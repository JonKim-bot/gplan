const axios = require("axios");
const API_ENDPOINT = "https://carlink.my/carlink_backend/API/";

const http = require("https");
const bodyParser = require("body-parser");
const express = require("express");
const { connect } = require("http2");

const port = 8000;

const router = express.Router();
const app = express();
const fs = require('fs');
app.use(express.json({
    limit: "200mb"
}));
app.use(express.urlencoded({
    extended: true,
    limit: "200mb"
}));

var privateKey = fs.readFileSync("/etc/apache2/ssl/carlink/server.key");
var certificate = fs.readFileSync("/etc/apache2/ssl/carlink/carlink_my.crt");
var ca = fs.readFileSync('/etc/apache2/ssl/carlink/carlink_my.ca-bundle');

const httpServer = require("https").createServer({
	key: privateKey,
	cert: certificate,
	ca: ca
},app);
const io = require("socket.io")(httpServer, {
    path: '/',
    cors: {
        origin: "*"
    }
});

httpServer.listen(5000, () => {
    console.log("WEBSOCKET");

});

var user_socket = [];
var rooms = [];

io.on('connection', (socket) => {
    console.log(socket.rooms);

    socket.emit("request_verification", { test: "saf" });
    socket.on("response_verification", (msg) => {
        console.log("RECEIVED RESPONSE_VERIFICATION ", msg);

        var room = check_or_create_room(msg.auction_id);
        socket.join(room.name);
    });

    
    socket.on("update_max_bid", (msg) => {
        console.log('max bid BID POST PARAM',msg);

        axios.post(API_ENDPOINT + "add_auto_bid", format_request({
            auction_id: msg.auction_id,
            users_id: msg.users_id,
            max_price: msg.max_price
        })).then(res => {

            console.log('res after add_auto_bid');
            if (res.data) {

                
                console.log('add_auto_bid max post param',(res.data));

                if(res.data.hasOwnProperty('status')){
                    console.log('BID ERROR max bid',res.data);
                    socket.emit("bid_error",(res.data.message));
                }else{
                    socket.emit("bid_success",'You have placed a bid');

                    console.log('max bid start');

                    axios.get(API_ENDPOINT + "run_auto_bid/" + msg.auction_id).then(res_auto_bid => {

                        console.log('run_auto_bid on add_auto_bid',(res_auto_bid.data));

                        // if (res_auto_bid.data) {
                            // console.log(res2.data);
        
                            axios.post(API_ENDPOINT + "get_bids", format_request({
                                    auction_id: msg.auction_id
                            })).then(res2 => {

                                console.log('get_bids add_auto_bid',(res2.data));
        
                                if (res2.data) {
                                    // console.log(res2.data);
                                    var room = check_or_create_room(msg.auction_id);
                                    console.log(room);
                                    io.to(room.name).emit("bid_update", res2.data);
                                    console.log('bid_update emit add_auto_bid');
                                }
                            }).catch(err=>{ console.log("ERROR get bid", err.messages)});

                            console.log('run_auto_bid res');
                        // }
                    }).catch(err=>{ 
                        console.log(API_ENDPOINT + "run_auto_bid/" + msg.auction_id);
                        console.log("ERROR run_auto_bid", err)});


                    axios.post(API_ENDPOINT + "get_auction_end_time", format_request({
                        auction_id: msg.auction_id
                    })).then(res2 => {
                        console.log('bid_time max bid',(res2.data));

                        if (res2.data) {
                            // console.log(res2.data);
                            var room = check_or_create_room(msg.auction_id);
                            console.log(room);
                            io.to(room.name).emit("bid_time", res2.data);
                            console.log('bid_time emit max bid');
                        }
                    }).catch(err=>{ console.log("ERROR bid_time max bid", err.messages)});
                }            
            } else {
                console.log(res);
            }

        }).catch(err=> {
         
            console.log("bid_error max bid " , err);
            socket.emit("bid_error",(err));
        });

    });

    socket.on("set_bid", (msg) => {
        console.log('BID POST PARAM',msg);

        axios.post(API_ENDPOINT + "add_bid", format_request({
            auction_id: msg.auction_id,
            users_id: msg.users_id,
            price: msg.price
        })).then(res => {

            if (res.data) {
                console.log('add_bid',(res.data));

                if(res.data.hasOwnProperty('status')){
                    console.log('BID ERROR',res.data);
                    socket.emit("bid_error",(res.data.message));
                }else{
                    socket.emit("bid_success",'You have placed a bid');

                    console.log('get_bids start');

                    axios.get(API_ENDPOINT + "run_auto_bid/" + msg.auction_id).then(res_auto_bid => {
                        console.log('run_auto_bid on add_bid',(res_auto_bid.data));

                        // if (res_auto_bid.data) {
                            // console.log(res2.data);
        
                            axios.post(API_ENDPOINT + "get_bids", format_request({
                                    auction_id: msg.auction_id
                            })).then(res2 => {
                                console.log('get_bids',(res2.data));
        
                                if (res2.data) {
                                    // console.log(res2.data);
                                    var room = check_or_create_room(msg.auction_id);
                                    console.log(room);
                                    io.to(room.name).emit("bid_update", res2.data);
                                    console.log('bid_update emit');
                                }
                            }).catch(err=>{ console.log("ERROR get bid", err.messages)});

                            console.log('run_auto_bid res');
                        // }
                    }).catch(err=>{ console.log("ERROR run_auto_bid", err)});



                    axios.post(API_ENDPOINT + "get_auction_end_time", format_request({
                        auction_id: msg.auction_id
                    })).then(res2 => {
                        console.log('bid_time',(res2.data));

                        if (res2.data) {
                            // console.log(res2.data);
                            var room = check_or_create_room(msg.auction_id);
                            console.log(room);
                            io.to(room.name).emit("bid_time", res2.data);
                            console.log('bid_time emit');
                        }
                    }).catch(err=>{ console.log("ERROR bid_time", err.messages)});



                    
                  


                }            
            } else {
                console.log(res);
            }

        }).catch(err=> {
         
            socket.emit("bid_error",(err));
        });

    });

    socket.on("disconnect", ()=>{
        console.log("disconnected");
    });

});

function check_or_create_room(auction_id) {
    var exist = false;
    for (var i = 0; i < rooms.length; i++) {
        if (rooms[i].name == "auction_" + auction_id) {
            return rooms[i];
        }
    }
    rooms.push({
        name: "auction_" + auction_id
    });
    return rooms[rooms.length - 1];
}

function format_request(postparam) {

    let body = "";
    for (let k in postparam) {
        body += encodeURI(k) + "=" + encodeURI(postparam[k]) + "&";
    }

    return body;
};

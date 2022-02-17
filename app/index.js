const axios = require("axios");
const API_ENDPOINT = "http://206.189.80.215/carlink_backend/API/";

const http = require("http");
const bodyParser = require("body-parser");
const express = require("express");
const { connect } = require("http2");

const port = 8000;

const router = express.Router();
const app = express();

app.use(express.json({
    limit: "200mb"
}));
app.use(express.urlencoded({
    extended: true,
    limit: "200mb"
}));


const httpServer = require("http").createServer(app);
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


    socket.on("set_bid", (msg) => {
        console.log(msg);

        axios.post(API_ENDPOINT + "add_bid", format_request({
            auction_id: msg.auction_id,
            users_id: msg.users_id,
            price: msg.price
        })).then(res => {
            if (res.data) {
                axios.post(API_ENDPOINT + "get_bids", format_request({
                    auction_id: msg.auction_id
                })).then(res2 => {
                    if (res2.data) {
                        // console.log(res2.data);
                        var room = check_or_create_room(msg.auction_id);
                        console.log(room);
                        io.to(room.name).emit("bid_update", res2.data);
                    }
                }).catch(err=>{ console.log("ERROR get bid", err.messages)});
            } else {
                console.log(res);
            }

        }).catch(err=> console.log("ERROR add bid", err.messages));

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
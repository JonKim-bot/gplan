<?php





namespace App\Controllers;

use App\Core\BaseController;

use App\Models\AuctionModel;
use App\Models\CarModel;
use App\Models\AuctionIncrementModel;
use App\Models\AuctionSectionModel;
use App\Models\AuctionStatusModel;

use App\Models\BidModel;

use App\Models\AuctionWishlistModel;

use App\Models\NotificationModel;
// app\ThirdParty\fpdf\fpdf.php
// require_once APPPATH .
//     'ThirdParty' .
//     DIRECTORY_SEPARATOR .

//     'fpdf' .
//     DIRECTORY_SEPARATOR .
//     'fpdf.php';

use FPDF;


class Auction extends BaseController
{
    public function __construct()
    {
        $this->AuctionStatusModel = new AuctionStatusModel();

        $this->CarModel = new CarModel();
        $this->AuctionIncrementModel = new AuctionIncrementModel();
        $this->AuctionWishlistModel = new AuctionWishlistModel();
        $this->NotificationModel = new NotificationModel();
        $this->BidModel = new BidModel();

        $this->AuctionSectionModel = new AuctionSectionModel();

        $this->AuctionModel = new AuctionModel();
        if (
            session()->get('login_data') == null &&

            uri_string() != 'access/login'
            
        ) {
            //  redirect()->to(base_url('access/login/'));
            echo "<script>location.href='" .
                base_url() .
                "/access/login';</script>";
        }
        $this->generate_auction_increment();
    }

    
    public function generate_auction_increment($auction_id = 0){
        if($auction_id > 0){


            $auction = $this->AuctionModel->getWhere(['auction.auction_id' => $auction_id]);
        }else{
            $auction = $this->AuctionModel->getAll();

        }
        $auction_increment = ['100','300','500'];
        foreach($auction as $key=> $row){
            foreach($auction_increment as $row_incre){

                $where = [
                    'auction_increment.auction_id' => $row['auction_id'],
                    'auction_increment.increment_price' => $row_incre
                ];
                $auction_incre = $this->AuctionIncrementModel->getWhere($where);
                if(empty($auction_incre)){
                    $data = [
                        'auction_id' => $row['auction_id'],
                        'auction_increment.increment_price' =>$row_incre
                    ];
                    $this->AuctionIncrementModel->insertNew($data);
                }
            }
        }
    }

    public function change_popular($auction_id)
    {
        $where = [
            'auction_id' => $auction_id,
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        $is_popular = 0;

        if ($auction['is_popular'] == 1) {
            $is_popular = 0;
        } else {
            $is_popular = 1;

        }
        $this->AuctionModel->updateWhere($where, ['is_popular' => $is_popular]);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function get_wishlist_user($auction_id)

    {
        $where = [
            'auction_wishlist.auction_id' => $auction_id,
        ];
        $auction_wishlist = $this->AuctionWishlistModel->getWhere($where);

        return $auction_wishlist;
    }

    
    public function index()
    {

        $auction_status_id =
        ($_GET and isset($_GET['auction_status_id']))
            ? $_GET['auction_status_id']

            : 0;
            

        $seller_status_id =
        ($_GET and isset($_GET['seller_status_id']))
            ? $_GET['seller_status_id']
            : 0;

        $where = [];

        if($auction_status_id > 0){
            $where ['auction.auction_status_id'] = $auction_status_id;
                //  => $auction_status_id,
        }


        if($seller_status_id > 0){
            $where ['auction.seller_status_id'] = $seller_status_id;
                //  => $auction_status_id,
        }
        if(!empty($where)){

            $auction = $this->AuctionModel->getWhere($where);
        }else{
            $auction = $this->AuctionModel->getAll();
        }

        $field = $this->AuctionModel->get_field(
            [

                'created_by',
                'seller_id',

                'modified_by',
                'collect_letter',

                'is_popular',

                'payment_method_id',
                'deleted',
                'car_id',
                'auction_id',
                'status',
                'success_user_id',
                'seller_status_id',
                'auction_status_id',
                'auction_section_id',
            ],
            $auction
        );
        $this->pageData['table'] = $this->generate_table(
            $field,
            $auction,
            'auction',
            'banner',
            1
        );
        foreach($auction as $key => $row){
            $time_now = date('Y-m-d H:i:s');
            $end_time = $row['date'] . ' ' . $row['end_time'];

            

            $time_diff = $this->date_getFullTimeDifference($time_now, $end_time);
            $auction[$key]['time_diff'] = $time_diff;
        }
        $this->pageData['auction'] = $auction;
        $this->pageData['auction_status'] = $this->AuctionStatusModel->getAll();
        echo view('admin/header', $this->pageData);
        echo view('admin/auction/all');
        echo view('admin/footer');
    }

    public function get_deposit_amount($car_price){
        $deposit = 500;

        if($car_price >= 9900){
            $deposit =  500;
        }
        if($car_price >= 10000 && $car_price <= 49999){
            $deposit =  1500;
        }

        if($car_price >= 50000 && $car_price <= 99999){
            $deposit =  2500;
        }
       

        if($car_price >= 100000){
            $deposit =  5000;
        }
        return $deposit;
        
    }
    public function Ended()

    {
        $auction = $this->AuctionModel->getEnded();

        // dd($auction);
        $field = $this->AuctionModel->get_field(
            [
                'created_by',

                'modified_by',
                'collect_letter',
                'is_popular',
                'payment_method_id',
                'seller_id',
                'deleted',
                'car_id',
                'auction_id',
                'status',
                'success_user_id',
                'seller_status_id',
                'auction_status_id',
                'auction_section_id',
            ],
            $auction
        );
        $this->pageData['table'] = $this->generate_table(
            $field,
            $auction,
            'auction',
            'banner',
            1
        );
        $this->pageData['auction'] = $auction;
        echo view('admin/header', $this->pageData);
        echo view('admin/auction/all');
        echo view('admin/footer');

    }

    public function send_notification_to_seller($auction_id){
        $where = [
            'auction.auction_id' => $auction_id
        ];

        $auction = $this->AuctionModel->getWhere($where);
        // dd($auction);
        if(!empty($auction)){
            $auction = $auction[0];
            
            $name = 'Your vehicle have been uploaded by Carlink';
            $description = '"Your vehicle is ready to bid. Seller may check vehicle
            status at My Cars For Bids."';

            $notification_type_id = 3;
            $data = [
                'auction_id' => $auction_id,
                'users_id' => $auction['seller_id'],
                'name' => $name,
                'description' => $description,
                'notification_type_id' => $notification_type_id,
            ];
            $this->NotificationModel->insertNew($data);

            
        }
    }
    public function add()
    {

        if ($_POST) {

            $error = false;
            if (!$error) {
                $data = $this->get_insert_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');
                $data['deposit_amount'] = $this->get_deposit_amount($_POST['starting_price']);
                $auction_id = $this->AuctionModel->insertNew($data);


                $this->sync_auction_section_data($_POST['auction_section_id'],$auction_id);


                $this->generate_auction_increment($auction_id);
                $this->send_notification_to_seller($auction_id);
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['form'] = $this->AuctionModel->generate_input();

        $this->pageData['car'] = $this->CarModel->getCarNotInAuction();
        $this->pageData['auction_section'] = $this->AuctionSectionModel->getWhere(

            [
                'DATE(date) >=' => date('Y-m-d'),
            ]


        );

        // $this->pageData['auction_section'] = $this->AuctionSectionModel->getAll();
        // dd($this->pageData['car']);
        // $this->pageData['final_form'] = $this->AuctionModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','created_date']);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/auction/add');
        echo view('admin/footer');
    }

    public function copy($auction_id)
    {
        $auction = $this->AuctionModel->copy($auction_id);
        return redirect()->to(base_url('Auction', 'refresh'));
    }

    public function detail($auction_id)

    {
        $where = [
            'auction.auction_id' => $auction_id,
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        // dd($auction);
        $this->generate_collection_letter($auction_id);




        $this->pageData['auction'] = $auction;

        $field = $this->AuctionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'car_id',
            'auction_id',
            'status',
            'success_user_id',
            'seller_status_id',
            'auction_status_id',
            'auction_section_id',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $auction,
            'banner'
        );
        $auction_increment = $this->AuctionIncrementModel->getWhere([
            'auction_increment.auction_id' => $auction_id,
        ]);
        // dd($auction_increment);
        $field = $this->AuctionIncrementModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'auction_id',
        ]);
        $this->pageData['table_increment'] = $this->generate_table(
            $field,
            $auction_increment,
            'auction_increment',
            'banner'
        );

        $form_arr = ['increment_price'];
        $modal_auction_increment = $this->get_modal(
            $this->AuctionIncrementModel->generate_input(),
            $form_arr,
            '/AuctionIncrement/add',
            'modal_auction',
            'auction_id',
            $auction_id
        );

        $this->pageData['modal_auction_increment'] = $modal_auction_increment;

        $this->pageData['form'] = $this->AuctionModel->generate_edit_input(
            $auction_id
        );

        $this->pageData['auction_wishlist'] = $this->get_wishlist_user(
            $auction_id
        );

        
        // dd($this->pageData['auction_wishlist']);
        $bid = $this->BidModel->getWhere(['bid.auction_id' => $auction_id]);
        $field = $this->BidModel->get_field(
            [
                'created_by',
                'modified_by',
                'auction_id',
                'deleted',
                'users_id',
            'modified_date',

                'remarks',
                'model',
                'plate_no',
                'model',
                'bid_id',

            ],
            $bid
        );
        $this->pageData['table_bid'] = $this->generate_table(
            $field,
            $bid,
            'bid',
            'banner'
            

        );

        
        $time_now = date('Y-m-d H:i:s');
        $end_time = $auction['date'] . ' ' . $auction['end_time'];

        $time_diff = $this->date_getFullTimeDifference($time_now, $end_time);
        // dd($time_diff);
        $this->pageData['time_diff'] = $time_diff;

        $this->pageData['modified_by'] = $this->get_modified_by($auction['modified_by']);
        // dd($this->pageData['modified_by']);
        echo view('admin/header', $this->pageData);
        echo view('admin/auction/detail');
        echo view('admin/footer');
    }

    public function delete_auction_section($auction_id)
    {
        $where = [
            'auction.auction_id' => $auction_id,
        ];

        $error = false;

        if (!$error) {
            $data = [
                'auction_section_id' => 0,
            ];

            $this->AuctionModel->updateWhere($where, $data);



            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }


    public function sync_auction_section_data($auction_section_id,$auction_id){
        $where = [
            'auction.auction_id' => $auction_id
        ];
        $auction_section = $this->AuctionSectionModel->getWhere([
            'auction_section_id' => $auction_section_id,

        ])[0];
        $data['date'] = $auction_section['date'];
        $data['start_time'] = $auction_section['start_time'];
        $data['end_time'] = $auction_section['end_time'];
        $this->AuctionModel->updateWhere($where, $data);
    }
    public function edit_auction_section()
    {
        $auction_id = $_POST['auction_id'];
        $where = [
            'auction.auction_id' => $auction_id,
        ];
        $this->pageData['auction'] = $this->AuctionModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {

                $data = $this->get_update_data($_POST);

                $this->sync_auction_section_data($_POST['auction_section_id'],$auction_id);
                // $auction_section = $this->AuctionSectionModel->getWhere([
                //     'auction_section_id' => $_POST['auction_section_id'],
                // ])[0];
                // $data['date'] = $auction_section['date'];
                // $data['start_time'] = $auction_section['start_time'];
                // $data['end_time'] = $auction_section['end_time'];
                $this->AuctionModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->AuctionModel->generate_edit_input($auction_id);
        $this->pageData[
            
            'final_form'
        ] = $this->AuctionModel->get_final_form_edit($auction_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/auction/edit');
        echo view('admin/footer');
    }

    public function send_notification_to_user($name,$description,$auction_id,$users_id , $notification_type_id = 1){
        $data = [
            'auction_id' => $auction_id,
            'users_id' => $users_id,
            'name' => $name,
            'description' => $description,
            'notification_type_id' => $notification_type_id,
        ];
        $this->NotificationModel->insertNew($data);

    }

    function date_getFullTimeDifference($start, $end)
    {
        $uts['start']      =    strtotime($start);
        $uts['end']        =    strtotime($end);
        // if ($uts['start'] !== -1 && $uts['end'] !== -1) {
            // if ($uts['end'] >= $uts['start']) {
                $diff    =    $uts['end'] - $uts['start'];
                if ($years = intval((floor($diff / 31104000))))
                    $diff = $diff % 31104000;
                if ($months = intval((floor($diff / 2592000))))
                    $diff = $diff % 2592000;
                if ($days = intval((floor($diff / 86400))))
                    $diff = $diff % 86400;
                if ($hours = intval((floor($diff / 3600))))
                    $diff = $diff % 3600;
                if ($minutes = intval((floor($diff / 60))))
                    $diff = $diff % 60;
                $diff    =    intval($diff);
                return (array('years' => $years, 'months' => $months, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $diff));
        //     } else {
        //         return false;
        //         // echo "Ending date/time is earlier than the start date/time";
        //     }
        // } else {
        //     echo "Invalid date/time data detected";
        // }
    }



    public function edit_status($auction_id)
    {
        $where = [
            'auction.auction_id' => $auction_id,
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        $this->pageData['auction'] = $auction;
        // dd($auction);
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST,['buyer_status']);
                $data = $this->upload_image_with_data($data, 'banner');
                $data = $this->upload_image_with_data($data, 'collect_letter');
                // $this->sync_auction_section_data($_POST['auction_section_id'],$auction_id);

                $this->AuctionModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

       
    }



    public function edit($auction_id)
    {
        $where = [
            'auction.auction_id' => $auction_id,
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        $this->pageData['auction'] = $auction;
        // dd($auction);
        if ($_POST) {
            $error = false;
            if(isset($_POST['buyer_status'])){
                
                $notification_type_id = 3;
                if(isset($_POST['status'])){
                    if($_POST['status'] == 1){
                        //submit document
                        $name = 'Carlink has processed your bidding.';
                        $description = "Please prepare the required documents to submit for Auction ID$auction_id. You may
                        update to our customer service when you have prepared the required documents.";
                        $this->send_notification_to_user($name,$description,$auction_id,$auction['success_user_id']);

                    }
                    if($_POST['status'] == 2){
                        //ready to collect
                        $name = 'Your vehicle is ready to collect.';

                        $description = "Auction ID$auction_id vehicle is ready to collect. Please click 
                        Successful Bids - Ready to collect and download your 
                        
                        vehicle collect letter.";
                        $this->send_notification_to_user($name,$description,$auction_id,$auction['success_user_id']);


                    }


                    if($_POST['status'] == 3){
                        //ready to collect
                        $name = 'Congraulations, you have successfully collected your car.';
                        $description = "Thanks for choosing Carlink for your vehicle needs.";
                        $this->send_notification_to_user($name,$description,$auction_id,$auction['success_user_id']);
                    }
                }

                if(isset($_POST['auction_status_id'])){
                    if($_POST['auction_status_id'] == 4){
                        $name = 'Congratulations, you have successfully collected your car.';
                        $description = "Thanks for choosing Carlink for your vehicle needs.";
                        $this->send_notification_to_user($name,$description,$auction_id,$auction['success_user_id']);
                        //send to user



                        $name = "Congratulations! You have successfully sold your car.";
                        $description = "Thanks for choosing Carlink for your vehicle needs.";
                        $this->send_notification_to_user($name,$description,$auction_id,$auction['seller_id'],3);
                    
                    }

                }


               
            }


            if (!$error) {
                $data = $this->get_update_data($_POST,['buyer_status']);
                $data = $this->upload_image_with_data($data, 'banner');
                $data = $this->upload_image_with_data($data, 'collect_letter');
                // $this->sync_auction_section_data($_POST['auction_section_id'],$auction_id);

                $this->AuctionModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['form'] = $this->AuctionModel->generate_edit_input(
            $auction_id
        );


        $this->pageData[
            'final_form'
        ] = $this->AuctionModel->get_final_form_edit($auction_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/auction/edit');
        echo view('admin/footer');
    }

    
    public function generate_collection_letter($auction_id)
    {

        $where = [
            'auction.auction_id' => $auction_id,
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        $this->pageData['auction'] = $auction;




        $pdf = new FPDF();
        $car = $this->CarModel->getWhere(['car.car_id' => $auction['car_id']])[0];
        $pdf->template_1($auction,$car);
        // $this->response->setHeader('Content-Type', 'application/pdf');
        $fileName = 'collection_letter_' . $auction_id . '.pdf';
        $pdf->Output('F', 'public/files/' . $fileName);
        $filePath = base_url() . '/public/files/' . $fileName;

        $where = [
            'auction.auction_id' => $auction_id
        ];
        $data = [
            'collect_letter' => $filePath
        ];
        $this->AuctionModel->updateWhere($where,$data);
        // dd($filePath);
        return $filePath;
        // $pdf->Output('F', 'public/files/' . $fileName);
        // $filePath = base_url() . '/public/files/' . $fileName;

        // $where = [
        //     'auction.auction_id' => $auction_id
        // ];
        // $data = [
        //     'collect_letter' => $filePath
        // ];
        // $this->AuctionModel->updateWhere($where,$data);
        // // dd($filePath);
        // return $filePath;

        // echo view('admin/header', $this->pageData);
        // echo view('admin/auction/collection_letter');

        // echo view('admin/footer');
    }

    public function delete($auction_id)
    {
        $this->AuctionModel->softDelete($auction_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

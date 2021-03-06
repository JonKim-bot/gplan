<?php








namespace App\Controllers;

use App\Core\BaseController;
use App\Models\UsersModel;
use App\Models\FamilyModel;
use App\Models\BannerModel;

use App\Models\WalletModel;
use App\Models\CompanyProfitModel;

class Users extends BaseController
{

    public function __construct()
    {
        $this->WalletModel = new WalletModel();
        $this->FamilyModel = new FamilyModel();
        $this->BannerModel = new BannerModel();

        $this->CompanyProfitModel = new CompanyProfitModel();


        $this->UsersModel = new UsersModel();
        $this->database = db_connect();

        if (
            session()->get('login_data') == null &&
            uri_string() != 'access/login'
        ) {
            //  redirect()->to(base_url('access/login/'));
            echo "<script>location.href='" .
                base_url() .
                "/access/login';</script>";
        }
    }


    public function downline($users_id)
    {

        
        if (session()->get('login_data')['type_id'] == '1') { 

            $users_id = session()->get('login_id');
        }

        $where = [
            'users.reference_id' => $users_id,
        ];
        //get user downline
        $is_verified =
        ($_GET and isset($_GET['is_verified']))
            ? $_GET['is_verified']
            : 99;

        $where['users.contact !='] = '';

        if($is_verified != 99){

            $where['users.is_verified'] = $is_verified;
        }        
        $users = $this->UsersModel->getWhere($where);
        $users_count = 0;
        if(!empty($users)){
            $users_count = count($users);


        }

        $this->pageData['users_count'] = $users_count;
        // dd($users);

        $field = $this->UsersModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $users,
            'users',
            'banner'
        );


        foreach($users as $key => $row){
            $family_name = '';
            // dd($key);
            $upline_name = '';

            if($row['family_id'] > 0){
                $where = [
                    'family.family_id' => $row['family_id']
                ];
                $family_user_id = $this->FamilyModel->getWhere($where)[0]['user_id'];
                $where = [

                    'users.users_id' => $family_user_id
                ];
                $family_name = $this->UsersModel->getWhere($where)[0];
                $family_name = $family_name['name'];


                $where = [
                    'family.user_id' => $row['users_id']
                ];
    
    
    
                $link_family = $this->FamilyModel->getWhere($where);
                if(!empty($link_family)){
                    $link_family_id = $link_family[0]['link_family_id'];
                    $upline_name = $this->UsersModel->getWhere(['users.users_id' => $link_family_id])[0]['name'];
                }

            }
            $users[$key]['upline_name'] = $upline_name;

            $users[$key]['family_name'] = $family_name;


        }
        $this->pageData['users_id'] = $users_id;


        $this->pageData['users'] = $users;
        echo view('admin/header', $this->pageData);
        echo view('admin/users/downline');
        echo view('admin/footer');
    }

    public function make_payment(){

        if (session()->get('login_data')['type_id'] == '1') { 
            $users_id = session()->get('login_id');

        }
        $downline_id = $_POST['downline_id'];
        //deduct 500 from users_id
        $balance = $this->WalletModel->get_balance($users_id);
        if($balance < 500){
            die(json_encode([

                'status' => false,


                'message' => 'Balance not enought'
            ]));
        }else{
            $user = $this->get_users_info($users_id);
            $downline = $this->get_users_info($downline_id);

            //made the payment already
            if($downline['is_paid'] == 1){
                die(json_encode([

                    'status' => false,
                    'message' => 'User already made the payment'
                ]));
            }

            $this->UsersModel->updateWhere(['users.users_id' => $downline_id],['is_paid' => 1]);
            $remarks = 'Deduct RM 500 From ' . $user['username'] . " , Made by verify account for downline " . $downline['username'];

            $this->WalletModel->wallet_out(
                $users_id,

                500,
                $remarks,
            );

            die(json_encode([
                'status' => true,
                'data' => $remarks
            ]));
        }
    }
    // public function generate_image

    
    public function verified_member()
    {
        
        $where = [

            'users.is_verified' => 1,
    
        ];
        $is_verified =
        ($_GET and isset($_GET['is_verified']))
            ? $_GET['is_verified']
            : 99;
        $dateFrom =


        ($_GET and isset($_GET['dateFrom']))
            ? $_GET['dateFrom']

            : date('Y-m-d');
        $dateTo =
            ($_GET and isset($_GET['dateTo']))
                ? $_GET['dateTo']
                : date('Y-m-d');

        $where['users.contact !='] = '';

        if($is_verified != 99){

            $where['users.is_verified'] = $is_verified;
        }        
    
             
        $where['DATE(users.created_date) >='] = $dateFrom;
        $where['DATE(users.created_date) <='] = $dateTo;

        $users = $this->UsersModel->getWhere($where);
        $users_count = 0;
        if(!empty($users)){
            $users_count = count($users);
        }

        $this->pageData['users_count'] = $users_count;
        // dd($users);

        $field = $this->UsersModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $users,
            'users',
            'banner'
        );


        foreach($users as $key => $row){
            
            $family_name = '';
            // dd($key);
            $upline_name = '';

            if($row['self_family_id'] > 0){
                $where = [

                    'family.family_id' => $row['self_family_id']
                ];
                $user_in_family = $this->FamilyModel->getWhere($where);
    
                if(!empty($user_in_family)){
                    $link_family_id = $user_in_family[0]['link_family_id'];
                    $family_name = $this->FamilyModel->get_upline_infomation($link_family_id)['username'];
                }
            }
            $upline_name = $this->UsersModel->getWhere(['users.users_id' => $row['reference_id']]);
            if(!empty($upline_name)){
                $upline_name = $upline_name[0]['name'];
            }else{
                $upline_name = '';
            }

            $users[$key]['upline_name'] = $upline_name;

            $users[$key]['family_name'] = $family_name;

        }
        $where = [
            'DATE(wallet.created_date) >=' => $dateFrom,
            'DATE(wallet.created_date) <=' => $dateTo,
            'wallet.wallet_in <=' => 31,  
        ];

        
        $total = $users_count * 500;

        $this->pageData['total'] = $total;

        $this->pageData['users_count'] = $users_count;

        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);
        $users_wallet = array_sum(array_column($users_wallet,'transaction'));
        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;
        $this->pageData['users_wallet'] = $users_wallet;

        $this->pageData['users'] = $users;
        echo view('admin/header', $this->pageData);
        echo view('admin/users/all');
        echo view('admin/footer');
    }

    public function unpaid_user()
    {
        
        $where = [

            'users.is_paid' => 0,
        ];
        $is_verified =
        ($_GET and isset($_GET['is_verified']))
            ? $_GET['is_verified']
            : 99;

        $dateFrom =


        ($_GET and isset($_GET['dateFrom']))
            ? $_GET['dateFrom']

            : date('Y-m-d');
        $dateTo =
            ($_GET and isset($_GET['dateTo']))
                ? $_GET['dateTo']
                : date('Y-m-d');

        $where['users.contact !='] = '';
        $where['DATE(users.created_date) >='] = $dateFrom;
        $where['DATE(users.created_date) <='] = $dateTo;
    

        if($is_verified != 99){

            $where['users.is_verified'] = $is_verified;
        }        
        $users = $this->UsersModel->getWhere($where);
        $users_count = 0;
        if(!empty($users)){
            $users_count = count($users);
        }

        $this->pageData['users_count'] = $users_count;
        // dd($users);

        $field = $this->UsersModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $users,
            'users',
            'banner'
        );


        foreach($users as $key => $row){
            $family_name = '';
            // dd($key);
            $upline_name = '';

            if($row['self_family_id'] > 0){
                $where = [

                    'family.family_id' => $row['self_family_id']
                ];
                $user_in_family = $this->FamilyModel->getWhere($where);
    
                if(!empty($user_in_family)){
                    $link_family_id = $user_in_family[0]['link_family_id'];
                    $family_name = $this->FamilyModel->get_upline_infomation($link_family_id)['username'];
                }
            }
            $upline_name = $this->UsersModel->getWhere(['users.users_id' => $row['reference_id']]);
            if(!empty($upline_name)){
                $upline_name = $upline_name[0]['name'];
            }else{
                $upline_name = '';
            }

            $users[$key]['upline_name'] = $upline_name;

            $users[$key]['family_name'] = $family_name;

        }

        $where = [
            'DATE(wallet.created_date) >=' => $dateFrom,
            'DATE(wallet.created_date) <=' => $dateTo,
            'wallet.wallet_in <=' => 31,  
        ];

        $total = $users_count * 500;

        $this->pageData['total'] = $total;

        $this->pageData['users_count'] = $users_count;
        
        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);
        $users_wallet = array_sum(array_column($users_wallet,'transaction'));
        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;
        $this->pageData['users_wallet'] = $users_wallet;



        $this->pageData['users'] = $users;
        echo view('admin/header', $this->pageData);
        echo view('admin/users/all');
        echo view('admin/footer');
    }


    public function paid_user()
    {
        
        $where = [

            'users.is_paid' => 1,
        ];
        $is_verified =
        ($_GET and isset($_GET['is_verified']))
            ? $_GET['is_verified']
            : 99;

        $dateFrom =


        ($_GET and isset($_GET['dateFrom']))
            ? $_GET['dateFrom']

            : date('Y-m-d');
        $dateTo =
            ($_GET and isset($_GET['dateTo']))
                ? $_GET['dateTo']
                : date('Y-m-d');
        $where['users.contact !='] = '';

        if($is_verified != 99){

            $where['users.is_verified'] = $is_verified;
        }        

     
        $where['DATE(users.created_date) >='] = $dateFrom;
        $where['DATE(users.created_date) <='] = $dateTo;
    

        $users = $this->UsersModel->getWhere($where);
        $users_count = 0;
        if(!empty($users)){
            $users_count = count($users);
        }

        $this->pageData['users_count'] = $users_count;
        // dd($users);

        $field = $this->UsersModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $users,
            'users',
            'banner'
        );


        foreach($users as $key => $row){
            $family_name = '';
            // dd($key);
            $upline_name = '';

            if($row['self_family_id'] > 0){
                $where = [

                    'family.family_id' => $row['self_family_id']
                ];
                $user_in_family = $this->FamilyModel->getWhere($where);
    
                if(!empty($user_in_family)){
                    $link_family_id = $user_in_family[0]['link_family_id'];
                    $family_name = $this->FamilyModel->get_upline_infomation($link_family_id)['username'];
                }

            }
            $upline_name = $this->UsersModel->getWhere(['users.users_id' => $row['reference_id']]);
            if(!empty($upline_name)){
                $upline_name = $upline_name[0]['name'];
            }else{
                $upline_name = '';
            }

            $users[$key]['upline_name'] = $upline_name;

            $users[$key]['family_name'] = $family_name;

        }

               $where = [
            'DATE(wallet.created_date) >=' => $dateFrom,
            'DATE(wallet.created_date) <=' => $dateTo,
            'wallet.wallet_in <=' => 31,  
        ];
          
        $total = $users_count * 500;

        $this->pageData['total'] = $total;

        $this->pageData['users_count'] = $users_count;
        
        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);
        $users_wallet = array_sum(array_column($users_wallet,'transaction'));
        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;
        $this->pageData['users_wallet'] = $users_wallet;


        $this->pageData['users'] = $users;
        echo view('admin/header', $this->pageData);
        echo view('admin/users/all');
        echo view('admin/footer');
    }

    // public function verify_all_user(){



    //     $where = [

    //         'users.is_verified' => 0
    //     ];
    //     $users = $this->UsersModel->getWhereRaw($where);
    //     // dd($users);
    //     foreach($users as $row){
    //         $this->verify_user_func($row['users_id']);
    //     }

    // }

    public function index()
    {

        $where['users.is_verified'] = 0;

        $is_verified =
        ($_GET and isset($_GET['is_verified']))
            ? $_GET['is_verified']
            : 99;

        $dateFrom =
    

        ($_GET and isset($_GET['dateFrom']))
            ? $_GET['dateFrom']

            : date('Y-m-d');
        $dateTo =
            ($_GET and isset($_GET['dateTo']))
                ? $_GET['dateTo']
                : date('Y-m-d');

        $where['users.contact !='] = '';

        if($is_verified != 99){

            $where['users.is_verified'] = $is_verified;
        }        
     
        $where['DATE(users.created_date) >='] = $dateFrom;
        $where['DATE(users.created_date) <='] = $dateTo;

        // dd($where);
        $users = $this->UsersModel->getWhere($where);
        $users_count = 0;
        if(!empty($users)){
            $users_count = count($users);
        }

        $total = $users_count * 500;

        $this->pageData['total'] = $total;

        $this->pageData['users_count'] = $users_count;
        // dd($users);

        // dd($users_wallet);
        $field = $this->UsersModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        
        $where = [
            'DATE(wallet.created_date) >=' => $dateFrom,
            'DATE(wallet.created_date) <=' => $dateTo,
            'wallet.wallet_in <=' => 31,  
        ];

        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);
        $users_wallet = array_sum(array_column($users_wallet,'transaction'));
        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;
        $this->pageData['users_wallet'] = $users_wallet;


        $this->pageData['table'] = $this->generate_table(
            $field,
            $users,
            'users',
            'banner'
        );


        foreach($users as $key => $row){

            $family_name = '';
            // dd($key);
            $upline_name = '';

            if($row['self_family_id'] > 0){
                $where = [

                    'family.family_id' => $row['self_family_id']
                ];

                $user_in_family = $this->FamilyModel->getWhere($where);
    
                if(!empty($user_in_family)){
                    $link_family_id = $user_in_family[0]['link_family_id'];

                    $family_name = $this->FamilyModel->get_upline_infomation($link_family_id)['username'];
                }
            }
            $upline_name = $this->UsersModel->getWhere(['users.users_id' => $row['reference_id']]);
            if(!empty($upline_name)){
                $upline_name = $upline_name[0]['name'];
            }else{
                $upline_name = '';
            }
    
            $users[$key]['upline_name'] = $upline_name;

            $users[$key]['family_name'] = $family_name;


        }
        $this->pageData['users'] = $users;

        echo view('admin/header', $this->pageData);
        echo view('admin/users/all');

        echo view('admin/footer');
    }


    public function in_com($family_id){
        $this->FamilyModel->insert_extra_commission($family_id);
    }
    public function user_with_no_downline()

    {

        

        $users = $this->UsersModel->get_user_with_no_downline();
        $this->pageData['users'] = $users;
        echo view('admin/header', $this->pageData);
        echo view('admin/users/users_with_no_downline');
        echo view('admin/footer');

    }


    public function find_user_id_by_family_id($family_id){
        $where = [
            'family.family_id' => $family_id
        ];
        $family = $this->FamilyModel->getWhere($where)[0];
        return $family['user_id'];
        

    }

    public function submit_receipt()
    
    {

        if (session()->get('login_data')['type_id'] == '1') { 
            $users_id = session()->get('login_id');

        }
        $where = [
            'users.users_id' => $users_id
        ];


        $error = false;


        if ($_FILES) {
            $input = $_POST;

            // $input['family_id'] = $this->FamilyModel->find_empty_slot($input['family_id']);

            if (!$error) {
                $data = [
                    'is_paid' => 1,
                    'paid_date' => date('Y-m-d H:i:s')
                ];


                $data = $this->upload_image_with_data($data, 'receipt');
                $users_id = $this->UsersModel->updateWhere($where,$data);
                alert('Receipt submitted');
                locationhref($_SERVER['HTTP_REFERER']);
                
                // return redirect()->to(base_url('users/detail/' . $users_id, 'refresh'));
                // return redirect()->to($_SERVER['HTTP_REFERER']);
            } else {
                $this->page_data['error'] = 'Failed to add user data';
            }
        }

        

    }

    public function add()
    
    {
        if ($_POST) {
            $input = $_POST;
            $error = false;

            if ($input['password'] != $input['password2']) {
                $error = true;
                $this->pageData['error'] = 'Passwords do not match';
                $this->pageData['input'] = $input;
            }



            $existed = $this->checkExists($input['username']);

            if($existed){
                $error = true;
                $this->pageData['error'] = 'Username already existed';
                $this->pageData['input'] = $input;

            }


            // $input['family_id'] = $this->FamilyModel->find_empty_slot($input['family_id']);

            if (!$error) {
                $hash = $this->hash($input['password']);
                $input['contact'] = $this->format_contact($input['contact']);
                $reference_id = 0;
                if($input['family_id'] != 0){
                    $reference_id =  $this->find_user_id_by_family_id($input['family_id']);
                }
                $data = [
                    'name' => $input['name'],
                    'email' => $input['email'],

                    'username' => $input['username'],
                    'contact' => $input['contact'],
                    'password' => $hash['password'],
                    // 'nric_name' => $input['nric_name'],
                    'reference_id' => $reference_id,
                    // 'nric' => $input['nric'],
                    'family_id' => $input['family_id'],

                    // 'ssm_name' => $input['ssm_name'],
                    // 'ssm_number' => $input['ssm_number'],
                    'salt' => $hash['salt'],
                    // 'created_by'    => $this->session->userdata('login_id')
                ];
                $data = $this->upload_image_with_data($data, 'receipt');
                $data = $this->upload_image_with_data($data, 'nric_back');

              
                $users_id = $this->UsersModel->insertNew($data);

                

                // $this->FamilyModel->insert_new_member($users_id,$_POST['family_id']);
                
                return redirect()->to(base_url('users/detail/' . $users_id, 'refresh'));

                // return redirect()->to($_SERVER['HTTP_REFERER']);
            } else {
                $this->page_data['error'] = 'Failed to add user data';
            }
        }

        $this->pageData['users'] = $this->FamilyModel->getAll();



        echo view('admin/header', $this->pageData);
        echo view('admin/users/add');
        echo view('admin/footer');
    }

    //     if ($_POST) {

    //         $error = false;

    //         if (!$error) {
    //             $data = $this->get_insert_data($_POST);

    //             $data = $this->upload_image_with_data($data,'banner');
    //             // dd($data);
    //             $this->UsersModel->insertNew($data);

    //             return redirect()->to($_SERVER['HTTP_REFERER']);

    //         }
    //     }

    //     $this->pageData['final_form'] = $this->UsersModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','created_date']);
    //     // die(var_dump($this->pageData['form']));
    //     echo view('admin/header', $this->pageData);
    //     echo view('admin/users/add');
    //     echo view('admin/footer');
    // }

    
    // public function copy($users_id){

    //     $users = $this->UsersModel->copy($users_id);
    //     return redirect()->to(base_url('Users', 'refresh'));
    // }
    public function test_find($family_id){
        $family_id = $this->FamilyModel->find_empty_slot($family_id);
        dd($family_id);
    }

    public function set_paid($users_id){

        $where = [
            'users.users_id' => $users_id
        ];
        $users = $this->UsersModel->getWhere($where)[0];


        if($users['is_paid'] == 1){
            $is_paid = 0;
        }else{
            $is_paid = 1;
        }
        $this->UsersModel->updateWhere($where,['is_paid' => $is_paid ,'paid_date' => date('Y-m-d H:i:s')]);


        if(isset($_SERVER['HTTP_REFERER'])){
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }else{
             return redirect()->to(base_url('users'));
        }

    }

    
    public function verify_user_func($users_id){

        $where = [
            'users.users_id' => $users_id
        ];

        $users = $this->UsersModel->getWhere($where)[0];




        if($users['is_verified'] == 0){
            $is_verified = 1;
            $remarks = "Profit 500 from users " . $users['name'] . ' joining' ;
            $this->CompanyProfitModel->company_profit_in($users_id,500,$remarks);
            // dd($users['family_id']);

            $family_id = $this->FamilyModel->insert_new_member($users_id,$users['family_id']);
            $this->UsersModel->updateWhere(['users.users_id' => $users_id],['self_family_id' => $family_id]);
            $this->UsersModel->updateWhere($where,['is_verified' => $is_verified]);
        }


    }



    public function verify_user($users_id){

        $where = [
            'users.users_id' => $users_id
        ];
        $users = $this->UsersModel->getWhere($where)[0];



        if($users['is_verified'] == 0){
            $is_verified = 1;

            $remarks = "Profit 500 from users " . $users['name'] . ' joining' ;
            $this->CompanyProfitModel->company_profit_in($users_id,500,$remarks);
            // dd($users['family_id']);
            // $slot_family = $this->FamilyModel->find_empty_slot($users['family_id']);
            $family_id = $this->FamilyModel->insert_new_member($users_id,$users['family_id']);
            $this->UsersModel->updateWhere(['users.users_id' => $users_id],['self_family_id' => $family_id]);
            $this->UsersModel->updateWhere($where,['is_verified' => $is_verified]);
        }





        return redirect()->to(base_url('users/detail/' . $users_id, 'refresh'));

        // return redirect()->to(base_url() . '/users/detail/' . $users_id , 'refreash');

    }

    

    public function qrcode($users_id)
    {

        if (session()->get('login_data')['type_id'] == '1') { 
            $users_id = session()->get('login_id');
        }
        // dd($users_id);
        $where = [
            'users.users_id' => $users_id,
        ];

        $users = $this->UsersModel->getWhere($where)[0];

        $this->pageData['users'] = $users;
        $this->pageData['modified_by'] = $this->get_modified_by($users['modified_by']);
        $field = $this->UsersModel->get_field([
            
            'created_by',

            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $users,
            'banner'
        );

        $users_wallet = $this->WalletModel->get_transaction_by_users([
            'users.users_id' => $users_id,
        ]);

        $this->pageData['wallet'] = $users_wallet;
        $this->pageData['balance'] = $this->WalletModel->get_balance($users_id);



        echo view('admin/header', $this->pageData);
        echo view('admin/users/qrcode');
        echo view('admin/footer');
    }


    public function user_detail($users_id)

    {
        if (session()->get('login_data')['type_id'] == '1') { 

            $users_id = session()->get('login_id');
        }
        // dd($users_id);
        
        $where = [
            'users.users_id' => $users_id,
        ];

        $users = $this->UsersModel->getWhere($where)[0];

        $this->pageData['users'] = $users;


        echo view('admin/header', $this->pageData);
        echo view('admin/users/user_detail');
        echo view('admin/footer');
    }


    
    public function dashboard($users_id)

    {


        if (session()->get('login_data')['type_id'] == '1') { 

            $users_id = session()->get('login_id');
        }
        // dd($users_id);
        $where = [
            'users.users_id' => $users_id,
        ];

        $users = $this->UsersModel->getWhere($where)[0];

        // foreach($users as $key => $row){
        $family_name = '';


        $upline_name = '';
        if($users['self_family_id'] > 0){
            $where = [
                'family.family_id' => $users['self_family_id']
            ];
            $user_in_family = $this->FamilyModel->getWhere($where);

            if(!empty($user_in_family)){
                $link_family_id = $user_in_family[0]['link_family_id'];




                $family_name = $this->FamilyModel->get_upline_infomation($link_family_id)['username'];
            }
           
        }
        $upline_name = $this->UsersModel->getWhere(['users.users_id' => $users['reference_id']]);
        if(!empty($upline_name)){
            $upline_name = $upline_name[0]['name'];
        }else{
            $upline_name = '';
        }
        $users['family_name'] = $family_name;
        $users['upline_name'] = $upline_name;

        $family_id = 0;
        

        $family = $this->FamilyModel->getWhereRaw(['family.user_id' => $users_id]);
     
        if(!empty($family)){
            $family_id = $family[0]['family_id'];
        }

        $this->pageData['family_id'] = $family_id ;

        $level = $this->FamilyModel->user_family($family_id);

        if($family_id == 0){
            $level = 1;
        }
        $users['level']  = $level;

        $this->pageData['users'] = $users;
        $this->pageData['modified_by'] = $this->get_modified_by($users['modified_by']);
        $field = $this->UsersModel->get_field([
            'created_by',


            'modified_by',
            'deleted',

        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $users,
            'banner'
        );
        $users_wallet = $this->WalletModel->get_transaction_by_users([
            'users.users_id' => $users_id,
        ] , 10);

        $this->pageData['wallet'] = $users_wallet;
        $this->pageData['users_id'] = $users_id;

        $this->pageData['balance'] = $this->WalletModel->get_balance($users_id);
        $this->pageData['banner'] = $this->BannerModel->getWhere(['type_id' => 0]);

        $qrcode = $this->BannerModel->getWhere(['type_id' => 1]);
        if(!empty($qrcode)){
            $qrcode = $qrcode[0]['banner'];
        }else{
            $qrcode = 0;
        }
        $this->pageData['qrcode'] = $qrcode;
        $this->pageData['total_earn'] = $this->WalletModel->get_total_earn($users_id);
        $this->pageData['total_withdraw'] = $this->WalletModel->get_total_withdraw($users_id);

        
        echo view('admin/header', $this->pageData);

        echo view('admin/users/dashboard');
        
        echo view('admin/footer');
    }



    public function my_group($users_id  = 1){
        // $this->FamilyModel->insert_extra_commission(30);
        if (session()->get('login_data')['type_id'] == '1') { 

            $users_id = session()->get('login_id');
        }


        $users_downline = $this->UsersModel->get_downline($users_id);
        // dd($users_downline);


        $this->pageData['users_downline'] = $users_downline;
        echo view('admin/header', $this->pageData);


        echo view('admin/users/my_group');

        echo view('admin/footer');
    }


    public function detail($users_id)

    {

        if (session()->get('login_data')['type_id'] == '1') { 
            
            $users_id = session()->get('login_id');
        }
        // dd($users_id);

     

        $where = [
            'users.users_id' => $users_id,
        ];

        $users = $this->UsersModel->getWhere($where)[0];


        // foreach($users as $key => $row){
        $family_name = '';

        $upline_name = '';

        $total_commision = 0;
        $extra_commission = 0;
        $commission_normal = 0;

        if($users['self_family_id'] > 0){
            $where = [
                'family.family_id' => $users['self_family_id']
            ];
            $user_in_family = $this->FamilyModel->getWhere($where);


            if(!empty($user_in_family)){
                $commission_normal = $user_in_family[0]['commission_normal'];
                $extra_commission = $user_in_family[0]['extra_commission'];
                $total_commision = $user_in_family[0]['total_commision'];

                $link_family_id = $user_in_family[0]['link_family_id'];
                
                $family_name = $this->FamilyModel->get_upline_infomation($link_family_id)['username'];
          
            }
        }
        $upline_name = $this->UsersModel->getWhere(['users.users_id' => $users['reference_id']]);
        if(!empty($upline_name)){
            $upline_name = $upline_name[0]['name'];
        }else{
            $upline_name = '';
        }

        $users['family_name'] = $family_name;
        $users['upline_name'] = $upline_name;

        $users['extra_commission'] = $extra_commission;
        $users['commission_normal'] = $commission_normal;
        $users['total_commision'] = $total_commision;

        // }
        $this->pageData['users'] = $users;



        $this->pageData['modified_by'] = $this->get_modified_by($users['modified_by']);
        $field = $this->UsersModel->get_field([
            'created_by',

            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $users,
            'banner'
        );
        $users_wallet = $this->WalletModel->get_transaction_by_users([
            'users.users_id' => $users_id,
        ]);


        $this->pageData['wallet'] = $users_wallet;
        $this->pageData['balance'] = $this->WalletModel->get_balance($users_id);
        $family_id = 0;
        


        $family = $this->FamilyModel->getWhereRaw(['family.user_id' => $users_id]);
        if(!empty($family)){
            $family_id = $family[0]['family_id'];
        }
        $this->pageData['family_id'] = $family_id ;

        echo view('admin/header', $this->pageData);
        echo view('admin/users/detail');
        echo view('admin/footer');
    }


    
    public function add_remarks($users_id)
    {
        $where = [
            'users.users_id' => $users_id,
        ];

        if ($_POST) {
            $error = false;
            $input = $_POST;
       
            if (!$error) {

                $data = [
                    'remarks' => $input['remarks'],
                ];
                $this->UsersModel->updateWhere($where, $data);
                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }


    }


    
    public function edit_type($users_id)
    {
        $where = [
            'users.users_id' => $users_id,
        ];
        $this->pageData['users'] = $this->UsersModel->getWhere($where)[0];
        $where_2 = [
            'users.users_id' => $this->pageData['users']['reference_id']
        ];
        $user_direct = $this->UsersModel->getWhere($where_2);
        // dd($this->pageData['users']);
        if ($_POST) {

            $error = false;
            $input = $_POST;
       
            if (!$error) {

                if(!empty($user_direct)){
                    $user_direct = $user_direct[0];
                    if($input['type_id'] > $user_direct['type_id']){
                        alert('User level cannot bigger than the teacher level');
                        locationhref($_SERVER['HTTP_REFERER']);

                    }else{
                        $data = [
                            'type_id' => $input['type_id'],
                        ];
                        $this->UsersModel->updateWhere($where, $data);
        
                        locationhref($_SERVER['HTTP_REFERER']);
                    }
                }else{
                    $data = [
                        'type_id' => $input['type_id'],
                    ];
                    $this->UsersModel->updateWhere($where, $data);
    
                    locationhref($_SERVER['HTTP_REFERER']);
                }


                // return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

    }

    
    public function edit($users_id)
    {
        $where = [
            'users.users_id' => $users_id,
        ];
        $this->pageData['users'] = $this->UsersModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;
            $input = $_POST;
            if (!empty($input['password'])) {
                if ($input['password'] != $input['password2']) {
                    $error = true;
                    $this->pageData['error'] = 'Passwords do not match';
                    $this->pageData['input'] = $input;
                }
            }



       
            if (!$error) {
                $input['contact'] = $this->format_contact($input['contact']);

                $data = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['username'],
                    'contact' => $input['contact'],
                    'delivery_address' => $input['delivery_address'],

                    // 'nric_name' => $input['nric_name'],
                    // 'nric' => $input['nric'],
                ];
                $data = $this->upload_image_with_data($data, 'receipt');
                $data = $this->upload_image_with_data($data, 'nric_back');

                // $data = $this->upload_image_with_data($data, 'ssm_cert');
                if(!empty($input['password'])){


                    if ($input['password'] != '') {
                        $hash = $this->hash($input['password']);
                        $data['password'] = $hash['password'];
    
                        $data['salt'] = $hash['salt'];
                    }
                }
                $this->UsersModel->updateWhere($where, $data);


                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }



        // $this->pageData['form'] = $this->UsersModel->generate_edit_input($users_id);
        $this->pageData[
            'final_form'
        ] = $this->UsersModel->get_final_form_edit($users_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);



        echo view('admin/header', $this->pageData);
        echo view('admin/users/edit');
        echo view('admin/footer');
    }

    public function delete($users_id)
    {
        $this->UsersModel->softDelete($users_id);

        $where = [
            'family.user_id' => $users_id
        ];
        $family_id = $this->FamilyModel->getWhereRaw($where);
        if(!empty($family_id)){
            $family_id = $family_id[0]['family_id'];
            $this->FamilyModel->hardDelete($family_id);
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);

    }

    function return_level_max($level){
        if($level == 1){
            return 2;
        }
        if($level == 2){
            return 4;
        }
        if($level == 3){
            return 8;
        }

        if($level == 4){
            return 16;
        }

        if($level == 5){
            return 32;
        }

        if($level == 6){
            return 64;
        }
        if($level == 7){
            return 128;
        }
        if($level == 8){
            return 256;
        }
        if($level == 9){
            return 512;
        }
        if($level == 10){
            return 1028;
        }
        if($level == 11){
            return 2048;
        }
        if($level == 12){
            return 4096;
        }
        if($level == 13){
            return 8192;
        }
        if($level == 14){
            return 16384;
        }
        if($level == 15){
            return 32768;
        }

    }
    function check_if_reached_level($level,$family){
        $family_level = isset($family[$level ]) ? count($family[$level]) : -1;
        $level_max = $this->return_level_max($level);
        

        if($family_level >= $level_max){

            return 'Success';
            //reached
        }else{
            return 'Not success';
        }

    }

    function reset_user($user_id){
        $where = [

            'users.users_id' => $user_id
        ];

        $data = [
            'is_verified' => 0,

        ];

        $this->UsersModel->updateWhere($where,$data);

        $where = [
            'family.user_id' => $user_id
        ];
        $this->FamilyModel->hardDeleteWhere($where);
    }

    function family_tree($user_id = 1)
    {
        $user_id = 42;

        if (session()->get('login_data')['type_id'] == '1') { 

            $user_id = session()->get('login_id');
        }


        $where = [

            'family.user_id' => $user_id
        ];
        $user = $this->get_users_info($user_id);
        $family_id = $this->FamilyModel->getWhereRaw($where)[0]['family_id'];
        $level = $this->FamilyModel->user_family($family_id);
        $family_tree = $this->FamilyModel->user_family_tree($family_id);
        $level_arr = [];

        for ($x = 1; $x <= $level ; $x++) {


            if($x <= $user['type_id'] + 7){
                $family_level = $this->check_if_reached_level($x,$family_tree);
               
                $data = [
                    'level' => $x,
                    'status' => $family_level
                ];
                array_push($level_arr,$data);
            }
        }
        $this->pageData['level_arr'] = $level_arr;

        $this->pageData['family_tree'] = $family_tree;
        $this->pageData['level'] = $level;


        echo view('admin/header', $this->pageData);
        echo view('admin/users/family_tree');
        // echo view('admin/footer');
        

    }

    public function get_total_com($level_user,$level_upline){

        $total_com = $this->FamilyModel->get_total_com($level_user,$level_upline);
        
    }

    


    function direct_tree($user_id = 1)
    {

        if (session()->get('login_data')['type_id'] == '1') { 

            $user_id = session()->get('login_id');
        }



        $user_detail = $this->UsersModel->getWhere(['users.users_id' => $user_id]);
        $users_1 = $this->UsersModel->getWhere(['users.users_id' => $user_id]);

        $user = $this->UsersModel->getTree($user_id);

        // $users = $this->UsersModel->getTree($user_id);

        $users = array_merge($users_1,$user);

        $tree =  $this->buildTreeDirect($users,$user_id);
        
        $users_1[0]['children'] = $tree;
        
        $tree = $users_1;
        


        $ulli = $this->createListLi($tree);
        
        $this->pageData["ulli"] = $ulli;
        $this->pageData["user_detail"] = $user_detail[0];


        echo view('admin/header', $this->pageData);
        echo view('admin/users/ul_of_tree');
        // echo view('admin/footer');

        
    }

    function get_user_level(){
        
        $user_id = 42;

        if (session()->get('login_data')['type_id'] == '1') { 

            $user_id = session()->get('login_id');
        }
        
        $where = [
            'family.user_id' => $user_id
        ];
        $level = $_POST['level'];
        $family_id = $this->FamilyModel->getWhereRaw($where)[0]['family_id'];
        $family_tree = $this->FamilyModel->user_family_tree($family_id);
        $family_level_user = [];


        if(isset($family_tree[$level])){

            $familys_id = implode(",", $family_tree[$level]);
            if($familys_id != ''){
                $sql = "SELECT family.*,family.family_id as fid,users.username,
                (SELECT COUNT(*) FROM family WHERE link_family_id = fid) as total_downline
                FROM family 
                INNER JOIN users ON users.users_id = family.user_id
                WHERE family.family_id IN ($familys_id)";
                $family_level_user = $this->database->query($sql)->getResultArray();

            }


        }

        $this->pageData['family_level_user'] = $family_level_user;
        echo view('admin/users/users_list', $this->pageData);

    }

    public function process_user(){
        $where = [
            'users.is_verified' => 0
        ];
        $users = $this->UsersModel->getWhere($where);
        foreach($users as $row){
            echo "row" . $row['users_id'];
            $this->verify_user($row['users_id']);
        }
        die('end');
    }


    function tree($user_id = 1)
    {

        if (session()->get('login_data')['type_id'] == '1') { 

            $user_id = session()->get('login_id');
        }

        $users = $this->UsersModel->getWhere(['users.users_id' => $user_id]);
        $where = [
            'family.family_id' => $users[0]['self_family_id']

        ];
        $user_in_family = $this->FamilyModel->getWhere($where);


        $user_upline = [];
        if(!empty($user_in_family)){
            $link_family_id = $user_in_family[0]['link_family_id'];
            $user_upline = $this->FamilyModel->get_upline_infomation_tree($link_family_id);

            if(!empty($user_upline)){
                $user_upline['total_downline'] = $this->FamilyModel->get_total_downline($user_upline['self_family_id']);

                $user_upline['balance'] = $this->WalletModel->get_balance($user_upline['users_id']);
            }
        }


        // dd($user_upline);
        for($i = 0; $i < count($users); $i++){
            $users[$i]['family'] = $this->FamilyModel->getTree($users[$i]['users_id']);
            $users[$i]['total_downline'] = $this->FamilyModel->get_total_downline($users[$i]['self_family_id']);
            $users[$i]['balance'] = $this->WalletModel->get_balance($users[$i]['users_id']);


        }
        $this->pageData['user_upline'] = $user_upline;

        $this->pageData['users'] = $users;
        // dd($users);

        echo view('admin/header', $this->pageData);
        echo view('admin/users/tree', $this->pageData);
        // echo view('admin/footer');

        
    }

    // function tree($user_id = 1)
    // {

    //     if (session()->get('login_data')['type_id'] == '1') { 

    //         $user_id = session()->get('login_id');
    //     }



    //     $user_detail = $this->UsersModel->getWhere(['users.users_id' => $user_id]);


    //     $users_1 = $this->FamilyModel->getWhere(['family.user_id' => $user_id]);

    //     // dd($users_1);

    //     $user = $this->FamilyModel->getTree($user_id);
    //     // dd($users_1);
    //     // $user = $this->FamilyModel->user_family($users_1[0]['family_id']);



    //     // dd($user);  


    //     $users = array_merge($users_1,$user);
    //     $tree =  $this->buildTree($users,$user_id);

    //     $users_1[0]['children'] = $tree;

    //     $tree = $users_1;
        

    //     $ulli = $this->createListLi($tree);
        

    //     $this->pageData["ulli"] = $ulli;
    //     $this->pageData["user_detail"] = $user_detail[0];


    //     echo view('admin/header', $this->pageData);
    //     echo view('admin/users/ul_of_tree');
    //     // echo view('admin/footer');

        
    // }




    
    function createListAccordion($main_topics,$count = 0 )
    {
        if($main_topics == null || sizeof($main_topics) <= 0)
        {
            return '';
        }

        $list = '<div class="card-body">
                    <div id="accordion_'.$count.'">
                    <div class="card">
                        <div class="card-header" id="heading_'.$count.'">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$count.'" aria-expanded="true">
                                asdasdasd@asd  : Referrals (2)
                                <br>
                                Total Received Point : 8.50                                        <br>
                                Total Group Sales : RM 30.99                                        <br>
                                Total Self Sales : RM 0
                                </button>
                            </h5>
                        </div>
                        
                       
                        ';
        foreach($main_topics as $k_main_topics => $v_main_topics )
        {   
            // dd($v_main_topics);
            $list .= ' <div id="collapse'.$count.'" class="collapse" data-parent="#accordion_'.$count.'" style="">
            <div class="card-body">
            
          '.  $this->createListAccordion(isset($v_main_topics["children"]) ? $v_main_topics["children"] : null,$count++) . '</div></div>' ;

        }

        $list .= '</div></div></div></div>';

        return $list;

    }
       

    function createListLi($main_topics,$count = 0 )
    {
        if($main_topics == null || sizeof($main_topics) <= 0)
        {
            
            return '';

        }

        $list = '<ul>';
        foreach($main_topics as $k_main_topics => $v_main_topics )
        {
            // dd($v_main_topics);

            $list .= '<li>'.$v_main_topics['username']  . $this->createListLi(isset($v_main_topics["children"]) ? $v_main_topics["children"] : null,$count++) . '</li>' ;


        }

        $list .= '</ul>';


        return $list;

    }

    public function buildTreeDirect(array $elements, $parentId = 0) {
        $branch = array();
        // dd($elements);
        
        

        foreach ($elements as $element) {
            // dd($element);   
            // $element['downline_count']=  $this->CustomerModel->recursive_get_downline_count($element['customer_id']);;
            // dd($parentId);
            if ($element['reference_id'] == $parentId) {
                $children = $this->buildTreeDirect($elements, $element['users_id']);
                if (!empty($children)) {
                    $element['children'] = $children;
                    // dd($element);
                }
                $branch[] = $element;

            }
        }
        return $branch;
    }



    public function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        // dd($elements);
        foreach ($elements as $element) {
   
            if ($element['link_family_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['family_id']);
                if (!empty($children)) {

                    $element['children'] = $children;
                    // dd($element);
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

}    



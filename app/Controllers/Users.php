<?php





namespace App\Controllers;

use App\Core\BaseController;
use App\Models\UsersModel;
use App\Models\FamilyModel;

use App\Models\WalletModel;
use App\Models\CompanyProfitModel;

class Users extends BaseController
{
    public function __construct()
    {
        $this->WalletModel = new WalletModel();
        $this->FamilyModel = new FamilyModel();

        $this->CompanyProfitModel = new CompanyProfitModel();


        $this->UsersModel = new UsersModel();
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



    // public function generate_image
    public function index()
    {

        
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
    
        $this->pageData['users'] = $users;
        echo view('admin/header', $this->pageData);
        echo view('admin/users/all');
        echo view('admin/footer');
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

            if (!$error) {
                $hash = $this->hash($input['password']);
                $input['contact'] = $this->format_contact($input['contact']);

                $data = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['username'],
                    'contact' => $input['contact'],

                    'password' => $hash['password'],
                    // 'nric_name' => $input['nric_name'],
                    // 'nric' => $input['nric'],
                    'family_id' => $input['family_id'],
                    // 'ssm_name' => $input['ssm_name'],
                    // 'ssm_number' => $input['ssm_number'],
                    'salt' => $hash['salt'],
                    // 'created_by'    => $this->session->userdata('login_id')
                ];
                $data = $this->upload_image_with_data($data, 'nric_front');
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

    public function verify_user($users_id){
        $where = [
            'users.users_id' => $users_id
        ];
        $users = $this->UsersModel->getWhere($where)[0];

        if($users['is_verified'] == 0){
            $is_verified = 1;
            $remarks = "Profit 500 from users " . $users['name'] . ' joining' ;
            $this->CompanyProfitModel->company_profit_in($users_id,500,$remarks);
           
           
            $this->FamilyModel->insert_new_member($users_id,$users['family_id']);
    
        }else{
            $is_verified = 0;


        }
        $this->UsersModel->updateWhere($where,['is_verified' => $is_verified]);


        return redirect()->to($_SERVER['HTTP_REFERER']);

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
        
        $family = $this->FamilyModel->getWhere(['family.user_id' => $users_id]);
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
                    'username' => $input['contact'],
                    'contact' => $input['contact'],
                    // 'nric_name' => $input['nric_name'],
                    // 'nric' => $input['nric'],
                ];
                $data = $this->upload_image_with_data($data, 'receipt');
                $data = $this->upload_image_with_data($data, 'nric_back');

                // $data = $this->upload_image_with_data($data, 'ssm_cert');

                if ($input['password'] != '') {
                    $hash = $this->hash($input['password']);
                    $data['password'] = $hash['password'];

                    $data['salt'] = $hash['salt'];
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
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);

    }


    function tree($user_id = 1)
    {

        if (session()->get('login_data')['type_id'] == '1') { 

            $user_id = session()->get('login_id');
        }



        $users_1 = $this->FamilyModel->getWhere(['family.user_id' => $user_id]);

        // dd($users_1);

        $user = $this->FamilyModel->getTree($user_id);


        // dd($users_1);
        // $user = $this->FamilyModel->user_family($users_1[0]['family_id']);


        // dd($user);  


        $users = array_merge($users_1,$user);
        // dd($users);
        $tree =  $this->buildTree($users,$user_id);
        // dd($tree);

        $users_1[0]['children'] = $tree;

        $tree = $users_1;

        
        // dd($tree);
        $ulli = $this->createListLi($tree);
        
        $this->pageData["ulli"] = $ulli;
        

        echo view('admin/header', $this->pageData);
        echo view('admin/users/ul_of_tree');
        // echo view('admin/footer');

    }


    
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
            $list .= '<li>'.$v_main_topics['username']  . " 
            - ". $v_main_topics['name'] .  $this->createListLi(isset($v_main_topics["children"]) ? $v_main_topics["children"] : null,$count++) . '</li>' ;


        }

        $list .= '</ul>';

        return $list;

    }



    public function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        // dd($elements);
        
        foreach ($elements as $element) {
            // dd($element);   
            // $element['downline_count']=  $this->CustomerModel->recursive_get_downline_count($element['customer_id']);;
            if ($element['link_family_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['user_id']);
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



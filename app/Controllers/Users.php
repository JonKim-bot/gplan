<?php



namespace App\Controllers;

use App\Core\BaseController;
use App\Models\UsersModel;

use App\Models\WalletModel;

class Users extends BaseController
{
    public function __construct()
    {
        $this->WalletModel = new WalletModel();

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
                $this->page_data['error'] = 'Passwords do not match';
                $this->page_data['input'] = $input;
            }

            if (!$error) {
                $hash = $this->hash($input['password']);
                $input['contact'] = $this->format_contact($input['contact']);

                $data = [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'username' => $input['contact'],
                    'contact' => $input['contact'],
                    'password' => $hash['password'],
                    'nric_name' => $input['nric_name'],
                    'nric' => $input['nric'],

                    // 'ssm_name' => $input['ssm_name'],
                    // 'ssm_number' => $input['ssm_number'],
                    'salt' => $hash['salt'],
                    // 'created_by'    => $this->session->userdata('login_id')
                ];
                $data = $this->upload_image_with_data($data, 'nric_front');
                $data = $this->upload_image_with_data($data, 'nric_back');
                // $data = $this->upload_image_with_data($data, 'ssm_cert');

                // $where_role = array(
                //     'role.role_id' => $_POST['role_id']
                // );
                // $role = $this->Role_model->get_where($where_role);
                // $data['name'] = $role[0]['role'];
                // die();
                $users_id = $this->UsersModel->insertNew($data);

                $this->UsersModel->insert_new_member($users_id,$_POST['family_id']);
                // redirect("store_users", "refresh");
                return redirect()->to($_SERVER['HTTP_REFERER']);
            } else {
                $this->page_data['error'] = 'Failed to add user data';
            }
        }

        $this->pageData['users'] = $this->UsersModel->get_family_user();

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
        }else{
            $is_verified = 0;
        }
        $this->UsersModel->updateWhere($where,['is_verified' => $is_verified]);

        return redirect()->to($_SERVER['HTTP_REFERER']);

    }

    public function detail($users_id)
    {
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
                    'nric_name' => $input['nric_name'],
                    'nric' => $input['nric'],
                ];
                $data = $this->upload_image_with_data($data, 'nric_front');
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

        $users_1 = $this->User_model->get_where(['user_id' => $user_id]);

        $user = $this->User_model->get_tree($user_id);
        $users = array_merge($users_1,$user);
        // dd($users);
        $tree =  $this->buildTree($users,$user_id);
        $users_1[0]['children'] = $tree;
        $tree = $users_1;
        $ulli = $this->createListLi($tree);
        // dd($users_1);
        // dd($ulli);

        // $this->show_404_if_empty($user);

        $this->page_data["ulli"] = $ulli;


        $this->load->view("admin/header", $this->page_data);
        $this->load->view("admin/user/ul_of_tree");
        $this->load->view("admin/footer");
    }


}

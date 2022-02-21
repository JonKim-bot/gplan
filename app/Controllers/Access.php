<?php namespace App\Controllers;





use App\Core\BaseController;
use App\Models\AdminModel;
use App\Models\UsersModel;


class Access extends BaseController
{
    public function __construct()
    {
        $this->AdminModel = new AdminModel();
        // $session = session();
        $this->UsersModel = new UsersModel();

    }


    public function loginUser()
    {
        $session = session();

        if ($_POST) {
            $input = $this->request->getPost();

            $error = false;

            $where = [
                'username' => $input['username'],
            ];

            $user = $this->UsersModel->getWhere($where);
            // $user = $this->UsernModel->getWhere($where);
            // dd($admin);
            if (!empty($user)) {
                $login = $this->UsersModel->login(
                    $input['username'],
                    $input['password']
                );

                if (!empty($login)) {
                    $login_data = $login[0];
                    $login_id = $login[0]['users_id'];
                } else {
                    $error = true;
                    $this->pageData['error'] = 'Invalid Username and Password';
                }
            } /**else if (!empty($user)) {
                $login = $this->UsersModel->login($input["username"], $input["password"]);
                if (!empty($login)) {
                    $login_data = $login[0];

                    $login_id = $login[0]["user_id"];
                } else {
                    $error = true;
                    $this->pageData["error"] = "Invalid Username and Password";

                }
            } */ else {
                $error = true;
                $this->pageData['error'] = 'Invalid Username and Password';
            }

            if (!empty($login_data) and $login_data['deleted'] == 1) {
                $error = true;
                $this->pagedata['error'] = 'This Account has been DEACTIVATED';
            }

            if (!empty($login_data) and $login_data['is_verified'] == 0) {
                $error = true;
                $this->pagedata['error'] = 'This Account has not been VERIFIED yet';
            }

            // dd($login_data);
            if (!$error) {
                $login_data['type_id'] = 1;
                $session->set('login_data', $login_data);
                $session->set('login_id', $login_id);


                return redirect()->to(base_url('users/detail/1', 'refresh'));
            }
        }


        echo view('access/header', $this->pageData);
        echo view('access/login_user');
        echo view('access/footer');
    }


    public function login()
    {
        $session = session();

        if ($_POST) {
            $input = $this->request->getPost();

            $error = false;

            $where = [
                'username' => $input['username'],
            ];

            $admin = $this->AdminModel->getWhere($where);
            
            $user = $this->UsersModel->getWhere($where);
            // dd($admin);
            if (!empty($admin)) {
                $login = $this->AdminModel->login(
                    $input['username'],
                    $input['password']
                );

                if (!empty($login)) {
                    $login_data = $login[0];
                    $login_id = $login[0]['admin_id'];
                    $type_id = 0;

                } else {
                    $error = true;
                    $this->pageData['error'] = 'Invalid Username and Password';
                }
            } /**else if (!empty($user)) {
                $login = $this->UsersModel->login($input["username"], $input["password"]);
                if (!empty($login)) {
                    $login_data = $login[0];
                    $login_id = $login[0]["user_id"];
                } else {
                    $error = true;
                    $this->pageData["error"] = "Invalid Username and Password";

                }
            } */ else if(!empty($user)){



                $login = $this->UsersModel->login(
                    $input['username'],
                    $input['password']
                );

                if (!empty($login)) {
                    $login_data = $login[0];
                    $login_id = $login[0]['users_id'];

                    $type_id = 1;
                } else {
                    $error = true;
                    $this->pageData['error'] = 'Invalid Username and Password';
                }



            }else{
                $error = true;
                $this->pageData['error'] = 'Invalid Username and Password';

                
            }

            if (!empty($login_data) and $login_data['deleted'] == 1) {
                $error = true;
                $this->pagedata['error'] = 'This Account has been DEACTIVATED';
            }

            // dd($login_data);
            if (!$error) {
                $login_data['type_id'] = $type_id;

                $session->set('login_data', $login_data);
                $session->set('login_id', $login_id);

                if($type_id == 1){
                    return redirect()->to(base_url('users/detail/1', 'refresh'));

                }else{

                    return redirect()->to(base_url('admin', 'refresh'));
                }
            }
        }

        echo view('access/header', $this->pageData);
        echo view('access/login');
        echo view('access/footer');
    }

    public function logout()

    {
        $session = session();


        $session->destroy();
        // if (session()->get('login_data')['type_id'] == '0') { 
            return redirect()->to(base_url('access/login', 'refresh'));

        // }else{
            
        //     return redirect()->to(base_url('access/loginUser', 'refresh'));
        // }


    }
}

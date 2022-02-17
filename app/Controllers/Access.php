<?php namespace App\Controllers;




use App\Core\BaseController;
use App\Models\AdminModel;

class Access extends BaseController
{
    public function __construct()
    {
        $this->AdminModel = new AdminModel();
        // $session = session();
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
            // $user = $this->UsernModel->getWhere($where);
            // dd($admin);
            if (!empty($admin)) {
                $login = $this->AdminModel->login(
                    $input['username'],
                    $input['password']
                );

                if (!empty($login)) {
                    $login_data = $login[0];
                    $login_id = $login[0]['admin_id'];
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

            // dd($login_data);
            if (!$error) {
                $session->set('login_data', $login_data);
                $session->set('login_id', $login_id);

                return redirect()->to(base_url('admin', 'refresh'));
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

        return redirect()->to(base_url('access/login', 'refresh'));
    }
}

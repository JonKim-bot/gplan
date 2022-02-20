<?php namespace App\Controllers;




use App\Core\BaseController;
use App\Models\AdminModel;
use App\Models\UsersModel;


class Admin extends BaseController
{

    public function __construct()
    {

        $this->pageData = array();
        $this->AdminModel = new AdminModel();
        $this->UsersModel = new UsersModel();

    }

    public function index()
    {

        $page = 1;
        $filter = array();

        if($_GET){
            $get = $this->request->getGet();
            
            if(!empty($get['page'])) $page = $get['page'];
            unset($get['page']);
            $filter = $get;
        }
        
        $admin = $this->AdminModel->getAll(10, $page, $filter);
        $this->pageData['admin'] = $admin['result'];
        $this->pageData['page'] = $admin['pagination'];
        $this->pageData['start_no'] = $admin['start_no'];

        echo view('admin/header', $this->pageData);
        echo view('admin/admin/all');
        echo view('admin/footer');
    }

    public function add()
    {

        // $input = $this->request->getVar();
        // $check = $this->request->getGet();

        if ($_POST) {

            $input = $this->request->getPost();

            // $this->debug($input);

            $error = false;

            $exists = $this->checkExists($input["username"]);
            // $this->debug($exists);

            if ($exists) {
                $error = true;
                $this->pageData["error"] = "Username already exists.";
                $this->pageData["input"] = $input;
            }

            if ($input["password"] != $input["password2"]) {
                $error = true;
                $this->pageData["error"] = "Passwords do not match";
                $this->pageData["input"] = $input;
            }

            //single upload
            // $getUpload = $this->request->getFile('thumbnail');
            // $thumbnail = $getUpload->getName();
            // $tempName = $getUpload->getTempName();
            // $getUpload->move('./assets/img/admin', $thumbnail);

            //multiple upload
            // $getUpload = $this->request->getFileMultiple('thumbnail');
            // foreach ($getUpload as $files){
            //     $thumbnail = $files->getName();
            //     $files->move('./assets/img/admin', $thumbnail);
            // }

            if (!$error) {

                $hash = $this->hash($input['password']);

                $data = array(
                    // 'thumbnail' => $thumbnail,
                    'name' => $input['name'],
                    'username' => $input['username'],
                    'contact' => $input['contact'],
                    'email' => $input['email'],
                    // 'type_id' => $_POST['type_id'],

                    'password' => $hash['password'],
                    'salt' => $hash['salt'],
                    'created_by' => session()->get('login_id'),
                );

                // $this->debug($data);
                // dd($data);

                $this->AdminModel->insertNew($data);

                return redirect()->to(base_url('admin', "refresh"));

            }

        }

        echo view('admin/header', $this->pageData);
        echo view('admin/admin/add');
        echo view('admin/footer');
    }

    public function detail($admin_id)
    {


        $where = array(
            "admin_id" => $admin_id,
        );
        $admin = $this->AdminModel->getWhere($where);

        // $this->show_404_if_empty($admin);

        $this->pageData["admin"] = $admin[0];

        echo view('admin/header', $this->pageData);
        echo view('admin/admin/detail');
        echo view('admin/footer');
    }

    public function edit($admin_id)
    {

        $where = array(

            "admin_id" => $admin_id,
        );

        $this->pageData["admin"] = $this->AdminModel->getWhere($where)[0];

        if ($_POST) {

            $error = false;

            $input = $this->request->getPost();

            // $exists = $this->checkExists($input["username"], $admin_id);

            // if ($exists) {
            //     $error = true;
            //     $this->pageData["error"] = "Username already exists.";
            //     $this->pageData["input"] = $input;
            // }
            if (!empty($input['password'])) {
                if ($input["password"] != $input["password2"]) {
                    $error = true;
                    $this->pageData["error"] = "Passwords do not match";
                    $this->pageData["input"] = $input;
                }
            }

            //single upload
            $getUpload = $this->request->getFile('thumbnail');
            $thumbnail = $getUpload->getName();

            //multiple upload
            // $getUpload = $this->request->getFileMultiple('thumbnail');

            if (!$error) {

                $where = array(
                    'admin_id' => $admin_id,
                );

                $data = array(
                    // 'username' => $input['username'],
                    'name' => $input['name'],
                    
                    // 'type_id' => $_POST['type_id'],
                    'contact' => $input['contact'],
                    'email' => $input['email'],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => session()->get('login_id'),
                );

                if (!empty($thumbnail)) {
                    $data['thumbnail'] = $thumbnail;
                    $getUpload->move('./assets/img/admin', $thumbnail);

                    // foreach ($getUpload as $files){
                    //     $thumbnail = $files->getName();
                    //     $files->move('./assets/img/admin', $thumbnail);
                    // }
                }

                $this->AdminModel->updateWhere($where, $data);

                return redirect()->to(base_url('admin/detail/' . $admin_id, "refresh"));

            }

        }

        echo view('admin/header', $this->pageData);
        echo view('admin/admin/edit');
        echo view('admin/footer');
    }

    public function delete($admin_id)
    {

        $this->AdminModel->softDelete($admin_id);

        return redirect()->to(base_url('admin', "refresh"));
    }

    public function test()
    {
        die("hello world");
    }

}

<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\NotificationUpdateModel;

class NotificationUpdate extends BaseController
{
    public function __construct()
    {
        $this->pageData = [];

        $this->NotificationUpdateModel = new NotificationUpdateModel();
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

    public function index()
    {

        $notification_update = $this->NotificationUpdateModel->getAll();
        // dd($notification_update);
        $field = $this->NotificationUpdateModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['table'] = $this->generate_table($field,$notification_update,'notification_update','banner');
        $this->pageData['notification_update'] = $notification_update;
        echo view('admin/header', $this->pageData);
        echo view('admin/notification_update/all');
        echo view('admin/footer');
    }

    public function add()
    {


        if ($_POST) {

            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $name = $_POST['name'];
                $description = $_POST['description'];
                $data = $this->upload_image_with_data($data,'banner');
                // dd($data);
                $notification_update_id = $this->NotificationUpdateModel->insertNew($data);
                $user_sql =  'SELECT * FROM users where users.deleted = 0 and token != ""';
                $users = $this->NotificationUpdateModel->processSql(
                    $user_sql
                );

                $sql = "INSERT INTO notification (name,description,users_id,notification_type_id) 
                SELECT '$name','$description',users_id,4 FROM users WHERE users.deleted = 0 and token != '';";
                // $user = $this->db->query($sql);
                $notification_update = $this->NotificationUpdateModel->processSql(
                    $sql
                );
                // $users = 
                // dd($users);
                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }


        $this->pageData['final_form'] = $this->NotificationUpdateModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','created_date']);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/notification_update/add');
        echo view('admin/footer');
    }

    public function copy($notification_update_id){
        $notification_update = $this->NotificationUpdateModel->copy($notification_update_id);
        return redirect()->to(base_url('NotificationUpdate', 'refresh'));
    }

    public function detail($notification_update_id)
    {
        $where = [
            'notification_update.notification_update_id' => $notification_update_id,
        ];
        $notification_update = $this->NotificationUpdateModel->getWhere($where)[0];
        $this->pageData['notification_update'] = $notification_update;

        $field = $this->NotificationUpdateModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['detail'] = $this->generate_detail($field,$notification_update,'banner');

        echo view('admin/header', $this->pageData);
        echo view('admin/notification_update/detail');
        echo view('admin/footer');
    }

    public function edit($notification_update_id)
    {
        $where = [
            'notification_update.notification_update_id' => $notification_update_id,
        ];
        $this->pageData['notification_update'] = $this->NotificationUpdateModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {

                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data,'banner');

                $this->NotificationUpdateModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }

        }


        // $this->pageData['form'] = $this->NotificationUpdateModel->generate_edit_input($notification_update_id);
        $this->pageData['final_form'] = $this->NotificationUpdateModel->get_final_form_edit($notification_update_id,['created_by','modified_by','deleted','modified_date','created_date']);

        echo view('admin/header', $this->pageData);
        echo view('admin/notification_update/edit');
        echo view('admin/footer');
    }

    public function delete($notification_update_id)
    {
        $this->NotificationUpdateModel->softDelete($notification_update_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}


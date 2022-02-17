<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\NotificationModel;

class Notification extends BaseController
{
    public function __construct()
    {
        $this->NotificationModel = new NotificationModel();
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
        $notification = $this->NotificationModel->getAll();
        // dd($notification);
        $field = $this->NotificationModel->get_field(
            [
                'created_by',
                'modified_by',
                'deleted',
                'notification_id',
                'notification_type_id',
                'users_id',
                'auction_id',
            ],
            $notification
        );
        $this->pageData['table'] = $this->generate_table(
            $field,
            $notification,
            'notification',
            'banner'
        );
        $this->pageData['notification'] = $notification;
        echo view('admin/header', $this->pageData);
        echo view('admin/notification/all');
        echo view('admin/footer');
    }
    public function add_update()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $_POST['notification_type_id'] = 4;
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'banner');
                // dd($data);
                $this->NotificationUpdateModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->NotificationUpdateModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'auction_id',
            'is_read',
            'users_id',
            'notification_type',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/notification/add_update');
        echo view('admin/footer');
    }


    public function add()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'banner');
                // dd($data);
                $this->NotificationModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->NotificationModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/notification/add');
        echo view('admin/footer');
    }

    public function copy($notification_id)
    {
        $notification = $this->NotificationModel->copy($notification_id);
        return redirect()->to(base_url('Notification', 'refresh'));
    }

    public function detail($notification_id)
    {
        $where = [
            'notification.notification_id' => $notification_id,
        ];
        $notification = $this->NotificationModel->getWhere($where)[0];
        $this->pageData['notification'] = $notification;

        $field = $this->NotificationModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $notification,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/notification/detail');
        echo view('admin/footer');
    }

    public function edit($notification_id)
    {
        $where = [
            'notification.notification_id' => $notification_id,
        ];
        $this->pageData['notification'] = $this->NotificationModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->NotificationModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->NotificationModel->generate_edit_input($notification_id);
        $this->pageData[
            'final_form'
        ] = $this->NotificationModel->get_final_form_edit($notification_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/notification/edit');
        echo view('admin/footer');
    }

    public function delete($notification_id)
    {
        $this->NotificationModel->softDelete($notification_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

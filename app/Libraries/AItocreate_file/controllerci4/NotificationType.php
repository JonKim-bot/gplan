<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\NotificationTypeModel;

class NotificationType extends BaseController
{
    public function __construct()
    {
        $this->NotificationTypeModel = new NotificationTypeModel();
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
        $notification_type = $this->NotificationTypeModel->getAll();
        // dd($notification_type);
        $field = $this->NotificationTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $notification_type,
            'notification_type',
            'banner'
        );
        $this->pageData['notification_type'] = $notification_type;
        echo view('admin/header', $this->pageData);
        echo view('admin/notification_type/all');
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
                $this->NotificationTypeModel->insertNew($data);

                return redirect()->to(base_url('NotificationType', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->NotificationTypeModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/notification_type/add');
        echo view('admin/footer');
    }

    public function copy($notification_type_id)
    {
        $notification_type = $this->NotificationTypeModel->copy(
            $notification_type_id
        );
        return redirect()->to(base_url('NotificationType', 'refresh'));
    }

    public function detail($notification_type_id)
    {
        $where = [
            'notification_type_id' => $notification_type_id,
        ];
        $notification_type = $this->NotificationTypeModel->getWhere($where)[0];
        $this->pageData['notification_type'] = $notification_type;

        $field = $this->NotificationTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $notification_type,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/notification_type/detail');
        echo view('admin/footer');
    }

    public function edit($notification_type_id)
    {
        $where = [
            'notification_type_id' => $notification_type_id,
        ];
        $this->pageData[
            'notification_type'
        ] = $this->NotificationTypeModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->NotificationTypeModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'NotificationType/detail/' . $notification_type_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->NotificationTypeModel->generate_edit_input($notification_type_id);
        $this->pageData[
            'final_form'
        ] = $this->NotificationTypeModel->get_final_form_edit(
            $notification_type_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/notification_type/edit');
        echo view('admin/footer');
    }

    public function delete($notification_type_id)
    {
        $this->NotificationTypeModel->softDelete($notification_type_id);
        // dd('asd');
        return redirect()->to(base_url('NotificationType', 'refresh'));
    }
}

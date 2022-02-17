<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AdminModel;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->AdminModel = new AdminModel();
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
        $admin = $this->AdminModel->getAll();
        // dd($admin);
        $field = $this->AdminModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $admin,
            'admin',
            'banner'
        );
        $this->pageData['admin'] = $admin;
        echo view('admin/header', $this->pageData);
        echo view('admin/admin/all');
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
                $this->AdminModel->insertNew($data);

                return redirect()->to(base_url('Admin', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->AdminModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/admin/add');
        echo view('admin/footer');
    }

    public function copy($admin_id)
    {
        $admin = $this->AdminModel->copy($admin_id);
        return redirect()->to(base_url('Admin', 'refresh'));
    }

    public function detail($admin_id)
    {
        $where = [
            'admin_id' => $admin_id,
        ];
        $admin = $this->AdminModel->getWhere($where)[0];
        $this->pageData['admin'] = $admin;

        $field = $this->AdminModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $admin,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/admin/detail');
        echo view('admin/footer');
    }

    public function edit($admin_id)
    {
        $where = [
            'admin_id' => $admin_id,
        ];
        $this->pageData['admin'] = $this->AdminModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->AdminModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Admin/detail/' . $admin_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->AdminModel->generate_edit_input($admin_id);
        $this->pageData[
            'final_form'
        ] = $this->AdminModel->get_final_form_edit($admin_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/admin/edit');
        echo view('admin/footer');
    }

    public function delete($admin_id)
    {
        $this->AdminModel->softDelete($admin_id);
        // dd('asd');
        return redirect()->to(base_url('Admin', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\RoleModel;

class Role extends BaseController
{
    public function __construct()
    {
        $this->RoleModel = new RoleModel();
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
        $role = $this->RoleModel->getAll();
        // dd($role);
        $field = $this->RoleModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $role,
            'role',
            'banner'
        );
        $this->pageData['role'] = $role;
        echo view('admin/header', $this->pageData);
        echo view('admin/role/all');
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
                $this->RoleModel->insertNew($data);

                return redirect()->to(base_url('Role', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->RoleModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/role/add');
        echo view('admin/footer');
    }

    public function copy($role_id)
    {
        $role = $this->RoleModel->copy($role_id);
        return redirect()->to(base_url('Role', 'refresh'));
    }

    public function detail($role_id)
    {
        $where = [
            'role_id' => $role_id,
        ];
        $role = $this->RoleModel->getWhere($where)[0];
        $this->pageData['role'] = $role;

        $field = $this->RoleModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $role,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/role/detail');
        echo view('admin/footer');
    }

    public function edit($role_id)
    {
        $where = [
            'role_id' => $role_id,
        ];
        $this->pageData['role'] = $this->RoleModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->RoleModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Role/detail/' . $role_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->RoleModel->generate_edit_input($role_id);
        $this->pageData[
            'final_form'
        ] = $this->RoleModel->get_final_form_edit($role_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/role/edit');
        echo view('admin/footer');
    }

    public function delete($role_id)
    {
        $this->RoleModel->softDelete($role_id);
        // dd('asd');
        return redirect()->to(base_url('Role', 'refresh'));
    }
}

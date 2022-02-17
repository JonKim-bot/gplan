<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
{
    public function __construct()
    {
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

    public function index()
    {
        $users = $this->UsersModel->getAll();
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
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'banner');
                // dd($data);
                $this->UsersModel->insertNew($data);

                return redirect()->to(base_url('Users', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->UsersModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/users/add');
        echo view('admin/footer');
    }

    public function copy($users_id)
    {
        $users = $this->UsersModel->copy($users_id);
        return redirect()->to(base_url('Users', 'refresh'));
    }

    public function detail($users_id)
    {
        $where = [
            'users_id' => $users_id,
        ];
        $users = $this->UsersModel->getWhere($where)[0];
        $this->pageData['users'] = $users;

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

        echo view('admin/header', $this->pageData);
        echo view('admin/users/detail');
        echo view('admin/footer');
    }

    public function edit($users_id)
    {
        $where = [
            'users_id' => $users_id,
        ];
        $this->pageData['users'] = $this->UsersModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->UsersModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Users/detail/' . $users_id, 'refresh')
                );
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
        return redirect()->to(base_url('Users', 'refresh'));
    }
}

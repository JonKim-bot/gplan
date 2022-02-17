<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AboutModel;

class About extends BaseController
{
    public function __construct()
    {
        $this->AboutModel = new AboutModel();
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
        $about = $this->AboutModel->getAll();
        // dd($about);
        $field = $this->AboutModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $about,
            'about',
            'banner'
        );
        $this->pageData['about'] = $about;
        echo view('admin/header', $this->pageData);
        echo view('admin/about/all');
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
                $this->AboutModel->insertNew($data);

                return redirect()->to(base_url('About', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->AboutModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/about/add');
        echo view('admin/footer');
    }

    public function copy($about_id)
    {
        $about = $this->AboutModel->copy($about_id);
        return redirect()->to(base_url('About', 'refresh'));
    }

    public function detail($about_id)
    {
        $where = [
            'about_id' => $about_id,
        ];
        $about = $this->AboutModel->getWhere($where)[0];
        $this->pageData['about'] = $about;

        $field = $this->AboutModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $about,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/about/detail');
        echo view('admin/footer');
    }

    public function edit($about_id)
    {
        $where = [
            'about_id' => $about_id,
        ];
        $this->pageData['about'] = $this->AboutModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->AboutModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('About/detail/' . $about_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->AboutModel->generate_edit_input($about_id);
        $this->pageData[
            'final_form'
        ] = $this->AboutModel->get_final_form_edit($about_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/about/edit');
        echo view('admin/footer');
    }

    public function delete($about_id)
    {
        $this->AboutModel->softDelete($about_id);
        // dd('asd');
        return redirect()->to(base_url('About', 'refresh'));
    }
}

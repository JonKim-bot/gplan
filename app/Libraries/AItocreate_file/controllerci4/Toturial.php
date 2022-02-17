<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\ToturialModel;

class Toturial extends BaseController
{
    public function __construct()
    {
        $this->ToturialModel = new ToturialModel();
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
        $toturial = $this->ToturialModel->getAll();
        // dd($toturial);
        $field = $this->ToturialModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $toturial,
            'toturial',
            'banner'
        );
        $this->pageData['toturial'] = $toturial;
        echo view('admin/header', $this->pageData);
        echo view('admin/toturial/all');
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
                $this->ToturialModel->insertNew($data);

                return redirect()->to(base_url('Toturial', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->ToturialModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/toturial/add');
        echo view('admin/footer');
    }

    public function copy($toturial_id)
    {
        $toturial = $this->ToturialModel->copy($toturial_id);
        return redirect()->to(base_url('Toturial', 'refresh'));
    }

    public function detail($toturial_id)
    {
        $where = [
            'toturial_id' => $toturial_id,
        ];
        $toturial = $this->ToturialModel->getWhere($where)[0];
        $this->pageData['toturial'] = $toturial;

        $field = $this->ToturialModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $toturial,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/toturial/detail');
        echo view('admin/footer');
    }

    public function edit($toturial_id)
    {
        $where = [
            'toturial_id' => $toturial_id,
        ];
        $this->pageData['toturial'] = $this->ToturialModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->ToturialModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Toturial/detail/' . $toturial_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->ToturialModel->generate_edit_input($toturial_id);
        $this->pageData[
            'final_form'
        ] = $this->ToturialModel->get_final_form_edit($toturial_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/toturial/edit');
        echo view('admin/footer');
    }

    public function delete($toturial_id)
    {
        $this->ToturialModel->softDelete($toturial_id);
        // dd('asd');
        return redirect()->to(base_url('Toturial', 'refresh'));
    }
}

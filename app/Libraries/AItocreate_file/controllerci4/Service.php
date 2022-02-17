<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\ServiceModel;

class Service extends BaseController
{
    public function __construct()
    {
        $this->ServiceModel = new ServiceModel();
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
        $service = $this->ServiceModel->getAll();
        // dd($service);
        $field = $this->ServiceModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $service,
            'service',
            'banner'
        );
        $this->pageData['service'] = $service;
        echo view('admin/header', $this->pageData);
        echo view('admin/service/all');
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
                $this->ServiceModel->insertNew($data);

                return redirect()->to(base_url('Service', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->ServiceModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/service/add');
        echo view('admin/footer');
    }

    public function copy($service_id)
    {
        $service = $this->ServiceModel->copy($service_id);
        return redirect()->to(base_url('Service', 'refresh'));
    }

    public function detail($service_id)
    {
        $where = [
            'service_id' => $service_id,
        ];
        $service = $this->ServiceModel->getWhere($where)[0];
        $this->pageData['service'] = $service;

        $field = $this->ServiceModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $service,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/service/detail');
        echo view('admin/footer');
    }

    public function edit($service_id)
    {
        $where = [
            'service_id' => $service_id,
        ];
        $this->pageData['service'] = $this->ServiceModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->ServiceModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Service/detail/' . $service_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->ServiceModel->generate_edit_input($service_id);
        $this->pageData[
            'final_form'
        ] = $this->ServiceModel->get_final_form_edit($service_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/service/edit');
        echo view('admin/footer');
    }

    public function delete($service_id)
    {
        $this->ServiceModel->softDelete($service_id);
        // dd('asd');
        return redirect()->to(base_url('Service', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarInspectionModel;

class CarInspection extends BaseController
{
    public function __construct()
    {
        $this->CarInspectionModel = new CarInspectionModel();
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
        $car_inspection = $this->CarInspectionModel->getAll();
        // dd($car_inspection);
        $field = $this->CarInspectionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_inspection,
            'car_inspection',
            'banner'
        );
        $this->pageData['car_inspection'] = $car_inspection;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/all');
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
                $this->CarInspectionModel->insertNew($data);

                return redirect()->to(base_url('CarInspection', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->CarInspectionModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/add');
        echo view('admin/footer');
    }

    public function copy($car_inspection_id)
    {
        $car_inspection = $this->CarInspectionModel->copy($car_inspection_id);
        return redirect()->to(base_url('CarInspection', 'refresh'));
    }

    public function detail($car_inspection_id)
    {
        $where = [
            'car_inspection_id' => $car_inspection_id,
        ];
        $car_inspection = $this->CarInspectionModel->getWhere($where)[0];
        $this->pageData['car_inspection'] = $car_inspection;

        $field = $this->CarInspectionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car_inspection,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/detail');
        echo view('admin/footer');
    }

    public function edit($car_inspection_id)
    {
        $where = [
            'car_inspection_id' => $car_inspection_id,
        ];
        $this->pageData['car_inspection'] = $this->CarInspectionModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarInspectionModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'CarInspection/detail/' . $car_inspection_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->CarInspectionModel->generate_edit_input($car_inspection_id);
        $this->pageData[
            'final_form'
        ] = $this->CarInspectionModel->get_final_form_edit($car_inspection_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/edit');
        echo view('admin/footer');
    }

    public function delete($car_inspection_id)
    {
        $this->CarInspectionModel->softDelete($car_inspection_id);
        // dd('asd');
        return redirect()->to(base_url('CarInspection', 'refresh'));
    }
}

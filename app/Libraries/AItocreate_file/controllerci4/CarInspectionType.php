<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarInspectionTypeModel;

class CarInspectionType extends BaseController
{
    public function __construct()
    {
        $this->CarInspectionTypeModel = new CarInspectionTypeModel();
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
        $car_inspection_type = $this->CarInspectionTypeModel->getAll();
        // dd($car_inspection_type);
        $field = $this->CarInspectionTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_inspection_type,
            'car_inspection_type',
            'banner'
        );
        $this->pageData['car_inspection_type'] = $car_inspection_type;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_type/all');
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
                $this->CarInspectionTypeModel->insertNew($data);

                return redirect()->to(base_url('CarInspectionType', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->CarInspectionTypeModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_type/add');
        echo view('admin/footer');
    }

    public function copy($car_inspection_type_id)
    {
        $car_inspection_type = $this->CarInspectionTypeModel->copy(
            $car_inspection_type_id
        );
        return redirect()->to(base_url('CarInspectionType', 'refresh'));
    }

    public function detail($car_inspection_type_id)
    {
        $where = [
            'car_inspection_type_id' => $car_inspection_type_id,
        ];
        $car_inspection_type = $this->CarInspectionTypeModel->getWhere(
            $where
        )[0];
        $this->pageData['car_inspection_type'] = $car_inspection_type;

        $field = $this->CarInspectionTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car_inspection_type,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_type/detail');
        echo view('admin/footer');
    }

    public function edit($car_inspection_type_id)
    {
        $where = [
            'car_inspection_type_id' => $car_inspection_type_id,
        ];
        $this->pageData[
            'car_inspection_type'
        ] = $this->CarInspectionTypeModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarInspectionTypeModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'CarInspectionType/detail/' . $car_inspection_type_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->CarInspectionTypeModel->generate_edit_input($car_inspection_type_id);
        $this->pageData[
            'final_form'
        ] = $this->CarInspectionTypeModel->get_final_form_edit(
            $car_inspection_type_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_type/edit');
        echo view('admin/footer');
    }

    public function delete($car_inspection_type_id)
    {
        $this->CarInspectionTypeModel->softDelete($car_inspection_type_id);
        // dd('asd');
        return redirect()->to(base_url('CarInspectionType', 'refresh'));
    }
}

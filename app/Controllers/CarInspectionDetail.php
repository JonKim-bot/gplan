<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarInspectionDetailModel;

class CarInspectionDetail extends BaseController
{
    public function __construct()
    {
        $this->CarInspectionDetailModel = new CarInspectionDetailModel();
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
        $car_inspection_detail = $this->CarInspectionDetailModel->getAll();
        // dd($car_inspection_detail);
        $field = $this->CarInspectionDetailModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_inspection_detail,
            'car_inspection_detail',
            'banner'
        );
        $this->pageData['car_inspection_detail'] = $car_inspection_detail;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_detail/all');
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
                $this->CarInspectionDetailModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->CarInspectionDetailModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_detail/add');
        echo view('admin/footer');
    }

    public function copy($car_inspection_detail_id)
    {
        $car_inspection_detail = $this->CarInspectionDetailModel->copy(
            $car_inspection_detail_id
        );
        return redirect()->to(base_url('CarInspectionDetail', 'refresh'));
    }

    public function detail($car_inspection_detail_id)
    {
        $where = [
            'car_inspection_detail.car_inspection_detail_id' => $car_inspection_detail_id,
        ];
        $car_inspection_detail = $this->CarInspectionDetailModel->getWhere(
            $where
        )[0];
        $this->pageData['car_inspection_detail'] = $car_inspection_detail;

        $field = $this->CarInspectionDetailModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car_inspection_detail,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_detail/detail');
        echo view('admin/footer');
    }

    public function mark_pass_fail($car_inspection_detail_id)
    {
        $key = $_GET['key'];
        $car_inspection_type_id = $_GET['car_inspection_type'];
        $where = [
            'car_inspection_detail.car_inspection_detail_id' => $car_inspection_detail_id,
        ];
        $car_inspection_detail = $this->CarInspectionDetailModel->getWhere(
            $where
        )[0];
        // dd($car_inspection_detail);
        if ($car_inspection_detail['status_id'] == 1) {
            $status_id = 2;
        } else {
            $status_id = 1;
        }
        $car_inspection_detail = $this->CarInspectionDetailModel->updateWhere(
            $where,
            ['status_id' => $status_id]
        );
        // return redirect()->to($_SERVER['HTTP_REFERER']);
        return redirect()->to(
            base_url(
                '/CarInspectionType/detail/' .
                    $car_inspection_type_id .
                    "?key=$key&car_inspection_type_id=$car_inspection_type_id",
                'refresh'
            )
        );
    }

    public function edit($car_inspection_detail_id)
    {
        $where = [
            'car_inspection_detail.car_inspection_detail_id' => $car_inspection_detail_id,
        ];
        $this->pageData[
            'car_inspection_detail'
        ] = $this->CarInspectionDetailModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarInspectionDetailModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->CarInspectionDetailModel->generate_edit_input($car_inspection_detail_id);
        $this->pageData[
            'final_form'
        ] = $this->CarInspectionDetailModel->get_final_form_edit(
            $car_inspection_detail_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_detail/edit');
        echo view('admin/footer');
    }

    public function delete($car_inspection_detail_id)
    {
        $this->CarInspectionDetailModel->softDelete($car_inspection_detail_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarInspectionImageModel;

class CarInspectionImage extends BaseController
{
    public function __construct()
    {
        $this->CarInspectionImageModel = new CarInspectionImageModel();
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

    // public function index()
    // {

    //     $car_inspection_image = $this->CarInspectionImageModel->getAll();
    //     // dd($car_inspection_image);
    //     $field = $this->CarInspectionImageModel->get_field(['created_by','modified_by','deleted']);
    //     $this->pageData['table'] = $this->generate_table($field,$car_inspection_image,'car_inspection_image','banner');
    //     $this->pageData['car_inspection_image'] = $car_inspection_image;
    //     echo view('admin/header', $this->pageData);
    //     echo view('admin/car_inspection_image/all');
    //     echo view('admin/footer');
    // }

    public function image($car_inspection_id)
    {
        $where = [
            'car_inspection_image.car_inspection_id' => $car_inspection_id,
        ];
        $car_inspection_image = $this->CarInspectionImageModel->getWhere(
            $where
        );
        // dd($car_inspection_image);
        $field = $this->CarInspectionImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'car_inspection_id',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_inspection_image,
            'car_inspection_image',
            'image',
            0,
            'edit'
        );
        $this->pageData['car_inspection_image'] = $car_inspection_image;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_image/all');
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
                $this->CarInspectionImageModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->CarInspectionImageModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_image/add');
        echo view('admin/footer');
    }

    public function copy($car_inspection_image_id)
    {
        $car_inspection_image = $this->CarInspectionImageModel->copy(
            $car_inspection_image_id
        );
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function detail($car_inspection_image_id)
    {
        $where = [
            'car_inspection_image.car_inspection_image_id' => $car_inspection_image_id,
        ];
        $car_inspection_image = $this->CarInspectionImageModel->getWhere(
            $where
        )[0];
        $this->pageData['car_inspection_image'] = $car_inspection_image;

        $field = $this->CarInspectionImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'car_inspection_id',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car_inspection_image,
            'image'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_image/detail');
        echo view('admin/footer');
    }

    public function edit($car_inspection_image_id)
    {
        $where = [
            'car_inspection_image.car_inspection_image_id' => $car_inspection_image_id,
        ];
        $this->pageData[
            'car_inspection_image'
        ] = $this->CarInspectionImageModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarInspectionImageModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->CarInspectionImageModel->generate_edit_input($car_inspection_image_id);
        $this->pageData[
            'final_form'
        ] = $this->CarInspectionImageModel->get_final_form_edit(
            $car_inspection_image_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
                'car_inspection_id',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_image/edit');
        echo view('admin/footer');
    }

    public function delete($car_inspection_image_id)
    {
        $this->CarInspectionImageModel->softDelete($car_inspection_image_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

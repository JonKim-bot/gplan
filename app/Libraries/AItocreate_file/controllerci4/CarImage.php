<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarImageModel;

class CarImage extends BaseController
{
    public function __construct()
    {
        $this->CarImageModel = new CarImageModel();
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
        $car_image = $this->CarImageModel->getAll();
        // dd($car_image);
        $field = $this->CarImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_image,
            'car_image',
            'banner'
        );
        $this->pageData['car_image'] = $car_image;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/all');
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
                $this->CarImageModel->insertNew($data);

                return redirect()->to(base_url('CarImage', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->CarImageModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/add');
        echo view('admin/footer');
    }

    public function copy($car_image_id)
    {
        $car_image = $this->CarImageModel->copy($car_image_id);
        return redirect()->to(base_url('CarImage', 'refresh'));
    }

    public function detail($car_image_id)
    {
        $where = [
            'car_image_id' => $car_image_id,
        ];
        $car_image = $this->CarImageModel->getWhere($where)[0];
        $this->pageData['car_image'] = $car_image;

        $field = $this->CarImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car_image,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/detail');
        echo view('admin/footer');
    }

    public function edit($car_image_id)
    {
        $where = [
            'car_image_id' => $car_image_id,
        ];
        $this->pageData['car_image'] = $this->CarImageModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarImageModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('CarImage/detail/' . $car_image_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->CarImageModel->generate_edit_input($car_image_id);
        $this->pageData[
            'final_form'
        ] = $this->CarImageModel->get_final_form_edit($car_image_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/edit');
        echo view('admin/footer');
    }

    public function delete($car_image_id)
    {
        $this->CarImageModel->softDelete($car_image_id);
        // dd('asd');
        return redirect()->to(base_url('CarImage', 'refresh'));
    }
}

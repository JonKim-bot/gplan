<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarModel;

class Car extends BaseController
{
    public function __construct()
    {
        $this->CarModel = new CarModel();
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
        $car = $this->CarModel->getAll();
        // dd($car);
        $field = $this->CarModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car,
            'car',
            'banner'
        );
        $this->pageData['car'] = $car;
        echo view('admin/header', $this->pageData);
        echo view('admin/car/all');
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
                $this->CarModel->insertNew($data);

                return redirect()->to(base_url('Car', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->CarModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car/add');
        echo view('admin/footer');
    }

    public function copy($car_id)
    {
        $car = $this->CarModel->copy($car_id);
        return redirect()->to(base_url('Car', 'refresh'));
    }

    public function detail($car_id)
    {
        $where = [
            'car_id' => $car_id,
        ];
        $car = $this->CarModel->getWhere($where)[0];
        $this->pageData['car'] = $car;

        $field = $this->CarModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car/detail');
        echo view('admin/footer');
    }

    public function edit($car_id)
    {
        $where = [
            'car_id' => $car_id,
        ];
        $this->pageData['car'] = $this->CarModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Car/detail/' . $car_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->CarModel->generate_edit_input($car_id);
        $this->pageData[
            'final_form'
        ] = $this->CarModel->get_final_form_edit($car_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/car/edit');
        echo view('admin/footer');
    }

    public function delete($car_id)
    {
        $this->CarModel->softDelete($car_id);
        // dd('asd');
        return redirect()->to(base_url('Car', 'refresh'));
    }
}

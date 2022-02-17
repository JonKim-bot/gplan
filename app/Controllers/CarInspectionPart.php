<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarInspectionPartModel;

class CarInspectionPart extends BaseController
{
    public function __construct()
    {


        $this->CarInspectionPartModel = new CarInspectionPartModel();
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

        $car_inspection_part = $this->CarInspectionPartModel->getAll();
        // dd($car_inspection_part);
        $field = $this->CarInspectionPartModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['table'] = $this->generate_table($field,$car_inspection_part,'car_inspection_part','banner');
        $this->pageData['car_inspection_part'] = $car_inspection_part;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_part/all');
        echo view('admin/footer');
    }

    public function add()
    {


        if ($_POST) {

            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data,'banner');
                // dd($data);
                $this->CarInspectionPartModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }


        $this->pageData['final_form'] = $this->CarInspectionPartModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','created_date']);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_part/add');
        echo view('admin/footer');
    }

    public function copy($car_inspection_part_id){
        $car_inspection_part = $this->CarInspectionPartModel->copy($car_inspection_part_id);
        return redirect()->to(base_url('CarInspectionPart', 'refresh'));
    }

    public function detail($car_inspection_part_id)
    {
        $where = [
            'car_inspection_part.car_inspection_part_id' => $car_inspection_part_id,
        ];
        $car_inspection_part = $this->CarInspectionPartModel->getWhere($where)[0];
        $this->pageData['car_inspection_part'] = $car_inspection_part;

        $field = $this->CarInspectionPartModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['detail'] = $this->generate_detail($field,$car_inspection_part,'banner');

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_part/detail');
        echo view('admin/footer');
    }

    public function edit($car_inspection_part_id)
    {
        $where = [
            'car_inspection_part.car_inspection_part_id' => $car_inspection_part_id,
        ];
        $this->pageData['car_inspection_part'] = $this->CarInspectionPartModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {

                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data,'banner');

                $this->CarInspectionPartModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }

        }


        // $this->pageData['form'] = $this->CarInspectionPartModel->generate_edit_input($car_inspection_part_id);
        $this->pageData['final_form'] = $this->CarInspectionPartModel->get_final_form_edit($car_inspection_part_id,['created_by','modified_by','deleted','modified_date','created_date']);

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection_part/edit');
        echo view('admin/footer');
    }

    public function delete($car_inspection_part_id)
    {
        $this->CarInspectionPartModel->softDelete($car_inspection_part_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}


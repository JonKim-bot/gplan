<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarStickerModel;

class CarSticker extends BaseController
{
    public function __construct()
    {
        $this->pageData = [];

        $this->CarStickerModel = new CarStickerModel();
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

        $car_sticker = $this->CarStickerModel->getAll();
        // dd($car_sticker);
        $field = $this->CarStickerModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['table'] = $this->generate_table($field,$car_sticker,'car_sticker','banner');
        $this->pageData['car_sticker'] = $car_sticker;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_sticker/all');
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
                $this->CarStickerModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }


        $this->pageData['final_form'] = $this->CarStickerModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','created_date']);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_sticker/add');
        echo view('admin/footer');
    }

    public function copy($car_sticker_id){
        $car_sticker = $this->CarStickerModel->copy($car_sticker_id);
        return redirect()->to(base_url('CarSticker', 'refresh'));
    }

    public function detail($car_sticker_id)
    {
        $where = [
            'car_sticker.car_sticker_id' => $car_sticker_id,
        ];
        $car_sticker = $this->CarStickerModel->getWhere($where)[0];
        $this->pageData['car_sticker'] = $car_sticker;

        $field = $this->CarStickerModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['detail'] = $this->generate_detail($field,$car_sticker,'banner');

        echo view('admin/header', $this->pageData);
        echo view('admin/car_sticker/detail');
        echo view('admin/footer');
    }

    public function edit($car_sticker_id)
    {
        $where = [
            'car_sticker.car_sticker_id' => $car_sticker_id,
        ];
        $this->pageData['car_sticker'] = $this->CarStickerModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {

                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data,'banner');

                $this->CarStickerModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }

        }


        // $this->pageData['form'] = $this->CarStickerModel->generate_edit_input($car_sticker_id);
        $this->pageData['final_form'] = $this->CarStickerModel->get_final_form_edit($car_sticker_id,['created_by','modified_by','deleted','modified_date','created_date']);

        echo view('admin/header', $this->pageData);
        echo view('admin/car_sticker/edit');
        echo view('admin/footer');
    }

    public function delete($car_sticker_id)
    {
        $this->CarStickerModel->softDelete($car_sticker_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}


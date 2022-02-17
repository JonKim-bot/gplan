<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\StickerModel;

class Sticker extends BaseController
{
    public function __construct()
    {
        $this->pageData = [];

        $this->StickerModel = new StickerModel();
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


        $sticker = $this->StickerModel->getAll();
        // dd($sticker);
        $field = $this->StickerModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['table'] = $this->generate_table($field,$sticker,'sticker','image',0,'edit');
        $this->pageData['sticker'] = $sticker;
        echo view('admin/header', $this->pageData);
        echo view('admin/sticker/all');
        echo view('admin/footer');
    }

    public function add()
    {


        if ($_POST) {

            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data,'image');
                // dd($data);
                $this->StickerModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }
        }


        $this->pageData['final_form'] = $this->StickerModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','created_date']);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/sticker/add');
        echo view('admin/footer');
    }

    public function copy($sticker_id){
        $sticker = $this->StickerModel->copy($sticker_id);
        return redirect()->to(base_url('Sticker', 'refresh'));
    }

    public function detail($sticker_id)
    {
        $where = [
            'sticker.sticker_id' => $sticker_id,
        ];
        $sticker = $this->StickerModel->getWhere($where)[0];
        $this->pageData['sticker'] = $sticker;

        $field = $this->StickerModel->get_field(['created_by','modified_by','deleted']);
        $this->pageData['detail'] = $this->generate_detail($field,$sticker,'banner');

        echo view('admin/header', $this->pageData);
        echo view('admin/sticker/detail');
        echo view('admin/footer');
    }

    public function edit($sticker_id)
    {
        $where = [
            'sticker.sticker_id' => $sticker_id,
        ];
        $this->pageData['sticker'] = $this->StickerModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {



                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data,'image');

                $this->StickerModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);

            }

        }


        // $this->pageData['form'] = $this->StickerModel->generate_edit_input($sticker_id);
        $this->pageData['final_form'] = $this->StickerModel->get_final_form_edit($sticker_id,['created_by','modified_by','deleted','modified_date','created_date']);

        echo view('admin/header', $this->pageData);
        echo view('admin/sticker/edit');
        echo view('admin/footer');
    }

    public function delete($sticker_id)
    {
        $this->StickerModel->softDelete($sticker_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}


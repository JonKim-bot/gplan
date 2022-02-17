<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\ColorModel;

class Color extends BaseController
{
    public function __construct()
    {
        $this->ColorModel = new ColorModel();
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
        $color = $this->ColorModel->getAll();
        // dd($color);
        $field = $this->ColorModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $color,
            'color',
            'banner'
        );
        $this->pageData['color'] = $color;
        echo view('admin/header', $this->pageData);
        echo view('admin/color/all');
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
                $this->ColorModel->insertNew($data);

                return redirect()->to(base_url('Color', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->ColorModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/color/add');
        echo view('admin/footer');
    }

    public function copy($color_id)
    {
        $color = $this->ColorModel->copy($color_id);
        return redirect()->to(base_url('Color', 'refresh'));
    }

    public function detail($color_id)
    {
        $where = [
            'color_id' => $color_id,
        ];
        $color = $this->ColorModel->getWhere($where)[0];
        $this->pageData['color'] = $color;

        $field = $this->ColorModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $color,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/color/detail');
        echo view('admin/footer');
    }

    public function edit($color_id)
    {
        $where = [
            'color_id' => $color_id,
        ];
        $this->pageData['color'] = $this->ColorModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->ColorModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Color/detail/' . $color_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->ColorModel->generate_edit_input($color_id);
        $this->pageData[
            'final_form'
        ] = $this->ColorModel->get_final_form_edit($color_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/color/edit');
        echo view('admin/footer');
    }

    public function delete($color_id)
    {
        $this->ColorModel->softDelete($color_id);
        // dd('asd');
        return redirect()->to(base_url('Color', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\VariantModel;

class Variant extends BaseController
{


    public function __construct()
    {
        $this->VariantModel = new VariantModel();
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
        $variant = $this->VariantModel->getAll();
        // dd($variant);
        $field = $this->VariantModel->get_field(
            ['created_by', 'modified_by', 'deleted', 'variant_type_id','model_id', 'variant_id'],
            $variant
        );
        $this->pageData['table'] = $this->generate_table(
            $field,
            $variant,
            'variant',
            'banner'
        );
        $this->pageData['variant'] = $variant;
        echo view('admin/header', $this->pageData);

        echo view('admin/variant/all');
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
                $this->VariantModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['final_form'] = $this->VariantModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/variant/add');
        echo view('admin/footer');
    }

    public function copy($variant_id)
    {
        $variant = $this->VariantModel->copy($variant_id, ['variant_type']);
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function detail($variant_id)
    {
        $where = [
            'variant.variant_id' => $variant_id,
        ];
        $variant = $this->VariantModel->getWhere($where);
        $this->pageData['variant'] = $variant[0];

        $field = $this->VariantModel->get_field(
            ['created_by', 'modified_by', 'deleted', 'variant_id','model_id', 'variant_type_id'],

            $variant
        );
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $variant[0],
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/variant/detail');
        echo view('admin/footer');
    }

    public function edit($variant_id)
    {
        $where = [
            'variant.variant_id' => $variant_id,
        ];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->VariantModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->VariantModel->generate_edit_input($variant_id);
        $this->pageData[
            'final_form'
        ] = $this->VariantModel->get_final_form_edit($variant_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        $this->pageData['variant'] = $this->VariantModel->getWhere($where)[0];

        echo view('admin/header', $this->pageData);
        echo view('admin/variant/edit');
        echo view('admin/footer');
    }

    public function delete($variant_id)
    {
        $this->VariantModel->softDelete($variant_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

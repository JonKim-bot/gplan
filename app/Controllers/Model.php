<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\ModelModel;
use App\Models\VariantModel;

class Model extends BaseController
{
    public function __construct()
    {
        $this->VariantModel = new VariantModel();

        $this->ModelModel = new ModelModel();
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
        $model = $this->ModelModel->getAll();
        // dd($model);
        $field = $this->ModelModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $model,
            'model',
            'banner'
        );
        $this->pageData['model'] = $model;
        echo view('admin/header', $this->pageData);
        echo view('admin/model/all');
        echo view('admin/footer');
    }

    public function view_variant($model_id)
    {
        $where = [
            'variant.model_id' => $model_id
        ];
        $variant = $this->VariantModel->getWhere($where);
        $field = $this->VariantModel->get_field(
            ['created_by', 'modified_by', 'deleted', 'variant_type_id','model_id', 'variant_id'],
            $variant
        );
        $this->pageData['table'] = $this->generate_table(
            $field,
            $variant,
            'variant',
            'banner',
            0,
            'edit'
        );
        $this->pageData['variant'] = $variant;

        echo view('admin/header', $this->pageData);
        echo view('admin/model/view_variant');
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
                $this->ModelModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['final_form'] = $this->ModelModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/model/add');
        echo view('admin/footer');
    }

    public function copy($model_id)
    {
        $model = $this->ModelModel->copy($model_id);
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function detail($model_id)
    {
        $where = [
            'model.model_id' => $model_id,
        ];
        $model = $this->ModelModel->getWhere($where)[0];
        $this->pageData['model'] = $model;

        $field = $this->ModelModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $model,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/model/detail');
        echo view('admin/footer');
    }

    public function edit($model_id)
    {
        $where = [
            'model.model_id' => $model_id,
        ];
        $this->pageData['model'] = $this->ModelModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->ModelModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->ModelModel->generate_edit_input($model_id);
        $this->pageData[
            'final_form'
        ] = $this->ModelModel->get_final_form_edit($model_id, [
            'brand_id',
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/model/edit');
        echo view('admin/footer');
    }

    public function delete($model_id)
    {
        $this->ModelModel->softDelete($model_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

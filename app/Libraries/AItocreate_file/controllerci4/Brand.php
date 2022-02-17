<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\BrandModel;

class Brand extends BaseController
{
    public function __construct()
    {
        $this->BrandModel = new BrandModel();
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
        $brand = $this->BrandModel->getAll();
        // dd($brand);
        $field = $this->BrandModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $brand,
            'brand',
            'banner'
        );
        $this->pageData['brand'] = $brand;
        echo view('admin/header', $this->pageData);
        echo view('admin/brand/all');
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
                $this->BrandModel->insertNew($data);

                return redirect()->to(base_url('Brand', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->BrandModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/brand/add');
        echo view('admin/footer');
    }

    public function copy($brand_id)
    {
        $brand = $this->BrandModel->copy($brand_id);
        return redirect()->to(base_url('Brand', 'refresh'));
    }

    public function detail($brand_id)
    {
        $where = [
            'brand_id' => $brand_id,
        ];
        $brand = $this->BrandModel->getWhere($where)[0];
        $this->pageData['brand'] = $brand;

        $field = $this->BrandModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $brand,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/brand/detail');
        echo view('admin/footer');
    }

    public function edit($brand_id)
    {
        $where = [
            'brand_id' => $brand_id,
        ];
        $this->pageData['brand'] = $this->BrandModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->BrandModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Brand/detail/' . $brand_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->BrandModel->generate_edit_input($brand_id);
        $this->pageData[
            'final_form'
        ] = $this->BrandModel->get_final_form_edit($brand_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/brand/edit');
        echo view('admin/footer');
    }

    public function delete($brand_id)
    {
        $this->BrandModel->softDelete($brand_id);
        // dd('asd');
        return redirect()->to(base_url('Brand', 'refresh'));
    }
}

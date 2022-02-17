<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AreaModel;

class Area extends BaseController
{
    public function __construct()
    {
        $this->AreaModel = new AreaModel();

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
        $area = $this->AreaModel->getAll();
        // dd($area);
        $field = $this->AreaModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $area,
            'area',
            'banner'
        );
        $this->pageData['area'] = $area;
        echo view('admin/header', $this->pageData);
        echo view('admin/area/all');
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
                $this->AreaModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['final_form'] = $this->AreaModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);

        echo view('admin/area/add');
        echo view('admin/footer');
    }

    public function copy($area_id)
    {
        $area = $this->AreaModel->copy($area_id);
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function detail($area_id)
    {
        $where = [
            'area.area_id' => $area_id,
        ];
        $area = $this->AreaModel->getWhere($where)[0];
        $this->pageData['area'] = $area;

        $field = $this->AreaModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $area,
            'banner'
        );

        $area = $this->AreaModel->getWhere(['area.area_id' => $area_id]);
        // dd($model);
        $field = $this->AreaModel->get_field(
            [
                'model_id',
                'created_by',
                'modified_by',
                'deleted',
                'brand_id',
                'area_id',
                'area_id',
            ],
            $area
        );
        $this->pageData['table_area'] = $this->generate_table(
            $field,
            $area,
            'area',
            'banner',
            0,
            'edit'
        );
        // $this->pageData['final_form_area'] = $this->ModelModel->get_final_form_add(['created_by','modified_by','deleted','modified_date','brand_id','created_date','logo']);

        $form_arr = ['name'];
        $modal_area = $this->get_modal(
            $this->AreaModel->generate_input(),
            $form_arr,
            '/Area/add',
            'modalAdd',
            'area_id',
            $area_id
        );

        $this->pageData['modal_area'] = $modal_area;

        echo view('admin/header', $this->pageData);
        echo view('admin/area/detail');
        echo view('admin/footer');
    }

    public function edit($area_id)
    {
        $where = [
            'area.area_id' => $area_id,
        ];
        $this->pageData['area'] = $this->AreaModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->AreaModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->AreaModel->generate_edit_input($area_id);
        $this->pageData[
            'final_form'
        ] = $this->AreaModel->get_final_form_edit($area_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/area/edit');
        echo view('admin/footer');
    }

    public function delete($area_id)
    {
        $this->AreaModel->softDelete($area_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

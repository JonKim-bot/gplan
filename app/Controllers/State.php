<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\StateModel;
use App\Models\AreaModel;

class State extends BaseController
{
    public function __construct()
    {
        $this->StateModel = new StateModel();

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
        $state = $this->StateModel->getAll();
        // dd($state);
        $field = $this->StateModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $state,
            'state',
            'banner'
        );
        $this->pageData['state'] = $state;
        echo view('admin/header', $this->pageData);
        echo view('admin/state/all');
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
                $this->StateModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['final_form'] = $this->StateModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);

        echo view('admin/state/add');
        echo view('admin/footer');
    }

    public function copy($state_id)
    {
        $state = $this->StateModel->copy($state_id);
        return redirect()->to(base_url('State', 'refresh'));
    }

    public function detail($state_id)
    {
        $where = [
            'state.state_id' => $state_id,
        ];
        $state = $this->StateModel->getWhere($where)[0];
        $this->pageData['state'] = $state;

        $field = $this->StateModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $state,
            'banner'
        );

        $area = $this->AreaModel->getWhere(['area.state_id' => $state_id]);
        // dd($model);
        $field = $this->AreaModel->get_field(
            [
                'model_id',
                'created_by',
                'modified_by',
                'deleted',
                'brand_id',
                'area_id',
                'state_id',
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
            'state_id',
            $state_id
        );

        $this->pageData['modal_area'] = $modal_area;

        echo view('admin/header', $this->pageData);
        echo view('admin/state/detail');
        echo view('admin/footer');
    }

    public function edit($state_id)
    {
        $where = [
            'state.state_id' => $state_id,
        ];
        $this->pageData['state'] = $this->StateModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->StateModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->StateModel->generate_edit_input($state_id);
        $this->pageData[
            'final_form'
        ] = $this->StateModel->get_final_form_edit($state_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/state/edit');
        echo view('admin/footer');
    }

    public function delete($state_id)
    {
        $this->StateModel->softDelete($state_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

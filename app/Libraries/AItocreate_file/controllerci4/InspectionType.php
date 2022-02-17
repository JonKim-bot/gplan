<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\InspectionTypeModel;

class InspectionType extends BaseController
{
    public function __construct()
    {
        $this->InspectionTypeModel = new InspectionTypeModel();
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
        $inspection_type = $this->InspectionTypeModel->getAll();
        // dd($inspection_type);
        $field = $this->InspectionTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $inspection_type,
            'inspection_type',
            'banner'
        );
        $this->pageData['inspection_type'] = $inspection_type;
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/all');
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
                $this->InspectionTypeModel->insertNew($data);

                return redirect()->to(base_url('InspectionType', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->InspectionTypeModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/add');
        echo view('admin/footer');
    }

    public function copy($inspection_type_id)
    {
        $inspection_type = $this->InspectionTypeModel->copy(
            $inspection_type_id
        );
        return redirect()->to(base_url('InspectionType', 'refresh'));
    }

    public function detail($inspection_type_id)
    {
        $where = [
            'inspection_type_id' => $inspection_type_id,
        ];
        $inspection_type = $this->InspectionTypeModel->getWhere($where)[0];
        $this->pageData['inspection_type'] = $inspection_type;

        $field = $this->InspectionTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $inspection_type,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/detail');
        echo view('admin/footer');
    }

    public function edit($inspection_type_id)
    {
        $where = [
            'inspection_type_id' => $inspection_type_id,
        ];
        $this->pageData[
            'inspection_type'
        ] = $this->InspectionTypeModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->InspectionTypeModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'InspectionType/detail/' . $inspection_type_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->InspectionTypeModel->generate_edit_input($inspection_type_id);
        $this->pageData[
            'final_form'
        ] = $this->InspectionTypeModel->get_final_form_edit(
            $inspection_type_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/edit');
        echo view('admin/footer');
    }

    public function delete($inspection_type_id)
    {
        $this->InspectionTypeModel->softDelete($inspection_type_id);
        // dd('asd');
        return redirect()->to(base_url('InspectionType', 'refresh'));
    }
}

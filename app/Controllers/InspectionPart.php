<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\InspectionPartModel;

class InspectionPart extends BaseController
{
    public function __construct()
    {
        $this->InspectionPartModel = new InspectionPartModel();
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
        $inspection_part = $this->InspectionPartModel->getAll();
        // dd($inspection_part);

        $field = $this->InspectionPartModel->get_field(
            [
                'created_by',
                'modified_by',
                'deleted',
                'inspection_type_id',
                'inspection_part_id',
            ],
            $inspection_part
        );
        $this->pageData['table'] = $this->generate_table(
            $field,
            $inspection_part,
            'inspection_part',
            'banner',
            0,
            'edit'
        );
        $this->pageData['inspection_part'] = $inspection_part;
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_part/all');
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
                $this->InspectionPartModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->InspectionPartModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_part/add');
        echo view('admin/footer');
    }

    public function copy($inspection_part_id)
    {
        $inspection_part = $this->InspectionPartModel->copy(
            $inspection_part_id,
            ['inspection_type']
        );
        return redirect()->to(base_url('InspectionPart', 'refresh'));
    }

    public function detail($inspection_part_id)
    {
        $where = [
            
            'inspection_part.inspection_part_id' => $inspection_part_id,
        ];
        $inspection_part = $this->InspectionPartModel->getWhere($where)[0];
        $this->pageData['inspection_part'] = $inspection_part;

        $field = $this->InspectionPartModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            
            $field,
            $inspection_part,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_part/detail');
        echo view('admin/footer');
    }

    public function edit($inspection_part_id)
    {
        $where = [
            'inspection_part.inspection_part_id' => $inspection_part_id,
        ];
        $this->pageData[
            'inspection_part'
        ] = $this->InspectionPartModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->InspectionPartModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->InspectionPartModel->generate_edit_input($inspection_part_id);
        $this->pageData[
            'final_form'
        ] = $this->InspectionPartModel->get_final_form_edit(
            $inspection_part_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_part/edit');
        echo view('admin/footer');
    }

    public function delete($inspection_part_id)
    {
        $this->InspectionPartModel->softDelete($inspection_part_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

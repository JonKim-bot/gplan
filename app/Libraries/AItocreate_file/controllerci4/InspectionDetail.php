<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\InspectionDetailModel;

class InspectionDetail extends BaseController
{
    public function __construct()
    {
        $this->InspectionDetailModel = new InspectionDetailModel();
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
        $inspection_detail = $this->InspectionDetailModel->getAll();
        // dd($inspection_detail);
        $field = $this->InspectionDetailModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $inspection_detail,
            'inspection_detail',
            'banner'
        );
        $this->pageData['inspection_detail'] = $inspection_detail;
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_detail/all');
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
                $this->InspectionDetailModel->insertNew($data);

                return redirect()->to(base_url('InspectionDetail', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->InspectionDetailModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_detail/add');
        echo view('admin/footer');
    }

    public function copy($inspection_detail_id)
    {
        $inspection_detail = $this->InspectionDetailModel->copy(
            $inspection_detail_id
        );
        return redirect()->to(base_url('InspectionDetail', 'refresh'));
    }

    public function detail($inspection_detail_id)
    {
        $where = [
            'inspection_detail_id' => $inspection_detail_id,
        ];
        $inspection_detail = $this->InspectionDetailModel->getWhere($where)[0];
        $this->pageData['inspection_detail'] = $inspection_detail;

        $field = $this->InspectionDetailModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $inspection_detail,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_detail/detail');
        echo view('admin/footer');
    }

    public function edit($inspection_detail_id)
    {
        $where = [
            'inspection_detail_id' => $inspection_detail_id,
        ];
        $this->pageData[
            'inspection_detail'
        ] = $this->InspectionDetailModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->InspectionDetailModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'InspectionDetail/detail/' . $inspection_detail_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->InspectionDetailModel->generate_edit_input($inspection_detail_id);
        $this->pageData[
            'final_form'
        ] = $this->InspectionDetailModel->get_final_form_edit(
            $inspection_detail_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_detail/edit');
        echo view('admin/footer');
    }

    public function delete($inspection_detail_id)
    {
        $this->InspectionDetailModel->softDelete($inspection_detail_id);
        // dd('asd');
        return redirect()->to(base_url('InspectionDetail', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\QnaTypeModel;

class QnaType extends BaseController
{
    public function __construct()
    {
        $this->QnaTypeModel = new QnaTypeModel();
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
        $qna_type = $this->QnaTypeModel->getAll();
        // dd($qna_type);
        $field = $this->QnaTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $qna_type,
            'qna_type',
            'banner'
        );
        $this->pageData['qna_type'] = $qna_type;
        echo view('admin/header', $this->pageData);
        echo view('admin/qna_type/all');
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
                $this->QnaTypeModel->insertNew($data);

                return redirect()->to(base_url('QnaType', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->QnaTypeModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/qna_type/add');
        echo view('admin/footer');
    }

    public function copy($qna_type_id)
    {
        $qna_type = $this->QnaTypeModel->copy($qna_type_id);
        return redirect()->to(base_url('QnaType', 'refresh'));
    }

    public function detail($qna_type_id)
    {
        $where = [
            'qna_type_id' => $qna_type_id,
        ];
        $qna_type = $this->QnaTypeModel->getWhere($where)[0];
        $this->pageData['qna_type'] = $qna_type;

        $field = $this->QnaTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $qna_type,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/qna_type/detail');
        echo view('admin/footer');
    }

    public function edit($qna_type_id)
    {
        $where = [
            'qna_type_id' => $qna_type_id,
        ];
        $this->pageData['qna_type'] = $this->QnaTypeModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->QnaTypeModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('QnaType/detail/' . $qna_type_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->QnaTypeModel->generate_edit_input($qna_type_id);
        $this->pageData[
            'final_form'
        ] = $this->QnaTypeModel->get_final_form_edit($qna_type_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/qna_type/edit');
        echo view('admin/footer');
    }

    public function delete($qna_type_id)
    {
        $this->QnaTypeModel->softDelete($qna_type_id);
        // dd('asd');
        return redirect()->to(base_url('QnaType', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\QnaModel;

class Qna extends BaseController
{
    public function __construct()
    {
        $this->QnaModel = new QnaModel();
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
        $qna = $this->QnaModel->getAll();
        // dd($qna);
        $field = $this->QnaModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $qna,
            'qna',
            'banner'
        );
        $this->pageData['qna'] = $qna;
        echo view('admin/header', $this->pageData);
        echo view('admin/qna/all');
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
                $this->QnaModel->insertNew($data);

                return redirect()->to(base_url('Qna', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->QnaModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/qna/add');
        echo view('admin/footer');
    }

    public function copy($qna_id)
    {
        $qna = $this->QnaModel->copy($qna_id);
        return redirect()->to(base_url('Qna', 'refresh'));
    }

    public function detail($qna_id)
    {
        $where = [
            'qna_id' => $qna_id,
        ];
        $qna = $this->QnaModel->getWhere($where)[0];
        $this->pageData['qna'] = $qna;

        $field = $this->QnaModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $qna,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/qna/detail');
        echo view('admin/footer');
    }

    public function edit($qna_id)
    {
        $where = [
            'qna_id' => $qna_id,
        ];
        $this->pageData['qna'] = $this->QnaModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->QnaModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Qna/detail/' . $qna_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->QnaModel->generate_edit_input($qna_id);
        $this->pageData[
            'final_form'
        ] = $this->QnaModel->get_final_form_edit($qna_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/qna/edit');
        echo view('admin/footer');
    }

    public function delete($qna_id)
    {
        $this->QnaModel->softDelete($qna_id);
        // dd('asd');
        return redirect()->to(base_url('Qna', 'refresh'));
    }
}

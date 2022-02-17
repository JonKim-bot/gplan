<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DepositDeductRecordModel;

class DepositDeductRecord extends BaseController
{
    public function __construct()
    {
        $this->DepositDeductRecordModel = new DepositDeductRecordModel();
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
        $deposit_deduct_record = $this->DepositDeductRecordModel->getAll();
        // dd($deposit_deduct_record);
        $field = $this->DepositDeductRecordModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $deposit_deduct_record,
            'deposit_deduct_record',
            'banner'
        );
        $this->pageData['deposit_deduct_record'] = $deposit_deduct_record;
        echo view('admin/header', $this->pageData);
        echo view('admin/deposit_deduct_record/all');
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
                $this->DepositDeductRecordModel->insertNew($data);

                return redirect()->to(
                    base_url('DepositDeductRecord', 'refresh')
                );
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->DepositDeductRecordModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/deposit_deduct_record/add');
        echo view('admin/footer');
    }

    public function copy($deposit_deduct_record_id)
    {
        $deposit_deduct_record = $this->DepositDeductRecordModel->copy(
            $deposit_deduct_record_id
        );
        return redirect()->to(base_url('DepositDeductRecord', 'refresh'));
    }

    public function detail($deposit_deduct_record_id)
    {
        $where = [
            'deposit_deduct_record_id' => $deposit_deduct_record_id,
        ];
        $deposit_deduct_record = $this->DepositDeductRecordModel->getWhere(
            $where
        )[0];
        $this->pageData['deposit_deduct_record'] = $deposit_deduct_record;

        $field = $this->DepositDeductRecordModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $deposit_deduct_record,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/deposit_deduct_record/detail');
        echo view('admin/footer');
    }

    public function edit($deposit_deduct_record_id)
    {
        $where = [
            'deposit_deduct_record_id' => $deposit_deduct_record_id,
        ];
        $this->pageData[
            'deposit_deduct_record'
        ] = $this->DepositDeductRecordModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->DepositDeductRecordModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'DepositDeductRecord/detail/' .
                            $deposit_deduct_record_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->DepositDeductRecordModel->generate_edit_input($deposit_deduct_record_id);
        $this->pageData[
            'final_form'
        ] = $this->DepositDeductRecordModel->get_final_form_edit(
            $deposit_deduct_record_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/deposit_deduct_record/edit');
        echo view('admin/footer');
    }

    public function delete($deposit_deduct_record_id)
    {
        $this->DepositDeductRecordModel->softDelete($deposit_deduct_record_id);
        // dd('asd');
        return redirect()->to(base_url('DepositDeductRecord', 'refresh'));
    }
}

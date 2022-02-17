<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\TransferFeeModel;

class TransferFee extends BaseController
{
    public function __construct()
    {
        $this->TransferFeeModel = new TransferFeeModel();
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
        $transfer_fee = $this->TransferFeeModel->getAll();
        // dd($transfer_fee);
        $field = $this->TransferFeeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $transfer_fee,
            'transfer_fee',
            'banner'
        );
        $this->pageData['transfer_fee'] = $transfer_fee;
        echo view('admin/header', $this->pageData);
        echo view('admin/transfer_fee/all');
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
                $this->TransferFeeModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->TransferFeeModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/transfer_fee/add');
        echo view('admin/footer');
    }

    public function copy($transfer_fee_id)
    {
        $transfer_fee = $this->TransferFeeModel->copy($transfer_fee_id);
        return redirect()->to(base_url('TransferFee', 'refresh'));
    }

    public function detail($transfer_fee_id)
    {
        $where = [
            'transfer_fee.transfer_fee_id' => $transfer_fee_id,
        ];
        $transfer_fee = $this->TransferFeeModel->getWhere($where)[0];
        $this->pageData['transfer_fee'] = $transfer_fee;

        $field = $this->TransferFeeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $transfer_fee,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/transfer_fee/detail');
        echo view('admin/footer');
    }

    public function edit($transfer_fee_id)
    {
        $where = [
            'transfer_fee.transfer_fee_id' => $transfer_fee_id,
        ];
        $this->pageData['transfer_fee'] = $this->TransferFeeModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->TransferFeeModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->TransferFeeModel->generate_edit_input($transfer_fee_id);
        $this->pageData[
            'final_form'
        ] = $this->TransferFeeModel->get_final_form_edit($transfer_fee_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/transfer_fee/edit');
        echo view('admin/footer');
    }

    public function delete($transfer_fee_id)
    {
        $this->TransferFeeModel->softDelete($transfer_fee_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

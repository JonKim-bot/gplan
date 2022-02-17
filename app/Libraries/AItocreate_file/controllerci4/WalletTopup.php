<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\WalletTopupModel;

class WalletTopup extends BaseController
{
    public function __construct()
    {
        $this->WalletTopupModel = new WalletTopupModel();
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
        $wallet_topup = $this->WalletTopupModel->getAll();
        // dd($wallet_topup);
        $field = $this->WalletTopupModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $wallet_topup,
            'wallet_topup',
            'banner'
        );
        $this->pageData['wallet_topup'] = $wallet_topup;
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/all');
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
                $this->WalletTopupModel->insertNew($data);

                return redirect()->to(base_url('WalletTopup', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->WalletTopupModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/add');
        echo view('admin/footer');
    }

    public function copy($wallet_topup_id)
    {
        $wallet_topup = $this->WalletTopupModel->copy($wallet_topup_id);
        return redirect()->to(base_url('WalletTopup', 'refresh'));
    }

    public function detail($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];
        $wallet_topup = $this->WalletTopupModel->getWhere($where)[0];
        $this->pageData['wallet_topup'] = $wallet_topup;

        $field = $this->WalletTopupModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $wallet_topup,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/detail');
        echo view('admin/footer');
    }

    public function edit($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];
        $this->pageData['wallet_topup'] = $this->WalletTopupModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->WalletTopupModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'WalletTopup/detail/' . $wallet_topup_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->WalletTopupModel->generate_edit_input($wallet_topup_id);
        $this->pageData[
            'final_form'
        ] = $this->WalletTopupModel->get_final_form_edit($wallet_topup_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/edit');
        echo view('admin/footer');
    }

    public function delete($wallet_topup_id)
    {
        $this->WalletTopupModel->softDelete($wallet_topup_id);
        // dd('asd');
        return redirect()->to(base_url('WalletTopup', 'refresh'));
    }
}

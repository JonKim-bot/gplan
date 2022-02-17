<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\WalletModel;

class Wallet extends BaseController
{
    public function __construct()
    {
        $this->WalletModel = new WalletModel();
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
        $wallet = $this->WalletModel->getAll();
        // dd($wallet);
        $field = $this->WalletModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $wallet,
            'wallet',
            'banner'
        );
        $this->pageData['wallet'] = $wallet;
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet/all');
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
                $this->WalletModel->insertNew($data);

                return redirect()->to(base_url('Wallet', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->WalletModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet/add');
        echo view('admin/footer');
    }

    public function copy($wallet_id)
    {
        $wallet = $this->WalletModel->copy($wallet_id);
        return redirect()->to(base_url('Wallet', 'refresh'));
    }

    public function detail($wallet_id)
    {
        $where = [
            'wallet_id' => $wallet_id,
        ];
        $wallet = $this->WalletModel->getWhere($where)[0];
        $this->pageData['wallet'] = $wallet;

        $field = $this->WalletModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $wallet,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet/detail');
        echo view('admin/footer');
    }

    public function edit($wallet_id)
    {
        $where = [
            'wallet_id' => $wallet_id,
        ];
        $this->pageData['wallet'] = $this->WalletModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->WalletModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Wallet/detail/' . $wallet_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->WalletModel->generate_edit_input($wallet_id);
        $this->pageData[
            'final_form'
        ] = $this->WalletModel->get_final_form_edit($wallet_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet/edit');
        echo view('admin/footer');
    }

    public function delete($wallet_id)
    {
        $this->WalletModel->softDelete($wallet_id);
        // dd('asd');
        return redirect()->to(base_url('Wallet', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\BidModel;

class Bid extends BaseController
{
    public function __construct()
    {
        $this->BidModel = new BidModel();
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
        $bid = $this->BidModel->getAll();
        // dd($bid);
        $field = $this->BidModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $bid,
            'bid',
            'banner'
        );
        $this->pageData['bid'] = $bid;
        echo view('admin/header', $this->pageData);
        echo view('admin/bid/all');
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
                $this->BidModel->insertNew($data);

                return redirect()->to(base_url('Bid', 'refresh'));
            }
        }

        $this->pageData['final_form'] = $this->BidModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/bid/add');
        echo view('admin/footer');
    }

    public function copy($bid_id)
    {
        $bid = $this->BidModel->copy($bid_id);
        return redirect()->to(base_url('Bid', 'refresh'));
    }

    public function detail($bid_id)
    {
        $where = [
            'bid_id' => $bid_id,
        ];
        $bid = $this->BidModel->getWhere($where)[0];
        $this->pageData['bid'] = $bid;

        $field = $this->BidModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $bid,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/bid/detail');
        echo view('admin/footer');
    }

    public function edit($bid_id)
    {
        $where = [
            'bid_id' => $bid_id,
        ];
        $this->pageData['bid'] = $this->BidModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->BidModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Bid/detail/' . $bid_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->BidModel->generate_edit_input($bid_id);
        $this->pageData[
            'final_form'
        ] = $this->BidModel->get_final_form_edit($bid_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/bid/edit');
        echo view('admin/footer');
    }

    public function delete($bid_id)
    {
        $this->BidModel->softDelete($bid_id);
        // dd('asd');
        return redirect()->to(base_url('Bid', 'refresh'));
    }
}

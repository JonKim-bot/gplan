<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AuctionStatusModel;

class AuctionStatus extends BaseController
{
    public function __construct()
    {
        $this->AuctionStatusModel = new AuctionStatusModel();
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
        $auction_status = $this->AuctionStatusModel->getAll();
        // dd($auction_status);
        $field = $this->AuctionStatusModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $auction_status,
            'auction_status',
            'banner'
        );
        $this->pageData['auction_status'] = $auction_status;
        echo view('admin/header', $this->pageData);
        echo view('admin/auction_status/all');
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
                $this->AuctionStatusModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->AuctionStatusModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/auction_status/add');
        echo view('admin/footer');
    }

    public function copy($auction_status_id)
    {
        $auction_status = $this->AuctionStatusModel->copy($auction_status_id);
        return redirect()->to(base_url('AuctionStatus', 'refresh'));
    }

    public function detail($auction_status_id)
    {
        $where = [
            'auction_status.auction_status_id' => $auction_status_id,
        ];
        $auction_status = $this->AuctionStatusModel->getWhere($where)[0];
        $this->pageData['auction_status'] = $auction_status;

        $field = $this->AuctionStatusModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $auction_status,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/auction_status/detail');
        echo view('admin/footer');
    }

    public function edit($auction_status_id)
    {
        $where = [
            'auction_status.auction_status_id' => $auction_status_id,
        ];
        $this->pageData['auction_status'] = $this->AuctionStatusModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->AuctionStatusModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->AuctionStatusModel->generate_edit_input($auction_status_id);
        $this->pageData[
            'final_form'
        ] = $this->AuctionStatusModel->get_final_form_edit($auction_status_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/auction_status/edit');
        echo view('admin/footer');
    }

    public function delete($auction_status_id)
    {
        $this->AuctionStatusModel->softDelete($auction_status_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

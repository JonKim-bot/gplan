<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AuctionModel;

class Auction extends BaseController
{
    public function __construct()
    {
        $this->AuctionModel = new AuctionModel();
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
        $auction = $this->AuctionModel->getAll();
        // dd($auction);
        $field = $this->AuctionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $auction,
            'auction',
            'banner'
        );
        $this->pageData['auction'] = $auction;
        echo view('admin/header', $this->pageData);
        echo view('admin/auction/all');
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
                $this->AuctionModel->insertNew($data);

                return redirect()->to(base_url('Auction', 'refresh'));
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->AuctionModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/auction/add');
        echo view('admin/footer');
    }

    public function copy($auction_id)
    {
        $auction = $this->AuctionModel->copy($auction_id);
        return redirect()->to(base_url('Auction', 'refresh'));
    }

    public function detail($auction_id)
    {
        $where = [
            'auction_id' => $auction_id,
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        $this->pageData['auction'] = $auction;

        $field = $this->AuctionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $auction,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/auction/detail');
        echo view('admin/footer');
    }

    public function edit($auction_id)
    {
        $where = [
            'auction_id' => $auction_id,
        ];
        $this->pageData['auction'] = $this->AuctionModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->AuctionModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('Auction/detail/' . $auction_id, 'refresh')
                );
            }
        }

        // $this->pageData['form'] = $this->AuctionModel->generate_edit_input($auction_id);
        $this->pageData[
            'final_form'
        ] = $this->AuctionModel->get_final_form_edit($auction_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/auction/edit');
        echo view('admin/footer');
    }

    public function delete($auction_id)
    {
        $this->AuctionModel->softDelete($auction_id);
        // dd('asd');
        return redirect()->to(base_url('Auction', 'refresh'));
    }
}

<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AuctionIncrementModel;

class AuctionIncrement extends BaseController
{
    public function __construct()
    {
        $this->AuctionIncrementModel = new AuctionIncrementModel();
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
        $auction_increment = $this->AuctionIncrementModel->getAll();
        // dd($auction_increment);
        $field = $this->AuctionIncrementModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $auction_increment,
            'auction_increment',
            'banner'
        );
        $this->pageData['auction_increment'] = $auction_increment;
        echo view('admin/header', $this->pageData);
        echo view('admin/auction_increment/all');
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
                $this->AuctionIncrementModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->AuctionIncrementModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/auction_increment/add');
        echo view('admin/footer');
    }

    public function copy($auction_increment_id)
    {
        $auction_increment = $this->AuctionIncrementModel->copy(
            $auction_increment_id
        );
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function detail($auction_increment_id)
    {
        $where = [
            'auction_increment.auction_increment_id' => $auction_increment_id,
        ];
        $auction_increment = $this->AuctionIncrementModel->getWhere($where)[0];
        $this->pageData['auction_increment'] = $auction_increment;

        $field = $this->AuctionIncrementModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $auction_increment,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/auction_increment/detail');
        echo view('admin/footer');
    }

    public function edit($auction_increment_id)
    {
        $where = [
            'auction_increment.auction_increment_id' => $auction_increment_id,
        ];
        $this->pageData[
            'auction_increment'
        ] = $this->AuctionIncrementModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->AuctionIncrementModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->AuctionIncrementModel->generate_edit_input($auction_increment_id);
        $this->pageData[
            'final_form'
        ] = $this->AuctionIncrementModel->get_final_form_edit(
            $auction_increment_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/auction_increment/edit');
        echo view('admin/footer');
    }

    public function delete($auction_increment_id)
    {
        $this->AuctionIncrementModel->softDelete($auction_increment_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

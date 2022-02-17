<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\BestOfferModel;

class BestOffer extends BaseController
{
    public function __construct()
    {
        $this->BestOfferModel = new BestOfferModel();
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
        $best_offer = $this->BestOfferModel->getAll();
        // dd($best_offer);
        // $field = $this->BestOfferModel->get_field(
        //     [
        //         'created_by',
        //         'modified_by',
        //         'deleted',
        //         'model_id',
        //         'best_offer_id',
        //         'brand_id',
        //     ],
        //     $best_offer
        // );
        // $this->pageData['table'] = $this->generate_table(
        //     $field,
        //     $best_offer,
        //     'best_offer',
        //     'banner'
        // );
        $this->pageData['best_offer'] = $best_offer;
        echo view('admin/header', $this->pageData);
        echo view('admin/best_offer/all');
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
                $this->BestOfferModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->BestOfferModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/best_offer/add');
        echo view('admin/footer');
    }

    public function copy($best_offer_id)
    {
        $best_offer = $this->BestOfferModel->copy($best_offer_id, [
            'brand',
            'model',
        ]);
        return redirect()->to(base_url('BestOffer', 'refresh'));
    }

    public function detail($best_offer_id)
    {
        $where = [
            'best_offer.best_offer_id' => $best_offer_id,
        ];
        $best_offer = $this->BestOfferModel->getWhere($where)[0];

        $data = [
            'is_read' => 1,
        ];
        $this->BestOfferModel->updateWhere($where,$data);

        $this->pageData['best_offer'] = $best_offer;

        // $field = $this->BestOfferModel->get_field([
        //     'created_by',
        //     'modified_by',
        //     'deleted',
        // ]);
        // $this->pageData['detail'] = $this->generate_detail(
        //     $field,
        //     $best_offer,
        //     'banner'
        // );

        echo view('admin/header', $this->pageData);
        echo view('admin/best_offer/detail');
        echo view('admin/footer');
    }

    public function edit($best_offer_id)
    {
        $where = [
            'best_offer.best_offer_id' => $best_offer_id,
        ];
        $this->pageData['best_offer'] = $this->BestOfferModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->BestOfferModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->BestOfferModel->generate_edit_input($best_offer_id);
        $this->pageData[
            'final_form'
        ] = $this->BestOfferModel->get_final_form_edit($best_offer_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/best_offer/edit');
        echo view('admin/footer');
    }

    public function delete($best_offer_id)
    {
        $this->BestOfferModel->softDelete($best_offer_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

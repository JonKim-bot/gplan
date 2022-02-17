<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\BannerModel;

class Banner extends BaseController
{
    public function __construct()
    {
        $this->BannerModel = new BannerModel();
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

    public function change_title($banner_id)
    {
        $where = [
            'banner_id' => $banner_id,
        ];
        $auction = $this->BannerModel->getWhere($where)[0];
        $is_title = 0;
        if ($auction['is_title'] == 1) {
            $is_title = 0;
        } else {
            $is_title = 1;
        }
        $this->BannerModel->updateWhere($where, ['is_title' => $is_title]);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function index()
    {
        $banner = $this->BannerModel->getAll();
        // dd($banner);
        $field = $this->BannerModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'is_title',
            'banner',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $banner,
            'banner',
            'image'
        );
        $this->pageData['banner'] = $banner;
        echo view('admin/header', $this->pageData);
        echo view('admin/banner/all');
        echo view('admin/footer');
    }

    public function add()
    {
        if ($_POST) {
            $error = false;


            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'image');
                // dd($data);
                $this->BannerModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['final_form'] = $this->BannerModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/banner/add');
        echo view('admin/footer');
    }

    public function copy($banner_id)
    {
        $banner = $this->BannerModel->copy($banner_id);
        return redirect()->to(base_url('Banner', 'refresh'));
    }

    public function detail($banner_id)
    {
        $where = [
            'banner.banner_id' => $banner_id,
        ];
        $banner = $this->BannerModel->getWhere($where)[0];
        $this->pageData['banner'] = $banner;

        $field = $this->BannerModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'banner',

        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $banner,
            'image'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/banner/detail');
        echo view('admin/footer');
    }

    public function edit($banner_id)
    {
        $where = [
            'banner.banner_id' => $banner_id,
        ];
        $this->pageData['banner'] = $this->BannerModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'image');

                $this->BannerModel->updateWhere($where, $data);


                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->BannerModel->generate_edit_input($banner_id);
        $this->pageData[
            'final_form'
        ] = $this->BannerModel->get_final_form_edit($banner_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/banner/edit');
        echo view('admin/footer');
    }

    public function delete($banner_id)
    {
        $this->BannerModel->softDelete($banner_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

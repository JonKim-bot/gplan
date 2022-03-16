<?php




namespace App\Controllers;

use App\Core\BaseController;
use App\Models\BannerModel;

class Banner extends BaseController
{
    public function __construct()
    {
        $this->pageData = [];

        $this->BannerModel = new BannerModel();
        if (

            session()->get('login_data') == null &&
            uri_string() != 'access/login'
        ) {
            //  redirect()->to(base_url('access/login/'));
            echo "<script>location.href='" .
                base_url() .
                "/access/loginAdmin';</script>";


        }


    }
    
    public function index()
    {

        $banner = $this->BannerModel->getWhere(['type_id' => 0]);
        // dd($banner);
        $field = $this->BannerModel->get_field(['created_by','modified_by','type_id','type','title','deleted','link']);

        $this->pageData['table'] = $this->generate_table($field,$banner,'banner','banner');
        $this->pageData['banner'] = $banner;
        echo view('admin/header', $this->pageData);

        echo view('admin/banner/all');
        echo view('admin/footer');
    }

    public function add()
    {
        if ($_FILES) {

            $error = false;

            
            if (!$error) {
                $data = $this->get_insert_data($_POST);
                
                $data = $this->upload_image_with_data($data,'banner');
                // dd($data);
                $this->BannerModel->insertNew($data);

                return redirect()->to(base_url('banner', 'refresh'));
            }
        }

        $this->pageData['form'] = $this->BannerModel->generate_input();

        echo view('admin/header', $this->pageData);
        echo view('admin/banner/add');
        echo view('admin/footer');
    }

    public function copy($banner_id){
        $where = [
            'banner_id' => $banner_id,
        ];
        $banner = $this->BannerModel->getWhere($where)[0];
        unset($banner['banner_id']);
        $this->BannerModel->insertNew($banner);
        return redirect()->to(base_url('banner', 'refresh'));

    }

    public function detail($banner_id)
    {
        $where = [
            'banner_id' => $banner_id,
        ];
        $banner = $this->BannerModel->getWhere($where)[0];
        $this->pageData['banner'] = $banner;
        $field = $this->BannerModel->get_field(['created_by','modified_by','type_id','title','deleted']);
        $this->pageData['detail'] = $this->generate_detail($field,$banner,'banner');

        echo view('admin/header', $this->pageData);
        echo view('admin/banner/detail');
        echo view('admin/footer');
    }

    public function qrcode()
    {
        $where = [
            'type_id' => 1,
        ];
        $this->pageData['banner'] = $this->BannerModel->getWhere($where)[0];
      
        if ($_POST) {
            $error = false;

            if (!$error) {

                $data = $this->get_update_data($_POST,['asd']);
                
                $data = $this->upload_image_with_data($data,'banner');

                $this->BannerModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('banner/qrcode', 'refresh')
                );
            }
        }

        echo view('admin/header', $this->pageData);
        echo view('admin/banner/edit_qr');
        echo view('admin/footer');
    }

    public function edit($banner_id)
    {
        $where = [
            'banner_id' => $banner_id,
        ];
        $this->pageData['banner'] = $this->BannerModel->getWhere($where)[0];
      
        if ($_FILES) {
            $error = false;

            if (!$error) {

                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data,'banner');

                $this->BannerModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url('banner/detail/' . $banner_id, 'refresh')
                );
            }
        }

        $this->pageData['form'] = $this->BannerModel->generate_edit_input($banner_id);

        echo view('admin/header', $this->pageData);
        echo view('admin/banner/edit');
        echo view('admin/footer');
    }

    public function delete($banner_id)
    {
        $this->BannerModel->softDelete($banner_id);

        return redirect()->to(base_url('banner', 'refresh'));
    }
}


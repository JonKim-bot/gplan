<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\GetInTouchModel;

class GetInTouch extends BaseController
{
    public function __construct()
    {
        $this->GetInTouchModel = new GetInTouchModel();
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
        $get_in_touch = $this->GetInTouchModel->getAll();
        // dd($get_in_touch);
        // $field = $this->GetInTouchModel->get_field([
        //     'created_by',
        //     'modified_by',
        //     'deleted',
        // ]);
        // $this->pageData['table'] = $this->generate_table(
        //     $field,
        //     $get_in_touch,
        //     'get_in_touch',
        //     'banner'
        // );
        $this->pageData['get_in_touch'] = $get_in_touch;
        echo view('admin/header', $this->pageData);
        echo view('admin/get_in_touch/all');
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
                $this->GetInTouchModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->GetInTouchModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/get_in_touch/add');
        echo view('admin/footer');
    }

    public function copy($get_in_touch_id)
    {
        $get_in_touch = $this->GetInTouchModel->copy($get_in_touch_id);
        return redirect()->to(base_url('GetInTouch', 'refresh'));
    }

    public function detail($get_in_touch_id)
    {
        $where = [
            'get_in_touch.get_in_touch_id' => $get_in_touch_id,
        ];
        $get_in_touch = $this->GetInTouchModel->getWhere($where)[0];


        $data = [
            'is_read' => 1,
        ];
        $this->GetInTouchModel->updateWhere($where,$data);

        $this->pageData['get_in_touch'] = $get_in_touch;

        $field = $this->GetInTouchModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $get_in_touch,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/get_in_touch/detail');
        echo view('admin/footer');
    }

    public function edit($get_in_touch_id)
    {
        $where = [
            'get_in_touch.get_in_touch_id' => $get_in_touch_id,
        ];
        $this->pageData['get_in_touch'] = $this->GetInTouchModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->GetInTouchModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->GetInTouchModel->generate_edit_input($get_in_touch_id);
        $this->pageData[
            'final_form'
        ] = $this->GetInTouchModel->get_final_form_edit($get_in_touch_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/get_in_touch/edit');
        echo view('admin/footer');
    }

    public function delete($get_in_touch_id)
    {
        $this->GetInTouchModel->softDelete($get_in_touch_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

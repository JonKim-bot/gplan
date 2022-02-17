<?php



namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarInspectionModel;
use App\Models\CarInspectionImageModel;

class CarInspection extends BaseController
{
    public function __construct()
    {
        $this->CarInspectionModel = new CarInspectionModel();

        $this->CarInspectionImageModel = new CarInspectionImageModel();
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

    public function reset($car_inspection_detail_id)
    {
        $key = $_GET['key'];
        $car_inspection_type_id = $_GET['car_inspection_type'];
        $car_id = $_GET['car_id'];

        $where = [
            'car_inspection.car_inspection_id' => $car_inspection_detail_id,
        ];
        $car_inspection_detail = $this->CarInspectionModel->getWhere($where)[0];
        // dd($car_inspection_detail);
        $status_id = 0;
        $car_inspection_detail = $this->CarInspectionModel->updateWhere(
            $where,
            ['status_id' => $status_id]
        );
        // return redirect()->to($_SERVER['HTTP_REFERER']);
        return redirect()->to(
            base_url(
                '/InspectionType/detail/' .
                    $car_inspection_type_id .
                    "/$car_id?car_id=$car_id&key=$key&car_inspection_type_id=$car_inspection_type_id",
                'refresh'
            )
        );
    }
   
    public function mark_pass_fail_status()
    {
        // $key = $_GET['key'];
        // $car_inspection_type_id = $_GET['car_inspection_type'];
        // $car_id = $_GET['car_id'];
        $car_inspection_detail_id = $_POST['car_inspection_id'];
        $status_id = $_POST['status_id'];

        $where = [
            'car_inspection.car_inspection_id' => $car_inspection_detail_id,
        ];
        $car_inspection_detail = $this->CarInspectionModel->getWhere($where)[0];
        // dd($car_inspection_detail);
     
        $car_inspection_detail = $this->CarInspectionModel->updateWhere(
            $where,
            ['status_id' => $status_id]
        );
        


    die(json_encode([

            'status' => true,
            'data' => $_POST,
        ]));
    }
    public function mark_pass_fail($car_inspection_detail_id, $is_na = 0)
    {
        $key = $_GET['key'];
        $car_inspection_type_id = $_GET['car_inspection_type'];
        $car_id = $_GET['car_id'];

        $where = [
            'car_inspection.car_inspection_id' => $car_inspection_detail_id,
        ];
        $car_inspection_detail = $this->CarInspectionModel->getWhere($where)[0];
        // dd($car_inspection_detail);
        if ($car_inspection_detail['status_id'] == 1) {
            $status_id = 2;
        } else {
            $status_id = 1;
        }

        if ($is_na != 0) {
            $status_id = 3;
        }

        $car_inspection_detail = $this->CarInspectionModel->updateWhere(
            $where,
            ['status_id' => $status_id]
        );

        // die


        // return redirect()->to($_SERVER['HTTP_REFERER']);
        // return redirect()->to(
        //     base_url(
        //         '/InspectionType/detail/' .
        //             $car_inspection_type_id .
        //             "/$car_id?car_id=$car_id&key=$key&car_inspection_type_id=$car_inspection_type_id",
        //         'refresh'
        //     )
        // );
    }

    public function index()
    {
        $car_inspection = $this->CarInspectionModel->getAll();
        // dd($car_inspection);
        $field = $this->CarInspectionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_inspection,
            'car_inspection',
            'banner'
        );
        $this->pageData['car_inspection'] = $car_inspection;
        echo view('admin/header', $this->pageData);

        echo view('admin/car_inspection/all');
        echo view('admin/footer');
    }

    public function add_image()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST,['car_id','inspection_type_id','key']);

                $data = $this->upload_image_with_data($data, 'image');
                // dd($data);
                $this->CarInspectionImageModel->insertNew($data);

                return redirect()->to(base_url('InspectionType/detail/' . $_POST['inspection_type_id'] . '/' . $_POST['car_id'] . '?key=' . $_POST['key'] , "refresh"));

                // return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function add()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'banner');
                // dd($data);
                $this->CarInspectionModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->CarInspectionModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/add');
        echo view('admin/footer');
    }

    public function copy($car_inspection_id)
    {
        $car_inspection = $this->CarInspectionModel->copy($car_inspection_id);
        return redirect()->to(base_url('CarInspection', 'refresh'));
    }

    public function detail($car_inspection_id)
    {
        $where = [
            'car_inspection.car_inspection_id' => $car_inspection_id,
        ];
        $car_inspection = $this->CarInspectionModel->getWhere($where)[0];
        $this->pageData['car_inspection'] = $car_inspection;

        $field = $this->CarInspectionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car_inspection,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/detail');
        echo view('admin/footer');
    }

    public function edit($car_inspection_id)
    {
        $where = [
            'car_inspection.car_inspection_id' => $car_inspection_id,
        ];
        $this->pageData['car_inspection'] = $this->CarInspectionModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->CarInspectionModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->CarInspectionModel->generate_edit_input($car_inspection_id);
        $this->pageData[
            'final_form'
        ] = $this->CarInspectionModel->get_final_form_edit($car_inspection_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/car_inspection/edit');
        echo view('admin/footer');
    }
    public function delete_()

    {
        $this->CarInspectionModel->hardDelete( $_POST['car_inspection_id']);
        // dd('asd');
        die(json_encode([
            'status' => true,
        ]));

    }

    public function delete($car_inspection_id)
    {
        $this->CarInspectionModel->softDelete($car_inspection_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

<?php




namespace App\Controllers;

use App\Core\BaseController;
use App\Models\InspectionTypeModel;
use App\Models\InspectionPartModel;

use App\Models\InspectionDetailModel;
use App\Models\CarInspectionModel;


use App\Models\CarInspectionImageModel;

class InspectionType extends BaseController
{
    public function __construct()
    {
        
        $this->InspectionTypeModel = new InspectionTypeModel();
        $this->CarInspectionModel = new CarInspectionModel();

        $this->InspectionPartModel = new InspectionPartModel();

        $this->InspectionDetailModel = new InspectionDetailModel();
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

    public function index()
    {
        $inspection_type = $this->InspectionTypeModel->getAll();
        // dd($inspection_type);
        $field = $this->InspectionTypeModel->get_field([

            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $inspection_type,
            'inspection_type',
            'icon',
            0,
            'edit'
        );
        $this->pageData['inspection_type'] = $inspection_type;
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/all');
        echo view('admin/footer');
    }

    public function add()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'icon');
                // dd($data);
                $this->InspectionTypeModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->InspectionTypeModel->get_final_form_add([
            'created_by',
            'icon',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/add');
        echo view('admin/footer');
    }

    public function copy($inspection_type_id)
    {
        $inspection_type = $this->InspectionTypeModel->copy(
            $inspection_type_id
        );
        return redirect()->to(base_url('InspectionType', 'refresh'));
    }

    public function get_inspection_part()
    {
    
        if($_POST['inspection_detail_id'] > 0){
            
            $where = [
                'inspection_detail.inspection_detail_id' => $_POST['inspection_detail_id']
            ];
        }else{
            $where = [
                'car_inspection.car_inspection_id' => $_POST['car_inspection_id']
            ];
            $car_inspection = $this->CarInspectionModel->getWhereDeleted($where)[0];
            $where = [

                'inspection_detail.inspection_detail_id' => $car_inspection['inspection_detail_id']
            ];
        }


        $inspection_detail = $this->InspectionDetailModel->getWhere($where)[0];

        $where = [
            'inspection_part_id' => $inspection_detail['inspection_part_id'],
            'car_id' => $_POST['car_id'],
        ];


    $car_inspection_detail = $this->InspectionDetailModel->getWhereCar($where);

        $this->pageData['car_inspection_detail'] = $car_inspection_detail;
  
        $this->pageData['car_id'] = $_POST['car_id'];

        $row['inspection_part_id'] = $inspection_detail['inspection_part_id'];
        $this->pageData['row'] = $row;

        echo view('admin/inspection_type/get_inspection_part',$this->pageData);
    }

    public function get_percentage(){
        $inspection_part_id =$_POST['inspection_part_id'];
        $car_id =$_POST['car_id'];

        $where = [
            'inspection_part.inspection_part_id' => $inspection_part_id,

            'car_inspection.car_id' => $car_id,
        ];
        $car_inspection_part = $this->InspectionPartModel->getWith($where);
        // dd($car_inspection_part);
        die(json_encode([
            'status' => true,
            'data' => $car_inspection_part[0]
        ]));
    }

    public function detail($inspection_type_id, $car_id = 2)
    {
        $where = [
            'inspection_type.inspection_type_id' => $inspection_type_id,
        ];
        $inspection_type = $this->InspectionTypeModel->getWhere($where)[0];
        $this->pageData['inspection_type'] = $inspection_type;

        $field = $this->InspectionTypeModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,

            $inspection_type,
            'icon'
        );

        $where = [
            'inspection_part.inspection_type_id' => $inspection_type_id,
            'car_inspection.car_id' => $car_id,
        ];

        $car_inspection_part = $this->InspectionPartModel->getWith($where);
        foreach ($car_inspection_part as $key => $row) {
            
            $where = [
                'inspection_part_id' => $row['inspection_part_id'],
                'car_id' => $car_id,
            ];

            $car_inspection_part[$key][
                'car_inspection_detail'
            ] = $this->InspectionDetailModel->getWhereCar($where);


        // dd($where);

        }

        // dd($car_inspection_part);

        $this->pageData['car_inspection_part'] = $car_inspection_part;
        $this->pageData['car_id'] = $car_id;
        $this->pageData['inspection_type_id'] = $inspection_type_id;

        // $this->pageData['form_inspection_type'] = $this->CarInspectionDetailModel->generate_input();


        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/detail');
        echo view('admin/footer');
    }

    public function edit($inspection_type_id)
    {
        $where = [
            'inspection_type.inspection_type_id' => $inspection_type_id,
        ];
        $this->pageData[
            'inspection_type'
        ] = $this->InspectionTypeModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'icon');


                $this->InspectionTypeModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        // $this->pageData['form'] = $this->InspectionTypeModel->generate_edit_input($inspection_type_id);
        $this->pageData[
            'final_form'
        ] = $this->InspectionTypeModel->get_final_form_edit(
            $inspection_type_id,
            [
                'created_by',
                'icon',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/inspection_type/edit');
        echo view('admin/footer');
    }

    public function delete($inspection_type_id)
    {
        $this->InspectionTypeModel->softDelete($inspection_type_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

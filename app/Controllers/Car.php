<?php





namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarModel;
use App\Models\CarImageModel;
use App\Models\CarInspectionTypeModel;
use App\Models\InspectionTypeModel;
use App\Models\CarInspectionModel;  
use App\Models\WalletWithdrawModel;
use App\Models\CarStickerModel;
use App\Models\InspectionDetailModel;
use App\Models\StickerModel;
use App\Models\BrandModel;
use App\Models\ModelModel;
use App\Models\VariantModel;
use App\Models\AreaModel;
use App\ThirdParty\FPDF;

// use Ajaxray\PHPWatermark\Watermark;


class Car extends BaseController
{
    public function __construct()
    {



        $this->AreaModel = new AreaModel();

        $this->BrandModel = new BrandModel();
        $this->ModelModel = new ModelModel();
        $this->VariantModel = new VariantModel();

        $this->CarImageModel = new CarImageModel();
        $this->CarStickerModel = new CarStickerModel();
        $this->StickerModel = new StickerModel();

        $this->CarInspectionTypeModel = new CarInspectionTypeModel();
        $this->CarInspectionModel = new CarInspectionModel();
        $this->InspectionDetailModel = new InspectionDetailModel();

        $this->InspectionTypeModel = new InspectionTypeModel();
        $this->CarModel = new CarModel();

        $this->WalletWithdrawModel = new WalletWithdrawModel();

        $this->pageData['undone_withdraw'] = $this->WalletWithdrawModel->getCountOfUndone();

        
        if (
            session()->get('login_data') == null &&
            uri_string() != 'access/login'
        ) {
            //  redirect()->to(base_url('access/login/'));
            echo "<script>location.href='" .
                base_url() .
                "/access/login';</script>";
        }

        $this->generate_sticker();
    }
    public function search_matching_model(){
        $where = [
            'model.brand_id' => $_POST['brand_id']
        ];
        $model = $this->ModelModel->getWhere($where);
        $this->pageData['selected_model'] = isset($_POST['selected_model']) ? $_POST['selected_model'] : 0;

        $this->pageData['model'] = $model;

        echo view('admin/car/model_list', $this->pageData);

    }


    public function search_matching_variant(){
        $where = [
            'variant.model_id' => $_POST['model_id']
        ];
        $variant = $this->VariantModel->getWhere($where);
        $this->pageData['selected_variant'] = isset($_POST['selected_variant']) ? $_POST['selected_variant'] : 0;

        $this->pageData['variant'] = $variant;

        echo view('admin/car/variant_list', $this->pageData);

    }


    public function search_matching_area(){
        $where = [
            'area.state_id' => $_POST['state_id'],
        ];
        $area = $this->AreaModel->getWhere($where);
        $this->pageData['area'] = $area;
        $this->pageData['selected_area'] = isset($_POST['selected_area']) ? $_POST['selected_area'] : 0;

        echo view('admin/car/area_list', $this->pageData);

    }

    public function set_sticker_active($car_sticker_id){
        $where = [
            'car_sticker.car_sticker_id' => $car_sticker_id
        ];
        $car_sticker  = $this->CarStickerModel->getWhere($where)[0];
        if($car_sticker['is_active'] == 1) {
            $data = 0;
        }else{
            $data = 1;
        }
        

        $this->CarStickerModel->updateWhere($where,['is_active' => $data]);
        return redirect()->to($_SERVER['HTTP_REFERER']);

        
        
    }
    public function generate_sticker(){
        $sticker = $this->StickerModel->getAll();
        $car = $this->CarModel->getAll();



        foreach($sticker as $row){
            foreach($car as $row_car){
                $where = [
                    'car_sticker.car_id' => $row_car['car_id'],
                    'car_sticker.sticker_id' => $row['sticker_id'],
                ];

                $car_sticker = $this->CarStickerModel->getWhere($where);
                if(empty($car_sticker)){

                    $this->CarStickerModel->insertNew($where);
                }
            }
        }
    }
    


    public function index()
    {
        $car = $this->CarModel->getAll();
        // dd($car);
        $field = $this->CarModel->get_field(
            [
                'created_by',
                'modified_by',
                'deleted',
                'car_id',

                'model_id',
                'deposit_amount',
                'price',
                'color_id',
                'already_auction',
                'variant_id',
                'brand_id_copy',
                'no_of_seat',
                'no_of_previos_owner',
                'lisence_plate_no',
                'transmission_id',
                'area_id',
                'registation_card',
                'engine_no',
                'sticker',

                'state_id',
                'users_id',
            ],
            $car
        );


        $this->pageData['table'] = $this->generate_table(
            $field,
            $car,
            'car',
            'sticker'

        );


        $this->pageData['car'] = $car;
        echo view('admin/header', $this->pageData);
        echo view('admin/car/all');
        echo view('admin/footer');
    }

    public function add()

    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'sticker');
                // dd($data);

                $car_id = $this->CarModel->insertNew($data);

                $this->auto_insert_car_inspection_form($car_id);
                // return redirect()->to($_SERVER['HTTP_REFERER']);
                return redirect()->to(base_url('car/detail/' . $car_id . "?new_car=1", "refresh"));

            }
        }

        $this->pageData['final_form'] = $this->CarModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
            'sticker',
        ]);
        

        $this->pageData['brand'] = $this->BrandModel->getAll();

        $this->pageData['users'] = $this->UsersModel->getAll();

        // $this->pageData['brand'] = $this->BrandModel->getAll();
        // $this->pageData['brand'] = $this->BrandModel->getAll();

        // die(var_dump($this->pageData['form']));
        $this->pageData['form'] = $this->CarModel->generate_input();

        echo view('admin/header', $this->pageData);
        echo view('admin/car/add');
        echo view('admin/footer');
    }

    public function copy($car_id)
    {
        $car = $this->CarModel->copy($car_id);


        return redirect()->to(base_url('Car', 'refresh'));
    }

    public function detail($car_id)
    {

        $where = [
            'car.car_id' => $car_id,
        ];
        $this->auto_insert_car_inspection_form($car_id);

        $car = $this->CarModel->getWhere($where);

        $this->pageData['modified_by'] = $this->get_modified_by($car[0]['modified_by']);

        // dd($this->pageData['modified_by']);

        $this->pageData['car'] = $car[0];


        // $car_inspection = $this->CarModel->getInspectionSummary($car_id)[0];
        // $car_inspection_percentage = 0;
        // // dd($car_inspection);
        // if($car_inspection['total'] != 0){

        //     $car_inspection_percentage = $car_inspection['total_pass'] * 100 / $car_inspection['total'];
        // }

        $inspection = $this->CarInspectionModel->getSummary($car_id);

        $car_inspection_percentage = 0;
        if ($inspection['total'] != 0) {
            $car_inspection_percentage =
                ($inspection['total_pass'] * 100) / $inspection['total'];
        }

        $field = $this->CarModel->get_field(
            [
                'created_by',
                'modified_by',
                'deleted',
                'model_id',
                'brand_id_copy',
                'variant_id',

                'state_id',
                'transmission_id',
                'area_id',
                'car_id',
                'users_id',
                'color_id',
                'short_form',
            ],
            $car
        );
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $car[0],
            'sticker'
        );

        $car_image = $this->CarImageModel->getWhere([
            'car_image.car_id' => $car_id,
        ]);

        $car_sticker = $this->CarStickerModel->getWhere([
            'car_sticker.car_id' => $car_id,
        ]);

        // dd($car_image);
        $field = $this->CarImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'car_id',
        ]);
        $this->pageData['table_carimage'] = $this->generate_table(
            $field,
            $car_image,
            'car_image',
            'image',
            0,
            'edit'
        );

        $car_inspection_type = $this->InspectionTypeModel->getAll();
        // dd($car_inspection_type);
        $this->pageData['car_inspection_type'] = $car_inspection_type;
        // dd($car_inspection_type);

        $field = $this->InspectionTypeModel->get_field(
            [
                'created_by',
                'modified_by',
                'deleted',
                'car_id',
                'inspection_type_id',
            ],
            $car_inspection_type
        );
        $this->pageData['table_inspection_type'] = $this->generate_table(
            $field,
            $car_inspection_type,
            'inspection_type',
            'icon'
        );

        $form_arr = ['inspection_type_id'];
        $modal_car_inspection = $this->get_modal(
            $this->CarInspectionTypeModel->generate_input(),
            $form_arr,
            '/CarInspectionType/add',

            'modalcar_inspection_type',
            'car_id',
            $car_id
        );

        $this->pageData['modal_car_inspection'] = $modal_car_inspection;
        $this->pageData[
            'car_inspection_percentage'
        ] = $car_inspection_percentage;

        $this->pageData['car_inspection'] = $inspection;

        $this->pageData['car_sticker'] = $car_sticker;
        $this->pageData['car_image'] = $car_image;

        $form_arr = ['image'];

        $modal_car_image = $this->get_modal(
            $this->CarImageModel->generate_input(),
            $form_arr,
            '/CarImage/add',


            'modalAdd',
            'car_id',
            $car_id
        );
        $this->pageData['modal_car_image'] = $modal_car_image;

        echo view('admin/header', $this->pageData);
        echo view('admin/car/detail');
        echo view('admin/footer');
    }

    public function auto_insert_car_inspection_form($car_id)
    {
        $details = $this->InspectionDetailModel->getWhere([
            'inspection_detail.deleted' => 0,
        ]);

        foreach ($details as $row) {
            $where = [
                'inspection_detail_id' => $row['inspection_detail_id'],
                'car_id' => $car_id,
            ];
            $car_inspection = $this->CarInspectionModel->getWhere([
                'inspection_detail_id' => $row['inspection_detail_id'],
                'car_id' => $car_id,
            ]);
            if (empty($car_inspection)) {
                $this->CarInspectionModel->insertNew([
                    'inspection_detail_id' => $row['inspection_detail_id'],
                    'car_id' => $car_id,
                    'status_id' => 1,

                ]);
            }
        }
    }

    public function edit($car_id)
    {
        $where = [
            'car.car_id' => $car_id,
        ];
        $this->pageData['car'] = $this->CarModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'sticker');


                $this->CarModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['form'] = $this->CarModel->generate_edit_input($car_id);
        $this->pageData[


            'final_form'
        ] = $this->CarModel->get_final_form_edit($car_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
            'sticker',
        ]);
        $this->pageData['brand'] = $this->BrandModel->getAll();

        // $this->pageData['form'] = $this->CarModel->generate_input_edit($car_id);

        echo view('admin/header', $this->pageData);
        echo view('admin/car/edit');
        echo view('admin/footer');
    }

    public function delete($car_id)
    {
        $this->CarModel->softDelete($car_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

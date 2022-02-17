<?php namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AdminModel;
use App\Models\AttendenceModel;
use App\Models\DeductionModel;
use App\Models\DesignationModel;
use App\Models\DispatchModel;
use App\Models\SubdivisionModel;
use App\Models\UomModel;
use App\Models\WorkCodeModel;
use App\Models\WorkDoneModel;

use App\Models\WorkerModel;

use CodeIgniter\HTTP\IncomingRequest;


use App\Models\WorkCategoryModel;

use App\Models\WorkTypeModel;
use App\Models\RoleModel;

use App\Models\CompanyModel;
use App\Models\DeductForModel;
use App\Models\EstateModel;
use App\Models\MillModel;


class APIRedo extends BaseController
{

    public function __construct()
    {
        $this->request = service('request');


        $this->pageData = array();
        
        $this->AdminModel = new AdminModel();
        $this->SubdivisionModel = new SubdivisionModel();
        $this->DesignationModel = new DesignationModel();
        $this->WorkerModel = new WorkerModel();
        $this->UomModel = new UomModel();
        $this->WorkcodeModel = new WorkcodeModel();
        $this->WorkDoneModel = new WorkDoneModel();
        $this->AttendenceModel = new AttendenceModel();
        $this->DeductionModel = new DeductionModel();
        $this->DispatchModel = new DispatchModel();

        $this->WorkCategoryModel = new WorkCategoryModel();
        $this->WorkTypeModel = new WorkTypeModel();
        $this->CompanyModel = new CompanyModel();
        $this->DeductForModel = new DeductForModel();
        $this->EstateModel = new EstateModel();
        $this->MillModel = new MillModel();

        $this->RoleModel = new RoleModel();



        // header('Access-Control-Allow-Origin: *');
        $_POST = json_decode(file_get_contents("php://input"), true);

    }



    public function check_company_id(){
        if($_POST){
            return ['company_id' => $_POST['company_id']];
            // return ['company_id' => 0];
        }else{
            die(json_encode(array(
                "status" => false,
                "message" => "No Company Id Found",
            )));       

        }
    }


    public function get_subdivisions()
    {

        $this->check_company_id();
        $where = [
            'subdivision.company_id' => $_POST['company_id']
        ];
        $subdivisions = $this->SubdivisionModel->getWhere($where);



        
        die(json_encode(array(
            "status" => true,
            "data" => $subdivisions,
        )));
    }

    public function get_designations()
    {
        // $this->debug($_POST);
        $this->check_company_id();

        $where = [
            'designation.company_id' => $_POST['company_id']
        ];

        $designations = $this->DesignationModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $designations,
        )));
    }

    public function get_deduct_for()
    {
        $this->check_company_id();
        $where = [
            'deduct_for.company_id' => $_POST['company_id']
        ];
        $deduct_for = $this->DeductForModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $deduct_for,
        )));
    }


    public function get_work_category()
    {
        $this->check_company_id();
        $where = [
            'work_category.company_id' => $_POST['company_id']
        ];

        $work_category = $this->WorkCategoryModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $work_category,
        )));
    }
    public function get_work_type()
    {
        $this->check_company_id();
        $where = [
            'work_type.company_id' => $_POST['company_id']
        ];
        $work_type = $this->WorkTypeModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $work_type,
        )));
    }
    public function get_attendance_id_by_worker()
    {
        $where = [
            'attendence.worker_id' => $_POST['worker_id'],
        ];
    
        if(isset($_POST['month']) && !empty($_POST['month'])){
            $where['attendence.month'] = $_POST['month'];
            
        }
        if(isset($_POST['subdivision_id']) && !empty($_POST['subdivision_id'])){

            $where['attendence.subdivision_id'] = $_POST['subdivision_id'];
        }
        if(isset($_POST['year']) ){
            $where['attendence.year'] = ($_POST['year']);
        }
        if(isset($_POST['designation_id']) && !empty($_POST['designation_id'])){
            $where['attendence.designation_id'] = $_POST['designation_id'];
        }
        
        $attendance = $this->AttendenceModel->get_attendance_by_worker_id($where);


        die(json_encode(array(


            "status" => true,
            "data" => $attendance,
        )));
    }
    public function get_uoms()
    {

        $this->check_company_id();
        $where = [
            'uom.company_id' => $_POST['company_id']
        ];
        $uoms = $this->UomModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $uoms,
        )));
    }


 
    public function get_company()
    {

        $company = $this->CompanyModel->getAll();


        die(json_encode(array(
            "status" => true,
            "data" => $company,
        )));
    }
    public function get_estate()
    {

        $this->check_company_id();
        $where = [
            'estate.company_id' => $_POST['company_id']
        ];

        $estate = $this->EstateModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $estate,
        )));
    }
    public function get_mill()
    {

        
        $this->check_company_id();
        $where = [
            'mill.company_id' => $_POST['company_id']
        ];
        $mill = $this->MillModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $mill,
        )));
    }


    public function get_attendance()
    {
            
        // $this->check_company_id();
        // $where = [
        //     'attendence.company_id' => $_POST['company_id']
        // ];

        $where = [];

        if(isset($_POST['month']) && !empty($_POST['month'])){
            $where['attendence.month'] = $_POST['month'];
            
        }
        if(isset($_POST['subdivision_id']) && !empty($_POST['subdivision_id'])){
            $where['attendence.subdivision_id'] = $_POST['subdivision_id'];
        }
        if(isset($_POST['year']) ){
            $where['attendence.year'] = ($_POST['year']);
        }
        if(isset($_POST['designation_id']) && !empty($_POST['designation_id'])){
            $where['attendence.designation_id'] = $_POST['designation_id'];
        }
        
        $attendence = $this->AttendenceModel->getAllWorker($where);
        foreach($attendence as $key=> $row){
            $total_working_hour = $row['total_working_day_working_hour'] + $row['total_rest_day_working_hour'] + $row['total_public_holiday_working_hour'];
            $attendence[$key]['total_working_hour'] = $total_working_hour;
            $attendence[$key]['total_days'] = $row['total_public_holiday'] + $row['total_rest_day'] + $row['total_working_day'];
            $attendence[$key]['total_overtime'] = $row['total_public_holiday_overtime'] + $row['total_rest_day_overtime'] + $row['total_working_day_overtime'];

        }
        
        die(json_encode(array(
            "status" => true,
            "data" => $attendence,

        )));
    }
    public function export_attendance(){
        if($_POST){

            $attendancecsv = $this->AttendenceModel->getAll();
            $header = [
                'attendence_id',
                'subdivision_id',
                'worker_id',
                'company_id',
                'week',
                'working_day',
                'working_hour',
                'rest_day',
                'public_holiday',
                'absent',
                'sick_leave',
                'on_leave',
                'overtime',
                'month',
                'year',
                'deleted',
                'created_date',
                'created_by',
                'modified_date',
                'modified_by'
            ];
            die(json_encode(array(
                "status" => true,
                "data" => $this->exports_to_csv($attendancecsv,'attendance',$header),
            )));
        }
    }
    public function exports_to_csv($data,$file_name,$header){
        $path = './assets/csv/'.$file_name.'.csv';
        $handle = fopen($path, 'w');
        fputcsv($handle, $header);

        foreach ($data as $data_array) {
            fputcsv($handle, $data_array);
        }
            fclose($handle);
        return base_url() . $path;
        exit;
    }

    public function get_workers()
    {
        $this->check_company_id();
        $where = [
            'worker.company_id' => $_POST['company_id']
        ];
        $workers = $this->WorkerModel->getWhere($where);
        $worker_arr = [];
        foreach($workers as $row){
            $dataExportRow = [
                "id_no" => $row['id_no'],
                "name" => $row['name'],
                "ic_no" => $row['ic_no'],
                "exp_date" => $row['exp_date'],
                "gang" => $row['gang'],
                "superior" =>  $row['superior'],
                "birth_date" =>  $row['birth_date'],
                "age" => $row['age'],
                "gender" => $row['gender'],
                "birth_place" =>  $row['birth_place'],
                "nationality" =>  $row['nationality'],
                "religion" =>  $row['religion'],
                "race" =>  $row['race'],
                "marital" =>  $row['marital'],
                "spouse_name" =>  $row['spouse_name'],
                "child" => $row['child'],
                "bank" => $row['bank'],
                "bank_acc" => $row['bank_acc'],
                "socso" => $row['socso'],
                "status" => $row['status'],
            ];
            array_push($worker_arr,$dataExportRow);
        }

        die(json_encode(array(
            "status" => true,
            "data" => $workers,
            'data_export' => $worker_arr
        )));
    }

    public function login()
    {
        if ($_POST) {
            $input = $_POST;

            $error = false;
            $login = $this->AdminModel->login($input["username"], $input["password"]);
            if (!empty($login)) {
                $login_data = $login[0];
                $login_id = $login[0]["admin_id"];
            } else {
                
                $error = true;
                $message = "Invalid Username and Password";
            }

            if (!$error) {
                $token = $this->generate_token();

                $where = array(
                    "admin_id" => $login_id,
                );

                $data = array(
                    "token" => $token,
                    "last_login" => date("Y-m-d H:i:s"),

                );

                $this->AdminModel->updateWhere($where, $data);

                die(json_encode(array(
                    "status" => true,
                    "data" => array(
                        "login_data" => $login_data,
                        "token" => $token,
                    ),
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => $message,
                )));
            }
        }
    }

    public function generate_token()
    {
        $chars = "abcdefghijklmnopqrtuvwxyx1234564789";
        return substr(sha1(strtotime('now') . $chars), 0, 64);
    }
    public function get_admin()
    {
        if($_POST){
            $this->check_company_id();
            $where = [
                'admin.company_id' => $_POST['company_id']
            ];
            $admins = $this->AdminModel->getWhere($where);

            $admin_arr = [];
            foreach($admins as $admin){
                $data = [
                    'admin_id' => $admin['admin_id'],
                    'last_login' => $admin['last_login'],

                    'email' => $admin['email'],
                    'user_name' => $admin['username'],
                    'name' => $admin['name'],
                    'role' => $admin['role'],
                    'role_id' => $admin['role_id'],
                ];
                array_push($admin_arr,$data);

            }
            die(json_encode(array(
                "status" => true,
                "data" => $admin_arr,
            )));
        }
    }
    public function get_deduction()
    {
        $where = [
            'deduction.company_id' => $_POST['company_id']
        ];       

        $deduction = $this->DeductionModel->getWhere($where);

        die(json_encode(array(
            "status" => true,
            "data" => $deduction,
        )));
    }

    public function get_workcode()
    {
        // $this->check_company_id();
        $where = [
            'workcode.company_id' => $_POST['company_id']
        ]; 

        $workcode = $this->WorkcodeModel->getWhere($where);

        
        die(json_encode(array(
            "status" => true,
            "data" => $workcode,
        )));
    }
    public function get_workdone()
    {

        $this->check_company_id();
        $where = [
            'workdone.company_id' => $_POST['company_id']
        ]; 
        $workdone = $this->WorkDoneModel->getWhere($where);

        die(json_encode(array(
            "status" => true,

            "data" => $workdone,
        )));
    }
    public function get_dispatch()
    {
        $this->check_company_id();
        $where = [
            'dispatch.company_id' => $_POST['company_id']
        ]; 
        $production = $this->DispatchModel->getWhere($where);

        die(json_encode(array(



            "status" => true,
            "data" => $production,
        )));
    }


    public function checkWorkerExisted($where){
        $worker = $this->WorkerModel->checkWorkerExisted($where);
        if (!empty($worker)) {
            return true;
        }else{
            return false;
        }
    }
    
    public function register_worker()
    {

        if ($this->request->getMethod() == "post") {

            

            $where = array(
                "id_no" => $this->request->getPost("id_no"),
                "deleted" => "0",

            );
            $exist = $this->checkWorkerExisted($where);

       
            
            if (!$exist) {
                $data = array(
                    "subdivision_id" => $this->request->getPost("subdivision_id"),
                    "designation_id" => $this->request->getPost("designation_id"),
                    'company_id' => $this->request->getPost('company_id'),
                    "id_no" => $this->request->getPost("id_no"),
                    "name" => $this->request->getPost("name"),
                    "ic_no" => $this->request->getPost("ic_no"),
                    "exp_date" => DATE("Y-m-d", strtotime($this->request->getPost("exp_date"))),
                    "emp_date" => DATE("Y-m-d", strtotime($this->request->getPost("emp_date"))),
                    "gang" => $this->request->getPost("gang"),
                    "superior" => $this->request->getPost("superior"),
                    "birth_date" => $this->request->getPost("birth_date"),
                    "age" => $this->request->getPost("age"),
                    "gender" => $this->request->getPost("gender"),
                    "birth_place" => $this->request->getPost("birth_place"),
                    "nationality" => $this->request->getPost("nationality"),
                    "religion" => $this->request->getPost("religion"),
                    "race" => $this->request->getPost("race"),

                    "marital" => $this->request->getPost("marital"),
                    "spouse_name" => $this->request->getPost("spouse"),
                    "child" => $this->request->getPost("child"),
                    "bank" => $this->request->getPost("bank"),
                    "bank_acc" => $this->request->getPost("bank_acc"),
                    "socso" => $this->request->getPost("socso"),
                    "status" => $this->request->getPost("status"),
                    "created_by" => $this->request->getPost("admin_id"),

                );

                if (!empty($_FILES['image']['name'])) {
                    $file = $this->request->getFile('image');
                    $new_name = $file->getRandomName();
                 
                    $banner = $file->move('./public/image/worker/', $new_name);
                    if ($banner) {
                        $banner = '/public/image/worker/' . $new_name;
                        $data['image'] = $banner;
                    } else {
                        $error = true;
                        $error_message = "Upload failed.";
                    }
                }
                $this->WorkerModel->insertNew($data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $this->request->getPost(),
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "worker already existed",
                )));
            }
        }
    }
    

    public function insert_workcode()
    {
        if ($_POST) {
            $error = false;


            if (!$error) {
                $data = array(
                    "workcode" => $_POST["workcode"],
                    "work_category_id" => $_POST["category"],
                    "work_type_id" => $_POST["type_of_work"],
                    "uom_id" => $_POST["uom"],
                    "rate" => $_POST["rate"],
                    "remark" => $_POST["remarks"],
                    "created_by" => $_POST["admin_id"],

                    'company_id' => $_POST['company_id'],
                );

                $this->WorkcodeModel->insertNew($data);

                die(json_encode(array(
                    "status" => true,
                    "data"=> $data
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }

    
    public function get_role(){
        if($_POST){
            $where = [
                'role.company_id' => $_POST['company_id']
            ];
            $role = $this->RoleModel->getWhere($where);


            die(json_encode(array(
                "status" => true,
                "data" => $role,
            )));
            
        }
    }

    //insert start


    public function register_admin(){
        
        if ($_POST) {
            


            $input = $this->request->getPost();
            $error = false;


            if($this->checkExists($_POST['username'])){
                $error = true;
                die(json_encode(array(
                    "status" => false,
                    'message' => "admin existed",
                )));

                
            }
              
            // $this->debug($input);

            if (!empty($_POST['password'])) {


                if ($_POST["password"] != $_POST["password2"]) {
                    $error = true;
                    $error_message = "Passwords do not match";
                  
                }
            }

            // $this->debug($error_message);
            //single upload
            // $getUpload = $this->request->getFile('thumbnail');
            // $thumbnail = $getUpload->getName();
            // $tempName = $getUpload->getTempName();
            // $getUpload->move('./assets/img/admin', $thumbnail);

            //multiple upload
            // $getUpload = $this->request->getFileMultiple('thumbnail');
            // foreach ($getUpload as $files){
            //     $thumbnail = $files->getName();
            //     $files->move('./assets/img/admin', $thumbnail);
            // }

            if (!$error) {

                $hash = $this->hash($_POST['password']);

                $data = array(
                    'role_id' => $_POST['role_id'],
                    'name' => $_POST['name'],
                    'company_id' => $_POST['company_id'],
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $hash['password'],
                    'salt' => $hash['salt'],
                    
                    'created_by' => $_POST['admin_id'],
                );



                $this->AdminModel->insertNew($data);
                 
                die(json_encode(array(
                    "status" => true,
                    'message' => $_POST,
                )));


                
            }else{
                 
                die(json_encode(array(
                    "status" => false,
                    'message' => "admin existed",
                )));
            }

        }
    }

    public function insert_workdone()
    {
        if ($_POST) {
            $error = false;
            
     
            if (!$error) {
                $data = array(
                    
                    'company_id' => $_POST['company_id'],

                    "worker_id" => $_POST['worker_id'],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "designation_id" => $_POST["designation_id"],
                    "workcode_id" => $_POST["work_code"],
                    "worker_id" => $_POST['worker_id'],
                    "qty" => $_POST["quantity"],
                    "block" => $_POST["block"],
                    "week" => "w",

                    "workdone_date" => $_POST['date'],

                    
                    "created_by" => $_POST["admin_id"],

                    "month" => DATE("m", strtotime($_POST["date"])),
                    "year" => DATE("Y", strtotime($_POST["date"])),
                    'remark' => $_POST['remark'],

                );
    
                $this->WorkDoneModel->insertNew($data);

                
                die(json_encode(array(
                    "status" => true,
                    'message' => "data inserted",
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => $error,
                )));
            }
        }else{
            echo "no post";
        }
    }

    public function insert_deduction()
    {
        if ($_POST) {

            $where = array(
                "worker_id" => $_POST['worker_id'],
                'company_id' => $_POST['company_id'],

            );
            $exist = false;
            if (!$exist) {
                $data = array(
                  

                    'company_id' => $_POST['company_id'],
                    "worker_id" => $_POST['worker_id'],
                    "subdivision_id" => $_POST["subdivision_id"],

                    "deduct_id" => $_POST["deduct_id"],
                    "deduction" => $_POST["deduction"],

                    "bf" => $_POST["BF"],
                    "cf" => $_POST["CF"],
                    'current' => $_POST['credit'],

                    "created_by" => $_POST["admin_id"],

                    // "month" => $_POST["rate"],
                    "month" => $_POST["month"],
                    'year' => $_POST['year'],
                    
                );

                $this->DeductionModel->insertNew($data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Worker already existed",
                )));
            }
        }
    }



    public function insert_dispatch()
    {
        if ($_POST) {
            $error = false;
            if (!$error) {
                $data = array(
                    'date' => DATE("Y-m-d", strtotime($_POST['date'])),
                    "estate_id" => $_POST['estate'],
                    'company_id' => $_POST['company_id'],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "delivery_note" => $_POST["delivery_note"],
                    "mill_id" => $_POST["mill_id"],
                    'mill_no' => $_POST['mill_ticket_no'],
                    "seal_no" => $_POST["seal_no"],
                    "lorry_no" => $_POST["lorry_no"],
                    "tonnage" => $_POST["tonnage"],
                    "block" => $_POST["block"],
                    "created_by" => $_POST["admin_id"],
                    'month' => DATE("m", strtotime($_POST['date'])),
                    'year' => DATE("Y", strtotime($_POST['date'])),
                );

                $this->DispatchModel->insertNew($data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => $error,
                )));
            }
        }
    }
    public function insert_attendance()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "worker_id" => $_POST['worker_id'],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "company_id" => $_POST["company_id"],
                    "date" => $_POST["date"],

                    "week" =>DATE("M", strtotime($_POST["date"])),
                    "created_by" => $_POST["admin_id"],
                    "month" => DATE("m", strtotime($_POST["date"])),
                    "year" => DATE("Y", strtotime($_POST["date"])),
                );

                $attendance_type_id = $_POST['attendance_type_id'];
                if(($attendance_type_id == 0 || $attendance_type_id == 1 || $attendance_type_id == 2 )){

                    if($_POST['working_hour'] > 8 ){
                        $data["overtime"]=$_POST["working_hour"] - 8;
                        $data["working_hour"] = 8;
                    }else{
                        $data["overtime"]=0;
                        $data["working_hour"] = $_POST["working_hour"];
                    }
                  
                }
            

                switch ($attendance_type_id){
                    case '0' :
                        $data['working_day'] = 1;
                        break;

                    case '1' :
                        $data['rest_day'] = 1;
                        break;
                    case '2' :
                        $data['public_holiday'] = 1;
                        break;

                    case '3' :
                        $data['absent'] = 1;
                        break;

                    case '4' :
                        $data['sick_leave'] = 1;
                        break;

                    case '5' :
                        $data['on_leave'] = 1;
                        break;

       
                }
                $this->AttendenceModel->insertNew($data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Worker already existed",
                )));
            }

        }
    }

    public function resetAttendance($where){
        $data = [
           
            'working_day' => 0,
            'rest_day' => 0,
            'public_holiday' => 0,
            'absent' => 0,
            'sick_leave' => 0,
            'on_leave' => 0,
        ];
        $this->AttendenceModel->updateWhere($where,$data);

    }
    public function edit_attendance()
    {
        if ($_POST) {
            $error = false;


            $where = array(
                'attendence_id' => $_POST['attendence_id'],
            );


            if (!$error) {
                $data = array(
                    "worker_id" => $_POST['worker_id'],
                    "date" => $_POST["date"],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "company_id" => $_POST["company_id"],
                    "week" =>DATE("M", strtotime($_POST["date"])),
                    "created_by" => $_POST["admin_id"],
                    "month" => DATE("m", strtotime($_POST["date"])),
                    
                    "year" => DATE("Y", strtotime($_POST["date"])),
                );

                $this->resetAttendance($where);
                $attendance_type_id = $_POST['attendance_type_id'];
                if(($attendance_type_id == 0 || $attendance_type_id == 1 || $attendance_type_id == 2 )){
                    if($_POST['working_hour'] > 8 ){
                        $data["overtime"]=$_POST["working_hour"] - 8;
                        $data["working_hour"] = 8;
                    }else{
                        $data["overtime"]=0;
                        $data["working_hour"] = $_POST["working_hour"];
                    }
                  
                }
            
                switch ($attendance_type_id){
                    case '0' :
                        $data['working_day'] = 1;
                        break;

                    case '1' :
                        $data['rest_day'] = 1;
                        break;
                    case '2' :
                        $data['public_holiday'] = 1;
                        break;

                    case '3' :
                        $data['absent'] = 1;
                        break;

                    case '4' :
                        $data['sick_leave'] = 1;
                        break;

                    case '5' :
                        $data['on_leave'] = 1;
                        break;
       
                }
                $this->AttendenceModel->updateWhere($where,$data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Worker already existed",
                )));
            }

        }
    }
    
    public function insert_estate()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "estate" => $_POST["estate"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->EstateModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }
    public function insert_role()
    {
        if ($_POST) {
            
       
            $error = false;

            if (!$error) {
                $data = array(
                    "role" => $_POST["role"],
                    "company_id" => $_POST['company_id'],
                );
                $this->RoleModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }
    public function insert_deduct_for()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "deduct_for" => $_POST["deduct_for"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->DeductForModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert deduct_for failed.",
                )));
            }
        }
    }

    public function insert_designation()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "designation" => $_POST["designation"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->DesignationModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert designation failed.",
                )));
            }
        }
    }
    public function insert_subdivision()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "subdivision" => $_POST["subdivision"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->SubdivisionModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert subdivision failed.",
                )));
            }
        }
    }
    public function insert_uom()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "uom" => $_POST["uom"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->UomModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert subdivision failed.",
                )));
            }
        }
    }
    public function insert_work_category()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "work_category" => $_POST["work_category"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->WorkCategoryModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert work_category failed.",
                )));
            }
        }
    }
    public function insert_work_type()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "work_type" => $_POST["work_type"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->WorkTypeModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert WorkTypeM failed.",
                )));
            }
        }
    }

    public function insert_company()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "company" => $_POST["company"],
                    "created_by" => $_POST["admin_id"],

                );
                $this->CompanyModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    "data" => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }

    public function insert_mill()
    {
        if ($_POST) {
            $error = false;
            if (!$error) {
                $data = array(
                    "mill" => $_POST["mill"],
                    'company_id' => $_POST['company_id'],
                    "created_by" => $_POST["admin_id"],
                );
                $this->MillModel->insertNew($data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }
    
    //insert end



    //update start

    public function edit_worker()
    {

        if ($this->request->getMethod() == "post") {
            

            $where = array(
                "worker_id" => $this->request->getPost("worker_id"),
            );
       
            $error = false;
            if (!$error) {
                $data = array(
                    "subdivision_id" => $this->request->getPost("subdivision_id"),
                    "designation_id" => $this->request->getPost("designation_id"),
                    'company_id' => $this->request->getPost('company_id'),
                    "id_no" => $this->request->getPost("id_no"),
                    "name" => $this->request->getPost("name"),
                    "ic_no" => $this->request->getPost("ic_no"),
                    "exp_date" => DATE("Y-m-d", strtotime($this->request->getPost("exp_date"))),
                    "emp_date" => DATE("Y-m-d", strtotime($this->request->getPost("emp_date"))),
                    "gang" => $this->request->getPost("gang"),
                    "superior" => $this->request->getPost("superior"),
                    "birth_date" => $this->request->getPost("birth_date"),
                    "age" => $this->request->getPost("age"),
                    "gender" => $this->request->getPost("gender"),
                    "birth_place" => $this->request->getPost("birth_place"),
                    "nationality" => $this->request->getPost("nationality"),
                    "religion" => $this->request->getPost("religion"),
                    "race" => $this->request->getPost("race"),

                    "marital" => $this->request->getPost("marital_status"),
                    "spouse_name" => $this->request->getPost("spouse"),
                    "child" => $this->request->getPost("child"),
                    "bank" => $this->request->getPost("bank"),
                    "bank_acc" => $this->request->getPost("bank_acc"),
                    "socso" => $this->request->getPost("socso"),
                    "status" => $this->request->getPost("status"),
                    "created_by" => $this->request->getPost("admin_id"),

                );

                if (!empty($_FILES['image']['name'])) {
                    $file = $this->request->getFile('image');
                    $new_name = $file->getRandomName();
                 
                    $banner = $file->move('./public/image/worker/', $new_name);
                    if ($banner) {
                        $banner = '/public/image/worker/' . $new_name;
                        $data['image'] = $banner;
                    } else {
                        $error = true;
                        $error_message = "Upload failed.";
                    }
                }
                $this->WorkerModel->updateWhere($where,$data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $this->request->getPost(),
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Error",
                )));
            }
        }
    }

    public function edit_admin(){
        
        
        if ($_POST) {
            $admin_id = $_POST['admin_id'];

            $error = false;

      

            //single upload
            // $getUpload = $this->request->getFile('thumbnail');
            // $thumbnail = $getUpload->getName();

            //multiple upload
            // $getUpload = $this->request->getFileMultiple('thumbnail');
            if (!empty($_POST['password']) && $_POST['password'] != "") {
                if ($_POST["password"] != $_POST["password2"]) {
                    $error = true;
                    $error_message= "Passwords do not match";
                }
            }
            if (!$error) {

                $where = array(
                    'admin_id' => $admin_id,
                );

                $data = array(
                    'username' => $_POST['username'],
                    'name' => $_POST['name'],
                    'role_id' => $_POST['role_id'],
                    // 'contact' => $_POST['contact'],
                    'email' => $_POST['email'],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                );

              
                // if (!empty($thumbnail)) {
                //     $data['thumbnail'] = $thumbnail;
                //     $getUpload->move('./assets/img/admin', $thumbnail);


                //     // foreach ($getUpload as $files){
                //     //     $thumbnail = $files->getName();
                //     //     $files->move('./assets/img/admin', $thumbnail);
                //     // }
                // }
                if (!empty($_POST['password'])) {

                    $hash = $this->hash($_POST['password']);
                    $data['password'] = $hash['password'];
                    $data['salt'] = $hash['salt'];
                }
                $this->AdminModel->updateWhere($where, $data);
                
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));

                // return redirect()->to(base_url('admin/detail/' . $admin_id, "refresh"));

            }else{
                die(json_encode(array(
                    "status" => false,
                    'data' => $error_message,
                )));
            }

        }
    }

    public function edit_workdone()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $where = [
                    'workdone_id' => $_POST['workdone_id'],    
                ];

                $data = array(
                    
                    'company_id' => $_POST['company_id'],

                    "worker_id" => $_POST['worker_id'],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "designation_id" => $_POST["designation_id"],
                    "workcode_id" => $_POST["workcode_id"],
                    "worker_id" => $_POST['worker_id'],
                    "qty" => $_POST["qty"],
                    "block" => $_POST["block"],
                    "workdone_date" => $_POST['workdone_date'],

                    "week" => "w",
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                    "month" => DATE("M", strtotime($_POST["workdone_date"])),
                    "year" => DATE("Y", strtotime($_POST["workdone_date"])),
                    'remark' => $_POST['remark'],

                );
    
                $this->WorkDoneModel->updateWhere($where,$data);

                
                die(json_encode(array(
                    "status" => true,
                    'message' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => $error,
                )));
            }
        }else{
            echo "no post";
        }
    }
    public function edit_workcode()
    {
        if ($_POST) {
            $error = false;
            if (!$error) {
                $where = [
                    'workcode_id' => $_POST['workcode_id'],    
                ];
                $data = array(
                    "workcode" => $_POST["workcode"],
                    "work_category_id" => $_POST["work_category_id"],
                    "work_type_id" => $_POST["work_type_id"],
                    "uom_id" => $_POST["uom_id"],
                    "rate" => $_POST["rate"],
                    "remark" => $_POST["remark"],
                    'company_id' => $_POST['company_id'],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                );
                $this->WorkcodeModel->updateWhere($where,$data);


            
                die(json_encode(array(
                    "status" => true,
                    'message' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => $error,
                )));
            }
        }
    }

    public function edit_deduction()
    {
        if ($_POST) {

            $where = array(
                "deduction_id" => $_POST['deduction_id'],

            );
            $error = false;
            if (!$error) {
                $data = array(
                    
                    'company_id' => $_POST['company_id'],
                    "worker_id" => $_POST['worker_id'],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "deduct_id" => $_POST["deduct_id"],
                    "deduction" => $_POST["deduction"],

                    "bf" => $_POST["bf"],
                    "cf" => $_POST["cf"],
                    'current' => $_POST['current'],


                    // "month" => $_POST["rate"],
                    "month" => $_POST["month"],
                    'year' => $_POST['year'],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                    
                );

                $this->DeductionModel->updateWhere($where,$data);

                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Worker already existed",
                )));
            }
        }
    }

    public function edit_role()
    {
        if ($_POST) {
            
       
            $where = [
                'role_id'  => $_POST['role_id']
            ];
            $error = false;

            if (!$error) {
                $data = array(
                    "role" => $_POST["role"],
                    "company_id" => $_POST['company_id'],
                );
                $this->RoleModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }

    public function edit_dispatch()
    {
        if ($_POST) {
            $error = false;
            if (!$error) {
                $where = [
                    'dispatch_id' => $_POST['dispatch_id'],
                ];

                $data = array(
                 
                    'date' => DATE("Y-m-d", strtotime($_POST['date'])),
                    "estate_id" => $_POST['estate_id'],
                    'company_id' => $_POST['company_id'],
                    "subdivision_id" => $_POST["subdivision_id"],
                    "delivery_note" => $_POST["delivery_note"],
                    "mill_id" => $_POST["mill_id"],
                    'mill_no' => $_POST['mill_no'],
                    "seal_no" => $_POST["seal_no"],
                    "lorry_no" => $_POST["lorry_no"],

                    "tonnage" => $_POST["tonnage"],
                    "block" => $_POST["block"],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                    'month' => DATE("m", strtotime($_POST['date'])),
                    'year' => DATE("Y", strtotime($_POST['date'])),
                );

                $this->DispatchModel->updateWhere($where,$data);


                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => $error,
                )));

            }
        }
    }
    
    
  
    
    public function edit_estate()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $where = [
                    'estate_id' => $_POST['estate_id'],
                ];
                $data = array(
                    "estate" => $_POST["estate"],
                    "company_id" => $_POST['company_id'],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                );
                $this->EstateModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }

    public function edit_company()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = array(
                    "company" => $_POST["company"],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                );
                $where = [
                    'company_id' => $_POST['company_id'],
                ];
                $this->CompanyModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    "data" => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }

    public function edit_mill()
    {
        if ($_POST) {
            $error = false;
            if (!$error) {
                $where = [
                    'mill_id' => $_POST['mill_id'],
                ];
                $data = array(
                    "mill" => $_POST["mill"],
                    'company_id' => $_POST['company_id'],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                );
                $this->MillModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "Insert failed.",
                )));
            }
        }
    }

    public function edit_deduct_for()
    {
        if ($_POST) {
            $error = false;

            $where = [
                'deduct_for_id' => $_POST['deduct_for_id'],
            ];

            if (!$error) {
                $data = array(
                    "deduct_for" => $_POST["deduct_for"],
                    "modified_date" => date("Y-m-d H:i:s"),
                    'modified_by' => $_POST['admin_id'],
                );
                $this->DeductForModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "edit deduct_for failed.",
                )));
            }
        }
    }

    public function edit_designation()
    {
        if ($_POST) {
            $error = false;

            $where = [
                'designation_id' => $_POST['designation_id'],
            ];
            if (!$error) {
                $data = array(
                    "designation" => $_POST["designation"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->DesignationModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "edit designation failed.",
                )));
            }
        }
    }
    public function edit_subdivision()
    {
        if ($_POST) {
            $error = false;

            $where = [
                'subdivision_id' => $_POST['subdivision_id'],
            ];
            if (!$error) {
                $data = array(
                    "subdivision" => $_POST["subdivision"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->SubdivisionModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "edit subdivision failed.",
                )));
            }
        }
    }
    public function edit_uom()
    {
        if ($_POST) {
            $error = false;
            $where = [
                'uom_id' => $_POST['uom_id'],
            ];

            if (!$error) {
                $data = array(
                    "uom" => $_POST["uom"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->UomModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "edit subdivision failed.",
                )));
            }
        }
    }
    public function edit_work_category()
    {
        if ($_POST) {
            $error = false;
            $where = [
                'work_category_id' => $_POST['work_category_id'],
            ];


            if (!$error) {
                $data = array(
                    "work_category" => $_POST["work_category"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->WorkCategoryModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "edit work_category failed.",
                )));
            }
        }
    }
    public function edit_work_type()
    {
        if ($_POST) {
            $error = false;
            
            $where = [
                'work_type_id' => $_POST['work_type_id'],
            ];

            if (!$error) {
                $data = array(
                    "work_type" => $_POST["work_type"],
                    "created_by" => $_POST["admin_id"],
                    "company_id" => $_POST['company_id'],
                );
                $this->WorkTypeModel->updateWhere($where,$data);
                die(json_encode(array(
                    "status" => true,
                    'data' => $_POST,
                )));
            } else {
                die(json_encode(array(
                    "status" => false,
                    "message" => "edit WorkType failed.",
                )));
            }
        }
    }
    


    //update end
    
    
    
    //delete start

    public function delete_attendance(){
        if(!empty($_POST['attendance_id'])){
            $this->AttendenceModel->softDelete($_POST['attendance_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
    }
    public function delete_role(){
        if(!empty($_POST['role_id'])){

            $this->RoleModel->where('role_id', $_POST['role_id'])->delete();
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
    }
    public function delete_admin(){
        if(!empty($_POST['admin_id'])){
            $this->AdminModel->softDelete($_POST['admin_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
    }

    public function delete_worker(){
        if(!empty($_POST['worker_id'])){
            $this->WorkerModel->softDelete($_POST['worker_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
        
    }
    public function delete_deduction(){
        if(!empty($_POST['deduction_id'])){
            $this->DeductionModel->softDelete($_POST['deduction_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
        
    }
    public function delete_workcode(){
        if(!empty($_POST['workcode_id'])){
            $this->WorkcodeModel->softDelete($_POST['workcode_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
        
    }
    public function delete_workdone(){
        if(!empty($_POST['workdone_id'])){
            $this->WorkDoneModel->softDelete($_POST['workdone_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
        
    }

    public function delete_dispatch(){
        
        if(!empty($_POST['dispatch_id'])){
            $this->DispatchModel->softDelete($_POST['dispatch_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
    }
    public function delete_company(){
        if(!empty($_POST['company_id'])){
            $this->CompanyModel->softDelete($_POST['company_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
        
    }
    public function delete_estate(){
        if(!empty($_POST['estate_id'])){
            $this->EstateModel->softDelete($_POST['estate_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
    }
    public function delete_mill(){
        if(!empty($_POST['mill_id'])){
            $this->MillModel->softDelete($_POST['mill_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
    }

    public function delete_deduct_for()
    {

        if(!empty($_POST['deduct_for_id'])){
            $this->DeductForModel->softDelete($_POST['deduct_for_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }

    }

    public function delete_designation()
    {
        if(!empty($_POST['designation_id'])){
            $this->DesignationModel->softDelete($_POST['designation_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }

    }
    public function delete_subdivision()
    {

        if(!empty($_POST['subdivision_id'])){
            $this->SubdivisionModel->softDelete($_POST['subdivision_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }

    }
    public function delete_uom()
    {

        if(!empty($_POST['uom_id'])){
            $this->UomModel->softDelete($_POST['uom_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }
        
    }
    public function delete_work_category()
    {
        if(!empty($_POST['work_category_id'])){
            $this->WorkCategoryModel->softDelete($_POST['work_category_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }   
    }
    public function delete_work_type()
    {

        if(!empty($_POST['work_type_id'])){
            $this->WorkTypeModel->softDelete($_POST['work_type_id']);
            die(json_encode(array(
                "status" => true,
                'data' => $_POST,
            )));
        }else{
            die(json_encode(array(
                "status" => true,
                'message' => "No Post detected",
            )));
        }   
        
    }
    //delete end


    
    //get start_

    public function get_admin_by_id(){
        if($_POST){
            $where = [
                'admin.admin_id' => $_POST['admin_id'],

            ];

            $admin  = $this->AdminModel->getWhereId($where)[0];

            
            $admin_arr = [
                'admin_id' => $_POST['admin_id'],
                'email' => $admin['email'],
                'username' => $admin['username'],
                'name' => $admin['name'],
                'role' => $admin['role'],
                'role_id' => $admin['role_id'],
            ];
            // $this->debug($admin);
            if(!empty($admin)){
                die(json_encode(array(
                    "status" => true,
                    'data' => $admin_arr,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Admin Found",
                )));
            }


        }
    }


    public function get_attendance_by_worker_id(){
        if($_POST){
            $where = [
                'attendence.worker_id' => $_POST['worker_id'],
            ];
            $unwanted_filed = [
                'subdivision_id'
            ];

            $attendence = $this->AttendenceModel->getWhere($where,'',1,$unwanted_filed);
            if(!empty($attendence)){
                
                die(json_encode(array(
                    "status" => true,
                    'data' => $attendence[0],
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Attendance Found",
                )));
            }
        }
    }
    public function get_attendance_by_id(){
        if($_POST){
            $where = [
                'attendence_id' => $_POST['attendence_id'],
            ];

            $attendence = $this->AttendenceModel->getWhere($where);

            if(!empty($attendence)){
                $attendence = $attendence [0];
                $where = [
                    'subdivision_id' => $attendence['subdivision_id']
                ];
                $attendence['subdivision_data'] = $this->SubdivisionModel->getWhere($where)[0];
                $attendence['worker_data'] = $this->WorkerModel->getWhereId([
                    'worker_id' => $attendence['worker_id'],
                ])[0];
                

                $attendence = $this->get_attendance_type($attendence);
                
                die(json_encode(array(
                    "status" => true,
                    'data' => $attendence,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Attendance Found",
                )));
            }
        }
        
    }


    public function get_attendance_type($attendance){

        if($attendance['working_day'] == 1){
            $attendance['attendance_type_id'] = 0;

        }else  if($attendance['rest_day'] == 1){
            $attendance['attendance_type_id'] = 1;

        }else if($attendance['public_holiday'] == 1){
            $attendance['attendance_type_id'] = 2;

        }else  if($attendance['absent'] == 1){
            $attendance['attendance_type_id'] = 3;


        }else  if($attendance['sick_leave'] == 1){
            $attendance['attendance_type_id'] = 4;

        }else if($attendance['on_leave'] == 1){
            $attendance['attendance_type_id'] = 5;
        }
        return $attendance;
    }
    
    public function get_worker_by_id(){
        if($_POST){ 
            $where = [
                'worker_id' => $_POST['worker_id']
            ];
            $worker = $this->WorkerModel->getWhereId($where)[0];
            if(!empty($worker)){

                die(json_encode(array(
                    "status" => true,
                    'data' => $worker,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Worker Found",
                )));
            }
        }  
    }
    public function get_deduction_by_id(){
        if($_POST){
            $where = [
                'deduction_id' => $_POST['deduction_id']
            ];
            $deduction = $this->DeductionModel->getWhereId($where)[0];
            if(!empty($deduction)){
                die(json_encode(array(
                    "status" => true,
                    'data' => $deduction,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Deduction Found",
                )));
            }
        }
        
    }
    public function get_workcode_by_id(){
       
        if($_POST){
            $where = [
                'workcode_id' => $_POST['workcode_id']
            ];
            $workcode = $this->WorkcodeModel->getWhereId($where)[0];
            if(!empty($workcode)){
                die(json_encode(array(
                    "status" => true,
                    'data' => $workcode,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Attendance Found",
                )));
            }
        }   
    }
    public function get_dispatch_by_id(){
        if($_POST){
            $where = [
                'dispatch_id' => $_POST['dispatch_id']
            ];
            $dispatch = $this->DispatchModel->getWhere($where)[0];
            if(!empty($dispatch)){
                die(json_encode(array(
                    "status" => true,
                    'data' => $dispatch,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Dispatch Found",
                )));
            }
        }
     
    }
    public function get_company_by_id(){
        
        if($_POST){
            $where = [
                'company_id' => $_POST['company_id']
            ];
            $company = $this->CompanyModel->getWhere($where)[0];
            if(!empty($company)){
                die(json_encode(array(
                    "status" => true,
                    'data' => $company,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Company Found",
                )));
            }
        }
    }
    public function get_estate_by_id(){
        if($_POST){
            $where = [
                'estate_id' => $_POST['estate_id']
            ];
            $estate = $this->EstateModel->getWhere($where)[0];
            if(!empty($estate)){
                die(json_encode(array(
                    "status" => true,
                    'data' => $estate,
                )));

            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Estate Found",
                )));
            }
        }      

    }
    public function get_mill_by_id(){
        if($_POST){
            $where = [
                'mill_id' => $_POST['mill_id']
            ];
            $mill = $this->MillModel->getWhere($where)[0];
            if(!empty($mill)){

                die(json_encode(array(
                    "status" => true,
                    'data' => $mill,
                )));
            }else{
                die(json_encode(array(
                    "status" => true,
                    'message' => "No Mill Found",
                )));
            }
        }
    }

    //get end..
}
<?php namespace App\Controllers;


use App\Core\BaseController;
use App\Models\CompanyProfitModel;
use App\Models\UsersModel;

class CompanyProfit extends BaseController

{
    public function __construct()
    {

        $this->pageData = array();
        $this->CompanyProfitModel = new CompanyProfitModel();
        $this->UsersModel = new UsersModel();


    }



    public function export_csv(){

        $filter_id =
        ($_GET and isset($_GET['filter_id']))
            ? $_GET['filter_id']
            : 0;

        $dateFrom =

        ($_GET and isset($_GET['dateFrom']))
            ? $_GET['dateFrom']
            : date('Y-m-d');
        $dateTo =
            ($_GET and isset($_GET['dateTo']))
                ? $_GET['dateTo']
                : date('Y-m-d');
        $where = [];
        if($filter_id == 1){
            $where = [
                'company_profit_out <' => 0,
                               
                'DATE(company_profit.created_date) >=' => $dateFrom,
                'DATE(company_profit.created_date) <=' => $dateTo,
            ];
        }else if($filter_id == 2){
            $where = [
                'company_profit_out' => 0,
                  
                'DATE(company_profit.created_date) >=' => $dateFrom,
                'DATE(company_profit.created_date) <=' => $dateTo,
            ];
        }else{

            $where = [
                'DATE(company_profit.created_date) >=' => $dateFrom,
                'DATE(company_profit.created_date) <=' => $dateTo,
            ];
        }

        $users_company_profit = $this->CompanyProfitModel->get_transaction('',1,[],$where);

        // dd($users_company_profit);
        $path = $this->exports_to_csv($users_company_profit,'transaction');
        return redirect()->to($path);
        // return redirect()->to(base_url('member', "refresh"));
    }
    public function index()
    {

        
        $filter_id =
        ($_GET and isset($_GET['filter_id']))
            ? $_GET['filter_id']
            : 0;

        $dateFrom =

        ($_GET and isset($_GET['dateFrom']))
            ? $_GET['dateFrom']
            : date('Y-m-d');
        $dateTo =
            ($_GET and isset($_GET['dateTo']))
                ? $_GET['dateTo']
                : date('Y-m-d');
        $where = [];
        if($filter_id == 1){
            $where = [
                'company_profit_out <' => 0,
                'DATE(company_profit.created_date) >=' => $dateFrom,
                'DATE(company_profit.created_date) <=' => $dateTo,
            ];
        }else if($filter_id == 2){
            $where = [
                'company_profit_out' => 0,
                'DATE(company_profit.created_date) >=' => $dateFrom,
                'DATE(company_profit.created_date) <=' => $dateTo,
            ];
        }else{
            $where = [
                'DATE(company_profit.created_date) >=' => $dateFrom,
                'DATE(company_profit.created_date) <=' => $dateTo,
            ];
        }


        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;


        $users_company_profit = $this->CompanyProfitModel->get_transaction('',1,[],$where);
        // dd($users_company_profit);
        $this->pageData['company_profit'] = $users_company_profit;
      
        echo view('admin/header', $this->pageData);

        echo view('admin/company_profit/all');
        echo view('admin/footer');
        
    }

    public function add()
    {

        if ($_POST) {



            $error = false;

            if (!$error) {

                
                    $this->CompanyProfitModel->company_profit_in($_POST['users_id'], $_POST['amount'], $_POST['remarks']);
        

                return redirect()->to(base_url('company_profit', "refresh"));
            }
        }
        $this->pageData['users'] = $this->UsersModel->getAll();
        $this->pageData['form'] = $this->CompanyProfitModel->generate_input();
       
        echo view('admin/header', $this->pageData);
        echo view('admin/company_profit/add');
        echo view('admin/footer');
    }
}

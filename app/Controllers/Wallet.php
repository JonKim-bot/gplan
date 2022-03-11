<?php namespace App\Controllers;





use App\Core\BaseController;
use App\Models\WalletModel;
use App\Models\UsersModel;

class Wallet extends BaseController
{
    public function __construct()
    {

        $this->pageData = array();
        $this->WalletModel = new WalletModel();
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
        $users_id =
        ($_GET and isset($_GET['users_id']))
            ? $_GET['users_id']
            : 0;
        $where = [];
        if($users_id > 0){
            $where = [
                'wallet.users_id' => $users_id,
                               
                'DATE(wallet.created_date) >=' => $dateFrom,
                'DATE(wallet.created_date) <=' => $dateTo,
            ];
        }else{
            $where = [
                'DATE(wallet.created_date) >=' => $dateFrom,
                'DATE(wallet.created_date) <=' => $dateTo,
            ];
        }

        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);


        // dd($users_wallet);
        $path = $this->exports_to_csv($users_wallet,'transaction');
        return redirect()->to($path);
        // return redirect()->to(base_url('member', "refresh"));
    }
    public function transaction()
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
        $users_id =
        ($_GET and isset($_GET['users_id']))
            ? $_GET['users_id']
            : 0;


        if (session()->get('login_data')['type_id'] == '1') { 
            $users_id = session()->get('login_id');
        }
        $where = [];
        if($users_id > 0 && ($dateFrom != "" && $dateTo != "")){
            $where = [
                'wallet.users_id' => $users_id,
                               
                'DATE(wallet.created_date) >=' => $dateFrom,
                'DATE(wallet.created_date) <=' => $dateTo,
            ];
        }else if(($dateFrom != "" && $dateTo != "")){

            $where = [
                'DATE(wallet.created_date) >=' => $dateFrom,
                'DATE(wallet.created_date) <=' => $dateTo,
            ];
        }


  
        // dd($users_id);
   

        $this->pageData['users_id'] = $users_id;

        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;

        $this->pageData['users'] = $this->UsersModel->getAll();

        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);
        // dd($users_wallet);
        $this->pageData['wallet'] = $users_wallet;
      
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet/transaction');

        // echo view('admin/wallet/all');
        echo view('admin/footer');
        
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
        $users_id =
        ($_GET and isset($_GET['users_id']))
            ? $_GET['users_id']
            : 0;


        if (session()->get('login_data')['type_id'] == '1') { 
            $users_id = session()->get('login_id');
        }
        $where = [];
        if($users_id > 0 && ($dateFrom != "" && $dateTo != "")){
            $where = [
                'wallet.users_id' => $users_id,
                               
                'DATE(wallet.created_date) >=' => $dateFrom,
                'DATE(wallet.created_date) <=' => $dateTo,
            ];
        }else if(($dateFrom != "" && $dateTo != "")){

            $where = [
                'DATE(wallet.created_date) >=' => $dateFrom,
                'DATE(wallet.created_date) <=' => $dateTo,
            ];
        }


  
        // dd($users_id);
   

        $this->pageData['users_id'] = $users_id;

        $this->pageData['dateFrom'] = $dateFrom;
        $this->pageData['dateTo'] = $dateTo;

        $this->pageData['users'] = $this->UsersModel->getAll();

        $users_wallet = $this->WalletModel->get_transaction('',1,[],$where);
        // dd($users_wallet);
        $this->pageData['wallet'] = $users_wallet;
      
        echo view('admin/header', $this->pageData);
        // echo view('admin/wallet/transaction');

        echo view('admin/wallet/all');
        echo view('admin/footer');
        
    }

    public function add()
    {

        if ($_POST) {



            $error = false;


            if (!$error) {

                
                    $this->WalletModel->wallet_in($_POST['users_id'], $_POST['amount'], $_POST['remarks']);
        

                return redirect()->to(base_url('wallet', "refresh"));
            }
        }
        $this->pageData['users'] = $this->UsersModel->getAll();
        $this->pageData['form'] = $this->WalletModel->generate_input();
       
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet/add');
        echo view('admin/footer');
    }
}

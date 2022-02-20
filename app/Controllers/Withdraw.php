<?php namespace App\Controllers;




use App\Core\BaseController;
use App\Models\WalletModel;
use App\Models\WalletWithdrawModel;
class Withdraw extends BaseController
{
    public function __construct()
    {
        $this->WalletModel = new WalletModel();
        $this->WalletWithdrawModel = new WalletWithdrawModel();
    }

    public function index()
    {

        if (session()->get('login_data')['type_id'] == '1') { 
            $users_id = session()->get('login_id');
            $wallet_withdraw = $this->WalletWithdrawModel->getWhere(['wallet_withdraw.users_id' => $users_id]);

        }else{
            $wallet_withdraw = $this->WalletWithdrawModel->getAll();

        }

        $field = $this->WalletWithdrawModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);


        $this->pageData['table'] = $this->generate_table(
            $field,
            $wallet_withdraw,
            'wallet_withdraw',
            'receipt'
        );
        $this->pageData['wallet_withdraw'] = $wallet_withdraw;
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_withdraw/all');
        echo view('admin/footer');
    }

    public function reject($wallet_withdraw_id)
    {
        $where = [
            'wallet_withdraw_id' => $wallet_withdraw_id,
        ];
        $wallet_withdraw = $this->WalletWithdrawModel->getWhere($where)[0];

        $data = [
            'is_rejected' => 1,
            'is_approved' => 0,
        ];
        $data['modified_date'] =date('Y-m-d');

        $data['modified_by'] = session()->get('login_id');


        $this->WalletWithdrawModel->updateWhere($where, $data);

        $remarks = 'Withdrawal rejected refund ';
        $this->WalletModel->wallet_in(
            $wallet_withdraw['users_id'],
            $wallet_withdraw['amount'],
            $remarks,
            $wallet_withdraw_id,
        );
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function approve($wallet_withdraw_id)
    {
        $where = [
            'wallet_withdraw_id' => $wallet_withdraw_id,
        ];
        $wallet_withdraw = $this->WalletWithdrawModel->getWhere($where)[0];

        $data = [
            'is_approved' => 1,
            'is_rejected' => 0,
            'remarks' => "Withdrawal success",
        ];
        $data['modified_by'] = session()->get('login_id');
        $data['modified_date'] = date('Y-m-d');
        

        $remarks = "Withdrawal on user " . $wallet_withdraw['name'];

        $balance = $this->WalletModel->get_balance($wallet_withdraw['users_id']);
        if($balance >= $wallet_withdraw['amount']){
            
            $this->WalletModel->wallet_out(
                $wallet_withdraw['users_id'],
                $wallet_withdraw['amount'],
                $remarks,
            );
            $this->WalletWithdrawModel->updateWhere($where, $data);
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }else{
            alert('Balance not enought');
            locationhref(base_url().'/withdraw');
            // return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }
    public function change_status($wallet_withdraw_id)
    {
        $where = [
            'wallet_withdraw_id' => $wallet_withdraw_id,
        ];
        $wallet_withdraw = $this->WalletWithdrawModel->getWhere($where)[0];
        $is_paid = 0;
        if ($wallet_withdraw['is_paid'] == 1) {
            $is_paid = 0;
        } else {
            $is_paid = 1;
        }
        $this->WalletWithdrawModel->updateWhere($where, [
            'is_paid' => $is_paid,
        ]);
        if ($is_paid == 1) {
            $this->WalletModel->wallet_in(
                $wallet_withdraw['users_id'],
                $wallet_withdraw['amount'],
                $wallet_withdraw['remarks']
            );
        }
        return redirect()->to(base_url('Topup', 'refresh'));
    }

    public function detail($wallet_withdraw_id)
    {
        $where = [
            'wallet_withdraw_id' => $wallet_withdraw_id,
        ];
        $wallet_withdraw = $this->WalletWithdrawModel->getWhere($where)[0];
        $this->pageData['wallet_withdraw'] = $wallet_withdraw;
        $this->pageData['modified_by'] = $this->get_modified_by($wallet_withdraw['modified_by']);

        $field = $this->WalletWithdrawModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'receipt',
            'is_paid',
            'users_id',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $wallet_withdraw,
            'receipt'

        );

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_withdraw/detail');

        echo view('admin/footer');
    }

    public function edit($wallet_withdraw_id)
    {
        $where = [
            'wallet_withdraw_id' => $wallet_withdraw_id,
        ];
        $this->pageData[
            'wallet_withdraw'
        ] = $this->WalletWithdrawModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->WalletWithdrawModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'WalletWithdraw/detail/' . $wallet_withdraw_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->WalletWithdrawModel->generate_edit_input($wallet_withdraw_id);
        $this->pageData[
            'final_form'
        ] = $this->WalletWithdrawModel->get_final_form_edit(
            $wallet_withdraw_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
                'receipt',
                'is_paid',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_withdraw/edit');
        echo view('admin/footer');
    }

    public function add()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {

                if (session()->get('login_data')['type_id'] == '1') { 
                    $users_id = session()->get('login_id');
                    $_POST['users_id'] = $users_id;

                }

                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'receipt');
                // dd($data);
                $balance = $this->WalletModel->get_balance($_POST['users_id']);
                if(floatval($balance) >= floatval($_POST['amount'])){
                    $this->WalletModel->wallet_out(
                        $_POST['users_id'],
                        $_POST['amount'],
                        $_POST['remarks'],
                    );
                    $wallet_withdraw_id = $this->WalletWithdrawModel->insertNew($data);
                    return redirect()->to($_SERVER['HTTP_REFERER']);
                }else{
                    alert('Balance not enought');
                    locationhref(base_url().'/withdraw');
                    // return redirect()->to($_SERVER['HTTP_REFERER']);
                }
            }
        }

        if (session()->get('login_data')['type_id'] == '1') { 
            $this->pageData[
                'final_form'
            ] = $this->WalletWithdrawModel->get_final_form_add([
                'created_by',
                'modified_by',
                'deleted',
                'users_id',
                'modified_date',
                'is_approved',
                'is_rejected',
                'receipt',
                'is_paid',
                'created_date',
            ]);
        }else{
            $this->pageData[
                'final_form'
            ] = $this->WalletWithdrawModel->get_final_form_add([
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'is_approved',
                'is_rejected',
                'receipt',
                'is_paid',
                'created_date',
            ]);
        }


 
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_withdraw/add');
        echo view('admin/footer');
    }
    // function list($status) {
    //     $page = 1;
    //     $filter = array();

    //     if ($_GET) {
    //         $get = $this->request->getGet();

    //         if (!empty($get['page'])) {
    //             $page = $get['page'];
    //         }
    //         if (!empty($get['status_text'])) {
    //             $get['IF(status = 1, "APPROVED", (IF(status = 2, "REJECTED", "PENDING")))'] = $get['status_text'];
    //         }
    //         if (!empty($get['created_date'])) {
    //             $get['transaction.created_date'] = $get['created_date'];
    //         }

    //         unset($get['page']);
    //         unset($get['created_date']);
    //         unset($get['status_text']);
    //         $filter = $get;
    //     }

    //     $where = array(
    //         "transaction_type_id" => 1,
    //         "status" => $status,
    //     );

    //     $user = $this->TransactionModel->getWhere($where, 10, $page, $filter);
    //     $this->pageData['transaction'] = $user['result'];
    //     $this->pageData['page'] = $user['pagination'];
    //     $this->pageData['start_no'] = $user['start_no'];
    //     $this->pageData['status'] = $status;

    //     echo view('admin/header', $this->pageData);
    //     echo view('admin/transaction/all');
    //     echo view('admin/footer');
    // }

    // public function approve($transaction_id)
    // {
    //     if ($_POST) {
    //         $input = $this->request->getPost();

    //         $where = array(
    //             "transaction_id" => $transaction_id,
    //         );

    //         $transaction = $this->TransactionModel->getWhere($where);
    //         if (empty($transaction)) {
    //             $this->show404();
    //         }
    //         $transaction = $transaction[0];

    //         $where = array(
    //             "user_id" => $transaction['user_id'],
    //         );

    //         $user = $this->UserModel->getWhere($where);

    //         if (empty($user)) {
    //             $this->show404();
    //         }
    //         $user = $user[0];

    //         $where = array(
    //             "transaction_id" => $transaction_id,
    //         );

    //         $data = array(
    //             "status" => 1,
    //             "accept_amount" => $input['amount'],
    //         );

    //         $this->TransactionModel->updateWhere($where, $data);
    //         $uprank_user_id = $this->TransactionModel->updateTier($transaction['user_id']);
    //         if ($uprank_user_id != "" AND $uprank_user_id != 0) {
    //             $where = array(
    //                 "user_id" => $uprank_user_id
    //             );

    //             $uprank_user = $this->UserModel->getWhere($where)[0];

    //             $this->TierModel->updateTier($uprank_user['user_id'], $uprank_user['tier']);
    //         }
    //         $this->CommissiontierModel->giveCommissiontier($transaction);

    //         $where = array(
    //             "user_id" => $user['user_id'],
    //         );

    //         $data = array(
    //             "points" => $user['points'] + ($input['amount'] / 1000),
    //         );

    //         $this->UserModel->updateWhere($where, $data);

    //         // see if there is any referral
    //         if ($user['referral_id'] != 0) {
    //             $this->LovingRewardsModel->debit($user['referral_id'],
    //                 ($input['amount'] * 0.1),
    //                 "Referral user #" . $user['user_id'],
    //                 $transaction_id
    //             );
    //         }

    //         return redirect()->to(base_url('transaction/list/1', "refresh"));
    //     }
    // }

    // public function reject($transaction_id)
    // {
    //     $where = array(
    //         "transaction_id" => $transaction_id,
    //     );

    //     $data = array(
    //         "status" => 2,
    //     );

    //     $this->TransactionModel->updateWhere($where, $data);

    //     return redirect()->to(base_url('transaction/list/2', "refresh"));
    // }

    // public function give_commissiontier()
    // {
    //     $where = array(
    //         "transaction_type_id" => 1,
    //         "status" => 1,
    //     );

    //     $transaction = $this->TransactionModel->getWhere($where);
    //     foreach ($transaction as $row) {
    //         $this->CommissiontierModel->giveCommissiontier($row);
    //     }
    // }
}

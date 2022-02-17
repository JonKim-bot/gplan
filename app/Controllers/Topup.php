<?php namespace App\Controllers;




use App\Core\BaseController;
use App\Models\WalletModel;
use App\Models\WalletTopupModel;
class Topup extends BaseController
{
    public function __construct()
    {
        $this->WalletModel = new WalletModel();
        $this->WalletTopupModel = new WalletTopupModel();
    }

    public function index()
    {
        $wallet_topup = $this->WalletTopupModel->getAll();
        // dd($wallet_topup);
        $field = $this->WalletTopupModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $wallet_topup,
            'wallet_topup',
            'receipt'
        );
        $this->pageData['wallet_topup'] = $wallet_topup;
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/all');
        echo view('admin/footer');
    }

    public function reject($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];

        $wallet_topup = $this->WalletTopupModel->getWhere($where)[0];

        $data = [
            'is_rejected' => 1,
            'is_approved' => 0,
            'remarks' => "Topup Rejected",
        ];

        $data['modified_by'] = session()->get('login_id');
        $data['modified_date'] =date('Y-m-d');

        $this->WalletTopupModel->updateWhere($where, $data);

        // $remarks = 'Withdrawal rejected refund ';
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function approve($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];
        // dd($where);
        $wallet_topup = $this->WalletTopupModel->getWhere($where)[0];
        $data = [
            'is_approved' => 1,
            'is_rejected' => 0,
            'remarks' => "Topup success",
        ];
        $data['modified_by'] = session()->get('login_id');

        $data['modified_date'] =date('Y-m-d');


        // $remarks = "Withdrawal on user " . $wallet_topup['name'];

        // $balance = $this->WalletModel->get_balance($wallet_topup['users_id']);
        // if($balance)
        // $this->WalletModel->wallet_out(
        //     $wallet_topup['users_id'],
        //     $wallet_topup['amount'],
        //     $remarks,
        // );
        $remarks = 'Topup success';

        $this->WalletModel->wallet_in(
            $wallet_topup['users_id'],
            $wallet_topup['amount'],
            $remarks,
            0,
            $wallet_topup_id,
        );

        $this->WalletTopupModel->updateWhere($where, $data);
        return redirect()->to($_SERVER['HTTP_REFERER']);

        
    }
    public function change_status($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];
        $wallet_topup = $this->WalletTopupModel->getWhere($where)[0];
        $is_paid = 0;
        if ($wallet_topup['is_paid'] == 1) {
            $is_paid = 0;
        } else {
            $is_paid = 1;
        }
        $this->WalletTopupModel->updateWhere($where, ['is_paid' => $is_paid]);
        if ($is_paid == 1) {
            $this->WalletModel->wallet_in(
                $wallet_topup['users_id'],
                $wallet_topup['amount'],
                $wallet_topup['remarks']
            );
        }
        return redirect()->to(base_url('Topup', 'refresh'));
        
    }

    public function detail($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];


        $wallet_topup = $this->WalletTopupModel->getWhere($where)[0];
        $this->pageData['modified_by'] = $this->get_modified_by($wallet_topup['modified_by']);

        $this->pageData['wallet_topup'] = $wallet_topup;
        $field = $this->WalletTopupModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'is_paid',
            'users_id',
        ]);
        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $wallet_topup,
            'receipt'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/detail');
        echo view('admin/footer');
    }

    public function edit($wallet_topup_id)
    {
        $where = [
            'wallet_topup_id' => $wallet_topup_id,
        ];
        $this->pageData['wallet_topup'] = $this->WalletTopupModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');

                $this->WalletTopupModel->updateWhere($where, $data);

                return redirect()->to(
                    base_url(
                        'WalletTopup/detail/' . $wallet_topup_id,
                        'refresh'
                    )
                );
            }
        }

        // $this->pageData['form'] = $this->WalletTopupModel->generate_edit_input($wallet_topup_id);
        $this->pageData[
            'final_form'
        ] = $this->WalletTopupModel->get_final_form_edit($wallet_topup_id, [
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'created_date',
            'receipt',
            'is_paid',
        ]);

        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/edit');
        echo view('admin/footer');
    }

    public function add()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'receipt');
                // dd($data);
                $this->WalletTopupModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData[
            'final_form'
        ] = $this->WalletTopupModel->get_final_form_add([
            'created_by',
            'modified_by',
            'deleted',
            'modified_date',
            'receipt',
            'is_paid',
            'created_date',
        ]);
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/wallet_topup/add');
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

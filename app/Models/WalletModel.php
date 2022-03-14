<?php namespace App\Models;





use App\Core\BaseModel;
// use App\Models\WalletTopupModel;

class WalletModel extends BaseModel

{
    public function __construct()
    
    {
        parent::__construct();

        $this->tableName = 'wallet';

        $this->primaryKey = 'wallet_id';

        // $this->WalletModel = new WalletModel();
        // $this->WalletTopupModel = new WalletTopupModel();

        $this->builder = $this->db->table($this->tableName);
    }
    function getWhere($where,$limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,users.*
        ');
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
    
        $this->builder->where($where);
        $this->builder->where($this->tableName . '.deleted',0);
    

        if ($limit != '') {
            $count = $this->getCount($filter);
            // die($this->builder->getCompiledSelect(false));
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging($limit, $offset, $page, $pages, $filter,$this->builder);
            return $pagination;
    
        }
        $query = $this->builder->get();
        return $query->getResultArray();
    }
    function get_total_earn($users_id)
    {
        $balance = 0;
        $this->builder->select('SUM(wallet_in) as total_earn_amount');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);
        $this->builder->orderBy('wallet_id', 'DESC');
        $query = $this->builder->get()->getResultArray();
        if (!empty($query)) {
            $balance = $query[0]['total_earn_amount'];
        }
        return $balance;
    }

    function get_total_withdraw($users_id)
    {
        $balance = 0;
        $this->builder->select('SUM(wallet_out) as total_withdraw');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);
        $this->builder->where('wallet_withdraw_id', 0);

        $this->builder->orderBy('wallet_id', 'DESC');
        $query = $this->builder->get()->getResultArray();
        if (!empty($query)) {
            $balance = $query[0]['total_withdraw'];
        }
        return $balance;
    }

    function get_balance($users_id)
    {
        $balance = 0;
        $this->builder->select('*');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);
        $this->builder->orderBy('wallet_id', 'DESC');
        $query = $this->builder->get()->getResultArray();


        if (!empty($query)) {
            $balance = $query[0]['balance'];
        }
        return $balance;
    }
    function get_refferal_point($users_id)
    {
        $balance = 0;
        $this->builder->select('*');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);
        // $this->builder->where('wallet.is_commissiontier', 1);
        $this->builder->orderBy('wallet_id', 'DESC');
        $query = $this->builder->get()->getResultArray();
        

        if (!empty($query)) {
            $balance = $query[0]['balance'];
        }
        return $balance;
    }
    function record_top_up($users_id, $amount)
    {
        $data = [
            
            'users_id' => $users_id,
            'amount' => $amount,
        ];

        // $top_up_id = $this->WalletTopupModel->insertNew($data);
        return $top_up_id;
    }


    function wallet_in($users_id, $amount, $remarks,$family_id = 0 ,$wallet_withdrawal_id = 0,$wallet_topup_id = 0 , $downline_that_exceed_level = 0 )
    {

        $balance = $this->get_balance($users_id);

        $data = [
            'users_id' => $users_id,
            'wallet_in' => $amount,
            'family_id' => $family_id,
            'downline_that_exceed_level' => $downline_that_exceed_level,
            'wallet_withdraw_id' => $wallet_withdrawal_id,
            'wallet_topup_id' => $wallet_topup_id,
            'balance' => $balance + $amount,
            'remarks' => $remarks,

            
        ];

        $this->insertNew($data);
    }

    function wallet_out($users_id, $amount, $remarks, $wallet_withdrawal_id = 0)
    {
        $balance = $this->get_balance($users_id);

        $data = [
            'users_id' => $users_id,
            'wallet_out' => $amount,
            'balance' => $balance - $amount,
            'remarks' => $remarks,
            'wallet_withdraw_id' => $wallet_withdrawal_id,
        ];
        // $users_bank = $this->users_model->get_users_bank([
        //     'users.users_id' => $users_id
        // ])[0];

        // $data_withdrawal = [
        //     'users_id' => $users_id,
        //     'amount' => $amount,
        //     'bank_account' => $users_bank['bank_account'],
        //     'bank_name' => $users_bank['bank_name'],
        //     'account_name' => $users_bank['account_name'],
        // ];
        // $this->Wallet_withdrawal_model->insert($data_withdrawal);
        $this->insertNew($data);
    }

    function finance($users_id, $data)
    {
        $balance = $this->get_balance($users_id);

        $data = [
            'users_id' => $users_id,
            'is_commissiontier' => 1,
            'wallet_in' => $data['amount'],
            'balance' => $balance + $data['amount'],
            'remarks' => $data['remarks'],
        ];
        // $users_bank = $this->users_model->get_users_bank([
        //     'users.users_id' => $users_id
        // ])[0];

        // $data_withdrawal = [
        //     'users_id' => $users_id,

        //     'amount' => $amount,
        //     'bank_account' => $users_bank['bank_account'],
        //     'bank_name' => $users_bank['bank_name'],
        //     'account_name' => $users_bank['account_name'],
        // ];
        // $this->Wallet_withdrawal_model->insert($data_withdrawal);
        $this->insertNew($data);
    }

    function get_total_wallet_in($users_id)
    {
        $this->builder->select('SUM(wallet_in) as total_wallet_in');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);

        $query = $this->builder->get()->getResultArray();

        if (!empty($query)) {
            $result = $query[0]['total_wallet_in'];
        } else {
            $result = 0;
        }

        return $result;
    }

    function get_total_wallet_out($users_id)
    {
        $this->builder->select('SUM(wallet_out) as total_wallet_out');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);

        $query = $this->builder->get()->getResultArray();

        if (!empty($query)) {
            $result = $query[0]['total_wallet_out'];
        } else {
            $result = 0;
        }

        return $result;
    }

    function get_transaction($limit = '', $page = 1, $filter = [], $where = [])
    {
        $this->builder->select(
            'wallet.*, users.name AS users, users.name as name,users.username, users.contact, (wallet_in - wallet_out) AS transaction'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'wallet.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('wallet.created_date DESC');
        if (!empty($where)) {
            $this->builder->where($where);
        }
        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);

            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;
        } else {
            $query = $this->builder->get();
            return $query->getResultArray();
        }
        
    }
    function get_transaction_wherein($wherein, $where = [])
    {
        $this->builder->select(
            'wallet.*, users.name AS users, users.name as name, users.contact, (wallet_in - wallet_out) AS transaction'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'wallet.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('wallet.created_date DESC');
        if (!empty($where)) {
            $this->builder->where($where);
        }
        $this->builder->whereIn('wallet.users_id', $wherein);
        $query = $this->builder->get();
        return $query->getResultArray();
    }


    function get_transaction_by_users($where = [],$limit = 0 )
    {
        $this->builder->select(
            'wallet.*, users.name AS users, users.name, users.contact, (wallet_in - wallet_out) AS transaction'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'wallet.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        if (!empty($where)) {
            $this->builder->where($where);
        }
        if($limit > 0){
            $this->builder->limit($limit);

        }
        $this->builder->orderBy('wallet.created_date DESC');


        $query = $this->builder->get();
        return $query->getResultArray();
    }
    function get_history($where, $limit, $page)

    {

        $this->builder->select(
            'wallet.*, (wallet_in - wallet_out) AS wallet_in'
        );
        $this->builder->from($this->table_name);
        $this->builder->where($where);
        $this->builder->orderBy('wallet_id DESC');
        $this->builder->limit($limit, $page);

        $query = $this->builder->get();
        return $query->getResultArray();
    }

    function get_where($where, $limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('wallet.*');
        $this->builder->from($this->table_name);
        $this->builder->where($where);
        $this->builder->where('wallet.deleted', 0);
        $this->builder->orderBy('wallet.wallet_id', 'DESC');

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;
        } else {
            $query = $this->builder->get();
            return $query->getResultArray();
        }
    }

    function get_all_balance()
    {
        $users = $this->builder
            ->query(
                'SELECT users.users_id, users.name as users, users.contact FROM wallet JOIN users ON users.users_id = wallet.users_id GROUP BY wallet.users_id'
            )
            ->getResultArray();

        foreach ($users as $key => $row) {
            $users[$key]['balance'] = $this->get_balance($row['users_id']);
        }

        return $users;
    }

    function get_history_new($users_id)
    {
        $sql = "(SELECT wallet.wallet_in, ABS(wallet_out) as wallet_out,wallet.created_date,'Success' as status,'Transaction' as type,wallet.remarks
        FROM wallet WHERE wallet.users_id = $users_id and wallet_withdraw_id = 0 and wallet_topup_id = 0 )
        UNION 
       ( SELECT wallet_topup.amount as wallet_in,0 as wallet_out,wallet_topup.created_date,
       
        (
            CASE
                WHEN is_approved = 1 THEN 'Approved'
                WHEN is_rejected = 1 THEN 'Rejected'
                ELSE 'Pending'
            END
        ) as status , 'Topup' as type,wallet_topup.remarks
        FROM wallet_topup
        WHERE wallet_topup.users_id = $users_id)
        UNION 

       ( SELECT wallet_withdraw.amount as wallet_in,0 as wallet_out,wallet_withdraw.created_date,
      
        (
            CASE
                WHEN is_approved = 1 THEN 'Approved'
                WHEN is_rejected = 1 THEN 'Rejected'
                ELSE 'Pending'
            END
        ) as status , 'Withdrawal' as type, wallet_withdraw.remarks 
        FROM wallet_withdraw
        WHERE wallet_withdraw.users_id = $users_id)
        order by created_date desc;
        
        
        ";
        // dd($sql);
        // $this->builder->select('wallet.*, ABS(wallet_out) as wallet_out');
        // $this->builder->from($this->table_name);
        // $this->builder->where($where);
        
        // $this->builder->orderBy('wallet_id DESC');
        $result = $this->db->query($sql)->getResultArray();
        // dd($result);
        return $result;
        // $query = $this->builder->get();
        // return $query->getResultArray();
    }

    function update_wallet($data)
    {
        $balance = $this->get_balance($data['users_id']);
        $wallet_in = $data['amount'] > 0 ? $data['amount'] : 0;
        $wallet_out = $data['amount'] < 0 ? $data['amount'] : 0;
        $wallet_withdrawal_id = !empty($data['wallet_withdraw_id']) ? $data['wallet_withdraw_id'] : 0;

        $data = [
            'users_id' => $data['users_id'],
            'auction_id' => $data['auction_id'],
            'wallet_in' => $wallet_in,
            'wallet_withdraw_id' => $wallet_withdrawal_id,
            'wallet_out' => $wallet_out,
            'balance' => $balance + $wallet_in + $wallet_out,
            'remarks' => $data['remarks'],
        ];
        $this->insertNew($data);
    }
}
?>

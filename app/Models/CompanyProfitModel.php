<?php namespace App\Models;


use App\Core\BaseModel;
// use App\Models\CompanyProfitTopupModel;

class CompanyProfitModel extends BaseModel

{
    public function __construct()
    
    {
        parent::__construct();

        $this->tableName = 'company_profit';
        

        $this->primaryKey = 'company_profit_id';

        // $this->CompanyProfitModel = new CompanyProfitModel();
        // $this->CompanyProfitTopupModel = new CompanyProfitTopupModel();

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
    function get_balance($users_id)
    {
        $balance = 0;
        $this->builder->select('*');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);
        $this->builder->orderBy('company_profit_id', 'DESC');
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
        // $this->builder->where('company_profit.is_commissiontier', 1);
        $this->builder->orderBy('company_profit_id', 'DESC');
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

        // $top_up_id = $this->CompanyProfitTopupModel->insertNew($data);
        return $top_up_id;
    }

    function company_profit_in($users_id, $amount, $remarks,$family_id = 0 ,$company_profit_withdrawal_id = 0,$company_profit_topup_id = 0 )
    {

        $balance = $this->get_balance($users_id);

        $data = [
            'users_id' => $users_id,
            'company_profit_in' => $amount,
            'family_id' => $family_id,
            'company_profit_withdraw_id' => $company_profit_withdrawal_id,
            'company_profit_topup_id' => $company_profit_topup_id,
            'balance' => $balance + $amount,
            'remarks' => $remarks,

            
        ];

        $this->insertNew($data);
    }

    function company_profit_out($users_id, $amount, $remarks, $company_profit_withdrawal_id = 0)
    {
        $balance = $this->get_balance($users_id);

        $data = [
            'users_id' => $users_id,
            'company_profit_out' => $amount,
            'balance' => $balance - $amount,
            'remarks' => $remarks,
            'company_profit_withdrawal_id' => $company_profit_withdrawal_id,
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
        // $this->CompanyProfit_withdrawal_model->insert($data_withdrawal);
        $this->insertNew($data);
    }

    function finance($users_id, $data)
    {
        $balance = $this->get_balance($users_id);

        $data = [
            'users_id' => $users_id,
            'is_commissiontier' => 1,
            'company_profit_in' => $data['amount'],
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
        // $this->CompanyProfit_withdrawal_model->insert($data_withdrawal);
        $this->insertNew($data);
    }

    function get_total_company_profit_in($users_id)
    {
        $this->builder->select('SUM(company_profit_in) as total_company_profit_in');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);

        $query = $this->builder->get()->getResultArray();

        if (!empty($query)) {
            $result = $query[0]['total_company_profit_in'];
        } else {
            $result = 0;
        }

        return $result;
    }

    function get_total_company_profit_out($users_id)
    {
        $this->builder->select('SUM(company_profit_out) as total_company_profit_out');
        $this->builder->from($this->table_name);
        $this->builder->where('users_id', $users_id);

        $query = $this->builder->get()->getResultArray();

        if (!empty($query)) {
            $result = $query[0]['total_company_profit_out'];
        } else {
            $result = 0;
        }

        return $result;
    }

    function get_transaction($limit = '', $page = 1, $filter = [], $where = [])
    {
        $this->builder->select(
            'company_profit.*, users.name AS users, users.name as name, users.contact, (company_profit_in - company_profit_out) AS transaction'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'company_profit.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('company_profit.created_date DESC');
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
            'company_profit.*, users.name AS users, users.name as name, users.contact, (company_profit_in - company_profit_out) AS transaction'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'company_profit.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('company_profit.created_date DESC');
        if (!empty($where)) {
            $this->builder->where($where);
        }
        $this->builder->whereIn('company_profit.users_id', $wherein);
        $query = $this->builder->get();
        return $query->getResultArray();
    }


    function get_transaction_by_users($where = [])
    {
        $this->builder->select(
            'company_profit.*, users.name AS users, users.name, users.contact, (company_profit_in - company_profit_out) AS transaction'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'company_profit.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('company_profit.created_date DESC');
        if (!empty($where)) {
            $this->builder->where($where);
        }

        $query = $this->builder->get();
        return $query->getResultArray();
    }
    function get_history($where, $limit, $page)

    {

        $this->builder->select(
            'company_profit.*, (company_profit_in - company_profit_out) AS company_profit_in'
        );
        $this->builder->from($this->table_name);
        $this->builder->where($where);
        $this->builder->orderBy('company_profit_id DESC');
        $this->builder->limit($limit, $page);

        $query = $this->builder->get();
        return $query->getResultArray();
    }

    function get_where($where, $limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('company_profit.*');
        $this->builder->from($this->table_name);
        $this->builder->where($where);
        $this->builder->where('company_profit.deleted', 0);
        $this->builder->orderBy('company_profit.company_profit_id', 'DESC');

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
                'SELECT users.users_id, users.name as users, users.contact FROM company_profit JOIN users ON users.users_id = company_profit.users_id GROUP BY company_profit.users_id'
            )
            ->getResultArray();

        foreach ($users as $key => $row) {
            $users[$key]['balance'] = $this->get_balance($row['users_id']);
        }

        return $users;
    }

    function get_history_new($users_id)
    {
        $sql = "(SELECT company_profit.company_profit_in, ABS(company_profit_out) as company_profit_out,company_profit.created_date,'Success' as status,'Transaction' as type,company_profit.remarks
        FROM company_profit WHERE company_profit.users_id = $users_id and company_profit_withdraw_id = 0 and company_profit_topup_id = 0 )
        UNION 
       ( SELECT company_profit_topup.amount as company_profit_in,0 as company_profit_out,company_profit_topup.created_date,
       
        (
            CASE
                WHEN is_approved = 1 THEN 'Approved'
                WHEN is_rejected = 1 THEN 'Rejected'
                ELSE 'Pending'
            END
        ) as status , 'Topup' as type,company_profit_topup.remarks
        FROM company_profit_topup
        WHERE company_profit_topup.users_id = $users_id)
        UNION 

       ( SELECT company_profit_withdraw.amount as company_profit_in,0 as company_profit_out,company_profit_withdraw.created_date,
      
        (
            CASE
                WHEN is_approved = 1 THEN 'Approved'
                WHEN is_rejected = 1 THEN 'Rejected'
                ELSE 'Pending'
            END
        ) as status , 'Withdrawal' as type, company_profit_withdraw.remarks 
        FROM company_profit_withdraw
        WHERE company_profit_withdraw.users_id = $users_id)
        order by created_date desc;
        
        
        ";
        // dd($sql);
        // $this->builder->select('company_profit.*, ABS(company_profit_out) as company_profit_out');
        // $this->builder->from($this->table_name);
        // $this->builder->where($where);
        
        // $this->builder->orderBy('company_profit_id DESC');
        $result = $this->db->query($sql)->getResultArray();
        // dd($result);
        return $result;
        // $query = $this->builder->get();
        // return $query->getResultArray();
    }

    function update_company_profit($data)
    {
        $balance = $this->get_balance($data['users_id']);
        $company_profit_in = $data['amount'] > 0 ? $data['amount'] : 0;
        $company_profit_out = $data['amount'] < 0 ? $data['amount'] : 0;
        $company_profit_withdrawal_id = !empty($data['company_profit_withdraw_id']) ? $data['company_profit_withdraw_id'] : 0;

        $data = [
            'users_id' => $data['users_id'],
            'auction_id' => $data['auction_id'],
            'company_profit_in' => $company_profit_in,
            'company_profit_withdraw_id' => $company_profit_withdrawal_id,
            'company_profit_out' => $company_profit_out,
            'balance' => $balance + $company_profit_in + $company_profit_out,
            'remarks' => $data['remarks'],
        ];
        $this->insertNew($data);
    }
}
?>

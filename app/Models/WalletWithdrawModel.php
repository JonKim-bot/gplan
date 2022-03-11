<?php namespace App\Models;


use App\Core\BaseModel;

class WalletWithdrawModel extends BaseModel
{
    
    public function __construct()
    
    {

        parent::__construct();

        $this->tableName = "wallet_withdraw";
        $this->primaryKey = "wallet_withdraw_id";
        $this->builder = $this->db->table($this->tableName);


    }
    
    
    function getAll($limit = '', $page = 1, $filter = [])
    {
        $this->builder->select(
            'wallet_withdraw.*, users.name AS users, users.name as name, users.contact'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'wallet_withdraw.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('wallet_withdraw.created_date DESC');
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
    
    function getWhere($where,$limit = '', $page = 1, $filter = [])
    {
        $this->builder->select(
            'wallet_withdraw.*, users.name AS users, users.name as name, users.contact,
            (
                CASE
                    WHEN is_approved = 1 THEN "Approved"
                    WHEN is_rejected = 1 THEN "Rejected"
                    ELSE "Pending"
                END
            ) as status
            '
        );
        $this->builder->from($this->table_name);
        
        $this->builder->join(
            'users',
            'wallet_withdraw.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('wallet_withdraw.created_date DESC');
        $this->builder->where($where);
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


    function getCountOfUndone($limit = '', $page = 1, $filter = [])
    {
        $where = [
            'is_approved' => 0,
            'is_rejected'=> 0
        ];
        $this->builder->select(
            'COUNT(*) as total_count'
        );
        $this->builder->from($this->table_name);
        $this->builder->where($where);
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
            return $query->getResultArray()[0]['total_count'];
        }
    }
}
?>
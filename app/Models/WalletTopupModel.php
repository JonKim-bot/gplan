<?php namespace App\Models;

use App\Core\BaseModel;

class WalletTopupModel extends BaseModel
{
    
    public function __construct()
    {

        parent::__construct();


        $this->tableName = "wallet_topup";
        $this->primaryKey = "wallet_topup_id";
        $this->builder = $this->db->table($this->tableName);

    }
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder->select(
            'wallet_topup.*, users.name AS users, users.name, users.contact'
        );
        $this->builder->from($this->table_name);
        $this->builder->join(
            'users',
            'wallet_topup.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('wallet_topup.created_date DESC');
    

        $query = $this->builder->get();
        return $query->getResultArray();
    }


    function getWhere($where,$limit = "", $page = 1, $filter = array()){
        $this->builder->select(
            'wallet_topup.*, users.name AS users, users.name, users.contact,
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
            'wallet_topup.users_id = users.users_id AND users.deleted = 0',
            'left'
        );
        $this->builder->orderBy('wallet_topup.created_date DESC');
    
        $this->builder->where($where);

        $query = $this->builder->get();
        return $query->getResultArray();
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
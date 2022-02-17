<?php namespace App\Models;

use App\Core\BaseModel;

class ToturialModel extends BaseModel
{
    function __construct()
    {
        parent::__construct();
        $this->tableName = 'toturial';
        $this->primaryKey = 'toturial_id';
    }
    function getAll($limit = '', $page = 1, $filter = [])
    {
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select(
            $this->tableName .
                '.*,
    (
        CASE
            WHEN status_id = 1 THEN "How it work"
            WHEN status_id = 2 THEN "How to sell"
            ELSE "unknown"
        END
    ) as type
    
    '
        );
        //sample_to_replace
        $this->builder->where($this->tableName . '.deleted', 0);

        if ($limit != '') {
            $count = $this->getCount($filter);
            // die($this->builder->getCompiledSelect(false));
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter,
                $this->builder
            );
            return $pagination;
        }
        $query = $this->builder->get();
        return $query->getResultArray();
    }
    function getWhere($where, $limit = '', $page = 1, $filter = [])
    {
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select(
            $this->tableName .
                '.*,
    (
        CASE
            WHEN status_id = 1 THEN "How it work"
            WHEN status_id = 2 THEN "How to sell"
            ELSE "unknown"
        END
    ) as type
    
    '
        ); //sample_to_replace
        $this->builder->where($where);
        $this->builder->where($this->tableName . '.deleted', 0);

        if ($limit != '') {
            $count = $this->getCount($filter);
            // die($this->builder->getCompiledSelect(false));
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter,
                $this->builder
            );
            return $pagination;
        }
        $query = $this->builder->get();
        return $query->getResultArray();
    }
}

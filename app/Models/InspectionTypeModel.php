<?php namespace App\Models;

use App\Core\BaseModel;

class InspectionTypeModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "inspection_type";
        // $this->single_log('inspection_type');
		$this->primaryKey = "inspection_type_id";
	}
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*');

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
    function getWhere($where,$limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*');
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
	}
<?php namespace App\Models;

use App\Core\BaseModel;

class VariantModel extends BaseModel{

	function __construct(){

		parent::__construct();
        $this->single_log('variant');
		$this->tableName = "variant";
		$this->primaryKey = "variant_id";
	}
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,model.name as model');
        $this->builder->join('model', 'model.model_id = '.$this->tableName.'.model_id', 'left');

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
        $this->builder->select($this->tableName . '.*,model.name as model');
        $this->builder->join('model', 'model.model_id = '.$this->tableName.'.model_id', 'left');
    
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
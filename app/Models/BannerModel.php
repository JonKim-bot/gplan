<?php namespace App\Models;

use App\Core\BaseModel;

class BannerModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "banner";
		$this->primaryKey = "banner_id";
        $this->single_log(('banner'));
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $base_url = base_url();

    $this->builder->select($this->tableName . ".*,
    CONCAT('$base_url', image) as banner,
    (
        CASE
            WHEN type_id = 0 THEN 'Desktop'
            WHEN type_id = 1 THEN 'Mobile'
            ELSE 'Pending'
        END
    ) as type_id
    ");
    //sample_to_replace
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
    $base_url = base_url();

    $this->builder->select($this->tableName . ".*,
    CONCAT('$base_url', image) as banner,
    (
        CASE
            WHEN type_id = 0 THEN 'Desktop'
            WHEN type_id = 1 THEN 'Mobile'
            ELSE 'Pending'
        END
    ) as type_id
    ");
    //sample_to_replace
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
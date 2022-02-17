<?php namespace App\Models;

use App\Core\BaseModel;

class CarImageModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "car_image";
		$this->primaryKey = "car_image_id";
        $this->single_log('car_image');
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*');
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
    $base_url = base_url();
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . ".*, CONCAT('$base_url', car_image.image) as car_image,
    CONCAT('$base_url', car_image.image) as src,
    CONCAT('$base_url', car_image.image) as thumb
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

function getImageWhere($where,$limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*, CONCAT("'.base_url() . '", car_image.image) as image');
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
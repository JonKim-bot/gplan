<?php namespace App\Models;

use App\Core\BaseModel;

class CarInspectionPartModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "car_inspection_part";
		$this->primaryKey = "car_inspection_part_id";
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*,inspection_part.name as inspection_part');
    $this->builder->join('inspection_part', 'inspection_part.inspection_part_id = '.$this->tableName.'.inspection_part_id', 'left');

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
    $this->builder->select($this->tableName . '.*,inspection_part.name as inspection_part,car_inspection_part.car_inspection_part_id as car_inspection_part_ids,
    (SELECT COUNT(*) FROM car_inspection_detail WHERE car_inspection_detail.car_inspection_part_id = car_inspection_part_ids) as total_detail,
    (SELECT COUNT(*) FROM car_inspection_detail WHERE car_inspection_detail.car_inspection_part_id = car_inspection_part_ids and status_id = 1) as total_pass,
    (SELECT COUNT(*) FROM car_inspection_detail WHERE car_inspection_detail.car_inspection_part_id = car_inspection_part_ids and status_id = 2) as total_fail,
    (
        (SELECT COUNT(*) FROM car_inspection_detail WHERE car_inspection_detail.car_inspection_part_id = car_inspection_part_ids and status_id = 1)
        * 100
        /
        (SELECT COUNT(*) FROM car_inspection_detail WHERE car_inspection_detail.car_inspection_part_id = car_inspection_part_ids) 
    ) as percentage


    ');
    $this->builder->join('inspection_part', 'inspection_part.inspection_part_id = '.$this->tableName.'.inspection_part_id', 'left');

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
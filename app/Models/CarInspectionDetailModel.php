<?php namespace App\Models;

use App\Core\BaseModel;

class CarInspectionDetailModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "car_inspection_detail";
		$this->primaryKey = "car_inspection_detail_id";
        // $this->single_log('car_inspection_detail');
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*,inspection_detail.name as inspection_detail,
    (
        CASE
            WHEN status_id = 1 THEN "Pass"
            WHEN status_id = 2 THEN "Fail"
            WHEN status_id = 3 THEN "NA"

            ELSE "unknown"
        END
    ) as status
    
    ');
    $this->builder->join('inspection_detail', 'inspection_detail.inspection_detail_id = '.$this->tableName.'.inspection_detail_id', 'left');

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
    $this->builder->select($this->tableName . '.*,inspection_detail.name as inspection_detail,
    (
        CASE
        WHEN status_id = 1 THEN "Pass"
        WHEN status_id = 2 THEN "Fail"
        WHEN status_id = 3 THEN "NA"
            ELSE "unknown"
        END
    ) as status
    ');
    $this->builder->join('inspection_detail', 'inspection_detail.inspection_detail_id = '.$this->tableName.'.inspection_detail_id', 'left');
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
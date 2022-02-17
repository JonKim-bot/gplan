<?php namespace App\Models;

use App\Core\BaseModel;

class InspectionDetailModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "inspection_detail";
		$this->primaryKey = "inspection_detail_id";
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
    $this->builder->select($this->tableName . '.*,inspection_part.name as inspection_part');
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

    // daniel added
    public function getWhereCar($where){
        
        $car_id = $where['car_id'];
        $inspection_part_id = $where['inspection_part_id'];

        $sql = "SELECT inspection_detail.name, inspection_detail.name as inspection_detail,inspection_detail.inspection_detail_id, car_inspection.status_id,
        car_inspection.car_inspection_id as car_inspection_ids,
        (
            CASE
                WHEN car_inspection.status_id = 1 THEN 'Pass'
                WHEN car_inspection.status_id = 2 THEN 'Fail'
                WHEN car_inspection.status_id = 3 THEN 'NA'


                ELSE 'Pending'
            END
        ) as status,
        (SELECT COUNT(*) FROM `car_inspection` INNER JOIN
         car_inspection_image on car_inspection_image.car_inspection_id 
         = car_inspection.car_inspection_id WHERE car_inspection.car_inspection_id = car_inspection_ids) as total_image
        
        ,car_inspection.car_inspection_id
        FROM inspection_detail 
        LEFT JOIN car_inspection ON car_inspection.inspection_detail_id = inspection_detail.inspection_detail_id
        WHERE inspection_detail.inspection_part_id = $inspection_part_id AND car_inspection.car_id = $car_id
        ";

        
        $result = $this->db->query($sql)->getResultArray();

        return $result;
    }    

	}
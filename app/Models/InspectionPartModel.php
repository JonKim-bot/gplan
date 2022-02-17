<?php namespace App\Models;


use App\Core\BaseModel;

class InspectionPartModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "inspection_part";
        // $this->single_log('inspection_part');
		$this->primaryKey = "inspection_part_id";
	}
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,inspection_type.name as inspection_type,inspection_part.name as inspection_part');
        $this->builder->join('inspection_type', 'inspection_type.inspection_type_id = '.$this->tableName.'.inspection_type_id', 'left');

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
        $this->builder->select($this->tableName . '.*,inspection_type.name as inspection_type,inspection_part.name as inspection_part');
        $this->builder->join('inspection_type', 'inspection_type.inspection_type_id = '.$this->tableName.'.inspection_type_id', 'left');

        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->where($where);

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

    function getWith($where,$limit = "", $page = 1, $filter = array()){
        $car_id = $where['car_inspection.car_id'];

        $this->builder = $this->db->table($this->tableName);

        $total_sql = 'SELECT COUNT(*) FROM `car_inspection` LEFT JOIN inspection_detail on inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id
        WHERE inspection_detail.inspection_part_id = inspection_part_ids and car_inspection.car_id = '.$car_id.'';
     
        $this->builder->select($this->tableName . '.*,inspection_type.name as inspection_type,inspection_part.name as inspection_part,
        inspection_part.inspection_part_id as inspection_part_ids 
        ,
        ('.$total_sql.') as total_detail
        ,
        (SELECT COUNT(*) FROM `car_inspection` LEFT JOIN inspection_detail on inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id
        WHERE inspection_detail.inspection_part_id = inspection_part_ids and status_id = 1
        and car_inspection.car_id = '.$car_id.'
        ) as total_pass
        ,
        (SELECT COUNT(*) FROM `car_inspection` LEFT JOIN inspection_detail on inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id
        WHERE inspection_detail.inspection_part_id = inspection_part_ids and status_id = 2 and car_inspection.car_id = '.$car_id.') as total_fail

        ,
        (

            (SELECT COUNT(*) FROM `car_inspection` LEFT JOIN inspection_detail on inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id
            WHERE inspection_detail.inspection_part_id = inspection_part_ids and status_id = 1 and car_inspection.car_id = '.$car_id.')
            * 100
            /
            (SELECT COUNT(*) FROM `car_inspection` LEFT JOIN inspection_detail on inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id
            WHERE inspection_detail.inspection_part_id = inspection_part_ids and car_inspection.car_id = '.$car_id.')
        ) as percentage
        
        
        ');
        $this->builder->join('inspection_type', 'inspection_type.inspection_type_id = '.$this->tableName.'.inspection_type_id', 'left');
        $this->builder->join('inspection_detail', 'inspection_detail.inspection_part_id = '.$this->tableName.'.inspection_part_id', 'right');
        $this->builder->join('car_inspection', 'car_inspection.inspection_detail_id = inspection_detail.inspection_detail_id', 'right');
        $this->builder->where($where);
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->groupBy('inspection_part.inspection_part_id');

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

    function getWhereCar($inspection_type_id, $car_id){

        $sql = "SELECT inspection_part.*,
                (SELECT COUNT(*) FROM inspection_detail LEFT JOIN car_inspection ON inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id 
                WHERE inspection_detail.inspection_part_id = inspection_part.inspection_part_id AND car_inspection.status_id = 1 AND car_inspection.car_id = $car_id) AS total_pass,
                (SELECT COUNT(*) FROM inspection_detail LEFT JOIN car_inspection ON inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id 
                WHERE inspection_detail.inspection_part_id = inspection_part.inspection_part_id AND car_inspection.status_id < 3 AND car_inspection.car_id = $car_id) AS total_detail,
                (SELECT COUNT(*) FROM inspection_detail LEFT JOIN car_inspection ON inspection_detail.inspection_detail_id = car_inspection.inspection_detail_id 
                WHERE inspection_detail.inspection_part_id = inspection_part.inspection_part_id AND car_inspection.status_id = 3 AND car_inspection.car_id = $car_id) AS total_na
                FROM inspection_part 
                WHERE inspection_type_id = $inspection_type_id AND deleted = 0";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

	}
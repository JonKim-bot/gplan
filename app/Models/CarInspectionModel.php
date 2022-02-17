<?php namespace App\Models;

use App\Core\BaseModel;

class CarInspectionModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "car_inspection";
		$this->primaryKey = "car_inspection_id";
	}

    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,
            (
                CASE
                    WHEN status_id = 1 THEN "Pass"
                    WHEN status_id = 2 THEN "Fail"
                    ELSE "Pending"
                END
            ) as status
        ');

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
        $this->builder->select($this->tableName . '.*,
        (
            CASE
                WHEN status_id = 1 THEN "Pass"
                WHEN status_id = 2 THEN "Fail"
                ELSE "Pending"
            END
        ) as status
        
        ');

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
    function getSummary($car_id){

        $sql = "SELECT COUNT(*) AS total FROM car_inspection WHERE car_id = $car_id AND deleted = 0";
        $total = $this->db->query($sql)->getResultArray()[0]['total'];

        $sql = "SELECT COUNT(*) AS total_pass FROM car_inspection WHERE status_id = 1 AND car_id = $car_id AND deleted = 0";
        $total_pass = $this->db->query($sql)->getResultArray()[0]['total_pass'];

        $sql = "SELECT COUNT(*) AS total_fail FROM car_inspection WHERE status_id = 2 AND car_id = $car_id AND deleted = 0";
        $total_fail = $this->db->query($sql)->getResultArray()[0]['total_fail'];

        $result = [
            'total' => $total,
            'total_pass' => $total_pass,
            'total_fail' => $total_fail,
        ];
        return $result;
    }
}
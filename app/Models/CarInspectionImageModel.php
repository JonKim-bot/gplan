<?php namespace App\Models;

use App\Core\BaseModel;

class CarInspectionImageModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "car_inspection_image";
		$this->primaryKey = "car_inspection_image_id";
	}

	function getWhereImages($car_inspection_id){

		$base_url = base_url();
        $sql = "SELECT *, CONCAT('$base_url', image) as image FROM car_inspection_image WHERE car_inspection_id = $car_inspection_id AND deleted = 0";
        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }
}
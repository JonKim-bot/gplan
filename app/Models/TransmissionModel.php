<?php namespace App\Models;

use App\Core\BaseModel;

class TransmissionModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "transmission";
		$this->primaryKey = "transmission_id";
	}
	}
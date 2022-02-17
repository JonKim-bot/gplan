<?php namespace App\Models;

use App\Core\BaseModel;

class ColorModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "color";
		$this->primaryKey = "color_id";
	}

}
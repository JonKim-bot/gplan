<?php namespace App\Models;

use App\Core\BaseModel;

class BankModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "bank";
		$this->primaryKey = "bank_id";
	}

}
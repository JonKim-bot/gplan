<?php namespace App\Models;

use App\Core\BaseModel;

class TransferFeeModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "transfer_fee";
		$this->primaryKey = "transfer_fee_id";
	}

    function getAllRaw(){
        
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*');
        $this->builder->where($this->tableName . '.deleted',0);

        $query = $this->builder->get();
        return $query->getResultArray();
    }
}
<?php namespace App\Models;

use App\Core\BaseModel;

class FamilyModel extends BaseModel
{
    
    public function __construct()
    {

        parent::__construct();


        $this->tableName = "family";
        $this->primaryKey = "family_id";
        $this->builder = $this->db->table($this->tableName);

    }
   
}
?>
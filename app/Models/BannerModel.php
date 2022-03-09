<?php namespace App\Models;

use App\Core\BaseModel;

class BannerModel extends BaseModel
{

    public function __construct()
    {

        parent::__construct();

        $this->tableName = "banner";
        $this->primaryKey = "banner_id";

    }

 
}

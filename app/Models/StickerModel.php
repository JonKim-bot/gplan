<?php namespace App\Models;

use App\Core\BaseModel;

class StickerModel extends BaseModel{

	function __construct(){
		parent::__construct();
		$this->tableName = "sticker";
		$this->primaryKey = "sticker_id";
	}
}
?>
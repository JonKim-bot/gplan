<?php namespace App\Models;

use App\Core\BaseModel;

class NotificationUpdateModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "notification_update";
		$this->primaryKey = "notification_update_id";
	}
}
?>
<?php namespace App\Models;

use App\Core\BaseModel;

class AuctionStatusBuyerModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "auction_status_buyer";
		$this->primaryKey = "auction_status_buyer_id";
	}
}
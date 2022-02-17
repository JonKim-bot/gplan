<?php namespace App\Models;

use App\Core\BaseModel;

class BidAutoModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "bid_auto";
		$this->primaryKey = "bid_auto_id";
        $this->all_logs();
	}

    function getMaximumBid($auction_id){

        $maximum = 0;
        $sql = "SELECT MAX(max_price) as maximum FROM bid_auto WHERE auction_id = $auction_id";
        $query = $this->db->query($sql)->getResultArray();

        if($query[0]['maximum'] != 0){
            $maximum = $query[0]['maximum'];
        }
        return $maximum;
    }

    function getWhereGroupUser($auction_id){
        $sql = "SELECT DISTINCT users_id, auction_id, (SELECT MAX(price) FROM bid_auto b1 WHERE b1.users_id = bid_auto.users_id AND b1.auction_id = $auction_id LIMIT 1) as price, 
            (SELECT MAX(max_price) FROM bid_auto b2 WHERE b2.users_id = bid_auto.users_id AND b2.auction_id = $auction_id LIMIT 1) as max_price
            FROM bid_auto WHERE auction_id = $auction_id";
        return $this->db->query($sql)->getResultArray();
    }

    function getWhereGroup($auction_id, $max_price){
        $sql = "SELECT DISTINCT users_id FROM bid_auto WHERE auction_id = $auction_id AND max_price >= $max_price";
        return $this->db->query($sql)->getResultArray();
    }

    function getWhereMax($auction_id, $users_id){

        $maximum = 0;
        $sql = "SELECT MAX(max_price) as maximum FROM bid_auto WHERE auction_id = $auction_id AND users_id = $users_id";
        $query = $this->db->query($sql)->getResultArray();

        if($query[0]['maximum'] != 0){
            $maximum = $query[0]['maximum'];
        }
        return $maximum;
    }
}
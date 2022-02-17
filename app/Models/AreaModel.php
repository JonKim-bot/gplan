<?php namespace App\Models;

use App\Core\BaseModel;

class AreaModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "area";
		$this->primaryKey = "area_id";
	}

	function getWhereAuction($where){

        $base_url = base_url();
        $sql = "SELECT area.*,
                (SELECT COUNT(*) FROM auction 
                LEFT JOIN car ON car.car_id = auction.car_id 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                WHERE DATE(auction_section.date) = DATE(NOW()) AND auction_section.end_time > NOW() AND car.area_id = area.area_id) as total_auction
                FROM area 
                WHERE $where";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

	}
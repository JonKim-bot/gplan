<?php namespace App\Models;

use App\Core\BaseModel;

class StateModel extends BaseModel{

	function __construct(){

		parent::__construct();
        $this->single_log('state');
		$this->tableName = "state";
		$this->primaryKey = "state_id";
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*');
    //sample_to_replace
    $this->builder->where($this->tableName . '.deleted',0);

    if ($limit != '') {
        $count = $this->getCount($filter);
        // die($this->builder->getCompiledSelect(false));
        $offset = ($page - 1) * $limit;
        $pages = $count / $limit;
        $pages = ceil($pages);
        $pagination = $this->getPaging($limit, $offset, $page, $pages, $filter,$this->builder);
        return $pagination;

    }
    $query = $this->builder->get();
    return $query->getResultArray();
}
function getWhere($where,$limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*');
    //sample_to_replace
    $this->builder->where($where);
    $this->builder->where($this->tableName . '.deleted',0);

    if ($limit != '') {
        $count = $this->getCount($filter);
        // die($this->builder->getCompiledSelect(false));
        $offset = ($page - 1) * $limit;
        $pages = $count / $limit;
        $pages = ceil($pages);
        $pagination = $this->getPaging($limit, $offset, $page, $pages, $filter,$this->builder);
        return $pagination;

    }
    $query = $this->builder->get();
    return $query->getResultArray();
}

    function getWhereAuction($where){

        $base_url = base_url();
        $sql = "SELECT state.*,
                (SELECT COUNT(*) FROM auction 
                LEFT JOIN car ON car.car_id = auction.car_id 
                LEFT JOIN area ON area.area_id = car.area_id 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                WHERE DATE(auction_section.date) = DATE(NOW()) AND auction_section.end_time > NOW() AND area.state_id = state.state_id) as total_auction
                FROM state 
                WHERE $where";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }
	}
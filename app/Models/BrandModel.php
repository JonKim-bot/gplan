<?php namespace App\Models;

use App\Core\BaseModel;

class BrandModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "brand";
		$this->primaryKey = "brand_id";
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*');

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

    function getWhereImage($where){

        $base_url = base_url();
        $sql = "SELECT brand.*, CONCAT('$base_url', brand.logo) as image,
                (SELECT COUNT(*) FROM auction 
                LEFT JOIN car ON car.car_id = auction.car_id 
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                WHERE DATE(auction_section.date) = DATE(NOW()) AND auction_section.end_time > NOW() AND model.brand_id = brand.brand_id) as total_auction
                FROM brand 
                WHERE $where";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

	}
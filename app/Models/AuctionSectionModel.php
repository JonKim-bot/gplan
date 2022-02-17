<?php namespace App\Models;


use App\Core\BaseModel;

class AuctionSectionModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "auction_section";
		$this->primaryKey = "auction_section_id";
        // $this->all_logs();
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*');
    //sample_to_replace
    $this->builder->where($this->tableName . '.deleted',0);
    $this->builder->orderBy($this->tableName . '.created_date','DESC');

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
    $this->builder->orderBy($this->tableName . '.created_date','DESC');

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


    public function getAvailableDate(){
        

        $sql = "SELECT auction_section_id, date, start_time, end_time FROM auction_section 
        WHERE deleted = 0 AND 
        (date > DATE(NOW()) OR (date = DATE(NOW()) AND start_time > TIME(NOW()))) ORDER BY date ASC, end_time ASC";
        return $this->db->query($sql)->getResultArray();
    }

	}
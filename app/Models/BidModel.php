<?php namespace App\Models;


use App\Core\BaseModel;

class BidModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "bid";
		$this->primaryKey = "bid_id";
        $this->all_logs();
	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*,users.name as users
    ,auction.auction_id,model.name as model,car.plate_no');
    //sample_to_replace
    $this->builder->join('auction', 'auction.auction_id = '.$this->tableName.'.auction_id', 'left');

    $this->builder->join('car', 'car.car_id = auction.car_id', 'left');
    $this->builder->join('model', 'car.model_id = model.model_id', 'left');

    $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');

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
    $this->builder->select($this->tableName . '.*,users.name as users
    ,auction.auction_id,model.name as model,car.plate_no');
    //sample_to_replace
    $this->builder->join('auction', 'auction.auction_id = '.$this->tableName.'.auction_id', 'left');

    $this->builder->join('car', 'car.car_id = auction.car_id', 'left');
    $this->builder->join('model', 'car.model_id = model.model_id', 'left');

    $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
    //sample_to_replace
    $this->builder->where($where);
    $this->builder->where($this->tableName . '.deleted',0);
    $this->builder->orderBy("bid.bid_id","desc");
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

    function get_current_selling_price($auction_id){

        $sql = "SELECT starting_price FROM auction WHERE auction_id = $auction_id";
        $query = $this->db->query($sql)->getResultArray();

        $selling_price = $query[0]['starting_price'];

        $sql = "SELECT MAX(current_selling_price) as selling_price FROM bid WHERE auction_id = $auction_id";
        $query = $this->db->query($sql)->getResultArray();

        if($query[0]['selling_price'] != 0){
            $selling_price = $query[0]['selling_price'];
        }
        return $selling_price;
    }

    function get_last_users_id($auction_id){

        $users_id = 0;
        $sql = "SELECT users_id FROM bid WHERE auction_id = $auction_id ORDER BY bid_id DESC";
        $query = $this->db->query($sql)->getResultArray();
        if(!empty($query)){
            $users_id = $query[0]['users_id'];
        }
        return $users_id;
    }

    function get_last_bid($auction_id){

        $sql = "SELECT * FROM bid WHERE auction_id = $auction_id ORDER BY bid_id DESC";
        $query = $this->db->query($sql)->getResultArray();

        return $query;
    }

    function getWhereLimit($where, $limit){
        

        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*, users.name as users, auction.auction_id, model.name as model, car.plate_no');
        $this->builder->join('auction', 'auction.auction_id = '.$this->tableName.'.auction_id', 'left');
        $this->builder->join('car', 'car.car_id = auction.car_id', 'left');
        $this->builder->join('model', 'car.model_id = model.model_id', 'left');
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
        $this->builder->where($where);
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->orderBy("bid.bid_id","desc");
        $this->builder->limit($limit);
       
        $query = $this->builder->get();
        return $query->getResultArray();
    }

    function getFailedBidder($users_id, $auction_id){
        $sql = "SELECT users_id FROM bid WHERE users_id != $users_id AND auction_id = $auction_id GROUP BY users_id";
        return $this->db->query($sql)->getResultArray();
    }

	}
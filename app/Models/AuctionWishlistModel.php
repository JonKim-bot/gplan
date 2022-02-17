<?php namespace App\Models;

use App\Core\BaseModel;

class AuctionWishlistModel extends BaseModel
{
    
    public function __construct()
    {

        parent::__construct();


        $this->tableName = "auction_wishlist";
        $this->primaryKey = "auction_wishlist_id";
        $this->builder = $this->db->table($this->tableName);

    }
    function getWhere($where,$limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,users.name as username , users.contact 
        ');
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
    
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

    function getWhereBuyer($auction_id){

        $sql = "SELECT auction_wishlist.*, users.name as username, users.contact,
            (SELECT users_id FROM car LEFT JOIN auction ON auction.car_id = car.car_id WHERE auction.auction_id = auction_wishlist.auction_id) AS seller_id 
            FROM auction_wishlist 
            LEFT JOIN users ON users.users_id = auction_wishlist.users_id 
            WHERE auction_wishlist.auction_id = $auction_id AND auction_wishlist.deleted = 0";
        return $this->db->query($sql)->getResultArray();
    }
}
?>
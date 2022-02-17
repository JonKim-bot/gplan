<?php namespace App\Models;

use App\Core\BaseModel;

class WalletWishlistModel extends BaseModel
{
    
    public function __construct()
    {

        parent::__construct();


        $this->tableName = "wallet_wishlist";
        $this->primaryKey = "wallet_wishlist_id";
        $this->builder = $this->db->table($this->tableName);

    }
}
?>
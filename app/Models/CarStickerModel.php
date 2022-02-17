<?php namespace App\Models;

use App\Core\BaseModel;

class CarStickerModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "car_sticker";
		$this->primaryKey = "car_sticker_id";
	}


	function getWhere($where,$limit = "", $page = 1, $filter = array()){
        $base_url = base_url();

        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,sticker.image, CONCAT("'.$base_url.'", sticker.image) as sticker_image , sticker.description');
        $this->builder->join('sticker', 'sticker.sticker_id = '.$this->tableName.'.sticker_id', 'left');
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

}
?>
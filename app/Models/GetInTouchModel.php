<?php namespace App\Models;


use App\Core\BaseModel;

class GetInTouchModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->tableName = 'get_in_touch';
        $this->primaryKey = 'get_in_touch_id';

        $this->builder = $this->db->table($this->tableName);
    }

    function getCountUndone($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select('COUNT(*) as total');
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->where($this->tableName . '.is_read',0);
        $this->builder->orderBy($this->tableName . '.' . $this->primaryKey,'DESC');

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
        return $query->getResultArray()[0]['total'];
    }

}
?>

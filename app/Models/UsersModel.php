<?php namespace App\Models;



use App\Core\BaseModel;

class UsersModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "users";
		$this->primaryKey = "users_id";
	}


    function getCountUndone($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select('COUNT(*) as total');
    
        $this->builder->where($this->tableName . '.deleted',0);
    
        $this->builder->where($this->tableName . '.is_verified',0);

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

    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*');
        //sample_to_replace
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->orderBy($this->tableName . '.users_id','DESC');

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
        $this->builder->orderBy($this->tableName . '.users_id','DESC');

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


    public function user_family($family_id){
        $families = array([$family_id]);
        $result = $this->recursive_users($families);
        $this->debug($result);
    }

    public function recursive_users($families){
        $key = array_key_last($families);
        $next = array();
        $stop = true;
        foreach($families[$key] as $row){
            $family = $this->db->query("SELECT * FROM family WHERE link_family_id = $row")->getResultArray();
            foreach($family as $fmy){
                array_push($next, $fmy['user_id']);
                $family_id = $fmy['family_id'];
                $more = $this->db->query("SELECT * FROM family WHERE link_family_id = $family_id")->getResultArray();
                if(!empty($more)){
                    $stop = false;
                }
            }
        }
        array_push($families, $next);
        // check if level 15 full
        if(isset($result[15]) && count($result[15]) == 30){
            return $families;
        }
        if(!$stop){
            return $this->recursive_users($families);
        }
        return $families;
    }

    public function insert_new_member($new_member, $family_id){

        $existed = $this->db->query("SELECT * FROM family WHERE user_id = $new_member")->getResultArray();
        if(empty($existed)){
            $slot_family_id = $this->find_empty_slot($family_id);
            $this->db->insert('family', ['link_family_id' => $slot_family_id, 'user_id' => $new_member]);
            $new_family_id = $this->db->insert_id();
            $this->insert_commission($new_family_id);
        }
        $this->user_family($family_id);
    }

    public function find_empty_slot($family_id){
        $families = array([$family_id]);
        $result = $this->recursive_users($families);
        $slot_family_id = $family_id;
        foreach($result as $index => $row){ // result index = level;
            if($index != 0 && count($row) < $index * 2){  // count($result[$index]) < $index * 2 then mean level no full 
                foreach($result[$index - 1] as $link){
                    $find_slot = $this->db->query("SELECT COUNT(*) as total FROM family WHERE link_family_id = $link HAVING total < 2")->getResultArray();
                    if(!empty($find_slot)){
                        $slot_family_id = $link;
                        break;
                    }
                }
            }
        }
        return $slot_family_id;
    }

    public function insert_commission($family_id){
        $upline = $this->recursive_upline($family_id); // find all upline
        $commission = 10;
        foreach($upline as $row){
            $result = $this->recursive_users([[$row]]);
            if(isset($result[11]) && count($result[11]) < 22){ // check if level 11 is full
                $commission = 30;
            }
            $user = $this->db->query("SELECT * FROM family WHERE family_id = $row")->getResultArray()[0];
            $user_id = $user['user_id'];
            $existed = $this->db->query("SELECT * FROM family_commission WHERE user_id = $user_id AND family_id = $family_id")->getResultArray();
            if(empty($existed)){
                $this->db->insert('family_commission', ['user_id' => $user_id, 'commission' => $commission, 'family_id' => $family_id]);
            }
        }
    }

    public function recursive_upline($family_id, $upline = array()){
        $family = $this->db->query("SELECT * FROM family WHERE family_id = $family_id")->getResultArray()[0];
        if($family['link_family_id'] != 0){
            $link_family_id = $family['link_family_id'];
            array_push($upline, $link_family_id);
            $up_family = $this->db->query("SELECT * FROM family WHERE family_id = $link_family_id")->getResultArray()[0];
            if($up_family['link_family_id'] != 0){
                return $this->recursive_upline($link_family_id, $upline);
            }
        }
        return $upline;
    }

}
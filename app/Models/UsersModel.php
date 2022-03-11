<?php namespace App\Models;




use App\Core\BaseModel;

class UsersModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "users";
		$this->primaryKey = "users_id";
	}

    public function get_user_name($users_id){
        $where = [
            'users.users_id' => $users_id
        ];
        $users = $this->getWhere($where)[0]['name'];
        return $users;

    }
    function get_downline($users_id){

        $this->builder = $this->db->table($this->tableName);
        
        $this->builder->select('*');
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->where($this->tableName . '.reference_id',$users_id);

     
        $query = $this->builder->get();
        return $query->getResultArray();
    }


    function get_family_user($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        
        $this->builder->select('*');

        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->join('family', 'family.user_id = '.$this->tableName.'.users_id');


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
        $this->builder->select($this->tableName . '.*,users.users_id');
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
        // -- (SELECT name FROM users WHERE users_id = (SELECT user_id FROM family WHERE family.family_id = fid)) as family_name,

        $this->builder->select($this->tableName . '.*,users.family_id as fid,
        


        (SELECT users_id FROM users WHERE users_id = fid) as users_family_id
        
        ');
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


    
    public function get_user_with_no_downline(){
        
        $sql = "SELECT * FROM users WHERE self_family_id NOT IN (select link_family_id from family) AND users.is_verified = 1";

        $result = $this->db->query($sql)->getResultArray();

        return $result;

    }



}
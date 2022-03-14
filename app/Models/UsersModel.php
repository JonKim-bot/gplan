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
        
        $sql = "SELECT * FROM users WHERE self_family_id NOT IN (select link_family_id from family) AND users.is_verified = 1 AND users.deleted = 0 ";

        $result = $this->db->query($sql)->getResultArray();

        return $result;

    }

    

    public function getTree($user_id)
    {
        $this->builder->select("*");
        $this->builder->where("reference_id", $user_id);
        $this->builder->where("users.deleted", 0);

        $users = $this->builder->get()->getResultArray();
        foreach ($users as $key => $row) {
            // $users[$key]['self_sales'] = $this->getSelfSales($row['user_id']);
            // $users[$key]['total_received_point'] = $this->PointModel->get_total_received_point($row['user_id']);
            // $users[$key]['group_sales'] = $this->getGroupTotalSales($row['user_id']);
            // $users[$key]['downline_count'] = $this->recursive_get_downline_count($row['user_id']);
            // //included own sales
            $this->builder->select("*");
            $this->builder->where("reference_id", $row['users_id']);
            $this->builder->where("users.deleted", 0);


            $child = $this->builder->get()->getResultArray();
            foreach ($child as $ckey => $crow) {
                // $child[$ckey]['self_sales'] = $this->getSelfSales($crow['user_id']);
                // $child[$ckey]['total_received_point'] = $this->PointModel->get_total_received_point($crow['user_id']);
                // $child[$ckey]['group_sales'] = $this->getGroupTotalSales($crow['user_id']);
                // $child[$ckey]['downline_count'] = $this->recursive_get_downline_count($crow['user_id']);

                $this->builder->select("*");
                $this->builder->where("reference_id", $crow['users_id']);

                $this->builder->where("users.deleted", 0);

                $gchild = $this->builder->get()->getResultArray();
                foreach ($gchild as $gkey => $grow) {
                    // $gchild[$gkey]['self_sales'] = $this->getSelfSales($grow['user_id']);
                    // $gchild[$gkey]['total_received_point'] = $this->PointModel->get_total_received_point($grow['user_id']);
                    // $gchild[$gkey]['group_sales'] = $this->getGroupTotalSales($grow['user_id']);
                    // $gchild[$gkey]['downline_count'] = $this->recursive_get_downline_count($grow['user_id']);

                    $this->builder->select("*");
                    $this->builder->where("reference_id", $grow['users_id']);
    
                    $ggchild = $this->builder->get()->getResultArray();
                    foreach ($ggchild as $ggkey => $ggrow) {
                        // $ggchild[$ggkey]['self_sales'] = $this->getSelfSales($ggrow['user_id']);
                        // $ggchild[$ggkey]['total_received_point'] = $this->PointModel->get_total_received_point($ggrow['user_id']);
                        // $ggchild[$ggkey]['group_sales'] = $this->getGroupTotalSales($ggrow['user_id']);
                        // $ggchild[$ggkey]['downline_count'] = $this->recursive_get_downline_count($ggrow['user_id']);

                    }
            
                    $gchild[$gkey]['children'] = $ggchild;

                }
                $child[$ckey]['children'] = $gchild;
            }
            $users[$key]['children'] = $child;
        }


        return $users;

    }
    



}
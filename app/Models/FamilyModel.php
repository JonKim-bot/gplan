<?php namespace App\Models;




use App\Core\BaseModel;
use App\Models\WalletModel;

class FamilyModel extends BaseModel
{
    
    public function __construct()
    {

        parent::__construct();


        $this->tableName = "family";
        $this->primaryKey = "family_id";
        $this->builder = $this->db->table($this->tableName);

    }


        
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,users.name');
        //sample_to_replace
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->orderBy($this->tableName . '.user_id','DESC');

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
        $this->builder->select($this->tableName . '.*,users.*');
        //sample_to_replace
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');
        $this->builder->where($where);
        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->orderBy($this->tableName . '.user_id','DESC');

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

    public function user_family_tree($family_id){
        $families = array([$family_id]);
        $result = $this->recursive_users($families);
        return $result;
    }

    public function user_family($family_id){
        $families = array([$family_id]);
        $result = $this->recursive_users($families);
        return count($result) - 1;

        // $this->debug($result);
    }

    
    public function recursive_users($families){
        $key = array_key_last($families);
        $next = array();
        $stop = true;
        foreach($families[$key] as $row){
            $family = $this->db->query("SELECT * FROM family WHERE link_family_id = $row")->getResultArray();
            foreach($family as $fmy){
                $family_id = $fmy['family_id'];
                array_push($next, $family_id);
                $more = $this->db->query("SELECT * FROM family WHERE link_family_id = $family_id")->getResultArray();
                if(!empty($more)){
                    $stop = false;
                }
            }
        }
        if(!empty($next)){
            array_push($families, $next);
        }

        // check if level 15 full
        if(isset($families[15]) && count($families[15]) == 30){
            return $families;
        }
        if(!$stop){
            return $this->recursive_users($families);
        }

        return $families;
    }


    public function insert_new_member($new_member, $family_id){

        $new_family_id = 0;
        $existed = $this->db->query("SELECT * FROM family WHERE user_id = $new_member")->getResultArray();
        if(empty($existed)){
            $slot_family_id = $this->find_empty_slot($family_id);
            $new_family_id = $this->insertNew(['link_family_id' => $slot_family_id, 'user_id' => $new_member]);
            // $this->db->insert('family', );

            // $new_family_id = $this->db->insertID();
            $this->insert_commission($new_family_id);
        }
        $this->user_family($family_id);

        return $new_family_id;
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
        // double check if this slot is available
        $slots = $this->db->query("SELECT COUNT(*) as total FROM family WHERE link_family_id = $slot_family_id")->getResultArray();
        if($slots[0]['total'] == 2){            
            $max_key = max(array_keys($result));
            $slot_family_id = $result[$max_key][0]; // set the last row first family_id
        }
        return $slot_family_id;
    }

    public function get_users_info($users_id){
        
        $where = [
            'users.users_id' => $users_id,
        ];
        $this->UsersModel = new UsersModel();

        $users = $this->UsersModel->getWhere($where);
        if(!empty($users)){

            return $users[0];
        }else{
            return "-None-";
        }
    }

    public function get_upline_info($link_family_id){
        $upline_id = $this->db->query("SELECT user_id FROM family WHERE family_id = $link_family_id")->getResultArray()[0]['user_id'];

        $user_info = $this->get_users_info($upline_id);
        return $user_info['type_id'];
    }

    public function insert_commission($family_id){
        $this->WalletModel = new WalletModel();
        $this->UsersModel = new UsersModel();

        $upline = $this->recursive_upline($family_id); // find all upline
        //get level of upline here 

        $commission = 10;

        
        foreach($upline as $row){
            $type_id = $this->get_upline_info($row);
            //check upline role here 
            $full = false;
            $result = $this->recursive_users([[$row]]);
            if(isset($result[11]) && count($result[11]) < 22){ 
                $commission = 30;
            }

            if($type_id == 0){
                //level 15
                if(isset($result[8]) && count($result[8]) < 16){ 
                    $full = true;
                }
            }
            
            
            if($type_id == 1){
                //level 11 full 
                if(isset($result[9]) && count($result[9]) < 18 ){ 
                    // check if level 11 is full
                    $full = true;
                }
            }

            if($type_id == 2){
                //level 11 full 
                if(isset($result[10]) && count($result[10]) < 20 ){ 
                    // check if level 11 is full
                    $full = true;
                }
            }

            if($type_id== 3){
                //level 11 full 
                if(isset($result[11]) && count($result[11]) < 22 ){ 
                    // check if level 11 is full
                    $full = true;
                }
            }

            if($type_id== 4){

                //level 11 full 
                if(isset($result[12]) && count($result[12]) < 24 ){ 
                    
                    // check if level 11 is full
                    $full = true;
                }
            }
            if($full == false){
                $user = $this->db->query("SELECT * FROM family WHERE family_id = $row")->getResultArray()[0];
                $user_id = $user['user_id'];
                $existed = $this->db->query("SELECT * FROM wallet WHERE users_id = $user_id AND family_id = $family_id")->getResultArray();
                if(empty($existed)){
                    $remarks = 'Commision for ' . $this->UsersModel->get_user_name($user_id) . ' With amount of ' . $commission ;
                    $this->WalletModel->wallet_in($user_id,$commission,$remarks,$family_id);
                    // $this->db->insert('family_commission', ['user_id' => $user_id, 'commission' => $commission, 'family_id' => $family_id]);
                }

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


   

    public function getTree($user_id)
    {
        $this->builder->select("*");
        $this->builder->where("link_family_id", $user_id);
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');
        $this->builder->where("family.deleted", 0);

        $users = $this->builder->get()->getResultArray();
        foreach ($users as $key => $row) {
            // $users[$key]['self_sales'] = $this->getSelfSales($row['user_id']);
            // $users[$key]['total_received_point'] = $this->PointModel->get_total_received_point($row['user_id']);
            // $users[$key]['group_sales'] = $this->getGroupTotalSales($row['user_id']);
            // $users[$key]['downline_count'] = $this->recursive_get_downline_count($row['user_id']);
            // //included own sales
            $this->builder->select("*");
            $this->builder->where("link_family_id", $row['user_id']);
            $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');

            $this->builder->where("family.deleted", 0);

            $child = $this->builder->get()->getResultArray();
            foreach ($child as $ckey => $crow) {
                // $child[$ckey]['self_sales'] = $this->getSelfSales($crow['user_id']);
                // $child[$ckey]['total_received_point'] = $this->PointModel->get_total_received_point($crow['user_id']);
                // $child[$ckey]['group_sales'] = $this->getGroupTotalSales($crow['user_id']);
                // $child[$ckey]['downline_count'] = $this->recursive_get_downline_count($crow['user_id']);

                $this->builder->select("*");
                $this->builder->where("link_family_id", $crow['user_id']);
                $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');

                $this->builder->where("family.deleted", 0);

                $gchild = $this->builder->get()->getResultArray();
                foreach ($gchild as $gkey => $grow) {
                    // $gchild[$gkey]['self_sales'] = $this->getSelfSales($grow['user_id']);
                    // $gchild[$gkey]['total_received_point'] = $this->PointModel->get_total_received_point($grow['user_id']);
                    // $gchild[$gkey]['group_sales'] = $this->getGroupTotalSales($grow['user_id']);
                    // $gchild[$gkey]['downline_count'] = $this->recursive_get_downline_count($grow['user_id']);

                    $this->builder->select("*");
                    $this->builder->where("link_family_id", $grow['user_id']);
                    $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');

                    $this->builder->where("family.deleted", 0);
    
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
?>
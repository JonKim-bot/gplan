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
            // dd($slot_family_id);
            $new_family_id = $this->insertNew(['link_family_id' => $slot_family_id, 'user_id' => $new_member]);

            $commission_normal = $this->insert_commission($new_family_id);

            $extra_commission = $this->insert_extra_commission($new_family_id);


            $total_commision = $commission_normal + $extra_commission;

            $where = [
                "family.family_id" => $new_family_id
            ];
            $data = [
                "extra_commission" => $extra_commission,
                "total_commision" => $total_commision,
                "commission_normal" => $commission_normal,

            ];
            $this->updateWhere($where,$data);

        }
        $this->user_family($family_id);

        return $new_family_id;
    }


    public function get_total_downline($family_id){
        $total_count = $this->db->query("SELECT COUNT(*) as total FROM family WHERE link_family_id = $family_id")->getResultArray()[0]['total'];
        if($total_count != NULL){
            return $total_count;
        }else{
            return 0;
        }
    }
    function return_level_max($level){
        if($level == 1){
            return 2;
        }
        if($level == 2){
            return 4;
        }
        if($level == 3){
            return 8;
        }

        if($level == 4){
            return 16;
        }

        if($level == 5){
            return 32;
        }

        if($level == 6){
            return 64;
        }
        if($level == 7){
            return 128;
        }
        if($level == 8){
            return 256;
        }
        if($level == 9){
            return 512;
        }
        if($level == 10){
            return 1028;
        }
        if($level == 11){
            return 2048;
        }
        if($level == 12){
            return 4096;
        }
        if($level == 13){
            return 8192;
        }
        if($level == 14){
            return 16384;
        }
        if($level == 15){
            return 32768;
        }

    }

    public function find_empty_slot($family_id){
        $families = array([$family_id]);
        $result = $this->recursive_users($families);
    // dd($result);
        // echo "<pre>";
        // print_r($result);

        $slot_family_id = $family_id;


        foreach($result as $index => $row){ // result index = level;

            
            // echo "<pre>";
            // print_r("index");
            // print_r($index);
            // print_r("row");
            // print_r($row);
            // print_r("count");
            
            // print_r($result[$index]);
            // print_r("result index");
            // if($index != 0 && count($row) < $index * 2){  // count($result[$index]) < $index * 2 then mean level no full 

            if($index != 0 && count($row) <  count($result[$index - 1]) * 2){  // count($result[$index]) < $index * 2 then mean level no full 
                foreach($result[$index - 1] as $link){
                 
                    $find_slot = $this->db->query("SELECT COUNT(*) as total FROM family WHERE link_family_id = $link HAVING total < 2")->getResultArray();
                    // $find_slot = $this->db->query("SELECT COUNT(*) as total FROM family WHERE link_family_id = $link HAVING total < 2")->getResultArray();

                    if(!empty($find_slot)){


                        // echo "<pre>";
                        // print_r("i link");
                        // print_r($link);


                        // echo "<pre>";
                        // print_r($find_slot);
                        $slot_family_id = $link;
                        break;
                    }
                }
                break;
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
        $upline_id = $this->db->query("SELECT user_id FROM family WHERE family_id = $link_family_id")->getResultArray();

        if(!empty($upline_id)){
            $upline_id = $upline_id[0]['user_id'];
            $user_info = $this->get_users_info($upline_id);
            return $user_info['type_id'];
        }
    }
    public function get_upline_infomation_tree($link_family_id){
        $upline_id = $this->db->query("SELECT user_id FROM family WHERE family_id = $link_family_id")->getResultArray();
        if(!empty($upline_id)){
            $upline_id = $upline_id[0];

            $user_info = $this->get_users_info($upline_id);
            return $user_info;
        }
    }


    public function get_upline_infomation($link_family_id){
        $upline_id = $this->db->query("SELECT user_id FROM family WHERE family_id = $link_family_id")->getResultArray();
        if(!empty($upline_id)){
            $upline_id = $upline_id[0];
            $user_info = $this->get_users_info($upline_id);
            return $user_info;
        }else{
            $user_info = [];
            $user_info['username'] = 'None';
            return $user_info ;
        }
    }

    public function get_total_com($level_user,$level_upline){
        $total_commision = 0;
        if($level_user < $level_upline ){
            for ($x = $level_user + 1; $x <= $level_upline; $x++) {
                if($x >= 11){
                    $commission = 30;
                }else{
                    $commission = 10;
                }
                $total_commision = $commission  + $total_commision;
                echo '<br>Commision for level ' . $x . "  = " . $commission;
            }
            // $total_commision = $level_diffrence * 10;
        }
        echo "<br>The number is: $total_commision <br>";
        return $total_commision;

    }
    public function give_over_commision_to_upline($user_id){
       
        $users = $this->db->query("SELECT reference_id FROM users WHERE users_id = $user_id")->getResultArray()[0];
        if($users['reference_id'] != 0){
            $upline_info = $this->db->query("SELECT * FROM users WHERE users_id = $user_reference_id")->getResultArray()[0];


            $level_user = $users['type_id'] + 8;
            $level_upline = $users['type_id'] + 8;

            $total_commision = 10;

            $remarks = 'Reward for ' . $this->UsersModel->get_user_name($upline_info['users_id']) . ' With amount of ' . $total_commision ;
          
            $this->WalletModel->wallet_in($user_id,$commission,$remarks,$family_id);
            
        }
        
        

    }

    public function insert_extra_commission($family_id){
        $this->WalletModel = new WalletModel();
        $this->UsersModel = new UsersModel();

        $upline = $this->recursive_upline($family_id); // find all upline
        $total_commision_given = 0;
        //get level of upline here 
        foreach($upline as $row){
            $type_id = $this->get_upline_info($row);

            //check upline role here 
            $full = false;
            $result = $this->recursive_users([[$row]]);
  
            $user_id = $this->get_user_id_from_family_id($row);

            // dd($user_id);
            
            $user_info = $this->get_users_info($user_id);


      
            $direct = $this->get_recursive_upline_referal([$user_info]);


            // $direct_id = $user_info['reference_id'];
            // $direct = $this->db->query("SELECT * FROM users WHERE users_id = $direct_id")->getResultArray();
            
            if(!empty($direct)){
                // $direct = $direct[0];
                // $direct_level = $direct['type_id'] + 8;

                        
                $level_for_user = 1;
                foreach($result as $key_level => $row_result){
                    if(in_array($family_id,$row_result)){
                        $level_for_user = $key_level;
                    }
                }
                


                // if($row == 3){


                    
                // if($row == 26){
                //     print_r("level_for_user");

                //     print_r($level_for_user);
                //     print_r("level id");

                //     print_r(($type_id + 8));

                //     echo "<pre>";
                //     print_r($result);

                // }

                
                // if($user_id == 18){
                    // print_r("level_for_user");

                    // print_r($level_for_user);
                    // print_r("level id");


                    // print_r(($type_id + 8));

                    // echo "<pre>";
                    // print_r($result);
        
                    // dd($direct);
                    if($level_for_user > $type_id + 8){
                        $extra_commission = $level_for_user >= 11 ? 30 : 10;
                        foreach($direct as $row){
                            if($row['users_id'] != $user_id){

                                $direct_level = $row['type_id'] + 8;
                                // echo "<pre>";
                                // print_r("direct");
    
                                // print_r($row);
    
    
                                // print_r("direct_level");
    
                                // print_r($direct_level);
    
                                // print_r("level_for_user");
    
                                // print_r($level_for_user);
                                if($direct_level >= $level_for_user){
    
                                    $total_commision_given = $total_commision_given + $extra_commission;

                                    //can get 
                                    $remarks = 'Extra Commision From Direct Sponsor '.$user_info['username'].' - Reward for ' . $row['username'] . ' With amount of extra ' . $extra_commission ;
                                    // dd($remarks);
                                    $this->WalletModel->wallet_in($row['users_id'],$extra_commission,$remarks,$family_id,0,0,$user_id);
                                    break;
                                }
                            }
                        }
                        
    
                    }
                //   
                // }    

                


                
                // }
                

                // if($type_id == 0){
                //     //level 8
                //     //find upline level 8
                //     if(isset($result[9])){
                //         if(isset($result[$direct_level]) && count($result[$direct_level]) < ($direct_level * 2)){
                            

                //         }
                //     }
                // }
                
                
                // if($type_id == 1){
                //     //level 9
                //     if(isset($result[10])){
                //         if(isset($result[$direct_level ]) && count($result[$direct_level ]) < ($direct_level * 2)){
                           
                //             $extra_commission = isset($result[11]) ? 30 : 10;
                //             $remarks = 'Reward for ' . $direct['username'] . ' With amount of extra ' . $extra_commission ;
                //             $this->WalletModel->wallet_in($direct['users_id'],$extra_commission,$remarks,$family_id,0,0,$row);
       
                //         }
                //     }
                // }
    
                // if($type_id == 2){
                //     //level 10 full 
                //     if(isset($result[11])){
                //         if(isset($result[$direct_level ]) && count($result[$direct_level ]) < ($direct_level * 2)){
                                
                //             $extra_commission = isset($result[11]) ? 30 : 10;
                //             $remarks = 'Reward for ' . $direct['username'] . ' With amount of extra ' . $extra_commission ;
                //             $this->WalletModel->wallet_in($direct['users_id'],$extra_commission,$remarks,$family_id,0,0,$row);
                //         }
                //     }
                // }
    
                // if($type_id== 3){
                //     //level 11 full 
                //     if(isset($result[12])){
                //         if(isset($result[$direct_level ]) && count($result[$direct_level ]) < ($direct_level * 2)){
                                
                //             $extra_commission = isset($result[11]) ? 30 : 10;
                //             $remarks = 'Reward for ' . $direct['username'] . ' With amount of extra ' . $extra_commission ;
                //             $this->WalletModel->wallet_in($direct['users_id'],$extra_commission,$remarks,$family_id,0,0,$row);

                //         }
                //     }
                // }
    
                // if($type_id== 4){
    
                //     //level 12 full 
                //     if(isset($result[13])){
                //         if(isset($result[$direct_level ]) && count($result[$direct_level ]) < ($direct_level * 2)){
                                 
                //             $extra_commission = isset($result[11]) ? 30 : 10;
                //             $remarks = 'Reward for ' . $direct['username'] . ' With amount of extra ' . $extra_commission ;
                //             $this->WalletModel->wallet_in($direct['users_id'],$extra_commission,$remarks,$family_id,0,0,$row);

                //         }
                //     }
                // }
                // if($type_id== 5){
    
                //     //level 13 full 

                //     if(isset($result[14])){
                //         if(isset($result[$direct_level ]) && count($result[$direct_level ]) < ($direct_level * 2)){
                                   
                //             $extra_commission = isset($result[11]) ? 30 : 10;
                //             $remarks = 'Reward for ' . $direct['username'] . ' With amount of extra ' . $extra_commission ;
                //             $this->WalletModel->wallet_in($direct['users_id'],$extra_commission,$remarks,$family_id,0,0,$row);

                //         }
                //     }
                // }
                // if($type_id== 6){
    
                //     if(isset($result[15])){
                //         if(isset($result[$direct_level ]) && count($result[$direct_level ]) < ($direct_level * 2)){
                                   
                //             $extra_commission = isset($result[11]) ? 30 : 10;
                //             $remarks = 'Reward for ' . $direct['username'] . ' With amount of extra ' . $extra_commission ;
                //             $this->WalletModel->wallet_in($direct['users_id'],$extra_commission,$remarks,$family_id,0,0,$row);

                //         }
                //     }
                // }
            }
            // if($type_id== 7){

            //     //level 15 full 
            //     if(isset($result[15]) && count($result[15]) < 30 ){ 
                    
            //         $full = true;
            //     }
            // }
            // if($full == false){
            //     $user = $this->db->query("SELECT * FROM family WHERE family_id = $row")->getResultArray()[0];
            //     $user_id = $user['user_id'];
            //     $existed = $this->db->query("SELECT * FROM wallet WHERE users_id = $user_id AND family_id = $family_id")->getResultArray();
            //     if(empty($existed)){
            //         $remarks = 'Commision for ' . $this->UsersModel->get_user_name($user_id) . ' With amount of ' . $commission ;
            //         $this->WalletModel->wallet_in($user_id,$commission,$remarks,$family_id);
            //         // $this->db->insert('family_commission', ['user_id' => $user_id, 'commission' => $commission, 'family_id' => $family_id]);
            //     }

            // }

        }
        return $total_commision_given;
    }

    public function get_user_id_from_family_id($family_id){
        $user = $this->db->query("SELECT user_id FROM family WHERE family_id = $family_id")->getResultArray()[0];
        return $user['user_id'];
    }

    
    public function insert_commission($family_id){
        $this->WalletModel = new WalletModel();
        $this->UsersModel = new UsersModel();


        $upline = $this->recursive_upline($family_id); // find all upline
        //get level of upline here 
        // dd($upline);
        $commission = 10;
        $total_commision_given = 0;

        $com_greater_than_10 = 0;
        $com_under_10 = 0;
        
        foreach($upline as $row){
            $type_id = $this->get_upline_info($row);
            //check upline role here 
            $full = false;
            $result = $this->recursive_users([[$row]]);
            
            $level_for_user = 1;
            // if($row == 2096){
            foreach($result as $key_level => $row_result){
                // dd($result);
                if(in_array($family_id,$row_result)){
                    $level_for_user = $key_level;
                }
            }
            // }

        

            if($level_for_user > 10){ 
                $commission = 30;
            }

            // if(isset($result[11]) && count($result[11]) == $this->return_level_max(11)){ 
            //     $commission = 30;
            // }


            // if($row == 3){

           



            if($level_for_user > $type_id + 8){ 
                $full = true;
            }

            
            // if($row == 26){
            //     print_r("level_for_user");

            //     print_r($level_for_user);
            //     print_r("level id");

            //     print_r(($type_id + 8));

            //     echo "<pre>";
            //     print_r($result);
            //     dd($full);

            // }


        
                // dd($commission);
                // dd($full);
            // }

            // if($type_id == 0){
            //     //level 8
            //     if($level_for_user > 8){ 
            //         $full = true;
            //     }

            //     // if($row == 3){
            //     //     dd($result);
            //     //     dd($level_for_user);
            //     //     // print_r($level_for_user);
            //     //     // dd(( $this->return_level_max(8)));
            //     // }

                
            // }
            
            
            // if($type_id == 1){
            //     //level 9
            //     if(isset($result[9]) && count($result[9]) == $this->return_level_max(9) ){ 
            //         $full = true;
            //     }
            // }

            // if($type_id == 2){
            //     //level 10 full 
            //     if(isset($result[10]) && count($result[10]) == $this->return_level_max(10) ){ 
            //         $full = true;
            //     }
            // }

            // if($type_id== 3){
            //     //level 11 full 
            //     if(isset($result[11]) && count($result[11]) == $this->return_level_max(11) ){ 
            //         $full = true;
            //     }
            // }

            // if($type_id== 4){

            //     //level 12 full 
            //     if(isset($result[12]) && count($result[12]) ==  $this->return_level_max(12) ){ 
                    
            //         $full = true;
            //     }
            // }
            // if($type_id== 5){

            //     //level 13 full 
            //     if(isset($result[13]) && count($result[13]) == $this->return_level_max(13) ){ 
                    
            //         $full = true;
            //     }
            // }
            // if($type_id== 6){

            //     //level 14 full 
            //     if(isset($result[14]) && count($result[14]) == $this->return_level_max(14) ){ 
                    
            //         $full = true;
            //     }
            // }
            // if($type_id== 7){

            //     //level 15 full 
            //     if(isset($result[15]) && count($result[15]) < $this->return_level_max(15) ){ 
                    
            //         $full = true;
            //     }
            // }

        
            // if($full == false){

            //     if($level_for_user <= 10){
            //         $com_under_10 = (float)$commission +  (float)$com_under_10;
            //         // dd($com_under_10);
            //         echo "<pre>com";
            //         print_r($com_under_10);
            //         echo "<pre>level for user";
            //         print_r($level_for_user);

            //         echo "<pre>upline family id ";
            //         print_r($row);
            //     }
            //     if($level_for_user > 10){
            //         $com_greater_than_10 =  (float)$commission +  (float)$com_greater_than_10;
            //         echo "<pre>com_greater_than_10";
            //         print_r($com_greater_than_10);
            //         echo "<pre>level for user";
            //         print_r($level_for_user);
            //     }

        
            //     // dd($result);
            // }
            
            if($full == false){
                $user = $this->db->query("SELECT * FROM family WHERE family_id = $row")->getResultArray()[0];

                $user_id = $user['user_id'];
                $existed = $this->db->query("SELECT * FROM wallet WHERE users_id = $user_id AND family_id = $family_id")->getResultArray();

                // if(empty($existed)){
                    $total_commision_given = $total_commision_given + $commission;
                    $remarks = 'Reward for ' . $this->UsersModel->get_user_name($user_id) . ' With amount of ' . $commission ;
                    $this->WalletModel->wallet_in($user_id,$commission,$remarks,$family_id);
                // }

            }
        }
        // dd($upline);


        // print_r($com_greater_than_10);

        return $total_commision_given;
    }

    
    public function get_recursive_upline_referal($upline, $child = [],$level = 0 ,$level_to_reach = 0 )
    {
        $this->UsersModel = new UsersModel();

        // $this->debug($upline);
        $got_child = false;

        $parent = $child;

        if (empty($parent)) {
            $parent = $upline;
            

        }

        $child = [];

    
        foreach ($parent as $row) {

            $where = [
                'users.users_id' => $row['reference_id'],
            ];
            $customers = $this->UsersModel->getWhere($where);

            if (!empty($customers)) {
                $got_child = true;
                foreach ($customers as $customer) {
                    // $customer['level'] = $level;
                    array_push($upline, $customer);
                    array_push($child, $customer);

                }
            }
        }
        // $this->debug($upline);
        if ($got_child) {
        
            return $this->get_recursive_upline_referal($upline, $child,$level+1);
            // }
        } else {
            return $upline;
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


   
    public function user_family_id($user_id){
        $where = [
            'family.user_id' => $user_id,
        ];

        $family_users_id = $this->getWhereRaw($where);
        if(!empty($family_users_id)){
            $family_users_id = $family_users_id[0]['family_id'];
        }
        return $family_users_id;
    }

    public function getTree($user_id)
    {
        $this->WalletModel = new WalletModel();

        // $this->builder->select("family.*,users.username");
        // $this->builder->join('users', 'users.users_id = '.$this->tableName.'.user_id');
        // $this->builder->where("family.link_family_id", $this->user_family_id($user_id));
        // $this->builder->where("family.deleted", 0);
        // die($this->builder->getCompiledSelect(false));

        // $users = $this->builder->get()->getResultArray();
        $sql = "SELECT family.*,users.username,users.users_id,users.type_id FROM family 
        INNER JOIN users
        ON users.users_id = family.user_id
        WHERE family.link_family_id = ".$this->user_family_id($user_id)."
        AND family.deleted = 0";
        $users = $this->db->query($sql)->getResultArray();
        foreach ($users as $key => $row) {
            // $users[$key]['self_sales'] = $this->getSelfSales($row['user_id']);
            // $users[$key]['total_received_point'] = $this->PointModel->get_total_received_point($row['user_id']);
            // $users[$key]['group_sales'] = $this->getGroupTotalSales($row['user_id']);
            $users[$key]['balance'] = $this->WalletModel->get_balance($row['user_id']);
            // $users[$key]['balance'] = $this->WalletModel->get_balance($row['user_id']);
            // //included own sales
            $users[$key]['total_downline'] = $this->get_total_downline($this->user_family_id($row['user_id']));

            $sql = "SELECT family.*,users.username,users.users_id,users.type_id FROM family 
            INNER JOIN users
            ON users.users_id = family.user_id
            WHERE family.link_family_id = ".$this->user_family_id($row['users_id'])."
            AND family.deleted = 0";
            $child = $this->db->query($sql)->getResultArray();

            foreach ($child as $ckey => $crow) {
                // $child[$ckey]['self_sales'] = $this->getSelfSales($crow['user_id']);

                // $child[$ckey]['total_received_point'] = $this->PointModel->get_total_received_point($crow['user_id']);
                // $child[$ckey]['group_sales'] = $this->getGroupTotalSales($crow['user_id']);
                $child[$ckey]['balance'] = $this->WalletModel->get_balance($crow['user_id']);
                $child[$ckey]['total_downline'] = $this->get_total_downline($this->user_family_id($crow['user_id']));

                $sql = "SELECT family.*,users.username,users.users_id,users.type_id FROM family 
                INNER JOIN users
                ON users.users_id = family.user_id
                WHERE family.link_family_id = ".$this->user_family_id($crow['users_id'])."
                AND family.deleted = 0";
                $gchild = $this->db->query($sql)->getResultArray();

                foreach ($gchild as $gkey => $grow) {

                    // $child[$ckey]['total_downline'] = $this->FamilyModel->get_total_downline($crow['self_family_id']);
                    $gchild[$gkey]['total_downline'] = $this->get_total_downline($this->user_family_id($grow['user_id']));

                    $gchild[$gkey]['balance'] = $this->WalletModel->get_balance($grow['user_id']);
                    // $gchild[$gkey]['total_received_point'] = $this->PointModel->get_total_received_point($grow['user_id']);
                    // $gchild[$gkey]['group_sales'] = $this->getGroupTotalSales($grow['user_id']);
                    // $gchild[$gkey]['downline_count'] = $this->recursive_get_downline_count($grow['user_id']);
                    $sql = "SELECT family.*,users.username,users.users_id,users.type_id FROM family 
                    INNER JOIN users
                    ON users.users_id = family.user_id
                    WHERE family.link_family_id = ".$this->user_family_id($grow['users_id'])."
                    AND family.deleted = 0";
                    $ggchild = $this->db->query($sql)->getResultArray();
                    
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
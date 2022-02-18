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
        if(isset($families[15]) && count($families[15]) == 30){
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

            $new_family_id = $this->insertNew(['link_family_id' => $slot_family_id, 'user_id' => $new_member]);
            // $this->db->insert('family', );
            // $new_family_id = $this->db->insertID();
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
        $this->WalletModel = new WalletModel();

        $upline = $this->recursive_upline($family_id); // find all upline
        $commission = 10;
        foreach($upline as $row){
            $result = $this->recursive_users([[$row]]);
            if(isset($result[11]) && count($result[11]) < 22){ // check if level 11 is full
                $commission = 30;
            }
            $user = $this->db->query("SELECT * FROM family WHERE family_id = $row")->getResultArray()[0];
            $user_id = $user['user_id'];
            $existed = $this->db->query("SELECT * FROM wallet WHERE users_id = $user_id AND family_id = $family_id")->getResultArray();
            if(empty($existed)){
                $remarks = 'Commision for ' . $user_id . ' With amount of ' . $commission;
                $this->WalletModel->wallet_in($user_id,$commission,$remarks,$family_id);
                // $this->db->insert('family_commission', ['user_id' => $user_id, 'commission' => $commission, 'family_id' => $family_id]);
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
?>
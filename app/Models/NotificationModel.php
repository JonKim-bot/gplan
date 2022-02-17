<?php namespace App\Models;


use App\Core\BaseModel;

class NotificationModel extends BaseModel{

	function __construct(){

		parent::__construct();
		$this->tableName = "notification";
		$this->primaryKey = "notification_id";
	}

    public function getUnreadNotificationUser($user_id){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select('COUNT(*) AS total');
        $this->builder->where($this->tableName . '.is_read',0);
        $this->builder->where($this->tableName . '.users_id',$user_id);

        $this->builder->where($this->tableName . '.deleted',0);

    
        $query = $this->builder->get();
        return $query->getResultArray()[0]['total'];   
    }
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,notification_type.name as notification_type,users.contact');
        $this->builder->join('notification_type', 'notification_type.notification_type_id = '.$this->tableName.'.notification_type_id', 'left');
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');

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
    function getWhere($where,$limit = "", $page = 1, $filter = array()){

        $base_url = base_url();
        
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,notification_type.name as notification_type,users.contact');
        $this->builder->select("(SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.deleted = 0 AND car_image.is_thumbnail = 1
        AND car_image.car_id IN (SELECT car_id FROM auction WHERE auction.auction_id = notification.auction_id)
        LIMIT 1) as image");
        $this->builder->join('notification_type', 'notification_type.notification_type_id = '.$this->tableName.'.notification_type_id', 'left');
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

    function getWhereWithTypes($users_id){

        $sql = "SELECT notification_type.*, 
                (SELECT COUNT(*) FROM notification WHERE notification.users_id = $users_id AND notification.notification_type_id = notification_type.notification_type_id 
                AND is_read = 0) AS badge 
                FROM notification_type WHERE notification_type.deleted = 0";
                
        $types = $this->db->query($sql)->getResultArray();

        foreach($types as $key => $row){

            $notification_type_id = $row['notification_type_id'];
            $base_url = base_url();
            $sql = "SELECT notification.*,
                    (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.deleted = 0 AND car_image.is_thumbnail = 1
                    AND car_image.car_id IN (SELECT car_id FROM auction WHERE auction.auction_id = notification.auction_id)
                    LIMIT 1) as image 
                    FROM notification 
                    WHERE notification.users_id = $users_id AND notification.deleted = 0 
                    AND notification.notification_type_id = $notification_type_id 
                    ORDER BY notification.notification_id DESC";
            $noti = $this->db->query($sql)->getResultArray();

            $types[$key]['notifications'] = $noti;
        }

        return $types;
    }

	}
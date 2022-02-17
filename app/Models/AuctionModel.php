<?php namespace App\Models;




use App\Core\BaseModel;

class AuctionModel extends BaseModel{


	function __construct(){

		parent::__construct();
		$this->tableName = "auction";
		$this->primaryKey = "auction_id";
        $this->single_log('auction');
        

	}
function getAll($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*,car.car_id,car.lisence_plate_no as plate_no,model.name as model,auction_status.name as auction_status,

    brand.name as brand,model.name as model,
    ,users.name as username,

    (SELECT current_selling_price FROM bid WHERE bid.auction_id = auction.auction_id ORDER BY bid.bid_id DESC LIMIT 1) as success_bid_price,
    car.users_id as seller_id,
    (
        CASE
            WHEN seller_status_id = 1 THEN "Accept"
            WHEN seller_status_id = 2 THEN "Rejected"
            ELSE "Pending"
        END
    ) as seller_status

    ');
    $this->builder->join('car', 'car.car_id = '.$this->tableName.'.car_id', 'left');
    $this->builder->join('model', 'car.model_id = model.model_id', 'left');
    

    $this->builder->join('brand', 'model.brand_id = brand.brand_id', 'left');

    $this->builder->join('auction_status', 'auction_status.auction_status_id = '.$this->tableName.'.auction_status_id', 'left');
    // $this->builder->join('auction_section', 'auction_section.auction_section_id = '.$this->tableName.'.auction_section_id', 'left');
    $this->builder->join('users', 'users.users_id = car.users_id', 'left');

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
function getCountUndone($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select('COUNT(*) AS total');
    $this->builder->where($this->tableName . '.deleted',0);
    $this->builder->where($this->tableName . '.status',0);
    $this->builder->where($this->tableName . '.auction_status_id',3);

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

function getEnded($limit = "", $page = 1, $filter = array()){
    $this->builder = $this->db->table($this->tableName);
    $this->builder->select($this->tableName . '.*,car.car_id,car.plate_no,model.name as model,auction_status.name as auction_status,
    auction_section.name as auction_section,auction_section.date,auction_section.start_time,auction_section.end_time,users.name as username
    ');
    $this->builder->join('car', 'car.car_id = '.$this->tableName.'.car_id', 'left');
    $this->builder->join('model', 'car.model_id = model.model_id', 'left');
    $this->builder->join('auction_status', 'auction_status.auction_status_id = '.$this->tableName.'.auction_status_id', 'left');
    $this->builder->join('auction_section', 'auction_section.auction_section_id = '.$this->tableName.'.auction_section_id', 'left');
    $this->builder->join('users', 'users.users_id = car.users_id', 'left');

    $this->builder->orderBy($this->tableName . '.created_date','DESC');
    $this->builder->where($this->tableName . '.status',0);
    $this->builder->where($this->tableName . '.auction_status_id',3);


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
    $this->builder->select($this->tableName . '.*,brand.name as brand,car.car_id,car.plate_no,model.name as model,auction_status.name as auction_status,car.lisence_plate_no,
    users.name as username,
    car.users_id as seller_id,(SELECT name FROM users WHERE users_id = auction.success_user_id) as success_user,variant.variant,

    (SELECT current_selling_price FROM bid WHERE bid.auction_id = auction.auction_id ORDER BY bid.bid_id DESC LIMIT 1) as success_bid_price,
    (SELECT name FROM users WHERE users_id = auction.success_user_id) as success_user,
    (SELECT contact FROM users WHERE users_id = auction.success_user_id) as success_contact,
    (
        CASE
            WHEN seller_status_id = 1 THEN "Accept"
            WHEN seller_status_id = 2 THEN "Rejected"
            WHEN seller_status_id = 3 THEN "Rebid"
            WHEN seller_status_id = 4 THEN "Withdraw"
            ELSE "Pending"
        END
    ) as seller_status

    
    ');

    // ,auction_section.date,auction_section.start_time,auction_section.end_time
    $this->builder->join('car', 'car.car_id = '.$this->tableName.'.car_id', 'left');

    $this->builder->join('model', 'car.model_id = model.model_id', 'left');
    $this->builder->join('brand', 'brand.brand_id = model.brand_id', 'left');


    $this->builder->join('variant', 'car.variant_id = variant.variant_id', 'left');

    $this->builder->join('auction_status', 'auction_status.auction_status_id = '.$this->tableName.'.auction_status_id', 'left');
    // $this->builder->join('auction_section', 'auction_section.auction_section_id = '.$this->tableName.'.auction_section_id', 'left');
    $this->builder->join('users', 'users.users_id = car.users_id', 'left');

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

    public function getWhereFilter($where, $filter_id, $users_id){

        // filter_id 1 = lastest upated
        // filter_id 2 = Price: Low to high
        // filter_id 3 = Price: High to low
        // filter_id 4 = Year: New to old
        // filter_id 5 = Year Old to New
        // filter_id 6 = Mileage: Low to high
        // filter_id 7 = Mileage: High to low

        $filter = 'auction.created_date DESC';
        if($filter_id == 2){
            $filter = 'auction.starting_price ASC';

        } else if($filter_id == 3){
            $filter = 'auction.starting_price DESC';
        } else if($filter_id == 4){
            $filter = 'car.manufactured_year DESC';
        } else if($filter_id == 5){
            $filter = 'car.manufactured_year ASC';
        } else if($filter_id == 6){
            $filter = 'car.mileage ASC';
        } else if($filter_id == 7){
            $filter = 'car.mileage DESC';
        }

        $base_url = base_url();
        $sql = "SELECT auction.*, car.manufactured_year, YEAR(car.manufactured_year) as year, car.mileage, car.engine_capacity, model.name as model, brand.name as brand, auction_section.date, auction_section.start_time, auction_section.end_time,
                variant.variant,

                CONCAT('$base_url', car.sticker) as sticker, NOW(), car.plate_no, transmission.name as transmission,
                state.short_form as state_tag,

                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image,
                IF((SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id AND bid.users_id = $users_id) > 0, 1, 0) as is_bidding,
                IF((SELECT COUNT(*) FROM auction_wishlist WHERE auction_wishlist.auction_id = auction.auction_id AND auction_wishlist.users_id = $users_id) > 0, 1, 0) as is_wishlist,
                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,
                IF((SELECT COUNT(*) FROM auction_section WHERE auction_section.auction_section_id = auction.auction_section_id 
                AND DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= NOW() AND auction_section.end_time >= NOW()) > 0, 1, 0) as is_live

                FROM auction 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN transmission ON transmission.transmission_id = car.transmission_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN area ON area.area_id = car.area_id
                LEFT JOIN state ON state.state_id = area.state_id
                WHERE $where AND car.deleted = 0 AND auction.auction_status_id < 2 ORDER BY $filter";
        // die(var_dump($sql));
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getWhereFilterNew($where, $filter_id, $users_id){

        // filter_id 1 = lastest upated
        // filter_id 2 = Price: Low to high
        // filter_id 3 = Price: High to low
        // filter_id 4 = Year: New to old
        // filter_id 5 = Year Old to New
        // filter_id 6 = Mileage: Low to high
        // filter_id 7 = Mileage: High to low

        $filter = 'auction.created_date DESC';


        if($filter_id == 2){
            $filter = 'auction.starting_price ASC';
        } else if($filter_id == 3){
            $filter = 'auction.starting_price DESC';
        } else if($filter_id == 4){
            $filter = 'car.manufactured_year DESC';
        } else if($filter_id == 5){
            $filter = 'car.manufactured_year ASC';
        } else if($filter_id == 6){
            $filter = 'car.mileage ASC';
        } else if($filter_id == 7){
            $filter = 'car.mileage DESC';
        }

        $base_url = base_url();
        $sql = "SELECT auction.*, car.manufactured_year, YEAR(car.manufactured_year) as year, car.mileage, car.engine_capacity, model.name as model, brand.name as brand, auction_section.date, auction_section.start_time, auction_section.end_time,
                variant.variant,
                CONCAT('$base_url', car.sticker) as sticker, NOW(), car.plate_no, transmission.name as transmission,
                state.short_form as state_tag,
                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,

                (SELECT COUNT(*) FROM car_image WHERE car_image.car_id = auction.car_id) AS total_image,
                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image,
                IF((SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id AND bid.users_id = $users_id) > 0, 1, 0) as is_bidding,
                IF((SELECT COUNT(*) FROM auction_wishlist WHERE auction_wishlist.auction_id = auction.auction_id AND auction_wishlist.users_id = $users_id) > 0, 1, 0) as is_wishlist,
                IF((SELECT COUNT(*) FROM auction_section WHERE auction_section.auction_section_id = auction.auction_section_id 
                AND DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= NOW() AND auction_section.end_time >= NOW()) > 0, 1, 0) as is_live
                FROM auction 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN transmission ON transmission.transmission_id = car.transmission_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN area ON area.area_id = car.area_id
                LEFT JOIN state ON state.state_id = area.state_id
                WHERE $where AND car.deleted = 0 ORDER BY $filter";

// --                WHERE $where AND car.deleted = 0 AND auction.auction_status_id < 3 ORDER BY $filter";
        // die(var_dump($sql));
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getWhereFilterLive($where, $filter_id, $users_id){

        $filter = 'auction.created_date DESC';
        if($filter_id == 2){
            $filter = 'auction.starting_price ASC';
        } else if($filter_id == 3){
            $filter = 'auction.starting_price DESC';
        } else if($filter_id == 4){
            $filter = 'car.manufactured_year DESC';
        } else if($filter_id == 5){
            $filter = 'car.manufactured_year ASC';
        } else if($filter_id == 6){
            $filter = 'car.mileage ASC';
        } else if($filter_id == 7){
            $filter = 'car.mileage DESC';
        }

        $base_url = base_url();
        $sql = "SELECT auction.*, car.manufactured_year, YEAR(car.manufactured_year) as year, car.mileage, car.engine_capacity, model.name as model, brand.name as brand, auction_section.date, auction_section.start_time, auction_section.end_time,
                variant.variant,

                CONCAT('$base_url', car.sticker) as sticker, NOW(), car.plate_no, transmission.name as transmission,
                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                IF((SELECT current_selling_price FROM bid WHERE bid.auction_id = auction.auction_id ORDER BY bid.bid_id DESC LIMIT 1) IS NULL, 0, (SELECT current_selling_price FROM bid WHERE bid.auction_id = auction.auction_id ORDER BY bid.bid_id DESC LIMIT 1)) as current_bidding_price,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image,
                IF((SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id AND bid.users_id = $users_id) > 0, 1, 0) as is_bidding,
                IF((SELECT COUNT(*) FROM auction_wishlist WHERE auction_wishlist.auction_id = auction.auction_id AND auction_wishlist.users_id = $users_id) > 0, 1, 0) as is_wishlist,
                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,

                IF((SELECT COUNT(*) FROM auction_section WHERE auction_section.auction_section_id = auction.auction_section_id 
                AND DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= NOW() AND auction_section.end_time >= NOW()) > 0, 1, 0) as is_live

                FROM auction 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN transmission ON transmission.transmission_id = car.transmission_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN area ON area.area_id = car.area_id
                LEFT JOIN state ON state.state_id = area.state_id
                WHERE $where AND car.deleted = 0 AND auction.auction_status_id < 3 ORDER BY $filter";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getBiddingList($where, $filter_id, $users_id){

        $filter = 'auction.created_date DESC';
        if($filter_id == 2){
            $filter = 'auction.starting_price ASC';
        } else if($filter_id == 3){
            $filter = 'auction.starting_price DESC';
        } else if($filter_id == 4){
            $filter = 'car.manufactured_year DESC';
        } else if($filter_id == 5){
            $filter = 'car.manufactured_year ASC';
        } else if($filter_id == 6){
            $filter = 'car.mileage ASC';
        } else if($filter_id == 7){
            $filter = 'car.mileage DESC';
        }

        $base_url = base_url();
        $sql = "SELECT auction.*, car.manufactured_year, YEAR(car.manufactured_year) as year, car.mileage, car.engine_capacity, model.name as model, brand.name as brand, auction_section.date, auction_section.start_time, auction_section.end_time,
                variant.variant,
                CONCAT('$base_url', car.sticker) as sticker, NOW(), car.plate_no, transmission.name as transmission,
                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image,
                IF((SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id AND bid.users_id = $users_id) > 0, 1, 0) as is_bidding,
                IF((SELECT COUNT(*) FROM auction_wishlist WHERE auction_wishlist.auction_id = auction.auction_id AND auction_wishlist.users_id = $users_id) > 0, 1, 0) as is_wishlist,
                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,
                IF((SELECT COUNT(*) FROM auction_section WHERE auction_section.auction_section_id = auction.auction_section_id 
                AND DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= NOW() AND auction_section.end_time >= NOW()) > 0, 1, 0) as is_live
                FROM auction 

                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN transmission ON transmission.transmission_id = car.transmission_id
                LEFT JOIN area ON area.area_id = car.area_id
                LEFT JOIN state ON state.state_id = area.state_id
                WHERE auction.deleted = 0 AND DATE(auction_section.date) = DATE(NOW()) AND car.deleted = 0
                AND auction_section.start_time <= NOW() AND auction_section.end_time >= NOW() AND auction.auction_status_id < 3
                HAVING is_bidding > 0
                ORDER BY $filter";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    public function getWishList($users_id){

        $base_url = base_url();
                $sql = "SELECT auction.*, car.manufactured_year, YEAR(car.manufactured_year) as year, car.mileage, car.engine_capacity, model.name as model, brand.name as brand, auction_section.date, auction_section.start_time, auction_section.end_time,
                variant.variant,

                CONCAT('$base_url', car.sticker) as sticker, NOW(), car.plate_no, transmission.name as transmission,
                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image,

                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,
                IF((SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id AND bid.users_id = $users_id) > 0, 1, 0) as is_bidding,
                IF((SELECT COUNT(*) FROM auction_wishlist WHERE auction_wishlist.auction_id = auction.auction_id AND auction_wishlist.users_id = $users_id) > 0, 1, 0) as is_wishlist,
                IF((SELECT COUNT(*) FROM auction_section WHERE auction_section.auction_section_id = auction.auction_section_id 
                AND DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= NOW() AND auction_section.end_time >= NOW()) > 0, 1, 0) as is_live

                FROM auction 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN transmission ON transmission.transmission_id = car.transmission_id
                LEFT JOIN area ON area.area_id = car.area_id
                LEFT JOIN state ON state.state_id = area.state_id
                WHERE auction.deleted = 0 AND car.deleted = 0 AND auction.auction_status_id < 3
                HAVING is_wishlist > 0";

        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

    function getMinimumIncrement($auction_id){

        $price = 0;
        $sql = "SELECT MIN(increment_price) AS price FROM auction_increment WHERE auction_id = $auction_id";
        $query = $this->db->query($sql)->getResultArray();

        if(!empty($query)){
            $price = $query[0]['price'];
        }


        return $price;
    }

    function getPopularAuction(){

        $base_url = base_url();

        $sql = "SELECT auction.*, CONCAT('$base_url', car.sticker) as sticker, car.manufactured_year, car.mileage, car.engine_capacity, auction.starting_price, auction.starting_price as final_price, YEAR(car.manufactured_year) as year,
        variant.variant,
                auction.deposit_amount, model.name as model, brand.name as brand, state.state, car.plate_no,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image 
                FROM auction 
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
            LEFT JOIN car ON car.car_id = auction.car_id


                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN state ON state.state_id = car.state_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                WHERE auction.deleted = 0 AND auction.is_popular = 1 AND ((DATE(auction_section.date) = DATE(NOW()) AND auction_section.end_time >= NOW()) OR DATE(auction_section.date) > DATE(NOW())) AND car.deleted = 0";
        $result = $this->db->query($sql)->getResultArray();
        // die(var_dump($this->db->getCompiledSelect()));
        return $result;
    }

    function getAuctionRaw($auction_status_id, $users_id){

        $base_url = base_url();
        $sql = "SELECT car.*, CONCAT('$base_url', car.sticker) as sticker, car.manufactured_year, car.mileage, car.engine_capacity, auction.starting_price, auction.expected_price as target_price,
                variant.variant,
                auction.deposit_amount, model.name as model, brand.name as brand, state.state, car.plate_no, YEAR(car.manufactured_year) as year, auction.auction_id,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder, auction_section.date, auction_section.start_time, auction_section.end_time,
                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                (SELECT COUNT(*) FROM auction a2 WHERE a2.car_id = auction.car_id) - 1 AS rebid,
                (
                    CASE
                        WHEN seller_status_id = 1 THEN 'Accept'
                        WHEN seller_status_id = 2 THEN 'Rejected'
                        WHEN seller_status_id = 3 THEN 'Rebid'
                        WHEN seller_status_id = 4 THEN 'Withdraw'
                        ELSE 'Pending'
                    END
                ) as seller_status,

                CONCAT('$base_url', auction.collect_letter) as collect_letter, auction.payment_method_id, auction.seller_status_id,
                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image 
                FROM auction 
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN state ON state.state_id = car.state_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                WHERE auction.deleted = 0 AND auction.auction_status_id = $auction_status_id AND car.users_id = $users_id AND car.deleted = 0 ORDER BY auction.auction_id DESC";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

    function getAuctionRawBuyer($auction_status_id, $users_id){


        // auction.status = 1 submit documents, 2 ready to collect
        $where = "auction.auction_status_id = $auction_status_id";
        if($auction_status_id == 1){
            $where = "auction.auction_status_id = 3 AND auction.status = 0";
        } else if($auction_status_id == 2){
            $where = "auction.auction_status_id = 3 AND auction.status = 1";
        } else if($auction_status_id == 3){
            $where = "auction.auction_status_id = 3 AND auction.status = 2";
        }
        else if($auction_status_id == 4){
            $where = "auction.auction_status_id = 3 AND auction.status = 3";
        }
        $base_url = base_url();
        $sql = "SELECT car.*, CONCAT('$base_url', car.sticker) as sticker, car.manufactured_year, car.mileage, car.engine_capacity, auction.starting_price, auction.expected_price as target_price,
                auction.deposit_amount, model.name as model, brand.name as brand, state.state, car.plate_no, auction.seller_status_id, YEAR(car.manufactured_year) as year, auction.auction_id,
                variant.variant,auction.collect_letter,
                (SELECT COUNT(DISTINCT bid.users_id) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bidder, auction_section.date, auction_section.start_time, auction_section.end_time,
                (SELECT COUNT(*) FROM bid WHERE bid.auction_id = auction.auction_id) AS total_bid,
                (SELECT COUNT(*) FROM auction a2 WHERE a2.car_id = auction.car_id) - 1 AS rebid,
                auction.payment_method_id,
                IF((SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) IS NULL, auction.starting_price, (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id)) AS final_price,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id AND car_image.deleted = 0 LIMIT 1) AS image 
                FROM auction 
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN state ON state.state_id = car.state_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_section_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                WHERE auction.deleted = 0 AND $where AND auction.success_user_id = $users_id AND car.deleted = 0 ORDER BY auction.auction_id DESC";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

    function getAuctionStart(){

        $sql = "SELECT auction.*, YEAR(car.manufactured_year) as year, car.engine_capacity, brand.name as brand, model.name as model, car.users_id as seller_id,
                variant.variant
                FROM auction_section 
                LEFT JOIN auction ON auction.auction_section_id = auction_section.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                WHERE DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= (NOW() - INTERVAL 30 MINUTE)";
              
        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

    function getAuctionPending(){

        $sql = "SELECT auction.*, YEAR(car.manufactured_year) as year, car.engine_capacity, brand.name as brand, model.name as model,
                variant.variant

                FROM auction_section 
                LEFT JOIN auction ON auction.auction_section_id = auction_section.auction_section_id
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                WHERE DATE(auction_section.date) = DATE(NOW()) AND auction_section.start_time <= NOW() AND auction.auction_status_id = 1";
              
        $result = $this->db->query($sql)->getResultArray();
        return $result;

    }

    function getAuctionBidResult($car_id){

        //bid status, bid price, date, time
        $sql = "SELECT car.manufactured_year, YEAR(car.manufactured_year) as year, car.mileage, car.engine_capacity, 
                auction.*, model.name as model, brand.name as brand, auction_section.date, auction_section.start_time, 
                auction_section.end_time, auction_status.name as auction_status,
                variant.variant,

                (SELECT MAX(current_selling_price) FROM bid WHERE bid.auction_id = auction.auction_id) as bid_price
                FROM auction 
                LEFT JOIN car ON car.car_id = auction.car_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                LEFT JOIN auction_section ON auction_section.auction_section_id = auction.auction_id 
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN auction_status ON auction_status.auction_status_id = auction.auction_status_id
                WHERE auction.car_id = $car_id ORDER BY auction.auction_id DESC";
              
        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

	}

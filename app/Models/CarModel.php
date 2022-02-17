<?php namespace App\Models;



use App\Core\BaseModel;

class CarModel extends BaseModel{

	function __construct(){

		parent::__construct();
        $this->single_log('car');
        $this->tableName = "car";
		$this->primaryKey = "car_id";
	}
    function getAll($limit = "", $page = 1, $filter = array()){
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,
        users.contact as seller contact,
        color.name as color,
        model.name as model,state.*,brand.name as brand,
        ,area.name as area,transmission.name as transmission,
        variant.variant,YEAR(car.manufactured_year) as year,
        IF((SELECT COUNT(*) FROM auction WHERE car_id = car.car_id) > 0, 0, 1) as already_auction
        

        ');
        $this->builder->join('model', 'model.model_id = '.$this->tableName.'.model_id', 'left');
        $this->builder->join('variant', 'variant.variant_id = '.$this->tableName.'.variant_id', 'left');
        $this->builder->join('brand', 'brand.brand_id = model.brand_id', 'left');
        $this->builder->join('color', 'color.color_id = '.$this->tableName.'.color_id', 'left');

        $this->builder->join('area', 'area.area_id = '.$this->tableName.'.area_id', 'left');
        $this->builder->join('state', 'area.state_id = state.state_id', 'left');
        
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
        $this->builder->join('transmission', 'transmission.transmission_id = '.$this->tableName.'.transmission_id', 'left');
        

        // $this->builder->join('car_image', 'car_image.car_id = '.$this->tableName.'.car_id', 'left');

        // $this->builder->join('car_inspection', 'car_inspection.car_id = '.$this->tableName.'.car_id', 'left');

        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->orderBy($this->tableName . '.car_id','DESC');


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


    function getCarNotInAuction($limit = "", $page = 1, $filter = array()){

        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*,
        users.contact as seller contact,
        model.name as model,state.*,brand.name as brand,
        ,area.name as area,transmission.name as transmission,
        variant.variant,YEAR(car.manufactured_year) as year,
        IF((SELECT COUNT(*) FROM auction WHERE auction.car_id = car.car_id AND auction.success_user_id != 0) > 0, 1, 0) as already_auction
        
        ');

        $this->builder->join('model', 'model.model_id = '.$this->tableName.'.model_id', 'left');
        $this->builder->join('variant', 'variant.variant_id = '.$this->tableName.'.variant_id', 'left');
        $this->builder->join('brand', 'brand.brand_id = model.brand_id', 'left');

        $this->builder->join('area', 'area.area_id = '.$this->tableName.'.area_id', 'left');
        $this->builder->join('state', 'area.state_id = state.state_id', 'left');
        
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
        $this->builder->join('transmission', 'transmission.transmission_id = '.$this->tableName.'.transmission_id', 'left');
        

        // $this->builder->join('car_image', 'car_image.car_id = '.$this->tableName.'.car_id', 'left');

        // $this->builder->join('car_inspection', 'car_inspection.car_id = '.$this->tableName.'.car_id', 'left');
        // $this->builder->where($where)

        $this->builder->where($this->tableName . '.deleted',0);
        $this->builder->orderBy($this->tableName . '.car_id','DESC');
        $this->builder->having('already_auction','0');

        
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
        $this->builder->select($this->tableName . '.*,users.contact as seller contact,model.name as model,state.*,area.name as area,transmission.name as transmission,variant.variant_id,
        car.modified_by as modified_by,
        color.name as color,
        IF((SELECT COUNT(*) FROM auction WHERE auction.car_id = car.car_id) > 0, 1, 0) as already_auction
        ');
        $this->builder->join('model', 'model.model_id = '.$this->tableName.'.model_id', 'left');
        $this->builder->join('variant', 'variant.variant_id = '.$this->tableName.'.variant_id', 'left');


        $this->builder->join('color', 'color.color_id = '.$this->tableName.'.color_id', 'left');

        $this->builder->join('area', 'area.area_id = '.$this->tableName.'.area_id', 'left');
        $this->builder->join('state', 'area.state_id = state.state_id', 'left');
        $this->builder->join('users', 'users.users_id = '.$this->tableName.'.users_id', 'left');
        $this->builder->join('transmission', 'transmission.transmission_id = '.$this->tableName.'.transmission_id', 'left');

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


    function getInspectionSummary($car_id,$limit = "", $page = 1, $filter = array()){
        $sql = "
        SELECT COUNT(*)  as total,
        (SELECT COUNT(*) as total_pass FROM `car_inspection_detail` 
        INNER JOIN car_inspection_part on car_inspection_part.car_inspection_part_id = car_inspection_detail.car_inspection_part_id
        INNER JOIN car_inspection_type on  car_inspection_type.car_inspection_type_id = car_inspection_part.car_inspection_type_id
        INNER JOIN car on car_inspection_type.car_id = car.car_id
        WHERE car.car_id = $car_id and status_id = 1) as total_pass,
        (SELECT COUNT(*) as total_pass FROM `car_inspection_detail` 
        INNER JOIN car_inspection_part on car_inspection_part.car_inspection_part_id = car_inspection_detail.car_inspection_part_id
        INNER JOIN car_inspection_type on  car_inspection_type.car_inspection_type_id = car_inspection_part.car_inspection_type_id
        INNER JOIN car on car_inspection_type.car_id = car.car_id
        WHERE car.car_id = $car_id and status_id = 2) as total_fail
        FROM `car_inspection_detail` 
        INNER JOIN car_inspection_part on car_inspection_part.car_inspection_part_id = car_inspection_detail.car_inspection_part_id
        INNER JOIN car_inspection_type on  car_inspection_type.car_inspection_type_id = car_inspection_part.car_inspection_type_id
        INNER JOIN car on car_inspection_type.car_id = car.car_id
        WHERE car.car_id = $car_id

        

        ";
        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

    function getWhereAuction($car_id){

        $base_url = base_url();
        $sql = "SELECT car.*, CONCAT('$base_url', car.sticker) as sticker, car.manufactured_year, car.mileage, car.engine_capacity, auction.starting_price, 
                auction.deposit_amount, model.name as model, brand.name as brand, state.state,variant.variant,
                (SELECT CONCAT('$base_url', car_image.image) FROM car_image WHERE car_image.is_thumbnail = 1 AND car_image.car_id = auction.car_id LIMIT 1) AS image 
                FROM car 
                LEFT JOIN auction ON auction.car_id = car.car_id
                LEFT JOIN state ON state.state_id = car.state_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                LEFT JOIN variant ON variant.variant_id = car.variant_id

                WHERE car.car_id = $car_id";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }

//     - License Plate No
// - Variant
// - Current Mileage
// - Current Color
// - Engine No
// - Chassis No
// - Manufactured Year
// - Registration Date
// - Engine Capacity
//  NEW - Existing Loan ( *display only Yes or No )
// - No of Seats
// - No of Previous Owner
// - Plate No (Sell With/Sell Without)
// - Seller ID
// - Fuel Type
// - Registration Type 
    function getAuctionCar($car_id){


        
        $base_url = base_url();
        $sql = "SELECT 
        car.lisence_plate_no as license_plate_no,
                 variant.variant,
                 car.mileage as current_mileage, 
         color.name as current_color,
        car.engine_no,
         car.chassis_no, 
                 car.manufactured_year, 
                 car.registration_date,
         car.engine_capacity,
         car.existing_loan, 
                car.no_of_seat as no_of_seats, 
                car.no_of_previos_owner as no_of_previous_owner,
                car.plate_no as 'Plate No ( Sell With / Sell Without)',
                car.plate_no,
                 car.users_id as car_user_id,
                 
                (SELECT users.name as seller from users where users.users_id = car_user_id) as seller_ID,
         car.fuel_type,
                car.registration_type, 
                 CONCAT('$base_url', car.sticker) as sticker, 
                 car.car_id
                FROM car 

                LEFT JOIN variant ON variant.variant_id = car.variant_id
                LEFT JOIN auction ON auction.car_id = car.car_id
                LEFT JOIN color ON color.color_id = car.color_id
                LEFT JOIN model ON model.model_id = car.model_id
                LEFT JOIN brand ON brand.brand_id = model.brand_id
                WHERE car.car_id = $car_id";

        $result = $this->db->query($sql)->getResultArray();
        return $result;
    }
}
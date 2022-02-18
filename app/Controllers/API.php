<?php

namespace App\Controllers;

use App\Core\BaseController;

use App\Models\AboutModel;
use App\Models\AdminModel;
use App\Models\AuctionModel;
use App\Models\AuctionIncrementModel;
use App\Models\BannerModel;

use App\Models\AuctionSectionModel;
use App\Models\AuctionStatusModel;
use App\Models\BidModel;
use App\Models\BidAutoModel;
use App\Models\BrandModel;
use App\Models\CarModel;
use App\Models\CarImageModel;
use App\Models\CarInspectionModel;
use App\Models\CarStickerModel;
use App\Models\BankModel;

use App\Models\CarInspectionDetailModel;
use App\Models\CarInspectionPartModel;
use App\Models\CarInspectionTypeModel;
use App\Models\ColorModel;
use App\Models\DepositDeductRecordModel;
use App\Models\InspectionDetailModel;
use App\Models\InspectionPartModel;
use App\Models\InspectionTypeModel;
use App\Models\ModelModel;
use App\Models\NotificationModel;
use App\Models\NotificationTypeModel;
use App\Models\QnaModel;
use App\Models\QnaTypeModel;
use App\Models\RoleModel;
use App\Models\ServiceModel;
use App\Models\StateModel;
use App\Models\ToturialModel;
use App\Models\TransferFeeModel;
use App\Models\UsersModel;
use App\Models\WalletModel;
use App\Models\WalletTopupModel;
use App\Models\CarInspectionImageModel;
use App\Models\WalletWithdrawModel;
use App\Models\AuctionWishlistModel;
use App\Models\BestOfferModel;
use App\Models\GetInTouchModel;
use App\Models\EmailModel;
use App\Models\AreaModel;
use App\Models\TransmissionModel;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

use Exception;

class API extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->request = service('request');

        $this->pageData = [];
        $this->BannerModel = new BannerModel();

        $this->BankModel = new BankModel();

        $this->CarStickerModel = new CarStickerModel();
        $this->AboutModel = new AboutModel();
        $this->AdminModel = new AdminModel();
        $this->AuctionModel = new AuctionModel();
        $this->AuctionIncrementModel = new AuctionIncrementModel();
        $this->AuctionSectionModel = new AuctionSectionModel();
        $this->AuctionStatusModel = new AuctionStatusModel();
        $this->BidModel = new BidModel();
        $this->BrandModel = new BrandModel();
        $this->CarModel = new CarModel();
        $this->CarImageModel = new CarImageModel();
        $this->CarInspectionModel = new CarInspectionModel();
        $this->CarInspectionDetailModel = new CarInspectionDetailModel();
        $this->CarInspectionPartModel = new CarInspectionPartModel();
        $this->CarInspectionTypeModel = new CarInspectionTypeModel();
        $this->ColorModel = new ColorModel();
        $this->DepositDeductRecordModel = new DepositDeductRecordModel();
        $this->InspectionDetailModel = new InspectionDetailModel();
        $this->InspectionPartModel = new InspectionPartModel();
        $this->InspectionTypeModel = new InspectionTypeModel();
        $this->ModelModel = new ModelModel();
        $this->NotificationModel = new NotificationModel();
        $this->NotificationTypeModel = new NotificationTypeModel();
        $this->QnaModel = new QnaModel();
        $this->QnaTypeModel = new QnaTypeModel();
        $this->RoleModel = new RoleModel();
        $this->ServiceModel = new ServiceModel();
        $this->StateModel = new StateModel();
        $this->ToturialModel = new ToturialModel();
        $this->UsersModel = new UsersModel();
        $this->WalletModel = new WalletModel();
        $this->WalletTopupModel = new WalletTopupModel();
        $this->WalletWithdrawModel = new WalletWithdrawModel();
        $this->AuctionWishlistModel = new AuctionWishlistModel();
        $this->BestOfferModel = new BestOfferModel();
        $this->GetInTouchModel = new GetInTouchModel();
        $this->BidAutoModel = new BidAutoModel();
        $this->EmailModel = new EmailModel();
        $this->TransferFeeModel = new TransferFeeModel();

        $this->CarInspectionImageModel = new CarInspectionImageModel();
        $this->AreaModel = new AreaModel();
        $this->TransmissionModel = new TransmissionModel();
        $this->database = db_connect();

        // $this->database = db_connect();
        // $sql = 'SELECT * FROM car';
        // $result = $this->database->query($sql)->getResultArray();

        // $_POST = json_decode(file_get_contents("php://input"), true);
    }

    public function get_bank()
    {
        // if ($_POST) {
        try {
            $bank = $this->BankModel->getAll();

            return $this->respond(['data' => $bank]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
        // }
    }
    public function check_company_id()
    {
        //   dd($result);
        if ($_POST) {
            $rules = ['company_id' => 'required'];
            $input = $this->getRequestInput($this->request);
            if (!$this->validateRequest($input, $rules)) {
                return $this->getResponse(
                    ['message' => 'Invalid Company Id'],
                    ResponseInterface::HTTP_NOT_FOUND
                );
            } else {
                return ['company_id' => $_POST['company_id']];
            }
            // return ['company_id' => 0];
        } else {
            return $this->getResponse(
                ['message' => 'Invalid Company Id'],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function reset_password_function()
    {
        if ($_POST) {
            $input = $this->request->getPost();
            $error = false;

            if ($input['password'] != $input['password2']) {
                $error = true;
                $this->pageData['error'] = 'Passwords do not match';
                $this->pageData['input'] = $input;
            }

            if (!$error) {
                $hash = $this->hash($input['password']);

                $where = [
                    'users.users_id' => $_POST['user_id'],
                ];
                $data = [
                    // 'thumbnail' => $thumbnail,
                    'password' => $hash['password'],
                    'salt' => $hash['salt'],
                ];
                $this->UsersModel->updateWhere($where, $data);
                $this->pageData['success'] = 'Password updated';

                return redirect()->to(base_url('API/success', 'refresh'));
            }
        }
    }

    public function reset_password_form($token)
    {
        $where = [
            'password' => $token,
        ];
        $user = $this->UsersModel->getWhere($where);
        if (empty($user)) {
            $this->show404();
        }
        $this->pageData['user'] = $user[0];

        echo view('admin/email/reset_password_form', $this->pageData);
    }
    public function success()
    {
        echo view('admin/email/success', $this->pageData);
    }
    public function generate_token()
    {
        $chars = 'abcdefghijklmnopqrtuvwxyx1234564789';
        return substr(sha1(strtotime('now') . $chars), 0, 64);
    }

    public function validation($input, $rules)
    {
        if (!$this->validateRequest($input, $rules)) {
            return $this->fail($this->get_error());
        } else {
            return true;
        }
    }

    public function get_error()
    {
        return array_values($this->validator->getErrors())[0];
    }
    public function get_service()
    {
        if ($_POST) {
            try {
                // $rules = ['company_id' => 'required'];
                // $input = $this->getRequestInput($this->request);
                // if (!$this->validateRequest($input, $rules))
                // {
                //     return $this->failValidationError($this->get_error());
                // }
                $service = $this->ServiceModel->getAll();
                return $this->respond(['data' => $service]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
                // dd($exception->getMessage());
            }
        }
    }

    public function get_abous_us()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'about.deleted' => 0,
            ];
            $about = $this->AboutModel->getWhere($where);
            return $this->respond(['data' => $about]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_auction_by_car_id()
    {
        try {
            if ($_POST) {
                $where = [
                    'auction.deleted' => 0,
                    'auction.car_id' => $_POST['car_id'],
                ];
                $auction = $this->AuctionModel->getWhere($where);
                foreach ($auction as $key => $row) {
                    $where_bid = [
                        'bid.auction_id' => $row['auction_id'],
                        'bid.deleted' => 0,
                    ];
                    $bid = $this->BidModel->getWhere($where_bid);
                    $auction[$key]['bid'] = $bid;
                    $where_detail = [
                        'auction_increment.auction_id' => $row['auction_id'],
                        'auction_increment.deleted' => 0,
                    ];
                    $auction_increment = $this->AuctionIncrementModel->getWhere(
                        $where_detail
                    );
                    $auction[$key]['increment'] = $auction_increment;
                }
                return $this->respond(['data' => $about]);
            }
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_auction_section()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'auction_section.deleted' => 0,
            ];
            $section = $this->AuctionSectionModel->getWhere($where);
            return $this->respond(['data' => $section]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_auction_status()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'auction_status.deleted' => 0,
            ];

            $status = $this->AuctionStatusModel->getWhere($where);
            return $this->respond(['data' => $status]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_toturial()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'toturial.deleted' => 0,
            ];
            $toturial = $this->ToturialModel->getWhere($where);
            return $this->respond(['data' => $toturial]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_brand()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'brand.deleted' => 0,
            ];

            if (isset($_POST['show_at_filter'])) {
                $where['show_at_filter'] = 1;
            }
            $where = $this->convert_array_to_where($where);
            $brand = $this->BrandModel->getWhereImage($where);
            return $this->respond(['data' => $brand]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_qna()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'qna.deleted' => 0,
            ];
            $qna = $this->QnaModel->getWhere($where);
            return $this->respond(['data' => $qna]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_qna_type()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'qna_type.deleted' => 0,
            ];
            $qna_type = $this->QnaTypeModel->getWhere($where);
            return $this->respond(['data' => $qna_type]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_state()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'state.deleted' => 0,
            ];
            $where = $this->convert_array_to_where($where);
            $state = $this->StateModel->getWhereAuction($where);
            return $this->respond(['data' => $state]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_color()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'color.deleted' => 0,
            ];
            $color = $this->ColorModel->getWhere($where);
            return $this->respond(['data' => $state]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_car()
    {
        try {
            // $rules = ['company_id' => 'required'];
            // $input = $this->getRequestInput($this->request);
            // if (!$this->validateRequest($input, $rules))
            // {
            //     return $this->failValidationError($this->get_error());
            // }
            $where = [
                'deleted' => 0,
            ];
            $car = $this->CarModel->getWhere($where);
            foreach ($car as $key => $row) {
                $where_image = [
                    'car_id' => $row['car_id'],
                ];
                $image = $this->CarImageModel->getImageWhere($where_image);
                $car[$key]['image'] = $image;

                $where_inspection = [
                    'car_id' => $row['car_id'],
                ];
            }
            return $this->respond(['data' => $car]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
            // dd($exception->getMessage());
        }
    }

    public function get_service_by_id()
    {
        if ($_POST) {
            try {
                $rules = ['service_id' => 'required'];
                $input = $this->getRequestInput($this->request);
                if (!$this->validateRequest($input, $rules)) {
                    return $this->failValidationError($this->get_error());
                }
                $service = $this->ServiceModel->getWhere($where);
                return $this->respond(['data' => $service]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
                // dd($exception->getMessage());
            }
        }
    }

    public function userprofile()
    {
        if ($_POST) {
            try {
                $where = [
                    'token' => $_POST['token'],
                ];
                $user = $this->UsersModel->getWhere($where);

                if (count($user)) {
                    $user[0]['submitted_kyc'] = true;

                    if ($user[0]['is_verified'] == 0) {
                        if (
                            $user[0]['nric_front'] == '' &&
                            $user[0]['nric_back'] == '' &&
                            $user[0]['ssm_name'] == '' &&
                            $user[0]['ssm_number'] == '' &&
                            $user[0]['ssm_cert'] == ''
                        ) {
                            $user[0]['submitted_kyc'] = false;
                        }
                    }
                }

                return $this->respond(['data' => $user]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
                // dd($exception->getMessage());
            }
        }
    }

    //get end..

    // daniel start here, car list, car detail, car inspection
    public function validate_token($token, $end_immediate = true)
    {
        $where = [
            'users.token' => $token,
        ];
        $user = $this->UsersModel->getWhereRaw($where);
        $user_id = 0;
        if (!empty($user)) {
            $user_id = $user[0]['users_id'];
        }
        return $user_id;
    }

    public function convert_array_to_where($data)
    {
        array_walk($data, function (&$value, $key) {
            if (strpos($key, ' ') !== false) {
                $value = "{$key} '{$value}'";
            } else {
                $value = "{$key} = '{$value}'";
            }
        });
        $data = implode(' AND ', array_values($data));

        return $data;
    }

    public function get_cars()
    {
        $input = $this->getRequestInput($this->request);

        $cars = $this->CarModel->getWhere(['car.deleted' => 0]);

        return $this->respond(['data' => $cars]);
    }

    public function get_car_detail()
    {
        // dd($first_plate_no);

        // if ($_POST) {
        //     try {
        $input = $this->getRequestInput($this->request);
        // $input['car_id'] = 48;

        $car = $this->CarModel->getAuctionCar($input['car_id'])[0];

        $where = [
            'auction.car_id' => $car['car_id'],
        ];
        $auction = $this->AuctionModel->getWhere($where)[0];
        // dd($auction);
        $stickers = $this->CarStickerModel->getWhere([
            'car_sticker.car_id' => $input['car_id'],
            'car_sticker.is_active' => 1,
        ]);

        $images = [];
        $image = $this->CarImageModel->getWhere([
            'car_id' => $input['car_id'],
        ]);
        foreach ($image as $img) {
            array_push($images, base_url() . $img['image']);
        }

        $sticker = $car['sticker'];
        unset($car['sticker']);
        unset($car['users_id']);
        unset($car['car_id']);
        unset($car['car_user_id']);

        $details = [];

        // $no_of_previos_owner = $car['no_of_previous_owner'];
        // $no_of_seats = $car['no_of_seats'];
        // unset($car['no_of_previous_owner']);
        // unset($car['no_of_seats']);
        $plate_no = $car['license_plate_no'];
        // $first_plate_no = $plate_no[0];
        // $last_plate_no = $plate_no[-1];
        // $complete_plate_no = $first_plate_no . 'XXXXX' . $last_plate_no;
        if ($auction['auction_status_id'] > 2) {
            $complete_plate_no = $plate_no;
            $complete_chassis_no = $car['chassis_no'];
            $complete_seller_id = $car['seller_ID'];
        } else {
            //    dd($car['seller_ID']);
            $complete_seller_id = $this->get_mask_text($car['seller_ID']);

            $complete_plate_no = $this->get_mask_text($plate_no);
            $complete_chassis_no = $this->get_mask_text($car['chassis_no']);
        }

        // unset($car['license_plate_no']);
        unset($car['plate_no']);

        foreach ($car as $index => $val) {
            if ($index == 'license_plate_no') {
                $val = $complete_plate_no;
            }
            if ($index == 'chassis_no') {
                $val = $complete_chassis_no;
            }
            if ($index == 'seller_ID') {
                $val = $complete_seller_id;
            }
            array_push($details, [
                'name' => ucwords(str_replace('_', ' ', $index)),
                'value' => $val,
            ]);
        }
        // array_push($details, [
        //     'name' => 'No of Seats',
        //     'value' => $no_of_seats,
        // ]);
        // array_push($details, [
        //     'name' => 'No of Previos Owner',
        //     'value' => $no_of_previos_owner,
        // ]);
        $result = [
            'images' => $images,
            'sticker' => $sticker,
            'details' => $details,
            'stickers' => $stickers,
            'is_after_bid' => $auction['auction_status_id'] > 2 ? '1' : 0,
        ];
        // dd($details);
        return $this->respond(['data' => $result]);
        // } catch (Exception $exception) {
        //     return $this->fail(['error' => $exception->getMessage()]);
        // }
        // }
    }

    public function get_car_inspection_summary()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $car_id = $input['car_id'];

                $car = $this->CarModel->getWhereAuction($car_id)[0];
                $inspection = $this->CarInspectionModel->getSummary($car_id);

                $summary = 0;
                if ($inspection['total'] != 0) {
                    $summary =
                        ($inspection['total_pass'] * 100) /
                        $inspection['total'];
                }

                $result = [
                    'summary' => $summary,
                    'write_up' =>
                        'Bidder have to deposit RM' .
                        $car['deposit_amount'] .
                        ' first then only eligible for bidding session.',
                ];
                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_car_inspection()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $car_id = $input['car_id'];
                $types = $this->InspectionTypeModel->getWhere([
                    'inspection_type.deleted' => 0,
                ]);
                foreach ($types as $key => $type) {
                    $parts = $this->InspectionPartModel->getWhereCar(
                        $type['inspection_type_id'],
                        $car_id
                    );
                    foreach ($parts as $index => $part) {
                        $details = $this->InspectionDetailModel->getWhereCar([
                            'car_id' => $car_id,
                            'inspection_part_id' => $part['inspection_part_id'],
                        ]);
                        foreach ($details as $num => $det) {
                            $images = $this->CarInspectionImageModel->getWhereImages(
                                $det['car_inspection_id']
                            );
                            $details[$num]['images'] = $images;
                        }
                        $parts[$index]['detail'] = $details;
                    }
                    $types[$key]['parts'] = $parts;
                }
                return $this->respond(['data' => $types]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    // public function insert_inspection_dummy_data_entry(){

    //     $data = [
    //         [ 1, 19 ],
    //         [ 2, 4 ],
    //         [ 3, 12 ],
    //         [ 4, 15 ],
    //         [ 5, 12 ],

    //         [ 6, 29 ],
    //         [ 7, 4 ],
    //         [ 8, 5 ],
    //         [ 9, 6 ],
    //         [ 10, 25 ],
    //         [ 11, 2 ],
    //         [ 12, 11 ],
    //         [ 13, 6 ],
    //         [ 14, 1 ],
    //         [ 15, 16 ],
    //         [ 16, 10 ],
    //         [ 17, 5 ],
    //         [ 18, 4 ],
    //         [ 19, 6 ],
    //         [ 20, 5 ],
    //         [ 21, 2 ],
    //         [ 22, 3 ],
    //         [ 23, 4 ],
    //         [ 24, 3 ],
    //     ];

    //     foreach($data as $row){

    //         $inspection_part_id = $row[0];
    //         $number_of_data = $row[1];

    //         $part = $this->InspectionPartModel->getWhere([
    //             'inspection_part.inspection_part_id' => $inspection_part_id,
    //         ])[0];

    //         $index = 1;
    //         for($i = 0; $i < $number_of_data; $i++){
    //             $this->InspectionDetailModel->insertNew([
    //                 'inspection_part_id' => $part['inspection_part_id'],
    //                 'name' => $part['name'] . ' ' . $index,
    //             ]);
    //             $index++;
    //         }
    //     }
    // }

    public function auto_insert_car_inspection_form($car_id)
    {
        $details = $this->InspectionDetailModel->getWhere([
            'inspection_detail.deleted' => 0,
        ]);

        foreach ($details as $row) {
            $where = [
                'inspection_detail_id' => $row['inspection_detail_id'],
                'car_id' => $car_id,
            ];
            $car_inspection = $this->CarInspectionModel->getWhere([
                'inspection_detail_id' => $row['inspection_detail_id'],
                'car_id' => $car_id,
            ]);
            if (empty($car_inspection)) {
                $this->CarInspectionModel->insertNew([
                    'inspection_detail_id' => $row['inspection_detail_id'],
                    'car_id' => $car_id,
                ]);
            }
        }
    }

    public function get_auction_date()
    {
        $result = $this->AuctionSectionModel->getAvailableDate();
        return $this->respond(['data' => $result]);
    }

    public function get_filter_data($data, $input)
    {
        if (isset($input['brand_id']) && $input['brand_id'] > 0) {
            $data['brand.brand_id'] = $input['brand_id'];
        }

        if (isset($input['model_id']) && $input['model_id'] > 0) {
            $data['car.model_id'] = $input['model_id'];
        }
        if (isset($input['state_id']) && $input['state_id'] > 0) {
            $data['car.state_id'] = $input['state_id'];
        }
        if (isset($input['start_price']) && $input['start_price'] > 0) {
            $data['auction.starting_price >='] = $input['start_price'];
        }
        if (isset($input['end_price']) && $input['end_price'] > 0) {
            $data['auction.starting_price <='] = $input['end_price'];
        }
        if (isset($input['start_year']) && $input['start_year'] > 0) {
            $data['car.manufactured_year >='] = $input['start_year'];
        }
        if (isset($input['end_year']) && $input['end_year'] > 0) {
            $data['car.manufactured_year <='] = $input['end_year'];
        }
        if (isset($input['start_mileage']) && $input['start_mileage'] > 0) {
            $data['car.mileage >='] = $input['start_mileage'];
        }
        if (isset($input['end_mileage']) && $input['end_mileage'] > 0) {
            $data['car.mileage <='] = $input['end_mileage'];
        }
        return $data;
    }

    public function get_auctions()
    {
        if ($_POST) {
            try {
                // filter_id 1 = lastest upated
                // filter_id 2 = Price: Low to high
                // filter_id 3 = Price: High to low
                // filter_id 4 = Year: New to old
                // filter_id 5 = Year Old to New
                // filter_id 6 = Mileage: Low to high
                // filter_id 7 = Mileage: High to low

                // put below param in to where with operator
                // brand_id, model_id, state_id, area_id, start_price, end_price, start_year, end_year, start_mileage, end_mileage

                $input = $this->getRequestInput($this->request);
                $filter_id = $input['filter_id'];

                $user_id = 0;
                if (isset($input['token'])) {
                    $user_id = $this->validate_token($input['token']);
                }
                // if($user_id == 0){
                //     return $this->fail(['error' => 'Invalid Token']);
                // }

                $data = [
                    'auction.deleted' => 0,
                    'auction.auction_section_id' =>
                        $input['auction_section_id'],
                ];
                $data = $this->get_filter_data($data, $input);
                if (isset($input['transmission_id'])) {
                    if ($input['transmission_id'] > 0) {
                        $data['car.transmission_id'] =
                            $input['transmission_id'];
                    }
                }

                $where = $this->convert_array_to_where($data);
                // $where = "auction.deleted = 0 AND auction.auction_section_id = $auction_section_id";
                $auctions = $this->AuctionModel->getWhereFilter(
                    $where,
                    $filter_id,
                    $user_id
                );

                return $this->respond(['data' => $auctions]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function send_otp()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $contact = preg_replace('/[^0-9.]+/', '', $input['contact']);
                $contact =
                    substr($contact, 0, 1) == 6 ? $contact : '6' . $contact;

                $api_key = 'f96ec75039eb17418c58f01964125bcd';
                $secret = 'b36c2eb88326b597d80d33a2f3b32d50';
                $url = 'https://api.smsglobal.com/http-api.php';
                $user = 'yewyang@cysoft.co';
                $password = 'Cysoft_12345!';

                $user = $this->UsersModel->getWhere([
                    'username' => $contact,
                ])[0];

                if (
                    date('Y-m-d H:i:s') <
                    date('Y-m-d H:i:s', strtotime($user['otp_timestamp']))
                ) {
                    return $this->fail([
                        'error' => 'Please try again after 3 minutes.',
                    ]);
                }

                $from = 'carlink';
                $to = $user['username'];

                $otp = substr(
                    str_shuffle(
                        str_repeat($x = '0123456789', ceil(6 / strlen($x)))
                    ),
                    1,
                    4
                );
                $text =
                    'Dear Gplan Customer, your OTP for registration is ' .
                    $otp .
                    '. Use this OTP to validate your registration.';

                $this->UsersModel->updateWhere(
                    ['users_id' => $user['users_id']],
                    [
                        'otp' => $otp,
                        'otp_timestamp' => date(
                            'Y-m-d H:i:s',
                            strtotime('+3 minutes')
                        ),
                    ]
                );

                \SMSGlobal\Credentials::set($api_key, $secret);
                $sms = new \SMSGlobal\Resource\Sms();

                $response = $sms->sendToOne($to, $text);
                return $this->respond(['data' => $response]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_login_method_data($post, $data)
    {
        if (isset($_POST['login_method'])) {
            if ($post['login_method'] == 'facebook') {
                $data['fb_id'] = $post['fb_id'];
            }

            if ($post['login_method'] == 'google') {
                $data['g_id'] = $post['g_id'];
            }
        }

        return $data;
    }

    public function register()
    {
        if ($_POST) {
            try {
                // contact, email, name, password, password2
                $input = $this->getRequestInput($this->request);
                $contact = preg_replace('/[^0-9.]+/', '', $input['contact']);
                $contact =
                    substr($contact, 0, 1) == 6 ? $contact : '6' . $contact;

                $exists = $this->checkExists($contact);
                if ($exists) {
                    return $this->fail([
                        'error' => 'Mobile Number Already Existed!',
                    ]);
                }

                $exists_email = $this->checkExistsEmail($_POST['email']);
                if ($exists_email) {
                    return $this->fail([
                        'error' => 'Email Address Already Existed!',
                    ]);
                }

                if ($input['password'] != $input['password2']) {
                    return $this->fail(['error' => 'Password Not Match!']);
                }

                $hash = $this->hash($input['password']);
                $data = [
                    'name' => $input['name'],
                    'username' => $contact,
                    'contact' => $contact,
                    'email' => $input['email'],
                    'password' => $hash['password'],
                    'salt' => $hash['salt'],
                ];
                $data = $this->get_login_method_data($input, $data);
                $users_id = $this->UsersModel->insertNew($data);
                $user = $this->UsersModel->getWhere([
                    'username' => $contact,
                ])[0];

                $token = md5($users_id . date('Y-m-d h:i:s'));
                $this->UsersModel->updateWhere(
                    ['users_id' => $user['users_id']],
                    ['token' => $token]
                );

                $result = [
                    'users_id' => $user['users_id'],
                    'token' => $token,
                    'contact' => $user['contact'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'nric' => $user['nric'],
                    'is_verified' => $user['is_verified'],
                    'is_otpverified' => $user['is_otpverified'],
                ];
                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function verify_otp()
    {
        if ($_POST) {
            try {
                // users_id, otp
                $input = $this->getRequestInput($this->request);

                $input['contact'] = $this->validate_contact($input['contact']);
                $user = $this->UsersModel->getWhere([
                    'contact' => $input['contact'],
                    'otp' => $input['otp'],
                ]);

                if (empty($user)) {
                    return $this->fail(['error' => 'Incorrect OTP']);
                }

                $this->UsersModel->updateWhere(
                    ['contact' => $input['contact']],
                    ['is_otpverified' => 1]
                );
                return $this->respond(['data' => $user[0]]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function social_login()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                if ($input['login_method'] == 'facebook') {
                    $where = [
                        'fb_id' => $input['fb_id'],
                    ];
                } elseif ($input['login_method'] == 'google') {
                    $where = [
                        'g_id' => $input['g_id'],
                    ];
                } else {
                    die(
                        json_encode([
                            'status' => false,
                            'message' => 'Login method unsupported',
                        ])
                    );
                }

                $login = $this->UsersModel->getWhere($where);
                if ($_POST['email'] != '') {
                    $exists_email = $this->checkExistsEmail($_POST['email']);
                    if ($exists_email) {
                        return $this->fail([
                            'error' => 'Email Address Already Existed!',
                        ]);
                    }
                }

                if (empty($login)) {
                    $data = [
                        'is_otpverified' => 1,
                        // 'fb_id' => $_POST['']
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                    ];

                    $data = $this->get_login_method_data($_POST, $data);
                    $users_id = $this->UsersModel->insertNew($data);
                    $login = $this->UsersModel->getWhere([
                        'users_id' => $users_id,
                    ])[0];
                    // return $this->fail(['error' => 'Invalid Credentials']);
                }

                $login = $login[0];
                $token = md5($login['users_id'] . date('Y-m-d h:i:s'));
                $this->UsersModel->updateWhere(
                    ['users_id' => $login['users_id']]
                    // ['token' => $token]
                );

                $result = [
                    'users_id' => $login['users_id'],
                    'token' => $token,
                    'contact' => $login['contact'],
                    'name' => $login['name'],
                    'email' => $login['email'],
                    'nric' => $login['nric'],
                    'is_verified' => $login['is_verified'],
                    'is_otpverified' => $login['is_otpverified'],
                ];
                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function login()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $contact = preg_replace('/[^0-9.]+/', '', $input['contact']);
                $contact =
                    substr($contact, 0, 1) == 6 ? $contact : '6' . $contact;

                $login = $this->UsersModel->login($contact, $input['password']);
                if (empty($login)) {
                    return $this->fail(['error' => 'Invalid Credentials']);
                }

                $login = $login[0];
                $token = md5($login['users_id'] . date('Y-m-d h:i:s'));
                // $this->UsersModel->updateWhere(
                //     ['users_id' => $login['users_id']],
                //     // ['token' => $token]
                // );

                $result = [
                    'users_id' => $login['users_id'],
                    // 'token' => $token,
                    'token' => $login['token'],
                    'contact' => $login['contact'],
                    'name' => $login['name'],
                    'email' => $login['email'],
                    'nric' => $login['nric'],
                    'is_verified' => $login['is_verified'],
                    'is_otpverified' => $login['is_otpverified'],
                ];
                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function verify_consumer()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $this->UsersModel->updateWhere(
                    ['users_id' => $input['users_id']],
                    [
                        'nric' => $input['nric'],
                        'nric_name' => $input['nric_name'],
                    ]
                );
                return $this->respond(['data' => true]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function verify_merchant()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $this->UsersModel->updateWhere(
                    ['users_id' => $input['users_id']],
                    [
                        'ssm_number' => $input['ssm_number'],

                        'ssm_name' => $input['ssm_name'],
                    ]
                );
                return $this->respond(['data' => true]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function upload_users_file()
    {
        if ($_POST) {
            try {
                // post filename and file
                $input = $this->getRequestInput($this->request);

                $file = $this->upload_image('file');
                $this->UsersModel->updateWhere(
                    ['users_id' => $input['users_id']],
                    [$input['filename'] => $file]
                );

                return $this->respond(['data' => base_url() . $file]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    // change password
    public function change_password()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                if ($input['password'] != $input['password2']) {
                    return $this->fail(['error' => 'Password Not Match!']);
                }

                $hash = $this->hash($input['password']);
                $data = [
                    'password' => $hash['password'],
                    'salt' => $hash['salt'],
                ];
                $this->UsersModel->updateWhere(
                    ['users_id' => $input['users_id']],
                    $data
                );
                $user = $this->UsersModel->getWhere([
                    'users_id' => $input['users_id'],
                ]);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_user_balance()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $balance = $this->WalletModel->get_balance($input['users_id']);
                // amount, users_id, upload_image
                return $this->respond(['data' => $balance]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_unread_notifications()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $unread_count = $this->NotificationModel->getUnreadNotificationUser(
                    $input['users_id']
                );
                // amount, users_id, upload_image
                return $this->respond(['data' => $unread_count]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_topup_history()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                // $input['user_id'] = 27;
                $where = [
                    'wallet_topup.users_id' => $input['users_id'],
                ];
                $wallet_topup = $this->WalletTopupModel->getWhere($where);

                return $this->respond(['data' => $wallet_topup]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_withdrawal_history()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                // $input['user_id'] = 27;
                $where = [
                    'wallet_withdraw.users_id' => $input['users_id'],
                ];
                $wallet_withdraw = $this->WalletWithdrawModel->getWhere($where);

                return $this->respond(['data' => $wallet_withdraw]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function format_wallet_record($wallet_record)
    {
        foreach ($wallet_record as $key => $row) {
            if ($row['type'] == 'Withdrawal') {
                if (
                    $row['status'] == 'Pending' ||
                    $row['status'] == 'Approved'
                ) {
                    //if still pending and havent approved
                    $wallet_record[$key]['transaction'] =
                        '-' . $row['wallet_in'];
                } else {
                    $wallet_record[$key]['transaction'] =
                        '+' . $row['wallet_in'];
                }
            }

            if ($row['type'] == 'Topup') {
                if ($row['status'] == 'Approved') {
                    //if still pending and havent approved
                    $wallet_record[$key]['transaction'] =
                        '+' . $row['wallet_in'];
                } else {
                    $wallet_record[$key]['transaction'] = $row['wallet_in'];
                }
            }

            if ($row['type'] == 'Transaction') {
                if ($row['wallet_in'] > 0) {
                    //if still pending and havent approved
                    $wallet_record[$key]['transaction'] =
                        '+' . $row['wallet_in'];
                } elseif ($row['wallet_out'] > 0) {
                    $wallet_record[$key]['transaction'] =
                        '-' . $row['wallet_out'];
                }
            }
        }
        // dd($wallet_record);

        return $wallet_record;
    }
    public function topup_wallet()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                // amount, users_id
                $verified = $this->validate_verified($input['users_id']);
                if (!$verified) {
                    return $this->fail([
                        'error' =>
                            'Account not verified by admin , please contact admin to verify your account',
                    ]);
                }
                $data = [
                    'amount' => $input['amount'],
                    'users_id' => $input['users_id'],
                    'receipt' => $input['receipt'],

                    'remarks' => 'Top up request',
                ];
                $wallet_topup_id = $this->WalletTopupModel->insertNew($data);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_upload_path()
    {
        if ($_POST) {
            try {
                // post filename and file
                $input = $this->getRequestInput($this->request);

                $file = $this->upload_image('file');
                return $this->respond(['data' => base_url() . $file]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function withdraw_wallet()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $verified = $this->validate_verified($input['users_id']);
                if (!$verified) {
                    return $this->fail([
                        'error' =>
                            'Account not verified by admin , please contact admin to verify your account',
                    ]);
                }

                $balance = $this->WalletModel->get_balance($input['users_id']);

                if ($balance < $input['amount']) {
                    return $this->fail(['error' => 'Insufficient Wallet']);
                }

                // amount, users_id
                $data = [
                    'amount' => $input['amount'],
                    'remarks' => 'Withdrawal Request',
                    'users_id' => $input['users_id'],
                    'bank_acc' => $input['bank_acc'],
                    'bank_name' => $input['bank_name'],
                    'acc_name' => $input['acc_name'],
                ];
                $wallet_withdraw_id = $this->WalletWithdrawModel->insertNew(
                    $data
                );

                $data = [
                    'users_id' => $input['users_id'],
                    'wallet_withdraw_id' => $wallet_withdraw_id,
                    'auction_id' => 0,
                    'amount' => '-' . $input['amount'],
                    'remarks' => 'Withdrawal Request',
                ];
                $this->WalletModel->update_wallet($data);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_wallet_history()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                // $input['users_id'] = 28;
                $wallet = $this->WalletModel->get_history_new(
                    $input['users_id']
                );
                $wallet = $this->format_wallet_record($wallet);
                // dd($wallet);
                return $this->respond(['data' => $wallet]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function add_wishlist()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $this->AuctionWishlistModel->insertNew([
                    'users_id' => $input['users_id'],
                    'auction_id' => $input['auction_id'],
                ]);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function remove_wishlist()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $this->AuctionWishlistModel->hardDeleteWhere([
                    'users_id' => $input['users_id'],
                    'auction_id' => $input['auction_id'],
                ]);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_notifications()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $user_id = $this->validate_token($input['token']);
                if ($user_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }
                $result = $this->NotificationModel->getWhereWithTypes($user_id);

                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function notification_details()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $user_id = $this->validate_token($input['token']);
                if ($user_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }
                $result = $this->NotificationModel->getWhere([
                    'notification_id' => $input['notification_id'],
                ]);

                $where = [
                    'notification_id' => $input['notification_id'],
                ];
                $this->NotificationModel->updateWhere($where, ['is_read' => 1]);
                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function read_notification()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $user_id = $this->validate_token($input['token']);
                if ($user_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }

                $this->NotificationModel->updateWhere(
                    ['notification_id' => $input['notification_id']],
                    ['is_read' => 1]
                );

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    //get only first and last text

    public function get_mask_text($text)
    {
        $first_text = $text[0];
        $last_text = $text[-1];
        $complete_text = $first_text . 'XXXXX' . $last_text;
        return $complete_text;
    }

    public function get_popular_auctions()
    {
        try {
            $auctions = $this->AuctionModel->getPopularAuction();

            foreach ($auctions as $key => $row) {
                $is_wishlist = 0;
                if (isset($input['user_id'])) {
                    $existed = $this->AuctionWishlistModel->getWhere([
                        'user_id' => $input['user_id'],
                        'car_id' => $row['car_id'],
                    ]);
                    $is_wishlist = count($existed) > 0 ? 1 : 0;
                }
                $auctions[$key]['is_wishlist'] = $is_wishlist;
            }

            return $this->respond(['data' => $auctions]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
        }
    }

    public function best_offer_request()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $data = [
                    'brand_id' => $input['brand_id'],
                    'model_id' => $input['model_id'],
                    'year' => $input['year'],
                    'name' => $input['name'],
                    'contact' => $input['contact'],
                    'state_id' => $input['state_id'],
                    'area_id' => $input['area_id'],
                    'email' => $input['email'],
                ];
                $this->BestOfferModel->insertNew($data);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_in_touch_request()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $data = [
                    'name' => $input['name'],
                    'contact' => $input['contact'],
                    'email' => $input['email'],
                    'message' => $input['message'],
                ];
                $this->GetInTouchModel->insertNew($data);

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function validate_verified($users_id)
    {
        $where = [
            'users.users_id' => $users_id,
        ];
        $user = $this->UsersModel->getWhere($where);
        // dd($user);
        if (empty($user)) {
            return false;
        }
        $user = $user[0];

        if ($user['is_verified'] == 0) {
            return false;
        }
        return true;
    }
    function get_bids()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $where = [
                    'bid.auction_id' => $input['auction_id'],
                ];
                $bids = $this->BidModel->getWhereLimit($where, 20);

                return $this->respond(['data' => $bids]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function get_auction_end_time()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $where = [
                    'auction.auction_id' => $input['auction_id'],
                ];
                $auction = $this->AuctionModel->getWhere($where)[0];
                $data = [
                    'end_time' => $auction['end_time'],
                    'date' => $auction['date'],
                    'start_time' => $auction['start_time'],
                ];
                return $this->respond(['data' => $data]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function check_user_valid_for_bid()
    {
        $input = $this->getRequestInput($this->request);

        $valid = $this->check_auction_entry(
            $input['auction_id'],
            $input['users_id']
        );
        if (!$valid) {
            $auction = $this->AuctionModel->getWhere([
                'auction_id' => $input['auction_id'],
            ])[0];
            return $this->fail([
                'error' =>
                    'To start the bidding, you will need to deposit RM' .
                    $auction['deposit_amount'] .
                    ' for the entry',
            ]);
        }
        $verified = $this->validate_verified($input['users_id']);
        if (!$verified) {
            return $this->fail([
                'error' =>
                    'Account not verified by admin , please contact admin to verify your account',
            ]);
        }
        return $this->respond(['data' => 'valid for bidding']);
    }

    function add_bid()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $verified = $this->validate_verified($input['users_id']);
                if (!$verified) {
                    return $this->fail([
                        'error' =>
                            'Account not verified by admin , please contact admin to verify your account',
                    ]);
                }

                $valid = $this->check_auction_entry(
                    $input['auction_id'],
                    $input['users_id']
                );
                if (!$valid) {
                    $auction = $this->AuctionModel->getWhere([
                        'auction_id' => $input['auction_id'],
                    ])[0];
                    return $this->fail([
                        'error' =>
                            'To start the bidding, you will need to deposit RM' .
                            $auction['deposit_amount'] .
                            ' for the entry',
                    ]);
                }

                $ended = $this->check_if_auction_ended($input['auction_id']);
                if ($ended) {
                    die(
                        json_encode([
                            'status' => false,
                            'message' => 'Auction Ended',
                        ])
                    );
                    // return $this->fail(['error' => 'Auction Ended']);
                }

                $final_auto_users_id = $this->BidModel->get_last_users_id(
                    $input['auction_id']
                );
                if ($input['users_id'] == $final_auto_users_id) {
                    // return $this->fail([
                    //     'error' => 'You are the highest bid now',
                    // ]);
                    die(
                        json_encode([
                            'status' => false,
                            'message' => 'You are the highest bid now',
                        ])
                    );
                }

                $current_selling_price = $this->BidModel->get_current_selling_price(
                    $input['auction_id']
                );

                $data = [
                    'users_id' => $input['users_id'],
                    'auction_id' => $input['auction_id'],
                    'price' => $input['price'],
                    'current_selling_price' =>
                        $current_selling_price + $input['price'],
                ];
                $this->BidModel->insertNew($data);
                // $this->run_auto_bid($input['auction_id']);

                return $this->respond(['data' => $data]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function get_auction_detail()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $data = ['auction_id' => $input['auction_id']];
                $where = $this->convert_array_to_where($data);
                // $auction = $this->AuctionModel->getWhereFilter($where, 1, 0)[0];
                $auction = $this->AuctionModel->getWhereFilterNew(
                    $where,
                    1,

                    0
                )[0];
                $auction['increments'] = $this->AuctionIncrementModel->getWhere(
                    [
                        'auction_id' => $input['auction_id'],
                    ]
                );

                return $this->respond(['data' => $auction]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function check_auction_entry($auction_id, $users_id)
    {
        $auction = $this->AuctionModel->getWhere([
            'auction_id' => $auction_id,
        ])[0];
        $deposit_amount = $auction['deposit_amount'];
        $balance = $this->WalletModel->get_balance($users_id);

        $existed = $this->WalletModel->getWhere([
            'wallet.users_id' => $users_id,
            'wallet.auction_id' => $auction_id,
        ]);

        if (empty($existed)) {
            if ($deposit_amount > $balance) {
                return false;
            }

            $data = [
                'users_id' => $users_id,
                'auction_id' => $auction_id,
                'amount' => '-' . $deposit_amount,
                'remarks' => 'Entry Of Auction ID' . $auction['auction_id'],
            ];
            $this->WalletModel->update_wallet($data);
        }

        return true;
    }

    function auction_entry()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $auction = $this->AuctionModel->getWhere([
                    'auction_id' => $input['auction_id'],
                ])[0];
                $deposit_amount = $auction['deposit_amount'];
                $balance = $this->WalletModel->get_balance($input['users_id']);

                $existed = $this->WalletModel->getWhere([
                    'users_id' => $input['users_id'],
                    'auction_id' => $input['auction_id'],
                ]);

                if (empty($existed)) {
                    if ($deposit_amount > $balance) {
                        $this->fail(['error' => 'Insuffient Credit']);
                    }

                    $data = [
                        'users_id' => $input['users_id'],
                        'auction_id' => $input['auction_id'],
                        'amount' => '-' . $deposit_amount,
                        'remarks' =>
                            'Entry Of Auction ID' . $auction['auction_id'],
                    ];
                    $this->WalletModel->update_wallet($data);
                }

                return $this->respond(['data' => $auction]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function add_auto_bid()
    {
        // recursive auto bid if new record added

        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $valid = $this->check_auction_entry(
                    $input['auction_id'],
                    $input['users_id']
                );
                if (!$valid) {
                    $auction = $this->AuctionModel->getWhere([
                        'auction_id' => $input['auction_id'],
                    ])[0];
                    return $this->fail([
                        'error' =>
                            'To start the bidding, you will need to deposit RM' .
                            $auction['deposit_amount'] .
                            ' for the entry',
                    ]);
                }

                $ended = $this->check_if_auction_ended($input['auction_id']);
                if ($ended) {
                    die(
                        json_encode([
                            'status' => false,
                            'message' => 'Auction Ended',
                        ])
                    );
                    // return $this->fail(['error' => 'Auction Ended']);
                }

                $price = $this->AuctionModel->getMinimumIncrement(
                    $input['auction_id']
                );

                $data = [
                    'users_id' => $input['users_id'],
                    'auction_id' => $input['auction_id'],
                    'max_price' => $input['max_price'],
                    'price' => $price,
                ];
                $this->BidAutoModel->insertNew($data);
                // $this->run_auto_bid($input['auction_id']);

                return $this->respond(['data' => $data]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function run_auto_bid($auction_id)
    {
        $ended = $this->check_if_auction_ended($auction_id);
        if ($ended) {
            return false;
        }
        $bids = $this->database
            ->query(
                'select * from bid where auction_id = ? order by current_selling_price desc limit 1',
                [$auction_id]
            )
            ->getResultArray();

        // $sql = 'SELECT * FROM car';
        // $result = $this->database->query($sql)->getResultArray();

        $current_selling_price = 0;
        $user = 0;
        if (count($bids)) {
            $current_selling_price = $bids[0]['current_selling_price'];
            $user = $bids[0]['users_id'];
        } else {
            $current_selling_price = $this->AuctionModel->getWhereRaw([
                'auction_id' => $auction_id,
            ])[0]['starting_price'];
            $user = -1;
        }

        // $auto = $this->database->query("select * from bid where auction_id = ? order by price desc limit 1")->getResultArray();

        $auto = $this->database
            ->query(
                'select users_id, max(max_price) as max_price, price from bid_auto where auction_id = ? and max_price  > ? and users_id != ? group by users_id',
                [$auction_id, $current_selling_price, $user]
            )
            ->getResultArray();

        if (count($auto)) {
            echo 'Add';

            $this->BidModel->insertNew([
                'auction_id' => $auction_id,
                'users_id' => $auto[0]['users_id'],
                'price' => $auto[0]['price'],
                'current_selling_price' =>
                    intval($auto[0]['price']) + intval($current_selling_price),
            ]);
            $this->run_auto_bid($auction_id);
        } else {
            die('DONE');
        }
    }

    function run_auto_bid_new()
    {
        if ($_POST) {
            var_dump('START RUN AUTO BID');
            $auction_id = $_POST['auction_id'];
            $ended = $this->check_if_auction_ended($auction_id);
            if ($ended) {
                return false;
            }

            // get auto_bid record
            // find final bid
            // find final bid user
            // loop bid record to check
            // skip if final bid is bid by final bid user
            // else insert new record
            // if last auto bid not reach auto bid maximum, recursive

            $autos = $this->BidAutoModel->getWhereGroupUser($auction_id);
            // die(var_dump($autos));
            $final_selling_price = $this->BidModel->get_current_selling_price(
                $auction_id
            );
            $final_auto_users_id = $this->BidModel->get_last_users_id(
                $auction_id
            );

            foreach ($autos as $row) {
                $current_selling_price = $this->BidModel->get_current_selling_price(
                    $auction_id
                );
                $last_users_id = $this->BidModel->get_last_users_id(
                    $auction_id
                );
                $next_selling_price = $current_selling_price + $row['price'];

                // skip if same users
                if (
                    $last_users_id != $row['users_id'] &&
                    $next_selling_price <= $row['max_price']
                ) {
                    $data = [
                        'users_id' => $row['users_id'],
                        'auction_id' => $row['auction_id'],
                        'price' => $row['price'],
                        'current_selling_price' => $next_selling_price,
                    ];
                    // $this->BidModel->insertNew($data);

                    $where = [
                        'bid.current_selling_price' => $next_selling_price,
                        'bid.users_id' => $row['users_id'],
                        'bid.auction_id' => $row['auction_id'],
                    ];
                    $bid = $this->BidModel->getWhere($where);
                    if (empty($bid)) {
                        // if bid not existed
                        $this->BidModel->insertNew($data);
                    }

                    $final_auto_users_id = $row['users_id'];
                    // $final_selling_price = $next_selling_price + $row['price'];
                    $final_selling_price = $next_selling_price;
                }
            }

            // check if available auto record more than 1
            $existed = $this->BidAutoModel->getWhereGroup(
                $auction_id,
                $final_selling_price
            );
            if (count($existed) == 1) {
                var_dump('END RUN AUTO BID');
                return false;
            }

            $maximum = $this->BidAutoModel->getMaximumBid($auction_id);
            if ($final_selling_price < $maximum) {
                var_dump('RECURSIVE');
                return $this->run_auto_bid($auction_id);
            }
        }
    }

    function get_live_bidding()
    {
        if ($_POST) {
            try {
                // filter_id 1 = lastest upated
                // filter_id 2 = Price: Low to high
                // filter_id 3 = Price: High to low
                // filter_id 4 = Year: New to old
                // filter_id 5 = Year Old to New
                // filter_id 6 = Mileage: Low to high
                // filter_id 7 = Mileage: High to low

                // put below param in to where with operator
                // brand_id, model_id, state_id, area_id, start_price, end_price, start_year, end_year, start_mileage, end_mileage

                $input = $this->getRequestInput($this->request);
                $filter_id = $input['filter_id'];

                $user_id = 0;
                if (isset($input['token'])) {
                    $user_id = $this->validate_token($input['token']);
                }
                // if($user_id == 0){
                //     return $this->fail(['error' => 'Invalid Token']);
                // }

                $data = [
                    'auction.deleted' => 0,
                    'DATE(auction.date)' => date('Y-m-d'),
                    'auction.start_time <=' => date('H:i:s'),
                    'auction.end_time >=' => date('H:i:s'),
                ];
                $data = $this->get_filter_data($data, $input);
                if (isset($input['transmission_id'])) {
                    if ($input['transmission_id'] > 0) {
                        $data['car.transmission_id'] =
                            $input['transmission_id'];
                    }
                }

                $where = $this->convert_array_to_where($data);
                // $where = "auction.deleted = 0 AND auction.auction_section_id = $auction_section_id";
                $auctions = $this->AuctionModel->getWhereFilterLive(
                    $where,

                    $filter_id,

                    $user_id
                );

                return $this->respond(['data' => $auctions]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function get_bidding_list()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $filter_id = 1;

                $user_id = 0;
                if (isset($input['token'])) {
                    $user_id = $this->validate_token($input['token']);
                }
                // if($user_id == 0){
                //     return $this->fail(['error' => 'Invalid Token']);
                // }

                $data = [
                    'auction.deleted' => 0,
                    'DATE(auction_section.date)' => date('Y-m-d'),
                    'auction_section.start_time <=' => date('H:i:s'),
                    'auction_section.end_time >=' => date('H:i:s'),
                ];
                $data = $this->get_filter_data($data, $input);
                if (isset($input['transmission_id'])) {
                    if ($input['transmission_id'] > 0) {
                        $data['car.transmission_id'] =
                            $input['transmission_id'];
                    }
                }

                $where = $this->convert_array_to_where($data);
                $auctions = $this->AuctionModel->getBiddingList(
                    $where,
                    $filter_id,
                    $user_id
                );

                return $this->respond(['data' => $auctions]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function get_wishlist()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $filter_id = 1;

                $user_id = 0;
                if (isset($input['token'])) {
                    $user_id = $this->validate_token($input['token']);
                }
                $auctions = $this->AuctionModel->getWishList($user_id);

                return $this->respond(['data' => $auctions]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function get_auction_history()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $users_id = $this->validate_token($input['token']);
                if ($users_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }

                $status = $this->AuctionStatusModel->getWhere(['deleted' => 0]);

                foreach ($status as $key => $row) {
                    $auctions = $this->AuctionModel->getAuctionRaw(
                        $row['auction_status_id'],
                        $users_id
                    );
                    $status[$key]['auctions'] = $auctions;
                }
                return $this->respond(['data' => $status]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function approve_auction_result()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $this->AuctionModel->updateWhere(
                    ['auction_id' => $input['auction_id']],
                    ['seller_status_id' => 1]
                );

                // send notification to buyer
                $auction = $this->AuctionModel->getWhere([
                    'auction.auction_id' => $input['auction_id'],
                ])[0];
                $this->send_notification(
                    $auction['success_user_id'],
                    'Seller has accepted your bided price.',
                    'Auction ID' .
                        $input['auction_id'] .
                        ' has been accepted by seller. You may click Successful Bids - Pending Acceptance to confirm your payment method.',
                    1,
                    $input['auction_id']
                );

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function rebid_auction()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $this->AuctionModel->updateWhere(
                    ['auction_id' => $input['auction_id']],
                    ['seller_status_id' => 3]
                );

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function withdraw_auction()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $this->AuctionModel->updateWhere(
                    ['auction_id' => $input['auction_id']],
                    ['seller_status_id' => 4]
                );

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function reject_auction_result()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $this->AuctionModel->updateWhere(
                    ['auction_id' => $input['auction_id']],
                    ['auction_status_id' => 5]
                );

                // send notification to buyer
                $auction = $this->AuctionModel->getWhere([
                    'auction.auction_id' => $input['auction_id'],
                ])[0];
                $this->send_notification(
                    $auction['success_user_id'],
                    'Seller has rejected your bided price.',
                    'Auction ID' .
                        $input['auction_id'] .
                        ' has been rejected by seller. We look forward for your next bid.',
                    1,
                    $input['auction_id']
                );

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function fail_response()
    {
        die(var_dump($this->fail(['error' => 'fail message'])));
    }

    public function refresh_bid_list($auction_id)
    {
        $ch = curl_init('http://206.189.80.215/carlink_backend/new_message');

        $payload = json_encode(['auction_id' => $auction_id]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function verify_user()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $users_id = $this->validate_token($input['token']);
                if ($users_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }

                $user = $this->UsersModel->getWhere([
                    'users.users_id' => $users_id,
                ])[0];

                if ($user['is_verified'] == 0) {
                    return $this->fail([
                        'error' => 'Your account is not verify by admin yet.',
                    ]);
                }

                if ($user['is_otpverified'] == 0) {
                    return $this->fail([
                        'error' => 'Your OTP verification is not done yet.',
                    ]);
                }

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function verify_otp_password()
    {
        if ($_POST) {
            try {
                // users_id, otp
                $input = $this->getRequestInput($this->request);

                $input['contact'] = $this->validate_contact($input['contact']);
                $user = $this->UsersModel->getWhere([
                    'contact' => $input['contact'],
                    'otp' => $input['otp'],
                ]);

                if (empty($user)) {
                    return $this->fail(['error' => 'Incorrect OTP']);
                }

                $this->UsersModel->updateWhere(
                    ['contact' => $input['contact']],
                    ['is_password_verified' => 1]
                );
                return $this->respond(['data' => true]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function auction_end()
    {
        $auctions = $this->AuctionModel->getWhere([
            'auction.auction_status_id' => 2,
        ]);

        foreach ($auctions as $auction) {
            $auction_id = $auction['auction_id'];
            $end_datetime = date(
                'Y-m-d H:i:s',
                strtotime($auction['date'] . ' ' . $auction['end_time'])
            );
            $ended = $this->check_if_auction_ended($auction_id);

            if ($auction['success_user_id'] == 0 && $ended) {
                // get last bid user
                $final_users_id = $this->BidModel->get_last_users_id(
                    $auction_id
                );
                // update success bid user_id
                $this->AuctionModel->updateWhere(
                    ['auction_id' => $auction_id],
                    [
                        'success_user_id' => $final_users_id,
                        'auction_status_id' => 3,
                    ]
                );

                // send notification to buyer
                $this->send_notification(
                    $final_users_id,
                    'Congratulation! You have won the auction.',
                    'Congratulation! You have won the auction ID' .
                        $auction['auction_id'] .
                        '. 
                    You may wait for the seller to accept / reject your bided price in 24 hours. 
                    You can click Successful Bids - Pending Acceptance to confirm your payment method.',

                    1,
                    $auction_id
                );

                // send notification to failed bider
                $failed = $this->BidModel->getFailedBidder(
                    $final_users_id,
                    $auction_id
                );
                foreach ($failed as $row) {
                    $this->send_notification(
                        $row['users_id'],
                        'Unfortunately, you did not win the auction you bidded.',
                        'You did not win the auction ID' .
                            $auction['auction_id'] .
                            '. Search for more vehicles in Marketplace. Good luck.',
                        1,
                        $auction_id
                    );
                }

                // send notification to seller
                $car = $this->CarModel->getWhere([
                    'car_id' => $auction['car_id'],
                ])[0];

                $user = $this->UsersModel->getWhere([
                    'users.users_id' => $final_users_id,
                ])[0];
                $this->send_notification(
                    $car['users_id'],
                    'Your car had been bided.',
                    'Congratulations! Your vehicle has been bided by ' .
                        $user['username'] .
                        '. Please click My Cars For Bids - End to accept buyer bided price',
                    3,
                    $auction_id
                );

                // refund
                $where = [
                    'bid.users_id != ' => $final_users_id,
                    'bid.auction_id' => $auction_id,
                ];
                $users = $this->BidModel->getWhere($where);

                foreach ($users as $user) {
                    $where = [
                        'wallet.users_id' => $user['users_id'],
                        'wallet.auction_id' => $auction_id,
                        'wallet.wallet_out !=' => 0,
                    ];
                    $deposit = $this->WalletModel->getWhere($where);

                    if (!empty($deposit)) {
                        $where = [
                            'wallet.users_id' => $user['users_id'],
                            'wallet.auction_id' => $auction_id,
                            'wallet.wallet_in !=' => 0,
                        ];
                        $refund = $this->WalletModel->getWhere($where);

                        if (empty($refund)) {
                            $data = [
                                'users_id' => $user['users_id'],
                                'auction_id' => $auction_id,
                                'amount' => abs($deposit[0]['wallet_out']),
                                'remarks' => 'Refund For ID' . $auction_id,
                            ];
                            $this->WalletModel->update_wallet($data);
                        }
                    }
                }
            }
        }
    }

    public function ended_bid_result()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $auction_id = $input['auction_id'];

                // check if auction ended
                $auction = $this->AuctionModel->getWhere([
                    'auction_id' => $auction_id,
                ])[0];
                $end_datetime = date(
                    'Y-m-d H:i:s',
                    strtotime($auction['date'] . ' ' . $auction['end_time'])
                );
                $ended = $this->check_if_auction_ended($auction_id);

                if ($auction['success_user_id'] == 0 && $ended) {
                    // get last bid user
                    $final_users_id = $this->BidModel->get_last_users_id(
                        $auction_id
                    );
                    // die(var_dump($final_users_id));
                    // update success bid user_id
                    $this->AuctionModel->updateWhere(
                        ['auction_id' => $auction_id],
                        [
                            'success_user_id' => $final_users_id,
                            'auction_status_id' => 3,
                        ]
                    );
                    // send notification to buyer
                    $this->send_notification(
                        $final_users_id,

                        'Congratulation! You have won the auction.',
                        'Congratulation! You have won the auction ID' .
                            $auction['auction_id'] .
                            '. 
                        You may wait for the seller to accept / reject your bided price in 24 hours. 
                        You can click Successful Bids - Pending Acceptance to confirm your payment method.',
                        1,
                        $auction_id
                    );

                    // send notification to failed bider
                    $failed = $this->BidModel->getWhere([
                        'users_id !=' => $final_users_id,
                    ]);
                    foreach ($failed as $row) {
                        $this->send_notification(
                            $row['users_id'],
                            'Unfortunately, you did not win the auction you bidded.',
                            'You did not win the auction ID' .
                                $auction['auction_id'] .
                                '. Search for more vehicles in Marketplace. Good luck.',
                            1,
                            $auction_id
                        );
                    }

                    // send notification to seller
                    $car = $this->CarModel->getWhere([
                        'car_id' => $auction['car_id'],
                    ])[0];

                    $user = $this->UsersModel->getWhere([
                        'users_id' => $final_users_id,
                    ])[0];
                    $this->send_notification(
                        $car['users_id'],
                        'Your car had been bided.',
                        'Congratulations! Your vehicle has been bided by ' .
                            $user['username'] .
                            '. Please click My Cars For Bids - End to accept buyer bided price',
                        3,
                        $auction_id
                    );
                }
                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function send_notification(
        $users_id,
        $name,
        $description,
        $notification_type_id,
        $auction_id
    ) {
        // 1 - auction, 2 - wishlist, 3 - seller, 4 - update
        $data = [
            'auction_id' => $auction_id,
            'users_id' => $users_id,
            'name' => $name,
            'description' => $description,
            'notification_type_id' => $notification_type_id,
        ];
        $this->NotificationModel->insertNew($data);
    }

    function get_buyer_auction_history()
    {
        if ($_POST) {
            try {
                // pending acceptance, submit documents, ready to collect, completed, rejected

                $input = $this->getRequestInput($this->request);
                $users_id = $this->validate_token($input['token']);
                if ($users_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }

                $status = [
                    [
                        'auction_status_buyer_id' => 1,
                        'name' => 'Pending Acceptance',
                    ],
                    [
                        'auction_status_buyer_id' => 2,
                        'name' => 'Submit Documents',
                    ],

                    [
                        'auction_status_buyer_id' => 3,
                        'name' => 'Ready To Collect',
                    ],
                    ['auction_status_buyer_id' => 4, 'name' => 'Completed'],
                    ['auction_status_buyer_id' => 5, 'name' => 'Rejected'],
                ];

                foreach ($status as $key => $row) {
                    $auctions = $this->AuctionModel->getAuctionRawBuyer(
                        $row['auction_status_buyer_id'],
                        $users_id
                    );
                    $status[$key]['auctions'] = $auctions;
                }

                return $this->respond(['data' => $status]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function wishlist_notification()
    {
        // find all wishlist started
        $auctions = $this->AuctionModel->getAuctionStart();
        // die(var_dump($auctions));
        // send to all users who set wishlist
        foreach ($auctions as $row) {
            $users = $this->AuctionWishlistModel->getWhereBuyer(
                $row['auction_id']
            );
            foreach ($users as $user) {
                // check if sent
                $existed = $this->NotificationModel->getWhere([
                    'notification.auction_id' => $row['auction_id'],
                    'notification.users_id' => $user['users_id'],
                    'notification.notification_type_id' => 2,
                ]);
                if (empty($existed)) {
                    $this->send_notification(
                        $user['users_id'],
                        'Bidding is about to start.',
                        'Auction ID' .
                            $row['auction_id'] .
                            ' in your wishlist is about to start in 30 minutes. Please stay tuned and place your bid.',
                        2,
                        $row['auction_id']
                    );
                }
            }

            $existed = $this->NotificationModel->getWhere([
                'notification.auction_id' => $row['auction_id'],
                'notification.users_id' => $row['seller_id'],
                'notification.notification_type_id' => 3,
            ]);

            if (empty($existed)) {
                $this->send_notification(
                    $row['seller_id'],
                    'Your vehicle bidding is about to start.',
                    'Your vehicle ID' .
                        $row['auction_id'] .
                        ' is about to start in 30 minutes. Seller may participate in the auction to view when someon places a bid.',
                    3,
                    $row['auction_id']
                );
            }
        }
        return true;
    }

    public function auction_history_detail()
    {
        // auction id, manufactured year, brand, model, engine_capacity, bid status, bid price, date, time
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $users_id = $this->validate_token($input['token']);
                if ($users_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }

                $auction = $this->AuctionModel->getAuctionBidResult(
                    $input['car_id']
                );

                return $this->respond(['data' => $auction]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    function date_getFullTimeDifference($start, $end)
    {
        $uts['start'] = strtotime($start);
        $uts['end'] = strtotime($end);
        if ($uts['start'] !== -1 && $uts['end'] !== -1) {
            if ($uts['end'] >= $uts['start']) {
                $diff = $uts['end'] - $uts['start'];
                if ($years = intval(floor($diff / 31104000))) {
                    $diff = $diff % 31104000;
                }
                if ($months = intval(floor($diff / 2592000))) {
                    $diff = $diff % 2592000;
                }
                if ($days = intval(floor($diff / 86400))) {
                    $diff = $diff % 86400;
                }
                if ($hours = intval(floor($diff / 3600))) {
                    $diff = $diff % 3600;
                }
                if ($minutes = intval(floor($diff / 60))) {
                    $diff = $diff % 60;
                }
                $diff = intval($diff);
                return [
                    'years' => $years,
                    'months' => $months,
                    'days' => $days,
                    'hours' => $hours,
                    'minutes' => $minutes,
                    'seconds' => $diff,
                ];
            } else {
                return false;
                // echo "Ending date/time is earlier than the start date/time";
            }
        } else {
            echo 'Invalid date/time data detected';
        }
    }

    public function check_if_auction_ended($auction_id)
    {
        $ended = false;
        $auction = $this->AuctionModel->getWhere([
            'auction_id' => $auction_id,
        ])[0];

        // default end time

        $auction_section_end_date_time = $this->AuctionSectionModel->getWhere([
            'auction_section_id' => $auction['auction_section_id'],
        ])[0];
        $end_datetime = date(
            'Y-m-d H:i:s',
            strtotime(
                $auction_section_end_date_time['date'] .
                    ' ' .
                    $auction_section_end_date_time['end_time']
            )
        );

        $time_now = date('Y-m-d H:i:s');
        $end_time = $auction['date'] . ' ' . $auction['end_time'];

        $time_diff = $this->date_getFullTimeDifference($time_now, $end_time);

        if ($time_diff != false) {
            if ($time_diff['seconds'] <= 30 && $time_diff['minutes'] <= 0) {
                // bidding end time
                $bid = $this->BidModel->get_last_bid($auction_id);

                if (!empty($bid)) {
                    $bid = $bid[0];

                    if (
                        date(
                            'Y-m-d H:i:s',
                            strtotime($bid['created_date']) + 30
                        ) > $end_time
                    ) {
                        // $ended = true;
                        // $end_time = date('H:i:s', strtotime($end_time) + 30);
                        $howmanysectoendtime = 30 - $time_diff['seconds'];
                        $end_time = date(
                            'H:i:s',
                            strtotime($end_time) + $howmanysectoendtime
                        );

                        $this->AuctionModel->updateWhere(
                            [
                                'auction_id' => $auction_id,
                            ],
                            ['end_time' => $end_time]
                        );
                    }
                }
                //  else {
                //     $ended = true;
                // }
            }
        }

        $auction = $this->AuctionModel->getWhere([
            'auction_id' => $auction_id,
        ])[0];
        $time_now = date('Y-m-d H:i:s');
        $end_time = $auction['date'] . ' ' . $auction['end_time'];

        $time_diff = $this->date_getFullTimeDifference($time_now, $end_time);

        if ($time_diff == false) {
            $ended = true;
        }

        return $ended;
    }

    public function decide_payment_method()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                // auction_id, payment_method_id

                $auction = $this->AuctionModel->updateWhere(
                    ['auction_id' => $input['auction_id']],
                    ['payment_method_id' => $input['payment_method_id']]
                );

                return $this->respond(['data' => $input]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_banner()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $banner = $this->BannerModel->getWhere([
                    'type_id' => $input['type_id'],
                ]);
                return $this->respond(['data' => $banner]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }
    public function get_own_max_auto_bid()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);
                $users_id = $this->validate_token($input['token']);
                if ($users_id == 0) {
                    return $this->fail(['error' => 'Invalid Token']);
                }
                $max_bid = $this->BidAutoModel->getWhereMax(
                    $input['auction_id'],
                    $users_id
                );

                return $this->respond(['data' => $max_bid]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_transfer_fee_rule()
    {
        if ($_POST) {
            try {
                $result = $this->TransferFeeModel->getAllRaw();
                $rule =
                    "For every ssuccessful bid of vehicles purchased with cash, the Buyer's Premium is RM450 + Handling Fee (shown above). With Loan, the Buyer's Premium is RM650 + Handling Fee (shown above).";

                return $this->respond(['data' => $result, 'rule' => $rule]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_models()
    {
        if ($_POST) {
            try {
                $where['model.deleted'] = 0;
                if ($_POST['brand_id'] != 0) {
                    $where['model.brand_id'] = $_POST['brand_id'];
                }
                $where = $this->convert_array_to_where($where);
                $result = $this->ModelModel->getWhereAuction($where);

                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_areas()
    {
        if ($_POST) {
            try {
                $where['area.deleted'] = 0;
                if ($_POST['state_id'] != 0) {
                    $where['area.state_id'] = $_POST['state_id'];
                }
                $where = $this->convert_array_to_where($where);
                $result = $this->AreaModel->getWhereAuction($where);

                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_qnas()
    {
        try {
            $where = [
                'qna_type.deleted' => 0,
            ];
            $types = $this->QnaTypeModel->getWhere($where);

            foreach ($types as $key => $row) {
                $where = [
                    'qna.deleted' => 0,
                    'qna.qna_type_id' => $row['qna_type_id'],
                ];
                $qna = $this->QnaModel->getWhere($where);
                $types[$key]['qna'] = $qna;
            }

            return $this->respond(['data' => $types]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
        }
    }

    public function get_transmissions()
    {
        if ($_POST) {
            try {
                $result = $this->TransmissionModel->getAll();

                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_years()
    {
        // if ($_POST) {
        try {
            $start = 1990;
            $end = date('Y');

            $result = [];
            for ($i = $start; $i <= $end; $i++) {
                array_push($result, $i);
            }

            $result = array_reverse($result);

            return $this->respond(['data' => $result]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
        }
        // }
    }

    public function get_mileages()
    {
        if ($_POST) {
            try {
                $gap = 10000;
                $start = 0;
                $end = 300000;

                $result = [];
                while ($start <= $end) {
                    array_push($result, $start);
                    $start = $start + $gap;
                }
                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_prices()
    {
        if ($_POST) {
            try {
                $gap = 5000;
                $start = 5000;
                $end = 100000;

                $result = [];
                while ($start <= $end) {
                    array_push($result, $start);
                    $start = $start + $gap;
                }

                return $this->respond(['data' => $result]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function set_status_if_auction_started()
    {
        // set auction_section_id = 2
        $auctions = $this->AuctionModel->getAuctionPending();
        // die(var_dump($auctions));
        foreach ($auctions as $row) {
            $this->AuctionModel->updateWhere(
                ['auction_id' => $row['auction_id']],
                ['auction_status_id' => 2]
            );
        }
        return true;
    }

    public function update_thumbnail()
    {
        try {
            $input = $this->getRequestInput($this->request);
            $users_id = $this->validate_token($input['token']);

            if ($users_id == 0) {
                return $this->fail(['error' => 'Invalid Token']);
            }

            $where = [
                'users.users_id' => $users_id,
            ];
            $data = [
                'thumbnail' => $input['thumbnail'],
            ];
            $this->UsersModel->updateWhere($where, $data);

            return $this->respond(['data' => $input]);
        } catch (Exception $exception) {
            return $this->fail(['error' => $exception->getMessage()]);
        }
    }

    public function delete_notification()
    {
        if ($_POST) {
            try {
                $this->NotificationModel->softDelete($_POST['notification_id']);
                return $this->respond(['data' => $_POST['notification_id']]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function verify_send_otp()
    {
        if ($_POST) {
            try {
                $input = $this->getRequestInput($this->request);

                $contact = preg_replace('/[^0-9.]+/', '', $input['contact']);
                $contact =
                    substr($contact, 0, 1) == 6 ? $contact : '6' . $contact;
                $api_key = 'f96ec75039eb17418c58f01964125bcd';
                $secret = 'b36c2eb88326b597d80d33a2f3b32d50';
                $url = 'https://api.smsglobal.com/http-api.php';
                $user = 'yewyang@cysoft.co';
                $password = 'Cysoft_12345!';
                $user = $this->UsersModel->getWhere([
                    'username' => $contact,
                ]);

                if (empty($user)) {
                    return $this->fail(['error' => 'Contact Not found']);
                }
                $user = $user[0];
                $this->UsersModel->updateWhere(
                    [
                        'username' => $contact,
                    ],
                    ['is_password_verified' => 0]
                );
                //make is password verified into 0

                if (
                    date('Y-m-d H:i:s') <
                    date('Y-m-d H:i:s', strtotime($user['otp_timestamp']))
                ) {
                    return $this->fail([
                        'error' => 'Please try again after 3 minutes.',
                    ]);
                }

                $from = 'carlink';
                $to = $user['username'];

                $otp = substr(
                    str_shuffle(
                        str_repeat($x = '0123456789', ceil(6 / strlen($x)))
                    ),
                    1,
                    4
                );
                $text =
                    'Dear Gplan Customer, your OTP for forgot password is ' .
                    $otp .
                    '. Use this OTP to reset your password.';

                $this->UsersModel->updateWhere(
                    ['users_id' => $user['users_id']],
                    [
                        'otp' => $otp,
                        'otp_timestamp' => date(
                            'Y-m-d H:i:s',
                            strtotime('+3 minutes')
                        ),
                    ]
                );

                \SMSGlobal\Credentials::set($api_key, $secret);
                $sms = new \SMSGlobal\Resource\Sms();

                $response = $sms->sendToOne($to, $text);
                return $this->respond(['data' => $response]);
            } catch (Exception $exception) {
                return $this->fail(['error' => $exception->getMessage()]);
            }
        }
    }

    public function get_car_image()
    {
        if ($_POST) {
            $where = [
                'car_image.car_id' => $_POST['car_id'],
                'car_image.type_id' => $_POST['type_id'],
            ];
            $car_image = $this->CarImageModel->getWhere($where);
            return $this->respond([
                'data' => $car_image,
            ]);
        }
    }

    public function reset_password()
    {
        if ($_POST) {
            $_POST['contact'] = $this->format_contact($_POST['contact']);
            $where = [
                'users.username' => $_POST['contact'],
            ];

            $user = $this->UsersModel->getWhere($where);

            if (!empty($user)) {
                $user = $user[0];
                if ($user['is_password_verified'] == 0) {
                    return $this->fail([
                        'error' => 'Please verify your otp first',
                    ]);
                }

                $hash = $this->hash($_POST['password']);
                $data = [
                    'password' => $hash['password'],

                    'salt' => $hash['salt'],
                ];
                $users_id = $this->UsersModel->updateWhere($where, $data);
                // return redirect()->to($_SERVER['HTTP_REFERER']);
                //send reset password email to user
                return $this->respond([
                    'data' => 'Password successfully resetted',
                ]);
            }
        }
    }
}

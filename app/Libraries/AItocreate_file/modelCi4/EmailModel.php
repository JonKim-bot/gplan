<?php namespace App\Models;

use App\Core\BaseModel;
use App\Models\UsesrModel;

class EmailModel extends BaseModel
{

    public function __construct(){
        parent::__construct();


        $this->UsesrModel = new UsesrModel();
        $this->pageData = array();

    }
    function send_email_reset($user_id){
        $email = \Config\Services::email();
        // $orders_id = 25;
     
        $where = [
            'user.user_id' => $user_id
        ];

        $user = $this->UserModel->getWhere($where)[0];
        // dd($user);
        $this->pageData['user'] = $user;


        $view = view('admin/email/email_reset', $this->pageData);
        $email->setFrom('noreply.piegenemenu@gmail.com', 'Lcelebs Orders');
        $email->setTo($user['email']);

        $email->setSubject('Lcelebs Reset email');
        $email->setMessage($view);


        if ($email->send()) {
            // echo "sent";
            return true;

        } else {


            $message = $email->printDebugger();
            die($message);
        }
    }
}
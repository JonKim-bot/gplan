<?php namespace App\Models;

use App\Core\BaseModel;
use App\Models\UsersModel;

class EmailModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->UsersModel = new UsersModel();
        $this->pageData = [];
    }
    function send_email_reset($users_id)
    {
        $email = \Config\Services::email();
        // $orders_id = 25;

        $where = [
            'users.users_id' => $users_id,
        ];

        $users = $this->UsersModel->getWhere($where)[0];
        // dd($users);
        $this->pageData['user'] = $users;

        $view = view('admin/email/email_reset', $this->pageData);
        $email->setFrom('noreply@idomoos.com', 'Gplan');
        $email->setTo($users['email']);

        $email->setSubject('Reset email');
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

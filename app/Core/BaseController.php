<?php





namespace App\Core;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;
use App\Models\AdminModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use App\Models\WalletTopupModel;
use App\Models\WalletWithdrawModel;

class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'infector', 'session'];

    /**
     * Constructor.
     */
    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

        $session = session();

        $uri = service('uri');


        
        $this->pageData = [];

        $this->AdminModel = new AdminModel();
        
        $this->UsersModel = new UsersModel();
        
        $this->WalletTopupModel = new WalletTopupModel();
        $this->WalletWithdrawModel = new WalletWithdrawModel();

        $this->pageData['undone_withdraw'] = $this->WalletWithdrawModel->getCountOfUndone();
        $this->pageData['undone_topup'] = $this->WalletTopupModel->getCountOfUndone();

        $this->pageData['undone_user'] = $this->UsersModel->getCountUndone();


        // if($_POST) {
        //     $data = array(
        //         'params' => json_encode($_POST),
        //         'action' => $_SERVER['REQUEST_URI'],
        //         'userdata' => json_encode($this->session->userdata()),
        //         'created_by' => $this->session->userdata('login_id'),
        //     );
        //     $this->Panel_activity_model->insert($data);
        // }
        // if($_FILES) {
        //     $data = array(
        //         'params' => json_encode($_FILES),
        //         'action' => $_SERVER['REQUEST_URI'],
        //         'userdata' => json_encode($this->session->userdata()),
        //         'created_by' => $this->session->userdata('login_id'),
        //     );
        //     $this->Panel_activity_model->insert($data);
        // }

    }


    public function get_modified_by($admin_id) {
        $where  = [
            'admin.admin_id' => $admin_id
        ];
        // dd($where);
        $admin = $this->AdminModel->getWhere($where);
        if(!empty($admin)){

            return $admin[0]['username'];
        }else{
            return '';
        }
    }
    public function get_modal($form,$form_arr,$url,$modal_id,$key,$id){
        $this->pageData['key'] = $key;
        $this->pageData['id'] = $id;
        $this->pageData['form'] = $form;
        $this->pageData['form_arr'] = $form_arr;
        $this->pageData['url'] = $url;
        
        $this->pageData['modal_id'] = $modal_id;
        return view('admin/modal/car_model',$this->pageData);
    }

    public function format_contact($contact){
        if(!ctype_digit($contact)){
            $error = true;
            $message = "Only digit allowed in contact";
        }

        $contact= preg_replace('/[^0-9]/', '', $contact);
        if(substr($_POST['contact'], 0, 1) == 0){
            $contact= '6' . $contact;
            // $contact= $contact;
        }

        if(strlen($contact) < 10){
            $error = true;
            $message = "Invalid Phone Number.";
        }
        return $contact;
    }
    public function validateRequest($input, array $rules, array $messages = [])
    {
        $this->validator = Services::Validation()->setRules($rules);
        // If you replace the $rules array with the name of the group
        if (is_string($rules)) {
            $validation = config('Validation');


            // If the rule wasn't found in the \Config\Validation, we
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }

            // If no error message is defined, use the error message in the Config\Validation file
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }

            $rules = $validation->$rules;
        }
        return $this->validator->setRules($rules, $messages)->run($input);
    }

    public function exports_to_csv($data,$file_name){
        //auto generate csv for files
        $header = array_keys($data[0]);
        $path = './public/csv/'.$file_name.'.csv';
        $handle = fopen($path, 'w');
        fputcsv($handle, $header);

        foreach ($data as $data_array) {

            fputcsv($handle, $data_array);
        }
        $path = '/public/csv/'.$file_name.'.csv';
        fclose($handle);
        return base_url() . $path;
        exit;
    }
    
    
    public function debug($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }

    public function getResponse(
        array $responseBody,
        int $code = ResponseInterface::HTTP_OK
    ) {
        return $this->response->setStatusCode($code)->setJSON($responseBody);
    }
    public function getRequestInput(IncomingRequest $request)
    {
        $input = $request->getPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }   
        
        return $input;
    }

    public function unset_array($filter, $orgininal)
    {
        foreach ($filter as $key => $row) {
            foreach ($orgininal as $dual_key => $ori) {
                if (!empty($orgininal[$dual_key][$row])) {
                    unset($orgininal[$dual_key][$row]);
                }
            }
        }
        return $orgininal;
    }

    public function generate_detail($field, $data, $image_field = '')
    {
        $html = '';
        foreach ($field as $row) {
            $html .= '<tr>';
            $temp_label_name = ucwords(str_replace('_', ' ', $row));
            $html .= '<td><b>' . $temp_label_name . '</b></td>';
            if ($row == $image_field) {
                $html .= '<td><div class="col-lg-12 col-xl-12">';
                $html .=
                    '<img src="' .
                    
                    base_url() .
                    $data[$image_field] .
                    '" width="200" class="img-fluid d-block m-auto" alt="">';
                $html .= '</div></td>';
            } else {
                $html .= '<td>' . $data[$row] . '</td>';
            }
            $html .= '</tr>';
        }
        return $html;
    }
    public function generate_table(
        $field,
        $data,
        $table,
        $image_field = '',
        $don_copy = 0,
        $show = 'detail'
    ) {
        $html = '';
        $html .= '<thead>';
        $html .= '<tr role="row">';
        $html .= '<th>No.</th>';
        foreach ($field as $row) {
            $temp_label_name = ucwords(str_replace('_', ' ', $row));

            $html .= '<th>' . $temp_label_name . '</th>';
        }
        $html .= '<th></th>';
        if ($don_copy == 0) {
            $html .= '<th></th>';
        }

        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $i = 1;
        $controller_name = str_replace(" ",'',ucwords(str_replace("_",' ',$table)));

        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $i . '</td>';
            foreach ($field as $row_f) {
                if ($row_f == $image_field) {

                    $html .= '<td>';
                    $html .=
                        '<img src="' .
                        base_url() .
                        $row[$image_field] .
                        '" width="300" class="img-fluid d-block m-auto" alt="">';
                    $html .= '</td>';
                } else {
                    $html .=
                        '<td>
                    <a target="_blank" href="' .
                        base_url() .
                        '/' .
                        $controller_name .
                        '/'.$show.'/' .
                        $row['' . $table . '_id'] .
                        '">' .
                        $row[$row_f] .
                        '</a></td>';
                }
            }

            $html .=
                '<td><a href="' .
                base_url() .
                '/' .
                $controller_name .
                '/delete/' .
                $row['' . $table . '_id' . ''] .
                '" class="btn btn-danger delete-button" ><i class="fa fa-trash"></i> Delete</a></td>';
            if ($don_copy == 0) {
                $html .=
                    '<td><a href="' .
                    base_url() .
                    '/' .
                    $controller_name .
                    '/copy/' .
                    $row['' . $table . '_id' . ''] .
                    '" class="btn btn-success " ><i class="fa fa-copy"></i> Copy</a></td>';
            }

            $html .= '</tr>';
            

            $i++;
        }
        $html .= '</tbody>';
        return $html;
    }

    public function get_insert_data($data, $filter = [])
    {
        $data['modified_by'] = session()->get('login_id');

        $data['created_by'] = session()->get('login_id');
        $data['created_date'] = date('Y-m-d H:i:s');
        if (!empty($filter)) {
            $data = $this->unset_array_filter($filter, $data);

            //filter unwanted fiield
        }
        return $data;
    }

    public function set_customer_session($customer_id)
    {
        $where = [
            'customer_id' => $customer_id,
        ];
        $customer = $this->CustomerModel->getWhere($where);
        $login_data = $customer[0];
        $login_id = $customer[0]['customer_id'];
        $this->session->set('customer_data', $login_data);
        $this->session->set('customer_id', $login_id);
    }

    public function validate_contact($contact)
    {
        $input['contact'] = $contact;
        $input['contact'] = str_replace(' ', '', $input['contact']);

        $input['contact'] = str_replace('-', '', $input['contact']);
        $input['contact'] = str_replace('+', '', $input['contact']);

        if (!$this->startsWith($input['contact'], '6')) {
            $input['contact'] = '6' . $input['contact'];
        }
        return $input['contact'];
    }

    function startsWith($string, $startString)
    {
        $len = strlen($startString);

        return substr($string, 0, $len) === $startString;
    }

    public function unset_array_filter($filter, $orgininal)
    {
        foreach ($filter as $key => $row) {
            foreach ($orgininal as $dual_key => $ori) {
                unset($orgininal[$row]);
            }
        }
        return $orgininal;
    }
    public function get_update_data($data, $filter = [])
    {
        $data['modified_by'] = session()->get('login_id');
        $data['modified_date'] = date('Y-m-d H:i:s');
        if (!empty($filter)) {
            $data = $this->unset_array_filter($filter, $data);
            //filter unwanted fiield
        }
        return $data;
    }


    public function upload_image($name)
    {
        if ($_FILES[$name] and !empty($_FILES[$name]['name'])) {
            $file = $this->request->getFile($name);
            $new_name = $file->getRandomName();
            $$name = $file->move('./public/img/' . $name . '/', $new_name);
            if ($name) {
                $name = '/public/img/' . $name . '/' . $new_name;
                return $name;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    function upload_image_base($image_name)
    {
        if (!empty($_FILES[$image_name]['name'])) {
            $file = $this->request->getFile($image_name);
            $new_name = $file->getName();
            $banner = $file->move('./public/images/', $new_name);

            if ($banner) {
                $banner = '/public/images/' . $new_name;
                // $data[$image_name] = $banner;
                return $banner;
            } else {
                return '';
            }
        } else {
            return '';
        }

    }
    function upload_image_with_data($data, $image_name)
    {
        $banner = $this->upload_image_base($image_name);
        if ($banner != '') {
            $data[$image_name] = $banner;
        }
        return $data;
    }
    function upload_multiple_image($image_name)
    {
        if (
            !empty($_FILES[$image_name]['name'][0]) &&
            $_FILES[$image_name]['name'][0] != ''
        ) {
            $getUpload = $this->request->getFileMultiple('cover_image');
            $image = [];
            foreach ($getUpload as $files) {
                $thumbnail = $files->getName();
                $banner = $files->move('./public/images/', $thumbnail);
                $banner = '/public/images/' . $thumbnail;
                $image[] = $banner;
            }
            return $image;
        } else {
            return '';
        }
    }
    public function hash($password)
    {
        $salt = rand(111111, 999999);
        $password = hash('sha512', $salt . $password);

        $hash = [
            'salt' => $salt,
            'password' => $password,
        ];

        return $hash;
    }

    public function convert_array_to_data($data)
    {
        array_walk($data, function (&$value, $key) {
            $value = "{$key} = '{$value}'";
        });
        $data = implode(', ', array_values($data));

        return $data;
    }


    public function convert_array_to_where($data)
    {
        array_walk($data, function (&$value, $key) {
            $value = "{$key} = '{$value}'";
        });
        $data = implode('AND ', array_values($data));

        return $data;
    }

    public function checkExists($username, $exclude_id = '')
    {
        $where = [
            'username' => $username,
        ];

        if ($exclude_id == '') {
            $admin = $this->AdminModel->getWhere($where);
            $user = $this->UsersModel->getWhere($where);

            if (empty($admin) and empty($user)) {
                return false;
            } else {
                return true;

            }
        } elseif ($exclude_id != '') {
            $admin = $this->AdminModel->getWhereAndPrimaryIsNot(
                $where,
                $exclude_id
            );
            $user = $this->UsersModel->getWhereAndPrimaryIsNot(
                $where,
                $exclude_id
            );

            // $this->debug($user);

            if (empty($admin) and empty($user)) {
                return false;
            } else {
                return true;
            }
        }
    }


    public function checkExistsEmail($email)
    {
        $where = [
            'users.email' => $email,
        ];

        $user = $this->UsersModel->getWhere($where);

        if (empty($user)) {
            return false;
        } else {
            return true;

        }

    }


    function show_404_if_empty($data)
    {
        if (empty($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    public function validateFile($file)
    {
        if ($file > 1000000) {
            return true;
        } else {
            return false;
        }
    }

    public function generateRandomString($length = 10)
    {
        $characters =
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function show404()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function getWhereRaw($where){

        $this->builder = $this->db->table($this->tableName);
        $this->builder->select($this->tableName . '.*');
        $this->builder->where($where);
        $this->builder->where($this->tableName . '.deleted',0);
        $query = $this->builder->get();
        return $query->getResultArray();
    }
}

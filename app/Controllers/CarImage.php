<?php


namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CarImageModel;

class CarImage extends BaseController
{
    public function __construct()
    {
        $this->CarImageModel = new CarImageModel();
        if (
            session()->get('login_data') == null &&
            uri_string() != 'access/login'
        ) {
            //  redirect()->to(base_url('access/login/'));
            echo "<script>location.href='" .
                base_url() .
                "/access/login';</script>";
        }
    }

    public function index()
    {
        $car_image = $this->CarImageModel->getAll();
        // dd($car_image);
        $field = $this->CarImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $car_image,
            'car_image',
            'banner'
        );
        $this->pageData['car_image'] = $car_image;
        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/all');
        echo view('admin/footer');
    }

    public function add()
    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);
                // $data['is_thumbnail'] = 1;
                // $data = $this->upload_image_with_data($data, 'image');
                // dd($data);
                if (!empty($_FILES['image']['name'][0])) {

                    $getUpload = $this->request->getFileMultiple('image');
                    foreach ($getUpload as $key=> $files){
                        $image = $files->getRandomName();
                        $files->move('./public/images/', $image);
                        $imagePath = '/public/images/' . $image;
                        $dataImage = [
                            'car_id' => $_POST['car_id'],
                            'image' => $imagePath,
                            'type_id' => $_POST['type_id'],

                        ];
                        $data['image'] = $imagePath;
                        $this->CarImageModel->insertNew($dataImage);
                        $this->watermark_image($_SERVER['DOCUMENT_ROOT'] . '/carlink_backend/' . $data['image'] ,
                        $_SERVER['DOCUMENT_ROOT'] . '/carlink_backend/' . "/assets/img/carlink_logo.png",
                        $_SERVER['DOCUMENT_ROOT'] . '/carlink_backend/' . $data['image']);
                    }
                }

                // $this->watermark_image($_SERVER['DOCUMENT_ROOT'] . '/carlink_backend/' . $data['image'] ,$_SERVER['DOCUMENT_ROOT'] . '/carlink_backend/' . "/assets/img/carlink_logo.png",$_SERVER['DOCUMENT_ROOT'] . '/carlink_backend/' . $data['image']);
                // $this->CarImageModel->insertNew($data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }


        // $this->pageData[
        //     'final_form'
        // ] = $this->CarImageModel->get_final_form_add([
        //     'created_by',
        //     'modified_by',
        //     'deleted',
        //     'modified_date',
        //     'created_date',
        // ]);
        $this->pageData['form'] = $this->CarImageModel->generate_input();
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/add');
        echo view('admin/footer');

    }

    function watermark_image($target, $wtrmrk_file, $newcopy) {
        $watermark = imagecreatefrompng($wtrmrk_file);

        imagealphablending($watermark, false);
        imagesavealpha($watermark, true);
        $ext = pathinfo($target, PATHINFO_EXTENSION);
        // dd($ext);
        if(strtolower($ext) == "png"){
            $img = imagecreatefrompng($target);
        }else if(strtolower($ext) == "jpeg" || strtolower($ext) == 'jpg'){
            
            $img = imagecreatefromjpeg($target);

        }else{
            return $target;
            // $img = imagecreatefromjpeg($target);
        }
        $img_w = imagesx($img);
        $img_h = imagesy($img);
        $wtrmrk_w = imagesx($watermark);
        $wtrmrk_h = imagesy($watermark);
        $dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
        $dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
        imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
        //new copy == file location
        imagepng($img, $newcopy,9);
        imagedestroy($img);
        imagedestroy($watermark);
        return $newcopy;
    }
    public function copy($car_image_id)
    {
        $car_image = $this->CarImageModel->copy($car_image_id);
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function detail($car_image_id)
    {
        $where = [
            'car_image.car_image_id' => $car_image_id,
        ];
        $car_image = $this->CarImageModel->getWhere($where)[0];
        $this->pageData['car_image'] = $car_image;

        $field = $this->CarImageModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
        ]);
        $this->pageData['detail'] = $this->generate_detail(

            $field,
            $car_image,
            'banner'
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/detail');
        echo view('admin/footer');
    }

    public function edit($car_image_id)
    {

        $where = [
            'car_image.car_image_id' => $car_image_id,
        ];
        $this->pageData['car_image'] = $this->CarImageModel->getWhere(
            $where
        )[0];

        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'image');

                $this->CarImageModel->updateWhere($where, $data);

                return redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        $this->pageData['form'] = $this->CarImageModel->generate_edit_input($car_image_id);
        // $this->pageData[
        //     'final_form'
        // ] = $this->CarImageModel->get_final_form_edit($car_image_id, [
        //     'created_by',
        //     'modified_by',
        //     'deleted',
        //     'modified_date',

        //     'created_date',
        //     'car_id',
        // ]);


        echo view('admin/header', $this->pageData);
        echo view('admin/car_image/edit');
        echo view('admin/footer');
    }

    public function set_thumbnail($car_image_id)
    {

        $where = [
            'car_image.car_image_id' => $car_image_id,
        ];
        $car_image= $this->CarImageModel->getWhere(
            $where
        )[0];
        if($car_image['is_thumbnail'] == 1) {
            $isthumbnail = 0;
        }else{
            $isthumbnail = 1;
        }

        $this->CarImageModel->updateWhere($where,['is_thumbnail' => $isthumbnail]);
        return redirect()->to($_SERVER['HTTP_REFERER']);
    
    }

    public function delete($car_image_id)
    {
        $this->CarImageModel->softDelete($car_image_id);
        // dd('asd');
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
}

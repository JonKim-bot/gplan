<?php



namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AuctionSectionModel;

use App\Models\AuctionModel;

class AuctionSection extends BaseController
{
    public function __construct()
    {
        $this->AuctionModel = new AuctionModel();

        $this->AuctionSectionModel = new AuctionSectionModel();
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
        $auction_section = $this->AuctionSectionModel->getAll();
        // dd($auction_section);
        $field = $this->AuctionSectionModel->get_field([
            'created_by',
            'modified_by',
            'deleted',
            'name',
        ]);
        $this->pageData['table'] = $this->generate_table(
            $field,
            $auction_section,
            'auction_section',
            'banner'

        );
        $this->pageData['auction_section'] = $auction_section;
        echo view('admin/header', $this->pageData);
        echo view('admin/auction_section/all');
        echo view('admin/footer');
    }

    public function add()

    {
        if ($_POST) {
            $error = false;

            if (!$error) {
                $data = $this->get_insert_data($_POST);

                $data = $this->upload_image_with_data($data, 'banner');
                // dd($data);
                
                $auction_section_id = $this->AuctionSectionModel->insertNew($data);
                $this->sync_date($auction_section_id);

                
                return redirect()->to(base_url('AuctionSection', 'refresh'));
            }
        }

        $this->pageData['form'] = $this->AuctionSectionModel->generate_input();
        // die(var_dump($this->pageData['form']));
        echo view('admin/header', $this->pageData);
        echo view('admin/auction_section/add');
        echo view('admin/footer');
    }

    public function copy($auction_section_id)

    {
        $auction_section = $this->AuctionSectionModel->copy(
            $auction_section_id
        );
        return redirect()->to(base_url('AuctionSection', 'refresh'));
    }

    public function detail($auction_section_id)
    {
        $where = [
            'auction_section_id' => $auction_section_id,
        ];
        $auction_section = $this->AuctionSectionModel->getWhere($where)[0];
        $this->pageData['auction_section'] = $auction_section;


        $field = $this->AuctionSectionModel->get_field([

            'created_by',
            'modified_by',
            'name',
            'deleted',
        ]);

        $this->pageData['detail'] = $this->generate_detail(
            $field,
            $auction_section,
            'banner'
        );


        $this->pageData['auction'] = $this->AuctionModel->getWhere([

            'auction.auction_section_id !=' => $auction_section_id,
            'auction.auction_status_id' => 1,
        ]);

        $this->pageData['auction_to_loop'] = $this->AuctionModel->getWhere([
            'auction.auction_section_id' => $auction_section_id,
        ]);


        $this->pageData['modified_by'] = $this->get_modified_by($auction_section['modified_by']);


        // dd($this->pageData['auction_to_loop']);

        echo view('admin/header', $this->pageData);
        echo view('admin/auction_section/detail');
        echo view('admin/footer');
    }

    public function sync_date($auction_section_id){
        $where = [
            'auction.auction_section_id' => $auction_section_id
        ];
        $auction_section = $this->AuctionSectionModel->getWhere([
            'auction_section_id' => $auction_section_id,
        ])[0];
        $data['date'] = $auction_section['date'];
        $data['start_time'] = $auction_section['start_time'];
        $data['end_time'] = $auction_section['end_time'];
        $this->AuctionModel->updateWhere($where, $data);
        

    }


    public function edit($auction_section_id)
    {

        $where = [
            'auction_section_id' => $auction_section_id,
        ];
        $this->pageData[
            'auction_section'
        ] = $this->AuctionSectionModel->getWhere($where)[0];

        if ($_POST) {
            $error = false;


            if (!$error) {
                $data = $this->get_update_data($_POST);
                $data = $this->upload_image_with_data($data, 'banner');
                $this->AuctionSectionModel->updateWhere($where, $data);
                $this->sync_date($auction_section_id);

                return redirect()->to(
                    base_url(
                        'AuctionSection/detail/' . $auction_section_id,
                        'refresh'
                    )
                );
            }
        }

        $this->pageData[
            'form'
        ] = $this->AuctionSectionModel->generate_edit_input(
            $auction_section_id
        );
        $this->pageData[
            'final_form'
        ] = $this->AuctionSectionModel->get_final_form_edit(
            $auction_section_id,
            [
                'created_by',
                'modified_by',
                'deleted',
                'modified_date',
                'created_date',
            ]
        );

        echo view('admin/header', $this->pageData);
        echo view('admin/auction_section/edit');
        echo view('admin/footer');
    }

    public function delete($auction_section_id)
    {
        $this->AuctionSectionModel->softDelete($auction_section_id);
        // dd('asd');
        return redirect()->to(base_url('AuctionSection', 'refresh'));
    }
}

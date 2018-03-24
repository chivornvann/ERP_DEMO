<?php defined('BASEPATH') OR exit('No direct script access allowed');

class sim_sale extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }

        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect('welcome');
        }

        $this->lang->load('sim', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->model('sim_model');
        $this->load->model('sim_sale_model');
        $this->upload_path = 'assets/uploads/';
        $this->digital_upload_path = 'files/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'csv|zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

    function index($warehouse_id = NULL)
    {
        $this->sma->checkPermissions();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : null;
        } else {
            $this->data['warehouses'] = null;
            $this->data['warehouse_id'] = $this->session->userdata('warehouse_id');
            $this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($this->session->userdata('warehouse_id')) : null;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('sales')));
        $meta = array('page_title' => lang('sales'), 'bc' => $bc);
        $this->page_construct('sim_sale/index', $meta, $this->data);
    }

public function add()
    {
        $this->form_validation->set_rules('customer', lang("customer"), 'required');
        $this->form_validation->set_rules('biller', lang("biller"), 'required');
        $this->form_validation->set_rules('sim_number[]', lang("sim_number"), 'required');
        if ($this->form_validation->run() == true) {
            $this->load->library('upload');
            $photo = null;
            $isHasImage = 0;
            if ($_FILES['identify_image']['size'] > 0) 
            {
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload("identify_image")) 
                {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("sim_sale/add");
                }

                $photo = $this->upload->file_name;
                $isHasImage = 1;

                $this->load->library('image_lib');
                
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                
                if (!$this->image_lib->resize()) 
                {
                    echo $this->image_lib->display_errors();
                }
            }

            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('so');
            $date = $this->sma->fld(trim($this->input->post('date')));
            $customer_id = $this->input->post('customer');
            $biller_id = $this->input->post('biller');
            $customer_details = $this->site->getCompanyByID($customer_id);
            $customer = $customer_details->company != '-' ? $customer_details->company : $customer_details->name;
            $biller_details = $this->site->getCompanyByID($biller_id);
            $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            $note = $this->sma->clear_tags($this->input->post('note'));
            $order_discount = $this->sma->clear_tags($this->input->post('order_discount'));
            $sim_id = $this->input->post('sim_number');
            $sale_info = array(
                'sale_date' => $date,
                'reference_no' => $reference,
                'sale_note' => $note,
                'customer_id' => $customer_id,
                'customer' => $customer,
                'biller_id' => $biller_id,
                'biller' => $biller
            );
            $sale_detail = array(
                'sim_id' => $sim_id,
                'discount' => $order_discount,
                'image' => $photo,
                'is_has_image' => $isHasImage,
            );
        }
        if($this->form_validation->run() == true && $this->sim_sale_model->addSaleSim($sale_info, $sale_detail)){
            $this->session->set_flashdata('message', lang("sim_sale_added"));
            redirect("sim_sale");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim_sale'), 'page' => lang('sim_sale')), array('link' => '#', 'page' => lang('add_sim_sale')));
            $meta = array('page_title' => lang('add_sim_sale'), 'bc' => $bc);
            
            $this->page_construct('sim_sale/add', $meta, $this->data);
        }
        
    }

    function suggestions()
    {
        $number = $this->input->get('term', true);
        if (strlen($number) < 1 || !$number) 
        {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }
        $result = $this->sim_sale_model->getSimNumber($number);
        if ($result) 
        {
            $data = [];
            foreach ($result as $value) {
               $data[] = array(
                "sim_type" => $value->sim_type,
                "sim_company" => $value->sim_company, 
                "label" => $value->sim_number,
                "price" => $value->price,
                "sim_id" => $value->id
               );
            }
            $this->sma->send_json($data);
        }else{
            $this->sma->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $number)));
        }
        
    }

    public function getSimSales()
    {
        $this->sma->checkPermissions('index');
        $detail_link = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $duplicate_link = anchor('sales/add?sale_id=$1', '<i class="fa fa-plus-circle"></i> ' . lang('duplicate_sale'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('sales/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('sales/email/$1', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $pdf_link = anchor('sales/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
        . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
        . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
        . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
            <li>' . $duplicate_link . '</li>
            <li>' . $payments_link . '</li>
            <li>' . $add_payment_link . '</li>
            <li>' . $add_delivery_link . '</li>
            <li>' . $edit_link . '</li>
            <li>' . $pdf_link . '</li>
            <li>' . $email_link . '</li>
            <li>' . $return_link . '</li>
            <li>' . $delete_link . '</li>
        </ul>
    </div></div>';

        $this->load->library('datatables');
        $this->datatables
                ->select("{$this->db->dbprefix('sim_sale_pos')}.id as id, DATE_FORMAT(sale_date, '%Y-%m-%d %T') as date, reference_no, customer, biller, sale_note, COUNT({$this->db->dbprefix('sim_sale_pos')}.id) as qty, SUM(price) as price")
                ->from('sim_sale_pos')
                ->join("sim_sale_pos_detail sd", 'sim_sale_pos.id=sd.sim_sale_id', 'left')
                ->join("sim s", 'sd.sim_id=s.id', 'left')
                ->group_by("{$this->db->dbprefix('sim_sale_pos')}.id");

        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }

    function search() {
        $this->sma->checkPermissions('stock_count');
        $this->form_validation->set_rules('biller', lang("biller"), 'required');
        $this->form_validation->set_rules('date', lang("date"), 'required');

        $this->data['result'] = '';
        if ($this->form_validation->run() == true) {
            $date = $this->input->post('date');
            $biller_id = $this->input->post('biller');
            $this->data['result'] = $this->sim_sale_model->search($date,$biller_id);

        } 

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('products'), 'page' => lang('products')), array('link' => '#', 'page' => lang('count_stock')));
            $meta = array('page_title' => lang('count_stock'), 'bc' => $bc);
            $this->page_construct('sim_sale/search', $meta, $this->data);
    }

}
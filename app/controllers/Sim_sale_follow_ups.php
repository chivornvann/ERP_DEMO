<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_follow_ups extends MY_Controller
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
        $this->lang->load('settings', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->model('Sim_sale_follow_ups_model');
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

    function index(){
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_sale_consignment')));
        $meta = array('page_title' => lang('sim_sale_consignment'), 'bc' => $bc);
        $this->page_construct('sim/sim_sale_follow_up', $meta, $this->data);
    }

    function getSaleFollowUp()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sim_sale_follow_up') . ".id as id, sim_sale_follow_up.follow_up_date, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, users.username, sim_sale_follow_up.total_price")
            ->from("sim_sale_follow_up")
            ->join('sale_follow_up_detail', 'sale_follow_up_detail.use_sim_sale_follow_up_id = sim_sale_follow_up.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_follow_up.use_branch_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_follow_up.sale_man_id')
            ->where('users.id', $this->session->userdata('user_id'))
            ->group_by('sale_follow_up_detail.use_sim_sale_follow_up_id')
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim_sale_follow_ups/viewSimByShop/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_sale_consignment") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_consignments/deleteSaleCognt/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }

     function viewSimByShop($id = NULL)
    {
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_sim_per_shop')));
        $meta = array('page_title' => lang('sim_group_per_shop'), 'bc' => $bc);
        $this->page_construct('sim/view_sim_by_shop', $meta, $this->data);
    }

    function getSimPerShop($id = null)
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sale_follow_up_detail') . ".id as id, sim.sim_number, sim.is_has_identify_card")
            ->from("sale_follow_up_detail")
            ->join('sim', 'sale_follow_up_detail.sim_id = sim.id')
            ->where('sale_follow_up_detail.use_sim_sale_follow_up_id', $id)
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim/view_sim_by_group/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_sale_consignment") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_consignments/deleteSimGroupFromConsignment/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }
}
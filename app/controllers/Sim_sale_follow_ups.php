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
        $this->load->model('Sim_sale_consignments_model');
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

    function index(){
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_sale_follow_up')));
        $meta = array('page_title' => lang('sim_sale_follow_up'), 'bc' => $bc);
        $this->page_construct('sim/sim_sale_follow_up', $meta, $this->data);
    }

    function getSaleFollowUp()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sim_sale_follow_up') . ".id as id, sim_sale_follow_up.follow_up_date, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, users.username,(select count(*) from sma_sale_follow_up_detail where use_sim_sale_follow_up_id = ".$this->db->dbprefix('sim_sale_follow_up').".id) as qty, (select sum(price) from sma_sim where id IN (select sim_id from sma_sale_follow_up_detail where use_sim_sale_follow_up_id = ".$this->db->dbprefix('sim_sale_follow_up').".id)) as total_price")
            ->from("sim_sale_follow_up")
            ->join('sale_follow_up_detail', 'sale_follow_up_detail.use_sim_sale_follow_up_id = sim_sale_follow_up.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_follow_up.use_branch_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_follow_up.sale_man_id')
            ->where('users.id', $this->session->userdata('user_id'))
            ->group_by('sale_follow_up_detail.use_sim_sale_follow_up_id')
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim_sale_follow_ups/viewSimByShop/$1') . "' class='tip' title='" . lang("view_sims") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_follow_up") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_follow_ups/deleteSaleFollowUp/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }

     function deleteSaleFollowUp($id = null){

        if ($this->Sim_sale_follow_ups_model->deleteSaleFollowUp($id)) {
            echo lang("Sale follow up was deleted.");
        }else{
            $this->session->set_flashdata('error', lang("Sale follow up cannot be deleted."));
            redirect($_SERVER["HTTP_REFERER"]);
        }
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
            ->add_column("Actions", "<div class=\"text-center\">"." <a href='#' class='tip po' title='<b>" . lang("delete_sim") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_follow_ups/deleteSim/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }

    function deleteSim($id){
        if ($this->Sim_sale_follow_ups_model->deleteSim($id)) {
            echo lang("Sim deleted.");
        }
    }

    function add_sale_follow_up()
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('follow_up_date', lang("Follow up date"), 'trim|required');
        $this->form_validation->set_rules('shop', lang("Shop"), 'trim|required');
        $this->form_validation->set_rules('branch', lang("Branch"), 'trim|required');
        $this->form_validation->set_rules('sims[]', lang("Sim"), 'trim|required');

        if ($this->form_validation->run() == true) {
            $followUpDate = strtr($this->input->post('follow_up_date'), '/', '-');
            $simIds = $this->input->post('sims[]');
            $data = array(
                'follow_up_date' =>  date('Y-m-d', strtotime($followUpDate)),
                'sale_man_id' => $this->session->userdata('user_id'),
                'use_branch_id' => $this->input->post('branch')
            );
        } elseif ($this->input->post('add_sale_follow_up')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim_sale_follow_ups/index");
        }

        if ($this->form_validation->run() == true && $this->Sim_sale_follow_ups_model->addSaleFollowUp($data,  $simIds)) {
            $this->session->set_flashdata('message', lang("Sale follow up added."));
            redirect("sim_sale_follow_ups/index");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['branches'] = $this->Sim_sale_consignments_model->getBranches();
            $this->data['shops'] = $this->Sim_sale_consignments_model->getShops();
            $this->data['locations'] = $this->Sim_sale_consignments_model->getLocations();
            $this->data['sims'] = $this->Sim_sale_follow_ups_model->getSims();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sale_follow_up', $this->data);
        }
    }

    function sale_follow_up_action()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $isSuccess = true;
                    foreach ($_POST['val'] as $id) {
                         $isSuccess = $isSuccess && $this->Sim_sale_follow_ups_model->deleteSaleFollowUp($id);
                    }
                    if($isSuccess){
                        $this->session->set_flashdata('message', lang("Sale follow up (s) has been deleted."));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }else{
                        $this->session->set_flashdata('error', lang("Sale follow up (s) cannot be deleted."));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('Sale follow up'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('Date follow up'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('Shop name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('Address'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('Sale man'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('Quantity'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('Total price'));

                    $row = 2;
                   
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->Sim_sale_follow_ups_model->getSaleFollowUp($id);
                        $sc = $sc[0];
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->follow_up_date);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->shop);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->locationName);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->username);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sc->qty);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sc->total_price);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'sale_consignment' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_record_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function addMoreSims($id){

        $this->load->helper('security');
        $this->form_validation->set_rules('sims[]', lang("Sim"), 'trim|required');

        if ($this->form_validation->run() == true) {
            $simIds = $this->input->post('sims[]');

        } elseif ($this->input->post('addMoreSims')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("Sim_sale_follow_ups/index");
        }

        if ($this->form_validation->run() == true) {
            if($this->Sim_sale_follow_ups_model->addMoreSim($id,  $simIds)){
                $this->session->set_flashdata('message', lang("Sim added."));
                redirect("Sim_sale_follow_ups/viewSimByShop/".$id);
            }else{
                $this->session->set_flashdata('error', lang("Sim group is already added."));
                redirect("Sim_sale_follow_ups/viewSimByShop/".$id);
            }
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['sims'] = $this->Sim_sale_follow_ups_model->getSims();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_to_sale_follow_up', $this->data);
        }
    }
}
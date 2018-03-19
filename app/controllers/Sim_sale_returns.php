<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_returns extends MY_Controller
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
        $this->load->model('Sim_sale_returns_model');
        $this->load->model('Sim_sale_consignments_model');
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

     function index(){
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_sale_return')));
        $meta = array('page_title' => lang('sim_sale_return'), 'bc' => $bc);
        $this->page_construct('sim/sim_sale_return', $meta, $this->data);
    }

    function getSaleReturns()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sim_sale_returns') . ".id as id, sim_sale_returns.date_return, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, users.username")
            ->from("sim_sale_returns")
            ->join('sim_sale_return_detail', 'sim_sale_return_detail.use_sim_sale_return_id = sim_sale_returns.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_returns.use_sim_branches_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_returns.use_sale_man_id')
            ->where('users.id', $this->session->userdata('user_id'))
            ->group_by('sim_sale_return_detail.use_sim_sale_return_id')
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim_sale_returns/viewGroupBySaleReturn/$1') . "' class='tip' title='" . lang("view group in sale return") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_sale_return") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_returns/deleteSaleReturn/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }

    function viewGroupBySaleReturn($id = NULL)
    {
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_group_per_sale_return')));
        $meta = array('page_title' => lang('sim_group_per_sale_return'), 'bc' => $bc);
        $this->page_construct('sim/view_group_in_sale_return', $meta, $this->data);
    }

    function getGroupPerReturnRecord($id = null)
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sim_groups') . ".id as id, sim_groups.name")
            ->from("sim_groups")
            ->join('sim_sale_return_detail', 'sim_sale_return_detail.use_sim_group_id = sim_groups.id')
            ->join('sim_sale_returns', 'sim_sale_return_detail.use_sim_sale_return_id = sim_sale_returns.id')
            ->where('sim_sale_return_detail.use_sim_sale_return_id', $id)
            ->group_by('sim_sale_return_detail.use_sim_group_id')
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim/view_sim_by_group/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_group") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_returns/deleteSimGroupFromSaleReturn/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }

    function deleteSaleReturn($id = null){

        if ($this->Sim_sale_returns_model->deleteSaleReturn($id)) {
            echo lang("Sale return was deleted.");
        }else{
            $this->session->set_flashdata('error', lang("Sale return cannot be deleted"));
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function add_sale_return()
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('returnDate', lang("Date"), 'trim|required');
        $this->form_validation->set_rules('shop', lang("Shop"), 'trim|required');
        $this->form_validation->set_rules('branch', lang("Branch"), 'trim|required');
        $this->form_validation->set_rules('sgroup', lang("Sim group"), 'trim|required');

        if ($this->form_validation->run() == true) {
            $returnDate = strtr($this->input->post('returnDate'), '/', '-');
            $data = array(
                'date_return' =>  date('Y-m-d', strtotime($returnDate)),
                'use_sim_branches_id' => $this->input->post('branch'),
                'use_sale_man_id' => $this->session->userdata('user_id'),
            );

        } elseif ($this->input->post('add_sale_return')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim_sale_returns/index");
        }

        $groupIds = [1,2];
        if ($this->form_validation->run() == true && $this->Sim_sale_returns_model->addSaleReturn($data, $groupIds)) {
            $this->session->set_flashdata('message', lang("Sale return added."));
            redirect("sim_sale_returns/index");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['branches'] = $this->Sim_sale_consignments_model->getBranches();
            $this->data['shops'] = $this->Sim_sale_consignments_model->getShops();
            $this->data['locations'] = $this->Sim_sale_consignments_model->getLocations();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sale_return', $this->data);
        }
    }

     function sale_return_action()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $isSuccess = true;
                    foreach ($_POST['val'] as $id) {
                         $isSuccess = $isSuccess && $this->Sim_sale_returns_model->deleteSaleReturn($id);
                    }
                    if($isSuccess){
                        $this->session->set_flashdata('message', lang("Sale return(s) has been deleted."));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }else{
                        $this->session->set_flashdata('error', lang("Sale return(s) cannot be deleted."));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('Sale return'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('Return date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('Shop name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('Address'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('Sale man'));

                    $row = 2;
                   
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->Sim_sale_returns_model->getSaleReturn($id);
                        $sc = $sc[0];
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->date_return);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->shop);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->locationName);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->username);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
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
    
    function addGroupToSaleReturn($saleReturnId){

        $this->load->helper('security');
        $this->form_validation->set_rules('group', lang("Group"), 'trim|required');

        if ($this->form_validation->run() == true) {
            $gId = $this->input->post('group');

        } elseif ($this->input->post('addGroupToSaleReturn')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim_sale_returns/index");
        }

        if ($this->form_validation->run() == true) {
            if($this->Sim_sale_returns_model->addGroupToSaleReturn($saleReturnId, $gId)){
                $this->session->set_flashdata('message', lang("Group added to sale return."));
            }else{
                $this->session->set_flashdata('error', lang("Sim group is already existed in this sale return."));
            }
            redirect("sim_sale_returns/viewGroupBySaleReturn/".$saleReturnId);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['groups'] = $this->Sim_sale_consignments_model->getGroups();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_group_to_sale_return', $this->data);
        }
    }

    function deleteSimGroupFromSaleReturn($gId = NULL)
    {
        if ($this->Sim_sale_returns_model->deleteSimGroupFromSaleReturn($gId)) {
            echo lang("Group deleted.");
        }else{
            $this->session->set_flashdata('error', lang("Group cannot be deleted."));
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }


}
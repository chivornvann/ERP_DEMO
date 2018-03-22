<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_sale_consignments extends MY_Controller
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
        $this->load->model('Sim_sale_consignments_model');
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
    	$this->page_construct('sim/sim_sale_consignment', $meta, $this->data);
    }

    function getSaleConsignments()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sim_sale_consignments') . ".id as id, sim_sale_consignments.date_consign, sim_shops.shop, CONCAT(".$this->db->dbprefix('sim_locations').".name, ' (', ".$this->db->dbprefix('sim_branches').".branch_name, ')') as locationName, sim_branches.facebook_name, users.username, sim_sale_consignments.reference_note")
            ->from("sim_sale_consignments")
            ->join('sale_consignment_detail', 'sale_consignment_detail.use_sale_consignment_id = sim_sale_consignments.id')
            ->join('sim_branches', 'sim_branches.id = sim_sale_consignments.use_sim_branches_id')
            ->join('sim_shops', 'sim_shops.id = sim_branches.use_shop_id')
            ->join('sim_locations', 'sim_locations.id = sim_branches.use_sim_location_id')
            ->join('users', 'users.id = sim_sale_consignments.use_sale_man_id')
            ->where('users.id', $this->session->userdata('user_id'))
            ->group_by('sale_consignment_detail.use_sale_consignment_id')
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim_sale_consignments/viewGroupByShop/$1') . "' class='tip' title='" . lang("view group in shop") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_sale_consignment") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_consignments/deleteSaleCognt/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }

    function deleteSaleCognt($id = null){

        if ($this->Sim_sale_consignments_model->deleteSaleCognt($id)) {
            echo lang("Sale consignment was deleted.");
        }else{
            $this->session->set_flashdata('error', lang("Cannot be deleted, some sims were sold."));
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    function add_sale_consignment()
    {

    	$this->load->helper('security');
        $this->form_validation->set_rules('conDate', lang("Date"), 'trim|required');
        $this->form_validation->set_rules('shop', lang("Shop"), 'trim|required');
        $this->form_validation->set_rules('branch', lang("Branch"), 'trim|required');
        $this->form_validation->set_rules('sgroup[]', lang("Sim group"), 'trim|required');
        $this->form_validation->set_rules('note', lang("Note"), 'trim|required');

        if ($this->form_validation->run() == true) {
            $consignDate = strtr($this->input->post('conDate'), '/', '-');
            $data = array(
            	'date_consign' =>  date('Y-m-d', strtotime($consignDate)),
            	'use_sim_branches_id' => $this->input->post('branch'),
            	'use_sale_man_id' => $this->session->userdata('user_id'),
            	'reference_note' => $this->input->post('note'),
            );
            $groupIds = $this->input->post('sgroup[]');
        } elseif ($this->input->post('add_sale_consignment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim_sale_consignments/index");
        }

        if ($this->form_validation->run() == true && $this->Sim_sale_consignments_model->addSaleConsignment($data, $groupIds)) {
            $this->session->set_flashdata('message', lang("Sale consignment added."));
            redirect("sim_sale_consignments/index");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['branches'] = $this->Sim_sale_consignments_model->getBranches();
            $this->data['shops'] = $this->Sim_sale_consignments_model->getShops();
            $this->data['locations'] = $this->Sim_sale_consignments_model->getLocations();
            $this->data['groups'] = $this->Sim_sale_consignments_model->getGroups();
            $this->data['modal_js'] = $this->site->modal_js();
        	$this->load->view($this->theme . 'sim/add_sale_consignment', $this->data);
        }
    }

    function addGroupToShop($saleCongtId){

        $this->load->helper('security');
        $this->form_validation->set_rules('group', lang("Group"), 'trim|required');

        if ($this->form_validation->run() == true) {
            $gId = $this->input->post('group');

        } elseif ($this->input->post('addGroupToShop')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim_sale_consignments/index");
        }

        if ($this->form_validation->run() == true) {
            if($this->Sim_sale_consignments_model->addGroupToShop($saleCongtId, $gId)){
                $this->session->set_flashdata('message', lang("Group added to shop."));
                redirect("sim_sale_consignments/viewGroupByShop/".$saleCongtId);
            }else{
                $this->session->set_flashdata('error', lang("Sim group is already existed in this shop."));
                redirect("sim_sale_consignments/viewGroupByShop/".$saleCongtId);
            }
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['groups'] = $this->Sim_sale_consignments_model->getGroups();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_group_to_shop', $this->data);
        }
    }

    public function groupsSuggestion()
    {
        $term = $this->input->get('term', true);
        $gId = $this->input->get('groupId', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $analyzed = $this->sma->analyze_term($term);
        $sr = $analyzed['term'];
        $rows = $this->Sim_sale_consignments_model->GetAutocomplete($sr);
        if ($rows) {
            $this->sma->send_json($rows);
        } else {
            $this->sma->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

    function deleteSimGroupFromConsignment($gId = NULL)
    {
        if ($this->Sim_sale_consignments_model->deleteSimGroupFromSlCongt($gId)) {
            echo lang("Group deleted.");
        }
    }

    function sale_con_action()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $isSuccess = true;
                    foreach ($_POST['val'] as $id) {
                         $isSuccess = $isSuccess && $this->Sim_sale_consignments_model->deleteSaleCognt($id);
                    }
                    if($isSuccess){
                        $this->session->set_flashdata('message', lang("Sale consignment (s) has been deleted."));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }else{
                        $this->session->set_flashdata('error', lang("Cannot be deleted, some sims were sold."));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('Sale consignment'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('Date consign'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('Shop name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('Address'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('Facebook'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('Sale man'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('Reference note'));

                    $row = 2;
                   
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->Sim_sale_consignments_model->getSaleConsignents($id);
                        $sc = $sc[0];
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->date_consign);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->shop);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->locationName);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->facebook_name);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sc->username);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sc->reference_note);
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
	
     function edit_group($id = NULL)
    {
        $this->form_validation->set_rules('sgroup', lang("sim_group"), 'trim|required|alpha_numeric_spaces');
        
        $simGroup = $this->Sim_sale_consignments_model->getGroupById($id);

        if ($this->form_validation->run() == true) 
        {
            $data = array('use_group_id' => $this->input->post('sgroup'));
        } elseif ($this->input->post('edit_sale_consignment')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim_sale_consignments/viewGroupByShop");
        }

        if ($this->form_validation->run() == true && $this->Sim_sale_consignments_model->updateGroupOnSaleConsign($id, $data)) 
        {
            $this->session->set_flashdata('message', lang("sim_group_updated"));
            redirect("sim_sale_consignments/");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['sim_gs'] = $this->Sim_sale_consignments_model->getSimInGroups();
            $this->data['sim_group'] = $simGroup;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sale_consignment', $this->data);
        }
    }

    function viewGroupByShop($id = NULL)
    {
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_group_per_shop')));
        $meta = array('page_title' => lang('sim_group_per_shop'), 'bc' => $bc);
        $this->page_construct('sim/view_group_by_shop', $meta, $this->data);
    }

    function getGroupPerShop($id = null)
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('sim_groups') . ".id as id, sim_groups.name")
            ->from("sim_groups")
            ->join('sale_consignment_detail', 'sale_consignment_detail.use_group_id = sim_groups.id')
            ->join('sim_sale_consignments', 'sale_consignment_detail.use_sale_consignment_id = sim_sale_consignments.id')
            ->where('sale_consignment_detail.use_sale_consignment_id', $id)
            ->group_by('sale_consignment_detail.use_group_id')
            ->add_column("Actions", "<div class=\"text-center\">"."<a href='" . site_url('sim/view_sim_by_group/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>"." <a href='#' class='tip po' title='<b>" . lang("delete_sale_consignment") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim_sale_consignments/deleteSimGroupFromConsignment/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        echo $this->datatables->generate();
    }
}
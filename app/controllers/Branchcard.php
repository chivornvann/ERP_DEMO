<?php defined('BASEPATH') or exit('No direct script access allowed');

class Branchcard extends MY_Controller
{

	public function __construct()
    {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if ($this->Customer) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->lang->load('card', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->model('branchcard_model');
    }

    public function index($warehouse_id = null)
    {
        $this->sma->checkPermissions();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('card_branch')));
        $meta = array('page_title' => lang('card_branch'), 'bc' => $bc);
        $this->page_construct('branchcard/index', $meta, $this->data);

    }

    public function getBranchCard()
    {
        $this->sma->checkPermissions('index');
        $edit_link = anchor('branchcard/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_branch_card'));
        $delete_link = "<a href='#' class='po' title='<b>" . $this->lang->line("delete_branch_card") . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('branchcard/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
        . lang('delete_branch_card') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
        . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
        . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $edit_link . '</li>
            <li>' . $delete_link . '</li>
        </ul>
    	</div></div>';
       

        $this->load->library('datatables');
        $this->datatables
            ->select("sma_card_branch.id,sma_card_branch.branch_name,sma_card_branch.phone,sma_card_branch.contact_name,
            	sma_card_branch.facebook_name, sma_card_branch.is_has_special_book,sma_card_branch.is_has_stamp_shop,sma_sim_shops.shop,sma_sim_locations.location ")
            ->from('sma_card_branch')
            ->join('sma_sim_shops','sma_sim_shops.id = sma_card_branch.use_card_shop_id')
            ->join('sma_sim_locations','sma_sim_locations.id = sma_card_branch.use_card_location_id');
        $this->datatables->add_column("Actions", $action, "sma_card_branch.id");
        echo $this->datatables->generate();
    }

    public function add($quote_id = null)
    {

        $this->sma->checkPermissions();
        $this->form_validation->set_rules('branch_name', $this->lang->line("branch_name"), 'required');
        $this->form_validation->set_rules('branch_card_phone', $this->lang->line("phone"), 'required');
        $this->form_validation->set_rules('contact_name', $this->lang->line("contact_name"), 'required');
        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            
            $data['branch_name'] = $this->input->post('branch_name');
            $data['phone'] = $this->input->post('branch_card_phone');
            $data['contact_name'] = $this->input->post('contact_name');
            $data['facebook_name'] = $this->input->post('facebook_name');
            $data['is_has_special_book'] = $this->input->post('has_special_book');
            $data['is_has_stamp_shop'] = $this->input->post('has_stamp_shop');
            $data['use_card_shop_id'] = $this->input->post('branch_card_shop');
            $data['use_card_location_id'] = $this->input->post('branch_card_location');

            $branch_card_id = $this->branchcard_model->add_branch_card($data);
            if($branch_card_id) {
                $this->session->set_flashdata('message', $this->lang->line("branch_card_add"));
                redirect('branchcard');
            }

        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['branch_card_shop'] = $this->branchcard_model->getBranchCardShop();
        $this->data['branch_card_location'] = $this->branchcard_model->getBranchCardLocation();
        $this->data['hasSpecialBook'] = array(
                array('id' => 0, 'name' => 'Yes'),
                array('id' => 1, 'name' => 'No'),
        );
        $this->data['hasStampShop'] = array(
                array('id' => 0, 'name' => 'Yes'),
                array('id' => 1, 'name' => 'No'),
        );
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('branchcard'), 'page' => lang('branch_card')), array('link' => '#', 'page' => lang('add_branch_card')));
        $meta = array('page_title' => lang('add_branch_card'), 'bc' => $bc);
        $this->page_construct('branchcard/add', $meta, $this->data);
    }

    public function edit($id = null) {

        $this->sma->checkPermissions();
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->sma->checkPermissions();
        $this->form_validation->set_rules('branch_name', $this->lang->line("branch_name"), 'required');
        $this->form_validation->set_rules('branch_card_phone', $this->lang->line("phone"), 'required');
        $this->form_validation->set_rules('contact_name', $this->lang->line("contact_name"), 'required');
        $this->session->unset_userdata('csrf_token');

        if ($this->form_validation->run() == true) {
            
            $data['branch_name'] = $this->input->post('branch_name');
            $data['phone'] = $this->input->post('branch_card_phone');
            $data['contact_name'] = $this->input->post('contact_name');
            $data['facebook_name'] = $this->input->post('facebook_name');
            $data['is_has_special_book'] = $this->input->post('has_special_book');
            $data['is_has_stamp_shop'] = $this->input->post('has_stamp_shop');
            $data['use_card_shop_id'] = $this->input->post('branch_card_shop');
            $data['use_card_location_id'] = $this->input->post('branch_card_location');
            $branch_card_id = $id;
            $branch_card_id = $this->branchcard_model->update_branch_card($data,$branch_card_id);
            if($branch_card_id) {
                $this->session->set_flashdata('message', $this->lang->line("branch_card_update"));
                redirect('branchcard');
            }
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['id'] = $id;
        $this->data['branch_card_infor'] = $this->branchcard_model->getBranchCardInfor($id);
        $this->data['branch_card_shop'] = $this->branchcard_model->getBranchCardShop();
        $this->data['branch_card_location'] = $this->branchcard_model->getBranchCardLocation();
        $this->data['hasSpecialBook'] = array(
                array('id' => 0, 'name' => 'Yes'),
                array('id' => 1, 'name' => 'No'),
        );
        $this->data['hasStampShop'] = array(
                array('id' => 0, 'name' => 'Yes'),
                array('id' => 1, 'name' => 'No'),
        );
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('branchcard'), 'page' => lang('branch_card')), array('link' => '#', 'page' => lang('edit_branch_card')));
        $meta = array('page_title' => lang('edit_branch_card'), 'bc' => $bc);
        $this->page_construct('branchcard/edit', $meta, $this->data);
    }

    public function delete($id = null)
    {
        $this->sma->checkPermissions(NULL, true);
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->branchcard_model->deleteBranchCard($id)) {
            if ($this->input->is_ajax_request()) {
                echo lang("branch_card_deleted");die();
            }
            $this->session->set_flashdata('message', lang('branch_card_deleted'));
            redirect('branchcard');
        }
    }

     public function branch_card_actions()
    {
        if (!$this->Owner && !$this->GP['bulk_actions']) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {

                    $this->sma->checkPermissions('delete');
                    foreach ($_POST['val'] as $id) {
                        $this->branchcard_model->deleteBranchCard($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line("branch_card_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'export_excel') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('card'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('branch_name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('phone'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('contact_name'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('facebook_name'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('has_special_book'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('has_stamp_shop'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('shop'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('location'));
                   

                    //dorl nis
                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $branchCard = $this->branchcard_model->getBranchCardInforById($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $branchCard[0]['branch_name']);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $branchCard[0]['phone']);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $branchCard[0]['contact_name']);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $branchCard[0]['facebook_name']);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->yesno($branchCard[0]['special_book'])) ;
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->yesno($branchCard[0]['stamp_shop']));
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $branchCard[0]['shop']);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $branchCard[0]['location']);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'branch_card' . date('Y_m_d_H_i_s');
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
                $this->session->set_flashdata('error', $this->lang->line("no_card_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

}
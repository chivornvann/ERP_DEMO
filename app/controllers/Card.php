<?php defined('BASEPATH') or exit('No direct script access allowed');

class Card extends MY_Controller
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
        $this->load->model('card_model');
    }


    public function index($warehouse_id = null)
    {
        $this->sma->checkPermissions();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('card')));
        $meta = array('page_title' => lang('card'), 'bc' => $bc);
        $this->page_construct('card/index', $meta, $this->data);

    }

     public function getCard()
    {
        $this->sma->checkPermissions('index');
        $edit_link = anchor('card/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_card'));
        $delete_link = "<a href='#' class='po' title='<b>" . $this->lang->line("delete_card") . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('card/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
        . lang('delete_card') . "</a>";
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
            ->select("sma_card_item.id,sma_sim_companies.name,sma_card_item.date_sale,sma_sim_branches.branch_name,
            	sma_card_item.price, sma_card_item.quality,sma_card_item.commission, sma_card_item.unit_price, sma_card_item.reference_note,sma_users.username")
            ->from('sma_card_item')
            ->join('sma_sim_companies','sma_sim_companies.id = sma_card_item.company_id')
            ->join('sma_sim_branches','sma_sim_branches.id = sma_card_item.branch_id')
            ->join('sma_users','sma_users.id = sma_card_item.use_sale_man_id');
        $this->datatables->add_column("Actions", $action, "sma_card_item.id");
        echo $this->datatables->generate();
    }


    public function add($quote_id = null)
    {

        $this->sma->checkPermissions();
       	$this->form_validation->set_rules('company_name', $this->lang->line("company_name"), 'required');
        $this->form_validation->set_rules('date_sale', $this->lang->line("date_sale"), 'required');
        $this->form_validation->set_rules('branch_name', $this->lang->line("branch_name"), 'required');
        $this->form_validation->set_rules('card_price', $this->lang->line("card_price"), 'required');
        $this->form_validation->set_rules('card_quality', $this->lang->line("card_quality"), 'required');
        $this->form_validation->set_rules('card_unit_price', $this->lang->line("card_unit_price"), 'required');

        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            
            $data['company_id'] = $this->input->post('company_name');
            if ($this->Owner || $this->Admin) {
                $data['date_sale'] = $this->sma->fld(trim($this->input->post('date_sale')));
            } else {
                $data['date_sale'] = date('Y-m-d H:i:s');
            }
            $data['branch_id'] = $this->input->post('branch_name');
            $data['price'] = $this->input->post('card_price');
            $data['quality'] = $this->input->post('card_quality');
            $data['commission'] = $this->input->post('card_commission');
            $data['unit_price'] = $this->input->post('card_unit_price');
            $data['reference_note'] = $this->sma->clear_tags($this->input->post('reference_note'));
            $data['use_sale_man_id'] = $this->session->userdata('user_id');
            $card_id = $this->card_model->add_card($data);
            if($card_id) {
                $this->session->set_flashdata('message', $this->lang->line("card_add"));
                redirect('card');
            }

        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['company_infor'] = $this->card_model->getCompanyInfor();
        $this->data['branch_infor'] = $this->card_model->getBranchInfor();
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('card'), 'page' => lang('card')), array('link' => '#', 'page' => lang('add_card')));
        $meta = array('page_title' => lang('add_card'), 'bc' => $bc);
        $this->page_construct('card/add', $meta, $this->data);
    }

    public function edit($id = null) {

        $this->sma->checkPermissions();
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->form_validation->set_rules('company_name', $this->lang->line("company_name"), 'required');
        $this->form_validation->set_rules('date_sale', $this->lang->line("date_sale"), 'required');
        $this->form_validation->set_rules('branch_name', $this->lang->line("branch_name"), 'required');
        $this->form_validation->set_rules('card_price', $this->lang->line("card_price"), 'required');
        $this->form_validation->set_rules('card_quality', $this->lang->line("card_quality"), 'required');
        $this->form_validation->set_rules('card_unit_price', $this->lang->line("card_unit_price"), 'required');

        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            $data['company_id'] = $this->input->post('company_name');
            if ($this->Owner || $this->Admin) {
                $data['date_sale'] = $this->sma->fld(trim($this->input->post('date_sale')));
            } else {
                $data['date_sale'] = date('Y-m-d H:i:s');
            }
            $data['branch_id'] = $this->input->post('branch_name');
            $data['price'] = $this->input->post('card_price');
            $data['quality'] = $this->input->post('card_quality');
            $data['commission'] = $this->input->post('card_commission');
            $data['unit_price'] = $this->input->post('card_unit_price');
            $data['reference_note'] = $this->sma->clear_tags($this->input->post('reference_note'));
            $data['use_sale_man_id'] = $this->session->userdata('user_id');
            $card_id = $id;
            $card_id = $this->card_model->update_card($data,$card_id);
            if($card_id) {
                $this->session->set_userdata('remove_card', 1);
                $this->session->set_flashdata('message', $this->lang->line("card_update"));
                redirect('card');
            }
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['id'] = $id;
        $this->data['card_infor'] = $this->card_model->getCardInfor($id);
        $this->data['company_infor'] = $this->card_model->getCompanyInfor();
        $this->data['branch_infor'] = $this->card_model->getBranchInfor();
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('card'), 'page' => lang('card')), array('link' => '#', 'page' => lang('edit_card')));
        $meta = array('page_title' => lang('edit_card'), 'bc' => $bc);
        $this->page_construct('card/edit', $meta, $this->data);
    }

    public function delete($id = null)
    {
        $this->sma->checkPermissions(NULL, true);
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->card_model->deleteCard($id)) {
            if ($this->input->is_ajax_request()) {
                echo lang("card_deleted");die();
            }
            $this->session->set_flashdata('message', lang('card_deleted'));
            redirect('card');
        }
    }

    public function card_actions()
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
                        $this->card_model->deleteCard($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line("card_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'export_excel') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('card'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('company_name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('date_sale'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('branch_name'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('price'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('quality'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('commission'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('unit_price'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('reference_note'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('seller_name'));


                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $card = $this->card_model->getCardInforById($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $card[0]['company_name']);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $this->sma->hrld($card[0]['date_sale']));
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $card[0]['branch_name']);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $card[0]['price']);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $card[0]['quality']);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $card[0]['commission']);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $card[0]['unit_price']);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $card[0]['reference_note']);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $card[0]['seller_name']);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'card' . date('Y_m_d_H_i_s');
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
<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cardsale extends MY_Controller
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
        $this->load->model('cardsale_model');
    }


    public function index($warehouse_id = null)
    {
        $this->sma->checkPermissions();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('card_sale')));
        $meta = array('page_title' => lang('card_sale'), 'bc' => $bc);
        $this->page_construct('cardsale/index', $meta, $this->data);

    }

    public function getCardSale()
    {
        $this->sma->checkPermissions('index');
        $edit_link = anchor('cardsale/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_card_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . $this->lang->line("delete_card_sale") . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('cardsale/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
        . lang('delete_card_sale') . "</a>";
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
            ->select("sma_sale_card.id,sma_sale_card.title,sma_sale_card.date_sale,sma_card_branch.branch_name ,sma_users.username,sma_sale_card.reference_noted")
            ->from('sma_sale_card')
            ->join('sma_card_branch','sma_card_branch.id = sma_sale_card.use_card_branch_id')
            ->join('sma_users','sma_users.id = sma_sale_card.sale_man_id');
        $this->datatables->add_column("Actions", $action, "sma_sale_card.id");
        echo $this->datatables->generate();
    }

    public function add($quote_id = null)
    {

        $this->sma->checkPermissions();
       	$this->form_validation->set_rules('title', $this->lang->line("title"), 'required');
        $this->form_validation->set_rules('date_sale_card_sale', $this->lang->line("date_sale"), 'required');
        $this->form_validation->set_rules('card_branch_name', $this->lang->line("card_branch_name"), 'required');

        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            
            $data['title'] = $this->input->post('title');
            if ($this->Owner || $this->Admin) {
                $data['date_sale'] = $this->sma->fld(trim($this->input->post('date_sale_card_sale')));
            } else {
                $data['date_sale'] = date('Y-m-d H:i:s');
            }
            $data['reference_noted'] = $this->sma->clear_tags($this->input->post('reference_note')) ;
            $data['use_card_branch_id'] = $this->input->post('card_branch_name');
         	$data['sale_man_id'] = $this->session->userdata('user_id');
            $card_id = $this->cardsale_model->add_card_sale($data);
            if($card_id) {
                $this->session->set_flashdata('message', $this->lang->line("card_sale_add"));
                redirect('cardsale');
            }

        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['card_branch_name'] = $this->cardsale_model->getCardBranchInfor();
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('cardsale'), 'page' => lang('card_sale')), array('link' => '#', 'page' => lang('add_card_sale')));
        $meta = array('page_title' => lang('add_card_sale'), 'bc' => $bc);
        $this->page_construct('cardsale/add', $meta, $this->data);
    }

    public function edit($id = null) {

        $this->sma->checkPermissions();
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->form_validation->set_rules('title', $this->lang->line("title"), 'required');
        $this->form_validation->set_rules('date_sale_card_sale', $this->lang->line("date_sale"), 'required');
        $this->form_validation->set_rules('card_branch_name', $this->lang->line("card_branch_name"), 'required');
        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            $data['title'] = $this->input->post('title');
            if ($this->Owner || $this->Admin) {
                $data['date_sale'] = $this->sma->fld(trim($this->input->post('date_sale_card_sale')));
            } else {
                $data['date_sale'] = date('Y-m-d H:i:s');
            }
            $data['reference_noted'] = $this->sma->clear_tags($this->input->post('reference_note')) ;
            $data['use_card_branch_id'] = $this->input->post('card_branch_name');
         	$data['sale_man_id'] = $this->session->userdata('user_id');
         	$card_sale_id = $id;
            $card_sale_id = $this->cardsale_model->update_card_sale($data,$card_sale_id);
            if($card_sale_id) {
                $this->session->set_flashdata('message', $this->lang->line("card_sale_update"));
                redirect('cardsale');
            }
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['id'] = $id;
        $this->data['card_sale_infor'] = $this->cardsale_model->getCardSaleInfor($id);
         $this->data['card_branch_name'] = $this->cardsale_model->getCardBranchInfor();
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('cardsale'), 'page' => lang('card_sale')), array('link' => '#', 'page' => lang('edit_card_sale')));
        $meta = array('page_title' => lang('edit_card_sale'), 'bc' => $bc);
        $this->page_construct('cardsale/edit', $meta, $this->data);
    }

    public function delete($id = null)
    {
        $this->sma->checkPermissions(NULL, true);
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->cardsale_model->deleteCardSale($id)) {
            if ($this->input->is_ajax_request()) {
                echo lang("card_sale_deleted");die();
            }
            $this->session->set_flashdata('message', lang('card_sale_deleted'));
            redirect('cardsale');
        }
    }
    public function card_sale_actions()
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
                        $this->cardsale_model->deleteCardSale($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line("card_sale_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'export_excel') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('card'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('title'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('date_sale'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('card_branch_name'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('username'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('reference_note'));


                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $card_sale = $this->cardsale_model->getCardSaleInforById($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $card_sale[0]['title']);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $this->sma->hrld($card_sale[0]['date_sale']));
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $card_sale[0]['card_branch_name']);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $card_sale[0]['username']);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $card_sale[0]['reference_noted']);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'cardsale' . date('Y_m_d_H_i_s');
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

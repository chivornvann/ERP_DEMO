<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cardsaledetail extends MY_Controller
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
        $this->load->model('cardsaledetail_model');
    }

    public function index($warehouse_id = null)
    {
        $this->sma->checkPermissions();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('card_sale_detail')));
        $meta = array('page_title' => lang('card_sale_detail'), 'bc' => $bc);
        $this->page_construct('cardsaledetail/index', $meta, $this->data);

    }

    public function getCardSaleDetail()
    {
        $this->sma->checkPermissions('index');
        $edit_link = anchor('cardsaledetail/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_card_sale_detail'));
        $delete_link = "<a href='#' class='po' title='<b>" . $this->lang->line("delete_card_sale_detail") . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('cardsaledetail/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
        . lang('delete_card_sale_detail') . "</a>";
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
            ->select("sma_sale_card_detail.id,sma_sale_card_detail.quality,sma_card_item.code,sma_sale_card.title")
            ->from('sma_sale_card_detail')
            ->join('sma_card_item','sma_card_item.id = sma_sale_card_detail.use_card_item_id')
            ->join('sma_sale_card','sma_sale_card.id = sma_sale_card_detail.use_sale_card_id');
        $this->datatables->add_column("Actions", $action, "sma_sale_card_detail.id");
        echo $this->datatables->generate();
       
    }

    public function add($quote_id = null)
    {

        $this->sma->checkPermissions();
        $this->form_validation->set_rules('quality', $this->lang->line("quality"), 'required');
        $this->form_validation->set_rules('card_item', $this->lang->line("card_item"), 'required');
        $this->form_validation->set_rules('card_sale', $this->lang->line("card_sale"), 'required');

        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            
            $data['quality'] = $this->input->post('quality');
            $data['use_card_item_id'] = $this->input->post('card_item');
            $data['use_sale_card_id'] = $this->input->post('card_sale');

            $card_sale_detail_id = $this->cardsaledetail_model->add_card_sale_detail($data);
            if($card_sale_detail_id) {
                $this->session->set_flashdata('message', $this->lang->line("card_sale_detail_add"));
                redirect('cardsaledetail');
            }

        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['card_item_name'] = $this->cardsaledetail_model->getCardItemInfor();
        $this->data['card_sale_name'] = $this->cardsaledetail_model->getCardSaleInfor();
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('cardsaledetail'), 'page' => lang('card_sale_detail')), array('link' => '#', 'page' => lang('add_card_sale_detail')));
        $meta = array('page_title' => lang('add_card_sale_detail'), 'bc' => $bc);
        $this->page_construct('cardsaledetail/add', $meta, $this->data);
    }

    public function edit($id = null) {

        $this->sma->checkPermissions();
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $this->form_validation->set_rules('quality', $this->lang->line("quality"), 'required');
        $this->form_validation->set_rules('card_item', $this->lang->line("card_item"), 'required');
        $this->form_validation->set_rules('card_sale', $this->lang->line("card_sale"), 'required');
        $this->session->unset_userdata('csrf_token');
        if ($this->form_validation->run() == true) {
            $data['quality'] = $this->input->post('quality');
            $data['use_card_item_id'] = $this->input->post('card_item');
            $data['use_sale_card_id'] = $this->input->post('card_sale');

            $card_sale_detail_id = $this->cardsaledetail_model->udpate_card_sale_detail($data,$id);
            if($card_sale_detail_id) {
                $this->session->set_flashdata('message', $this->lang->line("card_sale_detail_update"));
                redirect('cardsaledetail');
            }

        }
         $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['card_item_name'] = $this->cardsaledetail_model->getCardItemInfor();
        $this->data['card_sale_name'] = $this->cardsaledetail_model->getCardSaleInfor();
        $this->data['card_sale_detail_infor'] = $this->cardsaledetail_model->getCardSaleDetailInfor($id);
        $this->load->helper('string');
        $value = random_string('alnum', 20);
        $this->data['id'] = $id;
        $this->session->set_userdata('user_csrf', $value);
        $this->data['csrf'] = $this->session->userdata('user_csrf');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('cardsaledetail'), 'page' => lang('card_sale_detail')), array('link' => '#', 'page' => lang('edit_card_sale_detail')));
        $meta = array('page_title' => lang('edit_card_sale_detail'), 'bc' => $bc);
        $this->page_construct('cardsaledetail/edit', $meta, $this->data);
    }

    public function delete($id = null)
    {
        $this->sma->checkPermissions(NULL, true);
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->cardsaledetail_model->deleteCardSaleDetail($id)) {
            if ($this->input->is_ajax_request()) {
                echo lang("card_sale_detail_deleted");die();
            }
            $this->session->set_flashdata('message', lang('card_sale_detail_deleted'));
            redirect('cardsaledetail');
        }
    }

     public function card_sale_detail_actions()
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
                        $this->cardsaledetail_model->deleteCardSaleDetail($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line("card_sale_detail_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'export_excel') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('card'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('quality'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('card_item_code'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('card_sale_title'));
                    
                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $card_sale_detail = $this->cardsaledetail_model->getCardSaleDetailInforById($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $card_sale_detail[0]['quality']);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $card_sale_detail[0]['code']);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $card_sale_detail[0]['title']);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'cardSaleDetail' . date('Y_m_d_H_i_s');
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
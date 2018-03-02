<?php defined('BASEPATH') OR exit('No direct script access allowed');

class sim extends MY_Controller
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
        $this->load->model('sim_model');
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

    function index()
    {

        $this->form_validation->set_rules('site_name', lang('site_name'), 'trim|required');
        $this->form_validation->set_rules('dateformat', lang('dateformat'), 'trim|required');
        $this->form_validation->set_rules('timezone', lang('timezone'), 'trim|required');
        $this->form_validation->set_rules('mmode', lang('maintenance_mode'), 'trim|required');
        //$this->form_validation->set_rules('logo', lang('logo'), 'trim');
        $this->form_validation->set_rules('iwidth', lang('image_width'), 'trim|numeric|required');
        $this->form_validation->set_rules('iheight', lang('image_height'), 'trim|numeric|required');
        $this->form_validation->set_rules('twidth', lang('thumbnail_width'), 'trim|numeric|required');
        $this->form_validation->set_rules('theight', lang('thumbnail_height'), 'trim|numeric|required');
        $this->form_validation->set_rules('display_all_products', lang('display_all_products'), 'trim|numeric|required');
        $this->form_validation->set_rules('watermark', lang('watermark'), 'trim|required');
        $this->form_validation->set_rules('currency', lang('default_currency'), 'trim|required');
        $this->form_validation->set_rules('email', lang('default_email'), 'trim|required');
        $this->form_validation->set_rules('language', lang('language'), 'trim|required');
        $this->form_validation->set_rules('warehouse', lang('default_warehouse'), 'trim|required');
        $this->form_validation->set_rules('biller', lang('default_biller'), 'trim|required');
        $this->form_validation->set_rules('tax_rate', lang('product_tax'), 'trim|required');
        $this->form_validation->set_rules('tax_rate2', lang('invoice_tax'), 'trim|required');
        $this->form_validation->set_rules('sales_prefix', lang('sales_prefix'), 'trim');
        $this->form_validation->set_rules('quote_prefix', lang('quote_prefix'), 'trim');
        $this->form_validation->set_rules('purchase_prefix', lang('purchase_prefix'), 'trim');
        $this->form_validation->set_rules('transfer_prefix', lang('transfer_prefix'), 'trim');
        $this->form_validation->set_rules('delivery_prefix', lang('delivery_prefix'), 'trim');
        $this->form_validation->set_rules('payment_prefix', lang('payment_prefix'), 'trim');
        $this->form_validation->set_rules('return_prefix', lang('return_prefix'), 'trim');
        $this->form_validation->set_rules('expense_prefix', lang('expense_prefix'), 'trim');
        $this->form_validation->set_rules('detect_barcode', lang('detect_barcode'), 'trim|required');
        $this->form_validation->set_rules('theme', lang('theme'), 'trim|required');
        $this->form_validation->set_rules('rows_per_page', lang('rows_per_page'), 'trim|required|greater_than[9]|less_than[501]');
        $this->form_validation->set_rules('accounting_method', lang('accounting_method'), 'trim|required');
        $this->form_validation->set_rules('product_serial', lang('product_serial'), 'trim|required');
        $this->form_validation->set_rules('product_discount', lang('product_discount'), 'trim|required');
        $this->form_validation->set_rules('bc_fix', lang('bc_fix'), 'trim|numeric|required');
        $this->form_validation->set_rules('protocol', lang('email_protocol'), 'trim|required');
        if ($this->input->post('protocol') == 'smtp') {
            $this->form_validation->set_rules('smtp_host', lang('smtp_host'), 'required');
            $this->form_validation->set_rules('smtp_user', lang('smtp_user'), 'required');
            $this->form_validation->set_rules('smtp_pass', lang('smtp_pass'), 'required');
            $this->form_validation->set_rules('smtp_port', lang('smtp_port'), 'required');
        }
        if ($this->input->post('protocol') == 'sendmail') {
            $this->form_validation->set_rules('mailpath', lang('mailpath'), 'required');
        }
        $this->form_validation->set_rules('decimals', lang('decimals'), 'trim|required');
        $this->form_validation->set_rules('decimals_sep', lang('decimals_sep'), 'trim|required');
        $this->form_validation->set_rules('thousands_sep', lang('thousands_sep'), 'trim|required');
        $this->load->library('encrypt');

        if ($this->form_validation->run() == true) {

            $language = $this->input->post('language');

            if ((file_exists(APPPATH.'language'.DIRECTORY_SEPARATOR.$language.DIRECTORY_SEPARATOR.'sma_lang.php') && is_dir(APPPATH.DIRECTORY_SEPARATOR.'language'.DIRECTORY_SEPARATOR.$language)) || $language == 'english') {
                $lang = $language;
            } else {
                $this->session->set_flashdata('error', lang('language_x_found'));
                redirect("system_settings");
                $lang = 'english';
            }

            $tax1 = ($this->input->post('tax_rate') != 0) ? 1 : 0;
            $tax2 = ($this->input->post('tax_rate2') != 0) ? 1 : 0;

            $data = array('site_name' => DEMO ? 'Stock Manager Advance' : $this->input->post('site_name'),
                'rows_per_page' => $this->input->post('rows_per_page'),
                'dateformat' => $this->input->post('dateformat'),
                'timezone' => DEMO ? 'Asia/Kuala_Lumpur' : $this->input->post('timezone'),
                'mmode' => trim($this->input->post('mmode')),
                'iwidth' => $this->input->post('iwidth'),
                'iheight' => $this->input->post('iheight'),
                'twidth' => $this->input->post('twidth'),
                'theight' => $this->input->post('theight'),
                'watermark' => $this->input->post('watermark'),
                // 'reg_ver' => $this->input->post('reg_ver'),
                // 'allow_reg' => $this->input->post('allow_reg'),
                // 'reg_notification' => $this->input->post('reg_notification'),
                'accounting_method' => $this->input->post('accounting_method'),
                'default_email' => DEMO ? 'noreply@sma.tecdiary.my' : $this->input->post('email'),
                'language' => $lang,
                'default_warehouse' => $this->input->post('warehouse'),
                'default_tax_rate' => $this->input->post('tax_rate'),
                'default_tax_rate2' => $this->input->post('tax_rate2'),
                'sales_prefix' => $this->input->post('sales_prefix'),
                'quote_prefix' => $this->input->post('quote_prefix'),
                'purchase_prefix' => $this->input->post('purchase_prefix'),
                'transfer_prefix' => $this->input->post('transfer_prefix'),
                'delivery_prefix' => $this->input->post('delivery_prefix'),
                'payment_prefix' => $this->input->post('payment_prefix'),
                'ppayment_prefix' => $this->input->post('ppayment_prefix'),
                'qa_prefix' => $this->input->post('qa_prefix'),
                'return_prefix' => $this->input->post('return_prefix'),
                'returnp_prefix' => $this->input->post('returnp_prefix'),
                'expense_prefix' => $this->input->post('expense_prefix'),
                'auto_detect_barcode' => trim($this->input->post('detect_barcode')),
                'theme' => trim($this->input->post('theme')),
                'product_serial' => $this->input->post('product_serial'),
                'customer_group' => $this->input->post('customer_group'),
                'product_expiry' => $this->input->post('product_expiry'),
                'product_discount' => $this->input->post('product_discount'),
                'default_currency' => $this->input->post('currency'),
                'bc_fix' => $this->input->post('bc_fix'),
                'tax1' => $tax1,
                'tax2' => $tax2,
                'overselling' => $this->input->post('restrict_sale'),
                'reference_format' => $this->input->post('reference_format'),
                'racks' => $this->input->post('racks'),
                'attributes' => $this->input->post('attributes'),
                'restrict_calendar' => $this->input->post('restrict_calendar'),
                'captcha' => $this->input->post('captcha'),
                'item_addition' => $this->input->post('item_addition'),
                'protocol' => DEMO ? 'mail' : $this->input->post('protocol'),
                'mailpath' => $this->input->post('mailpath'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_user' => $this->input->post('smtp_user'),
                'smtp_port' => $this->input->post('smtp_port'),
                'smtp_crypto' => $this->input->post('smtp_crypto') ? $this->input->post('smtp_crypto') : NULL,
                'decimals' => $this->input->post('decimals'),
                'decimals_sep' => $this->input->post('decimals_sep'),
                'thousands_sep' => $this->input->post('thousands_sep'),
                'default_biller' => $this->input->post('biller'),
                'invoice_view' => $this->input->post('invoice_view'),
                'rtl' => $this->input->post('rtl'),
                'each_spent' => $this->input->post('each_spent') ? $this->input->post('each_spent') : NULL,
                'ca_point' => $this->input->post('ca_point') ? $this->input->post('ca_point') : NULL,
                'each_sale' => $this->input->post('each_sale') ? $this->input->post('each_sale') : NULL,
                'sa_point' => $this->input->post('sa_point') ? $this->input->post('sa_point') : NULL,
                'sac' => $this->input->post('sac'),
                'qty_decimals' => $this->input->post('qty_decimals'),
                'display_all_products' => $this->input->post('display_all_products'),
                'display_symbol' => $this->input->post('display_symbol'),
                'symbol' => $this->input->post('symbol'),
                'remove_expired' => $this->input->post('remove_expired'),
                'barcode_separator' => $this->input->post('barcode_separator'),
                'set_focus' => $this->input->post('set_focus'),
                'disable_editing' => $this->input->post('disable_editing'),
                'price_group' => $this->input->post('price_group'),
                'barcode_img' => $this->input->post('barcode_renderer'),
                'update_cost' => $this->input->post('update_cost'),
            );
            if ($this->input->post('smtp_pass')) {
                $data['smtp_pass'] = $this->encrypt->encode($this->input->post('smtp_pass'));
            }
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSetting($data)) {
            if ( ! DEMO && TIMEZONE != $data['timezone']) {
                if ( ! $this->write_index($data['timezone'])) {
                    $this->session->set_flashdata('error', lang('setting_updated_timezone_failed'));
                    redirect('system_settings');
                }
            }

            $this->session->set_flashdata('message', lang('setting_updated'));
            redirect("system_settings");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['settings'] = $this->sim_model->getSettings();
            $this->data['currencies'] = $this->sim_model->getAllCurrencies();
            $this->data['date_formats'] = $this->sim_model->getDateFormats();
            $this->data['tax_rates'] = $this->sim_model->getAllTaxRates();
            $this->data['customer_groups'] = $this->sim_model->getAllCustomerGroups();
            $this->data['price_groups'] = $this->sim_model->getAllPriceGroups();
            $this->data['warehouses'] = $this->sim_model->getAllWarehouses();
            $this->data['smtp_pass'] = $this->encrypt->decode($this->data['settings']->smtp_pass);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('system_settings')));
            $meta = array('page_title' => lang('system_settings'), 'bc' => $bc);
            $this->page_construct('settings/index', $meta, $this->data);
        }
    }


    function locations()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('locations')));
        $meta = array('page_title' => lang('locations'), 'bc' => $bc);
        $this->page_construct('sim/locations', $meta, $this->data);
    }

    function getLocations()
    {

        $print_barcode = anchor('products/print_barcodes/?category=$1', '<i class="fa fa-print"></i>', 'title="'.lang('print_barcodes').'" class="tip"');

        $this->load->library('datatables');
        $this->datatables
            ->select("{$this->db->dbprefix('sim_locations')}.id as id, {$this->db->dbprefix('sim_locations')}.image, {$this->db->dbprefix('sim_locations')}.code, {$this->db->dbprefix('sim_locations')}.name, c.name as parent", FALSE)
            ->from("sim_locations")
            ->join("sim_locations c", 'c.id=sim_locations.parent_id', 'left')
            ->group_by('sim_locations.id')
            ->add_column("Actions", "<div class=\"text-center\">".$print_barcode." <a href='" . site_url('sim/edit_location/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_location") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_location") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_location/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");

        echo $this->datatables->generate();
    }

    function add_location()
    {

        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("location_code"), 'trim|is_unique[sim_locations.code]|required');
        $this->form_validation->set_rules('name', lang("name"), 'required|min_length[3]');
        $this->form_validation->set_rules('userfile', lang("location_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'parent_id' => $this->input->post('parent'),
                );

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            }

        } elseif ($this->input->post('add_location')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/locations");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addLocation($data)) {
            $this->session->set_flashdata('message', lang("location_added"));
            redirect("sim/locations");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['locations'] = $this->sim_model->getParentLocations();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_location', $this->data);

        }
    }

    function edit_location($id = NULL)
    {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', lang("location_code"), 'trim|required');
        $pr_details = $this->sim_model->getLocationByID($id);
        if ($this->input->post('code') != $pr_details->code) {
            $this->form_validation->set_rules('code', lang("location_code"), 'is_unique[sim_locations.code]');
        }
        $this->form_validation->set_rules('name', lang("location_name"), 'required|min_length[3]');
        $this->form_validation->set_rules('userfile', lang("location_image"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'parent_id' => $this->input->post('parent'),
                );

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['max_width'] = $this->Settings->iwidth;
                $config['max_height'] = $this->Settings->iheight;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload_path . $photo;
                $config['new_image'] = $this->thumbs_path . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $this->Settings->twidth;
                $config['height'] = $this->Settings->theight;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) {
                    $this->image_lib->clear();
                    $wm['source_image'] = $this->upload_path . $photo;
                    $wm['wm_text'] = 'Copyright ' . date('Y') . ' - ' . $this->Settings->site_name;
                    $wm['wm_type'] = 'text';
                    $wm['wm_font_path'] = 'system/fonts/texb.ttf';
                    $wm['quality'] = '100';
                    $wm['wm_font_size'] = '16';
                    $wm['wm_font_color'] = '999999';
                    $wm['wm_shadow_color'] = 'CCCCCC';
                    $wm['wm_vrt_alignment'] = 'top';
                    $wm['wm_hor_alignment'] = 'right';
                    $wm['wm_padding'] = '10';
                    $this->image_lib->initialize($wm);
                    $this->image_lib->watermark();
                }
                $this->image_lib->clear();
                $config = NULL;
            }

        } elseif ($this->input->post('edit_location')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/locations");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateLocation($id, $data)) {
            $this->session->set_flashdata('message', lang("location_updated"));
            redirect("sim/locations");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['location'] = $this->sim_model->getLocationByID($id);
            $this->data['locations'] = $this->sim_model->getParentLocations();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_location', $this->data);

        }
    }

    function delete_location($id = NULL)
    {

        if ($this->site->getSubLocations($id)) {
            $this->session->set_flashdata('error', lang("location_has_sublocation"));
            redirect("sim/locations");
        }

        if ($this->sim_model->deleteLocation($id)) {
            echo lang("location_deleted");
        }
    }

    function location_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sim_model->deleteLocation($id);
                    }
                    $this->session->set_flashdata('message', lang("locations_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('locations'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('image'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('parent_location'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->sim_model->getLocationByID($id);
                        $parent_actegory = '';
                        if ($sc->parent_id) {
                            $pc = $this->sim_model->getLocationByID($sc->parent_id);
                            $parent_actegory = $pc->code;
                        }
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->code);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->name);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->image);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $parent_actegory);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'locations_' . date('Y_m_d_H_i_s');
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
	
	
	
	
	
	
	
	
	
	
	
	
	function sim_companies()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_companies')));
        $meta = array('page_title' => lang('sim_companies'), 'bc' => $bc);
        $this->page_construct('sim/sim_companies', $meta, $this->data);
    }

    function getSimCompanies()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("sim_companies")
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/group_product_prices/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>  <a href='" . site_url('sim/edit_sim_company/$1') . "' class='tip' title='" . lang("edit_sim_company") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim_company") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim_company/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_sim_company()
    {

        $this->form_validation->set_rules('name', lang("sim_company"), 'trim|is_unique[sim_companies.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_company')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_companies");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimCompany($data)) {
            $this->session->set_flashdata('message', lang("sim_company_added"));
            redirect("sim/sim_companies");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_company', $this->data);
        }
    }

    function edit_sim_company($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("sim_company"), 'trim|required|alpha_numeric_spaces');
        $pg_details = $this->sim_model->getSimCompanyByID($id);
        if ($this->input->post('name') != $pg_details->name) {
            $this->form_validation->set_rules('name', lang("sim_company"), 'is_unique[sim_companies.name]');
        }

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_company')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_companies");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimCompany($id, $data)) {
            $this->session->set_flashdata('message', lang("sim_company_updated"));
            redirect("sim/sim_companies");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['sim_company'] = $pg_details;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sim_company', $this->data);
        }
    }

    function delete_sim_company($id = NULL)
    {
        if ($this->sim_model->deleteSimCompany($id)) {
            echo lang("sim_company_deleted");
        }
    }
	
	
	
	
	
	
	function sim_types()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_types')));
        $meta = array('page_title' => lang('sim_types'), 'bc' => $bc);
        $this->page_construct('sim/sim_types', $meta, $this->data);
    }

    function getSimTypes()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("sim_types")
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/group_product_prices/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>  <a href='" . site_url('sim/edit_sim_type/$1') . "' class='tip' title='" . lang("edit_sim_type") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim_type") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim_type/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_sim_type()
    {

        $this->form_validation->set_rules('name', lang("sim_type"), 'trim|is_unique[sim_types.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_type')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimType($data)) {
            $this->session->set_flashdata('message', lang("sim_type_added"));
            redirect("sim/sim_types");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_type', $this->data);
        }
    }

    function edit_sim_type($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("sim_type"), 'trim|required|alpha_numeric_spaces');
        $pg_details = $this->sim_model->getSimTypeByID($id);
        if ($this->input->post('name') != $pg_details->name) {
            $this->form_validation->set_rules('name', lang("sim_type"), 'is_unique[sim_types.name]');
        }

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_type')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimType($id, $data)) {
            $this->session->set_flashdata('message', lang("sim_type_updated"));
            redirect("sim/sim_types");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['sim_type'] = $pg_details;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sim_type', $this->data);
        }
    }

    function delete_sim_type($id = NULL)
    {
        if ($this->sim_model->deleteSimType($id)) {
            echo lang("sim_type_deleted");
        }
    }
	
	
	
	
	
	
	function sim_stock_types()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_stock_types')));
        $meta = array('page_title' => lang('sim_stock_types'), 'bc' => $bc);
        $this->page_construct('sim/sim_stock_types', $meta, $this->data);
    }

    function getSimStockTypes()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("sim_stock_types")
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/group_product_prices/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>  <a href='" . site_url('sim/edit_sim_stock_type/$1') . "' class='tip' title='" . lang("edit_sim_stock_type") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim_stock_type") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim_stock_type/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_sim_stock_type()
    {

        $this->form_validation->set_rules('name', lang("sim_stock_type"), 'trim|is_unique[sim_stock_types.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_stock_type')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_stock_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimStockType($data)) {
            $this->session->set_flashdata('message', lang("sim_stock_type_added"));
            redirect("sim/sim_stock_types");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_stock_type', $this->data);
        }
    }

    function edit_sim_stock_type($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("sim_stock_type"), 'trim|required|alpha_numeric_spaces');
        $pg_details = $this->sim_model->getSimStockTypeByID($id);
        if ($this->input->post('name') != $pg_details->name) {
            $this->form_validation->set_rules('name', lang("sim_stock_type"), 'is_unique[sim_stock_types.name]');
        }

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_stock_type')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_stock_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimStockType($id, $data)) {
            $this->session->set_flashdata('message', lang("sim_stock_type_updated"));
            redirect("sim/sim_stock_types");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['sim_stock_types'] = $pg_details;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sim_stock_type', $this->data);
        }
    }

    function delete_sim_stock_type($id = NULL)
    {
        if ($this->sim_model->deleteSimStockType($id)) {
            echo lang("sim_stock_type_deleted");
        }
    }








    function sim_branches()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_branches')));
        $meta = array('page_title' => lang('sim_branches'), 'bc' => $bc);
        $this->page_construct('sim/sim_branches', $meta, $this->data);
    }

    function getSimBranches()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id,branch_name, phone, use_sim_location_id, contact_name, facebook_name")
            ->from("sim_branches")
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/edit_sim_branch/$1') . "' class='tip' title='" . lang("edit_sim_branch") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim_branch") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim_branch/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_sim_branch()
    {

        //$this->form_validation->set_rules('code', lang("currency_code"), 'trim|is_unique[currencies.code]|required');
        $this->form_validation->set_rules('branch_name', lang("branch_name"), 'required');
        $this->form_validation->set_rules('phone', lang("phone"), 'required');
        $this->form_validation->set_rules('use_sim_location', lang("sim_location"), 'required');
        $this->form_validation->set_rules('contact_name', lang("contact_name"), 'trim');
        $this->form_validation->set_rules('facebook_name', lang("facebook_name"), 'trim');

        if ($this->form_validation->run() == true) {
            $data = array(
                'branch_name' => $this->input->post('branch_name'),
                'phone' => $this->input->post('phone'),
                'use_sim_location_id' => $this->input->post('use_sim_location'),
                'contact_name' => $this->input->post('contact_name'),
                'facebook_name' => $this->input->post('facebook_name')
            );
        } elseif ($this->input->post('add_sim_branch')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_branches");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimBranch($data)) { //check to see if we are creating the customer
            $this->session->set_flashdata('message', lang("sim_branch_added"));
            redirect("sim/sim_branches");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['page_title'] = lang("new_sim_branch");
            $this->load->view($this->theme . 'sim/add_sim_branch', $this->data);
        }
    }

    function edit_sim_branch($id = NULL)
    {

        $this->form_validation->set_rules('branch_name', lang("branch_name"), 'required');
        $this->form_validation->set_rules('phone', lang("phone"), 'required');
        $this->form_validation->set_rules('use_sim_location', lang("sim_location"), 'required');
        $this->form_validation->set_rules('contact_name', lang("contact_name"), 'trim');
        $this->form_validation->set_rules('facebook_name', lang("facebook_name"), 'trim');
        if ($this->form_validation->run() == true) {

           $data = array(
                'branch_name' => $this->input->post('branch_name'),
                'phone' => $this->input->post('phone'),
                'use_sim_location_id' => $this->input->post('use_sim_location'),
                'contact_name' => $this->input->post('contact_name'),
                'facebook_name' => $this->input->post('facebook_name')
            );
        } elseif ($this->input->post('edit_sim_branch')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_branches");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimBranch($id, $data)) { //check to see if we are updateing the customer
            $this->session->set_flashdata('message', lang("sim_branch_updated"));
            redirect("sim/sim_branches");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['sim_branches'] = $this->sim_model->getSimBranchByID($id);
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sim_branch', $this->data);
        }
    }

    function delete_sim_branch($id = NULL)
    {

        if ($this->sim_model->deleteSimBranch($id)) {
            echo lang("sim_branch_deleted");
        }
    }

    function sim_branch_actions()
    {

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    foreach ($_POST['val'] as $id) {
                        $this->sim_model->deleteSimBranch($id);
                    }
                    $this->session->set_flashdata('message', lang("sim_branches_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sim_branches'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('branch_name'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('phone'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('use_sim_location'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('contact_name'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('facebook_name'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $sc = $this->sim_model->getSimBranchByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $sc->branch_name);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sc->phone);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sc->use_sim_location_id);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sc->contact_name);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sc->facebook_name);
                           
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'sim_branches_' . date('Y_m_d_H_i_s');
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







    function sim_groups()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_groups')));
        $meta = array('page_title' => lang('sim_groups'), 'bc' => $bc);
        $this->page_construct('sim/sim_groups', $meta, $this->data);
    }

    function getSimGroups()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, name")
            ->from("sim_groups")
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/edit_sim_group/$1') . "' class='tip' title='" . lang("edit_sim_group") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim_group") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim_group/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_sim_group()
    {

        $this->form_validation->set_rules('name', lang("sim_group"), 'trim|is_unique[sim_groups.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_group')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_groups");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimGroup($data)) {
            $this->session->set_flashdata('message', lang("sim_group_added"));
            redirect("sim/sim_groups");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_group', $this->data);
        }
    }

    function edit_sim_group($id = NULL)
    {

        $this->form_validation->set_rules('name', lang("sim_group"), 'trim|required|alpha_numeric_spaces');
        $pg_details = $this->sim_model->getSimGroupByID($id);
        if ($this->input->post('name') != $pg_details->name) {
            $this->form_validation->set_rules('name', lang("sim_group"), 'is_unique[sim_groups.name]');
        }

        if ($this->form_validation->run() == true) {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_group')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_groups");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimGroup($id, $data)) {
            $this->session->set_flashdata('message', lang("sim_group_updated"));
            redirect("sim/sim_groups");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['sim_group'] = $pg_details;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sim_group', $this->data);
        }
    }

    function delete_sim_group($id = NULL)
    {
        if ($this->sim_model->deleteSimGroup($id)) {
            echo lang("sim_group_deleted");
        }
    }











    function sim_shops()
    {

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_companies')));
        $meta = array('page_title' => lang('sim_shops'), 'bc' => $bc);
        $this->page_construct('sim/sim_shops', $meta, $this->data);
    }

    function getSimShops()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, shop")
            ->from("sim_shops")
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/group_product_prices/$1') . "' class='tip' title='" . lang("group_product_prices") . "'><i class=\"fa fa-eye\"></i></a>  <a href='" . site_url('sim/edit_sim_shop/$1') . "' class='tip' title='" . lang("edit_sim_shop") . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim_shop") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim_shop/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        //->unset_column('id');

        echo $this->datatables->generate();
    }

    function add_sim_shop()
    {

        $this->form_validation->set_rules('shop', lang("sim_shop"), 'trim|is_unique[sim_shops.shop]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) {
            $data = array('shop' => $this->input->post('shop'));
        } elseif ($this->input->post('add_sim_shop')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_shops");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimShop($data)) {
            $this->session->set_flashdata('message', lang("sim_shop_added"));
            redirect("sim/sim_shops");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/add_sim_shop', $this->data);
        }
    }

    function edit_sim_shop($id = NULL)
    {

        $this->form_validation->set_rules('shop', lang("sim_shop"), 'trim|required|alpha_numeric_spaces');
        $pg_details = $this->sim_model->getSimShopByID($id);
        if ($this->input->post('shop') != $pg_details->shop) {
            $this->form_validation->set_rules('shop', lang("sim_shop"), 'is_unique[sim_shops.shop]');
        }

        if ($this->form_validation->run() == true) {
            $data = array('shop' => $this->input->post('shop'));
        } elseif ($this->input->post('edit_sim_shop')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_shops");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimShop($id, $data)) {
            $this->session->set_flashdata('message', lang("sim_shop_updated"));
            redirect("sim/sim_shops");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['sim_shop'] = $pg_details;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'sim/edit_sim_shop', $this->data);
        }
    }

    function delete_sim_shop($id = NULL)
    {
        if ($this->sim_model->deleteSimShop($id)) {
            echo lang("sim_shop_deleted");
        }
    }







}
    
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

        $this->lang->load('sim', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->model('sim_model');
        $this->upload_path = 'assets/uploads/';
        $this->digital_upload_path = 'files/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'csv|zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif';
        $this->allowed_file_size = '1024';
    }

    function index()
    {
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('list_sim')));
        $meta = array('page_title' => lang('list_sim'), 'bc' => $bc);
        $this->page_construct('sim/index', $meta, $this->data);
       
    }

    function view_sim_by_group($simGroup = NULL)
    {
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('sim_group_detail')));
        $meta = array('page_title' => lang('sim_group_detail'), 'bc' => $bc);
        $this->page_construct('sim/view_sim_group', $meta, $this->data);
    }

    function get_sim_by_group($simGroup = NULL)
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("{$this->db->dbprefix('sim')}.id as id, {$this->db->dbprefix('sim')}.sim_number,g.name as sim_group,t.name as sim_type,c.name as sim_company,{$this->db->dbprefix('sim')}.is_saled,{$this->db->dbprefix('sim')}.is_has_identify_card,{$this->db->dbprefix('sim')}.identify_card_picture,{$this->db->dbprefix('sim')}.is_in_stock,{$this->db->dbprefix('sim')}.price")
            ->from("sim")
            ->join("sim_groups g", 'g.id=sim.use_sim_group_id', 'left')
            ->join("sim_types t", 't.id=sim.use_sim_type_id', 'left')
            ->join("sim_companies c", 'c.id=sim.use_sim_company_id', 'left')
            ->where("g.id",$simGroup)
            ->where("{$this->db->dbprefix('sim')}.is_saled",0)
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/edit_sim/$1') . "' class='tip' title='" . lang("edit_sim") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");

        echo $this->datatables->generate();
    }


    function add()
    {
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $this->form_validation->set_rules('sim_number', lang("sim_number"), 'trim|required|regex_match[/^[0-9]{9,10}$/]|is_unique[sim.sim_number]');
        $this->form_validation->set_rules('sim_group', lang("sim_group"), 'required');
        $this->form_validation->set_rules('price', lang("price"), 'required|numeric');
        $this->form_validation->set_rules('sim_type', lang("sim_type"), 'required');
        $this->form_validation->set_rules('sim_company', lang("sim_company"), 'required');

        if ($this->form_validation->run() == true) 
        {
            $this->load->library('upload');
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
                    redirect("sim/add");
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
                
                if (!$this->image_lib->resize()) 
                {
                    echo $this->image_lib->display_errors();
                }
            }

            $data = array(
                'sim_number' => $this->input->post('sim_number'),
                'use_sim_group_id' => $this->input->post('sim_group'),
                'use_sim_type_id' =>  $this->input->post('sim_type'),
                'use_sim_company_id' =>  $this->input->post('sim_company'),
                'price'  => $this->sma->formatDecimal($this->input->post("price")),
                'is_saled'  => $this->input->post("is_saled"),
                "is_has_identify_card" => $this->input->post("identify_card"),
                "is_in_stock" => $this->input->post("in_stock"),
                "identify_card_picture" =>$photo,
            );

            if ($this->sim_model->addSim($data)) {
                $this->session->set_flashdata('message', lang('add_sim_success'));
                redirect("sim/index");
            }

        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : '';
            $group_sim_result = $this->sim_model->getAllSimGroups();
            $this->data["sim_group"] = array();
            $this->data["sim_type"] = array();
            $this->data["sim_company"] = array();

            foreach ($group_sim_result as $value) 
            {
                $this->data["sim_group"][$value->id] = $value->name;
            }
            $sim_type_result = $this->sim_model->getAllSimTypes();
            foreach ($sim_type_result as $value) 
            {
                $this->data["sim_type"][$value->id] = $value->name;
            }
            $sim_company_result = $this->sim_model->getAllSimCompanies();
            foreach ($sim_company_result as $value) 
            {
                $this->data["sim_company"][$value->id] = $value->name;
            }

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('add_sim')));
            $meta = array('page_title' => lang('add_sim'), 'bc' => $bc);

            $this->page_construct('sim/add_sim', $meta, $this->data);
        }

    }

    function delete_sim($id = NULL)
    {
        if ($this->sim_model->deleteSim($id)) 
        {
            echo lang("delete_success");
        }
    }

    function edit_sim($id = NULL)
    {

        $this->form_validation->set_rules('sim_number', lang("sim_number"), 'trim|required|regex_match[/^[0-9]{9,10}$/]');
        $this->form_validation->set_rules('sim_group', lang("sim_group"), 'required');
        $this->form_validation->set_rules('sim_type', lang("sim_type"), 'required');
        $this->form_validation->set_rules('price', lang("price"), 'required|numeric');
        $this->form_validation->set_rules('sim_company', lang("sim_company"), 'required');
        $this->data["sim"] = $this->sim_model->getSimByID($id);


        if ($this->form_validation->run() == true) 
        {
            $this->load->library('upload');
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
                    redirect("sim/edit_sim/".$id);
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
                if (!$this->image_lib->resize()) 
                {
                    echo $this->image_lib->display_errors();
                }
            }
            $data = array(
                'sim_number' => $this->input->post('sim_number'),
                'use_sim_group_id' => $this->input->post('sim_group'),
                'use_sim_type_id' =>  $this->input->post('sim_type'),
                'use_sim_company_id' =>  $this->input->post('sim_company'),
                'price'  => $this->sma->formatDecimal($this->input->post("price")),
                'is_saled'  => $this->input->post("is_saled"),
                "is_has_identify_card" => $this->input->post("identify_card"),
                "is_in_stock" => $this->input->post("in_stock"),
                "identify_card_picture" =>$photo,
            );

            if ($this->sim_model->updateSim($data,$id)) 
            {
                $this->session->set_flashdata('message', lang('update_sim_success'));
                redirect("sim/index");
            }
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $group_sim_result = $this->sim_model->getAllSimGroups();
            $this->data["sim_group"] = array();
            $this->data["sim_type"] = array();
            $this->data["sim_company"] = array();

            foreach ($group_sim_result as $value) 
            {
                $this->data["sim_group"][$value->id] = $value->name;
            }

            $sim_type_result = $this->sim_model->getAllSimTypes();
            foreach ($sim_type_result as $value) {
                $this->data["sim_type"][$value->id] = $value->name;
            }
            
            $sim_company_result = $this->sim_model->getAllSimCompanies();
            foreach ($sim_company_result as $value) 
            {
                $this->data["sim_company"][$value->id] = $value->name;
            }
            
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('edit_sim')));
            $meta = array('page_title' => lang('edit_sim'), 'bc' => $bc);
            $this->page_construct('sim/edit_sim', $meta, $this->data);
        }
    }

    function getSim()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select("{$this->db->dbprefix('sim')}.id as id, g.id as group_id, {$this->db->dbprefix('sim')}.sim_number,g.name as sim_group,t.name as sim_type,c.name as sim_company,{$this->db->dbprefix('sim')}.is_saled,{$this->db->dbprefix('sim')}.is_has_identify_card,{$this->db->dbprefix('sim')}.identify_card_picture,{$this->db->dbprefix('sim')}.is_in_stock,{$this->db->dbprefix('sim')}.price")
            ->from("sim")
            ->join("sim_groups g", 'g.id=sim.use_sim_group_id', 'left')
            ->join("sim_types t", 't.id=sim.use_sim_type_id', 'left')
            ->join("sim_companies c", 'c.id=sim.use_sim_company_id', 'left')
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . site_url('sim/edit_sim/$1') . "' class='tip' title='" . lang("edit_sim") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . lang("delete_sim") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sim/delete_sim/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");

        echo $this->datatables->generate();
    }

    function action_transfer_sim()
    {
        $from_sim_group = $this->input->post('from_sim_group');
        $to_sim_group = $this->input->post('to_sim_group');

        if ( $from_sim_group != 0 && $to_sim_group != 0) 
        {
            if (!empty($_POST['val'])) 
            {
                foreach ($_POST['val'] as $id) 
                {
                    $this->sim_model->updateSim(array('use_sim_group_id' => $to_sim_group),$id);
                }
            $this->session->set_flashdata('message', lang("sim_transfer_success"));
            redirect("sim/transfer_sim");
            }else {
                $this->session->set_flashdata('error', lang("no_sim_selected"));
                redirect("sim/transfer_sim");
            }
        }else {
            $this->session->set_flashdata('error', lang("sim_group_no_selected"));
            redirect("sim/transfer_sim");
        }
    }

    function sim_actions()
    {
        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

            if ($this->form_validation->run() == true) 
            {
                if (!empty($_POST['val'])) 
                {
                    if ($this->input->post('form_action') == 'delete') 
                    {
                        foreach ($_POST['val'] as $id) 
                        {
                            $this->sim_model->deleteSim($id);
                        }
                        $this->session->set_flashdata('message', $this->lang->line("delete_success"));
                        redirect($_SERVER["HTTP_REFERER"]);
                    }
                
                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sim'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('sim_number'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('sim_group'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('sim_type'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('sim_company'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('price'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('is_saled'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('is_has_identify_card'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('identify_card_picture'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('is_in_stock'));


                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

                    $row = 2;
                    foreach ($_POST['val'] as $id) 
                    {
                        $sim = $this->sim_model->getSimInforByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, "'".$sim->sim_number);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $sim->sim_group);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sim->sim_type);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sim->sim_company);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sim->price);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sim->is_saled);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sim->is_has_identify_card);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $sim->identify_card_picture);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $sim->is_in_stock);
                           
                        $row++;
                    }

                    $filename = 'sim_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') 
                    {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php";
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) 
                        {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') 
                    {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    $this->session->set_flashdata('error', lang("no_sim_selected"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }
            }
    }

    function import_csv()
    {
        $this->sma->checkPermissions('csv');
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) 
        {
            if (isset($_FILES["userfile"])) 
            {
                $this->load->library('upload');

                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $config['max_filename'] = 25;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) 
                {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("sim/import_csv");
                }

                $csv = $this->upload->file_name;
                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");

                if ($handle) {
                    while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }

                $titles = array_shift($arrResult);
                $keys = array('sim_number', 'use_sim_group_id', 'use_sim_type_id', 'use_sim_company_id', 'price', 'is_saled', 'is_has_identify_card', 'identify_card_picture', 'is_in_stock');
                $final = array();

                foreach ($arrResult as $key => $value) 
                {
                    $final[] = array_combine($keys, $value);
                }

                $rw = 2;
                $sim_numbers = array();
                $sim_groups = array();
                $sim_types = array();
                $sim_companies = array();
                $is_saled = array();
                $is_has_identify_card = array();
                $identify_card_picture = array();
                $is_in_stock = array();
                $price = array();

                foreach ($final as $csv_sim) 
                {
                     //"0" string concat for phone number 
                    if (!$this->sim_model->getSimNumber("0".trim($csv_sim['sim_number']))) 
                    {
                        $sim_numbers[] = "0".trim($csv_sim['sim_number']);
                        $sim_groups[]  = $this->sim_model->getSimGroupID(trim($csv_sim['use_sim_group_id']));
                        $sim_types[]  = $this->sim_model->getSimTypeID(trim($csv_sim['use_sim_type_id']));
                        $sim_companies[]  = $this->sim_model->getSimCompanyID(trim($csv_sim['use_sim_company_id']));
                            $is_saled[] = trim($csv_sim['is_saled']);
                            $is_has_identify_card[] = trim($csv_sim['is_has_identify_card']);
                            $identify_card_picture[] = trim($csv_sim['identify_card_picture']);
                            $is_in_stock[] = trim($csv_sim['is_in_stock']);
                            $price[] = trim($csv_sim['price']);

                    } else {
                        $this->session->set_flashdata('error', lang("check_sim_number") . " (0" . $csv_sim['sim_number'] . "). " . lang("sim_number_is_exist") . " " . lang("line_no") . " " . $rw);
                        redirect("sim/import_csv");
                    }

                    $rw++;
                }

                $items = array();
                foreach (array_map(null, $sim_numbers,$sim_groups,$sim_types,$sim_companies,$price,$is_saled,$is_has_identify_card,$identify_card_picture,$is_in_stock) as $ikey => $value) 
                {
                    $items[] = array_combine($keys, $value);
                }
            }
        }


        if ($this->form_validation->run() == true && $sims = $this->sim_model->add_sims($items)) 
        {
            $this->session->set_flashdata('message', sprintf(lang("add_sim_success"), $sims));
            redirect('sim');
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['userfile'] = array('name' => 'userfile',
                'id' => 'userfile',
                'type' => 'text',
                'value' => $this->form_validation->set_value('userfile')
            );

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('add_sim_by_csv')));
            $meta = array('page_title' => lang('add_sim_by_csv'), 'bc' => $bc);
            $this->page_construct('sim/import_sim', $meta, $this->data);

        }
    }

    function transfer_sim()
    {
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        
        $group_sim_result = $this->sim_model->getAllSimGroups();
        $this->data["sim_group"] = array("--------select sim group-------------");
        
        foreach ($group_sim_result as $value) 
        {
            $this->data["sim_group"][$value->id] = $value->name;
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('sim'), 'page' => lang('sim')), array('link' => '#', 'page' => lang('transfer_sim')));
        $meta = array('page_title' => lang('transfer_sim'), 'bc' => $bc);
        $this->page_construct('sim/transfer_sim', $meta, $this->data);
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

        if ($this->form_validation->run() == true) 
        {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'parent_id' => $this->input->post('parent'),
                );

            if ($_FILES['userfile']['size'] > 0) 
            {
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
                
                if (!$this->upload->do_upload()) 
                {
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

                if (!$this->image_lib->resize()) 
                {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) 
                {
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

        } elseif ($this->input->post('add_location')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/locations");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addLocation($data)) 
        {
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
        
        if ($this->input->post('code') != $pr_details->code) 
        {
            $this->form_validation->set_rules('code', lang("location_code"), 'is_unique[sim_locations.code]');
        }

        $this->form_validation->set_rules('name', lang("location_name"), 'required|min_length[3]');
        $this->form_validation->set_rules('userfile', lang("location_image"), 'xss_clean');

        if ($this->form_validation->run() == true) 
        {
            $data = array(
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'parent_id' => $this->input->post('parent'),
                );

            if ($_FILES['userfile']['size'] > 0) 
            {
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

                if (!$this->upload->do_upload()) 
                {
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

                if (!$this->image_lib->resize()) 
                {
                    echo $this->image_lib->display_errors();
                }
                if ($this->Settings->watermark) 
                {
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

        } elseif ($this->input->post('edit_location')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/locations");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateLocation($id, $data)) 
        {
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
        if ($this->site->getSubLocations($id)) 
        {
            $this->session->set_flashdata('error', lang("location_has_sublocation"));
            redirect("sim/locations");
        }

        if ($this->sim_model->deleteLocation($id)) 
        {
            echo lang("location_deleted");
        }
    }

    function location_actions()
    {
        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) 
        {
            if (!empty($_POST['val'])) 
            {
                if ($this->input->post('form_action') == 'delete') 
                {
                    foreach ($_POST['val'] as $id) 
                    {
                        $this->sim_model->deleteLocation($id);
                    }
                    $this->session->set_flashdata('message', lang("locations_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') 
                {
                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('locations'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('code'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('image'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('parent_location'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) 
                    {
                        $sc = $this->sim_model->getLocationByID($id);
                        $parent_actegory = '';

                        if ($sc->parent_id) 
                        {
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
                    if ($this->input->post('form_action') == 'export_pdf') 
                    {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) 
                        {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') 
                    {
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

        echo $this->datatables->generate();
    }

    function add_sim_company()
    {
        $this->form_validation->set_rules('name', lang("sim_companies"), 'trim|is_unique[sim_companies.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_company')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_companies");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimCompany($data)) 
        {
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
        $this->form_validation->set_rules('name', lang("sim_companies"), 'trim|required|alpha_numeric_spaces');

        $pg_details = $this->sim_model->getSimCompanyByID($id);
        if ($this->input->post('name') != $pg_details->name) 
        {
            $this->form_validation->set_rules('name', lang("sim_company"), 'is_unique[sim_companies.name]');
        }

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_company')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_companies");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimCompany($id, $data)) 
        {
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

        echo $this->datatables->generate();
    }

    function add_sim_type()
    {
        $this->form_validation->set_rules('name', lang("sim_types"), 'trim|is_unique[sim_types.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_type')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimType($data)) 
        {
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
        if ($this->input->post('name') != $pg_details->name) 
        {
            $this->form_validation->set_rules('name', lang("sim_type"), 'is_unique[sim_types.name]');
        }

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_type')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimType($id, $data)) 
        {
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
        if ($this->sim_model->deleteSimType($id)) 
        {
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

        echo $this->datatables->generate();
    }

    function add_sim_stock_type()
    {
        $this->form_validation->set_rules('name', lang("sim_stock_types"), 'trim|is_unique[sim_stock_types.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_stock_type')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_stock_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->addSimStockType($data)) 
        {
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
        $this->form_validation->set_rules('name', lang("sim_stock_types"), 'trim|required|alpha_numeric_spaces');

        $pg_details = $this->sim_model->getSimStockTypeByID($id);
        if ($this->input->post('name') != $pg_details->name) 
        {
            $this->form_validation->set_rules('name', lang("sim_stock_types"), 'is_unique[sim_stock_types.name]');
        }

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_stock_type')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_stock_types");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimStockType($id, $data)) 
        {
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
        if ($this->sim_model->deleteSimStockType($id)) 
        {
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

        if ($this->form_validation->run() == true) 
        {
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
        if ($this->form_validation->run() == true) 
        {
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

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') 
                {
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
                        
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) 
                        {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') 
                    {
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

        echo $this->datatables->generate();
    }

    function add_sim_group()
    {
        $this->form_validation->set_rules('name', lang("sim_groups"), 'trim|is_unique[sim_groups.name]|required|alpha_numeric_spaces');

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('add_sim_group')) 
        {
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
        $this->form_validation->set_rules('name', lang("sim_groups"), 'trim|required|alpha_numeric_spaces');

        $pg_details = $this->sim_model->getSimGroupByID($id);
        if ($this->input->post('name') != $pg_details->name) 
        {
            $this->form_validation->set_rules('name', lang("sim_group"), 'is_unique[sim_groups.name]');
        }

        if ($this->form_validation->run() == true) 
        {
            $data = array('name' => $this->input->post('name'));
        } elseif ($this->input->post('edit_sim_group')) 
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect("sim/sim_groups");
        }

        if ($this->form_validation->run() == true && $this->sim_model->updateSimGroup($id, $data)) 
        {
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
        if ($this->sim_model->deleteSimGroup($id)) 
        {
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
    
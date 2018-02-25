<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-edit"></i><?= lang('edit_sim'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("sim/edit_sim/".$sim->id, $attrib);
                
                ?>
                <div class="col-md-5">
                    <div class="form-group all">
                        <?= lang("sim_number", "sim_number") ?>
                        <?= form_input('sim_number',(isset($_POST['sim_number']) ? $_POST['sim_number'] : ($sim?$sim->sim_number:'')),'class="form-control" id="sim_number" required="required"'); ?>
                    </div>
                    <div class="form-group all">
                        <?= lang("price", "price") ?>
                        <?= form_input('price',(isset($_POST['price']) ? $_POST['price'] : ($sim?$sim->price:'')),'class="form-control" id="price" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("sim_groups", "sim_group") ?>
                        <?php
                        echo form_dropdown('sim_group', $sim_group, (isset($_POST['sim_group']) ? $_POST['sim_group'] : ($sim?$sim->use_sim_group_id:'')), 'class="form-control" id="sim_group" required="required"');
                        ?>
                    </div>
                    <div class="form-group">
                        <?= lang("sim_types", "sim_type") ?>
                        <?php
                        echo form_dropdown('sim_type', $sim_type, (isset($_POST['sim_type']) ? $_POST['sim_type'] : ($sim?$sim->use_sim_type_id:'')), 'class="form-control" id="sim_type" required="required"');
                        ?>
                    </div>
                    <div class="form-group">
                        <?= lang("sim_companies", "sim_company") ?>
                        <?php
                        echo form_dropdown('sim_company', $sim_company, (isset($_POST['sim_company']) ? $_POST['sim_company'] : ($sim?$sim->use_sim_company_id:'')), 'class="form-control" id="sim_company" required="required"');
                        ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <?= lang("sale_status", "is_saled") ?>
                        <?php
                        $isSale = array("0" => "No","1" => "Yes");
                        echo form_dropdown('is_saled', $isSale, (isset($_POST['is_saled']) ? $_POST['is_saled'] : ($sim?$sim->is_saled:'')), 'class="form-control" id="is_saled" required="required"');
                        ?>
                    </div>
                    <div class="form-group">
                        <?= lang("status", "in_stock") ?>
                        <?php
                        $in_stock = array("0" => "In Stock","1" => "Out Stock");
                        echo form_dropdown('in_stock', $in_stock, (isset($_POST['in_stock']) ? $_POST['in_stock'] : ($sim?$sim->is_in_stock:'')), 'class="form-control" id="in_stock" required="required"');
                        ?>
                    </div>
                    <div class="form-group">
                        <?= lang("identify_card_status", "identify_card") ?>
                        <?php
                        $identify_card = array("0" => "No","1" => "Yes");
                        echo form_dropdown('identify_card', $identify_card, (isset($_POST['identify_card']) ? $_POST['identify_card'] : ($sim?$sim->is_has_identify_card:'')), 'class="form-control" id="identify_card" required="required"');
                        ?>
                    </div>
                    <div class="form-group all">
                        <?= lang("identify_card", "identify_image") ?>
                        <input id="identify_image" type="file" data-browse-label="<?= lang('browse'); ?>" name="identify_image" data-show-upload="false"
                               data-show-preview="false" accept="image/*" class="form-control file">
                    </div>
                    <div class="form-group">
                        <?php echo form_submit('update_sim', $this->lang->line("update_sim"), 'class="btn btn-primary"'); ?>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
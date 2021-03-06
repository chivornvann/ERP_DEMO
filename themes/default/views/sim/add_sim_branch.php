<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_sim_branch'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("sim/add_sim_branch", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="form-group">
                <?= lang("shop *", "shop") ?>
                <?php
                $cat[''] = lang('select').' '.lang('shop');
                foreach ($shops as $pcat) {
                    $cat[$pcat->id] = $pcat->shop;
                }
                echo form_dropdown('use_sim_shop_id', $cat, (isset($_POST['use_sim_shop_id']) ? $_POST['use_sim_shop_id'] : ''), 'class="form-control select" id="use_sim_shop_id" style="width:100%" required="required"')
                ?>
            </div>
            <div class="form-group">
                <label class="control-label" for="branch_name"><?php echo $this->lang->line("branch"); ?></label>

                <div
                    class="controls"> <?php echo form_input('branch_name', '', 'class="form-control" id="branch_name" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>

                <div
                    class="controls"> <?php echo form_input('phone', '', 'class="form-control" id="phone" required="required"'); ?> </div>
            </div>

            <!--<div class="form-group">
                <label class="control-label" for="use_sim_location"><?php echo $this->lang->line("location"); ?></label>

                <div
                    class="controls"> <?php echo form_input('use_sim_location', '', 'class="form-control" id="use_sim_location" required="required"'); ?> </div>
            </div>-->

            <div class="form-group">
                <?= lang("location *", "location") ?>
                <?php
                $cat[''] = lang('select').' '.lang('location');
                foreach ($locations as $pcat) {
                    $cat[$pcat->id] = $pcat->name;
                }
                echo form_dropdown('use_sim_location', $cat, (isset($_POST['use_sim_location']) ? $_POST['use_sim_location'] : ''), 'class="form-control select" id="use_sim_location" style="width:100%" required="required"')
                ?>
            </div>

            <div class="form-group">
                <label class="control-label" for="contact_name"><?php echo $this->lang->line("contact_name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('contact_name', '', 'class="form-control" id="contact_name"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="facebook_name"><?php echo $this->lang->line("facebook_name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('facebook_name', '', 'class="form-control" id="facebook_name"'); ?> </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sim_branch', lang('add_sim_branch'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>

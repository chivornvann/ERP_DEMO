<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_sim_shop'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("sim/edit_sim_shop/" . $id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label class="control-label" for="shop"><?php echo $this->lang->line("shop"); ?></label>

                <div
                    class="controls"> <?php echo form_input('shop', $sim_shops->shop, 'class="form-control" id="shop" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>

                <div
                    class="controls"> <?php echo form_input('phone', $sim_shops->phone, 'class="form-control" id="phone" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="use_sim_location"><?php echo $this->lang->line("location"); ?></label>

                <div
                    class="controls"> <?php echo form_input('use_sim_location', $sim_shops->use_sim_location, 'class="form-control" id="use_sim_location" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="contact_name"><?php echo $this->lang->line("contact_name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('contact_name', $sim_shops->contact_name, 'class="form-control" id="contact_name"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="facebook_name"><?php echo $this->lang->line("facebook_name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('facebook_name', $sim_shops->facebook_name, 'class="form-control" id="facebook_name"'); ?> </div>
            </div>
           
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_sim_shop', lang('edit_sim_shop'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_sim_group'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("sim_sale_consignments/addGroupToShop/".$this->uri->segment(3), $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label for="name"><?php echo $this->lang->line("sim_groups"); ?></label>
                <?php
                $gr[''] = lang('select').' a '.lang('group');
                foreach ($groups as $g) {
                    $gr[$g->id] = $g->name;
                }
                echo form_dropdown('group', $gr, (isset($_POST['parent']) ? $_POST['parent'] : ''), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sim_group', lang('add_sim_group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?= $modal_js ?>
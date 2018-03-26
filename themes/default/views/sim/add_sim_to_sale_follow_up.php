<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_sim'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("sim_sale_follow_ups/addMoreSims/".$this->uri->segment(3), $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

           <div class="form-group">
                <?= lang("Sim", "simGroupLabel"); ?><br/>
                <select class="multipleSelect" multiple name="sims[]" required="required" style="width: width: -webkit-fill-available;">
                    <?php 
                        foreach ($sims as $s) {
                            echo '<option value="'.$s->id.'">'.$s->sim_number.'</option>';
                        }
                    ?>
                </select>
          </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sim', lang('add_sim'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?= $modal_js ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_sim_group'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("sim/edit_sim_group/" . $id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="form-group">
                <?= lang("group_type *", "group_type") ?>
                <?php
                $group[''] = lang('select').' '.lang('group_type');
                foreach ($group_type as $row) {
                    $group[$row->id] = $row->name;
                }
                echo form_dropdown('group_type', $group, (isset($_POST['group_type']) ? $_POST['group_type'] : $sim_group->use_sim_main_group_id), 'class="form-control select" required="required" id="base_sim_group" style="width:100%"')
                ?>
            </div>

            <div class="form-group">
                <label class="control-label" for="name"><?php echo $this->lang->line("sim_groups"); ?></label>
                
                <?php echo form_input('name_input', $sim_group->name, 'class="form-control" id="name_input" required="required" disabled'); ?>
                <input type="hidden" name="name" id="name" value="">
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_sim_group', lang('edit_sim_group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#base_sim_group').change(function(e) {
            var bsg = $(this).val();
            $.get(site.base_url+'sim/get_base_sim_group/' + bsg, function(result){
                
                $('#name').val(result);
                $('#name_input').val(result);
            });
        });
    });
</script>
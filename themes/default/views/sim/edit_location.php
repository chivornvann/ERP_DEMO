<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_location'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("sim/edit_location/".$location->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('update_info'); ?></p>

            <div class="form-group">
                <?= lang('location_code', 'code'); ?>
                <?= form_input('code', set_value('code', $location->code), 'class="form-control" id="code" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang('location_name', 'name'); ?>
                <?= form_input('name', set_value('name', $location->name), 'class="form-control" id="name" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang("location_image", "image") ?>
                <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" data-show-upload="false" data-show-preview="false" class="form-control file">
            </div>
            <div class="form-group">
                <?= lang("parent_location", "parent") ?>
                <?php
                $cat[''] = lang('select').' '.lang('parent_location');
                foreach ($locations as $pcat) {
                    $cat[$pcat->id] = $pcat->name;
                }
                echo form_dropdown('parent', $cat, (isset($_POST['parent']) ? $_POST['parent'] : $location->parent_id), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_location', lang('edit_location'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
</script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add sale consignment'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("sim_sale_consignments/add_sale_consignment", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
             <div class="form-group">
                <?= lang("Consign date", "datelbl"); ?>
                <?php echo form_input('conDate', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="sldate" required="required"'); ?>
             </div>

             <div class="form-group">
                <?= lang("Shop", "shoplbl") ?>
                <?php
                $sh[''] = lang('select').' a '.lang('shop');
                foreach ($shops as $s) {
                    $sh[$s->id] = $s->shop;
                }
                echo form_dropdown('shop', $sh, (isset($_POST['parent']) ? $_POST['parent'] : ''), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>

            <div class="form-group">
                <?= lang("Branch", "branchlbl") ?>
                <?php
                $br[''] = lang('select').' a '.lang('branch');
                $locat[''] = '';
                foreach ($branches as $b) {
                    foreach ($locations as $lo) {
                        $br[$b->id] = $lo->name.' ('.$b->branch_name.')';
                    }
                }
                echo form_dropdown('branch', $br, (isset($_POST['parent']) ? $_POST['parent'] : ''), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>

            <div class="form-group">
                <?= lang("Sim Group", "simGroupLabel"); ?><br/>
                <select class="multipleSelect" multiple name="sgroup[]" required="required" style="width: width: -webkit-fill-available;">
                    <?php 
                        foreach ($groups as $g) {
                            echo '<option value="'.$g->id.'">'.$g->name.'</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <?= lang('Reference note', 'notelbl'); ?>
                <?= form_input('note', set_value('code'), 'class="form-control" id="code" required="required"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sale_consignment', lang('add sale consignment'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
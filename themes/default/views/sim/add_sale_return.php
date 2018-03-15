<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
</script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add sale return'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("sim_sale_returns/add_sale_return", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

             <div class="form-group">
                <?= lang("Return date", "datelbl"); ?>
                <?php echo form_input('returnDate', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="sldate" required="required"'); ?>
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
                <?= lang("Sim group", "sgrouplbl") ?>
                 <div class="input-group wide-tip">
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                        <i class="fa fa-2x fa-barcode addIcon"></i></a></div>
                    <?php echo form_input('sgroup', '', 'class="form-control input-lg" id="add_item" placeholder="' . lang("Please add sim group") . '"'); ?>
                </div>
            </div>


           <!--   <?= lang("Sim group", "sgrouplbl") ?>
             <div class="col-md-12" id="sticker">
                <div class="well well-sm">
                    <div class="form-group" style="margin-bottom:0;">
                        <div class="input-group wide-tip">
                            <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                <i class="fa fa-2x fa-barcode addIcon"></i></a></div>
                            <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . lang("add_product_to_order") . '"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div> -->

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sale_return', lang('add sale return'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
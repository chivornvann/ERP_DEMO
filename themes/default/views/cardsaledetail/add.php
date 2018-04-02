<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $("#reset_card_sale_detail").click(function() {
        window.location.reload();
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('add_card_sale_detail'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                    $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                    echo form_open_multipart("cardsaledetail/add", $attrib)
                ?>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="row" id="card_infor">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("quality", "quality"); ?>
                                        <?php echo form_input('quality', '', 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('quality') . '" id="quality"  required="required"' ); ?>
                                    </div>
                                </div>
                        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('card_item', 'card_item') ?>
                                        <?php
                                        $tr_item[""] = "";
                                        foreach ($card_item_name as $citem) {
                                            $tr_item[$citem['id']] = $citem['code'];
                                        }
                                        echo form_dropdown('card_item', $tr_item, "", 'id="card_item" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("card_item"));
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('card_sale', 'card_sale') ?>
                                        <?php
                                        $tr_csn[""] = "";
                                        foreach ($card_sale_name as $csn) {
                                            $tr_csn[$csn['id']] = $csn['title'];
                                        }
                                        echo form_dropdown('card_sale', $tr_csn, "", 'id="card_sale" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("card_sale"));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div
                                class="from-group"><?php echo form_submit('add_card_sale_detail', $this->lang->line("submit"), 'id="add_card_sale_detail" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset_card_sale_detail"><?= lang('reset') ?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

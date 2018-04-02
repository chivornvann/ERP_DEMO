<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
	
    $(document).ready(function () {
       
        $('#reset_card_sale_detail').click(function (e) { 
            window.location.reload(true);
        });
        $('#edit_card_sale').click(function () {
            $('form.edit-card-sale-detail-form').submit();
        });
    });

</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('edit_card_sale_detail'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-card-sale-detail-form');
                    echo form_open_multipart("cardsaledetail/edit/" . $id, $attrib)
                ?>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="row" id="card_infor">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("quality", "quality"); ?>
                                        <?php echo form_input('quality', (isset($_POST['quality']) ? $_POST['quality'] : ($card_sale_detail_infor ? $card_sale_detail_infor[0]['quality'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('quality') . '" id="quality"  required="required"' ); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('card_item', 'card_item') ?>
                                        <?php
                                        $tr_br[""] = "";
                                        foreach ($card_item_name as $carditem) {
                                            $tr_br[$carditem['id']] = $carditem['code'];
                                        }
                                        echo form_dropdown('card_item', $tr_br,(isset($_POST['card_item']) ? $_POST['card_item'] : ($card_sale_detail_infor ? $card_sale_detail_infor[0]['use_card_item_id'] : '')) , 'id="card_item" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("card_item"));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('card_sale', 'card_sale') ?>
                                        <?php
                                        $tr_sale[""] = "";
                                        foreach ($card_sale_name as $cardsale) {
                                            $tr_sale[$cardsale['id']] = $cardsale['title'];
                                        }
                                        echo form_dropdown('card_sale', $tr_sale,(isset($_POST['card_sale']) ? $_POST['card_sale'] : ($card_sale_detail_infor ? $card_sale_detail_infor[0]['use_sale_card_id'] : '')) , 'id="card_sale" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("card_sale"));
                                        ?>
                                    </div>
                                </div>
                                
                                 
                                
                            </div>
                        <div class="col-md-12">
                            <div
                                class="from-group"><?php echo form_submit('reset_card_sale_detail', $this->lang->line("submit"), 'id="reset_card_sale_detail" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
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

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
	
    $(document).ready(function () {
        $("#date_sale_card_sale").datetimepicker({
            format: site.dateFormats.js_ldate,
            fontAwesome: true,
            language: 'sma',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        }).datetimepicker('update', new Date());
        $('#reset_card_sale').click(function (e) { 
            window.location.reload(true);
        });
   
        <?php if ($card_sale_infor) { ?>
            localStorage.setItem('date_sale_card_sale', '<?= date($dateFormats['php_ldate'], strtotime($card_sale_infor[0]['date_sale']))?>');
            localStorage.setItem('reference_note', '<?= str_replace(array("\r", "\n"), "", $this->sma->decode_html($card_sale_infor[0]['reference_noted'])); ?>');
        <?php } ?>
        <?php if ($Owner || $Admin) { ?>
            $(document).on('change', '#date_sale_card_sale', function (e) {
                localStorage.setItem('date_sale_card_sale', $(this).val());
            });
            if (date_sale = localStorage.getItem('date_sale_card_sale')) {
                $('#date_sale_card_sale').val(date_sale);
            }
        <?php } ?>
        
        $('#edit_card_sale').click(function () {
            $('form.edit-card-sale-form').submit();
        });
    });

</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('edit_card_sale'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-card-sale-form');
                    echo form_open_multipart("cardsale/edit/" . $id, $attrib)
                ?>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="row" id="card_infor">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("title", "title"); ?>
                                        <?php echo form_input('title', (isset($_POST['title']) ? $_POST['title'] : ($card_sale_infor ? $card_sale_infor[0]['title'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('title') . '" id="title"  required="required"' ); ?>
                                    </div>
                                </div>
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("date_sale", "date_sale"); ?>
                                        <?php echo form_input('date_sale_card_sale',(isset($_POST['date_sale_card_sale']) ? $_POST['date_sale_card_sale'] : ""), 'class="form-control input-tip" id="date_sale_card_sale" required="required"'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('card_branch_name', 'card_branch_name') ?>
                                        <?php
                                        $tr_br[""] = "";
                                        foreach ($card_branch_name as $csi) {
                                            $tr_br[$csi['id']] = $csi['branch_name'];
                                        }
                                        echo form_dropdown('card_branch_name', $tr_br,(isset($_POST['card_branch_name']) ? $_POST['card_branch_name'] : ($card_sale_infor ? $card_sale_infor[0]['use_card_branch_id'] : '')) , 'id="card_branch_name" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("card_branch_name"));
                                        ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <?= lang("reference_note", "reference_note"); ?>
                                    <?php echo form_textarea('reference_note', (isset($_POST['reference_note']) ? $_POST['reference_note'] : ($card_sale_infor ? $card_sale_infor[0]['reference_noted'] : '')), 'class="form-control" id="reference_note" style="margin-top: 10px; height: 100px;"'); ?>
                                </div>
                            </div>
                        <div class="col-md-12">
                            <div
                                class="from-group"><?php echo form_submit('edit_card_sale', $this->lang->line("submit"), 'id="edit_card_sale" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset_card_sale"><?= lang('reset') ?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

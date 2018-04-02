<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
	
	$(document).ready(function () {
        $("#date_sale").datetimepicker({
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
        <?php if ($card_infor) { ?>
            localStorage.setItem('date_sale', '<?= date($dateFormats['php_ldate'], strtotime($card_infor[0]['date_sale']))?>');
            localStorage.setItem('reference_note', '<?= str_replace(array("\r", "\n"), "", $this->sma->decode_html($card_infor[0]['reference_note'])); ?>');
        <?php } ?>
        <?php if ($Owner || $Admin) { ?>
            $(document).on('change', '#date_sale', function (e) {
                localStorage.setItem('date_sale', $(this).val());
            });
            if (date_sale = localStorage.getItem('date_sale')) {
                $('#date_sale').val(date_sale);
            }
        <?php } ?>
        $('#reset_card').click(function (e) { 
            window.location.reload(true);
        });
        $('#edit_card').click(function () {
            $('form.edit-card-form').submit();
        });
    });

</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('edit_card'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-card-form');
                    echo form_open_multipart("card/edit/" . $id, $attrib)
                ?>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="row" id="card_infor">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('company_name', 'company_name') ?>
                                        <?php
                                        $tr[""] = "";
                                        foreach ($company_infor as $com) {
                                            $tr[$com['id']] = $com['name'];
                                        }
                                        echo form_dropdown('company_name', $tr,(isset($_POST['company_name']) ? $_POST['company_name'] : ($card_infor ? $card_infor[0]['company_id'] : '')), 'id="company_name" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("company_name") );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("code", "card_code"); ?>
                                        <?php echo form_input('card_code', (isset($_POST['card_code']) ? $_POST['card_code'] : ($card_infor ? $card_infor[0]['code'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('code') . '" id="card_code"  required="required"' ); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("date_sale", "date_sale"); ?>
                                        <?php echo form_input('date_sale',(isset($_POST['date_sale']) ? $_POST['date_sale'] : ""), 'class="form-control input-tip" id="date_sale" required="required"'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('branch_name', 'branch_name') ?>
                                        <?php
                                        $tr_br[""] = "";
                                        foreach ($branch_infor as $br) {
                                            $tr_br[$br['id']] = $br['branch_name'];
                                        }
                                        echo form_dropdown('branch_name', $tr_br,(isset($_POST['branch_name']) ? $_POST['branch_name'] : ($card_infor ? $card_infor[0]['branch_id'] : '')), 'id="branch_name" class="form-control input-tip select" style="width:100%;" required="required" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("branch_name"));
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("price", "card_price"); ?>
                                        <?php echo form_input('card_price', (isset($_POST['card_price']) ? $_POST['card_price'] : ($card_infor ? $card_infor[0]['price'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('card_price') . '" id="card_price"  required="required"' ); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("quality", "card_quality"); ?>
                                        <?php echo form_input('card_quality', (isset($_POST['card_quality']) ? $_POST['card_quality'] : ($card_infor ? $card_infor[0]['quality'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('card_quality') . '" id="card_quality" required="required"'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("commission", "card_commission"); ?>
                                        <?php echo form_input('card_commission',(isset($_POST['card_commission']) ? $_POST['card_commission'] : ($card_infor ? $card_infor[0]['commission'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('card_commission') . '" id="card_commission"'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("unit_price", "card_unit_price"); ?>
                                        <?php echo form_input('card_unit_price',(isset($_POST['card_unit_price']) ? $_POST['card_unit_price'] : ($card_infor ? $card_infor[0]['unit_price'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('card_unit_price') . '" id="card_unit_price" required="required"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <?= lang("reference_note", "reference_note"); ?>
                                <?php echo form_textarea('reference_note', (isset($_POST['reference_note']) ? $_POST['reference_note'] : ($card_infor ? $card_infor[0]['reference_note'] : '')), 'class="form-control" id="reference_note" style="margin-top: 10px; height: 100px;"'); ?>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div
                                class="from-group"><?php echo form_submit('edit_card', $this->lang->line("submit"), 'id="edit_card" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset_card"><?= lang('reset') ?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

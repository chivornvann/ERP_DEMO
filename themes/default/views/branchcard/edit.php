<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
	
	$(document).ready(function () {
        $('#reset_branch_card').click(function (e) { 
            window.location.reload(true);
        });
        $('#edit_branch_card').click(function () {
            $('form.edit-branch-card-form').submit();
        });
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('edit_branch_card'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-branch-card-form');
                    echo form_open_multipart("branchcard/edit/". $id, $attrib)
                ?>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="row" id="branch_card_infor">
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("branch_name", "branch_name"); ?>
                                        <?php echo form_input('branch_name', (isset($_POST['branch_name']) ? $_POST['branch_name'] : ($branch_card_infor ? $branch_card_infor[0]['branch_name'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('branch_name') . '" id="branch_name"  required="required"' ); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("phone", "branch_card_phone"); ?>
                                        <?php echo form_input('branch_card_phone', (isset($_POST['branch_card_phone']) ? $_POST['branch_card_phone'] : ($branch_card_infor ? $branch_card_infor[0]['phone'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('phone') . '" id="branch_card_phone"  required="required"' ); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("contact_name", "contact_name"); ?>
                                        <?php echo form_input('contact_name', (isset($_POST['contact_name']) ? $_POST['contact_name'] : ($branch_card_infor ? $branch_card_infor[0]['contact_name'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('contact_name') . '" id="contact_name" required="required"'); ?>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang("facebook_name", "facebook_name"); ?>
                                        <?php echo form_input('facebook_name', (isset($_POST['facebook_name']) ? $_POST['facebook_name'] : ($branch_card_infor ? $branch_card_infor[0]['facebook_name'] : '')), 'class="form-control tip" data-trigger="focus" data-placement="top" title="' . lang('facebook_name') . '" id="facebook_name"'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('has_special_book', 'has_special_book') ?>
                                        <?php
                                        $tr_has_special_book[""] = "";
                                        foreach ($hasSpecialBook as $spbook) {
                                            $tr_has_special_book[$spbook['id']] = $spbook['name'];
                                        }
                                        echo form_dropdown('has_special_book', $tr_has_special_book, (isset($_POST['has_special_book']) ? $_POST['has_special_book'] : ($branch_card_infor ? $branch_card_infor[0]['is_has_special_book'] : '')), 'id="has_special_book" class="form-control input-tip select" style="width:100%;" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("has_special_book") );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('has_stamp_shop', 'has_stamp_shop') ?>
                                        <?php
                                        $tr_has_stamp_shop[""] = "";
                                        foreach ($hasStampShop as $stampShop) {
                                            $tr_has_stamp_shop[$stampShop['id']] = $stampShop['name'];
                                        }
                                        echo form_dropdown('has_stamp_shop', $tr_has_stamp_shop, (isset($_POST['has_stamp_shop']) ? $_POST['has_stamp_shop'] : ($branch_card_infor ? $branch_card_infor[0]['is_has_stamp_shop'] : '')), 'id="has_stamp_shop" class="form-control input-tip select" style="width:100%;" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("has_stamp_shop") );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('shop', 'branch_card_shop') ?>
                                        <?php
                                        $tr_bcs[""] = "";
                                        foreach ($branch_card_shop as $bcs) {
                                            $tr_bcs[$bcs['id']] = $bcs['shop'];
                                        }
                                        echo form_dropdown('branch_card_shop', $tr_bcs, (isset($_POST['branch_card_shop']) ? $_POST['branch_card_shop'] : ($branch_card_infor ? $branch_card_infor[0]['use_card_shop_id'] : '')), 'id="branch_card_shop" class="form-control input-tip select" style="width:100%;" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("shop") );
                                        ?>
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <?= lang('location', 'branch_card_location') ?>
                                        <?php
                                        $tr_lo[""] = "";
                                        foreach ($branch_card_location as $lo) {
                                            $tr_lo[$lo['id']] = $lo['location'];
                                        }
                                        echo form_dropdown('branch_card_location', $tr_lo, (isset($_POST['branch_card_location']) ? $_POST['branch_card_location'] : ($branch_card_infor ? $branch_card_infor[0]['use_card_location_id'] : '')), 'id="branch_card_location" class="form-control input-tip select" style="width:100%;"  data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("location") );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="col-md-12">
                            <div
                                class="from-group"><?php echo form_submit('edit_branch_card', $this->lang->line("submit"), 'id="edit_branch_card" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset_branch_card"><?= lang('reset') ?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

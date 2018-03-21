<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('count_stock'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'stForm');
                echo form_open_multipart("sim_sale/search", $attrib);
                ?>
                <div class="row">
                    <div class="col-lg-12">

                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "date"); ?>
                                    <?php echo form_input('date','', 'class="form-control input-tip" id="date" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("biller", "slbiller"); ?>
                                <?php
                                $bl[""] = "";
                                foreach ($billers as $biller) {
                                        $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $Settings->default_biller), 'id="slbiller" data-placeholder="' . lang("select") . ' ' . lang("biller") . '" required="required" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="fprom-group">
                                <?= form_submit('count_stock', lang("search"), 'id="count_stock" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="PRData" class="table table-bordered table-condensed table-hover table-striped">
                                    <thead>
                                        <tr class="primary">
                                            <th><?= lang("sim_companies") ?></th>
                                            <th><?= lang("price") ?></th>
                                        </tr>
                                    </thead>
                                <?php 
                                    if($result){
                                ?>
                                    <tbody>

                                    <?php 
                                    $total = 0;
                                    foreach ($result as $value ) {
                                        $total += $value->price; 
                                    ?>
                                        <tr>
                                            <td><?= $value->sim_company ?></td>
                                            <td><?= $this->sma->formatMoney($value->price) ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot class="dtFilter">
                                        <tr class="active">
                                            <th><?= lang("total") ?></th>
                                            <th><?= $this->sma->formatMoney($total) ?></th>
                                        </tr>
                                    </tfoot>
                                <?php }else { ?>
                                        <tr>
                                           <td colspan="11" class="dataTables_empty">No Result found.</td> 
                                        </tr>
                               <?php } ?>
                                </table>
                            </div>
                        </div>
                </div>
                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#date").datetimepicker({format: 'yyyy-mm-dd',  minView: 2, todayBtn: 1, autoclose: 1});
        
    });
</script>
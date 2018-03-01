<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        $("#to_sim_group").attr('disabled', true);
        $("#btn-submit").attr('disabled', true);
        $("#action-form").change(function(){
            if ($("#from_sim_group").val() == 0 || $("#to_sim_group").val() == 0) {
                $("#btn-submit").attr('disabled', true);
            } else {
                $("#btn-submit").attr('disabled', false);
            }
        });
        $("#from_sim_group").change(function(e) {
            var current_sim_group = this.value;
            if (current_sim_group != 0) {
                $("#to_sim_group").attr('disabled', false);
            }else{
                $("#to_sim_group").attr('disabled', true);
            }
            $("#to_sim_group option").each(function(e) {
                var $thisOption = $(this);

                $thisOption.attr('disabled',false);
                if($thisOption.val() == current_sim_group) {
                    $thisOption.attr("disabled", true);
                }
            });

            if (e.added.id != 0) {
                    $('#CGData').dataTable({
                    "aaSorting": [[1, "asc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= site_url('sim/get_sim_by_group') ?>/'+ this.value,
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                    },
                     "bDestroy": true,
                    "aoColumns": 
                    [
                        {"bSortable": false,"mRender": checkbox},null,null,null,null,{"mRender": sale_status},{"mRender": identify_card_status},{"mRender" :img_hl},{"mRender": stock_status},{"mRender": currencyFormat}
                    ]
                });

            }
        });
    });
</script>
<?= form_open('sim/action_transfer_sim', 'id="action-form"') ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-building"></i><?= $page_title ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <?= lang("from_sim_group", "from_sim_group") ?>
                        <?php
                        echo form_dropdown('from_sim_group', $sim_group, (isset($_POST['from_sim_group']) ? $_POST['from_sim_group'] : ''), 'class="form-control" id="from_sim_group" required="required"');
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?= lang("to_sim_group", "to_sim_group") ?>
                        <?php
                        echo form_dropdown('to_sim_group', $sim_group, (isset($_POST['to_sim_group']) ? $_POST['to_sim_group'] : ''), 'class="form-control" id="to_sim_group" required="required"');
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label></label>
                        <?php echo form_submit('add_sim', $this->lang->line("submit"), 'class="btn btn-primary" id="btn-submit" style="margin-top:30px;"'); ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="CGData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th><?php echo $this->lang->line("sim_number"); ?></th>
                            <th><?php echo $this->lang->line("sim_groups"); ?></th>
                            <th><?php echo $this->lang->line("sim_types"); ?></th>
                            <th><?php echo $this->lang->line("sim_companies"); ?></th>
                            <th><?php echo $this->lang->line("sale_status"); ?></th>
                            <th><?php echo $this->lang->line("identify_card_status"); ?></th>
                            <th><?php echo $this->lang->line("identify_card"); ?></th>
                            <th><?php echo $this->lang->line("status"); ?></th>
                            <th><?php echo $this->lang->line("price"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
</div>
<?= form_close() ?>
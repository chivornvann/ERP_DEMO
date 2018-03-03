<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        $('#CGData').dataTable({
            "aaSorting": [[1, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('sim/getSim') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": 
            [
                {"bSortable": false,"mRender": checkbox},{"bVisible": false},{
                    "fnRender": function( obj ) {
                        if(obj.aData[1] == null){
                            return 'N/A';
                        }else{
                            return '<a href="sim/view_sim_by_group/' + obj.aData[1] + '">' + obj.aData[2] + '</a>';
                        }
                    

                }
                },null,{"mRender": currencyFormat},null,null,{"mRender" :img_hl},{"mRender": identify_card_status},{"mRender": sale_status},{"mRender": stock_status},{"bSortable": false}
            ]
        });
    });
</script>
<?= form_open('sim/sim_actions', 'id="action-form"') ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-th-list"></i><?= $page_title ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <a href="<?= site_url('sim/add') ?>">
                                <i class="fa fa-plus-circle"></i> <?= lang('add_sim') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sim/import_csv') ?>">
                                <i class="fa fa-plus-circle"></i> <?= lang('import_sim') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fa fa-file-excel-o"></i> <?= lang('export_excel') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="pdf" data-action="export_pdf">
                                <i class="fa fa-file-pdf-o"></i> <?= lang('export_pdf') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="delete" data-action="delete">
                                <i class="fa fa-trash-o"></i> <?= lang('delete_sim') ?>
                            </a>
                        </li>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>

                <div class="table-responsive">
                    <table id="CGData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th>Empty</th>
                            <th><?php echo $this->lang->line("sim_groups"); ?></th>
                            <th><?php echo $this->lang->line("sim_number"); ?></th>
                            <th><?php echo $this->lang->line("price"); ?></th>
                            <th><?php echo $this->lang->line("sim_types"); ?></th>
                            <th><?php echo $this->lang->line("sim_companies"); ?></th>
                            <th><?php echo $this->lang->line("identify_card"); ?></th>
                            <th><?php echo $this->lang->line("identify_card_status"); ?></th>                            
                            <th><?php echo $this->lang->line("sale_status"); ?></th>
                            <th><?php echo $this->lang->line("status"); ?></th>
                            
                            <th style="max-width:85px;"><?php echo $this->lang->line("actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script language="javascript">
    $(document).ready(function () {

        $('#delete').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#excel').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#pdf').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

    });
</script>


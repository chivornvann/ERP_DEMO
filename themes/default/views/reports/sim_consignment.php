<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

$v = "";
/* if($this->input->post('name')){
  $v .= "&product=".$this->input->post('product');
} */

if ($this->input->post('user')) {
    $v .= "&user=" . $this->input->post('user');
}
if ($this->input->post('start_date')) {
    $v .= "&start_date=" . $this->input->post('start_date');
}
if ($this->input->post('end_date')) {
    $v .= "&end_date=" . $this->input->post('end_date');
}

?>
<style type="text/css">
    .topborder div { border-top: 1px solid #CCC; }
</style>
<script>
    $(document).ready(function () {
        
        oTable = $('#sim_consignment_report').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getSimConsignment') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": dmy},null, null, null,null,null,
                {
                    "fnRender": function( obj ) {
                        if(obj.aData[1] == null){
                            return 'N/A';
                        }else{
                            return '<a href="sim/view_sim_by_sale_group_sim_status/' + obj.aData[8] +'/'+ obj.aData[9] +'/'+ obj.aData[10] + '/1">' + obj.aData[6] + '</a>';
                        }
                    

                    }
                }
            ,
                {
                    "fnRender": function( obj ) {
                        if(obj.aData[1] == null){
                            return 'N/A';
                        }else{
                            return '<a href="sim/view_sim_by_sale_group_sim_status/' + obj.aData[8] +'/'+ obj.aData[9] +'/'+ obj.aData[10] + '/0">' + obj.aData[7] + '</a>';
                        }
                    

                    }
                },{
                    "fnRender": function( obj ) {
                        if(obj.aData[11] == null){
                            return 'N/A';
                        }else{
                            return obj.aData[11]/2;
                        }
                    

                    }
                }]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('Customer_Shop');?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[dd-mm-yyyy]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('Location');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('Seller_Name');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('Facebook_Name');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('Group_Name');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('Saled');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('Not_Sale');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('Total Sale');?>]", filter_type: "text", data: []},
        ], "footer");

    });
</script>
<style>.table td:nth-child(6) {
        text-align: center;
    }</style>

<div class="box">
    
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-th-large"></i><?= lang('Sim_Consignment_Report'); ?></h2>
       <!--  <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                            class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                            class="icon fa fa-toggle-down"></i></a></li>
            </ul>
        </div> -->
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>"><i
                            class="icon fa fa-file-excel-o"></i></a></li>
                <!-- <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                            class="icon fa fa-file-picture-o"></i></a></li> -->
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="sim_consignment_report" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-hover table-striped reports-table">
                        <thead>
                        <tr>
                            <th><?= lang('Date_Sell'); ?></th>
                            <th><?= lang('Group_Name'); ?></th>
                            <th><?= lang('Customer_Shop'); ?></th>
                            <th><?= lang('Customer_Phone'); ?></th>
                            <th><?= lang('Location'); ?></th>
                            <!--<th><?= lang('Seller_Name') ?></th>-->
                            <th><?= lang('Facebook_Name'); ?></th>
                            <th><?= lang('Saled'); ?></th>
                            <th><?= lang('Not_Sale'); ?></th>
                            <th><?= lang('Total Sale'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getSimConsignment/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>

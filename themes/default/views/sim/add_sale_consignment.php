<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
        $('.bootbox').on('hidden.bs.modal', function (e) {
            $('#add_item').focus();
        });
        $("#add_item").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('sim_sale_consignments/groupsSuggestion'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        $(this).removeClass('ui-autocomplete-loading');
                        response(data);
                        console.log(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    alert(ui.item.id);
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
</script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add sale consignment'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("sim_sale_consignments/add_sale_consignment", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

             <div class="form-group">
                <?= lang("Consign date", "datelbl"); ?>
                <?php echo form_input('conDate', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="sldate" required="required"'); ?>
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
            <div class="form-group">
                <?= lang('Reference note', 'notelbl'); ?>
                <?= form_input('note', set_value('code'), 'class="form-control" id="code" required="required"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sale_consignment', lang('add sale consignment'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
<!-- <script type="text/javascript">
    $(document).ready(function () {
        $('#add_item').select2({
            minimumInputLength: 1,
            ajax: {
                url: site.base_url + "sim_sale_consignments/groupsSuggestion",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });
    });
</script> -->
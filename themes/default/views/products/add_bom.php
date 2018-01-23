<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0, DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>;
    $(document).ready(function () {
        if (localStorage.getItem('remove_slls')) {
            if (localStorage.getItem('slitems')) {
                localStorage.removeItem('slitems');
            }
            if (localStorage.getItem('sldiscount')) {
                localStorage.removeItem('sldiscount');
            }
            if (localStorage.getItem('sltax2')) {
                localStorage.removeItem('sltax2');
            }
            if (localStorage.getItem('slshipping')) {
                localStorage.removeItem('slshipping');
            }
            if (localStorage.getItem('slwarehouse')) {
                localStorage.removeItem('slwarehouse');
            }
            if (localStorage.getItem('slnote')) {
                localStorage.removeItem('slnote');
            }
            if (localStorage.getItem('slinnote')) {
                localStorage.removeItem('slinnote');
            }
            if (localStorage.getItem('slcurrency')) {
                localStorage.removeItem('slcurrency');
            }
            if (localStorage.getItem('sldate')) {
                localStorage.removeItem('sldate');
            }
            if (localStorage.getItem('slsale_status')) {
                localStorage.removeItem('slsale_status');
            }
            if (localStorage.getItem('slpayment_status')) {
                localStorage.removeItem('slpayment_status');
            }
            if (localStorage.getItem('paid_by')) {
                localStorage.removeItem('paid_by');
            }
            if (localStorage.getItem('amount_1')) {
                localStorage.removeItem('amount_1');
            }
            if (localStorage.getItem('paid_by_1')) {
                localStorage.removeItem('paid_by_1');
            }
            if (localStorage.getItem('pcc_holder_1')) {
                localStorage.removeItem('pcc_holder_1');
            }
            if (localStorage.getItem('pcc_type_1')) {
                localStorage.removeItem('pcc_type_1');
            }
            if (localStorage.getItem('pcc_month_1')) {
                localStorage.removeItem('pcc_month_1');
            }
            if (localStorage.getItem('pcc_year_1')) {
                localStorage.removeItem('pcc_year_1');
            }
            if (localStorage.getItem('pcc_no_1')) {
                localStorage.removeItem('pcc_no_1');
            }
            if (localStorage.getItem('cheque_no_1')) {
                localStorage.removeItem('cheque_no_1');
            }
            if (localStorage.getItem('payment_note_1')) {
                localStorage.removeItem('payment_note_1');
            }
            if (localStorage.getItem('slpayment_term')) {
                localStorage.removeItem('slpayment_term');
            }
            localStorage.removeItem('remove_slls');
        }
        
        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('sldate')) {
            $("#sldate").datetimepicker({
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
        }
        $(document).on('change', '#sldate', function (e) {
            localStorage.setItem('sldate', $(this).val());
        });
        if (sldate = localStorage.getItem('sldate')) {
            $('#sldate').val(sldate);
        }
        <?php } ?>

        ItemnTotals();
        $('.bootbox').on('hidden.bs.modal', function (e) {
            $('#bom_from_items').focus();
            $('#convert_to_item').focus();
        });
        $("#bom_from_items").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('products/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#slwarehouse").val()
                    },
                    success: function (data) {

                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#bom_from_items').focus();
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
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#bom_from_items').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
				
                event.preventDefault();
                if (ui.item.id !== 0) {
					
                	var rows        = "";
                    var data        = ui.item.uom;
					
					var opt = $("<select id=\"bom_from_option\" name=\"bom_from_items_uom\[\]\" class=\"form-control select rvariant\" />");
					if(ui.item.options !== false) {
						$.each(ui.item.options, function () {
							$("<option />", {value: this.id, text: this.name, qty: this.qty_unit}).appendTo(opt);
						});
					} else {
						$("<option />", {value: 0, text: 'n/a'}).appendTo(opt);
						opt = opt.hide();
					}
					
					rows = "<tr>"
	        				+ "<td>	<input type='hidden' value='"+ui.item.id+"' name='bom_from_items_id[]' />"
	        				+ " <input type='hidden' value='"+ui.item.code+"' name='bom_from_items_code[]' />"
	        				+ " <input type='hidden' value='"+ui.item.name+"' name='bom_from_items_name[]' />"
	        				+ ui.item.label+"</td>"
                            + "<td>" + (opt.get(0).outerHTML) + "</td>"
	        				+ "<td><input type='text' required='required' class='quantity form-control input-tip' value='' name='bom_from_items_qty[]' /></td>"
	        				+ '<td><i style="cursor:pointer;" title="Remove" id="1449892339552" class="fa fa-times tip pointer sldel"></i></td>'
						+ "</tr>";
						
                	$('#tbody-convert-from-items').append(rows);
					
                	$(this).val('');
					
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
        $("#convert_to_item").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('products/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#slwarehouse").val()
                    },
                    success: function (data) {

                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#convert_to_item').focus();
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
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#convert_to_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                	var rows       = "";
                    var data       = ui.item.uom;
					var cost 	   = (ui.item.cost > 0 ? ui.item.cost : ui.item.price);
                    var option     = "";
                    var opt = $("<select id=\"poption\" name=\"convert_to_items_uom\[\]\" class=\"form-control select rvariant\" />");
					if(ui.item.options !== false) {
						$.each(ui.item.options, function () {
							$("<option />", {value: this.id, text: this.name}).appendTo(opt);
						});
					} else {
						$("<option />", {value: 0, text: 'n/a'}).appendTo(opt);
						opt = opt.hide();
					}
                	rows = "<tr>"
	        				+ "<td>	<input type='hidden' value='"+ui.item.id+"' name='convert_to_items_id[]' />"
	        				+ " <input type='hidden' value='"+ui.item.code+"' name='convert_to_items_code[]' />"
	        				+ " <input type='hidden' value='"+ui.item.name+"' name='convert_to_items_name[]' />"
	        				+ ui.item.label+"</td>"
                            + "<td>" + (opt.get(0).outerHTML) + "</td>"
	        				+ "<td><input type='text' required='required' class='quantity form-control qty_count input-tip' value='' name='convert_to_items_qty[]' /></td>"
	        				+ '<td><i style="cursor:pointer;" title="Remove" id="1449892339552" class="fa fa-times tip pointer sldel"></i></td>'
						+ "</tr>";
                	$('#tbody-convert-to-items').append(rows);
                	$(this).val('');
					
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
        

        $('#bom_from_items').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });
        $('#convert_to_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });
	});
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Bom'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("products/add_bom", $attrib);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "sldate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="sldate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Name", "slref"); ?>
                                <?php echo form_input('name', '', 'class="form-control input-tip" required="required" id="slref"'); ?>
                            </div>
                        </div>
						

                    </div>
					<!-- convert from items -->
					<div class="col-md-12" id="sticker">
						<div class="well well-sm">
							<div class="form-group" style="margin-bottom:0;">
								<div class="input-group wide-tip">
									<div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
										<i class="fa fa-2x fa-barcode addIcon"></i></div>
									<?php echo form_input('bom_from_items', '', 'class="form-control input-lg" id="bom_from_items" placeholder="' . lang("add_product_to_order") . '"'); ?>                                        
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<!-- table show convert from items -->
					<div class="col-md-12">
						<div class="control-group table-group">
							<label class="table-label"><?= lang("bom_items_from"); ?> *</label>

							<div class="controls table-controls">
								<table id="slTable_" class="table items table-striped table-bordered table-condensed table-hover table-raw">
									<thead>
										<tr>
											<th class="col-md-5"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
											<th class="col-md-2"><?= lang("unit"); ?></th>
											<th class="col-md-5"><?= lang("quantity"); ?></th>
											<th class="col-md-1" style="width:30px !important;text-align: center;">
												<i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
											</th>
										</tr>
									</thead>
									<tbody id="tbody-convert-from-items"></tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- Select Convert to Items -->
					<div class="col-md-12" id="sticker">
						<div class="well well-sm">
							<div class="form-group" style="margin-bottom:0;">
								<div class="input-group wide-tip">
									<div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
										<i class="fa fa-2x fa-barcode addIcon"></i></div>
									<?php echo form_input('bom_to_item', '', 'class="form-control input-lg" id="convert_to_item" placeholder="' . lang("add_product_to_order") . '"'); ?>                                     
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<!-- table convert to items -->
					<div class="col-md-12">
						<div class="control-group table-group">
							<label class="table-label"><?= lang("bom_items_to"); ?> *</label>

							<div class="controls table-controls">
								<table id="slTable_ " class="table items table-striped table-bordered table-condensed table-hover table-fin">
									<thead>
										<tr>
											<th class="col-md-5"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
											<th class="col-md-2"><?= lang("unit"); ?></th>
											<th class="col-md-5"><?= lang("quantity"); ?></th>
											<th class="col-md-1" style="width:30px !important;text-align: center;">
												<i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
											</th>
										</tr>
									</thead>
									<tbody id="tbody-convert-to-items"></tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- Button Submit -->
					<div class="col-md-12">
						<div class="fprom-group"><?php echo form_submit('add_sale', lang("submit"), 'id="bth_convert_items" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
							<button type="button" name="convert_items" class="btn btn-danger" id="reset"><?= lang('reset') ?></button>
						</div>
                    </div>
                </div>
            </div>
                <?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabel"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <?php if ($Settings->tax1) { ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= lang('product_tax') ?></label>
                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                                echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($Settings->product_serial) { ?>
                        <div class="form-group">
                            <label for="pserial" class="col-sm-4 control-label"><?= lang('serial_no') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pserial">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>

                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
                    <?php if ($Settings->product_discount) { ?>
                        <div class="form-group">
                            <label for="pdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pdiscount">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('unit_price') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pprice">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="net_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <input type="hidden" id="punit_price" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_price" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="mcode" class="col-sm-4 control-label"><?= lang('product_code') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mname" class="col-sm-4 control-label"><?= lang('product_name') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mname">
                        </div>
                    </div>
                    <?php if ($Settings->tax1) { ?>
                        <div class="form-group">
                            <label for="mtax" class="col-sm-4 control-label"><?= lang('product_tax') ?> *</label>

                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                                echo form_dropdown('mtax', $tr, "", 'id="mtax" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="mquantity" class="col-sm-4 control-label"><?= lang('quantity') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mquantity">
                        </div>
                    </div>
                    <?php if ($Settings->product_discount) { ?>
                        <div class="form-group">
                            <label for="mdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mdiscount">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="mprice" class="col-sm-4 control-label"><?= lang('unit_price') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mprice">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="mnet_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="mpro_tax"></span></th>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fa fa-2x">&times;</i></button>
                <h4 class="modal-title" id="myModalLabel"><?= lang('sell_gift_card'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= lang('enter_info'); ?></p>

                <div class="alert alert-danger gcerror-con" style="display: none;">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <span id="gcerror"></span>
                </div>
                <div class="form-group">
                    <?= lang("card_no", "gccard_no"); ?> *
                    <div class="input-group">
                        <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#"
                                                                                                           id="genNo"><i
                                    class="fa fa-cogs"></i></a></div>
                    </div>
                </div>
                <input type="hidden" name="gcname" value="<?= lang('gift_card') ?>" id="gcname"/>

                <div class="form-group">
                    <?= lang("value", "gcvalue"); ?> *
                    <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("price", "gcprice"); ?> *
                    <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("customer", "gccustomer"); ?>
                    <?php echo form_input('gccustomer', '', 'class="form-control" id="gccustomer"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("expiry_date", "gcexpiry"); ?>
                    <?php echo form_input('gcexpiry', '', 'class="form-control date" id="gcexpiry"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        function requireQty(){
            var result = true;
            $(".quantity").each(function(){
                if($(this).val() === null || $(this).val() === ""){
                    result = false;
                }
            });
            return result;
        }
        $('#gccustomer').select2({
            minimumInputLength: 1,
            ajax: {
                url: site.base_url + "customers/suggestions",
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
        $("#bth_convert_items").click(function(){
        	if($('.quantity').length < 1){
        		bootbox.alert('<?= lang('please_add_items_below') ?>');
        		return false;
        	}
            if($('#tbody-convert-from-items tr').length < 1){
                bootbox.alert('<?= lang('please_add_items_below') ?>');
                return false;   
            }
            if($('#tbody-convert-to-items tr').length < 1){
                bootbox.alert('<?= lang('please_add_items_below') ?>');
                return false;   
            }
            var requireField = requireQty();
    		if(requireField === false){
    			bootbox.alert('<?= lang('quantity_require') ?>');
    			return false;
    		}
        });
        $('#genNo').click(function () {
            var no = generateCardNo();
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });
    });
	
/***** Sikeat Remove Convert Item *****/
$(document).on('click', '.sldel', function () {
    var row = $(this).closest('tr');
    row.remove();
	$('.quantity').trigger('change');
});
</script>

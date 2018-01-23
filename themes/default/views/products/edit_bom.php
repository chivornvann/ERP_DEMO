<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0, DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>;
    //var audio_success = new Audio('<?=$assets?>sounds/sound2.mp3');
    //var audio_error = new Audio('<?=$assets?>sounds/sound3.mp3');
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
                    //audio_error.play();
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
					
					var opt = $("<select id=\"poption\" name=\"bom_from_items_uom\[\]\" class=\"form-control select rvariant\" />");
					if(ui.item.options !== false) {
						$.each(ui.item.options, function () {
							$("<option />", {value: this.id, text: this.name}).appendTo(opt);
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
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Edit_Bom'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("products/edit_bom/".$id, $attrib);
				foreach($all_bom as $bom){
					$date = date("m/d/Y H:i", strtotime($bom->date));
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "sldate"); ?>
                                    <?php echo form_input('date', (isset($bom->date) ? $date : ""), 'class="form-control input-tip datetime" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Name", "slrefs"); ?>
                                <?php echo form_input('name', (isset($bom->name) ? $bom->name : ""), 'class="form-control input-tip" required="required" id="slrefs"'); ?>
                            </div>
                        </div>

                    </div>
					<!-- convert from items -->
					<div class="col-md-12" id="sticker">
						<div class="well well-sm">
							<div class="form-group" style="margin-bom_to:0;">
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
								<table id="slTable_" class="table items table-striped table-bordered table-condensed table-hover">
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
									<tbody id="tbody-convert-from-items">
										<?php
										
											if(isset($bom_froms)){

												foreach($bom_froms as $bom_from){
										?>
											<tr>
												<td>	
													<input type='hidden' value='<?= $bom_from->product_id;?>' name='bom_from_items_id[]' />
													<input type='hidden' value='<?= $bom_from->product_code;?>' name='bom_from_items_code[]' />
													<input type='hidden' value='<?= $bom_from->product_name;?>' name='bom_from_items_name[]' />
													<?= $bom_from->product_name .' ('.$bom_from->product_code .')';?>
												</td>
												<td>
													<?php
														$productunit = $this->products_model->getUnitbyProduct($bom_from->product_id);
														//$this->sma->print_arrays($productunit);
														if($productunit){
															echo "<select name='bom_from_items_uom[]' class='form-control'>";
															foreach($productunit as $unit){
																if($unit->id == $bom_from->unit_id){
																	echo '<option value="'.$unit->id.'" selected>'.$unit->name.'</option>';
																}else{
																	echo '<option value="'.$unit->id.'">'.$unit->name.'</option>';
																}
																
															}
															echo "</select>";
														}else{
															echo "<select name='bom_from_items_uom[]' class='form-control' style='display:none;'><option value='0'>n/b</option></select>";
														}
													?>
												</td>
												<td><input type='text' required='required' class='quantity form-control input-tip' value='<?= $this->sma->formatQuantity($bom_from->quantity);?>' name='bom_from_items_qty[]' /></td>
												
												<td><i style="cursor:pointer;" title="Remove" id="1449892339552" class="fa fa-times tip pointer sldel"></i></td>
											</tr>
										<?php
												}
											}
										?>
									</tbody>
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
								<table id="slTable_ " class="table items table-striped table-bordered table-condensed table-hover">
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
									<tbody id="tbody-convert-to-items">
										<?php
											if(isset($bom_tos)){
												foreach($bom_tos as $bom_to){
										?>
											<tr>
												<td>	
													<input type='hidden' value='<?= $bom_to->product_id;?>' name='convert_to_items_id[]' />
													<input type='hidden' value='<?= $bom_to->product_code;?>' name='convert_to_items_code[]' />
													<input type='hidden' value='<?= $bom_to->product_name;?>' name='convert_to_items_name[]' />
													<?= $bom_to->product_name .' ('.$bom_to->product_code .')';?>
												</td>
												<td>
													<?php
														$productunit = $this->products_model->getUnitbyProduct($bom_to->product_id);
														if($productunit){
															echo "<select name='convert_to_items_uom[]' class='form-control'>";
															foreach($productunit as $unit){
																if($unit->id == $bom_to->unit_id){
																	echo '<option value="'.$unit->id.'" selected>'.$unit->name.'</option>';
																}else{
																	echo '<option value="'.$unit->id.'">'.$unit->name.'</option>';
																}
																
															}
															echo "</select>";
														}else{
															echo "<select name='convert_to_items_uom[]' class='form-control' style='display:none;'><option value='0'>n/b</option></select>";
														}
													?>
												</td>
												<td><input type='text' required='required' class='quantity form-control input-tip' value='<?= $this->sma->formatQuantity($bom_to->quantity);?>' name='convert_to_items_qty[]' /></td>
												
												<td><i style="cursor:pointer;" title="Remove" id="1449892339552" class="fa fa-times tip pointer sldel"></i></td>
											</tr>
										<?php
												}
											}else{}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- Button Submit -->
					<div class="col-md-12">
                            <div class="fprom-group"><?php echo form_submit('add_sale', lang("submit"), 'id="bth_convert_items" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" name="convert_items" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                        </div>
                    </div>
                </div>
                <?php }echo form_close(); ?>

            </div>

        </div>
    </div>
</div>


<script type="text/javascript" src="<?=base_url('themes/default/assets/js/sales.js')?>"></script>
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
});
</script>

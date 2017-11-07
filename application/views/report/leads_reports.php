<style>
.lbl-rd-b{margin-top: 12px;}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Reports </h5>
					<?php 
						$pageUrl = BASE_URL.'reports/leads';
						
						if(!empty($_GET['from_date']) && !empty($records)) {
							echo '<div class="ibox-tools">
									<a href="javascript:;" target="_blank" class="btn btn-sm btn-info add-new-btn print_page">Print</a>
								  </div>';
						}
					?>
				</div>
				
				<div class="ibox-content" style="overflow: hidden;">
					<?php 
						if(empty($_GET['from_date'])) {
					?>
					<form id="rprt-form" action="<?php echo $pageUrl?>" target="_blank" method="get">
							<div class="col-lg-12 search-area">
								<div class="row radio-holder">
									<div class="col-md-12 form-group" style="margin-bottom: -20px;">
										<div class="col-md-8 form-group">
											<div class="col-lg-1">
												<input type="radio" class="form-control" name="report_type" value="o_l" <?php echo @$_GET['report_type'] == 'o_l' ? 'checked' : ""?> style="width: 17px;">							
											</div>	
											<label class="col-lg-5 control-label lbl-rd-b">Leads</label>
										</div>
									</div>
									<div class="col-md-12 form-group">
										<div class="col-md-8 form-group">
											<div class="col-lg-1">
												<input type="radio" class="form-control" name="report_type" value="l_c"<?php echo @$_GET['report_type'] == 'l_c' ? 'checked': ""?> style="width: 17px;">							
											</div>	
											<label class="col-lg-5 control-label lbl-rd-b">Leads Count (Sales Partner wise)</label>
										</div>
									</div>
								</div>
								<div class="col-md-3 form-group">
									<label class="control-label">From Date</label>
									<input type="text" placeholder="Select From Date" class="form-control datepickr" name="from_date" value="<?php echo @$_GET['from_date']?>">
								</div>
								
								<div class="col-md-3 form-group">
									<label class="control-label">To Date</label>
									<input type="text" placeholder="Select To Date" class="form-control datepickr" name="to_date" value="<?php echo @$_GET['to_date']?>">
								</div>
								
								<?php if($logged_in_role_id == 1) {?>
									<div class="col-md-3 form-group">
										<label class="control-label">Circle</label>
										<select class="form-control" name="circle" id="circle_id">
											<option value="">Select</option>
											<?php 
												if(isset($circles)) {
													foreach($circles as $rcd) {
														$selected = '';
														if($rcd['circle_id'] == @$_GET['circle']) {
															$selected = 'selected';
														}
														echo '<option value="'.$rcd['circle_id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								<?php } ?>
								
								<?php if(in_array($logged_in_role_id, array(1,2))) {?>
									<div class="col-md-3 form-group">
										<label class="control-label">SSA</label>
										<select class="form-control" name="ssa" id="ssa_id">
											<option value="">Select</option>
											<?php 
												if(isset($ssa)) {
													foreach($ssa as $rcd) {
														$selected = '';
														if($rcd['ssa_id'] == @$_GET['ssa']) {
															$selected = 'selected';
														}
														echo '<option value="'.$rcd['ssa_id'].'" '.$selected.'>'.$rcd['ssa_name'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								<?php } ?>
								<div class="col-md-3 form-group afe-dv">
									<label class="control-label">Sales Partner</label>
									<select class="form-control" name="afe">
										<option value="">Select</option>
										<?php 
											if(isset($afe_users)) {
												foreach($afe_users as $rcd) {
													$selected = '';
													if($rcd['afe_id'] == @DeCrypt($_GET['afe'])) {
														$selected = 'selected';
													}
													echo '<option value="'.EnCrypt($rcd['afe_id']).'" '.$selected.'>'.$rcd['afe_name'].'('.$rcd['afe_mobile'].')</option>';
												}
											}
										?>
									</select>	
								</div>
								<div class="col-md-12">
									<button type="button" class="btn btn-sm btn-primary" id="get_rprt">Get Report!</button>
									<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
								</div>
							</div>	
						</form>	
						<?php } else { ?>
							<div class="table-responsive">
								<?php $this->load->view($element_name);?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){	
	$(".datepickr").datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		validateOnBlur:false,
		maxDate:'<?php echo date('Y-m-d');?>',
		scrollInput:false
	});
	
	$(document).on('change','#circle_id',function(){
		var circle_id = $(this).val();
		$('#ssa_id').html('<option value="">Select</option>');
		if($.trim(circle_id) != ''){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'user/getCirclesSSA',
				type: 'POST',
				data: {circle_id: circle_id},
				dataType: 'JSON',
				error: function(){
					showCustomLoader(false);
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						$('#ssa_id').html(response.html);
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('click','input:radio[name="report_type"]',function(){
		if($.trim($(this).val()) == 'l_c'){
			$('.afe-dv').find('select').find('option[value=""]').prop('selected', true);
			$('.afe-dv').hide();
		} else {
			$('.afe-dv').show();
		}
	});
	
	$(document).on('click','#get_rprt',function(){
		if($("#rprt-form").valid()){
			$("#rprt-form")[0].submit();		
		}
	});	
	
	$("#rprt-form").validate({
		onkeyup: false,
		rules: {
			from_date: {
				required: true,
			},
			to_date: {
				required: true,
			},
			report_type: {
				required: true,
			},		
		},
		messages: {
			
		},
		submitHandler: function(form) {
			return false;
		},
		highlight: function (element) {						
			if ($(element).attr('type') == 'checkbox') {
				$(element).next('label').addClass("error");
				
			} else if ($(element).attr('type') == 'radio') {
				$(element).closest('div.radio-holder').addClass("error");
				
			} else {
				$(element).addClass('error');
			}
			
		},
		unhighlight: function (element) {
			if ($(element).attr('type') == 'checkbox') {
				$(element).next('label').removeClass("error");
				
			} else if ($(element).attr('type') == 'radio') {
				$(element).closest('div.radio-holder').removeClass("error");
				
			} else {
				$(element).removeClass('error');
			}
		},
		invalidHandler: function (form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				var first_error = validator.errorList[0].element;				
				var lbl = '';
				if (errors == 1) {
					lbl = ' Please fill the complete form. {' + errors + '} field is incorrect.';
				} else {
					lbl = ' Please fill the complete form. {' + errors + '} fields are incorrect.';
				}
				
				$('html, body').animate({
					scrollTop: $(first_error).offset().top - 150
				}, 500);
			}
		},
		errorPlacement: function (error, element) {
			 if ($(element).attr('type') == 'radio') {
				$(element).closest('div.radio-holder').append(error);
				
			} else {
				error.appendTo($(element).closest('div'));
			}
		}
	});
});

</script>
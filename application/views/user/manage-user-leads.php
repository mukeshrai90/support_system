<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins custom-wdth">
				<div class="ibox-title">
					<h5>Add/Update Lead</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="javascript:;" id="manage_lead_form" method="post">
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Name</label>
								<div class="col-md-7">
									<input type="text" class="form-control only-char-space" name="name" id="name"  placeholder="Name" value="<?php echo @$record['user_full_name']?>">
									<input type="hidden" name="afe_id" value="<?php echo @$record['afe_id']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Email</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="email" id="email"  placeholder="Email" value="<?php echo @$record['user_email']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Mobile</label>
								<div class="col-md-7">
									<input type="text" class="form-control only-number" name="mobile" id="mobile"  placeholder="Mobile" value="<?php echo @$record['user_mobile']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Address</label>
								<div class="col-md-7">
									<textarea name="address" id="address" class="form-control" placeholder="Address Details Here"><?php echo @$record['user_address']?></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Circle</label>
								<div class="col-md-7">
									<select name="circle_id" id="circle_id" class="form-control">
										<option value="">Select</option>									
										<?php 
											if(isset($circles)) {
												foreach($circles as $rcd) {
													$selected = '';
													if($rcd['circle_id'] == $record['user_circle_id']) {
														$selected = 'selected';
													}
													echo '<option value="'.$rcd['circle_id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">SSA</label>
								<div class="col-md-7">
									<select name="ssa_id" id="ssa_id" class="form-control">
										<option value="">Select</option>									
										<?php 
											if(isset($circles)) {
												foreach($circles as $rcd) {
													$selected = '';
													if($rcd['ssa_id'] == $record['user_ssa_id']) {
														$selected = 'selected';
													}
													echo '<option value="'.$rcd['ssa_id'].'" '.$selected.'>'.$rcd['ssa_name'].'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Plan</label>
								<div class="col-md-7">
									<select name="plan_id" id="plan_id" class="form-control">
										<option value="">Select</option>									
										<?php 
											if(isset($plans)) {
												foreach($plans as $rcd) {
													$selected = '';
													if($rcd['plan_id'] == $record['user_plan_id']) {
														$selected = 'selected';
													}
													echo '<option value="'.$rcd['plan_id'].'" '.$selected.'>'.$rcd['plan_name'].'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Payment Done?</label>
								<div class="col-md-7">
									<select name="payment_status" id="payment_status" class="form-control">
										<option value="">Select</option>									
										<?php 
											$sts_arr = array('Y' => 'Yes', 'N' => 'No');
											if(isset($sts_arr)) {
												foreach($sts_arr as $k=>$v) {
													$selected = '';
													if($record['payment_status'] == $k) {
														$selected = 'selected';
													}
													echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Application Form Image</label>
								<div class="col-md-7">
									<input type="file" class="form-control" name="app_forms_img" id="app_forms_img">
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">AFE</label>
								<div class="col-md-7">
									<select name="afe_id" id="afe_id" class="form-control">
										<option value="">Select</option>									
										<?php 
											if(isset($afeUsers)) {
												foreach($afeUsers as $rcd) {
													$selected = '';
													if($rcd['afe_id'] == $record['user_plan_id']) {
														$selected = 'selected';
													}
													echo '<option value="'.$rcd['afe_id'].'" '.$selected.'>'.$rcd['afe_name'].' ('.$rcd['afe_mobile'].')</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								
							</label>
							<div class="col-lg-7">
								<button class="btn btn-sm btn-primary" type="button" id="manage-form">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
	$(document).on('click','#manage-form',function(){
		if($("#manage_lead_form").valid()){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'user-leads/add',
				type: 'POST',
				data: $('#manage_lead_form').serialize(),
				dataType: 'JSON',
				error: function(){
					showCustomLoader(false);
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						customAlertBox(response.message);
						setTimeout(function(){window.location.href=response.redirectTo;},2000);
						
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});	
	
	$("#manage_lead_form").validate({
		onkeyup: false,
		rules: {
			name: {
				required: true,
				alphaSpace:true,
			},
			email: {
				required: true,
				email:true,
				remote : BASE_URL+'user/check_user_email?id='+$('input[name="id"]').val(),
			},
			mobile: {
				required: true,
				number:true,
				maxlength:10,
				minlength:10
			},
			circle_id: {
				required: true,				
			},
			ssa_id: {
				required: true,
			},
			plan_id: {
				required: true,
			},
			afe_id: {
				required: true,
			},			
		},
		messages: {
			email:{
				remote: 'Email Already Exist'
			}
		},
		submitHandler: function(form) {
			return false;
		},
		highlight: function (element) {						
			$(element).addClass('error');
		},
		unhighlight: function (element) {
			$(element).removeClass('error');
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
			error.appendTo($(element).closest('div'));
		}
	});
});  
</script>
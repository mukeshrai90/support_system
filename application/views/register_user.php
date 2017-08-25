<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>User Registration</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="javascript:;" id="manage_register_form" method="post">
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">User Type</label>
								<div class="col-md-7">
									<input type="hidden" name="id" value="<?php echo @$record['id']?>"/>	
									<select name="role_id" id="role_id" class="form-control">
										<option value="">Select</option>									
										<?php 
											$role_id = @$record['role_id'];
											if(isset($roles)) {
												foreach($roles as $role) {
													$selected = '';
													if($role['id'] == $role_id)
													{
														$selected = 'selected';
													}
													echo '<option value="'.$role['id'].'" '.$selected.'>'.$role['role_name'].'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Sequence No</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="sequence_no" id="sequence_no"  placeholder="Sequence No" value="<?php echo @$record['sequence_no']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Emp Code</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="emp_code" id="emp_code"  placeholder="Employee Code" value="<?php echo @$record['emp_code']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Name</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="name" id="name"  placeholder="Name" value="<?php echo @$record['name']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Email</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="email" id="email"  placeholder="Email" value="<?php echo @$record['email']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Mobile</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="mobile" id="mobile"  placeholder="Mobile" value="<?php echo @$record['mobile']?>" maxlength="10">
								</div>
							</div>
						</div>
						<?php 
							$manager_fields_display = 'display:none;';
							if(isset($record['role_id']) && $record['role_id'] == 5){
								$manager_fields_display = '';
							}
						?>
						<div class="form-group manager-fields" style="<?=$manager_fields_display?>">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Reporting Manager</label>
								<div class="col-md-7">
									<select name="manager_emp_code" id="manager_emp_code" class="form-control">
										<option value="">Select</option>									
										<?php 
											$manager_emp_code = @$record['manager_emp_code'];
											if(isset($managers)) {
												foreach($managers as $rcrd) {
													$selected = '';
													if($rcrd['emp_code'] == $manager_emp_code)
													{
														$selected = 'selected';
													}
													echo '<option value="'.$rcrd['emp_code'].'" '.$selected.'>'.$rcrd['emp_code'].' ('.$rcrd['name'].')</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Designation</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="designation" id="designation"  placeholder="Designation" value="<?php echo @$record['designation']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Department</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="department" id="department"  placeholder="Department" value="<?php echo @$record['department']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Location</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="location" id="location"  placeholder="Location" value="<?php echo @$record['location']?>">
								</div>
							</div>
							<div class="col-md-6" >
								<label class="col-md-5 control-label">City</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="city" id="city"  placeholder="City" value="<?php echo @$record['city']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Desktop Id</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="desktop_id" id="desktop_id"  placeholder="Add CPU Device Id (If Employye have Desktop)" value="<?php echo @$record['desktop_id']?>">	
								</div>
							</div>
							<div class="col-md-6" >
								<label class="col-md-5 control-label">Laptop Id</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="laptop_id" id="laptop_id"  placeholder="Add Laptop Device Id (If Applicable)" value="<?php echo @$record['laptop_id']?>">		
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Other Assigned Device Ids</label>
								<div class="col-md-7">
									<textarea name="other_device_ids" id="other_device_ids" class="form-control" placeholder="Write all other assigned device id separated with comma"><?php echo @$record['other_device_ids']?></textarea>
								</div>
							</div>
							<div class="col-md-6" >
								<label class="col-md-5 control-label">Machine Specification</label>
								<div class="col-md-7">
									<textarea name="machine_specification" id="machine_specification" class="form-control" placeholder="Add Machine Specification"><?php echo @$record['machine_specification']?></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Other Details</label>
								<div class="col-md-7">
									<textarea name="other_note_details" id="other_note_details" class="form-control" placeholder="Add Other Notes/Detailss for Employee Here"><?php echo @$record['other_details']?></textarea>
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

<script src="<?php echo ASSETS_URL?>js/jquery.datetimepicker.js"></script>
<link href="<?php echo ASSETS_URL?>css/jquery.datetimepicker.css" rel="stylesheet">

<script>
$(document).ready(function() {
	
	$(".datepick").datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		validateOnBlur:false,
		maxDate:'<?php echo date('Y-m-d');?>',
		scrollInput:false
	});
	
	$(document).on('change','#role_id',function(){
		var role_id = $(this).val();
		if(role_id  == 5){
			$('.manager-fields').slideDown('slow');
		} else {
			$('.manager-fields').slideUp('slow');
		}
	});
	
	$(document).on('click','#manage-form',function(){
		if($("#manage_register_form").valid()){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'users/register',
				type: 'POST',
				data: $('#manage_register_form').serialize(),
				dataType: 'JSON',
				error: function(){
					showCustomLoader(false);		
					swal({
					  title: "",
					  text: 'Unable to proocess your request right now.<br/> Please try again or some time later',
					  type : 'error',
					  html : true,	
					  timer: 5000						  
					});
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						swal({
						  title: "",
						  text: response.message,
						  type : 'success',
						  html : true,						  
						});				

						setTimeout(function(){window.location.href=BASE_URL+'employees/list';},2000);
						
					} else{
						swal({
						  title: "",
						  text: response.message,
						  type : 'error',
						  html : true,	
						  timer: 5000						  
						});
					}
				}
			});
		}
	});	
	
	$.validator.addMethod("check_role", function(value, element) {
	  if($('#role_id').val() == 5 && value == '') {
		  return false;
	  }
	  return true;
	},'This field is required');
	
	$.validator.addMethod('alphaSpace', function (value, element) {		
		var matchText = /^[A-Za-z\s\.\(\)]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Please enter only alphabets with space");
	
	$.validator.addMethod('alphaNumeric', function (value, element) {		
		var matchText = /^[A-Za-z0-9]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Please enter only alpha Numeric");
	
	$.validator.addMethod('alphaNumericComma', function (value, element) {		
		var matchText = /^[A-Za-z0-9\,]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Please enter only alpha Numeric");
	
	$.validator.addMethod('checkEmpCodeDeviceId', function (value, element) {		
		var matchText = /^[A-Za-z0-9\/\-\_]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Allowed Special Characters /_-");
	
	$.validator.addMethod('checkOtherDevices', function (value, element) {		
		var matchText = /^[A-Za-z0-9\,\/\-\_]+$/i;
		return this.optional(element) || matchText.test(value);;
	}, "Allowed Special Characters ,/_-");
	
	$("#manage_register_form").validate({
		onkeyup: false,
		rules: {
			role_id: {
				required: true,
			},
			sequence_no: {
				required: true,		
			},
			emp_code: {
				required: true,
				checkEmpCodeDeviceId:true,
				remote : BASE_URL+'admin/check_emp_code?id='+$('input[name="id"]').val(),
			},
			name: {
				required: true,
				alphaSpace:true,
			},
			email: {
				required: true,
				email:true,
				remote : BASE_URL+'admin/check_user_email?id='+$('input[name="id"]').val(),
			},
			mobile: {
				required: true,
				number:true,
				maxlength:10,
				minlength:10
			},
			manager_emp_code: {
				check_role: true,
				checkEmpCodeDeviceId:true,
			},			
			designation: {
				required: true,
				alphaSpace:true,
			},
			department: {
				required: true,
				alphaSpace:true,
			},
			location: {
				required: true,
				alphaSpace:true,
			},
			city: {
				required: true,
				alphaSpace:true,
			},
			desktop_id: {
				//required: true,				
				checkEmpCodeDeviceId:true,
			},
			laptop_id: {
				//required: true,
				checkEmpCodeDeviceId:true,
			},
			machine_specification: {
				required: true,
			},						
			other_device_ids: {
				//required: true,
				checkOtherDevices:true,
			},			
		},
		messages: {
			emp_code:{
				remote: 'Emp Code Already Exist'
			},
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
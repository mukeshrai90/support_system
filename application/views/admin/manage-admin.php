<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins custom-wdth">
				<div class="ibox-title">
					<h5>Add/Edit Admin</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="<?php echo BASE_URL.'admin/add'?>" id="manage_register_form" method="post">	
						<div class="form-group">
							<label class="col-lg-4 control-label">Role</label>
							<div class="col-lg-7">
								<?php 
									$admin_roles = @$admin_roles[0];
									$admin_role_prim_id = @$admin_roles['id'];
									$admin_role_id = @$admin_roles['admin_role_id'];
									$role_circle_id = @$admin_roles['admin_role_circle_id'];
									$role_ssa_id = @$admin_roles['admin_role_ssa_id'];
									
									$cirlDsplSts = $ssaDsplSts = 'display:none;';
									if($admin_role_id == 2){
										$cirlDsplSts = 'display:block;';
									} else if($admin_role_id == 3){
										$cirlDsplSts = 'display:block;';
										$ssaDsplSts = 'display:block;';
									}
									
								?>
								<input type="hidden" name="admin_role_id" value="<?php echo EnCrypt($admin_role_prim_id)?>">
								<select name="role_id" id="role_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($roles)) {
											foreach($roles as $role) {
												$selected = '';
												if($role['role_id'] == $admin_role_id) {
													$selected = 'selected';
												}
												echo '<option value="'.$role['role_id'].'" '.$selected.'>'.$role['role_name'].'</option>';
											}
										}
									?>   									
							   </select>
							</div>
						</div>					
						<div class="form-group">
							<label class="col-lg-4 control-label">Username</label>
							<div class="col-lg-7">
								<input type="hidden" name="admin_id" value="<?php echo !empty($record['admin_id']) ? EnCrypt($record['admin_id']) : ''?>">
								<input type="text" class="form-control" name="username" id="username"  placeholder="Username" value="<?php echo @$record['admin_username']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Name</label>
							<div class="col-lg-7">
								<input type="text" class="form-control" name="name" id="name"  placeholder="Name" value="<?php echo @$record['admin_name']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Email</label>
							<div class="col-lg-7">
								<input type="text" class="form-control" name="email" id="email"  placeholder="Email" value="<?php echo @$record['admin_email']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Mobile</label>
							<div class="col-lg-7">
								<input type="text" class="form-control" name="mobile" id="mobile"  placeholder="Mobile" value="<?php echo @$record['admin_mobile']?>" maxlength="10">
							</div>
						</div>				
						<div class="form-group">
							<label class="col-lg-4 control-label">Designation</label>
							<div class="col-lg-7">
								<input type="text" class="form-control" name="designation" id="designation"  placeholder="Designation" value="<?php echo @$record['admin_designation']?>">
							</div>
						</div>
						<div class="form-group" id="circle_row" style="<?=$cirlDsplSts?>">
							<label class="col-lg-4 control-label">Circle</label>
							<div class="col-lg-7">
								<select name="circle_id" id="circle_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($circles)) {
											foreach($circles as $rcd) {
												$selected = '';
												if($rcd['circle_id'] == $role_circle_id) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['circle_id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
											}
										}
									?>   									
								</select>
							</div>
						</div>	
						<div class="form-group" id="ssa_row" style="<?=$ssaDsplSts?>">
							<label class="col-lg-4 control-label">SSA</label>
							<div class="col-lg-7">
								<select name="ssa_id" id="ssa_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($ssa)) {
											foreach($ssa as $rcd) {
												$selected = '';
												if($rcd['ssa_id'] == $role_ssa_id) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['ssa_id'].'" '.$selected.'>'.$rcd['ssa_name'].'</option>';
											}
										}
									?>   									
								</select>
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
	
	$(document).on('change','#role_id',function(){
		var role_id = $(this).val();
		
		$('#circle_row, #ssa_row').slideUp();
		if($.trim(role_id) == '2'){
			$('#circle_row').slideDown();
		} else if($.trim(role_id) == '3') {
			$('#circle_row').slideDown();
			$('#ssa_row').slideDown();
		}
	});
	
	$(document).on('click','#manage-form',function(){
		if($("#manage_register_form").valid()){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'admins/add',
				type: 'POST',
				data: $('#manage_register_form').serialize(),
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
	
	$.validator.addMethod("checkCrclRole", function(value, element, param){
    	if($.trim($('#role_id').val()) == '2' && $.trim(value) == ''){
			return false;
		}
		return true;
    },("This field is required")); 

	
	$.validator.addMethod("checkSSARole", function(value, element, param){
    	if($.trim($('#role_id').val()) == '3' && $.trim(value) == ''){
			return false;
		}
		return true;
    },("This field is required"));
	
	$("#manage_register_form").validate({
		onkeyup: false,
		rules: {			
			username: {
				required: true,	
				alphaNumeric: true,			
				remote : BASE_URL+'admin/check_admin_username?id='+$('input[name="admin_id"]').val(),
			},
			name: {
				required: true,
				alphaSpace:true,
			},
			email: {
				required: true,
				email:true,
				remote: BASE_URL+'admin/check_admin_email?id='+$('input[name="admin_id"]').val(),
			},
			mobile: {
				required: true,
				number:true,
				maxlength:10,
				minlength:10
			},						
			designation: {
				alphaSpace:true,
			},
			circle_id: {
				checkCrclRole:true,
			},	
			ssa_id: {
				checkSSARole:true,
			},
		},
		messages: {
			username:{
				remote: 'Username Already Exist'
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

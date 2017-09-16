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
								<label class="col-md-5 control-label">User ID</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="userId" id="userId"  placeholder="User ID" value="<?php echo @$record['userId']?>">
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
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Circle</label>
								<div class="col-md-7">
									<select name="circle_id" id="circle_id" class="form-control">
											<option value="">Select</option>									
										<?php 
											$circle_id = @$record['circle_id'];
											if(isset($roles)) {
												foreach($circles as $rcd) {
													$selected = '';
													if($rcd['id'] == $circle_id)
													{
														$selected = 'selected';
													}
													echo '<option value="'.$rcd['id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
							<div class="col-md-6" >
								<label class="col-md-5 control-label">SSA</label>
								<div class="col-md-7">
									<select name="ssa_id" id="ssa_id" class="form-control">
											<option value="">Select</option>									
										<?php 
											$ssa_id = @$record['ssa_id'];
											if(isset($roles)) {
												foreach($circles as $rcd) {
													$selected = '';
													if($rcd['id'] == $ssa_id)
													{
														$selected = 'selected';
													}
													echo '<option value="'.$rcd['id'].'" '.$selected.'>'.$rcd['ssa_name'].'</option>';
												}
											}
										?>   									
								   </select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Other Details</label>
								<div class="col-md-7">
									<textarea name="other_note_details" id="other_note_details" class="form-control" placeholder="Add Other Notes/Details for Employee Here"><?php echo @$record['other_details']?></textarea>
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

						setTimeout(function(){window.location.href=BASE_URL+'users/list';},2000);
						
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
	
	$("#manage_register_form").validate({
		onkeyup: false,
		rules: {
			userId: {
				required: true,
				remote : BASE_URL+'admin/check_userId?id='+$('input[name="id"]').val(),
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
			circle_id: {
				required: true,				
			},
			ssa_id: {
				required: true,
			},		
		},
		messages: {
			userId:{
				remote: 'User Id Already Exist'
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
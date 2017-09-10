<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins custom-wdth">
				<div class="ibox-title">
					<h5>Add/Update User Details</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="javascript:;" id="manage_register_form" method="post">
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Name</label>
								<div class="col-md-7">
									<input type="text" class="form-control only-char-space" name="name" id="name"  placeholder="Name" value="<?php echo @$record['afe_name']?>">
									<input type="hidden" name="afe_id" value="<?php echo @$record['afe_id']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Email</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="email" id="email"  placeholder="Email" value="<?php echo @$record['afe_email']?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Mobile</label>
								<div class="col-md-7">
									<input type="text" class="form-control only-number" name="mobile" id="mobile"  placeholder="Mobile" value="<?php echo @$record['afe_mobile']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">PAN No</label>
								<div class="col-md-7">
									<input type="text" class="form-control only-alphaNum" name="pan_card" id="pan_card"  placeholder="PAN Card No" value="<?php echo @$record['afe_pan_card']?>" maxlength="10">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">User Address</label>
								<div class="col-md-7">
									<textarea name="address" id="address" class="form-control" placeholder="Address Details Here"><?php echo @$record['afe_address']?></textarea>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">Bank Account No</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="bank_account_no" id="bank_account_no"  placeholder="Bank Account No" value="<?php echo @$record['afe_bank_account_no']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Bank Name</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="bank_name" id="bank_name"  placeholder="Bank Name" value="<?php echo @$record['afe_bank_name']?>" maxlength="10">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-5 control-label">IFSC Code</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="bank_ifsc_code" id="bank_ifsc_code"  placeholder="Branch IFSC Code" value="<?php echo @$record['afe_bank_ifsc_code']?>">
								</div>
							</div>
							<div class="col-md-6">
								<label class="col-md-5 control-label">Branch Address</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="bank_branch_address" id="bank_branch_address"  placeholder="Branch Address" value="<?php echo @$record['afe_bank_branch_address']?>" maxlength="10">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12" style="text-align:center;">
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
		if($("#manage_register_form").valid()){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'afe-users/add',
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

						setTimeout(function(){window.location.href=BASE_URL+'afe-users/list';},2000);
						
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});	
	
	$("#manage_register_form").validate({
		onkeyup: false,
		rules: {
			name: {
				required: true,
				alphaSpace:true,
			},
			email: {
				//required: true,
				email: true,
				remote : BASE_URL+'admin/check_user_email?id='+$('input[name="id"]').val(),
			},
			mobile: {
				required: true,
				number:true,
				maxlength:10,
				minlength:10,
				remote : BASE_URL+'admin/check_user_mobile?id='+$('input[name="id"]').val(),
			},
			pan_card: {
				exactlength:10
			},
			afe_address: {
				required: true,	
				validAddress:true,				
			},
			bank_account_no: {
				required: true,
				number:true,
				maxlength:17,
				minlength:10
			},	
			bank_name: {
				required: true,
			},	
			bank_ifsc_code: {
				required: true,
				exactlength:11,
			},
			bank_branch_address: {
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
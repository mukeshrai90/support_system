
<div class="wrapper wrapper-content animated fadeInRight custom-wdth">
    <div class="row">
		<div class="col-lg-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Add/Edit Plans</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="javascript:;" id="manage-cms-form" method="post">
						<div class="form-group">
							<label class="col-md-4 control-label">Circle</label>
							<div class="col-md-8">
								<select name="circle_id" id="circle_id" class="form-control">
									<option value="">Select</option>									
									<?php 
										if(isset($circles)) {
											foreach($circles as $rcd) {
												$selected = '';
												if($rcd['circle_id'] == $record['circle_id']) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['circle_id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
											}
										}
									?>   									
							   </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Name
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Plan Name" class="form-control" name="plan_name" value="<?php echo @$record['plan_name']?>"> 
								<input type="hidden" name="referer" value="<?php echo $this->session->userdata('referer')?>" />
								<input type="hidden" name="plan_id" value="<?php echo !empty($record['plan_id']) ? EnCrypt($record['plan_id']) : ''?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Code
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Plan Code" class="form-control" name="plan_code" value="<?php echo @$record['plan_code']?>"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Rental
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Plan Monthly Rental" class="form-control only-number" name="plan_rental" value="<?php echo @$record['plan_rental']?>"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Features
							</label>
							<div class="col-lg-8">
								<textarea name="plan_features" id="plan_features" class="form-control" placeholder="Plan Features Here"><?php echo @$record['plan_features']?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								
							</label>
							<div class="col-lg-8">
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
jQuery(document).ready(function() {
	$(document).on('click','#manage-form',function(){
		if($("#manage-cms-form").valid()){
		
			showCustomLoader(true);
			$.ajax({
				url: BASE_URL+'cms/plans/add',
				type: 'POST',
				data: $('#manage-cms-form').serialize(),
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
	
	$("#manage-cms-form").validate({
		onkeyup: false,
		rules: {
			circle_id: {
				required: true,
			},
			plan_name: {
				required: true,
				alphaSpace:true,
			},
			plan_code: {
				//required: true,
			},
			plan_rental: {
				required: true,
				number: true,
			},
			plan_features: {
				//required: true,
			},			
		},
		messages: {
			plan_name:{
				remote: 'Plan Already Exist'
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
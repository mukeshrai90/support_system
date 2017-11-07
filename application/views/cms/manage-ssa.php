
<div class="wrapper wrapper-content animated fadeInRight custom-wdth">
    <div class="row">
		<div class="col-lg-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Add/Edit SSA</h5>
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
								<input type="text" placeholder="SSA Name" class="form-control" name="ssa_name" value="<?php echo @$record['ssa_name']?>"> 
								<input type="hidden" name="referer" value="<?php echo $this->session->userdata('referer')?>" />
								<input type="hidden" name="ssa_id" value="<?php echo !empty($record['ssa_id']) ? EnCrypt($record['ssa_id']) : ''?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Code
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="SSA Code" class="form-control" name="ssa_code" value="<?php echo @$record['ssa_code']?>"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Status
							</label>
							<div class="col-lg-8">
								<select name="ssa_status" id="ssa_status" class="form-control">
									<option value="1" <?php echo $record['ssa_status']== 1 ? 'selected="selected"':''?>>Active</option>
									<option value="0" <?php echo $record['ssa_status']== 0 ? 'selected="selected"':''?>>Inactive</option></select>
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
				url: BASE_URL+'cms/ssa/add',
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
			ssa_name: {
				required: true,
				alphaSpace:true,
				remote : BASE_URL+'cms/check_ssa_name?id='+$('input[name="ssa_id"]').val(),
			},
			ssa_code: {
				//required: true,
			},
			circle_id: {
				required: true,
			},
			ssa_status: {
				required: true,
			},			
		},
		messages: {
			circle_name:{
				remote: 'SSA Already Exist'
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
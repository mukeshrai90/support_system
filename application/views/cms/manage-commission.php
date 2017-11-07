<div class="wrapper wrapper-content animated fadeInRight custom-wdth">
    <div class="row">
		<div class="col-lg-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Add/Edit Commission</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="javascript:;" id="manage-cms-form" method="post">
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Commission Title
							</label>
							
							<?php 
								$flds_dsbld_sts = '';
								if(isset($is_rcd_updatable) && $is_rcd_updatable === false){
									$flds_dsbld_sts = 'disabled';
								}
							?>
							
							<div class="col-lg-8">
								<input required type="text" placeholder="Commission Title" class="form-control" name="title" value="<?php echo @$record['title']?>"> 
								<input type="hidden" name="referer" value="<?php echo $this->session->userdata('referer')?>" />
								<input type="hidden" name="id" value="<?php echo !empty($record['id']) ? EnCrypt($record['id']) : ''?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Commission For
							</label>
							<div class="col-lg-8">
								<select required name="type" id="type" class="form-control">
									<option value="">Select</option>
									<option value="3" <?php echo $record['type'] == 1 ? 'selected="selected"':''?>>Sales Partner</option>
									<option value="2" <?php echo $record['type'] == 2 ? 'selected="selected"':''?>>BSNL</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Commission Circle
							</label>
							<div class="col-lg-8">
								<select name="circle_id" id="circle_id" class="form-control" <?=$flds_dsbld_sts?>>
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
								Commission Percentage
							</label>
							<div class="col-lg-8">
								<input required type="text" placeholder="Commission Percentage" class="form-control only-float" name="rate" value="<?php echo @$record['rate']?>">
								<?php 
									if(empty($record)) {	
										echo '<span style="color:Red;font-size:10px;">This Rate will be applicable from next month</span>';
									}
								?>
							</div>
						</div>
						<!--<div class="form-group">
							<label class="col-lg-4 control-label">
								Status
							</label>
							<div class="col-lg-8">
								<select name="active" id="active" class="form-control">
									<option value="1" <?php echo $record['active'] == 1 ? 'selected="selected"':''?>>Active</option>
									<option value="0" <?php echo $record['active'] === 0 ? 'selected="selected"':''?>>Inactive</option></select>
							</div>
						</div> -->
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
				url: BASE_URL+'cms/commission/add',
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
			title: {
				required: true,
				alphaSpace:true,
			},
			type: {
				required: true,
			},
			circle_id: {
				required: true,
			},
			rate: {
				required: true,
				validAmount: true
			},
			status: {
				required: true,
			},			
		},
		messages: {

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
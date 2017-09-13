<style>
.level-2{margin-left:25px;}
.level-3{margin-left:50px;}
</style>

<?php 
$levelArray = array('first' => 'level-1','second' => 'level-2','third' => 'level-3');
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Add/Edit Circles</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="<?php echo BASE_URL.'machine-parts/add'?>" id="manage-cms-form" method="post">
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Name
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Circle Name" class="form-control" name="name" value="<?php echo @$record['circle_name']?>"> 
								<input type="hidden" name="referer" value="<?php echo $this->session->userdata('referer')?>" />
								<input type="hidden" name="circle_id" value="<?php echo !empty($record['circle_id']) ? EnCrypt($record['circle_id']) : ''?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Code
							</label>
							<div class="col-lg-8">
								<input type="text" placeholder="Circle Code" class="form-control" name="code" value="<?php echo @$record['circle_code']?>"> 
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">
								Status
							</label>
							<div class="col-lg-8">
								<select name="status" id="status" class="form-control">
									<option value="1" <?php echo $record['circle_status']== 1 ? 'selected="selected"':''?>>Active</option>
									<option value="0" <?php echo $record['circle_status']== 0 ? 'selected="selected"':''?>>Inactive</option></select>
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
				url: BASE_URL+'cms/circles/add',
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
			name: {
				required: true,
				alphaSpace:true,
				remote : BASE_URL+'cms/check_circle_name?id='+$('input[name="circle_id"]').val(),
			},
			code: {
				required: true,
			},
			status: {
				required: true,
			},			
		},
		messages: {
			name:{
				remote: 'Name Already Exist'
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
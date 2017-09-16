<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-8">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Bulk User Registration</h5>
					<a style="float:right;" href="javascript:;" id="download_sample" data-url="<?php echo BASE_URL.'assets/uploads/ticket_system_user_registration_data_sample.xlsx'?>">Download Sample</a>
				</div>
				<div class="ibox-content">
					
					<form class="form-horizontal" action="javascript:;" id="manage_upload_form" method="post">
						<!--<div class="form-group">
							<label class="col-lg-4 control-label">Select User Type</label>
							<div class="col-lg-7">
								<select name="user_type" id="user_type" class="form-control">
									<option value="">Select</option>									
									<option value="1">Employees</option>									
									<option value="2">Managers</option>   									
							   </select>
							</div>
						</div>-->
						<div class="form-group">
							<label class="col-lg-4 control-label">Upload CSV</label>
							<div class="col-lg-7">
								<input type="hidden" name="upload" value="true"/>
								<input class="upld_file" type="file" name="csv_file" id="csv_file"/>						
							</div>
						</div>												
						<div class="form-group">
							<label class="col-lg-4 control-label">
								
							</label>
							<div class="col-lg-7">
								<button class="btn btn-sm btn-primary" type="button" id="manage-form">Upload</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>

<script src="<?php echo ASSETS_URL?>admin/js/ajaxupload.3.5.js"></script>

<script>
$(document).ready(function() {
	
	$(document).on('click','#download_sample',function(){
		var url = $(this).data('url');
		$(this).attr('href', url);
	});
	
	$(document).on('click','#manage-form',function(){
		if($("#manage_upload_form").valid()){
		
			var formData = new FormData($("#manage_upload_form")[0]);
			
			showCustomLoader(true);		
			$.ajax({
				url: BASE_URL+'users/upload',
				type: 'POST',
				data: formData,
				dataType: 'json',
				async: false,				
				cache: false,
				contentType: false,
				processData: false,
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

						$('#csv_file').val('');
						
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
	
	$("#manage_upload_form").validate({
		onkeyup: false,
		rules: {
			user_type: {
				required: true,
			},
			csv_file: {
			    required: true,
			    //accept: "csv"
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
			
		},
		errorPlacement: function (error, element) {
			error.appendTo($(element).closest('div'));
		}
	});
	
	$(document).on('change','.upld_file',function(){	

		var imagePath = $(this).val();
		var pathLength = imagePath.length;
		var lastDot = imagePath.lastIndexOf(".");
		var fileType = imagePath.substring(lastDot,pathLength);	
		var fileType = fileType.toLowerCase();
		var allowedTypes = ['.xls', '.xlsx'];							

		if($.inArray(fileType,allowedTypes) == '-1') {			
			$(this).val('');
			swal('The uploaded file type is not allowed.\nAllowed types : xlsx');
			return false;
		}
		var fileSize = this.files[0].size;
		var sizeKB = fileSize/1024;
        if(parseInt(sizeKB) > 1024) {
            var sizeMB = sizeKB/1024;
			var sizeStr = sizeMB.toFixed(2);
            if(sizeStr > 10) {
				//$(this).val('');
				//swal("Sorry! We can't accept files with size greater than 10MB.\nPlease upload file with size less than 10MB.");
				//return false;
			}
        }
	});
});  
</script>

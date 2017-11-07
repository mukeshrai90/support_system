<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>User Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>BSNL ID : </b> 
							<?php echo $record['user_bsnl_id'] ? $record['user_bsnl_id'] : 'Not Available Yet'?>
						</li>
						<li class="list-group-item">
							<b>Name : </b> 
							<?php echo $record['user_full_name']?>
						</li>
						<li class="list-group-item ">
							<b>Email : </b> 
							<?php echo $record['user_email'] ? $record['user_email'] : 'NA'?>
						</li>
						<li class="list-group-item">
							<b>Mobile : </b> 
							<?php echo $record['user_mobile'] ?>
						</li>
						<li class="list-group-item">
							<b>Address : </b> 
							<?php echo $record['user_address'] ? $record['user_address'] : 'NA'?>
						</li>	
						<li class="list-group-item">
							<b>Created : </b> 
							<?php echo date('d-M-Y h:i a',strtotime($record['user_added_on']))?>
						</li>
						<li class="list-group-item">
							<b>SDCA : </b> 
							<?php echo $record['user_lead_sdca']?>
						</li>
					</ul>
				</div>
			</div>
        </div>
		
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Lead Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">	
						<li class="list-group-item">
							<b>Circle : </b> 
							<?php echo $record['circle_name']?>
						</li>
						<li class="list-group-item">
							<b>SSA : </b> 
							<?php echo $record['ssa_name']?>
						</li>
						<li class="list-group-item">
							<b>Plan : </b> 
							<?php echo $record['plan_name']?>
						</li>
						<li class="list-group-item">
							<b>Lead Source : </b> 
							<?php echo $lead_sources[$record['user_lead_source']]?>
						</li>
						<?php if($record['user_lead_source'] == 2) {?>
							<li class="list-group-item">
								<b>Sales Partner : </b> 
								<?php echo $record['afe_name']?>
							</li>
						<?php } ?>
						<li class="list-group-item">
							<b>Current Status : </b> 
							<?php echo $record['current_status']?>
						</li>
					</ul>
				</div>
			</div>
        </div>
		
		<?php 
			if(($can_change_status && !empty($lead_status))){
		?>
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Update Status</h5>
					</div>
					<div class="ibox-content" style="padding:8px 20px 1px;">
						<form class="form-horizontal" action="javascript:;" id="update-status-form">
							<div class="form-group">
								<label class="col-lg-3 control-label">Status</label>
								<div class="col-lg-8">
									<input type="hidden" value="<?=EnCrypt($record['user_id'])?>" name="lead_id">
									<select class="form-control" name="status_id" id="status_id"> 
										<option value="">Select</option>
										<?php 
											foreach($lead_status as $st){
												$value = $st['status_id'];
												$text = $st['status_name'];
												
												echo "<option value='$value'>$text</option>";
											}
										?>
									</select>
								</div>
							</div>	
							<!--<div class="form-group cpe_pmn_dv" style="display:none;">
								<label class="col-lg-3 control-label">Status</label>
								<div class="col-lg-8">
									<select class="form-control" name="cpe_payment_status" id="cpe_payment_status"> 
										<option value="Y">Payment Done</option>
										<option value="N">Payment Not Done</option>
									</select>
								</div>
							</div>-->
							<div class="form-group cpe_pmn_dv" style="display:none;">
								<label class="col-lg-3 control-label">Amount</label>
								<div class="col-lg-8">
									<input type="text" placeholder="Amount" class="form-control only-number" maxlength="5" name="cpe_payment_amnt">
								</div>
							</div>
							<div class="form-group cpe_pmn_dv" style="display:none;">
								<label class="col-lg-3 control-label">Mode</label>
								<div class="col-lg-8">
									<select class="form-control" name="cpe_payment_mode" id="cpe_payment_mode"> 
										<option value="Cash">Cash</option>
										<option value="Easy PAY">Easy PAY</option>
										<option value="Cheque">Cheque</option>
									</select>
								</div>
							</div>
							<div class="form-group caf_sts_dv" style="display:none;">
								<label class="col-lg-3 control-label">BSNL ID</label>
								<div class="col-lg-8">
									<input type="text" placeholder="BSNL User ID" class="form-control valid-bsnlid" name="bsnl_user_id">
								</div>
							</div>
							<div class="form-group caf_sts_dv" style="display:none;">
								<label class="col-lg-3 control-label">Act. Date</label>
								<div class="col-lg-8">
									<input type="text" placeholder="Activation Date" class="form-control" name="installation_date" id="installation_date">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Description</label>
								<div class="col-lg-8">
									<textarea class="form-control" name="description" id="description"></textarea>
								</div>
							</div>		
							<div class="form-group" id="upld_fl_dv" style="display:none;">							
								<label class="col-lg-3 control-label">Upload CAF</label>
								<div class="col-lg-8">
									<input type="file" class="form-control upld_file" name="upld_file[]" id="upld_file" style="padding:0;" multiple>
									<br/>
									<small style="color:red;width:100%;float:left;">Hold "[Ctrl]" for Multiple Files</small>
									<br/>
									<small style="color:red;width:100%;float:left;">Accepted Formats: PNG|JPG|JPEG|PDF</small>
									<br/>
									<small style="color:red;width:100%;float:left;">Max Size: 2MB</small>
								</div>							
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">
									
								</label>
								<div class="col-lg-8">
									<button class="btn btn-sm btn-primary" type="button" id="update-status-btn">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } ?>		
		

		<?php 
			if(!empty($lead_files)){
		?>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Leads File</h5>
					</div>
					<div class="ibox-content no-padding">
						<ul class="list-group">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="">#</th>	
										<th style="">File Type</th>
										<th style="">File</th>
										<th style="">Date/Time</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										
										$file_type_arr = array('1' => 'Application', '2' => 'CAF File', '3' => 'DNCS File', '4' => 'Installation & Activation File');
										
										if(!empty($lead_files)) { 
											$k = 1;
											foreach($lead_files as $rcd) { 
									?>
										<tr class="">
											<td><?php echo $k?></td>	
											<td><?php echo $file_type_arr[$rcd['file_type']]?></td>
											<td>
												<?php 
													if(!empty($rcd['file_name'])){
														$files = explode('*-*', $rcd['file_name']);
														
														foreach($files as $file){
															echo '<a class="vw-files-lnk" href="'.BASE_URL.'assets/uploads/leads/'.$file.'" target="_blank">View</a>';
														}
													}
												?>												
											</td>										
											<td><?=date('d-M-Y H:i a',strtotime($rcd['file_added_on']))?></td>	
										</tr>
									<?php 
											$k++;
											}
										}
										else
										{
											echo '<tr>
													<td colspan="4" align="center">No Files Uploaded</td>
												</tr>';
										}
									?>
								</tbody>
							</table>
						</ul>
					</div>
				</div>
			</div>
		<?php }	?>	
		
		<?php 
			if($can_see_logs){
		?>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Lead Logs</h5>
					</div>
					<div class="ibox-content no-padding">
						<ul class="list-group">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="">#</th>
										<th style="">Admin</th>	
										<th style="">Status</th>
										<th style="">Description</th>
										<th style="">Date/Time</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										if(!empty($lead_logs)) { 
											$k = 1;
											foreach($lead_logs as $log) { 
									?>
										<tr class="">
											<td><?php echo $k?></td>	
											<td><?php echo $log['admin_name'] != '' ? $log['admin_name'].' ['.$log['admin_username'].']' : '-NA-'?></td>
											<td><?php echo $log['status_name'] != '' ? $log['status_name'] : '-NA-';?></td>										
											<td><?php echo $log['call_desc']?></td>										
											<td><?php echo date('d-M-Y H:i a',strtotime($log['call_time']))?></td>	
										</tr>
									<?php 
											$k++;
											}
											
										} else {
											echo '<tr>
													<td colspan="5" align="center">No Logs</td>
												</tr>';
										}
									?>
								</tbody>
							</table>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>

	 </div>
</div>

<div id="myFilesViewerModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<a id="full-files-viewer" href="" target="_blank">Full View</a>
				<iframe id="files-viewer" style="width: 100%;height:400px;"></iframe>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo ASSETS_URL?>js/jquery.datetimepicker.js"></script>
<link href="<?php echo ASSETS_URL?>css/jquery.datetimepicker.css" rel="stylesheet">

<script>
jQuery(document).ready(function() {
	
	$("#installation_date").datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		validateOnBlur:false,
		maxDate:'<?php echo date('Y-m-d');?>',
		scrollInput:false
	});
	
	$(document).on('input', '.valid-bsnlid', function(){
		var $this = $(this);
		var regexp = /[^a-zA-Z0-9\_\-\.\/]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp, '')); 
		}
		return false;
	});
	
	$(document).on('change','#status_id',function(e){
		var stsId = $(this).val();
		$('.cpe_pmn_dv').hide();
		$('.instln_dv').hide();
		if(stsId == 2 || stsId == 3 || stsId == 4){
			$('#upld_fl_dv').show();
			$('#upld_fl_dv').find('label').html('Upload CAF');
			if(stsId == 2){
				$('.caf_sts_dv').show();
			} else if(stsId == 3){
				$('.cpe_pmn_dv').show();
				$('#upld_fl_dv').find('label').html('Upload DNCS File');
			} else if(stsId == 4){
				$('.instln_dv').show();
				$('#upld_fl_dv').find('label').html('Upload Inst & Act File');
			}
		}
	});
	
	$(document).on('click','#update-status-btn',function(){
		if($("#update-status-form").valid()){
			
			var status_id = $('#status_id').val();
			if($.inArray(status_id, ['2','3']) > -1){
				var files = $('.upld_file')[0].files;
				if(files.length <= 0){
					customAlertBox('Please Upload Files', 'e');
					return false;
				}
			}
			
			var formData = new FormData($("#update-status-form")[0]);
			
			showCustomLoader(true);		
			$.ajax({
				url: BASE_URL+'leads/change/status',
				type: "POST",
				dataType:'json',
				data: formData,
				async: false,				
				cache: false,
				contentType: false,
				processData: false,
				error: function(){
					showCustomLoader(false);		
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						customAlertBox(response.message);
						$('#update-status-form')[0].reset();
						setTimeout(function(){location.reload();},500);
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		} 
	});
		
	$("#update-status-form").validate({
		ignore: ':hidden',
		onkeyup: false,
		rules: {
			lead_id: {
				required: true,
			},
			status_id: {
				required: true,
			},
			description: {
				required: true,
				minlength: 10
			},	
			upld_file: {
				required: true,
			},
			cpe_payment_status: {
				required: true,
			},
			cpe_payment_amnt: {
				required: true,
				maxlength:5
			},
			cpe_payment_mode: {
				required: true,
			},
			bsnl_user_id: {
				required: true,
			},
			installation_date: {
				required: true,
			},
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
		},
		errorPlacement: function (error, element) {
			error.appendTo($(element).closest('div'));
		}
	});  
		
	$(document).on('change','.upld_file',function(){	
		var files = $(this)[0].files;
		
		if(files.length > 0){
			$.each(files, function(i, file){
				
				var imagePath = file.name;
				var pathLength = imagePath.length;
				var lastDot = imagePath.lastIndexOf(".");
				var fileType = imagePath.substring(lastDot,pathLength);	
				var fileType = fileType.toLowerCase();
				var allowedTypes = ['.png','.jpg','.jpeg','.pdf'];							

				if($.inArray(fileType,allowedTypes) == '-1') {			
					$(this).val('');
					swal('The uploaded file(s) type is not allowed.\nAllowed types : png,jpg,jpeg,pdf');
					return false;
				}
				
				var fileSize = file.size;
				var sizeKB = fileSize/1024;
				if(parseInt(sizeKB) > 1024) {
					var sizeMB = sizeKB/1024;
					var sizeStr = sizeMB.toFixed(2);
					if(sizeStr > 2)
					{
						$(this).val('');
						swal("Sorry! We can't accept files with size greater than 2MB.\nPlease upload file with size less than 2MB.");
						return false;
					}
				}
			});
		}
	});
	
	$(document).on('click','.vw-files-lnk',function(e){
		e.preventDefault();		
		var href = $(this).attr('href');
		try {				
			$('#full-files-viewer').attr('href', href);
			$('#files-viewer').attr('src', href);
			$('#myFilesViewerModal').modal('toggle');
		} catch (Error) {
			console.log(Error);
		}
		$('#view_document_div').show();
		
		$("html,body").animate({scrollTop:$('#view_document_div').offset().top},1000);
	});
});
</script>
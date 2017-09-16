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
							<b>AFE : </b> 
							<?php echo $record['afe_name']?>
						</li>
						<li class="list-group-item">
							<b>Current Status : </b> 
							<?php echo $record['current_status']?>
						</li>
					</ul>
				</div>
			</div>
        </div>
		
		<?php 
			if(($can_change_status && !empty($status_array)) || 1){
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
									<input type="hidden" value="<?=md5($ticket['id'])?>" name="ticket_id">
									<select class="form-control" name="status_id" id="status_id"> 
										<option value="">Select</option>
										<?php 
											foreach($status_array as $st){
												$value = $st['id'];
												$text = $st['title_short_text'];
												
												echo "<option value='$value'>$text</option>";
											}
										?>
									</select>
								</div>
							</div>		
							<?php			
								if(in_array($ticket['status'], array(12,19))) { 
							?>
								<div class="form-group">
									<label class="col-sm-3 control-label">Date</label>
									<div class="col-sm-8">
										<input type="text" class="form-control datepick" name="date" name="bill_amount" readOnly />
									</div>
								</div>
							<?php } ?>
							<div class="form-group">
								<label class="col-lg-3 control-label">Description</label>
								<div class="col-lg-8">
									<textarea class="form-control" name="description" id="description"></textarea>
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
			if(($role_id == 1 && $ticket['status'] > 6 && !in_array($ticket['status'],array(7,11))) || ($role_id == 5 && in_array($ticket['status'], array(13,15,17)))) { 
		?>
			
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>
							<?php 
								if($role_id == 5 && in_array($ticket['status'], array(13,17))){
									echo "Upload Purchase Order";
								} else {
									echo "Upload Bill/Invoices";
								}
							?>							
						</h5>
					</div>
					<div class="ibox-content">		
						<form method="post" class="form-horizontal" action="javascript:;" id="bill-form">
							<div class="form-group">
								<label class="col-sm-4 control-label">Ticket Id</label>
								<div class="col-sm-8">								
									<select class="form-control" name="ticket_id" ud="ticket_id">
										<option value="<?php echo @$ticket['id']?>"><?php echo @$ticket['ticket_id']?></option>
									</select>
									<input type="hidden" name="id" value="<?php echo @$info['id']?>"/>
									<input type="hidden" name="referer" value="<?php echo $this->session->userdata('referer');?>"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Amount</label>
								<div class="col-sm-8">
									<input type="text" class="form-control only-number" name="bill_amount" name="bill_amount" value="<?php echo @$info['amount']?>"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Short Desc</label>
								<div class="col-sm-8">
									<textarea name="description" id="description" class="form-control tinymce"><?php echo @$info['description']?></textarea>
								</div>
							</div>
							<div class="form-group">							
								<label class="col-lg-4 control-label">Upload Invoice/Bill</label>
								<div class="col-lg-8">
									<input type="file" class="form-control upld_file" name="bill_file" id="bill_file" style="padding:0;">
									<br/>
									<span style="color:red;width:100%;float:left;">Accepted Formats: PNG|JPG|JPEG|PDF|DOC<br/>DOCS|XLS|XSLX</span>
								</div>							
							</div>
							<div class="form-group">
								<label class="col-lg-4"></label>
								<div class="col-sm-8">
									<button class="btn btn-primary submit-btn" id="submit-btn" type="button">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>			
		<?php } ?>	
						
		<?php 
			if(!empty($bills)){
		?>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Ticket Invoices/Bills</h5>
					</div>
					<div class="ibox-content no-padding">
						<ul class="list-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th style="">#</th>
										<th style="">User</th>	
										<th style="">Amount</th>
										<th style="">Description</th>
										<th style="">Bill Type</th>
										<th style="">Invoice/Bill</th>
										<th style="">Date/Time</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										if(!empty($bills)) { 
											$k = 1;
											foreach($bills as $bill) { 
									?>
										<tr class="">
											<td><?php echo $k?></td>	
											<td><?php echo $bill['name'] != '' ? $bill['name'].' ('.$bill['emp_code'].')' : '-NA-'?></td>
											<td><?php echo CURRENCY_CONSTANT.' '.$bill['amount']?></td>
											<td><?php echo $bill['description']?></td>
											<td><?php echo $bill['bill_type'] == 1 ? 'PO' : 'Bill/Invoice'?></td>
											<td>
												<?php 
													if($bill['file'] != ''){
														echo '<a href="'.BASE_URL.'assets/uploads/bills/'.$bill['file'].'" target="_blank">View</a>';
													}
												?>												
											</td>										
											<td><?php echo date('d-M-Y H:i a',strtotime($bill['date_added']))?></td>	
										</tr>
									<?php 
											$k++;
											}
										}
										else
										{
											echo '<tr>
													<td colspan="4" align="center">No Bills Uploaded</td>
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
			if($can_see_logs || 1){
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

<script>
jQuery(document).ready(function() {

	$(document).on('change','#status_id',function(e){
		if($(this).val() == 16){
			if(!confirm('In this case this request will be changed to CarryIn Request.')){
				$(this).val('');
				return false;
			}
		}
	});
	
	$(document).on('click','#update-status-btn',function(){
		if($("#update-status-form").valid()){
			showCustomLoader(true);		
			$.ajax({
				url: BASE_URL+'tickets/change/status',
				type: "POST",
				dataType:'json',
				data: $('#update-status-form').serialize(),
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
						$('#update-status-form')[0].reset();
						setTimeout(function(){location.reload();},500);
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
		
	$("#update-status-form").validate({
		ignore: '',
		onkeyup: false,
		rules: {
			ticket_id: {
				required: true,
			},
			date: {
				required: true,
			},
			status_id: {
				required: true,
			},
			description: {
				required: true,
				minlength: 10
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
		
	$(document).on('input','.only-number',function(){ 		
		var $this = $(this);
		var regexp = /[^0-9\.]/g;
		var value = $this.val();
		
		if(value != '' && regexp.test(value)){			
			$this.val(value.replace(regexp,'')); 
		}
		return false;
	});
	
	$(document).on('click','#submit-btn',function(){
		if($("#bill-form").valid()){
			
			var formData = new FormData($("#bill-form")[0]);
			
			showCustomLoader(true);		
			$.ajax({
				type: 'POST',
				url: BASE_URL+'tickets/add/invoices',
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
						$('#bill-form')[0].reset();
						setTimeout(function(){window.location.reload();},2000);
						
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
	
	$("#bill-form").validate({
		rules: {
			ticket_id: {
				required: true,
			},
			bill_amount: {
				required: true,
			},
			description: {
				required: true,
			},
			bill_file: {
				//required: true,
			},
		 }
	});

	$(document).on('change','.upld_file',function(){	

		var imagePath = $(this).val();
		var pathLength = imagePath.length;
		var lastDot = imagePath.lastIndexOf(".");
		var fileType = imagePath.substring(lastDot,pathLength);	
		var fileType = fileType.toLowerCase();
		var allowedTypes = ['.png','.jpg','.jpeg','.pdf','.doc','.docs','.xls','.xlsx'];							

		if($.inArray(fileType,allowedTypes) == '-1') {			
			$(this).val('');
			swal('The uploaded file type is not allowed.\nAllowed types : png,jpg,jpeg,pdf,doc,docx,xls,xlsx');
			return false;
		}
		var fileSize = this.files[0].size;
		var sizeKB = fileSize/1024;
        if(parseInt(sizeKB) > 1024) {
            var sizeMB = sizeKB/1024;
			var sizeStr = sizeMB.toFixed(2);
            if(sizeStr > 10)
			{
				$(this).val('');
				swal("Sorry! We can't accept files with size greater than 10MB.\nPlease upload file with size less than 10MB.");
				return false;
			}
        }
	});
});
</script>
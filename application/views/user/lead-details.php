<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Personal Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>Employee Code :</b> 
							<?php echo $user['emp_code']?>
						</li>
						<li class="list-group-item">
							<b>Name :</b> 
							<?php echo $user['name']?>
						</li>								
						<li class="list-group-item">
							<b>Email :</b> 
							<?php echo $user['email']?>
						</li>	
						<li class="list-group-item">
							<b>Contact :</b> 
							<?php echo $user['mobile']?>
						</li>	
						<li class="list-group-item tooltip-demo">
							<b>Verified :</b>
							<?php 
								if($user['status'] == 0)
								{
									echo 
									'<a href="javascript:;" class="change-status" title="Pending" data-toggle="tooltip" data-placement="bottom" data-status="1" data-userid="'.$user['id'].'" data-field="status">
										<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
									</a> &nbsp;&nbsp;&nbsp;(Inactive)';
								}
								else if($user['status'] == 1)
								{
									echo 
									'<a href="javascript:;" class="change-status" title="Approved" data-toggle="tooltip" data-placement="bottom" data-status="0" data-userid="'.$user['id'].'" data-field="status">
										<i class="fa fa-star text-navy"></i>
									</a> &nbsp;&nbsp;&nbsp;(Active)';
								}								
							?>
						</li>	
					</ul>
				</div>
			</div>
        </div>	

		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Other Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">	
						<?php 
							if($user['role_id'] == 5){
						?>
							<li class="list-group-item ">
								<b>Manager :</b> 
								<?php echo $user['manager_emp_code']?>
							</li>
						<?php }	?>
						<li class="list-group-item">
							<b>Designation :</b> 
							<?php echo $user['designation']?>
						</li>
						<li class="list-group-item">
							<b>Department :</b> 
							<?php echo $user['department']?>
						</li>
						<li class="list-group-item">
							<b>Location :</b> 
							<?php echo $user['location'].' , '.$user['city']?>
						</li>
						<li class="list-group-item">
							<b>Date Added :</b> 
							<?php echo date('d-M-Y',strtotime($user['date_added']))?>
						</li>										
					</ul>
				</div>
			</div>
        </div>
		
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Machine Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">								
						<li class="list-group-item">							
							<?php 
								if($user['desktop_id'] != ''){
									echo '<b>Desktop Id</b>: '.$user['desktop_id'].'<br>';
								}
								if($user['laptop_id'] != ''){
									echo '<b>Laptop Id</b>: '.$user['laptop_id'];
								}
							?>
						</li>
						<li class="list-group-item">
							<b>Machine Specification :</b> 
							<?php echo $user['machine_specification']?>
						</li>
						<li class="list-group-item">
							<b>Other Notes :</b> 
							<?php echo $user['other_details']?>
						</li>											
					</ul>
				</div>
			</div>
        </div>
		
		<?php 
			if(1){
				
			$assigned_devices_status = array(0 => 'Not Assigned', 1 => 'Assigned', 2=> 'Surrended');
		?>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Assigned Devies</h5>
					</div>
					<div class="ibox-content no-padding">
						<ul class="list-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th style="">#</th>
										<th style="">Device Id</th>	
										<th style="">Device Name</th>
										<th style="">Device Type</th>
										<th style="">Device Specification</th>
										<th style="">Status</th>
										<th style="">Assigned Date</th>
										<th style="">Last updation date</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										if(!empty($user_devices)) { 
											$k = 1;
											foreach($user_devices as $row) { 
									?>
										<tr class="">
											<td><?php echo $k++?></td>	
											<td><?php echo $row['device_id'] ?></td>
											<td><?php echo $row['device_name']?></td>
											<td><?php echo $row['device_type']?></td>
											<td><?php echo $row['device_specification']?></td>
											<td><?php echo $assigned_devices_status[$row['assigned_status']]?></td>											
											<td><?php echo !empty($row['updated_date']) ? date('d-M-Y H:i a',strtotime($row['assigned_date'])) : 'NA'?></td>	
											<td><?php echo $row['updated_date'] != '0000-00-00 00:00:00' && !empty($row['updated_date']) ? date('d-M-Y H:i a',strtotime($row['updated_date'])) : 'NA'?></td>	
										</tr>
									<?php 											
											}
										}
										else
										{
											echo '<tr>
													<td colspan="6" align="center">No Devices Found</td>
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
			if($user['role_id'] == 5 || !empty($device_surrender_logs)){	

				$data['surrender_type'] = array(0 => 'Single Device', 1 => 'Full & Final', 2=> 'Surrended');
				$data['surrender_type'] = $surrender_type;
		?>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Devices Surrender Logs</h5>
					</div>
					<div class="ibox-content no-padding">
						<ul class="list-group">
							<?php $this->load->view('admin/elements/surrender-devices-logs-list', $$data);?>
						</ul>
					</div>
				</div>
			</div>
		<?php }	?>
    </div>
</div>

<script src="<?php echo ASSETS_URL?>js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js
"></script>
<script src="<?php echo ASSETS_URL?>js/plugins/tinymce/run.js"></script>

<script>
$(document).ready(function(){
	
	$(document).on('click','.change-status',function(){
        var status = $(this).attr('data-status');
		var UserId = $(this).attr('data-userid');
		var field = $(this).attr('data-field');
		var btn = $(this);
		
		var url = BASE_URL+'home/change_status?user_id='+UserId+'&status='+status+'&field='+field;
		
		swal({			
		  title:'',
		  text: "Are you sure you want change Status?",
		  showCancelButton: true,
		  confirmButtonColor: "#68AC35",
		  confirmButtonText: "Yes change",
		  closeOnConfirm: true
		},
		function(){		
		    showCustomLoader(true);
			$.ajax({
				type : 'POST',
				url : url,
				dataType: 'JSON',
				error : function(){
					showCustomLoader(false);					
				},
				success : function(response){
					showCustomLoader(false);
					console.log(response.status);
					if(response.status)
					{
						showToast('success',response.message);
						
						setTimeout(function(){
							window.location.reload();
						},100);
					}	
					else
					{
						showToast('error',response.message);
					}
				}
			});
			return false;
		});
	});
});
</script>
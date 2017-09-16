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
							<b>Name : </b> 
							<?php echo $user['name']?>
						</li>
						<li class="list-group-item ">
							<b>Username : </b> 
							<?php echo $user['username']?>
						</li>
						<li class="list-group-item">
							<b>Email : </b> 
							<?php echo $user['email'] != '' ? $user['email'] : 'Not Available'?>
						</li>
						<li class="list-group-item">
							<b>Contact : </b> 
							<?php echo $user['contact'] != '' ? $user['contact'] : 'Not Available'?>
						</li>						
						<li class="list-group-item tooltip-demo">
							<b>Status : </b>
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
						<li class="list-group-item">
							<b>Last Login : </b> 
							<?php 
								if(trim($user['last_login']) == '0000-00-00 00:00:00')
									echo 'No Login Yet';									
								else
									echo date('M-d-Y h:i a',strtotime($user['last_login']));
							?>
						</li>			
					</ul>
				</div>
			</div>
        </div>
		
		<?php 
			if($user['role_id'] == 2)
			{
		?>
		<div class="col-lg-10">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Access Details</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="<?php echo 'javascript:;'?>" id="manage-form" method="post">
						<?php 
							if(!empty($actions))
							{
								foreach($actions as $action)
								{
						?>						
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo str_replace('_',' ',$action['name'])?></label>
								<div class="col-sm-10">
									<?php 
										if(!empty($action['childs']))
										{
											foreach($action['childs'] as $child)
											{
												$checked = '';
												if(@$child['access'] == 1)
												{
													$checked = 'checked';
												}
									?>
											<label class="checkbox-inline my-checkbox-inline"> 
												<input type="checkbox" class="access_check" value="<?php echo strtolower($action['name'])?>" data-type="<?php echo $child['type']?>" <?php echo $checked?>> 
												<?php echo $child['name']?> 
											</label> 	   									
									<?php 
											}
										}
									?>
								</div>
							</div>
						<?php 
								}
							}
						?>	
						<div class="form-group">
							<label class="col-lg-2 control-label">
								
							</label>
							<div class="col-lg-10">
								<a href="<?php echo BASE_URL.'admin/access/admin/'.$user['id']?>">
									<button class="btn btn-sm btn-primary" type="button" id="manage-form">Update
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>	
		<?php } ?>
    </div>
</div>

<script>
$(document).ready(function(){
	
	setTimeout(function(){
		$('input:checkbox').attr('disabled',true);
	},100);
	
	/* $(document).on('click','.change-status',function(){
        var status = $(this).attr('data-status');
		var UserId = $(this).attr('data-userid');
		var field = $(this).attr('data-field');
		var btn = $(this);
		
		var url = BASE_URL+'admin/home/change_status?user_id='+UserId+'&status='+status+'&field='+field;
		
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
	}); */
});
</script>

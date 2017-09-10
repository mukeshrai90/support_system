<style>
.level-2{margin-left:25px;}
.level-3{margin-left:50px;}
</style>

<?php 
$levelArray = array('first' => 'level-1','second' => 'level-2','third' => 'level-3');
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-10">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Manage Access</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" action="<?php echo 'javascript:;'?>" id="manage-form" method="post">
						
						<?php
							$all_access_checked = '';
							if($have_admin_access){
								$all_access_checked = 'checked';
							}							
						?>
						
						<div class="form-group search-area">
							<label class="col-sm-2 control-label" style="margin-bottom:30px;">All Access</label>
							<div class="col-sm-10">
								<label class="checkbox-inline my-checkbox-inline"> 
									<input type="checkbox" class="access_check" value="all_access" data-type="" <?php echo $all_access_checked?>> 									
								</label> 
							</div>
						</div>
						
						<?php 
							if(!empty($actions))
							{
								$check_disabled = '';
								if(!empty($all_access_checked)) {
									$check_disabled = 'disabled';
								}
								
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
												<input type="checkbox" class="access_check checkboxes" value="<?php echo strtolower($action['name'])?>" data-type="<?php echo $child['type']?>" <?php echo $checked?> <?php echo $check_disabled?>> 
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
								<a href="<?php echo BASE_URL.'admin/list'?>">
									<button class="btn btn-sm btn-primary" type="button" id="manage-form">Finish</button>
								</a>
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
	
	$(document).on('click','.access_check',function(e){
		var btn = $(this);
		var action = btn.val();
		var type = btn.attr('data-type');
		var admin_id = '<?php echo $this->session->userdata('access_admin_id');?>';
		
		var access = 0;
		if(btn.is(':checked')) {
			access = 1;
		}
		
		if(action ==  'all_access'){
			if(access == 1){
				if(!confirm("Are you sure to give Full Access")){
					return false;
				}
			} else {
				$('.checkboxes').attr('disabled', false);			
			}
		}
		
		showCustomLoader(true);			
		$.ajax({
			type: 'POST',
			url: BASE_URL+'admin/access/update',
			dataType : 'JSON',
			data: {action:action,type:type,admin_id:admin_id,access:access},
			error: function(){
				showCustomLoader(false);
				swal({
				  title: "Alert!",
				  text: 'An internal error has occured.<br/>Unable to process your request right now',
				  type : 'error',
				  html : true,
				  timer: 5000
				});	
			},
			success: function(response){
				showCustomLoader(false);
				if(response.status) {					
					if(action ==  'all_access' && access == 1){
						window.location.href = BASE_URL+'admin/list';
					}				
				} else {
					swal({
					  title: "Alert!",
					  text: response.message,
					  type : 'error',
					  html : true,
					  timer: 5000
					});
				}
			}
		});
	});   
});
</script>

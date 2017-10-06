<style>
.actions-a{
	float: left;
    margin-right: 15px;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Employees </h5>	
					<?php 
						$pageUrl = BASE_URL.'employees/list';
						
						$actions = $this->session->userdata('access');
				
						$is_add_allowed = false;
						if(in_array(2, $actions['users'])){
							$is_add_allowed = true;
						}
						
						if($is_add_allowed) {
					?>
					<div class="ibox-tools">
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'csv-user_registration'?>">CSV Users Upload</button>
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'users/register'?>">Add New</button>
					<?php } ?>
					</div>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">Status</label>
								<select class="form-control" name="verified">
									<option value="">Select</option>
									<option value="1" <?php echo @$_GET['verified'] == 1 ? 'selected' : ''?>>Active</option>
									<option value="2" <?php echo @$_GET['verified'] === 2 ? 'selected' : ''?>>Inactive</option>									
								</select>	
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Name</label>
								<input type="text" placeholder="Search By Name" class="form-control" name="name" value="<?php echo @$_GET['name']?>">
							</div>
							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
								<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
							</div>
						</div>	
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/user-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
			<form action="<?php echo BASE_URL.'home/change_users_password'?>" id="change-password-form" method="post">		
				<div class="modal-body">						
					<input type="text" class="form-control" name="password" placeholder="Password"/>
					<br/>
					<input type="text" class="form-control" name="cpassword" placeholder="Confirm Password"/>
					<input type="hidden" class="form-control" name="user_id"/>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-primary m-t-n-xs" type="button" id="change-password-btn"><strong>Submit</strong></button>			
				</div>
			</form>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){	
	
	$(document).on('click','.change-password-link',function(){
		var user_id = $(this).attr('data-userid');
		$('input[name="user_id"]').val(user_id);
		
		$('#myModal').modal('toggle');
	});
	
	$(document).on('click','#change-password-btn',function(){        
		
		var url = BASE_URL+'home/change_users_password';
			
		showCustomLoader(true);
		$.ajax({
			type : 'POST',
			url : url,
			data : $('#change-password-form').serialize(),
			dataType: 'JSON',
			error : function(){
				showCustomLoader(false);
				showToast('error','Unable to change password');
			},
			success : function(response){
				showCustomLoader(false);				
				if(response.status)
				{
					$('#change-password-form')[0].reset();
					$('#myModal').modal('toggle');
					showToast('success',response.message);
				}	
				else
				{
					showToast('error',response.message);
				}
			}
		});
		return false;		
	});
	
	$(document).on('click','.change-status',function(){
        var status = $(this).attr('data-status');
		var UserId = $(this).attr('data-userid');
		var user_type = $(this).attr('data-roleid');;
		var field = $(this).attr('data-field');
		var btn = $(this);
		
		var url = BASE_URL+'home/change_status?&user_id='+UserId+'&status='+status+'&field='+field;
		
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
					if(response.status)
					{
						showToast('success',response.message);
						
						setTimeout(function(){
							window.location.reload();
						},200);
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
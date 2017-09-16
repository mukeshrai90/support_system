<style>
.fa{font-size:20px;}
</style>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Name</th>			
			<th>Roles</th>
			<th>Username</th>
			<th>Email</th>
			<th>Contact</th>
			<th>Status</th>			
			<th>Last Login</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($admins)) {
				foreach($admins as $admin) {
		?>
			<tr class="">
				<td><?php echo $admin['admin_name']?></td>				
				<td><?php echo $admin['roles']?></td>
				<td><?php echo $admin['admin_username']?></td>
				<td><?php echo $admin['admin_email'] ? $admin['admin_email'] : 'Not Available'?></td>
				<td><?php echo $admin['admin_mobile'] ? $admin['admin_mobile'] : 'Not Available'?></td>
				<td class="tooltip-demo">
					<?php 
						if($admin['admin_id'] == 1){
							echo 'Active';
						} else {
							if($admin['admin_status'] == 0) {
								echo 
								'<a href="javascript:;" class="change-status" title="Click to Approve" data-toggle="tooltip" data-placement="bottom" data-status="1" data-admin_id="'.EnCrypt($admin['admin_id']).'" data-field="status">
									<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
								</a> &nbsp;&nbsp;&nbsp;(Inactive)';
								
							} else if($admin['admin_status'] == 1) {
								echo 
								'<a href="javascript:;" class="change-status" title="Click to Disable" data-toggle="tooltip" data-placement="bottom" data-status="2" data-admin_id="'.EnCrypt($admin['admin_id']).'" data-field="status">
									<i class="fa fa-star text-navy"></i>
								</a> &nbsp;&nbsp;&nbsp;(Active)';
								
							} else if($admin['admin_status'] == 2) {
								echo 
								'<a href="javascript:;" class="change-status" title="Click to Enable" data-toggle="tooltip" data-placement="bottom" data-status="1" data-admin_id="'.EnCrypt($admin['admin_id']).'" data-field="status">
									<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
								</a> &nbsp;&nbsp;&nbsp;(Disabled)';
							}
						}
					?>
				</td>							
				<td><?php echo date('d-M-Y',strtotime($admin['admin_last_login']))?></td>
				<td class="tooltip-demo">
					<a href="javascript:;" title="Change Password" class="actions-a change-password-link" data-toggle="tooltip" data-placement="bottom" data-admin_id="<?php echo EnCrypt($admin['admin_id'])?>">
						<i class="fa fa-pencil text-navy"></i>
					</a>
					<a href="<?php echo BASE_URL.'admins/edit/'.EnCrypt($admin['admin_id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil text-navy"></i>
					</a>
					<a href="<?php echo BASE_URL.'admins/view/'.EnCrypt($admin['admin_id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a>									
				</td>
			</tr>
		<?php 
				}
			} else {
				echo '<tr>
						<td colspan="8" align="center">No Records found</td>
					</tr>';
			}
		?>
	</tbody>
</table>

<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<?php echo $links?>
</div>

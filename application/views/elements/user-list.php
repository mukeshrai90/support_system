<style>
.fa{font-size:20px;}
</style>

<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Employee Code</th>
			<th>Role</th>
			<th>Name</th>
			<th>Email</th>
			<th>Contact</th>
			<th>Status</th>
			<th>Designation</th>
			<th>Department</th>
			<th>Location</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($users))
			{
				$actions = $this->session->userdata('access');
				
				$is_edit_allowed = false;
				if(in_array(3, $actions['users'])){
					$is_edit_allowed = true;
				}
				
				$is_update_allowed = false;
				if(in_array(4, $actions['users'])){
					$is_update_allowed = true;
				}
				
				foreach($users as $user)
				{
		?>
			<tr class="">				
				<td><?php echo $user['emp_code']?></td>
				<td><?php echo $user['role_name']?></td>
				<td><?php echo $user['name']?></td>
				<td><?php echo $user['email']?></td>
				<td><?php echo $user['mobile']?></td>
				<td class="tooltip-demo">
					<?php 
						if($user['status'] == 0)
						{
							echo 
							'<a href="javascript:;" class="change-status" title="Pending" data-toggle="tooltip" data-placement="bottom" data-status="1" data-userid="'.$user['id'].'" data-field="status">
								<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
							</a> &nbsp;&nbsp;&nbsp;';
						}
						else if($user['status'] == 1)
						{
							echo 
							'<a href="javascript:;" class="change-status" title="Approved" data-toggle="tooltip" data-placement="bottom" data-status="0" data-userid="'.$user['id'].'" data-field="status">
								<i class="fa fa-star text-navy"></i>
							</a> &nbsp;&nbsp;&nbsp;';
						}
					?>
				</td>
				<td><?php echo $user['designation']?></td>
				<td><?php echo $user['department']?></td>
				<td><?php echo $user['location'].'<br/>'.$user['city']?></td>
				<td class="tooltip-demo">
					<?php 
						if($is_edit_allowed) {
					?>
						<a href="<?php echo BASE_URL.'employees/edit/'.md5($user['id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom" data-userid="<?php echo $user['id']?>">
							<i class="fa fa-pencil-square-o text-navy"></i>
						</a>
					<?php } ?>
					<a href="<?php echo BASE_URL.'employees/view/'.md5($user['id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a>
					
					<?php 
						if($is_update_allowed) {
					?>
						<a href="javascript:;" title="Change Password" class="actions-a change-password-link" data-toggle="tooltip" data-placement="bottom" data-userid="<?php echo $user['id']?>">
							<i class="fa fa-cog text-navy"></i>
						</a>
					<?php } ?>
				</td>
			</tr>
		<?php 
				}
			}
			else
			{
				echo '<tr>
						<td colspan="8" align="center">No Records found</td>
					</tr>';
			}
		?>
	</tbody>
</table>
<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<span class="pagination_head">Page No: </span>
	<?php echo $links?>
</div>
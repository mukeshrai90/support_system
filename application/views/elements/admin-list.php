<style>
.fa{font-size:20px;}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>			
			<th>Username</th>
			<th>Email</th>
			<th>Contact</th>
			<th>Verified</th>			
			<th>Registered On</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($admins))
			{
				foreach($admins as $admin)
				{
		?>
			<tr class="">
				<td><?php echo $admin['name']?></td>				
				<td><?php echo $admin['emp_code']?></td>
				<td><?php echo $admin['email']?></td>
				<td><?php echo $admin['mobile'] ? $admin['mobile'] : 'Not Available'?></td>
				<td class="tooltip-demo">
					<?php 
						if($admin['id'] == 1){
							echo 'Active';
						} else {
							if($admin['status'] == 0)
							{
								echo 
								'<a href="javascript:;" class="change-status" title="Click to Approve" data-toggle="tooltip" data-placement="bottom" data-status="1" data-adminid="'.$admin['id'].'" data-field="status">
									<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
								</a> &nbsp;&nbsp;&nbsp;(No)';
							}
							else if($admin['status'] == 1)
							{
								echo 
								'<a href="javascript:;" class="change-status" title="Click to Disable" data-toggle="tooltip" data-placement="bottom" data-status="2" data-adminid="'.$admin['id'].'" data-field="status">
									<i class="fa fa-star text-navy"></i>
								</a> &nbsp;&nbsp;&nbsp;(Yes)';
							}
							else if($admin['status'] == 2)
							{
								echo 
								'<a href="javascript:;" class="change-status" title="Click to Enable" data-toggle="tooltip" data-placement="bottom" data-status="1" data-adminid="'.$admin['id'].'" data-field="status">
									<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
								</a> &nbsp;&nbsp;&nbsp;(Disabled)';
							}
						}
					?>
				</td>							
				<td><?php echo date('m/d/y',strtotime($admin['created']))?></td>
				<td class="tooltip-demo">
					<a href="javascript:;" title="Change Password" class="actions-a change-password-link" data-toggle="tooltip" data-placement="bottom" data-adminid="<?php echo $admin['id']?>">
						<i class="fa fa-pencil-square-o text-navy"></i>
					</a>
					<a href="<?php echo BASE_URL.'admin/edit/'.md5($admin['id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil text-navy"></i>
					</a>
					<a href="<?php echo BASE_URL.'admin/view/'.md5($admin['id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a>
					<a href="<?php echo BASE_URL.'admin/access/manage/'.md5($admin['id'])?>" title="Manage Acess" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-key text-navy"></i>
					</a>									
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

	<?php echo $links?>

</div>

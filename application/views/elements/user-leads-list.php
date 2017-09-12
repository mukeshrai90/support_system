<style>
.fa{font-size:20px;}
</style>

<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Name</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Status</th>
			<th>Plan</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($users)) {
				foreach($users as $user) {
		?>
			<tr class="">				
				<td><?php echo $user['user_full_name']?></td>
				<td><?php echo $user['user_email']?></td>
				<td><?php echo $user['user_mobile']?></td>
				<td><?php echo $user['current_status']?></td>
				<td><?php echo $user['plan_name']?></td>
				<td class="tooltip-demo">
					<a href="<?php echo BASE_URL.'users-lead/edit/'.EnCrypt($user['user_id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom" data-userid="<?php echo $user['id']?>">
						<i class="fa fa-pencil-square-o text-navy"></i>
					</a>
					
					<a href="<?php echo BASE_URL.'users-lead/view/'.EnCrypt($user['user_id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
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
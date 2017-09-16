
<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Name</th>
			<th>Email</th>
			<th>Contact</th>
			<th>Address</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($users)) {
				foreach($users as $user) {
		?>
			<tr class="">				
				<td><?php echo $user['afe_name']?></td>
				<td><?php echo $user['afe_email'] ? $user['afe_email'] : 'NA'?></td>
				<td><?php echo $user['afe_mobile']?></td>
				<td><?php echo $user['afe_address'] ? $user['afe_address'] : 'NA'?></td>
				<td class="tooltip-demo">
					<?php 
						if($user['afe_status'] == 0) {
							echo 
							'<a href="javascript:;" class="change-status" title="Pending" data-toggle="tooltip" data-placement="bottom" data-status="1" data-userid="'.EnCrypt($user['afe_id']).'" data-field="status">
								<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
							</a> &nbsp;&nbsp;&nbsp;';
							
						} else if($user['afe_status'] == 1) {
							echo 
							'<a href="javascript:;" class="change-status" title="Approved" data-toggle="tooltip" data-placement="bottom" data-status="0" data-userid="'.EnCrypt($user['afe_id']).'" data-field="status">
								<i class="fa fa-star text-navy"></i>
							</a> &nbsp;&nbsp;&nbsp;';
						}
					?>
				</td>
				<td class="tooltip-demo">
					<a href="<?php echo BASE_URL.'afe-users/edit/'.EnCrypt($user['afe_id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil text-navy"></i>
					</a>
					
					<a href="<?php echo BASE_URL.'afe-users/view/'.EnCrypt($user['afe_id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
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
	<!--<span class="pagination_head">Page No: </span>-->
	<?php echo $links?>
</div>
<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Name</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Status</th>
			<th>Circle</th>
			<th>Plan</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($leads)) {
				foreach($leads as $rcd) {
		?>
			<tr class="">				
				<td><?php echo $rcd['user_full_name']?></td>
				<td><?php echo $rcd['user_email']?></td>
				<td><?php echo $rcd['user_mobile']?></td>
				<td><?php echo $rcd['current_status']?></td>
				<td><?php echo $rcd['circle_name']?></td>
				<td><?php echo $rcd['plan_name']?></td>
				<td class="tooltip-demo">
					
					<?php if($rcd['user_lead_status_id'] < 4) { ?>
						<a href="<?php echo BASE_URL.'leads/edit/'.EnCrypt($rcd['user_id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
							<i class="fa fa-pencil text-navy"></i>
						</a>
					<?php } ?>
					
					<a href="<?php echo BASE_URL.'leads/view/'.EnCrypt($rcd['user_id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
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
<table class="table table-bordered">
	<thead>
		<tr>			
			<th>#</th>
			<th>Name</th>
			<th>Mobile</th>
			<th>Status</th>
			<th>Circle</th>
			<th>Plan</th>
			<th>AFE</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				$k = 1;
				foreach($records as $rcd) {
		?>
			<tr class="">				
				<td><?php echo $k++;?></td>
				<td><?php echo $rcd['user_full_name']?></td>
				<td><?php echo $rcd['user_mobile']?></td>
				<td><?php echo $rcd['current_status']?></td>
				<td><?php echo $rcd['circle_name']?></td>
				<td><?php echo $rcd['plan_name']?></td>
				<td><?php echo $rcd['afe_name'].' ('.$rcd['afe_mobile'].')';?></td>
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
<table class="table table-bordered">
	<thead>
		<tr>			
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Plan</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				$i = 1;
				foreach($records as $rcd) {
		?>
			<tr class="">				
				<td><?php echo $i++?></td>
				<td><?php echo $rcd['user_full_name']?></td>
				<td><?php echo $rcd['user_email']?></td>
				<td><?php echo $rcd['user_mobile']?></td>
				<td><?php echo $rcd['plan_name'].' ['.$rcd['plan_rental'].']'?></td>
				<td><?php echo $rcd['current_status']?></td>
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
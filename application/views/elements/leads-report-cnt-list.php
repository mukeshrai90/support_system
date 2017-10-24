<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Sales Partner</th>
			<th>Mobile</th>
			<th>Circle</th>
			<th>SSA</th>
			<th>Total Leads</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				foreach($records as $rcd) {
		?>
			<tr class="">				
				<td><?php echo $rcd['afe_name']?></td>
				<td><?php echo $rcd['afe_mobile']?></td>
				<td><?php echo $rcd['circle_name']?></td>
				<td><?php echo $rcd['ssa_name']?></td>
				<td><?php echo $rcd['total_leads']?></td>
			</tr>
		<?php 
				}
			} else {
				echo '<tr>
						<td colspan="9" align="center">No Records found</td>
					</tr>';
			}
		?>
	</tbody>
</table>
<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<?php echo $links?>
</div>
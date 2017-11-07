<table class="table table-bordered">
	<thead>
		<tr>			
			<th>SSA</th>
			<th>Total Rentals</th>
			<th>Commision Rate</th>
			<th>Commision</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				foreach($records as $rcd) {
		?>
			<tr class="">				
				<td><?php echo $rcd['ssa_name']?></td>
				<td><?php echo $rcd['comm_total_amount']?></td>
				<td><?php echo $rcd['commission_rate'].'%'?></td>
				<td><?php echo $rcd['comm_amount'];?></td>
				<td class="tooltip-demo">
					<a href="<?php echo BASE_URL.'commissions/bsnl/view/leads?month='.$month.'&year='.$year.'&ssa='.EnCrypt($rcd['comm_ssa_id']).'&inner=true'?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a>
				</td>
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
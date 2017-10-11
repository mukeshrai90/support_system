<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Name</th>
			<th>Mobile</th>
			<th>Total Leads</th>
			<th>Total Plans Amt</th>
			<th>Incentive Rate</th>
			<th>Incentive</th>
			<th style="text-align:center !important;">Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				foreach($records as $rcd) {
		?>
			<tr class="">				
				<td><?php echo $rcd['admin_name']?></td>
				<td><?php echo $rcd['admin_mobile']?></td>
				<td><?php echo $rcd['incentive_total_leads']?></td>
				<td><?php echo $rcd['total_plans_amt']?></td>
				<td><?php echo $rcd['incentive_rate'].'%'?></td>
				<td><?php echo $rcd['incentive_amount'];?></td>
				<td align="center">
					<?php 
						
					?>
				</td>
				<td class="tooltip-demo">
					<?php 
						if($rcd['incentive_total_leads'] > 0){
					?>
						<a href="<?php echo BASE_URL.'incentives/cbh/view/leads?month='.$month.'&year='.$year.'&admin='.EnCrypt($rcd['admin_id']).'&inner=true'?>" title="View" class="actions-a inc_comm_detls_load_ajx" data-toggle="tooltip" data-placement="bottom">
							<i class="fa fa-eye text-navy"></i>
						</a>
					<?php } ?>
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
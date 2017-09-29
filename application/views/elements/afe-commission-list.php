<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Name</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Total Leads</th>
			<th>Total Leads Converted</th>
			<th>Total Plans Amt</th>
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
				<td><?php echo $rcd['afe_name']?></td>
				<td><?php echo $rcd['afe_email']?></td>
				<td><?php echo $rcd['afe_mobile']?></td>
				<td><?php echo $rcd['total_leads']?></td>
				<td><?php echo $rcd['total_leads']?></td>
				<td><?php echo $rcd['total_plans_amt']?></td>
				<td>
					<?php 
						echo $rcd['total_plans_amt'];
					?>
				</td>
				<td class="tooltip-demo">
					<a href="<?php echo BASE_URL.'commissions/afe/view/leads?month='.$month.'&afe='.EnCrypt($rcd['afe_id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
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
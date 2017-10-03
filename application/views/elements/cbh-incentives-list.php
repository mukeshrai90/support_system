<table class="table table-bordered">
	<thead>
		<tr>			
			<th>Name</th>
			<th>Mobile</th>
			<th>Total Leads</th>
			<th>Total Plans Amt</th>
			<th>Commision Rate</th>
			<th>Commision</th>
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
				<td><?php echo $rcd['afe_name']?></td>
				<td><?php echo $rcd['afe_mobile']?></td>
				<td><?php echo $rcd['commission_total_leads']?></td>
				<td><?php echo $rcd['total_plans_amt']?></td>
				<td><?php echo $rcd['commission_rate'].'%'?></td>
				<td><?php echo $rcd['commission_amount'];?></td>
				<td align="center">
					<?php 
						echo '<span class="sts_spn">'.$rcd['current_status'].'</span>';
						
						if((in_array($rcd['commission_status_id'], array(1,2,3,5,6)) && $logged_in_role_id == 3 && @$_GET['month'] != 'current') || (in_array($rcd['commission_status_id'], array(2,4)) && $logged_in_role_id == 2 && !empty($_GET['t']) && $_GET['t'] == 'pending')) {
							echo '<br/><span class="change_com_sts_spn" data-c="'.EnCrypt($rcd['commission_id']).'">Change</span>';
						}
					?>
				</td>
				<td class="tooltip-demo">
					<?php 
						if($rcd['commission_total_leads'] > 0){
					?>
						<a href="<?php echo BASE_URL.'commissions/afe/view/leads?month='.$month.'&year='.$year.'&afe='.EnCrypt($rcd['afe_id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
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
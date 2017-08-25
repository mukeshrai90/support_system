<table class="table table-striped">
	<thead>
		<tr>
			<th style="">#</th>
			<?php 
				if($show_user){
					echo '<th style="">User</th>';
				}
			?>	
			<th style="">Device Ids</th>	
			<th style="">Device Name</th>
			<th style="">Description</th>
			<th style="">Surrender Type</th>
			<th style="">Surrender Date</th>										
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($device_surrender_logs)) { 
				$k = 1;
				foreach($device_surrender_logs as $row) { 
		?>
			<tr class="">
				<td><?php echo $k++?></td>	
				<?php 
					if($show_user){
						echo '<td style="">'.$row['name'].' ('.$row['emp_code'].')</td>';
					}
				?>
				<td><?php echo $row['device_id'] ?></td>
				<td><?php echo $row['inv_device_name'] ? $row['inv_device_name'] : $row['device_name']?></td>
				<td><?php echo $row['description']?></td>
				<td><?php echo $surrender_type[$row['surrender_type']]?></td>											
				<td><?php echo date('d-M-Y H:i a',strtotime($row['surrender_date']))?></td>	
			</tr>
		<?php 											
				}
			}
			else
			{
				echo '<tr>
						<td colspan="6" align="center">No Logs Found</td>
					</tr>';
			}
		?>
	</tbody>
</table>
<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<?php echo $links?>
</div>
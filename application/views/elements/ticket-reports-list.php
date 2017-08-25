<style>
.fa{font-size:20px;}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th style="">#</th>
			<th style="">Name (Emp Code)</th>
			<th style="">TicketId</th>
			<th style="">Device Id</th>
			<th style="">Amount</th>
			<th style="">Description</th>
			<th style="">Status</th>
			<th style="">Created</th>			
			<th style="">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 		
			if(!empty($tickets)) { 
				$k = 1;
				foreach($tickets as $ticket){ 
					$ticket_id = md5($ticket['id']);
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td><?php echo $ticket['name'].' ('.$ticket['emp_code'].')'?></td>
				<td><?php echo $ticket['ticket_id']?></td>
				<td><?php echo $ticket['device_id'] != '' ? $ticket['device_id'].'<br/> ('.$ticket['device_type'].')' : 'NA';?></td>
				<td><?php echo $ticket['total_amount'] > 0 ? $ticket['total_amount'] : 'NA'?></td>				
				<td><?php echo $ticket['description']?></td>				
				<td><?php echo $ticket['status_name'];?></td>									
				<td><?php echo date('d-M-Y h:i a',strtotime($ticket['date_added']))?></td>									
				<td class="tooltip-demo">
					<a href="<?php echo BASE_URL.'ticket-reports/view/'.$ticket_id?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a>
				</td>
			</tr>
		<?php 
					$k++;
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
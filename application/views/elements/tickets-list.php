<style>
.fa{font-size:20px;}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th style="">#</th>
			<th style="">Name (Emp Code)</th>
			<th style="">TicketId</th>
			<th style="">Machine Type</th>
			<th style="">Request Type</th>
			<th style="">Category Type</th>
			<th style="">Status</th>
			<th style="">Created</th>			
			<th style="">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			if(!empty($tickets))
			{ 
				$actions = $this->session->userdata('access');
				$role_id = $this->session->userdata('role_id');
				
				$is_edit_allowed = false;
				if(in_array(3, $actions['tickets'])){
					$is_edit_allowed = true;
				}
				
				$is_update_allowed = false;
				if(in_array(4, $actions['tickets'])){
					$is_update_allowed = true;
				}
				
				$k = 1;
				foreach($tickets as $ticket)
				{ 
					$ticket_id = md5($ticket['id']);
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td><?php echo $ticket['name'].' ('.$ticket['emp_code'].')'?></td>
				<td><?php echo $ticket['ticket_id']?></td>
				<td><?php echo $ticket['machine_type']?></td>
				<td><?php echo $ticket['request_type']?></td>
				<td>
					<?php 
						echo $ticket['category_type'].'<br/>';
						if($ticket['category_type_id'] == 1){
							echo '('.$ticket['part'].')';
						} else {
							echo '('.$ticket['sw_name'].')';
						}
					?>
				</td>
				<td>
					<?php 
						echo $ticket['status_name'].'<br/>';
						
						$ticket_close_allowed_role_ids = $ticket['ticket_close_allowed_role_id'];
						$ticket_close_allowed_role_ids = explode(',', $ticket_close_allowed_role_ids);
						if(in_array($user['role_id'], $ticket_close_allowed_role_ids) && $ticket['ticket_close_allowed']) {
							echo "<a href='javascript:;' class='close-ticket-link' data-ticket='$ticket_id'>Close Ticket</a>";
						}					
					?>
				</td>									
				<td><?php echo date('d-M-Y h:i a',strtotime($ticket['date_added']))?></td>									
				<td class="tooltip-demo">
					<?php 
						if($user['id'] == $ticket['user_id'] && $is_edit_allowed) {
					?>
						<!--<a href="<?php echo BASE_URL.'tickets/edit/'.$ticket_id?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
							<i class="fa fa-pencil-square-o text-navy"></i>
						</a>-->
					<?php } ?>
					
					<a href="<?php echo BASE_URL.'tickets/view/'.$ticket_id?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a> 	
					
					<?php 
						if(!isset($no_link)){
					?>
					
						<a href="<?php echo BASE_URL.'tickets/print/'.$ticket_id?>" target="_blank" title="Print" class="actions-a" data-toggle="tooltip" data-placement="bottom">
							<i class="fa fa-print text-navy"></i>
						</a> 
						
						<?php 
							if(($role_id == 5 && $ticket['status'] == 13) || $role_id != 5) {
						?>					
							<a href="<?php echo BASE_URL.'tickets/add/invoices/'.$ticket_id?>" title="Upload Bill/Invoice" class="actions-a" data-toggle="tooltip" data-placement="bottom">
								<i class="fa fa-upload text-navy"></i>
							</a>
						<?php } ?>
					<?php } ?>
				</td>
			</tr>
		<?php 
					$k++;
				}
			}
			else {
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
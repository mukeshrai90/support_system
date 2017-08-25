<style>
.fa{font-size:20px;}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Purpose</th>			
			<th>Subject</th>
			<th>Description</th>
			<th>Mail or Text</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($emails))
			{
				$k = 1;
				foreach($emails as $email)
				{
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td><?php echo @$email['purpose']?></td>				
				<td><?php echo $email['subject'] ? $email['subject'] : 'NA'?></td>
				<td><?php echo strip_tags($email['description'])?></td>
				<td><?php echo @$email['text_or_email'] == 0 ? 'Mail' : 'Text'?></td>
				<td class="tooltip-demo">					
					<?php 
						if($email['text_or_email'] == 0){
					?>
						<a href="javascript:;" title="Send Test Email" class="actions-a send_test_email" data-toggle="tooltip" data-placement="bottom" data-id="<?php echo $email['id']?>">
							<i class="fa fa-envelope-o text-navy"></i>
						</a> 
					<?php } ?>
					<a href="<?php echo BASE_URL.'emails/edit/'.$email['id']?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil-square-o text-navy"></i>
					</a>
				</td>
			</tr>
		<?php 
				 $k++;
				}
			}
			else
			{
				echo '<tr>
						<td colspan="5" align="center">No Records found</td>
					 </tr>';
			}
		?>
	</tbody>
</table>
<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<?php echo $links?>
</div>
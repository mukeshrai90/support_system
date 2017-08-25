<style>
.fa{font-size:20px;}
.level-2{margin-left:35px;}
.level-3{margin-left:70px;}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records))
			{
				$k = 1;
				foreach($records as $record)
				{
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td>
					<?php echo $record['title'];?>					
				</td>
				<td class="tooltip-demo">
					<?php 
						if($record['status'] == 0)
						{
							echo 
							'<a href="javascript:;" class="change-status" title="Pending" data-toggle="tooltip" data-placement="bottom" data-status="1" data-userid="'.$record['id'].'" data-field="status">
								<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
							</a> &nbsp;&nbsp;&nbsp;(Inactive)';
						}
						else if($record['status'] == 1)
						{
							echo 
							'<a href="javascript:;" class="change-status" title="Approved" data-toggle="tooltip" data-placement="bottom" data-status="0" data-userid="'.$record['id'].'" data-field="status">
								<i class="fa fa-star text-navy"></i>
							</a> &nbsp;&nbsp;&nbsp;(Active)';
						}
					?>
				</td>
				<td class="tooltip-demo">										
					<a href="<?php echo BASE_URL.'request-types/edit/'.$record['id']?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
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
						<td colspan="3" align="center">No Records found</td>
					 </tr>';
			}
		?>
	</tbody>
</table>
<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
	<?php echo $links?>
</div>
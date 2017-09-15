
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Circle</th>
			<th>Code</th>
			<th>Rental</th>
			<th>Features</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				$k = 1;
				foreach($records as $rcd) {
					$plan_id = EnCrypt($rcd['plan_id']);
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td><?php echo $rcd['plan_name'];?></td>
				<td><?php echo $rcd['circle_name'];?></td>
				<td><?php echo $rcd['plan_code'];?></td>
				<td><?php echo $rcd['plan_rental'];?></td>
				<td><?php echo $rcd['plan_features'];?></td>
				<td class="tooltip-demo">
					<?php 
						if($rcd['plan_status'] == 0){
							echo 
							'<a href="javascript:;" class="change-status" title="Inactive" data-toggle="tooltip" data-placement="bottom" data-status="1" data-plan_id="'.$plan_id.'">
								<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
							</a> &nbsp;&nbsp;&nbsp;(Inactive)';
							
						} else if($rcd['plan_status'] == 1) {
							echo 
							'<a href="javascript:;" class="change-status" title="Active" data-toggle="tooltip" data-placement="bottom" data-status="0" data-plan_id="'.$plan_id.'">
								<i class="fa fa-star text-navy"></i>
							</a> &nbsp;&nbsp;&nbsp;(Active)';
						}
					?>
				</td>
				<td class="tooltip-demo">										
					<a href="<?php echo BASE_URL.'cms/plans/edit/'.$plan_id?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil-square-o text-navy"></i>
					</a>			
				</td>
			</tr>
		<?php 
				 $k++;
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
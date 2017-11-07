
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>For</th>
			<th>Rate</th>
			<td>Start Date</td>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($records)) {
				$k = 1;
				foreach($records as $rcd) {
		?>
			<tr class="">
				<td><?php echo $k?></td>
				<td><?php echo $rcd['title'];?></td>
				<td><?php if($rcd['type']=='2') echo 'Circle Branch Head';
						  elseif($rcd['type']=='3') echo 'Field Executive';
				?></td>
				<td><?php echo $rcd['rate'];?></td>
				<td><?php echo date('d-M-Y', strtotime($rcd['start_date']));?></td>
				<td class="tooltip-demo">
					<?php 
						if($rcd['active'] == 0){
							echo 
							'<a href="javascript:;" class="change-status" title="Inactive" data-toggle="tooltip" data-placement="bottom" data-status="1">
								<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
							</a> &nbsp;&nbsp;&nbsp;(Inactive)';
							
						} else if($rcd['active'] == 1) {
							echo 
							'<a href="javascript:;" class="change-status" title="Active" data-toggle="tooltip" data-placement="bottom" data-status="0">
								<i class="fa fa-star text-navy"></i>
							</a> &nbsp;&nbsp;&nbsp;(Active)';
						}
					?>
				</td>
				<td class="tooltip-demo">										
					<?php 
						if(is_cmsn_inctv_updatable($rcd)){
					?>
						<a href="<?php echo BASE_URL.'cms/incentive/edit/'.EnCrypt($rcd['id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
							<i class="fa fa-pencil text-navy"></i>
						</a>			
					<?php } ?>
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
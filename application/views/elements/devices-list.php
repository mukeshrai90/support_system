<style>
.fa{font-size:20px;}
</style>

<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Device Id</th>
			<th>Device Name</th>
			<th>Device Type</th>
			<th>Brand</th>			
			<th>Serial No</th>
			<th>RAM</th>
			<th>Status</th>					
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($devices)){
				
				$devices_status_arr = array(0 => 'Inactive', 1 => 'Active');
				$count = 1;
				foreach($devices as $device){
		?>
			<tr class="">
				<td><?php echo $count++;?></td>
				<td><?php echo $device['device_id']?></td>
				<td><?php echo $device['device_name']?></td>
				<td><?php echo $device['device_type']?></td>
				<td><?php echo $device['device_brand'] ? $device['device_brand'] : 'Not Available'?></td>				
				<td><?php echo $device['device_serial_no'] ? $device['device_serial_no'] : 'Not Available'?></td>				
				<td><?php echo $device['device_ram'] ? $device['device_ram'] : 'NA'?></td>				
				<td><?php echo $devices_status_arr[$device['device_status']]?></td>
				<td class="tooltip-demo">
					<a href="<?php echo BASE_URL.'devices-inventory/edit/'.md5($device['id'])?>" title="Edit" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-pencil-square-o text-navy"></i>
					</a>
					<a href="<?php echo BASE_URL.'device-details/view/'.md5($device['id'])?>" title="View" class="actions-a" data-toggle="tooltip" data-placement="bottom">
						<i class="fa fa-eye text-navy"></i>
					</a>										
				</td>
			</tr>
		<?php 
				}
			}
			else
			{
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
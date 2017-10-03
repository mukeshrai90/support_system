<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Personal Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>Name : </b> 
							<?php echo $record['afe_name']?>
						</li>
						<li class="list-group-item">
							<b>Email : </b> 
							<?php echo !empty($record['afe_email']) ? $record['afe_email'] : 'Not Available'?>
						</li>
						<li class="list-group-item">
							<b>Mobile : </b> 
							<?php echo !empty($record['afe_mobile']) ? $record['afe_mobile'] : 'Not Available'?>
						</li>						
						<li class="list-group-item tooltip-demo">
							<b>Status : </b>
							<?php 
								if($record['afe_status'] == 0) {
									echo '<a href="javascript:;" class="change-status" title="Inactive" data-toggle="tooltip" data-placement="bottom"  data-field="status">
										<i class="fa fa-star-o text-navy" style="color:#FF501E;"></i>
									</a> &nbsp;&nbsp;&nbsp;(Inactive)';
									
								} else if($record['afe_status'] == 1) {
									echo '<a href="javascript:;" class="change-status" title="Active" data-toggle="tooltip" data-placement="bottom" data-field="status">
										<i class="fa fa-star text-navy"></i>
									</a> &nbsp;&nbsp;&nbsp;(Active)';
								}								
							?>
						</li>									
					</ul>
				</div>
			</div>
        </div>
		
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Other Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>Circle : </b> 
							<?php echo $record['circle_name']?>
						</li>
						<li class="list-group-item">
							<b>SSA : </b> 
							<?php echo $record['ssa_name']?>
						</li>								
					</ul>
				</div>
			</div>
        </div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Bank Details</h5>
				</div>
				<div class="ibox-content no-padding">
					<ul class="list-group">
						<li class="list-group-item">
							<b>Bank Name : </b> 
							<?php echo $record['afe_bank_name']?>
						</li>
						<li class="list-group-item">
							<b>Account No : </b> 
							<?php echo $record['afe_bank_account_no']?>
						</li>
						<li class="list-group-item">
							<b>IFSC : </b> 
							<?php echo $record['afe_bank_ifsc_code']?>
						</li>						
						<li class="list-group-item">
							<b>Branch Address : </b> 
							<?php echo $record['afe_bank_branch_address']?>
						</li>								
					</ul>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
	
});
</script>

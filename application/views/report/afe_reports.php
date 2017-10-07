
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Reports </h5>
					<?php 
						$pageUrl = BASE_URL.'reports/afe';
					?>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;" target="_blank">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">From Date</label>
								<input type="text" placeholder="Select From Date" class="form-control datepickr" name="from_date" value="<?php echo @$_GET['from_date']?>">
							</div>
							
							<div class="col-md-3 form-group">
								<label class="control-label">To Date</label>
								<input type="text" placeholder="Select To Date" class="form-control datepickr" name="to_date" value="<?php echo @$_GET['to_date']?>">
							</div>
							<div class="col-md-3 form-group">
									<label class="control-label">AFE</label>
									<select class="form-control" name="afe">
										<option value="">Select</option>
										<?php 
											if(isset($afe_users)) {
												foreach($afe_users as $rcd) {
													$selected = '';
													if($rcd['afe_id'] == @DeCrypt($_GET['afe'])) {
														$selected = 'selected';
													}
													echo '<option value="'.EnCrypt($rcd['afe_id']).'" '.$selected.'>'.$rcd['afe_name'].'('.$rcd['afe_mobile'].')</option>';
												}
											}
										?>
									</select>	
								</div>
							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-primary">Get Report!</button>
								<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
							</div>
						</div>	
					</form>				
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){	
	$(".datepickr").datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		validateOnBlur:false,
		maxDate:'<?php echo date('Y-m-d');?>',
		scrollInput:false
	});
});

</script>
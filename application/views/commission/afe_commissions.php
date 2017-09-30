
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>
						AFE Commissions 
						<span id="com-mnth"><?=' | Month: '.date('M-y') ?></span>
					</h5>	
					<?php 
						$pageUrl = BASE_URL.'commissions/afe/list';
					?>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">AFE</label>
								<select class="form-control" name="circle">
									<option value="">Select</option>
									<?php 
										if(isset($afes)) {
											foreach($afes as $rcd) {
												$selected = '';
												if($rcd['afe_id'] == @$_GET['afe']) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['afe_id'].'" '.$selected.'>'.$rcd['afe_name'].'</option>';
											}
										}
									?>
								</select>	
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Year</label>
								<select class="form-control" name="year">
									<option value="">Select</option>
								</select>	
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Month</label>
								<select class="form-control" name="month">
									<option value="">Select</option>
								</select>	
							</div>
							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
								<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
							</div>
						</div>	
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/afe-commission-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';

$(document).ready(function(){	
	
});

</script>
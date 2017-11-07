<style>
.hdn_optn{display:none;}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>
						<?=$pageTitle?>
						<span class="subPageTitle">
							<i><?=$subPageTitle?></i>
						</span>
					</h5>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<?php if(!isset($fromPage)){ ?>
							<div class="col-lg-12 search-area">
								<div class="col-md-3 form-group">
									<label class="control-label">Circle</label>
									<select class="form-control" name="circle">
										<option value="">Select</option>
										<?php 
											if(isset($circles)) {
												foreach($circles as $rcd) {
													$selected = '';
													if($rcd['circle_id'] == @DeCrypt($_GET['circle'])) {
														$selected = 'selected';
													}
													echo '<option value="'.EnCrypt($rcd['circle_id']).'" '.$selected.'>'.$rcd['circle_name'].'</option>';
												}
											}
										?>
									</select>	
								</div>
								<?php 
									if(empty($_GET['m']) && empty($_GET['t'])){
								?>
									<div class="col-md-3 form-group">
										<label class="control-label">Month</label>
										<select class="form-control" name="month" id="mnth_slct">
											<?php 
												foreach($months_arr_gl as $k=>$m){
													$selected = '';
													if($month == $k){
														$selected = 'selected';
													}
													
													if($year == $current_year && $k > $current_month){
														echo "<option value='$k' $selected class='hdn_optn'>$m</option>";
													} else {
														echo "<option value='$k' $selected>$m</option>";
													}
												}
											?>
										</select>	
									</div>
									<div class="col-md-3 form-group">
										<label class="control-label">Year</label>
										<select class="form-control" name="year" id="yr_slct">
											<?php 
												for($i=$current_year; $i > $current_year-10; $i--){
													$selected = '';
													if($year == $i){
														$selected = 'selected';
													}
													echo "<option value='$i' $selected>$i</option>";
												}
											?>
										</select>	
									</div>
								<?php } ?>
								<div class="col-md-12">
									<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
									<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
								</div>
							</div>	
						<?php } ?>
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/bsnl-commission-circle-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';
var current_year = '<?=$current_year?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){	
	$(document).on('change', '#yr_slct', function(){
		var yr_slct = $(this).val();
		if(yr_slct === current_year){
			$('option.hdn_optn').hide();
		} else {
			$('option.hdn_optn').show();
		}
		
	});
});

</script>
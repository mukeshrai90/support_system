<style>
.hdn_optn{display:none;}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>
						<?php 
							if(isset($fromPage) && $fromPage == 'incentives') {
								echo 'Incentives Leads';
							} else {
								echo 'Sales Partner Commissions ';
							}
						?>
						
						<span class="subPageTitle">
							<i><?=$subPageTitle?></i>
						</span>
					</h5>
					
					<?php 
						if(isset($fromPage) && $fromPage == 'incentives') {
							$refrer = $this->agent->referrer();
							$inctv_htprfr = $this->session->userdata('inctv_htprfr');
							if(!empty($refrer) && empty($inctv_htprfr)){
								$this->session->set_userdata('inctv_htprfr', $refrer);
							}
							
							echo '<div class="ibox-tools">
										<button type="button" class="btn btn-sm btn-danger refresh-all add-new-btn" data-url="'.$this->session->userdata('inctv_htprfr').'">Back to Incentives</button>
								  </div>';
						} 
					?>
					<div class="ibox-tools">
						<?php 
							if(!empty($_SESSION['admin']['current_role_id']) && in_array($_SESSION['admin']['current_role_id'], array(2,7))){
						?>
							<button type="button" class="btn btn-sm btn-danger refresh-all add-new-btn" data-url="<?php echo BASE_URL.'commissions/afe/list?t=pending'?>">Pending For Approval</button>
						<?php } ?>
						
						<button type="button" class="btn btn-sm btn-danger refresh-all add-new-btn" data-url="<?php echo BASE_URL.'commissions/afe/list?m=current'?>">Current Month</button>
						
						<button type="button" class="btn btn-sm btn-danger refresh-all add-new-btn" data-url="<?php echo BASE_URL.'commissions/afe/list'?>">Previous Months</button>
				   </div>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<?php if(!isset($fromPage)){ ?>
							<div class="col-lg-12 search-area">
								<div class="col-md-3 form-group">
									<label class="control-label">Sales Partner</label>
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
						<?php $this->load->view('elements/afe-commission-list');?>
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
	$(document).on('click', '.change_com_sts_spn', function(){
		var c = $(this).data('c');
		var $this = $(this);
		
		if($this.siblings('.chnge_sts_slct').length && 0){
			$this.siblings('.chnge_sts_slct').show();
			$this.before('<span class="cncl_chnge_sts_spn">Cancel</span>');
			$this.hide();
		} else {
			showCustomLoader(true);		
			$.ajax({
				url: BASE_URL+'commissions/get/status',
				type: "POST",
				dataType:'json',
				data: {c:c},
				error: function(){
					showCustomLoader(false);		
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						$this.after(response.html);
						$this.before('<span class="cncl_chnge_sts_spn">Cancel</span>');
						$this.hide();
					} else{
						//customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
	
	$(document).on('click', '.cncl_chnge_sts_spn', function(){
		$(this).siblings('.change_com_sts_spn').show();
		$(this).siblings('.chnge_sts_slct').hide();
		$(this).remove();
	});
	
	$(document).on('change', '#yr_slct', function(){
		var yr_slct = $(this).val();
		if(yr_slct === current_year){
			$('option.hdn_optn').hide();
		} else {
			$('option.hdn_optn').show();
		}
		
	});
	
	$(document).on('change', '.chnge_sts_slct', function(){
		var s = $(this).val();
		var c = $(this).data('c');
		var $this = $(this);
		var t = $(this).find('option:selected').text();
		
		if($.trim(s) != ''){
			showCustomLoader(true);		
			$.ajax({
				url: BASE_URL+'commissions/change/status',
				type: "POST",
				dataType:'json',
				data: {s:s, c:c},
				error: function(){
					showCustomLoader(false);		
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success: function(response){
					showCustomLoader(false);		
					if(response.status){
						$this.siblings('.sts_spn').text(t);
						$this.siblings('.change_com_sts_spn').show();
						$this.siblings('.cncl_chnge_sts_spn').remove();
						$this.hide();
					} else{
						customAlertBox(response.message, 'e');
					}
				}
			});
		}
	});
});

</script>
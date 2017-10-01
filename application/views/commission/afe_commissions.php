
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
	$(document).on('click', '.change_com_sts_spn', function(){
		var c = $(this).data('c');
		var $this = $(this);
		
		if($this.siblings('.chnge_sts_slct').length){
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
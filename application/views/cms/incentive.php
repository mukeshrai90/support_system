<style>
.actions-a{
	float: left;
    margin-right: 15px;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>CBH/FE incentive</h5>	
					<?php 
						$pageUrl = BASE_URL.'cms/incentive/list';
					?>
					<div class="ibox-tools">
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'cms/incentive/add'?>">Add New</button>
					</div>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<div class="col-md-3 form-group">
							<label class="control-label">Type</label>
							<select class="form-control" name="type" id="type">
								<option value="">Select</option>
								<option value="">Select</option>
								<option value="3" <?php echo @$_GET['type'] == 3 ? 'selected="selected"':''?>>Field Executive</option>
								<option value="2" <?php echo @$_GET['type'] == 2 ? 'selected="selected"':''?>>Circle Branch Head</option>
							</select>	
						</div>
						<div class="col-md-3 form-group">
							<label class="control-label">Month</label>
							<select class="form-control" name="month" id="mnth_slct">
								<option value="">Select</option>
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
								<option value="">Select</option>
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
						<div class="col-md-12">
							<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
							<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
						</div>
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/incentive-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';
var hideTopBckBtn = 'YES';
$(document).ready(function(){	
	
});

</script>
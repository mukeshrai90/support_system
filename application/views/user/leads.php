
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Leads </h5>	
					<?php 
						$pageUrl = BASE_URL.'leads/list';
					?>
					<div class="ibox-tools">
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'leads/new-lead'?>">Add New</button>
					</div>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">Status</label>
								<select class="form-control" name="status">
									<option value="">Select</option>
									<?php 
										if(isset($status_arr)) {
											foreach($status_arr as $rcd) {
												$selected = '';
												if($rcd['status_id'] == @$_GET['status']) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['status_id'].'" '.$selected.'>'.$rcd['status_name'].'</option>';
											}
										}
									?>
								</select>	
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Name</label>
								<input type="text" placeholder="Search By Name" class="form-control" name="name" value="<?php echo @$_GET['name']?>">
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Circle</label>
								<select class="form-control" name="circle">
									<option value="">Select</option>
									<?php 
										if(isset($circles)) {
											foreach($circles as $rcd) {
												$selected = '';
												if($rcd['circle_id'] == @$_GET['circle']) {
													$selected = 'selected';
												}
												echo '<option value="'.$rcd['circle_id'].'" '.$selected.'>'.$rcd['circle_name'].'</option>';
											}
										}
									?>
								</select>	
							</div>
							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
								<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
							</div>
						</div>	
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/leads-list');?>
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
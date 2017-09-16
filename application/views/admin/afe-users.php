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
					<h5>AFE's </h5>	
					<?php 
						$pageUrl = BASE_URL.'afe-users/list';
					?>
					
					<div class="ibox-tools">
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'afe-users/add'?>">Add New</button>
					</div>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">Status</label>
								<select class="form-control" name="verified">
									<option value="">Select</option>
									<option value="1" <?php echo @$_GET['verified'] == 1 ? 'selected' : ''?>>Active</option>
									<option value="2" <?php echo @$_GET['verified'] === 2 ? 'selected' : ''?>>Inactive</option>									
								</select>	
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Name</label>
								<input type="text" placeholder="Search By Name" class="form-control" name="name" value="<?php echo @$_GET['name']?>">
							</div>

							<div class="col-md-12">
								<button type="button" class="btn btn-sm btn-primary search-btn">Search!</button>
								<button type="button" class="btn btn-sm btn-default refresh-all" data-url="<?php echo $pageUrl?>">Reset</button>
							</div>
						</div>	
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/afe-users-list');?>
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
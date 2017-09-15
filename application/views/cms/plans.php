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
					<h5>Plans </h5>	
					<?php 
						$pageUrl = BASE_URL.'cms/plans/list';
					?>
					<div class="ibox-tools">
						<button type="button" class="btn btn-sm btn-primary refresh-all add-new-btn" data-url="<?php echo BASE_URL.'cms/plans/add'?>">Add New</button>
					</div>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
						<div class="col-lg-12 search-area">
							<div class="col-md-3 form-group">
								<label class="control-label">Name</label>
								<input type="text" placeholder="Search By Name" class="form-control" name="name" value="<?php echo @$_GET['name']?>">
							</div>
							<div class="col-md-3 form-group">
								<label class="control-label">Circle</label>
								<select class="form-control" name="circle">
									<option value="">Select</option>
									<?php 
										$circle_id = @$_GET['circle'];
										if(isset($circles)) {
											foreach($circles as $rcd) {
												$selected = '';
												if($rcd['circle_id'] == $circle_id) {
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
						<?php $this->load->view('elements/plans-list');?>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var pageUrl = '<?php echo $pageUrl?>';

$(document).ready(function(){	
	$(document).on('click','.change-status',function(){
        var status = $(this).attr('data-status');
		var plan_id = $(this).attr('data-plan_id');		
		var btn = $(this);
		
		var url = BASE_URL+'cms/change_plans_status';
		
		swal({			
		  title:'',
		  text: "Are you sure you want change Status?",
		  showCancelButton: true,
		  confirmButtonColor: "#68AC35",
		  confirmButtonText: "Yes change",
		  closeOnConfirm: true
		},
		function(){		
		    showCustomLoader(true);
			$.ajax({
				type : 'POST',
				url : url,
				data: {plan_id:plan_id, status:status},
				dataType: 'JSON',
				error : function(){
					showCustomLoader(false);	
					customAlertBox('Unable to proocess your request right now.<br/> Please try again or some time later', 'e');
				},
				success : function(response){
					showCustomLoader(false);
					if(response.status) {
						customAlertBox(response.message);
						
						setTimeout(function(){
							window.location.reload();
						},200);
						
					} else {
						customAlertBox(response.message, 'e');
					}
				}
			});
			return false;
		});
	});
});

</script>
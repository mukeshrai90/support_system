
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>AFE Leads </h5>	
					<?php 
						$pageUrl = BASE_URL.'commissions/afe/list';
					?>
					<span class="subPageTitle">
						<?=$subPageTitle?>
					</span>
				</div>
				<div class="ibox-content">
					<form id="search-form" action="javascript:;">
							
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/afe-leads-list');?>
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
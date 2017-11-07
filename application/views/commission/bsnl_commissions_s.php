
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
							
					</form>
					<div class="table-responsive">
						<?php $this->load->view('elements/bsnl-commission-ssa-list');?>
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
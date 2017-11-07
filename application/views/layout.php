<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo @$pageTitle?></title>

<link rel="shortcut icon" type="image/png" href="<?php echo ASSETS_URL?>img/favicon.png"/>
<link href="<?php echo ASSETS_URL?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>font-awesome/css/font-awesome.min.css" rel="stylesheet">   
<link href="<?php echo ASSETS_URL?>css/animate.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>css/style.min.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>css/developer.css?v=1.3" rel="stylesheet">	
<script src="<?php echo ASSETS_URL?>js/jquery-2.1.1.js"></script>
<link href="<?php echo ASSETS_URL?>css/sweet-alert.css" rel="stylesheet">
<script src="<?php echo ASSETS_URL?>js/sweet-alert.min.js"></script>

<style>
.navbar-brand{height:52px;}
.table > thead > tr > th{font-size:11px;text-align:center;vertical-align:middle;}
/*.float-e-margins{width:70%;margin:0 auto;}*/
</style>
<script>
var BASE_URL = '<?php echo BASE_URL?>';
var ASSETS_URL = '<?php echo ASSETS_URL?>';
var pageTitle = '<?php echo $pageTitle?>';

$(document).ready(function(){
	$(document).ajaxComplete(function(x,xhr,settings){
	   if($.trim(xhr.responseText) === 'login-error'){
			swal('Your current session has been expired.Please login again.\n Redirecting you to login page...');
			setTimeout(function(){
				window.location.href = BASE_URL+'login';
			},2000);
	   } else if($.trim(xhr.responseText) === 'access-error'){
			swal('Sorry! You don\'t have permission.');
			setTimeout(function(){
				window.location.href = BASE_URL+'tickets/list';
			},2000);
	   }
	});
});
</script>
</head>

<body class="top-navigation">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom white-bg">
				<nav class="navbar navbar-static-top" role="navigation">
					<div class="navbar-header">
						<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
							<i class="fa fa-reorder"></i>
						</button>
						<a href="javascript:;" class="navbar-brand">Support System</a>
					</div>
					<div class="navbar-collapse" id="">
						<ul class="nav navbar-top-links navbar-right">
							<li>
								<a href="<?php echo BASE_URL.'profile/view'?>"><i class="fa fa-user"></i> Profile</a>
							</li>
							<li>
								<a href="<?php echo BASE_URL.'home/logout'?>"><i class="fa fa-sign-out"></i> Log out</a>
							</li>
						</ul>
						<div style="float:right;margin-right:45px;font-size:15px;color:red;">
							Welcome: <?=$_SESSION['admin']['name']?><br/>
							Last Login: <?=$_SESSION['admin']['last_login']?>
						</div>
					</div>
				</nav>
				<nav class="navbar navbar-static-top" role="navigation" style="border: 1px solid #ccc;">
					<div class="navbar-collapse collapse" id="navbar">
						<ul class="nav navbar-nav">
							<?php 						
								$admin_data = $this->session->userdata('admin');
								
								$role_id = $admin_data['current_role_id'];
								$actions = $admin_data['access'];
								
								$actions = array_keys($actions);						
							?>
							
							<?php 
								if(in_array('admins', $actions)) {
							?>
								<li class="<?php echo strstr($this->uri->segment(1), 'admins') == 'admins' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'admins/list'?>">
										<i class="fa fa-user-md"></i> 
										<span class="nav-label">Admin's</span>
									</a>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('afe_users', $actions)) {
							?>
								<li class="<?php echo strstr($this->uri->segment(1), 'afe-users')== 'afe-users' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'afe-users/list'?>">
										<i class="fa fa-user"></i> 
										<span class="nav-label">Sales Partner</span>
									</a>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('leads', $actions)) {
							?>
								<li class="<?php echo strstr($this->uri->segment(1),'leads')== 'leads' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'leads/list'?>">
										<i class="fa fa-share-square-o"></i> 
										<span class="nav-label">Leads</span>
									</a>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('afe_commissions', $actions) || in_array('bsnl_commissions', $actions)) {
							?>
								<li class="<?php echo $this->uri->segment(1) == 'commissions' ? 'active' : ''?>">
									<a aria-expanded="false" role="button" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-gears"></i> 
										<span class="nav-label">Commisions</span>
										<span class="caret"></span>
									</a>
									<ul role="menu" class="dropdown-menu">
										<li class="<?php echo strstr($this->uri->segment(2),'afe')== 'afe' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'commissions/afe/list?m=current'?>">
												<i class="fa fa-map-marker"></i>&nbsp;
												<span class="nav-label">Sales Partner</span>
											</a>
										</li>
										
										<?php 
											if(in_array('bsnl_commissions', $actions)) {
										?>
											<li class="<?php echo strstr($this->uri->segment(2),'bsnl')== 'bsnl' ? 'active' : ''?>">
												<a href="<?php echo BASE_URL.'commissions/bsnl/list'?>">
													<i class="fa fa-map-marker"></i>&nbsp;
													<span class="nav-label">BSNL</span>
												</a>
											</li>
										<?php } ?>
									</ul>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('fe_incentives', $actions) || in_array('cbh_incentives', $actions)) {
							?>
								<li class="<?php echo $this->uri->segment(1) == 'incentives' ? 'active' : ''?>">
									<a aria-expanded="false" role="button" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-gears"></i> 
										<span class="nav-label">Incentives</span>
										<span class="caret"></span>
									</a>
									<ul role="menu" class="dropdown-menu">
										<li class="<?php echo strstr($this->uri->segment(2),'fe')== 'fe' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'incentives/fe/list?m=current'?>">
												<i class="fa fa-map-marker"></i>&nbsp;
												<span class="nav-label">FE Incentive</span>
											</a>
										</li>
										
										<?php 
											if(in_array('bsnl_commissions', $actions)) {
										?>
											<li class="<?php echo strstr($this->uri->segment(2),'cbh')== 'cbh' ? 'active' : ''?>">
												<a href="<?php echo BASE_URL.'incentives/cbh/list?m=current'?>">
													<i class="fa fa-map-marker"></i>&nbsp;
													<span class="nav-label">CBH Incentive</span>
												</a>
											</li>
										<?php } ?>
									</ul>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('reports', $actions)) {
							?>
								<li class="<?php echo $this->uri->segment(1) == 'reports' ? 'active' : ''?>">
									<a aria-expanded="false" role="button" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-file-text-o"></i> 
										<span class="nav-label">Reports</span>
										<span class="caret"></span>
									</a>
									<ul role="menu" class="dropdown-menu">
										<li class="<?php echo $this->uri->segment(1) == 'reports' && $this->uri->segment(2) == 'leads' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'reports/leads'?>">
												<i class="fa fa-list-alt"></i>&nbsp;
												<span class="nav-label">Leads Report</span>
											</a>
										</li>
									</ul>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('cms', $actions)) {
							?>
								<li class="<?php echo $this->uri->segment(1) == 'cms' ? 'active' : ''?>">
									<a aria-expanded="false" role="button" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-gears"></i> 
										<span class="nav-label">CMS</span>
										<span class="caret"></span>
									</a>
									<ul role="menu" class="dropdown-menu">
										<li class="<?php echo strstr($this->uri->segment(2),'circles')== 'circles' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'cms/circles/list'?>">
												<i class="fa fa-map-marker"></i>&nbsp;
												<span class="nav-label">Circle Master</span>
											</a>
										</li>
										<li class="<?php echo strstr($this->uri->segment(2),'ssa')== 'ssa' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'cms/ssa/list'?>">
												<i class="fa fa-map-marker"></i>&nbsp;
												<span class="nav-label">SSA Master</span>
											</a>
										</li>
										<li class="<?php echo strstr($this->uri->segment(2),'plans')== 'plans' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'cms/plans/list'?>">
												<i class="fa fa-rupee"></i>&nbsp;&nbsp;
												<span class="nav-label">Plans Master</span>
											</a>
										</li>
										<li class="<?php echo strstr($this->uri->segment(2),'commission')== 'commission' && empty($_GET['t']) ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'cms/commission/list'?>">
												<i class="fa fa-rupee"></i>&nbsp;&nbsp;
												<span class="nav-label">Sales Partner Commission</span>
											</a>
										</li>
										<li class="<?php echo strstr($this->uri->segment(2),'commission')== 'commission' && !empty($_GET['t']) ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'cms/commission/list?t=2'?>">
												<i class="fa fa-rupee"></i>&nbsp;&nbsp;
												<span class="nav-label">BSNL Commission Master</span>
											</a>
										</li>
										<li class="<?php echo strstr($this->uri->segment(2),'incentive')== 'incentive' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'cms/incentive/list'?>">
												<i class="fa fa-rupee"></i>&nbsp;&nbsp;
												<span class="nav-label">CBH/FE Incentive</span>
											</a>
										</li>
									</ul>
								</li>
							<?php } ?>
						</ul>
					</div>
				</nav>
			</div>
			<div class="row back_to_lst_dv">
				<?php 
					$current_url = current_url();
					if(strstr($current_url, '/list') != '/list' && strstr($current_url, 'dashboard') != 'dashboard') {
						$refrer = $this->agent->referrer();
						if(!empty($refrer)){
							$this->session->set_userdata('http_referer', $refrer);
						}
						
						echo '<button type="button" class="btn btn-sm btn-warning refresh-all add-new-btn hideTopBckBtn" data-url="'.$this->session->userdata('http_referer').'">Back to Previous Page</button>';
					}
				?>				
			</div>
			<?php $this->load->view($content) ?>
		
		</div>
    </div>

<div id="myIncCommDtlsModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
				<!--<button class="btn btn-sm btn-primary m-t-n-xs incCommDtlsBckBtn" type="button"><strong>Back</strong></button>-->	
			</div>
			<div class="modal-body" style="padding: 2px;">						
					
			</div>
		</div>
	</div>
</div>

<?php 
	$flashMessage = '';$flashType = '';
	if($this->session->flashdata('success')){
		$flashType = 'success';
		$flashMessage = $this->session->flashdata('success');
	}
	else if($this->session->flashdata('error'))
	{
		$flashType = 'error';
		$flashMessage = $this->session->flashdata('error');
	}
?>	
	
<script src="<?php echo ASSETS_URL?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo ASSETS_URL?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/inspinia.js"></script>
<script src="<?php echo ASSETS_URL?>js/sweet-alert.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/developer.js?v=1.4"></script>
<script src="<?php echo ASSETS_URL?>js/jquery.datetimepicker.js"></script>

<link href="<?php echo ASSETS_URL?>css/jquery.datetimepicker.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>css/plugins/toastr/toastr.min.css" rel="stylesheet">

<style>

</style>
	
<script>
$(document).ready(function(){
	$('body').append('<div id="loading_overlay" style="display: none;"><div class="loading_message round_bottom"><img alt="loading" src="'+ASSETS_URL+'img/ajax_loader1.gif"></div>');
	
	var flashMessage = "<?php echo $flashMessage?>";
	var flashType = "<?php echo $flashType?>";
	if($.trim(flashType) === 'success') {
		showToast('success',flashMessage);
	} else if($.trim(flashType) === 'error') {
		showToast('error',flashMessage);
	}
});
function showCustomLoader(show)
{
	if(show) {
		$('#loading_overlay').show();
		$('body').addClass('loding-cursor');
	} else {
		$('#loading_overlay').hide();
		$('body').removeClass('loding-cursor');	
	}
}

function customAlertBox(text, type, timer, title){
	
	if(type == undefined){
		type = 'success';
	} else if(type == 'e'){
		type = 'error';
	} else if(type == 'w'){
		type = 'warning';
	}
	
	if(title == undefined){
		title = '';
	}
	
	if(timer == undefined){
		timer = 5000;
	}
	
	swal({
	  title: title,
	  text: text,
	  type : type,
	  html : true,	
	  timer: timer						  
	});
}

function showToast(type,message)
{
	toastr.options = {
		closeButton: true,
		progressBar: true,
		showMethod: 'fadeIn',
		timeOut: 4000
	};
	if($.trim(type) === 'success')
	{
		toastr.success(message);
	}
	else
	{
		toastr.error(message);
	}
}
	
</script>
</body>
</html>

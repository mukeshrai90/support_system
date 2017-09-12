<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo @$pageTitle?></title>

<link rel="shortcut icon" type="image/png" href="<?php echo ASSETS_URL?>frontend/images/favicon.png"/>
<link href="<?php echo ASSETS_URL?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>font-awesome/css/font-awesome.css" rel="stylesheet">   
<link href="<?php echo ASSETS_URL?>css/animate.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>css/style.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>css/developer.css?v=1.0" rel="stylesheet">	
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
					<div class="navbar-collapse collapse" id="navbar">
						<ul class="nav navbar-nav">
							<?php 						
								$role_id = $this->session->userdata('role_id');
								$actions = $this->session->userdata('access');
								$actions = array_keys($actions);						
							?>
							
							<?php 
								if(in_array('admins',$actions) || 1) {
							?>
								<li class="<?php echo strstr($this->uri->segment(1), 'admins') == 'admins' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'admins/list'?>">
										<i class="fa fa-user-md"></i> 
										<span class="nav-label">Admins</span>
									</a>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('afe-users',$actions) || 1) {
							?>
								<li class="<?php echo strstr($this->uri->segment(1), 'afe-users')== 'afe-users' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'afe-users/list'?>">
										<i class="fa fa-user"></i> 
										<span class="nav-label">AFE User's</span>
									</a>
								</li>
							<?php } ?>
							
							<?php 
								if(in_array('afe-users',$actions) || 1) {
							?>
								<li class="<?php echo strstr($this->uri->segment(1),'user-leads')== 'user-leads' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'user-leads/list'?>">
										<i class="fa fa-user-md"></i> 
										<span class="nav-label">User Leads</span>
									</a>
								</li>
							<?php } ?>
							
							<?php 
								/*if(in_array('ticket_reports',$actions) || in_array('expense_reports',$actions)) {
							?>
								<li class="<?php echo in_array($this->uri->segment(1),array('ticket-reports','expense-reports')) ? 'active' : ''?>">
									<a aria-expanded="false" role="button" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-bookmark"></i> 
										<span class="nav-label">Reports</span>
										<span class="caret"></span>
									</a>
									<ul role="menu" class="dropdown-menu">
										<li class="<?php echo strstr($this->uri->segment(1),'ticket-reports')== 'ticket-reports' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'ticket-reports/list'?>">Ticket Reports</a>
										</li>
										<li class="<?php echo strstr($this->uri->segment(1),'expense-reports')== 'expense-reports' ? 'active' : ''?>">
											<a href="<?php echo BASE_URL.'expense-reports/list'?>">Expense Reports</a>
										</li>
									</ul>
								</li>
							<?php } */?>
						</ul>
						<ul class="nav navbar-top-links navbar-right">
							<li>
								<a href="<?php echo BASE_URL.'home/logout'?>">
									<i class="fa fa-sign-out"></i> Log out
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
        
			<?php $this->load->view($content) ?>
		
		</div>
    </div>

<?php 
	$flashMessage = '';$flashType = '';
	if($this->session->flashdata('success'))
	{
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
<script src="<?php echo ASSETS_URL?>js/developer.js?v=1.0"></script>

<link href="<?php echo ASSETS_URL?>css/sweet-alert.css" rel="stylesheet">
<link href="<?php echo ASSETS_URL?>css/plugins/toastr/toastr.min.css" rel="stylesheet">

<style>

</style>
	
<script>
$(document).ready(function(){
	$('body').append('<div id="loading_overlay" style="display: none;"><div class="loading_message round_bottom"><img alt="loading" src="'+ASSETS_URL+'frontend/img/ajax_loader.gif"></div>');
	
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

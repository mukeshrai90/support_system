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
	<link href="<?php echo ASSETS_URL?>css/developer.css" rel="stylesheet">	
	<script src="<?php echo ASSETS_URL?>js/jquery-2.1.1.js"></script>
	<link href="<?php echo ASSETS_URL?>css/sweet-alert.css" rel="stylesheet">
	<script src="<?php echo ASSETS_URL?>js/sweet-alert.min.js"></script>
	
<script>
var BASE_URL = '<?php echo BASE_URL?>';
var ASSETS_URL = '<?php echo ASSETS_URL?>';
var pageTitle = '<?php echo $pageTitle?>';

$(document).ready(function(){
	$(document).ajaxComplete(function(event,xhr,settings){
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

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation" style="height:100%;overflow-y:scroll;">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
							<span>
								<img alt="image" class="img-circle" src="<?php echo ASSETS_URL?>img/profile_small.png" style="width:45px;"/>
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
								<span class="clear"> 
									<span class="block m-t-xs" style="width:auto;float:left;"> 	
										<strong class="font-bold"><?php echo $this->session->userdata('name')?></strong>
									</span>
									<span class="text-muted text-xs block" style="margin:4px 13px;float:left;">
										<b class="caret"></b>
									</span>
								</span> 
							</a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li>
									<a href="<?php echo BASE_URL.'profile/view'?>">Profile</a>
								</li>
                                <li>
									<a href="<?php echo BASE_URL.'profile/view'?>">Change Password</a>
								</li>
                                <li class="divider"></li>
                                <li>
									<a href="<?php echo BASE_URL.'home/logout'?>">Logout</a>
								</li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            Ticket System
                        </div>
                    </li>
					
					<?php 						
						$role_id = $this->session->userdata('role_id');
						$actions = $this->session->userdata('access');
						$actions = array_keys($actions);						
					?>
					
                    <!--<li class="<?php echo strstr($this->uri->segment(1),'dashboard') == 'dashboard' ? 'active' : ''?>">
                        <a href="<?php echo BASE_URL.'dashboard'?>">
							<i class="fa fa-th-large"></i> 
							<span class="nav-label">Dashboard</span> 
						</a>
                    </li>-->
					
					<?php 
						if(in_array('users',$actions)) {
					?>
						<li class="<?php echo strstr($this->uri->segment(1),'employees')== 'employees' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'employees/list'?>">
								<i class="fa fa-user"></i> 
								<span class="nav-label">Employees</span>
							</a>
						</li>
					<?php } ?>
					
					<?php 
						if($this->session->userdata('admin_id') == 1) {
					?>
						<li class="<?php echo strstr($this->uri->segment(1),'admin')== 'admin' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'list'?>">
								<i class="fa fa-user-md"></i> 
								<span class="nav-label">Admin Users</span>
							</a>
						</li>
					<?php } ?>
					
					<?php 
						if(in_array('tickets',$actions) && in_array($role_id,array(1,5,6))) {
					?>
						<li class="<?php echo strstr($this->uri->segment(1),'tickets')== 'tickets' && $this->uri->segment(3) != 'assigned' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'tickets/list'?>">
								<i class="fa fa-ticket"></i> 
								<?php 
									if(in_array($role_id,array(1,6))){
										echo '<span class="nav-label">All Tickets</span>';
									} else {
										echo '<span class="nav-label">My Tickets</span>';
									}
								?>
								
							</a>
						</li>
					<?php } ?>		

					<?php 
						if(in_array('assigned_tickets',$actions)) {
					?>
						<li class="<?php echo strstr($this->uri->segment(3),'assigned')== 'assigned' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'tickets/list/assigned'?>">
								<i class="fa fa-ticket"></i> 
								<span class="nav-label">Assigned Tickets</span>
							</a>
						</li>
					<?php } ?>
					
					<?php
						if(in_array('assign_devices',$actions)) {
					?>
						<li class="<?php echo strstr($this->uri->segment(1),'assign-devices')== 'assign-devices' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'assign-devices'?>">
								<i class="fa fa-exchange"></i> 
								<span class="nav-label">Assign Devices</span>
							</a>
						</li>
					<?php } ?>
					
					<?php 
						if(in_array('devices',$actions)) {
					?>
						<li class="<?php echo strstr($this->uri->segment(1),'devices-inventory')== 'devices-inventory' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'devices-inventory/list'?>">
								<i class="fa fa-folder"></i> 
								<span class="nav-label">Devices Inventory</span>
							</a>
						</li>
					<?php } ?>
					
					<?php 
						if(in_array('devices',$actions)) {
					?>
						<li class="<?php echo strstr($this->uri->segment(1),'surrender-devices-logs')== 'surrender-devices-logs' ? 'active' : ''?>">
							<a href="<?php echo BASE_URL.'surrender-devices-logs/list'?>">
								<i class="fa fa-truck"></i> 
								<span class="nav-label">Surrender Log</span>
							</a>
						</li>
					<?php } ?>
					
					<?php 
						if(in_array('ticket_reports',$actions) || in_array('expense_reports',$actions)) {
					?>
						<li class="<?php echo in_array($this->uri->segment(1),array('ticket-reports','expense-reports')) ? 'active' : ''?>">
							<a href="javascript:;">
								<i class="fa fa-bookmark"></i> 
								<span class="nav-label">Reports</span> <span class="fa arrow"></span>
							</a>
							<ul class="nav nav-second-level <?php echo in_array($this->uri->segment(2),array('ticket-reports','expense-reports')) ? 'in' : ''?>">
								<li class="<?php echo strstr($this->uri->segment(1),'ticket-reports')== 'ticket-reports' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'ticket-reports/list'?>">Ticket Reports</a>
								</li>
								<li class="<?php echo strstr($this->uri->segment(1),'expense-reports')== 'expense-reports' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'expense-reports/list'?>">Expense Reports</a>
								</li>
							</ul>
						</li>
					<?php } ?>

					<?php 
						if(in_array('cms',$actions)) {
					?>
						<li class="<?php echo in_array($this->uri->segment(1),array('categories','request-types','machine-types','machine-parts','emails')) ? 'active' : ''?>">
							<a href="javascript:;">
								<i class="fa fa-gear"></i> 
								<span class="nav-label">CMS</span> <span class="fa arrow"></span>
							</a>
							<ul class="nav nav-second-level <?php echo in_array($this->uri->segment(2),array('categories','request-types','machine-types','machine-parts','emails')) ? 'in' : ''?>">
								<li class="<?php echo strstr($this->uri->segment(1),'categories')== 'categories' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'categories/list'?>">Categories</a>
								</li>
								<li class="<?php echo strstr($this->uri->segment(1),'request-types')== 'request-types' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'request-types/list'?>">Request Types </a>
								</li>
								<li class="<?php echo strstr($this->uri->segment(1),'machine-types')== 'machine-types' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'machine-types/list'?>">Machine Types </a>
								</li>
								<li class="<?php echo strstr($this->uri->segment(1),'machine-parts')== 'machine-parts' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'machine-parts/list'?>">Machine Parts </a>
								</li>
								<li class="<?php echo strstr($this->uri->segment(1),'emails')== 'emails' ? 'active' : ''?>">
									<a href="<?php echo BASE_URL.'emails/list'?>">Msg Templates </a>
								</li>
							</ul>
						</li>
					<?php } ?>
                </ul>
            </div>
        </nav>	
		<div id="page-wrapper" class="gray-bg dashbard-1" style="height:100%;min-height:none;">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:;">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<ul class="nav navbar-top-links navbar-right">
						<li>
							<span class="m-r-sm text-muted welcome-message">Ticket System</span>
						</li>
						
						<li>
							<a href="<?php echo BASE_URL.'home/logout'?>">
								<i class="fa fa-sign-out"></i> 
								Log out
							</a>
						</li>
					</ul>
				</nav>
			</div>
		
			<?php $this->load->view($content) ?>
		
		</div>						
		
		<!--
        <div class="small-chat-box fadeInRight animated">
            <div class="heading" draggable="true">
                <small class="chat-date pull-right">
                    02.19.2015
                </small>
                Small chat
            </div>

            <div class="content">
                <div class="left">
                    <div class="author-name">
                        Monica Jackson <small class="chat-date">
                        10:02 am
                    </small>
                    </div>
                    <div class="chat-message active">
                        Lorem Ipsum is simply dummy text input.
                    </div>
                </div>
                <div class="right">
                    <div class="author-name">
                        Mick Smith
                        <small class="chat-date">
                            11:24 am
                        </small>
                    </div>
                    <div class="chat-message">
                        Lorem Ipsum is simpl.
                    </div>
                </div>
                <div class="left">
                    <div class="author-name">
                        Alice Novak
                        <small class="chat-date">
                            08:45 pm
                        </small>
                    </div>
                    <div class="chat-message active">
                        Check this stock char.
                    </div>
                </div>
                <div class="right">
                    <div class="author-name">
                        Anna Lamson
                        <small class="chat-date">
                            11:24 am
                        </small>
                    </div>
                    <div class="chat-message">
                        The standard chunk of Lorem Ipsum
                    </div>
                </div>
                <div class="left">
                    <div class="author-name">
                        Mick Lane
                        <small class="chat-date">
                            08:45 pm
                        </small>
                    </div>
                    <div class="chat-message active">
                        I belive that. Lorem Ipsum is simply dummy text.
                    </div>
                </div>
            </div>
            <div class="form-chat">
                <div class="input-group input-group-sm"><input type="text" class="form-control"> 
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button">Send</button> 
					</span>
				</div>
            </div>
        </div>
        <div id="small-chat">
            <span class="badge badge-warning pull-right">5</span>
            <a class="open-small-chat">
                <i class="fa fa-comments"></i>
            </a>
        </div>
		-->
		<!--<div class="footer">
			<footer style="float:left;width:100%;">
				ALL RIGHTS RESERVED. Copyright © 2017 b4S Solutions Pvt. Ltd
			</footer>
		</div>-->
	
    </div>        

<style>
.footer > footer {
    color: #f9f9f9;
    font-size: 15px;
    text-align: center;
}
.footer {
    background-color: #2f4050;
    float: none;
    position: fixed;
    width: 100%;
    z-index: 2002;
}
</style>

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
<link href="<?php echo ASSETS_URL?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
<script src="<?php echo ASSETS_URL?>js/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo ASSETS_URL?>js/inspinia.js"></script>
<link href="<?php echo ASSETS_URL?>frontend/css/sweet-alert.css" rel="stylesheet">
<script src="<?php echo ASSETS_URL?>frontend/js/sweet-alert.min.js"></script>\
<script src="<?php echo ASSETS_URL?>js/plugins/validate/jquery.validate.min.js"></script>
	
<script>
$(document).ready(function(){
	$('body').append('<div id="loading_overlay" style="display: none;"><div class="loading_message round_bottom"><img alt="loading" src="'+ASSETS_URL+'frontend/images/ajax_loader.gif"></div>');
	
	var flashMessage = "<?php echo $flashMessage?>";
	var flashType = "<?php echo $flashType?>";
	if($.trim(flashType) === 'success')
	{
		showToast('success',flashMessage);
	}
	else if($.trim(flashType) === 'error')
	{
		showToast('error',flashMessage);
	}	
});
function showCustomLoader(show)
{
	if(show)
	{
		$('#loading_overlay').show();
		$('body').addClass('loding-cursor');
	}
	else
	{
		$('#loading_overlay').hide();
		$('body').removeClass('loding-cursor');	
	}
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

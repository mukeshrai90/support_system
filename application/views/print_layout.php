<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title><?php echo $pageTitle;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
	<link href="<?php echo ASSETS_URL?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ASSETS_URL?>font-awesome/css/font-awesome.css" rel="stylesheet">   
    <link href="<?php echo ASSETS_URL?>css/animate.css" rel="stylesheet">
    <link href="<?php echo ASSETS_URL?>css/style.css" rel="stylesheet">
	<link href="<?php echo ASSETS_URL?>css/developer.css" rel="stylesheet">	
	
	<script>
		window.addEventListener('load', function() {
		  window.print();
		  window.onfocus=function(){ setTimeout(function () { window.close(); }, 500);}
		}, true);
	</script>
	<style>
		.table{border:1px solid #ccc}
		.ibox-content{border:none !important;}
	</style>
	<style type="text/css" media="print">
		@page 
		{
			size:  auto;   /* auto is the initial value */
			margin: 0mm;  /* this affects the margin in the printer settings */
		}

		html
		{
			background-color: #FFFFFF; 
			margin: 0px;  /* this affects the margin on the html before sending to printer */
		}

		body
		{
			//border: solid 1px blue ;
			//margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
		}
    </style>
</head>
<style>

</style>
<body>
    <div id="wrapper">        
		<div class="wrapper wrapper-content animated fadeInRight">	
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5><?php echo $pageTitle;?></h5>						
						</div>
						<div class="ibox-content">					
							<div class="table-responsive">
								<!-------------->
								
								<?php 
									if(isset($no_view_load) && $no_view_load === true){
										echo $content;
									} else {
										$this->load->view($content);
									}
								?>
														
								<!-------------->
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>						        
</body>
</html>

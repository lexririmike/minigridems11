<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title .'| EMS'; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php //echo $keywords?>" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url('asset/css/bootstrap.css');?>" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url('asset/css/style.css');?>" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

<!-- font CSS -->
<!-- font-awesome icons -->
<link href="<?php echo base_url('asset/css/font-awesome.css');?>" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="<?php echo base_url('asset/js/jquery-1.8.3.min.js');?>"></script>
<script src="<?php echo base_url('asset/js/modernizr.custom.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="<?php echo base_url('asset/css/animate.css');?>" rel="stylesheet" type="text/css" media="all">
<script src="<?php echo base_url('asset/js/wow.min.js');?>"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>


<!-- Metis Menu -->
<script src="<?php echo base_url('asset/js/metisMenu.min.js');?>"></script>
<script src="<?php echo base_url('asset/js/custom.js');?>"></script>
<link href="<?php echo base_url('asset/css/custom.css');?>" rel="stylesheet">
<!--//Metis Menu -->
<link href="<?php echo base_url('asset/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet">


<script src="<?php echo base_url('asset/js/canvasjs.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/js/moment.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/js/bootstrap-datetimepicker.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('asset/js//locales/bootstrap-datetimepicker.fr.js');?>" type="text/javascript"></script>




						<style>
      #map {
        width: 100%;
        height: 400px;
        background-color: grey;
      }
    </style>

</head> 
<body class="cbp-spmenu-push cbp-spmenu-push-toright">
	<div class="main-content">

	<?php	if($this->ion_auth->logged_in())
	{
     
            $this->load->view("default/_blocks/left_nav");
			$this->load->view("default/_blocks/sticky_header");
	}
 ?>
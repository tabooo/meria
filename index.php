<?php
include("config.php");
if (@$_SESSION['username']==""){
	refreshPage(0, "login");
	die();
}
//mysqlconnect();
@$cat=stripslashes($_GET['cat']);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>MERIA</title>
	<link href="favicon.ico" rel="shortcut icon" />
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<style type="text/css">
     

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      
      .navbar .nav li a {
        font-weight: bold;
        text-align: left;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }

    </style>
	 <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jasny-bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/jasny-bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-lightbox.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-tagsinput.css">
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.pt-BR.js"></script>
	<script type="text/javascript" src="js/bootstrap-lightbox.min.js"></script>
	
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-select.css">
	<script type="text/javascript" src="js/bootstrap-select.js"></script>
	<script type="text/javascript">
      window.onload=function(){
      $('.selectpicker').selectpicker();
      $('.rm-mustard').click(function() {
        $('.remove-example').find('[value=Mustard]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.rm-ketchup').click(function() {
        $('.remove-example').find('[value=Ketchup]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.rm-relish').click(function() {
        $('.remove-example').find('[value=Relish]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.ex-disable').click(function() {
          $('.disable-example').prop('disabled',true);
          $('.disable-example').selectpicker('refresh');
      });
      $('.ex-enable').click(function() {
          $('.disable-example').prop('disabled',false);
          $('.disable-example').selectpicker('refresh');
      });
      prettyPrint();
      };
    </script>   

  </head>
  <body width="">

<div class="container">

      <div class="masthead">
        <h3 class="muted">მერია</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
				<ul class="nav">
					<li <?php if($cat=="" || $cat=="index") echo 'class="active"';?>><a href="index"><i class="icon-home"></i> მთავარი</a></li>
					<!--<li <?php if($cat=="addcitizen") echo 'class="active"';?>><a href="index?cat=addcitizen"><i class="icon-plus-sign"></i> მოქალაქე</a></li>-->					
				
					<li <?php if($cat=="addnewdocument") echo 'class="active"';?>><a href="index?cat=addnewdocument"><i class="icon-plus-sign"></i> ახალი დოკუმენტი</a></li>
					<!--<li <?php if($cat=="addnewanswer") echo 'class="active"';?>><a href="index?cat=addnewanswer"><i class="icon-plus-sign"></i> ახალი პასუხი</a></li>-->
				</ul>
				<ul class="nav pull-right">
					<li></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i>  <?php echo @$_SESSION['username']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-user"></i> პროფილი</a></li>
							<li><a href="#"><i class="icon-wrench"></i> პარამეტრები</a></li>
							<li class="divider"></li>
							<li><a href="php?dos=logout"><i class="icon-off"></i> გასვლა</a></li>
						</ul>
					</li>
				</ul>
              
            </div>
          </div>
        </div><!-- /.navbar -->
		
      </div>
<div class="container-fluid">
<div class="row-fluid">
		<div class="span4">
          <div class="well sidebar-nav">
            <ul class="nav nav-pills nav-stacked">
              <li class="nav-header">ნავიგაცია</li>
              <li <?php if($cat=="documents") echo 'class="active"';?>><a href="?cat=documents"><i class="icon-file"></i> დოკუმენტები</a></li>
			  <li <?php if($cat=="rewrite") echo 'class="active"';?>><a href="?cat=rewrite"><i class="icon-file"></i> გადაწერა</a></li>
			  <li <?php if($cat=="answers") echo 'class="active"';?>><a href="?cat=answers"><i class="icon-file"></i> პასუხები</a></li>
              <li class="nav-header">სხვა</li>
              <li <?php if($cat=="addcitizen") echo 'class="active"';?>><a href="index?cat=addcitizen"><i class="icon-user"></i> მოქალაქის დამატება</a></li>
			  <li <?php if($cat=="citizens") echo 'class="active"';?>><a href="?cat=citizens"><i class="icon-user"></i> მოქალაქეები</a></li>
			  <li <?php if($cat=="addpost") echo 'class="active"';?>><a href="index?cat=addpost"><i class="icon-user"></i> თანამდებობის დამატება</a></li>
			  <li <?php if($cat=="addworker") echo 'class="active"';?>><a href="index?cat=addworker"><i class="icon-user"></i> თანამშრომლის დამატება</a></li>
			  <li <?php if($cat=="workers") echo 'class="active"';?>><a href="?cat=workers"><i class="icon-user"></i> თანამშრომლები</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
<?php 
			$catp="index";
			if($cat!="" && file_exists("module/".$cat.".php")) $catp=$cat;
			
			include("module/".$catp.".php");
?>
</div>
		<hr>
<div class="footer">
	<p>&copy; <a href="http://bms-page.com" target="_blank">B. M. S.</a> 2013</p>
</div>	  
</div>
</div>


  </body>
</html>

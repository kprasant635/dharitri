<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ILRMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <!-- Google Font: Source Sans Pro -->
<!--   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
</head>
<style>
.footer {
    background: #67696A;
	background: -webkit-linear-gradient(top, #67696A, #02040F);
	background: -moz-linear-gradient(top, #67696A, #02040F);
	background: linear-gradient(to bottom, #67696A, #02040F);
    color: #fff;
    font-size: 1em;
    color: #aaa;
	margin-top:10px;
	padding-top:10px;
	font-size:.8em;
	color:#fff;
	
}
style.css:28
.spacer {
    padding: 2em 0;
}
.ad_images {
    text-align: center;
    padding: 9px 12px 0;
}
.ad_img {
    padding: 10px;
    vertical-align: middle;
    border-right: 1px solid #28282a;
}
.navbar-light {
    border-bottom: solid 30px #2a75bb;
}
.wrapper body{
	min-height:0px !important;
}
</style>

<body class="">
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style='margin-left: -10px;'>
<div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-default navbar-fixed-top" role="navigation" id="top-nav">
          <div class="container logo-bg">
            <div class="navbar-header navbar-collapse   ">
              <!-- Logo Starts -->
              <a class="navbar-brand" href="#home"><img src="<?php echo base_url() ?>application/views/images/logo_1_2.png"  alt="logo"></a>
              <!-- #Logo Ends -->
              
            </div>
			<div class=''></div>
            <!-- Nav Starts -->
            
            <!-- #Nav Ends -->
          </div>
        </div>
      </div>
    </div>
</nav>
<div class="login-box " style='margin-left:500px'>
  <div class="login-logo">
    <a href="">ILRMS(Single Sign In)</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?php echo base_url()?>/index.php/Login/RedirectLogin" method="post">
        <div class="input-group mb-3">
          <input type="text" name='uname' class="form-control" placeholder="User Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password"  name='pwd'  class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-6 ">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="<?php echo base_url()?>index.php/login/forgotPassword">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="<?php echo base_url() ?>index.php/login/register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<div class="footer text-center spacer">
    <div class='container' >
		<div class='row'>
			<div class='col-lg-2'>
				<img class='pull-left' width=60 src="<?php echo base_url() ?>application/views/images/qrcode.svg" >
			</div>
			<div class='col-lg-7'>
				Contents provided and maintained by Revenue & Disaster Management Department, Govt. of Assam.<br>
Copyright © All Rights Reserved , Government of Assam. <br>
		Total Visitors :
		<iframe src="https://www.webfreecounter.com/hit.php?id=gvvfoafp&nd=8&style=13" height='30' width='160' style='border:none; margin-bottom:-15px;'></iframe>	
			</div>
			<div class='col-lg-3'>
			<img  src="<?php echo base_url() ?>application/views/images/niclogo.png" class='pull-right' >
		
			</div>
		</div>
        <div class="ad_images">
            <i class="ad_img1" href=""></i>
            <a class="ad_img" href="https://assam.mygov.in/" title="Government of Assam( External Site that opens in a new window)" target="_blank"><img src="<?php echo base_url(); ?>application/views/images/assam_govt_logo.PNG"></a>
            <a class="ad_img" href="https://data.gov.in/" title="Data Portal (External Site that opens in a new window)" target="_blank"><img src="<?php echo base_url(); ?>application/views/images/data-gov-logo.PNG"></a>
            <a class="ad_img" href="https://india.gov.in/" title="NPI (External Site that opens in a new window)" target="_blank"><img src="<?php echo base_url(); ?>application/views/images/india-gov-logo.PNG"></a>
            <a class="ad_img" href="https://www.mygov.in/" title="MyGov  (External Site that opens in a new window)" target="_blank"><img src="<?php echo base_url(); ?>application/views/images/logo.PNG" height="50"></a>
            <a class="ad_img" href="https://pmindia.gov.in/" title="PM INDIA (External Site that opens in a new window)" target="_blank"><img src="<?php echo base_url(); ?>application/views/images/pm-india-logo.PNG"></a>
			<a class="ad_img" href="https://digitalindia.gov.in/" title="DIGITAL INDIA (External Site that opens in a new window)" target="_blank"><img src="<?php echo base_url(); ?>application/views/images/digital-india-logo.png"></a>
        </div>
    </div>	
</div>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>

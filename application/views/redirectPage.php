<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ILRMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
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
<body style='margin-left: -250px !important; min-height:0px !important;'>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
<!-- Site wrapper -->
<style>
.hide {
	display:none;
}
</style>
<?php 
//var_dump($this->session->all_userdata());
if($this->session->userdata('dist_code')==null){
	redirect('/Login');
}
?>
<div class="wrapper" style='margin-top:10px;min-height:0px !important;'>
  <!-- Navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  REVENUE & DISASTER MANAGEMENT

                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>Dharitree</b></h2>
                      <p class="text-muted text-sm"><b>About: </b> Mutation / Partition/ Conversion etc </p>
                     
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?php echo base_url()?>homePage/img/Land-Mutation-Conversion-and-Partition_v2.jpg" alt="" class="img-responsive img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    
                    <a href="<?php echo base_url() ?>index.php/Home" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> Go To Dharitree Application
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  REVENUE & DISASTER MANAGEMENT
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>NOC for Transfer of Immovable Property</b></h2>
                      <p class="text-muted text-sm"><b>About: </b> Transfer of Immovable Property/  </p>
                      
                    </div>
                   <div class="col-5 text-center">
                      <img src="<?php echo base_url()?>homePage/img/Transfer-of-Immovable-Property_v2.jpg" alt="" class="img-responsive img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <?php 
					//var_dump($this->session->all_userdata());
					$dist_code = $this->session->userdata('dist_code');
					$subdiv_code = $this->session->userdata('subdiv_code');
					$cir_code = $this->session->userdata('cir_code');
					$user_code = $this->session->userdata('user_code');
					$mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
					$lot_no = $this->session->userdata('lot_no');
					$user_type=strtoupper(substr($this->session->userdata('user_code'),0,1));
					$class='';
					if($user_type=='M'){
						$lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
						$this->session->set_userdata('nocuser',$lm->lmuser);
						$nocUser=$lm->lmuser;
						if($nocUser==0){
							//$class='hide';
						}
					}else{
						$nocUser=$this->utilityclass->getNocPriv($this->session->userdata('user_code'),$this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'));
						if($nocUser==0){
							//$class='hide';
						}
					}
					?>
                    <a href="<?=NOC_LINK?>index.php/login/SingleSign/<?=$nocUser?>" class="btn btn-sm btn-primary <?=$class?>">
                      <i class="fas fa-user"></i> Go To NOC Application
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                  REVENUE & DISASTER MANAGEMENT
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>Bhunaksha</b></h2>
                      <p class="text-muted text-sm"><b>About: </b> Map  </p>
                      
                    </div>
                   <div class="col-5 text-center">
                      <img src="<?php echo base_url()?>homePage/img/Land-Mutation-Conversion-and-Partition_v3.jpg" alt="" class="img-responsive img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                   
                    <a href="#" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> Go To Bhunaksha Application
                    </a>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
        <!-- /.card-body -->
        
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<div class="footer text-center spacer">
    <div class='container' style='margin-left:350px'>
		<div class='row'>
			<div class='col-lg-2'>
				<img class='pull-left' width=60 src="<?php echo base_url() ?>application/views/images/qrcode.svg" >
			</div>
			<div class='col-lg-7'>
				Contents provided and maintained by Revenue & Disaster Management Department, Govt. of Assam.<br>
Copyright @ All Rights Reserved , Government of Assam. <br>
		Total Visitors :
		<iframe src="https://www.webfreecounter.com/hit.php?id=gvvfoafp&nd=7&style=13" height='30' width='150' style='border:none; margin-bottom:-15px;'></iframe>	
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
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>

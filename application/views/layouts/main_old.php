<?php date_default_timezone_set('Asia/Calcutta'); ?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>DHARITREE || Land Records Computerization Project</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <!-- JS file starts here-->
		<!-- Font Awesome Icons -->
		  <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/all.min.css">
		  <!-- Theme style -->
		  <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
		  <!-- Google Font: Source Sans Pro -->
<!-- 		  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
		  <!-- jQuery -->
			<script src="<?php echo base_url();?>homePage/js/jquery.min.js"></script>
			<!-- Bootstrap 4 -->
			<script src="<?php echo base_url();?>homePage/js/bootstrap.bundle.min.js"></script>
			<!-- AdminLTE App -->
			<script src="<?php echo base_url();?>homePage/js/adminlte.min.js"></script>
		<!------------------>
		<link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
        
        <script src="<?php echo base_url(); ?>application/views/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>application/views/js/bootstrap.min_1.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>application/views/js/plugins.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/jquery.tablesorter.min.js"></script>

        <script src="<?php echo base_url(); ?>application/views/js/dharitreecore.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/ajax.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/inputmask.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/jquery.inputmask.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/blowfish.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/jquery.dataTables.min.js"></script>

        <script src="<?php echo base_url(); ?>application/views/js/graph/jquery.jqplot.min.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/graph/jqplot.pieRenderer.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/graph/jqplot.enhancedLegendRenderer.min.js"></script>
        <script src="<?php echo base_url(); ?>application/views/js/verhoef.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/pramukhime.js"></script>
        <script type='text/javascript' src="<?php echo base_url(); ?>application/views/js/pramukhindic.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/pramukhime-common.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/convertchars.js"></script>

        <script>
            $(document).ready(function () {
                console.log("Ready");
                $('.page').dataTable();
                $('.pageshowpage').dataTable();
                function disableBack() {
                    window.history.forward()
                }
            });
        </script>
        <!-- JS file ends here-->
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.theme.fint.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.charts.js"></script>
        <!-- STyle sheet starts here-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/app.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/js/graph/jquery.jqplot.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/normalize.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/bootflat.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/font-awesome.min.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/dataTables.jqueryui.css">
        <!-- STyle sheet ends here-->
        <!--links are added for jquery calendar-->
        <link type="text/css" href="<?php echo base_url(); ?>application/views/css/flora.datepick.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery.datepick.js"></script>

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/jquery.growl.css"></style>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/jquery.growl.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/NotificationService.js"></script>

    <!--end calendar links-->
    <style>
        .not-active {
            pointer-events: none;
            cursor: default;
        }
        .test {
            width:200px;
            display:inline-block;
            overflow: auto;
            white-space: nowrap;
            margin:0px auto;
            border:1px red solid;
        }
        .blink_me {
            animation: blinker 3s linear infinite;
          }

          @keyframes blinker {
            50% {
              opacity: 0;
            }
          }
		  .navbar-default{
			  background:#fff !important;
		  }
    </style>
			<script>
            $(document).ready(function () {
                $.NotificationService.showTopNotification({
                    title: "Important Notice :",
                    message: "ILRMS will be down from 6 PM today (5/11/19) due to urgent maintenance work.PLEASE LOGOUT FROM DHARITREE, NOC , BHU-NAKSHA BEFORE THE TIME.It will be available tomorrow (6/11/19).We will inform the time.",
					type: "top",
                    id: "hide" // hide or show
                });
				
                $.NotificationService.showErrorNotification({
                    title: "Notice",
                    message: "1. Multiple Dag Mutation can be done! <br>2. In case of database error in order passing, logout and try again.",
                    id: "hide" // hide or show
                });

                $.NotificationService.showWarningNotification({
                    title: "Notice",
                    message: "Now DC/ADC can send back any reclassification Cases to Circle Officer.",
                    id: "hide" // hide or show
                });
                $.NotificationService.showInfoNotification({
                    title: "Notice",
                    message: "adsd",
                    id: "hide" // hide or show
                });

                var id = '#dialog';

                //Get the screen height and width
                var maskHeight = $(document).height();
                var maskWidth = $(window).width();

                //Set heigth and width to mask to fill up the whole screen
                $('#mask').css({'width': maskWidth, 'height': maskHeight});

                //transition effect
                $('#mask').fadeIn(500);
                $('#mask').fadeTo("slow", 0.9);

                //Get the window height and width
                var winH = $(window).height();
                var winW = $(window).width();

                //Set the popup window to center
                $(id).css('top', winH / 2 - $(id).height() / 2);
                $(id).css('left', winW / 2 - $(id).width() / 2);

                //transition effect
                $(id).fadeIn(2000);

                //if close button is clicked
                $('.window .close').click(function (e) {
                    //Cancel the link behavior
                    e.preventDefault();

                    $('#mask').hide();
                    $('.window').hide();
                });

                //if mask is clicked
                $('#mask').click(function () {
                    $(this).hide();
                    $('.window').hide();
                });
            });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#popupDatepicker').datepick({dateFormat: 'dd-mm-yyyy'});
        });
        $(function () {
            $('#popupDatepicker1').datepick({dateFormat: 'dd-mm-yyyy'});
        });
        $(function () {
            $('#ddmmyy').datepick({dateFormat: 'dd/mm/yyyy', minDate: 0, maxDate: 0});
        });
        $(function () {
            $('#enable_next_date').datepick({dateFormat: 'dd/mm/yyyy', minDate: 0});
        });
        $(function () {
            $('#ddmmyy1').datepick({dateFormat: 'dd/mm/yyyy'});
        });
        $(function () {
            $('#popup1Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
        });
        $(function () {
            $('#popup2Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
        });
        $(function () {
            $('#popup3Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
        });
        $(function () {
            $('#DatepickerCO').datepick({dateFormat: 'yyyy-mm-dd'});
        });
        $(function () {
            $('#popup5Datepicker').datepick({dateFormat: 'yyyy-mm-dd'});
        });

        $(function () {
            $('input[type="date"]').datepick({dateFormat: 'dd-mm-yyyy'});
        });

        $(function () {
            $('.dating').datepick({dateFormat: 'dd-mm-yyyy'});
        });
        //////////Range select/////////
        $(function () {
            $('.stdate').datepick({dateFormat: 'dd-mm-yyyy'});
        });
        $(function () {
            $('.endate').datepick({dateFormat: 'dd-mm-yyyy'});
        });
        
    </script>
</head>
<body>
  
        <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="ilrms_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <a><img src="<?php echo base_url() ?>application/views/css/images/flag.png" alt="Flag" style="color:#fff;margin-right: 5px;">GOVERNMENT OF ASSAM</a>
                    <a><img src="<?php echo base_url() ?>application/views/css/images/vertical-line.png" alt="Flag" style="color:#fff;margin-right: 5px;">Revenue &amp; Disaster Management </a>
                </div>
                <div>
                  <a></a>
                              </div>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid noprint">
	<div class="row" style='padding:10px'>
				
</div>
	</div>
	<div id="sticky-anchor"></div>
	<div class="row">
                <nav class="navbar menu" style='width:100%'>
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li class="uni_text"><a href="<?php echo base_url(); ?>index.php/home/"><i class='fa fa-home'></i> <?php echo "Home"; ?></a></li>
                        </ul>
						
						<ul class="nav navbar-nav navbar-right">
                            <li class='uni_text'>
                                <a>
                                    <?php
                                    $dist_code = $this->session->userdata('dist_code');
                                    $subdiv_code = $this->session->userdata('subdiv_code');
                                    $cir_code = $this->session->userdata('cir_code');
                                    $user_code = $this->session->userdata('user_code');
									$user_desig_code = $this->session->userdata('user_desig_code');
                                    if (($user_desig_code == 'CO')) { // Circle officer
                                        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'ASO')) { // Circle officer
                                        $co = $this->utilityclass->getSelectedASOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if ($this->session->userdata('user_desig_code') == 'AST') { // Assistant
                                        $asstt = $this->utilityclass->getSelectedAssttName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $asstt->username . "</span> ";
                                    }
                                    if ($user_desig_code == 'SK') { // Supervisor Kanango
                                        $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $sk->username . "</span> ";
                                    }
                                    if ($user_desig_code == 'SA') { // Senior Assistant
                                        $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $sk->username . "</span> ";
                                    }
                                    if ($user_desig_code == 'LM') { // Lot mondal
                                        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                                        $lot_no = $this->session->userdata('lot_no');
                                        $lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $lm->lm_name . "</span> "."( " .$user_desig_code .")";
                                    }
                                    if (($user_desig_code == 'DC') || ($user_desig_code == 'ADC') || ($user_desig_code == 'LAO')) { // DC, ADC and Land Authorization Officer
                                        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if ($user_desig_code == 'BO') { // Branch Officer
                                        $bo = $this->utilityclass->getDefinedBOName($dist_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $bo->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'ADM')) { // Nic Admin
                                        $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'RKG')) { // Registered Kanango
                                        $co = $this->utilityclass->getSelectedRkgName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'RS')) { // 
                                        $co = $this->utilityclass->getSelectedRSName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'SAD')) { // 
                                        $co = $this->utilityclass->getSelectedjadName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'JAD')) { // 
                                        $co = $this->utilityclass->getSelectedsadName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    if (($user_desig_code == 'SCN')) { // State Consultant Code
                                        $co = $this->utilityclass->getSelectedsadName($dist_code, $subdiv_code, $cir_code, $user_code);
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                    }
                                    ?>
                                </a>
                            </li>
                        </ul>
					</div>
				</nav>
	</div>
	<div class="home row" style='margin-top:-20px; padding-right:5px; min-height:510px'>
		<div class='col-lg-2'>
			<?php include('menu.php'); ?>
		</div>
		<div class='col-lg-10' style='margin-top:5px'>
		<?php                    
		if(isset($_view) && $_view)
			$this->load->view($_view);
		?> 
		</div>
	</div>
	<style>
	.footer {
		background: #67696A;
		background: -webkit-linear-gradient(top, #67696A, #02040F);
		background: -moz-linear-gradient(top, #67696A, #02040F);
		background: linear-gradient(to bottom, #67696A, #02040F);
		color: #fff;
		font-size: 1em;
		color: #aaa;
		padding-top:10px;
		font-size:.8em;
	}
	</style>
	<div class="footer dontshow text-center spacer" style='padding:10px'>
    <div class='container' >
		<div class='row'>
			<div class='col-lg-2'>
				<img class='pull-left' width=70 src="<?php echo base_url() ?>application/views/images/qrcode.svg" >
			</div>
			<div class='col-lg-7' style="color:#fff; font-size:.8em">
				Contents provided and maintained by Revenue & Disaster Management Department, Govt. of Assam.<br>
Copyright @ All Rights Reserved , Government of Assam. <br>
		Total Visitors :
		<iframe src="https://www.webfreecounter.com/hit.php?id=gvvfoafp&nd=7&style=13" height='30' width='150' style='border:none; margin-bottom:-15px'></iframe>	
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
</body>
</html>
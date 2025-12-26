<?php
date_default_timezone_set('Asia/Calcutta');
define('GLOBAL_CASE_SEARCH', '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <a href="'.base_url().'index.php/searching-data" target="_searching">
      <button class="btn btn-xs btn-danger pull-right"><i class="fa fa-search"></i> Search your cases here</button>
    </a>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div><hr>');

  header('Access-Control-Allow-Origin: *');

//   $csrf__enabled = config_item('csrf_protection') == TRUE ? 1 : 0;
?>

<!DOCTYPE html>
<html class="no-js">
<head>
    <script type="text/javascript">
        const baseUrl='<?=BASE_JS_LINK?>';
    </script>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <!-- <meta name="<?= $this->utilityclass->csrf__key() ?>" content="<?= $this->utilityclass->csrf__token() ?>" data-id="csrf-key" /> -->
    <title>DHARITREE || Land Records Computerization Project</title>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <!-- JS file starts here-->
    <!-- Font Awesome Icons -->

    <!-- Google Font: Source Sans Pro -->
    <!-- 		  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
    <!-- jQuery -->
    <script src="<?php echo base_url();?>homePage/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url();?>homePage/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>homePage/js/adminlte.min.js"></script>
     
    <!------------------>
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>homePage/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/views/css/reportstabs.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/views/css/reportstabstyles.css">
     <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
    <!-- Added by Abhijit - 2024-07-11 -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/views/css/jquery-ui.min.css">

    <script src="<?php echo base_url(); ?>application/views/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/views/js/bootstrap.min_1.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/views/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>application/views/js/jquery.tablesorter.min.js"></script>

    <!-- Added by Abhijit - 2024-07-11 -->
    <script src="<?php echo base_url(); ?>application/views/js/jquery-ui.min.js"></script>

    <!-------------->
    <script src="<?php echo base_url();?>application/views/css/jquery-confirm.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url();?>application/views/css/jquery-confirm.min.css">

    <!-- Added BY Prasant JS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/views/css/fontawesome/css/all.min.css">

    
    
    
    <?php
    // $bhulink=BHUNAKSHA_LINK;
    // if($_SESSION['credentials']['noc']){
    //     $noc_link=NOC_LINK;
    // }
    // else{
    //     $noc_link='hide';
    // }
    ?>
    <!-- <script>
        $(document).ready(function () {
            console.log("Ready");
            $('.example2').on('click', function(e){
                e.preventDefault();
                $.confirm({
                    title: '',
                    content: 'You are going to redirect to NOC Application! Do you want to proceed ? ',
                    buttons: {
                        confirm: function(){
                            $.alert('Confirmed!');
                            window.location = "<?=$noc_link;?>index.php/login/SingleSign/<?=$_SESSION['credentials']['noc']?>";
                        },
                        cancel: function(){
                            $.alert('Canceled!');
                        },
                    }
                });
            });
            $('.example3').on('click', function(e){
                e.preventDefault();
                $.confirm({
                    title: '',
                    content: 'You are going to redirect to Bhunaksha Application! Do you want to proceed ? ',
                    buttons: {
                        confirm: function(){
                            $.alert('Confirmed!');
                            //window.location = "<?=$bhulink?>";
                            window.open("<?=$bhulink?>", 'bhunaksha');
                        },
                        cancel: function(){
                            $.alert('Canceled!');
                        },
                    }
                });
            });

        });
    </script> -->

    <?php
    $bhulink=BHUNAKSHA_LINK;
    // var_dump($_SESSION['credentials']);
    if($_SESSION['credentials']['noc'] || $this->session->userdata('nocuser')){
        $noc_link=NOC_LINK;
    }
    else{
        $noc_link='hide';
    }
    ?>
    <form action ="https://<?=NOC_SERVER_IP?>/nocforimpssign/index.php/Login/SingleSign" method="POST" id='REDIRECT_TO_NOC'>
       <input type="hidden"  name="token" value="">
    </form>
    <script>
        $(document).ready(function () {
            console.log("Ready");
            $('.example2').on('click', function(e){
                e.preventDefault();
                $.confirm({
                    title: '',
                    content: 'You are going to redirect to NOC Application! Do you want to proceed ? ',
                    buttons: {
                        confirm: function(){
                            $.alert('Confirmed!');
                            $('#REDIRECT_TO_NOC').submit();
                            // window.location = "<?=$noc_link;?>index.php/login/SingleSign/<?=$_SESSION['credentials']['noc']?>";
                        },
                        cancel: function(){
                            $.alert('Canceled!');
                        },
                    }
                });
            });
            $('.example3').on('click', function(e){
                e.preventDefault();
                $.confirm({
                    title: '',
                    content: 'You are going to redirect to Bhunaksha Application! Do you want to proceed ? ',
                    buttons: {
                        confirm: function(){
                            $.alert('Confirmed!');
                            //window.location = "<?=$bhulink?>";
                            // window.open("<?=$bhulink?>", 'bhunaksha');
                        },
                        cancel: function(){
                            $.alert('Canceled!');
                        },
                    }
                });
            });

        });
    </script>


    <!--------------->
    <script src="<?php echo base_url(); ?>application/views/js/dharitreecore.js?v=1.1"></script>
    <script src="<?php echo base_url(); ?>application/views/js/ajax.js?v=1.1"></script>
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
    <!-- JS file ends here-->
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.theme.fint.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/fusioncharts.charts.js"></script>
    <!-- sweet alert -->

    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/sweetalert2.min.css">
    <!-- STyle sheet starts here-->
    <!-- STyle sheet starts here-->

    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/js/graph/jquery.jqplot.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/bootflat.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/dataTables.jqueryui.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/app.css">
    <!-- STyle sheet ends here-->
    <!--links are added for jquery calendar-->
    <link type="text/css" href="<?php echo base_url(); ?>application/views/css/flora.datepick.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/js/jquery.datepick.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/css/jquery.growl.css">


    <link href="<?php echo base_url('css/styles.css');?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('fonts/css/font-awesome.css');?>">


    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/jquery.growl.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/views/jsnew/NotificationService.js"></script>

    <!--end calendar links-->

    <!-- Newly Added for Basundhara MB2 BY KINGS -->
    <script src="<?php echo base_url(); ?>application/views/js/reject_mb2.js?v=1.4"></script>
    <script src="<?php echo base_url(); ?>application/views/js/reject_mb3.js?v=1.1"></script>

   
    <!-- Newly Added for Basundhara MB2 BY KINGS -->


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

    <?php
    include(APPPATH . 'views/layouts/ajax-setup.php');
    ?>

<style>
        .loader-wrap {
            position: fixed;
            z-index: 9999;
            height: 100%;
            width: 100%;
            overflow: show;
            margin: auto;
            background-color: #00193361;
            top: 0;
            left: 5;
            bottom: 0;
            right: 0;
        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            /* border-top: 3px solid #007bff; */
            border-top: 3px solid #7b01ff;
            border-right: 3px solid transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;

            position: fixed;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>
<body>

<style type="text/css">

    .navbar {
        position: relative;
        min-height: 20px;
        margin-bottom: 0px !important;
        border: 1px solid transparent;
        border-radius: 0px !important;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        font-size: 1.2em !important
    }
    .timeline>div {
        margin-right: 0px !important;
    }
    .timeline::before {
        width: 0px !important;
    }
    .timeline__content:nth-child(odd)::before {
        top: 50%;
        left: -39px;
    }
    .timeline>div::after, .timeline>div::before {
        content: "";
        display: table;
    }
    .timeline__content::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #848892;
        border-radius: 50%;
        transform: translateY(-50%);
    }
    .tab-content {
        padding: 0px!important;
    }

    .list-inline{
        padding-right: 0px!important;
    }

    .card:active {
        top: 0px;
        left: 0px;
        box-shadow: none;
    }
    .card:hover {
        top: 0px;
        left: 0px;
        box-shadow: none;
    }


</style>

<div class="loader-wrap" style="display:none;">
    <span class="loader"></span>
</div>


<nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="ilrms_nav_top">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div>
                <a><img src="<?php echo base_url(); ?>assets/flag.png" alt="Flag" style="color:#fff;margin-right: 5px;">GOVERNMENT OF ASSAM</a>
                <a><img src="<?php echo base_url(); ?>assets/vertical-line.png" alt="verticalline" style="color:#fff;margin-right: 5px;">Revenue &amp; Disaster Management </a>
            </div>
            <div>
                <a href="govindex.html" target="_blank" class="gov_login_switch" style="text-decoration: none;"></a>
                <b class="btn btn-warning">S1</b>
            </div>
        </div>
    </div>
</nav>



<nav class="navbar navbar-expand-lg dontshow navbar-light" id="logo_nav_bar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="col-md-6 ilrms-logo" style="padding-left: 70px">
            <p style="font-weight: bold;"><a class="tophead" title="Government of Assam">ILRMS</a></p>
            <p title="" class="mainhead">Integrated Land Records Management System</p>
        </div>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#ilrms_main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="ilrms_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item" style="margin-left: 10px !important">
                        <a class="nav-link" href="https://revenueassam.nic.in/ILRMS/"> Home</a>
                    </li>
                    <li class="nav-item" style="margin-left: 30px !important">
                        <a class="nav-link" href="https://revenueassam.nic.in/ILRMS/index.php/welcome/about"> About</a>
                    </li>
                    <li class="nav-item" style="margin-left: 30px !important">
                        <a class="nav-link" href="https://revenueassam.nic.in/ILRMS/index.php/welcome/document"> Documents</a>
                    </li>
                    <li class="nav-item" style="margin-left: 30px !important">
                        <a class="nav-link" href="https://revenueassam.nic.in/ILRMS/index.php/welcome/contact"> Contact</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</nav>



<?php
    //************************************************/
    if(CIRCLE_WISE_LAND_CLASS_AND_RATE_CHECK == '1' && $this->session->userdata('user_desig_code') == 'CO'){
        $co_block_flag = $this->utilityclass->getCoBlockFlagForLandClassAndRateUpdate($this->session->userdata('dist_code'),
            $this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'));
        // echo "<pre>";
        // var_dump($co_block_flag);
        // exit;
    }
    //************************************************/
    if (EKHAJANA_CO_PENDING_CONTROL == '1' && $this->session->userdata('user_desig_code') == 'CO'){
        $ekhajana_pending_co_cases = $this->utilityclass->getEkhajanaCoPendingCases($this->session->userdata('dist_code'),
            $this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'));
    }else{
        $ekhajana_pending_co_cases = 0;
    }
    //************************************************/
    if (EKHAJANA_LM_PENDING_CONTROL == '1' && $this->session->userdata('user_desig_code') == 'LM'){

        $ekhajana_pending_lm_cases = $this->utilityclass->getEkhajanaLmPendingCases($this->session->userdata('dist_code'),
            $this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),
            $this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'));
        //echo "lm pending cases ". $ekhajana_pending_lm_cases;
    }else{
        $ekhajana_pending_lm_cases = 0;
    }
    //************************************************/
    //testing
    // echo "<pre>";
    // var_dump($ekhajana_pending_co_cases);
    //************************************************/
?>
<?php include('menu_co.php');?>



<div id="page-content-wrapper">
    <nav class="navbar dontshow navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <button onclick="myFunction(this)" class="btn ban_button" id="sidebarToggle">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item ban-active add-mar-right"><a class="nav-link" href="<?php echo base_url(); ?>index.php/Home/index"> Dharitree</a> </li>
                    <?php if (in_array($this->session->userdata('user_desig_code'), ['DC','ADC','CO','AST','DDA','ADA','CDA'])) : ?>
                    <li class="nav-item add-mar-right"><a class="nav-link" href="#" id="rccms"> RCCMS </a> </li>
                    <form action ="<?php echo base_url(); ?>index.php/RccmsUser/validateUser" method="POST" id='rccmsFormPost'>
                       <input type="hidden"  name="jwt" id='rccms-token' value="">
                    </form>
                    <?php endif; ?>

                    <li class="nav-item add-mar-right"><a class="nav-link example2  <?=$noc_link?>" href="<?=$noc_link?>index.php/login/SingleSign/<?=$_SESSION['credentials']['noc']?>"> NOC</a></li>

                    <?php $bhulink=BHUNAKSHA_LINK;
                    $user_desig_code=$this->session->userdata('user_desig_code');
                    if($user_desig_code=='LM' or $user_desig_code=='SK' or $user_desig_code=='CO'){
                        ?>
                        <li class="nav-item add-mar-right">
                            <a class="nav-link example3" target="bhunaksha" href='#' >Bhunaksha</a>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('user_desig_code') == 'CO'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DOWNLOAD <span class="badge badge-danger">New</span></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" target="_blank" href="<?php echo base_url(); ?>download_notification.zip" download="download_notification.zip">Download all Notification regarding Juridical Entities</a>
                        </div>
                    </li>
                    <?php endif;?>
                    <li class="nav-item active"><a class="nav-link text-white" href="#!">

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

                            if (($user_desig_code == 'DEO')) {
                                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                //var_dump($co);
                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                            }
                            if (($user_desig_code == 'DIO')) {
                                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                //var_dump($co);
                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                            }
                            ?>
                        </a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">মোৰ প্ৰফাইল</a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#!">Notifications</a>
                            <a class="dropdown-item" href="#!">Account Settings</a>
                            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/CaseSearch/loginHistory"><sup class="red">New</sup> Login History</a>
                            <a class="dropdown-item" download href="<?php echo base_url(); ?>application/views/img/process_flow.pdf"><sup class="red">New</sup> Download Dharitree Processflow</a>
                            <a class="dropdown-item" download href="<?php echo base_url(); ?>application/views/img/lac.docx"><sup class="red">New</sup> Download LAC Processflow</a>
                            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/login/remapped">Un-Map User Setting</a>
                            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/Dsc/dSignDetails">NICDsign Config details</a>
                            <?php
                            if(CO_SIGN_UPLOAD == OPEN){
                                if($this->session->userdata('user_desig_code') == 'CO'){
                                ?>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/UploadSignatureController/index">Upload signature</a>
                                <?php  
                            }

                            }?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/login/logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class='col-lg-12' style='margin-top:5px'>
        <?php
        // if (($user_desig_code == 'DC' || $user_desig_code == 'ADC')) { 
        //     echo "<div class='alert alert-danger'> Last date for sending MISSION BASUNDHARA 2.0 cases to the Department is till midnight i.e 11:59 pm of 26th November’ 2023 </div>";
        // }
        if(ESCALATION_ENABLE == 1 && TO_BE_AUTO_ESCALATE_POPUP == 1) 
        { 
            $popUpOfToBeEscalatedList = $this->ToBeAutoEscModel->popUpOfToBeEscalatedList(); 
            if(!empty($popUpOfToBeEscalatedList) && isset($popUpOfToBeEscalatedList)) {
                include(APPPATH."views/auto_populate_to_be_escalate_case.php");
            }

        }
        if(isset($show_nav) && isset($show_nav['allow']) && $show_nav['allow']) {
            include('common_view.php');
        }
        else{
            if(isset($_view) && $_view)
                $this->load->view($_view);
        }
        // if(isset($_view) && $_view)
        //     $this->load->view($_view);
        ?>
    </div>

</div>

</div>

<footer class="footer-section spad dontshow">
    <!-- Theme style -->

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2 class="fw-title">ILRMS</h2>
                    <a href="">About ILRMS</a>
                    <a href="">FAQs</a>
                    <a href="">Contact Us</a>                   </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-widget">
                    <h2 class="fw-title">Website Links</h2>
                    <a href="https://landrevenue.assam.gov.in/" target="_blank">Revenue &amp; Disaster Management</a>
                    <a href="https://dlrs.assam.gov.in/" target="_blank">Directorate of Land Records</a>
                    <a href="https://igr.assam.gov.in/" target="_blank">Inspector General of Registration</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-widget">
                    <h2 class="fw-title">Important Links</h2>
                    <a href="https://cm.assam.gov.in/" target="_blank">Assam CM Portal</a>
                    <a href="https://assam.gov.in/" target="_blank">Assam State Portal</a>
                    <a href="https://covid19.assam.gov.in/" target="_blank">Assam Covid-19 Portal</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-7">
                <div class="footer-widget">

                    <a class="fw-title"><img src="<?php echo base_url('assets/nic_newlogo.png');?>" alt="NIC Logo"> </a>
                    <p class="text-light">
                        Designed,  Developed  &amp; Hosted by <a style="text-decoration: none;color:#4bcfec" rel="sponsored" href="https://assam.nic.in/" target="_blank"> National Informatics Centre, Assam</a>
                    </p>
                    <p class="text-light" style="font-size: 14px;">
                        Copyright &copy; 2021 Government of Assam
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-black">
        <div class="container">
            <div class="col-12">
                <div class="row addpad">


                    <p class="text-light" style="text-align: center;">
                        Content Maintained &amp; Managed by: <a style="text-decoration: none; text-align: center;" rel="sponsored" href="https://landrevenue.assam.gov.in/" target="_blank"> &nbsp;Revenue &amp; Disaster Management Department</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

</footer>


<!---Property blockchain-->
<!-- dsc sign modal -->
<div id="dsc_sign_modal" class="modal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>Digital Certificate Signature </b>
                    <span class="red" id='caseNoHtml'></span>
                </h3>
            </div>
            <div class="modal-body" id="dsc_sign_modal_body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- 30-05-2022 -->
<div id="displayBox" style="display: none;">
    <img src="<?= base_url(); ?>/assets/rejLoader.gif">
    <div id="progress" style='display: none;'></div>
    <div id="message" style="font-weight: bold;color: cyan;"></div>
</div>
<div id="rejectModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>গোচৰ নং: </b>
                    <span class="red" id='caseNoHtmls'></span></h5>
            </div>
            <form id="rejectform" method="post">
                <div class="modal-body" id="rejectmodalbody">
                    <div class="form-group">
                        <label class="required">Reject Reason</label>
                        <div style="max-height: 200px; overflow-y: scroll;">
                            <table class="table table-striped table-bordered">
                                <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th width="10%" style="text-align: center">Check All&nbsp;
                                        <input type="checkbox" id="checkedAll" value="1">
                                    </th>
                                    <th width="90%">Reject Reason</th>
                                </tr>
                                </thead>
                                <tbody id="reject_option"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Enter Reason (if any other)</label>
                        <textarea class="form-control" id="reject_remark" name="remark" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <span class="errorMsg text-bold text-red"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="service_code" value="">
                    <input type="hidden" id="dharitreeCaseNo" value="">
                    <input type="hidden" id="nocase" value="">
                    <button type="submit" id="submit_reject_modal" class="btn btn-primary" data-dismiss="modal">Submit Rejection</button>
                    <button type="button" id="close_reject_modal" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="ref_no" name="ref_no"/>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Recommend/Not Recommend by SDO/ADC-->
<div id="displayBoxNew" style="display: none;"><img src="<?= base_url(); ?>/assets/rejLoader.gif"></div>
<div id="rejectNewModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>গোচৰ নং: </b>
                    <span class="red" id='caseNoHtml'></span>
                </h5>
            </div>
            <form id="rejectformNew" method="post">
                <div class="modal-body" id="rejectmodalbodyNew">
                    <div class="form-group">
                        <label class="required">Reject Reason </label>
                        <div style="overflow-y: scroll;">
                            <table class="table table-striped table-bordered">
                                <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th width="10%" style="text-align: center">Select &nbsp;
                                    </th>
                                    <th width="60%">Reject Reason</th>
                                    <th width="30%">Additional Note</th>
                                </tr>
                                </thead>
                                <tbody id="reject_option_new"></tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="form-group">-->
                    <!--     <label for="exampleFormControlTextarea1">Enter Reason (if any other)</label>-->
                    <!--     <textarea class="form-control" id="reject_remark" rows="3"></textarea>-->
                    <!-- </div>-->
                    <div class="form-group">
                        <span class="errorMsg text-bold text-red"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="service_code" value="">
                    <input type="hidden" id="dharitreeCaseNo" value="">
                    <input type="hidden" id="nocase" value="">
                    <button type="submit" id="submit_reject_modal_new" class="btn btn-primary" data-dismiss="modal">Submit Rejection</button>
                    <button type="button" id="close_reject_modal_new" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="ref_no" name="ref_no"/>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- direct reject by DC/ADC/SDO/CO-->
<div id="displayBoxNewDirect" style="display: none;"><img src="<?= base_url(); ?>/assets/rejLoader.gif"></div>
<div id="rejectDirectedModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>গোচৰ নং :  </b>
                    <span class="red" id='caseNoHtmlMR'></span>
                </h5>
            </div>
            <form id="rejectDirectFormNew" method="post">
                <div class="modal-body" id="rejectDirectmodalbodyNew">
                    <div class="form-group">
                        <label class="required">Reject Reason Direct </label>
                        <div style="overflow-y: scroll;">
                            <table class="table table-striped table-bordered">
                                <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th width="10%" style="text-align: center">Select &nbsp;
                                    </th>
                                    <th width="60%">Reject Reason</th>
                                    <th width="30%">Additional Note</th>
                                </tr>
                                </thead>
                                <tbody id="reject_direct_option_new"></tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlTextarea1">Enter Reason (if any other)</label> -->
                    <!-- <textarea class="form-control hide" id="reject_direct_remark" rows="3"></textarea>-->
                    <!-- </div> -->
                    <div class="form-group">
                        <span class="errorMsg text-bold text-red"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="service_code" value="">
                    <input type="hidden" id="dharitreeCaseNo" value="">
                    <input type="hidden" id="nocase" value="">
                    <button type="submit" id="submit_reject_direct_modal_new" class="btn btn-primary" data-dismiss="modal">Submit Rejection</button>
                    <button type="button" id="close_reject_direct_modal_new" class="btn btn-default">Close Button</button>
                    <input type="hidden" id="ref_no" name="ref_no"/>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="rejectDirectedModalMb3" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>গোচৰ নং :  </b>
                    <span class="red" id='caseNoHtmlMR'></span>
                </h5>
            </div>
            <form id="rejectDirectFormNewMb3" method="post">
                <div class="modal-body" id="rejectDirectmodalbodyNew">
                    <div class="form-group">
                        <label class="required">Reject Reason Direct </label>
                        <div style="overflow-y: scroll;">
                            <table class="table table-striped table-bordered">
                                <thead style="white-space:nowrap; width:100%">
                                <tr class="text-bold table-success">
                                    <th width="10%" style="text-align: center">Select &nbsp;
                                    </th>
                                    <th width="60%">Reject Reason</th>
                                    <th width="30%">Additional Note</th>
                                </tr>
                                </thead>
                                <tbody id="reject_direct_option_new_mb3"></tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlTextarea1">Enter Reason (if any other)</label> -->
                    <!-- <textarea class="form-control hide" id="reject_direct_remark" rows="3"></textarea>-->
                    <!-- </div> -->
                    <div class="form-group">
                        <span class="errorMsg text-bold text-red"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="service_code" value="">
                    <input type="hidden" id="dharitreeCaseNo" value="">
                    <input type="hidden" id="nocase" value="">
                    <button type="submit" id="submit_reject_direct_modal_new_mb3" class="btn btn-primary" data-dismiss="modal">Submit Rejection</button>
                    <button type="button" id="close_reject_direct_modal_new_mb3" class="btn btn-default">Close Button</button>
                    <input type="hidden" id="ref_no" name="ref_no"/>
                </div>
            </form>
        </div>
    </div>
</div>





<style type="text/css">.blockUI { z-index: 1200 !important;}</style>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<script src="<?php echo base_url('js/bootstrap.bundle.min.js');?>"></script>
<!-- Core JS-->
<script src="<?php echo base_url('js/scripts.js');?>"></script>
<!-- Additional JS-->
<script src="<?php echo base_url('js/ban.js');?>"></script>


<script type="text/javascript">
    
// Set the date we're counting down toif
var countDownDate = new Date("Dec 31, 2023 23:59:00").getTime();

// Update the count down every 1 second
// var x = setInterval(function() {

//   // Get today's date and time
//   var now = new Date().getTime();

//   // Find the distance between now and the count down date
//   var distance = countDownDate - now;

//   // Time calculations for days, hours, minutes and seconds
//   var days = Math.floor(distance / (1000 * 60 * 60 * 24));
//   var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//   var seconds = Math.floor((distance % (1000 * 60)) / 1000);

//   // Display the result in the element with id="demo"
//   document.getElementById("demo").innerHTML = days + " Days " + hours + "Hours "
//   + minutes + "Minutes " + seconds + "Seconds ";
//   if($("#time_left").length!=0){
//   document.getElementById("time_left").innerHTML = "<kbd>"+ days + "</kbd> Days <kbd>" + hours + "</kbd> Hours <kbd>"
//   + minutes + "</kbd> Minutes <kbd> " + seconds + "</kbd> Seconds ";
//     }
//   // If the count down is finished, write some text
//   if (distance < 0) {
//     clearInterval(x);
//     document.getElementById("demo").innerHTML = "EXPIRED";
//   }
// }, 100);

    $(document).ready(function(){
        $('.modal').on('shown.bs.modal', function () {
            // to remove extra padding on the right side of the page on modal open
            $('body').css('padding-right', '0px');
        });
        $('.modal').on('hidden.bs.modal', function () {
            // to remove extra padding on the right side of the page on modal close
            $('body').css('padding-right', '0px');
        });
    });


</script>

<!-- //newly added for dsc enrollment by Mriganka ---------:::11052023 -->
<script src="<?php echo base_url(); ?>application/views/js/dsc.js?v=1.1"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dsc-signer.js?v=1.1"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dscapi-conf.js?v=1.1"></script>

<!-- //added for blockchain -------------------MRIGANKA---:::18122023 -->
<script src="<?php echo base_url(); ?>application/views/js/chain_report.js?v=1.1"></script>
<script>
    $('#rccms').click(function(e) {  
    e.preventDefault();
    $('#btnImageloading').html('Wait ....!!!'); 
    var apiUrl = baseurl + "RccmsUser/";
    $.ajax({
        url: apiUrl,
        method: "POST",
        async: true,
        dataType: 'json',
        success: function(data) {
            if (data.status === 'y') {
                $('#rccms-token').val(data.token); 
                // Submit form after getting token
                $('#rccmsFormPost').submit();
            } else {
                $('#perm_status').val('');
                $('#jtoken').val('');
                $("#rccms").hide();
            }
        },
        error: function(xhr, status, error) {
            console.error("Authentication failed: " + error);
        }
    });
});
</script>
 <link rel="stylesheet" href="<?php echo base_url();?>application/views/js/select2.min.css">
<script src="<?php echo base_url();?>application/views/js/select2.min.js"></script>





</body>

</html>

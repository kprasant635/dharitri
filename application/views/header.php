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
</head>
<body>
    <div class="row dg-assam noprint hide" >
        <div class="col-lg-12" id="actions" style="z-index:999;" >
            <div class="row">
                <div class='col-lg-9'>
                    <img src="<?php echo base_url(); ?>application/views/images/indiaflag.gif" width='50' style='float:left; margin-left:30px;padding: 0 8px;line-height: 30px; margin-top:1px'>
                    <span class='dg-text-assam'>GOVERNMENT OF ASSAM</span>
                </div>
                
                <div class="col-lg-3 magnifier" >
                    <label id="plus"><sup>+</sup>A</label>
                    <label id="minus"><sup>-</sup>A</label>
                    <label class='dolr_text' >DoLR, Govt. Of India</label>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid noprint">
        <div class='row headerwrap hide'>
            <div class='top-separator'></div>

            <div class='header'>
                <div class='row'  >
                    <div class='col-lg-8 left emblem'>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <h1 class="title">Dharitree</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12" style='margin-top:-7px'>
                                <span class="tag1" style='margin-top:-10px;'>Land Records Computerization System </span>
                                <span class="tag1" style='margin-top:-10px;'>Revenue & Disaster Management Department.</span>
                            </div>
                        </div>
                    </div> 
                    <div class='col-lg-3 emblem1 hide' >
                        <span class='dolr_text' >DoLR, Govt. Of India</span>
                        <img style="margin-top:0px; align:center;" src='<?php echo base_url() ?>application/views/images/digital-india-logo.PNG' width='130px;'>
                    </div>
                </div>
            </div>
            <div class='indian_flag'>
                <div class="row">
                    <div class="col-lg-4 emblem1" align="" style='float:right; margin-top:30px'>
                        <img style="margin-top:-10px; align:center;" src='<?php echo base_url() ?>application/views/images/logo1.png'>
                    </div>
                </div>
            </div>
        </div>
		<div class="contanier">
       <!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light" style='min-height:90px' > -->		
		<div class="row" style='padding:10px'>
					<div class="col-lg-9">
					  <!-- Logo Starts -->
					  <a class="pull-left" style='margin-left:0px;' href="#home"><img src="<?php echo base_url() ?>application/views/images/logo_1_2.png"  alt="logo"></a>
					  <!-- #Logo Ends -->  
					</div>					
		           <div class='col-lg-3' style='font-size:1.8em; font-family:Serif; margin-top:20px'>
						<span style='font-weight:bold;'><span style='color:#FF0505;'>D</span><span style='color:#F10A13;'>h</span><span style='color:#E31022;'>a</span><span style='color:#D61531;'>r</span><span style='color:#C81B3F;'>i</span><span style='color:#BA204E;'>t</span><span style='color:#AD265D;'>r</span><span style='color:#9F2C6B;'>e</span><span style='color:#91317A;'>e</span> <span style='color:#763C98;'>(</span><span style='color:#6842A6;'>I</span><span style='color:#5B48B5;'>L</span><span style='color:#4D4DC4;'>R</span><span style='color:#3F53D2;'>M</span><span style='color:#3258E1;'>S</span><span style='color:#245EF0;'>)</span></span>
					</div>					
	<!--</nav>-->
		</div>
		<div id="sticky-anchor"></div>
        <?php
		//var_dump($this->session->all_userdata());
        $user_desig_code = $this->session->userdata('user_desig_code');
        if (($user_desig_code != '') || ($user_desig_code != null)) {
            ?>
            <div class="row">
                <nav class="navbar menu" style='width:100%'>
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li class="uni_text"><a href="<?php echo base_url(); ?>index.php/home/"><i class='fa fa-home'></i> <?php echo "Home"; ?></a></li>
                        </ul>
						

                        <ul class="nav hide navbar-nav">
                            <li class="dropdown uni_text">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
									$db=  $this->session->userdata('db');
                                    $ChithaReportMasterPermission = $this->utilityclass->getMenuPermission('ChithaReportMaster');
									//var_dump($ChithaReportMasterPermission);
                                    if (strpos($ChithaReportMasterPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/chithareport/districtDetails_dc_lao">Chitha Report</a></li>';
                                    } else {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/chithareport/districtDetails">Chitha Report</a></li>';
                                    }
                                    ?>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                    <?php
                                    $CentralDiaryPermission = $this->utilityclass->getMenuPermission('CentralDiary');
                                    if (strpos($CentralDiaryPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/CentralDiary">Central Diary</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $GenerateDoulPermission = $this->utilityclass->getMenuPermission('GenerateDoul');
                                    if (strpos($GenerateDoulPermission, $user_desig_code) !== false) {
                                        if($user_desig_code == 'CO'){
                                            echo '<li class="uni_text"><a href="' . base_url() . 'index.php/GenerateDoul/CircleWiseDoulGenerate">Generate Doul <sup><span class="badge badge-danger blink_me">New</span></sup></a></li>';
                                        }
                                    }
                                    ?>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList">All Deed View List </a></li>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport">Generate Proceeding Report </a></li>
                                </ul>
                            </li>
                            <li class="dropdown uni_text">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance'); ?> <sup><span class="badge badge-danger blink_me">New</span></sup><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                    $JamabandiAutoUpdateMasterPermission = $this->utilityclass->getMenuPermission('JamabandiAutoUpdateMaster');
                                    if (strpos($JamabandiAutoUpdateMasterPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/chithareport/jamadistrictDetails_dc_lao">' . $this->lang->line("jamabandi_auto_update") . '</a></li>';
                                    } else {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/Jamabandi">' . $this->lang->line("jamabandi_auto_update") . '</a></li>';
                                    }
                                    ?>
                                    <li class="uni_text"><a href="<?php echo base_url(); ?>index.php/Maintenance/JamabandiStatus">Change Jamabandi Status For Re Updation <sup><span class="badge badge-danger blink_me">New</span></sup></a></li>
                                </ul>
                            </li>
                            <li class="dropdown uni_text">
                                <a href="#" class="dropdown-toggle uni_text " data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('utility'); ?> <sup><span class="badge badge-danger blink_me">New</span></sup><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                    $MiscUtilitiesPermission = $this->utilityclass->getMenuPermission('MiscUtilities');
                                    if (strpos($MiscUtilitiesPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/utility/misc_utilities">Misc utilities</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $BacklogPermission = $this->utilityclass->getMenuPermission('BackLogEntry');
                                    if (strpos($BacklogPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/utility/backentry_utilities">Back Log Entry <sup><span class="badge badge-danger blink_me">New</span></sup></a></li>';
                                    }
                                    ?>
                                    <?php
                                    $ChithaEditEntryPermission = $this->utilityclass->getMenuPermission('ChithaEditEntry');
                                    if (strpos($ChithaEditEntryPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/chithaeditentry">Chitha Edit/Entry</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $JamabandiEditEntryPermission = $this->utilityclass->getMenuPermission('JamabandiEditEntry');
                                    if (strpos($JamabandiEditEntryPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/jamaeditentry">Jamabandi Edit/Entry</a></li>';
                                        echo '<li class="divider"></li>';
                                    }
                                    ?>
                                    <?php
                                    $PattaUpdationPermission = $this->utilityclass->getMenuPermission('PattaUpdation');
                                    if (strpos($PattaUpdationPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/deletefromchitha/update_patta">Patta Updation<small>(Goalpara Only)</small></a></li>';
                                        echo '<li class="divider"></li>';
                                    }
                                    ?>
                                    <?php
                                    $DeleteDagInfoPermission = $this->utilityclass->getMenuPermission('DeleteDagInfo');
                                    if (strpos($DeleteDagInfoPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/utility/districtselect">' . $this->lang->line("delete_dag_info") . '</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $DeletePattaInfoPermission = $this->utilityclass->getMenuPermission('DeletePattaInfo');
                                    if (strpos($DeletePattaInfoPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/utility/districtDetails_junk">Delete Patta Information</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $DeleteOfficeHalfDoneCasePermission = $this->utilityclass->getMenuPermission('DeleteOfficeHalfDoneCase');
                                    if (strpos($DeleteOfficeHalfDoneCasePermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/utility/delete_half_donecase_o">' . $this->lang->line("delete_office_half_done_case") . '</a></li>';
                                    }
                                    ?> 
                                    <?php
                                    $ModifyDagPattaPermission = $this->utilityclass->getMenuPermission('ModifyDagPatta');
                                    if (strpos($ModifyDagPattaPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/utility/get_all_junk_dags">Modify Dag & Patta ( Junk data )</a></li>';
                                        echo '<li class="divider"></li>';
                                    }
                                    ?> 
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/CaseSearch">Case Search</a></li>
                                    <?php
                                    $CaseTransferPermission = $this->utilityclass->getMenuPermission('CaseTransfer');
                                    if (strpos($CaseTransferPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/casetransfer">Case Transfer</a></li>';
                                    }
                                    ?> 
                                    <li class="divider"></li>
                                    <?php
                                    $UpdateRevenueLocalTaxPermission = $this->utilityclass->getMenuPermission('UpdateRevenueLocalTax');
                                    if (strpos($UpdateRevenueLocalTaxPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/ControllerForRevenueUpdate/SelectLocations">Update Revenue & Local Tax</a></li>';
                                        echo '<li class="divider"></li>';
                                    }
                                    ?> 
                                    <?php
                                    $LocationPermission = $this->utilityclass->getMenuPermission('Location');
                                    if (strpos($LocationPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/location">' . $this->lang->line("location_code") . '</a></li>';
                                    }
                                    ?>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes">View Location Codes</a></li>
                                    <?php
                                    $MasterCodePermission = $this->utilityclass->getMenuPermission('MasterCode');
                                    if (strpos($MasterCodePermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/master_code">' . $this->lang->line("master_code") . '</a></li>';
                                    }
                                    ?>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/master_code_view">View Master Codes</a></li>
                                </ul>
                            </li>
                            <li class="dropdown uni_text">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Khatian <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                    $AddKhatianPermission = $this->utilityclass->getMenuPermission('AddKhatian');
                                    if (strpos($AddKhatianPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/Tenants/indexAdd">Add Khatian</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $AddRemoveTenantsPermission = $this->utilityclass->getMenuPermission('AddRemoveTenants');
                                    if (strpos($AddRemoveTenantsPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/Tenants/deleteTenant">Add/Remove Tenants</a></li>';
                                    }
                                    ?>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Khatian">View Khatian</a></li>
                                </ul>
                            </li>
                            <li class="dropdown uni_text">
                                <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation" class="dropdown-toggle " data-toggle="" role="button" aria-expanded="false">Legacy Data Updation <sup><span class="badge badge-danger blink_me">New</span></sup></a>
                            </li>
<!--                            <li class="dropdown uni_text">
                                <a href="<?php echo base_url(); ?>index.php/ChithaJamaCompare/startAllCompare" class="dropdown-toggle uni_text " data-toggle="" role="button" aria-expanded="false">Chitha Vs Jamabandi</a>
                            </li>-->
                            <?php
                            $DataEntryViewPermission = $this->utilityclass->getMenuPermission('DataEntryView');
                            if (strpos($DataEntryViewPermission, $user_desig_code) !== false) {
                                echo '<li class="dropdown uni_text">
                                        <a href="' . base_url() . 'index.php/Chitha_basic_deo/listAll" class="dropdown-toggle " data-toggle="" role="button" aria-expanded="false">Data Entry View</a>
                                    </li>';
                            }
                            ?>
                        </ul>

                        <ul class="nav navbar-nav navbar-right hide">
                            <li class="dropdown uni_text">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class='uni_text '><a href="<?php echo base_url(); ?>index.php/Login/guideline ">Guidelines</a></li>
                                    <li class='uni_text '><a href="<?php echo base_url(); ?>index.php/Login/setLanguage ">Change Language</a></li>
                                    <?php
                                    $NewAccountPermission = $this->utilityclass->getMenuPermission('NewAccount');
                                    if (strpos($NewAccountPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/useraccount">' . $this->lang->line("new_account") . '</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $EnabledAccountsPermission = $this->utilityclass->getMenuPermission('EnabledAccounts');
                                    if (strpos($EnabledAccountsPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/all_active_enabled_users">Enabled Accounts</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $EnabledAccountsPermission = $this->utilityclass->getMenuPermission('EnabledAccountsforCo');
                                    if (strpos($EnabledAccountsPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/all_active_enabled_users_co">Enabled Accounts</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $DisabledAccountsPermission = $this->utilityclass->getMenuPermission('DisabledAccounts');
                                    if (strpos($DisabledAccountsPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/all_inactive_disabled_users">Disabled Accounts</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $DisabledAccountsPermission = $this->utilityclass->getMenuPermission('DisabledAccountsforCo');
                                    if (strpos($DisabledAccountsPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/all_inactive_disabled_users_co">Disabled Accounts</a></li>';
                                    }
                                    ?>
                                    <?php
                                    $OtherAccountsPermission = $this->utilityclass->getMenuPermission('OtherAccounts');
                                    if (strpos($OtherAccountsPermission, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/viewaccount_master">Other Accounts</a></li>';
                                    }
		?>
                                    <?php
                                    $ResetPassword = $this->utilityclass->getMenuPermission('resetpassword');
                                    if (strpos($ResetPassword, $user_desig_code) !== false) {
                                        echo '<li class="uni_text"><a href="' . base_url() . 'index.php/initialization/passwordreset">Reset Password</a></li>';
                                    }
                                    ?>
									<li class='uni_text'><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>"><?php echo $this->lang->line('password_settings'); ?></a></li>
                                    <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                </ul>
                            </li>
                        </ul>
						<ul>
						<li>
							<?php 
							$nocUser=$this->utilityclass->getNocPriv($this->session->userdata('user_code'),$this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'));
							?>
							<a href='<?=NOC_LINK?>index.php/login/SingleSign/<?=$nocUser?>' target='_blank' class='uni_text' ><i class='fa fa-book '> </i>  NOC</a>
							</li>
						</ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class='uni_text'>
                                <a>
                                    <?php
                                    $dist_code = $this->session->userdata('dist_code');
                                    $subdiv_code = $this->session->userdata('subdiv_code');
                                    $cir_code = $this->session->userdata('cir_code');
                                    $user_code = $this->session->userdata('user_code');

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
                                        echo "<span class=''>" . " <i class='fa fa-user'></i> " . $lm->lm_name . "</span> ";
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
            <?php
        }
        ?>
    </div>
	<div class="modal fade" id="aa" role="dialog"  data-backdrop="static">
        <div class="modal-dialog" style="padding-top: 15%;">
            <!-- Modal content-->
            <div class="modal-content" style="margin:0;padding:0">
                <div class="modal-body" style="margin:0;padding:0">
                    <div class="progress" style="margin:0;padding:0">
                        <div  class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%;margin:0;padding:0">
                            <p style="font-size: 1.2em !important;">Please wait...Background Operation In Progress.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
		<div class='col-lg-3 hide'>
			<?php include  ('home/menu.php'); ?>
		</div>
	
    
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
        function sticky_relocate() {
            var window_top = $(window).scrollTop();
            var div_top = $('#sticky-anchor').offset().top;
            if (window_top > div_top) {
                $(function () {
                    $(window).scroll(sticky_relocate);
                    sticky_relocate();
                });
                var dir = 1;
                var MIN_TOP = 80;
                var MAX_TOP = 250;
                function autoscroll() {
                    var window_top = $(window).scrollTop() + dir;
                    if (window_top >= MAX_TOP) {
                        window_top = MAX_TOP;
                        dir = -1;
                    } else if (window_top <= MIN_TOP) {
                        window_top = MIN_TOP;
                        dir = 1;
                    }
                    $(window).scrollTop(window_top);
                    window.setTimeout(autoscroll, 100);
                }
            }
        }
    </script>
	
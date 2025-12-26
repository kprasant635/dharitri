<?php date_default_timezone_set('Asia/Calcutta'); ?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <style>
            .test {
                width:200px;
                display:inline-block;
                overflow: auto;
                white-space: nowrap;
                margin:0px auto;
                border:1px red solid;
            }
        </style>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>
            <?php 
            if (isset($title)) {
                echo $title;
            }
            else
            {
                echo "DHARITREE || Land Records Computerization Project";
            }
            ?>
        </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <!-- JS file starts here-->
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
        </style>
</head>
<body>
    <div class="row dg-assam noprint" >
        <div class="col-lg-12" id="actions" style="z-index:999;" >
            <div class="row">
                <div class='col-lg-10'>
                    <img src="<?php echo base_url(); ?>application/views/images/indiaflag.gif" width='50' style='float:left; margin-left:30px;padding: 0 8px;line-height: 30px; margin-top:1px'>
                    <span class='dg-text-assam'>GOVERNMENT OF ASSAM</span>
                </div>
                <div class="col-lg-2 magnifier" >
                    <label id="plus"><sup>+</sup>A</label>
                    <label id="minus"><sup>-</sup>A</label>
                    <label id="hide" class='hide'><i class="fa fa-arrow-circle-up"></i></label>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid noprint">
        <div class='row headerwrap'>
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
                    <div class='col-lg-3 emblem1' >
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
        <div id="sticky-anchor"></div>
        <?php
        $user_desig_code = $this->session->userdata('user_desig_code');
        if (($user_desig_code != '') || ($user_desig_code != null)) {
            ?>
            <div class="row">
                <nav class="navbar menu">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li class="uni_text"><a href="<?php echo base_url(); ?>index.php/home/"><i class='fa fa-home'></i> <?php echo "Home"; //$this->lang->line('dharitree');              ?></a></li>
                        </ul>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <?php
                            //$user_desig_code = $this->session->userdata('user_desig_code');
                            if (($user_desig_code == 'CO') || ($user_desig_code == 'ASO')) {
                                ?>
                                <ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><?php echo $this->lang->line('chitha_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/CentralDiary "><?php echo $this->lang->line('central_diary'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('allotment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('encroachment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('khatian_tenant_register'); ?></a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/chithareportkamrup" class="not-active"><?php echo $this->lang->line('chitha_report_kamrup'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Jamabandi"> <?php echo $this->lang->line('jamabandi_auto_update'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"> <?php echo $this->lang->line('inconsistance_jamabandi_view_delete'); ?></a></li> 
                                            <li class='divider'></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle uni_text " data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('utility'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/misc_utilities">Misc utilities</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities">Back Log Entry</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithaeditentry">Chitha Edit/Entry</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/jamaeditentry">Jamabandi Edit/Entry</a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('delete_pattadar'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/districtselect"><?php echo $this->lang->line('delete_dag_info'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/districtDetails_junk">Delete Patta Information</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/get_all_junk_dags">Modify Dag & Patta ( Junk data )</a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/CaseSearch">Case Search</a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations">Update Revenue & Local Tax</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle uni_text" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('initialisation'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/location"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><?php echo $this->lang->line('master_code'); ?></a></li>
                                            <li class="divider" hide></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('field_mutation_case_status'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('revenue_location'); ?> </a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('certificate_type'); ?></a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="<?php echo base_url(); ?>index.php/ChithaJamaCompare/startAllCompare" class="dropdown-toggle uni_text " data-toggle="" role="button" aria-expanded="false">Chitha Vs Jamabandi</a>
                                    </li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <!--<li class='uni_text'><a href="#">Link</a></li>-->
                                    <li class='uni_text'>

                                        <a><?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            $subdiv_code = $this->session->userdata('subdiv_code');
                                            $cir_code = $this->session->userdata('cir_code');
                                            $user_code = $this->session->userdata('user_code');
                                            if (($user_desig_code == 'CO')) {
                                                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            if (($user_desig_code == 'ASO')) {
                                                $co = $this->utilityclass->getSelectedASOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            ?></a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/useraccount "><?php echo $this->lang->line('new_account'); ?></a></li>
                                            <li class='uni_text '><a href="<?php echo base_url(); ?>index.php/Login/guideline ">Guidelines</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users_co"><?php echo "Enabled Accounts"; ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users_co"><?php echo "Disabled Accounts" ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/viewaccount_master">Other Accounts</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                            } else if (($user_desig_code == 'AST') || ($user_desig_code == 'LM') || ($user_desig_code == 'SK') || ($user_desig_code == 'SA') || ($user_desig_code == 'BO')) {
                                ?>
                                <ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><?php echo $this->lang->line('chitha_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#"><?php echo $this->lang->line('allotment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#"><?php echo $this->lang->line('encroachment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#"><?php echo $this->lang->line('khatian_tenant_register'); ?></a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/chithareportkamrup" class="not-active"><?php echo $this->lang->line('chitha_report_kamrup'); ?></a></li>
                                            <!--<li class='uni_text'><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>-->
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Jamabandi"> <?php echo $this->lang->line('jamabandi_auto_update'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"> <?php echo $this->lang->line('inconsistance_jamabandi_view_delete'); ?></a></li> 
                                            <li class='divider'></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('query'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php
                                            if ($user_desig_code != 'LM') {
                                                ?>
                                                <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities">Back Log Entry</a></li>
                                                <?php
                                            }
                                            ?>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/CaseSearch">Case Search</a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><?php echo $this->lang->line('master_code'); ?></a></li>
                                            <li class='uni_text hide'><a href="#"><?php echo $this->lang->line('field_mutation_case_status'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="<?php echo base_url(); ?>index.php/ChithaJamaCompare/startAllCompare" class="dropdown-toggle uni_text " data-toggle="" role="button" aria-expanded="false">Chitha Vs Jamabandi</a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Khatian<span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php
                                            if ($user_desig_code != 'LM') {
                                                ?>
                                                <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities">Back Log Entry</a></li>
                                                <?php
                                            }
                                            ?>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Tenants/indexAdd">Add Tenants</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Khatian">View Khatian</a></li>

                                            <li class="divider"></li>
                                        </ul>
                                    </li>

                                </ul>

                                <ul class="nav navbar-nav navbar-right">
                                    <!--<li><a href="#">Link</a></li>-->
                                    <li class=' uni_text'>

                                        <a class=""> 
                                            <?php
                                            //var_dump($this->session->all_userdata());
                                            $dist_code = $this->session->userdata('dist_code');
                                            $subdiv_code = $this->session->userdata('subdiv_code');
                                            $cir_code = $this->session->userdata('cir_code');
                                            $user_code = $this->session->userdata('user_code');
                                            if ($this->session->userdata('user_desig_code') == 'AST') {
                                                $asstt = $this->utilityclass->getSelectedAssttName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $asstt->username . "</span> ";
                                            }
                                            if ($user_desig_code == 'LM') {
                                                $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
                                                $lot_no = $this->session->userdata('lot_no');
                                                $lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $lm->lm_name . "</span> ";
                                            }
                                            if ($user_desig_code == 'SK') {
                                                $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $sk->username . "</span> ";
                                            }
                                            if ($user_desig_code == 'SA') {
                                                $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $sk->username . "</span> ";
                                            }
                                            if ($user_desig_code == 'BO') {
                                                $bo = $this->utilityclass->getDefinedBOName($dist_code, $user_code);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $bo->username . "</span> ";
                                            }
                                            ?>


                                        </a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>"><?php echo $this->lang->line('password_settings'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                            } else if (($user_desig_code == 'DC') || ($user_desig_code == 'ADC') || ($user_desig_code == 'LAO')) {
                                ?>
                                <ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao"><?php echo $this->lang->line('chitha_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/CentralDiary "><?php echo $this->lang->line('central_diary'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('allotment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('encroachment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('khatian_tenant_register'); ?></a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/chithareportkamrup" class="not-active"><?php echo $this->lang->line('chitha_report_kamrup'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/jamadistrictDetails_dc_lao"> <?php echo $this->lang->line('jamabandi_auto_update'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"> <?php echo $this->lang->line('inconsistance_jamabandi_view_delete'); ?></a></li> 
                                            <li class='divider'></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle uni_text" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('initialisation'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/location"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/view_master_location_codes"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><?php echo $this->lang->line('master_code'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('field_mutation_case_status'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('revenue_location'); ?> </a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('certificate_type'); ?></a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <!--<li class='uni_text'><a href="#">Link</a></li>-->
                                    <li class='uni_text'>

                                        <a><?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            $subdiv_code = $this->session->userdata('subdiv_code');
                                            $cir_code = $this->session->userdata('cir_code');
                                            $user_code = $this->session->userdata('user_code');
                                            if (($user_desig_code == 'DC') || ($user_desig_code == 'ADC') || ($user_desig_code == 'LAO')) {
                                                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            ?></a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/viewaccount_master">Other Accounts</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                            } else if (($user_desig_code == 'ADM')) {
                                ?>
                                <ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao"><?php echo $this->lang->line('chitha_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/CentralDiary "><?php echo $this->lang->line('central_diary'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('allotment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('encroachment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('khatian_tenant_register'); ?></a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/chithareportkamrup" class="not-active"><?php echo $this->lang->line('chitha_report_kamrup'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Jamabandi"> <?php echo $this->lang->line('jamabandi_auto_update'); ?></a></li>
                                            <li class='uni_text'><a href="#" class="not-active"> <?php echo $this->lang->line('inconsistance_jamabandi_view_delete'); ?></a></li> 
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle uni_text " data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('utility'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/misc_utilities">Misc utilities</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities">Back Log Entry</a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('delete_pattadar'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/districtselect"><?php echo $this->lang->line('delete_dag_info'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/get_all_junk_dags">Modify Dag & Patta ( Junk data )</a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/delete_half_donecase_o"><?php echo $this->lang->line('delete_office_half_done_case'); ?></a></li>
                                            <!--<li class="divider"></li>-->
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('dag_no_enumeration'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('duplicate_pattadar_management'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('corresponding_sk_code_correction'); ?></a></li>
                                            <!--<li class="divider hide"></li>-->
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('data_size'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle uni_text" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('initialisation'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/location"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/master_code"><?php echo $this->lang->line('master_code'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text'><a href="#" class="not-active"><?php echo $this->lang->line('field_mutation_case_status'); ?></a></li>
                                            <li class='uni_text'><a href="#" class="not-active"><?php echo $this->lang->line('revenue_location'); ?> </a></li>
                                            <li class='uni_text'><a href="#" class="not-active"><?php echo $this->lang->line('certificate_type'); ?></a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="<?php echo base_url(); ?>index.php/ChithaJamaCompare/startAllCompare" class="dropdown-toggle uni_text " data-toggle="" role="button" aria-expanded="false">Chitha Vs Jamabandi</a>
                                    </li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <!--<li class='uni_text'><a href="#">Link</a></li>-->
                                    <li class='uni_text'>

                                        <a><?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            $subdiv_code = $this->session->userdata('subdiv_code');
                                            $cir_code = $this->session->userdata('cir_code');
                                            $user_code = $this->session->userdata('user_code');
                                            if (($user_desig_code == 'ADM')) {
                                                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            ?></a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/useraccount"><?php echo $this->lang->line('new_account'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users"><?php echo "Enabled Accounts"; ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users"><?php echo "Disabled Accounts" ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/viewaccount_master">Other Accounts</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                            } else if (($user_desig_code == 'RKG') || ($user_desig_code == 'RS') || ($user_desig_code == 'JAD') || ($user_desig_code == 'SAD')) {
                                ?>

                                <ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao"><?php echo $this->lang->line('chitha_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/CentralDiary "><?php echo $this->lang->line('central_diary'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('allotment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('encroachment_register'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('khatian_tenant_register'); ?></a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/chithareportkamrup" class="not-active"><?php echo $this->lang->line('chitha_report_kamrup'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active">Chitha Checklist ( Junk Dag No )</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown hide uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('maintenance'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/Jamabandi"> <?php echo $this->lang->line('jamabandi_auto_update'); ?></a></li>
                                            <li class='uni_text'><a href="#" class="not-active"> <?php echo $this->lang->line('inconsistance_jamabandi_view_delete'); ?></a></li> 
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown hide uni_text">
                                        <a href="#" class="dropdown-toggle uni_text " data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('utility'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/misc_utilities">Misc utilities</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities">Back Log Entry</a></li>
                                            <li class="divider hide"></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('delete_pattadar'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/districtselect"><?php echo $this->lang->line('delete_dag_info'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/get_all_junk_dags">Modify Dag & Patta ( Junk data )</a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/utility/delete_half_donecase_o"><?php echo $this->lang->line('delete_office_half_done_case'); ?></a></li>
                                            <!--<li class="divider"></li>-->
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('dag_no_enumeration'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('duplicate_pattadar_management'); ?></a></li>
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('corresponding_sk_code_correction'); ?></a></li>
                                            <!--<li class="divider hide"></li>-->
                                            <li class='uni_text hide'><a href="#" class="not-active"><?php echo $this->lang->line('data_size'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown hide uni_text">
                                        <a href="#" class="dropdown-toggle uni_text" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('initialisation'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/location"><?php echo $this->lang->line('location_code'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/initialization/master_code"><?php echo $this->lang->line('master_code'); ?></a></li>
                                            <li class="divider"></li>
                                            <li class='uni_text'><a href="#" class="not-active"><?php echo $this->lang->line('field_mutation_case_status'); ?></a></li>
                                            <li class='uni_text'><a href="#" class="not-active"><?php echo $this->lang->line('revenue_location'); ?> </a></li>
                                            <li class='uni_text'><a href="#" class="not-active"><?php echo $this->lang->line('certificate_type'); ?></a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown hide uni_text">
                                        <a href="<?php echo base_url(); ?>index.php/ChithaJamaCompare/startAllCompare" class="dropdown-toggle uni_text " data-toggle="" role="button" aria-expanded="false">Chitha Vs Jamabandi</a>
                                    </li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <!--<li class='uni_text'><a href="#">Link</a></li>-->
                                    <li class='uni_text'>

                                        <a><?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            $subdiv_code = $this->session->userdata('subdiv_code');
                                            $cir_code = $this->session->userdata('cir_code');
                                            $user_code = $this->session->userdata('user_code');
                                            if (($user_desig_code == 'RKG')) {
                                                $co = $this->utilityclass->getSelectedRkgName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            if (($user_desig_code == 'RS')) {
                                                $co = $this->utilityclass->getSelectedRSName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            if (($user_desig_code == 'SAD')) {
                                                $co = $this->utilityclass->getSelectedjadName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            if (($user_desig_code == 'JAD')) {
                                                $co = $this->utilityclass->getSelectedsadName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            ?></a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/useraccount"><?php echo $this->lang->line('new_account'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users"><?php echo "Enabled Accounts"; ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users"><?php echo "Disabled Accounts" ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/initialization/viewaccount_master"><?php echo $this->lang->line('view_account'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>

                            <?php } ?>

                        </div><!-- /.container-fluid -->
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



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
						<ul class="nav navbar-nav">
                            <li class="uni_text hide"><a href="<?php echo base_url(); ?>index.php/JamaEditEntry/"><i class='fa fa-edit'></i> JamaBandi Edit</a></li>
                        </ul>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <?php
                            if (($user_desig_code == 'deo') || ($user_desig_code == 'DEO')) {
                                ?>
                                <ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->lang->line('report'); ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><?php echo $this->lang->line('chitha_report'); ?></a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><?php echo $this->lang->line('jamabandi_report'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/MisReport"><?php echo $this->lang->line('mis_report'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/CentralDiary "><?php echo $this->lang->line('central_diary'); ?></a></li>
                                            <li class='uni_text hide'><a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList ">All Deed View List </a></li>
                                        </ul>
                                    </li>
                                    
                                </ul>
								<ul class="nav navbar-nav">
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle hide" data-toggle="dropdown" role="button" aria-expanded="false"> Jama Edit Report <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamaEditEntry/dageditlist">Dag Detail(s)</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamaEditEntry/editpattadar">Pattadar Name(s)</a></li>
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/JamaEditEntry/editremark">Remark(s)</a></li>
                                            
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
                                            if (($user_desig_code == 'DEO')) {
                                                $co = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);
                                                //var_dump($co);
                                                echo "<span class=''>" . " <i class='fa fa-user'></i> " . $co->username . "</span> ";
                                            }
                                            ?></a>
                                    </li>
                                    <li class="dropdown uni_text">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('settings'); ?> <i class="fa fa-cog"></i></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class='uni_text'><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('logout'); ?></a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                            } 
							?>
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
    <script>
        $(document).ready(function () {
            $.NotificationService.showTopNotification({
                title: "Notice",
                message: "Assitant are requested to count number of pages before giving it to Applicant and update the amount after delivered.",
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



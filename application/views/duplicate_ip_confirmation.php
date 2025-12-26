<?php
date_default_timezone_set('Asia/Calcutta');
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <script type="text/javascript">
        const baseUrl='<?=BASE_JS_LINK?>';
    </script>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>DHARITREE || Land Records Computerization Project</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

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
    <script src="<?php echo base_url(); ?>application/views/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/views/js/bootstrap.min_1.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/views/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>application/views/js/jquery.tablesorter.min.js"></script>

    <!-------------->
    <script src="<?php echo base_url();?>application/views/css/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>application/views/css/jquery-confirm.min.css">
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
    <!-- Newly Added for Basundhara MB2 BY KINGS -->
</head>
<body>
<div id="ipmodal" class="modal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="<?=site_url("Login/confirmation")?>" method="post"> 
              <div class="modal-header d-flex justify-content-center" style="background-color: #ff3547;">
                <p style="font-size: 1.15rem;color: #fff;">Are you sure?</p>
              </div>
                <div class="modal-body" >
                    <div class="form-group">
                        <span class="errorMsg text-bold text-red"></span>
                        <center>
                        <i class="fas fa-bell fa-4x animated rotateIn mb-4"></i><br><br>
                        Your User Account is already being accessed from public IP
                        <!-- <span class="badge" style="background-color: #00c851;"><?=$ips_exists?> IP(s). </span>  -->

                        <br>
                        If you want to login in the current system, All other user accessing the Application would be forefully logged out. <br><hr>
                        <h3> Do you still want to continue ? </h3>
                    </center>
                    </div>
                    <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_token ?>">
                </div>
                <div class="modal-footer">
                    <input type="submit" name="confirm_y" type="submit" class="btn btn-primary" value="YES">
                    <input type="submit" name="confirm_n" type="submit" class="btn btn-danger" value="NO">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#ipmodal").modal({backdrop: 'static', keyboard: false});
    });
</script>
</body>
</html>

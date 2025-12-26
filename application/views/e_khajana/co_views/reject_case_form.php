<link href="<?php echo base_url(); ?>application/views/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/select2/select2.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold">
            <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/pendingList'?>">
                E-Khajana-(Pending-list)
            </a>
        </li>
         <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Reject-Form)</li>
    </ol>
    
</nav>
<div class="container-fluid form-top login">
    <div class="row">               
        <div class="col-lg-1"></div>
            <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
                <div class="card-body">
                <div class="panel panel-info">
                    <div class="panel-heading text-center bg-success">
                        <h3 class="panel-title text-white">
                            ANOTHER CASE EXISTS FOR THE PATTADAR-(<?=$caseDetails->pdar_name?>) WITH PATTA NO-(<?=$caseDetails->patta_no?>)
                        </h3>
                    </div>
                    <div class="panel-heading bg-warning text-center">
                        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
                            <b>NOTE :</b> CASE NO <b>(<?=$caseDetails->case_no?>)</b> CAN NOT BE FORWAREDED.
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-3 text-center">
                        <button class="btn btn-danger btn-sm" onclick="rejectCase('<?=$caseDetails->id?>')"
                        style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                REJECT
                        </button>
                        <a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>"
                            class="btn btn-danger btn-sm text-white" role="button" 
                            style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                                BACK TO HOME PAGE 
                        </a>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>

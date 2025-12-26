<!-- Masud's CSS-->
<style>
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard {
        margin: 10px auto;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
        padding-top: 10px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }


    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005B96 !important;
        text-decoration: none;
    }
    .wizard li.active{
        background: #005B96;
        padding: 0px;
        box-shadow: 1px 0px 1px 1px;

    }

    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 45%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #ffffff;
    }

    .wizard .nav-tabs > li a {
        text-align: center;
        /* width: 90%; */
        margin-bottom: 10px;
        /* padding: 0; */
    }
    .wizard .nav-tabs > li a:hover {
        background-color: transparent !important;
    }


    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }



</style>

<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 15px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        padding-bottom: -1px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
</style>

<style>
    .timeline {
        max-width: 830px;
        margin: 0px auto;
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 15px 0px;
    }
    .timeline::after {
        content: "";
        position: absolute;
        width: 3px;
        background-color: #848892;
        height: 100%;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
    }
    .timeline__content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 18px 30px;
        background-color: white;
        border-radius: 5px;
        position: relative;
        width: 386px;
        box-shadow: 0 2px 8px 0 #242e4c59;
    }
    .timeline__content::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: white;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
    }
    .timeline__content::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        /*background-color: #848892;*/
        border-radius: 50%;
        transform: translateY(-50%);
    }
    .timeline__content:nth-child(odd) {
        margin-left: auto;
    }
    .timeline__content:nth-child(odd) .content_tag {
        right: 5px;
    }
    .timeline__content:nth-child(odd)::after {
        left: -10px;
    }
    .timeline__content:nth-child(odd)::before {
        top: 50%;
        left: -39px;
    }
    .timeline__content:nth-child(even) {
        align-items: flex-end;
    }
    .timeline__content:nth-child(even) .content_p {
        text-align: right;
    }
    .timeline__content:nth-child(even)::after {
        right: -10px;
    }
    .timeline__content:nth-child(even)::before {
        top: 50%;
        right: -39px;
    }
    .timeline__content:nth-child(even) .content_tag {
        left: 5px;
    }

    .content_tag {
        position: absolute;
        top: 5px;
        padding: 6px 10px;
        background-color: #66BB6A;
        border-radius: 3px;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
        text-transform: capitalize;
    }

    .content_date {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #848892;
    }
    .content_Name {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #673AB7;
    }
    .content_p {
        color: #242e4c;
        max-width: 230px;
        margin-bottom: 20px;
    }
    .content_link {
        display: inline-flex;
        text-decoration: none;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
    }
    .content_link svg {
        margin-left: 5px;
    }
    .content_link:hover {
        color: royalblue;
        transition-duration: 300ms;
    }
    .content_link:hover svg path {
        fill: royalblue;
    }



    @media screen and (max-width: 600px) {
        .timeline {
            gap: 15px;
            padding: 10px;
        }
        .timeline::after {
            display: none;
        }
        .timeline__content {
            width: 100%;
        }
        .timeline__content::after {
            display: none;
        }
        .timeline__content::before {
            display: none;
        }
    }
</style>

<style>
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
        border: 1px solid #999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative;
    }
    .tree li::before,
    .tree li::after {
        content: "";
        left: -20px;
        position: absolute;
        right: auto;
    }
    .tree li::before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px;
    }
    .tree li::after {
        border-top: 1px solid #999;
        height: 20px!important;
        top: 25px;
        width: 25px;
    }
    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #999;
        border-radius: 5px;
        display: inline-block;
        padding: 3px 8px;
        text-decoration: none;
    }
    .tree li.parent_li > span {
        cursor: pointer;
    }
    .tree > ul > li::before,
    .tree > ul > li::after {
        border: 0;
    }
    .tree li:last-child::before {
        height: 46px;
    }
    .tree li.parent_li > span:hover,
    .tree li.parent_li > span:hover + ul li span {
        background: #eee;
        border: 1px solid #94a0b4;
        color: #000;
    }


    .rezaSpan{
        min-width: 140px;
        padding-left: 15px;
    }
    .rezaSpanB{
        min-width: 100px;
        padding-left: 15px;
    }
    .rezaCaseSpan{
        min-width: 270px;
        padding-left: 15px;
    }
    .rezaCaseSpanTotal{
        min-width: 270px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanBTotal{
        min-width: 100px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }
    .rezaSpanTotal{
        min-width: 140px;
        padding-left: 15px;
        border: 2px solid #FF5252!important;
        background-color: #bc9fea;
    }



    .badge-reza1{
        background-color: #F44336;
    }
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #9C27B0;
    }


</style>

<script>
    $(document).ready(function () {
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);

            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);

        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }

</script>



<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
{
    $lessa_chatak='Chatak';
}
else
{
    $lessa_chatak='Lessa';
}?>


<div class="row" style='padding-top: 15px; margin-bottom: 20px'>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php echo $this->lang->line('offlineSettlementSidebar') ?> /
        <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas" style="text-decoration: none">
            Khas Land /
        </a>
        <a href="<?= base_url()?>index.php/OfflineSettlementCoController/getPendingApplicationListCo" style="text-decoration: none">
            View Pending Offline Application /
        </a>
        View

        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
        </a>

        <?php if($this->session->flashdata('success')) { ?>
            <br>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <br>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>

    <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                    <li role="presentation" class="active">
                        <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1" >
                            <span class="round-tab"><strong>Application</strong></span>
                        </a>
                    </li>
                    <?php if(!empty($lmnotes)) : ?>
                        <li role="presentation">
                            <a class="test" href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2" >
                                <span class="round-tab"><strong>Lot Mondal</strong></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li role="presentation">
                        <a class="test" href="#stepCo" data-toggle="tab" aria-controls="stepCo" role="tab" title="Step Co" >
                            <span class="round-tab"><strong>Circle Officer</strong></span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="test" href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3" >
                            <span class="round-tab"><strong>Proceedings</strong></span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="test" href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Step 4" >
                            <span class="round-tab"><strong>History</strong></span>
                        </a>
                    </li>
                    <?php if(!empty($premium_data)) : ?>
                        <li role="presentation">
                            <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="step 5">
                                <span class="round-tab"><strong>Premium</strong></span>
                            </a>
                        </li>
                    <?php endif; ?>


                </ul>
            </div>

            <div class="tab-content">

                <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                    <?php echo $this->lang->line('offlineSettlementKhasLandTitle')?> (
                    <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$case_no?></span> )
                </h5>

                <!-- Application -->
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="reza-card">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-file-text"></i>  Application Details
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/application_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-map-marker"></i>  Location Details
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/location_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-user"></i>  Applicant Details
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/applicant_details.php"); ?>


                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-user-secret"></i>  Encroacher Details
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/encroacher_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-map"></i>  Area Details
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/dag_details.php"); ?>


                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-users"></i>  Family Details
                                <?php if(OFFLINE_SETTLEMENT_ENABLE_FAMILY_BUTTON_LM == 1){?>
                                    <span class="pull-right"><button type="button" onclick="addFamily();" class="btn btn-sm btn-warning" style="margin-top:-5px !important">Add Family</button></span>
                                <?php } ?>
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/family_details.php"); ?>


                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-file-pdf-o"></i> Supporting Documents
                            </h5>
                            <?php include(APPPATH."views/OfflineSettlement/include/document_details.php"); ?>

                        </div>
                    </div>

                    <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                            <button type="button" class="btn btn-primary next-step">
                                <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- LM Report -->
                <?php if(!empty($lmnotes)) : ?>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <div class="reza-card">
                            <div class="reza-body">
                                <h5  class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
                                </h5>

                                <?php include(APPPATH."views/OfflineSettlement/include/lm_report_view.php"); ?>

                            </div>
                        </div>

                        <ul class="list-inline pull-right" style="margin-top: 20px">
                            <li>
                                <button type="button" class="btn btn-default prev-step">
                                    <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-primary next-step">
                                    <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                                </button>
                            </li>
                        </ul>

                    </div>
                <?php endif; ?>

                <!-- co report  -->
                <div class="tab-pane" role="tabpanel" id="stepCo">
                    <div class="reza-card ">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Previous Remark
                            </h5>

                            <?php if ($proceedings) {  ?>
                                <div class="tableCard ">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Date of remark</th>
                                            <th>From</th>
                                            <th>Remark</th>
                                        </tr>
                                        <?php
                                        $i = 1;
                                        foreach ($proceedings as $pro):
                                            if ($i == 1) {
                                                ?>
                                                <tr>
                                                    <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                                    <td><?=$pro->office_from;?></td>
                                                    <td><span class="text-success"><?=$pro->note_on_order;?></span></td>
                                                </tr>
                                            <?php }
                                            $i++;endforeach;?>
                                    </table>
                                </div>
                            <?php }?>

                            <?php include(APPPATH."views/OfflineSettlement/include/area_modified.php"); ?>
                            <?php include(APPPATH."views/OfflineSettlement/include/encroacher_eligibility.php"); ?>

                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-map" aria-hidden="true"></i> Area Details Dag Wise
                            </h5>
                            <div class="tableCard">
                                <div class="tree" >
                                    <?php foreach ($chithaArea as $singleChithaArea): ?>
                                        <?php
                                        $totalApproveB = 0;
                                        $totalApproveK = 0;
                                        $totalApproveL = 0;
                                        $totalApproveG = 0;
                                        $totalApproveLessa = 0;
                                        $totalApproveGanda = 0;
                                        $totalApproveLessaInBKL  = 0;
                                        $totalApproveLessaInBKCG = 0;

                                        $totalLmProB = 0;
                                        $totalLmProK = 0;
                                        $totalLmProL = 0;
                                        $totalLmProG = 0;
                                        $totalLessa  = 0;
                                        $totalGanda  = 0;
                                        $totalLessaInBKL  = 0;
                                        $totalLessaInBKCG = 0;
                                        $toalLmProLNotSub = 0;

                                        $totalLmProBNotSub = 0;
                                        $totalLmProKNotSub = 0;
                                        $totalLmProLNotSub = 0;
                                        $totalLmProGNotSub = 0;
                                        $totalLessaNotSub  = 0;
                                        $totalGandaNotSub  = 0;
                                        $totalLessaInBKLNotSub  = 0;
                                        $totalLessaInBKCGNotSub = 0;

                                        ?>

                                        <ul style="margin-bottom: 50px">
                                            <li >
                                                <span>
                                                    <i class="fa fa-map"></i> Dag Number
                                                    <b><?php echo $singleChithaArea->dag_no ?></b>, Patta Number
                                                    <b><?php echo $singleChithaArea->patta_no ?></b>
                                                </span>
                                                <ul style="padding-bottom: 20px!important;">
                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                        <span class="badge badge-reza1" style="padding: 5px; font-size: 14px;">
                                                            <i class="fa fa-map-marker"></i>
                                                            &nbsp; Total Area Details Chitha
                                                        </span>
                                                        <ul>
                                                            <li>
                                                                <span class="rezaSpan">
                                                                    Bigha &nbsp;
                                                                    <b><?php echo $singleChithaArea->dag_area_b ?></b>
                                                                </span>
                                                                <span class="rezaSpan">
                                                                    Katha &nbsp;
                                                                    <b><?php echo $singleChithaArea->dag_area_k ?></b>
                                                                </span>
                                                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                    <span class="rezaSpan">
                                                                        Chatak &nbsp;
                                                                        <b><?php echo $singleChithaArea->dag_area_lc ?></b>
                                                                    </span>
                                                                    <span class="rezaSpan">
                                                                        Ganda &nbsp;
                                                                        <b><?php echo $singleChithaArea->dag_area_g ?></b>
                                                                    </span>

                                                                <?php else: ?>
                                                                    <span class="rezaSpan">
                                                                        Lessa &nbsp;
                                                                        <b><?php echo $singleChithaArea->dag_area_lc ?></b>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </li>
                                                        </ul>
                                                    </li>

                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                        <span class="badge badge-reza2" style="padding: 5px; font-size: 14px">
                                                            <i class="fa fa-check-circle-o"></i>
                                                            &nbsp; Total DC/ADC/SDO Approved Area In this Dag
                                                        </span>
                                                        <?php foreach ($reservedArea as $reza): ?>
                                                            <?php foreach ($reza as $singleReservedArea): ?>
                                                                <?php if ($singleChithaArea->dag_no == $singleReservedArea->dag_no): ?>
                                                                    <ul>
                                                                        <li >
                                                                            <span class="rezaCaseSpan">
                                                                                <a target="_blank" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=<?php echo $singleReservedArea->case_no; ?>" style="text-decoration: none">
                                                                                    <b><?php echo $singleReservedArea->case_no ?> </b>
                                                                                </a>
                                                                            </span>
                                                                            <span class="rezaSpanB">
                                                                                Bigha &nbsp;
                                                                                <b><?php echo $singleReservedArea->s_dag_area_b ?></b>
                                                                            </span>
                                                                            <span class="rezaSpanB">
                                                                                Katha &nbsp;
                                                                                <b><?php echo $singleReservedArea->s_dag_area_k ?></b>
                                                                            </span>

                                                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                                <span class="rezaSpan">
                                                                                    Chatak &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_lc ?></b>
                                                                                </span>
                                                                                <span class="rezaSpan">
                                                                                    Ganda &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_g ?></b>
                                                                                </span>

                                                                            <?php else: ?>
                                                                                <span class="rezaSpan">
                                                                                    Lessa &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_lc ?></b>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </li>
                                                                    </ul>

                                                                    <?php
                                                                    $totalApproveB += $singleReservedArea->s_dag_area_b;
                                                                    $totalApproveK += $singleReservedArea->s_dag_area_k;
                                                                    $totalApproveL += $singleReservedArea->s_dag_area_lc;
                                                                    $totalApproveG += $singleReservedArea->s_dag_area_g;

                                                                    $totalApproveLessa = $this->utilityclass->Total_Lessa($totalApproveB,$totalApproveK,$totalApproveL);
                                                                    $totalApproveLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalApproveLessa);
                                                                    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                                                    {
                                                                        $totalApproveGanda = $this->utilityclass->Total_ganda($totalApproveB,$totalApproveK,$totalApproveL,$totalApproveG);
                                                                        $totalApproveLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalApproveGanda);
                                                                    }
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>

                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <?php if($totalApproveGanda != 0): ?>
                                                                <ul>
                                                                    <li style="margin-top: 5px">
                                                                        <span class="rezaCaseSpanTotal" style="font-weight: bold; align-content: center!important;" >
                                                                            Total DC/ADC/SDO Approved Area
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Bigha &nbsp;
                                                                            <b><?php echo $totalApproveLessaInBKCG[0] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Katha &nbsp;
                                                                            <b><?php echo $totalApproveLessaInBKCG[1] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Chatak &nbsp;
                                                                            <b><?php echo round($totalApproveLessaInBKCG[2],5)  ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Ganda &nbsp;
                                                                            <b><?php echo round($totalApproveLessaInBKCG[3],5) ?></b>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if($totalApproveLessa != 0): ?>
                                                                <ul>
                                                                    <li style="margin-top: 5px">
                                                                        <span class="rezaCaseSpanTotal" style="font-weight: bold; align-content: center!important;" >
                                                                            Total DC/ADC/SDO Approved Area
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Bigha &nbsp;
                                                                            <b><?php echo $totalApproveLessaInBKL[0] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Katha &nbsp;
                                                                            <b><?php echo $totalApproveLessaInBKL[1] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Lessa &nbsp;
                                                                            <b><?php echo round($totalApproveLessaInBKL[2],5)  ?></b>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                        <span class="badge " style="padding: 5px; font-size: 14px; background-color: #6f42c1">
                                                            <i class="fa fa-spinner"></i>
                                                            &nbsp; LM Processed Area In this Dag (LM Report Submitted)
                                                        </span>
                                                        <?php foreach ($lmProcessArea as $single): ?>
                                                            <?php foreach ($single as $singleReservedArea): ?>
                                                                <?php if ($singleChithaArea->dag_no == $singleReservedArea->dag_no): ?>
                                                                    <?php if ($singleChithaArea->status != 'Z'): ?>
                                                                        <ul>
                                                                            <li>
                                                                                <span class="rezaCaseSpan">
                                                                                    <a target="_blank" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=<?php echo $singleReservedArea->case_no; ?>" style="text-decoration: none">
                                                                                        <b><?php echo $singleReservedArea->case_no ?> </b>
                                                                                    </a>
                                                                                </span>
                                                                                <span class="rezaSpanB">
                                                                                    Bigha &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_b ?></b>
                                                                                </span>
                                                                                <span class="rezaSpanB">
                                                                                    Katha &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_k ?></b>
                                                                                </span>
                                                                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                                    <span class="rezaSpan">
                                                                                        Chatak &nbsp;
                                                                                        <b><?php echo $singleReservedArea->s_dag_area_lc ?></b>
                                                                                    </span>
                                                                                    <span class="rezaSpan">
                                                                                        Ganda &nbsp;
                                                                                        <b><?php echo $singleReservedArea->s_dag_area_g ?></b>
                                                                                    </span>
                                                                                <?php else: ?>
                                                                                    <span class="rezaSpan">
                                                                                Lessa &nbsp;
                                                                                <b><?php echo $singleReservedArea->s_dag_area_lc ?></b>
                                                                            </span>
                                                                                <?php endif; ?>
                                                                            </li>
                                                                        </ul>
                                                                        <?php
                                                                        $totalLmProB += $singleReservedArea->s_dag_area_b;
                                                                        $totalLmProK += $singleReservedArea->s_dag_area_k;
                                                                        $totalLmProL += $singleReservedArea->s_dag_area_lc;
                                                                        $totalLmProG += $singleReservedArea->s_dag_area_g;

                                                                        $totalLessa = $this->utilityclass->Total_Lessa($totalLmProB,$totalLmProK,$totalLmProL);
                                                                        $totalLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessa);
                                                                        if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                                                        {
                                                                            $totalGanda = $this->utilityclass->Total_ganda($totalLmProB,$totalLmProK,$totalLmProL,$totalLmProG);
                                                                            $totalLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalGanda);
                                                                        }
                                                                        ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>

                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <?php if($totalGanda != 0): ?>
                                                                <ul>
                                                                    <li style="margin-top: 5px">
                                                                        <span class="rezaCaseSpanTotal" style="font-weight: bold; align-content: center!important;" >
                                                                            Total LM Processed Area
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Bigha &nbsp;
                                                                            <b><?php echo $totalLessaInBKCG[0] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Katha &nbsp;
                                                                            <b><?php echo $totalLessaInBKCG[1] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Chatak &nbsp;
                                                                            <b><?php echo round($totalLessaInBKCG[2],5)  ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Ganda &nbsp;
                                                                            <b><?php echo round($totalLessaInBKCG[3],5) ?></b>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>

                                                        <?php else: ?>
                                                            <?php if($totalLessa != 0): ?>
                                                                <ul>
                                                                    <li style="margin-top: 5px">
                                                                        <span class="rezaCaseSpanTotal" style="font-weight: bold; align-content: center!important;" >
                                                                            Total LM Processed Area
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Bigha &nbsp;
                                                                            <b><?php echo $totalLessaInBKL[0] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Katha &nbsp;
                                                                            <b><?php echo $totalLessaInBKL[1] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Lessa &nbsp;
                                                                            <b><?php echo round($totalLessaInBKL[2],5)  ?></b>
                                                                        </span>

                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                        <span class="badge " style="padding: 5px; font-size: 14px; background-color: #6f42c1">
                                                            <i class="fa fa-spinner"></i>
                                                            &nbsp; Applied Area In this Dag (LM Report Not Submitted)
                                                        </span>
                                                        <?php foreach ($lmProcessArea as $single): ?>
                                                            <?php foreach ($single as $singleReservedArea): ?>
                                                                <?php if ($singleChithaArea->dag_no == $singleReservedArea->dag_no): ?>
                                                                    <?php if ($singleChithaArea->status == 'Z'): ?>
                                                                        <ul>
                                                                            <li>
                                                                                <span class="rezaCaseSpan">
                                                                                    <a target="_blank" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=<?php echo $singleReservedArea->case_no; ?>" style="text-decoration: none">
                                                                                        <b><?php echo $singleReservedArea->case_no ?> </b>
                                                                                    </a>
                                                                                </span>
                                                                                <span class="rezaSpanB">
                                                                                    Bigha &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_b ?></b>
                                                                                </span>
                                                                                <span class="rezaSpanB">
                                                                                    Katha &nbsp;
                                                                                    <b><?php echo $singleReservedArea->s_dag_area_k ?></b>
                                                                                </span>

                                                                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                                    <span class="rezaSpan">
                                                                                        Chatak &nbsp;
                                                                                        <b><?php echo $singleReservedArea->s_dag_area_lc ?></b>
                                                                                    </span>
                                                                                    <span class="rezaSpan">
                                                                                        Ganda &nbsp;
                                                                                        <b><?php echo $singleReservedArea->s_dag_area_g ?></b>
                                                                                    </span
                                                                                <?php else: ?>
                                                                                    <span class="rezaSpan">
                                                                                        Lessa &nbsp;
                                                                                        <b><?php echo $singleReservedArea->s_dag_area_lc ?></b>
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </li>
                                                                        </ul
                                                                        <?php
                                                                        $totalLmProBNotSub += $singleReservedArea->s_dag_area_b;
                                                                        $totalLmProKNotSub += $singleReservedArea->s_dag_area_k;
                                                                        $toalLmProLNotSub  += $singleReservedArea->s_dag_area_lc;
                                                                        $totalLmProGNotSub += $singleReservedArea->s_dag_area_g;

                                                                        $totalLessaNotSub = $this->utilityclass->Total_Lessa($totalLmProBNotSub,$totalLmProKNotSub,$totalLmProLNotSub);
                                                                        $ttalLessaInBKLNotSub  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessaNotSub);
                                                                        if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
                                                                        {
                                                                            $totalGandaNotSub = $this->utilityclass->Total_ganda($totalLmProBNotSub,$totalLmProKNotSub,$totalLmProLNotSub,$totalLmProGNotSub);
                                                                            $totalLessaInBKCGNotSub = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalGandaNotSub);
                                                                        }
                                                                        ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>

                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <?php if($totalGandaNotSub != 0): ?>
                                                                <ul>
                                                                    <li style="margin-top: 5px">
                                                                        <span class="rezaCaseSpanTotal" style="font-weight: bold; align-content: center!important;" >
                                                                            Total LM Processed Area
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Bigha &nbsp;
                                                                            <b><?php echo $totalLessaInBKCGNotSub[0] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Katha &nbsp;
                                                                            <b><?php echo $totalLessaInBKCGNotSub[1] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Chatak &nbsp;
                                                                            <b><?php echo round($totalLessaInBKCGNotSub[2],5)  ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Ganda &nbsp;
                                                                            <b><?php echo round($totalLessaInBKCGNotSub[3],5) ?></b>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>

                                                        <?php else: ?>
                                                            <?php if($totalLessaNotSub != 0): ?>
                                                                <ul>
                                                                    <li style="margin-top: 5px">
                                                                        <span class="rezaCaseSpanTotal" style="font-weight: bold; align-content: center!important;" >
                                                                            Total LM Processed Area
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Bigha &nbsp;
                                                                            <b><?php echo $totalLessaInBKLNotSub[0] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanBTotal">
                                                                            Katha &nbsp;
                                                                            <b><?php echo $totalLessaInBKLNotSub[1] ?></b>
                                                                        </span>
                                                                        <span class="rezaSpanTotal">
                                                                            Lessa &nbsp;
                                                                            <b><?php echo round($totalLessaInBKLNotSub[2],5)  ?></b>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </li>

                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                        <span class="badge badge-reza3" style="padding: 5px; font-size: 14px">
                                                            <i class="fa fa-edit"></i>
                                                            &nbsp; Applied Area In Dag For Current Case
                                                        </span>
                                                        <?php foreach ($appliedDags as $singleAppliedArea): ?>
                                                            <?php if ($singleChithaArea->dag_no == $singleAppliedArea->dag_no): ?>
                                                                <ul>
                                                                    <li>
                                                                            <span class="rezaCaseSpan">
                                                                                <b><?php echo $singleAppliedArea->case_no ?></b>
                                                                            </span>
                                                                        <span class="rezaSpanB">
                                                                                Bigha &nbsp;
                                                                                <b><?php echo $singleAppliedArea->s_dag_area_b ?></b>
                                                                            </span>
                                                                        <span class="rezaSpanB">
                                                                                Katha &nbsp;
                                                                                <b><?php echo $singleAppliedArea->s_dag_area_k ?></b>
                                                                            </span>
                                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                            <span class="rezaSpan">
                                                                                    Chatak &nbsp;
                                                                                    <b><?php echo $singleAppliedArea->s_dag_area_lc ?></b>
                                                                                </span>
                                                                            <span class="rezaSpan">
                                                                                    Ganda &nbsp;
                                                                                    <b><?php echo $singleAppliedArea->s_dag_area_g ?></b>
                                                                                </span>
                                                                        <?php else: ?>
                                                                            <span class="rezaSpan">
                                                                                    Lessa &nbsp;
                                                                                    <b><?php echo $singleAppliedArea->s_dag_area_lc ?></b>
                                                                                </span>
                                                                        <?php endif; ?>
                                                                    </li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </li>

                                                    <?php if(!empty($reservation)): ?>
                                                        <li>
                                                            <span class="badge badge-reza3" style="padding: 5px; font-size: 14px; background-color: #FF9800">
                                                                <i class="fa fa-object-ungroup"></i>
                                                                &nbsp; Reservation Area In Dag For Current Case
                                                            </span>
                                                            <?php foreach ($reservation as $singleRes): ?>
                                                                <?php if ($singleChithaArea->dag_no == $singleRes->dag_no): ?>
                                                                    <ul>
                                                                        <li>
                                                                                <span class="rezaCaseSpan">
                                                                                    <b><?php echo $singleRes->case_no ?></b>
                                                                                </span>
                                                                            <span class="rezaSpanB">
                                                                                    Bigha &nbsp;
                                                                                    <b><?php echo $singleRes->bigha ?></b>
                                                                                </span>
                                                                            <span class="rezaSpanB">
                                                                                    Katha &nbsp;
                                                                                    <b><?php echo $singleRes->katha ?></b>
                                                                                </span>
                                                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                                                <span class="rezaSpan">
                                                                                        Chatak &nbsp;
                                                                                        <b><?php echo $singleRes->lessa ?></b>
                                                                                    </span>
                                                                                <span class="rezaSpan">
                                                                                        Ganda &nbsp;
                                                                                        <b><?php echo $singleRes->ganda ?></b>
                                                                                    </span>
                                                                            <?php else: ?>
                                                                                <span class="rezaSpan">
                                                                                        Lessa &nbsp;
                                                                                        <b><?php echo $singleRes->lessa ?></b>
                                                                                    </span>
                                                                            <?php endif; ?>
                                                                        </li>
                                                                    </ul>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </li>
                                                    <?php endif; ?>

                                                </ul>
                                            </li>
                                        </ul>

                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <input type="hidden" id="caseNo" name="case_no" value="<?= $basic->case_no?>">

                            <?php include(APPPATH."views/OfflineSettlement/include/village_wise_area_show_co.php"); ?>


                            <?php if($areaCheck == 1): ?>
                                <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
                                    Total Area Recommended for Settlement can’t exceed available Area in Chitha !
                                </h5>
                                <br>
                            <?php endif; ?>


                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> CO Report
                            </h5>

                            <div class="tableCard ">

                                <?php
                                $pending_officer = $basic->pending_officer;
                                $from_office = $basic->from_office;
                                ?>
                                <form method="post" id="co_form_sub" name="co_form_sub" action="<?php echo base_url() ?>index.php/OfflineSettlementCoController/offlineCaseProcessByCo">
                                    <input type="hidden" id="case_no" name="case_no" value="<?=$basic->case_no ?>">
                                    <input type="hidden" autocomplete="off" class="form-control date" id="enable_next_date" name="hearing_date" value="05/09/2022" />
                                    <input type="hidden" name="coProcess" id="coProcess" value="">

                                    <div class="mt-4 row px-5">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <label class="control-label" style="font-size: 16px">
                                                <input type="radio" name="order_type" value="re_lm_note" id="reverttolm" style="height: 17px; width: 17px"> <b>Send Back to LM for Re Submitting Report</b>
                                            </label>
                                            &nbsp; &nbsp;
                                            <label class="control-label" style="font-size: 16px">
                                                <input type="radio" name="order_type" value="frwrddc" id="frwrdtodc" style="height: 17px; width: 17px"> <b>Forward</b>
                                            </label><br><br>
                                            <select name="remark_co_type" id="remark_co" onchange="autoRemark();" class="form-control">

                                                <?php
                                                foreach(json_decode(CO_NOTE) as $co_remark_cat){

                                                    if($validation_bypass == 1)
                                                    {
                                                        if($co_remark_cat->CODE == 1)
                                                        {
                                                            continue;
                                                        }
                                                    }
                                                    ?>
                                                    <option value="<?=$co_remark_cat->CODE?>"><?=$co_remark_cat->NAME?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <br>
                                            <textarea placeholder="Remarks  ..." name="remark_co" id="remark_co_text" class="form-control p-2" cols="30" rows="10"></textarea>
                                            <input type="hidden" name="case_no" value="<?=$basic->case_no ?>">

                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="row mt-4 justify-content-center">

                                        <?php if (($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')) { ?>
                                            <input type="button" name="forward_to_dc" onclick="return lm_Revert();" class="m-1 col-2 btn btn-danger btn-sm" id="lm_revert_btn" disabled value="Revert Back to LM">
                                        <?php } ?>

                                        <?php if($pending_officer == 'LM' && $from_office == 'CO'){
                                            echo "<span class='alert-success text-center'><strong>Case reverted back to LM.</strong></span>";
                                        } ?>

                                        <?php if(OFFLINE_ENABLE_BUTTON_CO_PROCESS != 0)
                                        {
                                            if($sdo_user_check == 'y')
                                            {
                                                if(($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')) {?>
                                                    <input type="button" name="forward_to_dc" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" disabled value="Forward">

                                                    <?php if(OFFLINE_ENABLE_BUTTON_CO_REJECT == 1) { ?>
                                                        <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="col-2 btn btn-warning m-1 btn-info-full btn-sm">Reject</button>
                                                    <?php } ?>

                                                <?php }
                                            }
                                            else
                                            { ?>
                                                <div class="row text-center">
                                                    <strong style="color:red">No SDO created for this location.</strong>
                                                </div>

                                                <?php
                                            }
                                        }
                                        if($pending_officer == 'DC' && $from_office == 'CO'){
                                            echo "<span class='alert-success text-center'><strong>Case forwarded to DC.</strong></span>";
                                        }
                                        ?>

                                    </div>
                                    <br>
                                </form>

                            </div>
                        </div>
                    </div>

                    <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                            <button type="button" class="btn btn-default prev-step">
                                <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary next-step">
                                <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                            </button>
                        </li>
                    </ul>
                </div>


                <!-- Remarks -->
                <div class="tab-pane" role="tabpanel" id="step3">

                    <div class="reza-card ">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                            </h5>

                            <?php include(APPPATH."views/OfflineSettlement/include/remarks_details.php"); ?>

                        </div>
                    </div>

                    <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                            <button type="button" class="btn btn-default prev-step">
                                <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary next-step">
                                <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- History -->
                <div class="tab-pane" role="tabpanel" id="step4">
                    <div class="reza-card ">
                        <div class="reza-body">
                            <h5 class="reza-title"  style="margin-top: 15px">
                                <i class="fa fa-history" aria-hidden="true"></i> Application History
                            </h5>

                            <?php include(APPPATH."views/OfflineSettlement/include/history_details.php"); ?>

                        </div>
                    </div>

                    <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                            <button type="button" class="btn btn-default prev-step">
                                <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-primary next-step">
                                <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Premium -->
                <?php if(!empty($premium_data)) : ?>
                    <div class="tab-pane" role="tabpanel" id="step5">
                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title"  style="margin-top: 15px">
                                    <i class="fa fa-money" aria-hidden="true"></i> Premium Calculation
                                </h5>

                                <?php include(APPPATH."views/OfflineSettlement/include/premium_details.php"); ?>

                            </div>
                        </div>

                        <ul class="list-inline pull-right" style="margin-top: 20px">
                            <li>
                                <button type="button" class="btn btn-default prev-step">
                                    <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                                </button>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
</div>


<!-- Modal forward application -->
<div class="modal" role="dialog" id="reportSubmitApplicationModal" style="z-index: 999999999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to Forward this application to ADC/SDO </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="reportSubmitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="reportSubmitApplicationModalYes">Yes, Forward</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Revert application -->
<div class="modal" role="dialog" id="revertApplicationModal" style="z-index: 999999999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to Revert this application to LM </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="revertApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="revertApplicationModalYes">Yes, Revert</button>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }

    function lm_Revert()
    {
        let remark_co = document.forms["co_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text").val();

        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }
        else if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();
        }
    }

    function dc_forward()
    {
        let remark_co = document.forms["co_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text").val();

        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }else if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();
        }
    }

    $(document).ready(function()
    {
        $("#reverttolm").click(function() {
            $("#lm_revert_btn").removeAttr("disabled");
            $("#frwrd_dc_btn").attr("disabled", true);
        });

        $("#frwrdtodc").click(function() {
            $("#frwrd_dc_btn").removeAttr("disabled");
            $("#lm_revert_btn").attr("disabled", true);
        });
    });


    function autoRemark()
    {
        var remark_val = $.trim($('#remark_co').val());
        var case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no': case_no,
        };

        if(remark_val == 1)
        {

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            $.ajax({
                url: baseurl+'OfflineSettlementCommonController/checkRuralUrban',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                    if(arr.responseType == 0){
                        showErrorMessage(arr.msg);
                    }else{
                        //append auto remark in the text area
                        const areaDeatils = [];
                        for(i=0; i<arr.area.length; i++)
                        {
                            var areaData = " "+arr.area[i].s_dag_area_b +"B "+ arr.area[i].s_dag_area_k +"k "+ arr.area[i].s_dag_area_lc +"L covered by Dag no " +arr.area[i].dag_no;
                            areaDeatils.push(areaData);
                        }

                        var finalArea    = areaDeatils.toString();
                        var circleName   = arr.circleName;
                        var villageName  = arr.villageName;
                        var mouzaName    = arr.mouzaName;
                        var khasmaxrural = "<?=OFFLINE_KHAS_RURAL_MAX_MESSAGE?>";

                        if(arr.isUrban == 'Y'){
                            $('#remark_co_text').val("Perused LM report.  Checked all the documents submitted by the applicant and are found in order. Land is in "+$('#prem_area').val()+". \n\nThe applicant is found to be indigenous landless person occupying land by way of constructing residential structure like "+$('#prem_landtype').val()+" measuring "+ finalArea +" of revenue village "+ villageName +" of mouza "+ mouzaName +" under "+ circleName +" Revenue circle and it can be settled with the applicant as per para 14.2/14.4 of Land Policy, 2019 and Notification No RDM-12011(17)/5/2022-LR-REV-R&D., Dated 11-Nov-2022; issued by Revenue and Disaster Management Department, Assam after due realization of premium. \n\nForwarded for perusal and consideration.");
                        }
                        else if(arr.isUrban == 'N')
                        {
                            $('#remark_co_text').val("Perused LM report. Checked all the documents submitted by the applicant and are found in order. Land is in rural area, outside roadside, riverside reservation and not reserved land. The land is not within tribal belt & block/ within tribal belt & block and the applicant is eligible to get settlement, as per provision. The applicant is found to be indigenous landless person/cultivator having less than "+khasmaxrural+" land. Land measuring "+ finalArea +" of revenue village "+ villageName +" of mouza "+ mouzaName +" under "+ circleName +" Revenue Circle occupying by way of cultivation/homestead purpose or both may be settled with the applicant as per Notification No RDM-12011(17)/5/2022-LR-REV-R&D., Dated 11-Nov-2022; issued by Revenue and Disaster Management Department, Assam after due realization of premium.\n\nForwarded for perusal and consideration.");
                        }
                    }
                }
            });
        }
        if(remark_val != 1)
        {
            $('#remark_co_text').val('');
        }

    }


    function rejectSubAlert()
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to Reject this case?',
            html: 'You wont be able to undo this once done',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject it',
            cancelButtonText: 'No, Cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

        var case_no = $('#case_no').val();
        showNewDirectRejectModalMb2(''+case_no+'','<?php echo OFFLINE_KHAS_LAND_ID ?>');

        // $('#co_rejection_agree').val('co_rejection_agree');
        // $('#co_form_sub').submit();

    }
    })
    }




    // application Forward confirmation
    $(document).on('click','#frwrd_dc_btn',function ()
    {
        $('#reportSubmitApplicationModal').modal('show');
    });

    $(document).on('click','#reportSubmitApplicationModalNo',function ()
    {
        $('#reportSubmitApplicationModal').modal('hide');
    });

    // application Forward
    $(document).on('click','#reportSubmitApplicationModalYes',function ()
    {

        document.getElementById("coProcess").setAttribute('value','Forward');
        $('#co_form_sub').submit();
        $('#reportSubmitApplicationModal').modal('hide');
    });




    // application revert confirmation
    $(document).on('click','#lm_revert_btn',function ()
    {
        $('#revertApplicationModal').modal('show');
    });

    $(document).on('click','#revertApplicationModalNo',function ()
    {
        $('#revertApplicationModal').modal('hide');
    });

    // application Revert to LM
    $(document).on('click','#revertApplicationModalYes',function ()
    {
        document.getElementById("coProcess").setAttribute('value','Revert');
        $('#co_form_sub').submit();
        $('#revertApplicationModal').modal('hide');
    });




</script>



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

<style>
    .is-invalid:focus{
        border: 1px solid red !important;
    }
    .lm_invalid{
        border: 1px solid red !important;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }
    .enc-area-color{
        background: #FFFAEC!important;
    }
    .settlement-area-color{
        background: #EAFFEA!important;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
    /* modal css */
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 70%;
    }
    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        /* box-shadow: none !important; */
    }
    .tab-content .card:active{
        /* left: 0;
   right: 0;
   top: 0;
   bottom: 0; */
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
        padding: 5px;
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
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #5bc0de;
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
        <a href="<?= base_url()?>index.php/OfflineSettlementLMController/getRevertedApplicationListLM" style="text-decoration: none">
            All Reverted Offline Application /
        </a>
        View

        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
        </a>

        <?php if($this->session->flashdata('success')) { ?>
            <br>
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


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                    <li role="presentation" class="active">
                        <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1" >
                            <span class="round-tab"><strong>Application</strong></span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="test" href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2" >
                            <span class="round-tab"><strong>Lot Mondal</strong></span>
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
                <div class="tab-pane" role="tabpanel" id="step2">
                    <div class="reza-card">
                        <div class="reza-body">
                            <h5  class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
                            </h5>

                            <?php include(APPPATH."views/OfflineSettlement/include/reverted_lm_report.php"); ?>

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

                                <?php include(APPPATH."views/OfflineSettlement/include/premium_details_revert.php"); ?>

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
    </div>

</div>







<!-- Masud's CSS-->
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
        Relinquishment /
        <a href="<?= base_url()?>index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment">
            Process
        </a>
        /
        <a href="<?= base_url()?>index.php/RelinquishmentCoController/getAllPendingRelinquishmentCasesCo">
            Pending Application
        </a>
        /  View
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


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

        <div class="wizard">


            <div class="tab-content">

                <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                    <?php echo $this->lang->line('relinquishmentTitle')?> (
                    <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$case_no?></span> )
                </h5>

                <!-- process -->
                <div class="tab-pane active" role="tabpanel" id="step3">

                    <?php
                    $pending_officer = $basic->pending_officer;
                    $from_office     = $basic->from_office;
                    $enAppNo         = $this->utilityclass->encryptJwtCase($basic->case_no);
                    ?>


                    <div class="reza-card ">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate Notice
                            </h5>
                            <form id="myForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url()?>index.php/RelinquishmentDcController/saveRelinquishmentHearingNotice">
                                <input type="hidden" id="en_case_no" name="en_case_no" value="<?= $enAppNo ?>">
                                <input type="hidden" id="notice_generated_date" name="notice_generated_date" value="<?= $hearing_date?>">
                                <input type="hidden" name="is_generated" value="<?=$is_generated?>">
                                <input type="hidden" name="case_no" value="<?=$case_no?>">
                                <input type="hidden" name="remark_co_text" value="<?=$remark_co_text?>">
                                <input type="hidden" name="remark_co" value="<?=$remark_co?>">
                                <input type="hidden" name="hearing_date" value="<?=$hearing_date?>">
                                <input type="hidden" name="district" value="<?=$this->utilityclass->getDistrictName($basic->dist_code)?>">
                                <input type="hidden" name="sub_division" value="<?=$this->utilityclass->getSubDivName($basic->dist_code,$basic->subdiv_code)?>">
                                <input type="hidden" name="circle" value="<?=$this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code)?>">
                                <input type="hidden" name="lot_no" value="<?=$this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?>">
                                <input type="hidden" name="mouza" value="<?=$this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?>">
                                <input type="hidden" name="village" value="<?=$this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?>">
                                <?php foreach($get_buyers as $app):  ?>
                                    <input type="hidden" name="petitioner_name" value="<?=$app->pdar_name?>">
                                    <input type="hidden" name="g_name" value="<?=$app->pdar_guardian?>">
                                    <input type="hidden" name="dag_name" value="<?=$app->dag_no?>">
                                <?php endforeach;?>
                                <input type="hidden" name="case_no" value="<?=$case_no?>">
                                <input type="hidden" name="remark" value="<?=$remark?>">
                                <input type="hidden" name="district" value="<?=$this->utilityclass->getDistrictName($basic->dist_code)?>">
                                <input type="hidden" name="sub_division" value="<?=$this->utilityclass->getSubDivName($basic->dist_code,$basic->subdiv_code)?>">
                                <input type="hidden" name="circle" value="<?=$this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code)?>">
                                <input type="hidden" name="lot_no" value="<?=$this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?>">
                                <input type="hidden" name="mouza" value="<?=$this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?>">
                                <input type="hidden" name="village" value="<?=$this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?>">




                                <div id="printableArea">
                                    <div class="container bg-white shadow pb-3" id="print_direct">
                                        <div class="row mt-5 text-center">
                                            <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                                                <u>আবেদনকাৰী আৰু পট্টাদাৰৰ শুনানিৰ বাবে জাননী</u>
                                                <br> <span style="font-size: 14px; font-weight:bold;"> জাননী নং- <b><?=$case_no?></span></b>
                                            </div>
                                        </div>

                                        <div class="row mt-4 px-5">
                                            <div class="col-2">
                                                <?php if(isset($get_chitha_owners)){ ?>
                                                    প্ৰতি-
                                                <?php } ?>
                                            </div>
                                            <div class="col-8">
                                            </div>

                                            <div class="col-2">
                                                তাৰিখ- <b><?=date('Y-m-d')?></b>
                                            </div>
                                        </div>

                                        <div class="row mt-4 px-5">
                                            <div class="col-1">

                                            </div>
                                            <div class="col-11">
                                                <b>
                                                    <?php if(isset($get_chitha_owners))
                                                    {
                                                        echo $get_chitha_owners->owners;
                                                    }?>
                                                </b>
                                            </div>
                                        </div>



                                        <div class="row mt-4">
                                            <div class="col-12 text-justify p-5">
                                                ইয়াৰদ্বাৰা আপোনালোকক জনোৱা হয় যে,
                                                <b>
                                                    <?php
                                                    $position = 0;
                                                    $length = count($get_buyers);
                                                    foreach($get_buyers as $app){
                                                        if($position == $length - 1){
                                                            echo $app->pdar_name;
                                                        }elseif($position == $length - 2){
                                                            echo $app->pdar_name.' আৰু ';
                                                        }else{
                                                            echo $app->pdar_name.', ';
                                                        }
                                                        $position++;
                                                    }
                                                    ?></b>
                                                য়ে,

                                                <b><?=$this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code)?></b>
                                                মৌজাৰ,
                                                <b><?=$this->utilityclass->getLotName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no)?></b> নম্বৰ লাটৰ, <b><?=$this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code)?></b>
                                                গাঁৱৰ,
                                                <?php
                                                $dag_position = 0;
                                                $dag_length = count($get_dag_details);

                                                foreach($get_dag_details as $dags){
                                                    if($dag_position == $dag_length - 1){
                                                        ?>
                                                        <b><?=$dags->patta_no?></b>
                                                        নং একচনা পট্টাৰ, <b><?=$dags->dag_no?></b>
                                                        দাগৰ, মুঠ <b><?=$dags->s_dag_area_b;?></b>
                                                        বিঘা <b><?=$dags->s_dag_area_k;?></b>
                                                        কঠা <b><?=$dags->s_dag_area_lc;?></b>
                                                        লেচা
                                                        <?php
                                                    }elseif($dag_position == ($dag_length - 2)){
                                                        ?>
                                                        <b><?=$dags->patta_no?></b>
                                                        নং পট্টাৰ, <b><?=$dags->dag_no?></b>
                                                        দাগৰ, মুঠ <b><?=$dags->s_dag_area_b;?></b>
                                                        বিঘা <b><?=$dags->s_dag_area_k;?></b>
                                                        কঠা <b><?=$dags->s_dag_area_lc;?></b>
                                                        লেচা আৰু
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <b><?=$dags->patta_no?></b>
                                                        নং পট্টাৰ, <b><?=$dags->dag_no?></b>
                                                        দাগৰ, মুঠ <b><?=$dags->s_dag_area_b;?></b>
                                                        বিঘা <b><?=$dags->s_dag_area_k;?></b>
                                                        কঠা <b><?=$dags->s_dag_area_lc;?></b>
                                                        লেচা,
                                                        <?php
                                                    }
                                                    $dag_position++;
                                                }
                                                ?>
                                                ভূমিৰ হস্তান্তৰ মমে চৰকাৰীকৰণ ক্ৰমে পট্টনৰ বাবে আৱেদন দাখিল কৰিছে। এই ক্ষেত্ৰত তদন্ত মৰ্মে উক্ত ভূমি হস্তান্তৰ হোৱা বুলি প্ৰতিবেদন পোৱা গৈছে। তেনেক্ষেত্ৰত বন্দোবস্তীৰ নিয়মাৱলীৰ বিধি ১(২)(গ) মৰ্মে উক্ত মাটি কিয় চৰকাৰীকৰণ কৰা নহ’ব, তাৰ শুনানীৰ বাবে <b><?=$notice_hearing_date?></b> তাৰিখ ধাৰ্য কৰা হৈছে।
                                                <br><br>
                                                গতিকে আপোনালোকক যাৱতীয় নথিপত্ৰসহ উক্ত দিনত চক্ৰ বিষয়াৰ কাৰ্যালয়ত উপস্থিত থাকিবলৈ অনুৰোধ জনোৱা হ'ল।
                                            </div>
                                        </div>
                                        <div class="row mt-5 justify-content-end mb-5">
                                            <div class="col-5 text-center">
                                                <b><?=$this->utilityclass->dcname($basic->dist_code,$this->session->userdata('user_code'));?></b><br>
                                                জিলা আয়ুক্ত <br>
                                                <?=$this->utilityclass->getDistrictName($basic->dist_code)?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>
                                <div class="container">
                                    <div class="row mt-4 mb-5 justify-content-center text-center">
                                        <div class="col-6">

                                            <button type="button" class="rezaButt buttInfo" id="applicationSubmit">
                                                <i class="fa fa-check-square-o"></i> Save Notice
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </form>


                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>

<!-- Modal submit application -->
<div class="modal" role="dialog" id="submitApplicationModal" style="z-index: 9999999999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>
                    You want to Save Notice
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="submitApplicationModalYes">
                    Yes, Save
                </button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }




    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }


    // application submit confirmation
    $(document).on('click','#applicationSubmit',function ()
    {
        $('#submitApplicationModal').modal('show');
    });

    $(document).on('click','#submitApplicationModalNo',function ()
    {
        $('#submitApplicationModal').modal('hide');
    });

    // application submit
    $(document).on('click','#submitApplicationModalYes',function ()
    {
        var appNo      = $('#en_case_no').val();
        var htmlString =$( "#printableArea" ).html();
        var htmlString = b64EncodeUnicode(htmlString);
        $( "#htmlstring_text" ).text( htmlString );

        if(appNo == '' || appNo == null)
        {
            $('#submitApplicationModal').modal('hide');
            showErrorMessage('Some Required data is missing !');
        }
        if(htmlString == '' || htmlString == null)
        {
            $('#submitApplicationModal').modal('hide');
            showErrorMessage('Some Required data is missing !');
        }



        $('#myForm').submit();
        $('#submitApplicationModal').modal('hide');
    });


</script>

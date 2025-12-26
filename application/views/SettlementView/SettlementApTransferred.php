<?php //var_dump($this->utilityclass->getZonalValue($area_details['0']->dist_code,$basic['uuid'],$area_details['0']->dag_no));die;?>
<style>
    .lm_invalid{
        border: 1px solid red !important;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        /* box-shadow: none !important; */
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

    div.f-party-alternate > div:nth-of-type(odd) {
        background: #f2fdff;
    }
    div.co-report > form:nth-of-type(odd) {
        background: #f2fdff;
        padding-top: 3px;
        padding-bottom: 5px;
    }
</style>
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
</style>

<script src="<?php echo base_url();?>js/jAlert-v3.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jAlert-v3.css" />

<script>

    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
        else{
            $('#myTab a[href="#step1"]').tab('show');
        }

        $('.nav-tabs > li a[title]').tooltip();
        $(".next-step").click(function (e) {

            nr_bigha = parseFloat($("#nr_bigha").val());
            nr_katha = parseFloat($("#nr_katha").val());
            nr_lessa = parseFloat($("#nr_lessa").val());
            nr_ganda = parseFloat($("#nr_ganda").val());

            s_dag_area_b = parseFloat($("#s_dag_area_b").val());
            s_dag_area_k = parseFloat($("#s_dag_area_k").val());
            s_dag_area_lc = parseFloat($("#s_dag_area_lc").val());
            s_dag_area_g = parseFloat($("#s_dag_area_g").val());

            if($('#barak_valley').val() == 0){ // other than barak valley

                tot_nr_area = (nr_bigha*100)+(nr_katha*20)+nr_lessa;
                tot_settlement_area = (s_dag_area_b*100)+(s_dag_area_k*20)+s_dag_area_lc;

                if(tot_nr_area < tot_settlement_area) {
                    theme = "blue";
                    $.jAlert({
                        'title': 'Error: Invalid Data Entry',
                        'content': 'Area of settlement can not be more than Area for NR!!!',
                        'theme': theme,
                        'backgroundColor': 'white',
                        'btns': [
                            {'text':'OK', 'theme':theme}
                        ]
                    });
                    $('#nr_bigha').focus();
                    return false;
                }
            }

            if($('#barak_valley').val() == 1){ // for barak valley

                tot_nr_area = (nr_bigha * 6400) + (nr_katha * 320) + (nr_lessa * 20) + nr_ganda;
                tot_settlement_area = (s_dag_area_b * 6400) + (s_dag_area_k * 320) + (s_dag_area_lc * 20) + s_dag_area_g;

                if(tot_nr_area < tot_settlement_area) {
                    theme = "blue";
                    $.jAlert({
                        'title': 'Error: Invalid Data Entry',
                        'content': 'Area of settlement can not be more than Area for NR!!!',
                        'theme': theme,
                        'backgroundColor': 'white',
                        'btns': [
                            {'text':'OK', 'theme':theme}
                        ]
                    });
                    $('#nr_bigha').focus();
                    return false;
                }
            }

            if ($('.inplace-along').val().length == 0)
            {
                theme = "blue";
                $.jAlert({
                    'title': 'Error: Field Required',
                    'content': 'Inplace/Along with should not be empty!!!',
                    'theme': theme,
                    'backgroundColor': 'white',
                    'btns': [
                        {'text':'OK', 'theme':theme}
                    ]
                });
                $('.inplace-along').focus();
                return false;
            }


            <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))){?>
            var total_area = 0;
            var mbigha = parseFloat($("#s_dag_area_b").val());
            var mkatha = parseFloat($("#s_dag_area_k").val());
            var mlessa = parseFloat($("#s_dag_area_lc").val());
            var mganda = parseFloat($("#s_dag_area_g").val());
            var total_area = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
            <?php if($dags[0]->is_urban=='Y'){?>
            if(total_area>30){
                theme = "blue";
                $.jAlert({
                    'title': 'Error: Field Required',
                    'content': 'Max Urban area can not exceed 1 katha 10 lessa!!!',
                    'theme': theme,
                    'backgroundColor': 'white',
                    'btns': [
                        {'text':'OK', 'theme':theme}
                    ]
                });
                $('#s_dag_area_lc').focus();
                return false;
            }
            <?php } ?>

            <?php } else { ?>
            var total_area = 0;
            var mbigha = parseFloat($("#s_dag_area_b").val());
            var mkatha = parseFloat($("#s_dag_area_k").val());
            var mlessa = parseFloat($("#s_dag_area_lc").val());
            var total_area = ((mbigha * 100) + (mkatha * 20) + mlessa);
            <?php if($dags[0]->is_urban=='Y'){?>
            if(total_area>30){
                theme = "blue";
                $.jAlert({
                    'title': 'Error: Field Required',
                    'content': 'Max Urban area can not exceed 1 katha 10 lessa!!!',
                    'theme': theme,
                    'backgroundColor': 'white',
                    'btns': [
                        {'text':'OK', 'theme':theme}
                    ]
                });
                $('#s_dag_area_lc').focus();
                return false;
            }
            <?php } ?>



            <?php } ?>

            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

    });

</script>


<div class="container">
    <div class="row">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>

        <?php
        if($basic['old_case_no'] != null){
        ?>
        <div class="row text-right">
        <a href="<?=base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $basic['old_case_no'])?>" target="Old Application" class="text-danger">
            <span class="round-tab">
            <strong>View Old Application</strong>
            </span>
        </a>
        </div>
  
        <?php }?>

        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" role="tablist">
                        <li role="presentation" class="active">
                            <a
                                    class="test"
                                    href="#step1"
                                    data-toggle="tab"
                                    aria-controls="step1"
                                    role="tab"
                                    title="Step 1"
                            >
                <span class="round-tab">
                  <strong>Application</strong>
                </span>
                            </a>
                        </li>

                        <li role="presentation" class="">
                            <a
                                    href="#step2"
                                    data-toggle="tab"
                                    aria-controls="step2"
                                    role="tab"
                                    title="Step 2"
                            >
                <span class="round-tab">
                  <strong>Lot Mondal</strong>
                </span>
                            </a>
                        </li>

                    </ul>
                </div>
                

                <form role="form" class="lmForm" method="post" action="<?php echo base_url()?>index.php/SettlementAp/settlementApplication/<?=$review_flag?>?app=<?=$_GET['app']?>" enctype="multipart/form-data">
                    <?php 
                        // $application_no = $this->utilityclass->decryptJwtCase($_GET['app']);
                        $application_no = $_GET['app'];
                    ?>    
                    <input type="hidden" name="service_code" value="<?=$basic["service_code"]?>">
                    <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
                    <input type="hidden" name="application_no" value="<?=$application_no?>">
                    <input type="hidden" name="ref_no" value="<?=$basic["ref_no"]?>">
                    <input type="hidden" name="lm_verification_date" id="lm_verification_date" value="<?=$geo_date ; ?>">
                    <input type="hidden" name="uuid" id="uuid" value="<?=$basic['uuid']?>">
                    <input type="hidden" name="case_no" id="case_no" value="<?=$basic['case_no']?>">
                    <?php
                        $sl_count = 1;
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                                Registration of  Settlement AP Transfer (
                                <span class="bg-warning"><?=$application_no?></span> )
                            </h5>

                            <?php
                                include(APPPATH."views/SettlementView/include/applicationApView.php");
                            ?>

                            <ul class="list-inline pull-right" style="margin-top: 20px">
                                <li>
                                    <button type="button" class="btn btn-primary next-step">
                                        <i class="fa fa-arrow-circle-right"> </i>  Next
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- LM reporting starts here -->

                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                                Registration of  Settlement AP Transfer (
                                <span class="bg-warning">
                                <?=$application_no?>
                                </span> )
                            </h5>

                            <div class="reza-card">
                                <div class="reza-body">
                                    <?=$dagFlagCheckChitha?>
                                    <h5  class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
                                    </h5>
                                    <div class="tableCard">
                                    <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong>
                                                    Whether applicant eligible for NR or NR with Settlement ?</span>
                                                <?=form_error('is_nr_settlement')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_nr_settlement')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            onclick="apPP();"
                                                            name="is_nr_settlement"
                                                            value="NR with Settlement"
                                                        <?php if(set_value('is_nr_settlement') == 'NR with Settlement'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">NR with Settlement</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            onclick="apPP();"
                                                            class="form-check-input <?php if(form_error('is_nr_settlement')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="is_nr_settlement"
                                                            value="NR"
                                                        <?php if(set_value('is_nr_settlement') == 'NR'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">NR</label>
                                                </div>
                                                

                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_nr_settlement')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            onclick="apPP();"
                                                            name="is_nr_settlement"
                                                            value="AP to PP case"
                                                        <?php if(set_value('is_nr_settlement') == 'AP to PP case'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">AP to PP case</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                                                <?=form_error('chitha_verified')?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="chitha_verified"
                                                            id="chiitha_verified1"
                                                            value="YES"
                                                        <?php if(set_value('chitha_verified') == 'YES'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="chitha_verified"
                                                            id="chiitha_verified2"
                                                            value="NO"
                                                        <?php if(set_value('chitha_verified') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php

                                                foreach ($aadhar as $ddg) {
                                                    ?>
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $ddg->dag_no . '&m=' . $app['mouza_pargona_code'] . '&l=' . $app['lot_no'] . '&v=' . $app['vill_townprt_code'] . '&p=' . $ddg->patta_type_code . '&dist=' . $app['dist_code'] . '&cir=' . $app['cir_code'] . '&sub_div=' . $app['subdiv_code'] ?>">
                                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                                                    </a>
                                                    <br>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span>
                                                <?=form_error('bhumiputra_confirmation_lm')?>
                                                <br>
                                                <?php
                                                if(trim($basic['bhumiputra_confirmation']) == 'YES'){
                                                    ?>
                                                    <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>
                                                <?php }else{ ?>
                                                    <label for="" class="alert-warning">Certificate Not Available!</b></label>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="bhumiputra_confirmation_lm"
                                                            id="bhumiputra_confirmation1"
                                                            value="YES"
                                                        <?php if(set_value('bhumiputra_confirmation_lm') == 'YES'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="bhumiputra_confirmation_lm"
                                                            id="bhumiputra_confirmation2"
                                                            value="NO"
                                                        <?php if(set_value('bhumiputra_confirmation_lm') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                if(trim($basic['bhumiputra_confirmation']) == 'YES'){
                                                    ?>
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                                                    if(trim($basic['bhumiputra_certificate_type']) == 'CERT'){
                                                        echo "cer_number=".$basic['bhumiputra_certificate_no'];
                                                    }else{
                                                        echo "ack_number=".$basic['bhumiputra_certificate_no'];
                                                    }?>" target="BhumiPutra">
                                                        <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Possession verified?</span>
                                                <?=form_error('possession_verified')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('possession_verified')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="possession_verified"
                                                            id="possession_verified1"
                                                            value="<?=YES ?>"
                                                        <?php if(set_value('possession_verified') == YES){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('possession_verified')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="possession_verified"
                                                            id="possession_verified2"
                                                            value="<?=NO ?>"
                                                        <?php if(set_value('possession_verified') == NO){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                      <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                          Tribal Belt/ Block.</span>
                                                <?=form_error('is_tribal_belt')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">

                                                    <input
                                                            class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="is_tribal_belt"
                                                            id="whether_tribal1"
                                                            value="YES"
                                                        <?php
                                                        if(isset($err_return)){
                                                            if(set_value('is_tribal_belt') == 'YES'){
                                                                echo "checked";
                                                            }
                                                        }
                                                        else {

                                                            $app['tribal_belt'] != null ? 'checked':'';
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="is_tribal_belt"
                                                            id="whether_tribal2"
                                                            value="NO"
                                                        <?php
                                                        if(isset($err_return)){
                                                            if(set_value('is_tribal_belt') == 'NO'){
                                                                echo "checked";
                                                            }
                                                        }
                                                        else{
                                                            $app['tribal_belt'] != null ? 'checked':'';
                                                        }
                                                        ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide">
                                            <div class="col-md-6 text-justify">
                                    <span><strong><?=$sl_count++?>.</strong>
                                        Does applicant falls under protected category?</span>
                                                <?=form_error('protected_class_lm')?>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select name="protected_class_lm" id="protected_class_lm" class="form-control
                                        <?php if(form_error('protected_class_lm')){echo 'lm_invalid';}?>" required>
                                                    <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                                                        <option value="<?php echo $class->CODE ?>"
                                                            <?php if(set_value('protected_class_lm') == $class->CODE){ echo "selected";} ?>>
                                                            <?php echo $class->NAME ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ?
                                    </span>
                                                <?=form_error('landslide')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('landslide')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="landslide"
                                                            id="landslide"
                                                            value=<?=YES ?>
                                                            <?php if(set_value('landslide') == YES){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('landslide')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="landslide"
                                                            id="landslide2"
                                                            value=<?=NO ?>
                                                            <?php if(set_value('landslide') == NO){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong> Whether the land falls under erosion ?
                                    </span>
                                                <?=form_error('erosion')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('erosion')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="erosion"
                                                            id="landslide"
                                                            value=<?=YES?>
                                                            <?php if(set_value('erosion') == YES){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('erosion')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="erosion"
                                                            id="landslide2"
                                                            value=<?=NO?>
                                                            <?php if(set_value('erosion') == NO){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Nature of possession</span>
                                                <?=form_error('nature_possession')?>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select
                                                        name="nature_possession"
                                                        id="nature_possession"
                                                        class="form-control <?php if(form_error('nature_possession')){echo 'lm_invalid';}?>"
                                                >
                                                    <option value="Agricultural" <?php if(isset($err_return)){ if (set_value('nature_possession') == 'Agricultural') { echo "selected"; }}?>>Agricultural</option>
                                                    <option value="Residential" <?php if(isset($err_return)){ if (set_value('nature_possession') == 'Residential') { echo "selected"; }}?>>Residential</option>
                                                    <option value="Others" <?php if(isset($err_return)){ if (set_value('nature_possession') == 'Others') { echo "selected"; }}?>>Others</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                        <span>
                                            <strong><?=$sl_count++?>.</strong>
                                             Whether proposed land is under litigation?
                                        </span>
                                                <?=form_error('litigation')?>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('litigation')){echo 'lm_invalid';}?>"
                                                           type="radio"
                                                           name="litigation"
                                                           id="landed_property1"
                                                           value="YES"
                                                        <?php if(set_value('litigation') == 'YES'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('litigation')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="litigation"
                                                            id="landed_property2"
                                                            value="NO"
                                                        <?php if(set_value('litigation') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide">
                                            <div class="col-md-6 text-justify">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong> Category of the proposed land?
                                    </span>

                                                <?=form_error('land_falls')?>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select name="land_falls" id="land_falls" class="form-control <?php if(form_error('land_falls')){echo 'lm_invalid';}?>">
                                                    <option value="">Select...</option>
                                                    <?php foreach(json_decode(LB_NATURE_OF_RESERVATION) as $landCode): ?>
                                                        <option value="<?php echo $landCode->CODE ?>"

                                                            <?php if(set_value('land_falls') == $landCode->CODE){ echo "selected";} ?>>

                                                            <?php echo $landCode->NAME ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
                                        15 KM radius from the periphery of GMC or within 5 KM periphery of other
                                        town or within 3 KM periphery of Revenue town.
                                    </span>
                                                <?=form_error('falls_und_gmc')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('falls_und_gmc')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="falls_und_gmc"
                                                            id="falls_und_gmc"
                                                            value="YES"
                                                            onclick="forcedUrban('YES');"
                                                        <?php if(set_value('falls_und_gmc') == 'YES'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('falls_und_gmc')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="falls_und_gmc"
                                                            id="falls_und_gmc"
                                                            onclick="forcedUrban('NO');"
                                                            value="NO"
                                                        <?php if(set_value('falls_und_gmc') == 'NO'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <div id="forcedurban" style="display:none">
                                                    <div style="padding: 15px; background-color: #f44336; color: white;">
                                                        <strong>If you select Yes then this case is considered as Urban case.</strong>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                            /riverside reservation (if any, along with provision kept for road/drain
                                            wherever necessary)</span>
                                                <?=form_error('roadside_comment_check')?>
                                                <!-- this only to display the error message in area validation -->
                                                <span class="<?php if(form_error('roadsideMoreThanDagA')){echo 'lm_invalid';}?>"></span>
                                                <?=form_error('roadsideMoreThanDagA');?>

                                                <?php
                                                foreach($applicants as $dags){
                                                    echo form_error('reserved_bigha'.$dags->dag_no);
                                                    echo form_error('reserved_katha'.$dags->dag_no);
                                                    echo form_error('reserved_lessa'.$dags->dag_no);
                                                    echo form_error('reserved_ganda'.$dags->dag_no);
                                                    echo form_error('reserved_kranti'.$dags->dag_no);
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" onclick="roadSideReservYes();" class="form-check-input roadside_comment_check1 <?php if(form_error('roadside_comment_check')){echo 'lm_invalid';}?>" name="roadside_comment_check" id="roadside_comment_check1" value="YES" <?php if(set_value('roadside_comment_check') == 'YES'){ echo "checked";} ?>>
                                                    <label for="roadside">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio"  onclick="roadSideReservNo();" class="form-check-input roadside_comment_check2 <?php if(form_error('roadside_comment_check')){echo 'lm_invalid';}?>" name="roadside_comment_check" id="roadside_comment_check2" value="NO" <?php if(set_value('roadside_comment_check') == 'NO'){ echo "checked";} ?>>
                                                    <label for="roadside">No</label>
                                                </div>
                                                <div id="road_side_reservation_hide" class="road_side_reservation_hide" style="display: none;">
                                                    <?php foreach($dags_result as $dags){
                                                        ?>
                                                            <div class="form-group row mt-2">
                                                                <input type="hidden" value="<?=$dags->dag_no?>" class="form-control input-sm" name="reserved_dag_road<?=$dags->dag_no?>" id="reserved_dag_road">
                                                                <input type="hidden" value="<?=$dags->patta_no?>" class="form-control input-sm" name="reserved_patta_road<?=$dags->dag_no?>" id="reserved_patta_road">
                                                                <label for="area-reserved" class="mb-2"><b>Enter road side reserve area in Dag No: <?=$dags->dag_no?></b></label>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Bigha</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_bigha'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_bigha'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_bigha<?=$dags->dag_no?>" id="reserved_bigha">
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Katha</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_katha'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_katha'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_katha<?=$dags->dag_no?>" id="reserved_katha" >
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Lessa</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_lessa'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_lessa'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_lessa<?=$dags->dag_no?>" id="reserved_lessa" >
                                                                </div>
                                                            </div>
                                                            <?php if((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                                                <div class="form-group row mt-2">
                                                                    <div class="col-4">
                                                                        <span class="input-group-addon">Ganda</span>
                                                                        <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_ganda'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_ganda'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_ganda<?=$dags->dag_no?>" id="reserved_ganda">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <span class="input-group-addon">Kranti</span>
                                                                        <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_kranti'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_kranti'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_kranti<?=$dags->dag_no?>" id="reserved_kranti">
                                                                    </div>
                                                                </div>
                                                            <?php endif ;?>
                                                        <?php } ?>

                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label for="roadside">Reserved area remarks(if any)</label>
                                                            <textarea
                                                                    name="roadside_reservation"
                                                                    id="roadside_reservation"
                                                                    class="form-control"
                                                                    rows="2"
                                                            ><?php if(isset($err_return)){ echo set_value('roadside_reservation');}?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2 hide nrhide">
                                            <div class="col-md-6">
                                        <span><strong></strong>
                                            Whether applicant family has occupied any land in the state?</span>
                                                <?=form_error('family_comment_check')?>
                                                <!-- this only to display the error message in area validation -->
                                                <span class="<?php if(form_error('familyMoreThanDagA')){echo 'lm_invalid';}?>"></span>
                                                <?=form_error('familyMoreThanDagA');?>

                                                <?php

                                                foreach($applicants as $dags){
                                                    echo form_error('reserved_bigha_family'.$dags->dag_no);
                                                    echo form_error('reserved_katha_family'.$dags->dag_no);
                                                    echo form_error('reserved_lessa_family'.$dags->dag_no);
                                                    echo form_error('reserved_ganda_family'.$dags->dag_no);
                                                    echo form_error('reserved_kranti_family'.$dags->dag_no);
                                                }
                                                ?>



                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" onclick="familyReservYes();" class="form-check-input family_comment_check1 <?php if(form_error('family_comment_check')){echo 'lm_invalid';}?>" name="family_comment_check" id="family_comment_check1" value="<?=YES?>" <?php if(set_value('family_comment_check') == YES){ echo "checked";} ?>>
                                                    <label for="familyarea">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" checked  onclick="familyReservNo();" class="form-check-input family_comment_check2 <?php if(form_error('family_comment_check')){echo 'lm_invalid';}?>" name="family_comment_check" id="family_comment_check2" value="<?=NO?>" <?php if(set_value('family_comment_check') == NO){ echo "checked";} ?>>
                                                    <label for="familyarea">No</label>
                                                </div>
                                                <div id="family_reservation_hide" class="family_reservation_hide" style="display: none;">
                                                    <?php foreach($applicants as $dags){
                                                        if($dags->is_applicant==1){?>
                                                            <div class="form-group row mt-2">
                                                                <input type="hidden" value="<?=$dags->dag_no?>" class="form-control input-sm" name="reserved_dag_family<?=$dags->id?>" id="reserved_dag_family">
                                                                <input type="hidden" value="<?=$dags->patta_no?>" class="form-control input-sm" name="reserved_patta_family<?=$dags->id?>" id="reserved_patta_family<?=$dags->id?>">
                                                                <label for="area-reserved" class="mb-2"><b>Reserve family area(will deduct from applied area) in Dag No: <?=$dags->dag_no?></b></label>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Bigha</span>
                                                                    <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_bigha_family'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_bigha_family'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_bigha_family<?=$dags->dag_no?>" id="reserved_bigha_family">
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Katha</span>
                                                                    <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_katha_family'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_katha_family'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_katha_family<?=$dags->dag_no?>" id="reserved_katha_family" >
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Lessa</span>
                                                                    <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_lessa_family'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_lessa_family'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_lessa_family<?=$dags->dag_no?>" id="reserved_lessa_family" >
                                                                </div>
                                                            </div>
                                                            <?php if((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                                                <div class="form-group row mt-2">
                                                                    <div class="col-4">
                                                                        <span class="input-group-addon">Ganda</span>
                                                                        <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_ganda_family'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_ganda_family'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_ganda_family<?=$dags->dag_no?>" id="reserved_ganda_family">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <span class="input-group-addon">Kranti</span>
                                                                        <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_kranti_family'.$dags->dag_no);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_kranti_family'.$dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_kranti_family<?=$dags->dag_no?>" id="reserved_kranti_family" >
                                                                    </div>
                                                                </div>
                                                            <?php endif ;?>
                                                        <?php } }?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row bg-danger">
                                            <span><?=form_error('reserveAreaCheck')?></span>
                                        </div>

                                        <!-- <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong></strong> Zonal valuation/current market value
                                                of the proposed land and assessment of settlement premium as per standing
                                                Govt circular
                                            </span>
                                                <?=form_error('zonal_valuation')?>
                                            </div>
                                            <div class="col-md-6">
                                                <input
                                                        type="number"
                                                        name="zonal_valuation"
                                                        id="zonal_valuation222"
                                                        class="form-control <?php if(form_error('zonal_valuation')){echo 'lm_invalid';}?>"
                                                        value="<?php if(isset($err_return)){ echo set_value('zonal_valuation');}?>"
                                                />
                                            </div>
                                        </div> -->

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Whether applied land falls under Eksona /Gramdan  /Bhudan ?

                                            </span>
                                                <?=form_error('gramdan_bhudan')?>
                                            </div>
                                            <div class="col-md-6">

                                                <select name="gramdan_bhudan" id="gramdan_bhudan" class="form-control <?php if(form_error('gramdan_bhudan')){echo 'lm_invalid';}?>">
                                                    <option value="">Select...</option>
                                                    <?php
                                                    foreach(json_decode(GRAMDAN_BHUDAN) as $gb):
                                                        ?>
                                                        <option value="<?=$gb->CODE?>" <?php if(isset($err_return)){ if($gb->CODE == set_value('gramdan_bhudan')){ echo 'selected';}}?>>
                                                            <?=$gb->NAME;?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Is Eksona Land Transferred ?

                                            </span>
                                                <?=form_error('eksona_transfered')?>
                                            </div>
                                            <div class="col-md-6">

                                                <select name="eksona_transfered" id="eksona_transfered" class="form-control <?php if(form_error('eksona_transfered')){echo 'lm_invalid';}?>">
                                                    <option value="">Select...</option>
                                                    <?php
                                                    foreach(json_decode(EKSONA_TRANSFERRED) as $eksonat):
                                                        ?>
                                                        <option value="<?=$eksonat->CODE?>" <?php if(isset($err_return)){ if($eksonat->CODE == set_value('eksona_transfered')){ echo 'selected';}}?>>
                                                            <?=$eksonat->NAME;?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?php //var_dump($aadhar[0]->id); die;?>

                                        <div class="row p-2 nrhide">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Chitha copy of the proposed land</span>
                                                <?php echo form_error('chitha_copy'.$aadhar[0]->id); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="alert-warning">For Dag no. : <strong><?=$aadhar[0]->dag_no?></strong></span>
                                                <input type="hidden" name="dag_no_chitha<?=$aadhar[0]->id?>" value="<?=$aadhar[0]->dag_no?>">
                                                <input type="file" accept=".png, .jpg, .jpeg, .pdf" name="chitha_copy<?=$aadhar[0]->id?>" id="chitha_copy" class="form-control <?php if(form_error('chitha_copy'.$aadhar[0]->id)){echo 'lm_invalid';}?>" />
                                            </div>
                                        </div>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Copy of trace map of the proposed land
                                                clearly highlighting the propose land road/riverside reservation etc(if
                                                any)</span>
                                                <?php echo form_error('trace_map_copy'.$aadhar[0]->id); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="alert-warning">For Dag no. : <strong><?=$aadhar[0]->dag_no?></strong></span>
                                                <input type="hidden" name="dag_no_doc<?=$aadhar[0]->id?>" value="<?=$aadhar[0]->dag_no?>">
                                                <input
                                                        type="file"
                                                        name="trace_map_copy<?=$aadhar[0]->id?>"
                                                        id="trace_map_copy"
                                                        accept=".png, .jpg, .jpeg, .pdf"
                                                        class="form-control <?php if(form_error('trace_map_copy'.$aadhar[0]->id)){echo 'lm_invalid';}?>"
                                                /><br>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Field visit report & geo tagged
                                                    photograph of the land</span>
                                                <?=form_error('field_report')?>
                                                <span class="<?php if(form_error('geo_tag_photo')){echo 'lm_invalid';}?>"></span>
                                                <?php
                                                if(isset($geo_tag_doc)){
                                                    echo form_error('geo_tag_photo');
                                                }else{
                                                    echo form_error('geo_tag_photo');
                                                }?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <label for="inputEmail4">Field report</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input
                                                                class="form-control <?php if(form_error('field_report')){echo 'lm_invalid';}?>"
                                                                type="file"
                                                                name="field_report"
                                                                id="field_report"
                                                                accept=".png, .jpg, .jpeg, .pdf"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="row mt-2 nrhide">
                                                    <div class="col-4">
                                                        <label for="inputEmail4">Geo tagged photo</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <?php
                                                        if(isset($geo_tag_doc_empty)){
                                                            echo $geo_tag_doc_empty;
                                                        }
                                                        if(isset($geo_tag_doc)){
                                                            foreach($geo_tag_doc as $d):
                                                                ?>
                                                                <span class="alert-warning">For Dag no : <strong><?=$d->dag_no?></strong></span><br>
                                                                <a target='download' href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$d->id?>"><i class="fa fa-paperclip mb-2"></i> <?=$d->file_name;?></a><br>

                                                            <?php endforeach;}?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="nrhide">
                                        <!---// Add additional land detail modal --->
                                        <?php include 'application/views/SettlementView/include/settlementPropertyModal.php'; ?>
                                        <!---// Add additional land detail modal --->

                                        <?php if(ENABLE_CHECK_LAND != 0) {?>
                                            <!---// Land exist check modal --->
                                            <?php

                                                $identity_type=$aadhar[0]->identity_type;
                                                $identity_ref_no=$aadhar[0]->identity_ref_no;
                                               
                                            ?>
                                            <div style="margin: 10px">
                                                <?php include(APPPATH."views/SettlementView/include/landCheck.php"); ?>
                                            </div>

                                            <!---// Land exist check modal end --->
                                        <?php } ?>
                                        </div>


                                        <div class="row p-2 nrhide">
                                            <div class="col-md-6">
                                                <label for="">
                                                    <strong><?=$sl_count++?>.</strong>
                                                    Landmark
                                                </label>
                                                <?=form_error('landmark_east')?>
                                                <?=form_error('landmark_west')?>
                                                <?=form_error('landmark_north')?>
                                                <?=form_error('landmark_south')?>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">East side landmark</label>
                                                <textarea name="landmark_east" id="landmark_east" placeholder="Enter East Landmark" id="" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east')){echo 'lm_invalid';}?>"><?php echo set_value('landmark_east');?></textarea>

                                                <label for="">West side landmark</label>
                                                <textarea name="landmark_west" id="landmark_west" class="form-control <?php if(form_error('landmark_west')){echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="" cols="30" rows="3"><?php echo set_value('landmark_west');?></textarea>

                                            </div>
                                            <div class="col-md-3">
                                                <label for="">North side landmark</label>
                                                <textarea name="landmark_north" id="landmark_north" class="form-control <?php if(form_error('landmark_north')){echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="" cols="30" rows="3"><?php echo set_value('landmark_north');?></textarea>

                                                <label for="">South side landmark</label>
                                                <textarea name="landmark_south" id="landmark_south" class="form-control <?php if(form_error('landmark_south')){echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="" cols="30" rows="3"><?php echo set_value('landmark_south');?></textarea>
                                            </div>
                                        </div>


                                        <div class="row p-2 <?php if(form_error('land_exceed')){echo 'lm_invalid';}?>">
                                            <div class="col-md-6">
                                                <?=form_error('land_exceed');?>
                                                <strong><?=$sl_count++?>.</strong> LM remarks</label>
                                                <?=form_error('lm_note')?>
                                                <?=form_error('lm_remark_text')?>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2"></textarea> -->
                                                <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>">
                                                    <?php
                                                    foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                                                        ?>
                                                        <option value="<?=$lm_remark_cat->CODE?>"
                                                            <?php //if(set_value('lm_note') == $lm_remark_cat->CODE){ echo "selected";} ?>
                                                        ><?=$lm_remark_cat->NAME?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <br>
                                            </div>
                                        </div>

                                        <?php
                                        include(APPPATH."views/SettlementView/include/rejectedReasons.php");
                                        ?>

                                        <div id="lm_remark_text_additional" class="row p-2" style="display: none;">
                                            <div class="col-md-3">
                                                <strong><?=$sl_count++?>.</strong> NR remarks</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="lm_remark_additional" placeholder="Enter remark..." class="form-control p-2 <?php if(form_error('lm_remark_additional')){echo 'lm_invalid';}?>" id="lm_remark_additional" rows="6" cols="40"><?php echo set_value('lm_remark_additional');?></textarea>

                                            </div>
                                        </div>

                                        <div id="lm_remark_text_id" class="row p-2" style="display: none;">
                                            <div class="col-md-3">
                                                <strong><?=$sl_count++?>.</strong> Settlement remarks</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control p-2 <?php if(form_error('lm_remark_text')){echo 'lm_invalid';}?>" id="lm_remark_text" rows="12" cols="80"><?php echo set_value('lm_remark_text');?></textarea>
                                                <input id="validationcheck" type="hidden" class="validationcheck" value="" name="validationcheck" required/>
                                            </div>
                                        </div>




                                        <div class="row p-2" id="sk_for_reject">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong>
                                                <label>
                                                    <?php
                                                    if(trim($sk_availability) == 'yyyyyyy') // As discuussed sk not required so y replaced by yyyyyyy
                                                    {
                                                        echo "<label>Select Supervisor Kanangu (SK)</label>";
                                                    }
                                                    else
                                                    {
                                                        echo "<label>Select Circle Officer (CO)</label>";
                                                    }
                                                    ?>
                                                </label>
                                                <?=form_error('co_code')?>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control <?php if(form_error('co_code')){echo 'lm_invalid';}?>" name='co_code'>
                                                    <?php
                                                    if($sk_availability == 'yyyyyyy') // As discuussed sk not required so y replaced by yyyyyyy
                                                    {
                                                        ?>
                                                        <option value="">Select Supervisor Kanangu...</option>

                                                        <?php
                                                        foreach ($sk_name as $skname) {
                                                            $user_desig_code = $skname->user_desig_code;
                                                            $username = $skname->username." ( ".$user_desig_code." )";
                                                            $user_code = $skname->user_code;
                                                            ?>
                                                            <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                                                                if(set_value('co_code') == $user_code) {
                                                                    echo "selected";
                                                                }
                                                            }?>>
                                                                <?=$username?>
                                                            </option>

                                                            <?php
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <option value="">Select Circle Officer...</option>

                                                        <?php
                                                        foreach ($co_name as $coname) {
                                                            $user_desig_code = $coname->user_desig_code;
                                                            $username = $coname->username." ( ".$user_desig_code." )";
                                                            $user_code = $coname->user_code;
                                                            ?>
                                                            <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                                                                if(set_value('co_code') == $user_code) {
                                                                    echo "selected";
                                                                }
                                                            }?>>
                                                                <?=$username?>
                                                            </option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <br>

                                            </div>
                                        </div>

                                        <div class="row p-2" id="co_for_reject" style="display: none;">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong>
                                                <label>Select Circle Officer (CO)</label>
                                                <?=form_error('co_code_reject')?>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control <?php if(form_error('co_code_reject')) { echo 'lm_invalid';}?>" name='co_code_reject'>             
                                                    <option value="">Select Circle Officer...</option>
                                                    <?php
                                                    foreach ($co_name_reject as $coname) 
                                                    {
                                                        $user_desig_code = $coname->user_desig_code;
                                                        $username = $coname->username." ( ".$user_desig_code." )";
                                                        $user_code = $coname->user_code;
                                                        ?>
                                                        <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                                                            if(set_value('co_code_reject') == $user_code) {
                                                                echo "selected";
                                                            }
                                                        }?>>
                                                            <?=$username?>
                                                        </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="row p-2 nrhide">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Premium</label>
                                                <?=form_error('totaldue')?>
                                                <?=form_error('validationcheck')?>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="rezaButt buttPrimary <?php if(form_error('validationcheck')){echo 'lm_invalid';}?> <?php if(form_error('totaldue')){echo 'lm_invalid';}?>"
                                                        onclick="premiumModal()">
                                                    Calculate Premium
                                                </button>
                                            </div>
                                        </div>

                                        <?php
                                        include(APPPATH."views/SettlementView/include/addMoreDocumentView.php");
                                        ?>
                                    </div>


                                    <?php
                                    include(APPPATH."views/SettlementView/include/village_wise_area_show_lm.php");
                                    ?>

                                </div>
                            </div>


                            <ul class="list-inline pull-right"  style="margin-top: 20px">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">
                                        <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                                    </button>
                                </li>
                                <?php if(ENABLE_BUTTON_LM_SUBMIT_AP != 0){?>

                                    <li>
                                        <button type="submit" class="btn btn-primary next-step" id="btnLmSubmit">
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>  Save & Submit
                                        </button>
                                    </li>

                                <?php } ?>
                            </ul>
                        </div>

                        <?php //var_dump($dags); die;  ?>

                 
                        
                        <!-- new premium addition -->
                        <?php
                            include(APPPATH."views/SettlementView/include/premium_calculation_modal_ap_v2.php");
                        ?>
                        <!-- premium modal end -->


                        <!-- LM template start -->
                        <?php

                        //var_dump($settlements); die;

                        if($settlements == true){
                            foreach($settlements as $settlement){
                                if($settlement->is_applicant == 1){
                                    $posdate=$settlement->period_possession;
                                }
                            }
                        }
                        $barak_ad_prop_total="";
                        $aditional_prop_total="";
                        if (isset($additional_property)){

                            if(isset($total_aditional_area_g)){
                                // var_dump($total_aditional_area_g[0]); die;
                                if(isset($total_aditional_area)){
                                    $barak_ad_prop_1 =" আৰু ";
                                }else{
                                    $barak_ad_prop_1 ="";
                                }
                                $barak_ad_prop=$total_aditional_area_g[0]." বি " .$total_aditional_area_g[1]. " ক " .$total_aditional_area_g[2]. " লে " .$total_aditional_area_g[3]. " গ ভূমি থকা";
                                $barak_ad_prop_total = $barak_ad_prop_1. $barak_ad_prop;
                            }


                            if(isset($total_aditional_area)){
                                $ad_area1=$total_aditional_area[0]."বি ,".$total_aditional_area[1]. "ক ,".$total_aditional_area[2]."লে ভূমি থকা";
                                $aditional_prop_total = $aditional_prop_total.$ad_area1;
                            }
                            // var_dump($aditional_prop_total); die;

                        }else{
                            $aditional_prop_total="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                        }

                        if($area_details[0]->is_urban=="Y"){
                            $lmtown="টাউনৰ অন্তৰ্গত ";
                            $lmposession="ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ / আৰ চি চিঘৰ ) ";
                            $lmposdate="২৮ জুন, ২০০১ চনৰ ";
                        }else{
                            $lmtown="";
                            $lmposession="ঘৰবস্তী / খেতি-বাতি ";
                            $lmposdate=$posdate;
                        }


                        ?>

                        <?php
                        if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))){
                            if(isset($property) && !empty($property)) {
                                $resultprop = array();
                                foreach($property as $isproperty):
                                    $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে " .$isproperty->ganda. " গ";
                                endforeach;
                                $aditional_prop_temp=implode(",",$resultprop);
                                $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
                            }
                            else {
                                $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                            }
                        }else{
                            if(isset($property) && !empty($property)) {
                                $resultprop = array();
                                foreach($property as $isproperty):
                                    $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে";
                                endforeach;
                                $aditional_prop_temp=implode(",",$resultprop);
                                $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
                            }
                            else {
                                $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                            }
                        }
                        ?>

                        <?php
                        if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))){
//$resultdags = array();
                        foreach($applicants as $dags_lmtemplate){
                            //$resultdags[] = $dags_lmtemplate->dag_no;
                            if($dags_lmtemplate->is_applicant == 1){
                                $app_name   = $dags_lmtemplate->pdar_name;
                                $resultdags = $dags_lmtemplate->dag_no;
                            }
                            ?>


                        <input type="hidden" id="sbigha" name='sbigha'>
                        <input type="hidden" id="skatha" name='skatha'>
                        <input type="hidden" id="slessa" name='slessa'>
                        <input type="hidden" id="sganda" name='sganda'>

                        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                        <input type="hidden" id="alloted_katha" name='alloted_katha'>
                        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
                        <input type="hidden" id="alloted_ganda" name='alloted_ganda'>

                            <script>








                                function totalAppliedArea(){
                                    var total_area = 0;
                                    var mbigha = parseFloat($("#s_dag_area_b").val());
                                    var mkatha = parseFloat($("#s_dag_area_k").val());
                                    var mlessa = parseFloat($("#s_dag_area_lc").val());
                                    var mganda = parseFloat($("#s_dag_area_g").val());
                                    var total_area = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);


                                    var bigha_r = Math.floor(total_area / 100);
                                    var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                                    var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                                    var bigha_r = Math.floor(total_area / 6400);
                                    var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
                                    var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
                                    var ganda_r = (total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20).toFixed(2);

                                    $("#sbigha").val(bigha_r);
                                    $("#skatha").val(katha_r);
                                    $("#slessa").val(lessa_r);
                                    $("#sganda").val(ganda_r);

                                    var total_road_reserved = 0;
                                    var total_lm_reserved = 0;
                                    var total_family_reserved = 0;
                                    var total_lm_family_reserved = 0;
                                    <?php //foreach($dags as $dags_lmtemplate3){ ?>

                                    var road_bigha=$("#reserved_bigha").val() ? parseFloat($("#reserved_bigha").val()) : 0;
                                    var road_katha=$("#reserved_katha").val() ? parseFloat($("#reserved_katha").val()) : 0;
                                    var road_lessa=$("#reserved_lessa").val() ? parseFloat($("#reserved_lessa").val()) : 0;
                                    var road_ganda=$("#reserved_ganda").val() ? parseFloat($("#reserved_ganda").val()) : 0;
                                    total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=$("#reserved_bigha_family").val() ? parseFloat($("#reserved_bigha_family").val()) : 0;
                                    var family_katha=$("#reserved_katha_family").val() ? parseFloat($("#reserved_katha_family").val()) : 0;
                                    var family_lessa=$("#reserved_lessa_family").val() ? parseFloat($("#reserved_lessa_family").val()) : 0;
                                    var family_ganda=$("#reserved_ganda_family").val() ? parseFloat($("#reserved_ganda_family").val()) : 0;
                                    total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                                    total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                                    <?php //} ?>

                                    var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                                    var alloted_bigha = Math.floor(total_alloted_area / 6400);
                                    var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 6400) / 320);
                                    var alloted_lessa = Math.floor((total_alloted_area - (alloted_bigha * 6400) - (alloted_katha * 320)) / 20);
                                    var alloted_ganda = (total_alloted_area - alloted_bigha * 6400 - alloted_katha * 320 - alloted_lessa * 20).toFixed(2);
                                    // alert(total_alloted_area);
                                    $("#alloted_bigha").val(alloted_bigha);
                                    $("#alloted_katha").val(alloted_katha);
                                    $("#alloted_lessa").val(alloted_lessa);
                                    $("#alloted_ganda").val(alloted_ganda);

                                }
                            </script>

                        <?php }
                        $all_dags = $resultdags; ?>

                        <?php } else{

                        //$resultdags = array();
                        foreach($applicants as $dags_lmtemplate){
                        //$resultdags[] = $dags_lmtemplate->dag_no;
                        if($dags_lmtemplate->is_applicant == 1){
                            $app_name=$dags_lmtemplate->pdar_name;
                            $resultdags = $dags_lmtemplate->dag_no;
                        }
                        ?>

                        <input type="hidden" id="sbigha" name='sbigha'>
                        <input type="hidden" id="skatha" name='skatha'>
                        <input type="hidden" id="slessa" name='slessa'>

                        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                        <input type="hidden" id="alloted_katha" name='alloted_katha'>
                        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>

                            <script>
                                function totalAppliedArea(){
                                    var total_area = 0;
                                    var mbigha = parseFloat($("#s_dag_area_b").val());
                                    var mkatha = parseFloat($("#s_dag_area_k").val());
                                    var mlessa = parseFloat($("#s_dag_area_lc").val());
                                    var total_area = ((mbigha * 100) + (mkatha * 20) + mlessa);


                                    var bigha_r = Math.floor(total_area / 100);
                                    var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                                    var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                                    $("#sbigha").val(bigha_r);
                                    $("#skatha").val(katha_r);
                                    $("#slessa").val(lessa_r);

                                    var total_road_reserved = 0;
                                    var total_lm_reserved = 0;
                                    var total_family_reserved = 0;
                                    var total_lm_family_reserved = 0;
                                    <?php //foreach($dags as $dags_lmtemplate3){ ?>
                                    var road_bigha=$("#reserved_bigha").val() ? parseFloat($("#reserved_bigha").val()) : 0;
                                    var road_katha=$("#reserved_katha").val() ? parseFloat($("#reserved_katha").val()) : 0;
                                    var road_lessa=$("#reserved_lessa").val() ? parseFloat($("#reserved_lessa").val()) : 0;
                                    total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=$("#reserved_bigha_family").val() ? parseFloat($("#reserved_bigha_family").val()) : 0;
                                    var family_katha=$("#reserved_katha_family").val() ? parseFloat($("#reserved_katha_family").val()) : 0;
                                    var family_lessa=$("#reserved_lessa_family").val() ? parseFloat($("#reserved_lessa_family").val()) : 0;
                                    total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                                    total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                                    <?php //} ?>

                                    var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                                    var alloted_bigha = Math.floor(total_alloted_area / 100);
                                    var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 100) / 20);
                                    var alloted_lessa = total_alloted_area - alloted_bigha * 100 - alloted_katha * 20;
                                    // alert(total_alloted_area);
                                    $("#alloted_bigha").val(alloted_bigha);
                                    $("#alloted_katha").val(alloted_katha);
                                    $("#alloted_lessa").val(alloted_lessa);

                                }
                            </script>

                        <?php }
                            $all_dags=$resultdags;

                        }
                        ?>

                        <!-- LM template end -->



                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>

</div>

<script>
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
           timer: 5000,
           showCancelButton: true
   
       });
   }
</script>

<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
<script>

    $(document).ready(function(){
        var roadside_comment_check1 = $("input[name='roadside_comment_check']:checked").val();
        var roadside_reservation = document.getElementById("road_side_reservation_hide");

        if(roadside_comment_check1 == 'YES'){
            roadside_reservation.style.display = "block";
        }
    })


    $(document).ready(function(){
        var family_comment_check1 = $("input[name='family_comment_check']:checked").val();
        var family_reservation = document.getElementById("family_reservation_hide");

        if(family_comment_check1 == 'YES'){
            family_reservation.style.display = "block";
        }
    })
    function roadSideReservYes() {
        $('.reserved_road_value').val(0);
        var x = document.getElementById("road_side_reservation_hide");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
    }
    //  else {
    //   x.style.display = "none";
    // }
    function roadSideReservNo() {
        $('.reserved_road_value').val(0);
        reset();
        var x = document.getElementById("road_side_reservation_hide");
        if (x.style.display === "block") {
            x.style.display = "none";
        }
    }

    // zonal value validation
    $("#zonal_valuation").keyup(function(){
        var nodir_kaijo_b = $('#reserved_bigha').val();
        var nodir_kaijo_k = $('#reserved_katha').val();
        var nodir_kaijo_lc = $('#reserved_lessa').val();
        window.nodirkakhorlessa = parseFloat(nodir_kaijo_b) * 100 + parseFloat(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
        console.log(window.nodirkakhorlessa);
        var mbigha = $('.s_dag_area_b').val();
        var mkatha = $('.s_dag_area_k').val();
        var mlessa = $('.s_dag_area_lc').val();
        //window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
        window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
        console.log(window.originallessa);
        // alert(originallessa);
        window.occupiedlessa = nodirkakhorlessa;
        window.remaininglessa = originallessa - occupiedlessa;
        if(originallessa <= nodirkakhorlessa){
            alert("Road/River side reservation can't be greater then original land");
            $('#reserved_bigha').val("0");
            $('#reserved_katha').val("0");
            $('#reserved_lessa').val("0");
            window.nodirkakhorlessa=0;
            window.occupiedlessa = nodirkakhorlessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= occupiedlessa){
            alert("Total Reservation land can't be greater then original land");
            $('#reserved_bigha').val("0");
            $('#reserved_katha').val("0");
            $('#reserved_lessa').val("0");
            window.nodirkakhorlessa=0;
            window.occupiedlessa = nodirkakhorlessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        //alert(remaininglessa);
        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2);
    });

    function familyReservYes() {
        var x = document.getElementById("family_reservation_hide");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
    }

    function familyReservNo() {
        var x = document.getElementById("family_reservation_hide");
        if (x.style.display === "block") {
            x.style.display = "none";
        }
    }

</script>
<script>
    const classExists = document.getElementsByClassName(
        'is-invalid'
    ).length > 0;

    const classExistsLm = document.getElementsByClassName(
        'lm_invalid'
    ).length > 0;

    if(classExists){
        $('html, body').animate({
            scrollTop: ($('.is-invalid').offset().top - 300),
        }, 100);
    }else if(classExistsLm)
    {
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
        $('html, body').animate({
            scrollTop: ($('.lm_invalid').offset().top - 300),
        }, 100);
    };

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }


    //// premium code



    $(document).on('click','.closePremium',function ()
    {
        premModal.style.display = "none";
    });


    $("input[name=paymode]").on("click", function () {
        var modeValue = $("input[name=paymode]:checked").val();
        if (modeValue == "YES") {
            $('#totaldue').val('');
            var totaldue= $("#finalamount").val();
            $("#totaldue").val(totaldue);
        }
        else {
            if (modeValue == "NO") {
                var totaldue= $("#finalamount").val();
                var discount = 30;
                var finaldue = Math.ceil(totaldue * discount / 100);
                $("#totaldue").val(finaldue);
            }
        }

    });

    $("#finalsubmit").click(function(){
        // if (!$('#finalamount').val()) {
        //     alert("Final Amount Can't be blak !!!");
        //     return;
        // }
        if ($('.zonal_valuation_prem').val().length === 0) {
            // alert('Please Enter Zonal Value!!');
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Please Enter Zonal Value!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.zonal_valuation_prem').focus();
            return false;
        }

        if ($('.totalamount').val().length === 0) {
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Total Dag Amount can not be blank!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.totalamount').focus();
            return false;
        }

        var sum = 0;
        $("input[class *= 'totalamount']").each(function(){
            sum += +$(this).val();
        });
        $(".premhide").show();
        $("#finalsubmit").hide();
        $("#finalsave").show();
        $("#finalamount").val(sum);
        $("#totaldue").val(sum);
        $("#paymode1").prop( "checked", true );
        // premModal.style.display = "none";
    });

    $("#finalsave").click(function(){
        if (!$('#finalamount').val()) {
            alert("Final Amount Can't be blak !!!");
            return;
        }

        premModal.style.display = "none";
    });

    function reset(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#finalamount').val('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark_additional').text('');

    }

    function roadAreaCheck(){
        reset();
    }

    function familyAreaCheck(){
        reset();
    }

    //// premium code end

    $(document).ready(function () {

        $("#gramdan_bhudan").change(function (event) {
            var selectedGb=$(this).val();

            if(selectedGb==2){
                // alert("You have Selected  :: "+selectedGb);
                $("#lm_remark option:selected").removeAttr("selected");
                $("#lm_remark option[value=2]").prop('selected', 'selected');
                $('#lm_remark option:not(:selected)').prop('disabled', true);
                $("#eksona_transfered option[value=2]").prop('selected', 'selected');
                // $("#eksona_transfered").prop( "disabled", true );
            }else{
                $("#lm_remark option:selected").removeAttr("selected");
                $("#lm_remark option[value=-1]").prop('selected', 'selected');
                $('#lm_remark option:not(:selected)').prop('disabled', false);
                $("#eksona_transfered option:selected").removeAttr("selected");
                // $("#eksona_transfered").prop( "disabled", false );
            }
        });

        $("#eksona_transfered").change(function (event) {
            var selectedEt=$(this).val();

            if(selectedEt==2){
                // alert("You have Selected  :: "+selectedGb);
                // $("#lm_remark option[value=2]").attr('selected', 'selected');
                // $('#lm_remark option:not(:selected)').prop('disabled', true);
                $("#lm_remark option:selected").removeAttr("selected");
                $("#lm_remark option[value=2]").prop('selected', 'selected');
                $('#lm_remark option:not(:selected)').prop('disabled', true);
            }else{
                // $("#lm_remark option[value=-1]").attr('selected', 'selected');
                // $('#lm_remark option:not(:selected)').prop('disabled', false);
                $("#lm_remark option:selected").removeAttr("selected");
                $("#lm_remark option[value=-1]").prop('selected', 'selected');
                $('#lm_remark option:not(:selected)').prop('disabled', false);
            }
        });
    });

    $(document).ready(function () {

        var selectedRemarkCode=$('#lm_remark').val();
        if(selectedRemarkCode == 1){
            <?php
            if(isset($err_return)){
            ?>
            $('#lm_remark_text_id').show();
            $('#lm_remark_text_additional').show();
            <?php
            }
            ?>
        }
        if(selectedRemarkCode == 2){
            <?php
            if(isset($err_return)){
            ?>
            $('#lm_remark_text_id').show();
            $('#lm_remark_text_additional').show();
            <?php
            }
            ?>
        }

    })

    // LM remark template start
    $("#lm_remark").change(function (event) {

        var selectedRemark=$(this).val();

        if(selectedRemark==1){

            $('#lm_remark_text_id').show();
            $('#lm_remark_text_additional').show();

            // alert("You have Selected  :: "+selectedRemark);
            totalAppliedArea();
            $('#lm_remark_text').text('');
            $('#lm_remark_additional').text('');
            <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  হস্তান্তৰিত একচনা পট্টাৰ ভূমি চৰকাৰীকৰণ ক্ৰমে পট্টন পাবৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত উক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ ভূমিত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলত ৰখা দেখা যায়।");
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা যায়।");
            // $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop?>,  "+$('#occupation_applicant').val()+" কৰ্মসুত্ৰে উক্ত নগৰত বসবাস কৰিব লগীয়া আৰু নিজ উপাৰ্জনেৰে উক্ত নগৰ ভূমি কিনিবলৈ সামৰ্থ নথকা এজন/ ভূমিহীন আৰু ২৮ জুন, ২০০১ তনৰ পৰা উক্ত দখলকৰি থকা নথি দাখিল কৰামতে উক্ত তাৰিখৰ পৰা ভোগ দখল কৰি থকা লোক হয়।  গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা যায়।");

            $('#lm_remark_additional').text("<?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'], $app['subdiv_code'], $app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'], $app['subdiv_code'], $app['cir_code'], $app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#nr_bigha').val()+" বি "+$('#nr_katha').val()+" ক "+$('#nr_lessa').val()+" চ "+$('#nr_ganda').val()+" গ হস্তান্তৰিত হোৱাত পট্টাৰ স্বত্ব ভংগ হৈছে আৰু সেয়ে উক্ত ভূমি, বন্দোৱস্তী নিয়মাৱলীৰ 1(2)(c) বিধি মতে চৰকাৰী কৰণ কৰা হল ।");
            $('#lm_remark_additional').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  হস্তান্তৰিত একচনা পট্টাৰ ভূমি চৰকাৰীকৰণ ক্ৰমে পট্টন পাবৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত উক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে ভূমিত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলত ৰখা দেখা যায় ।");
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে পট্টন দিব পৰা যায়।");

            $('#lm_remark_additional').text("<?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#nr_bigha').val()+" বি "+$('#nr_katha').val()+" ক "+$('#nr_lessa').val()+" লে হস্তান্তৰিত হোৱাত পট্টাৰ স্বত্ব ভংগ হৈছে আৰু সেয়ে উক্ত ভূমি, বন্দোৱস্তী নিয়মাৱলীৰ 1(2)(c) বিধি মতে চৰকাৰী কৰণ কৰা হল ।");
            $('#lm_remark_additional').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");

            <?php endif ;?>

        }else if(selectedRemark==2){
            $('#lm_remark_text_id').show();
            $('#lm_remark_text_additional').show();
            totalAppliedArea();
            $('#lm_remark_text').text('');
            <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))): ?>

            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  হস্তান্তৰিত একচনা পট্টাৰ ভূমি চৰকাৰীকৰণ ক্ৰমে পট্টন পাবৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত উক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ ভূমিত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলত ৰখা দেখা যায়।");
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা নাযায়।");

            $('#lm_remark_additional').text("<?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#nr_bigha').val()+" বি "+$('#nr_katha').val()+" ক "+$('#nr_lessa').val()+" চ "+$('#nr_ganda').val()+" গ হস্তান্তৰিত হোৱাত পট্টাৰ স্বত্ব ভংগ হৈছে আৰু সেয়ে উক্ত ভূমি, বন্দোৱস্তী নিয়মাৱলীৰ 1(2)(c) বিধি মতে চৰকাৰী কৰণ কৰা হল ।");
            $('#lm_remark_additional').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            <?php else : ?>

            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  হস্তান্তৰিত একচনা পট্টাৰ ভূমি চৰকাৰীকৰণ ক্ৰমে পট্টন পাবৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত উক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে ভূমিত আবেদনকাৰীয়ে <?php echo $lmposession?> কৰি দখলত ৰখা দেখা যায় ।");
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে পট্টন দিব পৰা নাযায়।");

            $('#lm_remark_additional').text("<?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ "+$('#patta_no').val()+" নং একচনা পট্টাৰ <?php echo $all_dags?> দাগৰ "+$('#nr_bigha').val()+" বি "+$('#nr_katha').val()+" ক "+$('#nr_lessa').val()+" লে হস্তান্তৰিত হোৱাত পট্টাৰ স্বত্ব ভংগ হৈছে আৰু সেয়ে উক্ত ভূমি, বন্দোৱস্তী নিয়মাৱলীৰ 1(2)(c) বিধি মতে চৰকাৰী কৰণ কৰা হল ।");
            $('#lm_remark_additional').append("\n \n উক্ত <?php echo $all_dags?> দাগৰ উত্তৰে "+$('#landmark_north').val()+" দক্ষিণে "+$('#landmark_south').val()+" পূবে "+$('#landmark_east').val()+" আৰু পশ্চিমে "+$('#landmark_west').val()+" থকা দেখা যায়।");
            <?php endif ;?>
        }else{
            $('#lm_remark_text').text('');
            $('#lm_remark_additional').text('');
            $('#lm_remark_text_id').hide();
            $('#lm_remark_text_additional').hide('');
        }
    });

    // LM remark template end

    //modal for additional land property
    function openPropertyModal(){
        modal.style.display = "block";
    }


    var premModal = document.getElementById("premiumModal");

    function premiumModal(){

        premModal.style.display = "block";

        var uuid = $('#uuid').val();
        var base_url = "<?php echo base_url();?>";

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            premModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == premModal) {
                premModal.style.display = "none";
            }
        }
    }

    function forcedUrban(val) {
        if (val == "YES") {
            $("#forcedurban").show();
        } else {
            $("#forcedurban").hide();
        }
    }

</script>

<script>

    $(document).ready(function()
    {
        apPP();
        // if($("input[name='is_nr_settlement']:checked").val() == 'NR')
        // {
        //     $(".nrhide").hide();
        // }
        // else
        // {
        //     $(".nrhide").show();
        // }

    })

    function apPP()
    {
        var ap_ap = $("input[name='is_nr_settlement']:checked").val();

        if(ap_ap == 'AP to PP case')
        {
            $("#lm_remark option[value='1']").hide();
        }

        if(ap_ap != 'AP to PP case')
        {
            $("#lm_remark option[value='1']").show();
        }

        if(ap_ap == 'NR'){
            $(".nrhide").hide();
        }else{
            $(".nrhide").show();
        }
    }


    $('#btnLmSubmit').on('click',function(e){
        e.preventDefault();
        var form = $('.lmForm');
        

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: 'Land Occupied : '+$( "#is_landless option:selected" ).text(),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: 'Land Occupied : '+$( "#is_landless option:selected" ).text(),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: 'Land Occupied : '+$( "#is_landless option:selected" ).text(),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {

                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                // 'error'
            )
        }
    })
    });


</script>

<script>

    $(document).ready(function()
    {
        var selection = $('#lm_remark').val();
        if(selection == 2)
        {
            $('#sk_for_reject').hide();
            $('#co_for_reject').show();
        }
        else
        {
            $('#sk_for_reject').show();
        }

    })


    $(document).on('change', '#lm_remark', function(){
        
        var selection = $(this).val();
        
        if(selection == 2)
        {
            $('#sk_for_reject').hide();
            $('#co_for_reject').show();
        }
        else
        {
            $('#sk_for_reject').show();
            $('#co_for_reject').hide();
        }

    })
</script>
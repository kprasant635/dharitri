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
    .edit-enc-close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .edit-enc-close:hover,
    .edit-enc-close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function(){

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
<script>
    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>
<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
else{
    $lessa_chatak='Lessa';
}?>
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
                    <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
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
                        <li role="presentation">
                            <a
                                    href="#step2"
                                    data-toggle="tab"
                                    aria-controls="step2"
                                    role="tab"
                                    title="Step 2"
                            >
                          <span class="round-tab">
                          <strong>LRA Report</strong>
                          </span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a
                                    href="#step4"
                                    data-toggle="tab"
                                    aria-controls="step4"
                                    role="tab"
                                    title="step 4"
                            >
                        <span class="round-tab">
                          <strong>Proceedings</strong>
                        </span>
                        </a>
                        </li>
                        <li role="presentation">
                            <a href="#history" data-toggle="tab" aria-controls="history" role="tab" title="history">
                                <span class="round-tab"><strong>History</strong></span>
                            </a>
                        </li>

                    </ul>
                </div>

                <form role="form" class="lmForm" method="post" action="<?php echo base_url() ?>index.php/SettlementInstitutionLm/applicationInsRegistration/<?=$review_flag?>?app=<?=$_GET['app']?>" enctype="multipart/form-data">
   

                    <?php 
                        $application_no = $this->utilityclass->decryptJwtCase($_GET['app']);
                    ?>

                    <input type="hidden" id="service_code_lm" name="service_code" value="<?=$basic["service_code"]?>">
                    <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
                    <input type="hidden" id ='case_no' name="case_no" value="<?=$case_no?>">
                    <input type="hidden" id ='application_no' name="applid" value="<?=$application_no?>">
                    <input type="hidden" name="uuid" id="uuid" value="<?=$basic['uuid']?>">
                    <input type="hidden" name="lm_verification_date" id="lm_verification_date" value="<?=$geo_date ; ?>">
                    <?php
                    $sl_count = 1;
                    ?>
                    <div class="tab-content">


                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                <?php echo NJS_TAGLINE; ?> 
                                (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                            </h5>
                            <div class="reza-card">
                                <div id="additionalErrors" class="text-right px-4 mt-2" style="cursor:pointer;">
                                    <?php
                                    if(isset($all_errors)){?>
                                        <span class="text-danger">
                                        <i id="blink" class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>
                                        Check errors
                                        </span>
                                    <?php }?>
                                </div>
                                <div id="additional_errors_collapse" style="display: none;">
                                    <?php
                                    if(isset($all_errors)){?>
                                        <div class="alert alert-warning">
                                            <b>
                                                <?=$all_errors;?>
                                            </b>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                
                                <div class="reza-body">
                                    <?php
                                    echo $dagFlagCheckChitha;
                                    ?>

                                    <div id="ins_data_render_id"></div>

                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-file-text"></i> Authorised applicant e-kyc Information
                                    </h5>
                                    <div class="tableCard">
                                        <div class="row justify-content-center">
                                            <?php
                                            if(isset($base64_decoded_adhar_file)){
                                                ?>
                                                <div class="col-md-2">
                                                    <?=$base64_decoded_adhar_file;?>
                                                </div>
                                            <?php }?>
                                            <div class="col-md-10">
                                                <table class="table table-bordered">
                                                    <?php
                                                    foreach ($applicants_buyers as $identity):
                                                        if($identity->is_applicant == 1){
                                                            ?>
                                                            <tr>
                                                                <th>
                                                                    Name in <?=$identity->identity_type?>
                                                                </th>
                                                                <td>
                                                                    <input type="text" value="<?=$identity->eng_pdar_name?>" class="form-control" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th><?=$identity->identity_type?> Verified</th>
                                                                <td>
                                                                    <input type="text" name="aadhar_verified" value="<?php if ($aadhar->is_aadhaar_verify == '1') {echo 'Yes';}?>" class="form-control" disabled>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    endforeach;
                                                    if ($basic == true) { ?>                                                        
                                                        <!-- <tr>
                                                            <th>Total Applications applied by this applicant</th>
                                                            <td>
                                                                <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$basic["applid"];?>">
                                                                    <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                                                                </a>
                                                            </td>
                                                        </tr> -->
                                                    <?php } ?>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                        if($check_if_dag_available == 0)
                                        {
                                            echo "The applicant has submitted the application without selecting any DAG for the chosen village. Therefore, it is requested that the LRA assign a DAG corresponding to the selected village before raising a query regarding a village/DAG change !!!";
                                        }
                                        else
                                        {
                                            $basuCase= $this->utilityclass->decryptJwtCase($_GET['app']);
                                            include(APPPATH.'views/query/villageQueryModel.php');    
                                        }

                                        
                                    ?>

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-map-marker"></i> Address Information
                                    </h5>
                                    <div class="tableCard ">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>District Name:</th>
                                                <td class="text-warning">
                                                    <strong class="alert-warning">
                                                        <input type="text" name="dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($basic["dist_code"])?>' readonly>
                                                        <input type="hidden" id="dist_code" name="dist_code" value="<?=$basic["dist_code"];?>">
                                                    </strong>
                                                </td>
                                                <th>Subdivision Name:</th>
                                                <td class="text-warning">
                                                    <strong class="alert-warning">
                                                        <input type="text" name="subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($basic["dist_code"], $basic["subdiv_code"])?>' readonly>
                                                        <input type="hidden" name="subdiv_code" value="<?=$basic["subdiv_code"];?>">
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Circle Name: </th>
                                                <td class="text-warning">
                                                    <strong class="alert-warning">
                                                        <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?>' class="form-control input-sm" readonly>
                                                        <input type="hidden" name="cir_code" value="<?=$basic["cir_code"];?>">
                                                    </strong>
                                                </td>
                                                <th>Mouza Name: </th>
                                                <td class="text-warning">
                                                    <strong class="alert-warning">
                                                        <input type="text" name="mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?>' readonly>
                                                        <input type="hidden" name="mouza_pargona_code" value="<?=$basic["mouza_pargona_code"];?>">
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Village Name: </th>
                                                <td class="text-warning">
                                                    <strong class="alert-warning">
                                                        <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?>' class="form-control input-sm" readonly>
                                                        <input type="hidden" name="vill_townprt_code" value="<?=$basic["vill_townprt_code"];?>">
                                                    </strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php 
                                    if($selfDeclarationDetails != null)
                                    {
                                        ?>
                                        <h5 class="reza-title" style="margin-top: 50px">
                                            <i class="fa fa-pencil-square-o"></i> Self declaration details
                                        </h5>
                                        <div class="tableCard">
                                            <table class="table table-bordered">
                                                <?php foreach ($selfDeclarationDetails[0] as $key => $self) { ?>
                                                    <tr>
                                                        <th><?=$self->name?></th>
                                                        <td>
                                                            <strong>
                                                                <?php if ($self->status == "1") {echo "Yes";}?>
                                                                <?php if ($self->status == "0") {echo "No";}?>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                            </table>
                                        </div>
                                    <?php } ?>
                                    
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user"></i> Authorised Applicant details
                                        

                                    </h5>

                                    <?php $i = 1; foreach ($applicants_buyers as $settlement):
                                        ?>
                                        <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
                                        <!-- <div class="tableCard applicantData" id='applicantrow_<?=$i?>'> -->
                                        <div class="tableCard" id='applicantData'>
                                            
                                            <table class="table table-bordered" id="appRow<?=$settlement->id?>">

                                                <tr>
                                                    <th>
                                                        Name in <?=$settlement->identity_type?>
                                                    </th>
                                                    <td>
                                                        <input type="text" value="<?=$settlement->eng_pdar_name?>" class="form-control" readonly>
                                                    </td>
                                                
                                                    <th><?=$settlement->identity_type?> Verified</th>
                                                    <td>
                                                        <input type="text" name="aadhar_verified" value="<?php if ($aadhar->is_aadhaar_verify == '1') {echo 'Yes';}?>" class="form-control" disabled>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   
                                                    <th>Applicant Name (Assamese)</th>
                                                    <td>
                                                        <input type="text" name="pdar_name<?=$settlement->id?>" id="pdar_name<?=$settlement->id?>" readonly value="<?=$settlement->pdar_name;?>" class="form-control input-sm">
                                                    </td>
                                                    <th>Applicant Name (English)</th>
                                                    <td>
                                                        <input type="text" name="eng_pdar_name<?=$settlement->id?>" id="eng_pdar_name<?=$settlement->id?>" readonly class="form-control" value="<?=$settlement->eng_pdar_name;?>" readonly>
                                                    </td>
                                                    
                                                </tr>
                                                
                                                   
                                                <tr>
                                                    <th>DOB</th>
                                                    <td>
                                                        <input type="text" readonly id="dob<?=$settlement->id?>" name="dob<?=$settlement->id?>" value="<?=$settlement->dob;?>" class="form-control input-sm" >
                                                    </td>
                                                    <th>Mobile</th>
                                                    <td>
                                                        <input type="text" readonly name="pdar_mobile<?=$settlement->id?>" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile;?>" class="form-control input-sm" >
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Permanent address
                                                    </th>
                                                    <td >
                                                        <input type="text" readonly name="pdar_add1<?=$settlement->id?>" id="pdar_add1<?=$settlement->id?>" value="<?=$settlement->pdar_add1;?>" class="form-control input-sm">
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <th>Present address</th>
                                                    <td>
                                                        <input type="text" readonly name="pdar_add2<?=$settlement->id?>" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2;?>" class="form-control input-sm" >
                                                    </td>
                                                    <td colspan="2" style="vertical-align : middle;text-align:center;">
                                                        <?php //if(ENABLE_APPLICANT_BUTTON != 0){?>
                                                            <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>
                                                            <button type="button" onclick="openApplicant();" class="btn btn-sm btn-primary"><strong>Add Data</strong></button>

                                                            <?php if($settlement->is_applicant != 1){ ?>
                                                                <button type="button" onclick="confirmDeleteApplicant(<?=$settlement->id?>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                                    <strong>Delete</strong></button>

                                                            <?php }?>
                                                        <?php //}?>
                                                    </td>
                                                </tr> -->

                                            </table>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach; ?>
                                    <!-- <input type="hidden" name="deleted_applicant" value="" id="del_fpart_appl">
                                    <div class='element' id='div_1' style="margin-bottom: 25px; margin-top: 25px">
                                       <a class="rezaButt buttDanger add" style="color: white; font-size: 15px"> <i class="fa fa-plus-circle"></i>
                                       Add Applicant
                                       </a>
                                    </div> -->
                                    <?php if ($applicants_owners == true) {?>
                                        <h5 class="reza-title" style="margin-top: 50px">
                                            <i class="fa fa-user-circle-o" aria-hidden="true"></i> Owner Details
                                        </h5>
                                        <div class="tableCard ">
                                            <table class="table table-bordered">
                                                <?php
                                                foreach ($applicants_owners as $owners) {
                                                    ?>
                                                    <tr>
                                                        <th>Name</th>
                                                        <td colspan="2">
                                                            <input type="text" name="owners_name<?=$owners->id?>" value="<?=$owners->pdar_name;?>" class="form-control input-sm">
                                                        </td>
                                                        <th>Father's name</th>
                                                        <td colspan="2">
                                                            <input type="text" name="owners_guardian<?=$owners->id?>" value="<?=$owners->pdar_guardian;?>" class="form-control input-sm" >
                                                        </td>
                                                        <th>
                                                            In place/Along with
                                                        </th>
                                                        <input type="hidden" name="owners_pdar_id<?=$owners->id?>" value="<?=$owners->pdar_id?>">
                                                        <input type="hidden" name="owners_pdar_type<?=$owners->id?>" value="O">
                                                        <td>
                                                            <select name="owners_in_place<?=$owners->id?>" id="" class="form-control" required>
                                                                <option value="">Select...</option>
                                                                <option value="i" <?php if ($owners->inplaceAlognwith == 'i') {echo "selected";}?> >In Place</option>
                                                                <option value="a" <?php if ($owners->inplaceAlognwith == 'a') {echo "selected";}?>>Along with</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <?php
                                    }


                                    //*********occupiers details  */
                                    include(APPPATH."views/SettlementView/include/encroacherDetailsIns.php");

                                    ?>

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-map"></i>  Area Details
                                    </h5>

                                    <?php foreach($dags as $dagspremlm){ ?>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong style="color:red"> Area Type for Dag No : <?=$dagspremlm->dag_no?></strong></span>
                                                <?=form_error('area'.$dagspremlm->dag_no)?>
                                            </div>

                                            <div class="col-md-6">
                                            
                                            <input type="hidden" name='area_new<?=$dagspremlm->dag_no?>' id='area_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaCategory($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                                            <?=form_error('area_new'.$dagspremlm->dag_no)?>
                                            <input class="form-control" type="text" name='area_cat_new<?=$dagspremlm->dag_no?>' id='area_cat_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaName($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                                            </div>
                                        </div>

                                        
                                        <?php }?>
                                    <div class="tableCard">
                                        <!-- new premium addition -->
                                    
                                        <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;" class="<?php if(form_error('totalAppliedAdditionalArea')){echo 'is-invalid';} ?>">
                                            <?=form_error('totalAppliedAdditionalArea');?>
                                        </div>
                                        <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                                             class="<?php if(form_error('totalAppliedAreaInUrban')){echo 'is-invalid';} ?>">
                                            <?=form_error('totalAppliedAreaInUrban');?>
                                        </div>
                                        <?php if(empty($dags)){?>
                                            <p style="color: red;"><i class="fa fa-angle-double-right"></i> Dag has not been selected during application by citizen</p>
                                            <?php $show_ap_area = '';
                                            if($ap_area == null)
                                            {
                                                $show_ap_area = $total_home_bigha. "B-".$total_home_katha." K-".$total_home_lessa."-L";
                                            }
                                            else
                                            {
                                                $show_ap_area = $ap_area;
                                            } 
                                        
                                            ?>

                                            <p style="color: red;font-size: 15px;"> <i class="fa fa-angle-double-right"></i> Entities should be entered in VLB with suitable dag after joint verification for land measuring <?=$show_ap_area; ?>
                                             (citizen applied area) from dag no</p>    
                                        <?php } ?>


                                        <?php if(ENABLE_DAG_CHANGE_BUTTON_INSTITUTE == 1) { ?>
                                                <button type="button" class="btn btn-sm btn-success pull-right" id="add_new_dag"><i class="fa fa-plus"></i>&nbsp;&nbsp;ADD NEW DAG</button>
                                                  <br><br>
                                                  <?php include(APPPATH."views/SettlementView/include/newDagEntryIns.php"); ?>
                                                  <script src="<?php echo base_url();?>js/mb2/newDagEntryIns.js"></script>
                                                <?php } ?>
                                        
                                        <table class="table mb-0">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th class="text-center">Bigha</th>
                                                <th class="text-center">Katha</th>
                                                <th class="text-center"><?=$lessa_chatak?></th>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <th class="text-center">Ganda</th>
                                                    <th class="text-center hide">Kranti</th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <?php
                                            $total_home_bigha = 0;
                                            $total_home_katha = 0;
                                            $total_home_lessa = 0;
                                            $total_home_ganda = 0;
                                            $total_home_kranti = 0;

                                            $total_agri_bigha = 0;
                                            $total_agri_katha = 0;
                                            $total_agri_lessa = 0;
                                            $total_agri_ganda = 0;
                                            $total_agri_kranti = 0;

                                            $total_fbigha=0;
                                            $total_fkatha=0;
                                            $total_flessa=0;
                                            $total_fganda=0;
                                            $total_fkranti=0;

                                            $total_area_bigha = 1;
                                            $total_area_katha = 1;
                                            $total_area_lessa = 1;
                                            $total_area_ganda = 1;
                                            $total_area_kranti = 1;

                                            $total_area_agri_bigha = 1;
                                            $total_area_agri_katha = 1;
                                            $total_area_agri_lessa = 1;
                                            $total_area_agri_ganda = 1;
                                            $total_area_agri_kranti = 1;

                                            $total_area_fbigha = 1;
                                            $total_area_fkatha = 1;
                                            $total_area_flessa = 1;
                                            $total_area_fganda = 1;
                                            $total_area_fkranti = 1;

                                            foreach ($dags as $all_dags) {
                                                $total_home_bigha = $total_home_bigha + $all_dags->home_b;
                                                $total_home_katha = $total_home_katha + $all_dags->home_k;
                                                $total_home_lessa = $total_home_lessa + $all_dags->home_lc;
                                                $total_home_ganda = $total_home_ganda + $all_dags->home_g;
                                                $total_home_kranti = $total_home_kranti + $all_dags->home_kr;

                                                $total_agri_bigha = $total_agri_bigha + $all_dags->agri_b;
                                                $total_agri_katha = $total_agri_katha + $all_dags->agri_k;
                                                $total_agri_lessa = $total_agri_lessa + $all_dags->agri_lc;
                                                $total_agri_ganda = $total_agri_ganda + $all_dags->agri_g;
                                                $total_agri_kranti = $total_agri_kranti + $all_dags->agri_kr;

                                                $total_fbigha=$total_fbigha+$all_dags->fbigha;
                                                $total_fkatha=$total_fkatha+$all_dags->fkatha;
                                                $total_flessa=$total_flessa+$all_dags->flessa;
                                                $total_fganda=$total_fganda+$all_dags->fganda;
                                                $total_fkranti=$total_fkranti+$all_dags->fkranti;

                                                ?>
                                                <tr>
                                                    <th rowspan="4" style="vertical-align : middle;">
                                                        <div class="vertical">
                                                            DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> &nbsp;|&nbsp;
                                                            PATTA : <span class="text-danger"><?=$all_dags->patta_no?></span>
                                                            <input type="hidden" id="dag_no<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_no?>">
                                                            <input type="hidden" id="patta_no<?=$all_dags->dag_no?>" value="<?=$all_dags->patta_no?>">
                                                            <input type="hidden" name="is_urban" id="urbanCheck<?=$all_dags->dag_no?>" value="<?=$all_dags->is_urban?>">
                                                        </div>
                                                    </th>
                                                    <th class="bg-white">Total Land Area in Selected Dag</th>
                                                    <td class="bg-white">
                                                        <strong>
                                                            <input type="text" style="text-align: center;" name="dag_area_b<?=$all_dags->dag_no?>" id="dag_area_b<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?=$all_dags->dag_area_b;?>" readonly>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white">
                                                        <input type="text" style="text-align: center;" name="dag_area_k<?=$all_dags->dag_no?>" id="dag_area_k<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_area_k;?>" class="form-control input-sm" readonly>
                                                    </td>
                                                    <td class="bg-white">
                                                        <input type="text" style="text-align: center;" name="dag_area_lc<?=$all_dags->dag_no?>" id="dag_area_lc<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?= $all_dags->dag_area_lc;?>" readonly>
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="bg-white">
                                                            <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$all_dags->dag_no?>" id="dag_area_g<?=$all_dags->dag_no?>" readonly>
                                                        </td>
                                                        <td class="bg-white hide">
                                                            <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$all_dags->dag_no?>" id="dag_area_kr<?=$all_dags->dag_no?>" readonly>
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <?php $hide = 'area_show';
                                                if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                                                    $hide = 'area_show';
                                                } else {
                                                    $hide = 'area_hide';
                                                }
                                                ?>
                                                <?php
                                                $encroachment_area = json_decode($all_dags->encroachement_area);
                                                ?>
                                                <tr>
                                                    <th class="text-success enc-area-color">Encroachment Area</th>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$all_dags->dag_no?>" id="enc_home_b<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$encroachment_area->homestead->bigha;?>">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$all_dags->dag_no?>" id="enc_home_k<?=$all_dags->dag_no?>" value="<?=$encroachment_area->homestead->katha;?>" class="form-control input-sm enc_home_k">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$all_dags->dag_no?>" id="enc_home_lc<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_lc" value="<?=$encroachment_area->homestead->lessa;?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->homestead->ganda;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_dags->dag_no?>" id="enc_home_g<?=$all_dags->dag_no?>">
                                                        </td>
                                                        <td class="enc-area-color hide">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->homestead->kranti;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_dags->dag_no?>" id="enc_home_kr<?=$all_dags->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <!-- <tr>
                                                    <th class="text-success enc-area-color">Encroachment Area (Agricultural)</th>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_agri_b<?=$all_dags->dag_no?>" id="enc_agri_b<?=$all_dags->dag_no?>" class="form-control input-sm agri_b" value="<?=$encroachment_area->agriculture->bigha;?>">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_agri_k<?=$all_dags->dag_no?>" id="enc_agri_k<?=$all_dags->dag_no?>" value="<?=$encroachment_area->agriculture->katha;?>" class="form-control input-sm agri_k">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_agri_lc<?=$all_dags->dag_no?>" id="enc_agri_lc<?=$all_dags->dag_no?>" class="form-control input-sm agri_lc" value="<?=$encroachment_area->agriculture->lessa;?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->agriculture->ganda;?>" class="form-control input-sm agri_g" name="enc_agri_g<?=$all_dags->dag_no?>" id="enc_agri_g<?=$all_dags->dag_no?>" onkeyup="agriArea()">
                                                        </td>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->agriculture->kranti;?>" class="form-control input-sm agri_kr hide" name="enc_agri_kr<?=$all_dags->dag_no?>" id="enc_agri_kr<?=$all_dags->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr> -->
                                                <tr class='<?=$hide?>'>
                                                    <th class="text-primary settlement-area-color">Area for Settlement</th>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="home_b<?=$all_dags->dag_no?>" class="form-control input-sm home_b" value="<?=$all_dags->home_b;?>" onkeyup="totalAreaCal()" id="home_b<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="home_k<?=$all_dags->dag_no?>" value="<?=$all_dags->home_k;?>" class="form-control input-sm home_k" onkeyup="totalAreaCal()" id="home_k<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="home_lc<?=$all_dags->dag_no?>" class="form-control input-sm s_dag_area_lc" value="<?=$all_dags->home_lc;?>" onkeyup="totalAreaCal()" id="home_lc<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$all_dags->home_g;?>" class="form-control input-sm s_dag_area_g" name="home_g<?=$all_dags->dag_no?>" onkeyup="totalAreaCal()" id="home_g<?=$all_dags->dag_no?>">
                                                        </td>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$all_dags->home_kr;?>" class="form-control input-sm s_dag_area_kr hide" name="home_kr<?=$all_dags->dag_no?>" onkeyup="totalAreaCal()" id="home_kr<?=$all_dags->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <?php $hide = 'area_show';
                                                if ($all_dags->land_type == 2) {
                                                    $hide = 'area_show';
                                                } else {
                                                    $hide = 'area_hide';
                                                }

                                                ?>
                                                <!-- <tr class='<?=$hide?>'>
                                                    <th class="text-primary settlement-area-color">Area for Settlement (Agricultural)</th>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="agri_b<?=$all_dags->dag_no?>" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b;?>" onkeyup="agriArea()" id="agri_b<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="agri_k<?=$all_dags->dag_no?>" value="<?=$all_dags->agri_k;?>" class="form-control input-sm agri_k" onkeyup="agriArea()" id="agri_k<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="agri_lc<?=$all_dags->dag_no?>" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc;?>" onkeyup="agriArea()" id="agri_lc<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$all_dags->agri_g;?>" class="form-control input-sm agri_g" name="agri_g<?=$all_dags->dag_no?>" onkeyup="agriArea()" id="agri_g<?=$all_dags->dag_no?>">
                                                        </td>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$all_dags->agri_kr;?>" class="form-control input-sm agri_kr hide" name="agri_kr<?=$all_dags->dag_no?>" onkeyup="agriArea()" id="agri_kr<?=$all_dags->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr> -->
                                               
                                                <tr style="border-bottom:1px solid #227576">
                                                    <td colspan="2">
                                                        <?php if(ENABLE_AREA_BUTTON_INSTITUTE != 0){?>
                                                            <!-- <button type="button" id="editarea<?=$all_dags->id?>" onclick="editAreaIns(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-warning">Edit Area</button> -->
                                                        <?php } if(ENABLE_DAG_ELIGIBLE_BUTTON_INSTITUTE != 0){
                                                            if($dag_count>1){?>
                                                                <button type="button" id="deldag<?=$all_dags->id?>" onclick="deleteDagIns(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-danger"><i class="fa fa-remove" style="color:white"></i> Dag Not Eligible</button>

                                                                <button type="button" id="insdag<?=$all_dags->id?>" onclick="insertDagIns(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-success" style="display:none">Eligible</button>

                                                            <?php } }?>

                                                        <div id="dageligiblemsg<?=$all_dags->id?>" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; display:none">

                                                        </div>
                                                    </td>
                                                    <td colspan="2" class="text-center">

                                                        <!-- <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$basic["applid"];?>&dag=<?=$all_dags->dag_no;?>">
                                                            <small style="font-size:14px; color:white; font-weight:bold">
                                                                <i class="fa fa-eye"></i> View Total Applications in this Dag
                                                            </small>
                                                        </a> -->
                                                    </td>
                                                </tr>

                                            <?php }?>
                                            <script src="<?php echo base_url();?>js/mb3/juridical/editAreaJuridical.js"></script>
                                            <?php
                                            
                                            // for dag not eligible
                                            include(APPPATH."views/SettlementView/include/dagNotEligibleViewIns.php");
                                            ?>

                                            <tr class="bg-white" style="border-top: 3px solid #227576;">
                                                <th rowspan="2"></th>
                                                <th class="text-danger">
                                                    Total Settlement Area
                                                    <span class="<?php if(form_error('khasMaxHomestead') ){echo 'is-invalid';}?>"></span>
                                                    <?=form_error('khasMaxHomestead');?>
                                                </th>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_bigha" required class="form-control input-sm s_dag_area_b" id="total_applied_home_bigha" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_bigha');}else{ echo $total_home_bigha;}?>" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_katha" required value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_katha');}else{ echo $total_home_katha;}?>" id="total_applied_home_katha" class="form-control input-sm s_dag_area_k" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_lessa" required class="form-control input-sm s_dag_area_lc" id="total_applied_home_lessa" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_lessa');}else{ echo $total_home_lessa;}?>" >
                                                </td>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <td>
                                                        <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_ganda');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_g" id="total_applied_home_ganda" name="total_applied_area_homestead_ganda" >
                                                    </td>
                                                    <td class="hide">
                                                        <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_kranti');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_kr hide" id="total_applied_home_kranti" name="total_applied_area_homestead_kranti" >
                                                    </td>
                                                <?php endif;?>
                                            </tr>
                                            <!-- /////////for calculation only///////// -->
                                            <input readonly type="hidden" style="text-align: center;" name="total_applied_area_agricultural_bigha" class="form-control input-sm ag_dag_area_b"  id="total_applied_agri_bigha" value="0">
                                            <input readonly type="hidden" style="text-align: center;" name="total_applied_area_agricultural_katha" value="0" id="total_applied_agri_katha"  class="form-control input-sm ag_dag_area_k" >

                                            <input readonly type="hidden" style="text-align: center;" name="total_applied_area_agricultural_lessa" class="form-control input-sm ag_dag_area_lc" id="total_applied_agri_lessa"  value="0" >
                                            <!-- <tr>
                                                <th class="text-danger">
                                                    Total applied area (Agricultural)
                                                    <span class="<?php if(form_error('khasMaxAgriculture') ){echo 'is-invalid';}?>"></span>
                                                    <?=form_error('khasMaxAgriculture');?>
                                                </th>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_bigha" class="form-control input-sm ag_dag_area_b"  id="total_applied_agri_bigha"
                                                           value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_bigha');}else{ echo $total_agri_bigha;}?>">
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_katha" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_katha');}else{ echo $total_agri_katha;}?>" id="total_applied_agri_katha"  class="form-control input-sm ag_dag_area_k" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_lessa" class="form-control input-sm ag_dag_area_lc" id="total_applied_agri_lessa"  value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_lessa');}else{ echo $total_agri_lessa;}?>" >
                                                </td>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <td>
                                                        <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_ganda');}else{ echo $total_agri_ganda;}?>" class="form-control input-sm ag_dag_area_g" id="total_applied_agri_ganda"  name="total_applied_area_agricultural_ganda" >
                                                    </td>
                                                    <td class="hide">
                                                        <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_kranti');}else{ echo $total_agri_kranti;}?>" class="form-control input-sm ag_dag_area_kr hide" id="total_applied_agri_kranti"  name="total_applied_area_agricultural_kranti" >
                                                    </td>
                                                <?php endif;?>
                                            </tr> -->
                                            
                                        </table>
                                        <!-- this only to display the error message in area validation -->
                                        <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                                        <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                                        <br>

                                       

                                    </div>

                                    

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-file-pdf-o"></i> Supporting Documents
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php foreach ($document as $d): ?>
                                                <tr>
                                                    <th>
                                                        <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/documentmb3/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                                        <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                                        <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                                        <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                                        <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                                        <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                                                    </th>
                                                </tr>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                    <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
                                </div>
                            </div>
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
                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                <?php echo  NJS_TAGLINE; ?> (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                            </h5>
                            <div class="reza-card">
                                <div class="reza-body">
                                    <?php  
                                    echo $dagFlagCheckChitha;
                                    ?>
                                    <h5  class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
                                    </h5>
                                    <div class="tableCard lm-report" style="padding-bottom: 15px">
                                        <!------------------ khas land lm report ------->

                                        <div class="row p-2" >
                                            <!--<div class="col-md-6">
                                                <span><strong>.</strong> Chitha Verified?</span>
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
                                            </div> -->
                                            <!-- <div class="col-md-4">
                                                <?php
                                                foreach ($dags as $ddg) {
                                                    $patta_code = $this->utilityclass->getPattaTypeNo($ddg->dist_code,$ddg->subdiv_code,$ddg->cir_code,$ddg->mouza_pargona_code,$ddg->lot_no,$ddg->vill_townprt_code, $ddg->dag_no);
                                                    ?>
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $ddg->dag_no . '&m=' . $ddg->mouza_pargona_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_townprt_code . '&p=' . $patta_code->patta_type_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>">
                                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                                                    </a>
                                                    <br>
                                                <?php }?>
                                            </div> -->
                                        </div>
                                            <div>
                                                <input type="hidden" name="ins_cat_type_co_val" id="ins_cat_type_co_val" value="<?=$instituteDetails->ins_cat_type_co?>">
                                            </div>
                                            <div class="row p-2">
                                                <h5 style="color: #ff681d;">Primary Information Entered by CO (চক্ৰ বিষয়া.-ৰ দ্বাৰা প্ৰবিষ্ট কৰা প্ৰাথমিক তথ্য)</h5>
                                                <div class="col-md-6">
                                                   <i class="fa fa-arrow-circle-right"></i> Category
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->category_name))
                                                    {
                                                        echo $instituteDetails->category_name;
                                                    } 
                                                    ?></b>
                                                </div>
                                                    
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                   <i class="fa fa-arrow-circle-right"></i> Name of the institution (English)
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->ins_name_co))
                                                    {
                                                        echo $instituteDetails->ins_name_co;
                                                    } 
                                                    ?>
                                                </b>
                                                </div>
                                                    
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Name of the institution (অসমীয়া)
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->ins_name_assamese))
                                                    {
                                                        echo $instituteDetails->ins_name_assamese;
                                                    } 

                                                    ?>
                                                </b>
                                                </div>
                                                    
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Purpose of which land applied for
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->purpose_land_allot_co))
                                                    {
                                                        echo $instituteDetails->purpose_land_allot_co;
                                                    } 
                                                    else
                                                    {
                                                        echo "NA";
                                                    }
                                                    ?>
                                                    </b>
                                                </div>
                                           
                                                    
                                            </div>
                                            <?php if(isset($instituteDetails->other_purpose_land_allot_co) &&  $instituteDetails->other_purpose_land_allot_co != null){ ?>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Other Purpose details
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->other_purpose_land_allot_co) &&  $instituteDetails->other_purpose_land_allot_co != null)
                                                    {
                                                        echo $instituteDetails->other_purpose_land_allot_co;
                                                    } 
                                                    else
                                                    {
                                                        echo "NA";
                                                    }
                                                    ?>
                                                    </b>
                                                </div>
                                           
                                                    
                                            </div>
                                            <?php } ?>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Sub type details
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->other_subtype_details_co) && $instituteDetails->other_subtype_details_co != null)
                                                    {
                                                        echo $this->utilityclass->ins_sub_type($instituteDetails->other_subtype_details_co);
                                                    } 
                                                    else
                                                    {
                                                        echo "NA";
                                                    }
                                                    ?>
                                                    </b>
                                                </div>
                                           
                                                    
                                            </div>
                                            <?php if($instituteDetails->ministry_of_co != null){ ?>
                                            <div class="col-md-6">
                                                <i class="fa fa-arrow-circle-right"></i>Ministry
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->ministry_of_co) && $instituteDetails->ministry_of_co != null)
                                                    {
                                                        echo $instituteDetails->ministry_of_co;
                                                    }
                                                    else
                                                    {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </b>
                                            </div>
                                            <?php } ?>
                                            
                                            <?php 
                                                $stName = '';
                                                $stNameShowHide = "show";
                                                if($instituteDetails->ins_cat_type_co == 8 || $instituteDetails->ins_cat_type_co == 9)
                                                {
                                                    $stName = "State";
                                                    $stNameShowHide = "show";
                                                }
                                                else if($instituteDetails->ins_cat_type_co == 10 || $instituteDetails->ins_cat_type_co == 11)
                                                {
                                                    $stName = "Central";
                                                    $stNameShowHide = "show";
                                                }
                                                else
                                                {
                                                    $stNameShowHide = "hide";
                                                }
                                            ?>
                                            <div class="row p-2 <?=$stNameShowHide?>">
                                                <div class="col-md-6">
                                                    
                                                    <i class="fa fa-arrow-circle-right"></i><?=$stName?> Department (English)
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->dept_of_co) && $instituteDetails->dept_of_co != null)
                                                    {
                                                        echo $instituteDetails->dept_of_co;
                                                    }
                                                    else
                                                    {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </b>
                                                </div>
                                                    
                                          
                                            <div class="row p-2 <?=$stNameShowHide?>">
                                                <div class="col-md-6">
                                                   <i class="fa fa-arrow-circle-right"></i> <?=$stName?> Department (অসমীয়া)
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->dept_of_co_assamese) && $instituteDetails->dept_of_co_assamese != null)
                                                    {
                                                        echo $instituteDetails->dept_of_co_assamese;
                                                    }
                                                    else
                                                    {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </b>
                                                </div>
                                                    
                                            </div>

                                            <div class="row p-2 <?=$stNameShowHide?>">
                                                <div class="col-md-6">
                                                   <i class="fa fa-arrow-circle-right"></i> <?=$stName?> Directorate Name
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->directorate_name) && $instituteDetails->directorate_name != null)
                                                    {
                                                        echo $instituteDetails->directorate_name;
                                                    }
                                                    else
                                                    {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </b>
                                                </div>
                                                    
                                            </div>
                                            <div class="row p-2 <?=$stNameShowHide?>">
                                                <div class="col-md-6">
                                                   <i class="fa fa-arrow-circle-right"></i> <?=$stName?> Undertaking Board/Corporation Name
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if(isset($instituteDetails->undertaking_board_co) && $instituteDetails->undertaking_board_co != null)
                                                    {
                                                        echo $instituteDetails->undertaking_board_co;
                                                    }
                                                    else
                                                    {
                                                        echo "N/A";
                                                    }
                                                    ?>
                                                </b>
                                                </div>
                                                    
                                            </div>
                                            
                                            <?php if(isset($instituteDetails->state_warehousing_corporation) && ($instituteDetails->state_warehousing_corporation =='N' || $instituteDetails->state_warehousing_corporation == 'Y')){ ?>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals etc. like State Warehousing corporation(SWHC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if($instituteDetails->state_warehousing_corporation == 'Y')
                                                    {
                                                        echo "Yes";
                                                    } 
                                                    else
                                                    {
                                                        echo "No";
                                                    }
                                                    ?>
                                                    </b>
                                                </div>  
                                            </div>
                                            <?php } ?>

                                            <?php if(isset($instituteDetails->central_health_education_skill_sector) && ($instituteDetails->central_health_education_skill_sector =='N' || $instituteDetails->central_health_education_skill_sector == 'Y')){ ?>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development, within the meaning of DoR&DM Office Memorandum  No.ECF.106184/2019/9 dated 07-07-2021
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if($instituteDetails->central_health_education_skill_sector == 'Y')
                                                    {
                                                        echo "Yes";
                                                    } 
                                                    else
                                                    {
                                                        echo "No";
                                                    }
                                                    ?>
                                                    </b>
                                                </div>  
                                            </div>
                                            <?php } ?>

                                            <?php if(isset($instituteDetails->central_cwc_sector) && ($instituteDetails->central_cwc_sector =='N' || $instituteDetails->central_cwc_sector == 'Y')){ ?>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <i class="fa fa-arrow-circle-right"></i> Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals etc. like Food Corporation of India(FCI),Central Warehousing Corporation(CWC) etc which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022
                                                </div>
                                                <div class="col-md-6">
                                                    <b><?php if($instituteDetails->central_cwc_sector == 'Y')
                                                    {
                                                        echo "Yes";
                                                    } 
                                                    else
                                                    {
                                                        echo "No";
                                                    }
                                                    ?>
                                                    </b>
                                                </div>  
                                            </div>
                                            <?php } ?>


                                            
                                        </div>

                                        <?php if(isset($instituteDetails->non_govt_profit_making_yes_no) && $instituteDetails->ins_cat_type_co == 12 && ($instituteDetails->non_govt_profit_making_yes_no =='N' || $instituteDetails->non_govt_profit_making_yes_no == 'Y')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <i class="fa fa-arrow-circle-right"></i> Is the Non Govt. Educational Institution of public nature which is devoted to public purposes and which yield no return to private individuals (non profit making) within the meaning of DoR&DM letter No RSR.9/88/Pt.II/64 dated 25-05-1999.
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->non_govt_profit_making_yes_no == 'Y')
                                                {
                                                    echo "Yes";
                                                } 
                                                else
                                                {
                                                    echo "No";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if(isset($instituteDetails->commercial_purpose_non_govt) && $instituteDetails->ins_cat_type_co == 12 && ($instituteDetails->commercial_purpose_non_govt =='N' || $instituteDetails->commercial_purpose_non_govt == 'Y')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <i class="fa fa-arrow-circle-right"></i> Is the Land applied for used for religious or charitable purposes and other public utilities or amenities - please refer to section 16(e) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->commercial_purpose_non_govt == 'Y')
                                                {
                                                    echo "Yes";
                                                } 
                                                else
                                                {
                                                    echo "No";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if(isset($instituteDetails->commercial_purpose_govt) && $instituteDetails->ins_cat_type_co != 12 && ($instituteDetails->commercial_purpose_govt =='N' || $instituteDetails->commercial_purpose_govt == 'Y')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <i class="fa fa-arrow-circle-right"></i> Is the  land applied for, is or will be used or  transferred for commercial purposes- please refer to section 16(b) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015 
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->commercial_purpose_govt == 'Y')
                                                {
                                                    echo "Yes";
                                                } 
                                                else
                                                {
                                                    echo "No";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->ins_cat_type_co == 12 && ($instituteDetails->purpose_land_allot_co == 'socioculture' || $instituteDetails->purpose_land_allot_co == 'education' || $instituteDetails->purpose_land_allot_co == 'religious')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6" style="color:#ff681d;font-weight:bold">
                                                <i class="fa fa-arrow-circle-right"></i>  Does the Institution fall under category of NGOs, Trusts, Local Bodies, Associations, Societies 
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->under_ngo_trust_localbodies == 'YES')
                                                {
                                                    echo "Yes";
                                                } 
                                                else if($instituteDetails->under_ngo_trust_localbodies == 'NO')
                                                {
                                                    echo "No";
                                                }
                                                else
                                                {
                                                    echo "---";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->ins_cat_type_co == 12 && ($instituteDetails->purpose_land_allot_co == 'socioculture' || $instituteDetails->purpose_land_allot_co == 'education' || $instituteDetails->purpose_land_allot_co == 'religious')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6" style="color:#ff681d;font-weight:bold">
                                                <i class="fa fa-arrow-circle-right"></i> Is the charter of activities are such that the institution considered as educational,religious and socioculture institution ?
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->under_charter_activities == 'YES')
                                                {
                                                    echo "Yes";
                                                } 
                                                else if($instituteDetails->under_charter_activities == 'NO')
                                                {
                                                    echo "No";
                                                }
                                                else
                                                {
                                                    echo "---";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->purpose_land_allot_co == 'education' && $instituteDetails->ins_cat_type_co == 12){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6" style="color:#ff681d;font-weight:bold">
                                                <i class="fa fa-arrow-circle-right"></i>  Is the educational institution non provincialised venture school
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->under_venture_school == 'YES')
                                                {
                                                    echo "Yes";
                                                } 
                                                else if($instituteDetails->under_venture_school == 'NO')
                                                {
                                                    echo "No";
                                                }
                                                else
                                                {
                                                    echo "---";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->purpose_land_allot_co == 'education' && $instituteDetails->ins_cat_type_co == 12){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6" style="color:#ff681d;font-weight:bold">
                                                <i class="fa fa-arrow-circle-right"></i>  Type of venture school
                                            </div>
                                            <div class="col-md-6">
                                                <b><?php if($instituteDetails->venture_type == 'unrecognised_venture')
                                                {
                                                    echo "Unrecognised venture school";
                                                } 
                                                else if($instituteDetails->venture_type == 'govt_aided_venture')
                                                {
                                                    echo "Govt aided venture school (Allotment Only)";
                                                }
                                                else
                                                {
                                                    echo "---";
                                                }
                                                ?>
                                                </b>
                                            </div>  
                                        </div>
                                        <?php } ?>
                                   

                                        <div class="row p-2">
                                            <div class="col-md-9" style="color: red;">
                                                <?=form_error('change_primary_yes_no')?>
                                                <?=form_error('lm_remark_on_co_change')?>
                                                <i class="fa fa-arrow-circle-right"></i><b> Would you like to request for change the CO's primary information after field enquiry by You, mention below </b>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('change_primary_yes_no')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="change_primary_yes_no"
                                                            id="change_primary_yes_no1"
                                                            value="YES"
                                                        <?php if(set_value('change_primary_yes_no') == 'YES'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('change_primary_yes_no')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="change_primary_yes_no"
                                                            id="change_primary_yes_no2"
                                                            value="NO"
                                                        <?php if(set_value('change_primary_yes_no') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="primary_information_change" style="display: none;">

                                            <div class="row p-2">
                                                <div class="col-lg-4">
                                                    <span style="color: red;"><strong><i class="fa fa-angle-double-right"></i></strong> Write your remark (findings after enquiry...)</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control <?php if(form_error('lm_remark_on_co_change')){echo 'lm_invalid';}?>" name="lm_remark_on_co_change" id="lm_remark_on_co_change"><?php if(isset($err_return)){ echo set_value('lm_remark_on_co_change');}?></textarea>
                                                </div>
                                            </div>

                                            <!-- <div class="row p-2">
                                                <b style="color: red;">Note : Premium calculation will be based on your data</b>
                                            </div>
                                            <div class="row p-2">
                                                <div class="col-lg-4">
                                                  <span><strong><i class="fa fa-angle-double-right"></i></strong> Category of non individual juridical entities</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_central_state" id="is_central_state1" value="cent">
                                                        <label class="form-check-label" for="is_central_state1">Central Govt.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_central_state" id="is_central_state0" value="state">
                                                        <label class="form-check-label" for="is_central_state0">State Govt.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="is_central_state" id="is_central_state0" value="pvt">
                                                        <label class="form-check-label" for="is_central_state0">Non Govt. Entity</label>
                                                    </div>
                                                               
                                                </div>
                                            </div> -->
                                            <!-- <div class="row p-2">
                                                <div class="col-lg-4">
                                                    <span><strong><i class="fa fa-angle-double-right"></i></strong> Select Application for</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select class="form-select" name="application_type_state_central" id="application_type_state_central">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row p-2" >
                                                <div class="col-lg-4">
                                                    <strong><i class="fa fa-angle-double-right"></i></strong> Name of the institution
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name_ins_co" value="" class="form-control">
                                                </div>
                                            </div> -->
                                            <!-- <div class="row p-2" >
                                                <div class="col-lg-4">
                                                    <label><strong><i class="fa fa-angle-double-right"></i></strong> Name of the institution (assamese)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name_ins_co_ass" value="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row p-2" id="ins_checking" style="display: none;">
                                                <div class="col-lg-4" id="dept_name_change">
                                                    
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="dept_name_co" value="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row p-2" id="ins_checking_ass" style="display: none;">
                                                <div class="col-lg-4" id="dept_name_change_ass">
                                                    
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="dept_name_ass_co" value="" class="form-control">
                                                </div>
                                            </div> -->

                                            <!-- <div class="row p-2" id="state_govt_undertaking" style="display: none;">
                                                <div class="col-lg-8" id="dept_name_change_ass">
                                                    <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals etc. like State Warehousing corporation(SWHC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022  </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="state_warehousing_corporation"  id="inlineRadio1" value="Y">
                                                        <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="state_warehousing_corporation" id="inlineRadio2" value="N">
                                                        <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- <div class="row p-2" id="central_govt" style="display: none;">
                                                <div class="col-lg-8" id="dept_name_change_ass">
                                                    <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development, within the meaning of DoR&DM Office Memorandum  No.ECF.106184/2019/9 dated 07-07-2021 </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="central_health_education_skill_sector"  id="inlineRadio1" value="Y">
                                                        <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="central_health_education_skill_sector" id="inlineRadio2" value="N">
                                                        <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- <div class="row p-2" id="central_govt_undertaking" style="display: none;">
                                                <div class="col-lg-8" id="dept_name_change_ass">
                                                    <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals etc. like Food Corporation of India(FCI),Central Warehousing Corporation(CWC) etc which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022  </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="central_cwc_sector"  id="inlineRadio1" value="Y">
                                                        <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="central_cwc_sector" id="inlineRadio2" value="N">
                                                        <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- <div class="row p-2" id="non_govt_profit_making" style="display: none;">
                                                <div class="col-lg-8" id="dept_name_change_ass">
                                                    <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Non Govt. Educational Institution of public nature which is devoted to public purposes and which yield no return to private individuals (non profit making) within the meaning of DoR&DM letter No RSR.9/88/Pt.II/64 dated 25-05-1999. </label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="non_govt_profit_making_yes_no"  id="inlineRadio1" value="Y">
                                                        <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="non_govt_profit_making_yes_no" id="inlineRadio2" value="N">
                                                        <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
                                                    </div>
                                                </div>
                                            </div> -->
                                           

                                            <!-- <div class="row p-2">
                                                <div class="col-lg-4" id="">
                                                    <span><strong><i class="fa fa-angle-double-right"></i></strong> Purpose of which land applied for</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="purpose_co" id="purpose_co">
                                                    </select>
                                                </div>
                                            </div> -->

                                            

                                            <!-- <div class="row p-2" id="other_details_div" style="display: none;">
                                                <div class="col-lg-4" id="">
                                                    <span><strong><i class="fa fa-angle-double-right"></i></strong>Enter other details</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="other_details_co" value="" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row p-2" id="sub_type_div" style="display: none;">
                                                <div class="col-lg-4" id="">
                                                    <span><strong><i class="fa fa-angle-double-right"></i></strong>Enter sub type details</span>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="sub_type_lm" value="" class="form-control">
                                                </div>
                                            </div> -->
                                        </div>


                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Whether dag with juridical entity entered in VLB ? </span>

                                                <?=form_error('vlb_verified')?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('vlb_verified')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="vlb_verified"
                                                            id="vlb_verified1"
                                                            value="YES"
                                                        <?php if(set_value('vlb_verified') == 'YES'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('vlb_verified')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="vlb_verified"
                                                            id="vlb_verified2"
                                                            value="NO"
                                                        <?php if(set_value('vlb_verified') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">

                                                <?php
                                                foreach ($dags as $ddg) {
                                                    ?>
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    <a target='VlbReport' href="<?php echo base_url() . 'index.php/SettlementTribal/vlbEncroacherDetails?dag=' . $ddg->dag_no . '&m=' . $ddg->mouza_pargona_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_townprt_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>" target="VlbReport">
                                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (VLB)</span></u>
                                                    </a>
                                                    <br>
                                                <?php }?>
                                            </div> 
                                        </div>


                                        <div class="row p-2">
                                            <div id="vlb_tag_line_lm" style="display: none;">

                                                <?php $show_ap_area = '';
                                                if($ap_area == null)
                                                {
                                                    $show_ap_area = $total_home_bigha. "B-".$total_home_katha." K-".$total_home_lessa."-L";

                                                    if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))):
                                                        $show_ap_area = $show_ap_area. "".$total_home_ganda."G"; 
                                                    endif;

                                                }
                                                else
                                                {
                                                    $show_ap_area = $ap_area;
                                                } 
                                            
                                                ?>
                                                <b style="color: red;font-size: 15px;"><i class="fa fa-angle-double-right"></i> Chitha verified and found required land measuring <?=$show_ap_area?> available for the institution and land is settleable</b>
                                            </div>
                                            <div id="vlb_tag_line_lm_add_dag" style="display: none;">
                                                <?php $show_ap_area = '';
                                                if($ap_area == null)
                                                {
                                                    $show_ap_area = $total_home_bigha. "B-".$total_home_katha." K-".$total_home_lessa."-L";
                                                }
                                                else
                                                {
                                                    $show_ap_area = $ap_area;
                                                } 
                                            
                                                ?>

                                                <b style="color: red;font-size: 15px;"> <i class="fa fa-angle-double-right"></i>Entities should be entered in VLB with suitable dag after joint verification for land measuring <?=$show_ap_area; ?>
                                                 from dag no</b>
                                                 
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Possession Since (dd-mm-yyyy)</label>
                                                <?=form_error('lm_possession_entry')?>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" autocomplete="off" class="form-control <?php if(form_error('lm_possession_entry')){echo 'lm_invalid';}?>" id="lm_possession_entry" placeholder="dd-mm-yyyy" name="lm_possession_entry" value="<?php if(isset($err_return)){ echo set_value('lm_possession_entry');}else{echo $settlement->period_possession;}?>" required="" style="margin-left: 20px;">

                                            </div>
                                        </div>
                                        <div class="row p-2" >
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
                                                            if(set_value('is_tribal_belt') == YES){
                                                                echo "checked";
                                                            }
                                                        }
                                                        ?>

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
                                                            if(set_value('is_tribal_belt') == NO){
                                                                echo "checked";
                                                            }
                                                        }
                                                        ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row p-2">
                                            <div class="col-md-6 text-justify">
                                            <span><strong></strong>
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
                                        </div> -->

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong>Is the land prayed for under landslide prone area?
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

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Whether the land area falls under erosion ?
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

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Whether the land prayed for wetland ?
                                            </span>
                                                <?=form_error('wetland_area')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('wetland_area')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="wetland_area"
                                                            id="landslide"
                                                            value=<?=YES?>
                                                            <?php if(set_value('wetland_area') == YES){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('wetland_area')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="wetland_area"
                                                            id="landslide2"
                                                            value=<?=NO?>
                                                            <?php if(set_value('wetland_area') == NO){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        if($applicants_encroacher == true)
                                        {
                                            foreach($applicants_encroacher as $encroacher_ext){
                                                ?>

                                                <div class="row p-2" >
                                                    <div class="col-md-6">
                                                            <span>
                                                                <strong><?=$sl_count++?>.</strong> 
                                                                Is Encroacher Exists in VLB for <strong><span class="alert-warning">Dag no <?=$encroacher_ext->dag_no?></span></strong>?
                                                            </span>
                                                        <?=form_error('encroacher_exist_vlb'.$encroacher_ext->id)?>

                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select name="encroacher_exist_vlb<?=$encroacher_ext->id?>" id="encroacher_exist_vlb<?=$encroacher_ext->id?>" class="form-control clsencdata <?php if(form_error('encroacher_exist_vlb'.$encroacher_ext->id)){echo 'lm_invalid';}?>">

                                                            <?php
                                                            foreach(json_decode(ENC_VARIFICATION_LIST) as $enc_exist)
                                                            {
                                                                ?>
                                                                <option value="<?=$enc_exist->CODE?>" <?php if(isset($err_return)) {
                                                                    if(set_value('encroacher_exist_vlb'.$encroacher_ext->id) == $enc_exist->CODE){ echo "selected"; }}?>>
                                                                    <?=$enc_exist->NAME?>
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <div class="row p-2">
                                            <div class="col-md-12 <?php if(form_error('encroacher_exist_vlb')){echo 'lm_invalid';}?>">
                                                <strong><?=form_error('encroacher_exist_vlb')?></strong>
                                            </div>
                                        </div>


                                       <div class="row p-2">
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Verify Schedule of the land and area under occupation
                                            </span>
                                                <?=form_error('possession_verification')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('possession_verification')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="possession_verification"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('possession_verification') == 'YES'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('possession_verification')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="possession_verification"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('possession_verification') == 'NO'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        foreach($dags as $nature_dag):
                                            ?>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Nature of possession for Dag no: <?=$nature_dag->dag_no?></span>
                                                <?=form_error('nature_possession'.$nature_dag->dag_no)?>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select
                                                        name="nature_possession<?=$nature_dag->dag_no?>"
                                                        id="nature_possession<?=$nature_dag->dag_no?>"
                                                        class="form-control <?php if(form_error('nature_possession'.$nature_dag->dag_no)){echo 'lm_invalid';}?>"
                                                >
                                                    <option value="Agricultural" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Agricultural') { echo "selected"; }}?>>Agricultural</option>
                                                    <option value="Residential" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Residential') { echo "selected"; }}?>>Residential</option>
                                                    <option value="Commercial" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Commercial') { echo "selected"; }}?>>Commercial</option>
                                                    <option value="Others" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Others') { echo "selected"; }}?>>Others</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <?php
                                        endforeach;
                                        ?>

                                        
                                        
                                        <?php
                                        //include(APPPATH."views/SettlementView/include/settlementPropertyModal.php");
                                        ?>
                                        <?php if(ENABLE_CHECK_LAND != 0) {?>
                                            <!---// Land exist check modal --->
                                            <?php
                                            foreach ($applicants_buyers as $identity){
                                                // if($identity->is_applicant == 1){
                                                //     $identity_type=$identity->identity_type;
                                                //     $identity_ref_no=$identity->identity_ref_no;
                                                // }
                                            }
                                            ?>
                                            <div style="text-align: right">
                                                <?php //include(APPPATH."views/SettlementView/include/landCheck.php"); ?>
                                            </div>

                                            <!---// Land exist check modal end --->
                                        <?php } ?>

                                       

                                        <div class="row p-2">
                                            <div class="col-md-6 text-justify">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Category of the proposed land?
                                            </span>

                                                <?=form_error('land_falls')?>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select name="land_falls" id="land_falls" class="form-control <?php if(form_error('land_falls')){echo 'lm_invalid';}?>">
                                                    <option value="">Select...</option>
                                                    <?php foreach(json_decode(LB_NATURE_OF_RESERVATION_INS) as $landCode): ?>
                                                        <option value="<?php echo $landCode->CODE ?>"

                                                            <?php if(set_value('land_falls') == $landCode->CODE){ echo "selected";} ?>>

                                                            <?php echo $landCode->NAME ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong>.</strong> Whether the proposed land falls within
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
                                        </div> -->

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                                /riverside reservation (if any, along with provision kept for road/drain
                                                wherever necessary)</span>
                                                <?=form_error('roadside_comment_check')?>
                                                <!-- this only to display the error message in area validation -->
                                                <span class="<?php if(form_error('reserveMoreThanAppArea')){echo 'lm_invalid';}?>"></span>
                                                <?=form_error('reserveMoreThanAppArea');?>

                                                <?php
                                                foreach($dags as $dags_roadside){
                                                    echo form_error('reserved_bigha'.$dags_roadside->id);
                                                    echo form_error('reserved_katha'.$dags_roadside->id);
                                                    echo form_error('reserved_lessa'.$dags_roadside->id);
                                                    echo form_error('reserved_ganda'.$dags_roadside->id);
                                                    echo form_error('reserved_kranti'.$dags_roadside->id);
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
                                                <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                                                    <?php foreach($dags as $roadside_dags){ ?>
                                                        <div class="form-group row mt-2">
                                                            <input type="hidden" value="<?=$roadside_dags->dag_no?>" class="form-control input-sm" name="reserved_dag_road<?=$roadside_dags->dag_no?>" id="reserved_dag_road">
                                                            <input type="hidden" value="<?=$roadside_dags->patta_no?>" class="form-control input-sm" name="reserved_patta_road<?=$roadside_dags->dag_no?>" id="reserved_patta_road">
                                                            <label for="area-reserved" class="mb-2"><b>Enter road side reserve area in Dag No: <?=$roadside_dags->dag_no?></b></label>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Bigha</span>
                                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_bigha'.$roadside_dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_bigha'.$roadside_dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_bigha<?=$roadside_dags->dag_no?>" id="reserved_bigha<?=$roadside_dags->dag_no?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Katha</span>
                                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_katha'.$roadside_dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_katha'.$roadside_dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_katha<?=$roadside_dags->dag_no?>" id="reserved_katha<?=$roadside_dags->dag_no?>" >
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="input-group-addon"><?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>  Chatak <?php else :?> Lessa <?php endif ;?></span>
                                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_lessa'.$roadside_dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_lessa'.$roadside_dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_lessa<?=$roadside_dags->dag_no?>" id="reserved_lessa<?=$roadside_dags->dag_no?>" >
                                                            </div>
                                                        </div>
                                                        <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                            <div class="form-group row mt-2">
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Ganda</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_ganda'.$roadside_dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_ganda'.$roadside_dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_ganda<?=$roadside_dags->dag_no?>" id="reserved_ganda<?=$roadside_dags->dag_no?>">
                                                                </div>
                                                                <div class="col-4 hide">
                                                                    <span class="input-group-addon">Kranti</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_kranti'.$roadside_dags->dag_no);}else{echo "0";}?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_kranti'.$roadside_dags->dag_no)){echo 'lm_invalid';}?>" name="reserved_kranti<?=$roadside_dags->dag_no?>" id="reserved_kranti<?=$roadside_dags->dag_no?>">
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

                                        <!-- <div class="row p-2" style="display: none" >
                                            <div class="col-md-6" >
                                            <span>
                                                <strong></strong>
                                                Whether applicant family has occupied any land in the lot?</span>
                                                <?=form_error('family_comment_check')?>
                                                <span class="<?php if(form_error('familyMoreThanAppArea')){echo 'lm_invalid';}?>"></span>
                                                <?=form_error('familyMoreThanAppArea');?>

                                                <?php
                                                foreach($dags as $dags_family){
                                                    echo form_error('reserved_bigha_family'.$dags_family->id);
                                                    echo form_error('reserved_katha_family'.$dags_family->id);
                                                    echo form_error('reserved_lessa_family'.$dags_family->id);
                                                    echo form_error('reserved_ganda_family'.$dags_family->id);
                                                    echo form_error('reserved_kranti_family'.$dags_family->id);
                                                }
                                                ?>



                                            </div>
                                            <div class="col-md-6" >
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" onclick="familyReservYes();" class="form-check-input family_comment_check1 <?php if(form_error('family_comment_check')){echo 'lm_invalid';}?>" name="family_comment_check" id="family_comment_check1" value="<?=YES ?>" <?php if(set_value('family_comment_check') == YES){ echo "checked";} ?>>
                                                    <label for="familyarea">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" checked  onclick="familyReservNo();" class="form-check-input family_comment_check2 <?php if(form_error('family_comment_check')){echo 'lm_invalid';}?>" name="family_comment_check" id="family_comment_check2" value="<?=NO ?>" <?php if(set_value('family_comment_check') == NO){ echo "checked";} ?>>
                                                    <label for="familyarea">No</label>
                                                </div>
                                                <div id="family_reservation_hide" class="family_reservation_hide">
                                                    <?php foreach($dags as $family_dag){ ?>
                                                        <div class="form-group row mt-2">
                                                            <input type="hidden" value="<?=$family_dag->dag_no?>" class="form-control input-sm" name="reserved_dag_family<?=$family_dag->id?>" id="reserved_dag_family">
                                                            <input type="hidden" value="<?=$family_dag->patta_no?>" class="form-control input-sm" name="reserved_patta_family<?=$family_dag->id?>" id="reserved_patta_family<?=$family_dag->id?>">
                                                            <label for="area-reserved" class="mb-2"><b>Reserve family area(will deduct from applied area) in Dag No: <?=$family_dag->dag_no?></b></label>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Bigha</span>
                                                                <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_bigha_family'.$family_dag->id);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_bigha_family'.$family_dag->id)){echo 'lm_invalid';}?>" name="reserved_bigha_family<?=$family_dag->id?>" id="reserved_bigha_family<?=$family_dag->dag_no?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Katha</span>
                                                                <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_katha_family'.$family_dag->id);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_katha_family'.$family_dag->id)){echo 'lm_invalid';}?>" name="reserved_katha_family<?=$family_dag->id?>" id="reserved_katha_family<?=$family_dag->dag_no?>" >
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="input-group-addon"><?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>  Chatak <?php else :?> Lessa <?php endif ;?></span>
                                                                <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_lessa_family'.$family_dag->id);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_lessa_family'.$family_dag->id)){echo 'lm_invalid';}?>" name="reserved_lessa_family<?=$family_dag->id?>" id="reserved_lessa_family<?=$family_dag->dag_no?>" >
                                                            </div>
                                                        </div>
                                                        <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                            <div class="form-group row mt-2">
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Ganda</span>
                                                                    <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_ganda_family'.$family_dag->id);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_ganda_family'.$family_dag->id)){echo 'lm_invalid';}?>" name="reserved_ganda_family<?=$family_dag->id?>" id="reserved_ganda_family<?=$family_dag->dag_no?>">
                                                                </div>
                                                                <div class="col-4 hide">
                                                                    <span class="input-group-addon">Kranti</span>
                                                                    <input type="text" onkeyup="familyAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('reserved_kranti_family'.$family_dag->id);}else{echo "0";}?>" class="form-control input-sm <?php if(form_error('reserved_kranti_family'.$family_dag->id)){echo 'lm_invalid';}?>" name="reserved_kranti_family<?=$family_dag->id?>" id="reserved_kranti_family<?=$family_dag->dag_no?>">
                                                                </div>
                                                            </div>
                                                        <?php endif ;?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div> -->

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


                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Copy of trace map of the proposed land
                                                clearly highlighting the propose land road/riverside reservation etc(if
                                                any)</span>
                                                <?php
                                                foreach($dags as $dags_trace){
                                                    echo form_error('trace_map_copy'.$dags_trace->dag_no);
                                                }?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                foreach($dags as $dags_trace){
                                                    ?>
                                                    <span class="alert-warning">For Dag no. : <strong><?=$dags_trace->dag_no?></strong></span>
                                                    <input type="hidden" name="dag_no_doc<?=$dags_trace->dag_no?>" value="<?=$dags_trace->dag_no?>">
                                                    <input type="file" accept=".png, .jpg, .jpeg, .pdf" name="trace_map_copy<?=$dags_trace->dag_no?>" id="trace_map_copy" class="form-control <?php if(form_error('trace_map_copy'.$dags_trace->id)){echo 'lm_invalid';}?>"
                                                    /><br>

                                                <?php } ?>
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
                                                <div class="row mt-2">
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

                                        <?php
                                        foreach($dags as $landmark_dag):
                                            ?>
                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <label for="">
                                                        <strong><?=$sl_count++?>.</strong>
                                                        Landmark                                                        <span class="alert-warning">for Dag no. <?=$landmark_dag->dag_no?></span>
                                                    </label>
                                                    <?=form_error('landmark_east'.$landmark_dag->dag_no)?>
                                                    <?=form_error('landmark_west'.$landmark_dag->dag_no)?>
                                                    <?=form_error('landmark_north'.$landmark_dag->dag_no)?>
                                                    <?=form_error('landmark_south'.$landmark_dag->dag_no)?>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">East side landmark</label>
                                                    <textarea name="landmark_east<?=$landmark_dag->dag_no?>" placeholder="Enter East Landmark" id="landmark_east<?=$landmark_dag->dag_no?>" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east'.$landmark_dag->dag_no)){echo 'lm_invalid';}?>"><?php echo set_value('landmark_east'.$landmark_dag->dag_no);?></textarea>

                                                    <label for="">West side landmark</label>
                                                    <textarea name="landmark_west<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_west'.$landmark_dag->dag_no)){echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="landmark_west<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php echo set_value('landmark_west'.$landmark_dag->dag_no);?></textarea>

                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">North side landmark</label>
                                                    <textarea name="landmark_north<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_north'.$landmark_dag->dag_no)){echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="landmark_north<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php echo set_value('landmark_north'.$landmark_dag->dag_no);?></textarea>

                                                    <label for="">South side landmark</label>
                                                    <textarea name="landmark_south<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_south'.$landmark_dag->dag_no)){echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="landmark_south<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php echo set_value('landmark_south'.$landmark_dag->dag_no);?></textarea>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach;
                                        ?>

                                        <div class="row p-2 <?php if(form_error('land_exceed')){echo 'lm_invalid';}?>">
                                            <div class="col-md-6">
                                                <?=form_error('land_exceed');?>
                                                <strong><?=$sl_count++?>.</strong> LRA remarks
                                                <?=form_error('lm_note')?>
                                                <?=form_error('lm_remark_text')?>

                                            </div>
                                            <div class="col-md-6">
                                                <!-- <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2"></textarea> -->
                                                <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>">
                                                    <?php
                                                    foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                                                        ?>
                                                        <option value="<?=$lm_remark_cat->CODE?>" <?php if(set_value('lm_note') == $lm_remark_cat->CODE){ echo "selected"; }?>><?=$lm_remark_cat->NAME?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        include(APPPATH."views/SettlementView/include/rejectedReasonsIns.php");
                                        ?>


                                        <div id="lm_remark_text_id" class="row p-2" style="display: none;">
                                            <div class="col-md-12">
                                                <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control p-3 <?php if(form_error('lm_remark_text')){echo 'lm_invalid';}?>" id="lm_remark_text" rows="10" cols="70"><?php echo set_value('lm_remark_text');?></textarea>
                                                <input id="validationcheck" type="hidden" class="validationcheck" value="" name="validationcheck" required/>
                                            </div>
                                        </div>


                                        <div class="row p-2" id="sk_for_reject">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong>
                                                <?php
                                                echo "<label>Select Circle Officer (CO)</label>";
                                                // if(trim($sk_availability) == 'y')
                                                // {
                                                //     echo "<label>Select Supervisor Kanangu (SK)</label>";
                                                // }
                                                // else
                                                // {
                                                //     echo "<label>Select Circle Officer (CO)</label>";
                                                // }
                                                ?>
                                                <?=form_error('co_code')?>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control <?php if(form_error('co_code')) { echo 'lm_invalid';}?>" name='co_code'>

                                                    <?php
                                                    // if($sk_availability == 'y')
                                                    if('1' == '2')
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
                                        <input type="hidden" name="premium_for_settlement_on" id="premium_for_settlement_on" value="<?=PREMIUM_FOR_SETTLEMENT?>">
                                        <input type="hidden" name="non_govt_profit_making_yes_no_val" id="non_govt_profit_making_yes_no_val" value="<?=$instituteDetails->non_govt_profit_making_yes_no?>">

                                        <input type="hidden" name="under_venture_school" id="under_venture_school" value="<?=$instituteDetails->under_venture_school?>">
                                        <input type="hidden" name="venture_type" id="venture_type" value="<?=$instituteDetails->venture_type?>">

                                        <input type="hidden" name="commercial_purpose_non_govt" id="commercial_purpose_non_govt" value="<?=$instituteDetails->commercial_purpose_non_govt?>">

                                        <input type="hidden" name="commercial_purpose_govt" id="commercial_purpose_govt" value="<?=$instituteDetails->commercial_purpose_govt?>">

                                        <input type="hidden" name="purpose_land_allot_co_val" id="purpose_land_allot_co_val" value="<?=$instituteDetails->purpose_land_allot_co?>">

                                        <input type="hidden" name="state_warehousing_corporation" id="state_warehousing_corporation" value="<?=$instituteDetails->state_warehousing_corporation?>">
                                        <input type="hidden" name="central_cwc_sector" id="central_cwc_sector" value="<?=$instituteDetails->central_cwc_sector?>">
                                        <input type="hidden" name="central_health_education_skill_sector" id="central_health_education_skill_sector" value="<?=$instituteDetails->central_health_education_skill_sector?>">

                                        <?php if($instituteDetails->ins_cat_type_co == 12){?>
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <strong><?=$sl_count++?>.</strong> Whether the entity/organization/institution etc is registered under the Societies Registration Act,1860 or under the Assam Cooperative Societies Act,2007(as amended) or under relevant Central or State government Act/Law:
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select name="co_operative_registered" id="co_operative_registered" class="form-select <?php if(form_error('co_operative_registered')) { echo 'lm_invalid';}?>">
                                                    <option value="">---SELECT---</option>
                                                    <option value="N">No</option>
                                                    <option value="Y">Yes</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="row registration_no_details">
                                            <div class="form-group col-md-6 ">
                                                <strong><?=$sl_count++?>.</strong> Registration No.
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" autocomplete="off" class="form-control <?php if(form_error('registration_no')){echo 'lm_invalid';}?>" id="registration_no" placeholder="" name="registration_no" value="<?php if(isset($err_return)){ echo set_value('registration_no');}else{}?>" required="" style="margin-left: 20px;">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <strong><?=$sl_count++?>.</strong> Registration Date.
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" autocomplete="off" class="form-control <?php if(form_error('registration_date')){echo 'lm_invalid';}?>" id="registration_date" placeholder="" name="registration_date" value="<?php if(isset($err_return)){ echo set_value('registration_date');}else{}?>" required="" style="margin-left: 20px;">
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->ins_cat_type_co == 12 && ($instituteDetails->commercial_purpose_non_govt == null || $instituteDetails->commercial_purpose_non_govt == '')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Is the Land applied for used for religious or charitable purposes and other public utilities or amenities - please refer to section 16(e) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015
                                            </div>
                                            <div class="form-group col-md-6">
                                                
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('religious_or_charitable_purposes_reclassification')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="religious_or_charitable_purposes_reclassification"
                                                            id="religious_or_charitable_purposes_reclassification1"
                                                            value="Y"
                                                        <?php if(set_value('religious_or_charitable_purposes_reclassification') == 'Y'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('religious_or_charitable_purposes_reclassification')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="religious_or_charitable_purposes_reclassification"
                                                            id="religious_or_charitable_purposes_reclassification2"
                                                            value="N"
                                                        <?php if(set_value('religious_or_charitable_purposes_reclassification') == 'N'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>  
                                        </div>
                                        <?php } ?>

                                        <?php if($instituteDetails->ins_cat_type_co != 12 && ($instituteDetails->commercial_purpose_govt == null || $instituteDetails->commercial_purpose_govt == '')){ ?>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Is the  land applied for, is or will be used or  transferred for commercial purposes- please refer to section 16(b) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015.
                                            </div>
                                            <div class="form-group col-md-6">
                                                
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('transferred_for_commercial_purposes_reclassification_govt')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="transferred_for_commercial_purposes_reclassification_govt"
                                                            id="transferred_for_commercial_purposes_reclassification_govt1"
                                                            value="Y"
                                                        <?php if(set_value('transferred_for_commercial_purposes_reclassification_govt') == 'Y'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('transferred_for_commercial_purposes_reclassification_govt')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="transferred_for_commercial_purposes_reclassification_govt"
                                                            id="transferred_for_commercial_purposes_reclassification_govt2"
                                                            value="N"
                                                        <?php if(set_value('transferred_for_commercial_purposes_reclassification_govt') == 'N'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>  
                                        </div>
                                        <?php } ?>
                                        

                                        <?php if(PREMIUM_FOR_SETTLEMENT == 1){ ?>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <strong><?=$sl_count++?>.</strong>Is the land applied for already alloted in the name of institution
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <select name="already_alloted" id="already_alloted" class="form-select <?php if(form_error('already_alloted')) { echo 'lm_invalid';}?>">
                                                        <option value="N">No</option>
                                                        <option value="Y">Yes</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="row already_premium_paid_div" style="display: none;">
                                                <div class="form-group col-md-6 ">
                                                    a) Is premium paid during the time of allotment
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <select name="already_premium_paid" id="already_premium_paid" class="form-select">
                                                        <option value="N">No</option>
                                                        <option value="Y">Yes</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row already_premium_amount_div" style="display: none;">
                                                <div class="form-group col-md-6 ">
                                                    b) Enter premium amount
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="number"  name="premium_amount_paid" id="premium_amount_paid"
                                                        class="form-control <?php if(form_error('premium_amount_paid')){echo 'lm_invalid';}?>"
                                                        value="<?php if(isset($err_return)){ echo set_value('premium_amount_paid');}else { echo 0;} ?>" placeholder="Enter premium amount"/>
                                                   
                                                </div>
                                            </div> -->

                                            <div class="row already_premium_paid_div" style="display: none;">
                                                <div class="form-group col-md-6 ">
                                                    a) Date of allotment
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <input type="text" autocomplete="off" class="form-control <?php if(form_error('date_of_allotment')){echo 'lm_invalid';}?>" id="date_of_allotment" placeholder="dd-mm-yyyy" name="date_of_allotment" value="<?php if(isset($err_return)){ echo set_value('date_of_allotment');}else{}?>" required="" style="margin-left: 20px;">
                                                </div>
                                            </div>
                                            <div class="row already_premium_paid_div" style="display: none;">
                                                <div class="form-group col-md-6 ">
                                                    b) is the land used for the actual purposes ?
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                                class="form-check-input <?php if(form_error('actual_purpose_use')){echo 'lm_invalid';}?>"
                                                                type="radio"
                                                                name="actual_purpose_use"
                                                                id="actual_purpose_use1"
                                                                value="YES"
                                                            <?php if(set_value('actual_purpose_use') == 'YES'){ echo "checked";} ?>

                                                        />
                                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                                class="form-check-input <?php if(form_error('actual_purpose_use')){echo 'lm_invalid';}?>"
                                                                type="radio"
                                                                name="actual_purpose_use"
                                                                id="actual_purpose_use2"
                                                                value="NO"
                                                            <?php if(set_value('actual_purpose_use') == 'NO'){ echo "checked";} ?>
                                                        />
                                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                                    </div>
                                                   
                                                </div>
                                            </div>

                                        <?php } ?>


                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Premium</label>
                                                <?=form_error('totaldue')?>
                                                <?=form_error('validationcheck')?>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="rezaButt buttPrimary <?php if(form_error('validationcheck')){echo 'lm_invalid';}?> <?php if(form_error('totaldue')){echo 'lm_invalid';}?>"
                                                        onclick="premiumModal();" id="">
                                                    Calculate Premium
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row p-2" id="premrow" style="display:none">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Premium Amount</label>

                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td width="50%" style="font-weight: bold"> <span>Total Premium (Rs) </span></td>
                                                        <td width="50%" style="font-weight: bold"> <span>Premium Due (Rs) </span></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <span id="lmfinalamount"> </span> </td>
                                                        <td> <span id="lmdueamount"> </span> </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                        include(APPPATH."views/SettlementView/include/addMoreDocumentView.php");
                                        ?>

                                        <!--------------------khas lnd lm report end------>
                                    </div>

                                        <?php
                                        include(APPPATH."views/SettlementView/include/village_wise_area_show_lm_ins.php");
                                        ?>
                                </div>

                            </div>
                            <?php if(ENABLE_BUTTON_LM_FIRST_PROC_SUBMIT_INSTITUTE == 0){?>
                                    <h4>LRA Report button is closed for 3 hour due to some technical enhancement...will be available soon</h4>
                                <?php } ?>
                            <ul class="list-inline pull-right" style="margin-top: 20px">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">
                                        <i class="fa fa-arrow-circle-left"> </i>   Previous
                                    </button>
                                </li>

                                <?php if(ENABLE_BUTTON_LM_FIRST_PROC_SUBMIT_INSTITUTE != 0){?>
                                    <li>
                                        <input type="submit" onClick="this.disabled=true; this.value='Saving...';" value="Save and submit" class="btn btn-primary next-step" id="btnLmSubmit">
                                            <!-- <i class="fa fa-check-square-o"> </i>  Save and submit
                                        </button> -->
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="step4">

                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                <?php echo NJS_TAGLINE ?> (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                            </h5>
                            <div class="reza-card">
                                <div class="reza-body">
                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Remarks Details
                                    </h5>

                                    <div class="tableCard ">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Date of remark</th>
                                                <th>From</th>
                                                <th>Remark</th>
                                            </tr>
                                            <?php $i = 1;foreach ($proceedings as $pro): 
                                            if($pro->office_from == 'LM')
                                            {
                                                $from = 'LRA';
                                            }
                                            else
                                            {
                                                $from = $pro->office_from;
                                            }
                                            ?>
                                                <tr>
                                                <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                                    <td><?=$from;?></td>
                                                    <td><span class="text-success"><?=$pro->note_on_order;?></span></td>
                                                </tr>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right"  style="margin-top: 20px">
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

                        <div class="tab-pane" role="tabpanel" id="history">

                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                <?php echo NJS_TAGLINE ?> (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span>)
                            </h5>
                            <div class="reza-card ">
                                <div class="reza-body">

                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-history" aria-hidden="true"></i> Case History
                                    </h5>

                                    <div class="tableCard ">
                                        <div class="timeline" style="margin-bottom: 15px">

                                            <?php foreach($proceedings as $pro): ?>

                                                <?php if($pro->status == MB_FINAL): ?>

                                                    <div class="timeline__content" style="background-color: #4CAF50">
                                                        <span class="content_tag" style="margin-top: 15px; background-color: white; color: #4CAF50">
                                                            Application Approved
                                                        </span>
                                                        <span class="content_date" style="color: white; margin-top: 7px">
                                                            <?= date ("F j, Y",strtotime($pro->date_entry)) ?>
                                                            <br>
                                                            By <?=$pro->office_from;?>
                                                        </span>
                                                    </div>

                                                <?php elseif($pro->status == MB_DISMISS): ?>

                                                    <div class="timeline__content" style="background-color: #EF5350">
                                                        <span class="content_tag" style="margin-top: 15px; background-color: white; color: #EF5350">
                                                            Application Rejected
                                                        </span>
                                                        <span class="content_date" style="color: white; margin-top: 7px">
                                                           <?= date ("F j, Y",strtotime($pro->date_entry)) ?>
                                                            <br>
                                                             By <?=$pro->office_from;?>
                                                        </span>
                                                    </div>

                                                <?php else : ?>

                                                    <div class="timeline__content" >

                                                        <span class="content_tag" style="background-color: #AB47BC; color: white">
                                                            <?php if($pro->task != ''): ?>
                                                                <?=$pro->task ;?>
                                                            <?php else: ?>
                                                                Not Defined
                                                            <?php endif ?>
                                                        </span>
                                                        <span style="margin-top: 30px"></span>
                                                        <span class="content_date" >
                                                            On <?= date ("F j, Y",strtotime($pro->date_entry)) ?>
                                                        </span>
                                                        <span class="content_Name" >
                                                            By&nbsp;
                                                            <?php if($pro->office_from != ''):
                                                                if($pro->office_from == 'LM')
                                                                {
                                                                    $from = "LRA";
                                                                }
                                                                else
                                                                {
                                                                    $from = $pro->office_from;
                                                                }
                                                             ?>
                                                                <?=$from;?>
                                                            <?php else: ?>
                                                                Not Defined
                                                            <?php endif ?>
                                                        </span>
                                                    </div>

                                                <?php endif; ?>

                                            <?php endforeach; ?>


                                        </div>
                                    </div>

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


                        <!-- new premium addition -->
                        <?php
                            
                            include(APPPATH."views/SettlementView/include/premium_calculation_modal_ins.php");
                            
                            
                        ?>
                        


                        <!-- LM template start -->
                        <?php
                        if($applicants_encroacher == true){
                            foreach($applicants_encroacher as $riotee){
                                $posdate=$riotee->period_possession;
                            }
                        }else{
                            $posdate="";
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

                        foreach ($dags as $dag_urban) {
                            if($dag_urban->is_urban=="Y"){
                                $lmtown="টাউনৰ অন্তৰ্গত ";
                                $lmposession="অনুষ্ঠান ";
                                $lmposdate="২৮ জুন, ২০০১ চনৰ ";
                            }else{
                                $lmtown="";
                                $lmposession="অনুষ্ঠান";
                                $lmposdate=$posdate;
                            }
                        }
                        ?>
                        <?php
                        if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))){
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
                        if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))){
                            $resultdags = array();
                        foreach($applicants_encroacher as $dags_lmtemplate){
                            $resultdags[] = $dags_lmtemplate->dag_no;
                            foreach ($applicants_buyers as $settlement){
                                if($settlement->is_applicant == 1){
                                    $app_name=$settlement->pdar_name;
                                }
                            }?>
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
                                    var mbigha = parseFloat($("#total_applied_home_bigha").val());
                                    var mkatha = parseFloat($("#total_applied_home_katha").val());
                                    var mlessa = parseFloat($("#total_applied_home_lessa").val());
                                    var mganda = parseFloat($("#total_applied_home_ganda").val());
                                    var abigha = parseFloat($("#total_applied_agri_bigha").val());
                                    var akatha = parseFloat($("#total_applied_agri_katha").val());
                                    var alessa = parseFloat($("#total_applied_agri_lessa").val());
                                    var aganda = parseFloat($("#total_applied_agri_ganda").val());
                                    var total_home = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
                                    var total_agri = ((abigha * 6400) + (akatha * 320) + (alessa * 20) + aganda);
                                    var total_area = total_home + total_agri;


                                    //   var bigha_r = Math.floor(total_area / 100);
                                    //   var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                                    //   var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

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
                                    <?php foreach($applicants_encroacher as $dags_lmtemplate3){ ?>

                                    var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_ganda=$("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=0;
                                    var family_katha=0;
                                    var family_lessa=0;
                                    var family_ganda=0;
                                    total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                                    total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                                    <?php } ?>

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
                        $all_dags=implode(",",$resultdags); ?>
                        <?php } else{
                        $resultdags = array();
                        foreach($applicants_encroacher as $dags_lmtemplate){
                        $resultdags[] = $dags_lmtemplate->dag_no;
                        foreach ($applicants_buyers as $settlement){
                            if($settlement->is_applicant == 1){
                                $app_name=$settlement->pdar_name;
                            }
                        } ?>
                        <input type="hidden" id="sbigha" name='sbigha'>
                        <input type="hidden" id="skatha" name='skatha'>
                        <input type="hidden" id="slessa" name='slessa'>
                        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                        <input type="hidden" id="alloted_katha" name='alloted_katha'>
                        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
                            <script>
                                function totalAppliedArea(){
                                    var total_area = 0;
                                    var mbigha = parseFloat($("#total_applied_home_bigha").val());
                                    var mkatha = parseFloat($("#total_applied_home_katha").val());
                                    var mlessa = parseFloat($("#total_applied_home_lessa").val());
                                    var abigha = parseFloat($("#total_applied_agri_bigha").val());
                                    var akatha = parseFloat($("#total_applied_agri_katha").val());
                                    var alessa = parseFloat($("#total_applied_agri_lessa").val());
                                    var total_home = ((mbigha * 100) + (mkatha * 20) + mlessa);
                                    var total_agri = ((abigha * 100) + (akatha * 20) + alessa);
                                    var total_area = total_home + total_agri;


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
                                    <?php foreach($applicants_encroacher as $dags_lmtemplate3){ ?>
                                    var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=0;
                                    var family_katha=0;
                                    var family_lessa=0;
                                    total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                                    total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                                    <?php } ?>
                                    // alert(total_lm_family_reserved);
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
                            $all_dags=implode(",",$resultdags);
                        }
                        ?>
                        <!-- LM template end -->
                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>
<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
<!-- add Encroacher modal -->


<script>

    $(document).ready(function () {
        totalAreaCal();

        var selectedRemarkCode=$('#lm_remark').val();
        if(selectedRemarkCode == 1){
            <?php
            if(isset($err_return)){
            ?>
            $('#lm_remark_text_id').show();
            <?php
            }
            ?>
        }
        if(selectedRemarkCode == 2){
            <?php
            if(isset($err_return)){
            ?>
            $('#lm_remark_text_id').show();
            <?php
            }
            ?>
        }
    });

    $(document).on('change','#co_operative_registered',function (e)
    {
        e.preventDefault();
        var co_operative_registered = $("#co_operative_registered").val();
        $('.registration_no_details').hide();
        if(co_operative_registered == 'Y')
        {
            $('.registration_no_details').show();
        }
        else
        {
            $('.registration_no_details').hide();
        }

    });

    $(document).on('change','#already_alloted',function (e)
    {

        e.preventDefault();
        $("#finalamount").val('');
        $("#totaldue").val('');
        var already_alloted = $("#already_alloted").val();
        $('.already_premium_paid_div').hide();
        if(already_alloted == 'Y')
        {
            $('.already_premium_paid_div').show();
        }

    });

    

    $(document).on('change','#already_premium_paid',function (e)
    {
        e.preventDefault();
        var already_premium_paid = $("#already_premium_paid").val();
        $('.already_premium_amount_div').hide();
        if(already_premium_paid == 'Y')
        {
            $('.already_premium_amount_div').show();
        }

    });

    $("#lm_remark").change(function (event) {

        var selectedRemark=$(this).val();
        if(selectedRemark==1){
            $('#lm_remark_text_id').show();
            totalAppliedArea();
            $('#lm_remark_text').text('');

            <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী <?php echo $instituteDetails->ins_name_assamese; ?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  ত ভূমি আৱণ্টন বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে উক্ত মাটি "+$('#lm_possession_entry').val()+"  ৰ দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            // $('#lm_remark_text').append("\n \n  আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা প্ৰতিষ্ঠান হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি ও চৰকাৰ ৰ সেহতীয়া নিৰ্দেশ মতে আৱণ্টন যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ আৱণ্টন দিব পৰা যায়।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী  <?php echo $instituteDetails->ins_name_assamese; ?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  ত ভূমি আৱণ্টন বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ উক্ত মাটি "+$('#lm_possession_entry').val()+"  ৰ সময়ত আবেদনকাৰীয়ে দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            
            // $('#lm_remark_text').append("\n \n  আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক হয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি ও চৰকাৰ ৰ সেহতীয়া নিৰ্দেশ মতে আৱণ্টন যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে আৱণ্টন দিব পৰা যায়।");
            <?php endif ;?>
            // var lm_yes=$('#lm_template_yes').val();
            // $("textarea#lm_remark_text").val(lm_yes);


        }else if(selectedRemark==2){

            $('#lm_remark_text_id').show();
            // var lm_no=$('#lm_template_no').val();
            // $("textarea#lm_remark_text").val(lm_no);
            totalAppliedArea();
            $('#lm_remark_text').text('');
            <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী <?php echo $instituteDetails->ins_name_assamese; ?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  ত ভূমি আৱণ্টন বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত উক্ত মাটি "+$('#lm_possession_entry').val()+"  ৰ আবেদনকাৰীয়ে দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            // $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা নহয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি ও চৰকাৰ ৰ সেহতীয়া নিৰ্দেশ মতে আৱণ্টন যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ আৱণ্টন দিব পৰা নাযায়।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী <?php echo $instituteDetails->ins_name_assamese; ?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  ত ভূমি আৱণ্টন বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত উক্ত মাটি "+$('#lm_possession_entry').val()+"  ৰ আবেদনকাৰীয়ে কৰি দখলকৰি থকা দেখা গল।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            // $('#lm_remark_text').append("\n \n  আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক নহয়। ");
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি ও চৰকাৰ ৰ সেহতীয়া নিৰ্দেশ মতে আৱণ্টন যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে আৱণ্টন দিব পৰা নাযায়।");
            <?php endif ;?>

        }else{
            $('#lm_remark_text').text('');
            $('#lm_remark_text_id').hide();

        }
    });


</script>
<!-- Encroacher modal -->
<script src="<?php echo base_url();?>js/jAlert-v3.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jAlert-v3.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<!-- css for datatable -->
<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>
<script>
    $(function () {
        $('#lm_possession_entry').datepick({dateFormat: 'dd-mm-yyyy'});
        $('#date_of_allotment').datepick({dateFormat: 'dd-mm-yyyy'});
        $('#registration_date').datepick({dateFormat: 'dd-mm-yyyy'});
    });
    // $(function () {
    //     $('#popupDatepicker1').datepick({dateFormat: 'dd-mm-yyyy'});
    // });
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


<script>
    $('.primary_information_change').hide();
    $("input:radio[name=vlb_verified]").click(function() {

        var checkVal = $('input:radio[name=vlb_verified]:checked').val();
        if(checkVal == 'YES')
        {
            $('#vlb_tag_line_lm').show();
            $('#vlb_tag_line_lm_add_dag').hide();
        }
        else
        {
            $('#vlb_tag_line_lm_add_dag').show();
            $('#vlb_tag_line_lm').hide();
        }
        
    });


    $("input:radio[name=change_primary_yes_no]").click(function() {

        var checkVal = $('input:radio[name=change_primary_yes_no]:checked').val();
        if(checkVal == 'YES')
        {
            $('.primary_information_change').show();
        }
        else
        {
            $('.primary_information_change').hide();
        }
        
    });




    <?php
    if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))){
    ?>
    function totalAreaCal(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        // for(i=1; i<length; i++){
            // var mbigha = parseFloat($("#mbigha"+i).val());
            // var mkatha = parseFloat($("#mkatha"+i).val());
            // var mlessa = parseFloat($("#mlessa"+i).val());
            // var mganda = parseFloat($("#mganda"+i).val());
            var mbigha = parseFloat($("#total_applied_home_bigha").val());
            var mkatha = parseFloat($("#total_applied_home_katha").val());
            var mlessa = parseFloat($("#total_applied_home_lessa").val());
            var mganda = parseFloat($("#total_applied_home_ganda").val());

            var total_area = total_area + ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
        // }

        var bigha_r = Math.floor(total_area / 6400);
        var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
        var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
        var ganda_r = total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);
        $("#total_applied_home_ganda").val(ganda_r);
    }

    // function agriArea(){
    //     $('#totaldue').val('');
    //     $('#validationcheck').val('');
    //     $('#lm_remark_text').text('');
    //     $('#lm_remark').val('');
    //     $('.totalamount').val('');
    //     // for agri
    //     var bigha_agri = 0;
    //     var katha_agri = 0;
    //     var lessa_agri = 0;
    //     var length_agri = <?=$total_area_agri_bigha?>;
    //     var total_agri_area = 0;
    //     for(i=1; i<length_agri; i++){
    //         var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
    //         var mkatha_agri = parseFloat($("#agri_katha"+i).val());
    //         var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
    //         var mganda_agri = parseFloat($("#agri_ganda"+i).val());

    //         var total_agri_area = total_agri_area + ((mbigha_agri * 6400) + (mkatha_agri * 320) + (mlessa_agri * 20) + mganda_agri);
    //     }

    //     var bigha_agri = Math.floor(total_agri_area / 6400);
    //     var katha_agri = Math.floor((total_agri_area - bigha_agri * 6400) / 320);
    //     var lessa_agri = Math.floor((total_agri_area - (bigha_agri * 6400) - (katha_agri * 320)) / 20);
    //     var ganda_agri = total_agri_area - bigha_agri * 6400 - katha_agri * 320 - lessa_agri * 20;

    //     $("#total_applied_agri_bigha").val(bigha_agri);
    //     $("#total_applied_agri_katha").val(katha_agri);
    //     $("#total_applied_agri_lessa").val(lessa_agri);
    //     $("#total_applied_agri_ganda").val(ganda_agri);
    // }

    // function fisheryArea(){
    //     // for agri
    //     var bigha_fish = 0;
    //     var katha_fish = 0;
    //     var lessa_fish = 0;
    //     var length_fish = <?=$total_area_fbigha?>;
    //     var total_fish_area = 0;
    //     for(i=1; i<length_fish; i++){
    //         var mbigha_fish = parseFloat($("#fbigha"+i).val());
    //         var mkatha_fish = parseFloat($("#fkatha"+i).val());
    //         var mlessa_fish = parseFloat($("#flessa"+i).val());
    //         var mganda_fish = parseFloat($("#fganda"+i).val());

    //         var total_fish_area = total_fish_area + ((mbigha_fish * 6400) + (mkatha_fish * 320) + (mlessa_fish * 20) + mganda_fish);
    //     }

    //     var bigha_fish = Math.floor(total_fish_area / 6400);
    //     var katha_fish = Math.floor((total_fish_area - bigha_fish * 6400) / 320);
    //     var lessa_fish = Math.floor((total_fish_area - (bigha_fish * 6400) - (katha_fish * 320)) / 20);
    //     var ganda_fish = total_fish_area - bigha_fish * 6400 - katha_fish * 320 - lessa_fish * 20;

    //     $("#total_applied_fbigha").val(bigha_fish);
    //     $("#total_applied_fkatha").val(katha_fish);
    //     $("#total_applied_flessa").val(lessa_fish);
    //     $("#total_applied_fganda").val(ganda_fish);
    // }

    <?php
    }else{?>
    function totalAreaCal(){
        // alert('d');
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        // for(i=1; i<length; i++){
            // var mbigha = parseFloat($("#mbigha"+i).val());
            // var mkatha = parseFloat($("#mkatha"+i).val());
            // var mlessa = parseFloat($("#mlessa"+i).val());
            var mbigha = parseFloat($("#total_applied_home_bigha").val());
            var mkatha = parseFloat($("#total_applied_home_katha").val());
            var mlessa = parseFloat($("#total_applied_home_lessa").val());
            var total_area = total_area + ((mbigha * 100) + (mkatha * 20) + mlessa);
        // }

        var bigha_r = Math.floor(total_area / 100);
        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);

    }

    // function agriArea(){
    //     $('#totaldue').val('');
    //     $('#validationcheck').val('');
    //     $('#lm_remark_text').text('');
    //     $('#lm_remark').val('');
    //     $('.totalamount').val('');
    //     // for agri
    //     var bigha_agri = 0;
    //     var katha_agri = 0;
    //     var lessa_agri = 0;
    //     var length_agri = <?=$total_area_agri_bigha?>;
    //     var total_agri_area = 0;
    //     for(i=1; i<length_agri; i++){
    //         var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
    //         var mkatha_agri = parseFloat($("#agri_katha"+i).val());
    //         var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
    //         var total_agri_area = total_agri_area + ((mbigha_agri * 100) + (mkatha_agri * 20) + mlessa_agri);
    //     }
    //     // alert(total_agri_area);
    //     var bigha_agri = Math.floor(total_agri_area / 100);
    //     var katha_agri = Math.floor((total_agri_area - bigha_agri * 100) / 20);
    //     var lessa_agri = total_agri_area - bigha_agri * 100 - katha_agri * 20;

    //     $("#total_applied_agri_bigha").val(bigha_agri);
    //     $("#total_applied_agri_katha").val(katha_agri);
    //     $("#total_applied_agri_lessa").val(lessa_agri);
    // }

    // function fisheryArea(){
    //     // for agri
    //     var bigha_fish = 0;
    //     var katha_fish = 0;
    //     var lessa_fish = 0;
    //     var length_fish = <?=$total_area_fbigha?>;
    //     var total_fish_area = 0;
    //     for(i=1; i<length_fish; i++){
    //         var mbigha_fish = parseFloat($("#fbigha"+i).val());
    //         var mkatha_fish = parseFloat($("#fkatha"+i).val());
    //         var mlessa_fish = parseFloat($("#flessa"+i).val());
    //         var total_fish_area = total_fish_area + ((mbigha_fish * 100) + (mkatha_fish * 20) + mlessa_fish);
    //     }
    //     // alert(total_fish_area);
    //     var bigha_fish = Math.floor(total_fish_area / 100);
    //     var katha_fish = Math.floor((total_fish_area - bigha_fish * 100) / 20);
    //     var lessa_fish = total_fish_area - bigha_fish * 100 - katha_fish * 20;

    //     $("#total_applied_fbigha").val(bigha_fish);
    //     $("#total_applied_fkatha").val(katha_fish);
    //     $("#total_applied_flessa").val(lessa_fish);
    // }

    <?php }?>

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


    $(document).ready(function(){

        var roadside_comment_check1 = $("input[name='roadside_comment_check']:checked").val();
        var roadside_reservation = document.getElementById("road_side_reservation_hide");

        if(roadside_comment_check1 == 'YES'){
            roadside_reservation.style.display = "block";
        }

        // // Add new element
        $(".add").click(function(){

            // Finding total number of elements added
            var total_element = $(".element").length;

            // last <div> with element class id
            var lastid = $(".element:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 35;
            // Check total number elements
            if(total_element < max ){
                // Adding new div container after last occurance of element class
                $(".element:last").after("<div class='element' id='div_"+ nextindex +"'></div>");

                // Adding element to <div>
                $("#div_" + nextindex).append("<table class='table table-bordered' id='applicantrow_"+ nextindex +"'> <tr> <th rowspan='5' style='vertical-align : middle;text-align:center;'>1</th> <th>Name of the applicant</th> <td> <input type='text' placeholder='Enter name' name='pdar_name2[]' required class='form-control input-sm'> </td> <th>Guardian name</th> <td> <input placeholder='Enter guardian' type='text' name='pdar_guardian2[]' required class='form-control input-sm' > </td> <th>DOB</th><td><input type='date' class='form-control' name='dob2[]'></td> </tr> <tr> <th>Relation</th> <td> <select name='pdar_rel_guar2[]' id='pdar_rel_guar"+ nextindex +"' class='form-control' required> <option value='1' >Mother</option> <option value='2' selected>Father</option> <option value='3' >Husband</option> <option value='4' >Wife</option> <option value='5' >Guardian</option> <option value='6' >Supdt.Mother</option> <option value='7' >Guardian</option> </select> </td> <th>Gender</th> <td> <select name='pdar_gender2[]' id='pdar_gender"+ nextindex +"' class='form-control' > <option value='1' selected>Male</option> <option value='2' >Female</option> <option value='3' >Others</option> </select> </td> <th>Mobile</th> <td> <input type='text' placeholder='Enter mobile no' name='pdar_mobile2[]' class='form-control input-sm' > </td> </tr> <tr> <th> Permanent address </th> <td colspan='2'> <input type='text' placeholder='Enter permanent address' name='pdar_add12[]' class='form-control input-sm'> </td> <th>Present address</th> <td colspan='2'> <input placeholder='Enter present address' type='text' name='pdar_add22[]' class='form-control input-sm' > </td> </tr><tr><td><span id='remove_" + nextindex + "' class='remove'><i class='fa fa-trash-o' style='font-size:32px;color:red'></i></span></td></tr> </table>&nbsp;");

            }

        });

        // Remove element
        $('.container').on('click','.remove',function(){

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
            // Remove <div> with id
            $("#div_" + deleteindex).remove();
        });

        $(document).on('click', '.delete', function()
        {
            id = $(this).attr('id');
            if($('#del_fpart_appl').val()=='')
            {
                $('#del_fpart_appl').val(id);
            }
            else
            {
                $('#del_fpart_appl').val($('#del_fpart_appl').val()+', '+id);
            }
        });


        // Remove element
        $('.delete').on('click',function(){
            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
            // Remove <div> with id
            $("#applicantrow_" + deleteindex).remove();
        });

    });



    //// premium code

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var premModal = document.getElementById("premiumModal");
    function premiumModal()
    {
        $('.totalamount').val('');
        $(".premhide").hide();
        var settlement_premium_const = <?=PREMIUM_FOR_SETTLEMENT?>;
        var ins_cat_type_co_val = $('#ins_cat_type_co_val').val();
        var purpose_land_allot_co_val = $('#purpose_land_allot_co_val').val();
        //////reclassification required or not///////
        var commercial_purpose_non_govt = null;
        var commercial_purpose_govt = null;
        // alert($('#commercial_purpose_non_govt').val());
        if(ins_cat_type_co_val == 12)
        {
            commercial_purpose_non_govt = $('#commercial_purpose_non_govt').val();
            if(commercial_purpose_non_govt == null || commercial_purpose_non_govt == '')
            {
                
                var commercial_purpose_non_govt_new = $('input:radio[name=religious_or_charitable_purposes_reclassification]:checked').val();
               
                if(commercial_purpose_non_govt_new == null || commercial_purpose_non_govt_new == '')
                {
                    alert('#ERR 3772 :Is the Land applied for used for religious or charitable purposes and other public utilities or amenities ...');
                    return false;
                }
                else
                {
                    commercial_purpose_non_govt = commercial_purpose_non_govt_new;
                }
            }
        }
        else
        {
            commercial_purpose_govt = $('#commercial_purpose_govt').val();
            if(commercial_purpose_govt == null || commercial_purpose_govt == '')
            {
               
                var commercial_purpose_govt_new = $('input:radio[name=transferred_for_commercial_purposes_reclassification_govt]:checked').val();
                if(commercial_purpose_govt_new == null || commercial_purpose_govt_new == '')
                {
                    alert('#ERR 3772 : Is the  land applied for, is or will be used or  transferred for commercial purposes...');
                    return false;
                }
                else
                {
                    commercial_purpose_govt = commercial_purpose_govt_new;
                }
            }
        }
        if(ins_cat_type_co_val != 12 && (commercial_purpose_govt == null || commercial_purpose_govt == ''))
        {
            alert('Some data missing, kindly reload this page...');
            return false;
        }

        if(ins_cat_type_co_val == 12 && (commercial_purpose_non_govt == null || commercial_purpose_non_govt == ''))
        {
            alert('Some data missing, kindly reload this page...');
            return false;
        }

        $('.reclass_prem').show();
        $('.reclass_prem_used').hide();
        var reclassification_amount_used_or_not = 'N';
        if(settlement_premium_const == 1)
        {
            var already_alloted = $('#already_alloted').val();
            if((already_alloted == null || already_alloted == undefined) && (ins_cat_type_co_val == null || ins_cat_type_co_val == ''))
            {
                alert('Some data missing, kindly reload this page...');
                return false;
            }
        }
        
        premModal.style.display = "block";
        // When the user clicks on <span> (x), close the modal
        if(settlement_premium_const == 1)
        {
            if((already_alloted == 'Y' || already_alloted == 'N') && ins_cat_type_co_val == 8)
            {
                $('.reclass_prem').show();
                $('.reclass_prem_used').hide();
                $('#reclassification_amount_used_or_not').val(reclassification_amount_used_or_not);

            }
            else if(already_alloted == 'Y' && ins_cat_type_co_val == 9)
            {
                if(commercial_purpose_govt == 'Y')
                {
                    $('.reclass_prem').show();
                    $('.reclass_prem_used').show();
                    $('#reclassification_amount_used_or_not').val('Y');
                }
                else
                {
                    $('.reclass_prem').show();
                    $('.reclass_prem_used').hide();
                    $('#reclassification_amount_used_or_not').val('N');
                }
                
            }
            else if(already_alloted == 'N' && ins_cat_type_co_val == 9)
            {
                $('.reclass_prem').show();
                $('.reclass_prem_used').hide();
                $('#reclassification_amount_used_or_not').val('N');
            }
            else if((already_alloted == 'N' || already_alloted == 'Y') && (ins_cat_type_co_val == 10 || ins_cat_type_co_val == 11))
            {
                // $('.reclass_prem').show();
                if(commercial_purpose_govt == 'Y')
                {
                    $('.reclass_prem').show();
                    $('.reclass_prem_used').show();
                    $('#reclassification_amount_used_or_not').val('Y');
                }
                else
                {
                    $('.reclass_prem').show();
                    $('.reclass_prem_used').hide();
                    $('#reclassification_amount_used_or_not').val('N');
                }
            }
            else if(already_alloted == 'Y' && ins_cat_type_co_val == 12 && (purpose_land_allot_co_val=='socioculture' || purpose_land_allot_co_val=='education' || purpose_land_allot_co_val=='religious'))
            {
                if(commercial_purpose_non_govt =='N')
                {
                    $('.reclass_prem').show();
                    $('.reclass_prem_used').show();
                    $('#reclassification_amount_used_or_not').val('Y');
                }
                else
                {
                    $('.reclass_prem').show();
                    $('.reclass_prem_used').hide();
                    $('#reclassification_amount_used_or_not').val('N');
                }

                
            }
            else
            {
                $('.reclass_prem').show();
                $('.reclass_prem_used').hide();
                $('#reclassification_amount_used_or_not').val('N');
            }
        }
        if(settlement_premium_const == 0)
        {
            if(ins_cat_type_co_val == 10 || ins_cat_type_co_val == 11)
            {
                $('.reclass_prem').show();
                $('.reclass_prem_used').show();
                $('#reclassification_amount_used_or_not').val('Y');
            }
            else
            {
                $('.reclass_prem').show();
                $('.reclass_prem_used').hide();
                $('#reclassification_amount_used_or_not').val('N');
            }
        }
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
            $("#lmfinalamount").text(totaldue);
            $("#lmdueamount").text(totaldue);
        }
        else {
            if (modeValue == "NO") {
                var totaldue= $("#finalamount").val();
                var discount = 30;
                var finaldue = Math.ceil(totaldue * discount / 100);
                $("#totaldue").val(finaldue);
                $("#lmfinalamount").text(totaldue);
                $("#lmdueamount").text(finaldue);
            }
        }

    });

    $("#finalsubmit").click(function(){
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
            if ($(this).val().length === 0) {
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
                sum = '';
                return false;
            }else{
                sum += +$(this).val();
            }
            
        });
        $(".premhide").show();
        $("#finalsubmit").hide();
        $("#finalsave").show();
        $("#closePremium").show();

        $("#finalamount").val(sum);
        $("#totaldue").val(sum);
        $("#paymode1").prop( "checked", true );
        // premModal.style.display = "none";
        $("#premrow").show();
        $("#lmfinalamount").text(sum);
        $("#lmdueamount").text(sum);
    });

    $("#finalsave").click(function(){
        if (!$('#finalamount').val()) {
            alert("Final Amount Can't be blak !!!");
            return;
        }
        $("#premrow").show();
        premModal.style.display = "none";
    });

    $("input[name=prem_update").on("click", function () {

        var selectedValue3 = $("input[name=prem_update]:checked").val();
        if (selectedValue3 == "YES") {

            $("#chngPremButton").show();
            // if($("#textField").val()==null){
            //     alert("Please select premium before proceed!!!");
            //     return false;
            // }

        }
        else {
            if (selectedValue3 == "NO") {
                $("#chngPremButton").hide();

            }
        }

    });

    function reset(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        $("#lmfinalamount").text('');
        $("#lmdueamount").text('');

    }

    function roadAreaCheck(){
        reset();

    }

    function familyAreaCheck(){
        reset();
    }

    //// premium code end


</script>

<script>
    function roadSideReservYes() {
        $('#road_side_reservation_hide').show();
        $('.reserved_road_value').val(0);
    }

    function roadSideReservNo() {
        $('#road_side_reservation_hide').hide();
        $('.road_reserve_ifno_zero').val(0);
        $('.reserved_road_value').val(0);
        reset();
    }

    $(document).ready(function(){
        var roadside_val = $("input[name='roadside_comment_check']:checked").val();
        if(roadside_val == 'YES'){
            $('#road_side_reservation_hide').show();
        }

        if(roadside_val == 'NO'){
            $('#road_side_reservation_hide').hide();
        }
    })

    function forcedUrban(val) {
        if (val == "YES") {
            $("#forcedurban").show();
        } else {
            $("#forcedurban").hide();
        }
    }
</script>
<script>
    $('#road_side_reservation_hide').hide();
    $('#family_reservation_hide').hide();
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

</script>

<!-- additional errors check  -->
<script>
    $('#additionalErrors').on('click',function(){
        $(this).next('#additional_errors_collapse').slideToggle();
    });

    $('#btnLmSubmit').on('click',function(e){
        e.preventDefault();
        var form = $('.lmForm');
        var encData;
        var encDataAll =[];

        <?php
        if($applicants_encroacher == true)
        {
        foreach($applicants_encroacher as $encroacher_ext){
        ?>
        $(".clsencdata").each(function () {
            encData = "Dag No: "+'<?=$encroacher_ext->dag_no?>'+ " : " + $('#encroacher_exist_vlb<?=$encroacher_ext->id?> option:selected').text();
            // var encDagno= $(this).attr("data-id");
            // var encDagno =  $(this).attr("data-id");
            // var enchDataAll="Dag No: "+encDagno+ "; Encroacher Exists in VLB: " +encData;
            // alert( encData );
        })
        // alert( encData );
        encDataAll.push(encData);

        <?php } } ?>


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
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
                    html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
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
                    $('#btnLmSubmit').prop('disabled', false);
                    $('#btnLmSubmit').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnLmSubmit').prop('disabled', false);
                $('#btnLmSubmit').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnLmSubmit').prop('disabled', false);
            $('#btnLmSubmit').val('Save and submit');
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                // 'error'
            )
        }
    })
    });

</script>


<script src="<?php echo base_url();?>js/mb2/notify.js"></script>

<?php include(APPPATH."views/SettlementView/include/addEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/mb2/addEncroacher.js"></script>

<?php include(APPPATH."views/SettlementView/include/editEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editEncroacher.js"></script>

<?php include(APPPATH."views/SettlementView/include/changeEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/mb2/changeEncroacher.js"></script>

<?php include(APPPATH."views/SettlementView/include/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editApplicantDetails.js"></script>


<?php include(APPPATH."views/SettlementView/include/editAreaDetailsNew.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editAreaDetailsNew.js"></script>

<?php include(APPPATH."views/SettlementView/include/editFamilyDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editFamilyDetails.js"></script>

<?php include(APPPATH."views/SettlementView/include/addApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/addApplicantDetails.js"></script>


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

<script>

    $(document).ready(function(){
        showInsDetails();
    });

    function showInsDetails(){
        var case_no = $('#case_no').val();
        $.ajax({
            url: '<?=base_url()?>index.php/SettlementInstitutionCo/getInstitutionDetails',
            type: 'POST',
            data: {case_no: case_no},
            success: function(data){
                $('#ins_data_render_id').html(data);
            }
        });
    }
</script>
<script type="text/javascript">
    $('#ins_checking').hide();
    $('#ins_checking_ass').hide();
    $('#state_govt_undertaking').hide();
    $('#central_govt_undertaking').hide();
    
    $('#application_type_state_central').change(function (e) {
        e.preventDefault()
        $('#ins_checking').show();
        $('#ins_checking_ass').show();
        var ins_id = $(this).val();
        if(ins_id == 8)
        {
            $('#dept_name_change').html("<strong><i class='fa fa-angle-double-right'></i></strong> Name of the department");
            $('#dept_name_change_ass').html("<label><strong><i class='fa fa-angle-double-right'></i></strong> Name of the department (assamese)</label>");
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#non_govt_profit_making').hide();
            $('#central_govt').hide();
            var allotment_purpose = <?php echo json_encode(STATE_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html='';
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else if(ins_id == 9)
        {
            $('#dept_name_change').html("<strong><i class='fa fa-angle-double-right'></i></strong> Name of Board/Corporation/Govt. company");
            $('#dept_name_change_ass').html("<label><strong><i class='fa fa-angle-double-right'></i></strong> Name of Board/Corporation/Govt. company (assamese)</label>");
            $('#state_govt_undertaking').show();
            $('#central_govt_undertaking').hide();
            $('#non_govt_profit_making').hide();
            $('#central_govt').hide();
            var allotment_purpose = <?php echo json_encode(STATE_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html='';
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else if(ins_id == 10)
        {
            $('#dept_name_change').html("<strong><i class='fa fa-angle-double-right'></i></strong> Name of the department/ministry");
            $('#dept_name_change_ass').html("<label><strong><i class='fa fa-angle-double-right'></i></strong> Name of the department/ministry (assamese)</label>");
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#central_govt').show();
            $('#non_govt_profit_making').hide();
            var allotment_purpose = <?php echo json_encode(CENTRAL_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html='';
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);

        }
        else if(ins_id == 11)
        {
            $('#dept_name_change').html("<strong><i class='fa fa-angle-double-right'></i></strong> Name of the Board/Corporation/Central Govt. Company");
            $('#dept_name_change_ass').html("<label><strong><i class='fa fa-angle-double-right'></i></strong> Name of the Board/Corporation/Central Govt. Company (assamese)</label>");
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').show();
            $('#central_govt').hide();
            $('#non_govt_profit_making').hide();
            var allotment_purpose = <?php echo json_encode(CENTRAL_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html='';
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else if(ins_id == 12)
        {
            $('#dept_name_change').html("");
            $('#dept_name_change_ass').html("");
            $('#ins_checking').hide();
            $('#ins_checking_ass').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#central_govt').hide();
            $('#non_govt_profit_making').show();
            var allotment_purpose = <?php echo json_encode(NON_GOVT_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html='';
            for (var i = 0; i < allotment_purpose.length; i++) {
                html =
                    html +
                    "<option value='" +
                    allotment_purpose[i]['id'] +
                    "'>" +
                    allotment_purpose[i]['category_name'] +"</option>";
            }
            $("#purpose_co").html(html);
        }
        else
        {
            $('#ins_checking').hide();
            $('#ins_checking_ass').hide();
        }
    });

    $('#purpose_co').change(function (e) {
        var purpose = $(this).val();
        if(purpose == 'others')
        {
            $('#other_details_div').show();
            $('#sub_type_div').hide();
        }
        else if(purpose == 'religious')
        {
            $('#sub_type_div').show();
            $('#other_details_div').hide();
        }
        else
        {
            $('#other_details_div').hide();
            $('#sub_type_div').hide();
        }
    });


    $("input:radio[name=is_central_state]").click(function() {
        $('#ins_checking').hide();
        $('#ins_checking_ass').hide();
        var checkVal = $('input:radio[name=is_central_state]:checked').val();
        var service  = $('#service_code_lm').val();
        const application = {
            checkVal     : checkVal,
            service : service
        };
        $.ajax({
            url: '<?=base_url()?>index.php/SettlementInstitutionCo/getProjectDetails',
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                console.log(data);

                var html = "<option value='-1'>Select application details</option>";
                for (var i = 0; i < data.result.length; i++) {
                    html =
                        html +
                        "<option value='" +
                        data.result[i].id +
                        "'>" +
                        data.result[i].category_name +"</option>";
                }
                $("#application_type_state_central").html(html);
            },
            data: JSON.stringify(application)
        });
    });


    $("input:radio[name=religious_or_charitable_purposes_reclassification]").click(function(){
        $("#finalamount").val('');
        $("#totaldue").val('');
    });

    
    $("input:radio[name=roadside_comment_check]").click(function(){
        $("#finalamount").val('');
        $("#totaldue").val('');
    });


</script>
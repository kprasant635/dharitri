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
                        <li role="presentation" >
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
                        <li role="presentation" class="active">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                <span class="round-tab">
                                <strong>CO Report</strong>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <form role="form" class="lmForm" method="post" action="<?php echo base_url() ?>index.php/SettlementInstitutionCo/initRegistration/<?=$review_flag?>?app=<?=$_GET['app']?>" enctype="multipart/form-data">
   

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


                        <div class="tab-pane" role="tabpanel" id="step1">
                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            <?=NJS_TAGLINE?> (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic['applid']?></span>)
                            </h5>
                            <div class="reza-card">
                                <div id="additionalErrors" class="text-right px-4 mt-2" style="cursor:pointer;">
                                    <?php
                                    if(isset($all_errors)){?>
                                        <span class="text-danger">
                                            <i id="blink" class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>Check errors</span>
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
                                        <i class="fa fa-file-text"></i>  Application Details (Filled by Citizen)
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
                                                        <tr>
                                                            <th>Total Applications applied by this applicant</th>
                                                            <td>
                                                                <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$basic["applid"];?>">
                                                                    <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
                                    <?php if($selfDeclarationDetails != null)
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
                                        <i class="fa fa-user"></i>  Authorised Applicant details
                                    </h5>
                                    <?php $i = 1; foreach ($applicants_buyers as $settlement):
                                        ?>
                                        <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
                                        <!-- <div class="tableCard applicantData" id='applicantrow_<?=$i?>'> -->
                                        <div class="tableCard" id='applicantData'>
                                            <table class="table table-bordered" id="appRow<?=$settlement->id?>">
                                                <tr>
                                                    <th rowspan="6" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
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
                                                    <!-- <th>Present address</th>
                                                    <td>
                                                        <input type="text" readonly name="pdar_add2<?=$settlement->id?>" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2;?>" class="form-control input-sm" >
                                                    </td> -->
                                                    <!-- <td colspan="2" style="vertical-align : middle;text-align:center;">
                                                        <?php //if(ENABLE_APPLICANT_BUTTON != 0){?>
                                                            <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>
                                                            <button type="button" onclick="openApplicant();" class="btn btn-sm btn-primary"><strong>Add Data</strong></button>

                                                            <?php if($settlement->is_applicant != 1){ ?>
                                                                <button type="button" onclick="confirmDeleteApplicant(<?=$settlement->id?>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                                    <strong>Delete</strong></button>

                                                            <?php }?>
                                                        <?php //}?>
                                                    </td> -->
                                                </tr>

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
                                    <div class="tableCard">
                                        <!-- new premium addition -->

                                    <?php foreach($dags as $dagspremlm){ ?>
                                        <!-- <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong style="color:red"> Area Type for Dag No : <?=$dagspremlm->dag_no?></strong></span>
                                                <?=form_error('area'.$dagspremlm->dag_no)?>
                                            </div>

                                            <div class="col-md-6">
                                            
                                            <input type="hidden" name='area_new<?=$dagspremlm->dag_no?>' id='area_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaCategory($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                                            <?=form_error('area_new'.$dagspremlm->dag_no)?>
                                            <input class="form-control" type="text" name='area_cat_new<?=$dagspremlm->dag_no?>' id='area_cat_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaName($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                                            </div>
                                        </div> -->

                                        
                                        <?php }?>
                                        <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;" class="<?php if(form_error('totalAppliedAdditionalArea')){echo 'is-invalid';} ?>">
                                            <?=form_error('totalAppliedAdditionalArea');?>
                                        </div>
                                        <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                                             class="<?php if(form_error('totalAppliedAreaInUrban')){echo 'is-invalid';} ?>">
                                            <?=form_error('totalAppliedAreaInUrban');?>
                                        </div>
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
                                                <!-- <tr style="display:none">
                                                    <th class="text-primary settlement-area-color">Applied area (Fishery)</th>
                                                    <td class="settlement-area-color">
                                                        <span class="input-group-addon">Bigha</span>
                                                        <input type="text" style="text-align: center;" required name="fbigha<?=$all_dags->dag_no?>" class="form-control input-sm fbigha" value="<?=$all_dags->fbigha?>" onkeyup="fisheryArea()" id="fbigha<?=$total_area_fbigha++?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <span class="input-group-addon">Katha</span>
                                                        <input type="text" style="text-align: center;" required name="fkatha<?=$all_dags->dag_no?>" value="<?=$all_dags->fkatha?>" class="form-control input-sm fkatha" onkeyup="fisheryArea()" id="fkatha<?=$total_area_fkatha++?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <span class="input-group-addon">Lessa</span>
                                                        <input type="text" style="text-align: center;" required name="flessa<?=$all_dags->dag_no?>" class="form-control input-sm flessa" value="<?=$all_dags->flessa?>" onkeyup="fisheryArea()" id="flessa<?=$total_area_flessa++?>">
                                                    </td>
                                                    <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color">
                                                            <span class="input-group-addon">Ganda</span>
                                                            <input type="text" style="text-align: center;"  value="<?=$all_dags->fganda?>" class="form-control input-sm fganda" name="fganda<?=$all_dags->dag_no?>" onkeyup="fisheryArea()" id="fganda<?=$total_area_fganda++?>">
                                                        </td>
                                                        <td class="settlement-area-color">
                                                            <span class="input-group-addon">Kranti</span>
                                                            <input type="text" style="text-align: center;"  value="<?=$all_dags->fkranti?>" class="form-control input-sm fkranti" name="fkranti<?=$all_dags->dag_no?>" onkeyup="fisheryArea()" id="fkranti<?=$total_area_fkranti++?>">
                                                        </td>
                                                    <?php endif ; ?>
                                                </tr> -->
                                                <tr style="border-bottom:1px solid #227576">
                                                    <td colspan="2">
                                                       

                                                        <div id="dageligiblemsg<?=$all_dags->id?>" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; display:none">

                                                        </div>
                                                    </td>
                                                    <td colspan="2" class="text-center">

                                                        <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$basic["applid"];?>&dag=<?=$all_dags->dag_no;?>">
                                                            <small style="font-size:14px; color:white; font-weight:bold">
                                                                <i class="fa fa-eye"></i> View Total Applications in this Dag
                                                            </small>
                                                        </a>
                                                    </td>
                                                </tr>

                                            <?php }?>

                                            <?php
                                            // for dag not eligible
                                            include(APPPATH."views/SettlementView/include/dagNotEligibleView.php");
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
                                            <!-- <tr style="display:none">
                                                <th class="text-danger">Total applied area (Fishery)</th>
                                                <td>
                                                    <span class="input-group-addon">Bigha</span>
                                                    <input type="text" style="text-align: center;" name="fish_dag_area_b<?=$all_dags->dag_no?>" class="form-control input-sm fish_dag_area_b" value="<?=$total_fbigha?>" id="total_applied_fbigha">
                                                </td>
                                                <td>
                                                    <span class="input-group-addon">Katha</span>
                                                    <input type="text" style="text-align: center;" name="fish_dag_area_k<?=$all_dags->dag_no?>" value="<?=$total_fkatha?>" class="form-control input-sm fish_dag_area_k" id="total_applied_fkatha">
                                                </td>
                                                <td>
                                                    <span class="input-group-addon">Lessa</span>
                                                    <input type="text" style="text-align: center;" name="fish_dag_area_lc<?=$all_dags->dag_no?>" class="form-control input-sm fish_dag_area_lc" value="<?=$total_flessa?>" id="total_applied_flessa">
                                                </td>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <td>
                                                        <span class="input-group-addon">Ganda</span>
                                                        <input type="text" style="text-align: center;" value="<?=$total_fganda?>" class="form-control input-sm fish_dag_area_g" name="fish_dag_area_g<?=$all_dags->dag_no?>" id="total_applied_fganda">
                                                    </td>
                                                    <td>
                                                        <span class="input-group-addon">Kranti</span>
                                                        <input type="text" style="text-align: center;" value="<?=$total_fkranti?>" class="form-control input-sm fish_dag_area_kr" name="fish_dag_area_kr<?=$all_dags->dag_no?>" id="total_applied_fkranti">
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
                                    <!-- additional property -->
                                   <!--  <?php if(isset($property) && !empty($property)) { ?>
                                        <h5  class="reza-title" style="margin-top: 50px">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Additional Property Details
                                        </h5>
                                        <div class="tableCard">
                                            <table class="table table-bordered">
                                                <?php $i=1; foreach($property as $adp): ?>
                                                    <tr>
                                                        <th>District Name:</th>
                                                        <td class="text-warning">
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($adp->dist_code)?>' readonly>
                                                            </strong>
                                                        </td>
                                                        <th>Subdivision Name:</th>
                                                        <td class="text-warning">
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($adp->dist_code,$adp->subdiv_code)?>' readonly>
                                                            </strong>
                                                        </td>
                                                        <th>Circle Name: </th>
                                                        <td class="text-warning">
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_circle_name" value='<?=$this->utilityclass->getCircleName($adp->dist_code,$adp->subdiv_code,$adp->cir_code)?>' class="form-control input-sm" readonly>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Mouza Name: </th>
                                                        <td class="text-warning">
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code)?>' readonly>
                                                            </strong>
                                                        </td>
                                                        <th>Village Name: </th>
                                                        <td class="text-warning">
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_village_name" value='<?=$this->utilityclass->getVillageName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code,$adp->lot_no,$adp->vill_townprt_code)?>' class="form-control input-sm" readonly>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dag Number:</th>
                                                        <td>
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_dag_no" value='<?=$adp->dag_no?>' class="form-control input-sm" readonly>
                                                            </strong>
                                                        </td>
                                                        <th>Patta Number:</th>
                                                        <td>
                                                            <strong class="alert-warning">
                                                                <input type="text" name="a_patta_no" class="form-control input-sm" value='<?=$adp->patta_no;?>' readonly>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Additional Land Details</th>
                                                        <td>
                                                            <span class="input-group-addon">Bigha</span>
                                                            <strong>
                                                                <input type="text" style="text-align: center;" name="a_bigha" class="form-control input-sm" value="<?=$adp->bigha?>" readonly>
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            <span class="input-group-addon">Katha</span>
                                                            <input type="text" style="text-align: center;" name="a_katha" value="<?=$adp->katha?>" class="form-control input-sm" readonly>
                                                        </td>
                                                        <td>
                                                            <span class="input-group-addon">Lessa</span>
                                                            <input type="text" style="text-align: center;" name="a_lessa" class="form-control input-sm" value="<?=$adp->lessa?>" readonly>
                                                        </td>
                                                        <?php if((in_array($adp->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                                            <td>
                                                                <span class="input-group-addon">Ganda</span>
                                                                <input type="text" style="text-align: center;" value="<?=$adp->ganda?>" class="form-control input-sm" name="a_ganda" readonly>
                                                            </td>
                                                            <td>
                                                                <span class="input-group-addon">Kranti</span>
                                                                <input type="text" style="text-align: center;" value="<?=$adp->kranti?>" class="form-control input-sm" name="a_kranti" readonly>
                                                            </td>
                                                        <?php endif ; ?>
                                                    </tr>
                                                    <?php $i++ ?>
                                                <?php endforeach;  ?>
                                            </table>
                                        </div>
                                    <?php } ?> -->
                                    <!-- additional property end -->

                                    <!--- Nominee details starts here --mdz- --->
                                    <!-- <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Family Details
                                  
                                    </h5>
                                    <?php if(!empty($nominee)) { ?>
                                        <div class="tableCard">
                                            <table class="table table-bordered" id="listNextOfKin">
                                                <tr>
                                                    <th>Nominee name</th>
                                                    <th>Relation with Applicant</th>
                                                    <th>Address of Nominee</th>
                                                    <th>Mobile number</th>
                                                </tr>
                                                <?php $i = 1;foreach ($nominee as $kin): ?>
                                                    <tr id="sp<?=$kin->id?>">
                                                        <td>
                                                            <input type="text" readonly name="kin_name" value="<?=$kin->nominee_name?>" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly name="kin_relation" value="<?=$this->utilityclass->appRelationbyIDMB2($kin->relation)?>" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly class="form-control" value="<?=$kin->address?>" name="kin_address">
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control">
                                                        </td>
                                                        <td>
                                                            <?php if(ENABLE_FAMILY_BUTTON != 0){?>
                                                                <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add</button>
                                                                <button type="button" onclick="confirmDeleteFamily(<?=$kin->id?>);" class="btn btn-sm btn-danger">Delete</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;?>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="tableCard familyVisibleHide">
                                            <table class="table table-bordered" id="listNextOfKin">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relation</th>
                                                    <th>Address</th>
                                                    <th>Mobile number</th>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php } ?> -->

                                    

                                    <!--- Nominee details ends here --mdz- --->


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
                        <div class="tab-pane active" role="tabpanel" id="step2">
                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            <?=NJS_TAGLINE?> 
                                (<span class="bg-warning"><?=$basic['case_no']?> , <?=$basic['applid']?></span>)
                            </h5>
                            <div class="reza-card">
                                <div class="reza-body">
                                    <div class="row p-2">
                                        <p style="color: red;text-align: center;">Note : asterisk marks are mandatory !!!</p>
                                    </div>
                                    <div class="row p-2">
                                        <div class="col-lg-4">
                                          <span><strong><i class="fa fa-angle-double-right"></i></strong> Category of non individual juridical entities <span style="color: red;">*</span></span>
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
                                    </div>
                                    <div class="row p-2">
                                        <div class="col-lg-4">
                                            <span><strong><i class="fa fa-angle-double-right"></i></strong> Select Application for <span style="color: red;">*</span></span>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-select" name="application_type_state_central" id="application_type_state_central">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row p-2" >
                                        <div class="col-lg-4">
                                            <strong><i class="fa fa-angle-double-right"></i></strong> Name of the institution <span style="color: red;">*</span>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="name_ins_co" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row p-2" >
                                        <div class="col-lg-4">
                                            <label><strong><i class="fa fa-angle-double-right"></i></strong> Name of the institution (assamese) <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="name_ins_co_ass" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row p-2" id="ministry_department_checking" style="display: none;">
                                        <div class="col-lg-4" id="ministry_department_name_change">
                                        
                                            <label><strong><i class='fa fa-angle-double-right'></i></strong> Ministry <span style="color: red;">*</span></label>
                                  
                                        </div>
                                        <div class="col-lg-8">
                                            <!-- <input type="text" name="ministry_department_name_change" value="" class="form-control"> -->
                                            <select name="ministry_department_name_change" class="form-control" id="">
                                                <option value= "">--SELECT MINISTRY--</option>
                                                <?php $ministry = MINISTRY; foreach ($ministry as $key => $value) { ?>
                                                    <option value="<?=$value;?>"><?=$value?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row p-2" id="ins_checking" style="display: none;">
                                        <div class="col-lg-4" id="dept_name_change">
                                            <label><strong><i class='fa fa-angle-double-right'></i></strong> Department <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                    
                                            <select name="dept_name_co" class="form-control" id="">
                                                <option value= "">--SELECT DEPARTMENT--</option>
                                                <?php $departmenet = DEPARTMENT; foreach ($departmenet as $key => $value) { ?>
                                                    <option value="<?=$value;?>"><?=$value?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row p-2" id="ins_checking_ass" style="display: none;">
                                        <div class="col-lg-4" id="dept_name_change_ass">
                                            <label><strong><i class='fa fa-angle-double-right'></i></strong> Department (Assamese) <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="dept_name_ass_co" value="" class="form-control">
                                        </div>
                                    </div>

                                    

                                    <div class="row p-2" id="directorate_checking" style="display: none;">
                                        <div class="col-lg-4" id="directorate_name_change">
                                            <label><strong><i class='fa fa-angle-double-right'></i></strong> Directorate/Commissionerate</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="directorate_name_change" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row p-2" id="state_dept_undertaking_checking" style="display: none;">
                                        <div class="col-lg-4" id="state_undertaking_name_change">
                                            <strong><i class="fa fa-angle-double-right"></i></strong> Undertaking Board name <span style="color: red;">*</span>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="state_dept_undertaking_name" value="" class="form-control">
                                        </div>
                                    </div>

                                    
                                   

                                    <div class="row p-2">
                                        <div class="col-lg-4" id="">
                                            <span><strong><i class="fa fa-angle-double-right"></i></strong> Purpose of which land applied for <span style="color: red;">*</span></span>
                                        </div>
                                        <div class="col-lg-8">

                                            <select class="form-control" name="purpose_co" id="purpose_co">

                                            </select>
                                        </div>
                                    </div>
                                    

                                    <div class="row p-2" id="other_subtype_details_div" style="display: none;">
                                        <div class="col-lg-4" id="">
                                            <span><strong><i class="fa fa-angle-double-right"></i></strong>Enter the subtype (i:e for Religious (Temple/Namghar/Kirtan Ghar etc.) for socio culture (youth club/sanmilan sangha/mahila samittee etc.))<span style="color: red;">*</span></span>
                                        </div>
                                        <div class="col-lg-8">
                                     
                                            <select name="other_subtype_details_co" id="other_subtype_details_co" class="form-select">
                                                <option value="">--SELECT--</option>
                                                <?php $list = SUB_CAT;
                                                 foreach ($list as $key => $value) { ?>
                                                    <option value="<?=$value['id']?>"><?=$value['category_name']?></option>

                                                <?php } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row p-2" id="other_details_div" style="display: none;">
                                        <div class="col-lg-4" id="">
                                            <span><strong><i class="fa fa-angle-double-right"></i></strong>Enter other details <span style="color: red;">*</span></span>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="other_details_co" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row p-2" id="state_govt_undertaking" style="display: none;">
                                        <div class="col-lg-8" id="dept_name_change_ass">
                                            <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under State Government Undertakings/Statutory Bodies/Parastatals etc. like State Warehousing corporation(SWHC) etc.which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022 <span style="color: red;">*</span> </label>
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
                                    </div>

                                    <div class="row p-2" id="central_govt" style="display: none;">
                                        <div class="col-lg-8" id="dept_name_change_ass">
                                            <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under Central Govt. Ministries/Departments related to Health,Education and Skill Development, within the meaning of DoR&DM Office Memorandum  No.ECF.106184/2019/9 dated 07-07-2021 <span style="color: red;">*</span></label>
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
                                    </div>

                                    <div class="row p-2" id="central_govt_undertaking" style="display: none;">
                                        <div class="col-lg-8" id="dept_name_change_ass">
                                            <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Project/Infrastructure under Central Govt. Undertakings/Statutory Bodies/Parastatals etc. like Food Corporation of India(FCI),Central Warehousing Corporation(CWC) etc which are responsible for construction of warehouse/godown under Paddy Procurement Scheme ,within the meaning of DoR&DM Office Memorandum  ECF NO.106184/2019/11 dated 02-06-2022 <span style="color: red;">*</span> </label>
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
                                    </div>

                                    <div class="row p-2" id="non_govt_profit_making" style="display: none;">

                                        <div class="row p-2">
                                            <div class="col-md-6" style="color:#ff681d;font-weight: bold;">
                                                <i class="fa fa-arrow-circle-right"></i> Is the educational institution is venture school ?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('under_venture_school_primary_info')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="under_venture_school_primary_info"
                                                            id="under_venture_school_primary_info1"
                                                            value="YES"
                                                        <?php if(set_value('under_venture_school_primary_info') == 'YES'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('under_venture_school_primary_info')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="under_venture_school_primary_info"
                                                            id="under_venture_school_primary_info2"
                                                            value="NO"
                                                        <?php if(set_value('under_venture_school_primary_info') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="row p-2 school_type_venture_govt_aided_primary_info" style="background: antiquewhite;border: 1px solid;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                   
                                                    <label class="col-sm-3 checkbox-inline">
                                                        <input id="unrecognised_venture_primary_info"  name="unrecognised_venture_primary_info" type="checkbox" value="unrecognised_venture">unrecognised venture school</label>
                                                    <label class="col-sm-6 checkbox-inline">
                                                        <input id="govt_aided_venture_primary_info" name="govt_aided_venture_primary_info"  type="checkbox" value="govt_aided_venture">Govt aided venture school which have recieved grants in aid for paying salary/wages for teachers from the state government for each of the last 3 financial years only will be provided with <span style="color:red">Allotment only</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="non_profit_div">
                                            <div class="col-lg-8" id="dept_name_change_ass">
                                                <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Non Govt. Educational Institution of public nature which is devoted to public purposes and which yield no return to private individuals (non profit making) within the meaning of DoR&DM letter No RSR.9/88/Pt.II/64 dated 25-05-1999. <span style="color: red;">*</span></label>
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
                                        </div>
                                    </div>
                                    
                                    <div class="row p-2 govt_entitites" style="display:none;">
                                        <div class="col-lg-8" id="">
                                            <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the  land applied for, is or will be used or  transferred for commercial purpose and not for official purpose- please refer to section 16(b) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015. <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="transferred_for_commercial_purposes_reclassification_govt"  id="inlineRadio1" value="Y">
                                                <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="transferred_for_commercial_purposes_reclassification_govt" id="inlineRadio2" value="N">
                                                <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row p-2 non_govt_entitites" style="display:none;">
                                        <div class="col-lg-8" id="">
                                            <label><strong><i class="fa fa-angle-double-right"></i></strong> Is the Land applied for used for religious or charitable purposes and other public utilities or amenities - please refer to section 16(e) of The Assam Agricultural Land(Regulation of Reclassification and Transfer for Non-Agricultural Purpose)Act,2015 <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="religious_or_charitable_purposes_reclassification"  id="inlineRadio1" value="Y">
                                                <label class="form-check-label label-style" for="inlineRadio1" style="color:purple;">yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="religious_or_charitable_purposes_reclassification" id="inlineRadio2" value="N">
                                                <label class="form-check-label label-style" for="inlineRadio2" style="color:red;">no</label>
                                            </div>
                                          
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6" style="color:#ff681d;font-weight: bold;">
                                                <i class="fa fa-arrow-circle-right"></i> Does the Institution fall under category of NGOs, Trusts, Local Bodies, Associations, Societies ?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('under_ngo_trust_localbodies_primary_info')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="under_ngo_trust_localbodies_primary_info"
                                                            id="under_ngo_trust_localbodies_primary_info1"
                                                            value="YES"
                                                        <?php if(set_value('under_ngo_trust_localbodies_primary_info') == 'YES'){ echo "checked";}?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('under_ngo_trust_localbodies_primary_info')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="under_ngo_trust_localbodies_primary_info"
                                                            id="under_ngo_trust_localbodies_primary_info2"
                                                            value="NO"
                                                        <?php if(set_value('under_ngo_trust_localbodies_primary_info') == 'NO'){ echo "checked";}?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>  
                                        </div>

                                        <div class="row p-2 charter_activities_primary_info" style="display:none">
                                            <div class="col-md-6" style="color:#ff681d;font-weight: bold;">
                                                <i class="fa fa-arrow-circle-right"></i> Is the charter of activities are such that the institution considered as educational,religious and socioculture institution ?
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('under_charter_activities_primary_info')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="under_charter_activities_primary_info"
                                                            id="under_charter_activities_primary_info1"
                                                            value="YES"
                                                        <?php if(set_value('under_charter_activities_primary_info') == 'YES'){ echo "checked";} ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('under_charter_activities_primary_info')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="under_charter_activities_primary_info"
                                                            id="under_charter_activities_primary_info2"
                                                            value="NO"
                                                        <?php if(set_value('under_charter_activities_primary_info') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    
                                    <div class="row p-2">
                                        <div class="col-lg-4" id="">
                                            <span><strong><i class="fa fa-angle-double-right"></i></strong> Hearing date
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="hearing_date_co" id="hearing_date_co" value="" class="form-control">
                                            <p style="color:red;font-size: 11px;font-weight: bold;">(If required,Circle officer may give hearing date and assistant will generate notice)</span></p>
                                        </div>
                                    </div>
                                    

                                        <div class="row p-2" >
                                            <div class="col-md-4">
                                                <span><strong><i class="fa fa-angle-double-right"></i></strong> Enter Remark</span>
                                                <?=form_error('co_remark')?>
                                            </div>
                                            <div class="col-8">
                                                <p style="color:red;font-size: 11px;font-weight: bold;">(This is a default remark, circle officer may edit or add)</span></p>
                                                <?php 
                                                $show_ap_area = '';
                                                if($ap_area == null)
                                                {
                                                    $show_ap_area = $total_home_bigha. "B-".$total_home_katha." K-".$total_home_lessa."-L";
                                                    if (in_array($basic['dist_code'], json_decode(BARAK_VALLEY))) {
                                                        $total_settlement_ganda_home = $this->ncutility->Total_ganda($total_home_bigha, $total_home_katha, $total_home_lessa, $total_home_ganda);

                                                        $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa2($total_settlement_ganda_home);
                                                        $show_ap_area = $totalSettlementAreaArr[0]. "B-" .$totalSettlementAreaArr[1]." K-".$totalSettlementAreaArr[2]." L".$totalSettlementAreaArr[3]." G";
                                                    }
                                                    else
                                                    {
                                                        $total_settlement_lessa_home = $this->ncutility->Total_Lessa($total_home_bigha, $total_home_katha, $total_home_lessa);
                                                    
                                                        $totalSettlementAreaArr = $this->ncutility->Total_Bigha_Katha_Lessa($total_settlement_lessa_home); 
                                                        
                                                        $show_ap_area = $totalSettlementAreaArr[0]. "B-" .$totalSettlementAreaArr[1]." K-".$totalSettlementAreaArr[2]." L";
                                                    }
                                                
                                                }
                                                else
                                                {
                                                    $show_ap_area = $ap_area;
                                                } 
                                                ?>
                                                <textarea class="col-12 p-2 <?php if(form_error('co_remark')){echo 'lm_invalid';}?>" rows="10" name="co_remark" id="co_remark" placeholder="Please enter remark...">আবেদনকাৰীৰ আৱেদন চোৱা হল । আবেদনকাৰীয়ে <?=$mouza_name?> মৌজা ৰ <?=$vill_name;?> গাৱৰ <?=$show_ap_area?> মাটিত আবন্টন/পট্ন পাবৰ কাৰনে আবেদন কৰিছে । প্ৰাৰম্ভিক পৰীক্ষা মতে আবেদন বিবেচনা কৰা হল | ভূমিলেখ্য সহায়কে চৰজমিন তদন্ত কৰি <?=$mouza_name?> মৌজা ৰ <?=$vill_name?> গাৱৰ মাটি সম্পৰ্কে বিতং প্রতিবেদন তথ্য় সহ দাখিল কৰিব
                                            </textarea>


                                            </div>
                                        </div>
                                    </div>
                                   <!--  <div class="row p-2" >
                                        <div class="col-md-4">
                                            <span><strong><?=$sl_count++?>.</strong> Action</span>
                                            <?=form_error('chitha_verified')?>
                                        </div>
                                        <div class="col-8">

                                                <?php
                                                if($basic['status'] == 'ZC'){                                        
                                                ?>

                                                    <button type="button" onclick="showNewDirectRejectModalMb2('<?=$basic['case_no']?>','<?=SLIJE_ID ?>')" class="btn btn-danger">Reject this case</button>
                                                    <br>
                                                    <small style="background:#FFFF00;"> Reject Reasons will appear once reject button is clicked!</small>

                                                <?php }
                                                else if($basic['status'] == 'D'){
                                                    echo '<span class="text-danger"> Case has been rejected! </span>';
                                                }else{
                                                    echo '<span class="text-success"> Case forwared from CO! </span>';
                                                }?>

                                        </div>
                                    </div> -->

                                </div>

                            </div>
                            <ul class="list-inline pull-right" style="margin-top: 20px">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">
                                        <i class="fa fa-arrow-circle-left"> </i>   Previous
                                    </button>
                                </li>
                                <?php if(ENABLE_BUTTON_CO_FIRST_PROC_SUBMIT_INSTITUTE != 0){?>
                                    <li>
                                        <input type="submit" onClick="this.disabled=true; this.value='Saving...';" value="Save and submit" class="btn btn-primary next-step" id="btnCoFirstProcSubmit">
                                            <!-- <i class="fa fa-check-square-o"> </i>  Save and submit
                                        </button> -->
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>
<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
<!-- add Encroacher modal -->


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
        $('#hearing_date_co').datepick({dateFormat: 'dd-mm-yyyy'});
    });
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

<!-- additional errors check  -->
<script>
    $(document).ready( function () {
      totalAreaCal();
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
        // var length = <?=$total_area_bigha?>;
        var total_area = 0;
        // for(i=1; i<length; i++){
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



    <?php
    }else{?>
    function totalAreaCal(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        // for homestead
        // var length = <?=$total_area_bigha?>;
        var total_area = 0;
        // for(i=1; i<length; i++){
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

    <?php }?>

    $('#additionalErrors').on('click',function(){
        $(this).next('#additional_errors_collapse').slideToggle();
    });
    $('#ins_checking').hide();
    $('#ins_checking_ass').hide();
    $('#state_govt_undertaking').hide();
    $('#central_govt_undertaking').hide();
    $('#state_dept_undertaking_checking').hide();


    

    $('.charter_activities_primary_info').hide();
    $("input:radio[name=under_ngo_trust_localbodies_primary_info]").click(function() {
        $('input:radio[name=under_charter_activities_primary_info]').prop('checked', false);
        var checkVal = $('input:radio[name=under_ngo_trust_localbodies_primary_info]:checked').val();
        if(checkVal == 'YES')
        {
            $('.charter_activities_primary_info').show();
        }
        else
        {
            $('.charter_activities_primary_info').hide();
        }
        
    });


    $('.school_type_venture_govt_aided_primary_info').hide();
    $('#non_profit_div').hide();
    $("input:radio[name=under_venture_school_primary_info]").click(function() {
        $('#unrecognised_venture_primary_info').prop('checked', false);
        $('#govt_aided_venture_primary_info').prop('checked', false);
        $('input:radio[name=non_govt_profit_making_yes_no]').prop('checked', false);
        var checkVal = $('input:radio[name=under_venture_school_primary_info]:checked').val();
        if(checkVal == 'YES')
        {
            $('.school_type_venture_govt_aided_primary_info').show();
            $('#non_profit_div').hide();
        }
        else
        {
            $('.school_type_venture_govt_aided_primary_info').hide();
            $('#non_profit_div').show();
        }
        
    });

    $(document).on('click', 'input[type="checkbox"]', function() {      
        $('input[type="checkbox"]').not(this).prop('checked', false);      
    });


    $('#application_type_state_central').change(function (e) {
        e.preventDefault()
        $('#ins_checking').show();
        $('#ins_checking_ass').show();
        $('#ministry_department_checking').hide();
        $('#directorate_checking').hide();
        $('.govt_entitites').hide();
        $('.non_govt_entitites').hide();
        var ins_id = $(this).val();
        if(ins_id == 8)
        {
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#state_dept_undertaking_checking').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#non_govt_profit_making').hide();
            $('#central_govt').hide();
            var allotment_purpose = <?php echo json_encode(STATE_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
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
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#state_dept_undertaking_checking').show();
            $('#state_govt_undertaking').show();
            $('#central_govt_undertaking').hide();
            $('#non_govt_profit_making').hide();
            $('#central_govt').hide();
            var allotment_purpose = <?php echo json_encode(STATE_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
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
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#ministry_department_checking').show();
            $('#state_dept_undertaking_checking').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#central_govt').show();
            $('#non_govt_profit_making').hide();

            var allotment_purpose = <?php echo json_encode(CENTRAL_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
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
            $('.govt_entitites').show();
            $('#directorate_checking').show();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').show();
            $('#central_govt').hide();
            $('#non_govt_profit_making').hide();
            $('#state_dept_undertaking_checking').show();
            $('#ministry_department_checking').show();
            var allotment_purpose = <?php echo json_encode(CENTRAL_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
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
            $('.non_govt_entitites').show();
            $('#state_dept_undertaking_checking').hide();
            $('#ins_checking').hide();
            $('#ins_checking_ass').hide();
            $('#state_govt_undertaking').hide();
            $('#central_govt_undertaking').hide();
            $('#central_govt').hide();
            // $('#non_govt_profit_making').show();
            var allotment_purpose = <?php echo json_encode(NON_GOVT_PURPOSE);?>;
            // // var lt = JSON.parse(allotment_purpose);
            // console.log(allotment_purpose[0].id);
            var html = "<option value=''>Select land purpose---</option>";
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
        $('#non_govt_profit_making').hide();
        $('#other_subtype_details_div').hide();
        $('#other_details_div').hide();
        $('input:radio[name=non_govt_profit_making_yes_no]').prop('checked', false);
        $('input:radio[name=under_venture_school_primary_info]').prop('checked', false);
        $('input:radio[name=under_ngo_trust_localbodies_primary_info]').prop('checked', false);
        $('input:radio[name=under_charter_activities_primary_info]').prop('checked', false);
        $('#unrecognised_venture_primary_info').prop('checked', false);
        $('#govt_aided_venture_primary_info').prop('checked', false);
        var purpose = $(this).val();
        if(purpose == 'other')
        {
            $('#other_details_div').show();
        }
        else if(purpose == 'education' && $('#application_type_state_central').val() == 12) 
        {
            $('#non_govt_profit_making').show();
            $('#other_details_div').hide();
        }
        else if(purpose == 'religious' || purpose=='socioculture')
        {
            $('#other_subtype_details_div').show();
        }
        else
        {
            $('#other_details_div').hide();
        }
    });

    $('#other_subtype_details_co').change(function (e) {
        $('#other_details_div').hide();
        var purpose = $(this).val();
        if(purpose == 50)
        {
            $('#other_details_div').show();
        }
        else
        {
            $('#other_details_div').hide();
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

                var html = "<option value=''>Select application details</option>";
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


    $('#btnCoFirstProcSubmit').on('click',function(e){
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
            // html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                // html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
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
                    // html: 'Land Occupied : '+$( "#is_landless option:selected" ).text() + "; <br /><br /> Encroacher Exists in VLB - "+encDataAll,
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
                    $('#btnCoFirstProcSubmit').prop('disabled', false);
                    $('#btnCoFirstProcSubmit').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnCoFirstProcSubmit').prop('disabled', false);
                $('#btnCoFirstProcSubmit').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnCoFirstProcSubmit').prop('disabled', false);
            $('#btnCoFirstProcSubmit').val('Save and submit');
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
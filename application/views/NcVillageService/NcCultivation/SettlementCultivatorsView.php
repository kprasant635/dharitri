<style>
    .is-invalid:focus{
        border: 1px solid red !important;
    }
    .lm_invalid{
        border: 1px solid red !important;
    }
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>
<style>
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
<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) {
    $lessa_chatak='Chatak';
} else {
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
        <section>

            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                        <li role="presentation" class="active">
                            <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                        <span class="round-tab">
                            <strong>Application</strong>
                        </span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                        <span class="round-tab">
                            <strong>Lot Mondal</strong>
                        </span>
                            </a>
                        </li>

                    </ul>
                </div>
                <form role="form" class="lmForm" method="post" action="<?php echo base_url()?>index.php/NcCultivationLmController/settlementApplication?app=<?=$_GET['app']?>" enctype="multipart/form-data">
                    <?php 
                        $application_no = $this->utilityclass->decryptJwtCase($_GET['app']);
                    ?>
                    <input type="hidden" id="service_code_lm" name="service_code" value="<?=$basic["service_code"]?>">
                    <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
                    <input type="hidden" id ='case_no' name="case_no" value="<?=$case_no?>">
                    <input type="hidden" name="application_no" id="case_no" value="<?=$case_no?>">
                    <input type="hidden" name="uuid" id="uuid" value="<?=$basic['uuid']?>">

                    <?php
                    $sl_count = 1;
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h5  class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                                <?php echo $this->lang->line('teaSpecialCultivatorsName') ?> (
                                <span class="bg-warning"><?=$case_no?></span> )
                            </h5>
                            <div class="reza-card">
                                <div class="reza-body">
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
                                    <?=$dagFlagCheckChitha?>
                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-file-text"></i>  Application Details
                                    </h5>
                                    <div class="tableCard" id="applicantDetailsDiv">
                                        <div class="row justify-content-center">
                                            <?php
                                            foreach($applicants_buyers as $adhar_arr):
                                                if($adhar_arr->is_applicant == 1):
                                                    if($adhar_arr->identity_type == 'AADHAAR'):
                                                        ?>
                                                        <div class="col-md-2 text-center">
                                                            <?=$base64_decoded_adhar_file?>
                                                        </div>

                                                    <?php
                                                    endif;
                                                endif;
                                            endforeach;
                                            ?>
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
                                                        <?php }
                                                    endforeach; ?>
                                                    <tr>

                                                        <th><?=$aadhar[0]->identity_type?> Verified</th>
                                                        <td>
                                                            <input type="text" name="aadhar_verified" value="<?php if ($aadhar[0]->identity_type != null) {
                                                                echo 'Yes';
                                                            }?>" class="form-control" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Occupation or Profession of the applicant</th>
                                                        <td>
                                                            <input type="text" readonly name="occupation_applicant" id="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <input type="hidden" name="period_possession" class="form-control" value="<?=$basic["period_possession"] ?>">
                                                    <!-- <input type="hidden" name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" class="form-control"> -->

                                                    <tr>
                                                        <th>Caste</th>
                                                        <td>
                                                            <input type="text" id="caste_name" name="cast_category" value="<?php
                                                            foreach(json_decode(CASTE) as $caste_json) {
                                                                if($caste_json->CODE == $basic['caste']) {
                                                                    echo $caste_json->NAME;
                                                                }
                                                            }?>" class="form-control" readonly>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                    foreach($applicants_buyers as $applicant) {
                                                        if($applicant->is_applicant == '1') {
                                                            ?>
                                                            <tr>
                                                                <th>Under BPL </th>
                                                                <td>
                                                                    <input type="text" name="under_bpl" value="<?php if($applicant->bpl == 'YES') {
                                                                        echo "YES";
                                                                    } else {
                                                                        echo "NO";
                                                                    } ?>" class="form-control" readonly>
                                                                </td>
                                                            </tr>
                                                        <?php  }
                                                    }?>

                                                    <?php
                                                    if($basic['protected_class']):
                                                        ?>
                                                        <tr>
                                                            <th>Select if you fall under protected category?</th>
                                                            <td>
                                                                <select name="protected_class" id="" class="form-control" disabled>
                                                                    <?php
                                                                    foreach(json_decode(PROTECTED_CLASS) as $class) {
                                                                        ?>

                                                                        <option value="<?=$class->CODE?>" <?php if($class->CODE == $basic['protected_class']) {
                                                                            echo "selected";
                                                                        } ?>><?=$class->NAME?></option>
                                                                    <?php } ?>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                    <?php endif;?>
                                                    <tr>
                                                        <th>Whether land prayed for is within tribal belt/block ?</th>
                                                        <td>
                                                            <select name="tribal_belt" id="" class="form-control" disabled>
                                                                <option value="YES" <?php if($basic['tribal_belt'] == 'YES') {
                                                                    echo "selected";
                                                                }?>>Yes</option>
                                                                <option value="NO" <?php if($basic['tribal_belt'] == 'NO') {
                                                                    echo "selected";
                                                                }?>>No</option>
                                                            </select>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Whether the applicant already occupying the land ?</th>
                                                        <td>
                                                            <?php
                                                            if(trim($basic['is_occupying_land']) == 1) {
                                                                ?>
                                                                <input type="text" value="YES" class="form-control" readonly>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" value="NO" class="form-control" readonly>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="reza-title"  style="margin-top: 50px">
                                        <i class="fa fa-map-marker"></i> Address Information
                                    </h5>
                                    <div class="tableCard ">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>District Name:</th>
                                                <td class="text-warning">
                                                    <strong class="alert-warning">
                                                        <input type="text" name="dist_name" class="form-control input-sm" value="<?=$this->utilityclass->getDistrictName($basic["dist_code"])?>" readonly>
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


                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-pencil-square-o"></i> Self declaration details
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php foreach($selfDeclarationDetails[0] as $key=>$self) { ?>
                                                <tr>
                                                    <th><?=$self->name ?></th>
                                                    <td class="text-center">
                                                        <strong>
                                                            <?php if ($self->status == "1") {
                                                                echo "Yes";
                                                            }?>
                                                            <?php if ($self->status == "0") {
                                                                echo "No";
                                                            }?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </table>
                                    </div>

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user"></i>  Applicant details
                                    </h5>

                                    <?php $i = 1;
                                    foreach ($applicants_buyers as $settlement):?>
                                        <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
                                        <div class="tableCard " id='applicantData'>
                                            <table class="table" id="appRow<?=$settlement->id?>">
                                                <tr>
                                                    <th rowspan="6" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                                                    <th>Applicant Name (Assamese)</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="pdar_name<?=$settlement->id?>" value="<?=$settlement->pdar_name?>">
                                                    </td>
                                                    <th>Guardian Name (Assamese)</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="pdar_guardian<?=$settlement->id?>" value="<?=$settlement->pdar_guardian?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Applicant Name (English)</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" value="<?=$settlement->eng_pdar_name?>" id="eng_pdar_name<?=$settlement->id?>">

                                                    </td>
                                                    <th>Guardian Name (English)</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="eng_pdar_guardian<?=$settlement->id?>" value="<?=$settlement->eng_pdar_guardian?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Relation</th>
                                                    <td>
                                                        <select id="pdar_rel_guar<?=$settlement->id?>" class="form-control select-sm" disabled>
                                                            <option value="">Select</option>
                                                            <?php foreach ($guar_rel as $guar_rel_list) {?>
                                                                <option value="<?=$guar_rel_list->id?>" <?php if($guar_rel_list->id == $settlement->pdar_rel_guar) {
                                                                    echo "selected";
                                                                }?>><?=$guar_rel_list->guard_rel_desc_as?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </td>
                                                    <th>Gender</th>
                                                    <td>
                                                        <select disabled class="form-control" id="pdar_gender<?=$settlement->id?>">
                                                            <option value="">Select...</option>
                                                            <option value="1" <?php if($settlement->pdar_gender == "1") {
                                                                echo "selected";
                                                            }?>>Male</option>
                                                            <option value="2" <?php if($settlement->pdar_gender == "2") {
                                                                echo "selected";
                                                            }?>>Female</option>
                                                            <option value="3" <?php if($settlement->pdar_gender == "3") {
                                                                echo "selected";
                                                            }?>>Others</option>
                                                        </select>
                                                    </td>
                                                <tr>
                                                    <th>DOB</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="dob<?=$settlement->id?>" value="<?=$settlement->dob?>">
                                                    </td>
                                                    <?php if($settlement->is_applicant == 1): ?>
                                                        <th>Marital Status</th>
                                                        <td>
                                                            <select class="form-control" disabled id="marital_status<?=$settlement->id?>">
                                                                <option value="">Select...</option>
                                                                <?php
                                                                foreach(json_decode(MARITAL_STATUS) as $marital_stat) {
                                                                    ?>
                                                                    <option value="<?=$marital_stat->CODE?>" <?php if($marital_stat->CODE == $settlement->marital_status) {
                                                                        echo "selected";
                                                                    }?>>
                                                                        <?=$marital_stat->NAME?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <tr>
                                                    <th>Mobile</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile?>">

                                                    </td>
                                                    <th>
                                                        Permanent address
                                                    </th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="pdar_add1<?=$settlement->id?>" value="<?=$settlement->pdar_add1?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Present address</th>
                                                    <td>
                                                        <input type="text" readonly class="form-control input-sm" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2?>">
                                                    </td>
                                                    <td colspan="2" style="vertical-align : middle;text-align:center;">
                                                        <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning">Edit Data</button>
                                                        <button type="button" onclick="openApplicant();" class="btn btn-sm btn-primary"><strong>Add Data</strong></button>
                                                        <?php if($settlement->is_applicant != 1) { ?>
                                                            <button onclick="deleteApplicant(<?=$settlement->id?>)" id="<?=$settlement->id?>_<?=$i?>" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-trash-o"></i>
                                                                Delete
                                                            </button>
                                                        <?php }?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                        <?php $i++; endforeach; ?>

                                    <?php if($applicants_owners == true) { ?>
                                        <h5 class="reza-title" style="margin-top: 50px">
                                            <i class="fa fa-user-secret"></i>  Land Owner Details
                                        </h5>
                                        <div class="tableCard">
                                            <table class="table table-bordered">
                                                <?php foreach($applicants_owners as $owners) { ?>
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
                                                                <option value="i" <?php if($owners->inplaceAlognwith == 'i') {
                                                                    echo "selected";
                                                                } ?> >In Place</option>
                                                                <option value="a" <?php if($owners->inplaceAlognwith == 'a') {
                                                                    echo "selected";
                                                                } ?>>Along with</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    <?php } ?>

                                    <!-- Occupier details starts here -->
                                    <?php
                                        //*********occupiers details  */
                                        include(APPPATH."views/NcVillageService/Common/Includes/encroacherDetails.php");
                                    ?>

                                    <!-- Occupier details ends here -->

                                    <?php if($basic["bhumiputra_certificate_no"]) {?>
                                        <h5 class="reza-title" style="margin-top: 50px">
                                            <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                                        </h5>
                                        <div class="tableCard">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Bhumiputra Certificate/Ack verified?</th>
                                                    <td align="center">

                                                        <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="YES" <?php if(trim($basic['bhumiputra_confirmation']) == YES) {
                                                            echo "checked";
                                                        } ?>>
                                                        <label for="bhumi_confirmation">Yes</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                                                        <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="NO" <?php if(trim($basic['bhumiputra_confirmation']) == NO) {
                                                            echo "checked";
                                                        } ?>>
                                                        <label for="bhumi_confirmation">No</label>

                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="bhumiputra_certificate_type" value="<?php
                                                        if($basic["bhumiputra_certificate_no"] == BHUMI_CERT) {
                                                            echo BHUMI_CERT;
                                                        } elseif($basic["bhumiputra_certificate_no"] == BHUMI_ACK) {
                                                            echo BHUMI_ACK;
                                                        }?>">
                                                        <input type="hidden" name="bhumiputra_certificate_no" value="<?=$basic["bhumiputra_certificate_no"]?>">
                                                        Certificate/Ack number : <b><?=$basic["bhumiputra_certificate_no"]?></b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php }?>


                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-bank"></i>  Board Details
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered <?php if(form_error('board_name')){echo 'is-invalid';} ?>">
                                            <tr>
                                                <th>Board Name</th>
                                                <td>
                                                    <?php
                                                        $teaSelected = '';
                                                        $cofSelected = '';
                                                        $rubSelected = '';

                                                        if(isset($err_return))
                                                        {
                                                            if(set_value('board_name') == 'TEA')
                                                            {
                                                                $teaSelected = 'selected';
                                                            }
                                                            else
                                                            {
                                                                if(trim($basic['cult_board']) == 'TEA')
                                                                {
                                                                    $teaSelected = 'selected';
                                                                }
                                                            }
                                                        }
                                                       
                                                        if(isset($err_return))
                                                        {
                                                            if(set_value('board_name') == 'COFFEE')
                                                            {
                                                                $cofSelected = 'selected';
                                                            }
                                                            else
                                                            {
                                                                if(trim($basic['cult_board']) == 'COFFEE')
                                                                {
                                                                    $cofSelected = 'selected';
                                                                }
                                                            }
                                                        }

                                                        if(isset($err_return))
                                                        {
                                                            if(set_value('board_name') == 'RUBBER')
                                                            {
                                                                $rubSelected = 'selected';
                                                            }
                                                            else
                                                            {
                                                                if(trim($basic['cult_board']) == 'RUBBER')
                                                                {
                                                                    $rubSelected = 'selected';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <select name="board_name" id="cult_board" class="form-control">

                                                        <option value="TEA" <?=$teaSelected?>>TEA</option>
                                                        <option value="COFFEE" <?=$cofSelected?>>COFFEE</option>
                                                        <option value="RUBBER" <?=$rubSelected?>>RUBBER</option>
                                                    </select>
                                                    <?=form_error('board_name')?>

                                                    <!-- <input type="text" name="board_name" value="<?php echo $basic['cult_board'] ?>" class="form-control" readonly> -->
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Board Registration Number </th>
                                                <td>
                                                    <input type="text" name="cultboard_reg_no" value="<?php if(isset($err_return)){ echo set_value('cultboard_reg_no');}else{ echo $basic['cultboard_reg_no'];} ?>" class="form-control <?php if(form_error('cultboard_reg_no')){echo 'is-invalid';} ?>">
                                                    <?=form_error('cultboard_reg_no')?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-map"></i>  Area Details
                                    </h5>
                                    <div class="tableCard">
                                        <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;" class="<?php if(form_error('totalAppliedAdditionalArea')) {
                                            echo 'is-invalid';
                                        } ?>">
                                            <?=form_error('totalAppliedAdditionalArea');?>
                                        </div>
                                        <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                                             class="<?php if(form_error('totalAppliedAreaInUrban')) {
                                                 echo 'is-invalid';
                                             } ?>">
                                            <?=form_error('totalAppliedAreaInUrban');?>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th class="text-center">Bigha</th>
                                                <th class="text-center">Katha</th>
                                                <th class="text-center"><?=$lessa_chatak?></th>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <th class="text-center">Ganda</th>
                                                    <th class="text-center">Kranti</th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <?php
                                            $total_home_bigha=0;
                                            $total_home_katha=0;
                                            $total_home_lessa=0;
                                            $total_home_ganda=0;
                                            $total_home_kranti=0;

                                            $total_agri_bigha=0;
                                            $total_agri_katha=0;
                                            $total_agri_lessa=0;
                                            $total_agri_ganda=0;
                                            $total_agri_kranti=0;

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

                                            foreach($dags as $dags_dag) {
                                                $total_home_bigha=$total_home_bigha+$dags_dag->home_b;
                                                $total_home_katha=$total_home_katha+$dags_dag->home_k;
                                                $total_home_lessa=$total_home_lessa+$dags_dag->home_lc;
                                                $total_home_ganda=$total_home_ganda+$dags_dag->home_g;
                                                $total_home_kranti=$total_home_kranti+$dags_dag->home_kr;

                                                $total_agri_bigha=$total_agri_bigha+$dags_dag->agri_b;
                                                $total_agri_katha=$total_agri_katha+$dags_dag->agri_k;
                                                $total_agri_lessa=$total_agri_lessa+$dags_dag->agri_lc;
                                                $total_agri_ganda=$total_agri_ganda+$dags_dag->agri_g;
                                                $total_agri_kranti=$total_agri_kranti+$dags_dag->agri_kr;


                                                ?>
                                                <tr>
                                                    <th rowspan="4" style="vertical-align : middle;">
                                                        <div class="vertical">
                                                            DAG : <span class="text-danger"><?=$dags_dag->dag_no?></span> &nbsp;|&nbsp;
                                                            PATTA : <span class="text-danger"><?=$dags_dag->patta_no?></span>
                                                        </div>
                                                        <input type="hidden" id="dag_no<?=$dags_dag->dag_no?>" value="<?=$dags_dag->dag_no?>">
                                                        <input type="hidden" id="patta_no<?=$dags_dag->dag_no?>" value="<?=$dags_dag->patta_no?>">
                                                        <input type="hidden" id="urbanCheck<?=$dags_dag->dag_no?>" value="<?=$dags_dag->is_urban?>">
                                                    </th>
                                                    <th class="bg-white">Total Land Area in Selected Dag</th>
                                                    <td class="bg-white">
                                                        <strong>
                                                            <input type="text" style="text-align: center;" id="dag_area_b<?=$dags_dag->dag_no?>" name="dag_area_b<?=$dags_dag->dag_no?>" class="form-control input-sm" value="<?php echo $dags_dag->dag_area_b;?>" readonly>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white">
                                                        <input id="dag_area_k<?=$dags_dag->dag_no?>" type="text" style="text-align: center;" name="dag_area_k<?=$dags_dag->dag_no?>" value="<?=$dags_dag->dag_area_k;?>" class="form-control input-sm" readonly>
                                                    </td>
                                                    <td class="bg-white">
                                                        <input type="text" style="text-align: center;" name="dag_area_lc<?=$dags_dag->dag_no?>" id="dag_area_lc<?=$dags_dag->dag_no?>" class="form-control input-sm" value="<?php echo $dags_dag->dag_area_lc;?>" readonly>
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="bg-white">
                                                            <input type="text" style="text-align: center;" value="<?php  echo $dags_dag->dag_area_g;?>" class="form-control input-sm" name="dag_area_g<?=$dags_dag->dag_no?>" id="dag_area_g<?=$dags_dag->dag_no?>" readonly>
                                                        </td>
                                                        <td class="bg-white">
                                                            <input type="text" style="text-align: center;" value="<?php
                                                            echo $dags_dag->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$dags_dag->dag_no?>" id="dag_area_kr<?=$dags_dag->dag_no?>" readonly>
                                                        </td>
                                                    <?php endif;?>
                                                </tr>

                                                <?php
                                                $encroachment_area = json_decode($dags_dag->encroachement_area);
                                                ?>
                                                <tr class="hide">
                                                    <th class="text-primary enc-area-color">Encroachment Area (Homestead)</th>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$dags_dag->dag_no?>" id="enc_home_b<?=$dags_dag->dag_no?>" class="form-control input-sm enc_home_b" value="<?php echo $encroachment_area->homestead->bigha;?>">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$dags_dag->dag_no?>" id="enc_home_k<?=$dags_dag->dag_no?>" value="<?php echo $encroachment_area->homestead->katha;?>" class="form-control input-sm enc_home_k">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$dags_dag->dag_no?>" id="enc_home_lc<?=$dags_dag->dag_no?>" class="form-control input-sm enc_home_lc " value="<?php echo $encroachment_area->homestead->lessa;?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $encroachment_area->homestead->ganda;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$dags_dag->dag_no?>" id="enc_home_g<?=$dags_dag->dag_no?>">
                                                        </td>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $encroachment_area->homestead->kranti;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$dags_dag->dag_no?>" id="enc_home_kr<?=$dags_dag->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <tr>
                                                    <th class="text-primary enc-area-color">Encroachment Area (Agricultural)</th>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_agri_b<?=$dags_dag->dag_no?>" id="enc_agri_b<?=$dags_dag->dag_no?>" class="form-control input-sm agri_b" value="<?php echo $encroachment_area->agriculture->bigha;?>">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_agri_k<?=$dags_dag->dag_no?>" id="enc_agri_k<?=$dags_dag->dag_no?>" value="<?php echo $encroachment_area->agriculture->katha;?>" class="form-control input-sm agri_k">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_agri_lc<?=$dags_dag->dag_no?>" id="enc_agri_lc<?=$dags_dag->dag_no?>" class="form-control input-sm agri_lc" value="<?php echo $encroachment_area->agriculture->lessa;?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $encroachment_area->agriculture->ganda;
                                                            ?>" class="form-control input-sm agri_g" name="enc_agri_g<?=$dags_dag->dag_no?>" id="enc_agri_g<?=$dags_dag->dag_no?>" onkeyup="agriArea()">
                                                        </td>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $encroachment_area->agriculture->kranti;
                                                            ?>" class="form-control input-sm agri_kr" name="enc_agri_kr<?=$dags_dag->dag_no?>" id="enc_agri_kr<?=$dags_dag->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <tr class="hide">
                                                    <th class="text-primary settlement-area-color">Area for Settlement (Homestead)</th>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="home_b<?=$dags_dag->dag_no?>" class="form-control input-sm home_b" value="<?php echo $dags_dag->home_b;
                                                        ?>" onkeyup="totalAreaCal()" id="home_b<?=$dags_dag->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="home_k<?=$dags_dag->dag_no?>" value="<?php echo $dags_dag->home_k;?>" class="form-control input-sm home_k" onkeyup="totalAreaCal()" id="home_k<?=$dags_dag->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="home_lc<?=$dags_dag->dag_no?>" class="form-control input-sm s_dag_area_lc" value="<?php echo $dags_dag->home_lc;?>" onkeyup="totalAreaCal()" id="home_lc<?=$dags_dag->dag_no?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $dags_dag->home_g;?>" class="form-control input-sm s_dag_area_g" name="home_g<?=$dags_dag->dag_no?>" onkeyup="totalAreaCal()" id="home_g<?=$dags_dag->dag_no?>">
                                                        </td>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $dags_dag->home_kr;?>" class="form-control input-sm s_dag_area_kr" name="home_kr<?=$dags_dag->dag_no?>" onkeyup="totalAreaCal()" id="home_kr<?=$dags_dag->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>

                                                <tr style="border-bottom:1px solid #227576">
                                                    <th class="text-primary settlement-area-color">Area for Settlement (Agricultural)</th>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="agri_b<?=$dags_dag->dag_no?>" class="form-control input-sm agri_b" value="<?php echo $dags_dag->agri_b;?>" onkeyup="agriArea()" id="agri_b<?=$dags_dag->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="agri_k<?=$dags_dag->dag_no?>" value="<?php echo $dags_dag->agri_k;?>" class="form-control input-sm agri_k" onkeyup="agriArea()" id="agri_k<?=$dags_dag->dag_no?>">
                                                    </td>
                                                    <td class="settlement-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="agri_lc<?=$dags_dag->dag_no?>" class="form-control input-sm agri_lc" value="<?php echo $dags_dag->agri_lc;
                                                        ?>" onkeyup="agriArea()" id="agri_lc<?=$dags_dag->dag_no?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $dags_dag->agri_g;?>" class="form-control input-sm agri_g" name="agri_g<?=$dags_dag->dag_no?>" onkeyup="agriArea()" id="agri_g<?=$dags_dag->dag_no?>">
                                                        </td>
                                                        <td class="settlement-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?php echo $dags_dag->agri_kr;?>" class="form-control input-sm agri_kr" name="agri_kr<?=$dags_dag->dag_no?>" onkeyup="agriArea()" id="agri_kr<?=$dags_dag->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="4">
                                                        <button type="button" onclick="editArea(<?=$dags_dag->id?>,<?=$dags_dag->dag_no?>);" class="btn btn-sm btn-warning">Edit Area</button>
                                                        <?php if(ENABLE_DAG_ELIGIBLE_BUTTON != 0){
                                                            if($dag_count>1){?>
                                                                <button type="button" id="deldag<?=$dags_dag->id?>" onclick="deleteDag(<?=$dags_dag->id?>,<?=$dags_dag->dag_no?>);" class="btn btn-sm btn-danger"><i class="fa fa-remove" style="color:white"></i> Dag Not Eligible</button>
                                                                <button type="button" id="insdag<?=$dags_dag->id?>" onclick="insertDag(<?=$dags_dag->id?>,<?=$dags_dag->dag_no?>);" class="btn btn-sm btn-success" style="display:none">Eligible</button>
                                                            <?php } }?>

                                                        <div id="dageligiblemsg<?=$dags_dag->id?>" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; display:none">
                                                    </td>
                                                </tr>
                                            <?php }?>


                                            <?php
                                            // for dag not eligible
                                            include(APPPATH."views/NcVillageService/Common/Includes/dagNotEligibleView.php");
                                            ?>

                                            <tr class="bg-white hide" style="border-top: 3px solid #227576;">
                                                <th colspan="2"></th>
                                                <th class="text-danger">
                                                    Total Settlement Area (Homestead)
                                                    <span class="<?php if(form_error('khasMaxHomestead')) {
                                                        echo 'is-invalid';
                                                    }?>"></span>
                                                    <?=form_error('khasMaxHomestead');?>
                                                </th>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_bigha" required class="form-control input-sm s_dag_area_b" id="total_applied_home_bigha" value="<?php if(isset($err_return)) {
                                                        echo set_value('total_applied_area_homestead_bigha');
                                                    } else {
                                                        echo $total_home_bigha;
                                                    }?>" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_katha" required value="<?php if(isset($err_return)) {
                                                        echo set_value('total_applied_area_homestead_katha');
                                                    } else {
                                                        echo $total_home_katha;
                                                    }?>" id="total_applied_home_katha" class="form-control input-sm s_dag_area_k" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_lessa" required class="form-control input-sm s_dag_area_lc" id="total_applied_home_lessa" value="<?php if(isset($err_return)) {
                                                        echo set_value('total_applied_area_homestead_lessa');
                                                    } else {
                                                        echo $total_home_lessa;
                                                    }?>" >
                                                </td>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <td>
                                                        <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                            echo set_value('total_applied_area_homestead_ganda');
                                                        } else {
                                                            echo $total_home_ganda;
                                                        }?>" required class="form-control input-sm s_dag_area_g" id="total_applied_home_ganda" name="total_applied_area_homestead_ganda" >
                                                    </td>
                                                    <td class="hide">
                                                        <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                            echo set_value('total_applied_area_homestead_kranti');
                                                        } else {
                                                            echo $total_home_ganda;
                                                        }?>" required class="form-control input-sm s_dag_area_kr" id="total_applied_home_kranti" name="total_applied_area_homestead_kranti" >
                                                    </td>
                                                <?php endif;?>
                                            </tr>
                                            <tr style="border-top: 3px solid #227576;">
                                                <th class="text-danger" colspan="2">
                                                    Total applied area (Agricultural)
                                                    <span class="<?php if(form_error('khasMaxAgriculture')) {
                                                        echo 'is-invalid';
                                                    }?>"></span>
                                                    <?=form_error('khasMaxAgriculture');?>
                                                </th>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_bigha" class="form-control input-sm ag_dag_area_b"  id="total_applied_agri_bigha"
                                                           value="<?php echo $total_agri_bigha;?>">
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_katha" value="<?php echo $total_agri_katha;?>" id="total_applied_agri_katha"  class="form-control input-sm ag_dag_area_k" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_lessa" class="form-control input-sm ag_dag_area_lc" id="total_applied_agri_lessa"  value="<?php echo $total_agri_lessa;?>" >
                                                </td>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <td>
                                                        <input readonly type="text" style="text-align: center;" value="<?php echo $total_agri_ganda;?>" class="form-control input-sm ag_dag_area_g" id="total_applied_agri_ganda"  name="total_applied_area_agricultural_ganda" >
                                                    </td>
                                                    <td class="hide">
                                                        <input readonly type="text" style="text-align: center;" value="<?php echo $total_agri_kranti;?>" class="form-control input-sm ag_dag_area_kr" id="total_applied_agri_kranti"  name="total_applied_area_agricultural_kranti" >
                                                    </td>
                                                <?php endif;?>
                                            </tr>

                                            
                                        </table>
                                    </div>

                                    <!--- Nominee details starts here --mdz- --->
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Family Details
                                        <?php if(ENABLE_FAMILY_BUTTON != 0) {?>
                                            <span class="pull-right"><button type="button" onclick="addFamily();" class="btn btn-sm btn-warning" style="margin-top:-5px !important">Add Family</button></span>
                                        <?php } ?>
                                    </h5>
                                    <?php if(!empty($nominee)) { ?>
                                        <div class="tableCard">
                                            <table class="table table-bordered" id="listNextOfKin">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relation</th>
                                                    <th>Address</th>
                                                    <th>Mobile number</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php $i=1;
                                                foreach($nominee as $kin): ?>
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
                                                            <button type="button" onclick="addFamily();" class="btn btn-sm btn-success">Add</button>
                                                            <button type="button" onclick="confirmDeleteFamily(<?=$kin->id?>);" class="btn btn-sm btn-danger">Delete</button>
                                                        </td>
                                                    </tr>

                                                    <?php $i++;?>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                        <?php
                                    }
                                    else
                                    { ?>
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
                                    <?php } ?>

                                    <!--- Nominee details ends here --mdz- --->
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-file-pdf-o"></i> Supporting Documents
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php foreach($document as $d): ?>
                                                <tr>
                                                    <th>
                                                        <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                                        <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                                        <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                                        <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                                        <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                                        <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                                                    </th>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                    <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
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

                        <!-- LM reporting starts here -->
                        <div class="tab-pane" role="tabpanel" id="step2">
                            <h5  class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                                <?php echo $this->lang->line('teaSpecialCultivatorsName') ?> (
                                <span class="bg-warning"><?=$case_no?></span> )
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
                                                <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                                                <?=form_error('chitha_verified')?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('chitha_verified')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="chitha_verified"
                                                            id="chiitha_verified1"
                                                            value="YES"
                                                        <?php if(set_value('chitha_verified') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('chitha_verified')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="chitha_verified"
                                                            id="chiitha_verified2"
                                                            value="NO"
                                                        <?php if(set_value('chitha_verified') == 'NO') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                foreach ($dags as $ddg) {
                                                    $patta_code = $this->utilityclass->getPattaTypeNo($ddg->dist_code, $ddg->subdiv_code, $ddg->cir_code, $ddg->mouza_pargona_code, $ddg->lot_no, $ddg->vill_townprt_code, $ddg->dag_no);

                                                    ?>
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $ddg->dag_no . '&m=' . $ddg->mouza_pargona_code . '&l=' . $ddg->lot_no . '&v=' . $ddg->vill_townprt_code . '&p=' . $patta_code->patta_type_code . '&dist=' . $ddg->dist_code . '&cir=' . $ddg->cir_code . '&sub_div=' . $ddg->subdiv_code ?>">
                                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                                                    </a>
                                                    <br>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> VLB Verified?</span>

                                                <?=form_error('vlb_verified')?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('vlb_verified')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="vlb_verified"
                                                            id="vlb_verified1"
                                                            value="YES"
                                                        <?php if(set_value('vlb_verified') == 'YES') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('vlb_verified')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="vlb_verified"
                                                            id="vlb_verified2"
                                                            value="NO"
                                                        <?php if(set_value('vlb_verified') == 'NO') {
                                                            echo "checked";
                                                        } ?>
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

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span>
                                                <?=form_error('bhumiputra_confirmation_lm')?>
                                                <br>
                                                <?php
                                                if(!empty($bhumi)) {
                                                    if($bhumi[0]->bhumi_cert_available || $bhumi[0]->is_bhumi_applied) {?>
                                                        <label for="" class="alert-warning">Certificate/Ack number : <b><?=$bhumi[0]->bhumi_ack_no?></b></label>
                                                    <?php } else { ?>
                                                        <label for="" class="alert-warning">Certificate Not Available!</b></label>
                                                    <?php }
                                                }?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="bhumiputra_confirmation_lm"
                                                            id="bhumiputra_confirmation1"
                                                            value="YES"
                                                        <?php if(set_value('bhumiputra_confirmation_lm') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="bhumiputra_confirmation_lm"
                                                            id="bhumiputra_confirmation2"
                                                            value="NO"
                                                        <?php if(set_value('bhumiputra_confirmation_lm') == 'NO') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if(!empty($bhumi)) {
                                                    if($bhumi[0]->bhumi_cert_available || $bhumi[0]->is_bhumi_applied) {
                                                        ?>
                                                        <i class="fa fa-link" aria-hidden="true"></i>
                                                        <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                                                        if($bhumi[0]->bhumi_cert_available == 1) {
                                                            echo "cer_number=".$bhumi[0]->bhumi_ack_no;
                                                        } elseif($bhumi[0]->is_bhumi_applied == 1) {
                                                            echo "ack_number=".$bhumi[0]->bhumi_ack_no;
                                                        }?>" target="BhumiPutra">
                                                            <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                                        </a>
                                                    <?php }
                                                } ?>
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
                                                            class="form-check-input <?php if(form_error('possession_verification')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="possession_verification"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('possession_verification') == 'YES') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('possession_verification')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="possession_verification"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('possession_verification') == 'NO') {
                                                            echo "checked";
                                                        } ?>

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



                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                                Tribal Belt/ Block.</span>
                                                <?=form_error('is_tribal_belt')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">

                                                    <input
                                                            class="form-check-input <?php if(form_error('is_tribal_belt')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_tribal_belt"
                                                            id="whether_tribal1"
                                                            value="YES"
                                                        <?php
                                                        if(isset($err_return)) {
                                                            if(set_value('is_tribal_belt') == 'YES') {
                                                                echo "checked";
                                                            }
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_tribal_belt')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_tribal_belt"
                                                            id="whether_tribal2"
                                                            value="NO"
                                                        <?php
                                                        if(isset($err_return)) {
                                                            if(set_value('is_tribal_belt') == 'NO') {
                                                                echo "checked";
                                                            }
                                                        }
                                                        ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6 text-justify">
                                            <span><strong><?=$sl_count++?>.</strong>
                                                Does applicant falls under protected category?</span>
                                                <?=form_error('protected_class_lm')?>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select name="protected_class_lm" id="protected_class_lm" class="form-control
                                                <?php if(form_error('protected_class_lm')) {
                                                    echo 'lm_invalid';
                                                }?>" required>
                                                    <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                                                        <option value="<?php echo $class->CODE ?>"
                                                            <?php if(set_value('protected_class_lm') == $class->CODE) {
                                                                echo "selected";
                                                            } ?>>
                                                            <?php echo $class->NAME ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ?
                                            </span>
                                                <?=form_error('landslide')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('landslide')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="landslide"
                                                            id="landslide"
                                                            value=<?=YES ?>
                                                            <?php if(set_value('landslide') == YES) {
                                                                echo "checked";
                                                            } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('landslide')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="landslide"
                                                            id="landslide2"
                                                            value=<?=NO ?>
                                                            <?php if(set_value('landslide') == NO) {
                                                                echo "checked";
                                                            } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Whether the land falls under erosion ?
                                            </span>
                                                <?=form_error('erosion')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('erosion')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="erosion"
                                                            id="landslide"
                                                            value=<?=YES?>
                                                            <?php if(set_value('erosion') == YES) {
                                                                echo "checked";
                                                            } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('erosion')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="erosion"
                                                            id="landslide2"
                                                            value=<?=NO?>
                                                            <?php if(set_value('erosion') == NO) {
                                                                echo "checked";
                                                            } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong>
                                                Whether proposed land is under litigation?</span>
                                                <?=form_error('litigation')?>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('litigation')) {
                                                        echo 'lm_invalid';
                                                    }?>"
                                                           type="radio"
                                                           name="litigation"
                                                           id="landed_property1"
                                                           value="YES"
                                                        <?php if(set_value('litigation') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('litigation')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="litigation"
                                                            id="landed_property2"
                                                            value="NO"
                                                        <?php if(set_value('litigation') == 'NO') {
                                                            echo "checked";
                                                        } ?>
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

                                        

                                        <!---// Add additional land detail modal --->
                                        <?php include 'application/views/NcVillageService/Common/Includes/settlementPropertyModal.php'; ?>
                                        <!---// Add additional land detail modal --->

                                        <?php if(ENABLE_CHECK_LAND != 0) {?>
                                            <!---// Land exist check modal --->
                                            <?php
                                            $identity_type=$aadhar[0]->identity_type;
                                            $identity_ref_no=$aadhar[0]->identity_ref_no;
                                            ?>
                                            <div style="margin: 10px">
                                                <?php include(APPPATH."views/NcVillageService/Common/Includes/landCheck.php"); ?>
                                            </div>

                                            <!---// Land exist check modal end --->
                                        <?php } ?>


                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Landed property of
                                                the petitioner and his family (if any) within the State
                                                <?=form_error('landed_property')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('landed_property')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="landed_property"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('landed_property') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('landed_property')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="landed_property"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('landed_property') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> The Applicant should undertake
                                                special cultivation of <?php echo $basic['cult_board'] ?> as a means of livelihood
                                                <?=form_error('livelihood')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('livelihood')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="livelihood"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('livelihood') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('livelihood')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="livelihood"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('livelihood') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Suitability of proposed land
                                                for <?php echo $basic['cult_board'] ?> cultivation
                                                <?=form_error('suitability')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('suitability')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="suitability"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('suitability') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('suitability')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="suitability"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('suitability') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Patta land of applicant’s family.
                                                This should be deducted from the total admissible area
                                                <?=form_error('admissible_area')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('admissible_area')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="admissible_area"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('admissible_area') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('admissible_area')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="admissible_area"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('admissible_area') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Weather the applicant has been
                                                allotted govt land before
                                                <?=form_error('govt_allotted')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('govt_allotted')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="govt_allotted"
                                                            id="inlineRadio1"
                                                            value="YES"
                                                        <?php if(set_value('govt_allotted') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('govt_allotted')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="govt_allotted"
                                                            id="inlineRadio2"
                                                            value="NO"
                                                        <?php if(set_value('govt_allotted') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Whether the petitioner is
                                                differently abled/SC/ST/OBC/Ex-serviceman/Widow/others
                                                <?=form_error('is_st')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_st')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_st"
                                                            id="is_st1"
                                                            value="YES"
                                                        <?php if(set_value('is_st') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_st')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_st"
                                                            id="is_st2"
                                                            value="NO"
                                                        <?php if(set_value('is_st') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong>Whether the applicant is
                                                indigenous unemployed educated youth
                                                <?=form_error('is_indigenous')?>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_indigenous')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_indigenous"
                                                            id="is_indigenous1"
                                                            value="YES"
                                                        <?php if(set_value('is_indigenous') == 'YES') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_indigenous')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_indigenous"
                                                            id="is_indigenous2"
                                                            value="NO"
                                                        <?php if(set_value('is_indigenous') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong>Whether registered with <?php echo $basic['cult_board'] ?> Board
                                                of India/Directorate of <?php echo $basic['cult_board'] ?>, Assam
                                                <?=form_error('is_reg_with_teaboard')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_reg_with_teaboard')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_reg_with_teaboard"
                                                            id="is_reg_with_teaboard1"
                                                            value="YES"
                                                        <?php if(set_value('is_reg_with_teaboard') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('is_reg_with_teaboard')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="is_reg_with_teaboard"
                                                            id="is_reg_with_teaboard2"
                                                            value="NO"
                                                        <?php if(set_value('is_reg_with_teaboard') == 'NO') {
                                                            echo "checked";
                                                        } ?>

                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6 text-justify">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Category of the proposed land?
                                            </span>

                                                <?=form_error('land_falls')?>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <select name="land_falls" id="land_falls" class="form-control <?php if(form_error('land_falls')) {
                                                    echo 'lm_invalid';
                                                }?>">
                                                    <option value="">Select...</option>
                                                    <?php foreach(json_decode(LB_NATURE_OF_RESERVATION) as $landCode): ?>
                                                        <option value="<?php echo $landCode->CODE ?>"

                                                            <?php if(set_value('land_falls') == $landCode->CODE) {
                                                                echo "selected";
                                                            } ?>>

                                                            <?php echo $landCode->NAME ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row p-2" >
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
                                                            class="form-check-input <?php if(form_error('falls_und_gmc')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="falls_und_gmc"
                                                            id="falls_und_gmc"
                                                            value="YES"
                                                            onclick="forcedUrban('YES');"
                                                        <?php if(set_value('falls_und_gmc') == 'YES') {
                                                            echo "checked";
                                                        } ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('falls_und_gmc')) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                            type="radio"
                                                            name="falls_und_gmc"
                                                            id="falls_und_gmc"
                                                            value="NO"
                                                            onclick="forcedUrban('NO');"
                                                        <?php if(set_value('falls_und_gmc') == 'NO') {
                                                            echo "checked";
                                                        } ?>

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
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                                /riverside reservation (if any, along with provision kept for road/drain
                                                wherever necessary)</span>
                                                <?=form_error('roadside_comment_check')?>
                                                <!-- this only to display the error message in area validation -->
                                                <span class="<?php if(form_error('reserveMoreThanAppArea')) {
                                                    echo 'lm_invalid';
                                                }?>"></span>
                                                <?=form_error('reserveMoreThanAppArea');?>

                                                <?php
                                                foreach($dags as $dags_roadside) {
                                                    echo form_error('reserved_bigha'.$dags_roadside->dag_no);
                                                    echo form_error('reserved_katha'.$dags_roadside->dag_no);
                                                    echo form_error('reserved_lessa'.$dags_roadside->dag_no);
                                                    echo form_error('reserved_ganda'.$dags_roadside->dag_no);
                                                    echo form_error('reserved_kranti'.$dags_roadside->dag_no);
                                                }
                                                ?>


                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" onclick="roadSideReservYes();" class="form-check-input roadside_comment_check1 <?php if(form_error('roadside_comment_check')) {
                                                        echo 'lm_invalid';
                                                    }?>" name="roadside_comment_check" id="roadside_comment_check1" value="YES" <?php if(set_value('roadside_comment_check') == 'YES') {
                                                        echo "checked";
                                                    } ?>>
                                                    <label for="roadside">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio"  onclick="roadSideReservNo();" class="form-check-input roadside_comment_check2 <?php if(form_error('roadside_comment_check')) {
                                                        echo 'lm_invalid';
                                                    }?>" name="roadside_comment_check" id="roadside_comment_check2" value="NO" <?php if(set_value('roadside_comment_check') == 'NO') {
                                                        echo "checked";
                                                    } ?>>
                                                    <label for="roadside">No</label>
                                                </div>
                                                <div id="road_side_reservation_hide" class="road_side_reservation_hide" style="display: none;">
                                                    <?php
                                                    // echo "<pre>";
                                                    // var_dump($dags);
                                                    // die;

                                                    foreach($dags as $roadside_dags) { ?>
                                                        <div class="form-group row mt-2">
                                                            <input type="hidden" value="<?=$roadside_dags->dag_no?>" class="form-control input-sm" name="reserved_dag_road<?=$roadside_dags->dag_no?>" id="reserved_dag_road">
                                                            <input type="hidden" value="<?=$roadside_dags->patta_no?>" class="form-control input-sm" name="reserved_patta_road<?=$roadside_dags->dag_no?>" id="reserved_patta_road">
                                                            <label for="area-reserved" class="mb-2"><b>Enter road side reserve area in Dag No: <?=$roadside_dags->dag_no?></b></label>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Bigha</span>
                                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                                    echo set_value('reserved_bigha'.$roadside_dags->dag_no);
                                                                } else {
                                                                    echo "0";
                                                                }?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_bigha'.$roadside_dags->dag_no)) {
                                                                    echo 'lm_invalid';
                                                                }?>" name="reserved_bigha<?=$roadside_dags->dag_no?>" id="reserved_bigha<?=$roadside_dags->dag_no?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Katha</span>
                                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                                    echo set_value('reserved_katha'.$roadside_dags->dag_no);
                                                                } else {
                                                                    echo "0";
                                                                }?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_katha'.$roadside_dags->dag_no)) {
                                                                    echo 'lm_invalid';
                                                                }?>" name="reserved_katha<?=$roadside_dags->dag_no?>" id="reserved_katha<?=$roadside_dags->dag_no?>" >
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="input-group-addon">Lessa</span>
                                                                <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                                    echo set_value('reserved_lessa'.$roadside_dags->dag_no);
                                                                } else {
                                                                    echo "0";
                                                                }?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_lessa'.$roadside_dags->dag_no)) {
                                                                    echo 'lm_invalid';
                                                                }?>" name="reserved_lessa<?=$roadside_dags->dag_no?>" id="reserved_lessa<?=$roadside_dags->dag_no?>" >
                                                            </div>
                                                        </div>
                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <div class="form-group row mt-2">
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Ganda</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                                        echo set_value('reserved_ganda'.$roadside_dags->dag_no);
                                                                    } else {
                                                                        echo "0";
                                                                    }?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_ganda'.$roadside_dags->dag_no)) {
                                                                        echo 'lm_invalid';
                                                                    }?>" name="reserved_ganda<?=$roadside_dags->dag_no?>" id="reserved_ganda<?=$roadside_dags->dag_no?>">
                                                                </div>
                                                                <div class="col-4">
                                                                    <span class="input-group-addon">Kranti</span>
                                                                    <input type="text" onkeyup="roadAreaCheck()" style="text-align: center;" value="<?php if(isset($err_return)) {
                                                                        echo set_value('reserved_kranti'.$roadside_dags->dag_no);
                                                                    } else {
                                                                        echo "0";
                                                                    }?>" class="form-control input-sm reserved_road_value <?php if(form_error('reserved_kranti'.$roadside_dags->dag_no)) {
                                                                        echo 'lm_invalid';
                                                                    }?>" name="reserved_kranti<?=$roadside_dags->dag_no?>" id="reserved_kranti<?=$roadside_dags->dag_no?>">
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
                                                            ><?php if(isset($err_return)) {
                                                                    echo set_value('roadside_reservation');
                                                                }?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Copy of trace map of the proposed land
                                                clearly highlighting the propose land road/riverside reservation etc(if
                                                any)</span>
                                                <?php
                                                foreach($dags as $dags_trace) {
                                                    echo form_error('trace_map_copy'.$dags_trace->dag_no);
                                                }?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                foreach($dags as $dags_trace) {
                                                    ?>
                                                    <span class="alert-warning">For Dag no. : <strong><?=$dags_trace->dag_no?></strong></span>
                                                    <input type="hidden" name="dag_no_doc<?=$dags_trace->dag_no?>" value="<?=$dags_trace->dag_no?>">
                                                    <input
                                                            type="file"
                                                            name="trace_map_copy<?=$dags_trace->dag_no?>"
                                                            id="trace_map_copy"
                                                            class="form-control <?php if(form_error('trace_map_copy'.$dags_trace->dag_no)) {
                                                                echo 'lm_invalid';
                                                            }?>"
                                                    /><br>

                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Field visit report & geo tagged photograph of the land</span>
                                                <?=form_error('field_report')?>
                                                <span class="<?php if(form_error('geo_tag_photo')) {
                                                    echo 'lm_invalid';
                                                }?>"></span>
                                                <?php
                                                if(isset($geo_tag_doc)) {
                                                    echo form_error('geo_tag_photo');
                                                } else {
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
                                                                class="form-control <?php if(form_error('field_report')) {
                                                                    echo 'lm_invalid';
                                                                }?>"
                                                                type="file"
                                                                name="field_report"
                                                                id="field_report"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <label for="inputEmail4">Geo tagged photo</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <?php
                                                        if(isset($geo_tag_doc_empty)) {
                                                            echo $geo_tag_doc_empty;
                                                        }
                                                        if(isset($geo_tag_doc)) {
                                                            foreach($geo_tag_doc as $d):
                                                                ?>
                                                                <span class="alert-warning">For Dag no : <strong><?=$d->dag_no?></strong></span><br>
                                                                <a target='download' href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$d->id?>"><i class="fa fa-paperclip mb-2"></i> <?=$d->file_name;?></a><br>

                                                            <?php endforeach;
                                                        }?>

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
                                                    <textarea name="landmark_east<?=$landmark_dag->dag_no?>" placeholder="Enter East Landmark" id="landmark_east<?=$landmark_dag->dag_no?>" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east'.$landmark_dag->dag_no)) {
                                                        echo 'lm_invalid';
                                                    }?>"><?php echo set_value('landmark_east'.$landmark_dag->dag_no);?></textarea>

                                                    <label for="">West side landmark</label>
                                                    <textarea name="landmark_west<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_west'.$landmark_dag->dag_no)) {
                                                        echo 'lm_invalid';
                                                    }?>" placeholder="Enter West Landmark" id="landmark_west<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php echo set_value('landmark_west'.$landmark_dag->dag_no);?></textarea>

                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">North side landmark</label>
                                                    <textarea name="landmark_north<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_north'.$landmark_dag->dag_no)) {
                                                        echo 'lm_invalid';
                                                    }?>" placeholder="Enter North Landmark" id="landmark_north<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php echo set_value('landmark_north'.$landmark_dag->dag_no);?></textarea>

                                                    <label for="">South side landmark</label>
                                                    <textarea name="landmark_south<?=$landmark_dag->dag_no?>" class="form-control <?php if(form_error('landmark_south'.$landmark_dag->dag_no)) {
                                                        echo 'lm_invalid';
                                                    }?>" placeholder="Enter South Landmark" id="landmark_south<?=$landmark_dag->dag_no?>" cols="30" rows="3"><?php echo set_value('landmark_south'.$landmark_dag->dag_no);?></textarea>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach;
                                        ?>


                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Report of LR staff</label>
                                                <?=form_error('lr_remark')?>
                                            </div>
                                            <div class="col-md-6">

                                                <input type="file" name="lr_remark" id="lr_remark" class="form-control <?php if(form_error('lr_remark')) {
                                                    echo 'lm_invalid';
                                                }?>">
                                                <!-- <textarea name="lr_remark" class="form-control" id="lr_remark" cols="30" rows="2"></textarea> -->
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
                                                <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')) {
                                                    echo 'lm_invalid';
                                                }?>">
                                                    <?php
                                                    foreach(json_decode(LM_NOTE) as $lm_remark_cat) {
                                                        ?>
                                                        <option value="<?=$lm_remark_cat->CODE?>"
                                                            <?php if(set_value('lm_note') == $lm_remark_cat->CODE) {
                                                                echo "selected";
                                                            } ?>
                                                        ><?=$lm_remark_cat->NAME?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>

                                        <?php
                                        include(APPPATH."views/NcVillageService/Common/Includes/rejectedReasons.php");
                                        ?>

                                        <div id="lm_remark_text_id" class="row p-2" style="display: none;">
                                            <div class="col-md-12">
                                                <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control p-3 <?php if(form_error('lm_remark_text')) {
                                                    echo 'lm_invalid';
                                                }?>" id="lm_remark_text" rows="10" cols="70"><?php echo set_value('lm_remark_text');?></textarea>
                                                <input id="validationcheck" type="hidden" class="validationcheck" value="" name="validationcheck" required/>

                                            </div>
                                        </div>

                                        <div class="row p-2" id="sk_for_reject">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong>
                                                <?php
                                                if(trim($sk_availability) == 'y')
                                                {
                                                    echo "<label>Select Supervisor Kanangu (SK)</label>";
                                                }
                                                else
                                                {
                                                    echo "<label>Select Circle Officer (CO)</label>";
                                                }
                                                ?>
                                                <?=form_error('co_code')?>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control <?php if(form_error('co_code')) {
                                                    echo 'lm_invalid';
                                                }?>" name='co_code'>

                                                    <?php
                                                    if($sk_availability == 'y')
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


                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Premium
                                                <?=form_error('validationcheck')?>
                                                <!-- <span>
                                                <?php foreach($revenue as $revenue_premium) {
                                                    foreach($revenue_premium as $revenue_prem) { ?>
                                                    <b>[ Dag No: <?=$revenue_prem->dag_no?> Revenue Rs -  <?=$revenue_prem->dag_revenue?> (B-K-L : <?=$revenue_prem->dag_area_b?>-<?=$revenue_prem->dag_area_k?>-<?=$revenue_prem->dag_area_lc?> )]</b>
                                                <?php }
                                                } ?>
                                                </span> -->
                                            </div>
                                            <div class="col-md-6">
                     
                                                <button type="button" class="rezaButt buttPrimary" onclick="premiumModal();">
                                                    Calculate Premium
                                                </button>
                                                
                                                <div id="messageDiv">

                                                </div>

                                                <input type="hidden" name="dag_revenue" class="form-control dag_revenue" value=<?=$revenue_prem->dag_revenue?>  id="dag_revenue" />
                                                <input type="hidden" name="total_s_lessa" class="form-control total_s_lessa" value=""  id="total_s_lessa" />

                                            </div>
                                        </div>

                                        <div class="row p-2" style="display:none" id="total_due_row">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Total due amount (Rs) </label>
                                                <?=form_error('total_due_amount')?>
                                            </div>
                                            <div class="col-md-6">
                                                <input readonly type="text" name="total_due_amount" class="form-control total_due_amount"  id="total_due_amount" />
                                                <input readonly type="hidden" name="total_final_amount" class="form-control total_final_amount"  id="total_final_amount" />
                                            </div>
                                        </div>

                                        <?php
                                        include(APPPATH."views/NcVillageService/Common/Includes/addMoreDocumentView.php");
                                        ?>


                                    </div>

                                    <?php
                                    include(APPPATH."views/NcVillageService/Common/Includes/village_wise_area_show_lm.php");
                                    ?>
                                </div>
                            </div>

                            <ul class="list-inline pull-right" style="margin-top: 20px">
                                <li>
                                    <button type="button" class="btn btn-default prev-step">
                                        <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                                    </button>
                                </li>
                                <?php if(ENABLE_BUTTON_LM_SUBMIT_CULTI != 0) {?>

                                    <li>
                                        <input type="submit" class="btn btn-primary next-step" id="btnLmSubmit" onClick="this.disabled=true; this.value='Saving...';" value="Save and submit">
                                            <!-- <i class="fa fa-check-square-o" aria-hidden="true"></i> Save & Continue
                                        </button> -->
                                    </li>

                                <?php } ?>
                            </ul>
                        </div>





                        <!-- premium modal start -->
                        <div class="modal" role="dialog" id="premiumModal" style="padding-top: 25px!important;" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10">
                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                PREMIUM CALCULATION
                                            </h5>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" align="right">
                                            <i class="fa fa-times-circle closePremium" aria-hidden="true" style="color: red; font-weight: bold; font-size: 28px"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body" align="">
                                        <?php  $areacount=1;
                                        foreach($dags as $dagsprem) { ?>


                                            <div class="tableCard " style="padding: 25px!important;">
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                                                    </div>
                                                    <div class="form-group col-md-6">

                                                        <input type="number" onkeyup="zonalValueChange<?=$dagsprem->dag_no?>()" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                                               class="zonal_valuation_prem form-control <?php if(form_error('zonal_valuation_prem'.$dagsprem->dag_no)) {
                                                                   echo 'lm_invalid';
                                                               }?>"
                                                               value="<?php if(isset($err_return)){ echo set_value('zonal_valuation_prem'.$dagsprem->dag_no);} else {echo $this->utilityclass->getZonalValue($dagsprem->dist_code,$basic['uuid'],$dagsprem->dag_no);} ?>" placeholder="Enter Amount"/>
                                                    </div>
                                                </div>


                                                <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label for="title">Check Premium</label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="radio" id="concession<?=$dagsprem->dag_no?>" name="concession<?=$dagsprem->dag_no?>" class="concession" value="YES">
                                                        <label for="html">YES</label>
                                                        <!-- <input type="radio" id="concession2" name="concession<?=$dagsprem->dag_no?>" class="concession<?=$dagsprem->dag_no?>" value="NO">
                                    <label for="css">NO</label><br> -->
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                        <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                        <input id="amount_<?=$dagsprem->dag_no?>" type="number"
                                                               class="totalamount form-control" value="" name="amount<?=$dagsprem->dag_no?>" readonly/>
                                                    </div>
                                                </div>
                                            </div>


                                            <script>
                                                //////// for premium

                                                function zonalValueChange<?=$dagsprem->dag_no?>(){
                                                    $('#amount_<?=$dagsprem->dag_no?>').val('');
                                                    $('#totaldue').val('');
                                                    $("#finalamount").val('');
                                                    $("#totaldue").val('');
                                                    $(".premhide").hide();
                                                    $("#finalsubmit").show();
                                                    $("#finalsave").hide();
                                                    $(".paymode").prop( "checked", false );

                                                }

                                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                $("input[name=concession<?=$dagsprem->dag_no?>]").on("click", function () {

                                                    var appbigha_total=parseFloat($("#total_applied_agri_bigha").val());
                                                    var appkatha_total=parseFloat($("#total_applied_agri_katha").val());
                                                    var applessa_total=parseFloat($("#total_applied_agri_lessa").val());
                                                    var appganda_total=parseFloat($("#total_applied_agri_ganda").val());
                                                    let total_app_ganda_org = parseFloat((appbigha_total * 6400) + (appkatha_total * 320) + (applessa_total * 20) + appganda_total);

                                                    var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                                    var selectedValue = $("input[name=concession<?=$dagsprem->dag_no?>]:checked").val();
                                                    var agribigha=parseFloat($("#agri_b<?=$dagsprem->dag_no?>").val());
                                                    var agrikatha=parseFloat($("#agri_k<?=$dagsprem->dag_no?>").val());
                                                    var agrilessa=parseFloat($("#agri_lc<?=$dagsprem->dag_no?>").val());
                                                    var agriganda=parseFloat($("#agri_g<?=$dagsprem->dag_no?>").val());

                                                    var appbigha=agribigha;
                                                    var appkatha=agrikatha;
                                                    var applessa=parseFloat(agrilessa);
                                                    var appganda=parseFloat(agriganda);
                                                    var total_ganda = parseFloat((appbigha * 6400) + (appkatha * 320) + (applessa * 20) + appganda);


                                                    var total_road_reserved = 0;
                                                    var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val()
                                                    if (road_reserved_yn == "YES") {
                                                        var road_bigha=parseFloat($("#reserved_bigha<?=$dagsprem->dag_no?>").val());
                                                        var road_katha=parseFloat($("#reserved_katha<?=$dagsprem->dag_no?>").val());
                                                        var road_lessa=parseFloat($("#reserved_lessa<?=$dagsprem->dag_no?>").val());
                                                        var road_ganda=parseFloat($("#reserved_ganda<?=$dagsprem->dag_no?>").val());
                                                        if(road_bigha == null || road_bigha=='' || road_bigha=='undefined'){road_bigha=0;}
                                                        if(road_katha == null || road_katha=='' || road_katha=='undefined'){road_katha=0;}
                                                        if(road_lessa == null || road_lessa=='' || road_lessa=='undefined'){road_lessa=0;}
                                                        if(road_ganda == null || road_ganda=='' || road_ganda=='undefined'){road_ganda=0;}
                                                        total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                                                    }else if(road_reserved_yn == "NO"){
                                                        total_road_reserved = 0;
                                                    }
                                                    var total_s_area = parseFloat(total_ganda - total_road_reserved);
                                                    var total_culti_area= parseFloat(total_app_ganda_org - total_road_reserved);
                                                    var rate_type = $("#amount_type<?=$dagsprem->dag_no?>").val();

                                                    if (selectedValue == "YES") {
                                                        $("#finalamount").val('');
                                                        $("#totaldue").val('');
                                                        $(".premhide").hide();
                                                        $("#finalsubmit").show();
                                                        $("#finalsave").hide();
                                                        $(".paymode").prop( "checked", false );

                                                        var cult_board = $('#cult_board').val();
                                                        if(cult_board == 'TEA') {
                                                            if(total_culti_area>192000){
                                                                var percentage =30;
                                                                var zonal_ganda = zonal / 6400;
                                                                var premium = total_s_area * zonal_ganda;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var per_ganda_rate = 1000/6400;
                                                                var final_amount = (total_s_area * per_ganda_rate);
                                                                var amount= Math.ceil(final_amount);

                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            if(total_culti_area>192000){
                                                                var percentage =100;
                                                                var zonal_ganda = zonal / 6400;
                                                                var premium = total_s_area * zonal_ganda;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var percentage =30;
                                                                var zonal_ganda = zonal / 6400;
                                                                var premium = total_s_area * zonal_ganda;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }
                                                        }

                                                        $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                                        $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                                        $('#validationcheck').val(1);

                                                        // alert(<?=$dagsprem->dag_no?>);

                                                    }


                                                });
                                                <?php else : ?>

                                                $("input[name=concession<?=$dagsprem->dag_no?>]").on("click", function () {

                                                    var appbigha_total=parseFloat($("#total_applied_agri_bigha").val());
                                                    var appkatha_total=parseFloat($("#total_applied_agri_katha").val());
                                                    var applessa_total=parseFloat($("#total_applied_agri_lessa").val());

                                                    var total_app_lessa_org = parseFloat((appbigha_total * 100) + (appkatha_total * 20) + applessa_total);

                                                    var zonal = parseFloat($("#zonal_valuation_prem<?=$dagsprem->dag_no?>").val());
                                                    var selectedValue = $("input[name=concession<?=$dagsprem->dag_no?>]:checked").val();

                                                    var agribigha=parseFloat($("#agri_b<?=$dagsprem->dag_no?>").val());
                                                    var agrikatha=parseFloat($("#agri_k<?=$dagsprem->dag_no?>").val());
                                                    var agrilessa=parseFloat($("#agri_lc<?=$dagsprem->dag_no?>").val());

                                                    var appbigha=agribigha;
                                                    var appkatha=agrikatha;
                                                    var applessa=parseFloat(agrilessa);

                                                    var total_lessa = parseFloat((appbigha * 100) + (appkatha * 20) + applessa);

                                                    var total_road_reserved = 0;
                                                    var road_reserved_yn = $("input[name=roadside_comment_check]:checked").val()
                                                    if (road_reserved_yn == "YES") {
                                                        var road_bigha=parseFloat($("#reserved_bigha<?=$dagsprem->dag_no?>").val());
                                                        var road_katha=parseFloat($("#reserved_katha<?=$dagsprem->dag_no?>").val());
                                                        var road_lessa=parseFloat($("#reserved_lessa<?=$dagsprem->dag_no?>").val());
                                                        if(road_bigha == null || road_bigha=='' || road_bigha=='undefined'){road_bigha=0;}
                                                        if(road_katha == null || road_katha=='' || road_katha=='undefined'){road_katha=0;}
                                                        if(road_lessa == null || road_lessa=='' || road_lessa=='undefined'){road_lessa=0;}
                                                        total_road_reserved = parseFloat((road_bigha * 100) + (road_katha * 20) + road_lessa);
                                                    }else if(road_reserved_yn == "NO"){
                                                        total_road_reserved = 0;
                                                    }

                                                    var total_s_area = parseFloat(total_lessa - total_road_reserved);
                                                    var total_culti_area= parseFloat(total_app_lessa_org - total_road_reserved);


                                                    if (selectedValue == "YES") {
                                                        $("#finalamount").val('');
                                                        $("#totaldue").val('');
                                                        $(".premhide").hide();
                                                        $("#finalsubmit").show();
                                                        $("#finalsave").hide();
                                                        $(".paymode").prop( "checked", false );

                                                        var cult_board = $('#cult_board').val();

                                                        if(cult_board == 'TEA'){
                                                            if(total_culti_area>3000){
                                                                var percentage =30;
                                                                var zonal_lessa = zonal / 100;
                                                                var premium = total_s_area * zonal_lessa;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var per_lessa_rate = 1000/100;
                                                                var final_amount = (total_s_area * per_lessa_rate);
                                                                var amount= Math.ceil(final_amount);

                                                            }
                                                        } 
                                                        else 
                                                        { 
                                                            if(total_culti_area>3000){
                                                                var percentage =100;
                                                                var zonal_lessa = zonal / 100;
                                                                var premium = total_s_area * zonal_lessa;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                            }else{

                                                                var percentage =30;
                                                                var zonal_lessa = zonal / 100;
                                                                var premium = total_s_area * zonal_lessa;
                                                                var amount = Math.ceil(premium * percentage / 100);

                                                                // alert(total_s_area);

                                                            }
                                                        }

                                                        $('#amount_<?=$dagsprem->dag_no?>').val(amount);
                                                        $('#total_lessa<?=$dagsprem->dag_no?>').val(total_s_area);
                                                        $('#validationcheck').val(1);

                                                        // alert(<?=$dagsprem->dag_no?>);

                                                    }

                                                });
                                                <?php endif ;?>


                                                //////// premium end
                                            </script>
                                            <?php $areacount++;
                                        } ?>

                                        <div class="row"  align="center">
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-4">
                                    <span id="finalsubmit" class="rezaButt buttPrimary" style="margin-top: 20px">
                                        <i class="fa fa-check-square-o"> </i>  Submit
                                    </span>
                                            </div>
                                            <div class="col-lg-4"></div>
                                        </div>

                                        <br>
                                        <div class="tableCard premhide" style="padding: 25px!important; display:none">
                                            <div class="row premhide" style="display:none">
                                                <div class="form-group col-md-6  text-primary">
                                                    <label for="title">Final Amount</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" name="finalamount" id="finalamount" readonly>
                                                </div>

                                            </div>

                                            <div class="row premhide" style="display:none">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Payment Mode</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="radio" id="paymode1" name="paymode" class="paymode" value="YES">
                                                    <label for="html">Full Payment</label>
                                                    <!-- <input type="radio" id="paymode2" name="paymode" class="paymode" value="NO">
                                                    <label for="css">30% Down Payment</label> -->
                                                    <br>
                                                </div>

                                            </div>

                                            <div class="row premhide" style="display:none">
                                                <div class="form-group col-md-6 text-danger">
                                                    <label for="title">Total Due</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" value="" name="totaldue" id="totaldue" class="totaldue" readonly>
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="modal-footer prembutton">
                                        <div class="form-group text-right">
                            <span id="closePremium" class="rezaButt buttDanger closePremium" style="display:none">
                                <i class="fa fa-times" aria-hidden="true"></i>  Close
                            </span>

                                            <span id="finalsave" class="rezaButt buttPrimary" style="display:none">
                                <i class="fa fa-check-square-o"> </i>  Submit
                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- premium modal end -->


                        <!-- LM template start -->

                        <?php
                        if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) {
                            if(isset($property) && !empty($property)) {
                                $resultprop = array();
                                foreach($property as $isproperty):
                                    $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে " .$isproperty->ganda. " গ";
                                endforeach;
                                $aditional_prop_temp=implode(",", $resultprop);
                                $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
                            } else {
                                $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                            }
                        } else {
                            if(isset($property) && !empty($property)) {
                                $resultprop = array();
                                foreach($property as $isproperty):
                                    $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে";
                                endforeach;
                                $aditional_prop_temp=implode(",", $resultprop);
                                $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
                            } else {
                                $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                            }
                        }
                        ?>

                        <?php
                        if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) {
                            $resultdags = array();
                        foreach($dags as $dags_lmtemplate) {
                            $resultdags[] = $dags_lmtemplate->dag_no;
                            foreach ($applicants_buyers as $settlement) {
                                if($settlement->is_applicant == 1) {
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
                                    <?php foreach($dags as $dags_lmtemplate3) { ?>

                                    var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_ganda=$("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_ganda=$("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
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
                        $all_dags=implode(",", $resultdags); ?>

                        <?php } else {
                        $resultdags = array();
                        foreach($dags as $dags_lmtemplate) {
                        $resultdags[] = $dags_lmtemplate->dag_no;
                        foreach ($applicants_buyers as $settlement) {
                            if($settlement->is_applicant == 1) {
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
                                    <?php foreach($dags as $dags_lmtemplate3) { ?>
                                    var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                                    total_lm_reserved = total_lm_reserved + total_road_reserved;

                                    var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                                    total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                                    total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                                    <?php } ?>

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
                            $all_dags=implode(",", $resultdags);
                        }
                        ?>

                        <!-- LM template end -->


                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>

<script src="<?php echo base_url();?>js/jAlert-v3.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jAlert-v3.css" />
<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
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
        $('#road_side_reservation_hide').show();
        $('.reserved_road_value').val(0);
    }

    function roadSideReservNo() {
        $('#road_side_reservation_hide').hide();
        $('.road_reserve_ifno_zero').val(0);
        $('.reserved_road_value').val(0);
        reset();
    }


    // function roadSideReservYes() {
    //     var x = document.getElementById("road_side_reservation_hide");
    //     if (x.style.display === "none") {
    //         x.style.display = "block";
    //     }
    // }
    //  else {
    //   x.style.display = "none";
    // }
    // function roadSideReservNo() {
    //     var x = document.getElementById("road_side_reservation_hide");
    //     if (x.style.display === "block") {
    //         x.style.display = "none";
    //     }
    // }

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


    function rk_already_exist() {
        var x = document.getElementById('encroacher_name')
        if (x.style.display === 'none') {
            x.style.display = 'block'
        }
    }
    function rk_to_be_added() {
        var x = document.getElementById('encroacher_name')
        if (x.style.display === 'block') {
            x.style.display = 'none'
        }
    }

</script>

<script>
    function premiumModalTea(){

        let appbigha=parseFloat($("#total_applied_agri_bigha").val());
        let appkatha=parseFloat($("#total_applied_agri_katha").val());
        let applessa=parseFloat($("#total_applied_agri_lessa").val());

        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
        let appganda=parseFloat($("#total_applied_agri_ganda").val());
        let total_app_ganda_org = parseFloat((appbigha * 6400) + (appkatha * 320) + (applessa * 20) + appganda);

        var total_road_reserved = 0;
        <?php foreach($dags as $dagsroad) { ?>

        var road_bigha=$("#reserved_bigha<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dagsroad->dag_no?>").val()) : 0;
        var road_katha=$("#reserved_katha<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dagsroad->dag_no?>").val()) : 0;
        var road_lessa=$("#reserved_lessa<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dagsroad->dag_no?>").val()) : 0;
        var road_ganda=$("#reserved_ganda<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_ganda<?=$dagsroad->dag_no?>").val()) : 0;
        total_road_reserved = total_road_reserved + parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);


        <?php } ?>
        var total_app_ganda = parseFloat(total_app_ganda_org - total_road_reserved);

        if(total_app_ganda>192000){
            alert("above 30 bigha"); return;

        }else{

            var per_ganda_rate = 1000/6400;
            var final_amount = (total_app_ganda * per_ganda_rate);
            var total_due= Math.ceil(final_amount);
        }
        $('#total_s_lessa').val(total_app_ganda);


        <?php else : ?>
        let total_app_lessa_org = parseFloat((appbigha * 100) + (appkatha * 20) + applessa);

        var total_road_reserved = 0;

        <?php foreach($dags as $dagsroad) { ?>


        var road_bigha=$("#reserved_bigha<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dagsroad->dag_no?>").val()) : 0;
        var road_katha=$("#reserved_katha<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dagsroad->dag_no?>").val()) : 0;
        var road_lessa=$("#reserved_lessa<?=$dagsroad->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dagsroad->dag_no?>").val()) : 0;

        total_road_reserved = total_road_reserved + parseFloat((road_bigha * 100) + (road_katha * 20) + road_lessa);



        <?php } ?>
        var total_app_lessa = parseFloat(total_app_lessa_org - total_road_reserved);

        if(total_app_lessa>3000){
            alert("above 30 bigha"); return;

        }else{

            var per_lessa_rate = 1000/100;
            var final_amount = (total_app_lessa * per_lessa_rate);
            var total_due= Math.ceil(final_amount);
        }
        $('#total_s_lessa').val(total_app_lessa);


        <?php endif ;?>

        $('#total_due_amount').val(total_due);
        $('#total_final_amount').val(total_due);
        $("#total_due_row").show();

    }

    //// premium code

    var premModal = document.getElementById("premiumModal");
    function premiumModal(){

        premModal.style.display = "block";

        // $("#dag_prem").html(dag_no);

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
        // premModal.style.display = "none";

        $('#total_final_amount').val(sum);
        $("#total_due_row").show();
    });

    $("#finalsave").click(function(){
        if (!$('#finalamount').val()) {
            alert("Final Amount Can't be blak !!!");
            return;
        }
        var due = $("#totaldue").val();
        $('#total_due_amount').val(due);

        premModal.style.display = "none";
    });

    function roadAreaCheck(){
        reset();
    }

    //// premium code end


    $("#lm_remark").change(function (event) {


        var selectedRemark=$(this).val();

        if(selectedRemark==1){
            $('#lm_remark_text_id').show();

            // alert("You have Selected  :: "+selectedRemark);
            totalAppliedArea();
            $('#lm_remark_text').text('');
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ/ আৰ চি চি ঘৰ ) / খেতি-বাতি  কৰি দখলকৰি থকা দেখা গল।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+<?php echo $lmnote_dag->dag_no; ?>).val()+" দক্ষিণে "+$('#landmark_south'+<?php echo $lmnote_dag->dag_no; ?>).val()+" পূবে "+$('#landmark_east'+<?php echo $lmnote_dag->dag_no; ?>).val()+" আৰু পশ্চিমে "+$('#landmark_west'+<?php echo $lmnote_dag->dag_no; ?>).val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা যায়।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ/ আৰ চি চি ঘৰ ) / খেতি-বাতি  কৰি দখলকৰি থকা দেখা গল।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+<?php echo $lmnote_dag->dag_no; ?>).val()+" দক্ষিণে "+$('#landmark_south'+<?php echo $lmnote_dag->dag_no; ?>).val()+" পূবে "+$('#landmark_east'+<?php echo $lmnote_dag->dag_no; ?>).val()+" আৰু পশ্চিমে "+$('#landmark_west'+<?php echo $lmnote_dag->dag_no; ?>).val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে পট্টন দিব পৰা যায়।");
            <?php endif ;?>
            // var lm_yes=$('#lm_template_yes').val();
            // $("textarea#lm_remark_text").val(lm_yes);


        }else if(selectedRemark==2){
            $('#lm_remark_text_id').show();

            // alert("You have Selected  :: "+selectedRemark);
            // var lm_no=$('#lm_template_no').val();
            // $("textarea#lm_remark_text").val(lm_no);
            totalAppliedArea();
            $('#lm_remark_text').text('');
            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ/ আৰ চি চি ঘৰ ) / খেতি-বাতি  কৰি দখলকৰি থকা দেখা গল।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+<?php echo $lmnote_dag->dag_no; ?>).val()+" দক্ষিণে "+$('#landmark_south'+<?php echo $lmnote_dag->dag_no; ?>).val()+" পূবে "+$('#landmark_east'+<?php echo $lmnote_dag->dag_no; ?>).val()+" আৰু পশ্চিমে "+$('#landmark_west'+<?php echo $lmnote_dag->dag_no; ?>).val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" চ "+$('#alloted_ganda').val()+" গ পট্টন দিব পৰা নাযায় ।");
            <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?> ৰাজহ গাওঁৰ চৰকাৰী দাগ নং <?php echo $all_dags?> ত "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে  ত ভূমি পট্টনৰ বাবে আবেদন কৰিছে।");
            $('#lm_remark_text').append("\n \n চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ/ আৰ চি চি ঘৰ ) / খেতি-বাতি  কৰি দখলকৰি থকা দেখা গল।");
            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন খিলঞ্জীয়া লোক।");
            <?php foreach($dags as $lmnote_dag): ?>
            $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+<?php echo $lmnote_dag->dag_no; ?>).val()+" দক্ষিণে "+$('#landmark_south'+<?php echo $lmnote_dag->dag_no; ?>).val()+" পূবে "+$('#landmark_east'+<?php echo $lmnote_dag->dag_no; ?>).val()+" আৰু পশ্চিমে "+$('#landmark_west'+<?php echo $lmnote_dag->dag_no; ?>).val()+" থকা দেখা যায়।");
            <?php endforeach; ?>
            $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি "+$('#alloted_bigha').val()+" বি "+$('#alloted_katha').val()+" ক "+$('#alloted_lessa').val()+" লে পট্টন দিব পৰা নাযায় ।");
            <?php endif ;?>
        }else{
            $('#lm_remark_text').text('');
            $('#lm_remark_text_id').hide();

        }
    });


    function openPropertyModal(){
        modal.style.display = "block";
    }
</script>


<script>

    <?php
    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) {
    ?>
    function totalAreaCal(){
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseFloat($("#mbigha"+i).val());
            var mkatha = parseFloat($("#mkatha"+i).val());
            var mlessa = parseFloat($("#mlessa"+i).val());
            var mganda = parseFloat($("#mganda"+i).val());

            var total_area = total_area + ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
        }

        var bigha_r = Math.floor(total_area / 6400);
        var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
        var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
        var ganda_r = total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);
        $("#total_applied_home_ganda").val(ganda_r);
    }

    function agriArea(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#total_due_amount').val('');
        $(".concession").prop( "checked", false );
        $('.totalamount').val('');
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
            var mkatha_agri = parseFloat($("#agri_katha"+i).val());
            var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
            var mganda_agri = parseFloat($("#agri_ganda"+i).val());

            var total_agri_area = total_agri_area + ((mbigha_agri * 6400) + (mkatha_agri * 320) + (mlessa_agri * 20) + mganda_agri);
        }

        var bigha_agri = Math.floor(total_agri_area / 6400);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 6400) / 320);
        var lessa_agri = Math.floor((total_agri_area - (bigha_agri * 6400) - (katha_agri * 320)) / 20);
        var ganda_agri = total_agri_area - bigha_agri * 6400 - katha_agri * 320 - lessa_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
        $("#total_applied_agri_ganda").val(ganda_agri);
    }

    <?php
    } else {?>
    function totalAreaCal(){
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseFloat($("#mbigha"+i).val());
            var mkatha = parseFloat($("#mkatha"+i).val());
            var mlessa = parseFloat($("#mlessa"+i).val());
            var total_area = total_area + ((mbigha * 100) + (mkatha * 20) + mlessa);
        }

        var bigha_r = Math.floor(total_area / 100);
        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);

    }

    function agriArea(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#total_due_amount').val('');
        $(".concession").prop( "checked", false );
        $('.totalamount').val('');
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
            var mkatha_agri = parseFloat($("#agri_katha"+i).val());
            var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
            var total_agri_area = total_agri_area + ((mbigha_agri * 100) + (mkatha_agri * 20) + mlessa_agri);
        }
        // alert(total_agri_area);
        var bigha_agri = Math.floor(total_agri_area / 100);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 100) / 20);
        var lessa_agri = total_agri_area - bigha_agri * 100 - katha_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
    }

    <?php }?>


    function reset(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        $("#lmfinalamount").text('');
        $("#lmdueamount").text('');
        $('#total_due_amount').val('');
    }

    function forcedUrban(val) {
        if (val == "YES") {
            $("#forcedurban").show();
        } else {
            $("#forcedurban").hide();
        }
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
            encData = "Dag No: "+<?=$encroacher_ext->dag_no?>+ " : " + $('#encroacher_exist_vlb<?=$encroacher_ext->id?> option:selected').text();
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
                'error'
            )
        }
    })
    });

</script>



<script src="<?php echo base_url();?>js/NcVillage/notify.js"></script>

<?php include(APPPATH."views/NcVillageService/Common/Includes/addEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/addEncroacher.js"></script>

<?php include(APPPATH."views/NcVillageService/Common/Includes/editEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/editEncroacher.js"></script>

<?php include(APPPATH."views/NcVillageService/Common/Includes/changeEncroacher.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/changeEncroacher.js"></script>

<?php include(APPPATH."views/NcVillageService/Common/Includes/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/editApplicantDetails.js"></script>


<?php include(APPPATH."views/NcVillageService/Common/Includes/editAreaDetails.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/editAreaDetails.js"></script>

<?php include(APPPATH."views/NcVillageService/Common/Includes/editFamilyDetails.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/editFamilyDetails.js"></script>

<?php include(APPPATH."views/NcVillageService/Common/Includes/addApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/NcVillage/addApplicantDetails.js"></script>

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
    $(document).on('change', '#cult_board', function(){
        reset();

        var board = $('#cult_board').val();
        
        if(board == 'TEA')
        {
            $('#messageDiv').html('<span><b>&nbsp; <br>(@Rs 1000/ per Bigha up to 30 bighas of land, If above 30 bighas then 30% of the Zonal valuation up till 75 bigha)</b></span>');
        }
        else
        {
            $('#messageDiv').html('<span><b>&nbsp; <br>(30% of the Zonal Valuation)</b></span>');
        }
    })

    $(document).ready( function (){
        var board = $('#cult_board').val();
        
        if(board == 'TEA')
        {
            $('#messageDiv').html('<span><b>&nbsp; <br>(@Rs 1000/ per Bigha up to 30 bighas of land, If above 30 bighas then 30% of the Zonal valuation up till 75 bigha)</b></span>');
        }
        else
        {
            $('#messageDiv').html('<span><b>&nbsp; <br>(30% of the Zonal Valuation)</b></span>');
        }
    })
</script>
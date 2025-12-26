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

<div class="col-md-12" style="color: red; font-weight: bold;">        
    <?php if(!empty($this->TeaGrantModel->getApplicantToBeSettled($case_no))) { ?>
        <br><i class="fa fa-circle"></i>&nbsp;<?=$this->TeaGrantModel->getApplicantToBeSettled($case_no)?>
    <?php } ?>
        <br><i class="fa fa-circle"></i>&nbsp;SRO Remark: <?=$this->TeaGrantModel->sroReplyRemarks($case_no)?>        
</div>

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

            <?php include(APPPATH."views/TeaGrant/common/jama_view.php"); ?>

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
                  <strong>LRA</strong>
                  </span>
                            </a>
                        </li>

                        <?php
                        if($review_flag != false){
                        
                        ?>

                        <li role="presentation">
                            <a href="<?=base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $basic['old_case_no'])?>" target="Old Application" class="text-primary">
                                <span class="round-tab">
                                <strong>View Old Application</strong>
                                </span>
                            </a>
                        </li>

                        <?php }?>                        

                    </ul>
                </div>



                <form role="form" class="lmForm" method="post" action="<?php echo base_url() ?>index.php/TeaGrantControllerLm/applicationTeaGrantRegistration/<?=$review_flag?>?app=<?=$_GET['app']?>" enctype="multipart/form-data">
   

                    <?php 
                        $application_no = $this->utilityclass->decryptJwtCase($_GET['app']);
                    ?>

                    <input type="hidden" id="service_code_lm" name="service_code" value="<?=$basic["service_code"]?>">
                    <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
                    <input type="hidden" id ='case_no' name="case_no" value="<?=$case_no?>">
                    <input type="hidden" id ='application_no' name="applid" value="<?=$application_no?>">
                    <input type="hidden" name="uuid" id="uuid" value="<?=$basic['uuid']?>">
                    <input type="hidden" name="lm_verification_date" id="lm_verification_date" 
                        value="<?=date('d/m/Y', strtotime($geo_date))?>">
                    
                    <?php $sl_count = 1; ?>
                

                    <div class="tab-content">


                        <div class="tab-pane active" role="tabpanel" id="step1">
                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                Limited Conversion of Tea Grant Land to Periodic Patta (
                                <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$case_no?></span> )
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

                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-file-text"></i>  Application Details
                                    </h5>
                                    <div class="tableCard">
                                        <div class="row justify-content-center">
                                            <?php
                                            if(isset($base64_decoded_adhar_file)){
                                                ?>
                                                <?php if($identity->identity_type == 'AADHAAR') { ?>
                                                    <div class="col-md-2">
                                                        <?=$base64_decoded_adhar_file;?>
                                                    </div>
                                                <?php } ?>
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
                                                            <th>Occupation or Profession of the applicant</th>
                                                            <td>
                                                                <input readonly type="text" name="occupation_applicant" id="occupation_applicant" value="<?=$basic['occupation_applicant']?>" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        ?>
                                                        <tr>
                                                            <th>Caste</th>
                                                            <td>
                                                                <input type="hidden" name="caste" value="<?=$basic['caste']?>" class="form-control">
                                                                <input readonly type="text" name="" id="caste_name" value="<?php
                                                                foreach (json_decode(CASTE) as $caste) {
                                                                    if ($caste->CODE == $basic['caste']) {
                                                                        echo $caste->NAME;
                                                                    }
                                                                }
                                                                ?>" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        if(isset($backup_tribe_category)):
                                                            ?>
                                                            <tr>
                                                                <th>Select if you fall under protected category?</th>
                                                                <td>
                                                                    <input type="hidden" name="protected_class" value="<?=$basic['protected_class']?>" class="form-control">
                                                                    <strong class="alert-warning">
                                                                        <?php
                                                                        foreach(json_decode(PROTECTED_CLASS) as $class12){


                                                                            if($class12->CODE == $backup_tribe_category){
                                                                                echo $class12->NAME;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                        <?php endif;?>
                                                        <input type="hidden" name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" class="form-control">
                                                        <?php if (isset($backup_under_tribe_belts)) { ?>
                                                            <tr>
                                                                <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                                                                <td>
                                                                    <strong class="alert-warning"><?php
                                                                        if($backup_under_tribe_belts == '1'){
                                                                            ?>
                                                                            <input type="text" readonly value="Yes" class="form-control">
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <input type="text" readonly value="No" class="form-control">
                                                                            <?php
                                                                        }
                                                                        ?></strong>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        
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


                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user"></i>  Applicant details
                                    </h5>

                                    <button type="button" onclick="openTeaApplicant();" class="btn btn-sm btn-primary"><strong>Add Data</strong></button><br><br>
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
                                                    <th>Guardian Name (Assamese)</th>
                                                    <td>
                                                        <input type="text" name="pdar_guardian<?=$settlement->id?>" id="pdar_guardian<?=$settlement->id?>" readonly value="<?=$settlement->pdar_guardian;?>" class="form-control input-sm">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Applicant Name (English)</th>
                                                    <td>
                                                        <input type="text" name="eng_pdar_name<?=$settlement->id?>" id="eng_pdar_name<?=$settlement->id?>" readonly class="form-control" value="<?=$settlement->eng_pdar_name;?>" readonly>
                                                    </td>
                                                    <th>Guardian Name (English)</th>
                                                    <td>
                                                        <input type="text" readonly name="eng_pdar_guardian<?=$settlement->id?>" id="eng_pdar_guardian<?=$settlement->id?>" class="form-control" value="<?=$settlement->eng_pdar_guardian;?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Relation</th>
                                                    <td>
                                                        <select disabled name="pdar_rel_guar<?=$settlement->id?>" id="pdar_rel_guar<?=$settlement->id?>" class="form-control">
                                                            <option value="">Select...</option>
                                                            <?php foreach ($guar_rel as $guar_rel_list) {
                                                                ?>
                                                                <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $settlement->pdar_rel_guar) { echo "selected";}?>>
                                                                    <?=$guar_rel_list->guard_rel_desc_as?>
                                                                </option>
                                                            <?php }?>
                                                        </select>
                                                    </td>
                                                    <th>Gender</th>
                                                    <td>
                                                        <select disabled name="pdar_gender<?=$settlement->id?>" id="pdar_gender<?=$settlement->id?>" class="form-control input_editable_background">
                                                            <option value="">Select gender...</option>
                                                            <option value="1" <?php if ($settlement->pdar_gender == "1") {echo "selected";}?>>Male</option>
                                                            <option value="2" <?php if ($settlement->pdar_gender == "2") {echo "selected";}?>>Female</option>
                                                            <option value="3" <?php if ($settlement->pdar_gender == "3") {echo "selected";}?>>Others</option>
                                                        </select>
                                                    </td>
                                                <tr>
                                                    <th>DOB</th>
                                                    <td>
                                                        <input type="text" readonly id="dob<?=$settlement->id?>" name="dob<?=$settlement->id?>" value="<?=$settlement->dob;?>" class="form-control input-sm" >
                                                    </td>
                                                    <?php if($settlement->is_applicant == 1): ?>
                                                        <th>Marital Status</th>
                                                        <td>
                                                            <strong class="alert-warning">
                                                                <select class="form-control" disabled id="marital_status<?=$settlement->id?>">
                                                                    <option value="">Select...</option>
                                                                    <?php
                                                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                                                        ?>
                                                                        <option value="<?=$marital_stat->CODE?>" <?php if($marital_stat->CODE == $settlement->marital_status){ echo "selected";}?>>
                                                                            <?=$marital_stat->NAME?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </strong>
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                                <tr>
                                                    <th>Mobile</th>
                                                    <td>
                                                        <input type="text" readonly name="pdar_mobile<?=$settlement->id?>" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile;?>" class="form-control input-sm" >
                                                    </td>
                                                    <th>
                                                        Permanent address
                                                    </th>
                                                    <td>

                                                        <?php

                                                        // echo "<pre>"; var_dump($settlement); die;                                          
                                                            $pre_addr = json_decode($settlement->pdar_add1);
                                                            $per_addr = json_decode($settlement->pdar_add2);
                                                        ?>

                                                        <input type="text" readonly name="pdar_add1<?=$settlement->id?>" id="pdar_add1<?=$settlement->id?>" value="<?=isset($pre_addr->address)?$pre_addr->address:''?>" class="form-control input-sm">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Present address</th>
                                                    <td>
                                                        <input type="text" readonly name="pdar_add2<?=$settlement->id?>" id="pdar_add2<?=$settlement->id?>" value="<?=isset($per_addr->address)?$per_addr->address:''?>" class="form-control input-sm" >
                                                    </td>

                                                    <?php if($settlement->is_applicant == 1) { ?>



                                                    <th>Possession From</th>
                                                    <td>
                                                        <input type="text" readonly 
                                                        name="period_possession" 
                                                        id="period_possession" 
                                                        value="<?=date('d/m/Y', strtotime($settlement->period_possession))?>" 
                                                        class="form-control input-sm" >
                                                    </td>

                                                    <?php } ?>
                                                    
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="vertical-align : middle;text-align:center;">
                                                        <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>
                                                        

                                                        <?php if($settlement->is_applicant != 1){ ?>
                                                            <button type="button" onclick="confirmDeleteApplicant(<?=$settlement->id?>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                                <strong>Delete</strong></button>

                                                        <?php }?>
                                                    </td>
                                                </tr>



                                            </table>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach; ?>

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-map"></i> Area Details
                                    </h5>
                                   
                                    
                                    <div class="tableCard">

                                        <?php if(TEA_ADD_NEW_DAG_BUTTON_ENABLE == 1) { ?>
                                            <button type="button" class="btn btn-sm btn-danger pull-right" onclick="addTeaGrantPattaDetail('F')">Add New Dag Detail with Patta Change</button><br><br>
                                            <?php include(APPPATH."views/TeaGrant/common/add_new_dag.php"); ?>
                                        <?php } ?>

                                        <table class="table mb-0">
                                            <thead class="thead-warning">


                                                <tr>
                                                    <th>#</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Bigha</th>
                                                    <th class="text-center">Katha</th>
                                                    <th class="text-center"><?=$lessa_chatak?></th>
                                                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                    <th class="text-center">Ganda</th>
                                                    <th class="text-center">Kranti</th>
                                                    <?php endif; ?>
                                                </tr>
                                                <?php 

                                                    $total_area_bigha = 1;
                                                    foreach ($dags as $all_dags) {
                                                ?>

                                                <tr class="bg-white">
                                                    <th rowspan="2" style="vertical-align : middle;">
                                                        <div class="vertical">
                                                            DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> <br> 
                                                            PATTA : <span class="text-danger"><?=$all_dags->patta_no?> <br> <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?></span>

                                                            <input type="hidden" id="dag_no<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_no?>">

                                                            <input type="hidden" id="patta_no<?=$all_dags->dag_no?>" value="<?=$all_dags->patta_no?>">

                                                            <input type="hidden" name="is_urban" id="urbanCheck<?=$all_dags->dag_no?>" value="<?=$all_dags->is_urban?>">

                                                        </div>

                                                        <br>


                                                        <?php if(TEAGRANT_ENABLE_DAG_ELIGIBLE_BUTTON == 1){

                                                            if($dag_count > 1){?>
                                                                <button type="button" id="deldag<?=$all_dags->id?>" onclick="deleteDagTea(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-danger"><i class="fa fa-remove" style="color:white"></i> Dag Not Eligible</button>

                                                                <button type="button" id="insdag<?=$all_dags->id?>" onclick="insertDagTea(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-success" style="display:none">Eligible</button>

                                                        <?php } }?>

                                                    <div id="dageligiblemsg<?=$all_dags->id?>" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; display:none">
                                                    </div>


                                                    </th>
                                                    <td><strong>Total Land Area in Selected Dag</strong></td>
                                                    <td style="text-align: center;">
                                                        <strong><?=$all_dags->dag_area_b?></strong>
                                                        <input type="hidden" readonly style="text-align: center;" name="dag_area_b<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" id="dag_area_b<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <strong><?=$all_dags->dag_area_k?></strong>
                                                        <input type="hidden" readonly style="text-align: center;" name="dag_area_k<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" id="dag_area_k<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <strong><?=$all_dags->dag_area_lc?></strong>
                                                        <input type="hidden" readonly style="text-align: center;" name="dag_area_lc<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" id="dag_area_lc<?=$all_dags->dag_no?>">
                                                    </td>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <td style="text-align: center;">
                                                            <strong><?=$all_dags->dag_area_g?></strong>
                                                            <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$all_dags->dag_no?>" id="dag_area_g<?=$all_dags->dag_no?>">
                                                        </td>
                                                        <td class="hide" style="text-align: center;">
                                                            <strong><?=$all_dags->dag_area_kr?></strong>
                                                            <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr<?=$all_dags->dag_no?>" id="dag_area_kr<?=$all_dags->dag_no?>">
                                                        </td>
                                                    <?php endif ; ?>


                                                </tr>                                                

                                                <!-- area settlement homestead -->
                                                <?php $hide = 'area_show';
                                                    if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                                                        $hide = 'area_show';
                                                    } else {
                                                        $hide = 'area_hide';
                                                    }
                                                ?>
                                                <tr class='<?=$hide?>' class="bg-white">
                                                    <td class="settlement-area-color"><strong>Applied Area</strong></td>
                                                    <td class="settlement-area-color" style="text-align:center">
                                                        <strong><?=$all_dags->s_dag_area_b?></strong>
                                                        <input type="hidden" style="text-align: center;" name="enc_home_b<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$all_dags->s_dag_area_b?>" id="enc_home_b<?=$all_dags->dag_no?>" readonly>
                                                    </td>
                                                    <td class="settlement-area-color" style="text-align:center">
                                                        <strong><?=$all_dags->s_dag_area_k?></strong>
                                                        <input type="hidden" style="text-align: center;" name="enc_home_k<?=$all_dags->dag_no?>" value="<?=$all_dags->s_dag_area_k?>" class="form-control input-sm enc_home_k" id="enc_home_k<?=$all_dags->dag_no?>" readonly>
                                                    </td>
                                                    <td class="settlement-area-color" style="text-align:center">
                                                        <strong><?=$all_dags->s_dag_area_lc?></strong>
                                                        <input type="hidden" style="text-align: center;" name="enc_home_lc<?=$all_dags->dag_no?>" value="<?=$all_dags->s_dag_area_lc?>" class="form-control input-sm enc_home_lc" id="enc_home_lc<?=$all_dags->dag_no?>" readonly>
                                                    </td>
                                                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color" style="text-align:center">
                                                            <strong><?=$all_dags->s_dag_area_g?></strong>
                                                            <input type="hidden" style="text-align: center;" value="<?=$all_dags->s_dag_area_g?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_dags->dag_no?>" 
                                                            id="enc_home_g<?=$all_dags->dag_no?>"
                                                            readonly>
                                                        </td>
                                                        <td class="settlement-area-color" style="text-align:center">
                                                            <strong><?=$all_dags->s_dag_area_kr?></strong>
                                                            <input type="hidden" style="text-align: center;" value="<?=$all_dags->s_dag_area_kr?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_dags->dag_no?>" 
                                                            id="enc_home_kr<?=$all_dags->dag_no?>"
                                                            readonly>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>

                                                <?php } ?>

                                                <th rowspan="2"></th>

                                                <?php

                                                    $total_applied_bigha  = 0;
                                                    $total_applied_katha  = 0;
                                                    $total_applied_lessa  = 0;
                                                    $total_applied_ganda  = 0;
                                                    $total_applied_kranti = 0;

                                                    foreach ($dags as $all_dags) 
                                                    {
                                                        $total_applied_bigha = $total_applied_bigha + $all_dags->s_dag_area_b;
                                                        $total_applied_katha = $total_applied_katha + $all_dags->s_dag_area_k;
                                                        $total_applied_lessa = $total_applied_lessa + $all_dags->s_dag_area_lc;
                                                        $total_applied_ganda = $total_applied_ganda + $all_dags->s_dag_area_g;
                                                        $total_applied_kranti = $total_applied_kranti + $all_dags->s_dag_area_kr;
                                                    }

                                                    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) 
                                                    {
                                                        $convert_area = floor(($total_applied_bigha * 6400) + ($total_applied_katha * 320) + 
                                                            ($total_applied_lessa * 20) + 
                                                            $total_applied_ganda);

                                                        $total_applied_bigha = floor($convert_area / 6400);

                                                        $total_applied_katha = floor(($convert_area - ($total_applied_bigha * 6400))/320);

                                                        $total_applied_lessa = floor(($convert_area - ($total_applied_bigha * 6400 + $total_applied_katha * 320))/20);

                                                        $total_applied_ganda = number_format($convert_area - ($total_applied_bigha * 6400 + $total_applied_katha * 320 + $total_applied_lessa * 20), 2);

                                                        $total_applied_kranti = 0;
                                                    }
                                                    else
                                                    {
                                                        $convert_area = ($total_applied_bigha * 100) + 
                                                                       ($total_applied_katha * 20) + 
                                                                       $total_applied_lessa;

                                                        $total_applied_bigha = floor($convert_area / 100);

                                                        $total_applied_katha = floor(($convert_area - ($total_applied_bigha * 100))/20);

                                                        $total_applied_lessa = number_format($convert_area - ($total_applied_bigha * 100 + $total_applied_katha * 20), 2);

                                                        $total_applied_ganda  = 0;

                                                        $total_applied_kranti = 0;
                                                    }

                                                ?>  

                                                <tr class='<?=$hide?>' class="bg-white">

                                                    <td class="settlement-area-color text-danger"><strong>Total Applied Area</strong></td>
                                                    <td class="settlement-area-color text-danger" style="text-align:center">
                                                        <strong><?=$total_applied_bigha?></strong>
                                                        <input type="hidden" style="text-align: center;" name="tot_applied_b" class="form-control input-sm tot_applied_b" 
                                                        value="<?=$total_applied_bigha?>" id="tot_applied_b" readonly>
                                                    </td>
                                                    <td class="settlement-area-color text-danger" style="text-align:center">
                                                        <strong><?=$total_applied_katha?></strong>
                                                        <input type="hidden" style="text-align: center;" name="tot_applied_k" value="<?=$total_applied_katha?>" class="form-control input-sm tot_applied_k" id="tot_applied_k" readonly>
                                                    </td>
                                                    <td class="settlement-area-color text-danger" style="text-align:center">
                                                        <strong><?=$total_applied_lessa?></strong>
                                                        <input type="hidden" style="text-align: center;" name="tot_applied_lc" value="<?=$total_applied_lessa?>" class="form-control input-sm tot_applied_lc" id="tot_applied_lc" readonly>
                                                    </td>
                                                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="settlement-area-color text-danger" style="text-align:center">
                                                            <strong><?=$total_applied_ganda?></strong>
                                                            <input type="hidden" style="text-align: center;" value="<?=$total_applied_ganda?>" class="form-control input-sm tot_applied_g" name="tot_applied_g"
                                                            id="tot_applied_g" readonly>
                                                        </td>
                                                        <td class="settlement-area-color text-danger" style="text-align:center">
                                                            <strong><?=$total_applied_kranti?></strong>
                                                            <input type="hidden" style="text-align: center;" value="<?=$total_applied_kranti?>" class="form-control input-sm tot_applied_kr" name="tot_applied_kr" id="tot_applied_kr"
                                                            readonly>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>

                                                

                                            </thead>
                                        </table>
                                    </div>

                                    <!-- additional property -->
                                    <?php if(isset($property) && !empty($property)) { ?>
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
                                    <?php } ?>
                                    <!-- additional property end -->

                                    <!-- existing pattadar starts here -->
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Existing Pattadar
                                    </h5>
                                    <?php if(!empty($existing_pattadar)) { ?>
                                        <div class="tableCard">
                                            <table class="table table-bordered" id="existingPattadar">
                                                <tr>
                                                    <th>Dag No / Patta No</th>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Contact No</th>
                                                </tr>
                                                <?php $i = 1;foreach ($existing_pattadar as $ep): ?>
                                                    <tr id="sp<?=$ep->id?>">
                                                        <td>
                                                            <span><?=$ep->dag_no.' | '.$ep->patta_no?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$ep->pdar_name?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$ep->pdar_guardian?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$ep->pdar_mobile?></span>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;?>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="tableCard familyVisibleHide">
                                            <table class="table table-bordered" id="existingPattadar">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Contact No</th>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php } ?>
                                    <!-- existing pattadar ends here -->

                                    <!-- deed applicant starts here -->
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Deed Applicant
                                    </h5>
                                    <?php if(!empty($deed_applicant)) { ?>
                                        <div class="tableCard">
                                            <table class="table table-bordered" id="deedApplicant">
                                                <tr>
                                                    <th>Dag No/ Patta No</th>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Gender</th>
                                                    <th>Contact No</th>
                                                    <th>DOB</th>
                                                </tr>
                                                <?php 

                                                    $i = 1;foreach ($deed_applicant as $da): 
                                                    if($da->pdar_gender == 1)
                                                    {
                                                        $gender = "Male";
                                                    }
                                                    else if($da->pdar_gender == 2)
                                                    {
                                                        $gender = "Female";
                                                    }
                                                    else
                                                    {
                                                        $gender = "Others";
                                                    }

                                                ?>
                                                    <tr id="sp<?=$da->id?>">
                                                        <td>
                                                            <span><?=$da->dag_no.' | '.$da->patta_no?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$da->eng_pdar_name.'/'.$da->pdar_name?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$da->eng_pdar_guardian.'/'.$da->pdar_guardian?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$gender?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$da->pdar_mobile?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$da->dob?></span>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;?>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="tableCard familyVisibleHide">
                                            <table class="table table-bordered" id="deedApplicant">
                                                <tr>
                                                    <th>Dag No/ Patta No</th>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Gender</th>
                                                    <th>Contact No</th>
                                                    <th>DOB</th>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php } ?>
                                    <!-- deed applicant ends here -->


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

                                                            <?php //echo "<pre>"; var_dump($owners); ?>


                                                            <select name="owners_in_place<?=$owners->id?>" id="" class="form-control" required>
                                                                <option value="">Select...</option>
                                                                <option value="i" <?php if ($owners->inplace_alongwith == 'i') {echo "selected";}?> >In Place</option>
                                                                <option value="a" <?php if ($owners->inplace_alongwith == 'a') {echo "selected";}?>>Along with</option>
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

                                    ?>


                                    <!-- family tree starts here -->
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Family Tree
                                    </h5>
                                    <?php if(!empty($family_tree)) { ?>
                                        <div class="tableCard">
                                            <table class="table table-bordered" id="familyTree">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                    <th>Relation</th>
                                                </tr>
                                                <?php 

                                                    $i = 1;foreach ($family_tree as $ft): 

                                                    if($ft->pdar_type=='P')
                                                    {
                                                        $relation = 'Parent';
                                                    }
                                                    if($ft->pdar_type=='GP')
                                                    {
                                                        $relation = 'Grand Parent';
                                                    }
                                                    if($ft->pdar_type=='GPP')
                                                    {
                                                        $relation = 'Great Grand Parent';
                                                    }

                                                ?>
                                                    <tr id="sp<?=$ft->id?>">
                                                        <td>
                                                            <span><?=$ft->eng_pdar_name.'/'.$ft->pdar_name?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$ft->eng_pdar_guardian.'/'.$ft->pdar_guardian?></span>
                                                        </td>
                                                        <td>
                                                            <span><?=$relation?></span>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;?>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="tableCard familyVisibleHide">
                                            <table class="table table-bordered" id="familyTree">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Guardian Name</th>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php } ?>
                                    <!-- family tree ends here -->





                                    <!--- Nominee details starts here --mdz- --->
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-users"></i>  Family Details
                                        <span class="pull-right"><button type="button" onclick="addFamilyTeaGrant();" class="btn btn-sm btn-warning" style="margin-top:-5px !important">Add Family</button></span>
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
                                                                <button type="button" onclick="confirmDeleteFamilyTeaGrant(<?=$kin->id?>);" class="btn btn-sm btn-danger">Delete</button>
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
                                    <?php } ?>

                                    <!--- Nominee details ends here --mdz- --->

                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-file-pdf-o"></i> Supporting Documents
                                    </h5>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php foreach ($document as $d): ?>
                                                <tr>
                                                    <th>
                                                        <a target='download' href="<?php echo base_url(); ?>index.php/basundhara3/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
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
                                Limited Conversion of Tea Grant Land to Periodic Patta (
                                <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$case_no?></span> )
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
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Chitha verified and found the applicant / applicants predecessor as a pattadar ?</span>
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
                                                foreach ($dags as $ddg) {
                                                    $patta_code = $this->utilityclass->getPattaTypeNo($ddg->dist_code,$ddg->subdiv_code,$ddg->cir_code,$ddg->mouza_pargona_code,$ddg->lot_no,$ddg->vill_townprt_code, $ddg->dag_no);
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
                                                <span><strong><?=$sl_count++?>.</strong> Whether applicant / applicant`s predecessor is a bonafide transferee ?</span>
                                                <?=form_error('bonafide_transferee')?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('bonafide_transferee')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="bonafide_transferee"
                                                            id="bonafide_transferee1"
                                                            value="YES"
                                                        <?php if(set_value('bonafide_transferee') == 'YES'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('bonafide_transferee')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="bonafide_transferee"
                                                            id="bonafide_transferee2"
                                                            value="NO"
                                                        <?php if(set_value('bonafide_transferee') == 'NO'){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 div_dalil_upload">
                                              <b>Upload Dalil</b>
                                              <input
                                                class="form-control <?php if(form_error('dalil_upload')){echo 'lm_invalid';}?>"
                                                type="file"
                                                name="dalil_upload"
                                                id="dalil_upload"
                                                accept=".png, .jpg, .jpeg, .pdf"
                                              />                                               
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Caste Verified: whether applicant belongs to the caste as mentioned in application as per the verification of the caste certificate uploaded?</span>
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

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under Tribal Belt/ Block ?</span>
                                                <?=form_error('is_tribal_belt')?>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">

                                                    <input
                                                      class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                                                      type="radio"
                                                      name="is_tribal_belt"
                                                      id="whether_tribal1"
                                                      value="YES"
                                                      onclick="handleTribalClick(this)"
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
                                                      onclick="handleTribalClick(this)"
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
                                            <div class="col-md-4" id="tribal_belt_input_id" style="display: none;">
                                              <input type="text" class="form-control <?php if(form_error('tribal_belt_name')){echo 'lm_invalid';}?>" name="tribal_belt_name" placeholder="Enter name of the Tribal belt block" value="<?=set_value('tribal_belt_name')?>">
                                            </div>
                                        </div>

                                        <div class="row p-2" id="protected_class_id" style="display: none;">
                                          <div class="col-md-6 text-justify">
                                            <span><strong>-></strong>
                                            Does the applicant falls under protected category as mentioned in that particular tribal belt/block and eligible under section 163(2)(a), 163(2)(b)?</span>
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
                                        
                                        <div class="row p-2" id="contravention" style="display: none;">
                                          <div class="col-md-6">
                                            <span><strong>-></strong>
                                            Whether the occupancy tenant right has been conferred in contravention of provisions of chapter 10?</span>
                                            <?=form_error('contravention')?>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                                     type="radio"
                                                     name="contravention"
                                                     id="landed_property1"
                                                     value="YES"
                                                  <?php if(set_value('contravention') == 'YES'){ echo "checked";} ?>
                                              />
                                              <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                              <input
                                                      class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                                      type="radio"
                                                      name="contravention"
                                                      id="landed_property2"
                                                      value="NO"
                                                  <?php if(set_value('contravention') == 'NO'){ echo "checked";} ?>
                                              />
                                              <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                          </div>
                                        </div>

                                        <!-- <div class="row p-2">
                                            <div class="col-md-6 text-justify">
                                            <span><strong><?=$sl_count++?>.</strong>
                                                Does the applicant falls under protected category as mentioned in that particular tribal belt/block and eligible under section 163(2)(a), 163(2)(b) ?</span>
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
 -->
                                        <div class="row p-2">
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Schedule of the land and area under possession have been verified and found correct ?
                                            </span>
                                                <?=form_error('possession_verification')?>
                                            </div>
                                            <div class="col-md-2">
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

                                            <div class="col-md-4">
                                              <?=form_error('lra_possession_remark')?>

                                              <textarea placeholder="Remarks(if any)" rows="3" class="form-control <?php if(form_error('lra_possession_remark')){echo 'lm_invalid';}?>" name="lra_possession_remark" id="lra_possession_remark"><?php if(isset($err_return)){ echo set_value('lra_possession_remark');}?></textarea>

                                            </div>

                                        </div>

                                        <?php foreach($dags as $nature_dag): ?>
                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                                <span><strong><?=$sl_count++?>.</strong> Nature of possession in the dag: <?=$nature_dag->dag_no?></span>
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

                                                    <option value="Institution" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Institution') { echo "selected"; }}?>>Institution</option>

                                                    <option value="Industrial" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Industrial') { echo "selected"; }}?>>Industrial</option>

                                                    <option value="Others" <?php if(isset($err_return)){ if (set_value('nature_possession'.$nature_dag->dag_no) == 'Others') { echo "selected"; }}?>>Others</option>


                                                </select>
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                          <div class="col-md-6">
                                          <span>
                                            <strong><?=$sl_count++?>.</strong> Previous land use class  ?
                                          </span>
                                          </div>
                                          <div class="form-group col-md-6">

                                            <input type="text" readonly class="form-control" name="prev_land_class_name<?=$nature_dag->dag_no?>" id="prev_land_class_name<?=$nature_dag->dag_no?>"
                                            value="<?=$this->TeaGrantModel->getLandClassDetail($nature_dag->dist_code, $nature_dag->subdiv_code, $nature_dag->cir_code, $nature_dag->mouza_pargona_code, $nature_dag->lot_no, $nature_dag->vill_townprt_code, $nature_dag->patta_no, $nature_dag->patta_type_code, $nature_dag->dag_no)->land_type?>">

                                            <input type="hidden" name="prev_land_class_code<?=$nature_dag->dag_no?>" id="prev_land_class_code<?=$nature_dag->dag_no?>" 
                                            value="<?=$this->TeaGrantModel->getLandClassDetail($nature_dag->dist_code, $nature_dag->subdiv_code, $nature_dag->cir_code, $nature_dag->mouza_pargona_code, $nature_dag->lot_no, $nature_dag->vill_townprt_code, $nature_dag->patta_no, $nature_dag->patta_type_code, $nature_dag->dag_no)->land_class_code?>">

                                          </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Present Land use class ?
                                            </span>
                                                <?=form_error('land_class')?>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <select name="land_class<?=$nature_dag->dag_no?>" id="land_class<?=$nature_dag->dag_no?>" class="form-control
                                                <?php if(form_error('land_class')){echo 'lm_invalid';}?>" required>
                                                    <option value="">-- Select Present Land Class --</option>
                                                    <?php foreach($land_class as $land): ?>
                                                        <option value="<?=$land->land_class_code?>"
                                                            <?php if(set_value('land_class') == $land->land_class_code){ echo "selected";} ?>>
                                                            <?=$land->land_type?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <?php endforeach; ?>

                                        <?php include(APPPATH."views/TeaGrant/common/propertyModal.php"); ?>

                                        

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Whether the proposed land falls within gmc/municipal town/revenue town?
                                            </span>
                                                <?=form_error('landslide')?>
                                            </div>
                                            <div class="col-md-2">
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

                                            <div class="col-md-4">
                                                <a target='_notification' href="<?=base_url().'application/views/TeaGrant/common/Revenue_DM_Settlement_Department.pdf'?>">Notification - Revenue & DM (Settlement) Department
                                                </a>
                                            </div>

                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span>
                                                <strong><?=$sl_count++?>.</strong> Whether proposed land falls within notified gmda/notified master plan area/ within 5 km periphery (wherever applicable) ?
                                            </span>
                                                <?=form_error('land_falls_periphery')?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('land_falls_periphery')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="land_falls_periphery"
                                                            id="land_falls_periphery"
                                                            value=<?=YES ?>
                                                            <?php if(set_value('land_falls_periphery') == YES){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                            class="form-check-input <?php if(form_error('land_falls_periphery')){echo 'lm_invalid';}?>"
                                                            type="radio"
                                                            name="land_falls_periphery"
                                                            id="land_falls_periphery2"
                                                            value=<?=NO ?>
                                                            <?php if(set_value('land_falls_periphery') == NO){ echo "checked";} ?>
                                                    />
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside /riverside reservation (if any, along with provision kept for road/drain wherever necessary by relinquishing (istafa) </span>
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
                                                    <input type="radio" onclick="roadSideReservYes();" class="form-check-input roadside_comment_check1 <?php if(form_error('roadside_comment_check')){echo 'lm_invalid';}?>" name="roadside_comment_check" id="roadside_comment_check1" value="YES" <?php if(set_value('roadside_comment_check') == 'YES'){ echo "checked";} ?>>Yes
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio"  onclick="roadSideReservNo();" class="form-check-input roadside_comment_check2 <?php if(form_error('roadside_comment_check')){echo 'lm_invalid';}?>" name="roadside_comment_check" id="roadside_comment_check2" value="NO" <?php if(set_value('roadside_comment_check') == 'NO'){ echo "checked";} ?>>No
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

                                        <div class="row p-2" style="display: none" >
                                            <div class="col-md-6" >
                                            <span>
                                                <strong></strong>
                                                Whether applicant family has occupied any land in the lot?</span>
                                                <?=form_error('family_comment_check')?>
                                                <!-- this only to display the error message in area validation -->
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
                                        </div>

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Copy of map of the proposed land clearly highlighting the propose land road/riverside reservation etc(if any)</span>
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
                                            <span><strong><?=$sl_count++?>.</strong> Geo tagged
                                                photograph of the land</span>
                                            <span class="<?php if(form_error('geo_tag_photo')){echo 'lm_invalid';}?>"></span>
                                            <?php
                                              if(isset($geo_tag_doc)){
                                                echo form_error('geo_tag_photo');
                                              }else{
                                                echo form_error('geo_tag_photo');
                                              }
                                            ?>
                                          </div>
                                          <div class="col-md-6">
                                              
                                              <?php
                                                if(isset($geo_tag_doc_empty))
                                                {
                                                  echo $geo_tag_doc_empty;
                                                }
                                                if(isset($geo_tag_doc)){
                                                  foreach($geo_tag_doc as $d):
                                              ?>
                                                <span class="alert-warning">For Dag no : <strong><?=$d->dag_no?></strong></span><br>
                                                <a target='download' href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$d->id?>"><i class="fa fa-paperclip mb-2"></i> <?=$d->file_name;?></a><br>

                                              <?php endforeach; } ?>
                                          </div>
                                        </div>



                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Dispute regarding possession, if any, in Courts or if the land parcel under question is under sub judice</span>
                                              <?=form_error('dispute_possession')?>
                                            </div>

                                            <div class="col-md-2">
                                              <div class="form-check form-check-inline">
                                                  <input
                                                          class="form-check-input <?php if(form_error('dispute_possession')){echo 'lm_invalid';}?>"
                                                          type="radio"
                                                          name="dispute_possession"
                                                          id="dispute_possession"
                                                          value=<?=YES ?>
                                                          <?php if(set_value('dispute_possession') == YES){ echo "checked";} ?>
                                                  />
                                                  <label class="form-check-label" for="inlineRadio1">Yes</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                  <input
                                                          class="form-check-input <?php if(form_error('dispute_possession')){echo 'lm_invalid';}?>"
                                                          type="radio"
                                                          name="dispute_possession"
                                                          id="dispute_possession2"
                                                          value=<?=NO ?>
                                                          <?php if(set_value('dispute_possession') == NO){ echo "checked";} ?>
                                                  />
                                                  <label class="form-check-label" for="inlineRadio2">No</label>
                                              </div>
                                            </div>

                                            <div class="col-md-4 div_category_type">
                                              Category Type
                                              <?=form_error('dis_cat_type')?>
                                              <input class="form-control <?php if(form_error('dis_cat_type')){echo 'lm_invalid';}?>"
                                                type="text" name="dis_cat_type" id="dis_cat_type"
                                                placeholder="Enter Category Type" 
                                                value="<?php echo set_value('dis_cat_type');?>"
                                                />                            
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

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Possession Since (dd-mm-yyyy)</label>
                                                <?=form_error('lm_possession_entry')?>
                                            </div>
                                            <div class="col-md-6">
                                                <input
                                                class="form-control <?php if(form_error('lm_possession_entry')){echo 'lm_invalid';}?>"
                                                type="text"
                                                name="lm_possession_entry"
                                                id="lm_possession_entry" 
                                                value="<?php if(isset($err_return)){ echo set_value('lm_possession_entry');}else{echo $settlement->period_possession;}?>" />

                                            </div>
                                        </div>

                                        <div class="row p-2 <?php if(form_error('land_exceed')){echo 'lm_invalid';}?>">
                                            <div class="col-md-6">
                                                <?=form_error('land_exceed');?>
                                                <strong><?=$sl_count++?>.</strong> LRA Remarks</label>
                                                <?=form_error('lm_note')?>
                                                <?=form_error('lm_remark_text')?>

                                            </div>
                                            <div class="col-md-6">
                                                <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>">
                                                    <option value="-1">Please select remark category</option>
                                                    <option value="1" class="canRecommend">Can be Recommended</option>
                                                    <option value="2">Can not be Recommended</option>
                                                </select>
                                            </div>
                                        </div>

                                        

                                        <?php
                                        include(APPPATH."views/SettlementView/include/rejectedReasons.php");
                                        ?>

                                        <div id="lm_remark_text_id" class="row p-2" style="display: none;">
                                            <span class="text-red">(This is a system-generated remark and may be subject to revision for accuracy or clarity.)</span>
                                            <div class="col-md-12">
                                                <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control p-3 <?php if(form_error('lm_remark_text')){echo 'lm_invalid';}?>" id="lm_remark_text" rows="10" cols="70"><?php echo set_value('lm_remark_text');?></textarea>
                                                <input id="validationcheck" type="hidden" class="validationcheck" value="" name="validationcheck" required/>
                                            </div>
                                        </div>


                                        

                                        <!-- <div class="row p-2" id="co_for_reject">
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
                                        </div> -->

                                        <div class="row p-2" id="sk_for_reject">
                                          <div class="col-md-6">
                                            <label><strong><?=$sl_count++?>.</strong> 
                                              <?php echo "<label>Select Circle Officer (CO)</label>";?>
                                            </label>
                                            <?=form_error('co_code')?>
                                          </div>
                                          <div class="col-md-6">
                                              <select class="form-control <?php if(form_error('co_code')){echo 'lm_invalid';}?>" name='co_code'>
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
                                            <!-- <select class="form-control <?php if(form_error('co_code_reject')) { echo 'lm_invalid';}?>" name='co_code'>        -->
                                                <option value="">Select Circle Officer...</option>
                                                <?php
                                                foreach ($co_name_reject as $coname) 
                                                {
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
                                                ?>
                                            </select>
                                            <br>
                                          </div>
                                        </div>


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

                                        <div class="row p-2" >
                                            <div class="col-md-6">
                                            <span><strong><?=$sl_count++?>.</strong> Upload Legal heir`s document (Next of Kin)</span>
                                                <?=form_error('legal_heir_doc')?>
                                            </div>
                                            <div class="col-md-6">
                                              <input type="file" accept=".png, .jpg, .jpeg, .pdf" name="legal_heir_doc" id="legal_heir_doc" class="form-control <?php if(form_error('legal_heir_doc')){echo 'lm_invalid';}?>"
                                              />
                                            </div>
                                        </div>


                                        <div class="row p-2 <?php if(form_error('lra_deed_no')){echo 'lm_invalid';}?>">
                                            <div class="col-md-6">
                                                <?=form_error('lra_deed_no');?>
                                                <strong><?=$sl_count++?>.</strong> Deed No</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" value="<?=(!empty($basic['deed_no']))?$basic['deed_no']:''?>" name="lra_deed_no"
                                                id="lra_deed_no" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>" 
                                                placeholder="Deed No">
                                            </div>
                                        </div>


                                        <div class="row p-2 <?php if(form_error('lra_deed_date')){echo 'lm_invalid';}?>">
                                            <div class="col-md-6">
                                                <?=form_error('lra_deed_date');?>
                                                <strong><?=$sl_count++?>.</strong> Deed Date</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" value="<?=(!empty($basic['deed_date']))?date('Y-m-d', strtotime($basic['deed_date'])):''?>" name="lra_deed_date"
                                                id="lra_deed_date" class="form-control <?php if(form_error('lm_note')){echo 'lm_invalid';}?>" 
                                                placeholder="Deed Date">
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Add / View Legal Heir`s Detail</label>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" onclick="addLegalHeir();" class="btn btn-sm btn-warning" style="margin-top:-5px !important">Add / View Legal Heir</button>
                                            </div>
                                        </div>

                                        

                                        <?php
                                        include(APPPATH."views/SettlementView/include/addMoreDocumentView.php");
                                        ?>
                                        <!--------------------khas lnd lm report end------>
                                    </div>

                                    <?php
                                    //include(APPPATH."views/SettlementView/include/village_wise_area_show_lm.php");
                                    ?>
                                </div>

                            </div>

                            <?php if(DISABLE_ALL_BUTTON == 0) { ?>

                                <ul class="list-inline pull-right" style="margin-top: 20px">
                                    <li>
                                        <button type="button" class="btn btn-default prev-step">
                                            <i class="fa fa-arrow-circle-left"> </i>   Previous
                                        </button>
                                    </li>
                                    <li>
                                        <input type="submit" onClick="this.disabled=true; this.value='Saving...';" value="Save and submit" class="btn btn-primary next-step" id="btnLmSubmit">
                                            <!-- <i class="fa fa-check-square-o"> </i>  Save and submit
                                        </button> -->
                                    </li>
                                </ul>
                            <?php } ?>
                        </div>


                        <!-- new premium addition -->
                        <?php include(APPPATH."views/SettlementView/include/premium_calculation_modal_tea_mb3.php"); ?>


                        <!-- LM template start -->
                        <?php
                        
                            $posdate              = "";
                            $barak_ad_prop_total  = "";
                            $aditional_prop_total = "";
                            if (isset($additional_property)){

                                if(isset($total_aditional_area_g))
                                {
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
                            } else {
                                $aditional_prop_total="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
                            }
                            foreach ($dags as $dag_urban) {
                                if($dag_urban->is_urban=="Y") {
                                    $lmtown="টাউনৰ অন্তৰ্গত ";
                                    $lmposession="ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ / আৰ চি চিঘৰ ) ";
                                    $lmposdate="২৮ জুন, ২০০১ চনৰ ";
                                } else {
                                    $lmtown="";
                                    $lmposession="ঘৰবস্তী / খেতি-বাতি ";
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


                        // echo "<pre>"; var_dump($applicants_dag_details); die;

                        if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))){
                            $resultdags = array();




                        foreach($applicants_dag_details as $dags_lmtemplate){
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
                                    var mbigha = parseFloat($("#tot_applied_b").val());
                                    var mkatha = parseFloat($("#tot_applied_k").val());
                                    var mlessa = parseFloat($("#tot_applied_lc").val());
                                    var mganda = parseFloat($("#tot_applied_g").val());
                                    var total_home = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
                                    var total_area = total_home;

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
                                    <?php foreach($applicants_encroacher as $dags_lmtemplate3){ ?>

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
                        $all_dags=implode(",",$resultdags); ?>
                        <?php } else{
                        $resultdags = array();
                        foreach($applicants_dag_details as $dags_lmtemplate)
                        {
                            $resultdags[] = $dags_lmtemplate->dag_no;
                            foreach ($applicants_buyers as $settlement){
                                if($settlement->is_applicant == 1){
                                    $app_name=$settlement->pdar_name;
                                }
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
                                    var mbigha = parseFloat($("#tot_applied_b").val());
                                    var mkatha = parseFloat($("#tot_applied_k").val());
                                    var mlessa = parseFloat($("#tot_applied_lc").val());
                                    
                                    var total_home = ((mbigha * 100) + (mkatha * 20) + mlessa);
                                    var total_area = total_home;

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
                                    <?php foreach($applicants_dag_details as $dags_lmtemplate3){ ?>
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
    })

    $("#lm_remark").change(function (event) {


        var selectedRemark=$(this).val();

        <?php 
          foreach($dags as $r)
          {
            $dag        = '';
            $patta_no   = '';
            $patta_code = '';
            $message    = '';
            $msg        = '';

            if(in_array($r->dist_code, json_decode(BARAK_VALLEY)))
            {
              $message .= $r->dag_no." ত ".$r->s_dag_area_b. " বিঘা ".$r->s_dag_area_k. " কঠা ".$r->s_dag_area_lc. " চাতক ".$r->s_dag_area_g. " গণ্ডা, " ;

              $msg .= $r->s_dag_area_b. " বি ".$r->s_dag_area_k. " ক ".$r->s_dag_area_lc. " চা ".$r->s_dag_area_g. " গ, ";
            }
            else
            {
              $message .= $r->dag_no." ত ".$r->s_dag_area_b. " বিঘা ".$r->s_dag_area_k. " কঠা ".$r->s_dag_area_lc. " লেছা, " ;

              $msg .= $r->s_dag_area_b." বি ".$r->s_dag_area_k." ক ".$r->s_dag_area_lc." লে, ";
            }                                                
            $dag       .= $r->dag_no;
            $patta_no   = $r->patta_no;
            $patta_code = $r->patta_type_code;
          }
        ?>

        if(selectedRemark==1)
        {
          $('#lm_remark_text_id').show();
          // totalAppliedArea();
          $('#lm_remark_text').text('');

          <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
          
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $main_applicant->pdar_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?> লাটৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চাহ পট্টা নং <?php echo $patta_no;?> অন্তর্গত");

            <?php foreach($dags as $r): ?>
              $('#lm_remark_text').append(" দাগ নং <?php echo $r->dag_no?> ত <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> চ <?php echo $r->s_dag_area_g?> গ ,");
            <?php endforeach; ?>

            $('#lm_remark_text').append(" ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন বাবে আবেদন কৰিছে ।");

            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী / খেতি-বাতি/ ব্যৱসায় প্রতিষ্ঠান / উদ্যোগ হিচাপে দখলকৰি থকা দেখা গল ।");

            <?php foreach($dags as $lmnote_dag): ?>
              $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>

            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন  লোক হয় । আবেদনকাৰীৰ পৰিয়ালত থকা পট্টা আৰু ৰায়তি মাটি ও আবেদিত মাটি সহ চিলিং সীমাৰ ঊর্ধত নহয় । আবেদনকাৰীয়ে দাখিল কৰা নথি ও চৰজমিন তদন্তৰ মৰ্মে ২০২২ চনৰ আগৰ পৰাই বৈধ দলিল সুএে হস্তান্তৰ কৰি "+$('#lm_possession_entry').val()+" চনৰ পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক হয় । গতিকে Assam Fixation of Ceiling on Land Holdings Act,1956 as amended vide Assam Fixation of Ceiling on Land Holdings Act, 2024 ৰ ধাৰা 4(2) মতে যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি");

            <?php foreach($dags as $r): ?>
              $('#lm_remark_text').append(" দাগ নং <?php echo $r->s_dag_area_b?> ত  <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> চা <?php echo $r->s_dag_area_g?> গ,");
            <?php endforeach; ?>

            $('#lm_remark_text').append("নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন দিব পৰা যায় ।");

          <?php else : ?>
            $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $main_applicant->pdar_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?> লাটৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চাহ পট্টা নং <?php echo $patta_no;?> অন্তর্গত");

            <?php foreach($dags as $r): ?>
              $('#lm_remark_text').append(" দাগ নং <?php echo $r->dag_no?> ত <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> লে,");
            <?php endforeach; ?>
      
            $('#lm_remark_text').append(" ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন বাবে আবেদন কৰিছে ।");

            $('#lm_remark_text').append("\n \n "+$('#lm_verification_date').val()+" তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী / খেতি-বাতি/ ব্যৱসায় প্রতিষ্ঠান / উদ্যোগ হিচাপে দখলকৰি থকা দেখা গল ।");

            <?php foreach($dags as $lmnote_dag): ?>
              $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
            <?php endforeach; ?>

            $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন  লোক হয় । আবেদনকাৰীৰ পৰিয়ালত থকা পট্টা আৰু ৰায়তি মাটি ও আবেদিত মাটি সহ চিলিং সীমাৰ ঊর্ধত নহয় । আবেদনকাৰীয়ে দাখিল কৰা নথি ও চৰজমিন তদন্তৰ মৰ্মে ২০২২ চনৰ আগৰ পৰাই বৈধ দলিল সুএে হস্তান্তৰ কৰি "+$('#lm_possession_entry').val()+" চনৰ পৰা উক্ত ভূমি ভাগত দখল কৰি থকা লোক হয় । গতিকে Assam Fixation of Ceiling on Land Holdings Act,1956 as amended vide Assam Fixation of Ceiling on Land Holdings Act, 2024 ৰ ধাৰা 4(2) মতে যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি");

            <?php foreach($dags as $r): ?>
              $('#lm_remark_text').append(" দাগ নং <?php echo $r->s_dag_area_b?> ত <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> লে,");
            <?php endforeach; ?>

            $('#lm_remark_text').append("নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন দিব পৰা যায় ।");

          <?php endif ;?>

        }
        else if(selectedRemark==2) {

            $(  '#lm_remark_text_id').show();
            // totalAppliedArea();

            $('#lm_remark_text').text('');
            <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $main_applicant->pdar_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চাহ পট্টা নং <?php echo $patta_no;?> অন্তর্গত");

                <?php foreach($dags as $r): ?>
                  $('#lm_remark_text').append(" দাগ নং <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> চ <?php echo $r->s_dag_area_g?> গ,");
                <?php endforeach; ?>

                $('#lm_remark_text').append("ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন বাবে আবেদন কৰিছে ।");

                $('#lm_remark_text').append("\n \n <?php echo date('d/m/Y');?> তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী / খেতি-বাতি/ ব্যৱসায় প্রতিষ্ঠান / উদ্যোগ হিচাপে দখলকৰি থকা দেখা গল ।");

                <?php foreach($dags as $lmnote_dag): ?>
                $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
                <?php endforeach; ?>

                $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন লোক।");
                $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক নহয়। ");
                $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি ");

                <?php foreach($dags as $r): ?>
                    $('#lm_remark_text').append(" দাগ নং <?php echo $r->s_dag_area_b?> ত  <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> চ <?php echo $r->s_dag_area_lc?> গ,");
                <?php endforeach; ?>

                $('#lm_remark_text').append("ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন দিব পৰা নাযায় ।");

            <?php else : ?>
                $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $main_applicant->pdar_name?> য়ে <?php echo $this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"])?>ৰ <?php echo $this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?> <?php echo $lmtown?> ৰাজহ গাওঁৰ চাহ পট্টা নং <?php echo $patta_no;?> অন্তর্গত");

                <?php foreach($dags as $r): ?>
                  $('#lm_remark_text').append(" দাগ নং <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> লে,");
                <?php endforeach; ?>

                $('#lm_remark_text').append("ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন বাবে আবেদন কৰিছে ।");

                $('#lm_remark_text').append("\n \n <?php echo date('d/m/Y');?> তাৰিখে চৰজমিন তদন্তৰ সময়ত আবেদনকাৰীয়ে ঘৰবস্তী / খেতি-বাতি/ ব্যৱসায় প্রতিষ্ঠান / উদ্যোগ হিচাপে দখলকৰি থকা দেখা গল ।");

                <?php foreach($dags as $lmnote_dag): ?>
                $('#lm_remark_text').append("\n \n উক্ত <?php echo $lmnote_dag->dag_no?> দাগৰ উত্তৰে "+$('#landmark_north'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" দক্ষিণে "+$('#landmark_south'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" পূবে "+$('#landmark_east'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" আৰু পশ্চিমে "+$('#landmark_west'+'<?php echo $lmnote_dag->dag_no; ?>').val()+" থকা দেখা যায়।");
                <?php endforeach; ?>

                $('#lm_remark_text').append("\n \n আবেদনকাৰী "+$('#caste_name').val()+" জাতিৰ/ শ্ৰেণীৰ এজন লোক।");
                $('#lm_remark_text').append("\n \n আবেদনকাৰীজন <?php echo $aditional_prop_total.' '.$barak_ad_prop_total." কৃষক " ?>,  "+$('#occupation_applicant').val()+" । আবেদনকাৰীয়ে দাখিল কৰা নথি মতে <?php echo $lmposdate?> পৰা উক্ত ভূমি ভাগত  দখল কৰি থকা লোক নহয়। ");
                $('#lm_remark_text').append("\n \n গতিকে ভূমি নীতি মতে পট্টনৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি আৰু সংৰক্ষন কৰিব লগা ভূমি বাদ দি ");

                <?php foreach($dags as $r): ?>
                    $('#lm_remark_text').append(" দাগ নং <?php echo $r->s_dag_area_b?> ত <?php echo $r->s_dag_area_b?> বি <?php echo $r->s_dag_area_k?> ক <?php echo $r->s_dag_area_lc?> লে,");
                <?php endforeach; ?>

                $('#lm_remark_text').append("ত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন দিব পৰা নাযায় ।");
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




    $("input:radio[name=landslide]").click(function() {
      if($('input:radio[name=landslide]:checked').val() == 'YES') {
        $($('#land_falls_periphery').prop('checked', true));
        // $('input:radio[name=land_falls_periphery]').prop('disabled', true);
      }
      else
      {
        $($('#land_falls_periphery').prop('checked', false));
        // $('input:radio[name=land_falls_periphery]').prop('disabled', false);
      }
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


<script>
    <?php if((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))){ ?>
        function totalAreaCal(){
            $('#totaldue').val('');
            $('#validationcheck').val('');
            $('#lm_remark_text').text('');
            $('#lm_remark').val('');
            $('.totalamount').val('');
            // for homestead
            var length = <?=$total_area_bigha?>;
            var total_area = 0;
            for(i=1; i<length; i++){
                var mbigha = parseFloat($("#enc_home_b"+i).val());
                var mkatha = parseFloat($("#enc_home_k"+i).val());
                var mlessa = parseFloat($("#enc_home_lc"+i).val());
                var mganda = parseFloat($("#enc_home_g"+i).val());

                var total_area = total_area + ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
            }

            var bigha_r = Math.floor(total_area / 6400);
            var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
            var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
            var ganda_r = total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20;

            $("#tot_applied_b").val(bigha_r);
            $("#tot_applied_k").val(katha_r);
            $("#tot_applied_lc").val(lessa_r);
            $("#tot_applied_g").val(ganda_r);
        }
    <?php } else { ?>
        function totalAreaCal(){
            $('#totaldue').val('');
            $('#validationcheck').val('');
            $('#lm_remark_text').text('');
            $('#lm_remark').val('');
            $('.totalamount').val('');
            // for homestead
            var length = <?php echo $total_area_bigha?>;
            var total_area = 0;
            for(i=1; i<length; i++){
                var mbigha = parseFloat($("#enc_home_b"+i).val());
                var mkatha = parseFloat($("#enc_home_k"+i).val());
                var mlessa = parseFloat($("#enc_home_lc"+i).val());
                var total_area = total_area + ((mbigha * 100) + (mkatha * 20) + mlessa);
            }

            var bigha_r = Math.floor(total_area / 100);
            var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
            var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

            $("#tot_applied_b").val(bigha_r);
            $("#tot_applied_k").val(katha_r);
            $("#tot_applied_lc").val(lessa_r);
        }
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
        premModal.style.display = "block";

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
        if($applicants_dag_details == true)
        {
        foreach($applicants_dag_details as $encroacher_ext){
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

<?php include(APPPATH."views/SettlementView/include/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editApplicantDetails.js"></script>

<?php include(APPPATH."views/TeaGrant/common/editAreaDetailsTeaGrant.php"); ?>

<?php include(APPPATH."views/TeaGrant/common/editFamilyDetails.php"); ?>


<?php include(APPPATH."views/TeaGrant/common/addTeaApplicantDetails.php"); ?>


<?php include(APPPATH."views/TeaGrant/common/familyDetails.php"); ?>


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


<script type="text/javascript">

  // if($("#dis_cat_type").val() == null || $("#dis_cat_type").val() == '')
  // {
  //   $("#dis_cat_type").prop('disabled', true);
  // }
  // else
  // {
  //   $("#dis_cat_type").prop('disabled', false);
  // }

  // $("#dalil_upload").prop('disabled', true);
  

  // $("input:radio[name=bonafide_transferee]").click(function() 
  // {
  //   if($('input:radio[name=bonafide_transferee]:checked').val() == 'YES') 
  //   {
  //     $("#dalil_upload").prop('disabled', false);
  //   } 
  //   else 
  //   {
  //     $("#dalil_upload").prop('disabled', true);
  //   }
  // })


  // $("input:radio[name=dispute_possession]").click(function() 
  // {
  //   if($('input:radio[name=dispute_possession]:checked').val() == 'YES') 
  //   {
  //     $("#dis_cat_type").prop('disabled', false);
  //   } 
  //   else 
  //   {
  //     $("#dis_cat_type").prop('disabled', true);
  //     $("#dis_cat_type").val('');
  //   }
  // })

  $("input:radio[name=bonafide_transferee]").click(function() 
  {
    if($('input:radio[name=bonafide_transferee]:checked').val() == 'NO') 
    {
      $(".canRecommend").hide();
    } 
    else 
    {
      $(".canRecommend").show();
    }
  });

  $(function () {
    $('#lm_possession_entry').datepick({dateFormat: 'dd-mm-yyyy'});
    $('#lra_deed_date').datepick({dateFormat: 'dd-mm-yyyy'});
  });

  $(document).ready(function()
  {
    var is_tribal_belt = $('[name="is_tribal_belt"]:checked').val();

    if(is_tribal_belt == 'YES'){
      $('#tribal_belt_input_id').show();
      $('#protected_class_id').show();
      $('#contravention').hide();
    }else if (is_tribal_belt == 'NO'){
      $('#tribal_belt_input_id').hide();
      $('#protected_class_id').hide();
      $('#contravention').show();
    }
  });
  
 
  function handleTribalClick(elmt){
    if (elmt.value === "YES") {
      $('#tribal_belt_input_id').show();
      $('#protected_class_id').show();
      $('#contravention').hide();
    } else if (elmt.value === "NO") {
      $('#tribal_belt_input_id').hide();
      $('#protected_class_id').hide();
      $('#contravention').show();
    }
  }

</script>
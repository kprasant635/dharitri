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

        <?php //var_dump($this->session->flashdata('message')); ?>

        <?php if ($this->session->flashdata('message')): ?>
            <div class="success-msg">
                <div class="alert alert-warning alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-info"></i> <?php echo $this->session->flashdata('message') ?></b>
                </div>
            </div>
        <?php endif; ?>


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

            <div class="col-md-12 text-right text-cyan">
                Process > 
                Settlement MB3 > 
                <a href="<?=base_url().'index.php/Home/TeaGrantLandCo?service='.TEA_SERVICE_CODE?>">Tea Grant</a> >
                <a href="<?=base_url().'index.php/TeaGrantControllerCo/initialLanding?service='.TEA_SERVICE_CODE.'&s=i'?>">Case Registration</a> >
                <b>View</b>
            </div><br>

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
                  <strong>Circle Officer</strong>
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


                <form role="form" class="lmForm" method="post" action="<?php echo base_url() ?>index.php/TeaGrantControllerCo/applicationTeaGrantRegistrationCo?app=<?=$_GET['app']?>>" enctype="multipart/form-data">   

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
                                    <?php 
                                        
                                        $i = 1; foreach ($applicants_buyers as $settlement):
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

                                                        <input type="text" readonly name="pdar_add1<?=$settlement->id?>" id="pdar_add1<?=$settlement->id?>" value="<?=$pre_addr->address?>" class="form-control input-sm">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Present address</th>
                                                    <td>
                                                        <input type="text" readonly name="pdar_add2<?=$settlement->id?>" id="pdar_add2<?=$settlement->id?>" value="<?=$per_addr->address?>" class="form-control input-sm" >
                                                    </td>

                                                    <?php if($settlement->is_applicant == 1) {?>

                                                        <th>Possession Since</th>
                                                        <td>
                                                            <input 
                                                            type="text" 
                                                            readonly 
                                                            name="possession_since" 
                                                            id="possession_since" 
                                                            value="<?=$settlement->period_possession?>" 
                                                            class="form-control input-sm">
                                                        </td>

                                                    <?php } ?>
                                                    
                                                </tr>

                                            </table>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach; ?>
                                    <?php if ($applicants_owners == true) {?>
                                        <h5 class="reza-title" style="margin-top: 50px">
                                            <i class="fa fa-user-circle-o" aria-hidden="true"></i> Owner Details
                                        </h5>
                                        <div class="tableCard ">
                                            <table class="table table-bordered">
                                                <?php
                                                foreach ($applicants_owners as $owners) {

                                                    // echo "<pre>"; var_dump($owners); die;

                                                    ?>
                                                    <tr>
                                                        <th>Name</th>
                                                        <td colspan="2">
                                                            <input type="text" name="owners_name<?=$owners->id?>" value="<?=$owners->pdar_name;?>" class="form-control input-sm" readonly>
                                                        </td>
                                                        <th>Father's name</th>
                                                        <td colspan="2">
                                                            <input type="text" name="owners_guardian<?=$owners->id?>" value="<?=$owners->pdar_guardian;?>" class="form-control input-sm" readonly>
                                                        </td>
                                                        <input type="hidden" name="owners_pdar_id<?=$owners->id?>" value="<?=$owners->pdar_id?>">
                                                        <input type="hidden" name="owners_pdar_type<?=$owners->id?>" value="O">
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                    
                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-map"></i>  Area Details
                                    </h5>
                                    <div class="tableCard">
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

                                                ?>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align : middle;">
                                                        <div class="vertical">
                                                            DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> <br>
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
                                                    <th class="text-success enc-area-color">Applied Area</th>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$all_dags->dag_no?>" id="enc_home_b<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$encroachment_area->applied_bigha;?>">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$all_dags->dag_no?>" id="enc_home_k<?=$all_dags->dag_no?>" value="<?=$encroachment_area->applied_katha;?>" class="form-control input-sm enc_home_k">
                                                    </td>
                                                    <td class="enc-area-color">
                                                        <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$all_dags->dag_no?>" id="enc_home_lc<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_lc" value="<?=$encroachment_area->applied_lessa;?>">
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="enc-area-color">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->applied_ganda;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_dags->dag_no?>" id="enc_home_g<?=$all_dags->dag_no?>">
                                                        </td>
                                                        <td class="enc-area-color hide">
                                                            <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->applied_kranti;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_dags->dag_no?>" id="enc_home_kr<?=$all_dags->dag_no?>">
                                                        </td>
                                                    <?php endif;?>
                                                </tr>


                                            <?php }?>

                                            <?php
                                            // for dag not eligible
                                            include(APPPATH."views/SettlementView/include/dagNotEligibleView.php");
                                            ?>

                                            
                                            
                                        </table>
                                        <!-- this only to display the error message in area validation -->
                                        <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                                        <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                                        <br>

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
                                        <i class="fa fa-users"></i> Existing Pattadar
                                    </h5>
                                    <?php if(!empty($existing_pattadar)) { ?>
                                        <div class="tableCard">
                                            <table class="table table-bordered" id="existingPattadar">
                                                <tr>
                                                    <th>Dag No | Patta No</th>
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
                                                    <th>Dag No | Patta No</th>
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
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Circle Officer's Remark
                                    </h5>
                                    <div class="tableCard" style="padding-bottom: 15px">

                                        <?php
                                            if(count($deed_applicant) >= 1){
                                                $user = 'SRO';
                                                $status = 'the';
                                            }
                                            else {
                                                $user = 'LRA';
                                                $status = 'no';
                                            } 
                                        ?>

                                        <div class="row p-2">
                                            <div class="col-md-12">
                                                <label class="lg bg-warning">The case will be forwarded to both LRA and SRO(for deed no verification) !!! </label>
                                            </div>
                                        </div>                                        
                                        
                                        <div class="row p-2">

                                            <div class="col-md-3">
                                                <span>Enter Deed No</span>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="deed_no" id="deed_no" 
                                                class="form-control" placeholder="Enter Deed No">
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">&nbsp;</div>

                                            <div class="col-md-3">
                                                <span>Enter Deed Date</span>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="deed_date" id="deed_date" 
                                                class="form-control" placeholder="Enter Deed Date">
                                            </div>

                                            <div class="col-md-12">&nbsp;</div>

                                            <?php if(SEND_TO_MULTIPLE_SRO_DIST == 1) { ?>

                                              <div class="col-md-3">
                                                  <span>Select District(s) For SRO verification</span>
                                              </div>
                                              <div class="col-md-9 col-lg-9 col-sm-9 col-xs-12">
                                                <div class="list-group form__div" id="multi_dist_sro"
                                                style="height:200px;overflow:auto;border: solid 3px #181842;">
                                                  <div class="border p-3 rounded">
                                                    <?php foreach(json_decode(DISTRICT_LIST_TO_SEND_SRO) as $dist) { ?>
                                                      <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="<?=$dist->CODE?>" name="multi_dist_sro[]" value="<?=$dist->CODE?>">
                                                        <label class="form-check-label" for="<?=$dist->CODE?>">
                                                          <?=$dist->NAME?>
                                                        </label>
                                                      </div>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                              </div>
                                            <?php } ?>

                                            <div class="col-md-3">&nbsp;</div>

                                            <div class="col-md-9 text-red"><b><br>This is a system-generated remark and may be subject to revision for accuracy or clarity !!! </b></div>

                                            <div class="col-md-3">
                                                <span>CO Remark</span>
                                                <?=form_error('chitha_verified')?>
                                            </div>

                                            <div class="col-md-9 text-bold">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="recommend" id="recommend"
                                                    value="<?=YES?>">
                                                    <label class="form-check-label" for="inlineRadio1">Can be Recommended</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="recommend" id="notrecommend"
                                                    value="<?=NO?>">
                                                    <label class="form-check-label" for="inlineRadio1">Can not Recommended</label>
                                                </div>
                                            </div>

                                            <?php

                                              $dag        = '';
                                              $patta_no   = '';
                                              $patta_code = '';
                                              $message    = '';

                                              foreach($dags as $r)
                                              {
                                                if(in_array($r->dist_code, json_decode(BARAK_VALLEY)))
                                                {
                                                  $message .= $r->dag_no." নং দাগৰ ".$r->s_dag_area_b. " বিঘা ".$r->s_dag_area_k. " কঠা ".$r->s_dag_area_lc. " চাতক ".$r->s_dag_area_g. " গণ্ডা, " ;
                                                }
                                                else
                                                {
                                                  $message .= $r->dag_no." নং দাগৰ ".$r->s_dag_area_b. " বিঘা ".$r->s_dag_area_k. " কঠা ".$r->s_dag_area_lc. " লেছা, " ;
                                                }                                                
                                                $dag       .= $r->dag_no;
                                                $patta_no   = $r->patta_no;
                                                $patta_code = $r->patta_type_code;
                                              }
                                              $patta_name = $this->utilityclass->getPattaName($patta_code);
                                            ?>


                                            <div class="col-md-3">&nbsp;</div>

                                            <div class="col-md-9">
                                                <textarea name="co_remark" class="form-control" placeholder="Enter Remark" id="co_remark" cols="30" rows="10">আবেদনকাৰীৰ নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন ৰ আৱেদন চোৱা হল । আবেদনকাৰীয়ে <?=$mouza_name?> মৌজা ৰ <?=$vill_name?> গাৱৰ <?=$patta_no?> নং <?=$patta_name?>, <?=$message?>  মাটিত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন ৰ বাবে আবেদন কৰিছে । ভূমিলেখ্য সহায়ক ই চৰজমিন কৰি আবেদনকাৰীয়ে <?=$mouza_name?>  মৌজা ৰ <?=$vill_name?>  গাৱৰ উক্ত মাটিত নামজাৰী / বাটোৱাৰা / ম্যাদী পট্টা লৈ পৰিৱৰ্তন সম্পৰ্কে জিঅ'টেগ কৰা ফটো আপলোড কৰি আৰু দখল সম্পৰ্কে বিতং প্রতিবেদন পঞ্জীয়ন কৰা দলিলৰ নং ও তাৰিখ উল্লেখ কৰি দাখিল কৰিব |
                                                </textarea>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right" style="margin-top: 20px">
                                <li>
                                    <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" 
                                    class="btn btn-danger">Reject this case</button>
                                </li>
                                <li>
                                    <button type="button" class="btn btn-default prev-step">
                                        <i class="fa fa-arrow-circle-left"></i>Previous
                                    </button>
                                </li>
                                <li>
                                    <?php if(DISABLE_ALL_BUTTON == 0) { ?>
                                        <input type="submit" onClick="this.disabled=true; this.value='Saving...';" 
                                        value="Forward to LRA & SRO" class="btn btn-primary next-step" id="btnCoSubmit">
                                    <?php } ?>

                                    <input type="hidden" value="<?=count($deed_applicant)?>"
                                    name="deed_appl" id="deed_appl">
                                </li>
                            </ul>
                        </div>

                        <input type="hidden" id="sbigha" name='sbigha'>
                        <input type="hidden" id="skatha" name='skatha'>
                        <input type="hidden" id="slessa" name='slessa'>
                        <input type="hidden" id="sganda" name='sganda'>
                        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                        <input type="hidden" id="alloted_katha" name='alloted_katha'>
                        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
                        <input type="hidden" id="alloted_ganda" name='alloted_ganda'>
                        <input type="hidden" id="sbigha" name='sbigha'>
                        <input type="hidden" id="skatha" name='skatha'>
                        <input type="hidden" id="slessa" name='slessa'>
                        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                        <input type="hidden" id="alloted_katha" name='alloted_katha'>
                        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
                                               
                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>

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



    // $("input:radio[name=landslide]").click(function() {
    //   if($('input:radio[name=landslide]:checked').val() == 'YES') {
    //     $($('#land_falls_periphery').prop('checked', true));
    //     // $('input:radio[name=land_falls_periphery]').prop('disabled', true);
    //   }
    //   else
    //   {
    //     $($('#land_falls_periphery').prop('checked', false));
    //     $('input:radio[name=land_falls_periphery]').prop('disabled', false);
    //   }
    // });


    $('#btnCoSubmit').on('click',function(e){
        e.preventDefault();
        var form = $('.lmForm');
        var encData;
        var encDataAll = [];

        var co_remark = $('#co_remark').val();
        var user      = ($('#deed_appl').val() == 1) ? 'SRO' : 'LRA';
        var recommend = $('input:radio[name=recommend]:checked').val();

        if(recommend == null || recommend == '')
        {
            showWarningMessage("Please check recommend/not recommend radio button !!!");
            return;
        }

        if(co_remark == null || co_remark == '')
        {            
            showWarningMessage("CO remark is required !!!");
            $('#co_remark').focus();
            $('#btnCoSubmit').prop('disabled', false);
            $('#btnCoSubmit').val('Forward to '+user);
            return;
        }

        <?php
            if($applicants_dag_details == true)
            {
                foreach($applicants_dag_details as $encroacher_ext){
        ?>
                    $(".clsencdata").each(function () {
                        encData = "Dag No: "+'<?=$encroacher_ext->dag_no?>'+ " : " + $('#encroacher_exist_vlb<?=$encroacher_ext->id?> option:selected').text();
                    });
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
            title             : 'Are you sure to forward the case to LRA & SRO ?',
            icon              : 'warning',
            showCancelButton  : true,
            confirmButtonText : 'Yes, submit it!',
            cancelButtonText  : 'No, cancel!',
            reverseButtons    : true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit()
            }
            else
            {
                result.dismiss === Swal.DismissReason.cancel
                $('#btnCoSubmit').prop('disabled', false);
                $('#btnCoSubmit').val('Forward to '+user);
            }
        })
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

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }
</script>

<script src="<?php echo base_url();?>js/mb2/notify.js"></script>

<?php include(APPPATH."views/SettlementView/include/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editApplicantDetails.js"></script>


<?php include(APPPATH."views/SettlementView/include/editAreaDetailsNew.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editAreaDetailsNew.js"></script>

<?php include(APPPATH."views/SettlementView/include/editFamilyDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editFamilyDetails.js"></script>

<?php include(APPPATH."views/SettlementView/include/addApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/addApplicantDetails.js"></script>


<script>

    $(function () {
        $('#deed_date').datepick({dateFormat: 'dd-mm-yyyy'});
    });

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


    function rejectSubAlert()
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to Reject this case?',
            html: 'You wont be able to undo this once done',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var case_no = $('#case_no').val();
                showNewDirectRejectModalMb3(''+case_no+'','<?php echo TEA_SERVICE_CODE ?>');
            }
        })
    }


</script>
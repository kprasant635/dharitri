<!-- Masud's CSS-->
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

    div.f-party-alternate > div:nth-of-type(odd) {
        background: #f2fdff;
    }
    div.co-report > form:nth-of-type(odd) {
        background: #f2fdff;
        padding-top: 3px;
        padding-bottom: 5px;
    }

</style>

<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttSuccess {
        color: #FFF;
        background-color: #388E3C;
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

    .badge-reza3{
        background-color: #9C27B0;
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

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="padding-bottom: 5px; padding-top: 10px">
            Process /
            Settlement MB /
            <a href="<?= base_url()?>index.php/SettlementApADC/SettlementApLandDc"> AP Transfer</a> /
            <a href="<?= base_url()?>index.php/SettlementApADC/viewAllApFirstProceedingDCCaseList">First Proceeding</a>

            <a href="<?= base_url()?>index.php/SettlementApADC/SettlementApLandDc">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu
                </button>
            </a>

        </div>

        <section>
            <input type="hidden" id="caseNoHidden" name="caseNoHidden" value="<?php echo $_GET['case']?>" >
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
                        <li role="presentation">
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
                        <li role="presentation">
                            <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="step 5">
                                <span class="round-tab"><strong>ADC</strong></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#proceedings" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                <span class="round-tab"><strong>Proceedings</strong></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#history" data-toggle="tab" aria-controls="history" role="tab" title="history">
                                <span class="round-tab"><strong>History</strong></span>
                            </a>
                        </li>
                        <?php if(!empty($premium_data)) { ?>
                            <li role="premium">
                                <a href="#premium" data-toggle="tab" aria-controls="premium" role="tab" title="premium">
                                    <span class="round-tab"><strong>Premium</strong></span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
                <?php
                $sl_count = 1;
                ?>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <?php  include(APPPATH."views/SettlementView/include/applicationApCoView.php"); ?>
                    </div>

                    <!-- LM reporting starts here -->

                    <div class="tab-pane" role="tabpanel" id="step2">
                        <?php  include(APPPATH."views/SettlementView/include/lmReportApView.php");  ?>

                    </div>

                    <div class="tab-pane" role="tabpanel" id="step5">
                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement AP Transfer (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Previous Remark
                                </h5>
                                <?php if($proceedings){ ?>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 200px">Remark Date</th>
                                                <th style="width: 200px">Remark Time</th>
                                                <th style="width: 200px">Remark from</th>
                                                <th>Remark</th>
                                            </tr>
                                            <?php $i=1; $length=count($proceedings);
                                            foreach($proceedings as $pro):if ($i==1){ ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                                                        <?= date ("d-M-Y",strtotime($pro->date_entry)) ?>
                                                    </td>
                                                    <td style="text-transform: uppercase">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;
                                                        <?= date ("h:i a",strtotime($pro->date_entry)) ?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                        <?=$pro->office_from;?>
                                                    </td>
                                                    <td><?=$pro->note_on_order;?></span></td>
                                                </tr>
                                            <?php } $i++; endforeach;?>
                                        </table>
                                    </div>
                                    <br>

                                <?php } ?>

                                <?php if(isset($new_added_enc_data)){ ?>
                                    <h5 class="bg-danger p-2 text-center">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Newly Added VLB Land Bank encroacher Data
                                    </h5>

                                    <div class="tableCard">
                                        <span class="alert-warning mb-2">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <strong>
                                                After approval occupier/occupiers will added to the VLB.
                                            </strong>
                                        </span>
                                        <table class="table">
                                            <?php
                                            $enc_count =1;
                                            foreach($new_added_enc_data as $enc_data):
                                                ?>
                                                <tr class="bg-warning">
                                                    <th class="text-white" rowspan="7" style="vertical-align : middle;text-align:center;"><?=$enc_count++?></th>
                                                    <th class="text-white">Dag No</th>
                                                    <th colspan="3" class="text-white"><?=$enc_data->dag_no?></th>
                                                </tr>
                                                <tr>
                                                    <th>Encroacher Name</th>
                                                    <td colspan="3"><?=$enc_data->name?></td>
                                                </tr>
                                                <tr>
                                                    <th>Father's Name</th>
                                                    <td colspan="3"><?=$enc_data->fathers_name?></td>
                                                </tr>
                                                <tr>
                                                    <th>Encroachment from</th>
                                                    <td><?=$enc_data->encroachment_from?></td>
                                                    <th>Encroachment To</th>
                                                    <td><?=$enc_data->encroachment_to?></td>
                                                </tr>

                                                <tr>
                                                    <th>Landless Indigenous</th>
                                                    <td><?=$enc_data->landless_indigenous?></td>
                                                    <th>Erosion effected?</th>
                                                    <td><?=$enc_data->erosion?></td>
                                                </tr>
                                                <tr>
                                                    <th>Landless?</th>
                                                    <td><?=$enc_data->landless?></td>
                                                    <th>Caste</th>
                                                    <td><?=$enc_data->caste?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td>
                                                        <?php
                                                        if(trim($enc_data->gender) == 1){
                                                            echo "Male";
                                                        }elseif(trim($enc_data->gender) == 2){
                                                            echo "Female";
                                                        }elseif(trim($enc_data->gender) == 3){
                                                            echo "Others";
                                                        }
                                                        ?>
                                                    </td>
                                                    <th>Type of Land use?</th>
                                                    <td>
                                                        <?php
                                                        foreach(json_decode(LB_ENC_TYPE_OF_LAND_USE) as $land_use):
                                                            if(trim($enc_data->type_of_land_use) == $land_use->CODE){
                                                                echo $land_use->NAME;
                                                            }
                                                        endforeach;
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                <?php }?>

                                <!-- Masud's code-->

                                <input type="hidden" id="caseNo" value="<?php echo $caseDetails->case_no ?>">
                                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12"  style="margin-bottom: 40px">
                                        <h5 class="reza-title" style="margin-top: 15px">
                                            Area Details Dag Wise
                                        </h5>
                                        <div class="tableCard">
                                            <div class="tree" >
                                                <?php if($newDag != '') :?>

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
                                                        ?>

                                                        <ul style="margin-bottom: 50px">
                                                            <li >
                                                        <span>
                                                            <i class="fa fa-map"></i> New Dag Number
                                                            <b><?php echo $singleChithaArea->dag_no ?></b>, Patta Number
                                                            <b><?php echo $singleChithaArea->patta_no ?></b>
                                                        </span>
                                                                <ul style="padding-bottom: 20px!important;">
                                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                                <span class="badge badge-reza1" style="padding: 5px; font-size: 14px;">
                                                                    <i class="fa fa-map-marker"></i>
                                                                    &nbsp; Total Area Details in New Chitha
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
                                                                <span class="badge badge-reza3" style="padding: 5px; font-size: 14px">
                                                                    <i class="fa fa-edit"></i>
                                                                    &nbsp; Applied Area In Dag For Current Case
                                                                </span>
                                                                        <?php foreach ($appliedDags as $singleAppliedArea): ?>
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
                                                                        <?php endforeach; ?>
                                                                    </li>

                                                                    <?php if(!empty($reservation)): ?>
                                                                        <li>
                                                                    <span class="badge badge-reza3" style="padding: 5px; font-size: 14px; background-color: #FF9800">
                                                                        <i class="fa fa-object-ungroup"></i>
                                                                        &nbsp; Reservation Area In Dag For Current Case
                                                                    </span>
                                                                            <?php foreach ($reservation as $singleRes): ?>
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
                                                                            <?php endforeach; ?>

                                                                        </li>
                                                                    <?php endif; ?>

                                                                </ul>
                                                            </li>

                                                        </ul>

                                                    <?php endforeach; ?>

                                                <?php else: ?>

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


                                                                    <!-- LM proceed -->

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
                                                                                        $totalLmProBNotSub += $singleReservedArea->s_dag_area_b;
                                                                                        $totalLmProKNotSub += $singleReservedArea->s_dag_area_k;
                                                                                        $totalLmProLNotSub += $singleReservedArea->s_dag_area_lc;
                                                                                        $totalLmProGNotSub += $singleReservedArea->s_dag_area_g;

                                                                                        $totalLessaNotSub = $this->utilityclass->Total_Lessa($totalLmProBNotSub,$totalLmProKNotSub,$totalLmProLNotSub);
                                                                                        $totalLessaInBKLNotSub  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessaNotSub);
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

                                                                    <!-- LM proceed end -->

                                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                                        <span class="badge badge-reza3" style="padding: 5px; font-size: 14px">
                                                                            <i class="fa fa-spinner"></i>
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

                                                <?php endif ?>
                                            </div>
                                        </div>


                                        <?php
                                        include(APPPATH."views/SettlementView/include/village_wise_area_show_adc_sdo.php");
                                        ?>


                                        <?php if($areaCheck == 1): ?>
                                            <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
                                                Total Area Recommended for Settlement can’t exceed available Area in Chitha !
                                            </h5>
                                            <br>
                                        <?php endif; ?>
                                        <?php if($checkAppliedArea == 1): ?>
                                            <br>
                                            <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
                                                Applied & Additional area can't exceed total <?= MAX_APPLIED_ADDITIONAL_AREA ?> Bigha !
                                            </h5>
                                            <br>
                                        <?php endif; ?>

                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12" align="right">

                                        <?php if(DC_ADC_SDO_PRO_BUTTON == 0 OR DC_ADC_SDO_PRO_BUTTON == 1) { ?>

                                            <?php if($caseDetails->status == MB_PENDING OR $caseDetails->status == MB_RE_REPORT OR $caseDetails->status == MB_REVERT OR $caseDetails->status == MB_UNDER_CONSIDERATION) :?>
                                                <?php if($areaCheck == 0 && $checkAppliedArea == 0): ?>
                                                    <button class="rezaButt buttInfo" id="markAsSDLAC">
                                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                        <?php echo $this->lang->line('markAsSDLAC') ?>
                                                    </button>
                                                <?php endif; ?>
                                                <button class="rezaButt buttPrimary" id="revertFromDcToCo">
                                                    <i class="fa fa-level-down" aria-hidden="true"></i>
                                                    <?php echo $this->lang->line('revertToCO') ?>
                                                </button>
                                                <button class="rezaButt buttDanger" onclick="showNewDirectRejectModalMb2('<?php echo $_GET['case']?>','<?= SETTLEMENT_AP_TRANSFER_ID ?>')">
                                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                    <?php echo $this->lang->line('rejectApp') ?>
                                                </button>
                                                <?php if($caseDetails->status == MB_PENDING): ?>
                                                    <button class="rezaButt buttCust" id="putUnderConsider">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                        <?php echo $this->lang->line('considerSDLAC') ?>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php } ?>


                                        <?php if(DC_ADC_SDO_PRO_BUTTON == 1) { ?>
                                            <?php if($caseDetails->status == MB_PENDING OR $caseDetails->status == MB_RE_REPORT OR $caseDetails->status == MB_REVERT) :?>


                                                <!-- --><?php //if($urban->is_urban == 'Y' && $caseDetails->status == MB_PENDING){ ?>
                                                <!--     <button class="rezaButt buttInfo" id="forwardedToDept">-->
                                                <!--         <i class="fa fa-paper-plane" aria-hidden="true"></i>-->
                                                <!--         --><?php //echo $this->lang->line('forwardDept') ?>
                                                <!--     </button>-->
                                                <!-- --><?php //} else { ?>
                                                <!--     <button class="rezaButt buttInfo" id="approveByDc">-->
                                                <!--         <i class="fa fa-money" aria-hidden="true"></i>-->
                                                <!--         --><?php //echo $this->lang->line('orderForPaymentDc') ?>
                                                <!--     </button>-->
                                                <!-- --><?php //} ?>


                                            <?php elseif($caseDetails->status == MB_MARK_AS_SDLAC) :?>
                                                <button class="rezaButt buttPrimary" id="revertFromDcToCo">
                                                    <i class="fa fa-level-down" aria-hidden="true"></i>
                                                    <?php echo $this->lang->line('revertToCO') ?>
                                                </button>
                                                <button class="rezaButt buttDanger"  onclick="showNewDirectRejectModalMb2('<?php echo $_GET['case']?>','<?= SETTLEMENT_AP_TRANSFER_ID ?>')">
                                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                    <?php echo $this->lang->line('rejectApp') ?>
                                                </button>
                                                <button class="rezaButt buttInfo" id="unMarkAsSDLAC" >
                                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                    <?php echo $this->lang->line('unMarkAsSDLAC') ?>
                                                </button>
                                            <?php elseif($caseDetails->status == MB_SEND_TO_SDLAC) :?>
                                                <?php if($areaCheck == 0 && $checkAppliedArea == 0): ?>
                                                    <!--        <button class="rezaButt buttPrimary" id="approveBySdlac">-->
                                                    <!--            <i class="fa fa-check" aria-hidden="true"></i>-->
                                                    <!--            --><?php //echo $this->lang->line('approveBySdlac') ?>
                                                    <!--        </button>-->
                                                <?php endif; ?>

                                                <!--    <button class="rezaButt buttInfo" id="revertFromSDLACToCo">-->
                                                <!--        <i class="fa fa-level-down" aria-hidden="true"></i>-->
                                                <!--        --><?php //echo $this->lang->line('revertToCO') ?>
                                                <!--    </button>-->
                                                <!--    <button class="rezaButt buttDanger" id="rejectBySdlac">-->
                                                <!--        <i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                                <!--        --><?php //echo $this->lang->line('rejectBySdlac') ?>
                                                <!--    </button>-->
                                            <?php endif; ?>


                                            <?php if($caseDetails->status == MB_NR) :?>
                                                <?php if($areaCheck == 0 && $checkAppliedArea == 0): ?>
                                                    <button class="rezaButt buttInfo" id="approveNR">
                                                        <i class="fa fa-level-down" aria-hidden="true"></i>
                                                        <?php echo $this->lang->line('approvedNr') ?>
                                                    </button>
                                                <?php endif; ?>
                                                <button class="rezaButt buttPrimary" id="revertFromDcToCo">
                                                    <i class="fa fa-level-down" aria-hidden="true"></i>
                                                    <?php echo $this->lang->line('revertToCO') ?>
                                                </button>

                                            <?php endif; ?>

                                        <?php } ?>

                                    </div>
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

                    <div class="tab-pane" role="tabpanel" id="proceedings">

                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement AP Transfer (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                                </h5>
                                <?php if($proceedings){ ?>
                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 200px">Remark Date</th>
                                                <th style="width: 200px">Remark Time</th>
                                                <th style="width: 200px">Remark from</th>
                                                <th>Remark</th>
                                            </tr>
                                            <?php foreach($proceedings as $pro):  ?>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                                                        <?= date ("d-M-Y",strtotime($pro->date_entry)) ?>
                                                    </td>
                                                    <td style="text-transform: uppercase">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;
                                                        <?= date ("h:i a",strtotime($pro->date_entry)) ?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                        <?=$pro->office_from;?>
                                                    </td>
                                                    <td><?=$pro->note_on_order;?></span></td>
                                                </tr>
                                            <?php endforeach;?>
                                        </table>
                                    </div>
                                <?php } ?>
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

                        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                            Settlement AP Transfer (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">
                                <h5 class="reza-title"  style="margin-top: 15px">
                                    <i class="fa fa-history" aria-hidden="true"></i> Case History
                                </h5>
                                <div class="tableCard">
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
                                                        <?php if($pro->office_from != ''): ?>
                                                            <?=$pro->office_from;?>
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

                    <?php if(!empty($premium_data)) { ?>
                        <div class="tab-pane" role="tabpanel" id="premium">

                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                Settlement AP Transfer (
                                <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$_GET['case']?></span> )
                            </h5>
                            <div class="reza-card ">
                                <div class="reza-body">

                                    <h5 class="reza-title" style="margin-top: 15px">
                                        <i class="fa fa-money" aria-hidden="true"></i> Premium Calculation
                                    </h5>

                                    <div class="tableCard " style="padding: 25px!important;">
                                        <?php foreach ($premium_data as $dagsprem) {?>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label>Zonal Value for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <input type="number" name="zonal_valuation_prem<?=$dagsprem->dag_no?>" id="zonal_valuation_prem<?=$dagsprem->dag_no?>"
                                                           class="form-control"
                                                           value="<?=$dagsprem->zonal_valuation?>" readonly/>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label>Selected Area</label>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" id="prem_area" name='area<?=$dagsprem->dag_no?>' value="<?=$dagsprem->area?>" readonly>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Purpose of Land</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" name='land_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->land_type?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Encroached land type</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" id="prem_landtype" name='rate_type<?=$dagsprem->dag_no?>' value="<?=$dagsprem->house_type?>" readonly>

                                                </div>
                                            </div>
                                            <div class="row" id="percentage<?=$dagsprem->dag_no?>">
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Is ST/SC/Widows/Person with disabilities?</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php if($dagsprem->concession =='YES') { ?>
                                                        <label for="html">YES</label>
                                                    <?php } else if ($dagsprem->concession =='NO') { ?>
                                                        <label for="css">NO</label>
                                                    <?php } ?>
                                                    <br>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                    <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                    <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                                                    <?php if($dagsprem->ratetype=='R') { ?>
                                                        <span><b>(Amount: Rs @100/bigha based on above selected area)</b></span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>

                                        <div class="tableCard" style="padding: 25px!important;">
                                            <div class="row">
                                                <div class="form-group col-md-6  text-primary">
                                                    <label for="title">Final Amount</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->final_amount?>" readonly>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Payment Mode</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php if($dagsprem->is_full_pay =='YES') { ?>
                                                        <label for="html">Full Payment</label>
                                                    <?php } else if ($dagsprem->is_full_pay =='NO') { ?>
                                                        <label for="css">30% Down Payment</label>
                                                    <?php } ?>

                                                    <br>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 text-danger">
                                                    <label for="title">Total Due</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control " name="totaldue" id="totaldue"  value="<?=$dagsprem->due_amount?>" readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


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
                    <?php } ?>
                </div>

        </section>

    </div>
</div>


<!-- Modal Revert to co -->
<div class="modal" role="dialog" id="revertFromDcToCoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Application Revert  To CO</h5>
            </div>
            <div class="modal-body" align="">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="revertToCoRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="revertFromDcToCoModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="revertFromDcToCoModalYes">REVERT TO CO</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Application Forwarded To Dept -->
<div class="modal" role="dialog" id="forwardedToDeptModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Application Forwarded To Department</h5>
            </div>
            <div class="modal-body" align="">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="forwardRemarksDc" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="forwardedToDeptModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="forwardedToDeptModalYes">FORWARD</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Application Order for NR Dc -->
<div class="modal" role="dialog" id="approveNrModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Order For NR</h5>
            </div>
            <div class="modal-body" align="">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="approveRemarksDcNr" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="approveNrModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="approveNrModalYes">SUBMIT</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Application Order for payment generate Dc -->
<div class="modal" role="dialog" id="approveByDcModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Order For Payment Generate</h5>
            </div>
            <div class="modal-body" align="">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="approveRemarksDc" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="approveByDcModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="approveByDcModalYes">SUBMIT</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Application Rejected By DC -->
<div class="modal" role="dialog" id="rejectedByDcModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reject Application </h5>
            </div>
            <div class="modal-body" align="">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="rejectedRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="rejectedByDcModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="rejectedByDcModalYes">REJECT</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mark as SDLAC -->
<div class="modal" role="dialog" id="markAsSDLACModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to Recommend this application for SDLAC/CDLAC</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="markAsSDLACModalNo">NO</button>
                <button type="button" class="btn btn-primary"   id="markAsSDLACModalYes">YES</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Remove Mark as SDLAC -->
<div class="modal" role="dialog" id="unMarkAsSDLACModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to remove this application from SDLAC marking</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="unMarkAsSDLACModalNo">NO</button>
                <button type="button" class="btn btn-primary"   id="unMarkAsSDLACModalYes">YES</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Application Approve by SDLAC -->
<div class="modal" role="dialog" id="approveBySdlacModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Approve Application </h5>
            </div>
            <div class="modal-body" align="">
                <div class="modal-body" align="center">
                    <h3>Are You Sure !</h3>
                    <br>
                    <h5 style="color: #1B5E20; font-weight: bold">You Want to Approve The Case </h5>
                    <hr>
                    <div style="font-weight: bold; color: #3F51B5; font-size: 17px" id="minutesDetails">

                    </div>
                </div>

                <input type="hidden" id="approveRemarksSDLAC" required minlength="1" readonly>
                <input type="hidden" id="minutesProposalId" required  readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="approveBySdlacModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="approveBySdlacModalYes">APPROVE</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Application Rejected By SDLAC -->
<div class="modal" role="dialog" id="rejectedBySdlacModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reject Application </h5>
            </div>
            <div class="modal-body" align="">

                <div class="modal-body" align="center">
                    <h3>Are You Sure !</h3>
                    <br>
                    <h5 style="color: #C62828; font-weight: bold">You Want to Reject The Case </h5>
                    <hr>
                    <div style="font-weight: bold; color: #3F51B5; font-size: 17px" id="minutesDetailsRejected">

                    </div>
                </div>

                <input type="hidden" id="rejectedRemarksSDLAC" required minlength="1" readonly>
                <input type="hidden" id="minutesProposalIdRejected" required  readonly>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="rejectedBySdlacModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="rejectedBySdlacModalYes">REJECT</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal SDLAC Revert to CO -->
<div class="modal" role="dialog" id="revertFromSDLACToCoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Application Revert SDLAC To CO</h5>
            </div>
            <div class="modal-body" align="">

                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Has the case been Approved by SDLAC ?</label>
                            <select name="" id="sdlacApproveStatus" class="form-control">
                                <option value="<?php echo PRO_CASE_APPROVED_STATUS ?>">Yes</option>
                                <option value="<?php echo PRO_CASE_NOT_APPROVED_STATUS ?>">No</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="w3review" style="font-weight: bold">Enter Your Remarks</label>
                            <textarea class="form-control" name="w3review" id="revertSdlacToCoRemarks" rows="4" required minlength="1"> </textarea>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div style="font-size: 14px; color: #EF5350; font-weight: bold; margin-top: 10px; margin-bottom: 10px">
                        Note: If SDLAC not Approved and you Revert this application to CO, Then you have to generate new proposal Id.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="revertFromSDLACToCoModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="revertFromSDLACToCoModalYes">REVERT TO CO</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Put Under Consideration -->
<div class="modal" role="dialog" id="putUnderConsiderModal">
    <div class="modal-dialog modal-lg" role="document" style="width: 50%!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Application Put Under Consideration</h5>
            </div>
            <div class="modal-body" align="left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Reason <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <select name="consideration_reason" id="consideration_reason" class="form-control" required>
                            <?php foreach(json_decode(PUT_UNDER_CONSIDERATION) as $cons){ ?>
                                <option value="<?=$cons->CODE?>"><?=$cons->NAME?></option>
                            <?php } ?>
                        </select>
                        <br>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Additional Note (If Any)</label>
                        <textarea name="consideration_remark" class="form-control" id="consideration_remark" cols="30" rows="3" >
                        </textarea>
                    </div>
                </div>
                <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="putUnderConsiderModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="putUnderConsiderModalYes" style="margin-top: 0px;">Submit</button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
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

    $(function () {
        $(".tree li:has(ul)")
            .addClass("parent_li")
            .find(" > span")
            .attr("title", "Collapse this branch");
        $(".tree li.parent_li > span").on("click", function (e) {
            var children = $(this).parent("li.parent_li").find(" > ul > li");
            if (children.is(":visible")) {
                children.hide("fast");
                $(this)
                    .attr("title", "Expand this branch")
                    .find(" > i")
                    .addClass("icon-plus-sign")
                    .removeClass("icon-minus-sign");
            } else {
                children.show("fast");
                $(this)
                    .attr("title", "Collapse this branch")
                    .find(" > i")
                    .addClass("icon-minus-sign")
                    .removeClass("icon-plus-sign");
            }
            e.stopPropagation();
        });
    });



    // ****************************************************************
    // Revert Application From DC TO CO
    $(document).on('click','#revertFromDcToCo',function ()
    {
        $('#revertFromDcToCoModal').modal('show');
    });

    $(document).on('click','#revertFromDcToCoModalNo',function ()
    {
        $('#revertFromDcToCoModal').modal('hide');
    });

    $(document).on('click','#revertFromDcToCoModalYes',function ()
    {
        var remarks = $("#revertToCoRemarks").val();
        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
            };

            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationRevertFromDCToCO",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $('#revertFromDcToCoModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Successfully Reverted to CO");
                    }
                    else if (data.responseType == 9)
                    {
                        showErrorMessage("Application Already Send to SDLAC Committee!");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });



    // ****************************************************************
    // Rejected Application By DC
    $(document).on('click','#rejectByDc',function ()
    {
        $('#rejectedByDcModal').modal('show');
    });

    $(document).on('click','#rejectedByDcModalNo',function ()
    {
        $('#rejectedByDcModal').modal('hide');
    });

    $(document).on('click','#rejectedByDcModalYes',function ()
    {
        var remarks = $("#rejectedRemarks").val();
        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
            };

            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationRejectedByDc",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $('#rejectedByDcModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Successfully Rejected");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 9)
                    {
                        showErrorMessage("Application Already Send to SDLAC Committee!");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });


    // application order for NR
    $(document).on('click','#approveNR',function ()
    {
        $('#approveNrModal').modal('show');
    });

    $(document).on('click','#approveNrModalNo',function ()
    {
        $('#approveNrModal').modal('hide');
    });

    $(document).on('click','#approveNrModalYes',function ()
    {
        var remarks = $("#approveRemarksDcNr").val();
        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
            };
            $('#approveNrModal').modal('hide');
            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationApprovedByDcNr",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Forwarded To CO For NR case Settlement Process");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 10)
                    {
                        showErrorMessage("Total Area Recommended for Settlement can’t exceed available Area in Chitha !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)
            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });


    // NR order end
    // application Order for payment generate Dc
    $(document).on('click','#approveByDc',function ()
    {
        $('#approveByDcModal').modal('show');
    });

    $(document).on('click','#approveByDcModalNo',function ()
    {
        $('#approveByDcModal').modal('hide');
    });

    $(document).on('click','#approveByDcModalYes',function ()
    {
        var remarks = $("#approveRemarksDc").val();
        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
            };
            $('#approveByDcModal').modal('hide');
            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationApprovedByDcAp",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Forwarded To CO For Payment Generation  ");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 10)
                    {
                        showErrorMessage("Total Area Recommended for Settlement can’t exceed available Area in Chitha !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)
            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });



    //**********************************************************

    // forwarded to dept
    $(document).on('click','#forwardedToDept',function ()
    {
        $('#forwardedToDeptModal').modal('show');
    });


    $(document).on('click','#forwardedToDeptModalNo',function ()
    {
        $('#forwardedToDeptModal').modal('hide');
    });

    $(document).on('click','#forwardedToDeptModalYes',function ()
    {

        var remarks = $("#forwardRemarksDc").val();

        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
            };
            $('#forwardedToDeptModal').modal('hide');
            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationForwardedToDeptAp",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Successfully Forwarded to Dept.");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)
            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });





    // new Code Masud

    // ****************************************************************
    // marking fro SDLAC
    $(document).on('click','#markAsSDLAC',function ()
    {
        $('#markAsSDLACModal').modal('show');
    });

    $(document).on('click','#markAsSDLACModalNo',function ()
    {
        $('#markAsSDLACModal').modal('hide');
    });

    $(document).on('click','#markAsSDLACModalYes',function ()
    {

        const applicant = {
            caseNo: $("#caseNo").val(),
        };

        $.ajax({
            url: BASE_URL + "/SettlementApADC/markApplicationForSDLAC",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $('#markAsSDLACModal').modal('hide');
                if (data.responseType == 1)
                {
                    showErrorMessage("There is some problem, Please try again");
                }
                else if (data.responseType == 2)
                {
                    $('.rezaButt').hide();
                    showSuccessMessage("Application successfully Recommended For SDLAC/CDLAC");
                }
                else if (data.responseType == 3)
                {
                    showErrorMessage("Data not found !");
                }
                else if (data.responseType == 9)
                {
                    showErrorMessage("Application Already Send to SDLAC Committee!");
                }
                else if (data.responseType == 10)
                {
                    showErrorMessage("Total Area Recommended for Settlement can’t exceed available Area in Chitha !");
                }
                else if (data.responseType == 101)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });


    });



    // ****************************************************************
    // Remove From Marking List
    $(document).on('click','#unMarkAsSDLAC',function ()
    {
        $('#unMarkAsSDLACModal').modal('show');
    });

    $(document).on('click','#unMarkAsSDLACModalNo',function ()
    {
        $('#unMarkAsSDLACModal').modal('hide');
    });

    $(document).on('click','#unMarkAsSDLACModalYes',function ()
    {

        const applicant = {
            caseNo: $("#caseNo").val(),
        };

        $.ajax({
            url: BASE_URL + "/SettlementApADC/removeMarkApplicationForSDLAC",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $('#unMarkAsSDLACModal').modal('hide');
                if (data.responseType == 1)
                {
                    showErrorMessage("There is some problem, Please try again");
                }
                else if (data.responseType == 2)
                {
                    $('.rezaButt').hide();
                    showSuccessMessage("Application successfully removed from SDLAC Recommended List");
                }
                else if (data.responseType == 3)
                {
                    showErrorMessage("Data not found !");
                }
                else if (data.responseType == 9)
                {
                    showErrorMessage("Application Already Send to SDLAC Committee!");
                }
                else if (data.responseType == 101)
                {
                    showErrorMessage(data.message);
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });


    });



    // **************************************************************
    // Put Under Consideration
    $(document).on('click','#putUnderConsider',function ()
    {
        $('#putUnderConsiderModal').modal('show');
    });

    $(document).on('click','#putUnderConsiderModalNo',function ()
    {
        $('#putUnderConsiderModal').modal('hide');
    });

    $(document).on('click','#putUnderConsiderModalYes',function ()
    {
        var caseNo = $("#caseNo").val();
        var reason = $("#consideration_reason").val();
        var remark = $("#consideration_remark").val();

        if(reason == '')
        {
            showErrorMessage("Please select consideration reason !");
        }
        else if(reason == -1)
        {
            showErrorMessage("Please select consideration reason !");
        }
        else
        {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            const applicant = {
                caseNo: caseNo,
                reason: reason,
                remark: remark
            };

            $.ajax({
                url: BASE_URL + "/SettlementCommonDc/applicationPutUnderConsideration",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    $('#putUnderConsiderModal').modal('hide');

                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application successfully put under SDLAC Consideration");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }


    });




    // ****************************************************************
    // Approve Application By SDLAC
    $(document).on('click','#approveBySdlac',function ()
    {
        var caseNo = $("#caseNoHidden").val();
        var type = 1;

        if(caseNo != '')
        {
            const applicant = {
                caseNo: caseNo,
                type: type
            };
            $.ajax({
                url: BASE_URL + "/SettlementCommonDc/getMinutesApprovedRejectedBySdlac",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data)
                {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('#minutesDetails').html(data.minutes);
                        $('#approveRemarksSDLAC').val(data.minutes);
                        $('#minutesProposalId').val(data.minutesProId);
                        $('#approveBySdlacModal').modal('show');
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                },
                data: JSON.stringify(applicant)
            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }

    });

    $(document).on('click','#approveBySdlacModalNo',function ()
    {
        $('#approveBySdlacModal').modal('hide');
    });

    $(document).on('click','#approveBySdlacModalYes',function ()
    {
        var remarks = $("#approveRemarksSDLAC").val();
        var proposalId = $("#minutesProposalId").val();

        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
                proposalId: proposalId

            };
            $('#approveBySdlacModal').modal('hide');


            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationApprovedBySdlac",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {

                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Forwarded To CO For Payment Generation  ");

                    }
                    else if (data.responseType == 5)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Approved & Forwarded To Department  ");

                    }
                    else if (data.responseType == 10)
                    {
                        showErrorMessage("Total Area Recommended for Settlement can’t exceed available Area in Chitha !");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });



    // ****************************************************************
    // Rejected Application By SDLAC
    $(document).on('click','#rejectBySdlac',function ()
    {
        var caseNo = $("#caseNoHidden").val();
        var type = 2;


        if(caseNo != '')
        {
            const applicant = {
                caseNo: caseNo,
                type: type
            };
            $.ajax({
                url: BASE_URL + "/SettlementCommonDc/getMinutesApprovedRejectedBySdlac",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data)
                {
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('#minutesDetailsRejected').html(data.minutes);
                        $('#rejectedRemarksSDLAC').val(data.minutes);
                        $('#minutesProposalIdRejected').val(data.minutesProId);
                        $('#rejectedBySdlacModal').modal('show');
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                },
                data: JSON.stringify(applicant)
            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }


    });

    $(document).on('click','#rejectedBySdlacModalNo',function ()
    {
        $('#rejectedBySdlacModal').modal('hide');
    });

    $(document).on('click','#rejectedBySdlacModalYes',function ()
    {
        var remarks = $("#rejectedRemarksSDLAC").val();
        var proposalId = $("#minutesProposalIdRejected").val();


        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
                proposalId: proposalId
            };

            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationRejectedBySdlac",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $('#rejectedBySdlacModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Successfully Rejected");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });





    // new *************************************************

    // Revert Application From SDLAC TO CO
    $(document).on('click','#revertFromSDLACToCo',function ()
    {
        $('#revertFromSDLACToCoModal').modal('show');
    });

    $(document).on('click','#revertFromSDLACToCoModalNo',function ()
    {
        $('#revertFromSDLACToCoModal').modal('hide');
    });

    $(document).on('click','#revertFromSDLACToCoModalYes',function ()
    {
        var remarks = $("#revertSdlacToCoRemarks").val();
        var status  = $("#sdlacApproveStatus").val();
        if(remarks != '' && status != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
                status: status
            };

            $.ajax({
                url: BASE_URL + "/SettlementApADC/applicationRevertFromSDLACToCOAp",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $('#revertFromSDLACToCoModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('.rezaButt').hide();
                        showSuccessMessage("Application Successfully Reverted to CO");
                    }
                    else if (data.responseType == 9)
                    {
                        showErrorMessage("Application Already Send to SDLAC Committee!");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 101)
                    {
                        showErrorMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            showErrorMessage("Please Enter Some Remarks !");
        }
    });



</script>



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

    .badge-reza1{
        background-color: #F44336;
    }
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #03A9F4;
    }
    .badge-reza4{
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
                            <a
                                    href="#step3"
                                    data-toggle="tab"
                                    aria-controls="step3"
                                    role="tab"
                                    title="Step 3"
                            >
                     <span class="round-tab">
                     <strong>Applications</strong>
                     </span>
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="tab-pane" role="tabpanel" id="history">
                    <br>
                    <h5 class="bg-info p-2 text-white shadow">
                        Total Case Received for this Dag
                    </h5>
                    <div class="row" style="padding: 12px">
                        <div class="reza-card ">
                            <div class="reza-body">
                                <?php
                                $bigha = 0;
                                $katha = 0;
                                $lessa = 0;
                                $ganda = 0;
                                $bighaAgr = 0;
                                $kathaAgr = 0;
                                $lessaAgr = 0;
                                $gandaAgr = 0;
                                ?>

                                <div class="timeline">

                                    <?php $count=0; foreach($applications as $pro): ?>

                                        <?php
                                        $bigha += $this->UtilsModel->defaultValue($pro->mbigha, 0);
                                        $katha += $this->UtilsModel->defaultValue($pro->mkatha, 0);
                                        $lessa += $this->UtilsModel->defaultValue($pro->mlessa, 0);
                                        $ganda += $this->UtilsModel->defaultValue($pro->mganda, 0);
                                        $bighaAgr += $this->UtilsModel->defaultValue($pro->agri_bigha, 0);
                                        $kathaAgr += $this->UtilsModel->defaultValue($pro->agri_katha, 0);
                                        $lessaAgr += $this->UtilsModel->defaultValue($pro->agri_lessa, 0);
                                        $gandaAgr += $this->UtilsModel->defaultValue($pro->agri_ganda, 0);
                                        ?>

                                        <?php if($count % 2==0) {?>
                                            <div class="timeline__content" style="background-color: #6472ff">
                                                <span class="content_tag" style="margin-top: 15px; background-color: white; color: #4CAF50">
                                                    <a href="<?php echo base_url()?>index.php/SettlementCommon/viewBasundharaApplication?app=<?=$pro->application_no;?>" target="_blank">Application</a>
                                                </span>
                                                <span class="content_date" style="color: white; margin-top: 7px">
                                                    <?=$pro->application_no;?>
                                                    <br>(B-<?=$pro->mbigha;?>,K-<?=$pro->mkatha;?>,L-<?=$pro->mlessa;?>)
                                                    <?php if($service_code !='13' && $service_code !='14') {?>
                                                        Agri (B-<?=$pro->agri_bigha;?>,K-<?=$pro->agri_katha;?>,L-<?=$pro->agri_lessa;?>)
                                                    <?php } ?>
                                                </span>
                                            </div>
                                        <?php } else {?>
                                            <div class="timeline__content" style="background-color: #09aa99">
                                                <span class="content_tag" style="margin-top: 15px; background-color: white; color: #4CAF50">
                                                    <a href="<?php echo base_url()?>index.php/SettlementCommon/viewBasundharaApplication?app=<?=$pro->application_no;?>" target="_blank">Application</a>
                                                </span>
                                                <span class="content_date" style="color: white; margin-top: 7px">
                                                    <?= $pro->application_no;?>
                                                    <br>(B-<?=$pro->mbigha;?>,K-<?=$pro->mkatha;?>,L-<?=$pro->mlessa;?>)
                                                    <?php if($service_code!='13' && $service_code!='14') {?>
                                                        Agri (B-<?=$pro->agri_bigha;?>,K-<?=$pro->agri_katha;?>,L-<?=$pro->agri_lessa;?>)
                                                    <?php } ?>
                                                </span>
                                            </div>
                                        <?php }?>

                                        <?php $count++; endforeach; ?>

                                </div>

                                <h5 class="reza-title center"><span>Total  <?=$count?> Applications Received in  District-<?=$this->utilityclass->getDistrictName($pro->dist_code)?>, Subdivision-<?=$this->utilityclass->getSubDivName($pro->dist_code,$pro->subdiv_code)?>, Village-<?=$this->utilityclass->getVillageName($pro->dist_code,$pro->subdiv_code,$pro->cir_code,$pro->mouza_code,$pro->lot_no,$pro->vill_code)?>, Dag No- <?=$pro->dag_no?> :</span>  </h5>
                            </div>
                        </div>
                    </div>

                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-map" aria-hidden="true"></i> Area Details
                    </h5>

                    <?php
                    $totalLessa = $this->utilityclass->Total_Lessa($bigha,$katha,$lessa);
                    $totalGanda = $this->utilityclass->Total_ganda($bigha,$katha,$lessa,$ganda);
                    $totalLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessa);
                    $totalLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalGanda);

                    $totalLessaAgr = $this->utilityclass->Total_Lessa($bighaAgr,$kathaAgr,$lessaAgr);
                    $totalGandaAgr = $this->utilityclass->Total_ganda($bighaAgr,$kathaAgr,$lessaAgr,$gandaAgr);
                    $totalLessaInBKLAgr  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessaAgr);
                    $totalLessaInBKCGAgr = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalGandaAgr);

                    $totalChithaAreaInLessa = $this->utilityclass->Total_Lessa($chithaArea->dag_area_b,$chithaArea->dag_area_k,$chithaArea->dag_area_lc);
                    $totalChithaAreaInGanda = $this->utilityclass->Total_ganda($chithaArea->dag_area_b,$chithaArea->dag_area_k,$chithaArea->dag_area_lc,$chithaArea->dag_area_g);

                    $remainingLessa = $totalChithaAreaInLessa - ($totalLessa + $totalLessaAgr);
                    $remainingGanda = $totalChithaAreaInLessa - ($totalGanda + $totalGandaAgr);

                    $remainingLessaInBKL = $this->utilityclass->Total_Bigha_Katha_Lessa($remainingLessa);
                    $remainingLessaInBKCG= $this->utilityclass->Total_Bigha_Katha_Lessa2($remainingGanda);

                    ?>

                    <div class="tableCard">
                        <div class="tree" >

                            <ul style="margin-bottom: 50px">
                                <li >
                                    <span>
                                        <i class="fa fa-map"></i>
                                        Dag Number
                                        <b><?php echo $chithaArea->dag_no ?></b>
                                        , Patta Number
                                        <b><?php echo $chithaArea->patta_no ?></b>
                                    </span>
                                    <ul style="padding-bottom: 20px!important;">
                                        <li style="padding-top: 20px; padding-bottom: 10px">
                                            <span class="badge badge-reza1" style="padding: 5px; font-size: 14px;">
                                                <i class="fa fa-map-marker"></i>
                                                &nbsp; Total Area Details Chitha
                                            </span>
                                            <ul>
                                                <li>
                                                    <span class="rezaSpan">
                                                        Bigha &nbsp;
                                                        <b><?php echo $chithaArea->dag_area_b ?></b>
                                                    </span>
                                                    <span class="rezaSpan">
                                                        Katha &nbsp;
                                                        <b><?php echo $chithaArea->dag_area_k ?></b>
                                                    </span>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <span class="rezaSpan">
                                                            Chatak &nbsp;
                                                            <b><?php echo $chithaArea->dag_area_lc ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Ganda &nbsp;
                                                            <b><?php echo $chithaArea->dag_area_g ?></b>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="rezaSpan">
                                                            Lessa &nbsp;
                                                            <b><?php echo $chithaArea->dag_area_lc ?></b>
                                                        </span>
                                                    <?php endif; ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li style="padding-top: 20px; padding-bottom: 10px">
                                            <span class="badge badge-reza3" style="padding: 5px; font-size: 14px;">
                                                <i class="fa fa-home"></i>
                                                &nbsp; Total Applied Area (Homestead)
                                            </span>
                                            <ul>
                                                <li>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <span class="rezaSpan">
                                                            Bigha &nbsp;
                                                            <b><?php echo $totalLessaInBKCG[0] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Katha &nbsp;
                                                            <b><?php echo $totalLessaInBKCG[1] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Chatak &nbsp;
                                                            <b><?php echo round($totalLessaInBKCG[2],5)  ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Ganda &nbsp;
                                                            <b><?php echo round($totalLessaInBKCG[3],5) ?></b>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="rezaSpan">
                                                            Bigha &nbsp;
                                                            <b><?php echo $totalLessaInBKL[0] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Katha &nbsp;
                                                            <b><?php echo $totalLessaInBKL[1] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Lessa &nbsp;
                                                            <b><?php echo round($totalLessaInBKL[2],5)  ?></b>
                                                        </span>
                                                    <?php endif; ?>
                                                </li>
                                            </ul>
                                        </li>


                                        <li style="padding-top: 20px; padding-bottom: 10px">
                                            <span class="badge badge-reza4" style="padding: 5px; font-size: 14px;">
                                                <i class="fa fa-tree"></i>
                                                &nbsp; Total Applied Area (Agricultural)
                                            </span>
                                            <ul>
                                                <li>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <span class="rezaSpan">
                                                            Bigha &nbsp;
                                                            <b><?php echo $totalLessaInBKCGAgr[0] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Katha &nbsp;
                                                            <b><?php echo $totalLessaInBKCGAgr[1] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Chatak &nbsp;
                                                            <b><?php echo round($totalLessaInBKCGAgr[2],5)  ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Ganda &nbsp;
                                                            <b><?php echo round($totalLessaInBKCGAgr[3],5) ?></b>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="rezaSpan">
                                                            Bigha &nbsp;
                                                            <b><?php echo $totalLessaInBKLAgr[0] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Katha &nbsp;
                                                            <b><?php echo $totalLessaInBKLAgr[1] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Lessa &nbsp;
                                                            <b><?php echo round($totalLessaInBKLAgr[2],5)  ?></b>
                                                        </span>
                                                    <?php endif; ?>
                                                </li>
                                            </ul>
                                        </li>

                                        <li style="padding-top: 20px; padding-bottom: 10px">
                                            <span class="badge badge-reza2" style="padding: 5px; font-size: 14px;">
                                                <i class="fa fa-map-o"></i>
                                                &nbsp; Total Remaining Area Details
                                            </span>
                                            <ul>
                                                <li>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <span class="rezaSpan">
                                                            Bigha &nbsp;
                                                            <b><?php echo $remainingLessaInBKCG[0] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Katha &nbsp;
                                                            <b><?php echo $remainingLessaInBKCG[1] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Chatak &nbsp;
                                                            <b><?php echo round($remainingLessaInBKCG[2],5)  ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Ganda &nbsp;
                                                            <b><?php echo round($remainingLessaInBKCG[3],5) ?></b>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="rezaSpan">
                                                            Bigha &nbsp;
                                                            <b><?php echo $remainingLessaInBKL[0] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Katha &nbsp;
                                                            <b><?php echo $remainingLessaInBKL[1] ?></b>
                                                        </span>
                                                        <span class="rezaSpan">
                                                            Lessa &nbsp;
                                                            <b><?php echo round($remainingLessaInBKL[2],5)  ?></b>
                                                        </span>
                                                    <?php endif; ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>


                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>
<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
<script>
    function roadSideReservYes() {
        var x = document.getElementById("road_side_reservation_hide");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
    }
    //  else {
    //   x.style.display = "none";
    // }
    function roadSideReservNo() {
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
        window.nodirkakhorlessa = parseInt(nodir_kaijo_b) * 100 + parseInt(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
        console.log(window.nodirkakhorlessa);
        var mbigha = $('.s_dag_area_b').val();
        var mkatha = $('.s_dag_area_k').val();
        var mlessa = $('.s_dag_area_lc').val();
        //window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseFloat(mlessa);
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


</script>

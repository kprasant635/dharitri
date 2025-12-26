<!-- <style>
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
        color: #37474F;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    .reza-body{
        padding-top: 25px;
        padding-left: 10px;
        padding-right: 10px;
        padding-bottom: 10px;
    }

</style> -->


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

        <?php $userDegCode =  $this->session->userdata('user_desig_code'); ?>
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
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
                        Total Case Received for Dag No <?=$dag_no ?> (<?php echo $this->utilityclass->getDistrictName($dist_code) ?>
                        /
                        <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code, $cir_code); ?>
                        /
                        <?php echo $this->utilityclass->getVillageName
                        ($dist_code,$subdiv_code,$cir_code,$mouza_code,$lot_no, $vill_code) ?>)
                    </h5>
                    <div class="row" style="padding: 12px">
                        <div class="reza-card ">
                            <div class="reza-body">

                                <table class="table table-bordered border-primary">
                                    <tr>
                                        <th rowspan="2" class="text-center" style=" vertical-align: middle">Application Number</th>
                                        <th rowspan="2" style=" vertical-align: middle" class="text-center">Action</th>

                                        <th colspan="2" class="text-center">Applied Area</th>
                                        <th colspan="2" class="text-center">Modified/Corrected Area by LRA</th>
                                    </tr>

                                    <tr>
                                        <td align="center">Homestead</td>
                                        <td align="center">Agriculture</td>
                                        <td align="center">Homestead</td>
                                        <td align="center">Agriculture</td>
                                    </tr>

                                    <?php
                                    $appliedB = 0;
                                    $appliedK = 0;
                                    $appliedL = 0;
                                    $appliedG = 0;
                                    $appliedAgB = 0;
                                    $appliedAgK = 0;
                                    $appliedAgL = 0;
                                    $appliedAgG = 0;
                                    $totalGanda = 0;
                                    $totalLessa = 0;
                                    $totalAgGanda = 0;
                                    $totalAgLessa = 0;

                                    $lmAreaB = 0;
                                    $lmAreaK = 0;
                                    $lmAreaL = 0;
                                    $lmAreaG = 0;
                                    $lmAreaAgB = 0;
                                    $lmAreaAgK = 0;
                                    $lmAreaAgL = 0;
                                    $lmAreaAgG = 0;
                                    $totalLmGanda = 0;
                                    $totalLmLessa = 0;
                                    $totalLmAgGanda = 0;
                                    $totalLmAgLessa = 0;

                                    $bigha = 0;
                                    $katha = 0;
                                    $lessa = 0;
                                    $ganda = 0;
                                    $bighaAgr = 0;
                                    $kathaAgr = 0;
                                    $lessaAgr = 0;
                                    $gandaAgr = 0;

                                    ?>

                                    <?php $count=0; foreach ($applications as $applied_dag) { ?>


                                        <?php
                                        $bigha += $this->NcCommonModel->defaultValue($applied_dag->mbigha, 0);
                                        $katha += $this->NcCommonModel->defaultValue($applied_dag->mkatha, 0);
                                        $lessa += $this->NcCommonModel->defaultValue($applied_dag->mlessa, 0);
                                        $ganda += $this->NcCommonModel->defaultValue($applied_dag->mganda, 0);
                                        $bighaAgr += $this->NcCommonModel->defaultValue($applied_dag->agri_bigha, 0);
                                        $kathaAgr += $this->NcCommonModel->defaultValue($applied_dag->agri_katha, 0);
                                        $lessaAgr += $this->NcCommonModel->defaultValue($applied_dag->agri_lessa, 0);
                                        $gandaAgr += $this->NcCommonModel->defaultValue($applied_dag->agri_ganda, 0);
                                        ?>

                                        <?php $myArea = $this->utilityclass->getLmReportedAreaByDistCodeAppNo($applied_dag->dist_code,$applied_dag->application_no, $applied_dag->dag_no); ?>

                                        <tr>
                                            <td>
                                                <a style="text-decoration: none; color: #0a53be; font-weight:400" data-toggle="tooltip" data-placement="top" title="View application details"  href="<?php echo base_url()?>index.php/NcCommonController/viewBasundharaApplication?app=<?=$applied_dag->application_no?>" target="_blank">
                                                    <?=$applied_dag->application_no ?>
                                                    <br>
                                                    <span style="color: #F44336; font-size: 12px">
                                                        <?php echo $this->utilityclass->getCaseNoByApplId($applied_dag->dist_code,$applied_dag->application_no); ?>
                                                    </span>
                                                </a>
                                            </td>

                                            <?php




                                            // $tenant_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementTenant/settlementTenantRegistration?app=' . $this->utilityclass->encryptJwtcase($applied_dag->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';
                                            // $tribal_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/NcTribal/TribalApplicationRegistration?app=' . $this->utilityclass->encryptJwtcase($applied_dag->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';
                                            // $ap_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementAp/settlementApplication?app=' . $this->utilityclass->encryptJwtcase($applied_dag->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';
                                            // $khas_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/NcKhasland/applicationKhaslandRegistration?app=' . $this->utilityclass->encryptJwtcase($applied_dag->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';
                                            // $vgr_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/SettlementVgr/applicationVgrRegistration?app=' . $this->utilityclass->encryptJwtcase($applied_dag->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';
                                            // $tea_link = '<a type="button" target="_blank" href="' . base_url() . 'index.php/NcCultivator/settlementApplication?app=' . $this->utilityclass->encryptJwtcase($applied_dag->application_no) . '" class="lmreportmut btn-sm btn btn-primary">write report</a>';


                                            ?>


                                            <td class="text-center">
                                                <?php if($userDegCode == 'LM'): ?>

                                                    <?php
                                                    if (strpos($applied_dag->application_no, 'SKCSL') !== false)
                                                    {
                                                        echo $khas_link;
                                                    }
                                                    // else if (strpos($applied_dag->application_no, 'SAPH') !== false)
                                                    // {
                                                    //     echo $ap_link;
                                                    // }
                                                    // else if (strpos($applied_dag->application_no, 'SPVL') !== false)
                                                    // {
                                                    //     echo $vgr_link;
                                                    // }
                                                    else if (strpos($applied_dag->application_no, 'SOSC') !== false)
                                                    {
                                                        echo $tea_link;
                                                    }
                                                    else if (strpos($applied_dag->application_no, 'SHLTC') !== false)
                                                    {
                                                        echo $tribal_link;
                                                    }
                                                    // else if (strpos($applied_dag->application_no, 'SOT') !== false)
                                                    // {
                                                    //     echo $tenant_link;
                                                    // }
                                                    ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($applied_dag->mbigha)): ?>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <?php $appliedB += $applied_dag->mbigha; echo $applied_dag->mbigha ?> -
                                                        <?php $appliedK += $applied_dag->mkatha; echo $applied_dag->mkatha ?> -
                                                        <?php $appliedL += $applied_dag->mlessa; echo $applied_dag->mlessa ?> -
                                                        <?php $appliedG += $applied_dag->mganda; echo $applied_dag->mganda ?>
                                                    <?php else: ?>
                                                        <?php $appliedB += $applied_dag->mbigha; echo $applied_dag->mbigha ?> -
                                                        <?php $appliedK += $applied_dag->mkatha; echo $applied_dag->mkatha ?> -
                                                        <?php $appliedL += $applied_dag->mlessa; echo $applied_dag->mlessa ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    NA
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(isset($applied_dag->agri_bigha)): ?>
                                                    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                        <?php $appliedAgB += $applied_dag->agri_bigha; echo $applied_dag->agri_bigha ?> -
                                                        <?php $appliedAgK += $applied_dag->agri_katha; echo $applied_dag->agri_katha ?> -
                                                        <?php $appliedAgL += $applied_dag->agri_lessa; echo $applied_dag->agri_lessa ?> -
                                                        <?php $appliedAgG += $applied_dag->agri_ganda; echo $applied_dag->agri_ganda ?>
                                                    <?php else: ?>
                                                        <?php $appliedAgB += $applied_dag->agri_bigha; echo $applied_dag->agri_bigha ?> -
                                                        <?php $appliedAgK += $applied_dag->agri_katha; echo $applied_dag->agri_katha ?> -
                                                        <?php $appliedAgL += $applied_dag->agri_lessa; echo $applied_dag->agri_lessa ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    NA
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($myArea =='NA') : ?>
                                                    NA
                                                <?php else: ?>
                                                    <?php foreach ($myArea as $singleArea): ?>
                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <?php $lmAreaB += $singleArea->home_b;  echo $singleArea->home_b ?> -
                                                            <?php $lmAreaK += $singleArea->home_k;  echo $singleArea->home_k ?> -
                                                            <?php $lmAreaL += $singleArea->home_lc; echo $singleArea->home_lc ?> -
                                                            <?php $lmAreaG += $singleArea->home_g;  echo $singleArea->home_g ?>
                                                        <?php else: ?>
                                                            <?php $lmAreaB += $singleArea->home_b;  echo $singleArea->home_b ?> -
                                                            <?php $lmAreaK += $singleArea->home_k;  echo $singleArea->home_k ?> -
                                                            <?php $lmAreaL += $singleArea->home_lc; echo $singleArea->home_lc ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($myArea =='NA') : ?>
                                                    NA
                                                <?php else: ?>
                                                    <?php foreach ($myArea as $singleArea): ?>
                                                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                            <?php $lmAreaAgB += $singleArea->agri_b;  echo $singleArea->agri_b ?> -
                                                            <?php $lmAreaAgK += $singleArea->agri_k;  echo $singleArea->agri_k ?> -
                                                            <?php $lmAreaAgL += $singleArea->agri_lc; echo $singleArea->agri_lc ?> -
                                                            <?php $lmAreaAgG += $singleArea->agri_g;  echo $singleArea->agri_g ?>
                                                        <?php else: ?>
                                                            <?php $lmAreaAgB += $singleArea->agri_b;  echo $singleArea->agri_b ?> -
                                                            <?php $lmAreaAgK += $singleArea->agri_k;  echo $singleArea->agri_k ?> -
                                                            <?php $lmAreaAgL += $singleArea->agri_lc; echo $singleArea->agri_lc ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>



                                        <?php $count++; } ?>

                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr style="background-color: #EF9A9A; font-weight: bold">
                                        <td colspan="2" align="center">Total Applied Area Details</td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalGanda = $this->utilityclass->Total_ganda($appliedB,$appliedK,$appliedL,$appliedG); ?>
                                                <?php $totalLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalGanda); ?>
                                                <?= $totalLessaInBKCG[0] ?> -
                                                <?= $totalLessaInBKCG[1] ?> -
                                                <?= $totalLessaInBKCG[2] ?> -
                                                <?= $totalLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalLessa = $this->utilityclass->Total_Lessa($appliedB,$appliedK,$appliedL); ?>
                                                <?php $totalLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLessa); ?>
                                                <?= $totalLessaInBKL[0] ?> -
                                                <?= $totalLessaInBKL[1] ?> -
                                                <?= $totalLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalAgGanda = $this->utilityclass->Total_ganda($appliedAgB,$appliedAgK,$appliedAgL,$appliedAgG); ?>
                                                <?php $totalAgLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalAgGanda); ?>
                                                <?= $totalAgLessaInBKCG[0] ?> -
                                                <?= $totalAgLessaInBKCG[1] ?> -
                                                <?= $totalAgLessaInBKCG[2] ?> -
                                                <?= $totalAgLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalAgLessa = $this->utilityclass->Total_Lessa($appliedAgB,$appliedAgK,$appliedAgL); ?>
                                                <?php $totalAglLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalAgLessa); ?>
                                                <?= $totalAglLessaInBKL[0] ?> -
                                                <?= $totalAglLessaInBKL[1] ?> -
                                                <?= $totalAglLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalLmGanda = $this->utilityclass->Total_ganda($lmAreaB,$lmAreaK,$lmAreaL,$lmAreaG); ?>
                                                <?php $totalLmLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLmGanda); ?>
                                                <?= $totalLmLessaInBKCG[0] ?> -
                                                <?= $totalLmLessaInBKCG[1] ?> -
                                                <?= $totalLmLessaInBKCG[2] ?> -
                                                <?= $totalLmLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalLmLessa = $this->utilityclass->Total_Lessa($lmAreaB,$lmAreaK,$lmAreaL); ?>
                                                <?php $totalLmlLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLmLessa); ?>
                                                <?= $totalLmlLessaInBKL[0] ?> -
                                                <?= $totalLmlLessaInBKL[1] ?> -
                                                <?= $totalLmlLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                <?php $totalLmAgGanda = $this->utilityclass->Total_ganda($lmAreaAgB,$lmAreaAgK,$lmAreaAgL,$lmAreaAgG); ?>
                                                <?php $totalLmAgLessaInBKCG = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalLmAgGanda); ?>
                                                <?= $totalLmAgLessaInBKCG[0] ?> -
                                                <?= $totalLmAgLessaInBKCG[1] ?> -
                                                <?= $totalLmAgLessaInBKCG[2] ?> -
                                                <?= $totalLmAgLessaInBKCG[3] ?>
                                            <?php else: ?>
                                                <?php $totalLmAgLessa = $this->utilityclass->Total_Lessa($lmAreaAgB,$lmAreaAgK,$lmAreaAgL); ?>
                                                <?php $totalLmlAgLessaInBKL  = $this->utilityclass->Total_Bigha_Katha_Lessa($totalLmAgLessa); ?>
                                                <?= $totalLmlAgLessaInBKL[0] ?> -
                                                <?= $totalLmlAgLessaInBKL[1] ?> -
                                                <?= $totalLmlAgLessaInBKL[2] ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #CFD8DC; font-weight: bold">
                                        <td colspan="2" align="center">Total Chitha Area</td>
                                        <td>
                                            <b><?php echo $chithaArea->dag_area_b ?></b>
                                            - <b><?php echo $chithaArea->dag_area_k ?></b>
                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                - <b><?php echo $chithaArea->dag_area_lc ?></b>
                                                - <b><?php echo $chithaArea->dag_area_g ?></b>
                                            <?php else: ?>
                                                - <b><?php echo $chithaArea->dag_area_lc ?></b>
                                            <?php endif; ?>

                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>

                                    <tr>
                                        <td colspan="6">
                                            <h5 class="reza-title center"><span>Total  <?=$count?> Applications Received in  District-<?=$this->utilityclass->getDistrictName($applied_dag->dist_code)?>, Subdivision-<?=$this->utilityclass->getSubDivName($applied_dag->dist_code,$applied_dag->subdiv_code)?>, Village-<?=$this->utilityclass->getVillageName($applied_dag->dist_code,$applied_dag->subdiv_code,$applied_dag->cir_code,$applied_dag->mouza_code,$applied_dag->lot_no,$applied_dag->vill_code)?>, Dag No- <?=$applied_dag->dag_no?> :</span>  </h5>
                                        </td>
                                    </tr>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

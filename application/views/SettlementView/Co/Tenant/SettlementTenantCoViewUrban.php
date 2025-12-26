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
    .badge-reza2{
        background-color: #2E7D32;
    }
    .badge-reza3{
        background-color: #9C27B0;
    }


</style>

<script>
    $(document).ready(function () {
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


<div class="container">
    <div class="row">
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                        <li role="presentation" class="active">
                            <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1" >
                                <span class="round-tab">
                                  <strong>Application</strong>
                                </span>
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                <span class="round-tab">
                                  <strong>LRA</strong>
                                </span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                <span class="round-tab">
                                  <strong>   
                                    <?php
                                    if($user_desig_code == 'SK')
                                    {
                                        echo "SK";
                                    }
                                    else
                                    {
                                        echo "Circle Officer";
                                    }
                                    ?>
                                    </strong>
                                </span>
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="step 4">
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
                // include(APPPATH."views/SettlementView/include/applicationTenantLmView.php");
                include(APPPATH."views/SettlementView/include/applicationTenantLmViewUrban.php");
                ?>

                <div class="tab-pane" role="tabpanel" id="step3">
                    <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$_GET['case']?></span> )
                    </h5>
                    <div class="reza-card">
                        <div class="reza-body">
                            <?php if ($this->session->flashdata('message')):  ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong><?php echo $this->session->flashdata('message');?></strong>
                                </div>
                            <?php endif; ?>

                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Previous Remark
                            </h5>
                            <?php if($proceedings){ ?>
                                <div class="tableCard ">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Date</th>
                                            <th>From</th>
                                            <th>Note</th>
                                        </tr>
                                        <?php
                                        $i=1;
                                        foreach($proceedings as $pro):
                                            if ($i== 1){
                                                ?>
                                                <tr>
                                                    <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                                    <td><?=$pro->office_from;?></td>
                                                    <td><span><?=$pro->note_on_order;?></span></td>
                                                </tr>
                                            <?php } $i++; endforeach;?>
                                    </table>
                                </div>
                            <?php } ?>


                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-map" aria-hidden="true"></i> Area Details Dag Wise
                            </h5>
                            <div class="tableCard">
                                <div class="tree" >

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




                                                    <li style="padding-top: 10px; padding-bottom: 15px">
                                                        <span class="badge badge-reza3" style="padding: 5px; font-size: 14px">
                                                            <i class="fa fa-edit"></i>
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
                                </div>
                            </div>

                            <?php if($areaCheck == 1): ?>
                                <h5 style="color: red; font-weight: bold; padding-top: 15px; padding-bottom: 15px; text-align: center" >
                                    Total Area Recommended for Settlement can’t exceed available Area in Chitha !
                                </h5>
                                <br>
                            <?php endif; ?>


                            <?php
                            if($user_desig_code == 'SK')
                            {
                                ?>
                                <h5  class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> SK Report
                                </h5>
                                <?php
                                $pending_officer = $basic["pending_officer"];
                                $from_office = $basic["from_office"];
                                ?>
                                <div class="tableCard" style="padding-bottom: 15px">

                                    <form method="post" action="<?php echo base_url()?>index.php/SettlementTenantCoUrban/generateNoticeCo" name="sk_form_sub">

                                        <div class="mt-4 row px-5 justify-content-center">
                                            <div class="col-md-9">
                                                <label for="inputEmail4">Select remark type</label>

                                                <select name="remark_co_type" id="remark_co" class="form-control" required>
                                                    <option value="">Select remarks...</option>
                                                    <option value="Can be Recommended">Can be Recommended</option>
                                                    <option value="Can not be Recommended">Can not be Recommended</option>

                                                </select> <br>
                                                <textarea placeholder="Remarks  ..." name="remark_co_note" id="remark_co_text_sk" class="form-control" cols="30" rows="3"></textarea>
                                                <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
                                                <br>

                                                <?php
                                                if($basic_status == 'W'){
                                                    ?>
                                                    <select class="form-control <?php if(form_error('co_code')) {
                                                        echo 'lm_invalid';
                                                    }?>" name='co_code' required>
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
                                                <?php }?>

                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-center">

                                            <?php
                                            if($pending_officer == 'SK' && $from_office == 'LM'){
                                                ?>
                                                <button
                                                        type="submit"
                                                        name="sk_forward_co"
                                                        class="m-1 col-2 btn btn-primary btn-sm"
                                                        id="sk_forward_co" onclick="return skForward()">
                                                    Forward to CO
                                                </button>
                                            <?php }elseif($pending_officer == 'CO' && $from_office == 'SK'){?>

                                                <div class="alert alert-danger alert-dismissible text-center" role="alert">
                                                    <strong>Case forwarded to CO...</strong>
                                                </div>

                                            <?php }?>
                                        </div>

                                    </form>
                                </div>

                                <?php
                            }
                            else
                            { ?>
                                <h5 class="reza-title" style="margin-top: 50px">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> CO Report
                                </h5>

                                <div class="tableCard ">

                                    <?php
                                    $pending_officer = $basic["pending_officer"];
                                    $from_office = $basic["from_office"];

                                    ?>



                                    <?php
                                    if($applicants_riotee_nok == true){
                                        ?>
                                        <h5>
                                            <i class="fa fa-star text-danger" aria-hidden="true"></i>
                                            <span class="alert-danger">
                                                New Riotee's NOK would be added to the Khatian
                                            </span>
                                        </h5>

                                        <?php
                                    }
                                    ?>
                                    <br>

                                    <form method="post" id="co_form_sub" name="co_form_sub" action="<?php echo base_url()?>index.php/SettlementTenantCoUrban/generateNoticeCo">

                                        <input type="hidden" id="case_no" name="case_no" value="<?=$_GET['case']?>">

                                        <?php
                                        if($validation_bypass == 1)
                                        {
                                            ?>

                                            <div class="row justify-content-center mb-5">
                                                <div class="col-md-8">
                                                    <label for="" class="text-danger">

                                                        <h5><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                            <?php
                                                            if($basic["status"] != MB_DISMISS)
                                                            {
                                                                ?>
                                                                &nbsp;LM has rejected this case by selected rejection reasons which can be seen in the LM Report section. Do you aggree with LM and allow rejection for this case?

                                                            <?php }

                                                            if($basic["status"] == MB_DISMISS)
                                                            {?>

                                                                &nbsp;This case has been successfully rejected...
                                                            <?php }?>
                                                        </h5>
                                                    </label>
                                                    <br>
                                                    <br>

                                                    <?php
                                                    if($basic["status"] != MB_DISMISS)
                                                    {
                                                        ?>
                                                        <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="btn btn-danger btn-sm" name="">Agree with Rejection</button>
                                                        <input type="hidden" id="co_rejection_agree" name="co_rejection_agree" value="">
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php if (($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')) {?>
                                                        <button onclick="return revertSubAlert()" id="disagreeWithLm" type="button" class="btn btn-warning btn-sm" name="">Disagree and Revert to LM</button>
                                                        <input type="hidden" id="co_rejection_disagree" name="co_rejection_disagree" value="">

                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                        }
                                        // else
                                        // {
                                        ?>
                                        <div class="mt-4 row px-5 justify-content-center">

                                            <div class="col-md-9">


                                                <label for="inputEmail4">Select remark type</label>


                                                <select name="remark_co_type" id="remark_co" onchange="autoRemark();" class="form-control">
                                                    <?php
                                                    foreach(json_decode(CO_NOTE) as $co_remark_cat){
                                                        if($validation_bypass == 1)
                                                        {
                                                            if($co_remark_cat->CODE == 1)
                                                            {
                                                                continue;
                                                            }
                                                        }
                                                        ?>
                                                        <option value="<?=$co_remark_cat->CODE?>"><?=$co_remark_cat->NAME?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <br>
                                                <textarea placeholder="Remarks  ..." name="remark_co_text" id="remark_co_text" class="form-control p-2" cols="30" rows="12"></textarea>
                                                <input type="hidden" id="case_no" name="case_no" value="<?=$_GET['case']?>">


                                            </div>
                                        </div>
                                        <div class="row mt-4 justify-content-center">

                                            <?php

                                            if(ENABLE_ADDITIONAL_PROPERTY_BUTTON == 1 && isset($checkAdditionalProperty)){
                                                echo ADDITIONAL_PROPERTY_BUTTON;
                                                include(APPPATH."views/SettlementView/include/additionalProperty.php");
                                            }
                                            ?>

                                            <?php if(($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')){ ?>
                                                <button type="submit" name="revert_to_lm" onclick="return lm_Revert()" id="lm_revert_btn" class="m-1 col-2 btn btn-danger btn-sm">Revert Back to LM</button>


                                            <?php }

                                            if($pending_officer == 'LM' && $from_office = 'CO'){
                                                echo "<span class='alert alert-success text-center'><strong>Case reverted to LM</strong></span>";
                                            }

                                            if(ENABLE_BUTTON_CO_ACTION_TENANT_URBAN != 0)
                                            {
                                                if(($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')){ ?>
                                                    <button type="submit" name="forward_to_dc" id="frwrd_dc_btn" onclick="return dc_forward()" class="m-1 col-2 btn btn-primary btn-info-full btn-sm">Forward to DC</button>

                                                    <?php
                                                    if($validation_bypass != 1)
                                                    {
                                                        ?>
                                                        <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="col-2 btn btn-warning m-1 btn-info-full btn-sm">Reject</button>
                                                    <?php }
                                                }

                                                if($pending_officer == 'DC' && $from_office == 'CO'){
                                                    echo "<span class='alert alert-success text-center'><strong>Case forwarded to DC</strong></span>";
                                                }
                                            }

                                            ?>

                                        </div>
                                        <br>
                                        <?php //}?>
                                    </form>
                                </div>
                            <?php }?>
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


                <!-- proceeding -->
                <div class="tab-pane" role="tabpanel" id="step4">

                    <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$_GET['case']?></span> )
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
                                        <th>Remark from</th>
                                        <th>Remark</th>
                                    </tr>
                                    <?php $i=1; foreach($proceedings as $pro): ?>
                                        <tr>
                                            <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                            <td><?=$pro->office_from;?></td>
                                            <td><span><?=$pro->note_on_order;?></span></td>
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

                    <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                        Settlement of  Occupancy Tenant (
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
                            <?php echo $this->lang->line('khasLand')?> (
                            <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">

                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-money" aria-hidden="true"></i> Premium Calculation
                                </h5>

                                <div class="tableCard " style="padding: 25px!important;">
                                    <div class="row">
                                        <div class="form-group col-md-12 ">
                                            <label>(Premium: 50 Times of Dag Revenue Value / Bigha)+ 10% of Zonal Value</label><br><br>

                                        </div>

                                    </div>
                                    <?php foreach ($premium_data as $dagsprem) {?>


                                        <?php if(!empty($dagsprem->zonal_valuation)) { ?>
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
                                        <?php } ?>

                                        <?php if(!empty($dagsprem->amount_dag)) { ?>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                    <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                    <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />
                                                </div>
                                            </div>
                                        <?php } }?>

                                    <div class="tableCard" style="padding: 25px!important;">
                                        <!-- Added by Manashyoti Deka on 02-08-2025 Start -->
                                        <div class="row">
                                            <div class="form-group col-md-6  text-primary">
                                                <label for="title">Govt. Share Amount</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->govt_share?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6  text-primary">
                                                <label for="title">Landlord Share Amount</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->landlord_share?>" readonly>
                                            </div>
                                        </div>
                                        
                                        <!-- Added by Manashyoti Deka on 02-08-2025 End -->
                                        <div class="row">
                                            <div class="form-group col-md-6  text-primary">
                                                <label for="title">Final Amount</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="finalamount" id="finalamount" value="<?=$dagsprem->final_amount?>" readonly>
                                            </div>

                                        </div>

                                        <?php if(!empty($dagsprem->is_full_pay)) { ?>
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
                                        <?php } ?>

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

                <div class="tab-pane" role="tabpanel" id="complete">
                    <h3>Complete</h3>
                    <p>You have successfully completed all steps.</p>
                </div>
                <div class="clearfix"></div>
            </div>


        </section>
    </div>

</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    function coForm(){
        let x = document.forms["co_form_sub"]["hearing_date"].value;
        // let y = document.forms["co_form_sub"]['remark_co'].value;
        // let z = document.forms['co_form_sub']['remark_co_text'].value;
        if (x == "") {
            alert("Hearing date needs to be selected.");
            $(".hearing_date").focus();
            return false;
        }
        // if (y == "") {
        //     alert("Select remark type.");
        //     $("#remark_co").focus();
        //     return false;
        // }
        // if (z == "") {
        //     alert("Enter remark.");
        //     $("#remark_co_text").focus();
        //     return false;
        // }
    }

    function lm_Revert(){

        let remark_co = document.forms["co_form_sub"]["remark_co"].value;
        let remark_co_text = document.forms["co_form_sub"]["remark_co_text"].value;

        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }else if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();

            // $('#frwrd_dc_btn').val('Forwarding...');
        }
    }

    function dc_forward(){
        let remark_co = document.forms["co_form_sub"]["remark_co"].value;
        let remark_co_text = document.forms["co_form_sub"]["remark_co_text"].value;
        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }else if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();

            // $('#frwrd_dc_btn').val('Forwarding...');
        }
    }

</script>

<script>
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

    // function autoRemark(){
    //     var remark_val = $.trim($('#remark_co').val());
    //     var case_no = $.trim($('#case_no').val());

    //     var postData = {
    //         'case_no': case_no,
    //     };

    //     if(remark_val == 1){

    //         $.blockUI({
    //             message: $('#displayBox'),
    //             css: {
    //                 border:'none',
    //                 backgroundColor:'transparent'
    //             }
    //         });

    //         $.ajax({
    //             url: baseurl+'SettlementCommon/checkRuralUrban',
    //             type: "POST",
    //             data: postData,
    //             success: function(data) {
    //                 $.unblockUI();

    //                 arr = JSON.parse(data);
    //                 if(arr.responseType == 0){
    //                     showErrorMessage(arr.msg);
    //                 }else{
    //                     //append auto remark in the text area
    //                     const areaDeatils = [];
    //                     for(i=0; i<arr.area.length; i++){
    //                         var areaData = " "+arr.area[i].s_dag_area_b +"B "+ arr.area[i].s_dag_area_k +"k "+ arr.area[i].s_dag_area_lc +"L covered by Dag no " +arr.area[i].dag_no;

    //                         areaDeatils.push(areaData);
    //                     }

    //                     var finalArea = areaDeatils.toString();
    //                     var circleName = arr.circleName;
    //                     var villageName = arr.villageName;
    //                     var mouzaName = arr.mouzaName;
    //                     var khasmaxrural = "<?=KHAS_RURAL_MAX?>";

    //                     console.log(arr);

    //                     if(arr.isUrban == 'Y'){

    //                         $('#remark_co_text').val("Perused LM report.  Checked all the documents submitted by the applicant and are found in order. \n\nThe applicant is found to be indigenous landless person occupying land measuring "+ finalArea +" of revenue village "+ villageName +" of mouza "+ mouzaName +" under "+ circleName +" Revenue circle and it can be settled with the applicant as per para 14.2/14.4 of Land Policy, 2019 and Notification No RDM-12011(17)/5/2022-LR-REV-R&D., Dated 11-Nov-2022; issued by Revenue and Disaster Management Department, Assam after due realization of premium. \n\nForwarded for perusal and consideration.");
    //                     }
    //                     else if(arr.isUrban == 'N')
    //                     {
    //                         $('#remark_co_text').val("Perused LM report. Checked all the documents submitted by the applicant and are found in order. The land is not within tribal belt & block/ within tribal belt & block and the applicant is eligible to get settlement, as per provision. The applicant is found to be indigenous landless person/cultivator having less than "+khasmaxrural+" land. Land measuring "+ finalArea +" of revenue village "+ villageName +" of mouza "+ mouzaName +" under "+ circleName +" Revenue Circle occupying by way of cultivation/homestead purpose or both may be settled with the applicant as per Notification No RDM-12011(17)/5/2022-LR-REV-R&D., Dated 11-Nov-2022; issued by Revenue and Disaster Management Department, Assam after due realization of premium.\n\nForwarded for perusal and consideration.");
    //                     }
    //                 }
    //             }
    //         });


    //     }

    //     if(remark_val != 1){
    //         $('#remark_co_text').val('');
    //     }

    // }
</script>

<script>
    function skForward()
    {
        let remark_co = document.forms["sk_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text_sk").val();


        if (remark_co == "") {
            alert("Select remark type.");
            $("#remark_co").focus();
            return false;
        }
        if (remark_co_text == "") {
            alert("Enter remark.");
            $("#remark_co_text").focus();
            return false;
        }
    }
</script>

<script>

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
        showNewDirectRejectModalMb3(''+case_no+'','<?php echo SETTLEMENT_TENANT_URBAN_ID ?>');

        // $('#co_rejection_agree').val('co_rejection_agree');
        // $('#co_form_sub').submit();

    }
    })

    }

    function revertSubAlert()
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you disagree with LM rejection and want revert to LM to reverify?',
            html: 'You wont be able to undo this once done',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, revert it',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
        afterSubmitSanitization();
        $('#co_rejection_disagree').val('co_rejection_disagree');
        $('#co_form_sub').submit();
    }
    })
    }
</script>
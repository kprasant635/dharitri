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
        color: #37474F;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
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
    .bgheading{
        background:linear-gradient(to right, #267871, #136a8a);
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
                                <span class="round-tab"><strong>DC</strong></span>
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

                    </ul>
                </div>

                <div class="tab-content">

                    <?php
                    $sl_count = 1;
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step1">


                            <?php
                            //include(APPPATH."views/SettlementView/Dc/include/applicationview.php");
                            include(APPPATH."views/SettlementView/include/applicationApCoView.php");

                            ?>
                        </div>

                        <!-- LM reporting starts here -->

                        <div class="tab-pane" role="tabpanel" id="step2">
                            <?php
                            include(APPPATH."views/SettlementView/include/lmReportApView.php");
                            ?>

                        </div>

                        <div class="tab-pane" role="tabpanel" id="step5">

                            <br>
                            <h5 class="bg-info p-2 text-white shadow">
                                Registration of <?php echo $this->lang->line('settlementAP')?> (
                                <span class="bg-warning"><?=$_GET['case']?></span> )
                            </h5>
                            <div class="reza-card">
                                <div class="reza-body">
                                    <h5 class="reza-title">Previous Remark </h5>
                                    <?php if($proceedings){ ?>
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
                                        <br>

                                    <?php } ?>
                                    <!-- Masud's code-->

                                    <input type="hidden" id="caseNo" value="<?php echo $caseDetails->case_no ?>">
                                    <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                                    <div class="row">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12"  style="margin-bottom: 40px">
                                            <h5 class="reza-title" style="margin-top: 15px">
                                                <i class="fa fa-map" aria-hidden="true"></i> Area Details Dag Wise
                                            </h5>
                                            <div class="tableCard">
                                                <div class="tree" >

                                                    <?php foreach ($chithaArea as $singleChithaArea): ?>

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
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endforeach; ?>
                                                                    </li>


                                                                    <li>
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

                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12" align="right">
                                            <?php if($caseDetails->status == MB_PAYMENT_RECEIVED) :?>
                                                <?php if($areaCheck == 0): ?>
                                                    <button class="rezaButt buttInfo" id="orderForChithaUpByDc">
                                                        <i class="fa fa-gavel" aria-hidden="true"></i>
                                                        <?php echo $this->lang->line('chithaUpdating') ?>
                                                    </button>

                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" role="tabpanel" id="proceedings">

                            <br>
                            <h5 class="bg-info p-2 text-white shadow">
                                Proceeding of <?php echo $this->lang->line('settlementAP')?> (
                                <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$_GET['case']?></span> )
                            </h5>
                            <div class="row" style="padding: 12px">
                                <div class="reza-card ">
                                    <div class="reza-body">
                                        <h5 class="reza-title">Remarks Details  </h5>
                                        <?php if($proceedings){ ?>
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
                                            <br><br>

                                        <?php } ?>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" role="tabpanel" id="history">

                            <br>
                            <h5 class="bg-info p-2 text-white shadow">
                                Proceeding of <?php echo $this->lang->line('settlementAP')?> (
                                <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$_GET['case']?></span> )
                            </h5>
                            <div class="row" style="padding: 12px">
                                <div class="reza-card ">
                                    <div class="reza-body">
                                        <h5 class="reza-title">Remarks Details  </h5>

                                        <div class="timeline">

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

                        </div>

                    </div>
        </section>

    </div>
</div>

<!-- Modal Order for chitha update -->
<div class="modal" role="dialog" id="orderForChithaUpdateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Order For Chitha Updating</h5>
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
                <button type="button" class="btn btn-secondary"  id="orderForChithaUpdateModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="orderForChithaUpdateModalYes">SUBMIT</button>
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

    // ****************************************************************
    // Revert Application From DC TO CO
    $(document).on('click','#orderForChithaUpByDc',function ()
    {
        $('#orderForChithaUpdateModal').modal('show');
    });

    $(document).on('click','#orderForChithaUpdateModalNo',function ()
    {
        $('#orderForChithaUpdateModal').modal('hide');
    });

    $(document).on('click','#orderForChithaUpdateModalYes',function ()
    {
        var remarks = $("#revertToCoRemarks").val();
        if(remarks != '')
        {
            const applicant = {
                caseNo: $("#caseNo").val(),
                remarks: remarks,
            };

            $.ajax({
                url: BASE_URL + "/SettlementApSdo/orderToCoByDcForChithaUpdating",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {

                    $('#orderForChithaUpdateModal').modal('hide');

                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        $('#orderForChithaUpByDc').hide();

                        showSuccessMessage("Order for Chitha Update Successfully Send to CO");
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage("Data not found !");
                    }
                    else if (data.responseType == 10)
                    {
                        showErrorMessage("Total Area Recommended for Settlement can’t exceed available Area in Chitha !");
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



<!-- Masud's CSS-->
<style>
    .error
    {
        color: red;
    }
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

    .text-info{
        font-weight: bold;
        color: #248CF7!important;
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

    .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        text-transform: capitalize;
        margin-left: 25px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
        margin: 10px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
    .labDiv{
        margin-bottom: 15px;
    }
    .lab{
        margin-bottom: 5px;
    }
    .landDetails{
        display: none;
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
    .textBold{
        font-size: 18px;
        font-weight: bold;
        color: #156B88;
        text-transform: uppercase;

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


<div class="row" style='padding: 25px 10px 30px 10px'>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
            <br>
        <?php } ?>

        <h5 class="bg-info p-2 text-white shadow"  style="text-transform: uppercase">
            Dag Deletions Request Details (  <?php echo $caseDetails->case_no ?> )
        </h5>

        <div class="row">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs shadow" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="step 5" >
                                    <span class="round-tab"><strong>Application</strong></span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#proceedings" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                    <span class="round-tab"><strong>Proceedings</strong></span>
                                </a>
                            </li>
                            <!--  <li role="presentation">-->
                            <!--      <a href="#history" data-toggle="tab" aria-controls="history" role="tab" title="history">-->
                            <!--          <span class="round-tab"><strong>History</strong></span>-->
                            <!--      </a>-->
                            <!--  </li>-->
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="step5">
                            <div class="reza-card">
                                <div class="reza-body">
                                    <div class="row">
                                        <h5 class="reza-title" style="margin-top: 0px">
                                            <i class="fa fa-map" aria-hidden="true"></i> Area Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="tableCard">
                                            <table class="table table-bordered" style="margin-bottom: 0px!important;">
                                                <tr>
                                                    <th style="width: 20%">District Name:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?=$this->utilityclass->getDistrictName($caseDetails->dist_code) ?>
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">Subdivision Name:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?=$this->utilityclass->getSubDivName($caseDetails->dist_code, $caseDetails->subdiv_code)?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Circle Name: </th>
                                                    <td class="text-warning">
                                                        <strong class="alert-warning">
                                                            <?=$this->utilityclass->getCircleName($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code)?>
                                                        </strong>
                                                    </td>
                                                    <th>Mouza Name: </th>
                                                    <td class="text-warning">
                                                        <strong class="alert-warning">
                                                            <?=$this->utilityclass->getMouzaName($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code)?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Lot Name: </th>
                                                    <td class="text-warning">
                                                        <strong class="alert-warning">
                                                            <?=$this->utilityclass->getLotName($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no)?>
                                                        </strong>
                                                    </td>
                                                    <th>Village Name: </th>
                                                    <td class="text-warning">
                                                        <strong class="alert-warning">
                                                            <?=$this->utilityclass->getVillageName($caseDetails->dist_code, $caseDetails->subdiv_code, $caseDetails->cir_code, $caseDetails->mouza_pargona_code, $caseDetails->lot_no, $caseDetails->vill_townprt_code)?>
                                                        </strong>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <h5 class="reza-title" style="margin-top: 35px">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Application Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="tableCard">
                                            <table class="table  table-bordered" style="margin-bottom: 0px!important;">
                                                <tr>
                                                    <th style="width: 20%">
                                                        Application No.
                                                    </th>
                                                    <td style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $caseDetails->case_no ?>
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">
                                                        Status
                                                    </th>
                                                    <td style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php if($caseDetails->status == 'W') :
                                                                $status  = 'Pending';
                                                                $pwnWord = 'Pending With';
                                                                $appBy   = '';
                                                            elseif ($caseDetails->status == 'R'):
                                                                $status  = 'Rejected';
                                                                $pwnWord = 'Rejected By';
                                                                $appBy   = 'Rejected At';
                                                            elseif ($caseDetails->status == 'F'):
                                                                $status  = 'Approved';
                                                                $pwnWord = 'Approved By';
                                                                $appBy   = 'Approved At';
                                                            else:
                                                                $status  = '';
                                                                $pwnWord = '';
                                                                $appBy   = '';
                                                            endif;
                                                            echo $status ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">
                                                        Requested By
                                                    </th>
                                                    <td style="width: 30%">
                                                        <strong class="alert-warning">
                                                            LM
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">
                                                        Requested At
                                                    </th>
                                                    <td style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo date("d-m-Y", strtotime($caseDetails->creation_date_time));  ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">
                                                        Forwarded By
                                                    </th>
                                                    <td style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $caseDetails->from_office ?>
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">
                                                        Pending With
                                                    </th>
                                                    <td style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $caseDetails->pending_office ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <?php if($appBy != ''): ?>
                                                    <tr>
                                                        <th style="width: 20%">
                                                            <?php echo $pwnWord ?>
                                                        </th>
                                                        <td style="width: 30%">
                                                            <strong class="alert-warning">
                                                                <?php echo $caseDetails->approved_by ?>
                                                            </strong>
                                                        </td>
                                                        <th style="width: 20%">
                                                            <?php echo $appBy ?>
                                                        </th>
                                                        <td style="width: 30%">
                                                            <strong class="alert-warning">
                                                                <?php echo date("d-m-Y", strtotime($caseDetails->approved_date_time));  ?>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <th style="width: 20%" >
                                                        Deletion Reason
                                                    </th>
                                                    <td style="width: 80%" colspan="3">
                                                        <strong class="alert-warning">
                                                            <?php foreach(json_decode(DAG_DELETE_REASON) as $cons){ ?>
                                                                <?php if($cons->CODE == $caseDetails->reject_code){ ?>
                                                                    <?php echo $cons->NAME  ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <h5 class="reza-title" style="margin-top: 35px">
                                            <i class="fa fa-map" aria-hidden="true"></i> Dag Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="tableCard">
                                            <table class="table table-bordered" style="margin-bottom: 0px!important;">
                                                <tr>
                                                    <th style="width: 20%">Dag No:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $dagDetails->dag_no ?>
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">Land Class:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $landType->land_type ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%">Patta No:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $caseDetails->patta_no ?>
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">Patta Type:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $pattaType->patta_type ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 20%"> Chitha Verified:</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <strong class="alert-warning">
                                                            <?php echo $caseDetails->chitha_verified ?>
                                                        </strong>
                                                    </td>
                                                    <th style="width: 20%">View Chitha</th>
                                                    <td class="text-warning" style="width: 30%">
                                                        <a href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $dagDetails->dag_no .
                                                            '&m=' . $caseDetails->mouza_pargona_code . '&l=' . $caseDetails->lot_no . '&v=' . $caseDetails->vill_townprt_code .
                                                            '&p=' . $caseDetails->patta_type_code . '&dist=' . $caseDetails->dist_code . '&cir=' . $caseDetails->cir_code . '&sub_div=' . $caseDetails->subdiv_code ?>"
                                                            target='chithaReport' class="rezaButt buttPrimary">  <i class="fa fa-eye"></i> View
                                                        </a>

                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv">
                                                    <label for="sel1" class="lab"><?php echo $this->lang->line('bigha'); ?></label>
                                                    <input type="text" class="form-control" value="<?php echo $caseDetails->dag_area_b ?>" readonly>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv">
                                                    <label for="sel1" class="lab"><?php echo $this->lang->line('katha'); ?></label>
                                                    <input type="text" class="form-control"  value="<?php echo $caseDetails->dag_area_k ?>" readonly>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv">
                                                    <label for="sel1" class="lab"><?php echo $this->lang->line('lesa'); ?></label>
                                                    <input type="text" class="form-control"   value="<?php echo $caseDetails->dag_area_lc ?>" readonly>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 labDiv">
                                                    <label for="sel1" class="lab"><?php echo $this->lang->line('ganda'); ?></label>
                                                    <input type="text" class="form-control" value="<?php echo $caseDetails->dag_area_g ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <h5 class="reza-title" style="margin-top: 35px">
                                            <i class="fa fa-users" aria-hidden="true"></i> Pattadar Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="tableCard">
                                            <table class="table table-bordered" >
                                                <tr>
                                                    <th style="width: 10%;">SL No.</th>
                                                    <th style="width: 45%;">Name</th>
                                                    <th style="width: 45%;">Fathers Name</th>
                                                </tr>
                                                <tbody>
                                                <?php $i=1; foreach ($pattadars as $pattadar): ?>
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $pattadar->pdar_name ?></td>
                                                        <td><?php echo $pattadar->pdar_father ?></td>
                                                    </tr>
                                                    <?php $i=$i+1; endforeach;?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <h5 class="reza-title" style="margin-top: 35px">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Document Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="tableCard">
                                            <table class="table table-bordered" >
                                                <tr>
                                                    <th style="width: 10%;">SL No.</th>
                                                    <th style="width: 60%;">File Name</th>
                                                    <th style="width: 30%;">Download</th>
                                                </tr>
                                                <tbody>
                                                <?php $j=1; foreach ($documents as $document): ?>
                                                    <tr>
                                                        <td><?php echo $j ?></td>
                                                        <td><?php echo $document->file_name ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url(); ?>index.php/DagDeletionController/getViewSupportiveDocs/?fileId=<?php echo $document->file_path; ?>"
                                                               class="rezaButt buttCust btn-sm " target="ViewDocument">
                                                                <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download
                                                            </a>

                                                        </td>
                                                    </tr>
                                                    <?php $j=$j+1; endforeach;?>
                                                </tbody>
                                            </table>

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

                        <div class="tab-pane" role="tabpanel" id="proceedings">
                            <div class="reza-card">
                                <div class="reza-body">
                                    <div class="row">
                                        <h5 class="reza-title" style="margin-top: 0px">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="tableCard">
                                            <table class="table table-bordered" >
                                                <tr>
                                                    <th style="width: 180px">Remark Date / Time</th>
                                                    <th style="width: 150px">Remark from</th>
                                                    <th style="width: 200px">Order</th>
                                                    <th>Remark</th>
                                                </tr>
                                                <?php foreach($remarks as $pro):  ?>
                                                    <tr>
                                                        <td>
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                                                            <?= date ("d-M-Y",strtotime($pro->date_entry)) ?>
                                                            <br>
                                                            <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;
                                                            <?= date ("h:i a",strtotime($pro->date_entry)) ?>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                            <b><?=$pro->user_desig_code;?></b>
                                                        </td>
                                                        <td><?=$pro->co_order;?></span></td>
                                                        <td><?=$pro->note_on_order;?></span></td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right" style="margin-top: 20px">
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

                        <!-- <div class="tab-pane" role="tabpanel" id="history">-->
                        <!--     <div class="row" align="center">-->
                        <!--         <h2 style="margin-top: 25px"> -- Coming Soon -- </h2>-->
                        <!--     </div>-->
                        <!--     <ul class="list-inline pull-right" style="margin-top: 20px">-->
                        <!--         <li>-->
                        <!--             <button type="button" class="btn btn-default prev-step">-->
                        <!--                 <i class="fa fa-arrow-circle-left"> </i>  --><?php //echo $this->lang->line('previous'); ?>
                        <!--             </button>-->
                        <!--         </li>-->
                        <!--     </ul>-->
                        <!-- </div>-->
                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!-- Modal for confirmation -->
<div class="modal" role="dialog" id="submitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to submit this Request & forward to CO</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitModalNo">NO</button>
                <button type="button" class="btn btn-primary"   id="submitModalYes">YES</button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

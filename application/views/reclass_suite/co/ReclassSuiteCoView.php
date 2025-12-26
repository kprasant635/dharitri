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
    .IamReza{
        background-image: linear-gradient(to right, #ed6ea0, #f7186a, #FBB03B);
        box-shadow: 0 4px 15px 0 rgba(252, 104, 110, 0.75);
        border: none;
        font-weight: bolder;
        font-size: 16px;
        color: white;
        padding: 8px;
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

<style>
    .tooltip-th {
        position: relative;
        display: inline-block;
        cursor: help;
    }

    .tooltip-th .tooltip-text {
        visibility: hidden;
        width: 180px;
        background-color: #f44336;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 6px;
        position: absolute;
        z-index: 1;
        top: -35px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip-th:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
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
                            <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1"                 >
                                <span class="round-tab">
                                  <strong>Application</strong>
                                </span>
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2" id="lmreport">
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
                                            echo "CO";
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
                $sl_count = 1;
                ?>
                <div class="tab-content">

                    <div class="row" style="padding: 10px 1px 1px 1px; ">
                        <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
                            <input type="hidden" name="dist_code" value="<?=$basic['dist_code']?>">
                            <input type="hidden" name="subdiv_code"  value="<?=$basic['subdiv_code']?>">
                            <input type="hidden" name="circle_code" value="<?=$basic['cir_code']?>">
                            <input type="hidden" name="mouza_code" value="<?=$basic['mouza_pargona_code']?>">
                            <input type="hidden" name="lot_no" value="<?=$basic['lot_no']?>">
                            <input type="hidden" name="vill_code" value="<?=$basic['vill_townprt_code']?>">
                            <input type="hidden" name="patta_type" value="">
                            <input type="hidden" name="patta_no" value="">
                            <button style="float:right" id="seeJamaClick" class="IamReza">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                Patta No. (Jamabandi View)
                            </button>
                        </form>
                    </div>

                    <?php //if($basic['is_cum_transfer']=='Y'){
                        //include(APPPATH."views/reclass_suite/common/applicationreclassSuiteView_cum_transfer.php");
                    //}else{
                    include(APPPATH."views/reclass_suite/common/applicationreclassSuiteView.php");
                    //}
                    ?>

                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            Offering Reclassification Suite (
                            <span class="bg-warning"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card">
                            <div class="reza-body">
                                <?php
                                if ($this->session->flashdata('message')):
                                    ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong><?php echo $this->session->flashdata('message'); ?></strong>
                                    </div>
                                <?php endif;?>
                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Previous Remark
                                </h5>

                                <?php if ($proceedings) {  ?>
                                    <div class="tableCard ">

                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Date of remark</th>
                                                <th>From</th>
                                                <th>Remark</th>
                                            </tr>
                                            <?php
                                            $i = 1;
                                            foreach ($proceedings as $pro):
                                                if ($i == 1) {
                                                    ?>
                                                    <tr>
                                                        <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                                        <!-- <td><?=$pro->office_from;?></td> -->
                                                        <td><?php if($pro->office_from=='LM'){
                                                                echo 'LRA';}
                                                            else{
                                                                echo $pro->office_from;
                                                            }
                                                            ?></td>
                                                        <td><span class="text-success"><?=$pro->note_on_order;?></span></td>
                                                    </tr>
                                                <?php }
                                                $i++;endforeach;?>
                                        </table>
                                    </div>
                                <?php }?>

                                <?php
                                if(isset($new_added_enc_data)){
                                    ?>

                                    <h5 class="bg-danger p-2 text-center" style="margin-top: 50px">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Newly Added VLB Land Bank encroacher Data
                                    </h5>

                                    <div class="tableCard">
                                        <table class="table table-bordered">
                                            <?php
                                            $enc_count =1;
                                            foreach($new_added_enc_data as $enc_data):
                                                ?>
                                                <tr>
                                                    <th><?=$enc_count++?></th>
                                                    <th>Encroacher Name</th>
                                                    <td><?=$enc_data->enc_name?></td>
                                                    <th>Father's Name</th>
                                                    <td><?=$enc_data->enc_fathers_name?></td>
                                                    <th>Encroachment from</th>
                                                    <td><?=$enc_data->enc_from_date?></td>
                                                </tr>

                                            <?php endforeach;?>
                                        </table>
                                    </div>


                                <?php }?>

                                <input type="hidden" id="caseNo" name="case_no" value="<?=$_GET['case']?>">


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

                                        <form method="post" action="<?php echo base_url()?>index.php/TeaGrantControllerCo/generateNoticeCo" name="sk_form_sub">

                                            <div class="mt-4 row px-5 justify-content-center">
                                                <div class="col-md-9">
                                                    <label for="inputEmail4">Select remark type</label>

                                                    <select name="remark_co_type" id="remark_co" class="form-control" required>
                                                        <option value="">Select remarks...</option>
                                                        <option value="Can be Recommended">Can be Recommended</option>
                                                        <option value="Can not be Recommended">Can not be Recommended</option>

                                                    </select> <br>
                                                    <textarea placeholder="Remarks  ..." name="remark_co_note" id="remark_co_text_sk" class="form-control" cols="30" rows="3"></textarea>
                                                    <input type="hidden" id="case_no" name="case_no" value="<?=$_GET['case']?>">
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
                                                if(($pending_officer == 'SK' || $pending_officer == 'CO') && $from_office == 'LM'){
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
                                        <i class="fa fa-user"></i> Applicant Data<br>
                                    </h5>

                                    <div class="tableCard">

                                        <table class="table mb-0">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Dag No</th>
                                                <th class="text-center">Reclass Type</th>
                                                <th class="text-center">OLd Land Class</th>
                                                <th class="text-center">Proposed Land Class</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($dags as $dagspremlm){ ?>
                                            <tr>
                                                <td></td>
                                                <td class="bg-white">
                                                    <strong><?=$dagspremlm->dag_no?></strong>
                                                </td>
                                                <td class="bg-white text-center">
                                                    <strong style="color:red"><?=($dagspremlm->is_full_partial=='N')?'FULL DAG':'PARTIAL DAG'?></strong>
                                                </td>
                                                <td class="bg-white text-center">
                                                    <strong>
                                                        <?=$dagspremlm->exist_land_class_name?>
                                                    </strong>
                                                </td>
                                                <td class="bg-white text-center">
                                                    <strong>
                                                        <?=$dagspremlm->proposed_land_class_name?>
                                                    </strong>
                                                </td>

                                                <?php }?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <?php foreach($dags as $dagspremlm){ ?>
                                        <?php if($dagspremlm->is_full_partial=='Y'){?>
                                        <table class="table mb-0">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th>Dag</th>
                                                <th class="text-center">Bigha</th>
                                                <th class="text-center">Katha</th>
                                                <th class="text-center"><?=$lessa_chatak?></th>

                                            </tr>
                                            </thead>
                                            <tr>
                                                <th rowspan="6" style="vertical-align : middle;">

                                                </th>
                                                <th class="bg-white">Applied Land Area in Selected Dag</th>
                                                <td class="bg-white">
                                                    <strong>
                                                        <?=$dagspremlm->dag_no?>
                                                    </strong>
                                                </td>
                                                <td class="bg-white">
                                                    <strong>
                                                        <input type="text" style="text-align: center;" name="dag_area_b<?=$dagspremlm->dag_no?>" id="dag_area_b<?=$dagspremlm->dag_no?>" class="form-control input-sm" value="<?=$dagspremlm->s_dag_area_b;?>" readonly>
                                                    </strong>
                                                </td>
                                                <td class="bg-white">
                                                    <input type="text" style="text-align: center;" name="dag_area_k<?=$dagspremlm->dag_no?>" id="dag_area_k<?=$dagspremlm->dag_no?>" value="<?=$dagspremlm->s_dag_area_k;?>" class="form-control input-sm" readonly>
                                                </td>
                                                <td class="bg-white">
                                                    <input type="text" style="text-align: center;" name="dag_area_lc<?=$dagspremlm->dag_no?>" id="dag_area_lc<?=$dagspremlm->dag_no?>" class="form-control input-sm" value="<?= $dagspremlm->s_dag_area_lc;?>" readonly>
                                                </td>
                                                <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                    <td class="bg-white">
                                                        <input type="text" style="text-align: center;" value="<?=$dagspremlm->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$dagspremlm->dag_no?>" id="dag_area_g<?=$dagspremlm->s_dag_area_g?>" readonly>
                                                    </td>
                                                    <td class="bg-white hide">
                                                        <input type="text" style="text-align: center;" value="<?=$dagspremlm->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$dagspremlm->dag_no?>" id="dag_area_kr<?=$dagspremlm->s_dag_area_kr?>" readonly>
                                                    </td>
                                                <?php endif;?>
                                            </tr>
                                            <?php }}?>


                                        </table>
                                        <!-- this only to display the error message in area validation -->
                                        <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                                        <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                                        <br>
                                    </div>



                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-user"></i> LRA Report<br>
                                    </h5>


                                    <div class="tableCard">

                                        <?php foreach($dags as $is_partition_en):?>

                                            <div class="row p-2">
                                                <div class="col-md-6">
                                                    <span ><strong>*</strong> Type of Reclassification(For Dags <?=$is_partition_en->dag_no?>) </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                                class="form-check-input"
                                                                type="radio"
                                                                name="is_partition_en_lmr<?=$is_partition_en->dag_no?>"
                                                                id="is_partition_en_lm<?=$is_partition_en->dag_no?>"
                                                                value="YES" disabled <?php if ($is_partition_en->is_partition=='Y' && $is_partition_en->is_full_partition=='N') {echo "checked";}?>
                                                        />
                                                        <label class="form-check-label" for="inlineRadio1">Partial area Partition(New Dag,Patta will be created)</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                                class="form-check-input"
                                                                type="radio"
                                                                name="is_partition_en_lmr<?=$is_partition_en->dag_no?>"
                                                                id="is_partition_en1_lm<?=$is_partition_en->dag_no?>"
                                                                value="NO" disabled <?php if ($is_partition_en->is_partition=='Y' && $is_partition_en->is_full_partition=='Y') {echo "checked";}?>
                                                        />
                                                        <label class="form-check-label" for="inlineRadio2">Full area with Partition(New Patta will be created)</label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input
                                                                class="form-check-input"
                                                                type="radio"
                                                                name="is_partition_en_lmr<?=$is_partition_en->dag_no?>"
                                                                id="is_partition_en2_lm<?=$is_partition_en->dag_no?>"
                                                                value="NO" disabled <?php if ($is_partition_en->is_partition=='N' && $is_partition_en->is_full_partition=='N') {echo "checked";}?>
                                                        />
                                                        <label class="form-check-label" for="inlineRadio2">Full dag reclass</label>
                                                    </div>





                                                    <?php if ($is_partition_en->is_partition=='Y' && $is_partition_en->is_full_partition=='N') { ?>
                                                        <button class="btn btn-sm btn-warning viewModalPart" onclick="showPartitionInfo('<?=$is_partition_en->dag_no?>')" type="button"><i class="fa fa-university"></i>&nbsp;View Details</button>

                                                        <button class="btn btn-sm btn-danger closeModalPart-<?=$is_partition_en->dag_no?>" style="display:none" onclick="closePropertyModalPart('<?=$is_partition_en->dag_no?>')" type="button"><i class="fa fa-close"></i>&nbsp;Close Details</button>

                                                        <div class="addPropertyDetailPart-<?=$is_partition_en->dag_no?>" style="display:none" >
                                                            <div class="tableCard">
                                                                <table class="table table-bordered" id="propertyTablePart-<?=$is_partition_en->dag_no?>">
                                                                    <tr>
                                                                        <th>Area</th>
                                                                        <th>Pattadar</th>
                                                                        <th>Remain in the old dag</th>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                    <script>
                                                        function viewPropertyModal(){
                                                            $('.viewModalPart-'+'<?=$is_partition_en->dag_no?>').hide('slow');
                                                            $('.closeModalPart-'+'<?=$is_partition_en->dag_no?>').show('slow');
                                                            $('.addPropertyDetailPart-'+'<?=$is_partition_en->dag_no?>').show('slow');
                                                        }

                                                        function closePropertyModalPart(dag_no) {
                                                            $('.viewModalPart-'+dag_no).show('slow');
                                                            $('.closeModalPart-'+dag_no).hide('slow');
                                                            $('.addPropertyDetailPart-'+dag_no).hide('slow');
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <input type="hidden" id="patta_type" value="<?=$dagspremlm->patta_type_code?>">
                                            <input type="hidden" id="patta_no" value="<?=$dagspremlm->patta_no?>">
                                        <?php endforeach;?>


                                        <form id='formAjaxPost'>

                                            <input type="hidden" id="case_no" name="case_no" value="<?=$_GET['case']?>">
                                            <div class="row p-2">
                                                <div class="col-md-5">
                                                    <sup><span class="badge badge-danger blink_me">Click on this to proceed</span></sup>
                                                    <label for="title"><strong>Do you want to change the Reclass details? <span style="color:red">*</span></span></strong></label>
                                                    <?= form_error('prem_update') ?>
                                                    <?= form_error('validationcheck') ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="radio" id="recls_update1" name="recls_update" class="prem_update <?php if(form_error('prem_update') || form_error('validationcheck')){ echo 'lm_invalid';} ?>" value="YES">
                                                    <label for="recls_update1">YES</label>
                                                    &nbsp;
                                                    <input type="radio" id="recls_update2" name="recls_update" class="prem_update <?php if(form_error('prem_update') || form_error('validationcheck')){ echo 'lm_invalid';} ?>" value="NO">
                                                    <label for="recls_update2">NO</label>
                                                </div>
                                            </div><br>

                                            <div id="chngPremButton" class="" style="margin-top: 1px; display:none;" type="button">
                                                <?php foreach ($dags as $partition_dag): ?>
                                                    <div class="row p-2">
                                                        <div class="col-md-5">
                                                            <span><strong>*</strong> Type of Reclassification (For Dags <?= $partition_dag->dag_no ?>)</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="reclass_option_<?= $partition_dag->dag_no ?>" id="full_area_with_partition_<?= $partition_dag->dag_no ?>" value="part_full_yes" onclick="openPartitionModal('<?= $basic['case_no'] ?>', '<?= $partition_dag->dag_no ?>', false)">
                                                                <label class="form-check-label" for="full_area_with_partition_<?= $partition_dag->dag_no ?>">
                                                                    <strong>Full area with Partition (New Patta will be created)</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="reclass_option_<?= $partition_dag->dag_no ?>" id="partition_area_<?= $partition_dag->dag_no ?>" value="part_yes" onclick="openPartitionModal('<?= $basic['case_no'] ?>', '<?= $partition_dag->dag_no ?>', true)">
                                                                <label class="form-check-label" for="partition_area_<?= $partition_dag->dag_no ?>">
                                                                    <strong>Partial area Partition (New Dag, Patta will be created)</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="reclass_option_<?= $partition_dag->dag_no ?>" id="full_dag_reclass_<?= $partition_dag->dag_no ?>" value="part_no" onclick="openPartitionModal('<?= $basic['case_no'] ?>', '<?= $partition_dag->dag_no ?>', false)">
                                                                <label class="form-check-label" for="full_dag_reclass_<?= $partition_dag->dag_no ?>">
                                                                    <strong>Full dag reclass</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row p-2">
                                                        <div class="form-check" id="partition_render_id<?= $partition_dag->dag_no ?>"></div>
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <span id='loading'></span><span id='msg'></span>

                                            <div id="chngAreaButton" class="" style="margin-top: 1px; display:none;" type="button">
                                                <?php foreach ($dags as $partition_dag):
                                                    if ($partition_dag->is_partition=='Y' && $partition_dag->is_full_partition=='N'){?>
                                                        <div class="col-md-12">
                                                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ ?>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Area Details</th>
                                                                        <th>Dag No : <strong style="color:red"><?=$partition_dag->dag_no?></strong></th>


                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="bigha_p<?=$partition_dag->dag_no?>" name="bigha_part_co<?=$partition_dag->dag_no?>" placeholder="Enter bigha"  value=""></strong></td>
                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="katha_p<?=$partition_dag->dag_no?>" name="katha_part_co<?=$partition_dag->dag_no?>" placeholder="Enter katha" value=""></strong></td>
                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="lessa_p<?=$partition_dag->dag_no?>" name="lessa_part_co<?=$partition_dag->dag_no?>" placeholder="Enter chatak" value=""></strong></td>
                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="ganda_p<?=$partition_dag->dag_no?>" name="ganda_part_co<?=$partition_dag->dag_no?>" placeholder="Enter ganda" value=""></strong></td>

                                                                    </tr>
                                                                </table>
                                                            <?php }else{?>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Area Details</th>
                                                                        <th>Dag No : <strong style="color:red"><?=$partition_dag->dag_no?></strong></th>


                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="bigha_p<?=$partition_dag->dag_no?>" name="bigha_part_co<?=$partition_dag->dag_no?>" placeholder="Enter bigha"  value=""></strong></td>
                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="katha_p<?=$partition_dag->dag_no?>" name="katha_part_co<?=$partition_dag->dag_no?>" placeholder="Enter katha" value=""></strong></td>
                                                                        <td><strong><input type="number" class="form-control font-weight-bold" id="lessa_p<?=$partition_dag->dag_no?>" name="lessa_part_co<?=$partition_dag->dag_no?>" placeholder="Enter lessa" value=""></strong></td>

                                                                    </tr>
                                                                </table>

                                                            <?php } ?>
                                                        </div>

                                                    <?php }?>




                                                <?php endforeach; ?>

                                            </div><br>
                                            <?php foreach ($dags as $penalty_dag):

                                            if($penalty_dag->is_penalty == 'Y'){?>

                                            <div class="row p-2">
                                            <div class="col-md-12">
                                                <label for="reclass_check"><strong>
                                                    <i class="fa fa-exclamation-circle" style="font-size:20px;color:red"></i> Is the applied land agricultural class land as per Chitha record but has already become unfit for agricultural purposes or where there has been no agricultural activity atleast for 10 years preceeding the date of application but put to non agricultural purpose without due permission? Govt Notification  No. ECF. 544110/2024/27. Dated 25-06-2025. for <span style="color: red;">DAG : <?=$penalty_dag->dag_no?></span>
                                                    <br>
                                                    <span style="color: red;">- Please verify properly along with LRA report as this check determines reclassification penalty (2 times in addition to Reclassification premium) to be levied -</span>
                                                </strong></label>
                                                <?= form_error('reclass_check') ?>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('reclass_check')){ echo 'lm_invalid';} ?>" type="radio" name="reclass_check<?=$penalty_dag->dag_no?>" id="reclass_check_yes<?=$penalty_dag->dag_no?>" value="YES">
                                                    <label class="form-check-label" for="reclass_check_yes">YES</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('reclass_check')){ echo 'lm_invalid';} ?>" type="radio" name="reclass_check<?=$penalty_dag->dag_no?>" id="reclass_check_no<?=$penalty_dag->dag_no?>" value="NO">
                                                    <label class="form-check-label" for="reclass_check_no">NO</label>
                                                </div>
                                            </div>
                                        </div><br>


                                       
                                            <div class="row p-2 reclassPremFivetimes" style="margin-top: 1px;" type="button">
                                            <div class="col-md-12">
                                                <label for="reclass_check"><strong>
                                                    <i><i class="fa fa-exclamation-circle" style="font-size:20px;color:red"></i> </i>Is the applied land agricultural class land as per Chitha record which has been under cultivation during ten years preceding the date of application but put to non agricultural purpose without due permission?Govt Notification ECF. 544110/2024/27. Dated 25-06-2025 for <span style="color: red;">DAG <?=$penalty_dag->dag_no?></span>
                                                    <br>
                                                    <span style="color: red;">- Please verify properly along with LRA report as this check determines reclassification penalty(5 times in addition to Reclassification premium) to be levied -</span>
                                                </strong></label>
                                                <?= form_error('reclass_check') ?>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('reclass_check')){ echo 'lm_invalid';} ?>" type="radio" name="reclass_five_check<?=$penalty_dag->dag_no?>" id="reclass_five_check_yes<?=$penalty_dag->dag_no?>" value="YES">
                                            <label class="form-check-label" for="reclass_five_check_yes<?=$penalty_dag->dag_no?>">YES</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('reclass_check')){ echo 'lm_invalid';} ?>" type="radio" name="reclass_five_check<?=$penalty_dag->dag_no?>" id="reclass_five_check_no<?=$penalty_dag->dag_no?>" value="NO">
                                                    <label class="form-check-label" for="reclass_five_check_no<?=$penalty_dag->dag_no?>">NO</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2 justification" id="justification_<?=$penalty_dag->dag_no?>" style="display:none;">
                                                 <sup><span class="badge badge-danger blink_me">Mandatory</span></sup>
                                            <textarea placeholder="Justification of Penalty" name="remark_co_justification<?=$penalty_dag->dag_no?>" id="remark_co_justification_<?=$penalty_dag->dag_no?>" class="form-control p-2" cols="30" rows="10"></textarea>
                                        </div>
                                        </div>
                                        <br>

                                        <div class="row p-2 hide">
                                            <div class="col-md-12">
                                                <label for="reclass_check"><strong>
                                                    <i class="fa fa-exclamation-circle" style="font-size:20px;color:red"></i> Whether NO Penalty should impose as it is permitted to use by Govt? for <span style="color: red;">DAG : <?=$penalty_dag->dag_no?></span>
                                                    <br>
                                                </strong></label>
                                                <?= form_error('reclass_check') ?>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('reclass_check')){ echo 'lm_invalid';} ?>" type="radio" name="reclass_check_penalty<?=$penalty_dag->dag_no?>" id="reclass_check_penalty_yes<?=$penalty_dag->dag_no?>" value="NO" disabled>
                                                    <label class="form-check-label" for="reclass_check_penalty_yes">YES</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input <?php if(form_error('reclass_check')){ echo 'lm_invalid';} ?>" type="radio" name="reclass_check_penalty<?=$penalty_dag->dag_no?>" id="reclass_check_penalty_no<?=$penalty_dag->dag_no?>" value="NO" checked>
                                                    <label class="form-check-label" for="reclass_check_penalty_no">NO</label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                        <?php endforeach; ?>

                                                <br>
                                            <button id="reclsChangeTypeButton" class="rezaButt buttPrimary" style="margin-top: 1px; display:none;"  type="submit"  name="save_reclass_type">
                                                Update Data
                                            </button><br><br>

                                        </form>



                                        <?php if($basic["co_edit"]=='Y'){?>


                                            <div class="text-center">
                                                <table class="table mb-0 " style="width: 100%;">
                                                    <thead class="thead-warning">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>CO changed Reclass Details</th>
                                                        <th>Dag No</th>
                                                        <th>Reclass type</th>
                                                        <th>Premium</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($premium_data as $index => $dagspremco) { ?>
                                                        <tr>
                                                            <td><?php echo $index + 1; ?></td>

                                                            <td class="bg-white text-center">
                                                                <strong style="color:blue">
                                                                    <?php
                                                                    if ($basic['co_edit'] == 'Y') {
                                                                        echo 'Yes';
                                                                    }
                                                                    else {
                                                                        echo 'No';
                                                                    }
                                                                    ?>
                                                                </strong>
                                                            </td>
                                                            <td><?=$dagspremco->dag_no?></td>
                                                            <td class="bg-white text-center">
                                                                <strong style="color:red">
                                                                    <?php
                                                                    if ($dagspremco->co_is_full_partition == 'N' && $dagspremco->co_is_partition == 'Y') {
                                                                        echo 'Partial area Partition <br>';

                                                                        echo 'Area ('.$dagspremco->co_area_b.'B-'.$dagspremco->co_area_k.'K-'.$dagspremco->co_area_lc.'L) ';
                                                                    } else if ($dagspremco->co_is_full_partition == 'Y' && $dagspremco->co_is_partition == 'Y') {
                                                                        echo 'Full area with Partition';
                                                                    } else {
                                                                        echo 'FULL DAG RECLASS';
                                                                    }
                                                                    ?>
                                                                </strong>
                                                            </td>
                                                            <td><?=$dagspremco->amount_dag?></td> <!-- Add this if there's content for the "Premium" column -->
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table><br><br>
                                                 <br><br>

                                      
                                                <table class="table mb-0 mx-auto" style="width: 100%;">
                                                    <thead class="thead-warning">
                                                    <tr>
                                                        <th>Penalty</th>
                                                        <th>Dag No</th>
                                                        <th>Premium</th>
                                                        <th>Rate of Penalty</th>
                                                        <th>
                                                        <div class="tooltip-th">
                                                            Penalty Amount
                                                            <div class="tooltip-text">Penalty is added on premium amount</div>
                                                        </div>
                                                    </th>
                                                    <th>Premium per Dag</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($premium_data as $index => $dags_penalties) { ?>
                                                        <tr>

                                                            <td>
                                                                <strong style="color:blue">
                                                                    <?php
                                                                    if ($dags_penalties->penalty_rate != 0) {
                                                                        echo 'Yes';
                                                                    }
                                                                    else {
                                                                        echo 'No';
                                                                    }
                                                                    ?>
                                                                </strong>
                                                            </td>
                                                            <td><?=$dags_penalties->dag_no?></td>
                                                            <?php if ($dags_penalties->penalty_rate != 0) {?>
                                                            <td><?=$dags_penalties->premium_without_penalty;?>
                                                            </td>
                                                            <?php }else{?>
                                                                 <td><?=$dags_penalties->amount_dag;?>
                                                            </td>
                                                            <?php }?>
                                                            <td><?= $dags_penalties->penalty_rate != 0 ? $dags_penalties->penalty_rate . ' X' : 'NA'; ?></td>
                                                            <?php if ($dags_penalties->penalty_rate != 0) {?>
                                                            <td>
                                                                 <?='('.$dags_penalties->premium_without_penalty .' + '. ($dags_penalties->penalty_rate .' * '. $dags_penalties->premium_without_penalty).')' ?>
                                                            </td>
                                                            <?php }else{?>
                                                                <td>NA</td>
                                                            <?php }?>

                                                            <?php if ($dags_penalties->penalty_rate != 0) {?>
                                                            <td><?= $dags_penalties->premium_without_penalty + ($dags_penalties->penalty_rate * $dags_penalties->premium_without_penalty); ?></td>
                                                            <?php }else{?>
                                                                <td>
                                                                    <?=$dags_penalties->amount_dag;?>
                                                                </td>
                                                            <?php } ?>
                                                            <td><?=$dags_penalties->final_amount;?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                        <?php }?>

                                        <?php if($basic["co_edit"]=='N') {?>

                                            
                                            <table class="table mb-0 mx-auto" style="width: 100%;">
                                                <thead class="thead-warning">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>CO Changed Reclass</th>
                                                        <th>Dag No</th>
                                                        <th>Reclass Type</th>
                                                        <th>Premium</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($premium_data as $index => $dagspremco) { ?>
                                                        <tr>
                                                            <td><?= $index + 1; ?></td>
                                                            <td>
                                                                <span style="color:blue; font-weight:bold;">
                                                                    <?= ($basic['co_edit'] == 'Y') ? 'Yes' : 'No'; ?>
                                                                </span>
                                                            </td>
                                                            <td><?= $dagspremco->dag_no ?></td>
                                                            <td>
                                                                <span style="color:red; font-weight:bold;">
                                                                    <?php
                                                                    if ($dagspremco->co_is_full_partition == 'N' && $dagspremco->co_is_partition == 'Y') {
                                                                        echo 'Partial Area Partition<br>';
                                                                        echo 'Area (' . $dagspremco->co_area_b . 'B-' . $dagspremco->co_area_k . 'K-' . $dagspremco->co_area_lc . 'L)';
                                                                    } else if ($dagspremco->co_is_full_partition == 'Y' && $dagspremco->co_is_partition == 'Y') {
                                                                        echo 'Full Area with Partition';
                                                                    } else {
                                                                        echo 'Full DAG Reclass';
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td><?= $dagspremco->amount_dag ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                            <br><br>

                                      
                                                <table class="table mb-0 mx-auto" style="width: 100%;">
                                                    <thead class="thead-warning">
                                                    <tr>
                                                        <th>Penalty</th>
                                                        <th>Dag No</th>
                                                        <th>Premium</th>
                                                        <th>Rate of Penalty</th>
                                                        <th>
                                                        <div class="tooltip-th">
                                                            Penalty Amount
                                                            <div class="tooltip-text">Penalty is added on premium amount</div>
                                                        </div>
                                                    </th>
                                                    <th>Premium per Dag</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($premium_data as $index => $dags_penalties) { ?>
                                                        <tr>

                                                            <td>
                                                                <strong style="color:blue">
                                                                    <?php
                                                                    if ($dags_penalties->penalty_rate !=0) {
                                                                        echo 'Yes';
                                                                    }
                                                                    else {
                                                                        echo 'No';
                                                                    }
                                                                    ?>
                                                                </strong>
                                                            </td>
                                                            <td><?=$dags_penalties->dag_no?></td>
                                                            <?php if ($dags_penalties->penalty_rate !=0) {?>
                                                            <td><?=$dags_penalties->premium_without_penalty;?>
                                                            </td>
                                                            <?php }else{?>
                                                                 <td><?=$dags_penalties->amount_dag;?>
                                                            </td>
                                                            <?php }?>
                                                            <td><?= $dags_penalties->penalty_rate != 0 ? $dags_penalties->penalty_rate . ' X' : 'NA'; ?></td>
                                                            <?php if ($dags_penalties->penalty_rate != 0) {?>
                                                            <td>
                                                                 <?='('.$dags_penalties->premium_without_penalty .' + '. ($dags_penalties->penalty_rate .' * '. $dags_penalties->premium_without_penalty).')' ?>
                                                            </td>
                                                            <?php }else{?>
                                                                <td>NA</td>
                                                            <?php }?>

                                                            <?php if ($dags_penalties->penalty_rate != 0) {?>
                                                            <td><?= $dags_penalties->premium_without_penalty + ($dags_penalties->penalty_rate * $dags_penalties->premium_without_penalty); ?></td>
                                                            <?php }else{?>
                                                                <td>
                                                                    <?=$dags_penalties->amount_dag;?>
                                                                </td>
                                                            <?php } ?>
                                                            <td><?=$dags_penalties->final_amount;?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                      

                                        <?php }?>



                                    </div>
                                    <br>

                                        <?php
                                        include(APPPATH."views/SettlementView/include/addMoreDocumentView.php");
                                        ?>
                                        <br>


                                   <!--////jds revert//-->
                                   <?php if (($basic['pending_officer'] == 'CO') && ($basic['wet_land'] == 'Y') &&  ($basic['status'] == 'W' || $basic['status'] == 'X' || $basic['status'] == 'R') && ($basic['co_edit'] == 'Y' || $basic['co_edit'] == 'N') && (($basic['ads_approve'] == null || $basic['ads_approve'] == '') && ($basic['jds_approve'] == '' || $basic['jds_approve'] == null) && ($basic['jds_revert'] != '' || $basic['jds_revert'] != null) )){?>
                                  <div class="container mt-4">
                                    <h4>Upload Map Data</h4>

                                    <div id="kmlUploadResponse"></div>

                                    <form id="kmlUploadForm" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="kml_file">Choose File:</label>
                                            <input type="file" name="kml_file" id="kml_file" class="form-control" accept=".kml" required>
                                        </div>

                                        <input type="hidden" id="case_no" name="case_no" value="<?= $_GET['case'] ?>">

                                        <button id="kmlUpload" class="rezaButt buttPrimary" type="button">
                                            Upload
                                        </button>
                                    </form>
                                </div>
                            <?php }?>



                                    <h5 class="reza-title" style="margin-top: 50px">
                                        <i class="fa fa-check-square-o"></i> CO Report<br>
                                    </h5>
                                    <div class="tableCard">
                                        <?php
                                        //include(APPPATH."views/SettlementView/include/areaEditView.php");
                                        ?>

                                        <?php
                                        $pending_officer = $basic["pending_officer"];
                                        $from_office = $basic["from_office"];
                                        ?>
                                        <form method="post" id="co_form_sub" name="co_form_sub" action="<?php echo base_url() ?>index.php/ReclassSuiteControllerCO/generateNoticeCo">

                                            <input type="hidden" id="case_no" name="case_no" value="<?=$_GET['case']?>">
                                            <input type="hidden" autocomplete="off" class="form-control date" id="enable_next_date" name="hearing_date" value="05/09/2022" />

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
                                                                    &nbsp;LRA has rejected this case by selected rejection reasons which can be seen in the LRA Report section. Do you aggree with LRA and allow rejection for this case?

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
                                                            <button onclick="return revertSubAlert()" id="disagreeWithLm" type="button" class="btn btn-warning btn-sm" name="">Disagree and Revert to LRA</button>
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
                                            <div class="mt-4 row px-5">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="control-label" style="font-size: 16px">
                                                        <input type="radio" name="order_type" value="re_lm_note" id="reverttolm"> <b>Send Back to LRA for Re Submitting Report</b>
                                                    </label>
                                                    &nbsp; &nbsp;
                                                    <label class="control-label" style="font-size: 16px">
                                                        <input type="radio" name="order_type" value="frwrddc" id="frwrdtodc"> <b>Forward</b>
                                                    </label><br><br>

                                                    <div id="adc_block">
                                                        <label class="rasid btn">Please Select ADC &nbsp;&nbsp;<span class="red">*</span></label>
                                                        <label class="btn btn-success">
                                                            <select class="form-control" name='adc_code' id="adc_code" required>
                                                                <option value="-1">Select ADC</option>
                                                                <?php

                                                                foreach ($adcUsers as $dcadc) {
                                                                    $user_desig_code = $dcadc->user_desig_code;
                                                                    $username = $dcadc->username." ( ".$user_desig_code." )";
                                                                    $user_code = $dcadc->user_code;
                                                                    echo "<option value='$user_code'>$username</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </label>
                                                    </div>
                                                    <br><br>

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

                                                        <!-- <option value="">Select remarks...</option>
                                                        <option value="Can be Recommended">Can be Recommended</option>
                                                        <option value="Can not be Recommended">Can not be Recommended</option>
                                                        <option value="Reverted back to LM">Reverted back to LM</option> -->
                                                        <!-- <option value="Case forwarded to DC">Case forwarded to DC</option> -->

                                                    </select> <br>

                                                    <textarea placeholder="Remarks  ..." name="remark_co" id="remark_co_text" class="form-control p-2" cols="30" rows="10"></textarea>
                                                    <input type="hidden" name="case_no" value="<?=$_GET['case']?>">

                                                </div>
                                            </div>
                                            <!-- <?php if ((($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')) && ($basic['partition_enable'] == 'Y') && ($basic['notice_generated_yn'] == null || strtolower($basic['notice_generated_yn']) == null)) {?>
                                            <div class="mt-4 row px-5 hearingshow">
                                            <div class="col-md-3">
                                            <label for="w3review" style="font-weight: bold">Hearing Date <span style="color: red; font-weight: bold">*</span>
                                            </label>
                                            <input type="date" class="form-control" name="w3date" id="datePickernew" required> </input>
                                                  </div>
                                            </div>
                                        <?php }?> -->
                                            <div class="row mt-4 justify-content-center">

                                                <?php
                                                if ($basic['notice_generated_yn'] == 'Y') {?>

                                                    <!-- <button type="submit" name="print_notice" formtarget="GenerateNotice" type="button" class="m-1 col-2 text-white btn btn-warning btn-sm">Print Notice</button> -->

                                                <?php } else {?>

                                                    <!-- <button type="submit" name="generate_notice" formtarget="GenerateNotice" type="button" class="m-1 col-2 text-white btn btn-warning btn-sm">Generate Notice</button> -->
                                                <?php }?>

                                                <?php

                                                if(ENABLE_ADDITIONAL_PROPERTY_BUTTON == 1 && isset($checkAdditionalProperty)){
                                                    echo ADDITIONAL_PROPERTY_BUTTON;
                                                    include(APPPATH."views/SettlementView/include/additionalProperty.php");
                                                }
                                                ?>

                                                <?php if (($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')|| ($pending_officer == 'CO' && $from_office == 'CO')) {?>
                                                    <input type="submit" name="revert_to_lm" onclick="return lm_Revert();" class="m-1 col-2 btn btn-danger btn-sm" id="lm_revert_btn" disabled value="Revert Back to LM">
                                                    <!-- </button> -->
                                                <?php }

                                                if($pending_officer == 'LM' && $from_office == 'CO'){
                                                    echo "<span class='alert-success text-center'><strong>Case reverted back to LM.</strong></span>";
                                                }
                                                if(ENABLE_BUTTON_CO_TO_DC_RECLS != 0){

                                                    //if($penalty_dags == 'Y')
                                                    //{?>
                                                        <!-- <div class="row text-center">
                                                            <strong style="color:red">This case cannot be forwarded at the moment as it is a penalty case. It can be processed after the new penalty calculation notification is finalized. </strong>
                                                        </div> -->
                                                    <?php //}
                                                    // else
                                                    // {

                                                        if($sdo_user_check == 'y'){

                                                            if ((($pending_officer != 'LM' && $from_office != 'CO') || ($pending_officer != 'DC' && $from_office != 'CO')) && ($basic['wet_land'] != 'Y') && ($basic['co_edit'] == 'Y' || $basic['co_edit'] == 'N')) {?>
                                                                <input type="submit" name="forward_to_dc" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" disabled value="Forward">
                                                                <!-- </button> -->

                                                                <?php
                                                                if($validation_bypass != 1)

                                                                {
                                                                    ?>
                                                                    <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="col-2 btn btn-warning m-1 btn-info-full btn-sm">Reject</button>
                                                                <?php }}


                                                            ///for wet land//
                                                            else if (($pending_officer == 'CO' && ($from_office == 'CO' || $from_office == 'LM' || $from_office == 'ADC')) && ($basic['wet_land'] == 'Y') &&  ($basic['status'] == 'W' || $basic['status'] == 'X' || $basic['status'] == 'R') && ($basic['co_edit'] == 'Y' || $basic['co_edit'] == 'N') && (($basic['ads_approve'] == null || $basic['ads_approve'] == '') && ($basic['jds_approve'] == '' || $basic['jds_approve'] == null) )) {?>
                                                                <input type="submit" name="forward_to_jds" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" disabled value="Forward to JDS">
                                                                <!-- </button> -->

                                                                <?php
                                                                if($validation_bypass != 1)

                                                                {
                                                                    ?>
                                                                    <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="col-2 btn btn-warning m-1 btn-info-full btn-sm">Reject</button>
                                                                <?php }}

                                                            //for reverted cases//
                                                            else if (($pending_officer == 'CO' && ($from_office == 'DC' || $from_office == 'ADC')) &&  ($basic['status'] == 'R') && ($basic['co_edit'] == 'Y' || $basic['co_edit'] == 'N')) {?>
                                                                <input type="submit" name="forward_to_dc" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" disabled value="Forward">
                                                                <!-- </button> -->

                                                                <?php
                                                                if($validation_bypass != 1)

                                                                {
                                                                    ?>
                                                                    <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="col-2 btn btn-warning m-1 btn-info-full btn-sm">Reject</button>
                                                                <?php }}

                                                            else if (($pending_officer == 'CO' && ($from_office == 'CO' || $from_office == 'LM')) && ($basic['wet_land'] == 'Y') &&  ($basic['status'] == 'W' || $basic['status'] == 'X' || $basic['status'] == 'R') && ($basic['co_edit'] == 'Y' || $basic['co_edit'] == 'N') && ($basic['ads_approve'] == 1  && $basic['jds_approve'] ==1 &&  $basic['dlr_approve'] ==1)) {?>
                                                                <input type="submit" name="forward_to_dc" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" disabled value="Forward">
                                                                <!-- </button> -->

                                                                <?php
                                                                if($validation_bypass != 1)

                                                                {
                                                                    ?>
                                                                    <button onclick="return rejectSubAlert()" id="reject_button_direct" type="button" class="col-2 btn btn-warning m-1 btn-info-full btn-sm">Reject</button>
                                                                <?php }}

                                                        }
                                                    //}
                                                    // else
                                                    // {
                                                    ?>
                                                    <!-- <div class="row text-center">
                                                        <strong style="color:red">No SDO created for this location.</strong>
                                                    </div> -->

                                                    <?php
                                                    //}

                                                }

                                                if($pending_officer == 'DC' && $from_office == 'CO'){
                                                    echo "<span class='alert-success text-center'><strong>Case forwarded to DC.</strong></span>";
                                                }
                                                ?>

                                            </div>

                                            <?php
                                            //}
                                            ?>
                                            <br>
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


                    <div class="tab-pane" role="tabpanel" id="step4">

                        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            Offering Reclassification Suite (
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
                                            <th>From</th>
                                            <th>Remark</th>
                                        </tr>
                                        <?php $i = 1;foreach ($proceedings as $pro): ?>
                                            <tr>
                                                <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
                                                <td><?=$pro->office_from;?></td>
                                                <td><span class="text-success"><?=$pro->note_on_order;?></span></td>
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

                        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                            Offering Reclassification Suite (
                            <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$_GET['case']?></span> )
                        </h5>
                        <div class="reza-card ">
                            <div class="reza-body">

                                <h5 class="reza-title" style="margin-top: 15px">
                                    <i class="fa fa-history" aria-hidden="true"></i> Case History
                                </h5>

                                <div class="tableCard ">
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
                        <ul class="list-inline pull-right" style="margin-top: 20px">
                            <li>
                                <button type="button" class="btn btn-primary next-step">
                                    <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
                                </button>
                            </li>
                        </ul>

                    </div>
                    <div class="clearfix"></div>
                    <?php if(!empty($premium_data)) { ?>
                        <div class="tab-pane" role="tabpanel" id="premium">

                            <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                                Offering Reclassification Suite (
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
                                                    <label>Selected Land Type for Existing land class</label>
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <?php $dagspremval = '';
                                                    switch ($dagsprem->rate_type) {
                                                        case 1:
                                                            $dagspremval = 'Agricultural';
                                                            break;
                                                        case 2:
                                                            $dagspremval = 'Residential';
                                                            break;
                                                        case 3:
                                                            $dagspremval = 'Industrial';
                                                            break;
                                                        case 4:
                                                            $dagspremval = 'Trade';
                                                            break;
                                                        case 6:
                                                            $dagspremval = 'Plantation';
                                                            break;
                                                        case 10:
                                                            $dagspremval = 'Institution';
                                                            break;
                                                        // Add more cases as needed
                                                        default:
                                                            $dagspremval = 'Unknown'; // Default value if no cases match
                                                            break;
                                                    }
                                                    ?>
                                                    <input name="rate_type<?=$dagsprem->dag_no?>" readonly class="form-control" id="rate_type<?=$dagsprem->dag_no?>" value="<?=$dagspremval?>">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Selected Proposed Land Class</label>

                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <input type="text" class="form-control" name="" value="<?=$dagsprem->proposed_land_class_name?>" readonly>
                                                    <input type="hidden" class="form-control" name="prop_lc_code<?=$dagsprem->dag_no?>" value="<?=$dagsprem->proposed_land_class_code?>" id="proc_lc_code<?=$dagsprem->dag_no?>"  readonly>

                                                </div>
                                            </div>
                                            <div class="row" id="percentage<?=$dagsprem->rate?>" value="<?=$dagsprem->rate?>">
                                                <span><b>(Premium: <?php echo $dagsprem->rate;?>% based on above selected data)</b></span>
                                            </div>


                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="title">Total amount for dag no <strong><span id="dag_prem"><?=$dagsprem->dag_no?></span></strong></label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input id="finalper<?=$dagsprem->dag_no?>" type="hidden" class="finalper<?=$dagsprem->dag_no?>" value="" name="finalper<?=$dagsprem->dag_no?>" />
                                                    <input id="total_lessa<?=$dagsprem->dag_no?>" type="hidden" class="total_lessa<?=$dagsprem->dag_no?>" value="" name="total_lessa<?=$dagsprem->dag_no?>" />
                                                    <input type="text" class="totalamount form-control" value="<?=$dagsprem->amount_dag?>" name="amount<?=$dagsprem->dag_no?>" readonly />

                                                </div>
                                            </div><hr>
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
            </div>
        </section>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    function skForward()
    {
        let remark_co = document.forms["sk_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text_sk").val();


        if (remark_co == "" || remark_co == "-1") {
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


    function lm_Revert(){
        let remark_co = document.forms["co_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text").val();


        if (remark_co == "" || remark_co == "-1") {
            alert("Select remark type.");
            // $('#lm_revert_btn').prop('disabled', false);
            // $('#lm_revert_btn').val('Revert Back to LM');
            $("#remark_co").focus();
            return false;
        }
        else if (remark_co_text == "") {
            alert("Enter remark.");
            // $('#lm_revert_btn').prop('disabled', false);
            // $('#lm_revert_btn').val('Revert Back to LM');
            $("#remark_co_text").focus();
            return false;
        }
        else
        {
            afterSubmitSanitization();
            // $('#lm_revert_btn').prop('disabled', true);
            // $('#lm_revert_btn').val('Reverting...');
        }

    }

    function dc_forward(){
        let remark_co = document.forms["co_form_sub"]["remark_co_type"].value;
        let remark_co_text =  $("#remark_co_text").val();


        let adc_code =  $("#adc_code").val();
        //  $("#adc_block").show();

        if (adc_code == "" || adc_code == "-1") {
            alert("Select ADC before proceed.");
            $("#adc_code").focus();
            return false;
        }

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

    $(document).ready(function(){
        $("#reverttolm").click(function() {
            $("#lm_revert_btn").removeAttr("disabled");
            $("#frwrd_dc_btn").attr("disabled", true);
        });

        $("#frwrdtodc").click(function() {
            $("#frwrd_dc_btn").removeAttr("disabled");
            $("#lm_revert_btn").attr("disabled", true);
        });
    });

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
    function autoRemark(){

        var remark_val = $.trim($('#remark_co').val());
        var case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no': case_no,
        };

        if(remark_val == 1){

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            $.ajax({
                url: baseurl+'ReclassSuiteControllerCO/checkRuralUrban',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                    if(arr.responseType == 0){
                        showErrorMessage(arr.msg);
                    }else{
                        //append auto remark in the text area
                        const areaDeatils = [];
                        for(i=0; i<arr.area.length; i++){
                            var areaData = "covered by Dag no " +arr.area[i].dag_no+ " from " + arr.area[i].exist_land_class_name
                                + " to " + arr.area[i].proposed_land_class_name;

                            areaDeatils.push(areaData);
                        }

                        var finalArea = areaDeatils.toString();
                        var circleName = arr.circleName;
                        var villageName = arr.villageName;
                        var mouzaName = arr.mouzaName;
                        var khasmaxrural = "<?=KHAS_RURAL_MAX?>";

                        if(arr.isUrban == 'Y'){
                            $('#remark_co_text').val("Perused LRA report.  Checked all the documents submitted by the applicant along with report/certificate from line dept and are found in order as per provision of the Act . The land is in undisputed possession, without any ongoing litigation. The application for reclassification of land "+ finalArea +" is recommended for approval, subject to the conditions mentioned above. The necessary premium as per the mentioned notification should be realized before the reclassification is finalized.");
                        }
                        else if(arr.isUrban == 'N')
                        {
                            $('#remark_co_text').val("Perused LRA report.  Checked all the documents submitted by the applicant along with report/certificate from line dept and are found in order as per provision of the Act . The land is in undisputed possession, without any ongoing litigation. The application for reclassification of land "+ finalArea +" is recommended for approval, subject to the conditions mentioned above. The necessary premium as per the mentioned notification should be realized before the reclassification is finalized.");
                        }
                    }
                }
            });


        }

        if(remark_val != 1){
            $('#remark_co_text').val('');
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
        showNewDirectRejectModalMb3(''+case_no+'','<?php echo RECLASS_ID ?>');

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
            title: 'Are you sure you disagree with LRA rejection and want revert to LRA to reverify?',
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


<script>
    // Function to show lm report using AJAX
    function showLmReport(popupId) {

        var case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no': case_no,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementCommon/getLmReport',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);
                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }else{
                    // alert(arr.lmnotes.chitha_verified); return;

                    if(arr.lmnotes.chitha_verified == 'YES'){
                        $("#chiitha_verified1").attr('checked', 'checked');
                    }else{
                        $("#chiitha_verified2").attr('checked', 'checked');
                    }

                    if(arr.lmnotes.vlb_verified == 'YES'){
                        $("#vlb_verified1").attr('checked', 'checked');
                    }else{
                        $("#vlb_verified2").attr('checked', 'checked');
                    }


                    const linkContainer = $('#vlbdag');
                    for(var i = 0; i < arr.dags.length; i++)
                    {

                        const link = $('<a>', {
                            href: baseurl+'SettlementTribal/vlbEncroacherDetails?dag='+arr.dags[i].dag_no+'&m='+arr.basic.mouza_pargona_code+'&l='+arr.basic.lot_no+'&v='+arr.basic.vill_townprt_code+'&dist='+arr.basic.dist_code+'&cir='+arr.basic.cir_code+'&sub_div='+arr.basic.subdiv_code+'',
                            text: 'Dag ' + (arr.dags[i].dag_no) + '(VLB)',
                            target:'_blank'
                        });

                        linkContainer.append(link).append('<br>');
                    }


                }
            }
        });
    }

</script>

<script>
    // Get today's date in the format YYYY-MM-DD
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const day = String(today.getDate()).padStart(2, '0');
    const currentDate = `${year}-${month}-${day}`;

    // Set the minimum date to today
    const datePickernew = document.getElementById('datePickernew');
    datePickernew.min = currentDate;
    datePickernew.value = currentDate; // Optionally pre-fill with the current date
</script>

<!-- <script type="text/javascript">
$(document).ready(function ()
{
    $(".hearingshow").hide();
    $("#frwrd_ast_btn").click(function ()
    {
        $(".hearingshow").show();
    });
});
</script> -->

<script type="text/javascript">
    $("input[name=recls_update").on("click", function () {

        var selectedValue3 = $("input[name=recls_update]:checked").val();
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
                $("#chngAreaButton").show();

            }
        }

        $("#reclsChangeTypeButton").show();

    });


    function openPartitionModal(case_no, dag_no, check_ren){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'ReclassSuite/fetchRenderDataFromChitha',
            type: "POST",
            data: {case_no: case_no, dag_no:dag_no, check_ren: check_ren},
            success: function(data) {
                $.unblockUI();
                $('#partition_render_id'+dag_no).html(data);
            }
        });
    }
</script>
<!-- <script type="text/javascript">
    $('input[name="reclass_five_check<?=$penalty_dag->dag_no?>"]').on('change', function() {
            if ($(this).val() === 'YES') {
                $('#justification_<?=$penalty_dag->dag_no?>').show();
            } else {
                $('#justification_<?=$penalty_dag->dag_no?>').hide();
            }
        });
</script> -->

<script type="text/javascript">
    $(document).ready(function () {
        $('input[name^="reclass_five_check"]').on('change', function () {
            const nameAttr = $(this).attr('name'); // e.g., reclass_five_check101
            const dagNo = nameAttr.replace('reclass_five_check', ''); // gets 101

            if ($(this).val() === 'YES') {
                $('#justification_' + dagNo).show();
            } else {
                $('#justification_' + dagNo).hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $('#formAjaxPost').on('submit', function(event){
        event.preventDefault();
        $('.error').html('');
        var formData = $(this).serialize();
        //console.log(formData);
        $.ajax({
            type        : 'POST',
            url         : baseurl+'ReclassSuiteControllerCO/reclassTypeSave',
            data        : formData,
            dataType    : 'json',
            encode      : true,
            beforeSend: function(){
                $("#loading").html("Validating ...Please wait...");
                $('.alert').hide();
            },
            success: function(data){
                //console.log(data.success);return;
                if(data.success != null){
                    $("#loading").hide();
                    $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');

                    setTimeout(function() {
                        location.reload(); // Reload page after success
                    }, 1000);
                    //window.location.href = data.redirect_url;
                }else if(data.error!=null){
                    $("#loading").hide();
                    $('.btn-block').show();
                    $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                }
            },
            error: function(errorData){
                $("#loading").hide();
                $('.btn-block').show();
                if(errorData.status == 403){
                    const errorInJson = errorData.responseJSON.errors;
                    if(Object.keys(errorInJson).length){
                        $.each(errorInJson, function(index, value){
                            $(`.${index}_error`).html(value);
                        });
                    }else{
                        $('.error_container').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
                    }
                }else{
                    $('.error_container').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $("#seeJamaClick").click(function(event){
        $("input[name='patta_type']").val($('#patta_type').val());
        $("input[name='patta_no']").val($('#patta_no').val());
        $('#seeJama').submit();
    });
</script>


<script>
$('#kmlUpload').on('click', function () {
    var form = $('#kmlUploadForm')[0];
    var formData = new FormData(form); // includes file input + hidden case_no

    $.ajax({
        url         : baseurl+'ReclassSuiteControllerCO/upload_kml_ajax',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#kmlUpload').prop('disabled', true).text('Uploading...');
            $('#kmlUploadResponse').html('');
        },
        success: function (response) {
            $('#kmlUploadResponse').html('<div class="alert alert-success">' + response + '</div>');
        },
        error: function (xhr) {
            $('#kmlUploadResponse').html('<div class="alert alert-danger">Upload failed: ' + xhr.responseText + '</div>');
        },
        complete: function () {
            $('#kmlUpload').prop('disabled', false).text('Upload');
        }
    });
});
</script>


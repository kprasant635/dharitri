<!-- Masud's CSS -->
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

<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY))))
{
    $lessa_chatak='Chatak';
}
else
{
    $lessa_chatak='Lessa';
}?>

<div class="row" style='padding-top: 15px; margin-bottom: 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        Relinquishment /
        <a href="<?= base_url()?>index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment">
            Process
        </a>
        /
        <a href="<?= base_url()?>index.php/RelinquishmentLmController/getAllPendingRelinquishmentCasesLm">
            Pending Application
        </a>
        /  View
        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
        </a>

        <?php if($this->session->flashdata('success')) { ?>
            <br>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <br>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >

        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
                    <li role="presentation" class="active">
                        <a class="test" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1" >
                            <span class="round-tab"><strong>Application</strong></span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="test" href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3" >
                            <span class="round-tab"><strong>Process</strong></span>
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

                <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px">
                    <?php echo $this->lang->line('relinquishmentTitle')?> (
                    <span class="bg-warning" style="padding-left: 5px; padding-right: 5px"><?=$case_no?></span> )
                </h5>

                <!-- Application -->
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="reza-card">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-file-text"></i>  Application Details
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/application_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-map-marker"></i>  Location Details
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/location_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-pencil-square-o"></i> Self declaration details
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/self_dec_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-user"></i>  Applicant Details
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/applicant_details.php"); ?>

                            <h5 class="reza-title" style="margin-top: 45px">
                                <i class="fa fa-user"></i>  Owner Details
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/owner_details.php"); ?>


                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-map"></i>  Area Details
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/dag_details.php"); ?>


                            <h5 class="reza-title" style="margin-top: 50px">
                                <i class="fa fa-file-pdf-o"></i> Documents
                            </h5>
                            <?php include(APPPATH."views/Relinquishment/include/application/document_details.php"); ?>


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

                <!-- process -->
                <div class="tab-pane" role="tabpanel" id="step3">

                    <div class="reza-card ">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Process Details
                            </h5>
                            <?php if($proceedings){ ?>
                                <div class="tableCard" style="margin-top: 10px">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px">Remark Date</th>
                                            <th style="width: 200px">Remark Time</th>
                                            <th style="width: 200px">Remark from</th>
                                            <th>Remark</th>
                                        </tr>
                                        <?php $i=0; foreach($proceedings as $pro):  ?>
                                            <?php if($i==0): ?>
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
                                            <?php endif; ?>
                                            <?php $i = $i+1; ?>
                                        <?php endforeach;?>
                                    </table>
                                </div>
                                <br>
                            <?php } ?>
                            <?php include(APPPATH."views/Relinquishment/include/application/process_lm.php"); ?>

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

                <!-- Remarks -->
                <div class="tab-pane" role="tabpanel" id="proceedings">
                    <div class="reza-card ">
                        <div class="reza-body">
                            <h5 class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Remarks Details
                            </h5>
                            <?php if($proceedings){ ?>
                                <div class="tableCard" style="margin-top: 10px">
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
                                <br><br>
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

                <!-- History -->
                <div class="tab-pane" role="tabpanel" id="history">
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

                    <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                            <button type="button" class="btn btn-default prev-step">
                                <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal submit application -->
<div class="modal" role="dialog" id="submitApplicationModal" style="z-index: 9999999999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to Forward this application to CO </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary"   id="submitApplicationModalYes">Yes, Forward</button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


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


    // application submit confirmation
    $(document).on('click','#applicationSubmit',function ()
    {
        $('#submitApplicationModal').modal('show');
    });

    $(document).on('click','#submitApplicationModalNo',function ()
    {
        $('#submitApplicationModal').modal('hide');
    });

    // application submit
    $(document).on('click','#submitApplicationModalYes',function ()
    {
        var appNo     = $('#appNo').val();
        var forwardTo = $('#forwardTo').val();
        var remarks   = $('#remarks').val();
        if(appNo == '' || appNo == null)
        {
            $('#submitApplicationModal').modal('hide');
            showErrorMessage('Some Required data is missing !');
        }
        if(forwardTo == '' || forwardTo == null)
        {
            $('#submitApplicationModal').modal('hide');
            showErrorMessage('Some Required data is missing ! (Forward To)');
        }
        if(remarks == '' || remarks == null)
        {
            $('#submitApplicationModal').modal('hide');
            showErrorMessage('Some Required data is missing ! (Remarks)');
        }


        $('#myForm').submit();
        $('#submitApplicationModal').modal('hide');
    });


</script>

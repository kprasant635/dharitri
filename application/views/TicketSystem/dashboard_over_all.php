<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
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
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
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
    .rezaText {
        font-size: 16px;
    }

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }

    #files-area {
        width: 100%;
        margin: 0 auto;
    }
    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;
    }
    .file-block > span.name {
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        width: max-content;
        display: inline-flex;
    }

    .file-delete {
        display: flex;
        width: 24px;
        padding-top: 3px;
        color: red;
        background-color: #6eb4ff00;
        font-size: large;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;
    }
    .card-subtitle{
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .rezaBR{
        margin-top: 15px;
    }
    body{
        background: linear-gradient(#dbe1e2, #faf2f2);
    }


    .reza-card .circle {
        border-radius: 3px;
        width: 100px;
        height: 100px;
        background: black;
        position: absolute;
        right: 0px;
        top: 0;
        background-image: linear-gradient(to top, #fbc2eb 0%, #a6c1ee 100%);
        border-bottom-left-radius: 170px;
    }
    .countNum{
        padding-left: 20px;
        padding-bottom: 10px;
        font-weight: bold;
        color: #7E57C2;
    }

</style>

<div class="row" style='padding: 5px 20px 20px 0px'>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="padding-left: 30px; margin-top: 15px">
        Ticket System / Dashboard (Over All)

    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" align="right" style="margin-top: 15px">
        <a href="<?= base_url()?>index.php/Home/index">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Back to Menu
            </button>
        </a>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('errorM')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('errorM') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row" style="padding-right: 10px">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <a href="<?= base_url()?>index.php/TicketCommonController/getAllRegisterTicketForReport" target="_blank">
                    <div class="reza-card">
                        <div class="reza-title"> <i class="fa fa-edit"></i> Registered </div>
                        <div class="countNum">
                            <h2> <?php echo $allCount;  ?></h2>
                        </div>
                        <div class="circle"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <a href="<?= base_url()?>index.php/TicketCommonController/getAllClosedTicketForReport" target="_blank">
                    <div class="reza-card">
                        <div class="reza-title" style="color: #4CAF50"> <i class="fa fa-check-circle"></i> Closed </div>
                        <div class="countNum">
                            <h2>  <?php echo $closedCount;  ?></h2>
                        </div>
                        <div class="circle"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <a href="<?= base_url()?>index.php/TicketCommonController/getAllRejectedTicketForReport" target="_blank">
                    <div class="reza-card">
                        <div class="reza-title" style="color: #F44336"> <i class="fa fa-times-circle" ></i> Rejected </div>
                        <div class="countNum">
                            <h2><?php echo $rejectedCount;  ?></h2>
                        </div>
                        <div class="circle"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <a href="<?= base_url()?>index.php/TicketCommonController/getAllInQueueTicketForReport" target="_blank">
                    <div class="reza-card">
                        <div class="reza-title" style="color: #9C27B0"> <i class="fa fa-bars"></i> In Queue </div>
                        <div class="countNum">
                            <h2><?php echo $inQueueCount;  ?></h2>
                        </div>
                        <div class="circle"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <a href="<?= base_url()?>index.php/TicketCommonController/getAllUnderProcessingTicketForReport" target="_blank">
                    <div class="reza-card">
                        <div class="reza-title" style="color: #2196F3">
                            <i class="fa fa-cog fa-spin" aria-hidden="true"></i> Under Processing </div>
                        <div class="countNum">
                            <h2><?php echo $processingCount;  ?></h2>
                        </div>
                        <div class="circle"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <a href="<?= base_url()?>index.php/TicketCommonController/getAllPendingTicketForReport" target="_blank">
                    <div class="reza-card">
                        <div class="reza-title" style="color: #455A64"><i class="fa fa-spinner fa-spin"></i> Pending </div>
                        <div class="countNum">
                            <h2><?php echo $pendingCount;  ?></h2>
                        </div>
                        <div class="circle"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right: 0px">
            <div class="reza-card">
                <div class="reza-body"  style="margin-top: -10px!important;">
                    <div class="row reza-title">
                        Ticket Register Service Wise
                    </div>
                    <table class="table table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Application</th>
                            <th>Service</th>
                            <th>Total Ticket Register</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td style="font-weight: bolder"><?php echo $service['application_name'] ?></td>
                                <td style="font-weight: bolder"><?php echo $service['service_name'] ?></td>
                                <td style="font-weight: bold" align="center">
                                    <?php echo $service['count'] ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() ?>index.php/TicketCommonController/getTicketServiceTypeWise/?service=<?php echo $service['id']?>"
                                       type="button" class="btn btn-primary waves-effect">
                                        <i class="fa fa-eye"></i>
                                        <span>View</span>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>




<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>







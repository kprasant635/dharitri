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
    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaInfo {
        color: #FFF;
        background-color: #FFC107;
    }


    .rezaPrim {
        color: #FFF;
        background-color: #9C27B0;
    }
    .rezaDag {
        color: #FFF;
        background-color: #4CAF50;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        /*min-width: 150px;*/
        line-height: 37px;
        padding: 0 .8rem;
        /*font-size: 15px;*/
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        /*letter-spacing: 0.8px;*/
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
        margin-bottom: 5px;
        margin-left: 3px;
    }
    .rezaText {
        font-size: 16px;
    }

    .checkBoxD{

        width: 20px;
        height: 20px;
    }
    .reza-m{
        margin: 5px;
    }
    #progress {
        width: 500px;
        border: 1px solid #aaa;
        height: 20px;
    }
    #progress .bar {
        background-color: cyan;
        height: 20px;
    }
</style>



<div class="row" style='padding: 40px 0px 40px 20px'>

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

    <div class="row" style='padding: 15px 30px 15px 0px' id="print_direct">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="reza-card" >
                <div class="reza-title">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            All SDLAC Rejected Cases
                        </div>
                        <div class="col-md-4 col-sm-4" align="right">
                            Date - <?php echo date("d-m-Y") ?>
                        </div>
                    </div>
                </div>
                <div class="reza-body">
                    <br>
                    <table class="table table-bordered" style="background-color: white">
                        <thead>
                        <tr>
                            <th style="width: 15%; text-align: center; align-content: center" >
                                Meeting Name
                                <br>
                                Meeting Date
                            </th>
                            <th style="width: 80%; padding: 0px!important; text-align: center; align-content: center" align="center" >
                                <br>
                                Circle Name
                                <br>
                                <table style="padding: 0px!important; width: 100%">
                                    <tbody>
                                    <tr>
                                        <?php foreach ($locations as $location): ?>
                                            <td>
                                                <?php echo $location['cir_name'] ?>

                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    </tbody>
                                </table>
                            </th>
                            <th style="width: 5%">
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody style="background-color: white!important;">
                        <?php $grandTotalCirCount = 0 ?>
                        <?php foreach ($meetings as $meeting):  ?>
                            <?php $totalCirCount = 0 ?>
                            <tr style="background-color: white!important;">
                                <td>
                                    <b><?php echo $meeting->meeting_name?></b>
                                    <br>
                                    <b><?php echo date("d-m-Y", strtotime($meeting->meeting_date))?></b>
                                </td>
                                <td style="padding: 0px!important;">
                                    <table style="padding: 0px!important; width: 100%">
                                        <tbody>
                                        <tr>
                                            <?php foreach ($locations as $location): ?>
                                                <td style="align-content: center; text-align: center">
                                                    <?php

                                                    $casesCount = $this->utilityclass->countSdlacApproveCasesCircleWise
                                                    ($meeting->id,$this->session->userdata('dist_code'),$location['subdiv_code'],$location['cir_code'],2);

                                                    echo  $casesCount;

                                                    $totalCirCount = $totalCirCount + $casesCount ;
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <b><?php $grandTotalCirCount = $grandTotalCirCount + $totalCirCount ;echo $totalCirCount ?></b>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: white!important;">
                            <td colspan="2" style="text-align: center">
                                <b> Total SDLAC Rejected Case </b>
                            </td>
                            <td>
                                <b><?php echo $grandTotalCirCount ?></b>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="row mt-4 mb-5 justify-content-center text-center">
            <div class="col-6">
                <button type="button" onclick="printDiv('print_direct');" id="print" class="rezaButt">
                    <i class="fa fa-print"></i>
                    Print Report
                </button>
            </div>
        </div>
    </div>


</div>



<!--// NEW JS BY MASUD REZA-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>


<script>
    // -js-to print notice
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents
    }
</script>

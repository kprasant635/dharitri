<!-- Masud's CSS-->
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
    .rezaInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaClose {
        color: #FFF;
        background-color: #EF5350;
    }
    .rezaPrint {
        color: #FFF;
        background-color: #673AB7;
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

    .checkBoxD{

        width: 20px;
        height: 20px;
    }


    .divCard {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        margin-bottom: 20px;
    }

    .tdPrint{
        background-color: white!important;
        border: 1px solid black;
        color: black!important;
        font-size: 12px;
    }

    .table-bordered>tbody>tr>td,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>td,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>thead>tr>th
    {
        border: 1px solid black!important;
    }


    @media print
    {

        .divCard {
            background: #fff!important;
            width: 100%!important;
            margin-bottom: 20px!important;
            box-shadow: none!important;
        }
        .no-print, .no-print *
        {
            display: none !important;
        }
        div.page-break-after {
            display: block !important;
            page-break-after: always;
            padding: 15px;
            border: 1px solid #ccc;
        }

        .tdPrint{
            background-color: white!important;
            border: 1px solid black;
            color: black!important;
            font-size: 12px;
        }
        .table-bordered>tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th
        {
            border: 1px solid black!important;
        }


    }



</style>

<div class="row" style='padding: 20px 35px 0px 0px' align="left">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
        <span style="padding-left: 35px">
            Process /
            Settlement MB /
        <a href="<?= base_url()?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
            <?php echo $this->lang->line('villageMeetingSidebar') ?>
        </a>
        / Print Report
        </span>


        <a href="<?= base_url()?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Go one step Back</button>
        </a>
    </div>
</div>

<div class="row" style='padding: 10px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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


        <div class="reza-card" id="print_direct">
            <div class="reza-title">
                <span><?php echo $this->lang->line('villageMeetingCase') ?></span>
                <hr>

            </div>

            <div class="reza-body">
                <h5>Area Details</h5>
                <table class="table table-bordered" style="width: 100%">
                    <tbody>
                    <tr>
                        <td style="width: 20%">District</td>
                        <td style="width: 30%"><?php echo $dist_name->loc_name ?></td>

                        <td style="width: 20%">Sub Division</td>
                        <td style="width: 30%"><?php echo $subDiv_name->loc_name ?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Circle</td>
                        <td style="width: 30%"><?php echo $circle_name->loc_name ?></td>

                        <td style="width: 20%">Mouza</td>
                        <td style="width: 30%"><?php echo $mouza_name->loc_name ?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%">Lot</td>
                        <td style="width: 30%"><?php echo $lot_name->loc_name ?></td>

                        <td style="width: 20%">Village</td>
                        <td style="width: 30%"><?php echo $village_name ?></td>
                    </tr>
                    </tbody>
                </table>

                <br><br>
                <h5>Applications </h5>

                <?php if($output->settlement_ap == NULL ): ?>
                <?php else : ?>
                    <br><br>
                    <h5><?php echo $this->lang->line('settlementAPSelect') ?> </h5>
                    <table class='table table-bordered table-condensed' width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference No. <br> Application No.</th>
                            <th>Settlement Holder Details</th>
                            <th>Area Details</th>
                            <th><?php echo $this->lang->line('condition_1') ?></th>
                            <th><?php echo $this->lang->line('condition_2') ?></th>
                            <th><?php echo $this->lang->line('condition_3') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($output->settlement_ap as $case):  $i++ ?>
                            <tr>
                                <td class="tdPrint"><?php echo $i ?> </td>
                                <td class="tdPrint">
                                    <?php echo $case->ref_no ?>
                                    <br>
                                    <?php echo $case->application_no ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $applicants = explode(",", $case->name);

                                    foreach ($applicants as $applicant)
                                    {
                                        echo $applicant .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $dags = explode(",", $case->dag);

                                    foreach ($dags as $dag)
                                    {
                                        echo $dag .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_no<?=$case->application_no?>">&nbsp;No
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>



                <?php if($output->settlement_tribal == NULL ): ?>
                <?php else : ?>
                    <br><br>
                    <h5><?php echo $this->lang->line('settlementTribalCommunityTitle') ?> </h5>
                    <table class='table table-bordered table-condensed' width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference No. <br> Application No.</th>
                            <th>Settlement Holder Details</th>
                            <th>Area Details</th>
                            <th><?php echo $this->lang->line('condition_1') ?></th>
                            <th><?php echo $this->lang->line('condition_2') ?></th>
                            <th><?php echo $this->lang->line('condition_3') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($output->settlement_tribal as $case):  $i++ ?>
                            <tr>
                                <td class="tdPrint"><?php echo $i ?> </td>
                                <td class="tdPrint">
                                    <?php echo $case->ref_no ?>
                                    <br>
                                    <?php echo $case->application_no ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $applicants = explode(",", $case->name);

                                    foreach ($applicants as $applicant)
                                    {
                                        echo $applicant .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $dags = explode(",", $case->dag);

                                    foreach ($dags as $dag)
                                    {
                                        echo $dag .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_no<?=$case->application_no?>">&nbsp;No
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>



                <?php if($output->settlement_cultivators == NULL ): ?>
                <?php else : ?>
                    <br><br>
                    <h5><?php echo $this->lang->line('specialCultivatorsSelect') ?> </h5>
                    <table class='table table-bordered table-condensed' width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference No. <br> Application No.</th>
                            <th>Settlement Holder Details</th>
                            <th>Area Details</th>
                            <th><?php echo $this->lang->line('condition_1') ?></th>
                            <th><?php echo $this->lang->line('condition_2') ?></th>
                            <th><?php echo $this->lang->line('condition_3') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($output->settlement_cultivators as $case):  $i++ ?>
                            <tr>
                                <td class="tdPrint"><?php echo $i ?> </td>
                                <td class="tdPrint">
                                    <?php echo $case->ref_no ?>
                                    <br>
                                    <?php echo $case->application_no ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $applicants = explode(",", $case->name);

                                    foreach ($applicants as $applicant)
                                    {
                                        echo $applicant .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $dags = explode(",", $case->dag);

                                    foreach ($dags as $dag)
                                    {
                                        echo $dag .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_no<?=$case->application_no?>">&nbsp;No
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>


                <?php if($output->settlement_khas == NULL ): ?>
                <?php else : ?>
                    <br><br>
                    <h5><?php echo $this->lang->line('khasLand') ?> </h5>
                    <table class='table table-bordered table-condensed' width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference No. <br> Application No.</th>
                            <th>Settlement Holder Details</th>
                            <th>Area Details</th>
                            <th><?php echo $this->lang->line('condition_1') ?></th>
                            <th><?php echo $this->lang->line('condition_2') ?></th>
                            <th><?php echo $this->lang->line('condition_3') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($output->settlement_khas as $case):  $i++ ?>
                            <tr>
                                <td class="tdPrint"><?php echo $i ?> </td>
                                <td class="tdPrint">
                                    <?php echo $case->ref_no ?>
                                    <br>
                                    <?php echo $case->application_no ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $applicants = explode(",", $case->name);

                                    foreach ($applicants as $applicant)
                                    {
                                        echo $applicant .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $dags = explode(",", $case->dag);

                                    foreach ($dags as $dag)
                                    {
                                        echo $dag .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_no<?=$case->application_no?>">&nbsp;No
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>


                <?php if($output->settlement_pgr == NULL ): ?>
                <?php else : ?>
                    <br><br>
                    <h5><?php echo $this->lang->line('pgrVgrTitle') ?> </h5>
                    <table class='table table-bordered table-condensed' width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference No. <br> Application No.</th>
                            <th>Settlement Holder Details</th>
                            <th>Area Details</th>
                            <th><?php echo $this->lang->line('condition_1') ?></th>
                            <th><?php echo $this->lang->line('condition_2') ?></th>
                            <th><?php echo $this->lang->line('condition_3') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($output->settlement_pgr as $case):  $i++ ?>
                            <tr>
                                <td class="tdPrint"><?php echo $i ?> </td>
                                <td class="tdPrint">
                                    <?php echo $case->ref_no ?>
                                    <br>
                                    <?php echo $case->application_no ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $applicants = explode(",", $case->name);

                                    foreach ($applicants as $applicant)
                                    {
                                        echo $applicant .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <?php $dags = explode(",", $case->dag);

                                    foreach ($dags as $dag)
                                    {
                                        echo $dag .'<br>';
                                    }
                                    ?>
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_1<?=$case->application_no?>" id="condition_1_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_2<?=$case->application_no?>" id="condition_2_no<?=$case->application_no?>">&nbsp;No
                                </td>
                                <td class="tdPrint">
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_yes<?=$case->application_no?>">&nbsp;Yes
                                    <br>
                                    <input style="pointer-events: none" type="radio" name="condition_3<?=$case->application_no?>" id="condition_3_no<?=$case->application_no?>">&nbsp;No
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>




            </div>

        </div>

        <div class="container">
            <div class="row mt-4 mb-5 justify-content-center text-center">
                <div class="col-6">
                    <button type="button" onclick="printDiv('print_direct');" id="print" class="rezaButt rezaPrint">
                        <i class="fa fa-print"></i>
                        Print Report
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="row" style='padding: 0px 35px 30px 0px' align="left">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left">
        <a href="<?= base_url()?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
            <button type="button" class="btn btn-sm btn-danger pull-right">
                <i class="fa fa-backward"></i>&nbsp;Go one step Back</button>
        </a>
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

    function loader(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent',
            }
        });
    }


    // print notice
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();
        document.body.innerHTML = originalContents;


    }



</script>



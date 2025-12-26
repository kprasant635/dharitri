<style>
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
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
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

    .reza-title2{
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

    .mmm{
        font-weight: bold;
        margin-top: 3px!important;
    }
    .nnn{
        margin-top: 5px!important;
    }
    .form-check-input {
        width: 20px!important;
        height: 20px!important;
    }


    .form__input{
        padding: 18px 15px!important;

    }
</style>

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
        margin-top: -10px;
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


    .rezaI{
        padding: 10px;
        margin-left: 15px;
        margin-right: 15px;
        min-width: 75px!important;
        max-width: 75px!important;
    }
    .reza{
        padding: 15px;
    }


</style>

<div class="row" style='padding: 10px 20px 20px 0px'>
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

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            <a href="<?= base_url()?>index.php/MapIndustrialCorridorController/firstLandingPageMappingInCorridor">
                Mapping of Industrial Corridor /
            </a>
            <a href="<?= base_url()?>index.php/MapIndustrialCorridorController/getMappedLocationList">
                Mapped Dags List /
            </a>
            View


            <a href="<?= base_url()?>index.php/Home/index">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu
                </button>
            </a>
        </div>


        <div class="reza-card" style="margin-top: 15px">
            <div class="reza-title">
                <span>Mapping of Industrial Corridor</span>
                <hr>
            </div>
            <div class="reza-body">

                <h5 class="reza-title2" style="margin-top: 5px">
                    <i class="fa fa-map-signs" aria-hidden="true"></i> Location Details
                </h5>
                <div class="tableCard">
                    <table class="table table-striped table-hover table-bordered">
                        <tr>
                            <th style="width: 20%">District</th>
                            <td style="width: 30%">
                                <?php echo $this->utilityclass->getDistrictName($mappedLocDetails->dist_code);?>
                            </td>
                            <th style="width: 20%">Sub Division</th>
                            <td style="width: 30%">
                                <?php echo $this->utilityclass->getSubDivName($mappedLocDetails->dist_code,$mappedLocDetails->subdiv_code);?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%">Circle</th>
                            <td style="width: 30%">
                                <?php echo $this->utilityclass->getCircleName($mappedLocDetails->dist_code,$mappedLocDetails->subdiv_code,$mappedLocDetails->cir_code);?>
                            </td>
                            <th style="width: 20%">Mouza</th>
                            <td style="width: 30%">
                                <?php echo $this->utilityclass->getMouzaName($mappedLocDetails->dist_code,$mappedLocDetails->subdiv_code,$mappedLocDetails->cir_code,$mappedLocDetails->mouza_pargona_code);?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%">Lot</th>
                            <td style="width: 30%">
                                <?php echo $this->utilityclass->getLotLocationName($mappedLocDetails->dist_code,$mappedLocDetails->subdiv_code,$mappedLocDetails->cir_code,$mappedLocDetails->mouza_pargona_code,$mappedLocDetails->lot_no);?>
                            </td>
                            <th style="width: 20%">Village</th>
                            <td style="width: 30%">
                                <?php echo $this->utilityclass->getVillageName($mappedLocDetails->dist_code,$mappedLocDetails->subdiv_code,$mappedLocDetails->cir_code,$mappedLocDetails->mouza_pargona_code,$mappedLocDetails->lot_no,$mappedLocDetails->vill_townprt_code);?>
                            </td>
                        </tr>
                    </table>
                </div>

                <h5 class="reza-title2" style="margin-top: 45px">
                    <i class="fa fa-map" aria-hidden="true"></i> Dag Details
                </h5>
                <div class="tableCard">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form id="myForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url()?>index.php/MapIndustrialCorridorController/updateMappingDags">

                                <input type="hidden" id="mappedLocId" name="mappedLocId" value="<?php echo $mappedLocDetails->id ?>">
                                <?php foreach ($dagList as $dag) : ?>
                                    <div class="form-check form-check-inline rezaI">
                                        <?php if(in_array($dag->dag_no, $mappedDagArray)): ?>
                                            <input class="form-check-input reza" checked type="checkbox" name="selectedDags[]" id="inlineCheckbox1'<?php echo $dag->dag_no_int ?>" value="<?php echo $dag->dag_no.'@'.$dag->dag_no_int ?>">
                                        <?php else: ?>
                                            <input class="form-check-input reza" type="checkbox" name="selectedDags[]"  id="inlineCheckbox1'<?php $dag->dag_no_int ?>" value="<?php echo $dag->dag_no.'@'.$dag->dag_no_int ?>" >
                                        <?php endif; ?>

                                        <?php echo $dag->dag_no ?>
                                    </div>
                                <?php endforeach; ?>

                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 40px">
                            <button type="button" class="rezaButt buttPrimary" id="applicationSubmit">
                                <i class="fa fa-check-square-o"></i> UPDATE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal submit application -->
<div class="modal" role="dialog" id="submitApplicationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to update this Dags </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="submitApplicationModalNo">No</button>
                <button type="button" class="btn btn-primary" id="submitApplicationModalYes">Yes, Update</button>
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
        $('#myForm').submit();
        $('#submitApplicationModal').modal('hide');
    });


</script>





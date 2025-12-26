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

    .rezaButt {
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


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process / <?php echo $this->lang->line('ncSidebar') ?> /
            <a href="<?= base_url()?>index.php/NcKhasLandSdo/NcKhasLandLandingPageSdo">
                <?php echo $this->lang->line('ncKhasLink') ?>
            </a>


            <a href="<?= base_url()?>index.php/NcKhasLandSdo/NcKhasLandLandingPageSdo">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu
                </button>
            </a>
        </div>

        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('ncKhasLandTitle') ?></span>

                <hr>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Steps</th>
                        <th>Process Name</th>
                        <th>Total No. Case</th>
                        <th style="width: 200px; text-align:center!important;" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(NC_SDO_ADC_PROCESS_LIVE == 1): ?>
                        <tr>
                            <td class="rezaText"> <?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> Step 1</td>
                            <td class="rezaText"><?php echo $this->lang->line('ncFirstProceeding') ?></td>
                            <td>
                                <?php
                                if ($firstProceedingCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$firstProceedingCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$firstProceedingCount</span>";
                                }
                                ?>
                            </td>
                            <td style="width: 200px" >
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/NcKhasLandSdo/viewNcKhasFirstProceedingCaseListSdo'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td>Step 2</td>
                            <td class="rezaText"><?php echo $this->lang->line('NcSDLACCommittee') ?></td>
                            <td>
                                <?php
                                if ($SDLACCommitteeCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACCommitteeCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACCommitteeCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/NcCommonSdoAdcDc/getSdlacCommitteeCommon'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step 3</td>
                            <td class="rezaText"><?php echo $this->lang->line('SDLACNcMarkApp') ?></td>
                            <td>
                                <?php
                                if ($SDLACMarkedCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACMarkedCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACMarkedCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/NcKhasLandSdo/viewAllMarkAsSDLACListForKhasSdo'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step 4</td>
                            <td class="rezaText"><?php echo $this->lang->line('NcSDLACMemberReport') ?></td>
                            <td>
                                <?php
                                if ($SDLACReportCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACReportCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACReportCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/NcKhasLandSdo/getAllProposalListSdlacKhasSdo'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> -- </td>
                            <td class="rezaText">Modification Requested By CO</td>
                            <td>
                                <?php
                                if ($coModificationCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$coModificationCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$coModificationCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/NcModification/getAllModificationRequestApplicationByCoForSdo?service='.NC_KHAS_LAND_ID; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>





                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> -- </td>
                            <td class="rezaText"><?php echo $this->lang->line('SDLACConsideration') ?></td>
                            <td>
                                <?php
                                if ($SDLACConsideration != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACConsideration</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACConsideration</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/NcKhasLandSdo/getAllUnderConSdlacKhasSdo'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
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


</script>



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


</style>
<div class="row" style='padding: 10px 20px 20px 0px'>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Relinquishment /
            <a href="<?= base_url()?>index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment">
                Process
            </a>
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

        <?php $slNo = 0; ?>
        <?php $stepNo = 0; ?>

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('relinquishmentTitle') ?></span>
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

                    <?php if(in_array($this->session->userdata('user_desig_code'),RELINQUISHMENT_REGISTER_ACCESS)): ?>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                            <td class="rezaText"><?php echo $this->lang->line('relinquishment1stPro') ?></td>
                            <td>
                                <?php
                                if ($registerCasesCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$registerCasesCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$registerCasesCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt buttPrimary" href="<?php echo base_url() . 'index.php/RelinquishmentRegisterController/unRegisterRelinquishmentAppList'; ?>" style="float:right">
                                    <i class="fa fa-pencil-square-o"></i>&nbsp;Register
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if(in_array($this->session->userdata('user_desig_code'),RELINQUISHMENT_PROCESS_ACCESS)): ?>
                        <?php if($this->session->userdata('user_desig_code')== MB_LOT_MONDOL): ?>
                            <tr>
                                <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                                <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                                <td class="rezaText"><?php echo $this->lang->line('relinquishmentPending') ?></td>
                                <td>
                                    <?php
                                    if ($pendingCasesCount != '0')
                                    {
                                        echo  "<span class=\"badge badge-danger\">$pendingCasesCount</span>";
                                    }
                                    else
                                    {
                                        echo  "<span class=\"badge badge-success\">$pendingCasesCount</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/RelinquishmentLmController/getAllPendingRelinquishmentCasesLm'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if($this->session->userdata('user_desig_code')== MB_CIRCLE_OFFICER): ?>
                            <tr>
                                <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                                <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                                <td class="rezaText"><?php echo $this->lang->line('relinquishment1stPro') ?></td>
                                <td>
                                    <?php
                                    if ($pendingCasesCount != '0')
                                    {
                                        echo  "<span class=\"badge badge-danger\">$pendingCasesCount</span>";
                                    }
                                    else
                                    {
                                        echo  "<span class=\"badge badge-success\">$pendingCasesCount</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/RelinquishmentCoController/getAllPendingRelinquishmentCasesCo'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                                <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                                <td class="rezaText"><?php echo $this->lang->line('relinquishment2ndPro') ?></td>
                                <td>
                                    <?php
                                    if ($lmForwardToCoCount != '0')
                                    {
                                        echo  "<span class=\"badge badge-danger\">$lmForwardToCoCount</span>";
                                    }
                                    else
                                    {
                                        echo  "<span class=\"badge badge-success\">$lmForwardToCoCount</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/RelinquishmentCoController/getAllForwardedByLmToCoCases'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                </td>
                            </tr>

                        <?php endif; ?>
                        <?php if($this->session->userdata('user_desig_code')== MB_DEPUTY_COMM): ?>
                            <tr>
                                <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                                <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                                <td class="rezaText"><?php echo $this->lang->line('relinquishment1stPro') ?></td>
                                <td>
                                    <?php
                                    if ($pendingCasesCount != '0')
                                    {
                                        echo  "<span class=\"badge badge-danger\">$pendingCasesCount</span>";
                                    }
                                    else
                                    {
                                        echo  "<span class=\"badge badge-success\">$pendingCasesCount</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/RelinquishmentDcController/getAllPendingRelinquishmentCasesDc'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                                <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                                <td class="rezaText">Pending For Hearing </td>
                                <td>
                                    <?php
                                    if ($noticeCasesCount != '0')
                                    {
                                        echo  "<span class=\"badge badge-danger\">$noticeCasesCount</span>";
                                    }
                                    else
                                    {
                                        echo  "<span class=\"badge badge-success\">$noticeCasesCount</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/RelinquishmentDcController/getAllNoticeRelinquishmentCasesDc'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                                <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                                <td class="rezaText">Pending For Final Order</td>
                                <td>
                                    <?php
                                    if ($finalCasesCount != '0')
                                    {
                                        echo  "<span class=\"badge badge-danger\">$finalCasesCount</span>";
                                    }
                                    else
                                    {
                                        echo  "<span class=\"badge badge-success\">$finalCasesCount</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/RelinquishmentDcController/getAllPendingForFinalOrderRelinquishmentCasesDc'; ?>" style="float:right">
                                        <i class="fa fa-eye"></i>&nbsp;view
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
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


</script>





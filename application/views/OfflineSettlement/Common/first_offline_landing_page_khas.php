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
<div class="row" style='padding: 20px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            <?php echo $this->lang->line('offlineSettlementSidebar') ?> /
            <a href="<?= base_url()?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas">
                Khas Land
            </a>
            <a href="<?= base_url()?>index.php/Home/index">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>

        <?php $slNo = 0; ?>
        <?php $stepNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('offlineSettlementKhasLandTitle') ?></span>
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

                    <?php if(in_array($this->session->userdata('user_desig_code'),OFFLINE_SETTLEMENT_REGISTER_ACCESS)): ?>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                            <td class="rezaText"><?php echo $this->lang->line('offlineSettlementApply') ?></td>
                            <td>
                                <span class="badge badge-success">0</span>
                            </td>
                            <td>
                                <a class="rezaButt buttPrimary" href="<?php echo base_url() . 'index.php/OfflineSettlementRegisterController/registerOfflineCaseCommonKhas'; ?>" style="float:right">
                                    <i class="fa fa-pencil-square-o"></i>&nbsp;Apply
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> --- </td>
                            <td class="rezaText"><?php echo $this->lang->line('offlineSettlementMy') ?></td>
                            <td>
                                <?php
                                if ($myApplicationCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$myApplicationCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$myApplicationCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/OfflineSettlementCommonController/getMyAppliedApplicationList'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if(in_array($this->session->userdata('user_desig_code'),OFFLINE_SETTLEMENT_PROCESS)):; ?>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                            <td class="rezaText">Make Meeting</td>
                            <td>
                                <?php
                                if ($meetingApplicationCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$meetingApplicationCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$meetingApplicationCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/OfflineSettlementCommonController/applicationListForMakeMeeting'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step <?php echo $stepNo += 1; ?></td>
                            <td class="rezaText"> Pending Meeting List</td>
                            <td>
                                <?php
                                if ($pendingMeetingCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$pendingMeetingCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$pendingMeetingCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt buttInfo" href="<?php echo base_url() . 'index.php/OfflineSettlementCommonController/offlinePendingMeetingList'; ?>" style="float:right">
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


</script>



<?php //if(in_array($this->session->userdata('user_desig_code'),OFFLINE_SETTLEMENT_FIRST_REPORT)): ?>
<!--    <tr>-->
<!--        <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
<!--        <td class="rezaText">Step --><?php //echo $stepNo += 1; ?><!--</td>-->
<!--        <td class="rezaText">--><?php //echo $this->lang->line('offlineSettlementPenView') ?><!--</td>-->
<!--        <td>-->
<!--            --><?php
//            if ($pendingApplicationCount != '0')
//            {
//                echo  "<span class=\"badge badge-danger\">$pendingApplicationCount</span>";
//            }
//            else
//            {
//                echo  "<span class=\"badge badge-success\">$pendingApplicationCount</span>";
//            }
//            ?>
<!--        </td>-->
<!--        <td>-->
<!--            <a class="rezaButt buttInfo" href="--><?php //echo base_url() . 'index.php/OfflineSettlementLMController/getPendingApplicationListLM'; ?><!--" style="float:right">-->
<!--                <i class="fa fa-eye"></i>&nbsp;view-->
<!--            </a>-->
<!--        </td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
<!--        <td class="rezaText">Step --><?php //echo $stepNo += 1; ?><!--</td>-->
<!--        <td class="rezaText">--><?php //echo $this->lang->line('offlineSettlementRevList') ?><!--</td>-->
<!--        <td>-->
<!--            --><?php
//            if ($revertedApplicationCount != '0')
//            {
//                echo  "<span class=\"badge badge-danger\">$revertedApplicationCount</span>";
//            }
//            else
//            {
//                echo  "<span class=\"badge badge-success\">$revertedApplicationCount</span>";
//            }
//            ?>
<!--        </td>-->
<!--        <td>-->
<!--            <a class="rezaButt buttInfo" href="--><?php //echo base_url() . 'index.php/OfflineSettlementLMController/getRevertedApplicationListLM'; ?><!--" style="float:right">-->
<!--                <i class="fa fa-eye"></i>&nbsp;view-->
<!--            </a>-->
<!--        </td>-->
<!--    </tr>-->
<!---->
<?php //endif; ?>
<?php //if(in_array($this->session->userdata('user_desig_code'),OFFLINE_SETTLEMENT_PROCESS)): ?>
<!---->
<!--    --><?php //if($this->session->userdata('user_desig_code') == MB_CIRCLE_OFFICER): ?>
<!--        <tr>-->
<!--            <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
<!--            <td class="rezaText">Step --><?php //echo $stepNo += 1; ?><!--</td>-->
<!--            <td class="rezaText">--><?php //echo $this->lang->line('offlineSettlementPenView') ?><!--</td>-->
<!--            <td>-->
<!--                --><?php
//                if ($pendingApplicationCount != '0')
//                {
//                    echo  "<span class=\"badge badge-danger\">$pendingApplicationCount</span>";
//                }
//                else
//                {
//                    echo  "<span class=\"badge badge-success\">$pendingApplicationCount</span>";
//                }
//                ?>
<!--            </td>-->
<!--            <td>-->
<!--                <a class="rezaButt buttInfo" href="--><?php //echo base_url() . 'index.php/OfflineSettlementCoController/getPendingApplicationListCo'; ?><!--" style="float:right">-->
<!--                    <i class="fa fa-eye"></i>&nbsp;view-->
<!--                </a>-->
<!--            </td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
<!--            <td class="rezaText">Step --><?php //echo $stepNo += 1; ?><!--</td>-->
<!--            <td class="rezaText">--><?php //echo $this->lang->line('offlineSettlementReReportList') ?><!--</td>-->
<!--            <td>-->
<!--                --><?php
//                if ($reReportApplicationCount != '0')
//                {
//                    echo  "<span class=\"badge badge-danger\">$reReportApplicationCount</span>";
//                }
//                else
//                {
//                    echo  "<span class=\"badge badge-success\">$reReportApplicationCount</span>";
//                }
//                ?>
<!--            </td>-->
<!--            <td>-->
<!--                <a class="rezaButt buttInfo" href="--><?php //echo base_url() . 'index.php/OfflineSettlementCoController/getReReportApplicationListCo'; ?><!--" style="float:right">-->
<!--                    <i class="fa fa-eye"></i>&nbsp;view-->
<!--                </a>-->
<!--            </td>-->
<!--        </tr>-->
<!--    --><?php //endif; ?>
<!--    --><?php //if($this->session->userdata('user_desig_code') == MB_SUB_DIV_COMM): ?>
<!--        <tr>-->
<!--            <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
<!--            <td class="rezaText">Step --><?php //echo $stepNo += 1; ?><!--</td>-->
<!--            <td class="rezaText">--><?php //echo $this->lang->line('offlineSettlementPenView') ?><!--</td>-->
<!--            <td>-->
<!--                --><?php
//                if ($pendingApplicationCount != '0')
//                {
//                    echo  "<span class=\"badge badge-danger\">$pendingApplicationCount</span>";
//                }
//                else
//                {
//                    echo  "<span class=\"badge badge-success\">$pendingApplicationCount</span>";
//                }
//                ?>
<!--            </td>-->
<!--            <td>-->
<!--                <a class="rezaButt buttInfo" href="--><?php //echo base_url() . 'index.php/OfflineSettlementSdoController/getPendingApplicationListSdo'; ?><!--" style="float:right">-->
<!--                    <i class="fa fa-eye"></i>&nbsp;view-->
<!--                </a>-->
<!--            </td>-->
<!--        </tr>-->
<!--    --><?php //endif; ?>
<!---->
<?php //endif; ?>


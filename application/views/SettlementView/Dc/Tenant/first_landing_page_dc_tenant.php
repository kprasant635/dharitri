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
        <?php $slNo = 0;?>
        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                <hr>
                <div class="row">
                    <div class="col-12 text-center">
                        <span class="alert-success">
                        <?php echo $this->session->flashdata('message'); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Process Name</th>
                        <th>Total No. Case</th>
                        <th style="width: 200px; text-align:center!important;" >Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"><?php echo $this->lang->line('1st_proceeding') ?></td>
                        <td>
                            <?php
if ($firstProceedingCount != '0') {
    echo "<span class=\"badge badge-danger\">$firstProceedingCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$firstProceedingCount</span>";
}
?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/viewAllApFirstProceedingDCCaseList'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">Send to ADC for Hearing</td>
                        <td>
                            <?php
if ($noticeGeneratedAdcHearingCount != '0') {
    echo "<span class=\"badge badge-danger\">$noticeGeneratedAdcHearingCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$noticeGeneratedAdcHearingCount</span>";
}
?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/noticeGeneratedAdcHearingCases'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">ADC forwarded cases/Generate payment notice</td>
                        <td>
                            <?php
if ($generatePaymentNoticeCount != '0') {
    echo "<span class=\"badge badge-danger\">$generatePaymentNoticeCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$generatePaymentNoticeCount</span>";
}
?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/paymentNoticeCases'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <!-- <tr>
                        <td class="rezaText"><?php //echo $slNo += 1; ?>.</td>
                        <td class="rezaText"><?php echo $this->lang->line('reReportByCO') ?></td>
                        <td>
                            <?php
if ($reReportByCOCount != '0') {
    echo "<span class=\"badge badge-danger\">$reReportByCOCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$reReportByCOCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/getAllReReportAppByCOForDcAppTenant'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr> -->
                    <!---->
                    <!--                    <tr>-->
                    <!--                        <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
                    <!--                        <td class="rezaText">--><?php //echo $this->lang->line('revertedByDept') ?><!--</td>-->
                    <!--                        <td>-->
                    <!--                            --><?php
//                            if ($revertedByDepartmentCount != '0')
//                            {
//                                echo  "<span class=\"badge badge-danger\">$revertedByDepartmentCount</span>";
//                            }
//                            else
//                            {
//                                echo  "<span class=\"badge badge-success\">$revertedByDepartmentCount</span>";
//                            }
//                            ?>
                    <!--                        </td>-->
                    <!--                        <td>-->
                    <!--                            <a class="rezaButt" href="--><?php //echo base_url() . 'index.php/SettlementTenantDc/getAllRevertedAppByDeptForDcAppTenant'; ?><!--" style="float:right">-->
                    <!--                                <i class="fa fa-eye"></i>&nbsp;view-->
                    <!--                            </a>-->
                    <!--                        </td>-->
                    <!--                    </tr>-->
                    <!---->
                    <!--                    <tr>-->
                    <!--                        <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
                    <!--                        <td class="rezaText">--><?php //echo $this->lang->line('caseStatus') ?><!--</td>-->
                    <!--                        <td>-->
                    <!--                            --><?php
//                            if ($caseStatusCount != '0')
//                            {
//                                echo  "<span class=\"badge badge-danger\">$caseStatusCount</span>";
//                            }
//                            else
//                            {
//                                echo  "<span class=\"badge badge-success\">$caseStatusCount</span>";
//                            }
//                            ?>
                    <!--                        </td>-->
                    <!--                        <td>-->
                    <!--                            <a class="rezaButt" href="--><?php //echo base_url() . 'index.php/SettlementCommonDc/getCaseSearchCommon'; ?><!--" style="float:right">-->
                    <!--                                <i class="fa fa-eye"></i>&nbsp;view-->
                    <!--                            </a>-->
                    <!--                        </td>-->
                    <!--                    </tr>-->

                    <!-- <tr>
                        <td class="rezaText"><?php //echo $slNo += 1; ?>.</td>
                        <td class="rezaText"><?php echo $this->lang->line('approvedList') ?></td>
                        <td>
                            <?php
if ($approvedListCount != '0') {
    echo "<span class=\"badge badge-danger\">$approvedListCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$approvedListCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/getAllApprovedBySDLACListTenant'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr> -->
                    <!---->
                    <!-- <tr>
                        <td class="rezaText"><?php //echo $slNo += 1; ?>.</td>
                        <td class="rezaText"><?php echo $this->lang->line('rejectedLis') ?></td>
                        <td>
                            <?php
if ($rejectedListCount != '0') {
    echo "<span class=\"badge badge-danger\">$rejectedListCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$rejectedListCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/getAllRejectByDcListTenant'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr> -->

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            <!-- <?php echo $this->lang->line('chithaUpdating') ?> -->
                           Payment confimation (Applicant )
                        </td>
                        <td>
                            <?php
if ($paymentConfirmCount != '0') {
    echo "<span class=\"badge badge-danger\">$paymentConfirmCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$paymentConfirmCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/getAllOrderChithaUpdateForDcAppTenant'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            <!-- <?php echo $this->lang->line('chithaUpdating') ?> -->
                           Generate Villagewise notice
                        </td>
                        <td>
                            <?php
if ($genExlReportCount != '0') {
    echo "<span class=\"badge badge-danger\">$genExlReportCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$genExlReportCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/AllApplicantPaymentConfirmedCasesForNotice'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            <!-- <?php echo $this->lang->line('chithaUpdating') ?> -->
                           Generate Excel Report (For Beneficiary)
                        </td>
                        <td>
                            <?php
if ($genExlReportCount != '0') {
    echo "<span class=\"badge badge-danger\">$genExlReportCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$genExlReportCount</span>";
}
?>
                        </td>
                        <td>
                            <!-- <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/AllApplicantPaymentConfirmedCases'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a> -->
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            <!-- <?php echo $this->lang->line('chithaUpdating') ?> -->
                            Re-generate excel Report/Confirm paid status (To owner)

                        </td>
                        <td>
                            <?php
if (isset($lotCount->count)) {
    if ($lotCount->count != '0') {
        echo "<span class=\"badge badge-danger\">$lotCount->count</span>";
    } else {
        echo "<span class=\"badge badge-success\">$lotCount->count</span>";
    }
}
?>
                        </td>
                        <td>
                            <!-- <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTenantDc/excelGeneratedCases'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a> -->
                        </td>
                    </tr>


                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <!-- <td class="rezaText"> -- </td> -->
                        <td class="rezaText">Rejected By DC</td>
                        <td>
                            <?php
if ($rejctedListCount != '0') {
    echo "<span class=\"badge badge-danger\">$rejctedListCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$rejctedListCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDC/rejectedList?service=' . SETTLEMENT_TENANT_ID . '&s=D&office=' . MB_DEPUTY_COMM; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <!-- <td class="rezaText"> -- </td> -->
                        <td class="rezaText">Case Revival List</td>
                        <td>
                            <?php
if ($revivalListCount != '0') {
    echo "<span class=\"badge badge-danger\">$revivalListCount</span>";
} else {
    echo "<span class=\"badge badge-success\">$revivalListCount</span>";
}
?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementMbCo/coRevivalCases?service=' . SETTLEMENT_TENANT_ID . '&s=D'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

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
</script>


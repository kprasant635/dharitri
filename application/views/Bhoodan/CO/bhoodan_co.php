<style>
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }

    .rezaButt:hover {
        color: #0c0c0c;
    }

    .rezaButt {
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

    .road-map-main {
        margin: 50px 0 51px;
    }

    .road-map-main .road-map-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 175px;
    }

    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper {
            margin-bottom: 25px;
            height: auto;
            display: block;
        }
    }

    .road-map-main .road-map-wrapper::before {
        content: "";
        width: 100%;
        clear: both;
        display: block;
    }

    .road-map-main .road-map-wrapper::after {
        content: "";
        width: 100%;
        clear: both;
        display: block;
    }

    .road-map-main .road-map-wrapper .road-map-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 25px solid transparent;
        border-top-color: #7a7bd7;
        border-right-color: #7a7bd7;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        transform: rotate(45deg);
    }

    @media (max-width: 992px) {
        .road-map-main .road-map-wrapper .road-map-circle {
            position: unset;
            border: 25px solid #7a7bd7;
        }
    }

    .road-map-main .road-map-wrapper .road-map-circle .road-map-circle-text {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background-color: #eb0d0de0;
        font-size: 20px;
        font-weight: 600;
        line-height: 26px;
        text-transform: capitalize;
        color: #fff;
        box-shadow: 0px 0px 10px 5px #00000021;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        transform: rotate(-45deg);
    }

    .road-map-main .road-map-wrapper .road-map-card {
        width: 35%;
        background: #7a7bd7;
        padding: 20px 20px;
        z-index: 1;
        position: absolute;
        right: 0;
        border-radius: 5px;
    }

    .road-map-main .road-map-wrapper .road-map-card::before {
        content: "";
        width: 25%;
        height: 20px;
        background: #7a7bd7;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: -23%;
        z-index: -1;
    }

    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper .road-map-card {
            width: 100%;
            margin-top: 30px;
            position: unset;
        }

        .road-map-main .road-map-wrapper .road-map-card::before {
            content: "";
            width: 20px;
            height: 30%;
            top: 50%;
            transform: translateX(-50%);
            left: 50%;
        }
    }

    @media (max-width: 425px) {
        .road-map-main .road-map-wrapper .road-map-card {
            top: 45%;
        }
    }

    .road-map-main .road-map-wrapper .road-map-card .card-head {
        font-size: 20px;
        font-weight: 600;
        text-transform: capitalize;
        margin: 0 0 15px;
        color: #fff;
    }

    .road-map-main .road-map-wrapper .road-map-card .card-text {
        color: #fff;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 1199px) {
        .road-map-main .road-map-wrapper .road-map-card .card-text {
            -webkit-line-clamp: 4;
        }
    }

    .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-circle {
        border-bottom-color: #7a7bd7;
        border-left-color: #7a7bd7;
        border-top-color: transparent;
        border-right-color: transparent;
    }

    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-circle {
            border-color: #7a7bd7;
        }
    }

    .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card {
        left: 0;
    }

    .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card::before {
        right: -23%;
        left: unset;
    }

    @media (max-width: 991px) {
        .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card::before {
            content: "";
            width: 20px;
            height: 30%;
            top: 50%;
            transform: translateX(-50%);
            left: 50%;
        }
    }

    @media (max-width: 425px) {
        .road-map-main .road-map-wrapper:nth-of-type(even) .road-map-card::before {
            top: 45%;
        }
    }
</style>

<!--<div class="col-lg-12 col-md-12 col-sm-12" align="right" style="padding: 18px 20px 0px 0px">-->
<!--    <button class="rezaButt buttDanger" id="applicationProcessForCOModalMb2">-->
<!--        <i class="fa fa-arrows" aria-hidden="true"></i>-->
<!--        Application Process Flow-->
<!--    </button>-->
<!--</div>-->

<!-- Modal Application Approve by SDLAC -->
<div class="modal" role="dialog" id="applicationProcessModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <span style="color:red"> Application process flow for CO end</span>
                </h5>
                <i class="fa fa-close fa-2x text-red modalHide" style="cursor:pointer;"></i>
            </div>
            <div class="modal-body" align="">
                <div class="modal-body" align="center">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="road-map-main">
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 1
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">First Proceeding</h4>
                                        <p class="card-text">
                                            Check & verify LM report
                                            <br>
                                            if all ok then Generate general notice
                                            <br>
                                            if not then Revert back to LM
                                        </p>
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 2
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Second Proceeding</h4>
                                        <p class="card-text">
                                            After Generate general notice, Case forwarded to DC for NR
                                        </p>
                                    </div>
                                </div>

                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 3
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">NR to Settlement</h4>
                                        <p class="card-text">
                                            Check case proceedings, if DC approved as NR then forward the case to ADC/SDO for settlement
                                        </p>
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 4
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Payment Notice After approval from Department/DC</h4>
                                        <p class="card-text">
                                            Check & generate payment notice
                                        </p>
                                    </div>
                                </div>

                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 5
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Payment Notice Confirmation</h4>
                                        <p class="card-text">
                                            Check payment status if applicant paid the amount then update the Chitha Records
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 6
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Re-Report By LM/SK</h4>
                                        <p class="card-text">
                                            Check & verify LM re-report cases
                                            <br>
                                            if all ok then forward to ADC/SDO
                                            <br>
                                            if not then Revert back to LM
                                        </p>
                                    </div>
                                </div>
                                <div class="road-map-wrapper">
                                    <div class="road-map-circle">
                                        <span class="road-map-circle-text d-flex align-items-center justify-content-center">
                                            Step 7
                                        </span>
                                    </div>
                                    <div class="road-map-card">
                                        <h4 class="card-head">Reverted by DC/ADC</h4>
                                        <p class="card-text">
                                            Check reverted cases from DC/ADC/SDO

                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" id="approveRemarksSDLAC" required minlength="1" readonly>
                <input type="hidden" id="minutesProposalId" required readonly>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modalHide">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<div class="row p-4" style='margin-top:40px'>
    <div class="col-md-12">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular">
                        <?= BHODDAN_SERVICE_NAME ?>
                    </p>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-hover">


                    <tr class="">
                        <td>First Proceeding</td>
                        <td>
                            <?php
                            if ($first != '0') {
                                echo "<span class=\"badge badge-danger\">$first</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/BhoodanControllerCo/FirstProceeding?service=' . $service_code . '&s=' . MB_PENDING; ?>" style="float:right">View</a>
                        </td>
                    </tr>
                    <?php
                    if ($user_desig_code != 'SK') {
                    ?>

                        <tr>
                            <td><?php echo $this->lang->line('payment_notice_co') ?></td>
                            <td><?php
                                if ($payment_notice != '0') {
                                    echo "<span class=\"badge badge-danger\">$payment_notice</span>";
                                }
                                ?></td>
                            <td><a href="<?php echo base_url() . 'index.php/BhoodanControllerCo/paymentNoticeCo?service=' . $service_code . '&s=' . MB_PAYMENT_REQUEST; ?>" style="float:right">view</a></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->lang->line('payment_notice_confirmation') ?></td>
                            <td><?php
                                if ($payment_confirm != '0') {
                                    echo "<span class=\"badge badge-danger\">$payment_confirm</span>";
                                }
                                ?></td>
                            <td><a href="<?php echo base_url() . 'index.php/BhoodanControllerCo/paymentNoticeCofirmationCases?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE; ?>" style="float:right">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>


                    <tr>
                        <td>Re-Report By LRA</td>
                        <td><?php
                            if ($user_desig_code == 'SK') {
                                if ($re_report_lm_sk != '0') {
                                    echo "<span class=\"badge badge-danger\">$re_report_lm_sk</span>";
                                }
                            } else {
                                if ($re_report_lm != '0') {
                                    echo "<span class=\"badge badge-danger\">$re_report_lm</span>";
                                }
                            }
                            ?>
                        </td>
                        <td><a href="<?php echo base_url() . 'index.php/BhoodanController/coReSubmitLmCases?service=' . $service_code . '&s=' . MB_RE_REPORT; ?>" style="float:right">view</a></td>
                    </tr>
                    <?php
                    if ($user_desig_code != 'SK') {
                    ?>
                        <tr>
                            <td><?php echo $this->lang->line('reverted_by_dc') ?></td>
                            <td><?php
                                if ($reverted_by_dc != '0') {
                                    echo "<span class=\"badge badge-danger\">$reverted_by_dc</span>";
                                }
                                ?></td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/dcRevertedCases?service=' . $service_code . '&s=' . MB_REVERT; ?>" style="float:right">view</a></td>
                        </tr>

                        <tr>
                            <td>Reverted Cases to LRA</td>
                            <td><?php
                                if ($reverted_by_co != '0') {
                                    echo "<span class=\"badge badge-danger\">$reverted_by_co</span>";
                                }
                                ?></td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/coRevertedCases?service=' . $service_code . '&s=' . MB_REVERT . '&reverted=LM' ?>" style="float:right">view</a></td>
                        </tr>


                        <tr>
                            <td>Forwarded Cases from CO</td>
                            <td><?php
                                if ($forwarded_to_adc != '0') {
                                    echo "<span class=\"badge badge-danger\">$forwarded_to_adc</span>";
                                }
                                ?></td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/coForwardedCases?service=' . $service_code . '&s=' . MB_PENDING . '&reverted=ADC' ?>" style="float:right">view</a></td>
                        </tr>



                        <tr>
                            <td>Case list for Re-Geotag</td>
                            <td></td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementKhasCo/reGeoTagCaseList?service=' . $service_code; ?>" style="float:right">view</a></td>
                        </tr>

                        <!-- RE_GEOTAG --------14092023-->






                    <?php } ?>

                    <?php
                    if ($user_desig_code == 'CO') {
                        if (PARTIAL_PAYMENT_CONFIRMATION != 0) {
                    ?>
                            <tr>
                                <td class="text-success"><b>PARTIAL PAYMENT CONFIRMATION (Paid via Challan)</b></td>
                                <td>
                                    <?php
                                    if ($bulk_chitha_update != '0') {
                                        echo "<span class=\"badge badge-danger\">$bulk_chitha_update</span>";
                                    }
                                    ?>
                                </td>

                                <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/partialPaymentConfirmationList?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE ?>" style="float:right">view</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>

                    <?php
                    if ($user_desig_code == 'CO' && PREMIUM_RECALCULATE_AND_REGENERATE_NOTICE != 0) {
                    ?>
                        <tr>
                            <td class="text-secondary"><b>Re-calculate Premium and Re-Generate Premium notice</b></td>
                            <td>
                                <?php
                                if ($re_generate_premium_notice != '0') {
                                    echo "<span class=\"badge badge-danger\">$re_generate_premium_notice</span>";
                                }
                                ?>
                            </td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/premiumNoticeRegenList?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE ?>" style="float:right">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                    <?php
                    if ($user_desig_code == 'CO' && PREMIUM_NOTICE_30_PERCENT != 0) {
                    ?>
                        <!-- <tr>
                                    <td class="text-secondary"><b>Generate premium notice for partial payment cases</b></td>
                                    <td>
                                        <?php
                                        if ($remain_amt_prem_notice != '0') {
                                            echo "<span class=\"badge badge-danger\">$remain_amt_prem_notice</span>";
                                        }
                                        ?>
                                    </td>

                                    <td><a href="<?php echo base_url() . 'index.php/SettlementCommon/partialNoticeList?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE ?>" style="float:right">view</a></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary"><b>Print premium notice for partial payment cases</b></td>
                                    <td>
                                        <?php
                                        if ($print_partial_notice != '0') {
                                            echo "<span class=\"badge badge-danger\">$print_partial_notice</span>";
                                        }
                                        ?>
                                    </td>

                                    <td><a href="<?php echo base_url() . 'index.php/SettlementCommon/printPartialNoticeCases?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE ?>" style="float:right">view</a></td>
                                </tr> -->
                    <?php
                    }
                    ?>

                    <?php
                    if ($user_desig_code == 'CO') {
                    ?>
                        <!-- <tr>
                                <td class="text-danger"><b>CHITHA UPDATE</b></td>
                                <td>
                                    <?php
                                    if ($bulk_chitha_update != '0') {
                                        echo "<span class=\"badge badge-danger\">$bulk_chitha_update</span>";
                                    }
                                    ?>
                                </td>

                                <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/chithaBulkList?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE ?>" style="float:right">view</a></td>
                            </tr> -->

                        <?php
                        if (PARTIAL_PAYMENT_CHITHA_UPDATE != CLOSE) {
                        ?>
                            <tr>
                                <td class="text-danger"><b>CHITHA UPDATE (PARTIAL PAYMENTS)</b></td>
                                <td>
                                    <?php
                                    if ($bulk_chitha_update_partial != '0') {
                                        echo "<span class=\"badge badge-danger\">$bulk_chitha_update_partial</span>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() . 'index.php/SettlementMbCo/chithaBulkListPartial?service=' . $service_code . '&s=' . MB_PAYMENT_NOTICE ?>" style="float:right">view</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <!-- ***************************************************** -->
                    <?php
                    if ($user_desig_code == 'CO' && ENABLE_SETTLEMENT_MANUAL_INSTALLMENT_PAYMENT == 1) {
                    ?>
                        <tr>
                            <td class="text-primary"><b>INSTALLMENT PAYMENT UPDATION(MANUAL)</b></td>
                            <td></td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementInstallmentController/getInstallmentPaymentList?service=' . $service_code ?>" style="float:right" target="_dueInsPayCaseList">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                    <?php
                    if ($user_desig_code == 'CO' && ENABLE_PAYMENT_GRN_UPDATE == 1) {
                    ?>
                        <tr>
                            <td class="text-primary"><b>UPDATE GRN</b></td>
                            <td></td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/grnUpdateList?service=' . $service_code ?>" style="float:right" target="_dueInsPayCaseList">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <!-- ***************************************************** -->


                    <?php
                    if ($user_desig_code == 'CO' && MB2_REVIEW == 1) {
                    ?>
                        <tr>
                            <td><b>Review Applications</b></td>
                            <td></td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementReviewController/reviewCaseList?service=' . $service_code ?>" style="float:right" target="_dueInsPayCaseList">view</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>

</div>
<style>
    /* modal css */
    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 90%;
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

<div class="modal" role="dialog" id="apModal" style="padding-top: 25px!important;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">AP Notice Generated Cases</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><a href="<?= base_url() . 'index.php/SettlementMbCo/apNoticeGenertaedCases?service=14&s=V&notice=30' ?>">Notice Period Already Completed</a> (<?= $notice_already_completed->count ?>)</p>


                <p><a href="<?= base_url() . 'index.php/SettlementMbCo/apNoticeGenertaedCases?service=14&s=V&notice=2' ?>">Notice Period to be completed in 2 days</a> (<?= $to_be_completed_2days->count ?>)</p>


                <p><a href="<?= base_url() . 'index.php/SettlementMbCo/apNoticeGenertaedCases?service=14&s=V&notice=1' ?>">Notice Period to be completed in 1 day</a> </a> (<?= $to_be_completed_1day->count ?>)</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default closeAp" data-dismiss="modal">Close</button>
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


    // application process flow




    $(document).on('click', '#applicationProcessForCOModalMb2', function() {
        $('#applicationProcessModal').modal('show');
    });
    $(document).on('click', '.modalHide', function() {
        $('#applicationProcessModal').modal('hide');
    });

    var span = document.getElementsByClassName("close")[0];
    var apModal = document.getElementById("apModal");

    function apNoticeModal() {

        apModal.style.display = "block";

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            apModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == apModal) {
                apModal.style.display = "none";
            }
        }

    }
    $(document).on('click', '.closeAp', function() {
        apModal.style.display = "none";
    });

    <?php
    if ($_GET['service'] == '14') { ?>

        $(window).load(function() {
            apNoticeModal();
        });
    <?php } ?>
</script>
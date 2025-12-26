<div class="row" style='margin-top:40px'>
    <div class="col-lg-12">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class="regular"><?php echo $this->lang->line('settlement_tenant_urban') ?></p>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                
                    <?php 
                    if ($user_desig_code == 'CO') {
                    ?>

                    <tr class="">
                        <td>Case Registration</td>

                        <td>
                            <?php
                                if ($new_reg_count != '0' || $new_reg_count != '0') {
                                    echo "<span class=\"badge badge-danger\">$new_reg_count</span>";
                                }
                                ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/SettlementTenantCoUrban/initLanding?service=' . $service_code . '&s=' . TENANT_URBAN_INITIAL_STAT; ?>" style="float:right">view</a>
                        </td>
                    </tr>
                    <?php }?>

                    <tr class="">
                        <td><?php echo $this->lang->line('1st_proceeding') ?></td>

                        <td>
                            <?php
                                if ($first != '0' || $sk_first != '0') {
                                    if ($user_desig_code == 'SK') {
                                        echo "<span class=\"badge badge-danger\">$sk_first</span>";
                                    } else {
                                        echo "<span class=\"badge badge-danger\">$first</span>";
                                    }
                                }
                                ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'index.php/SettlementTenantCoUrban/FirstProceeding?service=' . $service_code . '&s=' . MB_PENDING; ?>" style="float:right">view</a>
                        </td>
                    </tr>

                    <?php
if ($user_desig_code != 'SK') {
    ?>
                        <tr>
                            <td>Re-report by LM/SK</td>
                            <td><?php
if ($re_report_lm_co != '0') {
        echo "<span class=\"badge badge-danger\">$re_report_lm_co</span>";
    }
    ?>
                            </td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/coReSubmitLmTenantCases?service=' . $service_code . '&s=' . MB_RE_REPORT; ?>" style="float:right">view</a></td>
                        </tr>

                        <tr>
                            <td>Rejected by CO</td>
                            <td><?php
if ($rejected_by_co != '0') {
        echo "<span class=\"badge badge-danger\">$rejected_by_co</span>";
    }
    ?></td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/coRejectCases?service=' . $service_code . '&s=' . MB_DISMISS ?>" style="float:right">view</a></td>
                        </tr>

                        <tr>
                            <td>Revival flag list</td>
                            <td><?php
if ($revival_flag_list != '0') {
        echo "<span class=\"badge badge-danger\">$revival_flag_list</span>";
    }
    ?></td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/coRevivalCases?service=' . $service_code . '&s=' . 'RRV1' ?>" style="float:right">view</a></td>
                        </tr>


                    <?php
}
?>

                    <?php
if ($user_desig_code == 'SK') {
    ?>
                        <tr>
                            <td>Re-report by LM/SK</td>
                            <td><?php
if ($re_report_lm_sk != '0') {
        echo "<span class=\"badge badge-danger\">$re_report_lm_sk</span>";
    }
    ?>
                            </td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/coReSubmitLmTenantCases?service=' . $service_code . '&s=' . MB_RE_REPORT; ?>" style="float:right">view</a></td>
                        </tr>
                    <?php
}?>

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

                    <?php
}
if ($user_desig_code == 'CO') {
    ?>
                        <tr>
                            <td class="text-danger"><b>CHITHA UPDATE</b></td>
                            <td>
                                <?php
if ($bulk_chitha_update != '0') {
        echo "<span class=\"badge badge-danger\">$bulk_chitha_update</span>";
    }
    ?>
                            </td>

                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/chithaBulkList?service=' . $service_code . '&s=P' ?>" style="float:right">view</a></td>
                        </tr>

                        <?php
}?>


                    <?php
if ($user_desig_code != 'SK') {
    ?>

                        <!-- <tr>
                            <td>Chitha Update</td>
                            <td><?php
if ($chitha != '0') {
        echo "<span class=\"badge badge-danger\">$chitha</span>";
    }
    ?></td>
                            <td><a href="<?php echo base_url() . 'index.php/SettlementMbCo/paymentNoticeCo?service=' . $service_code . '&s=' . MB_ORDER_FOR_CHITHA_UPDATE; ?>" style="float:right">view</a></td>
                        </tr> -->

                        <!-- <tr>
                            <td><?php //echo $this->lang->line('payment_notice_co') ?></td>
                            <td><?php
// if ($payment_notice != '0') {
    //     echo "<span class=\"badge badge-danger\">$payment_notice</span>";
    // }
    ?></td>
                            <td><a href="<?php //echo base_url() . 'index.php/SettlementMbCo/paymentNoticeCo?service='.$service_code.'&s='.MB_PAYMENT_REQUEST; ?>" style="float:right">view</a></td>
                        </tr>
                        <tr>
                            <td><?php //echo $this->lang->line('payment_notice_confirmation') ?></td>
                            <td><?php
//if ($payment_confirm != '0') {
    // echo "<span class=\"badge badge-danger\">$payment_confirm</span>";
    //}
    ?></td>
                            <td><a href="<?php //echo base_url() . 'index.php/SettlementMbCo/paymentNoticeCofirmationCases?service='.$service_code.'&s='//.MB_PAYMENT_NOTICE;; ?>" style="float:right">view</a></td>
                        </tr> -->

                    <?php
}?>

                    <tr>
                        <td>Case list for Re-Geotag</td>
                        <td></td>
                        <td><a href="<?php echo base_url() . 'index.php/SettlementKhasCo/reGeoTagCaseList?service=' . $service_code; ?>" style="float:right">view</a></td>
                    </tr>

                    <?php
                    if($user_desig_code == 'CO' && MB2_REVIEW==1)
                    {
                        ?>
                            <tr>
                                <td><b>Review Applications</b></td>    
                                <td></td>                            
                                <td><a href="<?php echo base_url() . 'index.php/SettlementReviewController/reviewCaseList?service='.$service_code?>" style="float:right" target="_dueInsPayCaseList">view</a></td>
                            </tr>
                        <?php
                    }
                    ?>

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
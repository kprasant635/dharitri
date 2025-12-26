<style>
    .casedisplay {
        min-height: 0px;
    }

    .casedisplay-small {
        min-height: 120px;
    }

    .casedisplay:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    td{
        font-size: .9em;
    }
</style>
<div class="container-fluid login home">
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        
        <div class="col-lg-12 ">
            <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> CIRCLE OFFICER'S DASHBOARD</label></td>
                    <td><?php include 'login_alert.php'; ?></td>
                </tr>
            </table>
            
            <div class="row">
                <?php include 'sro.php'; ?>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_mutation') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_fresh_order') ?></td>
                                    <td>
                                        <?php
                                        if ($mfirst_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$mfirst_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="pull-right green " href="<?php echo base_url() . 'index.php/coofficemutation/getPendingMutationCases?id=1'; ?>"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo $this->lang->line('co_next_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($msecond_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$msecond_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="pull-right green " href="<?php echo base_url() . 'index.php/coofficemutation/getPendingMutationCases?id=2'; ?>"><?php echo $this->lang->line('view') ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_resume_case') ?></td>
                                    <td></td>
                                    <td><a  class="pull-right green " href="#"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($proceedingMutRpt != '0') {
                                            echo "<span class=\"badge badge-primary\">$proceedingMutRpt</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right text-danger" href="<?php echo base_url() . 'index.php/coofficemutation/ActionTakenRpt'; ?>"><?php echo $this->lang->line('report') ?></a></td>
                                </tr>
                                <tr class="">
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_partition') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_fresh_order') ?></td>
                                    <td>
                                        <?php
                                        if ($FirstPro != '0') {
                                            echo "<span class=\"badge badge-primary\">$FirstPro</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/partition/CoPendingFirst'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_next_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($SecondPro != '0') {
                                            echo "<span class=\"badge badge-primary\">$SecondPro</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/partition/CoPendingSecond'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>


                                <tr>
                                    <td><?php echo $this->lang->line('co_resume_case') ?></td>
                                    <td></td>
                                    <td><a class="pull-right green " href="#"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?> </td>
                                    <td>
                                        <?php
                                        if ($proceedingPartRpt != '0') {
                                            echo "<span class=\"badge badge-primary\">$proceedingPartRpt</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/partition/ActionTakenRpt'; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class="">
                                    <td>Office Partition</td>
                                    <td>
                                        <?php
                                        if ($partchithaupdate != '0') {
                                            echo "<span class=\"badge badge-primary\">$partchithaupdate</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/Partition/MapPartitionUpdate' ?>" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_ofc_conversion') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_fresh_order') ?></td>
                                    <td>
                                        <?php
                                        if ($first_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$first_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_next_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($second_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$second_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td> All Revarted Cases By DC</td>
                                    <td>
                                        <?php
                                        if ($rejected_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$rejected_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=5"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_generate_proceeding') ?></td>
                                    <td>
                                        <?php
                                        if ($conversion_proceeding_report != '0') {
                                            echo "<span class=\"badge badge-primary\">$conversion_proceeding_report</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=4"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Waiting For Chitha Updation</td>
                                    <td>
                                        <?php
                                        if ($third_proceeding != '0') {
                                            echo "<span class=\"badge badge-primary\">$third_proceeding</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=6"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field cases- Mutation/Partition/OP-cancellation/MISCELLANEOUS CASES -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('co_field_mut_part') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_fmut'); ?> </td>
                                    <td>
                                        <?php
                                        if ($fmutation != '0') {
                                            echo "<span class=\"badge badge-primary\">$fmutation</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/cofieldmutation/getPendingFMCases";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_fpart'); ?> </td>
                                    <td>
                                        <?php
                                        if ($fpartition != '0') {
                                            echo "<span class=\"badge badge-primary\">$fpartition</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/cofieldmutation/getPendingpartitionCases";
                                    ?>
                                    <td><a class="pull-right green"  href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr class="">
                                    <td>Field Partition</td>
                                    <td>
                                        <?php
                                        echo "<span class=\"badge badge-primary\">$map_partition</span>";
                                        ?>
                                    </td>
                                    <td><a href="<?php echo base_url() . 'index.php/cofieldmutation/pendingmaps' ?>" style='float:right'><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_citizen_centric') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_verify_citizen') ?></td>
                                    <td>
                                        <?php
                                        if ($citizenPendingCO != '0') {
                                            echo "<span class=\"badge badge-primary\">$citizenPendingCO</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/CitizenController/COStep1";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_citizen_check_status') ?></td>
                                    <td></td>
                                    <td><a class="pull-right green" href="<?php echo base_url() . "index.php/CitizenController/CheckStatus" ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Final Order for Correction Of Land Records as per Civil Court</td>
                                    <td>
                                        <?php
//                                        if ($civil_appeal_basic != '0') {
//                                            echo "<span class=\"badge badge-primary\">$civil_appeal_basic</span>";
//                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/RecordCorrectionCivilCourt/copendingcaselist";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								<tr>
                                    <td>Final Order for Correction Of Land Records as per Civil Court</td>
                                    <td>
                                        <?php
//                                        if ($civil_appeal_basic != '0') {
//                                            echo "<span class=\"badge badge-primary\">$civil_appeal_basic</span>";
//                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/RecordCorrectionCivilCourt/copendingcaselist";
                                    ?>
                                    <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_misc_case') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Pending Name Correction</td>
                                    <td>
                                        <?php
                                        if ($MisCases != '0') {
                                            echo "<span class=\"badge badge-primary\">$MisCases</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/NameCorrection/COStep1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending Name Cancellation</td>
                                    <td>
                                        <?php
                                        if ($MisCasesNC != '0') {
                                            echo "<span class=\"badge badge-primary\">$MisCasesNC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/NameCancellation/COStep1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_objectpetition') ?></td>
                                    <td>
                                        <?php
                                        if ($pending_objection != '0') {
                                            echo "<span class=\"badge badge-primary\">$pending_objection</span>";
                                        }
                                        ?></td>
                                    <td><a class="pull-right green "  href="<?php echo base_url() . 'index.php/objection/COStep1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_misc_finalorder') ?></td>
                                    <td>
                                        <?php
                                        $FOMIS = count($FinalOrderMisc);
                                        if ($FOMIS != '0') {
                                            echo "<span class=\"badge badge-primary\">$FOMIS</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/NameCorrection/COFinalOrderMiscCase1' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- A.P cases / LAND RECLASSIFICATION / UPDATE CHITHA OPTIONS -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('asstt_annual_patta_canc') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_non_renewal_proceeding') ?></td>
                                    <td>
                                        <?php
                                        $CAPCOC = count($countAPCaseforCO);
                                        if ($CAPCOC != '0') {
                                            echo "<span class=\"badge badge-primary\">$CAPCOC</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/COAPStep1";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_recom_nrcase') ?></td>
                                    <td>
                                        <?php
                                        $CNH = count($countNoteHearingAPCaseforCO);
                                        if ($CNH != '0') {
                                            echo "<span class=\"badge badge-primary\">$CNH</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/COAPStep2_1";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_ap_orderpass') ?></td>
                                    <td>
                                        <?php
                                        $GOAPC = count($getOrderAPCancellation);
                                        if ($GOAPC != '0') {
                                            echo "<span class=\"badge badge-primary\">$GOAPC</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/APCancellation/COAPStep4_1";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>

                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular"><?php echo $this->lang->line('land_reclassification') ?></p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_reclass_recommen') ?></td>
                                    <td>
                                        <?php
                                        if ($land_proposals != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=1"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('co_reclass_dc_adc_approve') ?></td>
                                    <td>
                                        <?php
                                        if ($g_trans_for_dc != '0') {
                                            echo "<span class=\"badge badge-primary\">$g_trans_for_dc</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=2"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Reverted Back From DC / ADC</td>
                                    <td>
                                        <?php
                                        if ($land_proposals_returned_DC != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals_returned_DC</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=6"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Pending For Jamabandi Updation</td>
                                    <td>
                                        <?php
                                        if ($land_proposals_for_jamaupdate != '0') {
                                            echo "<span class=\"badge badge-primary\">$land_proposals_for_jamaupdate</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a  class="pull-right green"  href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=7"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Allotment Certificate to PP</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table hide table-striped table-hover">
                                <tr>
                                    <td><?php echo $this->lang->line('co_pending_object_petition') ?></td>
                                    <td>&nbsp;</td>
                                    <td><a class="pull-right green "   href="#"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                            </table>
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Write 1st Proceeding (Fresh)</td>
                                    <td>
                                        <?php
                                        if ($allotment_first != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_first</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green "   href="<?php echo base_url() . 'index.php/allotment/copendingfirstlist' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Write 2nd Proceeding</td>
                                    <td>
                                        <?php
                                        if ($allotment_second != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_second</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right green"   href="<?php echo base_url() . 'index.php/allotment/copendingseclist' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Proceeding Report of All Case(s)</td>
                                    <td>&nbsp;</td>
                                    <td><a class="pull-right green" href="<?php echo base_url() . 'index.php/allotment/proceeding' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                <tr>
                                    <td>Update AC to PP Passed By DC </td>
                                    <td>
                                        <?php
                                        if ($allotment_final != '0') {
                                            echo "<span class=\"badge badge-primary\">$allotment_final</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><a class="pull-right text-danger" href="<?php echo base_url() . 'index.php/allotment/cofinalpendingcase' ?>"><?php echo $this->lang->line('go') ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			<!-- 147 cases -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="panel casedisplay">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class="regular">Appeal Case U/S 147</p>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr class="">
                                    <td>Appeal Case 147 Passed By DC/ADC</td>
                                    <td></td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/Appealcase/copendingcaselist' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								<tr class="">
                                    <td>Appeal Case 147 Forward By LM</td>
                                    <td></td>
                                    <td><a class="pull-right green " href="<?php echo base_url() . 'index.php/Appealcase/coSecViewlist' ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
								
								<tr>
                                    <td>Record Correction Order</td>
                                    <td>
                                        <?php
                                        $CAPCOC = count($countAPCaseforCO);
                                        if ($CAPCOC != '0') {
                                            echo "<span class=\"badge badge-primary\">$CAPCOC</span>";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $link = base_url() . "index.php/Appealcase/orderCorrectCO";
                                    ?>
                                    <td><a class="pull-right green " href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                                </tr>
                                

                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>


        </div>
        <?php
        $change_password = $my_info->first_login;
        if ($change_password == 'Y'):
            ?> 
            <?php include 'first_login.php'; ?>
        <?php endif; ?>
    </div>
</div>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1' || $process == '2' || $process == '4' || $process == '6' || $process == '7' || $process=='11') {
                            echo $this->session->userdata('user_desig_code') ." pending Cases";
                        } elseif ($process == '3' || $process == '5' || $process == '8') {
                            echo $this->lang->line('dc_land_reclassification_cases');
                        }
                        ?>
                    </h2>
                </div>
            </div>

            <?php if($process == '1') { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <a href="<?=base_url().'index.php/home/LandReCo'?>">
                    <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
                </div>&nbsp;
            <?php } else if($process == '3' && $this->session->userdata('user_desig_code')=='ADC') { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <a href="<?=base_url().'index.php/home/ConversionAdc'?>">
                    <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
                </div>&nbsp;
            <?php } else if($process == '3' && $this->session->userdata('user_desig_code')=='DC') { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <a href="<?=base_url().'index.php/home/ConversionDc'?>">
                    <button type="button" class="btn btn-sm btn-danger pull-right"><< Go Back</button></a>
                </div>&nbsp;
            <?php } ?>


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body"z>
                        <?php
                        if ($process == '1') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>

                                    <tr>
                                        <?php if(ESCALATION_ENABLE == 1){ ?>
                                            <td><?=$case->escalation_zone?></td>
                                            <td><?=$case->escalation_date?></td>
                                        <?php } ?>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstCoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>">
                                                <?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <!-- <td><?php echo $case->case_no; ?></td> -->


                                    <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td> 
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                            <?php 
                                            if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                            {
                                                echo "Escalated to Appellate Authority";
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstCoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a>
                                        <?php   } ?>
                                        <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                        {?>

                                        <!-- property chain code -->
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReportRC btn btn-primary' style="margin:2px;">View Property Chain</button>
                                            <!--  -->

                                        <?php }?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
                        elseif ($process == '2') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><span style="color: red;"><?php echo "Proposal No : " . $case->proposal_no; ?></span></td>
                                        <td><?php echo $case->case_no; ?>
                                            <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">Pending for DC's approval &nbsp;</td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
						
						
						
						elseif (($process == '3')) {
							
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <?php if(ESCALATION_ENABLE == 1){ ?>
                                            <td><?=$case->escalation_zone?></td>
                                            <td><?=$case->escalation_date?></td>
                                        <?php } ?>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?>
                                           <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span> 
                                        </td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <?php if($case->date_entry!=null){?>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <?php }else{?>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?>
                                        </td>
                                        <?php }?>
                                        <td class="center">

                                        <?php 
                                            if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                            {
                                                echo "Escalated to Appellate Authority";
                                            }
                                            else
                                            {
                                        ?>

                                                <a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a>
                                        <?php } ?>

                                        <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                        {?>
                                         <!--////////////////// property chain report ///////////////////-->
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReportRC btn btn-primary' style="margin:2px;">View Property Chain</button>

                                            <!-- ///////////////////////////////////////////////// -->
                                        <?php }?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
						
						
                        elseif ($process == '3') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <?php if(ESCALATION_ENABLE == 1){ ?>
                                            <td><?=$case->escalation_zone?></td>
                                            <td><?=$case->escalation_date?></td>
                                        <?php } ?>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?>
                                            <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                        <?php 
                                            if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                            {
                                                echo "Escalated to Appellate Authority";
                                            }
                                            else
                                            {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a>
                                      <?php } ?>
                                  </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
                        elseif ($process == '4') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/ApprovedProposals?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center"><a href="<?php echo base_url(); ?>index.php/LandReclassification/ApprovedProposals?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
                        elseif ($process == '5') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><span style="color: red;"><?php echo "Proposal No : " . $case->proposal_no; ?></span></td>
                                        <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center"><?php echo $this->lang->line('pending_for_co_chitha_updation'); ?> &nbsp;<img src="<?php echo base_url(); ?>application/views/images/Exclamation.gif" width="10%"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
                        elseif ($process == '6') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <?php if(ESCALATION_ENABLE == 1){ ?>
                                            <td><?=$case->escalation_zone?></td>
                                            <td><?=$case->escalation_date?></td>
                                        <?php } ?>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/ApprovedProposals?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                            <?php 
                                            if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                            {
                                                echo "Escalated to Appellate Authority";
                                            }
                                            else
                                            {
                                            ?>

                                            <a href="<?php echo base_url(); ?>index.php/LandReclassification/ApprovedProposals?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        }
                        elseif ($process == '7') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><?php echo $case->patta_no; ?></td>
                                        <td class="center">
                                            <?php
                                            $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                            echo $mouza_pargona_code."-".$lot_no."-".$vill_townprt_code;
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            $patta_type = $this->utilityclass->getPattaName($case->patta_type_code);
                                            echo $patta_type;
                                            ?>
                                        </td>
                                        <td class="center">Pending For Jamabandi Update</td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
                        elseif ($process == '8') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><span style="color: red;"><?php echo "Proposal No : " . $case->proposal_no; ?></span></td>
                                        <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">Pending For Re-issue By CO</td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }

                        elseif ($process == '11') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <?php if(ESCALATION_ENABLE == 1){include(APPPATH."views/common/esc_table_head.php");} ?>
                                    <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <?php if(ESCALATION_ENABLE == 1){ ?>
                                            <td><?=$case->escalation_zone?></td>
                                            <td><?=$case->escalation_date?></td>
                                        <?php } ?>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/ApprovedProposals?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center">
                                            <?php 
                                            if(ESCALATION_ENABLE == 1 && $case->is_escalated == 1)
                                            {
                                                echo "Escalated to Appellate Authority";
                                            }
                                            else
                                            { ?>
                                                <a href="<?php echo base_url(); ?>index.php/LandReclassification/ResponseLM?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a>
                                      <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        }
                        ?>


                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $("a").tooltip();
    });
</script>

<!-- property chain modal -->
<div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>
<!--  -->
<?php if(ESCALATION_ENABLE == 1) { ?>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#zone_status').change(function(){
                var zone_status = $('#zone_status').val();
                $('#cases').DataTable().destroy();
                <?php if($process == '1') { ?>
                    load_data(zone_status);
                <?php } elseif($process == '3' && $this->session->userdata('user_desig_code')=='ADC') { ?>
                    load_adc_data(zone_status);
                <?php } elseif($process == '3' && $this->session->userdata('user_desig_code')=='DC') { ?>
                    load_dc_data(zone_status);
                <?php } elseif($process == '11' && $this->session->userdata('user_desig_code')=='LM') { ?>
                    load_revert_lm_data(zone_status);
                <?php } ?>
            });
            function load_data(zone_status) // CO load data
            {
                var base_url = "<?php echo base_url();?>";
                var table = $('#cases').DataTable({
                    'pageLength': 10,
                    "processing": true,
                    "serverSide": true,
                    // "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/EscalationController/searchByEscalationZoneReclassificationForCo',
                        type:'POST',
                        data: { zone_status:zone_status },
                        deferLoading: 57,
                    },
                    order: [[2, 'asc']],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false,
                        "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                        }]
                });
                table.columns().every(function () {
                    var table = this;
                    $('input', this.header()).on('keyup change', function () {
                        if (table.search() !== this.value) {
                                table.search(this.value).draw();
                        }
                    });
                });
            }
            function load_adc_data(zone_status) // ADC load data
            {
                var base_url = "<?php echo base_url();?>";
                var table = $('#cases').DataTable({
                    'pageLength': 10,
                    "processing": true,
                    "serverSide": true,
                    // "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/EscalationController/searchByEscalationZoneReclassificationForAdc',
                        type:'POST',
                        data: { zone_status:zone_status },
                        deferLoading: 57,
                    },
                    order: [[2, 'asc']],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false,
                        "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                        }]
                });
                table.columns().every(function () {
                    var table = this;
                    $('input', this.header()).on('keyup change', function () {
                        if (table.search() !== this.value) {
                                table.search(this.value).draw();
                        }
                    });
                });
            }
            function load_dc_data(zone_status) // DC load data
            {
                var base_url = "<?php echo base_url();?>";
                var table = $('#cases').DataTable({
                    'pageLength': 10,
                    "processing": true,
                    "serverSide": true,
                    // "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/EscalationController/searchByEscalationZoneReclassificationForDc',
                        type:'POST',
                        data: { zone_status:zone_status },
                        deferLoading: 57,
                    },
                    order: [[2, 'asc']],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false,
                        "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                        }]
                });
                table.columns().every(function () {
                    var table = this;
                    $('input', this.header()).on('keyup change', function () {
                        if (table.search() !== this.value) {
                                table.search(this.value).draw();
                        }
                    });
                });
            }

            // reverted by CO to LM
            function load_revert_lm_data(zone_status) // LM revert load data
            {
                var zone_status = $('#zone_status').val();                

                var base_url = "<?php echo base_url();?>";
                var table = $('#cases').DataTable({
                    'pageLength': 10,
                    "processing": true,
                    "serverSide": true,
                    "ordering"  : false,
                    "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                    'language'  : {
                                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                            },
                    'ajax':{
                        url: base_url+'index.php/EscRevertController/searchByEscalationZoneRevertedReclassLm',
                        type:'POST',
                        data: { zone_status:zone_status },
                        deferLoading: 57,
                    },
                    order: [[2, 'asc']],
                    columnDefs: [{
                        targets: "_all",
                        orderable: false,
                        "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5],
                        }]
                });
                table.columns().every(function () {
                    var table = this;
                    $('input', this.header()).on('keyup change', function () {
                        if (table.search() !== this.value) {
                                table.search(this.value).draw();
                        }
                    });
                });
            }

        });
    </script>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function() {
        // $("a").tooltip();

        // property chain modal

        $('.panel').on('click', '.chainReportRC', function(e) {
            e.preventDefault();
            // console.log($(this).attr("case_no"))
            case_no = $(this).attr("case_no");
            dist_code = $(this).attr("dist_code");
            subdiv_code = $(this).attr("subdiv_code");
            circle_code = $(this).attr("cir_code");
            mouza_code = $(this).attr("mouza_pargona_code");
            lot_no = $(this).attr("lot_no");
            vill_code = $(this).attr("vill_townprt_code");
            $('#myModal .modal-content').empty().html(
                '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div><br><p class="text-primary text-center">....Fetching Data From Property Chain. Please Wait....</p>');
            $.ajax({
                url: baseurl + "PropChainReport/getCaseData",
                data: {
                    case_no: $(this).attr("case_no"),
                    vill_code: $(this).attr("vill_townprt_code"),
                    mut_type: $('#mut_type').val()
                },
                type: 'post',
                success: function(data1) {
                    console.log(data1)
                    var obj = JSON.parse(data1)
                    var dag_no = obj.dag_no;
                    var patta_code = obj.patta_no;
                    $.ajax({
                        url: baseurl + "PropChainReport/getPropChainData",
                        type: 'post',
                        data: {
                            case_no: case_no,
                            dist_code: dist_code,
                            subdiv_code: subdiv_code,
                            circle_code: circle_code,
                            mouza_code: mouza_code,
                            // mouza_code: '02',
                            lot_no: lot_no,
                            // lot_no: '01',
                            vill_code: vill_code,
                            // vill_code: '10004',
                            patta_code: patta_code,
                            // patta_code: '0201',
                            dag_no: dag_no,
                            // dag_no: '1',
                        },
                        success: function(data2) {
                            var object = JSON.parse(data2);
                            console.log(object);
                            if (object.result === 0) {
                                console.log('abc');
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center">' + object.error_msg + '</h1>');
                                $('#myModal').modal();
                            } else if (object.result === 1) {
                                var property_data = object.property_data
                                var transaction_data = object.transaction_data

                                console.log(property_data);
                                $.ajax({
                                    url: baseurl + "PropChainReport/generatePropertyChain",
                                    method: 'post',
                                    data: {
                                        property_data: property_data,
                                        transaction_data: transaction_data
                                    },
                                    dataType: 'html',
                                    success: function(data3) {
                                        $('#myModal .modal-content').html(data3);
                                        $('#myModal').modal();
                                    }
                                });
                            } else {
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center"><i class="fa fa-warning"></i>Unable to connect to property chain</h1>');
                                $('#myModal').modal();
                            }

                        }
                    });
                }
            })
        });
    });

    $('#myModal').on('hidden.bs.modal', function() {
        $('body').css('padding-right', 0);
        $('.modal-content').css('background-color', 'white');
        $('.modal-content').css('color', 'black');
    })
</script>
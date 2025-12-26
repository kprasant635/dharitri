<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
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
            <div class="col-lg-10 col-lg-offset-1">
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
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><a href="<?php echo base_url(); ?>index.php/LandReclassification/FirstCoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>">
                                                <?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <!-- <td><?php echo $case->case_no; ?></td> -->


                                    <td><?php echo $case->case_no; ?><br>
                                    </td> 
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center"><a href="<?php echo base_url(); ?>index.php/SuomotoReclassification/FirstCoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a></td>
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
						
						
						
						  elseif (($process == '3') and ($this->session->userdata('user_desig_code')=='ADC')) {
							
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
                                        <td><a href="<?php echo base_url(); ?>index.php/SuomotoReclassification/FirstADCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?>
                                           <br>
                                    
                                        </td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center"><a href="<?php echo base_url(); ?>index.php/SuomotoReclassification/FirstADCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php
                        }
						
						
                        elseif (($process == '3') and ($this->session->userdata('user_desig_code')=='DC')) {
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
                                        <td><a href="<?php echo base_url(); ?>index.php/SuomotoReclassification/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>"><?php echo "Proposal No : " . $case->proposal_no; ?></a></td>
                                        <td><?php echo $case->case_no; ?>
                                            <br>
                                    
                                        </td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->lm_date)); ?></td>
                                        <td class="center"><a href="<?php echo base_url(); ?>index.php/SuomotoReclassification/FirstDCProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a></td>
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
                                        <td class="center"><a href="<?php echo base_url(); ?>index.php/LandReclassification/ResponseLM?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Proceed</a></td>
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
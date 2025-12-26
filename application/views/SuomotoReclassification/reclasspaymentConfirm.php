<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Suomoto Reclass Case For Payment Notice Generation
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?> / Refference No</label></th>
                                <th class="center"><label class="control-label">Location</label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('due_date'); ?></label></th>
                                <th class="center"><label class="control-label">&nbsp;</label></th>
                                </thead>
                            <tbody>
                                <?php foreach($cases as $case):?>
                                <tr>
                                    <td><?php 
											echo $case->case_no;
																					
										?><br>
                                    
                                    </td>
                                    <td class="center">
                                        <?php
                                        echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                        echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                        echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td class="center"><p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : <?php echo date('M jS, Y', strtotime($case->next_date_of_hearing)); ?></p></td>
                                    <td class="center">
                                        <a class="btn btn-sm btn-block btn-primary" href="<?php echo base_url(); ?>index.php/SuomotoReclassification/paymentConfirm?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><i class="fa fa-print"></i>&nbsp;Procced</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
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

<script>
$(document).ready(function() {
    $('#example').DataTable({
	"bLengthChange": false,
	"showNEntries" : false,
	"bSort" :	false,
	"bnew" :	false,
	"pageLength": 20
  });
  
});
</script> 
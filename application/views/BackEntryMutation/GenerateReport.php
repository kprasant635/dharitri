<style>
.unicode label, tr {
    font-size: 14px !important;
}
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Report on the changes made through backlog office / field mutation in Chitha & Jamabandi
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Report</h3>
                    </div>
                    <div class="panel-body">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label">Type</label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('mouza'); ?> / <?php echo $this->lang->line('lot_no'); ?> / <?php echo $this->lang->line('vill_town'); ?></label></th>
                                <th class="center"><label class="control-label">Entry Date</label></th>
                                <th class="center"><label class="control-label">Dag</label></th>
                                <th class="center"><label class="control-label">Back Log Passed By</label></th>
                                </thead>
                                <?php 
                                //var_dump($cases);
                                foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $case->case_no; ?></td>
                                        <td class='center'>
                                            <?php
                                            $reversedParts = explode('/', strrev($case->case_no), 2);
                                            $type =  strrev($reversedParts[0]);
                                            if($type=='FMUT-BL'){
                                                $mut_type = 'F';
                                                echo 'Field Muatation';
                                            } else {
                                                $mut_type = 'O';
                                                echo 'Office Muatation';
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php 
                                                $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                                $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                                $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                                echo $mouza_pargona_code." / ".$lot_no." / ".$vill_townprt_code;
                                            ?>
                                        </td>
                                        <td class="center"><span class="badge badge-info"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->date_entry)); ?></span></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td>
                                            <span class="badge badge-danger"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->co_ord_date)); ?></span><br>
                                            <?php 
                                                $co_name = $this->utilityclass->getSelectedCOName($case->dist_code, $case->subdiv_code, $case->cir_code,$case->co_code);
                                                echo $co_name->username
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                            echo 'Pending Cases Of Request For Back Log';
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Pending Request
                        </h3>
                    </div>
                    <div class="panel-body">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label">Request For</label></th>
                                <th><label class="control-label">Mondal's Name</label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('mouza'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('lot_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('vill_town'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                                </thead>
                                <?php foreach ($pending_request as $case): ?>
                                    <tr>
                                        <td><?php echo $request = $this->utilityclass->getRequestFor($case->request_for); ?></td>
                                        <td>
                                            <?php 
                                            $lm_name = $this->utilityclass->getDefinedMondalsName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no,$case->lm_code); 
                                            echo $lm_name->lm_name;
                                            ?>
                                        </td>
                                        <td class="center"><?php echo $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);?></td>
                                        <td class="center"><?php echo $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);?></td>
                                        <td class="center"><?php echo $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->request_date)); ?></td>
                                        <td class="center">
                                            <?php
                                            $status = $case->status;
                                            if($status=='P'){
                                                ?>
                                                <a  id='co-order' href='<?php echo base_url() . "index.php/Request/Activate?dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code. "&type=" . $case->request_for; ?>' class="btn btn-sm btn-success">Activate Backlog</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a  id='co-order' href='<?php echo base_url() . "index.php/Request/Deactivate?dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code. "&type=" . $case->request_for; ?>' class="btn btn-sm btn-danger">Deactivate</a>
                                                <?php
                                            }
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




<script type="text/javascript">
    $(document).ready(function () {
        $("a").tooltip();
    });
</script>
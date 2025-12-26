<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('dc_approval_on_ap_cancellation'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                       <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('sl_no');?></label></th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            </thead>
                            <?php
                            $row = count($getDCAPCancellation);
                            if ($row > 0) {
                            $c = 1;
                            foreach ($getDCAPCancellation AS $cases) 
                            {
                                ?>
                                <tr>
                                    <td class="center"><?php echo $c; ?></td>
                                    <td><?php echo $cases->case_no; ?></td>
                                    <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($cases->submission_date)); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url() . "index.php/APCancellation/DCAPStep2"; ?>?submission_date=<?php echo $cases->submission_date; ?>&dist_code=<?php echo $cases->dist_code; ?>&subdiv_code=<?php echo $cases->subdiv_code; ?>&cir_code=<?php echo $cases->cir_code; ?>&mouza_pargona_code=<?php echo $cases->mouza_pargona_code; ?>&lot_no=<?php echo $cases->lot_no; ?>&vill_townprt_code=<?php echo $cases->vill_townprt_code; ?>&year_no=<?php echo $cases->year_no; ?>&petition_no=<?php echo $cases->petition_no; ?>&case_no=<?php echo $cases->case_no; ?>" class="btn btn-primary"><?php echo $this->lang->line('pass_order');?></a>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            }
                            } 
                            ?>
                        </table>
                        <center>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
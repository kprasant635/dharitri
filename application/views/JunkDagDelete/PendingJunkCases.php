<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Pending Cases For Junk Dag Deletion.
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
                    <div class="panel-body">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('proposal_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?> / <?php echo $this->lang->line('patta_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('view_proposals'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $case->case_no; ?></td>
                                        <td><?php echo "Proposal no : " . $case->proposal_no; ?></td>
                                        <td class="center"><?php echo $case->dag_no; ?> / <?php echo $case->patta_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->lm_date)); ?></td>
                                        <?php if($this->session->userdata('user_desig_code') == 'DC' || ($this->session->userdata('user_desig_code')== 'ADC')): ?>
                                            <td class="center">
                                                <a href="<?php echo base_url(); ?>index.php/JunkDagDelete/DcAdcProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success"><?php echo $this->lang->line('give_order'); ?></a>
                                            </td>
                                        <?php elseif ($this->session->userdata('user_desig_code') == 'CO'): ?>
                                            <td class="center">
                                                <a href="<?php echo base_url(); ?>index.php/JunkDagDelete/CoProcess?case_no=<?php echo $case->case_no."&proposal_no=".$case->proposal_no; ?>" class="btn btn-success">Write Report</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
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




<script type="text/javascript">
    $(document).ready(function () {
        $("a").tooltip();
    });
</script>
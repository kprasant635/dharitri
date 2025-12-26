<div class="container-fluid login home">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                </div>
            <?php endif; ?>
            <table class='table table-striped pageshowpage' id='example'>
                <thead>
                    <tr>
                        <th class='alert-new'><?php echo $this->lang->line('case_no'); ?></th>
                        <th class='alert-new'><?php echo $this->lang->line('case_type'); ?></th>
                        <th class='alert-new'><?php echo $this->lang->line('submission_type'); ?></th>
                        <th class='alert-new'><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                </thead>
                <?php foreach ($cases as $case): ?>
                    <tbody>
                        <tr>
                            <td><a href="<?php echo base_url() . 'index.php/skmutation/viewcasedetails/?case=' . $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                            <td><?php echo ($case->mut_type == 01) ? $this->lang->line('mutation') :$this->lang->line('partition'); ?></td>
                            <td><?php echo $case->report_date; ?></td>
                            <td>
                                <?php if ($case->mut_type == '01'): ?>
                                <a target="__blank" href=<?php echo base_url() . "index.php/skmutation/getLMReport1?case_no=" . $case->case_no; ?> class='lmreport btn-sm btn btn-danger' id='<?php echo $case->case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('lm_report'); ?></a>
                                <?php else: ?>
                                    <a target="__blank" href=<?php echo base_url() . "index.php/skmutation/getLMReportPartition?case_no=" . $case->case_no; ?> class='lmreport btn-sm btn btn-danger' id='<?php echo $case->case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('lm_report'); ?></a>
                                <?php endif; ?>

                                <a target="__blank" href=<?php echo base_url() . "index.php/cofieldmutation/getSkNote?case_no=" . $case->case_no; ?> class='lmreport btn-sm btn btn-danger' id='<?php echo $case->case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('sk_report'); ?></a>

                                <a target="__blank" href='<?php echo base_url() . "index.php/cofieldmutation/freshLmReport?case_no=" . $case->case_no; ?>' class="btn btn-sm btn-danger"><?php echo $this->lang->line('fresh_lm_report'); ?></a>
                                <a target="__blank" href='<?php echo base_url() . "index.php/skmutation/saveReport?case_no=" . $case->case_no; ?>' class="btn btn-sm btn-danger"><?php echo $this->lang->line('reject'); ?></a>
                                <a target="__blank" id='co-order' 
                                   href='<?php echo base_url() . "index.php/COFieldMutation/viewcasedetails?case_no=" . $case->case_no; ?>' 
                                   class="btn btn-sm btn-success" <?php if ($case->consent != 0) echo "disabled"; ?>><?php echo $this->lang->line('pass_order');?>
                                </a>
                                <?php if ($case->consent != 0): ?>
                                    <span class='label label-danger'><?php echo $this->lang->line('copattadar_consent_not_obtained');?>.</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php // echo $this->pagination->create_links();?>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                Modal
            </div>
        </div>
    </div>
</div>
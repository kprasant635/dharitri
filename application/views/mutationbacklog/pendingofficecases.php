<div class="container-fluid login form-top">
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
            <table class='table table-stripped pageshowpage' id='cases'>
                <thead>
                    <tr>
                        <th class='alert-new'><?php echo $this->lang->line('case_no')?></th>
<!--                        <th>Case Type</th>-->
                        <th class='alert-new'><?php echo $this->lang->line('submission_date')?></th>
                        <th class='alert-new'><?php echo $this->lang->line('action')?></th>
                    </tr>
                </thead>
                <?php
                //var_dump($cases);
                foreach ($cases as $case): ?>
                    <tr>
                        <td><?php echo $case->case_no; ?></td>
<!--                        <td><?php echo $case->mut_type ; ?></td>-->
                        <td><?php echo date('d-m-Y',strtotime($case->submission_date)); ?></td>
                        <td>
                        <?php if($case->mut_type=='03'):?>
                            <a href="<?php echo base_url(); ?>index.php/lmmutation/writeOfficeReport?case_no=<?php echo $case->case_no ?>"><?php echo $this->lang->line('write_report')?></a>
                        <?php endif;?>
                        <?php if($case->mut_type=='04'):?>
                            <a href="<?php echo base_url(); ?>index.php/partition/LmPartitionRpt?petition_no=<?php echo $case->petition_no ?>&case_no=<?php echo $case->case_no ?>"><?php echo $this->lang->line('write_report')?></a>
                        <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php // echo $this->pagination->create_links();?>
        </div>
    </div>
</div>
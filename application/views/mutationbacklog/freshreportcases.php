<div class="container-fluid login form-top">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   
                </div>
            <?php endif; ?>
            <table class='table table-striped table-bordered tablesorter' id='cases'>
                <thead>
                    <tr>
                        <th class='alert-new'><?php echo $this->lang->line('case_no')?></th>
                        <th class='alert-new'><?php echo $this->lang->line('case_type')?></th>
                        <th class='alert-new'><?php echo $this->lang->line('submission_date')?></th>
                        <th class='alert-new'><?php echo $this->lang->line('action')?></th>
                    </tr>
                </thead>
                <?php foreach ($cases as $case): ?>
                    <tr>
                        <td><a href="<?php echo base_url() . 'index.php/skmutation/viewcasedetails/?case=' . $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                        <td><?php echo ($case->mut_type == 01) ? 'Mutation' : 'Partition'; ?></td>
                        <td><?php echo date('d-m-Y',  strtotime($case->co_flag_date)); ?></td>
                        <td>
                            <?php $link = base_url()."index.php/lmmutation/freshReportStep1?case_no=$case->case_no";?>
                            <a href="<?php echo $link;?>"><?php echo $this->lang->line('write_report')?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php echo $this->pagination->create_links();?>
        </div>
    </div>
</div>
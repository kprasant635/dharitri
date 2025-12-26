<div class="container-fluid">
    <div class='row'>
        <div class='col-lg-8' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php echo $this->session->userdata('message');
            $this->session->unset_userdata('message'); ?>
                </div>
            <?php endif; ?>
            <table class='table table-striped table-bordered tablesorter' id='cases'>
                <thead>
                    <tr>
                        <th>Case No</th>
                        <th>Case Type</th>
                        <th>Submission Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                    <?php foreach ($cases as $case): ?>
                    <tr>
                        <td><a href="<?php echo base_url() . 'index.php/skmutation/viewcasedetails/?case=' . $case->case_no; ?>"><?php echo $case->case_no; ?></a></td>
                        <td> Partition</td>
                        <td><?php echo date('d-m-Y', strtotime($case->submission_date)); ?></td>
                        <td><a href='<?php echo base_url() ?>index.php/partition/SKPartitionRedirect?case_no=<?php echo $case->case_no ?>&vill=<?php echo $case->vill_townprt_code; ?>&m=<?php echo $case->mouza_pargona_code ?>&l=<?php echo $case->lot_no ?>&p=<?php echo $case->petition_no ?>&y=<?php echo $case->year_no ?>' class="btn btn-danger">
                                Write Report</a></td>
                    </tr>
            <?php endforeach; ?>
            </table>
<?php echo ($this->pagination->create_links()); ?>
        </div>
    </div>
</div>
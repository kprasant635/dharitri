<div class="row mt-2">
    <div class="col-md-12 col-lg-12">
        <div class="card card-success">
            <div class="card-header text-center">
                <h5>Lot Mondal's pending Land Conversion Cases</h5>
            </div>
            <div class="card-body">
                <?php if($process == '1'): ?>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <table class="table table-bordered table-striped convtable">
                                <thead>
                                    <tr class="text-bold table-success">
                                        <th>Case No.</th>
                                        <th>Case Type</th>
                                        <th>Submission Date</th>
                                        <th>Write Report</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <?php echo $case->case_no; ?><br>
                                            <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td>
                                            <?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                            ?>
                                        </td>
                                        <td><i class='fa fa-calendar'></i> Submited On: <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td><a class="btn btn-success text-light" href="<?php echo base_url('index.php/lm_first_proceeding?case_no=' . $case->case_no); ?>"><?php echo $this->lang->line('write_report'); ?></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-center">
                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $('.convtable').dataTable();
</script>
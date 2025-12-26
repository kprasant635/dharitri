<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <?php if($process == '3'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion Premium Report Cases</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered convtable">
                            <thead>
                                <tr class="table-success">
                                    <th>Case No.</th>
                                    <th>Case Type</th>
                                    <th>Submission Date</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url('index.php/ast_premium_notice?case_no='. $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                        <br>
                                        <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                    </td>
                                    <td>
                                        <?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                        ?>
                                    </td>
                                    <td><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                    <td><p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : <?php echo date('d-m-Y', strtotime($case->next_date_of_hearing)); ?></p></td>
                                    <td><a href="<?php echo base_url("index.php/ast_premium_notice?case_no=". $case->case_no); ?>" class="btn btn-success text-light">Proceed</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?php echo base_url('index.php/home/index'); ?>" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>
                    </div>
                </div>
            <?php elseif($process == '4'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion Premium Confirmation</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered convtable">
                            <thead>
                                <tr class="table-success">
                                    <th>Case No.</th>
                                    <th>Case Type</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>
                                    <td>
                                        <?php
                                        if (($case->co_order_conv_notice != null) && (strtolower($case->co_order_conv_premium) == 'y')) {
                                            ?>
                                            <a href="#"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?php echo base_url('index.php/ast_premium_confirm?case_no='. $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                        if ($case->mut_type == '01') {
                                            echo "Conversion Case";
                                        }
                                        ?>
                                    </td>
                                    <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                    <td>
                                        <?php
                                        $datetime1 = new DateTime();
                                        $datetime2 = new DateTime(date('d-m-Y', strtotime($case->next_date_of_hearing)));
                                        $interval = $datetime1->diff($datetime2);
                                        $days = $interval->format('%R%a');
                                        if ($case->status == 'P') {
                                            if ($days <= -1) {
                                                echo "<p class=\"text-danger small regular blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>" . " Lapsed by " . abs($days) . " days ago" . "</p>";
                                            }
                                        }
                                        ?>
                                        <?php
                                        echo "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($case->next_date_of_hearing)) . "</p>";
                                        if ($case->co_order_conv_notice != null) {
                                            echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                        }
                                        ?>
                                        <?php
                                        if (($case->co_order_conv_notice != null) && (strtolower($case->co_order_conv_premium) == 'y')) {
                                            ?>

                                            <?php
                                        } else {
                                            ?>
                                            <a class='btn btn-success text-light' href="<?php echo base_url('index.php/ast_premium_confirm?case_no='. $case->case_no); ?>"><?php echo $this->lang->line('write_report'); ?></a></td>                                    
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?php echo base_url('index.php/home/index'); ?>" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    $('.convtable').dataTable();
</script>
<?php

// echo '<pre>';
// var_dump($cases);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <?php if($process == '1'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion Fresh Cases</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered convtable">
                            <thead>
                                <tr class="table-success">
                                    <th>Application No.</th>
                                    <th>Application Date</th>
                                    <th>Request Type</th>
                                    <th>Urban / Rural</th>
                                    <th>Village Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>
                                    <td><?php echo $case->application_no; ?></td>
                                    <td><?php echo (isset($case->date_submission) ? date('d-m-Y', strtotime($case->date_submission)) : 'No date submission available') ; ?></td>
                                    <td><?php echo isset($case->service) ? $case->service : 'No request type available'; ?></td>
                                    <td><?php echo $case->rurban; ?></td>
                                    <td><?php echo $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_code, $case->lot_no, $case->village_code); ?></td>
                                    <td><a href="<?php echo base_url("index.php/co_first_proceeding?application_no=". $case->application_no); ?>" class="btn btn-success text-light">Proceed</a></td>
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
            <?php elseif($process == '2'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion 2nd Proceeding Cases</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped convtable">
                            <thead>
                                <tr class="table-success">
                                    <th><?php echo $this->lang->line('case_no'); ?></th>
                                    <th><?php echo $this->lang->line('case_type'); ?></th>
                                    <th><?php echo $this->lang->line('submission_date'); ?></th>
                                    <th><?php echo $this->lang->line('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>    
                                    <td>
                                        <?php if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')): ?>
                                            <a href="#"><?php echo $case->case_no; ?></a>
                                            <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php else: ?>
                                            <a href="<?php echo base_url('index.php/co_second_proceeding?case_no=' . $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td>
                                        <i class='fa fa-calendar'></i> Submited On: <?php echo date('d-m-Y', strtotime($case->date_entry)); ?>
                                    </td>
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
                                            echo "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($case->next_date_of_hearing)) . "</p>";

                                            if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {

                                                echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                            }
                                            if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->sk_comment == '' or $case->sk_comment == null) {
                                                echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->proceeding_yn == '' or $case->proceeding_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->notice_generated_yn == 'Y') && ($case->notice_served_yn != 'Y')){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ জাননী জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->lm_note_yn == 'Y' && $case->notice_generated_yn == 'Y' && $case->notice_served_yn == 'Y' && $case->proceeding_yn == '1' && $case->sk_comment == 'Y') {
                                                ?>
                                                <a class="btn btn-sm btn-success text-light" href="<?php echo base_url('index.php/co_second_proceeding?case_no=' . $case->case_no); ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                                <?php
                                            }
                                        ?>
                                        <!--<a class='btn btn-sm btn-info' style="margin-top: 2px;" href="<?php echo base_url() . 'index.php/COconversionPartha/setupdateProDate' ?>?case_no=<?php echo $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>">Change Hearing Date</a>-->
                                        <!-- <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$case->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button> -->
                                        <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                        <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))): ?>
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReport btn-sm btn btn-primary'>View Property Chain</button>
                                        <?php endif; ?>
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
            <?php elseif($process=='6'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h3>Conversion Chitha Update Cases</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered convtable">
                            <thead>
                                <tr class="table-success">
                                    <th>Case No.</th>
                                    <th>Case Type</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cases as $case): ?>
                                <tr>
                                    <td>
                                        <?php
                                        if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')) {
                                            ?>
                                                <a href="#"><?php echo $case->case_no; ?></a>
                                                <br>
                                            
                                                <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                            <?php
                                        } else {
                                            ?>
                                                <a href="<?php echo base_url('index.php/co_chitha_update?case_no=' . $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                                <br>
                                            
                                                <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                        if ($case->mut_type == '01') {
                                            echo "Conversion Case";
                                        }
                                        echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                        echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                        echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
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

                                        if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {

                                            echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                        }
                                        if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                            echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                        }
                                        if ($case->sk_comment == '' or $case->sk_comment == null) {
                                            echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
                                        }
                                        if ($case->proceeding_yn == '' or $case->proceeding_yn == null) {
                                            echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ টোকা অপ্ৰাপ্ত</p>";
                                        }
                                        if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                            echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                        }
                                        if ($case->lm_note_yn == 'Y' and $case->notice_generated_yn == 'Y' and $case->proceeding_yn == '1') {
                                            ?>
                                            <a class="btn btn-success btn-block text-light" href="<?php echo base_url('index.php/co_chitha_update?case_no=' . $case->case_no); ?>">Update Chitha</a>
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

                <?php elseif($process == '11'): ?>

                    <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion Payment Declined by Assistant Cases</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped convtable">
                            <thead>
                                <tr class="table-success">
                                    <th><?php echo $this->lang->line('case_no'); ?></th>
                                    <th><?php echo $this->lang->line('case_type'); ?></th>
                                    <th><?php echo $this->lang->line('submission_date'); ?></th>
                                    <th><?php echo $this->lang->line('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>    
                                    <td>
                                        <?php if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')): ?>
                                            <a href="#"><?php echo $case->case_no; ?></a>
                                            <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php else: ?>
                                            <a href="<?php echo base_url('index.php/co_second_proceeding?case_no=' . $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td>
                                        <i class='fa fa-calendar'></i> Submited On: <?php echo date('d-m-Y', strtotime($case->date_entry)); ?>
                                    </td>
                                    <td>
                                        <?php
                                        

                                            if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {

                                                echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                            }
                                            if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->sk_comment == '' or $case->sk_comment == null) {
                                                echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->proceeding_yn == '' or $case->proceeding_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->notice_generated_yn == 'Y') && ($case->notice_served_yn != 'Y')){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ জাননী জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->new_status == 'ASPCA') {
                                                ?>
                                                <a class="btn btn-sm btn-success text-light" href="<?php echo base_url('index.php/payment_declined_cases?case_no=' . $case->case_no); ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                                <?php
                                            }
                                        ?>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                               
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

                <?php elseif($process == '5'): ?>

                    <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion Revert Cases from ADC/DC</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped convtable">
                            <thead>
                                <tr class="table-success">
                                    <th><?php echo $this->lang->line('case_no'); ?></th>
                                    <th><?php echo $this->lang->line('case_type'); ?></th>
                                    <th><?php echo $this->lang->line('submission_date'); ?></th>
                                    <th><?php echo $this->lang->line('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>    
                                    <td>
                                        <?php if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')): ?>
                                            <a href="#"><?php echo $case->case_no; ?></a>
                                            <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php else: ?>
                                            <a href="<?php echo base_url('index.php/co_second_proceeding?case_no=' . $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td>
                                        <i class='fa fa-calendar'></i> Submited On: <?php echo date('d-m-Y', strtotime($case->date_entry)); ?>
                                    </td>
                                    <td>
                                        <?php
                                        

                                            if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {

                                                echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                            }
                                            if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->sk_comment == '' or $case->sk_comment == null) {
                                                echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->proceeding_yn == '' or $case->proceeding_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->notice_generated_yn == 'Y') && ($case->notice_served_yn != 'Y')){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ জাননী জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->status == 'R') {
                                                ?>
                                                <a class="btn btn-success btn-block" href="<?php echo base_url(); ?>index.php/reverted_cases_dc_adc?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                                <?php
                                            }
                                        ?>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                               
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
            

                <?php elseif($process == '7'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion CO Final Order Cases</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped convtable">
                            <thead>
                                <tr class="table-success">
                                    <th><?php echo $this->lang->line('case_no'); ?></th>
                                    <th><?php echo $this->lang->line('case_type'); ?></th>
                                    <th><?php echo $this->lang->line('submission_date'); ?></th>
                                    <th><?php echo $this->lang->line('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>    
                                    <td>
                                        <?php if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')): ?>
                                            <a href="#"><?php echo $case->case_no; ?></a>
                                            <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php else: ?>
                                            <a href="<?php echo base_url('index.php/co_second_proceeding?case_no=' . $case->case_no); ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($case->mut_type == '01') {
                                                echo "Conversion Case";
                                            }
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td>
                                        <i class='fa fa-calendar'></i> Submited On: <?php echo date('d-m-Y', strtotime($case->date_entry)); ?>
                                    </td>
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
                                            echo "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($case->next_date_of_hearing)) . "</p>";

                                            if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {

                                                echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                            }
                                            if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->sk_comment == '' or $case->sk_comment == null) {
                                                echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->proceeding_yn == '' or $case->proceeding_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->notice_generated_yn == 'Y') && ($case->notice_served_yn != 'Y')){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ জাননী জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->lm_note_yn == 'Y' && $case->notice_generated_yn == 'Y' && $case->notice_served_yn == 'Y' && $case->proceeding_yn == '1' && $case->sk_comment == 'Y') {
                                                ?>
                                                <a class="btn btn-sm btn-success text-light" href="<?php echo base_url('index.php/co_final_order?case_no=' . $case->case_no); ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                                <?php
                                            }
                                        ?>
                                        <!--<a class='btn btn-sm btn-info' style="margin-top: 2px;" href="<?php echo base_url() . 'index.php/COconversionPartha/setupdateProDate' ?>?case_no=<?php echo $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>">Change Hearing Date</a>-->
                                        <!-- <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$case->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button> -->
                                        <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                        <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))): ?>
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReport btn-sm btn btn-primary'>View Property Chain</button>
                                        <?php endif; ?>
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
            <?php elseif($process == '8'): ?>
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-center">
                        <h5>Conversion All Cases</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered convtable">
                            <thead>
                                <tr class="table-success">
                                    <th>Case No.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cases as $case): ?>
                                <tr>
                                    <td><?php echo $case->case_no; ?></td>
                                    <td><a href="<?php echo base_url("index.php/co_all_cases?case_no=". $case->case_no); ?>" class="btn btn-success text-light">Proceed</a></td>
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
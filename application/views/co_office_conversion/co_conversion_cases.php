<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION CASES ( 1st PROCEEDING )";
                        } elseif ($process == '2') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION CASES ( 2nd PROCEEDING )";
                        } elseif ($process == '4') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION ( PROCEEDING REPORTS )";
                        } elseif ($process == '3') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION ( UPDATE CHITHA )";
                        } elseif ($process == '5') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION ( REVERTED BACK BY DC / ADC )";
                        } elseif ($process == '6') {
                            echo "CIRCLE OFFICER'S LAND CONVERSION ( CHITHA UPDATE ON CASES PASSED BY DC )";
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="col-lg-12">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if ($process == '1') {
                            ?>
                            <form method="post">
                            <div class="input-group">
                                <input type="text" name="searchKeyword" class="form-control col-sm-6 pull-right" placeholder="Search by Dharitree Case No" value="<?php echo $searchKeyword; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                                </div>
                            </form>
                            <table class='table table-striped table-bordered' id='conversionData' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?> / Location</label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><a href="<?php echo base_url(); ?>index.php/COconversionPartha/FirstProcess?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?><br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </a></td>
                                        <td class="center"><?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
                                            }
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center"><a class="btn btn-success btn-block" href="<?php echo base_url(); ?>index.php/COconversionPartha/FirstProcess?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a>

                                            <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                            {?>

                                            <!-- property chain report -->
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReport btn-sm btn btn-primary'>View Property Chain</button>

                                            <?php } ?>

                                        </td>



                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <div class="pagination_links"> 
                             <?php echo $links; ?> </div> 
                            </div>
                            <?php
                        } elseif ($process == '2') {
                            ?>
                            <form method="post">
                            <div class="input-group">
                                <input type="text" name="searchKeyword" class="form-control col-sm-6 pull-right" placeholder="Search by Dharitree Case No" value="<?php echo $searchKeyword; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                                </div>
                            </form>
                            <table class='table table-striped table-bordered' id='conversionData' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
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
                                                <a href="<?php echo base_url(); ?>index.php/COconversionPartha/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                                <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
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
                                                <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/COconversionPartha/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                                <?php
                                            }
                                            ?>
                                                <a class='btn btn-sm btn-info' style="margin-top: 2px;" href="<?php echo base_url() . 'index.php/COconversionPartha/setupdateProDate' ?>?case_no=<?php echo $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>">Change Hearing Date</a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$case->case_no?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                                <!-- <a class='btn btn-sm btn-danger' href="<?php //echo base_url(); ?>index.php/COconversionPartha/RejectOrder?case_no=<?php //echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Reject Order</a> -->

                                                <?php if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                            {?>

                                            <!-- property chain report -->
                                            <button type="button" data-toggle="modal" data-target="#myModal" case_no="<?= $case->case_no ?>" dist_code="<?= $case->dist_code ?>" subdiv_code="<?= $case->subdiv_code ?>" cir_code="<?= $case->cir_code ?>" mouza_pargona_code="<?= $case->mouza_pargona_code ?>" lot_no="<?= $case->lot_no ?>" vill_townprt_code="<?= $case->vill_townprt_code ?>" class='chainReport btn-sm btn btn-primary'>View Property Chain</button>

                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <div class="pagination_links"> 
                             <?php echo $links; ?> </div> 
                            </div> 
                            <?php
                        } elseif ($process == '5') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')) {
                                                ?>
                                                <a href="#"><?php echo $case->case_no; ?></a>
                                                
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/COconversionPartha/RejectedSecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                                <?php
                                            }
                                            ?>
                                            <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
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
                                            if ($case->lm_note_yn == 'Y' and $case->notice_generated_yn == 'Y' and ($case->proceeding_yn == '1' || $case->proceeding_yn == null)) {
                                                ?>
                                                <a class="btn btn-success btn-block" href="<?php echo base_url(); ?>index.php/COconversionPartha/RejectedSecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } else if ($process == '3') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter' id='cases' width="100%">
                                <thead>
                                <th><?php echo $this->lang->line('case_no'); ?></th>
                                <th class="center"><?php echo $this->lang->line('type'); ?></th>
                                <th class="center"><?php echo $this->lang->line('submission_date'); ?></th>
                                <th class="center"><?php echo $this->lang->line('dag_no'); ?></th>
                                <th class="center"><?php echo $this->lang->line('action'); ?></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><?php echo $case->case_no; ?><br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                                        <td><?php
                                            if ($case->ord_type_code == '01') {
                                                echo "Convertion Case";
                                            }
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                            ?>
                                        </td>
                                        <td><?php echo date('d-m-Y', strtotime($case->co_ord_date)); ?></td>
                                        <td><?php echo $case->dag_no; ?></td>
                                        <td><a href="<?php echo base_url(); ?>index.php/COconversionPartha/ChithaUpdateConversion?case_no=<?php echo $case->case_no; ?>">
                                        <input type="submit" name="submit" value="Update Chitha" class="btn btn-success btn-xs btn-block"/></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } else if ($process == '4') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?> / Location</label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('petition_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td><a href="#">
                                            <?php 
                                            echo $case->case_no;
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);

                                            ?></a>
                                            <br>
                                           <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center"><?php echo $case->petition_no; ?></td>
                                        <td class="center"><?php echo $case->dag_no; ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td><!--not_fresh is null and lm_note_yn is null-->
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
                                            if (strtolower($case->not_fresh) == null) {
                                                ?>
                                                <p class="text-primary"><i class="fa fa-exclamation-triangle red"></i> চক্র বিষয়াৰ হুকুম দিয়া নাই</p>
                                                <?php
                                            } elseif($case->status=='D' || $case->status=='R'){
                                                echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i>  Case Disposed </p>";
                                            } else {
                                                echo "<p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : " . date('d/m/Y', strtotime($case->next_date_of_hearing)) . "</p>";
                                                if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {

                                                    echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                                }
                                                if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                                    echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত </p>";
                                                }
                                                if ($case->sk_comment == '' or $case->sk_comment == null) {
                                                    echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত </p>";
                                                }
                                                if ($case->proceeding_yn == '' or $case->proceeding_yn == null) {
                                                    echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i>  সহায়কৰ টোকা অপ্ৰাপ্ত </p>";
                                                }
                                                if ($case->add_off_desig == 'DC' or $case->add_off_desig == 'ADC') {
                                                    echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i>  Forwarded to dc/adc </p>";
                                                }
                                                if($case->status=='W'){
                                                    echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i>  Order Passed by DC. Chitha Not Updated </p>";
                                                }
                                            }
                                            ?>

                                            <?php
                                            if (($case->notice_generated_yn == '') || (strtolower($case->lm_note_yn) != 'y') || (strtolower($case->sk_comment) == null)) {
                                                
                                            } elseif (($case->notice_generated_yn == '') || (strtolower($case->co_order_conv_premium) == '')) {
                                                
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/COconversionPartha/ViewActionTakenReport?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">
                                                <input type="submit" name="submit" value="View Report" class="btn btn-success btn-md btn-block"/></a></td>
                                            <?php
                                        }
                                        ?>

                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } else if ($process == '6') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
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
                                                    <a href="<?php echo base_url(); ?>index.php/COconversionPartha/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                                    <br>
                                                
                                                    <span class='small font-italic red'><?php if(isset($case->basundhara)){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
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
                                                <a class="btn btn-success btn-block" href="<?php echo base_url(); ?>index.php/COconversionPartha/DCPassedSecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Update Chitha</a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        }
                        ?>
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
<!-- property chain modal -->
<div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style=" overflow-y: auto;" id='myModal'>
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style=" overflow-y: auto;">
        <div class="modal-content" style=" overflow-y: auto;">

        </div>
    </div>
</div>
<!--  -->
<script type="text/javascript">
    $(document).ready(function () {
    $('#conversionData').DataTable({
        "pageLength": 50,
        "lengthChange": false
    })
    });
</script>

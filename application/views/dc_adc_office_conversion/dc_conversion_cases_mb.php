<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1') {
                            echo "DEPUTY COMMISSIONER'S LAND CONVERSION ( 1st PROCEEDING )";
                        } elseif ($process == '2') {
                            echo "ADDITIONAL DEPUTY COMMISSIONER'S LAND CONVERSION ( 2nd PROCEEDING )";
                        } elseif ($process == '3') {
                            echo "DEPUTY COMMISSIONER'S LAND CONVERSION ( 1st PROCEEDING )";
                        } elseif ($process == '4') {
                            echo "ADDITIONAL DEPUTY COMMISSIONER'S LAND CONVERSION ( 1st PROCEEDING )";
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
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')) {
                                                ?>
                                                <a href="#"><?php echo $case->case_no; ?>
                                                <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <!--<a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?>-->
                                                <a><?php echo $case->case_no; ?>
                                                     <br>
                                                    <span class='small font-italic red'>
                                                       <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                     </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
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
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সাখা কর্মকর্তাৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->lm_note_yn == 'Y' and $case->notice_generated_yn == 'Y' and $case->proceeding_yn == '1') {
                                                ?>
                                                <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_conversion_mb/FirstProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>

                                                <?php
                                            }
                                            ?>
                                            <a class='btn btn-sm btn-danger' href="<?php echo base_url(); ?>index.php/COconversionPartha/RejectOrder?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Reject Order</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } else if ($process == '2') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
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
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <a><?php echo $case->case_no; ?>
                                                     <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
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
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সাখা কর্মকর্তাৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }


                                            if ($case->status == 'W' and $case->add_off_desig == 'DPT' and $case->dept_note_yn == null){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> Department ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }else{

                                                if ($case->lm_note_yn == 'Y' and $case->notice_generated_yn == 'Y' and $case->proceeding_yn == '1') {
                                                    ?>
                                                    <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_conversion_mb/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>
                                                    
                                                    <?php
                                                }
                                            
                                            ?>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                            <?php
                                            }
                                            if($case->case_no == 'KAM/UTT/2022-23/23309/CONV'){
                                                ?>
                                                    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                                                    <input type="hidden" id="caseNum" value="KAM/UTT/2022-23/23309/CONV">
                                                    <button class="btn btn-danger" id="forwardCaseToDc">Forward this particular case To DC</button>
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
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
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
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/FirstProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?>
                                                     <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            $dist_code = $this->utilityclass->getDistrictName($case->dist_code);
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                            ?>
                                        </td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center">
                                            <form class="" method='post' action="<?php echo base_url() . "index.php/dc_adc_conversion_to_be_change/FirstProceeding_save_direct"; ?>">
                                                <input type="hidden" name="case_no" value="<?php echo $case->case_no;?>"/>
                                                <input type="hidden" name="dc_adc_order" value="<p>চক্ৰ বিযয়া <?php echo $circle_code; ?> ৰাজহ চক্ৰৰ পৰা <span style='color:red;'><?php echo $case->case_no; ?></span> নং ম্যাদীকৰন প্ৰস্তাৱ পোৱা গৈছে |</p><br>
                                               <label class='control-label rasid' style='float:right; margin-right:30px; font-size: 22px; text-align: center'><?php echo $case->add_off_name; ?><br><?php echo $location['designation_name']; ?>, <?php echo $dist_code; ?></label>">
                                                <input type="hidden" class="form-control"  name="dist_code" required value="<?php echo $case->dist_code;?>">
                                                <input type="hidden" class="form-control"  name="subdiv_code" required value="<?php echo $case->subdiv_code;?>">
                                                <input type="hidden" class="form-control"  name="cir_code" required value="<?php echo $case->cir_code;?>">
                                                <input type="hidden" class="form-control"  name="mouza_pargona_code" required value="<?php echo $case->mouza_pargona_code;?>">
                                                <input type="hidden" class="form-control"  name="lot_no" required value="<?php echo $case->lot_no;?>">
                                                <input type="hidden" class="form-control"  name="vill_townprt_code" required value="<?php echo $case->vill_townprt_code;?>">
                                                <label>
                                                    <select class="form-control" name='bo_code' required>
                                                        <option selected disabled>-- Select BO --</option>
                                                    <?php 
                                                        foreach ($branch_officer as $bo) {
                                                            $user_desig_code = $bo->user_desig_code;
                                                            $username = $bo->username." ( ".$user_desig_code." )";
                                                            $user_code = $bo->user_code;
                                                            echo"<option value='$user_code'>$username</option>";
                                                        }
                                                    ?>
                                                    </select>
                                                </label>
                                                <button type="submit" name="submit" id="onsubmit" class="btn btn-danger uni_text"><i class='fa fa-check'></i> Forward To BO </button>
                                            </form>
                                            <hr>
                                            <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/FirstProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>
                                            <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/PassToAdc?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Forward To ADC</a>
                                            <a class='btn btn-sm btn-danger' href="<?php echo base_url(); ?>index.php/COconversionPartha/RejectOrder?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Reject Order</a>
                                                    
                                                
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } else if ($process == '4') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td> 
                                            <?php

                                            if (($case->lm_note_yn == '') || ($case->notice_generated_yn == '') || ($case->proceeding_yn == '')) {
                                                ?>
                                                <a href="#"><?php echo $case->case_no ;?></a>
                                                <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/FirstProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?>
                                                     <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
                                            echo "<br>Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                            echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                            echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                            ?>
                                        </td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center">
                                            <?php if($case->is_mb3==1) {?>
                                                <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change_mb/FirstProceedingMb?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>
                                            <?php } else {?>
                                                <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/FirstProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>
                                            <?php }?>
                                            
                                            <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                            } else if ($process == '5') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
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
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <!--<a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?>-->
                                                <a><?php echo $case->case_no; ?>
                                                     <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
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
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সাখা কর্মকর্তাৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }




                                            if ($case->lm_note_yn == 'Y' and $case->notice_generated_yn == 'Y' and $case->proceeding_yn == '1' and $case->status == 'W' and $case->add_off_desig == 'DPT' and $case->dept_note_yn == null) {
                                                ?>
                                                 <p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> Department ঘোষনা জাৰী অপ্ৰাপ্ত</p>
                                                <!--<a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/DepartmentProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>-->
                                                <?php
                                            }
                                            
                                            ?>
                                            <!--<button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>-->
                                            <?php
                                            
                                            
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                            } else if ($process == '6') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
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
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <!--<a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?>-->
                                                <a><?php echo $case->case_no; ?>
                                                     <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
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
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সাখা কর্মকর্তাৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }


                                            if ($case->status == 'W' and $case->add_off_desig == 'DPT' and $case->dept_note_yn == null){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> Department ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }else{

                                                if ($case->lm_note_yn == 'Y' and $case->notice_generated_yn == 'Y' and $case->proceeding_yn == '1' and $case->dept_note_yn == 'Y') {
                                                    ?>
                                                    <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_conversion_mb/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>
                                                    <!-- <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_adc_conversion_to_be_change/PassToDc?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Forward To DC</a> -->
                                                    <?php
                                                }
                                            
                                            ?>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                            <?php
                                            }
                                            
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } else if ($process == '7') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
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
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <!--<a href="<?php echo base_url(); ?>index.php/dc_conversion_mb/SecondProceeding?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?>-->
                                                <a><?php echo $case->case_no; ?>
                                                     <br>
                                                <span class='small font-italic red'>
                                                   <?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?>
                                                 </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            echo "Circle : ".$circle_code = $this->utilityclass->getCircleName($case->dist_code, $case->subdiv_code, $case->cir_code);
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
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সাখা কর্মকর্তাৰ টোকা অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y') && ($case->pay_notice_gen_yn == null)){
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }


                                            if ($case->status == 'R' and $case->add_off_desig == 'DC' and $case->dept_note_yn == null){?>
                                                <a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>index.php/dc_conversion_mb/DepartmentReverted?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">View & Give Order</a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="showNewDirectRejectModalMb3('<?=$case->case_no?>','<?=SERVICE_CONVERSION_MB3?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                            <?php }
                                            
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

<script>
     $(document).on('click', '#forwardCaseToDc', function(response) {
        var baseurl = $('#baseurl').val();
        var case_no = $('#caseNum').val();
        // console.log(case_no, baseurl);

        $.ajax({
            url: baseurl + 'index.php/dc_adc_conversion_to_be_change/forwardToDc',
            type: 'POST',
            data: {case_no:case_no},
            success: function(response) {
                var response = JSON.parse(response);
                if(response.status == 'success') {
                    alert(response.msg);
                    window.location.reload();
                    // window.location.href = baseurl + 'dc_adc_conversion_to_be_change/GoToDC_ADC?pro=2';
                }
                else if(response.status == 'failed') {
                    alert(response.msg);
                }
            }
        });
    });
    
</script>
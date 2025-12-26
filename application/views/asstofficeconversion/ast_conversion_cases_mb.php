<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1') {
                            echo $this->lang->line('conversion_notice_generation_for_petitioner_and_concerned_parties');
                        } elseif ($process == '2') {
                            echo $this->lang->line('conversion_note_of_action_taken_on_proceeding_order');
                        } elseif ($process == '4') {
                            echo $this->lang->line('confirmation_of_payment_of_premium_conv');
                        } elseif ($process == '3') {
                            echo $this->lang->line('notice_generation_for_clearing_premium');
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="col-lg-10 col-lg-offset-1">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>
            <div class="col-lg-10 col-lg-offset-1">
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
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('due_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_generation?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center"><?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
                                            }
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center"><p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : <?php echo date('d-m-Y', strtotime($case->next_date_of_hearing)); ?></p></td>
                                        <td class="center">
                                            <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_generation?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Give Notice</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } elseif ($process == '2') {
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
                                            if (($case->notice_generated_yn == '') || (strtolower($case->lm_note_yn) != 'y') || (strtolower($case->sk_comment) == null)) {
                                                ?>
                                                <a href="#"><?php echo $case->case_no; ?></a>
                                                <br>
                                                <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } elseif (($case->notice_generated_yn == '') || (strtolower($case->co_order_conv_premium) == 'y')) {
                                                ?>
                                                <a href="#"><?php echo $case->case_no; ?></a>
                                                <br>
                                    <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_action_taken?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                                <br>
                                                <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
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
                                            if ($case->lm_note_yn == '' or $case->lm_note_yn == null) {
                                                echo "<p class='text-primary'> <i class='fa fa-exclamation-triangle red'></i> মন্ডলে প্ৰতিবেদন দিয়া নাই </p>";
                                            }
                                            if ($case->notice_generated_yn == '' or $case->notice_generated_yn == null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> সহায়কৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            if ($case->sk_comment == '' or $case->sk_comment == null) {
                                                echo "<p class='text-info'> <i class='fa fa-exclamation-triangle red'></i> পৰ্য্যবেশক কাননগোৰ মন্তব্য অপ্ৰাপ্ত</p>";
                                            }
                                            if (($case->co_order_conv_premium == 'Y')) {
                                                if($case->co_order_conv_premium != 'P')
                                                {
                                                    echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম আদায়ৰ ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                                }
                                            }
                                            if ($case->co_order_conv_notice != null) {
                                                echo "<p class='text-danger'> <i class='fa fa-exclamation-triangle red'></i> প্রিমিয়াম ঘোষনা জাৰী অপ্ৰাপ্ত</p>";
                                            }
                                            ?>
                                            <?php
                                            if ((strtolower($case->notice_generated_yn) == 'y') && (strtolower($case->notice_served_yn) == 'y') && (strtolower($case->co_order_conv_premium) != 'y') && (strtolower($case->sk_comment) != 'y')) {
                                                ?>
                                                <!-- <a class='text-danger btn btn-info' href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_action_taken?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a> -->
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ((strtolower($case->notice_generated_yn) == 'y') && (strtolower($case->notice_served_yn) == 'y') && ($case->proceeding_yn == null)) {
                                                ?>
                                                <a class='text-danger btn btn-info' href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_action_taken?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a>

                                                <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_generation?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code."&mode=1"; ?>">View Notice</a>
                                                <?php
                                            }
                                            ?>
                                            

                                                
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } elseif ($process == '3') {
                            ?>
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('due_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_premium?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                        </td>
                                        <td class="center"><?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
                                            }
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center"><p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : <?php echo date('d-m-Y', strtotime($case->next_date_of_hearing)); ?></p></td>
                                        <td class="center">
                                            <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/AsistantConversionMb/notice_premium?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Give Notice</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php
                        } elseif ($process == '4') {
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
                                            if (($case->co_order_conv_notice != null) && (strtolower($case->co_order_conv_premium) == 'y')) {
                                                ?>
                                                <a href="#"><?php echo $case->case_no; ?></a>
                                                <br>
                                                <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/AsistantConversionMb/confirmation_premium?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                                <br>
                                                <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if ($case->mut_type == '01') {
                                                echo "Convertion Case";
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
                                                <a class='text-danger btn btn-info' href="<?php echo base_url(); ?>index.php/AsistantConversionMb/confirmation_premium?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a></td>                                    
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



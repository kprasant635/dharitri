<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12  ">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('lm_report_on_miscellaneous_cases'); ?></h2>
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
                            <?php echo $this->lang->line('pattadar_name_correction'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('sl_no'); ?></label></th>
                            <?php
                                if(ESCALATION_ENABLE == 1) {
                                    include(APPPATH."views/common/esc_table_head.php");
                                }
                            ?>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            </thead>
                            <?php
                            $row = count($MisCases);
                            if ($row > 0) {
                                $c = 1;
                                foreach ($MisCases AS $cases) {
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $c; ?></td>
                                        <?php if(ESCALATION_ENABLE == 1) { ?>
                                            <td class="center"><?=$cases->escalation_zone;?></td>
                                            <td class="center"><?=$cases->escalation_date;?></td>
                                        <?php } ?>
                                        <!-- <td><?php echo $cases->misc_case_no; ?></td> -->

                                        <td><?php echo $cases->misc_case_no; ?><br>
                                    <span class='small font-italic red'><?php if($cases->basundhara){ echo "Basundhara:". $cases->basundhara ;} ?> </span></td>
                                        <td class="center"><?php
                                            $type = $cases->misc_case_type;
                                            if ($type == 06) {
                                                echo "নাম সংশোধন";
                                            } elseif ($type == 07) {
                                                echo "নাম কৰ্ত্তন";
                                            }
                                            ?></td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($cases->submission_date)); ?></td>
                                        <td class="center">
                                            <?php if(ESCALATION_ENABLE == 1 && $cases->is_escalated == 1){ 
                                                echo "Escalated to Appellate Authority";
                                             } else { ?>
                                                
        											<?php if($type=='06'){ ?>
                                                    <?php $misc_case_type = $cases->misc_case_type; ?>
                                                    <a href="<?php echo base_url() . "index.php/NameCorrectionV2/LMStep2_revert"; ?>?misc_case_no=<?php echo enc_param('misc_case_no', $cases->misc_case_no, 600)."&petition_no=".$cases->misc_case_petition_no; ?>" class="btn btn-primary"><?php echo $this->lang->line('write_report'); ?> </a>
        											<?php }else{?>
        											<!-- <a href="<?php //echo base_url() . "index.php/NameCancellation/LMStep2"; ?>?misc_case_no=<?php echo enc_param('misc_case_no', $cases->misc_case_no, 600)."&petition_no=".$cases->misc_case_petition_no; ?>" class="btn btn-primary"><?php echo $this->lang->line('write_report'); ?> </a> -->
        											<?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $c++;
                                }
                            }
                            ?>
                        </table>
                        <center>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


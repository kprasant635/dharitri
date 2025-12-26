<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php
                        if ($process == '1') {
                            echo "Notice Generation for Petitioners and concerned parties for Non juridical Entitites";
                        }
                        if ($process == '2') {
                            echo "Action taken for Non juridical Entitites";
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
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                                <th class="center"><label class="control-label">Submitted on</label></th>
                             
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('due_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url(); ?>index.php/AsistantJuridicalMb/notice_generation?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if($case->applid){ echo "RTPS:". $case->applid ;} ?> </span>
                                        </td>
                                        
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td class="center"><p class='text-success'> <i class='fa fa-calendar'></i> Hearing Date : <?php echo date('d-m-Y', strtotime($case->ast_notice_hearing_date)); ?></p></td>
                                        <td class="center">
                                            <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/AsistantJuridicalMb/notice_generation?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>">Give Notice</a>
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
                                
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                                <th class="center"><label class="control-label"><?php echo $this->lang->line('status'); ?></label></th>
                                </thead>
                                <?php foreach ($cases as $case): ?>
                                    <tr>
                                        <td>
                                           
                                            <a href="<?php echo base_url(); ?>index.php/AsistantJuridicalMb/notice_action_taken?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $case->case_no; ?></a>
                                            <br>
                                            <span class='small font-italic red'><?php if($case->applid){ echo "Basundhara:". $case->applid ;} ?> </span>
                                            
                                        </td>
                                        
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td>
                                          
                                            
                                           
                                            <?php
                                            if ($case->ast_notice_generated == 'Y') {
                                                ?>
                                                <a class='text-danger btn btn-info' href="<?php echo base_url(); ?>index.php/AsistantJuridicalMb/notice_action_taken?case_no=<?php echo $case->case_no."&dist_code=".$case->dist_code."&subdiv_code=".$case->subdiv_code."&cir_code=".$case->cir_code."&mouza_pargona_code=".$case->mouza_pargona_code."&lot_no=".$case->lot_no."&vill_townprt_code=".$case->vill_townprt_code; ?>"><?php echo $this->lang->line('write_report'); ?></a>
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



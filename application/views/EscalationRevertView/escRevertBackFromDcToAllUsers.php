<?php

// var_dump(expression)

// 'response'          => 4, 
//           'dc_remaining_days' => $dc_remaining_days,
//           'userCount'         => $userCount,        
//           'view'              => 'EscalationRevertView/escRevertBackFromDcToAllUsers',
//           'environment'       => 'deescalate',
//           'process_code'      => '#4814',


?>


<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center; text-transform:uppercase">Escalation Revert Back <i class='fa fa-undo'></i></h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="error_container">
                    <?php
                        if($this->session->flashdata('required_message')){
                    ?>
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                                <?= $this->session->flashdata('required_message'); ?>
                            </strong>
                        </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-6 rasid">Case No : <span class="bg-yellow"><?php echo $this->utilityclass->decryptJwtCase($this->input->get('case_no')); ?></span></label>
                            <label class="col-sm-2 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url() . 'index.php/DcEscalationController/revertBackEscalationCasesToAllUsers' ?>" method="post" >

                            <?php 
                                $title = "Remaining Days";
                                if($environment == DEESCALATE) 
                                { 
                            ?>
                                    <h4 style="color:red;">This case will be processed as DE-ESCALATION as the total assigned time for escalation has over. Please click on revert button and the days will distribute to all respected users as per percentage.</h4>
                            <?php 
                                    $title = "Remaining Days(Days has been added from De-escalation timeline)";
                                }
                            ?>

<?php 
    // var_dump('$dc_remaining_days :'.$dc_remaining_days); echo "<br>";
    // var_dump('$userCount :'.$userCount); echo "<br>";
    // var_dump('$environment :'.$environment); echo "<br>";
    // var_dump('$process_code :'.$process_code); echo "<br>";
    // die;
?>

                            <table class="table table-striped table-bordered">
                                <tbody>

                                <tr>
                                    <td><strong><?=$title?></strong></td>
                                    <td><?=$dc_remaining_days?></td>
                                </tr>

                                <tr>
                                    <td><strong >Remarks </strong></td>
                                    <td>
                                        <textarea class="form-control" rows="5" name='revert_remarks' id="textArea" placeholder="Please Type Your Reason For Revert Back" required></textarea>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <input type='hidden' name='case_no' value='<?php echo $this->utilityclass->decryptJwtCase(($this->input->get('case_no'))); ?>'> 
                            <input type='hidden' name='revert_to_user' value='<?php echo $this->utilityclass->decryptJwtCase(($this->input->get('revert_to_user'))); ?>'>

                            <input type='hidden' name='env' 
                            value="<?=$this->utilityclass->encryptJwtCase($environment)?>" readonly>

                            <hr style="border-bottom: 2px solid #000;">
                            <center>

                                <?php if($environment == DEESCALATE) { ?>

                                    <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> De-Escalate</button>

                                <?php } else { ?>
                                    <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                <?php } ?>                                
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
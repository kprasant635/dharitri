<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">List Of Miscellaneous Cases For Notice Re-Generateration</h2>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                       <h3 class="panel-title">
                            <?php echo $this->lang->line('pattadar_name_correction'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <!-- <th><label class="control-label"><?php echo $this->lang->line('sl_no');?></label></th> -->
                            <?php if(ESCALATION_ENABLE == 1) { ?>
                                <th>Zone</th>
                                <th width="12%">Escalate On</th>
                            <?php }?>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('notice_generate'); ?></label></th>
                            </thead>
                            <!-- <?php var_dump($Misccaseno);?> -->

                                    <tr>
                                        <!-- <td class="center"><?php echo $c; ?></td> -->
                                        <?php if(ESCALATION_ENABLE == 1) { ?>
                                            <td><?=$Misccaseno->escalation_zone?></td>
                                            <td><?=$Misccaseno->escalation_date?></td>
                                        <?php } ?>
                                        <td><?php echo $Misccaseno->misc_case_no; ?><br>
                                    <span class='small font-italic red'><?php if($Misccaseno->basundhara){ echo "Basundhara:". $Misccaseno->basundhara ;} ?> </span></td>
                                        <td class="center"><?php $type=$Misccaseno->misc_case_type;
                                        if($type==06){
                                            echo "নাম সংশোধন";
                                        }
                                        elseif ($type==07) {
                                            echo "নাম কৰ্ত্তন";
                                        }
                                        ?>
                                        </td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($Misccaseno->submission_date)); ?></td>

                                         <?php if($type==06){ ?>

                                        <td class="center">
                                            <a href="<?php echo base_url() . "index.php/NameCorrection/ASTNoticeGenerate1"; ?>?misc_case_no=<?php echo $Misccaseno->misc_case_no."&petition_no=".$Misccaseno->misc_case_petition_no; ?>" class="btn btn-primary">
                                                <?php echo $this->lang->line('notice_generate');?>
                                            </a>
                                        </td>

                                    <?php }
                                        else if ($type==07) { ?>

                                            <td class="center">
                                            <a href="<?php echo base_url() . "index.php/NameCancellation/ASTNoticeGenerate1"; ?>?misc_case_no=<?php echo $Misccaseno->misc_case_no."&petition_no=".$Misccaseno->misc_case_petition_no; ?>" class="btn btn-primary">
                                                <?php echo $this->lang->line('notice_generate');?>
                                            </a>
                                        </td>
                                            
                                       <?php  }
                                        ?>




                                    </tr>
                                    
                            
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


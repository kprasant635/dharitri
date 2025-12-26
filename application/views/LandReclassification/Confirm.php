<div class="row login panel-form" style="min-height: 500px;">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u>Please Note...!!!!</u></span></p>
                </div>
                <div class="col-lg-6 uni_text"><?php echo $this->lang->line('case_no'); ?> : <?php echo $det['case_no']; ?> </div>
                <div class="col-lg-6 uni_text"><span style="float:right;"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y') ?></div>
                <hr style="border-bottom: 2px solid #000;">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="rasid table">
                            <tr>
                                <td style="text-align: center;">Are You Sure you want to update the Chitha for Land Reclassification of</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; font-size: 30px;">Dag No <?php echo $Pcases->dag_no; ?>, Patta No <?php echo $Pcases->patta_no; ?>
                                    from Land Class <?php echo $det['old_land_class']; ?> To <?php echo $det['proposed_land_class']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {?>

                         <a href="<?php echo base_url(); ?>index.php/LandReclassification/SaveLandReclassification?case_no=<?php echo $Pcases->case_no . "&proposal_no=" . $det['proposal_no'] . "&ulpin=" . $ulpin. "&ulpinCheckFlag=".$ulpinCheckFlag. "&compareCheckFlag=".$compareCheckFlag; ?>" class="btn btn-success">
                            <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('pass_order_and_chitha_update'); ?>
                        </a>
                    <?php }else{?>

                        <a href="<?php echo base_url(); ?>index.php/LandReclassification/SaveLandReclassification?case_no=<?php echo $Pcases->case_no."&proposal_no=".$det['proposal_no']; ?>" class="btn btn-success">
                            <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('pass_order_and_chitha_update');?>
                        </a>
                    <?php }?>


                        <a href="<?php echo base_url(); ?>index.php/LandReclassification/dcWaitLandReclassification?case_no=<?php echo $Pcases->case_no."&proposal_no=".$det['proposal_no']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you dont want to UPDATE THE CHITHA?')">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
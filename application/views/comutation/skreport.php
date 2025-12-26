<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> 
                        <?php echo $this->lang->line('reject'); ?> <?php echo $case_no;?> <?php echo $this->lang->line('for_dag(s)'); ?> <?php foreach($dag_no as $dag )echo $dag->dag_no.".";?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                             Write Reason For Rejecting <?php echo $case_no;?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/cofieldmutation/saveReport"; ?>" method="post">
                            <input type="hidden" name='case_no' value="<?php echo $case_no; ?>"/>
                            <input type="hidden" name='dist_code' value="<?php echo $dist_code; ?>"/>
                            <input type="hidden" name='subdiv_code' value="<?php echo $subdiv_code; ?>"/>
                            <input type="hidden" name='cir_code' value="<?php echo $cir_code; ?>"/>
                            <input type="hidden" name='mouza_pargona_code' value="<?php echo $mouza_pargona_code; ?>"/>
                            <input type="hidden" name='lot_no' value="<?php echo $lot_no; ?>"/>
                            <input type="hidden" name='vill_townprt_code' value="<?php echo $vill_townprt_code; ?>"/>
                            <textarea class='form-control' rows='10' name='sk_note' required="true"></textarea>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Save Report</button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

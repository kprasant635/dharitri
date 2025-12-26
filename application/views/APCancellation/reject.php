<div class="container-fluid login form-top">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">Reject Case</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <?php echo $_GET['case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?>	: <?php echo date("d-m-Y", strtotime($_GET['submission_date'])); ?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/APCancellation/SaverejectNote"; ?>"> 
                            <?php
                            $dist_code = $_GET['dist_code'];
                            $subdiv_code = $_GET['subdiv_code'];
                            $cir_code = $_GET['cir_code'];
                            $lot_no = $_GET['lot_no'];
                            $vill_townprt_code = $_GET['vill_townprt_code'];
                            $year_no = $_GET['year_no'];
                            $petition_no = $_GET['petition_no'];
                            $case_no = $_GET['case_no'];
                            $mouza_pargona_code = $_GET['mouza_pargona_code'];
                            $submission_date = $_GET['submission_date'];
                            ?>
                            <input type="hidden" name="dist_code" value="<?php echo $dist_code; ?>"/>
                            <input type="hidden" name="subdiv_code" value="<?php echo $subdiv_code; ?>"/>
                            <input type="hidden" name="cir_code" value="<?php echo $cir_code; ?>"/>
                            <input type="hidden" name="lot_no" value="<?php echo $lot_no; ?>"/>
                            <input type="hidden" name="vill_townprt_code" value="<?php echo $vill_townprt_code; ?>"/>
                            <input type="hidden" name="year_no" value="<?php echo $year_no; ?>"/>
                            <input type="hidden" name="petition_no" value="<?php echo $petition_no; ?>"/>
                            <input type="hidden" name="case_no" value="<?php echo $case_no; ?>"/>
                            <input type="hidden" name="mouza_pargona_code" value="<?php echo $mouza_pargona_code; ?>"/>
                            <input type="hidden" name="submission_date" value="<?php echo $submission_date; ?>"/>
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label">Please Type Rejection Reason</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" name="reject_report" rows="6">Please Type Something Here</textarea>
                                </div> 
                            </div>
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="FormSubmit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


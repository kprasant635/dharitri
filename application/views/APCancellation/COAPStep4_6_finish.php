<div class="container-fluid login form-top">
    <div class="row ">
        <div class="col-lg-12">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('co_finishing_step_of_ap_cancellation'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <div style="text-align: center;" class='uni_text'>
                            <!--                            The case no <strong><?php //echo $this->session->userdata('case_no'); 
                                                                                ?></strong> is successfully finished.-->
                            <br />
                            গোচৰ নং <strong><?php echo $case_no; ?></strong> ৰ <?php echo $namedata[0]->district; ?> জিলাৰ
                            <?php echo $namedata[3]->mouza; ?> মৌজাৰ
                            <?php echo $namedata[5]->village; ?>
                            গাঁওৰ <?php echo $countAPCase->patta_no; ?> নং
                            <?php echo $countAPCase->patta_type; ?> পট্টাৰ
                            <?php echo $countAPCase->dag_no; ?>

                            নং দাগটো “পট্টা ৰদ” ৰ বাবে নিৰ্দেশ দিয়া হল ।

                            <br />
                            <br />
                            <a href="<?php echo base_url() . 'index.php/APCancellation/updateChithaApCancel?case_no=' . $case_no ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;Update Chitha Now
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
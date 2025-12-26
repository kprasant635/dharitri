<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Fresh Report</h2>
                </div>
                <div class="error_container">
                        <?php
                            if($this->session->flashdata('message_extra')){
                        ?>
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message_extra'); ?>
                                </strong>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid">Case No : <?php echo $this->input->get('case_no'); ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url() . 'index.php/lmmutation/freshReportBackMultiDag' ?>" method="post" >
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">Type Note</label>
                                <div class="col-lg-7">
                                    <textarea class="form-control" rows="5" name='note_order' id="textArea" placeholder="Please Type Your Report"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                
                            </div>
                            <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'> 
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
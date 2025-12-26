<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Update Next Date of Hearing</h2>
                    <?php
                            if($this->session->flashdata('message')){
                        ?>
<div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
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
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $this->session->userdata('case_no'); ?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url() . "index.php/partition/updateProDate"; ?>" method="post" >
                            <div class="form-group">
                                <label for="textArea" class="col-lg-4 control-label">Changed Date Of Hearing</label>
                                <div class="col-lg-6 control uni_text"> 
                                    <input class='form-control' placeholder='Click here to Change Date' required name='update_date' id='popupDatepicker' >
                                    <input type='hidden'  required name='case_no' value='<?php echo $this->session->userdata('case_no'); ?>' />
                                </div>
                                <div class="col-lg-2 control uni_text">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textArea" class="col-lg-4 control-label">Reason For Change in Date</label>
                                <div class="col-lg-6">
                                    <textarea class="form-control" rows="5" name='remark' id="textArea" placeholder="  Write here....."></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <button type="submit" id='formsubmit' class="btn btn-success uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/coofficemutation/getPendingMutationCases?id=2" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

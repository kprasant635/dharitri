<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Deed Proceeding Order</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('deed_no'); ?> : <?php echo $this->input->get('deed'); ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url() . 'index.php/DisplayDeed/FinalUpdatestatus' ?>" method="post" >
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">Nature Of Land</label>
                                <div class="col-lg-6 control uni_text">
                                    <input type="radio" name="nature_of_land" id="inlineRadio1" value="r" required> গ্রামীণ/গাওঁ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="nature_of_land" id="inlineRadio1" value="u" required> নগৰ/চহৰ
                                </div>
                                <div class="col-lg-2 control uni_text">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">CO's Order</label>
                                <div class="col-lg-7">
                                    <textarea class="form-control" rows="5" name='co_order' id="textArea">Please Register a mutation case against the Deed Number:<?php echo $this->input->get('deed'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                
                            </div>
                            <input type='hidden' name='deedno' value='<?php echo $this->input->get('deed'); ?>'> 
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
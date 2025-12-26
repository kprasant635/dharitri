<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 panel-form">
            <h2 class="uni_text center"><?php echo $this->lang->line('co_order');?></h2>
            <?php //print_r($dag);?>
            <hr>
            <div class="col-lg-4 uni_text"> <?php echo $this->lang->line('case_no');?> : <?php echo $this->session->userdata('case_no');?> </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('order_srno');?>: 5 </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y')?></div>
            <div class="col-lg-12">
                <form class="form-horizontal" style="margin-top:30px; margin-bottom: 10px" method="POST" action="<?php echo base_url();?>index.php/partition/COInFavOfDtls">
                
                    <legend><h2><?php echo $this->lang->line('dag_details')?></h2></legend>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('dag_no')?> :</label>
                        <div class="col-lg-4">
                            <input type="text" value="<?php echo $dag->dag_no ?>" class="form-control" name="dag" >
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-info uni_text" type="submit"><?php echo $this->lang->line('submit_button')?><i class="fa fa-arrow-circle-o-right "></i> </button>
                        </div>
                    </div>
            </form>
                <button class="btn btn-primary col-lg-offset-5" style="margin-top: 20px" disabled="" type="submit"><?php echo $this->lang->line('next')?>  >> </button> 
            </div>
        </div>
    </div>
</div>


<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-5 col-lg-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                             Please Type Exact Case Number 
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/coofficemutation/ActionTakenReport"; ?>" method="post">
                            <input type="text" class='form-control ' name='case_no' placeholder="Type Here / Copy-Paste Case Number"  />
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-2">
                                    <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Generate Report</button>
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

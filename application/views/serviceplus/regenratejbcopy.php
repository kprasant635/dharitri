<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Regenerate Jamabandi Copy </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">                        
                        <hr style="border-bottom: 2px solid #000;">
                        <form name='frmDelete' method='post' action='<?php echo base_url() . "index.php/serviceplus/regenerateJB"; ?>'>
                            <p style="color:red; font-weight: bold !important; font-size: 18px;" class='center'>Please Enter Valid Dharitree Case no./RTPS Case No</p>
                            <div class="row">
                                <div class="col-lg-8 col-lg-offset-3">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <input type="text" placeholder="Enter Case Number Here" name="cert_no" required='' class="form-control" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group center">
                                <div class="col-lg-12">
                                    <button type="submit" name="del_button" id="sbutton"  class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
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

<style>
    .nav-tabs li{
        background:#3bafda;
        color:#fff;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active{
        background:#800000 !important;
        color:#fff;
    }
    .nav-tabs li a{
        color:#fff;
        font-size:19px;
        font-weight:bold;
    }


</style>    
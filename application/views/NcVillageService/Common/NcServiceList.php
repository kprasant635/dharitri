
<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        padding: 15px;
        position: relative;
        width: 100%;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

</style>

<?php if($this->session->flashdata('success')) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 reza-card ">
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if($this->session->flashdata('error')) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 reza-card ">
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container-fluid" style="margin-top: 35px">
    <div class="col-lg-12">
        <div class="row">
            <?php foreach($output as $row): ?>
                <?php if(in_array($row->service_code, [25,26,27] )) :?>
                    <div class="col-lg-4" >
                        <div class="card bg-info text-white">
                            <div class="card-body text-white">
                                <h4><?=$row->service;?></h4>
                                Application Received: <kbd id='circle'><?=$row->count?></kbd>
                                <a href="<?php echo base_url() ?>index.php/NcVillageHomeController/request/<?=$row->service_code?>"><i class="fa fa-hand-o-right fa-3x pull-right" title="Please Click Here to Check Details" ></i></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<style type="text/css">
    .card-body{  background: #7b4397; /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #7b4397, #dc2430); /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #7b4397, #dc2430); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */);}
    #circle {
        background: #0f546a;
        border-radius: 30%;
        padding: 7px !important;
        font-weight: bold;
        font-size: 2em;
    }
</style>


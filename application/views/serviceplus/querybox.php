<script src="<?php echo base_url(); ?>application/views/resources/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dsc-signer.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>application/views/resources/js/dscapi-conf.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/views/resources/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>application/views/resources/css/dsc-signer.css">

<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10' style="margin: 0 auto;float: none;">
            <div class="panel panel-primary panel-form">
                <div class="panel-body">
                    <?php //var_dump($this->session->all_userdata()); ?>
                    <hr>
                    <div class="col-lg-12 ">
                        <div class="alert alert-info">
                            <form class="form-horizontal unicode" method='post' action='<?php echo base_url();?>index.php/serviceplus/ResultQuery'>
                                <textarea name='sql' class="form-control" rows='8' cols='8' ></textarea>
                                <input type="Submit" value="Search" class="btn btn-info"> 
                            </form>
                            <div id="panel"></div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>
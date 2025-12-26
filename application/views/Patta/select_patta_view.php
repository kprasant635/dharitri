<script>
    $(function () {
        $('#myModal').modal({});
    })
</script>
<style>
    .modal_body p {
        font-family: 'Calibri' !important;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-info panel-form">
                <div class="panel-heading bg-success text-white  my-2">
                    <h3 class="panel-title text-center font-weight-bold">Patta Details</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title text-center">View Patta</h3>
                </div>
                <div class="panel-body">
                    <!--                    --><?php //echo form_open(base_url('index.php/Patta/viewPatta'), array('class' => 'form-horizontal')); ?>
                    <form method="get" action="<?= base_url() . 'index.php/Patta/viewPatta' ?>" class="form-horizontal">
                    <div class="form-group">
                        <label for="select" class="col-lg-3 uni_text control-label required">Case No.</label>
                        <div class="col-lg-9">
                            <input type='text' name='case_no' id="case_no" placeholder='Case No.'
                                   class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary"><i
                                        class='fa fa-check'></i> <?php echo $this->lang->line('submit_button') ?>
                            </button>
                        </div>
                    </div>
                    </form>
                    <?php if ($this->session->flashdata('message')): ?>
                        <div class="col-lg-12 ">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <strong class="rasid"
                                        style="color:red !important"><?php echo $this->session->flashdata('message'); ?></strong>
                            </div>
                            <?php if ($this->session->flashdata('message2')): ?>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <strong class="rasid"
                                            style="color:red !important"><?php echo $this->session->flashdata('message2'); ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/patta.js"></script>
<div class="col-md-12 text-right text-cyan">
    Process > 
    Settlement MB3 > 
    <a href="<?php echo base_url(); ?>index.php/Home/TeaGrantLandCo?service=<?=TEA_SERVICE_CODE?>" style="text-decoration: none;">Tea Grant</a> > 
    <b>View</b>
</div>

<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
        First Proceeding
        </h4>
    </div>

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>


<?php
    include(APPPATH."views/TeaGrant/CO/TeaGrantPaginationList.php");
?>
<div class="col-md-12 text-right text-cyan">
    Process > Settlement MB3 > 
    <a href="<?=base_url().'index.php/Home/TeaGrantLandCo?service='.TEA_SERVICE_CODE?>">Tea Grant</a> > 
    <b>View</b>
</div>
<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Re-Report By LM/SK
        </h4>
    </div>
    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>

<?php
    include(APPPATH."views/TeaGrant/CO/TeaGrantCOResubmitLMCaseList.php");
?>
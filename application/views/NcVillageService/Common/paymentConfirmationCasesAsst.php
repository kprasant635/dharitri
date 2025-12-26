<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Confirm Payment list
        </h4>
    </div>

    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>

<?php
include(APPPATH."views/SettlementView/include/asstMenuMb2.php");
?>
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
    //include(APPPATH."views/SettlementView/include/coMenuMb2.php");
?>
<?php
    include(APPPATH."views/reclass_suite/co/ReclassSuitePaginationList.php");
?>
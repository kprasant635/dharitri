<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Reverted by ADC/SDO for VGR/PGR reservation
        </h4>
    </div>
    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>


<table class="table" id="dataTable">
    <thead>
        <tr>
            <th>Case No</th>
            <th>Applicaiton No</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($result_tb as $tb)
        {
            ?>
            <tr>
                <td><?=$tb->case_no?></td>
                <td><?=$tb->applid?></td>
                <td><a type="button" href="<?php echo base_url() ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=<?=$tb->case_no?>" class="lmreportmut btn-sm btn btn-primary">
                        write report</a></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>


<script>
	$(document).ready( function () 
    {
    	$('#dataTable').DataTable();
    });
</script>
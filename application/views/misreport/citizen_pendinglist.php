<style>
.text-dec{
	display:none;
}
</style>
<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" > 
            <table id='' class="example table table-bordered">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Case No</th>
                        <th>Date Entry</th>
                        <th>Applicant</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($cert as $c) { ?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?=$c['cert_no']?></td>
                        <td><?=date('d/m/Y',strtotime($c['date_entry']))?></td>
                        <td><?=$c['appln_name']?></td>
                        <td><?=$c['status']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table> 
            
            <center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url().'index.php/MisReport/DisposeForPP'?>"; //DisposeForPPSubmitdist
    };
	$(document).ready(function() {
    $('.example').DataTable();
} );
</script>

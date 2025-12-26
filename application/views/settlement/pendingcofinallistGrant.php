<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">
            <table id="example" class="table table-hover  panel-body" width="100%">
                <thead >
                    <tr >
                        <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('status') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
               //var_dump($cases);
                foreach ($cases as $case): ?>
                    <tr>
                        <td><?php echo $case->case_no; ?></td>
                        <td>PP</td>
                        <td><i class="fa fa-calendar"></i> <?php  echo   date('d/m/Y',  strtotime($case->date_entry)) ; ?></td>
                        <td>
                            <a  href='<?php echo base_url() . "index.php/Settlement/FinalcoorderGrant?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->circle_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>' class="btn btn-danger">Update Dag & Patta</a>
                        </td>
                       
                    </tr>
                <?php endforeach; ?>
	</tbody>
            </table>
           
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#example').DataTable({
	"bLengthChange": false,
	"showNEntries" : false,
	"bSort" :	false,
	"bnew" :	false,
	"pageLength": 20
  });
  
});
</script> 
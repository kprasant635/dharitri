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
                        <td><?php echo $case->case_no; ?>
                            <br><span class='small font-italic red'> </span>
                        </td>
                        <td>Settlement of Khas and Ceiling surplus land</td>
                        <td><i class="fa fa-calendar"></i> <?php  echo   date('d/m/Y',  strtotime($case->date_entry)) ; ?></td>
                        <td>
                            <?php if($case->status=='R' AND $case->pending_officer=="CO" AND $case->from_office=="DC") { ?>
                                <a href="<?php echo base_url() ?>index.php/SettlementMbCo/revertedCasesByDC" class="btn btn-danger">Write Report</a>
                            <?php } else if($case->status=='X' AND $case->pending_officer=="CO" AND $case->from_office=="DC") { ?>

                            <?php }?>
                            
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
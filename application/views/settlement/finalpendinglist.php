<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">
            <table id="example" class="table table-hover  panel-body" width="100%">
                <thead >
                    <tr >
                        <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
						<th class="alert-new">Next Hearing Date<?php //echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('status') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
               // var_dump($cases);
                foreach ($cases as $case): ?>
                    <tr>
                        <td><?php echo $case->case_no; ?></td>
                        <td>Settlement to PP</td>
                        <td><i class="fa fa-calendar"></i> <?php  echo   date('d/m/Y',  strtotime($case->date_entry)) ; ?></td>
						<td><i class="fa fa-calendar"></i> <?php  echo   date('d/m/Y',  strtotime($case->next_date_hearing)) ; ?></td>
                        <td><a class='btn btn-danger' href='<?php echo base_url() . 'index.php/Settlement/dcfinalorder' ?>?case_no=<?php echo $case->case_no ?>'>PROCESS</a>
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
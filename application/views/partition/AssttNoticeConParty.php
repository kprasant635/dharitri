<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">
            <?php if ($this->session->userdata('message')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                </div>
            <?php endif; ?>
            <table id="example" class="table table-hover panel-body" style="margin:auto; "  width="100%">
                <thead >
                    <tr >
                        <th class="alert-info"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('status') ?></th>

                    </tr>
                </thead>
                <tfoot >
                    <tr>
                        <th class="alert-info"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('certificate_type'); ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-info"><?php echo $this->lang->line('status') ?></th>

                    </tr>
                </tfoot>

                <tbody>
                    <?php
                    //var_dump($casess);
                    foreach ($casess as $case):
						$class=null;
                        ?>
                        <tr>
                            <td><?php echo $case['case_no']; ?><br>
							<?php
								if($case['application_ref_no']){
									echo "<i class='small'> ( ".$case['application_ref_no'] ." )</i>";
									$class='hide';
								}else{
									$class=null;
								}
							?>
							</td>
                            <td><?php echo ($case['mut_type'] == 04) ? 'Office' : 'Partition'; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($case['date_entry'])); ?></td>
                            <td>
                                <a class="btn btn-danger <?=$class?>" href="<?php echo base_url() ?>index.php/partition/AstReportGen?case=<?php echo $case['petition_no'] ?>">
    <?php echo $this->lang->line('write_report'); ?></a>
								<?php
								if($case['application_ref_no']){
								?>
								<a class="btn btn-info btn-sm" href="<?php echo base_url() ?>index.php/serviceplus/paymentQuery?case=<?php echo $case['case_no'] ?>">
    Check Payment</a>
								<?php
								}
								?>
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
	"bInfo" :	false,
	"pageLength": 20
  });
  
});
</script> 
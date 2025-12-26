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
            <table id="example" class="table table-hover  panel-body" width="100%">
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
                    // var_dump($cases);
                    foreach ($cases as $case):
                        ?>
                        <tr>
                            <td><?php echo $case->case_no; ?></td>
                            <td><?php echo $this->lang->line('office_partition'); ?></td>
                            <td><i class='fa fa-calendar'></i>  <?php echo date('d/m/Y', strtotime($case->submission_date)); ?></td>

                            <td>
                                <a class="btn btn-danger"  href="<?php echo base_url() ?>index.php/partition/IstharReport?case=<?php echo $case->case_no ?>">
    <?php echo $this->lang->line('write_report'); ?></a>
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

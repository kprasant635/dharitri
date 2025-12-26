
    <div class="col-md-12" style="min-height: 500px; margin-top: 10px; margin-bottom: 10px">
        <div class="panel">
            <div class="panel-body">
                <table id="example" class="table table-hover"  width="100%">
                    <thead class="alert-new">
                        <tr >
                            <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('certificate_type'); ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('delivery_date') ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('status') ?></th>

                        </tr>
                    </thead>

                    <tfoot class="alert-danger">
                        <tr >
                            <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('certificate_type'); ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('delivery_date') ?></th>
                            <th class="alert-new"><?php echo $this->lang->line('status') ?></th>

                        </tr>
                    </tfoot>
 
        <tbody>
            <?php 
            //var_dump($caseD);
            foreach($caseD as $c)
            {
            ?>
            <tr>
                <td><?php echo $c->cert_no; ?></td>
                <td><?php
                $name = $this->utilityclass->getCertName($c->cert_type);
                echo $name; ?></td>
                <td><?php echo date('d/m/Y',  strtotime($c->apply_date)) ; ?></td>
                <td><?php echo date('d/m/Y',  strtotime($c->next_due_date)) ; ?></td>
                <td><?php
                if($c->status== 'M')
                {
                    $status='Pending with LM';
                    echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }
                elseif ($c->status== 'C') {
                    $status='Pending with CO';
                    echo "<button type=\"button\" class=\"btn btn-danger\">$status</button>";
                }
                elseif ($c->status== 'R') {
                    $status='Certificate is Ready';
                    echo "<button type=\"button\" class=\"btn btn-warning\">$status</button>";
                 }
                 elseif ($c->status== 'D') {
                     $status='Certificate Delivered';
                     echo "<button type=\"button\" class=\"btn btn-success\">$status</button>";
                 }
                //echo $status; ?></td>
            </tr>
            <?php
            } 
            ?>
            
        </tbody>
    </table>
                </div>
        </div>
        <hr>
      <div class="btn btn-primary uni_text col-lg-offset-4" id="MainIndex"><i class="fa fa-arrow-circle-down"></i> আগৰ মেনুলৈ যাওঁক </div>
    </div>

<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>

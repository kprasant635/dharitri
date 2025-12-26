<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">Trace Map Cases</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                       <h3 class="panel-title">
                            pending Trace Map
                        </h3>
                    </div>
                    <div class="panel-body">
                       
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='example' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('sl_no');?></label></th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="alert-info"><?php echo $this->lang->line('certificate_type'); ?></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>
                            </thead>
                            <?php
                            $row = count($MisCases);
                            if ($row > 0) {
                            $c = 1;
                            foreach ($MisCases AS $cases) 
                            {
                                
                                ?>
                                <tr>
                                    <td class="center"><?php echo $c; ?></td>

                                    <td><?php echo $cases->case_no; ?><br><span class='small font-italic red'><?php if($cases->basundhara){ echo "RTPS:". $cases->basundhara ;} ?> </span>
                                    </td>
                                   <td>Trace Map</td>
                                    <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date("d-m-Y", strtotime($cases->submission_date)); ?></td>
                                    <td class="center"><a href="<?php echo base_url() . "index.php/Tracemap/LMStep2"; ?>?case_no=<?php echo $cases->case_no; ?>" class="btn btn-sm btn-primary"> <?php echo $this->lang->line('pass_order');?></a></td>
                                </tr>
                                <?php
                                $c++;
                            }
                            } 
                            ?>
                        </table>
                    
                         </div>
                        <center>
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable({
    
  });
  
});
</script> 
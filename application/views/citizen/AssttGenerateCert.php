
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php echo "Citizen Centric Services"; ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($this->session->userdata('message')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong><?php
                                    echo $this->session->userdata('message');
                                    $this->session->unset_userdata('message');
                                    ?>
                            </div>
                        <?php endif; ?>
                        <table id="user_data" class="table table-bordered table-striped">  
                            <thead>  
                                <tr>  
                                    <td><?php echo $this->lang->line('case_no'); ?></td>
                                    <td><?php echo $this->lang->line('certificate_type'); ?></td>
                                    <td><?php echo $this->lang->line('submission_date') ?></td>
                                    <td><?php echo $this->lang->line('delivery_date') ?></td>
                                    <td><?php echo $this->lang->line('status'); ?></td> 
                                </tr>  
                            </thead>  
                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
      var dataTable = $('#user_data').DataTable({  
           "processing":true,
           "pageLength":20,
           //"lengthChange":false,  
           "serverSide":true,
           "deferRender":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url() . 'index.php/DataTableController/CitizenCentricAst'; ?>", 
                type:"POST"  
           },  
           "columnDefs":[  
                {  
                     //"targets":[0, 3, 4],  
                     "orderable":false,  
                },  
           ],
           "lengthMenu": [[15,30,50],[15,30,50]]  
      });  
 });  
 </script>



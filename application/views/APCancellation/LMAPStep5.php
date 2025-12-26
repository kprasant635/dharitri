
<div class="container-fluid form-top login">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center; "><?php echo $this->lang->line('pattadar_detail_entry_for_ap_cancellation');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           <?php echo $this->lang->line('case_no');?> : <?php echo $caseno; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . "index.php/APCancellation/ASTStep5"; ?>">
                             <table class="table table-striped table-bordered" width="100%">
                                <tr>
                                    <th><?php echo $this->lang->line('sl_no');?></th>
                                    <th>
                                        <?php echo $this->lang->line('pattadar_name');?>
                                    </th>
                                    <th>
                                        <?php echo $this->lang->line('guardian_name');?>
                                    </th>
                                    <th>
                                        <?php echo $this->lang->line('relation');?>
                                    </th>
                                 </tr>
                                <?php $c=1; foreach($pdar_info AS $pdar){?>
                                 <tr>
                                     <td><?php echo $c;?></td>
                                     <td><?php echo $pdar->pdar_name;?></td>
                                     <td><?php echo $pdar->pdar_father;?></td>
                                     <td><?php echo $this->utilityclass->get_relation($pdar->pdar_guard_reln);?></td>
                                 </tr>
                                <?php $c++;}?>
                             </table>
                            
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <center>
                                        <button type="submit" name="ASTStep5Submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger disabled">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                        </a>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


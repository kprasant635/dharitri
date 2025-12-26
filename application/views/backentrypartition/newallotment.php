<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 " style="margin: 0 auto;float: none;">
            <div class='row' style='min-height:400px'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'>New Dag and New Patta</p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal'  action="<?php echo base_url(); ?>index.php/Backlogpartition/back_step_three" method="post">
                          
                            <div class="form-group">
                                <label for="inputEmail3"  class="col-sm-3 uni_text control-label required">New Dag Number</label>
                                <div class="col-sm-2">
                                    <input type="text"  class="form-control" name="new_dag" value="<?php echo $dagpatta['newdag']; ?>" >
                                </div>
                                <label for="inputEmail3"  class="col-sm-3 uni_text control-label required">New Patta Number</label>
                                <div class="col-sm-2">
                                    <input type="text"  class="form-control" name="new_patta" value="<?php echo $dagpatta['newpatta']; ?>" >
                                </div>
                            </div>
                            <div class=" hide form-group">
                                <label for="inputEmail3"  class="col-sm-3 uni_text control-label required">Old Dag List</label>
                                <div class="col-sm-2">
                                    
                                </div>
                                <label for="inputEmail3"  class="col-sm-3 uni_text control-label required">Old Patta List</label>
                                <div class="col-sm-2">
                                    <input type="text"  class="form-control" name="pdar_cron_no" value="<?php echo $dagpatta['newpatta']; ?>" >
                                </div>
                            </div>
                          
                            
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?></button>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">     
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Central Diary For Mutation / Partition / Conversion Case(s)</h3>
                </div>
                <?php 
                $this->session->userdata('user_desig_code');
                $user_desig_code = $this->session->userdata('user_desig_code');
                if ( ($user_desig_code == 'CO') ) {
                    $action=base_url()."index.php/CentralDiary/casediary";
                }else{
                     $action=base_url()."index.php/CentralDiary/casediaryR";
                }
                ?>
                
                <div class="panel-body" style="min-height: 330px">
                    <form class="form-horizontal" method="POST" action="<?php echo $action ?>">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('starting_date'); ?></label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control stdate"  name="sdate"  placeholder="dd-mm-yyyy">
                                          <span class="help-block">Note : Please follow the date in correct format dd-mm-yyyy</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo $this->lang->line('end_date'); ?></label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control endate" name="edate" placeholder="dd-mm-yyyy">
                                          <span class="help-block">Note : Please follow the date in correct format dd-mm-yyyy</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9 col-lg-offset-3">
                                        <button type="submit" class="btn btn-primary" onclick="LoadData();"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?> </button>
                                        
                                    </div>
                                </div>
                              

                            </fieldset></form>
	<button id="MainIndex" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                </div>
            </div>
        </div>
    </div>
    
</div>
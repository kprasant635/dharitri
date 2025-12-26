<script type="text/javascript">
    function onlyint(patta){
        //alert(patta);
        if(patta.length>0){
        var regex =/^[0-9]{1,10}$/;
        if (regex.test(patta)) {
             return true;
        }
        else{
            document.f1.patta_no.value="";
            alert('Only numeric values');
            return false;
        }
        }
    }
</script>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('petition_for_ap_cancellation');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">                            
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $countland = 0;
                        foreach ($AvilLand AS $land) {
                            $countland = $AvilLand->countland;
                        }
                        if ($countland > 0) {
                            ?>
                            <form class="form-horizontal" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">  
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mutation_type');?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control subdivselect" id="select" name="mut_type" required>
                                            <option value="0504">পট্টা ৰদ (একচনা পট্টা)</option>
                                        </select>
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('submission_date');?></label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="popupDatepicker" readonly name="submission_date" value="<?php echo date("Y-m-d"); ?>" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no');?></label>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control" autocomplete="off" name="patta_no" id="patta_no" value="" onkeyup="return onlyint(this.value);"  required />
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type');?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control subdivselect" id="select" name="patta_type_code" required>
                                            <?php foreach ($eksonapatta AS $patta) { ?>
                                                <option value="<?php echo $patta->type_code; ?>"><?php echo $patta->patta_type; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                        
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('address_to_the_officer');?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control subdivselect" id="select" name="add_off_name" required>
                                            <option selected disabled><?php echo "-- ".$this->lang->line('select')." --";?></option>
                                            <?php foreach ($coname AS $name) { ?>
                                                <option value="<?php echo $name->user_code; ?>"><?php echo $name->username; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('designation');?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control subdivselect" id="select" name="add_off_Desig" required>
                                            <option value="CO" selected><?php echo $this->lang->line('co');?></option>
                                        </select>
                                    </div>
                                </div>                      
                                <div class="form-group">
                                    <div class="col-lg-12 center">
                                        <button type="submit" name="ASTStep2Submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                        <button type="reset" class="btn btn-warning"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                        <a href="<?php echo base_url(); ?>index.php/APCancellation/LMAPStep1">
                                            <button type="button" class="btn btn-danger">
                                                <i class='fa fa-arrow-left'></i>&nbsp;<?php echo $this->lang->line('back');?>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </form>                        
                        <?php } else { ?>                           
                            <div class="form-group">
                                <div class="col-lg-12 uni_text center red"><?php echo $this->lang->line('no_eksona_patta_type_land');?></div>
                                <div class="col-lg-12 uni_text center">
                                    <a href="<?php echo base_url(); ?>index.php/APCancellation/LMAPStep1">
                                        <button type="button" class="btn btn-danger">
                                            <i class='fa fa-arrow-left'></i>&nbsp;<?php echo $this->lang->line('back');?>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

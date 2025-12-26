<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center; "><?php echo $this->lang->line('petitioner_detail_entry_for_ap_cancellation');?></h2>
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
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . "index.php/APCancellation/ASTStep3"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label red">
                                    <?php
                                    $i = $petid + 1;
                                    echo "<u>".$this->utilityclass->ordinal_suffix_of($i)." ".$this->lang->line('petitioner_no')."</u>";?>
                                </label>
                                <div class="col-lg-3 hide">
                                    <input type="text" class="form-control" name="pet_id" value="<?php echo ($petid + 1); ?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('petitioner_name');?></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="pet_name" value="" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('guardian_name');?></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="guard_name" value="" required/>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('relation');?></label>
                                <div class="col-lg-4">
                                    <select class="form-control subdivselect" id="select" name="guard_rel" required>
                                        <option selected disabled><?php echo "-- ".$this->lang->line('select')." --";?></option>
                                        <?php foreach($relation AS $rel){?>
                                        <option value="<?php echo $rel->guard_rel;?>"><?php echo $rel->guard_rel_desc;?> [<?php echo $rel->guard_rel_desc_as;?>]</option>
                                        <?php }?>
                                    </select>
                                </div>                               
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('address1');?></label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="add1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('address2');?></label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="add2"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" name="ASTStep3Submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    <button type="reset" class="btn btn-warning"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>                                    
                                    <?php 
                                    if($petid == '0')
                                    {
                                    ?>
                                    <a href="<?php echo base_url() . "index.php/APCancellation/ASTStep4"; ?>" class="btn btn-danger pull-right disabled">
                                        <?php echo $this->lang->line('next');?>&nbsp;<i class="fa fa-arrow-right"></i>
                                    </a>
                                    <?php
                                    }
                                    else 
                                    {
                                    ?>
                                    <a href="<?php echo base_url() . "index.php/APCancellation/ASTStep4"; ?>" class="btn btn-danger pull-right">
                                        <?php echo $this->lang->line('next');?>&nbsp;<i class="fa fa-arrow-right"></i>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

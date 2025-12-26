
<div class="row login">
        
    <div class="col-lg-10 col-lg-offset-1">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm ">
                <h3 style="text-align: center; font-size: 28px">Generate list of Patta Nos. by Pattadar Names</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">
                    
                    <form class="form-horizontal unicode" name="form" method='post' action="<?php echo base_url()."index.php/Utility/PattadarwithPNo";?>">
                        <div class="form-group">
                        <lavel class="col-lg-12" style="color: red; text-align: center"><?php echo validation_errors(); ?></lavel>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('district')?></label>
                            <div class="col-lg-8">
                                <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                    <option value="<?php echo $datas['dist_code'];?>"><?php echo $datas['dist_name'];?></option>
                                </select>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('subdivision')?></label>
                            <div class="col-lg-8">
                                <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                    <option value="<?php echo $datas['subdiv_code'];?>"><?php echo $datas['sub_div_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('circle')?></label>
                            <div class="col-lg-8">
                                <select class="form-control circleselect" id="select" required name="circle_code">
                                    <option value="<?php echo $datas['cir_code'];?>"><?php echo $datas['cir_name'];?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Pattadar's Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="pdarname"  size=30 tabindex="4" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select" class="col-lg-4 control-label">Pattadar's Fathers Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="father"  size=30 tabindex="4" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button') ?></button>
                                <button type="" class="btn btn-danger uni_text"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>


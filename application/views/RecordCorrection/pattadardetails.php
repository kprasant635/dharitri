<?php $genders = array('M'=>'Male','F'=>'Female','O'=>'Others','U'=>'Unknown');
?>
<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('pdar_details') ?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/RecordCorrectionController/editForm"; ?>" method="post">
                            <input type="hidden" name="dag_no" value="<?php echo $dag_no;?>"/>
                            <input type="hidden" name="patta_type_code" value="<?php echo $patta_type;?>"/>
                            <input type="hidden" name="pdar_id" value="<?php echo $pdar_id;?>"/>
                            <input type="hidden" name="patta_no" value="<?php echo $pattadar->patta_no;?>"/>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('pattadar_name') ?></label>
                                <div class="col-sm-6">
                                    <input value="<?php echo $pattadar->pdar_name;?>" type="text" class="form-control" required name="pdar_name"
                                           id="guard_name" placeholder="<?php echo $this->lang->line('pattadar_name') ?>">
                                </div>
                               
                                
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required" ><?php echo $this->lang->line('gender') ?></label>
                                <div class="col-sm-4">
                                    <select required class="form-control" name="pdar_gender" id='gender'>
                                        <?php if($pattadar->pdar_gender!=null):?>
                                        <option value="<?php echo $pattadar->pdar_gender;?>"><?php echo $genders[$pattadar->pdar_gender];?></option>
                                        <?php else:?>
                                        <option value="U">Unkown</option>    
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_name') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" value="<?php echo $pattadar->pdar_father;?>" class="form-control" required 
                                           name="pdar_father" id="guard_name" placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_relation') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control relation-type" name="pdar_guard_reln" required id="relation">
                                         <?php if($pattadar->pdar_gender!=null):?>
                                            <option value="<?php echo $pattadar->pdar_guard_reln;?>"><?php echo $this->utilityclass->get_relation($pattadar->pdar_guard_reln);?></option>
                                        <?php else:?>
                                            <option value="U">Unkown</option>    
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('mothers_name') ?></label>
                                <div class="col-sm-4">
                                    <input type="text"  value="<?php echo $pattadar->pdar_mother;?>" class="form-control" 
                                           name="pdar_mother" id="mother_name" placeholder="<?php echo $this->lang->line('mothers_name') ?>">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?php echo $pattadar->pdar_add1;?>" maxlength="100" 
                                           class="form-control" name="pdar_add1" id="add1" placeholder=" <?php echo $this->lang->line('address1') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" value="<?php echo $pattadar->pdar_add2;?>" 
                                           class="form-control" name="pdar_add2" id="add2" placeholder="<?php echo $this->lang->line('address2') ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pan_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" value="<?php echo $pattadar->pdar_pan_no;?>" maxlength="100" 
                                           class="form-control" name="pdar_pan_no" id="add1" placeholder=" <?php echo $this->lang->line('pan_no') ?>">
                                </div>
                                 <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('nrc_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="100" value="<?php echo $pattadar->pdar_nrcno;?>" 
                                           class="form-control" name="pdar_nrcno" id="add2" placeholder="<?php echo $this->lang->line('nrc_no') ?>">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('aadhar_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" value="<?php echo $pattadar->pdar_aadharno;?>" maxlength="100" 
                                           class="form-control" name="pdar_aadharno" id="add1" placeholder=" <?php echo $this->lang->line('aadhar_no') ?>">
                                </div>
                                 <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('mobile_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="100" value="<?php echo $pattadar->pdar_mobile;?>"
                                           class="form-control" name="pdar_mobile" id="add2" placeholder="<?php echo $this->lang->line('mobile_no') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('is_minor') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" value="<?php echo $pattadar->pdar_minor_yn;?>" maxlength="100" class="form-control"
                                           name="pdar_minor_yn" id="add1" placeholder=" <?php echo $this->lang->line('is_minor') ?>">
                                </div>
                                 <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('minor_dob') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="100" value="<?php echo $pattadar->pdar_minor_dob;?>" class="form-control"
                                           name="pdar_minor_dob" id="add2" placeholder="<?php echo $this->lang->line('pdar_minor_dob') ?>">
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-10 uni_text col-lg-offset-1'>
                                    <p class="myfont"><?php echo $this->lang->line('land_area') ?></p>
                                    <hr>
                                </div>
                            </div>



                            <div class="form-group" style="margin: 10px;">

                                <div class="col-sm-3 col-sm-offset-2">
                                    <input type="text" maxlength="6" value="<?php echo $pattadar->dag_por_b;?>" 
                                           class="form-control" id="appliedbigha" placeholder="বিঘা" name="" required>
                                </div>

                                <div class="col-sm-3">
                                    <input type="text" maxlength="2" value="<?php echo $pattadar->dag_por_k;?>" 
                                           class="form-control" id="appliedkatha" placeholder="কঠা" name="" required>
                                </div>

                                <div class="col-sm-3">
                                    <input type="text" maxlength="4" value="<?php echo $pattadar->dag_por_lc;?>" 
                                           class="form-control" id="appliedlessa" placeholder="লেছা" name="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>Submit</button>
                                    <a href='<?php echo base_url() . "index.php/lmmutation/mutationlandarea"; ?> ' 
                                       class="btn btn-danger"><i class='fa fa-check'></i>Next</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





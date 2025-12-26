<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> 
                        <?php 
                        if($this->session->userdata('ismultiple')==true){
                            $type_of_dag = "( Multiple Dag )";
                        }else{
                            $type_of_dag = "( Single Dag )";
                        }
                        
                        if($this->session->userdata('mut_type')==01){
                            echo "Field Mutation Transfer Type Form For ".$type_of_dag;
                        }else{
                            echo "Field Partition Transfer Type Form For ".$type_of_dag;
                        }
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php
                            if($this->session->userdata('mut_type')==01){
                                echo "Field Mutation (Applicant Details)";
                            }else{
                                echo "Field Partition (Applicant Details)";
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/lmmutation/saveApplicantDetails"; ?>" method="post">
                            <!--<div class='col-lg-4 uni_text'>
                                <p style='display:none'><?php echo $this->lang->line('applicant_work_order_no') ?></p>
                            </div>-->
                            <div class='col-lg-4 col-lg-offset-3 uni_text'>
                                <?php if ($husband_wife == true): ?>
                                    <p><?php echo $this->lang->line('is_husband_wife') ?><input type="checkbox" class="husband_wife" name="hus_wife"  value="w"/></p>
                                <?php else: ?>
                                    <p><?php echo $this->lang->line('is_husband_wife') ?><input type="checkbox" class="husband_wife" name="hus_wife" value="h"/></p>
                                <?php endif; ?>
                            </div>
                            <div class='col-lg-4 uni_text'>
                                <p><?php echo $this->lang->line('is_copattadar') ?> <input type="checkbox" name='co_pattadar'/></p>
                            </div>
                            <br/>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php if ($husband_wife == true): ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('wifes_name') ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pet_name" id="wifename" placeholder="Applicant's Name">
                                        <input type="hidden" name='hus_wife' value="w"/>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label required" id='applicant_name_label'><?php echo $this->lang->line('applicants_name') ?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" required="" name="pet_name" id="applicantNam" placeholder="<?php echo $this->lang->line('applicants_name') ?>">
                                    </div>
                                    <div id="cop" style="display: none;">
                                        <label for="inputEmail3" class="col-sm-3  uni_text control-label required" id='applicant_name_label'><?php echo $this->lang->line('select_co_pattadar') ?></label>
                                        <div class="col-sm-3">

                                            <select name="copname" class="form-control" >
                                                <option selected disabled ><?php echo $this->lang->line('select_co_pattadar') ?></option>
                                                <?php foreach ($pdars as $cop): ?>
                                                    <option  value="<?php echo $cop->pdar_id ?>"><?php echo $cop->pdar_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required" ><?php echo $this->lang->line('gender') ?></label>
                                <div class="col-sm-3">
                                    <select required class="form-control" name="pet_gender" id='gender'>
                                        <option disabled selected><?php echo $this->lang->line('select_gender') ?></option>
                                        <option value="M"><?php echo $this->lang->line('male') ?></option>
                                        <option value="F"><?php echo $this->lang->line('female') ?></option>
                                        <option value="O"><?php echo $this->lang->line('others') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('guardian_name') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" required name="guard_name" id="guard_name" placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('guardian_relation') ?></label>
                                <div class="col-sm-3">
                                    <select class="form-control relation-type" name="guard_rel" required id="relation">
                                        <option selected disabled><?php echo $this->lang->line('select_relation') ?></option>
                                        <?php foreach ($relation as $r): ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('mothers_name') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="pet_mother" id="mother_name" placeholder="<?php echo $this->lang->line('mothers_name') ?>">
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label required"><?php echo $this->lang->line('is_minor') ?></label>
                                <div class="col-sm-3">
                                    <select class="form-control" required="" name="pet_minor_yn" id="minor">
                                        <option disabled selected><?php echo $this->lang->line('select') ?></option>
                                        <option value="Y"><?php echo $this->lang->line('yes') ?></option>
                                        <option value="N"><?php echo $this->lang->line('no') ?></option>
                                    </select>
                                </div>
                                <div id='dobyn'>
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('date_of_birth') ?></label>
                                    <div class="col-sm-3">
                                        <div class="input-group add-on col-sm-12 date datepicker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control dating" id="minor_dob" placeholder="<?php echo $this->lang->line('date_of_birth') ?>" name="pet_minor_dob"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="100" class="form-control" name="add1" id="add1" placeholder=" <?php echo $this->lang->line('address1') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" maxlength="100" class="form-control" name="add2" id="add2" placeholder="<?php echo $this->lang->line('address2') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('phone_number') ?></label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" maxlength='10' name="pdar_mobile"/>
                                </div>
                                <div id='dobyn'>
                                    <label for="inputEmail3" class="col-sm-3  uni_text control-label"><?php echo $this->lang->line('adhar_number') ?></label>
                                    <div class="col-sm-3">
                                        <div class="input-group add-on col-sm-12 date datepicker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control " id="" placeholder="" name="pdar_aadharno" onblur="if (!validate(this.value))
                                                        alert('Invalid AADHAR');
                                                    this.focus;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                <h6 class="red uni_text">NOTE : Leave the individual land area blank if the land share of the applicant(s) are not known.</h6>
                            </div>
                            <div class="form-group" style="margin: 10px;">
                                <label for="inputEmail3" class="col-sm-3  uni_text control-label red">Land Area : </label>
                                <label for="inputEmail3" class="col-sm-1  uni_text control-label"><?php echo $this->lang->line('bigha') ?></label>
                                <div class="col-sm-2">
                                    <input type="number" maxlength="6" class="form-control" value="0" id="appliedbigha" placeholder="বিঘা" name="applied_b" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-1  uni_text control-label"><?php echo $this->lang->line('katha') ?></label>
                                <div class="col-sm-2">
                                    <input type="number" maxlength="2" class="form-control" value="0" id="appliedkatha" placeholder="কঠা" name="applied_k" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-1  uni_text control-label"><?php echo $this->lang->line('lessa') ?></label>
                                <div class="col-sm-2">
                                    <input type="number" maxlength="4" class="form-control" value="0" id="appliedlessa" placeholder="লেছা" name="applied_lc" required>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <center>
                                    <div class="col-lg-12">
                                        <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Save Applicant</button>
                                        <!--<a  <?php if($disabled){ echo 'disabled';}?> href='<?php echo base_url() . "index.php/lmmutation/mutationlandarea"; ?> '  class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;Proceed To Next Stage</a>-->
                                        <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                    </div>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






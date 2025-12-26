<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Select Location</li>
                <li class="progtrckr-done secondtick">Transfer Type</li>
                <li class="progtrckr-done thirdtick">Applicant Details</li>
                <li class="fourthtick">Mutation Land Area</li>
            </ol>
        </div>
    </div>
<?php //var_dump($this->session->all_userdata()); ?>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('applicant_details_for_field_mutation') ?>
                            <?php if($this->session->userdata('ismultiple')==true){
                                echo "**Multiple Dag**";
                            } ?>
                            </p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/mutationbacklog/saveApplicantDetails"; ?>" method="post">
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
                            <br />
                            <hr>
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
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label required" id='applicant_name_label'><?php echo $this->lang->line('applicants_name') ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" required="" name="pet_name" id="applicantNam" placeholder="<?php echo $this->lang->line('applicants_name') ?>">
                                    </div>
                                    <div id="cop" style="display: none;">
                                        <label for="inputEmail3" class="col-sm-2  uni_text control-label required" id='applicant_name_label'><?php echo $this->lang->line('select_co_pattadar') ?></label>
                                        <div class="col-sm-4">

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
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required" ><?php echo $this->lang->line('gender') ?></label>
                                <div class="col-sm-4">
                                    <select required class="form-control" name="pet_gender" id='gender'>
                                        <option disabled selected><?php echo $this->lang->line('select_gender') ?></option>
                                        <option value="M"><?php echo $this->lang->line('male') ?></option>
                                        <option value="F"><?php echo $this->lang->line('female') ?></option>
                                        <option value="O"><?php echo $this->lang->line('others') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_name') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required name="guard_name" id="guard_name" placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('guardian_relation') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control relation-type" name="guard_rel" required id="relation">
                                        <option selected disabled><?php echo $this->lang->line('select_relation') ?></option>
                                        <?php foreach ($relation as $r): ?>
                                            <option value="<?php echo $r->guard_rel; ?>"><?php echo $r->guard_rel_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('mothers_name') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="pet_mother" id="mother_name" placeholder="<?php echo $this->lang->line('mothers_name') ?>">
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('is_minor') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control" required="" name="pet_minor_yn" id="minor">
                                        <option disabled selected><?php echo $this->lang->line('select') ?></option>
                                        <option value="Y"><?php echo $this->lang->line('yes') ?></option>
                                        <option value="N"><?php echo $this->lang->line('no') ?></option>
                                    </select>
                                </div>
                                <div id='dobyn'>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('date_of_birth') ?></label>
                                    <div class="col-sm-4">
                                        <div class="input-group add-on col-sm-12 date datepicker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control dating" id="minor_dob" placeholder="<?php echo $this->lang->line('date_of_birth') ?>" name="pet_minor_dob"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address1') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="add1" id="add1" placeholder=" <?php echo $this->lang->line('address1') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address2') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" maxlength="100" class="form-control" name="add2" id="add2" placeholder="<?php echo $this->lang->line('address2') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('phone_number') ?></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" maxlength='10' name="pdar_mobile"/>
                                </div>
                                <div id='dobyn'>
                                    <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('adhar_number') ?></label>
                                    <div class="col-sm-4">
                                        <div class="input-group add-on col-sm-12 date datepicker" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control " id="" placeholder="" name="pdar_aadharno" onblur="if (!validate(this.value))
                                                        alert('Invalid AADHAR');
                                                    this.focus;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div class='col-lg-10 uni_text col-lg-offset-1'>
                                    <p class="myfont"><?php echo $this->lang->line('land_quantity') ?></p>
                                    <hr>
                                </div>
                            </div>
                            <div class="form-group" style="margin: 10px;">

                                <div class="col-sm-3 col-sm-offset-2">
                                    <input type="number" maxlength="6" class="form-control" value="0" id="appliedbigha" placeholder="বিঘা" name="applied_b" required>
                                </div>

                                <div class="col-sm-3">
                                    <input type="number" maxlength="2" class="form-control" value="0" id="appliedkatha" placeholder="কঠা" name="applied_k" required>
                                </div>

                                <div class="col-sm-3">
                                    <input type="number" maxlength="4" class="form-control" value="0" id="appliedlessa" placeholder="লেছা" name="applied_lc" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit"  class="btn btn-primary"><i class='fa fa-check'></i>Submit</button>
                                    <a  <?php if($disabled){ echo 'disabled';}?> href='<?php echo base_url() . "index.php/lmmutation/mutationlandarea"; ?> '  class="btn btn-danger"><i class='fa fa-check'></i>Next</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





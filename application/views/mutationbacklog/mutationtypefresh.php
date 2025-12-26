<div class="row form-top login">
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done firsttick">Select Location</li>
                <li class="progtrckr-done secondtick">Transfer Type</li>
                <li class="thirdtick">Applicant Details</li>
                <li class="fourthtick">Mutation Land Area</li>
            </ol>
        </div>
    </div>
    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('transfer_type_form')?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <hr>
                        <form class='form-horizontal' method="post"
                              action="<?php echo base_url() . 'index.php/lmmutation/freshReportStep1' ?>">
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('mutation_type')?></label>
                                <div class="col-sm-4">

                                    <select class="form-control mutation-type" name="mutation_type" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_mutaion_type')?></option>
                                        <?php foreach ($type as $t): ?>
                                            <?php if($t->order_type_code == $emuttype):?>
                                            <option selected value="<?php echo $t->order_type_code; ?>"><?php echo $t->order_type; ?></option>
                                            <?php else:?>
                                            <option value="<?php echo $t->order_type_code; ?>"><?php echo $t->order_type; ?></option>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('transfer_type')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control transfer-type" name="transfer_type" required="">
                                        <option value="<?php echo $eTransferType;?>">
                                            <?php echo $this->utilityclass->getTransferType($eTransferType);?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('patta_no')?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="20" class="form-control" id="applicantNam" placeholder="<?php echo $this->lang->line('patta_no')?>" 
                                           data-toggle="popover" required
                                           
                                           data-inputmask="'mask': '9[99]'" value="<?php echo $ePattaNo;?>"
                                           data-placement="top" data-content="This Patta No. Does Not Exists."
                                           name="patta_no" >
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('patta_type')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control patta-type" name="patta_type" required="">
                                         <option value="<?php echo $ePattaType;?>">
                                            <?php echo $this->utilityclass->getPattaType($ePattaType);?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('address_to')?></label>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control" id="applicantNam" required=""
                                           placeholder="<?php echo $this->lang->line('address_to')?>" name="add_of_name">
                                        <option disabled=""><?php echo $this->lang->line('select')?></option>
                                        <?php foreach($user as $u):?>
                                        <?php if($u->user_code == $eAddressedTo):?>
                                        <option selected value="<?php echo $u->user_code;?>"><?php echo $u->username;?></option>
                                        <?php else:?>
                                        <option  value="<?php echo $u->user_code;?>"><?php echo $u->username;?></option>
                                        <?php endif;?>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('designation')?></label>
                                <div class="col-sm-4">
                                    <select class="form-control add_of_desig" name="add_of_desig" required="">
                                       
                                        <option selected value="<?php echo $eDesignation;?>"><?php echo $eDesignation;?></option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('registration_deed_no')?></label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="30" class="form-control" id="applicantNam" value="<?php echo $eRegistration;?>"
                                           placeholder="Deed No" name="reg_deed_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('deed_value')?></label>
                                <div class="col-sm-4">
                                    <input type="number" maxlength="19" class="form-control" id="applicantNam"
                                           data-inputmask="'mask': '9[99]'" value="<?php echo $eDeedValue;?>" name="reg_deed_value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('deed_date')?></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="applicantNam" value="<?php echo $eDeedDate;?>"
                                            name="reg_deed_date">
                                </div>
                                 <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('report_date')?></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="applicantNam" value="<?php echo $eReportDate;?>" name="report_date">
                                </div>
                            </div>
                           
                            <hr>
                            <div class="form-group">
                                <div class="col-lg-6 alert alert-success" style="color:#0000;margin: 0 auto;float: none;text-align: center">
                                    <label class="checkbox-inline uni_text bold">
                                        
                                        <input type="checkbox" id="inlineCheckbox1"
                                               <?php if($eRajah=='y') echo "checked";?>
                                               name='rajah_adalat' value="y"> <?php echo $this->lang->line('rajah_adalat')?>
                                    </label>
                                    <label class="checkbox-inline uni_text bold">
                                        <input type="checkbox" id="inlineCheckbox2" 
                                                <?php if($ePossesion=='y') echo "checked";?>
                                               name="possession_yn" value="y"> <?php echo $this->lang->line('possession')?>
                                    </label>
                                    <label class="checkbox-inline uni_text bold">
                                        <input type="checkbox" id="inlineCheckbox3" 
                                               <?php if($eDispute=='y') echo "checked";?>
                                               name='dispute_yn' value="y"><?php echo $this->lang->line('dispute')?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button')?></button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





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

    <div class="col-lg-12 ">
        <div class="col-lg-12" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'><?php echo $this->lang->line('applicant_details_for_field_mutation')?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal' 
                              action="<?php echo base_url() . "index.php/lmmutation/saveFreshApplicants"; ?>" method="post">
                            <a class="btn btn-danger" id='addnewapplicant'><?php echo $this->lang->line('add_new')?></a>

                            <div>
                                <table class="table table-bordered" id='freshapplicants'>
                                    <thead>
                                        <tr>
                                            <th class='alert-new'><?php echo $this->lang->line('applicants_name')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('guardian_name')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('relation')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('address1')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('address2')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('bigha')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('katha')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('lessa')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('ganda')?></th>
                                            <th class='alert-new'><?php echo $this->lang->line('krantik')?></th>
                                        </tr>
                                    </thead>

                                    <?php foreach ($applicants as $applicant): ?>
                                        <tr id="template">
                                            <input type="hidden" name="applicant[1][pet_id]" value="<?php echo $applicant->pet_id;?>"></input>
                                            <td><input class='n' type="text" name="applicant[1][name]"
                                                       value="<?php echo $applicant->pet_name; ?>"/></td>
                                            <td><input class='g' type="text" name="applicant[1][g]" 
                                                       value="<?php echo $applicant->guard_name; ?>"/></td>
                                            <td><input class='r' type="text" name="applicant[1][r]" 
                                                       value="<?php echo $applicant->guard_rel; ?>"/></td>
                                            <td><input class='a1' type="text" name="applicant[1][a1]" 
                                                       value="<?php echo $applicant->add1; ?>"/></td>
                                            <td><input class='a2' type="text" name="applicant[1][a2]" 
                                                       value="<?php echo $applicant->add2; ?>"/></td>
                                            <td><input class='b' style="width: 50%;" type="text" name="applicant[1][b]" 
                                                        value="<?php echo $applicant->applied_b; ?>"/></td>
                                            <td><input class='k' style="width: 50%;" type="text" name="applicant[1][k]" 
                                                        value="<?php echo $applicant->applied_k; ?>"/></td>
                                            <td><input class='lc' style="width: 50%;" type="text" name="applicant[1][lc]" 
                                                        value="<?php echo $applicant->applied_lc; ?>"/></td>
                                            <td><input class='gn' style="width: 50%;" type="text" name="applicant[1][gn]" 
                                                       value="<?php echo 0; ?>"/></td>
                                            <td><input class='kr' style="width: 50%;" type="text" name="applicant[1][kr]" 
                                                       value="<?php echo 0; ?>"/></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <input type="<?php echo $this->$lang->line('submit_button')?>"/>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





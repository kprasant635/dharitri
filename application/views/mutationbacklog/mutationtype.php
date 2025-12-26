<script>
    $(function () {
 
        $('#mutationtype').submit(function (e) {
            var response = confirm("Are you sure you want to register a field mutation case?");
            if (response) {
                var dispute = $('#inlineCheckbox3').is(':checked');
                var possession = $('#inlineCheckbox2').is(':checked');
                if (dispute) {
                    $('#myModal .alert').html("A Disputed Plot cannot be Mutated");
                    $('#myModal').modal();
                    e.preventDefault();
                }
                if (!possession) {
                    $('#myModal .alert').html("A Plot in which the pattadar has no possession cannot be Mutated");
                    $('#myModal').modal();
                    e.preventDefault();
                }
                
            } else {
                e.preventDefault();
            }
        });
    });

</script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #ccc">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">You are in the process of Field mutation</h4>
            </div>
            <hr>
            <div class="modal-body">
                <div class="alert alert-info"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="row login">
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
                            <p class='center bold'><?php echo $this->lang->line('transfer_type_form') ?></p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <hr>
                        <form class='form-horizontal' method="post" action="<?php echo base_url()."index.php/mutationbacklog/saveFieldMutatonBasic";?>" id="mutationtype">

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text uni_text control-label required"><?php echo $this->lang->line('mutation_type') ?></label>
                                <div class="col-sm-4">

                                    <select class="form-control mutation-type" name="mutation_type" required="">
                                        <option selected disabled><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($type as $t): ?>
                                            <option value="<?php echo $t->order_type_code; ?>"><?php echo $t->order_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label requried hideonselect"><?php echo $this->lang->line('transfer_type') ?></label>
                                <div  class="col-sm-4 hideonselect">
                                    <select class="form-control transfer-type" name="transfer_type" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_transfer_type') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('patta_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="<?php echo $this->lang->line('patta_no') ?>" 
                                           data-toggle="popover" required
                                           id="patta_no"
                                           data-inputmask="'mask': '9[999]'"
                                           data-placement="top" data-content="This Patta No. Does Not Exists."
                                           name="patta_no" >
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('patta_type') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control patta-type" readonly name="patta_type" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_patta_type') ?></option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('acceptance_officer') ?></label>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control" id="applicantNam" required="" placeholder="Addressed To" name="add_of_name">
                                        <option selected disabled=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u->user_code; ?>"><?php echo $u->username; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required"><?php echo $this->lang->line('designation') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control add_of_desig" name="add_of_desig" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_designation') ?></option>
                                        <option value="CO"><?php echo $this->lang->line('circle_officer') ?></option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('registration_deed_no') ?></label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="30" class="form-control"  
                                           id="applicantNam" placeholder="<?php echo $this->lang->line('deed_no') ?>" name="reg_deed_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('deed_value') ?></label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="19" class="form-control" id="applicantNam"
                                           data-inputmask="'mask': '9[999999999]'"
                                           placeholder="<?php echo $this->lang->line('deed_value') ?>" name="reg_deed_value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('deed_date') ?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control dating" placeholder="<?php echo $this->lang->line('deed_date') ?>" name="reg_deed_date">
                                </div>

                            </div>

                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 required  uni_text control-label"><?php echo $this->lang->line('lm_report_date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" required="" class="form-control dating"  id="lmdatefield00" 
                                           placeholder="<?php echo $this->lang->line('lm_report_date') ?>" name="report_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 alert alert-success" style="margin: 0 auto;float: none;text-align: center">
                                    <label class="checkbox-inline uni_text bold">
                                        <input type="checkbox" id="inlineCheckbox1" name='rajah_adalat' value="y"> <?php echo $this->lang->line('is_there_any_applicant_in_rajah_adalat') ?>
                                    </label>
                                    <label class="checkbox-inline uni_text bold">
                                        <input type="checkbox"  id="inlineCheckbox2" name="possession_yn" value="y"><?php echo $this->lang->line('is_there_any_possession') ?>
                                    </label>
                                    <label class="checkbox-inline uni_text bold">
                                        <input type="checkbox" id="inlineCheckbox3" name='dispute_yn' value="y"><?php echo $this->lang->line('is_there_any_dispute') ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" class="fieldmutpart btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.fieldmutpart').prop('disabled', true);
        $("#lmdatefield00").click(function() {
        $('.fieldmutpart').prop('disabled', false);
    });
</script>





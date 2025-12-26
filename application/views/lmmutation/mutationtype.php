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

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm bg-info">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('transfer_type_form') ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                             Field Mutation/Partition (Transfer Type)
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' method="post" action="<?php echo base_url()."index.php/lmmutation/saveFieldMutatonBasic";?>" id="mutationtype">
                            <input type="hidden" class="form-control districtselect" id="select" name="dist_code" value="<?php echo $dist_code; ?>">
                            <input type="hidden" class="form-control subdivselect" id="select" name="subdiv_code" value="<?php echo $subdiv_code; ?>">
                            <input type="hidden" class="form-control circleselect" id="select" name="circle_code" value="<?php echo $cir_code; ?>">
                            <input type="hidden" class="form-control mouzaselect" id="select" name="mouza_code" value="<?php echo $mouza_code; ?>">
                            <input type="hidden" class="form-control lotselect" id="select" name="lot_no" value="<?php echo $lot_no; ?>">
                            <input type="hidden" class="form-control villageselect" id="select" name="vill_code" value="<?php echo $vill_code; ?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text uni_text control-label required"><?php echo $this->lang->line('mutation_type') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control mutation-type" name="mutation_type" required="">
                                        <option selected disabled><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($type as $t): ?>
                                            <option value="<?php echo $t->order_type_code; ?>"><?php echo $t->order_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label requried hideonselect"><?php echo $this->lang->line('transfer_type') ?></label>
                                <div  class="col-sm-4 hideonselect">
                                    <select class="form-control transfer-type" name="transfer_type" required="">
                                        <option selected disabled><?php echo $this->lang->line('select_transfer_type') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 uni_text uni_text control-label required"><?php echo  $this->lang->line('patta_type');?></label>
                                <div class="col-sm-4">
                                    <select class="form-control pattatype_nmae" id="all_patta_type"  required name="patta_type" style="display: none;">
                                       <option selected disabled><?php  echo $this->lang->line('select_patta_type'); ?></option>
                                           <?php foreach ($patta_type as $p): ?>
                                               <option value="<?php echo $p->type_code; ?>"><?php echo $p->patta_type; ?></option>
                                           <?php endforeach; ?>
                                   </select>
                                    
                                    <select class="form-control pattatype_nmae" id="patta_type_excludin_aksona" required name="patta_type">
                                       <option selected disabled><?php  echo $this->lang->line('select_patta_type'); ?></option>
                                           <?php foreach ($patta_type_excluding_aksona as $p): ?>
                                               <option value="<?php echo $p->type_code; ?>"><?php echo $p->patta_type; ?></option>
                                           <?php endforeach; ?>
                                   </select>
                                </div>

                                <label for="inputEmail" class="col-sm-2 uni_text uni_text control-label required"><?php echo  $this->lang->line('patta_no');?></label>
                                <div class="col-sm-4">
                                   <select class="form-control pattanoselect" id="select" required name="patta_no">
                                       <option>Select Patta</option>
                                   </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label required">Assign Officer</label>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control" id="applicantNam" required=""
                                            placeholder="Addressed To" name="add_of_name">
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
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label" id="change_text1">Deed No</label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="30" class="form-control" id="placehold1" placeholder="<?php echo $this->lang->line('registration_deed_no') ?>" name="reg_deed_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label hiden"><?php echo $this->lang->line('deed_value') ?></label>
                                <div class="col-sm-4">
                                    <input type="text"  maxlength="19" class="form-control hiden" id="applicantNam"
                                           data-inputmask="'mask': '9[999999999]'"
                                           placeholder="<?php echo $this->lang->line('deed_value') ?>" name="reg_deed_value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2  uni_text control-label" id="change_text2"><?php echo $this->lang->line('deed_date') ?></label>
                                <div class="col-sm-4">
                                    <div class="input-group add-on col-md-12 date datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" id="placehold2" class="form-control dating" placeholder="<?php echo $this->lang->line('deed_date') ?>" name="reg_deed_date">
                                        <div class="input-group-btn">
                                            <a class="btn btn-default"><i class="fa fa-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 required  uni_text control-label"><?php echo $this->lang->line('lm_report_date') ?></label>

                                <div class="col-sm-4">
                                    <div class="input-group add-on col-md-12 date datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" required="" class="form-control dating"  id="lmdatefield00" placeholder="<?php echo $this->lang->line('lm_report_date') ?>" name="report_date">
                                        <div class="input-group-btn">
                                            <a class="btn btn-default"><i class="fa fa-calendar"></i></a>
                                        </div>
                                    </div>
                                    
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
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
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
<script type="text/javascript">
    $('.transfer-type').change(function (e) {
        var transfer_type_code = $(this).val();
        if (transfer_type_code == '08')
        {
            $('.hiden').hide();
            document.getElementById('change_text1').innerHTML = 'উইল বা প্ৰবেট নং';
            document.getElementById('change_text2').innerHTML = 'উইল বা প্ৰবেট তাৰিখ';
            $('#placehold1').attr("placeholder", "উইল বা প্ৰবেট নং");
            $('#placehold2').attr("placeholder", "উইল বা প্ৰবেট তাৰিখ");
            //document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Dag Number Already Exists</p></label>";
        }
        else if ((transfer_type_code == '11')||(transfer_type_code == '02')||(transfer_type_code == '01'))
        {
            document.getElementById('all_patta_type').style.display = 'block';
            document.getElementById('patta_type_excludin_aksona').style.display = 'none';
        }
        else 
        {
            $('.hiden').show();
            document.getElementById('change_text1').innerHTML = "Deed No";
            document.getElementById('change_text2').innerHTML = "<?php echo $this->lang->line('deed_date'); ?>";
            $('#placehold1').attr("placeholder", "<?php echo $this->lang->line('registration_deed_no'); ?>");
            $('#placehold2').attr("placeholder", "<?php echo $this->lang->line('deed_date'); ?>");
            document.getElementById('all_patta_type').style.display = 'none';
            document.getElementById('patta_type_excludin_aksona').style.display = 'block';
        }
    });
</script>





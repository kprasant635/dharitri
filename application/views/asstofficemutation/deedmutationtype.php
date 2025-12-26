<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Suo-Moto Office Mutation Transfer Type Form</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                             Office Mutation (Transfer Type)
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/officemutation/mutationtype' ?>">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label required"><?php echo  $this->lang->line('patta_type');?></label>
                                <div class="col-lg-4">
                                    <input type="text" class='form-control' value='<?php echo $this->utilityclass->getPattaName($deeddata->patta_type_code) ?>' />  
                                    <input type="hidden" class='form-control' name='patta_type' value='<?php echo $deeddata->patta_type_code ?>' /> 
                                </div>

                                <label for="inputEmail" class="col-lg-2 control-label required"><?php echo  $this->lang->line('patta_no');?></label>
                                <div class="col-lg-4">
                                   <input type="text" maxlength="20" class="form-control" readonly value="<?php echo $deeddata->patta_no ?>" name="patta_no" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php  echo $this->lang->line('transfer_type'); ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control transfer-type_office" name="transfer_type" required>
                                        <option selected disabled><?php echo $this->lang->line('select_transfer_type'); ?></option>
                                        <?php foreach ($transfertype as $t): ?>
                                            <option value='<?php echo $t->trans_code; ?>'><?php echo $t->trans_desc_as; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required">Assign Officer</label>
                                <div class="col-sm-4">
                                    <select name="add_of_name" class="form-control" id="corequired" required>
                                        <option selected disabled><?php  echo $this->lang->line('select_recieving_officer'); ?></option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u->user_code; ?>"><?php echo $u->username; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php  echo $this->lang->line('designation'); ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control add_of_desig" name="add_of_desig" required>
                                        <option selected disabled><?php echo $this->lang->line('select_designation'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label" id="change_text1">Deed No</label>
                                <div class="col-sm-4">
                                    <input type="text" maxlength="25" class="form-control" readonly id="applicantNam" value="<?php echo $deeddata->deed_no; ?>" name="reg_deed_no">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label hiden"><?php  echo $this->lang->line('deed_value'); ?></label>
                                <div class="col-sm-4">
                                    <input type="number" maxlength="10"  class="form-control hiden" id="applicantNam" placeholder="<?php echo $this->lang->line('deed_value'); ?>" name="reg_deed_value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label" id="change_text2"><?php  echo $this->lang->line('deed_date'); ?></label>
                                <div class="col-sm-4">
                                    <div class="input-group add-on col-md-12 date datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" readonly id="applicantNam" value="<?php echo date('d/m/Y', strtotime($deeddata->date_of_deed)); ?>" name="reg_deed_date"/>
                                        <div class="input-group-btn">
                                            <a class="btn btn-default"><i class="fa fa-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' value='<?php echo $this->input->get('deed') ?>' name='suomoto' >
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="btn btn-success officemutation"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
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
    $('.officemutation').prop('disabled', true);
        $("#corequired").click(function() {
        $('.officemutation').prop('disabled', false);
    });
</script>
<script type="text/javascript">
    $('.transfer-type_office').change(function (e) {
        var transfer_type_code = $(this).val();
        if (transfer_type_code == '08')
        {
            $('.hiden').hide();
            document.getElementById('change_text1').innerHTML = 'উইল বা প্ৰবেট নং';
            document.getElementById('change_text2').innerHTML = 'উইল বা প্ৰবেট তাৰিখ';
            //document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Dag Number Already Exists</p></label>";
        }
        else
        {
            $('.hiden').show();
            document.getElementById('change_text1').innerHTML = "<?php echo "Deed No"; ?>";
            document.getElementById('change_text2').innerHTML = "<?php echo $this->lang->line('deed_date'); ?>";
        }
    });
</script>


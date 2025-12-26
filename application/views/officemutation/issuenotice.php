<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Parties who will get notice for Office Mutation</h2>
                </div>
                <?php
                            if($this->session->flashdata('message')){
                        ?>
                                <div class="error_container">
                                                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <strong class="text-danger">
                                                                    <?= $this->session->flashdata('message'); ?>
                                                                </strong>
                                                            </div>
                                </div>
                        <?php
                            }
                        ?>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading hide">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('first_party');?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('second_party');?></label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url(); ?>index.php/coofficemutation/issuenotice" method="post">
                            <input type="hidden" name="case_no" value="<?php echo $case_no;?>"/>
                            <input type="hidden" name="petition_no" value="<?php echo $petition_no;?>"/>
                            <div class="panel-body">
                                <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('more_information_about_parties_who_will_get_notice');?></u></span></p>
                                <hr>
                                <div id="itemRows" >
                                    <label class="rasid"><?php echo $this->lang->line('name');?> : </label><label><input type="text" class="form-control" name="notification[1][name]"/></label>
                                    <label class="rasid"><?php echo $this->lang->line('address1_C');?> : </label><label><input type="text" class="form-control" name="notification[1][address1]"/></label> 
                                    <label class="rasid"><?php echo $this->lang->line('address2_C');?> : </label><label><input type="text" name="notification[1][address2]" class="form-control" /></label> 
                                    <label class="rasid"><input onclick="addRow(this.form);" type="button" class="btn btn-info" value="Add More" /></label>
                                <hr>
                                </div>
                            </div>

                            <div class="panel-footer center">
                                <button type="submit" class="btn btn-success rasid" name="" onclick="$('#notificationform').submit()"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <button type="submit" class="btn btn-danger rasid" name="" onclick="$('#notificationform').submit()"><i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var rowNum = 0;
    function addRow(frm) {
        rowNum++;
        var row = '<div class="dynamic-row" id="rowNum' + rowNum + '"><label class="rasid"><?php echo $this->lang->line('name');?> : </label><label><input type="text" class="form-control" name="add_name[]"  value=""></label> <label class="rasid"><?php echo $this->lang->line('address1_C');?> : </label> <label><input type="text" class="form-control" name="add_1[]" value=""></label> <label class="rasid"><?php echo $this->lang->line('address2_C');?> : </label><label><input type="text" class="form-control" name="add_2[]" value=""></label><label><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow(' + rowNum + ');"></div>';
        jQuery('#itemRows').append(row);
        frm.add_name.value = '';
        frm.add_1.value = '';
        frm.add_2.value = '';
       // alert(rowNum);
    }
   function removeRow(rnum) {
        jQuery('#rowNum' + rnum).remove();
    }
</script>





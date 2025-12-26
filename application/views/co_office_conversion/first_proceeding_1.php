<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('parties_who_will_get_notice');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('first_party');?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('second_party');?></label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-inline" action="<?php echo base_url(); ?>index.php/COconversionPartha/ThirdProcess"  method="post">
                            <div class="panel-body">
                                <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('more_information_about_parties_who_will_get_notice');?></u></span></p>
                                <hr>
                                <div id="itemRows" class='center'>
                                    <label class="rasid"><?php echo $this->lang->line('name');?> : </label><label><input type="text" class="form-control" name="add_name[]" /></label>
                                    <label class="rasid"><?php echo $this->lang->line('address1_C');?> : </label><label><input type="text" class="form-control" name="add_1[]" /></label> 
                                    <label class="rasid"><?php echo $this->lang->line('address2_C');?> : </label><label><input type="text" name="add_2[]" class="form-control" /></label> 
                                    <label class="rasid"><input onclick="addRow(this.form);" type="button" class="btn btn-info" value="Add More" /></label>
                                <hr>
                                </div>
                            </div>

                            <div class="panel-footer center">
                                <button type="submit" class="btn btn-info rasid" name="" ><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
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

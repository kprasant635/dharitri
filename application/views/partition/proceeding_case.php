<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <form class="form-inline" action="<?php echo base_url(); ?>index.php/partition/savePartNotifi"  method="post">
                    <div class="panel-body">
                        <div class="well">
                            <h2 class="uni_text text-deco center ">জাননী পাবলগীয়া ব্যক্তিসকল </h2>
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
                            <?php foreach ($name as $n): ?>
                                <p class="uni_text">আবেদনকাৰীৰ নাম : <span class="green"><?php echo $n->pdar_name ?> </span> অভিভাৱক নাম : <span class="green"><?php echo $n->pdar_guardian ?></span> </p>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="uni-text text-deco center ">জাননী পাবলগীয়া অতিৰিক্ত ব্যক্তিৰ বিৱৰণ </h2>

                        <div id="itemRows">
                            <?php echo $this->lang->line('name'); ?> : <input type="text" class="form-control" name="add_name" /> <?php echo $this->lang->line('address1') ?>: <input type="text" class="form-control" name="add_1" /><?php echo $this->lang->line('address2') ?>: <input type="text" name="add_2" class="form-control" /> <input onclick="addRow(this.form);" type="button" class="btn btn-danger btn-xs" value="<?php echo $this->lang->line('add_new') ?>" />
                        </div>
                        

                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-info col-lg-offset-4" name="" ><i class="fa fa-plus"></i>&nbsp;<?php echo $this->lang->line('save_all');?> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>   
</div>
<script>
    var rowNum = 0;
    function addRow(frm) {
        rowNum++;
        var row = '<div class="dynamic-row" id="rowNum' + rowNum + '">Name : <input type="text" class="form-control" name="add_name[]"  value="' + frm.add_name.value + '"> Add 1: <input type="text" class="form-control" name="add_1[]" value="' + frm.add_1.value + '"> Add 2: <input type="text" class="form-control" name="add_2[]" value="' + frm.add_2.value + '"> <input type="button" class="btn btn-primary btn-xs" value="Remove" onclick="removeRow(' + rowNum + ');"></div>';
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

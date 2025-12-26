<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }

</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Adding New Pattadar Name In Chitha / Jamabandi </h2>
                </div>
            </div>       
             <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
              <?php endif; ?>        
            <?php
            if ($elist) {
                echo'<div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                <p class="uni_text red">Some Of Already Requested Name(s) pending  for COs approval </p>';
                foreach ($elist as $r):
                    ?>
                    <p class='uni_text'>New Name : <kbd><?= $r->pdar_name; ?> Gurdian Name: <?php echo  $r->pdar_father; ?></kbd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Old Name : <kbd><?= $r->pdar_old_name . " Gurdian Name :" . $r->pdar_old_father; ?></kbd> </p>
                    <?php
                endforeach;
                echo'</div></div>';
            }
            ?>
            <form class='form-horizontal' name="form" method="POST" action="<?php echo base_url() . "index.php/JamaeditEntry/pdaradd"; ?>" enctype="multipart/form-data">
                <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Add Pattadar Details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
<!--                                <div class="form-group "> 
                                    <label for="inputEmail3" class="col-sm-4 red control-label">PDAR ID</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="<?php //echo $pdar_id; ?>" readonly="" class="form-control" name="pdar_id">
                                    </div>
                                </div>-->
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4 red control-label">Pattadar Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="" class="form-control" name="pdar_name" required>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4  control-label " id='applicant_name_label'>Pattadar Gurdian</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="" class="form-control" name="pdar_father" required>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4  control-label red" id='applicant_name_label'>Address 1</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="" class="form-control" name="pdar_add1">
                                    </div>
                                </div> 
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4  control-label" id='applicant_name_label'>Address 2</label>
                                    <div class="col-sm-8">
                                        <input type="text" value="" class="form-control" name="pdar_add2">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4  control-label required" id='applicant_name_label'>Bigha</label>
                                    <div class="col-sm-1">
                                        <input type="text" style="width:50px;" value="0" class="form-control"  name="pdar_land_b" placeholder="">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2  control-label required" id='applicant_name_label'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Katha</label>
                                    <div class="col-sm-1">
                                        <input type="text" value="0" style="width:50px;" class="form-control"  name="pdar_land_k" placeholder="">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2  control-label required " id='applicant_name_label'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lessa</label>
                                    <div class="col-sm-1">
                                        <input type="text" value="0" style="width:50px;"  class="form-control"  name="pdar_land_lc" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4  control-label required" id='applicant_name_label'>Land Revenue</label>
                                    <div class="col-sm-2">
                                        <input type="text" style="width:100px;" value="0" class="form-control" name="pdar_land_revenue" required>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-3  control-label required" id='applicant_name_label'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Local Tax</label>
                                    <div class="col-sm-2">
                                        <input type="text" value="0" style="width:90px;" class="form-control" name="pdar_land_localtax" required>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <label for="inputEmail3" class="col-sm-4 control-label required">Pattadar Type</label>
                                    <div class="col-sm-3">
                                        <select name='new_pdar_name' class='form-control'>
                                            <option value='N'>New(Red)</option>
                                            <option value='O' selected>Old</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <select name='p_flag' class='form-control'>
                                            <option value='0' selected disabled>Strike / Unstrike</option>
                                            <option value='0'>Non-Strike</option>
                                            <option value='1'>Strike</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">Please Upload Hand Chitha/Jama Scan Copy</div>
                                    <div class="col-sm-12">
                                        <div class="btn btn-primary btn-sm float-left btn-block">
                                            <input type="file" name="file_upload" id="fileupload" required="">
                                            <span>Only jpg,jpeg,png,doc,docx,pdf,txt type files are allowed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Pattadar Dag Details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <label><font color=blue size=4>Please Select the Dag's associated with the new pattadar :</font></label><br>
                            <div class="col-sm-12">
                                <div class="form-group"> 
                                    <?php
                                    foreach ($dag as $d) {
                                    ?>
                                    <label class="col-sm-3 well" style="color:red;"><input type="checkbox" name="dag_no[]" value="<?= $d->dag_no ?>"><span style="font-size: 18px;text-align: center;">&nbsp;<?= $d->dag_no ?></span></label>
                                    <?php } ?>
                                </div>
                                <p><mark class='uni_text'>Please select the remark from here on which basis you want to enter name on jamabandi</mark></p>
                                <hr>
                                <div class="col-sm-12" style='height:200px; overflow-y:scroll; width:100%'>
                                    <?php foreach ($rmk as $row): ?>
                                    <label class="block-label" for="radio-1">
                                        <input type="radio" id="myRadio" name="lm_note" value="<?php echo $row->remark;?>" />&nbsp;&nbsp;<?php echo $row->remark;?>
                                    </label>
                                    <hr style="border-bottom: 1px solid #000;">
                                    <?php endforeach; ?>
                                </div>
                                <hr>
                                <div class="col-sm-12 center">
                                    <button type="submit" class="btn btn-success submit" disabled><i class='fa fa-check'></i>&nbsp; Submit</button>
                                    <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/jamaeditentry/pattadarlist/"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>   
   $('input:radio').change(function () {
       if ($('input:radio:checked').length > 0){
            $('.submit:button').prop('disabled', $('input:radio:checked').length == 0)
        } 
    })
</script>
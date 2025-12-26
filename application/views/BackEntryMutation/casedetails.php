<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Pending Backlog Mutation Case Details</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                            <table class='table table-bordered unicode'>
                                <tr>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                    <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger">
                                        <?php $mut_type = $this->utilityclass->ByrightOf($case_details[0]->mut_type); ?>
                                        <?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $mut_type->order_type; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?> : <?php echo $dag_details[0]->dag_no; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?> : <?php echo $dag_details[0]->patta_no; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('case_no'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $case_details[0]->case_no; ?></label></td>
                                    <td><label class="text-danger">&nbsp;</label></td>
                                    <td><label class="text-danger">
                                        <?php $patta_type_name = $this->utilityclass->getPattaName($dag_details[0]->patta_type_code); ?>
                                        <?php echo $this->lang->line('patta_type'); ?> : <?php echo $patta_type_name; ?></label></td>
                                </tr>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198">Applicant Details</h4>
                            <table class="table table-bordered  unicode">
                                <thead>
                                    <tr>
                                        <th><label class="text-danger">Applicant name</label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                        <th class="center"><label class="text-danger">Guardian Name</label></th>
                                        <th class="center"><label class="text-danger">Address 1 / Address 2</label></th>
                                    </tr>
                                </thead>
                                <?php 
                                foreach ($field_mut_petitioner as $petitioner):
                                    ?>
                                    <tr>
                                        <td><label class="control-label"><?php echo $petitioner->pet_name; ?></label></td>
                                        <?php
                                        $dist_code = $this->session->userdata('dist_code');
                                        if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                        <td><label class="control-label"><?php echo $petitioner->applied_b . " বিঘা " . $petitioner->applied_k . " কঠা " . $petitioner->applied_lc . " ছটাক ".$petitioner->applied_g . " গণ্ডা" ?></label></td>
                                    <?php }else{?>
                                        <td><label class="control-label"><?php echo $petitioner->applied_b . " বিঘা " . $petitioner->applied_k . " কঠা " . $petitioner->applied_lc . " লেছা " ?></label></td>
                                    <?php }?>
                                        <td class="center"><label class="control-label"><?php echo $petitioner->guard_name; ?></label></td>
                                        <td class="center"><label class="control-label"><?php echo $petitioner->add1; ?></label></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <fieldset>
                            <h4 class="bold" style="color:#3c8198">In place / Along with Information</h4>
                            <table class='table table-bordered  unicode'>
                                <thead>
                                    <tr>
                                        <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                        <th><label class="text-danger">In place / Along with</label></th>
                                        <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                    </tr>
                                </thead>
                                <?php
                                foreach ($field_mut_pattadar as $pattadars):
                                    ?>
                                    <tr>
                                        <td><label class="control-label"><?php echo $pattadars->pdar_name; ?></label></td>
                                        <td><label class="control-label"><?php echo $pattadars->pdar_guardian; ?></label></td>
                                        <td><label class="control-label"><?php echo $pattadars->pdar_add1; ?></label></td>
                                        <td><label class="control-label">
                                            <?php
                                             if(trim($pattadars->striked_out) == '0'){
                                                 echo "Along With";
                                             } else {
                                                 echo "In Place Of";
                                             }
                                            ?>
                                            </label></td>
                                        <td><label class="control-label"><?php  ?></label></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12" id="co_block">
                                    <label class="rasid col-sm-12">
                                          <input type="checkbox" id="myCheck" onclick="myFunction()"> চঃ বিঃ – লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া নামজাৰী ও নথি সংশোধন অনুমোদন কৰা হ’ল   |
                                    </label>
                            </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-4">
                                <?php
                                    if($location['mutation_type'] == 'F'){
                                        ?>
                                        <a href="<?php echo base_url() . "index.php/BackLogMutation/UpdateFMutation"; ?>" class="btn btn-success" id="change_text1"><i class='fa fa-check'></i>&nbsp;Submit & Pass Final Order</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo base_url() . "index.php/BackLogMutation/UpdateOMutation"; ?>" class="btn btn-success" id="change_text1"><i class='fa fa-check'></i>&nbsp;Submit & Pass Final Order</a>
                                        <?php
                                    }
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/BackLogMutation/PendingCases" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 $("#change_text1").attr('disabled', true);
 function myFunction() {
    var checkBox = document.getElementById("myCheck");
    if (checkBox.checked == true){
      $('#change_text1').removeAttr('disabled', false);
    } else {
      $('#change_text1').attr('disabled', true);
    }
}   
</script>
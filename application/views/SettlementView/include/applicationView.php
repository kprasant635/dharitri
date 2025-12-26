<style>
  
    .enc-area-color{
        background: #FFFAEC!important;
    }

    .settlement-area-color{
        background: #EAFFEA!important;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
    .element{
        margin-bottom: 10px;
    }

    .add,.remove{
        padding: 2px 10px;
    }

    .add:hover,.remove:hover{
        cursor: pointer;
    }
    .delete{
        padding: 2px 10px;
    }


    /* modal css */
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 70%;
    }

    /* The Close Button */
    .close-enc-modal{
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close-enc-modal:hover,
    .close-enc-modal:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }


    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    div.alternate_div > div:nth-of-type(odd) {
        background: #f2fdff;
        padding-top: 3px;
        padding-bottom: 5px;
    }


</style>
<style>
    .edit-enc-close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .edit-enc-close:hover,
    .edit-enc-close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }
</style>

<?php if((in_array($app->dist_code, json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
else{
    $lessa_chatak='Lessa';
}?>

<div class="reza-card">
    <div id="additionalErrors" class="text-right px-4 mt-2" style="cursor:pointer;">

    <?php
    if(isset($all_errors)){?>
        <span class="text-danger">
                <i id="blink" class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>
                Check errors
            </span>
    <?php }?>
    </div>
    <div id="additional_errors_collapse" style="display: none;">
        <?php
        if(isset($all_errors)){?>
            <div class="alert alert-warning">
                <b>
                    <?=$all_errors;?>
                </b>
            </div>
            <?php
        }
        ?>

    </div>
    <div class="reza-body" style="margin-top: 7px">

        <h5 class="reza-title">
            <i class="fa fa-file-text"></i>
            Application Details
        </h5>
        <div class="tableCard">

        <div class="row justify-content-center">
        <?php
            if(isset($aadhar)){
            if($aadhar){
                    if($aadhar->type == 'AADHAAR'){
                                    ?>
                    <div class="col-md-2 text-center">
                        <?=$aadhaar_b64_decoded?>
                    </div>

            <?php }}} ?>

            <input type="hidden" name="identity_type" value="<?=$aadhar->type?>">
            <input type="hidden" name="identity_ref_no" value="<?php if($aadhar->type == 'AADHAAR'){ echo $aadhar->aadhaar_no;}else{ echo $aadhar->pan_no;}?>">

            <div class="col-md-10">

                <table class="table table-bordered">
                    <?php
                        if(isset($aadhar)){
                            if($aadhar){
                                ?>

                                <tr>
                                    <th>
                                        Name in <?=$aadhar->type?>
                                    </th>
                                    <td>
                                        <?php
                                            if($aadhar->aadhaar_no || $aadhar->pan_no){
                                                foreach($applicants as $doc_name):
                                                    if($doc_name->is_applicant == 1):
                                                ?>
                                                    <input type="text" name="name_in_doc" value="<?=$doc_name->name_eng?>" class="form-control" readonly>
                                                <?php
                                                    endif;
                                                endforeach;
                                            }
                                        ?>

                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <?=$aadhar->type?> Verified ?
                                    </th>
                                    <td>
                                        <?php
                                            if($aadhar->aadhaar_no || $aadhar->pan_no){
                                            ?>
                                                <input type="text" readonly value="Yes" class="form-control">
                                            <?php
                                            }
                                        ?>

                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>

                    <?php
                    if($settlements == true){
                        // echo "<pre>";
                        // var_dump($settlements);
                        // die;
                        foreach($settlements as $settlement){

                            if($settlement->is_applicant == 1){
                                ?>
                                <tr>
                                    <th>Occupation or Profession of the applicant</th>
                                    <td>
                                        <input type="text" id="occupation_applicant" name="occupation_applicant" value="<?=$settlement->applicant_occupation?>" class="form-control" readonly>
                                    </td>
                                </tr>
                                <?php
                            }
                            if($settlement->is_applicant == 1){
                                ?>
                                <tr>
                                    <th>Caste</th>
                                    <td>

                                        <input type="hidden" name="caste" value="<?=$settlement->caste_category?>" class="form-control">
                                        <input type="text" id="caste_name" name="" value="<?php
                                        foreach(json_decode(CASTE) as $caste){
                                            if($caste->CODE == $settlement->caste_category){
                                                echo $caste->NAME;
                                            }
                                        }
                                        ?>" class="form-control" readonly>
                                    </td>
                                </tr>
                                <?php
                            }

                            if($settlement->is_applicant == 1){
                                // var_dump($settlement);
                                // die;
                                if($settlement->tribe_category){

                                ?>
                                <tr>
                                    <th>Select if you fall under protected category?</th>
                                    <td>
                                        <input type="hidden" name="protected_class" value="<?=$settlement->tribe_category?>" class="form-control">

                                        <input type="text" name="" value="<?php
                                        foreach(json_decode(PROTECTED_CLASS) as $class){


                                            if($class->CODE == $settlement->tribe_category){
                                                echo $class->NAME;
                                            }
                                        }
                                        ?>" class="form-control" readonly>
                                    </td>
                                </tr>
                                <?php
                            }}
                        }
                    }
                    ?>
                    <tr>
                        <th>Total Applications applied by this applicant</th>
                        <td>
                            <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$app->application_no;?>">
                                <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </div>

        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-map-marker"></i> Location Details
        </h5>
        <div class="tableCard ">
            <table class="table table-bordered">
                <tr>
                    <th>District Name:</th>
                    <td class="text-warning">
                        <strong class="alert-warning">
                            <input type="text" name="dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($app->dist_code)?>' readonly>
                            <input type="hidden" name="dist_code" value="<?=$app->dist_code;?>" required>
                        </strong></td>
                    <th>Subdivision Name:</th>
                    <td class="text-warning">
                        <strong class="alert-warning">
                            <input type="text" name="subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?>' readonly>
                            <input type="hidden" name="subdiv_code" value="<?=$app->subdiv_code;?>" required>

                        </strong>
                    </td>
                </tr>
                <tr>
                    <th>Circle Name: </th>
                    <td class="text-warning">
                        <strong class="alert-warning">
                            <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?>' class="form-control input-sm" readonly>
                            <input type="hidden" name="cir_code" value="<?=$app->cir_code;?>" required>

                        </strong></td>
                    <th>Mouza Name: </th>
                    <td class="text-warning">
                        <strong class="alert-warning">
                            <input type="text" name="mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?>' readonly>
                            <input type="hidden" name="mouza_pargona_code" value="<?=$app->mouza_code;?>" required>

                        </strong>
                    </td>
                </tr>
                <tr>

                    <th>Village Name: </th>
                    <td class="text-warning">
                        <strong class="alert-warning">
                            <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?>' class="form-control input-sm" readonly>
                            <input type="hidden" name="vill_townprt_code" value="<?=$app->village_code;?>" required>

                        </strong>
                    </td>
                </tr>


            </table>
        </div>



        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-pencil-square-o"></i> Self declaration details
        </h5>
        <div class="tableCard">
            <table class="table table-bordered">
                <?php
                // echo "<pre>";
                // var_dump($selfDeclarationDetails);
                // echo "</pre>";
                foreach($selfDeclarationDetails[0] as $key=>$self){
                    // var_dump($self->name.$key);
                    // echo "<tr><th>". $self->name ."</th><td>:". $key=='0'?'No':'Yes' ."</td></tr>";
                    ?>
                    <tr>
                        <th><?=$self->name ?></th>
                        <td class="text-center">
                            <strong>
                                <?php if ($self->status == "1"){ echo "Yes"; }?>
                                <?php if ($self->status == "0"){ echo "No"; }?>
                            </strong>
                        </td>
                    </tr>
                <?php }?>
            </table>
        </div>


        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-user"></i>  Applicant details
        </h5>

        <?php
        $i = 1;foreach ($applicants as $settlement): ?>
            <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
            <div class="tableCard" id='applicantrow_<?=$i?>'>
                <table class="table table-bordered" >
                    <tr>
                        <th rowspan="6" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                        <th>Applicant Name (Assamese)</th>
                        <td>
                            <input type="text" name="pdar_name<?=$settlement->id?>" value="<?php if(isset($err_return)){ echo set_value('pdar_name'.$settlement->id);}else{ echo $settlement->name_ass;}?>" class="input_editable_background form-control input-sm <?php if(form_error('pdar_name'.$settlement->id)){echo 'is-invalid';}?>">
                            <?=form_error('pdar_name' . $settlement->id)?>
                        </td>
                        <th>Guardian Name (Assamese)</th>
                        <td>
                            <input type="text" name="pdar_guardian<?=$settlement->id?>" value="<?php if(isset($err_return)){ echo set_value('pdar_guardian'.$settlement->id);}else{ echo $settlement->gurdian_name_ass;}?>" class="form-control input_editable_background input-sm <?php if (form_error('pdar_guardian' . $settlement->id)) {echo 'is-invalid';}?>">
                            <?=form_error('pdar_guardian' . $settlement->id)?>
                        </td>
                    </tr>

                    <tr>
                        <th>Applicant Name (English)</th>
                        <td>
                            <input type="text" name="eng_pdar_name<?=$settlement->id?>" value="<?php if(isset($err_return)){ echo set_value('eng_pdar_name'.$settlement->id);}else{ echo $settlement->name_eng;}?>" class="form-control input-sm <?php if(form_error('eng_pdar_name'.$settlement->id)){echo 'is-invalid';}?>" readonly>
                            <?=form_error('eng_pdar_name' . $settlement->id)?>
                        </td>

                        <th>Guardian Name (English)</th>
                        <td>
                            <input type="text" name="eng_pdar_guardian<?=$settlement->id?>" value="<?php if(isset($err_return)){ echo set_value('eng_pdar_guardian'.$settlement->id);}else{ echo $settlement->gurdian_name_eng;}?>" class="form-control input_editable_background input-sm <?php if(form_error('eng_pdar_guardian'.$settlement->id)){echo 'is-invalid';}?>">
                            <?=form_error('eng_pdar_guardian' . $settlement->id)?>
                        </td>

                    </tr>

                    <tr>
                        <th>DOB</th>
                        <td>
                            <input type="text" readonly name="dob<?=$settlement->id?>" class="form-control" value="<?=$settlement->dob?>">
                        </td>
                        <?php if($settlement->is_applicant == 1):?>
                        <th>Marital Status</th>
                        <td>
                            <input type="text" class="form-control" value="<?php foreach(json_decode(MARITAL_STATUS) as $married){ if($married->CODE == $settlement->marital_status){ echo $married->NAME;}}?>" name="marital_status" id="" readonly>
                        </td>
                        <?php endif;?>

                    </tr>
                    <tr>
                        <th>Relation</th>
                        <td>
                            <select name="pdar_rel_guar<?=$settlement->id?>" id="pdar_rel_guar<?=$settlement->id?>" class="form-control input_editable_background <?php if (form_error('pdar_rel_guar' . $settlement->id)) {echo 'is-invalid';}?>" required>
                                <option value="">Select relation...</option>
                                <?php foreach ($guar_rel as $guar_rel_list) {
                                    ?>
                                    <option value="<?=$guar_rel_list->id?>" <?php if(isset($err_return)){ if (set_value('pdar_rel_guar' . $settlement->id) == $guar_rel_list->id) { echo "selected"; }}elseif ($guar_rel_list->id == $settlement->gurdian_relation_id) { echo "selected";}?>>
                                        <?=$guar_rel_list->guard_rel_desc_as?>
                                    </option>
                                <?php }?>

                            </select>
                            <?=form_error('pdar_rel_guar' . $settlement->id)?>
                        </td>
                        <th>Gender</th>
                        <td>
                            <select name="pdar_gender<?=$settlement->id?>" id="pdar_gender<?=$settlement->id?>"
                                    class="form-control input_editable_background <?php if (form_error('pdar_gender' . $settlement->id)) {echo 'is-invalid';}?>">
                                <option value="">Select gender...</option>
                                <option value="1" <?php if(isset($err_return)) {if (set_value('pdar_gender' . $settlement->id) == "1") {echo "selected";}} elseif ($settlement->gender == "1") {echo "selected";}?>>Male</option>
                                <option value="2" <?php if(isset($err_return)) {if (set_value('pdar_gender' . $settlement->id) == "2") {echo "selected";}} elseif ($settlement->gender == "2") {echo "selected";}?>>Female</option>
                                <option value="3" <?php if(isset($err_return)) {if (set_value('pdar_gender' . $settlement->id) == "3") {echo "selected";}} elseif ($settlement->gender == "3") {echo "selected";}?>>Others</option>
                            </select>
                            <?=form_error('pdar_gender' . $settlement->id)?>
                        </td>
                    </tr>
                    <tr>
                    <th>Mobile</th>
                        <td>
                            <input type="text" name="pdar_mobile<?=$settlement->id?>" value="<?php if(isset($err_return)) { echo set_value('pdar_mobile' . $settlement->id);} else { echo $settlement->mobile;}?>" class="form-control input_editable_background input-sm <?php if (form_error('pdar_mobile' . $settlement->id)) {echo 'is-invalid';}?>" >
                            <?=form_error('pdar_mobile' . $settlement->id)?>
                        </td>
                        <th>
                            Permanent address
                        </th>
                        <td colspan="3">
                            <input type="text" name="pdar_add1<?=$settlement->id?>" value="<?php if(isset($err_return)) { echo set_value('pdar_add1' . $settlement->id);} else { echo $settlement->per_add;}?>" class="form-control input_editable_background input-sm <?php if (form_error('pdar_add1' . $settlement->id)) {echo 'is-invalid';}?>">
                            <?=form_error('pdar_add1' . $settlement->id)?>
                        </td>
                    </tr>
                    <tr>
                        <th>Present address</th>
                        <td colspan="3">
                            <input type="text" name="pdar_add2<?=$settlement->id?>" value="<?php if(isset($err_return)) { echo set_value('pdar_add2' . $settlement->id);} else { echo $settlement->pre_add;}?>" class="form-control input_editable_background input-sm <?php if (form_error('pdar_add2' . $settlement->id)) {echo 'is-invalid';}?>" >
                            <?=form_error('pdar_add2' . $settlement->id)?>
                        </td>
                    </tr>

                    <?php if ($settlement->is_applicant != 1) {?>
                        <tr>
                            <td>
                                <span onclick="deleteApplicant(<?=$settlement->id?>)" id="<?=$settlement->id?>_<?=$i?>" class='delete'><i class="fa fa-trash-o" style="font-size:32px;color:red"></i></span>
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>

            <?php
            $i++;
        endforeach;?>

        <input type="hidden" name="deleted_applicant" value="" id="del_fpart_appl">

        <?php
            if(ADD_APPLICANT_STATUS == 1):
        ?>
        <?php if(ENABLE_BUTTON_ADD_APPLICANT != 0){?>
        <div class='element' id='div_1' style="margin-bottom: 25px; margin-top: 25px">
            <a class="rezaButt buttDanger add" style="color: white;font-size: 15px"> <i class="fa fa-plus-circle"></i>
                Add Applicant
            </a>
        </div>
        <?php } ?>

        <?php
            endif;
        ?>



        <?php if($owners == true){ ?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user-secret"></i>  Land Owner Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php
                    foreach($owner as $owners){
                        ?>

                        <tr>
                            <th>Name</th>
                            <td colspan="2">
                                <input type="text" name="owners_name<?=$owners->pdar_id?>" value="<?=$owners->pdar_name;?>" class="form-control input-sm">
                            </td>
                            <th>Father's name</th>
                            <td colspan="2">
                                <input type="text" name="owners_guardian<?=$owners->pdar_id?>" value="<?=$owners->pdar_father;?>" class="form-control input-sm" >
                            </td>
                            <th>
                                In place/Along with
                            </th>
                            <td>
                                <select name="owners_in_place" id="" class="form-control" required>
                                    <option value="">Select...</option>
                                    <option value="i">In Place</option>
                                    <option value="a">Along with</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        <?php } ?>

        <?php if($encroachers == true){  ?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user-secret"></i>  Occupier's Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php
                    $enc_count = 1; 
                    
                    foreach($encroachers as $riotee){
                        if (!in_array($riotee->dag_no, $settlement_vlb_encroacher_check)){
                            ?>
                            <tr>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;"><?=$enc_count++;?></th>
                                <th>Dag No</th>
                                <td colspan="2">
                                    <input readonly type="text" name="enc_dag<?=$riotee->id?>" value="<?=$riotee->dag_no;?>" class="form-control input-sm encroacher_dag" >
    
                                </td>
    
                                <th>Name</th>
                                <td colspan="2">
                                    <input type="hidden" id="enc_id<?=$riotee->id?>" name="enc_id<?=$riotee->id?>" value="<?=$riotee->encroacher_id=='-1' ? '' : $riotee->encroacher_id?>">
    
    
                                    <input type="text" readonly id="enc_name<?=$riotee->id?>" name="riotee_name<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_name'.$riotee->id);}else{ echo $riotee->encroacher_id=='-1' || $riotee->encroacher_id=='' ? '' :$riotee->name_ass;}?>" class="form-control input-sm <?php if(form_error('riotee_name'.$riotee->id)){echo 'is-invalid';}?>">
    
                                    <?=form_error('riotee_name'.$riotee->id)?>
                                </td>
    
                                <?php if(ENABLE_BUTTON_CHANGE_ENCROACHER != 0){?>
    
                                <td rowspan="2" style="vertical-align : middle;">
                                <?php
                                    if($riotee->encroacher_id=='-1'):
                                        if(isset($settlement_vlb_encroacher_check)):
                                            if (in_array($riotee->dag_no, $settlement_vlb_encroacher_check)){
    
                                                foreach($land_bank_status as $land_bank_stats):
                                                    if($land_bank_stats != false):
    
                                                        if($land_bank_stats->dag_no == $riotee->dag_no){
                                                            if(trim($land_bank_stats->status) == 'A'){
                                                            ?>
                                                                <span class="alert-success">Encroacher already added for this dag no...</span>
                                                                <br>
                                                                <span class="alert-success">
                                                                    <strong>Status : Approved</strong>
                                                                </span>
                                                                <br>
                                                                <br>
    
                                                            <?php
                                                            }else{
                                                                ?>
                                                                <span class="alert-danger">Encroacher added.</span>
                                                                <br>
                                                                <span class="alert-danger">
                                                                    <strong>Status : Pending</strong>
                                                                </span>
                                                                <br>
                                                                <br>
                                                                <?php
                                                            }
                                                        }
                                                    endif;
                                                endforeach;
    
                                            }else{
                                                ?>
                                                <button type="button" onclick="addEncroacher(<?=$riotee->dag_no;?>,<?=$riotee->id?>,<?=$riotee->applied_bigha?>, <?=$riotee->applied_katha?>, <?=$riotee->applied_lessa?>, <?=$riotee->applied_ganda?>, <?=$riotee->applied_kranti?>);" class="btn btn-sm btn-danger">Add Occupier</button>
                                                    <br>
                                            <?php
                                            }
                                        endif;
                                    endif;
                                ?>
    
                                    <button type="button" class="mt-1 btn btn-sm btn-primary"
                                            onclick="encroacherModal(<?=$riotee->dag_no;?>,<?=$riotee->id?>);" id="<?=$riotee->dag_no;?>">
                                            VLB List
                                    </button>
    
                                </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <th>Father's Name</th>
                                <td colspan="2">
                                    <input readonly type="text" id="enc_gur_name<?=$riotee->id?>" name="riotee_guardian<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_guardian'.$riotee->id);}else{ echo $riotee->encroacher_id=='-1' || $riotee->encroacher_id=='' ? '' : $this->utilityclass->getEncroacherDetails($riotee->encroacher_id);}?>" class="form-control input-sm" >
    
                                </td>
    
                                <th>Possession From</th>
                                <td colspan="2">
                                    <input readonly type="text" id="enc_period_possession<?=$riotee->id?>" name="period_possession<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('period_possession'.$riotee->id);}else{ echo $riotee->encroacher_id=='-1' || $riotee->encroacher_id=='' ? '' : $riotee->possession_date;}?>"  class="possesiondate form-control">
    
                                </td>
    
                            </tr>
    
                            <?php
                         
                        }
                        else{
                            if(isset($settlement_land_bank_details)){
                                foreach($settlement_land_bank_details as $bank){
                                    if($bank != false){
                                        if($bank->dag_no == $riotee->dag_no){
                                            ?>
                                            <tr>
                                                <th rowspan="2" style="vertical-align : middle;text-align:center;"><?=$enc_count++;?></th>
                                                <th>Dag No</th>
                                                <td colspan="2">
                                                    <input readonly type="text" name="enc_dag<?=$riotee->id?>" value="<?=$riotee->dag_no;?>" class="form-control input-sm encroacher_dag" >
                    
                                                </td>
                    
                                                <th>Name</th>
                                                <td colspan="2">
                                                    <input type="hidden" id="enc_id<?=$riotee->id?>" name="enc_id<?=$riotee->id?>" value="<?=$bank->encroacher_id?>">
                    
                    
                                                    <input type="text" readonly id="enc_name<?=$riotee->id?>" name="riotee_name<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_name'.$riotee->id);}else{ echo $bank->enc_name;}?>" class="form-control input-sm <?php if(form_error('riotee_name'.$riotee->id)){echo 'is-invalid';}?>">
                    
                                                    <?=form_error('riotee_name'.$riotee->id)?>
                                                </td>
                    
                                                <?php if(ENABLE_BUTTON_CHANGE_ENCROACHER != 0){?>
                    
                                                <td rowspan="2" style="vertical-align : middle;">
                                                <?php
                                                    if($riotee->encroacher_id=='-1'):
                                                        if(isset($settlement_vlb_encroacher_check)):
                                                            if (in_array($riotee->dag_no, $settlement_vlb_encroacher_check)){
                    
                                                                foreach($land_bank_status as $land_bank_stats):
                                                                    if($land_bank_stats != false):
                    
                                                                        if($land_bank_stats->dag_no == $riotee->dag_no){
                                                                            if(trim($land_bank_stats->status) == 'A'){
                                                                            ?>
                                                                                <span class="alert-success">Encroacher already added for this dag no...</span>
                                                                                <br>
                                                                                <span class="alert-success">
                                                                                    <strong>Status : Approved</strong>
                                                                                </span>
                                                                                <br>
                                                                                <br>
                    
                                                                            <?php
                                                                            }else{
                                                                                ?>
                                                                                <span class="alert-danger">Encroacher added.</span>
                                                                                <br>
                                                                                <span class="alert-danger">
                                                                                    <strong>Status : Pending</strong>
                                                                                </span>
                                                                               <br>

                                                                                <button type="button" onclick="editEncroacher(<?=$riotee->dag_no?>,<?=$riotee->id?>, <?=$bank->encroacher_id?>,<?=$bank->land_bank_details_id?>);" class="btn btn-warning btn-sm">Edit Occupier</button>
                                                                                <br>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    endif;
                                                                endforeach;
                    
                                                            }else{
                                                                ?>
                                                                <button type="button" onclick="addEncroacher(<?=$riotee->dag_no;?>,<?=$riotee->id?>,<?=$riotee->applied_bigha?>, <?=$riotee->applied_katha?>, <?=$riotee->applied_lessa?>, <?=$riotee->applied_ganda?>, <?=$riotee->applied_kranti?>);" class="btn btn-sm btn-danger">Add Occupier in VLB</button>
                                                                    <br>
                                                            <?php
                                                            }
                                                        endif;
                                                    endif;
                                                ?>
                    
                                                    <button type="button" class="mt-1 btn btn-sm btn-primary"
                                                            onclick="encroacherModal(<?=$riotee->dag_no;?>,<?=$riotee->id?>);" id="<?=$riotee->dag_no;?>">
                                                        VLB List
                                                    </button>
                    
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <th>Father's Name</th>
                                                <td colspan="2">
                                                    <input readonly type="text" id="enc_gur_name<?=$riotee->id?>" name="riotee_guardian<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_guardian'.$riotee->id);}else{ echo $bank->enc_fathers_name;}?>" class="form-control input-sm" >
                    
                                                </td>
                    
                                                <th>Possession From</th>
                                                <td colspan="2">
                                                    <input readonly type="text" id="enc_period_possession<?=$riotee->id?>" name="period_possession<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('period_possession'.$riotee->id);}else{ echo $bank->enc_from_date;}?>"  class="possesiondate form-control">
                    
                                                </td>
                    
                                            </tr>
                    
                                            <?php                                            

                                        }
                                    }
                                }
                            }
                        }
                
                    }
                    ?>
                </table>
            </div>
        <?php } ?>

        <?php if($riotee_noks == true){ ?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user-plus"></i>  Riotee's NOK(This would be added to the Riotee khatian)
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php
                    foreach($riotee_nok as $riotee_nok){
                        ?>
                        <tr>
                            <th>Khatian Number</th>
                            <td colspan="2">
                                <input type="text" name="riotee_nok_khatian_no<?=$riotee_nok->id?>" value="<?=$riotee->khatian_no;?>" class="form-control input-sm">
                            </td>
                            <th>Name</th>
                            <td colspan="2">
                                <input type="text" name="riotee_nok_name<?=$riotee_nok->id?>" value="<?=$riotee_nok->name_ass;?>" class="form-control input-sm">
                            </td>
                            <th>Father's name</th>
                            <td colspan="2">
                                <input type="text" name="riotee_nok_guardian<?=$riotee_nok->id?>" value="<?=$riotee_nok->gurdian_name_ass;?>" class="form-control input-sm" >
                            </td>
                            <th>Relationship with Riotee</th>
                            <td colspan="2">
                                <?php
                                if($riotee_nok->pdar_type == 'GP'){
                                    ?>
                                    <input type="hidden" name="riotee_nok_relation<?=$riotee_nok->id?>" value="#">
                                    <input type="text" name="pdar_riotee_nok<?=$i?>" value="Grand Son/ Daughter" class="form-control input-sm" >
                                    <?php
                                }
                                elseif($riotee_nok->pdar_type == 'GGP'){
                                    ?>
                                    <input type="hidden" name="riotee_nok_relation<?=$riotee_nok->id?>" value="#">
                                    <input type="text" name="pdar_riotee_nok<?=$i?>" value="Great Grand Son/ Daughter" class="form-control input-sm" >
                                    <?php
                                }
                                ?>

                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>
        <?php } ?>

        <?php if(!empty($bhumi)){
            if($bhumi[0]->bhumi_cert_available || $bhumi[0]->is_bhumi_applied){?>
                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bhumiputra certificate/Ack verified?</th>
                            <td align="center">
                                <input style="margin: 4px 4px 5px -15px;;" type="radio" name="bhumiputra_confirmation" id="" class="form-check-input" value="YES" <?php if(!empty($bhumi[0]->bhumi_ack_no)){echo "checked";} ?> readonly>
                                <label for="bhumi_confirmation">Yes</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input style="margin: 4px 4px 5px -15px;;" type="radio" name="bhumiputra_confirmation" id="" class="form-check-input" value="NO" <?php if(empty($bhumi[0]->bhumi_ack_no)){echo "checked";} ?> readonly>
                                <label for="bhumi_confirmation">No</label>
                            </td>
                            <td>
                                <input type="hidden" name="bhumiputra_certificate_type" value="<?php
                                if($bhumi[0]->bhumi_cert_available == 1){
                                    echo BHUMI_CERT;
                                }elseif($bhumi[0]->is_bhumi_applied == 1){
                                    echo BHUMI_ACK;
                                }
                                ?>">
                                <input type="hidden" name="bhumiputra_certificate_no" value="<?=$bhumi[0]->bhumi_ack_no?>">
                                Certificate/Ack number : <b><?=$bhumi[0]->bhumi_ack_no?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        <?php } ?>


        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-map"></i>  Area Details
        </h5>
        <div class="tableCard">
            <div class="card-text alternate-table-color">
                <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                     class="<?php if(form_error('totalAppliedAdditionalArea')){echo 'is-invalid';} ?>">
                    <?=form_error('totalAppliedAdditionalArea');?>
                </div>
                <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
                     class="<?php if(form_error('totalAppliedAreaInUrban')){echo 'is-invalid';} ?>">
                    <?=form_error('totalAppliedAreaInUrban');?>
                </div>

                <table class="table">
                    <thead class="thead-warning">
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th class="text-center">Bigha</th>
                            <th class="text-center">Katha</th>
                            <th class="text-center"><?=$lessa_chatak?></th>
                            <?php if ((in_array($app->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <th class="text-center">Ganda</th>
                            <th class="text-center">Kranti</th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                <?php
                $i=1;
                $total_home_bigha=0;
                $total_home_katha=0;
                $total_home_lessa=0;
                $total_home_ganda=0;
                $total_home_kranti=0;

                $total_agri_bigha=0;
                $total_agri_katha=0;
                $total_agri_lessa=0;
                $total_agri_ganda=0;
                $total_agri_kranti=0;

                $total_fbigha=0;
                $total_fkatha=0;
                $total_flessa=0;
                $total_fganda=0;
                $total_fkranti=0;

                $total_area_bigha = 1;
                $total_area_katha = 1;
                $total_area_lessa = 1;
                $total_area_ganda = 1;
                $total_area_kranti = 1;

                $total_area_agri_bigha = 1;
                $total_area_agri_katha = 1;
                $total_area_agri_lessa = 1;
                $total_area_agri_ganda = 1;
                $total_area_agri_kranti = 1;

                //for encroacher area total calulation 
                $enc_total_area_bigha = 1;
                $enc_total_area_katha = 1;
                $enc_total_area_lessa = 1;
                $enc_total_area_ganda = 1;
                $enc_total_area_kranti = 1;

                $enc_total_area_agri_bigha = 1;
                $enc_total_area_agri_katha = 1;
                $enc_total_area_agri_lessa = 1;
                $enc_total_area_agri_ganda = 1;
                $enc_total_area_agri_kranti = 1;
                //end of encroacher area total calulation 


                $total_area_fbigha = 1;
                $total_area_fkatha = 1;
                $total_area_flessa = 1;
                $total_area_fganda = 1;
                $total_area_fkranti = 1;

                foreach($encroachers as $dags){
                $total_home_bigha=$total_home_bigha+$dags->mbigha;
                $total_home_katha=$total_home_katha+$dags->mkatha;
                $total_home_lessa=$total_home_lessa+$dags->mlessa;
                $total_home_ganda=$total_home_ganda+$dags->mganda;
                $total_home_kranti=$total_home_kranti+$dags->mkranti;

                $total_agri_bigha=$total_agri_bigha+$dags->agri_bigha;
                $total_agri_katha=$total_agri_katha+$dags->agri_katha;
                $total_agri_lessa=$total_agri_lessa+$dags->agri_lessa;
                $total_agri_ganda=$total_agri_ganda+$dags->agri_ganda;
                $total_agri_kranti=$total_agri_kranti+$dags->agri_kranti;

                $total_fbigha=$total_fbigha+$dags->fbigha;
                $total_fkatha=$total_fkatha+$dags->fkatha;
                $total_flessa=$total_flessa+$dags->flessa;
                $total_fganda=$total_fganda+$dags->fganda;
                $total_fkranti=$total_fkranti+$dags->fkranti;


                ?>
                    <input type="hidden" name="land_type<?=$dags->id?>" value="<?=$dags->land_type;?>" class="form-control input-sm">

                    <input type="hidden" name="new_land_class_code<?=$dags->id?>" value="<?=$this->utilityclass->classCodeFromChitha($dags->dist_code,$dags->subdiv_code,$dags->cir_code,$dags->mouza_code,$dags->lot_no,$dags->vill_code,$dags->dag_no)?>" class="form-control input-sm">


                    <input readonly type="hidden" name="dag_no<?=$dags->id?>" value='<?=$dags->dag_no?>' class="form-control input-sm">
                    <input readonly type="hidden" name="patta_no<?=$dags->id?>" class="form-control input-sm" value='<?=$dags->patta_no;?>'>

                    <input type="hidden" name="patta_type_code<?=$dags->id?>" value='<?=$dags->patta_code?>' class="form-control input-sm" >

                    <input type="hidden" name="patta_type_code_display" value='<?=$dags->patta_type?>' class="form-control input-sm" readonly>

                    <tr class="bg-white">
                        <th rowspan="6" style="vertical-align : middle;">
                            <div class="vertical">
                                DAG : <span class="text-danger"><?=$dags->dag_no?></span> | 
                                PATTA : <span class="text-danger"><?=$dags->patta_no?> | <?=$dags->patta_type?></span>
                            </div>
                        </th>
                        <th>Total Land Area in Selected Dag</th>
                        <td>
                            <strong>
                                <input type="text" readonly style="text-align: center;" name="dag_area_b<?=$dags->id?>" class="form-control input-sm" value="<?=$dags->applied_bigha?>" >
                            </strong>
                        </td>
                        <td>
                            <input type="text" readonly style="text-align: center;" name="dag_area_k<?=$dags->id?>" value="<?=$dags->applied_katha?>" class="form-control input-sm" >
                        </td>
                        <td>
                            <input type="text" readonly style="text-align: center;" name="dag_area_lc<?=$dags->id?>" class="form-control input-sm" value="<?=$dags->applied_lessa?>" >
                        </td>
                        <?php if((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <input type="text" readonly style="text-align: center;" value="<?=$dags->applied_ganda?>" class="form-control input-sm" name="dag_area_g<?=$dags->id?>" >
                            </td>
                            <td class="hide">
                                <input type="text" readonly style="text-align: center;" value="<?=$dags->applied_kranti?>" class="form-control input-sm" name="dag_area_kr<?=$dags->id?>" >
                            </td>
                        <?php endif ; ?>
                    </tr>

                    <tr class="bg-white">
                        <th class="enc-area-color">
                            Encroachment Area (Homestead)
                            <span class="<?php if(form_error('khasMaxHomestead')){echo 'is-invalid';}?>"></span>
                            <?=form_error('khasMaxHomestead');?>
                        </th>
                        <td class="enc-area-color">
                            <input type="number" style="text-align: center;" name="enc_mbigha<?=$dags->id?>" class="form-control input_editable_background input-sm enc_mbigha marea <?php if(form_error('enc_mbigha'.$dags->id)){echo 'is-invalid';}?>" onkeyup="totalAreaCal()" value="<?php if(isset($err_return)){ echo set_value('enc_mbigha'.$dags->id);}else{ echo $dags->mbigha;}?>" id="enc_mbigha<?=$enc_total_area_bigha++?>">
                            <?=form_error('enc_mbigha'.$dags->id)?>
                        </td>
                        <td class="enc-area-color">
                            <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="enc_mkatha<?=$dags->id?>" value="<?php if(isset($err_return)){ echo set_value('enc_mkatha'.$dags->id);}else{ echo $dags->mkatha;}?>" id="enc_mkatha<?=$enc_total_area_katha++?>" class="form-control input-sm input_editable_background enc_mkatha marea <?php if(form_error('enc_mkatha'.$dags->id)){echo 'is-invalid';}?>" >
                            <?=form_error('enc_mkatha'.$dags->id)?>
                        </td>
                        <td class="enc-area-color">
                            <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="enc_mlessa<?=$dags->id?>" id="enc_mlessa<?=$enc_total_area_lessa++?>" class="form-control input_editable_background input-sm enc_mlessa marea <?php if(form_error('enc_mlessa'.$dags->id)){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('enc_mlessa'.$dags->id);}else{ echo $dags->mlessa;}?>" >
                            <?=form_error('enc_mlessa'.$dags->id)?>
                        </td>
                        <?php if ((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <input onkeyup="totalAreaCal()" type="number" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('enc_mganda'.$dags->id);}else{ echo $dags->mganda;}?>" id="enc_mganda<?=$enc_total_area_ganda++?>" class="form-control input_editable_background input-sm enc_mganda marea <?php if(form_error('enc_mganda'.$dags->id)){echo 'is-invalid';}?>" name="enc_mganda<?=$dags->id?>" >
                                <?=form_error('enc_mganda'.$dags->id)?>
                            </td>
                            <td class="hide enc-area-color">
                                <input onkeyup="totalAreaCal()" type="number" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('enc_mkranti'.$dags->id);}else{ echo $dags->mkranti;}?>" id="enc_mkranti<?=$enc_total_area_kranti++?>" class="input_editable_background form-control input-sm enc_mkranti marea <?php if(form_error('enc_mkranti'.$dags->id)){echo 'is-invalid';}?>" name="enc_mkranti<?=$dags->id?>" >
                                <?=form_error('enc_mkranti'.$dags->id)?>
                            </td>
                        <?php endif;?>
                    </tr>


                    <tr class="bg-white">
                        <th class="enc-area-color">
                            Encroachment Area (Agricultural)
                            <span class="<?php if(form_error('khasMaxAgriculture')){echo 'is-invalid';}?>"></span>
                            <?=form_error('khasMaxAgriculture');?>
                        </th>
                        <td class="enc-area-color">
                            <input type="number" onkeyup="agriArea()" style="text-align: center;" required name="enc_agri_bigha<?=$dags->id?>" class="form-control input_editable_background input-sm enc_agri_bigha <?php if (form_error('enc_agri_bigha' . $dags->id)) {echo 'is-invalid';}?>" id="enc_agri_bigha<?=$enc_total_area_agri_bigha++?>"
                                   value="<?php if (isset($err_return)) { echo set_value('enc_agri_bigha' . $dags->id);} else { echo $dags->agri_bigha;}?>">
                            <?=form_error('enc_agri_bigha' . $dags->id)?>
                        </td>
                        <td class="enc-area-color">
                            <input type="number" onkeyup="agriArea()" style="text-align: center;" required name="enc_agri_katha<?=$dags->id?>" value="<?php
                            if (isset($err_return)) {
                                echo set_value('enc_agri_katha' . $dags->id);
                            } else {
                                echo $dags->agri_katha;
                            }
                            ?>" id="enc_agri_katha<?=$enc_total_area_agri_katha++?>" class="form-control input_editable_background input-sm enc_agri_katha <?php if (form_error('enc_agri_katha' . $dags->id)) {echo 'is-invalid';}?>" >
                            <?=form_error('enc_agri_katha' . $dags->id)?>
                        </td>
                        <td class="enc-area-color">
                            <input type="number" onkeyup="agriArea()" style="text-align: center;" required name="enc_agri_lessa<?=$dags->id?>" class="form-control input_editable_background input-sm enc_agri_lessa <?php if(form_error('enc_agri_lessa'.$dags->id)){echo 'is-invalid';}?>" id="enc_agri_lessa<?=$enc_total_area_agri_lessa++?>" value="<?php if(isset($err_return)){ echo set_value('enc_agri_lessa'.$dags->id);}else{ echo $dags->agri_lessa;}?>" >
                            <?=form_error('enc_agri_lessa'.$dags->id)?>

                        </td>
                        <?php if ((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td class="enc-area-color">
                                <input type="number" onkeyup="agriArea()" style="text-align: center;"  value="<?php if(isset($err_return)){ echo set_value('enc_agri_ganda'.$dags->id);}else{ echo $dags->agri_ganda;}?>" class="form-control input_editable_background input-sm enc_agri_ganda <?php if(form_error('enc_agri_ganda'.$dags->id)){echo 'is-invalid';}?>" id="enc_agri_ganda<?=$enc_total_area_agri_ganda++?>" name="enc_agri_ganda<?=$dags->id?>" >
                                <?=form_error('enc_agri_ganda'.$dags->id)?>
                            </td>
                            <td class="hide enc-area-color">
                                <input type="text" onkeyup="agriArea()" style="text-align: center;"  value="<?php if(isset($err_return)){ echo set_value('enc_agri_kranti'.$dags->id);}else{ echo $dags->agri_kranti;}?>" class="form-control input_editable_background input-sm enc_agri_kranti <?php if(form_error('enc_agri_kranti'.$dags->id)){echo 'is-invalid';}?>" id="enc_agri_kranti<?=$enc_total_area_agri_kranti++?>" name="enc_agri_kranti<?=$dags->id?>" >
                                <?=form_error('enc_agri_kranti'.$dags->id)?>
                            </td>
                        <?php endif;?>
                    </tr>


                    <tr class="bg-white">
                        <th class="settlement-area-color">
                            Area for Settlement (Homestead)
                            <span class="<?php if(form_error('khasMaxHomestead')){echo 'is-invalid';}?>"></span>
                            <?=form_error('khasMaxHomestead');?>
                        </th>
                        <td class="settlement-area-color">
                            <input type="number" style="text-align: center;" name="mbigha<?=$dags->id?>" class="form-control input_editable_background input-sm mbigha marea <?php if(form_error('mbigha'.$dags->id)){echo 'is-invalid';}?>" onkeyup="totalAreaCal()" value="<?php if(isset($err_return)){ echo set_value('mbigha'.$dags->id);}else{ echo $dags->mbigha;}?>" id="mbigha<?=$total_area_bigha++?>">
                            <?=form_error('mbigha'.$dags->id)?>
                        </td>
                        <td class="settlement-area-color">
                            <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="mkatha<?=$dags->id?>" value="<?php if(isset($err_return)){ echo set_value('mkatha'.$dags->id);}else{ echo $dags->mkatha;}?>" id="mkatha<?=$total_area_katha++?>" class="form-control input-sm input_editable_background mkatha marea <?php if(form_error('mkatha'.$dags->id)){echo 'is-invalid';}?>" >
                            <?=form_error('mkatha'.$dags->id)?>
                        </td>
                        <td class="settlement-area-color">
                            <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="mlessa<?=$dags->id?>" id="mlessa<?=$total_area_lessa++?>" class="form-control input_editable_background input-sm mlessa marea <?php if(form_error('mlessa'.$dags->id)){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('mlessa'.$dags->id);}else{ echo $dags->mlessa;}?>" >
                            <?=form_error('mlessa'.$dags->id)?>
                        </td>
                        <?php if ((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td class="settlement-area-color">
                                <input onkeyup="totalAreaCal()" type="number" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('mganda'.$dags->id);}else{ echo $dags->mganda;}?>" id="mganda<?=$total_area_ganda++?>" class="form-control input_editable_background input-sm mganda marea <?php if(form_error('mganda'.$dags->id)){echo 'is-invalid';}?>" name="mganda<?=$dags->id?>" >
                                <?=form_error('mganda'.$dags->id)?>
                            </td>
                            <td class="hide settlement-area-color">
                                <input onkeyup="totalAreaCal()" type="number" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('mkranti'.$dags->id);}else{ echo $dags->mkranti;}?>" id="mkranti<?=$total_area_kranti++?>" class="input_editable_background form-control input-sm mkranti marea <?php if(form_error('mkranti'.$dags->id)){echo 'is-invalid';}?>" name="mkranti<?=$dags->id?>" >
                                <?=form_error('mkranti'.$dags->id)?>
                            </td>
                        <?php endif;?>
                    </tr>


                    <tr class="bg-white">
                        <th class="settlement-area-color">
                            Area for Settlement (Agricultural)
                            <span class="<?php if(form_error('khasMaxAgriculture')){echo 'is-invalid';}?>"></span>
                            <?=form_error('khasMaxAgriculture');?>
                        </th>
                        <td class="settlement-area-color">
                            <input type="number" onkeyup="agriArea()" style="text-align: center;" required name="agri_bigha<?=$dags->id?>" class="form-control input_editable_background input-sm agri_bigha <?php if (form_error('agri_bigha' . $dags->id)) {echo 'is-invalid';}?>" id="agri_bigha<?=$total_area_agri_bigha++?>"
                                   value="<?php if (isset($err_return)) { echo set_value('agri_bigha' . $dags->id);} else { echo $dags->agri_bigha;}?>">
                            <?=form_error('agri_bigha' . $dags->id)?>
                        </td>
                        <td class="settlement-area-color">
                            <input type="number" onkeyup="agriArea()" style="text-align: center;" required name="agri_katha<?=$dags->id?>" value="<?php
                            if (isset($err_return)) {
                                echo set_value('agri_katha' . $dags->id);
                            } else {
                                echo $dags->agri_katha;
                            }
                            ?>" id="agri_katha<?=$total_area_agri_katha++?>" class="form-control input_editable_background input-sm agri_katha <?php if (form_error('agri_katha' . $dags->id)) {echo 'is-invalid';}?>" >
                            <?=form_error('agri_katha' . $dags->id)?>
                        </td>
                        <td class="settlement-area-color">
                            <input type="number" onkeyup="agriArea()" style="text-align: center;" required name="agri_lessa<?=$dags->id?>" class="form-control input_editable_background input-sm agri_lessa <?php if(form_error('agri_lessa'.$dags->id)){echo 'is-invalid';}?>" id="agri_lessa<?=$total_area_agri_lessa++?>" value="<?php if(isset($err_return)){ echo set_value('agri_lessa'.$dags->id);}else{ echo $dags->agri_lessa;}?>" >
                            <?=form_error('agri_lessa'.$dags->id)?>

                        </td>
                        <?php if ((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td class="settlement-area-color">
                                <input type="number" onkeyup="agriArea()" style="text-align: center;"  value="<?php if(isset($err_return)){ echo set_value('agri_ganda'.$dags->id);}else{ echo $dags->agri_ganda;}?>" class="form-control input_editable_background input-sm agri_ganda <?php if(form_error('agri_ganda'.$dags->id)){echo 'is-invalid';}?>" id="agri_ganda<?=$total_area_agri_ganda++?>" name="agri_ganda<?=$dags->id?>" >
                                <?=form_error('agri_ganda'.$dags->id)?>
                            </td>
                            <td class="hide settlement-area-color">
                                <input type="text" onkeyup="agriArea()" style="text-align: center;"  value="<?php if(isset($err_return)){ echo set_value('agri_kranti'.$dags->id);}else{ echo $dags->agri_kranti;}?>" class="form-control input_editable_background input-sm agri_kranti <?php if(form_error('agri_kranti'.$dags->id)){echo 'is-invalid';}?>" id="agri_kranti<?=$total_area_agri_kranti++?>" name="agri_kranti<?=$dags->id?>" >
                                <?=form_error('agri_kranti'.$dags->id)?>
                            </td>
                        <?php endif;?>
                    </tr>

                    <!-- input value modified to 0 for passing the case -->
                    <tr class="hide">
                        <th class="text-primary">Applied area (Fishery)</th>
                        <td>
                            <span class="input-group-addon">Bigha</span>
                            <input type="text" style="text-align: center;" required name="fbigha<?=$dags->id?>" class="form-control input-sm fbigha" value="0" onkeyup="fisheryArea()" id="fbigha<?=$total_area_fbigha++?>">
                        </td>
                        <td>
                            <span class="input-group-addon">Katha</span>
                            <input type="text" style="text-align: center;" required name="fkatha<?=$dags->id?>" value="0" class="form-control input-sm fkatha" onkeyup="fisheryArea()" id="fkatha<?=$total_area_fkatha++?>">
                        </td>
                        <td>
                            <span class="input-group-addon"><?=$lessa_chatak?></span>
                            <input type="text" style="text-align: center;" required name="flessa<?=$dags->id?>" class="form-control input-sm flessa" value="0" onkeyup="fisheryArea()" id="flessa<?=$total_area_flessa++?>">
                        </td>
                        <?php if((in_array($dags->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <span class="input-group-addon">Ganda</span>
                                <input type="text" style="text-align: center;"  value="0" class="form-control input-sm fganda" name="fganda<?=$dags->id?>" onkeyup="fisheryArea()" id="fganda<?=$total_area_fganda++?>">
                            </td>
                            <td class="hide">
                                <span class="input-group-addon">Kranti</span>
                                <input type="text" style="text-align: center;"  value="0" class="form-control input-sm fkranti" name="fkranti<?=$dags->id?>" onkeyup="fisheryArea()" id="fkranti<?=$total_area_fkranti++?>">
                            </td>
                        <?php endif ; ?>
                    </tr>
                    <tr class="bg-white">
                        <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                            <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$dags->application_no;?>&dag=<?=$dags->dag_no;?>">
                                <small style="font-size:14px; color:white; font-weight:bold">
                                    <i class="fa fa-eye"></i> View Total Applications in this Dag
                                </small>
                            </a>

                        </td>
                    </tr>


                    <?php $i++; }  ?>
                    <tr class="bg-white" style="border-top: 3px solid #227576;">
                        <th rowspan="2"></th>
                        <th class="text-danger">
                            Total Settlement Area (Homestead)
                            <span class="<?php if(form_error('khasMaxHomestead') ){echo 'is-invalid';}?>"></span>
                            <?=form_error('khasMaxHomestead');?>
                        </th>
                        <td>
                            <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_bigha" required class="form-control input-sm s_dag_area_b" id="total_applied_home_bigha" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_bigha');}else{ echo $total_home_bigha;}?>" >
                        </td>
                        <td>
                            <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_katha" required value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_katha');}else{ echo $total_home_katha;}?>" id="total_applied_home_katha" class="form-control input-sm s_dag_area_k" >

                        </td>
                        <td>
                            <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_lessa" required class="form-control input-sm s_dag_area_lc" id="total_applied_home_lessa" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_lessa');}else{ echo $total_home_lessa;}?>" >
                        </td>
                        <?php if ((in_array($app->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_ganda');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_g" id="total_applied_home_ganda" name="total_applied_area_homestead_ganda" >
                            </td>
                            <td class="hide">
                                <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_kranti');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_kr" id="total_applied_home_kranti" name="total_applied_area_homestead_kranti" >
                            </td>
                        <?php endif;?>
                    </tr>

                    <tr>
                        <th class="text-danger">
                            Total applied area (Agricultural)
                            <span class="<?php if(form_error('khasMaxAgriculture') ){echo 'is-invalid';}?>"></span>
                            <?=form_error('khasMaxAgriculture');?>
                        </th>
                        <td>
                            <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_bigha" class="form-control input-sm ag_dag_area_b"  id="total_applied_agri_bigha"
                                   value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_bigha');}else{ echo $total_agri_bigha;}?>">
                        </td>
                        <td>
                            <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_katha" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_katha');}else{ echo $total_agri_katha;}?>" id="total_applied_agri_katha"  class="form-control input-sm ag_dag_area_k" >
                        </td>
                        <td>
                            <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_lessa" class="form-control input-sm ag_dag_area_lc" id="total_applied_agri_lessa"  value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_lessa');}else{ echo $total_agri_lessa;}?>" >
                        </td>
                        <?php if ((in_array($app->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_ganda');}else{ echo $total_agri_ganda;}?>" class="form-control input-sm ag_dag_area_g" id="total_applied_agri_ganda"  name="total_applied_area_agricultural_ganda" >
                            </td>
                            <td class="hide">
                                <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_kranti');}else{ echo $total_agri_kranti;}?>" class="form-control input-sm ag_dag_area_kr" id="total_applied_agri_kranti"  name="total_applied_area_agricultural_kranti" >
                            </td>
                        <?php endif;?>
                    </tr>

                    <tr class="hide">
                        <th class="text-danger">Total applied area (Fishery)</th>
                        <td>
                            <span class="input-group-addon">Bigha</span>
                            <input type="text" readonly style="text-align: center;" name="f_dag_area_b" class="form-control input-sm f_dag_area_b" value="<?=$total_fbigha?>" id="total_applied_fbigha">
                        </td>
                        <td>
                            <span class="input-group-addon">Katha</span>
                            <input type="text" readonly style="text-align: center;" name="f_dag_area_k" value="<?=$total_fkatha?>" class="form-control input-sm f_dag_area_k" id="total_applied_fkatha">
                        </td>
                        <td>
                            <span class="input-group-addon"><?=$lessa_chatak?></span>
                            <input type="text" readonly style="text-align: center;" name="f_dag_area_lc" class="form-control input-sm f_dag_area_lc" value="<?=$total_flessa?>" id="total_applied_flessa">
                        </td>
                        <?php if((in_array($app->dist_code, json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <span class="input-group-addon">Ganda</span>
                                <input type="text" readonly style="text-align: center;" value="<?=$total_fganda?>" class="form-control input-sm f_dag_area_g" name="f_dag_area_g" id="total_applied_fganda">
                            </td>
                            <td class="hide">
                                <span class="input-group-addon">Kranti</span>
                                <input type="text" readonly style="text-align: center;" value="<?=$total_fkranti?>" class="form-control input-sm f_dag_area_kr" name="f_dag_area_kr" id="total_applied_fkranti">
                            </td>
                        <?php endif ; ?>
                    </tr>
                </table>
                <!-- this only to display the error message in area validation -->
                <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                <?=form_error('totalAppliedAreaZeroCheck');?>

                <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                <?=form_error('appAreaMoreThanDagA');?>
                <br>

            </div>
        </div>

        <!-- additional property -->
        <?php if(isset($property) && !empty($property)) { ?>
            <h5  class="reza-title" style="margin-top: 50px">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Additional Property Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php $i=1; foreach($property as $adp): ?>
                        <tr>
                            <th>District Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="hidden" name="a_dist_code[]" value="<?=$adp->dist_code?>">
                                    <input type="text" name="" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($adp->dist_code)?>' readonly>
                                </strong></td>
                            <th>Subdivision Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="hidden" name="a_subdiv_code[]" value="<?=$adp->subdiv_code?>">
                                    <input type="text" name="" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($adp->dist_code,$adp->subdiv_code)?>' readonly>

                                </strong>
                            </td>
                            <th>Circle Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="hidden" name="a_circle_code[]" value="<?=$adp->cir_code?>">
                                    <input type="text" name="" value='<?=$this->utilityclass->getCircleName($adp->dist_code,$adp->subdiv_code,$adp->cir_code)?>' class="form-control input-sm" readonly>

                                </strong></td>
                        </tr>

                        <tr>
                            <th>Mouza Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="hidden" name="a_mouza_code[]" value="<?=$adp->mouza_pargona_code?>">
                                    <input type="text" name="" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code)?>' readonly>

                                </strong>
                            </td>
                            <th>Village Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="hidden" name="a_village_code[]" value="<?=$adp->vill_townprt_code?>">
                                    <input type="hidden" name="a_lot_no[]" value="<?=$adp->lot_no?>">
                                    <input type="hidden" name="a_rural_urban[]" value="<?=$adp->is_rural?>">
                                    <input type="hidden" name="a_service_code[]" value="<?=$adp->service_id?>">

                                    <input type="text" name="" value='<?=$this->utilityclass->getVillageName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code,$adp->lot_no,$adp->vill_townprt_code)?>' class="form-control input-sm" readonly>

                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Dag Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <input type="text" readonly name="a_dag_no[]" value='<?=$adp->dag_no?>' class="form-control input-sm">
                                </strong>
                            </td>

                            <th>Patta Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <input type="text" readonly name="a_patta_no[]" class="form-control input-sm" value='<?=$adp->patta_no;?>'>
                                </strong>
                            </td>

                        </tr>

                        <tr>
                            <th>Total Additional Land Details</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <strong>
                                    <input type="text" readonly style="text-align: center;" name="a_bigha[]" class="form-control input-sm" value="<?=$adp->bigha?>" >
                                </strong>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" readonly style="text-align: center;" name="a_katha[]" value="<?=$adp->katha?>" class="form-control input-sm" >
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" readonly style="text-align: center;" name="a_lessa[]" class="form-control input-sm" value="<?=$adp->lessa?>" >
                            </td>
                            <?php if((in_array($adp->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" readonly style="text-align: center;" value="<?=$adp->ganda?>" class="form-control input-sm" name="a_ganda[]" >
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" readonly style="text-align: center;" value="<?=$adp->kranti?>" class="form-control input-sm" name="a_kranti[]" >
                                </td>
                            <?php endif ; ?>
                        </tr>


                        <?php $i++ ?>
                    <?php endforeach;  ?>
                </table>
            </div>
        <?php  } ?>


        <?php if($nextKin){ ?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-users"></i>  Family Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <tr>
                        <th>Nominee Name</th>
                        <th>Relation with Applicant</th>
                        <th>Address of Nominee</th>
                        <th>Mobile number</th>
                    </tr>
                    <?php $i=1; foreach($nextKin as $kin): ?>
                        <tr>
                            <td>
                                <input type="text" name="kin_name[]" value="<?=$kin->next_of_kin_name?>" class="form-control">
                            </td>
                            <td>
                                <input type="hidden" name="kin_relation[]" value="<?=$kin->relation_with_kin?>" class="form-control">
                                <input type="text" name="kin_relation_display" value="<?=$this->utilityclass->appRelationbyIDMB2($kin->relation_with_kin)?>" class="form-control">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="<?=$kin->address?>" name="kin_address[]">
                            </td>
                            <td>
                                <input type="text" name="kin_contact_no[]" value="<?=$kin->mobile_no?>" class="form-control">
                            </td>
                        </tr>
                        <?php $i++;?>
                    <?php endforeach;?>
                </table>
            </div>
        <?php } ?>

        <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-file-pdf-o"></i> Supporting Documents
        </h5>
        <div class="tableCard">
            <table class="table table-bordered">
                <?php foreach($document as $d): ?>
                    <tr>
                        <th>
                            <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
         
                            <input type="hidden" name="file_name" value="<?=$d->name;?>">
                            <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                            <input type="hidden" name="file_path" value="<?=$d->path;?>">
                            <input type="hidden" name="file_details" value="<?=$d->file_details?>">

                            <input type="hidden" name="mut_type" value="<?=$app->service_code?>">
                        </th>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
    </div>
</div>

<ul class="list-inline pull-right" style="margin-top: 20px">
    <li>
        <button type="button" class="btn btn-primary next-step">
            <i class="fa fa-check-square-o"> </i>  Save and continue
        </button>
    </li>
</ul>

<!-- add Encroacher modal -->

<div id="addOccModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="close-enc-modal px-4">&times;</span>
        </div>
        <p>
        <div class="container px-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5>Add Occupiers in DAG <strong><span id="dag_label_add_occ"></span></strong></h5>
                </div>
            </div>
            <input type="hidden" id="dist_code" name="dist_code" value="<?=$app->dist_code;?>">
            <input type="hidden" id="subdiv_code" name="subdiv_code" value="<?=$app->subdiv_code;?>">
            <input type="hidden" id="circle_code" name="circle_code" value="<?=$app->cir_code;?>">
            <input type="hidden" id="mouza_code" name="mouza_code" value="<?=$app->mouza_code;?>">
            <input type="hidden" id="lot_no" name="lot_no" value="<?=$app->lot_no;?>">
            <input type="hidden" id="vill_code" name="vill_code" value="<?=$app->village_code;?>">
            <input type="hidden" id="v_uuid" name="v_uuid" value="<?=$app->uuid;?>">
            <input type="hidden" name="v_dag_no" id="v_dag_no" class="form-control">
            <?php foreach ($applicants as $settlement):
                if($settlement->is_applicant == 1):
                    $add_enc_count = 1;
                    // echo "<pre>";
                    // var_dump($settlement);
                ?>

            <div class="alternate_div">
                <hr>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="lb_lm_update_form_en_name[]" id="lb_lm_update_form_en_name" class="form-control" value="<?=$settlement->name_ass?>">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Father Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="lb_lm_update_form_en_father_name[]" id="lb_lm_update_form_en_father_name" class="form-control" value="<?=$settlement->gurdian_name_ass?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Gender</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_gender[]" id="lb_lm_update_form_en_gender" class="form-control">
                            <option value="">Select...</option>
                            <option value="1" <?php if($settlement->gender == '1'){echo 'selected';}?>>Male</option>
                            <option value="2" <?php if($settlement->gender == '2'){echo 'selected';}?>>Female</option>
                            <option value="3" <?php if($settlement->gender == '3'){echo 'selected';}?>>Others</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment From</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" name="lb_lm_update_form_en_from_date[]" id="lb_lm_update_form_en_from_date" class="form-control ymd" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment To</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" name="lb_lm_update_form_en_to_date[]" id="lb_lm_update_form_en_to_date" class="form-control ymd" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless Indigenous</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_landless_indigenuous[]" id="lb_lm_update_form_en_landless_indigenuous" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_landless[]" id="lb_lm_update_form_en_landless" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Caste</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="lb_lm_update_form_en_caste[]" id="lb_lm_update_form_en_caste">
                            <option value="">Select...</option>
                            <?php
                                foreach(json_decode(CASTE) as $add_cast_cat):
                            ?>
                                <option value="<?=$add_cast_cat->CODE?>" <?php if($settlement->caste_category == $add_cast_cat->CODE){echo "selected";}?>><?=$add_cast_cat->NAME?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Erosion effected?</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_erosion[]" id="lb_lm_update_form_en_erosion" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landslide prone area?</label>
                    </div>
                    <div class="col-md-3">
                        <select name="lb_lm_update_form_en_landslide[]" id="lb_lm_update_form_en_landslide" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Type Of Land Use</label>
                    </div>
                    <div class="col-md-3">

                        <select class="form-control" name="lb_lm_update_form_type_of_land_use[]" id="lb_lm_update_form_type_of_land_use">
                            <option value="">Select...</option>
                            <?php
                                foreach(json_decode(LB_ENC_TYPE_OF_LAND_USE) as $land_use):
                            ?>
                                <option value="<?=$land_use->CODE?>"><?=$land_use->NAME?></option>
                            <?php
                                endforeach;
                            ?>

                        </select>

                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Type</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="lb_lm_update_form_type_of_encroacher[]" id="lb_lm_update_form_type_of_encroacher">
                            <option value="">Select...</option>
                        <?php
                            foreach(json_decode(TYPE_OF_ENCROACHER) as $enc_type):
                        ?>
                            <option value="<?=$enc_type->CODE?>"><?=$enc_type->NAME?></option>
                        <?php
                            endforeach;
                        ?>
                        </select>

                    </div>
                </div>
                <hr>
                <div class="row justify-content-center mt-3">
                    <button type="button" onclick="addEncSubmit()" class="col-md-3 btn btn-primary">Submit</button>
                </div>
            </div>

            <?php endif; endforeach;?>
        </div>
        </p>
    </div>

</div>

<!-- Encroacher modal -->

<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="close px-4">&times;</span>
        </div>
        <p>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5>AVAILABLE OCCUPIERS IN DAG <strong><span id="dag_label"></span></strong></h5>
            </div>
        </div>

        <table class="table table-bordered datatable" id='datatable'>
            <thead>
            <th>#</th>
            <th>
                Occupier's Name
            </th>
            <th>Father's Name</th>
            <th>
                Occupied From
            </th>
            <th>Type of land use</th>
            <th>
                Action
                <button type="button" class="search_button btn btn-sm btn-success form-control">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    Search
                </button>

            </th>
            </thead>
            <tbody>

            </tbody>
        </table>
        </p>
    </div>

</div>
<!-- Encroacher modal -->

<!-- Edit Encroacher modal -->

<div id="editOccModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="row text-right">
            <span class="edit-enc-close px-4">&times;</span>
        </div>
        <p>
        <div class="container px-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5>Add Occupiers in DAG <strong><span id="dag_label_add_occ"></span></strong></h5>
                </div>
            </div>

            <input type="hidden" id = "edit_enc_application_no">
            <input type="hidden" id = "edit_enc_land_bank_details_id">
            <input type="hidden" id = "edit_enc_id_land_bank">
            <input type="hidden" id = "enc_uuid">
            <input type="hidden" id = "enc_dag_no">

            <?php
                $add_enc_count = 1;
            ?>

            <div class="alternate_div">
                <hr>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="edit_lb_lm_update_form_en_name" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroacher Father Name</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="edit_lb_lm_update_form_en_father_name" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Gender</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_gender" class="form-control">
                            <option value="">Select...</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Others</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment From</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" id="edit_lb_lm_update_form_en_from_date" class="form-control ymd" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Encroachment To</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="yyyy-mm-dd" id="edit_lb_lm_update_form_en_to_date" class="form-control ymd" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless Indigenous</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_landless_indigenuous" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landless</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_landless" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Caste</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_lb_lm_update_form_en_caste">
                            <option value="">Select...</option>
                            <?php
                                foreach(json_decode(CASTE) as $add_cast_cat):
                            ?>
                                <option value="<?=$add_cast_cat->CODE?>"><?=$add_cast_cat->NAME?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Erosion effected?</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_erosion" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Landslide prone area?</label>
                    </div>
                    <div class="col-md-3">
                        <select id="edit_lb_lm_update_form_en_landslide" class="form-control">
                            <option value="">Select...</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Type Of Land Use</label>
                    </div>
                    <div class="col-md-3">

                        <select class="form-control" id="edit_lb_lm_update_form_type_of_land_use">
                            <option value="">Select...</option>
                            <?php
                                foreach(json_decode(LB_ENC_TYPE_OF_LAND_USE) as $land_use):
                            ?>
                                <option value="<?=$land_use->CODE?>"><?=$land_use->NAME?></option>
                            <?php
                                endforeach;
                            ?>

                        </select>

                    </div>
                    <div class="col-md-3">
                        <label for=""><?=$add_enc_count++?>. Type</label>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="edit_lb_lm_update_form_type_of_encroacher">
                            <option value="">Select...</option>
                        <?php
                            foreach(json_decode(TYPE_OF_ENCROACHER) as $enc_type):
                        ?>
                            <option value="<?=$enc_type->CODE?>"><?=$enc_type->NAME?></option>
                        <?php
                            endforeach;
                        ?>
                        </select>

                    </div>
                </div>
                <hr>
                <div class="row justify-content-center mt-3">
                    <button type="button" onclick="updateEncDetails()" class="col-md-3 btn btn-primary">Update</button>
                </div>
            </div>

        </div>
        </p>
    </div>

</div>


<!-- css for datatable -->
<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<script>
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: false

        });
    }
</script>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    function encroacherModal(dag_no, riotee_id){

        modal.style.display = "block";

        $("#dag_label").html(dag_no);

        var uuid = $('#uuid').val();
        var base_url = "<?php echo base_url();?>";

        $('#datatable thead th:nth-of-type(2)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" value="" class="input_search form-control form-control-sm" placeholder="Search occupier" data-column-index="1" />');
        });

        $('#datatable thead th:nth-of-type(4)').each(function () {
            var title = $(this).text();
            $(this).html(title+' <input type="text" value="" class="input_search form-control form-control-sm" placeholder="Search date" data-column-index="3" />');
        });

        var table = $('#datatable').DataTable({
            // "scrollX": true,
            'pageLength':10,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language': {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax':{
                url: base_url+'index.php/Basundhara2/encroacherPagination',
                type:'POST',
                data: {
                    uuid:uuid,
                    dag_no:dag_no,
                    riotee_id:riotee_id
                },
                deferLoading: 57,
            },


            order: [[2, 'asc']],
            columnDefs: [{
                targets: "_all",
                orderable: false,
                "className": "dt-center", "targets":[ 0, 3, 4, 5],
            }]

        });

        // on keypress search
        // table.columns().every(function () {
        //     var table = this;
        //     $('input', this.header()).on('keyup change', function () {
        //         if (table.search() !== this.value) {
        //                 table.search(this.value).draw();
        //         }
        //     });
        // });

        // button search
        $('.search_button').on('click', function () {
            $('table thead tr th .input_search').each(function(){
                table.column($(this).data('columnIndex')).search(this.value);
            });
            table.draw();
        });

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            table.destroy();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                table.destroy();
            }
        }

    }

    // change encroacher name to selected encroacher
    function changeEncroacher(enc_id,riotee_id){
        var enc_name = $("#enc_name"+enc_id).val();
        var enc_father = $("#enc_fathers_name"+enc_id).val();
        var enc_from = $("#end_enc_from"+enc_id).val();
        var enc_land_type = $("#enc_land_type"+enc_id).val();

        $("#enc_id"+riotee_id).val(enc_id);
        $("#enc_name"+riotee_id).val(enc_name);
        $("#enc_gur_name"+riotee_id).val(enc_father);
        $("#enc_period_possession"+riotee_id).val(enc_from);

        showSuccessMessage('Encroacher changed successfully...');
        modal.style.display = "none";
        $('#datatable').DataTable().destroy();
    }


</script>

<script>

    <?php
    if((in_array($app->dist_code, json_decode(BARAK_VALLEY)))){
    ?>
    function totalAreaCal(){
        $('#totaldue').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('#finalamount').val('');
        $('.totalamount').val('');
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseFloat($("#mbigha"+i).val());
            var mkatha = parseFloat($("#mkatha"+i).val());
            var mlessa = parseFloat($("#mlessa"+i).val());
            var mganda = parseFloat($("#mganda"+i).val());

            var total_area = total_area + ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
        }

        var bigha_r = Math.floor(total_area / 6400);
        var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
        var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
        var ganda_r = total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);
        $("#total_applied_home_ganda").val(ganda_r);
    }

    function agriArea(){
        $('#totaldue').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('#finalamount').val('');
        $('.totalamount').val('');
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
            var mkatha_agri = parseFloat($("#agri_katha"+i).val());
            var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
            var mganda_agri = parseFloat($("#agri_ganda"+i).val());

            var total_agri_area = total_agri_area + ((mbigha_agri * 6400) + (mkatha_agri * 320) + (mlessa_agri * 20) + mganda_agri);
        }

        var bigha_agri = Math.floor(total_agri_area / 6400);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 6400) / 320);
        var lessa_agri = Math.floor((total_agri_area - (bigha_agri * 6400) - (katha_agri * 320)) / 20);
        var ganda_agri = total_agri_area - bigha_agri * 6400 - katha_agri * 320 - lessa_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
        $("#total_applied_agri_ganda").val(ganda_agri);
    }

    function fisheryArea(){
        // for agri
        var bigha_fish = 0;
        var katha_fish = 0;
        var lessa_fish = 0;
        var length_fish = <?=$total_area_fbigha?>;
        var total_fish_area = 0;
        for(i=1; i<length_fish; i++){
            var mbigha_fish = parseFloat($("#fbigha"+i).val());
            var mkatha_fish = parseFloat($("#fkatha"+i).val());
            var mlessa_fish = parseFloat($("#flessa"+i).val());
            var mganda_fish = parseFloat($("#fganda"+i).val());

            var total_fish_area = total_fish_area + ((mbigha_fish * 6400) + (mkatha_fish * 320) + (mlessa_fish * 20) + mganda_fish);
        }

        var bigha_fish = Math.floor(total_fish_area / 6400);
        var katha_fish = Math.floor((total_fish_area - bigha_fish * 6400) / 320);
        var lessa_fish = Math.floor((total_fish_area - (bigha_fish * 6400) - (katha_fish * 320)) / 20);
        var ganda_fish = total_fish_area - bigha_fish * 6400 - katha_fish * 320 - lessa_fish * 20;

        $("#total_applied_fbigha").val(bigha_fish);
        $("#total_applied_fkatha").val(katha_fish);
        $("#total_applied_flessa").val(lessa_fish);
        $("#total_applied_fganda").val(ganda_fish);
    }

    <?php
    }else{?>
    function totalAreaCal(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark_text').text('');
        $('#lm_remark').val('');
        $('#finalamount').val('');
        $('.totalamount').val('');
        


        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseFloat($("#mbigha"+i).val());
            var mkatha = parseFloat($("#mkatha"+i).val());
            var mlessa = parseFloat($("#mlessa"+i).val());
            var total_area = total_area + ((mbigha * 100) + (mkatha * 20) + mlessa);
        }

        var bigha_r = Math.floor(total_area / 100);
        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);

    }

    function agriArea(){
        $('#totaldue').val('');
        $('#validationcheck').val('');
        $('#lm_remark').val('');
        $('#lm_remark_text').text('');
        $('#finalamount').val('');
        $('.totalamount').val('');
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseFloat($("#agri_bigha"+i).val());
            var mkatha_agri = parseFloat($("#agri_katha"+i).val());
            var mlessa_agri = parseFloat($("#agri_lessa"+i).val());
            var total_agri_area = total_agri_area + ((mbigha_agri * 100) + (mkatha_agri * 20) + mlessa_agri);
        }
        // alert(total_agri_area);
        var bigha_agri = Math.floor(total_agri_area / 100);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 100) / 20);
        var lessa_agri = total_agri_area - bigha_agri * 100 - katha_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
    }

    function fisheryArea(){
        // for agri
        var bigha_fish = 0;
        var katha_fish = 0;
        var lessa_fish = 0;
        var length_fish = <?=$total_area_fbigha?>;
        var total_fish_area = 0;
        for(i=1; i<length_fish; i++){
            var mbigha_fish = parseFloat($("#fbigha"+i).val());
            var mkatha_fish = parseFloat($("#fkatha"+i).val());
            var mlessa_fish = parseFloat($("#flessa"+i).val());
            var total_fish_area = total_fish_area + ((mbigha_fish * 100) + (mkatha_fish * 20) + mlessa_fish);
        }
        // alert(total_fish_area);
        var bigha_fish = Math.floor(total_fish_area / 100);
        var katha_fish = Math.floor((total_fish_area - bigha_fish * 100) / 20);
        var lessa_fish = total_fish_area - bigha_fish * 100 - katha_fish * 20;

        $("#total_applied_fbigha").val(bigha_fish);
        $("#total_applied_fkatha").val(katha_fish);
        $("#total_applied_flessa").val(lessa_fish);
    }

    <?php }?>


    // jS Masud Reza & Muzammil Da

    $(document).ready(function(){

        // // Add new element
        $(".add").click(function(){

            // Finding total number of elements added
            var total_element = $(".element").length;

            // last <div> with element class id
            var lastid = $(".element:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 35;
            // Check total number elements
            if(total_element < max ){
                // Adding new div container after last occurance of element class
                $(".element:last").after("<div class='element' id='div_"+ nextindex +"'></div>");

                // Adding element to <div>
                $("#div_" + nextindex).append("<table class='table table-bordered' id='applicantrow_"+ nextindex +"'> <tr> <th rowspan='5' style='vertical-align : middle;text-align:center;'>1</th> <th>Name of the applicant</th> <td> <input type='text' placeholder='Enter name' name='pdar_name2[]' required class='form-control input-sm'> </td> <th>Guardian name</th> <td> <input placeholder='Enter guardian' type='text' name='pdar_guardian2[]' required class='form-control input-sm' > </td> <th>DOB</th><td><input type='date' class='form-control' name='dob2[]'></td> </tr> <tr> <th>Relation</th> <td> <select name='pdar_rel_guar2[]' id='pdar_rel_guar"+ nextindex +"' class='form-control' required> <option value='1' >Mother</option> <option value='2' selected>Father</option> <option value='3' >Husband</option> <option value='4' >Wife</option> <option value='5' >Guardian</option> <option value='6' >Supdt.Mother</option> <option value='7' >Guardian</option> </select> </td> <th>Gender</th> <td> <select name='pdar_gender2[]' id='pdar_gender"+ nextindex +"' class='form-control' > <option value='1' selected>Male</option> <option value='2' >Female</option> <option value='3' >Others</option> </select> </td> <th>Mobile</th> <td> <input type='text' placeholder='Enter mobile no' name='pdar_mobile2[]' class='form-control input-sm' > </td> </tr> <tr> <th> Permanent address </th> <td colspan='2'> <input type='text' placeholder='Enter permanent address' name='pdar_add12[]' class='form-control input-sm'> </td> <th>Present address</th> <td colspan='2'> <input placeholder='Enter present address' type='text' name='pdar_add22[]' class='form-control input-sm' > </td> </tr><tr><td><span id='remove_" + nextindex + "' class='remove'><i class='fa fa-trash-o' style='font-size:32px;color:red'></i></span></td></tr> </table>&nbsp;");

            }

        });

        // Remove element
        $('.container').on('click','.remove',function(){

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
            // Remove <div> with id
            $("#div_" + deleteindex).remove();
        });

        $(document).on('click', '.delete', function()
        {
            id = $(this).attr('id');
            if($('#del_fpart_appl').val()=='')
            {
                $('#del_fpart_appl').val(id);
            }
            else
            {
                $('#del_fpart_appl').val($('#del_fpart_appl').val()+', '+id);
            }
        });


        // Remove element
        $('.delete').on('click',function(){
            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
            // Remove <div> with id
            $("#applicantrow_" + deleteindex).remove();
        });


    });
</script>

<!-- additional errors check  -->
<script>
    $('#additionalErrors').on('click',function(){
        $(this).next('#additional_errors_collapse').slideToggle();
    });

</script>

<script>
    function addEncroacher(dag_no, riotee_id, total_bigha, total_katha, total_lessa, total_ganda, total_kranti){

        var modal = document.getElementById("addOccModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-enc-modal")[0];
        modal.style.display = "block";

        $("#dag_label_add_occ").html(dag_no);
        $("#v_dag_no").val(dag_no);

        $('#lb_lm_update_form_en_area_b').val(total_bigha);
        $('#lb_lm_update_form_en_area_k').val(total_katha);
        $('#lb_lm_update_form_en_area_l').val(total_lessa);
        $('#lb_lm_update_form_en_area_g').val(total_ganda);
        $('#lb_lm_update_form_en_area_kr').val(total_kranti);
        // When the user clicks on <span> (x), close the modal

        span.onclick = function() {
            modal.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                // table.destroy();
            }
        }

    }

    function addEncSubmit(){
        var modal = document.getElementById("addOccModal");

        //input validation starts here
        if($('#dist_code').val() == ''){
            alert('dist_code field is required !');
            return false;
        }
        if($('#subdiv_code').val() == ''){
            alert('subdiv_code field is required !');
            return false;
        }
        if($('#circle_code').val() == ''){
            alert('circle_code field is required !');
            return false;
        }
        if($('#mouza_code').val() == ''){
            alert('mouza_code field is required !');
            return false;
        }
        if($('#lot_no').val() == ''){
            alert('lot_no field is required !');
            return false;
        }
        if($('#vill_code').val() == ''){
            alert('vill_code field is required !');
            return false;
        }
        if($('#v_uuid').val() == ''){
            alert('v_uuid field is required !');
            return false;
        }
        if($('#v_dag_no').val() == ''){
            alert('Dag No field is required !');
            $('#v_dag_no').focus();
            return false;
        }
        if($('#v_nature_of_reservation').val() == ''){
            alert('Type of Govt. land field is required !');
            $('#v_nature_of_reservation').focus();
            return false;
        }
        if($('#v_whether_encroached').val() == ''){
            alert('Whether encroached field is required !');
            $('#v_whether_encroached').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_area_b').val() == ''){
            alert('Bigha field is required !');
            $('#lb_lm_update_form_en_area_b').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_area_k').val() == ''){
            alert('Katha field is required !');
            $('#lb_lm_update_form_en_area_k').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_area_l').val() == ''){
            alert('Lessa field is required !');
            $('#lb_lm_update_form_en_area_l').focus();
            return false;
        }
        <?php
        if ((in_array($app->dist_code, json_decode(BARAK_VALLEY)))){
        ?>
        if($('#lb_lm_update_form_en_area_g').val() == ''){
            alert('Ganda field is required !');
            $('#lb_lm_update_form_en_area_g').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_area_kr').val() == ''){
            alert('Kranti field is required !');
            $('#lb_lm_update_form_en_area_kr').focus();
            return false;
        }
        <?php } ?>

        if($('#v_no_of_encroachers_lm_update_form').val() == ''){
            alert('No of encroacher field is required !');
            $('#v_no_of_encroachers_lm_update_form').focus();
            return false;
        }
        if($('#v_longitude').val() == ''){
            alert('Longitude field is required !');
            $('#v_longitude').focus();
            return false;
        }
        if($('#v_latitude').val() == ''){
            alert('Latitude field is required !');
            $('#v_latitude').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_name').val() == ''){
            alert('Encroacher Name field is required !');
            $('#lb_lm_update_form_en_name').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_father_name').val() == ''){
            alert('Encroacher father field is required !');
            $('#lb_lm_update_form_en_father_name').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_gender').val() == ''){
            alert('Gender field is required !');
            $('#lb_lm_update_form_en_gender').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_from_date').val() == ''){
            alert('Encroachment from field is required !');
            $('#lb_lm_update_form_en_from_date').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_to_date').val() == ''){
            alert('Encroachment field is required !');
            $('#lb_lm_update_form_en_to_date').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_landless_indigenuous').val() == ''){
            alert('Landless Indigenous field is required !');
            $('#lb_lm_update_form_en_landless_indigenuous').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_landless').val() == ''){
            alert('Landless field is required !');
            $('#lb_lm_update_form_en_landless').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_caste').val() == ''){
            alert('Caste field is required !');
            $('#lb_lm_update_form_en_caste').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_erosion').val() == ''){
            alert('Erosion field is required !');
            $('#lb_lm_update_form_en_erosion').focus();
            return false;
        }
        if($('#lb_lm_update_form_en_landslide').val() == ''){
            alert('Landslide field is required !');
            $('#lb_lm_update_form_en_landslide').focus();
            return false;
        }
        if($('#lb_lm_update_form_type_of_land_use').val() == ''){
            alert('Type Of Land Use field is required !');
            $('#lb_lm_update_form_type_of_land_use').focus();
            return false;
        }
        if($('#lb_lm_update_form_type_of_encroacher').val() == ''){
            alert('Type field is required !');
            $('#lb_lm_update_form_type_of_encroacher').focus();
            return false;
        }
        //input validation ends here

        var base_url = "<?php echo base_url();?>";
        <?php
            if ((in_array($app->dist_code, json_decode(BARAK_VALLEY)))){
            ?>
                var ganda = $('#lb_lm_update_form_en_area_g').val();
                var kranti = $('#lb_lm_update_form_en_area_kr').val();
        <?php
            }else{
         ?>
                var ganda = 0;
                var kranti = 0;
        <?php
            }
        ?>

        var postData = {
                'application_no' : "<?=$app->application_no;?>",
                'dist_code' : $('#dist_code').val(),
                'subdiv_code' : $('#subdiv_code').val(),
                'circle_code' : $('#circle_code').val(),
                'mouza_code' : $('#mouza_code').val(),
                'lot_no' : $('#lot_no').val(),
                'vill_code' : $('#vill_code').val(),
                'v_uuid' : $('#v_uuid').val(),
                'v_dag_no' : $('#v_dag_no').val(),
                'v_nature_of_reservation' : $('#v_nature_of_reservation').val(),
                'v_whether_encroached' : $('#v_whether_encroached').val(),
                'lb_lm_update_form_en_area_b' : $('#lb_lm_update_form_en_area_b').val(),
                'lb_lm_update_form_en_area_k' : $('#lb_lm_update_form_en_area_k').val(),
                'lb_lm_update_form_en_area_l' : $('#lb_lm_update_form_en_area_l').val(),
                'lb_lm_update_form_en_area_g' : ganda,
                'lb_lm_update_form_en_area_kr' : kranti,
                'v_no_of_encroachers_lm_update_form' : $('#v_no_of_encroachers_lm_update_form').val(),
                'v_longitude' : $('#v_longitude').val(),
                'v_latitude' : $('#v_latitude').val(),
                'lb_lm_update_form_en_name' : $('#lb_lm_update_form_en_name').val(),
                'lb_lm_update_form_en_father_name' : $('#lb_lm_update_form_en_father_name').val(),
                'lb_lm_update_form_en_gender' : $('#lb_lm_update_form_en_gender').val(),
                'lb_lm_update_form_en_from_date' : $('#lb_lm_update_form_en_from_date').val(),
                'lb_lm_update_form_en_to_date' : $('#lb_lm_update_form_en_to_date').val(),
                'lb_lm_update_form_en_landless_indigenuous' : $('#lb_lm_update_form_en_landless_indigenuous').val(),
                'lb_lm_update_form_en_landless' : $('#lb_lm_update_form_en_landless').val(),
                'lb_lm_update_form_en_caste' : $('#lb_lm_update_form_en_caste').val(),
                'lb_lm_update_form_en_erosion' : $('#lb_lm_update_form_en_erosion').val(),
                'lb_lm_update_form_en_landslide' : $('#lb_lm_update_form_en_landslide').val(),
                'lb_lm_update_form_type_of_land_use' : $('#lb_lm_update_form_type_of_land_use').val(),
                'lb_lm_update_form_type_of_encroacher' : $('#lb_lm_update_form_type_of_encroacher').val(),
            };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: base_url+'index.php/SettlementCommon/landBankInsert',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType == 2){
                    showErrorMessage(arr.msg);
                }else{
                    modal.style.display = "none";
                    showSuccessMessage(arr.msg);
                    window.location.reload();
                }
            }
        });

    }

</script>


<script>
    var base_url = "<?php echo base_url();?>";

    function editEncroacher(dag_no, riotee_id, enc_id, land_bank_details_id){

        var modal = document.getElementById("editOccModal");
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal
        var span_close = document.getElementsByClassName("edit-enc-close")[0];
        modal.style.display = "block";

        var uuid = $('#uuid').val();
        var application_no = $('#application_no').val();


        $('#enc_application_no').val(application_no);
        $('#enc_uuid').val(uuid);
        $('#enc_dag_no').val(dag_no);

        var postData = {
                'enc_id' : enc_id,
                'dag_no' : dag_no,
                'uuid' : uuid,
                'application_no' : application_no
            };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: base_url+'index.php/SettlementCommon/fetchLandBankEncData',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);

                $('#edit_enc_id_land_bank').val(arr.id);
                $('#edit_enc_application_no').val(arr.application_no);
                $('#edit_enc_land_bank_details_id').val(arr.land_bank_details_id);
                $('#edit_lb_lm_update_form_en_name').val(arr.name);
                $('#edit_lb_lm_update_form_en_father_name').val(arr.fathers_name);

                $("#edit_lb_lm_update_form_en_gender option[value="+arr.gender+"]").prop('selected', 'selected');            

                $('#edit_lb_lm_update_form_en_from_date').val(arr.encroachment_from);
                $('#edit_lb_lm_update_form_en_to_date').val(arr.encroachment_to);
                $('#edit_lb_lm_update_form_en_landless_indigenuous').val(arr.landless_indigenous);
                $('#edit_lb_lm_update_form_en_landless').val(arr.landless);
                // $('#lb_lm_update_form_en_caste').val(arr.caste);

                $("#edit_lb_lm_update_form_en_caste option[value="+arr.caste+"]").prop('selected', 'selected');  

                $('#edit_lb_lm_update_form_en_erosion').val(arr.erosion);
                $('#edit_lb_lm_update_form_en_landslide').val(arr.landslide);
                $('#edit_lb_lm_update_form_type_of_land_use').val(arr.type_of_land_use);
                $('#edit_lb_lm_update_form_type_of_encroacher').val(arr.type_of_encroacher);
                
                $.unblockUI();
            }
        });

        span_close.onclick = function() {
            modal.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                // table.destroy();
            }
        }
    }

    function updateEncDetails(){
        var modal = document.getElementById("editOccModal");

        var enc_uuid = $.trim($('#enc_uuid').val());
        var enc_dag_no = $.trim($('#enc_dag_no').val());
        // var enc_case_no  = $.trim($('#enc_case_no').val());    
        var enc_id_land_bank = $.trim($('#edit_enc_id_land_bank').val());           
        var enc_application_no =  $.trim($('#edit_enc_application_no').val());
        var enc_land_bank_details_id =  $.trim($('#edit_enc_land_bank_details_id').val());
        var lb_lm_update_form_en_name =  $.trim($('#edit_lb_lm_update_form_en_name').val());
        var lb_lm_update_form_en_father_name =  $.trim($('#edit_lb_lm_update_form_en_father_name').val());
        var lb_lm_update_form_en_gender =  $.trim($("#edit_lb_lm_update_form_en_gender").val());            
        var lb_lm_update_form_en_from_date =  $.trim($('#edit_lb_lm_update_form_en_from_date').val());
        var lb_lm_update_form_en_to_date =  $.trim($('#edit_lb_lm_update_form_en_to_date').val());
        var lb_lm_update_form_en_landless_indigenuous =  $.trim($('#edit_lb_lm_update_form_en_landless_indigenuous').val());
        var lb_lm_update_form_en_landless =  $.trim($('#edit_lb_lm_update_form_en_landless').val());
        var lb_lm_update_form_en_caste =  $.trim($("#edit_lb_lm_update_form_en_caste").val());  
        var lb_lm_update_form_en_erosion =  $.trim($('#edit_lb_lm_update_form_en_erosion').val());
        var lb_lm_update_form_en_landslide =  $.trim($('#edit_lb_lm_update_form_en_landslide').val());
        var lb_lm_update_form_type_of_land_use =  $.trim($('#edit_lb_lm_update_form_type_of_land_use').val());
        var lb_lm_update_form_type_of_encroacher =  $.trim($('#edit_lb_lm_update_form_type_of_encroacher').val());
       
        if(enc_uuid == ''){
            alert("enc_uuid field is required !");
            $('#enc_uuid').focus();
            return false;
        }
        if(enc_dag_no == ''){
            alert("enc_dag_no field is required !");
            $('#enc_uuid').focus();
            return false;
        }
        if(enc_id_land_bank == ''){
            alert('Enc ID field is required !');
            $('#enc_application_no').focus();
            return false;
        }
        if(enc_application_no == ''){
            alert('Application no field is required !');
            $('#enc_application_no').focus();
            return false;
        }
        if(enc_land_bank_details_id == ''){
            alert('Encroacher land bank details ID is required !');
            $('#enc_land_bank_details_id').focus();
            return false;
        }
        if(lb_lm_update_form_en_name == ''){
            alert('Encroacher Name is required !');
            $('#lb_lm_update_form_en_name').focus();
            return false;
        }
        if(lb_lm_update_form_en_father_name == ''){
            alert('Father name field is required !');
            $('#lb_lm_update_form_en_father_name').focus();
            return false;
        }
        if(lb_lm_update_form_en_gender == ''){
            alert('Gender is required !');
            $('#lb_lm_update_form_en_gender').focus();
            return false;
        }
        if(lb_lm_update_form_en_from_date == ''){
            alert('From date is required !');
            $('#lb_lm_update_form_en_from_date').focus();
            return false;
        }
        if(lb_lm_update_form_en_to_date == ''){
            alert('To Date is required !');
            $('#lb_lm_update_form_en_to_date').focus();
            return false;
        }
        if(lb_lm_update_form_en_landless_indigenuous == ''){
            alert('Landless Indigenous is required !');
            $('#lb_lm_update_form_en_landless_indigenuous').focus();
            return false;
        }
        if(lb_lm_update_form_en_landless == ''){
            alert('Landless is required !');
            $('#lb_lm_update_form_en_landless').focus();
            return false;
        }
        if(lb_lm_update_form_en_caste == ''){
            alert('Caste is required !');
            $('#lb_lm_update_form_en_caste').focus();
            return false;
        }
        if(lb_lm_update_form_en_erosion == ''){
            alert('Erosion effected is required !');
            $('#lb_lm_update_form_en_erosion').focus();
            return false;
        }
        if(lb_lm_update_form_en_landslide == ''){
            alert('Landslide prone area field is required !');
            $('#lb_lm_update_form_en_landslide').focus();
            return false;
        }
        if(lb_lm_update_form_type_of_land_use == ''){
            alert('Type Of Land Use field required !');
            $('#lb_lm_update_form_type_of_land_use').focus();
            return false;
        }
        if(lb_lm_update_form_type_of_encroacher == ''){
            alert('Encroacher type field is required !');
            $('#lb_lm_update_form_type_of_encroacher').focus();
            return false;
        }

        var postData = {
            'enc_uuid' : enc_uuid,
            'enc_dag_no' : enc_dag_no,
            // 'enc_case_no' : enc_case_no,
            'encroacher_id' : enc_id_land_bank,
            'enc_application_no' : enc_application_no,
            'enc_land_bank_details_id' : enc_land_bank_details_id,
            'lb_lm_update_form_en_name' : lb_lm_update_form_en_name,
            'lb_lm_update_form_en_father_name' : lb_lm_update_form_en_father_name,
            'lb_lm_update_form_en_gender' : lb_lm_update_form_en_gender,
            'lb_lm_update_form_en_from_date' : lb_lm_update_form_en_from_date,
            'lb_lm_update_form_en_to_date' : lb_lm_update_form_en_to_date,
            'lb_lm_update_form_en_landless_indigenuous' : lb_lm_update_form_en_landless_indigenuous,
            'lb_lm_update_form_en_landless' : lb_lm_update_form_en_landless,
            'lb_lm_update_form_en_caste' : lb_lm_update_form_en_caste,
            'lb_lm_update_form_en_erosion' : lb_lm_update_form_en_erosion,
            'lb_lm_update_form_en_landslide' : lb_lm_update_form_en_landslide,
            'lb_lm_update_form_type_of_land_use' : lb_lm_update_form_type_of_land_use,
            'lb_lm_update_form_type_of_encroacher' : lb_lm_update_form_type_of_encroacher,
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: base_url+'index.php/SettlementCommon/updateLandBankEncData',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 2){
                    showErrorMessage(arr.msg);
                }
                else{
                    modal.style.display = "none";
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }
            }
        });

    }

</script>
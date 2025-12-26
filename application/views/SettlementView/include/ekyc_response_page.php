<style type="text/css">
    .title {
        /*font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: red;
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;*/
        color:red;
    }
    .ekyctableCard {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 15px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        padding-bottom: -1px!important;
        margin-bottom: 15px!important;
        border: 1px solid red;
        border-radius: 4px;
    }
    .ekycth {
        color: red;
    }
</style>


<?php 

// var_dump($eKyc_data);die;

if(isset($message))
{
    echo "<span style='color:red; font-size: 18px;'>".$message."</span>";
}


if(ENABLE_MODIFY_MAIN_APPLICANT==1 && (isset($eKyc_data))) { 

// echo "<pre>";

    $auth_response = json_decode($eKyc_data);

    // echo "<pre>";
    // var_dump($auth_response);





    // if(isset($auth_response->type))
    // {
    //     $ekyc_verify = $auth_response->type;
    //     if($auth_response->gender == 'M')
    //     {
    //         $gender = 'Male';
    //     }
    //     else if($auth_response->gender == 'F')
    //     {
    //         $gender = 'Female';
    //     }
    //     else 
    //     {
    //         $gender = 'Other';
    //     }
    // }
    // else if(isset($auth_response->ekyc_type))
    // {
    //     $ekyc_verify = $auth_response->type;
    // }


?>

    <h5 class="title">
        <i class="fa fa-check"></i> eKyc response of <?=$auth_response->type?> after verification
    </h5>
    <div class="ekyctableCard">
        <table class="table table-bordered">

            <!-- ============== AADHAAR RESPONSE STARTS HERE -->
            <?php if(isset($auth_response->type) && $auth_response->type == 'AADHAAR') { ?>

                <tr>
                    <th class="ekycth">eKyc Type</th>
                    <td>
                        <input type="text" name="ekyc_pdar_type" id="ekyc_pdar_type" readonly value="<?=$auth_response->type?>" class="form-control input-sm">
                    </td>
                    <th class="ekycth">Applicant Name (Eng)</th>
                    <td>
                        <input type="text" name="ekyc_pdar_name" id="ekyc_pdar_name" readonly value="<?=$auth_response->name_eng?>" class="form-control input-sm">
                    </td>                
                </tr>
                <tr>
                    <th class="ekycth">Guardian Name(Eng)</th>
                    <td>
                        <input type="text" name="ekyc_pdar_guardian" id="ekyc_pdar_guardian" readonly value="<?=$auth_response->f_name?>" class="form-control input-sm">
                    </td>
                    <th class="ekycth">Date of Birth</th>
                    <td>
                        <input type="text" autocomplete="off" placeholder="yyyy-mm-dd"
                        class="ekyc_dob form-control" id="ekyc_dob" name="ekyc_dob" readonly value="<?=$auth_response->dob?>">
                    </td>                
                </tr>
                <tr>
                    <th class="ekycth">Gender</th>
                    <td>
                        <input type="text" name="ekyc_gender" id="ekyc_gender" class="form-control" value="<?=$auth_response->gender?>" readonly>
                    </td>
                    <th class="ekycth">Present Address</th>
                    <td> 
                        <input type="text" name="ekyc_address" id="ekyc_address" readonly class="form-control" value="<?=$auth_response->address?>" readonly>
                    </td>
                </tr>
                <tr>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="ekyc_appl_asm" id="ekyc_appl_asm" 
                        class="form-control" value="" autofocus>
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td> 
                        <input type="text" name="ekyc_guar_appl_asm" id="ekyc_guar_appl_asm" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <th>Marital Status</th>
                    <td>
                        <select class="form-control" name="ekyc_marital_status" id="ekyc_marital_status">
                            <option value="">-- Select Marital Status --</option>
                            <?php foreach(json_decode(MARITAL_STATUS_NEW_APPL) as $r) { ?>
                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <th>Permanent Address</th>
                    <td> 
                        <input type="text" name="ekyc_per_add" id="ekyc_per_add" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>
                        <input type="text" name="ekyc_mobile" id="ekyc_mobile" maxlength="10" 
                        class="form-control" value=""
                        oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                    </td>
                    <th>Relation with guardian</th>
                    <td> 
                        <select class="form-control" name="ekyc_relation" id="ekyc_relation">
                            <option value="">-- Select Relation --</option>
                            <?php foreach(json_decode(RELATION_NEW_APPL) as $r) { ?>
                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            <?php } ?>
            <!-- ============== AADHAAR RESPONSE ENDS HERE -->


            <!-- ============== PAN/DL RESPONSE STARTS HERE -->
            <?php if(isset($auth_response->ekyc_type) && ($auth_response->ekyc_type == 'PAN' || $auth_response->ekyc_type == 'DL')) { 

                if($auth_response->ekyc_type == 'DL')
                {
                    $dob=$auth_response->dob;
                    $readonly = 'readonly';
                }
                else
                {
                    $dob='';
                    $readonly = '';
                }
            ?>

                <tr>
                    <th class="ekycth">eKyc Type</th>
                    <td>
                        <input type="text" name="ekyc_pdar_type" id="ekyc_pdar_type" readonly value="<?=$auth_response->ekyc_type?>" class="form-control input-sm">
                    </td>
                    <th class="ekycth">Applicant Name (Eng)</th>
                    <td>
                        <input type="text" name="ekyc_pdar_name" id="ekyc_pdar_name" readonly value="<?=$auth_response->name_eng?>" class="form-control input-sm">
                    </td>                
                </tr>            
                <tr>
                    <th>Guardian Name(Eng)</th>
                    <td>
                        <input type="text" name="ekyc_pdar_guardian" id="ekyc_pdar_guardian" value="" class="form-control input-sm" autofocus>
                    </td>
                    <th>Date of Birth</th>
                    <td>
                        <input type="text" autocomplete="off" placeholder="yyyy-mm-dd"
                                   class="ekyc_dob form-control date" id="popup2Datepicker" name="ekyc_dob" <?=$readonly?> value="<?=$dob?>">
                    </td>                
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>
                        <select class="form-control" name="ekyc_gender" id="ekyc_gender">
                            <option value="">-- Select Gender --</option>
                            <?php foreach(json_decode(GENDER_NEW_APPL) as $r) { ?>
                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <th>Present Address</th>
                    <td> 
                        <input type="text" name="ekyc_address" id="ekyc_address" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <th>Applicant Name (Assamese)</th>
                    <td>
                        <input type="text" name="ekyc_appl_asm" id="ekyc_appl_asm" 
                        class="form-control" value="উৎপল">
                    </td>
                    <th>Guardian Name (Assamese)</th>
                    <td> 
                        <input type="text" name="ekyc_guar_appl_asm" id="ekyc_guar_appl_asm" class="form-control" value="উৎপল">
                    </td>
                </tr>
                <tr>
                    <th>Marital Status</th>
                    <td>
                        <select class="form-control" name="ekyc_marital_status" id="ekyc_marital_status">
                            <?php foreach(json_decode(MARITAL_STATUS_NEW_APPL) as $r) { ?>
                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <th>Permanent Address</th>
                    <td> 
                        <input type="text" name="ekyc_per_add" id="ekyc_per_add" class="form-control" value="">
                    </td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>
                        <input type="text" name="ekyc_mobile" id="ekyc_mobile" maxlength="10" 
                        class="form-control" value=""
                        oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
                    </td>
                    <th>Relation with guardian</th>
                    <td> 
                        <select class="form-control" name="ekyc_relation" id="ekyc_relation">
                            <option value="">-- Select Relation --</option>
                            <?php foreach(json_decode(RELATION_NEW_APPL) as $r) { ?>
                                <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

            <?php } ?>

            <tr>
                <th>Occupation</th>
                <th>
                    <select class="form-control" name="ekyc_occ" id="ekyc_occ">
                        <option value="">-- Select Occupation --</option>
                        <?php foreach(json_decode(OCCUPATION_NEW_APPL) as $r) { ?>
                            <option value="<?=$r->CODE?>"><?=$r->NAME?></option>
                        <?php } ?>
                    </select>
                </th>
                <th></th>
                <th>
                    <button type="button" class="btn btn-sm btn-danger addNewMainApplicant">Add Applicant as Main Applicant</button>
                </th>
            </tr>
            <!-- ============== PAN/DL RESPONSE ENDS HERE -->


        </table>
    </div>

    <input type="hidden" id="base_url" value="<?=base_url()?>">
    <textarea style="display: none" id="auth_response"><?php echo json_encode($auth_response);?></textarea>

    
<?php  }  ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url().'js/mb2/changeApplicant.js'?>"></script>
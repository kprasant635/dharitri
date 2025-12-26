<style>
    .enc-area-color{
        background: #FDEBEA!important;
    }
    .settlement-area-color{
        background: #EAFFEA!important;
    }
    .vertical{
        writing-mode: vertical-rl;
        transform: scale(-1)
    }

    .md-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #dc3545);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
</style>

<?php 
if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
else{
    $lessa_chatak='Lessa';
}
?>
<div class="tab-pane active" role="tabpanel" id="step1">

    <h5 class="bgheading p-2 text-white shadow" style="background: #248cf7 !important; margin-top: 10px">
        Applicant Modified Settlement Case  (
        <small><span class="bg-warning"><?=$_GET['case']?> , <?=$basic["applid"]?></span></small> )
    </h5>
    <div class="reza-card">
        <div class="reza-body">
        <h5 class="reza-title" style="margin-top: 15px">
                <i class="fa fa-file-text"></i>  Application Details
            </h5>
            <div class="tableCard">
                <div class="row justify-content-center">
                    <?php 
                    if(isset($base64_decoded_adhar_file)){
                        ?>
                        <div class="col-md-2">
                            <?=$base64_decoded_adhar_file;?>
                        </div>

                    <?php }?>
                    <div class="col-md-10">
                        <table class="table table-bordered">

                        <?php
                            foreach ($applicants_buyers as $identity):
                                if($identity->is_applicant == 1){
                                    ?>
                                    <tr>
                                        <th>
                                            Name in <?=$identity->identity_type?>
                                        </th>
                                        <td>
                                        <strong class="alert-warning"><?=$identity->eng_pdar_name?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?=$identity->identity_type?> Verified</th>
                                        <td>
                                        <strong class="alert-warning"> <?php if(!empty($identity->identity_ref_no)) {echo 'Yes';}?></strong>
                                        </td>
                                    </tr>
                                <?php }
                            endforeach;
                           ?>
 
                            <?php
                            if($applicants_encroacher == true){
                                foreach($applicants_encroacher as $enc_data1){
                                    ?>
                                    <tr>
                                        <th>Period of Possession</th>
                                        <td>
                                            <strong class="alert-warning"><?=$enc_data1->period_possession?></strong>
                                        </td>
                                    </tr>
                                <?php }}?>
                            <tr>
                                <th>Occupation or Profession of the applicant</th>
                                <td>
                                    <strong class="alert-warning"><?=$basic["occupation_applicant"]?></strong>
                                </td>
                            </tr>
                            <?php 
                                if($basic['protected_class']):
                            ?>
                            <tr>
                                <th>Select if you fall under protected category?</th>
                                <td>
                                    <input type="hidden" name="protected_class" value="<?=$basic['protected_class']?>" class="form-control">
                                    <strong class="alert-warning">
                                        <?php
                                        foreach(json_decode(PROTECTED_CLASS) as $class12){


                                            if($class12->CODE == $basic['protected_class']){
                                                echo $class12->NAME;
                                            }
                                        }
                                        ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php endif;?>
                            <tr>
                                <th>Caste</th>
                                <td>
                                    <input type="hidden" name="caste" value="<?=$basic["caste"]?>" class="form-control">
                                    <strong class="alert-warning"><?php
                                        foreach(json_decode(CASTE) as $caste){
                                            if($caste->CODE == $basic["caste"]){
                                                echo $caste->NAME;
                                            }
                                        }
                                        ?></strong>
                                </td>
                            </tr>
                            <?php if (isset($backup_under_tribe_belts)) { ?>
                            <tr>
                                <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                                <td>
                                    <strong class="alert-warning"><?php
                                        if($backup_under_tribe_belts == '1'){
                                            ?>
                                            YES
                                            <?php
                                        }else{
                                            ?>
                                            NO
                                            <?php
                                        }
                                        ?></strong>
                                </td>
                            </tr>
                            <?php } ?>
                           
                            <tr>
                                <th>View Application </th>
                                <td>

                                    <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=<?=$basic["case_no"];?>">
                                        <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-map-marker"></i> Address Information
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <tr>
                        <th>District Name:</th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getDistrictName($basic["dist_code"])?>
                            </strong>
                        </td>
                        <th>Subdivision Name:</th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getSubDivName($basic["dist_code"], $basic["subdiv_code"])?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Circle Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?>
                            </strong>
                        </td>
                        <th>Mouza Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Village Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?>
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user"></i>  Applicant details
            </h5>
            <?php $i = 1;foreach ($applicants_buyers as $settlement): ?>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr >
                            <th rowspan="6" style="vertical-align : middle;text-align:center; min-width: 4%!important; max-width: 4%!important; width: 4%">
                                <?=$i;?>
                            </th>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Applicant Name ( Assamese)</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_name;?>
                                </strong>
                            </td>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Guardian name (Assamese)</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_guardian;?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Applicant Name (English)</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->eng_pdar_name;?>
                                </strong>
                            </td>
                            <th>Guardian Name (English)</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->eng_pdar_guardian;?>
                                </strong>
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Relation</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    foreach ($guar_rel as $guar_rel_list) {
                                        if ($guar_rel_list->id == $settlement->pdar_rel_guar) { 
                                            echo $guar_rel_list->guard_rel_desc_as;
                                        }
                                    }
                                    ?>
                                </strong>
                            </td>
                            <th>Gender</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    if ($settlement->pdar_gender == "1") {
                                        echo "Male";
                                    }
                                    if ($settlement->pdar_gender == "2") {
                                        echo "Female";
                                    }
                                    if ($settlement->pdar_gender == "3") {
                                        echo "Others";
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <?php if($settlement->is_applicant == 1): ?>
                            <th>Marital Status</th>
                            <td>
                                <strong class="alert-warning">
                                <?php
                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                        if($marital_stat->CODE == $settlement->marital_status){
                                        ?>
                                            <?=$marital_stat->NAME?>
                                        <?php
                                    } }
                                ?>
                                </strong>
                            </td>
                            <?php endif;?>
                            <th>Mobile</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_mobile?>
                                </strong>
                            </td>
                          
                        </tr>
                        
                        <tr>
                            <th>DOB</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->dob?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Present address</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_add2?>
                                </strong>
                            </td>
                            <th>
                                Permanent address
                            </th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_add1?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php $i++;?>
            <?php endforeach;?>

            <?php if (!empty($applicant_marital_status)) { ?>
            <h5 class="md-title" style="margin-top: 50px">
                <i class="fa fa-user"></i>  Applicant details Updated Data <img src="<?= base_url(); ?>/assets/icon_new.gif">
            </h5>
            
                <div class="tableCard">
                    <table class="table table-bordered">
                        

                        
                       
                        <tr>
                            <th>Updated Marital Status</th>
                            <td>
                                <strong class="alert-warning">
                                <?php
                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                        if($marital_stat->CODE == $applicant_marital_status->marital_status){
                                        ?>
                                            <?=$marital_stat->NAME?>
                                        <?php
                                    } }
                                ?>
                                </strong>
                            </td>

                            
                          
                        </tr>
                       
                    </table>
                </div>

                <?php $i++;?>

            <?php } ?>

            

            <?php if (!empty($applicants_new)) { ?>
            <h5 class="md-title" style="margin-top: 50px">
                <i class="fa fa-user"></i>  New Join Pattdar added by applicant <img src="<?= base_url(); ?>/assets/icon_new.gif">
            </h5>
            <?php $i = 1;foreach ($applicants_new as $jpattadar): ?>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr >
                            <th rowspan="6" style="vertical-align : middle;text-align:center; min-width: 4%!important; max-width: 4%!important; width: 4%">
                                <?=$i;?>
                            </th>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Applicant Name ( Assamese)</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$jpattadar->name_ass;?>
                                </strong>
                            </td>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Guardian name (Assamese)</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$jpattadar->gurdian_name_ass;?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Applicant Name (English)</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$jpattadar->name_eng;?>
                                </strong>
                            </td>
                            <th>Guardian Name (English)</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$jpattadar->gurdian_name_eng;?>
                                </strong>
                            </td>
                        </tr>
                        
                        <tr>
                            <th>Relation</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    foreach ($guar_rel as $guar_rel_list) {
                                        if ($guar_rel_list->id == $jpattadar->gurdian_relation_id) { 
                                            echo $guar_rel_list->guard_rel_desc_as;
                                        }
                                    }
                                    ?>
                                </strong>
                            </td>
                            <th>Gender</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    if ($jpattadar->gender == "1") {
                                        echo "Male";
                                    }
                                    if ($jpattadar->gender == "2") {
                                        echo "Female";
                                    }
                                    if ($jpattadar->gender == "3") {
                                        echo "Others";
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Marital Status</th>
                            <td>
                                <strong class="alert-warning">
                                <?php
                                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                                        if($marital_stat->CODE == $jpattadar->marital_status){
                                        ?>
                                            <?=$marital_stat->NAME?>
                                        <?php
                                    } }
                                ?>
                                </strong>
                            </td>

                            <th>Mobile</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$jpattadar->mobile?>
                                </strong>
                            </td>
                          
                        </tr>
                        
                        <tr>
                            <th>DOB</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$jpattadar->dob?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Present address</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$jpattadar->pre_add?>
                                </strong>
                            </td>
                            <th>
                                Permanent address
                            </th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$jpattadar->per_add?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php $i++;?>
            <?php endforeach;?>
            <?php } ?>


            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-check-square-o" aria-hidden="true"></i> LM Report
            </h5>

            <div class="tableCard">
                    <table class="table table-bordered">
                        <tr >
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Lm Recommend</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$lm_report_from_proceedings->note_type;?>
                                </strong>
                            </td>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Lm Note</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$lm_report_from_proceedings->note_on_order;?>
                                </strong>
                            </td>
                        </tr>
                        </table>
            </div>


<!-- 
        </div>
    </div>

    <div class="reza-card">
    <div class="reza-body"> -->
        <?php
        if ($this->session->flashdata('message')):
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?php echo $this->session->flashdata('message'); ?></strong>
            </div>
        <?php endif;?>

        <input type="hidden" id="caseNo" name="case_no" value="<?=$_GET['case']?>">

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-check-square-o" aria-hidden="true"></i> CO Report
            </h5>

            <div class="tableCard ">


                <?php
                $pending_officer = $basic["pending_officer"];
                $from_office = $basic["from_office"];
                ?>
                <form method="post" id="lm_form_sub" name="lm_form_sub" action="<?php echo base_url() ?>index.php/SettlementApplicantCo/coReportSubmit">

                    <input type="hidden" id="case_no" name="case_no" value="<?=$_GET['case']?>">

                    <div class="mt-4 row px-5">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">

                            <select name="remark_co_type" id="remark_co" onchange="autoRemark();" class="form-control">

                            

                                <option value="">Select remarks...</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Reject</option>


                            </select> <br>
                            <textarea placeholder="Remarks  ..." name="remark_co" id="remark_co_text" class="form-control p-2" cols="30" rows="10"></textarea>
                            <input type="hidden" name="case_no" value="<?=$_GET['case']?>">

                        </div>
                    </div>
                    <div class="row mt-4 justify-content-center">

                    <input type="submit" name="forward_to_dc" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" value="Submit">
                    <!-- <input type="submit" name="forward_to_dc" onclick="return dc_forward()" id="frwrd_dc_btn" class="m-1 col-2 btn btn-danger btn-info-full btn-sm" value="Reject"> -->
                    </div>

                    <?php
                    //}
                    ?>
                    <br>
                    
                </form>

            </div>

    </div>
</div>
    <!-- <ul class="list-inline pull-right" style="margin-top: 20px">
        <li>
            <button id="next_id" type="button" class="btn btn-primary next-step">
                <i class="fa fa-arrow-circle-right"> </i> Next
            </button>
        </li>
    </ul> -->
</div>


<script>

function showSelfAndDocument(popupId) {
            
            var case_no = $.trim($('#case_no').val());

            var postData = {
                'case_no': case_no,
            };

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            $.ajax({
                url: baseurl+'SettlementCommon/getSelfDocApi',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                               
                    if(arr.responseType == 0){
                        showErrorMessage(arr.msg);
                    }else{

                        const selfContainer = $('#selfdeclaration');
                        for(var i = 0; i < arr.selfDeclarationDetails[0].length; i++)
                        {
                            if(arr.selfDeclarationDetails[0][i].status == '1'){
                                $yesno='YES';
                            }else if(arr.selfDeclarationDetails[0][i].status == '0'){
                                $yesno='NO';
                            }else{
                                $yesno='';
                            }

                            const selfd = $('<tr><th>'+arr.selfDeclarationDetails[0][i].name+'</th><td class="text-center"><strong>'+$yesno+'</strong></td></tr>');

                            selfContainer.append(selfd);
                        }

                        const docContainer = $('#apidoc');
                        for(var x = 0; x < arr.document.length; x++)
                        {
                            const doclink = $('<a>', {
                                href: baseurl+'SettlementCommon/document/'+arr.document[x].name,
                                text: '' + arr.document[x].file_details,
                                target:'_blank'
                            });

                            docContainer.append(doclink).append('<br>');
                        }

                        // $("#aadhartype").show();
                        // $("#aadhartype").append("in " + arr.aadhar.type);
                        $(".btn-api-call").hide();

                        
                    }
                }
            });
        }
</script>
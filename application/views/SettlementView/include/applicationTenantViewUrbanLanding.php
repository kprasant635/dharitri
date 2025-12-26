<style>
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
</style>

<?php 
  if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
  else{
    $lessa_chatak='Lessa';
  }
?>

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
    <?php if(isset($all_errors)) { ?>
      <div class="alert alert-warning">
        <b><?=$all_errors;?></b>
      </div>
    <?php } ?>

  </div>

  <div class="reza-body">

    <!--- Application Details starts here --->
    <?=$dagFlagCheckChitha?>
    <h5 class="reza-title" style="margin-top: 7px">
      <i class="fa fa-file-text"></i>  Application Details
    </h5>
    <div class="tableCard">
      <div class="row justify-content-center">
 
        <?php if(isset($base64_decoded_adhar_file)){ ?>
          <div class="col-md-2">
            <?=$base64_decoded_adhar_file;?>
          </div>
        <?php }?>

        <div class="col-md-10">
          <table class="table table-bordered">
            <tr>
               <th>
                  Name in <?=$aadhar[0]->identity_type?>
               </th>
               <td>
                  <input type="text" value="<?=$aadhar[0]->eng_pdar_name?>" class="form-control" readonly>
               </td>
            </tr>

            <tr>

              <th><?=$aadhar[0]->identity_type?> Verified</th>
              <td>
                <input type="text" name="aadhar_verified" value="<?php if ($aadhar[0]->identity_type != null) {echo 'Yes';}?>" class="form-control" disabled>
              </td>
            </tr>

            <?php
              if ($basic == true) { ?>
            <tr>
                <th>Occupation or Profession of the applicant</th>
                <td>
                  <input type="text" readonly name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" id="occupation_applicant" class="form-control">
                </td>
            </tr>
            <tr>
                <th>Caste</th>
                <td>
                    <input type="hidden" name="caste" value="<?=$basic['caste']?>" class="form-control">
                    <input readonly type="text" name="" id="caste_name" value="<?php
                        foreach (json_decode(CASTE) as $caste) {
                            if ($caste->CODE == $basic['caste']) {
                                echo $caste->NAME;
                            }
                        }
                    ?>" class="form-control">
                </td>
            </tr>
            <?php
              if($basic['protected_class']):
            ?>
            <tr>
                <th>Select if you fall under protected category?</th>
                <td>
                    <select name="protected_class" id="protected_class" class="form-control">
                        <?php
                        foreach(json_decode(PROTECTED_CLASS) as $class){
                            ?>
                            <option value="<?=$class->CODE?>" <?php if($class->CODE == $basic['protected_class']){echo "selected";} ?>><?=$class->NAME?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>
              <tr>
                  <th>Whether land prayed for is within tribal belt/block ?</th>
                  <td>
                      <select name="tribal_belt" id="" class="form-control" disabled>
                          <option value="YES" <?php if($basic['tribal_belt'] == 'YES'){echo "selected";}?>>Yes</option>
                          <option value="NO" <?php if($basic['tribal_belt'] == 'NO'){echo "selected";}?>>No</option>
                      </select>
                  </td>
              </tr>
            <?php } ?>

              <tr>
                <th>Possession Since</th>
                <td>
                  <input type="text" readonly name="period_possession" class="form-control" value="<?=$basic["period_possession"] ?>">
                </td>
              </tr>

              <tr>
                <th>Total Applications applied by this applicant</th>
                <td>
                  <span>
                    <a type="button" target="_blank" class="btn buttInfo"
                       href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$application_no?>">
                        <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View now</small>
                    </a>
                  </span>
                </td>
              </tr>
          </table>
        </div>
      </div>
    </div>
    <!--- Application Details ends here ///////////////////////--->

    <!--- Location Details starts here --->
    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-map-marker"></i> Location Details
    </h5>
    <div class="tableCard ">
        <table class="table table-bordered">
            <tr>
                <th>District Name:</th>
                <td class="text-warning">
                    <strong class="alert-warning">
                        <input type="text" name="dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($basic["dist_code"])?>' readonly>
                        <input type="hidden" name="dist_code" value="<?=$basic["dist_code"];?>">
                    </strong>
                </td>
                <th>Subdivision Name:</th>
                <td class="text-warning">
                    <strong class="alert-warning">
                        <input type="text" name="subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($basic["dist_code"],$basic["subdiv_code"])?>' readonly>
                        <input type="hidden" name="subdiv_code" value="<?=$basic["subdiv_code"];?>">
                    </strong>
                </td>
            </tr>
            <tr>
                <th>Circle Name: </th>
                <td class="text-warning">
                    <strong class="alert-warning">
                        <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?>' class="form-control input-sm" readonly>
                        <input type="hidden" name="cir_code" value="<?=$basic["cir_code"];?>">
                    </strong>
                </td>
                <th>Mouza Name: </th>
                <td class="text-warning">
                    <strong class="alert-warning">
                        <input type="text" name="mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?>' readonly>
                        <input type="hidden" name="mouza_pargona_code" value="<?=$basic["mouza_pargona_code"];?>">
                    </strong>
                </td>
            </tr>
            <tr>
                <th>Village Name: </th>
                <td class="text-warning">
                    <strong class="alert-warning">
                        <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?>' class="form-control input-sm" readonly>
                        <input type="hidden" name="vill_townprt_code" value="<?=$basic["vill_townprt_code"];?>">
                    </strong>
                </td>
            </tr>
        </table>
    </div>
    <!--- Location Details ends here //////////////////////////////--->


    <!--- Self declaration Details starts here --->
    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-pencil-square-o"></i> Self declaration details
    </h5>
    <div class="tableCard">
        <table class="table table-bordered">
          <?php foreach ($selfDeclarationDetails[0] as $key => $self) { ?>
          <tr>
              <th><?=$self->name?></th>
              <td>
                <strong>
                <?php if ($self->status == "1") {echo "Yes";}?>
                <?php if ($self->status == "0") {echo "No";}?>
                </strong>
              </td>
          </tr>
          <?php }?>
        </table>
    </div>
    <!--- Self declaration Details starts here //////////////////////////////--->


    <!--- Applicant starts here --->
    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-user"></i>  Applicant details
    </h5>

    <?php if(ENABLE_APPLICANT_BUTTON != 0) { ?>

      <button type="button" onclick="openApplicant();" class="btn btn-sm btn-danger"><strong>Click to Add New Applicant Detail</strong></button>

    <?php }     
    $i = 1;foreach ($applicants_buyers as $settlement):?>
      <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
      <div class="tableCard" id='applicantData'>
        <table class="table" id="appRow<?=$settlement->id?>">
           <tr>
              <th rowspan="7" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
              <th>Applicant Name (Assamese)</th>
              <td>
                <input type="text" readonly class="form-control input-sm" id="pdar_name<?=$settlement->id?>" value="<?=$settlement->pdar_name?>">
              </td>
              <th>Guardian Name (Assamese)</th>
              <td>
                 <input type="text" readonly class="form-control input-sm" id="pdar_guardian<?=$settlement->id?>" value="<?=$settlement->pdar_guardian?>">
              </td>
           </tr>
           <tr>
              <th>Applicant Name (English)</th>
              <td>
                 <input type="text" readonly class="form-control input-sm" value="<?=$settlement->eng_pdar_name?>" id="eng_pdar_name<?=$settlement->id?>">

              </td>
              <th>Guardian Name (English)</th>
              <td>
                 <input type="text" readonly class="form-control input-sm" id="eng_pdar_guardian<?=$settlement->id?>" value="<?=$settlement->eng_pdar_guardian?>">
              </td>
           </tr>
           <tr>
              <th>Relation</th>
              <td>
                <select id="pdar_rel_guar<?=$settlement->id?>" class="form-control select-sm" disabled>
                    <option value="">Select</option>
                    <?php foreach ($guar_rel as $guar_rel_list) {
                      ?>
                    <option value="<?=$guar_rel_list->id?>" <?php if ($guar_rel_list->id == $settlement->pdar_rel_guar) { echo "selected";}?>>
                      <?=$guar_rel_list->guard_rel_desc_as?>
                    </option>
                    <?php }?>
                </select>

              </td>
              <th>Gender</th>
              <td>
                    <select disabled class="form-control" id="pdar_gender<?=$settlement->id?>">
                        <option value="">Select...</option>
                        <option value="1" <?php if($settlement->pdar_gender == "1") {echo "selected";}?>>Male</option>
                        <option value="2" <?php if($settlement->pdar_gender == "2"){ echo "selected";}?>>Female</option>
                        <option value="3" <?php if($settlement->pdar_gender == "3"){ echo "selected";}?>>Others</option>
                    </select>
              </td>
           <tr>
              <th>DOB</th>
              <td>
                <input type="text" readonly id="dob<?=$settlement->id?>" name="dob<?=$settlement->id?>" value="<?=$settlement->dob;?>" class="form-control input-sm hasDatepick" >
              </td>
              <?php if($settlement->is_applicant == 1): ?>
              <th>Marital Status</th>
              <td>
                <select class="form-control" disabled id="marital_status<?=$settlement->id?>">
                    <option value="">Select...</option>
                    <?php
                    foreach(json_decode(MARITAL_STATUS) as $marital_stat){
                        ?>
                        <option value="<?=$marital_stat->CODE?>" <?php if($marital_stat->CODE == $settlement->marital_status){ echo "selected";}?>>
                            <?=$marital_stat->NAME?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
              </td>
              <?php endif;?>
           </tr>
           <tr>
              <th>Mobile</th>
              <td>
                <input type="text" readonly class="form-control input-sm" id="pdar_mobile<?=$settlement->id?>" value="<?=$settlement->pdar_mobile?>">

              </td>
              <th>
                 Permanent address
              </th>
              <td>
                <input type="text" readonly class="form-control input-sm" id="pdar_add1<?=$settlement->id?>" value="<?=$settlement->pdar_add1?>">
              </td>
           </tr>
           <tr>
              <th>Present address</th>
              <td>
                <input type="text" readonly class="form-control input-sm" id="pdar_add2<?=$settlement->id?>" value="<?=$settlement->pdar_add2?>">
              </td>


           </tr>
           <tr>
                <td style="vertical-align : middle;text-align:center;">
                  <?php if(ENABLE_APPLICANT_BUTTON != 0) { ?>

                    <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>

                  <?php if($settlement->is_applicant != 1) { ?>

                    <button type="button" onclick="confirmDeleteApplicant(<?=$settlement->id?>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i><strong>Delete</strong></button>

                  <?php }} ?>

                </td>
           </tr>
        </table>
      </div>

    <?php $i++; endforeach; ?>

    <input type="hidden" name="deleted_applicant" value="" id="del_fpart_appl">


    <!--- Applicant ends here  //////////////////////////////--->

    <!--- Land Owner Details starts here --->
    <?php if(!empty($owners)) { ?>
      <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-user-secret"></i> Land Owner Details
      </h5>
      <div class="tableCard">
        <table class="table table-bordered">
        
          <?php          
          $i=1; foreach($owners as $owners_details) { ?>

            <tr>
              <th rowspan="2"><?=$i?></th>
              <th>Name</th>
              <td colspan="2">
                <input type="text" readonly name="owners_name<?=$owners_details->id?>" value="<?php echo $owners_details->pdar_name;?>" class="form-control input-sm <?php if(form_error('owners_name'.$owners_details->id)){echo 'is-invalid';}?>">
                <?=form_error('owners_name'.$owners_details->id)?>
              </td>
              <th>Father's name</th>
              <td colspan="2">
                <input type="text" readonly name="owners_guardian<?=$owners_details->id?>" value="<?php echo $owners_details->pdar_guardian;?>" class="form-control input-sm <?php if(form_error('owners_guardian'.$owners_details->id)){echo 'is-invalid';}?>" >
                <?=form_error('owners_guardian'.$owners_details->id)?>
              </td>
            </tr>
            <tr>
              <th> Mobile No.</th>
              <td colspan="2">
                <input type="text" readonly class="form-control <?php if(form_error('owners_mobile_number'.$owners_details->id)){echo 'is-invalid';}?>" name="owners_mobile_number<?=$owners_details->id?>" value="<?php if($owners_details->pdar_mobile == '' || $owners_details->pdar_mobile == null || $owners_details->pdar_mobile == 'NA' || $owners_details->pdar_mobile == 'na' || $owners_details->pdar_mobile == '-1'){ echo 'NA';}else{ echo $owners_details->pdar_mobile;}?>">
                <?=form_error('owners_mobile_number'.$owners_details->id)?>
              </td>
            </tr>
          <?php $i++; } ?>
        </table>
      </div>
    <?php } ?>
    <!--- Land Owner Details ends here  //////////////////////////////--->

    <!--- Bhumiputra Details starts here --->
    <?php if(isset($basic["bhumiputra_certificate_no"])){?>
      <h5 class="reza-title" style="margin-top: 50px">
          <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
      </h5>
      <div class="tableCard">
          <table class="table table-bordered">
            <tr>
                <th>Bhumiputra certificate/Ack verified?</th>
                <td>
                  <?php if(trim($basic['bhumiputra_confirmation']) == YES) : ?>
                  <input  type="hidden" name="bhumiputra_confirmation" id=""  value="YES" >
                  <b>Yes </b>
                  <?php else: ?>
                  <input  type="hidden" name="bhumiputra_confirmation" id="" value="NO">
                  <b>No </b>
                  <?php endif; ?>
                </td>
                <td>
                  <input type="hidden" name="bhumiputra_certificate_type" value="<?php
                      if($basic["bhumiputra_certificate_no"] == BHUMI_CERT){
                          echo BHUMI_CERT;
                      }elseif($basic["bhumiputra_certificate_no"] == BHUMI_ACK){
                          echo BHUMI_ACK;
                      }
                      ?>">
                  <input type="hidden" name="bhumiputra_certificate_no" value="<?=$basic["bhumiputra_certificate_no"]?>">
                  Certificate/Ack number : <b><?=$basic["bhumiputra_certificate_no"]?></b>
                </td>
            </tr>
          </table>
      </div>
    <?php }?>
    <!--- Bhumiputra Details ends here  //////////////////////////////--->

    <!--- Area Details starts here --->
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
              <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
              <th class="text-center">Ganda</th>
              <th class="text-center">Kranti</th>
              <?php endif; ?>
            </tr>

            <?php
              $i=1;
            foreach($dags as $dags_details){

              $applId = $this->utilityclass->getApplidFromCaseNo($dags_details->case_no);
                ?>
              <input type="hidden" name="is_urban" id="urbanCheck<?=$dags_details->dag_no?>" value="<?=$dags_details->is_urban?>">
              <tr class="bg-white">
                <th rowspan="6" style="vertical-align : middle;">
                  <div class="vertical text-center">
                    DAG : <span class="text-danger"><?=$dags_details->dag_no?></span> | 
                    PATTA : <span class="text-danger"><?=$dags_details->patta_no?> <br> <?=$this->utilityclass->getPattaType($dags_details->patta_type_code)?></span>

                    <input type="hidden" name="dag_no" value='<?=$dags_details->dag_no?>' class="form-control input-sm" readonly>
                    
                    <input type="hidden" name="patta_no" id="patta_no" class="form-control input-sm" value='<?=$dags_details->patta_no;?>' readonly>

                    <input type="hidden" name="patta_type_code" value='<?=$dags_details->patta_type_code?>' class="form-control input-sm" >

                    <input type="hidden" id="patta_type_code_display" name="patta_type_code_display" value='<?=$this->utilityclass->getPattaType($dags_details->patta_type_code)?>' class="form-control input-sm" readonly>
                  </div>
                </th>
                <td><strong>Total Land Area in Selected Dag</strong></td>

                <td style="text-align: center;">
                  <strong>
                    <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags_details->dag_area_b?>" readonly id="dag_area_b">
                  </strong>
                </td>
                <td style="text-align: center;">
                  <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags_details->dag_area_k?>" class="form-control input-sm" readonly id="dag_area_k">
                </td>
                <td style="text-align: center;">
                  <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags_details->dag_area_lc?>" readonly id="dag_area_lc">
                </td>
                <?php if((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td style="text-align: center;">
                    <input type="text" style="text-align: center;" value="<?=$dags_details->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly id="dag_area_g">
                  </td>
                  <td style="text-align: center;">
                    <input type="text" style="text-align: center;" value="<?=$dags_details->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly id="dag_area_kr">
                  </td>
                <?php endif; ?>
              </tr>

              <!-- Area for Settlement -->
              <tr class="bg-white">
                <td class="settlement-area-color">
                    <strong class="text-danger">Area for Settlement</strong>
                    <span class="<?php if(form_error('appAreaLessaValidation') || form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                    <?=form_error('appAreaLessaValidation');?>
                    <?=form_error('appAreaMoreThanDagA');?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input readonly type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_b" id="s_dag_area_b" class="form-control input_editable_background input-sm s_dag_area_b <?php if(form_error('s_dag_area_b')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_b');}else{ echo $dags_details->s_dag_area_b;}?>" >
                  <?=form_error('s_dag_area_b')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input readonly type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_k" id="s_dag_area_k" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_k');}else{ echo $dags_details->s_dag_area_k;}?>" class="form-control input_editable_background input-sm s_dag_area_k <?php if(form_error('s_dag_area_k')){echo 'is-invalid';}?>" >
                  <?=form_error('s_dag_area_k')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input readonly type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_lc" id="s_dag_area_lc" class="form-control input_editable_background input-sm s_dag_area_lc <?php if(form_error('s_dag_area_lc')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_lc');}else{ echo $dags_details->s_dag_area_lc;}?>" >
                  <?=form_error('s_dag_area_lc')?>
                </td>

                <?php if((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input readonly type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_g');}else{ echo $dags_details->s_dag_area_g;}?>" class="form-control input_editable_background input-sm s_dag_area_g <?php if(form_error('s_dag_area_g')){echo 'is-invalid';}?>" name="s_dag_area_g" id="s_dag_area_g" >
                    <?=form_error('s_dag_area_g')?>
                  </td>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input readonly type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_kr');}else{ echo $dags_details->s_dag_area_kr;}?>" class="form-control input_editable_background input-sm s_dag_area_kr <?php if(form_error('s_dag_area_kr')){echo 'is-invalid';}?>" name="s_dag_area_kr"  id="s_dag_area_kr">
                    <?=form_error('s_dag_area_kr')?>
                  </td>
                <?php endif; ?>

                <?php if((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))) { ?>
                  <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
                <?php } else { ?>
                  <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
                <?php } ?>

              </tr>

              <?php if((in_array($dags_details->dist_code, json_decode(BARAK_VALLEY)))) { ?>
                <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
              <?php } else { ?>
                <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
              <?php } ?>

              <tr class="bg-white">
                <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                  <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$applId;?>&dag=<?=$dags_details->dag_no;?>">
                      <small style="font-size:14px; color:white; font-weight:bold"><i class="fa fa-eye"></i> View Total Applications in this Dag</small>
                  </a>
                </td>
              </tr>
            <?php $i++; } ?>
          </thead>
        </table>
      </div>
    </div>
    <!--- Area Details ends here  //////////////////////////////--->

    <!--- Additional property starts here --->
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
                </strong>
              </td>
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

          <?php $i++; endforeach;  ?>
        </table>
      </div>
    <?php  } ?>
    <!--- Additional property ends here  //////////////////////////////--->

    <!--- Rayytee details starts here --->
    <?php 

    if($chitha_tenant_exist == 'y') {
        $en = $chitha_tenant;
          ?>
          <h5 class="reza-title" style="margin-top: 50px">
            <i class="fa fa-users"></i>  Rayytee Details
          </h5>
          <div class="tableCard">
            <table class="table table-bordered">
              <tr>
                <th>Khatian No</th>
                <th>Name</th>
                <th>Father's Name</th>
              </tr>          
              <tr>
                <td>
                  <input type="text" readonly name="khatian_no" value="<?=($en->khatian_no=='-1' || $en->khatian_no=='') ? '' : $en->khatian_no;?>" class="khatian_no_id form-control input-sm <?php if(form_error('khatian_no')){echo 'is-invalid';}?>">
                  <?=form_error('khatian_no')?>
                </td>
                <td>
                  <input type="text" name="riotee_name" value="<?=($en->tenant_name=='-1' || $en->tenant_name=='') ? '' : $en->tenant_name; ?>" id="tenant_name_id" class="form-control input-sm <?php if(form_error('riotee_name')){echo 'is-invalid';}?>" readonly>
                  <?=form_error('riotee_name')?>
                </td>
                <td>
                  <input type="text" name="riotee_guardian" value="<?= ($en->tenants_father=='-1' || $en->tenants_father=='') ? '' : $en->tenants_father; ?>" id="tenants_father_id" class="form-control input-sm <?php if(form_error('riotee_guardian')){echo 'is-invalid';}?>" readonly>
                    <?=form_error('riotee_guardian')?>
                </td>
              </tr>          
            </table>
          </div>
    <?php 
    }
    else
    {
      $en = $chitha_tenant_app_end;
      ?>
        <h5 class="reza-title" style="margin-top: 50px">
          <i class="fa fa-users"></i>  Rayytee Details
        </h5>
        <div class="tableCard">
          <table class="table table-bordered">
            <tr>
              <th>Khatian No</th>
              <th>Name</th>
              <th>Father's Name</th>
            </tr>          
            <tr>
              <td>
                <input type="text" readonly name="khatian_no" value="" class="khatian_no_id form-control input-sm <?php if(form_error('riotee_name')){echo 'is-invalid';}?>">
                <?=form_error('khatian_no')?>

              </td>
              <td>
                <input type="text" name="riotee_name" value="" id="tenant_name_id" class="form-control input-sm <?php if(form_error('riotee_name')){echo 'is-invalid';}?>" readonly>
                <?=form_error('riotee_name')?>
              </td>
              <td>
                <input type="text" name="riotee_guardian" value="" id="tenants_father_id" class="form-control input-sm <?php if(form_error('riotee_guardian')){echo 'is-invalid';}?>" readonly>
                  <?=form_error('riotee_guardian')?>
              </td>
            </tr>          
          </table>
        </div>
      <?php
    }
    ?>
    <!--- Rayytee details ends here  //////////////////////////////--->

    <!--- Rayytee NOK details starts here --->
    <?php if(!empty($applicants_riotee_nok)) { ?>
      <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-users"></i>  Rayytee`s NOK(This would be added to the Rayytee khatian)
      </h5>
      <div class="tableCard">
        <table class="table table-bordered">
          <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Father`s Name</th>
            <th>Relation with Rayytee</th>
          </tr>
          <?php $i=1; foreach($applicants_riotee_nok as $rio): ?>
            <tr>
              <td><?=$i?></td>
              <td>

                <input type="hidden" readonly name="riotee_nok_khatian_no<?=$rio->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_nok_khatian_no'.$rio->id);}else { echo $applicants_encroacher[0]->khatian_no;}?>" class="riotee_nok_khatian_no form-control input-sm <?php if(form_error('riotee_nok_khatian_no'.$rio->id)){echo 'is-invalid';}?>">

                <?=form_error('riotee_nok_khatian_no'.$rio->id)?>
                
                <input type="text" readonly name="riotee_nok_name<?=$rio->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_nok_name'.$rio->id);}else{ echo $rio->pdar_name;}?>" class="form-control input-sm <?php if(form_error('riotee_nok_name'.$rio->id)){echo 'is-invalid';}?>">
                <?=form_error('riotee_nok_name'.$rio->id)?>
              </td>
              <td>
                <input type="text" readonly name="riotee_nok_guardian<?=$rio->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_nok_guardian'.$rio->id);}else{ echo $rio->pdar_guardian;}?>" class="form-control input-sm <?php if(form_error('riotee_nok_guardian'.$rio->id)){echo 'is-invalid';}?>" >
                  <?=form_error('riotee_nok_guardian'.$rio->id)?>
              </td>
              <td>
                <?php
                  if($rio->pdar_type == 'GP'){
                      ?>
                      <input type="hidden" name="riotee_nok_relation<?=$rio->id?>" value="GP">
                      <input type="text" name="pdar_riotee_nok<?=$i?>" value="Grand Son/ Daughter" class="form-control input-sm" readonly>

                <?php
                  }
                  if($rio->pdar_type == 'GGP'){
                      ?>
                      <input type="hidden" name="riotee_nok_relation<?=$rio->id?>" value="GGP">
                      <input type="text" name="pdar_riotee_nok<?=$i?>" value="Great Grand Son/ Daughter" class="form-control input-sm" readonly>
                <?php
                  }
                  if($rio->pdar_type == 'P'){
                      ?>
                      <input type="hidden" name="riotee_nok_relation<?=$rio->id?>" value="P">
                      <input type="text" name="pdar_riotee_nok<?=$i?>" value="Son" class="form-control input-sm" readonly>
                      <?php
                  }
                ?>
              </td>
            </tr>
          <?php $i++; endforeach;?>
        </table>
      </div>
    <?php } ?>
    <!--- Rayytee NOK details ends here  //////////////////////////////--->

    <!--- Nominee details starts here --mdz- --->
    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-users"></i>  Family Details
        <?php if(ENABLE_FAMILY_BUTTON != 0){?>
                <span class="pull-right"><button type="button" onclick="addFamily();" class="btn btn-sm btn-warning" style="margin-top:-5px !important">Add Family</button></span>
        <?php } ?>
    </h5>
    <?php if(!empty($nominee)) { ?>
      <div class="tableCard">
          <table class="table table-bordered" id="listNextOfKin">
            <tr>
                <th>Nominee name</th>
                <th>Relation with Applicant</th>
                <th>Address of Nominee</th>
                <th>Mobile number</th>
            </tr>
            <?php $i = 1;foreach ($nominee as $kin): ?>
              <tr id="sp<?=$kin->id?>">
                  <td>
                      <input type="text" readonly name="kin_name" value="<?=$kin->nominee_name?>" class="form-control">
                  </td>
                  <td>
                      <input type="text" readonly name="kin_relation" value="<?=$this->utilityclass->appRelationbyIDMB2($kin->relation)?>" class="form-control">
                  </td>
                  <td>
                      <input type="text" readonly class="form-control" value="<?=$kin->address?>" name="kin_address">
                  </td>
                  <td>
                      <input type="text" readonly name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control">
                  </td>
                  <td>
                  <?php if(ENABLE_FAMILY_BUTTON != 0){?>
                      <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add</button>
                      <button type="button" onclick="confirmDeleteFamily(<?=$kin->id?>);" class="btn btn-sm btn-danger">Delete</button>
                  <?php } ?>
                  </td>
              </tr>
            <?php $i++;?>
            <?php endforeach;?>
          </table>
      </div>
    <?php } else { ?>
      <div class="tableCard familyVisibleHide">
          <table class="table table-bordered" id="listNextOfKin">
          <tr>
              <th>Name</th>
              <th>Relation</th>
              <th>Address</th>
              <th>Mobile number</th>
          </tr>
          </table>
      </div>
    <?php } ?>

    <!--- Nominee details ends here --mdz- --->

    <!--- Supporting Documents starts here --->
    <h5 class="reza-title" style="margin-top: 50px">
      <i class="fa fa-file-pdf-o"></i> Supporting Documents
    </h5>
    <div class="tableCard">
      <table class="table table-bordered">
        <?php foreach($document as $d): ?>
          <tr>
            <th>
              <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/documentmb3/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
              <input type="hidden" name="file_name" value="<?=$d->name;?>">
              <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
              <input type="hidden" name="file_path" value="<?=$d->path;?>">
              <input type="hidden" name="file_details" value="<?=$d->file_details?>">
              <input type="hidden" name="mut_type" value="<?=$app['service_code']?>">
            </th>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <!--- Supporting Documents ends here  //////////////////////////////--->

  </div>
</div>
<!-- <ul class="list-inline pull-right" style="margin-top: 20px">
    <li>
        <button type="button" class="btn btn-primary next-step">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>  Save & Continue
        </button>
    </li>
</ul> -->

<script>
    $('#additionalErrors').on('click',function(){
        $(this).next('#additional_errors_collapse').slideToggle();
    });

</script>

<!-- for blinking the check errors tag -->
<script>
    // var blink = document.getElementById('blink');

    // setInterval(function () {
    //     blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    // }, 500);


    function totalAreaCal(){
        reset();
    }


</script>
<?php include(APPPATH."views/SettlementView/include/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editApplicantDetails.js"></script>
<?php include(APPPATH."views/SettlementView/include/addApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/addApplicantDetails.js"></script>
<?php include(APPPATH."views/SettlementView/include/editFamilyDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editFamilyDetails.js"></script>



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

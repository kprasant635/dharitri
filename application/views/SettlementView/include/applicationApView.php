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
<script>
   $(function () {
       $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
   });
</script>
<?php 
    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
        $lessa_chatak='Chatak'; }
    else{
        $lessa_chatak='Lessa';
    }
?>
<div class="reza-card">
  <div id="additionalErrors" class="text-right px-4 mt-2" style="cursor:pointer;">
    <?php if(isset($all_errors)){ ?>
        <span class="text-danger">
          <i id="blink" class="fa fa-exclamation-circle fa-lg" aria-hidden="true"></i>
            Check errors
        </span>
    <?php } ?>
  </div>
  <div id="additional_errors_collapse" style="display: none;">
    <?php if(isset($all_errors)){ ?>
      <div class="alert alert-warning">
        <b>
            <?=$all_errors;?>
        </b>
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
              
            <?php 
            if(isset($base64_decoded_adhar_file)){
                ?>
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
                            <input readonly type="text" name="aadhar_verified" value="<?=$basic["occupation_applicant"] ?>" class="form-control" >
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
                            <select name="protected_class" id="protected_class" class="form-control" readonly>
                                <?php
                                foreach(json_decode(PROTECTED_CLASS) as $class){
                                    ?>
                                    <option value="<?=$class->CODE?>" <?php if($class->CODE == $basic['protected_class']){echo "selected";} ?>><?=$class->NAME?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                  <?php endif; ?>
                    <!-- <tr>
                        <th>Whether land prayed for is within tribal belt/block ?</th>
                        <td>
                            <select name="tribal_belt" id="" class="form-control" readonly>
                                <option value="YES" <?php if($basic['tribal_belt'] == 'YES'){echo "selected";}?>>Yes</option>
                                <option value="NO" <?php if($basic['tribal_belt'] == 'NO'){echo "selected";}?>>No</option>
                            </select>
                        </td>
                    </tr> -->
                    <?php
                      if($basic['type_of_transfer']):
                    ?>
                    <tr>
                        <th>Land Transfer Type</th>
                        <td>
                            <select name="type_of_transfer" id="type_of_transfer" class="form-control" readonly>
                                <?php
                                foreach(json_decode(TYPE_OF_TRANSFER) as $land_transfer){
                                    ?>
                                    <option value="<?=$land_transfer->CODE?>" <?php if($land_transfer->CODE == $basic['type_of_transfer']){echo "selected";} ?>><?=$land_transfer->NAME?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php
                      if($basic['type_of_patta']):
                    ?>
                    <tr>
                        <th>Type of Patta</th>
                        <td>
                            <select name="type_of_patta" id="type_of_patta" class="form-control" readonly>
                                <?php
                                foreach(json_decode(TYPE_OF_PATTA) as $land_patta){
                                    ?>
                                    <option value="<?=$land_patta->CODE?>" <?php if($land_patta->CODE == $basic['type_of_patta']){echo "selected";} ?>><?=$land_patta->NAME?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <?php endif; ?>
                  
                    <input type="hidden" name="period_possession" class="form-control" value="<?=$basic["period_possession"] ?>">
                    <input type="hidden" name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" id="occupation_applicant" class="form-control">
                    <tr>
                        <th>Total Applications applied by this applicant</th>
                        <td>
                            <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$basic["applid"];?>">
                                <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
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
    <!--- Self declaration Details ends here //////////////////////////////--->

    <!--- Applicant starts here --->
    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-user"></i>  Applicant details
    </h5>



    <?php $i = 1;foreach ($applicants_buyers as $settlement):?>
        <input type="hidden" name="pdar_type<?=$settlement->id?>" value="<?=$settlement->pdar_type;?>">
        <div class="tableCard" id='applicantData'>
          <table class="table" id="appRow<?=$settlement->id?>">
             <tr>
                <th rowspan="6" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
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
                      <?php foreach ($guar_rel as $guar_rel_list) {?>
                          <option value="<?=$guar_rel_list->id?>" <?php if($guar_rel_list->id == $settlement->pdar_rel_guar){ echo "selected";}?>><?=$guar_rel_list->guard_rel_desc_as?></option>
                      <?php
                      }
                      ?>
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

                <td colspan="2" style="vertical-align : middle;text-align:center;">

                  <?php if(ENABLE_APPLICANT_BUTTON != 0) { ?>

                    <button type="button" onclick="editApplicant(<?=$settlement->id?>, <?=$settlement->is_applicant?>);" class="btn btn-sm btn-warning"><strong>Edit Data</strong></button>
                    <button type="button" onclick="openApplicant();" class="btn btn-sm btn-primary"><strong>Add Data</strong></button>

                  <?php if($settlement->is_applicant != 1) { ?>

                    <button type="button" onclick="confirmDeleteApplicant(<?=$settlement->id?>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i><strong>Delete</strong></button>

                  <?php }} ?>

                </td>

             </tr>
          </table>
        </div>

    <?php $i++; endforeach; ?>

    <input type="hidden" name="deleted_applicant" value="" id="del_fpart_appl">

    <?php if(ADD_APPLICANT_STATUS == 1): ?>
    <?php if(ENABLE_BUTTON_ADD_APPLICANT != 0) { ?>
    <!-- <div class='element' id='div_1' style="margin-bottom: 25px; margin-top: 25px">
        <a class="rezaButt buttDanger add" style="color: white; font-size: 15px"> <i class="fa fa-plus-circle"></i>
            Add Applicant
        </a>
    </div> -->
    <?php } endif; ?>
    <!--- Applicant ends here  //////////////////////////////--->

    <!--- Land Owner Details starts here --->
    <?php if(!empty($owners)) { ?>
      <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-user-secret"></i> Land Owner Details

        <?php 

          if(ENABLE_LAND_OWNER_BUTTON == 1) 
          {
            $d      = $settlement->dist_code;
            $s      = $settlement->subdiv_code;
            $c      = $settlement->cir_code;
            $m      = $settlement->mouza_pargona_code;
            $l      = $settlement->lot_no;
            $v      = $settlement->vill_townprt_code;
            $dag    = trim($settlement->dag_no);
            $pcode  = trim($settlement->patta_type_code);
            $pno    = trim($settlement->patta_no);
            $case   = trim($settlement->case_no);

            echo "<span class='pull-right'>
            <button type='button' class='btn btn-sm btn-warning'
            style='margin-top:-5px !important; font-weight: bold;'
            onclick=\"popUpLandOwnerModal('$d', '$s', '$c', '$m', '$l', '$v', '$dag', '$pcode', '$pno', '$case')\">
            <i class='fa fa-user'></i>&nbsp;Edit Land Owner Detail(s)</button></span>";
          }
          include(APPPATH."views/SettlementView/include/editLandOwnerDetails.php");
        ?>

      </h5>
      <div class="tableCard">
        <table class="table table-bordered">
          <?php foreach($owners as $owners) { ?>
            <tr>
              <th>Name</th>
              <td colspan="2">
                <input type="text" readonly name="owners_name<?=$owners->id?>" value="<?php if(isset($err_return)){ echo set_value('owners_name'.$owners->id);}else{ echo $owners->pdar_name;}?>" class="form-control input-sm <?php if(form_error('owners_name'.$owners->id)){echo 'is-invalid';}?>">
                <?=form_error('owners_name'.$owners->id)?>
              </td>
              <th>Father's name</th>
              <td colspan="2">
                <input type="text" readonly name="owners_guardian<?=$owners->id?>" value="<?php if(isset($err_return)){ echo set_value('owners_guardian'.$owners->id);}else{ echo $owners->pdar_guardian;}?>" class="form-control input-sm <?php if(form_error('owners_guardian'.$owners->id)){echo 'is-invalid';}?>" >
                <?=form_error('owners_guardian'.$owners->id)?>
              </td>
            </tr>
            <tr>
              <th> Mobile No.</th>
              <td colspan="2">
                <input type="text" readonly class="form-control <?php if(form_error('owners_mobile_number'.$owners->id)){echo 'is-invalid';}?>" name="owners_mobile_number<?=$owners->id?>" value="<?php if(isset($err_return)){ echo set_value('owners_mobile_number'.$owners->id);}else{ if($owners->pdar_mobile == '' || $owners->pdar_mobile == null || $owners->pdar_mobile == 'NA' || $owners->pdar_mobile == 'na' || $owners->pdar_mobile == '-1'){ echo 'NA';}else{ echo $owners->pdar_mobile;}}?>">
                <?=form_error('owners_mobile_number'.$owners->id)?>
              </td>
              <th>In place/Along with</th>

              <input type="hidden" name="owners_pdar_id<?=$owners->id?>" value="<?php if(isset($err_return)){ echo set_value('owners_pdar_id'.$owners->id);}else{ echo $owners->id;}?>">
              <input type="hidden" name="owners_pdar_type<?=$owners->id?>" value="O">

              <td colspan="2">
                <select name="owners_in_place<?=$owners->id?>" id="" class="inplace-along input_editable_background form-control <?php if(form_error('owners_in_place'.$owners->id)){echo 'is-invalid';}?>" required>
                    <option value="">Select...</option>
                    <option value="i" <?php if(isset($err_return)){ if (set_value('owners_in_place'.$owners->id) == "i") { echo "selected"; }}?>>In Place</option>
                    <option value="a" <?php if(isset($err_return)){ if (set_value('owners_in_place'.$owners->id) == "a") { echo "selected"; }}?>>Along with</option>
                </select>
                <?=form_error('owners_in_place'.$owners->id)?>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>
    <?php } ?>
    <!--- Land Owner Details ends here  //////////////////////////////--->

    <!--- Bhumiputra Details starts here --->
    <?php if($basic["bhumiputra_certificate_no"]){?>
      <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
      </h5>
      <div class="tableCard">
        <table class="table table-bordered">
          <tr>
            <th>Bhumiputra Certificate/Ack verified?</th>
            <td align="center">

              <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="YES" <?php if(trim($basic['bhumiputra_confirmation']) == YES){echo "checked";} ?>>
              <label for="bhumi_confirmation">Yes</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


              <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="NO" <?php if(trim($basic['bhumiputra_confirmation']) == NO){echo "checked";} ?>>
              <label for="bhumi_confirmation">No</label>

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
      <!-- new premium addition -->
      <?php foreach($dags_result as $dagspremlm){ ?>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong style="color:red"> Area Type for Dag No : <?=$dagspremlm->dag_no?></strong></span>
                    <?=form_error('area'.$dagspremlm->dag_no)?>
                </div>

                <div class="col-md-6">
                
                <input type="hidden" name='area_new<?=$dagspremlm->dag_no?>' id='area_new' value='<?=$this->utilityclass->getAreaCategory($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                <?=form_error('area_new'.$dagspremlm->dag_no)?>
                <input readonly class="form-control" type="text" name='area_cat_new<?=$dagspremlm->dag_no?>' id='area_cat_new' value='<?=$this->utilityclass->getAreaName($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                </div>
            </div>

            
      <?php }?>
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
                foreach($dags as $dags_ap){

                  $applId = $this->utilityclass->getApplidFromCaseNo($dags_ap->case_no);
            ?>
              <tr class="bg-white">
                <th rowspan="6" style="vertical-align : middle;">
                  <div class="vertical">
                    DAG : <span class="text-danger"><?=$dags_ap->dag_no?></span> | 
                    PATTA : <span class="text-danger"><?=$dags_ap->patta_no?> | <?=$this->utilityclass->getPattaType($dags_ap->patta_type_code)?></span>

                    <input type="hidden" name="dag_no" value='<?=$dags_ap->dag_no?>' class="form-control input-sm" readonly>
                    
                    <input type="hidden" name="patta_no" id="patta_no" class="form-control input-sm" value='<?=$dags_ap->patta_no;?>' readonly>

                    <input type="hidden" name="patta_type_code" value='<?=$dags_ap->patta_type_code?>' class="form-control input-sm" >

                    <input type="hidden" name="patta_type_code_display" value='<?=$this->utilityclass->getPattaType($dags_ap->patta_type_code)?>' class="form-control input-sm" readonly>
                  </div>
                </th>
                <td><strong>Total Land Area in Selected Dag</strong></td>

                <td style="text-align: center;">
                  <strong>
                    <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags_ap->dag_area_b?>" readonly>
                  </strong>
                </td>
                <td style="text-align: center;">
                  <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags_ap->dag_area_k?>" class="form-control input-sm" readonly>
                </td>
                <td style="text-align: center;">
                  <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags_ap->dag_area_lc?>" readonly>
                </td>
                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td style="text-align: center;">
                    <input type="text" style="text-align: center;" value="<?=$dags_ap->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly>
                  </td>
                  <td style="text-align: center;">
                    <input type="text" style="text-align: center;" value="<?=$dags_ap->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly>
                  </td>
                <?php endif; ?>
              </tr>

              <!-- Area for NR as per DEED/Aggreement -->
              <tr class="bg-white">
                <td class="enc-area-color">
                  <strong>Area for NR as per DEED/Aggreement<br> (Provided by applicant)</strong>
                  <span class="<?php if(form_error('appAreaLessaValidation') || form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                  <?=form_error('appAreaLessaValidation');?>
                  <?=form_error('appAreaMoreThanDagA');?>
                </td>

                <td class="enc-area-color" style="text-align: center;">
                  <input type="number" style="text-align: center;" name="nr_bigha" id="nr_bigha" class="form-control input-sm nr_bigha <?php if(form_error('nr_bigha')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('nr_bigha');}else{ echo $dags_ap->nr_bigha;}?>" >
                  <?=form_error('nr_bigha')?>
                </td>

                <td class="enc-area-color" style="text-align: center;">
                    <input type="number" style="text-align: center;" name="nr_katha" id="nr_katha" value="<?php if(isset($err_return)){ echo set_value('nr_katha');}else{ echo $dags_ap->nr_katha;}?>" class="form-control input-sm nr_katha <?php if(form_error('nr_katha')){echo 'is-invalid';}?>" >
                    <?=form_error('nr_katha')?>
                </td>

                <td class="enc-area-color" style="text-align: center;">
                    <input type="number" style="text-align: center;" name="nr_lessa" id="nr_lessa" class="form-control input-sm nr_lessa <?php if(form_error('nr_lessa')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('nr_lessa');}else{ echo $dags_ap->nr_lessa;}?>" >
                    <?=form_error('nr_lessa')?>
                </td>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td class="enc-area-color" style="text-align: center;">
                    <input type="number" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('nr_ganda');}else{ echo $dags_ap->nr_ganda;}?>" class="form-control input-sm nr_ganda <?php if(form_error('nr_ganda')){echo 'is-invalid';}?>" name="nr_ganda" id="nr_ganda" >
                    <?=form_error('nr_ganda')?>
                  </td>
                  <td class="enc-area-color" style="text-align: center;">
                    <input type="number" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('nr_kranti');}else{ echo $dags_ap->nr_kranti;}?>" class="form-control input-sm nr_kranti <?php if(form_error('nr_kranti')){echo 'is-invalid';}?>" name="nr_kranti"  id="nr_kranti">
                    <?=form_error('nr_kranti')?>
                  </td>
                <?php endif; ?>
              </tr>



               <!-- Area for home -->
               <tr class="bg-white">
                <td class="settlement-area-color">
                    <strong class="text-danger">Area for Settlement (Homestead)</strong>
                    <span class="<?php if(form_error('appAreaLessaValidation') || form_error('appAreaMoreThanDagA') || form_error('totalSettlementAreaNotMatchHomeAgri')){echo 'is-invalid';}?>"></span>
                    <?=form_error('appAreaLessaValidation');?>
                    <?=form_error('appAreaMoreThanDagA');?>
                    <?=form_error('totalSettlementAreaNotMatchHomeAgri');?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="home_b" id="home_b" class="form-control input_editable_background input-sm home_b <?php if(form_error('home_b')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('home_b');}else{ echo $dags_ap->home_b;}?>" >
                  <?=form_error('home_b')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="home_k" id="home_k" value="<?php if(isset($err_return)){ echo set_value('home_k');}else{ echo $dags_ap->home_k;}?>" class="form-control input_editable_background input-sm home_k <?php if(form_error('home_k')){echo 'is-invalid';}?>" >
                  <?=form_error('home_k')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="home_lc" id="home_lc" class="form-control input_editable_background input-sm home_lc <?php if(form_error('home_lc')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('home_lc');}else{ echo $dags_ap->home_lc;}?>" >
                  <?=form_error('home_lc')?>
                </td>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('home_g');}else{ echo $dags_ap->home_g;}?>" class="form-control input_editable_background input-sm home_g <?php if(form_error('home_g')){echo 'is-invalid';}?>" name="home_g" id="home_g" >
                    <?=form_error('home_g')?>
                  </td>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('home_kr');}else{ echo $dags_ap->home_kr;}?>" class="form-control input_editable_background input-sm home_kr <?php if(form_error('home_kr')){echo 'is-invalid';}?>" name="home_kr"  id="home_kr">
                    <?=form_error('home_kr')?>
                  </td>
                <?php endif; ?>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))) { ?>
                  <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
                <?php } else { ?>
                  <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
                <?php } ?>

              </tr>

              <!-- Area for home -->
              <tr class="bg-white">
                <td class="settlement-area-color">
                    <strong class="text-danger">Area for Settlement (Agriculture)</strong>
                    <span class="<?php if(form_error('appAreaLessaValidation') || form_error('appAreaMoreThanDagA') || form_error('totalSettlementAreaNotMatchHomeAgri')){echo 'is-invalid';}?>"></span>
                    <?=form_error('appAreaLessaValidation');?>
                    <?=form_error('appAreaMoreThanDagA');?>
                    <?=form_error('totalSettlementAreaNotMatchHomeAgri');?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="agri_b" id="agri_b" class="form-control input_editable_background input-sm agri_b <?php if(form_error('agri_b')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('agri_b');}else{ echo isset($dags_ap->agri_b) ? $dags_ap->agri_b:0;}?>" >
                  <?=form_error('agri_b')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="agri_k" id="agri_k" value="<?php if(isset($err_return)){ echo set_value('agri_k');}else{ echo isset($dags_ap->agri_k) ? $dags_ap->agri_k:0;}?>" class="form-control input_editable_background input-sm agri_k <?php if(form_error('agri_k')){echo 'is-invalid';}?>" >
                  <?=form_error('agri_k')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="agri_lc" id="agri_lc" class="form-control input_editable_background input-sm agri_lc <?php if(form_error('agri_lc')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('agri_lc');}else{ echo isset($dags_ap->agri_lc) ? $dags_ap->agri_lc:0;}?>" >
                  <?=form_error('agri_lc')?>
                </td>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('agri_g');}else{ echo isset($dags_ap->agri_g) ? $dags_ap->agri_g : 0 ;}?>" class="form-control input_editable_background input-sm agri_g <?php if(form_error('agri_g')){echo 'is-invalid';}?>" name="agri_g" id="agri_g" >
                    <?=form_error('agri_g')?>
                  </td>
                  <td class="settlement-area-color" style="text-align: center;">a
                    <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('agri_kr');}else{ echo isset($dags_ap->agri_kr) ? $dags_ap->agri_kr : 0;}?>" class="form-control input_editable_background input-sm agri_kr <?php if(form_error('agri_kr')){echo 'is-invalid';}?>" name="agri_kr"  id="agri_kr">
                    <?=form_error('agri_kr')?>
                  </td>
                <?php endif; ?>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))) { ?>
                  <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
                <?php } else { ?>
                  <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
                <?php } ?>

              </tr>

                <!-- Area for Settlement -->
                <tr class="bg-white">
                <td class="settlement-area-color">
                    <strong class="text-danger">Total Area for Settlement</strong>
                    <span class="<?php if(form_error('appAreaLessaValidation') || form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                    <?=form_error('appAreaLessaValidation');?>
                    <?=form_error('appAreaMoreThanDagA');?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_b" id="s_dag_area_b" class="form-control input_editable_background input-sm s_dag_area_b <?php if(form_error('s_dag_area_b')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_b');}else{ echo $dags_ap->s_dag_area_b;}?>" >
                  <?=form_error('s_dag_area_b')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_k" id="s_dag_area_k" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_k');}else{ echo $dags_ap->s_dag_area_k;}?>" class="form-control input_editable_background input-sm s_dag_area_k <?php if(form_error('s_dag_area_k')){echo 'is-invalid';}?>" >
                  <?=form_error('s_dag_area_k')?>
                </td>

                <td class="settlement-area-color" style="text-align: center;">
                  <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" name="s_dag_area_lc" id="s_dag_area_lc" class="form-control input_editable_background input-sm s_dag_area_lc <?php if(form_error('s_dag_area_lc')){echo 'is-invalid';}?>" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_lc');}else{ echo $dags_ap->s_dag_area_lc;}?>" >
                  <?=form_error('s_dag_area_lc')?>
                </td>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))): ?>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_g');}else{ echo $dags_ap->s_dag_area_g;}?>" class="form-control input_editable_background input-sm s_dag_area_g <?php if(form_error('s_dag_area_g')){echo 'is-invalid';}?>" name="s_dag_area_g" id="s_dag_area_g" >
                    <?=form_error('s_dag_area_g')?>
                  </td>
                  <td class="settlement-area-color" style="text-align: center;">
                    <input type="number" onkeyup="totalAreaCal()" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('s_dag_area_kr');}else{ echo $dags_ap->s_dag_area_kr;}?>" class="form-control input_editable_background input-sm s_dag_area_kr <?php if(form_error('s_dag_area_kr')){echo 'is-invalid';}?>" name="s_dag_area_kr"  id="s_dag_area_kr">
                    <?=form_error('s_dag_area_kr')?>
                  </td>
                <?php endif; ?>

                <?php if((in_array($dags_ap->dist_code, json_decode(BARAK_VALLEY)))) { ?>
                  <input type="hidden" value="1" id="barak_valley"> <!-- if barak valley -->
                <?php } else { ?>
                  <input type="hidden" value="0" id="barak_valley"> <!-- other than barak valley -->
                <?php } ?>

              </tr>

              <tr class="bg-white">
              
                <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                  <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$applId;?>&dag=<?=$dags_ap->dag_no;?>">
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

    <!--- Nominee details starts here --->
    <h5 class="reza-title" style="margin-top: 50px">
        <i class="fa fa-users"></i>  Family Details
        <?php if(ENABLE_FAMILY_BUTTON != 0){?>
                <span class="pull-right"><button type="button" onclick="addFamily();" class="btn btn-sm btn-warning" style="margin-top:-5px !important">Add Family</button></span>
        <?php } ?>
    </h5>
    <?php if(!empty($nextKin)) { ?>
      
      <div class="tableCard">
        <table class="table table-bordered" id="listNextOfKin">
          <tr>
            <th>Name</th>
            <th>Relation</th>
            <th>Address</th>
            <th>Mobile number</th>
          </tr>
          <?php $i=1; foreach($nextKin as $kin): ?>
            <tr id="sp<?=$kin->id?>">
              <td>
                <input type="text" readonly name="kin_name[]" value="<?=$kin->nominee_name?>" class="form-control">
              </td>
              <td>
                <input type="hidden" name="kin_relation[]" value="<?=$kin->relation?>" class="form-control">
                <input type="text" name="kin_relation_display" value="<?=$this->utilityclass->appRelationbyIDMB2($kin->relation)?>" class="form-control" readonly>
              </td>
              <td>
                <input type="text" class="form-control" value="<?=$kin->address?>" name="kin_address[]" readonly>
              </td>
              <td>
                <input type="text" name="kin_contact_no[]" value="<?=$kin->mobile_no?>" class="form-control" readonly>
              </td>
              <td>
                <?php if(ENABLE_FAMILY_BUTTON != 0){?>
                    <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add</button>
                    <button type="button" onclick="confirmDeleteFamily(<?=$kin->id?>);" class="btn btn-sm btn-danger">Delete</button>
                <?php } ?>
              </td>
            </tr>
          <?php $i++; endforeach;?>
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
    <!--- Nominee details ends here  //////////////////////////////--->


    <!--- Supporting Documents starts here --->
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
              <input type="hidden" name="mut_type" value="<?=$app['service_code']?>">
            </th>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <!--- Supporting Documents ends here  //////////////////////////////--->
  </div>
</div>






<!-- <ul class="list-inline pull-right"  style="margin-top: 20px">
  <li>
    <button type="button" class="btn btn-primary next-step">
      <i class="fa fa-arrow-circle-right"> </i>  <?php //echo $this->lang->line('next'); ?>
    </button>
  </li>
</ul> -->

<script>

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
                $("#div_" + nextindex).append("<table class='table table-bordered' id='applicantrow_"+ nextindex +"'> <tr> <th rowspan='5' style='vertical-align : middle;text-align:center;'>1</th> <th>Name of the applicant</th> <td colspan='2'> <input type='text' name='pdar_name2[]' required class='form-control input-sm'> </td> <th>Guardian name</th> <td colspan='2'> <input type='text' name='pdar_guardian2[]' required class='form-control input-sm' > </td> </tr> <tr> <th>Relation</th> <td> <select name='pdar_rel_guar2[]' id='pdar_rel_guar"+ nextindex +"' class='form-control' required> <option value='1' >Mother</option> <option value='2' selected>Father</option> <option value='3' >Husband</option> <option value='4' >Wife</option> <option value='5' >Guardian</option> <option value='6' >Supdt.Mother</option> <option value='7' >Guardian</option> </select> </td> <th>Gender</th> <td> <select name='pdar_gender2[]' id='pdar_gender"+ nextindex +"' class='form-control' > <option value='1' selected>Male</option> <option value='2' >Female</option> <option value='3' >Others</option> </select> </td> <th>Mobile</th> <td> <input type='text' name='pdar_mobile2[]' class='form-control input-sm' > </td> </tr> <tr> <th> Permanent address </th> <td colspan='2'> <input type='text' name='pdar_add12[]' class='form-control input-sm'> </td> <th>Present address</th> <td colspan='2'> <input type='text' name='pdar_add22[]' class='form-control input-sm' > </td> </tr><tr><td><span id='remove_" + nextindex + "' class='remove'><i class='fa fa-trash-o' style='font-size:32px;color:red'></i></span></td></tr> </table>&nbsp;");

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

<!-- for blinking the check errors tag -->
<script>
    var blink = document.getElementById('blink');

    setInterval(function () {
        blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 500);


    // function totalAreaCal(){
    //     reset();
    // }


    <?php
    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) {
    ?>
    function totalAreaCal(){
        // for homestead
        reset();

        var total_settlement_area = 0;
        var total_area = 0;
        var mbigha = parseFloat($("#home_b").val());
        var mkatha = parseFloat($("#home_k").val());
        var mlessa = parseFloat($("#home_lc").val());
        var mganda = parseFloat($("#home_g").val());

        total_area = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
      

        // for agri
        var bigha_s = 0;
        var katha_s = 0;
        var lessa_s = 0;
        var ganda_s = 0;
        var total_agri_area = 0;
        var mbigha_agri = parseFloat($("#agri_b").val());
        var mkatha_agri = parseFloat($("#agri_k").val());
        var mlessa_agri = parseFloat($("#agri_lc").val());
        var mganda_agri = parseFloat($("#agri_g").val());

        total_agri_area = ((mbigha_agri * 6400) + (mkatha_agri * 320) + (mlessa_agri * 20) + mganda_agri);

        total_settlement_area =  total_area + total_agri_area;
        

        bigha_s = Math.floor(total_settlement_area / 6400);
        katha_s = Math.floor((total_settlement_area - bigha_s * 6400) / 320);
        lessa_s = Math.floor((total_settlement_area - (bigha_s * 6400) - (katha_s * 320)) / 20);
        ganda_s = total_settlement_area - bigha_s * 6400 - katha_s * 320 - lessa_s * 20;

        $("#s_dag_area_b").val(bigha_s);
        $("#s_dag_area_k").val(katha_s);
        $("#s_dag_area_lc").val(lessa_s);
        $("#s_dag_area_g").val(ganda_s);
        
    }

    <?php
    } else {?>
    function totalAreaCal(){
        // for homestead
        reset();
        var total_settlement_area = 0;
        var total_area = 0;

        var mbigha = parseFloat($("#home_b").val());
        var mkatha = parseFloat($("#home_k").val());
        var mlessa = parseFloat($("#home_lc").val());
        total_area = ((mbigha * 100) + (mkatha * 20) + mlessa);
        

        // for agri
        var bigha_s = 0;
        var katha_s = 0;
        var lessa_s = 0;
        var total_agri_area = 0;
        var mbigha_agri = parseFloat($("#agri_b").val());
        var mkatha_agri = parseFloat($("#agri_k").val());
        var mlessa_agri = parseFloat($("#agri_lc").val());

        total_agri_area = ((mbigha_agri * 100) + (mkatha_agri * 20) + mlessa_agri);

        total_settlement_area =  total_area + total_agri_area;


        var bigha_s = Math.floor(total_settlement_area / 100);
        var katha_s = Math.floor((total_settlement_area - bigha_s * 100) / 20);
        var lessa_s = total_settlement_area - bigha_s * 100 - katha_s * 20;

        $("#s_dag_area_b").val(bigha_s);
        $("#s_dag_area_k").val(katha_s);
        $("#s_dag_area_lc").val(lessa_s);

    }

    

    <?php }?>


</script>
<?php include(APPPATH."views/SettlementView/include/editApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editApplicantDetails.js"></script>
<?php include(APPPATH."views/SettlementView/include/addApplicantDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/addApplicantDetails.js"></script>
<?php include(APPPATH."views/SettlementView/include/editFamilyDetails.php"); ?>
<script src="<?php echo base_url();?>js/mb2/editFamilyDetails.js"></script>
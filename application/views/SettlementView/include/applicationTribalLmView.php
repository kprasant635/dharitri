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
</style>

<?php 
  if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    $lessa_chatak='Chatak'; }
  else{
    $lessa_chatak='Lessa';
  }
?>

<div class="tab-pane active" role="tabpanel" id="step1">
    <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
        Settlement of  Tribal Community (
        <span class="bg-warning"><?=$_GET['case']?></span> )
    </h5>
    <div class="reza-card ">
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


                            <tr>
                                <th> Name in <?=$aadhar->type?> </th>
                                <td>
                                    <?php
                                        if($aadhar->aadhaar_no || $aadhar->pan_no){
                                            foreach($applicants_buyers as $doc_name):
                                                if($doc_name->is_applicant == 1):
                                            ?>
                                                <strong class="alert-warning">
                                                    <?=$doc_name->eng_pdar_name?>
                                                </strong>
                                            <?php
                                                endif;
                                            endforeach;
                                        }
                                    ?>

                                </td>
                            </tr>



                            <tr>
                                <th style="width: 50%">Aadhaar Verified</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php if ($aadhar->is_aadhaar_verify == '1') {echo 'Yes';}?>
                                    </strong>
                                </td>
                            </tr>
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
                            <?php if (isset($basic["tribal_belt"])) { ?>
                                <tr>
                                    <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                                    <td>
                                        <strong class="alert-warning"><?=$basic["tribal_belt"]?></strong>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th>Total Applications applied by this applicant</th>
                                <td>
                                    <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?=$basic["applid"];?>">
                                        <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>




            <h5 class="reza-title" style="margin-top: 15px">
                <i class="fa fa-map-marker"></i> Address Information
            </h5>
            <div class="tableCard ">
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
                                <?=$this->utilityclass->getSubDivName($basic["dist_code"],$basic["subdiv_code"])?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Circle Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?>
                            </strong>
                        </td>
                        <th>Mouza Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Village Name: </th>
                        <td class="text-warning">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?>
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
                    foreach($selfDeclarationDetails[0] as $key=>$self){
                        ?>
                        <tr>
                            <th><?=$self->name ?></th>
                            <td class="text-center">
                                <strong>
                                    <?php if ($self->status == "1"){ echo "Yes"; }?>
                                    <?php if ($self->status == "0"){ echo "No"; } ?>
                                </strong>
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user"></i>  Applicant details
            </h5>
            <?php $i=1; foreach($applicants_buyers as $settlement): ?>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="5"  style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                            <th width="18%">Applicant Name (Assamese)</th>
                            <td width="30%">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_name;?>
                                </strong>
                            </td>
                            <th width="18%">Guardian Name (Assamese)</th>
                            <td width="30%">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_guardian;?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th width="18%">Applicant Name (English)</th>
                            <td width="30%">
                                <strong class="alert-warning">
                                    <?=$settlement->eng_pdar_name;?>
                                </strong>
                            </td>
                            <th width="18%">Guardian Name (English)</th>
                            <td width="30%">
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
                                    if($settlement->pdar_rel_guar == "1"){
                                        echo "Mother";
                                    }
                                    if($settlement->pdar_rel_guar == "2"){
                                        echo "Father";
                                    }
                                    if($settlement->pdar_rel_guar == "3"){
                                        echo "Husband";
                                    }
                                    if($settlement->pdar_rel_guar == "4"){
                                        echo "Wife";
                                    }
                                    if($settlement->pdar_rel_guar == "5"){
                                        echo "Guardian";
                                    }
                                    if($settlement->pdar_rel_guar == "6"){
                                        echo "Supdt.Mother";
                                    }
                                    ?>
                                </strong>
                            </td>
                            <th>Gender</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    if($settlement->pdar_gender == "1"){
                                        echo "Male";
                                    }
                                    if($settlement->pdar_gender == "2"){
                                        echo "Female";
                                    }
                                    if($settlement->pdar_gender == "3"){
                                        echo "Others";
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_mobile?>
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
                        <tr>
                            <th>Present address</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_add2?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php $i++;?>
            <?php endforeach;?>


            <?php if ($applicants_encroacher == true) { ?>
                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-user-secret"></i>  Occupier Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <?php $enc_count = 1; foreach ($applicants_encroacher as $riotee) { ?>
                            <tr >
                                <th rowspan="2" style="vertical-align : middle;text-align:center; min-width: 4%!important; max-width: 4%!important; width: 4%">
                                    <?=$enc_count++;?>
                                </th>
                                <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Occupier`s Name</th>
                                <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                    <strong class="alert-warning">
                                        <?=$riotee->pdar_name;?>
                                    </strong>
                                </td>
                                <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Father`s Name</th>
                                <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                    <strong class="alert-warning">
                                        <?=$riotee->pdar_guardian;?>
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <th>Possession Since</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?=$riotee->period_possession;?>
                                    </strong>
                                </td>
                                <th>
                                    Dag No
                                </th>
                                <td>
                                    <strong class="alert-warning">
                                        <?=$riotee->dag_no;?>
                                    </strong>
                                </td>
                            </tr>



                        <?php }
                         include(APPPATH."views/SettlementView/include/encroacherNotEligibleCoView.php");
                        ?>
                    </table>
                </div>
            <?php }?>

            <?php if($basic["bhumiputra_certificate_no"]){ ?>
                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bhumiputra certificate/ack verified?</th>
                            <td align="center">

                                <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="YES" <?php if(trim($basic['bhumiputra_confirmation']) == YES){echo "checked";} ?>>
                                <label for="bhumi_confirmation">Yes</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                                <input disabled type="radio" style="margin: 4px 4px 5px -15px;;"  name="bhumiputra_confirmation" id="" class="form-check-input" value="NO" <?php if(trim($basic['bhumiputra_confirmation']) == NO){echo "checked";} ?>>
                                <label for="bhumi_confirmation">No</label>

                            </td>
                            <td>
                                <input type="hidden" name="bhumiputra_certificate_no" value="<?=$basic["bhumiputra_certificate_no"]?>">
                                Certificate/Ack number : <b><?=$basic["bhumiputra_certificate_no"]?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php }?>

            <?php if (!empty($nominee)) {?>
                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-users"></i>  Family Details
                </h5>
                <div class="tableCard">
                    <table class="table  table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Relation</th>
                            <th>Address</th>
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

                                </tr>
                              <?php $i++;?>
                              <?php endforeach;?>
                    </table>
                </div>
            <?php }?>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-map"></i>  Area Details
            </h5>
            <div class="tableCard">

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
                </thead>
                <tbody>
                  <?php foreach($dags as $dags_area){ ?>

                    <tr class="bg-white">
                      <th rowspan="6" style="vertical-align : middle;">
                        <div class="vertical">
                          DAG : <span class="text-danger"><?=$dags_area->dag_no?></span> | 
                          PATTA : <span class="text-danger"><?=$dags_area->patta_no?> | <?=$this->utilityclass->getPattaType($dags_area->patta_type_code)?></span>
                        </div>
                      </th>
                      <td><strong>Total Land Area in Selected Dag</strong></td>
                      <td style="text-align: center;">
                        <strong><?=$dags_area->dag_area_b?></strong>
                        <input type="hidden" readonly style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags_area->dag_area_b?>" >
                      </td>
                      <td style="text-align: center;">
                        <strong><?=$dags_area->dag_area_k?></strong>
                        <input type="hidden" readonly style="text-align: center;" name="dag_area_k" value="<?=$dags_area->dag_area_k?>" class="form-control input-sm" >
                      </td>
                      <td style="text-align: center;">
                        <strong><?=$dags_area->dag_area_lc?></strong>
                        <input type="hidden" readonly style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags_area->dag_area_lc?>" >
                      </td>
                      <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td style="text-align: center;">
                          <strong><?=$dags_area->dag_area_g?></strong>
                          <input type="hidden" readonly style="text-align: center;" value="<?=$dags_area->dag_area_g?>" class="form-control input-sm" name="dag_area_g" >
                        </td>
                        <td class="hide" style="text-align: center;">
                          <strong><?=$dags_area->dag_area_kr?></strong>
                          <input type="hidden" readonly style="text-align: center;" value="<?=$dags_area->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" >
                        </td>
                      <?php endif ; ?>
                    </tr>

                    <?php                            
                      $enc_area = json_decode($dags_area->encroachement_area);
                      if($enc_area != null) {
                    ?>
                    <!-- encroacher homestead -->
                    <tr class="bg-white">
                      <td class="enc-area-color"><strong>Encroachment Area (Homestead)</strong></td>
                      <td class="enc-area-color" style="text-align: center;">
                        <strong><?=$enc_area->homestead->bigha?></strong>
                        <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->homestead->bigha?>" readonly>
                      </td>
                      <td class="enc-area-color" style="text-align: center;">
                        <strong><?=$enc_area->homestead->katha?></strong>
                        <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->homestead->katha?>" readonly>
                      </td>
                      <td class="enc-area-color" style="text-align: center;">
                        <strong><?=$enc_area->homestead->lessa?></strong>
                        <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->homestead->lessa?>" readonly>
                      </td>
                      <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td class="enc-area-color" style="text-align: center;">
                          <strong><?=$enc_area->homestead->ganda?></strong>
                          <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->homestead->ganda?>" readonly>
                        </td>
                        <td class="enc-area-color" style="text-align: center;">
                          <strong><?=$enc_area->homestead->kranti?></strong>
                          <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->homestead->kranti?>" readonly>
                        </td>
                      <?php endif;?>
                    </tr>
                    <!-- encroacher agriculture -->
                    <tr class="bg-white">
                      <td class="enc-area-color"><strong>Encroachment Area (Agriculture)</strong></td>
                      <td class="enc-area-color" style="text-align: center;">
                        <strong><?=$enc_area->agriculture->bigha?></strong>
                        <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->agriculture->bigha?>" readonly>
                      </td>
                      <td class="enc-area-color" style="text-align: center;">
                        <strong><?=$enc_area->agriculture->katha?></strong>
                        <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->agriculture->katha?>" readonly>
                      </td>
                      <td class="enc-area-color" style="text-align: center;">
                        <strong><?=$enc_area->agriculture->lessa?></strong>
                        <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->agriculture->lessa?>" readonly>
                      </td>
                      <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td class="enc-area-color" style="text-align: center;">
                          <strong><?=$enc_area->agriculture->ganda?></strong>
                          <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->agriculture->ganda?>" readonly>
                        </td>
                        <td class="enc-area-color" style="text-align: center;">
                          <strong><?=$enc_area->agriculture->kranti?></strong>
                          <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->agriculture->kranti?>" readonly>
                        </td>
                      <?php endif;?>
                    </tr>  
                    <?php } ?>

                    <!-- area settlement homestead -->
                    <?php $hide = 'area_show';
                      if ($dags_area->land_type == 3 || $dags_area->land_type == 1) {
                        $hide = 'area_show';
                      } else {
                        $hide = 'area_hide';
                      }
                    ?>
                    <tr class='<?=$hide?>' class="bg-white">
                      <td class="settlement-area-color"><strong>Area for Settlement (Homestead)</strong></td>
                      <td class="settlement-area-color" style="text-align:center">
                        <strong><?=$dags_area->home_b?></strong>
                        <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$dags_area->home_b?>" readonly>
                      </td>
                      <td class="settlement-area-color" style="text-align:center">
                        <strong><?=$dags_area->home_k?></strong>
                        <input type="hidden" style="text-align: center;" name="home_k" value="<?=$dags_area->home_k?>" class="form-control input-sm home_k" readonly>
                      </td>
                      <td class="settlement-area-color" style="text-align:center">
                        <strong><?=$dags_area->home_lc?></strong>
                        <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$dags_area->home_lc?>" class="form-control input-sm home_lc" readonly>
                      </td>
                      <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td class="settlement-area-color" style="text-align:center">
                          <strong><?=$dags_area->home_g?></strong>
                          <input type="hidden" style="text-align: center;" value="<?=$dags_area->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                        </td>
                        <td class="settlement-area-color" style="text-align:center">
                          <strong><?=$dags_area->home_kr?></strong>
                          <input type="hidden" style="text-align: center;" value="<?=$dags_area->home_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
                        </td>
                      <?php endif; ?>
                    </tr>

                    <!-- area settlement agriculture -->
                    <?php 
                      $hide = 'area_show';
                      if ($dags_area->land_type == 2) {
                        $hide = 'area_show';
                      } else {
                        $hide = 'area_hide';
                      }
                    ?>
                    <tr class='<?=$hide?>' class="bg-white">
                      <td class="settlement-area-color"><strong>Area for Settlement (Agriculture)</strong></td>
                      <td class="settlement-area-color" style="text-align:center">
                        <strong><?=$dags_area->agri_b?></strong>
                        <input type="hidden" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$dags_area->agri_b?>" readonly>
                      </td>
                      <td class="settlement-area-color" style="text-align:center">
                        <strong><?=$dags_area->agri_k?></strong>
                        <input type="hidden" style="text-align: center;" name="agri_k" value="<?=$dags_area->agri_k?>" class="form-control input-sm agri_k" readonly>
                      </td>
                      <td class="settlement-area-color" style="text-align:center">
                        <strong><?=$dags_area->agri_lc?></strong>
                        <input type="hidden" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$dags_area->agri_lc?>" readonly>
                      </td>
                      <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td class="settlement-area-color" style="text-align:center">
                          <strong><?=$dags_area->agri_g?></strong>
                          <input type="hidden" style="text-align: center;" value="<?=$dags_area->agri_g?>" class="form-control input-sm agri_g" name="agri_g" readonly>
                        </td>
                        <td class="settlement-area-color" style="text-align:center">
                          <strong><?=$dags_area->agri_kr?></strong>
                          <input type="hidden" style="text-align: center;" value="<?=$dags_area->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" readonly>
                        </td>
                      <?php endif;?>
                    </tr>

                    <tr class="bg-white">
                      <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                        <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$basic["applid"];?>&dag=<?=$dags_area->dag_no;?>">
                            <small style="font-size:14px; color:white; font-weight:bold">
                                <i class="fa fa-eye"></i> View Total Applications in this Dag
                            </small>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>

                  <?php
                        // for dag not eligible
                        include(APPPATH."views/SettlementView/include/dagNotEligibleCoView.php");
                    ?>
                </tbody>
              </table>
            </div>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Supporting Documents
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php foreach($document as $d): ?>
                        <tr>
                            <th>
                                <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                <!-- <input type="hidden" name="case_no" value="<?=$d->case_no;?>"> -->
                                <!-- <input type="hidden" name="user_code" value="<?=$d->user_code;?>"> -->
                                <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
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
            <button id="next_id" type="button" class="btn btn-primary next-step">
                <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
            </button>
        </li>
    </ul>
</div>



<!-- LM reporting starts here -->
<div class="tab-pane" role="tabpanel" id="step2">
    <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
        Settlement of  Tribal Community (
        <span class="bg-warning"><?=$_GET['case']?></span> )
    </h5>
    <div class="reza-card">
        <div class="reza-body">
            <h5  class="reza-title" style="margin-top: 15px">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
            </h5>
            <div class="tableCard">

                <?php $i=1; foreach($lmnotes as $lmnote):
                    if($validation_bypass == 0):
                    
                        ?>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Chitha Verified?</span>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="chiitha_verified"
                                            id="chiitha_verified1"
                                            value="YES" disabled <?php if ($lmnote->chitha_verified == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="chiitha_verified"
                                            id="chiitha_verified2"
                                            value="NO" disabled <?php if ($lmnote->chitha_verified == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <?php
                                foreach ($dags as $ddg) {

                                    ?>
                                    <i class="fa fa-link" aria-hidden="true"></i>
                                    <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $ddg->dag_no . '&m=' . $basic["mouza_pargona_code"] . '&l=' . $basic["lot_no"] . '&v=' . $basic["vill_townprt_code"] . '&p=' . $ddg->patta_type_code . '&dist=' . $basic["dist_code"] . '&cir=' . $basic["cir_code"] . '&sub_div=' . $basic["subdiv_code"] ?>">
                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (Chitha)</span></u>
                                    </a>
                                    <br>
                                <?php }?>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> VLB Verified?</span>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="vlb_verified"
                                            id="vlb_verified1"
                                            value="YES" disabled <?php if ($lmnote->vlb_verified == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="vlb_verified"
                                            id="vlb_verified2"
                                            value="NO" disabled <?php if ($lmnote->vlb_verified == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php
                                foreach ($dags as $ddg) {
                                    ?>
                                    <i class="fa fa-link" aria-hidden="true"></i>
                                    <a target='VlbReport' href="<?php echo base_url() . 'index.php/SettlementTribal/vlbEncroacherDetails?dag=' . $ddg->dag_no . '&m=' . $basic["mouza_pargona_code"] . '&l=' . $basic["lot_no"] . '&v=' . $basic["vill_townprt_code"] . '&dist=' . $basic["dist_code"] . '&cir=' . $basic["cir_code"] . '&sub_div=' . $basic["subdiv_code"] ?>" target="VlbReport">
                                        <u><span class="text-primary" style="font-size:16px;">Dag - <?=$ddg->dag_no?> (VLB)</span></u></a>
                                    <br>
                                <?php }?>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                                <?php if($basic['bhumiputra_certificate_no']){?>
                                    <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>

                                <?php }else{ ?>

                                    <label for="" class="alert-warning">Certificate Not Available!</b></label>

                                <?php }?>


                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="bhumiputra_confirmation_lm"
                                            id="bhumiputra_confirmation1"
                                            value="YES"
                                            disabled
                                        <?php if($lmnote->bhumiputra_confirmation == YES){echo "checked";} ?>

                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="bhumiputra_confirmation_lm"
                                            id="bhumiputra_confirmation2"
                                            value="NO"
                                            disabled
                                        <?php if($lmnote->bhumiputra_confirmation == NO){echo "checked";} ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <i class="fa fa-link" aria-hidden="true"></i>
                                <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                                if($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT){
                                    echo "cer_number=".$basic['bhumiputra_certificate_no'];
                                }elseif($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK){
                                    echo "ack_number=".$basic['bhumiputra_certificate_no'];
                                }?>" target="BhumiPutra">
                                    <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                </a>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Schedule of the land and area under occupation?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="possession_verified"
                                            id="possession_verified1"
                                            value="YES" disabled <?php if ($lmnote->possession_verification == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="possession_verified"
                                            id="possession_verified2"
                                            value="NO" disabled <?php if ($lmnote->possession_verification == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6 text-justify">
                                <span><strong><?=$sl_count++?>.</strong> Does applicant falls under protected category?</span>
                                <?=form_error('protected_class_lm')?>
                            </div>
                            <div class="col-md-6 form-group">
                                <select name="protected_class_lm" id="protected_class_lm" class="form-control" required disabled>
                                    <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                                        <option value="<?php echo $class->CODE ?>"
                                            <?php if($lmnote->protected_class_lm == $class->CODE){ echo "selected";} ?>>
                                            <?php echo $class->NAME ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php
                            foreach($applicants_encroacher as $enc_exis_vlb)
                            {
                                ?>
                                <div class="row p-2 <?php if($enc_exis_vlb->encroacher_exist_vlb == 4){ echo "alert-danger"; }?>">
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Is Encroacher Exists in VLB for <strong> Dag no <?=$enc_exis_vlb->dag_no?></strong>? </span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select name="encroacher_exist_vlb" id="encroacher_exist_vlb" class="form-control" disabled>
                                            <?php
                                                foreach(json_decode(ENC_VARIFICATION_LIST) as $enc_list)
                                                {
                                                    ?>
                                                    <option value="<?=$enc_list->CODE?>" <?php if($enc_list->CODE == $enc_exis_vlb->encroacher_exist_vlb){echo 'selected';}?>>
                                                        <?=$enc_list->NAME?>
                                                    </option>
                                                    <?php
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <?php   
                            } 
                        ?>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Whether proposed land is under litigation?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="litigation"
                                            id="landed_property1"
                                            value="YES"
                                            disabled
                                        <?php if($lmnote->litigation == 'YES'){ echo "checked";} ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="litigation"
                                            id="landed_property2"
                                            value="NO"
                                            disabled
                                        <?php if($lmnote->litigation == 'NO'){ echo "checked";} ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Landed property of the petitioner and his family (if any) within the State</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="landed_property"
                                            id="landed_property1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->landed_property == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="landed_property"
                                            id="landed_property2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->landed_property == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Whether the petitioner is ST</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="whether_st"
                                            id="whether_st1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->is_st == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="whether_st"
                                            id="whether_st2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->is_st == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under Tribal Belt/ Block.</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">

                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="whether_tribal"
                                            id="whether_tribal1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->is_tribal_belt == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="whether_tribal"
                                            id="whether_tribal2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->is_tribal_belt == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Whether proposed land is free from Encroachment</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">

                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_free_encroachment"
                                            id="is_free_encroachment1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->is_free_encroachment == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_free_encroachment"
                                            id="is_free_encroachment2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->is_free_encroachment == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2">
                        <div class="col-md-6">
                            <span ><strong><?=$sl_count++?>.</strong> Whether applicant and his/her family has occupied any land in the state ?</span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="is_landless"
                                id="is_landless"
                                value="YES" disabled <?php if ($lmnote->is_landless == YES) {echo "checked";}?>
                            />
                            <label class="form-check-label" for="inlineRadio1">Completely Landless</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                class="form-check-input"
                                type="radio"
                                name="is_landless"
                                id="is_landless"
                                value="NO" disabled <?php if ($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">Landless as per policy / Having Land</label>
                            </div>

                            <?php if($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') { ?>
                            <button class="btn btn-sm btn-warning viewModal" onclick="viewPropertyModal()" type="button"><i class="fa fa-university"></i>&nbsp;View Property</button>

                            <button class="btn btn-sm btn-danger closeModal" style="display:none" onclick="closePropertyModal()" type="button"><i class="fa fa-close"></i>&nbsp;Close Property</button>

                            <div class="addPropertyDetail" style="display:none">
                                <div class="tableCard">
                                <table class="table table-bordered">
                                    <tr>
                                    <th>District</th>
                                    <th>Circle</th>
                                    <th>Area</th>
                                    </tr>

                                    <?php                                 
                                    if($additional_property != null) {                                   
                                    foreach($additional_property as $area) {
                                    ?>
                                    <tr>
                                        <td><?=$area->dist_name?></td>
                                        <td><?=$area->cir_name?></td>
                                        <td>
                                        <b>B:</b> <?=$area->bigha?>;
                                        <b>K:</b> <?=$area->katha?>;
                                        <b>L/C:</b> <?=$area->lessa?>;
                                        <b>G:</b> <?=$area->ganda?>;
                                        <b>Kr:</b> <?=$area->kranti?> 
                                        </td>
                                    </tr>
                                    <?php }} ?>
                                </table>
                                </div>
                            </div>

                            <?php } ?>
                                
                            <script>
                            function viewPropertyModal(){
                                $('.viewModal').hide('slow');
                                $('.closeModal').show('slow');
                                $('.addPropertyDetail').show('slow');
                            }
                            function closePropertyModal() {
                                $('.viewModal').show('slow');
                                $('.closeModal').hide('slow');
                                $('.addPropertyDetail').hide('slow');
                            }
                            </script>
                        </div>
                        </div>

                        <div class="row p-2">
                            <div class="col-md-6 text-justify">
                            <span><strong><?=$sl_count++?>.</strong> Category of the proposed land?</span>

                            </div>
                            <div class="col-md-6 form-group">
                                <select name="land_falls" id="land_falls" class="form-control" required disabled>
                                    <?php foreach(json_decode(LB_NATURE_OF_RESERVATION) as $landCode): ?>
                                        <option value="<?php echo $landCode->CODE ?>"

                                            <?php if($lmnote->land_falls == $landCode->CODE){ echo "selected";} ?>>

                                            <?php echo $landCode->NAME ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
                            15 KM radius from the periphery of GMC or within 5 KM periphery of other
                            town or within 3 KM periphery of Revenue town.</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="falls_und_gmc"
                                            id="falls_und_gmc"
                                            value="YES" disabled <?php if ($lmnote->falls_und_gmc == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="falls_und_gmc"
                                            id="falls_und_gmc"
                                            value="NO" disabled <?php if ($lmnote->falls_und_gmc == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>


                        <?php 

                        foreach($dags as $landmark):
                        $land_mark = json_decode($landmark->landmark);      

                        if($land_mark != null) {                

                                ?>

                                <div class="row p-2">
                                <div class="col-md-6">
                                    <strong><?=$sl_count++?>.</strong> Landmark <span class="alert-warning"><strong>for Dag No. <?=$landmark->dag_no?></strong></span>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                    <tr>
                                        <th>East side</th>
                                        <td><?= $land_mark->east == null ? '-' :$land_mark->east ?></td>
                                        <th>West side</th>
                                        <td><?= $land_mark->west == null ? '-' :$land_mark->west ?></td>
                                    </tr>
                                    <tr>
                                        <th>North side</th>
                                        <td><?= $land_mark->north == null ? '-' :$land_mark->north ?></td>
                                        <th>South side</th>
                                        <td><?= $land_mark->south == null ? '-' :$land_mark->south ?></td>
                                    </tr>
                                    </table>
                                </div>
                                </div>
                        <?php } endforeach;?>


                        <?php if ($reservation == true) {?>
                            <div class="row p-2" >
                                <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                /riverside reservation (if any, along with provision kept for road/drain
                                wherever necessary)</span>
                                </div>
                                <div class="col-md-6">
                                    <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                                        <?php foreach ($reservation as $reserv_road) {

                                            if ($reserv_road->type == "R") {?>
                                                <div class="form-group row mt-2">

                                                    <input disabled type="hidden" name="dag_no<?=$reserv_road->dag_no?>" value="<?=$reserv_road->dag_no?>">
                                                    <span class="alert-success mb-2"><b>Dag no : <?=$reserv_road->dag_no?></b></span>
                                                    <div class="col-4">
                                                        <span class="input-group-addon">Bigha</span>
                                                        <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->bigha?>" class="form-control input-sm" name="reserved_bigha<?=$reserv_road->dag_no?>" id="reserved_bigha">
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="input-group-addon">Katha</span>
                                                        <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->katha?>" class="form-control input-sm" name="reserved_katha<?=$reserv_road->dag_no?>" id="reserved_katha" >
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="input-group-addon">Lessa</span>
                                                        <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->lessa?>" class="form-control input-sm" name="reserved_lessa<?=$reserv_road->dag_no?>" id="reserved_lessa" >
                                                    </div>
                                                </div>
                                                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                    <div class="form-group row mt-2">
                                                        <div class="col-4">
                                                            <span class="input-group-addon">Ganda</span>
                                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->ganda?>" class="form-control input-sm" name="reserved_ganda<?=$reserv_road->dag_no?>" >
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="input-group-addon">Kranti</span>
                                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv_road->kranti?>" class="form-control input-sm" name="reserved_kranti<?=$reserv_road->dag_no?>" >
                                                        </div>
                                                    </div>
                                                <?php endif;?>
                                            <?php }}?>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="roadside">Comment(if any)</label>
                                                <textarea
                                                        name="roadside_reservation"
                                                        id="roadside_reservation"
                                                        class="form-control"
                                                        rows="2"
                                                        disabled
                                                ><?=$lmnote->roadside_reservation?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }?>

                    <?php endif;?>

                    <?php if($validation_bypass == 1) {?>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <span ><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                            <?php if($basic['bhumiputra_certificate_no']){?>
                                <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>
                            <?php }else{ ?>
                                <label for="" class="alert-warning">Certificate/Ack Not Available!</b></label>
                            <?php }?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if($basic['bhumiputra_certificate_no']){?>
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                            
                            if($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT){
                                echo "cer_number=".$basic['bhumiputra_certificate_no'];
                            }elseif($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK){
                                echo "ack_number=".$basic['bhumiputra_certificate_no'];
                            }?>" target="BhumiPutra">
                                <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                            </a>
                            <?php 
                            }
                            else
                            {
                                ?>
                                    <span class="text-primary" style="font-size:16px;">Certificate not available</span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php }?>

                    <div class="row p-2">
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong> LM remarks</label>
                        </div>
                        <div class="col-md-6">
                         <!-- <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2"></textarea> -->
                         <select name="lm_note" id="lm_remark" class="form-control" disabled>
                                <?php
                                foreach(json_decode(LM_NOTE) as $lm_remark_cat){
                                    ?>
                                    <option value="<?=$lm_remark_cat->CODE?>"
                                        <?php if($lmnote->lm_note == $lm_remark_cat->CODE){ echo "selected";} ?>
                                    ><?=$lm_remark_cat->NAME?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row p-5 m-2" style="background:#FFF3CD;">
                        <div class="col-md-12">
                        <?php 
                            include(APPPATH."views/SettlementView/include/coRejectedRemarks.php");
                        ?>
                        </div>
                    </div>
                    <div class="row p-2 justify-content-end" style="padding-bottom: 15px!important;">
                        <div class="col-md-12">
                            <textarea readonly name="lm_remark_text" placeholder="Enter remark..." class="form-control p-2" id="lm_remark_text" cols="30" rows="13"><?=$lmnote->lm_remark_text?></textarea>

                        </div>
                    </div>
                    <!-- lm report ends here -->
                <?php endforeach;?>
                <br>
            </div>


            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Uploaded Documents
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php foreach($dhardocuments as $docs): ?>
                        <tr>
                            <th>
                                <a target='download'
                                   href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$docs->id?>"><i class="fa fa-paperclip"></i> <?=$docs->file_name;?>
                                    <?php if(isset($docs->dag_no)){ ?>
                                        <span class="alert-danger"><small> for Dag no: <strong><?=$docs->dag_no?></strong></small></span>
                                    <?php }?>
                                </a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>


            <!-- //for correcting the wrong possseion from date starts-->
    <?php if(isset($wrong_possession_from_flag) && $wrong_possession_from_flag =='yes'):?>
        <!-- //view for LRA STARTS-->
        <?php if($this->session->userdata('user_desig_code') == "LM"):?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-check" aria-hidden="true"></i> For Correction Of Wrong Possession From Date
            </h5>
            <hr>
            <?php 
                $this->load->model('SettlementPossessionFrom/SettlementPossesionFromModel');
            ?>
            <div class="container-fluid reza-body reza-card">
                <form id="wrong_posssession_from_date_correction_form" name='wrong_posssession_from_date_correction_form' action="<?php echo base_url()?>index.php/SettlementPossesionFrom/formSubmitFromLra">
                <div class="row">
                    <?php $existing_possession_from = $this->SettlementPossesionFromModel->getPossessionFromData($_GET['case']);?>
                    <label>
                        Exisiting Possession From date:<span style="color:red"> <?=$existing_possession_from?></span>
                    </label>
                    <div class="col-md-6">
                        <label for="date_of_possession_modified">Please Select The Correct Date Of Possession <span style="color: red;">*</span></label>
                        <input type="text" class="form-control mt-2" placeholder="-DATE OF POSSESSION-" 
                            id="date_of_possession_modified" name="date_of_possession_modified">
                    </div>
                    <div class="col-md-6">
                        <label for="supporting_document_wrong_possession_document">Upload Supporting Document(if any)</label>
                        <input type="file" class="form-control mt-2"  
                            id="supporting_document_wrong_possession_document" name="supporting_document_wrong_possession_document">
                    </div>
                    <div class="col-md-6">
                        <label for="wrong_poseesion_from_remarks">Please Enter Remarks Here <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="wrong_poseesion_from_remarks" id="wrong_poseesion_from_remarks" placeholder="Please Enter Remarks Here"></textarea>
                    </div>
                </div>
                <!-- hidden fields -->
                <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
                <input type="hidden" name="existing_possession_from_date" value="<?=$existing_possession_from?>">
                <!-- hidden fields -->
                
                </form>
                <center>
                    <button class="btn btn-sm btn-success mt-2"  onclick="wrong_poss_forward_lra_to_co()">
                        <i class="fa fa-forward" aria-hidden="true"></i> FORWARD TO CO
                    </button>
                </center>
            </div>
        <?php endif;?>
        <!-- //view for LRA ends-->

        <!-- //view for CO STARTS-->
        <?php if($this->session->userdata('user_desig_code') == "CO"):?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-check" aria-hidden="true"></i> For Correction Of Wrong Possession From Date
            </h5>
            <hr>
            <?php 
                $this->load->model('SettlementPossessionFrom/SettlementPossesionFromModel');
            ?>
            <div class="container-fluid reza-body reza-card">
                <form id="wrong_posssession_from_date_correction_form_co" name='wrong_posssession_from_date_correction_form_co' action="<?php echo base_url()?>index.php/SettlementPossesionFrom/formSubmitFromLra">
                <div class="row">
                    <?php 
                        $existing_possession_from = $this->SettlementPossesionFromModel->getPossessionFromData($_GET['case']);
                        $corrected_possession_from = $this->SettlementPossesionFromModel->getCorrectedPossessionFromData($_GET['case']);
                    ?>
                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <td><strong>Existing Possession From Date</strong></td>
                            <td style="color: red;"><?=$existing_possession_from?></td>
                        </tr>
                        <tr>
                            <td><strong>Corrected Possession From Date</strong></td>
                            <td style="color: green;"><?=$corrected_possession_from->possesion_from_correct_date?></td>
                        </tr>
                        <tr>
                            <td><strong>Remarks From LRA</strong></td>
                            <td style="color: black;"><?=$corrected_possession_from->lra_remark?></td>
                        </tr>
                        <tr>
                            <td><strong> View Supporting Document</strong></td>
                            <?php if($corrected_possession_from->attachment_url =='NA'):?>
                                <td><span style="background-color:yellow">Not Uploaded</span></td>
                            <?php else:?>
                                <td>
                                    <a class="btn btn-sm btn-success" 
                                    href="<?= base_url('index.php/SettlementPossesionFrom/viewSupportingDocument?case_no=' . urlencode($_GET['case'])) ?>" 
                                    target="_blank">
                                        View Document
                                    </a>
                                </td>
                            <?php endif;?>
                        </tr>
                    </table>  
                    <!-- New Div for Chitha Remarks starts-->
                    <div class="col-md-12 mt-3">
                        <h6><strong>Chitha Remarks</strong></h6>
                        <textarea required readonly name="chitha_remarks_correction" id="chitha_remarks_correction"
                            class="form-control p-2 border rounded"
                            style="background-color: #f9f9f9; font-size: 14px; line-height: 1.6;" rows="5">১ নং হুকুম মতে বন্দৱস্তী হোৱা ভূমি ভুলক্ৰমে <?=$existing_possession_from?> চনৰ পৰা দখল থকা বুলি উল্লেখ কৰা হৈছিল, কিন্তু প্ৰকৃততে <?=$corrected_possession_from->possesion_from_correct_date?> চনৰ পৰা দখল থকা বুলি হ'ব লাগিছিল। সেয়েহে <?=$corrected_possession_from->possesion_from_correct_date?> চনৰ পৰা দখল থকা বুলি সংশোধনী কৰি ৰাজহ নিৰ্ধাৰণ কৰিবলৈ নথি সংশোধন কৰা হল।
                        </textarea>
                    </div>
                    <!-- New Div for Chitha Remarks ends--> 
                    <div class="col-md-6">
                        <label for="wrong_poseesion_from_remarks_co">Please Enter Remarks Here <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="wrong_poseesion_from_remarks_co" id="wrong_poseesion_from_remarks_co" placeholder="Please Enter Remarks Here"></textarea>
                    </div>
                </div>
                <!-- hidden fields -->
                <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
                <!-- hidden fields -->
                
                </form>
                <center>
                    <button class="btn btn-sm btn-success mt-2"  onclick="wrong_poss_co_update()">
                        <i class="fa fa-refresh" aria-hidden="true"></i> UPDATE THE DATE IN CHITHA
                    </button>
                </center>
            </div>
        <?php endif;?>
         <!-- //view for CO ends-->

    <?php endif;?>
    <!-- //for correcting the wrong possseion from date ends-->


        </div>
    </div>


    <script>
$(document).ready( function () {
    //date field initialisation
    $('#date_of_possession_modified').datepick({dateFormat: 'yyyy-mm-dd'});
});

function wrong_poss_forward_lra_to_co() {
    var formdata = new FormData(document.getElementById('wrong_posssession_from_date_correction_form'));
    let remarks = $('#wrong_poseesion_from_remarks').val().trim();
    let dateModified = $('#date_of_possession_modified').val().trim();

    if (remarks === '' || dateModified === '') {
        alert("Remarks and Date of Possession are required!");
        return;
    }

    $.ajax({
        url: baseurl + "SettlementPossesionFrom/formSubmitFromLra",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (response) {
            $.unblockUI();
            if (response.result === 'SUCCESS') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.msg,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = baseurl + "SettlementPossesionFrom/index";
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: response.result,
                    text: response.msg
                });
            }
        },
        error: function (xhr, status, error) {
            $.unblockUI();
            alert("An error occurred while submitting the form.");
            console.error(error);
        }
    });
}

function wrong_poss_co_update() {
    var formdata = new FormData(document.getElementById('wrong_posssession_from_date_correction_form_co'));
    let remarks = $('#wrong_poseesion_from_remarks_co').val().trim();
    let chitha_remarks_correction = $('#chitha_remarks_correction').val().trim();
    
    if (remarks === '' ) {
        alert("Remarks field is required!");
        return;
    }

    if (chitha_remarks_correction === '' ) {
        alert("Chitha Remarks field is required!");
        return;
    }

    $.ajax({
        url: baseurl + "SettlementPossesionFrom/formSubmitFromCo",
        type: 'POST',
        enctype: 'multipart/form-data',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border: 'none',
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function (response) {
            $.unblockUI();
            if (response.result === 'SUCCESS') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.msg,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = baseurl + "SettlementPossesionFrom/coLanding";
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: response.result,
                    text: response.msg
                });
            }
        },
        error: function (xhr, status, error) {
            $.unblockUI();
            alert("An error occurred while submitting the form.");
            console.error(error);
        }
    });
}
</script>




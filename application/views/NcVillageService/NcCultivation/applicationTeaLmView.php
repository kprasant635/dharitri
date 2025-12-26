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
    <h5  class="bgheading p-2 text-white shadow " style="margin-top: 10px">
        <?php echo $this->lang->line('nc_cultivator') ?> (
        <span class="bg-warning"><?=$_GET['case']?></span> )
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
                                        <strong class="alert-warning"><?php if(trim($basic['tribal_belt']) == 'YES') {echo "YES";
                                            } else { echo "NO";}?></strong>
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

            <!-- ************************************************************************************ -->
            <h5 class="reza-title"  style="margin-top: 15px">
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

            <!-- *************************************************************************************** -->
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
            <!-- ****************************************************************************************-->
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
                                    if ($settlement->pdar_rel_guar == "1") {
                                        echo "Mother";
                                    }
                                    if ($settlement->pdar_rel_guar == "2") {
                                        echo "Father";
                                    }
                                    if ($settlement->pdar_rel_guar == "3") {
                                        echo "Husband";
                                    }
                                    if ($settlement->pdar_rel_guar == "4") {
                                        echo "Wife";
                                    }
                                    if ($settlement->pdar_rel_guar == "5") {
                                        echo "Guardian";
                                    }
                                    if ($settlement->pdar_rel_guar == "6") {
                                        echo "Supdt.Mother";
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

            <!-- ************************************************************************************* -->
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
                        // for encroacher not eligible
                        include(APPPATH."views/SettlementView/include/encroacherNotEligibleCoView.php");

                        ?>
                    </table>
                </div>
            <?php }?>

            <!-- ************************************************************************************** -->

            <?php if($basic["bhumiputra_certificate_no"]){?>

                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bhumiputra Certificate/Ack verified?</th>
                            <td align="center">

                                <input disabled type="radio" style="margin: 4px 4px 5px -15px;;" name="bhumiputra_confirmation" id="" class="form-check-input" value="YES" <?php if(trim($basic['bhumiputra_confirmation']) == YES){echo "checked";} ?>>
                                <label for="bhumi_confirmation">Yes</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                                <input disabled type="radio" style="margin: 4px 4px 5px -15px;;" name="bhumiputra_confirmation" id="" class="form-check-input" value="NO" <?php if(trim($basic['bhumiputra_confirmation']) == NO){echo "checked";} ?>>
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

            <!-- ********************************************************************************** -->

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

            <!-- ***************************************************************************** -->

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-bank"></i>  Board Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <tr>
                        <th>Board Name</th>
                        <td>
                            <strong class="alert-warning"><?=$basic["cult_board"] ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Board Registration Number</th>
                        <td>
                            <strong class="alert-warning"><?=$basic["cultboard_reg_no"]?></strong>
                        </td>
                    </tr>
                    <!-- <tr>
                       <th>Nature of occupation over the land</th>
                       <td>
                         <input type="text" value="Agricultural" name="nature_occupation" class="form-control">
                       </td>
                       </tr> -->
                </table>
            </div>

            <!-- ******************************************************************************** -->

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

                    <?php foreach ($dags as $all_dags) {?>

                        <tr class="bg-white">
                            <th rowspan="3" style="vertical-align : middle;">
                                <div class="vertical text-center">
                                    DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> |
                                    PATTA : <span class="text-danger"><?=$all_dags->patta_no?> <br> <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?></span>
                                </div>
                            </th>
                            <td><strong>Total Land Area in Selected Dag</strong></td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_k" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" >
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$all_dags->dag_area_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" >
                            </td>
                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" >
                                </td>
                                <td class="hide" style="text-align: center;">
                                    <strong><?=$all_dags->dag_area_kr?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" >
                                </td>
                            <?php endif ; ?>
                        </tr>

                        <?php
                        $enc_area = json_decode($all_dags->encroachement_area);
                        if($enc_area != null) {
                            ?>
                            <!-- encroacher homestead -->
                            <tr class="bg-white hide">
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

                        <tr class='hide' class="bg-white">
                            <td class="settlement-area-color"><strong>Area for Settlement (Homestead)</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_b?></strong>
                                <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_dags->home_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_k?></strong>
                                <input type="hidden" style="text-align: center;" name="home_k" value="<?=$all_dags->home_k?>" class="form-control input-sm home_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->home_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$all_dags->home_lc?>" class="form-control input-sm home_lc" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->home_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->home_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->home_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- area settlement agriculture -->

                        <tr class="bg-white">
                            <td class="settlement-area-color"><strong>Area for Settlement (Agriculture)</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_b?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_k?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_k" value="<?=$all_dags->agri_k?>" class="form-control input-sm agri_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->agri_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->agri_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->agri_g?>" class="form-control input-sm agri_g" name="agri_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->agri_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" readonly>
                                </td>
                            <?php endif;?>
                        </tr>

                        <tr class="bg-white">
                            <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                                <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/NcCommonController/apiDagWiseApplication?app=<?=$basic["applid"];?>&dag=<?=$all_dags->dag_no;?>">
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

                    </thead>
                </table>

            </div>

            <!-- ************************************************************************************* -->

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Supporting Documents
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php
                    foreach($document as $d):

                        ?>
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

            <!-- ************************************************************************************ -->

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
    <h5  class="bgheading p-2 text-white shadow " style="margin-top: 10px">
        <?php echo $this->lang->line('nc_cultivator') ?> (
        <span class="bg-warning"><?=$_GET['case']?></span> )
    </h5>
    <div class="reza-card">
        <div class="reza-body">
            <h5  class="reza-title" style="margin-top: 15px">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
            </h5>
            <?php $i=1; foreach($lmnotes as $lmnote):?>
                <div class="tableCard" style="padding-bottom: 15px">
                    <?php
                    if($validation_bypass == 0):?>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Chitha Verified?
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
                                <strong><?=$sl_count++?>.</strong> VLB Verified?
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
                                <strong><?=$sl_count++?>.</strong> Bhumiputra Verified?<br>
                                <?php if($basic['bhumiputra_certificate_no']){?>
                                    <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>

                                <?php }else{ ?>

                                    <label for="" class="alert-warning">Certificate/Ack Not Available!</b></label>

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
                                        <?php if(trim($lmnote->bhumiputra_confirmation) == YES){echo "checked";} ?>

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
                                        <?php if(trim($lmnote->bhumiputra_confirmation) == NO){echo "checked";} ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php
                                if($basic['bhumiputra_certificate_no']):
                                    ?>
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
                                endif;
                                ?>
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
                                <strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                Tribal Belt/ Block.
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
                                        <?php if ($lmnote->is_tribal_belt == "YES") {echo "checked";}?>

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
                                        <?php if ($lmnote->is_tribal_belt == "NO") {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6 text-justify">
                                <strong><?=$sl_count++?>.</strong> Does applicant falls under protected category?
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" name="" value="<?php
                                foreach(json_decode(PROTECTED_CLASS) as $class){


                                    if($class->CODE == $lmnote->protected_class_lm){
                                        echo $class->NAME;
                                    }
                                }
                                ?>" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Schedule of the land and area under
                                occupation?
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
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ?
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="landslide"
                                            id="landslide"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->landslide == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="landslide"
                                            id="landslide2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->landslide == NO) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>


                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Whether the land falls under erosion?
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="erosion"
                                            value="YES" disabled <?php if (trim($lmnote->erosion) == YES){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">YES</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="erosion"
                                            value="NO" disabled <?php if (trim($lmnote->erosion) == NO){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Whether proposed land is under litigation?
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="litigation"
                                            value="YES" disabled <?php if ($lmnote->litigation == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="litigation"
                                            value="NO" disabled <?php if ($lmnote->litigation == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <?php
                        $display_old_nature=0;
                        foreach($dags as $naturedag):
                            if (!is_null($naturedag->nature_possession)){
                                $display_old_nature=0;
                                ?>
                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <strong><?=$sl_count++?>.</strong> Nature of possession <span class="alert-warning"><strong>for Dag No. <?=$naturedag->dag_no?></strong></span>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="nature_possession<?=$naturedag->dag_no?>" readonly class="form-control" id="nature_possession<?=$naturedag->dag_no?>" value="<?=$naturedag->nature_possession?>">
                                    </div>
                                </div>
                            <?php } else { $display_old_nature=1; } endforeach;?>

                        <?php if ($display_old_nature == 1){ ?>
                            <div class="row p-2" >
                                <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> Nature of possession –</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <input name="nature_possession" readonly class="form-control" id="nature_possession" value="<?=$lmnote->nature_possession?>">
                                    <!-- <select
                                            name="nature_possession"
                                            id="nature_possession"
                                            class="form-control" disabled
                                    >
                                        <option value="Agricultural" <?php if ($lmnote->nature_possession == "Agricultural") {echo "selected";}?>>Agricultural</option>
                                        <option value="Business" <?php if ($lmnote->nature_possession == "Business") {echo "selected";}?>>Business</option>
                                        <option value="Residential" <?php if ($lmnote->nature_possession == "Residential") {echo "selected";}?>>Residential</option>
                                        <option value="Commercial" <?php if ($lmnote->nature_possession == "Commercial") {echo "selected";}?>>Commercial</option>
                                        <option value="Others" <?php if ($lmnote->nature_possession == "Others") {echo "selected";}?>>Others</option>
                                    </select> -->
                                </div>
                            </div>
                        <?php } ?>
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
                                            value="YES" disabled <?php if (trim($lmnote->is_landless) == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Completely Landless</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_landless"
                                            id="is_landless"
                                            value="NO" disabled <?php if (trim($lmnote->is_landless) == NO || trim($lmnote->is_landless) == 'OTHERS') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">Landless as per policy / Having Land</label>
                                </div>

                                <?php if($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') { ?>
                                    <button class="btn btn-sm btn-warning viewModal" onclick="viewPropertyModal()" type="button"><i class="fa fa-university"></i>&nbsp;View Property</button>

                                    <button class="btn btn-sm btn-danger closeModal" style="display:none" onclick="closePropertyModal()" type="button"><i class="fa fa-close"></i>&nbsp;Close Property</button>

                                    <div class="addPropertyDetail" style="display:none" >
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
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> The Applicant should undertake special cultivation of tea as a means of livelihood
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="livelihood"
                                            id="livelihood"
                                            value="YES" disabled <?php if ($lmnote->livelihood == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="livelihood"
                                            id="livelihood"
                                            value="NO" disabled <?php if ($lmnote->livelihood == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Suitability of proposed land for tea cultivation
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="suitability"
                                            id="suitability"
                                            value="YES" disabled <?php if ($lmnote->suitability == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="suitability"
                                            id="suitability"
                                            value="NO" disabled <?php if ($lmnote->suitability == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Patta land of applicant’s family. This should be deducted from the total admissible area
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="admissible_area"
                                            id="admissible_area"
                                            value="YES" disabled <?php if ($lmnote->admissible_area == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="admissible_area"
                                            id="admissible_area"
                                            value="NO" disabled <?php if ($lmnote->admissible_area == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Weather the applicant has been allotted govt land before
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="govt_allotted"
                                            id="govt_allotted"
                                            value="YES" disabled <?php if ($lmnote->govt_allotted == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="govt_allotted"
                                            id="govt_allotted"
                                            value="NO" disabled <?php if ($lmnote->govt_allotted == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Whether the petitioner is differently abled/SC/ST/OBC/Ex-serviceman/Widow/others
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_st"
                                            id="is_st1"
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
                                            name="is_st"
                                            id="is_st2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->is_st == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong>whether the applicant is indigenous unemployed educated youth
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_indigenous"
                                            id="is_indigenous1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->is_indigenous == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_indigenous"
                                            id="is_indigenous2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->is_indigenous == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong>Whether registered with Tea Board of India/Directorate of Tea, Assam
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_reg_with_teaboard"
                                            id="is_reg_with_teaboard1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->is_reg_with_teaboard == "YES"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_reg_with_teaboard"
                                            id="is_reg_with_teaboard2"
                                            value="NO"
                                            disabled
                                        <?php if ($lmnote->is_reg_with_teaboard == "NO"){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-md-6 text-justify">
                                <strong><?=$sl_count++?>.</strong> Category of the proposed land?
                            </div>
                            <div class="col-md-6">
                                <select name="land_falls" id="land_falls" class="form-control" required disabled>
                                    <option value="">Select...</option>
                                    <?php foreach (json_decode(LB_NATURE_OF_RESERVATION) as $landCode): ?>
                                        <option value="<?php echo $landCode->CODE ?>" <?php if ($lmnote->land_falls == $landCode->CODE) {echo "selected";}?>><?php echo $landCode->NAME ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
                                15 KM radius from the periphery of GMC or within 5 KM periphery of other
                                town or within 3 KM periphery of Revenue town.
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
                        <?php if ($reservation == true) {?>
                            <div class="row p-2" >
                                <div class="col-md-6">
                                    <strong><?=$sl_count++?>.</strong> Specific comment on roadside
                                    /riverside reservation (if any, along with provision kept for road/drain
                                    wherever necessary)
                                </div>
                                <div class="col-md-6">
                                    <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                                        <?php foreach ($reservation as $reserv_road) {

                                            if ($reserv_road->type == "R") {?>
                                                <div class="form-group row mt-2">

                                                    <input disabled type="hidden" name="dag_no<?=$reserv_road->dag_no?>" value="<?=$reserv_road->dag_no?>">
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

                        <?php foreach($dags as $landmark):
                            $land_mark = json_decode($landmark->landmark);?>
                            <div class="row p-2">
                                <div class="col-md-6">
                                    <strong><?=$sl_count++?>.</strong> Landmark <span class="alert-warning"><strong>for Dag No. <?=$landmark->dag_no?></strong></span>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>East side</th>
                                            <td><?=$land_mark->east?></td>
                                            <th>West side</th>
                                            <td><?=$land_mark->west?></td>
                                        </tr>
                                        <tr>
                                            <th>North side</th>
                                            <td><?=$land_mark->north?></td>
                                            <th>South side</th>
                                            <td><?=$land_mark->south?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php
                    endif;?>

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
                            <!-- <input type="text" name="lm_note" value="<?php
                            foreach(json_decode(CO_NOTE) as $co_note){
                                if($co_note->CODE == $lmnote->lm_note){
                                    echo $co_note->NAME;
                                }
                            }?>" class="form-control" readonly> -->
                            <input name="lm_note" readonly class="form-control" id="lm_note" value="<?php foreach(json_decode(LM_NOTE) as $lm_remark_cat){ if($lm_remark_cat->CODE == $lmnote->lm_note){ echo $lm_remark_cat->NAME;}}?>" cols="30" rows="2">
                            <br>
                        </div>
                    </div>

                    <div class="row p-5 m-2" style="background:#FFF3CD;">
                        <div class="col-md-12">
                            <?php 
                                include(APPPATH."views/SettlementView/include/coRejectedRemarks.php");
                            ?>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12">
                            <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark" cols="30" rows="12" readonly><?=$lmnote->lm_remark_text?></textarea>
                        </div>
                    </div>

                </div>
            <?php endforeach;?>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Uploaded Documents
            </h5>
            <div class="tableCard">
                <table class="table  table-bordered">
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
        </div>
    </div>

    <ul class="list-inline pull-right"  style="margin-top: 20px">
        <li>
            <button type="button" class="btn btn-default prev-step">
                <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
            </button>
        </li>
        <li>
            <button type="button" class="btn btn-primary next-step">
                <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
            </button>
        </li>
    </ul>
</div>
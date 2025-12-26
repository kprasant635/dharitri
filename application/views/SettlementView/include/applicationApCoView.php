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
<h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
<?php echo $this->lang->line('settlementAP')?> (
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
                    <?php
                        foreach ($applicants_buyers as $identity):
                            if($identity->is_applicant == 1){
                    ?>
                        <tr>
                            <th>
                                Name in <?=$identity->identity_type?>
                            </th>
                            <td>
                                <span class="alert-warning"><strong><?=$identity->eng_pdar_name?></strong></span>
                            </td>
                        </tr>

                        <tr>
                            <th><?=$identity->identity_type?> Verified</th>
                            <td>
                                <span class="alert-warning"><strong><?php if ($aadhar->is_aadhaar_verify == '1') {echo 'Yes';}?></strong></span>
                            </td>
                        </tr>

                    <?php }
                        endforeach;
                    ?>
                        <?php if (isset($basic["period_possession"])) { ?>
                            <tr>
                                <th>Period of Possession</th>
                                <td>
                                    <strong class="alert-warning"><?=$basic["period_possession"] ?></strong>

                                </td>
                            </tr>
                            <tr>
                                <th>Occupation or Profession of the applicant</th>
                                <td>
                                    <strong class="alert-warning"><?=$basic["occupation_applicant"]?></strong>

                                </td>
                            </tr>
                        <?php } ?>
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
                        <?php if($basic["protected_class"]): ?>
                        <tr>
                            <th>Are you fall under protected category?</th>
                            <td>
                                <strong class="alert-warning"><?php
                                    foreach(json_decode(PROTECTED_CLASS) as $caste){
                                        if($caste->CODE == $basic["protected_class"]){
                                            echo $caste->NAME;
                                        }
                                    }
                                    ?></strong>

                            </td>
                        </tr>
                        <?php endif;?>
                        <tr>
                            <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                            <td>
                                <strong class="alert-warning"><?=$basic["tribal_belt"]?></strong>

                            </td>
                        </tr>
                        <?php
                        if($basic['type_of_transfer']):
                        ?>
                        <tr>
                            <th>Land Transfer Type</th>
                            <td>
                                <strong class="alert-warning"><?php
                                foreach(json_decode(TYPE_OF_TRANSFER) as $land_transfer){
                                    if($land_transfer->CODE == $basic["type_of_transfer"]){
                                        echo $land_transfer->NAME;
                                    }
                                }
                                ?></strong>
                                
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php
                        if($basic['type_of_patta']):
                        ?>
                        <tr>
                            <th>Type of Patta</th>
                            <td>
                                <strong class="alert-warning"><?php
                                    foreach(json_decode(TYPE_OF_PATTA) as $land_patta){
                                        if($land_patta->CODE == $basic["type_of_patta"]){
                                            echo $land_patta->NAME;
                                        }
                                    }
                                    ?>
                                </strong>
                                
                            </td>
                        </tr>
                        <?php endif; ?>
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

        <h5 class="reza-title"  style="margin-top: 50px">
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
                        <th rowspan="6" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
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
                        <th>DOB</th>
                        <td>
                            <strong class="alert-warning">
                                <?=$settlement->dob?>
                            </strong>
                        </td>
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



        <?php  if($applicants_owners == true){ ?>
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user-secret"></i>  Land Owner Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php
                    $sl = 1;
                    foreach($applicants_owners as $owners){
                        ?>

                        <tr>
                            <th width="5%" rowspan="3" style="vertical-align : middle;text-align:center;"><?=$sl++;?></th>
                            <th>Name</th>
                            <td >
                                <strong class="alert-warning">
                                    <?=$owners->pdar_name;?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Father's name</th>
                            <td >
                                <strong class="alert-warning">
                                    <?=$owners->pdar_guardian;?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                In place/Along with
                            </th>
                            <td>
                                <strong class="alert-warning">
                                    <?php
                                    if($owners->inplace_alongwith == 'i'){
                                        echo "In Place";
                                    }
                                    if($owners->inplace_alongwith == 'a'){
                                        echo "Along with";
                                    }
                                    ?>
                                </strong>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        <?php } ?>

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
                                <b>Yes </b>
                            <?php else: ?>
                                <b>No </b>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="hidden" name="bhumiputra_certificate_no" value="<?=$basic["bhumiputra_certificate_no"]?>">
                            Certificate/Ack number : <b><?=$basic["bhumiputra_certificate_no"]?></b>
                        </td>
                    </tr>
                </table>
            </div>
        <?php }?>


        <?php if (isset($nominee) && $nominee) {?>
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
                    <?php foreach($dags as $dags_first){ ?>

                        <tr class="bg-white">
                            <th rowspan="6" style="vertical-align : middle;">
                                <div class="vertical text-center">
                                    DAG : <span class="text-danger"><?=$dags_first->dag_no?></span> <br>
                                    PATTA : <span class="text-danger"><?=$dags_first->patta_no?> <br> 
                                    <?=$this->utilityclass->getPattaType($dags_first->patta_type_code)?></span>
                                </div>
                            </th>
                            <td><strong>Total Land Area in Selected Dag</strong></td>

                            <td style="text-align: center;">
                                <strong><?=$dags_first->dag_area_b?></strong>
                                <input type="hidden" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags_first->dag_area_b?>" readonly>                                
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$dags_first->dag_area_k?></strong>
                                <input type="hidden" style="text-align: center;" name="dag_area_k" value="<?=$dags_first->dag_area_k?>" class="form-control input-sm" readonly>
                            </td>
                            <td style="text-align: center;">
                                <strong><?=$dags_first->dag_area_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags_first->dag_area_lc?>" readonly>
                            </td>
                            <?php if((in_array($dags_first->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td style="text-align: center;">
                                    <strong><?=$dags_first->dag_area_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$dags_first->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly>
                                </td>
                                <td style="text-align: center;">
                                    <strong><?=$dags_first->dag_area_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$dags_first->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- Area for NR as per DEED/Aggreement -->
                        <tr class="bg-white">
                            <td class="enc-area-color">
                                <strong>Area for NR as per DEED/Aggreement<br> (Provided by applicant)</strong>
                            </td>
                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$dags_first->nr_bigha?></strong>
                                <input readonly type="hidden" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags_first->nr_bigha?>" >
                            </td>

                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$dags_first->nr_katha?></strong>
                                <input readonly type="hidden" style="text-align: center;" name="s_dag_area_k" value="<?=$dags_first->nr_katha?>" class="form-control input-sm s_dag_area_k" >
                            </td>

                            <td class="enc-area-color" style="text-align: center;">
                                <strong><?=$dags_first->nr_lessa?></strong>
                                <input readonly type="hidden" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags_first->nr_lessa?>" >
                            </td>

                            <?php if((in_array($dags_first->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$dags_first->nr_ganda?></strong>
                                    <input readonly type="hidden" style="text-align: center;" value="<?=$dags_first->nr_ganda?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                                </td>
                                <td class="enc-area-color" style="text-align: center;">
                                    <strong><?=$dags_first->nr_kranti?></strong>
                                    <input readonly type="hidden" style="text-align: center;" value="<?=$dags_first->nr_kranti?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- Area for Settlement -->
                        <tr class="bg-white">
                            <td class="settlement-area-color">
                                <strong class="text-danger">Total Area for Settlement</strong>
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=$dags_first->s_dag_area_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags_first->s_dag_area_b?>" >
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=$dags_first->s_dag_area_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="s_dag_area_k" value="<?=$dags_first->s_dag_area_k?>" class="form-control input-sm s_dag_area_k" >
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=$dags_first->s_dag_area_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags_first->s_dag_area_lc?>" >
                            </td>

                            <?php if((in_array($dags_first->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align: center;">
                                    <strong><?=$dags_first->s_dag_area_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=$dags_first->s_dag_area_g?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                                </td>
                                <td class="settlement-area-color" style="text-align: center;">
                                    <strong><?=$dags_first->s_dag_area_kr?></strong>
                                    <input type="text" readonly style="text-align: center;" value="<?=$dags_first->s_dag_area_kr?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- Area for Settlement Home -->

                        <tr class="bg-white">
                            <td class="settlement-area-color">
                                <strong class="text-danger">Area for Settlement (Homestead)</strong>
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=is_null($dags_first->home_b) ? 0 :  $dags_first->home_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=is_null($dags_first->home_b) ? 0 :  $dags_first->home_b?>" >
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=is_null($dags_first->home_k) ? 0 :  $dags_first->home_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="home_k" value="<?=is_null($dags_first->home_k) ? 0 :  $dags_first->home_k?>" class="form-control input-sm home_k" >
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=is_null($dags_first->home_lc) ? 0 :  $dags_first->home_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="home_lc" class="form-control input-sm home_lc" value="<?=is_null($dags_first->home_lc) ? 0 :  $dags_first->home_lc?>" >
                            </td>

                            <?php if((in_array($dags_first->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align: center;">
                                    <strong><?=is_null($dags_first->home_g) ? 0 :  $dags_first->home_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=is_null($dags_first->home_g) ? 0 :  $dags_first->home_g?>" class="form-control input-sm home_g" name="home_g" >
                                </td>
                                <td class="settlement-area-color" style="text-align: center;">
                                    <strong><?=is_null($dags_first->home_kr) ? 0 :  $dags_first->home_kr?></strong>
                                    <input type="text" readonly style="text-align: center;" value="<?=is_null($dags_first->home_kr) ? 0 :  $dags_first->home_kr?>" class="form-control input-sm home_kr" name="home_kr" >
                                </td>
                            <?php endif; ?>
                        </tr>

                        <!-- Area for Settlement Agri -->
                        <tr class="bg-white">
                            <td class="settlement-area-color">
                                <strong class="text-danger">Area for Settlement (Agriculture)</strong>
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=is_null($dags_first->agri_b) ? 0 :  $dags_first->agri_b?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=is_null($dags_first->agri_b) ? 0 :  $dags_first->agri_b?>" >
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=is_null($dags_first->agri_k) ? 0 :  $dags_first->agri_k?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="agri_k" value="<?=is_null($dags_first->agri_k) ? 0 :  $dags_first->agri_k?>" class="form-control input-sm agri_k" >
                            </td>

                            <td class="settlement-area-color" style="text-align: center;">
                                <strong><?=is_null($dags_first->agri_lc) ? 0 :  $dags_first->agri_lc?></strong>
                                <input type="hidden" readonly style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=is_null($dags_first->agri_lc) ? 0 :  $dags_first->agri_lc?>" >
                            </td>

                            <?php if((in_array($dags_first->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align: center;">
                                    <strong><?=is_null($dags_first->agri_g) ? 0 :  $dags_first->agri_g?></strong>
                                    <input type="hidden" readonly style="text-align: center;" value="<?=is_null($dags_first->agri_g) ? 0 :  $dags_first->agri_g?>" class="form-control input-sm agri_g" name="agri_g" >
                                </td>
                                <td class="settlement-area-color" style="text-align: center;">
                                    <strong><?=is_null($dags_first->agri_kr) ? 0 :  $dags_first->agri_kr?></strong>
                                    <input type="text" readonly style="text-align: center;" value="<?=is_null($dags_first->agri_kr) ? 0 :  $dags_first->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" >
                                </td>
                            <?php endif; ?>
                        </tr>

                        <?php if(isset($dags_first->new_dag_no)) { ?>
                            <tr>
                                <th class="alert-warning text-danger">New Dag Number after NR:</th>
                                <td>
                                    <strong class="alert-warning text-danger">
                                        <?=$dags_first->new_dag_no?>
                                    </strong>
                                </td>
                            </tr>
                        <?php } ?>

                        <!-- view button -->
                        <tr class="bg-white">
                            <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
                                <a type="button" target="_blank" class="btn-sm  buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiDagWiseApplication?app=<?=$basic["applid"];?>&dag=<?=$dags_first->dag_no;?>">
                                    <small style="font-size:14px; color:white; font-weight:bold"><i class="fa fa-eye"></i> View Total Applications in this Dag</small>
                                </a>
                            </td>
                        </tr>

                    <?php } ?>
                </thead>
            </table>
            
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
                                    <input type="text" name="a_dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($adp->dist_code)?>' readonly>
                                </strong></td>
                            <th>Subdivision Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="text" name="a_subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($adp->dist_code,$adp->subdiv_code)?>' readonly>

                                </strong>
                            </td>
                            <th>Circle Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="text" name="a_circle_name" value='<?=$this->utilityclass->getCircleName($adp->dist_code,$adp->subdiv_code,$adp->cir_code)?>' class="form-control input-sm" readonly>

                                </strong></td>
                        </tr>

                        <tr>
                            <th>Mouza Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="text" name="a_mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code)?>' readonly>

                                </strong>
                            </td>
                            <th>Village Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <input type="text" name="a_village_name" value='<?=$this->utilityclass->getVillageName($adp->dist_code,$adp->subdiv_code,$adp->cir_code,$adp->mouza_pargona_code,$adp->lot_no,$adp->vill_townprt_code)?>' class="form-control input-sm" readonly>

                                </strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Dag Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <input type="text" name="a_dag_no" value='<?=$adp->dag_no?>' class="form-control input-sm" readonly>
                                </strong>
                            </td>

                            <th>Patta Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <input type="text" name="a_patta_no" class="form-control input-sm" value='<?=$adp->patta_no;?>' readonly>
                                </strong>
                            </td>

                        </tr>

                        <tr>
                            <th>Total Additional Land Details</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <strong>
                                    <input type="text" style="text-align: center;" name="a_bigha" class="form-control input-sm" value="<?=$adp->bigha?>" readonly>
                                </strong>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="a_katha" value="<?=$adp->katha?>" class="form-control input-sm" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" style="text-align: center;" name="a_lessa" class="form-control input-sm" value="<?=$adp->lessa?>" readonly>
                            </td>
                            <?php if((in_array($adp->dist_code, json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$adp->ganda?>" class="form-control input-sm" name="a_ganda" readonly>
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$adp->kranti?>" class="form-control input-sm" name="a_kranti" readonly>
                                </td>
                            <?php endif ; ?>
                        </tr>


                        <?php $i++ ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php  } ?>


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
        <button type="button" class="btn btn-primary next-step">
            <i class="fa fa-arrow-circle-right"> </i>  <?php echo $this->lang->line('next'); ?>
        </button>
    </li>
</ul>
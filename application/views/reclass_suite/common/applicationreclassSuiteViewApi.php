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


    <h5 class="bgheading p-2 text-white shadow" style="background: #248cf7 !important; margin-top: 10px">
        Offering Reclassification Suite (
        <small><span class="bg-warning"><?=$basic['case_no']?> , <?=$basic["applid"]?></span></small> )
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
 
                            
                            <tr>
                                <th>Occupation or Profession of the applicant</th>
                                <td>
                                    <strong class="alert-warning"><?=$basic["occupation_applicant"]?></strong>
                                </td>
                            </tr>
                            <?php 
                                //if($basic['protected_class']):
                            ?>
                            <!-- <tr>
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
                            </tr> -->
                            <?php //endif;?>
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

                <i class="fa fa-pencil-square-o"></i> Self declaration details
                <button class="btn btn-sm btn-warning btn-api-call" onclick="showSelfAndDocument()" type="button"><i class="fa fa-university"></i>&nbsp;View Self declaration</button>
            </h5>
            <div class="tableCard">
                <table class="table table-bordered" id="selfdeclaration">
                    <!-- <?php
                    foreach ($selfDeclarationDetails[0] as $key => $self) {
                        ?>
                        <tr>
                            <th><?=$self->name?></th>
                            <td class="text-center">
                                <strong>
                                    <?php if ($self->status == "1") {echo "Yes";}?>
                                    <?php if ($self->status == "0") {echo "No";}?>
                                </strong>
                            </td>
                        </tr>
                    <?php }?> -->
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

                        <?php

                            $pre_addr = json_decode($settlement->pdar_add1);
                            $per_addr = json_decode($settlement->pdar_add2);
                        ?>


                        <tr>
                            <th>Present address</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$pre_addr?>
                                </strong>
                            </td>
                            <th>
                                Permanent address
                            </th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$per_addr?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php $i++;?>
            <?php endforeach;?>


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

                        <?php foreach ($dags as $all_dags) {?>

                        <tr class="bg-white">
                            <th rowspan="1" style="vertical-align : middle;">
                                <div class="vertical">
                                    DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> | 
                                    PATTA : <span class="text-danger"><?=$all_dags->patta_no?> | <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?></span>
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

                        

                        <!-- area settlement homestead -->
                        <?php $hide = 'area_show';
                            if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                                $hide = 'area_show';
                            } else {
                                $hide = 'area_hide';
                            }
                        ?>
                        <!-- <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color"><strong>Applied Area</strong></td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->s_dag_area_b?></strong>
                                <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_dags->s_dag_area_b?>" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->s_dag_area_k?></strong>
                                <input type="hidden" style="text-align: center;" name="home_k" value="<?=$all_dags->s_dag_area_k?>" class="form-control input-sm home_k" readonly>
                            </td>
                            <td class="settlement-area-color" style="text-align:center">
                                <strong><?=$all_dags->s_dag_area_lc?></strong>
                                <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$all_dags->s_dag_area_lc?>" class="form-control input-sm home_lc" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->s_dag_area_g?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->s_dag_area_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                                </td>
                                <td class="settlement-area-color" style="text-align:center">
                                    <strong><?=$all_dags->s_dag_area_kr?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$all_dags->s_dag_area_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr> -->

                        

                        <?php } ?>

                        <?php
                                // for dag not eligible
                                //include(APPPATH."views/SettlementView/include/dagNotEligibleCoView.php");
                        ?>

                    </thead>
                </table>
                
            </div>


                                    <div class="tableCard">
                                        <!-- new premium addition -->
                                   

                                        <table class="table mb-0">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Dag No</th>
                                                <th class="text-center">Reclass Type</th>
                                                <th class="text-center">OLd Land Class</th>
                                                <th class="text-center">Proposed Land Class</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($dags as $dagspremlm){ ?>
                                                    <tr>
                                                    <td></td>
                                                    <td class="bg-white">
                                                        <strong><?=$dagspremlm->dag_no?></strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                       <strong style="color:red"><?=($dagspremlm->is_full_partial=='N')?'FULL DAG':'PARTIAL DAG'?></strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                        <strong>
                                                            <?=$dagspremlm->exist_land_class_name?>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                        <strong>
                                                           <?=$dagspremlm->proposed_land_class_name?>
                                                        </strong>
                                                    </td>

                                                <?php }?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <?php foreach($dags as $dagspremlm){ ?>
                                        <?php if($dagspremlm->is_full_partial=='Y'){?>
                                        <table class="table mb-0">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th>Dag</th>
                                                <th class="text-center">Bigha</th>
                                                <th class="text-center">Katha</th>
                                                <th class="text-center"><?=$lessa_chatak?></th>
                                                
                                            </tr>
                                            </thead>
                                                <tr>
                                                    <th rowspan="6" style="vertical-align : middle;">
                                                        
                                                    </th>
                                                    <th class="bg-white">Applied Land Area in Selected Dag</th>
                                                    <td class="bg-white">
                                                        <strong>
                                                            <?=$dagspremlm->dag_no?>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white">
                                                        <strong>
                                                            <input type="text" style="text-align: center;" name="dag_area_b<?=$dagspremlm->dag_no?>" id="dag_area_b<?=$dagspremlm->dag_no?>" class="form-control input-sm" value="<?=$dagspremlm->s_dag_area_b;?>" readonly>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white">
                                                        <input type="text" style="text-align: center;" name="dag_area_k<?=$dagspremlm->dag_no?>" id="dag_area_k<?=$dagspremlm->dag_no?>" value="<?=$dagspremlm->s_dag_area_k;?>" class="form-control input-sm" readonly>
                                                    </td>
                                                    <td class="bg-white">
                                                        <input type="text" style="text-align: center;" name="dag_area_lc<?=$dagspremlm->dag_no?>" id="dag_area_lc<?=$dagspremlm->dag_no?>" class="form-control input-sm" value="<?= $dagspremlm->s_dag_area_lc;?>" readonly>
                                                    </td>
                                                    <?php if ((in_array($basic["dist_code"], json_decode(BARAK_VALLEY)))): ?>
                                                        <td class="bg-white">
                                                            <input type="text" style="text-align: center;" value="<?=$dagspremlm->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$dagspremlm->dag_no?>" id="dag_area_g<?=$dagspremlm->s_dag_area_g?>" readonly>
                                                        </td>
                                                        <td class="bg-white hide">
                                                            <input type="text" style="text-align: center;" value="<?=$dagspremlm->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$dagspremlm->dag_no?>" id="dag_area_kr<?=$dagspremlm->s_dag_area_kr?>" readonly>
                                                        </td>
                                                    <?php endif;?>
                                                </tr>
                                            <?php }}?>
                                                
                                            
                                        </table>
                                        <!-- this only to display the error message in area validation -->
                                        <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                                        <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                                        <br>
                                    </div>

                        <?php if($basic['is_partition_done']=='Y'){?>

                        <h5 class="reza-title" style="margin-top: 50px">
                            <i class="fa fa-map"></i>  Partition Details
                        </h5>
                                    <div class="tableCard">
                                        <!-- new premium addition -->
                                   

                                        <table class="table mb-0">
                                            <thead class="thead-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Old Dag No</th>
                                                <th>Old Patta No</th>
                                                <th class="text-center">New Dag No</th>
                                                <th class="text-center">New Patta No</th>
                                                <th class="text-center">Partition Type</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($dags as $dagspremlm){
                                                    if($dagspremlm->is_full_partition=='Y' || $dagspremlm->is_partition=='Y'){?>
                                                    <tr>
                                                    <td></td>
                                                    <td class="bg-white">
                                                        <strong><?=$dagspremlm->dag_no?></strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                        <strong>
                                                            <?=$dagspremlm->patta_no?>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                        <strong>
                                                           <?=$dagspremlm->new_dag?>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                        <strong>
                                                           <?=$dagspremlm->new_patta?>
                                                        </strong>
                                                    </td>
                                                    <td class="bg-white text-center">
                                                       <strong style="color:red"><?=($dagspremlm->is_full_partition=='Y' && $dagspremlm->is_partition=='Y')?'FULL DAG PARTITION':'PARTIAL PARTITION'?></strong>
                                                    </td>


                                                <?php }}?>
                                            </tbody>
                                        </table>
                                        <br>
                                       
                                                
                                            
                                        </table>
                                        <!-- this only to display the error message in area validation -->
                                        <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
                                        <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
                                        <strong><?=form_error('appAreaMoreThanDagA');?></strong>
                                        <br>
                                    </div>     
                                    <?php }?>    
            
  

                    <h5 class="bg-secondary p-2 text-white shadow mt-2 text-center"><i class="fa fa-file-text" aria-hidden="true"></i>
                    Supporting Documents
                  </h5>
                  <p class="card-text">
                  <table class="table">
                   <!--  <?php foreach ($documents as $d) : ?>
                      <tr>
                        <th>

                          <a target='download' href="<?php echo base_url(); ?>index.php/Basundhara/document/<?= $d->name; ?>"><i class="fa fa-paperclip"></i> <?= $d->file_details; ?></a>

                        </th>
                      </tr>
                    <?php endforeach; ?> -->
                  </table>
                  </p>

        </div>
    </div>

    <div class="reza-card">
        <div class="reza-body ">
            <h5  class="reza-title" style="margin-top: 15px">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
            </h5>
            <div class="tableCard">
                <?php $sl_count =1; $i = 1;foreach ($lmnotes as $lmnote): 
                    if($validation_bypass == 0):
                    
                        ?>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Chitha verified and found the applicant as a pattadar?</span >
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="chiitha_verified"
                                            id="chiitha_verified1"
                                            value="YES" disabled <?php if ($lmnote->chitha_verified == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="chiitha_verified"
                                            id="chiitha_verified2"
                                            value="NO" disabled <?php if ($lmnote->chitha_verified == NO) {echo "checked";}?>
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
                                <span ><strong><?=$sl_count++?>.</strong> Schedule of the land and area under occupation?</<span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="possession_verified"
                                            id="possession_verified1"
                                            value="YES" disabled <?php if ($lmnote->possession_verification == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="possession_verified"
                                            id="possession_verified2"
                                            value="NO" disabled <?php if ($lmnote->possession_verification == NO) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Applicant of type ?</<span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="applicant_type"
                                            id="applicant_type1"
                                            value="YES" disabled <?php if ($basic['applicant_type'] == 'I') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Individual</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="applicant_type"
                                            id="applicant_type2"
                                            value="NO" disabled <?php if ($basic['applicant_type'] == 'N') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">Non individual juridical entity</label>
                                </div>
                            </div>
                        </div>

                        
                        
                        <?php foreach($dags as $wetland):
                               // var_dump($wetland->is_wet_land);
                                ?>
                                <div class="row p-2">
                                        <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> Dag is Wet Land(Jalatak) <span class="alert-warning"><strong>for Dag No. <?=$wetland->dag_no?></strong></span>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="wetland_verified<?=$wetland->dag_no?>"
                                                    id="wetland_verified1_<?=$wetland->dag_no?>"
                                                    value="YES" disabled <?php if ($wetland->is_wet_land == 'Y') {echo "checked";}?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="wetland_verified<?=$wetland->dag_no?>"
                                                    id="wetland_verified2_<?=$wetland->dag_no?>"
                                                    value="NO" disabled <?php if ($wetland->is_wet_land == 'N') {echo "checked";}?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach;?>
                        
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

                                           <?php $nature_possession_value = '';
                                            switch ($naturedag->nature_possession) {
                                                case 1:
                                                    $nature_possession_value = 'Agricultural';
                                                    break;
                                                case 2:
                                                    $nature_possession_value = 'Residential';
                                                    break;
                                                case 3:
                                                    $nature_possession_value = 'Industrial';
                                                    break;
                                                case 4:
                                                    $nature_possession_value = 'Trade';
                                                    break;
                                                case 6:
                                                    $nature_possession_value = 'Plantation';
                                                    break;
                                                case 10:
                                                    $nature_possession_value = 'Institution';
                                                    break;
                                                // Add more cases as needed
                                                default:
                                                    $nature_possession_value = 'Unknown'; // Default value if no cases match
                                                    break;
                                            }
                                            ?>

                                            <!-- <input name="nature_possession<?=$naturedag->dag_no?>" readonly class="form-control" id="nature_possession<?=$naturedag->dag_no?>" value="<?=$naturedag->nature_possession?>"> -->
                                            <input name="nature_possession<?=$naturedag->dag_no?>" readonly class="form-control" id="nature_possession<?=$naturedag->dag_no?>" value="<?=$nature_possession_value?>">
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
                                </select> -->
                            </div>
                        </div>
                        <?php } ?>

                        <?php foreach($dags as $landmark):
                            $land_mark = json_decode($landmark->landmark);
                                ?>
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

                    <?php endif;?>

                        <?php foreach($dags as $agrinonagri):?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Whether Reclassification from agri to Non-agri(For Dags <?=$agrinonagri->dag_no?>) ?</span>
                                <input type="hidden" name="" id="dag_no<?=$agrinonagri->dag_no?>" value="<?=$agrinonagri->dag_no?>">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_agrinonagri<?=$agrinonagri->dag_no?>"
                                        id="is_agrinonagri<?=$agrinonagri->dag_no?>"
                                        value="YES" disabled <?php if ($agrinonagri->is_agri_to_nonagri == 'Y') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_agrinonagri<?=$agrinonagri->dag_no?>"
                                        id="is_agrinonagri1<?=$agrinonagri->dag_no?>"
                                        value="NO" disabled <?php if ($agrinonagri->is_agri_to_nonagri == 'N') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>

                                <?php if($agrinonagri->is_agri_to_nonagri == 'Y') { ?>
                                    <button class="btn btn-sm btn-warning viewModal" onclick="showDagEligibility('<?=$agrinonagri->dag_no?>')" type="button"><i class="fa fa-university"></i>&nbsp;View Details</button>

                                    <button class="btn btn-sm btn-danger closeModal-<?=$agrinonagri->dag_no?>" style="display:none" onclick="closePropertyModal('<?=$agrinonagri->dag_no?>')" type="button"><i class="fa fa-close"></i>&nbsp;Close Details</button>

                                    <div class="addPropertyDetail-<?=$agrinonagri->dag_no?>" style="display:none" >
                                            <div class="tableCard">
                                                    <table class="table table-bordered" id="propertyTable-<?=$agrinonagri->dag_no?>">
                                        <tr>
                                            <th>Is Prime Agri Land</th>
                                            <th>Fit for Reclassification</th>
                                            <th>The land is unfit for cultivation</th>
                                        </tr>
                                    </table>
                                            </div>
                                    </div>

                                <?php } 
                                 if($agrinonagri->is_agri_to_nonagri == 'N') { ?>
                                    <button class="btn btn-sm btn-warning viewModal-<?=$agrinonagri->dag_no?>" onclick="showDagEligibilityforother('<?=$agrinonagri->dag_no?>')" type="button"><i class="fa fa-university"></i>&nbsp;View Details</button>

                                    <button class="btn btn-sm btn-danger closeModal-<?=$agrinonagri->dag_no?>" style="display:none" onclick="closePropertyModal('<?=$agrinonagri->dag_no?>')" type="button"><i class="fa fa-close"></i>&nbsp;Close Details</button>

                                    <div class="addPropertyDetail-<?=$agrinonagri->dag_no?>" style="display:none" >
                                            <div class="tableCard">
                                                    <table class="table table-bordered" id="propertyTable-<?=$agrinonagri->dag_no?>">
                                        <tr>
                                            <th>Fit for Reclassification</th>
                                        </tr>
                                    </table>
                                            </div>
                                    </div>

                                <?php } ?>
                                                                
                                                            <script>
                                                                function viewPropertyModal(){
                                                                    $('.viewModal-'+'<?=$agrinonagri->dag_no?>').hide('slow');
                                                                    $('.closeModal-'+'<?=$agrinonagri->dag_no?>').show('slow');
                                                                    $('.addPropertyDetail-'+'<?=$agrinonagri->dag_no?>').show('slow');
                                                                }

                                                                function closePropertyModal(dag_no) {
                                                                    $('.viewModal-'+dag_no).show('slow');
                                                                    $('.closeModal-'+dag_no).hide('slow');
                                                                    $('.addPropertyDetail-'+dag_no).hide('slow');
                                                                }
                                                            </script>

                            </div>
                        </div>
                         <?php endforeach;?>

                         <?php foreach($dags as $masterplan):
                               // var_dump($wetland->is_wet_land);
                                ?>
                                <div class="row p-2">
                                        <div class="col-md-6">
                                                <strong><?=$sl_count++?>.</strong> The land is within notified master plan area <span class="alert-warning"><strong>for Dag No. <?=$masterplan->dag_no?></strong></span>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="master_plan<?=$masterplan->dag_no?>"
                                                    id="master_plan1_<?=$masterplan->dag_no?>"
                                                    value="YES" disabled <?php if ($masterplan->is_master_plan == 'Y') {echo "checked";}?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="master_plan<?=$masterplan->dag_no?>"
                                                    id="master_plan2_<?=$masterplan->dag_no?>"
                                                    value="NO" disabled <?php if ($masterplan->is_master_plan == 'N') {echo "checked";}?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach;?>

                         <?php foreach($dags as $is_partition_en):?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Type of Reclassification(For Dags <?=$is_partition_en->dag_no?>) ?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_partition_en<?=$is_partition_en->dag_no?>"
                                        id="is_partition_en<?=$is_partition_en->dag_no?>"
                                        value="YES" disabled <?php if ($is_partition_en->is_partition=='Y' && $is_partition_en->is_full_partition=='N') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Partial area Partition(New Dag,Patta will be created)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_partition_en<?=$is_partition_en->dag_no?>"
                                        id="is_partition_en1<?=$is_partition_en->dag_no?>"
                                        value="NO" disabled <?php if ($is_partition_en->is_partition=='Y' && $is_partition_en->is_full_partition=='Y') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">Full area with Partition(New Patta will be created)</label>
                                </div>

                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_partition_en<?=$is_partition_en->dag_no?>"
                                        id="is_partition_en2<?=$is_partition_en->dag_no?>"
                                        value="NO" disabled <?php if ($is_partition_en->is_partition=='N' && $is_partition_en->is_full_partition=='N') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">Full dag reclass</label>
                                </div>

                               

                            </div>
                        </div>
                         <?php endforeach;?>

                        

                        

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
                            <strong><?=$sl_count++?>.</strong> LRA remarks</label>
                        </div>
                        <div class="col-md-6">
                        <input name="lm_remark" readonly class="form-control" id="lm_remark" value="<?php foreach(json_decode(LM_NOTE) as $lm_remark_cat){ if($lm_remark_cat->CODE == $lmnote->lm_note){ echo $lm_remark_cat->NAME;}}?>" cols="30" rows="2">
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
                            <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="11" disabled><?=$lmnote->lm_remark_text?></textarea>
                        </div>
                    </div>

             
                <?php endforeach;?>

            </div>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Uploaded Documents
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php foreach($dhardocuments as $docs): ?>
                        <tr>
                            <th>
                                <input type="hidden" name="district_code" value="<?= $basic['dist_code']; ?>">
                            <input type="hidden" name="doc_id" value="<?= $docs->id ?>">
                            <a target='download' href="<?php echo base_url(); ?>index.php/Basundhara/viewDharitreeDocument/<?= $basic['dist_code']; ?>/<?= $docs->id ?>"><i class="fa fa-paperclip"></i> <?= $docs->file_name; ?></a>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>
    </div>

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
                url: baseurl+'Mb3CommonController/getSelfDocApi',
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

<script>

function showDagEligibility(dag_no) {
            
            var case_no = $.trim($('#case_no').val());
            //var dag_no = $.trim($('#dag_no<?=$agrinonagri->dag_no?>').val());

            var postData = {
                'case_no': case_no,
                'dag_no' : dag_no
            };

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            $.ajax({
                url: baseurl+'ReclassSuiteControllerCO/getDagEligibility',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                               
                    if(arr.responseType == 0){
                        showErrorMessage(arr.msg);
                    }else{

                        // console.log(arr.dag_data[0].is_prime_agri);return;
                        var arr = arr.dag_data[0];
                        $('#propertyTable-'+dag_no).find("tr:gt(0)").remove();
                        var row = '<tr>';
                        row += '<td>' + (arr.is_prime_agri === 'Y' ? 'Yes' : 'No') + '</td>';
                        row += '<td>' + (arr.is_eligible === 'Y' ? 'Yes' : 'No') + '</td>';
                        row += '<td>' + (arr.is_unfit_culti === 'Y' ? 'Yes' : 'No') + '</td>';
                        row += '</tr>';
                        $('#propertyTable-'+dag_no).append(row);
                        $('.addPropertyDetail-'+dag_no).show('slow');
                        $('.viewModal-'+dag_no).hide('slow');
                        $('.closeModal-'+dag_no).show('slow');
                        //$(".btn-api-call").hide();

                        
                    }
                }
            });
        }



    function showDagEligibilityforother(dag_no) {
            
            var case_no = $.trim($('#case_no').val());
            //var dag_no = $.trim($('#dag_no<?=$agrinonagri->dag_no?>').val());

            var postData = {
                'case_no': case_no,
                'dag_no' : dag_no
            };

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            $.ajax({
                url: baseurl+'ReclassSuiteControllerCO/getDagEligibilityforotherthanagrinonagri',
                type: "POST",
                data: postData,
                success: function(data) {
                    $.unblockUI();

                    arr = JSON.parse(data);
                               
                    if(arr.responseType == 0){
                        showErrorMessage(arr.msg);
                    }else{

                        // console.log(arr.dag_data[0].is_eligible);return;
                        var arr = arr.dag_data[0];
                        $('#propertyTable-'+dag_no).find("tr:gt(0)").remove();
                        var row = '<tr>';
                        row += '<td>' + (arr.is_eligible === 'Y' ? 'Yes' : 'No') + '</td>';
                        row += '</tr>';
                        $('#propertyTable-'+dag_no).append(row);
                        $('.addPropertyDetail-'+dag_no).show('slow');
                        $('.viewModal-'+dag_no).hide('slow');
                        $('.closeModal-'+dag_no).show('slow');
                        //$(".btn-api-call").hide();

                        
                    }
                }
            });
        }
</script>
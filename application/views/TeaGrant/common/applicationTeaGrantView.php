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

    <h5 class="bgheading p-2 text-white shadow" style="background: #248cf7 !important; margin-top: 10px">
        Limited Conversion of Tea Grant Land to Periodic Patta (
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
                            <?php if($settlement->is_applicant == 1) { ?>
                                <th>Possession Since</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?=$settlement->period_possession?>
                                    </strong>
                                </td>
                            <?php } ?>
                        </tr>

                        <?php

                            $pre_addr = json_decode($settlement->pdar_add1);
                            $per_addr = json_decode($settlement->pdar_add2);
                        ?>


                        <tr>
                            <th>Present address</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=isset($pre_addr->address)?$pre_addr->address:'' ?>
                                </strong>
                            </td>
                            <th>
                                Permanent address
                            </th>
                            <td>
                                <strong class="alert-warning">
                                    <?=isset($per_addr->address)?$per_addr->address:''?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php $i++;?>
            <?php endforeach;?>


            

            
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
                            <th rowspan="2" style="vertical-align : middle;">
                                <div class="vertical">
                                    DAG : <span class="text-danger"><?=$all_dags->dag_no?></span> <br> 
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

                        

                        <!-- area settlement homestead -->
                        <?php $hide = 'area_show';
                            if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                                $hide = 'area_show';
                            } else {
                                $hide = 'area_hide';
                            }
                        ?>
                        <tr class='<?=$hide?>' class="bg-white">
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
                        </tr>

                        <?php } ?>

                        <th rowspan="2">
                        </th>

                        <?php

                            $total_applied_bigha  = 0;
                            $total_applied_katha  = 0;
                            $total_applied_lessa  = 0;
                            $total_applied_ganda  = 0;
                            $total_applied_kranti = 0;

                            foreach ($dags as $all_dags) 
                            {
                                $total_applied_bigha = $total_applied_bigha + $all_dags->s_dag_area_b;
                                $total_applied_katha = $total_applied_katha + $all_dags->s_dag_area_k;
                                $total_applied_lessa = $total_applied_lessa + $all_dags->s_dag_area_lc;
                                $total_applied_ganda = $total_applied_ganda + $all_dags->s_dag_area_g;
                                $total_applied_kranti = $total_applied_kranti + $all_dags->s_dag_area_kr;
                            }

                            if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))) 
                            {
                                $convert_area = floor(($total_applied_bigha * 6400) + ($total_applied_katha * 320) + 
                                    ($total_applied_lessa * 20) + 
                                    $total_applied_ganda);

                                $total_applied_bigha = floor($convert_area / 6400);

                                $total_applied_katha = floor(($convert_area - ($total_applied_bigha * 6400))/320);

                                $total_applied_lessa = floor(($convert_area - ($total_applied_bigha * 6400 + $total_applied_katha * 320))/20);

                                $total_applied_ganda = number_format($convert_area - ($total_applied_bigha * 6400 + $total_applied_katha * 320 + $total_applied_lessa * 20), 2);

                                $total_applied_kranti = 0;
                            }
                            else
                            {
                                $convert_area = ($total_applied_bigha * 100) + 
                                               ($total_applied_katha * 20) + 
                                               $total_applied_lessa;

                                $total_applied_bigha = floor($convert_area / 100);

                                $total_applied_katha = floor(($convert_area - ($total_applied_bigha * 100))/20);

                                $total_applied_lessa = number_format($convert_area - ($total_applied_bigha * 100 + $total_applied_katha * 20), 2);

                                $total_applied_ganda  = 0;

                                $total_applied_kranti = 0;
                            }

                        ?>                                                

                        <tr class='<?=$hide?>' class="bg-white">
                            <td class="settlement-area-color text-danger"><strong>Total Applied Area</strong></td>
                            <td class="settlement-area-color text-danger" style="text-align:center">
                                <strong><?=$total_applied_bigha?></strong>
                                <input type="hidden" style="text-align: center;" name="tot_applied_b" class="form-control input-sm tot_applied_b" 
                                value="<?=$total_applied_bigha?>" id="tot_applied_b" readonly>
                            </td>
                            <td class="settlement-area-color text-danger" style="text-align:center">
                                <strong><?=$total_applied_katha?></strong>
                                <input type="hidden" style="text-align: center;" name="tot_applied_k" value="<?=$total_applied_katha?>" class="form-control input-sm tot_applied_k" id="tot_applied_k" readonly>
                            </td>
                            <td class="settlement-area-color text-danger" style="text-align:center">
                                <strong><?=$total_applied_lessa?></strong>
                                <input type="hidden" style="text-align: center;" name="tot_applied_lc" value="<?=$total_applied_lessa?>" class="form-control input-sm tot_applied_lc" id="tot_applied_lc" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td class="settlement-area-color text-danger" style="text-align:center">
                                    <strong><?=$total_applied_ganda?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$total_applied_ganda?>" class="form-control input-sm tot_applied_g" name="tot_applied_g"
                                    id="tot_applied_g" readonly>
                                </td>
                                <td class="settlement-area-color text-danger" style="text-align:center">
                                    <strong><?=$total_applied_kranti?></strong>
                                    <input type="hidden" style="text-align: center;" value="<?=$total_applied_kranti?>" class="form-control input-sm tot_applied_kr" name="tot_applied_kr" id="tot_applied_kr"
                                    readonly>
                                </td>
                            <?php endif; ?>
                        </tr>

                    </thead>
                </table>
                
            </div>


            <!-- additional property -->
            <?php if(isset($additional_property) && !empty($additional_property)) { ?>
                <h5  class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Additional Property Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <?php $i=1; foreach($additional_property as $adp): ?>
                            <tr>
                                <th>District Name:</th>
                                <td class="text-warning">
                                    <strong class="alert-warning">
                                        <input type="text" name="a_dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($adp->dist_code)?>' readonly>
                                    </strong>
                                </td>
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
                                    </strong>
                                </td>
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
                                <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
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
            <?php } ?>

            <!-- additional property end -->

            <!-- existing pattadar starts here -->
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-users"></i>  Existing Pattadar
            </h5>
            <?php if(!empty($existing_pattadar)) { ?>
                <div class="tableCard">
                    <table class="table table-bordered" id="existingPattadar">
                        <tr>
                            <th>Name</th>
                            <th>Guardian Name</th>
                            <th>Contact No</th>
                        </tr>
                        <?php $i = 1;foreach ($existing_pattadar as $ep): ?>
                            <tr id="sp<?=$ep->id?>">
                                <td>
                                    <span><?=$ep->pdar_name?></span>
                                </td>
                                <td>
                                    <span><?=$ep->pdar_guardian?></span>
                                </td>
                                <td>
                                    <span><?=$ep->pdar_mobile?></span>
                                </td>
                            </tr>
                            <?php $i++;?>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php } else { ?>
                <div class="tableCard familyVisibleHide">
                    <table class="table table-bordered" id="existingPattadar">
                        <tr>
                            <th>Name</th>
                            <th>Guardian Name</th>
                            <th>Contact No</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <!-- existing pattadar ends here -->

            <!-- deed applicant starts here -->
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-users"></i>  Deed Applicant
            </h5>
            <?php if(!empty($deed_applicant)) { ?>
                <div class="tableCard">
                    <table class="table table-bordered" id="deedApplicant">
                        <tr>
                            <th>Dag No / Patta No</th>
                            <th>Name</th>
                            <th>Guardian Name</th>
                            <th>Gender</th>
                            <th>Contact No</th>
                            <th>DOB</th>
                        </tr>
                        <?php 

                            $i = 1;foreach ($deed_applicant as $da): 
                            if($da->pdar_gender == 1)
                            {
                                $gender = "Male";
                            }
                            else if($da->pdar_gender == 2)
                            {
                                $gender = "Female";
                            }
                            else
                            {
                                $gender = "Others";
                            }

                        ?>
                            <tr id="sp<?=$da->id?>">
                                <td>
                                    <span><?=$da->dag_no.' | '.$da->patta_no?></span>
                                </td>
                                <td>
                                    <span><?=$da->eng_pdar_name.'/'.$da->pdar_name?></span>
                                </td>
                                <td>
                                    <span><?=$da->eng_pdar_guardian.'/'.$da->pdar_guardian?></span>
                                </td>
                                <td>
                                    <span><?=$gender?></span>
                                </td>
                                <td>
                                    <span><?=$da->pdar_mobile?></span>
                                </td>
                                <td>
                                    <span><?=$da->dob?></span>
                                </td>
                            </tr>
                            <?php $i++;?>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php } else { ?>
                <div class="tableCard familyVisibleHide">
                    <table class="table table-bordered" id="deedApplicant">
                        <tr>
                            <th>Dag No / Patta No</th>
                            <th>Name</th>
                            <th>Guardian Name</th>
                            <th>Gender</th>
                            <th>Contact No</th>
                            <th>DOB</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <!-- deed applicant ends here -->


            <!-- family tree starts here -->
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-users"></i>  Family Tree
            </h5>
            <?php if(!empty($family_tree)) { ?>
                <div class="tableCard">
                    <table class="table table-bordered" id="familyTree">
                        <tr>
                            <th>Name</th>
                            <th>Guardian Name</th>
                            <th>Relation</th>
                        </tr>
                        <?php 

                            $i = 1;foreach ($family_tree as $ft): 

                            if($ft->pdar_type=='P')
                            {
                                $relation = 'Parent';
                            }
                            if($ft->pdar_type=='GP')
                            {
                                $relation = 'Grand Parent';
                            }
                            if($ft->pdar_type=='GPP')
                            {
                                $relation = 'Great Grand Parent';
                            }

                        ?>
                            <tr id="sp<?=$ft->id?>">
                                <td>
                                    <span><?=$ft->eng_pdar_name.'/'.$ft->pdar_name?></span>
                                </td>
                                <td>
                                    <span><?=$ft->eng_pdar_guardian.'/'.$ft->pdar_guardian?></span>
                                </td>
                                <td>
                                    <span><?=$relation?></span>
                                </td>
                            </tr>
                            <?php $i++;?>
                        <?php endforeach;?>
                    </table>
                </div>
            <?php } else { ?>
                <div class="tableCard familyVisibleHide">
                    <table class="table table-bordered" id="familyTree">
                        <tr>
                            <th>Name</th>
                            <th>Guardian Name</th>
                            <th>Relation</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <!-- family tree ends here -->


            <!--- Nominee details starts here --mdz- --->
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-users"></i>  Family Details            
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
                            <th>Nominee name</th>
                            <th>Relation with Applicant</th>
                            <th>Address of Nominee</th>
                            <th>Mobile number</th>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <!--- Nominee details ends here --mdz- --->

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Supporting Documents
                <button class="btn btn-sm btn-warning btn-api-call" onclick="showSelfAndDocument()" type="button"><i class="fa fa-university"></i>&nbsp;View Supporting Documents</button>
            </h5>
            <div class="tableCard">
                <table class="table table-bordered" id="apidoc">
                    <?php //foreach ($document as $d): ?>
                        <!-- <tr>
                            <th>
                                <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                            </th>
                        </tr> -->
                    <?php //endforeach;?>
                </table>
            </div>
            <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
        </div>
    </div>
    <ul class="list-inline pull-right" style="margin-top: 20px">
        <li>
            <button id="next_id" type="button" class="btn btn-primary next-step">
                <i class="fa fa-arrow-circle-right"> </i> Next
            </button>
        </li>
    </ul>
</div>





<!-- LM reporting starts here -->
<div class="tab-pane" role="tabpanel" id="step2">

    <h5 class="bgheading p-2 text-white shadow"  style="background: #248cf7 !important; margin-top: 10px">
        Limited Conversion of Tea Grant Land to Periodic Patta (
        <span class="bg-warning"><?=$_GET['case']?></span> )
    </h5>
    <div class="reza-card">
        <div class="reza-body ">
            <h5  class="reza-title" style="margin-top: 15px">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
            </h5>
            <div class="tableCard">
                <?php $sl_count =1; $i = 1;foreach ($lmnotes as $lmnote): 
                    if($validation_bypass == 0):

                      $lm_tea_report = json_decode($lmnotes[0]->lm_tea_report);
                    
                        ?>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Chitha verified and found the applicant / applicants predecessor as a pattadar ?</span >
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
                                <span ><strong><?=$sl_count++?>.</strong> Whether applicant / applicants predecessor is a Bonafide transferee ?</span >
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="bonfide_transferee"
                                            id="bonfide_transferee1"
                                            value="YES" disabled <?php if ($lmnote->chitha_verified == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="bonfide_transferee"
                                            id="bonfide_transferee2"
                                            value="NO" disabled <?php if ($lmnote->chitha_verified == NO) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            
                        </div>

                        <?php if(!isset($lmnote->lm_rejected_remarks)) { ?>
                        
                            <div class="row p-2" >
                                <div class="col-md-6">
                                    <span ><strong><?=$sl_count++?>.</strong> Caste Verified: whether applicant belongs to the caste as mentioned in application as per the verification of the caste cerficate uploaded?</span><br>
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
                                    <?php } ?>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under Tribal Belt/ Block?</span>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="whether_tribal"
                                            id="whether_tribal1"
                                            value="YES"
                                            disabled
                                        <?php if ($lmnote->is_tribal_belt == YES) {echo "checked";}?>
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
                                        <?php if ($lmnote->is_tribal_belt == NO) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            <?php if ($lmnote->is_tribal_belt == YES) { ?>
                              <div class="col-md-4" id="tribal_belt_input_id">
                                <input type="text" class="form-control" name="tribal_belt_name" readonly placeholder="Enter name of the Tribal belt block" value="<?=(!empty($lm_tea_report->tribal_belt_name))?$lm_tea_report->tribal_belt_name:''?>">
                              </div>
                            <?php } ?>
                        </div>


                        <?php if ($lmnote->is_tribal_belt == YES) { ?>

                          <div class="row p-2" id="protected_class_id">
                            <div class="col-md-6 text-justify">
                              <span><strong>-></strong>
                              Does the applicant falls under protected category as mentioned in that particular tribal belt/block and eligible under section 163(2)(a), 163(2)(b)?</span>
                              <?=form_error('protected_class_lm')?>
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

                        <?php } else if ($lmnote->is_tribal_belt == NO) { ?>  

                          <div class="row p-2" id="contravention">
                            <div class="col-md-6">
                              <span><strong>-></strong>
                              Whether the occupancy tenant right has been conferred in contravention of provisions of chapter 10?</span>
                              <?=form_error('contravention')?>
                            </div>
                            <div class="col-md-6">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                       type="radio"
                                       name="contravention"
                                       id="landed_property1"
                                       value="YES"
                                    <?php if ((!empty($lm_tea_report->contravention)) && $lm_tea_report->contravention == 'YES') {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                        type="radio"
                                        name="contravention"
                                        id="landed_property2"
                                        value="NO"
                                    <?php if ((!empty($lm_tea_report->contravention)) && $lm_tea_report->contravention == 'NO') {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                              </div>
                            </div>
                          </div>

                        <?php } ?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Schedule of the land and area under possession have been verified and found correct ?
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="possession_verification"
                                        value="YES" disabled <?php if (trim($lmnote->possession_verification) == YES){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">YES</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="possession_verification"
                                        value="NO" disabled <?php if (trim($lmnote->possession_verification) == NO){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <textarea placeholder="Remarks(if any)" readonly rows="3" class="form-control" name="lra_possession_remark" id="lra_possession_remark"><?=(!empty($lm_tea_report->lra_possession_remark))?$lm_tea_report->lra_possession_remark:''?></textarea>
                            </div>

                        </div>
                        

                        <?php
                        $display_old_nature=0;
                        foreach($dags as $key=>$naturedag):
                            if (!is_null($naturedag->nature_possession)){
                                $display_old_nature=0;
                                $landClassCode = $lm_tea_report->land_class;

                                // var_dump($landClassCode[$key]->land_class); die;

                                ?>
                                <div class="row p-2">
                                        <div class="col-md-6">
                                            <strong><?=$sl_count++?>.</strong> Nature of possession <span class="alert-warning"><strong>in the Dag <?=$naturedag->dag_no?></strong></span>
                                        </div>
                                        <div class="col-md-6">
                                            <input name="nature_possession<?=$naturedag->dag_no?>" readonly class="form-control" id="nature_possession<?=$naturedag->dag_no?>" value="<?=$naturedag->nature_possession?>">
                                        </div>
                                </div>
                                <!-- <div class="row p-2">
                                        <div class="col-md-6">
                                            <strong><?=$sl_count++?>.</strong> Land use class(as per govt records) <span class="alert-warning"><strong>in the Dag <?=$naturedag->dag_no?></strong></span>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" readonly class="form-control" name="prev_land_class_name<?=$naturedag->dag_no?>" id="prev_land_class_name<?=$naturedag->dag_no?>"
                                            value="<?=$this->TeaGrantModel->getLandClassDetail($naturedag->dist_code, $naturedag->subdiv_code, $naturedag->cir_code, $naturedag->mouza_pargona_code, $naturedag->lot_no, $naturedag->vill_townprt_code, $naturedag->patta_no, $naturedag->patta_type_code, $naturedag->dag_no)->land_type?>">
                                        </div>
                                </div> -->


                                <div class="row p-2" >
                                  <div class="col-md-6">
                                  <span>
                                    <strong><?=$sl_count++?>.</strong> Previous land use class  ?
                                  </span>
                                  </div>
                                  <div class="form-group col-md-6">

                                    <input type="text" readonly class="form-control" name="prev_land_class_name<?=$naturedag->dag_no?>" id="prev_land_class_name<?=$naturedag->dag_no?>"
                                    value="<?=$this->TeaGrantModel->getLandClassDetail($naturedag->dist_code, $naturedag->subdiv_code, $naturedag->cir_code, $naturedag->mouza_pargona_code, $naturedag->lot_no, $naturedag->vill_townprt_code, $naturedag->patta_no, $naturedag->patta_type_code, $naturedag->dag_no)->land_type?>">

                                    <input type="hidden" name="prev_land_class_code<?=$naturedag->dag_no?>" id="prev_land_class_code<?=$naturedag->dag_no?>" 
                                    value="<?=$this->TeaGrantModel->getLandClassDetail($naturedag->dist_code, $naturedag->subdiv_code, $naturedag->cir_code, $naturedag->mouza_pargona_code, $naturedag->lot_no, $naturedag->vill_townprt_code, $naturedag->patta_no, $naturedag->patta_type_code, $naturedag->dag_no)->land_class_code?>">

                                  </div>
                                </div>

                                <?php 

                                // var_dump($landClassCode[$key]->land_class); die;

                                if($landClassCode[$key]->land_class != false || $landClassCode[$key]->land_class != 0) { ?>
                                    <div class="row p-2">
                                        <div class="col-md-6">
                                            <strong><?=$sl_count++?>.</strong>Present land use class <span class="alert-warning"><strong>in the Dag <?=$naturedag->dag_no?></strong></span>
                                        </div>
                                        <div class="col-md-6">

                                            <input type="hidden" class="form-control" name="land_falls" id="land_falls" value="<?=$landClassCode[$key]->land_class?>">

                                            <input type="text" class="form-control" name="land_falls_name" id="land_falls_name" value="<?=$this->TeaGrantModel->landClassName($landClassCode[$key]->land_class)->name_ass?>" disabled>
                                            
                                        </div>
                                    </div>
                                <?php } ?>


                        <?php } else { $display_old_nature=1; } endforeach;?>

                        <?php if ($display_old_nature == 1){ ?>
                        <div class="row p-2" >
                            <div class="col-md-6">
                                <span><strong><?=$sl_count++?>.</strong> Nature of possession –</span>
                            </div>
                            <div class="form-group col-md-6">

                                <input name="nature_possession" readonly class="form-control" id="nature_possession" value="<?=$lmnote->nature_possession?>">
                            </div>
                        </div>
                        <div class="row p-2" >
                          <div class="col-md-6">
                          <span>
                            <strong><?=$sl_count++?>.</strong> Previous land use class  ?
                          </span>
                          </div>
                          <div class="form-group col-md-6">

                            <input type="text" readonly class="form-control" name="prev_land_class_name<?=$naturedag->dag_no?>" id="prev_land_class_name<?=$naturedag->dag_no?>"
                            value="<?=$this->TeaGrantModel->getLandClassDetail($naturedag->dist_code, $naturedag->subdiv_code, $naturedag->cir_code, $naturedag->mouza_pargona_code, $naturedag->lot_no, $naturedag->vill_townprt_code, $naturedag->patta_no, $naturedag->patta_type_code, $naturedag->dag_no)->land_type?>">

                            <input type="hidden" name="prev_land_class_code<?=$naturedag->dag_no?>" id="prev_land_class_code<?=$naturedag->dag_no?>" 
                            value="<?=$this->TeaGrantModel->getLandClassDetail($naturedag->dist_code, $naturedag->subdiv_code, $naturedag->cir_code, $naturedag->mouza_pargona_code, $naturedag->lot_no, $naturedag->vill_townprt_code, $naturedag->patta_no, $naturedag->patta_type_code, $naturedag->dag_no)->land_class_code?>">

                          </div>
                        </div>
                        <?php } ?>

                        <!-- <div class="row p-2">
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Whether applicant and his/her family has patta land and land as tenant including the land applied for exceed ceiling limit ?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        value="YES" disabled <?php if (trim($lmnote->is_landless) == YES){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">YES</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        value="NO" disabled checked <?php if (trim($lmnote->is_landless) == NO){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div> -->

                        

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span ><strong><?=$sl_count++?>.</strong> Whether total patta/tenancy land held by the applicant family including the land applied for as above exceeds ceiling limit under relevant provisions of the Assam Fixation of Ceiling on Land holdings Act, 1956?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        value="YES" disabled <?php if (trim($lmnote->is_landless) == YES){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">YES</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        value="NO" disabled <?php if (trim($lmnote->is_landless) == NO){ echo "checked"; } ?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>                       

                        

                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Whether the proposed land falls within gmc/municipal town/revenue town?
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="landslide"
                                            id="landslide"
                                            value="YES" disabled <?php if ($lmnote->landslide == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="landslide"
                                            id="landslide"
                                            value="NO" disabled <?php if ($lmnote->landslide == NO) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>


                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Whether proposed land falls within notified gmda/notified master plan area/ within 5 km periphery (wherever applicable) ?
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="land_falls_periphery"
                                            id="land_falls_periphery"
                                            value="YES" disabled <?php //if ($lmnote->land_falls_periphery == YES) {echo "checked";}?>
                                            <?php if ((!empty($lm_tea_report->land_falls_periphery)) && $lm_tea_report->land_falls_periphery == 'YES') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="land_falls_periphery"
                                            id="land_falls_periphery"
                                            value="NO" disabled <?php if ((!empty($lm_tea_report->land_falls_periphery)) && $lm_tea_report->land_falls_periphery == 'NO') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>



                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Specific comment on roadside /riverside reservation (if any, along with provision kept for road/drain wherever necessary by relinquishing (istafa)
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="roadside_comment_check"
                                            id="roadside_comment_check"
                                            value="YES" disabled <?php if ($reservation == true) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="roadside_comment_check"
                                            id="roadside_comment_check"
                                            value="NO" disabled <?php if ($reservation == false) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>




                        <div class="row p-2" >
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Dispute regarding possession, if any, in Courts or if the land parcel under question is under sub judice.
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="dispute_possession"
                                            id="dispute_possession"
                                            value="YES" disabled 
                                            <?php if ((!empty($lm_tea_report->dispute_possession)) && $lm_tea_report->dispute_possession == 'YES') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="dispute_possession"
                                            id="dispute_possession"
                                            value="NO" disabled  <?php if ((!empty($lm_tea_report->dispute_possession)) && $lm_tea_report->dispute_possession == 'NO') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                            <div class="col-md-4 div_category_type">
                                Category Type
                                <input class="form-control" readonly
                                type="text" name="dis_cat_type" id="dis_cat_type"
                                placeholder="Enter Category Type" 
                                value="<?=(!empty($lm_tea_report->dis_cat_type) && isset($lm_tea_report->dis_cat_type)) ? $lm_tea_report->dis_cat_type : ''?>"
                                />                            
                            </div>
                        </div>




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
                                                <span>Dag No: <?=$reserv_road->dag_no?></span>
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
                        <?php if ($reservation == true) {?>
                            <div class="row p-2" >
                                <div class="col-md-6">
                                    <span ><strong><?=$sl_count++?>.</strong> Whether applicant family has occupied any land in the lot?</span>
                                </div>
                                <div class="col-md-6">
                                    <div id="road_side_reservation_hide" class="road_side_reservation_hide">
                                        <?php foreach ($reservation as $reserv) {
                                            if ($reserv->type == "F") {?>
                                                <span>Dag No: <?=$reserv->dag_no?></span>
                                                <div class="form-group row mt-2">
                                                    <input disabled type="hidden" name="dag_no<?=$reserv->dag_no?>" value="<?=$reserv->dag_no?>">
                                                    <div class="col-4">
                                                        <span class="input-group-addon">Bigha</span>
                                                        <input disabled type="text" style="text-align: center;" value="<?=$reserv->bigha?>" class="form-control input-sm" name="reserved_bigha_family<?=$reserv->dag_no?>" id="reserved_bigha_family">
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="input-group-addon">Katha</span>
                                                        <input disabled type="text" style="text-align: center;" value="<?=$reserv->katha?>" class="form-control input-sm" name="reserved_katha_family<?=$reserv->dag_no?>" id="reserved_katha_family" >
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="input-group-addon">Lessa</span>
                                                        <input disabled type="text" style="text-align: center;" value="<?=$reserv->lessa?>" class="form-control input-sm" name="reserved_lessa_family<?=$reserv->dag_no?>" id="reserved_lessa_family" >
                                                    </div>
                                                </div>
                                                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                                    <div class="form-group row mt-2">
                                                        <div class="col-4">
                                                            <span class="input-group-addon">Ganda</span>
                                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv->ganda?>" class="form-control input-sm" name="reserved_ganda_family<?=$reserv->dag_no?>" >
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="input-group-addon">Kranti</span>
                                                            <input disabled type="text" style="text-align: center;" value="<?=$reserv->kranti?>" class="form-control input-sm" name="reserved_kranti_family<?=$reserv->dag_no?>" >
                                                        </div>
                                                    </div>
                                                <?php endif;?>
                                            <?php }}?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>


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

                    <?php if($validation_bypass == 1) {?>

                        <?php if(!isset($lmnote->lm_rejected_remarks)) { ?>
                            <div class="row p-2" >
                                <div class="col-md-6">
                                    <span ><strong><?=$sl_count++?>.</strong> Caste Verified: whether applicant belongs to the caste as mentioned in application as per the verification of the caste cerficate uploaded?</span><br>
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
                    <?php }?>

                    <div class="row p-2">
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong> Possession Since</label>
                        </div>
                        <div class="col-md-6">
                        <input name="lm_possession_entry" readonly class="form-control" id="lm_possession_entry" value="<?=(!empty($lm_tea_report->lm_possession_entry))?$lm_tea_report->lm_possession_entry:''?>" cols="30" rows="2">
                        </div>
                    </div>

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
                            include(APPPATH."views/TeaGrant/common/rejectedRemarks.php");
                        ?>
                        </div>
                    </div>

                    
                    <div class="row p-2 justify-content-end" style="padding-bottom: 15px!important;">
                        <div class="col-md-12">
                            <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="11" disabled><?=$lmnote->lm_remark_text?></textarea>
                        </div>
                    </div>

                    <!-- <div class="row p-2" >
                        <div class="col-md-6">
                            <strong><?=$sl_count++?>.</strong> Whether total patta/ tenancy land held by the applicant family including the land applied for as above exceeds ceiling limit under relevant provisions of the Assam Fixation of Ceiling on Land Holdings Act,1956
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="land_exceed"
                                        id="land_exceed"
                                        value="YES" disabled checked<?php //if ($lmnote->land_exceed == YES) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="land_exceed"
                                        id="land_exceed"
                                        value="NO" disabled  <?php //if ($lmnote->land_exceed == NO) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div> -->


                    <?php //if(!isset($lmnote->lm_rejected_remarks)) { ?>

                        <?php $lmData = json_decode($lmnote->lm_tea_report); ?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <strong><?=$sl_count++?>.</strong> Deed No</label>
                            </div>
                            <div class="col-md-6">
                            <input name="deed_no" readonly class="form-control" id="deed_no" value="<?=(!empty($lmData->lra_deed_no))?$lmData->lra_deed_no:''?>" cols="30" rows="2">
                            </div>
                        </div>

                        <?php if(!empty($lmData->lra_deed_date)) { ?>

                            <div class="row p-2">
                                <div class="col-md-6">
                                    <strong><?=$sl_count++?>.</strong> Deed Date</label>
                                </div>
                                <div class="col-md-6">
                                <input name="deed_date" readonly class="form-control" id="deed_date" value="<?=(!empty($lmData->lra_deed_date))?date('d/m/Y', strtotime($lmData->lra_deed_date)):''?>" cols="30" rows="2">
                                </div>
                            </div>
                        <?php } ?>
                    <?php //} ?>

             
                <?php endforeach;?>

            </div>

            <?php //if(!isset($lmnote->lm_rejected_remarks)) { ?>

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

                        
                        </tr>
                    </table>
                </div>

            <?php //} ?>

        </div>
    </div>
    <ul class="list-inline pull-right" style="margin-top: 20px">
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
                                href: baseurl+'SettlementCommon/documentmb3/'+arr.document[x].name,
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
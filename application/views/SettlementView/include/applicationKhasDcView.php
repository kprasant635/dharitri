<div class="tab-pane active" role="tabpanel" id="step1">

    <h5 class="bgheading p-2 text-white shadow" style="background: #248cf7 !important; margin-top: 10px">
        <?php echo $this->lang->line('khasLand')?> (
        <span class="bg-warning"><?=$_GET['case']?></span> )
    </h5>
    <div class="reza-card">
        <div class="reza-body">
            <h5 class="reza-title" style="margin-top: 15px">
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
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php
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
                    <?php }?>
                </table>
            </div>



            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-user"></i>  Applicant details
            </h5>
            <?php $i = 1;foreach ($applicants_buyers as $settlement): ?>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr >
                            <th rowspan="5" style="vertical-align : middle;text-align:center; min-width: 4%!important; max-width: 4%!important; width: 4%">
                                <?=$i;?>
                            </th>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Name</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_name;?>
                                </strong>
                            </td>
                            <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Guardian name</th>
                            <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                <strong class="alert-warning">
                                    <?=$settlement->pdar_guardian;?>
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
                    <i class="fa fa-user-secret"></i>  Encroacher Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <?php $sl = 1; foreach ($encdata as $riotee) { ?>
                            <tr >
                                <th rowspan="3" style="vertical-align : middle;text-align:center; width: 4%!important; max-width: 4%!important;; min-width: 4%!important;">
                                    <?=$sl++;?>
                                </th>
                            </tr>
                            <tr >
                                <th style="width: 30%!important; max-width: 30%!important; min-width: 30%!important;">Name</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?=$riotee[0]->name;?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Father's name</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?=$riotee[0]->fathers_name;?>
                                    </strong>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
            <?php }?>


            <?php if(isset($basic["bhumiputra_certificate_no"])){?>

                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bhumiputra certificate/Ack verified?</th>
                            <td>
                                <?php if($basic['bhumiputra_confirmation'] == YES) : ?>
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


            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-text"></i>  Application Details
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
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
                </table>
            </div>
            <?php if ($nextKin) {?>
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
                        <?php $i = 1;foreach ($nextKin as $kin): ?>
                            <tr>
                                <td>
                                    <?=$kin->next_of_kin_name?>
                                </td>
                                <td>
                                    <?=$this->utilityclass->appRelationbyIDMB2($kin->relation_with_kin)?>
                                </td>
                                <td>
                                    <?=$kin->address?>
                                </td>
                                <td>
                                    <?=$kin->mobile_no?>
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
                <table class="table table-bordered">
                    <?php foreach ($dags as $all_dags) {?>
                        <tr>
                            <th>Dag Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$all_dags->dag_no?>
                                </strong>
                            </td>
                            <th>Patta Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$all_dags->patta_no?>
                                </strong>
                            </td>
                            <th>Patta type:</th>
                            <td>
                                <strong class="alert-warning">
                                    <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Land Area in Selected Dag</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <strong>
                                    <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" readonly>
                                </strong>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly>
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                        <?php $hide = 'area_show';
                        if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                            $hide = 'area_show';
                        } else {
                            $hide = 'area_hide';
                        }

                        ?>
                        <tr class='<?=$hide?>'>
                            <th class="text-primary">Applied area (Homestead)</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <input type="text" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_dags->home_b?>" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="home_k" value="<?=$all_dags->home_k?>" class="form-control input-sm home_k" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" style="text-align: center;" name="home_lc" class="form-control input-sm s_dag_area_lc" value="<?=$all_dags->home_lc?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->home_kr?>" class="form-control input-sm s_dag_area_kr" name="home_kr" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                        <?php $hide = 'area_show';
                        if ($all_dags->land_type == 2) {
                            $hide = 'area_show';
                        } else {
                            $hide = 'area_hide';
                        }

                        ?>
                        <tr class='<?=$hide?>'>
                            <th class="text-primary">Applied area (Agricultural)</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <input type="text" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b?>" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="agri_k" value="<?=$all_dags->agri_k?>" class="form-control input-sm agri_k" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->agri_g?>" class="form-control input-sm agri_g" name="agri_g" readonly>
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" readonly>
                                </td>
                            <?php endif;?>
                        </tr>

                        <tr>
                            <th class="text-primary">Applied area (Fishery)</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <input type="text" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$all_dags->fbigha?>" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="fkatha" value="<?=$all_dags->fkatha?>" class="form-control input-sm fkatha" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$all_dags->flessa?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->fganda?>" class="form-control input-sm fganda" name="fganda" readonly>
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$all_dags->fkranti?>" class="form-control input-sm fkranti" name="fkranti" readonly>
                                </td>
                            <?php endif;?>
                        </tr>
                    <?php }?>

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
            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-file-pdf-o"></i> Supporting Documents
            </h5>
            <div class="tableCard">
                <table class="table table-bordered">
                    <?php foreach ($document as $d): ?>
                        <tr>
                            <th>
                                <a target='download' href="<?php echo base_url(); ?>index.php/basundhara2/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                                <!-- <input type="hidden" name="case_no" value="<?=$d->case_no;?>"> -->
                                <!-- <input type="hidden" name="user_code" value="<?=$d->user_code;?>"> -->
                                <input type="hidden" name="file_name" value="<?=$d->name;?>">
                                <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                                <input type="hidden" name="file_path" value="<?=$d->path;?>">
                                <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                                <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                            </th>
                        </tr>
                    <?php endforeach;?>
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
        <?php echo $this->lang->line('khasLand')?> (
        <span class="bg-warning"><?=$_GET['case']?></span> )
    </h5>
    <div class="reza-card">
        <div class="reza-body ">
            <h5  class="reza-title" style="margin-top: 15px">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LM Report
            </h5>
            <div class="tableCard">
                <?php $sl_count =1; $i = 1;foreach ($lmnotes as $lmnote): ?>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <span ><strong><?=$sl_count++?>.</strong> Chitha Verified?</span >
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
                            <span ><strong><?=$sl_count++?>.</strong> VLB Verified?</span>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="vlb_verified"
                                        id="vlb_verified1"
                                        value="YES" disabled <?php if ($lmnote->vlb_verified == YES) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="vlb_verified"
                                        id="vlb_verified2"
                                        value="NO" disabled <?php if ($lmnote->vlb_verified == NO) {echo "checked";}?>
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
                            <span ><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                            <?php if(isset($basic['bhumiputra_certificate_no'])){?>
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
                            <span><strong><?=$sl_count++?>.</strong> Is Encroacher Exists in VLB ? </span>
                        </div>
                        <div class="form-group col-md-6">
                            <select
                                    name="encroacher_exist_vlb"
                                    id="encroacher_exist_vlb"
                                    class="form-control" disabled>
                                <option value="">select...</option>
                                <option value="Name exists" <?php if ($lmnote->encroacher_exist_vlb == "Name exists") {echo "selected";}?>>Name Exists</option>
                                <option value="Name exists but Procession not found" <?php if ($lmnote->encroacher_exist_vlb == "Name exists but Procession not found") {echo "selected";}?>>Name exists but Procession not found</option>
                                <option value="Name does not exists" <?php if ($lmnote->encroacher_exist_vlb == "Name does not exists") {echo "selected";}?>>Name does not exists</option>
                            </select>
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
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6 text-justify">
                            <span><strong><?=$sl_count++?>.</strong> Does applicant falls under protected category?</span>
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
                            <span><strong><?=$sl_count++?>.</strong> Is Area Under cover landslide prone ? </span>
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
                            <span><strong><?=$sl_count++?>.</strong> Whether the land falls under erosion?</span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="erosion"
                                        value="YES" disabled <?php if ($lmnote->erosion == YES){ echo "checked"; } ?>
                                />
                                <label class="form-check-label" for="inlineRadio1">YES</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="erosion"
                                        value="NO" disabled <?php if ($lmnote->erosion == NO){ echo "checked"; } ?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Nature of possession –</span>
                        </div>
                        <div class="form-group col-md-6">
                            <select
                                    name="nature_possession"
                                    id="nature_possession"
                                    class="form-control" disabled
                            >
                                <option value="Agricultural" <?php if ($lmnote->nature_possession == "Agricultural") {echo "selected";}?>>Agricultural</option>
                                <option value="Business" <?php if ($lmnote->nature_possession == "Business") {echo "selected";}?>>Business</option>
                                <option value="Residential" <?php if ($lmnote->nature_possession == "Residential") {echo "selected";}?>>Residential</option>
                            </select>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <span ><strong><?=$sl_count++?>.</strong> Whether applicant is landless</span>
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
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        id="is_landless"
                                        value="NO" disabled <?php if ($lmnote->is_landless == NO) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row p-2">
                        <div class="col-md-6 text-justify">
                            <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                VGR/PGR/Wet Land/ CS Land/Khas Govt Land/NR Govt Land/Green Belt
                                area/reserved for Govt departments/ancient monuments/reserved for other
                                purposes/RF/PRF/Un-classed Forest land/under Wild Life Sanctuary/or any
                                land barred for allotment/settlement by a judicial pronouncement or any
                                Central or State Legislation.</span>
                        </div>
                        <div class="col-md-6">
                            <select name="land_falls" id="land_falls" class="form-control" required disabled>
                                <option value="">Select...</option>
                                <?php foreach (json_decode(LAND_FALLS) as $landCode): ?>
                                    <option value="<?php echo $landCode->CODE ?>" <?php if ($lmnote->land_falls == $landCode->CODE) {echo "selected";}?>><?php echo $landCode->NAME ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <span ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
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
                                        value="YES" disabled <?php if ($lmnote->falls_und_gmc == YES) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                        class="form-check-input"
                                        type="radio"
                                        name="falls_und_gmc"
                                        id="falls_und_gmc"
                                        value="NO" disabled <?php if ($lmnote->falls_und_gmc == NO) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
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
                    <div class="row p-2 ">
                        <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> Zonal valuation/current market value
                                of the proposed land and assessment of settlement premium as per standing
                                Govt circular</span>
                        </div>
                        <div class="col-md-6">
                            <input
                                    type="text"
                                    name="zonal_valuation"
                                    id="zonal_valuation"
                                    class="form-control" value="<?=$lmnote->zonal_valuation?>" readonly
                            />
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <span><strong><?=$sl_count++?>.</strong> LM remarks</span>
                        </div>
                        <div class="col-md-6">
                            <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2" readonly><?=$lmnote->lm_note?></textarea>
                        </div>
                    </div>
                    <div class="row p-2 justify-content-end" style="padding-bottom: 15px!important;">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <textarea name="lm_remark_text" class="form-control" id="lm_remark_text" cols="30" rows="2" disabled><?=$lmnote->lm_remark_text?></textarea>
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
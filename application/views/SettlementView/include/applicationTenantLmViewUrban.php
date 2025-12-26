<?php $sl_count = 1; ?>
<div class="tab-content">
    <div class="tab-pane active" role="tabpanel" id="step1" >

            <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                Settlement of  Occupancy Tenant (
                <span class="bg-warning"><?php echo $_GET['case']?></span> )
            </h5>
            <div class="reza-card">
                <div class="reza-body">
                    <!--- Application Details starts here --->
                    <h5 class="reza-title" style="margin-top: 15px">
                        <i class="fa fa-file-text"></i>  Application Details
                    </h5>
                    <div class="tableCard">
                        <div class="row justify-content-center">
                            <?php
                                if (isset($base64_decoded_adhar_file)) {
                                ?>
                                <div class="col-md-2">
                                    <?php echo $base64_decoded_adhar_file;?>
                                </div>

                            <?php }?>
                            <div class="col-md-10">
                                <table class="table table-bordered">


                                    <tr>
                                        <th> Name in <?php echo $aadhar->type?> </th>
                                        <td>
                                            <?php
                                                if ($aadhar->aadhaar_no || $aadhar->pan_no) {
                                                    foreach ($applicants_buyers as $doc_name):
                                                        if ($doc_name->is_applicant == 1):
                                                    ?>
	                                                        <strong class="alert-warning">
	                                                            <?php echo $doc_name->eng_pdar_name?>
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
                                        if ($applicants_encroacher == true) {
                                            foreach ($applicants_encroacher as $enc_data1) {
                                            ?>
                                            <tr>
                                                <th>Period of Possession</th>
                                                <td>
                                                    <strong class="alert-warning"><?php echo $enc_data1->period_possession?></strong>
                                                </td>
                                            </tr>
                                        <?php }
                                        }?>
                                    <tr>
                                        <th>Occupation or Profession of the applicant</th>
                                        <td>
                                            <strong class="alert-warning"><?php echo $basic["occupation_applicant"]?></strong>
                                        </td>
                                    </tr>
                                    <?php
                                        if ($basic['protected_class']):
                                    ?>
                                    <tr>
                                        <th>Select if you fall under protected category?</th>
                                        <td>
                                            <input type="hidden" name="protected_class" value="<?php echo $basic['protected_class']?>" class="form-control">
                                            <strong class="alert-warning">
                                                <?php
                                                    foreach (json_decode(PROTECTED_CLASS) as $class12) {

                                                        if ($class12->CODE == $basic['protected_class']) {
                                                            echo $class12->NAME;
                                                        }
                                                    }
                                                ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th>Caste</th>
                                        <td>
                                            <input type="hidden" name="caste" value="<?php echo $basic["caste"]?>" class="form-control">
                                            <strong class="alert-warning"><?php
                                                                              foreach (json_decode(CASTE) as $caste) {
                                                                                  if ($caste->CODE == $basic["caste"]) {
                                                                                      echo $caste->NAME;
                                                                                  }
                                                                          }
                                                                          ?></strong>
                                        </td>
                                    </tr>
                                    <?php if (isset($basic["tribal_belt"])) {
                                            if ($basic["tribal_belt"] != null) {
                                            ?>
                                        <tr>
                                            <th>Whether the proposed land falls under Tribal Belt/ Block?</th>
                                            <td>
                                                <strong class="alert-warning"><?php echo $basic["tribal_belt"]?></strong>
                                            </td>
                                        </tr>
                                    <?php }
                                    }?>
                                    <tr>
                                        <th>Total Applications applied by this applicant</th>
                                        <td>
                                            <a type="button" target="_blank" class="btn buttInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/apiAadharWiseApplication?app=<?php echo $basic["applid"];?>">
                                                <small style="font-size:14px; color:white; font-weight:bold;"> <i class="fa fa-eye"></i> View Now</small>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--- Application Details ends here ///////////////////////--->
                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-map-marker"></i> Address Information
                    </h5>

                <div class="tableCard ">
                    <table class="table table-bordered">
                        <tr>
                            <th>District Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?php echo $this->utilityclass->getDistrictName($basic["dist_code"])?>
                                </strong>
                            </td>
                            <th>Subdivision Name:</th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?php echo $this->utilityclass->getSubDivName($basic["dist_code"], $basic["subdiv_code"])?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Circle Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?php echo $this->utilityclass->getCircleName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"])?>
                                </strong>
                            </td>
                            <th>Mouza Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?php echo $this->utilityclass->getMouzaName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"])?>
                                </strong>
                            </td>
                        </tr>
                        <tr>

                            <th>Village Name: </th>
                            <td class="text-warning">
                                <strong class="alert-warning">
                                    <?php echo $this->utilityclass->getVillageName($basic["dist_code"], $basic["subdiv_code"], $basic["cir_code"], $basic["mouza_pargona_code"], $basic["lot_no"], $basic["vill_townprt_code"])?>
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
                                <th><?php echo $self->name?></th>
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
                    <div class="tableCard ">
                        <table class="table table-bordered">
                            <tr>
                                <th rowspan="6" style="vertical-align : middle;text-align:center; min-width: 4%!important; max-width: 4%!important; width: 4%">
                                    <?php echo $i;?>
                                </th>
                                <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Name</th>
                                <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                    <strong class="alert-warning">
                                        <?php echo $settlement->pdar_name;?>
                                    </strong>
                                </td>
                                <th style="max-width: 18%!important; min-width: 18%!important; width: 18%">Guardian name</th>
                                <td style="max-width: 30%!important; min-width: 30%!important; width: 30%!important;">
                                    <strong class="alert-warning">
                                        <?php echo $settlement->pdar_guardian;?>
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
                                <?php if ($settlement->is_applicant == 1): ?>
                                <th>Marital Status</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php
                                            foreach (json_decode(MARITAL_STATUS) as $marital_stat) {

                                                if ($marital_stat->CODE == $settlement->marital_status) {
                                                    echo $marital_stat->NAME;
                                                }

                                            }
                                        ?>
                                    </strong>
                                </td>
                                <?php endif; ?>
                                <th>Mobile</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php echo $settlement->pdar_mobile?>
                                    </strong>
                                </td>

                            </tr>
                            <tr>
                                <th>DOB</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php echo $settlement->dob?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant Eligibility</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php if ($settlement->applicant_eligibility == '1') {echo 'Eligible';} elseif ($settlement->applicant_eligibility == '2') {echo 'Not Eligible';}?>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Permanent address
                                </th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php echo $settlement->pdar_add1?>
                                    </strong>
                                </td>
                                <th>Present address</th>
                                <td>
                                    <strong class="alert-warning">
                                        <?php echo $settlement->pdar_add2?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php $i++; ?>
<?php endforeach; ?>


                <?php if ($applicants_owners == true) {?>
                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-user-secret"></i>  Land Owner Details
                    </h5>
                    <div class="tableCard">
                        <table class="table table-bordered">
                            <?php
                                $sl = 1;
                                    foreach ($applicants_owners as $owners) {
                                    ?>

                                <tr>
                                    <th rowspan="3" style="vertical-align : middle;text-align:center;  min-width: 4%!important; max-width: 4%!important; width: 4%">
                                        <?php echo $sl++;?>
                                    </th>
                                    <th style=" min-width: 35%!important; max-width: 35%!important; width: 35%">Name</th>
                                    <td >
                                        <strong class="alert-warning">
                                            <?php echo $owners->pdar_name;?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Father's name</th>
                                    <td >
                                        <strong class="alert-warning">
                                            <?php echo $owners->pdar_guardian;?>
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
                                                if ($owners->inplace_alongwith == 'i') {
                                                            echo "In Place";
                                                        }
                                                        if ($owners->inplace_alongwith == 'a') {
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
                <?php }?>

                <?php if ($applicants_encroacher == true) {?>
                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-user-circle"></i>  Riotee Details
                    </h5>
                    <div class="tableCard">
                        <table class="table table-bordered">
                            <?php

                                    $sl = 1;
                                    foreach ($applicants_encroacher as $riotee) {
                                    ?>

                                <tr>
                                    <th rowspan="3" style="min-width: 4%!important; max-width: 4%!important; width: 4%; vertical-align : middle;text-align:center;">
                                        <?php echo $sl++;?>
                                    </th>
                                    <th style=" min-width: 35%!important; max-width: 35%!important; width: 35%">Khatian Number</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php echo $riotee->khatian_no;?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php echo $riotee->pdar_name;?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Father's name</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php echo $riotee->pdar_guardian;?>
                                        </strong>
                                    </td>
                                </tr>

                                <?php
                                    }
                                    ?>
                        </table>
                    </div>
                <?php }?>

                <?php
                if ($applicants_riotee_nok == true) {?>
                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-user-plus"></i>  Riotee's NOK(This would be added to the Riotee khatian)
                    </h5>
                    <div class="tableCard">
                        <table class="table table-bordered">
                            <?php
                                $sl = 1;
                                    foreach ($applicants_riotee_nok as $riotee_nok) {
                                    ?>
                                <tr>
                                    <th rowspan="4" width="4%" style="vertical-align : middle;text-align:center;"><?php echo $sl++;?></th>
                                    <th width="35%">Khatian Number</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php echo $riotee->khatian_no;?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php echo $riotee_nok->pdar_name;?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Father's name</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php echo $riotee_nok->pdar_guardian;?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Relationship with Riotee</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <?php
                                                if ($riotee_nok->pdar_type == 'GP') {
                                                            echo "Grand Son/ Daughter";
                                                        } elseif ($riotee_nok->pdar_type == 'GGP') {
                                                            echo "Great Grand Son";
                                                        }
                                                        if ($riotee_nok->pdar_type == 'P') {
                                                            echo "Son";
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
                <?php }?>

                <?php if ($basic["bhumiputra_certificate_no"]) {?>

                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-certificate"></i>  Bhumiputra Certificate/Ack Details
                    </h5>
                    <div class="tableCard">
                        <table class="table table-bordered">
                            <tr>
                                <th>Bhumiputra certificate/ack verified?</th>
                                <td align="center">
                                    <input disabled type="radio" style="margin: 4px 4px 5px -15px;;" name="bhumiputra_confirmation" id="" class="form-check-input" value="YES"                                                                                                                                                                               <?php if (trim($basic['bhumiputra_confirmation']) == YES) {echo "checked";}?>>
                                    <label for="bhumi_confirmation">Yes</label>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <input disabled type="radio" style="margin: 4px 4px 5px -15px;;" name="bhumiputra_confirmation" id="" class="form-check-input" value="NO"                                                                                                                                                                              <?php if (trim($basic['bhumiputra_confirmation']) == NO) {echo "checked";}?>>
                                    <label for="bhumi_confirmation">No</label>
                                </td>
                                <td>
                                    <input type="hidden" name="bhumiputra_certificate_no" value="<?php echo $basic["bhumiputra_certificate_no"]?>">
                                    Certificate/Ack number : <b><?php echo $basic["bhumiputra_certificate_no"]?></b>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php }?>

                <?php if ($nextKin) {?>
                    <h5 class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-users"></i>  Family Details
                    </h5>
                    <div class="tableCard">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Relation</th>
                                <th>Address</th>
                                <th>Mobile number</th>
                            </tr>
                            <?php $i = 1;foreach ($nextKin as $kin): ?>
                                <tr>
                                    <td>
                                        <?php echo $kin->next_of_kin_name?>
                                    </td>
                                    <td>
                                        <?php echo $this->utilityclass->appRelationbyIDMB2($kin->relation_with_kin)?>
                                    </td>
                                    <td>
                                        <?php echo $kin->address?>
                                    </td>
                                    <td>
                                        <?php echo $kin->mobile_no?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
<?php endforeach; ?>
                        </table>
                    </div>
                <?php }?>

                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-map"></i>  Area Details
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">

                        <tr>
                            <th>Dag Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php echo $dags["dag_no"]?>
                                </strong>
                            </td>

                            <th>Patta Number:</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php echo $dags["patta_no"]?>
                                </strong>
                            </td>
                            <th>Patta type:</th>
                            <td>
                                <strong class="alert-warning">
                                    <?php echo $this->utilityclass->getPattaType($dags["patta_type_code"])?>
                                </strong>
                            </td>

                        </tr>

                        <tr>
                            <th>Total Land Area in Selected Dag</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <strong>
                                    <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?php echo $dags["dag_area_b"]?>" readonly>
                                </strong>
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="dag_area_k" value="<?php echo $dags["dag_area_k"]?>" class="form-control input-sm" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?php echo $dags["dag_area_lc"]?>" readonly>
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?php echo $dags["dag_area_g"]?>" class="form-control input-sm" name="dag_area_g" readonly>
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?php echo $dags["dag_area_kr"]?>" class="form-control input-sm" name="dag_area_kr" readonly>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <tr>
                            <th>Total applied area</th>
                            <td>
                                <span class="input-group-addon">Bigha</span>
                                <input type="text" readonly style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?php echo $dags["s_dag_area_b"]?>" >
                            </td>
                            <td>
                                <span class="input-group-addon">Katha</span>
                                <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?php echo $dags["s_dag_area_k"]?>" readonly class="form-control input-sm s_dag_area_k" >
                            </td>
                            <td>
                                <span class="input-group-addon">Lessa</span>
                                <input type="text" readonly style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?php echo $dags["s_dag_area_lc"]?>" >
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon">Ganda</span>
                                    <input type="text" readonly style="text-align: center;" value="<?php echo $dags["s_dag_area_g"]?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                                </td>
                                <td>
                                    <span class="input-group-addon">Kranti</span>
                                    <input type="text" readonly style="text-align: center;" value="<?php echo $dags["s_dag_area_kr"]?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                                </td>
                            <?php endif; ?>
                        </tr>

                    </table>
                </div>

                <!-- additional property -->
                <?php if (isset($property) && ! empty($property)) {?>
                    <h5  class="reza-title" style="margin-top: 50px">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Additional Property Details
                    </h5>
                    <div class="tableCard">
                        <table class="table table-bordered">
                            <?php $i = 1;foreach ($property as $adp): ?>
                                <tr>
                                    <th>District Name:</th>
                                    <td class="text-warning">
                                        <strong class="alert-warning">
                                            <input type="text" name="a_dist_name" class="form-control input-sm" value='<?php echo $this->utilityclass->getDistrictName($adp->dist_code)?>' readonly>
                                        </strong>
                                    </td>
                                    <th>Subdivision Name:</th>
                                    <td class="text-warning">
                                        <strong class="alert-warning">
                                            <input type="text" name="a_subdiv_name" class="form-control input-sm" value='<?php echo $this->utilityclass->getSubDivName($adp->dist_code, $adp->subdiv_code)?>' readonly>
                                        </strong>
                                    </td>
                                    <th>Circle Name: </th>
                                    <td class="text-warning">
                                        <strong class="alert-warning">
                                            <input type="text" name="a_circle_name" value='<?php echo $this->utilityclass->getCircleName($adp->dist_code, $adp->subdiv_code, $adp->cir_code)?>' class="form-control input-sm" readonly>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mouza Name: </th>
                                    <td class="text-warning">
                                        <strong class="alert-warning">
                                            <input type="text" name="a_mouza_name" class="form-control input-sm" value='<?php echo $this->utilityclass->getMouzaName($adp->dist_code, $adp->subdiv_code, $adp->cir_code, $adp->mouza_pargona_code)?>' readonly>
                                        </strong>
                                    </td>
                                    <th>Village Name: </th>
                                    <td class="text-warning">
                                        <strong class="alert-warning">
                                            <input type="text" name="a_village_name" value='<?php echo $this->utilityclass->getVillageName($adp->dist_code, $adp->subdiv_code, $adp->cir_code, $adp->mouza_pargona_code, $adp->lot_no, $adp->vill_townprt_code)?>' class="form-control input-sm" readonly>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dag Number:</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <input type="text" name="a_dag_no" value='<?php echo $adp->dag_no?>' class="form-control input-sm" readonly>
                                        </strong>
                                    </td>
                                    <th>Patta Number:</th>
                                    <td>
                                        <strong class="alert-warning">
                                            <input type="text" name="a_patta_no" class="form-control input-sm" value='<?php echo $adp->patta_no;?>' readonly>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Additional Land Details</th>
                                    <td>
                                        <span class="input-group-addon">Bigha</span>
                                        <strong>
                                            <input type="text" style="text-align: center;" name="a_bigha" class="form-control input-sm" value="<?php echo $adp->bigha?>" readonly>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="input-group-addon">Katha</span>
                                        <input type="text" style="text-align: center;" name="a_katha" value="<?php echo $adp->katha?>" class="form-control input-sm" readonly>
                                    </td>
                                    <td>
                                        <span class="input-group-addon">Lessa</span>
                                        <input type="text" style="text-align: center;" name="a_lessa" class="form-control input-sm" value="<?php echo $adp->lessa?>" readonly>
                                    </td>
                                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                        <td>
                                            <span class="input-group-addon">Ganda</span>
                                            <input type="text" style="text-align: center;" value="<?php echo $adp->ganda?>" class="form-control input-sm" name="a_ganda" readonly>
                                        </td>
                                        <td>
                                            <span class="input-group-addon">Kranti</span>
                                            <input type="text" style="text-align: center;" value="<?php echo $adp->kranti?>" class="form-control input-sm" name="a_kranti" readonly>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php $i++?>
<?php endforeach; ?>
                        </table>
                    </div>
                <?php }?>

                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-file-pdf-o"></i> Supporting Documents
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <?php foreach ($document as $d): ?>
                            <tr>
                                <th>
                                    <a target='download' href="<?php echo base_url(); ?>index.php/SettlementCommon/documentmb3/<?php echo $d->name;?>"><i class="fa fa-paperclip"></i> <?php echo $d->file_details;?></a>
                                    <input type="hidden" name="file_name" value="<?php echo $d->name;?>">
                                    <input type="hidden" name="file_type" value="<?php echo $d->content_type;?>">
                                    <input type="hidden" name="file_path" value="<?php echo $d->path;?>">
                                    <input type="hidden" name="file_details" value="<?php echo $d->file_details?>">

                                    <input type="hidden" name="mut_type" value="<?php echo $basic["service_code"]?>">
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
                    <i class="fa fa-arrow-circle-right"> </i> Next
                </button>
            </li>
        </ul>
    </div>

    <!-- LM reporting starts here -->

    <div class="tab-pane" role="tabpanel" id="step2">
        <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
            Settlement of  Occupancy Tenant (
            <span class="bg-warning"><?php echo $_GET['case']?></span> )
        </h5>

        <div class="reza-card">
            <div class="reza-body">
                <h5  class="reza-title" style="margin-top: 15px">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
                </h5>
                <div class="tableCard" style="padding-bottom: 15px">
                    <?php $i = 1;foreach ($lmnotes as $lmnote):
                            if ($validation_bypass == 0):

                        ?>

	                        <div class="row p-2">
	                            <div class="col-md-6">
	                                <span><strong><?php echo $sl_count++?>.</strong> Chitha verified and found the applicant as a pattadar ?</span>
	                            </div>
	                            <div class="col-md-2">
	                                <div class="form-check form-check-inline">
	                                    <input
	                                            class="form-check-input"
	                                            type="radio"
	                                            name="chiitha_verified"
	                                            id="chiitha_verified1"
	                                            value="YES"
	                                        <?php if (trim($lmnote->chitha_verified) == YES) {echo "checked";}?>
	                                            disabled
	                                    />
	                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
	                                </div>
	                                <div class="form-check form-check-inline">
	                                    <input
	                                            class="form-check-input"
	                                            type="radio"
	                                            name="chiitha_verified"
	                                            id="chiitha_verified2"
	                                            value="NO" disabled	                                                                <?php if (trim($lmnote->chitha_verified) == NO) {echo "checked";}?>
	                                    />
	                                    <label class="form-check-label" for="inlineRadio2">No</label>
	                                </div>
	                                </a>
	                            </div>
	                            <div class="col-md-4">

	                                <i class="fa fa-link" aria-hidden="true"></i>
	                                <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $dags['dag_no'] . '&m=' . $basic["mouza_pargona_code"] . '&l=' . $basic['lot_no'] . '&v=' . $basic["vill_townprt_code"] . '&p=' . $dags['patta_type_code'] . '&dist=' . $basic["dist_code"] . '&cir=' . $basic["cir_code"] . '&sub_div=' . $basic["subdiv_code"] ?>">
	                                    <u><span class="text-primary" style="font-size:16px;">Dag - <?php echo $dags['dag_no']?> (Chitha)</span></u>
	                                </a>
	                                <br>
	                            </div>
	                        </div>

	                        <div class="row p-2">
	                            <div class="col-md-6">
	                                <span>
	                                    <strong><?php echo $sl_count++?>.</strong> RAIOTEE KHATIAN verified and found applicant predecessors is a recorded occupancy tenant?
	                                </span>
	                            </div>
	                            <div class="col-md-2">
	                                <div class="form-check form-check-inline">
	                                    <input
	                                            class="form-check-input"
	                                            type="radio"
	                                            name="rk_verified"
	                                            id="rk_verified1"
	                                            value="YES"
	                                            disabled
	                                        <?php if (trim($lmnote->rk_verified) == YES) {echo "checked";}?>
	                                    />
	                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
	                                </div>
	                                <div class="form-check form-check-inline">
	                                    <input
	                                            class="form-check-input"
	                                            type="radio"
	                                            name="rk_verified"
	                                            id="rk_verified2"
	                                            value="NO"
	                                            disabled
	                                        <?php if (trim($lmnote->chitha_verified) == NO) {echo "checked";}?>
	                                    />
	                                    <label class="form-check-label" for="inlineRadio2">No</label>
	                                </div>
	                            </div>
	                            <div class="col-md-4">
	                                <?php
                                            foreach ($applicants_encroacher as $en) {
                                                $khatian_no = $en->khatian_no;
                                                break;
                                            }
                                        ?>
	                                <i class="fa fa-link" aria-hidden="true"></i>
	                                <a href="<?php echo base_url() . 'index.php/basundhara2/khatian?st=' . $khatian_no . '&end=' . $khatian_no . '&dist=' . $basic['dist_code'] . '&cir_code=' . $basic['cir_code'] . '&subdiv_code=' . $basic['subdiv_code'] . '&mouza_code=' . $basic["mouza_pargona_code"] . '&lot_no=' . $basic['lot_no'] . '&village_code=' . $basic["vill_townprt_code"] . '&patta_no=' . $dags['patta_type_code'] . '&dag_no=' . $dags['dag_no'] ?>" target="view_riotee">

	                                    <u><span class="text-primary" style="font-size:16px;">Dag - <?php echo $dags['dag_no']?> (RK)</span></u>
	                                </a>
	                                <br>
	                            </div>
	                        </div>

	                        <div class="row p-2">
	                            <div class="col-md-6">
	                                <span><strong><?php echo $sl_count++?>.</strong> Bhumiputra Verified?</span><br>
	                                <?php if ($basic['bhumiputra_certificate_no']) {?>
	                                    <label for="" class="alert-warning">Certificate number : <b><?php echo $basic['bhumiputra_certificate_no']?></b></label>

	                                <?php } else {?>

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
	                                        <?php if (trim($lmnote->bhumiputra_confirmation) == YES) {echo "checked";}?>

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
	                                        <?php if (trim($lmnote->bhumiputra_confirmation) == NO) {echo "checked";}?>
	                                    />
	                                    <label class="form-check-label" for="inlineRadio2">No</label>
	                                </div>
	                            </div>
	                            <?php
                                        if ($basic['bhumiputra_certificate_no']) {

                                        ?>
	                            <div class="col-md-4">
	                                <i class="fa fa-link" aria-hidden="true"></i>
	                                <a href="<?php echo base_url(); ?>index.php/SettlementCommon/bhumiPutra?<?php
        if ($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT) {
                echo "cer_number=" . $basic['bhumiputra_certificate_no'];
            } elseif ($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK) {
        echo "ack_number=" . $basic['bhumiputra_certificate_no'];
    }?>" target="BhumiPutra">
                                    <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                </a>
                            </div>

                            <?php }?>
                        </div>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span><strong><?php echo $sl_count++?>.</strong> Verified schedule of the land and area under possession and found correct?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="possession_verified"
                                            id="possession_verified1"
                                            value="YES" disabled                                                                 <?php if (trim($lmnote->possession_verification) == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="possession_verified"
                                            id="possession_verified2"
                                            value="NO" disabled                                                                <?php if (trim($lmnote->possession_verification) == NO) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col-md-6">
                            <span><strong><?php echo $sl_count++?>.</strong> Whether the proposed land falls under
                                Tribal Belt/ Block.</span>
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
                                <?php if (trim($lmnote->is_tribal_belt) == YES) {echo "checked";}?>
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
                                <?php if (trim($lmnote->is_tribal_belt) == NO) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                            </div>
                        </div>


                        <?php
                            if (trim($lmnote->is_tribal_belt) == NO) {
                            ?>
                                <div class="row p-2" id="contravention">
                                  <div class="col-md-6">
                                    <span><strong>-></strong>
                                    Whether the occupancy tenant right has been conferred in contravention of provisions of chapter 10?</span>
                                    <?php echo form_error('contravention')?>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input                                                                     <?php if (form_error('contravention')) {echo 'lm_invalid';}?>"
                                             type="radio"
                                             name="contravention"
                                             id="landed_property1"
                                             value="YES"
                                             disabled
                                             <?php if (trim($lmnote->contravention) == YES) {echo "checked";}?>
                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input                                                                      <?php if (form_error('contravention')) {echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="contravention"
                                              id="landed_property2"
                                              value="NO"
                                              disabled
                                              <?php if (trim($lmnote->contravention) == NO) {echo "checked";}?>
                                      />
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                </div>
                            <?php
                                } else {
                                ?>
                                <div class="row p-2">
                                    <div class="col-md-6 text-justify">
                                        <span><strong>-></strong> Does applicant falls under protected category?</span>
                                    <?php echo form_error('protected_class_lm')?>
                                    </div>
                                    <div class="col-md-6 form-group">
                                    <select name="protected_class_lm" id="protected_class_lm" class="form-control" required disabled>
                                            <?php foreach (json_decode(PROTECTED_CLASS) as $class): ?>
                                                <option value="<?php echo $class->CODE ?>"
                                            <?php if ($lmnote->protected_class_lm == $class->CODE) {echo "selected";}?>>
                                            <?php echo $class->NAME ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>


                        <div class="row p-2">
                            <div class="col-md-6">
                                <span><strong><?php echo $sl_count++?>.</strong> Whether proposed land is under litigation?</span>
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
                                <?php if (trim($lmnote->litigation) == YES) {echo "checked";}?>
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
                                <?php if (trim($lmnote->litigation) == NO) {echo "checked";}?>
                                />
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span><strong><?php echo $sl_count++?>.</strong> Period of possession</span>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="inputEmail4">From Date</label>
                                    </div>
                                    <div class="col-8">
                                        <input
                                                class="form-control"
                                                type="date"
                                                name="period_possession"
                                                id="period_possession"
                                                value="<?php echo $lmnote->period_possession?>" readonly
                                        />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span><strong><?php echo $sl_count++?>.</strong> Nature of possession </span>
                            </div>
                            <div class="form-group col-md-6">
                                <select
                                        name="nature_possession"
                                        id="nature_possession"
                                        class="form-control" disabled
                                >
                                    <option value="Agricultural"                                                                 <?php if ($lmnote->nature_possession == "Agricultural") {echo "selected";}?>>Agricultural</option>
                                    <option value="Business"                                                             <?php if ($lmnote->nature_possession == "Business") {echo "selected";}?>>Business</option>
                                    <option value="Residential"                                                                <?php if ($lmnote->nature_possession == "Residential") {echo "selected";}?>>Residential</option>
                                    <option value="Residential"                                                                <?php if ($lmnote->nature_possession == "Others") {echo "selected";}?>>Others</option>
                                </select>
                            </div>
                        </div>

                        <?php
                            if ($lmnote->nature_possession == "Others") {
                            ?>
                            <div class="row p-2">
                                <div class="col-md-6">
                                    <span><strong>-></strong>
                                        Purpose of the land used by the occupants(if any other)
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" name="land_used_by_occupants" value="<?php echo $lmnote->land_used_by_occupants?>" class="form-control" placeholder="Enter purpose of the land used by occupants" disabled>
                                </div>
                            </div>
                            <?php
                                }
                            ?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span ><strong><?php echo $sl_count++?>.</strong> Whether applicant and his/her family has occupied any land in the state ?</span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        id="is_landless"
                                        value="YES" disabled                                                             <?php if ($lmnote->is_landless == YES) {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Completely Landless</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="is_landless"
                                        id="is_landless"
                                        value="NO" disabled                                                            <?php if ($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') {echo "checked";}?>
                                    />
                                    <label class="form-check-label" for="inlineRadio2">Landless as per policy / Having Land</label>
                                </div>

                                <?php if ($lmnote->is_landless == NO || $lmnote->is_landless == 'OTHERS') {?>
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
                                                    if ($additional_property != null) {
                                                        foreach ($additional_property as $area) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $area->dist_name?></td>
                                                                <td><?php echo $area->cir_name?></td>
                                                                <td>
                                                                        <b>B:</b> <?php echo $area->bigha?>;
                                                                        <b>K:</b> <?php echo $area->katha?>;
                                                                        <b>L/C:</b> <?php echo $area->lessa?>;
                                                                        <b>G:</b> <?php echo $area->ganda?>;
                                                                        <b>Kr:</b> <?php echo $area->kranti?>
                                                                </td>
                                                            </tr>

                                                        <?php
                                                            }
                                                        }?>

                                            </table>
                                        </div>
                                    </div>

                                <?php }?>

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
                                <span><strong><?php echo $sl_count++?>.</strong>
                                    Check the land revenue details as fetch from the E-Khajana Database or check the Khajana receipt uploaded by applicant
                                </span>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="khajana_receipt"
                                            id="khajana_receipt1"
                                            value="YES"
                                        <?php if (trim($lmnote->e_khajana_receipt_check) == YES) {echo "checked";}?>
                                            disabled
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="khajana_receipt"
                                            id="khajana_receipt2"
                                            value="NO"
                                        <?php if (trim($lmnote->e_khajana_receipt_check) == NO) {echo "checked";}?>
                                            disabled
                                    />
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                              <span>
                                  <strong><?php echo $sl_count++?>.</strong>
                                  Date of notification vide which the area was included in town lands
                              </span>
                              <?php echo form_error('date_notification')?>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control                                                                       <?php if (form_error('tenancy_record')) {echo 'lm_invalid';}?>" name="date_notification" id="date_notification"
                                value="<?php echo date('d/m/Y', strtotime($lmnote->date_notification))?>" readonly placeholder="Date of Notification">
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                              <span>
                                  <strong><?php echo $sl_count++?>.</strong>
                                  The year in which the tenancy records were created
                              </span>
                              <?php echo form_error('tenancy_record')?>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control                                                                       <?php if (form_error('tenancy_record')) {echo 'lm_invalid';}?>" name="tenancy_record" id="tenancy_record" placeholder="The year in which the tenancy records were created"
                                value="<?php echo $lmnote->tenancy_record?>" readonly>
                            </div>
                        </div>

                        <div class="row p-2" >
                            <div class="col-md-6">
                              <span>
                                  <strong><?php echo $sl_count++?>.</strong>
                                  Whether applicant(s) have been in continuous possession from the year of creation of the tenancy records ?
                              </span>
                              <?php echo form_error('cont_possession')?>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input                                                                <?php if (form_error('cont_possession')) {echo 'lm_invalid';}?>"
                                        type="radio"
                                        name="cont_possession"
                                        id="cont_possession1"
                                        value="YES"
                                        <?php if (trim($lmnote->cont_possession) == YES) {echo "checked";}?>
                                            disabled>
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                            class="form-check-input                                                                    <?php if (form_error('cont_possession')) {echo 'lm_invalid';}?>"
                                            type="radio"
                                            name="cont_possession"
                                            id="cont_possession2"
                                            value="NO"
                                        <?php if (trim($lmnote->cont_possession) == NO) {echo "checked";}?>
                                            disabled>
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>





                        <?php //foreach($dags as $landmark_data):
                            $land_mark = json_decode($dags['landmark']);
                        ?>
                            <div class="row p-2">
                                    <div class="col-md-6">
                                            <strong><?php echo $sl_count++?>.</strong> Landmark <span class="alert-warning"><strong>for Dag No. <?php echo $dags['dag_no']?></strong></span>
                                    </div>
                                    <div class="col-md-6">
                                            <table class="table table-bordered">
                                                    <tr>
                                                            <th>East side</th>
                                                            <td><?php echo $land_mark->east?></td>
                                                            <th>West side</th>
                                                            <td><?php echo $land_mark->west?></td>
                                                    </tr>
                                                    <tr>
                                                            <th>North side</th>
                                                            <td><?php echo $land_mark->north?></td>
                                                            <th>South side</th>
                                                            <td><?php echo $land_mark->south?></td>
                                                    </tr>
                                            </table>
                                    </div>
                            </div>

                        <?php endif; ?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span> <strong><?php echo $sl_count++?>.</strong> LM remarks</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="lm_note" value="<?php
                                                                             foreach (json_decode(CO_NOTE) as $co_note) {
                                                                                 if ($co_note->CODE == $lmnote->lm_note) {
                                                                                     echo $co_note->NAME;
                                                                             }
                                                                         }?>" class="form-control" readonly><br>
                            </div>
                        </div>
                        <div class="row p-5 m-2" style="background:#FFF3CD;">
                            <div class="col-md-12">
                                <?php
                                    include APPPATH . "views/SettlementView/include/coRejectedRemarks.php";
                                ?>
                            </div>
                        </div>

                        <div class="row p-2 justify-content-end" style="padding-bottom: 15px!important;">
                            <div class="col-md-12">
                                <textarea name="lm_remark_text" class="form-control p-2" id="lm_remark_text" cols="30" rows="10" readonly><?php echo $lmnote->lm_remark_text?></textarea>
                            </div>
                        </div>


                        <?php if ($validation_bypass == 0): ?>

                        <div class="row p-2">
                            <div class="col-md-6">
                                <span> <strong><?php echo $sl_count++?>.</strong> Beneficiary Details</span>
                            </div>
                            <div class="col-md-6">

                                <a target="Beneficiary Details" class="text-primary" href="<?php echo base_url() . 'index.php/SettlementCommon/viewBeneficiary?case=' . $_GET['case']; ?>">View beneficiary details</a>
                            </div>
                        </div>
                        <?php endif; ?>


                        <!-- lm report ends here -->

                    <?php endforeach; ?>

                    <?php if ($validation_bypass == 1) {?>
                    <div class="row p-2" >
                        <div class="col-md-6">
                            <span ><strong><?php echo $sl_count++?>.</strong> Bhumiputra Verified?</span><br>
                            <?php if ($basic['bhumiputra_certificate_no']) {?>
                                <label for="" class="alert-warning">Certificate/Ack number : <b><?php echo $basic['bhumiputra_certificate_no']?></b></label>
                            <?php } else {?>
                                <label for="" class="alert-warning">Certificate/Ack Not Available!</b></label>
                            <?php }?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if ($basic['bhumiputra_certificate_no']) {?>
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <a href="<?php echo base_url(); ?>index.php/SettlementCommon/bhumiPutra?<?php

        if ($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_CERT) {
            echo "cer_number=" . $basic['bhumiputra_certificate_no'];
        } elseif ($basic['bhumiputra_certificate_no'] && $basic['bhumiputra_certificate_type'] == BHUMI_ACK) {
        echo "ack_number=" . $basic['bhumiputra_certificate_no'];
    }?>" target="BhumiPutra">
                                <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                            </a>
                            <?php } else {
                                ?>
                                    <span class="text-primary" style="font-size:16px;">Certificate not available</span>
                                <?php
                                    }
                                    ?>
                        </div>
                    </div>
                    <?php }?>



                </div>


                <h5 class="reza-title" style="margin-top: 50px">
                    <i class="fa fa-file-pdf-o"></i> Uploaded Documents
                </h5>
                <div class="tableCard">
                    <table class="table table-bordered">
                        <?php foreach ($dhardocuments as $docs): ?>
                            <tr>
                                <th>
                                    <a target='download'
                                       href="<?php echo base_url() ?>index.php/SettlementCommon/downloadDocument?doc_id=<?php echo $docs->id?>"><i class="fa fa-paperclip"></i> <?php echo $docs->file_name;?></a>
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
                    <i class="fa fa-arrow-circle-left"> </i>                                                              <?php echo $this->lang->line('previous'); ?>
                </button>
            </li>
            <li>
                <button type="button" class="btn btn-primary next-step">
                    <i class="fa fa-arrow-circle-right"> </i>                                                               <?php echo $this->lang->line('next'); ?>
                </button>
            </li>
        </ul>
    </div>
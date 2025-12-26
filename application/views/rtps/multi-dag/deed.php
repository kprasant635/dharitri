<style type="text/css">
    .markElement {
    padding: 0.2em;
    background-color: #ffe142;
}
</style>
<form id='formAjaxPost'>
    <div class="container-fluid login form-top">
        <div class="row">
            <?php
            //*************INTEGRATION OF BLOCKCHAIN***************//
            if (ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {
                include 'application/views/common/input_hidden_fields_and_func.php';
                //*************END*************************************//
            } ?>
            <div class="col-lg-12 ">
                <div class="col-lg-10 col-lg-offset-1">

                    <div class="panel panel-info panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Registration of <kbd>Mutation By Deed (<?= $_GET['app'] ?>)</kbd>
                            </h3>
                        </div>
                        <?php
                        if ($this->session->flashdata('message')) {
                        ?>
                            <div class="error_container">
                                <div class="alert alert-warning alert-dismissible show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong class="text-danger">
                                        <?= $this->session->flashdata('message'); ?>
                                    </strong>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>District Name: <?= $this->utilityclass->getDistrictName($app->dist_code) ?></td>
                                    <td>Subdivision Name: <?= $this->utilityclass->getSubDivName($app->dist_code, $app->subdiv_code) ?></td>
                                    <td>Circle Name: <?= $this->utilityclass->getCircleName($app->dist_code, $app->subdiv_code, $app->cir_code) ?></td>
                                </tr>
                                <tr>
                                    <td>Mouza Name: <?= $this->utilityclass->getMouzaName($app->dist_code, $app->subdiv_code, $app->cir_code, $app->mouza_code) ?></td>
                                    <td>Lot Name: <?= $this->utilityclass->getLotName($app->dist_code, $app->subdiv_code, $app->cir_code, $app->mouza_code, $app->lot_no) ?></td>
                                    <td>Village Name: <?= $this->utilityclass->getVillageName($app->dist_code, $app->subdiv_code, $app->cir_code, $app->mouza_code, $app->lot_no, $app->village_code) ?></td>
                                </tr>
                            </table>
                            <div class="container">
                                <!-- Aadhaar consent Self--- -->
                                <?php include 'application/views/common/aadhar_details_dhar_end.php'; ?>

                            </div>
                            <center class="uni_text">First Party Information</center>
                            <table class="table">
                                <tbody class="applicant_tbody">
                                    <tr class="bg-primary">
                                        <td>Sl No: </td>
                                        <td>Name: </td>
                                        <td>Gurdian: </td>
                                        <td>Relation: </td>
                                        <td>Gender: </td>
                                        <td>Mobile: </td>
                                        <td>Marital Status: </td>
                                        <td>Occupation: </td>
                                        <td>Caste: </td>
                                        <td>Action <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#addApplicantModal">+ Add First Party</button></td>

                                    </tr>
                                    <?php $i = 1;
                                    $j = 1;
                                    foreach ($firstParty as $key => $fp) : ?>
                                        <tr class="bg-success applicant_sl">
                                            <td class="sl_no"><?= $i++ ?></td>
                                            <td><?= $fp->pat_name_ass; ?></td>
                                            <td><?= $fp->pat_gurdian_name_ass; ?></td>
                                            <td><?= $this->utilityclass->appRelationbyID($app->dist_code, $fp->pat_gurdian_rel_id); ?></td>
                                            <td><?= $this->utilityclass->gender($fp->pat_gender); ?></td>
                                            <td><?= $fp->pat_mobile_no; ?></td>
                                            <td><?= $this->utilityclass->getMaritalStatusName($fp->marital_status); ?></td>
                                            <td><?= $fp->applicant_occupation ?? '-'; ?></td>
                                            <td>
                                                <?php
                                                echo $this->utilityclass->getCasteCategoryName($fp->caste_category);
                                                if (!empty($fp->tribe_category)) {
                                                    echo "<br>( " . $this->utilityclass->getTribeCategoryName($fp->tribe_category) . " )";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($fp->auth_type == 'AADHAAR'): ?>
                                                    <strong class="text-danger">You can't delete this applicant</strong>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-danger rtps_applicant delete_applicant" data-index="<?= $key; ?>"><i class="fa fa-trash"></i></button>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php $j++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                            <center class="uni_text">Second Party Information</center>
                            <table class="table">
                                <tr class="bg-primary">
                                    <td>Sl No: </td>
                                    <td>Name: </td>
                                    <td>Dag No: </td>
                                    <td>Gurdian: </td>
                                    <td>Implace/Along With </td>
                                    <!-- <td>Relation: </td>
                                        <td>Gender: </td>
                                        <td>Mobile: </td> -->
                                </tr>
                                <?php $j = 1;
                                foreach ($secParty as $sp) :
                                ?>
                                    <tr class="bg-success">
                                        <td><?= $j++ ?></td>
                                        <td><?= $sp->name_ass; ?></td>
                                        <td><?= $sp->dag_no; ?></td>
                                        <td><?= $sp->gurdian_name_ass; ?></td>
                                        <td  class="markElement">
                                            <input type="radio" value="0" name='<?= $sp->mutation_deed_id . '_' . $sp->chitha_pdar_id; ?>'>Along
                                            <input type="radio" value="1" name='<?= $sp->mutation_deed_id . '_' .  $sp->chitha_pdar_id ?>'>Inplace
                                        </td>
                                        <!-- <td><?= $sp->gurdian_relation_id; ?></td>
                                            <td><?= $sp->gender; ?></td>
                                            <td><?= $sp->mobile; ?></td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <center class="uni_text">Land Area Information</center>
                            <table class="table">
                                <tr class="bg-primary">
                                    <td>Dag No </td>
                                    <td>Patta Type </td>
                                    <td>Patta No </td>
                                    <td>Total Area </td>
                                    <td colspan="4">NOC Details </td>
                                </tr>
                                <?php
                                if (count($landAreaInfo)) :
                                    foreach ($landAreaInfo as $key => $dag_wise_land_detail) :
                                ?>
                                        <tr class="">
                                            <td><span class="markElement"><?= $dag_wise_land_detail->dag_no; ?></span></td>
                                            <td><?= $this->utilityclass->getPattaType($dag_wise_land_detail->patta_type_code); ?></td>
                                            <td><span class="markElement"><?= $dag_wise_land_detail->patta_no; ?> </span></td>
                                            <!---#START PLB--->
                                            <?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            if (in_array($dist_code, json_decode(BARAK_VALLEY))) {
                                            ?>
                                                <td><?= $dag_wise_land_detail->dag_area_b; ?>B-<?= $dag_wise_land_detail->dag_area_k; ?>K-<?= $dag_wise_land_detail->dag_area_lc; ?>C-<?= $dag_wise_land_detail->dag_area_g; ?>G </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td><?= $dag_wise_land_detail->dag_area_b; ?>B-<?= $dag_wise_land_detail->dag_area_k; ?>K-<?= $dag_wise_land_detail->dag_area_lc; ?>L </td>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($key == 0) : ?>
                                                <td colspan="3" rowspan="<?= count($landAreaInfo) ?>" style="border-left: 1px solid #ddd; line-height: 1.5; vertical-align: middle; text-align: center;">
                                                   <span class="markElement"> NOC no : <?= $secParty[0]->noc_no ?></span><br>
                                                   <span class="markElement"> NOC Date: <?= $secParty[0]->noc_date ?></span>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                <?php
                                    endforeach;
                                endif;
                                ?>


                                <?php if (RTPS_FLAG == 1) {
                                    // $tag = 'readonly';
                                    $tag = 'disabled';
                                } else {
                                    $tag = '';
                                } ?>

                                <?php 
                                    $dag_used = [];
                                    foreach($secParty as $sp): 
                                        if(!in_array($sp->dag_no, $dag_used)):
                                            array_push($dag_used, $sp->dag_no);
                                ?>
                                            <tr>
                                                <td class="text-danger" colspan="2">Mutated Area (Dag No: <?= $sp->dag_no; ?>) </td>
                                                <?php
                                                $dist_code = $this->session->userdata('dist_code');
                                                if (in_array($dist_code, json_decode(BARAK_VALLEY))) { ?>
            
                                                    <td><input type="number" required="" name="mut_area_b[<?= $sp->dag_no; ?>]" value="<?= $sp->area_b; ?>" <?= $tag ?> /> Bigha</td>
                                                    <td><input type="number" required="" min="0" max="20" name="mut_area_k[<?= $sp->dag_no; ?>]" value="<?= $sp->area_k; ?>" <?= $tag ?> /> Katha </td>
                                                    <td><input type="number" required="" min="0" max="16" step="0.01" name="mut_area_l[<?= $sp->dag_no; ?>]" value="<?= $sp->area_l; ?>" <?= $tag ?> /> Chatak </td>
                                                    <td><input type="number" required="" min="0" max="20" step="0.01" name="mut_area_g[<?= $sp->dag_no; ?>]" value="<?= $sp->area_go; ?>" <?= $tag ?> /> Ganda </td>
                                                    <td><input type="number" required="" min="0" max="12" step="0.01" name="mut_area_kr[<?= $sp->dag_no; ?>]" value="<?= $sp->area_ka; ?>" <?= $tag ?> /> Kranti </td>
                                                <?php } else { ?>
                                                    <input type="hidden" min="0" max="20" step="0.01" name="mut_area_g[<?= $sp->dag_no; ?>]" value="0" <?= $tag ?> />
                                                    <td><input type="number" required="" name="mut_area_b[<?= $sp->dag_no; ?>]" value="<?= $sp->area_b; ?>" <?= $tag ?> /> Bigha</td>
                                                    <td><input type="number" required="" min="0" max="4" name="mut_area_k[<?= $sp->dag_no; ?>]" value="<?= $sp->area_k; ?>" <?= $tag ?> /> Katha </td>
                                                    <td><input type="number" required="" min="0" max="19.99" step="0.01" name="mut_area_l[<?= $sp->dag_no; ?>]" value="<?= $sp->area_l; ?>" <?= $tag ?> /> Lessa </td>
                                                <?php } ?>
            
                                            </tr>
                                <?php 
                                        endif;
                                    endforeach; 
                                ?>
                                <tr>
                                    <td class="text-danger" colspan="2">Deed Details </td>
                                    <td><span class="markElement">Deed No: <input type="text" required="" name="deed_no" value="<?= $secParty[0]->deed_no; ?>" <?= $tag ?> /></span></td>
                                    <td><span class="markElement">Deed Date : <input type="text" required="" name="deed_date" value="<?= $secParty[0]->deed_date; ?>" id="<?= ((RTPS_FLAG == 1) ? '' : 'DatepickerCO') ?>" <?= $tag ?> /> </span></td>

                                    <td><span class="markElement">Deed Value : <input type="text" required="" name="deed_value" value="<?= $secParty[0]->deed_value; ?>" <?= $tag ?> /></span> </td>
                                </tr>
                            </table>

                            <div class="alert alert-info">
                                <table>
                                    <td>Please Select Transfer Type : </td>
                                    <td width="70%">
                                        <select class="form-control" id='mut_type' name="mut_type" required="">
                                            <!-- <option value="<?= $secParty[0]->trans_type ?>"><?= $this->utilityclass->getTransferType($secParty[0]->trans_type) ?></option> -->
                                            <?php foreach ($mut_type as $mut) { 
                                                $selected = '';
                                                if($secParty[0]->trans_type == $mut['trans_code']){
                                                    $selected = 'selected';
                                                }
                                            ?>

                                                <option value="<?= $mut['trans_code'] ?>" <?= $selected; ?> ><?= $mut['trans_desc_as'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </table>
                            </div>
                            <?php
                                include(APPPATH."views/common/addMoreDocumentView.php");
                            ?>
                            <center class="uni_text">Document(s) Attached</center>
                            <ul class="list-group" style='margin-bottom: 10px'>
                                <?php foreach ($document as $d) : ?>
                                    <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?= $d->name; ?>"><i class="fa fa-paperclip"></i> <?= $d->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if ($query) {
                                echo "<center class='uni_text text-danger'>All Query</center>";
                                echo "<table class='table'>";
                                echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                                foreach ($query as $q) {
                            ?>
                                    <tr>
                                        <td><?= $q->date_of_query ?></td>
                                        <td><?= $q->query_text ?></td>
                                        <td><?= $q->date_of_reply ?></td>
                                        <td><?= $q->reply_text;
                                            if ($q->app_doc_id) {
                                                echo "<br>";
                                                echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> ";
                                            }
                                            ?></td>
                                    </tr>

                            <?php }
                                echo "</table>";
                            } ?>
                            <?php if ($sro) {
                                echo "<center class='uni_text text-danger'>SRO Report</center>";
                                echo "<table class='table'>";
                                echo "<th><tr class='bg-primary'><td>SRO Remark</td>
                          <td>Approve/Reject</td><td>Verified Date</td><td>Verified By</td></tr></th>";
                                foreach ($sro as $q) {
                            ?>
                                    <tr>
                                        <td><?= $q->remark ?></td>
                                        <td><kbd><?= $q->approve_reject == 1 ? 'Approved' : 'Rejected'; ?></kbd></td>
                                        <td><?= $q->date_of_verification ?></td>
                                        <td><?= $q->sro_officer_name; ?></td>
                                    </tr>

                            <?php }
                                echo "</table>";
                            } ?>
                            <input type="hidden" class="form-control" id='appno' name='application_no' value="<?= $app->application_no ?>">
                            <!-- <input type="hidden" class="form-control" name='patta_type' value="<?= $pattaNo->patta_type_code ?>">
                            <input type="hidden" class="form-control" name='patta_no' value="<?= $pattaNo->patta_no ?>"> -->
                            <textarea class="form-control" name='remark' id='reapply_remark' placeholder="Enter your remark"></textarea>
                            <hr>
                            <span id='loading'></span><span id='msg'></span>
                            <center>
                                <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                                <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                                <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!--  -->
<!-- Modal HTML -->
<div id="addApplicantModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add First Party</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="javascript:void(0)" id="addApplicantForm">
                <div class="text-center text-success app_add_scc text-bold" style="display: none;"></div>
                <input type="hidden" name="case_id" id="case_id" value="<?= $app->application_no ?>">
                <input type="hidden" name="dist_code" value="<?= $app->dist_code ?>">
                <div class="row mx-3">
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Name</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Name" name="name_asm" id="first_party_name">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Guardian Name</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Guardian Name" name="guardian_name_asm" id="first_party_gurd_name">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Relation</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_guar_rel" name="relation">
                                <option value="">Select Relation</option>
                                <?php 
                                    foreach(json_decode(RELATION_NEW_APPL) as $relation_app):
                                ?>
                                        <option value="<?= $relation_app->CODE; ?>" data-name="<?= $relation_app->NAME; ?>"><?= $relation_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Gender</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_gender" name="gender">
                                <option value="">Select Gender</option>
                                <?php 
                                    foreach(json_decode(GENDER_NEW_APPL) as $gen_app):
                                ?>
                                        <option value="<?= $gen_app->CODE; ?>" data-name="<?= $gen_app->NAME; ?>"><?= $gen_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Mobile</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Mobile" id="first_party_mobile" name="mobile">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">DOB</label>
                            <input class="form-control add_applicant_fld dnt_show_in_tbl" type="date" id="first_party_dob" name="dob">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Marital Status</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_martial" name="marital_status">
                                <option value="">Select Marital Status</option>
                                <?php 
                                    foreach(json_decode(MARITAL_STATUS_NEW_APPL) as $marital_staus):
                                ?>
                                        <option value="<?= $marital_staus->CODE; ?>" data-name="<?= $marital_staus->NAME; ?>"><?= $marital_staus->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Occupation</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_occu" name="applicant_occupation">
                                <option value="">Select Occupation</option>
                                <?php 
                                    foreach(json_decode(OCCUPATION_NEW_APPL) as $occu_app):
                                ?>
                                        <option value="<?= $occu_app->CODE; ?>" data-name="<?= $occu_app->NAME; ?>"><?= $occu_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Caste</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_cast" name="caste_category">
                                <option value="">Select Caste</option>
                                <?php 
                                    foreach(json_decode(CASTE) as $caste_app):
                                ?>
                                        <option value="<?= $caste_app->CODE; ?>" data-name="<?= $caste_app->NAME; ?>"><?= $caste_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Protected Class</label>
                            <select class="form-control add_applicant_fld_select dnt_show_in_tbl" id="first_party_protcast" name="tribe_category">
                                <?php 
                                    foreach(json_decode(PROTECTED_CLASS) as $protectedcls_app):
                                        if($protectedcls_app->CODE == -1):
                                ?>
                                            <option value="">Select Protected Class</option>
                                <?php 
                                        else:
                                ?>
                                            <option value="<?= $protectedcls_app->CODE; ?>" data-name="<?= $protectedcls_app->NAME; ?>"><?= $protectedcls_app->NAME; ?></option>
                                <?php
                                        endif;
                                ?>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Address</label>
                            <input class="form-control add_applicant_fld dnt_show_in_tbl" type="text" placeholder="Enter Address" id="first_party_address" name="address">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary app_modal_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_applicant_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  -->
<!-- Modal HTML -->
<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/rtps/RejectOrder" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name='application_no' value="<?= $app->application_no ?>">
                    <textarea name='order' class="form-control">Reason of Rejection</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  -->
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/rtps/queryRequest" method="post">
                <input type="hidden" class="form-control" name='application_no' value="<?= $app->application_no ?>">
                <div class="modal-body">
                    <?php
                    if ($this->session->flashdata('query_mdl_message')) {
                    ?>
                        <div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('query_mdl_message'); ?>
                                </strong>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <textarea name='query' class="form-control">Please enter your query</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id='querySend' class="btn query btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  -->
<script type="text/javascript">
    $(document).ready(function() {
        let removeApplicant = [];
        <?php
        if ($this->session->flashdata('query_mdl_message')) {
        ?>
            $('#myModal1').modal('show');
        <?php
        }
        ?>

        getNoks();

        $(document).on('click', '.add_applicant_btn', function(){
            $('.error, .app_add_scc').text('');
            const $this = $(this);
            $this.attr('disabled', true);
            let allFieldHasVal = true;
            $('.add_applicant_fld').each(function() {
                let closestFormGroup = $(this).closest('.formgroup');
                if($(this).val() == ''){
                    allFieldHasVal = false;
                    $('.add_applicant_fld_error', closestFormGroup).text('The field is required');
                }
            });
            console.log(allFieldHasVal);
            if(!allFieldHasVal){
                $this.attr('disabled', false);

                return false;
            }

            let protectedClass = $('#first_party_protcast').val();
            let protectedClassNmAttr = $('#first_party_protcast').attr('name');
            if(protectedClass == ''){
                protectedClass = 'NA';
            }
            let address = $('#first_party_address').val();
            let addressNmAttr = $('#first_party_address').attr('name');

            let formData = new FormData(document.getElementById('addApplicantForm'));

            $.ajax({
                method: 'POST',
                data: formData,
                url: "<?= base_url('index.php/add-nok'); ?>",
                processData : false, // Don't process the files
                contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                dataType    : 'json',
                success: function(response){
                    if(response.success){
                        arrangeNok(response.data);
                        $('.app_add_scc').text(response.message).show();
                    }else{
                        $('.app_add_scc').text(response.message).show();
                    }
                    
                    $('#addApplicantForm').trigger("reset");
                    $this.attr('disabled', false);
                    
                },
                error: function(data){
                    var errors = data.responseJSON;
                }
            });
            
            setTimeout(() => {
                $('.app_add_scc').hide(500);
            }, 2000);
        });

        $(document).on('click', '.delete_applicant', function(){
            const $this = $(this);
            Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'You want to delete this!',
                    showCancelButton: true,
                    // confirmButtonColor: '#2dbc9d',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((response) => {
                    if(response.isConfirmed){
                        if($this.hasClass('rtps_applicant')){
                            removeApplicant.push($this.attr('data-index'));
                            $this.closest('tr').remove();
                            manageSlNo();
                        }else{
                            const caseId = $('#case_id').val();
                            const serialId = $this.data('serial_id');
                            let formData = new FormData();
                                formData.append('case_id', caseId);
                                formData.append('row_id', serialId);
                            $.ajax({
                                url: "<?= base_url('index.php/delete-noks'); ?>",
                                method: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response){
                                    if(response.success){
                                        $this.closest('tr').remove();
                                        manageSlNo();
                                    }else{
                                        alert(response.message);
                                    }
                                },
                                error: function(errorData){
                                    alert("Something went wrong. Please try again later.");
                                }
                            });
                        }
                        
                    }
                });
        });

        $('#formAjaxPost').on('submit', function(event) {
            event.preventDefault();
            if ($("#reapply_remark").val().trim().length < 1) {
                alert("Please Enter Your Remark");
                return;
            }
            var mut_type = $("#mut_type");
            if (mut_type.val() == "") {
                alert("Please select Transfer Type!");
                return false;
            }
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            if(removeApplicant.length > 0){
                for(var i = 0; i < removeApplicant.length; i++){
                    formData.append('remove_applicant[]', removeApplicant[i]);
                }
            }

            $.ajax({
                type: 'POST',
                url: baseurl + 'rtps/deedMultiDagPost',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                // encode: true,
                beforeSend: function() {
                    $("#loading").html("Validating ...Please wait...");
                    $('.alert').hide();
                    $('.disable_forward').hide();
                },
                success: function(data) {
                    // console.log(data);
                    if (data.success != null) {
                        //alert('hai');
                        $("#loading").hide();
                        $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                        window.location.href = data.redirect_url;
                    } else if (data.error != null) {
                        $("#loading").hide();
                        $('.btn-block').show();
                        $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                        $('.disable_forward').show();
                    }
                },
                error: function(errors){
                    $("#loading").hide();
                    $('.btn-block').show();
                    $('#msg').html('<div class="alert alert-danger text-center">Something went wrong. Please try again later.</div>');
                    $('.disable_forward').show();
                }
            });
        });
    });

    function getNoks(){
        const caseId = $('#case_id').val();
        let formData = new FormData();
            formData.append('case_id', caseId);
        $.ajax({
            method: 'POST',
            data: formData,
            url: "<?= base_url('index.php/get-noks'); ?>",
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success: function(response){
                if(response.success){
                    arrangeNok(response.data);
                }
            },
            error: function(data){
                var errors = data.responseJSON;
            }
        });
    }

    function arrangeNok(datas){
        let html = '';
        $('.nok_tr').remove();
        if(datas.length > 0){
            $.each(datas, function(index, data){
                html += `<tr class="bg-success applicant_sl nok_tr">
                            <td class="sl_no"></td>
                            <td>${data.name_asm}</td>
                            <td>${data.guardian_name_asm}</td>
                            <td>${data.relation_name}</td>
                            <td>${data.gender_name}</td>
                            <td>${data.mobile}</td>
                            <td>${data.marital_status_name}</td>
                            <td>${data.applicant_occupation}</td>
                            <td>
                                ${data.caste_category_name}
                                ${data.tribe_category_name != '' ? `<br>(${data.tribe_category_name})` : `` }
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger delete_applicant" data-serial_id="${data.serial_id}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
            });

            $('.applicant_tbody').append(html);

            manageSlNo();
        }
    }

    function manageSlNo(){
        $('.applicant_sl').each(function(index){
            let closestTr = $(this);
            $('.sl_no', closestTr).text(index + 1);
        });
    }
</script>
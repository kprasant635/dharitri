    <div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
    <div class="container-fluid form-top login">
        <div class="row">
            <div class="col-lg-12 ">

                <?php if($this->session->flashdata('message')):?>
                <div class="col-lg-12 ">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                    </div>
                </div>
                <?php endif;?>


                <div class="col-lg-10 col-lg-offset-1">
                    <div class="well well-sm">
                        <h2 style="text-align: center;">Revert Report</h2>
                    </div>
                </div>
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <input type="hidden" value="<?=$this->input->get('case_no')?>" id="case_no">
                                <label class="col-sm-6 rasid">Case No : <?php echo $this->input->get('case_no'); ?></label>
                                <label class="col-sm-3 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                                <label class="col-sm-3 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                                <br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span style="color:#3c8198; font-size: 18px" class="bold"><?php echo $this->lang->line('general_information'); ?>
                            </span>
                            <table class='table table-bordered unicode'>
                                <tr>
                                    <td width="35%"><label
                                        class="text-danger">Case No.
                                        : &nbsp;&nbsp;&nbsp;<?= $petition_basic ->case_no ?></label>
                                    </td>
                                    <td width="30%"><label
                                        class="text-danger">Transfer Type
                                        : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getTransferType($petition_basic ->trans_code) ?></label>
                                    </td>
                                    <td width="35%"><label
                                        class="text-danger">জিলা (District)
                                        : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getDistrictName($petition_basic ->dist_code) ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label
                                        class="text-danger">মহকুমা (Sub Division)
                                        :
                                        &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getSubDivName($petition_basic ->dist_code, $petition_basic ->subdiv_code) ?></label>
                                    </td>
                                    <td><label
                                        class="text-danger">চক্র (Circle)
                                        :
                                        &nbsp;&nbsp;&nbsp; <?= $this->utilityclass->getCircleName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code) ?></label>
                                    </td>
                                    <td><label
                                        class="text-danger">মৌজা (Mouza)
                                        : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getMouzaName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code, $petition_basic ->mouza_pargona_code) ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><label
                                        class="text-danger">লাট (Lot)
                                        : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getLotName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code, $petition_basic ->mouza_pargona_code, $petition_basic ->lot_no) ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label
                                        class="text-danger">গাওঁ / চহৰ (Village) :
                                        <?= $this->utilityclass->getVillageName($petition_basic ->dist_code, $petition_basic ->subdiv_code, $petition_basic ->cir_code, $petition_basic ->mouza_pargona_code, $petition_basic ->lot_no, $petition_basic ->vill_townprt_code) ?></span>
                                    </label>
                                </td>
                                <td><label
                                    class="text-danger">Patta No.
                                    : &nbsp;&nbsp;&nbsp;<?= $petition_dag_details[0]->patta_no ?></label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span style="color:#3c8198; font-size: 18px" class="bold">
                            <?php echo $this->lang->line('applicant_information'); ?> (First Party)
                        </span>
                        <table class='table table-bordered unicode'>
                            <thead>
                                <tr>
                                    <th><label
                                        class="text-danger"><?php echo $this->lang->line('applicants_name'); ?></label>
                                    </th>
                                    <th><label
                                        class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label>
                                    </th>
                                    <th><label
                                        class="text-danger"><?php echo $this->lang->line('address1'); ?>
                                        / <?php echo $this->lang->line('address2'); ?></label>
                                    </th>
                                    <th><label class="text-danger">Land Area</label>
                                    </th>
                                    <th><label class="text-danger">Marital Status</label></th>
                                    <th><label class="text-danger">Occupation</label></th>
                                    <th><label class="text-danger">Caste</label></th>
                                    <th><label class="text-danger">Edit | Delete</label></th>                                    
                                </tr>
                            </thead>
                            <tbody id="petitioner">
                                <?php foreach ($petitioner as $key=>$applicant) {

                                    $bigha = (($applicant->applied_b==null)?'0':$applicant->applied_b);
                                    $katha = (($applicant->applied_k==null)?'0':$applicant->applied_k);
                                    $lessa = (($applicant->applied_lc==null)?'0':$applicant->applied_b);

                                    $land = 'B:'.$bigha.' / K:'.$katha.' / L:'.$lessa.' / Kr: 0';
                                    $add2 = $applicant->add2;

                                    ?>
                                    <tr id="<?=$applicant->pet_id?>" class="remove_<?=$applicant->pet_id?>">
                                        <td><?= $applicant->pet_name ?></label>
                                        </td>
                                        <td><?= $applicant->guard_name ?></label>
                                        </td>
                                        <td>Add 1: <?= $applicant->add1 ?><br>
                                        <?=(($add2=='')?'':'Add 2:'. $add2)?>
                                        </td>
                                        <td><label class="text-danger"><?=$land?></label></td>
                                        <td>
                                            <?= $this->utilityclass->getMaritalStatusName($applicant->marital_status); ?>
                                        </td>
                                        <td>
                                            <?= $applicant->applicant_occupation; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                echo $this->utilityclass->getCasteCategoryName($applicant->caste_category); 
                                                if($applicant->tribe_category){
                                                    echo "<br> (". $this->utilityclass->getTribeCategoryName($applicant->tribe_category) .")";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btnOMutationFirstApplEditLM" id="<?=$applicant->pet_id?>" title="Click to Edit Applicant <?= $applicant->pet_name ?>"><i class="fa fa-edit"></i></button>&nbsp;
                                            <button class="btn btn-sm btn-danger btnOMutationApplDeleteLM" title="Click to Delete Applicant <?= $applicant->pet_name ?>" id="<?=$applicant->pet_id?>"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <span style="color:#3c8198; font-size: 18px" class="bold">
                            Land Area Details
                        </span>
                        <table class='table table-bordered unicode'>
                            <thead>
                                <tr>
                                    <th>Dag No</th>
                                    <th>Patta Type</th>
                                    <th>Total Area</th>
                                    <th>Area To Be Mutated</th>                                  
                                </tr>
                            </thead>
                            <tbody id="land_area_dtl">
                                <?php 
                                    $dist_code = $this->session->userdata('dist_code');
                                    foreach ($petition_dag_details as $key => $petition_dag_detail) :
                                ?>
                                    <tr>
                                        <td><?= $petition_dag_detail->dag_no ?></label>
                                        </td>
                                        <td><?= $this->utilityclass->getPattaType($petition_dag_detail->patta_type_code); ?></label>
                                        </td>
                                        <?php
                                            if (in_array($dist_code, json_decode(BARAK_VALLEY))) {
                                        ?>
                                                <td><?= $petition_dag_detail->dag_area_b; ?>B-<?= $petition_dag_detail->dag_area_k; ?>K-<?= $petition_dag_detail->dag_area_lc; ?>C-<?= $petition_dag_detail->dag_area_g; ?>G </td>
                                                <td><?= $petition_dag_detail->m_dag_area_b; ?>B-<?= $petition_dag_detail->m_dag_area_k; ?>K-<?= $petition_dag_detail->m_dag_area_lc; ?>C-<?= $petition_dag_detail->m_dag_area_g; ?>G </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td><?= $petition_dag_detail->dag_area_b; ?>B-<?= $petition_dag_detail->dag_area_k; ?>K-<?= $petition_dag_detail->dag_area_lc; ?>L </td>
                                                <td><?= $petition_dag_detail->m_dag_area_b; ?>B-<?= $petition_dag_detail->m_dag_area_k; ?>K-<?= $petition_dag_detail->m_dag_area_lc; ?>L </td>
                                        <?php
                                            }
                                        ?>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
            
                    <div class="form-group" style="padding-left:10px;">
                         <?php
                            if($basundharaAttachment){
                            echo '<h2 class="red">Basundhara Attachments</h2>';
                            foreach ($basundharaAttachment  as $attachment):
                            ?>
                            <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                            <?php 
                            endforeach; 
                            }
                        ?>   
                    </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <span style="color:#3c8198; font-size: 18px" class="bold">Pattadar Details (Second Party)
                </span>

                <?php if($petition_basic->trans_code=='03' && $basuCase) { ?>
                    <button class="btn btn-sm btn-danger pull-right btnAddSecondPartyOM uni_text" style="border: 1px solid #000"><i class="fa fa-plus-square"></i>&nbsp;Add Second Party</button>
                <?php } ?>

                <table class='table table-bordered unicode'>
                    <thead>
                        <tr>
                            <th><label
                                class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label>
                            </th>
                            <th><label
                                class="text-danger">Pattadar Name</label>
                            </th>
                            <th><label
                                class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label>
                            </th>
                            <th><label
                                class="text-danger"><?php echo $this->lang->line('address1'); ?>
                                / <?php echo $this->lang->line('address2'); ?></label>
                            </th>
                            <th><label class="text-danger">Inplace Alongwith</label>
                            </th>
                            <?php if($petition_basic->trans_code=='03' && $basuCase) { ?>
                            <th><label class="text-danger">Delete</label></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="petitioner_second_party">
                        <?php foreach ($petition_pattadar as $key=>$pattadar) {?>
                            <tr>
                                <td><?= ++$key?></td>
                                <td><?= $pattadar->pdar_name ?></td>
                                <td><?= $pattadar->pdar_guardian ?></td>
                                <td>Add 1: <?= $pattadar->pdar_add1 ?>
                                    / Add 2: <?= $pattadar->pdar_add2 ?>
                                </td>
                                <td>
                                    <?php if($pattadar->striked_out == 1) { ?>
                                        Inplace
                                    <?php } else if($pattadar->striked_out == 0) { ?>
                                        Alongwith
                                    <?php }?>
                                </td>
                                <?php if($petition_basic->trans_code=='03' && $basuCase) { ?>
                                <td>
                                    <button id="<?=$pattadar->pdar_id?>,<?=$pattadar->dist_code?>,<?=$pattadar->subdiv_code?>,<?=$pattadar->cir_code?>,<?=$pattadar->mouza_pargona_code?>,<?=$pattadar->lot_no?>,<?=$pattadar->vill_townprt_code?>,<?=$pattadar->dag_no?>,<?=$pattadar->patta_no?>,<?=$pattadar->patta_type_code?>,<?=$pattadar->pdar_cron_no?>" type="button" class="btn btn-sm btn-danger btnOMSPdel"><i class="fa fa-trash"></i></button>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 delete_error_SP_OM text-bold text-red"></div>
            <hr style="border-bottom: 2px solid #000;">

            <?php if($petition_basic ->mut_type=='03') { ?>
            <form class="form-horizontal" id="nok_applicant" method="post" >
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <label for="inputEmail3"
                    class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('applicants_name') ?></label>
                    <input type="text" class="form-control" required1=""
                    name="name_asm" id="name_asm" autocomplete="off"
                    placeholder="<?php echo $this->lang->line('applicants_name') ?>">
                    <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_name_asm"
                    class="error_class_a"></span>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <label for="inputEmail3"
                    class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('gender') ?></label>
                    <select class="form-control relation-type" name="gender" required1
                    id="relation">
                    <option selected disabled value="">Select Gender</option>
                    <?php foreach ($genders as $g): ?>
                        <option value="<?php echo $g->short_name; ?>">
                            <?php echo $g->gen_name_ass; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_gender"
                    class="error_class_a"></span>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                    <label for="inputEmail3"
                    class="uni_text control-label"><?php echo $this->lang->line('date_of_birth') ?></label>
                    <div class="input-group col-sm-12 date datepicker"
                    data-date-format="dd-mm-yyyy">
                    <input type="text" readonly class="form-control dating" id="dob"
                    placeholder="<?php echo $this->lang->line('date_of_birth') ?>"
                    name="dob" autocomplete="off" />
                </div>
                <span style="color:red; font-size: 14px; padding-top:5px;"
                id="error_a_dob" class="error_class_a"></span>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                <label for="inputEmail3"
                class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('guardian_name') ?></label>
                <input type="text" class="form-control" required1=""
                name="guardian_name_asm" id="guardian_name_asm" autocomplete="off"
                placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_guardian_name_asm"
                class="error_class_a"></span>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <label for="inputEmail3"
                class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('guardian_relation') ?></label>
                <select class="form-control relation-type" name="relation" required1=""
                id="relation">
                <option selected disabled value="">
                    <?php echo $this->lang->line('select_relation') ?></option>
                    <?php foreach ($relation as $r): ?>
                        <option value="<?php echo $r->guard_rel; ?>">
                            <?php echo $r->guard_rel_desc_as; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_relation"
                    class="error_class_a"></span>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <label for="inputEmail3"
                    class="uni_text control-label required">Address</label>
                    <input type="text" maxlength="100" class="form-control" name="address" id="address" placeholder=" Address">
                    <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_address"
                    class="error_class_a"></span>
                </div>
                <input type='hidden' name='case_id' id="case_id" value='<?php echo $this->input->get('case_no'); ?>'>
                <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_case_id"
                class="error_class_a"></span>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
                    <center><button type="submit" class="btn btn-success btnLoc applicant_form"><i
                        class='fa fa-save'></i>&nbsp;Save & Add More
                    </button></center>
                </div>
            </form>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
            <table width="100%" class="table table-striped table-bordered" style=" overflow:auto;">
                <thead style="white-space:nowrap; ">
                    <tr class="text-bold table-success">
                        <th align='center'>#</th>
                        <th>Applicant Name</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Guardian Name</th>
                        <th>Guardian Relation</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="applicant_table_show">
                    <?php $i=1; foreach($nok_temp as $tp){ ?>
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$tp->name_asm;?></td>
                        <td><?=$tp->gender;?></td>
                        <td><?=date('Y-m-d',strtotime($tp->dob))?></td>
                        <td><?=$tp->guardian_name_asm;?></td>
                        <td><?=$tp->relation_name;?></td>
                        <td><?=$tp->address;?></td>
                        <td>
                            <button class="btn btn-sm btn-danger delete_application_row" 
                            id="<?=$tp->serial_id?>"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>





            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-lg-12 text-bold text-red" id="alert_message"></div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <label><u>Upload Supportive Document</u></label>
                &nbsp;
<i class="fa fa-info-circle text-red" 
title="1. Uploaded file types should be jpeg|jpg|png|pdf only.
2. Uploaded file size should not be more than 4MB"></i>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                <table class="table table-striped table-bordered">
                    <tbody id='certi_tab'>
                        
                        <tr>
                            <td><span class="text-bold"><?=DEATH_CERTIFICATE?></span>
                            </td>
                            <td><input type='file' name="death_cer" id="death_cer"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadOMutDocumentLM" id='1'>Upload Death Certificate&nbsp;<i class='fa fa-upload'></i></button>
                            </td>
                            <td>
                                <?php if(!empty($d_id)) { if($d_id->id!='' || $d_id->id!=null) { ?>
                                <div id="div_death">
                                    <button class="btn btn-sm btn-info"><a  style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$d_id->id?>" target="_blank">VIEW <?=$d_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removeFreshReportDocumentLM removeDeath" id='1'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_1"></div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="text-bold"><?=NOC?></span>
                            </td>
                            <td><input type='file' name="noc_file" id="noc_file"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadOMutDocumentLM" id='2'>Upload NOC&nbsp;<i class='fa fa-upload'></i></button>
                                </a>
                            </td>
                            <td>

                                <?php if(!empty($noc_id)) { if($noc_id->id!='' || $noc_id->id!=null) { ?>
                                <div id="div_noc">
                                    <button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$noc_id->id?>" target="_blank">VIEW <?=$noc_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removeFreshReportDocumentLM removeNOC" id='2'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_2"></div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="text-bold"><?=NOK_CONSENT?></span>
                            </td>
                            <td><input type='file' name="nok_file" id="nok_file"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadOMutDocumentLM" id='3'>Upload NOK&nbsp;<i class='fa fa-upload'></i></button>
                            </td>
                            <td>

                                <?php if(!empty($nok_id)) { if($nok_id->id!='' || $nok_id->id!=null) { ?>
                                <div id="div_nok">
                                    <button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$nok_id->id?>" target="_blank">VIEW <?=$nok_id->file_name?></a></button>
                                    &nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentLM" id='3'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_3"></div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <form class="form-horizontal" action="<?=base_url().'index.php/lmmutation/OMutUpdateReport'?>" method="post" >
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <label for="inputEmail3"
                    class="uni_text control-label required">Type Note</label>
                    <textarea class="form-control" rows="5" name='note_order' id="note_order" placeholder="Please Type Your Report"></textarea>
                </div>
                <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'>
                <hr style="border-bottom: 2px solid #000;">
                <center>
                    <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                </center>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>


<!---// Edit Applicant Modal --->
<?php foreach($petitioner as $appl): ?>

<div class="modal" id="editOMAppl_<?=$appl->pet_id?>" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <!-- <form id="first_applicant_edit_<?=$appl->pet_id?>" method="post"> -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #136a6f; color: white">
                            <span class="text-bold">Update Applicant : &nbsp;&nbsp;<?=$appl->pet_name?></span>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold">Applicant`s Name</span>
                            <span class="text-danger text-bold">&nbsp;*</span>
                            <input type="text" class="form-control" name="pet_name" id="pet_name_<?=$appl->pet_id?>" placeholder="<?php echo $this->lang->line('applicants_name') ?>"
                            value="<?=$appl->pet_name?>">
                            <div id="alert_pet_name"></div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold"><?php echo $this->lang->line('gender') ?></span>
                            <span class="text-danger text-bold">&nbsp;*</span>
                            <select class="form-control" name="pet_gender" id='pet_gender_<?=$appl->pet_id?>'>
                                <option disabled selected value="">-- Select Gender --</option>
                                <?php foreach ($genders as $r): ?>
                                <option value="<?=$r->short_name?>"  <?=(($appl->pet_gender==$r->short_name)?'selected':'')?>><?=$r->gen_name_ass?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="alert_pet_gender"></div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 applicant_guard_name main_guard">
                            <span class="text-bold"><?php echo $this->lang->line('guardian_name') ?></span>
                            <span class="text-danger text-bold">&nbsp;*</span>
                            <input type="text" class="form-control guard_name" 
                            name="guard_name" id="guard_name_<?=$appl->pet_id?>" value="<?=$appl->guard_name?>"
                            placeholder="<?php echo $this->lang->line('guardian_name') ?>">
                            <div id="alert_guard_name"></div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12"><!--guardian relation-->
                            <span class="text-bold">Guardian Relation</span>
                            <span class="text-danger text-bold">&nbsp;*</span>
                            <select class="form-control" id="relation_guardian_<?=$appl->pet_id?>" name="relation_guardian">
                            <option selected disabled value="0">
                                <?php echo $this->lang->line('select_relation') ?></option>
                                <?php foreach ($relation as $r): ?>
                                    <option value="<?php echo $r->guard_rel; ?>" <?=(($appl->guard_rel==$r->guard_rel)?'selected':'')?>><?php echo $r->guard_rel_desc_as; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="alert_relation_guardian"></div>
                        </div>
                        
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-md-5 col-lg-5 col-sm-6 col-xs-12">
                            <span class="text-bold"><?php echo $this->lang->line('address1') ?></span>
                            <span class="text-danger text-bold">&nbsp;*</span>
                            <input type="text" maxlength="100" class="form-control" name="add1"
                            id="add1_<?=$appl->pet_id?>" placeholder=" <?php echo $this->lang->line('address1') ?>"
                            value="<?=$appl->add1?>">
                            <div id="alert_add1"></div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                            <span class="text-bold"><?php echo $this->lang->line('address2') ?></span>
                            <span class="text-danger text-bold">&nbsp;*</span>
                            <input type="text" maxlength="100" class="form-control" name="add2"
                            id="add2_<?=$appl->pet_id?>" placeholder=" <?php echo $this->lang->line('address2') ?>" value="<?=$appl->add2?>">
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                            <span class="text-bold">Phone Number</span>
                            <input type="text" readonly class="form-control" value="<?=$appl->pdar_mobile?>"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">&nbsp;</div>

                    </div>
                </div>
                <div class="modal-footer">
                    
                    <input type="hidden" value="<?=$appl->pet_id?>" name="pet_id" id="pet_id">
                    <input type="hidden" value="<?=$appl->case_no?>" name="case_no" id="case_no">
                    <input type="hidden" value="<?=$appl->petition_no?>" name="petition_no" id="petition_no">

                    <button class="btn btn-sm btn-info btnOMutUpdateApplicantCO" 
                    id="<?=$appl->pet_id?>" type="submit">Update Applicant</button>
                    <button type="button" class="btn btn-sm btn-default btnOMutApplicantCloseModal" id="<?=$appl->pet_id?>">Close</button>
                </div>
            <!-- </form> -->

            
        </div>
    </div>
</div>
<?php endforeach;?>
<!---// Edit Applicant --->


    <!---// Add office mutation Second pattadar --->
    <div class="modal" id="editSecondPattadarOM" role="dialog">
        <div class="modal-dialog" style="max-width: 70%;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-red text-bold">
                            Additional Second Party Adding Form
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><hr></div>

                        <form id="add_additional_second_party_OM" method="post">
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Select Applicant</span>
                                <select class="form-control" name="appl_sec_party_OM" id='appl_sec_party_OM'>
                                    <option value="">Select Applicant</option>
                                </select>
                                <div id="error_appl_sec_party_OM"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Guardian Name</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" class="form-control" 
                                name="guardian_name_sec_party_OM" 
                                id="guardian_name_sec_party_OM" value="" readonly>
                                <div id="error_patta_guardian_name_sec_party_OM"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Relation</span>
                                <span class="text-red text-bold">*</span>
                                <select class="form-control" name="relation_sec_party_OM" 
                                id='relation_sec_party_OM'>
                                    <option value="">Select Relation</option>
                                </select>
                                <div id="error_relation_sec_party_OM"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Gender</span>
                                <span class="text-red text-bold">*</span>
                                <select class="form-control" name="gender_sec_party_OM" 
                                id='gender_sec_party_OM'>
                                    <option value="">Select Gender</option>
                                </select>
                                <div id="error_gender_sec_party_OM"></div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">DOB</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" class="form-control dating" 
                                name="dob_sec_party_OM" id="dob_sec_party_OM" value="" readonly>
                                <div id="error_dob_sec_party_OM"></div>
                            </div>   
                            <style type="text/css">
                                .datepick-popup{
                                    position: fixed;
                                    left:0 px;
                                    right:0 px;
                                    z-index:10000;
                                }
                            </style>
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <span class="text-bold">Address</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" name="address_sec_party_OM" 
                                id="address_sec_party_OM" value="" class="form-control">
                                <div id="error_address_sec_party_OM"></div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                                <span class="text-bold">Select Inplace/Alongwith</span>
                                <select class="form-control" name="strikeout_sec_party_OM" id='strikeout_sec_party_OM'>
                                    <option selected disabled>Select Inplace/Alongwith</option>
                                    <option value="1">Inplace</option>
                                    <option value="0">Alongwith</option>
                                </select>
                                <div id="error_strikeout_sec_party_OM"></div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 pull-right">
                                <button type="submit" id="saveSecPartyOM" class="btn btn-sm btn-primary">Save Second Party</button>
                                <button type="button" class="btn btn-sm btn-default btnCloseSecPartyOM" id="">Close</button>
                                <input type="hidden" name="dist" id="dist" value="<?=$petition_basic->dist_code?>">
                                <input type="hidden" id="sub" name="sub" value="<?=$petition_basic->subdiv_code?>">
                                <input type="hidden" id="cir" name="cir" value="<?=$petition_basic->cir_code?>">
                                <input type="hidden" id="mouza" name="mouza" value="<?=$petition_basic->mouza_pargona_code?>">
                                <input type="hidden" id="lot" name="lot" value="<?=$petition_basic->lot_no?>">
                                <input type="hidden" id="vill" name="vill" value="<?=$petition_basic->vill_townprt_code?>">
                                <input type="hidden" id="dag" name="dag" value="<?= $petition_dag_details[0]->dag_no ?>">
                                <input type="hidden" id="ptype" name="ptype" value="<?=$petition_dag_details[0]->patta_type_code?>">
                                <input type="hidden" id="pn" name="pn" value="<?=$petition_dag_details[0]->patta_no?>">
                            </div>
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 div_error_SP_OM text-bold text-red"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---// Add office mutation Second pattadar ends here --->



<!--///////////////////////LM UPDATE REPORT///////////////////////////////-->
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
    $(function() {
        $('#nok_applicant').submit(function(e) {
            e.preventDefault();
            if(!confirm("Are you sure you want to add applicant?"))
            {
                return false;
            }
            $.ajax({
                url: baseurl + "lmmutation/OMutAddApplicant",
                method: "POST",
                data: $('#nok_applicant').serialize(),
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        $('.error_class_a').html('');
                        $.each(data.error, function (index, value) {
                            $('#error_a_' + value['field'])
                            .html(value['message']);
                        });
                    }
                    if (data.validation_success == 'true' && data.success === true) 
                    {
                        $('#nok_applicant').trigger("reset");
                        $('.error_class_a').html('');
                        alert(data.msg);
                        //if (data.nok_tmp) {
                            var nok_tmp_table = '';
                            $.each(data.nok_tmp, function (index, value) {
                                index++;
                                nok_tmp_table +=
                                '<tr>' +
                                    '<td align="center">' + index + '</td>' +
                                    '<td>' + value["name_asm"] + '</td>' +
                                    '<td>' + value["gender"] + '</td>' +
                                    '<td>' + value["dob"] + '</td>' +
                                    '<td>' + value["guardian_name_asm"] + '</td>' +
                                    '<td>' + value["relation"] + '</td>' +
                                    '<td>' + value["address"] + '</td>' +
                                    '<td>' + '<button class="btn btn-sm btn-danger delete_application_row" id="'+value['serial_id']+'"><i class="fa fa-trash"></i></button>' + '</td>' +
                                '</tr>'
                            });
                            console.log(nok_tmp_table);
                            $('#applicant_table_show').html(nok_tmp_table);
                    }
                    else
                    {
                        if(data.msg){
                        alert(data.msg);
                        }
                    }
                }
            })
        });
    });
</script>
<script>
    
    $(document).on('click', '.delete_application_row', function(){
        id = $(this).attr('id');
        case_no = $('#case_no').val();
        data = {id:id, case_no:case_no}
        if(confirm("Are you sure to delete petitioner ?")){
            $.ajax({
                url: baseurl + "lmmutation/deleteOfcMutationNOK/",
                type:'POST',
                data:data,
                dataType:'json',
                success: function (data) {
                    console.log(data);
                    var nok_tmp_table = '';
                    $.each(data.details, function (index, value) {
                        index++;
                        nok_tmp_table +=
                        '<tr>' +
                            '<td align="center">' + index + '</td>' +
                            '<td>' + value["name_asm"] + '</td>' +
                            '<td>' + value["gender"] + '</td>' +
                            '<td>' + value["dob"] + '</td>' +
                            '<td>' + value["guardian_name_asm"] + '</td>' +
                            '<td>' + value["relation"] + '</td>' +
                            '<td>' + value["address"] + '</td>' +
                            '<td>' + '<button class="btn btn-sm btn-danger delete_application_row" id="'+value['serial_id']+'"><i class="fa fa-trash"></i></button>' + '</td>' +
                        '</tr>'
                    });
                    console.log(nok_tmp_table);
                    $('#applicant_table_show').html(nok_tmp_table);
                    $('#nok_applicant').trigger("reset");
                }
            });
        }  
    });


    ////////////    06-04-22 office mutation second party add & delete     /////////////
    //close modal
    $(document).on('click','.btnCloseSecPartyOM', function(){
        $('#editSecondPattadarOM').modal('hide');
    });
    //popup and load applicant detail
    $(document).on('click', '.btnAddSecondPartyOM', function(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        no = $('#case_no').val();
        dist = $('#dist').val();
        sub = $('#sub').val();
        cir = $('#cir').val();
        mouza = $('#mouza').val();
        lot = $('#lot').val();
        vill = $('#vill').val();
        dag = $('#dag').val();
        pno = $('#pn').val();
        ptype = $('#ptype').val();

        arr = no.split('/');
        petition_no = arr['3'];

        $('#editSecondPattadarOM').modal('show');

        $.ajax({
            url: baseurl + "lmmutation/getSecondPartyApplicantDetailOM",
            type:'POST',
            data:{petition_no:petition_no, dist:dist, sub:sub, cir:cir, mouza:mouza, lot:lot, vill:vill, dag:dag, pno:pno, ptype:ptype},
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                $("#add_additional_second_party_OM").trigger('reset');
                if(data.sec_party){
                    var template = '<option selected disabled value="">Select Applicant</option>';
                    $.each(data.sec_party, function (index, val) {
                        template += '<option value='+val["pdar_id"]+'>'+val["pdar_name"]+' </option>'
                    });
                    $('#appl_sec_party_OM').html(template);
                }
                //relation list
                if(data.relation){
                    var relTemp = '<option selected disabled value="">Select Relation</option>';
                    $.each(data.relation, function (index, val) {
                        relTemp += '<option value='+val["guard_rel"]+'>'+val["guard_rel_desc_as"]+' </option>'
                    });
                    $('#relation_sec_party_OM').html(relTemp);
                }
                //gender list
                if(data.genders){
                    var genTemp = '<option selected disabled value="">Select Gender</option>';
                    $.each(data.genders, function (index, val) {
                        genTemp += '<option value='+val["short_name"]+'>'+val["gen_name_ass"]+' </option>'
                    });
                    $('#gender_sec_party_OM').html(genTemp);
                }
            },
            error: function(data){
                $.unblockUI();
                alert("Something Went wrong");
            }
        });
    });
    //onchange applicant, get respective detail
    $('#appl_sec_party_OM').change(function(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        dist = $('#dist').val();
        sub = $('#sub').val();
        cir = $('#cir').val();
        mouza = $('#mouza').val();
        lot = $('#lot').val();
        vill = $('#vill').val();
        dag = $('#dag').val();
        ptype = $('#ptype').val();
        pn = $('#pn').val();
        case_no = $('#case_no').val();
        id = $('#appl_sec_party_OM').val();

        $.ajax({
            url: baseurl + "lmmutation/getPattadarDetailsOfc",
            type: 'POST',
            data: {dist:dist, sub:sub, cir:cir, mouza:mouza, lot:lot, vill:vill, dag:dag, ptype:ptype, pn:pn, case_no:case_no, id:id},
            dataType: "json",
            success: function (data) 
            {
                $.unblockUI();
                if(data.details){
                    $('#guardian_name_sec_party_OM').val(data.details.pdar_father);
                    $('#dob_sec_party_OM').val(data.details.pdar_minor_dob);
                    $('#address_sec_party_OM').val(data.details.pdar_add1);
                }
            },
            error:function(data){
                alert("Something went wrong");
                $.unblockUI();
            }
        });
    });
    // //insert second party
    $('#add_additional_second_party_OM').submit(function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "lmmutation/addAdditionalSecondPartyOM",
            type: 'POST',
            data: $("#add_additional_second_party_OM").serialize()+
                    "&case_no="+$('#case_no').val()+
                    "&applicant_name="+$("#appl_sec_party_OM option:selected").text(),
            dataType: "json",
            success: function (data) 
            {
                $.unblockUI();
                if(data.message != null){
                    $('.div_error_SP_OM').fadeIn();
                    $('.div_error_SP_OM').html(data.message);
                    setTimeout(function(){
                        $('.div_error_SP_OM').fadeOut();
                    }, 30000);
                }
                if(data.success == 'true'){
                    alert("Second Party has added successfully");
                    $('#editSecondPattadarOM').modal('hide');
                    var table = '';
                    $.each(data.details, function (i, val) { 
                        table +=                     
                        '<tr>'+
                            '<td>' + ++i + '</td>' +
                            '<td>' + val["pdar_name"] + '</td>' +
                            '<td>' + val["pdar_guardian"] + '</td>' +
                            '<td>' + ((val["pdar_add1"]==null || val["pdar_add1"]=='')?'-':val["pdar_add1"]) + '</td>' +
                            '<td>' + ((val["striked_out"]==1)?'Inplace':'Alongwith') + '</td>' +
                            '<td align="center">' +
                                '<button type="button" class="btn btn-sm btn-danger btnOMSPdel" id="'+val["pdar_id"]+','+val["dist_code"]+','+val["subdiv_code"]+','+val["cir_code"]+','+val["mouza_pargona_code"]+','+val["lot_no"]+','+val["vill_townprt_code"]+','+val["dag_no"]+','+val["patta_no"]+','+val["patta_type_code"]+','+val["pdar_cron_no"]+'">' +
                                    '<i class="fa fa-trash"></i></button>' +
                            '</td>'+
                        '</tr>'
                    });
                    $('#petitioner_second_party').html(table);
                }

                if(data.pattadarList){
                    var template = '<option selected disabled value="">Select Applicant</option>';
                    $.each(data.pattadarList, function (index, val) {
                        template += '<option value='+val["pdar_id"]+'>'+val["pdar_name"]+' </option>'
                    });
                    $('#appl_sec_party_OM').html(template);
                }
                if(data.error){
                    $.each(data.error, function (index, value) {
                        $('#error_'+value['field']).fadeIn();
                        $('#error_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#error_'+value['field']).fadeOut();
                        }, 30000);
                    });    
                }
            },
            error: function(data){
                $.unblockUI();
                alert("Unable to Process");
            }
        });
    });
    // //delete second party
    $(document).on('click', '.btnOMSPdel', function(){
        id = $(this).attr('id');
        arr = id.split(',');
        pid = arr[0];
        dist = arr[1];
        sub = arr[2];
        cir = arr[3];
        mouza = arr[4];
        lot = arr[5];
        vill = arr[6];
        dag = arr[7];
        pno = arr[8];
        ptype = arr[9];
        cron= arr[10];
        case_no = $('#case_no').val();        

        data = {pid:pid, dist:dist, sub:sub, cir:cir, mouza:mouza, lot:lot, vill:vill, dag:dag, pno:pno, ptype:ptype, cron:cron, case_no:case_no}

        if(confirm("Are you sure to delete second party ? Once deleted, it cannot be undone..")){
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: baseurl + "lmmutation/deleteSecondPartyOM/",
                type:'POST',
                data:data,
                dataType:'json',
                success: function (data) {
                    $.unblockUI();
                    //for message display purpose
                    if(data.message != null){
                        $('.delete_error_SP_OM').fadeIn();
                        $('.delete_error_SP_OM').html(data.message);
                        setTimeout(function(){
                            $('.delete_error_SP_OM').fadeOut();
                        }, 30000);
                    }
                    //pattadar table details after deletion
                    if(data.success == 'true'){
                        $('#editSecondPattadarOM').modal('hide');
                        var table = '';
                        $.each(data.details, function (i, val) { 
                            table +=                     
                            '<tr>'+
                                '<td>' + ++i + '</td>' +
                                '<td>' + val["pdar_name"] + '</td>' +
                                '<td>' + val["pdar_guardian"] + '</td>' +
                                '<td>' + ((val["pdar_add1"]==null || val["pdar_add1"]=='')?'-':val["pdar_add1"]) + '</td>' +
                                '<td>' + ((val["striked_out"]==1)?'Inplace':'Alongwith') + '</td>' +
                                '<td align="center">' +
                                    '<button type="button" class="btn btn-sm btn-danger btnOMSPdel" id="'+val["pdar_id"]+','+val["dist_code"]+','+val["subdiv_code"]+','+val["cir_code"]+','+val["mouza_pargona_code"]+','+val["lot_no"]+','+val["vill_townprt_code"]+','+val["dag_no"]+','+val["patta_no"]+','+val["patta_type_code"]+','+val["pdar_cron_no"]+'">' +
                                        '<i class="fa fa-trash"></i></button>' +
                                '</td>'+
                            '</tr>'
                        });
                        $('#petitioner_second_party').html(table);
                    }
                    //pattadar dropdwon list after deletion
                    if(data.pattadarList){
                        var template = '<option selected disabled value="">Select Applicant</option>';
                        $.each(data.pattadarList, function (index, val) {
                            template += '<option value='+val["pdar_id"]+'>'+val["pdar_name"]+' </option>'
                        });
                        $('#appl_sec_party_OM').html(template);
                    }
                },
                error:function(data){
                    alert("Something went wrong");
                    $.unblockUI();
                }
            });
        } 
        else {
            return false;
        } 
    });
    ////////////    06-04-22 office mutation second party add & delete ends here   /////////////
</script>
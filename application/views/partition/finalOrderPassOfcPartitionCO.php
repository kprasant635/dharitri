<style type="text/css">
    input[type=text] {
        border: 1px solid #000;
    }
</style>

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

            <div class="panel panel-info">
                <div class="panel-body">
                    <h3>Circle Officer`s Order for Office Partition</h3><br>
                    <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
                        <input type="hidden" name="dist_code" value="<?=$values->dist_code;?>">
                        <input type="hidden" name="subdiv_code"  value="<?=$values->subdiv_code;?>">
                        <input type="hidden" name="circle_code" value="<?=$values->cir_code;?>">
                        <input type="hidden" name="mouza_code" value="<?=$values->mouza_pargona_code;?>">
                        <input type="hidden" name="lot_no" value="<?=$values->lot_no;?>">
                        <input type="hidden" name="vill_code" value="<?=$values->vill_townprt_code;?>">
                        <input type="hidden" name="patta_type" value="<?=$values->patta_type_code?>">
                        <input type="hidden" name="patta_no" value="<?=$values->patta_no?>">
                    </form>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <b style="float:right;background: #fff57f;padding: 4px;">Chitha and Jamabandi Details</b>
                            <br>
                            <div class="col-lg-12">
                                <a style="float:right" target="_blank" href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $values->dag_no. '&m=' . $values->mouza_pargona_code . '&l=' . $values->lot_no. '&v=' . $values->vill_townprt_code . '&p=' . $values->patta_type_code. '&dist=' . $values->dist_code . '&cir=' . $values->cir_code . '&sub_div=' . $values->subdiv_code ?>">
                                <i class="fa fa-link" aria-hidden="true"></i><u><span class="text-primary" style="font-size:16px;">Dag No. <?=$values->dag_no?> (Chitha View)</span></u>
                                </a>
                            </div>
                            <div class="col-lg-12">

                            <button style="float:right" id="seeJamaClick">
                                 <i class="fa fa-link" aria-hidden="true"></i>
                                 <span class="text-primary" style="font-size:16px;color:#ffb81d">Patta No. <?=$values->patta_no?> (Jamabandi View)</span>
                            </button>
                            </div>
                       
                            
                        </div>
                    <form class="form-horizontal" enctype="multipart/form-data" method='post' action="<?=base_url().'index.php/Partition/finalOrderOfcPartitionCO_save'?>">
                        <?php if(ESCALATION_ENABLE == 1){ ?>
                            <input type="hidden" name="executionDate" id="executionDate" value="<?= date('Y-m-d H:i:s'); ?>" />
                        <?php } ?>
                        <?php
                        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))){ ?>                            
                            <!-- property chain data -->
                            <!-- property chain hidden fields -->

                            <input type="hidden" name="ulpinCheckFlag" id="ulpinCheckFlag" value="<?= $ulpinCheck ?>" />
                            <input type="hidden" name="compareCheckFlag" id="compareCheckFlag" value="<?= $chithaPropChainCmpFlag ?>" />
                            <input type="hidden" name="ulpin" id="ulpin" value="<?= $ulpin ?>" />
                            <input type="hidden" name="old_revenue" id="old_revenue" value="<?= $old_revenue ?>" />
                            <input type="hidden" name="old_local_tax" id="old_local_tax" value="<?= $old_local_tax ?>" />
                            <?php if (isset($old_ulpin)) { ?>
                                <input type="hidden" name="old_ulpin" id="old_ulpin" value="<?= $old_ulpin ?>" />
                            <?php } ?>

                        <?php } ?>
                        <?php if(!empty($app->basundhara)){ ?>
                            <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php } ?>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <!----- General Information ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">General Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="10%">Case No:</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=$this->session->userdata('case_no')?>
                                                </span>
                                            </td>
                                            <td width="10%">Submission Date:</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=date('d/m/Y',strtotime($pb->submission_date))?>
                                                    <input type="hidden" class="form-control" readonly="" name="orderDate" value="<?=date('d/m/Y',strtotime($pb->submission_date))?>" >
                                                </span>
                                            </td>       
                                        </tr>
                                        <tr>
                                            <td>Old Patta No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$values->patta_no?>
                                                    <input type="hidden" name="pattaNo" 
                                                    value="<?=$values->patta_no?>" >
                                                </span>
                                            </td>
                                            <td>Old Dag No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$values->dag_no?>
                                                    <input type="hidden" name="dag_no" 
                                                    value="<?=$values->dag_no?>"/>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Land Area:</td>
                                            <td>
                                                 <span class="text-danger">
                                                    <?php
                                                        ////// BARAK VALLEY CODE START ////////////
                                                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                                            echo "B: ".$values->m_dag_area_b.", K: ".$values->m_dag_area_k.", C: ".$values->m_dag_area_lc.", G: ".$values->m_dag_area_g;
                                                        }
                                                        else {
                                                            echo "B: ".$values->m_dag_area_b.", K: ".$values->m_dag_area_k.", L: ".$values->m_dag_area_lc;
                                                        }
                                                        ////// BARAK VALLEY CODE END ////////////
                                                    ?>
                                                </span>
                                                <span class="btnEditDagArea btn btn-primary btn-sm pull-right">Change Area</span>
                                                <input type="hidden" name="LandB" 
                                                value="<?=$values->m_dag_area_b?>">
                                                <input type="hidden" name="LandK" 
                                                value="<?=$values->m_dag_area_k?>">
                                                <input type="hidden" name="LandL" 
                                                value="<?=$values->m_dag_area_lc?>">
                                                <input type="hidden" name="LandG" 
                                                value="<?=$values->m_dag_area_g?>">

                                                <!--////// BARAK VALLEY CODE START ////////////-->
                                                <input type="hidden" name="ChithaLandB" 
                                                value="<?=$values->dag_area_b?>">
                                                <input type="hidden" name="ChithaLandK" 
                                                value="<?=$values->dag_area_k?>">
                                                <input type="hidden" name="ChithaLandL" 
                                                value="<?=$values->dag_area_lc?>">
                                                <input type="hidden" name="ChithaLandG" 
                                                value="<?=$values->dag_area_g?>">
                                                <!--////// BARAK VALLEY CODE END ////////////-->
                                            </td>
                                            <td>Order Type:</td>
                                            <td>
                                                <span class="text-danger">Office Partition</span>
                                                <input type="hidden" class="form-control" 
                                                name="orderType" value='Partition' >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Patta Type:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$this->utilityclass->getPattaName($values->patta_type_code)?>
                                                    <input type="hidden" name="pattaCode" 
                                                    value="<?=$values->patta_type_code?>" >
                                                </span>
                                            </td>
                                            <td>Reference Letter no:</td>
                                            <td>
                                                <input type="text" class="form-control" name="refLtrNo">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Order Primary Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Order Primary Details</th>
                                    </thead>
                                    <tbody>                                        
                                        <tr>
                                            <td width=20%>Mondols Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?=$getSelectedMondalsName->lm_name?>
                                                </span>
                                                <input type="hidden" name="lmName" 
                                                value="<?=$getSelectedMondalsName->lm_code?>">
                                            </td>
                                            <td width=20%>Sign Date:</td>
                                            <td width=20%>
                                                <?=date('d/m/Y', strtotime($lmnote->lm_sign_date))?>
                                                <input type="hidden" value="<?=$lmnote->lm_sign_date?>" 
                                                name="lmSignDate">
                                                <input type="hidden" name="lmSign" value="Y">
                                            </td>
                                        </tr>
                                        <?php if($pb->es_flag == 0)
                                        {
                                            ?>
                                            <tr>
                                            <td width=20%>SK Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?=$getSelectedSKName->username?>
                                                </span>
                                                <input type="hidden" name="skName" 
                                                value="<?=$getSelectedSKName->user_code?>" >
                                            </td>
                                            <td width=20%>Sign Date:</td>
                                            <td width=20%>
                                                <?=date('d/m/Y', strtotime($lmnote->sk_note_date))?>
                                                <input type="hidden" 
                                                value="<?=$lmnote->sk_note_date?>" name="skSignDate">
                                                <input type="hidden" name="skSign" value="Y">
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        
                                        <tr>
                                            <td width=20%>CO Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?=$getSelectedCOName->username?>
                                                </span>
                                                <input type="hidden" name="coName" 
                                                value="<?=$getSelectedCOName->user_code?>">
                                            </td>
                                            <td width=20%>Sign Date:</td>
                                            <td width=20%>
                                                <?=date('d/m/Y')?>
                                                <input type="hidden" 
                                                value="<?=date('d/m/Y')?>" name="coSignDate">
                                                <input type="hidden" name="COSign" value="Y">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Applicant Details ----->
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="9">Applicant Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>#</th>
                                            <th>Applicant Name</th>
                                            <th>Gender</th>
                                            <th>Guardian Name</th>
                                            <th>Relation</th>
                                            <th>Mobile</th>
                                            <th>Address 1</th>
                                            <th>Address 2</th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicant_list">
                                        <?php 
                                            $i=1;
                                            foreach($applicant as $row): 
                                                $mb = $row->pdar_mobile==''?'':$row->pdar_mobile;
                                        ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$row->pdar_name?></td>
                                                <td><?=$this->utilityclass->getGender($row->pdar_gender==null?'M':$row->pdar_gender)?></td>
                                                <td><?=$row->pdar_guardian?></td>
                                                <td>
                                                    <select class="form-control" name="guar_rel[]">
                                                        <option value="<?=$row->pdar_rel_guar?>"><?=$this->utilityclass->get_relation($row->pdar_rel_guar)?></option>
                                                        <?php foreach ($relation as $r) { ?>
                                                            <option value="<?=$r->guard_rel?>"><?=$r->guard_rel_desc_as ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td><?=$mb?></td>
                                                <td>
                                                    <input type="text" name="infavourAdd1[]" 
                                                    value="<?=$row->pdar_add1?>" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="infavourAdd2[]" 
                                                    value="<?=$row->pdar_add2?>" class="form-control">
                                                </td>
                                            </tr>

                                            <input type="hidden" name="infavourOf[]" 
                                            value="<?=$row->pdar_id ?>" >
                                            <input type="hidden" name="inFavourName[]" 
                                            value="<?=$row->pdar_name?>" >
                                            <input type="hidden" name="inFavourGurd[]" 
                                            value="<?=$row->pdar_guardian?>">         
                                            <input type="hidden" name="pdar_cron_no[]" 
                                            value="<?=$row->pdar_cron_no?>">
                                            <input type="hidden" name="inFavourSex[]"
                                            value="<?=$row->pdar_gender?>">
                                            <input type="hidden" name="inFavourMother[]" 
                                            value="<?=$row->pdar_mother?>">
                                            <input type="hidden" name="pdar_mobile[]"
                                            value="<?=$row->pdar_mobile?>">
                                            <input type="hidden" name="pdar_aadhar[]"
                                            value="<?=$row->pdar_aadharno?>">
                                            <input type="hidden" name="pdar_nrc[]"
                                            value="<?=$row->pdar_nrcno?>">
                                            <input type="hidden" name="pdar_pan[]"
                                            value="<?=$row->pdar_pan_no?>">
                                            <input type="hidden" name="pdar_voterID[]"
                                            value="<?=$row->pdar_citizen_no?>">

                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>

                                <!----- Notes ----->
                                <hr><span class="text-success text-bold">Note : New Dag / Patta Number will be wrongly generate if there exist junk dag/patta in the village. So, please check and edit it,if needed.</span>
                                <br><br>
                                <span class="text-red text-bold">Auto Generated Dag Number and Patta Number Should be Verified with the Existing Old Dag and Office Hard Copy Chitha</span><hr>
                                
                                <!----- New Dag Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">New Dag Details</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="10%">
                                                <span class="text-danger">New Dag No</span>
                                            </td>
                                            <td width="20%">
                                                <?php

                                                    $complete = strtolower($pbdata->complete_partition_yn);
                                                    $pdar_strike=0;

                                                    //if complete partition occurs
                                                    if (($complete == 'y')) {
                                                ?>
                                                    <input type="text" class="form-control" name="newDag" readonly value="<?=$values->dag_no?>" >
                                                    <input type="hidden" value="<?=$values->dag_no?>" 
                                                    name="oldDag">
                                                <?php } 
                                                    //if partial partition occurs
                                                    elseif ($complete == 'n') { 
                                                    $pdar_strike='Y';
                                                ?>
                                                    <input type="text" class="form-control" name="newDag" value="<?=$NewDag['dag']?>" >
                                                    <input type="hidden" value="<?=$values->dag_no?>" 
                                                    name="oldDag">
                                                <?php } ?>
                                            </td>

                                            <td width="10%"><span class="text-danger">Check Existing Dags</span></td>
                                            <td width="20%">
                                                <select class="dropdown" 
                                                style="border: 1px solid #000;width: 100%; padding: 2px;">
                                                    <?php foreach ($oldDag as $odag) { ?>
                                                        <option> <?php echo $odag->dag_no ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td width="10%"><span class="text-danger">New Patta No</span></td>
                                            <td width="20%">
                                                <?php if ($plmnote->sugg_pno != null or $plmnote->sugg_pno != '') { ?>
                                                    <input type="text" readonly="" class="form-control" name="newPatta" value="<?=$plmnote->sugg_pno ?>">
                                                <?php } else { ?>
                                                    <input type="text" class="form-control" 
                                                    name="newPatta" value="<?=$NewPatta['patta']?>">
                                                <?php } ?>
                                            </td>

                                            <td width="10%"><span class="text-danger">Check Existing Pattas</span></td>
                                            <td width="20%">
                                                <select class="" 
                                                style="border: 1px solid #000;width: 100%; padding: 2px;">
                                                    <?php foreach ($oldPatta as $odag) { ?>
                                                        <option> <?php echo $odag->patta_no ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%"><span class="text-danger">Revenue in Rs./-<br> (New Dag)</span></td>
                                            <td width="20%">
                                                <input type="text" name="revenue"  class="form-control"  required="" value="<?=number_format($revenue, 2)?>" >
                                                <input type="hidden" value="<?=$revenue?>" name="old_revenue" >
                                            </td>

                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Check this box if Deed Data Exists ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Check this box if Deed Data Exists
                                        &nbsp;<input class="squaredTwo" name="deed_y_n" type="checkbox" value="Yes" id="deed_y_n">
                                        </th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="10%">
                                                <span class="text-danger">Deed No</span>
                                            </td>
                                            <td width="20%">
                                                <input type="text" id="deed_no" class="form-control" 
                                                name="RegDeedNo" disabled style="border: 1px solid #000;">
                                            </td>

                                            <td width="10%">
                                                <span class="text-danger">Deed Value (Rs)</span>
                                            </td>
                                            <td width="20%">
                                                <input type="text" id="deed_value"  class="form-control" name='RegDeedValue' style="border: 1px solid #000;" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">
                                                <span class="text-danger">Registration Date (dd/mm/yyyy)</span>
                                            </td>
                                            <td width="20%">
                                                <input type="text" id='popupDatepicker' class="form-control dating"
                                                name="reg_date" readonly style="border: 1px solid #000;">

                                                <!-- <input type="text" id='popupDatepicker' class="form-control"   
                                                name='reg_date' placeholder="dd/mm/yyyy"
                                                style="border: 1px solid #000" 
                                                maxlength="10" disabled> -->
                                            </td>
                                            <td width="10%">
                                                <span class="text-danger">Sub Registration Office</span>
                                            </td>
                                            <td width="20%">
                                                <input type="text" id="sub_regOffice" 
                                                 style="border: 1px solid #000;"
                                                class="form-control" name='sub_regOffice' disabled>
                                                <input type="hidden" name="pdar_strike" 
                                                value="<?=$pdar_strike?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Check this box if Deed Data Exists ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <tbody>
                                        <tr>
                                            <td width="17%">
                                                <span class="text-danger">Notes</span>
                                            </td>
                                            <td>
                                                <?php
                                                    ////// BARAK VALLEY CODE START ////////////
                                                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                                ?>
                                                    <textarea rows="5" style="border: 1px solid #000" 
                                                    class="form-control" name="notes">লা:ম: / কান্নন গহর রিপোর্ট করেছেন যে খরিদা জমিটি আবেদনকারী দ্বারা দখল করা হয়েছে । তারিখ অনুযায়ী নোটিশ জারি করা হয় এবং নোটিশের সময়কালের মধ্যে কোনও আপত্তি ইত্যাদি পাওয়া যায়নি । সমস্ত তথ্য সঠিক । বাটোবারার শেষ আদেশটি দেওয়া হয়েছিল ।  চক্র বিষয়া
                                                    </textarea>
                                                <?php } else { ?>
                                                    <textarea rows="5" style="border: 1px solid #000" 
                                                    class="form-control" name="notes">লা:ম: / কানন গোহৰ ৰ প্রতিবেদন মতে খৰিদা জমিত আবেদনকাৰীৰ দখল-আবাদ আছে । জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি পোৱা নাই । সকলো তথ্য সঠিক আছে । বাটোবাৰাৰ অন্তিম হুকুম দিয়া হল ।  চক্র বিষয়া
                                                    </textarea>
                                                <?php } ////// BARAK VALLEY CODE END //////////// ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                include(APPPATH."views/common/addMoreDocumentView.php");
                                ?>
                            </div>

                            <!--/////////////upload docs///////////-->



                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-lg-12 text-bold text-red" id="alert_message"></div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <label><u>Upload Additional Document</u></label>
                                    &nbsp;
                    <i class="fa fa-info-circle text-red" 
                    title="1. Uploaded file types should be jpeg|jpg|png|pdf only.
                    2. Uploaded file size should not be more than 4MB"></i>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered">
                    <tbody id='certi_tab'>
                        <input type="hidden" name="case_no" id="case_no" value="<?=$pb->case_no?>">
                        
                        <tr>
                            <td><span class="text-bold"> <input type="text" required="" id="doc1" name="doc1" placeholder="Enter document name"  value="" style="padding:5px 10px"/></span>
                            </td>
                            <td><input type='file' name="doc1_file" id="doc1_file"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadPartDocumentCO" id='1'>Upload &nbsp;<i class='fa fa-upload'></i></button>
                            </td>
                            <td>
                                <?php if(!empty($doc1_id)) { if($doc1_id->id!='' || $doc1_id->id!=null) { ?>
                                <div id="div_death">
                                    <button class="btn btn-sm btn-info" type="button"><a  style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc1_id->id?>" target="_blank">VIEW <?=$doc1_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removePartReportDocumentCO removeDeath" id='1'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_1"></div>
                            </td>
                        </tr>

                        <tr>
                            <td><span class="text-bold"> <input type="text" required="" id="doc2" name="doc2" placeholder="Enter document name"  value="" style="padding:5px 10px" /></span>
                            </td>
                            <td><input type='file' name="doc2_file" id="doc2_file" ></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadPartDocumentCO" id='2'>Upload &nbsp;<i class='fa fa-upload'></i></button>
                               
                            </td>
                            <td>

                                <?php if(!empty($doc2_id)) { if($doc2_id->id!='' || $doc2_id->id!=null) { ?>
                                <div id="div_noc">
                                    <button class="btn btn-sm btn-info" type="button"><a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc2_id->id?>" target="_blank">VIEW <?=$doc2_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removePartReportDocumentCO removeNOC" id='2'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_2"></div>
                            </td>
                        </tr>

                        <tr>
                            <td><span class="text-bold"> <input type="text" required="" id="doc3" name="doc3" placeholder="Enter document name"  value="" style="padding:5px 10px"/></span>
                            </td>
                            <td><input type='file' name="doc3_file" id="doc3_file"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning uploadPartDocumentCO" id='3'>Upload &nbsp;<i class='fa fa-upload'></i></button>
                            </td>
                            <td>
                                <?php if(!empty($doc3_id)) { if($doc3_id->id!='' || $doc3_id->id!=null) { ?>
                                <div id="div_new">
                                    <button class="btn btn-sm btn-info" type="button"><a  style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc3_id->id?>" target="_blank">VIEW <?=$doc3_id->file_name?></a></button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger removePartReportDocumentCO removeDeath" id='3'>Remove&nbsp;<i class='fa fa-minus-square'></i></button>
                                </div>
                                <?php }} ?>
                                <div id="file_3"></div>
                            </td>
                        </tr>

                        

                            </tbody>
                        </table>
                    </div>

         <!----------------->

                             <!-- /////////ESCALATION REMARK///////////// -->
                              <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $pb->es_flag == 1 && $pb->out_of_esc == 0) { ?>
                                <div class="col-lg-12">
                                    <div class="form-group col-md-4 text-right">
                                        <label class="red"> Cause For the case has not been pass in the timeline : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                    </div>
                                </div>
                              <?php } ?>
                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-6" style="background-color:#ffb81d;padding: 24px;box-shadow: 0px 0px 4px #000">
                                <b style="font-size: 19px;color: #cf0606;">Zonal Value for Existing Dag No :  <span style="font-size: 17px;">(<?=$values->dag_no?> )  &nbsp;&nbsp;&nbsp; <kbd> <?=$zonalValueOfDag == null ? "N/A" : $zonalValueOfDag ;?></kbd></span> </b>
                                <hr>
                                <?php
                                if($zonalValueOfDag != null){
                                    echo "<b>NOTE : Same will be updated in new dag after CO Final Order.</b>";
                                }else{
                                    echo "<b>NOTE: No updation will be done against the new dag no.</b>";
                                }
                                ?>
                                
                            </div>
                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;<hr></div>
                            <div class="col-lg-12">
                                <center>
                                    <input type="hidden" name="dist_code" value="<?=$pb->dist_code?>">
                                    <input type="hidden" name="subdiv_code" value="<?=$pb->subdiv_code?>">
                                    <input type="hidden" name="cir_code" value="<?=$pb->cir_code?>">
                                    <input type="hidden" name="mouza_code" 
                                    value="<?=$pb->mouza_pargona_code?>">
                                    <input type="hidden" name="lot_no" value="<?=$pb->lot_no?>">
                                    <input type="hidden" name="vill" value="<?=$pb->vill_townprt_code?>">
                                    <input type="hidden" name="petitionno" value="<?=$pb->petition_no?>">
                                    <input type="hidden" name="appl" value="<?=$pb->case_no?>">

                                    <?php if(($pb->dist_code==$this->session->userdata('dist_code')) && ($pb->subdiv_code==$this->session->userdata('subdiv_code')) && ($pb->cir_code==$this->session->userdata('cir_code'))){?>

                                    <button id='btn-hide' type="submit" name="formsubmit" class="btn btn-primary uni_text"><?php echo $this->lang->line('submit_button'); ?>&nbsp;<i class="fa fa-arrow-circle-o-right"></i></button>
                                <?php }?>
                                    <button class="btn btn-warning" id='backtoLists'><i class="fa fa-arrow-left"></i> Back To Previous Case List(s)</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<!-- SK Modal -->
<div class="modal" id="DagArea" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form method="POST" action="<?php echo base_url(); ?>index.php/partition/saveArea">
                        <table class="table">
                            <thead>
                                <td>Land Area</td>
                                <td>Bigha</td>
                                <td>Katha</td>
                                <?php
                                    ////// BARAK VALLEY CODE START ////////////
                                    if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                ?>
                                    <td>Chatak</td>
                                <?php } else { ?>
                                    <td>Lessa</td>
                                <?php } ////// BARAK VALLEY CODE END //////////// ?>
                                <td>Ganda</td>
                                <td>Kranti</td>
                            </thead>
                            <tbody>
                                <tr>
                                   <td>Total</td>
                                   <td><input type="text" readonly="" name="total_bigha"  value="<?=$oldDagArea->dag_area_b?>"></td> 
                                   <td><input type="text" readonly="" name="total_katha" max="4" value="<?=$oldDagArea->dag_area_k?>"></td> 
                                   <td><input type="text" readonly="" name="total_lessa" value="<?=$oldDagArea->dag_area_lc?>"></td> 
                                   <td><input type="text" readonly="" name="total_gonda" value="<?=$oldDagArea->dag_area_g?>"></td> 
                                   <td><input type="text" readonly="" name="total_kranti" value="<?=$oldDagArea->dag_area_kr?>"></td> 
                                </tr>
                                <tr>
                                   <td>Applied</td>
                                   <td><input type="text" name="edit_bigha"  value="<?=$values->m_dag_area_b?>"></td> 
                                   <td><input type="text" name="edit_katha" max="4" value="<?=$values->m_dag_area_k?>"></td> 
                                   <td><input type="text" name="edit_lessa" value="<?=$values->m_dag_area_lc?>"></td> 
                                   <td><input type="text" name="edit_gonda" value="<?=$values->m_dag_area_g?>"></td> 
                                   <td><input type="text" name="edit_kranti" value="<?=$values->m_dag_area_kr==null?0:$values->m_dag_area_kr?>"></td> 
                                </tr>
                            </tbody>
                        </table>

                        <input type="hidden" name="dist_code" value="<?=$pb->dist_code?>">
                        <input type="hidden" name="subdiv_code" value="<?=$pb->subdiv_code?>">
                        <input type="hidden" name="cir_code" value="<?=$pb->cir_code?>">
                        <input type="hidden" name="mouza_code" 
                        value="<?=$pb->mouza_pargona_code?>">
                        <input type="hidden" name="lot_no" value="<?=$pb->lot_no?>">
                        <input type="hidden" name="vill" value="<?=$pb->vill_townprt_code?>">
                        <input type="hidden" name="petitionno" value="<?=$pb->petition_no?>">
                        <input type="hidden" name="appl" value="<?=$pb->case_no?>">
                        <input type="hidden" name="dag_no" value="<?=$values->dag_no?>">
                        <button type="submit" class="btn btn-sm btn-success">Click Here to Change & Save Area</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default btnMiscCloseLMReport" id="">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">

    $("#deed_y_n").click(function(){        
        if($(this).is(":checked")) {
            $('#deed_no').prop("disabled", false);
            $('#deed_value').prop("disabled", false);
            $('#popupDatepicker').prop("disabled", false);
            $('#sub_regOffice').prop("disabled", false);
        }
        else {
            $('#deed_no').prop("disabled", true);
            $('#deed_value').prop("disabled", true);
            $('#popupDatepicker').prop("disabled", true);
            $('#sub_regOffice').prop("disabled", true);
        }
    });
    //$(".reg_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    $('#btn-hide').click(function(e){
        $('#btn-hide').hide();
    });
    $('#backtoLists').click(function(e){
            e.preventDefault();
            window.location.href=baseurl +'partition/CoPendingSecond';
    });

    // $('input[name=deed_y_n]').change(function (e) {
    //     var status = $('#formOne input[name=deed_y_n]').is(':checked');
    //     if (status) {
    //         $('#deed_no').prop("disabled", false);
    //         $('#deed_value').prop("disabled", false);
    //         $('.reg_date').prop("disabled", false);
    //         $('#sub_regOffice').prop("disabled", false);

    //     } else {
    //         $('#deed_no').prop("disabled", true);
    //         $('#deed_value').prop("disabled", true);
    //         $('.reg_date').prop("disabled", true);
    //         $('#sub_regOffice').prop("disabled", true);

    //     }
    // });

    // //for rejection
    // $(document).on('click','.btnRejectApplication', function(){
    //     $('#rejApplication_modal').modal('show');
    // });
    // $(document).on('click','.btnCloseRejAppl', function(){
    //     $('#rejApplication_modal').modal('hide');
    // });

    //for viewing LM report
    // $(document).on('click','#editSaveArea', function(){
    //     var edit_bigha=$('#edit_bigha').val();
    //     var edit_katha=$('#edit_katha').val();
    //     var edit_lessa=$('#edit_lessa').val();
    //     var edit_gonda=$('#edit_gonda').val();
    //     var edit_kranti=$('#edit_kranti').val();
    //     if(edit_katha>4){
    //         alert("Katha Should be less than 5");
    //         return;
    //     }
    //     if(edit_lessa>20){
    //         alert("Lessa Should be less than 20");
    //         return;
    //     }
    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });
    //     $('#DagArea').modal('show');
    //     $.ajax({
    //         url: baseurl + "partition/areaSaveChange",
    //         type:'POST',
    //         data:{edit_bigha:edit_bigha, edit_katha: edit_katha ,edit_lessa:edit_lessa ,edit_gonda:edit_gonda, edit_kranti:edit_kranti},
    //         dataType:'json',
    //         success: function (data) {
    //             $.unblockUI();
    //             $('#lm_name_corr_report').html('');                
    //             if(data.success == 'true'){
    //                 $('#lm_name_corr_report').html(data.details);
    //             }
    //         }
    //     });
    // });
    // $(document).on('click','.btnMiscCloseLMReport', function(){
    //     $.unblockUI();
    //     $('#lm_report').modal('hide');
    // });

    // //for viewing SK report
    // $(document).on('click','.btnSKReport', function(){
    //     id = $(this).attr('id');
    //     val = id.split(",");
    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });
    //     $('#sk_report').modal('show');
    //     $.ajax({
    //         url: baseurl + "NameCorrection/skNameCorrectionReport",
    //         type:'POST',
    //         data:{case_no:val[0], petition_no: val[1]},
    //         dataType:'json',
    //         success: function (data) {
    //             $.unblockUI();
    //             $('#sk_name_corr_report').html('');                
    //             if(data.success == 'true'){
    //                 $('#sk_name_corr_report').html(data.details);
    //             }
    //         }
    //     });
    // });
    // $(document).on('click','.btnMiscCloseSKReport', function(){
    //     $('#sk_report').modal('hide');
    // });

    // //for Query
    $(document).on('click','.btnEditDagArea', function(e){
        e.preventDefault(e);
        $('#DagArea').modal('show');
    });
    // $(document).on('click','.btnMiscQueryAppl', function(){
    //     $('#query_modal').modal('hide');
    // });

    // $(document).on('click','.btnRevertClose', function(){
    //     $('#revertToLmModal').modal('hide');
    // });

    $("#seeJamaClick").click(function(event){
        $('#seeJama').submit();
    });
</script>

<script type="text/javascript">
     ////////
$('.uploadPartDocumentCO').click(function(){
        $('#alert_message').html('');
        $('#alert_message').hide();
        flag = $(this).attr('id');
    
        var formdata = new FormData();

        if(flag == 1){
            formdata.append("doc1_file", $('#doc1_file')[0].files[0]);
            formdata.append("doc1", $('#doc1').val());
        }
        if(flag == 2){
            formdata.append("doc2_file", $('#doc2_file')[0].files[0]);
            formdata.append("doc2", $('#doc2').val());
        }

        if(flag == 3){
            formdata.append("doc3_file", $('#doc3_file')[0].files[0]);
            formdata.append("doc3", $('#doc3').val());
        }

        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        // formdata.append("dist_code", $('#dist_code').val());

        // console.log(formdata);

        $.ajax({
            url: baseurl + "Partition/uploadSupportiveDocsPart",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                }

                if(data.flag_set == '1'){
                     $('#div_death').html('');
                     $('#file_1').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removePartReportDocumentCO" id="1">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '2'){
                    $('#div_noc').html('');
                    $('#file_2').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removePartReportDocumentCO" id="2">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }

                if(data.flag_set == '3'){
                    $('#div_new').html('');
                    $('#file_3').html('<a class="btn btn-sm btn-info" type="button" style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>'+' '+'<button type="button" class="btn btn-sm btn-danger removePartReportDocumentCO" id="3">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
            
                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);

                    return false;
                }

            },error: function(errors){
                $('#alert_message').html('');
                $('#alert_message').fadeIn();
                if(errors.status == 403){
                    let err_msg = errors.responseJSON.errors;
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">${err_msg}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }else{
                    $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong. Please try again later.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
            }
        });
    });

$(document).on('click','.removePartReportDocumentCO', function(){
        $('#alert_message').html('');
        $('#alert_message').hide();
        flag = $(this).attr('id');

        case_no = $('#case_no').val();
    //     doc1 = $('#doc1').val();
    //     doc2 = $('#doc2').val();
    //    //alert(flag);
    //     data = {flag:flag, case_no:case_no, doc1:doc1, doc2:doc2}

    //     if(flag==1){certificate = 'Document 1';}
    //     if(flag==2){certificate = 'Document 2';}

        data = {flag:flag, case_no:case_no}

        if(flag==1){
            certificate = 'Document 1';
            doc1 = $('#doc1').val();
            data = {...data,  doc1:doc1};
        }
        if(flag==2){
            certificate = 'Document 2';
            doc2 = $('#doc2').val();
            data = {...data,  doc2:doc2};
        }

        if(flag==3){
            certificate = 'Document 3';
            doc3 = $('#doc3').val();
            data = {...data,  doc3:doc3};
        }

        if(confirm("Are you sure to delete " +certificate+ " ?")){

            $.ajax({
                url: baseurl + "Partition/removeSupportiveDocsPart/",
                type: 'POST',
                data: data,
                dataType: "json",

                success: function (data) 
                {
                    console.log(data);
                    if(data.flag == '1'){
                        $('#file_1').html('');
                        $('#div_death').html('');
                    }
                    if(data.flag == '2'){
                        $('#file_2').html('');
                        $('#div_noc').html('');
                    }
                    if(data.flag == '3'){
                        $('#file_3').html('');
                        $('#div_new').html('');
                    }
                },error: function(errors){
                    $('#alert_message').html('');
                    $('#alert_message').fadeIn();
                    if(errors.status == 403){
                        let err_msg = errors.responseJSON.errors;
                        $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">${err_msg}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    }else{
                        $('#alert_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">Something went wrong. Please try again later.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    }
                }
            });
        }  
    });

$(".rejectCO").click(function(event){
              event.preventDefault();
              $("#rejectCO").modal('show');
      });

$(document).on('click','.btnRevertClose', function(){
        $('#rejectCO').modal('hide');
    });

</script>
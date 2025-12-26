<style type="text/css">
    input[type=text] {
        border: 1px solid #000;
    }
</style>

<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">
    <div class="row">
        <?php
        $buttonEnabledFlag =1;
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            include 'application/views/common/input_hidden_fields_and_func.php';
        }
        ?>
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
                    <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
                        <input type="hidden" name="dist_code" value="<?=$details->dist_code;?>">
                        <input type="hidden" name="subdiv_code"  value="<?=$details->subdiv_code;?>">
                        <input type="hidden" name="circle_code" value="<?=$details->cir_code;?>">
                        <input type="hidden" name="mouza_code" value="<?=$details->mouza_pargona_code;?>">
                        <input type="hidden" name="lot_no" value="<?=$details->lot_no;?>">
                        <input type="hidden" name="vill_code" value="<?=$details->vill_townprt_code;?>">
                        <input type="hidden" name="patta_type" value="<?=$dag_details->patta_type_code?>">
                        <input type="hidden" name="patta_no" value="<?=$dag_details->patta_no?>">
                    </form>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                            <b style="float:right;background: #fff57f;padding: 4px;">Chitha and Jamabandi Details</b>
                            <br>
                      
                            <div class="col-lg-12">
                            <a style="float:right"  target="_blank" href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $dag_details->dag_no . '&m=' . $details->mouza_pargona_code . '&l=' . $details->lot_no . '&v=' . $details->vill_townprt_code . '&p=' . $dag_details->patta_type_code . '&dist=' . $details->dist_code . '&cir=' . $details->cir_code . '&sub_div=' . $details->subdiv_code ?>">
                                         <i class="fa fa-link" aria-hidden="true"></i><u><span class="text-primary" style="font-size:16px;">Dag No. <?=$dag_details->dag_no?> (Chitha View)</span></u>
                                      </a>
                            </div>
                            <div class="col-lg-12">
                            <button style="float:right" id="seeJamaClick">
                                 <i class="fa fa-link" aria-hidden="true"></i>
                                 <span class="text-primary" style="font-size:16px;color:#ffb81d">Patta No. <?=$dag_details->patta_no?> (Jamabandi View)</span>
                            </button>
                            </div>
                            
                        </div>


                    <h3>Circle Officer`s Order for Field Partition</h3><br>
                    <form class="form-horizontal" enctype="multipart/form-data" method='post' action="<?=base_url().'index.php/Partition/finalOrderFieldPartitionCOSave'?>">
                        <?php if(ESCALATION_ENABLE == 1){ ?>
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <?php 
                                  include(APPPATH."views/escalation/remaining_time.php");
                            ?>
                        <?php } ?>
                    



                        <?php if(!empty($app->basundhara)){ ?>
                            <input type="hidden" class="form-control" name='application_no' 
                            value="<?= $app->basundhara ?>">
                        <?php } ?>

                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {

                            if($propChainEnableFlag)
                            {
                                include 'application/views/common/propertyCheckDetails.php';

                            }

                        }?>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <!----- General Information ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">General Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15%">Case No:</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=$this->input->get('case_no')?>
                                                    <input type="hidden" name="case_no"
                                                    value="<?=$this->input->get('case_no')?>">
                                                </span>
                                            </td>
                                            <td width="15%">Submission Date:</td>
                                            <td width="20%">
                                                <?=date('d-m-Y')?>
                                            </td>       
                                        </tr>

                                        <tr>
                                            <td>Old Patta No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$dag_details->patta_no?>
                                                    <input type="hidden" name="old_patta"
                                                    value="<?= $dagapply->patta_no?>">
                                                </span>
                                            </td>
                                            <td>Patta Type:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$dag_details->patta_type?>
                                                    <input type="hidden" name="patta_code" 
                                                    value="<?=$dag_details->patta_type_code?>"/>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Old Dag No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$dag_details->dag_no?>
                                                    <input type="hidden" name="old_dag" 
                                                    value="<?= $dagapply->dag_no ?>">
                                                </span>
                                            </td>
                                            <td>Actual Land Area:</td>
                                            <td>

                                                 <?php 
                                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                                              if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?> 
                                                <span class="text-danger">
                                                    B:<?=$dag_details->dag_area_b?>, K:<?=$dag_details->dag_area_k?>, C:<?=$dag_details->dag_area_lc?>, G: <?=$dag_details->dag_area_g?>
                                                </span>
                                            <?php }else{?>
                                                <span class="text-danger">
                                                    B:<?=$dag_details->dag_area_b?>, K:<?=$dag_details->dag_area_k?>, L:<?=$dag_details->dag_area_lc?>
                                                </span>

                                               <?php } ?>
                                                <span class="btnEditDagFieldArea btn btn-primary btn-sm pull-right">Change Area</span>
                                            
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Order Type:</td>
                                            <td>
                                                <span class="text-danger">Field Partition</span>
                                                <input type="hidden" class="form-control" 
                                                name="orderType" value='Partition' >
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Order Primary Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Basic Details</th>
                                    </thead>
                                    <tbody>                                        
                                        <tr>
                                            <td width=15%>Land Records Assistant's Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?php 
                                                        $lms = $this->utilityclass->getDefinedMondalsName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no,$details->lm_code);?>
                                                    <?= $lms->lm_name ?>
                                                </span>
                                                <input type="hidden" value="<?=$details->lm_code?>" name="lm_code"/>
                                            </td>
                                            <td width=15%>Sign Date:</td>
                                            <td width=20%>
                                                <?= date('d-m-Y', strtotime($details->date_entry))?>
                                                <input type="hidden" name="lm_date" 
                                                value ='<?= $details->date_entry ?>'/>
                                                <input type="hidden" name='lm_sign_yn' value="y">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CO Name:</td>
                                            <td>
                                                <?php $coname = $this->utilityclass->getCOCode($details->dist_code, $details->subdiv_code, $details->cir_code,$this->session->userdata('user_code')); ?>
                                                <span class="text-danger"><?= $coname->username ?></span>
                                                <input type="hidden" value="<?= $coname->user_code ?>" name="co_code"/>
                                            </td>
                                            <td>Sign Date:</td>
                                            <td>
                                                <input type="hidden" name="co_ord_date" 
                                                value ='<?= date('d-m-Y') ?>'/>
                                                <?= date('d-m-Y',strtotime(date('d-m-Y'))) ?>
                                                <input type="hidden" name='co_sign_yn' value="y">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Check this box if Deed Data Exists ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <tbody>
                                        <tr>
                                            <td width="21.5%">Land Records Assistant Note:</td>
                                            <td><span class="text-danger"><?= $remark->remark ?></span></td>
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
                                            <th>Guardian Name</th>
                                            <th>Relation</th>
                                            <th>Land Share(B-K-L)</th>
                                            <th>Aadhaar/Pan Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicant_list">
                                        <?php 
                                            $i=1;
                                            foreach($petitioner as $row): 
                                                 if($row->auth_type !=null){
                                                $status = $row->auth_type. " Verified";
                                            }else{
                                                $status = 'N/A';
                                            }
                                        ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$row->pdar_name?></td>
                                                <td><?=$row->pdar_guardian?></td>
                                                <td><?=$this->utilityclass->get_relation($row->pdar_rel_guar)?>
                                                </td>
                                                <?php 
                                        ///// BARAK VALLEY CODE START HERE ////////////////
                                          if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                                                <td><?=$row->pdar_dag_por_b.'-'.$row->pdar_dag_por_k.'-'.$row->pdar_dag_por_lc.'-'.$row->pdar_dag_por_g?></td>
                                                <?php }else{?>
                                                <td><?=$row->pdar_dag_por_b.'-'.$row->pdar_dag_por_k.'-'.$row->pdar_dag_por_lc?></td>
                                                <?php }?>
                                                <td style="color:green"><b><?=$status?></b></td>
                                            </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>

                                <!----- Notes ----->
                                <?php
                                    if (($check[0]->count == '0') && ($land_area_check == '0')) {
                                        echo "<span class='text-red text-bold'>Since All the Pattadars are the Applicants for Partition so the dag no will remain same and patta no will be Changed.</span>";
                                    } else {
                                        echo "<span class='text-red text-bold'>This is a Partial Partition so the dag no and patta no will be Changed.</span>";
                                    }
                                ?><br><br>

                                <!----- Land Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="9">Land Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th width="25%"></th>
                                            <th style="text-align: center">Bigha</th>
                                            <th style="text-align: center">Katha</th>
                                            <th style="text-align: center">Lessa</th>
                                            <th style="text-align: center">Ganda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                                        ///////////// BARAK VALLEY CODE START HERE ////////////////
                                          if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?> 
                                         <tr>
                                            <td class="text-red">Applied Land For Partition</td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_b?>
                                                <input type="hidden" name="bigha_applied" 
                                                value="<?= $dagapply->m_dag_area_b ?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_k?>
                                                <input type="hidden" name="katha_applied" 
                                                value="<?=$dagapply->m_dag_area_k?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_lc?>
                                                <input type="hidden" name="lessa_applied" 
                                                value="<?=$dagapply->m_dag_area_lc?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_g?>
                                                <input type="hidden" name="ganda_applied" 
                                                value="<?=$dagapply->m_dag_area_g?>">
                                            </td>
                                            
                                        </tr>
                                    <?php }else{?>

                                        <tr>
                                            <td class="text-red">Applied Land For Partition</td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_b?>
                                                <input type="hidden" name="bigha_applied" 
                                                value="<?= $dagapply->m_dag_area_b ?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_k?>
                                                <input type="hidden" name="katha_applied" 
                                                value="<?=$dagapply->m_dag_area_k?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_lc?>
                                                <input type="hidden" name="lessa_applied" 
                                                value="<?=$dagapply->m_dag_area_lc?>">
                                            </td>
                                            <td style="text-align: center">0</td>
                                        </tr>
                                    <?php }?>
                                        <tr>
                                            <td class="text-red">Land Description in Chitha</td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_b?>
                                                <input type="hidden" name="bigha" 
                                                value="<?=$areaFromChitha->dag_area_b?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_k?>
                                                <input type="hidden" name="katha" 
                                                value="<?= $areaFromChitha->dag_area_k ?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_lc?>
                                                <input type="hidden" name="lessa" 
                                                value="<?= $areaFromChitha->dag_area_lc ?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_g?>
                                                <input type="hidden" name="ganda" 
                                                value="<?= $areaFromChitha->dag_area_g ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- New Dag Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="9">New Dag Details</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15%">Dag Revenue:</td>
                                            <td width="20%">
                                                <input type="text" class="form-control" 
                                                id="P_land" name="dag_revenue" 
                                                value="<?=($revenue ==null) ? "15" : (( $revenue <= 15 ) ? "15" : $revenue)?>">
                                            </td>
                                            <td width="15%">Dag local tax:</td>
                                            <td width="20%">
                                                <input type="text" class="form-control" 
                                                id="p_loc_tax" name="dag_local_tax" 
                                                value="<?=($local_tax ==null) ? "3.5" : (( $local_tax <= 3.5 ) ? "15" : $local_tax)  ?>">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="15%">Suggested New Dag No:</td>
                                            <td width="20%">
                                                <?php if (($land_area_check == '0')) { ?>
                                                    <input type="text" class="form-control" 
                                                    name="sugg_dag_no" readonly
                                                    value="<?= $dagapply->dag_no ?>">
                                                <?php } else { ?>
                                                    <input type="text" class="form-control" 
                                                    name="sugg_dag_no" value="<?= $new_dag ?>">
                                                <?php } ?>
                                            </td>
                                            <td width="15%">Check Existing Dags:</td>
                                            <td width="20%">
                                                <select style="width:100%">
                                                    <option disabled selected>-- Verify Old Dags --</option>
                                                    <?php foreach ($dags_all as $d): ?>
                                                        <option value="<?= $d->dag_no ?>"><?= $d->dag_no ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="15%">Suggested New Patta No:</td>
                                            <td width="20%">
                                                <input type="text" class="form-control"
                                                name="sugg_patta_no" value="<?= $new_patta ?>">
                                            </td>
                                            <td width="15%">Check Existing Patta:</td>
                                            <td width="20%">
                                                <select style="width: 100%">
                                                    <option disabled selected>-- Verify Old Patta --</option>
                                                    <?php foreach ($patta_all as $p): ?>
                                                        <option value="<?= $p->patta_no ?>"><?= $p->patta_no ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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
                        <input type="hidden" name="case_no" id="case_no" value="<?=$details->case_no?>">
                        
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
                              <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $details->es_flag == 1 && $details->out_of_esc == 0) { ?>
                                <div class="col-lg-12">
                                    <div class="form-group col-md-4 text-right">
                                        <label> Cause For the case has not been pass in the timeline : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                    </div>
                                </div>
                              <?php } ?>
                            <?php
                            if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                            }
                            ?>
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;<hr></div>
                            
                            <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                            <br>                         
                            
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <center class='text-danger text-bold'><b>View Supportive Document</b></center>
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <?php foreach($sup_doc as $doc) { ?>
                                        <tr>
                                            <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                            <td>
                                               <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank" download>Click to View</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>


                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-6" style="background-color:#ffb81d;padding: 24px;box-shadow: 0px 0px 4px #000">
                                <b style="font-size: 19px;color: #cf0606;">Zonal Value for Existing Dag No :  <span style="font-size: 17px;">(<?=$dag_details->dag_no?> )  &nbsp;&nbsp;&nbsp; <kbd> <?=$zonalValueOfDag == null ? "N/A" : $zonalValueOfDag ;?></kbd></span> </b>
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
                            <div class="col-lg-12" style="margin-top: 30px;">
                                <center>
                                    <input type="hidden" name="dist_code" 
                                    value="<?= $dagapply->dist_code ?>">
                                    <input type="hidden" name="cir_code" 
                                    value="<?= $dagapply->cir_code ?>">
                                    <input type="hidden" name="subdiv_code" 
                                    value="<?= $dagapply->subdiv_code ?>">
                                    <input type="hidden" name="mouza_pargona_code" 
                                    value="<?= $dagapply->mouza_pargona_code ?>">
                                    <input type="hidden" name="lot_no"
                                    value="<?= $dagapply->lot_no ?>">
                                    <input type="hidden" name="vill_townprt_code" 
                                    value="<?= $dagapply->vill_townprt_code ?>">


                                    <input type="hidden" name="check_count" 
                                    value='<?=$check_count?>'>
                                    <input type="hidden" name="land_area_check" 
                                    value='<?=$land_area_check?>'>
                                    <?php if($buttonEnabledFlag == 1)
                                    { ?>
                                        <button type="submit" id='formsubmit' class="btn btn-primary uni_text btn-sm"><i class='fa fa-check'></i>&nbsp;Submit</button>
                                    <?php } ?> 
                                    
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
<div class="modal" id="DagFieldArea" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">
                
            </div>
            <div class="modal-body">
            <?php
                    if($this->session->flashdata('query_mdl_message')){
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
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form method="POST" action="<?php echo base_url(); ?>index.php/Partition/saveFieldArea">
                        <table class="table">
                            <thead>
                                <td>Land Area</td>
                                <td>Bigha</td>
                                <td>Katha</td>
                                <td>Lessa</td>
                                <td>Gonda</td>
                                <td>Kranti</td>
                            </thead>
                            <tbody>


                                <tr>
                                    <td>Total</td>
                                    <td><input type="text" readonly="" name="total_bigha"  
                                    value="<?=$areaFromChitha->dag_area_b?>"></td> 
                                    <td><input type="text" readonly="" name="total_katha" max="4" 
                                    value="<?= $areaFromChitha->dag_area_k ?>"></td> 
                                    <td><input type="text" readonly="" name="total_lessa" 
                                    value="<?= $areaFromChitha->dag_area_lc ?>"></td> 
                                    <td><input type="text" readonly="" name="total_gonda" 
                                    value="<?= $areaFromChitha->dag_area_g ?>"></td> 
                                    <td><input type="text" readonly="" name="total_kranti" 
                                    value="<?= $areaFromChitha->dag_area_kr ?>"></td> 
                                </tr>
                                <tr>
                                    <td>Applied</td>
                                    <td><input type="text" name="edit_bigha"  
                                    value="<?= $dagapply->m_dag_area_b ?>"></td> 
                                    <td><input type="text" name="edit_katha" max="4" 
                                    value="<?=$dagapply->m_dag_area_k?>"></td> 
                                    <td><input type="text" name="edit_lessa" 
                                    value="<?=$dagapply->m_dag_area_lc?>"></td> 
                                    <td><input type="text" name="edit_gonda" 
                                    value="<?=$dagapply->m_dag_area_g?>"></td> 
                                    <td><input type="text" name="edit_kranti" 
                                    value="<?=$dagapply->m_dag_area_kr==null?0:$dagapply->m_dag_area_kr?>"></td> 
                                </tr>
                            </tbody>
                        </table>

                        <input type="hidden" name="dist_code" value="<?=$dagapply->dist_code?>">
                        <input type="hidden" name="subdiv_code" value="<?=$dagapply->subdiv_code?>">
                        <input type="hidden" name="cir_code" value="<?=$dagapply->cir_code?>">
                        <input type="hidden" name="mouza_code" 
                        value="<?=$dagapply->mouza_pargona_code?>">
                        <input type="hidden" name="lot_no" value="<?=$dagapply->lot_no?>">
                        <input type="hidden" name="vill" value="<?=$dagapply->vill_townprt_code?>">

                        <input type="hidden" name="caseno" value="<?=$details->case_no?>">
                        <input type="hidden" name="petitionno" value="<?=$details->petition_no?>">
                        <input type="hidden" name="appl" value="<?=$details->case_no?>">
                        <input type="hidden" name="dag_no" value="<?=$dagapply->dag_no?>">
                        
                        <button type="submit" class="btn btn-sm btn-success">Click Here to Change & Save Area</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default btnCloseModal" id="">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#DagFieldArea').modal('show');
    <?php
        }
    ?>
    $(document).on('click','.btnEditDagFieldArea', function(e){
        e.preventDefault(e);
        $('#DagFieldArea').modal('show');
    });
    $(document).on('click', '.btnCloseModal', function(e){
        e.preventDefault(e);
        $('#DagFieldArea').modal('hide');
    });

    $("#seeJamaClick").click(function(event){
        $('#seeJama').submit();
    });
    $('#backtoLists').click(function(e){
        e.preventDefault();
        window.location.href=baseurl +'cofieldmutation/getPendingpartitionCases';
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
<?php $user_code = $location['uc']; ?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
            <?php
            $buttonEnabledFlag =1;
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                include 'application/views/common/input_hidden_fields_and_func.php';
            }
            ?>
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('list_of_plots_of_land_proposed_for_reclassification'); ?> </h2>
                </div>
                <div class="error_container">
                    <?php
                        if($this->session->flashdata('message')){
                    ?>
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                                <?= $this->session->flashdata('message'); ?>
                            </strong>
                        </div>
                    <?php
                        }
                    ?>

                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('land_reclassification'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php  
                        if(ESCALATION_ENABLE == 1)
                        {
                            include(APPPATH."views/escalation/remaining_time.php");
                        }
                                  
                        ?>
                       <?php 
                       if($basundharaApp){
                       //changes done for aadhaar/pan information shown---
                        if(isset($basundharaApp->applicants[0]->auth_type) && $basundharaApp->applicants[0]->auth_type == 'AADHAAR'){
                            $flag = 'AADHAAR Verified <i class="fa fa-check"></i>';
                        }else if(isset($basundharaApp->applicants[0]->auth_type) && $basundharaApp->applicants[0]->auth_type == 'PAN'){
                            $flag = 'PAN Verified <i class="fa fa-check"></i>';
                        }else{
                            $flag = 'N/A';
                        }  
                                     
                         echo '<h2 class="red"><mark>Applicant Information</mark></h2>';
                         ?>
                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  value="<?=$basundharaApp->applicants[0]->name_ass ;?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Guardian Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?=$basundharaApp->applicants[0]->gurdian_name_ass ;?>" readonly>
                            </div>
                        </div><br><br>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Relation</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?=$basundharaApp->applicants[0]->guard_rel_desc_as."(".$basundharaApp->applicants[0]->guard_rel_desc.")";?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label">Mobile</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?=$basundharaApp->applicants[0]->mobile ;?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Aadhaar/PAN Status</label>
                                <div class="col-sm-6">
                                    <b style="color:green"><?=$flag;?></b>
                                </div>
                            </div>
                        <?php 
                        echo "";
                    }
                    ?>
                </div>
                <div class="panel-body">
                    <h2><mark><?php echo $this->lang->line('present_dag_details'); ?></mark></h2>
                    <hr>
                    <form class='form-horizontal' method="post" action="">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  value="<?php echo $Pcases->dag_no; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $Pcases->patta_no; ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $det['patta_type']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $det['old_land_class']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('present_land_revenue'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_revenue, 2); ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo round($Pcases->present_land_localtax, 2); ?>" readonly>
                            </div>
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('total_revenue'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo round($Pcases->present_total_revenue, 2); ?>" readonly>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('year_in_which_the_land_is_used_for_other_purpose'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="<?php echo $Pcases->new_landuse_year; ?>" readonly>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group alert alert-success">
                            <label for="inputEmail3" class="col-sm-4 control-label"><span class="ass-btn" style="line-height: 50px;"><?php echo $this->lang->line('full_part_of_the_dag'); ?><?php echo $this->lang->line('land_area'); ?></span></label>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('bigha'); ?></p>
                                <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_b; ?>" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('katha'); ?></p>
                                <input type="text" class="form-control" value="<?php echo $Pcases->dag_area_k; ?>" readonly>
                            </div>
                            <div class="col-sm-2">
                                <p class="center bold"><?php echo $this->lang->line('lesa'); ?></p>
                                <input type="text" class="form-control" value="<?php echo round($Pcases->dag_area_lc, 2); ?>" readonly>
                            </div>
                                <?php
                                    $dist_code = $this->session->userdata('dist_code');
                                    if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <div class="col-sm-2">
                                    <p class="center bold"><?php echo $this->lang->line('ganda');?></p>
                                    <input type="text" class="form-control" value="<?php echo round($Pcases->dag_area_g, 2); ?>" readonly>
                                </div>
                                <?php }?>
                                
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('proposed_details'); ?></mark></h2>
                        <hr>
                        <?php   
                        $userdesig_code = $this->session->userdata('user_desig_code');
                        if($userdesig_code =='DC'){
                           $form_action= "index.php/LandReclassification/FinalProcessDC";
                           $disabled = '';
                        }else{
                           $disabled = 'disabled';
                           $form_action= "index.php/LandReclassification/FinalProcess";
                       }    
                       ?>
                       <form class='form-horizontal' method="post" action="<?php echo base_url().$form_action ?>">
                        
							<?php if(ESCALATION_ENABLE == 1){ ?>
                                <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            
                            <?php } ?>
                          <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {

                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>

                        <?php if(!empty($app->basundhara)){ ?>
                            <!-- <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>"> -->
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('new_land_class'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $det['proposed_land_class']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_land_revenue'); ?></label>
                            <div class="col-sm-4">
                                <input type="number" name="P_land_rev" id="P_land" class="form-control" value="<?php echo round($Pcases->proposed_land_revenue, 2); ?>" <?= $disabled; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('proposed_local_tax'); ?></label>
                            <div class="col-sm-4">
                                <input type="number" name="p_local_tax" id="p_loc_tax" class="form-control" value="<?php echo round($Pcases->proposed_land_localtax, 2); ?>" readonly <?= $disabled; ?>>
                            </div>                                
                        </div>
                        <div class="form-group hide">
                            <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('revenue_difference'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo round($Pcases->revenue_diff, 2); ?>" readonly>
                            </div>
                        </div>
                        <?php
                        if($basundharaAttachment){
                            echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                            foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                            endforeach; 
                            echo "</ul>";
                        }
                        ?>
                        <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                        <div class="bg bg-primary col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <center class='text-white text-bold'>View Supportive Document</center>
                            <table class="table table-striped table-bordered">
                                <tbody class="text-dark">
                                    <?php foreach($sup_doc as $doc) { ?>
                                    <tr>
                                        <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                        <td>
                        <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?> 
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('circleofficers_recommendation_note'); ?></mark></h2>
                        <hr>
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <?php echo $cormk->co_order; ?>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group hide">
                            <div class="col-sm-12">
                                <!-- <textarea name="co_report" class="form-control" rows="5" readonly> <?php echo $Pcases->co_recommendation; ?></textarea> -->
                                <textarea class="form-control" rows="5" readonly> <?php echo $Pcases->co_recommendation; ?></textarea>
                            </div>
                        </div>
                        <?php 
                        $userdesig_code = $this->session->userdata('user_desig_code');
                        if($userdesig_code =='DC'){
                            $remark_text="Deputy Commissioner";
                            $desig= " উপায়ুক্ত";
                            ?>
                            <h2><mark>NOTE FROM ADC</mark></h2>
                            
                            <div class="form-group">
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <?php echo $lmrmk->co_order; ?>
                                </div>
                            </div>
                            <textarea name="adc_report" class="form-control hide" rows="5" readonly> </textarea>
                        <?php }
                        else{
                            $remark_text="Additional Deputy Commissioner";
                            $desig="অতিৰিক্ত উপায়ুক্ত";
                        }
                        ?>
                        <h2><mark><?=$remark_text?> Recommendation Note</mark></h2>
                        <hr>
                        <!--//#START PLB--->
                        <?php
                        $dist_code = $this->session->userdata('dist_code');
                        if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea name="dc_report" class="form-control" rows="5"> রিপোর্টে মাটির বিভাগে পরিবর্তনের নির্দেশ দেওয়া হয়েছে ।</textarea>
                                <!-- <textarea name="dc_report_suffix" class="form-control hidden" rows="5"><?php echo $location['adc_name'] . ", "; ?><?php echo $desig ; ?></textarea> -->
                                <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                <!-- <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" > -->
                            </div>
                        </div>
                        <?php }else{?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea name="dc_report" class="form-control" rows="5"> প্রতিবেদন মৰ্মে মাটিৰ  শ্ৰেণী পৰিবৰ্ত্তনৰ  বাবে  হুকুম দিয়া হল ।</textarea>
                                <!-- <textarea name="dc_report_suffix" class="form-control hidden" rows="5"><?php echo $location['adc_name'] . ", "; ?><?php echo $desig ; ?></textarea> -->
                                <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                <!-- <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" > -->
                            </div>
                        </div>
                    <?php }?>

                        <!-- /////////ESCALATION REMARK///////////// -->
                        <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $Pcases->es_flag == 1 && $Pcases->out_of_esc == 0) { ?>
                        <div class="col-lg-12">
                            <div class="form-group col-md-4 text-right">
                                <label class="red"> Cause For the case has not been pass in the timeline : </label>
                            </div>
                            <div class="form-group col-md-8">
                                <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                            </div>
                        </div>
                        <?php } ?>
                        <center>
                         <a class="btn btn-info uni_text proreport" href="<?php echo base_url() . "index.php/LandReclassification/proceedingDetails?proposal_no=" . $Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" >
                            <i class="fa fa-paperclip"></i>&nbsp;Click here to Show Proceeding
                        </a></center>

                         <?php if(($flag_co == true || $flag_adc == true) && ESCALATION_ENABLE ==1 && $out_of_esc == 0){ ?>
                            <table>
                                <tr>
                                    <td><b style="color:red;">Warning  : Assign days to CO/ADC for report the Case No. (Maximum <?php echo $day = (int) $remainingDaysDC-1; ?> day)</b></td>
                                    <td>
                                        <select class="form-select" name="allocate_day" >
                                            <?php for ($i=1; $i < $remainingDaysDC; $i++) {  ?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                           <?php  } ?>
                                            
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>


                        <?php $userdesig_code = $this->session->userdata('user_desig_code');
                        if($userdesig_code =='ADC'){?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                        <label for="inputEmail3" class=" control-label " style="color: #990000; top:-10px">Punor Protibedon By Circle Officer</label>
                                        <input type="radio"  name="revarted" value="Y"/>
                                        <label for="inputEmail3" class=" control-label " style="color: #990000; top:-10px">Forward to DC for Final Pass</label>
                                        <input type="radio"  checked name="revarted" value="N"/>
                                    </div>
                                </div>
                            </div>
                            <?php 
                        }
                        $userdesig_code = $this->session->userdata('user_desig_code');
                        if($userdesig_code =='DC'){ ?>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="bs-callout bs-callout-info" style='margin-left:10px' id="callout-type-b-i-elems"> 
                                        <label for="inputEmail3" class=" control-label " style="color: #990000; top:-10px">Revert to Circle Officer</label>
                                        <input type="radio"  name="revarted" value="C"/>
                                        <label for="inputEmail3" class=" control-label " style="color: #990000; top:-10px">Revert to ADC</label>
                                        <input type="radio"   name="revarted" value="A"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                      <label for="inputEmail3" class=" control-label " style="color: #990000; top:-10px">Final Pass</label>
                                      <input type="radio"  checked name="revarted" value="F"/>
                                      <label for="inputEmail3" class=" control-label green" style=" top:-10px">Reject Order</label>
                                      <input type="radio"   name="revarted" value="R"/>
                                  </div>
                              </div>
                          </div>
                      <?php }?>
                            
                            <?php if($buttonEnabledFlag==1){?>
                            <center><input type="submit" class="btn btn-success " name="forwardtodc" value="Submit"></center>
                        <?php }?>
                        </form>

                        <form>
                            <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                            <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                            <?php } ?>
                            <textarea name="dc_report_suffix" class="form-control hidden" rows="5"><?php echo $location['adc_name'] . ", "; ?><?php echo $desig ; ?></textarea>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <center>
                           <?php if($user_code =='DC') {?>
                               <a href="<?php echo base_url() . "index.php/LandReclassification/forwardtoco?proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no."&forwardcofrom_adc=Y"; ?>" class="btn btn-success">
                                   
                                    <i class="fa fa-success"></i>&nbsp;Forward/Revert to CO
                                </a>
                            <?php } ?>
                        </center>
                        <?php if(!empty($app->basundhara)){ ?>
                           <center>
                              
                              <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                              <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=1&proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" class="btn btn-info" target="_blank">
                                <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_chitha');?>
                            </a>
                            <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=1&proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" target="_blank" class="btn btn-info">
                                <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_jamabandi');?>
                            </a>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$Pcases->case_no?>','<?=SERVICE_RECLASSIFICATION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                             
                            <br><br>
                        </center>
                    <?php }
                    else { ?>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=1&proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" class="btn btn-info" target="_blank">
                                    <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_chitha');?>
                                </a>
                                <a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=1&proposal_no=".$Pcases->proposal_no."&case_id=".$Pcases->case_no; ?>" target="_blank" class="btn btn-info">
                                    <i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('show_jamabandi');?>
                                </a>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$Pcases->case_no?>','<?=SERVICE_RECLASSIFICATION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <br><br>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='skmodal'>
    <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
     <button type="button" class="close red" data-dismiss="modal">&times;</button>
     <div class="modal-content"  style=" overflow-y: auto;">
     </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Click here to Close</button>
    </div>
</div>
</div>

<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
             <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
             <div class="modal-body">
                <?php
                    if($this->session->flashdata('query_mdl_message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('query_mdl_message'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
                <textarea name='query' class="form-control" placeholder="Please enter your query"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
   $(function () {
    $('.proreport').on('click',function (e) {
        e.preventDefault();
        console.log($(this));
        $.ajax({
            url:$(this).attr('href'),
            success:function(data){
                $('#skmodal .modal-content').html(data);
                $('#skmodal').modal('show');
            }
        });
    });
    $('#skmodal').on('hidden.bs.modal', function () {
        $('body').css('padding-right',0);
    })

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
});
</script>   

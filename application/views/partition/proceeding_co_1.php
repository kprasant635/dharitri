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
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">চক্র বিষয়াৰ হুকুম</h2>
                </div>
                <?php
                    if($this->session->flashdata('message')){
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
            </div>
            <div class="col-lg-10 col-lg-offset-1">
               
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid">গোচৰ নং : <?php echo $petition->case_no; ?></label>
                            <label class="col-sm-4 rasid">হুকুম  ক্রমিক নং : 1 </label>
                            <label class="col-sm-4 rasid">তাং : <?php echo date('d-m-Y', strtotime($petition->date_entry)); ?></label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="unicode" action="<?php echo base_url() . "index.php/partition/savePartionCO1" ?>" method="POST"  > 
                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {
                            if($propChainEnableFlag)
                            {
                                include 'application/views/common/propertyCheckDetails.php';
                            }
                        }?>   
                        <?php if(ESCALATION_ENABLE == 1){?>
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>"> 
                            <?php 
                                include(APPPATH."views/escalation/remaining_time.php");
                            ?>

                        <?php } ?> 
                         
                        
                        <?php  if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ ?>          
                            <div class='panel-body'>
                                <?php
                                $dist_code = $this->session->userdata('dist_code');
                                $subdiv_code = $this->session->userdata('subdiv_code');
                                $cir_code = $this->session->userdata('cir_code');
                                $user = $this->session->userdata('user_code');
                                //var_dump($location);
                                $coname = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user);
                                ?>
                                <p class='uni_text'>
                                    আবেদনকারীর বাটোৱারা  র আবেদন দেখা হইল । আবেদনকারী  <span class="green"> <?php echo $location['mouza'] ?></span> পরগণার <span class="green"><?php echo $location['vill'] ?> </span> গ্রামের

                                    <span class="green"> <?php echo $this->utilityclass->cassnum($dags[0]->patta_no) . " নং পাট্টার" ?> 
                                        <?php echo $this->utilityclass->cassnum($dags[0]->dag_no) ?> নং দাগের   <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_k) ?> কঠা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_lc) ?> লেছা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_g) ?> গণ্ডা
                                    </span>
                                    ভূমিতে বাটোয়ারার প্রার্থনা করিয়াছেন |
                                    <br>
                                    ভূমিলেখ্য সহায়ক এবং  ভূমিলেখ্য পৰ্যবেক্ষক  সরজমিন  মাপজোখ করিয়া খরচের রসিদ, ট্রেস ম্যাপ, চিঠা এবং জমাবন্দী কপিসহ প্র-পত্রমতে  দখল ও বিবাদ সম্পর্কে সম্পূর্ণ প্রতিবেদন দাখিল করিবেন  |

                                    <input type="hidden" name="COorder" value=" আবেদনকারীর বাটোৱারা  র আবেদন দেখা হইল । আবেদনকারী <?php echo $location['mouza'] ?> পরগণার <?php echo $location['vill'] ?>  গ্রামের  <?php echo $this->utilityclass->cassnum($dags[0]->patta_no) . " পাট্টার " ?>
                                           <?php echo $this->utilityclass->cassnum($dags[0]->dag_no) ?> দাগর  <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_k) ?> কঠা  <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_lc) ?> লেছা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_g) ?> গণ্ডা
                                           ভূমিতে বাটোয়ারার প্রার্থনা করিয়াছেন |ভূমিলেখ্য সহায়ক এবং ভূমিলেখ্য পৰ্যবেক্ষক সরজমিন মাপজোখ করিয়া খরচের রসিদ,ট্রেস ম্যাপ,চিঠা এবং জমাবন্দী কপিসহ প্র-পত্রমতে দখল ও বিবাদ সম্পর্কে সম্পূর্ণ প্রতিবেদন দাখিল করিবেন |
                                           সহায়কে রাজস্ব আইনের ৯৯ নং ধারা অনুযায়ী সকল সহ-পট্টাদারকে সাক্ষ্য এবং আপত্তি দাখিলের জন্য জারীকারকদ্বারা নোটিশ জারীর ব্যৱস্থা করিবেন |
                                           পরবর্ত্তী তারিখ dateName শুনানি এবং আপত্তি দাখিলের জন্য ধার্য্য করা হইল | <?php echo "\r \n \n" . "<br><span class='pull-right'>" . $coname->username . "<br>" . "চক্র বিষয়া ," . $location['cir'] . "</span>"; ?>
                                           " />
                                </p>
                                <hr>
                                <p class="uni_text">
                                    সহায়কে রাজস্ব আইনের ৯৯ নং ধারা অনুযায়ী সকল সহ-পট্টাদারকে সাক্ষ্য এবং আপত্তি দাখিলের জন্য জারীকারকদ্বারা নোটিশ জারীর ব্যৱস্থা করিবেন |
                                    পরবর্ত্তী তারিখ <input type="text" name="next_date" required  id="enable_next_date" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >  শুনানি এবং আপত্তি দাখিলের জন্য ধার্য্য করা হইল |
                                </p>
                                <p class="pull-right uni_text">
                                    <?php echo $coname->username; ?><br>
                                    চক্র আধিকারিক ,
                                    <?php echo $location['cir'] ?>
                                </p>
                                <hr style="border-bottom: 2px solid #000;">
                                <label class="radio-inline uni-text col-lg-offset-3">
                                    <input type="radio" name="next_hearing" disabled=""  value="F"> অন্তিম হকুম দেন
                                </label>
                                <!-- <label class="radio-inline uni-text">
                                    <input type="radio" name="next_hearing"  value="D"> মামলা খারিজ করুণ
                                </label> -->
                                <label class="radio-inline uni-text">
                                    <input type="radio" name="next_hearing"  value="P" checked=""> শুনানি জারি রাখুণ
                                </label>
                            </div>
                            <?php } else{?>
                            <div class='panel-body'>
                                <?php
                                $dist_code = $this->session->userdata('dist_code');
                                $subdiv_code = $this->session->userdata('subdiv_code');
                                $cir_code = $this->session->userdata('cir_code');
                                $user = $this->session->userdata('user_code');
                                //var_dump($location);
                                $coname = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user);
                                ?>
                                <p class='uni_text'>
                                    আবেদনকাৰীৰ বাটোৱাৰা  ৰ আৱেদন চোৱা হ'ল । আবেদনকাৰীয়ে  <span class="green"> <?php echo $location['mouza'] ?></span> মৌজাৰ <span class="green"><?php echo $location['vill'] ?> </span> গাৱৰ 

                                    <span class="green"> <?php echo $this->utilityclass->cassnum($dags[0]->patta_no) . " নং পট্টাৰ" ?> 
                                        <?php echo $this->utilityclass->cassnum($dags[0]->dag_no) ?> নং দাগৰ   <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_k) ?> কঠা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_lc) ?> লেছা 
                                    </span>
                                    'ৰ মাটিৰ বাটোৱাৰা বিচাৰিছে |
                                    <br>
                                    ভূমিলেখ্য সহায়ক আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি ব্যয় প্রাক্ কলনসহ ট্রেচ মেপ ,চিঠা আৰু জমাবন্দীৰ এক কপিকৈ প্র-পত্রমতে দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব  |

                                    
<input type="hidden" name="COorder" value="আবেদনকাৰীৰ বাটোৱাৰা ৰ আৱেদন চোৱা হ'ল। আবেদনকাৰীয়ে <?php echo $location['mouza'] ?> মৌজাৰ <?php echo $location['vill'] ?> গাৱৰ <?php echo $this->utilityclass->cassnum($dags[0]->patta_no) . " পট্টাৰ " ?><?php echo $this->utilityclass->cassnum($dags[0]->dag_no) ?> দাগৰ <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_b) ?> বিঘা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_k) ?> কঠা <?php echo $this->utilityclass->cassnum($dags[0]->m_dag_area_lc) ?> লেছামাটিৰ বাটোৱাৰা বিচাৰিছে| ভূমিলেখ্য সহায়ক আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি ব্যয় প্রাক্ কলনসহ ট্রেচ মেপ ,চিঠা আৰু জমাবন্দীৰ এক কপিকৈ প্র-পত্রমতে দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব পাৰে | সহায়কে ৰাজহ আইনৰ ৯৯ নং ধাৰা অনুযায়ী সকলো সহ-পট্টাদাৰাকে সাক্ষ্য আৰু আপত্তি দাখিলৰ বাবে জাৰীকাৰকদ্বাৰা জাননী দিয়াৰ ব্যৱস্থা কৰিব |পৰবৰ্তী তাৰিখ dateName শুনানি আৰু আপট্তি দাখিলৰ বাবে ধাৰ্য্য কৰা হল | <?php echo $coname->username ." চক্র বিষয়া ," . $location['cir']; ?>" />

                                </p>
                                <hr>
                                <p class="uni_text">
                                    সহায়কে ৰাজহ আইনৰ ৯৯ নং ধাৰা অনুযায়ী সকলো সহ-পট্টাদাৰাকে সাক্ষ্য আৰু আপত্তি দাখিলৰ বাবে জাৰীকাৰকদ্বাৰা জাননী দিয়াৰ ব্যৱস্থা কৰিব |
                                    পৰবৰ্তী তাৰিখ <input type="text" name="next_date" autocomplete="off" required  id="enable_next_date" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >  শুনানি আৰু আপত্তি  দাখিলৰ বাবে ধাৰ্য্য কৰা হল |
                                </p>
                                <p class="pull-right uni_text">
                                    <?php echo $coname->username; ?><br>
                                    চক্র বিষয়া ,
                                    <?php echo $location['cir'] ?>
                                </p>
                                <hr style="border-bottom: 2px solid #000;">
                                <label class="radio-inline uni-text col-lg-offset-3">
                                    <input type="radio" name="next_hearing" disabled=""  value="F"> অন্তিম হকুম দিয়ক 
                                </label>
                                <!-- <label class="radio-inline uni-text">
                                    <input type="radio" name="next_hearing"  value="D"> গোচৰ খাৰিজ কৰক 
                                </label> -->
                                <label class="radio-inline uni-text">
                                    <input type="radio" name="next_hearing"  value="P" checked=""> শুনানি জাৰি ৰাখক 
                                </label>
                            </div>


                        <?php }?>


							
							<?php
								if($attachment){
								echo '<h2 class="red">Other Attachments</h2>';
								
								foreach ($attachment  as $attachment):
								//var_dump($attachment);
								?>
								<h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $petition->application_ref_no .'&type='. 2 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
								<?php 
								endforeach; 
								}
							?>
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
							<?php if($basuCase){ ?>
                            <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                            <?php } ?>
                            <?php
                             if($query){
                          echo "<center class='uni_text text-danger'>All Query</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                          foreach($query as $q){
                            ?>
                              <tr>
                                <td><?=$q->date_of_query?></td>
                                <td><?=$q->query_text?></td>
                                <td><?=$q->date_of_reply?></td>
                                <td><?=$q->reply_text;
                                  if($q->app_doc_id){ 
                                    echo "<br>";
                                    echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                        <!-- /////////ESCALATION REMARK///////////// -->
                      <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $petition->es_flag == 1  && $petition->out_of_esc == 0) { ?>
                        <div class="col-lg-12">
                            <div class="form-group col-md-4 text-right">
                                <label class="red"> Cause For the case has not been pass in the timeline : </label>
                            </div>
                            <div class="form-group col-md-8">
                                <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                            </div>
                        </div>
                      <?php } ?>
							
							
                            <div class="panel-footer center">
                                <div class="btn btn-info uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>

                                <?php if ($buttonEnabledFlag == 1) { ?>
                                <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                                <?php } ?>
                                <input type="hidden" name="petition_no" value="<?php echo $petition->petition_no ?>" >
                                <input type="hidden" name="case_no" value="<?php echo $petition->case_no ?>" >
           <!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <div class="btn btn-primary uni_text" data-toggle="modal" data-target="#myModalApplicant" ><i class="fa fa-check-square-o "></i> &nbsp; <?php echo $this->lang->line('see_application_rpt'); ?></div>
                                <div class="btn btn-success uni_text " disabled="disabled" ><i class="fa fa-unlock-alt "></i> &nbsp;<?php echo $this->lang->line('see_byayprak_rpt'); ?></div>
                                <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$petition->case_no?>','<?=SERVICE_OFFICE_PARTITION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <div class="btn btn-info uni_text" disabled="disabled" ><i class="fa fa-unlock-alt "></i> &nbsp;<?php echo $this->lang->line('see_mondal_rpt'); ?></div>
                                <div class="btn btn-dange uni_text" disabled="disabled" ><i class="fa fa-unlock-alt "></i> &nbsp; <?php echo $this->lang->line('see_copattadar_rpt'); ?></div>
                                <div class="btn btn-active uni_text" disabled="disabled" ><i class="fa fa-unlock-alt "></i> &nbsp; <?php echo $this->lang->line('see_asstt_rpt'); ?></div>
                                <!--<div class="btn btn-default uni_text" disabled="disabled" ><i class="fa fa-unlock-alt "></i> &nbsp; <?php echo $this->lang->line('see_sk_rpt'); ?></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="myModalApplicant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('case_no'); ?> : <?php echo $this->session->userdata('case_no') ?></h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <div class="form_1" >
                        <fieldset><legend><?php echo $this->lang->line('partion_applicant_dtls'); ?> </legend>
                            <table class="table_border">
                                <tr>
                                    <td><?php echo $this->lang->line('district'); ?>  : <?php echo $location['dist']; ?> </td>
                                    <td> <?php echo $this->lang->line('subdivision'); ?>  : <?php echo $location['sub']; ?></td>
                                    <td> <?php echo $this->lang->line('circle'); ?>  : <?php echo $location['cir']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('mouza'); ?>    : <?php echo $location['mouza']; ?></td>
                                    <td> <?php echo $this->lang->line('lot_no'); ?>   : <?php echo $location['lot']; ?></td>
                                    <td><?php echo $this->lang->line('vill_town'); ?>   :<?php echo $location['vill']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('date_applied'); ?> : <?php
                                        echo date('d-m-Y', strtotime($petition->submission_date));
                                        //echo "$date";
                                        ?></td><td><?php echo $this->lang->line('type') ?> : বাটোৱাৰা 
                                        <?php
                                        if ($petition->complete_partition_yn == 'Y') {
                                            echo "( সম্পূৰ্ণ )";
                                        } else {
                                            echo "( অসম্পূৰ্ণ )";
                                        }
                                        ?> </td>
                                    <td> <?php echo $this->lang->line('user_designation'); ?> : চক্র বিষয়া</td>
                                </tr>

                            </table>  

                        </fieldset>
                    </div>
                    <?php if(ESCALATION_ENABLE ==1 ){

                            $params = [
                              'case_no'          => $this->session->userdata('case_no'),
                              'service_code'     => 3,
                              'remarks'          => 'Office Partition',
                              'accessed_entity'  => 'Aadhaar Name, Photo',
                            ];
                            // $this->load->model('EkycLogModel');
                            $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);

                            include(APPPATH."views/correction/aadhaarInfo.php");
                        } ?>
                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dag_dtls'); ?></legend>
                            <table class="table table-bordered">
                                <tr>
                                    <th><?php echo $this->lang->line('dag_no'); ?></th><th><?php echo $this->lang->line('applicant_portion'); ?> (B - K - L)</th>
                                    <th><?php echo $this->lang->line('revenue'); ?>  (Rs/-) </th><th><?php echo $this->lang->line('patta_no') ?> </th>
                                    <th><?php echo $this->lang->line('patta_type'); ?>  </th>
                                </tr>
                                <tr class="text-center">
                                    <?php foreach ($dags as $d): ?>
                                        <td><?php echo $d->dag_no; ?></td><td> <?php echo $d->m_dag_area_b; ?>-<?php echo $d->m_dag_area_k; ?>-<?php echo $d->m_dag_area_lc; ?> </td>
                                        <td><?php echo number_format($d->revenue, 2); ?></td><td><?php echo $d->patta_no; ?></td>
                                        <td>
                                            <?php echo $this->utilityclass->getPattaName($d->patta_type_code); ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            </table>  
                        </fieldset>
                    </div>

                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dtls'); ?></legend>
                            <div class="col-lg-12">
                                <?php
                                $count = 1;
                                foreach ($PetiPart as $p):
                                    ?>
                                    <p class="uni_text">(<?php echo $count++; ?>)<?php echo $this->lang->line('applicant_name') ?>  : <?php echo $p->pdar_name; ?></p>
                                    <table class="table_border unicode " >
                                        <tr><td><?php echo $this->lang->line('guardian_name'); ?>  : <?php echo $p->pdar_guardian; ?></td><td><?php echo $this->lang->line('relation') ?>  : <?php echo $this->utilityclass->get_relation($p->pdar_rel_guar); ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('address1') ?> : <?php echo $p->pdar_add1; ?> </td><td><?php echo $this->lang->line('address2') ?> : <?php echo $p->pdar_add2; ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('mobile_no') ?> : <?php echo $p->pdar_mobile; ?> </td><td><?php echo $this->lang->line('voter_id') ?> : <?php echo $p->pdar_citizen_no; ?></td></tr>
                                        <tr class='hide'><td><?php echo $this->lang->line('remaing_land_exist_not') ?>  ::
                                                <?php
                                                if ($p->is_converted_pattadar == 'N') {
                                                    echo "নাথাকে";
                                                } else {
                                                    echo "থাকিব";
                                                }
                                                ?>
                                            </td><td></td></tr>
                                    </table>
                                <?php endforeach; ?>    
                            </div> 
                        </fieldset>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
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
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
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
<script>
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
    $('#BackHome').click(function () {
        location.href = "<?php echo base_url(); ?>index.php/home";
    });
    var dateToday = new Date();
    $(function () {
        $("#ddmmyy").datepicker({
            numberOfMonths: 3,
            showButtonPanel: true,
            minDate: dateToday
        });
    });
</script>
<?php
   $guard = "";
   $count = 1;
   foreach ($pattadar as $p):
       ?>
<p class='regular uni_text'><?php $count++ . ") <span class='text-danger'>" . $p->pdar_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->pdar_rel_guar) . " : " . $p->pdar_guardian; ?></p>
<?php
   $sellername = $p->pdar_name;
   $seller_father = $p->pdar_guardian;
   $seller_relation = $this->utilityclass->get_relation($p->pdar_rel_guar);
   endforeach;
   ?>
<?php
   $hide=null;
   $guard = "";
   $count = 1;
   $appname = "";
   foreach ($petitioner as $p):
       ?>
<p class='regular uni_text'><?php
   $count++ . ") <span class='text-danger'>" . $p->pet_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->guard_rel) . " : " . $p->guard_name;
   $appname .=$p->pet_name . ",";
   $appname_father = $p->guard_name;
   $app_relation = $this->utilityclass->get_relation($p->guard_rel);
   ?></p>
<?php
   endforeach;
   $appname = rtrim($appname, ",");
   ?>
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
         <div class="col-lg-12 ">
            <div class="well well-sm">
               <h2 style="text-align: center;">Circle Officer's Office Mutation Order</h2>
               <?php if($this->session->flashdata('message')){?>
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
               <?php } ?>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                  <h3 class="panel-title">
                     <input type='hidden' id='case_no' value='<?=$case_no?>' />
                     <label class="col-sm-5 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?></label>
                     <label class="col-sm-2 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "2"; ?></label>
                     <label class="col-sm-5 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                     <br>
                  </h3>
               </div>
               <div class="panel-body">
                  <div class='row regular'>
                     <div class='col-lg-6' >
                        <p class="bold uni_text"><?php echo $this->lang->line('first_party') ?></p>
                        <?php
                           $guard = "";
                           $count = 1;
                           foreach ($petitioner as $p):
                           ?>
                           <!-- <p class='regular uni_text'> -->
                              <p class=''>
                        <?php echo $count++ . ") <span class='text-danger'>" . $p->pet_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->guard_rel) . " : " . $p->guard_name; ?>
                           
                        <b><?=isset($p->child_of)?" <span style='color:red'> [ NoK of ".$p->child_of." ] </span>" : null?></b>

                        </p>
                        <?php endforeach; ?>
                     </div>
                     <?php
                        //var_dump($petition_basic);
                        // $coname = $this->utilityclass->getSelectedCOName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $this->session->userdata('user_code'));
                        // //var_dump($coname);
                        // if ($petition_basic->trans_code == 03) {
                        //     $message = "আবেদনকাৰীয়ে হাজিৰ দাখিল কৰিছে আৰু গোচৰ উপস্থাপিত হৈছে |"
                        //             . "আবেদনকাৰী " . " $appname " . "য়ে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ "
                        //             . "$dag->dag_no নং দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . " মাটিত খ:দ: সূত্ৰে নামজাৰী বিচাৰিছে | "
                        //             . "জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি পোৱা নাই | "
                        //             . "আবেদনকাৰীয়ে দাখিল কৰা " . date('d/m/Y', strtotime($petition_basic->date_entry)) . " ইং তাৰিখৰ $petition_basic->deed_no  নং ৰে: দলিল চোবা হ’ল | "
                        //             . "উত্ত দলিল যোগে আবেদনকাৰীয়ে  " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ $dag->dag_no নং "
                        //             . "দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "  মাটি পট্টাদাৰ $sellername পৰা খৰিদ কৰে | লা:ম: ৰ প্রতিবেদন মতে খৰিদা জমিত আবেদনকাৰীৰ দখল-আবাদ আছে | "
                        //             . "সেয়েহে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ $dag->dag_no নং দাগৰ অংশ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "  মাটিত খৰিদা "
                        //             . "দখল সূত্ৰে পট্টাদাৰ  $sellername ৰ লগত আবেদনকাৰী  $appname ৰ নামজাৰী মঞ্জুৰ কৰা হ’ল |";
                            
                        // } elseif ($petition_basic->trans_code == 01) {
                        //     $message = " আবেদনকাৰীয়ে হাজিৰ দাখিল কৰিছে আৰু গোচৰ উপস্থাপিত হৈছে | "
                        //             . "আবেদনকাৰী " . " $appname " . "য়ে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ  "
                        //             . "$dag->dag_no নং দাগৰ মৃত পট্টাদাৰ   $sellername    স্থলত উত্তৰাধিকাৰী সূত্ৰে নামজাৰী বিচাৰিছে  | "
                        //             . " জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি অহা নাই  |  আবেদনকাৰীয়ে দাখিল কৰা মৃত্যুৰ প্রমাণ পত্ৰ , গাও৺ বুঢ়াৰ প্রমাণ পত্ৰ ,শপত নামা আৰু সংশ্লিস্ট লা:ম: ৰ প্রতিবেদন চোবা হ’ল |  "
                        //             . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " মৌজাৰ অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ পট্টাদাৰ  $appname $app_relation $appname_father"
                        //             . " ৰ ইতিমধ্যে মৃত্যু হৈছে আৰু আবেদনকাৰীজন মৃত পট্টাদাৰৰ প্রকৃত উওৰাধিকাৰী হয় | "
                        //             . "সেয়েহে " . $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code) . " অন্তৰ্গত " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) . " ৰ খে: ম্যাদী $dag->patta_no নং পট্টাৰ $dag->dag_no নং দাগৰ মৃত পট্টাদাৰ স্থলত উ:দ: দখল সূত্ৰে আবেদনকাৰী "
                        //             . "$appname ৰ নামজাৰী মঞ্জুৰ কৰা হ’ল |";
                        // } else {
                        //     $message = "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল । আবেদনকাৰীয়ে " .
                        //             $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                        //             . " " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                        //             " গাৱৰ " . $dag->patta_no . " নং পট্টাৰ " . $dag->dag_no . " নং দাগৰ " . $dag->m_dag_area_b . " (বিঘা) " . $dag->m_dag_area_k . " (কঠা) " . $dag->m_dag_area_lc . " (লেছা) " . "মাটিৰ নামজাৰী বিচাৰিছে |"
                        //             . "লাট মণ্ডল আৰু চু:কা: ই চৰজমিন জোখ মাখ কৰি চিঠা আৰু জমাবন্দীৰ এক কপিকৈ প্র-পত্রমতে দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিছে | জাননী ৰীতিমতে জাৰি হয় আৰু জাননী জাৰিৰ ম্যাদৰ ভিতৰত কোনো আপত্তি আদি অহা নাই  | নামজাৰী মঞ্জুৰ কৰা হ’ল | ";
                        // }
                        ?>
                     <div class='col-lg-6'>
                        <p class="bold uni_text"><?php echo $this->lang->line('second_party') ?></p>
                        <?php
                           $guard = "";
                           $count = 1;
                           foreach ($pattadar as $p):
                           ?>
                        <p class='regular uni_text'><?php echo $count++ . ") <span class='text-danger'>" . $p->pdar_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->pdar_rel_guar) . " : " . $p->pdar_guardian; ?><br></p>
                        <?php endforeach; ?>
                     </div>
                  </div>
                  <hr style="border-bottom: 2px solid #000;">
                  <div class="col-lg-12 center">
                     <div class="form-group" style="text-align: center">
                        <a class="btn btn-primary uni_text petitionreport" href="<?php echo base_url() . "index.php/officemutation/viewPetition?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View Application</a>
                        <a class="btn btn-info uni_text lmreportmut"  href="<?php echo base_url() . "index.php/officemutation/lmreport?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View LM Report</a>
                        <a class="btn btn-success uni_text astreport"  href="<?php echo base_url() . "index.php/officemutation/asstReport1?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View Assistant Report</a>
                        <a class="btn btn-danger uni_text skreport"  href="<?php echo base_url() . "index.php/officemutation/skreport1?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View SK Report</a>
                     </div>
                  </div>
                  <hr style="border-bottom: 2px solid #000;">
                  <?php $action = base_url() . "index.php/coofficemutation/proceedingForMultigenerationEscalation"; ?>
                  <form class='form-horizontal' action="<?php echo $action; ?>" method="post">


                     <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                           {
                             if($propChainEnableFlag)
                              {
                                include 'application/views/common/propertyCheckDetails.php';
                              }

                           }?>


                            
                     <table class='table table-striped table-bordered unicode ' style="font-size: 20px;">
                        <tr>
                           <td colspan="2">
                              <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
                              <input type="hidden" class="form-control" name="dist_code" value="<?php echo $petition_basic->dist_code; ?>" readonly>
                              <input type="hidden" class="form-control" name="subdiv_code" value="<?php echo $petition_basic->subdiv_code; ?>" readonly>
                              <input type="hidden" class="form-control" name="cir_code" value="<?php echo $petition_basic->cir_code; ?>" readonly>
                              <input type="hidden" class="form-control" name="mouza_pargona_code" value="<?php echo $petition_basic->mouza_pargona_code; ?>" readonly>
                              <input type="hidden" class="form-control" name="lot_no" value="<?php echo $petition_basic->lot_no; ?>" readonly>
                              <input type="hidden" class="form-control" name="vill_townprt_code" value="<?php echo $petition_basic->vill_townprt_code; ?>" readonly>
                              <div id="textarea">
                                 <textarea class='form-control' cols="10" rows="10" name='co_order' placeholder="Enter Remarks (if any)........."></textarea>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="2">
                              <label for="inputEmail3" class="col-sm-3 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('next_date_of_hearing') ?></label>
                              <div class="col-sm-4">
                                 <input type="text" autocomplete="off" required="" class="form-control" placeholder='dd/mm/yyyy' name="next_hearing_date" id="popupDatepicker">
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="2">
                              <div class="col-lg-6 alert alert-warning" style="margin: 0 auto;float: none;text-align: center">
                                 <label class="control-label">    
                                    <input type="checkbox" id="inlineCheckbox1" name='reissue_notice' value="y">
                                    <span style="color:#000000"><?php echo $this->lang->line('reissue_notice'); ?></span> 
                                 </label>
                                 <label class="control-label">    
                                    <input type="checkbox" id="inlineCheckbox2" name='lm_petition_re' value="y">
                                    <span style="color:#000000"><?php echo "Submit Report Afresh"; ?></span>
                                 </label>
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="2" style="text-align: center;">
                              <div class="col-lg-8 alert alert-success" style="margin: 0 auto;float: none;text-align: center">
                                 <input type="radio" checked="checked" name="case_status" id="inlineRadio1" value="final"> <span style="color:#000000"><?php echo $this->lang->line('final_order'); ?></span>
                                 <!-- <input type="radio" name="case_status" id="inlineRadio2" value="dispose"> <span style="color:#000000"><?php //echo $this->lang->line('reject'); ?></span> -->
                                 <input type="radio" name="case_status" id="inlineRadio3" value="pending"> <span style="color:#000000"><?php echo "Continue Hearing"; ?></span>

                              </div>
                           </td>
                        </tr>
                     </table>
                     <?php
                     if($petition_basic->application_ref_no){
                        echo '<hr style="border-bottom: 2px solid #000;">';
                        echo '<h2 class="red">Other Attachments</h2>';
                        foreach ($attachment  as $attachment):
                        //var_dump($attachment);
                        ?>
                        <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $petition_basic->application_ref_no .'&type='. 4 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                        <?php 
                        endforeach; 
                     }
                     ?>
                     <?php
                        if(isset($basundharaAttachment) and isset($basuCase)){
                        echo '<h2 class="red">Other Attachments</h2>';
                        foreach ($basundharaAttachment  as $attachment):
                        ?>
                     <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                     <?php 
                        endforeach; 
                        }
                        ?>
                     <?php if(isset($basuCase)){ ?>
                     <button class="btn query btn-md btn-info"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                     <?php } ?>
                     <?php
                        if(($query) and isset($basuCase)){
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
                     <?php
                        if(isset($sup_doc) && sizeof($sup_doc)>0) {
                         ?>
                     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <center class='text-danger text-bold pull-left'><b>View Supportive Document</b></center>
                        <table class="table table-striped table-bordered">
                           <tbody>
                              <?php foreach($sup_doc as $doc) { ?>
                              <tr>
                                 <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                 <td>
                                    <a style="color: red; text-decoration: none;"  target='attachment'  href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                                 </td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                     <?php } ?>
                     <?php
                        if(isset($sro) and isset($basuCase) and ($petition_basic->mut_type=='03') and ($petition_basic->trans_code=='03')){
                         if(($apps->pending_with_officer!='SRO')){
                            $hide=null;
                          ?>
                     <a href="<?php echo base_url()."index.php/basundhara/pushSro?app=$basuCase&c=$_GET[case_no]" ?>" class="green" onclick="if (!confirm('Are you sure want to continue ?')) { return false; }"><i class='fa fa-asterisk'></i>&nbsp;Push to SRO (Click to send SRO Office)</a>
                     <?php }else{
                        $hide='hide';
                        echo "<p class='text-info'>Forwarded to SRO Office for Deed Verification</p>";
                        }
                        } ?>
                     <hr>
                     <?php  if($sro){
                        echo "<center class='uni_text text-danger'>SRO Report</center>";
                        echo "<table class='table'>";
                        echo "<th><tr class='bg-primary'><td>SRO Remark</td>
                        <td>Approve/Reject</td><td>Verified Date</td><td>Verified By</td></tr></th>";
                        foreach($sro as $q){
                          ?>
                     <tr>
                        <td><?=$q->remark?></td>
                        <td><kbd><?=$q->approve_reject==1?'Approved':'Rejected';?></kbd></td>
                        <td><?=$q->date_of_verification?></td>
                        <td><?=$q->sro_officer_name;?></td>
                     </tr>
                     <?php } echo "</table>"; } ?>
                     <?php if($tempNok and ($tempNok[0]['approve_reject']==0 || $tempNok[0]['approve_reject']==1)){
                        $disable='hide';
                        ?>
                     <div class="alert alert-danger">
                  <form id='formAjaxPost' method="post">
                              <table class="table">
                              <thead><tr>
                              <td>Sl No</td>
                              <td>Name</td>
                              <td>Gurdian Name</td>
                              <td>Relation</td>
                              <td>Gender</td>
                              <td>DOB</td>
                              </tr></thead>
                              <tbody>
                              <?php $i=1; foreach($tempNok as $temp){ ?>
                              <tr>
                              <td><?=$i++?></td>
                              <td><?=$temp['name_asm']?></td>
                              <td><?=$temp['guardian_name_asm']?></td>
                              <td><?=$this->utilityclass->get_relation($temp['relation'])?></td>
                              <td><?=$temp['gender']?></td>
                              <td><?=$temp['dob']?></td>
                              </tr>
                              <?php } ?>
                              </tbody>
                              </table>
                              <input type='hidden' id="case_no" value='<?=$_GET['case_no']?>' name='case_no' />
                              <?php if($tempNok and $tempNok[0]['approve_reject']==0){ ?>
                              <div class="form-control alert alert-info" style="padding-top: 6px">
                              <div class="col-sm-4">
                              <input type="radio" class="co_status"  name="co_status" checked="" value="1"> Approve
                              </div>
                              <div class="col-sm-4">
                              <input type="radio" class="co_status" name="co_status" value="0"> Revert to LM
                              </div>
                              <div class="col-sm-4">
                              <input type="radio" class="co_status" name="co_status" value="2"> Cancel
                              </div>
                              </div>
                              <center><button id='submitNoK' class="btn btn-sm btn-success" name="submit">Submit Status</button></center> 
                  </form>
                  <?php } ?>
                  
                  </div>
                  <?php }
                     if($tempNok and $tempNok[0]['approve_reject']==1 ){
                        $disable=null;
                        $now = time(); // or your date as well
                        $your_date = strtotime($tempNok[0]['co_approve_date']);
                        $datediff = $now - $your_date;
                     
                        echo "<p class='text-danger uni_text'><b>No. of day(s) for Objection of NOK Approval by Applicant passed <kbd>". round($datediff / (60 * 60 * 24)) ."</kbd> Days </b></p>";
                        ?>
                  <hr>
                  <span id='loading'></span><span id='msg'></span>
                  <input type='hidden' value='<?=$_GET['case_no']?>' name='case_no' />
                  <!-- <center><button type="submit" class="disable_forward btn btn-sm btn-success" name="submit">Submit</button></center> -->
                  <hr style="border-bottom: 2px solid #000;">
                  <div class='form-group' style="text-align: center;">
                     <button type="submit" class="btn btn-success uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?> </button>
                     <a href="<?php echo base_url(); ?>index.php/coofficemutation/getPendingMutationCases?id=2" class="btn btn-danger">
                     <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                     </a>
                     <?php if(isset($basuCase)){ ?>
                     <a class="btn btn-warning" href="<?=base_url()."index.php/coofficemutation/revertToLMOfficeMutationCO?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-backward'></i>&nbsp; Revert to LM</a>
                     <?php } ?>
                  </div>
                  <?php }else if(!$tempNok) { ?>
                  <span id='loading'></span><span id='msg'></span>
                  <input type='hidden' value='<?=$_GET['case_no']?>' name='case_no' />
                  <!-- <center><button type="submit" class="disable_forward btn btn-sm btn-success" name="submit">Submit</button></center> -->                              
                  <hr style="border-bottom: 2px solid #000;">
                  <div class='form-group' style="text-align: center;">

                     <!-- ===================PROPERTY CHAIN CODE=============== -->
                     <?php if ($buttonEnabledFlag == 1) { ?>
                     <button type="submit" class="btn <?=$hide?> btn-success uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                  <?php } ?>
                  
                     <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$_GET['case_no']?>',<?=SERVICE_OFFICE_MUTATION?>)"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                     <a href="<?php echo base_url(); ?>index.php/coofficemutation/getPendingMutationCases?id=2" class="btn btn-danger">
                     <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                     </a>
                     <?php if(isset($basuCase)){ ?>
                     <a class="btn btn-warning" href="<?=base_url()."index.php/coofficemutation/revertToLMOfficeMutationCO?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-backward'></i>&nbsp; Revert to LM</a>
                     <?php } ?>
                  </div>
                  <?php } ?>
                  </form>
                  <hr style="border-bottom: 2px solid #000;">
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  id='skmodal'>
      <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
         <div class="modal-content"  style=" overflow-y: auto;">
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
   $(document).ready(function(){
      <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
      $('#textarea').hide();

      $(document).on('change', '#inlineCheckbox1', function(){
         if($("#inlineCheckbox1").is(':checked'))
            $("#textarea").show();  // checked
         else
            $("#textarea").hide();  // unchecked
      });

      $(document).on('change', '#inlineCheckbox2', function(){
         if($("#inlineCheckbox2").is(':checked'))
            $("#textarea").show();  // checked
         else
            $("#textarea").hide();  // unchecked
      });

      $('#inlineRadio1').click(function(){
         if(confirm("Are you sure to give final order ? ")){
            $("#textarea").hide();
         }
      });
      $('#inlineRadio2').click(function(){
         if(confirm("Are you sure you want to reject the case order? ")){
            $("#textarea").show();
         }
      });
      $('#inlineRadio3').click(function(){
         $("#textarea").show();
      });

   ////////////////////   
   $("#submitNoK").click(function(event){
   $("#formAjaxPost").submit();
   event.preventDefault();
       var formData = {
         co_status: $(".co_status").val(),
         case_no: $("#case_no").val(),
       };
       $.ajax({
           type        : 'POST', 
           url         : baseurl+'coofficemutation/nokApprove', 
           data        : formData, 
           dataType    : 'json', 
           encode      : true,
   
           beforeSend: function(){
                       $("#loading").html("Validating ...Please wait...");
                       $('.alert').hide();
                       $('.disable_forward').hide();
                   },
           success: function(data){
             console.log(data);
             if(data.success!=null){
               //alert('hai');
               $("#loading").hide();
               $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
             }else if(data.error!=null){
               $("#loading").hide();
               $('.btn-block').show();
               $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
               $('.disable_forward').show();
            }
           },
       });
   });
   });
   
   
   
    $(function () {
       $('.panel').on('click','.lmreportmut',function (e) {
           e.preventDefault();
           //console.log($(this));
           $.ajax({
               url:$(this).attr('href'),
               success:function(data){
                   //alert('hai');
                   $('#skmodal .modal-content').html(data);
                   $('#skmodal').modal('show');
               }
           });
           
       });
       $('.panel').on('click','.skreport',function (e) {
           e.preventDefault();
           $.ajax({
               url:$(this).attr('href'),
               success:function(data){
                   $('#skmodal .modal-content').html(data);
                   $('#skmodal').modal('show');
               }
           });
           
       });
       
       $('.panel').on('click','.astreport',function (e) {
           e.preventDefault();
           $.ajax({
               url:$(this).attr('href'),
               success:function(data){
                   $('#skmodal .modal-content').html(data);
                   $('#skmodal').modal('show');
               }
           });
           
       });
       
       $('.panel').on('click','.petitionreport',function (e) {
           e.preventDefault();
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
   });
</script>
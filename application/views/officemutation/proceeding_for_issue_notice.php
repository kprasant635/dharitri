<style type="text/css">
       .genealogy-scroll::-webkit-scrollbar {
    width: 5px;
    height: 8px;
}
.genealogy-scroll::-webkit-scrollbar-track {
    border-radius: 10px;
    background-color: #e4e4e4;
}
.genealogy-scroll::-webkit-scrollbar-thumb {
    background: #212121;
    border-radius: 10px;
    transition: 0.5s;
}
.genealogy-scroll::-webkit-scrollbar-thumb:hover {
    background: #d5b14c;
    transition: 0.5s;
}


/*----------------genealogy-tree----------*/
.genealogy-body{
    white-space: nowrap;
    overflow-y: hidden;
    padding: 50px;
    min-height: 294px;
    padding-top: 10px;
    text-align: center;
}
.genealogy-tree{
  display: inline-block;
}
.genealogy-tree ul {
    padding-top: 20px; 
    position: relative;
    padding-left: 0px;
    display: flex;
    justify-content: center;
}
.genealogy-tree li {
    float: left; text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
}
.genealogy-tree li::before, .genealogy-tree li::after{
    content: '';
    position: absolute; 
  top: 0; 
  right: 50%;
    border-top: 2px solid #ccc;
    width: 50%; 
  height: 18px;
}
.genealogy-tree li::after{
    right: auto; left: 50%;
    border-left: 2px solid #ccc;
}
.genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before {
    display: none;
}
.genealogy-tree li:only-child{ 
    padding-top: 0;
}
.genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after{
    border: 0 none;
}
.genealogy-tree li:last-child::before{
    border-right: 2px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}
.genealogy-tree li:first-child::after{
    border-radius: 5px 0 0 0;
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
}
.genealogy-tree ul ul::before{
    content: '';
    position: absolute; top: 0; left: 50%;
    border-left: 2px solid #ccc;
    width: 0; height: 20px;
}
.genealogy-tree li a{
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 11px;
    display: inline-block;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}

.genealogy-tree li a:hover+ul li::after, 
.genealogy-tree li a:hover+ul li::before, 
.genealogy-tree li a:hover+ul::before, 
.genealogy-tree li a:hover+ul ul::before{
    border-color:  #fbba00;
}

.litext{
    background-color: #c9fa73;
    padding: 7px;
    font-weight: bold;
    border-radius: 15px;
    font-size: 14px;
    border: 1px solid #c2c2c2;
}
.badge{
    font-size: 13px !important;

}
</style>


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
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Office Mutation Order (<?=$mutation_type_single_multi?>)</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?></label>
                            <label class="col-sm-4 rasid">
							<?php
							if($petition_basic->application_ref_no){
								echo "অনলাইনত উল্লেখ নং : ".$petition_basic->application_ref_no;
							} else {
								echo $this->lang->line('sl_no').' : 1';
							}
							?> 
							</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h2 class="text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Family Details (All NoK)</h2>
                    <?php if($petition_basic->is_multigeneration == "M"){ ?>


                        <?php 
                        if($tree != null || !empty($tree)){ ?>

                        <?php if(isset($generation_type) && $generation_type == "GGP"){
                        ?>
                        <div class="col-lg-12">
                        <div class="body genealogy-body genealogy-scroll">
                        <div class="genealogy-tree">
                        <ul>
                            <li>    
                                <span class="litext"><?=$owner_pattadar?></span> 
                                <ul class="active">
                                <?php
                                foreach ($tree['GP'] as $key => $value) {
                                    if(is_array($tree['GP'][$key]) && count($tree['GP'][$key])>2){
                                        echo "<li><span class='litext'>".$value[1]."</span><ul>";

                                        foreach ($tree['GP'][$key]['P'] as $key1 => $value1) {
                                            if(is_array($tree['GP'][$key]['P'][$key1]) && count($tree['GP'][$key]['P'][$key1])>2){
                                                echo "<li><span class='litext'>".$value1[1]."</span><ul>";
                                                foreach ($tree['GP'][$key]['P'][$key1]['A'] as $key2 => $value2) {
                                                    echo "<li><span class='litext'>".$value2[1]."</span></li>";
                                                }
                                                echo "</ul></li>";
                                            }else{
                                                echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                            }
                                        }
                                        echo "</ul></li>";
                                    }else{
                                        echo "<li><span class='litext'>".$value[1]."</span></li>";
                                    }  
                                }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    </div>
                      </div>
                  <?php }else{ ?>
                    <div class="col-lg-12">
                        <div class="body genealogy-body genealogy-scroll">
                        <div class="genealogy-tree">
                        <ul>
                            <li>
                                <span class="litext"><?=$owner_pattadar?></span> 
                                
                                <ul class="active">
                                <?php
                                
                                foreach($tree['P'] as $key => $value) {
                                    if(is_array($tree['P'][$key]) && count($tree['P'][$key])>2){
                                        echo "<li><span class='litext'>".$value[1]."</span><ul>";
                                        if(!empty($tree['P'][$key]['A'])){
                                            foreach ($tree['P'][$key]['A'] as $key1 => $value1) {
                                                // if(is_array($tree['P'][$key]['A'][$key1]) && count($tree['P'][$key]['A'][$key1])>2){
                                                //     echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                                // }else{
                                                    echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                                // }
                                            }
                                        }
                                        

                                        echo "</ul></li>";
                                    }else{
                                        echo "<li><span class='litext'>".$value[1]."</span></li>";
                                    }  
                                    
                                }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
                    <?php } ?>
                    <?php } ?>
                     <?php } ?>






                        <div class='col-lg-6'>
                            <h2 class="red"><?php echo $this->lang->line('first_party') ?></h2>

                            <?php
							$guard = "";
                            $count = 1;
                            $appname = "";
                            foreach ($petitioner as $p):
                                ?>
                                <!-- //old case -->
                                <!-- <p class='regular uni_text'> -->
                                <p class=''><?php
                                    echo $count++ . ") <span class='text-danger'>" . $p->pet_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->guard_rel) . " : " . $p->guard_name;
                                    $appname .=$p->pet_name . ",";
                                    $appname_father = $p->guard_name;
                                    $app_relation = $this->utilityclass->get_relation($p->guard_rel);
                                    ?> <b><?=isset($p->child_of)?" <span style='color:red'> [ Nok of ".$p->child_of." ] </span>" : null?></b></p>
                            <?php endforeach; $appname = rtrim($appname,",");?>
                        </div>
                        
                        <div class='col-lg-6'>
                            <h2 class="red"><?php echo $this->lang->line('second_party') ?></h2>

                            <?php
                            $guard = "";
                            $count = 1;
                            foreach ($pattadar as $p):
                                ?>
                            <p class='regular uni_text'><?php echo $count++ . ") <span class='text-danger'>" . $p->pdar_name . "</span>,&nbsp;" . $this->utilityclass->get_relation($p->pdar_rel_guar) . " : " . $p->pdar_guardian; ?><br></p>
                                <?php
                                $sellername = $p->pdar_name;
                                $seller_father = $p->pdar_guardian;
                                $seller_relation = $this->utilityclass->get_relation($p->pdar_rel_guar);
                            endforeach;
                            ?>
                        </div>
                        
                        <div class="col-lg-12 p-0">
                        <!-- #Start Other Property Details -->
                        <?php if(SHOW_OTHER_PROPERTY_DETAILS_IN_MUL_MUT_REVIEW_SEC == 1 && count($other_properties)): ?>
                        <h2 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Other Property Details</h2>
                        <table class="table">
                            <tbody>
                                <tr class="bg-primary">
                                    <td>Sl No: </td>
                                    <td>District</td>
                                    <td>Circle: </td>
                                    <td>Area Type: </td>
                                    <td>Village: </td>
                                    <td>Dag: </td>
                                    <td>Patta: </td>
                                    <td>Area: </td>
                                </tr>
                                <?php foreach($other_properties as $key => $other_property): ?>
                                    <tr>
                                        <td><?= ($key+1); ?></td>
                                        <td><?= $other_property->dist_name; ?></td>
                                        <td><?= $other_property->cir_name; ?></td>
                                        <td><?= $other_property->is_rural == 'Y' ? 'Rural' : 'Urban'; ?></td>
                                        <td><?= $other_property->vill_name; ?></td>
                                        <td><?= $other_property->dag_no; ?></td>
                                        <td><?= $other_property->patta_no; ?></td>
                                        <td>
                                            <?= $other_property->bigha; ?> Bigha
                                            | <?= $other_property->katha; ?> Katha
                                            | <?= $other_property->lessa; ?> Lessa
                                            | <?= $other_property->ganda; ?> Ganda
                                            <?php if(in_array($other_property->dist_code, json_decode(BARAK_VALLEY))): ?>
                                                    | <?= $other_property->kranti; ?> Kranti
                                            <?php endif; ?>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                                
                            </tbody>
                        </table>
                        <?php endif; ?>
                        <!-- #End Other Property Details -->
                        </div>
                        <hr>

                        <div class="row" style="background-color: beige;margin-bottom: 26px;">
                            <div class="col-lg-6 text-right">
                                <label class="rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?></label>
                            </div>
                            <div class="col-lg-6">
                                <a class="btn btn-primary petitionreport" href="<?php echo base_url() . "index.php/officemutation/viewPetition?case_no=" . $case_no . "&dist_code=" . $petitioner[0]->dist_code . "&subdiv_code=" . $petitioner[0]->subdiv_code . "&cir_code=" . $petitioner[0]->cir_code . "&mouza_pargona_code=" . $petitioner[0]->mouza_pargona_code . "&lot_no=" . $petitioner[0]->lot_no . "&vill_townprt_code=" . $petitioner[0]->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View Application Details </a>
                            </div>
                        </div>


                        <form class="" method='post' action="<?php echo base_url() . "index.php/coofficemutation/proceeding1"; ?>">

                            <?php if(ESCALATION_ENABLE == 1){ ?>

                             
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <?php 
                              include(APPPATH."views/escalation/remaining_time.php");
                            } ?>

                            <?php if($tranfer_type != null){ ?>
                          
                            <div class="col-lg-12">
                               
                                  <label>Please Select Transfer Type  :</label>
                                    <div class="form-group">
                                      <select class="form-select" id='mut_type' name="mut_type" required="">
                                          <?php foreach($tranfer_type as $mut){ ?>
                                            <option value="<?=$mut['trans_code']?>"><?=$mut['trans_desc_as']?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                            </div>
                            <?php } else{?>
                                <input type="hidden" name="mut_type" value="<?=$trans_code?>">
                            <?php }  ?>
                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {

                                include 'application/views/common/propertyCheckDetails.php';

                            }?>

                            
                            <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
                            <input type="hidden" class="form-control" name="dist_code" value="<?php echo $petition_basic->dist_code; ?>" readonly>
                            <input type="hidden" class="form-control" name="subdiv_code" value="<?php echo $petition_basic->subdiv_code; ?>" readonly>
                            <input type="hidden" class="form-control" name="cir_code" value="<?php echo $petition_basic->cir_code; ?>" readonly>
                            <input type="hidden" class="form-control" name="mouza_pargona_code" value="<?php echo $petition_basic->mouza_pargona_code; ?>" readonly>
                            <input type="hidden" class="form-control" name="lot_no" value="<?php echo $petition_basic->lot_no; ?>" readonly>
                            <input type="hidden" class="form-control" name="vill_townprt_code" value="<?php echo $petition_basic->vill_townprt_code; ?>" readonly>
                            <table class='rasid-t'>

                              <?php
                              $dist_code = $this->session->userdata('dist_code');
                              if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <tr>
                                    <td style='font-size:16px;line-height:1.4em;'><?php
                                        $coname = $this->utilityclass->getSelectedCOName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $this->session->userdata('user_code'));
                                        $coname=$coname->username;
                                        $cir_name=$this->utilityclass->getCircleName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code);
                                        $message = "আবেদনকারীর নামের আবেদন টি দেখা হয়েছে । আবেদনকারী " .
                                        $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                                        . " মৌজা ৰ " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                                        " গ্রামের জমিতে একটি নামজারি চাই |"
                                        . "ভূমিলেখ্য সহায়ক এবং ভূমিলেখ্য পৰ্যবেক্ষক এটি দখল এবং বিরোধের বিষয়ে একটি বিস্তারিত প্রতিবেদন জমা দেবে  |";
                                        ?>
                                        <?php echo $message; ?>
                                        <input type="hidden" class='form-control' name='co_order' value="<?php echo $message; ?>"/>
                                    </td>                                         
                                </tr>

                                <?php }else{?>

                                    <tr>
                                    <td style='font-size:16px;line-height:1.4em;'><?php
                                        $coname = $this->utilityclass->getSelectedCOName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $this->session->userdata('user_code'));
                                        $coname=$coname->username;
                                        $cir_name=$this->utilityclass->getCircleName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code);
                                        $message = "আবেদনকাৰীৰ নামজাৰী আৱেদন চোৱা হল । আবেদনকাৰীয়ে " .
                                        $this->utilityclass->getMouzaName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code)
                                        . " মৌজা ৰ " . $this->utilityclass->getVillageName($petitioner[0]->dist_code, $petitioner[0]->subdiv_code, $petitioner[0]->cir_code, $petitioner[0]->mouza_pargona_code, $petitioner[0]->lot_no, $petitioner[0]->vill_townprt_code) .
                                        " গাৱৰ মাটিত নামজাৰী বিচাৰিছে |"
                                        . "ভূমিলেখ্য সহায়ক আৰু চু:কা: ই চৰজমিন  কৰি  দখল আৰু বিবাদ সম্পৰ্কে বিতং প্রতিবেদন দাখিল কৰিব  |";
                                        ?>
                                        <?php echo $message; ?>
                                        <input type="hidden" class='form-control' name='co_order' value="<?php echo $message; ?>"/>
                                    </td>                                         
                                </tr>

                                <?php }?>



                            </table>
                            <br>
                            <!-- /////////ESCALATION REMARK///////////// -->
                          <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $petition_basic->es_flag == 1) { ?>
                            <div class="col-lg-12">
                                <div class="form-group col-md-4 text-right">
                                    <label> Cause For the case has not been pass in the timeline : </label>
                                </div>
                                <div class="form-group col-md-8">
                                    <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                </div>
                            </div>
                          <?php } ?>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-3" style="margin-left:20px;">
                                        <input type="text" autocomplete="off" class="form-control" id="popupDatepicker" placeholder="dd-mm-yyyy" name="next_hearing_date" required style="margin-left: 20px;">
                                    </div>
                                  <?php
                                  $dist_code = $this->session->userdata('dist_code');
                                  if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                    <label style="" class="col-sm-8 uni_text">শুনানি এবং আপত্তি দাখিলের জন্য তারিখ নির্ধারণ করা হয়েছে ।</label>
                                    <?php }else{?>
                                        <label style="" class="col-sm-8 uni_text">তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য হ'ল ।</label>
                                    <?php }?>
                                </div>
                                <br>
                                <label class="control-label uni_text" style="float:right; margin-right:30px; text-align: center; margin-top:30px; margin-left:70px"><?php echo $coname; ?><br>চক্র বিষয়া, <?php echo $cir_name; ?></label>
                            </div>
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
                                if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
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
                        <?php if($sro){
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
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12">
                                <center>
                                    <button type="submit" class="btn btn-success officemutation"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/getPendingMutationCases?id=1" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                    <?php if($basuCase){ ?>
                                    <button class="btn query btn-md btn-info"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                                    <?php } ?>
                                </center>
                            </div>
                            <br>
                            <hr style="border-bottom: 2px solid #000;">
                        </form>
                    </div>
                </div>
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
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
    });
    </script>
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  id='skmodal'>
      <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
         <div class="modal-content"  style=" overflow-y: auto;">
         </div>
      </div>
</div>
<script type="text/javascript">
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
</script>
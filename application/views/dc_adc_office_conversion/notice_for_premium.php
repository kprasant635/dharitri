<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        border: solid 1px black ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
    }
</style>
<div class="row login panel-form">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u>ম্যাদীকৰণ গোচৰৰ প্রিমিয়াম আদায়ৰ জাননী</u></span></p>
                    <p class='center'><span class="rasid">(<?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</span></p>
                </div>
            </div>
            <div class="panel-body" id="printdiv">
                <!-- <form class="unicode" method='post' action="<?php echo base_url() . "index.php/AdcConversionMb/notice_for_premium_save"; ?>"> -->
                    <table width="100%">
                        <tr>
                            <td colspan="3">
                                <p align="" style="margin-top: 0; margin-bottom: 0; margin-left: 70px;" class="uni_text">
                                    প্ৰতি   <?php
                                $count = 1;
                                $howmany = sizeof($pattadar) - 1;
                                foreach ($pattadar as $p):
                                ?>
                                    <span style="color:red;">
                                        <?php echo $p->name_ass; ?>
                                    </span>
                                <?php
                                    if(isset($p->gurdian_name_ass)){
                                        echo "( " . $p->gurdian_name_ass. " )";
                                    }
                                    if ($count < sizeof($pattadar) - 1) {
                                        echo " , ";
                                        $count++;
                                    } elseif ($count == sizeof($pattadar) - 1) {
                                        echo " আৰু ";
                                        $count++;
                                    } else {
                                        echo " ";
                                    }
                                ?>
                                <?php endforeach; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3" style=" padding-left: 50px;">
                                <?php
                                if (($lm_details['jati_janajati_yn'] != 'Y') && ($lm_details['freedom_fighter_yn'] != 'Y') && ($lm_details['widow_yn'] != 'Y'))
                                {
                                    $msg="";
                                }
                                else{
                                    $msg="আৰু ২৫% ৰেহাই পাচত";
                                }
                                ?>
                                <p class="rasid" >

                                <?php
                                
                                if(($approval_authority == 'gov') || ($approval_authority == 'dc')){
                                  // $prem_percent="বিঘাই প্রতি ".$lm_details['premium_assesment']." % ";
                                  $prem_percent="বিঘাই প্রতি 1% ";
                               
                                }else{

                                   // if ((($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'o')) || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm')) || (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'r')) || ($lm_details['dist_frm_town'] == '3') || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm'))) {
                                    if (trim($lm_details['conversion_premium_rates_id']) == 3 || trim($lm_details['conversion_premium_rates_id']) == 11) {
                                      // $prem_percent="বিঘাই প্রতি ".$lm_details['premium_assesment']." টকা ";
                                      $prem_percent="বিঘাই প্রতি 1% ";
                                  }else {
                                    $prem_percent="বিঘাই প্রতি 450 টকা ";
                                  }
                                    
                                }
                                ?>
    
                                    চক্ৰ বিযয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰই দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যদীকৰন গোচৰ মৰ্মে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $land_details['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $land_details['dag']; ?> নং দাগৰ</span> <?php echo $lm_details['conv_b']; ?> বিঘা <?php echo $lm_details['conv_k']; ?> কঠা <?php echo $lm_details['conv_lc']; ?> লেছা জমীৰ ম্যাদীকৰণ প্ৰিমিয়াম মাটিৰ মান্ডলিক মুল্যৰ <span style='color:red;'> <?=$prem_percent ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $lm_details['prim_tot']; ?> টকা</span> ৩০ দিনৰ ভিতৰত আদায়ৰ বাবে এই জাননী জাৰী কৰা হ'ল ।
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    </table>
                    <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <p class="rasid" style="float: right;"><?php echo $location['add_to']; ?><br>
                                             <?php echo $location['add_off_designation']; ?>,&nbsp;<?php echo $location['dist']; ?></p>
                    </div>
                    <input type="hidden" name="case_no" id="case_no" value="<?php echo $location['case_no']; ?>"/>
                    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">

                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <?php
                    if($basundharaAttachment){
                        echo "<p class='text-success uni_text text-center'>Note: As this application request is generated from Basundhara Application ,an automatic Payment Request will be intiated to the user for Payment of the Respective Amount of Rs:/- $lm_details[prim_tot] only</p>";
                        echo '<h2 class="red">Basundhara Attachments</h2>';
                        foreach ($basundharaAttachment  as $attachment):
                        ?>
                        <input type="hidden" name="amount" id="amount" value="<?=$lm_details['prim_tot']?>">
                        <h6><a href="<?php echo base_url()."index.php/basundhara3/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                        <?php 
                        endforeach; 
                    }
                    else{
                        echo '<h2 class="red">Other Attachments</h2>';
                        foreach($supportiveDocs as $docs):
                        ?>
                            <input type="hidden" name="amount" value="<?=$lm_details['prim_tot']?>">
                            <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
                        <?php
                        endforeach;
                    }
                    ?>
                    <div class="col-sm-12 dontshow">
                    <!-- <center>
                        <h4 class="bold dontshow">Note : Click the button below to Print and Proceed.</h4>
                        <button type="button" name="submit" class="btn btn-danger uni_text" onclick="return myFunction()"><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
                    </center> -->

                    <center>
                        <h4 class="bold dontshow">Note : Click the button below to Print and Proceed.</h4>

                        <div class="flex-container" style="
                            display: flex;
                            width: 100%;
                            justify-content: center;
                            gap: 10px;
                        ">
                                                    <div class="print-recipt" style="padding:08px">
                                                        <button type="button" name="submit" class="btn btn-danger uni_text" onclick="return myFunction()"><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
                                                    </div>


                                                                    <!-- Button -->
                                                <?php if ($petition_basic->dept_note_yn != 'Y') {
                                                                        
                                                    ?>
                                                    <div class="revert-to-co">
                                                        <label class="control-label">
                                                            <button
                                                                type="button"
                                                                class="btn btn-warning mt-2 mb-2"
                                                                id="openRevertModal"
                                                                
                                                            >
                                                                Send Back for Re-verification by Circle Officer
                                                            </button>
                                                        </label>
                                                    </div>
                                                    <?php } ?>
                                                </div>


                        <!-- Modal -->
                        <div id="revertModal" class="modal" style="display:none;">
                            <div class="modal-content" style="width: 400px; margin: 100px auto; padding: 20px; background: #fff; border-radius: 5px;">
                                <h4>Reason for Re-verification</h4>
                                <form id="revertForm" method="POST" action="<?php echo base_url() . "index.php/AdcConversionMb/reverificationbyco"; ?>">
                                    <!-- Add CSRF token if needed -->
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <input type="hidden" name="case_no" value="<?php echo $petition_basic->case_no; ?>">
                                    <input type="hidden" name="dist_code" value="<?php echo $petition_basic->dist_code; ?>">
                                    <input type="hidden" name="subdiv_code" value="<?php echo $petition_basic->subdiv_code; ?>">
                                    <input type="hidden" name="cir_code" value="<?php echo $petition_basic->cir_code; ?>">
                                    <input type="hidden" name="mouza_pargona_code" value="<?php echo $petition_basic->mouza_pargona_code; ?>">
                                    <input type="hidden" name="lot_no" value="<?php echo $petition_basic->lot_no; ?>">
                                    <input type="hidden" name="vill_townprt_code" value="<?php echo $petition_basic->vill_townprt_code; ?>">

                                    <textarea name="reason" id="revertReason" rows="4" style="width:100%;" placeholder="Enter reason here..."></textarea>
                                    <br><br>
                                    <button type="button" class="btn btn-primary" onclick="submitRevert()">Submit</button>
                                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Background -->
                        <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;"></div>

                        <script>
                            const openBtn = document.getElementById('openRevertModal');
                            const modal = document.getElementById('revertModal');
                            const overlay = document.getElementById('modalOverlay');

                            openBtn.addEventListener('click', function () {
                                modal.style.display = 'block';
                                overlay.style.display = 'block';
                            });

                            function closeModal() {
                                modal.style.display = 'none';
                                overlay.style.display = 'none';
                            }

                            function submitRevert() {
                                const reason = document.getElementById('revertReason').value.trim();
                                if (!reason) {
                                    alert("Please enter a reason before submitting.");
                                    return;
                                }

                                const confirmAction = confirm("Are you sure you want to send it back for re-verification?");
                                if (confirmAction) {
                                    document.getElementById('revertForm').submit();
                                }
                            }
                        </script>


                    </center>
                    </div>
                <!-- </form> -->
                <div class="col-lg-12 alert alert-warning">
                    <div class="col-lg-12 center">
                        <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                        <button type="" class="btn btn-info uni_text" value="2" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;<?php echo $this->lang->line('lm_report'); ?></button>
                        <button type="" class="btn btn-active uni_text" value="3" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp;  AST & CO Report</button>
                        <!-- <button type="" class="btn btn-default uni_text" value="4" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('sk_report'); ?></button>
                        <button type="" class="btn btn-primary uni_text" value="6" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; BO Report</button>
                        <button type="" class="btn btn-warning uni_text" value="5" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class="fa fa-list-alt"></i> &nbsp; <?php echo $this->lang->line('view_premiun_report'); ?></button>
                        <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/dc_adc_conversion/GoToDC_ADC?pro=2"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title uni_text"><?php echo $this->lang->line('application_description'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row panel-form">
                    <div class="col-lg-12 center-col">
                        <div class="panel">
                            <!--div 1-->         
                            <div id="notice1" style='display: none'>
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <p class='center uni_text'> <?php echo $this->lang->line('application_description'); ?></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                                        <table class='table table-bordered unicode'>
                                            <tr>
                                                <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                                <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                                <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $conv_type; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to_the_officer'); ?> : <?php echo $location['add_to']; ?></label></td>
                                                <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($location['date'])); ?></label></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                                        <table class="table table-bordered  unicode">
                                            <thead>
                                                <tr>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></label></th>
                                                    <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td><label class="control-label"><?php echo $land_details['dag']; ?></label></td>
                                                <td><label class="control-label"><?php echo $land_details['m_dag_area_b'] . " বিঘা " . $land_details['m_dag_area_k'] . " কঠা " . $land_details['m_dag_area_lc'] . " লেছা " ?></label></td>
                                                <td class="center"><label class="control-label"><?php echo $land_details['patta_no']; ?></label></td>
                                                <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                                                <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=4&dist=" . $l_data['dist_code'] ."&sub_div=".$l_data['subdiv_code']."&cir=".$l_data['cir_code']."&m=".$l_data['mouza_pargona_code']."&l=".$l_data['lot_no']."&v=".$l_data['vill_code']."&p=".$land_details['patta_type']."&dag=".$land_details['dag']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">চিঠা চাওক</span></button></a></td>
                                                <td class="center"><a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">জমাবন্দী চাওক</span></button></a></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                                        <table class='table table-bordered  unicode'>
                                            <thead>
                                                <tr>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                                    <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                                </tr>
                                            </thead>
                                            <?php $count = 1; ?>
                                            <?php
                                            foreach ($pattadar as $p):
                                                $pattadar = $p->name_ass;
                                                //$relation=$p->pdar_rel_guar;
                                                $relation = 'f';
                                                $relationship = $this->utilityclass->get_relation($relation);
                                                ?>
                                                <tr>
                                                    <td><label class="control-label"><?php echo $count++; ?></label></td>
                                                    <td><label class="control-label"><?php echo $pattadar; ?></label></td>
                                                    <td><label class="control-label"><?php echo $p->gurdian_name_ass; ?></label></td>
                                                    <td><label class="control-label"><?php echo $relationship; ?></label></td>
                                                    <td><label class="control-label"><?php echo $p->address; ?></label></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                            <!--div 2-->            
                            <div id="notice2" style='display: none'>
                                <?php
                                if (count($lm_details_final) != 0) {
                                    foreach ($lm_details_final as $lm):
                                        ?>
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <p class='center uni_text'><u><?php echo $this->lang->line('lm_report'); ?> (<?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</u><br>
                                                <span style="color: red;" class="uni_text">(<?php echo $this->lang->line('dag_no'); ?>  <?php echo $land_details['dag']; ?>)</span></p>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class='table table-striped unicode'>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ১) আবেদন কৰা মাটিৰ পট্টা আবেদনকাৰীৰ নামত &nbsp; - 
                                                                    <?php
                                                                    if ($lm->applicant_patta_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ২) আবেদন কৰা মাটি আবেদনকাৰীৰ দখলত &nbsp; -
                                                                    <?php
                                                                    if ($lm->occupied_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৩) উক্ত মাটিত মূল্যবান গছ-গছনি &nbsp; -
                                                                    <?php
                                                                    if ($lm->val_tree_yn == 'Y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label" >৪) উক্ত মাটিৰ শ্রেণী - <?php echo $lm_details['land_class_code']; ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৫) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী &nbsp; -
                                                                    <?php
                                                                    if ($lm->issuit_forconv_under105 == 'Y') {
                                                                        echo "হয়";
                                                                    } else {
                                                                        echo "নহয়";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm->roadside_rsv_b; ?> বিঃ, <?php echo $lm->roadside_rsv_k; ?> কঃ, <?php echo $lm->roadside_rsv_lc; ?> লেঃ </label>
                                                                <!-- added by hridayjit -->
                                                                <?php if($lm->roadside_old_new_dag_reservation != null) {?>
                                                                    </label class="control-label"> <b>Roadside Reservation: </b> 
                                                                        <?php 
                                                                            if($lm->roadside_old_new_dag_reservation == 'newdagreservation')
                                                                            {
                                                                                echo 'New Dag Reservation';
                                                                            } 
                                                                            else if($lm->roadside_old_new_dag_reservation == 'olddagreservation') 
                                                                            {
                                                                                echo 'Old Dag Reservation';
                                                                            }; 
                                                                        ?>
                                                                    </label>
                                                                <?php } ?>
                                                                <!--  -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ৭) উক্ত মাটি নদীৰ কাষৰ মাটি &nbsp; -
                                                                    <?php
                                                                    if ($lm->near_river_yn == 'Y') {
                                                                        echo "হয়";
                                                                    } else {
                                                                        echo "নহয়";
                                                                    }
                                                                    ?></label>
                                                                    <!-- added by hridayjit -->
                                                                    <?php if($lm->riverside_old_new_dag_reservation != null) { ?>
                                                                        <label class="control-label"> <b>Riverside Reservation: </b>
                                                                            <?php 
                                                                                if($lm->riverside_old_new_dag_reservation == 'newdagreservation')
                                                                                {
                                                                                    echo 'New Dag Reservation';
                                                                                } 
                                                                                else if($lm->riverside_old_new_dag_reservation == 'olddagreservation') 
                                                                                {
                                                                                    echo 'Old Dag Reservation';
                                                                                }; 
                                                                            ?>
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!--  -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label" >৮) <span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব |</span></label> 
                                                                <ul>
                                                                <?php
                                                                if (($lm_details_final[0]->jati_janajati_yn != 'Y') && ($lm_details_final[0]->freedom_fighter_yn != 'Y') && ($lm_details_final[0]->widow_yn != 'Y'))
                                                                {
                                                                    $msg="";
                                                                    echo " - এই আবেদনত উপযোগী নহয় |";
                                                                }
                                                                else{
                                                                    $msg="আৰু ২৫% ৰেহাই পাচত";
                                                                }
                                                                if ($lm->jati_janajati_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';

                                                                        if(empty($lm->jati_janajati_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->jati_janajati_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                } 
                                                                if ($lm->freedom_fighter_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >খ. আবেদনকাৰী ভূমিহীণ মুক্তিযোদ্ধা হয় &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                        if(empty($lm->freedom_fighter_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->freedom_fighter_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                if ($lm->widow_yn == 'Y') {
                                                                    echo '<li>
                                                                        <label class="control-label" >গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই &nbsp;</label>
                                                                        <div id="jati_janajatie" class="alert alert-info">';
                                                                        if(empty($lm->widow_yn_upload)){
                                                                        ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - FILE NOT ATTACHED</span> 
                                                                        <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm->widow_yn_upload); ?>" class="preview__file">View</a></span> 
                                                                            <?php
                                                                        }
                                                                        echo'</div>
                                                                    </li>';
                                                                }
                                                                ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <?php 
                                                                    // muzammil : new include file added for premium condition 
                                                                    // include(APPPATH."views/inc/conversion_premium.php");?>
                                                                    <label class="control-label" >
                                                                    ৯) 
                                                                    <?php

                                                                        echo $conversion_premium_area->ass_name . ' মাটি - হয়';

                                                                    ?>
                                                                    </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                            <?php // muzammil : new include file added for premium per bigha 
                                                            include(APPPATH."views/inc/conversion_premium_per_bigha.php"); ?>
                                                                <label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?=round($bigha_prem, 2); ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="50%"><label class="control-label">১১) মন্ডলৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                                            <td><label class="control-label"><?php echo $lm->partition_info; ?></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><label class="control-label">
                                                                    ১২) লাঃ মঃ ৰ চহী &nbsp; - 
                                                                    <?php
                                                                    if ($lm->lm_sign_yn == 'Y' || $lm->lm_sign_yn == 'y') {
                                                                        echo "আছে";
                                                                    } else {
                                                                        echo "নাই";
                                                                    }
                                                                    ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label">১৩) লাঃ মঃ ৰ নাম &nbsp; - <?php echo $lm_name; ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <label class="control-label">১৪) লাঃ মঃ এ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm->date_entry)); ?></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Pattadar Name</th>
                                                                            <th>Inplace / Alongwith</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($p_in_order as $pdar) { ?>
                                                                            <tr>
                                                                                <td><?php echo $pdar->pdar_name; ?></td>
                                                                                <td><?php echo $pdar->inplace_alongwith; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <p class='center uni_text'><u><?php echo $this->lang->line('lm_report'); ?> ( <?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>)</u><br>
                                            <span style="color: red;" class="uni_text">(<?php echo $this->lang->line('dag_no'); ?> <?php echo $land_details['dag']; ?>)</span></p>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        No Report found
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--div 3-->            
                            <div id="notice3" style='display: none'>
                                <div class="panel-heading">
                                    <p align="left" class="uni_text"> অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ </p><br>
                                    <p align="right" style="margin-top: 0; margin-bottom: 0">
                                        <font size="3" face="courier">
                                        <?php echo $this->lang->line('name'); ?> : 
                                        <?php
                                        foreach ($p_in_order as $pop):
                                            echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                                        endforeach;
                                        ?>
                                        </font>
                                    </p>
                                    <div class="panel-title">
                                        <p class='center bold uni_text'><u>ORDER SHEET</u></p>
                                        <p class='center uni_text'>(See Rule 129 of the Record Manual 1911)</p>
                                        <br>
                                        <p class='center bold uni_text'><span class="">Order Sheet, dated from <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['date'])); ?></span> To <span style="color: red;"><?php echo date('d-m-Y', strtotime($location['next_date'])); ?></span> District <?php echo $location['dist']; ?> <br>
                                                Case No <?php echo $location['case_no']; ?></span></p>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                            <table class="table table-bordered" style="font-size: 16px;">
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>Serial No and Date of Order</td>
                                                    <td width="40%">Order and Signature of Officer</td>
                                                    <td width="40%">Note Of Action Taken on Order</td>
                                                </tr>
                                                <tr style="color:#0000cc; text-align: center;">
                                                    <td>১</td>
                                                    <td>২</td>
                                                    <td>৩</td>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                foreach ($cases as $case):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                                        <td>
                                                            <?php echo $case->co_order; ?></td>
                                                        <td>
                                                            <?php echo $case->note_on_order; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                                //$i = $i+1;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default uni_text" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // function myFunction() {
	// 	$(".dontshow").hide();
		
    //     window.print();
	// 	$(".dontshow").show();
	// 	document.getElementById("mainMenu").disabled = false;

        
	// 	}

    function modaldiva(objButton) {
        if (objButton == 1)
        {
            document.getElementById('notice1').style.display = 'block';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 2)
        {
            document.getElementById('notice2').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 3)
        {
            document.getElementById('notice3').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 4)
        {
            document.getElementById('notice4').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 5)
        {
            document.getElementById('notice5').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice6').style.display = 'none';
        }
        else if (objButton == 6)
        {
            document.getElementById('notice6').style.display = 'block';
            document.getElementById('notice1').style.display = 'none';
            document.getElementById('notice2').style.display = 'none';
            document.getElementById('notice3').style.display = 'none';
            document.getElementById('notice4').style.display = 'none';
            document.getElementById('notice5').style.display = 'none';
        }
    }

    function myFunction() {     
        var htmlString = $("#printdiv").html();
        htmlString = base64EncodeUnicode(htmlString);
        var baseurl = $('#baseurl').val();

        $("#htmlstring_text").text(htmlString);
        // Extracting case_no dynamically if it's part of an input field
        var case_no = $("#case_no").val(); // Ensure this selector points to the correct input field
        var amount = $("#amount").val(); // Adjust if needed

        console.log(case_no, amount);

        $(".dontshow").hide();
        $('.reports-tab-section').hide();
        // $(".reports-tabs nav ul").hide();
	    window.print();
        $(".dontshow").show();
        $('.reports-tab-section').show();
        // $(".reports-tabs nav ul").show();
        // document.getElementById("mainMenu").disabled = false;
        var case_no = $('#case_no').val();
        var amount = $('#amount').val();
        var baseurl = $('#baseurl').val();
        // console.log(case_no);
        if(case_no == '' || case_no == undefined || amount == '' || amount == undefined) {
            swal.fire("", 'Required Parameters are empty.', "error")
            .then((value) => {
                
            });
            return false;
        }
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

       

        $.ajax({
            url: baseurl + 'index.php/AdcConversionMb/notice_for_premium_save',
            method: 'POST',
            data: {case_no:case_no, amount:amount},
            dataType: 'JSON',
            success: function(response) {
                $.unblockUI();
                console.log(response);
                if(response.status == 'SUCCESS') {

                    $.ajax({
                        url: baseurl + '/index.php/save_premium_notice',
                        method: 'POST',
                        data: {
                            case_no: case_no,
                            amount: amount,
                            html_content: htmlString // If you need to save the HTML content in the table
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            $.unblockUI();
                            console.log(response);
                            
                        },
                        error: function(error) {
                            $.unblockUI();
                            console.log(error);
                        }
                    });

                    swal.fire("", response.msg, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                else if(response.status == 'FAILED') {
                    swal.fire("", response.msg, "error")
                    .then((value) => {
                        
                    });
                }
            },
            error: function(error) {
                $.unblockUI();
                console.log(error);
            }
    });
	}

    function base64EncodeUnicode(str) {
        return btoa(unescape(encodeURIComponent(str)));
    }
    

        
 </script>

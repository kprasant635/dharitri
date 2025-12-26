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
                <form class="unicode" method='post' action="<?php echo base_url() . "index.php/BranchOfficerConversion/notice_for_premium_save"; ?>">
                    <table width="100%">
                        <tr>
                            <td colspan="3">
                                <p align="" style="margin-top: 0; margin-bottom: 0; margin-left: 70px;" class="uni_text">
                                    প্ৰতি ,<br>
                                    <?php
                                    foreach ($pattadar as $pop):
                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                                    endforeach;
                                    ?>
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
                                
                                if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) {
                                    if ((($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'o')) || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm')) || (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'r')) || ($lm_details['dist_frm_town'] == '3') || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm'))) {
                                        if (trim($lm_details['premium_assesment']) == '40' || trim($lm_details['premium_assesment']) == '20') {
                                            $prem_percent="বিঘাই প্রতি ".$lm_details['premium_assesment']." টকা ";
                                        }else {
                                            $prem_percent="বিঘাই প্রতি ".$lm_details['premium_assesment']." % ";
                                        }
                                    }else{
                                        $prem_percent="বিঘাই প্রতি ".$lm_details['premium_assesment']." % ";
                                    }
                                }
                                else {
                                    if($conversion_premium_rate->amount != 0 && $conversion_premium_rate->rate == 0) {
                                        $prem_percent = "বিঘাই প্রতি " . $conversion_premium_rate->amount . " টকা";
                                    }
                                    else if($conversion_premium_rate->amount == 0 && $conversion_premium_rate->rate != 0) {
                                        $prem_percent = "বিঘাই প্রতি " . $conversion_premium_rate->rate . " %";
                                    }
                                }
                                ?>
                                    চক্ৰ বিযয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰই দাখিল কৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যদীকৰন গোচৰ মৰ্মে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাওঁৰ <span style='color:red;'><?php echo $land_details['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $land_details['dag']; ?> নং দাগৰ</span> <?php echo $land_details['m_dag_area_b']; ?> বিঘা <?php echo $land_details['m_dag_area_k']; ?> কঠা <?php echo $land_details['m_dag_area_lc']; ?> লেছা জমীৰ ম্যাদীকৰণ প্ৰিমিয়াম মাটিৰ মান্ডলিক মুল্যৰ <span style='color:red;'> <?=$prem_percent ?> হিচাপে <?php echo $msg; ?> মুঠ <?php echo $lm_details['prim_tot']; ?> টকা</span> আদায়ৰ বাবে শুনানি জাৰী কৰা হ'ল ।
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
                    <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <?php
                    if($basundharaAttachment){
                        echo "<p class='text-success uni_text text-center'>Note: As this application request is generated from Basundhara Application ,an automatic Payment Request will be intiated to the user for Payment of the Respective Amount of Rs:/- $lm_details[prim_tot] only</p>";
                        echo '<h2 class="red">Basundhara Attachments</h2>';
                        foreach ($basundharaAttachment  as $attachment):
                        ?>
                        <input type="hidden" name="amount" value="<?=$lm_details['prim_tot']?>">
                        <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
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
                    <center>
                        <h4 class="bold dontshow">Note : Click the button below to Print and Proceed.</h4>
                        <button type="submit" name="submit" class="btn btn-danger uni_text" onclick="return myFunction()"><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
                    </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
		$(".dontshow").hide();
		
        window.print();
		$(".dontshow").show();
		document.getElementById("mainMenu").disabled = false;
		}
 </script>

<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">ভূমিলেখ্য সহায়কৰ প্ৰতিবেদন ( গোচৰ নং : <?php echo $lm_details['case_no']; ?> )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-4 rasid">( দাগ নং  : <?php echo $lm_details['dag_no']; ?> )</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class='table table-striped table-bordered unicode' style="font-size: 20px;">
                                    <tr>
                                        <td colspan="2"><label class="control-label" >
                                                ১) আবেদন কৰা মাটিৰ পট্টা আবেদনকাৰীৰ নামত &nbsp; - 
                                                <?php
                                                if ($lm_details['applicant_patta_yn'] == 'Y') {
                                                    echo "আছে";
                                                } else {
                                                    echo "নাই";
                                                }
                                                ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="control-label" >
                                                ২) আবেদন কৰা মাটি আবেদনকাৰীৰ দখলত &nbsp; -
                                                <?php
                                                if ($lm_details['occupied_yn'] == 'Y') {
                                                    echo "আছে";
                                                } else {
                                                    echo "নাই";
                                                }
                                                ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="control-label" >
                                                ৩) উক্ত মাটিত মূল্যবান গছ-গছনি &nbsp; -
                                                <?php
                                                if ($lm_details['val_tree_yn'] == 'Y') {
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
                                        <td colspan="2"><label class="control-label" >
                                                ৫) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী &nbsp; -
                                                <?php
                                                if ($lm_details['issuit_forconv_under105'] == 'Y') {
                                                    echo "হয়";
                                                } else {
                                                    echo "নহয়";
                                                }
                                                ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="control-label" >৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm_details['roadside_rsv_b']; ?> বিঃ, <?php echo $lm_details['roadside_rsv_k']; ?> কঃ, <?php echo $lm_details['roadside_rsv_lc']; ?> লেঃ </label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="control-label" >
                                                ৭) উক্ত মাটি নদীৰ কাষৰ মাটি &nbsp; -
                                                <?php
                                                if ($lm_details['near_river_yn'] == 'Y') {
                                                    echo "হয়";
                                                } else {
                                                    echo "নহয়";
                                                }
                                                ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" >৮) <span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব |</span></label> 
                                            <ul>
                                            <?php
                                            if (($lm_details['jati_janajati_yn'] == '0') && ($lm_details['freedom_fighter_yn'] == '0') && ($lm_details['widow_yn'] == '0'))
                                            {
                                                echo " - এই আবেদনত উপযোগী নহয় |";
                                                $msg="";
                                            }
                                            else{
                                                $msg="২৫% ৰেহাই পাচত";
                                            }
                                            if ($lm_details['jati_janajati_yn'] == 'Y') {
                                                echo '<li>
                                                    <label class="control-label" >ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয় &nbsp;</label>
                                                    <div id="jati_janajatie" class="alert alert-info">';
                                                    ?>
                                                        <!-- <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="<?php echo base_url(); ?>dharitree/uploads/ConversionDocs/<?php echo $lm_details['jati_janajati_upload'];?>" target="_blank">View</a></span>  -->
                                                        <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm_details['jati_janajati_upload']); ?>" class="preview__file">View</a></span> 
                                                    <?php
                                                    echo'</div>
                                                </li>';
                                            } 
                                            if ($lm_details['freedom_fighter_yn'] == 'Y') {
                                                echo '<li>
                                                    <label class="control-label" >খ. আবেদনকাৰী ভূমিহীণ মুক্তিযোদ্ধা হয় &nbsp;</label>
                                                    <div id="jati_janajatie" class="alert alert-info">';
                                                    ?>
                                                        <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm_details['freedom_fighter_upload']); ?>" class="preview__file">View</a></span> 
                                                    <?php
                                                    echo'</div>
                                                </li>';
                                            }
                                            if ($lm_details['widow_yn'] == 'Y') {
                                                echo '<li>
                                                    <label class="control-label" >গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই &nbsp;</label>
                                                    <div id="jati_janajatie" class="alert alert-info">';
                                                    ?>
                                                        <span class="blue"> প্ৰয়েজনীয় নথি চাৱ পাৰে - <a href="javascript:void(0);" data-path="<?php echo search_file_location('ConversionDocs/'. $lm_details['widow_upload']); ?>" class="preview__file">View</a></span> 
                                                    <?php
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
                                        //     strtotime($lm_details['lm_sign_date']);
                                        //     strtotime(convnewdate);
                                        // if (strtotime($lm_details['lm_sign_date']) > strtotime(convnewdate)) { 
                                        if($rtps==BASUNDHARA_CHECK){
                                        ?>
                                        
                                        <label class="control-label" >
                                                ৯) 
                                                <?php
                                                if($lm_details['premium_new_yn'] == 1) {
                                                    echo $conversion_premium_area->ass_name . ' মাটি হয়নে ? - হয়';
                                                }
                                                else {
                                                    if ($lm_details['dist_frm_town'] == '0') {
                                                        echo "অবেদিত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে ? - হয়";
                                                    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'd')) {
                                                        echo "অবেদিত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে - হয়";
                                                    } elseif (($lm_details['dist_frm_town'] == '3') && ($lm_details['inside_outside_town'] == 'i')) {
                                                        echo "উক্ত মাটি জিলা মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধি অঞ্চল মাটি হয়নে - হয়";
                                                    } elseif (($lm_details['dist_frm_town'] == '1') && ($lm_details['inside_outside_town'] == 'o')) {
                                                        echo "উক্ত মাটি জিলাৰ মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ বাহিৰে আন চহৰবোৰৰ
                                                        পৰিধি অঞ্চল মাটি হয়নে  - হয়";
                                                    } elseif (($lm_details['dist_frm_town'] == '15') && ($lm_details['inside_outside_town'] == 'i')) {
                                                        echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে ? - হয়";
                                                    } elseif (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'o')) {
                                                        echo "অবেদিত মাটি গাওৰ মাটি হয়নে - হয়";
                                                    } elseif ($lm_details['dist_frm_town'] == '1') {
                                                        echo "উক্ত মাটি গ্ৰাম্য এলেকা মাটি হয়নে - হয়";
                                                    }
                                                }
                                                
                                        ?></label>
                                        <?php } else {
                                                // muzammil : new include file added for premium condition 
                                                include(APPPATH."views/inc/conversion_premium.php");
                                        
                                        } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php // muzammil : new include file added for premium per bigha 
                                                include(APPPATH."views/inc/conversion_premium_per_bigha.php"); ?>
                                            <label class="control-label" >১০) বিঘাই প্রতি <span style="color: red;"><?=$bigha_prem ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm_details['conv_b']; ?></span> বিঃ <span style="color: red;"><?php echo $lm_details['conv_k']; ?></span> কঃ <span style="color: red;"><?php echo $lm_details['conv_lc']; ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".$lm_details['prim_tot']; ?></span> টকা  &nbsp; <a href="<?= base_url(); ?>/assets/Premium.pdf" target="_blank">View Premium Notice </a></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%"><label class="control-label" >১১) ভূমিলেখ্য সহায়কৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                        <td><label class="control-label" ><?php echo $lm_details['partition_info']; ?></label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="control-label" >
                                                ১২) ভূমিলেখ্য সহায়ক ৰ চহী &nbsp; - 
                                                <?php
                                                if ($lm_details['lm_sign_yn'] == 'Y') {
                                                    echo "আছে";
                                                } else {
                                                    echo "নাই";
                                                }
                                                ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" >১৩) ভূমিলেখ্য সহায়কৰ নাম &nbsp; - <?php echo $lm_details['lm_name']; ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" >১৪) ভূমিলেখ্য সহায়ক এ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm_details['date_entry'])); ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="control-label" >১৫) স্থানান্তৰ নকৰা কালি - <?php echo $lm_details['partial_untrans_b']; ?> বিঃ, <?php echo $lm_details['partial_untrans_k']; ?> কঃ, <?php echo $lm_details['partial_untrans_lc']; ?> লেঃ </label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <p class='center bold'><span class="rasid" style="color: red;"><u>ভূমিলেখ্য পৰ্যবেক্ষকৰ প্রতিবেদন</u></span></p>
                        <form class="unicode" method='post' action="<?php echo base_url($post_url); ?>">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class='table table-striped table-bordered' style="font-size: 20px;">
                                            <tr>
                                                <td><label class="control-label" >১) ভূমিলেখ্য পৰ্যবেক্ষকৰ অন্যান্য তথ্য ও মন্তব্য</label></td>
                                                <td width="50%"><textarea name="sk_notice" class="form-control" cols="8" rows="8" required placeholder="ভূমিলেখ্য সহায়কৰ প্রতিবেদন পৰীক্ষা কৰা হ'ল । প্ৰিমিয়াম আদায় মৰ্মে ম্যদীকৰনৰ হুকুম দিব পাৰে ।">ভূমিলেখ্য সহায়কৰ প্রতিবেদন পৰীক্ষা কৰা হ'ল । প্ৰিমিয়াম আদায় মৰ্মে ম্যদীকৰনৰ হুকুম দিব পাৰে ।</textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label class="control-label" >২) ভূমিলেখ্য পৰ্যবেক্ষকৰ চহী &nbsp;</label>
                                                    <label>
                                                        <input type="radio" name="sk_sign" id="inlineRadio1" value="Y" checked> আছে  
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="sk_sign" id="inlineRadio2" value="N"> নাই
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label class="control-label" >৩) ভূমিলেখ্য পৰ্যবেক্ষকৰ নাম &nbsp;</label>
                                                    <input type="hidden" name="SK_code" value="<?php echo $lm_details['sk_code']; ?>"/>
                                                    <input type="text" name="SK_name" style="width: 200px;" value="<?php echo $lm_details['sk_name']; ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label class="control-label" >৪) ভূমিলেখ্য পৰ্যবেক্ষকৰ টোকা লিখাৰ তাৰিখ &nbsp;</label>
                                                    <input type="text" name="sk_date_of_entry" id="popupDatepicker" style="width: 200px;" required>
                                                    <label class="control-label" >&nbsp; (dd/mm/yyyy)</label>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                //var_dump($basundharaAttachment);
                                if($basundharaAttachment){
                                    echo '<h2 class="red">Basundhara Attachments</h2>';
                                    foreach ($basundharaAttachment  as $attachment):
                                    ?>
                                    <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                    <?php 
                                    endforeach; 
                                }
                                else{
                                    echo '<h2 class="red">Other Attachments</h2>';
                                    foreach($supportiveDocs as $docs):
                                    ?>
                                        <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
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
                            
                                <hr style="border-bottom: 2px solid #000;">
                                <center>
                                    <input type="hidden" name="case_no" value="<?php echo $lm_details['case_no']; ?>"/>
                                    <input type="hidden" name="dag_no" value="<?php echo $lm_details['dag_no']; ?>"/>
                                    <input type="hidden" name="note_no" value="<?php echo $lm_details['note_no']; ?>"/>
                                    <button type="submit" name="submit" class="btn btn-success uni_text"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                                </center>
                                <hr style="border-bottom: 2px solid #000;">
                            </div>
                        </form>
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <a class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                                <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/SKconversionPartha/GoToSK?pro=1"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                            </div>
                        </div>
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
                            <td><label class="control-label"><?php echo $location['dag']; ?></label></td>
                            <td><label class="control-label"><?php echo $location['m_dag_area_b'] . " বিঘা " . $location['m_dag_area_k'] . " কঠা " . $location['m_dag_area_lc'] . " লেছা " ?></label></td>
                            <td class="center"><label class="control-label"><?php echo $location['patta_no']; ?></label></td>
                            <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                            <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn">চিঠা চাওক</span></button></a></td>
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
                            $pattadar = $p->pdar_name;
                            //$relation=$p->pdar_rel_guar;
                            $relation = 'f';
                            $relationship = $this->utilityclass->get_relation($relation);
                            ?>
                            <tr>
                                <td><label class="control-label"><?php echo $count++; ?></label></td>
                                <td><label class="control-label"><?php echo $pattadar; ?></label></td>
                                <td><label class="control-label"><?php echo $p->pdar_guardian; ?></label></td>
                                <td><label class="control-label"><?php echo $relationship; ?></label></td>
                                <td><label class="control-label"><?php echo $p->pdar_add1 . " " . $p->pdar_add2; ?></label></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </fieldset>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default uni_text" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
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

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>

</script>
<!--  -->


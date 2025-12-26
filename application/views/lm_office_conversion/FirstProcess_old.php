<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">লট মন্ডলৰ প্ৰতিবেদন ( গোচৰ নং : <?php echo $land_details['case_no']; ?> )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-4 rasid">( দাগ নং  : <?php echo $land_details['dag']; ?> )</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal unicode" method='post' action="<?php echo base_url() . "index.php/LMconversionPartha/SecondProcess"; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class='table table-striped table-bordered' style="font-size: 20px;">
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ১) আবেদন কৰা মাটি আবেদনকাৰীৰ পট্টাৰ মাটি হয়নে ?  &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" name='pattar_mati_hoi_ne' value="Y"> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ২) আবেদন কৰা মাটিত আবেদনকাৰীৰ দখল আছে নে ? &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" name='dokhol_ase_ne' value="Y"> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ৩) উক্ত মাটিত মূল্যবান গছ-গছনি আছে নে ? &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" name='gos_gosoni' value="Y">
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ৪) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী নে ? &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" name='miyadi_upojugi' value="Y">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" > ৫) উক্ত মাটিৰ শ্রেণী  &nbsp;</label></td>
                                            <td>
                                                <select name="land_class" class="form-control" required>
                                                    <option value="<?php echo $land_details['land_class_code']; ?>" selected><?php echo $land_details['land_class_actual_name']; ?></option>
                                                    <?php foreach ($land_class as $land): ?>
                                                        <?php
                                                        $class_code = $land->class_code;
                                                        $land_type = $land->land_type;
                                                        ?>
                                                        <option value="<?php echo $class_code; ?>"><?php echo $land_type; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><label class="control-label" > ৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - &nbsp;</label>
                                                <input type="text" name="rastar_kaijo_b" class="rastar_kaijo_b" style="width: 100px;" value="0"> বিঃ 
                                                <input type="text" name="rastar_kaijo_k" class="rastar_kaijo_k" style="width: 100px;" value="0"> কঃ 
                                                <input type="text" name="rastar_kaijo_lc" class="rastar_kaijo_lc" style="width: 100px;" value="0"> লেঃ
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ৭) উক্ত মাটি নদীৰ কাষৰ মাটি নেকি ? &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" class='rv_side' name='nodir_kakhor' value="Y"> &nbsp;
                                                <div id='river_seide'>
                                                    পরিমাণ - 
                                                    <input type="text" name="nodir_kaijo_b" class="nodir_kaijo_b" style="width: 100px;" value="0"> বিঃ 
                                                    <input type="text" name="nodir_kaijo_k" class="nodir_kaijo_k" style="width: 100px;" value="0"> কঃ 
                                                    <input type="text" name="nodir_kaijo_lc" class="nodir_kaijo_lc" style="width: 100px;" value="0"> লেঃ
                                                </div>
                                            </td>
                                        </tr>
                                        <!--new addition starts--->
                                        <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব | যদিহে হ'য় তেন্তে তলত দিয়া ক,খ,গ 'ৰ পৰা বাচনী কৰক |</span></label>
                                                <ul>
                                                    <li>
                                                        <label class="control-label" > ৮) ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয়নে ? &nbsp;</label>
                                                        <input type="checkbox" id="jati_janajati" class='jati_janajati' name='jati_janajati' value="Y"> &nbsp;
                                                        <div id='jati_janajatie' class="alert alert-info">
                                                            <span class="blue"> প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                            <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename_jati_janajati"></span> 
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; খ. আবেদনকাৰী ভূমিহীণ মুক্তিযোদ্ধা হয়নে ? &nbsp;</label>
                                                        <input type="checkbox" id="freedom_fighter" class='freedom_fighter' name='freedom_fighter' value="Y"> &nbsp;
                                                        <div id='freedom_fightere' class="alert alert-info">
                                                            <span class="blue">&nbsp;&nbsp; প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                            <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename_freedom_fighter"></span> 
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্যনকাৰী সন্তান নাই অথবা উপাৰ্যনক্ষম ভূসম্পওি নাই ? &nbsp;</label>
                                                        <input type="checkbox" id="widow" class='widow' name='widow' value="Y"> &nbsp;
                                                        <div id='widowe' class="alert alert-info">
                                                            <span class="blue">&nbsp;&nbsp; প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                            <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename_widow"></span> 
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">টোকা : ক্ৰ্মিক নং ৯, ১০ আৰু ১১ অতি গুরুত্বপূর্ণ / বাধ্যতামূলক |</span></label>
                                                <ul>
                                                    <li>
                                                        <label class="control-label"> ৯) ক. উক্ত মাটি নগৰ/চহৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withintown" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; খ. অবেদিত মাটি চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within3km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within10km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঘ. <span class="red">(গাওৰ মাটি হয়নে ?)</span> &nbsp; অবেদিত মাটি চহৰ অথবা চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধ আৰু গুৱাহাটী <br>পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ বাহিৰৰ মাটি হয়নে ? &nbsp; </label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinRev" class="get_premium_assessed">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ১০) মাটিৰ মান্ডলিক মুল্য (&nbsp;বিঘাই প্রতি &nbsp;</label>
                                                <input type="number" name="each_bigha_rate" id="zonal_rate" style="width: 100px;" required value="0.00"> <label class="control-label" >&nbsp; টকা &nbsp;)</label><span class="red"> * mandatory</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ১১) মাটিৰ প্রিমিয়াম Assesment Type(&nbsp;বিঘাই প্রতি - </label>
                                                <select name="premium_assesment" class="townland" required  style="display:none;" id="cal_premium_a">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="50">50% per bigha land value for Residiantial Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="100">100% per bigha land value for Remaining occupied portion of AP land if a part is transfered.</option>
                                                </select>
                                                <select name="premium_assesment" class="w3km" required  style="display:none;" id="cal_premium_b">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="15">Premium @ 15% of per bigha land value.</option>
                                                </select>
                                                <select name="w10km" class="w10km" required  style="display:none;" id="cal_premium_c">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="25">Premium @ 25% of per bigha land value.</option>
                                                </select>
                                                <select name="premium_assesment" class="withinrevenue" required  style="display:none;" id="cal_premium_d">
                                                    <option selected disabled>-- select --</option>
                                                    <?php if($basuCase) { ?>
                                                        <option value="0">Premium Free As it is Basundhara registered Case</option>
                                                    <?php } ?>
                                                    <option value="20">Premium @ 20 Rs of per bigha land value for Agricultural Purpose.</option>
                                                    <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                </select>
                                                <select name="premium_assesment" class="when_none" required>
                                                    <option selected disabled>-- select --</option>
                                                </select>
                                                <label class="control-label" > &nbsp;)</label><span class="red"> * mandatory</span>
                                            </td>
                                        </tr>
                                        <!--new addition ends-->
                                        <tr>
                                            <td colspan="2">
                                                <input type="hidden" class="b" readonly value="<?php echo $land_details['dag_area_b']; ?>" style="width: 100px;" readonly>
                                                <input type="hidden" class="k" readonly value="<?php echo $land_details['dag_area_k']; ?>" style="width: 100px;" readonly>
                                                <input type="hidden" class="l" readonly value="<?php echo $land_details['dag_area_lc']; ?>" style="width: 100px;" readonly>
                                                <label class="control-label" > ১২) </label>
                                                <input type="text" name="conv_b" id="rb" readonly value="<?php echo $land_details['dag_area_b']; ?>" style="width: 100px;" readonly> <label class="control-label" >বিঃ </label>
                                                <input type="text" name="conv_k" id="rkatha" readonly value="<?php echo $land_details['dag_area_k']; ?>" style="width: 100px;" readonly> <label class="control-label" >কঃ </label> 
                                                <input type="text" name="conv_lc" id="rl" readonly value="<?php echo $land_details['dag_area_lc']; ?>" style="width: 100px;" readonly> <label class="control-label" >লেঃ </label>
                                                <label class="control-label" >&nbsp; মাটিৰ প্রিমিয়াম (&nbsp;বিঘাই প্রতি &nbsp; <span id="change_text" class="red"></span></label>
                                                <input type="text" name="total_premium" id="rk" style="width: 100px;" readonly><label class="control-label" >&nbsp; টকা &nbsp;)</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" > ১৩) অন্যান্য তথ্য ও মন্তব্য &nbsp;</label></td>
                                            <td><textarea name="lm_notice" class="form-control" cols="8" rows="8" required placeholder="লাট মন্ডলৰ প্রতিবেদন পৰীক্ষা কৰা হ'ল । প্ৰিমিয়াম আদায় মৰ্মে ম্যদীকৰনৰ হুকুম দিব পাৰে ।">লাট মন্ডলৰ প্রতিবেদন পৰীক্ষা কৰা হ'ল । প্ৰিমিয়াম আদায় মৰ্মে ম্যদীকৰনৰ হুকুম দিব পাৰে ।</textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > স্বাক্ষৰ (লাট মন্ডল) &nbsp;</label>
                                                <label>
                                                    <input type="radio" name="lm_sign" id="inlineRadio1" value="Y" checked>   <?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="lm_sign" id="inlineRadio2" value="N">  <?php echo $this->lang->line('no'); ?>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > লট মন্ডলৰ নাম &nbsp;</label>
                                                <input type="hidden" name="lm_code" value="<?php echo $land_details['lm_code']; ?>"/>
                                                <input type="text" name="lm_name" style="width: 200px;" value="<?php echo $land_details['lm_name']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" >তাৰিখ &nbsp;</label>
                                                <input type="text" name="date_of_entry" autocomplete="off" id="popupDatepicker" style="width: 200px;" required>
                                                &nbsp; (dd-mm-yyyy)
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <input type="hidden" name="case_no" value="<?php echo $land_details['case_no']; ?>"/>
                                <input type="hidden" name="dag_no" value="<?php echo $land_details['dag']; ?>"/>
                                <button type="submit" name="submit" class="btn btn-success uni_text"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                            </center>
                            <hr style="border-bottom: 2px solid #000;">
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
                            <hr>
                        </form>
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <a class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                                <button type="" class="btn btn-primary uni_text" value="1" onclick="modaldiva(this.value)" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/LMconversionPartha/GoToLM?pro=1"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
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
                                <td><label class="control-label"><?php echo $pattadar; ?></label>
                                <?php if($p->pdar_mobile) { ?> ( <i class="fa fa-mobile"></i> <?=$p->pdar_mobile?> ) <?php } ?>
                                </td>
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

<script>
$(document).ready(function() {
    $("#river_seide").hide();
    $("#jati_janajatie").hide();
    $("#freedom_fightere").hide();
    $("#widowe").hide();
    
    $('.jati_janajati').change(function () {
        if(this.checked) {
            $("#jati_janajatie").show();
            document.getElementById('change_text').innerHTML = '২৫% ৰেহাই পাচত';
        }
        else
        {
            $("#jati_janajatie").hide();
            document.getElementById('change_text').innerHTML = '';
        }
    });
    
    $('.freedom_fighter').change(function () {
        if(this.checked) {
            $("#freedom_fightere").show();
            document.getElementById('change_text').innerHTML = '২৫% ৰেহাই পাচত';
        }
        else
        {
            $("#freedom_fightere").hide();
            document.getElementById('change_text').innerHTML = '';
        }
    });
    
    $('.widow').change(function () {
        if(this.checked) {
            $("#widowe").show();
            document.getElementById('change_text').innerHTML = '২৫% ৰেহাই পাচত';
        }
        else
        {
            $("#widowe").hide();
            document.getElementById('change_text').innerHTML = '';
        }
    });
    
    $('.rv_side').change(function () {
        if(this.checked) {
            $("#river_seide").show();
        }
        else
        {
            $("#river_seide").hide();
        }
    });
    
    $('.get_premium_assessed').change(function () {
        var selected_value = $('.get_premium_assessed:checked').val();
        calculateLandRemaining();
        
        if(selected_value == 'withintown')
        {
            $(".townland").show();
            $(".when_none").hide();
            $(".w10km").hide();
            $(".w3km").hide();
            $(".withinrevenue").hide();
        }
        else if(selected_value == 'within3km')
        {
            $(".townland").hide();
            $(".when_none").hide();
            $(".w10km").hide();
            $(".w3km").show();
            $(".withinrevenue").hide();
        }
        else if(selected_value == 'within10km')
        {
            $(".townland").hide();
            $(".when_none").hide();
            $(".w10km").show();
            $(".w3km").hide();
            $(".withinrevenue").hide();
        }
        else if(selected_value == 'withinRev')
        {
            $(".townland").hide();
            $(".when_none").hide();
            $(".w10km").hide();
            $(".w3km").hide();
            $(".withinrevenue").show();
        }
    });
    
    function calculateLandRemaining(){
        var rastar_kaijo_b = $('.rastar_kaijo_b').val();
        var rastar_kaijo_k = $('.rastar_kaijo_k').val();
        var rastar_kaijo_lc = $('.rastar_kaijo_lc').val();
        var nodir_kaijo_b = $('.nodir_kaijo_b').val();
        var nodir_kaijo_k = $('.nodir_kaijo_k').val();
        var nodir_kaijo_lc = $('.nodir_kaijo_lc').val();
        
        window.rastarkakhorlessa = parseInt(rastar_kaijo_b) * 100 + parseInt(rastar_kaijo_k) * 20 + parseInt(rastar_kaijo_lc);
        console.log(window.rastarkakhorlessa);
        
        window.nodirkakhorlessa = parseInt(nodir_kaijo_b) * 100 + parseInt(nodir_kaijo_k) * 20 + parseInt(nodir_kaijo_lc);
        console.log(window.nodirkakhorlessa);
        
        var mbigha = $('.b').val();
        var mkatha = $('.k').val();
        var mlessa = $('.l').val();

        window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        console.log(window.originallessa);


        window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa;
        window.remaininglessa = originallessa - occupiedlessa;
        //alert(remaininglessa);

        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = remaininglessa - bigha_r * 100 - katha_r * 20;

        $('#rb').val(bigha_r);
        $('#rkatha').val(katha_r);
        $('#rl').val(lessa_r);
    }
    
    $('#cal_premium_a').change(function (e) {
        var percent = $(this).val();
        var bigha = $('#rb').val();
        var katha = $('#rkatha').val();
        var lessa = $('#rl').val();
        var zonal_rate = $('#zonal_rate').val();
        var jati_janajati = document.getElementById("jati_janajati").checked;
        var freedom_fighter = document.getElementById("freedom_fighter").checked;
        var widow = document.getElementById("widow").checked;
        //alert ( jati_janajati + '/' + freedom_fighter + '/' + widow);
        console.log("Changer");
        $.ajax({
            url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                $('#rk').val(result[0].premium);
            }
        });
    });
    $('#cal_premium_b').change(function (e) {
        var percent = $(this).val();
        var bigha = $('#rb').val();
        var katha = $('#rkatha').val();
        var lessa = $('#rl').val();
        var zonal_rate = $('#zonal_rate').val();
        var jati_janajati = document.getElementById("jati_janajati").checked;
        var freedom_fighter = document.getElementById("freedom_fighter").checked;
        var widow = document.getElementById("widow").checked;
        //alert (jati_janajati);
        console.log("Changer");
        $.ajax({
            url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                $('#rk').val(result[0].premium);
            }
        });
    });
    $('#cal_premium_c').change(function (e) {
        var percent = $(this).val();
        var bigha = $('#rb').val();
        var katha = $('#rkatha').val();
        var lessa = $('#rl').val();
        var zonal_rate = $('#zonal_rate').val();
        var jati_janajati = document.getElementById("jati_janajati").checked;
        var freedom_fighter = document.getElementById("freedom_fighter").checked;
        var widow = document.getElementById("widow").checked;
        //alert (jati_janajati);
        console.log("Changer");
        $.ajax({
            url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                $('#rk').val(result[0].premium);
            }
        });
    });
    $('#cal_premium_d').change(function (e) {
        var percent = $(this).val();
        var bigha = $('#rb').val();
        var katha = $('#rkatha').val();
        var lessa = $('#rl').val();
        var zonal_rate = $('#zonal_rate').val();
        var jati_janajati = document.getElementById("jati_janajati").checked;
        var freedom_fighter = document.getElementById("freedom_fighter").checked;
        var widow = document.getElementById("widow").checked;
        //alert (jati_janajati);
        console.log("Changer");
        $.ajax({
            url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                $('#rk').val(result[0].premium);
            }
        });
    });
    
});
</script>

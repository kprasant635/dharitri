<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">ভূমিলেখ্য সহায়কৰ প্ৰতিবেদন ( গোচৰ নং : <?php echo $land_details['case_no']; ?> )</h2>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-6 rasid text-left"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-3 rasid">( দাগ নং  : <?php echo $land_details['dag']; ?> )</label>
                            <label class="col-sm-3 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php if($basuCase){ ?>
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 div_new_applicant">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                            <style type="text/css">
                                input[type=text]{
                                    border: 1px solid #000;
                                }
                            </style>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #136a6f; color: white">
                                <span class="text-bold">Add New Applicant</span>
                            </div>
                            <form class="form-horizontal" id="nok_conv_applicant" method="post" >
                                <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
                                    <label class="uni_text control-label required"><?=$this->lang->line('applicants_name')?></label>
                                    <select style="border: 1px solid #000;" class="form-control" 
                                    name="appl_name_conv" id="appl_name_conv">
                                        <option selected disabled value="">Select Applicant</option>
                                    </select>
                                    <div id="error_appl_name_conv"></div>
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
                                    <label class="uni_text control-label required"><?=$this->lang->line('guardian_name') ?></label>
                                    <input type="text" class="form-control"
                                    name="guardian_name_conv" id="guardian_name_conv" autocomplete="off"
                                    placeholder="<?php echo $this->lang->line('guardian_name') ?>" maxlength="50">
                                    <div id="error_guardian_name_conv"></div>
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                    <label class="uni_text control-label required"><?=$this->lang->line('guardian_relation') ?></label>
                                    <select style="border: 1px solid #000;" class="form-control" 
                                    name="rel_conv" id="rel_conv">
                                        <option selected disabled value="">
                                        <?=$this->lang->line('select_relation')?></option>
                                        <?php foreach ($relation as $r): ?>
                                        <option value="<?=$r->guard_rel?>"><?=$r->guard_rel_desc_as?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="error_rel_conv"></div>
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
                                    <label class="uni_text control-label required"><?=$this->lang->line('gender')?></label>
                                    <select style="border: 1px solid #000;" class="form-control" 
                                    name="gender_conv" id="gender_conv">
                                        <option selected disabled value="">Select Gender</option>
                                        <?php foreach ($genders as $g): ?>
                                            <option value="<?=$g->short_name?>"><?=$g->gen_name_ass?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="error_gender_conv"></div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                                <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
                                    <label class="uni_text control-label"><?=$this->lang->line('date_of_birth') ?></label>
                                    <div class="input-group col-sm-12 date datepicker"
                                    data-date-format="dd-mm-yyyy">
                                        <input type="text" readonly class="form-control dating" id="dob_conv"
                                        placeholder="<?=$this->lang->line('date_of_birth')?>"
                                        name="dob_conv" autocomplete="off" />
                                    </div>
                                    <div id="error_dob_conv"></div>
                                </div>
                                <div class="col-md-5 col-lg-5 col-sm-4 col-xs-12">
                                    <label class="uni_text control-label required">Address</label>
                                    <input type="text" maxlength="100" class="form-control" 
                                    name="address_conv" id="address_conv" placeholder="Address">
                                    <div id="error_address_conv"></div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12"><br>
                                    <input type="hidden" id="case_no" value="<?=$land_details['case_no']?>"/>
                                    <input type="hidden" id="dag_no" value="<?=$land_details['dag']?>"/>
                                    <input type="hidden" id="patta_no" value="<?=$location['patta_no']?>"/>
                                    <input type="hidden" id="patta_type" value="<?=$land_details['patta_type']?>"/>
                                   
                                    <button type="button" class="btn btn-sm btn-warning uni_text btnAddNewConvAppl">
                                        <i class='fa fa-save'></i>&nbsp;Save & Add More</button>
                                </div>
                            </form>
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;</div>

                            <table width="100%" class="table table-striped table-bordered" style=" overflow:auto;">
                                <thead style="white-space:nowrap; ">
                                    <tr class="text-bold table-success">
                                        <th align='center'>#</th>
                                        <th>Applicant Name</th>
                                        <th>Guardian Name</th>
                                        <th>Relation</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="applicant_table_show_conv">
                                    <?php 
                                        $i=1; 
                                        foreach($pattadar as $row) : //get pattadar list
                                    ?>
                                            <tr>
                                                <td align='center'><?=$i?></td>
                                                <td><?=$row->pdar_name?></td>
                                                <td><?=$row->pdar_guardian?></td>
                                                <td><?=$this->utilityclass->get_relation($row->pdar_rel_guar)?></td>
                                                <td><?=$this->utilityclass->gender($row->pdar_gender)?></td>
                                                <td><?=$row->pdar_add1?> <br> <?=$row->pdar_add2?></td>
                                                <td>
                                                    <?php 
                                                        foreach($dup_pdar_id as $pid) : //get duplicate pdar_id
                                                            if($row->pdar_id == $pid->pdar_id) {
                                                    ?>
                                                        <button type="button" 
                                                        id="<?=$row->pdar_id?>,<?=$row->pdar_cron_no?>,<?=$pid->dag_no?>,<?=$pid->patta_no?>,<?=$pid->dist_code?>,<?=$pid->subdiv_code?>,<?=$pid->cir_code?>,<?=$pid->mouza_pargona_code?>,<?=$pid->lot_no?>,<?=$pid->vill_townprt_code?>,<?=$pid->patta_type_code?>"
                                                        class="btn btn-sm btn-danger btnDelApplConv">
                                                        <i class="fa fa-trash"></i></button>
                                                        
                                                    <?php } 
                                                        endforeach;  //end of get duplicate pdar_id                    
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php 
                                        $i++; 
                                        endforeach; //end of get pattadar list
                                    ?>
                                </tbody>
                            </table>
                            <div class="show_msg_add_appl_conv text-danger text-bold"></div>
                        </div>
                        <?php } ?>
                        <form class="form-horizontal unicode" method='post' 
                        action="<?php echo base_url($post_url); ?>"
                        enctype="multipart/form-data">                        
                            <div class="row">
                                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                            <?php if(!in_array($location['dist'], json_decode(BARAK_VALLEY))) { ?>
                                <input type="hidden" id="is_barak" value="0">
                            <?php } else { ?>
                                <input type="hidden" id="is_barak" value="1">
                            <?php } ?>
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
                                                    <!-- <?php foreach ($land_class as $land): ?>
                                                        <?php
                                                        $class_code = $land->class_code;
                                                        $land_type = $land->land_type;
                                                        ?>
                                                        <option value="<?php echo $class_code; ?>"><?php echo $land_type; ?></option>
                                                    <?php endforeach; ?> -->
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- added by hriday - 25-04-2024 -->
                                            <td colspan="2">
                                                <div style="display:flex;">
                                                    <label class="control-label" > ৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - &nbsp;</label>
                                                    <input type="text" name="rastar_kaijo_b" class="rastar_kaijo_b" style="width: 100px;" value="0"> বিঃ 
                                                    <input type="text" name="rastar_kaijo_k" class="rastar_kaijo_k" style="width: 100px;" value="0"> কঃ 
                                                    <input type="text" name="rastar_kaijo_lc" class="rastar_kaijo_lc" style="width: 100px;" value="0"> লেঃ
                                                    <select class="ml-2" name="rastarkakhoroldnew" id="rastarkakhoroldnew" style="display:none;">
                                                        <option value="">--Select--</option>
                                                        <option value="olddagreservation">Old Dag Reservation</option>
                                                        <option value="newdagreservation">New Dag Reservation</option>
                                                    </select>
                                                </div>
                                                <!-- end added -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ৭) উক্ত মাটি নদীৰ কাষৰ মাটি নেকি ? &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" class='rv_side' name='nodir_kakhor' value="Y"> &nbsp;
                                                <!-- added by hriday - 25-04-2024 -->
                                                <div id='river_seide' style="display:flex;">
                                                <!-- end added -->
                                                    পরিমাণ - 
                                                    <input type="text" name="nodir_kaijo_b" class="nodir_kaijo_b" style="width: 100px;" value="0"> বিঃ 
                                                    <input type="text" name="nodir_kaijo_k" class="nodir_kaijo_k" style="width: 100px;" value="0"> কঃ 
                                                    <input type="text" name="nodir_kaijo_lc" class="nodir_kaijo_lc" style="width: 100px;" value="0"> লেঃ
                                                    <!-- added by hriday - 25-04-2024 -->
                                                    <select class="ml-2" name="nodirkakhoroldnew" id="nodirkakhoroldnew" style="display:none;">
                                                        <option value="">--Select--</option>
                                                        <option value="olddagreservation">Old Dag Reservation</option>
                                                        <option value="newdagreservation">New Dag Reservation</option>
                                                    </select>
                                                    <!-- end added -->
                                                </div>
                                            </td>
                                        </tr>
                                        <!--new addition starts--->
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ৮) এইটো এটা আংশিক ৰূপান্তৰ নেকি ? &nbsp;</label>
                                                <input type="checkbox" id="inlineCheckbox1" class='partial' name='partial_conv' value="Y"> &nbsp;
                                                <div id='partial_conv'>
                                                    পরিমাণ - (স্থানান্তৰ নকৰা কালি)
                                                    <input type="text" name="partial_b" class="partial_b" style="width: 100px;" value="0"> বিঃ 
                                                    <input type="text" name="partial_k" class="partial_k" style="width: 100px;" value="0"> কঃ 
                                                    <input type="text" name="partial_lc" class="partial_lc" style="width: 100px;" value="0"> লেঃ
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্জনকাৰী সন্তান নাই অথবা উপাৰ্জনক্ষম ভূসম্পওি নাই / মুক্তিযোদ্ধা হয় তেন্তে মুঠ ম্যাদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব | যদিহে হ'য় তেন্তে তলত দিয়া ক,খ,গ 'ৰ পৰা বাচনী কৰক |</span></label>
                                                <ul>
                                                    <li>
                                                        <label class="control-label" > ৯) ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয়নে ? &nbsp;</label>
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
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্জনকাৰী সন্তান নাই অথবা উপাৰ্জনক্ষম ভূসম্পওি নাই ? &nbsp;</label>
                                                        <input type="checkbox" id="widow" class='widow' name='widow' value="Y"> &nbsp;
                                                        <div id='widowe' class="alert alert-info">
                                                            <span class="blue">&nbsp;&nbsp; প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                            <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename_widow"></span> 
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php if($rtps==BASUNDHARA_CHECK){ ?>
                                        <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">টোকা : ক্ৰ্মিক নং ৯, ১০ আৰু ১১ অতি গুরুত্বপূর্ণ / বাধ্যতামূলক |</span></label>
                                                <ul>
                                                    <!-- <li>
                                                        <label class="control-label"> ১০) i. উক্ত মাটি গ্ৰাম্য এলেকা মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinRev" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp; ii. উক্ত মাটি ৰাজহ নগৰ আৰু ইয়াৰ প্ৰান্তীয় এলেকা মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinRev" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; iii. উক্ত মাটি জিলাৰ মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ বাহিৰে আন চহৰবোৰৰ <br> পৰিধি অঞ্চল মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinRev" class="get_premium_assessed">
                                                    </li> -->
                                                    <?php if(($location['rural_urban']!='R') && ($rtps!='RTPS')){ ?>
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; iv. উক্ত মাটি জিলা মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধি অঞ্চল মাটি হয়নে? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within3km" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; v. উক্ত মাটি জিলা মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ <br> পৰিধি অঞ্চল (চহৰৰ পৰিসীমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে) ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within10km" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; v. &nbsp; সকলো পৌৰ নিগম/পৌৰ নিগমৰ ভিতৰত এলেকাবোৰ পৰি আছে নেকি? &nbsp; </label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withintown" class="get_premium_assessed">
                                                    </li> -->
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    
                                        
                                    <?php } else { ?>
                                        <!-- <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">টোকা : ক্ৰ্মিক নং ৯, ১০ আৰু ১১ অতি গুরুত্বপূর্ণ / বাধ্যতামূলক |</span></label>
                                                <ul>
                                                    <li>
                                                        <label class="control-label"> ১০) ক. উক্ত মাটি নগৰ/চহৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withintown" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; খ. আবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within3km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. আবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিসীমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within10km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঘ. <span class="red">(গাওঁৰ মাটি হয়নে ?)</span> &nbsp; আবেদিত মাটি চহৰ অথবা চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধ আৰু গুৱাহাটী <br>পৌৰনিগোম পৰিসীমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ বাহিৰৰ মাটি হয়নে ? &nbsp; </label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinRev" class="get_premium_assessed">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr> -->

                                         <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">১০) টোকা : ক্ৰ্মিক নং ৯, ১০ আৰু ১১ অতি গুরুত্বপূর্ণ / বাধ্যতামূলক |</span></label>
                                                <ul>
                                                
                                                    <?php
                                                        $sl=1;
                                                        foreach ($premium_areas as $key => $value) {?>
                                                            <li>
                                                                <label for="" class="control-label"><?php echo $sl++ . ') ' . $value->ass_name; ?></label>
                                                                <input type="radio" name="whetherOr" id="" value="<?php echo $value->id; ?>" class="get_premium_assessed">
                                                            </li>
                                                        <?php }
                                                    ?>
                                                    <!-- <li>
                                                        <label class="control-label"> ১০) ক. গাওঁৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinrural" class="get_premium_assessed">
                                                    </li> -->

                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; খ. ৰাজহ নগৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinrevenuetown" class="get_premium_assessed">
                                                    </li> -->
                                                    
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. আবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within3km" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঘ. জিলা সদৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া, পলাশবাৰী নগৰ আৰু পৌৰ নগৰ/নিগম মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withintown" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঙ. জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withintown5km" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; চ. পৌৰ নগৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinmunicipal" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ছ. পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinmunicipal5km" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; জ. গুৱাহাটী মহানগৰী মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinghy" class="get_premium_assessed">
                                                    </li> -->
                                                    <!-- <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঝ. গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে ? &nbsp; </label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="within15km" class="get_premium_assessed">
                                                    </li> -->
                                                </ul>
                                            </td>
                                        </tr>
                                        
                                    <?php } ?>
                                        <tr>
                                            <td colspan="2">
                                                <?php $zonalValue=$this->utilityclass->getZonalValue($location['distcode'],$location['uuid'],$land_details['dag']);?>
                                                <label class="control-label" > ১১) মাটিৰ মান্ডলিক মুল্য (&nbsp;বিঘাই প্রতি &nbsp;</label>
                                                <?php if($zonalValue==null){ ?>
                                                    <span class="red"> <b>Plese add zonal value before proceed.</b> </span> )
                                                <?php } else { ?>
                                                    <input readonly type="number" name="each_bigha_rate" id="zonal_rate" style="width: 100px;" required value="<?php echo $zonalValue ?>"> <label class="control-label" >&nbsp; টকা &nbsp;)</label><span class="red"> * mandatory</span>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ১২) মাটিৰ প্রিমিয়াম Assesment Type(&nbsp;বিঘাই প্রতি - </label>
                                                <input type="hidden" id="premium_assesment_type" name="premium_assesment_type" value="">
                                                    <select name="premium_assesment" id="" class="cal_premium_e" required>
                                                        <option value="">---Select Assesment Type---</option>
                                                        <?php
                                                            foreach ($premium_area_purpose as $key => $value) { ?>
                                                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                            <?php }
                                                        ?>
                                                    </select>
                                                <!-- <select name="premium_assesment" class="townland cal_premium_e" required  style="display:none;" id="cal_premium_a">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="100">100% per bigha land value for Occupied portion of the AP land that remains with the pattadar after transfer of AP land (Residential Purpose).</option>
                                                    <option value="50">50% per bigha land value for Residential Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    
                                                </select> -->
                                                <!-- <select name="premium_assesment" class="w3km cal_premium_e" required  style="display:none;" id="cal_premium_b">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                    <option value="75">75% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="20">Premium @ 20 Rs of per bigha land value for Agriculture Purpose</option> -->
                                                    <!-- <option value="50">50% per bigha land value for Residential Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="50">50% per bigha land value for Agriculture Purpose</option> -->
                                                    <!-- <option value="15">Premium @ 15% of per bigha land value.</option> -->
                                                <!-- </select> -->
                                                <!-- <select name="premium_assesment" class="w10km cal_premium_e" required  style="display:none;" id="cal_premium_c">
                                                    <option selected disabled>-- select --</option> -->
                                                    <!-- <option value="25">Premium @ 25% of per bigha land value.</option> -->
                                                    <!-- <option value="50">50% per bigha land value for Residential Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="50">50% per bigha land value for Agriculture Purpose</option> 

                                                </select> -->
                                                <!-- <select name="premium_assesment" class="withinrevenue cal_premium_e" required  style="display:none;" id="cal_premium_d">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="0">Premium Free</option> -->
                                                    <!-- <?php if($basuCase) { ?>
                                                        <option value="0">Premium Free As it is Basundhara registered Case</option>
                                                    <?php } ?>
                                                    <option value="20">Premium @ 20 Rs of per bigha land value for Agricultural Purpose.</option>
                                                    <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option> -->
                                                <!-- </select> -->

                                                <!-- <select name="premium_assesment" class="withinrevenuetown cal_premium_e" required  style="display:none;">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                    <option value="75">75% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                            
                                                </select> -->

                                                <!-- <select name="premium_assesment" class="withintown5km cal_premium_e" required  style="display:none;">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="15">15% per bigha land value for Residential Purpose.</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="15">15% per bigha land value for Agriculture Purpose</option>
                            
                                                </select> -->

                                                <!-- <select name="premium_assesment" class="withinmunicipal cal_premium_e" required  style="display:none;">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="100">100% per bigha land value for Occupied portion of the AP land that remains with the pattadar after transfer of AP land (Residential Purpose).</option>
                                                    <option value="50">50% per bigha land value for Residential Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    
                                                </select> -->

                                                <!-- <select name="premium_assesment" class="withinmunicipal5km cal_premium_e" required  style="display:none;">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                    <option value="75">75% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="20">Premium @ 20 Rs of per bigha land value for Agriculture Purpose</option>
                                                    
                                                </select> -->

                                                <!-- <select name="premium_assesment" class="withinghy cal_premium_e" required  style="display:none;">
                                                    <option selected disabled>-- select --</option>
                                                    <option value="100">100% per bigha land value for Occupied portion of the AP land that remains with the pattadar after transfer of AP land (Residential Purpose).</option>
                                                    <option value="50">50% per bigha land value for Residential Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    
                                                </select> -->

                                                <!-- <select name="premium_assesment" class="within15km cal_premium_e" required  style="display:none;">
                                                    <option selected disabled>-- select --</option> -->
                                                    <!-- <option value="25">Premium @ 25% of per bigha land value.</option> -->
                                                    <!-- <option value="25">25% per bigha land value for Residential Purpose</option>
                                                    <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                    <option value="25">25% per bigha land value for Agriculture Purpose</option> 

                                                </select> -->
                                                
                                                <!-- <select name="premium_assesment" class="when_none" required>
                                                    <option selected disabled>-- select --</option>
                                                </select> -->
                                                <label class="control-label" > &nbsp;)</label><span class="red"> * mandatory</span>
                                            </td>
                                        </tr>
                                        <!--new addition ends-->
                                        <tr>
                                            <td colspan="2">
                                                <input type="hidden" class="b" readonly value="<?php echo $land_details['o_dag_area_b']; ?>" style="width: 100px;" readonly>
                                                <input type="hidden" class="k" readonly value="<?php echo $land_details['o_dag_area_k']; ?>" style="width: 100px;" readonly>
                                                <input type="hidden" class="l" readonly value="<?php echo $land_details['o_dag_area_lc']; ?>" style="width: 100px;" readonly>
                                                <label class="control-label" > ১৩) </label>

                                                <!-- <input type="text" name="conv_b" id="rb" readonly value="<?php //echo $land_details['dag_area_b']; ?>" style="width: 100px;" readonly>  -->

                                                <input type="text" name="conv_b" id="rb" readonly value="<?php echo $land_details['o_dag_area_b']; ?>" style="width: 100px;" readonly>
                                                
                                                <label class="control-label" >বিঃ </label>

                                                <!-- <input type="text" name="conv_k" id="rkatha" readonly value="<?php //echo $land_details['dag_area_k']; ?>" style="width: 100px;" readonly> -->

                                                <input type="text" name="conv_k" id="rkatha" readonly value="<?php echo $land_details['o_dag_area_k']; ?>" style="width: 100px;" readonly>

                                                <label class="control-label" >কঃ </label> 

                                                <!-- <input type="text" name="conv_lc" id="rl" readonly value="<?php //echo $land_details['dag_area_lc']; ?>" style="width: 100px;" readonly> -->

                                                <input type="text" name="conv_lc" id="rl" readonly value="<?php echo $land_details['o_dag_area_lc']; ?>" style="width: 100px;" readonly>

                                                <?php if(in_array($location['dist'], json_decode(BARAK_VALLEY))): ?>
                                                    <input type="text" name="conv_g" id="rg" readonly value="<?php echo $land_details['o_dag_area_g']; ?>" style="width: 100px;" readonly>
                                                <?php endif; ?>

                                                <label class="control-label" >লেঃ </label>
                                                <label class="control-label" >&nbsp; মাটিৰ প্রিমিয়াম (&nbsp; <span id="change_text" class="red"></span></label>
                                                <input type="text" name="total_premium" id="rk" style="width: 100px;" readonly><label class="control-label" >&nbsp; টকা &nbsp;) <a href="<?= base_url(); ?>/assets/Premium.pdf" target="_blank">View Premium Notice </a></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" > ১৪) অন্যান্য তথ্য ও মন্তব্য &nbsp;</label></td>
                                            <td><textarea name="lm_notice" class="form-control" cols="8" rows="8" required placeholder="ভূমিলেখ্য সহায়কৰ প্রতিবেদন পৰীক্ষা কৰা হ'ল । প্ৰিমিয়াম আদায় মৰ্মে ম্যাদীকৰনৰ হুকুম দিব পাৰে ।">ভূমিলেখ্য সহায়কৰ প্রতিবেদন পৰীক্ষা কৰা হ'ল । প্ৰিমিয়াম আদায় মৰ্মে ম্যাদীকৰনৰ হুকুম দিব পাৰে ।</textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > স্বাক্ষৰ (ভূমিলেখ্য সহায়ক) &nbsp;</label>
                                                <label>
                                                    <input type="radio" name="lm_sign" id="inlineRadio1" value="Y" checked>   <?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="lm_sign" id="inlineRadio2" value="N">  <?php echo $this->lang->line('no'); ?>
                                                </label>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="patta_type_code" id="patta_type_code" value="<?php echo $location['patta_type']; ?>">
                                        <?php if($location['patta_type'] == '0208') { ?>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > Is the Nisfi Kheraz land transferred? &nbsp;</label>
                                                <label>
                                                    <input type="radio" name="land_trans" id="land_trans_y" value="Y" checked><?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="land_trans" id="land_trans_n" value="N">  <?php echo $this->lang->line('no'); ?>
                                                </label>
                                               <label class="control-label" ><a href="<?= base_url(); ?>assets/nisfi_kheraz_notice.pdf" target="_blank">View Nisfi Kheraz Notice </a></label>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > ভূমিলেখ্য সহায়কৰ নাম &nbsp;</label>
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
                            <!-- Added by hriday - 25-04-2024 -->
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pattadar Name</th>
                                                <th>Pattadar Guardian Name</th>
                                                <th>Inplace / AlongWith</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($pattadar as $pdar): ?>
                                                <tr>
                                                    <td><?php echo $pdar->pdar_name; ?></td>
                                                    <td><?php echo $pdar->pdar_guardian; ?></td>
                                                    <td><select name="inplacealong<?php echo $pdar->pdar_id; ?>" class="form-control">
                                                        <option value="inplace">Inplace</option>
                                                        <option value="alongwith">Alongwith</option>
                                                    </select></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php include(APPPATH.'views/multipleUpload.php')?>
                            <!-- end added -->
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 required  control-label">Upload <?=NOC?> from Pattadar</label>
                                <div class="col-lg-3">
                                    <input type='file' name="up_noc_conv" id="up_noc_conv" required>
                                </div>
                                <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                            </div>
                            <?php if($location['patta_type'] == '0208') { ?>
                            <div class="form-group">
                                <label for="" class="col-lg-3 required  control-label">Upload Nisfi Kheraz Document</label>
                                <div class="col-lg-3">
                                    <input type='file' name="up_doc" id="up_doc" required>
                                </div>
                                <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                            </div>
                            <?php } ?>                 
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <input type="hidden" name="case_no" value="<?php echo $land_details['case_no']; ?>"/>
                                <input type="hidden" name="dag_no" value="<?php echo $land_details['dag']; ?>"/>
                                <!-- added by hriday - 25-04-2024 -->
                                <input type="hidden" name="is_partial" value="<?php echo $is_partial; ?>">
                                <!-- end added -->
                                <button type="submit" name="submit" class="btn btn-success uni_text btnSubmit"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
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
                                else{
                                    echo '<h2 class="red">Other Attachments</h2>';
                                    foreach($supportiveDocs as $docs):
                                    ?>
                                        <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
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
                                <?php if($basuCase && $rtps==null){ ?>
                                    <button type="button" class="btn btn-success btnAddApplicant uni_text"><i class="fa fa-user"></i>
                                    &nbsp;Add New Applicant</button>
                                <?php } ?>

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
                                <th>AADHAAR/PAN Status</th>
                            </tr>
                        </thead>
                        <?php $count = 1; ?>
                        <?php

                        $params = [
                          'case_no'          => $location['case_no'],
                          'service_code'     => 9,
                          'remarks'          => 'Conversion',
                          'accessed_entity'  => 'Aadhaar Status Check',
                        ];
                        // $this->load->model('EkycLogModel');
                        // $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


                        foreach ($pattadar as $p):
                            $flag = 'N/A';
                            if($p->auth_type == 'AADHAAR'){
                                $flag = 'AADHAAR Verified';
                            }else if($p->auth_type == 'PAN'){
                                $flag = 'PAN Verified';
                            }
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
                                <td><?=$flag;?></td>
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
<!--div 2-->
<?php if(!empty($basuCase) && $rtps!=null && !empty($lm_details_final) ){ ?>
<div id="notice2 panel" >
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
                                <td colspan="2"><label class="control-label" >৪) উক্ত মাটিৰ শ্রেণী - <?php echo $this->utilityclass->getLandClassCode($lm->land_class_code); ?></label></td>
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
                                <td colspan="2"><label class="control-label">৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ - <?php echo $lm->roadside_rsv_b; ?> বিঃ, <?php echo $lm->roadside_rsv_k; ?> কঃ, <?php echo $lm->roadside_rsv_lc; ?> লেঃ </label></td>
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
                                <td colspan="2"><label class="control-label" >
                                    ৯) 
                                    <?php
                                    if (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'i')) {
                                        echo "উক্ত মাটি নগৰ/চহৰৰ মাটি হয়নে - হয়";
                                    } elseif (($lm->dist_frm_town == '3') && ($lm->inside_outside_town == 'i')) {
                                        echo "অবেদিত মাটি চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                    } elseif (($lm->dist_frm_town == '10') && ($lm->inside_outside_town == 'i')) {
                                        echo "অবেদিত মাটি গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে - হয়";
                                    } elseif (($lm->dist_frm_town == '15') && ($lm->inside_outside_town == 'i')) {
                                        echo "অবেদিত মাটি গুৱাহাটী মহানগৰৰ পৰিধিৰ পৰা 15 কিলোমিটাৰ দূৰত আৰু জিলা হেডকুৱেটাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পালাচবাৰী চহৰৰ পৰা 5 কিলোমিটাৰ ব্যাসাৰ্ধৰ ভিতৰত মাটি হয়নে ? - হয়";
                                    } elseif(($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'i')) {
                                        echo 'জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী,
                                        ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়';
                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'd')) {
                                        echo "অবেদিত মাটি জিলা হেড কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ অন্তৰ্গত এলেকাসমূহ মাটি হয়নে - হয়";
                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'o')) {
                                        echo "অবেদিত মাটি গাওৰ মাটি হয়নে - হয়";
                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'm')) {
                                        echo 'পৌৰ নগৰ মাটি হয়নে - হয়';
                                    } elseif (($lm->dist_frm_town == '5') && ($lm->inside_outside_town == 'm')) {
                                        echo 'পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে - হয়';
                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'g')){
                                        echo 'গুৱাহাটী মহানগৰী মাটি হয়নে - হয়';
                                    } elseif (($lm->dist_frm_town == '15') && ($lm->inside_outside_town == 'g')){
                                        echo 'গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে - হয়';
                                    } elseif (($lm->dist_frm_town == '0') && ($lm->inside_outside_town == 'r')) {
                                        echo 'ৰাজহ নগৰ মাটি হয়নে - হয়';
                                    } elseif (($lm->inside_outside_town != 'i')) {
                                        echo "অবেদিত মাটি চহৰ অথবা চহৰৰ পৰিহিমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধ আৰু গুৱাহাটী পৌৰনিগোম পৰিহিমাৰ পৰা 10 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ বাহিৰৰ মাটি হয়নে (গাওৰ মাটি হয়নে ?) - হয়";
                                    }
                                    ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><label class="control-label">১০) বিঘাই প্রতি <span style="color: red;"><?php echo round($lm->prim_per_bigha, 2); ?></span> টকা হাৰে <span style="color: red;"><?php echo $lm->conv_b; ?></span> বিঃ <span style="color: red;"><?php echo $lm->conv_k; ?></span> কঃ <span style="color: red;"><?php echo round($lm->conv_lc, 2); ?></span> লেঃ মাটিৰ মুঠ প্রিমিয়াম <span style="color: red;"><?php echo $msg." ".round($lm->prim_tot, 2); ?></span> টকা</label></td>
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
                            <tr class="hide">
                                <td colspan="2">
                                    <label class="control-label">১৩) লাঃ মঃ ৰ নাম &nbsp; - <?php echo $lm->lm_code; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label class="control-label">১৪) লাঃ মঃ এ টোকা লিখাৰ তাৰিখ &nbsp; - <?php echo date('d-m-Y', strtotime($lm->date_entry)); ?></label>
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
<?php } ?>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>
$('.btnSubmit').click(function(){
    if($('#up_noc_conv').val()==0){
        alert("NOC upload is mandatory");
        $('#up_noc_conv').focus();
        return false;
    }
    //added by hriday - 25-04-2024
    var patta_type_code = $('#patta_type_code').val();
    if(patta_type_code == '0208') {
        if($('#up_doc').val()==0) {
            alert("Nispi Kheraz Document Mandatory for Nispi Kheraz Land");
            $('#up_doc').focus();
            return false;
        }
    }
    var rastarkaijob = $('.rastar_kaijo_b').val();
    var rastarkaijok = $('.rastar_kaijo_k').val();
    var rastarkaijolc = $('.rastar_kaijo_lc').val();
    var nodirkaijob = $('.nodir_kaijo_b').val();
    var nodirkaijok = $('.nodir_kaijo_k').val();
    var nodirkaijolc = $('.nodir_kaijo_lc').val();
    var ispartial = <?php echo $is_partial; ?>;

    if(ispartial == 1 && (rastarkaijob != 0 || rastarkaijok != 0 || rastarkaijolc != 0)) {
        if($('#rastarkakhoroldnew').val() == '') {
            alert("Roadside Old / New Dag reservation field is a required field");
            return false;
        }
    }
    if(ispartial == 1 && (nodirkaijob != 0 || nodirkaijok != 0 || nodirkaijolc != 0)) {
        if($('#nodirkakhoroldnew').val() == '') {
            alert("Riverside Old / New Dag reservation field is a required field");
            return false;
        }
    }
    //end added
});
$(document).ready(function() {
    $("#river_seide").hide();
    $("#partial_conv").hide();
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

    $('.partial').change(function () {
        if(this.checked) {
            $("#partial_conv").show();
        }
        else
        {
            $("#partial_conv").hide();
        }
    });

    
    //code designed by MRI009 : 21092023-------------//
    $('[name="rastar_kaijo_b"],[name="rastar_kaijo_k"],[name="rastar_kaijo_lc"]').change(function(){
        $('[name="premium_assesment"]').val('');
        //$('[name="premium_assesment"]').hide();
        $('.when_none').show();
        $('.get_premium_assessed').prop('checked', false);
        $('#rk').val('');
        //added by hriday - 25-04-2024
        var rastarkaijob = $('.rastar_kaijo_b').val();
        var rastarkaijok = $('.rastar_kaijo_k').val();
        var rastarkaijolc = $('.rastar_kaijo_lc').val();
        var ispartial = <?php echo $is_partial; ?>;
        if(ispartial == 1 && (rastarkaijob != 0 || rastarkaijok != 0 || rastarkaijolc != 0)) {
            $('#rastarkakhoroldnew').attr({style: 'display:block;', disabled: false, required: true});
        }
        else{
            $('#rastarkakhoroldnew').val('');
            $('#rastarkakhoroldnew').attr({style: 'display:none;', disabled: true, required: false});
        }
        // end added
    });
    

    $('[name="nodir_kaijo_b"],[name="nodir_kaijo_k"],[name="nodir_kaijo_lc"]').change(function(){
        $('[name="premium_assesment"]').val('');
        // $('[name="premium_assesment"]').hide();
        $('.when_none').show();
        $('.get_premium_assessed').prop('checked', false);
        $('#rk').val('');
        //added by hriday - 25-04-2024
        var nodirkaijob = $('.nodir_kaijo_b').val();
        var nodirkaijok = $('.nodir_kaijo_k').val();
        var nodirkaijolc = $('.nodir_kaijo_lc').val();
        var ispartial = <?php echo $is_partial; ?>;

        if(ispartial == 1 && (nodirkaijob != 0 || nodirkaijok != 0 || nodirkaijolc != 0)) {
            $('#nodirkakhoroldnew').attr({style: 'display:block;', disabled: false, required: true});
        }
        else{
            $('#nodirkakhoroldnew').val('');
            $('#nodirkakhoroldnew').attr({style: 'display:none;', disabled: true, required: false});
        }
        //end added
    });

    $('[name="partial_b"],[name="partial_k"],[name="partial_lc"]').change(function(){
        $('[name="premium_assesment"]').val('');
        $('.get_premium_assessed').prop('checked', false);
    });

    //END validation check---------

    $('.get_premium_assessed').change(function() {
        var selected_value = $('.get_premium_assessed:checked').val();
        // console.log(selected_value);
        $('#premium_assesment_type').val('');
        $('select[name="premium_assesment"]').val('');
        $('#rk').val('');
        calculateLandRemaining();
    });

    
    // $('.get_premium_assessed').change(function () {
    //     var selected_value = $('.get_premium_assessed:checked').val();
    //     $('#rk').val('');
    //     calculateLandRemaining();
        
    //     if(selected_value == 'withintown')
    //     {
    //         $(".townland").show();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'within3km')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").show();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'withinrural')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").show();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'within10km')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").show();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
        
    //     else if(selected_value == 'withinRev')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").show();
    //         $('#rk').val(0);
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'withinrevenuetown')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").show();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'withintown5km')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").show();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'withinmunicipal')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").show();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'withinmunicipal5km')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").show();
    //         $(".withinghy").hide();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'withinghy')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").show();
    //         $(".within15km").hide();
    //     }
    //     else if(selected_value == 'within15km')
    //     {
    //         $(".townland").hide();
    //         $(".when_none").hide();
    //         $(".w10km").hide();
    //         $(".w3km").hide();
    //         $(".withinrevenue").hide();
    //         $(".withinrevenuetown").hide();
    //         $(".withintown5km").hide();
    //         $(".withinmunicipal").hide();
    //         $(".withinmunicipal5km").hide();
    //         $(".withinghy").hide();
    //         $(".within15km").show();
    //     }
    // });
    
    function calculateLandRemaining(){
        var rastar_kaijo_b = $('.rastar_kaijo_b').val();
        var rastar_kaijo_k = $('.rastar_kaijo_k').val();
        var rastar_kaijo_lc = $('.rastar_kaijo_lc').val();
        var nodir_kaijo_b = $('.nodir_kaijo_b').val();
        var nodir_kaijo_k = $('.nodir_kaijo_k').val();
        var nodir_kaijo_lc = $('.nodir_kaijo_lc').val();

        var partial_b = $('.partial_b').val();
        var partial_k = $('.partial_k').val();
        var partial_lc = $('.partial_lc').val();
        
        window.rastarkakhorlessa = parseInt(rastar_kaijo_b) * 100 + parseInt(rastar_kaijo_k) * 20 + parseFloat(rastar_kaijo_lc);
        // console.log(window.rastarkakhorlessa);
        
        window.nodirkakhorlessa = parseInt(nodir_kaijo_b) * 100 + parseInt(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
        // console.log(window.nodirkakhorlessa);

        window.partiallessa = parseInt(partial_b) * 100 + parseInt(partial_k) * 20 + parseFloat(partial_lc);
        // console.log(window.partiallessa);
        //alert(partiallessa);
        
        var mbigha = $('.b').val();
        var mkatha = $('.k').val();
        var mlessa = $('.l').val();

        //window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseFloat(mlessa);
        // console.log(window.originallessa);
        // alert(originallessa);
        window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
        window.remaininglessa = originallessa - occupiedlessa;

        if(originallessa <= rastarkakhorlessa){
            alert("Road side reservation can't be greater then original land");
            $('.rastar_kaijo_b').val("0");
            $('.rastar_kaijo_k').val("0");
            $('.rastar_kaijo_lc').val("0");
            window.rastarkakhorlessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= nodirkakhorlessa){
            alert("River side reservation can't be greater then original land");
            $('.nodir_kaijo_b').val("0");
            $('.nodir_kaijo_k').val("0");
            $('.nodir_kaijo_lc').val("0");
            window.nodirkakhorlessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= partiallessa){
            alert("Partial land can't be greater then original land");
            $('.partial_b').val("0");
            $('.partial_k').val("0");
            $('.partial_lc').val("0");
            window.partiallessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= occupiedlessa){
            alert("Total Reservation land can't be greater then original land");
            $('.rastar_kaijo_b').val("0");
            $('.rastar_kaijo_k').val("0");
            $('.rastar_kaijo_lc').val("0");
            $('.nodir_kaijo_b').val("0");
            $('.nodir_kaijo_k').val("0");
            $('.nodir_kaijo_lc').val("0");
            $('.partial_b').val("0");
            $('.partial_k').val("0");
            $('.partial_lc').val("0");
            window.rastarkakhorlessa=0;
            window.nodirkakhorlessa=0;
            window.partiallessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }

      
        //alert(remaininglessa);

        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2);

        console.log(bigha_r, katha_r, lessa_r);

        $('#rb').val(bigha_r);
        $('#rkatha').val(katha_r);
        $('#rl').val(lessa_r);
    }

    $('.cal_premium_e').change(function (e) {
        var baseurl = $('#baseurl').val();
        var is_barak = $('#is_barak').val();//
        var area_purpose_type = $(this).val();
        var area = $('.get_premium_assessed:checked').val();
        // console.log(area_purpose_type, area);
        // $('#premium_assesment_type').val(percent);
        var bigha = $('#rb').val();
        var katha = $('#rkatha').val();
        var lessa = $('#rl').val();
        if(is_barak == '1') {
            var ganda = $('#rg').val();
        }
        else {
            var ganda = '0';
        }
        var zonal_rate = $('#zonal_rate').val();
        var jati_janajati = document.getElementById("jati_janajati").checked;
        var freedom_fighter = document.getElementById("freedom_fighter").checked;
        var widow = document.getElementById("widow").checked;

        if(zonal_rate <= 0 || zonal_rate == '') {
            alert("Error!!..Zonal Rate is not available");
            return false;
        }
        if(area == '' || area_purpose_type == '' || area == undefined || area_purpose_type == undefined) {
            alert("Required field no 10 and 12 are empty!");
            return false;
        }
        console.log(is_barak, area_purpose_type, bigha, katha, lessa, ganda, zonal_rate, jati_janajati, freedom_fighter, widow);
        $.ajax({
            url: baseurl + `index.php/calculate_premium_mb3`,
            method: 'POST',
            dataType: 'JSON',
            data: {is_barak:is_barak, area:area, area_purpose_type:area_purpose_type, bigha:bigha, katha:katha, lessa:lessa, ganda:ganda, zonal_rate:zonal_rate, jati_janajati:jati_janajati, freedom_fighter:freedom_fighter, widow:widow},
            success: function (response) {
                $('#rk').val(response[0].premium);
                $('#premium_assesment_type').val(response[0].premium_percent_amount);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    
    // $('#cal_premium_a').change(function (e) {

    //     var percent = $(this).val();
    //     var bigha = $('#rb').val();
    //     var katha = $('#rkatha').val();
    //     var lessa = $('#rl').val();
    //     var zonal_rate = $('#zonal_rate').val();
    //     var jati_janajati = document.getElementById("jati_janajati").checked;
    //     var freedom_fighter = document.getElementById("freedom_fighter").checked;
    //     var widow = document.getElementById("widow").checked;
    //     //alert ( jati_janajati + '/' + freedom_fighter + '/' + widow);
    //     console.log("Changer");
    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
    //             success: function (data) {
    //                 console.log(data);
    //                 var result = JSON.parse(data);
    //                 $('#rk').val(result[0].premium);
    //             }
    //         });
    //     }
    //     else {
    //         alert("Error!!..Zonal Rate is not available");
    //     }
    // });
    // $('#cal_premium_b').change(function (e) {
    //     var percent = $(this).val();
    //     var bigha = $('#rb').val();
    //     var katha = $('#rkatha').val();
    //     var lessa = $('#rl').val();
    //     var zonal_rate = $('#zonal_rate').val();
    //     var jati_janajati = document.getElementById("jati_janajati").checked;
    //     var freedom_fighter = document.getElementById("freedom_fighter").checked;
    //     var widow = document.getElementById("widow").checked;
    //     //alert (jati_janajati);
    //     console.log("Changer");
    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
    //             success: function (data) {
    //                 console.log(data);
    //                 var result = JSON.parse(data);
    //                 $('#rk').val(result[0].premium);
    //             }
    //         });
    //     }
    //     else {
    //         alert("Error!!..Zonal Rate is not available");
    //     }
    // });
    // $('#cal_premium_c').change(function (e) {
    //     var percent = $(this).val();
    //     var bigha = $('#rb').val();
    //     var katha = $('#rkatha').val();
    //     var lessa = $('#rl').val();
    //     var zonal_rate = $('#zonal_rate').val();
    //     var jati_janajati = document.getElementById("jati_janajati").checked;
    //     var freedom_fighter = document.getElementById("freedom_fighter").checked;
    //     var widow = document.getElementById("widow").checked;
    //     //alert (jati_janajati);
    //     console.log("Changer");
    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
    //             success: function (data) {
    //                 console.log(data);
    //                 var result = JSON.parse(data);
    //                 $('#rk').val(result[0].premium);
    //             }
    //         });
    //     }
    //     else {
    //         alert("Error!!..Zonal Rate is not available");
    //     }
    // });
    // $('#cal_premium_d').change(function (e) {
    //     var percent = $(this).val();
    //     var bigha = $('#rb').val();
    //     var katha = $('#rkatha').val();
    //     var lessa = $('#rl').val();
    //     var zonal_rate = $('#zonal_rate').val();
    //     var jati_janajati = document.getElementById("jati_janajati").checked;
    //     var freedom_fighter = document.getElementById("freedom_fighter").checked;
    //     var widow = document.getElementById("widow").checked;
    //     //alert (jati_janajati);
    //     console.log("Changer");
    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
    //             success: function (data) {
    //                 console.log(data);
    //                 var result = JSON.parse(data);
    //                 $('#rk').val(result[0].premium);
    //             }
    //         });
    //     }
    //     else {
    //         alert("Error!!..Zonal Rate is not available");
    //     }
    // });

    // $('.cal_premium_e').change(function (e) {
    //     var percent = $(this).val();
    //     var bigha = $('#rb').val();
    //     var katha = $('#rkatha').val();
    //     var lessa = $('#rl').val();
    //     var zonal_rate = $('#zonal_rate').val();
    //     var jati_janajati = document.getElementById("jati_janajati").checked;
    //     var freedom_fighter = document.getElementById("freedom_fighter").checked;
    //     var widow = document.getElementById("widow").checked;
    //     //alert (jati_janajati);
    //     console.log("Changer");
    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + "LMconversionPartha/Calculate_premium/" + percent + '/' + bigha + '/' + katha + '/' + lessa + '/' + zonal_rate + '/' + jati_janajati + '/' + freedom_fighter + '/' + widow,
    //             success: function (data) {
    //                 console.log(data);
    //                 var result = JSON.parse(data);
    //                 $('#rk').val(result[0].premium);
    //             }
    //         });
    //     }
    //     else {
    //         alert("Error!!..Zonal Rate is not available");
    //     }
    // });


    $('.div_new_applicant').hide();

    //open up applicant add div
    $('.btnAddApplicant').on('click', function(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        case_no = $('#case_no').val();
        $.ajax({
            url: baseurl + "LMconversionPartha/popUpNewApplicantConv",
            method: "POST",
            data: {case_no:case_no},
            dataType: "json",
            success: function (data) {
                $.unblockUI();
                $('.div_new_applicant').show();
                if(data.success == 'true'){
                    reset();
                    var template = '<option selected disabled value="">Select Applicant</option>';
                    $.each(data.applicants, function (index, val) {
                        template += '<option value='+val["pdar_id"]+'>'+val["pdar_name"]+' </option>'
                    });
                    $('#appl_name_conv').html(template);
                }
            },
            error: function(data) {
                $.unblockUI();
                alert("Something went wrong");
            }
        });
    });

    //on change applicant get respective details available in form
    $('#appl_name_conv').on('change', function(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        case_no = $('#case_no').val();
        dag_no = $('#dag_no').val();
        patta_no = $('#patta_no').val();
        patta_type = $('#patta_type').val();

        $.ajax({
            url: baseurl + "LMconversionPartha/applicantChangeConv",
            method: "POST",
            data: {case_no:case_no, dag_no:dag_no, patta_no:patta_no, patta_type:patta_type},
            dataType: "json",
            success: function (data) {
                $.unblockUI();
                $('#guardian_name_conv').val(data.pattadar.pdar_father);
                $('#address_conv').val(data.pattadar.pdar_add1);                
            },
            error: function(data) {
                $.unblockUI();
                alert("Something went wrong");
            }
        });
    });

    //add applicant
    $('.btnAddNewConvAppl').on('click', function(e) {
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        appl_name_conv = $('#appl_name_conv').val();
        guardian_name_conv = $('#guardian_name_conv').val();
        rel_conv = $('#rel_conv').val();
        gender_conv = $('#gender_conv').val();
        dob_conv = $('#dob_conv').val();
        address_conv = $('#address_conv').val();
        case_no = $('#case_no').val();
        applicant_name = $("#appl_name_conv option:selected").text();
        dag_no = $('#dag_no').val();
        patta_no = $('#patta_no').val();
        patta_type = $('#patta_type').val();

        data = {appl_name_conv:appl_name_conv, guardian_name_conv:guardian_name_conv, rel_conv:rel_conv, gender_conv:gender_conv, dob_conv:dob_conv, address_conv:address_conv, case_no:case_no, applicant_name:applicant_name, dag_no:dag_no, 
            patta_no:patta_no, patta_type:patta_type}

        $.ajax({
            url: baseurl + "LMconversionPartha/addNewApplicantConv",
            method: "POST",
            data: data,
            dataType: "json",
            success: function (data) {
                $.unblockUI();
                if(data.success == 'true'){
                    reset();
                    var tmp_table = '';
                    var button = '';
                    //applicant table list
                    $.each(data.applicants, function (index, value) {
                        //duplicate pattadar
                        $.each(data.duplicate, function (i, val){
                            button = ((val["pdar_id"] == value["pdar_id"])?'<button type="button" class="btn btn-sm btn-danger btnDelApplConv" id="'+value["pdar_id"]+','+value["pdar_cron_no"]+','+val["dag_no"]+','+val["patta_no"]+','+val["dist_code"]+','+val["subdiv_code"]+','+val["cir_code"]+','+val["mouza_pargona_code"]+','+val["lot_no"]+','+val["vill_townprt_code"]+','+val["patta_type_code"]+'">' +
                                        '<i class="fa fa-trash"></i></button>':'')
                        });

                        index++;
                        tmp_table +=
                        '<tr>' +
                            '<td align="center">' + index + '</td>' +
                            '<td>' + value["pdar_name"] + '</td>' +
                            '<td>' + value["pdar_guardian"] + '</td>' +
                            '<td>' + value["pdar_rel_guar"] + '</td>' +
                            '<td>' + value["pdar_gender"] + '</td>' +
                            '<td>' + value["pdar_add1"] + '</td>' +
                            '<td>' + button + '</td>' +
                        '</tr>'
                    });

                    $('#applicant_table_show_conv').html(tmp_table);
                    $('.show_msg_add_appl_conv').html(data.message);
                }
                if(data.message != null){
                    $('.show_msg_add_appl_conv').fadeIn();
                    $('.show_msg_add_appl_conv').html(data.message);
                    setTimeout(function(){
                        $('.show_msg_add_appl_conv').fadeOut();
                    }, 30000);
                }
                if(data.error){
                    $.each(data.error, function (index, value) {
                        $('#error_'+value['field']).fadeIn();
                        $('#error_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#error_'+value['field']).fadeOut();
                        }, 30000);
                    });    
                }
                //pattadar dropdwon list after insertion
                if(data.pattadarList){
                    var template = '<option selected disabled value="">Select Applicant</option>';
                    $.each(data.pattadarList, function (index, val) {
                        template += '<option value='+val["pdar_id"]+'>'+val["pdar_name"]+' </option>'
                    });
                    $('#appl_name_conv').html(template);
                }
            },
            error: function(data) {
                $.unblockUI();
                alert("Something went wrong");
            }
        });
    });

    //delete applicant
    $(document).on('click', '.btnDelApplConv', function(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        id = $(this).attr('id');
        arr = id.split(",");
        pid = arr['0'];
        pcron = arr['1'];
        dag = arr['2'];
        patta = arr['3'];
        dist = arr['4'];
        sub = arr['5'];
        cir = arr['6'];
        mouza = arr['7'];
        lot = arr['8'];
        vill = arr['9'];
        patta_type = arr['10'];
        case_no = $('#case_no').val();

        data = {pid:pid, pcron:pcron, dag:dag, patta:patta, dist:dist, sub:sub, cir:cir, mouza:mouza, lot:lot, vill:vill, case_no:case_no, patta_type:patta_type}

        $.ajax({
            url: baseurl + "LMconversionPartha/deleteApplicantConv",
            type:'POST',
            data: data,
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                if(!confirm("Are you sure to delete this newly added applicant ? "))
                {
                    return false;
                }
                else
                {
                    if(data.success == 'true')
                    {
                        reset();
                        var tmp_table = '';
                        var button = '';
                        //applicant table list
                        $.each(data.applicants, function (index, value) {

                            //duplicate pattadar
                            $.each(data.duplicate, function (i, val){
                                button = ((val["pdar_id"] == value["pdar_id"])?'<button type="button" class="btn btn-sm btn-danger btnDelApplConv" id="'+value["pdar_id"]+','+value["pdar_cron_no"]+','+val["dag_no"]+','+val["patta_no"]+','+val["dist_code"]+','+val["subdiv_code"]+','+val["cir_code"]+','+val["mouza_pargona_code"]+','+val["lot_no"]+','+val["vill_townprt_code"]+','+val["patta_type_code"]+'"><i class="fa fa-trash"></i></button>':'')
                            });

                            index++;
                            tmp_table +=
                            '<tr>' +
                                '<td align="center">' + index + '</td>' +
                                '<td>' + value["pdar_name"] + '</td>' +
                                '<td>' + value["pdar_guardian"] + '</td>' +
                                '<td>' + value["pdar_rel_guar"] + '</td>' +
                                '<td>' + value["pdar_gender"] + '</td>' +
                                '<td>' + value["pdar_add1"] + '</td>' +
                                '<td>' + button + '</td>' +
                            '</tr>'
                        });
                        $('#applicant_table_show_conv').html(tmp_table);

                        //pattadar dropdwon list after deletion
                        if(data.pattadar){
                            var template = '<option selected disabled value="">Select Applicant</option>';
                            $.each(data.pattadar, function (index, val) {
                                template += '<option value='+val["pdar_id"]+'>'+val["pdar_name"]+' </option>'
                            });
                            $('#appl_name_conv').html(template);
                        }
                    }
                }
                if(data.message != null){
                    $('.show_msg_add_appl_conv').fadeIn();
                    $('.show_msg_add_appl_conv').html(data.message);
                    setTimeout(function(){
                        $('.show_msg_add_appl_conv').fadeOut();
                    }, 30000);
                }
            },
            error: function(data) {
                $.unblockUI();
                alert("Something went wrong");
            }
        });
    });

    function reset(){
        $('#appl_name_conv').val('');
        $('#guardian_name_conv').val('');
        $('#rel_conv').val('');
        $('#gender_conv').val('');
        $('#dob_conv').val('');
        $('#address_conv').val('');        
    }

});
</script>

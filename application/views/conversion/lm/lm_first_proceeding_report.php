
<?php //echo '<pre>'; var_dump($other_pattadars); die; ?>

<?php if ($is_partial) {?>
<?php if ($basundhar_application) {?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header text-center">
                        <h5>Add Applicant</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="case_no" value="<?php echo $petition_basic->case_no?>"/>
                            <input type="hidden" id="dag_no" value="<?php echo $petition_dag_details->dag_no?>"/>
                            <input type="hidden" id="patta_no" value="<?php echo $petition_dag_details->patta_no?>"/>
                            <input type="hidden" id="patta_type" value="<?php echo $petition_dag_details->patta_type_code?>"/>
                            <input type="hidden" id="pdar_id_conv" value=""/>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Applicant's Name <span class="red">*</span></label>
                                    <select name="appl_name_conv" id="appl_name_conv" class="form-control">
                                        <option value="">---Select Applicant---</option>
                                        <?php foreach ($other_pattadars as $other_pattadar): ?>
                                            <option value="<?php echo $other_pattadar->unique_id; ?>"><?php echo $other_pattadar->pdar_name . ' (' . $other_pattadar->pdar_father . ')'; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Guardian's Name <span class="red">*</span></label>
                                    <input type="text" id="guardian_name_conv" name="guardian_name_conv" class="form-control" placeholder="Guardian's Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Guardian's Relation <span class="red">*</span></label>
                                    <select name="rel_conv" id="rel_conv" class="form-control">
                                        <option value="">---Select Relation---</option>
                                        <?php foreach ($relations as $r): ?>
                                        <option value="<?php echo $r->guard_rel?>"><?php echo $r->guard_rel_desc_as?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Gender <span class="red">*</span></label>
                                    <select name="gender_conv" id="gender_conv" class="form-control">
                                        <option value="">---Select Gender---</option>
                                        <?php foreach ($genders as $g): ?>
                                            <option value="<?php echo $g->short_name?>"><?php echo $g->gen_name_ass?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Date of Birth</label>
                                    <input type="date" id="dob_conv" name="dob_conv" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Address <span class="red">*</span></label>
                                    <textarea name="address_conv" id="address_conv" class="form-control" rows="1" placeholder="Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 mb-4">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="button" class="btn btn-success" id="btnAddNewConvAppl"><i class='fa fa-save'></i>&nbsp;Save & Add More</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                                        $i = 1;
                                            foreach ($pattadars as $row): //get pattadar list
                                            ?>
	                                            <tr>
	                                                <td align='center'><?php echo $i?></td>
	                                                <td><?php echo $row->pdar_name?></td>
	                                                <td><?php echo $row->pdar_guardian?></td>
	                                                <td><?php echo $this->utilityclass->get_relation($row->pdar_rel_guar)?></td>
	                                                <td><?php echo $this->utilityclass->gender($row->pdar_gender)?></td>
	                                                <td><?php echo $row->pdar_add1?> <br> <?php echo $row->pdar_add2?></td>
	                                                <td>
	                                                    <?php
                                                                foreach ($unique_pattadars as $pid): //get duplicate pdar_id
                                                                        if ($row->pdar_id == $pid->pdar_id) {
                                                                        ?>
		                                                            <button type="button"
		                                                            id="<?php echo $row->pdar_id?>,<?php echo $row->pdar_cron_no?>,<?php echo $pid->dag_no?>,<?php echo $pid->patta_no?>,<?php echo $pid->dist_code?>,<?php echo $pid->subdiv_code?>,<?php echo $pid->cir_code?>,<?php echo $pid->mouza_pargona_code?>,<?php echo $pid->lot_no?>,<?php echo $pid->vill_townprt_code?>,<?php echo $pid->patta_type_code?>"
		                                                            class="btn btn-sm btn-danger btnDelApplConv">
		                                                            <i class="fa fa-trash"></i></button>

		                                                    <?php }
                                                                        endforeach; //end of get duplicate pdar_id                    
                                                                    ?>
	                                                </td>
	                                            </tr>
	                                    <?php
                                                $i++;
                                                endforeach; //end of get pattadar list
                                            ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-success" id="btnAddNewConvAppl"><i class='fa fa-save'></i>&nbsp;Save & Add More</button>
                    </div> -->
                </div>
            </div>
        </div>
    <?php }?>
<?php }?>

<div class="row mt-2">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-between">
                <h5>গোচৰ নং:                                         <?php echo $petition_basic->case_no; ?></h5>
                <h5>( দাগ নং  :                                          <?php echo $petition_dag_details->dag_no; ?> )</h5>
                <h5>Date:                          <?php echo date('d-m-Y'); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="mainform">
                            <input type="hidden" name="patta_type_code" id="patta_type_code" value="<?php echo $petition_dag_details->patta_type_code; ?>">
                            <input type="hidden" id="b" name="b" readonly value="<?php echo ($applied_area) ? $applied_area['bigha'] : $petition_dag_details->m_dag_area_b; ?>" style="width: 100px;">
                            <input type="hidden" id="k" name="k" readonly value="<?php echo ($applied_area) ? $applied_area['katha'] : $petition_dag_details->m_dag_area_k; ?>" style="width: 100px;">
                            <input type="hidden" id="l" name="l" readonly value="<?php echo ($applied_area) ? $applied_area['lessa_chatak'] : $petition_dag_details->m_dag_area_lc; ?>" style="width: 100px;">
                            <input type="hidden" id="g" name="g" readonly value="<?php echo ($applied_area) ? $applied_area['ganda'] : $petition_dag_details->m_dag_area_g; ?>" style="width: 100px;">
                            <input type="hidden" name="lm_code" id="lm_code" value="<?php echo $lm_details->lm_code; ?>"/>
                            <input type="hidden" name="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                            <input type="hidden" name="dag_no" value="<?php echo $petition_dag_details->dag_no; ?>"/>
                            <input type="hidden" name="is_partial" value="<?php echo $is_partial; ?>">
                            <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                            <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {?>
                                <input type="hidden" id="is_barak" value="0">
                            <?php } else {?>
                                <input type="hidden" id="is_barak" value="1">
                            <?php }?>
<?php if ($patta_type_details->type_code == '0208') {?>
                                <input type="hidden" id="is_nisfi_kheraz" value="1">
                            <?php } else {?>
                                <input type="hidden" id="is_nisfi_kheraz" value="0">
                            <?php }?>

                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ১) আবেদন কৰা মাটি আবেদনকাৰীৰ পট্টাৰ মাটি হয়নে ?  &nbsp;</label>
                                            <!-- <input type="checkbox" id="pattar_mati_hoi_ne" name='pattar_mati_hoi_ne' value="Y"> -->
                                            <input type="radio" id="Yes" name="pattar_mati_hoi_ne" value="Y">
                                            <label for="Yes">Yes</label>
                                            <input type="radio" id="NO" name="pattar_mati_hoi_ne" value="">
                                            <label for="NO">NO</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ২) আবেদন কৰা মাটিত আবেদনকাৰীৰ দখল আছে নে ? &nbsp;&nbsp;</label>
                                            <!-- <input type="checkbox" id="dokhol_ase_ne" name='dokhol_ase_ne' value="Y">  -->
                                            <input type="radio" id="Yes" name="dokhol_ase_ne" value="Y">
                                            <label for="Yes">Yes</label>
                                            <input type="radio" id="NO" name="dokhol_ase_ne" value="">
                                            <label for="NO">NO</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৩) উক্ত মাটিত মূল্যবান গছ-গছনি আছে নে ? &nbsp;&nbsp;&nbsp;</label>
                                            <!-- <input type="checkbox" id="gos_gosoni" name='gos_gosoni' value="Y"> -->
                                            <input type="radio" id="Yes" name="gos_gosoni" value="Y">
                                            <label for="Yes">Yes</label>
                                            <input type="radio" id="NO" name="gos_gosoni" value="">
                                            <label for="NO">NO</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৪) উক্ত মাটি অসম ভূমিলেখ্য অধিনিয়মৰ ১০৫ ধাৰা মতে ম্যাদীৰ উপযোগী নে ? <br><br>
                                            - অবেদিত মাটি কেডাষ্টল জবীপ হোৱা গাঁও অন্তর্গত মাটি হয়<br>
                                            - উক্ত মাটিত ফচল আদিৰে আবাদ/ ঘৰ বস্তি / ব্যৱসায় কৰি স্থায়ী ভাবে ভোগ দখল কৰি আছে। <br>
                                            - প্রস্তাবিত মাটি বিধি মতে ৰাস্তাৰ সোঁমাজৰ পৰা সংৰক্ষণ ও নদী নলাৰ বাবে প্ৰয়োজনিয় সংৰক্ষণ প্ৰস্তাৱ দিয়া হয়ছে। <br>
                                            - অবেদিত মাটি পট্টাদাৰ আবেদন কাৰিয়ে নিজৰ দখলত ৰাখিচে আৰু কোনো প্ৰকাৰে হস্তান্তৰ কাৰা নাই ।
                                            &nbsp;</label> &nbsp;&nbsp;
                                            <!-- <input type="checkbox" id="miyadi_upojugi" name='miyadi_upojugi' value="Y"> -->
                                            <input type="radio" id="Yes" name="miyadi_upojugi" value="Y">
                                            <label for="Yes">Yes</label>
                                            <input type="radio" id="NO" name="miyadi_upojugi" value="">
                                            <label for="NO">NO</label>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label" > ৫) উক্ত মাটিৰ শ্রেণী  &nbsp;<span class="red">*</span></label>
                                        </td>
                                        <td>
                                            <select name="land_class" id="land_class" class="form-control" required>
                                                <option value="<?php echo $land_class_details->class_code; ?>" selected><?php echo $land_class_details->land_type; ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- added by hriday - 25-04-2024 -->
                                        <td colspan="2">
                                            <div style="display:flex;">
                                                <label class="control-label" > ৬) ৰাস্তাৰ কাষৰ সংৰক্ষণ আছে নেকি ? &nbsp;</label>
                                                <!-- <input type="checkbox" id="rasta_res" class='partial' name='rasta_res' value="Y"> &nbsp; -->
                                                <input type="radio" id="Yes" name="rasta_res" value="Y" class='partial'>
                                                <label for="Yes">&nbsp;Yes</label>&nbsp;
                                                <input type="radio" id="NO" name="rasta_res" value="" class='partial'>
                                                <label for="NO">&nbsp;NO</label>
                                                <div id='partial_area_div' style="display:flex;">
                                                <input type="text" id="rastar_kaijo_b" name="rastar_kaijo_b" class="rastar_kaijo_b" style="width: 100px;" value="0"> বিঃ
                                                <input type="text" id="rastar_kaijo_k" name="rastar_kaijo_k" class="rastar_kaijo_k" style="width: 100px;" value="0"> কঃ
                                                <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {?>
                                                    <input type="text" id="rastar_kaijo_lc" name="rastar_kaijo_lc" class="rastar_kaijo_lc" style="width: 100px;" value="0"> লেঃ
                                                <?php } else {?>
                                                    <input type="text" id="rastar_kaijo_lc" name="rastar_kaijo_lc" class="rastar_kaijo_lc" style="width: 100px;" value="0"> ছ
                                                    <input type="text" id="rastar_kaijo_g" name="rastar_kaijo_g" class="rastar_kaijo_g" style="width: 100px;" value="0"> গো
                                                <?php }?>
                                                </div>
                                                <!-- <select class="ml-2" name="rastarkakhoroldnew" id="rastarkakhoroldnew" style="display:none;">
                                                    <option value="">--Select--</option>
                                                    <option value="olddagreservation">Old Dag Reservation</option>
                                                    <option value="newdagreservation">New Dag Reservation</option>
                                                </select> -->
                                            </div>
                                        </td>
                                        <!-- end added -->
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ৭) উক্ত মাটি ভূমি নিতীৰ মতে নদীৰ কাষৰ মাটি নেকি ? &nbsp;</label>
                                            <!-- <input type="checkbox" id="nodir_kakhor" class='rv_side' name='nodir_kakhor' value="Y"> &nbsp; -->
                                            <input type="radio" id="Yes" name="nodir_kakhor" value="Y" class='rv_side'>
                                            <label for="Yes">&nbsp;Yes</label>&nbsp;
                                            <input type="radio" id="NO" name="nodir_kakhor" value="" class='rv_side'>
                                            <label for="NO">&nbsp;NO</label>
                                            <!-- added by hriday - 25-04-2024 -->
                                            <div id='river_seide' style="display:flex;">
                                            <!-- end added -->
                                                পরিমাণ -
                                                <input type="text" id="nodir_kaijo_b" name="nodir_kaijo_b" class="nodir_kaijo_b" style="width: 100px;" value="0"> বিঃ
                                                <input type="text" id="nodir_kaijo_k" name="nodir_kaijo_k" class="nodir_kaijo_k" style="width: 100px;" value="0"> কঃ
                                                <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {?>
                                                    <input type="text" id="nodir_kaijo_lc" name="nodir_kaijo_lc" class="nodir_kaijo_lc" style="width: 100px;" value="0"> লেঃ
                                                <?php } else {?>
                                                    <input type="text" id="nodir_kaijo_lc" name="nodir_kaijo_lc" class="nodir_kaijo_lc" style="width: 100px;" value="0"> ছ
                                                    <input type="text" id="nodir_kaijo_g" name="nodir_kaijo_g" class="nodir_kaijo_g" style="width: 100px;" value="0"> গো
                                                <?php }?>
                                                <!-- added by hriday - 25-04-2024 -->
                                                <!-- <select class="ml-2" name="nodirkakhoroldnew" id="nodirkakhoroldnew" style="display:none;">
                                                    <option value="">--Select--</option>
                                                    <option value="olddagreservation">Old Dag Reservation</option>
                                                    <option value="newdagreservation">New Dag Reservation</option>
                                                </select> -->
                                                <!-- end added -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td colspan="2">
                                            <label class="control-label" > ৮) এইটো এটা আংশিক ৰূপান্তৰ নেকি ? &nbsp;</label>
                                            <input type="checkbox" id="partial_conv" class='partial' name='partial_conv' value="Y"> &nbsp;
                                            <div id='' style="display:none;">
                                                পরিমাণ - (স্থানান্তৰ নকৰা কালি)
                                                <input type="text" id="partial_b" name="partial_b" class="partial_b" style="width: 100px;" value="0"> বিঃ
                                                <input type="text" id="partial_k" name="partial_k" class="partial_k" style="width: 100px;" value="0"> কঃ
                                                <?php if (! in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {?>
                                                    <input type="text" id="partial_lc" name="partial_lc" class="partial_lc" style="width: 100px;" value="0"> লেঃ
                                                <?php } else {?>
                                                    <input type="text" id="partial_lc" name="partial_lc" class="partial_lc" style="width: 100px;" value="0"> ছ
                                                    <input type="text" id="partial_g" name="partial_g" class="partial_g" style="width: 100px;" value="0"> গো
                                                <?php }?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                        <!-- <input type="checkbox" id="partial_conv" class='partial' name='partial_conv' value="Y" style="display: none;"> &nbsp; -->
                                        <label class="" ><span class="red">টোকা : ক্ৰ্মিক নং  ৮, ৯,  আৰু ১০ অতি গুরুত্বপূর্ণ / বাধ্যতামূলক </span><span class="red">*</span></label><br>
                                            <label class="" ><span class="red">অনুসুচিত জাতি / জনজাতি / বিধবা যাৰ কোনো উপাৰ্জনকাৰী সন্তান নাই অথবা উপাৰ্জনক্ষম ভূসম্পওি নাই  / শাৰিৰীক ভাবে অক্ষম হয় তেন্তে মুঠ ম্যাদীকৰন প্ৰিমিয়ামৰ ২৫% ৰেহাই ধায্য কৰি প্ৰিমিয়াম নিৰ্ধাৰণ কৰিব লাগিব | যদিহে হ'য় তেন্তে তলত দিয়া ক,খ,গ 'ৰ পৰা বাচনী কৰক |</span></label>
                                            <ul>
                                                <li>
                                                    <label class="control-label" > ৮) ক. আবেদনকাৰী অনুসুচিত জাতি / জনজাতি হয়নে ? &nbsp;</label>
                                                    <input type="checkbox" id="jati_janajati" class='jati_janajati premrecal' name='jati_janajati' value="Y"> &nbsp;
                                                    <div id='jati_janajatie' class="alert alert-info">
                                                        <span class="blue"> প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                        <input type="file" id="filename_jati_janajati" required="" placeholder="Type Here"  name="filename_jati_janajati"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; খ. শাৰিৰীক ভাবে অক্ষম হয়নে ? &nbsp;</label>
                                                    <input type="checkbox" id="freedom_fighter" class='freedom_fighter premrecal' name='freedom_fighter' value="Y"> &nbsp;
                                                    <div id='freedom_fightere' class="alert alert-info">
                                                        <span class="blue">&nbsp;&nbsp; প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                        <input type="file" id="filename_freedom_fighter" required="" placeholder="Type Here"  name="filename_freedom_fighter"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. আবেদনকাৰী বিধবা হয়নেকি যাৰ কোনো উপাৰ্জনকাৰী সন্তান নাই অথবা উপাৰ্জনক্ষম ভূসম্পওি নাই ? &nbsp;</label>
                                                    <input type="checkbox" id="widow" class='widow premrecal' name='widow' value="Y"> &nbsp;
                                                    <div id='widowe' class="alert alert-info">
                                                        <span class="blue">&nbsp;&nbsp; প্ৰয়েজনীয় নথি দাখিল কৰিছে । -
                                                        <input type="file" id="filename_widow" required="" placeholder="Type Here"  name="filename_widow"></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php if ($rtps_tag == BASUNDHARA_CHECK) {?>
                                        <!-- <tr>
                                            <td colspan="2">
                                                <label class="" ><span class="red">টোকা : ক্ৰ্মিক নং ৯, ১০ আৰু ১১ অতি গুরুত্বপূর্ণ / বাধ্যতামূলক |</span></label>
                                                <ul>
                                                    <li>
                                                        <label class="control-label"> ১০) i. উক্ত মাটি গ্ৰাম্য এলেকা মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinRev" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp; ii. উক্ত মাটি ৰাজহ নগৰ আৰু ইয়াৰ প্ৰান্তীয় এলেকা মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio2" required value="withinRev" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; iii. উক্ত মাটি জিলাৰ মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ বাহিৰে আন চহৰবোৰৰ <br> পৰিধি অঞ্চল মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio3" required value="withinRev" class="get_premium_assessed">
                                                    </li>
                                                    <?php if (($location_details->rural_urban != 'R') && ($rtps_tag != 'RTPS')) {?>
                                                        <li>
                                                            <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; iv. উক্ত মাটি জিলা মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধি অঞ্চল মাটি হয়নে? &nbsp;</label>
                                                            <input type="radio" name="whetherOr" id="inlineRadio4" required value="within3km" class="get_premium_assessed">
                                                        </li>
                                                        <li>
                                                            <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; v. &nbsp; সকলো পৌৰ নিগম/পৌৰ নিগমৰ ভিতৰত এলেকাবোৰ পৰি আছে নেকি? &nbsp; </label>
                                                            <input type="radio" name="whetherOr" id="inlineRadio5" required value="withintown" class="get_premium_assessed">
                                                        </li>
                                                    <?php }?>
                                                </ul>
                                            </td>
                                        </tr> -->
                                    <?php } else {?>
                                        <tr>
                                            <td colspan="2">
                                            ৯)
                                                <ul>
                                                    <?php $serial = 0; ?>
<?php foreach ($conversion_premium_areas as $cpareas): ?>
<?php $serial++; ?>
                                                        <li>
                                                            <label class="control-label"><?php echo $serial . ') ' . $cpareas->ass_name; ?></label>
                                                            <input type="radio" name="whetherOr" id="inlineRadio<?php echo $serial; ?>" required value="<?php echo $cpareas->id ?>" class="get_premium_assessed">
                                                        </li>
                                                    <?php endforeach; ?>
                                                    <!-- <li>
                                                        <label class="control-label"> ১০) ক. গাওঁৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio1" required value="withinrural" class="get_premium_assessed">
                                                    </li>

                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; খ. ৰাজহ নগৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio2" required value="withinrevenuetown" class="get_premium_assessed">
                                                    </li>

                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; গ. আবেদিত মাটি চহৰৰ পৰিসীমাৰ পৰা 3 কিঃ মিঃ ব্যাসাৰ্দ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio3" required value="within3km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঘ. জিলা সদৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া, পলাশবাৰী নগৰ আৰু পৌৰ নগৰ/নিগম মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio4" required value="withintown" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঙ. জিলা সদৰ চহৰসমূহৰ পুনৰ্গঠিত উন্নয়ন প্ৰাধিকৰণ এলেকাৰ ভিতৰত আৰু উত্তৰ গুৱাহাটী, <br> ৰঙিয়া আৰু পলাশবাৰী চহৰৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio5" required value="withintown5km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; চ. পৌৰ নগৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio6" required value="withinmunicipal" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ছ. পৌৰ নগৰসমূহৰ পৰিধিৰ পৰা 5 কিঃমিঃ ব্যাসাৰ্ধৰ ভিতৰৰ মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio7" required value="withinmunicipal5km" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; জ. গুৱাহাটী মহানগৰী মাটি হয়নে ? &nbsp;</label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio8" required value="withinghy" class="get_premium_assessed">
                                                    </li>
                                                    <li>
                                                        <label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp; ঝ. গুৱাহাটী চহৰৰ পৰিসীমাৰ পৰা ১৫ কিলোমিটাৰ দূৰত্বৰ মাটি হয়নে ? &nbsp; </label>
                                                        <input type="radio" name="whetherOr" id="inlineRadio9" required value="within15km" class="get_premium_assessed">
                                                    </li> -->
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="2">
                                            <?php $zonalValue = $this->utilityclass->getZonalValue($petition_basic->dist_code, $location_details->uuid, $petition_dag_details->dag_no); ?>
                                            <label class="control-label" > ১০) মাটিৰ মান্ডলিক মুল্য (&nbsp;বিঘাই প্রতি &nbsp;</label>
                                            <?php if ($zonalValue == null) {?>
                                                <span class="red"> <b>Plese add zonal value before proceed.</b> </span> )
                                            <?php } else {?>
                                                <input readonly type="number" name="each_bigha_rate" id="zonal_rate" style="width: 100px;" required value="<?php echo $zonalValue ?>"> <label class="control-label" >&nbsp; টকা &nbsp;)</label><span class="red"> * mandatory</span>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            <div>
                                                <label for="">Recommended</label>
                                                <input type="radio" name="recommendation" value="recommended" checked>
                                            </div>
                                        </td>
                                        <td colspan="1">
                                            <div>
                                                <label for="">Not Recommended</label>
                                                <input type="radio" name="recommendation" value="not_recommended" >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div style="display: flex; align-items: center;">
                                                <div style="margin-right: 1rem;">
                                                    <label class="control-label" > ১১) </label>
                                                    <input type="text" name="conv_b" id="rb" value="<?php echo ($applied_area) ? $applied_area['bigha'] : $petition_dag_details->m_dag_area_b; ?>" style="width: 100px;" class="premrecal">
                                                    <label class="control-label" >বিঃ </label>

                                                    <input type="text" name="conv_k" id="rkatha" value="<?php echo ($applied_area) ? $applied_area['katha'] : $petition_dag_details->m_dag_area_k; ?>" style="width: 100px;" class="premrecal">
                                                    <label class="control-label" >কঃ </label> 
                                                    
                                                    <input type="text" name="conv_lc" id="rl" value="<?php echo ($applied_area) ? $applied_area['lessa_chatak'] : $petition_dag_details->m_dag_area_lc; ?>" style="width: 100px;" class="premrecal">
                                                    <?php if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) { ?>
                                                        <label class="control-label" >লেঃ </label>
                                                    <?php } else {?>
                                                        <label class="control-label" >ছটাক </label>

                                                        <input type="text" name="conv_g" id="rg" value="<?php echo ($applied_area) ? $applied_area['ganda'] : $petition_dag_details->m_dag_area_g; ?>" style="width: 100px;" class="premrecal">
                                                        <label class="control-label" >গোণ্ডা </label>
                                                    <?php }?>
                                                </div>
                                                <div style="margin-left: 1rem;" class="display_premium">
                                                    <label class="control-label" >&nbsp; মাটিৰ প্রিমিয়াম (&nbsp; <span id="change_text" class="red"></span></label>
                                                    <input type="text" name="total_premium" id="rk" style="width: 100px;" readonly><label class="control-label" >&nbsp; টকা &nbsp;) <a href="<?php echo base_url();?>/assets/Premium.pdf" target="_blank">View Premium Notice </a></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="display_premium">
                                        <td colspan="2">
                                            <label class="control-label" > ১২) মাটিৰ প্রিমিয়াম Assesment Type(&nbsp;বিঘাই প্রতি - </label>
                                            <input type="hidden" id="premium_assesment_type" name="premium_assesment_type" value="">
                                            <select name="premium_assesment" id="" class="cal_premium_e" required>
                                                <option value="">---Select Assesment Type---</option>
                                                <?php foreach ($conversion_premium_area_purpose as $areaPurpose): ?>
                                                    <option value="<?php echo $areaPurpose->id; ?>"><?php echo $areaPurpose->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="townland">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="100">100% per bigha land value for Occupied portion of the AP land that remains with the pattadar after transfer of AP land (Residential Purpose).</option>
                                                <option value="50">50% per bigha land value for Residential Purpose</option>
                                                <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>

                                            </select>
                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="w3km">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                <option value="75">75% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                <option value="20">Premium @ 20 Rs of per bigha land value for Agriculture Purpose</option>
                                            </select>
                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="w10km">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="50">50% per bigha land value for Residential Purpose</option>
                                                <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                <option value="50">50% per bigha land value for Agriculture Purpose</option>

                                            </select>
                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="withinrevenue">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="0">Premium Free</option>
                                            </select>

                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="withinrevenuetown">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                <option value="75">75% per bigha land value for Trade/Commerce/Industrial Purpose</option>

                                            </select>

                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="withintown5km">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="15">15% per bigha land value for Residential Purpose.</option>
                                                <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                <option value="15">15% per bigha land value for Agriculture Purpose</option>

                                            </select>

                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="withinmunicipal">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="100">100% per bigha land value for Occupied portion of the AP land that remains with the pattadar after transfer of AP land (Residential Purpose).</option>
                                                <option value="50">50% per bigha land value for Residential Purpose</option>
                                                <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>

                                            </select>

                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="withinmunicipal5km">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="40">Premium @ 40 Rs of per bigha land value for Residential Purpose.</option>
                                                <option value="75">75% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                <option value="20">Premium @ 20 Rs of per bigha land value for Agriculture Purpose</option>

                                            </select>

                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="withinghy">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="100">100% per bigha land value for Occupied portion of the AP land that remains with the pattadar after transfer of AP land (Residential Purpose).</option>
                                                <option value="50">50% per bigha land value for Residential Purpose</option>
                                                <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>

                                            </select>

                                            <select name="premium_assesment" class="cal_premium_e" required  style="display:none;" id="within15km">
                                                <option value="" selected disabled>-- select --</option>
                                                <option value="25">25% per bigha land value for Residential Purpose</option>
                                                <option value="100">100% per bigha land value for Trade/Commerce/Industrial Purpose</option>
                                                <option value="25">25% per bigha land value for Agriculture Purpose</option>

                                            </select>

                                            <select name="premium_assesment" class="" required id="when_none">
                                                <option value="" selected disabled>-- select --</option>
                                            </select> -->
                                            <label class="control-label" > &nbsp;)</label><span class="red"> * mandatory</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label class="control-label" > ১৩) অন্যান্য তথ্য ও মন্তব্য &nbsp;<span class="red">*</span></label></td>
                                        <td><textarea name="lm_notice" id="lm_notice" class="form-control" cols="8" rows="8" required placeholder="ভূমিলেখ্য সহায়কৰ মন্তব্য ?"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > স্বাক্ষৰ (ভূমিলেখ্য সহায়ক) &nbsp;<span class="red">*</span></label>
                                            <label>
                                                <input type="radio" name="lm_sign" id="inlineRadio21" value="Y" checked>                                                                                                                           <?php echo $this->lang->line('yes'); ?>
                                            </label>
                                            <label>
                                                <input type="radio" name="lm_sign" id="inlineRadio22" value="N">                                                                                                                  <?php echo $this->lang->line('no'); ?>
                                            </label>
                                        </td>
                                    </tr>

                                    <?php if ($patta_type_details->type_code == '0208') {?>
                                        <tr>
                                            <td colspan="2">
                                                <label class="control-label" > Is the Nisfi Kheraz land transferred? &nbsp;<span class="red">*</span></label>
                                                <label>
                                                    <input type="radio" name="land_trans" id="land_trans_y" value="Y" checked><?php echo $this->lang->line('yes'); ?>
                                                </label>
                                                <label>
                                                    <input type="radio" name="land_trans" id="land_trans_n" value="N">                                                                                                                        <?php echo $this->lang->line('no'); ?>
                                                </label>
                                                <label class="control-label" ><a href="<?php echo base_url();?>assets/nisfi_kheraz_notice.pdf" target="_blank">View Nisfi Kheraz Notice </a></label>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    <tr>
                                        <td colspan="2">
                                            <label class="control-label" > ভূমিলেখ্য সহায়কৰ নাম &nbsp;<span class="red">*</span></label>
                                            <input type="text" name="lm_name" id="lm_name" style="width: 200px;" value="<?php echo $lm_details->lm_name; ?>">
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="2">
                                            <label class="control-label" >তাৰিখ &nbsp;<span class="red">*</span></label>
                                            <input type="date" name="date_of_entry" autocomplete="off" id="date_of_entry" style="width: 200px;" required>
                                            &nbsp; (dd-mm-yyyy)
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                            <!-- Added by hriday - 25-04-2024 -->
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-bold table-success">
                                        <th>Pattadar Name</th>
                                        <th>Pattadar Guardian Name</th>
                                        <th>Inplace / AlongWith <span class="red">*</span></th>
                                    </tr>
                                </thead>
                                <tbody id="pattadar_inplace_alongwith">
                                    <?php foreach ($pattadars as $pdar): ?>
                                        <tr>
                                            <td><?php echo $pdar->pdar_name; ?></td>
                                            <td><?php echo $pdar->pdar_guardian; ?></td>
                                            <td><select id="inplacealong_<?php echo $pdar->pdar_id; ?>" name="inplacealong[]" class="form-control inplace_alongwith">
                                                <option value="">Select Inplace/Alongwith</option>
                                                <option value="inplace_<?php echo $pdar->pdar_id; ?>">Inplace (Pattadar going to be remove from old dag)</option>
                                                <!-- <option value="alongwith">Alongwith</option> -->
                                            </select></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- end added -->
                            <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-6 required  control-label">Upload <?php echo NOC?> signed copy from all the Pattadars</label>
                                    <div class="col-lg-6">
                                        <input type='file' name="up_noc_conv" id="up_noc_conv" required>
                                    </div>
                                </div>
                            </div>
                            </div> -->

                            <div class="row mt-2">
                                <div class="col-4">
                                    <label for="inputEmail4">Geo tagged photo</label>
                                </div>
                                <div class="col-8">
                                    <?php
                                        if (isset($geo_tag_doc_empty)) {
                                            echo $geo_tag_doc_empty;
                                        }
                                        if (isset($geo_tag_doc)) {
                                            foreach ($geo_tag_doc as $d):
                                        ?>
                                            <span class="alert-warning">For Dag no : <strong><?php echo $d->dag_no?></strong></span><br>
                                            <a target='download' href="<?php echo base_url() ?>index.php/SettlementCommon/downloadDocument?doc_id=<?php echo $d->id?>"><i class="fa fa-paperclip mb-2"></i> <?php echo $d->file_name;?></a><br>

                                        <?php endforeach;
                                        }?>

                                </div>
                            </div>

                            <?php include APPPATH . 'views/multipleUploadMB3.php'?>


                            <?php if ($patta_type_details->type_code == '0208') {?>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="col-lg-3 required  control-label">Upload Nisfi Kheraz Document</label>
                                            <div class="col-lg-3">
                                                <input type='file' name="up_doc" id="up_doc" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </form>
                    </div>
                </div>
                <!-- <div class="row mt-4">
                    <div class="col-md-12"> -->
                        <?php
                            // if($basundhar_application){
                            //     echo '<h6 class="red">Other Attachments</h6>';
                            //     foreach ($basundhara_attachment  as $attachment):
                        //     ?>
                            <!--          <p><a href="<?php echo base_url() . "index.php/basundhara/document/" . $attachment->name ?>" class="red fs-6" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name; ?> (Click to see the attachment)</a></p> -->
                                 <?php
                                     //     endforeach; 
                                     // }
                                     // else{
                                     //     echo '<h6 class="red">Other Attachments</h6>';
                                     //     foreach($supportive_documents as $docs):
                                 //     ?>
                            <!--          <p><a class="red fs-6" href="<?php echo base_url('index.php/AjaxController/getFile?id=' . $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name; ?> (Click to see the attachment)</a></p> -->
                                 <?php
                                     //     endforeach;
                                     // }
                                 ?>
                    <!-- </div>
                </div> -->
            </div>
            <?php
                $basuCase = $basundhar_application;
                include 'application\views\query\queryModel.php';

            ?>

            <div class="card-footer d-flex justify-content-center">
                <p style="color: red">Please verify the area and premium before submitting</p>
                <button type="button" name="submit" id="mainFormSubmit" class="btn btn-success uni_text btnSubmit mr-2 ml-2"><i class="fa fa-check"></i>&nbsp;<?php echo $this->lang->line('submit_report'); ?></button>
                <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $petition_basic->case_no; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                <a class="btn btn-danger uni_text mr-2 ml-2" href="<?php echo base_url(); ?>index.php/go_to_lm?pro=1"><i class='fa fa-arrow-left'></i><?php echo $this->lang->line('back') ?></a>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script>

    $(document).on('change', 'input[name="recommendation"]', (e) => {
        if(e.currentTarget.checked) {
            if(e.currentTarget.value == 'not_recommended') {
                $('.display_premium').hide();
            }
            else {
                $('.display_premium').show();
            }
        }
    });

    $(document).on('click', '#mainFormSubmit', (e) => {
        var is_nisfi_kheraz = $('#is_nisfi_kheraz').val();
        var is_barak = $('#is_barak').val();
        var recommendation = $('input[name="recommendation"]:checked').val();

        // var up_noc_conv = document.getElementById('up_noc_conv').files[0];
        // if(up_noc_conv == undefined) {
        //     swal.fire("", "NOC Document is a required parameter", "error")
        //     .then((value) => {

        //     });
        //     return false;
        // }
        if(is_nisfi_kheraz == '1') {
            var up_doc = document.getElementById('up_doc').files[0];
            if(up_doc == undefined) {
                swal.fire("", "Nisfi Kheraz Document is a required parameter", "error")
                .then((value) => {

                });
                return false;
            }
        }
        var inplace_alongwith = $('.inplace_alongwith');
        for(var i=0; i<inplace_alongwith.length; i++) {
            var id = inplace_alongwith[i].id;
            var idSplit = id.split('_');
            if(inplace_alongwith[i].value != 'inplace_' + idSplit[1]) {
                swal.fire("", "Pattadar inplace/alongwith is not set", "error")
                .then((value) => {

                });
                return false;
            }
        }
        var jati_janajati = $('#jati_janajati:checked').val();
        if(jati_janajati != undefined) {
            var filename_jati_janajati = document.getElementById('filename_jati_janajati').files[0];
            if(filename_jati_janajati == undefined) {
                swal.fire("", "Jati Janajati file not uploaded", "error")
                .then((value) => {

                });
                return false;
            }
        }
        var freedom_fighter = $('#freedom_fighter:checked').val();
        if(freedom_fighter != undefined) {
            var filename_freedom_fighter = document.getElementById('filename_freedom_fighter').files[0];
            if(filename_freedom_fighter == undefined) {
                swal.fire("", "Freedom fighter file not uploaded", "error")
                .then((value) => {

                });
                return false;
            }
        }
        var widow = $('#widow:checked').val();
        if(widow != undefined) {
            var filename_widow = document.getElementById('filename_widow').files[0];
            if(filename_widow == undefined) {
                swal.fire("", "Widow file not uploaded", "error")
                .then((value) => {

                });
                return false;
            }
        }
        var partial_conv = $('#partial_conv:checked').val();
        if(partial_conv != undefined) {
            var partial_b = $('#partial_b').val();
            var partial_k = $('#partial_k').val();
            var partial_lc = $('#partial_lc').val();
            if(is_barak == '1') {
                var partial_g = $('#partial_g').val();
                if(partial_b <= 0 && partial_k <= 0 && partial_lc <= 0 && partial_g <= 0) {
                    swal.fire("", "partial bigha, katha, lessa, ganda cant be all zero in this case", "error")
                    .then((value) => {

                    });
                    return false;
                }
            }
            else {
                var partial_g = '0';
                if(partial_b <= 0 && partial_k <= 0 && partial_lc <= 0) {
                    swal.fire("", "partial bigha, katha, lessa cant be all zero in this case", "error")
                    .then((value) => {

                    });
                    return false;
                }
            }
        }
        var nodir_kakhor = $('#nodir_kakhor:checked').val();
        if(nodir_kakhor != undefined) {
            var nodir_kaijo_b = $('#nodir_kaijo_b').val();
            var nodir_kaijo_k = $('#nodir_kaijo_k').val();
            var nodir_kaijo_lc = $('#nodir_kaijo_lc').val();
            if(is_barak == '1') {
                var nodir_kaijo_g = $('#nodir_kaijo_g').val();
                if(nodir_kaijo_b <= 0 && nodir_kaijo_k <= 0 && nodir_kaijo_lc <= 0 && nodir_kaijo_g <= 0) {
                    swal.fire("", "River Side bigha, katha, lessa, ganda cant be all zero in this case", "error")
                    .then((value) => {

                    });
                    return false;
                }
            }
            else {
                var nodir_kaijo_g = '0';
                if(nodir_kaijo_b <= 0 && nodir_kaijo_k <= 0 && nodir_kaijo_lc <= 0) {
                    swal.fire("", "River Side bigha, katha, lessa cant be all zero in this case", "error")
                    .then((value) => {

                    });
                    return false;
                }
            }
        }
        var whetherOr = $('input[name="whetherOr"]:checked').val();
        if(whetherOr == undefined) {
            swal.fire("", "No. 9 Field is mandatory to be selected", "error")
            .then((value) => {

            });
            return false;
        }
        
        if(recommendation == 'recommended') {
            var premium_assesment = $('#premium_assesment_type').val();
            if(premium_assesment == "" || premium_assesment == undefined) {
                swal.fire("", "Premium assessment type is a required field", "error")
                .then((value) => {

                });
                return false;
            }
            var zonal_rate = $('#zonal_rate').val();
            var total_premium = $('#rk').val();
        }
        
        if(is_nisfi_kheraz == '1') {
            var land_trans = $('input[name="land_trans"]:checked').val();
            if(land_trans == undefined || land_trans == '') {
                swal.fire("", "Land Transfered check is a required field", "error")
                .then((value) => {

                });
                return false;
            }
        }

        if (!$.trim($("#lm_notice").val())) {
            // textarea is empty or contains only white-space
            swal.fire("", "LRA remarks are mandatory", "error")
                .then((value) => {

                });
                return false;
        }

        //
        var land_class = $('#land_class').val();
        var conv_b = $('#rb').val();
        var conv_k = $('#rkatha').val();
        var conv_lc = $('#rl').val();
        if(is_barak == '1') {
            var conv_g = $('#rg').val();
        }
        else {
            var conv_g = '0';
        }
        var lm_notice = $('#lm_notice').val();
        var lm_sign = $('input[name="lm_sign"]:checked').val();

        var lm_name = $('#lm_name').val();
        // var date_of_entry = $('#date_of_entry').val();

        if(is_barak == '1') {
            if(land_class == '' || land_class == undefined || zonal_rate == '' || total_premium == '' || lm_notice == '' || lm_sign == '' || lm_sign == undefined || lm_name == '' || (conv_b <= 0 && conv_k <= 0 && conv_lc <= 0 && conv_g <= 0)) {
                swal.fire("", "All fields with (*) mark are mandatory", "error")
                .then((value) => {

                });
                return false;
            }
        }
        else {
            if(land_class == '' || land_class == undefined || zonal_rate == '' || total_premium == '' || lm_notice == '' || lm_sign == '' || lm_sign == undefined || lm_name == '' || (conv_b <= 0 && conv_k <= 0 && conv_lc <= 0)) {
                swal.fire("", "All fields with (*) mark are mandatory", "error")
                .then((value) => {

                });
                return false;
            }
        }



        // var miyadi_upojugi = $('#miyadi_upojugi:checked').val();
        // var gos_gosoni = $('#gos_gosoni:checked').val();
        // var dokhol_ase_ne = $('#dokhol_ase_ne:checked').val();
        // var pattar_mati_hoi_ne = $('#pattar_mati_hoi_ne:checked').val();

        var baseurl = $('#baseurl').val();
        var mainform = document.getElementById('mainform');
        const formData = new FormData(mainform);
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + 'index.php/lm_first_proceeding_post',
            method: 'POST',
            dataType: 'JSON',
            data:formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.unblockUI();
                if(response.status == 'SUCCESS') {
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
            error: function(err) {
                $.unblockUI();
                console.log(err);
            }
        });
    });
$(document).ready(function() {
    $("#river_seide").hide();
    $("#partial_area_div").hide();
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

    // $('.rv_side').change(function () {
    //     if(this.checked) {
    //         $("#river_seide").show();
    //     }
    //     else
    //     {
    //         $("#river_seide").hide();
    //     }
    // });

    $('input[name="rasta_res"]').change(function() {
        if ($(this).val() === "Y") {
        $("#partial_area_div").show();
        } else {
        $("#partial_area_div").hide();
        }
    });

    $('input[name="nodir_kakhor"]').change(function() {
        if ($(this).val() === "Y") {
        $("#river_seide").show();
        } else {
        $("#river_seide").hide();
        }
    });

    // $('.partial').change(function () {
    //     if(this.checked) {
    //         $("#partial_area_div").show();
    //     }
    //     else
    //     {
    //         $("#partial_area_div").hide();
    //     }
    // });

    $('.premrecal').change(function () {
        $('select[name="premium_assesment"]').val('');
        $('#rk').val('');
    });


    //code designed by MRI009 : 21092023-------------//
    $('#rastar_kaijo_b, #rastar_kaijo_k, #rastar_kaijo_lc, #rastar_kaijo_g').change(function(){
        $('#premium_assesment_type').val('');
        $('select[name="premium_assesment"]').val('');
        // $('select[name="premium_assesment"]').hide();
        $('#when_none').show();
        $('.get_premium_assessed').prop('checked', false);
        $('#rk').val('');
        //added by hriday - 25-04-2024
        // var rastarkaijob = $('.rastar_kaijo_b').val();
        // var rastarkaijok = $('.rastar_kaijo_k').val();
        // var rastarkaijolc = $('.rastar_kaijo_lc').val();
        // var ispartial =                           <?php echo $is_partial; ?>;

        // if(ispartial == 1 && (rastarkaijob != 0 || rastarkaijok != 0 || rastarkaijolc != 0)) {
        //     $('#rastarkakhoroldnew').attr({style: 'display:block;', disabled: false, required: true});
        // }
        // else{
        //     $('#rastarkakhoroldnew').val('');
        //     $('#rastarkakhoroldnew').attr({style: 'display:none;', disabled: true, required: false});
        // }
        // end added
    });


    $('#nodir_kaijo_b, #nodir_kaijo_k, #nodir_kaijo_lc, #nodir_kaijo_g').change(function(){
        $('#premium_assesment_type').val('');
        $('select[name="premium_assesment"]').val('');
        // $('select[name="premium_assesment"]').hide();
        $('#when_none').show();
        $('.get_premium_assessed').prop('checked', false);
        $('#rk').val('');
        //added by hriday - 25-04-2024
        // var nodirkaijob = $('.nodir_kaijo_b').val();
        // var nodirkaijok = $('.nodir_kaijo_k').val();
        // var nodirkaijolc = $('.nodir_kaijo_lc').val();
        // var ispartial =                           <?php echo $is_partial; ?>;

        // if(ispartial == 1 && (nodirkaijob != 0 || nodirkaijok != 0 || nodirkaijolc != 0)) {
        //     $('#nodirkakhoroldnew').attr({style: 'display:block;', disabled: false, required: true});
        // }
        // else{
        //     $('#nodirkakhoroldnew').val('');
        //     $('#nodirkakhoroldnew').attr({style: 'display:none;', disabled: true, required: false});
        // }
        //end added
    });

    $('#partial_b, #partial_k, #partial_lc, #partial_g').change(function(){
        $('#premium_assesment_type').val('');
        $('select[name="premium_assesment"]').val('');
        // $('select[name="premium_assesment"]').hide();
        $('#when_none').show();
        $('.get_premium_assessed').prop('checked', false);
        $('#rk').val('');
        //added by hriday - 25-04-2024
        // var nodirkaijob = $('.nodir_kaijo_b').val();
        // var nodirkaijok = $('.nodir_kaijo_k').val();
        // var nodirkaijolc = $('.nodir_kaijo_lc').val();
        // var ispartial =                           <?php echo $is_partial; ?>;

        // if(ispartial == 1 && (nodirkaijob != 0 || nodirkaijok != 0 || nodirkaijolc != 0)) {
        //     $('#nodirkakhoroldnew').attr({style: 'display:block;', disabled: false, required: true});
        // }
        // else{
        //     $('#nodirkakhoroldnew').val('');
        //     $('#nodirkakhoroldnew').attr({style: 'display:none;', disabled: true, required: false});
        // }
        //end added
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
    //     $('#premium_assesment_type').val('');
    //     $('select[name="premium_assesment"]').val('');
    //     $('select[name="premium_assesment"]').hide();
    //     $('#rk').val('');
    //     calculateLandRemaining();

    //     if(selected_value == 'withintown')
    //     {
    //         $("#townland").show();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'within3km')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").show();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'withinrural')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").show();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'within10km')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").show();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }

    //     else if(selected_value == 'withinRev')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#withinrevenue").show();
    //         $('#rk').val(0);
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'withinrevenuetown')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").show();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'withintown5km')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").show();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'withinmunicipal')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").show();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'withinmunicipal5km')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").show();
    //         $("#withinghy").hide();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'withinghy')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").show();
    //         $("#within15km").hide();
    //     }
    //     else if(selected_value == 'within15km')
    //     {
    //         $("#townland").hide();
    //         $("#when_none").hide();
    //         $("#w10km").hide();
    //         $("#w3km").hide();
    //         $("#withinrevenue").hide();
    //         $("#withinrevenuetown").hide();
    //         $("#withintown5km").hide();
    //         $("#withinmunicipal").hide();
    //         $("#withinmunicipal5km").hide();
    //         $("#withinghy").hide();
    //         $("#within15km").show();
    //     }
    // });

    function calculateLandRemaining(){
        var is_barak = $('#is_barak').val();
        var rastar_kaijo_b = $('#rastar_kaijo_b').val();
        var rastar_kaijo_k = $('#rastar_kaijo_k').val();
        var rastar_kaijo_lc = $('#rastar_kaijo_lc').val();

        var nodir_kaijo_b = $('#nodir_kaijo_b').val();
        var nodir_kaijo_k = $('#nodir_kaijo_k').val();
        var nodir_kaijo_lc = $('#nodir_kaijo_lc').val();

        var partial_b = $('#partial_b').val();
        var partial_k = $('#partial_k').val();
        var partial_lc = $('#partial_lc').val();

        if(is_barak == 1) {
            var rastar_kaijo_g = $('#rastar_kaijo_g').val();
            var nodir_kaijo_g = $('#nodir_kaijo_g').val();
            var partial_g = $('#partial_g').val();
        } else {
            var rastar_kaijo_g = '0';
            var nodir_kaijo_g = '0';
            var partial_g = '0';
        }

        // ($petitionDagDetails->dag_area_b * 6400) + ($petitionDagDetails->dag_area_k * 320) + ($petitionDagDetails->dag_area_lc * 20) + $petitionDagDetails->dag_area_g;

        if(is_barak == '1') {
            window.rastarkakhorlessa = parseInt(rastar_kaijo_b) * 6400 + parseInt(rastar_kaijo_k) * 320 + parseFloat(rastar_kaijo_lc) * 20 + parseFloat(rastar_kaijo_g);
            window.nodirkakhorlessa = parseInt(nodir_kaijo_b) * 6400 + parseInt(nodir_kaijo_k) * 320 + parseFloat(nodir_kaijo_lc) * 20 + parseFloat(nodir_kaijo_g);
            window.partiallessa = parseInt(partial_b) * 6400 + parseInt(partial_k) * 320 + parseFloat(partial_lc) * 20 + parseFloat(partial_g);
        }
        else {
            window.rastarkakhorlessa = parseInt(rastar_kaijo_b) * 100 + parseInt(rastar_kaijo_k) * 20 + parseFloat(rastar_kaijo_lc);
            window.nodirkakhorlessa = parseInt(nodir_kaijo_b) * 100 + parseInt(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
            window.partiallessa = parseInt(partial_b) * 100 + parseInt(partial_k) * 20 + parseFloat(partial_lc);
        }

        // console.log(rastarkakhorlessa, nodirkakhorlessa, partiallessa, partial_b, partial_k, partial_lc, partial_g);

        var mbigha = $('#b').val();
        var mkatha = $('#k').val();
        var mlessa = $('#l').val();
        var mganda = $('#g').val();

        if(is_barak == '1') {
            window.originallessa = parseInt(mbigha) * 6400 + parseInt(mkatha) * 320 + parseFloat(mlessa) * 20 + parseFloat(mganda);
        }
        else {
            window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseFloat(mlessa);
        }

        window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
        window.remaininglessa = originallessa - occupiedlessa;

        if(originallessa <= rastarkakhorlessa){
            alert("Road side reservation can't be greater then original land");
            $('#rastar_kaijo_b').val("0");
            $('#rastar_kaijo_k').val("0");
            $('#rastar_kaijo_lc').val("0");
            if(is_barak == '1') {
                $('#rastar_kaijo_g').val('0');
            }

            window.rastarkakhorlessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= nodirkakhorlessa){
            alert("River side reservation can't be greater then original land");
            $('#nodir_kaijo_b').val("0");
            $('#nodir_kaijo_k').val("0");
            $('#nodir_kaijo_lc').val("0");
            if(is_barak == '1') {
                $('#nodir_kaijo_g').val("0");
            }

            window.nodirkakhorlessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= partiallessa){
            alert("Partial land can't be greater then original land");
            $('#partial_b').val("0");
            $('#partial_k').val("0");
            $('#partial_lc').val("0");
            if(is_barak == '1') {
                $('#partial_g').val("0");
            }

            window.partiallessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }
        if(originallessa <= occupiedlessa){
            alert("Total Reservation land can't be greater then original land");
            $('#rastar_kaijo_b').val("0");
            $('#rastar_kaijo_k').val("0");
            $('#rastar_kaijo_lc').val("0");

            $('#nodir_kaijo_b').val("0");
            $('#nodir_kaijo_k').val("0");
            $('#nodir_kaijo_lc').val("0");

            $('#partial_b').val("0");
            $('#partial_k').val("0");
            $('#partial_lc').val("0");

            if(is_barak == '1') {
                $('#rastar_kaijo_g').val("0");
                $('#nodir_kaijo_g').val("0");
                $('#partial_g').val("0");
            }

            window.rastarkakhorlessa=0;
            window.nodirkakhorlessa=0;
            window.partiallessa=0;
            window.occupiedlessa = rastarkakhorlessa + nodirkakhorlessa + partiallessa;
            window.remaininglessa = originallessa - occupiedlessa;
        }


        //alert(remaininglessa);

        if(is_barak == '1') {
            var bigha_r = Math.floor(remaininglessa / 6400);
            var katha_r = Math.floor((remaininglessa - bigha_r * 6400) / 320);
            var lessa_r = Math.floor((remaininglessa - bigha_r * 6400 - katha_r * 320) / 20).toFixed(2);
            var ganda_r = (remaininglessa - bigha_r * 6400 - katha_r * 320 - lessa_r * 20).toFixed(2);
        } else {
            var bigha_r = Math.floor(remaininglessa / 100);
            var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
            var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2);
            var ganda_r = 0;
        }

        // console.log(bigha_r, katha_r, lessa_r, ganda_r);

        $('#rb').val(bigha_r);
        $('#rkatha').val(katha_r);
        $('#rl').val(lessa_r);
        if(is_barak == '1') {
            $('#rg').val(ganda_r);
        }
    }

    $('.cal_premium_e').change(function (e) {
        var baseurl = $('#baseurl').val();
        var is_barak = $('#is_barak').val();
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
    // $('.cal_premium_e').change(function (e) {
    //     var percent = $(this).val();
    //     var bigha = $('#rb').val();
    //     var katha = $('#rkatha').val();
    //     var lessa = $('#rl').val();
    //     var zonal_rate = $('#zonal_rate').val();
    //     var jati_janajati = document.getElementById("jati_janajati").checked;
    //     var freedom_fighter = document.getElementById("freedom_fighter").checked;
    //     var widow = document.getElementById("widow").checked;

    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + `index.php/calculate_premium/${percent}/${bigha}/${katha}/${lessa}/${zonal_rate}/${jati_janajati}/${freedom_fighter}/${widow}`,
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

    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + `index.php/calculate_premium/${percent}/${bigha}/${katha}/${lessa}/${zonal_rate}/${jati_janajati}/${freedom_fighter}/${widow}`,
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

    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url:baseurl + `index.php/calculate_premium/${percent}/${bigha}/${katha}/${lessa}/${zonal_rate}/${jati_janajati}/${freedom_fighter}/${widow}`,
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

    //     if(zonal_rate > 0) {
    //         $.ajax({
    //             url: baseurl + `index.php/calculate_premium/${percent}/${bigha}/${katha}/${lessa}/${zonal_rate}/${jati_janajati}/${freedom_fighter}/${widow}`,
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

    //on change applicant get respective details available in form
    $('#appl_name_conv').on('change', function(e){
        var baseurl = $('#baseurl').val();
        var unique_id = e.currentTarget.value;
        if(unique_id != '') {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: baseurl + 'index.php/get_single_pattadar_details',
                method: 'POST',
                data: {unique_id:unique_id},
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                    $.unblockUI();

                    let address = "";
                    if(response.data.pdar_add1 != "" && response.data.pdar_add1 != null) {
                        address += response.data.pdar_add1;
                    }
                    if(response.data.pdar_add2 != "" && response.data.pdar_add2 != null) {
                        address += response.data.pdar_add2;
                    }
                    if(response.data.pdar_add3 != "" && response.data.pdar_add3 != null) {
                        address += response.data.pdar_add3;
                    }

                    $('#guardian_name_conv').val(response.data.pdar_father);
                    $('#rel_conv').val(response.data.pdar_guard_reln);
                    $('#gender_conv').val(response.data.pdar_gender);
                    $('#dob_conv').val(response.data.pdar_minor_dob);
                    $('#address_conv').val(address);
                    $('#pdar_id_conv').val(response.data.pdar_id);
                },
                error: function (error) {
                    $.unblockUI();
                    alert("Something went wrong");
                }
            });
        }
    });

    //add applicant
    $('#btnAddNewConvAppl').on('click', function(e) {
        e.preventDefault();
        var baseurl = $('#baseurl').val();
        var pdar_id_conv = $('#pdar_id_conv').val();
        var appl_name_conv = $('#appl_name_conv').val();
        var guardian_name_conv = $('#guardian_name_conv').val();
        var rel_conv = $('#rel_conv').val();
        var gender_conv = $('#gender_conv').val();
        var dob_conv = $('#dob_conv').val();
        var address_conv = $('#address_conv').val();
        var case_no = $('#case_no').val();
        var applicant_name = $("#appl_name_conv option:selected").text();
        var dag_no = $('#dag_no').val();
        var patta_no = $('#patta_no').val();
        var patta_type = $('#patta_type').val();



        console.log(appl_name_conv, pdar_id_conv, guardian_name_conv, rel_conv, gender_conv, dob_conv, address_conv, case_no, applicant_name, dag_no, patta_no, patta_type);

        if(appl_name_conv != "" && pdar_id_conv != "" && guardian_name_conv != "" && rel_conv != "" && gender_conv != "" && address_conv != "" && case_no != "" && applicant_name != "" && dag_no != "" && patta_no != "" && patta_type != "") {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            var data = {appl_name_conv:appl_name_conv, guardian_name_conv:guardian_name_conv, rel_conv:rel_conv, gender_conv:gender_conv, dob_conv:dob_conv, address_conv:address_conv, case_no:case_no, applicant_name:applicant_name, dag_no:dag_no, patta_no:patta_no, patta_type:patta_type};

            $.ajax({
                url:baseurl + 'index.php/applicant_submit',
                method: 'POST',
                dataType: 'JSON',
                data: data,
                success: function (response) {
                    $.unblockUI();
                    console.log(response);
                    if(response.status == 'SUCCESS') {
                        $('#guardian_name_conv').val('');
                        $('#rel_conv').val('');
                        $('#gender_conv').val('');
                        $('#dob_conv').val('');
                        $('#address_conv').val('');
                        $('#pdar_id_conv').val('');
                        swal.fire("", response.msg, "success")
                        .then((value) => {
                            $tableAppend = $('#applicant_table_show_conv');
                            $pattadarAppend = $('#pattadar_inplace_alongwith');
                            $appl_name_conv = $('#appl_name_conv');
                            var respData = response.data;
                            var pattadars =respData.pattadars;
                            var unique_pattadars =respData.unique_pattadars;
                            var other_pattadars =respData.other_pattadars;

                            var html = "";
                            if(pattadars.length > 0) {
                                var i = 0;
                                pattadars.forEach(element => {
                                    var html1 = `
                                    <tr>
                                        <td>${i++}</td>
                                        <td>${element.pdar_name}</td>
                                        <td>${element.pdar_guardian}</td>
                                        <td>${element.relation_name}</td>
                                        <td>${element.gender_name}</td>
                                        <td>${element.pdar_add1} <br> ${(element.pdar_add2) ? element.pdar_add2 : ''}</td>
                                        <td>
                                    `;
                                    var html2 = '';
                                    unique_pattadars.forEach(ele => {
                                        if(ele.pdar_id == element.pdar_id) {
                                            html2 = `<button type="button" id="${element.pdar_id},${element.pdar_cron_no},${ele.dag_no},${ele.patta_no},${ele.dist_code},${ele.subdiv_code},${ele.cir_code},${ele.mouza_pargona_code},${ele.lot_no},${ele.vill_townprt_code},${ele.patta_type_code}" class="btn btn-sm btn-danger btnDelApplConv"><i class="fa fa-trash"></i></button>`;
                                        }
                                    });
                                    var html3 = `
                                        </td>
                                    </tr>`;
                                    html += html1 + html2 + html3;
                                });
                            }
                            $tableAppend.html(html);
                            var html = "";
                            if(pattadars.length > 0) {
                                var i = 0;
                                pattadars.forEach(element => {
                                    var html1 = `
                                    <tr>
                                        <td>${element.pdar_name}</td>
                                        <td>${element.pdar_guardian}</td>
                                        <td>
                                            <select id="inplacealong_${element.pdar_id}" name="inplacealong[]" class="form-control inplace_alongwith">
                                                <option value="inplace_${element.pdar_id}">Inplace (Pattadar going to be remove from old dag)</option>
                                            </select>
                                        </td>
                                    </tr>
                                    `;
                                    html += html1;
                                });
                            }
                            $pattadarAppend.html(html);

                            var optionhtml = '<option value="">---Select Applicant---</option>';
                            other_pattadars.forEach(element => {
                                optionhtml += `<option value="${element.unique_id}">${element.pdar_name} (${element.pdar_father})</option>`;
                            });
                            $appl_name_conv.html(optionhtml);

                        });
                    }
                    else if(response.status == 'FAILED') {
                        swal.fire("", response.msg, "error;")
                        .then((value) => {

                        });
                    }
                },
                error: function (error) {
                    $.unblockUI();
                    console.log(error);
                }

            })
        }
    });

    //delete applicant
    $(document).on('click', '.btnDelApplConv', function(e) {
        var id = e.currentTarget.id;
        var baseurl = $('#baseurl').val();
        var arr = id.split(",");
        var pdar_id = arr[0];
        var pdar_cron_no = arr[1];
        var dag_no = arr[2];
        var patta_no = arr[3];
        var dist_code = arr[4];
        var subdiv_code = arr[5];
        var cir_code = arr[6];
        var mouza_pargona_code = arr[7];
        var lot_no = arr[8];
        var vill_townprt_code = arr[9];
        var patta_type_code = arr[10];
        var case_no = $('#case_no').val();

        if(arr.length < 11 || case_no == '') {
            swal.fire("", "Couldnt find required parameters.", "error;")
            .then((value) => {

            });
        }
        else{
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: baseurl + 'index.php/applicant_delete',
                method: 'POST',
                dataType: 'JSON',
                data: {dist_code:dist_code, subdiv_code:subdiv_code, cir_code:cir_code, mouza_pargona_code:mouza_pargona_code, lot_no:lot_no, vill_townprt_code:vill_townprt_code, dag_no:dag_no, patta_no:patta_no, patta_type_code:patta_type_code, pdar_id:pdar_id, pdar_cron_no:pdar_cron_no, case_no:case_no},
                success: function (response) {
                    $.unblockUI();
                    if(response.status == 'SUCCESS') {
                        swal.fire("", response.msg, "success")
                        .then((value) => {
                            $tableAppend = $('#applicant_table_show_conv');
                            $pattadarAppend = $('#pattadar_inplace_alongwith');
                            var respData = response.data;
                            var pattadars =respData.pattadars;
                            var unique_pattadars =respData.unique_pattadars;

                            var html = "";
                            if(pattadars.length > 0) {
                                var i = 0;
                                pattadars.forEach(element => {
                                    var html1 = `
                                    <tr>
                                        <td>${i++}</td>
                                        <td>${element.pdar_name}</td>
                                        <td>${element.pdar_guardian}</td>
                                        <td>${element.relation_name}</td>
                                        <td>${element.gender_name}</td>
                                        <td>${element.pdar_add1} <br> ${(element.pdar_add2) ? element.pdar_add2 : ''}</td>
                                        <td>
                                    `;
                                    var html2 = '';
                                    unique_pattadars.forEach(ele => {
                                        if(ele.pdar_id == element.pdar_id) {
                                            html2 = `<button type="button" id="${element.pdar_id},${element.pdar_cron_no},${ele.dag_no},${ele.patta_no},${ele.dist_code},${ele.subdiv_code},${ele.cir_code},${ele.mouza_pargona_code},${ele.lot_no},${ele.vill_townprt_code},${ele.patta_type_code}" class="btn btn-sm btn-danger btnDelApplConv"><i class="fa fa-trash"></i></button>`;
                                        }
                                    });
                                    var html3 = `
                                        </td>
                                    </tr>`;
                                    html += html1 + html2 + html3;
                                });
                            }
                            $tableAppend.html(html);
                            var html = "";
                            if(pattadars.length > 0) {
                                var i = 0;
                                pattadars.forEach(element => {
                                    var html1 = `
                                    <tr>
                                        <td>${element.pdar_name}</td>
                                        <td>${element.pdar_guardian}</td>
                                        <td>
                                            <select id="inplacealong_${element.pdar_id}" name="inplacealong[]" class="form-control inplace_alongwith">
                                                <option value="inplace_${element.pdar_id}">Inplace (Pattadar going to be remove from old dag)</option>
                                            </select>
                                        </td>
                                    </tr>
                                    `;
                                    html += html1;
                                });
                            }
                            $pattadarAppend.html(html);
                        });
                    }
                    else if(response.status == 'FAILED') {
                        swal.fire("", response.msg, "error;")
                        .then((value) => {

                        });
                    }
                },
                error: function (err) {
                    $.unblockUI();
                    console.log(err);
                }
            });
        }
    });

    // function reset(){
    //     $('#appl_name_conv').val('');
    //     $('#guardian_name_conv').val('');
    //     $('#rel_conv').val('');
    //     $('#gender_conv').val('');
    //     $('#dob_conv').val('');
    //     $('#address_conv').val('');
    // }

});
</script>

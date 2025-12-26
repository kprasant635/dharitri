<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Register Office Mutation Cases ( Online )</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6"><p class="uni_text">Location Details </p></div>
                            <div class="col-lg-6"><p class="uni_text text-center">
							<?php
							if($application_ref_no){
								echo "অনলাইনত উল্লেখ নং : ".$application_ref_no;
							}
							?> 
							</p></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="myForm" method='post' action="<?php echo base_url() . "index.php/Serviceplus/save_office_mutation"; ?>">
                            <?php
                            foreach ($result as $key => $basic) :
							//var_dump($basic);
								?>
								<div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="dist_code" >
                                                    <option value="<?php echo $basic->dist_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getDistrictName($basic->dist_code); ?>
                                                    </option>
                                                </select>
                                            </div> 
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="subdiv_code" >
                                                    <option value="<?php echo $basic->subdiv_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getSubDivName($basic->dist_code, $basic->subdiv_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="cir_code">
                                                    <option value="<?php echo $basic->cir_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getCircleName($basic->dist_code, $basic->subdiv_code, $basic->cir_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="mouza_code">
                                                    <option value="<?php echo $basic->mouza_pargona_code; ?>"  selected>
                                                        <?php echo $this->utilityclass->getMouzaName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="lot_no">
                                                    <option value="<?php echo $basic->lot_no; ?>"  selected>
                                                        <?php echo $this->utilityclass->getLotLocationName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control" name="vill_townprt_code">
                                                    <option value='<?php echo $basic->vill_townprt_code; ?>' selected>
                                                        <?php echo $this->utilityclass->getVillageName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div> 
                                        <hr style="border-bottom: 2px solid #000;">
                                        <h2 class="red"><?php echo $this->lang->line('dag_details'); ?></h2>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 uni_text control-label requried hideonselect"><?php echo $this->lang->line('transfer_type') ?></label>
                                            <div  class="col-sm-3">
                                                <select class="form-control transfer-type" name="transfer_type" required="">
                                                    <option value="<?php echo $basic->trans_code; ?>" selected>
                                                        <?php echo $this->utilityclass->getTransferType($basic->trans_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control pattatype_nmae" id="new_patta_type" required name="patta_type">
                                                    <option value="<?php echo $basic->patta_type_code; ?>">
                                                        <?php echo $this->utilityclass->getPattaName($basic->patta_type_code); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                            <div class="col-lg-3">
                                                <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                                    <option value="<?php echo $basic->patta_no; ?>">
                                                        <?php echo $basic->patta_no; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                            <div class="col-lg-3">
                                                <?php $dag_no = $this->utilityclass->get_dag_no_from_dag_no_int($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code,$basic->patta_no,$basic->patta_type_code,$basic->dag_no); ?>
                                                <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                                    <option value="<?php echo $dag_no; ?>">
                                                        <?php echo $dag_no; ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr style="border-bottom: 2px solid #000;">
                                        <h2 class="red">Deed Details (if any)</h2>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2  uni_text control-label" id="change_text1">Deed No</label>
                                            <div class="col-sm-3">
                                                <input type="text"  maxlength="30" class="form-control" name="reg_deed_no" value="<?php echo $basic->deed_no; ?>">
                                            </div>
                                            <label for="inputEmail3" class="col-sm-2  uni_text control-label hiden"><?php echo $this->lang->line('deed_value') ?></label>
                                            <div class="col-sm-3">
                                                <input type="text"  maxlength="19" class="form-control" data-inputmask="'mask': '9[999999999]'" name="reg_deed_value" value="<?php echo $basic->deed_value; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2  uni_text control-label" id="change_text2"><?php echo $this->lang->line('deed_date') ?></label>
                                            <div class="col-sm-3">
                                                <div class="input-group add-on col-md-12 date datepicker" data-date-format="yyyy-mm-dd">
                                                    <input type="text" id="placehold2" readonly class="form-control dating" name="reg_deed_date" value="<?php echo $basic->deed_no==null?null:$basic->deed_date; ?>">
                                                    <div class="input-group-btn">
                                                        <a class="btn btn-default"><i class="fa fa-calendar"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-bottom: 2px solid #000;">
                                        <h2 class="red"><?php echo $this->lang->line('land_details'); ?></h2>

                                        <?php
                                          $dist_code = $this->session->userdata('dist_code');

                                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                            <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="top: 32px;">Total Land Area</label>
                                            <div class="col-sm-2">
                                                <p class="center bold">বিঘা</p>
                                                <input type="number"  class="form-control" value="<?php echo $basic->dag_area_b; ?>" readonly="" name='dag_area_b' placeholder="বিঘা">
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="center bold">কঠা</p>
                                                <input type="number"  class="form-control" value="<?php echo $basic->dag_area_k; ?>"  readonly="" name='dag_area_k' placeholder="কঠা">
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="center bold">ছটাক</p>
                                                <input type="number"  class="form-control"  name='dag_area_lc' placeholder="ছটাক" readonly="" value="<?php echo $basic->dag_area_lc; ?>">
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="center bold">গণ্ডা</p>
                                                <input type="number"  class="form-control"  name='dag_area_g' placeholder="গণ্ডা" readonly="" value="<?php echo $basic->dag_area_g; ?>">
                                            </div>
                                        </div>
                                        <!--Land Area To Be Mutated-->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label" style="top: 32px;">Mutation Land Area</label>
                                            <div class="col-sm-2">
                                                <p class="center bold">বিঘা</p>
                                                <input type="number" maxlength="6" class="form-control" value="<?php echo $basic->m_dag_area_b; ?>" name='m_dag_area_b' placeholder="বিঘা">
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="center bold">কঠা</p>
                                                <input type="number" maxlength="2" class="form-control" value="<?php echo $basic->m_dag_area_k; ?>" name='m_dag_area_k' placeholder="কঠা">
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="center bold">ছটাক</p>
                                                <input type="number" maxlength="7" class="form-control" value="<?php echo $basic->m_dag_area_lc; ?>" name='m_dag_area_lc' <?php echo $basic->dag_no; ?>placeholder="ছটাক">
                                            </div>
                                            <div class="col-sm-2">
                                                <p class="center bold">গণ্ডা</p>
                                                <input type="number" maxlength="7" class="form-control" value="<?php echo $basic->m_dag_area_g; ?>" name='m_dag_area_g' <?php echo $basic->dag_no; ?>placeholder="গণ্ডা">
                                            </div>
                                        </div>
                                          <?php }else{?>
                                        <!--Actual Land Area-->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;">Total Land Area</label>
                                            <div class="col-sm-3">
                                                <p class="center bold">বিঘা</p>
                                                <input type="number"  class="form-control" value="<?php echo $basic->dag_area_b; ?>" readonly="" name='dag_area_b' placeholder="বিঘা">
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="center bold">কঠা</p>
                                                <input type="number"  class="form-control" value="<?php echo $basic->dag_area_k; ?>"  readonly="" name='dag_area_k' placeholder="কঠা">
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="center bold">লেছা</p>
                                                <input type="number"  class="form-control"  name='dag_area_lc' placeholder="লেছা" readonly="" value="<?php echo $basic->dag_area_lc; ?>">
                                            </div>
                                        </div>
                                        <!--Land Area To Be Mutated-->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label" style="top: 32px;">Mutation Land Area</label>
                                            <div class="col-sm-3">
                                                <p class="center bold">বিঘা</p>
                                                <input type="number" maxlength="6" class="form-control" value="<?php echo $basic->m_dag_area_b; ?>" name='m_dag_area_b' placeholder="বিঘা">
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="center bold">কঠা</p>
                                                <input type="number" maxlength="2" class="form-control" value="<?php echo $basic->m_dag_area_k; ?>" name='m_dag_area_k' placeholder="কঠা">
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="center bold">লেছা</p>
                                                <input type="number" maxlength="7" class="form-control" value="<?php echo $basic->m_dag_area_lc; ?>" name='m_dag_area_lc' <?php echo $basic->dag_no; ?>placeholder="লেছা">
                                            </div>
                                        </div>
                                    <?php }?>
								

                                    <hr style="border-bottom: 2px solid #000;">
                                    <fieldset>
                                        <h2 class="red">Applicant Details</h2>
										<?php
										//var_dump($basic);
										foreach ($basic->declaration as $declaration):
											$document_path = $declaration->path;
											
											/////////////////////////////////
                                            //var_dump($declaration->path);
                                            ?>
											<iframe src="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$declaration->path .'&refNo=' . $application_ref_no .'&type='. 4  ?>" width="800px" height="600px" ></iframe>
											<?php
										endforeach;
										?>
										<?php
										//var_dump($basic);
                                        foreach ($basic->petitioner_details as $petitioner):
                                            //var_dump($petitioner)
											//echo $petitioner['pet_name'];
                                            ?>
                                            <div id="itemRows">
                                                <div class="col-lg-3">
                                                    <label class="center">Applicants Name : </label><br>
													<input type="text" class="form-control" name="applicant_name[]" value="<?php echo $petitioner->pet_name; ?>"/>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="center">Guardian Name : </label><br>
													<input type="text" class="form-control" name="guardian[]" value="<?php echo $petitioner->guard_name; ?>"/>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="center">Applicant Address : </label><br>
													<input type="text" name="add_1[]" class="form-control" value="<?php echo $petitioner->add1; ?>"/>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="center">Mobile: </label><br>
                                                    <input type="text" name="pdar_mobile[]" class="form-control" value="<?php echo $petitioner->pdar_mobile; ?>"/>
                                                </div>
                                                <input type="hidden" name="guard_rel[]" value="<?php echo $petitioner->guard_rel; ?>"/>
                                                <input type="hidden" name="add2[]" value="<?php echo $petitioner->add2; ?>"/>
                                                <input type="hidden" name="pet_is_copdar[]" value="<?php echo $petitioner->pet_is_copdar; ?>"/>
                                                <input type="hidden" name="pet_gender[]" value="<?php echo $petitioner->pet_gender; ?>"/>
                                                <input type="hidden" name="pet_minor_yn[]" value="<?php echo $petitioner->pet_minor_yn; ?>"/>
                                                <input type="hidden" name="pet_minor_dob[]" value="<?php echo $petitioner->pet_minor_dob; ?>"/>
                                                <input type="hidden" name="pet_mother[]" value="<?php echo $petitioner->pet_mother; ?>"/>
                                                <input type="hidden" name="pdar_mobile[]" value="<?php echo $petitioner->pdar_mobile; ?>"/>
                                                <input type="hidden" name="new_pattadar[]" value="<?php echo $petitioner->new_pattadar; ?>"/>
                                            </div>
                                        <?php endforeach; ?>
                                    </fieldset>
                                    <hr style="border-bottom: 2px solid #000;">
                                    <fieldset>
                                        <h2 class="red">In place / Along with Information</h2>
                                        <?php
                                        foreach ($basic->pattadar_details  as $pattadars):
                                            //var_dump($pattadars);
                                            ?>
                                            <div id="itemRowsPattadars">
                                                <div class="col-lg-4">
                                                    <label class="center bold">Pattadar Name : </label><br>
													<input type="text" class="form-control" name="pdar_name[]" required value="<?php echo $pattadars->pdar_name; ?>"></label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="center bold">Pattadar Guardian Name : </label><br>
													<input type="text" class="form-control" name="pdar_name[]" required value="<?php echo $pattadars->pdar_guardian; ?>"></label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="center bold">Inplace Alongwith Details: </label><br>
                                                    <select class="form-control inplace" name="striked_out[]" required>
                                                            <?php
                                                            if (trim($pattadars->striked_out) == 'F') {// F means full land
                                                                ?>
                                                                <option value="1"><?php echo $this->lang->line('inplace') ?></option>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <option value="0"><?php echo $this->lang->line('alongwith') ?></option>
                                                                <?php
                                                            }
                                                            ?>  
                                                        </select>
                                                </div>
                                                <input type="hidden" class="form-control" name="pdar_id[]" value="<?php echo $pattadars->pdar_id; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </fieldset>
									<hr style="border-bottom: 2px solid #000;">
                                    <fieldset>
                                        <h2 class="red">Other Attachments</h2>
                                        <?php
                                        foreach ($basic->attachment  as $attachment):
                                            //var_dump($attachment);
                                            ?>
											<h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $application_ref_no .'&type='. 4 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
											<?php 
										endforeach; 
										?>
                                    </fieldset>
                            <?php endforeach; ?>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required">Assign Officer</label>
                                <div class="col-sm-4">
                                    <select name="add_of_name" class="form-control" id="corequired" required>
                                        <option selected disabled><?php echo $this->lang->line('select_recieving_officer'); ?></option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u->user_code; ?>"><?php echo $u->username; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required"><?php echo $this->lang->line('designation'); ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control add_of_desig" name="add_of_desig" required>
                                        <option selected disabled><?php echo $this->lang->line('select_designation'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="application_ref_no" value="<?php echo $application_ref_no; ?>">
                            <input type="hidden" class="form-control" name="applid" value="<?php echo $applid; ?>">
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-4">
                                <button type="submit" name="ASTSTEP2Submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/serviceplus/office_mutation_cases" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.btn-success').click(function () {
        $(this).hide(); 
        document.getElementById("myForm").submit();
        //return false;
    });
</script>
<script type="text/javascript">
    $('.transfer-type').change(function (e) {
        var transfer_type_code = $(this).val();
        if (transfer_type_code == '08')
        {
            $('.hiden').hide();
            document.getElementById('change_text1').innerHTML = 'উইল বা প্ৰবেট নং';
            document.getElementById('change_text2').innerHTML = 'উইল বা প্ৰবেট তাৰিখ';
            $('#placehold1').attr("placeholder", "উইল বা প্ৰবেট নং");
            $('#placehold2').attr("placeholder", "উইল বা প্ৰবেট তাৰিখ");
            //document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Dag Number Already Exists</p></label>";
        }
        else if ((transfer_type_code == '11') || (transfer_type_code == '02') || (transfer_type_code == '01'))
        {
            //document.getElementById('all_patta_type').style.display = 'block';
            //document.getElementById('patta_type_excludin_aksona').style.display = 'none';
        }
        else
        {
            $('.hiden').show();
            document.getElementById('change_text1').innerHTML = "Deed No";
            document.getElementById('change_text2').innerHTML = "<?php echo $this->lang->line('deed_date'); ?>";
            $('#placehold1').attr("placeholder", "<?php echo $this->lang->line('registration_deed_no'); ?>");
            $('#placehold2').attr("placeholder", "<?php echo $this->lang->line('deed_date'); ?>");
            //document.getElementById('all_patta_type').style.display = 'none';
            //document.getElementById('patta_type_excludin_aksona').style.display = 'block';
        }
    });
</script>
<script type="text/javascript">
    $(window).on('load', function(){
        $('#query_modal').modal('show');
    });
    $(document).on('click','.btnMiscQueryAppl', function(){
        $('#query_modal').modal('hide');
    });
</script>
<div class="modal" id="query_modal" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">Notice</div>   
            <div class="modal-body">
            <p>The Applicant name in the applications received from RTPS are in English. Kidnly type the name in 
                <?php 
                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                { echo "<b>Bengali</b>"; }
                else { echo "<b>Assamese</b>";}
                ?> 
            before regestering the case in Dharitree.</p>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default btnMiscQueryAppl" id="">Close</button>
                </div>
        </div>
    </div>
</div>
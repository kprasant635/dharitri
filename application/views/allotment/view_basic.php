<div class="login">
    <div class="row">
        <div class="col-lg-12 ">

            <div class="col-lg-12 panel panel-default panel-body ">
                <div class="well well-sm mis_report">
                    <h2 class='uni_text' style="text-align: center; color: #2e4d8e">Registration Of Allotment Certificate to PP Conversion</h2>
                </div>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="center panel-title">
                            Application form
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php echo validation_errors(); ?>
						<?php
						$attributes = array('Allotment/index','class' => 'form-horizontal', 'id' => 'myform');
						echo form_open_multipart('Allotment/index',$attributes); ?>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                <div class="col-lg-2">
								<?php 
								$dist_name = $this->utilityclass->getDistrictName($certbasic->dist_code);
								$sub_div_name = $this->utilityclass->getSubDivName($certbasic->dist_code, $certbasic->subdiv_code);
								$cir_name = $this->utilityclass->getCircleName($certbasic->dist_code, $certbasic->subdiv_code, $certbasic->circle_code);
								$mouza_name = $this->utilityclass->getMouzaName($certbasic->dist_code, $certbasic->subdiv_code, $certbasic->circle_code,$certbasic->mouza_pargona_code); 
								$lot_name = $this->utilityclass->getLotLocationName($certbasic->dist_code, $certbasic->subdiv_code, $certbasic->circle_code,$certbasic->mouza_pargona_code,$certbasic->lot_no); 
								$vill_name = $this->utilityclass->getVillageName($certbasic->dist_code, $certbasic->subdiv_code, $certbasic->circle_code,$certbasic->mouza_pargona_code,$certbasic->lot_no,$certbasic->vill_townprt_code); 
								
								
								?>
								<input class="form-control districtselect" value='<?php echo $dist_name ?>' />
                                </div> 
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control districtselect" value='<?php echo $sub_div_name ?>' />
                                </div>
								<label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control districtselect" value='<?php echo $cir_name ?>' />
                                </div>
                            </div>

                            <div class="form-group">
                                
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                <div class="col-lg-2">
                                     <input class="form-control districtselect" value='<?php echo $mouza_name ?>' />
                                </div>
                            
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control districtselect" value='<?php echo $lot_name ?>' />
                                </div>
                                <label for="select" class="col-lg-2 required control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                <div class="col-lg-2">
                                    <input class="form-control districtselect" value='<?php echo $vill_name ?>' />
                                </div>
                            </div>
                            <hr>
							<?php $i=1;
							foreach($aloteepett as $aloteepet): ; ?>
							<p>Applicant Serial No. <?=$i;?></p>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 required control-label">Applicant Name</label>
                                <div class="col-lg-2">
                                    <input class="form-control " required value="<?php echo $aloteepet->alotee_name; ?>" placeholder="Type Name"  required name="applicant_name" />
                                </div>
                                <label for="select" class="col-lg-2 required control-label">Guardian Name</label>
                                <div class="col-lg-2">
                                    <input class="form-control " required value="<?php echo $aloteepet->alotee_gurdian; ?>" placeholder="Enter Guardian Name"  required name="gurdian_name" />
                                </div>
                                <label for="select" class="col-lg-2 required control-label">Relationship</label>
                                <div class="col-lg-2">
                                 <input class="form-control " required value="<?php echo $aloteepet->alotee_gurdian; ?>" placeholder="Enter Guardian Name"  required name="gurdian_name" />
                                </div>
                            </div>
							<div class='form-group'>
							<label for="select" class="col-lg-2 required control-label">Age</label>
                                <div class="col-lg-2">
                                    <input class="form-control" value="<?php echo $aloteepet->alotee_age; ?>" type="text" placeholder="Type Here"  required name="age" />
                            </div>
							
							<label for="select" class="col-lg-2 required control-label">Gender</label>
                                <div class="col-lg-2">
                                    <input class="form-control required" value='<?=$this->utilityclass->gender($aloteepet->alotee_gender);?>'>
										
                                </div>
							
							</div>
							<div class='form-group'>
							<label for="select" class="col-lg-4 control-label">Name of Wife if Applicant is Husband</label>
							<?php if($aloteepet->alotee_hus_wife=='y'){?>
                                <div class="col-lg-2">
                                    <input type='checkbox' checked class="form-control" id="mycheckbox" name="applicant_hus_wife" />
                                </div>
							<?php }
					
							else{?>
							<div class="col-lg-2">
                                    <input type='checkbox' class="form-control" id="mycheckbox" name="applicant_hus_wife" />
                                </div>
							<?php }?>
							<span id="mycheckboxdiv" >
							<label for="select" class="col-lg-3 red required control-label">Name of Wife/Husband</label>
                                <div class="col-lg-2">
                                    <input type='text' class="form-control" value=<?php echo $aloteepet->name_alotee_h_w; ?> required name="name_hus_wife" />
                                </div>
							</span>
							</div>
						
							
                            <div class="form-group">
                                 <label for="select" class="col-lg-2 control-label">Mobile No.</label>
                                <div class="col-lg-2">
                                    <input class="form-control" type="text" value="<?php echo $aloteepet->alotee_mobile; ?>" placeholder="Enter Mobile Number"  name="mobile_no" />
                                </div>

                                 <label class="col-lg-2 control-label uni_text">Aadhaar Status</label>
                                <div class="col-lg-2">
                                    <?php if(isset($aloteepet->auth_type) && $aloteepet->auth_type == 'AADHAAR'): 
                                    ?>
                                    <!-- <input type="text" disabled placeholder="Aadhar Number"  name="aadhar"  class="form-control"  > -->
                                    <b style="color:green;">Verified <i class="fa fa-check"></i></b>
                                <?php else: ?>
                                    <b style="color:red;">N/A</b>
                                <?php endif; ?>
                                </div>
								<label class="col-lg-2 control-label uni_text">PAN No. </label>
                                <div class="col-lg-2">
                                     <?php if(isset($aloteepet->auth_type) && $aloteepet->auth_type == 'PAN'):?>
                                    <input type="text"  placeholder="Enter PAN Number" value="<?php echo $aloteepet->alotee_pan_card; ?>"  name="pan"  class="form-control"  >
                                <?php else: ?>
                                    <b style="color:red;">N/A</b>
                                <?php endif; ?>
                                </div>
                            </div>
							<hr>
							<?php $i++; endforeach; ?>
                            <h4 class="center red"><u>Allotment Certificate Details </u></h4>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text">Allotment Certificate/Order No </label>
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" value='<?php echo $aloteedoc->certficate_no; ?>'  name="certificate_no"  class="form-control"  >
                                </div>
                                <label for="inputEmail" class="col-lg-3 uni_text control-label">Date of Certificate Issue </label>            
                                <div class="col-lg-3">
                                    <input type="text" required="" placeholder="Type Here" value='<?php echo date('d/m/Y',strtotime($aloteedoc->date_of_issue));  ?>'  name="cert_date"  class="form-control"  >
                                </div>   
                            </div>
                            <div class="hide form-group">
                                <label for="inputEmail" class="col-lg-3 control-label uni_text">Upload Certificate </label>
                                <div class="col-lg-2">
                                    <input type="file" id="fileupload" required="" placeholder="Type Here"  name="filename"  class="form-control"  >
                                </div>
                                <div class='img img-thumbnail' style='border:1px solid #000; width:60px; height:60px ' id="dvPreview">
							</div>
                            </div>
                            <hr>
                            <h4 class="center red "><u>Schedule Of Land Allotted</u></h4>
                            <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">Whether Applicant(s) is/are legeal heir(s) of original allottee  </label>
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="alot_y_n" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="alot_y_n" disabled=""  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                 
                            </div>
							<div class="form-group">
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">In Whose Name Allotted  </label>
                                <div class="col-lg-4">
                                    <input type="text" value='<?php echo $certbasic->name_of_allote; ?>'  class="form-control" name="alot_whos_name" required="" value="" >
                                </div>    
                            </div>
							<div class="form-group col-lg-offset-2 hide">
                                 <label for="select" class="col-lg-1 col-lg-offset-3 control-label">Circle</label>
                                <div class="col-lg-2">
                                    <input class="form-control" type="text" placeholder="Type Here"  required name="" />
                                </div>
                                 <label class="col-lg-1 control-label uni_text">Mouza </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  name=""  class="form-control"  >
                                </div>
								<label class="col-lg-1 control-label uni_text">Village </label>
                                <div class="col-lg-2">
                                    <input type="text" required="" placeholder="Type Here"  name=""  class="form-control"  >
                                </div>
                            </div>
							<div class="form-group ">
                                <label for="inputEmail" class="col-lg-5 control-label uni_text">Dag Number  </label>
                                <div class="col-lg-2">
									<input class="form-control dag_number" value='<?php echo $aloteedag->dag_no; ?>' />
									
                                </div>
								<label for="inputEmail" class="col-lg-2 hide control-label uni_text">Patta Number  </label>
                                <div class="col-lg-1">
                                    <input type="text"  class="form-control hide" disabled name="patta_no" placeholder='Patta' value="" >
                                </div>
								<label for="inputEmail" class="col-lg-2 hide control-label uni_text">Patta Type  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control hide" disabled name="p_type" placeholder='Patta Type' value="" >
                                </div>
                                  
                            </div>
                            <?php
                                ///////////// BARAK VALLEY CODE START HERE ////////////////
                                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                            ?>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2  control-label red">Total Area of the Dag  </label>
                                    <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                    <div class="col-lg-1">
                                        <input type="text" id='tb'  class="form-control" placeholder='Bigha' value='<?php echo $aloteedag->tot_area_b ?>' name="tot_bigha" required="" >
                                    </div>
                                    <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                    <div class="col-lg-1">
                                        <input type="text"  id='tk' class="form-control" placeholder='Katha' name="tot_katha" value='<?php echo $aloteedag->tot_area_k ?>'>
                                    </div>
                                    <label for="inputEmail" class="col-lg-1 control-label uni_text">Chatak  </label>
                                    <div class="col-lg-2">
                                        <input type="text" id='tl'  class="form-control" name="tot_lessa" placeholder='Lessa' value='<?php echo $aloteedag->tot_area_lc ?>'>
                                    </div>
                                    <label for="inputEmail" class="col-lg-1 control-label uni_text">Ganda  </label>
                                    <div class="col-lg-2">
                                        <input type="text" id='tg' class="form-control" name="tot_ganda" placeholder='Ganda' value='<?php echo $aloteedag->tot_area_g ?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label red">Area Alloted </label>
                                    <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                    <div class="col-lg-1">
                                        <input type="text"  class="form-control" name="alot_bigha" value='<?php echo $aloteedag->alot_area_b ?>' >
                                    </div>
                                    <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                    <div class="col-lg-1">
                                        <input type="text"  class="form-control" name="alot_katha" value='<?php echo $aloteedag->alot_area_k ?>' >
                                    </div>
                                    <label for="inputEmail" class="col-lg-1 control-label uni_text">Chatak  </label>
                                    <div class="col-lg-2">
                                        <input type="text"  class="form-control" name="alot_lessa" value='<?php echo $aloteedag->alot_area_lc ?>' >
                                    </div>  
                                    <label for="inputEmail" class="col-lg-1 control-label uni_text">Ganda </label>
                                    <div class="col-lg-2">
                                        <input type="text"  class="form-control" name="alot_lessa" value='<?php echo $aloteedag->alot_area_g ?>' >
                                    </div>  
                                </div>
                            <?php } else { ?>
							<div class="form-group">
								<label for="inputEmail" class="col-lg-3  control-label red">Total Area of the Dag  </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='tb'  class="form-control" placeholder='Bigha' value='<?php echo $aloteedag->tot_area_b ?>' name="tot_bigha" required="" >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  id='tk' class="form-control" placeholder='Katha' name="tot_katha" value='<?php echo $aloteedag->tot_area_k ?>'>
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text" id='tl'  class="form-control" name="tot_lessa" placeholder='Lessa' value='<?php echo $aloteedag->tot_area_lc ?>'>
                                </div>  
                            </div>
                            <div class="form-group">
							<label for="inputEmail" class="col-lg-3  control-label red">Area Alloted   </label>
                                <label for="inputEmail" class="col-lg-1  control-label uni_text">Bigha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="alot_bigha" value='<?php echo $aloteedag->alot_area_b ?>' >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Katha  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="alot_katha" value='<?php echo $aloteedag->alot_area_k ?>' >
                                </div>
                                <label for="inputEmail" class="col-lg-1 control-label uni_text">Lessa  </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" name="alot_lessa" value='<?php echo $aloteedag->alot_area_lc ?>' >
                                </div>  
                            </div>
                        <?php }?>
                            <div class="form-group">
                               <label for="inputEmail" class="col-lg-2 col-lg-offset-2 control-label uni_text">Allotment Under  </label>
                                <div class="col-lg-2">
									<?php $scname=$this->utilityclass->allote_scheme_name($certbasic->allotment_under); ?>
                                    <input class="form-control" name='alot_under' value='<?php echo $scname; ?>' />
                                </div>
                            </div>
                    </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

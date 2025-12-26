<div class="card">
                <div class="card-body">
                  <h5 class="card-title">Address Information</h5>
                  <p class="card-text">
              
                    <table class="table table-bordered">
                      <tr>
                        <th>District Name:</th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($app->dist_code)?>'>
                            <input type="hidden" name="dist_code" value="<?=$app->dist_code;?>">
                          </strong></td>
                        <th>Subdivision Name:</th>
                        <td class="text-warning">
                          <strong class="alert-warning"> 
                            <input type="text" name="subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?>'>
                            <input type="hidden" name="subdiv_code" value="<?=$app->subdiv_code;?>">
  
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <th>Circle Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?>' class="form-control input-sm" >
                            <input type="hidden" name="cir_code" value="<?=$app->cir_code;?>">
  
                          </strong></td>
                        <th>Mouza Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?>' >
                            <input type="hidden" name="mouza_pargona_code" value="<?=$app->mouza_code;?>">
  
                          </strong>
                        </td>
                      </tr>
                      <tr>
         
                        <th>Village Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?>' class="form-control input-sm" >
                            <input type="hidden" name="vill_townprt_code" value="<?=$app->village_code;?>">
  
                          </strong>
                        </td>
                      </tr>
          
  
                     </table>


                  </p>
                  <table class="table table-bordered">
                       
                  
                  <h5 class="card-title bgheading text-white p-2 text-center shadow-sm">Self declaration details</h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                    <?php
                    // echo "<pre>";
                    // var_dump($selfDeclarationDetails);
                    // echo "</pre>";
                    foreach($selfDeclarationDetails[0] as $key=>$self){
                      // var_dump($self->name.$key);
                      // echo "<tr><th>". $self->name ."</th><td>:". $key=='0'?'No':'Yes' ."</td></tr>";
                    ?>
                      <tr>
                        <th><?=$self->name ?></th>
                        <td>
                          
                          <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="Yes" class="form-check-input" <?php if ($self->status == "1"){ echo "checked"; }?>>
                          <label for="Yes">Yes</label>
       
                          
                          <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="No" class="form-check-input" <?php if ($self->status == "0"){ echo "checked"; } ?>>
                          <label for="Yes">No</label>
                        </td>
                      </tr>
                      <?php }?>
                    </table>
                  </p>
                  
                  <p class="card-text">
                    <?php $i=1; foreach($settlements as $settlement): ?>
                      <input type="hidden" name="pdar_type<?=$i?>" value="<?=$settlement->pdar_type;?>">
                      <!-- <input type="hidden" name="pdar_id<?=$i?>" value="<?=$settlement->chitha_pdar_id;?>"> -->
                    <?php if($settlement->pdar_type=='B'){ ?>
                      <h5 class="card-title bgheading text-white p-2 text-center shadow-sm">Applicant details</h5>
                      
                    <table class="table table-bordered">
                      <tr>
                        <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                        <th>Name of the applicant</th>
                        <td colspan="2">
                          <input type="text" name="pdar_name<?=$i?>" value="<?=$settlement->name_ass;?>" class="form-control input-sm">
                        </td>
                        <th>Guardian name</th>
                        <td colspan="2">
                          <input type="text" name="pdar_guardian<?=$i?>" value="<?=$settlement->gurdian_name_ass;?>" class="form-control input-sm" >
                        </td>
                      </tr>

                      <tr>
                       
                        <th>Relation</th>
                        <td>
                          <!-- <input type="text" value="<?=$settlement->gurdian_relation_id;?>" name="pdar_rel_guar<?=$i?>" class="form-control input-sm"> -->
                          <select
                          name="pdar_rel_guar<?=$i?>"
                          id="pdar_rel_guar<?=$i?>"
                          class="form-control"
                        >
                        <option value="1" <?php if ($settlement->gurdian_relation_id == "1"){ echo "selected"; }?>>Mother</option>
                          <option value="2" <?php if ($settlement->gurdian_relation_id == "2"){ echo "selected"; }?>>Father</option>
                          <option value="3" <?php if ($settlement->gurdian_relation_id == "3"){ echo "selected"; }?>>Husband</option>
                          <option value="4" <?php if ($settlement->gurdian_relation_id == "4"){ echo "selected"; }?>>Wife</option>
                          <option value="5" <?php if ($settlement->gurdian_relation_id == "5"){ echo "selected"; }?>>Guardian</option>
                          <option value="6" <?php if ($settlement->gurdian_relation_id == "6"){ echo "selected"; }?>>Supdt.Mother</option>
                          <option value="7" <?php if ($settlement->gurdian_relation_id == "7"){ echo "selected"; }?>>Guardian</option>
                        </select>
                        </td>
                        <th>Gender</th>
                        <td>
                          <!-- <input type="text" name="pdar_gender<?=$i?>" class="form-control input-sm" value="<?=$settlement->gender;?>"> -->
                          <select
                          name="pdar_gender<?=$i?>"
                          id="pdar_gender<?=$i?>"
                          class="form-control"
                          >
                        <option value="1" <?php if ($settlement->gender == "1"){ echo "selected"; }?>>Male</option>
                          <option value="2" <?php if ($settlement->gender == "2"){ echo "selected"; }?>>Female</option>
                          <option value="3" <?php if ($settlement->gender == "3"){ echo "selected"; }?>>Others</option>
                        </select>
                        </td>
                        <th>Mobile</th>
                        <td>
                          <input type="text" name="pdar_mobile<?=$i?>" value="<?=$settlement->mobile?>" class="form-control input-sm" >
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Permanent address
                        </th>
                        <td colspan="2">
                          <input type="text" name="pdar_add1<?=$i?>" value="<?=$settlement->per_add?>" class="form-control input-sm">
                        </td>
                
                        <th>Present address</th>
                        <td colspan="2">
                          <input type="text" name="pdar_add2<?=$i?>" value="<?=$settlement->pre_add?>" class="form-control input-sm" >
                        </td>

                      </tr>
                      <!-- <tr>
                   
                        <th>Individual land share</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->mbigha?>" name="i_area_b<?=$i?>" class="form-control input-sm">
                          </strong>
                          </td>
                          <td>
                          <span class="input-group-addon">Katha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->mkatha?>" name="i_area_k<?=$i?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_lc<?=$i?>" value="<?=$settlement->mlessa?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_g<?=$i?>" value="<?php if((in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))){ echo $settlement->mganda;} else {echo '0';} ?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <strong><input type="text" style="text-align: center;" value="<?php if((in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))){ echo $settlement->mkranti;} else {echo '0';} ?>" name="i_area_kr<?=$i?>" class="form-control input-sm" >
                          </strong>
                        </td>
                        <?php endif ; ?>
                      </tr> -->
                    </table>

                    <?php } else if($settlement->pdar_type=='SP'){ ?>
                      <h5 class="card-title"><u>Spouse details</u></h5>
                      <table class="table table-bordered">
                      <tr>
                        <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                        <th>Name of the applicant</th>
                        <td colspan="2">
                          <input type="text" name="pdar_name<?=$i?>" value="<?=$settlement->name_ass;?>" class="form-control input-sm">
                        </td>
                        <th>Guardian name</th>
                        <td colspan="2">
                          <input type="text" name="pdar_guardian<?=$i?>" value="<?=$settlement->gurdian_name_ass;?>" class="form-control input-sm" >
                        </td>
                      </tr>

                      <tr>
                       
                        <th>Relation</th>
                        <td>
                          <!-- <input type="text" value="<?=$settlement->gurdian_relation_id;?>" name="pdar_rel_guar<?=$i?>" class="form-control input-sm"> -->
                          <select
                          name="pdar_rel_guar<?=$i?>"
                          id="pdar_rel_guar<?=$i?>"
                          class="form-control"
                        >
                        <option value="1" <?php if ($settlement->gurdian_relation_id == "1"){ echo "selected"; }?>>Mother</option>
                          <option value="2" <?php if ($settlement->gurdian_relation_id == "2"){ echo "selected"; }?>>Father</option>
                          <option value="3" <?php if ($settlement->gurdian_relation_id == "3"){ echo "selected"; }?>>Husband</option>
                          <option value="4" <?php if ($settlement->gurdian_relation_id == "4"){ echo "selected"; }?>>Wife</option>
                          <option value="5" <?php if ($settlement->gurdian_relation_id == "5"){ echo "selected"; }?>>Guardian</option>
                          <option value="6" <?php if ($settlement->gurdian_relation_id == "6"){ echo "selected"; }?>>Supdt.Mother</option>
                          <option value="7" <?php if ($settlement->gurdian_relation_id == "7"){ echo "selected"; }?>>Guardian</option>
                        </select>
                        </td>
                        <th>Gender</th>
                        <td>
                          <!-- <input type="text" name="pdar_gender<?=$i?>" class="form-control input-sm" value="<?=$settlement->gender;?>"> -->
                          <select
                          name="pdar_gender<?=$i?>"
                          id="pdar_gender<?=$i?>"
                          class="form-control"
                          >
                        <option value="1" <?php if ($settlement->gender == "1"){ echo "selected"; }?>>Male</option>
                          <option value="2" <?php if ($settlement->gender == "2"){ echo "selected"; }?>>Female</option>
                          <option value="3" <?php if ($settlement->gender == "3"){ echo "selected"; }?>>Others</option>
                        </select>
                        </td>
                        <th>Mobile</th>
                        <td>
                          <input type="text" name="pdar_mobile<?=$i?>" value="<?=$settlement->mobile?>" class="form-control input-sm" >
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Permanent address
                        </th>
                        <td colspan="2">
                          <input type="text" name="pdar_add1<?=$i?>" value="<?=$settlement->per_add?>" class="form-control input-sm">
                        </td>
                
                        <th>Present address</th>
                        <td colspan="2">
                          <input type="text" name="pdar_add2<?=$i?>" value="<?=$settlement->pre_add?>" class="form-control input-sm" >
                        </td>

                      </tr>
                      <!-- <tr>
                   
                        <th>Individual land share</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->mbigha?>" name="i_area_b<?=$i?>" class="form-control input-sm">
                          </strong>
                          </td>
                          <td>
                          <span class="input-group-addon">Katha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->mkatha?>" name="i_area_k<?=$i?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_lc<?=$i?>" value="<?=$settlement->mlessa?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_g<?=$i?>" value="<?php if((in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))){ echo $settlement->mganda;} else {echo '0';} ?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <strong><input type="text" style="text-align: center;" value="<?php if((in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY)))){ echo $settlement->mkranti;} else {echo '0';} ?>" name="i_area_kr<?=$i?>" class="form-control input-sm" >
                          </strong>
                        </td>
                        <?php endif ; ?>
                      </tr> -->
                    </table>


                    <?php } $i++;?>
                    <?php endforeach;?>
                  </p>

                  <h5 class="card-title bgheading text-white p-2 text-center shadow-sm">Application Details</h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                    <?php if(isset($aadhar->is_aadhaar_verify)){ ?>
                        <tr>
                          <th>Aadhaar Verified</th>
                          <td>
                            <input type="text" name="aadhar_verified" value="<?php if ($aadhar->is_aadhaar_verify == '1') { echo 'Yes';}?>" class="form-control" disabled>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(isset($settlementsOne->occupation_period)){ ?>
                        <tr>
                          <th>Period of Possession</th>
                          <td>
                            <input type="text" name="period_possession" class="form-control" value="<?php echo $settlementsOne->occupation_period; ?>">
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(isset($settlementsOne->applicant_occupation)){ ?>
                        <tr>
                          <th>Occupation or Profession of the applicant</th>
                          <td>
                            <input type="text" name="occupation_applicant" value="<?=$settlementsOne->applicant_occupation?>" class="form-control">
                          </td>
                        </tr>
                        <?php } ?>
                        <!-- <tr>
                          <th>Nature of occupation over the land</th>
                          <td>
                            <input type="text" value="Agricultural" name="nature_occupation" class="form-control">
                          </td>
                        </tr> -->
                    </table>
                  </p>
                  <h5 class="card-title bgheading text-white p-2 text-center shadow-sm">Area Details</h5>
                  <p class="card-text">
                    <table class="table table-bordered">

                      <tr>
                        <th>Dag Number:</th>
                        <td>
                          <strong class="alert-warning">
                          <input type="text" name="dag_no" value='<?=$app->dag_no?>' class="form-control input-sm" readonly>
                          </strong>
                        </td>
                        
                        <th>Patta Number:</th>
                        <td>
                          <strong class="alert-warning">
                            <input type="text" name="patta_no" class="form-control input-sm" value='<?=$app->patta_no;?>' readonly>
                          </strong>
                        </td>
                        <th>Patta type:</th>
                        <td>
                          <strong class="alert-warning">
                          <input type="hidden" name="patta_type_code" value='<?=$pattaNo->patta_type_code?>' class="form-control input-sm" >

                            <input type="text" name="patta_type_code_display" value='<?=$this->utilityclass->getPattaType($pattaNo->patta_type_code)?>' class="form-control input-sm" readonly>
                          </strong>
                        </td>
                        
                      </tr>

                      <tr>
                        <th>Total Land Area in Selected Dag</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong>
                            <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$app->area_b?>" >
                          </strong>
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$app->area_k?>" class="form-control input-sm" >
                        </td>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$app->area_l?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$app->area_g?>" class="form-control input-sm" name="dag_area_g" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$app->area_kr?>" class="form-control input-sm" name="dag_area_kr" >
                        </td>
                        <?php endif ; ?>
                      </tr>

                      <?php $i=1; foreach($settlements as $settlement): if ($i==1){?>
                      <tr>
                        <th>Total applied area</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$settlement->applied_bigha?>" >
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?=$settlement->applied_katha?>" class="form-control input-sm s_dag_area_k" >
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$settlement->applied_lessa?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$settlement->applied_ganda?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$settlement->applied_kranti?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                        </td>
                        <?php endif ; ?>
                      </tr>
                      <?php $i++?>
                      <?php } endforeach; ?>
                  </table>
                  </p>

                  <!-- additional property -->
                  <?php if(isset($property) && !empty($property)) { ?>
                  <h5 class="card-title bgheading text-white p-2 text-center shadow-sm">Additonal Property Details</h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                    <?php $i=1; foreach($property as $adp): ?>
                      <tr>
                        <th>Dag Number:</th>
                        <td>
                          <strong class="alert-warning">
                          <input type="text" name="a_dag_no" value='<?=$adp->dag_no?>' class="form-control input-sm">
                          </strong>
                        </td>
                        
                        <th>Patta Number:</th>
                        <td>
                          <strong class="alert-warning">
                            <input type="text" name="a_patta_no" class="form-control input-sm" value='<?=$adp->patta_no;?>'>
                          </strong>
                        </td>
                        
                      </tr>

                      <tr>
                        <th>Total Additional Land Details</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong>
                            <input type="text" style="text-align: center;" name="a_bigha" class="form-control input-sm" value="<?=$adp->bigha?>" >
                          </strong>
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="a_katha" value="<?=$adp->katha?>" class="form-control input-sm" >
                        </td>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="a_lessa" class="form-control input-sm" value="<?=$adp->lessa?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$adp->ganda?>" class="form-control input-sm" name="a_ganda" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$adp->kranti?>" class="form-control input-sm" name="a_kranti" >
                        </td>
                        <?php endif ; ?>
                      </tr>
                      

                      <?php $i++ ?>
                      <?php endforeach; } ?>
                  </table>
                  </p>
                  <!-- additional property end -->

                  <?php if($nextKin){ ?>
                  <h5 class="card-title bgheading text-white p-2 text-center shadow-sm">Next of Kin details</h5>
                  <p class="card-text">
                    <table class="table">
                      <tr>
                        <th>Next of KIN name</th>
                        <th>Relation with KIN</th>
                        <th>Address of KIN</th>
                        <th>Mobile number</th>
                      </tr>
                      <?php $i=1; foreach($nextKin as $kin): ?>
                      <tr>
                        <td>
                          <input type="text" name="kin_name" value="<?=$kin->next_of_kin_name?>" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="kin_relation" value="<?=$kin->relation_with_kin?>" class="form-control">
                        </td>
                        <td>
                          <input type="text" class="form-control" value="<?=$kin->address?>" name="kin_address">
                        </td>
                        <td>
                          <input type="text" name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control">
                        </td>
                      </tr>
                      <?php $i++;?>
                      <?php endforeach;?>
                    </table>
                  </p>
                  <?php } ?>

                  <h5 class="card-title"><u>Supporting Documents</u></h5>
                  <p class="card-text">
                    <table class="table">
                    <?php foreach($document as $d): ?>
                      <tr>
                        <th>
                        <a target='download' href="<?php echo base_url(); ?>index.php/basundhara2/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->file_details;?></a>
                          <!-- <input type="hidden" name="case_no" value="<?=$d->case_no;?>"> -->
                          <!-- <input type="hidden" name="user_code" value="<?=$d->user_code;?>"> -->
                          <input type="hidden" name="file_name" value="<?=$d->name;?>">
                          <input type="hidden" name="file_type" value="<?=$d->content_type;?>">
                          <input type="hidden" name="file_path" value="<?=$d->path;?>">
                          <input type="hidden" name="file_details" value="<?=$d->file_details?>">
                      
                          <input type="hidden" name="mut_type" value="<?=$app->service_code?>">
                        </th>
                      </tr>
                      <?php endforeach; ?>
                    </table>
                  </p>

                  </div>
              </div>

         




              <ul class="list-inline pull-right">
                <li>
                  <button type="button" class="btn btn-primary next-step">
                    Save and continue
                  </button>
                </li>
              </ul>

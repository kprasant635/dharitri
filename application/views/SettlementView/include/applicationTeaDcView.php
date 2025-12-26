
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-primary mb-0"><span class="alert-info">Address Information</span></h5>

                  <p class="card-text" style="margin:0 auto;">
                  <table class="table mt-0">
                      <tr>
                        <th>District Name:</th>
                          <td class="text-warning">
                            <strong class="alert-warning">
                              <?=$this->utilityclass->getDistrictName($basic["dist_code"])?>
                            </strong>
                          </td>
                        <th>Subdivision Name:</th>
                        <td class="text-warning">
                          <strong class="alert-warning"> 
                            <?=$this->utilityclass->getSubDivName($basic["dist_code"],$basic["subdiv_code"])?>
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <th>Circle Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <?=$this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?>
                          </strong>
                        </td>
                        <th>Mouza Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <?=$this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?>
                          </strong>
                        </td>
                      </tr>
                      <tr>
         
                        <th>Village Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                              <?=$this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?>
                          </strong>
                        </td>
                      </tr>
          
  
                     </table>
                  </p>                       
                  <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Self declaration details</span></h5>
                  <p class="card-text" style="margin:0 auto;">
                    <table class="table">
                    <?php
                    foreach($selfDeclarationDetails[0] as $key=>$self){
                    ?>
                      <tr>
                        <th><?=$self->name ?></th>
                        <td class="text-center">
                          <strong>
                            <?php if ($self->status == "1"){ echo "Yes"; }?>
                            <?php if ($self->status == "0"){ echo "No"; } ?>
                          </strong>
                        </td>
                      </tr>
                      <?php }?>
                    </table>
                  </p>
                  
                 <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Applicant details</span></h5>
                  <p class="card-text" style="margin:0 auto;">
                    <?php $i=1; foreach($applicants_buyers as $settlement): ?>
                    <table class="table">
                      <tr>
                        <th rowspan="5" style="vertical-align : middle;text-align:center;">#<?=$i;?></th>
                        <th>Name</th>
                        <td>
                          <strong class="alert-warning">
                            <?=$settlement->pdar_name;?>
                          </strong>
                        </td>
                        <th>Guardian name</th>
                        <td>
                          <strong class="alert-warning">
                            <?=$settlement->pdar_guardian;?>
                          </strong>
                        </td>
                      </tr>

                      <tr>
                       
                        <th>Relation</th>
                        <td>
                          <strong class="alert-warning">
                              <?php 
                                if($settlement->pdar_rel_guar == "1"){
                                    echo "Mother"; 
                                }
                                if($settlement->pdar_rel_guar == "2"){ 
                                  echo "Father"; 
                                }
                                if($settlement->pdar_rel_guar == "3"){ 
                                  echo "Husband"; 
                                }
                                if($settlement->pdar_rel_guar == "4"){ 
                                  echo "Wife"; 
                                }
                                if($settlement->pdar_rel_guar == "5"){ 
                                  echo "Guardian"; 
                                }
                                if($settlement->pdar_rel_guar == "6"){ 
                                  echo "Supdt.Mother"; 
                                }
                              ?>
                          </strong>
                        </td>
                        <th>Gender</th>
                        <td>
                          <strong class="alert-warning">
                                <?php 
                                  if($settlement->pdar_gender == "1"){ 
                                    echo "Male"; 
                                  }
                                  if($settlement->pdar_gender == "2"){ 
                                    echo "Female"; 
                                  }
                                  if($settlement->pdar_gender == "3"){ 
                                    echo "Others"; 
                                  }
                                ?>
                          </strong>
                        </td>
                       
                      </tr>
                      <tr>
                        <th>Mobile</th>
                        <td>
                          <strong class="alert-warning">
                            <?=$settlement->pdar_mobile?>
                          </strong>
                        </td>
                        <th>
                          Permanent address
                        </th>
                        <td>
                          <strong class="alert-warning">
                            <?=$settlement->pdar_add1?>
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <th>Present address</th>
                        <td>
                          <strong class="alert-warning">
                            <?=$settlement->pdar_add2?>
                          </strong>
                        </td>
                      </tr>
                    </table>
                    <?php $i++;?>
                    <?php endforeach;?>
                  </p>

                <div class="row">
                    <div class="col-md-12">
                      <?php
                        if($applicants_encroacher == true){ 
                            ?>
                            <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Encroacher Details</span></h5>
                            <table class="table" style="margin:0 auto;">
                            <?php
                            $sl =1;
                            // foreach($applicants_encroacher as $riotee){
                            foreach($encdata as $riotee){
                            ?>
                            
                                <tr>
                                    <th rowspan="3" style="vertical-align : middle;text-align:center;">#<?=$sl++;?></th>
                                    
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                      <strong class="alert-warning">
                                        <?=$riotee[0]->name;?>
                                      </strong>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Father's name</th>
                                    <td>
                                      <strong class="alert-warning">
                                        <?=$riotee[0]->fathers_name;?>
                                      </strong>
                                    </td>
                                </tr>
                            
                          <?php 
                              }
                            ?>
                            </table>
                        <?php
                        }?>
                    </div>
                  </div>
                  

                  <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Application Details</span></h5>
                  <p class="card-text" style="margin:0 auto;">
                    <table class="table">
                        <tr>
                          <th>Aadhaar Verified</th>
                          <td>
                            <strong class="alert-warning">
                              <?php if ($aadhar->is_aadhaar_verify == '1') { echo 'Yes';}?>
                            </strong>
                          </td>
                        </tr>

                        <tr>
                          <th>Period of Possession</th>
                          <td>
                            <strong class="alert-warning"><?=$basic["period_possession"] ?></strong>
                           
                          </td>
                        </tr>
                        <tr>
                          <th>Occupation or Profession of the applicant</th>
                          <td>
                            <strong class="alert-warning"><?=$basic["occupation_applicant"]?></strong>
                            
                          </td>
                        </tr>

                         <tr>
                          <th>Caste</th>
                          <td>
                            <strong class="alert-warning"><?=$settlement->caste?></strong>
                            
                          </td>
                        </tr>

                    
                         <tr>
                          <th>Under BPL</th>
                          <td>
                            <strong class="alert-warning"><?=$settlement->bpl?></strong>
                            
                          </td>
                        </tr>
                    </table>
                  </p>

                  <?php if($nextKin){ ?>
                  <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Next of Kin details</span></h5>
                  <p class="card-text" style="margin:0 auto;">
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
                          <?=$kin->next_of_kin_name?>
                        </td>
                        <td>
                          <?=$kin->relation_with_kin?>
                        </td>
                        <td>
                          <?=$kin->address?>
                        </td>
                        <td>
                          <?=$kin->mobile_no?>
                        </td>
                      </tr>
                      <?php $i++;?>
                      <?php endforeach;?>
                    </table>
                  </p>
                  <?php } ?>


                  <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Board Details</span></h5>
                  <p class="card-text" style="margin:0 auto;">
                    <table class="table">
                       

                        <tr>
                          <th>Board Name</th>
                          <td>
                            <strong class="alert-warning"><?=$basic["cult_board"] ?></strong>
                           
                          </td>
                        </tr>
                        <tr>
                          <th>Board Registration Number</th>
                          <td>
                            <strong class="alert-warning"><?=$basic["cultboard_reg_no"]?></strong>
                            
                          </td>
                        </tr>
                    
                        <!-- <tr>
                          <th>Nature of occupation over the land</th>
                          <td>
                            <input type="text" value="Agricultural" name="nature_occupation" class="form-control">
                          </td>
                        </tr> -->
                    </table>
                  </p>

                 
                

                  <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Area Details</span></h5>
                  <p class="card-text" style="margin:0 auto;">
                    <table class="table">
                      <?php foreach($dags as $dags){ ?>
                      <tr>
                        <th>Dag Number:</th>
                        <td>
                          <strong class="alert-warning">
                            <?=$dags->dag_no?>
                          </strong>
                        </td>
                       
                        <th>Patta Number:</th>
                        <td>
                          <strong class="alert-warning">
                            <?=$dags->patta_no?>
                          </strong>
                        </td>
                        <th>Patta type:</th>
                        <td>
                          <strong class="alert-warning">
                          <?=$this->utilityclass->getPattaType($dags->patta_type_code)?>
                          
                          </strong>
                        </td>
                       
                      </tr>

                      <tr>
                        <th>Total Land Area in Selected Dag</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong>
                            <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags->dag_area_b?>" readonly>
                          </strong>
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags->dag_area_k?>" class="form-control input-sm" readonly>
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags->dag_area_lc?>" readonly>
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly>
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly>
                        </td>
                        <?php endif ; ?>
                      </tr>
                      <?php $hide = 'area_show'; 
                          if ($dags->land_type == 3 || $dags->land_type==1)
                            $hide = 'area_show';
                          else 
                          $hide = 'area_hide';
                       ?>   
                      <tr class='<?=$hide?>'>
                        <th class="text-primary">Applied area (Homestead)</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$dags->home_b?>" >
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="home_k" value="<?=$dags->home_k?>" class="form-control input-sm home_k" >
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <input type="text" style="text-align: center;" name="home_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags->home_lc?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->home_kr?>" class="form-control input-sm s_dag_area_kr" name="home_kr" >
                        </td>
                        <?php endif ; ?>
                      </tr>

                      <?php $hide = 'area_show'; 
                          if ($dags->land_type == 2)
                            $hide = 'area_show';
                          else 
                          $hide = 'area_hide';
                       ?>

                      <tr class='<?=$hide?>'>
                        <th class="text-primary">Applied area (Agricultural)</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$dags->agri_b?>" >
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="agri_k" value="<?=$dags->agri_k?>" class="form-control input-sm agri_k" >
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <input type="text" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$dags->agri_lc?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->agri_g?>" class="form-control input-sm agri_g" name="agri_g" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" >
                        </td>
                        <?php endif ; ?>
                      </tr>

                      
                      <?php }?>
                      <!-- <tr>
                        <th class="text-danger">Total applied area</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags->s_dag_area_b?>" >
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?=$dags->s_dag_area_k?>" class="form-control input-sm s_dag_area_k" >
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags->s_dag_area_lc?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->s_dag_area_g?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$dags->s_dag_area_kr?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                        </td>
                        <?php endif ; ?>
                      </tr> -->

                  </table>
                  </p>

                  <h5 class="card-title text-primary mt-5 mb-0"><span class="alert-info">Supporting Documents</span></h5> 
                  <p class="card-text" style="margin:0 auto;">
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
                      
                          <input type="hidden" name="mut_type" value="<?=$basic["service_code"]?>">
                        </th>
                      </tr>
                      <?php endforeach; ?>
                    </table>
                  </p>

            <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
                </div>
              </div>

         




              <ul class="list-inline pull-right">
                <li>
                  <button id="next_id" type="button" class="btn btn-primary next-step">
                    Next
                  </button>
                </li>
              </ul>

              
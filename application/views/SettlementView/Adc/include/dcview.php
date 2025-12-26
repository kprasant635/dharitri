<?php 
          $sl_count = 1; 
          ?>
<div class="tab-pane" role="tabpanel" id="step1">
              <h5 class="bg-info p-2 text-white shadow">
                Registration of SETTLEMENT KHAS LAND (
                <span class="bg-warning"><?=$_GET['case']?></span> )
              </h5>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Address Information</h5>
                  <p class="card-text">
                  <table class="table table-bordered">
                      <tr>
                        <th>District Name:</th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="dist_name" class="form-control input-sm" value='<?=$this->utilityclass->getDistrictName($basic["dist_code"])?>' readonly>
                            <input type="hidden" name="dist_code" value="<?=$basic["dist_code"];?>">
                          </strong></td>
                        <th>Subdivision Name:</th>
                        <td class="text-warning">
                          <strong class="alert-warning"> 
                            <input type="text" name="subdiv_name" class="form-control input-sm" value='<?=$this->utilityclass->getSubDivName($basic["dist_code"],$basic["subdiv_code"])?>' readonly>
                            <input type="hidden" name="subdiv_code" value="<?=$basic["subdiv_code"];?>">
  
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <th>Circle Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"])?>' class="form-control input-sm" readonly>
                            <input type="hidden" name="cir_code" value="<?=$basic["cir_code"];?>">
  
                          </strong></td>
                        <th>Mouza Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="mouza_name" class="form-control input-sm" value='<?=$this->utilityclass->getMouzaName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"])?>' readonly>
                            <input type="hidden" name="mouza_pargona_code" value="<?=$basic["mouza_pargona_code"];?>">
  
                          </strong>
                        </td>
                      </tr>
                      <tr>
         
                        <th>Village Name: </th>
                        <td class="text-warning">
                          <strong class="alert-warning">
                            <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($basic["dist_code"],$basic["subdiv_code"],$basic["cir_code"],$basic["mouza_pargona_code"],$basic["lot_no"],$basic["vill_townprt_code"])?>' class="form-control input-sm" readonly>
                            <input type="hidden" name="vill_townprt_code" value="<?=$basic["vill_townprt_code"];?>">
  
                          </strong>
                        </td>
                      </tr>
          
  
                     </table>
                  </p>
                  <table class="table table-bordered">
                       
                  
                  <h5 class="card-title"><u>Self declaration details</u></h5>
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
                          
                          <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="Yes" class="form-check-input" <?php if ($self->status == "1"){ echo "checked"; }?> disabled>
                          <label for="Yes">Yes</label>
       
                          
                          <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="No" class="form-check-input" <?php if ($self->status == "0"){ echo "checked"; } ?> disabled>
                          <label for="Yes">No</label>
                        </td>
                      </tr>
                      <?php }?>
                    </table>
                  </p>
                  
                 
                  <h5 class="card-title"><u>Applicant details</u></h5>
                  <p class="card-text">
                    <?php $i=1; foreach($applicants as $settlement): ?>
                    <table class="table table-bordered">
                      <tr>
                        <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                        <th>Name of the applicant</th>
                        <td colspan="2">
                          <input type="text" name="pdar_name<?=$i?>" value="<?=$settlement->pdar_name;?>" class="form-control input-sm" readonly>
                        </td>
                        <th>Guardian name</th>
                        <td colspan="2">
                          <input type="text" name="pdar_guardian<?=$i?>" value="<?=$settlement->pdar_guardian;?>" class="form-control input-sm" readonly>
                        </td>
                      </tr>

                      <tr>
                       
                        <th>Relation</th>
                        <td>
                          <input type="text" value="<?=$settlement->pdar_rel_guar;?>" name="pdar_rel_guar<?=$i?>" class="form-control input-sm" readonly>
                        </td>
                        <th>Gender</th>
                        <td>
                          <input type="text" name="pdar_gender<?=$i?>" class="form-control input-sm" value="<?=$settlement->pdar_gender;?>" readonly>
                        </td>
                        <th>Mobile</th>
                        <td>
                          <input type="text" name="pdar_mobile<?=$i?>" value="<?=$settlement->pdar_mobile?>" class="form-control input-sm" readonly>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Permanent address
                        </th>
                        <td colspan="2">
                          <input type="text" name="pdar_add1<?=$i?>" value="<?=$settlement->pdar_add1?>" class="form-control input-sm" readonly>
                        </td>
                
                        <th>Present address</th>
                        <td colspan="2">
                          <input type="text" name="pdar_add2<?=$i?>" value="<?=$settlement->pdar_add2?>" class="form-control input-sm" readonly>
                        </td>

                      </tr>
                      <!-- <tr>
                   
                        <th>Individual land share</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->i_area_b?>" name="i_area_b<?=$i?>" class="form-control input-sm" readonly>
                          </strong>
                          </td>
                          <td>
                          <span class="input-group-addon">Katha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->i_area_k?>" name="i_area_k<?=$i?>" class="form-control input-sm" readonly>
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_lc<?=$i?>" value="<?=$settlement->i_area_lc?>" class="form-control input-sm" readonly>
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_g<?=$i?>" value="<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ echo $settlement->i_area_g;} else {echo '0';} ?>" class="form-control input-sm" readonly>
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <strong><input type="text" style="text-align: center;" value="<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ echo $settlement->i_area_kr;} else {echo '0';} ?>" name="i_area_kr<?=$i?>" class="form-control input-sm" readonly>
                          </strong>
                        </td>
                      </tr> -->
                    </table>
                    <?php $i++;?>
                    <?php endforeach;?>
                  </p>

                  <h5 class="card-title"><u>Application Details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                        <tr>
                          <th>Aadhaar Verified</th>
                          <td>
                            <input type="text" name="aadhar_verified" value="<?php if ($aadhar->is_aadhaar_verify == '1') { echo 'Yes';}?>" class="form-control" disabled>
                          </td>
                        </tr>

                        <tr>
                          <th>Period of Possession</th>
                          <td>
                            <input type="text" name="period_possession" class="form-control" value="<?=$basic["period_possession"] ?>" readonly>
                          </td>
                        </tr>
                        <tr>
                          <th>Occupation or Profession of the applicant</th>
                          <td>
                            <input type="text" name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" class="form-control" readonly>
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
                  <h5 class="card-title"><u>Area Details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">

                      <tr>
                        <th>Dag Number:</th>
                        <td>
                          <strong class="alert-warning">
                          <input type="text" name="dag_no" value='<?=$dags["dag_no"]?>' class="form-control input-sm" readonly>
                          </strong>
                        </td>
                       
                        <th>Patta Number:</th>
                        <td>
                          <strong class="alert-warning">
                            <input type="text" name="patta_no" class="form-control input-sm" value='<?=$dags["patta_no"]?>' readonly>
                          </strong>
                        </td>
                        <th>Patta type:</th>
                        <td>
                          <strong class="alert-warning">
                          <input type="hidden" name="patta_type_code" value='<?=$dags["patta_type_code"]?>' class="form-control input-sm" >

                            <input type="text" name="patta_type_code_display" value='<?=$this->utilityclass->getPattaType($dags["patta_type_code"])?>' class="form-control input-sm" readonly>
                          </strong>
                        </td>
                       
                      </tr>

                      <tr>
                        <th>Total Land Area in Selected Dag</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong>
                            <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags["dag_area_b"]?>" readonly>
                          </strong>
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags["dag_area_k"]?>" class="form-control input-sm" readonly>
                        </td>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags["dag_area_lc"]?>" readonly>
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$dags["dag_area_g"]?>" class="form-control input-sm" name="dag_area_g" readonly>
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$dags["dag_area_kr"]?>" class="form-control input-sm" name="dag_area_kr" readonly>
                        </td>
                        <?php endif ; ?>
                      </tr>

                      <tr>
                        <th>Total applied area</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags["s_dag_area_b"]?>" >
                        </td>
                        <td>
                          <span class="input-group-addon">Katha</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?=$dags["s_dag_area_k"]?>" class="form-control input-sm s_dag_area_k" >
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <input type="text" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags["s_dag_area_lc"]?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <input type="text" style="text-align: center;" value="<?=$dags["s_dag_area_g"]?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <input type="text" style="text-align: center;" value="<?=$dags["s_dag_area_kr"]?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                        </td>
                        <?php endif ; ?>
                      </tr>

                  </table>
                  </p>

                  <?php if($nextKin){ ?>
                  <h5 class="card-title"><u>Next of Kin details</u></h5>
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
                          <input type="text" name="kin_name" value="<?=$kin->next_of_kin_name?>" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" name="kin_relation" value="<?=$kin->relation_with_kin?>" class="form-control" readonly>
                        </td>
                        <td>
                          <input type="text" class="form-control" value="<?=$kin->address?>" name="kin_address" readonly>
                        </td>
                        <td>
                          <input type="text" name="kin_contact_no" value="<?=$kin->mobile_no?>" class="form-control" readonly>
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
            </div>

             <!-- LM reporting starts here -->

             <div class="tab-pane" role="tabpanel" id="step2">
              <h5 class="bg-info p-2 text-white shadow">
                LM(A) reporting for Registration of SETTLEMENT KHAS LAND (
                <span class="bg-warning"><?=$_GET['case']?></span> )
              </h5>

              <div class="card">
                <div class="card-body lm-report">
                  <h5 class="card-title">
                    <u>LM Reporting format</u>
                  </h5>
                  <p class="card-text mt-3">
                    <!-- <form action="#"> -->

<!-- lm report -->
<!-- lm previous remarks -->

<?php $i=1; foreach($lmnotes as $lmnote):?>
  <div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Chitha Verified?</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="chiitha_verified"
        id="chiitha_verified1"
        value="YES" <?php if ($lmnote->chitha_verified == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="chiitha_verified"
        id="chiitha_verified2"
        value="NO" <?php if ($lmnote->chitha_verified == "NO"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
    </a>
  </div>
</div>


<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> VLB Verified?</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
        <input
          class="form-check-input"
          type="radio"
          name="vlb_verified"
          id="vlb_verified1"
          value="YES" <?php if ($lmnote->vlb_verified == "YES"){ echo "checked"; } ?> disabled
        />
        <label class="form-check-label" for="inlineRadio1">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input
          class="form-check-input"
          type="radio"
          name="vlb_verified"
          id="vlb_verified2"
          value="NO" <?php if ($lmnote->vlb_verified == "NO"){ echo "checked"; } ?> disabled
        />
        <label class="form-check-label" for="inlineRadio2">No</label>
      </div>
  </div>
</div>

<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Schedule of the land and area under
      occupation?</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified1"
        value="YES" <?php if ($lmnote->possession_verification == "YES"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified2"
        value="NO" <?php if ($lmnote->possession_verification == "NO"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Total area of the land under that
      Dag</label
    >
  </div>
  <div class="form-group col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">Total Bigha</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="text"
          name="total_bigha"
          id="total_bigha"
          value="<?=$lmnote->total_bigha?>" readonly
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Katha</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_Katha"
          class="form-control"
          id="total_katha"
          value="<?=$lmnote->total_Katha?>" readonly
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Lessa</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_lessa"
          class="form-control"
          id="total_lessa"
          value="<?=$lmnote->total_lessa?>" readonly
          
        />
      </div>
    </div>
    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Ganda</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_ganda"
          class="form-control"
          id="total_ganda"
          value="<?=$lmnote->total_ganda?>" readonly
          
        />
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Total Kranti</label>
      </div>
      <div class="col-8">
        <input
          type="text"
          name="total_kranti"
          class="form-control"
          id="total_kranti"
          value="<?=$lmnote->total_kranti?>" readonly
          
        />
      </div>
    </div>
<?php endif; ?>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Period of possession</label
    >
  </div>
  <div class="form-group col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">From Date</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="date"
          name="period_possession"
          id="period_possession"
          value="<?=$lmnote->period_possession?>" readonly
        />
      </div>
    </div>
    
  </div>
</div>
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Nature of possession –</label
    >
  </div>
  <div class="form-group col-md-6">
    <select
      name="nature_possession"
      id="nature_possession"
      class="form-control" disabled
    >
      <option value="Agricultural" <?php if ($lmnote->nature_possession == "Agricultural"){ echo "selected"; }?>>Agricultural</option>
      <option value="Business" <?php if ($lmnote->nature_possession == "Business"){ echo "selected"; }?>>Business</option>
      <option value="Residential" <?php if ($lmnote->nature_possession == "Residential"){ echo "selected"; }?>>Residential</option>
    </select>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether application is landless</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="is_landless"
        id="is_landless"
        value="YES" <?php if ($lmnote->is_landless == "YES"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="is_landless"
        id="is_landless"
        value="NO" <?php if ($lmnote->is_landless == "NO"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>
<!-- <div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong>.</strong> Copy of trace map of the proposed land
      clearly highlighting the propose land road/riverside reservation etc(if
      any)</label
    >
  </div>
  <div class="col-md-6">
    <input
      type="file"
      name="trace_map_copy"
      id="trace_map_copy"
      class="form-control"
    />
  </div>
</div> -->
<div class="row p-2 px-5">
  <div class="col-md-6 text-justify">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
      VGR/PGR/Wet Land/ CS Land/Khas Govt Land/NR Govt Land/Green Belt
      area/reserved for Govt departments/ancient monuments/reserved for other
      purposes/RF/PRF/Un-classed Forest land/under Wild Life Sanctuary/or any
      land barred for allotment/settlement by a judicial pronouncement or any
      Central or State Legislation.</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="land_falls"
        id="land_falls"
        value="YES" <?php if ($lmnote->land_falls == "YES"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="land_falls"
        id="land_falls"
        value="NO" <?php if ($lmnote->land_falls == "NO"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Whether the proposed land falls within
      15 KM radius from the periphery of GMC or within 5 KM periphery of other
      town or within 3 KM periphery of Revenue town.</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="falls_und_gmc"
        id="falls_und_gmc"
        value="YES" <?php if ($lmnote->falls_und_gmc == "YES"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="falls_und_gmc"
        id="falls_und_gmc"
        value="NO" <?php if ($lmnote->falls_und_gmc == "NO"){ echo "checked"; } ?> disabled
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Specific comment on roadside
      /riverside reservation (if any, along with provision kept for road/drain
      wherever necessary)</label
    >
  </div>
  <div class="col-md-6">
    <div id="road_side_reservation_hide" class="road_side_reservation_hide">
      <div class="form-group row mt-2">
        <label for="area-reserved" class="mb-2">Enter reserved area</label>
        <div class="col-4">
          <span class="input-group-addon">Bigha</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_bigha?>" class="form-control input-sm" name="reserved_bigha" id="reserved_bigha" readonly>
        </div>
        <div class="col-4">
          <span class="input-group-addon">Katha</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_katha?>" class="form-control input-sm" name="reserved_katha" id="reserved_katha" readonly>
        </div>
        <div class="col-4">
          <span class="input-group-addon">Lessa</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_lessa?>" class="form-control input-sm" name="reserved_lessa" id="reserved_lessa" readonly>
        </div>

      </div>
      <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
      <div class="form-group row mt-2">
        <div class="col-4">
          <span class="input-group-addon">Ganda</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_ganda?>" class="form-control input-sm" name="reserved_ganda" readonly>
        </div>
        <div class="col-4">
          <span class="input-group-addon">Kranti</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_kranti?>" class="form-control input-sm" name="reserved_kranti" readonly>
        </div>
      </div>
      <?php endif ;?>


      <div class="form-group row">
        <div class="col-12">
          <label for="roadside">Reserved are remarks(if any)</label>
          <textarea
            name="roadside_reservation"
            id="roadside_reservation"
            class="form-control"
            rows="2" readonly
          ><?=$lmnote->roadside_reservation?></textarea>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Zonal valuation/current market value
      of the proposed land and assessment of settlement premium as per standing
      Govt circular</label
    >
  </div>
  <div class="col-md-6">
    <input
      type="text"
      name="zonal_valuation"
      id="zonal_valuation"
      class="form-control" value="<?=$lmnote->zonal_valuation?>" readonly
    />
  </div>
</div>

<!-- <div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong>.</strong> Field visit report & geo tagged
      photograph of the land</label
    >
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-4">
        <label for="inputEmail4">Field report</label>
      </div>
      <div class="col-8">
        <input
          class="form-control"
          type="file"
          name="field_report"
          id="field_report"
        />
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-4">
        <label for="inputEmail4">Geo tagged photo</label>
      </div>
      <div class="col-8">
        <input
          type="file"
          name="geo_tag_photo"
          class="form-control"
          id="geo_tag_photo"
        />
      </div>
    </div>
  </div>
</div> -->

<div class="row p-2 px-5">
  <div class="col-md-6">
    <strong><?=$sl_count++?>.</strong> LM remarks</label>
  </div>
  <div class="col-md-6">
    <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2" readonly><?=$lmnote->lm_note?></textarea>
  </div>
</div>

<!-- lm report ends here -->

<?php endforeach;?>

<div class="row p-2 px-5" >
<div class="col-md-12"
<h5 class="card-title"><u>Uploaded Documents</u></h5>
<p class="card-text">
  <table class="table">
  <?php foreach($dhardocuments as $docs): ?>
    <tr>
      <th>
      <a target='download' href="<?php echo base_url(); ?><?=$docs->file_path;?>"><i class="fa fa-paperclip"></i> <?=$docs->file_name;?></a>
      </th>
    </tr>
    <?php endforeach; ?>
  </table>
</p>
</div>
</div>

</p>
</div>
</div>

  <ul class="list-inline pull-right">
  <li>
  <button type="button" class="btn btn-default prev-step">
    <?php echo $this->lang->line('previous'); ?>
  </button>
  </li>
  <li>
  <button type="button" class="btn btn-primary next-step">
  <?php echo $this->lang->line('next'); ?>
  </button>
  </li>
  </ul>
  </div>


      
<div class="tab-pane" role="tabpanel" id="step3">
  <h5 class="bg-info p-2 text-white shadow">
    CO report for Registration of SETTLEMENT KHAS LAND (
    <span class="bg-warning"><?=$_GET['case']?></span> )
  </h5>
  <div class="card">
    <div class="card-body">
    <?php
        if ($this->session->flashdata('message')):
          ?>
          <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><?php echo $this->session->flashdata('message');?></strong>
          </div>
          <?php endif; ?>
      <h5 class="card-title">
        <u>CO Report</u>
      </h5>
      <div class="card-text mt-2 co-report">

      <?php
        if($proceedings){
          // var_dump($proceedings);
      ?>
<div class="row p-2 px-5" >
  <h5 class="bg-danger p-2 text-white shadow">
    Previous remark
  </h5>
  <table class="table table-bordered">
    <tr>
      <th>Date of remark</th>
      <th>Remark from</th>
      <th>Remark</th>
    </tr>
    <?php 
    $i=1;
    $length=count($proceedings);
    foreach($proceedings as $pro):
    if ($i===$length){
    ?>
    <tr>
      <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
      <td><?=$pro->office_from;?></td>
      <td><span class="bg-warning text-white"><?=$pro->note_on_order;?></span></td>
    </tr>
    <?php } $i++; endforeach;?>
  </table>
</div>
<?php } ?>


      <?php
        $pending_officer = $basic["pending_officer"];
        $from_office = $basic["from_office"];
      ?>

        
      </div>
    </div>
  </div>

  <ul class="list-inline pull-right">
    <li>
    <button type="button" class="btn btn-default prev-step">
      <?php echo $this->lang->line('previous'); ?>
    </button>
    </li>
    <li>
    <button type="button" class="btn btn-primary next-step">
    <?php echo $this->lang->line('next'); ?>
    </button>
    </li>
    </ul>


</div>


<div class="tab-pane" role="tabpanel" id="step4">

<!-- proceeding start -->
<div class="row p-2 px-5" >
  <h5 class="bg-danger p-2 text-white shadow">
    All proceedings
  </h5>
  <table class="table table-bordered">
    <tr>
      <th>Date of remark</th>
      <th>Remark from</th>
      <th>Remark</th>
    </tr>
    <?php $i=1; foreach($proceedings as $pro): ?>
    <tr>
      <td><?=date('Y-m-d h:i:s', strtotime($pro->date_entry));?></td>
      <td><?=$pro->office_from;?></td>
      <td><span class="bg-warning text-white"><?=$pro->note_on_order;?></span></td>
    </tr>
    <?php endforeach;?>
  </table>
</div>
<!-- proceeding end -->

<ul class="list-inline pull-right">
<li>
<button type="button" class="btn btn-default prev-step">
  Previous
</button>
</li>
<li>
<button type="button" class="btn btn-default next-step">
  Skip
</button>
</li>
<li>
<button
  type="button"
  class="btn btn-primary btn-info-full next-step"
>
  Save and continue
</button>
</li>
</ul>
</div>
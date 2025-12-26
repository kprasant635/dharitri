<style>

  .tab-content .card:hover{
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    /* box-shadow: none !important; */
  }
  .tab-content .card:active{
    /* left: 0;
    right: 0;
    top: 0;
    bottom: 0; */
    box-shadow: none !important;
  }

  .wizard {
    margin: 10px auto;
}

.wizard .nav-tabs {
    position: relative;
    margin: 0px auto;
    margin-bottom: 0;
    border-bottom-color: #e0e0e0;
}

.wizard > div.wizard-inner {
    position: relative;
}


.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #fff;
    cursor: default;
    border: 0;
    background-color: #005B96 !important;
    text-decoration: none;
}
.wizard li.active{
    background: #005B96;
    padding: 5px;
    box-shadow: 1px 0px 1px 1px;
    
}

.wizard .nav-tabs > li {
    width: 16%;
    border: none;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 45%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #ffffff;
}

.wizard .nav-tabs > li a {
    text-align: center;
    /* width: 90%; */
    margin-bottom: 10px;
    /* padding: 0; */
}
.wizard .nav-tabs > li a:hover {
  background-color: transparent !important;
}



/* .wizard .tab-pane {
    position: relative;
    padding-top: 15px;
} */

/* .wizard h3 {
    margin-top: 0;
} */
/* 
@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
} */
/* div alternate color */
div.lm-report > div:nth-of-type(odd) {
    background: #f2fdff;
}

</style>

<script>
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

</script>

<div class="container">
  <div class="row">
      <div class="wizard">
        <div class="wizard-inner">
          <div class="connecting-line"></div>
          <ul class="nav nav-tabs shadow" role="tablist">
            <li role="presentation" class="active">
              <a
                class="test"
                href="#step1"
                data-toggle="tab"
                aria-controls="step1"
                role="tab"
                title="Step 1"
              >
                <span class="round-tab">
                  <strong>Application</strong>
                </span>
              </a>
            </li>

            <li role="presentation" class="disabled">
              <a
                href="#step2"
                data-toggle="tab"
                aria-controls="step2"
                role="tab"
                title="Step 2"
              >
                <span class="round-tab">
                  <strong>Lot Mondal</strong>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a
                href="#step3"
                data-toggle="tab"
                aria-controls="step3"
                role="tab"
                title="Step 3"
              >
                <span class="round-tab">
                  <strong>Circle Officer</strong>
                </span>
              </a>
            </li>

            <li role="presentation" class="disabled">
              <a
                href="#step4"
                data-toggle="tab"
                aria-controls="step4"
                role="tab"
                title="step 4"
              >
                <span class="round-tab">
                  <strong>ADC</strong>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a
                href="#step5"
                data-toggle="tab"
                aria-controls="step5"
                role="tab"
                title="step 5"
              >
                <span class="round-tab">
                  <strong>DC</strong>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a
                href="#complete"
                data-toggle="tab"
                aria-controls="complete"
                role="tab"
                title="Complete"
              >
                <span class="round-tab">
                  <strong>Department</strong>
                </span>
              </a>
            </li>
          </ul>
        </div>

        <form role="form" method="post" action="<?php echo base_url()?>index.php/basundhara2/settlementApPost" enctype="multipart/form-data">
          <input type="hidden" name="service_code" value="<?=$app->service_code?>">
          <input type="hidden" name="lot_no" value="<?=$app->lot_no?>">
          <input type="hidden" name="application_no" value="<?=$_GET['app']?>">
          <input type="hidden" name="ref_no" value="<?=$app->ref_no?>">
          <input type="hidden" name="is_urban" value=" <?=$settlementsOne->is_rural_urban; ?>">

          <?php 
          $sl_count = 1; 
          ?>
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="step1">
              <h5 class="bg-info p-2 text-white shadow">
                Registration of SETTLEMENT AP TRANSFER (
                <span class="bg-warning"><?=$_GET['app']?></span> )
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
                          
                          <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="Yes" class="form-check-input" <?php if ($self->status == "1"){ echo "checked"; }?>>
                          <label for="Yes">Yes</label>
       
                          
                          <input type="radio" name="<?=$self->name?>" id="<?=$self->name?>" value="No" class="form-check-input" <?php if ($self->status == "0"){ echo "checked"; } ?>>
                          <label for="Yes">No</label>
                        </td>
                      </tr>
                      <?php }?>
                    </table>
                  </p>
                  
                 
                  <h5 class="card-title"><u>First Party Information/Applicant details</u></h5>
                  <p class="card-text">
                    <?php $i=1; foreach($settlements as $settlement): ?>
                      <input type="hidden" name="pdar_id<?=$i?>" value="<?=$settlement->chitha_pdar_id;?>">
                      <input type="hidden" name="pdar_type<?=$i?>" value="<?=$settlement->pdar_type;?>">
                    <table class="table table-bordered">
                      <tr>
                        <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                        <th>Name of the applicant</th>
                        <td colspan="2">
                          <input type="text" name="pdar_name<?=$i?>" value="<?=$settlement->name_ass;?>" class="form-control input-sm">
                        </td>
                        <th>Gurdian name</th>
                        <td colspan="2">
                          <input type="text" name="pdar_guardian<?=$i?>" value="<?=$settlement->gurdian_name_ass;?>" class="form-control input-sm" >
                        </td>
                      </tr>

                      <tr>
                       
                        <th>Relation</th>
                        <td>
                          <input type="text" value="<?=$settlement->gurdian_relation_id;?>" name="pdar_rel_guar<?=$i?>" class="form-control input-sm">
                        </td>
                        <th>Gender</th>
                        <td>
                          <input type="text" name="pdar_gender<?=$i?>" class="form-control input-sm" value="<?=$settlement->gender;?>">
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
                
                        <th>Presend address</th>
                        <td colspan="2">
                          <input type="text" name="pdar_add2<?=$i?>" value="<?=$settlement->pre_add?>" class="form-control input-sm" >
                        </td>

                      </tr>
                      <tr>
                   
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
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_g<?=$i?>" value="<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ echo $settlement->mganda;} else {echo '0';} ?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <strong><input type="text" style="text-align: center;" value="<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ echo $settlement->mkranti;} else {echo '0';} ?>" name="i_area_kr<?=$i?>" class="form-control input-sm" >
                          </strong>
                        </td>
                      </tr>
                    </table>
                    <?php $i++;?>
                    <?php endforeach;?>
                  </p>

                  <h5 class="card-title"><u>Application Details</u></h5>
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
                            <input type="text" name="period_possession" class="form-control" value=" <?php echo $settlementsOne->occupation_period; ?>">
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
                  <h5 class="card-title"><u>Area Details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">

                      <tr>
                        <th>Dag Number:</th>
                        <td>
                          <strong class="alert-warning">
                          <input type="text" name="dag_no" value='<?=$app->dag_no?>' class="form-control input-sm">
                          </strong>
                        </td>
                        <?php if(isset($property) && !empty($property)) { ?>
                          <?php $i=1; foreach($property as $adp): ?>
                        <th>Patta Number:</th>
                        <td>
                          <strong class="alert-warning">
                            <input type="text" name="patta_no" class="form-control input-sm" value='<?=$adp->patta_no;?>'>
                          </strong>
                        </td>
                        <th>Patta type:</th>
                        <td>
                          <strong class="alert-warning">
                            <input type="text" name="patta_type_code" value='<?=$pattaNo->patta_type_code?>' class="form-control input-sm" >
                          </strong>
                        </td>
                        <?php endforeach; } ?>
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
                  <?php if($nextKin) { ?>
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
                  <?php }?>

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

            <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
                </div>
              </div>

         




              <ul class="list-inline pull-right">
                <li>
                  <button type="button" class="btn btn-primary next-step">
                    Save and continue
                  </button>
                </li>
              </ul>
            </div>

            <!-- LM reporting starts here -->

            <div class="tab-pane" role="tabpanel" id="step2">
              <h5 class="bg-info p-2 text-white shadow">
                LM(A) reporting for Registration of SETTLEMENT AP TRANSFER (
                <span class="bg-warning"><?=$_GET['app']?></span> )
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
<div class="row p-2 px-5" >
  <h5 class="bg-danger p-2 text-white shadow">
    Previous remarks
  </h5>
  <table class="table table-bordered">
    <tr>
      <th>Date of remark</th>
      <th>Remark from</th>
      <th>Remark</th>
    </tr>
    <tr>
      <td>2021-07-12</td>
      <td>Circle Officer</td>
      <td><span class="bg-warning text-white">Please note this remark and reverify all the documents.</span></td>
    </tr>
  </table>
</div>

<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Possession verified?</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified1"
        value="Yes"
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified2"
        value="No"
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Ceiling Limit of the land</label
    >
  </div>
  <div class="col-md-6">
    <input
      type="text"
      name="ceiling_limit"
      id="ceiling_limit"
      class="form-control"
      placeholder="Enter ceilling limit"
    />
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
    <div class="form-check form-check-inline">
      <input type="radio" onclick="roadSideReservYes();" class="form-check-input roadside_comment_check1" name="roadside_comment_check" id="roadside_comment_check1" value="Yes">
      <label for="roadside">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input type="radio"  onclick="roadSideReservNo();" class="form-check-input roadside_comment_check2" name="roadside_comment_check" id="roadside_comment_check2 value="No">
      <label for="roadside">No</label>
    </div>
    <div id="road_side_reservation_hide" class="road_side_reservation_hide" style="display: none;">
      <div class="form-group row mt-2">
        <label for="area-reserved" class="mb-2">Enter reserved area</label>
        <div class="col-4">
          <span class="input-group-addon">Bigha</span>
          <input type="text" style="text-align: center;" value="0" class="form-control input-sm" name="reserved_bigha" id="reserved_bigha">
        </div>
        <div class="col-4">
          <span class="input-group-addon">Katha</span>
          <input type="text" style="text-align: center;" value="0" class="form-control input-sm" name="reserved_katha" id="reserved_katha" >
        </div>
        <div class="col-4">
          <span class="input-group-addon">Lessa</span>
          <input type="text" style="text-align: center;" value="0" class="form-control input-sm" name="reserved_lessa" id="reserved_lessa" >
        </div>

      </div>
      <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
      <div class="form-group row mt-2">
        <div class="col-4">
          <span class="input-group-addon">Ganda</span>
          <input type="text" style="text-align: center;" value="0" class="form-control input-sm" name="reserved_ganda" >
        </div>
        <div class="col-4">
          <span class="input-group-addon">Kranti</span>
          <input type="text" style="text-align: center;" value="0" class="form-control input-sm" name="reserved_kranti" >
        </div>
      </div>
      <?php endif ;?>


      <div class="form-group row">
        <div class="col-12">
          <label for="roadside">Comment(if any)</label>
          <textarea
            name="roadside_reservation"
            id="roadside_reservation"
            class="form-control"
            rows="2"
          ></textarea>
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
      class="form-control"
    />
  </div>
</div>
<div class="row p-2 px-5" >
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Copy of trace map of the proposed land
      clearly highlighting the propose land road/riverside reservation etc(if
      any)</label
    >
  </div>
  <div class="col-md-6">
    <input type="hidden" name="trace_map_name" value="Trace Map Copy">
    <input
      type="file"
      name="trace_map_copy"
      id="trace_map_copy"
      class="form-control"
    />
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Chitha copy of the proposed
      land</label
    >
  </div>
  <div class="col-md-6">
    <input type="file" name="chitha_copy" id="chitha_copy" class="form-control" />
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <strong><?=$sl_count++?>.</strong> LM remarks</label>
  </div>
  <div class="col-md-6">
    <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2"></textarea>
  </div>
</div>

<!-- lm report ends here -->


</p>
</div>
</div>


  <ul class="list-inline pull-right">
  <li>
  <button type="button" class="btn btn-default prev-step">
    Previous
  </button>
  </li>
  <li>
  <button type="submit" class="btn btn-primary next-step">
    Save and continue
  </button>
  </li>
  </ul>
  </div>
</form>




<div class="tab-pane" role="tabpanel" id="step3">
<h3>Step 3</h3>
<p>This is step 3</p>
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
<div class="tab-pane" role="tabpanel" id="complete">
<h3>Complete</h3>
<p>You have successfully completed all steps.</p>
</div>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>

<!-- Script for roadside side reservation  -->
<!-- #road_side_reservation_hide -->
<script>
 function roadSideReservYes() {
  var x = document.getElementById("road_side_reservation_hide");
  if (x.style.display === "none") {
    x.style.display = "block";
  }
}
  //  else {
  //   x.style.display = "none";
  // }
  function roadSideReservNo() {
  var x = document.getElementById("road_side_reservation_hide");
  if (x.style.display === "block") {
    x.style.display = "none";
  }
}

// zonal value validation
$("#zonal_valuation").keyup(function(){
          var nodir_kaijo_b = $('#reserved_bigha').val();
          var nodir_kaijo_k = $('#reserved_katha').val();
          var nodir_kaijo_lc = $('#reserved_lessa').val();
          window.nodirkakhorlessa = parseInt(nodir_kaijo_b) * 100 + parseInt(nodir_kaijo_k) * 20 + parseFloat(nodir_kaijo_lc);
          console.log(window.nodirkakhorlessa);
          var mbigha = $('.s_dag_area_b').val();
          var mkatha = $('.s_dag_area_k').val();
          var mlessa = $('.s_dag_area_lc').val();
          //window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
          window.originallessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseFloat(mlessa);
          console.log(window.originallessa);
          // alert(originallessa);
          window.occupiedlessa = nodirkakhorlessa;
          window.remaininglessa = originallessa - occupiedlessa;
          if(originallessa <= nodirkakhorlessa){
              alert("Road/River side reservation can't be greater then original land");
              $('#reserved_bigha').val("0");
              $('#reserved_katha').val("0");
              $('#reserved_lessa').val("0");
              window.nodirkakhorlessa=0;
              window.occupiedlessa = nodirkakhorlessa;
              window.remaininglessa = originallessa - occupiedlessa;
          }
          if(originallessa <= occupiedlessa){
              alert("Total Reservation land can't be greater then original land");
              $('#reserved_bigha').val("0");
              $('#reserved_katha').val("0");
              $('#reserved_lessa').val("0");
              window.nodirkakhorlessa=0;
              window.occupiedlessa = nodirkakhorlessa;
              window.remaininglessa = originallessa - occupiedlessa;
          }
          //alert(remaininglessa);
          var bigha_r = Math.floor(remaininglessa / 100);
          var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
          var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2);
        });




</script>
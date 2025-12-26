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
    <section>
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

        <!-- <form role="form" method="post" action="<?php echo base_url()?>index.php/basundhara/settlementApPost" enctype="multipart/form-data"> -->
        <form role="form">
          <!-- <input type="hidden" name="service_code" value="<?=$app->service_code?>">
          <input type="hidden" name="lot_no" value="<?=$app->lot_no?>">
          <input type="hidden" name="application_no" value="<?=$_GET['app']?>"> -->

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
                          <input type="text" name="dist_name" class="form-control" value='<?=$this->utilityclass->getDistrictName($app->dist_code)?>' disabled>
                          <input type="hidden" name="dist_code" value="<?=$app->dist_code;?>">
                        </strong></td>
                      <th>Subdivision Name:</th>
                      <td class="text-warning">
                        <strong class="alert-warning"> 
                          <input type="text" name="subdiv_name" class="form-control" value='<?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?>' disabled>
                          <input type="hidden" name="subdiv_code" value="<?=$app->subdiv_code;?>">

                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <th>Circle Name: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="circle_name" value='<?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?>' class="form-control" disabled>
                          <input type="hidden" name="cir_code" value="<?=$app->cir_code;?>">

                        </strong></td>
                      <th>Mouza Name: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="mouza_name" class="form-control" value='<?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?>' disabled>
                          <input type="hidden" name="mouza_pargona_code" value="<?=$app->mouza_code;?>">

                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <th>Dag Number: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="dag_no" value='<?=$app->dag_no?>' class="form-control" disabled>
                          
                        </strong>
                      </td>
                      <th>Village Name: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="village_name" value='<?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?>' class="form-control" disabled>
                          <input type="hidden" name="vill_townprt_code" value="<?=$app->village_code;?>">

                        </strong>
                      </td>
                    </tr>
                    <?php if(isset($property) && !empty($property)) { ?>
                      <?php $i=1; foreach($property as $adp): ?>
                    <tr>
                      <th>Patta Number: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="patta_no" class="form-control" value='<?=$adp->patta_no;?>' disabled>
                        </strong>
                      </td>
                      <th>Patta type: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="patta_type_code" value='<?=$pattaNo->patta_type_code?>' class="form-control" disabled>
                        </strong>
                      </td>
                    </tr>
                    <?php endforeach; } ?>

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
                  
                 
                  <h5 class="card-title"><u>First Party Information/Applicant details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                      <tr>
                        <th>#</th>
                        <th>Name </th>
                        <th>Gurdian </th>
                        <th>Relation </th>
                        <th>Gender </th>
                        <th>Mobile </th>
                        <th>Individual land share</th>
                        <th>Permanent address</th>
                        <th>Presend address</th>
                      </tr>
                      <?php $i=1; foreach($settlements as $settlement): ?>
                        <input type="hidden" name="pdar_id" value="<?=$settlement->pdar_id?>">
                      <tr>
                        <td>1</td>
                        <td>
                          <input type="text" name="pdar_name" value="<?=$settlement->name_ass;?>" class="form-control" disabled>
                        </td>
                        <td>
                          <input type="text" name="pdar_guardian" value="<?=$settlement->gurdian_name_ass;?>" class="form-control" disabled>
                        </td>
                        <td>
                          <input type="text" value="<?=$settlement->gurdian_relation_id;?>" name="pdar_rel_guar" class="form-control" disabled>
                        </td>
                        <td>
                          <input type="text" name="pdar_gender" class="form-control" value="<?=$settlement->gender;?>" disabled>
                        </td>
                        <td>
                          <input type="text" name="pdar_mobile" value="<?=$settlement->mobile?>" class="form-control" disabled>
                        </td>
                        <td>
                          <label for="Bigha">Bigha</label> 
                          <strong><input type="text" value="<?=$settlement->mbigha?>" name="dag_area_b" class="form-control" disabled>
                          </strong> 
                          <label for="katha">katha</label>
                          <strong><input type="text" value="<?=$settlement->mkatha?>" name="dag_area_k" class="form-control" disabled>
                          </strong> 
                          <label for="Lessa">Lessa</label> 
                          <strong><input type="text" name="dag_area_lc" value="<?=$settlement->mlessa?>" class="form-control" disabled>
                          </strong> 
                          <label for="Ganda">Ganda</label>
                          <strong><input type="text" name="dag_area_g" value='<?php if((in_array($this->session->userdata("dist_code"), BARAK_VALLEY))){ echo $settlement->mganda;} else {echo '0';} ?>' class="form-control" disabled>
                          </strong> 
                          <label for="Kranti">Kranti</label> 
                          <strong><input type="text" value="<?php if((in_array($this->session->userdata("dist_code"), BARAK_VALLEY))){ echo $settlement->mkranti;} else {echo '0';} ?>" name="dag_area_kr" class="form-control" disabled>
                          </strong>
                        </td>
                        <td>
                          <input type="text" name="pdar_add1" value="<?=$settlement->per_add?>" class="form-control" disabled>
                        </td>
                        <td>
                          <input type="text" name="pdar_add2" value="<?=$settlement->pre_add?>" class="form-control" disabled>

                        </td>
                      </tr>
                      <?php endforeach;?>

                    </table>
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
                            <input type="text" name="period_possession" class="form-control" value=" <?php echo $settlementsOne->occupation_period; ?>" disabled>
                          </td>
                        </tr>
                        <tr>
                          <th>Occupation or Profession of the applicant</th>
                          <td>
                            <input type="text" name="occupation_applicant" value="<?=$settlementsOne->applicant_occupation?>" class="form-control" disabled>
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
                          <th>Description</th>
                          <th>Bigha</td>
                          <th>Katha</td>
                          <th>Lessa</td>
                          <?php if((in_array($this->session->userdata("dist_code"), BARAK_VALLEY))): ?>
                          <th>Ganda</td>
                          <th>Kranti</td>
                          <?php endif ; ?>
                        </tr>
                        <tr>
                          <th>Total Land Area in Selected Dag</th>
                          <td>
                            <input type="text" name="dag_area_b" class="form-control" value="<?=$app->area_b?>" disabled>
                          </td>
                          <td>
                            <input type="text" name="dag_area_k" value="<?=$app->area_k?>" class="form-control" disabled>
                          </td>
                          <td>
                            <input type="text" name="dag_area_lc" class="form-control" value="<?=$app->area_l?>" disabled>
                          </td>
                          <?php if((in_array($this->session->userdata("dist_code"), BARAK_VALLEY))): ?>
                          <td>
                            <input type="text" value="<?=$app->area_g?>" class="form-control" name="dag_area_g" disabled>
                          </td>
                          <td>
                            <input type="text" value="<?=$app->area_kr?>" class="form-control" name="dag_area_kr" disabled>
                          </td>
                          <?php endif ; ?>
                        </tr>

                        <?php $i=1; foreach($settlements as $settlement): if ($i==1){?>
                        <tr>
                          <th>Total applied area</th>
                          <td>
                            <input type="text" name="s_dag_area_b" class="form-control" value="<?=$settlement->applied_bigha?>" disabled>
                          </td>
                          <td>
                            <input type="text" name="s_dag_area_k" value="<?=$settlement->applied_katha?>" class="form-control" disabled>
                          </td>
                          <td>
                            <input type="text" name="s_dag_area_lc" class="form-control" value="<?=$settlement->applied_lessa?>" disabled>
                          </td>
                          <?php if((in_array($this->session->userdata("dist_code"), BARAK_VALLEY))): ?>
                          <td>
                            <input type="text" value="<?=$settlement->applied_ganda?>" class="form-control" name="s_dag_area_g" disabled>
                          </td>
                          <td>
                            <input type="text" value="<?=$settlement->applied_kranti?>" class="form-control" name="s_dag_area_kr" disabled>
                          </td>
                          <?php endif ; ?>
                        </tr>
                        <?php $i++?>
                        <?php } endforeach; ?>
                    </table>
                  </p>

                  <h5 class="card-title"><u>Next of Kin details</u></h5>
                  <p class="card-text">
                    <table class="table">
                      <tr>
                        <th>Next of KIN name</th>
                        <th>Relation with KIN</th>
                        <th>Address of KIN</th>
                        <th>Mobile number</th>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" name="kin_name" value="Jayanta Sonowal" class="form-control" disabled>
                        </td>
                        <td>
                          <input type="text" name="kin_relation" value="Father" class="form-control" disabled>
                        </td>
                        <td>
                          <input type="text" class="form-control" value="Dibrugarh" name="kin_address" disabled>
                        </td>
                        <td>
                          <input type="text" name="kin_contact_no" value="8403903066" class="form-control" disabled>
                        </td>
                      </tr>
                    </table>
                  </p>

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
                   Next
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
        disabled/>
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified2"
        value="No"
        disabled
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
      disabled
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
    <textarea
      name="roadside_reservation"
      id="roadside_reservation"
      class="form-control"
      cols="30"
      rows="3"
    ></textarea>
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
      disabled
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
      disabled
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
    <input type="file" name="chitha_copy" id="chitha_copy" class="form-control" disabled/>
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
  <button type="button" class="btn btn-primary next-step">
    Next
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
</section>
</div>
</div>

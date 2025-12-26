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
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
    else{
        $('#myTab a[href="#step1"]').tab('show');
    }

    $('.nav-tabs > li a[title]').tooltip();
    $(".next-step").click(function (e) {
    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);
    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });

    function nextTab(elem) {
      $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
    }
  });

</script>

<div class="container">
  <div class="row">
    <section>
      <div class="wizard">
        <div class="wizard-inner">
          <div class="connecting-line"></div>
          <ul class="nav nav-tabs shadow" id="myTab" role="tablist">
            <li role="presentation">
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

            <li role="presentation">
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
            <li role="presentation">
              <a
                href="#step3"
                data-toggle="tab"
                aria-controls="step3"
                role="tab"
                title="Step 3"
              >
                <span class="round-tab">
                  <strong>Proceedings</strong>
                </span>
              </a>
            </li>

            <!-- <li role="presentation" class="disabled">
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
            </li> -->
          </ul>
        </div>

        <form role="form" method="post" action="<?php echo base_url()?>index.php/SettlementKhasLand/settlementKhasUpdate" enctype="multipart/form-data">
          <input type="hidden" name="service_code" value="<?=$basic["service_code"]?>">
          <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
          <input type="hidden" name="application_no" value="<?=$_GET['case']?>">

          <?php 
          $sl_count = 1; 
          ?>
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="step1">
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
                  
                 
                  <h5 class="card-title"><u>First Party Information/Applicant details</u></h5>
                  <p class="card-text">
                    <?php $i=1; foreach($applicants as $settlement): ?>
                    <table class="table table-bordered">
                      <tr>
                        <th rowspan="5" style="vertical-align : middle;text-align:center;"><?=$i;?></th>
                        <th>Name of the applicant</th>
                        <td colspan="2">
                          <input type="text" name="pdar_name<?=$i?>" value="<?=$settlement->pdar_name;?>" class="form-control input-sm">
                        </td>
                        <th>Guardian name</th>
                        <td colspan="2">
                          <input type="text" name="pdar_guardian<?=$i?>" value="<?=$settlement->pdar_guardian;?>" class="form-control input-sm" >
                        </td>
                      </tr>

                      <tr>
                       
                        <th>Relation</th>
                        <td>
                          <!-- <input type="text" value="<?=$settlement->pdar_rel_guar;?>" name="pdar_rel_guar<?=$i?>" class="form-control input-sm"> -->
                          <select
                          name="pdar_rel_guar<?=$i?>"
                          id="pdar_rel_guar<?=$i?>"
                          class="form-control"
                        >
                        <option value="1" <?php if ($settlement->pdar_rel_guar == "1"){ echo "selected"; }?>>Mother</option>
                          <option value="2" <?php if ($settlement->pdar_rel_guar == "2"){ echo "selected"; }?>>Father</option>
                          <option value="3" <?php if ($settlement->pdar_rel_guar == "3"){ echo "selected"; }?>>Husband</option>
                          <option value="4" <?php if ($settlement->pdar_rel_guar == "4"){ echo "selected"; }?>>Wife</option>
                          <option value="5" <?php if ($settlement->pdar_rel_guar == "5"){ echo "selected"; }?>>Guardian</option>
                          <option value="6" <?php if ($settlement->pdar_rel_guar == "6"){ echo "selected"; }?>>Supdt.Mother</option>
                          <option value="7" <?php if ($settlement->pdar_rel_guar == "7"){ echo "selected"; }?>>Guardian</option>
                        </select>
                        </td>
                        <th>Gender</th>
                        <td>
                          <!-- <input type="text" name="pdar_gender<?=$i?>" class="form-control input-sm" value="<?=$settlement->pdar_gender;?>"> -->
                          <select
                          name="pdar_gender<?=$i?>"
                          id="pdar_gender<?=$i?>"
                          class="form-control"
                          >
                        <option value="1" <?php if ($settlement->pdar_gender == "1"){ echo "selected"; }?>>Male</option>
                          <option value="2" <?php if ($settlement->pdar_gender == "2"){ echo "selected"; }?>>Female</option>
                          <option value="3" <?php if ($settlement->pdar_gender == "3"){ echo "selected"; }?>>Others</option>
                        </select>
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
                          <input type="text" name="pdar_add1<?=$i?>" value="<?=$settlement->pdar_add1?>" class="form-control input-sm">
                        </td>
                
                        <th>Present address</th>
                        <td colspan="2">
                          <input type="text" name="pdar_add2<?=$i?>" value="<?=$settlement->pdar_add2?>" class="form-control input-sm" >
                        </td>

                      </tr>
                      <tr>
                   
                        <th>Individual land share</th>
                        <td>
                          <span class="input-group-addon">Bigha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->i_area_b?>" name="i_area_b<?=$i?>" class="form-control input-sm">
                          </strong>
                          </td>
                          <td>
                          <span class="input-group-addon">Katha</span>
                          <strong><input type="text" style="text-align: center;" value="<?=$settlement->i_area_k?>" name="i_area_k<?=$i?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Lessa</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_lc<?=$i?>" value="<?=$settlement->i_area_lc?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Ganda</span>
                          <strong><input type="text" style="text-align: center;" name="i_area_g<?=$i?>" value="<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ echo $settlement->i_area_g;} else {echo '0';} ?>" class="form-control input-sm" >
                          </strong> 
                        </td>
                        <td>
                          <span class="input-group-addon">Kranti</span>
                          <strong><input type="text" style="text-align: center;" value="<?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){ echo $settlement->i_area_kr;} else {echo '0';} ?>" name="i_area_kr<?=$i?>" class="form-control input-sm" >
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
                        <tr>
                          <th>Aadhaar Verified</th>
                          <td>
                            <input type="text" name="aadhar_verified" value="<?php if ($aadhar->is_aadhaar_verify == '1') { echo 'Yes';}?>" class="form-control" disabled>
                          </td>
                        </tr>

                        <tr>
                          <th>Period of Possession</th>
                          <td>
                            <input type="text" name="period_possession" class="form-control" value="<?=$basic["period_possession"] ?>">
                          </td>
                        </tr>
                        <tr>
                          <th>Occupation or Profession of the applicant</th>
                          <td>
                            <input type="text" name="occupation_applicant" value="<?=$basic["occupation_applicant"]?>" class="form-control">
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
                            <input type="text" name="patta_type_code" value='<?=$dags["patta_type_code"]?>' class="form-control input-sm" readonly>
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
        value="NO" <?php if ($lmnote->chitha_verified == "NO"){ echo "checked"; } ?>
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
          value="YES" <?php if ($lmnote->vlb_verified == "YES"){ echo "checked"; } ?>
        />
        <label class="form-check-label" for="inlineRadio1">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input
          class="form-check-input"
          type="radio"
          name="vlb_verified"
          id="vlb_verified2"
          value="NO" <?php if ($lmnote->vlb_verified == "NO"){ echo "checked"; } ?>
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
        value="YES" <?php if ($lmnote->possession_verification == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified2"
        value="NO" <?php if ($lmnote->possession_verification == "NO"){ echo "checked"; } ?>
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
          value="<?=$lmnote->total_bigha?>"
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
          value="<?=$lmnote->total_Katha?>"
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
          value="<?=$lmnote->total_lessa?>"
          
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
          value="<?=$lmnote->total_ganda?>"
          
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
          value="<?=$lmnote->total_kranti?>"
          
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
          value="<?=$lmnote->period_possession?>"
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
      class="form-control"
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
        value="YES" <?php if ($lmnote->is_landless == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="is_landless"
        id="is_landless"
        value="NO" <?php if ($lmnote->is_landless == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
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
    <input
      type="file"
      name="trace_map_copy"
      id="trace_map_copy"
      class="form-control"
    />
  </div>
</div>
<div class="row p-2 px-5">
  <div class="col-md-6 text-justify">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Category of the proposed land?</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="land_falls"
        id="land_falls"
        value="YES" <?php if ($lmnote->land_falls == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="land_falls"
        id="land_falls"
        value="NO" <?php if ($lmnote->land_falls == "NO"){ echo "checked"; } ?>
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
        value="YES" <?php if ($lmnote->falls_und_gmc == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="falls_und_gmc"
        id="falls_und_gmc"
        value="NO" <?php if ($lmnote->falls_und_gmc == "NO"){ echo "checked"; } ?>
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
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_bigha?>" class="form-control input-sm" name="reserved_bigha" id="reserved_bigha">
        </div>
        <div class="col-4">
          <span class="input-group-addon">Katha</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_katha?>" class="form-control input-sm" name="reserved_katha" id="reserved_katha" >
        </div>
        <div class="col-4">
          <span class="input-group-addon">Lessa</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_lessa?>" class="form-control input-sm" name="reserved_lessa" id="reserved_lessa" >
        </div>

      </div>
      <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
      <div class="form-group row mt-2">
        <div class="col-4">
          <span class="input-group-addon">Ganda</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_ganda?>" class="form-control input-sm" name="reserved_ganda" >
        </div>
        <div class="col-4">
          <span class="input-group-addon">Kranti</span>
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_kranti?>" class="form-control input-sm" name="reserved_kranti" >
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
      class="form-control" value="<?=$lmnote->zonal_valuation?>"
    />
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Field visit report & geo tagged
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
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <strong><?=$sl_count++?>.</strong> LM remarks</label>
  </div>
  <div class="col-md-6">
    <textarea name="lm_remark" class="form-control" id="lm_remark" cols="30" rows="2"><?=$lmnote->lm_note?></textarea>
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
  <button type="submit" class="btn btn-primary next-step">
  <?php echo $this->lang->line('update_records'); ?>
  </button>
  </li>
  </ul>
  </div>
</form>




<div class="tab-pane" role="tabpanel" id="step3">

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
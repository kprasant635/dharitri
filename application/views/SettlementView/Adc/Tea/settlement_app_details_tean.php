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

div.f-party-alternate > div:nth-of-type(odd) {
    background: #f2fdff;
}
div.co-report > form:nth-of-type(odd) {
    background: #f2fdff;
    padding-top: 3px;
    padding-bottom: 5px;
}
.bgheading{
  background:linear-gradient(to right, #267871, #136a8a);
}
</style>

<script>
// $(document).ready(function () {



//     //Initialize tooltips
//     $('.nav-tabs > li a[title]').tooltip();
    
//     //Wizard
//     $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

//         var $target = $(e.target);
    
//         // alert($target);
//         // if ($target.parent().hasClass('disabled')) {
//         //     return false;
//         // }
//     });

//     $(".next-step").click(function (e) {

//         var $active = $('.wizard .nav-tabs li.active');
//         $active.next().removeClass('disabled');
//         nextTab($active);

//     });
//     $(".prev-step").click(function (e) {

//         var $active = $('.wizard .nav-tabs li.active');
//         prevTab($active);

//     });
// });

// function nextTab(elem) {
//     $(elem).next().find('a[data-toggle="tab"]').click();
// }
// function prevTab(elem) {
//     $(elem).prev().find('a[data-toggle="tab"]').click();
// }
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
            <li role="presentation" >
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
                  <strong>Circle Officer</strong>
                </span>
              </a>
            </li>

            <li role="presentation">
              <a
                href="#step4"
                data-toggle="tab"
                aria-controls="step4"
                role="tab"
                title="step 4"
              >
                <span class="round-tab">
                  <strong>Proceedings</strong>
                </span>
              </a>
            </li>
          </ul>
        </div>

        <!-- <form role="form"> -->
          <!-- <input type="hidden" name="service_code" value="<?=$app->service_code?>">
          <input type="hidden" name="lot_no" value="<?=$app->lot_no?>">
          <input type="hidden" name="application_no" value="<?=$_GET['app']?>"> -->

          <?php 
          $sl_count = 1; 
          ?>
          <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="step1">
              <h5 class="bgheading p-2 text-white shadow">
                Registration of <?php echo $this->lang->line('teaSpecialCultivatorsName') ?> (
                <span class="bg-warning"><?=$_GET['case']?></span> )
              </h5>
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
            </div>

             <!-- LM reporting starts here -->

             <div class="tab-pane" role="tabpanel" id="step2">
              <h5 class="bgheading p-2 text-white shadow">
                LM(A) reporting for Registration of <?php echo $this->lang->line('teaSpecialCultivatorsName') ?> (
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
        value="YES" disabled <?php if ($lmnote->chitha_verified == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="chiitha_verified"
        id="chiitha_verified2"
        value="NO" disabled <?php if ($lmnote->chitha_verified == "NO"){ echo "checked"; } ?>
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
          value="YES" disabled <?php if ($lmnote->vlb_verified == "YES"){ echo "checked"; } ?>
        />
        <label class="form-check-label" for="inlineRadio1">Yes</label>
      </div>
      <div class="form-check form-check-inline">
        <input
          class="form-check-input"
          type="radio"
          name="vlb_verified"
          id="vlb_verified2"
          value="NO" disabled <?php if ($lmnote->vlb_verified == "NO"){ echo "checked"; } ?>
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
        value="YES" disabled <?php if ($lmnote->possession_verification == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="possession_verified"
        id="possession_verified2"
        value="NO" disabled <?php if ($lmnote->possession_verification == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
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
        value="YES" disabled <?php if ($lmnote->is_landless == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="is_landless"
        id="is_landless"
        value="NO" disabled <?php if ($lmnote->is_landless == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Landed property of the petitioner and his family (if any) within the State</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="landed_property"
        id="landed_property"
        value="YES" disabled <?php if ($lmnote->landed_property == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="landed_property"
        id="landed_property"
        value="NO" disabled <?php if ($lmnote->landed_property == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>



<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> The Applicant should undertake special cultivation of tea as a means of livelihood</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="livelihood"
        id="livelihood"
        value="YES" disabled <?php if ($lmnote->livelihood == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="livelihood"
        id="livelihood"
        value="NO" disabled <?php if ($lmnote->livelihood == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Suitability of proposed land for tea cultivation</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="suitability"
        id="suitability"
        value="YES" disabled <?php if ($lmnote->suitability == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="suitability"
        id="suitability"
        value="NO" disabled <?php if ($lmnote->suitability == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Patta land of applicant’s family. This should be deducted from the total admissible area</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="admissible_area"
        id="admissible_area"
        value="YES" disabled <?php if ($lmnote->admissible_area == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="admissible_area"
        id="admissible_area"
        value="NO" disabled <?php if ($lmnote->admissible_area == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Schedule of the land and area under
      occupation</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="admissible"
        id="admissible"
        value="YES" disabled <?php if ($lmnote->admissible_area == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="admissible"
        id="admissible"
        value="NO" disabled <?php if ($lmnote->admissible_area == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

<div class="row p-2 px-5">
  <div class="col-md-6">
    <label for="formGroupExampleInput"
      ><strong><?=$sl_count++?>.</strong> Weather the applicant has been allotted govt land before</label
    >
  </div>
  <div class="col-md-6">
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="govt_allotted"
        id="govt_allotted"
        value="YES" disabled <?php if ($lmnote->govt_allotted == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="govt_allotted"
        id="govt_allotted"
        value="NO" disabled <?php if ($lmnote->govt_allotted == "NO"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio2">No</label>
    </div>
  </div>
</div>

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
        value="YES" disabled <?php if ($lmnote->land_falls == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="land_falls"
        id="land_falls"
        value="NO" disabled <?php if ($lmnote->land_falls == "NO"){ echo "checked"; } ?>
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
        value="YES" disabled <?php if ($lmnote->falls_und_gmc == "YES"){ echo "checked"; } ?>
      />
      <label class="form-check-label" for="inlineRadio1">Yes</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        name="falls_und_gmc"
        id="falls_und_gmc"
        value="NO" disabled <?php if ($lmnote->falls_und_gmc == "NO"){ echo "checked"; } ?>
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
        <label for="area-reserved" class="mb-2">Reserved area details</label>
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
          <input type="text" style="text-align: center;" value="<?=$lmnote->r_lessa?>" class="form-control input-sm" name="reserved_lessa" id="reserved_lessa" readonly >
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
          <label for="roadside">Reserved area remarks</label>
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
<h5 class="bgheading p-2 text-white shadow">
    CO report for Registration of <?php echo $this->lang->line('teaSpecialCultivatorsName') ?>(
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
        <form method="post" action="<?php echo base_url()?>index.php/SettlementKhasCo/generateNoticeCo">
          <div class="mt-4 row px-5">
              <div class="col-md-3">
                <!-- <label for="">Select hearing date</label> -->
                <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
                <input type="hidden" autocomplete="off" class="form-control date" id="enable_next_date" name="hearing_date" value="05/09/2022" />
                
              </div>
              <div class="col-md-9">

                
                  <label for="inputEmail4">Remarks(if any)</label>
                  <!-- <textarea placeholder="Remarks  ..." name="remark_co" class="form-control" id="remark_co" cols="30" rows="3" required></textarea> -->
                  <select name="remark_co" id="remark_co" class="form-control" required>
                  <option value="">Select remarks...</option>
                  <option value="Reverted back to LM">Reverted back to LM</option>
                  <option value="Case forwarded to DC">Case forwarded to DC</option>
                </select>
                  <input type="hidden" name="case_no" value="<?=$_GET['case']?>">

           
              </div>
          </div>
          <div class="row mt-4 justify-content-center">

          <?php
            if($basic['notice_generated_yn'] == 'Y'){ ?>
            
            <!-- <button type="submit" name="print_notice" formtarget="GenerateNotice" type="button" class="m-1 col-2 text-white btn btn-warning btn-sm">Print Notice</button> -->
          
          <?php }else{ ?>

              <!-- <button type="submit" name="generate_notice" formtarget="GenerateNotice" type="button" class="m-1 col-2 text-white btn btn-warning btn-sm">Generate Notice</button> -->
              <?php } ?>

              <?php if(($pending_officer == 'LM' && $from_office == 'CO') || ($pending_officer == 'DC' && $from_office == 'CO')){ ?>
                <button type="submit" name="revert_to_lm" class="m-1 col-2 btn btn-danger btn-sm" disabled>Revert Back to LM</button>
            <?php }else{ ?>
              <button type="submit" name="revert_to_lm" class="m-1 col-2 btn btn-danger btn-sm">Revert Back to LM</button>
              <?php } ?>
              


                <?php if(($pending_officer == 'LM' && $from_office == 'CO') || ($pending_officer == 'DC' && $from_office == 'CO')){ ?>
                <button type="submit" name="forward_to_dc" class="m-1 col-2 btn btn-primary btn-info-full btn-sm" disabled>Forward to DC</button>
                <?php }else{ ?>
                  <button type="submit" name="forward_to_dc" class="m-1 col-2 btn btn-primary btn-info-full btn-sm">Forward to DC</button>
                  <?php } ?>

          </div>
        </form>

        
      </div>
    </div>
  </div>
  <!-- <ul class="list-inline pull-right">
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
 
    </li>
  </ul> -->
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


<div class="tab-pane" role="tabpanel" id="complete">
  <h3>Complete</h3>
  <p>You have successfully completed all steps.</p>
</div>
<div class="clearfix"></div>
</div>
<!-- </form> -->
</div>
</section>
</div>
</div>

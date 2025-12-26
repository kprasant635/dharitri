<style>
    .is-invalid:focus{
        border: 1px solid red !important;
    }

    .lm_invalid{
        border: 1px solid red !important;
    }
    .tab-content .card:hover {
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        /* box-shadow: none !important; */
    }
    .tab-content .card:active {
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
    .wizard .nav-tabs > li.active > a,
    .wizard .nav-tabs > li.active > a:hover,
    .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005b96 !important;
        text-decoration: none;
    }
    .wizard li.active {
        background: #005b96;
        padding: 5px;
        box-shadow: 1px 0px 1px 1px;
    }
    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }
    .wizard li:after {
        content: ' ';
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
        content: ' ';
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
    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }

</style>

<!-- Masud's CSS-->
<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 15px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        padding-bottom: -1px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }

    select.form-control {
        appearance: auto!important;
    }
</style>

<style>
    .close-bene {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-bene:hover,
    .close-bene:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<style>
    div.alt-color-div>div:nth-of-type(odd) {
        background: #f2fdff;
    }
</style>

<script src="<?php echo base_url();?>js/jAlert-v3.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jAlert-v3.css" />

<script>
    $(document).ready(function () {
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip()

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            var $target = $(e.target)

            if ($target.parent().hasClass('disabled')) {
                return false
            }
        })

        $('.next-step').click(function (e) {

          tot_bigha = parseFloat($("#dag_area_b").val());
          tot_katha = parseFloat($("#dag_area_k").val());
          tot_lessa = parseFloat($("#dag_area_lc").val());
          tot_ganda = parseFloat($("#dag_area_g").val());

          s_dag_area_b  = parseFloat($("#s_dag_area_b").val());
          s_dag_area_k  = parseFloat($("#s_dag_area_k").val());
          s_dag_area_lc = parseFloat($("#s_dag_area_lc").val());
          s_dag_area_g  = parseFloat($("#s_dag_area_g").val());

          if($('#barak_valley').val() == 0){ // other than barak valley

            total_area = (tot_bigha*100)+(tot_katha*20)+tot_lessa;
            tot_settlement_area = (s_dag_area_b*100)+(s_dag_area_k*20)+s_dag_area_lc;

            if(total_area < tot_settlement_area) {
              theme = "blue";
              $.jAlert({
                  'title': 'Error: Invalid Data Entry',
                  'content': 'Area of settlement can not be more than total available Area !!!',
                  'theme': theme,
                  'backgroundColor': 'white',
                  'btns': [
                      {'text':'OK', 'theme':theme}
                  ]
              });
              $('#tot_bigha').focus();
              return false;
            }
          }

          if($('#barak_valley').val() == 1){ // for barak valley
            
            tot_area = (tot_bigha * 6400) + (tot_katha * 320) + (tot_lessa * 20) + tot_ganda;
            tot_settlement_area = (s_dag_area_b * 6400) + (s_dag_area_k * 320) + (s_dag_area_lc * 20) + s_dag_area_g;

            if(tot_area < tot_settlement_area) {
              theme = "blue";
              $.jAlert({
                  'title': 'Error: Invalid Data Entry',
                  'content': 'Area of settlement can not be more than total available Area !!!',
                  'theme': theme,
                  'backgroundColor': 'white',
                  'btns': [
                      {'text':'OK', 'theme':theme}
                  ]
              });
              $('#tot_bigha').focus();
              return false;
            }
          }




          if ($('.inplace-along').val().length == 0) {
            alert('Please select In place or Along in Owner Details section!!');
            return false;
          }

          var $active = $('.wizard .nav-tabs li.active')
          $active.next().removeClass('disabled')
          nextTab($active)

        })

        $('.prev-step').click(function (e) {
            var $active = $('.wizard .nav-tabs li.active')
            prevTab($active)
        })
    })

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click()
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click()
    }
</script>
<script>
    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>
<div class="container">
    <div class="row">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>

        <?php
        if($basic['old_case_no'] != null){
        ?>
        <div class="row text-right">
        <a href="<?=base_url('index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $basic['old_case_no'])?>" target="Old Application" class="text-danger">
            <span class="round-tab">
            <strong>View Old Application</strong>
            </span>
        </a>
        </div>
  
        <?php }?>
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs shadow" role="tablist">
                        <li role="presentation" class="active">
                            <a class="test" href="#step1" data-toggle="tab"
                               aria-controls="step1"
                               role="tab"
                               title="Step 1"
                            >
                  <span class="round-tab">
                  <strong>Application</strong>
                  </span>
                            </a>
                        </li>
                        <li role="presentation" class="">
                            <a
                                    href="#step2"
                                    data-toggle="tab"
                                    aria-controls="step2"
                                    role="tab"
                                    title="Step 2"
                            >
                  <span class="round-tab">
                  <strong>LRA</strong>
                  </span>
                            </a>
                        </li>
                        <!-- <li role="presentation">
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
                           </li> -->
                    </ul>
                </div>
                <form
                        role="form"
                        class="lmForm"
                        method="post"
                        action="<?php echo base_url()?>index.php/SettlementTenantUrban/settlementTenantRegistration?app=<?=$_GET['app']?>"
                        enctype="multipart/form-data"
                >

                    <?php 
                        $application_no = $this->utilityclass->decryptJwtCase($_GET['app']);
                    ?>

                  <input type="hidden" name="service_code" value="<?=$basic["service_code"]?>">
                  <input type="hidden" name="lot_no" value="<?=$basic["lot_no"]?>">
                  <input type="hidden" name="application_no" value="<?=$application_no?>">
                  <input type="hidden" name="ref_no" value="<?=$basic["ref_no"]?>">
                  <input type="hidden" name="lm_verification_date" id="lm_verification_date" value="<?=$geo_date ; ?>">
                  <input type="hidden" name="uuid" id="uuid" value="<?=$basic['uuid']?>">
                  <input type="hidden" name="case_no" id="case_no" value="<?=$basic['case_no']?>">
                  <input type="hidden" id="application_no" value="<?=$basic['case_no']?>">

                  <?php $sl_count = 1; ?>

                  <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                      <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                          Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$basic['case_no']?></span> )
                      </h5>
                      <?php include(APPPATH."views/SettlementView/include/applicationTenantViewUrban.php"); ?>
                      <ul class="list-inline pull-right" style="margin-top: 20px">
                        <li>
                          <button type="button" class="btn btn-primary next-step">
                            <i class="fa fa-arrow-circle-right"> </i>  Next
                          </button>
                        </li>
                      </ul>
                    </div>


                    <div class="tab-pane" role="tabpanel" id="step2">
                          <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                              Registration of Settlement of  Occupancy Tenant (
                            <span class="bg-warning"><?=$basic['case_no']?></span> )
                          </h5>

                          <div class="reza-card">
                            <div class="reza-body">
                              <?=$dagFlagCheckChitha?>
                              <h5  class="reza-title" style="margin-top: 15px">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> LRA Report
                              </h5>
                              <div class="tableCard">

                                <div class="row p-2" >
                                  <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> Chitha verified and found the applicant as a pattadar ?</span>
                                    <?=form_error('chitha_verified')?>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="chitha_verified"
                                              id="chiitha_verified1"
                                              value="YES"
                                          <?php if(set_value('chitha_verified') == 'YES'){ echo "checked";} ?>
                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                                class="form-check-input <?php if(form_error('chitha_verified')){echo 'lm_invalid';}?>"
                                                type="radio"
                                                name="chitha_verified"
                                                id="chiitha_verified2"
                                                value="NO"
                                            <?php if(set_value('chitha_verified') == 'NO'){ echo "checked";} ?>
                                        />
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                      <i class="fa fa-link" aria-hidden="true"></i>
                                      <a target='chithaReport' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $aadhar[0]->dag_no . '&m=' . $app['mouza_pargona_code'] . '&l=' . $app['lot_no'] . '&v=' . $app['vill_townprt_code'] . '&p=' . $aadhar[0]->patta_type_code . '&dist=' . $app['dist_code'] . '&cir=' . $app['cir_code'] . '&sub_div=' . $app['subdiv_code'] ?>">
                                          <u><span class="text-primary" style="font-size:16px;">Dag - <?=$aadhar[0]->dag_no?> (Chitha)</span></u>
                                      </a>
                                      <br>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                  <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> RAIOTEE KHATIAN verified and found applicant predecessors is a recorded occupancy tenant</span>
                                    <?=form_error('rk_verified')?>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                      <input
                                      class="form-check-input <?php if(form_error('rk_verified')){echo 'lm_invalid';}?>"
                                      type="radio"
                                      name="rk_verified"
                                      id="rk_verified1"
                                      value="YES"
                                      <?php if(set_value('rk_verified') == 'YES'){ echo "checked";} ?>
                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <input
                                      class="form-check-input <?php if(form_error('rk_verified')){echo 'lm_invalid';}?>"
                                      type="radio"
                                      name="rk_verified"
                                      id="rk_verified2"
                                      value="NO"
                                      <?php if(set_value('rk_verified') == 'NO'){ echo "checked";} ?>

                                      />
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>                                  
                                  </div>

                                  <div class="col-md-4">
                                    <i class="fa fa-link" aria-hidden="true"></i>

                                    <span id="rk_view"></span>
                                    <?php
                                        if($chitha_tenant_exist == 'y') {
                                        ?>
                                        <a id="khatian_link" href="<?php echo base_url() . 'index.php/basundhara2/khatian?st='.$chitha_tenant->khatian_no.'&end='.$chitha_tenant->khatian_no.'&dist='.$app['dist_code'].'&cir_code='.$app['cir_code'].'&subdiv_code='.$app['subdiv_code'].'&mouza_code='.$app['mouza_pargona_code'].'&lot_no='.$app['lot_no'].'&village_code='.$app['vill_townprt_code'].'&patta_no='.$aadhar[0]->patta_no.'&dag_no='.$aadhar[0]->dag_no?>" target="view_riotee">
                                            <button type="button" class="btn btn-sm btn-info text-white col-4">View</button>
                                        </a>
                                    <?php }?>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Bhumiputra Verified?</span>
                                        <?=form_error('bhumiputra_confirmation_lm')?>
                                        <br>
                                        <?php
                                        if(trim($basic['bhumiputra_confirmation']) == 'YES'){
                                            ?>
                                                <label for="" class="alert-warning">Certificate/Ack number : <b><?=$basic['bhumiputra_certificate_no']?></b></label>
                                            <?php }else{ ?>
                                                <label for="" class="alert-warning">Certificate Not Available!</b></label>
                                            <?php } ?>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="bhumiputra_confirmation_lm"
                                                    id="bhumiputra_confirmation1"
                                                    value="YES"
                                                <?php if(set_value('bhumiputra_confirmation_lm') == 'YES'){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('bhumiputra_confirmation_lm')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="bhumiputra_confirmation_lm"
                                                    id="bhumiputra_confirmation2"
                                                    value="NO"
                                                <?php if(set_value('bhumiputra_confirmation_lm') == 'NO'){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        if(trim($basic['bhumiputra_confirmation']) == 'YES'){
                                                ?>
                                                <i class="fa fa-link" aria-hidden="true"></i>
                                                <a href="<?php echo base_url();?>index.php/SettlementCommon/bhumiPutra?<?php
                                                if(trim($basic['bhumiputra_certificate_type']) == 'CERT'){
                                                    echo "cer_number=".$basic['bhumiputra_certificate_no'];
                                                }else{
                                                    echo "ack_number=".$basic['bhumiputra_certificate_no'];
                                                }?>" target="BhumiPutra">
                                                    <u><span class="text-primary" style="font-size:16px;">View certificate</span></u>
                                                </a>
                                            <?php } ?>
                                    </div>
                                </div>

                                

                                <div class="row p-2">
                                  <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> verified schedule of the land and area under possession and found correct?
                                    </span>
                                    <?=form_error('possession_verification')?>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input <?php if(form_error('possession_verification')){echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="possession_verification"
                                              id="inlineRadio1"
                                              value="YES"
                                          <?php if(set_value('possession_verification') == 'YES'){ echo "checked";} ?>

                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input <?php if(form_error('possession_verification')){echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="possession_verification"
                                              id="inlineRadio2"
                                              value="NO"
                                          <?php if(set_value('possession_verification') == 'NO'){ echo "checked";} ?>

                                      />
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                  <div class="col-md-6">
                                      <span><strong><?=$sl_count++?>.</strong> Whether the proposed land falls under
                                          Tribal Belt/ Block.</span>
                                      <?=form_error('is_tribal_belt')?>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-check form-check-inline">

                                          <input
                                                  class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                                                  type="radio"
                                                  name="is_tribal_belt"
                                                  id="whether_tribal1"
                                                  value="YES"
                                                  onclick="handleTribalClick(this)"
                                              <?php
                                              if(isset($err_return)){
                                                  if(set_value('is_tribal_belt') == 'YES'){
                                                      echo "checked";
                                                  }
                                              }
                                              else {

                                                $app['tribal_belt'] != null ? 'checked':'';
                                              } ?>
                                          />
                                          <label class="form-check-label" for="inlineRadio1">Yes</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input
                                                  class="form-check-input <?php if(form_error('is_tribal_belt')){echo 'lm_invalid';}?>"
                                                  type="radio"
                                                  name="is_tribal_belt"
                                                  id="whether_tribal2"
                                                  value="NO"
                                                  onclick="handleTribalClick(this)"
                                              <?php
                                              if(isset($err_return)){
                                                  if(set_value('is_tribal_belt') == 'NO'){
                                                      echo "checked";
                                                  }
                                              }
                                              else{
                                                  $app['tribal_belt'] != null ? 'checked':'';
                                              }
                                              ?>
                                          />
                                          <label class="form-check-label" for="inlineRadio2">No</label>
                                      </div>
                                  </div>
                                    <div class="col-md-4" id="tribal_belt_input_id" style="display: none;">
                                        <input type="text" class="form-control <?php if(form_error('tribal_belt_name')){echo 'lm_invalid';}?>" name="tribal_belt_name" placeholder="Enter name of the Tribal belt block">

                                    </div>
                                </div>

                                <div class="row p-2" id="protected_class_id" style="display: none;">
                                  <div class="col-md-6 text-justify">
                                    <span><strong>-></strong>
                                    Does the applicant falls under protected category as mentioned in that particular tribal belt/block and eligible under section 163(2)(a), 163(2)(b)?</span>
                                    <?=form_error('protected_class_lm')?>
                                  </div>
                                  <div class="col-md-6 form-group">
                                    <select name="protected_class_lm" id="protected_class_lm" class="form-control
                                    <?php if(form_error('protected_class_lm')){echo 'lm_invalid';}?>" required>
                                      <?php foreach(json_decode(PROTECTED_CLASS) as $class): ?>
                                      <option value="<?php echo $class->CODE ?>"
                                      <?php if(set_value('protected_class_lm') == $class->CODE){ echo "selected";} ?>>
                                      <?php echo $class->NAME ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                </div>
                                
                                <div class="row p-2" id="contravention" style="display: none;">
                                  <div class="col-md-6">
                                    <span><strong>-></strong>
                                    Whether the occupancy tenant right has been conferred in contravention of provisions of chapter 10?</span>
                                    <?=form_error('contravention')?>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                             type="radio"
                                             name="contravention"
                                             id="landed_property1"
                                             value="YES"
                                          <?php if(set_value('contravention') == 'YES'){ echo "checked";} ?>
                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input <?php if(form_error('contravention')){echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="contravention"
                                              id="landed_property2"
                                              value="NO"
                                          <?php if(set_value('contravention') == 'NO'){ echo "checked";} ?>
                                      />
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                  <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong>
                                    Whether proposed land is under litigation?</span>
                                    <?=form_error('litigation')?>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input <?php if(form_error('litigation')){echo 'lm_invalid';}?>"
                                             type="radio"
                                             name="litigation"
                                             id="landed_property1"
                                             value="YES"
                                          <?php if(set_value('litigation') == 'YES'){ echo "checked";} ?>
                                      />
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input
                                              class="form-check-input <?php if(form_error('litigation')){echo 'lm_invalid';}?>"
                                              type="radio"
                                              name="litigation"
                                              id="landed_property2"
                                              value="NO"
                                          <?php if(set_value('litigation') == 'NO'){ echo "checked";} ?>
                                      />
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                    <span>
                                        <strong><?=$sl_count++?>.</strong> Whether applicant / applicant's predecessors continuosuly possessing the land since creation of occupancy tenant while the area is in rural area?
                                    </span>
                                        <?=form_error('cont_possessing')?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('cont_possessing')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="cont_possessing"
                                                    id="cont_possessing"
                                                    value=<?=YES?>
                                                    <?php if(set_value('cont_possessing') == YES){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('cont_possessing')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="cont_possessing"
                                                    id="cont_possessing"
                                                    value=<?=NO?>
                                                    <?php if(set_value('cont_possessing') == NO){ echo "checked";} ?>

                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Period of possession</span>
                                        <?=form_error('period_possession_lm')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="inputEmail4">From Date</label>
                                            </div>
                                            <div class="col-8">
                                                <input
                                                        class="form-control <?php if(form_error('period_possession_lm')){echo 'lm_invalid';}?>"
                                                        type="text" autocomplete="off"
                                                        readonly
                                                        name="period_possession_lm"
                                                        id="popup1Datepicker"
                                                        value="<?php if(isset($err_return)){ echo set_value('period_possession_lm');}else{
                                                            if ($applicants == true) {
                                                                foreach ($applicants as $applicant) {
                                                                    if ($applicant->is_applicant == 1) {
                                                                        echo $applicant->period_possession;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Nature of possession </span>
                                        <?=form_error('nature_possession')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select
                                                name="nature_possession"
                                                id="nature_possession"
                                                onchange="naturePossessionOther(this)"
                                                class="form-control <?php if(form_error('nature_possession')){echo 'lm_invalid';}?>"
                                        >
                                            <option value="Agricultural" <?php if(isset($err_return)){ if (set_value('nature_possession') == "Agricultural") { echo "selected"; }}?>>
                                                Agricultural
                                            </option>
                                            <option value="Residential" <?php if(isset($err_return)){ if (set_value('nature_possession') == "Residential") { echo "selected"; }}?>>
                                                Residential
                                            </option>
                                            
                                            <option value="Commercial" <?php if(isset($err_return)){ if (set_value('nature_possession') == 'Commercial') { echo "selected"; }}?>>Commercial</option>

                                            <option value="Others" <?php if(isset($err_return)){ if (set_value('nature_possession') == "Others") { echo "selected"; }}?>>
                                                Others
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row p-2"  style="display: none;" id="nature_possession_div_other">
                                    <div class="col-md-6">
                                        <span><strong>-></strong> Purpose of the land used by the occupants(if any other than pt.12)</span>
                                        <?=form_error('land_used_by_occupants')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" name="land_used_by_occupants" class="form-control <?php if(form_error('land_used_by_occupants')){echo 'lm_invalid';}?>" placeholder="Enter purpose of the land used by occupants" value="<?php if(isset($err_return)){ echo set_value('land_used_by_occupants');}?>">
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          Check the land revenue details as fetch from the E-Khajana Database or check the Khajana receipt uploaded by applicant
                                      </span>
                                      <?=form_error('khajana_receipt')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('khajana_receipt')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="khajana_receipt"
                                                    id="khajana_receipt1"
                                                    value="YES"
                                                <?php if(set_value('khajana_receipt') == 'YES'){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('khajana_receipt')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="khajana_receipt"
                                                    id="khajana_receipt2"
                                                    value="NO"
                                                <?php if(set_value('khajana_receipt') == 'NO'){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>




                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          Date of notification vide which the area was included in town lands
                                      </span>
                                      <?=form_error('date_notification')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control <?php if(form_error('tenancy_record')){echo 'lm_invalid';}?>" name="date_notification" id="date_notification"
                                        value="<?php if(isset($err_return)) {echo set_value('date_notification');}?>" readonly placeholder="Date of Notification">
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          The year in which the tenancy records were created
                                      </span>
                                      <?=form_error('tenancy_record')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control <?php if(form_error('tenancy_record')){echo 'lm_invalid';}?>" name="tenancy_record" id="tenancy_record" placeholder="The year in which the tenancy records were created"
                                        value="<?=date('Y', strtotime($chitha_tenant->date_entry))?>" readonly>
                                    </div>
                                </div>

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                      <span>
                                          <strong><?=$sl_count++?>.</strong>
                                          Whether applicant(s) have been in continuous possession from the year of creation of the tenancy records ?
                                      </span>
                                      <?=form_error('cont_possession')?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('cont_possession')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="cont_possession"
                                                    id="cont_possession1"
                                                    value="YES"
                                                <?php if(set_value('cont_possession') == 'YES'){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input
                                                    class="form-check-input <?php if(form_error('cont_possession')){echo 'lm_invalid';}?>"
                                                    type="radio"
                                                    name="cont_possession"
                                                    id="cont_possession2"
                                                    value="NO"
                                                <?php if(set_value('cont_possession') == 'NO'){ echo "checked";} ?>
                                            />
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>


                                <!---// Add additional land detail modal --->
                                <?php include 'application/views/SettlementView/include/settlementPropertyModal.php'; ?>
                                <!---// Add additional land detail modal --->

                                <?php if(ENABLE_CHECK_LAND != 0) {?>
                                            <!---// Land exist check modal --->
                                            <?php
                                            $identity_type=$aadhar[0]->identity_type;
                                            $identity_ref_no=$aadhar[0]->identity_ref_no;
                                            ?>
                                            <div style="margin: 10px">
                                                <?php include(APPPATH."views/SettlementView/include/landCheck.php"); ?>
                                            </div>

                                            <!---// Land exist check modal end --->
                                <?php } ?>

                        
                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <label for="">
                                            <strong><?=$sl_count++?>.</strong>
                                            Landmark                                                        
                                        </label>
                                        <?=form_error('landmark_east')?>
                                        <?=form_error('landmark_west')?>
                                        <?=form_error('landmark_north')?>
                                        <?=form_error('landmark_south')?>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">East side landmark</label>
                                        <textarea name="landmark_east" placeholder="Enter East Landmark" id="landmark_east" cols="30" rows="3" class="form-control <?php if(form_error('landmark_east')){echo 'lm_invalid';}?>"><?php echo set_value('landmark_east');?></textarea>

                                        <label for="">West side landmark</label>
                                        <textarea name="landmark_west" class="form-control <?php if(form_error('landmark_west')){echo 'lm_invalid';}?>" placeholder="Enter West Landmark" id="landmark_west" cols="30" rows="3"><?php echo set_value('landmark_west');?></textarea>

                                    </div>
                                    <div class="col-md-3">
                                        <label for="">North side landmark</label>
                                        <textarea name="landmark_north" class="form-control <?php if(form_error('landmark_north')){echo 'lm_invalid';}?>" placeholder="Enter North Landmark" id="landmark_north" cols="30" rows="3"><?php echo set_value('landmark_north');?></textarea>

                                        <label for="">South side landmark</label>
                                        <textarea name="landmark_south" class="form-control <?php if(form_error('landmark_south')){echo 'lm_invalid';}?>" placeholder="Enter South Landmark" id="landmark_south" cols="30" rows="3"><?php echo set_value('landmark_south');?></textarea>
                                    </div>
                                </div>
                             

                                <div class="row p-2" >
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Copy of trace map of the proposed land
                                        clearly highlighting the propose land road/riverside reservation etc(if
                                            any)</span>
                                        <?php
                                        foreach($encroachers as $dags_trace){
                                            echo form_error('trace_map_copy'.$dags_trace->id);
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        foreach($encroachers as $dags_trace){
                                            ?>
                                            <span class="alert-warning">For Dag no. : <strong><?=$dags_trace->dag_no?></strong></span>
                                            <input type="hidden" name="dag_no_doc<?=$dags_trace->id?>" value="<?=$dags_trace->dag_no?>">
                                            <input
                                                    type="file"
                                                    name="trace_map_copy<?=$dags_trace->id?>"
                                                    id="trace_map_copy"
                                                    class="form-control <?php if(form_error('trace_map_copy'.$dags_trace->id)){echo 'lm_invalid';}?>"
                                            /><br>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <span><strong><?=$sl_count++?>.</strong> Field visit report & geo tagged
                                            photograph of the land</span>
                                        <?=form_error('field_report')?>
                                        <span class="<?php if(form_error('geo_tag_photo')){echo 'lm_invalid';}?>"></span>
                                        <?php
                                        if(isset($geo_tag_doc)){
                                                echo form_error('geo_tag_photo');
                                            }else{
                                                echo form_error('geo_tag_photo');
                                            }?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label for="inputEmail4">Field report</label>
                                            </div>
                                            <div class="col-8">
                                                <input
                                                        class="form-control <?php if(form_error('field_report')){echo 'lm_invalid';}?>"
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
                                                <?php
                                                if(isset($geo_tag_doc_empty)){
                                                    echo $geo_tag_doc_empty;
                                                }
                                                if(isset($geo_tag_doc)){
                                                    foreach($geo_tag_doc as $d):
                                                        ?>
                                                        <span class="alert-warning">For Dag no : <strong><?=$d->dag_no?></strong></span><br>
                                                        <a target='download' href="<?php echo base_url()?>index.php/SettlementCommon/downloadDocument?doc_id=<?=$d->id?>"><i class="fa fa-paperclip mb-2"></i> <?=$d->file_name;?></a><br>

                                                    <?php endforeach;}?>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <strong><?=$sl_count++?>.</strong> LRA Remarks</label>
                                        <?=form_error('lm_note')?>
                                        <?=form_error('lm_remark_text')?>
                                    </div>
                                    <div class="col-md-6">
                            
                                        <select name="lm_note" id="lm_remark" class="form-control <?php if(form_error('lm_note') || form_error('lm_remark_text')){echo 'lm_invalid';}?>">
                                            <?php
                                            foreach(json_decode(LM_NOTE) as $lm_remark_cat){

                                                if(LM_NOT_RECOMM_OPTION == 0)
                                                {
                                                    if($lm_remark_cat->CODE == 2) 
                                                    {
                                                        continue;
                                                    }
                                                }

                                                ?>
                                                <option value="<?=$lm_remark_cat->CODE?>"
                                                    <?php //if(set_value('lm_note') == $lm_remark_cat->CODE){ echo "selected";} ?>
                                                ><?=$lm_remark_cat->NAME?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <br>
                                    </div>
                                </div>

                                <?php
                                    include(APPPATH."views/SettlementView/include/rejectedReasons.php");
                                ?>

                                <div id="lm_remark_text_id" class="row p-2" style="display: none;">
                                    <div class="col-md-12">
                                    <textarea name="lm_remark_text" placeholder="Enter remark..." class="form-control <?php if(form_error('lm_remark_text')){echo 'lm_invalid';}?>" id="lm_remark_text" rows="10" cols="60"><?php echo set_value('lm_remark_text');?></textarea>
                                        
                                    </div>
                                </div>

                                <div class="row p-2" id="sk_for_reject">
                                    <div class="col-md-6">
                                        <label>
                                            <strong><?=$sl_count++?>.</strong> 
                                        <?php
                                            if(trim($sk_availability) == 'y')
                                            {
                                                echo "<label>Select Supervisor Kanangu (SK)</label>";
                                            }
                                            else
                                            {
                                                echo "<label>Select Circle Officer (CO)</label>";
                                            }
                                        ?>
                                    </label>
                                        <?=form_error('co_code')?>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control <?php if(form_error('co_code')){echo 'lm_invalid';}?>" name='co_code'>
                                        <?php
                                            if($sk_availability == 'y')
                                            {
                                                ?>
                                                <option value="">Select Supervisor Kanangu...</option>

                                                <?php
                                                foreach ($sk_name as $skname) {
                                                    $user_desig_code = $skname->user_desig_code;
                                                    $username = $skname->username." ( ".$user_desig_code." )";
                                                    $user_code = $skname->user_code;
                                                    ?>
                                                    <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                                                        if(set_value('co_code') == $user_code) {
                                                            echo "selected";
                                                        }
                                                    }?>>
                                                        <?=$username?>
                                                    </option>

                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <option value="">Select Circle Officer...</option>

                                                <?php
                                                foreach ($co_name as $coname) {
                                                    $user_desig_code = $coname->user_desig_code;
                                                    $username = $coname->username." ( ".$user_desig_code." )";
                                                    $user_code = $coname->user_code;
                                                    ?>
                                                    <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                                                        if(set_value('co_code') == $user_code) {
                                                            echo "selected";
                                                        }
                                                    }?>>
                                                        <?=$username?>
                                                    </option>

                                                    <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                        <br>

                                    </div>
                                </div>


                                <div class="row p-2" id="co_for_reject" style="display: none;">
                                    <div class="col-md-6">
                                        <strong><?=$sl_count++?>.</strong>
                                        <label>Select Circle Officer (CO)</label>
                                        <?=form_error('co_code_reject')?>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control <?php if(form_error('co_code_reject')) { echo 'lm_invalid';}?>" name='co_code_reject'>      
                                        <!-- <select class="form-control <?php if(form_error('co_code_reject')) { echo 'lm_invalid';}?>" name='co_code'>        -->
                                            <option value="">Select Circle Officer...</option>
                                            <?php
                                            foreach ($co_name_reject as $coname) 
                                            {
                                                $user_desig_code = $coname->user_desig_code;
                                                $username = $coname->username." ( ".$user_desig_code." )";
                                                $user_code = $coname->user_code;
                                                ?>
                                                <option value="<?=$user_code?>" <?php if(isset($err_return)) {
                                                    if(set_value('co_code') == $user_code) {
                                                        echo "selected";
                                                    }
                                                }?>>
                                                    <?=$username?>
                                                </option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <br>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-md-6">
                             
                                        <strong><?=$sl_count++?>.</strong> Premium <span><b>[ Dag No: <?=$dags[0]->dag_no?>]</b></span></label>
                                        <?=form_error('total_due_amount')?>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <button type="button" class="rezaButt buttPrimary <?php if(form_error('validationcheck')){echo 'lm_invalid';}?> <?php if(form_error('totaldue')){echo 'lm_invalid';}?>"
                                                        onclick="premiumModal();" id="">
                                                    Calculate Premium
                                        </button> -->
                                        <button type="button" class="rezaButt buttPrimary <?php if(form_error('total_due_amount')){echo 'lm_invalid';}?>" onclick="premiumModal();">
                                            Calculate Premium
                                        </button><span><b>&nbsp; <br>(10% of the current zonal value + 50 Times of Dag Revenue Value / Bigha)</b></span>
                                        <input type="hidden" name="dag_revenue" class="form-control dag_revenue" value=<?=$revenue->dag_revenue?>  id="dag_revenue" />
                                        <input type="hidden" name="total_s_lessa" class="form-control total_s_lessa" value=""  id="total_s_lessa" />
                                        <input type="hidden" name="total_dag_lessa" class="form-control total_dag_lessa" value=""  id="total_dag_lessa" />

                                    </div>
                                </div>

                                <!-- new premium addition -->
                                <?php
                                    include(APPPATH."views/SettlementView/include/premium_calculation_modal_tenant_mb3.php");
                                ?>

                                <div class="row p-2" style="display:none" id="total_due_row">
                                    <div class="col-md-6">
                                        <strong><?=$sl_count++?>.</strong> Total due amount (Rs) </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input readonly type="text" name="total_due_amount" class="form-control total_due_amount"  id="total_due_amount" value="" />
                                        <span style="color:red; font-weight:bold"><b>&nbsp; <br>(NOTE: Please verify the amount before submit the application)</b></span>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-md-6">
                                        <strong><?=$sl_count++?>.</strong> Compensation Beneficiary </label>
                                        <?=form_error('beneficiary_err')?>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" onclick="compenBene();" class="btn btn-sm btn-warning <?php if(form_error('beneficiary_err')){echo 'lm_invalid';}?>"><strong>Click to select/add Beneficiary</strong></button>
                                     
                                    </div>
                                </div>

                                <?php
                                    //include(APPPATH."views/DagFlagInProcess/dag_flag_in_process.php");
                                ?>

                                <?php
                                  include(APPPATH."views/SettlementView/include/addMoreDocumentView.php");
                                ?>
                              </div>
                            </div>


                            <!-- LM note ends here -->
                            <ul class="list-inline pull-right" style="margin-top: 20px">
                              <li>
                                <button type="button" class="btn btn-default prev-step">
                                  <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                                </button>
                              </li>
                              <?php if(ENABLE_BUTTON_LM_SUBMIT_TENANT_URBAN != 0){?>
                                <li>
                                  <input type="submit" class="btn btn-primary next-step" id="btnLmSubmit" value="Save and submit" onClick="this.disabled=true; this.value='Saving...';">
                                    <!-- <i class="fa fa-check-square-o" aria-hidden="true"></i> Save & Continue
                                  </button> -->
                                </li>
                              <?php } ?>
                            </ul>

                        </div>






                  </div>


<!-- Beneficary modal starts here -->
<div id="beneModal" class="modal">
  <div class="modal-content">
    <div class="row text-right">
      <span class="close-bene px-4">&times;</span>
    </div>
    <p>
      <div class="row">
        <div class="col-md-12 text-center">
          <h5>Beneficiary details <strong><span id="dag_label"></span></strong></h5>
        
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 pl-5 pb-2">
            <span class="alert-warning">
                <i class="fa fa-star" aria-hidden="true"></i> Note : Beneficiary compensation should be total of <b>100%</b> by adding all Beneficiaries. <b>(Total compensation SUM now: <span id="totalCompensation"></span>)</b>
            </span>
        </div>
      </div>
      <div class="container">
  
        <div id="ownerList">
        </div>

        <!-- add beneficiary details -->
        <div class="row justify-content-center mt-2" id="bene_submit" style="display: none;">
          <button type="button" id="save" class="col-4 btn btn-sm btn-primary">SAVE</button>
        </div>
      </div>
    </p>
  </div>
</div>
<!-- Beneficary modal ends here -->




<script>


  $(function () {
    $('#date_notification').datepick({dateFormat: 'dd-mm-yyyy'});
  });

    // function premiumModal(){
                                        
    //     let appbigha=parseFloat($("#s_dag_area_b").val());
    //     let appkatha=parseFloat($("#s_dag_area_k").val());
    //     let applessa=parseFloat($("#s_dag_area_lc").val());
    //     var zonal_bigha = parseFloat($("#dag_revenue").val());
        
    //     let area_b= <?=$revenue->dag_area_b ?>;
    //     let area_k= <?=$revenue->dag_area_k ?>;
    //     let area_lc= <?=$revenue->dag_area_lc ?>;

    //     <?php if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))): ?>
    //     let appganda=parseFloat($("#s_dag_area_g").val());
    //     let area_g= <?=$revenue->dag_area_g ?>;
    //     let total_dag_ganda = parseFloat((area_b * 6400) + (area_k * 320) + (area_lc * 20) + area_g);
    //     let dag_per_ganda_revenue = (zonal_bigha / total_dag_ganda);

    //     let total_app_ganda = parseFloat((appbigha * 6400) + (appkatha * 320) + (applessa * 20) + appganda);
        
    //     var final_amount = (total_app_ganda * dag_per_ganda_revenue);
    //     var total_due= Math.ceil(final_amount * 50);
    //     $('#total_s_lessa').val(total_app_ganda);
    //     $('#total_dag_lessa').val(total_dag_ganda);
        
    //     <?php else : ?>
    //     let total_dag_lessa = parseFloat((area_b * 100) + (area_k * 20) + area_lc);
    //     let dag_per_lessa_revenue = (zonal_bigha / total_dag_lessa);
    //     let total_app_lessa = parseFloat((appbigha * 100) + (appkatha * 20) + applessa);
        
    //     var final_amount = (total_app_lessa * dag_per_lessa_revenue);
    //     var total_due= Math.ceil(final_amount * 50);
    //     $('#total_s_lessa').val(total_app_lessa);
    //     $('#total_dag_lessa').val(total_dag_lessa);
    //     <?php endif ;?>
        
    //     $('#total_due_amount').val(total_due);
    //     $("#total_due_row").show();
    // }

    var premModal = document.getElementById("premiumModal");

    function premiumModal()
    {
        premModal.style.display = "block";

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            premModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == premModal) {
                premModal.style.display = "none";
            }
        }

    }

    $(document).on('click','.closePremium',function ()
    {
        premModal.style.display = "none";
    });

    $("input[name=paymode]").on("click", function () {
        var modeValue = $("input[name=paymode]:checked").val();
        if (modeValue == "YES") {
            $('#totaldue').val('');
            var totaldue= $("#finalamount").val();
            $("#totaldue").val(totaldue);
            $("#lmfinalamount").text(totaldue);
            $("#lmdueamount").text(totaldue);
        }
        else {
            if (modeValue == "NO") {
                var totaldue= $("#finalamount").val();
                var discount = 30;
                var finaldue = Math.ceil(totaldue * discount / 100);
                $("#totaldue").val(finaldue);
                $("#lmfinalamount").text(totaldue);
                $("#lmdueamount").text(finaldue);
            }
        }

    });

    $("#finalsubmit").click(function(){
        if ($('.zonal_valuation_prem').val().length === 0) {
            // alert('Please Enter Zonal Value!!');
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Please Enter Zonal Value!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.zonal_valuation_prem').focus();
            return false;
        }

        if ($('.totalamount').val().length === 0) {
            theme = "blue";
            $.jAlert({
                'title': 'Error: Field Required',
                'content': 'Total Dag Amount can not be blank!!!',
                'theme': theme,
                'backgroundColor': 'white',
                'btns': [
                    {'text':'OK', 'theme':theme}
                ]
            });
            $('.totalamount').focus();
            return false;
        }

        var sum = 0;
        $("input[class *= 'totalamount']").each(function(){
            if ($(this).val().length === 0) {
                theme = "blue";
                $.jAlert({
                    'title': 'Error: Field Required',
                    'content': 'Total Dag Amount can not be blank!!!',
                    'theme': theme,
                    'backgroundColor': 'white',
                    'btns': [
                        {'text':'OK', 'theme':theme}
                    ]
                });
                $('.totalamount').focus();
                sum = '';
                return false;
            }else{
                sum += +$(this).val();
            }
            
        });
        $(".premhide").show();
        $("#finalsubmit").hide();
        $("#finalsave").show();
        $("#closePremium").show();

        $("#finalamount").val(sum);
        $("#totaldue").val(sum);
        $("#paymode1").prop( "checked", true );
        // premModal.style.display = "none";
        $("#premrow").show();
        $("#lmfinalamount").text(sum);
        $("#lmdueamount").text(sum);
    });

    $("#finalsave").click(function(){
        if (!$('#finalamount').val()) {
            alert("Final Amount Can't be blak !!!");
            return;
        }
        $("#premrow").show();
        premModal.style.display = "none";
    });

    $("input[name=prem_update").on("click", function () {

        var selectedValue3 = $("input[name=prem_update]:checked").val();
        if (selectedValue3 == "YES") {

            $("#chngPremButton").show();
            // if($("#textField").val()==null){
            //     alert("Please select premium before proceed!!!");
            //     return false;
            // }

        }
        else {
            if (selectedValue3 == "NO") {
                $("#chngPremButton").hide();

            }
        }

    });

    var row_counter = 0;
    // var compensation_sum = 0;

    function compenBene(){
        var modal = document.getElementById("beneModal");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-bene")[0];
        var save = document.getElementById('save');
        modal.style.display = "block";

        //*****When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            if (confirm("Closing this panel without saving the data will result in lost of inserted data!") == true) 
            {
                $("#ownerList").html("");
                modal.style.display = "none";
            } 
            else 
            {
                return false;
            }
        }

        //******* */ When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                if (confirm("Closing this panel without saving the data will result in lost of inserted data!") == true) 
                {
                    $("#ownerList").html("");
                    modal.style.display = "none";
                } 
                else 
                {
                    return false;
                }
            }
        }

        //****check if beneficiary already added, if so append */
        var case_no = $('#case_no').val();
            
        var postData = {
            'case_no' : case_no
        };
    
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementTenant/checkAddedBeneficiary',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 2)
                {
                    for(i = 0; i < arr.data.length; i++)
                    {
                        $('#ownerList').append("<div class=\"row wrapper p-1\">"+
                            "<div class=\"col-md-3\">"+
                                "<span class=\"alert-warning\">"+
                                    arr.data[i].pdar_name+
                                "</span>"+
                                "<small>"+
                                    "<strong>&nbsp; for Dag no : <?=$dags[0]->dag_no;?></strong>"+
                                "</small>"+
                                "<br>"+
                                "Is the mentioned owner of the land alive?"+
                                "<input type=\"hidden\" id=\"pdar_name_bene"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_name+"\">"+
                                "<input type=\"hidden\" id=\"pdar_id"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_id+"\">"+
                                "<input type=\"hidden\" id=\"owner_name"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_name+"\">"+
                                "<input type=\"hidden\" id=\"owner_father"+arr.data[i].pdar_id+"\" value=\""+arr.data[i].pdar_guardian+"\">"+
                            "</div>"+
                            "<div class=\"col-md-9 text-center\">"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerAlive"+arr.data[i].pdar_id+"\" onclick=\"ownerAlive('"+arr.data[i].pdar_id+"', '"+case_no+"');\" value=\"YES\">"+
                                "&nbsp;<label>Yes</label> &nbsp;"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerDead"+arr.data[i].pdar_id+"\" onclick=\"ownerDead('"+arr.data[i].pdar_id+"', '"+case_no+"');\" value=\"NO\">"+
                                "&nbsp;<label>No</label> &nbsp;"+
                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerUnt"+arr.data[i].pdar_id+"\" onclick=\"ownerUntraceable('"+arr.data[i].pdar_id+"', '"+case_no+"');\" class=\"owner_living_status_class\" value=\"UNT\">"+
                                "&nbsp;<label>Untraceable</label> &nbsp;"+

                                "<input type=\"radio\" name=\"ownerLivingStatus"+arr.data[i].pdar_id+"\" id=\"ownerCca"+arr.data[i].pdar_id+"\" onclick=\"ownerCca('"+arr.data[i].pdar_id+"', '"+case_no+"');\" class=\"owner_living_status_class\" value=\"CCA\">"+
                                "&nbsp;<label>Could not capture account details</label>"+
                            "</div>"+
                        "</div>");

                        $('#ownerList').append("<div id=\"beneList"+arr.data[i].pdar_id+"\"></div>");

                        var postDataC = {
                                'pdar_id' : arr.data[i].pdar_id,
                                'case_no' : case_no
                            };
                                                    
                        $.ajax({
                            url: baseurl+'SettlementTenant/checkOwnerLivingStatus',
                            type: "POST",
                            data: postDataC,
                            success: function(data) {
                                arrOwnLiv = JSON.parse(data);
                                $.unblockUI();

                                // console.log(arrOwnLiv.data.owner_living_status);
                                if(arrOwnLiv.responseType == 2)
                                {
                                    if(arrOwnLiv.data.owner_living_status == 'YES')
                                    {
                                        $("#ownerAlive"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                        "<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Beneficiary Name</th>"+
                                                    "<th>Compensation Percentage</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append(
                                                           "<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_name+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_percentage+"</td>"+
                                                                "<td>"+arrBen.data[i].amount+"</td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });
                                    }
                                    if(arrOwnLiv.data.owner_living_status == 'NO')
                                    {
                                        $("#ownerDead"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                            "<div class=\"row justify-content-end pl-3 pr-3\">"+
                                                "<button onclick=\"ownerDead('"+arrOwnLiv.pdar_id+"', '"+case_no+"')\" class=\"col-1 btn btn-sm btn-info\" type=\"button\">Add more</button>"+
                                                "&nbsp; &nbsp; <button onclick=\"closeForm('"+arrOwnLiv.pdar_id+"')\" class=\"col-1 btn btn-sm btn-warning\" type=\"button\">Close</button>"+
                                            "</div>"
                                        );

                                        $('#beneList'+arrOwnLiv.pdar_id).append("<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Beneficiary Name</th>"+
                                                    "<th>Compensation Percentage</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append("<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_name+"</td>"+
                                                                "<td>"+arrBen.data[i].bene_percentage+"</td>"+
                                                                "<td>"+arrBen.data[i].amount+"</td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });
                                    }
                                    if(arrOwnLiv.data.owner_living_status == 'UNT')
                                    {
                                        $("#ownerUnt"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                        "<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Owner Name</th>"+
                                                    "<th>Owner Guardian Name</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append(
                                                           "<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_name+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_father+"</td>"+
                                                                "<td><span class=\"alert-danger\">Untraceable</span></td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });


                                    }

                                    if(arrOwnLiv.data.owner_living_status == 'CCA')
                                    {
                                        $("#ownerCca"+arrOwnLiv.pdar_id).prop( "checked", true );

                                        $('#ownerAlive'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerDead'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerUnt'+arrOwnLiv.pdar_id).attr('disabled','disabled');
                                        $('#ownerCca'+arrOwnLiv.pdar_id).attr('disabled','disabled');

                                        $('#beneList'+arrOwnLiv.pdar_id).append(
                                        "<table class=\"table table-bordered mt-2\" id=\"exist_bene_list"+arrOwnLiv.pdar_id+"\">"+
                                            "<thead>"+
                                                "<tr>"+
                                                    "<th>#</th>"+
                                                    "<th>Owner Name</th>"+
                                                    "<th>Owner Guardian Name</th>"+
                                                    "<th>Amount</th>"+
                                                    "<th>Action</th>"+
                                                "</tr>"+
                                            "</thead>"+
                                        "</table>");

                                        var postData = {
                                                'pdar_id' : arrOwnLiv.pdar_id,
                                                'case_no' : case_no
                                            };
                                                                    
                                        $.ajax({
                                            url: baseurl+'SettlementTenant/getInsertedBeneficiary',
                                            type: "POST",
                                            data: postData,
                                            success: function(data) {
                                                arrBen = JSON.parse(data);
                                                $.unblockUI();
                                                if(arrBen.responseType == 2)
                                                {
                                                    var sl = 1;
                                                    for(i = 0; i < arrBen.data.length; i++)
                                                    {
                                                        $('#exist_bene_list'+arrBen.data[i].pdar_id).append(
                                                           "<tr>"+
                                                                "<td>"+sl+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_name+"</td>"+
                                                                "<td>"+arrBen.data[i].owner_father+"</td>"+
                                                                "<td><span class=\"alert-danger\">Could not capture account details</span></td>"+
                                                                "<td><button title=\"Delete\" type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteBeneficiary('"+arrBen.data[i].id+"', '"+arrBen.data[i].pdar_id+"', '"+case_no+"')\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></button></td>"+
                                                            "</tr>");
                                                        sl++;
                                                    }
                                                }
                                            }
                                        });


                                    }

                                }
                            }
                        });

                        $('#ownerList').append("<table class=\"table table-bordered\" id=\"ownerInputForm"+arr.data[i].pdar_id+"\"></table>");
                        $('#ownerList').append("<hr>");

                    }
                }
            }
        });
    }

    $(document).ready(function() {
        $('#totalCompensation').html('');
        totalCompensationSum();
    });

    function totalCompensationSum()
    {
        case_no = $.trim($('#case_no').val());

        var postData = {
            'case_no' : case_no
        };
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementTenant/totalCompensationSum',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0){
                    showErrorMessage(arr.msg);
                }
                else{
                    $('#totalCompensation').html(arr.data);
                }
            }
        });
    }

    function closeForm(pdar_id)
    {
        $('#ownerInputForm'+pdar_id).html('');
    }

    function ownerAlive(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();
        var total_due_amount = $.trim($('#total_due_amount').val());

        if(total_due_amount == '')
        {
            alert('Please calculate premium before enter Beneficiary data !');
            $("#ownerAlive"+pdar_id).prop( "checked", false );
            return false;
        }

        var postData = {
            'pdar_id' : pdar_id,
            'case_no' : case_no
        };
    
        // $.unblockUI();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementTenant/checkIfAreadlyBeneExist',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 1)
                {
                    //*******if data doesnot exist then enter option */
                    $('#ownerInputForm'+pdar_id).html('');
                    $('#ownerInputForm'+pdar_id).append("<thead>"+
                            "<tr class=\"bg-success\">"+
                                "<th class=\"text-center\" colspan=\"4\">Enter Owner Details</th>"+
                            "</tr>"+
                        "</thead>"+
                        "<tr>"+
                            "<input type=\"hidden\" id=\"original_owner_father"+pdar_id+"\" value=\""+owner_father+"\">"+
                            "<input type=\"hidden\" id=\"original_owner_name"+pdar_id+"\" value=\""+owner_name+"\">"+
                            "<input type=\"hidden\" id=\"total_due_amount"+pdar_id+"\" value=\""+total_due_amount+"\">"+
                            "<td>"+
                                "<label>Enter owners PAN number</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter PAN number\" class=\"form-control\" id=\"pan_number"+pdar_id+"\">"+
                            "</td>"+
                            "<td>"+
                                "<label>Name of the Bank</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter Bank name\" class=\"form-control\" id=\"bank_name"+pdar_id+"\">"+
                            "</td>"+
                    
                        "</tr>"+

                        "<tr>"+
                            "<td>"+
                                "<label>Enter Bank Account Number</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"number\" placeholder=\"Enter Account name\" class=\"form-control\" id=\"acc_number"+pdar_id+"\">"+
                            "</td>"+
                            "<td>"+
                                "<label>Enter Bank IFSC</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"text\" placeholder=\"Enter IFSC\" class=\"form-control\" id=\"bank_ifsc"+pdar_id+"\">"+
                            "</td>"+
                        "</tr>"+

                        "<tr>"+
                            "<td>"+
                                "<label>Percentage of Compensation</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"number\" placeholder=\"Enter compensation percentage\" class=\"form-control\" id=\"percentage_compensation"+pdar_id+"\">"+
                            "</td>"+
                            "<td>"+
                                "<label>Bank passbook/Cancelled Cheque copy</label>"+
                            "</td>"+
                            "<td>"+
                                "<input type=\"file\" class=\"form-control\" id=\"bank_photo"+pdar_id+"\">"+
                            "</td>"+
                        "</tr>"+

                        "<tr>"+
                            "<td class=\"text-center\" colspan=\"4\">"+
                                "<button type=\"button\" onclick=\"insertOwnerData('"+pdar_id+"', '"+case_no+"')\" class=\"btn btn-primary btn-sm pl-3 pr-3\">Save</button>"+
                            "</td>"+
                        "</tr>");
                }
            }
        });
    }

    function insertOwnerData(pdar_id, case_no)
    {
        var owner_pan_no = $.trim($('#pan_number'+pdar_id).val());
        var owner_bank_name = $.trim($('#bank_name'+pdar_id).val());
        var owner_acc_no = $.trim($('#acc_number'+pdar_id).val());
        var owner_ifsc = $.trim($('#bank_ifsc'+pdar_id).val());
        var original_owner_father = $.trim($('#original_owner_father'+pdar_id).val());
        var original_owner_name = $.trim($('#original_owner_name'+pdar_id).val()); 
        var total_due_amount = $.trim($('#total_due_amount'+pdar_id).val()); 
        var bene_percentage = $.trim($('#percentage_compensation'+pdar_id).val());

        if(owner_pan_no == '')
        {
            alert('Please enter owner_pan_no!');
            $('#pan_number'+pdar_id).focus();
            return false;
        }
        if(owner_bank_name == '')
        {
            alert('Please enter owner_bank_name!');
            $('#bank_name'+pdar_id).focus();
            return false;
        }
        if(owner_acc_no == '')
        {
            alert('Please enter owner_acc_no!');
            $('#acc_number'+pdar_id).focus();
            return false;
        }
        if(owner_ifsc == '')
        {
            alert('Please enter owner_ifsc!');
            $('#bank_ifsc'+pdar_id).focus();
            return false;
        }
        if(original_owner_father == '')
        {
            alert('Please enter original_owner_father!');
            $('#original_owner_father'+pdar_id).focus();
            return false;
        }
        if(original_owner_name == '')
        {
            alert('Please enter original_owner_name!');
            $('#original_owner_name'+pdar_id).focus();
            return false;
        }
        if(total_due_amount == '')
        {
            alert('Please enter total_due_amount!');
            $('#total_due_amount'+pdar_id).focus();
            return false;
        }
        if(bene_percentage == '')
        {
            alert('Please enter bene_percentage!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if(bene_percentage > 100)
        {
            alert('The Percentage of compensation should not be greater then 100!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if($('#bank_photo'+pdar_id).val() == '')
        {
            alert('Please upload Bank/cheque copy!');
            $('#bank_photo'+pdar_id).focus();
            return false;
        }

        var postData = new FormData();
        postData.append("owner_pan_no", owner_pan_no);
        postData.append("owner_bank_name", owner_bank_name);
        postData.append("owner_acc_no", owner_acc_no);
        postData.append("owner_ifsc", owner_ifsc);
        postData.append("bank_photo", $("#bank_photo"+pdar_id)[0].files[0]);
        postData.append("original_pdar_id", pdar_id);
        postData.append("original_owner_father", original_owner_father);
        postData.append("original_owner_name", original_owner_name);
        postData.append("owner_living_stats", 'YES');
        postData.append("case_no", case_no);
        postData.append("total_due_amount", total_due_amount);
        postData.append("bene_percentage", bene_percentage);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
           url: baseurl+'SettlementTenant/insertOwnerData',
           type: "POST",
           data: postData,
           enctype: 'multipart/form-data',
           contentType: false,
           cache: false,
           processData:false,
           success: function(data) {
               arr = JSON.parse(data);               
               $.unblockUI();

               if(arr.responseType == 0)
               {
                   showErrorMessage(arr.msg);
               }
               else
               {
                   Swal.fire({
                           text: arr.msg,
                           icon: 'success',
                           confirmButtonText: 'OK',
                           customClass: {
                               actions: 'my-actions',
                               confirmButton: 'order-2',
                           }
                   }).then((result) => {
                       if (result.isConfirmed) {
                            $("#ownerList").html("");
                            compenBene();
                            $('#totalCompensation').html('');
                            totalCompensationSum();
                       }
                   })
               }
           }
       });
    }

    function deleteBeneficiary(id, pdar_id, case_no)
    {
        var postData = {
            'id' : id,
            'pdar_id' : pdar_id,
            'case_no' : case_no
        };

        Swal.fire({
            title: 'Do you want to delete this data?',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
        
                $.ajax({
                    url: baseurl+'SettlementTenant/deleteBeneficiary',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        $.unblockUI();
                        if(arr.responseType == 0){
                            showErrorMessage(arr.msg);
                        }
                        else{
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#ownerList").html("");
                                    compenBene();
                                    $('#totalCompensation').html('');
                                    totalCompensationSum();
                                }
                            })
                        }
                    }
                });
            }
        })
    }

    function ownerDead(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();
        var total_due_amount = $.trim($('#total_due_amount').val());

        if(total_due_amount == '')
        {
            alert('Please calculate premium before enter Beneficiary data !');
            $("#ownerAlive"+pdar_id).prop( "checked", false );
            return false;
        }

        var postData = {
            'pdar_id' : pdar_id,
            'case_no' : case_no
        };
    
        // $.unblockUI();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'SettlementTenant/checkIfAreadlyBeneExist',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 1 || arr.responseType == 2)
                {

                    //*******if data doesnot exist then enter option */
                    $('#ownerInputForm'+pdar_id).html('');
                    $('#ownerInputForm'+pdar_id).append("<thead>"+
                        "<tr class=\"bg-success\">"+
                            "<th class=\"text-center\" colspan=\"4\">Enter NOK (Beneficiary) Details</th>"+
                        "</tr>"+
                    "</thead>"+
                    "<tr>"+
                        "<input type=\"hidden\" id=\"original_owner_father"+pdar_id+"\" value=\""+owner_father+"\">"+
                        "<input type=\"hidden\" id=\"original_owner_name"+pdar_id+"\" value=\""+owner_name+"\">"+
                        "<input type=\"hidden\" id=\"total_due_amount"+pdar_id+"\" value=\""+total_due_amount+"\">"+

                        "<td>"+
                            "<label>Enter Name</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter Name\" class=\"form-control\" id=\"bene_name"+pdar_id+"\">"+
                        "</td>"+

                        "<td>"+
                            "<label>Guardian Name</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter Guardian Name\" class=\"form-control\" id=\"bene_guardian_name"+pdar_id+"\">"+
                        "</td>"+

                    "</tr>"+

                    "<tr>"+
                        "<td>"+
                            "<label>Relation With Owner</label>"+
                        "</td>"+
                        "<td>"+
                            "<select class=\"form-control\" id=\"bene_relation"+pdar_id+"\">"+
                                "<?php foreach ($guar_rel as $guar_rel_list) {?>"+
                                    "<option value=\"<?=$guar_rel_list->id?>\"><?=$guar_rel_list->guard_rel_desc_as?></option>"+
                                "<?php }?>"+
                            "</select>"+
                        "</td>"+

                        "<td>"+
                            "<label>Gender</label>"+
                        "</td>"+
                        "<td>"+
                            "<select class=\"form-control\" id=\"bene_gender"+pdar_id+"\">"+
                                "<option value=\"1\">Male</option>"+
                                "<option value=\"2\">Female</option>"+
                                "<option value=\"3\">Female</option>"+
                            "</select>"+
                        "</td>"+
                    "</tr>"+

                    "<tr>"+

                        "<td>"+
                            "<label>DOB</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"date\" placeholder=\"Enter DOB\" class=\"form-control ymd\" id=\"bene_dob"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Mobile</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"number\" maxlength=\"10\" placeholder=\"Enter Mobile number\" class=\"form-control\" id=\"bene_mobile"+pdar_id+"\">"+
                        "</td>"+

                    "</tr>"+

                    
                    "<tr>"+

                        "<td>"+
                            "<label>Present Address</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter present address\" class=\"form-control\" id=\"bene_present_add"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Permanent Address</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter permanent address\" class=\"form-control\" id=\"bene_permanent"+pdar_id+"\">"+
                        "</td>"+

                    "</tr>"+

                    "<tr>"+

                        "<td>"+
                            "<label>Enter owners PAN number</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter PAN number\" class=\"form-control\" id=\"pan_number"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Name of the Bank</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter Bank name\" class=\"form-control\" id=\"bank_name"+pdar_id+"\">"+
                        "</td>"+
                
                    "</tr>"+

                    "<tr>"+
                        "<td>"+
                            "<label>Enter Bank Account Number</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"number\" placeholder=\"Enter Account name\" class=\"form-control\" id=\"acc_number"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Enter Bank IFSC</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" placeholder=\"Enter IFSC\" class=\"form-control\" id=\"bank_ifsc"+pdar_id+"\">"+
                        "</td>"+
                    "</tr>"+

                    "<tr>"+
                        "<td>"+
                            "<label>Percentage of Compensation</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"number\" placeholder=\"Enter compensation percentage\" class=\"form-control\" id=\"percentage_compensation"+pdar_id+"\">"+
                        "</td>"+
                        "<td>"+
                            "<label>Bank passbook/Cancelled Cheque copy</label>"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"file\" class=\"form-control\" id=\"bank_photo"+pdar_id+"\">"+
                        "</td>"+
                    "</tr>"+

                    "<tr>"+
                        "<td class=\"text-center\" colspan=\"4\">"+
                            "<button type=\"button\" onclick=\"insertBeneficiaryData('"+pdar_id+"', '"+case_no+"')\" class=\"btn btn-primary btn-sm pl-3 pr-3\">Save</button>"+
                        "</td>"+
                    "</tr>");
                }
            }
        });
    }

    function insertBeneficiaryData(pdar_id, case_no)
    {
        var owner_pan_no = $.trim($('#pan_number'+pdar_id).val());
        var owner_bank_name = $.trim($('#bank_name'+pdar_id).val());
        var owner_acc_no = $.trim($('#acc_number'+pdar_id).val());
        var owner_ifsc = $.trim($('#bank_ifsc'+pdar_id).val());
        var original_owner_father = $.trim($('#original_owner_father'+pdar_id).val());
        var original_owner_name = $.trim($('#original_owner_name'+pdar_id).val()); 
        var total_due_amount = $.trim($('#total_due_amount'+pdar_id).val()); 
        var bene_percentage = $.trim($('#percentage_compensation'+pdar_id).val());

        var bene_name = $.trim($('#bene_name'+pdar_id).val());
        var bene_guardian_name = $.trim($('#bene_guardian_name'+pdar_id).val());
        var bene_relation = $.trim($('#bene_relation'+pdar_id).val());
        var bene_gender = $.trim($('#bene_gender'+pdar_id).val());
        var bene_dob = $.trim($('#bene_dob'+pdar_id).val());
        var bene_mobile = $.trim($('#bene_mobile'+pdar_id).val());
        var bene_present_add = $.trim($('#bene_present_add'+pdar_id).val());
        var bene_permanent = $.trim($('#bene_permanent'+pdar_id).val());

        if(bene_name == '')
        {
            alert('Please enter bene_name');
            $('#bene_name'+pdar_id).focus();
            return false;
        }
        if(bene_guardian_name == '')
        {
            alert('Please enter bene_guardian_name');
            $('#bene_guardian_name'+pdar_id).focus();
            return false;
        }
        if(bene_relation == '')
        {
            alert('Please enter bene_relation');
            $('#bene_relation'+pdar_id).focus();
            return false;
        }
        if(bene_gender == '')
        {
            alert('Please enter bene_gender');
            $('#bene_gender'+pdar_id).focus();
            return false;
        }
        if(bene_dob == '')
        {
            alert('Please enter bene_dob');
            $('#bene_dob'+pdar_id).focus();
            return false;
        }
        if(bene_mobile == '')
        {
            alert('Please enter bene_mobile');
            $('#bene_mobile'+pdar_id).focus();
            return false;
        }
        if(bene_present_add == '')
        {
            alert('Please enter bene_present_add');
            $('#bene_present_add'+pdar_id).focus();
            return false;
        }
        if(bene_permanent == '')
        {
            alert('Please enter bene_permanent');
            $('#bene_permanent'+pdar_id).focus();
            return false;
        }

        if(owner_pan_no == '')
        {
            alert('Please enter owner_pan_no!');
            $('#pan_number'+pdar_id).focus();
            return false;
        }
        if(owner_bank_name == '')
        {
            alert('Please enter owner_bank_name!');
            $('#bank_name'+pdar_id).focus();
            return false;
        }
        if(owner_acc_no == '')
        {
            alert('Please enter owner_acc_no!');
            $('#acc_number'+pdar_id).focus();
            return false;
        }
        if(owner_ifsc == '')
        {
            alert('Please enter owner_ifsc!');
            $('#bank_ifsc'+pdar_id).focus();
            return false;
        }
        if(original_owner_father == '')
        {
            alert('Please enter original_owner_father!');
            $('#original_owner_father'+pdar_id).focus();
            return false;
        }
        if(original_owner_name == '')
        {
            alert('Please enter original_owner_name!');
            $('#original_owner_name'+pdar_id).focus();
            return false;
        }
        if(total_due_amount == '')
        {
            alert('Please enter total_due_amount!');
            $('#total_due_amount'+pdar_id).focus();
            return false;
        }
        if(bene_percentage == '')
        {
            alert('Please enter bene_percentage!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if(bene_percentage > 100)
        {
            alert('The Percentage of compensation should not be greater then 100!');
            $('#percentage_compensation'+pdar_id).focus();
            return false;
        }
        if($('#bank_photo'+pdar_id).val() == '')
        {
            alert('Please upload Bank/cheque copy!');
            $('#bank_photo'+pdar_id).focus();
            return false;
        }

        var postData = new FormData();
        postData.append("owner_pan_no", owner_pan_no);
        postData.append("owner_bank_name", owner_bank_name);
        postData.append("owner_acc_no", owner_acc_no);
        postData.append("owner_ifsc", owner_ifsc);
        postData.append("bank_photo", $("#bank_photo"+pdar_id)[0].files[0]);
        postData.append("original_pdar_id", pdar_id);
        postData.append("original_owner_father", original_owner_father);
        postData.append("original_owner_name", original_owner_name);
        postData.append("owner_living_stats", 'NO');
        postData.append("case_no", case_no);
        postData.append("total_due_amount", total_due_amount);
        postData.append("bene_percentage", bene_percentage);

        postData.append('bene_name', bene_name);
        postData.append('bene_guardian_name', bene_guardian_name);
        postData.append('bene_relation', bene_relation);
        postData.append('bene_gender', bene_gender);
        postData.append('bene_dob', bene_dob);
        postData.append('bene_mobile', bene_mobile);
        postData.append('bene_present_add', bene_present_add);
        postData.append('bene_permanent', bene_permanent);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
           url: baseurl+'SettlementTenant/insertBeneficiaryData',
           type: "POST",
           data: postData,
           enctype: 'multipart/form-data',
           contentType: false,
           cache: false,
           processData:false,
           success: function(data) {
               arr = JSON.parse(data);               
               $.unblockUI();

               if(arr.responseType == 0)
               {
                   showErrorMessage(arr.msg);
               }
               else
               {
                   Swal.fire({
                           text: arr.msg,
                           icon: 'success',
                           confirmButtonText: 'OK',
                           customClass: {
                               actions: 'my-actions',
                               confirmButton: 'order-2',
                           }
                   }).then((result) => {
                       if (result.isConfirmed) {
                            $("#ownerList").html("");
                            compenBene();
                            $('#totalCompensation').html('');
                            totalCompensationSum();
                       }
                   })
               }
           }
       });
    }

    function ownerUntraceable(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();

        var postData = {
            'owner_living_status' : 'UNT',
            'owner_name' : owner_name,
            'owner_father' : owner_father,
            'pdar_id' : pdar_id,
            'case_no' : case_no,
        };

        Swal.fire({
            title: 'This option will save the owner as untraceable...',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
        
                $.ajax({
                    url: baseurl+'SettlementTenant/ownerUntraceble',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        $.unblockUI();
                        if(arr.responseType == 0){
                            showErrorMessage(arr.msg);
                        }
                        else{
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#ownerList").html("");
                                    compenBene();
                                    $('#totalCompensation').html('');
                                    totalCompensationSum();
                                }
                            })
                        }
                    }
                });
            }
            else
            {
                $("#ownerUnt"+pdar_id).prop( "checked", false );
            }
            
        })

    }

    function ownerCca(pdar_id, case_no)
    {
        var owner_name = $('#owner_name'+pdar_id).val();
        var owner_father = $('#owner_father'+pdar_id).val();

        var postData = {
            'owner_living_status' : 'CCA',
            'owner_name' : owner_name,
            'owner_father' : owner_father,
            'pdar_id' : pdar_id,
            'case_no' : case_no,
        };

        Swal.fire({
            title: 'This option will save as account details could not be captured...',
            showCancelButton: true,
            confirmButtonText: 'CONFIRM',
        }).then((result) => {
            if (result.isConfirmed) {

                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
        
                $.ajax({
                    url: baseurl+'SettlementTenant/ownerUntraceble',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        $.unblockUI();
                        if(arr.responseType == 0){
                            showErrorMessage(arr.msg);
                        }
                        else{
                            Swal.fire({
                                    text: arr.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        actions: 'my-actions',
                                        confirmButton: 'order-2',
                                    }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#ownerList").html("");
                                    compenBene();
                                    $('#totalCompensation').html('');
                                    totalCompensationSum();
                                }
                            })
                        }
                    }
                });
            }
            else
            {
                $("#ownerCca"+pdar_id).prop( "checked", false );
            }
            
        })

    }


</script>

    <!-- LM template start -->

    <?php
    if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY))))
    {
        if(isset($property) && !empty($property)) {
            $resultprop = array();
            foreach($property as $isproperty):
                $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে " .$isproperty->ganda. " গ";
            endforeach;
            $aditional_prop_temp=implode(",",$resultprop);
            $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
        } 
        else { 
            $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
        }
    }
    else
    {
        if(isset($property) && !empty($property)) {
            $resultprop = array();
            foreach($property as $isproperty):
                $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে";
            endforeach;
            $aditional_prop_temp=implode(",",$resultprop);
            $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
        } 
        else { 
            $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
        }
    }
?>

<?php
    if((in_array($basic['dist_code'], json_decode(BARAK_VALLEY)))){
        $resultdags = array();
        foreach($applicants as $dags_lmtemplate){ 

            if($dags_lmtemplate->is_applicant == 1){

                $resultdags[] = $dags_lmtemplate->dag_no;
                if($dags_lmtemplate->is_applicant == 1)
                {
                    $app_name=$dags_lmtemplate->name_ass;
                }
                ?>
                <input type="hidden" id="sbigha" name='sbigha'>
                <input type="hidden" id="skatha" name='skatha'>
                <input type="hidden" id="slessa" name='slessa'>
                <input type="hidden" id="sganda" name='sganda'>

                <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                <input type="hidden" id="alloted_katha" name='alloted_katha'>
                <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
                <input type="hidden" id="alloted_ganda" name='alloted_ganda'>

                <script>
                    function totalAppliedArea(){
                        var total_area = 0;
                        var mbigha = parseFloat($("#s_dag_area_b").val());
                        var mkatha = parseFloat($("#s_dag_area_k").val());
                        var mlessa = parseFloat($("#s_dag_area_lc").val());
                        var mganda = parseFloat($("#s_dag_area_g").val());
                        var total_area = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
                        

                        var bigha_r = Math.floor(total_area / 100);
                        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                        var bigha_r = Math.floor(total_area / 6400);
                        var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
                        var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
                        var ganda_r = (total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20).toFixed(2);

                        $("#sbigha").val(bigha_r);
                        $("#skatha").val(katha_r);
                        $("#slessa").val(lessa_r);
                        $("#sganda").val(ganda_r);

                        var total_road_reserved = 0;
                        var total_lm_reserved = 0;
                        var total_family_reserved = 0;
                        var total_lm_family_reserved = 0;
                        <?php foreach($applicants as $dags_lmtemplate3){ ?>

                            var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;                
                            var road_ganda=$("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                            total_lm_reserved = total_lm_reserved + total_road_reserved;

                            var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var family_ganda=$("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_ganda_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                            total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                        <?php } ?>

                        var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                        var alloted_bigha = Math.floor(total_alloted_area / 6400);
                        var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 6400) / 320);
                        var alloted_lessa = Math.floor((total_alloted_area - (alloted_bigha * 6400) - (alloted_katha * 320)) / 20);
                        var alloted_ganda = (total_alloted_area - alloted_bigha * 6400 - alloted_katha * 320 - alloted_lessa * 20).toFixed(2);
                        // alert(total_alloted_area);
                        $("#alloted_bigha").val(alloted_bigha);
                        $("#alloted_katha").val(alloted_katha);
                        $("#alloted_lessa").val(alloted_lessa);
                        $("#alloted_ganda").val(alloted_ganda);

                    }
                </script>

            <?php
            } 
        }
        $all_dags=implode(",",$resultdags); ?>
    <?php 
    } 
    else
    {
        $resultdags = array();

        foreach($applicants as $dags_lmtemplate) {
            if($dags_lmtemplate->is_applicant == 1){
                $resultdags[] = $dags_lmtemplate->dag_no;
                if($dags_lmtemplate->is_applicant == 1) {
                    $app_name=$dags_lmtemplate->pdar_name;
                }
                ?>

                <input type="hidden" id="sbigha" name='sbigha'>
                <input type="hidden" id="skatha" name='skatha'>
                <input type="hidden" id="slessa" name='slessa'>
                <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
                <input type="hidden" id="alloted_katha" name='alloted_katha'>
                <input type="hidden" id="alloted_lessa" name='alloted_lessa'>

                <script>
                    function totalAppliedArea(){
                        var total_area = 0;
                        var mbigha = parseFloat($("#s_dag_area_b").val());
                        var mkatha = parseFloat($("#s_dag_area_k").val());
                        var mlessa = parseFloat($("#s_dag_area_lc").val());
                        var total_area = ((mbigha * 100) + (mkatha * 20) + mlessa);
                        

                        var bigha_r = Math.floor(total_area / 100);
                        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                        $("#sbigha").val(bigha_r);
                        $("#skatha").val(katha_r);
                        $("#slessa").val(lessa_r);

                        var total_road_reserved = 0;
                        var total_lm_reserved = 0;
                        var total_family_reserved = 0;
                        var total_lm_family_reserved = 0;
                        <?php foreach($applicants as $dags_lmtemplate3) { ?>
                            var road_bigha=$("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var road_katha=$("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var road_lessa=$("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa<?=$dags_lmtemplate3->dag_no?>").val()) : 0;                
                            total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                            total_lm_reserved = total_lm_reserved + total_road_reserved;

                            var family_bigha=$("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_bigha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var family_katha=$("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_katha_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            var family_lessa=$("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val() ? parseFloat($("#reserved_lessa_family<?=$dags_lmtemplate3->dag_no?>").val()) : 0;
                            total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                            total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                        <?php } ?>

                        var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                        var alloted_bigha = Math.floor(total_alloted_area / 100);
                        var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 100) / 20);
                        var alloted_lessa = total_alloted_area - alloted_bigha * 100 - alloted_katha * 20;
                        // alert(total_alloted_area);
                        $("#alloted_bigha").val(alloted_bigha);
                        $("#alloted_katha").val(alloted_katha);
                        $("#alloted_lessa").val(alloted_lessa);

                    }
                </script>

            <?php 
            }
        }
        $all_dags=implode(",",$resultdags);
    }
?>

<!-- LM template end -->




                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>


<script>
    function reset(){

        $('#total_due_amount').val('');
        $('#validationcheck').val('');
        $('#finalamount').val('');
        $('#lm_remark').val('');
        $('.totalamount').val('');
        $('#lm_remark_text').text('');
        // $('#lm_remark_additional').text('');
        var case_no = $('#case_no').val();

        $.ajax({
            url: baseurl+'SettlementTenant/deleteBeneficiaryData',
            type: 'post',
            data: {'case_no': case_no},
        })


    }
</script>

<script>
    function roadSideReservYes() {
        var x = document.getElementById('road_side_reservation_hide')
        if (x.style.display === 'none') {
            x.style.display = 'block'
        }
    }
    //  else {
    //   x.style.display = "none";
    // }
    function roadSideReservNo() {
        var x = document.getElementById('road_side_reservation_hide')
        if (x.style.display === 'block') {
            x.style.display = 'none'
        }
    }

    function rk_already_exist() {
        var x = document.getElementById('riotee_name')
        if (x.style.display === 'none') {
            x.style.display = 'block'
        }
    }

    function rk_to_be_added() {
        var x = document.getElementById('riotee_name')
        if (x.style.display === 'block') {
            x.style.display = 'none'
        }
    }

    // zonal value validation
    $('#zonal_valuation').keyup(function () {
        var nodir_kaijo_b = $('#reserved_bigha').val()
        var nodir_kaijo_k = $('#reserved_katha').val()
        var nodir_kaijo_lc = $('#reserved_lessa').val()
        window.nodirkakhorlessa =
            parseFloat(nodir_kaijo_b) * 100 +
            parseFloat(nodir_kaijo_k) * 20 +
            parseFloat(nodir_kaijo_lc)
        console.log(window.nodirkakhorlessa)
        var mbigha = $('.s_dag_area_b').val()
        var mkatha = $('.s_dag_area_k').val()
        var mlessa = $('.s_dag_area_lc').val()
        //window.originallessa = parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa);
        window.originallessa =
            parseFloat(mbigha) * 100 + parseFloat(mkatha) * 20 + parseFloat(mlessa)
        console.log(window.originallessa)
        // alert(originallessa);
        window.occupiedlessa = nodirkakhorlessa
        window.remaininglessa = originallessa - occupiedlessa
        if (originallessa <= nodirkakhorlessa) {
            alert("Road/River side reservation can't be greater then original land")
            $('#reserved_bigha').val('0')
            $('#reserved_katha').val('0')
            $('#reserved_lessa').val('0')
            window.nodirkakhorlessa = 0
            window.occupiedlessa = nodirkakhorlessa
            window.remaininglessa = originallessa - occupiedlessa
        }
        if (originallessa <= occupiedlessa) {
            alert("Total Reservation land can't be greater then original land")
            $('#reserved_bigha').val('0')
            $('#reserved_katha').val('0')
            $('#reserved_lessa').val('0')
            window.nodirkakhorlessa = 0
            window.occupiedlessa = nodirkakhorlessa
            window.remaininglessa = originallessa - occupiedlessa
        }
        //alert(remaininglessa);
        var bigha_r = Math.floor(remaininglessa / 100)
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20)
        var lessa_r = (remaininglessa - bigha_r * 100 - katha_r * 20).toFixed(2)
    })
</script>
<!-- for scrolling to specific point of errors -js- -->

<script>
    // LM remark template start
    $("#lm_remark").change(function (event) {

    var selectedRemark=$(this).val();

    if(selectedRemark==1){
        $('#lm_remark_text_id').show();

        // alert("You have Selected  :: "+selectedRemark);
        totalAppliedArea();
        $('#lm_remark_text').text('');
        <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))): ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('.khatian_no_id').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ ভূমি পূৰ্বতে গ্ৰাম্যাঞ্চলত থকা আৰু বৰ্তমান নগৰ অঞ্চলত অন্তৰ্ভুক্ত হোৱাত দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php else : ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('.khatian_no_id').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে ভূমি পূৰ্বতে গ্ৰাম্যাঞ্চলত থকা আৰু বৰ্তমান নগৰ অঞ্চলত অন্তৰ্ভুক্ত হোৱাত দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পাৰি।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php endif ;?>

    }else if(selectedRemark==2){
        $('#lm_remark_text_id').show();

        totalAppliedArea();
        $('#lm_remark_text').text('');
        <?php if((in_array($app['dist_code'], json_decode(BARAK_VALLEY)))): ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('.khatian_no_id').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" চ "+$('#sganda').val()+" গ ভূমি পূৰ্বতে গ্ৰাম্যাঞ্চলত থকা আৰু বৰ্তমান নগৰ অঞ্চলত অন্তৰ্ভুক্ত হোৱাত দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পৰা নাযায়।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php else : ?>
        $('#lm_remark_text').text("আবেদনকাৰী শ্ৰী <?php echo $app_name?> য়ে <?php echo $this->utilityclass->getCircleName($app['dist_code'],$app['subdiv_code'],$app['cir_code'])?> ৰাজহ চক্ৰৰ  <?php echo $this->utilityclass->getMouzaName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'])?> মৌজাৰ <?php echo $this->utilityclass->getLotName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'])?>ৰ <?php echo $this->utilityclass->getVillageName($app['dist_code'],$app['subdiv_code'],$app['cir_code'],$app['mouza_pargona_code'],$app['lot_no'],$app['vill_townprt_code'])?> ৰাজহ গাওঁৰ "+$('#patta_type_code_display').val()+" পট্টাৰ অন্তৰ্গত "+$('.khatian_no_id').val()+" নং ৰায়তী খাতিয়ানভূক্ত <?php echo $all_dags?> দাগৰ "+$('#sbigha').val()+" বি "+$('#skatha').val()+" ক "+$('#slessa').val()+" লে ভূমি পূৰ্বতে গ্ৰাম্যাঞ্চলত থকা আৰু বৰ্তমান নগৰ অঞ্চলত অন্তৰ্ভুক্ত হোৱাত দখলি থকা ৰায়ত হিচাপে মালিকীস্বত্ব পাবৰ বাবে আবেদন কৰিছে।");
        $('#lm_remark_text').append("\n \n চৰজামিন তদন্তৰ সময়ত উক্ত ভূমি আবেদনকাৰীয়ে কৃষি কাৰ্য কৰি দখলত ৰখা দেখা যায়।");
        $('#lm_remark_text').append("\n \n গতিকে ৰায়তী আইন 1971 ৰ 23A নং ধাৰা মতে মালিকীস্বত্ব পাবৰ যোগ্য বুলি বিবেচনা কৰিব পৰা নাযায়।");
        $('#lm_remark_text').append("\n \n THE ASSAM (TEMPORARILY SETTLED AREAS) TENANCY (AMENDED) ACR, 2024");
        <?php endif ;?>
    }else{
        $('#lm_remark_text').text('');
        $('#lm_remark_text_id').hide();

    }
    });

    // LM remark template end
</script>


<script>
    const classExists = document.getElementsByClassName(
        'is-invalid'
    ).length > 0;

    const classExistsLm = document.getElementsByClassName(
        'lm_invalid'
    ).length > 0;

    if(classExists){
        $('html, body').animate({
            scrollTop: ($('.is-invalid').offset().top - 300),
        }, 200);
    }else if(classExistsLm)
    {
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
        $('html, body').animate({
            scrollTop: ($('.lm_invalid').offset().top - 300),
        }, 200);
    };

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
</script>

<script>
   function showSuccessMessage(text) {
       swal.fire({
           title: "Success !",
           text: text,
           icon: 'success',
           position: 'top',
           showConfirmButton: true,
           timer: 5000,
       });
   
   }
   
   function showErrorMessage(text) {
       swal.fire({
           title: "Error!",
           text: text,
           icon: 'error',
           position: 'top',
           timer: 5000,
           showCancelButton: true
   
       });
   }


   $('#btnLmSubmit').on('click',function(e){
        e.preventDefault();
        var form = $('.lmForm');
        

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you confirm?',
            html: 'Land Occupied : '+$( "#is_landless option:selected" ).text(),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({

                title: 'Do you want to submit the report?',
                html: 'Land Occupied : '+$( "#is_landless option:selected" ).text(),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true

            }).then((result2) => {

                if (result2.isConfirmed) {
                // form.submit()
                swalWithBootstrapButtons.fire({

                    title: 'Do you really want to submit the report?',
                    html: 'Land Occupied : '+$( "#is_landless option:selected" ).text(),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true

                }).then((result3) => {

                    if (result3.isConfirmed) {
                    form.submit()
                }else{
                    result3.dismiss === Swal.DismissReason.cancel
                    $('#btnLmSubmit').prop('disabled', false);
                    $('#btnLmSubmit').val('Save and submit');
                }
            })

            }else{
                result2.dismiss === Swal.DismissReason.cancel
                $('#btnLmSubmit').prop('disabled', false);
                $('#btnLmSubmit').val('Save and submit');
            }

        })
        } else if (
            /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
            $('#btnLmSubmit').prop('disabled', false);
            $('#btnLmSubmit').val('Save and submit');
            swalWithBootstrapButtons.fire(
                'Cancelled !!',
                // 'Your imaginary file is safe :)',
                // 'error'
            )
        }
    })
    });
</script>

<script>

    $(document).ready(function()
    {
        var selection = $('#lm_remark').val();
        if(selection == 2)
        {
            $('#sk_for_reject').hide();
            $('#co_for_reject').show();
        }
        else
        {
            $('#sk_for_reject').show();
        }

    })


    $(document).on('change', '#lm_remark', function(){
        
        var selection = $(this).val();
        
        if(selection == 2)
        {
            $('#sk_for_reject').hide();
            $('#co_for_reject').show();
        }
        else
        {
            $('#sk_for_reject').show();
            $('#co_for_reject').hide();
        }

    })
</script>

<script>

    $(document).ready(function(){
        var nature_pos_val = $('#nature_possession').val();
        if(nature_pos_val == 'Others'){
            $('#nature_possession_div_other').show();
        }else{
            $('#nature_possession_div_other').hide();
        }
        
        var is_tribal_belt = $('[name="is_tribal_belt"]:checked').val();

        if(is_tribal_belt == 'YES'){
            $('#tribal_belt_input_id').show();
            $('#protected_class_id').show();
            $('#contravention').hide();
        }else if (is_tribal_belt == 'NO'){
            $('#tribal_belt_input_id').hide();
            $('#protected_class_id').hide();
            $('#contravention').show();
        }

    });

    function naturePossessionOther(elm){
        if(elm.value == 'Others'){
            $('#nature_possession_div_other').show();
        }else{
            $('#nature_possession_div_other').hide();
        }
    }

    function handleTribalClick(elmt){
        if (elmt.value === "YES") {
            $('#tribal_belt_input_id').show();
            $('#protected_class_id').show();
            $('#contravention').hide();
        } else if (elmt.value === "NO") {
            $('#tribal_belt_input_id').hide();
            $('#protected_class_id').hide();
            $('#contravention').show();
        }
    }


</script>
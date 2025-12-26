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
                  <strong>CO Report</strong>
                  </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <form role="form" class="lmForm" method="post" action="<?php echo base_url()?>index.php/SettlementTenantCoUrban/initRegistration?app=<?=$_GET['app']?>" enctype="multipart/form-data">

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
                  <input type="hidden" name="dist_code" value="<?=$this->session->userdata('dist_code')?>">

                  <?php $sl_count = 1; ?>

                  <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                      <h5 class="bgheading p-2 text-white shadow " style="margin-top: 10px">
                          Settlement of  Occupancy Tenant (
                        <span class="bg-warning"><?=$basic['case_no']?></span> )
                      </h5>
                      <?php include(APPPATH."views/SettlementView/include/applicationTenantViewUrbanLanding.php"); ?>
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
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> CO Report
                              </h5>
                              <div class="tableCard pb-5">

                                <div class="row p-2" >
                                  <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> Enter Remark</span>
                                    <?=form_error('co_remark')?>
                                  </div>
                                  <div class="col-6">
                                    <textarea class="col-12 p-2 <?php if(form_error('co_remark')){echo 'lm_invalid';}?>" rows="5" name="co_remark" id="co_remark" placeholder="Please enter remark..."></textarea>
                                  </div>
                                </div>

                                <div class="row p-2" >
                                  <div class="col-md-6">
                                    <span><strong><?=$sl_count++?>.</strong> Action</span>
                                    <?=form_error('chitha_verified')?>
                                  </div>
                                  <div class="col-6">

                                        <?php
                                        if($basic['status'] == 'ZC'){
                                            if(ENABLE_BUTTON_CO_ACTION_TENANT_URBAN != 0)
                                            {                                     
                                        ?>
                                            
                                            <button type="button" onclick="showNewDirectRejectModalMb3('<?=$basic['case_no']?>','<?=SETTLEMENT_TENANT_URBAN_ID ?>')" class="btn btn-danger">Reject this case</button>
                                            <br>
                                            <small style="background:#FFFF00;"> Reject Reasons will appear once reject button is clicked!</small>

                                        <?php 
                                            }
                                        }
                                        else if($basic['status'] == 'D'){
                                            echo '<span class="text-danger"> Case has been rejected! </span>';
                                        }else{
                                            echo '<span class="text-success"> Case forwared from CO! </span>';
                                        }?>

                                  </div>
                                </div>

                              </div>
                            </div>


                            <!-- LM note ends here -->
                            <ul class="list-inline pull-right" style="margin-top: 20px">
                              <li>
                                <button type="button" class="btn btn-default prev-step">
                                  <i class="fa fa-arrow-circle-left"> </i>  <?php echo $this->lang->line('previous'); ?>
                                </button>
                              </li>
                              <?php if(ENABLE_BUTTON_CO_SUBMIT_TENANT_LANDING != 0){
                                  if($basic['status'] == 'ZC'){                                        
                                    ?>
                                    <li>
                                    <input type="submit" class="btn btn-primary next-step" id="btnLmSubmit" value="Submit and forward to LM" onClick="this.disabled=true; this.value='Saving...';">
                                    </li>
                                <?php }
                            
                            } ?>
                            </ul>

                        </div>

                  </div>

                </form>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>

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
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit()
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                $('#btnLmSubmit').prop('disabled', false);
                $('#btnLmSubmit').val('Save and submit');
                swalWithBootstrapButtons.fire(
                    'Cancelled !!',
                )
            }
        })
    });
</script>

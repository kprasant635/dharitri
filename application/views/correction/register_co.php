<style type="text/css">
  tr td{
    font-size: 1.2em;
  }
  .collapsing {
    -webkit-transition: none;
    transition: none;
    display: none;
  }
  .bg-first{
    background: rgb(35,60,60) !important;
    background: linear-gradient(39deg, rgb(114 171 71) 8%, rgb(26 151 211 / 81%) 62%) !important;
  }
  .bg-second{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgba(231,31,95,0.8071603641456583) 75%)!important;
  }
  .bg-third{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgba(25,143,25,0.8071603641456583) 75%)!important;
  }
  .custom-accordion .accordion-item {
  background-color: #f9f9f9;
  margin-bottom: 10px;
  position: relative;
  border-radius: 40px;
  overflow: hidden; }
  .custom-accordion .accordion-item .btn-link {
    display: block;
    width: 100%;
    padding: 15px;
    text-decoration: none;
    text-align: left;
    color: #fff;
    font-size: .6em;
    border: none;
    padding-left: 40px;
    border-radius: 0;
    position: relative;
    background: #fff;
    }
    .custom-accordion .accordion-item .btn-link:before {
      font-family: 'icomoon';
      content: "\25bc";
      position: absolute;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      left: 15px;
      }
    .custom-accordion .accordion-item .btn-link[aria-expanded="true"]:before {
      font-family: 'icomoon';
      content: "\25b2";
      position: absolute;
      color: red;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      left: 15px; }
  .custom-accordion .accordion-item.active {
    z-index: 2; }
    .custom-accordion .accordion-item.active .btn-link {
      color: #72c02c; }
  .custom-accordion .accordion-item .accordion-body {
    padding: 20px 20px 20px 20px;
    color: #888; }
</style>
<h2 class="my-2 text-center">Legacy Data Correction</h2>
<div class="container">

<table class="table table-bordered">
  <tr class="bg-primary">
    <td colspan="3"><center>Location</center></td>
  </tr>
  <tr class="bg-success">
    <td colspan="3">
      <center>
        RTPS Case No. <kbd><?=$app->case_no;?></kbd> Submitted on Dated <kbd><?=$app->date_of_reg?></kbd>
      </center>
    </td>
  </tr>
  <tr>
    <td>District : <?=$this->utilityclass->getDistrictName($app->dist_code)?></td>
    <td>Subdivsion : <?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?></td>
    <td>Circle : <?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?></td>
  </tr>
  <tr>
    <td>Mouza : <?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_pargona_code)?></td>
    <td>Lot Name: <?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_pargona_code,$app->lot_no)?></td>
    <td>Village Name: <?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_pargona_code,$app->lot_no,$app->vill_townprt_code)?></td>
  </tr>
</table>
<form class="form-horizontal" action="<?php echo base_url() . "index.php/LegacyCorrection/COFinalOrderPassArea"; ?>"  enctype="multipart/form-data" method="POST">    
                 <?php if(!empty($application->basundhara)){ ?>   
                 <input type="hidden" class="form-control" name='application_no' value="<?php echo $application->basundhara;?>">   
                 <?php }?>
            <input type="hidden" name="case_no" value="<?php echo $app->case_no; ?>"/>
            <input type="hidden" name="petition_no" value="<?php echo $app->petition_no; ?>"/>
        
                    <?php include(APPPATH."views/correction/aadhaarInfo.php"); ?>
   
        
          
<div class="custom-accordion" id="accordion_1">
  <?php if ($app->service_type=='A'){ ?>
  <div class="accordion-item">
      <h2 class="mb-0"><button class="btn btn-link bg-first" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Applied for Legacy Area Correction</button></h2>
          <div id="collapseOne" class="collapse <?=$app->service_type=='A'?'show':'hide';?>" aria-labelledby="headingOne" data-parent="#accordion_1">
              <div class="accordion-body">
                  <div class="col-lg-9">
                    <h4>Old Dag Information</h4>
                    <table class="table">
                      <tr>
                        <td>Dag No:<?= $app->dag_no?> </td>
                        <td>Old Area: <?= $dagDetails->dag_area_b .' Bigha&nbsp;&nbsp;'.$dagDetails->dag_area_k .' Katha&nbsp;&nbsp;'.$dagDetails->dag_area_lc .' Lessa' ?> </td>
                      </tr>
                    </table>
                    <h4>Applicant Information</h4>
                    <table class="table table-stripped">
                      <tr>
                        <td>Name:<?= $app->appl_name?> </td>
                        <td>Gurdian Name:<?= $app->appl_gurdian_name?> </td>
                        <!-- <td>Relation: //$this->utilityclass->getrelationByID($app->gurdian_relation_id) </td> -->
                      </tr>
                      <tr>
                        <td>Address:<?= $app->address?> </td>
                        <td colspan="2">Applied Area:  <?= $app->dag_area_b .' Bigha&nbsp;&nbsp;'.$app->dag_area_k .' Katha&nbsp;&nbsp;'.$app->dag_area_lc .' Lessa' ?> </td>
                      </tr>
                    </table>
                  </div>
                  
                  
              </div>
          </div>
  </div> 
<?php }?>
<?php if ($app->service_type=='N'){ ?>
<div class="accordion-item">
    <h2 class="mb-0">
      <button class="btn btn-link collapsed bg-second" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Applied for Legacy Name Coorection</button>
        </h2>
      <div id="collapseTwo" class="collapse <?=$app->service_type=='N'?'show':'hide';?>" aria-labelledby="headingTwo" data-parent="#accordion_1">
        <div class="accordion-body">
            <div class="col-lg-9">  
            <h4>Old Pattadar Information</h4>

                <table class="table table-stripped">
                    <tr>
                      <td>Name: <?=$app->appl_name?> </td>
                      <td>Gurdian Name:<?=$app->appl_gurdian_name?> </td>
                      <td>Relation: <?=$this->utilityclass->getrelationByID($app->relation) ?></td>
                    </tr>
                 
                    <tr>
                      <td>Patta No:<?= $app->patta_no?> </td>
                      <td colspan="2">Patta Type Code:<?= $this->utilityclass->getPattaName($app->patta_type_code)?> </td>
                    </tr>
                  </table>


                <h4>Applicant Information</h4>
                  <table class="table table-stripped">
                    <tr>
                      <td>Name: <?=$app->pdar_name?> </td>
                      <td>Gurdian Name:<?=$app->gurdian_name;?> </td>
                      <td>Relation: <?=$this->utilityclass->getrelationByID($app->relation) ?></td>
                    </tr>
                    <tr>
                      <td>Name in English:<?= $app->eng_name;?> </td>
                      <td>Gurdian Name in English:<?= $app->guard_eng_name;?> </td>
                      <td>Mobile:<?= $app->mobile?> </td>
                    </tr>
                    <tr>
                      <td>Patta No:<?= $app->patta_no?> </td>
                      <td colspan="2">Patta Type Code:<?= $this->utilityclass->getPattaName($app->patta_type_code)?> </td>
                    </tr>
                  </table>
                </div>
                  
              
        </div>
      </div>
    </div> 
    <?php }?>
    <?php if ($app->service_type=='M'){ ?>
<div class="accordion-item">
      <h2 class="mb-0">
      <button class="btn btn-link collapsed bg-third" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Applied for Mobile No. Updation</button>
      </h2>
        <div id="collapseThree" class="collapse <?=$app->service_type=='M'?'show':'hide';?>" aria-labelledby="headingThree" data-parent="#accordion_1">
          <div class="accordion-body">
            
            <h4>Applicant Information</h4>
            <table class="table table-stripped">
              <tr>
                <td>Name:<?= $app->appl_name?> </td>
                <td>Gurdian Name:<?= $app->appl_gurdian_name?> </td>
                <td>Relation:<?= $this->utilityclass->getrelationByID($app->relation)?> </td>
              </tr>
              <tr>
                <td>Address:<?= $app->address?> </td>
                <td colspan="2">Update Mobile No: <?= $app->new_mobile; ?> </td>
              </tr>
              <tr>
                <td>Patta No:<?= $app->patta_no?> </td>
                <td colspan="2">Patta Type Code:<?= $this->utilityclass->getPattaName($app->patta_type_code)?> </td>
              </tr>
            </table>
            
        </div>
      </div>
    </div> 
    <?php }?>
    <textarea class="form-control" rows="3" name="co_final_report" placeholder=" Enter Your Remark(s) here" required></textarea>
    <blockquote class="quote-info pt-2 mt-2">
      <h5>Document(s) Attached</h5>
    </blockquote>
     <ul class="list-group" style='margin-bottom: 10px'>
        <?php foreach($basundharaAttachment as $d): ?>
         <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
        <?php endforeach; ?>
      </ul>

      <div class="form-group" style="margin-bottom: 30px;">
      <div class="panel panel-info">
          <div class="">
        
            <div class="col-lg-8 col-lg-offset-4">
                <button type="submit" name="FormSubmit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                </a>

                <a class="btn btn-info lmreport"  href="<?php echo base_url() . "index.php/LegacyCorrection/lmReport?case_no=" . $app->case_no . "&dist_code=" . $app->dist_code . "&subdiv_code=" . $app->subdiv_code . "&cir_code=" . $app->cir_code . "&mouza_pargona_code=" . $app->mouza_pargona_code . "&lot_no=" . $app->lot_no . "&vill_townprt_code=" . $app->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View LM Report</a>
            </div>
          </div>
        </div>
      </div>
    </div>
     </form>
    </div>

    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  id='lmreportModal'>
      <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
         <div class="modal-content"  style=" overflow-y: auto;">
         </div>
      </div>
    </div>
    <script type="text/javascript">
          $('.panel').on('click','.lmreport',function (e) {
               e.preventDefault();
               $.ajax({
                   url:$(this).attr('href'),
                   success:function(data){
                       $('#lmreportModal .modal-content').html(data);
                       $('#lmreportModal').modal('show');
                   }
               });
               
           });
    </script>
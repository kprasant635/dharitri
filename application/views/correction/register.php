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
    background: linear-gradient(39deg, rgba(35,60,60,1) 8%, rgba(31,166,231,0.8071603641456583) 62%) !important;
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
      content: "\f067";
      position: absolute;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      left: 15px;
      }
    .custom-accordion .accordion-item .btn-link[aria-expanded="true"]:before {
      font-family: 'icomoon';
      content: "\f068";
      position: absolute;
      color: #72c02c;
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
<h2 class="my-5 text-center">Legacy Data Correction</h2>
<div class="container">

<table class="table table-bordered">
  <tr class="bg-primary">
    <td colspan="3"><center>Location</center></td>
  </tr>
  <tr class="bg-success">
    <td colspan="3">
      <center>
        RTPS Case No. <kbd><?=$app->application_no;?></kbd> Submitted on Dated <kbd><?=$app->date_submission?></kbd>
      </center>
    </td>
  </tr>
  <tr>
    <td>District : <?=$this->utilityclass->getDistrictName($app->dist_code)?></td>
    <td>Subdivsion : <?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?></td>
    <td>Circle : <?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?></td>
  </tr>
  <tr>
    <td>Mouza : <?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?></td>
    <td>Lot Name: <?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no)?></td>
    <td>Village Name: <?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?></td>
  </tr>
</table>

<div class="custom-accordion" id="accordion_1">
<div class="accordion-item">
<h2 class="mb-0">
<button class="btn btn-link bg-first" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Applied for Legacy Area Correction</button>
</h2>
<div id="collapseOne" class="collapsing collapse <?=$app->legacy=='A'?'show':'hide';?>" aria-labelledby="headingOne" data-parent="#accordion_1">
<div class="accordion-body">
  <?php if ($app->legacy=='A'){ ?>
<h4>Old Dag Information</h4>
<table class="table">
  <tr>
    <td>Dag No:<?= $app->dag_no?> </td>
    <td>Old Area: <?= $app->area_b .' Bigha&nbsp;&nbsp;'.$app->area_k .' Katha&nbsp;&nbsp;'.$app->area_l .' Lessa' ?> </td>
  </tr>
</table>
<h4>Applicant Information</h4>
<table class="table table-stripped">
  <tr>
    <td>Name:<?= $applicant[0]->name_ass?> </td>
    <td>Gurdian Name:<?= $applicant[0]->gurdian_name_ass?> </td>
    <td>Relation:<?= $this->utilityclass->getrelationByID($applicant[0]->gurdian_relation_id)?> </td>
  </tr>
  <tr>
    <td>Address:<?= $applicant[0]->address?> </td>
    <td colspan="2">Applied Area: <?= $applicant[0]->new_area_b .' Bigha&nbsp;&nbsp;'.$applicant[0]->new_area_k .' Katha&nbsp;&nbsp;'.$applicant[0]->new_area_l .' Lessa' ?> </td>
  </tr>
</table>
<?php }else{
  echo "No Data Available";
}?>
</div>
</div>
</div> 
<div class="accordion-item">
<h2 class="mb-0">
<button class="btn btn-link collapsed bg-second" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Applied for Legacy Name Coorection</button>
</h2>
<div id="collapseTwo" class="collapse <?=$app->legacy=='N'?'show':'hide';?>" aria-labelledby="headingTwo" data-parent="#accordion_1">
<div class="accordion-body">
<?php if($app->legacy=='N'){ ?>
<h4>Applicant Information</h4>
<table class="table table-stripped">
  <tr>
    <td>Name:<?= $applicantInfo[0]->name_ass?> </td>
    <td>Gurdian Name:<?= $applicantInfo[0]->gurdian_name_ass?> </td>
    <td>Relation:<?= $this->utilityclass->getrelationByID($applicant[0]->gurdian_relation_id)?> </td>
  </tr>
  <tr>
    <td>Name in English:<?= $applicantInfo[0]->pat_name_eng?> </td>
    <td>Gurdian Name in English:<?= $applicantInfo[0]->pat_gurdian_name_eng?> </td>
    <td>Mobile:<?= $applicantInfo[0]->mobile?> </td>
  </tr>
  <tr>
    <td>Patta No:<?= $app->patta_no?> </td>
    <td colspan="2">Patta Type Code:<?= $this->utilityclass->getPattaName($app->patta_type)?> </td>
  </tr>
</table>
<?php }else{
  echo "No Data Available";
}?>
</div>
</div>
</div> 
<div class="accordion-item">
<h2 class="mb-0">
<button class="btn btn-link collapsed bg-third" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Applied for Mobile No. Updation</button>
</h2>
<div id="collapseThree" class="collapse <?=$app->legacy=='M'?'show':'hide';?>" aria-labelledby="headingThree" data-parent="#accordion_1">
<div class="accordion-body">
<?php if($app->legacy=='M'){ ?>
<h4>Applicant Information</h4>
<table class="table table-stripped">
  <tr>
    <td>Name:<?= $applicant[0]->name_ass?> </td>
    <td>Gurdian Name:<?= $applicant[0]->gurdian_name_ass?> </td>
    <td>Relation:<?= $this->utilityclass->getrelationByID($applicant[0]->gurdian_relation_id)?> </td>
  </tr>
  <tr>
    <td>Address:<?= $applicant[0]->address?> </td>
    <td colspan="2">Update Mobile No: <?= $applicant[0]->new_mobile; ?> </td>
  </tr>
  <tr>
    <td>Patta No:<?= $app->patta_no?> </td>
    <td colspan="2">Patta Type Code:<?= $this->utilityclass->getPattaName($app->patta_type)?> </td>
  </tr>
</table>
<?php }else{
  echo "No Data Available";
}?>
</div>
</div>

</div> 
<textarea class="form-control" rows="3" placeholder=" Enter Your Remark(s) here"></textarea>
<blockquote class="quote-info pt-2 mt-2">
  <h5>Document(s) Attached</h5>
</blockquote>
 <ul class="list-group" style='margin-bottom: 10px'>
    <?php foreach($document as $d): ?>
     <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
    <?php endforeach; ?>
  </ul>
</div>
</div>
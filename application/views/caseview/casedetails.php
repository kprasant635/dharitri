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

  .bg-five{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgb(143 124 25 / 91%) 75%)!important;

  }

  .bg-four{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgb(59 209 218 / 83%) 75%)!important;
  }


 .bg-six{
    /*background: rgb(35,60,60)!important;*/
    background: linear-gradient(39deg, rgb(35 60 60 / 49%) 9%, rgb(113 25 73 / 88%) 75%)!important;
  }


  .bg-seven{
    /*background: rgb(35,60,60)!important;*/
    background: linear-gradient(39deg, rgb(35 55 60 / 75%) 9%, #007bff82 75%)!important;
  }
   /*.table tr:nth-child(odd){
    background: transparent;
    color: white;
  
  }

  .table tr:nth-child(even){
    background: transparent;
    color: white;
  }*/

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
    <style>
        .mycard{width: 100%;background: white;padding: 0px 0px;text-align: center;  
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 30px 0px;
        color: black;
        }
        .mycard: hover{box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);};
    </style>
<h2 class="my-2 text-center">
  <?php $case=explode('/',$app['basic']->case_no); 
  if($case[4]==='FMUT'){
    echo "Field Mutation";
  }
if($case[4]==='FPART'){
  echo "Field Partition";
}
else if($case[4]==='OMUT'){
  echo "Office Mutation";
}
else if($case[4]==='OPART'){
  echo "Office Partition";
}
else if($case[4]==='RECLASS'){
  echo "Reclassification";
}

else if($case[4]==='LDU'){
  echo "Area Correction";
}
else if($case[4]==='ACPP'){
  echo "Land Allotment";
}
  else 
  {
   
  }
  
// echo $case[4]==='FMUT' ?  "Field Mutation" :  "Office Mutation" ;
 ?>
</h2>
<div class="container">
  

  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="mycard">
              <div class="card-header bg-first">
              <strong>Case Details</strong>
            </div>
              <table class="table table-bordered">

                <tr>
                 <td>RTPS No</td>
                 <td>Dharitree Case No</td>
                 <td>Application Date</td>
                 <td>Status</td>
                 <td>Pending with Officer</td>
                </tr>
                <tr>
                 <td><?php echo $app['basic']->basundhara?$app['basic']->basundhara:$app['basic']->application_ref_no ?></td>
                 <td><?=$app['basic']->case_no?></td>
                 <td><?=$app['basic']->date_entry;?></td>
                 <td><?=$app['status'];?></td>
                 <td><?=$app['pending_with_user'];?></td>
                </tr>
            </table>
            </div>
            <div class="mycard">
              <div class="card-header bg-second">
              <strong>Location Details</strong>
            </div>

              <table class="table table-bordered">

                <tr>
                 <td>District</td>
                 <td>Subdivision</td>
                 <td>Circle</td>
                 <td>Mouza</td>
                 <td>Lot</td>
                 <td>Village</td>
                </tr>
                <tr>
                 <td><?=$this->utilityclass->getDistrictName($app['basic']->dist_code)?></td>
                 <td> <?=$this->utilityclass->getSubDivName($app['basic']->dist_code,$app['basic']->subdiv_code)?></td>
                 <td><?=$this->utilityclass->getCircleName($app['basic']->dist_code,$app['basic']->subdiv_code,$app['basic']->cir_code)?></td>
                 <td><?=$this->utilityclass->getMouzaName($app['basic']->dist_code,$app['basic']->subdiv_code,$app['basic']->cir_code,$app['basic']->mouza_pargona_code)?></td>
                 <td><?=$this->utilityclass->getLotName($app['basic']->dist_code,$app['basic']->subdiv_code,$app['basic']->cir_code,$app['basic']->mouza_pargona_code,$app['basic']->lot_no)?></td>
                 <td><?=$this->utilityclass->getVillageName($app['basic']->dist_code,$app['basic']->subdiv_code,$app['basic']->cir_code,$app['basic']->mouza_pargona_code,$app['basic']->lot_no,$app['basic']->vill_townprt_code)?></td>
                </tr>

              </table>
            </div>
            <?php if ($case[4]=='RECLASS'){?>
            <div class="mycard">
              <div class="card-header bg-third">
              <strong>Dag wise area details</strong>
            </div>

            <table class="table table-bordered">

                <tr>
                 <td>Dag No</td>
                 <td>Patta No</td>
                 <td>Patta Type</td>
                 <td>Chitha area</td>
                 <td>Land Class</td>
                 <td>Proposed Land Class</td>
                </tr>
                <tr>
                 <td><?= $app['basic']->dag_no ?></td>
                 <td> <?= $app['basic']->patta_no ?></td>
                 <td><?=$this->utilityclass->getPattaType($app['basic']->patta_type_code)?></td>
                 <td><?= $app['basic']->dag_area_b.'B-'.$app['basic']->dag_area_k.'K-'.$app['basic']->dag_area_lc.'L' ?></td>
                 <td><?=$this->utilityclass->getLandClassCode($app['basic']->present_land_class);?></td>
                 <td><?=$this->utilityclass->getLandClassCode($app['basic']->proposed_land_class);?></td>
                </tr>

              </table>
            </div>
            <?php }

            else if ($case[4]=='MiNC' or $case[4]=='MiND'){?>
            <div class="mycard">
              <div class="card-header bg-third">
              <strong>Dag wise area details</strong>
            </div>
             <table class="table table-bordered">
              <tr>
                <td>Dag No</td>
                <td>Patta No</td>
                <td>Patta Type</td>
              </tr>
              <tr>
                <td><?= $app['basic']->dag_no ?></td>
                <td><?= $app['basic']->patta_no ?></td>
                <td><?=$this->utilityclass->getPattaType($app['basic']->patta_type_code)?></td>
              </tr>
             </table>
    
            </div>
            <?php }

           else if ($case[4]=='LDU'){?>
            <div class="mycard">
              <div class="card-header bg-third">
              <strong>Dag wise area details</strong>
            </div>

            <table class="table table-bordered">

                <tr>
                 <td>Dag No</td>
                 <td>Patta No</td>
                 <td>Patta Type</td>
                 <td>Chitha area</td>
                 <td>Applied Land Area</td>
                </tr>
                <tr>
                 <td><?= $app['basic']->dag_no ?></td>
                 <td> <?= $app['basic']->patta_no ?></td>
                 <td><?=$this->utilityclass->getPattaType($app['basic']->patta_type_code)?></td>
                 <?php if(in_array($app['basic']->dist_code, json_decode(BARAK_VALLEY))){?>
                 <td><?= $app['basic']->dag_area_b.'B-'.$app['basic']->dag_area_k.'K-'.$app['basic']->dag_area_lc.'C'.$app['basic']->dag_area_g.'G' ?></td>
                 <?php } 
                 else{?>
                  <td><?= $app['basic']->dag_area_b.'B-'.$app['basic']->dag_area_k.'K-'.$app['basic']->dag_area_lc.'L' ?></td>
                 <?php }?>
                 
                 <td><?= $app['basic']->suggested_dag_area_b.'B-'.$app['basic']->suggested_dag_area_k.'K-'.$app['basic']->suggested_dag_area_lc.'L' ?></td>
                </tr>

              </table>
            </div>
            <?php }

            else if ($case[4]=='ACPP'){?>
            <div class="mycard">
            <div class="card-header bg-third">
              <strong>Dag wise area details</strong>
            </div>

              <table class="table table-bordered">

                <tr>
                 <td>Dag No</td>
                 <td>Patta No</td>
                 <td>Patta Type</td>
                 <td>Chitha area</td>
                 <td>Applied Area</td>
                </tr>
                <tr>
                 <td><?= $app['dag']->dag_no ?></td>
                 <td> <?= $app['dag']->patta_no ?></td>
                 <td><?=$this->utilityclass->getPattaType($app['dag']->patta_type_code)?></td>
                 <td><?= $app['dag']->tot_area_b.'B-'.$app['dag']->tot_area_k.'K-'.$app['dag']->tot_area_lc.'L' ?></td>
                 <td><?= $app['dag']->alot_area_b.'B-'.$app['dag']->alot_area_k.'K-'.$app['dag']->alot_area_lc.'L' ?></td>
                
                </tr>

              </table>
            </div>
          <?php }

            else{?>
            <div class="mycard">
            <div class="card-header bg-third">
              <strong>Dag wise area details</strong>
            </div>

              <table class="table table-bordered">

                <tr>
                 <td>Dag No</td>
                 <td>Patta No</td>
                 <td>Patta Type</td>
                 <td>Chitha area</td>
                 <td>Applied Area</td>
                </tr>
                <tr>
                 <td><?= $app['dag']->dag_no ?></td>
                 <td> <?= $app['dag']->patta_no ?></td>
                 <td><?=$this->utilityclass->getPattaType($app['dag']->patta_type_code)?></td>
                 <td><?= $app['dag']->dag_area_b.'B-'.$app['dag']->dag_area_k.'K-'.$app['dag']->dag_area_lc.'L' ?></td>
                 <td><?= $app['dag']->m_dag_area_b.'B-'.$app['dag']->m_dag_area_k.'K-'.$app['dag']->m_dag_area_lc.'L' ?></td>
                
                </tr>

              </table>
            </div>
          <?php }?>
            <div class="mycard">
              <div class="card-header bg-four">
              <strong>PATTADAR DETAILS</strong></div>

              <table class="table table-bordered">

                <tr>
                 <td>Name</td>
                 <td>Father's Name</td>
                </tr>
                <?php  foreach($app['pattadar'] as $pat):?>
                <tr>
                  <td><?=$pat->pattadarname?></td>
                  <td><?=$pat->pdarguardian?></td>
                </tr>
               <?php endforeach?>
              </table>
            </div>


            <div class="mycard">
              <div class="card-header bg-five">
              <strong>AADHAAR/PAN/DECLARATION  DETAILS</strong>
             </div>
              
                <table class="table table-bordered">
                <?php if($self){
                  echo "<tr>";
                  echo "<td>";
                foreach ($self as $k=>$r) :?>
                  <?php for($i=0;$i<count($r);$i++){
                      echo "<ol style='text-align:left'>".$r[$i]->id.")".$r[$i]->name."</ol>";
                  }
               endforeach; } ?>
               </td>
               <td>
                 <?=$aadhaar_photo;?><br>
                <?=$auth_type == 'AADHAAR' ? "<b class='btn-success'><i class='fa fa-check'></i> Aadhaar Verified</b>" :
                ($auth_type == 'PAN' ? "<b style='color:#ff681d'><i class='fa fa-check'></i> PAN Verified</b>" : "N/A");?>
               </td>
             </tr>
            </table>
          </div>
            <?php if ($case[4]=='RECLASS'){?>
            <div class="mycard">
              <div class="card-header bg-seven">
              <strong>Applicant  DETAILS</strong>
            </div>

             <table class="table table-bordered">
              <tr>
                <td>Name</td>
                <td>Father's Name</td>
              </tr>
              <tr>
                <td><?=$basundharaApp->applicants[0]->name_ass ;?></td>
                <td><?=$basundharaApp->applicants[0]->gurdian_name_ass ;?></td>
              </tr>
             </table>
            </div>
            <?php }

           else if ($case[4]=='LDU'){?>
            <div class="mycard">
              <div class="card-header bg-seven">
              <strong>Applicant  DETAILS</strong>
            </div>

             <table class="table table-bordered">
              <tr>
                <td>Name</td>
                <td>Father's Name</td>
              </tr>
              <tr>
                <td><?=$basundharaApp->mutation[0]->name_ass ;?></td>
                <td><?=$basundharaApp->mutation[0]->gurdian_name_ass ;?></td>
              </tr>
             </table>
            </div>
            <?php }

          else if ($case[4]=='MiNC'){?>
            <div class="mycard">
               <div class="card-header bg-seven">
              <strong>Applicant  DETAILS</strong>
            </div>

              <table class="table table-bordered">
              <tr>
                <td>Name</td>
                <td>Corrected Name</td>
              </tr>
              <tr>
                <td><?=$app['petitioner'][0]->pet_name ;?></td>
                <td><?=$app['petitioner'][0]->applied_name ;?></td>
              </tr>
             </table>
            </div>
            <?php }

             else if ($case[4]=='MiND'){?>
            <div class="mycard">
              <div class="mycard">
               <div class="card-header bg-seven">
              <strong>Applicant  DETAILS</strong>
            </div>

            <table class="table table-bordered">
              <tr>
                <td>Name</td>
                <td>Second Party Name</td>
                <td>Father's Name</td>
              </tr>
              <tr>
                <td><?=$app['petitioner'][0]->pet_name ;?></td>
                
                 <td> 
                  <?php foreach($secondparty as $sp):?>
                    <?=$sp->pdar_name?>
                    <br>
                  <?php endforeach?>
                </td>
                <td> 
                  <?php foreach($secondparty as $sp):?>
                    <?=$sp->pdar_father?>
                    <br>
                  <?php endforeach?>
                </td>
             
            </td>

              </tr>
             </table>
            </div>
          </div>
            <?php }

            else if($case[4]=='ACPP'){?>
              <div class="mycard">
              <div class="card-header bg-seven">
              <strong>Applicant  DETAILS</strong></div>

              <table class="table table-bordered">
                <tr>
                  <td>Name</td>
                  <td>Father's Name</td>
                  <td>Address</td>
                </tr>
                
                  <?php foreach($app['petitioner'] as $pet):?>
                    <tr>
                  <td><?=$pet->appl_name?></td>
                  <td><?=$pet->applguardian?></td>
                  <td></td>
                  </tr>
                <?php endforeach ?>
                
             </table>
            </div>
            <?php }

            else{?>
              <div class="mycard">
              <div class="card-header bg-seven">
              <strong>Applicant  DETAILS</strong></div>

              <table class="table table-bordered">
                <tr>
                  <td>Name</td>
                  <td>Father's Name</td>
                  <td>Address</td>
                </tr>
                
                  <?php foreach($app['petitioner'] as $pet):?>
                    <tr>
                  <td><?=$pet->appl_name?></td>
                  <td><?=$pet->applguardian?></td>
                  <td><?=$pet->add?></td>
                  </tr>
                <?php endforeach ?>
                
             </table>
            </div>
            <?php }?>
           <?php $case=explode('/',$app['basic']->case_no);
           if($case[4]=='FMUT' or $case[4]=='FPART'){?>

            <div class="mycard">
              <div class="card-header bg-six">
              <strong>Proceeding  DETAILS</strong></div>

              <table class="table table-bordered">
              <tr>
                <td>Remark</td>
                <td>Name</td>
                <td>Date</td>
              </tr>
              
               <?php foreach($app['remark'] as $remark): ?>
                <tr>
                <td><?= $remark->remark ?></td>
                <?php $code = $remark->user_code;
                $lms = $this->utilityclass->getDefinedMondalsName($app['basic']->dist_code,
                $app['basic']->subdiv_code, $app['basic']->cir_code,$app['basic']->mouza_pargona_code, $app['basic']->lot_no, $code);?>
                <td><?=$lms->lm_name?></td>
                <td><?=$remark->date_entry?></td>
                </tr>
              <?php endforeach; ?>
              
             </table>



              
            </div>
          <?php }

          else if ($case[4]=='LDU'){?>

            <div class="mycard">
              <div class="card-header bg-six">
              <strong>Proceeding  Details</strong></div>
            
                <table class="table table-bordered">
                
                   <th>Note</th>
                   <th>Date</th>
                 <tr>
                 <td>Lm Note:
                <?= $app['basic']->lm_note ?> &nbsp;
                </td> 
                <td>
                <?= $app['basic']->date_entry ?> &nbsp;
                </td> 

              </tr>
              <?php if(!empty($app['basic']->co_note)){?>
              <tr>
                <td>CO Note:
                <?= $app['basic']->co_note ?> &nbsp;
                </td> 
                <td>
                <?= $app['basic']->co_orddate ?> &nbsp;
                </td>
              
                </tr>
              <?php }
               if(!empty($app['basic']->dc_adc_note)){?>
              <tr>
                <td>DC/ADC Note:
                <?= $app['basic']->dc_adc_note ?> &nbsp;
                </td> 
                <td>
                <?= $app['basic']->dc_adc_orddate ?> &nbsp;
                </td>
              
                </tr>
              <?php }?>
               </table>
               
  
          
            </div>
          <?php }

          else if($case[4]=='ACPP'){?>

            <div class="mycard">
              <div class="card-header bg-six">
              <strong>Proceeding  Details</strong></div>
              
                <?php
                if($app['remark']){?>
                <table class="table table-bordered">
                  <th>Proceeding</th>
                  
                   <th>Date Entry</th>

                <?php foreach($app['remark'] as $remark):?>                  
                 <tr>
                 <td>

                <?= $remark->remark ?> &nbsp;
                </td>
                <td>

                <?= $remark->date_entry ?> &nbsp;
                </td> 
                </tr>

              <?php  $code = $remark->user_code;

               endforeach;?>
               </table>
               
            <?php  }?>
          
            </div>
          <?php }

          else{?>

            <div class="mycard">
              <div class="card-header bg-six">
              <strong>Proceeding  Details</strong></div>
              
                <?php
                if($app['remark']){?>
                <table class="table table-bordered">
                  <th>Proceeding</th>
                   <th>Note on order</th>
                   <th>Date Entry</th>

                <?php foreach($app['remark'] as $remark):?>                  
                 <tr>
                 <td>

                <?= $remark->remark ?> &nbsp;
                </td> 
                <td>

                <?= $remark->order ?> &nbsp;
                </td>
                <td>

                <?= $remark->date_entry ?> &nbsp;
                </td> 
                </tr>

              <?php  $code = $remark->user_code;

               endforeach;?>
               </table>
               
            <?php  }?>
          
            </div>
          <?php }?>
            <?php if($case[4]=='OMUT' || $case[4]=='OPART'){ ?>
            <table class="table">
              <tr>
                <td>LM Remark</td>
                <td><?=$app['lm_sk_remark']->lm_remark?></td>
              </tr>
              <tr>
                <td>SK Remark</td>
                <td><?=$app['lm_sk_remark']->sk_remark?></td>
              </tr>
            </table>
          <?php } ?>
            <div class="mycard">
              <div class="card-header bg-seven">
              <strong>Order Pass details  </strong></div>
              <table class="table table-bordered">
                <tr><td><?=$app['status'];?></td></tr>
                
              </table>
            </div>
            <?php
            if(isset($basundharaAttachment) && $basundharaAttachment!='n'){
            echo '<hr><h2 class="red">Attachments</h2> <ul>';
            foreach($basundharaAttachment  as $attachment):
              if($service_name == 'RTPS')
              {
                $linkVal = 'rtps';
              }
              else
              {
                $linkVal = 'basundhara';
              }
            ?>
            <li class="uni_text"><a href="<?php echo base_url()."index.php/".$linkVal."/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
            <?php 
            endforeach; 
            echo "</ul>";
            }
            ?>
            <?php
             if(isset($attachment)){
                echo '<hr style="border-bottom: 2px solid #000;">';
                echo '<h2 class="red">Old Mutation/Partition(RTPS) Attachments</h2>';
                foreach ($attachment  as $attachment):
                //var_dump($attachment);
                ?>
                <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $application_ref_no .'&type='. 4 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                <?php 
                endforeach; 
             }
            ?>
            <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
            <hr><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <center class='text-danger text-bold'><b>Other Supportive Document</b></center>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <?php foreach($sup_doc as $doc) { ?>
                        <tr>
                            <td><span class="text-bold"><?=$doc->file_name?></span></td>
                            <td>
            <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?> 
        </div>
    </div>
</div>

</div>

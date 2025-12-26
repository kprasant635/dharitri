<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>LAND ALLOTMENT(<?=$_GET['app']?>)</kbd>
                        </h3>
                    </div>

                    <div class="panel-body">

                      <table class="table table-striped table-bordered">
                        <tr>
                          <td>District Name: <?=$this->utilityclass->getDistrictName($app->dist_code)?></td>
                          <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?></td>
                          <td>Circle Name: <?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?></td>
                        </tr>
                        <tr>
                          <td>Mouza Name: <?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?></td>
                          <td>Lot Name: <?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no)?></td>
                          <td>Village Name: <?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?></td>
                        </tr>
                      </table>
                      <center class="uni_text">First Party Information</center>

                      <table class="table">
                         <tr class="bg-primary">
                          <td>Sl No: </td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          <td>Relation: </td>
                          <td>Gender: </td>
                          <td>Mobile: </td>
                         </tr>
                         <?php $j=1; 
                         foreach($firstParty as $sp):
                          ?>
                         <tr class="bg-success">
                          <td><?=$j++?></td>
                          <td><?=$sp->name_ass;
                          echo "<br>Orginal Allotee:" .$sp->allotee_name;
                          ?></td>
                          <td><?=$sp->gurdian_name_ass;?></td>
                          <td><?=$sp->gurdian_relation_id==1?'father':'mother';?></td>
                          <td><?=$sp->gender==1?'male':'female';?></td>
                          <td><?=$sp->mobile;?></td> 
                         </tr>
                         <?php endforeach; ?>
                      </table>  
                      <center class="uni_text">Land Area Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No:  </td>
                          <td>Order No: </td>
                          <td>Order Date: </td>
                          <td>Applied Area: </td>
                          <td>Total Area: </td>
                         </tr>
                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$firstParty[0]->order_no;?></td>
                          <td><?=$firstParty[0]->order_date?> </td>
                          <td><?=$firstParty[0]->area_b;?>B-<?=$firstParty[0]->area_k;?>K-<?=$firstParty[0]->area_l;?>L </td>
                          <td><?=$pattaNo->dag_area_b;?>B-<?=$pattaNo->dag_area_k;?>K-<?=$pattaNo->dag_area_lc;?>L </td>
                         </tr>
                      </table>
                       <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group" style='margin-bottom: 10px'>
                          <?php foreach($document as $d): ?>
                           <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
                          <?php endforeach; ?>
                        </ul>
                        <?php if($query){
                          echo "<center class='uni_text text-danger'>All Query</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                          foreach($query as $q){
                            ?>
                              <tr>
                                <td><?=$q->date_of_query?></td>
                                <td><?=$q->query_text?></td>
                                <td><?=$q->date_of_reply?></td>
                                <td><?=$q->reply_text;
                                  if($q->app_doc_id){ 
                                echo "<br>";
                                echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                              }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                          <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
                       <hr>   
                          <span id='loading'></span><span id='msg'></span>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- Modal HTML -->

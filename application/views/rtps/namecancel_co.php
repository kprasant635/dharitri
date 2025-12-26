<form id='formAjaxPost'>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Name Cancellation (<?=$_GET['app']?>)</kbd>
                        </h3>
                    </div>
                    <div class="panel-body">

                      <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
                          <input type="hidden" class="form-control" name='dag_revenue' value="<?=$pattaNo->dag_revenue?>">
                          <input type="hidden" class="form-control" name='dag_local_tax' value="<?=$pattaNo->dag_local_tax?>">
                          <input type="hidden" class="form-control" name='land_class_code' value="<?=$pattaNo->land_class_code?>">

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


                      

                      <center class="uni_text">Land Area Information</center>

                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No:  </td>
                          <td>Patta Type: </td>
                          <td>Patta No: </td>
                          <td>Total Area: </td>
                          <td>Revenue </td>
                          
                         </tr>

                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code)?> </td>
                          <td><?=$pattaNo->patta_no?> </td>
                          <td><?=$app->area_b;?>B-<?=$app->area_k;?>K-<?=$app->area_l;?>L </td>
                          <td><i class="fa fa-rupee"></i> <?=number_format($pattaNo->dag_revenue,2);?>+<?=number_format($pattaNo->dag_local_tax,2)?> = <?=number_format($pattaNo->sum,2);?> </td>
                          
                      </table>

                      <!-- <center class="uni_text">Name Cancellation</center> -->

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
                         <?php $i=1; foreach($firstParty as $fp): ?>
                         <tr class="bg-success">
                          <td><?=$i++?></td>
                          <td> <?=$fp->pat_name_ass;?></td>
                          <td> <?=$fp->pat_gurdian_name_ass;?></td>
                          <td> <?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                          <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                          <td><?=$fp->pat_mobile_no;?></td>
                         </tr>
                         <?php endforeach; ?>
                      </table>

                      <center class="uni_text">Second Party Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Sl No: </td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          <!-- <td>Relation: </td>
                          <td>Gender: </td>
                          <td>Mobile: </td> -->
                         </tr>
                         <?php $j=1; 
                         foreach($secParty as $sp):
                          ?>
                         <tr class="bg-success">
                          <td><?=$j++?></td>
                          <td><?=$sp->name_ass;?></td>
                          <td><?=$sp->gurdian_name_ass;?></td>
                          <!-- <td><?=$sp->gurdian_relation_id;?></td>
                          <td><?=$sp->gender;?></td>
                          <td><?=$sp->mobile;?></td> -->
                         </tr>
                         <?php endforeach; ?>
                      </table>


                      <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group">
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
                          <?php endforeach; ?>
                        </ul>
                      <hr>
                       <div class="col-lg-3">
                                    <select class="form-control" name="official" >
                                        <option selected disabled>Address to officer</option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?php echo $u['user_code']; ?>"><?php echo $u['co_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('official', '<p class="red">', '</p>'); ?>
                        </div>

                        <div class="col-lg-9">
                        <textarea name="remark" class="form-control" rows="4" required=""></textarea>
                                     
                        </div>
                         
                         <div>

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
                          <hr>
                       <!--  <center><button type="submit" class="btn btn-info">Submit</button></center> -->

                        
                      </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


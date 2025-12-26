<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of Office<kbd>Mutation By Deed(<?=$_GET['app']?>)</kbd>
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
                         <?php $i=1;$j=1; foreach($firstParty as $fp): ?>
                         <tr class="bg-success">
                          <td><?=$i++?></td>
                          <td><?=$fp->pat_name_ass;?></td>
                          <td><?=$fp->pat_gurdian_name_ass;?></td>
                          <td><?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                          <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                          <td><?=$fp->pat_mobile_no;?></td>
                          
                         </tr>
                         <?php $j++; endforeach; ?>
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
                      <center class="uni_text">Land Area Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No  </td>
                          <td>Patta Type </td>
                          <td>Patta No </td>
                          <td>Mutated Area </td>
                          <td>Total Area </td>
                          <td>Deed Details </td>
                          <td>NOC Details </td>
                         </tr>
                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code);?></td>
                          <td><?=$pattaNo->patta_no?> </td>                          
                          <td><?=$secParty[0]->area_b;?>B-<?=$secParty[0]->area_k;?>K-<?=$secParty[0]->area_l;?>L </td>
                          <td><?=$app->area_b;?>B-<?=$app->area_k;?>K-<?=$app->area_l;?>L </td>
                          <td>Deed no : <?=$secParty[0]->deed_no?><br>
                            Deed Date: <?=$secParty[0]->deed_date?><br>
                            Value : <i class="fa fa-rupee"></i> <?=$secParty[0]->deed_value?>
                          </td>
                          <td>NOC no : <?=$secParty[0]->noc_no?><br>
                            NOC Date: <?=$secParty[0]->noc_date?>
                          </td>
                         </tr>
                      </table>
                       <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group" style='margin-bottom: 10px'>
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/basundhara/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
                          <?php endforeach; ?>
                        </ul>
                        <input type="hidden" class="form-control" id='appno' name='application_no' value="<?=$app->application_no?>">
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
<!--  -->

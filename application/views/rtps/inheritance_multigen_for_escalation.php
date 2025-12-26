<style type="text/css">
/*.familytree ul {
  padding-top: 20px;
  position: relative;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}
ul.tree li {
    list-style-type: none;
    position: relative;
}

ul.tree li ul {
    display: none;
}

ul.tree li.open > ul {
    display: block;
}

ul.tree li a {
    color: black;
    text-decoration: none;
}

ul.tree li a:before {
    height: 1em;
    padding:0 .1em;
    font-size: .8em;
    display: block;
    position: absolute;
    left: -1.3em;
    top: .2em;
}



ul.tree li > a:not(:last-child):before {
    content: '+';
}

ul.tree li.open > a:not(:last-child):before {
    content: '-';
}

.familytree ul ul:before {
  content: "";
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 1px solid #ccc;
  width: 0;
  height: 20px;
}
.familytree ul li {
  float: left;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 5px 0 5px;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}
.familytree ul li a {
  border: 1px solid #ccc;
  padding: 5px 10px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 18px;
  display: inline-block;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
  /*Connector styles on hover*/
/*}
.familytree ul li a:hover, .familytree ul li a:hover + ul li a {
  background: #c8e4f8;
  color: #000;
  border: 1px solid #94a0b4;
}
.familytree ul li a:hover + ul li:after, .familytree ul li a:hover + ul li:before, .familytree ul li a:hover + ul:before, .familytree ul li a:hover + ul ul:before {
  border-color: #94a0b4;
}
.familytree ul li:before, .familytree ul li:after {
  content: "";
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 1px solid #ccc;
  width: 50%;
  height: 20px;
}
.familytree ul li:after {
  right: auto;
  left: 50%;
  border-left: 1px solid #ccc;
}
.familytree ul li:only-child:after, .familytree ul li:only-child:before {
  display: none;
}
.familytree ul li:only-child {
  padding-top: 0;
}
.familytree ul li:first-child:before, .familytree ul li:last-child:after {
  border: 0 none;
}
.familytree ul li:last-child:before {
  border-right: 1px solid #ccc;
  border-radius: 0 5px 0 0;
  -webkit-border-radius: 0 5px 0 0;
  -moz-border-radius: 0 5px 0 0;
}
.familytree ul li:first-child:after {
  border-radius: 5px 0 0 0;
  -webkit-border-radius: 5px 0 0 0;
  -moz-border-radius: 5px 0 0 0;
}*/

.genealogy-scroll::-webkit-scrollbar {
    width: 5px;
    height: 8px;
}
.genealogy-scroll::-webkit-scrollbar-track {
    border-radius: 10px;
    background-color: #e4e4e4;
}
.genealogy-scroll::-webkit-scrollbar-thumb {
    background: #212121;
    border-radius: 10px;
    transition: 0.5s;
}
.genealogy-scroll::-webkit-scrollbar-thumb:hover {
    background: #d5b14c;
    transition: 0.5s;
}


/*----------------genealogy-tree----------*/
.genealogy-body{
    white-space: nowrap;
    overflow-y: hidden;
    padding: 50px;
    min-height: 294px;
    padding-top: 10px;
    text-align: center;
}
.genealogy-tree{
  display: inline-block;
}
.genealogy-tree ul {
    padding-top: 20px; 
    position: relative;
    padding-left: 0px;
    display: flex;
    justify-content: center;
}
.genealogy-tree li {
    float: left; text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
}
.genealogy-tree li::before, .genealogy-tree li::after{
    content: '';
    position: absolute; 
  top: 0; 
  right: 50%;
    border-top: 2px solid #ccc;
    width: 50%; 
  height: 18px;
}
.genealogy-tree li::after{
    right: auto; left: 50%;
    border-left: 2px solid #ccc;
}
.genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before {
    display: none;
}
.genealogy-tree li:only-child{ 
    padding-top: 0;
}
.genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after{
    border: 0 none;
}
.genealogy-tree li:last-child::before{
    border-right: 2px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}
.genealogy-tree li:first-child::after{
    border-radius: 5px 0 0 0;
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
}
.genealogy-tree ul ul::before{
    content: '';
    position: absolute; top: 0; left: 50%;
    border-left: 2px solid #ccc;
    width: 0; height: 20px;
}
.genealogy-tree li a{
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 11px;
    display: inline-block;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}

.genealogy-tree li a:hover+ul li::after, 
.genealogy-tree li a:hover+ul li::before, 
.genealogy-tree li a:hover+ul::before, 
.genealogy-tree li a:hover+ul ul::before{
    border-color:  #fbba00;
}

.litext{
    background-color: #c9fa73;
    padding: 7px;
    font-weight: bold;
    border-radius: 15px;
    font-size: 14px;
    border: 1px solid #c2c2c2;
}
</style>
<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    
    <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-12">
                <?php 
                  //*************INTEGRATION OF BLOCKCHAIN***************//
                  // if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                  // {
                  //    include 'application/views/common/input_hidden_fields_and_func.php';
                  // //*************END*************************************//
                  // }
               ?>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Inheritance Mutation (<?=$_GET['app']?>) Case no <?=$case_no?></kbd>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php if(ESCALATION_ENABLE ==1){ ?>
                            <input type="hidden" name="executionDate" id="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
                            
                            <?php 
                              include(APPPATH."views/escalation/remaining_time.php");
                            ?>

                        <?php } ?>
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
                        
                      <div class="container">
                        <!-- Aadhaar consent Self--- -->
                                <?php include 'application/views/common/aadhar_details_dhar_end.php'; ?>
                    
                      </div>
                      
                      <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Owner Pattadar Information (DagWise)</h5>
                      <table class="table table-striped">
                         <tr class="bg-primary">
                          <td>Sl No: </td>
                          <td>Dag No.</td>
                          <td>Relation with Applicant</td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          
                          <!-- <td>Relation: </td>
                          <td>Gender: </td>
                          <td>Mobile: </td> -->
                         </tr>
                         <?php $j=1; 
                         foreach($secParty as $sp):
                            if($sp->gen == "GGP"){
                                $gen = "Great Grand Parent";
                            }else if($sp->gen == "GP"){
                                $gen = "Grand Parent";
                            }else if($sp->gen == "P"){
                                $gen = "Parent";
                            }
                          ?>
                         <tr>
                          <td><?=$j++?></td>
                          <td><?=$sp->dag_no;?></td>
                          <td><?=$gen;?></td>
                          <td><?=$sp->name_ass;?></td>
                          <td><?=$sp->gurdian_name_ass;?></td>
                          <!-- <td><?=$sp->gurdian_relation_id;?></td>
                          <td><?=$sp->gender;?></td>
                          <td><?=$sp->mobile;?></td> -->
                         </tr>
                         <?php endforeach; ?>
                      </table>

                      <?php if($app->is_multigeneration == 'M'){ ?>

                        <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Family Tree Structure (All NoK of  <?=$owner_pattadar?>)</h5>
                        <?php 
                        if($tree != null && !empty($tree)){ ?>

                        <?php if(isset($generation_type) && $generation_type == "GGP"){
                        ?>
                        <div class="col-lg-12">
                        <div class="body genealogy-body genealogy-scroll">
                        <div class="genealogy-tree">
                        <ul>
                            <li>    
                                <span class="litext"><?=$owner_pattadar?></span> 
                                <ul class="active">
                                <?php
                                foreach ($tree['GP'] as $key => $value) {
                                    if(is_array($tree['GP'][$key]) && count($tree['GP'][$key])>2){
                                        echo "<li><span class='litext'>".$value[1]."</span><ul>";

                                        foreach ($tree['GP'][$key]['P'] as $key1 => $value1) {
                                            if(is_array($tree['GP'][$key]['P'][$key1]) && count($tree['GP'][$key]['P'][$key1])>2){
                                                echo "<li><span class='litext'>".$value1[1]."</span><ul>";
                                                foreach ($tree['GP'][$key]['P'][$key1]['A'] as $key2 => $value2) {
                                                    echo "<li><span class='litext'>".$value2[1]."</span></li>";
                                                }
                                                echo "</ul></li>";
                                            }else{
                                                echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                            }
                                        }
                                        echo "</ul></li>";
                                    }else{
                                        echo "<li><span class='litext'>".$value[1]."</span></li>";
                                    }  
                                }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    </div>
                      </div>
                  <?php }else{ ?>
                    <div class="col-lg-12">
                        <div class="body genealogy-body genealogy-scroll">
                        <div class="genealogy-tree">
                        <ul>
                            <li>
                                <span class="litext"><?=$owner_pattadar?></span> 
                                
                                <ul class="active">
                                <?php
                                
                                foreach($tree['P'] as $key => $value) {
                                    if(is_array($tree['P'][$key]) && count($tree['P'][$key])>2){
                                        echo "<li><span class='litext'>".$value[1]."</span><ul>";
                                        if(!empty($tree['P'][$key]['A'])){
                                            foreach ($tree['P'][$key]['A'] as $key1 => $value1) {
                                                // if(is_array($tree['P'][$key]['A'][$key1]) && count($tree['P'][$key]['A'][$key1])>2){
                                                //     echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                                // }else{
                                                    echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                                // }
                                            }
                                        }
                                        

                                        echo "</ul></li>";
                                    }else{
                                        echo "<li><span class='litext'>".$value[1]."</span></li>";
                                    }  
                                    
                                }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
                        <?php } ?>
                    <?php } ?>


                        <!-- <div class="col-md-12 text-center">
                          <button type="button" class="btn btn-warning" id="tree_view" >Family Tree Hiearchy (Applicants)</button>
                      </div> -->
                      <?php } ?>
                  </div>
                      <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Next of Kin (All Applicants)</h5>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Sl No: </td>
                          <td><!-- Relation with Applicant -->Next of Kin Details</td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          <td>Relation: </td>
                          <td>Gender: </td>
                          <td>Mobile: </td>
                          <td>Marital Status: </td>
                          <td>Occupation: </td>
                          <td>Caste: </td>
                          <td>Action</td>
                         </tr>
                         <?php $i=1;
                         $colorFlag = '';
                        if($app->is_multigeneration == 'S'){
                                foreach($firstParty as $key => $fp):
                                    if($fp->gen == "GP"){
                                        $gen = "Grand Parent";
                                    }else if($fp->gen == "P"){
                                        $gen = "Parent";
                                    }else if($fp->gen == "A"){
                                        $gen = "Applicant";
                                    }
                                 ?>
                                 <tr style="<?=$colorFlag;?>">
                                  <td><?=$i++?></td>
                                  <td> <?=$gen;?></td>
                                  <td> <?=$fp->pat_name_ass;?></td>
                                  <td> <?=$fp->pat_gurdian_name_ass;?></td>
                                  <td> <?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                                  <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                                  <td><?=$fp->pat_mobile_no;?></td>
                                  <td><?= $this->utilityclass->getMaritalStatusName($fp->marital_status);?></td>
                                  <td><?=$fp->applicant_occupation ?? '-';?></td>
                                  <td>
                                    <?php
                                        echo $this->utilityclass->getCasteCategoryName($fp->caste_category);
                                        if(!empty($fp->tribe_category)){
                                            echo "<br>( " . $this->utilityclass->getTribeCategoryName($fp->tribe_category) . " )";
                                        }
                                    ?>
                                  </td>
                                  <td>--</td>
                                  
                             </tr>

                            <?php endforeach;
                        }elseif($app->is_multigeneration == 'M'){ 
                            foreach($firstParty as $key => $fp):
                                if($fp->gen == "GP"){  
                                    if($fp->gen == "GGP"){
                                        $gen = "Great Grand Parent";
                                    }else if($fp->gen == "GP"){
                                        $gen = "Grand Parent";
                                    }else if($fp->gen == "P"){
                                        $gen = "Parent";
                                    }else if($fp->gen == "A"){
                                        $gen = "Applicant";
                                    }
                                 ?>
                                 <tr style="<?=$colorFlag;?>">
                                  <td><?=$i++?></td>
                                  <td><b>Next of Kin of <span style="color:red;font-weight: bold;">(<?=$fp->child_of;?>)</span></b> </td>
                                  <td> <?=$fp->pat_name_ass;?></td>
                                  <td> <?=$fp->pat_gurdian_name_ass;?></td>
                                  <td> <?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                                  <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                                  <td><?=$fp->pat_mobile_no;?></td>
                                  <td><?= $this->utilityclass->getMaritalStatusName($fp->marital_status);?></td>
                                  <td><?=$fp->applicant_occupation ?? '-';?></td>
                                  <td>
                                    <?php
                                        echo $this->utilityclass->getCasteCategoryName($fp->caste_category);
                                        if(!empty($fp->tribe_category)){
                                            echo "<br>( " . $this->utilityclass->getTribeCategoryName($fp->tribe_category) . " )";
                                        }
                                    ?>
                                  </td>
                                  <td>--</td>
                                 </tr>

                            <?php } endforeach; ?>
                             <!-- <tr><td colspan="7" class="text-center" style="font-weight: bold;">Next of Kin of Grand Parent Listed Below [PARENT LIST]</td></tr> -->
                            <?php foreach($firstParty as $key => $fp): ?>
                           
                               <?php if($fp->gen == "P"){  
                                    if($fp->gen == "P"){
                                        $gen = $fp->child_of;
                                    }
                                 ?>
                                    <tr style="<?=$colorFlag;?>">
                                    <td><?=$i++?></td>
                                    <td><b>Next of Kin of <span style="color:red;font-weight: bold;">(<?=$gen;?>)</span></b></td>
                                    <td> <?=$fp->pat_name_ass;?></td>
                                    <td> <?=$fp->pat_gurdian_name_ass;?></td>
                                    <td> <?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                                    <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                                    <td><?=$fp->pat_mobile_no;?></td>
                                    <td><?= $this->utilityclass->getMaritalStatusName($fp->marital_status);?></td>
                                    <td><?=$fp->applicant_occupation ?? '-';?></td>
                                    <td>
                                        <?php
                                            echo $this->utilityclass->getCasteCategoryName($fp->caste_category);
                                            if(!empty($fp->tribe_category)){
                                                echo "<br>( " . $this->utilityclass->getTribeCategoryName($fp->tribe_category) . " )";
                                            }
                                        ?>
                                    </td>
                                    <!-- <td><input type="checkbox" id="eligible" name="eligibleParent[]" value="<?=$fp->pdar_id?>">
                                        <span style="color: red;font-size: 11px;font-weight: bold;">Click here for strike NoK</span></td> -->
                                        <td>--</td>
                                    </tr>

                                <?php }
                            
                         endforeach; ?>
                         <!-- <tr><td colspan="7" class="text-center" style="font-weight: bold;">Next of Kin of Parent </td></tr> -->
                            <?php foreach($firstParty as $key => $fp): ?>
                           
                               <?php if($fp->gen == "A"){  
                                    if($fp->gen == "A"){
                                        $gen = $fp->child_of." )";
                                    }
                                 ?>
                                 <tr style="<?=$colorFlag;?>">
                                  <td><?=$i++?></td>
                                  <td> <b>Next of Kin of <span style="color:red;font-weight: bold;">( <?=$gen;?></span></b></td>
                                  <td> <?=$fp->pat_name_ass;?></td>
                                  <td> <?=$fp->pat_gurdian_name_ass;?></td>
                                  <td> <?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                                  <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                                  <td><?=$fp->pat_mobile_no;?></td>
                                  <td><?= $this->utilityclass->getMaritalStatusName($fp->marital_status);?></td>
                                  <td><?=$fp->applicant_occupation ?? '-';?></td>
                                  <td>
                                    <?php
                                        echo $this->utilityclass->getCasteCategoryName($fp->caste_category);
                                        if(!empty($fp->tribe_category)){
                                            echo "<br>( " . $this->utilityclass->getTribeCategoryName($fp->tribe_category) . " )";
                                        }
                                    ?>
                                  </td>
                                  <!-- <td><input type="checkbox" id="eligible" name="eligibleApplicant[]" value="<?=$fp->pdar_id?>">
                                    <span style="color: red;font-size: 11px;font-weight: bold;">Click here for strike NoK</span></td> -->
                                    <td>--</td>
                                 </tr>

                            <?php }
                            
                         endforeach;
                         } ?>
                      </table>
                        
                      
                       <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Land Area Information Dag wise</h5>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No  </td>
                          <!-- <td>Choose Not Eligible Pattadar</td> -->
                          <td>Patta Type </td>
                          <td>Patta No </td>
                          
                           <td colspan="4">Total Area </td>
                         </tr>

                         <?php 
                         foreach($landAreaInfo as $landArea):
                          ?>
                         <tr>
                          <td><?=$landArea->dag_no;?></td>
                          <!-- <td></td> -->
                          <td><?=$this->utilityclass->getPattaType($landArea->patta_type_code)?></td>
                          <td><?=$landArea->patta_no;?></td>

                          
                          <!---#START PLB--->
                        <?php
                        $dist_code = $this->session->userdata('dist_code');
                        if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                             <td colspan="4"><?=$landArea->dag_area_b;?>B-<?=$landArea->dag_area_k;?>K-<?=$landArea->dag_area_lc;?>C-<?=$landArea->dag_area_g;?>G </td>
                          <?php }

                          else{?>
                            <td colspan="2"><?=$landArea->dag_area_b;?>B-<?=$landArea->dag_area_k;?>K-<?=$landArea->dag_area_lc;?>L </td>
                          <?php }?>
                         </tr>
                         <?php endforeach; foreach($secParty as $secParty):?>
                         <tr>
                           <td class="text-danger">Mutated Area <input type="hidden" name="dag_no_list[]"  value="<?=$secParty->dag_no;?>"/></td>
                           <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>

                          <?php

                          $dist_code = $this->session->userdata('dist_code');
                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                           <td><input type="number" required="" name="mut_area_b[]"  value="<?=$secParty->area_b;?>" <?=$tag?>/> Bigha</td>
                           <td><input type="number" required="" name="mut_area_k[]"  value="<?=$secParty->area_k;?>" <?=$tag?>/> Katha </td>
                           <td><input type="number" required="" name="mut_area_l[]" value="<?=$secParty->area_l;?>" <?=$tag?>/> Chatak </td>
                           <td><input type="number" required="" name="mut_area_g[]" value="<?=$secParty->area_go;?>" <?=$tag?>/> Ganda </td>
                           <td><input type="number" required="" name="mut_area_kr[]" value="<?=$secParty->area_ka;?>" <?=$tag?>/> Kranti </td>
                           <?php }
                           else{?>
                           <td><input type="number" required="" name="mut_area_b[]"  value="<?=$secParty->area_b;?>" <?=$tag?>/> Bigha</td>
                           <td><input type="number" required="" name="mut_area_k[]"  value="<?=$secParty->area_k;?>" <?=$tag?>/> Katha </td>
                           <td><input type="number" required="" name="mut_area_l[]" value="<?=$secParty->area_l;?>" <?=$tag?>/> Lessa </td>
                           <td><input type="hidden" required="" name="mut_area_g[]" value="0" <?=$tag?>/> </td>

                         <?php }?>
                         </tr>
                     <?php endforeach; ?>

                         <!-----#END PLB--->
                      </table>
                      <div class="alert alert-info">
                        <table>
                          <td>Please Select Transfer Type  : </td>
                          <td width="70%">
                              <select class="form-control" id='mut_type' name="mut_type" required="">
                                  <option value="">Please Select Transfer Type</option>
                                  <?php foreach($mut_type as $mut){ ?>
                                    <option value="<?=$mut['trans_code']?>"><?=$mut['trans_desc_as']?></option>
                                  <?php } ?>
                              </select>
                          </td>
                        </table>
                      </div>
                        
                        <!-- #Start Other Property Details -->
                        <?php if(SHOW_OTHER_PROPERTY_DETAILS_IN_MUL_MUT_REVIEW_SEC == 1 && count($other_properties)): ?>
                            <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Other Property Details</h5>
                            <table class="table">
                                <tbody>
                                    <tr class="bg-primary">
                                        <td>Sl No: </td>
                                        <td>District</td>
                                        <td>Circle: </td>
                                        <td>Area Type: </td>
                                        <td>Village: </td>
                                        <td>Dag: </td>
                                        <td>Patta: </td>
                                        <td>Area: </td>
                                    </tr>
                                    <?php foreach($other_properties as $key => $other_property): ?>
                                        <tr>
                                            <td><?= ($key+1); ?></td>
                                            <td><?= $other_property->dist_name; ?></td>
                                            <td><?= $other_property->cir_name; ?></td>
                                            <td><?= $other_property->is_rural == 'Y' ? 'Rural' : 'Urban'; ?></td>
                                            <td><?= $other_property->vill_name; ?></td>
                                            <td><?= $other_property->dag_no; ?></td>
                                            <td><?= $other_property->patta_no; ?></td>
                                            <td>
                                                <?= $other_property->bigha; ?> Bigha
                                                | <?= $other_property->katha; ?> Katha
                                                | <?= $other_property->lessa; ?> Lessa
                                                | <?= $other_property->ganda; ?> Ganda
                                                <?php if(in_array($other_property->dist_code, json_decode(BARAK_VALLEY))): ?>
                                                     | <?= $other_property->kranti; ?> Kranti
                                                <?php endif; ?>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                    
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <!-- #End Other Property Details -->

                       <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Document(s) Attached</h5>
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
                        <div class="col-lg-10 uni_text">
                        <div class="col-lg-7 red ">Applicant has Possession (Please select the right option) </div>
                          <input type="radio" checked  name="possession" value="y"> Yes &nbsp;&nbsp;&nbsp;
                          <input type="radio"   name="possession" value="n"> No
                        </div>
                        <br><br>
                          <input type="hidden" class="form-control" name='application_no'  id='application_no' value="<?=$app->application_no?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$app->patta_type?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$app->patta_no?>">
                          <input type="hidden" class="form-control" name="is_multigeneration" id="is_multigeneration" value="<?=$app->is_multigeneration?>">
                          <div class="col-lg-12 row" style="margin-bottom:40px">
                            <div class="col-lg-3 text-right">
                                <b>LRA Remarks :</b>
                            </div>
                            <div class="col-lg-9">
                                <textarea class="form-control" name='remark' style="height: 159px;" id='reapply_remark' placeholder="Enter your remark"></textarea>
                            </div>
                          </div>
                           
                       <hr>  
                       <span id='loading'></span><span id='msg'></span>
                        <center>
                          <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- Modal HTML -->
<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/rtps/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/rtps/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
            <div class="modal-body">
                <textarea name='query' required class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<div id="treeViewModal" class="modal" tabindex="-1">
    <div class="modal-dialog" style="max-width:1312px;max-height: 450px;">
        <div class="modal-content">
            <div class="">
                
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Family Tree Structure</h5>
                <?php 
                        if($tree != null || !empty($tree)){ ?>
                            <h5 class="text-center"></h5>

                        <?php if($generation_type == "GGP"){
                        ?>
                        <div class="col-lg-12">
                        <div class="body genealogy-body genealogy-scroll">
                        <div class="genealogy-tree">
                        <ul>
                            <li>    
                                <span class="litext"><?=$owner_pattadar?></span> 
                                <ul class="active">
                                <?php
                                foreach ($tree['GP'] as $key => $value) {
                                    if(is_array($tree['GP'][$key]) && count($tree['GP'][$key])>2){
                                        echo "<li><span class='litext'>".$value[1]."</span><ul>";

                                        foreach ($tree['GP'][$key]['P'] as $key1 => $value1) {
                                            if(is_array($tree['GP'][$key]['P'][$key1]) && count($tree['GP'][$key]['P'][$key1])>2){
                                                echo "<li><span class='litext'>".$value1[1]."</span><ul>";
                                                foreach ($tree['GP'][$key]['P'][$key1]['A'] as $key2 => $value2) {
                                                    echo "<li><span class='litext'>".$value2[1]."</span></li>";
                                                }
                                                echo "</ul></li>";
                                            }else{
                                                echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                            }
                                        }
                                        echo "</ul></li>";
                                    }else{
                                        echo "<li><span class='litext'>".$value[1]."</span></li>";
                                    }  
                                }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    </div>
                      </div>
                  <?php }else{ ?>
                    <div class="col-lg-12">
                        <div class="body genealogy-body genealogy-scroll">
                        <div class="genealogy-tree">
                        <ul>
                            <li>
                                <span class="litext"><?=$owner_pattadar?></span> 
                                
                                <ul class="active">
                                <?php
                                
                                foreach($tree['P'] as $key => $value) {
                                    if(is_array($tree['P'][$key]) && count($tree['P'][$key])>2){
                                        echo "<li><span class='litext'>".$value[1]."</span><ul>";
                                        if(!empty($tree['P'][$key]['A'])){
                                            foreach ($tree['P'][$key]['A'] as $key1 => $value1) {
                                                // if(is_array($tree['P'][$key]['A'][$key1]) && count($tree['P'][$key]['A'][$key1])>2){
                                                //     echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                                // }else{
                                                    echo "<li><span class='litext'>".$value1[1]."</span></li>";
                                                // }
                                            }
                                        }
                                        

                                        echo "</ul></li>";
                                    }else{
                                        echo "<li><span class='litext'>".$value[1]."</span></li>";
                                    }  
                                    
                                }
                                ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
                    <?php } ?>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
   $elem1=$('input[name="aadhaar_no"]')[0].outerHTML;
   $elem2=$('input[name="dob"]')[0].outerHTML;
   $('input[name="aadhaar_no"]')[0].remove();
   $('input[name="dob"]')[0].remove();
   $form = $("<form></form>");
   $form.append($elem1);
   $form.append($elem2);
    $('body').append($form);
    
  $(document).ready(function(){
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    if($("#reapply_remark").val().trim().length < 1)
    {
      alert("Please Enter Your Remark");
      return false; 
    }
    var mut_type = $("#mut_type");
    if (mut_type.val() == "") {
        alert("Please select Transfer Type!");
        return false;
    }

    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'COFieldMutation/inheritancePost',
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            error: (error) => {
                alert("SOMETHING WENT WRONG!!!!!");
            },
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                        $('.disable_forward').hide();
                    },
            success: function(data){
              if(data.success!=null){
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
              }else if(data.error!=null){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
              }
            },
        });
    });
    $(document).on('click', '#tree_view', function(){
        // $('#treeViewModal').modal({backdrop: 'static', keyboard: false});
        $("#treeViewModal").modal('show');
    });
});


var tree = document.querySelectorAll('ul.tree a:not(:last-child)');
for(var i = 0; i < tree.length; i++){
    tree[i].addEventListener('click', function(e) {
        var parent = e.target.parentElement;
        var classList = parent.classList;
        if(classList.contains("open")) {
            classList.remove('open');
            var opensubs = parent.querySelectorAll(':scope .open');
            for(var i = 0; i < opensubs.length; i++){
                opensubs[i].classList.remove('open');
            }
        } else {
            classList.add('open');
        }
        e.preventDefault();
    });
}
</script>
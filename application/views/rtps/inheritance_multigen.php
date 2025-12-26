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
                            Registration of <kbd>Inheritance Mutation (<?=$_GET['app']?>)</kbd>
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
                      <h5 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">
                        Next of Kin (All Applicants)
                        <?php if($app->is_multigeneration == 'S'): ?>
                            <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#addApplicantModal">+ Add NOK</button>
                        <?php endif; ?>
                    </h5>
                      <table class="table">
                        <tbody class="applicant_tbody">
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
                                 <tr style="<?=$colorFlag;?>" class="applicant_sl">
                                  <td class="sl_no"><?=$i++?></td>
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
                         </tbody>
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

                        <?php
                            include(APPPATH."views/common/addMoreDocumentView.php");
                        ?>

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

<!-- Modal HTML -->
<div id="addApplicantModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add NOK</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="javascript:void(0)" id="addApplicantForm">
                <div class="text-center text-success app_add_scc text-bold" style="display: none;"></div>
                <input type="hidden" name="case_id" id="case_id" value="<?= $app->application_no ?>">
                <input type="hidden" name="dist_code" value="<?= $app->dist_code ?>">
                <div class="row mx-3">
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Name</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Name" name="name_asm" id="first_party_name">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Guardian Name</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Guardian Name" name="guardian_name_asm" id="first_party_gurd_name">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Relation</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_guar_rel" name="relation">
                                <option value="">Select Relation</option>
                                <?php 
                                    foreach(json_decode(RELATION_NEW_APPL) as $relation_app):
                                ?>
                                        <option value="<?= $relation_app->CODE; ?>" data-name="<?= $relation_app->NAME; ?>"><?= $relation_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Gender</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_gender" name="gender">
                                <option value="">Select Gender</option>
                                <?php 
                                    foreach(json_decode(GENDER_NEW_APPL) as $gen_app):
                                ?>
                                        <option value="<?= $gen_app->CODE; ?>" data-name="<?= $gen_app->NAME; ?>"><?= $gen_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Mobile</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Mobile" id="first_party_mobile" name="mobile">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">DOB</label>
                            <input class="form-control add_applicant_fld dnt_show_in_tbl" type="date" id="first_party_dob" name="dob">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Marital Status</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_martial" name="marital_status">
                                <option value="">Select Marital Status</option>
                                <?php 
                                    foreach(json_decode(MARITAL_STATUS_NEW_APPL) as $marital_staus):
                                ?>
                                        <option value="<?= $marital_staus->CODE; ?>" data-name="<?= $marital_staus->NAME; ?>"><?= $marital_staus->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Occupation</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_occu" name="applicant_occupation">
                                <option value="">Select Occupation</option>
                                <?php 
                                    foreach(json_decode(OCCUPATION_NEW_APPL) as $occu_app):
                                ?>
                                        <option value="<?= $occu_app->CODE; ?>" data-name="<?= $occu_app->NAME; ?>"><?= $occu_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Caste</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_cast" name="caste_category">
                                <option value="">Select Caste</option>
                                <?php 
                                    foreach(json_decode(CASTE) as $caste_app):
                                ?>
                                        <option value="<?= $caste_app->CODE; ?>" data-name="<?= $caste_app->NAME; ?>"><?= $caste_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Protected Class</label>
                            <select class="form-control add_applicant_fld_select dnt_show_in_tbl" id="first_party_protcast" name="tribe_category">
                                <?php 
                                    foreach(json_decode(PROTECTED_CLASS) as $protectedcls_app):
                                        if($protectedcls_app->CODE == -1):
                                ?>
                                            <option value="">Select Protected Class</option>
                                <?php 
                                        else:
                                ?>
                                            <option value="<?= $protectedcls_app->CODE; ?>" data-name="<?= $protectedcls_app->NAME; ?>"><?= $protectedcls_app->NAME; ?></option>
                                <?php
                                        endif;
                                ?>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Address</label>
                            <input class="form-control add_applicant_fld dnt_show_in_tbl" type="text" placeholder="Enter Address" id="first_party_address" name="address">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary app_modal_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_applicant_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  -->
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
    let removeApplicant = [];
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
    var is_multigeneration = $("#is_multigeneration").val();
    if(is_multigeneration == null || is_multigeneration==""){
        alert("Something went wrong");
        return false;
    }
    var uriSegment;
    if(is_multigeneration == "S"){
        uriSegment = "inheritancePostSingleGeneration";
    }else if(is_multigeneration == "M"){
        uriSegment = "inheritancePostMultiGeneration";
    }
    // var formData = $(this).serialize();
    var formData = new FormData(this);
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'rtps/'+uriSegment,
            data        : formData, 
            contentType: false,
            processData: false,
            dataType    : 'json', 
            // encode      : true,
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

    getNoks();

        $(document).on('click', '.add_applicant_btn', function(){
            $('.error, .app_add_scc').text('');
            const $this = $(this);
            $this.attr('disabled', true);
            let allFieldHasVal = true;
            $('.add_applicant_fld').each(function() {
                let closestFormGroup = $(this).closest('.formgroup');
                if($(this).val() == ''){
                    allFieldHasVal = false;
                    $('.add_applicant_fld_error', closestFormGroup).text('The field is required');
                }
            });
            console.log(allFieldHasVal);
            if(!allFieldHasVal){
                $this.attr('disabled', false);

                return false;
            }

            let protectedClass = $('#first_party_protcast').val();
            let protectedClassNmAttr = $('#first_party_protcast').attr('name');
            if(protectedClass == ''){
                protectedClass = 'NA';
            }
            let address = $('#first_party_address').val();
            let addressNmAttr = $('#first_party_address').attr('name');

            let formData = new FormData(document.getElementById('addApplicantForm'));

            $.ajax({
                method: 'POST',
                data: formData,
                url: "<?= base_url('index.php/add-nok'); ?>",
                processData : false, // Don't process the files
                contentType : false, // Set content type to false as jQuery will tell the server its a query string request
                dataType    : 'json',
                success: function(response){
                    if(response.success){
                        arrangeNok(response.data);
                        $('.app_add_scc').text(response.message).show();
                    }else{
                        $('.app_add_scc').text(response.message).show();
                    }
                    
                    $('#addApplicantForm').trigger("reset");
                    $this.attr('disabled', false);
                    
                },
                error: function(data){
                    var errors = data.responseJSON;
                }
            });
            
            setTimeout(() => {
                $('.app_add_scc').hide(500);
            }, 2000);
        });

    $(document).on('click', '.delete_applicant', function(){
        const $this = $(this);
        Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'You want to delete this!',
                showCancelButton: true,
                // confirmButtonColor: '#2dbc9d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((response) => {
                if(response.isConfirmed){
                    const caseId = $('#case_id').val();
                    const serialId = $this.data('serial_id');
                    let formData = new FormData();
                        formData.append('case_id', caseId);
                        formData.append('row_id', serialId);
                    $.ajax({
                        url: "<?= base_url('index.php/delete-noks'); ?>",
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response){
                            if(response.success){
                                $this.closest('tr').remove();
                                manageSlNo();
                            }else{
                                alert(response.message);
                            }
                        },
                        error: function(errorData){
                            alert("Something went wrong. Please try again later.");
                        }
                    });
                    // if($this.hasClass('rtps_applicant')){
                    //     removeApplicant.push($this.attr('data-index'));
                    //     $this.closest('tr').remove();
                    //     manageSlNo();
                    // }else{
                    // }
                    
                }
            });
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

    function getNoks(){
        const caseId = $('#case_id').val();
        let formData = new FormData();
            formData.append('case_id', caseId);
        $.ajax({
            method: 'POST',
            data: formData,
            url: "<?= base_url('index.php/get-noks'); ?>",
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success: function(response){
                if(response.success){
                    arrangeNok(response.data);
                }
            },
            error: function(data){
                var errors = data.responseJSON;
            }
        });
    }

    function arrangeNok(datas){
        let html = '';
        $('.nok_tr').remove();
        if(datas.length > 0){
            $.each(datas, function(index, data){
                html += `<tr class= applicant_sl nok_tr">
                            <td class="sl_no"></td>
                            <td>Applicant</td>
                            <td>${data.name_asm}</td>
                            <td>${data.guardian_name_asm}</td>
                            <td>${data.relation_name}</td>
                            <td>${data.gender_name}</td>
                            <td>${data.mobile}</td>
                            <td>${data.marital_status_name}</td>
                            <td>${data.applicant_occupation}</td>
                            <td>
                                ${data.caste_category_name}
                                ${data.tribe_category_name != '' ? `<br>(${data.tribe_category_name})` : `` }
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger delete_applicant" data-serial_id="${data.serial_id}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>`;
            });

            $('.applicant_tbody').append(html);

            manageSlNo();
        }
    }

    function manageSlNo(){
        $('.applicant_sl').each(function(index){
            let closestTr = $(this);
            $('.sl_no', closestTr).text(index + 1);
        });
    }
</script>
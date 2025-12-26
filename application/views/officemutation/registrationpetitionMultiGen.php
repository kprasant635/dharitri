<style type="text/css">
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
.badge{
    font-size: 13px !important;

}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 center-col">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="bold" style="text-align: center;"><?php  echo $this->lang->line('case_no'); ?>: <?php echo $case_no;?> <b>(<?=$mutation_type_single_multi?>)</b></p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    <p class="regular uni_text text-center text-danger">Family Details (All NoK)</p>
                    <?php if($pb->is_multigeneration == "M"){ ?>


                        <?php 
                        if($tree != null || !empty($tree)){ ?>

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
                     <?php } ?>


                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger"><?php  echo $this->lang->line('general_information'); ?></p>
                            <table class='table'>
                                <tr >
                                    <td class='alert-new'><?php  echo $this->lang->line('district'); ?>:<?php echo $location['dist']; ?></td>
                                    <td class='alert-new'><?php  echo $this->lang->line('subdivision'); ?>:<?php echo $location['sub']; ?></td>
                                    <td class='alert-new'><?php  echo $this->lang->line('circle'); ?>:<?php echo $location['cir']; ?></td>
                                    <td class='alert-new'><?php  echo $this->lang->line('lot_no'); ?>:<?php echo $location['lot']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php  echo $this->lang->line('mouza'); ?>:<?php echo $location['mouza']; ?></td>
                                    <td><?php  echo $this->lang->line('vill_town'); ?>:<?php echo $location['vill']; ?></td>
                                    <td><?php  echo $this->lang->line('transfer_type'); ?>:<?php echo $tranfer_type; ?></td>
                                    <td><?php  echo $this->lang->line('address_to'); ?>:<?php echo $addressed_to->username; ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                   <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger"><?php  echo $this->lang->line('applicant_information')?></p>
                            
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th class='alert-new'><?php  echo $this->lang->line('applicant_id')?></th>
                                       <!--  <?php 
                                        // if($pb->is_multigeneration =="M"){
                                        //     echo $Generation = "<th>Generation Level</th>";
                                        // }
                                         ?> -->
                                        <th class='alert-new'><?php  echo $this->lang->line('applicants_name')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('guardian_name')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('relation')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('address1')?>/<?php  echo $this->lang->line('address2')?></th>
                                        <th class='alert-new'><?php  echo $this->lang->line('date_applied')?></th>
                                        <th class='alert-new'>Mobile</th>
                                        <th class='alert-new'>Marital Status </th>
                                        <th class='alert-new'>Occupation </th>
                                        <th class='alert-new'>Caste </th>
                                    </tr>
                                </thead>
                                <?php $count = 1; ?>
                                <?php foreach ($petitioner as $p): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <?php 
                                        // if($pb->is_multigeneration =="M"){
                                        //     if($p['generation_type'] == "GP"){
                                        //         $gen = "Grand Parent";
                                        //     }elseif($p['generation_type'] == "P"){
                                        //         $gen = "Parent";
                                        //     }else{
                                        //         $gen = "Applicant";
                                        //     }
                                        //     echo $Generation = "<td>".$gen."</td>";
                                        // }
                                         ?>
                                        <td><?php echo $p['pet_name']; ?> <b><?=isset($p['child_of'])?" <span style='color:red'> [ NoK of ".$p['child_of']." ] </span>" : null?></b></td>
                                        <td><?php echo $p['guard_name']; ?></td>
                                        <td><?php echo $this->utilityclass->get_relation($p['guard_rel']); ?></td>
                                        <td><?php echo $p['add1'] . "/" . $p['add2']; ?></td>
                                        <td><?php echo date('d-m-y',  strtotime($p['date_entry'])); ?></td>
                                        <td><b class="uni_text text-success"><?=$p['pdar_mobile']?"(".$p['pdar_mobile'].")":null?></b></td>
                                        <td><?= $this->utilityclass->getMaritalStatusName($p['marital_status']);?></td>
                                            <td><?=$p['applicant_occupation'] ?? '-';?></td>
                                            <td>
                                                <?php
                                                    echo $this->utilityclass->getCasteCategoryName($p['caste_category']);
                                                    if(!empty($p['tribe_category'])){
                                                        echo "<br>( " . $this->utilityclass->getTribeCategoryName($p['tribe_category']) . " )";
                                                    }
                                                ?>
                                            </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger"><?php  echo $this->lang->line('application_dag_details_information')?></p>
                           
                            <table class="table table-striped">
                                <thead>
                                <th class='alert-new'><?php  echo $this->lang->line('dag_no')?></th>
                                <?php
                                  $dist_code = $this->session->userdata('dist_code');
                                  if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <th class='alert-new'><?php  echo $this->lang->line('land_area_mutation')?><br>B-K-C-G</th>
                            <?php }else{?>
                                <th class='alert-new'><?php  echo $this->lang->line('land_area_mutation')?><br><?php  echo $this->lang->line('B-K-L')?></th>
                            <?php }?>
                                <th class='alert-new'><?php  echo $this->lang->line('patta_no')?></th>
                                <th class='alert-new'><?php  echo $this->lang->line('patta_type')?></th>
                                </thead>
                                <?php foreach ($dags as $d): ?>
                                    <tr>
                                        
                                        <td>Dag No: <?php echo $d['dag_no']; ?></td>
                                <?php
                                  $dist_code = $this->session->userdata('dist_code');
                                  if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                        <td>
                                            <?php echo $d['m_dag_area_b']."-".$d['m_dag_area_k']."-".$d['m_dag_area_lc']."-".$d['m_dag_area_g']; ?>
                                        </td>
                                     <?php }else{?>   
                                        <td>
                                            <?php echo $d['m_dag_area_b']."-".$d['m_dag_area_k']."-".$d['m_dag_area_lc']; ?>
                                        </td>
                                    <?php }?>
                                        <td><?php echo $d['patta_no'];?>
                                        <td><?php echo $this->utilityclass->getPattaType($d['patta_type_code']);?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>Deed No: <?=$pb->deed_no;?></td>
                                    <td>Deed Date: <?=$pb->deed_date;?></td>
                                    <td>Deed Value: <?=$pb->deed_value;?></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- #Start Other Property Details -->
                    <?php if(SHOW_OTHER_PROPERTY_DETAILS_IN_MUL_MUT_REVIEW_SEC == 1 && count($other_properties)): ?>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular uni_text text-center text-danger">Other Property Details</p>
                           
                            <table class="table table-striped">
                                <thead>
                                    <th class="alert-new">Sl No: </th>
                                    <th class="alert-new">District</th>
                                    <th class="alert-new">Circle: </th>
                                    <th class="alert-new">Area Type: </th>
                                    <th class="alert-new">Village: </th>
                                    <th class="alert-new">Dag: </th>
                                    <th class="alert-new">Patta: </th>
                                    <th class="alert-new">Area: </th>
                                </thead>
                                <tbody>
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
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- #End Other Property Details -->

<!--                    <div class="row">
                        <div class="col-lg-12">
                            <p class="regular">Second Party Information</p>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Applicant ID</th>
                                        <th>Second Party</th>
                                        <th>Guardian Name</th>
                                        <th>Realtion</th>
                                        <th>Address1/Address2</th>
                                    </tr>
                                </thead>
                                <?php $count = 1; ?>
                                <?php foreach ($pattadar as $p): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $p['pdar_name']; ?></td>
                                        <td><?php echo $p['pdar_guardian']; ?></td>
                                        <td><?php echo $p['pdar_rel_guar']; ?></td>
                                        <td><?php echo $p['pdar_add1'] . "/" . $p['pdar_add2']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </table>

                        </div>
                    </div>-->
                  
                </div>
            </div>
        </div>
    </div>
</div>
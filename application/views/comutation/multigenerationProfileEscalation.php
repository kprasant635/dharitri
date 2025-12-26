<style type="text/css">
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>application/views/images/load.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .9;
    }



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

<?php
    $rtps;
?>



<div class="loader"></div> 
<div class="container-fluid form-top login">
    <div class="row">
        <?php
        $buttonEnabledFlag =1;
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            include 'application/views/common/input_hidden_fields_and_func.php';
        }
        ?>
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Field <b>Mutation Type : <?=$mutation_type_single_multi?></b>
                    </h2>
                </div>
            </div>
            <div class="error_container">
                <?php
                    if($this->session->flashdata('message_extra')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('message_extra'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
            </div>

            <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
                <input type="hidden" name="dist_code" value="<?=$fmb['dist_code']?>">
                <input type="hidden" name="subdiv_code"  value="<?=$fmb['subdiv_code']?>">
                <input type="hidden" name="circle_code" value="<?=$fmb['cir_code']?>">
                <input type="hidden" name="mouza_code" value="<?=$fmb['mouza_pargona_code']?>">
                <input type="hidden" name="lot_no" value="<?=$fmb['lot_no']?>">
                <input type="hidden" name="vill_code" value="<?=$fmb['vill_townprt_code']?>">
                <input type="hidden" name="patta_type" value="<?=$fmd[0]['patta_type_code']?>">
                <input type="hidden" name="patta_no" value="<?=$fmd[0]['patta_no']?>">
            </form>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <b style="float:right;background: #fff57f;padding: 4px;">Chitha and Jamabandi Details</b>
                <br>
                <div class="col-lg-12">
                <a style="float:right" target="_blank" href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $fmd[0]['dag_no'] . '&m=' . $fmb['mouza_pargona_code'] . '&l=' . $fmb['lot_no'] . '&v=' . $fmb['vill_townprt_code'] . '&p=' . $fmd[0]['patta_type_code'] . '&dist=' . $fmb['dist_code'] . '&cir=' . $fmb['cir_code'] . '&sub_div=' . $fmb['subdiv_code'] ?>">
                             <i class="fa fa-link" aria-hidden="true"></i><u><span class="text-primary" style="font-size:16px;">Dag No. <?=$fmd[0]['dag_no']?> (Chitha View)</span></u>
                          </a>
                </div>
                <div class="col-lg-12">
                <button style="float:right" id="seeJamaClick">
                     <i class="fa fa-link" aria-hidden="true"></i>
                     <span class="text-primary" style="font-size:16px;color:#ffb81d">Patta No. <?=$fmd[0]['patta_no']?> (Jamabandi View)</span>
                </button>
                </div>
                
            </div>
            <form id='submitFieldPost' action="<?php echo base_url() ?>index.php/cofieldmutation/passOrderofMultiGenerationWithEscalation" enctype="multipart/form-data" method="POST">
                <input type="text" name="executionDate" id="executionDate" value="<?=date('Y-m-d H:i:s')?>">
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }
                            ?>
                            <h2 class="text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Location Details</h2>
                                <table class="table">
                                        <tr class="table-primary">
                                            <td>District Name: <?=$this->utilityclass->getDistrictName($fmb['dist_code'])?></td>
                                            <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($fmb['dist_code'],$fmb['subdiv_code'])?></td>
                                            <td>Circle Name: <?=$this->utilityclass->getCircleName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'])?></td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td>Mouza Name: <?=$this->utilityclass->getMouzaName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'])?></td>
                                            <td>Lot Name: <?=$this->utilityclass->getLotName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'])?></td>
                                            <td>Village Name: <?=$this->utilityclass->getVillageName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'],$fmb['vill_townprt_code'])?></td>
                                        </tr>
                                </table>
                        <h2 class="text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Family Details (All NoK)</h2>
                    <?php if($fmb['is_multigeneration'] == "M"){ ?>


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



                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Address</td>
                                            <td>Aadhaar/PAN Status</td>
                                            <td>Marital Status</td>
                                            <td>Occupation</td>
                                            <td>Caste</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($generation_type) && $generation_type == "GGP"){ ?>
                                         <tr><td colspan="8" class="text-center"><b style="font-size: 17px;">Next of Kin of Owner Pattadar <span class="badge badge-success">Grand Parent List of Applicant</span> </b></td></tr>
                                     <?php } ?>
                                        <?php foreach ($applicant as $app) : ?>
                                           
                                            <?php 
                                            if($app['generation_type'] == "GP"){
                                            if($app['auth_type'] !=null){
                                                $status = $app['auth_type']. " Verified";
                                                $engName = $app['engName'];
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                            }
                                            ?>
                                            
                                            <tr>
                                                <td><b><?=$app['pet_name']?></b></td>
                                                <td><?=$app['guard_name']?></td>
                                                <td><?=$this->utilityclass->appRelation($app['guard_rel'])?> <span class="badge badge-danger"> <?=isset($app['child_of'])?"  NoK of ".$app['child_of'] ." ":null?> </span></td>
                                                <td><?=$app['add1'].$app['add2']?></td>
                                                <td style="color:green"><?=$engName?><br><b><?=$status?></b></td>
                                                <td><?= $this->utilityclass->getMaritalStatusName($app['marital_status']);?></td>
                                                <td><?=$app['applicant_occupation'] ?? '-';?></td>
                                                <td>
                                                    <?php
                                                        echo $this->utilityclass->getCasteCategoryName($app['caste_category']);
                                                        if(!empty($app['tribe_category'])){
                                                            echo "<br>( " . $this->utilityclass->getTribeCategoryName($app['tribe_category']) . " )";
                                                        }
                                                    ?>
                                                </td> 
                                            </tr>
                                        
                                            
                                        <?php } endforeach; ?>
                                        <tr><td colspan="8" class="text-center"><b style="font-size: 17px;">Next of Kin of Grand Parent <span class="badge badge-success">Parent list of Applicant</span></b></td></tr>
                                        <?php foreach ($applicant as $app) : ?>
                                            
                                            <?php 
                                        if($app['generation_type'] == "P"){
                                            if($app['auth_type'] !=null){
                                                $status = $app['auth_type']. " Verified";
                                                $engName = $app['engName'];
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                            }
                                            ?>
                                            
                                            <tr>
                                                <td><b><?=$app['pet_name']?></b></td>
                                                <td><?=$app['guard_name']?></td>
                                                <td><?=$this->utilityclass->appRelation($app['guard_rel'])?> <span class="badge badge-danger"> <?=isset($app['child_of'])?"  NoK of ".$app['child_of'] ." ":null?> </span></td>
                                                <td><?=$app['add1'].$app['add2']?></td>
                                                <td style="color:green"><?=$engName?><br><b><?=$status?></b></td>
                                                <td><?= $this->utilityclass->getMaritalStatusName($app['marital_status']);?></td>
                                                <td><?=$app['applicant_occupation'] ?? '-';?></td>
                                                <td>
                                                    <?php
                                                        echo $this->utilityclass->getCasteCategoryName($app['caste_category']);
                                                        if(!empty($app['tribe_category'])){
                                                            echo "<br>( " . $this->utilityclass->getTribeCategoryName($app['tribe_category']) . " )";
                                                        }
                                                    ?>
                                                </td> 
                                            </tr>
                                        
                                            
                                        <?php }


                                         endforeach; ?>
                                         <tr><td colspan="8" class="text-center"><b style="font-size: 17px;">Next of Kin of Parent <span class="badge badge-success">list of Applicant</span></b></td></tr>
                                        <?php foreach ($applicant as $app) : ?>
                                            
                                            <?php 
                                        if($app['generation_type'] == "A"){
                                            if($app['auth_type'] !=null){
                                                $status = $app['auth_type']. " Verified";
                                                $engName = $app['engName'];
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                            }
                                            ?>
                                            
                                            <tr>
                                                <td><b><?=$app['pet_name']?></b></td>
                                                <td><?=$app['guard_name']?></td>
                                                <td><?=$this->utilityclass->appRelation($app['guard_rel'])?> <span class="badge badge-danger"> <?=isset($app['child_of'])?"  NoK of ".$app['child_of'] ." ":null?> </span></td>
                                                <td><?=$app['add1'].$app['add2']?></td>
                                                <td style="color:green"><?=$engName?><br><b><?=$status?></b></td>
                                                <td><?= $this->utilityclass->getMaritalStatusName($app['marital_status']);?></td>
                                                <td><?=$app['applicant_occupation'] ?? '-';?></td>
                                                <td>
                                                    <?php
                                                        echo $this->utilityclass->getCasteCategoryName($app['caste_category']);
                                                        if(!empty($app['tribe_category'])){
                                                            echo "<br>( " . $this->utilityclass->getTribeCategoryName($app['tribe_category']) . " )";
                                                        }
                                                    ?>
                                                </td> 
                                            </tr>
                                        
                                            
                                        <?php }


                                         endforeach; ?>
                                    </tbody>
                                </table>
                            <?php } else{ ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Address</td>
                                            <td>Aadhaar/PAN Status</td>
                                            <td>Marital Status: </td>
                                            <td>Occupation: </td>
                                            <td>Caste: </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($applicant as $app) :
                                            if($app['auth_type'] !=null){
                                                $status = $app['auth_type']. " Verified";
                                                $engName = $app['engName'];
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                            }
                                            ?>
                                        <tr>
                                            <td><b><?=$app['pet_name']?></b></td>
                                            <td><?=$app['guard_name']?></td>
                                            <td><?=$this->utilityclass->appRelation($app['guard_rel'])?></td>
                                            <td><?=$app['add1'].$app['add2']?></td>
                                            <td style="color:green"><?=$engName?><br><b><?=$status?></b></td>
                                            <td><?= $this->utilityclass->getMaritalStatusName($app['marital_status']);?></td>
                                            <td><?=$app['applicant_occupation'] ?? '-';?></td>
                                            <td>
                                                <?php
                                                    echo $this->utilityclass->getCasteCategoryName($app['caste_category']);
                                                    if(!empty($app['tribe_category'])){
                                                        echo "<br>( " . $this->utilityclass->getTribeCategoryName($app['tribe_category']) . " )";
                                                    }
                                                ?>
                                            </td> 
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                                <h2 class="text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Owner Pattadar Dag Details</h2>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Dag No.</td>
                                            <td>Generation Level</td>
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Inplace/Alongwith</td>
                                            <td>Type</td>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                         foreach ($seller as $app) :?>
                                        <tr>
                                            <td><?=$app['dag_no']?></td>
                                            <td>
                                                <?php if($app['generation_type'] == "GGP"){
                                                    $gen = "Great Grand Parent";
                                                }else if($app['generation_type'] == "GP"){
                                                    $gen = "Grand Parent";
                                                }else if($app['generation_type'] == "P"){
                                                    $gen = "Parent";
                                                }else{
                                                    $gen ="N/A";
                                                } ?>
                                            <?=$gen;?></td>
                                            <td><?=$app['pdar_name']?></td>
                                            <td><?=$app['pdar_guardian']?></td>
                                            <input type="hidden" name="pattadar_id[]" value="<?=$app['pdar_id']?>">
                                            <td><?php $app['striked_out']; ?>
                                            <select name="inplace_alongwith[]" class="form-control" required="">
                                            <option value="1" <?php
                                            if ($app['striked_out'] == 1) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $this->lang->line('inplace') ?></option>
                                            <option value="0" <?php
                                            if (($app['striked_out'] == 0)) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $this->lang->line('along_with') ?></option>
                                        </select>
                                            </td>
                                            <td><?=$this->utilityclass->getTransferType($fmb['trans_code'])?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <h2 class="text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Land Information Details</h2>
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($fmd as $dag) :?>
                                        <tr class="table-primary">
                                            <td>Patta Type: <?=$this->utilityclass->getPattaName($dag['patta_type_code'])?> </td>
                                            <td>Patta No: <?=$dag['patta_no']?></td>
                                            <td colspan="4">Dag No: <?=$dag['dag_no']?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-danger"><center><b>Please Update the Details if it's incorrect</b></center></td>
                                        </tr>
                                        <input type="hidden" name="trans_code" value="<?=$fmb['trans_code']?>">
                                        <?php
                                            //echo $fmb['trans_code'];
                                            if($fmb['trans_code']=='03'){ 
                                            $deed=true;
                                            //echo $fmb['reg_deed_date'];
                                            ?>
                                        <tr class="table-success">

                                            <td>Deed No: <input type="text" name="reg_deed_no" value=<?=$fmb['reg_deed_no']==null?0:$fmb['reg_deed_no']?> >  </td>
                                            <td>Deed Date: <input type="text" name="reg_deed_date" value=<?=$fmb['reg_deed_date']==null?0:$fmb['reg_deed_date']?> id='DatepickerCO' ></d>
                                            <td colspan="4">Deed Value: <input type="text" name="deed_value" value=<?=$fmb['deed_value']==null?0:$fmb['deed_value']?> ></td>
                                        </tr>
                                            <?php
                                            }else{
                                                $deed=false;$hide=null;
                                            } ?>


                                        <!--//#START PLB--->
                                        <?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>

                                         <tr class="table-info">
                                            <td>Applied Bigha: <input type="hidden" name="dag_no_update[]" value=<?=$dag['dag_no'];?> > <input type="text" name="applied_b[]" value=<?=$dag['m_dag_area_b']==null?0:$dag['m_dag_area_b']?> readonly>  </td>
                                            <td>Applied Katha: <input type="text" maxlength="4" name="applied_k[]" value=<?=$dag['m_dag_area_k']==null?0:$dag['m_dag_area_k']?> readonly></d>
                                            <td>Applied Chatak: <input type="text" maxlength="19" name="applied_lc[]" value=<?=$dag['m_dag_area_lc']==null?0:$dag['m_dag_area_lc']?> readonly></td>
                                            <td>Applied Ganda: <input type="text" maxlength="19" name="applied_g[]" value=<?=$dag['m_dag_area_g']==null?0:$dag['m_dag_area_g']?> readonly></td>
                                            <td>Applied Kranti: <input type="text" maxlength="19" name="applied_kr[]" value=<?=$dag['m_dag_area_kr']==null?0:$dag['m_dag_area_kr']?> readonly></td>
                                        </tr>
                                        
                                        <tr class="table-info hide">
                                            <td>Applied Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Applied Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Applied Lessa: <?= $dag['m_dag_area_lc']?></td>
                                            <td>Applied Ganda: <?= $dag['m_dag_area_g']?></td>
                                            <td>Applied Kranti: <?= $dag['m_dag_area_kr']?></td>

                                        </tr>
                                        <tr class="table-warning">
                                            <td>Total Bigha: <?= $dag['dag_area_b']?> </td>
                                            <td>Total Katha: <?=$dag['dag_area_k']?></td>
                                            <td>Total Chatak: <?=number_format($dag['dag_area_lc'],2)?></td>
                                            <td>Total Ganda: <?=number_format($dag['dag_area_g'],2)?></td>
                                            <td>Total kranti: <?=number_format($dag['dag_area_kr'],2)?></td>
                                        </tr>

                                        <?php }
                                        else{?>    

                                        <tr class="table-info">
                                            <td>Applied Bigha: <input type="hidden" name="dag_no_update[]" value=<?=$dag['dag_no'];?> ><input type="text" name="applied_b[]" value=<?=$dag['m_dag_area_b']==null?0:$dag['m_dag_area_b']?> readonly>  </td>
                                            <td>Applied Katha: <input type="text" maxlength="4" name="applied_k[]" value=<?=$dag['m_dag_area_k']==null?0:$dag['m_dag_area_k']?> readonly></d>
                                            <td>Applied Lessa: <input type="text" maxlength="19" name="applied_lc[]" value=<?=$dag['m_dag_area_lc']==null?0:$dag['m_dag_area_lc']?> readonly></td>
                                        </tr>
                                        
                                        <tr class="table-info hide">
                                            <td>Applied Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Applied Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Applied Lessa: <?= $dag['m_dag_area_lc']?></td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>Total Bigha: <?= $dag['dag_area_b']?> </td>
                                            <td>Total Katha: <?=$dag['dag_area_k']?></td>
                                            <td>Total Lessa: <?=number_format($dag['dag_area_lc'],2)?></td>
                                        </tr>
                                    <?php }?>

                                         <!--//#END PLB--->
                                        <tr class="table-success">
                                            <td>Rajah Adalat: <?=$fmb['rajah_adalat']=='0' ?'No':'Yes'?> </td>
                                            <td>Dispute: <?=$fmb['dispute_yn']=='0' ?'No':'Yes'?></td>
                                            <td colspan="4">Possession: <?=$fmb['possession_yn']==null ?'':'Have Possession'; ?></td>
                                        </tr>
                                        <tr class="table-success">
                                            <!-- <td colspan="3">Mondal  Note: <?= $dag['remark']?> </td> -->
                                            <td colspan="5">Mondal  Note: <?=$lm_remark?> </td>
                                           </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <!-- #Start Other Property Details -->
                                <?php if(SHOW_OTHER_PROPERTY_DETAILS_IN_MUL_MUT_REVIEW_SEC == 1 && count($other_properties)): ?>
                                <h2 class="modal-title text-center" style="color: #9f382f;border-left: 4px solid #b2412f;background: beige;padding: 9px;">Other Property Details</h2>
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
                        </div>
                        <div class="col-lg-12">
                            <label class="col-sm-4">
                                Mondols Name : <?php $lmName=$this->utilityclass->getDefinedMondalsName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'],$fmb['user_code']);
                                echo $lmName->lm_name;
                                ?> </label>
                            <label class="col-sm-4 rasid">
                                Mondal Note Date : <?=$fmb['date_entry']?>
                            </label>
                        </div>

                        <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                        <br>                         
                        <hr>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <center class='text-danger text-bold'><b>View Supportive Document</b></center>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <?php foreach($sup_doc as $doc) { ?>
                                    <tr>
                                        <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                        <td>
                                           <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank" download>Click to View</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>


                        <?php }
                        include(APPPATH."views/common/addMoreDocumentView.php");
                         ?>


                        <hr>
                        <div>
                    <?php if($basuCase){ ?>
                    <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        <?php } ?>
                            <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                            }                               
                            ?>

                            <?php
                             if($query){
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
                                    echo "<a target='download' href='".base_url()."index.php/basundhara/document/".$q->app_doc_id."'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; }?>
                        <?php if($sro){
                          $hide=null;
                          echo "<center class='uni_text text-danger'>SRO Report</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>SRO Remark</td>
                          <td>Approve/Reject</td><td>Verified Date</td><td>Verified By</td></tr></th>";
                          foreach($sro as $q){
                            ?>
                              <tr>
                                <td><?=$q->remark?></td>
                                <td><kbd><?=$q->approve_reject==1?'Approved':'Rejected';?></kbd></td>
                                <td><?=$q->date_of_verification?></td>
                                <td><?=$q->sro_officer_name;?></td>
                              </tr>
                        <?php } echo "</table>"; } ?>
                    </div>
                    <hr>
                        <?php
                        if(empty($sro) and $deed==true and $rtps!='RTPS'){
                         if($apps->pending_with_officer!='SRO'){
                            $hide=null;
                          ?>
                            <a href="<?php echo base_url()."index.php/basundhara/pushSro?app=$basuCase&c=$_GET[case_no]" ?>" class="green" onclick="if (!confirm('Are you sure want to continue ?')) { return false; }"><i class='fa fa-asterisk'></i>&nbsp;Push to SRO (Click to send SRO Office)</a>
                            <?php }else{
                                $hide='hide';
                                echo "<p class='text-info'>Forwarded to SRO Office for Deed Verification</p>";
                            }
                        } ?>
                        <hr>
                       <?php if($tempNok and ($tempNok[0]['approve_reject']==0 || $tempNok[0]['approve_reject']==1)){
                        ?>
                            <div class="alert alert-danger">
                                <form id='formAjaxPost' method="post">
                                    <table class="table">
                                        <thead><tr>
                                            <td>Sl No</td>
                                            <td>Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Gender</td>
                                            <td>DOB</td>
                                        </tr></thead>
                                        <tbody>
                                            <?php $i=1; foreach($tempNok as $temp){ ?>
                                                <tr>
                                                    <td><?=$i++?></td>
                                                    <td><?=$temp['name_asm']?></td>
                                                    <td><?=$temp['guardian_name_asm']?></td>
                                                    <td><?=$this->utilityclass->get_relation($temp['relation'])?></td>
                                                    <td><?=$temp['gender']?></td>
                                                    <td><?=$temp['dob']?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <input type='hidden' id="case_no" value='<?=$_GET['case_no']?>' name='case_no' />
                                    <?php if($tempNok and $tempNok[0]['approve_reject']==0){ ?>
                                        <div class="form-control alert alert-info" style="padding-top: 6px">
                                            <div class="col-sm-2">
                                                <input type="radio" class="co_status"  name="co_status" checked="" value="1"> Approve
                                            </div>
                                            <div class="hide col-sm-2">
                                                <input type="radio" class="co_status" name="co_status" value="0"> Revert to LM
                                            </div>
                                            <div class="hide col-sm-2">
                                                <input type="radio" class="co_status" name="co_status" value="2"> Cancel
                                            </div>
                                        </div>
                                       <center><button id='submitNoK' class="btn btn-sm btn-success" name="submit">Submit Status</button></center> 
                                    <?php } ?>
                                </form>
                            </div>
                            <?php }
                             if($tempNok and $tempNok[0]['approve_reject']==1 ){
                                $disable=null;
                                $now = time(); // or your date as well
                                $your_date = strtotime($tempNok[0]['co_approve_date']);
                                $datediff = $now - $your_date;
                                echo "<p class='text-danger uni_text'><b>No. of day(s) for Objection of NOK Approval by Applicant passed <kbd>". round($datediff / (60 * 60 * 24)) ."</kbd> Days </b></p>";
                                ?>
                                <hr>
                                <span id='loading'></span><span id='msg'></span>
                               <input type='hidden' value='<?=$_GET['case_no']?>' name='case_no' />
                               <?php if ($buttonEnabledFlag ==1) { ?>
                               <center><button type="submit" class="disable_forward btn btn-sm btn-success" name="submit">Submit</button></center>
                               <?php } ?> 
                            <?php }else if(!$tempNok || $tempNok[0]['approve_reject']==2) { ?>
                                <span id='loading'></span><span id='msg'></span>
                               <input type='hidden' value='<?=$_GET['case_no']?>' name='case_no' />  
                               <?php if ($buttonEnabledFlag ==1) { ?>
                                <center><button type="submit" class="disable_forward btn btn-sm btn-success" name="submit">Submit</button></center>   
                                <?php } ?>                             
                           <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<style type="text/css">
    .table-primary> td {
        background-color: #338AFF !important;
        color:#fff; 
    }
    .table-info>td {
        background-color: #CFBCA3 !important;
        color:#fff; 
    }
    .table-warning>td {
        background-color: #64856B !important;
        color:#fff; 
    }
    .table-success>td {
        background-color: #7A7C78 !important;
        color:#fff; 
    }
</style>
<script type="text/javascript">
        $(window).load(function() {
             $(".loader").fadeOut();
             //$('.disable_forward').hide();
        });
        $(document).ajaxStart(function(e){
            $(".loader").fadeOut();
        });
        $(document).ajaxComplete(function(e){
           $(".loader").fadeOut();
        });
    </script>
    <script language="javascript" type="text/javascript">
        $(window).load(function () {
            $('#loading').hide();
        });
        function LoadData() {
            $("#loading").show();
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });
        }
        $('#backtoLists').click(function(e){
            e.preventDefault();
            window.location.href=baseurl +'cofieldmutation/getPendingFMCases';
        });
    </script>
    <script type="text/javascript">

    $(document).ready(function(){
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
  $('#submitFieldPost').on('submit', function(){
    LoadData();
    $("#loading").html("Submitting ...Please wait...Don't refresh the page !!!!!");
    $('.disable_forward').hide();
    return true;
  });

  $("#seeJamaClick").click(function(event){
    $('#seeJama').submit();
  });

  $("#submitNoK").click(function(event){
    $("#formAjaxPost").submit();
    event.preventDefault();
        var formData = {
          co_status: $(".co_status").val(),
          case_no: $("#case_no").val(),
        };
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'COFieldMutation/nokApprove', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,

            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                        $('.disable_forward').hide();
                    },
            success: function(data){
              console.log(data);
              if(data.success!=null){
                //alert('hai');
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
});
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<!-- Modal HTML -->
<!-- <div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div> -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
            <?php
                    if($this->session->flashdata('query_mdl_message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('query_mdl_message'); ?>
                        </strong>
                    </div>
                <?php
                    }
                ?>
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
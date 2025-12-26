<style>
    table tr {
        font-weight: bold !important;
        font-size: 16px !important;
    }
    body { padding-right: 0 !important }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>">E-Khajana</a></li>
        <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/pendingList'?>">E-Khajana-(Case-list)</a></li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Case-Details : <?=$caseDetails[0]->petition_no?>)</li>
    </ol>
</nav>
<div class="container-fluid login form-top">
    <form action="" id="">
        <!-- Application Details -->
        
        <!-- working -->
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-danger panel-form">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-align: center; font-weight: bold;">
                                <span>Pattadar Area Change Details</span>                                
                            </h3>
                            <h3 class="panel-title mt-1" style="text-align: center; font-weight: bold;">       <?php //var_dump($caseDetails[0]->petition_no);exit;?>                         
                                <span><kbd> (Case-No : <?=$caseDetails[0]->petition_no?>) </kbd></span>
                            </h3>
                        </div>
                        <div class="panel-body" style="font-size:18px!important;">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>District Name: <?=$this->utilityclass->getDistrictName($caseDetails[0]->dist_code)?></td>
                                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($caseDetails[0]->dist_code,$caseDetails[0]->subdiv_code)?></td>
                                    <td>Circle Name: <?=$this->utilityclass->getCircleName($caseDetails[0]->dist_code,$caseDetails[0]->subdiv_code,$caseDetails[0]->cir_code)?></td>
                                </tr>
                                <tr>
                                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($caseDetails[0]->dist_code,$caseDetails[0]->subdiv_code,$caseDetails[0]->cir_code,$caseDetails[0]->mouza_pargona_code)?></td>
                                    <td>Lot Name: <?=$this->utilityclass->getLotName($caseDetails[0]->dist_code,$caseDetails[0]->subdiv_code,$caseDetails[0]->cir_code,$caseDetails[0]->mouza_pargona_code,$caseDetails[0]->lot_no)?></td>
                                    <td>Village Name: <?=$this->utilityclass->getVillageName($caseDetails[0]->dist_code,$caseDetails[0]->subdiv_code,$caseDetails[0]->cir_code,$caseDetails[0]->mouza_pargona_code,$caseDetails[0]->lot_no,$caseDetails[0]->vill_townprt_code)?></td>
                                </tr>
                            </table>

                            <table class="table table-striped table-bordered">
                                <th colspan="6" class="text-center bg-info">
                                    Land Information
                                </th>
                                <tr class="bg-secondary">
                                    <td>Patta No</td>
                                    <td>Patta Type</td>
                                    <td>Dag No</td>
                                    <td>Dag Area (B -K- L)</td>
                                </tr>
                                <tr class="">
                                    <td><?=$caseDetails[0]->patta_no?></td>
                                    <td><?=$this->utilityclass->getPattaType($caseDetails[0]->patta_type_code)?></td>
                                    <td><?=$caseDetails[0]->dag_no?></td>
                                    <td><?=$caseDetails[0]->dag_area_b?>B-<?=$caseDetails[0]->dag_area_k?>K-<?=$caseDetails[0]->dag_area_lc?>L</td>
                                
                                </tr>
                            </table>  

                            <table class="table table-striped table-bordered">
                                <th colspan="6" class="text-center bg-warning">
                                    Area Change Information
                                </th>
                                <tr class="bg-secondary">
                                    <td>Pattadar</td>
                                    <td>Original Land Share (B -K- L)</td>
                                    <td>Suggested Land Share (B -K- L)</td>
                                    
                                </tr>
                                <?php foreach($caseDetails as $cs): //var_dump($cs)?>
                                <tr class="">
                                    <td><?=$this->utilityclass->getPdarName($caseDetails[0]->dist_code,$caseDetails[0]->subdiv_code,$caseDetails[0]->cir_code,$caseDetails[0]->mouza_pargona_code,$caseDetails[0]->lot_no,$caseDetails[0]->vill_townprt_code,$cs->pdar_id,$caseDetails[0]->dag_no)?></td>
                                    <td><?=$cs->dag_por_b?>B-<?=$cs->dag_por_k?>K-<?=$cs->dag_por_lc?>L</td>
                                    <td><?=$cs->suggested_bigha?>B-<?=$cs->suggested_katha?>K-<?=$cs->suggested_lessa?>L</td>
                                </tr>
                            <?php endforeach;?>
                            </table>    

                            <table class="table table-striped table-bordered">
                                <th colspan="6" class="text-center bg-success">
                                   Remark By Mouzadar
                                </th>
                                <tr class="bg-secondary">
                                    <td>Mouzadar Name</td>
                                    <td>Remark</td>
                                    <td>Date of Entry</td>
                                </tr>
                                <tr class="">
                                    <td><?=$caseDetails[0]->mouzadar_name?></td>
                                    <td><?=$caseDetails[0]->mouzadar_remark?></td>
                                    <td><?=$caseDetails[0]->date_entry?></td>
                                </tr>
                            </table>                        
                                            
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>


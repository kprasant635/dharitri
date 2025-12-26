<link href="<?php echo base_url(); ?>application/views/css/select2.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>application/views/js/select2/select2.js"></script>
<div id="displayBoxEK" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">    
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoArrearUpdateController/index'?>">ARREAR-UPDATE(CO)</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">VIEW-ARREAR-UPDATES(BY CO/TEHSILDAR)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center font-weight-bold">
        <h3 class="panel-title">
            <u>
                UPDATED ARREAR LIST(CO) - (PATTA-WISE) <br>
            </u>                        
        </h3>
    </div>
    <div class="panel-heading bg-warning text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            NOTE : ONLY INITIAL OFFLINE ARREAR ENTRIES ARE DISPLAYED HERE
        </h6>
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="arrear_update_view_table" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>MOUZA</td>
                                <td>VILLAGE</td>
                                <td>PATTA-TYPE</td>
                                <td>PATTA-NO</td>
                                <td>FINANCIAL-YEAR</td>
                                <td>UPDATED-AT</td>
                                <td>ACTION</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($updated_arrear_list as $updated_arrear):?>       
                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-success" id="arrear_updated_mouza_name_<?=$updated_arrear->id?>">
                                            <?= $this->utilityclass->getMouzaName($updated_arrear->dist_code,$updated_arrear->subdiv_code, $updated_arrear->cir_code, $updated_arrear->mouza_pargona_code)?>
                                        <span>
                                    </td>                                    
                                    <td>
                                        <span class="font-weight-bold text-danger" id="arrear_updated_village_name_<?=$updated_arrear->id?>">
                                            <?= $this->utilityclass->getVillageNameFromUUID($updated_arrear->dist_code,$updated_arrear->village_uuid)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="text-primary">
                                            <?= $this->utilityclass->getPattaType($updated_arrear->patta_type_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="text-primary">
                                            <?= $updated_arrear->patta_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="text-primary">
                                            <?= $updated_arrear->financial_year?>
                                        <span>
                                    </td>                            
                                    <td>
                                        <span class="text-primary">
                                            <?= $updated_arrear->created_at?>
                                        <span>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="viewArrearDetails('<?=$updated_arrear->id?>')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                VIEW DETAILS
                                        </button>
                                    </td>                                    
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MOUZDAR ARREAR VIEW MODAL  -->
<?php include 'arrear_update_view_modal.php'; ?>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/co_arrear_update.js"></script>
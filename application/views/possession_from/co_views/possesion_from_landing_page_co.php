<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/SettlementPossesionFrom/index'?>">Settlement Wrong Possession From</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">Pending-list</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading text-center" style="background-color: #0d6836ff; color: #ffffff;">
        <h3 class="panel-title">
            <u><b><i class="fas fa-hourglass-half"></i> Pending List</b></u>
        </h3>
    </div>
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_lm_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td><i class="fas fa-file-alt"></i> CASE-NO</td>
                                <td><i class="fas fa-calendar-alt"></i>RTPS-APP-NO</td>
                                <td><i class="fas fa-map-marker-alt"></i> VILLAGE-NAME</td>
                                <td><i class="fas fa-book"></i> PATTA-NO</td>
                                <td><i class="fas fa-cogs"></i> Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($wrong_possesion_from as $row):?>                                    
                                <tr>                                    
                                    <td>
                                        <span class="font-weight-bold text-danger">
                                            <?= $row->dharitree_case_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                        <?= $row->rtps_case_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getVillageName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code, 
                                            $row->lot_no, $row->vill_townprt_code)?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-danger">
                                            <?= $row->patta_no?>
                                        <span>
                                    </td>
                                    
                                    <td>
                                         <a class="btn btn-success btn-sm text-white" 
                                            href="<?php echo base_url('index.php/SettlementPossesionFrom/viewApplicationDetailsOnly') . '?case=' . $row->dharitree_case_no; ?>" role="button" style="font-size: 14px;">
                                            View Details
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
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
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_lm.js"></script>


<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-danger text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(Pending-List)</b><br>
            </u>                        
        </h3>
    </div> 
    
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_co_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>RTPS-APPLICATION-NO</td>
                                <td>CASE-NO</td>
                                <td>VILLAGE-NAME</td>
                                <td>PATTA-NO</td>
                                <td>PATTADAR-NAME</td>
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($pendingListdpEstate as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->application_no?>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$row->case_no?>
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
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->patta_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-success">
                                            <?=$row->pdar_name?>
                                        <span>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/EkhajanaCoController/pendingCaseDetailsDpEstate/'.$row->id?>" role="button" style="font-size: 14px;">
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
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_co.js"></script>

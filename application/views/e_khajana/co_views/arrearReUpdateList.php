<!-- <?= json_encode($JamaWasilOnline)?> -->

<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaCoController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Re-Update Arrear)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(Re-Update Arrear)</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_ast_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: yellow;">
                                <td>RTPS-APPLICATION-NO</td>
                                <td>CASE-NO</td>
                                <td>DUE-PAYMENT</td>
                                <td>VILLAGE NAME</td>
                                <td>PATTA NO</td>
                                <td>PATTADAR NAME</td>
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($JamaWasilOffline as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->ld_application_no?>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$row->case_no?>
                                        <span>
                                    </td>
                                    <td>
                                    <span class="font-weight-bolder text-success">
                                            <?=$row->due_payment?>
                                    <span>
                                    </td> 
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$row->village_name?>
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
                                        <a class="btn btn-danger btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/EkhajanaCoController/arrearReUpdateForm/'.$row->id?>" role="button" style="font-size: 14px;">
                                            Re-Update Arrear
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
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>
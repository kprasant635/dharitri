<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaAstController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Pending-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-success text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(Edit Pre Arrear List)</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_ast_arrear_edit_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>VILLAGE-NAME</td>
                                <td>PATTA-TYPE</td>
                                <td>PATTA-NO</td>
                                <td>TOTAL ARREAR</td>
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($edit_pre_arrear_list as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getVillageName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code, 
                                            $row->lot_no, $row->vill_townprt_code)?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$this->utilityclass->getPattaType($row->patta_type_code)?>
                                        <span>
                                    </td>
                                    <td>
                                    <span class="font-weight-bolder text-success">
                                            <?=$row->patta_no?>
                                        <span>
                                            
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->arrear?>
                                        <span>
                                    </td>
                                    <td>
                                        <a class="btn btn-warning btn-sm text-white" 
                                            href="<?php echo base_url() . 'index.php/EkhajanaTn/editYearWiseArrear/'.$row->pre_id?>" role="button" style="font-size: 14px;">
                                            Edit Year Wise Arrear
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
<script>
    $('#ek_ast_arrear_edit_list').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true
    });
</script>


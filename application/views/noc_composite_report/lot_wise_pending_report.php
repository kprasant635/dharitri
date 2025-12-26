<div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold active" aria-current="page"><a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/registered">NOC Composite Repor</a></li>
      <li class="breadcrumb-item"><a href="#"> Lot wise applications</a></li>
    </ol>
</nav>
  <div class="panel panel-info panel-form mt-5">
      <div class="panel-heading bg-info text-center font-weight-bold">
          <h3 class="panel-title">
              <?=$header?>
          </h3>
      </div>    
      <div id="land_bank_details_added_list" class="tab-pane">
          <div class="card-body">
              <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
              <div class = "card-body">            
                      <table id="noc_composite_report_table" class="table table-hover text-center" style="width:100%!important">            
                          <thead class="thead-dark">                            
                              <tr>                                
                                  <th>Lot Name</th>
                                  <th>Lm Name</th>
                                  <th>Pending Count</th>
                              </tr>                                                        
                          </thead>
                          <tbody>
                              <?php foreach ($lotwisedetails as $row):?>                                    
                                  <tr>
                                      <td>
                                        <?=$row->lot?>                                    
                                      </td>
                                      <td><?=$row->nameoff?></td>
                                      <td><?=$row->case_count?></td>
                                  </tr>
                              <?php endforeach;?> 
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script>
$(document).ready( function () {
  $('#noc_composite_report_table').dataTable({
      "scrollX": true,
      "lengthMenu": [ [4, 8, -1], [4, 8, "All"] ],
      "pageLength": 8,
      //"autoWidth":false,
      responsive: true
  });
});
</script>
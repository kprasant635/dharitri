<div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold active" aria-current="page"><a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/registered">NOC Composite Report</a></li>
      <li class="breadcrumb-item"><a href="#"> District wise applications</a></li>
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
                                  <th>Circle Name</th>
                                  <th>Total</th>
                                  <th>LM</th>
                                  <th>CO</th>
                                  <th>ADC</th>
                                  <th>DC</th>
                                  <th>SRO/NOC-Issued</th>
                                  <th>Deed-Registered</th>
                              </tr>                                                        
                          </thead>
                          <tbody>
                              <?php foreach ($result as $row):?>                                    
                                  <tr>
                                      <td>
                                          <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/lotwisepending/<?=$row['dist_code']?>/<?=$row['subdiv_code']?>/<?=$row['cir_code']?>?flag=<?=$flag?>">
                                              <u><?=$row['circle_name']?></u>
                                          </a>                                        
                                      </td>
                                      <td><?=$row['total_pending_count']?></td>                                      
                                      <td><?=$row['pendingWithLmCount']?></td>                                                                            
                                      <td><?=$row['pendingWithCoCount']?></td>
                                      <td><?=$row['pendingWithAdcCount']?></td>
                                      <td><?=$row['pendingWithDcCount']?></td>
                                      <td><?=$row['pending_with_sro_count']?></td>
                                      <td><?=$row['completion_of_deed_count']?></td>
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
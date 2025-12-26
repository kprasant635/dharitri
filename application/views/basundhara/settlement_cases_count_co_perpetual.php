<link href="<?php echo base_url(); ?>application/views/css/dataTableButton.css" rel="stylesheet" /> 
<style>
    
    .tenant{
        background-color : #9b8f83 !important;
        border-bottom-width: 0px;
    }
    .AP{
        background-color : #fb010159 !important;
        border-bottom-width: 0px;
    }
    .tribal{
        background-color : #0b405452 !important;
        border-bottom-width: 0px;
    }
    .khasland{
        background-color : #3333337a !important;
        border-bottom-width: 0px;
    }
    .bgrpgr{
        background-color : #8cc152a3 !important;
        border-bottom-width: 0px;
    }
    .cultivator{
        background-color : #6640409c !important;
        border-bottom-width: 0px;
    }

</style>

<script type="text/javascript">  
        var exportThis = (function () {  
            var uri = 'data:application/vnd.ms-excel;base64,',  
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"  xmlns="http://www.w3.org/TR/REC-html40"><head> <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets> <x:ExcelWorksheet><x:Name>{worksheet}</x:Name> <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions> </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook> </xml><![endif]--></head><body> <table>{table}</table></body></html>',  
                base64 = function (s) {  
                    return window.btoa(unescape(encodeURIComponent(s)))  
                },  
                format = function (s, c) {  
                    return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })  
                }  
            return function () {  
                var ctx = { worksheet: 'Multi Level Export Table Example' || 'Worksheet', table: document.getElementById("multiLevelTable").innerHTML }  
                window.location.href = uri + base64(format(template, ctx))  
            }  
        })()  
        var exportThisAll = (function () {  
            var uri = 'data:application/vnd.ms-excel;base64,',  
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"  xmlns="http://www.w3.org/TR/REC-html40"><head> <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets> <x:ExcelWorksheet><x:Name>{worksheet}</x:Name> <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions> </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook> </xml><![endif]--></head><body> <table>{table}</table></body></html>',  
                base64 = function (s) {  
                    return window.btoa(unescape(encodeURIComponent(s)))  
                },  
                format = function (s, c) {  
                    return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })  
                }  
            return function () {  
                var ctx = { worksheet: 'Multi Level Export Table Example' || 'Worksheet', table: document.getElementById("multiLevelTableAll").innerHTML }  
                window.location.href = uri + base64(format(template, ctx))  
            }  
        })()  
</script>

  <div class="container-fluid">
  <div class="col-lg-12">
      
    <div class="row">
      <p class="uni_text">Total No. of Perpetual Case(s) in the District </p>

        <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Received: <kbd id='circle'><?=$output->data->recieved;?></kbd>   
                </div>
              </div>
            </div>

            <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Pending: <kbd id='circle'><?=$output->data->pending;?></kbd>   
                </div>
              </div>
            </div>
            <div class="col-lg-3">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Delivered: <kbd id='circle'><?=$output->data->delivered;?></kbd>  
                </div>
              </div>
            </div>
              <div class="col-lg-3">
              <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Rejected: <kbd id='circle'><?=$output->data->rejected;?></kbd>  
                </div>
              </div>
            </div>
          </div>
        </div>

      <!--third Row Start-->
    <div class="mt-5 col-lg-12 " style="overflow-x:auto;"> 
    <div class="row">
    <hr>
    <!-- <p class="uni_text">Total Case Details of Basundhara 2.0 service wise </p> -->
    

    <section class="">
    <button onclick="exportThis()" class="btn btn-sm btn-success">Export to Excel</button>
    <h4 class="text-center">Detail of service </h4>
   
    <div class="d-flex justify-content-between align-items-center">

    <table class="table table-bordered table-sm" id="multiLevelTable">

    <thead>
      <tr>
        <th rowspan="3" scope="col" class="align-middle" scope="col">#</th>
        <th rowspan="3" scope="col" class="align-middle" scope="col">Circle</th>
        <th  colspan="24" scope="col" class="text-center">SETTLEMENT</th>
      </tr>
      <tr class="text-center">

        <th colspan="4" class="text-center tenant">TENANT</th>
        <th colspan="4" class="text-center khasland">KHAS LAND</th>
        <th colspan="4" class="text-center cultivator">SPECIAL CULTIVATORS</th>
        
      </tr>
       <tr class="text-center">
        <th class="tenant"> Received</th>
        <th class="tenant"> Pending</th>
        <th class="tenant"> Delivered</th>
        <th class="tenant"> Rejected</th>
       
        
        <th class="khasland"> Received</th>
        <th class="khasland"> Pending</th>
        <th class="khasland"> Delivered</th>
        <th class="khasland"> Rejected</th>
       
        <th class="cultivator"> Received</th>
        <th class="cultivator">Pending</th>
        <th class="cultivator">Delivered</th>
        <th class="cultivator">Rejected</th>
      </tr>

     
    </thead>
    <tbody>
     
     
      <tr>
        <td scope="row"></td>
        <td><a href="" title=""></a><?=$this->utilityclass->getCircleName($output->data1->dist_code,$output->data1->subdiv_code,$output->data1->cir_code)?></td>
      
       <td class="text-sm text-right">
            <span class=""><?=$output->data1->socc_recieved ;?></span> 
        </td>
                       

         <td class="text-sm text-right">
            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_TENANT_ID?>">
                <i class="fa fa-eye" aria-hidden="true"></i>
                <span class=""><?=$output->data1->socc_pending ;?> </span>
            </a>
          </td>

        <td class="text-sm text-right">
                          <span class=""> <?=$output->data1->socc_delivered ;?> </span>
                        </td>
        <td class="text-sm text-right">
                          <span class=""><?=$output->data1->socc_rejected ;?></span>
                        </td>
           
          
            
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->skha_recieved ;?></span>
                        </td>
          
             <td class="text-sm text-right">
             <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_KHAS_LAND_ID?>">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                          <span class=""><?=$output->data1->skha_pending ;?></span>
             </a>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->skha_delivered ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->skha_rejected ;?></span>
                        </td>
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->stea_recieved ;?></span>
                        </td>
          
             <td class="text-sm text-right">
             <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_SPECIAL_CULTIVATORS_ID?>">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                          <span class=""><?=$output->data1->stea_pending ;?></span>
             </a>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->stea_delivered ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->stea_rejected ;?></span>
                        </td>
          
      </tr>

    </tbody>
  </table>
  </div>
  </section>
    </div>
    </div>

    <div class="mt-5 col-lg-12" style="overflow-x:auto;"> 
    <div class="row">
    <hr>

    <section class="">
    <button onclick="exportThisAll()" class="btn btn-sm btn-success">Export to Excel</button>
    <h4 class="text-center">Detail of service Lot wise</h4>
   
    <div class="d-flex justify-content-between align-items-center">

    <table class="table table-bordered table-sm" id="multiLevelTableAll">

    <thead>
      <tr>
        <th rowspan="3" scope="col" class="align-middle" scope="col">#</th>
        <th rowspan="3" scope="col" class="align-middle" scope="col">Mouza</th>
        <th rowspan="3" scope="col" class="align-middle" scope="col">Lot</th>
        <th  colspan="24" scope="col" class="text-center">SETTLEMENT</th>
      </tr>
      <tr class="text-center">

        <th colspan="4" class="text-center tenant">TENANT</th>
        
        <th colspan="4" class="text-center khasland">KHAS LAND</th>

        <th colspan="4" class="text-center cultivator">SPECIAL CULTIVATORS</th>
        
      </tr>
       <tr class="text-center">
        <th class="tenant"> Received</th>
        <th class="tenant"> Pending<br> (% wise)
        </th>
        <th class="tenant"> Delivered<br> (% wise)</th>
        <th class="tenant"> Rejected<br> (% wise)</th>
        
       
        <th class="khasland"> Received</th>
        <th class="khasland"> Pending<br> (% wise)</th>
        <th class="khasland"> Delivered<br> (% wise)</th>
        <th class="khasland"> Rejected<br> (% wise)</th>
       
        <th class="cultivator"> Received</th>
        <th class="cultivator">Pending<br> (% wise)</th>
        <th class="cultivator">Delivered<br> (% wise)</th>
        <th class="cultivator">Rejected<br> (% wise)</th>
      </tr>

     
    </thead>
    <tbody>
      <?php $i=1; foreach($output->data2 as $cirData): ?>

     
      <tr>
        <td scope="row"><?=$i++?></td>
        <td><a href="" title=""></a><?=$this->utilityclass->getMouzaName($cirData->dist_code,$cirData->subdiv_code,$cirData->cir_code,$cirData->mouza_pargona_code)?></td>
        <td><a href="" title=""></a><?=$this->utilityclass->getLotName($cirData->dist_code,$cirData->subdiv_code,$cirData->cir_code,$cirData->mouza_pargona_code,$cirData->lot_no)?></td>

       <td class="text-sm text-right">
                          <span class=""><?=($cirData->socc_recieved)==null?"0":($cirData->socc_recieved)?></span><br>
                        </td>

         <td class="text-sm text-right">
                          <span class=""><?=($cirData->socc_pending)==null?"0":(($cirData->socc_pending)) ;?> </span><br>
                            <span class="">
                              <?php if($cirData->socc_recieved!=0){
                               echo '('. number_format(((($cirData->socc_pending)/($cirData->socc_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>

        <td class="text-sm text-right">
                          <span class=""><?=($cirData->socc_delivered)==null?"0":($cirData->socc_delivered) ;?> </span><br>
                          <span class="">
                              <?php if($cirData->socc_recieved!=0){
                               echo '('. number_format(((($cirData->socc_delivered)/($cirData->socc_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
        <td class="text-sm text-right">
                          <span class=""><?=($cirData->socc_rejected)==null?"0":($cirData->socc_rejected) ;?></span><br>
                          <span class="">
                              <?php if($cirData->socc_recieved!=0){
                               echo '('. number_format(((($cirData->socc_rejected)/($cirData->socc_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
           
          
          
           
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->skha_recieved)==null?"0":($cirData->skha_recieved) ;?></span><br>                       </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->skha_pending)==null?"0":($cirData->skha_pending) ;?></span><br>                       <span class="">
                              <?php if($cirData->skha_recieved!=0){
                               echo '('. number_format(((($cirData->skha_pending)/($cirData->skha_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->skha_delivered)==null?"0":($cirData->skha_delivered) ;?></span><br>
                          <span class="">
                              <?php if($cirData->skha_recieved!=0){
                               echo '('. number_format(((($cirData->skha_delivered)/($cirData->skha_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->skha_rejected)==null?"0":($cirData->skha_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->skha_recieved!=0){
                               echo '('. number_format(((($cirData->skha_rejected)/($cirData->skha_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
          
             
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->stea_recieved)==null?"0":($cirData->stea_recieved) ;?></span><br>                       </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->stea_pending)==null?"0":($cirData->stea_pending) ;?></span><br>                       <span class="">
                              <?php if($cirData->stea_recieved!=0){
                               echo '('. number_format(((($cirData->stea_pending)/($cirData->stea_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->stea_delivered)==null?"0":($cirData->stea_delivered) ;?></span><br>
                           <span class="">
                              <?php if($cirData->stea_recieved!=0){
                               echo '('. number_format(((($cirData->stea_delivered)/($cirData->stea_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->stea_rejected)==null?"0":($cirData->stea_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->stea_recieved!=0){
                               echo '('. number_format(((($cirData->stea_rejected)/($cirData->stea_recieved))*100),1).'%)';
                                
                              }else{
                                echo '(NA)';
                              }?>

                            </span>
                        </td>
          

          
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>
  

  </div>
  </section>
    </div>
    </div>
</div>
<style type="text/css">
  .card-body{  background: #7b4397; /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #7b4397, #dc2430); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #7b4397, #dc2430); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */);}
  #circle {
    background: #0f546a;
    border-radius: 30%;
    padding: 7px !important;
    font-weight: bold;
    font-size: 2em;
    }
</style>

<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script>
<script type="text/javascript">  
$(document).ready( function () {
    $('#mb2report').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 20,
        //"autoWidth":false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download"></i> Download As Excel',
                titleAttr: 'Excel',
                title: "Basundhara 2.0 Cases Circle Wise",
            }, 
        ],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-info btn-sm');
            btns.removeClass('dt-button');
        }
    });
});
</script>


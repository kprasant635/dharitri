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
      <p class="uni_text">Total No. of Basundhara 2.0 Review Geotag Details in the Circle <?=$output->data->circle?></p>

        <div class="col-lg-4">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Application Received: <kbd id='circle'><?=$output->data->recieved;?></kbd>   
                </div>
              </div>
            </div>

            <div class="col-lg-4">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Geotag Photo Uploaded: <kbd id='circle'><?=$output->data->uploaded;?></kbd>   
                </div>
              </div>
            </div>
            <div class="col-lg-4">
          <div class="card">
                <div class="card-body text-white">
                  <h4></h4>
                  Geotag Pending: <kbd id='circle'><?=$output->data->pending;?></kbd>  
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
    <h4 class="text-center">Geotag Details of service wise <?=$output->data->circle?></h4>
   
    <div class="d-flex justify-content-between align-items-center">

    <table class="table table-bordered table-sm" id="multiLevelTable">

    <thead>
      <tr>
        <th rowspan="3" scope="col" class="align-middle" scope="col">#</th>
        <th rowspan="3" scope="col" class="align-middle" scope="col">Circle</th>
        <th  colspan="18" scope="col" class="text-center">SETTLEMENT</th>
      </tr>
      <tr class="text-center">

        <th colspan="3" class="text-center tenant">TENANT</th>
        <th colspan="3" class="text-center AP">AP TRANSFER</th>
        <th colspan="3" class="text-center tribal">TRIBAL</th>
        <th colspan="3" class="text-center khasland">KHAS LAND</th>
        <th colspan="3" class="text-center bgrpgr">PGR VGR LAND</th>
        <th colspan="3" class="text-center cultivator">SPECIAL CULTIVATORS</th>
        
      </tr>
      <tr class="text-center">
        <th class="tenant"> Received</th>
        <th class="tenant"> Completed</th>
        <th class="tenant"> Pending</th>
        <th class="AP">     Received</th>
        <th class="AP">     Completed</th>
        <th class="AP">     Pending</th>
        <th class="tribal"> Received</th>
        <th class="tribal"> Completed</th>
        <th class="tribal"> Pending</th>
        <th class="khasland"> Received</th>
        <th class="khasland"> Completed</th>
        <th class="khasland"> Pending</th>
        <th class="bgrpgr"> Received</th>
        <th class="bgrpgr"> Completed</th>
        <th class="bgrpgr"> Pending</th>
        <th class="cultivator"> Received</th>
        <th class="cultivator">Completed</th>
        <th class="cultivator">Pending</th>
      </tr>

     
    </thead>
    <tbody>
     
     
      <tr>
        <td scope="row"></td>
        <td><a href="" title=""></a><?=$output->data1->circle?></td>
      
       <td class="text-sm text-right">
            <span class=""><?=$output->data1->tenant_recieved ;?></span> 
        </td>
                       

         <td class="text-sm text-right">
            
                <span class=""><?=$output->data1->tenant_uploaded ;?> </span>
            
          </td>

        <td class="text-sm text-right">
                          <span class=""> <?=$output->data1->tenant_pending ;?> </span>
                        </td>
        
           <td class="text-sm text-right">
                          <span class=""><?=$output->data1->ap_recieved ;?></span>
                        </td>
         <td class="text-sm text-right">
                          
                            <span class=""><?=$output->data1->ap_uploaded ;?></span>
                        </td>
          
           <td class="text-sm text-right">
                          <span class=""><?=$output->data1->ap_pending ;?></span>
                        </td>
          
            
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->tribal_recieved ;?></span>
                        </td>
          
             <td class="text-sm text-right">
             
                          <span class=""><?=$output->data1->tribal_uploaded ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->tribal_pending ;?></span>
                        </td>
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->khas_recieved ;?></span>
                        </td>
          
             <td class="text-sm text-right">
             
                          <span class=""><?=$output->data1->khas_uploaded ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->khas_pending ;?></span>
                        </td>
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->pgr_recieved ;?></span>
                        </td>
          
             <td class="text-sm text-right">
             
                          <span class=""><?=$output->data1->pgr_uploaded ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->pgr_pending ;?></span>
                        </td>
          
            
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->tea_recieved ;?></span>
                        </td>
          
             <td class="text-sm text-right">
             
                          <span class=""><?=$output->data1->tea_uploaded ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=$output->data1->tea_pending ;?></span>
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
    <h4 class="text-center">Geotag Details of lot wise  <?=$output->data->circle?></h4>
   
    <div class="d-flex justify-content-between align-items-center">

    <table class="table table-bordered table-sm" id="multiLevelTableAll">

    <thead>
      <tr>
        <th rowspan="3" scope="col" class="align-middle" scope="col">#</th>
        <th rowspan="3" scope="col" class="align-middle" scope="col">Mouza</th>
        <th rowspan="3" scope="col" class="align-middle" scope="col">Lot</th>
        <th  colspan="18" scope="col" class="text-center">SETTLEMENT</th>
      </tr>
      <tr class="text-center">

        <th colspan="3" class="text-center tenant">TENANT</th>
        <th colspan="3" class="text-center AP">AP TRANSFER</th>
        <th colspan="3" class="text-center tribal">TRIBAL</th>
        <th colspan="3" class="text-center khasland">KHAS LAND</th>
        <th colspan="3" class="text-center bgrpgr">PGR VGR LAND</th>
        <th colspan="3" class="text-center cultivator">SPECIAL CULTIVATORS</th>
        
      </tr>
       <tr class="text-center">
        <th class="tenant"> Received</th>
        <th class="tenant"> Completed</th>
        <th class="tenant"> Pending</th>
        <th class="AP"> Received</th>
        <th class="AP"> Completed</th>
        <th class="AP"> Pending</th>
        
        <th class="tribal"> Received</th>
        <th class="tribal"> Completed</th>
        <th class="tribal"> Pending</th>
        
        <th class="khasland"> Received</th>
        <th class="khasland"> Completed</th>
        <th class="khasland"> Pending</th>
        
        <th class="bgrpgr"> Received</th>
        <th class="bgrpgr"> Completed</th>
        <th class="bgrpgr"> Pending</th>
        
        <th class="cultivator"> Received</th>
        <th class="cultivator">Completed</th>
        <th class="cultivator">Pending</th>
        
      </tr>

     
    </thead>
    <tbody>
      <?php $i=1; foreach($output->data2 as $cirData): ?>

     
      <tr>
        <td scope="row"><?=$i++?></td>
        <td><a href="" title=""></a><?=$cirData->mouza?></td>
        <td><a href="" title=""></a><?=$cirData->lot?></td>

        <td class="text-sm text-right">
                          <span class=""><?=($cirData->tenant_recieved)==null?"0":($cirData->tenant_recieved)?></span><br>
                        </td>

         <td class="text-sm text-right">
                          <span class=""><?=($cirData->tenant_uploaded)==null?"0":(($cirData->tenant_uploaded)) ;?> </span>
                        </td>

        <td class="text-sm text-right">
                          <span class=""><?=($cirData->tenant_pending)==null?"0":($cirData->tenant_pending) ;?> </span>
                        
                        </td>
       
           <td class="text-sm text-right">
                          <span class=""><?=($cirData->ap_recieved)==null?"0":($cirData->ap_recieved) ;?></span><br>
                        </td>
         <td class="text-sm text-right">
                          <span class=""><?=($cirData->ap_uploaded)==null?"0":($cirData->ap_uploaded) ;?></span>
                        </td>
          
           <td class="text-sm text-right">
                          <span class=""><?=($cirData->ap_pending)==null?"0":($cirData->ap_pending) ;?></span>
                        </td>
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->tribal_recieved)==null?"0":($cirData->tribal_recieved) ;?></span><br>                       </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->tribal_uploaded)==null?"0":($cirData->tribal_uploaded) ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->tribal_pending)==null?"0":($cirData->tribal_pending) ;?></span>
                        </td>
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->khas_recieved)==null?"0":($cirData->khas_recieved) ;?></span>                     
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->khas_uploaded)==null?"0":($cirData->khas_uploaded) ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->khas_pending)==null?"0":($cirData->khas_pending) ;?></span>
                        </td>
          
             
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->pgr_recieved)==null?"0":($cirData->pgr_recieved) ;?></span><br>                       </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->pgr_uploaded)==null?"0":($cirData->pgr_uploaded) ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->pgr_pending)==null?"0":($cirData->pgr_pending) ;?></span>
                        </td>
          
            
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->tea_recieved)==null?"0":($cirData->tea_recieved) ;?></span><br>                       </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->tea_uploaded)==null?"0":($cirData->tea_uploaded) ;?></span>
                        </td>
          
             <td class="text-sm text-right">
                          <span class=""><?=($cirData->tea_pending)==null?"0":($cirData->tea_pending) ;?></span>
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


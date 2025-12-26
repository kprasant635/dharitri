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

 <!--third Row Start-->
 <div class="mt-5 col-lg-12 " style="overflow-x:auto;"> 
    <div class="row">
    <hr>
    
    <section class="">
    <button onclick="exportThis()" class="btn btn-sm btn-success">Export to Excel</button>
    <h4 class="text-center">Detail of E-Khajana details Lot Wise </h4>
   
    <div class="d-flex justify-content-between align-items-center">

    <table class="table table-bordered table-sm" id="multiLevelTable">

    <thead>
        <tr>
                <th rowspan="2" scope="col" class="align-middle" scope="col">MOUZA NAME</th>
                <th rowspan="2" scope="col" class="align-middle" scope="col">LOT NAME</th>
                <th  colspan="5" scope="col" class="text-center">E-KHAJANA</th>
        </tr>
        <tr class="text-center">
                <th class="Ekhajana"> Received</th>
                <th class="Ekhajana"> Pending</th>
                <th class="Ekhajana"> Delivered(Payment-Received)</th>
                <th class="Ekhajana"> Rejected</th>
                <th class="Ekhajana"> View case detail</th>
        </tr>
    </thead>
    <tbody>
      
       
        <?php foreach($lot_details as $row): ?>
            <tr>
            <td class="text-sm text-center"><a href="" title=""></a><?=$this->utilityclass->getMouzaName($row->dist_code,$row->subdiv_code, $row->cir_code, $row->mouza_pargona_code);?></td>
            <td><a href="" title=""></a><?=$row->lot_name?></td>
            
            <td class="text-sm text-right">
                <span class=""><?=$row->registered_app_count ;?></span> 
            </td>
            <td class="text-sm text-right">
              
                    <span class=""><?=$row->pending_app_count ;?> </span>
                </a>
            </td>
            <td class="text-sm text-right">
                <span class=""> <?=$row->delivered_app_count ;?> </span>
            </td>
            <td class="text-sm text-right">
                <span class=""><?=$row->rejected_app_count;?></span>
            </td>
            <td class="text-sm text-center">
            <a href="<?=base_url().'index.php/EkhajanaReportController/viewCaseDetail/'.$row->mouza_pargona_code.'/'.$row->lot_no?>">
                    <i class="fa fa-eye" aria-hidden="true"></i>
            </td>
            </tr>
        <?php endforeach;?>
    </tbody>
  </table>
  </div>
  </section>
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
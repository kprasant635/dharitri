<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<link href="<?php echo base_url(); ?>application/views/css/dataTableButton.css" rel="stylesheet" />
<script>
document.onreadystatechange = function(e)
{
    $.blockUI({ 
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });    
};
window.onload = function(){   
    $.unblockUI();
}
</script>
<style>
.buttons-excel {
  left: 15%;
  background-color: orange;
  color: white!important;
}
.buttons-csv {
  left: 15%;
  background-color: grey;
  color: white!important;
}
</style>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/LandBankCO/index'?>">Village Land Bank</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank Report-(Village-list)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center font-weight-bold">
        <h3 class="panel-title">
            Village Land Bank Report-(Village-Wise)                       
        </h3>
    </div>    
    <div id="land_bank_details_added_list" class="tab-pane">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                    <table id="land_bank_rpt_dt" class="table table-hover text-center" style="width:100%!important">            
                        <thead class="thead-dark">                            
                            <tr>
                                <th class="center"><label class="control-label">District<br>Name</label></th>
                                <th class="center"><label class="control-label">Subdivision<br>Name</label></th>
                                <th class="center"><label class="control-label">Circle<br>Name</label></th>
                                <th class="center"><label class="control-label">Mouza<br>Name</label></th>
                                <th class="center"><label class="control-label">Lot<br>No</label></th>
                                <th class="center"><label class="control-label">Village<br>Name</label></th>
                                <th class="center"><label class="control-label">Total<br>Encroached<br>Area</label></th>
                                <th class="center"><label class="control-label">VGR<br>Count</label></th>
                                <th class="center"><label class="control-label">PGR<br>Count</label></th>
                                <th class="center"><label class="control-label">Road<br>Side<br>Reserve<br>Count</label></th>
                                <th class="center"><label class="control-label">River<br>Side<br>Reserve<br>Count</label></th>
                                <th class="center"><label class="control-label">Wetland/<br>Jalatan<br>Count</label></th>
                                <th class="center"><label class="control-label">Govt Khas<br>Land<br>Count</label></th>
                                <th class="center"><label class="control-label">Govt Ceiling<br>Land<br>Count</label></th>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($reportData as $rptData):?>                                    
                                <tr>
                                    <td><?=$rptData['district_name']?></td>
                                    <td><?=$rptData['subdiv_name']?></td>
                                    <td><?=$rptData['circle_name']?></td>
                                    <td><?=$rptData['mouza_name']?></td>
                                    <td><?=$rptData['lot_name']?></td>
                                    <td><?=$rptData['village_name']?></td>
                                    <td>B-<?=$rptData['total_bigha']?><br>K-<?=$rptData['total_katha']?><br>L-<?=$rptData['total_lessa']?></td>
                                    <td><?=$rptData['vgr_count']?></td>
                                    <td><?=$rptData['pgr_count']?></td>
                                    <td><?=$rptData['road_side_reserve_count']?></td>
                                    <td><?=$rptData['river_side_reserve_count']?></td>
                                    <td><?=$rptData['wetland_count']?></td>
                                    <td><?=$rptData['govt_khas_land_count']?></td>
                                    <td><?=$rptData['govt_ceiling_land_count']?></td>
                                </tr>
                            <?php endforeach;?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script>
<script type="text/javascript">  
$(document).ready( function () {
    $('#land_bank_rpt_dt').dataTable({
        "scrollX": true,
        "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
        "pageLength": 4,
        //"autoWidth":false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download"></i> Download As Excel',
                titleAttr: 'Excel',
                title: "Land Bank",
            }, 
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-download"></i> Download As CSV',
                titleAttr: 'CSV'
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

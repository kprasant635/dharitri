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
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center font-weight-bold">
        <h3 class="panel-title">
            Khatian Report-(Lot-Wise)                       
        </h3>
    </div>    
    <div id="land_bank_details_added_list" class="tab-pane">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                    <table id="land_bank_rpt_dt" class="table table-hover text-center" style="width:100%!important">            
                        <thead class="thead-dark">                            
                            <tr>                                
                                <th>Mouza Name</th>
                                <th>Lot Name</th>
                                <th>Total Pending Count</th>
                                <th>Total Approved Count</th>
                                <th>Total Raytee Count</th>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($lot_wise_report_data as $rptData):?>                                    
                                <tr>
                                    <td class="text-primary"><?=$this->utilityclass->getMouzaName($rptData['dist_code'], $rptData['subdiv_code'], $rptData['cir_code'], $rptData['mouza_pargona_code'])?></td>
                                    <td>
                                        <a href="<?php echo base_url() . 'index.php/Khatian/VillageWiseReport/'.$rptData['mouza_pargona_code'].'/'.$rptData['lot_no'] ?>" class="text-danger">
                                            <u><?=$this->utilityclass->getLotName($rptData['dist_code'], $rptData['subdiv_code'], $rptData['cir_code'], $rptData['mouza_pargona_code'], $rptData['lot_no'])?></u>
                                        </a>                                        
                                    </td>
                                    <td><?=$rptData['pending']?></td>
                                    <td><?=$rptData['approved']?></td>
                                    <td><?=$rptData['raytee']?></td>
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
        "pageLength": 20,
        //"autoWidth":false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-download"></i> Download As Excel',
                titleAttr: 'Excel',
                title: "Land Bank Report Lot Wise",
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
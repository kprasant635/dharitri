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
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Village Land Bank Report-(Circle-Wise)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center font-weight-bold">
        <h3 class="panel-title">
            Village Land Bank Report-(Circle-Wise)                       
        </h3>
    </div>    
    <div class="panel-heading bg-warning text-center">
        <h6 class="panel-title font-weight-bold" style="font-size:14px;">
            TOTAL-GOVT-DAG(DISTRICT): <?=$total_govt_dag_in_district?>,
            TOTAL-DAG-UPDATED(DISTRICT) : <?=$total_updated_by_lm_dag?>,
            TOTAL-DAG-APPROVED(DISTRICT) : <?=$total_approved_by_co_dag?>
            
        </h6>
    </div>
    <div id="land_bank_details_added_list" class="tab-pane">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
            <div class = "card-body">            
                    <table id="land_bank_rpt_dt" class="table table-hover text-center" style="width:100%!important">            
                        <thead class="thead-dark">                            
                            <tr>                                
                                <th>Circle Name</th>
                                <th>Total Govt Dag</th>
                                <th>Total Approved Count</th>
                                <th>Total Rejected Count</th>
                                <th>Total Pending With CO Count</th>
                                <th>Total Dag Pending</th>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($circle_wise_report_data as $rptData):?>                                    
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url() . 'index.php/LandBankReport/VillageWiseReportFromCircle/'.$rptData['dist_code'].'/'.$rptData['subdiv_code'].'/'.$rptData['cir_code'] ?>" class="text-danger">
                                            <u><?=$this->utilityclass->getCircleName($rptData['dist_code'], $rptData['subdiv_code'], $rptData['cir_code'])?></u>
                                        </a>                                        
                                    </td>
                                    <td><?=$rptData['total_govt_dags']?></td>
                                    <td><?=$rptData['approved_count']?></td>
                                    <td><?=$rptData['rejected_count']?></td>
                                    <td><?=$rptData['pending_with_co_count']?></td>
                                    <td><?=$rptData['overall_pending']?></td>
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
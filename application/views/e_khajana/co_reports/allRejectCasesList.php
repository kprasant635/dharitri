<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
      <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaReportController/index'?>">E-Khajana</a></li>
      <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Reports)</li>
  </ol>
</nav>
<div class="panel panel-info panel-form mt-5" >
    <div class="panel-heading bg-warning text-center">
        <h3 class="panel-title">
            <u>
                <b>E-Khajana-(Reject cases List)</b><br>
            </u>                        
        </h3>
    </div> 
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table id="ek_ast_pending_list" class="table table-hover text-center" style="width:100%">            
                        <thead class="thead-dark">                            
                            <tr style="background-color: black; color: #fff;">
                                <td>RTPS-APPLICATION-NO</td>
                                <td>CASE-NO</td>
                                <td>VILLAGE</td>
                                <td>PATTA-NO</td>
                                <td>PATTADAR-NAME</td>
                                <td>ACTION</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php foreach ($rejectList as $row):?> 
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder text-danger">
                                            <?=$row->application_no?>
                                    </td>
                                    <td>
                                        <span class="font-weight-bolder text-success">
                                            <?=$row->case_no?>
                                        <span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-primary">
                                            <?=$this->utilityclass->getVillageName($row->dist_code,
                                            $row->subdiv_code, 
                                            $row->cir_code, $row->mouza_pargona_code, 
                                            $row->lot_no, $row->vill_townprt_code)?>
                                        <span>  
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
                                        <button type="button" class="btn btn-success btn-sm" onclick="viewRejectModal(`<?=$row->co_remark?>`,`<?=$row->lm_remark?>`,`<?=$row->mou_remark?>`)"> <i class="fa fa-eye"></i> VIEW REASON</button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div id="rejectModal" class="modal shadow-lg " style="border 5px solid black" role="dialog">
                    <div class="modal-dialog modal-sm modal-dialog-centered" style="max-width:70%">
                        <div class="modal-content">
                            <div class="modal-body" id="rejectmodalbody">
                                <div class="form-group">
                                    <div style="max-height: 500px; overflow-y: scroll;">
                                        <table class="table table-striped table-bordered">
                                            <thead style="white-space:nowrap; width:100%">
                                                <tr class="text-bold bg-danger">
                                                    <th style="text-align:center" width="90%">Reject Reasons</th>
                                                </tr>
                                            </thead>
                                            <th>Reject Remarks Of CO</th>
                                            <tbody id="reject_body"></tbody>
                                            <th>Remarks Of LM</th>
                                            <tbody id="reject_body_lm"></tbody>
                                            <th>Remarks Of Mouzadar</th>
                                            <tbody id="reject_body_mou"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="close_reject_modal" class="btn btn-danger btn" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function viewRejectModal(co_remark,lm_remark,mou_remark)
    {
        console.log(co_remark.split(','));
        let reject_remarks = co_remark.split(',');
         $('#reject_body').empty();
        let c = 1;
        reject_remarks.forEach(function(remark) {
            let row = '<tr><td>' + c++ +')' +'&nbsp;' + remark + '</td></tr>';
            $('#reject_body').append(row);
        });
        $('#reject_body_lm').append(lm_remark);
        $('#reject_body_mou').append(mou_remark);
        $('#rejectModal').show(500);
    }
    //function to close modal 
    $(document).on('click', '#close_reject_modal', function () {
        $('#rejectModal').hide(500);
        location.reload(true);
    });
</script>
<script src="<?php echo base_url(); ?>application/views/js/e_khajana/ekhajana_ast.js"></script>

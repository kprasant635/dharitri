<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
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

<div class="panel panel-info panel-form mt-5">
    <div class="panel-heading bg-info text-center">
        <h3 class="panel-title">
            <u>
                Chitha Flag Mapping - (Pending-List) : Circle - <?php echo $this->utilityclass->getCircleName($dist_code,$subdiv_code,$circle_code); ?>, 
            </u>                        
        </h3>
    </div>
    
    <div class="tab-content">
        <div class="card-body">
            <div class="card-body shadow-lg p-1 mb-5 bg-white rounded">                              
                <div class = "card-body">            
                    <table class="table table-hover text-center" style="width:100%" id="example">            
                        <thead class="">                            
                            <tr>
                                <td>Sl no.</td>
                                <td>Village-Name</td>
                                <td>Action</td>
                            </tr>                                                        
                        </thead>
                        <tbody>
                            <?php $count=1; foreach ($pending_list as $pending):?>                                    
                                <tr>
                                    <td><?=$count++;?> </td>
                                    <td>
                                        <span class="text-primary font-weight-bold" id="lb_view_village_name">
                                            <?= $this->utilityclass->getVillageName($pending->dist_code, $pending->subdiv_code, 
                                            $pending->cir_code, $pending->mouza_pargona_code, $pending->lot_no, $pending->vill_townprt_code)?>
                                        </span>                                     
                                    </td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm text-white" onclick="PendingVillageFlagDetailsApproved('<?=$pending->dist_code;?>', '<?=$pending->subdiv_code;?>', 
                                            '<?=$pending->cir_code;?>', '<?=$pending->mouza_pargona_code;?>', '<?=$pending->lot_no;?>', '<?=$pending->vill_townprt_code;?>')">
                                            <i class="fa fa-eye"></i>
                                            View & Approved
                                        </button>
                                    </td>
                                     
                                    <!-- <td>
                                        <button type="button" class="btn btn-danger btn-sm text-white" onclick="PendingVillageFlagDetailsReject('<?=$pending->dist_code;?>', '<?=$pending->subdiv_code;?>', 
                                            '<?=$pending->cir_code;?>', '<?=$pending->mouza_pargona_code;?>', '<?=$pending->lot_no;?>', '<?=$pending->vill_townprt_code;?>')">
                                            <i class="fa fa-arrow-left"></i>
                                            Revert to LM
                                        </button>
                                    </td>    -->                           
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                    <div id="dagList"></div>
                    <div class="text-center">
                        <a href="<?=base_url().'index.php/chithaFlag/FlagIndex';?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i>BACK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function PendingVillageFlagDetailsApproved(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_code){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: '<?= base_url()?>'+ "index.php/ChithaFlag/viewPendingDagFlagVillageWise",
            type: "POST",
            data : {dist_code : dist_code , subdiv_code : subdiv_code,cir_code : cir_code,mouza_pargona_code:mouza_pargona_code,lot_no:lot_no,vill_code:vill_code,flag : 'A'},
            error: function() {
                $.unblockUI();
                Swal.fire({
                    title: "Failed",
                    text: "Error",
                    icon: "warning",
                    timer: 50000
                });
            },
            
            success: function(data) {
                $.unblockUI();
                $("#dagList").html(data); 
                $('#myLargeModalLabelDagList').modal('show');                        
            }
        });
    }


    function PendingVillageFlagDetailsReject(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_code){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: '<?= base_url()?>'+ "index.php/ChithaFlag/viewPendingDagFlagVillageWise",
            type: "POST",
            data : {dist_code : dist_code , subdiv_code : subdiv_code,cir_code : cir_code,mouza_pargona_code:mouza_pargona_code,lot_no:lot_no,vill_code:vill_code,flag:'R'},
            error: function() {
                $.unblockUI();
                Swal.fire({
                    title: "Failed",
                    text: "Error",
                    icon: "warning",
                    timer: 50000
                });
            },
            
            success: function(data) {
                $.unblockUI();
                $("#dagList").html(data); 
                $('#myLargeModalLabelDagList').modal('show');                        
            }
        });
    }

  $(document).ready(function() {
    $('#example').DataTable({
    "bLengthChange": false,
    "showNEntries" : false,
    "bSort" :   false,
    "bnew" :    false,
    "pageLength": 20
  });
  
});
</script>
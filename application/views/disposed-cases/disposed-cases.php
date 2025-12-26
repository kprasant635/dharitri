<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php 
                        if($service_type == 'field'){
                            $title = 'Disposed & Rejected Cases - Field Partition';
                        } else if($service_type == 'office') {
                            $title = 'Disposed & Rejected Cases - Office Partition';
                        } else if($service_type == 'field_mut'){
                            $title = 'Disposed & Rejected Cases - Field Mutation';
                        } else if($service_type == 'office_mut') {
                            $title = 'Disposed & Rejected Cases - Office Mutation';
                        } else if($service_type == 'allotment') {
                            $title = 'Disposed & Rejected Cases - Allotment';
                        } else if($service_type == 'area_correction') {
                            $title = 'Disposed & Rejected Cases - Area Correction';
                        }else if($service_type == 'land_reclassification'){
                            $title = 'Disposed & Rejected Cases - Land Reclassification';
                        }else if($service_type == 'name_correction'){
                            $title = 'Disposed & Rejected Cases - Name Correction';
                        }
                        
                        echo $title;
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo 'Disposed & Rejected Cases'; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" name="searchCaseNo" class="form-control col-sm-6 pull-right" placeholder="Search by Case No." value="<?php echo $searchCaseNo; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                            </div>
                        </form>
                        
                        <div id="example_wrapper" class="dataTables_wrapper no-footer" style="width:100%">
                        <table class="centertable table table-stripped table-compressed" id='disposed_data_table' role="grid" width="100%">
                            <thead class="info center">
                                <tr class="center" role="row">
                                    <th><label class="control-label">Sr No.</label></th>
                                    <th><label class="control-label">Application No.</label></th>
                                    <th class="center"><label class="control-label">Name of Applicant</label></th>
                                    <th class="center"><label class="control-label">Circle Name</label></th>
                                    <th class="center"><label class="control-label">Lot No.</th>
                                    <th class="center"><label class="control-label">Village Name</th>
                                    <th class="center"><label class="control-label">Patta No.</th>
                                    <th class="center"><label class="control-label">Dag No.</th>
                                    <th class="center"><label class="control-label">Order No.</th>
                                    <th class="center"><label class="control-label">Order Pass Date</th>
                                    <th class="center"><label class="control-label">LM Name</th>
                                    <th class="center"><label class="control-label">CO/ADC/DC Name</th>
                                    <th class="center"><label class="control-label">View CO/ADC/DC Order</th>
                                    <th class="center"><label class="control-label">View Details</th>
                                </tr>
                            </thead>
                            
                            <?php $count = '1';
                            foreach ($cases as $case):
                            
                                $lmcode = $case->lmcode;
                                if($service_type == 'field' || $service_type == 'field_mut'){
                                    if($service_type == 'field_mut'){
                                        $user_code = $case->co_code;
                                    } else {
                                        $user_code = $case->user_code;    
                                    }
                                    
                                    if($case->is_dispose == 'Y' && !empty($case->if_dispose_date)){
                                        $order_pass_date = date('d-m-Y',strtotime($case->if_dispose_date));
                                    } else if($case->order_passed == 'Y' && !empty($case->date_of_order)){
                                        $order_pass_date = date('d-m-Y',strtotime($case->date_of_order));
                                    }
                                } else if($service_type == 'office' || $service_type == 'office_mut'){
                                    if(!empty($case->co_user_code)){
                                        $user_code = $case->co_user_code;
                                    } else {
                                        $user_code = $case->user_code;
                                    }
                                    $order_pass_date = date('d-m-Y',strtotime($case->date_entry));
                                }  else if($service_type == 'allotment'){
                                    $user_code = $case->co_code;
                                    $order_pass_date = date('d-m-Y',strtotime($case->date_entry));
                                    $lmcode = $case->lm_code;
                                    $case->cir_code = $case->circle_code;
                                }  else if($service_type == 'area_correction'){
                                    $user_code = $case->co_code;
                                    $order_pass_date = date('d-m-Y',strtotime($case->status_date));
                                    $lmcode = $case->lm_code;
                                } else if($service_type == 'land_reclassification'){
                                    $lmcode = $case->lm_code;
                                    $order_pass_date = date('d-m-Y',strtotime($case->lm_date));
                                    $user_code = $case->user_code;
                                } if($service_type == 'name_correction'){
                                    $lmcode = $case->lmcode;
                                    $user_code = $case->add_to_officer;
                                    $order_pass_date = date('d-m-Y',strtotime($case->submission_date));
                                }
                                
                                $dist_code = $case->dist_code;
                                $subdiv_code = $case->subdiv_code;
                                $cir_code = $case->cir_code;
                                $mouza_pargona_code = $case->mouza_pargona_code;
                                $lot_no = $case->lot_no;
                                $vill_townprt_code = $case->vill_townprt_code;
                                $caseNo = $case->case_no;
                                $appID = $this->utilityclass->getBasundharaFromCaseNo($caseNo);
                                //$date_submission = 'NA';
                                $date_submission =  '';
                                if(!empty($appID)){
                                    //$date_submission = $this->utilityclass->getDisposedDataFromAppID($appID);
                                }
                                
                                $circle_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
                                $lot_name = $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no);
                                $village_name = $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);
                                $patta_no = $case->patta_no;
                                $dag_no = $case->dag_no;
                                if(!empty($lmcode)){
                                    $lmname = $this->utilityclass->getlmNameFromCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $lmcode);
                                } else {
                                    $lmname = '';
                                }
                                $applicant_name = $case->pdar_name;
                                $CO_name = $this->utilityclass->getNameOfUserByUserCode($user_code);
                                
                                if($service_type == 'land_reclassification' || $service_type == 'area_correction'){
                                    if($case->pdar_id  != ''){
                                        $applicant_name = $this->utilityclass->getPdarName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $case->pdar_id, $dag_no);    
                                    } else {
                                        $applicant_name = '-';
                                    }
                                }
                                
                                if($CO_name == ''){
                                    $CO_name = '-';
                                }
                                
                                /*if($service_type == 'area_correction'){
                                    echo 'here';
                                    if(!empty($appID)){
                                        echo $appID;
                                        $disposedData = $this->utilityclass->getDisposedDataFromAppID($appID);    
                                         //echo '<pre>'; print_r($disposedData); exit;
                                        
                                        $applicant_name = $disposedData['applicant_name'];
                                    }
                                }*/
                                
                                //$petition_no = '';
                                //$dag_no = $this->utilityclass->dagnumbr($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code,$petition_no);
                                //$patta_no = $this->utilityclass->pattaNoFromChitha();
                                
                                /*$patta_no = '';
                                $dag_no = '';
                                $date_submission = '';
                                $applicant_name = '';
                                if(!empty($appID)){
                                    $disposedData = $this->utilityclass->getDisposedDataFromAppID($appID);    
                                    $patta_no = $disposedData['patta_no'];
                                    $dag_no = $disposedData['dag_no'];
                                    $date_submission = date('d-m-Y',strtotime($disposedData['date_submission']));
                                    //$lot_no = $disposedData['lot_no'];
                                    $applicant_name = $disposedData['applicant_name'];
                                }*/
                                
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td>
                                    <?php echo $appID; 
                                    if($date_submission != ''){ echo ' - '.$date_submission; }
                                    ?>
                                </td>
                                <td><?php echo $applicant_name; ?></td>
                                <td><?php echo $circle_name; ?></td>
                                <td><?php echo $lot_name ?></td>
                                <td><?php echo $village_name;  ?></td>
                                <td><?php echo $patta_no;  ?></td>
                                <td><?php echo $dag_no;  ?></td>
                                <td><?php echo $caseNo; ?></td>
                                <td><?php echo $order_pass_date; ?></td>
                                <td><?php echo $lmname; ?></td>
                                <td><?php echo $CO_name;?></td>
                                <td>#</td>
                                <td>#</td>
                            </tr>
                            <?php $count++;
                        endforeach; ?>
                        </table>
                        
                        <div class="pagination_links"> 
                            <?php echo $links; ?> &nbsp;&nbsp; Total Records - <?php echo $total_records; ?> </div> 
                        </div>
                        
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/disposed-cases/get" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo 'Back To Search'; ?>
                            </a>
                        </center>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style=" overflow-y: auto;" id='myModal'>
        <div class="modal-dialog modal-lg"  style=" overflow-y: auto;">
            <div class="modal-content"  style=" overflow-y: auto;">
                
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#disposed_data_table-back').DataTable({
            "iDisplayLength": 25,
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bInfo": false,
            //"pageLength": 2
        });

    });
</script> 

<script>
    
    $(function () {
        $('.panel').on('click','.skreport',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });
            
        });


        $('.panel').on('click','.lmreportpart',function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal('show');
                }
            });
            
        });
		
        $('#myModal').on('hidden.bs.modal', function () {
            $('body').css('padding-right',0);
	   })

        $('#myModal').on('hidden.bs.modal', function() {
            $('body').css('padding-right', 0);
            $('.modal-content').css('background-color', 'white');
            $('.modal-content').css('color', 'black');
        })
    });
</script>

<style>
#disposed_data_table {
  table-layout: fixed;
  width: 100% !important;
}
#disposed_data_table td,
#disposed_data_table th{
  width: auto !important;
  white-space: normal;
  text-overflow: ellipsis;
  overflow: hidden;
}
table { table-layout: fixed; }
td,th { word-wrap:break-word; }
table.dataTable tbody th, table.dataTable tbody td{ font-size:1em !important; }
table.dataTable thead th, table.dataTable thead td{ padding:0px !important; font-size:1em !important;}

ul.tsc_pagination{
    height:50px !important;
}
</style>
<style>
    .modal-clus {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content-cluster {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 70%;
    }
    /* The Close Button */
    .close-modal-cluster {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close-modal-cluster:hover,
    .close-modal-cluster:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<center>
    
    <mark>
        Village Cluster List 
    </mark>
        
    <br>
    <mark>
        <strong style="font-size: 20px;">
            <?php
                echo "Settlement VGR/PGR";
            ?>
        </strong>
    </mark>
    
</center>

<div class="row px-5">
    <table id="dataTable" class="datatable table table-stripped">  
            <thead>  
                <tr>  
                    <th>SL No</th> 
                    <th>Mouza Name</th>
                    <th>Lot Name</th>
                    <th>Village Name</th>
                    <th class="text-center">Total Processed</th>
                    <th class="text-center">Action</th>
                </tr>  
            </thead>  
            <tbody>
                <?php
                    $sl_no = 1;
                    if($villageClusters)
                    {
                        foreach($villageClusters as $vil_list)
                        {
                            ?>
                            <tr>
                                <td><?=$sl_no++?></td>
                                <td><?=$vil_list->mouza_name?></td>
                                <td><?=$vil_list->lot_name?></td>
                                <td><?=$vil_list->village_name?></td>
                                <td class="text-center text-danger"><?=$vil_list->completed_out_of?></td>
                                <td class="text-center">
                            
                                    <button type="button" onclick="viewClusteredCases('<?=$vil_list->dist_code?>','<?=$vil_list->subdiv_code?>','<?=$vil_list->cir_code?>','<?=$vil_list->mouza_pargona_code?>','<?=$vil_list->lot_no?>','<?=$vil_list->vill_townprt_code?>','<?=$vil_list->village_name?>')" class="btn btn-sm btn-success">view</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="checkForwardEligibility('<?=$vil_list->total_api_case?>', '<?=$vil_list->total_clustered?>', '<?=$vil_list->dist_code?>','<?=$vil_list->subdiv_code?>','<?=$vil_list->cir_code?>','<?=$vil_list->mouza_pargona_code?>','<?=$vil_list->lot_no?>','<?=$vil_list->vill_townprt_code?>')">Forward to ADC/SDO</button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>

            </tbody>
    </table>  
</div>

<div id="caseClusterModal" class="modal-clus">
    <!-- Modal content -->
    <div class="modal-content-cluster">
        <div class="row text-right">
            <span class="close-modal-cluster px-4">&times;</span>
        </div>
        <h5 id="head_label" class="text-center"></h5>
        <div class="container px-5" id="clusterTable">
           
        </div>
    </div>
</div>

<script>
	$(document).ready( function () {
    	$('#dataTable').DataTable();
    });
</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>

    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });
    }
    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true
    
        });
    }
</script>

<script>
    function checkForwardEligibility(total_api_cases, total_clustered, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code)
    {
        if(total_api_cases != total_clustered)
        {
            showErrorMessage('Unable to forward to SDO/ADC as the village cluster is not completed...');
            return false;
        }

        // showErrorMessage('This feature will be available soon!');
        // return false;

        const swalWithBootstrapButtons1 = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ml-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

        swalWithBootstrapButtons1.fire({
                    title: 'If you proceed with this all cases will be forwarded to ADC/SDO (Except rejected cases)!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) 
                    {
                        
                        //*****if equal  */
                        // showErrorMessage('This feature will be available soon!');
                        // return false;

                        var postData = {
                            'dist_code' : dist_code, 
                            'subdiv_code' : subdiv_code, 
                            'cir_code' : cir_code, 
                            'mouza_pargona_code' : mouza_pargona_code, 
                            'lot_no' : lot_no, 
                            'vill_townprt_code' : vill_townprt_code,
                        }

                        $.blockUI({
                            message: $('#displayBox'),
                            css: {
                                border:'none',
                                backgroundColor:'transparent'
                            }
                        });
                    
                        $.ajax({
                            url: baseurl+'SettlementVgrCo/forwardClusterToAdcSdo',
                            type: "POST",
                            data: postData,
                            success: function(data) {
                                arr = JSON.parse(data);
                                $.unblockUI();
                                if(arr.responseType != 2)
                                {
                                    showErrorMessage(arr.msg);
                                    return false;
                                }
                                else
                                {
                                    const swalWithBootstrapButtons = Swal.mixin({
                                        customClass: {
                                            confirmButton: 'btn btn-success ml-2',
                                            cancelButton: 'btn btn-danger'
                                        },
                                        buttonsStyling: false
                                    })

                                    swalWithBootstrapButtons.fire({
                                        title: arr.msg,
                                        icon: 'success',
                                        // showCancelButton: true,
                                        confirmButtonText: 'Ok',
                                        // reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = baseurl+"home/SettlementVgrCo?service=17";
                                        }
                                    })
                                }
                            }
                        });
                    }
                })
    }
</script>

<script>

    var modal_cluster = document.getElementById("caseClusterModal");
    var span_vgr_cluster = document.getElementsByClassName("close-modal-cluster")[0];

    span_vgr_cluster.onclick = function() {
        modal_cluster.style.display = "none";
        // table.destroy();
    }

    // When the user clicks anywhere outside of the modal_cluster, close it
    window.onclick = function(event) {
        if (event.target == modal_cluster) {
            modal_cluster.style.display = "none";
            // table.destroy();
        }
    }

    function viewClusteredCases(dist_code, subdiv_code, cir_code, mouza_code, lot_no, vill_code, village_name)
    {
        var postData = {
            'dist_code' : dist_code, 
            'subdiv_code' : subdiv_code, 
            'cir_code' : cir_code, 
            'mouza_pargona_code' : mouza_code, 
            'lot_no' : lot_no, 
            'vill_townprt_code' : vill_code,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementVgrCo/getClusteredCases',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                    return false;
                }
                else
                {
                    //console.log(arr.content);
                    modal_cluster.style.display = "block";
                    $('#head_label').html('List of the cases of '+village_name+' cluster');

                    var thead = "<thead>"+
                                    "<tr>"+
                                        "<th>Case No</th>"+
                                        "<th>Application No</th>"+
                                        "<th class= 'text-center'>Cases Status</th>"+
                                        "<th class= 'text-center'>Action</th>"+
                                    "</tr>"+
                                "</thead>";

                    var tdata = "";

                    for(i = 0; i < arr.content.length; i ++)
                    {
                        var c_status = '';

                        if(arr.content[i].status == 'AA')
                        {
                            c_status = '<span class="alert-warning"><b>In Village Cluster</b></span>';
                        }
                        else if(arr.content[i].status == 'D')
                        {
                            c_status = '<span class="alert-danger"><b>Case Rejected</b></span>';
                        }
                        else if(arr.content[i].status == 'F')
                        {
                            c_status = '<span class="alert-success"><b>Case Disposed</b></span>';
                        }
                        else if(arr.content[i].pending_officer == 'ADC')
                        {
                            c_status = '<span class="alert-success"><b>Forwarded to ADC</b></span>';
                        }
                        else if(arr.content[i].pending_officer == 'SDO')
                        {
                            c_status = '<span class="alert-success"><b>Forwarded to SDO</b></span>';
                        }

                        tdata += "<tr>"+
                                    "<td>"+arr.content[i].case_no+"</td>"+
                                    "<td>"+arr.content[i].applid+"</td>"+
                                    "<td class='text-center'>"+c_status+"</td>"+
                                    '<td class= "text-center"><a type="button" target="_blank" href="'+baseurl+'SettlementCommonDc/viewApplicationDetailsOnly?case='+arr.content[i].case_no+'" class="lmreportmut btn-sm btn btn-primary">view</a> <button type="button" onclick="rejectSubAlerttt(\''+arr.content[i].case_no+'\');" class="btn btn-sm btn-danger">Reject Case</button></td>'+
                                "</tr>";
                    }

                    $('#clusterTable').html('<table id="clusterDT" class="table table-bordered">'+thead+'<tbody>'+tdata+'</tbody></table>');

                    $('#clusterDT').DataTable({
                                            "aaSorting": [],
                                            "pageLength": 10,
                                            "bDestroy": true
                                        });
                }
            }
        });
    }
</script>

<script>
    function rejectSubAlerttt(case_no)
    {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure you want to Reject this case?',
            html: 'You wont be able to undo this once done',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                // var case_no = $('#case_no').val();
                showNewDirectRejectModalMb2(case_no, '<?php echo SETTLEMENT_PGR_VGR_LAND_ID ?>');
            }
        })

    }
</script>


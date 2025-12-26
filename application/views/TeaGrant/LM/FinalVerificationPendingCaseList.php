<div class="col-md-12 text-right text-cyan">
    Process > 
    Settlement MB3 > 
    <a href="<?php echo base_url(); ?>index.php/Home/TeaGrantLandLm?service=<?=TEA_SERVICE_CODE?>" style="text-decoration: none;">Tea Grant</a> > 
    <b>View</b>
</div>
<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Pending Case List For Final Verification
        </h4>
    </div>
</div>
<div class="col-lg-12 ">
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">
                To be forwarded <?php echo $this->lang->line('pending_cases');  ?>
            </h3>
        </div>
        <div class="panel-body">
            <table class='table table-striped' id='cases' width="100%">
                <thead>
                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                </thead>
                <?php foreach ($cases as $case) : ?>
                    <tr>
                        <td><?php echo $case->case_no; ?></td>
                        <td class="center">

                            <?php
                            echo "Mouza : " . $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                            echo "<br>Lot : " . $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                            echo "<br>Village : " . $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                            ?>
                        </td>
                        <td class="center">
                            <i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->submission_date)); ?>

                        </td>
                        <td>

                            <?php

                                if($case->chitha_processing_details == 1)
                                {
                                    $verification_status = '<span class="text-success"><strong><small>Verified</small></strong></span>';
                                    $verify_report_button = '';
                                }
                                else
                                {
                                    $verification_status = '<span class="text-danger"><strong><small>Not Verified</small></strong></span>';
                                    $verify_report_button = '&nbsp;<button type="button" onclick="finalVerificationModalTeaGrant(\''.$case->case_no.'\')" class="btn btn-sm btn-danger">Write Report</button>';
                                }

                                $view_link = '<a alt="View Application" class="text-white btn btn-sm btn-success" target="Application View" href="' . base_url() . 'index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=' . $case->case_no . '">
                                    <i class="fa fa-lg fa-file-text" aria-hidden="true"></i> Application</a>';

                                echo $view_link.$verify_report_button;

                            ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <center>
                <a href="<?php echo base_url(); ?>index.php/Home/TeaGrantLandLm?service=43" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;Back to Menu
                </a>
            </center>
        </div>
    </div>
</div>

<style>
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 80%;
            margin: 1.75rem auto;
        }
    }
</style>

<div class="modal" role="dialog" id="verifyReportModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="approvalForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Please Enter the following details</h5>
                </div>
                <div class="modal-body" align="center">

                    <div id="nomHead">

                    </div>

                    <div id="tableNomineeExt">

                    </div>
                    <div id="tableNominee">

                    </div>
                 
                    <div id="tableAppend">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  id="verifyReportModalNo">CANCEL</button>
                    <button type="submit" class="btn btn-primary"   id="verifyReportModalYes">FORWARD TO ADC</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $('#approvalForm').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to save the entered details?"))
        {
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/chithaProcessingDetailsTeaGrant",
            type: 'POST',
            data: $("#approvalForm").serialize(),
            dataType: 'json',
            success: function (data) {

                $('#verifyReportModal').modal('hide');

                $.unblockUI();
                if(data.responseType == 2)
                {
                    Swal.fire({
                            text: data.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) 
                        {
                            window.location = window.location;
                        }
                    })
                    // showSuccessMessage(data.msg);
                    // window.location = window.location;
                }
                else
                {
                    showErrorMessage(data.msg); 
                }
            }
        });
    });

    $(document).on('click','#verifyReportModalNo',function ()
    {
        $('#verifyReportModal').modal('hide');
    });
   
    function finalVerificationModalTeaGrant(case_no)
    {

        $('#nomHead').html('');
        $('#tableNomineeExt').html('');
        $('#tableNominee').html('');
        $('#tableAppend').html('');

        $('#verifyReportModal').modal('show');

        var postData = {
            'case_no': case_no
        };
        
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
        $.ajax({
            url: baseurl+'TeaGrantControllerLm/getFinalVerificationDataTeaGrant',
            type: "POST",
            data: postData,
            success: function(data) 
            {
                $.unblockUI();
                arr = JSON.parse(data);

                console.log(arr);

                if(arr.responseType == 0)
                {
                    $('#verifyReportModal').modal('hide');
                    showErrorMessage(arr.msg);
                    return false;
                }

                //****nominee details */
                // var headH = '<div>'+
                //                 '<h5 class="text-center" colspan="5">Family Details &nbsp; &nbsp;  <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add member</button>'+
                //                             '</h5>'+
                //             '</div>';

                // $('#nomHead').html(headH);

                if(arr.nominee != false)
                {
                    var nomHead = '<tr>'+
                            '<th>Nominee name</th>'+
                            '<th>Relation with Nominee</th>'+
                            '<th>Address of Nominee</th>'+
                            '<th>Mobile number</th>'+
                            '<th>Action</th>'+
                        '</tr>';

                    var trNom = '';

                    //****already existing nominee */
                    for(i=0; i<arr.nominee.length; i++)
                    {
                        trNom +=  '<tr>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.nominee[i].nominee_name+'" class="form-control"></td>'+
                                    '<td>'+
                                    '<input type="text" readonly name="kin_name" value="'+arr.nominee[i].relation_decoded+'" class="form-control">'+
                                    '<input type="hidden" readonly name="kin_name" value="'+arr.nominee[i].relation+'" class="form-control">'+
                                    '</td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.nominee[i].address+'" class="form-control"></td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.nominee[i].mobile_no+'" class="form-control"></td>'+

                                    '<td>'+
                                        '<button type="button" onclick="confirmDeleteFamily('+arr.nominee[i].id+');" class="btn btn-sm btn-danger">Delete</button>'+
                                    '</td>'+
                            '</tr>'; 
                    }

                    $('#tableNomineeExt').html('<table class="table">'+nomHead+trNom+'</table>');
                }
                // else
                // {
                    ////******added nonimees */
                if(arr.transactionNom != false)
                {

                    var trNom = '';
                    var tr_color = '';
                    var famDel = '';

                    var nomHead = '<tr>'+
                            '<th>Nominee name</th>'+
                            '<th>Relation with Nominee</th>'+
                            '<th>Address of Nominee</th>'+
                            '<th>Mobile number</th>'+
                            '<th>Action</th>'+
                        '</tr>';

                    for(i=0; i<arr.transactionNom.length; i++)
                    {
                        
                        if(arr.transactionNom[i].delete_id != 0)
                        {
                            tr_color =  '<tr style="background:#FFBBBB">';
                            famDel = '<button type="button" onclick="confirmDeleteFamilyLmInserted('+arr.transactionNom[i].id+');" class="btn btn-sm btn-danger">Remove</button>';
                        }
                        else
                        {
                            tr_color =  '<tr style="background:#A8FFA8">';
                            famDel = '<button type="button" onclick="confirmDeleteFamilyLmInserted('+arr.transactionNom[i].id+');" class="btn btn-sm btn-danger">Remove</button>';
                        }

                        trNom +=  tr_color+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.transactionNom[i].nominee_name+'" class="form-control"></td>'+
                                    '<td><input type="text" readonly value="'+arr.transactionNom[i].relation_decoded+'" class="form-control">'+
                                    '<input type="hidden" readonly name="kin_name" value="'+arr.transactionNom[i].relation+'" class="form-control">'+
                                    '</td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.transactionNom[i].address+'" class="form-control"></td>'+
                                    '<td><input type="text" readonly name="kin_name" value="'+arr.transactionNom[i].mobile_no+'" class="form-control"></td>'+

                                    '<td>'+
                                        famDel +
                                    '</td>'+
                            '</tr>'; 
                    }

                    $('#tableNominee').html('<table class="table">'+nomHead+trNom+'</table>');

                }
                // else
                // {
                //     $('#tableNominee').html('<table class="table">'+headH+'</table>');
                // }

                //}

                //******dag related details */
                var tr = '';

                tr += '<input id="user_dist_code" type="hidden" value="'+arr.user_data.user_dist_code+'">'+
                            '<input id="user_subdiv_code" type="hidden" value="'+arr.user_data.user_subdiv_code+'">'+
                            '<input id="user_cir_code" type="hidden" value="'+arr.user_data.user_cir_code+'">'+
                            '<input id="user_mouza_pargona_code" type="hidden" value="'+arr.user_data.user_mouza_pargona_code+'">'+
                            '<input id="user_lot_no" type="hidden" value="'+arr.user_data.user_lot_no+'">'+
                            '<input id="case_no_id" name="case_no" type="hidden" value="'+case_no+'">';
  
                
                // var clickCount = 1;
                for(i=0; i<arr.dagResult.length; i++)
                {
                    dist_option = '';

                    for(k=0; k<arr.dist_array.length; k++)
                    {
                        if(arr.user_data.user_dist_code == arr.dist_array[k].dist_code)
                        {
                            dist_option += '<option value="'+arr.dist_array[k].dist_code+'" selected>'+arr.dist_array[k].dist_name+'</option>'
                        }
                        else
                        {
                            dist_option += '<option value="'+arr.dist_array[k].dist_code+'">'+arr.dist_array[k].dist_name+'</option>'
                        }
                    }

                    var option_class_code = '';

                    for(j=0; j<arr.land_class_code.length; j++)
                    {
                        class_code = arr.land_class_code[j].class_code;
                        land_type  = arr.land_class_code[j].land_type;

                        option_class_code += '<option value="'+class_code+'">'+land_type+'</option>';
                    }
                    
                    tr += '<th class="text-center bg-info" colspan="4"><strong>Dag No: '+arr.dagResult[i].dag_no+' :::: Old Land Class: '+arr.dagResult[i].old_class_name+'</strong></th>';

                    var roadside_reservation = '';

                    if(arr.dagResult[i].road_side_reservation != false)
                    {
                        roadside_reservation = '<th>Reservation Area</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].road_side_reservation+'" class="form-control"></td>';
                    }

                    tr += '<tr>'+
                                '<th>Final Area</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].final_settlement_area+'" class="form-control"></td>'+
                           '</tr>';

                    tr += roadside_reservation;

                    tr += '<tr>'+
                                '<th>Landmark Entered</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].landmark_entered+'" class="form-control"></td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select East side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_east'+arr.dagResult[i].dag_no+'" id="landmark_dist_east'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        dist_option+
                                    '</select>'+
                                    '<select name="landmark_subdiv_east'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_east'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_east'+arr.dagResult[i].dag_no+'" id="landmark_cir_east'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_east'+arr.dagResult[i].dag_no+'" id="landmark_mouza_east'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_east'+arr.dagResult[i].dag_no+'" id="landmark_lot_east'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_east'+arr.dagResult[i].dag_no+'" id="landmark_village_east'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'east\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_east'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_east'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select West side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_west'+arr.dagResult[i].dag_no+'" id="landmark_dist_west'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        dist_option+
                                    '</select>'+
                                    '<select name="landmark_subdiv_west'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_west'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_west'+arr.dagResult[i].dag_no+'" id="landmark_cir_west'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_west'+arr.dagResult[i].dag_no+'" id="landmark_mouza_west'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_west'+arr.dagResult[i].dag_no+'" id="landmark_lot_west'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_west'+arr.dagResult[i].dag_no+'" id="landmark_village_west'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'west\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_west'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_west'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select North side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_north'+arr.dagResult[i].dag_no+'" id="landmark_dist_north'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        dist_option+
                                    '</select>'+
                                    '<select name="landmark_subdiv_north'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_north'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_north'+arr.dagResult[i].dag_no+'" id="landmark_cir_north'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_north'+arr.dagResult[i].dag_no+'" id="landmark_mouza_north'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_north'+arr.dagResult[i].dag_no+'" id="landmark_lot_north'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_north'+arr.dagResult[i].dag_no+'" id="landmark_village_north'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'north\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_north'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_north'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th>Select South side landmark</th>'+
                                '<td colspan="3">'+
                                    '<select name="landmark_dist_south'+arr.dagResult[i].dag_no+'" id="landmark_dist_south'+arr.dagResult[i].dag_no+'" onchange="landmark_dist(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        dist_option+
                                    '</select>'+
                                    '<select name="landmark_subdiv_south'+arr.dagResult[i].dag_no+'" id="landmark_subdiv_south'+arr.dagResult[i].dag_no+'" onchange="landmark_subdiv(\'south\','+arr.dagResult[i].dag_no+');" class="m-2">'+
                                        '<option value="">Select Subdivision...</option>'+
                                    '</select>'+
                                    '<select name="landmark_cir_south'+arr.dagResult[i].dag_no+'" id="landmark_cir_south'+arr.dagResult[i].dag_no+'" onchange="landmark_cir(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Circle...</option>'+
                                    '</select>'+
                                    '<select name="landmark_mouza_south'+arr.dagResult[i].dag_no+'" id="landmark_mouza_south'+arr.dagResult[i].dag_no+'" onchange="landmark_mouza(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select Mouza...</option>'+
                                    '</select>'+
                                    '<select name="landmark_lot_south'+arr.dagResult[i].dag_no+'" id="landmark_lot_south'+arr.dagResult[i].dag_no+'" onchange="landmark_lot(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">Select lot...</option>'+
                                    '</select>'+
                                    '<select name="landmark_village_south'+arr.dagResult[i].dag_no+'" id="landmark_village_south'+arr.dagResult[i].dag_no+'" onchange="landmark_village(\'south\',\''+arr.dagResult[i].dag_no+'\');" class="m-2">'+
                                        '<option value="">--Select Village--</option>'+
                                    '</select>'+
                                    '<select name="landmark_dag_no_south'+arr.dagResult[i].dag_no+'" id="landmark_dag_no_south'+arr.dagResult[i].dag_no+'" class="m-2">'+
                                        '<option value="">--Select Dag --</option>'+
                                    '</select>'+
                    
                                '</td>'+
                           '</tr>';

                    tr += '<tr>'+
                                '<th colspan="2">'+
                                    '<label>New Land Class</label>'+
                                    '<select class="form-control" name="land_class_code_tgpp'+arr.dagResult[i].dag_no+'" onchange="getRevenueTeaGrant(\''+arr.dagResult[i].old_dag+'\', \''+arr.dagResult[i].case_no+'\')" id="land_class_code_tgpp'+arr.dagResult[i].old_dag+'">'+
                                        '<option value="">Select land class...</option>'+
                                        option_class_code+
                                    '</select>'+
                                '</th>'+

                                '<th>'+
                                    '<label>Revenue</label>'+ 
                                    '<input type="number" id="revenue_tgpp'+arr.dagResult[i].old_dag+'" name="revenue_tgpp'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                '</th>'+

                                '<th><label>Local Tax</label> <input type="number" name="local_tax_tgpp'+arr.dagResult[i].dag_no+'" id="local_tax_tgpp'+arr.dagResult[i].old_dag+'" placeholder="Enter Local Tax" class="form-control" readonly></th>'+

                           '</tr>';

                }

                // tr +='<input type="hidden" id="clickCount_id" value="'+clickCount+'">';

                var patta_option = '';
                for(i=0; i<arr.patta_details.length; i++)
                {
                    patta_option += '<option value="'+arr.patta_details[i].type_code+'">'+arr.patta_details[i].patta_type+'</option>';
                }

                tr +=  '<tr>'+
                            '<th colspan="4" class="bg-info"></th>'+
                        '</tr>'+
                
                        '<tr>'+
                            '<th>Enter Patta Type</th>'+
                            '<td>'+
                                '<select name="new_patta_type" class="form-control">'+
                                    '<option value="">Select Patta Type...</option>'+
                                    patta_option+
                                '</select>'+
                            '</td>'+
                            '<th>Possession From</th>'+
                            '<td>'+
                                '<input type="date" name="possession_from" class="form-control" placeholder="Enter possession from...">'+
                            '</td>'+
                       '</tr>';

                $('#tableAppend').html('<table class="table">'+tr+'</table>');

                for(i=0; i<arr.dagResult.length; i++)
                {
                    landmark_dist('east', arr.dagResult[i].dag_no);
                    landmark_dist('west', arr.dagResult[i].dag_no);
                    landmark_dist('north', arr.dagResult[i].dag_no);
                    landmark_dist('south', arr.dagResult[i].dag_no);
                }
            }

        });


    }
</script>

<script>

    function landmark_dist(side, dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();

        var user_subdiv_code = $('#user_subdiv_code').val();

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getSubdivTeaGrant/" + district,
            success: function(data) {
                var arrdata = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Subdivision --</option>";
                for (var i = 0; i < arrdata.length; i++) 
                {
                    if(user_subdiv_code == arrdata[i].subdiv_code)
                    {
                        template +=
                            '<option value="'+arrdata[i].subdiv_code+'" selected>'+
                                arrdata[i].loc_name +' (' +arrdata[i].locname_eng +')'+
                            "</option>";
                    }
                    else
                    {
                        template +=
                            "<option value='" +
                            arrdata[i].subdiv_code +
                            "'>" +
                            arrdata[i].loc_name +
                            " (" +
                            arrdata[i].locname_eng +
                            ")</option>";
                    }

                }
                $("#landmark_subdiv_"+side+dag_no).html(template);

                landmark_subdiv(side, dag_no);

            },
            error: function(error) {
            },
        });

    };

    function landmark_subdiv(side,dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();

        var user_cir_code = $('#user_cir_code').val();

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getCircleTeaGrant/" + district+ "/"+ subdiv,
            success: function(data) {
                var Circle = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Circle --</option>";
                for (var i = 0; i < Circle.length; i++) 
                {

                    if(user_cir_code == Circle[i].cir_code)
                    {
                        template +=
                            '<option value="'+Circle[i].cir_code+'" selected>'+
                                Circle[i].loc_name +' (' +Circle[i].locname_eng +')'+
                            "</option>";
                    }
                    else
                    {
                        template +=
                            "<option value='" +
                            Circle[i].cir_code +
                            "'>" +
                            Circle[i].loc_name +
                            " (" +
                            Circle[i].locname_eng +
                            ")</option>";
                    }
                }
                $("#landmark_cir_"+side+dag_no).html(template);
                
                landmark_cir(side, dag_no);
            },
            error: function(error) {
            },
        });

    };

    function landmark_cir(side, dag_no) 
    {

        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val();

        var user_mouza_pargona_code = $('#user_mouza_pargona_code').val();

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getMouzaTeaGrant/" + district+ "/"+ subdiv+"/"+ cir,
            success: function(data) {
                var Mouza = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Mouza --</option>";
                for (var i = 0; i < Mouza.length; i++) 
                {

                    if(user_mouza_pargona_code == Mouza[i].mouza_pargona_code)
                    {
                        template +=
                            '<option value="'+Mouza[i].mouza_pargona_code+'" selected>'+
                                Mouza[i].loc_name +' (' +Mouza[i].locname_eng +')'+
                            "</option>";
                    }
                    else
                    {
                        template +=
                            "<option value='" +
                            Mouza[i].mouza_pargona_code +
                            "'>" +
                            Mouza[i].loc_name +
                            " (" +
                            Mouza[i].locname_eng +
                            ")</option>";
                    }
                }
                $("#landmark_mouza_"+side+dag_no).html(template);

                landmark_mouza(side, dag_no);

            },
            error: function(error) {
            },
        });

    };

    function landmark_mouza(side,dag_no) 
    {

        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val(); 
        var mouza = $('#landmark_mouza_'+side+dag_no).val(); 

        var user_lot_no = $('#user_lot_no').val();

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getLotTeaGrant/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza,
            success: function(data) {
                var Lot = JSON.parse(data);

                var template = "<option selected value='' disabled>-- Select Lot --</option>";
                for (var i = 0; i < Lot.length; i++) 
                {

                    if(user_lot_no == Lot[i].lot_no)
                    {
                        template +=
                            '<option value="'+Lot[i].lot_no+'" selected>'+
                                Lot[i].loc_name +' (' +Lot[i].locname_eng +')'+
                            "</option>";
                    }
                    else
                    {
                        template +=
                            "<option value='" +
                            Lot[i].lot_no +
                            "'>" +
                            Lot[i].loc_name +
                            " (" +
                            Lot[i].locname_eng +
                            ")</option>";
                    }
                }
                $("#landmark_lot_"+side+dag_no).html(template);

                landmark_lot(side, dag_no);

            },
            error: function(error) {
            },
        });
    };

    function landmark_lot(side,dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val(); 
        var mouza = $('#landmark_mouza_'+side+dag_no).val(); 
        var lot = $('#landmark_lot_'+side+dag_no).val(); 

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getVillageTeaGrant/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza+"/"+ lot,
            success: function(data) {
                var Village = JSON.parse(data);

                var template = "<option selected value=''>-- Select Village --</option>";
                for (var i = 0; i < Village.length; i++) 
                {
                    template +=
                        "<option value='" +
                        Village[i].vill_townprt_code +
                        "'>" +
                        Village[i].loc_name +
                        " (" +
                        Village[i].locname_eng +
                        ")</option>";
                    
                }
                $("#landmark_village_"+side+dag_no).html(template);
            },
            error: function(error) {
            },
        });
    };

    function landmark_village(side,dag_no) 
    {
        var district = $('#landmark_dist_'+side+dag_no).val();
        var subdiv = $('#landmark_subdiv_'+side+dag_no).val();
        var cir = $('#landmark_cir_'+side+dag_no).val(); 
        var mouza = $('#landmark_mouza_'+side+dag_no).val(); 
        var lot = $('#landmark_lot_'+side+dag_no).val(); 
        var village = $('#landmark_village_'+side+dag_no).val(); 

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getAllDagsTeaGrant/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza+"/"+ lot+"/"+ village,
            success: function(data) {
                var Dags = JSON.parse(data);

                var template = "<option selected value=''>-- Select Dag --</option>";
                for (var i = 0; i < Dags.length; i++) 
                {
                    template +=
                        "<option value='" +
                        Dags[i].dag_no +
                        "'>" +
                        Dags[i].dag_no +
                        "</option>";
                    
                }
                $("#landmark_dag_no_"+side+dag_no).html(template);
            },
            error: function(error) {
            },
        });
    };

    function getRevenueTeaGrant(dag_no, case_no)
    {
        var land_class = $('#land_class_code_tgpp'+dag_no).val();

        var postData = {
            'land_class_code' : land_class,
            'dag_no' : dag_no,
            'case_no' : case_no
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        })

        $.ajax({
            url: baseurl + "TeaGrantControllerLm/getRevenueDetailsTeaGrant",
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (data) {
                $.unblockUI();

                if(data.responseType == 2)
                {
                    // console.log(data.revenue);
                    $('#revenue_tgpp'+dag_no).val(data.revenue);
                    $('#local_tax_tgpp'+dag_no).val(data.local_tax);
                    $('#revenue_tgpp'+dag_no).attr('readonly', false);
                    $('#local_tax_tgpp'+dag_no).attr('readonly', false);
                }
                else
                {
                    $('#revenue_tgpp'+dag_no).val('');
                    $('#local_tax_tgpp'+dag_no).val('');
                    $('#revenue_tgpp'+dag_no).attr('readonly', false);
                    $('#local_tax_tgpp'+dag_no).attr('readonly', false);
                }
            }
        });
    }

</script>
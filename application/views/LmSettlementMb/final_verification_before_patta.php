<script>
    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>
<center>
    
    <mark>
        Final Verification 
    </mark>
        
    <br>
    <mark>
        <strong style="font-size: 20px;">
            <?php
                if($service == '13')
                {
                    echo "Settlement Occupancy Tenant";
                }
                if($service == '14')
                {
                    echo "Settlement AP Transfer";

                }
                if($service == '15')
                {
                    echo "Settlement Tribal Community";
                }
                if($service == '16')
                {
                    echo "Settlement Khasland";

                }
                if($service == '17')
                {
                    echo "Settlement VGR/PGR";

                }
                if($service == '18')
                {
                    echo "Settlement Cultivation";

                }

            ?>
        </strong>
    </mark>
    
</center>

<table class="datatable table table-stripped" id='datatable'>
	<thead style="font-size:7px">
		<tr>
			<th></th>
			<th></th>
			<th>Name 
                <select class="form-control input_search" name="category" id="category" data-column-index="2">
                    <option value="">select Village</option>
                    <?php 
                    if(isset($selectList))
                    { 
                        foreach($selectList as $vill)
                        {
                            ?>
                                <option value="<?=$vill->vill_townprt_code?>">
                                    <?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_pargona_code, $vill->lot_no, $vill->vill_townprt_code)?>
                                </option>
                            <?php 
                        }
                    }
                    ?>
                </select>
            </th>
            <th>
                Verification Status
                <select class="form-control input_search" name="v_status" id="v_status" data-column-index="3">
                    <option value="">Choose...</option>
                    <option value="1">Verified</option>
                    <option value="0">Not Verified</option>
                </select>

            </th>
			<th>
                <!-- Action -->
                <button type="button" class="search_button btn btn-sm btn-success form-control">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    Search
                </button>
            </th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>

<script>
    $(document).ready(function ()
    {
        $('#category, #v_status').change(function()
        {
            var category = $('#category').val();
            var v_status = $('#v_status').val();
            $('#datatable').DataTable().destroy();

            load_data(category, v_status);
    
        });

        load_data();

        function load_data(category,v_status)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = <?=$service?>;

            $('#datatable thead th:nth-of-type(1)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
                var title = 'Application No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
                var title = 'Case No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
            });
            
            var table = $('#datatable').DataTable({
                // "scrollX": true,
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                // "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/SettlementMbLm/finalVerificationPagination',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        v_status:v_status,
                    },
                    deferLoading: 57,
                },

                order: [[2, 'asc']],
                columnDefs: [{
                        targets: "_all",
                        orderable: false,
                        "className": "dt-center", "targets":[2, 3, 4],
                    }],
                    
            });

            // button search
            $('.search_button').on('click', function () {            
                $('table thead tr th .input_search').each(function(){ 
                    table.column($(this).data('columnIndex')).search(this.value);
                });
                table.draw();
            });
        }
        
    });

</script>
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
                    <button type="submit" class="btn btn-primary"   id="verifyReportModalYes">FORWARD TO CO</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

    $(document).on('click','#verifyReportModalNo',function ()
    {
        $('#verifyReportModal').modal('hide');
    });
   
    function finalVerificationModal(case_no)
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
            url: baseurl+'SettlementMbLm/getFinalVerificationData',
            type: "POST",
            data: postData,
            success: function(data) 
            {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType == 0)
                {
                    $('#verifyReportModal').modal('hide');
                    showErrorMessage(arr.msg);
                    return false;
                }

                //****nominee details */
                var headH = '<div>'+
                                '<h5 class="text-center" colspan="5">Family Details &nbsp; &nbsp;  <button type="button" onclick="addFamily();" class="btn btn-sm btn-warning">Add member</button>'+
                                            '</h5>'+
                            '</div>';

                $('#nomHead').html(headH);

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


                    var option_agri_class_code = '';
                    var option_home_class_code = '';
                    for(j=0; j<arr.land_class_code.length; j++)
                    {
                        class_code = arr.land_class_code[j].class_code;
                        land_type = arr.land_class_code[j].land_type;

                        //****For agriculture */
                        if(arr.land_class_code[j].class_code_cat == '01')
                        {
                            if(arr.dagResult[i].landTypeFinal == 2 || arr.dagResult[i].landTypeFinal == 3)
                            {
                                option_agri_class_code += '<option value="'+class_code+'">'+land_type+'</option>';
                            }
                            else
                            {
                                option_agri_class_code += '';
                            }
                        }

                        //****for homestead */
                        if(arr.land_class_code[j].class_code_cat == '02')
                        {
                            if(arr.dagResult[i].landTypeFinal == 1 || arr.dagResult[i].landTypeFinal == 3)
                            {
                                option_home_class_code += '<option value="'+class_code+'">'+land_type+'</option>';
                            }
                            else
                            {
                                option_home_class_code += '';
                            }
                        }

                        // option += '<option value="'+class_code+'">'+land_type+'</option>';
                    }
                    
                    tr += '<th class="text-center bg-info" colspan="4"><strong>Dag No: '+arr.dagResult[i].dag_no+' :::: Old Land Class: '+arr.dagResult[i].old_class_name+'</strong></th>';

                    var roadside_reservation = '';

                    if(arr.dagResult[i].road_side_reservation != false)
                    {
                        roadside_reservation = '<th>Reservation Area</th>'+
                                '<td colspan="3"> <input readonly type="text" value="'+arr.dagResult[i].road_side_reservation+'" class="form-control"></td>';
                    }

                    tr += '<tr>'+
                                '<th>Final Settlement Area</th>'+
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
                                // '<th>New land Class Homestead</th>'+
                                '<th colspan="2">'+
                                    '<label>New land Class Homestead</label> '+
                                    '<select class="form-control" name="land_class_code_homestead'+arr.dagResult[i].dag_no+'" onchange="getRevenueHome(\''+arr.dagResult[i].old_dag+'\', \''+arr.dagResult[i].case_no+'\')" id="land_class_code_homestead'+arr.dagResult[i].old_dag+'">'+
                                        '<option value="">Select land class...</option>'+
                                        option_home_class_code+
                                    '</select>'+
                                '</th>'+

                                '<th>'+
                                    '<label>Revenue</label>'+ 
                                    '<input type="number" id="revenue_home'+arr.dagResult[i].old_dag+'" name="revenue_home'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                '</th>'+

                                '<th><label>Local Tax</label> <input type="number" name="local_tax_home'+arr.dagResult[i].dag_no+'" id="local_tax_home'+arr.dagResult[i].old_dag+'" placeholder="Enter Local Tax" class="form-control" readonly></th>'+
                            '</tr>'+



                            '<tr>'+
                                // '<th>New land Class Agriculture</th>'+
                                '<th colspan="2">'+
                                    '<label>New land Class Agriculture</label>'+
                                    '<select class="form-control" name="land_class_code_agriculture'+arr.dagResult[i].dag_no+'" onchange="getRevenueAgri(\''+arr.dagResult[i].old_dag+'\', \''+arr.dagResult[i].case_no+'\')" id="land_class_code_agriculture'+arr.dagResult[i].old_dag+'">'+
                                        '<option value="">Select land class...</option>'+
                                        option_agri_class_code+
                                    '</select>'+
                                '</th>'+

                                '<th>'+
                                    '<label>Revenue</label>'+ 
                                    '<input type="number" id="revenue_agri'+arr.dagResult[i].old_dag+'" name="revenue_agri'+arr.dagResult[i].dag_no+'" placeholder="Enter Revenue" class="form-control" readonly>'+
                                '</th>'+

                                '<th><label>Local Tax</label> <input type="number" name="local_tax_agri'+arr.dagResult[i].dag_no+'" id="local_tax_agri'+arr.dagResult[i].old_dag+'" placeholder="Enter Local Tax" class="form-control" readonly></th>'+

                           '</tr>';

                           

                    // clickCount++;

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
            url: baseurl + "SettlementMbLm/getSubdiv/" + district,
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
            url: baseurl + "SettlementMbLm/getCircle/" + district+ "/"+ subdiv,
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
            url: baseurl + "SettlementMbLm/getMouza/" + district+ "/"+ subdiv+"/"+ cir,
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
            url: baseurl + "SettlementMbLm/getLot/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza,
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
            url: baseurl + "SettlementMbLm/getVillage/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza+"/"+ lot,
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
            url: baseurl + "SettlementMbLm/getAllDags/" + district+ "/"+ subdiv+"/"+ cir +"/"+ mouza+"/"+ lot+"/"+ village,
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

</script>


<style>
    @media (min-width: 576px){
        .modal-dialog-family {
            max-width: 50%;
            margin: 1.75rem auto;
        }
    }
</style>

<div class="modal" role="dialog" id="addFamilyModal">
    <div class="modal-dialog-family" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Enter Family Details</h5>
            </div>
            <div class="modal-body" align="center">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td>
                        <input type="text" id="add_kin_name" name="add_kin_name" placeholder="Name" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            <input type="text" id="add_kin_address" name="add_kin_address" placeholder="Address" class="form-control">
                        </td>
                        
                    </tr>
                    <tr>
                        <th>Relation</th>
                        <td>
                            <select id="add_kin_relation" class="form-control" name="add_kin_relation">
                                
                            </select>
                        </td>
                        
                    </tr>
            
                    <tr>
                        <th>Mobile</th>
                        <td>
                            <input type="number" maxlength="10" id="add_kin_contact_no" class="form-control" name="add_kin_contact_no" placeholder="Mobile Number">
                        </td>
                        
                    </tr>
                    
                </table>
                
                <!-- <div class="row justify-content-center">
                    <button type="button" onclick="addFamilyDetails();" class="btn btn-sm btn-danger col-3">Add</button>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="familyModalCancel">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addFamilyDetails();" id="familyModalSave">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- add family details -->
<script>
    $(document).on('click','#familyModalCancel',function ()
    {
        $('#addFamilyModal').hide();
    });

    function addFamily()
    {   
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbLm/getGuardianRelation',
            type: "POST",
            success: function(data) 
            {
                $.unblockUI();
                
                $('#addFamilyModal').show();

                arr = JSON.parse(data);

                if(arr.guar_rel == false)
                {
                    alert('Something went wrong!');
                    return false;
                }

                var option_rel = "<option selected value='' disabled>-- Select Relation --</option>";

                for(i=0; i<arr.guar_rel.length; i++)
                {
                    option_rel += '<option value="'+arr.guar_rel[i].id+'">'+arr.guar_rel[i].guard_rel_desc_as+'</option>'
                }

                $('#add_kin_relation').html(option_rel);
            }
        })
    }

    function addFamilyDetails(){
        var case_no = $.trim($('#case_no_id').val());
        var nominee_name = $.trim($('#add_kin_name').val());
        var address = $.trim($('#add_kin_address').val());
        var relation = $.trim($('#add_kin_relation').val());
        var mobile_no = $.trim($('#add_kin_contact_no').val());
        
        //validation for the update
        if(nominee_name == ''){
            alert('Name Field is required !');
            $('#add_kin_name').focus();
            return false;
        }
        if(address == ''){
            alert('Address Field is required !');
            $('#add_kin_address').focus();
            return false;
        }
        if(relation == ''){
            alert('Relation Field is required !');
            $('#add_kin_relation').focus();
            return false;
        }
        if(mobile_no == ''){
            alert('Mobile number Field is required !');
            $('#add_kin_contact_no').focus();
            return false;
        }
        if(mobile_no.length != 10){
            alert('Not a Valid Mobile number!');
            $('#add_kin_contact_no').focus();
            return false;
        }

        //prepare for updation
        var postData = {
            'case_no' : case_no,
            'nominee_name' : nominee_name,
            'address' : address,
            'relation' : relation,
            'mobile_no' : mobile_no
        };

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementMbLm/addFamilyDetails',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType == 0)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) 
                        {
                            $('#add_kin_name').val('');
                            $('#add_kin_address').val('');
                            $('#add_kin_contact_no').val('');
                            $('#add_kin_relation').val('');

                            $('#addFamilyModal').hide();
                            finalVerificationModal(case_no);
                        }
                    })
                }
            }
        });
    }

    // family delete
    function confirmDeleteFamily(id)
    {
        case_no = $('#case_no_id').val();

        if(confirm("Are you sure you want to delete this Record?"))
        {
            $.ajax({
                type: "POST",
                url: baseurl+'SettlementMbLm/delFamilyDetailsExisted',
                async: false,
                // dataType: 'json',
                data: { id: id, case_no:case_no },
                success: function (response) 
                {
                    const data = JSON.parse(response);
                    // console.log(data);
                    if(data.status == 0)
                    {
                        showErrorMessage("something went wrong!!");
                    }
                    else 
                    {              
                        showSuccessMessage("Nominee Deleted!!");
                        finalVerificationModal(case_no);
                    }         
                }
            });
        }
        else {
            // loading.out();
        }
    }
    // family delete
    function confirmDeleteFamilyLmInserted(id)
    {
        case_no = $('#case_no_id').val();

        if(confirm("Are you sure you want to delete this Record?"))
        {
            $.ajax({
                type: "POST",
                url: baseurl+'SettlementMbLm/delFamilyDetails',
                async: false,
                // dataType: 'json',
                data: { id: id, case_no:case_no },
                success: function (response) 
                {
                    const data = JSON.parse(response);
                    // console.log(data);
                    if(data.status == 0)
                    {
                        showErrorMessage("something went wrong!!");
                    }
                    else 
                    {              
                        showSuccessMessage("Nominee Deleted!!");
                        finalVerificationModal(case_no);
                    }         
                }
            });
        }
        else {
            // loading.out();
        }
    }

</script>
 

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
            url: baseurl + "SettlementMbLm/chithaProcessingDetails",
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
</script>

<!-- getting the revenue details  -->
<script>
    function getRevenueHome(dag_no, case_no)
    {
        var land_class = $('#land_class_code_homestead'+dag_no).val();

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
            url: baseurl + "SettlementMbLm/getRevenueDetails",
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (data) {
                $.unblockUI();

                if(data.responseType == 2)
                {
                    // console.log(data.revenue);
                    $('#revenue_home'+dag_no).val(data.revenue);
                    $('#local_tax_home'+dag_no).val(data.local_tax);
                    $('#revenue_home'+dag_no).attr('readonly', false);
                    $('#local_tax_home'+dag_no).attr('readonly', false);
                }
                else
                {
                    $('#revenue_home'+dag_no).val('');
                    $('#local_tax_home'+dag_no).val('');
                    $('#revenue_home'+dag_no).attr('readonly', false);
                    $('#local_tax_home'+dag_no).attr('readonly', false);
                }
            }
        });
    }

    function getRevenueAgri(dag_no, case_no)
    {
        var land_class = $('#land_class_code_agriculture'+dag_no).val();

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
            url: baseurl + "SettlementMbLm/getRevenueDetails",
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (data) {
                $.unblockUI();

                if(data.responseType == 2)
                {
                    // console.log(data.revenue);
                    $('#revenue_agri'+dag_no).val(data.revenue);
                    $('#local_tax_agri'+dag_no).val(data.local_tax);
                    $('#revenue_agri'+dag_no).attr('readonly', false);
                    $('#local_tax_agri'+dag_no).attr('readonly', false);
                }
                else
                {
                    $('#revenue_agri'+dag_no).val('');
                    $('#local_tax_agri'+dag_no).val('');
                    $('#revenue_agri'+dag_no).attr('readonly', false);
                    $('#local_tax_agri'+dag_no).attr('readonly', false);
                }
            }
        });
    }
</script>


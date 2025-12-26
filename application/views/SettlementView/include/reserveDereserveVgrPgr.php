<style>
    .modal-vgr {
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
    .modal-content-vgr {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 90%;
    }
    /* The Close Button */
    .close-enc-modal-vgr {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close-enc-modal-vgr:hover,
    .close-enc-modal-vgr:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<div id="vgrReserveModal" class="modal-vgr">

    <!-- Modal content -->
    <div class="modal-content-vgr">
        <div class="row text-right">
            <span class="close-enc-modal-vgr px-4">&times;</span>
        </div>
        <h5 id="head_label" class="text-center"></h5>

        <div class="container px-5" id="previouslySelectedTable">
        </div>

        <div class="container px-5" id="villageTable">
        </div>
    </div>

</div>

<script>
    //*******for subdiv */

    function getCirclesInSubdiv(dist_code, subdiv_code)
    {
        $('#head_label').html('');
        $('#previouslySelectedTable').html('');
        var modal_vgr = document.getElementById("vgrReserveModal");
        // Get the button that opens the modal_vgr
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal_vgr
        var span_vgr = document.getElementsByClassName("close-enc-modal-vgr")[0];
        modal_vgr.style.display = "block";

    
        span_vgr.onclick = function() {
            checkIfRserveDataInserted();
            modal_vgr.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal_vgr, close it
        window.onclick = function(event) {
            if (event.target == modal_vgr) {
                checkIfRserveDataInserted();
                modal_vgr.style.display = "none";
                // table.destroy();
            }
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var case_no = $('#case_no').val();
        var postDataFirst = {
            'case_no' : case_no,
        }

        $.ajax({
            url: baseurl+'SettlementVgr/checkIfReserveAreaInsertedForCase',
            type: "POST",
            data: postDataFirst,
            success: function(data) {
                arr = JSON.parse(data);
           
                if(arr.responseType == 2)
                {
                    $.unblockUI();
                    $('#head_label').html('<u>VGR/PGR Reservation/De-reservation details (Data entered by - '+arr.content.user_name+')</u>');

                    var exitedData = "<tr>"+
                                        "<th>District Name:</th>"+
                                        "<td>"+arr.content.dist_name+"</td>"+
                                        "<th>Suddiv Name:</th>"+
                                        "<td>"+arr.content.subdiv_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Circle Name:</th>"+
                                        "<td>"+arr.content.cir_name+"</td>"+
                                        "<th>Suddiv Name:</th>"+
                                        "<td>"+arr.content.mouza_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Lot Name:</th>"+
                                        "<td>"+arr.content.lot_name+"</td>"+
                                        "<th>Village Name:</th>"+
                                        "<td>"+arr.content.vill_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Dag No:</th>"+
                                        "<td>"+arr.content.dag_no+"</td>"+
                                        "<th>Area Details:</th>"+
                                        "<td>"+arr.content.area+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<td class='text-center' colspan='4'><button type='button' onclick='dereserve()' class='btn btn-danger btn sm'>Delete</button></td>"
                                     "</tr>";
                    

                    $('#villageTable').html("<table class='table table-bordered'>"+exitedData+"</table>");
                }
                else
                {
                    var postDataPrev = {
                            'dist_code': dist_code, 
                            'subdiv_code': subdiv_code,
                            // 'cir_code': cir_code,
                            // 'mouza_pargona_code': mouza_pargona_code,
                            // 'lot_no': lot_no,
                            // 'vill_townprt_code': vill_townprt_code,
                        }
                                
                    $.ajax({
                        url: baseurl+'SettlementVgr/getPreviouslyInsertedVgrLotData',
                        type: "POST",
                        data: postDataPrev,
                        success: function(data) {
                            // $('#head_label').html('Lot Information');

                            arrdt = JSON.parse(data);
                            if(arrdt.responseType != 2)
                            {
                                var selected_cir_array = [];
                            }
                            else
                            {
                                var selected_cir_array = arrdt.content.selected_dist_sub_cir_array;
                            }

                            var postData = {
                                'dist_code': dist_code, 
                                'subdiv_code': subdiv_code, 
                                // 'cir_code': cir_code, 
                            };

                            $.ajax({
                                url: baseurl+'SettlementVgrPgrADC/getCirclesFromSubdiv',
                                type: "POST",
                                data: postData,
                                success: function(data) {
                                    $.unblockUI();

                                    arr = JSON.parse(data);

                                    if(arr.responseType != 2)
                                    {
                                        showErrorMessage(arr.msg);
                                        return false;
                                    }
                                    var thead = "<thead>"+
                                                    "<tr>"+
                                                        "<th>Cicle</th>"+
                                                        "<th>Total Area in Circle</th>"+
                                                        "<th>Total Applied Area (By applicant)</th>"+
                                                        "<th>Available Area <br> (Total Chitha Area - Total Applied Area)</th>"+
                                                        "<th>Action</th>"+
                                                    "</tr>"+
                                                "</thead>";

                                    var tData = '';

                                    //******previously selected separate talbe */
                                    var phead = "<thead>"+
                                                    "<tr>"+
                                                        "<th>Cicle</th>"+
                                                        "<th>Total Area in Circle</th>"+
                                                        "<th>Total Applied Area (By applicant)</th>"+
                                                        "<th>Available Area <br> (Total Chitha Area - Total Applied Area)</th>"+
                                                        "<th>Action</th>"+
                                                    "</tr>"+
                                                "</thead>";

                                    var pData = '';

                                    for(var i = 0; i < arr.content.length; i++)
                                    {

                                        if(selected_cir_array.includes(arr.content[i].dist_code+arr.content[i].subdiv_code+arr.content[i].cir_code))
                                        {
                                            //*******normal table previously selected data highlight */
                                            var prev_select_style = "<br><span class='alert-warning' style='font-size:12px;'><strong>Previously reserved</strong></span>";
                                            var button_color = "btn-success";

                                            //*******previously selected table */
                                            pData += '<tr style="font-size: 12px;">'+
                                                    '<td>'+arr.content[i].cir_name+prev_select_style+'</td>'+

                                                    '<td>'+arr.content[i].total_area_in_circle+'</td>'+
                                                    '<td>'+arr.content[i].total_applied_area+'</td>'+
                                                    '<td>'+arr.content[i].total_available_area+'</td>'+
                                                    '<td><button type="button" onclick="getLotsInCircle(\''+arr.content[i].dist_code+'\', \''+arr.content[i].subdiv_code+'\', \''+arr.content[i].cir_code+'\')" class="btn '+button_color+' btn-sm">select</button></td></tr>';
                                        }
                                        else
                                        {
                                            var prev_select_style = "";
                                            var button_color = "btn-primary";
                                        }


                                        tData += '<tr style="font-size: 12px;">'+
                                        '<td>'+arr.content[i].cir_name+prev_select_style+'</td>'+

                                        '<td>'+arr.content[i].total_area_in_circle+'</td>'+
                                        '<td>'+arr.content[i].total_applied_area+'</td>'+
                                        '<td>'+arr.content[i].total_available_area+'</td>'+
                                        '<td><button type="button" onclick="getLotsInCircle(\''+arr.content[i].dist_code+'\', \''+arr.content[i].subdiv_code+'\', \''+arr.content[i].cir_code+'\')" class="btn '+button_color+' btn-sm">select</button></td></tr>'
                                    }

                                    $('#villageTable').html("<h6 class='text-center'><strong class='alert-success'>All Circle in Sub-division</strong></h6><table id='village_table' class='table table-bordered'>"+thead+"<tbody>"+tData+"</tbody></table>");
                                    
                                    //*****Previously selected table */
                                    if(pData != '')
                                    {
                                        $('#previouslySelectedTable').html("<h6 class='text-center'><strong class='alert-success'>Previously Reserved Circle</strong></h6><table id='previously_village_table' class='table table-bordered'>"+phead+"<tbody>"+pData+"</tbody></table><hr>");
                                    } 

                                    $('#previously_village_table').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "bDestroy": true
                                    });

                                    $('#village_table').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "bDestroy": true
                                    });
                                }
                            });

                        }
                    })

                }
            }
        })

    }



    //*******for circle */
    function getLotsInCircle(dist_code, subdiv_code, cir_code, village_townprt_code = '')
    {   
        $('#head_label').html('');

        var modal_vgr = document.getElementById("vgrReserveModal");
        // Get the button that opens the modal_vgr
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal_vgr
        var span_vgr = document.getElementsByClassName("close-enc-modal-vgr")[0];
        modal_vgr.style.display = "block";

    
        span_vgr.onclick = function() {
            checkIfRserveDataInserted();
            modal_vgr.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal_vgr, close it
        window.onclick = function(event) {
            if (event.target == modal_vgr) {
                checkIfRserveDataInserted();
                modal_vgr.style.display = "none";
                // table.destroy();
            }
        }

    
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });


        var case_no = $('#case_no').val();
        var postDataFirst = {
            'case_no' : case_no,
        }

        $.ajax({
            url: baseurl+'SettlementVgr/checkIfReserveAreaInsertedForCase',
            type: "POST",
            data: postDataFirst,
            success: function(data) {
                arr = JSON.parse(data);

                if(arr.responseType == 2)
                {
                    $.unblockUI();
                    $('#head_label').html('<u>VGR/PGR Reservation/De-reservation details (Data entered by - '+arr.content.user_name+')</u>');

                    var exitedData = "<tr>"+
                                        "<th>District Name:</th>"+
                                        "<td>"+arr.content.dist_name+"</td>"+
                                        "<th>Suddiv Name:</th>"+
                                        "<td>"+arr.content.subdiv_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Circle Name:</th>"+
                                        "<td>"+arr.content.cir_name+"</td>"+
                                        "<th>Suddiv Name:</th>"+
                                        "<td>"+arr.content.mouza_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Lot Name:</th>"+
                                        "<td>"+arr.content.lot_name+"</td>"+
                                        "<th>Village Name:</th>"+
                                        "<td>"+arr.content.vill_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Dag No:</th>"+
                                        "<td>"+arr.content.dag_no+"</td>"+
                                        "<th>Area Details:</th>"+
                                        "<td>"+arr.content.area+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<td class='text-center' colspan='4'><button type='button' onclick='dereserve()' class='btn btn-danger btn sm'>Delete</button></td>"
                                     "</tr>";
                    

                    $('#villageTable').html("<table class='table table-bordered'>"+exitedData+"</table>");
                }
                else
                {
                    var postDataPrev = {
                            'dist_code': dist_code, 
                            'subdiv_code': subdiv_code,
                            'cir_code': cir_code,
                            // 'mouza_pargona_code': mouza_pargona_code,
                            // 'lot_no': lot_no,
                            // 'vill_townprt_code': vill_townprt_code,
                        }
                                
                    $.ajax({
                        url: baseurl+'SettlementVgr/getPreviouslyInsertedVgrLotData',
                        type: "POST",
                        data: postDataPrev,
                        success: function(data) {
                            // $('#head_label').html('Lot Information');

                            arrdt = JSON.parse(data);
                            if(arrdt.responseType != 2)
                            {
                                var selected_lot_array = [];
                            }
                            else
                            {
                                var selected_lot_array = arrdt.content.selected_dist_sub_cir_mouza_lot_array;
                            }

                            var postData = {
                                'dist_code': dist_code, 
                                'subdiv_code': subdiv_code, 
                                'cir_code': cir_code, 
                            };

                            $.ajax({
                                url: baseurl+'SettlementVgrCo/getLotsFromInCircle',
                                type: "POST",
                                data: postData,
                                success: function(data) {
                                    $.unblockUI();

                                    arr = JSON.parse(data);

                                    if(arr.responseType != 2)
                                    {
                                        showErrorMessage(arr.msg);
                                        return false;
                                    }
                                    var thead = "<thead>"+
                                                    "<tr>"+
                                                        "<th>Mouza</th>"+
                                                        "<th>Lot</th>"+
                                                        "<th>Total Area in Lot</th>"+
                                                        "<th>Total Applied Area (By applicant)</th>"+
                                                        "<th>Available Area <br> (Total Chitha Area - Total Applied Area)</th>"+
                                                        "<th>Action</th>"+
                                                    "</tr>"+
                                                "</thead>";

                                    var tData = '';

                                    //******previously selected separate talbe */
                                    var phead = "<thead>"+
                                                    "<tr>"+
                                                        "<th>Mouza</th>"+
                                                        "<th>Lot</th>"+
                                                        "<th>Total Area in Lot</th>"+
                                                        "<th>Total Applied Area (By applicant)</th>"+
                                                        "<th>Available Area <br> (Total Chitha Area - Total Applied Area)</th>"+
                                                        "<th>Action</th>"+
                                                    "</tr>"+
                                                "</thead>";

                                    var pData = '';

                                    for(var i = 0; i < arr.content.length; i++)
                                    {

                                        if(selected_lot_array.includes(arr.content[i].dist_code+arr.content[i].subdiv_code+arr.content[i].cir_code+arr.content[i].mouza_pargona_code+arr.content[i].lot_no))
                                        {
                                            //*******normal table previously selected data highlight */
                                            var prev_select_style = "<br><span class='alert-warning' style='font-size:12px;'><strong>Previously reserved</strong></span>";
                                            var button_color = "btn-success";

                                            //*******previously selected table */
                                            pData += '<tr style="font-size: 12px;">'+
                                                    '<td>'+arr.content[i].mouza_name+'</td>'+

                                                    '<td>'+arr.content[i].lot_name+prev_select_style+'</td>'+

                                                    '<td>'+arr.content[i].total_area_in_lot+'</td>'+
                                                    '<td>'+arr.content[i].total_applied_area+'</td>'+
                                                    '<td>'+arr.content[i].total_available_area+'</td>'+
                                                    '<td><button type="button" onclick="vgrReservation(\''+arr.content[i].dist_code+'\', \''+arr.content[i].subdiv_code+'\', \''+arr.content[i].cir_code+'\', \''+arr.content[i].mouza_pargona_code+'\', \''+arr.content[i].lot_no+'\', \''+village_townprt_code+'\')" class="btn '+button_color+' btn-sm">select</button></td></tr>';
                                        }
                                        else
                                        {
                                            var prev_select_style = "";
                                            var button_color = "btn-primary";
                                        }


                                        tData += '<tr style="font-size: 12px;">'+
                                        '<td>'+arr.content[i].mouza_name+'</td>'+

                                        '<td>'+arr.content[i].lot_name+prev_select_style+'</td>'+

                                        '<td>'+arr.content[i].total_area_in_lot+'</td>'+
                                        '<td>'+arr.content[i].total_applied_area+'</td>'+
                                        '<td>'+arr.content[i].total_available_area+'</td>'+
                                        '<td><button type="button" onclick="vgrReservation(\''+arr.content[i].dist_code+'\', \''+arr.content[i].subdiv_code+'\', \''+arr.content[i].cir_code+'\', \''+arr.content[i].mouza_pargona_code+'\', \''+arr.content[i].lot_no+'\', \''+village_townprt_code+'\')" class="btn '+button_color+' btn-sm">select</button></td></tr>'
                                    }

                                    $('#villageTable').html("<h6 class='text-center'><strong class='alert-success'>All Lot Details</strong></h6><table id='village_table' class='table table-bordered'>"+thead+"<tbody>"+tData+"</tbody></table>");
                                    
                                    //*****Previously selected table */
                                    if(pData != '')
                                    {
                                        $('#previouslySelectedTable').html("<h6 class='text-center'><strong class='alert-success'>Previously Reserved Lot</strong></h6><table id='previously_village_table' class='table table-bordered'>"+phead+"<tbody>"+pData+"</tbody></table><hr>");
                                    } 

                                    $('#previously_village_table').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "bDestroy": true
                                    });

                                    $('#village_table').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "bDestroy": true
                                    });
                                }
                            });

                        }
                    })

                }
            }
        })
    }

    //*****for lot  */
    function vgrReservation(dist_code='', subdiv_code='', cir_code='', mouza_pargona_code='', lot_no='', vill_townprt_code = '')
    {
        var modal_vgr = document.getElementById("vgrReserveModal");
        // Get the button that opens the modal_vgr
        var btn = document.getElementById("myBtn");
        // Get the <span> element that closes the modal_vgr
        var span_vgr = document.getElementsByClassName("close-enc-modal-vgr")[0];
        modal_vgr.style.display = "block";

    
        span_vgr.onclick = function() {
            checkIfRserveDataInserted();
            modal_vgr.style.display = "none";
            // table.destroy();
        }

        // When the user clicks anywhere outside of the modal_vgr, close it
        window.onclick = function(event) {
            if (event.target == modal_vgr) {
                checkIfRserveDataInserted();
                modal_vgr.style.display = "none";
                // table.destroy();
            }
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });



        var case_no = $('#case_no').val();
        var postDataFirst = {
            'case_no' : case_no,
        }

        $.ajax({
            url: baseurl+'SettlementVgr/checkIfReserveAreaInsertedForCase',
            type: "POST",
            data: postDataFirst,
            success: function(data) {
                arr = JSON.parse(data);

                if(arr.responseType == 2)
                {
                    $.unblockUI();

                    $('#head_label').html('<u>VGR/PGR Reservation/De-reservation details (Data entered by - '+arr.content.user_name+')</u>');

                    var exitedData = "<tr>"+
                                        "<th>District Name:</th>"+
                                        "<td>"+arr.content.dist_name+"</td>"+
                                        "<th>Suddiv Name:</th>"+
                                        "<td>"+arr.content.subdiv_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Circle Name:</th>"+
                                        "<td>"+arr.content.cir_name+"</td>"+
                                        "<th>Suddiv Name:</th>"+
                                        "<td>"+arr.content.mouza_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Lot Name:</th>"+
                                        "<td>"+arr.content.lot_name+"</td>"+
                                        "<th>Village Name:</th>"+
                                        "<td>"+arr.content.vill_name+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<th>Dag No:</th>"+
                                        "<td>"+arr.content.dag_no+"</td>"+
                                        "<th>Area Details:</th>"+
                                        "<td>"+arr.content.area+"</td>"+
                                     "</tr>"+
                                     "<tr>"+
                                        "<td class='text-center' colspan='4'><button type='button' onclick='dereserve()' class='btn btn-danger btn sm'>Delete</button></td>"
                                     "</tr>";
                    

                    $('#villageTable').html("<table class='table table-bordered'>"+exitedData+"</table>");
                    
                }
                else
                {
                    var postDataPrev = {
                        'dist_code': dist_code, 
                        'subdiv_code': subdiv_code,
                        'cir_code': cir_code,
                        'mouza_pargona_code': mouza_pargona_code,
                        'lot_no': lot_no,
                        'vill_townprt_code': vill_townprt_code,
                    }
                    
                    $.ajax({
                        url: baseurl+'SettlementVgr/getPreviouslyInsertedVgrLotData',
                        type: "POST",
                        data: postDataPrev,
                        success: function(data) {
                            
                            // $('#head_label').html('Village Information');

                            arr = JSON.parse(data);
                            if(arr.responseType != 2)
                            {
                                var selected_vil_uuids = [];
                                var selected_dags = [];
                            }
                            else
                            {
                                var selected_vil_uuids = arr.content.selected_village_uuid_array;
                                var selected_dags = arr.content.selected_dags_array;

                            }

                            // ================================
                            var postData = {
                                'dist_code' : dist_code,
                                'subdiv_code' : subdiv_code,
                                'cir_code' : cir_code,
                                'mouza_pargona_code' : mouza_pargona_code,
                                'lot_no' : lot_no,
                                'vill_townprt_code' : vill_townprt_code,
                            }

                            $.ajax({
                                url: baseurl+'SettlementVgr/vgrReservationLot',
                                type: "POST",
                                data: postData,
                                success: function(data) {

                                    arr = JSON.parse(data);
                                    if(arr.responseType != 2)
                                    {
                                        $.unblockUI();

                                        showErrorMessage(arr.msg);
                                    }
                                    else
                                    {
                                        $.unblockUI();

                                        var thead = "<thead>"+
                                                        "<tr>"+ 
                                                            "<th class='text-center'>Sl.No.</th>"+
                                                            "<th>Village Name</th>"+
                                                            "<th>Total Area</th>"+
                                                            "<th>Total Applied Area</th>"+
                                                            "<th>Total Available Area</th>"+
                                                            "<th>Action</th>"+
                                                        "</tr>"+
                                                    "</thead>";

                                        var phead = "<thead>"+
                                                        "<tr>"+ 
                                                            "<th class='text-center'>Sl.No.</th>"+
                                                            "<th>Village Name</th>"+
                                                            "<th>Total Area</th>"+
                                                            "<th>Total Applied Area</th>"+
                                                            "<th>Total Available Area</th>"+
                                                            "<th>Action</th>"+
                                                        "</tr>"+
                                                    "</thead>";

                                        var tData = '';
                                        var pData = '';
                                        
                                        var sl_no = 1;

                                        for(i=0; i < arr.content.length; i ++)
                                        {

                                            if(selected_vil_uuids.includes(arr.content[i].vil_uuid))
                                            {
                                                //******previously selected data highlight in normal table */
                                                var prev_select_style = "<br><span class='alert-warning' style='font-size:12px;'><strong>Previously reserved</strong></span>";
                                                var button_color = "btn-success";

                                                //*****for previously selected table */
                                                pData += "<tr>"+ 
                                                        "<td class='text-center'>"+ sl_no++ +"</td>"+
                                                        "<td>"+arr.content[i].vil_name+prev_select_style+"</td>"+
                                                        "<td>"+arr.content[i].total_area_in_village+"</td>"+
                                                        "<td>"+arr.content[i].total_applied_area+"</td>"+
                                                        "<td>"+arr.content[i].total_available_area+"</td>"+
                                                        "<td><button type='button' onclick=\"selectedVill('"+arr.content[i].vil_uuid+"', '"+arr.content[i].vil_name+"','"+dist_code+"','"+subdiv_code+"','"+cir_code+"','"+mouza_pargona_code+"','"+lot_no+"', '"+vill_townprt_code+"')\" class='btn "+button_color+" btn-sm'>Select</button></td>"+
                                                    "</tr>";
                                            }
                                            else
                                            {
                                                var prev_select_style = "";
                                                var button_color = "btn-primary";
                                            }

                                            tData += "<tr>"+ 
                                                        "<td class='text-center'>"+ sl_no++ +"</td>"+
                                                        "<td>"+arr.content[i].vil_name+prev_select_style+"</td>"+
                                                        "<td>"+arr.content[i].total_area_in_village+"</td>"+
                                                        "<td>"+arr.content[i].total_applied_area+"</td>"+
                                                        "<td>"+arr.content[i].total_available_area+"</td>"+
                                                        "<td><button type='button' onclick=\"selectedVill('"+arr.content[i].vil_uuid+"', '"+arr.content[i].vil_name+"','"+dist_code+"','"+subdiv_code+"','"+cir_code+"','"+mouza_pargona_code+"','"+lot_no+"', '"+vill_townprt_code+"')\" class='btn "+button_color+" btn-sm'>Select</button></td>"+
                                                    "</tr>";
                                        }

                                        if(pData != '')
                                        {
                                            $('#previouslySelectedTable').html("<h6 class='text-center'><strong class='alert-success'>Previously Reserved Village</strong></h6><table id='previously_village_table' class='table table-bordered'>"+phead+"<tbody>"+pData+"</tbody></table><hr>");
                                        } 
                                        
                                        $('#villageTable').html("<h6 class='text-center'><strong class='alert-success'>All Village Details</strong></h6><table id='village_table' class='table table-bordered'>"+thead+"<tbody>"+tData+"</tbody></table>");

                                    }
                                    
                                    $('#previously_village_table').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "bDestroy": true
                                    });
                                    $('#village_table').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "bDestroy": true
                                    });

                                }
                            })


                        }
                    })
                }
            }
        })
       
    }


    function selectedVill(uuid, vill_name, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code)
    {   

        // $('#head_label').html('<strong class="alert-success">Showing Dag Details for village : '+vill_name+'</strong>');

        var case_no = $('#case_no').val();

        var postData = {
            'case_no' : case_no,
            'uuid' : uuid,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var postDataPrev = {
                'dist_code': dist_code, 
                'subdiv_code': subdiv_code,
                'cir_code': cir_code,
                'mouza_pargona_code': mouza_pargona_code,
                'lot_no': lot_no,
                'vill_townprt_code': vill_townprt_code,
            }

        $.ajax({
            url: baseurl+'SettlementVgr/getPreviouslyInsertedVgrLotData',
            type: "POST",
            data: postDataPrev,
            success: function(data) {
                arr = JSON.parse(data);
                if(arr.responseType != 2)
                {
                    var selected_vil_uuids = [];
                    var selected_dags = [];
                }
                else
                {
                    var selected_vil_uuids = arr.content.selected_village_uuid_array;
                    var selected_dags = arr.content.selected_dags_array;

                }

                //=================================================

                $.ajax({
                    url: baseurl+'SettlementVgr/getAvailabilityDetails',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        arr = JSON.parse(data);
                        if(arr.responseType != 2)
                        {
                            $.unblockUI();

                            showErrorMessage(arr.msg);
                            return false;
                        }
                        else
                        {
                            $.unblockUI();

                            var thead = "<thead>"+
                                            "<tr>"+ 
                                                "<th class='text-center'>Sl.No.</th>"+
                                                "<th>Dag Number</th>"+
                                                "<th>Total Area</th>"+
                                                "<th>Total Applied Area</th>"+
                                                "<th>Total Available Area</th>"+
                                                "<th>Action</th>"+
                                            "</tr>"+
                                        "</thead>";

                            var phead = "<thead>"+
                                            "<tr>"+ 
                                                "<th class='text-center'>Sl.No.</th>"+
                                                "<th>Dag Number</th>"+
                                                "<th>Total Area</th>"+
                                                "<th>Total Applied Area</th>"+
                                                "<th>Total Available Area</th>"+
                                                "<th>Action</th>"+
                                            "</tr>"+
                                        "</thead>";

                            var tData = '';
                            var pData = '';
                            
                            var sl_no = 1;

                            for(i=0; i < arr.content.length; i ++)
                            {
                                if(selected_dags.includes(arr.content[i].dag_no))
                                {
                                    //*****previously selected design */
                                    var prev_select_style = "<br><span class='alert-warning' style='font-size:12px;'><strong>Previously reserved</strong></span>";
                                    var button_color = "btn-success";

                                    //*****previously selected table */
                                    pData += "<tr>"+ 
                                            "<td class='text-center'>"+ sl_no++ +"</td>"+
                                            "<td>"+arr.content[i].dag_no+prev_select_style+"</td>"+
                                            "<td>"+arr.content[i].total_area_in_dag+"</td>"+
                                            "<td>"+arr.content[i].total_applied_area_in_dag+"</td>"+
                                            "<td>"+arr.content[i].total_available_area_in_dag+"</td>"+
                                            "<td><button type='button' onclick=\"selectedDag('"+vill_name+"','"+uuid+"', '"+arr.content[i].dag_no+"', '"+arr.content[i].b+"', '"+arr.content[i].k+"', '"+arr.content[i].l+"', '"+arr.content[i].g+"', '"+arr.content[i].applied_min+"', '"+arr.content[i].avail_min+"')\" class='btn "+button_color+" btn-sm'>Select</button></td>"+
                                        "</tr>";
                                }
                                else
                                {
                                    var prev_select_style = "";

                                    var button_color = "btn-primary";
                                }


                                tData += "<tr>"+ 
                                            "<td class='text-center'>"+ sl_no++ +"</td>"+
                                            "<td>"+arr.content[i].dag_no+prev_select_style+"</td>"+
                                            "<td>"+arr.content[i].total_area_in_dag+"</td>"+
                                            "<td>"+arr.content[i].total_applied_area_in_dag+"</td>"+
                                            "<td>"+arr.content[i].total_available_area_in_dag+"</td>"+
                                            "<td><button type='button' onclick=\"selectedDag('"+vill_name+"','"+uuid+"', '"+arr.content[i].dag_no+"', '"+arr.content[i].b+"', '"+arr.content[i].k+"', '"+arr.content[i].l+"', '"+arr.content[i].g+"', '"+arr.content[i].applied_min+"', '"+arr.content[i].avail_min+"')\" class='btn "+button_color+" btn-sm'>Select</button></td>"+
                                        "</tr>";
                            }

                           
                            if(pData != '')
                            {
                                $('#previouslySelectedTable').html("<h6 class='text-center'><strong class='alert-success'>Previously selected Dag Details for village : "+vill_name+"</strong></h6><table id='previously_village_table' class='table table-bordered'>"+phead+"<tbody>"+pData+"</tbody></table><hr>");
                            } 
                            
                            $('#villageTable').html("<h6 class='text-center'><strong class='alert-success'>Showing Dag Details for village : "+vill_name+"</strong></h6><table id='village_table' class='table table-bordered'>"+thead+"<tbody>"+tData+"</tbody></table>"); 

                        }
                        
                        $('#previously_village_table').DataTable({
                            "aaSorting": [],
                            "pageLength": 10,
                            "bDestroy": true
                        });
                        $('#village_table').DataTable({
                            "aaSorting": [],
                            "pageLength": 10,
                            "bDestroy": true
                        });

                    }
                })
            }
        })

    }

    function selectedDag(village_name, uuid, dag_no, bigha, katha, lessa, ganda, applied_min, avail_min)
    {

        if(parseFloat(applied_min) > parseFloat(avail_min))
        {
            showErrorMessage('Selected Dag has less available area then area to be reserved!');
            return false;
        }

        $('#head_label').html('<strong class="alert-success">Preview of Seleted Details <br><small class="alert-warning">Road/River side reservation (if any) will be automatically calculated after you submit you data</small></strong>');
        
        $('#previouslySelectedTable').html('');

        var tData = "<tr>"+ 
                        "<td><b>Village Name:</b></td>"+
                        "<td>"+ village_name +"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td><b>Dag No:</b></td>"+
                        "<td>"+ dag_no +"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td><b>Area to be reserved:</b></td>"+
                        "<td>B: "+bigha+" K: "+katha+" L: "+lessa+"</td>"+
                    "</tr>"+
                    
                    "<tr class='text-center'>"+
                        "<td colspan='2'><button type='button' onclick=\"finalSubmit('"+uuid+"','"+dag_no+"','"+bigha+"','"+katha+"','"+lessa+"','"+ganda+"')\" class='btn btn-primary btn-sm col-6'>Submit</button></td>"+
                    "</tr>";

        $('#villageTable').html("<table id='village_table' class='table table-bordered'><tbody>"+tData+"</tbody></table>");
    }

    function finalSubmit(uuid, dag_no, bigha, katha, lessa, ganda)
    {
        var case_no = $('#case_no').val();
        var modal_vgr = document.getElementById("vgrReserveModal");
        var reservation_details = $("input[name='re_dereservation']").val();

        var postData = {
            'uuid' : uuid,
            'dag_no' : dag_no,
            'bigha' : bigha,
            'katha' : katha,
            'lessa' : lessa,
            'ganda' : ganda,
            'case_no' : case_no,
            'reservation' : reservation_details,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementVgr/submitLmVgrData',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                if(arr.responseType != 2)
                {
                    $.unblockUI();
                    showErrorMessage(arr.msg);
                    return false;
                }
                else
                {
                    $.unblockUI();
                    modal_vgr.style.display = "none";
                    showSuccessMessage(arr.msg);
                }           
            }
        })
    }
</script>

<script>
    function dereserve() {
        var modal_vgr = document.getElementById("vgrReserveModal");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Selecting this option will delete added reservation details (if any)',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {

            if(result.isConfirmed)
            {
                var case_no = $('#case_no').val();
                var postData = {
                    'case_no' : case_no,
                }

                $.ajax({
                    url: baseurl+'SettlementVgr/reservationNotAvailableDelete',
                    type: "POST",
                    data: postData,
                    success: function(data) {
                        // $.unblockUI();
                        modal_vgr.style.display = "none";
                        $('#villageTable').html("");
                        checkIfRserveDataInserted();
                    }
                })
            }
            else
            {
                // $.unblockUI();
                $("input[name='re_dereservation']").prop("checked", false);
                checkIfRserveDataInserted();
            }
        })
    }

    function checkIfRserveDataInserted()
    {
        var case_no = $('#case_no').val();
        var postData = {
            'case_no' : case_no,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementVgr/checkIfReserveAreaInsertedForCase',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();
                arr = JSON.parse(data);

                if(arr.responseType == 2)
                {
                    $("#reservation_vgr").prop("checked", true);
                }
                else
                {
                    $("#reservation_vgr").prop("checked", false);
                }
            }
        })
    }

    $(document).ready(function(){
        checkIfRserveDataInserted();
    })

</script>
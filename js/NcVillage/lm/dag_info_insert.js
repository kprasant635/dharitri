
$('#dagDetailsModalNo').on('click', function(){
    $('#dagDetailsModal').hide();
});

function dagDetails(application_no){
    var postData = {
        'application_no': application_no
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getDagDetailsData',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);

            if(arr.responseType != 2){
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else{
                $('#dagDetailsModal').show();

                var option = '<option class="form-control" value="" disabled selected>Select dag Number</option>';
                for(i=0; i<arr.data.length; i++){
                    option += '<option>'+arr.data[i].dag_no+'</option>'

                    $('#select_dist_code').val(arr.data[i].dist_code);
                    $('#select_subdiv_code').val(arr.data[i].subdiv_code);
                    $('#select_cir_code').val(arr.data[i].cir_code);
                    $('#select_mouza_pargona_code').val(arr.data[i].mouza_pargona_code);
                    $('#select_lot_no').val(arr.data[i].lot_no);
                    $('#select_vill_townprt_code').val(arr.data[i].vill_townprt_code);
                }

                $('#select_location').html(arr.location_name);
                $('#select_application_no').val(application_no);
                $('#select_dag').html('<select class="form-control" id="selected_dag_no" onchange="dagSelect()">'+option+'</select>');
            }
        }
    });
}

function dagSelect()
{
    var dist_code = $('#select_dist_code').val();
    var subdiv_code = $('#select_subdiv_code').val();
    var cir_code = $('#select_cir_code').val();
    var mouza_pargona_code = $('#select_mouza_pargona_code').val();
    var lot_no = $('#select_lot_no').val();
    var vill_townprt_code = $('#select_vill_townprt_code').val();
    var dag_no = $('#selected_dag_no').val();

    var postData = {
        'dist_code' : dist_code,
        'subdiv_code' : subdiv_code,
        'cir_code' : cir_code,
        'mouza_pargona_code' : mouza_pargona_code,
        'lot_no' : lot_no,
        'vill_townprt_code' : vill_townprt_code,
        'dag_no' : dag_no
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getEncroachersInDag',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2){
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else
            {
                $('#dagDetailsModal').show();

                var option = '<option class="form-control" value="" disabled selected> Select Encroacher </option>';
                for(i=0; i<arr.data.length; i++){
                    option += '<option value="'+arr.data[i].id+'">'+arr.data[i].name+'</option>'
                }

                $('#select_encroacher').html('<select class="form-control" id="selected_encroacher" onchange="encroacherSelected(\''+dist_code+'\',\''+subdiv_code+'\',\''+cir_code+'\',\''+mouza_pargona_code+'\',\''+lot_no+'\',\''+vill_townprt_code+'\',\''+dag_no+'\')">'+option+'</select>');
            }
        }
    });
}


function encroacherSelected(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no){
    barak_valley = new Array('21','22','23');

    var postData = {
        'dist_code' : dist_code,
        'subdiv_code' : subdiv_code,
        'cir_code' : cir_code,
        'mouza_pargona_code' : mouza_pargona_code,
        'lot_no' : lot_no,
        'vill_townprt_code' : vill_townprt_code,
        'dag_no' : dag_no
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getChitaArea',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2){
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else
            {
                if (barak_valley.indexOf(dist_code) !== -1)
                {
                    var chita_area = 'B:'+arr.data.dag_area_b+' &nbsp; &nbsp; K:'+arr.data.dag_area_k+' &nbsp; &nbsp; C:'+arr.data.dag_area_lc+' &nbsp; &nbsp; G:'+arr.data.dag_area_g;
                    //****barak valley */
                    var area_inputs = '<div class="row">'+
                        '<div class="col-4">Bigha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Ganda (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="ganda"></div>'+
                        '</div>';
                    var area_inputs_agri = '<div class="row">'+
                        '<div class="col-4">Bigha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha_agri"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha_agri"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa_agri"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Ganda (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="ganda_agri"></div>'+
                        '</div>';
                    var roadside_inputs = '<div class="row">'+
                        '<div class="col-4">Bigha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_bigha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_katha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_lessa"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Ganda</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_ganda"></div>'+
                        '</div>';

                }
                else
                {
                    var chita_area = 'B: '+arr.data.dag_area_b+' &nbsp; &nbsp; K: '+arr.data.dag_area_k+' &nbsp; &nbsp;  L: '+arr.data.dag_area_lc;

                    //****non barak valley */
                    var area_inputs = '<div class="row">'+
                        '<div class="col-4">Bigha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa"></div>'+
                        '</div>';
                    var area_inputs_agri = '<div class="row">'+
                        '<div class="col-4">Bigha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha_agri"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha_agri"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa_agri"></div>'+
                        '</div>';
                    var roadside_inputs = '<div class="row">'+
                        '<div class="col-4">Bigha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_bigha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_katha"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_lessa"></div>'+
                        '</div>';

                }


                $('#select_chita_area').html(chita_area);
                $('#select_area').html(area_inputs);
                $('#select_area_agri').html(area_inputs_agri);
                $('#select_roadside').html(roadside_inputs);
            }
        }
    });
}

$('#dagDetailsModalSave').on('click', function()
{

    // $('#dagDetailsModal').hide();
    var dist_code   = $('#select_dist_code').val();
    var subdiv_code = $('#select_subdiv_code').val();
    var cir_code    = $('#select_cir_code').val();
    var mouza_pargona_code = $('#select_mouza_pargona_code').val();
    var lot_no             = $('#select_lot_no').val();
    var vill_townprt_code  = $('#select_vill_townprt_code').val();

    var dag_no         = $('#selected_dag_no').val();
    var application_no = $('#select_application_no').val();
    var bigha = $('#bigha').val();
    var katha = $('#katha').val();
    var lessa = $('#lessa').val();
    var ganda = $('#ganda').val();

    var bigha_agri = $('#bigha_agri').val();
    var katha_agri = $('#katha_agri').val();
    var lessa_agri = $('#lessa_agri').val();
    var ganda_agri = $('#ganda_agri').val();

    var road_bigha = $('#road_bigha').val();
    var road_katha = $('#road_katha').val();
    var road_lessa = $('#road_lessa').val();
    var road_ganda = $('#road_ganda').val();

    var encroacher_id = $('#selected_encroacher').val();

    var postData = {
        'dag_no': dag_no,
        'application_no': application_no,
        'bigha': bigha,
        'katha': katha,
        'lessa': lessa,
        'ganda': ganda,

        'bigha_agri': bigha_agri,
        'katha_agri': katha_agri,
        'lessa_agri': lessa_agri,
        'ganda_agri': ganda_agri,

        'road_bigha': road_bigha,
        'road_katha': road_katha,
        'road_lessa': road_lessa,
        'road_ganda': road_ganda,
        'encroacher_id': encroacher_id,

        'dist_code'   : dist_code,
        'subdiv_code' : subdiv_code,
        'cir_code'    : cir_code,
        'mouza_pargona_code' : mouza_pargona_code,
        'lot_no'             : lot_no,
        'vill_townprt_code'  : vill_townprt_code
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/saveDagInfo',
        type: "POST",
        data: postData,
        success: function(data)
        {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType == 2)
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'success',
                    position: 'top',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                location.reload();
            }
            });
            }
            if(arr.responseType != 2)
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
        }
    });
});




//*********************************************** ************************** *





// view encroacher details with dag
function viewEncroacherDetailsWithDag(app_id)
{
    var postData = {
        'app_id': app_id
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getApplicantDetailsWithDagId',
        type: "POST",
        data: postData,
        success: function(data)
        {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2)
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else if(arr.responseType == 2)
            {
                $('#dagDetailsViewModal').show();
                $('#select_location_view').html(arr.location_name);
            }
            else
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
        }
    });
}

// close view encroacher modal
$('#dagDetailsViewModalNo').on('click', function()
{
    $('#dagDetailsViewModal').hide();
});



// update encroacher details
function updateEncroacherDetailsWithDag(app_id)
{
    var postData = {
        'app_id': app_id
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/updateApplicantDetailsWithDagId',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);

            if(arr.responseType != 2)
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else if(arr.responseType == 2)
            {
                $('#dagDetailsUpdateModal').show();

                var option_update = '<option class="form-control" value="" disabled selected>Select dag Number</option>';
                for(i=0; i<arr.data.length; i++){
                    option_update += '<option>'+arr.data[i].dag_no+'</option>'

                    $('#select_dist_code_update').val(arr.data[i].dist_code);
                    $('#select_subdiv_code_update').val(arr.data[i].subdiv_code);
                    $('#select_cir_code_update').val(arr.data[i].cir_code);
                    $('#select_mouza_pargona_code_update').val(arr.data[i].mouza_pargona_code);
                    $('#select_lot_no_update').val(arr.data[i].lot_no);
                    $('#select_vill_townprt_code_update').val(arr.data[i].vill_townprt_code);
                }

                $('#select_location_update').html(arr.location_name_update);
                $('#select_application_no_update').val(arr.application_no);
                $('#updated_encroach_id').val(arr.encroach_id);
                $('#select_dag_update').html('<select class="form-control" id="selected_dag_no_update" onchange="dagSelectUpdate()">'+option_update+'</select>');

            }
            else
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
        }
    });
}

// close updated encroacher modal
$('#dagDetailsUpdateModalNo').on('click', function(){
    $('#dagDetailsUpdateModal').hide();
});


// select dag from select dag option
function dagSelectUpdate()
{
    var dist_code   = $('#select_dist_code_update').val();
    var subdiv_code = $('#select_subdiv_code_update').val();
    var cir_code    = $('#select_cir_code_update').val();
    var mouza_pargona_code = $('#select_mouza_pargona_code_update').val();
    var vill_townprt_code  = $('#select_vill_townprt_code_update').val();
    var lot_no = $('#select_lot_no_update').val();
    var dag_no = $('#selected_dag_no_update').val();

    var postData = {
        'dist_code' : dist_code,
        'subdiv_code' : subdiv_code,
        'cir_code' : cir_code,
        'mouza_pargona_code' : mouza_pargona_code,
        'lot_no' : lot_no,
        'vill_townprt_code' : vill_townprt_code,
        'dag_no' : dag_no
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getEncroachersInDag',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2){
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else
            {
                $('#dagDetailsUpdateModal').show();

                var option = '<option class="form-control" value="" disabled selected> Select Encroacher </option>';
                for(i=0; i<arr.data.length; i++){
                    option += '<option value="'+arr.data[i].id+'">'+arr.data[i].name+'</option>'
                }

                $('#select_encroacher_update').html('<select class="form-control" id="selected_encroacher_update" onchange="encroacherSelectedUpdate(\''+dist_code+'\',\''+subdiv_code+'\',\''+cir_code+'\',\''+mouza_pargona_code+'\',\''+lot_no+'\',\''+vill_townprt_code+'\',\''+dag_no+'\')">'+option+'</select>');
            }
        }
    });
}


// get encroacher chitha details
function encroacherSelectedUpdate(dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code,dag_no)
{
    barak_valley = new Array('21','22','23');

    var postData = {
        'dist_code' : dist_code,
        'subdiv_code' : subdiv_code,
        'cir_code' : cir_code,
        'mouza_pargona_code' : mouza_pargona_code,
        'lot_no' : lot_no,
        'vill_townprt_code' : vill_townprt_code,
        'dag_no' : dag_no
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/getChitaArea',
        type: "POST",
        data: postData,
        success: function(data) {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType != 2){
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
            else
            {
                if (barak_valley.indexOf(dist_code) !== -1)
                {
                    var chita_area_update = 'B:'+arr.data.dag_area_b+' &nbsp; &nbsp; K:'+arr.data.dag_area_k+' &nbsp; &nbsp; C:'+arr.data.dag_area_lc+' &nbsp; &nbsp; G:'+arr.data.dag_area_g;
                    //****barak valley */
                    var area_inputs_update = '<div class="row">'+
                        '<div class="col-4">Bigha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Ganda (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="ganda_update"></div>'+
                        '</div>';
                    var area_inputs_agri_update = '<div class="row">'+
                        '<div class="col-4">Bigha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha_agri_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha_agri_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa_agri_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Ganda (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="ganda_agri_update"></div>'+
                        '</div>';
                    var roadside_inputs_update = '<div class="row">'+
                        '<div class="col-4">Bigha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_bigha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_katha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_lessa_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Ganda</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_ganda_update"></div>'+
                        '</div>';

                }
                else
                {
                    var chita_area_update = 'B: '+arr.data.dag_area_b+' &nbsp; &nbsp; K: '+arr.data.dag_area_k+' &nbsp; &nbsp;  L: '+arr.data.dag_area_lc;

                    //****non barak valley */
                    var area_inputs_update = '<div class="row">'+
                        '<div class="col-4">Bigha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Homestead) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa_update"></div>'+
                        '</div>';
                    var area_inputs_agri_update = '<div class="row">'+
                        '<div class="col-4">Bigha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="bigha_agri_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="katha_agri_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa (Agriculture) </div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="lessa_agri_update"></div>'+
                        '</div>';
                    var roadside_inputs_update = '<div class="row">'+
                        '<div class="col-4">Bigha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_bigha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Katha</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_katha_update"></div>'+
                        '</div>'+
                        '<div class="row mt-2">'+
                        '<div class="col-4">Lessa</div>'+
                        '<div class="col-8"><input class="form-control" type="number" id="road_lessa_update"></div>'+
                        '</div>';
                }


                $('#select_chita_area_update').html(chita_area_update);
                $('#select_area_update').html(area_inputs_update);
                $('#select_area_agri_update').html(area_inputs_agri_update);
                $('#select_roadside_update').html(roadside_inputs_update);
            }
        }
    });
}


// update encroacher into database
$('#dagDetailsModalUpdate').on('click', function()
{
    // $('#dagDetailsModal').hide();
    var dist_code   = $('#select_dist_code_update').val();
    var subdiv_code = $('#select_subdiv_code_update').val();
    var cir_code    = $('#select_cir_code_update').val();
    var mouza_pargona_code = $('#select_mouza_pargona_code_update').val();
    var lot_no             = $('#select_lot_no_update').val();
    var vill_townprt_code  = $('#select_vill_townprt_code_update').val();

    var dag_no         = $('#selected_dag_no_update').val();
    var application_no = $('#select_application_no_update').val();
    var bigha = $('#bigha_update').val();
    var katha = $('#katha_update').val();
    var lessa = $('#lessa_update').val();
    var ganda = $('#ganda_update').val();

    var bigha_agri = $('#bigha_agri_update').val();
    var katha_agri = $('#katha_agri_update').val();
    var lessa_agri = $('#lessa_agri_update').val();
    var ganda_agri = $('#ganda_agri_update').val();

    var road_bigha = $('#road_bigha_update').val();
    var road_katha = $('#road_katha_update').val();
    var road_lessa = $('#road_lessa_update').val();
    var road_ganda = $('#road_ganda_update').val();

    var selected_encroacher_id = $('#selected_encroacher_update').val();
    var updated_encroach_id    = $('#updated_encroach_id').val();

    var postData = {
        'dag_no': dag_no,
        'application_no': application_no,
        'bigha': bigha,
        'katha': katha,
        'lessa': lessa,
        'ganda': ganda,

        'bigha_agri': bigha_agri,
        'katha_agri': katha_agri,
        'lessa_agri': lessa_agri,
        'ganda_agri': ganda_agri,

        'road_bigha': road_bigha,
        'road_katha': road_katha,
        'road_lessa': road_lessa,
        'road_ganda': road_ganda,
        'selected_encroacher_id': selected_encroacher_id,
        'updated_encroach_id'   : updated_encroach_id,

        'dist_code'   : dist_code,
        'subdiv_code' : subdiv_code,
        'cir_code'    : cir_code,
        'mouza_pargona_code' : mouza_pargona_code,
        'lot_no'             : lot_no,
        'vill_townprt_code'  : vill_townprt_code
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcLmKhaslandController/updateDagInfoForEncroacher',
        type: "POST",
        data: postData,
        success: function(data)
        {
            $.unblockUI();
            arr = JSON.parse(data);
            if(arr.responseType == 2)
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'success',
                    position: 'top',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                location.reload();
            }
            });
            }
            if(arr.responseType != 2)
            {
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2'
                    }
                });
                return false;
            }
        }
    });
});

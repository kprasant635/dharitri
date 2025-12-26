$('#village_code').change(function (e) {
    e.preventDefault()
    var loc_list = $('#village_code').val();
	var loc = loc_list.split(',');

    var dist_code = loc[0]; 
    var subdiv_code = loc[1];
    var cir_code = loc[2];
    var mouza_pargona_code = loc[3];
    var lot_no = loc[4];
    var vill_townprt_code = loc[5];

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    var postData = {
        dist_code : dist_code,
        subdiv_code : subdiv_code,
        cir_code : cir_code,
        mouza_pargona_code : mouza_pargona_code,
        lot_no : lot_no,
        vill_townprt_code : vill_townprt_code,
    }

    $.ajax({
        url: baseurl + 'LandClassPermissionController/menu',
        data: postData,
        type: 'POST',
        success: function (data) {
            $.unblockUI();
            $('#menu').html(data);
            $('#permission_view').html('');
        }
    })
})

function givePermission(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code){
    var postData = {
        dist_code : dist_code,
        subdiv_code : subdiv_code,
        cir_code : cir_code,
        mouza_pargona_code : mouza_pargona_code,
        lot_no : lot_no,
        vill_townprt_code : vill_townprt_code,
    }
    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl + 'LandClassPermissionController/permissionView',
        data: postData,
        type: 'POST',
        success: function (data) {
            $.unblockUI();
            $('#permission_view').html(data);
        }
    })
}

$(document).on('click', '#check_all', function () {
    $('.dag-checkbox').prop('checked', this.checked);
});

$(document).on('click', '.dag-checkbox', function () {
    var allChecked = $('.dag-checkbox:checked').length === $('.dag-checkbox').length;
    $('#check_all').prop('checked', allChecked);
});

$(document).on('click', '#check_all_lnd_class', function () {
    $('.land-class-checkbox').prop('checked', this.checked);
});

$(document).on('click', '.land-class-checkbox', function () {
    var allChecked = $('.land-class-checkbox:checked').length === $('.land-class-checkbox').length;
    $('#check_all_lnd_class').prop('checked', allChecked);
});


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

function permissionSave() {
    // e.preventDefault();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success ml-2',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl + 'LandClassPermissionController/permissionSave', 
        type: 'POST',  
        data: $("#form_sub").serialize(),  
        success: function(data) {
            $.unblockUI();  
            arr = JSON.parse(data);

            if(arr.responseType != 2){
                showErrorMessage(arr.msg);
                return false;
            }else{
                swalWithBootstrapButtons.fire({
                    title: arr.msg,
                    icon: 'success',
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false
                }).then((result2) => {
                    if (result2.isConfirmed) {
                        $('#permission_view').html('');
                    } 
                })
            }
        },
    });
    
    
    
}


function viewList(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code){
    var postData = {
        dist_code : dist_code,
        subdiv_code : subdiv_code,
        cir_code : cir_code,
        mouza_pargona_code : mouza_pargona_code,
        lot_no : lot_no,
        vill_townprt_code : vill_townprt_code,
    }

    if ($('.blockUI').length === 0) {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    }

    $.ajax({
        url: baseurl + 'LandClassPermissionController/viewList',
        data: postData,
        type: 'POST',
        success: function (data) {
            $.unblockUI();
            $('#permission_view').html(data);
        }
    })
}

function viewLandclassInDag(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no){
    
    var postData = {
        dist_code : dist_code,
        subdiv_code : subdiv_code,
        cir_code : cir_code,
        mouza_pargona_code : mouza_pargona_code,
        lot_no : lot_no,
        vill_townprt_code : vill_townprt_code,
        dag_no : dag_no
    }
    if ($('.blockUI').length === 0) {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    }
    $.ajax({
        url: baseurl + 'LandClassPermissionController/landclassViewInDag',
        data: postData,
        type: 'POST',
        success: function (data) {
            $.unblockUI();
            $('#dag_view_div_'+dag_no).html(data);
        }
    })
}

function deleteDag(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, dag_no, master_id){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success ml-2',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Do you really want to delete this dag?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true

    }).then((result) => {
        if (result.isConfirmed) {
            var postData = {
                dist_code : dist_code,
                subdiv_code : subdiv_code,
                cir_code : cir_code,
                mouza_pargona_code : mouza_pargona_code,
                lot_no : lot_no,
                vill_townprt_code : vill_townprt_code,
                dag_no : dag_no,
                master_id : master_id
            }
            if ($('.blockUI').length === 0) {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            }
        
            $.ajax({
                url: baseurl + 'LandClassPermissionController/deleteDag',
                data: postData,
                type: 'POST',
                success: function (data) {
                    $.unblockUI();
                    arr = JSON.parse(data);

                    if(arr.responseType != 2){
                        showErrorMessage(arr.msg);
                    }else{
                        viewList(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code);
                        showSuccessMessage(arr.msg);
                    }
                }
            })
        }else{
            result.dismiss === Swal.DismissReason.cancel
        }
    })
}



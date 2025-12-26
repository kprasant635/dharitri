
// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function encroacherModal(dag_no, riotee_id)
{

    modal.style.display = "block";
    $("#dag_label").html(dag_no);
    var uuid = $('#uuid').val();

    $('#datatable thead th:nth-of-type(2)').each(function ()
    {
        var title = $(this).text();
        $(this).html(title+' <input type="text" value="" class="input_search form-control form-control-sm" placeholder="Search occupier" data-column-index="1" />');
    });

    $('#datatable thead th:nth-of-type(4)').each(function ()
    {
        var title = $(this).text();
        $(this).html(title+' <input type="text" value="" class="input_search form-control form-control-sm" placeholder="Search date" data-column-index="3" />');
    });

    var table = $('#datatable').DataTable({
        // "scrollX": true,
        'pageLength':10,
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
        'language': {"processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
        },
        'ajax':{
            url: baseurl+'NcCommonController/encroacherPagination',
            type:'POST',
            data: {
                uuid:uuid,
                dag_no:dag_no,
                riotee_id:riotee_id
            },
            deferLoading: 57,
        },


        order: [[2, 'asc']],
        columnDefs: [{
            targets: "_all",
            orderable: false,
            "className": "dt-center", "targets":[ 0, 3, 4, 5],
        }]

    });

    // button search
    $('.search_button').on('click', function () {
        $('table thead tr th .input_search').each(function(){
            table.column($(this).data('columnIndex')).search(this.value);
        });
        table.draw();
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        table.destroy();
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            table.destroy();
        }
    }
}

// change encroacher name to selected encroacher
function changeEncroacher(enc_id,riotee_id){

    var case_no = $.trim($('#case_no').val());
    var enc_name = $("#enc_name"+enc_id).val();
    var enc_father = $("#enc_fathers_name"+enc_id).val();
    var enc_from = $("#end_enc_from"+enc_id).val();
    var enc_land_type = $("#enc_land_type"+enc_id).val();

    // ********prepare for updation***
    var postData = {
        'case_no' : case_no,
        'riotee_id' : riotee_id,
        'enc_id' : enc_id,
        'enc_name' : enc_name,
        'enc_father' : enc_father,
        'enc_from' : enc_from,
        'enc_land_type' : enc_land_type,
    };

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

    $.ajax({
        url: baseurl+'NcCommonController/updateEncroacher',
        type: "POST",
        data: postData,
        success: function(data) {
            arr = JSON.parse(data);
            $.unblockUI();
            if(arr.responseType == 0){
                Swal.fire({
                    text: arr.msg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                })
            }
            else
            {
                // modal.style.display = "none";
                Swal.fire({
                    text: arr.msg,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        actions: 'my-actions',
                        confirmButton: 'order-2',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                modal.style.display = "none";

                $("#enc_id"+riotee_id).val(arr.appnData.enc_id);
                $("#enc_name"+riotee_id).val(arr.appnData.pdar_name);
                $("#enc_gur_name"+riotee_id).val(arr.appnData.pdar_guardian);
                $("#enc_period_possession"+riotee_id).val(arr.appnData.period_possession);
                $('#datatable').DataTable().destroy();
                window.location = window.location;

            }
            })
            }
        }
    });
}
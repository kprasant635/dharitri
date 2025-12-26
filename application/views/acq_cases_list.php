<style>
/* ===== Clean Modern Look for Existing DAG Page ===== */
body {
    background-color: #f8fafc;
    font-family: 'Poppins', sans-serif;
}
/* === Fix DataTable width and scrolling === */
.dataTables_wrapper {
    width: 100% !important;
    overflow-x: auto !important;
    margin-top: 15px;
}

table.dataTable {
    width: 100% !important;
    border-collapse: collapse !important;
}

.dataTables_scrollHeadInner, 
.dataTables_scrollBody {
    width: 100% !important;
}

/* Better alignment for the table inside card */
#datatable {
    margin-bottom: 0;
    border-radius: 8px;
}

#datatable th, 
#datatable td {
    white-space: nowrap;
    text-align: center;
    vertical-align: middle;
    padding: 10px 12px;
}

/* Optional: limit table height with smooth scroll */
.table-responsive {
    max-height: 70vh;
    overflow-y: auto;
    overflow-x: auto;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    background: #fff;
    padding: 20px;
}

h4 {
    font-weight: 600;
    color: #334155;
    text-align: center;
    margin-bottom: 20px;
}

/* Filter Bar Styling */
.filter-bar {
    background: #f9fafb;
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.filter-bar label {
    font-weight: 500;
    color: #475569;
    font-size: 14px;
}

.filter-bar select,
.filter-bar input {
    border-radius: 6px !important;
    font-size: 14px;
    border-color: #e2e8f0;
}

/* Table Styling */
#datatable {
    font-size: 14px !important;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
}

#datatable thead {
    background: #f1f5f9;
    color: #334155;
}

#datatable th,
#datatable td {
    text-align: center;
    vertical-align: middle;
    padding: 10px;
}

#datatable tr:hover {
    background-color: #f9fafb;
}

/* Buttons */
.btn {
    border-radius: 6px !important;
    font-weight: 500;
    font-size: 14px;
}

.btn-success {
    background-color: #22c55e !important;
    border-color: #22c55e !important;
}

.btn-warning {
    background-color: #f59e0b !important;
    border-color: #f59e0b !important;
    color: #fff;
}

.btn-warning:hover {
    background-color: #d97706 !important;
}

/* Issue Notice Section */
.issue-section {
    background: #fffbea;
    border: 1px solid #fcd34d;
    border-radius: 10px;
    padding: 20px;
    margin-top: 30px;
    text-align: center;
}

.issue-section span {
    font-weight: 600;
    color: #92400e;
}

.issue-section i {
    color: #f59e0b;
}

/* Success / Error Message */
.success-msg .alert {
    border-radius: 8px;
    font-size: 14px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.alert-success {
    background-color: #dcfce7 !important;
    color: #166534 !important;
}

.alert-danger {
    background-color: #fee2e2 !important;
    color: #991b1b !important;
}

/* Checkbox alignment */
#checkedAll {
    transform: scale(1.2);
    cursor: pointer;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .filter-bar {
        padding: 10px;
    }
    .filter-bar .row > div {
        margin-bottom: 10px;
    }
    #datatable {
        font-size: 13px;
    }
}
</style>
<div class="card">
    <h4 style="text-align: center;margin-top: 18px;">
        Acquisition Tea Gardens Dags under Section 7-A of the Assam Fixation of Ceiling on Land Holdings Act, 1956
        </h4>
    <form id="co_bulk_notice" method="post">
        <div class="row px-5" style="margin-top:25px;">
            <table id="datatable" class="datatable table table-stripped">  
                <thead>  
                    <tr>  
                        <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                        <th>Tea Estate Name(Mobile no)</th>
                        <th>Case No</th> 
                        <th>Mouza
                            <select class="form-control" name="mouza_cat" id="mouza_cat">
                                <option value="">select</option>
                                <?php if(isset($select_data)){ foreach($select_data as $select){?>
                                    <option value="<?=$select->mouza_pargona_code?>"><?=$this->utilityclass->getMouzaName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code)?></option>
                                <?php }}?>
                            </select>
                        </th>
                        <th>Lot
                            <select class="form-control" name="lot_cat" id="lot_cat">
                                <option value="">Select Lot</option>
                            </select>
                        </th>
                        <th>Village
                            <select class="form-control" name="category" id="category">
                                <option value="">select</option>
                            </select>
                        </th>  

                        <th>Notice</th>
                        <th>Claims/Objections</th>
                        <th>Proposed Area</th> 
                        <th></th>
                        <th>
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
            
            <div class="row">
                <div class="form-group">
                    <input type="hidden" class="form-control" autocomplete="off" name="remark" value="Forwarded to ADC for hearing" required>
                    <br>
                    <hr>

                    <label class="col-lg-12 col-md-12 col-sm-12 text-left" style=" font-size: 18px; color:#FF5252">
                        <i class="fa fa-hand-o-right"></i>
                        Click on checkboxes to issue notice in bulk
                    </label>
                    <br>

                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 25px">
                
                        <button type="submit" name="generate_notice" formtarget="GenerateNotice" class="btn btn-sm btn-warning">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Issue Notice
                        </button>
                    </div>

                </div>
                <div class="form-group">
                    <span id="error_hear"></span>
                    <ul class="caselist">

                    </ul>
                </div>

            </div>
            
        </div>

    </form>
</div>

 <style>
    /* .dataTables_filter, .dataTables_info { display: none; } */
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>

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
    $(document).on('change', '#mouza_cat, #lot_cat', function(){
        var mouzaCode = $('#mouza_cat').val();
        var lot_no = $('#lot_cat').val();

        var postData = {
            'mouza_pargona_code' : mouzaCode,
            'lot_no' : lot_no,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementCommon/getLotsFromMouzaCo',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();
                if(arr.responseType != 2)
                {
                    showErrorMessage(arr.msg);
                }
                else
                {
                    var options = '<option value="">Select Lot</option>';
                    var options2 = '<option value="">Select Village</option>';

                    if(mouzaCode == '')
                    {
                        $('#lot_cat').html(options);
                        $('#category').html(options2);
                    }

                    if(arr.lot_details != '')
                    {
                        for(i=0; i<arr.lot_details.length; i ++)
                        {
                            options += "<option value='"+arr.lot_details[i].lot_no+"'>"+arr.lot_details[i].loc_name+"</option>";
                        }

                        $('#lot_cat').html(options);
                    }

                    if(arr.village_details != '')
                    {
                        for(i=0; i<arr.village_details.length; i ++)
                        {
                            options2 += "<option value='"+arr.village_details[i].vill_townprt_code+"'>"+arr.village_details[i].loc_name+"</option>";
                        }

                        $('#category').html(options2);
                        
                    }
                    else
                    {
                        $('#category').html(options2);
                    }
                }
            }
        });
    })

</script>

<script>
    $(document).ready(function ()
    {
        $(document).on('change', '#category, #remark_cat, #mouza_cat, #lot_cat, #review_cat', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();
            var nr_cat = $('#nr_cat').val();

            var review_cat = $('#review_cat').val();

        
            $('#datatable').DataTable().destroy();
            if(category != '')
            {
                category = category;
            }
            else
            {
                category = '';
            }
            if(remark_cat != '')
            {
                remark_cat = remark_cat;
            }
            else
            {
                remark_cat = '';
            }

            if(mouza_cat != '')
            {
                mouza_cat = mouza_cat;
            }
            else
            {
                mouza_cat = '';
            }

            if(lot_cat != '')
            {
                lot_cat = lot_cat;
            }
            else
            {
                lot_cat = '';
            }

            load_data(category, remark_cat, mouza_cat, lot_cat, review_cat);

        });

        load_data();

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null, nr_cat=null, payment_status=null, final_verification_report=null, review_cat)
        {

            var review_cat = $('#review_cat').val();

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" data-column-index="1" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(3)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" data-column-index="2" placeholder="Search ' + title + '" />');
            });
            // $('#datatable thead th:nth-of-type(4)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });
            
            var table = $('#datatable').DataTable({
                // "scrollX": true,
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax':{
                    url: base_url+'index.php/Acquisition/cases',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category,
                        remark_cat:remark_cat,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat,
                        nr_cat : nr_cat,
                        payment_status : payment_status,
                        final_verification_report: final_verification_report,
                        review_cat: review_cat
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                // columnDefs: [{
                //     targets: "_all",
                //     orderable: false,
                //     "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6, 7],
                //     }]

                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        'selectRow': true
                    },
                    data: "is_visible",
                    'render': function (data, type, row) {
                        let text = row[0];
                        const myArray = text.split("/");
                        var arr = myArray[3];
                        return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+arr+' name="selectMark[]">';
                    }
                }],
                    
            });

            var selectedCheckBoxArray = [];
            $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
                var checkBoxId = $(this).val();
                var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
                if(this.checked && rowIndex === -1) {
                    selectedCheckBoxArray.push(checkBoxId);
                }
                else if (!this.checked && rowIndex !== -1) {
                    selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
                }
            });

            $("#checkedAll").click(function(){
                if(this.checked){
                    $('.selectMark').each(function(){
                        this.checked = true;
                        var id = $(this).val();
                        if($.inArray(id, selectedCheckBoxArray) !== -1){
                            // $('.selectMark').prop('checked', false);
                        }else{
                            selectedCheckBoxArray.push(id);
                            $('.selectMark').prop('checked', true);
                        }
                    })
                }else{
                    $('.selectMark').each(function(){
                        this.checked = false;
                        var id = $(this).val();
                        var rowIndex = $.inArray(id, selectedCheckBoxArray);
                        if(rowIndex == -1){

                        }else{
                            selectedCheckBoxArray.splice(rowIndex, 1);
                            $('.selectMark').prop('checked', false);
                        }
                    })
                }
                console.log(selectedCheckBoxArray);
            });


            $("#datatable").on('draw.dt', function() {
                for (var i = 0; i < selectedCheckBoxArray.length; i++) {
                    checkboxId = selectedCheckBoxArray[i];
                    const myArray = checkboxId.split("/");
                    var arr = myArray[3];
                    $('#' + arr).attr('checked', true);
                }
            });


            $('.search_button').on('click', function () {
                $('table thead tr th .input_search').each(function(){
                    table.column($(this).data('columnIndex')).search(this.value);
                });
                table.draw();
            });
        }
        
    });

</script>


<script>
    $('#co_bulk_notice').submit(function (e) {
        e.preventDefault();
        if(!confirm("Are you sure you want to issue X notice?"))
        {
            return false;
        }
        // $("#overlay").fadeIn(300);
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        var ct = [];

        var checkboxes = $('input[type="checkbox"]');
        checkboxes.filter(':checked').each(function() {
            var name = this.value;
            ct.push(name);
        });
        if(ct.length  == 0){
            $.unblockUI();
            alert("Please select atleast one checkbox...");
            return false;
        }
        $.ajax({
            url: baseurl + "Acquisition/bulkXnoticeServe",
            type: 'POST',
            data: $("#co_bulk_notice").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();


                if(data.responseType != 2)
                {
                    showErrorMessage(data.message);
                    return false;
                }
                else
                {
                    Swal.fire({
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }

            },
            error: function (error) {
                console.log(error);
                $.unblockUI();
                alert("Something went wrong");
            }

        })

    });
</script>


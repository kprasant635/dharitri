<style>
    /* Center the modal and cover 70% of the screen */
    #modifiedDataModal .modal-dialog {
        max-width: 80%; /* Modal will cover 70% of the screen width */
        margin: auto; /* Ensure modal is horizontally centered */
    }

    #modifiedDataModal .modal-dialog-centered {
        display: flex;
        align-items: center; /* Vertically centers the modal */
        min-height: 100vh; /* Ensures modal is centered even if the page is short */
    }

</style>

<center>
    
    <mark>
        Review-Application Received for MB2 
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
<form id="co_bulk_forward" method="post">

    <table class="datatable table table-stripped" id='datatable'>
        <thead style="font-size:7px">
            <tr>
                <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                <th></th>
                <th></th>
                <th>Occupation
                    <select name="occupation" id="occupation" class="form-control input_search" data-column-index="2">
                        <option value="">Select</option>
                        <option value="SERVICE">SERVICE</option>
                        <option value="PRIVSERV">PRIVSERV</option>
                        <option value="BUSINESS">BUSINESS</option>
                        <option value="PENSIONER">PENSIONER</option>
                        <option value="AGRICULTURE">AGRICULTURE</option>
                        <option value="HOUSEWIFE">HOUSEWIFE</option>
                        <option value="UNEMPLOYED">UNEMPLOYED</option>
                    </select>
                </th>
                <th>
                    Applied for
                </th>
                <th>
                    Flagged in Chitha
                </th>
                <th>Urban/Rural

                    <select class="form-control input_search" name="rural" id="rural" data-column-index="3">
                        <option value="">select</option>
                        <?php if(isset($selectList->urban_check)){ foreach($selectList->urban_check as $rural){
                            ?>
                            <option value="<?=$rural->is_urban?>"><?php if($rural->is_urban == 'Y'){echo 'Urban';}else{echo "Rural";}?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>Name 
                    <select class="form-control input_search" name="category" id="category" data-column-index="4">
                        <option value="">select</option>
                        <?php if(isset($selectList->vill_list)){ foreach($selectList->vill_list as $vill){
                            ?>
                            <option value="<?=$vill->village_code?>"><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_code, $vill->lot_no, $vill->village_code)?></option>
                        <?php }}?>
                    </select>
                </th>
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
            <input type="hidden" name="service_code" id="service_code" value="<?=$_GET['service']?>">
            
            <br>
            <hr>

            <label class="col-lg-12 col-md-12 col-sm-12 text-left" style=" font-size: 18px; color:#FF5252">
                <i class="fa fa-hand-o-right"></i>
                Click on checkboxes to forward multiple cases for review. All forwarded cases will be available at LRA...
            </label>

            <br>
            <strong><small>Note - By forwarding the case(s) will register again with a new case no and process will be same as the old process.</small></strong> 
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 25px">
                <textarea name="remark" id="remark" class="form-control p-2" placeholder="Please Enter remark..." style="border: 3px solid black;"></textarea>

                <button type="submit" name="forward_submit" formtarget="Forward" class="btn btn-sm btn-warning mt-3">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    Forward Case(s) for review...
                </button>
            </div>

        </div>
        <div class="form-group">
            <span id="error_hear"></span>
            <ul class="caselist">

            </ul>
        </div>

    </div>
</form>

<div id="render_id"></div>



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
    $(document).ready(function ()
    {
        $('#rural, #category, #occupation').change(function(){
            var rural = $('#rural').val();
            var category = $('#category').val();
            var occupation = $('#occupation').val();
            $('#datatable').DataTable().destroy();

            load_data(category,rural,occupation);
    
        });

        load_data();

        function load_data(category,rural,occupation)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = <?=$service?>;

            $('#datatable thead th:nth-of-type(2)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
                var title = 'Application No';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
            });

            $('#datatable thead th:nth-of-type(3)').each(function () {
                // var title = $(this).text();
                // $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
                var title = 'Application Date';
                $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
            });
            
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
                    url: base_url+'index.php/SettlementReviewController/paginationAPIBulk',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        rural:rural,
                        occupation:occupation,
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                // columnDefs: [{
                //     targets: "_all",
                //     orderable: false,
                //     "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
                //     }],

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
                        return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+arr+' name="selected_applications[]">';
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
 

<script>
    $('#co_bulk_forward').submit(function (e) {
        e.preventDefault();
        if(!confirm("Are you sure you want to revert this cases?"))
        {
            return false;
        }
 
        var ct = [];

        var checkboxes = $('input[type="checkbox"]');
        checkboxes.filter(':checked').each(function() {
            var name = this.value;
            ct.push(name);
        });
        if(ct.length  == 0){
            showErrorMessage("Please select atleast one checkbox...");
            return false;
        }

        if($('#remark').val() == ''){
            showErrorMessage('Please enter remark!');
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
            url: baseurl + "SettlementReviewController/bulkForwardSubmit",
            type: 'POST',
            data: $("#co_bulk_forward").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();


                if(data.responseType != 2)
                {
                    showErrorMessage(data.msg);
                    return false;
                }
                else
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

<script>
    function viewModifiedData(application_no){

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
   
       $.ajax({
            url: baseurl+'SettlementReviewController/getModifiedReviewData',
            type: "POST",
            data: {application_no: application_no},
            success: function(data) {
                $.unblockUI();

                $('#render_id').html(data);
                $('#modifiedDataModal').modal('show');                
            }
        });

    }

    $(document).on('click','#modifiedDataModallNo',function ()
    {
        $('#modifiedDataModal').modal('hide');
    });
</script>
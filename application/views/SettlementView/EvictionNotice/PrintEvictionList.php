<style>
    .card:hover{
        transform: none!important;
        margin: 0!important;
        padding:0!important;

    }

</style>

<div class="container">
    <h5 class="text-center p-3 bg-warning text-white shadow">Eviction Notice List</h5>
    <form id="co_bulk_notice" method="post">

        <div class="table-wrap shadow p-2">
            <table class="table datatable" id="datatable">
                <thead>
                    <tr>
                        <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                        <th>Application No</th>
                        <th>Case No</th>
                        <th>
                            Service <br>
                            <select name="service_cat" id="service_cat" data-column-index="3">
                                <option value="16">Khasland</option>
                                <option value="15">Tribal</option>
                                <option value="18">Cultivation</option>
                                <option value="14">AP</option>
                                <option value="13">Tenant</option>
                                <option value="17">VGR/PGR</option>
                            </select>
                        </th>
                        <th>
                            Circle <br>
                            <select name="circle_cat" id="circle_cat" data-column-index="4">
                                <option value="">--select--</option>
                                <?php 
                                    if($circle_list != false){
                                        foreach($circle_list as $select){
                                            ?>
                                            <option value="<?=$select->uuid?>">
                                                <?=$this->utilityclass->getCircleName($select->dist_code, $select->subdiv_code, $select->cir_code)?>
                                            </option>
                                            <?php 
                                        }
                                    }
                                ?>
                            </select>
                        </th>
                        <th>
                            Lot <br>
                            <select name="lot_cat" id="lot_cat" data-column-index="5">
                                <option value="">--select--</option>
                            </select>
                        </th>
                        <th>
                            Village <br>
                            <select name="village_cat" id="village_cat" data-column-index="6">
                                <option value="">--select--</option>
                            </select>
                        </th>
                        <th>
                            Action
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
        </div>

        <!-- <div class="row">
            <div class="form-group">
                <input type="hidden" class="form-control" autocomplete="off" name="remark" value="Forwarded to ADC for hearing" required>
                <br>
                <hr>

                <label class="col-lg-12 col-md-12 col-sm-12 text-left" style=" font-size: 18px; color:#FF5252">
                    <i class="fa fa-hand-o-right"></i>
                    Generate bulk Eviction notice...
                </label>
                <br>

                <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 25px">
            
                    <button type="submit" name="generate_notice" formtarget="GenerateNotice" class="btn btn-sm btn-warning">
                        Generate Notice
                    </button>
                </div>

            </div>
            <div class="form-group">
                <span id="error_hear"></span>
                <ul class="caselist">

                </ul>
            </div>

        </div> -->
    </form>
</div>


<div class="modal" role="dialog" id="viewNoticeModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body" id="printableArea">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="noticeSaveModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="noticeSaveModalYes">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    &nbsp;SAVE NOTICE
                </button>
            </div>
        </div>
    </div>
</div>



<style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>


<script>
    $(document).on('change', '#circle_cat', function(){
        var circle_uuid = $('#circle_cat').val();

        var postData = {
            'circle_uuid' : circle_uuid,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementEvictionController/getlotsByUUID',
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
                    var options2 = '<option value="">Select Lot</option>';
                    var options3 = '<option value="">Select Village</option>';
                    for(i=0; i<arr.data.length; i++){
                        options2 += '<option value="'+arr.data[i].uuid+'">'+arr.data[i].loc_name+'</option>';
                    }
                    $('#lot_cat').html(options2);   
                    $('#village_cat').html(options3);
                }
            }
        });
    })

    $(document).on('change', '#lot_cat', function(){
        var lot_uuid = $('#lot_cat').val();
        var postData = {
            'lot_uuid' : lot_uuid,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    
        $.ajax({
            url: baseurl+'SettlementEvictionController/getVillagesByUUID',
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
                    var options2 = '<option value="">Select village</option>';
                    for(i=0; i<arr.data.length; i++){
                        options2 += '<option value="'+arr.data[i].uuid+'">'+arr.data[i].loc_name+'</option>';
                    }
                    $('#village_cat').html(options2);   
                }
            }
        });
    })
</script>

<script>
    $(document).ready(function () {
        $(document).on('change', '#service_cat, #circle_cat, #lot_cat, #village_cat', function(){
            console.log('Change event triggered');

            var service_code = $('#service_cat').val();
            var circle_uuid = $('#circle_cat').val();
            var lot_uuid = $('#lot_cat').val();
            var village_uuid = $('#village_cat').val();
            
            $('#datatable').DataTable().destroy();

            load_data(service_code, circle_uuid, lot_uuid, village_uuid);
        });

        load_data();

        function load_data(service_code=null, circle_uuid=null, lot_uuid=null, village_uuid=null) {
            if(service_code === null){
                service_code = $('#service_cat').val();
            }

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+'<br> <input class="input_search" type="text" data-column-index="1" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(3)').each(function () {
                var title = $(this).text();
                $(this).html(title+'<br> <input class="input_search" type="text" data-column-index="2" placeholder="Search ' + title + '" />');
            });
            
            var table = $('#datatable').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                        },
                'ajax': {
                    url: baseurl + 'SettlementEvictionController/printPaginationList',
                    type: 'POST',
                    data: {
                        service_code: service_code,
                        circle_uuid: circle_uuid,
                        lot_uuid: lot_uuid,
                        village_uuid: village_uuid
                    },
                    deferLoading: 57,
                },

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
    $('#co_bulk_notice').submit(function (e) {
        e.preventDefault();
        if(!confirm("Are you sure you want to generate eviction notice for this cases?"))
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
            url: baseurl + "SettlementEvictionController/generateEvictionNoticeBulk",
            type: 'POST',
            data: $("#co_bulk_notice").serialize(),
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

    function evictionNoticeSingle(case_no){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        
        $.ajax({
            url: baseurl + "SettlementEvictionController/generateEvictionNotice",
            type: 'POST',
            data: {case_no: case_no, view:true},
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
                    $('#viewNoticeModal').modal({backdrop: 'static', keyboard: false});
                    $('#viewNoticeModal').modal('show');
                    $('#printableArea').html(data.notice_content);
                }

            },
            error: function (error) {
                console.log(error);
                $.unblockUI();
                alert("Something went wrong");
            }

        })
    }

    $(document).on('click','#noticeSaveModalNo',function ()
    {
        $('#viewNoticeModal').modal('hide');
    });

    $(document).on('click','#noticeSaveModalYes',function ()
    {
        $('#viewNoticeModal').modal('hide');
        var nextval = $('#nextval').val();
        var case_no = $('#case_no_id').val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        
        $.ajax({
            url: baseurl + "SettlementEvictionController/generateEvictionNotice",
            type: 'POST',
            data: {nextval: nextval, case_no: case_no},
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
                    $('#viewNoticeModal').modal('hide');
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

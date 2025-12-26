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
        Rejected Cases list 
    </mark>
        
    <br>
    <mark>
        <strong style="font-size: 20px;">
            Filter by Remark Head
        </strong>
    </mark>
    
</center>
<form id="co_bulk_forward" method="post">

    <table class="datatable table table-stripped" id='datatable'>
        <thead style="font-size:7px">
            <tr>
                <!-- <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th> -->
                <th></th>
                <th></th>
                <th>Applicant Name</th>
                <th>Village list 
                    <select class="form-control input_search" name="category" id="category" data-column-index="4">
                        <option value="">select</option>
                        <?php if(isset($selectList)){ foreach($selectList as $vill){
                            ?>
                            <option value="<?=$vill->dist_code.'_'.$vill->subdiv_code.'_'.$vill->cir_code.'_'.$vill->mouza_pargona_code.'_'.$vill->lot_no.'_'.$vill->vill_townprt_code?>"  ><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_pargona_code, $vill->lot_no, $vill->vill_townprt_code)?></option>
                        <?php }}?>
                    </select>
                </th>
                <th>Service
                    <select name="service" id="service" class="form-control input_search" data-column-index="2">
                        <option value="16">Settlement Khasland</option>
                        <option value="13">Settlement Tenant</option>
                        <option value="14">Settlement AP</option>
                        <option value="15">Settlement Tribal</option>
                        <option value="17">Settlement PGR/VGR</option>
                        <option value="18">Settlement Cultivation</option>
                    </select>
                </th>
                <th>Remark Head
                    <select name="remark_head" id="remark_head" class="form-control input_search" data-column-index="2">
                        <?php
                        foreach(json_decode(REJECTED_REMARK_HEAD) as $r_head){
                            ?>
                            <option value="<?=$r_head->CODE?>"><?=$r_head->NAME?></option>
                            <?php
                        }
                        ?>
                    </select>
                </th>
       
                <th>Rejected for reasons
                    <button type="button" class="search_button btn btn-sm btn-success form-control col-2">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        Search
                    </button>
                    <!-- <button type="button" class="btn btn-sm btn-danger" id="excelDwn">Download Excel</button> -->
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
                --Download excel file--
            </label>

            <br>
            <strong><small>Download excel file with rejected reasons...</small></strong> 
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 25px">
                <button type="button" onclick="downloadExcel()" name="forward_submit" formtarget="Forward" class="btn btn-sm btn-warning mt-3">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    Click to Download Excel file
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
        $('#category, #remark_head, #service').change(function(){
            var category = $('#category').val();
            var remark_head = $('#remark_head').val();
            var service = $('#service').val();
            $('#datatable').DataTable().destroy();
            load_data(category,remark_head, service);
    
        });

        $('#excelDwn').click(function(){
            var category = $('#category').val();
            var remark_head = $('#remark_head').val();
            var service = $('#service').val();
            $('#datatable').DataTable().destroy();

            load_data(category,remark_head, service, true);
        });

        load_data();

        function load_data(category,remark_head, service, download=false)
        {
            var base_url = "<?php echo base_url();?>";
            var service_code = $('#service').val();

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = 'Case No';
                $(this).html('<input type="text" id="case_no" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = 'Application No';
                $(this).html('<input type="text" id="application_no" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
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
                    url: base_url+'index.php/SettlementCommon/paginationRejectedReasons',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:category,
                        remark_head:remark_head,
                        download:download,
                    },
                    deferLoading: 57,
                },
                    
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


<script>
    function downloadExcel(){
        var case_no = $('#case_no').val();
        var app_no = $('#application_no').val();
        var location = $('#category').val();
        var service_code = $('#service').val();
        var remark_head = $('#remark_head').val();
        var url = baseurl+"SettlementCommon/test" +
                "?case_no=" + case_no +
                "&app_no=" + app_no +
                "&location=" + location +
                "&service_code=" + service_code +
                "&remark_head=" + remark_head;


        window.location.href = url;
    }
</script>
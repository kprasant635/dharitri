<style>
    .checkBoxD{

        width: 20px;
        height: 20px;
    }
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }


</style>

<div class="row" style='padding: 30px 40px 30px 10px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
        <?php endif; ?>
        <div class="reza-card">
            <div class="reza-title">
                <?php echo $this->session->userdata('user_desig_code'); ?> Revival flagged Cases
                <hr>
            </div>

            <div class="reza-body">
                <form id="co_bulk_notice" method="post">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <table id="datatable" class="datatable table table-stripped">
                                <thead>
                                <tr>
                                    <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                                    <th>Case No</th>
                                    <th>Application No</th>
                                    <th>Mouza
                                        <select class="form-control input_search" name="mouza_cat" id="mouza_cat">
                                            <option value="">select</option>
                                            <?php if(isset($select_data)){ foreach($select_data as $select){?>
                                                <option value="<?php echo $select->dist_code."_".$select->subdiv_code."_".$select->cir_code."_".$select->mouza_pargona_code?>"><?=$this->utilityclass->getMouzaName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code)?></option>
                                            <?php }}?>
                                        </select>
                                    </th>
                                    <th>Lot
                                        <select class="form-control input_search" name="lot_cat" id="lot_cat">
                                            <option value="">Select Lot</option>
                                        </select>
                                    </th>
                                    <th>Village
                                        <select class="form-control input_search" name="category" id="category">
                                            <option value="">select</option>
                                        </select>
                                    </th>
                                    <th>Revival Reason</th>

                                    <th>
                                        <label for="">Rejected for</label>
                                        <select name="r_head_filter" id="r_head_filter" class="form-control">
                                            <option value="">--select--</option>
                                            <option value="10">Self flagged</option>

                                            <?php
                                                foreach($rejected_array as $rejectedrow)
                                                {
                                                ?>
                                                    <option value="<?=$rejectedrow->reject_code?>"><?=$rejectedrow->remark?></option>

                                                <?php
                                                }
                                            ?>
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
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="form-group">
                            <input type="hidden" class="form-control" autocomplete="off" name="remark" value="Forwarded to ADC for hearing" required>
                            <br>
                            <hr>

                            <label class="col-lg-12 col-md-12 col-sm-12 text-left" style=" font-size: 18px; color:#FF5252">
                                <i class="fa fa-hand-o-right"></i>
                                Click on checkboxes to revive multiple cases. All revived cases will be available at CO first proceeding...
                            </label>
                            <br>

                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 25px">
                                <?php
                                if(REVIVE_CASE_BUTTON != 0)
                                {
                                    ?>
                                    <button type="submit" name="generate_notice" formtarget="GenerateNotice" class="rezaButt">
                                        <i class="fa fa-recycle" aria-hidden="true"></i>
                                        Revive Selected cases
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                        <div class="form-group">
                            <span id="error_hear"></span>
                            <ul class="caselist">

                            </ul>
                        </div>

                    </div>
                </form>
            </div>

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
        $(document).on('change', '#mouza_cat, #lot_cat', function(){
            var mouzaCode = $('#mouza_cat').val();
            var lot_no = $('#lot_cat').val();

            locationArr = mouzaCode.split("_");

            var dist_code = String(locationArr[0]);
            var subdiv_code = String(locationArr[1]);
            var cir_code = String(locationArr[2]);
            var mouza_pargona_code = String(locationArr[3]);

            var postData = {
                'dist_code' : dist_code,
                'subdiv_code' : subdiv_code,
                'cir_code' : cir_code,
                'mouza_pargona_code' : mouza_pargona_code,
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
                url: baseurl+'SettlementCommon/getLotsFromMouza',
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
            $(document).on('change', '#category, #mouza_cat, #lot_cat, #r_head_filter', function(){
                var category = $('#category').val();
                var mouza_cat = $('#mouza_cat').val();
                var lot_cat = $('#lot_cat').val();

                var r_head_filter = $('#r_head_filter').val();

                locationArr = mouza_cat.split("_");

                var dist_code = String(locationArr[0]);
                var subdiv_code = String(locationArr[1]);
                var cir_code = String(locationArr[2]);
                var mouza_pargona_code = String(locationArr[3]);

                $('#datatable').DataTable().destroy();
                if(category != '')
                {
                    category = category;
                }
                else
                {
                    category = '';
                }


                if(lot_cat != '')
                {
                    lot_cat = lot_cat;
                }
                else
                {
                    lot_cat = '';
                }

                if(r_head_filter != '')
                {
                    r_head_filter = r_head_filter;
                }
                else
                {
                    r_head_filter = '';
                }

                if(mouza_cat != '')
                {
                    if(dist_code != '')
                    {
                        dist_code = dist_code;
                    }
                    else
                    {
                        dist_code = '';
                    }
                    if(subdiv_code != '')
                    {
                        subdiv_code = subdiv_code;
                    }
                    else
                    {
                        subdiv_code = '';
                    }
                    if(cir_code != '')
                    {
                        cir_code = cir_code;
                    }
                    else
                    {
                        cir_code = '';
                    }
                    if(mouza_pargona_code != '')
                    {
                        mouza_pargona_code = mouza_pargona_code;
                    }
                    else
                    {
                        mouza_pargona_code = '';
                    }
                }
                else
                {
                    dist_code = ''
                    subdiv_code = ''
                    cir_code = ''
                    mouza_pargona_code = ''
                }

                load_data(category,  dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_cat, r_head_filter);

            });

            load_data();

            function load_data(is_category = null, dist_code =null, subdiv_code = null, cir_code = null, mouza_pargona_code = null, lot_cat=null, r_head_filter =null)
            {

                var base_url = "<?php echo base_url();?>";
                var service_code = "<?=$_GET['service']?>";
                var s = "<?=$_GET['s']?>";

                $('#datatable thead th:nth-of-type(2)').each(function () {
                    var title = $(this).text();
                    $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
                });

                $('#datatable thead th:nth-of-type(3)').each(function () {
                    var title = $(this).text();
                    $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="2"/>');
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
                        url: base_url+'index.php/SettlementCommon/revivalPagination',
                        type:'POST',
                        data: {
                            service:service_code,
                            status:s,
                            is_category:is_category,
                            r_head_filter : r_head_filter,
                            dist_code: dist_code,
                            subdiv_code: subdiv_code,
                            cir_code: cir_code,
                            mouza_pargona_code: mouza_pargona_code,
                            lot_no : lot_cat,
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


                    // order: [[2, 'asc']],
                    // columnDefs: [{
                    //     targets: "_all",
                    //     orderable: false,
                    //     "className": "dt-center", "targets":[ 1, 2, 3, 4, 5, 6, 7],
                    //     }]

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



                // table.columns().every(function () {
                //     var table = this;
                //     $('input', this.header()).on('keyup change', function () {
                //         if (table.search() !== this.value) {
                //                 table.search(this.value).draw();
                //         }
                //     });
                // });
            }

        });

    </script>

    <script>
        $('#co_bulk_notice').submit(function (e) {
            e.preventDefault();
            if(!confirm("Are you sure you want to revive this cases?"))
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
                url: baseurl + "SettlementCommon/bulkReviveCases",
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
    </script>

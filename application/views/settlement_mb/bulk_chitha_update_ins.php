<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Chitha Update List
            <b>(Please select upto village to view result...)</b>
        </h4>
    </div>
    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>



<style>
    #datatable {
        font-size: 14px!important; /* Adjust the font size as needed */
    }

    #datatable th,
    #datatable td {
        font-size: 14px!important; /* Adjust the font size as needed */
    }
</style>

<form id="co_bulk_notice" method="post">
    <div class="row px-5">
        <table id="datatable" class="datatable table table-stripped">  
            <thead>  
                <tr>  
                    <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                    <th>Case No</th> 
                    <th>Application No</th> 
                    <th>Mouza
                        <select class="form-control" name="mouza_cat" id="mouza_cat">
                            <option value="">select</option>
                            <?php if(isset($select_data)){ 
                                $mc = '';
                                foreach($select_data as $select){
                                    if($mc != $select->mouza_pargona_code){
                                        ?>

                                        <option value="<?=$select->mouza_pargona_code?>"><?=$this->utilityclass->getMouzaName($select->dist_code, $select->subdiv_code, $select->cir_code, $select->mouza_pargona_code)?></option>
                                        
                                        <?php 
                                    }
                                $mc = $select->mouza_pargona_code;
                                }
                            }?>
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

                    <th>Submission Date</th>
                    <!-- <th>
                        <select class="form-control" data-column-index="2" id="remark_cat"
                                name="remark_cat">
                            <option value="">LM Remark Category...</option>
                            <option value="1">Recommended</option>
                            <option value="2">Not Recommended</option>
                        </select>
                    </th>                    -->

                    <th>
                        Payment Type
                        <select class="form-control" name="p_type" id="p_type">
                            <option value="">select</option>
                            <option value="f">Full</option>
                            <option value="p">Partial</option>
                        </select>
                    </th>

                    <th>
                        Landclass missing
                        <select class="form-control" name="l_mis" id="l_mis">
                            <option value="">select</option>
                            <option value="l_not_mis">landclass not missing</option>
                            <option value="l_miss">landclass missing</option>
                        </select>
                    </th>
                    <th>
                        <select name="allotment_settlement" class="form-control" data-column-index="5" id="allotment_settlement">
                            <option value="">Allotment/Settlement Category</option>
                            <option value="8">State govt</option>
                            <option value="9">State Govt Undertaking</option>
                            <option value="10">Central Govt Dept.</option>
                            <option value="11">Central Govt Undertaking</option>
                            <option value="12">Non Govt.</option>
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
        <?php if(CHITHA_UPDATE_INSTITUTION == 1)
        { ?>
            <div class="row">
            <div class="form-group">
                <input type="hidden" class="form-control" autocomplete="off" name="remark" value="Forwarded to ADC for hearing" required>
                <br>
                <hr>

                <label class="col-lg-12 col-md-12 col-sm-12 text-left" style=" font-size: 18px; color:#FF5252">
                    <i class="fa fa-hand-o-right"></i>
                    Click on checkboxes to update multiple cases chitha (MAX 3 allowed)...
                </label>
                <br>

                <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 25px">
                    <button type="submit" name="generate_notice" formtarget="GenerateNotice" class="btn btn-sm btn-warning">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        Approve Selected Cases
                    </button>
                </div>

            </div>
            <div class="form-group">
                <span id="error_hear"></span>
                <ul class="caselist">

                </ul>
            </div>

        </div>
        <?php } ?>
        
        
    </div>

</form>

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
        $(document).on('change', '#category, #p_type, #l_mis,#allotment_settlement', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();
            var nr_cat = $('#nr_cat').val();
            var p_type = $('#p_type').val();
            var l_mis = $('#l_mis').val();
            var allotment_settlement = $('#allotment_settlement').val();

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

            if(p_type != '')
            {
                p_type = p_type;
            }
            else
            {
                p_type = '';
            }

            if(l_mis != '')
            {
                l_mis = l_mis;
            }
            else
            {
                l_mis = '';
            }

            // if(category != ''){
            load_data(category, remark_cat, mouza_cat, lot_cat, p_type, l_mis,allotment_settlement);

            // }
        });

        load_data();

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null, p_type = null, l_mis=null,allotment_settlement=null)
        {
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
            $('#datatable').DataTable().destroy();
            
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
                    url: base_url+'index.php/SettlementInstitutionCo/paginationBulkChitaUpdate',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category,
                        remark_cat:remark_cat,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat,
                        p_type : p_type,
                        l_mis : l_mis,
                        allotment_settlement : allotment_settlement
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
        if(!confirm("Are you sure you want to udpate chitha for this cases?"))
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
            url: baseurl + "SettlementInstitutionCo/bulkChithaUpdate",
            type: 'POST',
            data: $("#co_bulk_notice").serialize(),
            dataType: 'json',
            success: function (data) {
                console.log(data);
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
                        html: "Failed Cases:" + JSON.parse(data.failed) + "<br> Completed Cases: "+JSON.parse(data.passed),
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


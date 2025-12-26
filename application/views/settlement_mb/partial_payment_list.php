<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Partial Payment Confirmation List(paid via Challan)
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
                    <!-- <th>All <br><input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th> -->
                    <th>Case No</th> 
                    <th>Application No</th> 
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

                    <th>Submission Date</th>
                    <!-- <th>
                        <select class="form-control" data-column-index="2" id="remark_cat"
                                name="remark_cat">
                            <option value="">LM Remark Category...</option>
                            <option value="1">Recommended</option>
                            <option value="2">Not Recommended</option>
                        </select>
                    </th>                    -->

                    <!-- <th>
                        Payment Type
                        <select class="form-control" name="p_type" id="p_type">
                            <option value="">select</option>
                            <option value="f">Full</option>
                            <option value="p">Partial</option>
                        </select>
                    </th> -->

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
        $(document).on('change', '#category, #remark_cat, #mouza_cat, #lot_cat, #p_type', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();
            var nr_cat = $('#nr_cat').val();
            // var p_type = $('#p_type').val();

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

            // if(p_type != '')
            // {
            //     p_type = p_type;
            // }
            // else
            // {
            //     p_type = '';
            // }

            load_data(category, remark_cat, mouza_cat, lot_cat);

        });

        load_data();

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null)
        {
            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" data-column-index="1" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="input_search form-control form-control-sm" data-column-index="2" placeholder="Search ' + title + '" />');
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
                    url: base_url+'index.php/SettlementMbCo/paginationPartialPaymentList',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category,
                        remark_cat:remark_cat,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat,
                        // p_type : p_type
                    },
                    deferLoading: 57,
                },

                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
                }]
                    
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
            url: baseurl + "SettlementMbCo/bulkChithaUpdate",
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
                        title: "Failed Cases:" + data.history,
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


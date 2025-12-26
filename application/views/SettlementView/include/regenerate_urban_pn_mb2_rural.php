
<style>
    #datatable {
        font-size: 14px!important; /* Adjust the font size as needed */
    }

    #datatable th,
    #datatable td {
        font-size: 14px!important; /* Adjust the font size as needed */
    }
</style>

<div class="row px-5">
    <table id="datatable" class="datatable table table-stripped">  
            <thead>  
                <tr>  
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

                    <?php
                        // if(isset($service_code))
                        // {
                        //     if($service_code == '14')
                        //     {
                                ?>
                                    <!-- <th>
                                        NR Completed(Yes/No)
                                        <select class="form-control" name="nr_cat" id="nr_cat">
                                            <option value="">select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </th>   -->
                                <?php
                        //     }
                        // }
                    ?>
                    <?php
                    if($_GET['s'] != 'N')
                    {
                    ?>
                        <th>
                            Submission Date
                            <input type="date" class="form-control" id="sub_date" name="sub_date">
                        </th>
                        <th>
                            <select class="form-control" data-column-index="2" id="remark_cat"
                                    name="remark_cat">
                                <option value="">LM Remark Category...</option>
                                <option value="1">Recommended</option>
                                <option value="2">Not Recommended</option>
                            </select>
                        </th>

                        <th>
                                <select name="co_approved" class="form-control" data-column-index="4" id="co_approved">
                                    <option value="">CO Approved</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </th>
                        <?php 
                    }?>
                    <?php
                        if($_GET['s'] == 'N')
                        {
                            ?>
                            <!-- <th>Payment status</th> -->
                            <th>
                                <select name="payment_status" class="form-control" data-column-index="3" id="payment_status">
                                    <option value="">Select Payment Status</option>
                                    <option value="paid">PAID</option>
                                    <option value="unpaid">NOT PAID</option>
                                </select>
                            </th>
                            <!-- <th>
                                <select name="payment_status" class="form-control" data-column-index="3" id="payment_status">
                                    <option value="">-Find issue cases-</option>
                                    <option value="land_class_issue">Issue Cases</option>
                                </select>
                            </th> -->

                            <th>
                                <select name="final_verification_report" class="form-control" data-column-index="4" id="final_verification_report">
                                    <option value="">Verification report(LM)</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="land_class_issue">Missing Landclass Cases</option>

                                </select>
                            </th>

                            <th>
                                <select name="co_approved" class="form-control" data-column-index="4" id="co_approved">
                                    <option value="">CO Approved</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </th>
                            <?php
                        }
                    ?>
                    <th>Action</th>
                </tr>  
            </thead>  
            <tbody>

            </tbody>
    </table>  
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
        $(document).on('change', '#category, #remark_cat, #mouza_cat, #lot_cat, #nr_cat, #payment_status, #final_verification_report, #co_approved', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();
            var nr_cat = $('#nr_cat').val();

            var final_verification_report = $('#final_verification_report').val();
            var co_approved = $('#co_approved').val();

            var payment_status = $('#payment_status').val();

            var sub_date  = $('#sub_date').val();

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
            if(nr_cat != '')
            {
                nr_cat = nr_cat;
            }
            else
            {
                nr_cat = '';
            }

            if(payment_status != '')
            {
                payment_status = payment_status
            }
            else
            {
                payment_status = '';
            }

            if(final_verification_report != '')
            {
                final_verification_report = final_verification_report;
            }
            else
            {
                final_verification_report = '';
            }
            if(co_approved != '')
            {
                co_approved = co_approved;
            }
            else
            {
                co_approved = '';
            }

            if(sub_date != '')
            {
                sub_date = sub_date;
            }
            else
            {
                sub_date = '';
            }

            load_data(category, remark_cat, mouza_cat, lot_cat, nr_cat, payment_status, final_verification_report, co_approved, sub_date);

        });

        load_data();

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null, nr_cat=null, payment_status=null, final_verification_report=null, co_approved = null, sub_date = null)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            var sub_date  = $('#sub_date').val();

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
                    url: base_url+'index.php/SettlementCommon/notPaidReGeneratepaginationRural',
                    type:'POST',
                    data: {
                        service                   : service_code,
                        status                    : s,
                        is_category               : is_category,
                        remark_cat                : remark_cat,
                        mouza_pargona_code        : mouza_cat,
                        lot_no                    : lot_cat,
                        nr_cat                    : nr_cat,
                        payment_status            : payment_status,
                        final_verification_report : final_verification_report,
                        co_approved               : co_approved,
                        sub_date                  : sub_date
                    },
                    deferLoading: 57,
                },

                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6, 7],
                }]
                    
            });

            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                            table.search(this.value).draw();
                    }
                });
            });
        }
        
    });

</script>


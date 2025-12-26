<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Cases for Offer of Allotment/Settlement (Bulk Printing Only)
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
<form id="bulk_payment_notice_generate_form_print" method="post">
<div class="row px-5">
    <table id="datatable" class="datatable table table-stripped">  
            <thead>  
                <tr> 
                    <th>All<input  type="checkbox" class="checkBoxD " value="all" id="checkedAll1"></th>
                    <th>Case no</th>
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
                    
                    <?php if($_GET['s'] == 'N') { ?>
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
                                    <option value="">Verification report(LRA)</option>
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
                    <?php } ?>
                    <th>Action
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
<?php if($_GET['service'] == '45') { ?>
    <div class="row pt-2 urbanrural_show" >
        <div class="col-lg-12">
            <div class="mt-4 row px-5">
                <div class="col-md-7">
                    <b style="color:#ff681d"><i class="fa fa-hand-o-right"></i> Click here for Bulk print [offer of allotment/settlement]</b>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="bulk_ins_print" formtarget="bulk_payment_notice_generate_form_print" class=" text-white btn btn-primary" ><i class="fa fa-print" aria-hidden="true"></i> Print </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <span id="error_hear"></span>
            <ul class="caselist">
                
            </ul>
        </div>
    </div>
<?php } ?>
</form>
 <style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>


<script>
    // function coForm(){
    //     let x = document.forms["bulk_payment_notice_generate_form"]["remark_co_text"].value;
    //     // let y = document.forms["bulk_payment_notice_generate_form"]['remark_co_type'].value;
    //     //let z = document.forms['co_form_sub']['remark_co'].value;
    //     //let z =  $("#remark_co_text").val();
    //     if (x == "") {
    //         showErrorMessage("Remarks field can not be empty");
    //         $(".remark_co_text").focus();
    //         return false;
    //     }
    //     // if (y == "") {
    //     //     alert("Select remark type.");
    //     //     $("#remark_co_type").focus();
    //     //     return false;
    //     // }
    //     // if (z == "") {
    //     //     alert("Enter remark.");
    //     //     $("#remark_co_text").focus();
    //     //     return false;
    //     // }
    // }


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
        $(document).on('change', '#category, #remark_cat, #mouza_cat, #lot_cat, #nr_cat, #payment_status, #final_verification_report, #co_approve,#allotment_settlement', function(){
            var category = $('#category').val();

            var remark_cat = $('#remark_cat').val();

            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();
            var nr_cat = $('#nr_cat').val();

            var final_verification_report = $('#final_verification_report').val();
            var co_approved = $('#co_approved').val();

            var payment_status = $('#payment_status').val();
            var allotment_settlement = $('#allotment_settlement').val();

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
            if(allotment_settlement != '')
            {
                allotment_settlement = allotment_settlement;
            }
            else
            {
                allotment_settlement = '';
            }

            load_data(category, remark_cat, mouza_cat, lot_cat, nr_cat, payment_status, final_verification_report, co_approved,allotment_settlement);

        });

        load_data();

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null, nr_cat=null, payment_status=null, final_verification_report=null, co_approved = null,allotment_settlement = null)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var s = "<?=$_GET['s']?>";

            // $('#datatable thead th:nth-of-type(2)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });

            // $('#datatable thead th:nth-of-type(3)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });

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
                    url: base_url+'index.php/SettlementInstitutionCo/offerLetterListCases',
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
                        co_approved: co_approved,
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
                  // 'render': function (data, type, row) {
                  //   // console.log(row);
                  //   let text = row[0];
                  //   if(text != 'N'){
                  //       $('#checkedAll1').show();
                  //       const myArray = text.split("/");
                  //       var arr = myArray[3];
                  //       return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+arr+' name="selectMark[]">';
                  //   }else{
                  //       $('#checkedAll1').hide();
                  //       return '---';
                  //   }
                    
                  // }
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
              console.log(selectedCheckBoxArray);
            });

            $("#checkedAll1").click(function(){
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
$('#bulk_payment_notice_generate_form_print').submit(function (e) {
    e.preventDefault();
    if(!confirm("Are you sure you want to print this selected cases?"))
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
        showErrorMessage("Please select atleast one checkbox...");
        return false;
    }
    $.ajax({
        url: baseurl + "SettlementInstitutionCo/bulkPrintPaymentNoticeInstitution",
        type: 'POST',
        data: $("#bulk_payment_notice_generate_form_print").serialize(),
        dataType: 'json',
        success: function (data) {
            $.unblockUI();
            var list = null; 
            var listing = "";
            if(data.responseType == 2)
            {
                var htmlContent = `
                <html>
                <head>
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
                </head>
                <body>
                  ${JSON.parse(data.list)}
                </body>
                </html>
                `;
                 // Open a new window and write the HTML
                var printWindow = window.open('', '_blank');
                printWindow.document.write(htmlContent);
                printWindow.document.close();
                printWindow.focus();
                // printWindow.print();
                // printWindow.close();
                return;
                
            }
            else if(data.responseType == 3)
            {
                $.unblockUI();
                showErrorMessage("Something went wrong");
                location.reload(true);
            }



        },
        error: function (error) {
            console.log(error);
            $.unblockUI();
            showErrorMessage("Something went wrong");
            location.reload(true);
        }

    });
});

</script>


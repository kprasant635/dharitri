<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 900px;
    }
    /* The Close Button */
    .close-modal {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close-modal:hover,
    .close-modal:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
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

    .rezaInfo {
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        color: #FFF;
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

    td{
        font-size: 17px!important;;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }

</style>

<div class="row" style='padding: 20px 30px 20px 0px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if($this->session->flashdata('success')) { ?>

            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
        <?php endif; ?>


        <div class="reza-card">
            <div class="reza-title">
                MB2 review application list
                <div class="row">
                    <p class="text-danger">Note : Select Checkbox to forward the applications</p>
                </div>
            </div>
            <div class="reza-body">
                <table id="datatable" class="datatable table table-stripped">
                    <thead>
                    <tr>
                        <!-- <th>Case No</th> -->
                        <th>All <input  type="checkbox" class="checkBoxD " value="all" id="checkedAll" > </th>
                        <!-- <th></th> -->
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
                        </th> -->
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="text-center btn_show_hide" style="display: none;">
                    <!-- <button class="btn btn-primary" type="button" onclick="openModalForFlagReject();"><i class="fa fa-check-square-o"></i> Click here for Reject</button> -->
                    <button class="btn btn-success" type="button" onclick="openModalForFlag();"> Forward to DLR <i class="fa fa-check-square-o"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal bs-example-modal-md" id='myLargeModalLabelApproved' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelApproved">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            <div class="row text-right">
                <span class="edit-enc-close px-4">&times;</span>
            </div>
            <div class="modal-body">
                <form id="ajaxMappingFormForward">
                <h4 style="border-bottom: 5px solid #ff681d;">Below listed applications will be forwarded to Directorate of Land Records(DLRs)</h4>
                <div class="row">
                    <div class="col-lg-4">
                       <b style="font-size:18px"><i class="fa fa-info-circle text-red"></i> Selected Applications</b>
                    </div>
                    <div class="col-lg-8">
                       <b style="font-size:18px"> <textarea class="form-control" readonly="" id="applications_view" style="height: 180px;"></textarea></b>
                       <input type="hidden" name="application_list" id="application_list">
                      
                    </div>
                </div>
                <div class="container mt-2" style="margin-bottom:25px">
                    <div class="col-md-6 text-center">
                        <label for="" class="text-danger"><i class="fa fa-hand-o-right text-green"></i> DC Remarks</label>
                   </div>
                   <div class="col-md-6">   
                        <textarea class="form-control" placeholder="Remarks" name="dc_remarks" id="dc_remarks" required></textarea>
                   </div>
               </div>
               
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal  bs-example-modal-md" id='myLargeModalLabelReject' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelReject">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            <div class="row text-right">
                <span class="edit-enc-close-reject px-4">&times;</span>
            </div>
            <div class="modal-body">
                <form id="ajaxMappingFormRevert">
                <h4 style="border-bottom: 5px solid #ff681d;">Below listed applications will be rejected</h4>
                <div class="row">
                    <div class="col-lg-4">
                       <b style="font-size:18px"><i class="fa fa-info-circle text-red"></i> Selected Applications</b>
                    </div>
                    <div class="col-lg-8">
                       <b style="font-size:18px"> <textarea class="form-control" readonly="" id="applications_view" style="height: 180px;"></textarea></b>
                       <input type="hidden" name="application_list" id="application_list">
                      
                    </div>
                </div>
                <div class="container mt-2" style="margin-bottom:25px">
                    <div class="col-md-6 text-center">
                        <label for="" class="text-danger"><i class="fa fa-hand-o-right text-green"></i> DC Remarks for Rejection</label>
                   </div>
                   <div class="col-md-6">   
                        <textarea class="form-control" placeholder="Remarks" name="dc_remarks" id="dc_remarks" required></textarea>
                   </div>
               </div>
               
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-save"></i> Reject</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    var selectedCheckBoxArray = [];
    function showSuccessMessage(text) 
    {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) 
    {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }

    function openModalForFlag()
    {
        if(selectedCheckBoxArray.length == 0)
        {
            showErrorMessage("Please select one application for proceed...");
            return false;
        }
        var btn = document.getElementById("myBtn");
        var span_close = document.getElementsByClassName("edit-enc-close")[0];
        $('#myLargeModalLabelApproved').modal('show');
        $('.modal-backdrop').remove();

        $("#applications_view").html(selectedCheckBoxArray.toString());
        $("#application_list").val(selectedCheckBoxArray);
        span_close.onclick = function() {
           $('#myLargeModalLabelApproved').modal('hide');
        }
    }

    function openModalForFlagReject()
    {
        $('.modal-backdrop').hide();
        if(selectedCheckBoxArray.length == 0)
        {
            showErrorMessage("Please select one application for proceed...");
            return false;
        }
        var btn = document.getElementById("myBtn");
        var span_close = document.getElementsByClassName("edit-enc-close-reject")[0];
        $('#myLargeModalLabelReject').modal('show');
        $('.modal-backdrop').remove();
        $("#applications_view").html(selectedCheckBoxArray.toString());
        $("#application_list").val(selectedCheckBoxArray);
        span_close.onclick = function() {
           $('#myLargeModalLabelReject').modal('hide');
        }
    }
</script>

<script type="text/javascript">

    $(document).on('change', '#mouza_cat, #lot_cat', function()
    {
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
    });

    $(document).ready(function ()
    {
        $(document).on('change', '#category, #mouza_cat, #lot_cat', function()
        {
            var category   = $('#category').val();
            var remark_cat = $('#remark_cat').val();
            var mouza_cat  = $('#mouza_cat').val();
            var lot_cat    = $('#lot_cat').val();
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
            load_data(category, remark_cat, mouza_cat, lot_cat);

        });


        load_data();

        
        function load_data(is_category = null, mouza_cat=null, lot_cat=null)
        {
            
            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";
            var pending_office = "DC";
            var s = "D";

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            // $('#datatable thead th:nth-of-type(2)').each(function () {
            //     var title = $(this).text();
            //     $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            // });

            var table = $('#datatable').DataTable({
                'pageLength':10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax':{
                    url: base_url+'index.php/BasundharaReview/getPendingList',
                    type:'POST',
                    data: {
                        service:service_code,
                        status:s,
                        is_category:is_category,
                        pending_office:pending_office,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat
                    },
                    deferLoading: 57,
                },

                order: [[2, 'asc']],

                columnDefs: [{
                  targets: 0,

                  data: "is_visible",
                  'render': function (data, type, row) {
                    return '<input type="checkbox" class="checkBoxD selectMark" value='+row[0]+' id='+row[0]+' name="selectMark[]">';
                  }
                }],
            });

            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });

            $('.btn_show_hide').show(300);

            $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
                var checkBoxId = $(this).val();
                var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray); 
                if(this.checked && rowIndex === -1) {
                    selectedCheckBoxArray.push(checkBoxId);
                }
                else if (!this.checked && rowIndex !== -1) {
                    selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
                }
                // console.log(selectedCheckBoxArray);
                $("#application_list").val(application_list);
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
                $("#application_list").val(application_list);
            });


            $("#datatable").on('draw.dt', function() {
              for (var i = 0; i < selectedCheckBoxArray.length; i++) {
                checkboxId = selectedCheckBoxArray[i];
                const myArray = checkboxId.split("/");
                var arr = myArray[3];
                // var arr = checkboxId;
                $('#' + arr).attr('checked', true);
              }
            });

            // $('.search_button').on('click', function () {            
            //     $('table thead tr th .input_search').each(function(){ 
            //         table.column($(this).data('columnIndex')).search(this.value);
            //     });
            //     table.draw();
            // });
        }
    });

    $('#ajaxMappingFormForward').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to forward?"))
        {
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
            url: baseurl + "BasundharaReview/forwardCasesToDLR",
            type: 'POST',
            data: $("#ajaxMappingFormForward").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
                if(data.responseType == 2){
                    showSuccessMessage(data.msg);
                    location.reload();
                }else{
                    showErrorMessage(data.msg); 
                }
            },error: function (error) {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });

     $('#ajaxMappingFormRevert').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to reject?"))
        {
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
            url: baseurl + "BasundharaReview/RejectCasesbyDC",
            type: 'POST',
            data: $("#ajaxMappingFormRevert").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
                if(data.responseType == 2){
                    showSuccessMessage(data.msg);
                    location.reload();
                }else{
                    showErrorMessage(data.msg); 
                }
            },error: function (error) {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });

</script>


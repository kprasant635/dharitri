<style>
    #button{
        display:block;
        margin:20px auto;
        padding:10px 30px;
        background-color:#eee;
        border:solid #ccc 1px;
        cursor: pointer;
    }
    #overlay{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
    .is-hide{
        display:none;
    }
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 677px !important;
            margin: 1.75rem auto;
        }
    }

</style>
<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            All Cases for Modification Request
        </h4>
    </div>
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if($this->session->userdata('message')) { ?>
        <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <b><?php echo $this->session->userdata('message') ?></b>
            <br>
            <b><?php $this->session->set_userdata('message','') ?></b>
        </div>
    <?php } ?>
</div>

<div class="row px-2">
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
            <th>Pending <br>With</th>
            <th style="width: 230px!important;">Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<div class="modal" role="dialog" id="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Modification Request
                </h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5 style="color: #F44336">You want to request for modification <br>
                    Case :
                    <span id="case_no_view" style="font-weight: bold">  </span>
                    <br>
                    to SDO/ADC
                </h5>
                <hr>

                <form id="ajaxMappingForm">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" style="margin-top: 15px" align="left">
                        <label for="w3review" style="font-weight: bold">Enter Your Remarks <span style="color: red; font-weight: bold; font-size: 18px">*</span></label>
                        <textarea class="form-control" name="co_remarks" id="co_remarks" rows="4" required minlength="1"> </textarea>
                    </div>
                    <input type="hidden" name="case_no" id="case_no">
                    <input type="hidden" name="applid" id="applid">

                    <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 15px">
                        <div style="font-size: 14px; font-weight: bold; margin-top: 10px; margin-bottom: 10px">
                            Note: If you request for modification of this application to ADC/SDO and accepted,
                            this case would no longer be part of any Proposal and ADC/SDO have to
                            generate new proposal for this application.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  id="modalNo">Close</button>
                        <button type="submit" name="submit" class="btn btn-success"  id="modalYes">Yes, Request For Modification</button>
                    </div>

                </form>


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
            showConfirmButton: false,
            timer: 10000,
            showCancelButton: true
        });
    }


    function openModalForFlag(case_no,applid){

        var btn = document.getElementById("myBtn");

        var span_close = document.getElementsByClassName("edit-enc-close")[0];

        $('#myLargeModalLabel').modal('show');

        $('#case_no_view').html(case_no);
        $('#applid_view').html(applid);
        $('#case_no').val(case_no);
        $('#applid').val(applid);


        span_close.onclick = function() {
            $('#myLargeModalLabel').modal('hide');
            // table.destroy();
        }
    }

    function openModalForForwardToDC(case_no1,applid1){

        var btn = document.getElementById("myBtn");

        var span_close = document.getElementsByClassName("edit-enc-close-adc")[0];

        $('#myLargeModalLabelADC').modal('show');

        $('#adc_case_no_view').html(case_no1);
        $('#applid_view').html(applid);
        $('#adc_case_no').val(case_no1);
        $('#adc_applid').val(applid1);


        span_close.onclick = function() {
            $('#myLargeModalLabelADC').modal('hide');
            // table.destroy();
        }
    }


    $(document).on('change', '#mouza_cat, #lot_cat', function(){
        var mouzaCode = $('#mouza_cat').val();
        var lot_no = $('#lot_cat').val();

        var postData = {
            'mouza_pargona_code' : mouzaCode,
            'lot_no' : lot_no
        };

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
        $(document).on('change', '#category, #mouza_cat, #lot_cat', function(){
            var category = $('#category').val();


            var mouza_cat = $('#mouza_cat').val();
            var lot_cat = $('#lot_cat').val();

            $('#datatable').DataTable().destroy();
            if(category != '')
            {
                category = category;
            }
            else
            {
                category = '';
            }
            var remark_cat = '';


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

        function load_data(is_category = null, remark_cat = null, mouza_cat=null, lot_cat=null)
        {

            var base_url = "<?php echo base_url();?>";
            var service_code = "<?=$_GET['service']?>";

            $('#datatable thead th:nth-of-type(1)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
            });

            $('#datatable thead th:nth-of-type(2)').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');
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
                    url: base_url+'index.php/SettlementModification/paginationForPullRequest',
                    type:'POST',
                    data: {
                        service:service_code,
                        is_category:is_category,
                        remark_cat:remark_cat,
                        mouza_pargona_code : mouza_cat,
                        lot_no : lot_cat
                    },
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    // "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6, 7],
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

<script type="text/javascript">


    $('#ajaxMappingForm').submit(function (e) {

        e.preventDefault();
        if(!confirm("Are you sure you want to request for pull?"))
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
            url: baseurl + "SettlementModification/checkWhetherPullRequestByCO",
            type: 'POST',
            data: $("#ajaxMappingForm").serialize(),
            dataType: 'json',
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if(data.responseType == 2)
                {
                    Swal.fire({
                        text: data.message,
                        // confirmButtonText: 'OK',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Thank You',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                    location.reload();
                }})
                }
                else
                {
                    showErrorMessage('Something went wrong.');
                }
            },error: function (error)
            {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            }
        });
    });


    $('#modalNo').click(function()
    {
        $('#myLargeModalLabel').modal('hide');
    });


</script>
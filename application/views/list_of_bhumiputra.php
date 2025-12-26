<center>

    <mark>
        Application having Bhumiputra Certificate(s)
    </mark>

    <br>

</center>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <a href="<?=base_url().'index.php/load-fetched-bhumiputra-data'; ?>" target="_bhumi_data">
        <button class="btn btn-xs btn-primary pull-left"><i class="fa fa-eye"></i> Check Bhumiputra Status</button>
    </a>
</div><hr>

<div class="row px-5">
    <table id="datatable" class="datatable table table-stripped">
        <thead>
        <tr>
            <th>Case/Application No</th>
            <th>Certificate/Ack No</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal" role="dialog" id="statusModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="approvalForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Bhumiputra Status</h5>
                </div>
                <div class="modal-body" align="center">
                    <div id="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                                    <label>Bhumiputra Status</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                                    <span id="bhumi_api_status"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                                    <label>Applicant Name</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                                    <span id="bhumi_api_appl"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                                    <label>Caste Category</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right">
                                    <span id="bhumi_api_caste"></span>
                                </div>
                            </div>

                        </div>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  id="statusModalOk">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>

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

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showConfirmButton: true,
        });
    }


    $(document).ready(function ()
    {
        load_data();

        function load_data()
        {
            var base_url = "<?php echo base_url();?>";

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
                    url: base_url+'index.php/get-bhumiputra-pagination',
                    type:'POST',
                    deferLoading: 57,
                },


                order: [[2, 'asc']],
                // columnDefs: [{
                //     targets: "_all",
                //     orderable: false,
                //     "className": "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6, 7],
                //     }]

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


    $(document).on('click','#statusModalOk',function ()
    {
        $('#statusModal').hide();
    });

    function getBhumiApi(case_no)
    {
        $('#statusModal').show();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        var postData = {
            'case_no' : case_no,
        };

        $.ajax({

            url: baseurl+'get-bhumiputra-status-api',
            type: "POST",
            data: postData,
            success: function(data) {
                arr = JSON.parse(data);
                $.unblockUI();

                console.log(arr.responseType);

                if(arr.responseType == 3) { // error message
                    showErrorMessage(arr.message);
                }
                else if(arr.responseType == 1) // success
                {
                    showSuccessMessage(arr.message);
                    $('#bhumi_api_status').html(arr.bhumi_status);
                    $('#bhumi_api_appl').html(arr.bhumi_applicant);
                    $('#bhumi_api_caste').html(arr.bhumi_caste);
                }
                else {
                    showErrorMessage("Something went wrong on fetching Bhumiputra data. Kindly contact system administrator !!!");
                }
            },
            error: function(err) {
                $.unblockUI();
                showErrorMessage("Something went wrong on fetching Bhumiputra data. Kindly contact system administrator !!!");
            }
        });


    }

</script>
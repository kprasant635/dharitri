<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>



<div class="panel-heading">
    <div class="panel-title">
        <h4 class="text-center">Zonal Details Report by CO</h4>
    </div>
</div>

<!-- Pending Zonal Info ADC  -->

<div class="col-lg-12">
    <div class="panel panel-success panel-form">
        <div class="panel-heading">
            <span class="panel-title">Pending Zonal Details Report by CO</span>
        </div>
        <div class="panel-body">
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableZonalUploadReportADC' width="100%">
                <thead>
                    <th scope="col" style="width: 20%;" class="center"><label class="control-label">Circle </label>
                    <th scope="col" style="width: 20%;" class="center"><label class="control-label">CO Name </label>
                    <th scope="col" class="center"><label class="control-label">Zonal Report</label></th>
                    <th scope="col" class="center"><label class="control-label">Uploaded on</label></th>
                    <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label>
                        <button type="button" class="search_button btn btn-sm btn-danger form-control">
                            <i class="fa fa-refresh"></i>
                            Reset
                        </button>
                    </th>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        load_datatable_co_upload_report_adc();

        function load_datatable_co_upload_report_adc() {

            var base_url = "<?php echo base_url(); ?>";
            var dist_code_pending = "<?= $dist_code ?>";
            var table = $('#datatableZonalUploadReportADC').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 20, 50, 100],
                    [5, 10, 20, 50, 100]
                ],
                'language': {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax': {
                    url: base_url + 'index.php/ZoneInformationController/viewUploadedReportDetailsADC',
                    type: 'POST',
                    data: {
                        dist_code_pending: dist_code_pending,
                    },
                    deferLoading: 57,
                },
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center",
                    "targets": [0, 1, 2, 3, 4],
                }]
            });
            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
            // button search
            $('.search_button').on('click', function() {
                $('table thead tr th .input_search').each(function() {
                    $(this).val('');
                    // table.column($(this).data('columnIndex')).search('');
                });
                $('#datatableZonalUploadReportADC').DataTable().destroy();
                load_datatable_co_upload_report_adc();
            });
        }
        // Load Pending Zonal Details ADC end

    });
</script>




<script>
    // Success Message
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });
        location.reload();
    }

    // Error Message
    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    // Warning Message
    function showWarningMessage(text) {
        swal.fire({
            // title: "Error!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }
    //Bulk Approved by  CO
</script>



<script>
    function viewUploadedReportAdc(dist_code, subdiv_code, cir_code) {

        const applicant = {
            dist_code: dist_code,
            subdiv_code: subdiv_code,
            cir_code: cir_code,
        };
        console.log(applicant);
        // return;
        $.ajax({
            url: '<?php echo base_url() . "index.php/ZonalByforcationController/viewUploadedReportByCOADC" ?>',
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function(data) {
                if (data.responseType == 1) {
                    showErrorMessage("There is some problem, Please try again");
                } else if (data.responseType == 2) {

                    $('#coUploadReportModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#coUploadReportModal').modal('show');

                    var reportDiv = data.uploadReport;

                    $('#reportView').html(reportDiv);
                } else if (data.responseType == 3) {
                    $('#searchProIdModal').modal('hide');
                    showErrorMessage("Data not found !");
                } else {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)
        });
    }



    // Approve Uploaded Report by ADC
    function approveUploadedReporADC(dist_code, subdiv_code, cir_code, co_user_code, circle_name) {

        var dist_code_report = dist_code;
        var subdiv_code_report = subdiv_code;
        var cir_code_report = cir_code;
        var co_user_code_report = co_user_code;
        var circle_name_report = circle_name;

        const upload_report_data = {
            dist_code_report: dist_code_report,
            subdiv_code_report: subdiv_code_report,
            cir_code_report: cir_code_report,
            co_user_code_report: co_user_code_report,
        };

        // console.log(upload_report_data)

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal Report Uploaded  by CO for " + circle_name_report + " Circle Will be Verified by ADC",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/approveZonalUploadReportADC" ?>',
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            showSuccessMessage(data.message);
                            // location.reload();
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    data: JSON.stringify(upload_report_data)
                });
            }
        })
    }


    // Revert Uploaded Report by ADC to CO
    function revertUploadedReporADC(dist_code, subdiv_code, cir_code, co_user_code, circle_name) {

        var dist_code_report = dist_code;
        var subdiv_code_report = subdiv_code;
        var cir_code_report = cir_code;
        var co_user_code_report = co_user_code;
        var circle_name_report = circle_name;

        const upload_report_data = {
            dist_code_report: dist_code_report,
            subdiv_code_report: subdiv_code_report,
            cir_code_report: cir_code_report,
            co_user_code_report: co_user_code_report,
        };

        // console.log(upload_report_data)

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal Report Uploaded  by CO for " + circle_name_report + " Circle Will be Reverted",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Revert!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/revertZonalUploadReportADC" ?>',
                    type: "POST",
                    dataType: "json",
                    contentType: "application/json",
                    success: function(data) {
                        if (data.responseType == 1) {
                            showErrorMessage(data.message);
                        } else if (data.responseType == 2) {
                            showSuccessMessage(data.message);
                            // location.reload();
                        } else if (data.responseType == 3) {
                            showWarningMessage(data.message);
                        } else {
                            showErrorMessage("SOMETHING WENT WRONG");
                        }
                    },
                    data: JSON.stringify(upload_report_data)
                });
            }
        })
    }
</script>
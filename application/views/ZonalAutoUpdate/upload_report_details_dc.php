<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>



<div class="panel-heading">
    <div class="panel-title">
        <h4 class="text-center">Zonal Details Report by ADC (Circle Wise)</h4>
    </div>
</div>

<!-- Pending Zonal Info ADC  -->

<div class="col-lg-12">
    <div class="panel panel-primary panel-form">
        <div class="panel-heading">
            <span class="panel-title">Circle WisePending Zonal Details Report by ADC</span>
        </div>
        <div class="panel-body">
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableZonalUploadReportADC' width="100%">
                <thead>
                    <th scope="col" style="width: 20%;" class="center"><label class="control-label">Report For </label>
                    <th scope="col" style="width: 20%;" class="center"><label class="control-label">Report By ADC </label>
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
                    url: base_url + 'index.php/ZoneInformationController/viewUploadedReportDetailsDC',
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
    function approveUploadedReporDC(dist_code, uploaded_subdiv_adc, uploaded_circle_adc, adc_user_code) {

        var dist_code_report = dist_code;
        var subdiv_code_report = uploaded_subdiv_adc;
        var circle_code_report = uploaded_circle_adc;
        var adc_user_code_report = adc_user_code;

        const upload_report_data = {
            dist_code_report: dist_code_report,
            subdiv_code_report: subdiv_code_report,
            circle_code_report: circle_code_report,
            adc_user_code_report: adc_user_code_report,
        };

        // console.log(upload_report_data)

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal Report Uploaded  by ADC Will be Verified by DC",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/approveZonalUploadReportDC" ?>',
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


    // Revert Uploaded Report by DC to ADC
    function revertUploadedReporDC(dist_code, uploaded_subdiv_adc, uploaded_circle_adc, adc_user_code) {

        var dist_code_report = dist_code;
        var subdiv_code_report1 = uploaded_subdiv_adc;
        var circle_code_report1 = uploaded_circle_adc;
        var adc_user_code_report = adc_user_code;

        const upload_report_data = {
            dist_code_report: dist_code_report,
            subdiv_code_report: subdiv_code_report1,
            circle_code_report: circle_code_report1,
            adc_user_code_report: adc_user_code_report,
        };

        Swal.fire({
            title: 'Are you sure?',
            text: "Zonal Report Uploaded  by ADC  Will be Reverted",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Revert!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() . "index.php/ZoneInformationController/revertZonalUploadReportDC" ?>',
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
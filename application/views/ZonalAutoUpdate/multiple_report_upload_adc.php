<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>



<div class="panel-heading">
    <div class="panel-title">
        <h4 class="text-center">Generate & Upload Zonal Certificate Report by ADC (Circlewise)</h4>
    </div>
</div>

<div class="col-lg-8 col-lg-offset-1 mb-2 text-center" id="msg">
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>


<div class="col-lg-12">
    <div class="panel panel-success panel-form">
        <div class="panel-heading">
            <span class="panel-title">Zonal Details Report Submitted by CO</span>
        </div>
        <div class="panel-body">
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatableZonalUploadReportADC' width="100%">
                <thead>
                    <th scope="col" style="width: 20%;" class="center"><label class="control-label">Circle </label>
                    <th scope="col" class="center"><label class="control-label">Zonal Report</label></th>
                    <th scope="col" class="center"><label class="control-label">Uploaded by CO on</label></th>
                    <th scope="col" class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label>
                        <button type="button" class="search_button btn btn-sm btn-danger form-control">
                            <i class="fa fa-refresh"></i>
                            Reset
                        </button>
                    </th>
                </thead>
                <tbody>
                    <?php
                    foreach ($results as  $rows) {
                    ?>
                        <tr>
                            <td><?php echo $circle_name = $this->utilityclass->getCircleName($rows->dist_code, $rows->subdiv_code, $rows->cir_code) ?></td>
                            <td><a class="btn btn-success btn-sm" target="download" href="<?php echo base_url(); ?>index.php/ZonalByforcationController/circleWiseGenerateReportADC/?cir_code=<?php echo $rows->cir_code; ?>&subdiv_code=<?php echo $rows->subdiv_code; ?>"><i class="fa fa-download"></i> Generate ADC Report for Circle</a></td>
                            <td><?php echo date('d-M-Y', strtotime($rows->date_upload)); ?></td>

                            <td>
                                <?php $uploaded_status = $this->zonalinformationmodel->uploadedZonalReportDetailsByADC($rows->subdiv_code, $rows->cir_code) ?>
                                <?php $uploaded_status_result =  $uploaded_status->result() ?>
                                <?php if ($uploaded_status->num_rows() == 0) : ?>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="file_<?= $rows->subdiv_code ?>_<?= $rows->cir_code ?>">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <div>
                                        <button type="submit" id="upload" onclick="uploadMultipleReportADC('<?= $rows->subdiv_code ?>','<?= $rows->cir_code ?>')" class="btn btn-primary btn-sm">Upload <i class="fa fa-upload"></i></button>
                                    </div>

                                <?php elseif ($uploaded_status_result[0]->is_active == 'E') : ?>
                                    <span class="bg-yellow"><i class="fa fa-paper-plane" aria-hidden="true"></i> Sent for DC Approval</span>
                                <?php elseif ($uploaded_status_result[0]->is_active == 'A') : ?>
                                    <span class="bg-success"><i class="fa fa-check"></i> Approved by DC</span>
                                <?php elseif ($uploaded_status_result[0]->is_active == 'R') : ?>
                                    <small class="bg-danger"><i class="fa fa-undo"></i> Reverted by DC</small>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="file_reupload_<?= $rows->subdiv_code ?>_<?= $rows->cir_code ?>">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <div>
                                        <button type="submit" id="reupload" onclick="reUploadMultipleReportADC('<?= $rows->subdiv_code ?>','<?= $rows->cir_code ?>')" class="btn btn-primary btn-sm">Reupload <i class="fa fa-upload"></i></button>
                                    </div>
                                <?php endif;
                                ?>
                            </td>
                        </tr>
                    <?php }  ?>

                </tbody>
            </table>

        </div>
    </div>
</div>



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





<script type="text/javascript">
    $(document).ready(function() {
        $('#datatableZonalUploadReportADC').DataTable();

        // New Script for Button navigation
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        // alert(activeTab);
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });



    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    function uploadMultipleReportADC(subdiv_code, cir_code) {
        var base_url = "<?php echo base_url(); ?>";
        var subdiv_code_upload = subdiv_code;
        var cir_code_upload = cir_code;
        var file_data = $('#file_' + subdiv_code_upload + '_' + cir_code_upload).prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('subdiv_code_upload', subdiv_code_upload);
        form_data.append('cir_code_upload', cir_code_upload);
        $.ajax({
            url: base_url + 'index.php/ZonalByforcationController/uploadMultipleReportADC',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
                $('#msg').html(response);
                setTimeout(function() {
                    history.go(0);
                }, 4000);
            },
            error: function(response) {
                $('#msg').html(response);
            }
        });
    };



    //Reupload Zonal Report after reverted from DC
    function reUploadMultipleReportADC(subdiv_code, cir_code) {
        var base_url = "<?php echo base_url(); ?>";
        var subdiv_code_reupload = subdiv_code;
        var cir_code_reupload = cir_code;
        var file_data_reupload = $('#file_reupload_' + subdiv_code_reupload + '_' + cir_code_reupload).prop('files')[0];
        var form_data_reupload = new FormData();
        form_data_reupload.append('file', file_data_reupload);
        form_data_reupload.append('subdiv_code_reupload', subdiv_code_reupload);
        form_data_reupload.append('cir_code_reupload', cir_code_reupload);
        $.ajax({
            url: base_url + 'index.php/ZonalByforcationController/reUploadMultipleReportADC',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data_reupload,
            type: 'post',
            success: function(response) {
                $('#msg').html(response);
                setTimeout(function() {
                    history.go(0);
                }, 4000);
            },
            error: function(response) {
                $('#msg').html(response);
            }
        });
    };
</script>
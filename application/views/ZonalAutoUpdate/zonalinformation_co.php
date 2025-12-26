<style>
    .blink_text {
        animation: 3s blinker linear infinite;
        -webkit-animation: 3s blinker linear infinite;
        -moz-animation: 3s blinker linear infinite;
        /* color: red; */
    }
</style>
<div class="row">
    <div class="col-lg-8 col-lg-offset-1 mb-2 text-center" id="msg">
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('message'); ?></div>
        <?php endif; ?>
    </div>
    <div class="col-lg-9 col-lg-offset-1">
        <div class="panel casedisplay">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4 class="text-center">Zonal Value Information/Updation</h4>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Pending Zonal Value Information </td>
                        <td>
                            <?php if ($pendingcount != '0') {
                                echo "<span class=\"badge badge-danger\">$pendingcount</span>";
                            } ?>
                        </td>
                        <?php
                        $link = base_url() . "index.php/ZoneInformationController/getPendingZonalInformation";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                    </tr>
                    <tr>
                        <td>Villagewise Dags Report </td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZonalByforcationController/zonalDagVillageWise";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                    </tr>

                    <!-- Dags not having Zonal Details -->
                    <tr>
                        <td><b class="bg-yellow">Zonal Details Missing Report </b> <sup class="red">New</sup></td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZonalByforcationController/zonalDetailsVillageWiseReport";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>">Download</a></td>
                    </tr>

                    <!-- Pending Dagwise Zonal Entry -->
                    <tr>
                        <td><b class="bg-yellow">Pending Dagwise Entry Report <i class="fa fa-download"></i></b> <sup class="red">New</sup></td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZonalByforcationController/dagwiseEntryMissingReportCO";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>">Download</a></td>
                    </tr>
                    <!-- Missing Zonal Report for Basundhara Dags -->

                    <tr>
                        <td><b class="bg-yellow">Missing Zonal Entry for Basundhara Dags Report <i class="fa fa-download"></i></b> <sup class="red">New</sup></td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZonalByforcationController/zonalApplicationMissingDags";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>">Download</a></td>
                    </tr>

                    <tr>
                        <td><b class="bg-yellow">Zonal Value Certificate Report Download<i class="fa fa-download"></i></b> <sup class="red">New</sup></td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZonalByforcationController/zonalValueCertificateReportCO";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>">Download</a></td>
                    </tr>

                    <tr>
                        <td>View Uploaded Report by LM </td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZoneInformationController/viewUploadedReportCO";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                    </tr>

                    <tr class="bg-success">
                        <?php if ($document_count == 0) : ?>
                            <td>
                                <h6>Upload Verified Report <i class="fa fa-upload"></i> <sup class="red">New</sup></h6>
                            </td>
                        <?php else : ?>
                            <td>
                                <?php if (($document->is_active == 'R')) : ?>
                                    <small class="text-danger">Zonal Details Report Reverted by ADC</small>
                                    <h6>Reupload Verified Report <i class="fa fa-upload"></i> <sup class="red">New</sup></h6>
                                <?php elseif (($document->is_active == 'E')) : ?>
                                    <h6>Zonal Details Report Sent for ADC verification </h6>
                                <?php elseif (($document->is_active == 'A')) : ?>
                                    <h6>Zonal Details Report Verified by ADC </h6>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <?php if (($document_count == 0) || ($document->is_active == 'R')) : ?>
                            <td>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="file">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </td>
                            <td>
                                <button type="submit" id="upload" class="btn btn-primary">Upload <i class="fa fa-upload"></i></button>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php if ($document_count >= 1) : ?>
                        <tr>
                            <td>
                                <p>View Uploaded Report</p>
                            </td>
                            <td>
                                <a class="text-primary" target='download' href="<?php echo base_url(); ?>index.php/ZonalByforcationController/viewUploadedReport"><i class="fa fa-file-pdf-o" style="font-size:18px"></i> <?php echo substr($document->report_name, 0, 30) ?></a>
                            </td>
                            <td>
                                <a class="btn btn-secondary btn-sm" target='download' href="<?php echo base_url(); ?>index.php/ZonalByforcationController/viewUploadedReport"><i class="fa fa-eye"></i> view Report</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>


<script type="text/javascript">
    $(document).ready(function(e) {
        $('#upload').on('click', function() {
            var base_url = "<?php echo base_url(); ?>";
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: base_url + 'index.php/ZonalByforcationController/uploadReportCo',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response) {
                    $('#msg').html(response);
                    // location.reload();
                    setTimeout(function() {
                        history.go(0);
                    }, 4000);
                },
                error: function(response) {
                    $('#msg').html(response);
                }
            });
        });
    });
</script>
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
                        <td>Pending Zonal Value Details Sent by CO </td>
                        <td>
                            <?php if ($adcPendingCount != '0') {
                                echo "<span class=\"badge badge-danger\">$adcPendingCount</span>";
                            } ?>
                        </td>
                        <?php
                        $link = base_url() . "index.php/ZoneInformationController/GetZonalDetailsAdc";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                    </tr>


                    <!-- Dags not having Zonal Details -->
                    <tr>
                        <td><b class="bg-yellow">Zonal Details Missing Report Download</b> <sup class="red">New</sup></td>
                        <td>
                        </td>
                        <?php
                        $link = base_url() . "index.php/ZonalByforcationController/zonalDetailsMissingReportDCADC";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>">Download</a></td>
                    </tr>


                    <tr>
                        <td>View Uploaded Report by CO </td>
                        <td>
                        </td>
                        <?php
                        $link = base_url() . "index.php/ZoneInformationController/viewUploadedReportADC";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>"><?php echo $this->lang->line('view') ?></a></td>
                    </tr>

                    <tr>
                        <td><b class="bg-yellow">Zonal Certification Report (Circlewise) Download /Upload<i class="fa fa-download"></i></b> <sup class="red">New</sup></td>
                        <td>

                        </td>
                        <?php
                        $link = base_url() . "index.php/ZoneInformationController/multipleReportUploadADC";
                        ?>
                        <td><a class="pull-right green" href="<?php echo $link; ?>">Go</a></td>
                    </tr>
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
                url: base_url + 'index.php/ZonalByforcationController/uploadReportADC',
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
        });
    });
</script>
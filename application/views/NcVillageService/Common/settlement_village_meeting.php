<!-- Masud's CSS-->
<style>
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
    .rezaPrim {
        background-color: #9C27B0;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
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
        color: #FFF;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
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



        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('villageMeeting') ?></span>
                <hr>

            </div>

            <div class="reza-body">

                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                    <thead>
                    <tr>
                        <th>SL No.</th>
                        <th><label class="control-label">Village Name</label></th>
                        <th><label class="control-label">Village UUID</label></th>
                        <th class="center"><label class="control-label">Action</label></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; foreach ($villageList as $village):  $i++ ?>
                        <tr>
                            <td><?php echo $i ?> </td>
                            <td>
                                <?php echo $village->village_name ?>
                            </td>
                            <td>
                                <?php echo $village->uuid  ?>
                            </td>
                            <td class="center">
                                <a  target="_blank" class="rezaButt rezaInfo" href="<?php echo base_url(); ?>index.php/SettlementCommon/genMPDFCaseListForVillageMeetingApi?village=<?= trim($village->village_name) ?>&code=<?= base64_encode($village->uuid) ?>">
                                    <i class="fa fa-print"></i> Print Report
                                </a>
                                <a class="rezaButt rezaPrim" href="<?php echo base_url(); ?>index.php/SettlementCommon/uploadReportCaseListForVillageMeetingApi?village=<?= trim($village->village_name) ?>&code=<?= base64_encode($village->uuid) ?>">
                                    <i class="fa fa-upload"></i> Upload Report
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>


            </div>

        </div>





    </div>
</div>
<!--Masud Script-->

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>


    var BASE_URL = $("#getBaseURL").val();
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
            timer: 5000,
            showCancelButton: true
        });
    }


    });
</script>



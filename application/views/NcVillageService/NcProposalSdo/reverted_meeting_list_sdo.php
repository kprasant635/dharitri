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
                Reverted Meeting List By DC
                <hr>
            </div>
            <div class="reza-body">

                <table class="datatable table table-stripped" id='datatable' width="100%">
                    <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Meeting ID</th>
                        <th>Meeting Date</th>
                        <th class="center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach($cases as $row) { ?>
                        <tr>
                            <td><?=$i?></td>
                            <td style="font-weight: bold"><?=$row->meeting_name?></td>
                            <td><?=$row->meeting_date?></td>
                            <td align="center">
                                <?php if($row->vgr_pgr_revert_status == 1): ?>
                                    <b style="color: #FF5252;">Some cases are Reverted back from this Meeting</b>
                                <?php else: ?>
                                    <a class="rezaButt rezaInfo" href="<?php echo base_url(); ?>index.php/NcCommonProposalSdo/getProposalUnderRevertedMeetingForSdo/?meetingId=<?php echo $row->id; ?>">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>



<!--// NEW JS BY MASUD REZA-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

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

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    $('#datatable').DataTable();

    load_data();

    $('.search_button').click(function(){
        load_data();
    });


</script>

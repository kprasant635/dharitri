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
    .rezaButt {
        color: #FFF;
    }
    .rezaInfo {
        color: #FFF;
        background-color: #FFC107;
    }

    .rezaPrim {
        color: #FFF;
        background-color: #9C27B0;
    }
    .rezaDag {
        color: #FFF;
        background-color: #4CAF50;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        /*min-width: 150px;*/
        line-height: 37px;
        padding: 0 .8rem;
        /*font-size: 15px;*/
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        /*letter-spacing: 0.8px;*/
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
        margin-bottom: 5px;
        margin-left: 3px;
    }
    .rezaText {
        font-size: 16px;
    }

    .checkBoxD{

        width: 20px;
        height: 20px;
    }
    .reza-m{
        margin: 5px;
    }
</style>



<div class="row" style='padding: 40px 50px 40px 20px'>

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



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="reza-card">
            <div class="reza-title">All Reverted Cases By Department </div>

            <div class="reza-body">
                <br>
                <?php if($meetingCount == 0): ?>
                    <h5><br>No Meeting Found !<br></h5>
                <?php else: ?>
                    <table class="datatable table table-stripped table-bordered" id='datatable_reverted'>
                        <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="10%">Meeting ID</th>
                            <th width="20%">Meeting Venue <br> Date</th>
                            <th width="8%"> Reverted By</th>
                            <th width="70%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0;
                        foreach ($meetings as $meeting):  $i++  ?>

                            <tr>
                                <td><?php echo $i ?> </td>
                                <td style="font-weight: bold"><?php echo $meeting->meeting_name ?> </td>
                                <td>
                                    <?php echo $meeting->meeting_venue ?>
                                    <br>
                                    <?php echo date('d-m-Y', strtotime($meeting->meeting_date)) ?>
                                </td>
                                <td><?php echo 'DEPT'; ?> </td>
                                <td>
                                    <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/getDigitalMinutesWithMeetingId/?meetingId=<?php echo $meeting->meeting_id; ?>"
                                       class="rezaButt btn btn-sm " style="color: #FFF; background-color: #9C27B0;" target="DigitalMinutes">
                                        <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Digital Minutes
                                    </a>
                                    <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/getRevertedProposalsAgainstMeetingId/?meetingId=<?php echo $meeting->meeting_id; ?>"
                                       class="rezaButt btn btn-sm " style="background-color :#4CAF50" >
                                        <i class="fa fa-eye" aria-hidden="true"></i> &nbsp;Meeting Details
                                    </a>
                                    <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/getRevertedCasesDeptAgainstMeetingId/?meetingId=<?php echo $meeting->meeting_id; ?>"
                                       class="rezaButt btn btn-sm " style="background-color :#af4b24" >
                                        <i class="fa fa-eye" aria-hidden="true"></i> &nbsp;View All Reverted Cases
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>
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


    $('#search_by_filter').click(function(){
        $('#searchByFilterModal').modal('show');
    });

    $('#search_by_filter').click(function(){
        $('#searchByFilterModal').modal('show');
    });


    $('.search_button').click(function(){
        load_data();
    });

    $('#datatable_reverted').DataTable();

    load_data();


</script>

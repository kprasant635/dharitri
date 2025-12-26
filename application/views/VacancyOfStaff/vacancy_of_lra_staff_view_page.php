<!-- Masud's CSS-->
<style>
    .error
    {
        color: red;
    }
    .tab-content .card:hover{
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .tab-content .card:active{

        box-shadow: none !important;
    }

    .wizard {
        margin: 10px auto;
    }

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
        padding-top: 10px;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }


    .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        border: 0;
        background-color: #005B96 !important;
        text-decoration: none;
    }
    .wizard li.active{
        background: #005B96;
        padding: 0px;
        box-shadow: 1px 0px 1px 1px;

    }

    .wizard .nav-tabs > li {
        width: 16%;
        border: none;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        /*opacity: 0;*/
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        /*border-bottom-color: #5bc0de;*/
        transition: 0.1s ease-in-out;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 45%;
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #ffffff;
    }

    .wizard .nav-tabs > li a {
        text-align: center;
        /* width: 90%; */
        margin-bottom: 10px;
        /* padding: 0; */
    }
    .wizard .nav-tabs > li a:hover {
        background-color: transparent !important;
    }


    /* div alternate color */
    div.lm-report > div:nth-of-type(odd) {
        background: #f2fdff;
    }



</style>

<style>
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
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
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }

    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
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
        margin-bottom: 10px;
        margin-top: 10px;
        background: linear-gradient(to right, #267871, #136a8a);
        color: white;
        text-transform: capitalize;
        text-align: center;
        padding: 8px;
    }

    .title{
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        margin-top: 10px;
        text-transform: capitalize;
        margin-left: 25px;
    }
    .reza-body{
        padding-top: 10px;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
        margin: 10px;
    }

    .bgheading{
        background-color: #248cf7 !important;
    }
    .tableCard{
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-left: 15px!important;
        padding-right: 15px!important;
        margin-bottom: 15px!important;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 4px;
    }
    .labDiv{
        margin-bottom: 15px;
    }
    .lab{
        margin-bottom: 5px;
    }
    .landDetails{
        display: none;
    }
    .modal-header{
        background-color: #248cf7!important;
        color: white;
    }
    .modal-body{
        padding: 25px!important;
    }
</style>


<div class="row" style='padding: 30px 40px 30px 10px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>
            <br>
        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
            <br>
        <?php } ?>

        <h5 class="bg-info p-2 text-white shadow" style="margin-top: 10px;margin-bottom: 25px; text-transform: uppercase; text-align: center">
            Land Records Staff (Assistant)
        </h5>


        <div class="reza-card" style="margin-bottom: 25px;">
            <div class="reza-body">
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h5>
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i> Land Records Assistant (LRA)
                        </h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right">
                        <?php if($vacPositionLRACount != 0): ?>
                            <a href="<?php echo base_url()?>index.php/VacancyStaffController/getVacancyOfLraStaffReport" class="rezaButt buttInfo" >
                                <i class="fa fa-download" aria-hidden="true"></i> Download
                            </a>
                        <?php endif; ?>
                        <button class="rezaButt buttPrimary"  type="button" id="vacancyAddLRA">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Staff
                        </button>
                    </div>
                </div>
                <table class="table table-striped table-bordered text-bold">
                    <thead>
                    <tr>
                        <th style="width: 5%">Sl. No.</th>
                        <th style="width: 10%">Category</th>
                        <th style="width: 20%">Roster Point</th>
                        <th style="width: 20%">Name of LRA</th>
                        <th style="width: 10%">Date of Joining</th>
                        <th style="width: 10%">Date of Superannuation</th>
                        <th style="width: 25%">Remarks</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php if($vacPositionLRACount == 0): ?>
                        <tr>
                            <td colspan="7"> No Data Found</td>
                        </tr>
                    <?php else: ?>
                        <?php $i=1; foreach ($vacPositionLRAS as $vacPositionLRA): ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $vacPositionLRA->open_category ?></td>
                                <td><?php echo $vacPositionLRA->roster_point ?></td>
                                <td><?php echo $vacPositionLRA->lr_name ?></td>
                                <td><?php echo date("d-m-Y", strtotime($vacPositionLRA->date_of_joining)) ?></td>
                                <td><?php echo date("d-m-Y", strtotime($vacPositionLRA->date_of_superannuation)) ?></td>
                                <td><?php echo $vacPositionLRA->remarks ?></td>
                            </tr>
                            <?php $i = $i+1; endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal for LRA -->
<div class="modal" role="dialog" id="vacancyAddLRAModal" >
    <div class="modal-dialog modal-lg" role="document" style="width: 60%!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Vacancy of Land Records Assistant (LRA)</h5>
            </div>
            <form action="<?php echo base_url(); ?>index.php/VacancyStaffController/saveVacancyAssistant" method="post">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left">
                    <span style="color: #FF5252; font-size: 14px; margin-bottom: 15px">
                        All fields marked with an asterisk ( <b> * </b> ) are required
                    </span>
                </div>
                <div class="modal-body row" align="center">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="left" style="margin-bottom: 20px">
                        <label for="sel1" class="lab">Category  <span style="color: red;font-weight: bold;"> *</span></label>
                        <select name="open_category" id="" required class="form-control">
                            <option disabled selected>Select</option>
                            <option value="UR">UR</option>
                            <option value="OBC/MOBC">OBC/MOBC</option>
                            <option value="STP">STP</option>
                            <option value="SHT">SHT</option>
                            <option value="SC">SC</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="left" style="margin-bottom: 20px">
                        <label for="sel1" class="lab">Roster Point  <span style="color: red;font-weight: bold;"> *</span></label>
                        <input type="text" class="form-control" name='roster_point' placeholder="Please Enter" required>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left" style="margin-bottom: 20px">
                        <label for="sel1" class="lab">Name of LRA <span style="color: red;font-weight: bold;"> *</span></label>
                        <input type="text" class="form-control" name='lr_name' placeholder="Please Enter" required>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="left" style="margin-bottom: 20px">
                        <label for="sel1" class="lab">Date of Joining  <span style="color: red;font-weight: bold;"> *</span></label>
                        <input type="date" class="form-control" name='date_of_joining' placeholder="Please Enter" required>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="left" style="margin-bottom: 20px">
                        <label for="sel1" class="lab">Date of Superannuation  <span style="color: red;font-weight: bold;"> *</span></label>
                        <input type="date" class="form-control" name='date_of_superannuation' placeholder="Please Enter" required>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left" style="margin-bottom: 20px">
                        <label for="sel1" class="lab">Remarks</label>
                        <textarea type="text" class="form-control" name='remarks' ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="rezaButt btn-secondary"  id="vacancyAddLRSNo">NO</button>
                    <button type="submit" class="rezaButt btn-success"   id="vacancyAddLRSYes">YES, SUBMIT</button>
                </div>
            </form>
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
            timer: 8000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 50000,
            showCancelButton: true

        });
    }

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 50000,
            showConfirmButton: true,
        });
    }



    // **** LRA ********************************************************


    $(document).on('click','#vacancyAddLRA',function ()
    {
        $('#vacancyAddLRAModal').modal('show');
    });

    $(document).on('click','#vacancyAddLRANo',function ()
    {
        $('#vacancyAddLRAModal').modal('hide');
    });

</script>

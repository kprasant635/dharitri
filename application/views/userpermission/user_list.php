<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 5px;
        border: 1px solid #888;
        width: 900px;
    }
    /* The Close Button */
    .close-modal {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close-modal:hover,
    .close-modal:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

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

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }

</style>

<div class="row" style='padding: 20px 30px 20px 0px'>
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
        <?php if ($this->session->flashdata('message')) : ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
        <?php endif; ?>


        <div class="reza-card">
            <div class="reza-title">
                User list
                <div class="bs-callout bs-callout-info mt-1 mb-1" id="callout-type-b-i-elems">
                    <h6 class="red uni_text"><b>NOTE : This module enable/disable selected user to access RCCMS portal.</b></h6>
                </div>
                <div class="row">
                    <div class="success-msg" style="display:none;">
                        <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                            <b><i class="fa fa-check" id="success_msg"></i></b>
                        </div>
                    </div>
                    <div style="display:none;" class="error-msg alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                        <b id="error_msg"></b>
                    </div>
                </div>
            </div>
            <div class="reza-body">
                <table id="datatable" class="datatable table table-stripped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnt = 0;
                        foreach($users as $user){
                            $cnt++;
                        ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['desg']; ?></td>
                                <!-- <td><a href="<?php echo base_url().'index.php/user-permission/'.$user['user_code']; ?>" class="btn btn-primary">Permission</a></td> -->
                                <td>
                                    <?php
                                    if($user['permission_allowed'] == 1){
                                        ?>
                                            <a class="btn btn-success permission_revert text-white" data-user_code="<?php echo $user['user_code']; ?>">Premission Revert</a>
                                        <?php
                                    } else{
                                    ?>
                                        <a href="#" class="btn btn-primary permission_for_rccm text-white" data-user_code="<?php echo $user['user_code']; ?>">Allow RCCMS</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal bs-example-modal-md" id='myLargeModalLabelApproved' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelApproved">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            <div class="row text-right">
                <span class="edit-enc-close px-4">&times;</span>
            </div>
            <div class="modal-body">
                <form id="ajaxMappingFormForward">
                <h4 style="border-bottom: 5px solid #ff681d;">Below listed applications will be forwarded to Directorate of Land Records(DLRs)</h4>
                <div class="row">
                    <div class="col-lg-4">
                       <b style="font-size:18px"><i class="fa fa-info-circle text-red"></i> Selected Applications</b>
                    </div>
                    <div class="col-lg-8">
                       <b style="font-size:18px"> <textarea class="form-control" readonly="" id="applications_view" style="height: 180px;"></textarea></b>
                       <input type="hidden" name="application_list" id="application_list">
                      
                    </div>
                </div>
                <div class="container mt-2" style="margin-bottom:25px">
                    <div class="col-md-6 text-center">
                        <label for="" class="text-danger"><i class="fa fa-hand-o-right text-green"></i> DC Remarks</label>
                   </div>
                   <div class="col-md-6">   
                        <textarea class="form-control" placeholder="Remarks" name="dc_remarks" id="dc_remarks" required></textarea>
                   </div>
               </div>
               
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal  bs-example-modal-md" id='myLargeModalLabelReject' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelReject">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            <div class="row text-right">
                <span class="edit-enc-close-reject px-4">&times;</span>
            </div>
            <div class="modal-body">
                <form id="ajaxMappingFormRevert">
                <h4 style="border-bottom: 5px solid #ff681d;">Below listed applications will be rejected</h4>
                <div class="row">
                    <div class="col-lg-4">
                       <b style="font-size:18px"><i class="fa fa-info-circle text-red"></i> Selected Applications</b>
                    </div>
                    <div class="col-lg-8">
                       <b style="font-size:18px"> <textarea class="form-control" readonly="" id="applications_view" style="height: 180px;"></textarea></b>
                       <input type="hidden" name="application_list" id="application_list">
                      
                    </div>
                </div>
                <div class="container mt-2" style="margin-bottom:25px">
                    <div class="col-md-6 text-center">
                        <label for="" class="text-danger"><i class="fa fa-hand-o-right text-green"></i> DC Remarks for Rejection</label>
                   </div>
                   <div class="col-md-6">   
                        <textarea class="form-control" placeholder="Remarks" name="dc_remarks" id="dc_remarks" required></textarea>
                   </div>
               </div>
               
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-save"></i> Reject</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    var selectedCheckBoxArray = [];
    function showSuccessMessage(text) 
    {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) 
    {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true

        });
    }

    function openModalForFlag()
    {
        if(selectedCheckBoxArray.length == 0)
        {
            showErrorMessage("Please select one application for proceed...");
            return false;
        }
        var btn = document.getElementById("myBtn");
        var span_close = document.getElementsByClassName("edit-enc-close")[0];
        $('#myLargeModalLabelApproved').modal('show');
        $('.modal-backdrop').remove();

        $("#applications_view").html(selectedCheckBoxArray.toString());
        $("#application_list").val(selectedCheckBoxArray);
        span_close.onclick = function() {
           $('#myLargeModalLabelApproved').modal('hide');
        }
    }

    function openModalForFlagReject()
    {
        $('.modal-backdrop').hide();
        if(selectedCheckBoxArray.length == 0)
        {
            showErrorMessage("Please select one application for proceed...");
            return false;
        }
        var btn = document.getElementById("myBtn");
        var span_close = document.getElementsByClassName("edit-enc-close-reject")[0];
        $('#myLargeModalLabelReject').modal('show');
        $('.modal-backdrop').remove();
        $("#applications_view").html(selectedCheckBoxArray.toString());
        $("#application_list").val(selectedCheckBoxArray);
        span_close.onclick = function() {
           $('#myLargeModalLabelReject').modal('hide');
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.permission_for_rccm', function(e) {
            e.preventDefault();
            let actionUrl = '<?php echo base_url(). 'index.php/permission-for-rccm-store/'; ?>';
            let user_code = $(this).data('user_code');
            Swal.fire({
                title: "Are you sure?",
                text: "The user is able to access the RCCM application.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        url: actionUrl,
                        dataType: 'json',
                        data: { "user_code": user_code },
                        success: function(response) {
                            if (response.success) {
                                $(".success-msg").show();
                                $("#success_msg").html(response.message);
                            } else{
                                $(".error-msg").show();
                                $("#error_msg").html(response.message);
                            }                   
                        },
                        error: function(errors) {
                            console.log("errors: ", errors.responseJSON);
                        },
                        complete : function() {
                            setTimeout(() => {
                                $(".success-msg").hide();
                                $(".error-msg").hide();
                                location.reload();
                            }, 4000);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.permission_revert', function(e) {
            e.preventDefault();
            let actionUrl = '<?php echo base_url(). 'index.php/permission-revert-rccm/'; ?>';
            let user_code = $(this).data('user_code');
            Swal.fire({
                title: "Are you sure?",
                text: "The user will not be able to access the RCCM application.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        url: actionUrl,
                        dataType: 'json',
                        data: { "user_code": user_code },
                        success: function(response) {
                            if (response.success) {
                                $(".success-msg").show();
                                $("#success_msg").html(response.message);
                            } else{
                                $(".error-msg").show();
                                $("#error_msg").html(response.message);
                            }                   
                        },
                        error: function(errors) {
                            console.log("errors: ", errors.responseJSON);
                        },
                        complete : function() {
                            setTimeout(() => {
                                $(".success-msg").hide();
                                $(".error-msg").hide();
                                location.reload();
                            }, 4000);
                        }
                    });
                }
            });
        });
    });
</script>


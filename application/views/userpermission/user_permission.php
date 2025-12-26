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

<div class="row d-flex justify-content-center" style='padding: 20px 30px 20px 0px'>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
            <div class="reza-title">Permission For <?php echo $user['username']; ?></div>
            <div class="reza-body">
                <table id="datatable" class="datatable table table-stripped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Application</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnt = 0;
                        foreach($applications as $application){
                            $cnt++;
                        ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td>
                                    <a href="#" class="get_services" data-app_id="<?php echo $application['id']; ?>" data-user_code="<?php echo $user_code; ?>"><?php echo $application['name']; ?></a>
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


<div class="modal bs-example-modal-md" id="servicesModal" tabindex="-1" role="dialog" aria-labelledby="servicesModal">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            <div class="modal-header">
                <h4 class="modal-title">Permission For <?php echo $user['username']; ?></h4>
                <button type="button" class="close closeModal" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="success-msg" style="display:none;">
                    <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                        <b><i class="fa fa-check" id="success_msg"></i></b>
                    </div>
                </div>
                <div style="display:none;" class="error-msg alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <b id="error_msg"></b>
                </div>
                <form id="permission_form" class="services_cls"></form>
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
    $(document).ready(function() {
        $(document).on('click', '.get_services', function(e) {
            let app_id = $(this).data('app_id');
            let user_code = $(this).data('user_code');
            let actionUrl = '<?php echo base_url(). 'index.php/get-application-services/'; ?>'+user_code+'/'+app_id;
            
            $.ajax({
                method: 'GET',
                url: actionUrl,
                dataType: 'json',
                // data: { "user_code": user_code, "app_id": 2, "service_id": services },
                success: function(response) {
                    console.log("response: ", response); 
                    $('#servicesModal').modal('show');
                    $('.modal-backdrop').remove();    
                    $('.services_cls').html("");               
                    $('.services_cls').append(response.html);  
                    $('#user_code').val(user_code)             
                },
                error: function(errors) {
                    console.log("errors: ", errors);
                },
                complete : function() {
                    
                }
            });
        });

        $(document).on('click', '.closeModal', function(e) {
            $('#servicesModal').modal('hide');
        });

        $(document).on('click', '#checkedAll', function(e) {
            if(this.checked){
                $('.selectMark').each(function(){
                    this.checked = true;
                    var id = $(this).val();
                    if($.inArray(id, selectedCheckBoxArray) !== -1){
                        // $('.selectMark').prop('checked', false);
                    }else{
                        selectedCheckBoxArray.push(id);
                        $('.selectMark').prop('checked', true);
                    }
                })
            }else{
                $('.selectMark').each(function(){
                    this.checked = false;
                    var id = $(this).val();
                    var rowIndex = $.inArray(id, selectedCheckBoxArray);
                    if(rowIndex == -1){

                    }else{
                        selectedCheckBoxArray.splice(rowIndex, 1);
                        $('.selectMark').prop('checked', false);
                    }                
                })
            }
            // console.log(selectedCheckBoxArray);
        });

        $(document).on('submit', '#permission_form', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let actionUrl = '<?php echo base_url(). 'index.php/user-permission-store/'; ?>';

            $.ajax({
                method: 'POST',
                url: actionUrl,
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                // data: { "user_code": user_code, "app_id": 2, "service_id": services },
                success: function(response) {
                    if (response.success) {
                        $(".success-msg").show();
                        $("#success_msg").html(response.message);
                        setTimeout(() => {
                            window.location.href = "<?= base_url(); ?>index.php/user-list";
                        }, 4000);
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
                    }, 3000);
                }
            });
        });

    });
</script>


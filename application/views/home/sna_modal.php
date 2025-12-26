<style>
    .modal_color {
        background-color: #516789 !important;
        color:white;
    }

    .top-color{
        background:linear-gradient(180deg, rgba(117,145,189,1) 0%, rgba(161,198,245,1) 47%, rgba(247,247,247,0.5466561624649859) 100%);
    }

    .new_joinee_color{
        background: linear-gradient(180deg, rgba(157,152,238,1) 0%, rgba(134,214,251,1) 35%, rgba(247,247,247,0.5466561624649859) 100%);
    }
</style>
<div class="modal sna_index_modal" id="sna_index_modal" data-keyboard="false" data-backdrop="static" role="dialog" >
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header1" style="background-color:#E08243"> 
                <h3 class="text-center mt-2 text-white" >
                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                    <u class="text-white">
                        KINDLY FILL UP THE FOLLOWING DETAILS...!!!
                    </u>
                </h3>
            </div>
            <!-- fetching user details -->
            <?php 
                $dist_code= $this->session->userdata('dist_code');
                $subdiv_code= $this->session->userdata('subdiv_code');
                $cir_code= $this->session->userdata('cir_code');
                $user_code= $this->session->userdata('user_code');
                $get_all_user_data = $this->SnaReportModel->fetchAllUserdata($dist_code,$subdiv_code,$cir_code,$user_code);
                $getUniqueSnaCode = $this->SnaReportModel->getUniqueSnaCode($dist_code,$subdiv_code,$cir_code);
            ?>
            <form id="sna_modal_form" method="POST">
            <div class="modal-body">
                <!-- first header -->
                <div class="modal_color row">
                    <div class="col-md-3 mb-2">
                        <label><?php echo $this->lang->line('district') ?>
                            <span style="color:yellow;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <?php $dist_code = $this->session->userdata('dist_code'); ?>
                        <?php echo $this->utilityclass->getDistrictName($dist_code); ?>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label><?php echo $this->lang->line('subdivision') ?>
                            <span style="color:yellow;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                            <?php $subdiv_code = $this->session->userdata('subdiv_code'); ?>
                            <?php echo $this->utilityclass->getSubDivName($dist_code, $subdiv_code); ?>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>
                            <?php echo $this->lang->line('circle') ?>
                            <span style="color:yellow;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                            <?php $cir_code = $this->session->userdata('cir_code'); ?>
                            <?php echo $this->utilityclass->getCircleName($dist_code, $subdiv_code,$cir_code); ?>
                    </div>
                    <div class="col-md-3 mb-2" style="margin-top:10px">
                        Unique SNA Code: <?=$getUniqueSnaCode?>
                    </div>
                </div>
                <!-- second div -->
                <div class="row top-color">
                    <div class="col-md-4 mb-2">
                        <label>Name :
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input type="text" name="user_name" value="<?=$get_all_user_data->username?>" readonly class="form-control">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Upload Joining Document :
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input type="file" name="join_doc"  class="form-control">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Joining date :
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input type="date" name="join_date" max = <?=date("Y-m-d")?> class="form-control">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Phone Number :
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input type="text" name="user_phone_number" value="<?=$get_all_user_data->phone_no?>" readonly class="form-control">
                    </div>
                    <!-- <div class="col-md-4 mb-2">
                        <label>Gender:
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <select name= "gender" class="form-control">
                            <option selected disabled> --SELECT--</option>
                            <option value="1"> Male</option>
                            <option value="2"> Female</option>
                            <option value="3"> Others</option>
                        </select>
                    </div> -->
                    <div class="col-md-4 mb-2">
                        <label>Address:
                            <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                        </label>
                        <input type="text" name="user_address" class="form-control">
                    </div>
                </div>
                <hr>
                <p class="bg" style="padding: 10px;margin-top:2rem"><b>Are You Transfered From Other Circle Office?</b><br>
                <div class="form-group" class="name-confirm" id='name-confirm'>
                <label class="radio-inline">
                    <input type="radio"  class='name-confirm-class' name="transfer_type"  value="y">Yes
                </label>
                <label class="radio-inline">
                    <input type="radio"  class='name-confirm-class' name="transfer_type" value="n">No
                </label>
                </div>
                <hr>
                <div class="new_joinee_color" id ="new_joinee" style="display:none">
                    <u><h6 style="text-align:center">Select Your Previous Location Of Posting</h6></u>
                    <div class="col-md-3 mb-2">
                        <?php $district = $this->SnaReportModel->getAllDistrict();?>
                        <label>District:
                            <select name="prev_dist" class="form-control" aria-label="Default select example" id="district_code" onchange="districtOnChange()">
                                <option selected>SELECT DISTRICT</option>
                                <?php foreach ($district as $key => $dist) { ?>
                                    <option value="<?php echo $dist->dist_code; ?>"><?php echo $dist->loc_name; ?></option>
                                <?php  } ?>
                            </select> 
                        </label>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Sub Division:
                            <select name="prev_subdiv" class="form-control" aria-label="Default select example" onchange="subdivOnChange()" id="subdiv_list" name="subdiv_list">
                                <option value="00" selected>SELECT SUB DIVISION</option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label>Circle:
                            <select name="prev_cir" class="form-control" aria-label="Default select example" onchange="circleOnChange()"id="circle_list" name="circle_list">
                                <option value="00" selected>SELECT CIRCLE</option>
                            </select>
                        </label>
                    </div>
                    <div name ="prev_user" class="col-md-3 mb-2">
                        <label>User name:
                            <select class="form-control" aria-label="Default select example"  id="previous_user_list" name="previous_user_list">
                                <option value="00" selected>SELECT PREVIOUS USER</option>
                            </select>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label>Previous Joining date:
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>
                            <input type="date" max = <?=date("Y-m-d")?> name="prev_joining_date" class="form-control">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label>Previous Leaving date:
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>
                            <input type="date" max = <?=date("Y-m-d")?> name="prev_leave_date" class="form-control">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label>Previous Transfer Order Certificate:
                                <span style="color:red;font-weight:bold; font-size: 25px;">*</span>
                            </label>
                            <input type="file" name="prev_transfer_cert" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="error_div" style="display:none;margin-top:1rem">
                    <div class="card-header h5 bg-danger text-white text-center">
                        VALIDATION ERRORS
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important" id="error_div_msg">
                        </strong>
                    </div>
                </div>
                <!-- validation-error-div-end -->
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4" style="text-align:center">
                        <button type="button" onclick="sna_formSubmit()"class="btn btn-success btn-xs">
                            <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                            Submit
                        </button>
                        <!-- <button type="button" id='modal-close' class="btn btn-danger" data-dismiss="modal">Close</button> -->
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload();
        }
    });
    }
    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            timer: 5000,
            showCancelButton: true
        });
    }
</script>
<script type="text/javascript">
    $(window).load(function()
    {
        var snaUser=$('#snaUser').val();
        $('#sna_index_modal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#sna_index_modal").modal("show"); 
    });
    $('#modal-close').click(function(){
        $('#sna_index_modal').modal('hide');
    });


    $(".name-confirm-class").click(function(){
        
        var mm = $('input[name="transfer_type"]:checked').val();
        if(mm == 'y'){
            $('#new_joinee').show();
        }else if(mm == 'n'){
            $('#new_joinee').hide();
        }
    });

    //function village on change 
    function districtOnChange(){

        //***************select-reset*************/
        $('#subdiv_list').empty();
        $('#subdiv_list').append('<option value="00" selected>-SELECT SUBDIVISION-</option>');
        //***************************************/
        var district = $('#district_code').val();
        
        if(district == '00'){
            alert("Please select a District...!!");
            return;
        }
        const application = {
                dist_code  : district,            
            };
        $.ajax({ 
            url: baseurl + "SnaReport/getSubdivNames",
            type: 'POST',
            data: JSON.stringify(application),
            cache : false,
            processData: false,
            dataType: 'json',
            success: function (data) { 
                console.log(data);     
                for(var i=0; i<data.length; i++) {
                    $('#subdiv_list').append('<option value="'+data[i].dist_code+','+data[i].subdiv_code+'">'+ data[i].loc_name+'</option>');
                }
            },
            error: function (jqXHR, exception) {
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });

    }

    //function village on change 
    function subdivOnChange(){

        //***************select-reset*************/
        $('#circle_list').empty();
        $('#circle_list').append('<option value="00" selected>-SELECT CIRCLE-</option>');
        //***************************************/
        var district = $('#district_code').val();
        var location = $('#subdiv_list').val();
        var explodedString = location.split(",");
        var dist_code =explodedString[0];
        var  subdiv_code =explodedString[1];
        if(district == '00'){
            alert("Please select a District...!!");
            return;
        }
        const application = {
                dist_code  : district,            
                subdiv_code  : subdiv_code,            
            };
        $.ajax({ 
            url: baseurl + "SnaReport/getCircleNames",
            type: 'POST',
            data: JSON.stringify(application),
            cache : false,
            processData: false,
            dataType: 'json',
            success: function (data) { 
                console.log(data);     
                for(var i=0; i<data.length; i++) {
                    $('#circle_list').append('<option value="'+data[i].dist_code+','+data[i].subdiv_code+','+data[i].cir_code+'">'+ data[i].loc_name+'</option>');
                }
            },
            error: function (jqXHR, exception) {
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });

    }

    //function village on change 
    function circleOnChange(){

        //***************select-reset*************/
        $('#previous_user_list').empty();
        $('#previous_user_list').append('<option value="00" selected>-SELECT PREVIOUS USERS-</option>');
        //***************************************/
        var district = $('#district_code').val();
        var location = $('#circle_list').val();

        var explodedString = location.split(",");
        var dist_code =explodedString[0];
        var subdiv_code =explodedString[1];
        var cir_code =explodedString[2];
        // alert(subdiv_code);
        // return;
        if(district == '00'){
            alert("Please select a District...!!");
            return;
        }
        const application = {
                dist_code  : district,            
                subdiv_code  : subdiv_code,            
                cir_code  : cir_code,            
            };
        $.ajax({ 
            url: baseurl + "SnaReport/getPreviousUserList",
            type: 'POST',
            data: JSON.stringify(application),
            cache : false,
            processData: false,
            dataType: 'json',
            success: function (data) { 
                console.log(data);     
                for(var i=0; i<data.length; i++) {
                    $('#previous_user_list').append('<option value="'+data[i].dist_code+','+data[i].subdiv_code+','+data[i].cir_code+','+data[i].user_code+'">'+ data[i].username+'</option>');
                }
            },
            error: function (jqXHR, exception) {
                alert('Could not Complete your Request ..!, Please Try Again later..!');
            }  
        });

    }


    function sna_formSubmit(){
        event.preventDefault();
        var formdata = new FormData(document.getElementById('sna_modal_form'));
        //console.log(formdata);
        $.ajax({
            url: baseurl + "SnaReport/submitSnaForm",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: $('#displayBox'),
                    css: {
                        border:'none',
                        backgroundColor:'transparent'
                    }
                });
            },
            success: function (data) {
                if(data.result == 'VALIDATION-ERROR'){
                    $.unblockUI();
                    $('#error_div').show();
                    for (let i = 0; i < data.msg.length; i++) {
                        $('#error_div_msg').append(data.msg[i]);
                    }
                    return;
                }else if(data.result == 'SUCCESS'){
                    $.unblockUI();
                    showSuccessMessage(data.msg);
                }else if(data.result == 'FILE_UPLOAD_ERR'){
                    $.unblockUI();
                    showErrorMessage(data.msg);
                }else{
                    $.unblockUI();
                    showErrorMessage(data.msg);
                }
            },
            error: function (jqXHR, exception) {
                $.unblockUI();
                showErrorMessage('Could not Complete your Request ..!, Please Try Again later..!');
                //alert('Could not Complete your Request ..!, Please Try Again later..!');
            }
        });
    }
</script>
    
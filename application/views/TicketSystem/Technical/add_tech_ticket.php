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
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
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
    .rezaText {
        font-size: 16px;
    }

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }

    #files-area {
        width: 100%;
        margin: 0 auto;
    }
    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;
    }
    .file-block > span.name {
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        width: max-content;
        display: inline-flex;
    }

    .file-delete {
        display: flex;
        width: 24px;
        padding-top: 3px;
        color: red;
        background-color: #6eb4ff00;
        font-size: large;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;
    }
    .card-subtitle{
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .rezaBR{
        margin-top: 15px;
    }


</style>
<div class="row" style='padding: 10px 20px 20px 0px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
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
        <?php } ?>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            <?php echo $this->lang->line('TicketSidebar') ?> /
            <a href="<?= base_url()?>index.php/TicketCommonController/getTicketSystemDashboard">
                Dashboard
            </a>
            /
            <?php echo $this->lang->line('TicketTech') ?>


            <a href="<?= base_url()?>index.php/TicketCommonController/getTicketSystemDashboard">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>

        <?php $slNo = 0; ?>
        <?php $stepNo = 0; ?>

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('TicketTech') ?></span>
                <hr>
            </div>
            <div class="reza-body">
                <div class="body">
                    <div class="row"><h4>TICKET DETAILS</h4></div>
                    <h5 class="card-subtitle"><code> All fields marked with asterisks(*) are required  </code></h5>

                    <form id="myForm" action="" method="POST" enctype="multipart/form-data">
                        <div class="body" >
                            <div class="row masudBorder">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 rezaBR" >
                                    <div class="form-group">
                                        <label  class="form-label">Application Type <span style="color:red;">*</span></label>
                                        <select class="select form-control" style="width: 100%" id="appType" name="appType" required>
                                            <option selected disabled>Select</option>
                                            <?php foreach($applications as $application): ?>
                                                <option value="<?php echo $application->id ?>">
                                                    <?php echo $application->application_name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span style="color: red">
                                            <?php echo form_error('appType'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 rezaBR" >
                                    <div class="form-group">
                                        <label  class="form-label">Service Type <span style="color:red;">*</span></label>
                                        <select class="select form-control" style="width: 100%" id="serviceType" name="serviceType" required>

                                        </select>
                                        <span style="color: red">
                                            <?php echo form_error('serviceType'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 rezaBR" >
                                    <div class="form-group">
                                        <label  class="form-label">Ticket Category <span style="color:red;">*</span></label>
                                        <select class="select form-control" style="width: 100%" id="ticketCategory" name="ticketCategory" required>
                                            <?php foreach($types as $type): ?>
                                                <option value="<?php echo $type->id ?>">
                                                    <?php echo $type->t_type_name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span style="color: red">
                                            <?php echo form_error('ticketCategory'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 rezaBR" >
                                    <div class="form-group ">
                                        <label class="form-label">Reference Case No. <span id="refMark" style="color:red;">*</span> </label>
                                        <input type="text" class="form-control" id="refCaseNo"  name="refCaseNo"  value="<?=set_value('refCaseNo')?>"  maxlength="180" required >
                                    </div>
                                    <span style="color: red">
                                        <?php echo form_error('refCaseNo'); ?>
                                    </span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rezaBR" >
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Subject <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="subject" name="subject" required value="<?=set_value('subject')?>" minlength="2" maxlength="180">
                                        </div>
                                    </div>
                                    <span style="color: red">
                                        <?php echo form_error('subject'); ?>
                                    </span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rezaBR" >
                                    <label class="form-label">Ticket Details <span style="color:red;">*</span></label>

                                    <textarea id="ckeditor" name="ticketDetails" required minlength="2" maxlength="3000"> </textarea>
                                    <span style="color: red">
                                        <?php echo form_error('ticketDetails'); ?>
                                    </span>
                                </div>

                                <input type="hidden" id="fileCounter" name="fileCounter">

                                <?php include(APPPATH."views/TicketSystem/Include/addMoreDocument.php");  ?>

                            </div>

                            <br>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="submitToCo" class="rezaButt btn-primary waves-effect">SAVE & SUBMIT</button>
                            <button type="reset" class="rezaButt btn-danger waves-effect" >RESET</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for confirmation -->
<div class="modal" role="dialog" id="submitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure ?</h3>
                <br>
                <h5>Do you want to report this ticket and forward it to NIC ?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="submitModalNo">NO</button>
                <button type="button" class="btn btn-primary"   id="submitModalYes">YES, SUBMIT</button>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<!-- Ckeditor -->
<script src="<?php echo base_url();?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url();?>assets/js/pages/forms/editors.js"></script>
<script>
    CKEDITOR.replace('ckeditor', {
        height: 300,
        // Custom toolbar
        toolbar: [
            { name: 'clipboard', items: ['Undo', 'Redo', 'Paste', 'PasteText'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'HorizontalRule'] },
            { name: 'links', items: ['Unlink'] },
            { name: 'insert', items: ['Table'] },
            { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize'] }
        ],
        // Remove unwanted plugins
        removePlugins: 'image,flash,smiley,specialchar,sourcearea,maximize',
        resize_enabled: true
    });
</script>

<script>
    const refInput = $('#refCaseNo');
    const refMark = $('#refMark');

    $('#ticketCategory').on('change', function()
    {
        const selectedId = $(this).val();

        if (selectedId == '2')
        {
            refMark.hide();
            refInput.prop('required', false);
        }
        else
        {
            refMark.show();
            refInput.prop('required', true);
        }
    }).trigger('change');


    function showSuccessMessage(text) {
        swal.fire({
            backdrop:true,
            allowOutsideClick: false,
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
            backdrop:true,
            allowOutsideClick: false,
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    var BASE_URL = $("#getBaseURL").val();


    function loader(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
    }


    // get service list
    $('#appType').change(function ()
    {
        loader();
        var appTypeId = $('#appType').val();

        if(appTypeId == '')
        {
            $.unblockUI();
            showErrorMessage('Something went wrong.');
        }

        const sendData = {
            appTypeId : appTypeId
        };

        $.ajax({
            url: BASE_URL + "/TicketCommonController/getAllServiceTypeByAppId",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            beforeSend: function () {
                $('#serviceType').prop('selectedIndex', 0);

            },
            success: function (data)
            {
                $.unblockUI();
                if(data.responseType == 2)
                {
                    $.unblockUI();
                    var html = '';
                    var i;
                    html += '<option value="">Please select</option>';
                    for (i = 0; i < data['services'].length; i++)
                    {
                        var service_id  = data['services'][i].id;
                        var serviceName = data['services'][i].service_name;
                        html += '<option value=' + service_id + '>' + serviceName + '</option>';
                    }
                    $('#serviceType').html(html);
                }
                else
                {
                    $.unblockUI();
                    showErrorMessage(data.message);
                }

            },error: function (error)
            {
                $.unblockUI();
                showErrorMessage('Something went wrong.');
            },
            data: JSON.stringify(sendData)
        });
    });



    $(document).on('click','#submitToCo',function ()
    {
        $('#submitModal').modal('show');
    });

    $(document).on('click','#submitModalNo',function ()
    {
        $('#submitModal').modal('hide');
    });


    // submit & forward to NIC Manager
    $(document).on('click','#submitModalYes',function ()
    {
        $('#submitModal').modal('hide');
        var form_data = new FormData();

        var appType        = $('#appType').val();
        var serviceType    = $('#serviceType').val();
        var ticketCategory = $('#ticketCategory').val();
        var refCaseNo      = $('#refCaseNo').val();
        var subject        = $('#subject').val();
        var fileTotCount   = $('#fileCounter').val();
        var ckeditor       =  CKEDITOR.instances.ckeditor.getData();

        if(appType == '')
        {
            showErrorMessage("Please Select Application Type !");
            return false;
        }
        if(serviceType == '')
        {
            showErrorMessage("Please Select Service Type !");
            return false;
        }
        if(ticketCategory == '')
        {
            showErrorMessage("Please select Ticket Category !");
            return false;
        }
        if (ticketCategory != '2')
        {
            if(refCaseNo == '')
            {
                showErrorMessage("Please Enter Reference Case No...");
                return false;
            }
        }
        if(subject == '')
        {
            showErrorMessage("Please Enter Subject !");
            return false;
        }
        if(ckeditor == '')
        {
            showErrorMessage("Please Enter Ticket Details !");
            return false;
        }
        if(fileTotCount == '')
        {
            showErrorMessage("Kindly upload at least one document file...");
            return false;
        }



        form_data.append("appType", appType);
        form_data.append("serviceType", serviceType);
        form_data.append("ticketCategory", ticketCategory);
        form_data.append("refCaseNo", refCaseNo);
        form_data.append("subject", subject);
        form_data.append("ckeditor", ckeditor);

        for (var index = 1; index <= fileTotCount; index++)
        {
            console.log("--"+index);
            var name = document.getElementById('uploadFile'+index);

            if(name){
                form_data.append("uploadFile"+index, name.files[0]);
                form_data.append("document"+index, $('#document'+index).val());
            }
        }

        var fileCounter = $("#fileCounter").val();
        form_data.append("fileCounter", fileCounter);

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: BASE_URL + "/TicketTechnicalController/saveTechnicalTicket",
            type: "POST",
            processData: false, // important
            contentType: false, // important
            dataType: "json",
            data: form_data,
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    $('#submitModal').modal('hide');

                    showErrorMessage(data.message);
                    data.validation.forEach(function(validation)
                    {
                        var errMsg = "#" + validation.field + "Err";
                        $(errMsg).text("⚠️ " + validation.message);

                    });
                }
                else if (data.responseType == 2)
                {
                    Swal.fire({
                        icon              : 'success',
                        backdrop          : true,
                        allowOutsideClick : false,
                        text              : data.message,
                        showCancelButton  : true,
                        confirmButtonText : 'CONFIRM',
                    }).then((result) => {
                        window.location.href = BASE_URL + "/TicketTechnicalController/getAllPendingTicketListForCo";
                })
                }
            },
            error:function(data){
                $.unblockUI();
                showErrorMessage("Something went wrong");
            }
        });
    });

</script>





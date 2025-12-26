<style>
    body{
        padding-right: 0 !important;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3">
        <li class="breadcrumb-item font-weight-bold">            
            <a href="<?php echo base_url() . 'index.php/CPMSAdcController/getCPMSDetails'?>">
                CPMS
            </a>
        </li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">CPMS-Form</li>
    </ol>
</nav>
<?php if($evaluation_status == 'verification_not_completed'): ?>
    <div class="col-lg-12">
        <form action="" id="cpms_verification_form">
            <input type="hidden" name="user_code" value="<?=$consultant_code?>">
            <input type="hidden" name="year" value="<?=$year?>">
            <div class="panel panel-info">                
                <div class="panel-heading" style="background-color:#000000">
                    <h3 class="panel-title text-center">EVALUATION OF CONSULTANT PERFORMANCE MANAGEMENT SYSTEM</h3>
                </div>
                <div class="panel-heading" style="background-color:#c00;font-size: 12px;">
                    <h5 class="panel-title text-center">NOTE: INCREMENT WILL BE CALCULATED ON THE BASIS OF CONSULTANT CURRENT SALARY : <?=$baseSalary?> RS</h5>
                </div>
                <div class="panel-body">            
                    <table class="table table-bordered" id="datatable">
                        <tr style="background-color: #a5acff; font-weight:bold; font-size:16px;">
                            <th>TASK-NAME</th>
                            <th>TASK-DETAILS</th>
                            <th>CUMALATIVE-MARKS<br>ACHIEVED</th> 
                            <th>CUMALATIVE-MARKS<br>VERIFIED-BY-RO</th>
                        </tr>       
                        <?php foreach ($cpms_verification_data as $cpmsDetails):?>
                            <tr>
                                <td><?=$this->CpmsModel->getCpmsMasterTaskName($cpmsDetails->master_task_id)->name?></td>
                                <td>
                                    <button class="btn btn-success btn-sm mt-1" data-toggle="modal" onclick="viewModal()"
                                    data-target="#exampleModalCenter<?=$cpmsDetails->master_task_id?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i> view</button>                            
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter<?=$cpmsDetails->master_task_id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:60%">
                                            <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <?=$this->CpmsModel->getCpmsMasterTaskName($cpmsDetails->master_task_id)->name?>
                                                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- displayng subtask wise result -->
                                                <?php     
                                                    $subtask_wise_result = $this->CpmsModel->getSubTaskWiseResultFromMasterTaskIDADC($cpmsDetails->master_task_id, $consultant_code, $year);                                                      
                                                    $master_task_wise_result = $this->CpmsModel->getMasterTaskWiseResultFromMasterTaskID($cpmsDetails->master_task_id);                                       
                                                ?>     
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr style="background: #000000;color: white;">
                                                            <th scope="col">TASK-NAME</th>
                                                            <th scope="col">TASK-VALUE</th>
                                                            <th scope="col">TASK-NAME</th>
                                                            <th scope="col">TASK-VALUE</th>
                                                            <th scope="col">TASK-RESULT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($subtask_wise_result as $sub_task_result):?>                
                                                            <tr>
                                                                <td><?=$this->CpmsModel->getSubtaskNameFromId($sub_task_result->subtask_id)?></td>
                                                                <td><?=$sub_task_result->subtask_id_value?></td>
                                                                <td><?=$this->CpmsModel->getSubtaskNameFromId($sub_task_result->related_subtask_id)?></td>
                                                                <td><?=$sub_task_result->related_subtask_id_value?></td>
                                                                <td><?=$sub_task_result->subtask_result?>%</td>
                                                            </tr>
                                                        <?php endforeach;?>
                                                    </tbody>
                                                </table>    
                                                <div class="text-center bg-info text-white p-3">
                                                    CUMULATIVE MARKS ACHIEVED : <?=$cpmsDetails->result?>
                                                </div>        
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?=$cpmsDetails->result?></td> 
                                <td>
                                    <input type="text" placeholder="VERIFIED-MARKS" 
                                    id="cpms_verified_marks_master_task_id_<?=$cpmsDetails->master_task_id?>"
                                    name="cpms_verified_marks_master_task_id_<?=$cpmsDetails->master_task_id?>"
                                    class="form-control">
                                </td>
                            </tr>       
                        <?php endforeach;?>     
                    </table>
                    <div class="row mb-3">
                        <div class="col-lg-12 mt-3 text-center">
                            <button class="btn btn-info btn-sm" onclick="verfificationMarksSubmitHandle()"
                            style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    FORWARD
                            </button>
                            <a href="<?php echo base_url() . 'index.php/CPMSAdcController/getCPMSDetails'?>"                        
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                                <i class="glyphicon glyphicon-remove-sign"></i>
                                    CANCEL
                            </a>
                        </div>                
                    </div>  
                    <!-- validation-errors-div -->
                    <div class="col-lg-12" id="cpms_verification_marks_form_validation_error_div" style="display:none;">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong class="text-center" style="color:red !important"
                                id="cpms_verification_marks_form_validation_error_msg">
                            </strong>
                        </div>
                    </div>        
                </div>
            </div>
        </form>
    </div>
    <script>

        function viewModal(){
            event.preventDefault();
        }
                                                            
        function verfificationMarksSubmitHandle(){
            event.preventDefault();
            $('#cpms_verification_marks_form_validation_error_msg').empty();
            $('#cpms_verification_marks_form_validation_error_div').hide();
            var cpms_verification_form = $('#cpms_verification_form').serialize();
            $.ajax({
                url: baseurl + "CPMSAdcController/cpmsVerificationMarksSubmitHandle",
                type: 'POST',
                data: cpms_verification_form,
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
                    $.unblockUI();                
                    //validation_error_handle
                    if(data.result == 'VALIDATION-ERROR'){                
                        alert("Validation-Error, Please Check The Validation Errors(Shown Below The Submit Button), And Fill The Form Correctly..!");
                        $('#cpms_verification_marks_form_validation_error_div').show();
                        for (let i = 0; i < data.msg.length; i++) {
                            $('#cpms_verification_marks_form_validation_error_msg').append(data.msg[i]);
                        }
                        return;
                    }
                    //*******************/
                    if(!data.result){
                        alert(data.msg);
                        return;
                    }else if(data.result){
                        alert(data.msg);                
                        location.reload();
                        return;
                    }
                },
                error: function (jqXHR, exception) {
                    $.unblockUI();
                    alert('Could not Complete your Request ..!, Please Try Again later..!');
                }
            });
        }
    </script>
<?php else : ?>
    <div class="panel panel-info">                
        <div class="panel-heading bg-success">
            <h3 class="panel-title text-center">EVALUATION OF THE CONSULTANT PERFORMANCE IS COMPLETED</h3>
        </div>
        <div class="panel-body bg-secondary">            
            <div class="row mb-3">
                <div class="col-lg-12 mt-3 text-center">
                    <a href="<?php echo base_url() . 'index.php/CPMSAdcController/getCPMSreport/'.$year?>"                        
                        class="btn btn-danger btn-sm text-white" role="button" 
                        style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                        <i class="glyphicon glyphicon-remove-sign"></i>
                            VIEW-REPORT
                    </a>
                </div>                
            </div>      
        </div>
    </div>
<?php endif ?> 





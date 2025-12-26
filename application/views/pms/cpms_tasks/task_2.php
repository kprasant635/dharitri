<?php     
    $data_exists_flag = $this->CpmsModel->checkTask1DataExistsFromUserCode($cpmsTask->id);    
?>
<?php if($data_exists_flag): ?>
    <form id="cpms_task_2_form" method="POST">
        <?php foreach ($this->CpmsModel->getCpmsMatrix($cpmsTask->id) as $cpmsMatrix):?>
            <?php 
                $ui_parameters = json_decode($cpmsMatrix->ui_parameters);
                $evaluation_parameters = json_decode($cpmsMatrix->evaluation_parameters);
                //var_dump($evaluation_parameters);
            ?>
            <input type="hidden" name="master_task_id" value="<?=$cpmsTask->id?>">
            <?php if($ui_parameters->new_row == 'Y'): ?>
                <div class="row">
                    <div class="col-lg-1"></div>  
                    <div class="col-lg-5">
                        <table class="table table-bordered shadow-lg" style="border-radius: 2rem;">                
                            <tbody>
                                <tr>
                                    <td>
                                        <?=$this->CpmsModel->getSubtaskNameFromId($cpmsMatrix->subtask_id)?>
                                        <span style="color:red;font-weight:bold; font-size: 18px;">*</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" 
                                        onkeyup="task_2_keyup('<?=$evaluation_parameters->evaluation_subtask_id?>', 
                                        '<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                        id="task_2_subtask_id_<?=$evaluation_parameters->evaluation_subtask_id?>" 
                                        name="task_2_subtask_id_<?=$evaluation_parameters->evaluation_subtask_id?>" 
                                        placeholder="Enter The Value">
                                    </td>
                                </tr>
                            </tbody>
                        </table>   
                    </div>  
            <?php elseif($ui_parameters->new_row == 'N'): ?>   
                <?php if($evaluation_parameters->evaluation_subtask_id == 't2sT'): ?>
                    <div class="col-lg-5">
                        <table class="table table-bordered shadow-lg">                
                            <tbody>
                                <tr>
                                    <td>
                                        <?=$this->CpmsModel->getSubtaskNameFromId($cpmsMatrix->subtask_id)?>
                                        <span style="color:red;font-weight:bold; font-size: 18px;">*</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" 
                                        onkeyup="task_2_keyup('<?=$evaluation_parameters->evaluation_subtask_id?>','<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                        id="<?=$evaluation_parameters->evaluation_subtask_id?>" 
                                        name="<?=$evaluation_parameters->evaluation_subtask_id?>"
                                        placeholder="Total No Of Training" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>     
                    </div>  
                <?php else : ?>
                    <div class="col-lg-5">
                        <table class="table table-bordered shadow-lg">                
                            <tbody>
                                <tr>
                                    <td>
                                        <?=$this->CpmsModel->getSubtaskNameFromId($cpmsMatrix->subtask_id)?>
                                        <span style="color:red;font-weight:bold; font-size: 18px;">*</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" 
                                        onkeyup="task_2_keyup('<?=$evaluation_parameters->evaluation_subtask_id?>','<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                        id="task_2_subtask_id_<?=$evaluation_parameters->evaluation_subtask_id?>" 
                                        name="task_2_subtask_id_<?=$evaluation_parameters->evaluation_subtask_id?>" 
                                        placeholder="Enter The Value">
                                    </td>
                                </tr>
                            </tbody>
                        </table>     
                    </div>  
                <?php endif ?>
                <?php if($ui_parameters->end_row == 'Y'): ?>
                </div>
                <?php endif ?>   
            <?php endif ?> 
        <?php endforeach;?>    
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <table class="table table-bordered shadow-lg">                
                    <tbody>
                            <tr class="text-center text-white" style="background-color:#7993d5;font-size:16px;font-weight:bold;">
                                <td>Cumulative marks achieved</td>
                            </tr>
                            <tr class="text-center">
                                <td>
                                    <input type="text" class="form-control text-center" 
                                    id="cumalative_marks_achieved_task_2" placeholder="Percentage"
                                    name="cumalative_marks_achieved_task_2">
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>           
        </div> 
        <div class="row mb-3">
            <div class="col-lg-12 mt-3 text-center text-danger">
                <button class="btn btn-success btn-sm" onclick="submit_task_2()"
                style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        SUBMIT
                </button>
                <a href="<?php echo base_url() . 'index.php/Home/index'?>"
                    class="btn btn-danger btn-sm text-white" role="button" 
                    style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                    <i class="glyphicon glyphicon-remove-sign"></i>
                    CANCEL
                </a>
            </div>                
        </div>  
        <!-- validation-errors-div -->
        <div class="col-lg-12" id="task_2_form_validation_error_div" style="display:none;">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <strong class="text-center" style="color:red !important"
                    id="task_2_form_validation_error_msg">
                </strong>
            </div>
        </div>  
        <script>
            function task_2_keyup(subtask_id, display_input_id){                   
                var task7result = $('#task_2_subtask_id_7').val();                
                var task8result = $('#task_2_subtask_id_8').val();                    
                var task9result = $('#task_2_subtask_id_9').val();        
                var task10result = $('#task_2_subtask_id_10').val();        
                var task11result = $('#task_2_subtask_id_11').val();        
                if(task7result == null || task7result == ''){
                    $('#t2sT').val("Total will be calculated afetr filling all the values");            
                    return;
                }
                if(task8result == null || task8result == ''){
                    $('#t2sT').val("Total will be calculated afetr filling all the values");
                    return;
                }
                if(task9result == null || task9result == ''){
                    $('#t2sT').val("Total will be calculated afetr filling all the values");
                    return;
                }
                if(task10result == null || task10result == ''){
                    $('#t2sT').val("Total will be calculated afetr filling all the values");
                    return;
                }
                if(task11result == null || task11result == ''){
                    $('#t2sT').val("Total will be calculated afetr filling all the values");
                    return;
                }
                var cumalative_marks_total = parseFloat(task7result)+parseFloat(task8result)+parseFloat(task9result)+parseFloat(task10result)+parseFloat(task11result);        
                $('#t2sT').val(cumalative_marks_total);
                if(cumalative_marks_total >= 20){
                    $('#cumalative_marks_achieved_task_2').val(10);
                    return;
                }else if(cumalative_marks_total >= 15){
                    $('#cumalative_marks_achieved_task_2').val(8);
                    return;
                }else if(cumalative_marks_total >= 10){
                    $('#cumalative_marks_achieved_task_2').val(6);
                    return;
                }else if(cumalative_marks_total >= 5){
                    $('#cumalative_marks_achieved_task_2').val(4);
                    return;
                }else{
                    $('#cumalative_marks_achieved_task_2').val(0);
                    return;
                }            
            }

            function submit_task_2(){
                event.preventDefault();
                $('#task_2_form_validation_error_msg').empty();
                $('#task_2_form_validation_error_div').hide();
                var cpms_task_2_form = $('#cpms_task_2_form').serialize();                
                $.ajax({
                    url: baseurl + "CPMSController/task_2_submit_handle",
                    type: 'POST',
                    data: cpms_task_2_form,
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
                            $('#task_2_form_validation_error_div').show();
                            for (let i = 0; i < data.msg.length; i++) {
                                $('#task_2_form_validation_error_msg').append(data.msg[i]);
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
    </form>
<?php else : ?>
    <div class="alert alert-success text-center">
        <u><strong>Already data filled for <b><?=$cpmsTask->category?></b>..!!</strong></u><br>
        <button class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#exampleModalCenter2"><i class="fa fa-eye" aria-hidden="true"></i> view</button>
    </div>    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:60%">
            <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                    <?=$cpmsTask->category?> : <?=$cpmsTask->name?>
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- displayng subtask wise result -->
                <?php     
                    $subtask_wise_result = $this->CpmsModel->getSubTaskWiseResultFromMasterTaskID($cpmsTask->id);                    
                    $master_task_wise_result = $this->CpmsModel->getMasterTaskWiseResultFromMasterTaskID($cpmsTask->id);                                       
                ?>     
                <table class="table table-bordered">
                    <thead>
                        <tr style="background: #000000;color: white;">
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
                                <td><?=$sub_task_result->subtask_result?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>    
                <div class="text-center bg-info text-white p-3">
                    CUMULATIVE MARKS ACHIEVED : <?=$master_task_wise_result->result?>
                </div>        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
<?php endif ?> 
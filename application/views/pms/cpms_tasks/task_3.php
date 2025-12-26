<?php     
    $data_exists_flag = $this->CpmsModel->checkTask1DataExistsFromUserCode($cpmsTask->id);    
?>
<?php if($data_exists_flag): ?>
    <form id="cpms_task_3_form" method="POST">
        <?php foreach ($this->CpmsModel->getCpmsMatrix($cpmsTask->id) as $cpmsMatrix):?>
            <?php 
                //echo $cpmsTask->id;
                //$x = $this->CpmsModel->getCpmsMatrix($cpmsTask->id);
                // echo "<pre>";
                // var_dump($x);
                // echo "</pre>";
                //exit;
                $ui_parameters = json_decode($cpmsMatrix->ui_parameters);
                $evaluation_parameters = json_decode($cpmsMatrix->evaluation_parameters);
                //var_dump($evaluation_parameters);
            ?>
            <input type="hidden" name="master_task_id" value="<?=$cpmsTask->id?>">
            <?php if($ui_parameters->new_row == 'Y'): ?>
                <div class="row">
                    <div class="col-lg-1"></div>  
                    <div class="col-lg-4">    
                        <table class="table table-bordered shadow-sm" style="border-radius: 2rem;">                
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
                                            onkeyup="task_3_keyup('<?=$cpmsMatrix->subtask_id?>','<?=$evaluation_parameters->evaluation_from_subtask_id?>', '<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                            id="task_3_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
                                            name="task_3_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
                                            placeholder="Enter The Value">
                                        </td>
                                    </tr>
                            </tbody>
                        </table>   
                    </div> 
            <?php elseif($ui_parameters->new_row == 'N'): ?>    
                    <div class="col-lg-4">
                        <table class="table table-bordered shadow-sm">                
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
                                    onkeyup="task_3_keyup('<?=$cpmsMatrix->subtask_id?>','<?=$evaluation_parameters->evaluation_from_subtask_id?>', '<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                    id="task_3_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
                                    name="task_3_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
                                    placeholder="Enter The Value">
                                    </td>
                                </tr>
                            </tbody>
                        </table>     
                    </div>   
                    <div class="col-lg-2">                        
                        <table class="table table-bordered shadow-sm">                
                            <tbody>
                                    <tr><td>Percentage(%)</td></tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control text-primary percentage_mt1" readonly 
                                            id="task_3_evaluation_display_id_<?=$evaluation_parameters->evaluated_value_display_id?>"
                                            name="task_3_evaluation_id_<?=$evaluation_parameters->evaluated_value_display_id?>" 
                                            placeholder="Percentage">
                                        </td>
                                    </tr>
                            </tbody>
                        </table>                             
                    </div>
                </div>            
            <?php endif ?>  
        <?php endforeach;?>    
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <table class="table table-bordered shadow-sm">                
                    <tbody>
                        <tr class="text-center text-white" style="background-color:#7993d5;font-size:16px;font-weight:bold;">
                            <td>Cumulative marks achieved</td>
                        </tr>
                        <tr class="text-center">
                            <td>
                                <input type="text" name="cumalative_marks_achieved_task_3" class="form-control text-center" id="cumalative_marks_achieved_task_3" placeholder="Percentage" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>           
        </div> 
        <div class="row mb-3">
            <div class="col-lg-12 mt-3 text-center">
                <button class="btn btn-success btn-sm" onclick="submit_task_3()"
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
        <div class="col-lg-12" id="task_3_form_validation_error_div" style="display:none;">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <strong class="text-center" style="color:red !important"
                    id="task_3_form_validation_error_msg">
                </strong>
            </div>
        </div>    
    </form>
    <script>        
        function task_3_keyup(subtask_id, to_be_evalutaed_id, display_input_id){        
            var subtask_val = $('#task_3_subtask_id_'+ subtask_id).val();
            var to_be_evaluated_value = $('#task_3_subtask_id_'+ to_be_evalutaed_id).val();
            if(to_be_evaluated_value == null || to_be_evaluated_value == ""){
                return;
            }
            var result = subtask_val/to_be_evaluated_value*100;     
            //*********************testing**************************/
            //alert("Sub task Id is " + subtask_id);
            //alert("Sub Task Value Is " + subtask_val);
            //alert("To Be Evaluated Value Is" + to_be_evalutaed_id);
            //alert("Display Input Id Is " + display_input_id);
            //alert("REsult is " + result);
            //*********************testing**************************/
            $('#task_3_evaluation_display_id_'+display_input_id).val(result);
            var task1314result = $('#task_3_evaluation_display_id_t1s1314').val();                
            var task1516result = $('#task_3_evaluation_display_id_t1s1516').val();        
            var task1718result = $('#task_3_evaluation_display_id_t1s1718').val();        
            if(task1314result == null || task1314result == ''){
                $('#cumalative_marks_achieved_task_3').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                return;
            }
            if(task1516result == null || task1516result == ''){
                $('#cumalative_marks_achieved_task_3').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                return;
            }
            if(task1718result == null || task1718result == ''){
                $('#cumalative_marks_achieved_task_3').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                return;
            }
            var cumalative_marks_total = parseFloat(task1314result)+parseFloat(task1516result)+parseFloat(task1718result);        
            var cumalative_marks_avg = parseFloat(cumalative_marks_total)/3; 
            if(cumalative_marks_avg >= 90){
                $('#cumalative_marks_achieved_task_3').val(10);
                return;
            }else if(cumalative_marks_avg >= 80){
                $('#cumalative_marks_achieved_task_3').val(8);
                return;
            }else if(cumalative_marks_avg >= 70){
                $('#cumalative_marks_achieved_task_3').val(6);
                return;
            }else if(cumalative_marks_avg >= 60){
                $('#cumalative_marks_achieved_task_3').val(4);
                return;
            }else{
                $('#cumalative_marks_achieved_task_3').val(0);
                return;
            }
            
        }
        function submit_task_3(){  
            event.preventDefault();
            $('#task_3_form_validation_error_msg').empty();
            $('#task_3_form_validation_error_div').hide();
            var cpms_task_3_form = $('#cpms_task_3_form').serialize();
            $.ajax({
                url: baseurl + "CPMSController/task_3_submit_handle",
                type: 'POST',
                data: cpms_task_3_form,
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
                        $('#task_3_form_validation_error_div').show();
                        for (let i = 0; i < data.msg.length; i++) {
                            $('#task_3_form_validation_error_msg').append(data.msg[i]);
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
    <div class="alert alert-success text-center">
        <u><strong>Already data filled for <b><?=$cpmsTask->category?></b>..!!</strong></u><br>
        <button class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#exampleModalCenter3"><i class="fa fa-eye" aria-hidden="true"></i> view</button>
    </div>    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

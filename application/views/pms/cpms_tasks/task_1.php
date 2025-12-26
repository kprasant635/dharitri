<?php     
    $data_exists_flag = $this->CpmsModel->checkTask1DataExistsFromUserCode($cpmsTask->id);    
?>
<?php if($data_exists_flag): ?>
    <form id="cpms_task_1_form" method="POST">
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
                                            onkeyup="task_1_keyup('<?=$cpmsMatrix->subtask_id?>','<?=$evaluation_parameters->evaluation_from_subtask_id?>', '<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                            id="task_1_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
                                            name="task_1_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
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
                                    onkeyup="task_1_keyup('<?=$cpmsMatrix->subtask_id?>','<?=$evaluation_parameters->evaluation_from_subtask_id?>', '<?=$evaluation_parameters->evaluated_value_display_id?>')" 
                                    id="task_1_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
                                    name="task_1_subtask_id_<?=$cpmsMatrix->subtask_id?>" 
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
                                            id="task_1_evaluation_display_id_<?=$evaluation_parameters->evaluated_value_display_id?>"
                                            name="task_1_evaluation_id_<?=$evaluation_parameters->evaluated_value_display_id?>" 
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
                                <input type="text" name="cumalative_marks_achieved_task_1" class="form-control text-center" id="cumalative_marks_achieved_task_1" placeholder="Percentage" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>           
        </div> 
        <div class="row mb-3">
            <div class="col-lg-12 mt-3 text-center">
                <button class="btn btn-success btn-sm" onclick="submit_task_1()"
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
            <!-- validation-errors-div -->
            <div class="col-lg-12" id="task_1_form_validation_error_div" style="display:none;">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong class="text-center" style="color:red !important"
                        id="task_1_form_validation_error_msg">
                    </strong>
                </div>
            </div>        
        </div>  
    </form>
    <script>        
        function task_1_keyup(subtask_id, to_be_evalutaed_id, display_input_id){        
            var subtask_val = $('#task_1_subtask_id_'+ subtask_id).val();
            var to_be_evaluated_value = $('#task_1_subtask_id_'+ to_be_evalutaed_id).val();
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
            $('#task_1_evaluation_display_id_'+display_input_id).val(result);
            var task12result = $('#task_1_evaluation_display_id_t1s12').val();                
            var task34result = $('#task_1_evaluation_display_id_t1s34').val();        
            var task56result = $('#task_1_evaluation_display_id_t1s56').val();        
            if(task12result == null || task12result == ''){
                $('#cumalative_marks_achieved_task_1').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                return;
            }
            if(task34result == null || task34result == ''){
                $('#cumalative_marks_achieved_task_1').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                return;
            }
            if(task56result == null || task56result == ''){
                $('#cumalative_marks_achieved_task_1').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                return;
            }
            var cumalative_marks_total = parseFloat(task12result)+parseFloat(task34result)+parseFloat(task56result);        
            var cumalative_marks_avg = parseFloat(cumalative_marks_total)/3; 
            if(cumalative_marks_avg >= 90){
                $('#cumalative_marks_achieved_task_1').val(10);
                return;
            }else if(cumalative_marks_avg >= 80){
                $('#cumalative_marks_achieved_task_1').val(8);
                return;
            }else if(cumalative_marks_avg >= 70){
                $('#cumalative_marks_achieved_task_1').val(6);
                return;
            }else if(cumalative_marks_avg >= 60){
                $('#cumalative_marks_achieved_task_1').val(4);
                return;
            }else{
                $('#cumalative_marks_achieved_task_1').val(0);
                return;
            }
            
        }
        function submit_task_1(){
            event.preventDefault();
            $('#task_1_form_validation_error_msg').empty();
            $('#task_1_form_validation_error_div').hide();
            var cpms_task_1_form = $('#cpms_task_1_form').serialize();
            $.ajax({
                url: baseurl + "CPMSController/task_1_submit_handle",
                type: 'POST',
                data: cpms_task_1_form,
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
                        $('#task_1_form_validation_error_div').show();
                        for (let i = 0; i < data.msg.length; i++) {
                            $('#task_1_form_validation_error_msg').append(data.msg[i]);
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
        <button class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye" aria-hidden="true"></i> VIEW</button>
        <!--<?//php     
            //$proceeding_flag = $this->CpmsModel->getProceedingFlag('2023');             
            //var_dump($proceeding_flag);       
        ?>   
        <?php //if($proceeding_flag != 'C'): ?>
            <button class="btn btn-warning btn-sm mt-1" data-toggle="modal" data-target="#editTask1Modal"><i class="fa fa-edit"></i> EDIT</button>
        <?php //else : ?>
            <br><u><strong class="text-danger">NOTE: CANNOT EDIT THE TASK 1 DETAILS SINCE CPMS DETAILS ARE ALREADY VERIFIED BY ADC</strong></u><br>
        <?php //endif ?> -->
    </div>    
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <td><?=$sub_task_result->subtask_result?>%</td>
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
    <!-- edit of task 1  -->
    <div class="modal fade" id="editTask1Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <form id="task_1_edit_form">
            <input type="hidden" name="master_task_id" value="<?=$cpmsTask->id?>">
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
                    <input type="hidden" name="year" value="<?=$master_task_wise_result->year?>"> 
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background: #000000;color: white;">
                                <th scope="col">TASK-NAME</th>
                                <th scope="col">TASK-VALUE</th>
                                <th scope="col">TASK-NAME</th>
                                <th scope="col">TASK-VALUE</th>
                                <th scope="col">TASK-RESULT(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subtask_wise_result as $sub_task_result):?>                
                                <tr>
                                    <td><?=$this->CpmsModel->getSubtaskNameFromId($sub_task_result->subtask_id)?></td>
                                    <td>
                                        <input type="text" value="<?=$sub_task_result->subtask_id_value?>"
                                        class="form-control" onkeyup="task_1_keyup_edit('<?=$sub_task_result->subtask_id?>','<?=$sub_task_result->related_subtask_id?>')" 
                                        id="task_1_subtask_id_edit<?=$sub_task_result->subtask_id?>" 
                                        name="task_1_subtask_id_edit<?=$sub_task_result->subtask_id?>">                                    
                                    </td>
                                    <td><?=$this->CpmsModel->getSubtaskNameFromId($sub_task_result->related_subtask_id)?></td>
                                    <td>
                                        <input type="text" value="<?=$sub_task_result->related_subtask_id_value?>"
                                        class="form-control" onkeyup="task_1_keyup_edit('<?=$sub_task_result->subtask_id?>','<?=$sub_task_result->related_subtask_id?>')" 
                                        id="task_1_subtask_id_edit<?=$sub_task_result->related_subtask_id?>" 
                                        name="task_1_subtask_id_edit<?=$sub_task_result->related_subtask_id?>">                                    
                                    </td>
                                    <td>
                                        <input type="text" value="<?=$sub_task_result->subtask_result?>" 
                                        readonly class="form-control" id="task_1_edit_result_display_id_<?=$sub_task_result->subtask_id?><?=$sub_task_result->related_subtask_id?>"
                                        name="task_1_edit_result_id_<?=$sub_task_result->subtask_id?><?=$sub_task_result->related_subtask_id?>">
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>    
                    <div class="text-center bg-info text-white p-3">
                        CUMULATIVE MARKS ACHIEVED : 
                        <input type="text" value="<?=$master_task_wise_result->result?>" readonly 
                        class="form-control text-center" id="cumalative_marks_achieved_task_1_edit"
                        name="cumalative_marks_achieved_task_1_edit">
                    </div>        
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12 text-center">
                        <button class="btn btn-success btn-sm" onclick="update_task_1()"
                        style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                SUBMIT
                        </button>
                        <a href="#" data-dismiss="modal"
                            class="btn btn-danger btn-sm text-white" role="button" 
                            style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                                CLOSE
                        </a>
                    </div> 
                </div>
                <!-- validation-errors-div -->
                <div class="col-lg-12" id="task_1_form_validation_error_div_edit" style="display:none;">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong class="text-center" style="color:red !important"
                            id="task_1_form_validation_error_msg_edit">
                        </strong>
                    </div>
                </div>   
                </div>
            </div>
        </form>        
        <script>
            function task_1_keyup_edit(subtask_id, to_be_evalutaed_id){    
                var subtask_val = $('#task_1_subtask_id_edit'+ subtask_id).val();
                var to_be_evaluated_value = $('#task_1_subtask_id_edit'+ to_be_evalutaed_id).val();
                if(to_be_evaluated_value == null || to_be_evaluated_value == ""){
                    return;
                }
                var result = to_be_evaluated_value/subtask_val*100;     
                //*********************testing**************************/
                // alert("Sub task Id is " + subtask_id);
                // alert("to be evaluated value id is " + to_be_evalutaed_id);
                // alert("Sub Task Value Is " + subtask_val);
                // alert("To Be Evaluated Value Is" + to_be_evaluated_value);
                // //alert("Display Input Id Is " + display_input_id);
                // alert("REsult is " + result);
                //*********************testing**************************/                
                $('#task_1_edit_result_display_id_'+subtask_id+to_be_evalutaed_id).val(result);
                var task12result = $('#task_1_edit_result_display_id_12').val();                
                var task34result = $('#task_1_edit_result_display_id_34').val();        
                var task56result = $('#task_1_edit_result_display_id_56').val();        
                if(task12result == null || task12result == ''){
                    $('#cumalative_marks_achieved_task_1_edit').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                    return;
                }
                if(task34result == null || task34result == ''){
                    $('#cumalative_marks_achieved_task_1_edit').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                    return;
                }
                if(task56result == null || task56result == ''){
                    $('#cumalative_marks_achieved_task_1_edit').val("Cumalative Marks Will Be Calculated After Filling All The Values");            
                    return;
                }
                var cumalative_marks_total = parseFloat(task12result)+parseFloat(task34result)+parseFloat(task56result);        
                var cumalative_marks_avg = parseFloat(cumalative_marks_total)/3; 
                if(cumalative_marks_avg >= 90){
                    $('#cumalative_marks_achieved_task_1_edit').val(10);
                    return;
                }else if(cumalative_marks_avg >= 80){
                    $('#cumalative_marks_achieved_task_1_edit').val(8);
                    return;
                }else if(cumalative_marks_avg >= 70){
                    $('#cumalative_marks_achieved_task_1_edit').val(6);
                    return;
                }else if(cumalative_marks_avg >= 60){
                    $('#cumalative_marks_achieved_task_1_edit').val(4);
                    return;
                }else{
                    $('#cumalative_marks_achieved_task_1_edit').val(0);
                    return;
                }
                
            }
            function update_task_1(){
                event.preventDefault();
                $('#task_1_form_validation_error_msg_edit').empty();
                $('#task_1_form_validation_error_div_edit').hide();
                var cpms_task_1_edit_form = $('#task_1_edit_form').serialize();
                $.ajax({
                    url: baseurl + "CPMSController/task_1_update_handle",
                    type: 'POST',
                    data: cpms_task_1_edit_form,
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
                            $('#task_1_form_validation_error_div_edit').show();
                            for (let i = 0; i < data.msg.length; i++) {
                                $('#task_1_form_validation_error_msg_edit').append(data.msg[i]);
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
    </div>
<?php endif ?> 

<style>
    body{
        padding-right: 0 !important;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold">
            <a href="">
                CPMS
            </a>
        </li>
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">CPMS-Form</li>
    </ol>
</nav>
<div class="row" style='margin-top:20px'>               
    <div class="panel col-lg-10" style='padding-right:0px;padding-left:0px;'>
        
    </div>
</div>
<div class="col-lg-10 offset-1 mb-5 shadow-lg">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="card-header h5 bg-info text-white text-center">
                <u>Consultant Performance Monitoring System</u>
        </div>
        <div class="card-header h6 bg-warning text-white text-center">
                <u>Evaluation Form</u> 
        </div>
        <div class="card-header h6 bg-secondary text-white text-center">
            Fields Marks With (*) Are Mandatory 
        </div>
        <!-- Basic Details OF the Consultant -->
        <?php //$this->load->view('pms/consultant_basic_details'); ?>
        <?php
            $count=1;
        ?>
        <?php foreach ($cpmsMaster as $cpmsTask):?>
            <div class="accordion-item">
                <h2 class="accordion-header mb-3" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#task_<?=$cpmsTask->id?>" aria-expanded="false" aria-controls="flush-collapseOne">
                    <span class="badge badge-success" style="margin-right:10px;"><?=$count++?></span>
                    <?=$cpmsTask->category?> : <?=$cpmsTask->name?>
                </button>
                </h2>
                <div id="task_<?=$cpmsTask->id?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#task_<?=$cpmsTask->id?>">                                        
                    <?php if($cpmsTask->id == '1'): ?>
                        <?php include('cpms_tasks/task_1.php');?>
                    <?php elseif($cpmsTask->id == '2'): ?>  
                        <?php include('cpms_tasks/task_2.php');?>
                    <?php elseif($cpmsTask->id == '3'): ?>  
                        <?php include('cpms_tasks/task_3.php');?>
                    <?php elseif($cpmsTask->id == '4'): ?>  
                        <?php include('cpms_tasks/task_4.php');?>
                    <?php elseif($cpmsTask->id == '5'): ?>                          
                        <?php include('cpms_tasks/task_5.php');?>
                    <?php elseif($cpmsTask->id == '6'): ?>                          
                        <?php include('cpms_tasks/task_6.php');?>
                    <?php elseif($cpmsTask->id == '7'): ?>                          
                        <?php include('cpms_tasks/task_7.php');?>
                    <?php elseif($cpmsTask->id == '8'): ?>                          
                        <?php include('cpms_tasks/task_8.php');?>
                    <?php elseif($cpmsTask->id == '9'): ?>                          
                        <?php include('cpms_tasks/task_9.php');?>
                    <?php elseif($cpmsTask->id == '10'): ?>                          
                        <?php include('cpms_tasks/task_10.php');?>
                    <?php endif ?>                                       
                </div>
            </div>
        <?php endforeach;?>
        
        <div class="card text-center mt-3">
            <div class="card-header text-white bg-info">
                FORWARD TO ADC
            </div>
            <?php if($forward_to_adc_flag): ?>
                <div class="card-body">
                    <u><p class="card-text text-danger">NOTE: PLEASE FORWARD THE FORMS TO ADC</p></u>
                    <div class="row mb-3">
                        <div class="col-lg-12 mt-3 text-center">
                            <button class="btn btn-success btn-sm" onclick="forwardToAdc()"
                            style="padding: 5px!important;font-size: 14px;font-weight: bold;">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    FORWARD
                            </button>
                            <a href="<?php echo base_url() . 'index.php/Home/index'?>"
                                class="btn btn-danger btn-sm text-white" role="button" 
                                style="padding: 7px !important;font-size: 14px;font-weight: bold;">
                                <i class="glyphicon glyphicon-remove-sign"></i>
                                    CANCEL
                            </a>
                        </div>                
                    </div>  
                </div>
            <?php else : ?>          
                <div class="row mb-3 mt-3">
                    <u><p class="card-text text-danger font-weight-bold">FORWARD STATUS: <?=$forward_to_adc_flag_message?></p></u>  
                </div>                                  
            <?php endif ?>       
        </div>
    </div>
</div>
<script>
    function forwardToAdc(){
        event.preventDefault();
        $.ajax({
            url: baseurl + "CPMSController/forwardToAdc",
            type: 'POST',
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
                    alert(data.msg);
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








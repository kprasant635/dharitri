<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">

         <?php
            $buttonEnabledFlag =1;
            if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
                include 'application/views/common/input_hidden_fields_and_func.php';
            }
            ?>

    <div class="row">
        <div class="col-lg-12 ">

            <?php if($this->session->flashdata('message')):?>
                <div class="col-lg-12 ">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                    </div>
                </div>
            <?php endif;?>

            <div class="panel panel-info">

                <div class="panel-body">
                    <h3>CO Final order on Misc Cases (Name Cancellation)</h3><br>
                    <form class="form-horizontal" action="<?=base_url().'index.php/NameCancellation/finalOrderCONameCancellation_save'?>" enctype="multipart/form-data" method="POST">
                        <?php if(ESCALATION_ENABLE == 1){ ?>
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                        <?php 
                              include(APPPATH."views/escalation/remaining_time.php");
                            ?>
                        <?php } ?>
						
                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>

                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {?>
                        <!-- property chain hidden fields -->
                        <input type="hidden" name="ulpin" id="ulpin" value="<?= $ulpin ?>" />
                        <?php if (isset($old_ulpin)) { ?>
                            <input type="hidden" name="old_ulpin" id="old_ulpin" value="<?= $old_ulpin ?>" />
                        <?php } ?>

                        <input type="hidden" name="chain_revenue" id="chain_revenue" value="<?= $revenue ?>" />
                        <input type="hidden" name="chain_local_tax" id="chain_local_tax" value="<?= $local_tax ?>" />

                        <!--  -->
                    <?php }?>

                        <?php if(!empty($app->basundhara)){ ?>
                            <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php } ?>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">General Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="10%">Case No:</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=$_GET['misc_case_no']?>
                                                </span>
                                            </td>
                                            <td width="10%">Submission Date:</td>
                                            <td width="20%"><span class="text-danger"><?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                                            </td>       
                                        </tr>
                                        <tr>
                                            <td>District:</td>
                                            <td>
                                                <span class="text-danger"><?=$namedata[0]->district?></span>
                                            </td>
                                            <td>Sub Division:</td>
                                            <td><span class="text-danger"><?=$namedata[1]->subdiv?></span></td>       
                                        </tr>
                                        <tr>
                                            <td>Circle:</td>
                                            <td>
                                                <span class="text-danger"><?=$namedata[2]->circle?></span>
                                            </td>
                                            <td>Mouza:</td>
                                            <td><span class="text-danger"><?=$namedata[3]->mouza?></span></td>       
                                        </tr>
                                        <tr>
                                            <td>Lot:</td>
                                            <td>
                                                <span class="text-danger"><?=$namedata[4]->lot_no?></span>
                                            </td>
                                            <td>Village:</td>
                                            <td><span class="text-danger"><?=$namedata[5]->village?></span></td>       
                                        </tr>
                                        <tr>
                                            <td>Addressing Officer:</td>
                                            <td>
                                                <span class="text-danger"><?=$user_name->username?></span>
                                            </td>
                                            <td>Patta Type:</td>
                                            <td><span class="text-danger"><?=$pattaType->patta_type?></span></td>       
                                        </tr>
                                        <tr>
                                            <td>Order Type:</td>
                                            <td>
                                                <span class="text-danger">Misc Case (Name Cancellation)
                                                    <input type="hidden" name="ord_type_code" value="05">
                                                </span>
                                            </td>
                                            <td>Order Passed By:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$this->lang->line('co')?>
                                                    <input type="hidden" name="ord_passby_desig" value="CO">
                                                </span>
                                            </td>       
                                        </tr>
                                        <tr>
                                            <td>Patta No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=trim($miscCaseInfo->patta_no)?>
                                                </span>
                                            </td>
                                            <td>Dag No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=trim($miscCaseInfo->dag_no)?>
                                                    <input type="hidden" name="dag_no" value="<?=trim($miscCaseInfo->dag_no)?>"/>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">Land Records Assistant Name</td>
                                            <td width="20%">
                                                <span class="text-danger"><?=$lmname->lm_name?>
                                                <input type="hidden" name="lm_code" 
                                                value="<?=$lmname->lm_code?>">
                                                </span>
                                            </td>
                                            <td width="10%">LRA Sign Date</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=date("d-m-Y", strtotime($LmSignDate))?>
                                                    <input type="hidden" name="lm_sign_date"
                                                    value="<?=date("d-m-Y", strtotime($LmSignDate))?>">
                                                </span>
                                            </td>
                                        </tr>
                                        <?php if(isset($es_flag) && $es_flag == 0){ ?>
                                        <tr>
                                            <td width="10%">Land Records Supervisor Name</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <span class="text-danger"><?=$skname->username?>
                                                    <input type="hidden" name="sk_code" 
                                                    value="<?=$skname->user_code?>">
                                                    </span>
                                                </span>
                                            </td>
                                            <td width="10%">LRS Sign Date</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=date("d-m-Y", strtotime($SkSignDate))?>
                                                    <input type="hidden" name="sk_sign_date"
                                                    value="<?=date("d-m-Y", strtotime($SkSignDate))?>"> 
                                                </span>
                                            </td>
                                        </tr>
                                        <?php }else{ ?>
                                            <input type="hidden" name="sk_sign_date"
                                                    value=""> 
                                            <input type="hidden" name="sk_code" 
                                                    value="">
                                        <?php } ?>
                                        
                                    </tbody>
                                </table>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Infavour of Details (Petitioner Information)</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width=20%>Petitioner Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">

                                                    <?=$pet->petition_pdar_name_old?>
                                                </span>
                                            </td>
                                            <td>Aadhaar/Pan Status</td>
                                            <td>
                                                <?php 
                                                if($pet->auth_type == 'AADHAAR'):
                                                    echo $flag = 'AADHAAR Verified <i class="fa fa-check"></i>';
                                                elseif($pet->auth_type='PAN'):
                                                    echo $flag = 'PAN Verified <i class="fa fa-check"></i>';
                                                else:
                                                    echo $flag = 'N/A';
                                                endif;
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div>
                                    <?php include 'application/views/common/aadhar_details_dhar_end_half.php'; ?>
                                </div>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="5">Second Party Information</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th width="5%">Sr No</th>
                                            <th width="15%">Name</th>
                                            <th width="15%">Guardian Name</th>
                                            <th width="15%">Address 1</th>
                                            <th width="15%">Address 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($secondparty as $row): ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$row->pdar_name?></td>
                                                <td><?=$row->pdar_father?></td>
                                                <td><?=$row->pdar_add1?></td>
                                                <td><?=$row->pdar_add2?></td>
                                            </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>
                               
                                

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">CO Remark</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="20%"><span class="text-danger"><?=$this->lang->line('ref_letter_no')?></span></td>
                                            <td colspan="3"><input type="text" class="form-control" name="ord_ref_let_no" placeholder="Enter Reference No"></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-danger">CO Remark<span class="text-danger text-bold">*</span></span></td>
                                            <td colspan="3">
                                                <textarea name="co_report" class="form-control" rows="3" placeholder="&nbsp;&nbsp;CO Remark.........." required="required"></textarea>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- /////////ESCALATION REMARK///////////// -->
                                  <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $miscCaseInfo->es_flag == 1) { ?>
                                    <div class="col-lg-12">
                                        <div class="form-group col-md-4 text-right">
                                            <label> Cause For the case has not been pass in the timeline : </label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                        </div>
                                    </div>
                                  <?php } ?>
                            </div>
                            <?php 
                            include(APPPATH."views/common/addMoreDocumentView.php");
                             ?>
                            <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }
                            ?>
                             <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <center class='text-danger text-bold'><h2>View Supportive Document</h2></center>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sl no.</th>
                                                <th>File Name</th>
                                                <th>Uploaded File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count=1; foreach($sup_doc as $doc) { ?>
                                            <tr>
                                                <td><?=$count++;?></td>
                                                <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                                <td>
                                                    <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/uploadDocuments/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;<hr></div>

                            
                            <div class="col-lg-12">
                                <center>
                                    <input type="hidden" name="misc_case_no" id="misc_case_no" 
                                    value="<?=$_GET['misc_case_no']?>"/>
                                    <input type="hidden" name="misc_case_petition_no" 
                                    id="misc_case_petition_no" value="<?=$_GET['petition_no']?>"/>
                                    <input type="hidden" name="ord_passby_sign_yn" value="Y"> <!--orderpass-->
                                    <input type="hidden" name="lm_sign" value="Y"> <!--lm_sign-->
                                    <input type="hidden" name="sk_sign" value="Y"> <!--sk_sign-->
                                    <input type="hidden" name="co_sign" value="Y"> <!--co_sign-->

                                    <input type="hidden" name="ord_date"
                                    value="<?=$miscCaseInfo->submission_date?>">

                                    <input type="hidden" name="infavor_of_name"
                                    value="<?=$pet->petition_pdar_name_old?>">

                                    <?php if($buttonEnabledFlag==1){?>
                                    <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i>&nbsp;<b>Submit</b></button>
                                    <?php }?>

                                    <?php if(!empty($app->basundhara)){ ?>

                                   <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CANCEL?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>

                                    <?php }

                             else { ?>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CANCEL?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <?php }?>
                                <?php if($es_flag == 0 || $es_flag == null){ ?>
                                    
                                <?php } ?>
                                    
                                    <button type="button" class="btn btn-sm btn-success btnQueryAppl"><i class='fa fa-hand-paper-o'></i>&nbsp;Query to Applicant(s)</button>

                                    <button type="button" class="btn btn-sm btn-warning btnAssistantReport"><i class='fa fa-eye'></i>
                                    &nbsp;<b>Assistant Report</b></button>

                                    <button type="button" class="btn btn-sm btn-info btnLMReport"><i class='fa fa-eye'></i>
                                    &nbsp;<b><?=$this->lang->line('lm_report')?></b></button>
                                    <?php if(isset($es_flag) && $es_flag == 1){ ?>
                                        <button type="button" class="btn btn-sm btn-default btnSKReport"><i class='fa fa-eye'></i>&nbsp;<b><?=$this->lang->line('sk_report')?></b></button>
                                    <?php } ?>

                                    <?php if($es_flag == 1 && ESCALATION_ENABLE == 1){ ?>

                                        <a class="btn btn-warning" href="<?=base_url()."index.php/NameCancellation/RevertLMNameCancellation?case_no=" . $miscCaseInfo->misc_case_no . "&dist_code=" . $miscCaseInfo->dist_code . "&subdiv_code=" . $miscCaseInfo->subdiv_code . "&cir_code=" . $miscCaseInfo->cir_code . "&mouza_pargona_code=" . $miscCaseInfo->mouza_pargona_code . "&lot_no=" . $miscCaseInfo->lot_no . "&vill_townprt_code=" . $miscCaseInfo->vill_townprt_code. "&application_no=". $app->basundhara ?>"><i class='fa fa-backward'></i>&nbsp; Revert to LM</a>

                                   <?php }else{ ?>
                                    <button class="btn revertToLmModal btn-sm btn-success"><i class='fa fa-arrows-alt'></i> Revert to LRA</button>&nbsp;

                                   <?php } ?>

                                


                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal" id="rejApplication_modal" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">
                Reject Reason : <?=$_GET['misc_case_no']?>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/NameCancellation/RejectOrder" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name='application_no' 
                    value="<?=$app->basundhara?>">
                    <input type="hidden" class="form-control" name='misc_case_no' 
                    value="<?=$_GET['misc_case_no']?>">
                    <textarea name='order' class="form-control">Reason of Rejection</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id='rejectSubmit' class="btn reject btn-sm btn-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-default btnCloseRejAppl" id="">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Query Modal -->
<div class="modal" id="query_modal" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">Type Your Query</div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
                <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
                <div class="modal-body">
                    <?php
                        if($this->session->flashdata('query_mdl_message')){
                    ?>
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                                <?= $this->session->flashdata('query_mdl_message'); ?>
                            </strong>
                        </div>
                    <?php
                        }
                    ?>
                    <textarea name='query' class="form-control" placeholder="Please enter your query" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id='querySend' class="btn btn-sm btn-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-default btnMiscQueryAppl" id="">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="revertToLmModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Revert to LM reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/NameCancellation/revertToLm" method="post">
                <div class="modal-body">
                <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
                <input type="hidden" class="form-control" name='misc_case_no' value="<?=$_GET['misc_case_no']?>">
                
                    <textarea name='co_revert_report' class="form-control" placeholder="Reason for revert" required></textarea> 
                    <textarea name="co_report_suffix" class="form-control hide" rows="5"></textarea> 

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assistant Modal -->
<div class="modal" id="assistant_report" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">
                Assistant`s Report : <?=$_GET['misc_case_no']?>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?=$ast_report?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default btnMiscCloseAssistantReport" id="">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- LM Modal -->
<div class="modal" id="lm_report" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">
                LM`s Report : <?=$_GET['misc_case_no']?>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?=$lm_report?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default btnMiscCloseLMReport" id="">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- SK Modal -->
<div class="modal" id="sk_report" role="dialog">
    <div class="modal-dialog" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header text-danger text-bold">
                SK`s Report : <?=$_GET['misc_case_no']?>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?=$sk_report?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default btnMiscCloseSKReport" id="">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#query_modal').modal('show');
    <?php
        }
    ?>

</script>


<script type="text/javascript">

    //for rejection
    $(document).on('click','.btnRejectApplication', function(){
        $('#rejApplication_modal').modal('show');
    });
    $(document).on('click','.btnCloseRejAppl', function(){
        $('#rejApplication_modal').modal('hide');
    });

    //for viewing assistant report
    $(document).on('click','.btnAssistantReport', function(){
        $('#assistant_report').modal('show');        
    });
    $(document).on('click','.btnMiscCloseAssistantReport', function(){
        $('#assistant_report').modal('hide');
    });

    //for viewing LM report
    $(document).on('click','.btnLMReport', function(){
        $('#lm_report').modal('show');
    });
    $(document).on('click','.btnMiscCloseLMReport', function(){
        $('#lm_report').modal('hide');
    });

    //for viewing SK report
    $(document).on('click','.btnSKReport', function(){
        $('#sk_report').modal('show');
    });
    $(document).on('click','.btnMiscCloseSKReport', function(){
        $('#sk_report').modal('hide');
    });

    //for Query
    $(document).on('click','.btnQueryAppl', function(){
        $('#query_modal').modal('show');
    });
    $(document).on('click','.btnMiscQueryAppl', function(){
        $('#query_modal').modal('hide');
    });

</script>
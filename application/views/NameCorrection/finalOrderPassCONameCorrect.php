<style type="text/css">
    input[type=text] {
        border: 1px solid #000;
    }
</style>

<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">

        <?php
        $buttonEnabledFlag =1;
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            include 'application/views/common/input_hidden_fields_and_func.php';
        }
        ?>

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
                    <h3>CO Final order on Misc Cases (Name Correction)</h3><br>
                    <form class="form-horizontal" action="<?=base_url().'index.php/NameCorrection/finalOrderCONameCorrection_save'?>"  enctype="multipart/form-data" method="POST">
                        <?php if(ESCALATION_ENABLE ==1){ ?>
                            <input type="text" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                        <?php } ?>

                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                        {
                            if($propChainEnableFlag)
                            {
                                include 'application/views/common/propertyCheckDetails.php';
                            }

                        }?>

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
                                                <span class="text-danger">Name Correction
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
                                            <td width="10%">Land Records Assistant Sign Date</td>
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
                                            <td width="10%">Land Records Supervisor Sign Date</td>
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
                                        <th style="background-color: #136a6f; color: #fff" colspan="3">Petitioner Information</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if(empty($petitioner) || $petitioner == null){ ?>
                                        <tr>
                                            <td colspan="3" class="text-danger">Name Might be already corrected in chitha. Please verify in chitha</td>
                                        <tr>
                                        <?php }
                                        foreach ($petitioner as $pet) { ?>
                                        <tr>
                                            <td width=20%>Existing Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?=$pet->petition_pdar_name_old?>
                                                </span>
                                                <input type="hidden" value="<?=$pet->petition_pdar_name_old?>" 
                                                name="infavor_of_old_name">
                                            </td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <td width=20%>Corrected Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?=$pet->petition_pdar_name_new?>
                                                </span>
                                                <input type="hidden" class="form-control" 
                                                name="infavor_of_corrected_name" 
                                                value="<?=$pet->petition_pdar_name_new?>">
                                            </td>
                                            <td><b><?php if(isset($pet->auth_type) && $pet->auth_type == 'AADHAAR'){
                                                    echo $flag = 'AADHAAR Verified';
                                                }else if(isset($pet->auth_type) && $pet->auth_type == 'PAN'){
                                                    echo $flag = 'PAN Verified';
                                                }else{
                                                    echo $flag = null;
                                                } ?></b></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div>
                                    <?php include 'application/views/common/aadhar_details_dhar_end_half.php'; ?>
                                </div>

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
                                                <textarea style="border: 1px solid #000" name="co_report" class="form-control" rows="3" placeholder="&nbsp;&nbsp;CO Remark.........." required="required"></textarea>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Reference of court Order No</th>
                                    </thead>
                                    <tbody>
                                        <tr class="text-danger">
                                            <td>WRT Order 1:</td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                name="wrt1" placeholder="Order 1">
                                            </td>
                                            <td>WRT Order 2:</td>
                                            <td>
                                                <input type="text" class="form-control"
                                                name="wrt2" placeholder="Order 2">
                                            </td>
                                        </tr>
                                        <tr class="text-danger">
                                            <td>WRT Order 3:</td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                name="wrt3" placeholder="Order 3">
                                            </td>
                                            <td>WRT Order 4:</td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                name="wrt4"  placeholder="Order 4">
                                            </td>
                                        </tr>
                                        <tr class="text-danger">
                                            <td>Infavor of Guardian Name:</td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                name="infavor_of_guardian" readonly="readonly"
                                                value="<?=isset($pdarinfo->pdar_father) ? $pdarinfo->pdar_father : '' ?>">
                                            </td>
                                            <td>Address 1:</td>
                                            <td>
                                                <input type="text" class="form-control" name="infavor_of_add1" value="<?php isset($pdarinfo->pdar_add1) ? $pdarinfo->pdar_add1 : ''?>">
                                            </td>
                                        </tr>

                                        <tr class="text-danger">
                                            <td>Address 2:</td>
                                            <td>
                                                <input type="text" class="form-control" name="infavor_of_add2" value="<?= isset($pdarinfo->pdar_add2) ? $pdarinfo->pdar_add2 : '' ?>">
                                            </td>
                                            <td></td><td></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="container-fluid">
                                <?php 
                                include(APPPATH."views/common/addMoreDocumentView.php");
                                ?>
                            </div>


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
                            <?php if($query){
                              echo "<center class='uni_text text-danger'>All Query</center>";
                              echo "<table class='table'>";
                              echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                              foreach($query as $q){
                                ?>
                                  <tr>
                                    <td><?=$q->date_of_query?></td>
                                    <td><?=$q->query_text?></td>
                                    <td><?=$q->date_of_reply?></td>
                                    <td><?=$q->reply_text;
                                    if($q->app_doc_id){ 
                                    $var=base_url().'index.php/rtps/document/'.$q->app_doc_id;
                                    echo "<br>";
                                    echo "<a target='download' href='$var'><i class='fa fa-paperclip'></i> Download </a> " ;
                                  }
                                    ?></td>
                                  </tr>
                                
                            <?php } echo "</table>"; } ?>
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

                                    <input type="hidden" class="form-control" 
                                    name="infav_of_guar_relation" 
                                    value="<?=isset($pdarinfo->pdar_guard_reln) ? $pdarinfo->pdar_guard_reln : '' ?>">

                                    <input type="hidden" class="form-control" 
                                    name="infavor_of_name" value="<?=isset($pdarinfo->pdar_name) ? $pdarinfo->pdar_name : '' ?>">

                                    <?php if($buttonEnabledFlag==1){?>

                                    <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i>&nbsp;<b>Submit</b></button>
                                    <?php }?>

                                    <!-- <button type="button" class="btn btn-sm btn-danger btnRejectApplication"><i class='fa fa-arrows-alt'></i>&nbsp;Reject Application</button> -->

                                    <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CORRECT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>

                                    <?php if($basundharaAttachment){ ?>
                                        <button type="button" class="btn btn-sm btn-success btnQueryAppl"><i class='fa fa-hand-paper-o'></i>&nbsp;Query to Applicant(s)</button>
                                    <?php } ?>
                                    
                                    

                                    <button type="button" class="btn btn-sm btn-info btnLMReport" id="<?=$_GET['misc_case_no']?>, <?=$_GET['petition_no']?>">
                                    <i class='fa fa-eye'></i>&nbsp;
                                    <b><?=$this->lang->line('lm_report')?></b></button>

                                    

                                    

                                    <?php if(isset($es_flag) && $es_flag == 0){ ?>
                                        <button type="button" class="btn btn-sm btn-default btnSKReport" id="<?=$_GET['misc_case_no']?>, <?=$_GET['petition_no']?>">
                                        <i class='fa fa-eye'></i>&nbsp;
                                        <b><?=$this->lang->line('sk_report')?></b></button>
                                    <?php } ?>

                                    <?php if($es_flag == 1 && ESCALATION_ENABLE == 1){ ?>

                                        <a class="btn btn-warning" href="<?=base_url()."index.php/NameCorrection/RevertLMNameCancellation?case_no=" . $miscCaseInfo->misc_case_no . "&dist_code=" . $miscCaseInfo->dist_code . "&subdiv_code=" . $miscCaseInfo->subdiv_code . "&cir_code=" . $miscCaseInfo->cir_code . "&mouza_pargona_code=" . $miscCaseInfo->mouza_pargona_code . "&lot_no=" . $miscCaseInfo->lot_no . "&vill_townprt_code=" . $miscCaseInfo->vill_townprt_code. "&application_no=". $app->basundhara ?>"><i class='fa fa-backward'></i>&nbsp; Revert to LM</a>

                                   <?php }else{ ?>
                                    <button type="button" class="btn revertToLmModal btn-sm btn-warning">
                                        <i class='fa fa-backward'></i>&nbsp;<b>Revert to LM</b>
                                    </button>
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

<div id="revertToLmModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Revert to LM reason</h5>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/NameCorrection/revertToLm" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name='application_no' 
                    value="<?=$app->basundhara?>">
                    <input type="hidden" class="form-control" name='misc_case_no' 
                    value="<?=$_GET['misc_case_no']?>">
                    <textarea name='co_revert_report' class="form-control" placeholder="Reason for revert" required></textarea> 
                    <textarea name="co_report_suffix" class="form-control hide" 
                    rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-default btnRevertClose" id="">Close</button>
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
                    <textarea name='query' class="form-control" placeholder="Please enter your query"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id='querySend' class="btn btn-sm btn-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-default btnMiscQueryAppl" id="">Close</button>
                </div>
            </form>
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
                        <div id="lm_name_corr_report"></div>
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
                        <div id="sk_name_corr_report"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default btnMiscCloseSKReport" id="">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#query_modal').modal('show');
    <?php
        }
    ?>

    // //for rejection
    // $(document).on('click','.btnRejectApplication', function(){
    //     $('#rejApplication_modal').modal('show');
    // });
    // $(document).on('click','.btnCloseRejAppl', function(){
    //     $('#rejApplication_modal').modal('hide');
    // });

    //for viewing LM report
    $(document).on('click','.btnLMReport', function(){
        id = $(this).attr('id');
        val = id.split(",");
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $('#lm_report').modal('show');
        $.ajax({
            url: baseurl + "NameCorrection/lmNameCorrectionReport",
            type:'POST',
            data:{case_no:val[0], petition_no: val[1]},
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                $('#lm_name_corr_report').html('');                
                if(data.success == 'true'){
                    $('#lm_name_corr_report').html(data.details);
                }
            }
        });
    });
    $(document).on('click','.btnMiscCloseLMReport', function(){
        $.unblockUI();
        $('#lm_report').modal('hide');
    });

    //for viewing SK report
    $(document).on('click','.btnSKReport', function(){
        id = $(this).attr('id');
        val = id.split(",");
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $('#sk_report').modal('show');
        $.ajax({
            url: baseurl + "NameCorrection/skNameCorrectionReport",
            type:'POST',
            data:{case_no:val[0], petition_no: val[1]},
            dataType:'json',
            success: function (data) {
                $.unblockUI();
                $('#sk_name_corr_report').html('');                
                if(data.success == 'true'){
                    $('#sk_name_corr_report').html(data.details);
                }
            }
        });
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

    $(document).on('click','.btnRevertClose', function(){
        $('#revertToLmModal').modal('hide');
    });
</script>
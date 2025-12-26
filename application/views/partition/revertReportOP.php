    <div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
    <div class="container-fluid form-top login">
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

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="well well-sm">
                        <h2 style="text-align: center; color: red">Office Partition Revert Report</h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-info">
                        
                        <div class="panel-body">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type='hidden' id='case_no' value='<?=$petition_basic->case_no ?>'>
                                <table class='table table-bordered text-danger text-bold'>
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">General Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span>Case No.
                                                : <?=$petition_basic->case_no ?></span>
                                            </td>
                                            <td><span>Transfer Type
                                                : <?= $this->utilityclass->getTransferType($petition_basic->trans_code) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>জিলা (District)
                                                : <?= $this->utilityclass->getDistrictName($petition_basic->dist_code) ?></span>
                                            </td>
                                            <td><span>মহকুমা (Sub Division)
                                                : <?= $this->utilityclass->getSubDivName($petition_basic->dist_code, $petition_basic->subdiv_code) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>চক্র (Circle) :
                                                <?= $this->utilityclass->getCircleName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code) ?></span>
                                            </td>
                                            <td><span>মৌজা (Mouza)
                                                : <?= $this->utilityclass->getMouzaName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>লাট (Lot)
                                                : <?= $this->utilityclass->getLotName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no) ?></span>
                                            </td>
                                            <td>
                                                <span>গাওঁ / চহৰ (Village) :
                                                <?= $this->utilityclass->getVillageName($petition_basic->dist_code, $petition_basic->subdiv_code, $petition_basic->cir_code, $petition_basic->mouza_pargona_code, $petition_basic->lot_no, $petition_basic->vill_townprt_code) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span>Patta No : <?= $dag->patta_no ?></span></td>
                                            <td><span>Dag No : <?= $dag->dag_no ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div> -->

                            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                                <table class='table table-bordered'>
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">First Party Information&nbsp;
                                        <button class="btn btn-sm btn-warning pull-right btnAddParty">Add Additional Party&nbsp;<i class="fa fa-plus-square"></i></button>
                                        </th>

                                    </thead>
                                    <thead>
                                        <tr class="text-bold table-success">
                                            <th width="5%">#</th>
                                            <th width="12%"><?=$this->lang->line('applicants_name')?></th>
                                            <th width="12%"><?=$this->lang->line('guardian_name')?></th>
                                            <th width="20%">Address</th>
                                            <th width="10%">Contact No</th>
                                            <th class="th_del" width="10%">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="office_partition_first_party">
                                        <?php $i=1; foreach($first_party as $appl):?>
                                        <tr id="<?=$appl->pdar_id?>" class="remove_<?=$appl->pdar_id?>">
                                            <td><?=$i?></td>
                                            <td><?=$appl->pdar_name?></td>
                                            <td><?=$appl->pdar_guardian?></td>
                                            <td><?=$appl->pdar_add1?></td>
                                            <th><?=(($appl->pdar_mobile=='')?'-':$appl->pdar_mobile)?></th>
                                            <td>
                                                <?php if($appl->pdar_mobile=='') { ?>
                                                    <button type="button" class="btn btn-sm btn-danger btnDelOfcPart" id="<?=$appl->pdar_id?>" title="Click to Delete <?=$appl->pdar_name?>"><i class="fa fa-trash"></i></button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach; ?>                             
                                    </tbody>
                                </table>
                            </div>

                            
                            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="6">Modify Mutated Land Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th></th>
                                            <th>B (বি :)</th>
                                            <th>K (ক :)</th>
                                            <th>L (লে :)</th>
                                            <th>G (গ :)</th>
                                            <th>Kr (ক্ৰা :)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?=$this->lang->line('total_land_area')?></td>
                                            <td>
                                                <span class="text-bold"><?=$dag->dag_area_b?></span>
                                                <input type='hidden' id="b_op" 
                                                value="<?=$dag->dag_area_b?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->dag_area_k?></span>
                                                <input type='hidden' maxlength="2" id="k_op"
                                                value="<?=$dag->dag_area_k?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->dag_area_lc?></span>
                                                <input type='hidden' maxlength="5" id="lc_op" 
                                                value="<?=$dag->dag_area_lc?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->dag_area_g?></span>
                                                <input type='hidden' maxlength="2" id="g_op" 
                                                value="<?=$dag->dag_area_g?>"/>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->dag_area_kr?></span>
                                                <input type='hidden' maxlength="2" id="kr_op"
                                                value="<?=$dag->dag_area_kr?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-red text-bold"><?=$this->lang->line('mutated_land_area')?></td>
                                            <td>
                                                <input type='number' maxlength="6" name="mut_b_op" id="mut_b_op" value="<?=$dag->m_dag_area_b?>" />
                                                <div id="err_lm_report_mut_b_op"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_k_op" id="mut_k_op" value="<?=$dag->m_dag_area_k?>"/>
                                                <div id="err_lm_report_mut_k_op"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="5" name="mut_lc_op" id="mut_lc_op" value="<?=$dag->m_dag_area_lc?>" />
                                                <div id="err_lm_report_mut_lc_op"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_g_op" id="mut_g_op" value="<?=$dag->m_dag_area_g?>" />
                                                <div id="err_lm_report_mut_g_op"></div>
                                            </td>
                                            <td>
                                                <input type='number' maxlength="2" name="mut_kr_op" id="mut_kr_op" value="0" readonly />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="form-group" style="padding-left:10px;">
                            <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                            ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                            <?php endforeach; } ?>   
                            </div>
                    



                    
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-12 text-bold text-red" id="alert_message"></div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <label><u>Upload Supportive Document</u></label>
                        &nbsp;
    <i class="fa fa-info-circle text-red" 
    title="1. Uploaded file types should be &nbsp;&nbsp;&nbsp;jpeg | jpg | png | pdf only.
    2. Uploaded file size should not be more than 2MB"></i>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                                <table class="table table-striped table-bordered">
                                    <tbody id='certi_tab'>
                                        
                                        <tr>
                                            <td width="20%"><span class="text-bold"><?=JAMABANDI?></span>
                                            </td>
                                            <td width="20%"><input type='file' name="jama_cer" id="jama_cer"></td>
                                            <td width="20%">
                                                <button type="button" class="btn btn-sm btn-warning uploadOfcPart" id='4'>Upload Jamabandi&nbsp;<i class='fa fa-upload'></i></button>
                                            </td>
                                            <td width="20%">
                                                <?php if(!empty($jama_id)) { if($jama_id->id!='' || $jama_id->id!=null) { ?>
                                                <div id="div_jama">
                                                    <button class="btn btn-sm btn-info"><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$jama_id->id?>" target="_blank" title="View Jamabandi"><i class="fa fa-plus-square"></i></a></button>&nbsp;&nbsp;
                                                    <button type="button" class="btn btn-sm btn-danger removeOfcPartDoc" id='4' title="Remove Jamabandi"><i class='fa fa-minus-square'></i></button>
                                                </div>
                                                <?php }} ?>
                                                <div id="file_4"></div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <form id="revert_Report_LM_OPart" method="post">
                                <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <label for="inputEmail3"
                                    class="uni_text control-label required">Type Note</label>
                                    <textarea class="form-control" rows="5" name='note_order' id="note_order" placeholder="Please Type Your Report"></textarea>
                                    <div id="err_lm_report_note_order"></div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                                <center>
                                    <!-- <input type="hidden" value="" id="del_OPart" name="del_OPart"> -->
                                    <input type='hidden' name='case_no' value='<?=$petition_basic->case_no ?>'>
                                    <input type='hidden' name='dist_code' value='<?=$petition_basic->dist_code ?>'>
                                    <input type='hidden' name='subdiv_code' value='<?=$petition_basic->subdiv_code ?>'>
                                    <input type='hidden' name='cir_code' value='<?=$petition_basic->cir_code ?>'>
                                    <input type='hidden' name='mouza_pargona_code' value='<?=$petition_basic->mouza_pargona_code ?>'>
                                    <input type='hidden' name='lot_no' value='<?=$petition_basic->lot_no ?>'>
                                    <input type='hidden' name='petition_no' value='<?=$petition_basic->petition_no ?>'>
                                    <input type='hidden' name='dag_no' value='<?= $dag->dag_no ?>'>
                                    <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!---// Add pattadar --->
    <div class="modal" id="editPattadar" role="dialog">
        <div class="modal-dialog" style="max-width: 70%;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-red text-bold">
                            Additional First Party Adding Form
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><hr></div>

                        <form id="add_additional_pattadar" method="post">
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Select Applicant</span>
                                <select class="form-control" name="add_pattadar" id='add_pattadar'>
                                    <option value="">Select Applicant</option>
                                    <?php foreach($pattadar_list as $row):?>
                                        <option value="<?=$row->pdar_id?>"><?=$row->pdar_name?></option>
                                    <?php endforeach;?>
                                </select>
                                <div id="error_patta_add_pattadar"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Applicant Name</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" class="form-control" name="appl_name" id="appl_name" value="" readonly>
                                <div id="error_patta_appl_name"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Guardian Name</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" class="form-control" name="guardian_name" id="guardian_name" value="" readonly>
                                <div id="error_patta_guardian_name"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Relation</span>
                                <span class="text-red text-bold">*</span>
                                <select class="form-control" name="relation" id='relation'>
                                    <option value="">Select Relation</option>
                                    <?php foreach($relation as $rel):?>
                                        <option value="<?=$rel->guard_rel?>"><?=$rel->guard_rel_desc_as?></option>
                                    <?php endforeach;?>
                                </select>
                                <div id="error_patta_relation"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">Gender</span>
                                <span class="text-red text-bold">*</span>
                                <select class="form-control" name="gender" id='gender'>
                                    <option value="">Select Gender</option>
                                    <?php foreach($gender as $r):?>
                                        <option value="<?=$r->short_name?>"><?=$r->gen_name_ass?></option>
                                    <?php endforeach;?>
                                </select>
                                <div id="error_patta_gender"></div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                                <span class="text-bold">DOB</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" class="form-control dating" name="dob" id="dob" value="" readonly>
                                <div id="error_patta_dob"></div>
                            </div>
                            <style type="text/css">
                                .datepick-popup{
                                    position: fixed;
                                    left:0 px;
                                    right:0 px;
                                    z-index:10000;
                                }
                            </style>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <span class="text-bold">Address</span>
                                <span class="text-red text-bold">*</span>
                                <input type="text" name="address" id="address" value="" class="form-control">
                                <div id="error_patta_address"></div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 pull-right">
                                <button type="submit" id="btnAdd" class="btn btn-sm btn-primary">Add First Party</button>
                                <button type="button" class="btn btn-sm btn-default btnClose" id="">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---// Add pattadar --->


    <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
    <script>

    // $(document).on('click', '.btnDelOfcPart', function(){
    //     if(confirm("Are you sure to delete this applicant ? Once deleted, it cannot be undone...")){

    //         $.blockUI({
    //                 message: $('#displayBox'),
    //                 css: {
    //                     border:'none',
    //                     backgroundColor:'transparent'
    //             }
    //         });

    //         id = $(this).attr('id');
    //         length = ($('#office_partition_first_party tr').length);        
    //         if(length == 1){
    //             alert("All petitioners can not be deleted");
    //             return false;
    //         }
    //         else
    //         {
    //             $.unblockUI();
    //             remove = $('.remove_'+id).remove();
    //             if($('#del_OPart').val()==''){
    //                 $('#del_OPart').val(id);
    //             }
    //             else {
    //                 $('#del_OPart').val($('#del_OPart').val()+', '+id);   
    //             }
    //         }    
    //     }        
    // });

    $('#jama_cer').change(function(){
        alert("Click on Upload Button to upload your document..");
        $('.uploadOfcPart').focus();    
    });

    $('.uploadOfcPart').click(function(){
        flag = $(this).attr('id');
        var formdata = new FormData();
        if(flag == 4){
            formdata.append("jama_cer", $('#jama_cer')[0].files[0]);
        }
        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        formdata.append("mut_type", '02');
        $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl + "uploadDocuments/uploadSupportiveDocs/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                $.unblockUI();            
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                    $('#div_jama').html('');
                }

                if(data.flag_set == '4'){
                    $('#file_4').html('<button class="btn btn-sm btn-info"><a href="'+baseurl+'uploadDocuments/downloadDocuments/'+data.doc_id+'" target="_blank" title="View Jamabandi"><i class="fa fa-plus-square"></i></a></button>'+'  '+'<button type="button" class="btn btn-sm btn-danger removeOfcPartDoc" id="4" title="Remove Jamabandi"><i class="fa fa-minus-square"></i></button>');
                }
                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);
                    return false;
                }
            },
            error:function(data){
                if(data.status == 403){
                    $('#alert_message').html(`<div class="bg-gradient-danger p-2 rounded">${ data.responseJSON.errors }<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>`);
                }
                else
                {
                    alert("Something went wrong");
                }
                $.unblockUI();
            }
        });
    });

    $(document).on('click','.removeOfcPartDoc', function(){
        flag = $(this).attr('id');
        case_no = $('#case_no').val();
        data = {flag:flag, case_no:case_no}

        $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
            }
        });
        if(confirm("Are you sure to delete Jamabandi Certificate ?")){
            $.ajax({
                url: baseurl + "uploadDocuments/removeSupportiveDocs/",
                type: 'POST',
                data: data,
                dataType: "json",

                success: function (data) 
                {
                    $.unblockUI();

                    console.log(data);
                    if(data.flag == '4'){
                        $('#file_4').html('');
                        $('#div_jama').html('');
                    }
                },
                error:function(data){
                    alert("Something went wrong");
                    $.unblockUI();
                }
            });
        }  
    });

    $(document).on('click','.btnAddParty', function(){
        $('#editPattadar').modal('show');
    });
    $(document).on('click','.btnClose', function(){
        $('#editPattadar').modal('hide');
    });

    $('#add_pattadar').change(function(){
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        case_no = $('#case_no').val();
        id = $('#add_pattadar').val();
        $.ajax({
            url: baseurl + "partition/getPattadarDetail",
            type: 'POST',
            data: {case_no:case_no, id:id},
            dataType: "json",
            success: function (data) 
            {
                $.unblockUI();
                if(data.details){
                    $('#appl_name').val(data.details.pdar_name);
                    $('#guardian_name').val(data.details.pdar_father);
                    $('#relation').val('');
                    $('#gender').val(data.details.pdar_gender);
                    $('#dob').val(data.details.pdar_minor_dob);
                    $('#address').val(data.details.pdar_add1);
                }
            },
            error:function(data){
                alert("Something went wrong");
                $.unblockUI();
            }
        });
    });

    $('#revert_Report_LM_OPart').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: baseurl + "partition/revertReportOPartSubmit",
            type: 'POST',
            data: $("#revert_Report_LM_OPart").serialize()+
                    "&mut_b_op="+$('#mut_b_op').val()+
                    "&mut_k_op="+$('#mut_k_op').val()+
                    "&mut_lc_op="+$('#mut_lc_op').val()+
                    "&mut_g_op="+$('#mut_g_op').val()+
                    "&mut_kr_op="+$('#mut_kr_op').val(),
            dataType: "json",
            success: function (data) 
            {
                console.log(data.final);
                if(data.error){
                    $.each(data.error, function (index, value) {
                        $('#err_lm_report_'+value['field']).fadeIn();
                        $('#err_lm_report_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#err_lm_report_'+value['field']).fadeOut();
                        }, 5000);
                    });    
                }
                if(data.final == "true"){
                    alert("Case has successfully forwarded to CO");
                    window.location.href = baseurl + "partition/getRevertedOfcPartitionCases";
                }
            },
            error:function(data){
                alert("Something went wrong");
            }
        });
    });


    $('#add_additional_pattadar').submit(function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "partition/addAdditionalFirstParty",
            type: 'POST',
            data: $("#add_additional_pattadar").serialize()+
                    "&case_no="+$('#case_no').val(),
            dataType: "json",
            success: function (data) 
            {
                $.unblockUI();
                console.log(data.details);
                if(data.error){
                    $.each(data.error, function (index, value) {
                        $('#error_patta_'+value['field']).fadeIn();
                        $('#error_patta_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#error_patta_'+value['field']).fadeOut();
                        }, 5000);
                    });    
                }
                if(data.details)
                {
                    alert("Applicant detail has successfully updated");
                    $('#editPattadar').modal('hide');
                    var table = '';
                    $.each(data.details, function (i, val) { 
                        sr_no = i++;

                        delbtn = ((val['pdar_mobile']=='' || val['pdar_mobile']==null)?'<button type="button" class="btn btn-sm btn-danger btnDelOfcPart" id="'+val['pdar_id']+'" title="Click to Delete '+val['pdar_name']+'"><i class="fa fa-trash"></i></button>':'');

                        table +=                     
                            '<tr id="'+val['pdar_id']+'" class="remove_'+val['pdar_id']+'">'+
                                '<td>' + (sr_no+1) + '</td>' +
                                '<td>' + val["pdar_name"] + '</td>' +
                                '<td>' + val["pdar_guardian"] + '</td>' +
                                '<td>' + ((val["pdar_add1"]==null || val["pdar_add1"]=='')?'-':val["pdar_add1"]) + '</td>' +
                                '<td>' + ((val['pdar_mobile']==null || val['pdar_mobile']=='')?'-':val['pdar_mobile']) + '</td>' +
                                '<td>' + delbtn + '</td>' +
                            '</tr>'
                    });
                    $('#office_partition_first_party').html(table);
                    $('#add_additional_pattadar').trigger('reset');

                    var templates = "<option value=''>Select Applicant</option>";
                    $.each(data.pattadar_list, function (index, value) {
                        templates += '<option value = ' +
                        value["pdar_id"] +' >' + value["pdar_name"] + ' </option>'
                    });
                    $('#add_pattadar').html(templates);
                }
            },
                error:function(data){
                    alert("Something went wrong");
                    $.unblockUI();
                }
        });
    });

    function landCalc() 
    {
        var bigha = $('#b_op').val();
        var katha = $('#k_op').val();
        var lessa = $('#lc_op').val();  
        var ganda = $('#g_op').val();
        var krantik = $('#kr_op').val();
        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
        console.log(window.sourcelessa);

        var mbigha = $('#mut_b_op').val();
        var mkatha = $('#mut_k_op').val();
        var mlessa = $('#mut_lc_op').val();
        var mg = $('#mut_g_op').val();
        var mk = $('#mut_kr_op').val();
        window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        
        if (window.sourcelessa < window.targetlessa) {
            alert('Mutated Land Area should be less than the area available in Chitha..');

            $('#mut_b_op').val(0);
            $('#mut_k_op').val(0);
            $('#mut_lc_op').val(0);
            $('#mut_g_op').val(0);
            $('#mut_kr_op').val(0);
        }

        if(parseInt(mkatha) >= 5)
        {
            bigha_cal = Math.floor((mkatha*20)/100);
            bigha_value = (mkatha*20)/100;
            bigha1 = bigha_value.toFixed(2);

            decimalbigha = bigha1 - Math.floor(bigha1);
            kathareminder = decimalbigha.toFixed(2);

            katha_cal = (kathareminder*100)/20;

            $('#mut_b_op').val(bigha_cal);
            $('#mut_k_op').val(katha_cal);
            $('#mut_lc_op').val(0);
            $('#mut_g_op').val(0);
            $('#mut_kr_op').val(0);
        }

        //lessa katha calculation
        if(parseInt(mlessa) >= 20)
        {   
            katha_cal = Math.floor((mlessa)/20);
            katha_value = (mlessa)/20;
            katha1 = katha_value.toFixed(2);

            decimalkatha = katha1 - Math.floor(katha1);
            lessa_cal = decimalkatha.toFixed(2);

            $('#mut_b_op').val(0);
            $('#mut_k_op').val(katha_cal);
            $('#mut_lc_op').val(lessa_cal);
            $('#mut_g_op').val(0);
            $('#mut_kr_op').val(0);
         }

        //lessa bigha calculation
        if(parseInt(mlessa) >= 100)
        {   
            bigha_cal = Math.floor((mlessa)/100);
            bigha_value = (mlessa)/100;
            bigha1 = bigha_value.toFixed(2);

            decimalbigha = bigha1 - Math.floor(bigha1);
            kathareminder = decimalbigha.toFixed(2);

            katha_cal = Math.floor((kathareminder*20)/100);
            katha_value = (kathareminder*20)/100;
            katha1 = katha_value.toFixed(2);

            decimalkatha = katha1 - Math.floor(katha1);
            lessa_cal = decimalkatha.toFixed(2);

            $('#mut_b_op').val(bigha_cal);
            $('#mut_k_op').val(katha_cal);
            $('#mut_lc_op').val(lessa_cal);
            $('#mut_g_op').val(0);
            $('#mut_kr_op').val(0);
        }
    }

    $('#mut_b_op').change(function(){
        landCalc();
    });

    $('#mut_k_op').change(function(){
        var mbigha = $('#mut_b_op').val();
        var mkatha = $('#mut_k_op').val();
        var mlessa = $('#mut_lc_op').val();

        landCalc();
        
        if(parseInt(mkatha) >= 5)
        {
            bigha_cal = Math.floor((mkatha*20)/100);
            bigha_value = (mkatha*20)/100;
            bigha1 = bigha_value.toFixed(2);

            decimalbigha = bigha1 - Math.floor(bigha1);
            kathareminder = decimalbigha.toFixed(2);

            katha_cal = (kathareminder*100)/20;

            $('#mut_b_op').val(bigha_cal);
            $('#mut_k_op').val(katha_cal);
            $('#mut_lc_op').val(0);
        }
    });

    $('#mut_lc_op').change(function(){
        var mbigha = $('#mut_b_op').val();
        var mkatha = $('#mut_k_op').val();
        var mlessa = $('#mut_lc_op').val();
        landCalc();
        //lessa katha calculation
        if(parseInt(mlessa) >= 20)
        {   
            katha_cal = Math.floor((mlessa)/20);
            katha_value = (mlessa)/20;
            katha1 = katha_value.toFixed(2);

            decimalkatha = katha1 - Math.floor(katha1);
            lessa_cal = decimalkatha.toFixed(2);

            $('#mut_b_op').val(0);
            $('#mut_k_op').val(katha_cal);
            $('#mut_lc_op').val(lessa_cal);
        }

        //lessa bigha calculation
        if(parseInt(mlessa) >= 100)
        {   
            bigha_cal = Math.floor((mlessa)/100);
            bigha_value = (mlessa)/100;
            bigha1 = bigha_value.toFixed(2);

            decimalbigha = bigha1 - Math.floor(bigha1);
            kathareminder = decimalbigha.toFixed(2);

            katha_cal = Math.floor((kathareminder*20)/100);
            katha_value = (kathareminder*20)/100;
            katha1 = katha_value.toFixed(2);

            decimalkatha = katha1 - Math.floor(katha1);
            lessa_cal = decimalkatha.toFixed(2);

            $('#mut_b_op').val(bigha_cal);
            $('#mut_k_op').val(katha_cal);
            $('#mut_lc_op').val(lessa_cal);
        }    
    });
    //////////////////////
    $(document).on('click', '.btnDelOfcPart', function(){
        id = $(this).attr('id');
        case_no = $('#case_no').val();        
        data = {id:id, case_no:case_no}

        if(confirm("Are you sure to delete first party ? Once deleted, it cannot be undone..")){

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: baseurl + "partition/deleteFirstPartyFPART/",
                type:'POST',
                data:data,
                dataType:'json',
                success: function (data) {
                    $.unblockUI();
                    console.log(data);
                    if(data.audit){
                        alert(data.audit);
                        return;
                    }
                    if(data.delete === false){
                        alert("All applicants cannot be deleted");
                        return;
                    }
                    if(data.details)
                    {
                        alert("Successfully Deleted");
                        var table = '';
                        $.each(data.details, function (i, val) { 
                            sr_no = i++;
                            delbtn = ((val['pdar_mobile']=='' || val['pdar_mobile']==null)?'<button type="button" class="btn btn-sm btn-danger btnDelOfcPart" id="'+val['pdar_id']+'" title="Click to Delete '+val['pdar_name']+'"><i class="fa fa-trash"></i></button>':'');

                            table +=                     
                                '<tr id="'+val['pdar_id']+'" class="remove_'+val['pdar_id']+'">'+
                                    '<td>' + (sr_no+1) + '</td>' +
                                    '<td>' + val["pdar_name"] + '</td>' +
                                    '<td>' + val["pdar_guardian"] + '</td>' +
                                    '<td>' + ((val["pdar_add1"]==null || val["pdar_add1"]=='')?'-':val["pdar_add1"]) + '</td>' +
                                    '<td>' + ((val['pdar_mobile']==null || val['pdar_mobile']=='')?'-':val['pdar_mobile']) + '</td>' +
                                    '<td>' + delbtn + '</td>' +
                                '</tr>'
                        });
                        $('#office_partition_first_party').html(table);
                        $('#add_additional_pattadar').trigger('reset');

                        var templates = "<option value=''>Select Applicant</option>";
                        $.each(data.pattadar_list, function (index, value) {
                            templates += '<option value = ' +
                            value["pdar_id"] +' >' + value["pdar_name"] + ' </option>'
                        });
                        $('#add_pattadar').html(templates);
                    }

                },
                error:function(data){
                    alert("Something went wrong");
                    $.unblockUI();
                    }
            });
        } 
        else {
            return false;
        } 
    });

    </script>
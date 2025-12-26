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

                    <?php 
                        $var = $field_mut_basic->case_no; 
                        $type = explode('/', $var); 
                        $type = $type['4'];
                        if($type=='FMUT'){ $type = 'Mutation'; }else{ $type = 'Partition'; }
                    ?>



                    <div class="col-lg-12">
                        <div class="well well-sm">
                            <h2 style="text-align: center; color: red">Field <?=$type?> Revert Report (RTPS)</h2>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span style="color:#3c8198; font-size: 18px" class="bold"><?php echo $this->lang->line('general_information'); ?>
                                </span>
                                <input type='hidden' id='case_no' value='<?=$field_mut_basic->case_no ?>'>
                                <table class='table table-bordered unicode'>
                                    <tr>
                                        <td width="35%"><label
                                            class="text-danger">Case No.
                                            : &nbsp;&nbsp;&nbsp;<?= $field_mut_basic->case_no ?></label>
                                        </td>
                                        <td width="30%"><label
                                            class="text-danger">Transfer Type
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getTransferType($field_mut_basic->trans_code) ?></label>
                                        </td>
                                        <td width="35%"><label
                                            class="text-danger">জিলা (District)
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getDistrictName($field_mut_basic->dist_code) ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label
                                            class="text-danger">মহকুমা (Sub Division)
                                            :
                                            &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getSubDivName($field_mut_basic->dist_code, $field_mut_basic->subdiv_code) ?></label>
                                        </td>
                                        <td><label
                                            class="text-danger">চক্র (Circle)
                                            :
                                            &nbsp;&nbsp;&nbsp; <?= $this->utilityclass->getCircleName($field_mut_basic->dist_code, $field_mut_basic->subdiv_code, $field_mut_basic->cir_code) ?></label>
                                        </td>
                                        <td><label
                                            class="text-danger">মৌজা (Mouza)
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getMouzaName($field_mut_basic->dist_code, $field_mut_basic->subdiv_code, $field_mut_basic->cir_code, $field_mut_basic->mouza_pargona_code) ?></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1"><label
                                            class="text-danger">লাট (Lot)
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getLotName($field_mut_basic->dist_code, $field_mut_basic->subdiv_code, $field_mut_basic->cir_code, $field_mut_basic->mouza_pargona_code, $field_mut_basic->lot_no) ?></label>
                                        </td>
                                        <td>
                                                <label
                                                class="text-danger">গাওঁ / চহৰ (Village) :
                                                <?= $this->utilityclass->getVillageName($field_mut_basic->dist_code, $field_mut_basic->subdiv_code, $field_mut_basic->cir_code, $field_mut_basic->mouza_pargona_code, $field_mut_basic->lot_no, $field_mut_basic->vill_townprt_code) ?></span>
                                            </label>
                                        </td>
                                        <td >
                                            <label
                                                class="text-danger">Dag No :
                                                 &nbsp;&nbsp;&nbsp;<?= $dag_details[0]->dag_no ?></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label
                                            class="text-danger">Patta Type :
                                            : &nbsp;&nbsp;&nbsp;<?= $this->utilityclass->getPattaName($dag_details[0]->patta_type_code) ?></label>
                                        </td>
                                        <td><label
                                            class="text-danger">Patta No.
                                            : &nbsp;&nbsp;&nbsp;<?= $dag_details[0]->patta_no ?></label>
                                        </td>
                                        <td >
                                            <label
                                                class="text-danger">Date :
                                                 &nbsp;&nbsp;&nbsp;<?= date('Y-m-d') ?></span>
                                            </label>
                                        </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span style="color:#3c8198; font-size: 18px" class="bold">
                                <?php echo $this->lang->line('applicant_information'); ?> (First Party)
                            </span>
                            <table class='table table-bordered unicode'>
                                <thead>
                                    <tr class="text-bold table-success">
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('applicants_name'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('address1'); ?>
                                            / <?php echo $this->lang->line('address2'); ?></label>
                                        </th>
                                        
                                        <?php if($field_mut_basic->mut_type=='01'){ ?>
                                            <th><label class="text-danger">Land Area</label></th>
                                        <?php } ?>
                                                                            
                                    </tr>
                                </thead>
                                <tbody id="field_mut_petitioner">
                                    <?php foreach ($field_mut_petitioner as $key=>$applicant) {

                                        $bigha = (($applicant->applied_b==null)?'0':$applicant->applied_b);
                                        $katha = (($applicant->applied_k==null)?'0':$applicant->applied_k);
                                        $lessa = (($applicant->applied_lc==null)?'0':$applicant->applied_b);

                                        $land = 'B:'.$bigha.' / K:'.$katha.' / L:'.$lessa.' / Kr: 0';
                                        $add2 = $applicant->add2;

                                        ?>
                                        <tr id="<?=$applicant->pet_id?>" class="remove_<?=$applicant->pet_id?>">
                                            <td><?= $applicant->pet_name ?></label>
                                            </td>
                                            <td><?= $applicant->guard_name ?></label>
                                            </td>
                                            <td>Add 1: <?= $applicant->add1 ?><br>
                                            <?=(($add2=='')?'':'Add 2:'. $add2)?>
                                            </td>
                                            <?php if($field_mut_basic->mut_type=='01'){ ?>
                                            <td><label class="text-danger"><?=$land?></label></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>




                        <?php //if($field_mut_basic->mut_type=='02') { ?>
                        <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th style="background-color: #136a6f; color: #fff" colspan="6">Land Details</th>
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
                                            <input type='hidden' id="b_fp" 
                                            value="<?=$dag->dag_area_b?>"/>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->dag_area_k?></span>
                                            <input type='hidden' maxlength="2" id="k_fp"
                                            value="<?=$dag->dag_area_k?>"/>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->dag_area_lc?></span>
                                            <input type='hidden' maxlength="5" id="lc_fp" 
                                            value="<?=$dag->dag_area_lc?>"/>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->dag_area_g?></span>
                                            <input type='hidden' maxlength="2" id="g_fp" 
                                            value="<?=$dag->dag_area_g?>"/>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->dag_area_kr?></span>
                                            <input type='hidden' maxlength="2" id="kr_fp"
                                            value="<?=$dag->dag_area_kr?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-red text-bold"><?=$this->lang->line('mutated_land_area')?></td>
                                        <td>
                                            <span class="text-bold"><?=$dag->m_dag_area_b?></span>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->m_dag_area_k?></span>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->m_dag_area_lc?></span>
                                        </td>
                                        <td>
                                            <span class="text-bold"><?=$dag->m_dag_area_g?></span>
                                        </td>
                                        <td>
                                            <span class="text-bold">0</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php //} ?>

                
                        <div class="form-group" style="padding-left:10px;">
                             <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                                }
                            ?>   
                        </div>
                <?php if($field_mut_basic->mut_type=='01') { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span style="color:#3c8198; font-size: 18px" class="bold">Pattadar Details (Second Party)
                            </span>
                            <table class='table table-bordered unicode'>
                                <thead>
                                    <tr>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger">Pattadar Name</label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label>
                                        </th>
                                        <th><label
                                            class="text-danger"><?php echo $this->lang->line('address1'); ?>
                                            / <?php echo $this->lang->line('address2'); ?></label>
                                        </th>
                                        <th><label class="text-danger">Inplace Alongwith</label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php foreach ($field_mut_pattadar as $key=>$pattadar) {?>
                                        <tr>
                                            <td><?= ++$key?></label>
                                            </td>
                                            <td><?= $pattadar->pdar_name ?></label>
                                            </td>
                                            <td><?= $pattadar->pdar_guardian ?></label>
                                            </td>
                                            <td>Add 1: <?= $pattadar->pdar_add1 ?>
                                            / Add 2: <?= $pattadar->pdar_add2 ?>
                                        </td>
                                        <td>
                                            <?php if($pattadar->striked_out == 1)
                                            { ?>
                                                Inplace
                                            <?php }
                                            else if($pattadar->striked_out == 0)
                                                { ?>
                                                    Alongwith
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                
                <?php } ?>
                <div class="col-lg-12 text-bold text-red" id="alert_message"></div>

                <form id="revert_Report_LM_FPart" method="post">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <label for="inputEmail3"
                        class="uni_text control-label required">Type Note</label>
                        <textarea class="form-control" rows="5" name='note_order' id="textArea" placeholder="Please Type Your Report"><?=$dag_details[0]->remark;?></textarea>
                        <div id="err_lm_report_note_order"></div>
                    </div>
                    <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <center>
                        <button type="submit" id='submit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                    </center>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
    <script>

    $('#revert_Report_LM_FPart').submit(function(e){
        e.preventDefault();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + "Rtps/freshReportBackRTPS",
            type: 'POST',
            data: $("#revert_Report_LM_FPart").serialize(),
            dataType: "json",
            success: function (data) 
            {
                $.unblockUI();
                console.log(data);
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
                    window.location.href = baseurl + "lmmutation/revertedcases";
                }
            },
                error:function(data){
                    alert("Something went wrong");
                    $.unblockUI();
                }
        });
    });




    </script>
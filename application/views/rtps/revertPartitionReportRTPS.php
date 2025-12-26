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
                        <h2 style="text-align: center; color: red">Office Partition Revert Report (RTPS)</h2>
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
                                        </th>
                                    </thead>
                                    <thead>
                                        <tr class="text-bold table-success">
                                            <th width="5%">#</th>
                                            <th width="12%"><?=$this->lang->line('applicants_name')?></th>
                                            <th width="12%"><?=$this->lang->line('guardian_name')?></th>
                                            <th width="20%">Address</th>
                                            <th width="10%">Contact No</th>
                                        </tr>
                                    </thead>
                                    <tbody id="office_partition_first_party">
                                        <?php $i=1; foreach($first_party as $appl):?>
                                        <tr id="<?=$appl->pdar_id?>" class="remove_<?=$appl->pdar_id?>">
                                            <td><?=$i?></td>
                                            <td><?=$appl->pdar_name?></td>
                                            <td><?=$appl->pdar_guardian?></td>
                                            <td><?=$appl->pdar_add1?></td>
                                            <td><?=(($appl->pdar_mobile=='')?'-':$appl->pdar_mobile)?></td>
                                        </tr>
                                        <?php $i++; endforeach; ?>                             
                                    </tbody>
                                </table>
                            </div>

                            
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
                                                <span class="text-bold"><?=$dag->m_dag_area_b?></span>
                                                <input type='hidden' maxlength="6" name="mut_b_op" id="mut_b_op" value="<?=$dag->m_dag_area_b?>" />
                                                <div id="err_lm_report_mut_b_op"></div>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->m_dag_area_k?></span>
                                                <input type='hidden' maxlength="2" name="mut_k_op" id="mut_k_op" value="<?=$dag->m_dag_area_k?>"/>
                                                <div id="err_lm_report_mut_k_op"></div>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->m_dag_area_lc?></span>
                                                <input type='hidden' maxlength="5" name="mut_lc_op" id="mut_lc_op" value="<?=$dag->m_dag_area_lc?>" />
                                                <div id="err_lm_report_mut_lc_op"></div>
                                            </td>
                                            <td>
                                                <span class="text-bold"><?=$dag->m_dag_area_g?></span>
                                                <input type='hidden' maxlength="2" name="mut_g_op" id="mut_g_op" value="<?=$dag->m_dag_area_g?>" />
                                                <div id="err_lm_report_mut_g_op"></div>
                                            </td>
                                            <td>
                                                <span class="text-bold">0</span>
                                                <input type='hidden' maxlength="2" name="mut_kr_op" id="mut_kr_op" value="0" readonly />
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

                            <form id="revert_Report_LM_OPart" method="post">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <label for="inputEmail3"
                                    class="uni_text control-label required">Type Note</label>
                                    <textarea class="form-control" rows="5" name='note_order' id="note_order" placeholder="Please Type Your Report"></textarea>
                                    <div id="err_lm_report_note_order"></div>
                                </div>
                                &nbsp;
                                <div id="div_error" class="col-lg-12 text-bold text-red"></div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;<hr></div>
                                <center>
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

    <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
    <script>

    $('#revert_Report_LM_OPart').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: baseurl + "Rtps/revertReportOPartSubmitRTPS",
            type: 'POST',
            data: $("#revert_Report_LM_OPart").serialize(),
            dataType: "json",
            success: function (data) 
            {
                //console.log(data.final);
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

                if(data.errorMsg != null){
                    $('#div_error').html(data.errorMsg);
                }

            },
            error:function(data){
                alert("Something went wrong");
            }
        });
    });

    </script>
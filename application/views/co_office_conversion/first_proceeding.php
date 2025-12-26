<div class="container-fluid form-top login">
    <div class="row">
        <?php
        $buttonEnabledFlag =1;
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            include 'application/views/common/input_hidden_fields_and_func.php';
        }
        ?>
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Conversion Order</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        
                        <form class="" method='post' action="<?php echo base_url() . "index.php/COconversionPartha/ThirdProcess"; ?>">
                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>

                            <table class='rasid-t'>
                                <input type="text" name="executionDate" id="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                                <tr>
                                    <td>আবেদনকাৰীৰ ম্যাদীকৰণ আৱেদন চোৱা হল । আবেদনকাৰী
                                    <?php
                                    $count = 1;
                                    $howmany = sizeof($pattadar) - 1;
                                    foreach ($pattadar as $p):
                                    ?>
                                        <span style="color:red;">
                                            <?php echo $p->pdar_name; ?>
                                        </span>
                                    <?php
                                        echo "( " . $p->pdar_guardian. " )";
                                        if ($count < sizeof($pattadar) - 1) {
                                            echo " , ";
                                            $count++;
                                        } elseif ($count == sizeof($pattadar) - 1) {
                                            echo " আৰু ";
                                            $count++;
                                        } else {
                                            echo " ";
                                        }
                                    ?>
                                    <?php endforeach; ?>য়ে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাঁৱৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা
                                        মাটিৰ ম্যাদীকৰণ বিচাৰিছে |</td>                                         
                                </tr>
                                <tr>
                                    <td>লাঃ মঃ আৰু  চু:কা:ই  ভূমি-লেক্ষ্য নিয়মাৱলীৰ ১০৫ নং ধাৰা মতে প্রতিবেদন দিব ।
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; padding-right: 40px;">
                                        <input type="hidden" name="co_order" value="আবেদনকাৰীৰ ম্যাদীকৰণ আৱেদন চোৱা হল । আবেদনকাৰী
                                    <?php
                                    $count = 1;
                                    $howmany = sizeof($pattadar) - 1;
                                    foreach ($pattadar as $p):
                                    ?>
                                        <span style='color:red;'>
                                            <?php echo $p->pdar_name; ?>
                                        </span>
                                    <?php
                                        echo '( ' . $p->pdar_guardian. ' )';
                                        if ($count < sizeof($pattadar) - 1) {
                                            echo ' , ';
                                            $count++;
                                        } elseif ($count == sizeof($pattadar) - 1) {
                                            echo ' আৰু ';
                                            $count++;
                                        } else {
                                            echo ' ';
                                        }
                                    ?>
                                    <?php endforeach; ?>য়ে <?php echo $location['mouza']; ?> মৌজাৰ <?php echo $location['vill']; ?> গাঁৱৰ <?php echo $location['patta_no']; ?> নং <?php echo $patta_type; ?> পট্টাৰ  <?php echo $location['dag']; ?> নং দাগৰ <?php echo $location['m_dag_area_b']; ?> বিঘা <?php echo $location['m_dag_area_k']; ?> কঠা <?php echo $location['m_dag_area_lc']; ?> লেছা
                                        মাটিৰ ম্যাদীকৰণ বিচাৰিছে |<br>লাঃ মঃ আৰু  চু:কা:ই  ভূমি-লেক্ষ্য নিয়মাৱলীৰ ১০৫ নং ধাৰা মতে প্রতিবেদন দিব ।<br><label class='control-label rasid' style='float:right;margin-right:50px;'><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></label>">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-2" style="margin-left:20px;">
                                        <input type="text" class="form-control" id="popupDatepicker" readonly="" autocomplete="off" placeholder="" name="hearing_date" required style="margin-left: 20px;">
                                    </div>
                                    <label class="col-sm-8 uni_text">তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য হ'ল ।</label>
                                </div>
                                <br>
                                <label class="control-label uni_text pull-right" style="float:right; font-size: 22px; text-align: right"><?php echo $location['add_to']; ?><br>চক্র বিষয়া, <?php echo $location['cir']; ?></label>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-sm-12">
                                <label class="rasid col-sm-4">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" disabled> <?php echo $this->lang->line('final_order'); ?>
                                </label>
                                <!-- <label class="rasid col-sm-4">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" onclick="return confirm('Are you sure you want to cancel this case order?')"> <?php //echo $this->lang->line('cancel_order'); ?>
                                </label> -->
                                <label class="rasid col-sm-4">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked> <?php echo $this->lang->line('continue_hearings'); ?>
                                </label>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <center>
                                    <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>

                                    <?php if($buttonEnabledFlag == 1){ ?>
                                        <button type="submit" name="submit"  class="btn btn-success uni_text"><i class='fa fa-check'></i>  <?php echo $this->lang->line('submit_button'); ?> / Proceed</button>
                                    <?php } ?>
                                    
                                </center>
                                <hr>
                            </div>
                            <br>
                            <hr style="border-bottom: 2px solid #000;">
                        </form>
                            <?php
                                if($basundharaAttachment){
                                    echo '<h2 class="red">Other Attachments</h2>';
                                    foreach ($basundharaAttachment  as $attachment):
                                    ?>
                                    <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                    <?php 
                                    endforeach; 
                                }
                                else{
                                    echo '<h2 class="red">Other Attachments</h2>';
                                    foreach($supportiveDocs as $docs):
                                    ?>
                                        <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
                                    <?php
                                    endforeach;
                                }
                                
                            ?>
                            <hr>
                        <div class="col-lg-12 alert alert-warning">
                            <center>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank"><i class='fa fa-list-alt'></i> চিঠা চাওক</a>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><i class='fa fa-list-alt'></i> জমাবন্দী চাওক</a>
                                <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$location['case_no']?>','<?=SERVICE_CONVERSION?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                <button type="" class="btn btn-primary uni_text" data-toggle="modal" data-target="#myModal"><i class='fa fa-list-alt'></i>&nbsp; <?php echo $this->lang->line('view_application'); ?></button>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/COconversionPartha/GoToCO?pro=1"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title uni_text"><?php echo $this->lang->line('application_description'); ?></h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('general_information'); ?></h4>
                    <table class='table table-bordered unicode'>
                        <tr>
                            <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                            <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                            <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                        </tr>
                        <tr>
                            <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                            <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                            <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                        </tr>
                        <tr>
                            <td colspan="3"><label class="text-danger"><?php echo $this->lang->line('type'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $conv_type; ?></label></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="text-danger"><?php echo $this->lang->line('address_to_the_officer'); ?> : <?php echo $location['add_to']; ?></label></td>
                            <td><label class="text-danger"><?php echo $this->lang->line('submission_date'); ?> : &nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y', strtotime($location['date'])); ?></label></td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('application_dag_details_information'); ?></h4>
                    <table class="table table-bordered  unicode">
                        <thead>
                            <tr>
                                <th><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?></label></th>
                                <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?></label></th>
                                <th class="center"><label class="text-danger"><?php echo $this->lang->line('patta_type'); ?></label></th>
                                <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_chitha'); ?></label></th>
                                <th class="center"><label class="text-danger"><?php echo $this->lang->line('show_jamabandi'); ?></label></th>
                            </tr>
                        </thead>
                        <tr>
                            <td><label class="control-label"><?php echo $location['dag']; ?></label></td>
                            <td><label class="control-label"><?php echo $location['m_dag_area_b'] . " বিঘা " . $location['m_dag_area_k'] . " কঠা " . $location['m_dag_area_lc'] . " লেছা " ?></label></td>
                            <td class="center"><label class="control-label"><?php echo $location['patta_no']; ?></label></td>
                            <td class="center"><label class="control-label"><?php echo $patta_type; ?></label></td>
                            <td class="center"><a href="<?php echo base_url() . "index.php/ChithaReport/generateChitha?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn"><?php echo $this->lang->line('show_chitha'); ?></span></button></a></td>
                            <td class="center"><a href="<?php echo base_url() . "index.php/AsistantMutationPartha/saveJamabandiByPattano?case_no=" . $location['case_no']; ?>" target="_blank"><button type="submit" class="btn btn-xs"><span class="ass-btn"><?php echo $this->lang->line('show_jamabandi'); ?></span></button></a></td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <h4 class="bold" style="color:#3c8198"><?php echo $this->lang->line('applicant_information'); ?></h4>
                    <table class='table table-bordered  unicode'>
                        <thead>
                            <tr>
                                <th><label class="text-danger"><?php echo $this->lang->line('sl_no'); ?></label></th>
                                <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                <th><label class="text-danger"><?php echo $this->lang->line('relation'); ?></label></th>
                                <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                <th>Aadhaar/PAN Status</th>
                            </tr>
                        </thead>
                        <?php $count = 1; ?>
                        <?php

                        $params = [
                          'case_no'          => $location['case_no'],
                          'service_code'     => 9,
                          'remarks'          => 'Conversion',
                          'accessed_entity'  => 'Aadhaar Status Check',
                        ];
                        $this->load->model('EkycLogModel');
                        $log = $this->EkycLogModel->insertEkycAccessedBy($this->db, $params);


                        foreach ($pattadar as $p):
                            $flag = 'N/A';
                            if($p->auth_type == 'AADHAAR'){
                                $flag = 'AADHAAR Verified';
                            }else if($p->auth_type == 'PAN'){
                                $flag = 'PAN Verified';
                            }
                            $pattadar = $p->pdar_name;
                            //$relation=$p->pdar_rel_guar;
                            $relation = 'f';
                            $relationship = $this->utilityclass->get_relation($relation);
                            ?>
                            <tr>
                                <td><label class="control-label"><?php echo $count++; ?></label></td>
                                <td><label class="control-label"><?php echo $pattadar; ?></label>
                                  <?php if($p->pdar_mobile) { ?> ( <i class="fa fa-mobile"></i> <?=$p->pdar_mobile?> ) <?php } ?></td>
                                <td><label class="control-label"><?php echo $p->pdar_guardian; ?></label></td>
                                <td><label class="control-label"><?php echo $relationship; ?></label></td>
                                <td><label class="control-label"><?php echo $p->pdar_add1 . " " . $p->pdar_add2; ?></label></td>
                                <td><label class="control-label"><?php echo $flag; ?></label></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </fieldset>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default uni_text" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('lm_report');?> (<?php echo $this->lang->line('miscellaneous_cases');?>)</h2>
                </div>
            </div>

            <?php if ($this->session->flashdata('message')): ?>
                <?php 
                    echo '<div class="col-lg-10 col-lg-offset-1">
                        <p style="color:red;">'.$this->session->flashdata('message').'</p>
                    </div>';
                ?>
            <?php endif; ?>

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <?php echo $misc_case_no = $_GET['misc_case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="<?php echo base_url('index.php/NameCorrectionV2/LMStep2revert_save'); ?>" enctype="multipart/form-data" method="POST">  
                            <input type="hidden" name="executionDate" id="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <?php if(ESCALATION_ENABLE == 1){ ?>
                                <?php 
                                    include(APPPATH."views/escalation/remaining_time.php");
                                ?>
                            <?php } ?>

                            <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                            <?php
                            }
                            ?>

                            <input type="hidden" name="misc_case_no" value="<?php echo $misc_case_no; ?>"/>
                            <input type="hidden" name="misc_case_petition_no" value="<?php echo $_GET['petition_no']; ?>"/>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered" width="100%">
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('district');?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('circle');?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('mouza');?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                                        </tr>
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?> : <strong><?php $d = $miscCaseInfo->submission_date;
                                                        echo date("d-m-Y", strtotime($d)); ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $pattaType->patta_type; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $user_name->username; ?></strong></h6></td>
                                        </tr> 
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_no');?> : <strong><?php echo $miscCaseInfo->patta_no; ?></strong></h6></td>
                                            <td class="text-center">&nbsp;</td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('dag_no');?> : <strong><?php echo $miscCaseInfo->dag_no; ?></strong></h6></td>
                                        </tr>

                                        <?php if($basundharaApp){ ?>
                                        <tr>
                                            <td class="text-center"><h6><?php echo "Mobile";?> : <strong><?php echo $basundharaApp->applicants[0]->mobile; ?></strong></h6></td>
                                     </tr>
                                      <?php }?>

                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <h2><mark><?php echo $this->lang->line('petitioner_information');?></mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <table class="table table-striped table-bordered" width="100%">
                                        <?php
                                        if($Petitioner){ 

                                        $c = 1;
                                       foreach ($Petitioner AS $pet) {
                                            ?>
                                            <tr class="success">
                                                <td>
                                                   <?php echo $this->lang->line('petitioner_name');?> : <strong><?php echo $pet->petition_pdar_name_old;?></strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="success">
                                                <td>
                                                    <?php echo $this->lang->line('corrected_name');?>  : <?php echo $pet->petition_pdar_name_new;?>
                                                </td>
                                                <td><b><?php if(isset($pet->auth_type) && $pet->auth_type == 'AADHAAR'){
                                                    echo $flag = 'AADHAAR Verified';
                                                }else if(isset($pet->auth_type) && $pet->auth_type == 'PAN'){
                                                    echo $flag = 'PAN Verified';
                                                }else{
                                                    echo $flag = null;
                                                } ?></b></td>
                                            </tr>
                                            <?php $c++; } 
                                            }

                                        else echo '<h2 class="red">Petitioner name might already been corrected.Kindly check the chitha</h2>';


                                            ?>
                                    </table>
                                </div>
                                <div>
                                    <?php include 'application/views/common/aadhar_details_dhar_end_half.php'; ?>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php if($co_revert){?>

                               <div class="form-group">
                                <label for="inputEmail" class="col-lg-4 control-label">CO's remark</label>
                                <div class="col-lg-8">

                                    <textarea name="" class="form-control" rows="5" readonly><?php echo $co_revert->process_note;?></textarea>
                                </div>
                            </div>

                            <?php } ?>
                            <hr style="border-bottom: 2px solid #000;">

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
                                else { ?>
                            <div class="col-lg-6">
                                <h2><mark><?php echo $this->lang->line('related_document_information');?></mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <table class="table table-striped table-bordered" width="100%">
                                    <?php
                                    $c = 1;
                                    foreach ($SupportDoc AS $sup) {
                                        ?>
                                        <tr class="success">
                                            <td>
                                            <?php echo $c . ". " . $sup->supp_doc_name; ?>
                                            </td>
                                        </tr>
                                    <?php $c++; } ?>
                                    </table> 
                                </div>
                            </div>
                             <?php }
                             include(APPPATH."views/common/addMoreDocumentView.php");
                             ?>

                            
                            
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('lm_report');?> </label>
                                <div class="col-lg-8">
                                    <textarea name="lm_report" class="form-control" rows="5" required></textarea>
                                </div>
                            </div>

                            <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $miscCaseInfo->es_flag == 1 && $miscCaseInfo->out_of_esc == 0) { ?>
                                <div class="col-lg-12">
                                    <div class="form-group col-md-4 text-right">
                                        <label> Cause For the case has not been pass in the timeline : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 uni_text control-label required" aria-required="true">Assign Recieving Circle Officer</label>
                            <div class="col-sm-5">
                                <select name="official" class="form-control" required="" id='selectCo' aria-required="true" aria-invalid="false">
                                <option value="">Select CO</option>
                                  <?php foreach($user as $u){
                                    
                                   ?>
                                 <option value="<?=$u['user_code']?>"><?=$u['username']?> </option>
                                  <?php } ?>
                                </select>
                               
                            </div>
                            </div>

                            <hr style="border-bottom: 2px solid #000;">

                             <?php if(!empty($app->basundhara)){ ?>

                                 <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject btn-sm btn-danger hide"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                      

                            <?php }
                            else { ?>
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="FormSubmit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            </div>
                            <?php }?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
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
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>

<script>

    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>

</script>


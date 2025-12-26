<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('co_final_order_on_miscellaneous_cases');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <?php echo $misc_case_no = $_GET['misc_case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/NameCorrection/COFinalOrderMiscCase2_save"; ?>">

                         <?php if(!empty($app->basundhara)){ ?>   
                         <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">   
                         <?php }?>                   
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
                                    </table>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">


                            
                            <div class="col-lg-6">
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
                                            </tr>
                                            <tr class="success">
                                                <td>
                                                    <?php echo $this->lang->line('corrected_name');?>  : <?php echo $pet->petition_pdar_name_new;?>
                                                </td>
                                            </tr>
                                            <?php $c++; } }
                                            else echo '<h2 class="red">Petitioner name might already been corrected.Kindly check the chitha</h2>';


                                            ?>
                                    </table>
                                </div>
                            </div>

                            <br>

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
                             <?php }?>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-6">
                                <h2><mark><?php echo $this->lang->line('lm_report');?></mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <p class='uni_text'><?php echo $lm_report;?></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h2><mark><?php echo $this->lang->line('sk_report');?></mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <p class='uni_text'><?php echo $sk_report;?></p>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group revertForm">
                                <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('co_final_order');?> </label>
                                <div class="col-lg-8">
                                    <textarea name="co_report" class="form-control" rows="5" required></textarea>

                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">

                            <?php if(!empty($app->basundhara)){ ?>

                                 <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CORRECT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                          <button class="btn revertToLmModal btn-sm btn-success"><i class='fa fa-arrows-alt'></i> Revert to LM</button>&nbsp;

                        </center>
                      

                            <?php }

                             else { ?>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <button type="submit" name="FormSubmit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
									<button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$_GET['misc_case_no']?>','<?=SERVICE_NAME_CORRECT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                                    <!-- <a href="<?php echo base_url() . "index.php/NameCorrection/revertToLm"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>" class="btn btn-success">
                                        <i class='fa fa-check'></i>Revert to LM
                                    </a> -->
                                    <button class="btn revertToLmForReport btn-sm btn-success"><i class='fa fa-arrows-alt'></i> Revert to LM</button>&nbsp;

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

<!-- <div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/basundhara/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div> -->

<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/NameCancellation/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
              <input type="hidden" class="form-control" name='misc_case_no' value="<?php echo $misc_case_no; ?>">
              
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
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
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
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
            <form id='' action="<?php echo base_url() ?>index.php/NameCorrection/revertToLm" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
              <input type="hidden" class="form-control" name='misc_case_no' value="<?php echo $misc_case_no; ?>">
              
                <textarea name='co_report' class="form-control">Reason for revert</textarea> 
                <textarea name="co_report_suffix" class="form-control hide" rows="5"></textarea> 

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form> 
        </div>
    </div>
</div>

<div id="revertToLmForReport" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Revert to LM reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/NameCorrection/revertToLm" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='misc_case_no' value="<?php echo $misc_case_no; ?>"> 
                <textarea name='co_report1' class="form-control">Reason for revert</textarea> 
                <textarea name="co_report_suffix" class="form-control hide" rows="5"></textarea> 

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form> 
        </div>
    </div>
</div>




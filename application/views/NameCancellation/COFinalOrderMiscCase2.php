<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('co_final_order_on_misc_cases');?></h2>
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
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/NameCancellation/COFinalOrderMiscCase2_save"; ?>">   

                         <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php
                            }
                            ?>                     
                            <input type="hidden" name="misc_case_no" value="<?php echo $misc_case_no; ?>"/>
                            <input type="hidden" name="petition_no" value="<?php echo $miscCaseInfo->misc_case_petition_no ; ?>"/>
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
                                            <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?>  : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                                        </tr>
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?>  : <strong><?php $d = $miscCaseInfo->submission_date;
                                                        echo date("d-m-Y", strtotime($d)); ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $pattaType->patta_type; ?></strong></h6></td>
                                            
                                            <td class="text-center "><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $user_name->username; ?></strong></h6></td>
                                        </tr>
                                    </table>


                                </div>
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
                            
                            <h3><?php echo $this->lang->line('co_final_order');?></h3>
                            <hr/>
                            
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <textarea name="co_report" class="form-control" rows="5" required></textarea>
                                </div>
                                
                                
                            </div>
                            <?php if(!empty($app->basundhara)){ ?>

                                 <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Submit </button>&nbsp;
                          <button class="btn reject btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>

                          <a href="<?php echo base_url() . "index.php/NameCancellation/ViewNCorrPetition"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_petition');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    
                                    <a href="<?php echo base_url() . "index.php/NameCancellation/ViewASTReport"; ?>?misc_case_no=<?php echo $_GET['misc_case_no'];?>&petition_no=<?php echo $_GET['petition_no'] ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('ast_report');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/NameCorrection/ViewLMReport"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>&petition_no=<?php echo $_GET['petition_no'] ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('lm_report');?>
                                    </a>
                                    <br>
                                    <a href="<?php echo base_url() . "index.php/NameCorrection/ViewSKReport"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>&petition_no=<?php echo $_GET['petition_no'] ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('sk_report');?>
                                    </a>
                        </center>
                      

                            <?php }

                             else { ?>
                           
                            <div class="form-group">
                                <div class="col-lg-12 col-lg-offset-1">
                                    <button type="submit" name="FormSubmit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/NameCancellation/RejectOrder"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>" class="btn btn-info">
                                        <i class='fa fa-check'></i>Reject Order
                                    </a>
                                    <a href="<?php echo base_url() . "index.php/NameCancellation/ViewNCorrPetition"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_petition');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
									
                                    <a href="<?php echo base_url() . "index.php/NameCancellation/ViewASTReport"; ?>?misc_case_no=<?php echo $_GET['misc_case_no'];?>&petition_no=<?php echo $_GET['petition_no'] ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('ast_report');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/NameCorrection/ViewLMReport"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>&petition_no=<?php echo $_GET['petition_no'] ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('lm_report');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/NameCorrection/ViewSKReport"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>&petition_no=<?php echo $_GET['petition_no'] ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('sk_report');?>
                                    </a>
                                    <br/><br/>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
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


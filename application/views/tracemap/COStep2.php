
<style type="text/css">
  .mmm{
    padding-top: 5px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
}
  }
</style>


<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="p-2 my-2 rounded center" style="background-color: #607d8b;font-size: 25px;font-weight: 700">
                    CO's Order for Trace Map 
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading" style="background-color: #00838F">
                        <h3 class="panel-title">
                           <?php echo $this->lang->line('case_no');?> : <?php echo $case_no = $_GET['case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/Tracemap/COStep2_save"; ?>">   

                            <?php if(!empty($app->basundhara)){ ?>
                                <input type="hidden" class="form-control" name='application_no' value="<?php echo $app->basundhara;?>">
                        <?php
                            }
                            ?>                    
                            <input type="hidden" name="case_no" value="<?php echo $case_no; ?>"/> 
							
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table" width="100%">
                                        <tr class="success">
                                            <td class=""><h6><?php echo $this->lang->line('district');?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                            <td class=""><h6><?php echo $this->lang->line('subdivision');?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                            <td class=""><h6><?php echo $this->lang->line('circle');?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                                        </tr>
                                        <tr>
                                            <td class=""><h6><?php echo $this->lang->line('mouza');?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                            <td class=""><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                            <td class=""><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                                        </tr>
                                        <tr class="success">
                                            <td class=""><h6><?php echo $this->lang->line('submission_date');?>  : <strong><?php
                                                        $d = $miscCaseInfo->submission_date;
                                                        echo date("d-m-Y", strtotime($d));
                                                        ?></strong></h6></td>
                                            <td class=""><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $pattaType->patta_type; ?></strong></h6></td>
                                            <td class=" "><h6><strong></strong></h6></td>
                                        </tr>                      
                                    </table>

                                </div>
                            </div>


                            <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>


                        
                            <h2 style="color: #448AFF; padding-left: 15px">Land Details</h2>
                            
                            <div class="row">
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <input type="text" name="dist" class="form-control " readonly="readonly" value="<?php echo $pattaType->patta_type; ?>"/>
                                 </div>
                              </div>
                            </div>
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <input type="text" name="dist" class="form-control " readonly="readonly" value="<?php echo $miscCaseInfo->patta_no; ?>"/>
                                 </div>
                              </div>
                            </div>

                             <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <input type="text" name="dist" class="form-control " readonly="readonly" value="<?php echo $miscCaseInfo->dag_no; ?>"/>
                                 </div>
                              </div>
                          </div>
                        </div>


                        <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>


                        
                            <h2 style="color: #448AFF; padding-left: 15px">Applicant Details</h2>

                           

                            <?php  foreach($miscCaseappl as $fp): 
                              ?>
                            
                            <div class="row">
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Applicant Name</label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <input type="text" name="dist" class="form-control " readonly="readonly" value="<?=$fp->appl_name;?>"/>
                                 </div>
                              </div>
                            </div>
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Father's Name</label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <input type="text" name="dist" class="form-control " readonly="readonly" value="<?=$fp->father_name;?>"/>
                                 </div>
                              </div>
                            </div>
                            

                            
                        
                        </div>
                      <?php endforeach; ?>
                    </div>
                      
                      <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Mobile</label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <input type="text" name="dist" class="form-control " readonly="readonly" value="<?php echo $miscCaseInfo->mobile; ?>"/>
                                 </div>
                              </div>
                          </div>
                       <br/><br>
					   <?php
                             if($query){
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
                                    echo "<br>";
                                    echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
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
                  
                            <div class="row">
                                 <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 mmm'>
                                    <label for="inputEmail" class=" control-label">Remark</label>
                                 </div>
                                 <div class='col-lg-9 col-md-6 col-sm-6 col-xs-6'>
                                    <textarea name="coremark" class="form-control" rows="5" required> </textarea>
                                 </div>
                              </div>
                             <br/>
                    
                            
                        <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
                        <br/>


                        <?php if(!empty($app->basundhara)){ ?>

                                 <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject btn-sm btn-danger"><i class='fa fa-close'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                          <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-warning" style="background-color: #f0ad4e;color: white;">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                        </center>
                      

                            <?php }

                             else { ?>

                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                   
                            
                              <button class="btn revertToLmForReport btn-sm btn-danger"><i class='fa fa-close'></i>&nbsp;Reject</button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-warning" style="background-color: #f0ad4e;color: white;">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>

                            </div>


                       
                        
                    </div>
                    <?php }?>
                     </form>
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
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/Tracemap/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
              <input type="hidden" class="form-control" name='misc_case_no' value="<?php echo $case_no; ?>">
                <textarea name='coremark' class="form-control">Reason of Rejection</textarea>
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
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/Rtps/queryRequest" method="post">
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

<div id="revertToLmForReport" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/Tracemap/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='case_no' value="<?php echo $case_no; ?>"> 
                <textarea name='coremark' class="form-control">Reason for rejection</textarea> 
                <textarea name="co_report_suffix" class="form-control hide" rows="5"></textarea> 

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form> 
        </div>
    </div>
</div>


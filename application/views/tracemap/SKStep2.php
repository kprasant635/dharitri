
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
                    SK's Report on Trace Map 
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
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/Tracemap/SKStep2_save"; ?>">   

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
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table" width="100%">
                                        <tr class="success">
                                            <td class=""><h6>Patta No : <strong><?php echo $miscCaseInfo->patta_no; ?></strong></h6></td>
                                            <td class=""><h6>Dag No: <strong><?php echo $miscCaseInfo->dag_no; ?></strong></h6></td>
                                             <td class=""><h6>Mobile: <strong><?php echo $miscCaseInfo->mobile; ?></strong></h6></td>
                                            
                                        </tr>
                                 
                                    </table>
                                    <table class="table table-bordered" width="100%">

                                        <?php $i=1; foreach($miscCaseappl as $fp):?>
                                         
                                        <tr>
                                          <td><?=$i++?></td>
                                            <td class=""><h6>Applicant Name : <strong><?=$fp->appl_name;?></strong></h6></td>
                                            <td class=""><h6>Father's Name : <strong><?=$fp->father_name;?></strong></h6></td>
                                            
                                        </tr>
                                         <?php endforeach; ?>

                                    </table>

                                </div>
                            </div>

                            <?php
                                if($lmrmk){?>

                            <div class="row pt-2">
                                 <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 mmm'>
                                    <label for="inputEmail" class=" control-label">LM Remark</label>
                                 </div>
                                 <div class='col-lg-9 col-md-6 col-sm-6 col-xs-6'>
                                    <textarea name="fcoremark" class="form-control" rows="5" readonly=""><?php echo $lmrmk->co_order; ?> </textarea>
                                 </div>
                              </div>
                          
                       <?php }?><br>
                       <?php
                                if($skrmk){?>

                            <div class="row">
                                 <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 mmm'>
                                    <label for="inputEmail" class=" control-label">Previous Remark(SK)</label>
                                 </div>
                                 <div class='col-lg-9 col-md-6 col-sm-6 col-xs-6'>
                                    <textarea name="fcoremark" class="form-control" rows="5" readonly=""><?php echo $skrmk->co_order; ?> </textarea>
                                 </div>
                              </div>
                          
                       <?php }?>

                       <?php
                        
                         if($cormk){?>

                            <div class="row pt-2">
                                 <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 mmm'>
                                    <label for="inputEmail" class=" control-label">CO Remark</label>
                                 </div>
                                 <div class='col-lg-9 col-md-6 col-sm-6 col-xs-6'>
                                    <textarea name="fcoremark" class="form-control" rows="5" readonly=""><?php echo $cormk->co_order; ?> </textarea>
                                 </div>
                              </div>
                          
                       <?php }?><br/>

            <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>

                
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <?php $i=1; foreach($sup_doc as $doc) { ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><span class="text-red bold">VIEW <?=$doc->file_name?></span></td>
                                <td>
                               <a style="color: red; text-decoration: none;" target='attachment'  href="<?=base_url()?>index.php/uploadDocuments/downloadDocuments/<?=$doc->id?>" target="_blank"><button type="button" class="btn-success">Click to View</button></a>
                                </td> 
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>

                  <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }
                            ?>

                         <div class="row pt-2">
                                 <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 mmm'>
                                    <label for="inputEmail" class="control-label">Remark <span class="text-red bold"> *</span></label>
                                 </div>
                                 <div class='col-lg-9 col-md-6 col-sm-6 col-xs-6'>
                                    <textarea name="skremark" class="form-control" rows="5" required=""> </textarea>
                                 </div>
                              </div>
               

                          
                        <hr> 





                        <?php if(!empty($app->basundhara)){ ?>

                          <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure you want to Submit the Case ?')" required><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>&nbsp;
                         
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>

                          <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                           <i class="fa fa-check-circle"></i>&nbsp; <?php echo $this->lang->line('back_to_main_menu');?>
                             </a>
                        </center>
                      

                            <?php }

                             else { ?>

                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure you want to Submit the Case ?')" required><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    
                                    <br><br>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                                    <i class="fa fa-check-circle"></i>&nbsp; <?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            <?php }?>

                            </div>
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


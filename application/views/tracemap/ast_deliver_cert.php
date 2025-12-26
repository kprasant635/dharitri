
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
                    Upload Signed Copy of Trace Map </div>
            
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading" style="background-color: #00838F">
                        <h3 class="panel-title">
                           <?php echo $this->lang->line('case_no');?> : <?php echo $case_no = $_GET['case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' id="lm_save" enctype="multipart/form-data">   

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
                             <!-- <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'>
                            <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table" width="100%">
                                        <tr>
                                            <td class=""><h6>Upload <?=TRACE_MAP?></h6></td>
                                            <td class=""><input type='file' name="up_noc" id="up_noc"></td>
                                            <td></td>
                                            
                                        </tr>
                                    <div class="col-lg-6 text-bold red" id="err_message"></div>
                                                            
                                    </table>

                                </div>
                            </div> -->
                             <?php if($cormk){?>
                            <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
                            <div class="form-group">

                                <label for="inputEmail" class="col-lg-4 control-label" style="text-align: left">CO's remark</label>
                                <div class="col-lg-8">
                                    <textarea disabled class="form-control" rows="5"><?php echo $cormk->co_order; ?></textarea>

                                </div>
                            </div>
                        <?php }?>

                <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
                <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>


                  <div class="form-group">
                        <label for="inputEmail" class="col-lg-3">Upload <?=TRACE_MAP?><span class="text-red bold"> *</span>
                        </label>
                        <div class="col-lg-3">
                            <input type='file' name="up_noc" id="up_noc">
                        </div>
                        <div class="col-lg-6 text-bold red" id="err_message"></div>
                    </div>
             
                        <br/>
                           
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
                        <hr> 





                        <?php if(!empty($app->basundhara)){ ?>

                                 <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                      

                            <?php }

                             else { ?>

                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check'></i>Upload Map</button>
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



<script>
  
  $("#lm_save").submit(function(e){
        e.preventDefault();
       
        $.ajax({
            url: baseurl + "Tracemap/deliverCertAst",
            type:'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType:'json',
            success: function (data) {
               
                
                

                if(data.error_a){
                    $('#err_message').html('');
                    var error_message = '';

                    $.each(data.error_a, function (index, value) {
                        $('#err_message').fadeIn();
                        error_message += value['err_msg'];
                    });
                    $('#err_message').html(error_message);
                    setTimeout(function(){
                            $('#err_message').fadeOut();
                        }, 15000);
                    return false;
                }

                  
            
                if(data.success == 'true'){
                    alert("Trace Map has been successfully uploaded for case no "+ data.case_no);
                    window.location.href = data.redirect;
                }
            },
            error: function(data){
                alert("Unable to Process");
                
            }
        });
    });


</script>


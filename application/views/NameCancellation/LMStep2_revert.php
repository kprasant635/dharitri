<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('lm_report');?> (<?php echo $this->lang->line('miscellaneous_cases');?>)</h2>
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
                        <form class="form-horizontal" method='post' id="lm_save" enctype="multipart/form-data">    
                            <input type="text" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
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
                                        <?php if($basundharaApp){ ?>
                                          <tr>
                                            <td class="text-center"><h6><?php echo "Mobile";?> : <strong><?php echo $basundharaApp->mutation[0]->pat_mobile_no; ?></strong></h6></td>
                                     </tr>
                                      <?php }?>
                                    </table>
                                </div>
                            </div>
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
                            
                            else {?>
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
                        
                            
                            <div class="col-lg-6">
                                <h2><mark>First Party information</mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <table class="table table-striped table-bordered" width="100%">
                                        <?php
                                        $c = 1;
                                       //foreach ($Petitioner AS $pet) {
                                            ?>
                                            <tr class="success">
                                                <td>
                                                   <?php echo $this->lang->line('petitioner_name');?> : <strong><?php echo $Petitioner->petition_pdar_name_old;?></strong>
                                                </td>
                                            </tr>
                                            
                                            <?php //$c++; } ?>
                                    </table>
                                </div>
                            </div>
							<div class="col-lg-6">
                                <h2><mark>Second Party information</mark></h2>
                                <hr/>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <table class="table table-striped table-bordered" width="100%">
                                        <?php  foreach ($secondparty AS $ss){ ?>
                                            <tr class="success">
                                                <td>
                                                   <?php echo $this->lang->line('petitioner_name');?> : <strong><?php echo $ss->pdar_name;?></strong>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>

                            <?php if(!empty($cormk)){ ?>
                             <div class="row">
                                 <div class='col-lg-3 col-md-6 col-sm-6 col-xs-12 mmm'>
                                    <label for="inputEmail" class=" control-label">CO's remark</label>
                                 </div>
                                 <div class='col-lg-9 col-md-6 col-sm-6 col-xs-6'>
                                    <textarea name="lmremark" class="form-control" rows="5" readonly=""> <?php echo $cormk->process_note; ?></textarea>
                                 </div>
                              </div>
                          <?php }?>


                           <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                                <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>

                                <div class="form-group">
                                <label for="inputEmail" class="col-lg-3">Upload <?=affidavit?></label>
                                <div class="col-lg-3">
                                    <input type='file' name="up_noc" id="up_noc">
                                </div>
                                <div class="col-lg-6 text-bold red" id="err_message"></div>
                                </div>
                              




                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-4 control-label"><?php echo $this->lang->line('lm_report');?> </label>
                                <div class="col-lg-8">
                                    <textarea name="lm_report" class="form-control" rows="5" required></textarea>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">


                            <?php if(!empty($app->basundhara)){ ?>

                                 <center>
                          <button type="submit" name="FormSubmit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <!-- <button class="btn reject btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp; -->
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

<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/basundhara/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
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
                <textarea name='query' class="form-control" placeholder="Please enter your query"></textarea>
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

<script>
  
  $("#lm_save").submit(function(e){
        e.preventDefault();
       
        $.ajax({
            url: baseurl + "NameCancellation/LMStep2_revertsave",
            type:'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType:'json',
            success: function (data) {
                console.log(data);

                if(data.responseType) {
                    alert(data.msg+'.Error: '+data.errorCode);
                    if(data.data.redirectUrl!='') {
                        window.location.href = data.data.redirectUrl;
                    }
                }

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
                    alert("Case has successfully forwarded for case no "+ data.case_no);
                    window.location.href = data.redirect;
                }
            },
            error: function(data){
                alert("Unable to Process");
                
            }
        });
    });


</script>
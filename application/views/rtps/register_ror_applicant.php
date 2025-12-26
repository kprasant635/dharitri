<style type="text/css">
  .mmm{
    padding-top: 5px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
}
  }
</style>
<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">জমাবন্দীৰ নকল'ৰ বাবে আবেদন পঞ্জীকৰণ ফৰ্ম ( Online )</h2>
                  <!--   <input type="text" class="form-control " readonly="readonly" value="<?=$app->date_submission?>"/>

                    <input type="text" class="form-control " readonly="readonly" value="<?=date('Y-m-d G:i:s')?>"/> -->

                    <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6"><p class="uni_text">Location Details </p></div>
                            <div class="col-lg-6"><p class="uni_text text-center">
							
							</p></div>
                        </div>
                    </div>
                    <div class="panel-body">
                       
                     <div class="form-group">
                        <div class="row">
                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                              <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class="control-label"><?php echo $this->lang->line('district'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                   
                                    <input type="text" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getDistrictName($app->dist_code)?>"/>
                                 </div>
                              </div>
                          </div>  

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    
                                    <input type="text"  class="form-control " readonly="readonly" value="<?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?>"/>
                                 </div>
                              </div>
                          </div> 

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                              <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('circle'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                        
                                    <input type="text" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?>"/>
                                 </div>
                              </div>
                          </div>  



                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                  <input type="text" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?>"/>
                                 </div>
                              </div>
                          </div>   

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                              <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class="control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                  <input type="text" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no)?>"/>
                                 </div>
                              </div>
                          </div>  

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <input type="text" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?>"/>
                                 </div>
                              </div>
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
                                  <input type="hidden" class="form-control" name="patta_type_code" readonly="readonly" value="<?=$pattaInfo->patta_type_code?>"/>
                                    <input type="text" class="form-control" readonly="readonly" value="<?=$this->utilityclass->getPattaType($pattaInfo->patta_type_code);?>"/>
                                 </div>
                              </div>
                            </div>
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <input type="text" class="form-control" name="patta_no" readonly="readonly" value="<?=$pattaInfo->patta_no?>"/>
                                 </div>
                              </div>
                            </div>
                          </div>

                          <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>

                         
                            <h2 style="color: #448AFF; padding-left: 15px">Applicant Details</h2>
                           <div class="row">
							             <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Applicant Name</label>
                                <div class="col-lg-4">
                                    <input type="hidden" name="pdar_id" class="form-control " value="<?php echo $firstParty->chitha_pdar_id; ?>">
                                    <input type="text" name="pdar_name" class="form-control " readonly="" value="<?php echo $firstParty->pat_name_ass; ?>">
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('mobile_no'); ?></label>
                                <div class="col-lg-4">
                                    <input type="text" name="mobile_no" id="quantity"  readonly="" maxlength="10" class="form-control "  value="<?php echo $firstParty->pat_mobile_no; ?>">
                                    <span id="errmsg"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Gurdian Name</label>
                                <div class="col-lg-4">
                                    <input type="text" name="guard_name" class="form-control " readonly=""  value="<?php echo $firstParty->pat_gurdian_name_ass; ?>">
                                </div>                                
                                <label for="inputEmail" class="col-lg-2 control-label required">Relation</label>
                                <div class="col-lg-4">
                                   <input type="text" name="" class="form-control " readonly="" value="<?=$this->utilityclass->appRelationbyID($app->dist_code,$firstParty->pat_gurdian_rel_id);?>">
                                </div>
                            </div>
                            
                           
                        
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Service Fee</label>
                                <div class="col-lg-4">
                                    <input type="text" readonly="" class="form-control " name="cert_fees" value="20.00">
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('revenue_done'); ?></label>
                                <div class="col-lg-4">
                                    <label class="radio-inline">
                                        <input type="radio" name="revenue" checked=""  value="Y">  <?php echo $this->lang->line('revenue_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" disabled="" name="revenue" value="N"> <?php echo $this->lang->line('revenue_no'); ?>
                                    </label>
                                </div>
                            </div>
                          </div>
                        </div>

                        <?php if($query){
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

                             <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>

                       <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group">
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/basundhara/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
                          <?php endforeach; ?>
                        </ul>

                        <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
              <br/>
          
            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-4">
                   <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                    <button type="reset" name="" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                    </a>

                    <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/rtps/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
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

<script>
  
  $("#formAjaxPost").submit(function(e){
        e.preventDefault();

       
       
        $.ajax({
            url: baseurl + "Rtps/jamabandiPost",
            type:'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType:'json',
            success: function (data) {
              console.log(data);

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
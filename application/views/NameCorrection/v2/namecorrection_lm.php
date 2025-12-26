<form id='formAjaxPost'>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">
                 <?php 
                  //*************INTEGRATION OF BLOCKCHAIN***************//
                  if(ENABLED_BLOCKCHAIN == 1 &&  in_array($app->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                  {
                     include 'application/views/common/input_hidden_fields_and_func.php';
                  //*************END*************************************//
               }?>
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Name Correction (<?=$case_no?>)</kbd>
                        </h3>
                    </div>
                    <div class="panel-body">

                      
                        <input type="hidden" class="form-control" name='patta_type' value="<?=$app->patta_type_code?>">
                        <input type="hidden" class="form-control" name='patta_no' value="<?=$app->patta_no?>">
                        <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">
                        <input type="hidden" class="form-control" id="application_no" name='application_no' value="<?=$application_no?>">

                        <input type="hidden" name="executionDate" id="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                        <?php if(ESCALATION_ENABLE == 1){ ?>
                            <?php 
                                include(APPPATH."views/escalation/remaining_time.php");
                            ?>
                        <?php } ?>

                      <table class="table table-striped table-bordered">
                        <tr>
                          <td>District Name: <?=$this->utilityclass->getDistrictName($app->dist_code)?></td>
                          <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?></td>
                          <td>Circle Name: <?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?></td>
                        </tr>
                        <tr>
                          <td>Mouza Name: <?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_pargona_code)?></td>
                          <td>Lot Name: <?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_pargona_code,$app->lot_no)?></td>
                          <td>Village Name: <?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_pargona_code,$app->lot_no,$app->vill_townprt_code)?></td>
                        </tr>
                      </table>
                      <?php 
                        if(ESCALATION_ENABLE ==1){
                            include(APPPATH."views/correction/aadhaarInfo.php"); 
                        }                                    
                    ?>

                      

                      <center class="uni_text">Land Area Information</center>

                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No:  </td>
                          <td>Patta Type: </td>
                          <td>Patta No: </td>
                          
                         </tr>

                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($app->patta_type_code)?> </td>
                          <td><?=$app->patta_no?> </td>
                          
                      </table>


                      <center class="uni_text">Name correction</center>

                      <table class="table">
                         <tr class="bg-primary">
                          
                          <td>Old Name : </td>
                           <!-- <td>Guardian Name: </td>
                           <td>Guardian Relation</td> -->
                           <td>Mobile</td>
                         </tr>
                         
                         <tr class="bg-success">
                          <td> <?=$firstparty->petition_pdar_name_old ;?></td>
                          <!-- <td> <?=$sp->gurdian_name_ass ;?></td>
                          <td> <?=$sp->guard_rel_desc_as."(".$sp->guard_rel_desc.")";?></td> -->
                          <td><?=$applicant_info[0]->mobile?></td>

                         </tr>
                       
                      </table>

                      <table class="table">
                         <tr class="bg-primary">
                          
                          <td>Applied Name in English: </td>
                           <td>Applied Name in Assamese: </td>
                         </tr>
                         
                         <tr class="bg-success">
                          <td> <?=$applicant_info[0]->pat_name_eng ;?></td>
                          <td> <?=$firstparty->petition_pdar_name_new ;?></td>
                         
                         </tr>
                      </table>



                      <div class="form-group">
                        <h5>LM remark</h5>
                        <div class="col-sm-12">
                            <textarea id="lm_report" name="lm_report" class="form-control" rows="5"></textarea>
                            <span class="text-danger error co_report_error"></span>
                            <!-- <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $lm->lm_name.", ";?><?php echo "লাট মণ্ডল, "; ?></textarea> -->
                            <!-- <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" > 
                                    <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" > -->
                            </div>
                        </div><br>

                        <!-- /////////ESCALATION REMARK///////////// -->
                      <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $app->es_flag == 1) { ?>
                        <div class="col-lg-12">
                            <div class="form-group col-md-4 text-right">
                                <label> Cause For the case has not been pass in the timeline : </label>
                            </div>
                            <div class="form-group col-md-8">
                                <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                            </div>
                        </div>
                      <?php } ?>


                      <blockquote class="quote-info pt-2 mt-2">
                          <h5>Document(s) Attached</h5>
                        </blockquote>
                         <ul class="list-group" style='margin-bottom: 10px'>
                            <?php foreach($basundharaAttachment as $d): ?>
                             <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
                            <?php endforeach; ?>
                          </ul>
                      <hr>
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

                        <span id='loading'></span><span id='msg'></span>
                        <hr>
                         <center>
                          <button type="submit" class="btn btn-sm btn-primary bhide"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject btn-sm btn-danger hide"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                        <input type="hidden" id="baseurlNew" value="<?=BASE_JS_LINK?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/rtps/RejectOrder" method="post">
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
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/rtps/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
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

<script type="text/javascript">
  $(document).ready(function(){
    $('#formAjaxPost').on('submit', function(event){
      event.preventDefault();
      var selectCo = $("#selectCo");
      var lmremark = $("#lm_report");
      var esc_remark = $("#esc_remark");
      var baseurlN = $("#baseurlNew").val();
      var executionDate = $('#executionDate').val();
      //alert(baseurlN);
      if (selectCo.val() == "") {
          alert("Please select Assign CO!");
          return false;
      }
      if (lmremark.val() == "") {
          alert("Please enter a remark!");
          return false;
      }
      var sendArr = {official: selectCo.val(), application_no: $('#application_no').val(), case_no: $('#case_no').val(),lmremark : lmremark.val(), executionDate : executionDate,esc_remark:esc_remark.val()};
      // console.log(sendArr);return;
      // const formData = new FormData();
      // Object.keys(sendArr).forEach(element => {
      //   formData.append(element, sendArr[element]);
      // });
      // var formData = $(this).serialize();
      $.ajax({
        type        : 'POST', 
        url         : baseurlN+'NameCorrectionV2/namecorrectLMPost', 
        data        : sendArr, 
        dataType    : 'json', 
        encode      : true,
        beforeSend: function(){
            $("#loading").html("Validating ...Please wait...");
            $('.alert').hide();
            // $('.bhide').hide();
        },
        success: function(data){
              console.log(data);
              if(data.success!=null){
                //alert('hai');
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
              }else if(data.error!=null){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
              }
            },
      });
    });
});
</script>

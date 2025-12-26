<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">

    <div class="col-lg-12 parition-basu">
  <div class="col-lg-10 col-lg-offset-1">


      <?php 
      //*************INTEGRATION OF BLOCKCHAIN***************//
      if(ENABLED_BLOCKCHAIN == 1 &&  in_array($app->dist_code,json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
      {
         include 'application/views/common/input_hidden_fields_and_func.php';
      //*************END*************************************//
      }?>

      <div class="card">
          <div class="card-header">
          <h3>
          Registration of <kbd>CONCENSUS PARTITION (<?=$_GET['app']?>)</kbd>
          </h3>
          </div>

          <div class="card-body">

            <div class="card">
              <div class="card-header">Location Details</div>    
              <div class="card-body">
              <table class="table table-striped table-bordered">
                        <tr>
                          <td>District Name: <?=$this->utilityclass->getDistrictName($app->dist_code)?></td>
                          <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($app->dist_code,$app->subdiv_code)?></td>
                          <td>Circle Name: <?=$this->utilityclass->getCircleName($app->dist_code,$app->subdiv_code,$app->cir_code)?></td>
                        </tr>
                        <tr>
                          <td>Mouza Name: <?=$this->utilityclass->getMouzaName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code)?></td>
                          <td>Lot Name: <?=$this->utilityclass->getLotName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no)?></td>
                          <td>Village Name: <?=$this->utilityclass->getVillageName($app->dist_code,$app->subdiv_code,$app->cir_code,$app->mouza_code,$app->lot_no,$app->village_code)?></td>
                        </tr>
                      </table>
              </div>
            </div>

            <div class="card">
              <div class="card-header">Self Declaration & Aadhaar / PAN Information</div>    
              <div class="card-body">
              <?php include 'application/views/common/aadhar_details_dhar_end.php'; ?>
              </div>
            </div>

            <div class="card">
              <div class="card-header">First Party Information</div>    
              <div class="card-body">
              <table class="table">
                         <tr class="bg-primary">
                          <td>Sl No: </td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          <!-- <td>Relation: </td>
                          <td>Gender: </td> -->
                          <td>Mobile: </td>
                         </tr>
                         <?php $j=1; 
                         foreach($firstParty as $sp):
                          ?>
                         <tr class="bg-success">
                          <td><?=$j++?></td>
                          <td><?=$sp->name_ass;?></td>
                          <td><?=$sp->gurdian_name_ass;?></td>
                          <!-- <td><?=$sp->gurdian_relation_id;?></td>
                          <td><?=$sp->gender;?></td> -->
                          <td><?=$sp->mobile;?></td>
                         </tr>
                         <?php endforeach; ?>
                      </table>  
              </div>
            </div>

            <div class="card">
              <div class="card-header">Land Area Information</div>    
              <div class="card-body">
              <?php 
                          ///////////// BARAK VALLEY CODE START HERE ////////////////
                          if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
                      ?>
                              <table class="table">
                                 <tr class="bg-primary">
                                    <td>Dag No:  </td>
                                    <td>Patta Type: </td>
                                    <td>Patta No: </td>
                                    <td colspan="2">Total Area (when applied): </td>
                                 </tr>
                                 <tr class="bg-success">
                                    <td><?=$app->dag_no;?></td>
                                    <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code);?></td>
                                    <td><?=$pattaNo->patta_no?> </td>
                                    <td colspan="2"><?=$pattaNo->dag_area_b;?>B-<?=$pattaNo->dag_area_k;?>K-<?=$pattaNo->dag_area_lc;?>C-<?=$pattaNo->dag_area_g;?>G </td>
                                 </tr>
                                 <tr>
                                   <td class="text-danger">Mutated Area </td>
                                   <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>
                                   <td><input  class="input-num" type="number" required="" name="mut_area_b"  value="<?=$firstParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                                   <td><input  class="input-num" type="number" required="" name="mut_area_k"  value="<?=$firstParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                                   <td><input  class="input-num" type="number" required="" name="mut_area_l" value="<?=$firstParty[0]->area_l;?>" <?=$tag?>/> Chatak </td>
                                   <td><input  class="input-num" type="number" required="" name="mut_area_g" value="<?=$firstParty[0]->area_go;?>" <?=$tag?>/> Ganda </td>
                                 </tr>
                              </table>
                      <?php } else { ?>
                              <table class="table">
                                 <tr class="bg-primary">
                                    <td>Dag No:  </td>
                                    <td>Patta Type: </td>
                                    <td>Patta No: </td>
                                    <!-- <td>Mutated Area: </td> -->
                                    <td>Total Area (when applied): </td>
                                 </tr>
                                 <tr class="bg-success">
                                    <td><?=$app->dag_no;?></td>
                                    <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code);?></td>
                                    <td><?=$pattaNo->patta_no?> </td>
                                    <!-- <td><?=$firstParty[0]->area_b;?>B-<?=$firstParty[0]->area_k;?>K-<?=$firstParty[0]->area_l;?>L </td> -->
                                    <td><?=$pattaNo->dag_area_b;?>B-<?=$pattaNo->dag_area_k;?>K-<?=$pattaNo->dag_area_lc;?>L </td>
                                 </tr>
                                 <tr>
                                   <td class="text-danger">Mutated Area </td>
                                   <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>
                                   <td><input class="input-num" type="number" required="" name="mut_area_b"  value="<?=$firstParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                                   <td><input class="input-num" required="" min="0" max="4" name="mut_area_k"  value="<?=$firstParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                                   <td><input class="input-num" required="" min="0" max="19.99" step="0.01" name="mut_area_l" value="<?=$firstParty[0]->area_l;?>" <?=$tag?>/> Lessa </td>
                                 </tr>
                              </table>
                      <?php } ?>
              </div>
            </div>

            <div class="card">
              <div class="card-header">Document(s) Attached</div>    
              <div class="card-body">
              <ul class="list-group" style='margin-bottom: 10px'>
                          <?php foreach($document as $d): ?>
                           <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
                          <?php endforeach; ?>
               </ul>
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
              </div>
            </div>

            <div class="card">
              <div class="card-header">Remark</div>    
              <div class="card-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
              <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
              <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
              <textarea class="form-control" name="remark" placeholder="Enter your remark"></textarea>
              </div>
            </div>                   
                
          </div>

          <div class="card-footer text-muted">
            <span id="loading"></span><span id="msg"></span>
            <input type="hidden" class="form-control" name='submit_with_more_area' id="submit_with_more_area" value="0">
            <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
            <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
            <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
          </div>
      </div>
  </div>
</div>






    </div>
</div>
</form>
<!-- Modal HTML -->
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
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('query_mdl_message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>

                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<script type="text/javascript">
  
  $(document).ready(function(){
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'rtps/partitionPost', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                        $('.disable_forward').hide();
                        $(".input-num").removeAttr('style');
                    },
            success: function(data){
              if(data.success!=null){
                //alert('hai');
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
              }else if(data.error!=null){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
                $('.disable_forward').show();
                if(data.error == 'Applied area is more then chitha area. Please add Remark and Forward.'){
                  $("#submit_with_more_area").val('1');
                }
                if(data.info!=null)
                {
                  $("#loading").hide();
                  $(".input-num").attr("readonly", false);
                  $('.disable_forward').show();
                  $(".input-num").css('border-color', 'red');
                }
              }
            },
        });
    });
});
</script>
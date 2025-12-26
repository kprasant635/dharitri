<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
          <?php 
            //*************INTEGRATION OF BLOCKCHAIN***************//
            if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
            {
               include 'application/views/common/input_hidden_fields_and_func.php';
            //*************END*************************************//
            }
          ?>
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of Office<kbd>Mutation By Deed  (<?=$_GET['app']?>)</kbd>
                        </h3>
                        <?php
                            if($this->session->flashdata('message')){
                        ?>
<div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
  </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="panel-body">

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
                      <div class="container">
                        <!-- Aadhaar consent Self--- -->
                                <?php include 'application/views/common/aadhar_details_dhar_end.php'; ?>
                    
                      </div>
                      <center class="uni_text">First Party Information</center>
                      <table class="table">
                      	 <tr class="bg-primary">
                      	 	<td>Sl No: </td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          <td>Relation: </td>
                          <td>Gender: </td>
                          <td>Mobile: </td>
                         
                      	 </tr>
                         <?php $i=1;$j=1; foreach($firstParty as $fp): ?>
                         <tr class="bg-success">
                          <td><?=$i++?></td>
                          <td><?=$fp->pat_name_ass;?></td>
                          <td><?=$fp->pat_gurdian_name_ass;?></td>
                          <td><?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                          <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                          <td><?=$fp->pat_mobile_no;?></td>
                          
                         </tr>
                         <?php $j++; endforeach; ?>
                      </table>
                      <center class="uni_text">Second Party Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Sl No: </td>
                          <td>Name: </td>
                          <td>Gurdian: </td>
                          <!-- <td>Relation: </td>
                          <td>Gender: </td>
                          <td>Mobile: </td> -->
                         </tr>
                         <?php $j=1; 
                         foreach($secParty as $sp):
                          ?>
                         <tr class="bg-success">
                          <td><?=$j++?></td>
                          <td><?=$sp->name_ass;?></td>
                          <td><?=$sp->gurdian_name_ass;?></td>
                          
                          <!-- <td><?=$sp->gurdian_relation_id;?></td>
                          <td><?=$sp->gender;?></td>
                          <td><?=$sp->mobile;?></td> -->
                         </tr>
                         <?php endforeach; ?>
                      </table>	
                      <center class="uni_text">Land Area Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No  </td>
                          <td>Patta Type </td>
                          <td>Patta No </td>
                          <td>Total Area </td>
                          <td>NOC Details </td>
                         </tr>
                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code);?></td>
                          <td><?=$pattaNo->patta_no?> </td>
                          <!---#START PLB--->
                          <?php
                          $dist_code = $this->session->userdata('dist_code');
                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                          <td><?=$app->area_b;?>B-<?=$app->area_k;?>K-<?=$app->area_l;?>C-<?=$app->area_g;?>G </td>
                          <?php }
                          else{?>
                          <td><?=$app->area_b;?>B-<?=$app->area_k;?>K-<?=$app->area_l;?>L </td>
                          <?php }?>
                          <td>NOC no : <?=$secParty[0]->noc_no?><br>
                            NOC Date: <?=$secParty[0]->noc_date?>
                          </td>
                         </tr>

                         <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>

                         <?php
                          $dist_code = $this->session->userdata('dist_code');

                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                            <tr>

                           <td><input type="number" required="" name="mut_area_b"  value="<?=$secParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                           <td><input type="number" required="" min="0" max="20" name="mut_area_k"  value="<?=$secParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                           <td><input type="number" required="" min="0" max="16" step="0.01" name="mut_area_l" value="<?=$secParty[0]->area_l;?>" <?=$tag?>/> Chatak </td>
                           <td><input type="number" required="" min="0" max="20" step="0.01" name="mut_area_g" value="<?=$secParty[0]->area_go;?>" <?=$tag?>/> Ganda </td>
                           <td><input type="number" required="" min="0" max="12" step="0.01" name="mut_area_kr" value="<?=$secParty[0]->area_ka;?>" <?=$tag?>/> Kranti </td>
                         </tr>

                        <?php }else{?>
                         <tr>
                           <td class="text-danger" colspan="2">Mutated Area </td>
                           <td><input type="number" required="" name="mut_area_b"  value="<?=$secParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                           <td><input type="number" required="" min="0" max="4" name="mut_area_k"  value="<?=$secParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                           <td><input type="number" required="" min="0" max="19.99" step="0.01" name="mut_area_l" value="<?=$secParty[0]->area_l;?>" <?=$tag?>/> Lessa </td>
                           <td class="hide"><input type="number" required="" min="0" max="20" step="0.01" name="mut_area_g" value="0" <?=$tag?>/> Ganda </td>
                         </tr>
                           <?php }?>
                         <tr>
                       
                           <td class="text-danger" colspan="2">Deed Details </td>
                           <td>Deed No:  <input type="text" required="" name="deed_no"  value="<?=$secParty[0]->deed_no;?>" <?=$tag?>/></td>
                           <td>Deed Date : <input type="text" required="" name="deed_date"  value="<?=$secParty[0]->deed_date;?>" 
                            id="<?=((RTPS_FLAG==1)?'':'DatepickerCO')?>" <?=$tag?>/> </td>
                           <td>Deed Value : <input type="text" required="" name="deed_value" value="<?=$secParty[0]->deed_value;?>" <?=$tag?>/></td>
                         </tr>
                      </table>
                       <div class="alert alert-info">
                        <table>
                          <td>Please Select Transfer Type  : </td>
                          <td width="70%">
                              <select class="" id='mut_type' name="mut_type" required="">
                                  <option value="<?=$secParty[0]->trans_type?>"><?=$this->utilityclass->getTransferType($secParty[0]->trans_type)?></option>
                                  <?php foreach($mut_type as $mut){ ?>
                                    <option value="<?=$mut['trans_code']?>"><?=$mut['trans_desc_as']?></option>
                                  <?php } ?>
                              </select>
                          </td>
                        </table>
                      </div>
                       <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group" style='margin-bottom: 10px'>
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
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
                        <?php if($sro){
                          echo "<center class='uni_text text-danger'>SRO Report</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>SRO Remark</td>
                          <td>Approve/Reject</td><td>Verified Date</td><td>Verified By</td></tr></th>";
                          foreach($sro as $q){
                            ?>
                              <tr>
                                <td><?=$q->remark?></td>
                                <td><kbd><?=$q->approve_reject==1?'Approved':'Rejected';?></kbd></td>
                                <td><?=$q->date_of_verification?></td>
                                <td><?=$q->sro_officer_name;?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                        <input type="hidden" class="form-control" id='appno' name='application_no' value="<?=$app->application_no?>">
                        <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
                        <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 uni_text control-label required" aria-required="true">Assign Recieving Circle Officer</label>
                          <div class="col-sm-5">
                              <select name="add_of_name" class="form-control" required="" aria-required="true" aria-invalid="false">
                              <?php foreach($user as $u){
                               ?>
                              <option value="<?=$u['user_code']?>"><?=$u['username']?> </option>
                              <?php } ?>
                              </select>
                          </div>
                        </div>
                       <hr>   
                        <span id='loading'></span><span id='msg'></span>
                        <center>
                          <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!--  -->
<!-- Modal HTML -->
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
    $(".reject").click(function(event){
            event.preventDefault();
            $("#myModal").modal('show');
            $('#rejectForm').on('submit', function(event){
              event.preventDefault();
              var app=$('#appno').val();
              //alert('hai');
            });
        });
     $(".query").click(function(event){
      event.preventDefault();
            $("#myModal1").modal('show');
      });
    $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'rtps/deedofcPost', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                        $('.disable_forward').hide();
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
                $('.disable_forward').show();
              }
            },
        });
    });
});
</script>
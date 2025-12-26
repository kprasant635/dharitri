<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Mutation By Deed  (<?=$_GET['app']?>)</kbd>
                        </h3>
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
                          <td>Implace/Along With </td>
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
                          <td>
                            <input type="radio"  value="0" name='<?=$sp->chitha_pdar_id;?>'>Along
                            <input type="radio" checked value="1"  name='<?=$sp->chitha_pdar_id?>'>Inplace
                          </td>
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
                          <td>Mutated Area </td>
                          <td>Total Area </td>
                          <td>Deed Details </td>
                          <td>NOC Details </td>
                         </tr>
                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code);?></td>
                          <td><?=$pattaNo->patta_no?> </td>                          
                          <td><?=$secParty[0]->area_b;?>B-<?=$secParty[0]->area_k;?>K-<?=$secParty[0]->area_l;?>L </td>
                          <td><?=$app->area_b;?>B-<?=$app->area_k;?>K-<?=$app->area_l;?>L </td>
                          <td>Deed no : <?=$secParty[0]->deed_no?><br>
                            Deed Date: <?=$secParty[0]->deed_date?><br>
                            Value : <i class="fa fa-rupee"></i> <?=$secParty[0]->deed_value?>
                          </td>
                          <td>NOC no : <?=$secParty[0]->noc_no?><br>
                            NOC Date: <?=$secParty[0]->noc_date?>
                          </td>
                         </tr>
                      </table>
                       <center class="uni_text">Document(s) Attached</center>
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
                        <input type="hidden" class="form-control" name='app_id' value="<?=$app->id?>">
                        <div class="form-group row">
                            <span class="col-lg-6 uni_text red">Do you want to allow re-apply for the rejected application ? </span>
                            <div class="col-lg-6">
                              <input type="hidden" name="rural_urban" id='rural_urban' value="<?=$app->is_urban?>">
                              <?php if($this->session->userdata('user_desig_code') == 'ADC') {?>
                                <label class="checkbox-inline"><input type="radio" checked name='allow_reapply' value="Y"> Yes </label>
                                <label class="checkbox-inline"><input type="radio" name='allow_reapply' value="N"> No</label>
                              <?php } else if($this->session->userdata('user_desig_code') == 'CO'){ ?>
                                <label class="checkbox-inline"><input type="radio" name='allow_reapply' value="Y" required> Send to applicant </label>
                                <label class="checkbox-inline"><input type="radio" name='allow_reapply' value="E" required> Edit and Pass</label>
                              <?php }?>
                            </div>
                            <input type="hidden" class="form-control" name='case_no' value="<?=$_GET['app']?>">
                        </div>
                        <div class="form-group ">
                        <span class="col-lg-3 uni_text">Enter your Remark</span>
                        <textarea class="form-control col-lg-9" rows="5" id='reapply_remark' name='reapply_remark'></textarea>
                        </div>
                        <br>
                        <hr>   
                        <span id='loading'></span><span id='msg'></span>
                        <center>
                          <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Submit</button>&nbsp;
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script type="text/javascript">
  $(document).ready(function(){
  
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    rural_urban=$('#rural_urban').val();

    if($("#reapply_remark").val().trim().length < 1)
    {
      alert("Please Enter Your Remark");
      return; 
    }
    if(rural_urban=='Y'){
      sendurl=baseurl+'rtps/adcApproveRejectOffice';
    }else{
      sendurl=baseurl+'rtps/adcApproveReject';
    }
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : sendurl, 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
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
<form class="hiddenSections">
	<input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
	<input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
	<input type="hidden" class="form-control" name='dag_revenue' value="<?=$pattaNo->dag_revenue?>">
	<input type="hidden" class="form-control" name='dag_local_tax' value="<?=$pattaNo->dag_local_tax?>">
  <input type="hidden" class="form-control" name='land_class_code' value="<?=$pattaNo->land_class_code?>">
	<!-- <input type="hidden" class="form-control" name='sum' value=""> -->
</form>

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
                            Registration of <kbd>Name Cancellation  (<?=$_GET['app']?>)</kbd>
                        </h3>
                    </div>
                    <div class="panel-body">

                      <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                          

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

                      

                      <center class="uni_text">Land Area Information</center>

                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No:  </td>
                          <td>Patta Type: </td>
                          <td>Patta No: </td>
                          <td>Total Area: </td>
                          <td>Revenue </td>
                          
                         </tr>

                         <tr class="bg-success">
                          <td><?=$app->dag_no;?></td>
                          <td><?=$this->utilityclass->getPattaType($pattaNo->patta_type_code)?> </td>
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

                          <!--#END PLB-->
                          <td><i class="fa fa-rupee"></i> <?=number_format($pattaNo->dag_revenue,2);?>+<?=number_format($pattaNo->dag_local_tax,2)?> = <?=number_format($pattaNo->sum,2);?> </td>
                          
                      </table>

                      <!-- <center class="uni_text">Name Cancellation</center> -->

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
                         <?php $i=1; foreach($firstParty as $fp): ?>
                         <tr class="bg-success">
                          <td><?=$i++?></td>
                          <td> <?=$fp->pat_name_ass;?></td>
                          <td> <?=$fp->pat_gurdian_name_ass;?></td>
                          <td> <?=$this->utilityclass->appRelationbyID($app->dist_code,$fp->pat_gurdian_rel_id);?></td>
                          <td><?=$this->utilityclass->gender($fp->pat_gender);?></td>
                          <td><?=$fp->pat_mobile_no;?></td>
                         </tr>
                         <?php endforeach; ?>
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


                      <center class="uni_text">Document(s) Attached</center>
                       <ul class="list-group">
                          <?php foreach($document as $d): ?>
                            <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><li class="list-group-item"><?=$d->name;?></li></a>
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
                       <hr>
                        <div class="col-lg-12">
                            <textarea class="form-control" name='remark' id='reapply_remark' placeholder="Enter your remark"></textarea>        
                        </div>
                         <div>

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
                          <hr>
                       <!--  <center><button type="submit" class="btn btn-info">Submit</button></center> -->
                       <span id='loading'></span><span id='msg'></span>
                        <center>
                          <button type="submit" class="btn btn-sm btn-primary bhide"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject btn-sm btn-danger hide"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        </center>
                      </div>
                        
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
<!--  -->

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
    const dobEl = $('input[name="dob"]')[0];
		const aadhaarEl = $('input[name="aadhaar_no"]')[0];
    const authtypeEl = $('input[name="auth_type"]')[0];

		$('input[name="dob"]').remove();
		$('input[name="aadhaar_no"]').remove();
    $('input[name="auth_type"]').remove();
		
		$('.hiddenSections').append(dobEl);
		$('.hiddenSections').append(aadhaarEl);
    $('.hiddenSections').append(authtypeEl);

    $('#formAjaxPost').on('submit', function(event){
        event.preventDefault();
        if($("#reapply_remark").val().trim().length < 1)
        {
          alert("Please Enter Your Remark");
          return; 
        }
        var selectCo = $("#selectCo");
        if (selectCo.val() == "") {
            alert("Please select Assign CO!");
            return false;
        }
        var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'rtps/namecancelPost', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
              $("#loading").html("Validating ...Please wait...");
              $('.alert').hide();
              // $('.bhide').hide();
            },
            success: function(data){
              console.log(data);
              if(data.responseType==2){
                //alert('hai');
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.msg + '</div>');
                window.location.href = data.data.redirectUrl;
              }else if(data.responseType==1){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.msg + '</div>');
              }
            },
        });
      });
    });
</script>

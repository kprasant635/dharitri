<form id='formAjaxPost'>
<div class="container-fluid login form-top">
    <div class="row">
           <?php 
              //*************INTEGRATION OF BLOCKCHAIN***************//
              if(ENABLED_BLOCKCHAIN == 1 &&  in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
              {
                 include 'application/views/common/input_hidden_fields_and_func.php';
              //*************END*************************************//
           }?>
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">

                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Mutation By Deed  (<?=$_GET['app']?>)</kbd>
                        </h3>
                    </div>
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
                      <center class="uni_text">NOK</center>
                      <table class='table table-bordered'>
                          <thead style="white-space:nowrap; ">
                            <tr class="text-bold bg-primary">
                              <th align='center'>#</th>
                              <th>Applicant Name</th>
                              <th>Gender</th>
                              <th>Date of Birth</th>
                              <th>Guardian Name</th>
                              <th>Guardian Relation</th>
                              <th>Address</th>
                              <th>Action <button type="button" class="btn btn-warning float-end btn-sm" data-target="#nokApplicantModal" data-toggle="modal">Add NOK</button></th>
                            </tr>
                          </thead>
                          <tbody id="applicant_table_show">
                                  <?php $i=1; foreach($nok_temp as $tp){ ?>
                                  <tr class="bg-success">
                                  <td><?=$i++;?></td>
                                  <td><?=$tp->name_asm;?></td>
                                  <td><?=$tp->gender;?></td>
                                  <td><?=$tp->dob;?></td>
                                  <td><?=$tp->guardian_name_asm;?></td>
                                  <td><?=$tp->relation_name;?></td>
                                  <td><?=$tp->address;?></td>
                                  <td><span data-id="<?=$tp->serial_id;?>" id="delete_application_row" class="text-center delete_application_row"><button class="btn btn-danger " type="button"><i class="fa fa-trash"></i></button></span></td>
                                  </tr>
                                  <?php } ?>
                          </tbody>
                      </table>	
                      <center class="uni_text">Land Area Information</center>
                      <table class="table">
                         <tr class="bg-primary">
                          <td>Dag No  </td>
                          <td>Patta Type </td>
                          <td>Patta No </td>
                          <td>Total Area </td>
                          <td colspan="4">NOC Details </td>
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
                          <td colspan="3">NOC no : <?=$secParty[0]->noc_no?><br>
                            NOC Date: <?=$secParty[0]->noc_date?>
                          </td>
                         </tr>


                         <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>

                         <tr>
                          <td class="text-danger" colspan="2">Mutated Area </td>
                          <?php
                          $dist_code = $this->session->userdata('dist_code');
                          if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>

                            <td><input type="number" required="" name="mut_area_b"  value="<?=$secParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                           <td><input type="number" required="" min="0" max="20" name="mut_area_k"  value="<?=$secParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                           <td><input type="number" required="" min="0" max="16" step="0.01" name="mut_area_l" value="<?=$secParty[0]->area_l;?>" <?=$tag?>/> Chatak </td>
                           <td><input type="number" required="" min="0" max="20" step="0.01" name="mut_area_g" value="<?=$secParty[0]->area_go;?>" <?=$tag?>/> Ganda </td>
                           <td><input type="number" required="" min="0" max="12" step="0.01" name="mut_area_kr" value="<?=$secParty[0]->area_ka;?>" <?=$tag?>/> Kranti </td>
                         <?php }
                          else{?>
                            <input type="hidden" min="0" max="20" step="0.01" name="mut_area_g" value="0"/>
                           <td><input type="number" required="" name="mut_area_b"  value="<?=$secParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                           <td><input type="number" required="" min="0" max="4" name="mut_area_k"  value="<?=$secParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                           <td><input type="number" required="" min="0" max="19.99" step="0.01" name="mut_area_l" value="<?=$secParty[0]->area_l;?>" <?=$tag?>/> Lessa </td>
                         <?php }?>
                         </tr>
                         <tr>
                           <td class="text-danger" colspan="2">Deed Details </td>
                           <td>Deed No:  <input type="text" required="" name="deed_no"  value="<?=$secParty[0]->deed_no;?>" <?=$tag?>/></td>
                           <td>Deed Date : <input type="text" required="" name="deed_date"  value="<?=$secParty[0]->deed_date;?>" 
                            id="<?=((RTPS_FLAG==1)?'':'DatepickerCO')?>" <?=$tag?>/> </td>
                            
                           <td>Deed Value : <input type="text" required="" name="deed_value" value="<?=$secParty[0]->deed_value;?>" <?=$tag?>/> </td>
                         </tr>
                      </table>
                      <div class="alert alert-info">
                        <table>
                          <td>Please Select Transfer Type  : </td>
                          <td width="70%">
                              <select class="form-control" id='mut_type' name="mut_type" required="">
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
                          <input type="hidden" class="form-control" id='appno' name='application_no' value="<?=$app->application_no?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$pattaNo->patta_type_code?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$pattaNo->patta_no?>">
                          <textarea class="form-control" name='remark' id='reapply_remark' placeholder="Enter your remark"></textarea>
                       <hr>   
                        <span id='loading'></span><span id='msg'></span>
                        <center>
                          <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward</button>&nbsp;
                          <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
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
<div id="nokApplicantModal" class="modal" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add Applicant</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form class="form-horizontal row p-3" id="nok_applicant" method="post" >
            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                  <label for="inputEmail3"
                  class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('applicants_name') ?></label>
                  <input type="text" class="form-control" required1=""
                  name="name_asm" id="name_asm" autocomplete="off"
                  placeholder="<?php echo $this->lang->line('applicants_name') ?>">
                  <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_name_asm"
                  class="error_class_a"></span>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                  <label for="inputEmail3"
                  class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('gender') ?></label>
                  <select class="form-control relation-type" name="gender" required1
                  id="relation">
                  <option selected disabled value="">Select Gender</option>
                  <?php foreach ($genders as $g): ?>
                     <option value="<?php echo $g->short_name; ?>">
                        <?php echo $g->gen_name_ass; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_gender"
                  class="error_class_a"></span>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                  <label for="inputEmail3"
                  class="uni_text control-label"><?php echo $this->lang->line('date_of_birth') ?></label>
                  <div class="input-group col-sm-12 date datepicker"
                  data-date-format="dd-mm-yyyy">
                  <input type="date" class="form-control" id="dob"
                  placeholder="<?php echo $this->lang->line('date_of_birth') ?>"
                  name="dob" autocomplete="off" />
            </div>
            <span style="color:red; font-size: 14px; padding-top:5px;"
            id="error_a_dob" class="error_class_a"></span>
         </div>
         <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
         <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
            <label for="inputEmail3"
            class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('guardian_name') ?></label>
            <input type="text" class="form-control" required1=""
            name="guardian_name_asm" id="guardian_name_asm" autocomplete="off"
            placeholder="<?php echo $this->lang->line('guardian_name') ?>">
            <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_guardian_name_asm"
            class="error_class_a"></span>
         </div>
         <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
            <label for="inputEmail3"
            class="uni_text control-label required applicant_name_label1"><?php echo $this->lang->line('guardian_relation') ?></label>
            <select class="form-control relation-type" name="relation" required1=""
            id="relation">
            <option selected disabled value="">
                  <?php echo $this->lang->line('select_relation') ?></option>
                  <?php foreach ($relation as $r): ?>
                     <option value="<?php echo $r->guard_rel; ?>">
                        <?php echo $r->guard_rel_desc_as; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_relation"
                  class="error_class_a"></span>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <label for="inputEmail3"
                  class="uni_text control-label required">Address</label>
                  <input type="text" maxlength="100" class="form-control" name="address" id="address" placeholder=" Address">
                  <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_address"
                  class="error_class_a"></span>
            </div>
            <input type='hidden' name='case_id' id="case_id" value='<?php echo $this->input->get('app'); ?>'>
            <span style="color:red; font-size: 14px; padding-top:5px;" id="error_a_case_id"
            class="error_class_a"></span>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
                  <center><button type="submit" class="btn btn-success btnLoc applicant_form"><i
                     class='fa fa-save'></i>&nbsp;Save & Add More
                  </button></center>
            </div>
         </form>
      </div>
   </div>
</div>

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

    $('#nok_applicant').submit(function(e) {
         e.preventDefault();
         if(!confirm("Are you sure you want to add applicant?"))
         {
            return false;
         }
         $.ajax({
            url: baseurl + "lmmutation/FmAddApplicant",
            method: "POST",
            data: $('#nok_applicant').serialize(),
            dataType: "json",
            beforeSend: function () {
               console.log("beforeSend");
            },
            success: function (data) {
               console.log(data);
               if (data.error) {
                     $('.error_class_a').html('');
                     $.each(data.error, function (index, value) {
                        $('#error_a_' + value['field'])
                        .html(value['message']);
                     });
               }
               else if (data.validation_success == 'true' && data.success === true) {
                     $('#nok_applicant').trigger("reset");
                     $('.error_class_a').html('');
                     alert(data.msg);
                        //if (data.nok_tmp) {
                           var nok_tmp_table = '';
                           $.each(data.nok_tmp, function (index, value) {
                                 index++;
                                 nok_tmp_table +=
                                 '<tr class="bg-success">' +
                                 '<td align="center">' + index + '</td>' +
                                 '<td>' + value["name_asm"] + '</td>' +
                                 '<td>' + value["gender"] + '</td>' +
                                 '<td>' + value["dob"] + '</td>' +
                                 '<td>' + value["guardian_name_asm"] + '</td>' +
                                 '<td>' + value["relation_name"] + '</td>' +
                                 '<td>' + value["address"] + '</td>' +
                                 '<td><span data-id="' + value["serial_id"] + '" id="delete_application_row" class="text-center delete_application_row"><button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button></span></td>' +
                                 '</tr>'
                           });
                           console.log(nok_tmp_table);
                           $('#applicant_table_show').html(nok_tmp_table);
                        //}
                     }
                     else
                     {
                        alert(data.msg);
                     }
               },
            error:function(data){
               alert("Something went wrong");
            }
         });
      });

      $(document).on('click', '.delete_application_row', function (e) {
         if (! confirm('Are you sure want to delete this applicant?'))
         {
               return false;
         }
         var row_id = $(this).attr('data-id');
         var obj = this;
         $.ajax({
                  url: baseurl + "lmmutation/DeleteNokTmpFMApp",
                  type : "POST",
                  data : {
                  row_id : row_id,
                  case_id: $('#case_id').val(),
               },
               dataType : "json",
               success: function (data) {
                  console.log(data);
                  if (data === true)
                  {
                     $(obj).parent().parent().remove();
                  }
                  else
                  {
                     alert('Delete failed..!');
                  }
               },
               error:function(data){
                  alert("Something went wrong");
               }
         });
      });

    $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    if($("#reapply_remark").val().trim().length < 1)
    {
      alert("Please Enter Your Remark");
      return; 
    }
    var mut_type = $("#mut_type");
    if (mut_type.val() == "") {
        alert("Please select Transfer Type!");
        return false;
    }
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'rtps/deedPost', 
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
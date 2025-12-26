<style type="text/css">
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>application/views/images/load.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .9;
    }
</style>
<?php
    $rtps;
?>
<div class="loader"></div> 
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Field Partition 
                    </h2>
                </div>
            </div>
           
            <form id='formAjaxPost'>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        
                        <div class="col-lg-12">
                            <div class="text-center">
                                <b class="text-red"> Case no. :<?=$case_no?></b>
                            </div>
                            <?php if(ESCALATION_ENABLE ==1){ ?>
                                <input type="hidden" name="executionDate" id="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">
                                
                                <?php 
                                  include(APPPATH."views/escalation/remaining_time.php");
                                ?>

                            <?php } ?>
                            <div class="mb-3 text-center">
                                <a target="__blank"  href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $fmd[0]->dag_no . '&m=' . $fmb['mouza_pargona_code'] . '&l=' . $fmb['lot_no'] . '&v=' . $fmb['vill_townprt_code'] . '&p=' . $fmd[0]->patta_type_code . '&dist=' . $fmb['dist_code'] . '&cir=' . $fmb['cir_code'] . '&sub_div=' . $fmb['subdiv_code'] ?>" class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                                <br>
                            </div>
                            
                                <table class="table">
                                    <tr class="table-primary">
                                        <td>District Name: <?=$this->utilityclass->getDistrictName($fmb['dist_code'])?></td>
                                        <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($fmb['dist_code'],$fmb['subdiv_code'])?></td>
                                        <td>Circle Name: <?=$this->utilityclass->getCircleName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'])?></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Mouza Name: <?=$this->utilityclass->getMouzaName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'])?></td>
                                        <td>Lot Name: <?=$this->utilityclass->getLotName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'])?></td>
                                        <td>Village Name: <?=$this->utilityclass->getVillageName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'],$fmb['vill_townprt_code'])?></td>
                                    </tr>
                                </table>

                                <?php 
                                    if(ESCALATION_ENABLE ==1){
                                        include(APPPATH."views/correction/aadhaarInfo.php"); 
                                    }                                    
                                ?>

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
                                 foreach($applicant as $sp):

                                    $applicant_mobile = json_decode($sp->applicant_info);
                                  ?>
                                 <tr class="bg-success">
                                  <td><?=$j++?></td>
                                  <td><?=$sp->pdar_name;?></td>
                                  <td><?=$sp->pdar_guardian;?></td>
                                  <!-- <td><?=$sp->gurdian_relation_id;?></td>
                                  <td><?=$sp->gender;?></td> -->
                                  <td><?=$applicant_mobile->mobile;?></td>
                                 </tr>
                                 <?php endforeach; ?>
                              </table>  
                      <center class="uni_text">Land Area Information</center>


                       <?php 
                          ///////////// BARAK VALLEY CODE START HERE ////////////////
                          if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){ 
                      ?>
                              <table class="table">
                                 <tr class="bg-primary">
                                    <td>Dag No:  </td>
                                    <td>Patta Type: </td>
                                    <td>Patta No: </td>
                                    <td colspan="2">Total Area: </td>
                                 </tr>
                                 <tr class="bg-success">
                                    <td><?=$fmd[0]->dag_no;?></td>
                                    <td><?=$this->utilityclass->getPattaType($fmd[0]->patta_type_code);?></td>
                                    <td><?=$fmd[0]->patta_no?> </td>
                                    <td colspan="2"><?=$fmd[0]->dag_area_b;?>B-<?=$fmd[0]->dag_area_k;?>K-<?=$fmd[0]->dag_area_lc;?>C-<?=$fmd[0]->dag_area_g;?>G </td>
                                 </tr>
                                 <tr>
                                   <td class="text-danger">Mutated Area </td>
                                   <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>
                                   <td><input type="number" required="" name="mut_area_b"  value="<?=$firstParty[0]->area_b;?>" <?=$tag?>/> Bigha</td>
                                   <td><input type="number" required="" name="mut_area_k"  value="<?=$firstParty[0]->area_k;?>" <?=$tag?>/> Katha </td>
                                   <td><input type="number" required="" name="mut_area_l" value="<?=$firstParty[0]->area_l;?>" <?=$tag?>/> Chatak </td>
                                   <td><input type="number" required="" name="mut_area_g" value="<?=$firstParty[0]->area_go;?>" <?=$tag?>/> Ganda </td>
                                 </tr>
                              </table>
                      <?php } else {
                       ?>
                              <table class="table">
                                 <tr class="bg-primary">
                                    <td>Dag No:  </td>
                                    <td>Patta Type: </td>
                                    <td>Patta No: </td>
                                    <td>Total Area: </td>
                                 </tr>
                                 <tr class="bg-success">
                                    <td><?=$fmd[0]->dag_no;?></td>
                                    <td><?=$this->utilityclass->getPattaType($fmd[0]->patta_type_code);?></td>
                                    <td><?=$fmd[0]->patta_no?> </td>
                                
                                    <td><?=$fmd[0]->dag_area_b;?>B-<?=$fmd[0]->dag_area_k;?>K-<?=$fmd[0]->dag_area_lc;?>L </td>
                                 </tr>
                                 <tr>
                                   <td class="text-danger">Mutated Area </td>
                                   <?php if(RTPS_FLAG==1){ $tag='readonly'; } else { $tag='';} ?>
                                   <td><input type="number" required="" name="mut_area_b"  value="<?=$fmd[0]->m_dag_area_b;?>" <?=$tag?>/> Bigha</td>
                                   <td><input type="number" required="" min="0" max="4" name="mut_area_k"  value="<?=$fmd[0]->m_dag_area_k;?>" <?=$tag?>/> Katha </td>
                                   <td><input type="number" required="" min="0" max="19.99" step="0.01" name="mut_area_l" value="<?=$fmd[0]->m_dag_area_lc;?>" <?=$tag?>/> Lessa </td>
                                 </tr>
                              </table>
                      <?php } ?>
                      <div class="col-lg-12">
                        <div class="form-group col-md-4 text-right">
                            <label> Remarks : </label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea class="form-control" name='remark' id='reapply_remark' placeholder="Enter your remark"></textarea>
                            <span class="error_remark" style="color: red;"></span>
                        </div>
                      </div>

                      <!-- /////////ESCALATION REMARK///////////// -->
                      <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE == 1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $fmb['es_flag'] == 1 && $fmb['out_of_esc'] == 0) { ?>
                        <div class="col-lg-12">
                            <div class="form-group col-md-4 text-right">
                                <label> Cause For the case has not been pass in the timeline : </label>
                            </div>
                            <div class="form-group col-md-8">
                                <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                            </div>
                        </div>
                      <?php } ?>
                       <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                        <br>                         
                        <hr>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <center class='text-danger text-bold'><b>View Supportive Document</b></center>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <?php foreach($sup_doc as $doc) { ?>
                                    <tr>
                                        <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                        <td>
                                           <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank" download>Click to View</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } 
                        //include(APPPATH."views/common/addMoreDocumentView.php");
                        //echo APPPATH."views/common/addMoreDocumentView.php";
                        ?>
                        <?php include(APPPATH.'views/multipleUpload.php')?>
                        <blockquote class="quote-info pt-2 mt-2">
                          <h5>Document(s) Attached</h5>
                        </blockquote>
                         <ul class="list-group" style='margin-bottom: 10px'>
                            <?php foreach($basundharaAttachment as $d): ?>
                             <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
                            <?php endforeach; ?>
                          </ul>
                        
                        <hr>
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
                      
                          <input type="hidden" class="form-control" name='application_no' value="<?=$application->basundhara?>">
                          <input type="hidden" class="form-control" name='patta_type' value="<?=$fmd[0]->patta_type_code?>">
                          <input type="hidden" class="form-control" name='patta_no' value="<?=$fmd[0]->patta_no?>">

                       <hr>   
                          <span id='loading'></span><span id='msg'></span>
                         <center>
                          <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check'></i> Forward to CO</button>&nbsp;
                          <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>&nbsp;
                          <!-- <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button> -->
                        </center>
                      </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<style type="text/css">
    .table-primary> td {
        background-color: #338AFF !important;
        color:#fff; 
    }
    .table-info>td {
        background-color: #CFBCA3 !important;
        color:#fff; 
    }
    .table-warning>td {
        background-color: #64856B !important;
        color:#fff; 
    }
    .table-success>td {
        background-color: #7A7C78 !important;
        color:#fff; 
    }
</style>
<script type="text/javascript">
        $(window).load(function() {
             $(".loader").fadeOut();
             //$('.disable_forward').hide();
        });
        $(document).ajaxStart(function(e){
            $(".loader").fadeOut();
        });
        $(document).ajaxComplete(function(e){
           $(".loader").fadeOut();
        });
    </script>

  <script type="text/javascript">
  $(document).ready(function(){
  ////////////////////

  $("#seeJamaClick").click(function(event){
    // alert("hii");
    $('#seeJama').submit();
  });

});
</script>
<script type="text/javascript">
  $(document).ready(function(){
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    $(".error_remark").html("");
    if($("#reapply_remark").val().trim().length < 1)
    {
      alert("Please Enter Your Remark");
      $(".error_remark").html("<b><i class='fa fa-info'></i> Please Enter Your Remark</b>");
      return; 
    }

    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'COFieldMutation/partitionPost', 
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
              }
            },
        });
    });
});
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
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
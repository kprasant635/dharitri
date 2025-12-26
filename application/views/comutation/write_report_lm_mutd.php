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
                        Field Mutation 
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
                                <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
                                
                                <?php 
                                  include(APPPATH."views/escalation/remaining_time.php");
                                ?>

                            <?php } ?>
                            <div class="mb-3 text-center">
                                <a target="__blank"href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $fmd[0]['dag_no'] . '&m=' . $fmb['mouza_pargona_code'] . '&l=' . $fmb['lot_no'] . '&v=' . $fmb['vill_townprt_code'] . '&p=' . $fmd[0]['patta_type_code'] . '&dist=' . $fmb['dist_code'] . '&cir=' . $fmb['cir_code'] . '&sub_div=' . $fmb['subdiv_code'] ?>" class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                                <br>
                            </div>
                            </div>
                            <input type="hidden" name="case_no" id="case_no" value="<?=$case_no?>">
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
                                    if(AADHAAR_DOC_ENV == 'PROD' && ESCALATION_ENABLE ==1){
                                        include(APPPATH."views/correction/aadhaarInfo.php"); 
                                    }                                    
                                ?>

                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                          <th colspan="5" style="text-align:center;">First Party Information</th>
                                        </tr>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Address</td>
                                            <td>Aadhaar/PAN Status</td>
                                            <td>Mobile: </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($applicant as $app) :
                                            if($app['auth_type'] !=null){
                                                $status  = $app['auth_type']. " Verified";
                                                $engName = $app['pdar_name_eng'];
                                                
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                                $base64_decoded_adhar_file = null;
                                            }
                                            ?>
                                        <tr>
                                            <td><?=$app['pet_name']?></td>
                                            <td><?=$app['guard_name']?></td>
                                            <td><?=$this->utilityclass->appRelation($app['guard_rel'])?></td>
                                            <td><?=$app['add1'].$app['add2']?></td>
                                            <td style="color:green">
                                                <div class="">
                                                    <?=$engName?>
                                                </div><b><?=$status?></b>
                                            </td>
                                            <td><?=$app['pdar_mobile']?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                          <th colspan="3" style="text-align:center;">Second Party Information</th>
                                        </tr>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Implace/Along With </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($seller as $app) :?>
                                        <tr>
                                            <td><?=$app['pdar_name']?></td>
                                            <td><?=$app['pdar_guardian']?></td>
                                            <td>
                                                <input type="radio"  value="0" name='stk[<?=$app['pdar_id'];?>]'>Along
                                                <input type="radio"  value="1" checked name='stk[<?=$app['pdar_id'];?>]'>Inplace
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                               
                                <table class="table">
                                    <thead><tr><th colspan="4" class="text-center">Land area Information</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($fmd as $dag) :?>
                                        <tr class="table-primary">
                                            <td>Patta Type: <?=$this->utilityclass->getPattaName($dag['patta_type_code'])?> </td>
                                            <td>Patta No: <?=$dag['patta_no']?></td>
                                            <td colspan="4">Dag No: <?=$dag['dag_no']?> <br> [ NOC Details <?=$fmb['noc_no']?> <?=$fmb['noc_date']?> ]</td>
                                     
                                        </tr>
                                        
                                        <input type="hidden" name="trans_code" value="<?=$fmb['trans_code']?>">
                                        <?php
                                            //echo $fmb['trans_code'];
                                            if($fmb['reg_deed_no']!=null || !empty($fmb['reg_deed_no'])){ 
                                            $deed=true;
                                            //echo $fmb['reg_deed_date'];
                                            ?>
                                        <tr class="table-success">

                                            <td>Deed No: <input type="text" name="reg_deed_no" value=<?=$fmb['reg_deed_no']==null?0:$fmb['reg_deed_no']?> readonly>  </td>
                                            <td>Deed Date: <input type="text" name="reg_deed_date" value=<?=$fmb['reg_deed_date']==null?0:$fmb['reg_deed_date']?>  readonly></d>
                                            <td colspan="4">Deed Value: <input type="text" name="deed_value" value=<?=$fmb['deed_value']==null?0:$fmb['deed_value']?> readonly></td>
                                        </tr>
                                            <?php
                                            }else{
                                                $deed=false;$hide=null;
                                            } 
                                            ?>


                                        <!--//#START PLB--->
                                        <?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>

                                         <tr class="table-info">
                                            <td>Applied Bigha: <input type="text" name="applied_b" readonly value=<?=$dag['m_dag_area_b']==null?0:$dag['m_dag_area_b']?> >  </td>
                                            <td>Applied Katha: <input type="text" maxlength="4" name="applied_k" value=<?=$dag['m_dag_area_k']==null?0:$dag['m_dag_area_k']?> ></d>
                                            <td>Applied Chatak: <input type="text" maxlength="19" name="applied_lc" value=<?=$dag['m_dag_area_lc']==null?0:$dag['m_dag_area_lc']?> ></td>
                                            <td>Applied Ganda: <input type="text" maxlength="19" name="applied_g" value=<?=$dag['m_dag_area_g']==null?0:$dag['m_dag_area_g']?> ></td>
                                            <td>Applied Kranti: <input type="text" maxlength="19" name="applied_kr" value=<?=$dag['m_dag_area_kr']==null?0:$dag['m_dag_area_kr']?> ></td>
                                        </tr>
                                        
                                        <tr class="table-info hide">
                                            <td>Mutated Area Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Mutated Area Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Mutated Area Lessa: <?= $dag['m_dag_area_lc']?></td>
                                            <td>Mutated Area Ganda: <?= $dag['m_dag_area_g']?></td>
                                            <td>Mutated Area Kranti: <?= $dag['m_dag_area_kr']?></td>

                                        </tr>
                                        <tr class="table-warning">
                                            <td>Total Bigha: <?= $dag['dag_area_b']?> </td>
                                            <td>Total Katha: <?=$dag['dag_area_k']?></td>
                                            <td>Total Chatak: <?=number_format($dag['dag_area_lc'],2)?></td>
                                            <td>Total Ganda: <?=number_format($dag['dag_area_g'],2)?></td>
                                            <td>Total kranti: <?=number_format($dag['dag_area_kr'],2)?></td>
                                        </tr>

                                        <?php }
                                        else{?>    

                                        
                                        
                                        <tr class="table-info">
                                            <td>Mutated Area Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Mutated Area Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Mutated Area Lessa: <?= $dag['m_dag_area_lc']?></td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>Total Bigha: <?= $dag['dag_area_b']?> </td>
                                            <td>Total Katha: <?=$dag['dag_area_k']?></td>
                                            <td>Total Lessa: <?=number_format($dag['dag_area_lc'],2)?></td>
                                        </tr>
                                    <?php }?>

                                         <!--//#END PLB--->
                                        <tr class="table-success">
                                            <td>Rajah Adalat: <?=$fmb['rajah_adalat']=='0' ?'No':'Yes'?> </td>
                                            <td colspan="5">Dispute: <?=$fmb['dispute_yn']=='0' ?'No':'Yes'?></td>
                                            
                                        </tr>
                                       
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                        </div>
                        
                       <div class="row">
                        <table>
                            <tr>
                                <td class="text-right">Please Select Transfer Type  : </td>
                                <td width="70%">
                                    <select class="form-control" id='mut_type' name="mut_type" required="">
                                        <option value="">==SELECT MUTATION==</option>
                                      <?php foreach($mut_type as $mut){ 
                                        if($fmb['trans_code'] == $mut['trans_code']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }


                                        ?>

                                        <option value="<?=$mut['trans_code']?>" <?=$selected?>><?=$mut['trans_desc_as']?></option>
                                      <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        

                      </div>
                      <div class="row" style="margin-top: 32px;">
                        <div class="col-lg-10 uni_text">
                            <div class="col-lg-7 red ">Applicant has Possession (Please select the right option) </div>
                            <input type="radio" checked  name="possession" value="y"> Yes &nbsp;&nbsp;&nbsp;
                            <input type="radio"   name="possession" value="n"> No
                        </div>



                      </div>
                      <div class="col-lg-12">
                        <div class="form-group col-md-4 text-right">
                            <label> Remarks : </label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea class="form-control" name='remark' id='reapply_remark' placeholder="Enter your remark"></textarea>
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

                        <blockquote class="quote-info pt-2 mt-2">
                          <h5>Document(s) Attached</h5>
                        </blockquote>
                         <ul class="list-group" style='margin-bottom: 10px'>
                            <?php foreach($basundharaAttachment as $d): ?>
                             <li class="list-group-item"> <a target='download' href="<?php echo base_url(); ?>index.php/rtps/document/<?=$d->name;?>"><i class="fa fa-paperclip"></i> <?=$d->name;?></a></li>
                            <?php endforeach; ?>
                          </ul>
                        
                        <hr>
                        <div>
                    <?php if($basuCase){ ?>
                    <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        <?php } ?>
                           <!--  <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                            }                               
                            ?> -->

                            <?php
                             if($query){
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
                                    echo "<a target='download' href='".base_url()."index.php/basundhara/document/".$q->app_doc_id."'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; }?>
                        <?php if($sro){
                          $hide=null;
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
                    </div>
                    <hr>
                        <?php
                        if(empty($sro) and $deed==true and $rtps!='RTPS'){
                         if($apps->pending_with_officer!='SRO'){
                            $hide=null;
                          ?>
                            <a href="<?php echo base_url()."index.php/basundhara/pushSro?app=$basuCase&c=$_GET[case_no]" ?>" class="green" onclick="if (!confirm('Are you sure want to continue ?')) { return false; }"><i class='fa fa-asterisk'></i>&nbsp;Push to SRO (Click to send SRO Office)</a>
                            <?php }else{
                                $hide='hide';
                                echo "<p class='text-info'>Forwarded to SRO Office for Deed Verification</p>";
                            }
                        } ?>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn disable_forward btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Forward to CO</button>&nbsp;
                              <button class="btn reject hide btn-sm btn-danger"><i class='fa fa-arrows-alt'></i> Reject Application</button>
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
            url         : baseurl+'COFieldMutation/deedPost', 
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
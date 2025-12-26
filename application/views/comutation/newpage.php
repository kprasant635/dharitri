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
        <?php
        $buttonEnabledFlag =1;
        if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
        {
            include 'application/views/common/input_hidden_fields_and_func.php';
        }
        ?>
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Field Mutation
                    </h2>
                </div>
            </div>
            <div class="error_container">
                        <?php
                            if($this->session->flashdata('message_extra')){
                        ?>
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message_extra'); ?>
                                </strong>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
            <form id="seeJama" action="<?php echo base_url()?>index.php/JamabandiControllerBondita/saveJamabandiByEnteringPattano" method="POST" target="_blank">
                <input type="hidden" name="dist_code" value="<?=$fmb['dist_code']?>">
                <input type="hidden" name="subdiv_code"  value="<?=$fmb['subdiv_code']?>">
                <input type="hidden" name="circle_code" value="<?=$fmb['cir_code']?>">
                <input type="hidden" name="mouza_code" value="<?=$fmb['mouza_pargona_code']?>">
                <input type="hidden" name="lot_no" value="<?=$fmb['lot_no']?>">
                <input type="hidden" name="vill_code" value="<?=$fmb['vill_townprt_code']?>">
                <input type="hidden" name="patta_type" value="<?=$fmd[0]['patta_type_code']?>">
                <input type="hidden" name="patta_no" value="<?=$fmd[0]['patta_no']?>">
            </form>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <b style="float:right;background: #fff57f;padding: 4px;">Chitha and Jamabandi Details</b>
                <br>
                <div class="col-lg-12">
                <a style="float:right" target="_blank" href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $fmd[0]['dag_no'] . '&m=' . $fmb['mouza_pargona_code'] . '&l=' . $fmb['lot_no'] . '&v=' . $fmb['vill_townprt_code'] . '&p=' . $fmd[0]['patta_type_code'] . '&dist=' . $fmb['dist_code'] . '&cir=' . $fmb['cir_code'] . '&sub_div=' . $fmb['subdiv_code'] ?>">
                             <i class="fa fa-link" aria-hidden="true"></i><u><span class="text-primary" style="font-size:16px;">Dag No. <?=$fmd[0]['dag_no']?> (Chitha View)</span></u>
                          </a>
                </div>
                <div class="col-lg-12">
                <button style="float:right" id="seeJamaClick">
                     <i class="fa fa-link" aria-hidden="true"></i>
                     <span class="text-primary" style="font-size:16px;color:#ffb81d">Patta No. <?=$fmd[0]['patta_no']?> (Jamabandi View)</span>
                </button>
                </div>
                
            </div>
            <form id='submitFieldPost' action="<?php echo base_url() ?>index.php/cofieldmutation/passOrderNew" enctype="multipart/form-data" method="POST">
            <div class="col-lg-12">
                <?php if(ESCALATION_ENABLE == 1){?>
                    <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                    <?php 
                      include(APPPATH."views/escalation/remaining_time.php");
                    ?>
                <?php } ?>
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        
                        <div class="col-lg-12">
                            <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            {
                                if($propChainEnableFlag)
                                {
                                include 'application/views/common/propertyCheckDetails.php';
                                }

                            }?>
                            <center><h4><u>Location Details</u></h4></center>
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
                                <center><h4><u>First Party Information</u></h4></center>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Address</td>
                                            <td>Aadhaar/PAN Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($applicant as $app) :
                                            if($app['auth_type'] !=null){
                                                $status = $app['auth_type']. " Verified";
                                                $engName = $app['engName'];
                                            }else{
                                                $status = 'N/A';
                                                $engName = null;
                                            }
                                            ?>
                                        <tr>
                                            <td><?=$app['pet_name']?></td>
                                            <td><?=$app['guard_name']?></td>
                                            <td><?=$this->utilityclass->appRelation($app['guard_rel'])?></td>
                                            <td><?=$app['add1'].$app['add2']?></td>
                                            <td style="color:green"><?=$engName?><br><b><?=$status?></b></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <center><h4><u>Second Party Information</u></h4></center>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Inplace/Alongwith</td>
                                            <td>Type</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($seller as $app) :?>
                                        <tr>
                                            <td><?=$app['pdar_name']?></td>
                                            <td><?=$app['pdar_guardian']?></td>
                                            <input type="hidden" name="pattadar_id[]" value="<?=$app['pdar_id']?>">
                                            <td><?php $app['striked_out']; ?>
                                            <select name="inplace_alongwith[]" class="form-control" required="">
                                            <option value="1" <?php
                                            if ($app['striked_out'] == 1) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $this->lang->line('inplace') ?></option>
                                            <option value="0" <?php
                                            if (($app['striked_out'] == 0)) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $this->lang->line('along_with') ?></option>
                                            <option value="555" <?php
                                            if (($app['striked_out'] == null)) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo "Please Select One Option" ?></option>
                                        </select>
                                            </td>
                                            <td><?=$this->utilityclass->getTransferType($fmb['trans_code'])?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <center><h4><u>Land Details</u></h4></center>
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($fmd as $dag) :?>
                                        <tr class="table-primary">
                                            <td>Patta Type: <?=$this->utilityclass->getPattaName($dag['patta_type_code'])?> </td>
                                            <td>Patta No: <?=$dag['patta_no']?></td>
                                            <td colspan="4">Dag No: <?=$dag['dag_no']?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-danger"><center><b>Please Update the Details if it's incorrect</b></center></td>
                                        </tr>
                                        <input type="hidden" name="trans_code" value="<?=$fmb['trans_code']?>">
                                        <?php
                                            //echo $fmb['trans_code'];
                                            if($fmb['reg_deed_no']!=null || !empty($fmb['reg_deed_no'])){ 
                                            $deed=true;
                                            //echo $fmb['reg_deed_date'];
                                            ?>
                                        <tr class="table-success">

                                            <td>Deed No: <input type="text" name="reg_deed_no" value=<?=$fmb['reg_deed_no']==null?0:$fmb['reg_deed_no']?> >  </td>
                                            <td>Deed Date: <input type="text" name="reg_deed_date" value=<?=$fmb['reg_deed_date']==null?0:$fmb['reg_deed_date']?> id='DatepickerCO' ></d>
                                            <td colspan="4">Deed Value: <input type="text" name="deed_value" value=<?=$fmb['deed_value']==null?0:$fmb['deed_value']?> ></td>
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
                                            <td>Applied Bigha: <input type="text" name="applied_b" value=<?=$dag['m_dag_area_b']==null?0:$dag['m_dag_area_b']?> >  </td>
                                            <td>Applied Katha: <input type="text" maxlength="4" name="applied_k" value=<?=$dag['m_dag_area_k']==null?0:$dag['m_dag_area_k']?> ></d>
                                            <td>Applied Chatak: <input type="text" maxlength="19" name="applied_lc" value=<?=$dag['m_dag_area_lc']==null?0:$dag['m_dag_area_lc']?> ></td>
                                            <td>Applied Ganda: <input type="text" maxlength="19" name="applied_g" value=<?=$dag['m_dag_area_g']==null?0:$dag['m_dag_area_g']?> ></td>
                                            <td>Applied Kranti: <input type="text" maxlength="19" name="applied_kr" value=<?=$dag['m_dag_area_kr']==null?0:$dag['m_dag_area_kr']?> ></td>
                                        </tr>
                                        
                                        <tr class="table-info hide">
                                            <td>Applied Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Applied Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Applied Lessa: <?= $dag['m_dag_area_lc']?></td>
                                            <td>Applied Ganda: <?= $dag['m_dag_area_g']?></td>
                                            <td>Applied Kranti: <?= $dag['m_dag_area_kr']?></td>

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
                                            <td>Applied Bigha: <input type="text" name="applied_b" value=<?=$dag['m_dag_area_b']==null?0:$dag['m_dag_area_b']?> >  </td>
                                            <td>Applied Katha: <input type="text" maxlength="4" name="applied_k" value=<?=$dag['m_dag_area_k']==null?0:$dag['m_dag_area_k']?> ></d>
                                            <td>Applied Lessa: <input type="text" maxlength="19" name="applied_lc" value=<?=$dag['m_dag_area_lc']==null?0:$dag['m_dag_area_lc']?> ></td>
                                        </tr>
                                        
                                        <tr class="table-info hide">
                                            <td>Applied Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Applied Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Applied Lessa: <?= $dag['m_dag_area_lc']?></td>
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
                                            <td>Dispute: <?=$fmb['dispute_yn']=='0' ?'No':'Yes'?></td>
                                            <td colspan="4">Possession: <?=$fmb['possession_yn']==null ?'':'Have Possession'; ?></td>
                                        </tr>
                                        <tr class="table-success">
                                            <!-- <td colspan="3">Mondal  Note: <?= $dag['remark']?> </td> -->
                                            <td colspan="5">Land Records Assistant Note: <?=$lm_remark?> </td>
                                           </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                        </div>
                        <div class="col-lg-12">
                            <label class="col-sm-4">
                                Land Records Assistant's Name : <?php $lmName=$this->utilityclass->getDefinedMondalsName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'],$fmb['user_code']);
                                echo $lmName->lm_name;
                                ?> </label>
                            <label class="col-sm-4 rasid">
                                Mondal Note Date : <?=$fmb['date_entry']?>
                            </label>
                        </div>

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
                        include(APPPATH."views/common/addMoreDocumentView.php");
                        //echo APPPATH."views/common/addMoreDocumentView.php";
                        ?>
                        <hr>

                        <!-- /////////ESCALATION REMARK///////////// -->
                      <?php if (ESCALATION_ENABLE == 1 && ESCALATION_REMARK_ENABLE ==1 && isset($escRemarkData) && !empty($escRemarkData) && $escRemarkData->remark_status == null && $fmb['es_flag'] == 1 && $fmb['out_of_esc'] == 0) { ?>
                        <div class="col-lg-12">
                            <div class="form-group col-md-4 text-right">
                                <label> Cause For the case has not been pass in the timeline : </label>
                            </div>
                            <div class="form-group col-md-8">
                                <textarea class="form-control" name='esc_remark' id='esc_remark' placeholder="Enter your cause"></textarea>
                            </div>
                        </div>
                      <?php } ?>
                        <div>
                    <?php if($basuCase){ ?>
                    <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                        <?php } ?>
                            <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                            }                               
                            ?>

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
                            <h2><a href="<?php echo base_url()."index.php/basundhara/pushSro?app=$basuCase&c=$_GET[case_no]" ?>" class="green" onclick="if (!confirm('Are you sure want to continue ?')) { return false; }"><i class='fa fa-asterisk'></i>&nbsp;Push to SRO (Click to send SRO Office)</a></h2>
                            <?php }else{
                                $hide='hide';
                                echo "<p class='text-info'>Forwarded to SRO Office for Deed Verification</p>";
                            }
                        } ?>

                        <?php
                        if(empty($sro) and $deed==true){
                          ?>
                            <a href="<?php echo base_url()."index.php/COFieldMutation/pushSroNgdrs?app=$basuCase&case_no=$_GET[case_no]" ?>" class="green" onclick="if (!confirm('Are you sure want to continue ?')) { return false; }"><i class='fa fa-asterisk'></i>&nbsp;Push to SRO (Click to send SRO Office)</a>
                        <?php } ?>
                        <hr>
                       <?php if($tempNok and ($tempNok[0]['approve_reject']==0 || $tempNok[0]['approve_reject']==1)){
                        ?>
                            <div class="alert alert-danger">
                                <form id='formAjaxPost' method="post">
                                    <table class="table">
                                        <thead><tr>
                                            <td>Sl No</td>
                                            <td>Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Gender</td>
                                            <td>DOB</td>
                                        </tr></thead>
                                        <tbody>
                                            <?php $i=1; foreach($tempNok as $temp){ ?>
                                                <tr>
                                                    <td><?=$i++?></td>
                                                    <td><?=$temp['name_asm']?></td>
                                                    <td><?=$temp['guardian_name_asm']?></td>
                                                    <td><?=$this->utilityclass->get_relation($temp['relation'])?></td>
                                                    <td><?=$temp['gender']?></td>
                                                    <td><?=$temp['dob']?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <input type='hidden' id="case_no" value='<?=$_GET['case_no']?>' name='case_no' />
                                    <?php if($tempNok and $tempNok[0]['approve_reject']==0){ ?>
                                        <div class="form-control alert alert-info" style="padding-top: 6px">
                                            <div class="col-sm-2">
                                                <input type="radio" class="co_status"  name="co_status" checked="" value="1"> Approve
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="radio" class="co_status" name="co_status" value="0"> Revert to LM
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="radio" class="co_status" name="co_status" value="2"> Cancel
                                            </div>
                                        </div>
                                       <center><button id='submitNoK' class="btn btn-sm btn-success" name="submit">Submit Status</button></center> 
                                    <?php } ?>
                                </form>
                            </div>
                            <?php }
                             if($tempNok and $tempNok[0]['approve_reject']==1 ){
                                $disable=null;
                                $now = time(); // or your date as well
                                $your_date = strtotime($tempNok[0]['co_approve_date']);
                                $datediff = $now - $your_date;
                                echo "<p class='text-danger uni_text'><b>No. of day(s) for Objection of NOK Approval by Applicant passed <kbd>". round($datediff / (60 * 60 * 24)) ."</kbd> Days </b></p>";
                                ?>
                                <hr>
                                <h2 style="color:red" id='loading alert-danger'></h2><span id='msg'></span>
                               <input type='hidden' value='<?=$_GET['case_no']?>' name='case_no' />
                               <?php if ($buttonEnabledFlag ==1) { ?>
                               <center><button type="submit" class="disable_forward btn btn-sm btn-success" name="submit">Submit</button></center>
                               <?php } ?>  
                            <?php }else if(!$tempNok || $tempNok[0]['approve_reject']==2) { ?>
                                <h2 style="color:red" id='loading'></h2><span id='msg'></span>
                               <input type='hidden' value='<?=$_GET['case_no']?>' name='case_no' />
                               <?php if(!empty($sro_history)){?>
                           <center><h4><u>SRO Push Information</u></h4></center>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Deed status</td>
                                            <td>Sent date</td>
                                            <td>SRO remark</td>
                                            <td>Replied by SRO</td>
                                            <td>Is deed Valid</td>
                                            <td>SRO reply date</td>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sro_history as $sh) :?>
                                        <tr>
                                            <td><?php if($sh['status']=='S'){
                                                echo "Deed is sent to SRO";
                                            }?></td>
                                            <td><?=$sh['date_of_creation']?></td>
                                            <td><?=$sh['remark']?></td>
                                            <td><?php if($sh['action']=='Y'){
                                                echo "Yes";
                                            }?>
                                            </td>
                                            <td><?php if($sh['is_deed_valid']=='Y'){
                                                echo "Yes";
                                            }
                                            else if($sh['is_deed_valid']=='N'){
                                                echo "Not Valid";
                                            }
                                            ?>
                                            </td>
                                            <td><?=$sh['date_of_update']?></td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                 <?php }?>
                                 <?php
                                    if($restriction){?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Is Original inhabitants <small class="text-success">(both parties, i.e. buyer and seller)</small></label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="yes" name="original_inhabitants" value="1">
                                            <label for="Yes">Yes</label><br>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="radio" id="no" name="original_inhabitants" value="0">
                                            <label for="No">No</label><br>
                                        </div>
                                        <div class="col-md-2">
                                                <a href="<?php echo base_url() ?>assets\Original_inhabitants.pdf" target="_blank">Officiel Notification</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <em style="text-align: left;">(“Original inhabitants” mean “a person along with his family, who have been residing in that area for three generations”)</em>
                                    </div>
                                <?php } ?> 

                                
                                <?php if ($buttonEnabledFlag ==1) { ?>
                                <center><button type="submit" class="disable_forward btn btn-sm btn-success" name="submit">Submit</button></center>   
                                <?php } ?>                           
                           <?php } ?>
                           <button class="btn btn-warning" id='backtoLists'><i class="fa fa-arrow-left"></i> Back To Previous Case List(s)</button>
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
    <script language="javascript" type="text/javascript">
        $(window).load(function () {
            $('#loading').hide();
        });
        function LoadData() {
            $("#loading").show();
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });
        }
        $('#backtoLists').click(function(e){
            e.preventDefault();
            window.location.href=baseurl +'cofieldmutation/getPendingFMCases';
        });
    </script>
  <script type="text/javascript">
  $(document).ready(function(){
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
  $('#submitFieldPost').on('submit', function(){
    LoadData();
    $("#loading").html("Submitting ...Please wait...Don't refresh the page !!!!!");
    $('.disable_forward').hide();
    return true;
  });
  ////////////////////

  $("#seeJamaClick").click(function(event){
    // alert("hii");
    $('#seeJama').submit();
  });
  $("#submitNoK").click(function(event){
    $("#formAjaxPost").submit();
    event.preventDefault();
        var formData = {
          co_status: $(".co_status:checked").val(),
          case_no: $("#case_no").val(),
        };
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'COFieldMutation/nokApprove', 
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
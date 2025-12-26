<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form');  ?></h2>

                </div>
                <!--#START PLB-->
                <?php if(isset($certPenDtls->reason_pending))
                {?>
                    <div class="well well-sm">
                        <h2 style="text-align: center;color: red">Pending Reason:
                            <p style="text-align: center;color: black"><?php if($certPenDtls->reason_pending)
                            {
                                echo $certPenDtls->reason_pending;
                            }?></p></h2>
                        </div>
                    <?php }?>
                    <!--#END PLB-->
                </div>
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel-info panel-form">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no'); ?> :<?php echo $certDtls->cert_no; ?> </p></div>
                                <div class="col-lg-5"><p class="uni_text text-center">
                                    <?php
                                    if($certDtls->application_ref_no){
                                        echo "অনলাইনত উল্লেখ নং : ".$certDtls->application_ref_no;
                                    }
                                    ?> 
                                </p></div>
                                <div class="col-lg-3"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date'); ?> : <?php echo date('d-m-Y', strtotime($certDtls->apply_date)); ?> </p></div>
                            </div>
                            <?php //var_dump($users); ?>
                            <hr style="border-bottom: 2px solid #000;">
                            <form class="form-horizontal unicode">
                                <h2 class="red">Location Details</h2>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('district'); ?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control districtselect" id="select" name="dist_code" required>
                                            <option value="<?php echo $certDtls->dist_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getDistrictName($certDtls->dist_code); ?>
                                            </option>
                                        </select>
                                    </div> 
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                            <option value="<?php echo $certDtls->subdiv_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getSubDivName($certDtls->dist_code, $certDtls->subdiv_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('circle'); ?> </label>
                                    <div class="col-lg-4">
                                        <select class="form-control circleselect" id="select" required name="circle_code">
                                            <option value="<?php echo $certDtls->cir_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getCircleName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('mouza'); ?>  </label>
                                    <div class="col-lg-4">
                                        <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                            <option value="<?php echo $certDtls->mouza_pargona_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getMouzaName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code, $certDtls->mouza_pargona_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('lot_no'); ?> </label>
                                    <div class="col-lg-4">
                                        <select class="form-control lotselect" id="select" required name="lot_no">
                                            <option value="<?php echo $certDtls->lot_no; ?>"  selected>
                                                <?php echo $this->utilityclass->getLotName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code, $certDtls->mouza_pargona_code, $certDtls->lot_no); ?>
                                            </option>
                                        </select>
                                    </div>
                                    <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('vill_town'); ?> </label>
                                    <div class="col-lg-4">
                                        <select class="form-control villageselect" id="select" required name="vill_name">
                                            <option value="<?php echo $certDtls->vill_townprt_code; ?>"  selected>
                                                <?php echo $this->utilityclass->getVillageName($certDtls->dist_code, $certDtls->subdiv_code, $certDtls->cir_code, $certDtls->mouza_pargona_code, $certDtls->lot_no, $certDtls->vill_townprt_code); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_type'); ?></label>
                                    <div class="col-lg-4">
                                        <select class="form-control pattatype_nmae"  required name="patta_code">
                                            <?php $patta_type = $this->utilityclass->getpattaName($certDtls->patta_type_code); ?>?>
                                            <option value="<?php echo $certDtls->patta_type_code; ?>"><?php echo $patta_type; ?></option>
                                        </select>
                                    </div>

                                    <label for="inputEmail" class="col-lg-2 control-label required"><?php echo $this->lang->line('patta_no'); ?></label>
                                    <div class="col-lg-4">
                                        <input type="text" readonly="" class="form-control " name="patta_no" value="<?php echo $certDtls->patta_no; ?>">
                                    </div>
                                </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <h2 class="red">Applicant Details</h2>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Applicant Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="relation" class="form-control " readonly="" value="<?php echo $certDtls->appln_name; ?>">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label hide"><?php echo $this->lang->line('mobile_no'); ?></label>
                                    <div class="col-lg-4 hide">
                                        <?php 
                                        $pdar_mobile=$certDtls->pdar_mobile;
                                        if($certDtls->pdar_mobile == '0'){
                                            $pdar_mobile = '';
                                        }
                                        ?>
                                        <input type="text" name="mobile_no" class="form-control " value="<?php echo $pdar_mobile; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Gurdian Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="guard_name" class="form-control " readonly="" value="<?php echo $certDtls->appln_guard; ?>">
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('relation'); ?></label>
                                    <div class="col-lg-4">
                                        <?php $relation = $this->utilityclass->get_relation($certDtls->guard_reln);?>
                                        <input type="text" name="relation" class="form-control" readonly="" value="<?php echo $relation; ?>"  >
                                    </div>
                                </div>

                                <div class="form-group hide">
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('aadhar_no'); ?></label>
                                    <div class="col-lg-4">
                                        <?php 
                                        $pdar_aadharno=$certDtls->pdar_aadharno;
                                        if($certDtls->pdar_aadharno == '0'){
                                            $pdar_aadharno = '';
                                        }
                                        ?>
                                        <input type="text" name="aadhar_no" class="form-control " value="<?php echo $pdar_aadharno; ?>"  >
                                    </div>
                                    <label for="inputEmail" class="col-lg-2 control-label"><?php echo $this->lang->line('pan_no'); ?></label>
                                    <div class="col-lg-4">
                                        <?php 
                                        $pdar_pan=$certDtls->pdar_pan;
                                        if($certDtls->pdar_pan == '0'){
                                            $pdar_pan = '';
                                        }
                                        ?>
                                        <input type="text" name="pan_no" class="form-control " value="<?php echo $pdar_pan; ?>"  >
                                    </div>
                                </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <!--#START PLB-->
                                <?php if($certDtls->application_ref_no){?>
                                    <h2 class="red">Other Attachments</h2>
                                    <?php 
                                    foreach ($attachments as $attachment):
                                //var_dump($attachment);
                                        ?>
                                        <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment .'&refNo=' . $certDtls->application_ref_no .'&type='. 1 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment;?> (Click to see the attachment)</a></h6>
                                    <?php endforeach; ?>
                                <?php }?>
                                <!--#END PLB-->
                                <hr style="border-bottom: 2px solid #000;">
                            </form>
                            <div class="col-lg-6 update">
                                <div class="alert alert-info" style="min-height: 160px;">
                                    <form class="form-inline" action="<?php echo base_url(); ?>index.php/serviceplus/saveJamabandi" method="POST" >
                                         <!---#START PLB--->
                                    <?php
                                    $dist_code = $this->session->userdata('dist_code');
                                    if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                            <legend class="uni_text text-center">ভূমিলেখ্য সহায়কর রিপোর্টের উপর ভিত্তি করে, উল্লিখিত জমাবন্দী জারি করা হয়েছে বা প্রত্যাখ্যান করা হয়েছে । জারি করা জমাবন্দীকে পাট্টাদার চূড়ান্ত হিসাবে গ্রহণ করবেন।
                                            প্ৰিন্ট করার পরে আমার স্বাক্ষরের প্রয়োজন নেই। <br>&nbsp;</legend>

                                    <?php }else{?>
                                        <legend class="uni_text text-center">ভূমিলেখ্য সহায়কৰ প্ৰতিবেদনৰ ভিত্তিত উক্ত জমাবন্দী খন জাৰী অথবা প্রত্যাখ্যান কৰিবলৈ লোৱা হৈছে । জাৰী কৰা  জমাবন্দী খন পট্টাদাৰে চূড়ান্ত হিচাবে গ্ৰহণ কৰিব ।
                                        প্ৰিন্ট কৰাৰ পাছত মোৰ হস্তাক্ষৰৰ প্ৰয়োজন নাই । <br>&nbsp;</legend>
                                    <?php }?>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success clickenable col-lg-offset-4" name="Submit">Please Click here to <?php echo $this->lang->line('generate_jamabandi') ?></button>
                                                <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="cert_no" >
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="alert alert-info" style="min-height: 160px;">
                                        <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/CitizenController/pendingJamaBondi" method="POST">
                                            <legend class="uni_text"><?php echo $this->lang->line('keeping_pending_reason'); ?> </legend>
                                            <div class="form-group col-lg-offset-4">
                                                <button type="submit" class="btn btn-success col-lg-offset-4"><?php echo $this->lang->line('reason_keep_pending'); ?></button>
                                                <input type="hidden" value="<?php echo $certDtls->cert_no; ?>" name="case_no" />
                                            </div>
                                        </form> 
                                        <!--#START PLB-->
                                        <div class="form-group col-lg-offset-4">
                                           <button class="btn query btn-sm btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                                       </div>

                                       <button type="button" class="btn rejectCO btn-sm btn-danger">
                                            <i class='fa fa-backward'></i>&nbsp;<b>Reject Application</b>
                                            </button>
                                   </div>
                               </div>
                               <div class="col-lg-12">
                                   <?php
                                   if($basundharaAttachment){
                                    echo '<h2 class="red">Attachments</h2> <ul>';
                                    foreach ($basundharaAttachment  as $attachment):
                                        ?>
                                        <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                        <?php 
                                    endforeach; 
                                    echo "</ul>";
                                }
                                ?>
                            </div>

                            <div class="col-lg-12">
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
                                            $url=base_url().'index.php/basundhara/document/'.$q->app_doc_id;
                                            echo "<a target='download' href='$url'><i class='fa fa-paperclip'></i> Download </a> " ;
                                        }
                                        ?></td>
                                    </tr>
                                    
                                <?php } echo "</table>"; } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <div id="myModal1" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Type Your Query</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='queryRequest' action="<?php echo base_url() ?>index.php/rtps/queryRequest" method="post">
                 <input type="hidden" class="form-control" name='application_no' value="<?=$certDtls->basundhara;?>">
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
<!--#END PLB-->
<script>
    $('#num_page').keyup(function () {
        if ($("#num_page").val() == "0")
        {
            alert("Please type number of pages");
            var fees = 20;
            $('#fees').val(fees);
            $('#button').prop('disabled', true);
            return false;
        }

        if ($(this).val().length == 0) {
            $('#button').prop('disabled', true);
        } else {
            $('#button').prop('disabled', false);
            var fees = 0;
            var num_page = parseInt($('#num_page').val()) || 0;
            var count = num_page - 1;
            var fees = count * 10 + 20;
            $('#fees').val(fees);
        }
    });
    $('#button').prop('disabled', true);
    $('.clickenable').click(function () {
        $('#button').prop('disabled', false);
    });


    $(".rejectCO").click(function(event){
              event.preventDefault();
              $("#rejectCO").modal('show');
      });

$(document).on('click','.btnRevertClose', function(){
        $('#rejectCO').modal('hide');
    });
    
</script>

<script type="text/javascript">
    function validateForm() {
    var coReport = document.getElementById("co_report").value;

    if (coReport.trim() < 1) {
        alert("Please enter a remark.");
        return false;
   
  }
}

</script>

<div id="rejectCO" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject reason</h5>
            </div>
            <form id='' action="<?php echo base_url() ?>index.php/Serviceplus/rejectCOJB" method="post" >
                <div class="modal-body">
                    <input type="hidden" class="form-control" name='cert_no' 
                    value="<?=$certDtls->cert_no?>">
                    <input type="hidden" name="dist_code" value="<?=$certDtls->dist_code?>">
                    <input type="hidden" name="subdiv_code"  value="<?=$certDtls->subdiv_code?>">
                    <input type="hidden" name="cir_code" value="<?=$certDtls->cir_code?>">
                    <textarea name='co_report' id="co_report" class="form-control" placeholder="Remark" required></textarea> 
                    <textarea name="co_report_suffix" class="form-control hide" 
                    rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"  onclick="return validateForm();">Submit</button>
                    <button type="button" class="btn btn-sm btn-default btnRevertClose" id="">Close</button>
                </div>
            </form> 
        </div>
    </div>
</div>

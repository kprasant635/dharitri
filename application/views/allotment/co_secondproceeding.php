<?php
    ///////////// BARAK VALLEY CODE START HERE ////////////////
    $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
?>

<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#sk').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#cbsic').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#actoppSecond .modal-content').html(data);
                    $('#actoppSecond').modal('show');
                    $('body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Allotment/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>
                    <?php if($basuCase==null){ ?>
                    <a class="btn btn-success uni_text" target='_blank' href='<?php echo base_url() . 'index.php/Allotment/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Allotment Certificate
                    </a>
                    <?php } ?>
                   <a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>
                </div>
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-success uni_text" id='lm' href='<?php echo base_url() . 'index.php/Allotment/viewlmnote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View LRA Report
                    </a>
                    <a class="btn btn-warning uni_text" id='sk' href='<?php echo base_url() . 'index.php/Allotment/viewsknote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View LRS Report
                    </a>
                    <a class="btn btn-danger uni_text" id='pr' href='<?php echo base_url() . 'index.php/Allotment/viewpro?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Proceeding Report
                    </a>
                    <a class="btn btn-info hide uni_text" id='co' href='<?php echo base_url() . 'index.php/Allotment/viewsknote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View CO Report
                    </a>  
                </div>
                <form class="form-horizontal unicode" action="<?php echo base_url()."index.php/Allotment/savecoscondorder" ?>" method="POST"  >              
                <div class='panel-body'>
                <?php
                    if($this->session->flashdata('message')){
                  ?>
                  <br>
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
				<br>
                <?php
                        ///////////// BARAK VALLEY CODE START HERE ////////////////
                        if($barak){
                    ?>
                        <h2 class="text-center" style="top:20px;">সার্কেল অফিসারের আদেশ </h2>
                        <table class="table_border">
                            <tr>
                                <td class="uni_text">কেস নং : <?php echo $allotment_cb->case_no ;?></td>
                                <td class="uni_text">রুলিং সিরিয়াল নং : 2</td>
                                <td class="uni_text">তাং : <?php echo date('d-m-Y',strtotime($allotment_cb->date_entry)) ; ?></td>
                            </tr>
                        </table><hr>
                    <?php } else { ?>
                    <h2 class="text-center" style="top:20px;">চক্র বিষয়াৰ হুকুম </h2>
                    <table class="table_border">
                        <tr>
                            <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no ;?></td>
                            <td class="uni_text">হুকুম  ক্রমিক নং : 2</td>
                            <td class="uni_text">তাং : <?php echo date('d-m-Y',strtotime($allotment_cb->date_entry)) ; ?></td>
                        </tr>
                    </table>
                </div>
            <?php }?>
					<hr>
					<?php if($allotment_cb->dc_note){
						echo "<u>This case is Revert Back By DC/ADC: </u><p>";
						echo  $allotment_cb->dc_note ."</p>";
					} ?>
                    <hr>
					<div class="form-group">    
                    <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                    <div class="col-lg-10">
						<?php
						$i=1;
						$name="";
						foreach($applicant as $ap){
							$mouza=$this->utilityclass->getMouzaName($ap->dist_code,$ap->subdiv_code,$ap->circle_code,$ap->mouza_pargona_code);
							$vill=$this->utilityclass->getVillageName($ap->dist_code,$ap->subdiv_code,$ap->circle_code,$ap->mouza_pargona_code,$ap->lot_no,$ap->vill_townprt_code);
							$name=$name.$i.")".$ap->alotee_name." ";
							$i++;
						}	
						$dag=$lmreport->dag_no;
						$b=$lmreport->alot_area_b;
						$k=$lmreport->alot_area_k;
						$lc=$lmreport->alot_area_lc;
						?>

                         <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                                $g=$lmreport->alot_area_g;
                        ?>
                            <textarea class="form-control" rows=5 placeholder='Type here' name="co_comment" required="" value="" >  আবেদনকারীর (নাম/ ঠিকানা) আবেদন টি দেখা হয় । ভূমিলেখ্য সহায়ক / ভূমিলেখ্য পৰ্যবেক্ষকর প্রতিবেদনে বলা হয়,  <?=$name;?> <?=$mouza?> মৌজা  <?=$vill?> গ্রাম র <?=$dag?> দাগর  <?=$b?> বি: <?=$k?> ক: <?=$lc?> চা: <?=$g?> গ: জমিটি বরাদ্দ ব্যবস্থা দ্বারা দখল করা হয় । আবেদনকারী বরাদ্দের মানদণ্ড ভঙ্গ করেননি । সুতরাং রিপোর্ট করা জমির পটনের জন্য প্রস্তাবটি অনুমোদনের সাথে জমা দেওয়া হয়েছিল ।</textarea>
                        <?php } else { ?>
                        <textarea class="form-control" rows=5 placeholder='Type here' name="co_comment" required="" value="" >  আবেদনকাৰীৰ (নাম / ঠিকনা) ৰ আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক / ভূমিলেখ্য পৰ্যবেক্ষক ৰ প্রতিবেদন মৰ্মে জনা যায় যে  <?=$name;?> <?=$mouza?> মৌজা  <?=$vill?> গাওঁৰ  <?=$dag?> দাগৰ  <?=$b?> বি: <?=$k?> ক: <?=$lc?> লে: মাটিত আবণ্টন প্রত্ৰ মৰ্মে ভোগ দখল কৰি থকা মাটি হয় ।আবেদনকাৰীয়ে  আবণ্টনৰ চৰ্ত ভংগ কৰা নাই । সেয়েহে আবেদিত মাটিৰ পট্টনৰ প্রস্তাৱ অনুমোদনৰ বাৱে  সহ দাখিল কৰা হ'ল ।</textarea>
                    <?php }?>
                    </div>		
					</div>
					<div class="form-group">    
                    <label for="inputEmail" class="col-lg-2 required control-label ">Next Date of Hearing </label>
                    <div class="col-lg-10">
                        <input type="text" readonly name="next_date" autocomplete="off" required  id="popupDatepicker" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >
						 <input type="text" class='hide' name="case_no" required value='<?php echo $allotment_cb->case_no ;?>'>
                    </div>		
					</div>

                    
                    
                    <hr> 
                    <?php
                        ///////////// BARAK VALLEY CODE START HERE ////////////////
                        if($barak){
                    ?>
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="inputEmail" class="col-lg-3 required control-label ">Applied Area </label>
                                <div class="col-lg-2">
                                   <input type="number" class="form-control"  required="" name="mut_area_b"  value="<?= $lmreport->alot_area_b ?>" readonly/> Bigha
                                </div>
                                <div class="col-lg-2">
                                   <input type="number" class="form-control" required=""  name="mut_area_k"  value="<?= $lmreport->alot_area_k ?>" readonly/> Katha 
                                </div>
                                <div class="col-lg-2">
                                   <input type="number" class="form-control" required=""  step="0.01" name="mut_area_l" value="<?= $lmreport->alot_area_lc ?>" readonly/> Chatak 
                                </div>
                                <div class="col-lg-2">
                                   <input type="number" class="form-control" required=""  step="0.01" name="mut_area_g" value="<?= $lmreport->alot_area_g ?>" readonly/> Ganda
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="inputEmail" class="col-lg-3 required control-label ">Applicant having Possesion(Area) </label>
                                <div class="col-lg-2">
                                    <input type="number" class="form-control" required="" name="mut_area_b"  value="<?= $lmposses->area_posession_b ?>" /> Bigha
                                </div>
                                <div class="col-lg-2">
                                    <input type="number" class="form-control" required="" min="0" max="5" maxlength="1"  name="mut_area_k"  value="<?= $lmposses->area_posession_k ?>" /> Katha 
                                </div>
                                <div class="col-lg-2">
                                    <input type="number"  class="form-control" required="" min="0" name="mut_area_l" value="<?= $lmposses->area_posession_lc ?>" /> Chatak 
                                </div>
                                <div class="col-lg-2">
                                    <input type="number"  class="form-control" required="" min="0" name="mut_area_g" value="<?= $lmposses->area_posession_g ?>" /> Ganda 
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label class="radio-inline uni-text col-lg-offset-2">
                            <input type="radio" name="next_hearing" value="L"> ভূমিলেখ্য সহায়ক ফিরে রিপোর্ট করুন 
                        </label>
                        <label class="radio-inline uni-text">
                            <input type="radio" name="next_hearing"  value="P" checked=""> জেলা প্রশাসকের কাছে পাঠান 
                        </label>
                    <?php } else { ?>
                    <div class="form-group">
                     <label for="inputEmail" class="col-lg-2 required control-label ">Applied Area </label>
                        <div class="col-lg-3">
                           <input type="number" class="form-control" style="width: 250px"  required="" name="mut_area_b"  value="<?= $lmreport->alot_area_b ?>" readonly/> Bigha
                       </div>
                       <div class="col-lg-3">
                           <input type="number" class="form-control" style="width: 250px" required=""  name="mut_area_k"  value="<?= $lmreport->alot_area_k ?>" readonly/> Katha 
                       </div>
                       <div class="col-lg-3">
                           <input type="number" class="form-control" style="width: 250px" required=""  step="0.01" name="mut_area_l" value="<?= $lmreport->alot_area_lc ?>" readonly/> Lessa 
                    </div>      
                    
                     <label for="inputEmail" class="col-lg-2 required control-label ">Applicant having Possesion(Area) </label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" style="width: 250px" required="" name="mut_area_b"  value="<?= $lmposses->area_posession_b ?>" /> Bigha
                    </div>
                    <div class="col-lg-3">
                       <input type="number" class="form-control" style="width: 250px" required="" min="0" max="5" maxlength="1"  name="mut_area_k"  value="<?= $lmposses->area_posession_k ?>" /> Katha 
                   </div>
                   <div class="col-lg-3">
                       <input type="number"  class="form-control" style="width: 250px" required="" min="0" max="19.99" step="0.01" name="mut_area_l" value="<?= $lmposses->area_posession_lc ?>" /> Lessa 
                   </div>
                    </div>
                    
                        
                   
                    <hr>

                    <?php if($flag == true && ESCALATION_ENABLE ==1 && $out_of_esc == 0){ ?>
                        <div class="row justify-content-center" id="allocate_days" style="display: none;">
                            <div class="col-md-6">
                                <label for="">
                                    <b style="color:red;">Warning  : Assign days to LM for report the Case No. (Maximum <?php echo $day = (int) $remainingDaysCO-1; ?> day)</b>
                                </label>
                                <select class="form-select" name="allocate_day" >
                                    <?php for ($i=1; $i < $remainingDaysCO; $i++) {  ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?php  } ?>
                                </select>

                            </div>
                        </div>
                    <?php } ?>
                    <label class="radio-inline uni-text col-lg-offset-2">
                        <input type="radio" name="next_hearing" onclick="alloted_days_check()" value="L"> লাট মন্দলে পুন: প্রতিবেদন দিয়ক 
                    </label>
                    <!-- <label class="radio-inline uni-text">
                        <input type="radio" name="next_hearing"  value="D"> প্রস্তাৱ খাৰিজ কৰক 
                    </label> -->
                    <label class="radio-inline uni-text">
                        <input type="radio" name="next_hearing" onclick="alloted_days_check()"  value="P" checked=""> উপায়ুক্ত লৈ প্রেৰণ কৰক 
                    </label>
                    <?php } ///////////// BARAK VALLEY CODE START HERE //////////////// ?>
                    <br>
                <div class="col-lg-12" id="dc_block">
                <label class="rasid col-sm-12">
                    Note : Please Select the Forwarding Officer (Additional Deputy Commissioner) 
                </label>
                <center>
                    <label class="rasid btn">Please Select ADC &nbsp;&nbsp;</label>
                    <label class="btn btn-success">
                        <select class="form-control" name='adc_code' id="adc_code" required>
                            <?php
                            echo"<option disabled selected> -- Select --</option>";
                            foreach ($adc as $dcadc) {
                                $user_desig_code = $dcadc->user_desig_code;
                                $username = $dcadc->username . " ( " . $user_desig_code . " )";
                                $user_code = $dcadc->user_code;
                                echo"<option value='$user_code'>$username</option>";
                            }
                            ?>
                        </select>
                    </label>
                </center>
                <br>
                </div>
                    <hr>
                </div>
                <?php
                if($basundharaAttachment){
                echo '<div class=\'col-lg-12\'><h2 class="red">Basundhara Attachments</h2>';
                foreach ($basundharaAttachment  as $attachment):
                ?>
                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                <?php 
                endforeach; 
                }
                echo "</div>";
                ?>
                <?php if(isset($noc_cert) and !empty($noc_cert)) { ?>
                <div class="col-lg-12"><h2 class="red">View NOC (For Changing Dag)</h2>
                <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$noc_cert->id?>" class="red" download target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo NOC;?> (Click to see the attachment)</a></h6>
                </div>  
                <?php } ?>

                <?php if(isset($allot_cert) and !empty($allot_cert)) { ?>
                <div class="col-lg-12"><h2 class="red">View <?=ALLOT_CERT?></h2>
                <h6><a href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$allot_cert->id?>" class="red" download target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo ALLOT_CERT;?> (Click to see the attachment)</a></h6>
                </div>  
                <?php } ?>

                
                <div class="panel-footer">
                    
                    <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                    <button type="button" class="btn btn-danger" onclick="showRejectModal('<?=$allotment_cb->case_no?>','<?=SERVICE_ALLOTMENT?>')"><i class="fa fa-close"></i> &nbsp;Reject Application</button>
                     <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                   
<!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
                </div>
                </form>
                
            </div>
         </div>
        
    </div>
        
</div>
<div class="modal bs-example-modal-lg" id='actoppSecond' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<style type="text/css">
    .modal{
        overflow-y:auto;
        overflow-x: hidden;
    }
    .bodytest{
        position: relative;
        padding: 0px !important;
    }
</style>


<script>
    $('#BackHome').click(function(){
	location.href = "<?php echo base_url(); ?>index.php/home";
    });
    var dateToday = new Date(); 
    $(function() {
        $( "#ddmmyy" ).datepicker({
            numberOfMonths: 3,
            showButtonPanel: true,
            minDate: dateToday
        });
    });
    </script>

    <script>
        function alloted_days_check(){
            var check_type = $("input[type='radio'][name='next_hearing']:checked").val();
            if(check_type == 'L'){
                $('#allocate_days').show();
            }
            else{
                $('#allocate_days').hide();
            }
        }
    </script>
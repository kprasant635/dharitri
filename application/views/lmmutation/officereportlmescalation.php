<script>
    $(function () {
        $('#vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#myLargeModalLabel .modal-content').html(data);
                    $('#myLargeModalLabel').modal('show');
                }
            });

        });
        $('.lmreportmut').click(function (e) {
           e.preventDefault();
           $.ajax({
               url:$(this).attr('href'),
               success:function(data){
                   //alert('hai');
                   $('#myLargeModalLabel .modal-content').html(data);
                   $('#myLargeModalLabel').modal('show')
               }
           });
           
       });

    });
</script>
<script>
    $(function () {
        $('form').submit(function (e) {
            var response = confirm("Are you sure you want to register a field mutation case?");
            if (response) {
                var dispute = $('input[name="dispute"]').is(':checked');
                console.log(dispute);
                if (dispute) {
                    $('#myModal .modal-body p').html("Disputed Plots cannot be Mutated!");
                    $('#myModal').modal();
                    e.preventDefault();
                }
            } else {
                e.preventDefault();
            }
        });
    });

</script>
<style>
    input[type='number']{
        width:100%;
    }
</style>

<div class="container-fluid login form-top">
    <?php if($this->session->flashdata('message')):?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
    </div>
    <?php endif;?>

    <div class='row'>
        <div class='col-lg-12 center-col'>
            <div class='panel panel-info'>
                <div class='panel-heading'>
                    <div class='panel-title'>
                        <p class="uni_text"><?php echo $this->lang->line('lm_report') ?> <?php echo $this->lang->line('case_no'); ?>- <?php echo $case_no; ?></p>
                    </div>
                </div>
                <div class='panel-body'>
                    <div class='row'>

                        <div class='col-lg-12'>
                            <?php
                            $link = base_url() . "index.php/lmmutation/writeofficereportMultiGenEscalation";
                            ?>
                            <form method="post" id="omForm" action="<?php echo $link; ?>" accept-charset="UTF-8">
                                <?php if(ESCALATION_ENABLE == 1){?>
                                    <input type="text" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                                <?php } ?>
                                <div class="row col-lg-12">
                                    <div class="col-lg-2">
                                        <a  id='vp' href='<?php echo base_url(); ?>index.php/officemutation/viewpetition?case_no=<?php echo $case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_petition'); ?></a>
                                    </div><div class="col-lg-3">
                                    <a class="btn btn-info uni_text lmreportmut"  href="<?php echo base_url() . "index.php/officemutation/lmreport?case_no=" . $case_no . "&dist_code=" . $petition->dist_code . "&subdiv_code=" . $petition->subdiv_code . "&cir_code=" . $petition->cir_code . "&mouza_pargona_code=" . $petition->mouza_pargona_code . "&lot_no=" . $petition->lot_no . "&vill_townprt_code=" . $petition->vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View LM Report (if Exists)</a>
                                    </div>
                                </div>

                                <input type='hidden' value="<?php echo $petition->dist_code; ?>" name="dist_code"/>
                                <input type='hidden' value="<?php echo $petition->subdiv_code; ?>" name="subdiv_code"/>
                                <input type='hidden' value="<?php echo $petition->cir_code; ?>" name="cir_code"/>
                                <input type='hidden' value="<?php echo $petition->mouza_pargona_code; ?>" name="mouza_pargona_code"/>
                                <input type='hidden' value="<?php echo $petition->lot_no; ?>" name="lot_no"/>
                                <input type='hidden' value="<?php echo $petition->vill_townprt_code; ?>" name="vill_townprt_code"/>
                                <input type='hidden' value="<?php echo $petition->petition_no; ?>" name="petition_no"/>
                                <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>
                                
                                
                                <table class='table table-bordered'>
                                    <?php foreach ($dags as $key => $dags) { ?>
                                    <tr>
                                        <td colspan="11" style="text-align: center">
                                          <span style="font-size:16px;font-weight: bold;"> Dag No : <?=$dags->dag_no;?> </span><a target="__blank" href='<?php echo base_url(); ?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                                            

                                        </td>
                                    </tr>
                                    <input type='hidden' value="<?php echo $dags->dag_no; ?>" name="dag_no[]"/>
                                    <input type='hidden' value="<?php echo $dags->dag_area_b; ?>" id="b"/>
                                    <input type='hidden' value="<?php echo $dags->dag_area_k; ?>" id="k"/>
                                    <input type='hidden' value="<?php echo $dags->dag_area_lc; ?>" id="lc"/>
                                    <input type='hidden' value="<?php echo $dags->dag_area_g; ?>" id="g"/>
                                    <input type='hidden' value="<?php echo $dags->dag_area_kr; ?>" id="kr"/>
                                    <tr>
                                        <td></td>
                                        <td>B (বি :) </td><td>K (ক :)</td><td>L (লে :)</td><td>G (গ :)</td><td>Kr (ক্ৰা :)</td>

                                    </tr>
                                    <tr>
                                        <!-- To be mutated Area-->
                                        <td><?php echo $this->lang->line('total_land_area') ?></td>
                                        <td>
                                            <input type='number' maxlength="6" name="" id="b" 
                                                   value="<?php echo $dags->dag_area_b; ?>" />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="" id="k" 
                                                   value="<?php echo $dags->dag_area_k; ?>"/>
                                        </td>
                                        <td>
                                            <input type='number' maxlength="5" name="" id="lc" 
                                                   value="<?php echo $dags->dag_area_lc; ?>"/>
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="" id="g" 
                                                   value="<?php echo $dags->dag_area_g; ?>" />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="" id="kr"
                                                   value="<?php echo $dags->dag_area_g; ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- To be mutated Area-->
                                        <td><?php echo $this->lang->line('mutated_land_area') ?></td>
                                        <td>
                                            <input type='number' maxlength="6" name="mut_b[]" id="mut_b"
                                                   value="<?php echo $dags->m_dag_area_b; ?>" />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="mut_k[]" id="mut_k"
                                                   value="<?php echo $dags->m_dag_area_k; ?>" />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="5" name="mut_lc[]" id="mut_lc"
                                                   value="<?php echo $dags->m_dag_area_lc; ?>" />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="mut_g[]" id="mut_g"
                                                   value="<?php echo $dags->m_dag_area_g; ?>" />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="mut_kr[]" id="mut_kr"
                                                   value="0" />
                                        </td>
                                    </tr>

                                    <?php

                                     ////// BARAK VALLEY CODE START ////////////

                                        $mb = $dags->m_dag_area_b;
                                        $mk = $dags->m_dag_area_k;
                                        $ml = $dags->m_dag_area_lc;
                                        $mg = $dags->m_dag_area_g;

                                        $sm = $dags->dag_area_b;
                                        $sk = $dags->dag_area_k;
                                        $slc = $dags->dag_area_lc;
                                        $sg = $dags->dag_area_g;
                                        $dags->dag_area_lc;

                                        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                            
                                            $m = $mb*6400+$mk*320+$ml*20+$mg;
                                            $s = $sm*6400+$sk*320+$slc*20+$sg;

                                            $rem = $s - $m;
                                            $bigha_r = floor($rem / 6400);
                                            $katha_r = floor(($rem-$bigha_r*6400)/320);
                                            $lessa_r = floor(($rem-$bigha_r*6400-$katha_r*320)/20);
                                            $ganda_r = $rem-$bigha_r*6400-$katha_r*320-$lessa_r*20 ;
                                        }
                                        else {
                                            $m = $mb * 100 + $mk * 20 + $ml;
                                            $s = $sm * 100 + $sk * 20 + $slc;
                                            $rem = $s - $m;
                                            $bigha_r = floor($rem / 100.0);
                                            $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
                                            $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
                                        }
                                        ////// BARAK VALLEY CODE END ////////////
                                    ?>  	
                                    <tr>
                                        <td><?php echo $this->lang->line('remaining_land_area') ?></td>
                                        <td>
                                            <input type='number' maxlength="6" name="area_left_b" id="area_left_b"
                                                   value="<?php echo $bigha_r; ?>"
                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="area_left_k" id="area_left_k"
                                                   value="<?php echo $katha_r; ?>"
                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="5" name="area_left_lc" id="area_left_lc"
                                                   value="<?php echo round($lessa_r, 2); ?>"
                                                   />
                                        </td>
                                        <td>
                                            <!-- ////// BARAK VALLEY CODE START //////////// -->
                                            <?php
                                                if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
                                            ?>
                                                <input type='number' maxlength="2" name="area_left_g" id="area_left_g" value="<?= round($ganda_r, 2) ?>" />
                                            <?php } else { ?>
                                                <input type='number' maxlength="2" name="area_left_g" 
                                                id="area_left_g" value="<?php echo $dags->dag_area_g - $dags->m_dag_area_g; ?>" />
                                            <?php } ?>
                                            <!-- ////// BARAK VALLEY CODE END //////////// -->
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="area_left_kr" id="area_left_kr"
                                                   value="<?php echo $dags->dag_area_kr - $dags->m_dag_area_kr; ?>"
                                                   />
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="6" style="background-color: #94baff;"><b><?php echo $this->lang->line('pattadar_details_office')?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                           <!--  <div class="form-group " style="display: none;">
                                                <label for="inputEmail3"  class="col-sm-2  uni_text control-label"><?php echo $this->lang->line('pattadar_no')?></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control" value="<?php echo $pattadar_cron_no; ?>" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                                </div>
                                            </div> -->
                                            <?php
                                            $count=1;
                                            foreach ($pattadars as $key => $value) { ?>
                                                <div class="row" style="padding:3px;">
                                                <label for="inputEmail3" class="col-sm-1  uni_text control-label required"><?=$count;?></label>
                                                <div class="col-sm-3">
                                                    <input type="hidden" name="pda_id_new[]" value="<?=$value->pdar_id;?>">
                                                    <input type="text" readonly class="form-control" name="pda_name_new[]" value="<?=$value->pdar_name;?>">
                                                    <!-- <select type="text" class="form-control pattadar_name_no_session" name="pdar_name" id="pdar_name" required>
                                                        <option selected><?php echo $this->lang->line('select_pattadar')?></option>
                                                        <?php foreach ($pattadars as $pattadar): ?>
                                                            <option value='<?php echo $pattadar->pdar_id; ?>'><?php echo $pattadar->pdar_name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select> -->
                                                </div>
                                                <label for="inputEmail3" style="font-size:12px;" class="col-sm-1 control-label required">Guardian Name</label>
                                                <div class="col-sm-3">
                                                    <input type="text" readonly class="form-control" value="<?=$value->pdar_father;?>" >
                                                </div>
                                                <label for="inputEmail3" style="font-size:12px;color: red;" class="col-sm-1 control-label required"><?php echo $this->lang->line('inplace_alongwith')?></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control inplace" name="striked_out[]" required>
                                                        <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith')?></option>
                                                        <option value="1"><?php echo $this->lang->line('inplace')?></option>
                                                        <option value="0"><?php echo $this->lang->line('alongwith')?></option>
                                                    </select>
                                                    <p style="color:red" id="error<?=$key;?>"></p>
                                                </div>
                                                

                                            </div>
                                            <div class="clearfix"></div>
                                            <?php $count++; }
                                            ?>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><?php echo $this->lang->line('detailed_report') ?></td>
                                        <td colspan="2"><?php echo $this->lang->line('dispute') ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <td colspan="3">
                                            <textarea rows="5" name='report_on_possession' style="width: 100%" >সকলো  তথ্য়  সঠিক  |
								লাট মন্ডল -----</textarea>
                                        </td>
                                        <td colspan="2">
                                            <input type="checkbox" name='dispute' value="y"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="11" style="text-align: center;">
                                            <label><?php echo $this->lang->line('transfer_type') ?></label>
                                            <input type="hidden"  value="<?php echo $petition->mut_type; ?>" name="trans_code" style="width:20%;"/>
                                            <input type="text" readonly="" value="<?php echo $this->utilityclass->getTransferType($petition->trans_code); ?>" name="" style="width:20%;"/>
                                        </td>
                                    </tr>
                                    <TR>
                                        <TD colspan=11>
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
                            <?php if($basuCase){ ?>
                            <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                            <?php } ?>
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
                                    echo "<a target='download' href='".base_url() ."index.php/basundhara/document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                                        </TD>
                                    </TR>
                                    <tr>
                                        <td colspan="11" style="text-align: center">
                                            <h2 style="color:red" class="submit_message_show"></h2>
                                            <button type="submit" id="submitButtonOM"  class="btn btn-danger"><?php echo $this->lang->line('submit_report') ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal  bs-example-modal-lg" id='myLargeModalLabel' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            Modal
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
<script type="text/javascript">
// $().ready(function() {
//         $("#checkform").validate({
//             rules: {
//                 "field_name[]": "required"
//             },
//             messages: {
//                 "field_name[]": "Please select field option",
//             }
//         });
//     });
// $(document).on('click','#submitButtonOM',function() {
//     $('#submitButtonOM').hide();
//     $('.submit_message_show').html("Please wait...form is submitting, do not refresh the page.");
// })

$(document).ready(function(){
    <?php
        if($this->session->flashdata('query_mdl_message')){
    ?>
        $('#myModal1').modal('show');
    <?php
        }
    ?>
    $('#omForm').on('submit', function(){
        var flag = [];
        var inps = document.getElementsByName('striked_out[]');
        for (var i = 0; i <inps.length; i++) {
            var inp=inps[i];
            if(inp.value == 'Select Inplace Alongwith'){
               // alert('Please select in place/Alongwith of each pattadar.');
               $("#error"+i).html("Please select in place/Alongwith of each pattadar.");
               flag.push(i);
               
            }
        }
        // console.log(flag);
        if(flag.length == 0){
            $('#submitButtonOM').hide();
            $('.submit_message_show').html("Please wait...form is submitting, do not refresh the page.");
            return true;
        }else{
            return false;
        }

    });
});
</script>
</script>
<!--  -->
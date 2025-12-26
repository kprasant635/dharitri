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
                                $link = base_url() . "index.php/lmmutation/writeofficereportNewMultiDag";
                                $dist_code = $this->session->userdata('dist_code');
                                $case_dist_code = $dags[0]->dist_code;
                                $case_subdiv_code = $dags[0]->subdiv_code;
                                $case_cir_code = $dags[0]->cir_code;
                                $case_mouza_pargona_code = $dags[0]->mouza_pargona_code;
                                $case_lot_no = $dags[0]->lot_no;
                                $case_vill_townprt_code = $dags[0]->vill_townprt_code;
                                $case_petition_no = $dags[0]->petition_no;
                                $case_lot_no = $dags[0]->lot_no;
                                
                                $show_barrack_block = 'none';
                                if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                                    $show_barrack_block = '';
                                }
                            ?>
                            <form method="post" id="omForm" action="<?php echo $link; ?>" accept-charset="UTF-8">

                                <?php if(ESCALATION_ENABLE == 1){?>
                                    <input type="text" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                                <?php } ?>
                                <input type='hidden' value="<?php echo $case_dist_code; ?>" name="dist_code"/>
                                <input type='hidden' value="<?php echo $case_subdiv_code; ?>" name="subdiv_code"/>
                                <input type='hidden' value="<?php echo $case_cir_code; ?>" name="cir_code"/>
                                <input type='hidden' value="<?php echo $case_mouza_pargona_code; ?>" name="mouza_pargona_code"/>
                                <input type='hidden' value="<?php echo $case_lot_no; ?>" name="lot_no"/>
                                <input type='hidden' value="<?php echo $case_vill_townprt_code; ?>" name="vill_townprt_code"/>
                                <!-- <input type='hidden' value="<?php echo $case_petition_no; ?>" name="petition_no"/> -->
                                <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>

                                <table class='table table-bordered'>
                                    <tr>
                                        <td colspan="11" style="text-align: center">
                                            <!-- <a target="__blank" href='<?php echo base_url(); ?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a> -->
                                            <a  id='vp' href='<?php echo base_url(); ?>index.php/officemutation/viewpetition?case_no=<?php echo $case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_petition'); ?></a>
                                            <a class="btn btn-info uni_text lmreportmut"  href="<?php echo base_url() . "index.php/officemutation/lmreport?case_no=" . $case_no . "&dist_code=" . $case_dist_code . "&subdiv_code=" . $case_subdiv_code . "&cir_code=" . $case_cir_code . "&mouza_pargona_code=" . $case_mouza_pargona_code . "&lot_no=" . $case_lot_no . "&vill_townprt_code=" . $case_vill_townprt_code; ?>"><i class='fa fa-list-alt'></i>&nbsp; View LM Report (if Exists)</a>

                                        </td>
                                    </tr>
                                    
                                    <?php
                                        foreach($dags as $petition_dag_detail):
                                            ////// BARAK VALLEY CODE START ////////////

                                            $mb = $petition_dag_detail->m_dag_area_b;
                                            $mk = $petition_dag_detail->m_dag_area_k;
                                            $ml = $petition_dag_detail->m_dag_area_lc;
                                            $mg = $petition_dag_detail->m_dag_area_g;

                                            $sm = $petition_dag_detail->dag_area_b;
                                            $sk = $petition_dag_detail->dag_area_k;
                                            $slc = $petition_dag_detail->dag_area_lc;
                                            $sg = $petition_dag_detail->dag_area_g;
                                            $petition_dag_detail->dag_area_lc;

                                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){
                                                
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
                                            <input type='hidden' value="<?php echo $petition_dag_detail->dag_no; ?>" name="dag_no[]"/>
                                            <input type='hidden' value="<?php echo $petition_dag_detail->dag_area_b; ?>" id="b"/>
                                            <input type='hidden' value="<?php echo $petition_dag_detail->dag_area_k; ?>" id="k"/>
                                            <input type='hidden' value="<?php echo $petition_dag_detail->dag_area_lc; ?>" id="lc"/>
                                            <input type='hidden' value="<?php echo $petition_dag_detail->dag_area_g; ?>" id="g"/>
                                            <input type='hidden' value="<?php echo $petition_dag_detail->dag_area_kr; ?>" id="kr"/>
                                            <tr>
                                                <td colspan="11" style="text-align: center">
                                                <span style="font-size:16px;font-weight: bold;"> Dag No : <?=$petition_dag_detail->dag_no;?> </span><a target="__blank" href='<?php echo base_url(); ?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no; ?>&dag_no=<?= $petition_dag_detail->dag_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                                                    

                                                </td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <td>B (বি :) </td><td>K (ক :)</td><td>L (লে :)</td><td style="display: <?= $show_barrack_block; ?>">G (গ :)</td><td style="display: <?= $show_barrack_block; ?>">Kr (ক্ৰা :)</td>
                                            </tr>
                                            <tr>
                                                <!-- To be mutated Area-->
                                                <td><?php echo $this->lang->line('total_land_area') ?></td>
                                                <td>
                                                    <input type='number' maxlength="6" readonly id="b" 
                                                        value="<?php echo $petition_dag_detail->dag_area_b; ?>" />
                                                </td>
                                                <td>
                                                    <input type='number' maxlength="2" readonly id="k" 
                                                        value="<?php echo $petition_dag_detail->dag_area_k; ?>"/>
                                                </td>
                                                <td>
                                                    <input type='number' maxlength="5" readonly id="lc" 
                                                        value="<?php echo number_format($petition_dag_detail->dag_area_lc); ?>"/>
                                                </td>
                                                <td style="display: <?= $show_barrack_block; ?>">
                                                    <input type='number' maxlength="2" readonly id="g" 
                                                        value="<?php echo $petition_dag_detail->dag_area_g; ?>" />
                                                </td>
                                                <td style="display: <?= $show_barrack_block; ?>">
                                                    <input type='number' maxlength="2" readonly id="kr"
                                                        value="<?php echo $petition_dag_detail->dag_area_g; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <!-- To be mutated Area-->
                                                <td><?php echo $this->lang->line('mutated_land_area') ?></td>
                                                <td>
                                                    <input type='number' maxlength="6" name="mut_b[]" id="mut_b"
                                                        value="<?php echo $petition_dag_detail->m_dag_area_b; ?>" />
                                                </td>
                                                <td>
                                                    <input type='number' maxlength="2" name="mut_k[]" id="mut_k"
                                                        value="<?php echo $petition_dag_detail->m_dag_area_k; ?>" />
                                                </td>
                                                <td>
                                                    <input type='number' maxlength="5" name="mut_lc[]" id="mut_lc"
                                                        value="<?php echo $petition_dag_detail->m_dag_area_lc; ?>" />
                                                </td>
                                                <td style="display: <?= $show_barrack_block; ?>">
                                                    <input type='number' maxlength="2" name="mut_g[]" id="mut_g"
                                                        value="<?php echo $petition_dag_detail->m_dag_area_g; ?>" />
                                                </td>
                                                <td style="display: <?= $show_barrack_block; ?>">
                                                    <input type='number' maxlength="2" name="mut_kr[]" id="mut_kr"
                                                        value="0" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('remaining_land_area') ?></td>
                                                <td>
                                                    <input type='number' maxlength="6" name="area_left_b[]" id="area_left_b"
                                                        value="<?php echo $bigha_r; ?>"
                                                        />
                                                </td>
                                                <td>
                                                    <input type='number' maxlength="2" name="area_left_k[]" id="area_left_k"
                                                        value="<?php echo $katha_r; ?>"
                                                        />
                                                </td>
                                                <td>
                                                    <input type='number' maxlength="5" name="area_left_lc[]" id="area_left_lc"
                                                        value="<?php echo round($lessa_r, 2); ?>"
                                                        />
                                                </td>
                                                <td style="display: <?= $show_barrack_block; ?>">
                                                    <!-- ////// BARAK VALLEY CODE START //////////// -->
                                                    <?php
                                                        if(in_array($dist_code,json_decode(BARAK_VALLEY))){
                                                    ?>
                                                        <input type='number' maxlength="2" name="area_left_g[]" id="area_left_g" value="<?= round($ganda_r, 2) ?>" />
                                                    <?php } else { ?>
                                                        <input type='number' maxlength="2" name="area_left_g[]" 
                                                        id="area_left_g" value="<?php echo $petition_dag_detail->dag_area_g - $petition_dag_detail->m_dag_area_g; ?>" />
                                                    <?php } ?>
                                                    <!-- ////// BARAK VALLEY CODE END //////////// -->
                                                </td>
                                                <td style="display: <?= $show_barrack_block; ?>">
                                                    <input type='number' maxlength="2" name="area_left_kr[]" id="area_left_kr"
                                                        value="<?php echo $petition_dag_detail->dag_area_kr - $petition_dag_detail->m_dag_area_kr; ?>"
                                                        />
                                                </td>
                                            </tr>
                                    <?php
                                        endforeach;
                                    ?>

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
                                                <label for="inputEmail3" style="font-size:12px;" class="col-sm-1 control-label required">Dag No</label>
                                                <div class="col-sm-2">
                                                    <input type="text" readonly class="form-control" name="pdar_dag[]" value="<?=$value->dag_no;?>" >
                                                </div>
                                                <div class="col-sm-2">
                                                    <!-- <input type="hidden" name="pda_id_new[<?= $key . '_' . $value->dag_no ?>]" value="<?=$value->pdar_id;?>"> -->
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
                                                <div class="col-sm-2">
                                                    <input type="text" readonly class="form-control" value="<?=$value->pdar_father;?>" >
                                                </div>
                                                <label for="inputEmail3" style="font-size:12px;color: red;" class="col-sm-1 control-label required"><?php echo $this->lang->line('inplace_alongwith')?></label>
                                                <div class="col-sm-2">
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
                                </table>
                                <table class='table table-bordered'>
                                    <tbody class="applicant_tbody">
                                        <tr>
                                            <td colspan="10" style="background-color: #94baff;"><b>Add Applicant</b></td>
                                        </tr>
                                        <tr class="">
                                            <td>Sl No: </td>
                                            <td>Name: </td>
                                            <td>Gurdian: </td>
                                            <td>Relation: </td>
                                            <td>Gender: </td>
                                            <td>Mobile: </td>
                                            <td>Marital Status: </td>
                                            <td>Occupation: </td>
                                            <td>Caste: </td>
                                            <td>Action <button class="btn btn-warning btn-sm float-end" type="button" data-toggle="modal" data-target="#addApplicantModal">+ Add First Party</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class='table table-bordered'>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><?php echo $this->lang->line('detailed_report') ?></td>
                                        <td colspan="2"><?php echo $this->lang->line('dispute') ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <td colspan="3">
                                            <textarea rows="5" name='report_on_possession' style="width: 100%" >সকলো তথ্য় সঠিক | ভূমিলেখ্য সহায়ক</textarea>
                                        </td>
                                        <td colspan="2">
                                            <input type="checkbox" name='dispute' value="y"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="11" style="text-align: center;">
                                            <label><?php echo $this->lang->line('transfer_type') ?></label>
                                            <!-- <input type="hidden"  value="<?php echo $petition->mut_type; ?>" name="trans_code" style="width:20%;"/> -->
                                            <!-- <input type="text" readonly="" value="<?php echo $this->utilityclass->getTransferType($petition->trans_code); ?>" name="" style="width:20%;"/> -->
                                            <select name="trans_code">
                                                <?php foreach ($tranfer_type as $key => $value) { 
                                                    $selected= '';
                                                    if($petition->trans_code == $value['trans_code'])
                                                    {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option value="<?=$value['trans_code']?>" <?=$selected?>><?=$value['trans_desc_as']?></option>
                                                <?php } ?>
                                                
                                            </select>
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

<!-- Modal HTML -->
<div id="addApplicantModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add First Party</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="javascript:void(0)" id="addApplicantForm">
                <div class="text-center text-success app_add_scc text-bold" style="display: none;"></div>
                <input type="hidden" name="case_id" id="case_id" value="<?= $case_no; ?>">
                <input type="hidden" name="dist_code" value="<?= $dags[0]->dist_code ?>">
                <div class="row mx-3">
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Name</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Name" name="name_asm" id="first_party_name">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Guardian Name</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Guardian Name" name="guardian_name_asm" id="first_party_gurd_name">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Relation</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_guar_rel" name="relation">
                                <option value="">Select Relation</option>
                                <?php 
                                    foreach(json_decode(RELATION_NEW_APPL) as $relation_app):
                                ?>
                                        <option value="<?= $relation_app->CODE; ?>" data-name="<?= $relation_app->NAME; ?>"><?= $relation_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Gender</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_gender" name="gender">
                                <option value="">Select Gender</option>
                                <?php 
                                    foreach(json_decode(GENDER_NEW_APPL) as $gen_app):
                                ?>
                                        <option value="<?= $gen_app->CODE; ?>" data-name="<?= $gen_app->NAME; ?>"><?= $gen_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Mobile</label>
                            <input class="form-control add_applicant_fld" type="text" placeholder="Enter Mobile" id="first_party_mobile" name="mobile">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">DOB</label>
                            <input class="form-control add_applicant_fld dnt_show_in_tbl" type="date" id="first_party_dob" name="dob">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Marital Status</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_martial" name="marital_status">
                                <option value="">Select Marital Status</option>
                                <?php 
                                    foreach(json_decode(MARITAL_STATUS_NEW_APPL) as $marital_staus):
                                ?>
                                        <option value="<?= $marital_staus->CODE; ?>" data-name="<?= $marital_staus->NAME; ?>"><?= $marital_staus->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Occupation</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_occu" name="applicant_occupation">
                                <option value="">Select Occupation</option>
                                <?php 
                                    foreach(json_decode(OCCUPATION_NEW_APPL) as $occu_app):
                                ?>
                                        <option value="<?= $occu_app->CODE; ?>" data-name="<?= $occu_app->NAME; ?>"><?= $occu_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Caste</label>
                            <select class="form-control add_applicant_fld add_applicant_fld_select" id="first_party_cast" name="caste_category">
                                <option value="">Select Caste</option>
                                <?php 
                                    foreach(json_decode(CASTE) as $caste_app):
                                ?>
                                        <option value="<?= $caste_app->CODE; ?>" data-name="<?= $caste_app->NAME; ?>"><?= $caste_app->NAME; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Protected Class</label>
                            <select class="form-control add_applicant_fld_select dnt_show_in_tbl" id="first_party_protcast" name="tribe_category">
                                <?php 
                                    foreach(json_decode(PROTECTED_CLASS) as $protectedcls_app):
                                        if($protectedcls_app->CODE == -1):
                                ?>
                                            <option value="">Select Protected Class</option>
                                <?php 
                                        else:
                                ?>
                                            <option value="<?= $protectedcls_app->CODE; ?>" data-name="<?= $protectedcls_app->NAME; ?>"><?= $protectedcls_app->NAME; ?></option>
                                <?php
                                        endif;
                                ?>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <div class="form-group formgroup">
                            <label for="">Address</label>
                            <input class="form-control add_applicant_fld dnt_show_in_tbl" type="text" placeholder="Enter Address" id="first_party_address" name="address">
                            <span class="error text-danger add_applicant_fld_error"></span>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary app_modal_close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_applicant_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  -->

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

    getNoks();

    $(document).on('click', '.add_applicant_btn', function(){
        $('.error, .app_add_scc').text('');
        const $this = $(this);
        $this.attr('disabled', true);
        let allFieldHasVal = true;
        $('.add_applicant_fld').each(function() {
            let closestFormGroup = $(this).closest('.formgroup');
            if($(this).val() == ''){
                allFieldHasVal = false;
                $('.add_applicant_fld_error', closestFormGroup).text('The field is required');
            }
        });
        console.log(allFieldHasVal);
        if(!allFieldHasVal){
            $this.attr('disabled', false);

            return false;
        }

        let protectedClass = $('#first_party_protcast').val();
        let protectedClassNmAttr = $('#first_party_protcast').attr('name');
        if(protectedClass == ''){
            protectedClass = 'NA';
        }
        let address = $('#first_party_address').val();
        let addressNmAttr = $('#first_party_address').attr('name');

        let formData = new FormData(document.getElementById('addApplicantForm'));

        $.ajax({
            method: 'POST',
            data: formData,
            url: "<?= base_url('index.php/add-nok'); ?>",
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType    : 'json',
            success: function(response){
                if(response.success){
                    arrangeNok(response.data);
                    $('.app_add_scc').text(response.message).show();
                }else{
                    $('.app_add_scc').text(response.message).show();
                }
                
                $('#addApplicantForm').trigger("reset");
                $this.attr('disabled', false);
                
            },
            error: function(data){
                var errors = data.responseJSON;
            }
        });
        
        setTimeout(() => {
            $('.app_add_scc').hide(500);
        }, 2000);
    });

    $(document).on('click', '.delete_applicant', function(){
        const $this = $(this);
        Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'You want to delete this!',
                showCancelButton: true,
                // confirmButtonColor: '#2dbc9d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((response) => {
                if(response.isConfirmed){
                    if($this.hasClass('rtps_applicant')){
                        removeApplicant.push($this.attr('data-index'));
                        $this.closest('tr').remove();
                        manageSlNo();
                    }else{
                        const caseId = $('#case_id').val();
                        const serialId = $this.data('serial_id');
                        let formData = new FormData();
                            formData.append('case_id', caseId);
                            formData.append('row_id', serialId);
                        $.ajax({
                            url: "<?= base_url('index.php/delete-noks'); ?>",
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response){
                                if(response.success){
                                    $this.closest('tr').remove();
                                    manageSlNo();
                                }else{
                                    alert(response.message);
                                }
                            },
                            error: function(errorData){
                                alert("Something went wrong. Please try again later.");
                            }
                        });
                    }
                    
                }
            });
    });
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

function getNoks(){
    const caseId = $('#case_id').val();
    let formData = new FormData();
        formData.append('case_id', caseId);
    $.ajax({
        method: 'POST',
        data: formData,
        url: "<?= base_url('index.php/get-noks'); ?>",
        processData : false, // Don't process the files
        contentType : false, // Set content type to false as jQuery will tell the server its a query string request
        dataType    : 'json',
        success: function(response){
            if(response.success){
                arrangeNok(response.data);
            }
        },
        error: function(data){
            var errors = data.responseJSON;
        }
    });
}

function arrangeNok(datas){
    let html = '';
    $('.nok_tr').remove();
    if(datas.length > 0){
        $.each(datas, function(index, data){
            html += `<tr class="applicant_sl nok_tr">
                        <td class="sl_no"></td>
                        <td>${data.name_asm}</td>
                        <td>${data.guardian_name_asm}</td>
                        <td>${data.relation_name}</td>
                        <td>${data.gender_name}</td>
                        <td>${data.mobile}</td>
                        <td>${data.marital_status_name}</td>
                        <td>${data.applicant_occupation}</td>
                        <td>
                            ${data.caste_category_name}
                            ${data.tribe_category_name != '' ? `<br>(${data.tribe_category_name})` : `` }
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete_applicant" data-serial_id="${data.serial_id}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>`;
        });

        $('.applicant_tbody').append(html);

        manageSlNo();
    }
}

function manageSlNo(){
    $('.applicant_sl').each(function(index){
        let closestTr = $(this);
        $('.sl_no', closestTr).text(index + 1);
    });
}
</script>
</script>
<!--  -->
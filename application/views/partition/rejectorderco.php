<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">চক্র বিষয়াৰ হুকুম 
                       
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid">গোচৰ নং : <?php echo $this->session->userdata('case_no') ?></label>
                            
                            <label class="col-sm-4 rasid">তাং : <?php echo date('d/m/Y') ?></label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="" method='post' action="<?php echo base_url() . "index.php/partition/confirmRejectOrder"; ?>">
                            
                            <hr style="border-bottom: 2px solid #000;">
                            
                            <div class="row" id="show_div">
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">Reason of Rejection</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" rows="5" name='remark' id="textArea" placeholder=" Write Reason here.....">চক্ৰ বিষয়াৰ নিৰ্দেশত গোচৰ টো খাৰিজ কৰা হ'ল ।</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="case_no" value="<?=$this->input->get('case_no')?>">
                                <input type="hidden" name="type" value="<?=$this->input->get('type')?>">
                            </div>    
                                
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Reject Order</button>
                                <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_home'); ?>
                                </a>
                            </center>
                            <div class="row" id="re_lm_note1" style="display:none;">
                                <hr>
                                <div class="col-lg-12">
                                    <center>
                                        <button type="submit" name="submit" id="onsubmit" class="btn btn-danger uni_text"><i class='fa fa-check'></i>  <?php echo "Re Submit"; ?> </button>
                                    </center>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="col-lg-12 alert alert-warning">
                            <div class="col-lg-12 center">
                                <div class="btn btn-primary uni_text " data-toggle="modal" data-target="#myModalApplicant"><i class="fa fa-check-square-o "></i> &nbsp; Application Report</div>
                                <div class="btn btn-success uni_text" data-toggle="modal" data-target="#myModalByAy"><i class="fa fa-unlock-alt "></i> &nbsp; Byayprak Report
                                    <?php
                                    if ($pb->pay_notice_gen_yn == null and $byayprak->if_paid == null) {
                                        echo "<sup class='red blink_me'>Click here</sup>";
                                    }
                                    ?>
                                </div>
                                <div class="btn btn-info uni_text" data-toggle="modal" data-target="#myModalLM" ><i class="fa fa-unlock-alt "></i> &nbsp; Mondal Report</div>
                                <div class="btn btn-danger uni_text" data-toggle="modal" data-target="#myModalCONs" ><i class="fa fa-unlock-alt "></i> &nbsp; Copattadar report</div>
                                <div class="btn btn-success uni_text" data-toggle="modal" data-target="#myModalAST"  ><i class="fa fa-unlock-alt "></i> &nbsp; Assistant report</div>
                                <div class="btn btn-default uni_text" data-toggle="modal" data-target="#myModalSK"   ><i class="fa fa-unlock-alt "></i> &nbsp; Sk Report</div>
                            </div>
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalByAy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('byayprak_see_report_bhumi_revenue'); ?> </h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <hr>
                    <?php
                    $var = count($byayprak);
                    if ($var >= '1') {
                        ?>
                        <form class="form-horizontal unicode"  >
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('mouza_village_patta'); ?></label>
                                <div class="col-lg-8">
                                    <input type="text" readonly="" class="form-control uni_text input-lg" name="mouza_vill_name" value="<?php echo $byayprak->mouza_vill_name; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('pattdar_name_address'); ?> </label>
                                <div class="col-lg-8">
                                    <textarea readonly="" class="form-control uni_text" name="pdar_name_add" rows="3"><?php echo $byayprak->pdar_name_add; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('land_revenue'); ?></label>
                                <div class="col-lg-4">
                                    <input type="text" name="revenue" class="form-control" readonly="" value="<?php echo number_format($byayprak->revenue, 2); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('land_all_details'); ?></label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" name="land_details" readonly="" rows="3"><?php echo $byayprak->land_details; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('applicant_add_land'); ?></label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" name="pet_name_add_por" readonly="" rows="3"><?php echo $byayprak->pet_name_add_por; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('coppattdar_land_portion'); ?> </label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" readonly="" name="por_left_details" rows="3"><?php echo $byayprak->por_left_details; ?></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('time_taken_partition'); ?></label>
                                <div class="col-lg-4">
                                    <input type="text" readonly="" value="<?php echo $byayprak->survey_time; ?>" name="survey_time" class="form-control" >
                                </div>
                            </div>          


                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('total_cost_details'); ?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="exp_details" readonly="" rows="3"><?php echo $byayprak->exp_details; ?></textarea>
                                </div>
                                <div class="col-lg-2">
                                    <?php echo $this->lang->line('total_cost'); ?>
                                    <input type="text" value="<?php echo number_format($byayprak->exp_details_total, 2); ?>" readonly="" name="exp_details_total" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('cost_from_copattadar'); ?> </label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="copdar_amt" readonly="" rows="3"><?php echo $byayprak->copdar_amt; ?></textarea>
                                </div>
                                <div class="col-lg-2">
                                    <?php echo $this->lang->line('total_cost'); ?>
                                    <input type="text" value="<?php echo number_format($byayprak->copdar_amt_total, 2); ?>" readonly="" name="copdar_amt_total" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('time_taken_for_revenue_collect'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="exp_deposite_time" class="form-control" value="<?php echo $byayprak->exp_deposite_time; ?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label uni_text"><?php echo $this->lang->line('payment_over_not'); ?> </label>
                                <div class="col-lg-6">
                                    <?php if ($byayprak->if_paid == 'Y') {
                                        ?>
                                        <span class="green uni_text"><?php echo $this->lang->line('payment_done'); ?></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="red uni_text"><?php echo $this->lang->line('payment_notdone'); ?></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('time_taken_for_byayprak'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="byayprak_comp_time" class="form-control" value="<?php echo $byayprak->byayprak_comp_time; ?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-4 control-label"><?php echo $this->lang->line('short_notes'); ?>  </label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" name="remarks" readonly="" rows="3"><?php echo $byayprak->remarks; ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 pull-right" style="margin-top: 20px">
                                <p class="uni_text">
                                    <?php
                                    //var_dump($LMName);
                                    $LMName = $this->utilityclass->getDefinedMondalsName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $byayprak->user_code);
                                    //var_dump($LMName);
                                    echo $LMName->lm_name;
                                    ?>
                                </p>
                                <p class="uni_text"><?php echo $this->lang->line('lm_sign'); ?></p>
                                <p class="uni_text" style="margin-top: 10px"> <?php echo $this->lang->line('lm_sign_date'); ?> : <?php echo date('d/m/Y', strtotime($byayprak->date_entry)) ?></p>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="myModalLM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('mondal_report') ?>(<?php echo $this->lang->line('case_no') ?><?php echo $this->session->userdata('case_no'); ?>)</h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <hr>
                    <?php
                    foreach ($lmNote as $lmNote) {
                        ?>
                        <p class="uni_text text-danger badge badge-info">Order Serial No : <?php echo $lmNote->note_no + 1; ?></p>
                        <form class="form-horizontal unicode" >
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('mutation_is_not') ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    if ($lmNote->mutation_yn == 'Y') {
                                        $mutation_yn = "আছে";
                                    } else {
                                        $mutation_yn = "নাই";
                                    }
                                    ?>
                                    <input type="text" readonly="" value="<?php echo $mutation_yn; ?>" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('mutation_year') ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" value="<?php echo $lmNote->mutation_year; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_how') ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    $q = "Select trans_desc_as from nature_trans_code where trans_code= '$lmNote->trans_code' ";
                                    $v = $this->db->query($q)->row();
                                    ?>
                                    <input type="text" class="form-control" readonly="" value="<?php echo $v->trans_desc_as; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_other_case') ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    if ($lmNote->other_cases_yn == 'Y') {
                                        $other_cases_yn = "আছে";
                                    } else {
                                        $other_cases_yn = "নাই";
                                    }
                                    ?>
                                    <input type="text" name="other_cases_yn" readonly="" class="form-control" value="<?php echo $other_cases_yn; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('partition_revenue_year') ?> </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" readonly="" value="<?php echo $lmNote->revenue_paid_year; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('consent_yes_no') ?> </label>
                                <div class="col-sm-3">
                                    <?php
                                    if ($lmNote->copdar_complain_yn == 'Y') {
                                        $copdar_complain_yn = "আছে";
                                    } else {
                                        $copdar_complain_yn = "নাই";
                                    }
                                    ?>
                                    <input type="text" class="form-control" readonly="" value="<?php echo $copdar_complain_yn; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('trace_map_show') ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    if ($lmNote->trace_map_yn == 'Y') {
                                        $trace_map_yn = "আছে";
                                    } else {
                                        $trace_map_yn = "নাই";
                                    }
                                    ?>
                                    <input type="text" name="trace_map_yn" class="form-control" readonly="" value="<?php echo $trace_map_yn; ?>">
                                </div>
                            </div>          
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('tracemap_byayprak') ?></label>
                                <div class="col-sm-3">
                                    <?php
                                    if ($lmNote->ror_byayprak_yn == 'Y') {
                                        $ror_byayprak_yn = "আছে";
                                    } else {
                                        $ror_byayprak_yn = "নাই";
                                    }
                                    ?>
                                    <input type="text" name="ror_byayprak_yn" class="form-control" readonly="" value="<?php echo $ror_byayprak_yn; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('short_notes') ?> </label>
                                <div class="col-lg-6">
                                    <textarea class="form-control" name="lm_note" rows="3"><?php echo $lmNote->partition_info; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-6 control-label"><?php echo $this->lang->line('min_revenue') ?> </label>
                                <div class="col-sm-3">
                                    <input type="text" readonly="" class="form-control" name="min_revenue" value="<?php echo number_format($lmNote->min_revenue, 2); ?>" >
                                </div>
                            </div>
                            <hr>
                            <p class="uni_text"> <?php echo $this->lang->line('partition_skReport') ?> :-</p>
                            <p class="uni_text"><?php echo $lmNote->sk_note; ?> </p>
                            <hr>
                            <div class="col-lg-12" >
                                <span class="pull-left uni_text">
                                    <?php
                                    if ($lmNote->sk_sign_yn == 'Y') {

                                        $s = $this->utilityclass->getDefinedSKName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $lmNote->user_code);
                                        echo $s->username;
                                        //var_dump($s);
                                    }
                                    ?>
                                    <br>
                                    <?php echo $this->lang->line('sk_sign'); ?> </span>
                                <span class="pull-right uni_text">
                                    <?php
                                    $LMName = $this->utilityclass->getDefinedMondalsName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $pb->mouza_pargona_code, $pb->lot_no, $lmNote->lm_code);
                                    //var_dump($LMName);
                                    echo $LMName->lm_name;
                                    ?>
                                    <br>
                                    <?php echo $this->lang->line('lm_sign'); ?> </span><br/><br/><br/><br/>

                            </div>
                            <div class="col-lg-12" >
                                <span class="uni_text pull-right"> <?php echo $this->lang->line('lm_sign_date'); ?> : <?php echo date('d/m/Y', strtotime($lmNote->date_entry)); ?> </span>
                            </div>
                        </form>
                        <hr  style=" border:2px solid #000; width: 100%">
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="myModalCONs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('consent_copattadar_rpt'); ?></h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <form class="form-horizontal unicode" >
                        <h4><?php echo $this->lang->line('case_no'); ?> : <?php echo $this->session->userdata('case_no') ?></h4>
                        <hr>
                        <?php
                        $i = 0;
                        foreach ($consent as $c) :
                            ?>
                            <p class="uni_text text-danger badge badge-info"> Serial No : <?php echo $i + 1; ?></p>
                            <div class="form-group">
                                <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('name') ?>: </label>
                                <div class="col-sm-6 uni_text"><?php echo $c->copattadar_name; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('copattadar_comment') ?></label>
                                <div class="col-sm-6 uni_text">
                                    <?php
                                    if ($c->consent == 'Y') {
                                        $var = 'আছে';
                                    } else {
                                        $var = 'নাই';
                                    }
                                    echo $var;
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-sm-4 control-label"><?php echo $this->lang->line('comment') ?> </label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="copattadar_comment" rows="3"><?php echo $c->copattadar_comment; ?></textarea>
                                </div>
                            </div>
                            <hr  style=" border:1px solid #000; width: 100%">
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </form>
                    <hr>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalAST" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="center">ORDER SHEET</h2>
                <p class="center">See Rule of 129 Records Manual 1911</p>
                <div style="margin-top: 10px">
                    <p class="center">Order Sheet,  Dated From <?php echo date('d-m-Y', strtotime($pb->submission_date)); ?> to <?php
                        echo date('d-m-Y', strtotime($pb->next_date_of_hearing));
                        ;
                        ?> </p>
                    <p class="center">Case No : <?php echo $pb->case_no; ?></p>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <form>
                        <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                            <table class="table table-bordered" style="font-size: 16px;">
                                <tr style="color:#0000cc; text-align: center;">
                                    <td>Serial No and Date of Order</td>
                                    <td width="40%">Order and Signature of Officer</td>
                                    <td width="40%">Note Of Action Taken on Order</td>
                                </tr>
                                <tr style="color:#0000cc; text-align: center;">
                                    <td>১</td>
                                    <td>২</td>
                                    <td>৩</td>
                                </tr>
                                <?php
                                $i = 1;
                                foreach ($pd as $case):
                                    ?>
                                    <tr>
                                        <td><?php echo "(" . $i . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                        <td>
                                            <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
                                            <?php echo $case->co_order; ?></td>
                                        <td>
                                            <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                            <textarea name="note_on_order[]" rows="5" cols="8" class="form-control"><?php echo $case->note_on_order; ?></textarea>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                endforeach;
                                ?>
                            </table>
                        </div>

                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="myModalSK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('partition_skReport'); ?></h2>
            </div>
            <hr>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <?php
//           var_dump($lmNote);
                    foreach ($skNote as $lmNote) {
                        ?>
                        <p class="uni_text text-danger badge badge-info">Order Serial No : <?php echo $lmNote->note_no + 1; ?></p>
                        <form class="form-horizontal unicode" >
                            <div class="form-group">
                                <label for="select" class="col-sm-2 control-label"><?php echo $this->lang->line('comment'); ?></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="sk_comment" rows="5"><?php echo $lmNote->sk_note; ?></textarea>
                                </div>
                            </div>
                        </form>
                        <span><?php echo $this->lang->line('sk_sign'); ?> </span> : 
                        <?php
                        if ($lmNote->sk_sign_yn == 'Y') {
                            $s = $this->utilityclass->getDefinedSKName($pb->dist_code, $pb->subdiv_code, $pb->cir_code, $lmNote->user_code);
                            echo $s->username;
                        }
                        ?>
                        <p> <?php echo $this->lang->line('date') ?> : <?php echo date('d-m-Y', strtotime($lmNote->sk_note_date)); ?></p>
                        <hr  style=" border:2px solid #000; width: 100%">
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalApplicant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('case_no') ?>: <?php echo $this->session->userdata('case_no') ?></h2>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" >
                    <div class="form_1" >
                        <fieldset><legend><?php echo $this->lang->line('partion_applicant_dtls') ?> </legend>
                            <table class="table_border">
                                <tr>
                                    <td><?php echo $this->lang->line('district'); ?> : <?php echo $location['dist']; ?> </td>
                                    <td> <?php echo $this->lang->line('subdivision'); ?>  : <?php echo $location['sub']; ?></td>
                                    <td> <?php echo $this->lang->line('circle'); ?>  : <?php echo $location['cir']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('mouza'); ?>   : <?php echo $location['mouza']; ?></td>
                                    <td> <?php echo $this->lang->line('lot_no'); ?>   : <?php echo $location['lot']; ?></td>
                                    <td><?php echo $this->lang->line('vill_town'); ?> :<?php echo $location['vill']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('date_applied'); ?> : <?php
                                        echo date('d-m-Y', strtotime($pb->submission_date));
//echo "$date";
                                        ?></td><td><?php echo $this->lang->line('type') ?> : বাটোৱাৰা 
                                        <?php
                                        if ($pb->complete_partition_yn == 'Y') {
                                            echo "( সম্পূৰ্ণ )";
                                        } else {
                                            echo "( অসম্পূৰ্ণ )";
                                        }
                                        ?> </td>
                                    <td> <?php echo $this->lang->line('user_designation'); ?>  : চক্র বিষয়া</td>
                                </tr>

                            </table>  

                        </fieldset>
                    </div>
                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dag_dtls'); ?></legend>
                            <table class="table table-bordered">
                                <tr>
                                    <th><?php echo $this->lang->line('dag_no'); ?></th><th><?php echo $this->lang->line('applicant_portion'); ?> (B - K - L)</th>
                                    <th><?php echo $this->lang->line('revenue'); ?>  (Rs/-) </th><th><?php echo $this->lang->line('patta_no') ?> </th>
                                    <th><?php echo $this->lang->line('patta_type'); ?>  </th>
                                </tr>
                                <tr class="text-center">
                                    <?php foreach ($dags as $d): ?>
                                        <td><?php echo $d->dag_no; ?></td><td> <?php echo $d->m_dag_area_b; ?>-<?php echo $d->m_dag_area_k; ?>-<?php echo $d->m_dag_area_lc; ?> </td>
                                        <td><?php echo number_format($d->revenue, 2); ?></td><td><?php echo $d->patta_no; ?></td>
                                        <td><?php
                                            $patta_type = $d->patta_type_code;
                                            $sql = "Select patta_type from patta_code where type_code='$patta_type' ";
                                            //echo $sql;
                                            $pattaCode = $this->db->query($sql)->row();
                                            echo $pattaCode->patta_type;
                                            ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </table>  
                        </fieldset>
                    </div>

                    <div class="form_1">
                        <fieldset><legend><?php echo $this->lang->line('applicant_dtls'); ?></legend>
                            <div class="col-lg-12">
                                <?php
                                $count = 1;
                                foreach ($PetiPart as $p):
                                    ?>
                                    <p class="uni_text">(<?php echo $count++; ?>) <?php echo $this->lang->line('applicant_name') ?> : <?php echo $p->pdar_name; ?></p>
                                    <table class="table_border unicode " >
                                        <tr><td><?php echo $this->lang->line('guardian_name'); ?>  : <?php echo $p->pdar_guardian; ?></td><td><?php echo $this->lang->line('relation') ?>  : <?php echo $this->utilityclass->get_relation($p->pdar_rel_guar); ?></td></tr>
                                        <tr><td><?php echo $this->lang->line('address1') ?> : <?php echo $p->pdar_add1; ?> </td><td><?php echo $this->lang->line('address2') ?> : <?php echo $p->pdar_add2; ?></td></tr>
                                        <tr class='hide'><td><?php echo $this->lang->line('remaing_land_exist_not') ?>  ::
                                                <?php
                                                if ($p->is_converted_pattadar == 'N') {
                                                    echo "নাথাকে";
                                                } else {
                                                    echo "ঠাকিব";
                                                }
                                                ?>
                                            </td><td></td></tr>
                                    </table>
                                <?php endforeach; ?>    
                            </div> 
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('input[type="radio"]').click(function () {
            if ($(this).attr("value") == "P") {
                $(".squaredTwo").attr("disabled", false);
            }
            if ($(this).attr("value") == "F") {
                $(".squaredTwo").attr("disabled", true);
                $('.squaredTwo').prop('checked', false);
            }
            if ($(this).attr("value") == "D") {
                $(".squaredTwo").attr("disabled", true);
                $('.squaredTwo').prop('checked', false);
            }
        })
        $('#BackMain').click(function () {
            location.href = "<?php echo base_url() ?>index.php/home";
        })
    });
    ;
</script>
<script>
    $(document).ready(function () {
        $('.myPop').popover();
    });
</script>


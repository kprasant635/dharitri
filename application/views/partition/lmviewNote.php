            <div class="card-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title center uni_text" id="myModalLabel"><?php echo $this->lang->line('mondal_report') ?>(<?php echo $this->lang->line('case_no') ?>: <?php echo $this->session->userdata('case_no'); ?>)</h2>
            </div>
            <div class="card-body">
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
                                   
                                    <input type="text" class="form-control" readonly="" value="<?php echo $this->utilityclass->getTransferType($lmNote->trans_code); ?>" >
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

                                        $s = $this->utilityclass->getDefinedSKName($lmNote->dist_code, $lmNote->subdiv_code, $lmNote->cir_code, $lmNote->user_code);
                                        echo $s->username;
                                        //var_dump($s);
                                    }
                                    ?>
                                    <br>
                                    <?php echo $this->lang->line('sk_sign'); ?> </span>
                                <span class="pull-right uni_text">
                                    <?php
                                    $LMName = $this->utilityclass->getDefinedMondalsName($lmNote->dist_code, $lmNote->subdiv_code, $lmNote->cir_code, $lmNote->mouza_pargona_code, $lmNote->lot_no, $lmNote->lm_code);
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
                    <hr>
                    <!-- <div class="col-lg-12 col-sm-12 col-xs-12 col-sm-12 alert alert-info">
                        <div class="col-lg-12 text-bold"></div>
                        <p class="uni_text text-red"><u>LM Revert Report</u></p>
                        <?php //$i=1; //foreach($lm_revert_note as $note): ?>
                            <div class="col-lg-4 col-md-4 col-xs-12 col-sm-6">
                                <p class="uni_text"> <?php //echo $i++ .")". $note->order_date; ?> </p>
                            </div>
                            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-6">
                                <p class="uni_text"><?php //echo $note->co_order; ?> </p>
                            </div>
                        <?php //endforeach; ?>
                    </div> -->
                </div>
            </div>
            
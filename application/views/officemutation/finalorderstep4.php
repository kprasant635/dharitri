<div class="row login">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold rasid'><u><?php echo $this->lang->line('mutation_order_form');?> <span style='color: red;'>(Office Mutation Order Details)</span></u></p>
                </div>
            </div>
            <div class="panel-heading">
                <label class="col-sm-5 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                <label class="col-sm-2 rasid"><p class='bold uni_text text-center'>&nbsp;</p></label>
                <label class="col-sm-5 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y'); ?></label>
                <hr style="border-bottom: 2px solid #000;">
            </div>
            <div class="panel-body">
                <?php $action = base_url() . "index.php/coofficemutation/finalOrderStep4"; ?>
                <form class='form-horizontal' action="<?php echo $action; ?>" method="post">
                    <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
                    <input type="hidden" class="form-control" name="dist_code" value="<?php echo $data->dist_code; ?>" readonly>
                    <input type="hidden" class="form-control" name="subdiv_code" value="<?php echo $data->subdiv_code; ?>" readonly>
                    <input type="hidden" class="form-control" name="cir_code" value="<?php echo $data->cir_code; ?>" readonly>
                    <input type="hidden" class="form-control" name="mouza_pargona_code" value="<?php echo $data->mouza_pargona_code; ?>" readonly>
                    <input type="hidden" class="form-control" name="lot_no" value="<?php echo $data->lot_no; ?>" readonly>
                    <input type="hidden" class="form-control" name="vill_townprt_code" value="<?php echo $data->vill_townprt_code; ?>" readonly>
                    <?php if ($data->new_pattadar): ?>
                        <input type='hidden' name='new_pattadar' value='N' />
                    <?php endif; ?>
                    <input type='hidden' name='dag_no' value='<?php echo $data->dag_no; ?>' />
                    <p class='bold uni_text text-center'>In Favour Of Details</p>
                    <table class='table table-striped table-bordered' style="font-size: 20px;">
                        <tr>
                            <td width="40%">
                                <label>Applicant Details</label>
                            </td>
                            <td>
                                <label><?php echo $this->lang->line('applicant_individual_land_portion');?></label>
                            </td>
                        </tr>
                        <?php
                        foreach($applicants as $applicant):
                        {
                            ?>
                            <tr>
                                <td>
                                    <input type="hidden" class="form-control" name="infavor_of_id[]" value="<?php echo $applicant->pet_id; ?>" />
                                    <?php echo $count.". " ?>
                                    <input type="hidden" class="form-control" name="infavor_of_name[]" value="<?php echo $applicant->pet_name; ?>" >
                                    <?php echo "<span style='color:red;'>".$applicant->pet_name."</span>"; ?>
                                    <input type="hidden" class="form-control" name="infavor_of_guardian[]" value="<?php echo $applicant->guard_name; ?>" />
                                    <?php echo " (".$applicant->guard_name.") "; ?>
                                    <input type="hidden" class="form-control" name="infav_of_guar_relation[]" value="<?php echo $applicant->guard_rel; ?>" >
                                    <input type="hidden" class="form-control" name="infavor_of_add1[]" value="<?php echo $applicant->add1; ?>" >
                                    <input type="hidden" class="form-control" name="infavor_of_add2[]" value="<?php echo $applicant->add2; ?>" >
                                </td>
                                <td>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('bigha');?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="land_area_b[]" value="<?php echo $applicant->applied_b; ?>" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('katha');?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="land_area_k[]" value="<?php echo $applicant->applied_k; ?>" >
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo $this->lang->line('lessa');?></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="land_area_lc[]" value="<?php echo $applicant->applied_lc; ?>" >
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        $count++;
                        endforeach;
                        ?>
                    </table>
                    <p class='bold uni_text text-center'><?php echo $this->lang->line('basic_order_details') ?></p>    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label"><?php echo $this->lang->line('order_no') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="ord_no" value="<?php echo $case_no; ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" ><?php echo $this->lang->line('order_date') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="ord_date" value="<?php echo date('d-m-Y'); ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" ><?php echo $this->lang->line('patta_type') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" value="<?php echo $this->utilityclass->getPattaName($data->patta_type_code); ?>" readonly/>
                                    <input type="hidden" class="form-control" name="patta_type_code" value="<?php echo $data->patta_type_code; ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" ><?php echo $this->lang->line('patta_no') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="patta_no" value="<?php echo $data->patta_no ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" class="form-control" name="by_right_of" value="<?php echo $trans_code; ?>" readonly>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('deed_no') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="reg_deal_no" value="<?php echo $deed_no; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('deed_value') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="deed_value" value="<?php echo $deed_value; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($deed_date){?>
                    <div class="row">

                    <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('deed_date') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="deed_date" value="<?php echo $deed_date; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('registration_date') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="reg_date" value="<?php echo date('d-m-Y', strtotime($submission_date)); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 uni_text control-label" id='applicant_name_label'><?php echo $this->lang->line('sub_registration_office') ?></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="sub_reg_office" value="<?php echo $sub_reg_office; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-bottom: 2px solid #000;">
                    <div class="col-lg-12">
                        <center>
                            <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;Proceed to Along With / Inplace of Details</button>
                            <!--<a href="<?php echo base_url(); ?>index.php/coofficemutation/finalorderstep2?case_no=<?php echo $case_no; ?>" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>-->
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
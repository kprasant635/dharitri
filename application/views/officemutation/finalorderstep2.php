<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Office Mutation Order</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $case_no; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('basic_order_details');?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y'); ?></label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="unicode" method='post' action="<?php echo base_url() . "index.php/coofficemutation/finalorderstep2"; ?>">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class='table table-striped'>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_no');?> :</label></td>
                                            <td><input type="text" name="ord_no" value="<?php echo $case_no; ?>" class="form-control" readonly/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('lm_name');?> :</label></td>
                                            <td><?php $lmcode = $lm_code;
                                                    $lms = $this->utilityclass->getDefinedMondalsName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $lmcode);
                                                ?>
                                                <input type="text" name="" value="<?php echo $lms->lm_name; ?>" class="form-control" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_date');?>  :</label></td>
                                            <td><input type="text" class="form-control uni_text" name="ord_date" value="<?php echo date('d-m-Y'); ?>" ></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('lm_sign_y_n');?> :</label></td>
                                            <td>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" <?php echo ($lm_sign_yn == 'Y') ? "Checked" : ""; ?> name="lm_sign_yn" value="y"> আছে
                                                </label>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" name="lm_sign_yn" <?php echo (!$lm_sign_yn) ? "Checked" : ""; ?> value="n"> নাই
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_type');?></label></td>
                                            <td><?php $order_type = $this->utilityclass->getOfficeMutType($data->mut_type); ?>
                                                <input type="text" class="form-control uni_text" name="ord_type_code" value="<?php echo $order_type; ?>"></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('lm_sign_date');?></label></td>
                                            <td><input type="text" class="form-control" name="lm_sign_date" value="<?php echo date('d-m-Y', strtotime($lm_note_date)); ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_passed_by');?></label></td>
                                            <td><input type="text" name="ord_passby_desig" value="CO" class="form-control" readonly/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('sk_name');?></label></td>
                                            <td><?php $sks = $this->utilityclass->getSKName($data->dist_code, $data->subdiv_code, $data->cir_code, $user_code);
                                                foreach ($sks as $sk){
                                                    $sk_name = $sk->username;
                                                    $sk_code = $sk->user_code;
                                                }
                                            ?>
                                                <input type="text" name="" value="<?php echo $sk_name; ?>" class="form-control" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_passed_by_sign_yes_no');?></label></td>
                                            <td>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" checked name="ord_passby_sign_yn" value="y"> আছে
                                                </label>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" name="ord_passby_sign_yn" value="n"> নাই
                                                </label>
                                            </td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('sk_sign_y_n');?></label></td>
                                            <td>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" <?php echo ($sk_sign_yn == 'Y') ? "Checked" : ""; ?> name="sk_sign_yn" value="Y"> আছে
                                                </label>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" <?php echo (!$sk_sign_yn) ? "Checked" : ""; ?> name="sk_sign_yn" value="N"> নাই
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('case_no');?></label></td>
                                            <td><input type="text" name="case_no" value="<?php echo $case_no; ?>" class="form-control" readonly/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('sk_sign_date');?></label></td>
                                            <td><input type="text" class="form-control" id="inputEmail3" value="<?php echo date('d-m-Y', strtotime($sk_note_date)); ?>" placeholder=""></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('ref_letter_no');?></label></td>
                                            <td><input type="text" name="" value="" class="form-control"/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('co_name');?></label></td>
                                            <td><?php $cos = $this->utilityclass->getCOName($data->dist_code, $data->subdiv_code, $data->cir_code, $this->session->userdata('user_code'));
                                                foreach ($cos as $co){
                                                    $co_name = $co->username;
                                                    $co_code = $co->user_code;
                                                }
                                            ?>
                                                <input type="text" name="" value="<?php echo $co_name; ?>" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('co_sign_date');?></label></td>
                                            <td><input type="text" class="form-control" name="co_ord_date" value="<?php echo date('d-m-Y'); ?>" placeholder=""></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('co_sign');?></label></td>
                                            <td>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" checked name="co_sign_yn" value="y"> আছে
                                                </label>
                                                <label class="radio-inline uni_text regular">
                                                    <input type="radio" id="inlineCheckbox2" name="co_sign_yn" value="n"> নাই
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr style="border-bottom: 2px solid #000;">
                                </div>
                                <div class="col-lg-12">
                                    <center>
                                        <input type="hidden" name="co_code" value="<?php echo $co_code; ?>">
                                        <input type="hidden" name="lm_code" value="<?php echo $lmcode; ?>">
                                        <input type="hidden" name="sk_code" value="<?php echo $sk_code; ?>">
                                        <input type='hidden' name="case_no" value="<?php echo $case_no; ?>"/>
                                        <input type="hidden" class="form-control" name="dist_code" value="<?php echo $data->dist_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="subdiv_code" value="<?php echo $data->subdiv_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="cir_code" value="<?php echo $data->cir_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="mouza_pargona_code" value="<?php echo $data->mouza_pargona_code; ?>" readonly>
                                        <input type="hidden" class="form-control" name="lot_no" value="<?php echo $data->lot_no; ?>" readonly>
                                        <input type="hidden" class="form-control" name="vill_townprt_code" value="<?php echo $data->vill_townprt_code; ?>" readonly>
                                        <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;Proceed to In favour of Details</button>
                                        <a href="<?php echo base_url(); ?>index.php/coofficemutation/proceeding2?case_no=<?php echo $case_no."&dist_code=".$data->dist_code."&subdiv_code=".$data->subdiv_code."&cir_code=".$data->cir_code."&mouza_pargona_code=".$data->mouza_pargona_code."&lot_no=".$data->lot_no."&vill_townprt_code=".$data->vill_townprt_code; ?>" class="btn btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


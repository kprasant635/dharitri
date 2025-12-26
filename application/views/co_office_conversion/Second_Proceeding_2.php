<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Circle Officer's Conversion Order</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $display['case_no']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('basic_order_details');?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y', strtotime($display['date'])); ?></label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="unicode" method='post' action="<?php echo base_url() . "index.php/COconversionPartha/FourthProceeding"; ?>">
                        <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                            { ?>
                            <input type="hidden" name="ulpin" id="ulpin" value="<?= $ulpin ?>" />
                            <input type="hidden" name="chain_revenue" id="chain_revenue" value="<?= $chain_revenue ?>" />
                            <input type="hidden" name="chain_local_tax" id="chain_local_tax" value="<?= $chain_local_tax ?>" />
                            <input type="hidden" name="ulpin" id="ulpin" value="<?= $ulpin ?>" />
                            <?php if (isset($old_ulpin)) { ?>
                                <input type="hidden" name="old_ulpin" id="old_ulpin" value="<?= $old_ulpin ?>" />
                            <?php } ?>

                        <?php }?>



                            <div class="row">
                                <div class="col-lg-12">
                                    <table class='table table-striped'>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_no');?> :</label></td>
                                            <td><input type="text" name="order_no" value="<?php echo $display['case_no']; ?>" class="form-control" readonly/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('lm_name');?> :</label></td>
                                            <td><input type="text" name="lm_name" value="<?php echo $display['lm_name']; ?>" class="form-control"/></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_date');?>  :</label></td>
                                            <td><input type="text" name="order_date" id="popupDatepicker" class="form-control" required/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('lm_sign_y_n');?> :</label></td>
                                            <td>
                                                <label class="control-label" >
                                                    <input type="radio" name="lm_sign" id="inlineRadio1" value="y" checked> <?php echo $this->lang->line('yes');?> 
                                                </label>
                                                <label class="control-label" >
                                                    <input type="radio" name="lm_sign" id="inlineRadio2" value="n"> <?php echo $this->lang->line('no');?> 
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_type');?></label></td>
                                            <td><input type="text" name="order_type" value="<?php echo $display['order_type']; ?>" class="form-control"/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('lm_sign_date');?></label></td>
                                            <td><input type="text" name="lm_sign_date" value="<?php echo date('d-m-Y', strtotime($display['lm_note_date'])); ?>" class="form-control"/></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_passed_by');?></label></td>
                                            <td><input type="text" name="order_passed_by" value="CO" class="form-control" readonly/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('sk_name');?></label></td>
                                            <td><input type="text" name="sk_name" value="<?php echo $display['sk_name']; ?>" class="form-control"/></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('order_passed_by_sign_yes_no');?></label></td>
                                            <td>
                                                <label class="control-label" >
                                                    <input type="radio" name="order_passed_sign" id="inlineRadio1" value="y" checked> <?php echo $this->lang->line('yes');?> 
                                                </label>
                                                <label class="control-label" >
                                                    <input type="radio" name="order_passed_sign" id="inlineRadio2" value="n"> <?php echo $this->lang->line('no');?> 
                                                </label>
                                            </td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('sk_sign_y_n');?></label></td>
                                            <td>
                                                <label class="control-label" >
                                                    <input type="radio" name="sk_sign" id="inlineRadio1" value="y" checked> <?php echo $this->lang->line('yes');?>  
                                                </label>
                                                <label class="control-label" >
                                                    <input type="radio" name="sk_sign" id="inlineRadio2" value="n"> <?php echo $this->lang->line('no');?> 
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('case_no');?></label></td>
                                            <td><input type="text" name="case_no" value="<?php echo $display['case_no']; ?>" class="form-control" readonly/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('sk_sign_date');?></label></td>
                                            <td><input type="text" name="sk_sign_date" value="<?php echo date('d-m-Y', strtotime($display['sk_note_date'])); ?>" class="form-control" readonly/></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('ref_letter_no');?></label></td>
                                            <td><input type="text" name="ref_letter" value="" class="form-control"/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('co_name');?></label></td>
                                            <td><input type="text" name="co_name" value="<?php echo $display['co_name']; ?>" class="form-control"/></td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label" ><?php echo $this->lang->line('co_sign_date');?></label></td>
                                            <td><input type="text" name="co_order_date" id='popupDatepicker' value="<?php echo date('d-m-Y', strtotime($display['co_order_date']));?>" class="form-control"/></td>
                                            <td><label class="control-label" ><?php echo $this->lang->line('co_sign');?></label></td>
                                            <td>
                                                <label class="control-label" >
                                                    <input type="radio" name="co_sign" id="inlineRadio1" value="y" checked>  <?php echo $this->lang->line('yes');?>
                                                </label>
                                                <label class="control-label" >
                                                    <input type="radio" name="co_sign" id="inlineRadio2" value="n"> <?php echo $this->lang->line('no');?>
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr style="border-bottom: 2px solid #000;">
                                </div>
                                <div class="col-lg-12">
                                    <center>
                                        <input type="hidden" name="co_code" value="<?php echo $display['co_code']; ?>">
                                        <input type="hidden" name="lm_code" value="<?php echo $display['lm_code']; ?>">
                                        <input type="hidden" name="sk_code" value="<?php echo $display['sk_code']; ?>">
                                        <button type="submit" name="submit" class="btn btn-success uni_text" value="false"><i class='fa fa-check'></i> <?php echo $this->lang->line('write_report');?> / Proceed</button>
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


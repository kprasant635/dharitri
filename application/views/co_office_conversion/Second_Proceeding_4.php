<div class="row login">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold rasid'><u><?php echo $this->lang->line('mutation_order_form');?> <span style='color: red;'>(<?php echo $this->lang->line('conversion_order_details');?>)</span></u></p>
                </div>
            </div>
            <hr>
            <div class="panel-body">
                <form class='form-horizontal' action="" id='pattadardetails' method="post" name="officemutationpattadardetails">
                    
                    <table class='table table-striped table-bordered' style="font-size: 20px;">
                        <tr>
                            <td width="50%">
                            <label for="inputEmail3"  class="col-sm-6 control-label"><?php echo $this->lang->line('sl_no');?></label>
                            <div class="col-sm-2">
                                <input type="text" readonly class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                            </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr> 
                        <tr>
                            <td>
                                <label for="inputEmail3"  class="col-sm-6 control-label"><?php echo $this->lang->line('on_behalf_of_name');?></label>
                        <div class="col-sm-6">
                            <select   class="form-control pattadar_name" name="pdar_name" id="pdar_name" >
                                <option selected><?php echo $this->lang->line('select_pattadar');?></option>

                            </select>
                        </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('type_of_premium');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="prem_type" value="<?php echo $payment_type->chalan_name; ?>" readonly>
                        </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('premium_chalan_receipt_no');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="chalan_no" value="<?php echo $datas['premium_reciept']; ?>" readonly>
                        </div>
                            </td>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('premium');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="prem_amt" value="<?php echo $datas['premium_amount']; ?>" readonly>
                        </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label><?php echo $this->lang->line('applicant_individual_land_portion');?></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_bigha');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="c_bigha" value="<?php echo $datas['bigha']; ?>" readonly>
                        </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_katha');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="c_kotha" value="<?php echo $datas['kotha']; ?>" readonly>
                        </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_lessa');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="c_lessa" value="<?php echo $datas['lessa']; ?>" readonly>
                        </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_type');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="patta_type" value="<?php echo $datas['patta_type']; ?>" readonly>
                        </div></td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_no');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="patta_no" value="<?php echo $datas['patta_no']; ?>" readonly>
                        </div></td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('new_patta_type');?></label>
                        <div class="col-sm-6">
                            <select class="form-control new_patta_type" name="new_patta_type">
                                        <?php foreach($type as $t): ?>
                                        <option value="<?php echo $t->type_code; ?>"><?php echo $t->patta_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                        </div></td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_patta_no');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="newPatta" name="sugg_patta_no" value="<?php echo $datas['newpatta']; ?>" readonly>
                        </div>
                            </td>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('existing_old_patta_no');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="old_patta_no" value="<?php echo $datas['patta_no']; ?>" readonly>
                        </div></td>
                        </tr>
                        <tr>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no');?> </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="newDag" name="sugg_dag_no" value="<?php echo $datas['new_dag']; ?>" readonly>
                        </div></td>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('existing_old_dag_no');?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="old_dag_no" value="<?php echo $datas['dag_no']; ?>" readonly>
                        </div></td>
                        </tr>
                        <tr>
                            <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('pattadar_whole_land_will_be_converted');?></label>
                        <div class="col-sm-6">
                            <select name="land_portion_status" class="form-control">
                                <option selected disabled>-- Select --</option>
                                <option value="N"><?php echo $this->lang->line('yes');?></option>
                                <option value="Y" selected><?php echo $this->lang->line('no');?></option>
                            </select>
                        </div></td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="col-sm-4" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                            <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i><span class="ass-btn"><?php echo $this->lang->line('submit_button');?></span></button>
                            <?php
                            $next = base_url() . "index.php/COconversionPartha/FinalSave";
                            ?>
                            <a href='<?php echo $next; ?>' class="btn btn-danger"><i class='fa fa-check'></i><span class="ass-btn"><?php echo $this->lang->line('next');?></span></a>

                        </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>  
        </div>
    </div>
</div>



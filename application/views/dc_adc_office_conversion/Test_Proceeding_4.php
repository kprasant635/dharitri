<div class="row login panel-form">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold rasid'><u><?php echo $this->lang->line('conversion_order_form'); ?> <span style='color: red;'>(<?php echo $this->lang->line('conversion_order_details'); ?>)</span></u></p>
                </div>
            </div>
            <div class="panel-body">
                <form class='form-horizontal unicode'  id='myForm' action="<?php echo base_url($post_url); ?>" method="post">

                    <?php 
                    $buttonEnabledFlag =1;
                    if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                    {
                        if($propChainEnableFlag)
                        {
                        include 'application/views/common/propertyCheckDetails.php';
                        }

                    }?>
                    <table class='table table-striped'>
                        <tr class="hide">
                            <td width="50%">
                                <label for="inputEmail3"  class="col-sm-6 control-label"><?php echo $this->lang->line('sl_no'); ?></label>
                                <div class="col-sm-2">
                                    <input type="text" readonly class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr> 
                        <tr>
                            <td width="50%">
                                <label for="inputEmail3"  class="col-sm-6 control-label"><?php echo $this->lang->line('on_behalf_of_name'); ?></label>
                                <div class="col-sm-6"><label class="control-label" >
                                        <?php
                                        $count = 1;
                                        $howmany = sizeof($pattadar_details) - 1;
                                        foreach ($pattadar_details as $pa): {
                                                echo $pa->pdar_name;
                                                if ($count < sizeof($pattadar_details) - 1) {
                                                    echo "<span style='color:red;'> , </span>";
                                                    $count++;
                                                } elseif ($count == sizeof($pattadar_details) - 1) {
                                                    echo "<span style='color:red;'> আৰু </span>";
                                                    $count++;
                                                } else {
                                                    echo " ";
                                                }
                                            }
                                        endforeach;
                                        ?></label>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('type_of_premium'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="prem_type" value="<?php echo $payment_type->chalan_name; ?>" readonly>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                        if ($datas['type_of_premium'] != '003') {
                            ?>
                            <tr>
                                <td>
                                    <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('chalan_receipt_no'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="chalan_no" value="<?php echo $datas['premium_reciept']; ?>" readonly>
                                    </div>
                                </td>
                                <td>
                                    <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('premium'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="prem_amt" value="<?php echo $datas['premium_amount']; ?>" readonly>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2" class="center">
                                <label><?php echo $this->lang->line('applicant_individual_land_portion'); ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="alert-danger center danger">
                                <?php echo $datas['bigha']; ?>&nbsp;Bigha
                                <?php echo $datas['kotha']; ?>&nbsp;Kotha 
                                <?php echo $datas['lessa']; ?>&nbsp;Lessa
                            </td>
                        </tr>
                        <tr class="hide">
                            <td colspan="2">
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="c_bigha" value="<?php echo $datas['bigha']; ?>" readonly>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="hide">
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_katha'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="c_kotha" value="<?php echo $datas['kotha']; ?>" readonly>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="hide">
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('land_area_lessa'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="c_lessa" value="<?php echo $datas['lessa']; ?>" readonly>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="patta_type" value="<?php echo $datas['patta_type']; ?>" readonly>
                                </div>
                            </td>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="patta_no" value="<?php echo $datas['patta_no']; ?>" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($petition_basic->trans_code == 'F') {
                                    echo "<span style='color:red;'>Since This is a Full Conversion the dag no will remain same and patta no will be Changed. Please select the new patta type from the drop down below.</span>";
                                } else {
                                    echo "<span style='color:red;'>This is a Partial Conversion the dag no and patta no will be Changed. Please select the new patta type from the drop down below.</span>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('new_patta_type'); ?></label>
                                <div class="col-sm-6">
                                    <select class="form-control new_patta_type_by_dc" name="new_patta_type" required>
                                        <option disabled selected>-- Select --</option>
                                        <?php foreach($type as $r){ ?>
                                            <option value="<?=$r->type_code;?>"><?=$r->patta_type?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                            <td><div id="msgfornotselectingpattatype" class="pull-left"></div></td>
                        </tr>
                        <?php
                        if ($petition_basic->trans_code == 'F') {
                            ?>
                            <tr>
                                <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control newDag" id="" name="sugg_dag_no" value="<?php echo $datas['dag_no']; ?>" readonly>
                                    </div>
                                    <div id="msg1"></div>
                                </td>
                                <td>
                                    <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                    <div class="col-sm-6">
                                        <select class="form-control">
                                            <option disabled selected>-- Verify Old Dags --</option>
                                            <?php foreach($check_dag_no as $odag) {?>
                                            <option> <?php echo $odag->dag_no ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-6 control-label hide"><?php echo $this->lang->line('existing_old_dag_no'); ?></label>
                                    <div class="col-sm-6 hide">
                                        <input type="text" class="form-control" name="old_dag_no" value="<?php echo $datas['dag_no']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td><label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control newDag" id="newDag" name="sugg_dag_no" value="<?php echo $datas['new_dag']; ?>">
                                    </div>
                                    <div id="msg1"></div>
                                </td>
                                <td>
                                    <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                    <div class="col-sm-6">
                                        <select class="form-control">
                                            <option disabled selected>-- Verify Old Dags --</option>
                                            <?php foreach($check_dag_no as $odag) {?>
                                            <option> <?php echo $odag->dag_no ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-6 control-label hide"><?php echo $this->lang->line('existing_old_dag_no'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control hide" name="old_dag_no" value="<?php echo $datas['dag_no']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_patta_no'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="newPatta" name="sugg_patta_no" value="<?php echo $datas['newpatta']; ?>">
                                </div>
                            </td>
                            <td>
                                <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Pattas</label>
                                <div class="col-sm-6">
                                    <select class="form-control">
                                        <option disabled selected>-- Verify Old Patta --</option>
                                        <?php foreach($check_patta_no as $odag) {?>
                                        <option><?php echo $odag->patta_no ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-6 control-label hide"><?php echo $this->lang->line('existing_old_patta_no'); ?></label>
                                <div class="col-sm-6 hide">
                                    <input type="text" class="form-control" name="old_patta_no" value="<?php echo $datas['patta_no']; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('dag_revenue'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="P_land" name="dag_revenue" value="<?php echo $datas['revenue']; ?>">
                                </div>
                            </td>
                            <td>
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('dag_local_tax'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="p_loc_tax" name="dag_local_tax" value="<?php echo $datas['local_tax']; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr class="hide">
                            <td colspan="2">
                                <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('pattadar_whole_land_will_be_converted'); ?></label>
                                <div class="col-sm-4">
                                    <select name="land_portion_status" class="form-control">
                                        <option value="N" selected><?php echo $this->lang->line('yes'); ?></option>
                                        <option value="Y"><?php echo $this->lang->line('no'); ?></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $location['dist_code']; ?>" readonly>
                        <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $location['subdiv_code']; ?>" readonly>
                        <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $location['cir_code']; ?>" readonly>
                        <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $location['mouza_pargona_code']; ?>" readonly>
                        <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $location['lot_no']; ?>" readonly>
                        <input type="hidden" class="form-control" id="village" value="<?php echo $location['vill_code']; ?>" readonly>
                    </table>
                </form>
                <center>
                    <table>
                        <tr>
                            <td colspan="2">
                                <!-- //property chain check -->
                            <?php if($buttonEnabledFlag == 1){

                                if ($petition_basic->trans_code == 'F') {
                                    ?>
                                    <button type="submit" id='directformsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Update Chitha</button>
                                    <?php
                                }else
                                {
                                    ?>
                                    <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> Update Chitha</button>
                                    <?php
                                }
                            

                            } ?>

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?php if($this->session->flashdata('message')): ?>
                                    <?php 
                                        echo '
                                            <p style="color:red;">'.$this->session->flashdata('message').'</p>
                                        ';
                                    ?>
                                <?php endif; ?>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </center>
            </div>  
        </div>
    </div>
</div>
<script>
    $('#directformsubmit').click(function() {
        var new_patta_type = $('.new_patta_type_by_dc').val();
        if(new_patta_type == null)
        {
            document.getElementById("msgfornotselectingpattatype").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Please Select the New Patta Type</p></label>";
            return false;
        }
        document.getElementById("myForm").submit();
    });
    $('#formsubmit').click(function() {
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village').val();
        var new_dag = $('.newDag').val();
        var new_patta = $('#newPatta').val();
        var new_patta_type = $('.new_patta_type_by_dc').val();
        
        
        $.ajax({
            url: baseurl + "dc_adc_conversion/chech_dag_patta_exist/" + dist_code_new + '/' + subdiv_code_new + '/' + circle_code_new + '/' + mouza_code_new + '/' + lot_no_new + '/' + village_new + '/' +new_dag + '/' + new_patta + '/' + new_patta_type,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                if(result == '1')
                {
                    document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Dag Number Already Exists</p></label>";
                    return false;
                }
                else
                {
                    document.getElementById("myForm").submit();
                }
            }
        });
    });
    
</script>

<script type="text/javascript">
$('.new_patta_type_by_dc').change(function (e) {
        var type_code = $(this).val();
        if(type_code != null)
        {
            document.getElementById("msgfornotselectingpattatype").style.display='none';
        }
        console.log("Changer");
        $.ajax({
            url: baseurl + "dc_adc_conversion/getNewDagPattaTypeJSON/" + type_code,
            success: function (data) {
                console.log(data);
                var lot = JSON.parse(data);
                $('#newDag').val(lot[0].new_dag);
                $('#newPatta').val(lot[0].new_patta);
            }
        });
    });    
</script>



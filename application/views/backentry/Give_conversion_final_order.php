
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('conversion_order_form'); ?> <span style='color: red; font-weight: bold;'>(<?php echo $this->lang->line('conversion_order_details'); ?>)</span></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('conversion') ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>Note: This process is entering data directly into the Chitha. Please make sure your are entering the correct data.You  are responsible for this entry.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2><mark><?php echo $this->lang->line('basic_details'); ?></mark></h2>
                        <form class='form-horizontal unicode' id='myForm' action="<?php echo base_url() . "index.php/Utility/FinalSaveTest"; ?>" method="post">
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
                                    <td>
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
                                                if($howmany<0){
                                                    echo "<span style='color:red;'> There are no pattadars in this dag. Backlog Conversion Cannot be done. </span>";
                                                }
                                                ?></label>
                                                <input type="hidden" id="pattadar_exist" value="<?php echo $howmany;?>"/>
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
                                        <hr style="border-bottom: 2px solid #000;">
                                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                        <?php
                                        if ($datas['PartialOrFull'] == 'Y') {
                                            echo "<span style='color:red;'>Since This is a Full Conversion the dag no will remain same. Please select the new patta type from the drop down below.</span>";
                                        } else {
                                            echo "<span style='color:red;'>This is a Partial Conversion the dag no and patta no will be Changed. Please select the new patta type from the drop down below.</span>";
                                        }
                                        ?>
                                        </div>
                                        <hr style="border-bottom: 2px solid #000;">
                                    </td>
                                </tr>
                            </table>
                            <h2><mark>Premium Details</mark></h2>
                            <hr>
                            <div class="form-group">
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('total_premium');?></label>
                                <div class="col-lg-2">
                                    <input type="text" name="total_premium" id="total_premium" class="form-control" value="0.00">
                                </div>
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('type_of_premium'); ?> </label>
                                <div class="col-lg-2">
                                    <select name="payment_type" class="form-control" id="payment_type">
                                        <?php foreach ($payment_type as $pay): ?>
                                        <option value="<?php echo $pay->code;?>"><?php echo $pay->chalan_name;?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="inputEmail" id="recpt1" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('receipt_no') ?></label>            
                                <div class="col-lg-2" id="recpt2">
                                    <input type="number" name="chalan_no" id="chalan_no" class="form-control" maxlength="7" value="0.00"/>
                                </div>
                                
                            </div>
                            <h2><mark>Select New Patta Type</mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('new_patta_type'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control new_patta_type_by_dc" name="new_patta_type" required>
                                        <option disabled selected>-- Select --</option>
                                        <option value="0201">খেৰাজ ম্যাদী</option>
                                        <option value="0203">বিশেষ ম্যাদী</option>
                                        <option value="0205">লা খেৰাজ</option>
                                        <option value="0208">নিস্ফি খেৰাজ</option>
                                        <option value="0216">চাহ ম্যাদী</option>
                                        <option value="0217">হ্ৰস্ব ম্যাদী</option>
                                        <option value="0223">গ্ৰামদান ম্যাদী</option>
                                        <option value="0232">গ্ৰামসভা ম্যাদী</option>
                                    </select>
                                </div>
                                <div id="msgfornotselectingpattatype" class="col-lg-5 pull-left"></div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <table class="table table-striped table-bordered" width="100%">
                                <tr class="success">
                                    <td width="50%">
                                       <strong>Old Details</strong>
                                    </td>
                                    <td>
                                        <strong>New Details</strong>
                                    </td>
                                </tr>
                                <?php
                                if ($datas['PartialOrFull'] == 'Y') {
                                ?>
                                <tr>
                                    <td>
                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control newDag" id="" name="sugg_dag_no" value="<?php echo $datas['actual_dag_no']; ?>" readonly>
                                            <input type="hidden" class="form-control " name="old_dag_no" value="<?php echo $datas['actual_dag_no']; ?>" readonly>
                                        </div>
                                        <div id="msg1"></div>
                                    </td>
                                    <td>
                                        <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"  >
                                            <?php foreach($check_dag_no as $odag) {?>
                                                <option> <?php echo $odag->dag_no ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                } else {
                                ?>
                                <tr>
                                    <td>
                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_dag_no'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control newDag" id="newDag" name="sugg_dag_no" value="<?php echo $datas['new_dag']; ?>">
                                            <input type="hidden" class="form-control hide" name="old_dag_no" value="<?php echo $datas['actual_dag_no']; ?>" >
                                        </div>
                                        <div id="msg1"></div>
                                    </td>
                                    <td>
                                        <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Dags</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"  >
                                            <?php foreach($check_dag_no as $odag) {?>
                                                <option> <?php echo $odag->dag_no ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td>
                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('suggested_new_patta_no'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="newPatta" name="sugg_patta_no" value="<?php echo $datas['newpatta']; ?>">
                                            <input type="hidden" class="form-control" name="old_patta_no" value="<?php echo $datas['patta_no']; ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <label for="inputEmail" class="col-sm-6 control-label uni_text">Check Existing Pattas</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"  >
                                            <?php foreach($check_patta_no as $odag) {?>
                                                <option> <?php echo $odag->patta_no ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2><mark>Revenue Details ( If Any )</mark></h2>
                            <hr>
                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('dag_revenue'); ?></label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="P_land" name="dag_revenue" value="<?php echo $datas['revenue']; ?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-inr"> ( Rupees ) </i>
                                    </span>
                                </div>
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('dag_local_tax'); ?></label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="p_loc_tax" name="dag_local_tax" value="<?php echo $datas['local_tax']; ?>">
                                    <span class="input-group-addon">
                                        <i class="fa fa-inr"> ( Rupees ) </i>
                                    </span>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="center red bold"><u>Please select the name who passes this order </u></h2>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('mondal_name') ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="lm_code" id="lm_code">
                                    <option selected disabled value="">Select Lot Mondal</option>
                                    <?php
                                    foreach($lmname as $lm){
                                    ?>
                                       <option value="<?php echo $lm->lm_code;?>"><?php echo $lm->lm_name;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="lmSign" disabled="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup3Datepicker" name="lm_date" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sk_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="sk_code">
                                    <option selected disabled value="">Select SK</option>
                                    <?php
                                    foreach($skname as $sk){
                                    ?>
                                       <option  value="<?php echo $sk->user_code;?>"><?php echo $sk->username;?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="skSign" disabled="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup2Datepicker" name="sk_date" class="form-control"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('co_name'); ?> </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="co_code" id="co_code">
                                    <option selected disabled value="">Select Circle Officer</option>
                                    <?php
                                    foreach($coname as $co){
                                    ?>
                                       <option value="<?php echo $co->user_code;?>"><?php echo $co->username;?></option>
                                    <?php
                                    }
                                    ?>
                                     </select>
                                </div>
                                <label for="inputEmail" class="col-lg-2 uni_text control-label"><?php echo $this->lang->line('sign') ?> </label>            
                                <div class="col-lg-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="coSign" disabled="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                </div>
                                <label class="col-lg-2 control-label uni_text"><?php echo $this->lang->line('sign_date'); ?> </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup1Datepicker" name="co_date" class="form-control"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $location['dist_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $location['subdiv_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $location['cir_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $location['mouza_pargona_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $location['lot_no']; ?>" readonly>
                            <input type="hidden" class="form-control" id="village" value="<?php echo $location['vill_code']; ?>" readonly>
                            <center>
                                <div class="col-lg-8 col-lg-offset-2">
                                    <?php
                                    if($howmany<0){
                                        echo "<span style='color:red;'> There are no pattadars in this dag. Backlog Conversion Cannot be done. Please Contact NIC Help Desk Officials.</span>";
                                    }
                                    if ($datas['PartialOrFull'] == 'Y') {
                                        ?>
                                        <button type="submit" id='directformsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                        <?php
                                    }else
                                    {
                                        ?>
                                        <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                                        <?php
                                    }
                                    ?>
                                    <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('#payment_type').change(function () {
        var data = $(this).val();
        //alert (data);
        if (data == '003') 
        {
            $('#recpt1').hide();
            $('#recpt2').hide();
        }
        else 
        {
            $('#recpt1').show();
            $('#recpt2').show();
        }
    });
    
    $('#directformsubmit').click(function() {
        var new_patta_type = $('.new_patta_type_by_dc').val();
        var lm_code = $('#lm_code').val();
        var co_code = $('#co_code').val();
        var pattadar_exist = $('#pattadar_exist').val();
        if(pattadar_exist < 0)
        {
            return false;
        }
        if(new_patta_type == null)
        {
            document.getElementById("msgfornotselectingpattatype").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Please Select the New Patta Type</p></label>";
            document.getElementById("new_patta_type_by_dc").focus();
            return false;
        }
        if((lm_code == null) || (co_code == null)){
            alert('Please Enter Lot Mondal & Circle Officer Details!');
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
        var new_patta_type = $('.new_patta_type_by_dc').val();
        var new_patta = $('#newPatta').val();
        var new_dag = $('#dag_no').val();
        var lm_code = $('#lm_code').val();
        var co_code = $('#co_code').val();
        var pattadar_exist = $('#pattadar_exist').val();
        if(pattadar_exist < 0)
        {
            return false;
        }
        if((new_dag == null) || (new_patta == null) || (new_patta_type == null)){
            alert('Please Enter Land Details!');
            return false;
        }
        if((lm_code == null) || (co_code == null)){
            alert('Please Enter Lot Mondal & Circle Officer Details!');
            return false;
        }
        
        $.ajax({
            url: baseurl + "CoconversionPartha/chech_dag_patta_exist/" + dist_code_new + '/' + subdiv_code_new + '/' + circle_code_new + '/' + mouza_code_new + '/' + lot_no_new + '/' + village_new + '/' +new_dag + '/' + new_patta + '/' + new_patta_type,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                if(result > '0')
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
            url: baseurl + "CoconversionPartha/getNewDagPattaTypeJSON/" + type_code,
            success: function (data) {
                console.log(data);
                var lot = JSON.parse(data);
                $('#newDag').val(lot[0].new_dag);
                $('#newPatta').val(lot[0].new_patta);
            }
        });
    });    
</script>




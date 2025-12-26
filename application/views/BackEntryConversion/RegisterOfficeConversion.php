
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Office Conversion ( Back Log Entry )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Add Applicants Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal unicode' id='myForm' action="<?php echo base_url() . "index.php/BackLogConversion/RegisterOConversion"; ?>" method="post">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-12 control-label uni_text" style="text-align:left"> Pattadar's Name :</label>
                                <div class="col-lg-12">
                                    <input type="hidden" readonly class="form-control" name="pdar_cron_no" id="pdar_cron_no" placeholder="Pattadar No">
                                    <label class="control-label" >
                                                <?php
                                                $count = 1;
                                                $howmany = sizeof($pattadar_details) - 1;
                                                foreach ($pattadar_details as $pa): {
                                                    if($pa->p_flag == '1'){
                                                        echo "<span style='text-decoration: line-through; color:red;'>".$pa->pdar_name."</span>";
                                                    } else {
                                                        echo $pa->pdar_name;
                                                    }
                                                        
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
                            </div>
                            <input type="hidden" class="form-control" name="patta_type" value="<?php echo $datas['patta_type']; ?>" readonly>
                            <input type="hidden" class="form-control" name="patta_no" value="<?php echo $datas['patta_no']; ?>" readonly>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red">Premium Details  as per Conversion order Passed</h2>
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
                                    <input type="number" name="chalan_no" id="chalan_no" class="form-control" maxlength="7" value="0"/>
                                </div>
                                
                            </div>
                            <h2 class="red">Select New Patta Type  as per Conversion order Passed</h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label"><?php echo $this->lang->line('new_patta_type'); ?></label>
                                <div class="col-lg-3">
                                    <select class="form-control new_patta_type_by_dc" required name="new_patta_type" id="new_patta_type">
                                       <option selected disabled><?php  echo $this->lang->line('select_patta_type'); ?></option>
                                           <?php 
                                           foreach ($patta_type_excluding_aksona as $p): ?>
                                               <option value="<?php echo $p->type_code; ?>"><?php echo $p->patta_type; ?></option>
                                           <?php endforeach; ?>
                                   </select>
                                </div>
                                <div id="msgfornotselectingpattatype" class="col-lg-5 pull-left"></div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php
                            if ($datas['PartialOrFull'] == 'F') {
                                echo "<h2 class='red'>Since This is a Full Conversion so the dag no will remain same. Please type the new patta no below.</h2>";
                            } else {
                                echo "<h2 class='red'>This is a Partial Conversion so the dag no and patta no will be Changed. Please type the new patta no and dag no below.</h2>";
                            }
                            ?>
                            <table class="table table-striped table-bordered" width="100%">
                                <tr class="success">
                                    <td width="50%" colspan="2">
                                       <strong>Assign Dag no / Patta no</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if ($datas['PartialOrFull'] == 'F') { 
                                        $id = '';
                                        ?>
                                    <td>
                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('new_dag_no'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control newDag" id="<?php echo $id;?>" name="sugg_dag_no" value="<?php echo $datas['actual_dag_no']; ?>" readonly>
                                            <input type="hidden" class="form-control " name="old_dag_no" value="<?php echo $datas['actual_dag_no']; ?>" readonly>
                                        </div>
                                        <div id="msg1"></div>
                                    </td>
                                    <?php } else { 
                                        $id = 'newDag';
                                        ?>
                                    <td>
                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('new_dag_no'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control newDag" id="<?php echo $id;?>" name="sugg_dag_no" value="">
                                            <input type="hidden" class="form-control" name="old_dag_no" value="<?php echo $datas['actual_dag_no']; ?>" readonly>
                                        </div>
                                        <div id="msg1"></div>
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <label for="inputEmail3" class="col-sm-6 control-label"><?php echo $this->lang->line('new_patta_no'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="newPatta" name="sugg_patta_no" value="">
                                            <input type="hidden" class="form-control" name="old_patta_no" value="<?php echo $datas['patta_no']; ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red">Revenue Details  as per Conversion order Passed</h2>
                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label"><?php echo $this->lang->line('dag_revenue'); ?></label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="rev" name="dag_revenue" value="<?php echo $datas['revenue']; ?>">
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
                                <label for="inputEmail" class="col-lg-2 uni_text control-label">Mondal Signed </label>            
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
                                <label class="col-lg-2 control-label uni_text">Signed Date </label>
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
                                <label for="inputEmail" class="col-lg-2 uni_text control-label">SK Signed </label>            
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
                                <label class="col-lg-2 control-label uni_text">SK Signed Date </label>
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
                                <label for="inputEmail" class="col-lg-2 uni_text control-label">CO Signed </label>            
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
                                <label class="col-lg-2 control-label uni_text">CO Signed Date </label>
                                <div class="col-lg-2">
                                    <input type="text" id="popup1Datepicker" name="co_date" class="form-control"  >
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12" id="co_block">
                                    <label class="rasid col-sm-12">
                                          <input type="checkbox" id="myCheck" onclick="myFunction()"> লাঃ মঃ - চিঠা নথি তথ্য অনুসৰি এই দাগৰ ম্যাদীকৰণ সবিশেষ বকেয়া অন্তৰ্ভূক্তিৰ বাবে চক্ৰ বিষয়াৰ অনুমোদন বিচৰা হ’ল |
                                    </label>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <input type="hidden" class="form-control" id="dist_code_new" value="<?php echo $location['dist_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="subdiv_code_new" value="<?php echo $location['subdiv_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="circle_code_new" value="<?php echo $location['cir_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="mouza_code_new" value="<?php echo $location['mouza_pargona_code']; ?>" readonly>
                            <input type="hidden" class="form-control" id="lot_no_new" value="<?php echo $location['lot_no']; ?>" readonly>
                            <input type="hidden" class="form-control" id="village" value="<?php echo $location['vill_code']; ?>" readonly>
                            </form>
                            <center>
                                <div class="col-lg-8 col-lg-offset-2">
                                    <button type="submit" id='formsubmit'  class="btn btn-success"><i class='fa fa-check'></i> Submit & Register</button>
                                    <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                    </a>
                                </div>
                            </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">    
    $('#formsubmit').click(function() {
        var dist_code_new = $('#dist_code_new').val();
        var subdiv_code_new = $('#subdiv_code_new').val();
        var circle_code_new = $('#circle_code_new').val();
        var mouza_code_new = $('#mouza_code_new').val();
        var lot_no_new = $('#lot_no_new').val();
        var village_new = $('#village').val();
        var lm_code = $('#lm_code').val();
        var co_code = $('#co_code').val();
        var total_premium = $('#total_premium').val();
        var payment_type = $('#payment_type').val();    
        var chalan_no = $('#chalan_no').val(); 
        var new_patta_type = $('#new_patta_type').val(); 
        var rev = $('#rev').val(); 
        var p_loc_tax = $('#p_loc_tax').val();
        var newDag = $('#newDag').val();
        var newPatta = $('#newPatta').val();
        
        if((newDag == '') || (newPatta == '')){
            alert('Please Enter New Dag no / New Patta no..!');
            return false;
        }
        
        if((lm_code == null) || (co_code == null)){
            alert('Please Enter Lot Mondal & Circle Officer Details!');
            return false;
        }
        
        if((total_premium == null) || (payment_type == null) || (chalan_no == null)){
            alert('Please Enter Premium Details!');
            return false;
        }
        
        if((new_patta_type == null)){
            alert('Please Select New Patta Type!');
            return false;
        }
        
        if((rev == null) || (p_loc_tax == null)){
            alert('Please Enter Revenue & Local Tax Details!');
            return false;
        }
        
        $.ajax({
            url: baseurl + "BackLogConversion/chech_existing_dag/" + dist_code_new + '/' + subdiv_code_new + '/' + circle_code_new + '/' + mouza_code_new + '/' + lot_no_new + '/' + village_new + '/' +newDag,
            success: function (data) {
                console.log(data);
                var result = JSON.parse(data);
                if(result == '1')
                {
                    alert('Dag Number Already Exist!');
                    //document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Dag Number Already Exists</p></label>";
                    return false;
                }
                else
                {
                    document.getElementById("myForm").submit();
                }
            }
        });
        //exit();
        //document.getElementById("myForm").submit();
    });
    
    $("#formsubmit").attr('disabled', true);
    function myFunction() {
       var checkBox = document.getElementById("myCheck");
       if (checkBox.checked == true){
         $('#formsubmit').removeAttr('disabled', false);
       } else {
         $('#formsubmit').attr('disabled', true);
       }
   }   
</script>





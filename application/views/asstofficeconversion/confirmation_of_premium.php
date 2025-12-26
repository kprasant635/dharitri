<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('case_no_mutation_premium_details');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y', strtotime($location['date'])); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                    <?php 
            $proceed=1;
            if($basundharaExist){
                    if($success->payment_status=='Y'){
                        $proceed=0;
                ?>
                <h4>Payment Successfull..</h4>
                <form class="" method='post' action="<?php echo base_url() . "index.php/AsistantMutationPartha/confirmation_premium_save"; ?>">
                    <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                    <input type="hidden" name="date" value="<?php echo $success->payment_date; ?>"/>
                    <center><button type="submit" name="paymentBasu" class="btn btn-success uni_text" value="true"><i class='fa fa-check'></i> <?php echo $this->lang->line('got_premium');?></button></center>
                </form> 
            <?php
                }else{
                    $proceed=1;
                    echo "<h4>Payment not Completed by the USER</h4>";
                ?>
                    <h6><a href="<?php echo base_url()."index.php/AsistantMutationPartha/cancelPremium?case_no=".$location['case_no']  ?>" class="green pull-right" >&nbsp;&nbsp;Click Here to Cancel Premium Notice & Revert to CO <sup class="red">New</sup></a></h6>
                    <br>
            <?php
                }
             } 
             if ($proceed==1){

                 ?>
                        <form class="" method='post' enctype="multipart/form-data" action="<?php echo base_url() . "index.php/AsistantMutationPartha/confirmation_premium_save"; ?>" id="asstMutForm">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p align="right" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                                        <?php echo $this->lang->line('name'); ?> : 
                                        <?php
                                        foreach ($pattadar as $pop):
                                            echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                                        endforeach;
                                        ?>
                                    </p>
                                    <table class='table table-striped'>
                                        <tr style="text-align: center;">
                                            <td colspan="4">
                                            <?php $prem_percent=((trim($lm_details['premium_assesment'])=='40') || (trim($lm_details['premium_assesment'])=='20')? $lm_details['premium_assesment']: $lm_details['prim_per_bigha']); ?>
                                                <p class="rasid" >বিঘাই প্রতি <span style="color:#37BC9B"><?=$prem_percent ?> টকা</span> হাৰে <?php echo $lm_details['dag_no']; ?> নং দাগৰ <?php echo $lm_details['conv_b']; ?> বিঘা, <?php echo $lm_details['conv_k']; ?> কঠা, <?php echo $lm_details['conv_lc']; ?> লেছা মাটিৰ <span style="color:#37BC9B">প্রিমিয়াম হয় = <?php echo $lm_details['prim_tot']; ?> টকা</span> ।</p></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td width="25%"><label class="control-label" ><?php echo $this->lang->line('type_of_premium');?></label></td>
                                            <td width="25%">
                                                <select name="payment_type" class="form-control" id="payment_type">
                                                    <option selected disabled>Select Payment Type</option>
                                                    <?php foreach ($payment_type as $pay): ?>
                                                    <option value="<?php echo $pay->code;?>"><?php echo $pay->chalan_name;?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td width="25%"><div id="recpt1"><label class="control-label" ><?php echo $this->lang->line('premium_chalan_receipt_no');?></label></div></td>
                                            <td width="25%"><div id="recpt2"><input type="number" name="chalan_no" class="form-control" id="chalan_no" maxlength="7" required/></div></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td colspan="4"><label class="control-label" ><?php echo $this->lang->line('total_premium');?> = <?php echo $lm_details['prim_tot']; ?></label></td>
                                        </tr>
                                    </table>
                                    
                                    <div class="form-group">
                                                    <label for="inputEmail" class="col-lg-3 required  control-label">Upload Premium Challan</label>
                                                    <div class="col-lg-3">
                                                        <input type='file' name="up_prem_conv" id="up_prem_conv" required>
                                                    </div>
                                                    <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                                    </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <h6 class="red uni_text"><b>PLEASE NOTE :: If You are not satisfied with the premium amount than click on the " Premium Not Received Button " and write the reason in the action taken report. This case will be sent back to the Circle Officer where the circle officer can ask Lot Mondal for fresh report.</b></h6>
                                </div>
                                </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <div class="col-lg-12">
                                    <div class="col-lg-6" align="right">
                                        <button type="submit" name="submit2" class="btn btn-warning uni_text" value="false" onclick="return ConfResent()"><i class='fa fa-times'></i>  <?php echo $this->lang->line('no_premium');?></button>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                                        
                                        <button type="submit" name="submit1" class="btn btn-success uni_text" value="true"><i class='fa fa-check'></i> <?php echo $this->lang->line('got_premium');?></button>
                                        <a class="btn btn-danger uni_text" href="<?php echo base_url(); ?>index.php/AsistantMutationPartha/GoToAST?pro=4"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php 
                 } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

$('.btnprem').click(function(){
    if($('#up_prem_conv').val()==0){
        alert("Premium Challan upload is mandatory");
        $('#up_prem_conv').focus();
        return false;
    }
});

    function ConfResent() {
        if (!confirm('Are you sure you want to send it back to Lot Mondal for fresh report?'))
        {
            return (false);
        }
        else
        {
            var theInput = document.getElementById("chalan_no");
            theInput.removeAttribute("required");
            return (true);
        }
    }
    
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

    let btnNameAttr;
    let btnValAttr;

    $('button').click(function(){
        btnNameAttr = $(this).attr('name');
        btnValAttr = $(this).attr('value');
    });

    $('#asstMutForm').on('submit', function(){
        $('.submit_input').remove();
        $('#asstMutForm').append(`<input type="hidden" class="submit_input" name="${btnNameAttr}" value="${btnValAttr}">`);
    });
});
</script>

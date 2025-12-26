<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-12 col-lg-12">
            <div class="card card-success">
                <div class="card-header d-flex justify-content-between">
                    <p>Case No: <?php echo $petition_basic->case_no; ?></p>
                    <p>Confirmation of Premium</p>
                    <p>Date: <?php echo date('d-m-Y'); ?></p>
                </div>
                <div class="card-body">
                    <input type="hidden" id="base" value="<?php echo base_url(); ?>">
                    <?php 
                    $proceed=1;
                    if($basundhar_application){
                        //if($payment_confirmation->payment_status=='Y'){
                        if(strtoupper($payment_status_check->payment_status) =='Y'){
                            $proceed=0;
                        ?>
                        <h4>Payment successfully completed through GRN No: <?=$payment_status_check->grn_no?>
                        <br><br><br>
                        <strong style="color:red">NOTE: Please verify GRN/challan before payment onfirmtaion <a style="color:blue" target="_blank" href="https://assamegras.gov.in/challan/views/frmSearchChallanWithOutReg.php">Click here to verify</a></strong>
                        </h4>
                        <form id="basuform">
                            <input type="hidden" name="case_no" id="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                            <input type="hidden" name="payment_date" id="payment_date" value="<?php echo $payment_status_check->payment_date; ?>"/>
                            <center><button type="button" id="basu_btn" class="btn btn-success uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('got_premium');?></button></center>
                        </form>
                    <?php
                        }else{
                            $proceed=1;
                            echo "<h4>Payment not Completed by the USER</h4>";
                        ?>
                            <!--<h6><a href="<?php echo base_url()."index.php/AsistantMutationPartha/cancelPremium?case_no=".$petition_basic->case_no; ?>" class="green pull-right" >&nbsp;&nbsp;Click Here to Cancel Premium Notice & Revert to CO <sup class="red">New</sup></a></h6>-->
                            <br>
                        <?php
                        }
                    } 
                    if ($proceed==1){ ?>
                        <!-- <form class="" method='post' enctype="multipart/form-data" action="<?php echo base_url() . "index.php/AsistantMutationPartha/confirmation_premium_save"; ?>" id="asstMutForm"> -->
                        <form id="mainform">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p align="right" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                                        <?php echo $this->lang->line('name'); ?> : 
                                        <?php
                                        foreach ($pattadars as $pop):
                                            echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                                        endforeach;
                                        ?>
                                    </p>
                                    <table class='table table-striped'>
                                        <tr style="text-align: center;">
                                            <td colspan="4">
                                                <?php 
                                                if($premium_rate_details->amount != 0 && $premium_rate_details->rate == 0) {
                                                    $prem_percent = $premium_rate_details->amount;
                                                }
                                                else if ($premium_rate_details->amount == 0 && $premium_rate_details->rate != 0) {
                                                    $prem_percent = ($premium_rate_details->rate / 100) * $petition_lm_note_details->prim_per_bigha;
                                                }
                                                // $prem_percent=((trim($petition_lm_note_details->premium_assesment)=='40') || (trim($petition_lm_note_details->premium_assesment)=='20')? $petition_lm_note_details->premium_assesment: $petition_lm_note_details->prim_per_bigha); ?>

                                                <p class="rasid" >বিঘাই প্রতি <span style="color:#37BC9B"><?=$prem_percent ?> টকা</span> হাৰে <?php echo $petition_lm_note_details->dag_no; ?> নং দাগৰ <?php echo $petition_lm_note_details->conv_b; ?> বিঘা, <?php echo $petition_lm_note_details->conv_k; ?> কঠা, 
                                                <?php
                                                    if(!in_array($petition_basic->dist_code, json_decode(BARAK_VALLEY))) {
                                                        echo $petition_lm_note_details->conv_lc . ' লেছা ';
                                                    }
                                                    else {
                                                        echo $petition_lm_note_details->conv_lc . ' ছটাক ' . $petition_lm_note_details->conv_g . ' গোণ্ডা';
                                                    }
                                                ?> মাটিৰ <span style="color:#37BC9B">প্রিমিয়াম হয় = <?php echo $petition_lm_note_details->prim_tot; ?> টকা</span> ।</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td width="25%">
                                                <label class="control-label" ><?php echo $this->lang->line('type_of_premium');?></label>
                                            </td>
                                            <td width="25%">
                                                <select name="payment_type" class="form-control" id="payment_type">
                                                    <option selected disabled>Select Payment Type</option>
                                                    <?php foreach ($premium_chalan_receipts as $pay): ?>
                                                    <option value="<?php echo $pay->code;?>"><?php echo $pay->chalan_name;?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td width="25%"><div id="recpt1"><label class="control-label" ><?php echo $this->lang->line('premium_chalan_receipt_no');?></label></div></td>
                                            <td width="25%"><div id="recpt2"><input type="number" name="chalan_no" class="form-control" id="chalan_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "7" required/></div></td>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <td colspan="4"><label class="control-label" ><?php echo $this->lang->line('total_premium');?> = <?php echo 'Rs. ' . ($petition_lm_note_details->prim_tot) ? $petition_lm_note_details->prim_tot : '0.00'; ?></label></td>
                                        </tr>
                                    </table>
                                    
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-lg-3 required  control-label">Upload Premium Challan</label>
                                        <div class="col-lg-3">
                                            <input type='file' name="up_prem_conv" id="up_prem_conv" required>
                                        </div>
                                        <!-- <div class="col-lg-6 text-bold red" id="err_message"></div> -->
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Date</label>
                                        <input type="date" name="payment_date" id="payment_date" class="" required />
                                    </div>
                                <hr style="border-bottom: 2px solid #000;">
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <h6 class="red uni_text"><b>PLEASE NOTE :: If You are not satisfied with the premium amount than click on the " Premium Not Received Button " and write the reason in the action taken report. This case will be sent back to the Circle Officer where the circle officer can ask Lot Mondal for fresh report.</b></h6>
                                </div>
                                </div>
                                <input type="hidden" name="case_no" id="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                               
                            </div>
                        </form>
                    <?php } ?>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button id="no_prem_btn" type="button" class="btn btn-warning uni_text mr-1 ml-1"><i class='fa fa-times'></i>  <?php echo $this->lang->line('no_premium');?></button>
                    <button id="got_prem_btn" type="button" class="btn btn-success uni_text mr-1 ml-1"><i class='fa fa-check'></i> <?php echo $this->lang->line('got_premium');?></button>
                    <a class="btn btn-danger uni_text mr-1 ml-1" href="<?php echo base_url('index.php/go_to_ast?pro=4'); ?>"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).on('click', '#no_prem_btn', (e) => {
        if(!confirm("Are you sure you want to send it back to Lot Mondal for fresh report?")) {
            return false;
        }
        var case_no = $('#case_no').val();
        if(case_no == '' || case_no == undefined) {
            swal.fire("", 'Case No is a required field', "error")
            .then((value) => {
                
            });
            return false;
        }
        var baseurl = $('#base').val();
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + 'index.php/ast_premium_confirm_post',
            method: 'POST',
            dataType: 'JSON',
            data: {case_no:case_no, submit_type:'no_premium'},
            // processData: false,
            // contentType: false,
            success: function(response) {
                $.unblockUI();

                console.log(response);
            },
            error: function(error) {
                $.unblockUI();
                console.log(error);
            }
        });
    });

    $(document).on('click', '#got_prem_btn', (e) => {
        var baseurl = $('#base').val();
        var case_no = $('#case_no').val();
        var payment_type = $('#payment_type').val();
        var up_prem_conv = document.getElementById("up_prem_conv").files[0];
        var paymentdate = $("#payment_date").val();

        if(case_no == '' || payment_type == '' || paymentdate == '' || payment_type == undefined || up_prem_conv == '' || up_prem_conv == undefined || paymentdate == undefined) {
            swal.fire("", 'The required fields are empty!', "error")
            .then((value) => {
                
            });
            return false;
        }
        if(payment_type != '003') {
            var chalan_no = $('#chalan_no').val();
            if(chalan_no == '' || chalan_no == undefined) {
                swal.fire("", 'The challan no is a required field!', "error")
                .then((value) => {
                    
                });
                return false;
            }
        }

        var form  = document.getElementById("mainform");
        const formData = new FormData(form);
        formData.append('submit_type', 'got_premium');

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url:baseurl + 'index.php/ast_premium_confirm_post',
            method: 'POST',
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.unblockUI();
                if(response.status == 'FAILED') {
                    swal.fire("", response.msg, "error")
                    .then((value) => {
                        
                    });
                }
                else if(response.status == 'SUCCESS') {
                    swal.fire("", response.msg, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                // console.log(response);
            },
            error: function (error) {
                $.unblockUI();
                console.log(error);
            }
        });

    });

    $(document).on('click', '#basu_btn', (e) => {
        var payment_date = $('#payment_date').val();
        var case_no = $('#case_no').val();
        var baseurl = $('#base').val();

        if(payment_type == '' || payment_type == undefined || case_no == '' || case_no == undefined) {
            swal.fire("", 'The required fields are empty!', "error")
            .then((value) => {
                
            });
            return false;
        }

        var form  = document.getElementById("basuform");
        const formData = new FormData(form);
        formData.append('submit_type', 'basu_premium');

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url:baseurl + 'index.php/ast_premium_confirm_post',
            method: 'POST',
            dataType: 'JSON',
            data: formData,
            // processData: false,
            // contentType: false,
            success: function(response) {
                $.unblockUI();
                console.log(response);
            },
            error: function (error) {
                $.unblockUI();
                console.log(error);
            }
        });

    });

// $('.btnprem').click(function(){
//     if($('#up_prem_conv').val()==0){
//         alert("Premium Challan upload is mandatory");
//         $('#up_prem_conv').focus();
//         return false;
//     }
// });
    
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

    // let btnNameAttr;
    // let btnValAttr;

    // $('button').click(function(){
    //     btnNameAttr = $(this).attr('name');
    //     btnValAttr = $(this).attr('value');
    // });

    // $('#asstMutForm').on('submit', function(){
    //     $('.submit_input').remove();
    //     $('#asstMutForm').append(`<input type="hidden" class="submit_input" name="${btnNameAttr}" value="${btnValAttr}">`);
    // });
});
</script>

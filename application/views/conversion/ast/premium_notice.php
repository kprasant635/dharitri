<?php //echo '<pre>'; var_dump($location_details); die(); ?>

<style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
        size: portrait; /* for page layout */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        /*border: solid 1px blue ;
        margin: 5mm 15mm 10mm 15mm;*/ /*margin you want for the content */
    }
</style>

<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-md-12 col-lg-12">
            <div class="row login panel-form">
                <div class="col-lg-12 center-col">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <p class='center bold'><span class="rasid"><u>(<?php echo $this->lang->line('case_no'); ?> : <?php echo $petition_basic->case_no; ?>) নং ম্যাদীকৰণ গোচৰৰ প্রিমিয়াম আদায়ৰ জাননী</u></span></p>
                            </div>
                        </div>
                        <div class="panel-body" id="printdiv">

                        <!-- <form action="sdf" method="post" enctype='multipart/form-data'> -->
                        <textarea  style="display:none" id="htmlstring_text" name="htmlstring_text" cols="30" rows="10"></textarea>
                        <!-- </form> -->
                            <!-- <form class="unicode" method='post' action="<?php echo base_url() . "index.php/AsistantMutationPartha/notice_for_premium_save"; ?>"> -->
                                <table width="100%">
                                    <tr style="text-align: center;">
                                        <td><label class="control-label" ><?php echo $this->lang->line('district'); ?> : <?php echo $location_details->dist_name; ?></label></td>
                                        <td><label class="control-label" ><?php echo $this->lang->line('subdivision'); ?> : <?php echo $location_details->subdiv_name; ?></label></td>
                                        <td><label class="control-label" ><?php echo $this->lang->line('circle'); ?> : <?php echo $location_details->cir_name; ?></label></td>
                                    </tr>
                                    <tr style="text-align: center;">
                                        <td><label class="control-label" ><?php echo $this->lang->line('lot_no'); ?>  : <?php echo $location_details->lot_name; ?></label></td>
                                        <td><label class="control-label" ><?php echo $this->lang->line('mouza'); ?>  : <?php echo $location_details->mouza_pargona_name; ?></label></td>
                                        <td><label class="control-label" ><?php echo $this->lang->line('vill_town'); ?> : <?php echo $location_details->vill_townprt_name; ?></label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style=" padding-left: 50px;">
                                            
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
                                                    echo $petition_lm_note_details->conv_lc . ' ছটাক ' . $petition_lm_note_details->conv_g . ' গোণ্ডা ';
                                                }
                                            ?> 
                                            মাটিৰ প্রিমিয়াম হয় <?php echo $petition_lm_note_details->prim_tot; ?> টকা, <span style="color:#37BC9B">(মুঠ প্রিমিয়াম <?php echo $petition_lm_note_details->prim_tot; ?> টকা)</span> । নিম্নলিখিত আবেদনকাৰীক (সকলক) প্রিমিয়াম আদায়ৰ বাবে জাননী জাৰী কৰা হ'ল ।</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr style="text-align: center; font-weight: bold; color:#0000cc;" class="table table-bordered">
                                        <td><label class="control-label" ><?php echo $this->lang->line('petitoner_name'); ?></label></td>
                                        <td><label class="control-label" ><?php echo $this->lang->line('guardian_name'); ?></label></td>
                                        <td><label class="control-label" ><?php echo $this->lang->line('dag_no'); ?></label></td>
                                    </tr>
                                    <?php
                                    //var_dump($pattadardetails);
                                    foreach ($pattadars as $p):
                                        $pattadar = $p->pdar_name;
                                        //$relation=$p->pdar_rel_guar;
                                        $relation = 'f';
                                        // $relationship = $this->utilityclass->get_relation($relation);
                                        ?>
                                        <tr style="text-align: center;" class="table table-bordered">
                                            <td><label class="control-label" ><?php echo $pattadar; ?></label></td>
                                            <td><label class="control-label" ><?php echo $p->pdar_guardian; ?></label></td>
                                            <td><label class="control-label" ><?php echo $petition_dag_details->dag_no; ?></label></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <p class="rasid" style="float: right;"><?php echo $petition_basic->add_off_name; ?><br>
                                                        চক্র বিষয়া,&nbsp;<?php echo $location_details->cir_name; ?></p>
                                </div>
                                <input type="hidden" name="case_no" id="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                                <input type="hidden" name="amount" id="amount" value="<?=$petition_lm_note_details->prim_tot?>">
                                
                                <hr style="border-bottom: 2px solid #000;" class="dontshow">
                                <?php
                                if($basundhar_application){
                                    echo "<p class='text-success uni_text text-center'>Note: As this application request is generated from Basundhara Application ,an automatic Payment Request will be intiated to the user for Payment of the Respective Amount of Rs:/- " . $petition_lm_note_details->prim_tot . " only</p>";
                                    echo '<h2 class="red">Basundhara Attachments</h2>';
                                    foreach ($basundhara_attachment  as $attachment):
                                    ?>
                                    <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                    <?php 
                                    endforeach; 
                                }
                                else{
                                    echo '<h2 class="red">Attachments</h2>';
                                    foreach($supportive_documents as $docs):
                                    ?>
                                        <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
                                    <?php
                                    endforeach;
                                }
                                ?>
                                <div class="col-sm-12 dontshow">
                                    <center>
                                        <button type="button" name="submit" class="btn btn-success uni_text" onclick="return myFunction()"><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
                                    </center>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo base_url('index.php/ast_premium_notice_save?case_no=' . $petition_basic->case_no);?>
<script>

     function printDiv(divId) {
        var content = document.getElementById(divId).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = originalContent;
    }
    function b64EncodeUnicode(str) {    
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
        }));
    }


    function myFunction() {     
        var htmlString = $("#printdiv").html();
        htmlString = b64EncodeUnicode(htmlString);
        var baseurl = $('#baseurl').val();

        $("#htmlstring_text").text(htmlString);
        // Extracting case_no dynamically if it's part of an input field
        var case_no = $("#case_no").val(); // Ensure this selector points to the correct input field
        var amount = $("#amount").val(); // Adjust if needed

        console.log(case_no, amount);

        


        $(".dontshow").hide();
        $('.reports-tab-section').hide();
        // $(".reports-tabs nav ul").hide();
	    window.print();
        $(".dontshow").show();
        $('.reports-tab-section').show();
        // $(".reports-tabs nav ul").show();
        // document.getElementById("mainMenu").disabled = false;
        var case_no = $('#case_no').val();
        var amount = $('#amount').val();
        var baseurl = $('#baseurl').val();
        // console.log(case_no);
        if(case_no == '' || case_no == undefined || amount == '' || amount == undefined) {
            swal.fire("", 'Required Parameters are empty.', "error")
            .then((value) => {
                
            });
            return false;
        }
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl + '/index.php/ast_premium_notice_save',
            method: 'POST',
            data: {case_no:case_no, amount:amount},
            dataType: 'JSON',
            success: function(response) {
                $.unblockUI();
                console.log(response);
                if(response.status == 'SUCCESS') {

                    $.ajax({
                        url: baseurl + '/index.php/save_premium_notice',
                        method: 'POST',
                        data: {
                            case_no: case_no,
                            amount: amount,
                            html_content: htmlString // If you need to save the HTML content in the table
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            $.unblockUI();
                            console.log(response);
                            
                        },
                        error: function(error) {
                            $.unblockUI();
                            console.log(error);
                        }
                    });

                    swal.fire("", response.msg, "success")
                    .then((value) => {
                        window.location.href = baseurl + 'index.php/home';
                    });
                }
                else if(response.status == 'FAILED') {
                    swal.fire("", response.msg, "error")
                    .then((value) => {
                        
                    });
                }
            },
            error: function(error) {
                $.unblockUI();
                console.log(error);
            }
        });
	}
 </script>


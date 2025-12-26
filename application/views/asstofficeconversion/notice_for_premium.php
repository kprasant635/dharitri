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
        //border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
        
    }
    .unicode{
        font-size: 5px !important;
    }
</style>
<div class="row login panel-form">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u>(<?php echo $this->lang->line('case_no'); ?> : <?php echo $location['case_no']; ?>) নং ম্যাদীকৰণ গোচৰৰ প্রিমিয়াম আদায়ৰ জাননী</u></span></p>
                </div>
            </div>
            <div class="panel-body" id="printdiv">
                <form class="unicode" method='post' action="<?php echo base_url() . "index.php/AsistantMutationPartha/notice_for_premium_save"; ?>">
                    <table width="100%">
                        <tr style="text-align: center;">
                            <td><label class="control-label" ><?php echo $this->lang->line('district'); ?> : <?php echo $location['dist']; ?></label></td>
                            <td><label class="control-label" ><?php echo $this->lang->line('subdivision'); ?> : <?php echo $location['sub']; ?></label></td>
                            <td><label class="control-label" ><?php echo $this->lang->line('circle'); ?> : <?php echo $location['cir']; ?></label></td>
                        </tr>
                        <tr style="text-align: center;">
                            <td><label class="control-label" ><?php echo $this->lang->line('lot_no'); ?>  : <?php echo $location['lot']; ?></label></td>
                            <td><label class="control-label" ><?php echo $this->lang->line('mouza'); ?>  : <?php echo $location['mouza']; ?></label></td>
                            <td><label class="control-label" ><?php echo $this->lang->line('vill_town'); ?> : <?php echo $location['vill']; ?></label></td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3" style=" padding-left: 50px;">
                            <?php $prem_percent=((trim($lm_details['premium_assesment'])=='40') || (trim($lm_details['premium_assesment'])=='20')? $lm_details['premium_assesment']: $lm_details['prim_per_bigha']); ?>
                            <p class="rasid" >বিঘাই প্রতি <span style="color:#37BC9B"><?=$prem_percent ?> টকা</span> হাৰে <?php echo $lm_details['dag_no']; ?> নং দাগৰ <?php echo $lm_details['conv_b']; ?> বিঘা, <?php echo $lm_details['conv_k']; ?> কঠা, <?php echo $lm_details['conv_lc']; ?> লেছা মাটিৰ প্রিমিয়াম হয় <?php echo $lm_details['prim_tot']; ?> টকা, <span style="color:#37BC9B">(মুঠ প্রিমিয়াম <?php echo $lm_details['prim_tot']; ?> টকা)</span> । নিম্নলিখিত আবেদনকাৰীক (সকলক) প্রিমিয়াম আদায়ৰ বাবে জাননী জাৰী কৰা হ'ল ।</p>
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
                        foreach ($pattadar as $p):
                            $pattadar = $p->pdar_name;
                            //$relation=$p->pdar_rel_guar;
                            $relation = 'f';
                            $relationship = $this->utilityclass->get_relation($relation);
                            ?>
                            <tr style="text-align: center;" class="table table-bordered">
                                <td><label class="control-label" ><?php echo $pattadar; ?></label></td>
                                <td><label class="control-label" ><?php echo $p->pdar_guardian; ?></label></td>
                                <td><label class="control-label" ><?php echo $land_details['dag']; ?></label></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <p class="rasid" style="float: right;"><?php echo $location['add_to']; ?><br>
                                             চক্র বিষয়া,&nbsp;<?php echo $location['cir']; ?></p>
                    </div>
                    <input type="hidden" name="case_no" value="<?php echo $location['case_no']; ?>"/>
                    <input type="hidden" name="amount" value="<?=$lm_details['prim_tot']?>">
                    
                    <hr style="border-bottom: 2px solid #000;" class="dontshow">
                    <?php
                    if($basundharaAttachment){
                        echo "<p class='text-success uni_text text-center'>Note: As this application request is generated from Basundhara Application ,an automatic Payment Request will be intiated to the user for Payment of the Respective Amount of Rs:/- $lm_details[prim_tot] only</p>";
                        echo '<h2 class="red">Basundhara Attachments</h2>';
                        foreach ($basundharaAttachment  as $attachment):
                        ?>
                        <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                        <?php 
                        endforeach; 
                    }
                    else{
                        echo '<h2 class="red">Attachments</h2>';
                        foreach($supportiveDocs as $docs):
                        ?>
                            <h6><a class="red" href="<?php echo base_url('index.php/AjaxController/getFile?id='. $docs->id); ?>" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $docs->file_name;?> (Click to see the attachment)</a></h6>
                        <?php
                        endforeach;
                    }
                    ?>

                    <div class="col-sm-12 dontshow">
                    <center>
                        <button type="submit" name="submit" class="btn btn-success uni_text" onclick="return myFunction()"><i class='fa fa-print'></i> ৰচিদ ছপোৱা আৰু ৰচিদ জাৰি কৰক |</button>
                    </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        $(".dontshow").hide();
		
        window.print();
        $(".dontshow").show();
            document.getElementById("mainMenu").disabled = false;
    }
</script>

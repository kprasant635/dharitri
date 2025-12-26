<div class="row login panel-form">
    <div class="col-lg-12 center-col">
        <div class="panel ">
            <div class="panel-heading">
                <p align="left" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                    অসম অনুসূচী XXXVII(ৰ্পাট I), আবেদন নং ৫৫ 
                </p><br>
                <p align="right" style="margin-top: 0; margin-bottom: 0" class="uni_text">
                    <?php echo $this->lang->line('name'); ?> : 
                    <?php
                    foreach ($p_in_order as $pop):
                        echo $pop->pdar_name . ", " . $pop->pdar_guardian . "<br>";
                    endforeach;
                    ?>
                </p>
                <div class="panel-title">
                    <p class='center bold uni_text'>নিৰ্দেশৰ তালিকা</p>
                    <p class='center uni_text'><u>(১৯১১ ৰেৰ্কড সহায়িকাৰ ১২৯ নং অনুসুচী চাঁওক)</u></p>
                    <br>
                    <p class='center uni_text'>Order Sheet, dated from <?php echo date('d-m-Y', strtotime($location['date'])); ?> to <?php echo date('d-m-Y', strtotime($location['date_of_hearing'])); ?> district <?php echo $location['dist']; ?><br>Case No <?php echo $location['case_no']; ?></p>
                </div>
            </div>
            <div class="panel-body form_1">
                <form class="unicode" action="<?php echo base_url(); ?>index.php/BranchOfficerConversion/action_taken_conversion_save" method="post">
                    <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                        <table class="table table-bordered" style="font-size: 16px;">
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label"><?php echo $this->lang->line('sl_no_and_date_of_order'); ?></label></td>
                                <td width="40%"><label class="control-label"><?php echo $this->lang->line('order_and_signature_of_officer'); ?></label></td>
                                <td width="40%"><label class="control-label"><?php echo $this->lang->line('note_of_action_taken_on_order'); ?></label></td>
                            </tr>
                            <tr style="color:#0000cc; text-align: center;">
                                <td><label class="control-label" >১</label></td>
                                <td><label class="control-label" >২</label></td>
                                <td><label class="control-label" >৩</label></td>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($cases as $case):
                                ?>
                                <tr>
                                    <td><label class="control-label" ><?php echo "(" . $i++ . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></label></td>
                                    <td>
                                        <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
                                        <label class="control-label" ><?php echo $case->dc_order; ?></label></td>
                                    <td>
                                        <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                        <?php
                                        if (strlen($case->note_on_order) != NULL) {
                                            ?>
                                            <?php echo $case->note_on_order; ?>
                                            <input type="hidden" name="note_on_order[]" class="form-control" value="<?php echo $case->note_on_order; ?>"/>
                                            <?php
                                        } else {
                                            ?>
                                            চক্ৰ বিযয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰৰ পৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰনৰ প্ৰস্তাব পৰীক্ষা কৰি চোৱা হল | আবেদিত জমী অসম ভূমিলেখ নিয়মাবলী, ১৯০৬ ৰ ১০৫ নং নিয়ম অনুসৰি আবেদিত জমী ম্যাদী উপযোগী হোৱাত অসম চৰকাৰা শেহতীয়া নিৰ্দ্দেশনা অনুসৰি আবেদিত জমীৰ ম্যাদীকৰন প্ৰিমিয়াম বিঘাই প্ৰতি ----- টকা হাৰত মুঠ ---- টকা আদায় মৰ্মে ম্যাদীকৰন হুকুম দিব পাৰে | শাখা বিষয়া 
                                            <input type="hidden" name="note_on_order[]" class="form-control" value="চক্ৰ বিযয়া <?php echo $location['cir']; ?> ৰাজহ চক্ৰৰ পৰা <span style='color:red;'><?php echo $location['case_no']; ?></span> নং ম্যাদীকৰনৰ প্ৰস্তাব পৰীক্ষা কৰি চোৱা হল | আবেদিত জমী অসম ভূমিলেখ নিয়মাবলী, ১৯০৬ ৰ ১০৫ নং নিয়ম অনুসৰি আবেদিত জমী ম্যাদী উপযোগী হোৱাত অসম চৰকাৰা শেহতীয়া নিৰ্দ্দেশনা অনুসৰি আবেদিত জমীৰ ম্যাদীকৰন প্ৰিমিয়াম বিঘাই প্ৰতি ----- টকা হাৰত মুঠ ---- টকা আদায় মৰ্মে ম্যাদীকৰন হুকুম দিব পাৰে | শাখা বিষয়া "/>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <center>
                        <button type="submit" name="submit" class="btn btn-danger uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_report'); ?></button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="contanier form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <h2 class="center"><?php echo $this->lang->line('order_sheet');?></h2>
            <p class="center"><?php echo $this->lang->line('see_rule_129_of_the_record_manual_1911');?></p>
            <div style="margin-top: 10px">
                <p class="center"><?php echo $this->lang->line('order_sheet');?>,   <?php echo $this->lang->line('from');?> <?php echo date('m-d-Y', strtotime($stdate->stdate)); ?> <?php echo $this->lang->line('to');?> <?php echo date('m-d-Y', strtotime($endate->endate));
; ?> <?php echo $this->lang->line('district');?> : <?php echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')) ?> </p>
               
            </div>

            <form >
                <div class="col-sm-12" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                    <table class="table table-bordered" style="font-size: 16px;">
                        <tr style="color:#0000cc; text-align: center;">
                            <td><?php echo $this->lang->line('sl_no_and_date_of_order');?></td>
                            <td width="40%"><?php echo $this->lang->line('order_and_signature_of_officer');?></td>
                            <td width="40%"><?php echo $this->lang->line('note_of_action_taken_on_order');?> </td>
                        </tr>
                        <tr style="color:#0000cc; text-align: center;">
                            <td>১</td>
                            <td>২</td>
                            <td>৩</td>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($pd as $case):
                            ?>
                            <tr>
                                <td><?php echo "(" . $i . ") " . date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                <td>
                                    <input type="hidden" name="case_no" value="<?php echo $case->case_no; ?>" />
    <?php echo $case->co_order; ?></td>
                                <td>
                                    <input type="hidden" name="proceeding_id[]" value="<?php echo $case->proceeding_id; ?>" />
                                    <textarea name="note_on_order[]" rows="5" cols="8" class="form-control"><?php echo $case->note_on_order; ?></textarea>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </table>
                </div>
                    <center><button   class="btn btn-danger " onclick="goBack()"><?php echo $this->lang->line('back');?></button></center>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
    function goBack() {
    window.history.back();
}

</script>



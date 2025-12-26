    <div class="row login">
    <div class="col-lg-12">

        <?php if($this->session->flashdata('message')):?>
        <div class="col-lg-12 ">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
            </div>
        </div>
        <?php endif;?>
        
        <div class='row'>
            <div class="panel col-lg-12 panel-info panel-form">
                <div class='panel-heading'>
                    <div class='panel-title'>
                        <p class="uni_text">Reverting Case No :<?=$this->input->get('case_no')?></p>
                    </div>
                </div>
                <div class='panel-body'>

                    <form method="POST" action="">
                        
                        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s')?>">
                            <table class="table table-striped table-bordered">
                                <tbody>
                             <?php if($flag == true && ESCALATION_ENABLE ==1 && $out_of_esc == 0){ ?>
                                <tr>
                                    <td><b style="color:red;">Warning  : Assign days to LM for report the Case No. (Maximum <?php echo $day = (int) $remainingDaysCO-1; ?> day)</b></td>
                                    <td>
                                        <select class="form-select" name="allocate_day" >
                                            <?php for ($i=1; $i < $remainingDaysCO; $i++) {  ?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                           <?php  } ?>
                                            
                                        </select>
                                    </td>
                                </tr>
                            <?php } ?>
                                </tbody>
                            </table>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td><span class="text-bold">Reverted To</span></td>
                                        <td>
                                            <span class="text-bold">LM</span>
                                            <input type="radio" name="co_revert_to" id="co_revert_to" value="LM" checked="checked">
                                        </td>
                                        <!-- <td>
                                            <span class="text-bold">SK</span>
                                            <input type="radio" name="co_revert_to" id="co_revert_to" value="SK">
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td><span class="text-bold">Reason of Reverting Back</span></td>
                                        <td colspan="2">
                                            <textarea rows="3" name='revert_report_remarks_co'
                                            id="revert_report_remarks_co" style="width: 100%">Reverting Office Partition Case to ...</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-xs btn-danger"><?=$this->lang->line('submit_report')?></button>
                            <input type="hidden" name="case_no" id="case_no" value="<?=$this->input->get('case_no')?>">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
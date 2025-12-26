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
                        <p class="uni_text">Reverting Case No :<?=$this->input->get('case_id')?></p>
                    </div>
                </div>
                <div class='panel-body'>

                    <form method="POST" action="">
                        
                        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                            
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
                                    
                                    <tr>
                                        <td><span class="text-bold">Reverted To</span></td>
                                        <td>
                                            <input type="hidden" name="executionDate" value="<?=date('Y-m-d H:i:s');?>">
                                            <span class="text-bold">LM</span>
                                            <input type="radio" name="co_revert_to" id="co_revert_to" value="LM" checked="checked">
                                        </td>                                    </tr>
                                    <tr>
                                        <td><span class="text-bold">Reason of Reverting Back</span></td>
                                        <td colspan="2">
                                          <input type="hidden" class="form-control" name='application_no' value="<?=$app->basundhara?>">
                                          <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>">
                                          <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>">
                                            <textarea rows="3" name='revert_report_remarks_co'
                                            id="revert_report_remarks_co" style="width: 100%">Reverting Office Mutation Case to ...</textarea>
                                            <textarea name="co_report_suffix" class="form-control hide" rows="5"><?php echo $location['co_name'].", ";?><?php echo "চক্র বিষয়া, ".$location['cir']; ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-xs btn-danger"><?=$this->lang->line('submit_report')?></button>
                            
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
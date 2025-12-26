<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Revert Back to LM </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid">Case No : <?php echo $this->input->get('case_no'); ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no'); ?> : <?php echo "1"; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="<?php echo base_url() . 'index.php/COFieldMutation/revertBackLSNew' ?>" method="post" >
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
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">Revert Back</label>
                                <div class="col-lg-6 control uni_text">
                                    <input type="radio" name="revert_back" checked id="inlineRadio1" value="L" required> LM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php if($es_flag == null || $es_flag ==0){ ?>
                                        <input type="radio" name="revert_back" id="inlineRadio1" value="S" required> SK
                                    <?php } ?>
                                    
                                </div>
                                <div class="col-lg-2 control uni_text">  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">CO's Order</label>
                                <div class="col-lg-7">
                                    <textarea class="form-control" rows="5" name='co_order' id="textArea" placeholder="Please Type Your Reason For Revert Back"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                
                            </div>
                            <input type='hidden' name='case_no' value='<?php echo $this->input->get('case_no'); ?>'> 
                            <hr style="border-bottom: 2px solid #000;">
                            <center>
                                <button type="submit" id='formsubmit' class="btn btn-primary uni_text"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?></button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
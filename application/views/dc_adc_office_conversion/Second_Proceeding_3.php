<div class="row login panel-form">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class='center bold'><span class="rasid"><u>DC / ADC's Order</u></span></p>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="unicode" method='post' action="<?php echo base_url() . "index.php/dc_adc_conversion/FifthProceeding"; ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $display['case_no']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('sl_no');?> : <?php echo $display['proceeding_id']; ?></label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y', strtotime($display['date'])); ?> </label>
                            <hr>
                            <label class="rasid"><?php echo $this->lang->line('select_one_dag_no_to_enter_conversion_order_details_of_that_dag');?></label>
                            <br>
                            <table class='rasid table table-striped'>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><label class="control-label" ><?php echo $this->lang->line('dag_no');?> :</label></td>
                                    <td><select class="form-control dag_no" id='dag_no' name='dag_no' style="width: 200px;">
                                            <option><?php echo $display['dag_no']; ?></option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <center>
                                <button type="submit" name="submit" class="btn btn-danger uni_text" value="false"><i class='fa fa-check'></i> <?php echo $this->lang->line('next');?> / <?php echo $this->lang->line('proceed');?></button>
                            </center>
                        </div>
                    </div>
                    </form>   
                </div>
            </div>
        </div>
    </div>



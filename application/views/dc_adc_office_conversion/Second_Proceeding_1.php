<div class="row login panel-form">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class='center bold uni_text'><u>DC / ADC's Order</u></p>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="unicode" method='post' action="<?php echo base_url() . "index.php/dc_adc_conversion/ThirdProceeding"; ?>">
                            <label class="col-sm-4 control-label rasid"><?php echo $this->lang->line('case_no');?> : <?php echo $display['case_no']; ?></label>
                            <label class="col-sm-4 control-label rasid"><?php echo $this->lang->line('sl_no');?>  : <?php echo $display['proceeding_id']; ?></label>
                            <label class="col-sm-4 control-label rasid"><?php echo $this->lang->line('date');?> : <?php echo date('d-m-Y', strtotime($display['date'])); ?> </label>
                            <hr>
                            <label class="uni_text" style="color: red;"><?php echo $this->lang->line('applicant_dag_details_information');?></label>
                            <br>
                            <table class='rasid table table-striped'>
                                <tr>
                                    <td><label class="control-label" ><?php echo $this->lang->line('dag_no');?></label></td>
                                    <td><label class="control-label" ><?php echo $this->lang->line('land_area_b_k_l');?></label></td>
                                    <td><label class="control-label" ><?php echo $this->lang->line('patta_no');?></label></td>
                                    <td><label class="control-label" ><?php echo $this->lang->line('patta_type');?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="control-label" ><?php echo $display['dag']; ?></label></td>
                                    <td><label class="control-label" ><?php echo $display['m_dag_area_b']." বিঘা ".$display['m_dag_area_k']." কঠা ".$display['m_dag_area_lc']." লেছা " ?></label></td>
                                    <td><label class="control-label" ><?php echo $display['patta_no']; ?></label></td>
                                    <td><label class="control-label" ><?php echo $patta_type; ?></label></td>
                                </tr>
                            </table>
                            <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-6" align="right">
                                <button type="submit" name="submit1" class="btn btn-danger uni_text" value="true"><i class='fa fa-times'></i>  <?php echo $this->lang->line('cancel_order');?></button>
                            </div>

                            <div class="col-lg-6">
                                <button type="submit" name="submit2" class="btn btn-success uni_text" value="false"><i class='fa fa-check'></i> <?php echo $this->lang->line('give_order');?></button>
                            </div>
                        </div>
                    </div>
                    </form>   
                </div>
            </div>
        </div>
    </div>

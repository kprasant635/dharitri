<div class="container-fluid form-top login">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('dag_no_entry_for_ap_cancellation_petition');?></h2>
                </div>
            </div>
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           <?php echo $this->lang->line('case_no');?> : <?php echo $caseno; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . "index.php/APCancellation/ASTStep4"; ?>">
                            <div class="form-group">
                                <label for="select" class="col-lg-3 control-label"> <?php echo $this->lang->line('dag_no');?></label>
                                <div class="col-lg-6">
                                    <select class="form-control districtselect" id="select" name="dag_no" required>
                                        <option disabled selected><?php echo $this->lang->line('select_dag_no');?></option>
                                        <?php foreach ($dags as $d): ?>
                                            <option><?php echo $d->dag_no; ?></option>
                                        <?php endforeach; ?>
                                    </select>                                   
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" name="dagNoSubmit" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

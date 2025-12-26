<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10  panel panel-default panel-body  col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h2 class='uni_text' style="text-align: center; color: #2e4d8e"> Delete Field Mutation with specific date </h2>
            </div>
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Select Date Range (Please wait for the result. It will take time.)</h3>
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/MisReportController/dcDeleteMutationOrder' ?>">   
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Date</label>
                            <div class="col-sm-4">
                                <input class='form-control' placeholder='click here' id='popupDatepicker' name='date' />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Upto Date</label>
                            <div class="col-sm-4">
                                <input class='form-control' placeholder='click here' id='popupDatepicker1' name='date_upto' />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-5 col-lg-offset-4" style="float: none;margin-top: 20px;margin-bottom: 20px;">
                                <button type="submit" class="btn btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                
                            </div>
                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
        location.href = "<?php echo base_url() . 'index.php/MisReport' ?>";
    };
</script>
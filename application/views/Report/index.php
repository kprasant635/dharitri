<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Agriculture Report</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>
                        
            <div class="panel panel-form">
                <div class="panel-body">
                    <div class="form-group">
                    </div>
                    
                    <table class="table table-striped tab1">
                        <tbody>
                            <!-- <a href="<?php echo base_url(); ?>index.php/AgricultureCountController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Agri-Stack Report</a>
                            <a href="<?php echo base_url(); ?>index.php/ReportController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Bari-Class Report</a> -->
                            <tr>
                                <th>Agri-Stack Report</th>
                                <th width="70%"><a href="<?php echo base_url(); ?>index.php/AgricultureCountController/index" class="btn btn-primary btn-sm">View</a></th>
                            </tr>
                            <tr>
                                <th>Bari-Class Report</th>
                                <th><a href="<?= base_url('index.php/ReportController/BariExport') ?>" class="btn btn-primary btn-sm">Export to Excel</a></th>
                            </tr>
                            <tr>
                                <th>List Of Newly added Pattadar(s)</th>
                                <th><a href="<?= base_url('index.php/ReportController/pattadarReport') ?>" class="btn btn-primary btn-sm">View</a></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>



<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('.tab1').DataTable({
            pageLength: 100
        });
    });
</script> -->



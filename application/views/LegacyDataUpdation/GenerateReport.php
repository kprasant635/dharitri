<style>
.unicode label, tr {
    font-size: 14px !important;
}
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Report on the changes made in Basic Dag details in Chitha & Jamabandi
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Report</h3>
                    </div>
                    <div class="panel-body">
                            <form class='form-horizontal' method="post" action="">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">District</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control"  value="<?php echo $location['dist']; ?>" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Subdivision</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="<?php echo $location['sub']; ?>" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Circle</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="<?php echo $location['cir']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Mouza</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control"  value="<?php echo $location['mouza']; ?>" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Lot No</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="<?php echo $location['lot']; ?>" readonly>
                                    </div>
                                    <label for="inputEmail3" class="col-sm-2 control-label">Village / Town</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" value="<?php echo $location['vill']; ?>" readonly>
                                    </div>
                                </div>
                            </form>
                            <hr style="border-bottom: 2px solid #000;">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th class="center" width="10%"><label class="control-label">Dag / Patta</label></th>
                                <th class="center"><label class="control-label">LM Note</label></th>
                                <th class="center"><label class="control-label">CO Note</label></th>
                                <th class="center"><label class="control-label">DC/ADC Note</label></th>
                                <th class="center"><label class="control-label"><mark style="background-color: #efff00;">Final Order Note</mark></label></th>
                                </thead>
                                <?php 
                                //var_dump($cases);
                                foreach ($cases as $case): ?>
                                    <tr>
                                        <td class="center"><?php echo $case->dag_no; ?> / <?php echo $case->patta_no; ?></td>
                                        <td>
                                            <span class="badge badge-danger"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->lm_date)); ?></span><br>
                                            <?php echo $case->lm_note; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->co_orddate)); ?></span><br>
                                            <?php echo $case->co_note; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($case->dc_adc_orddate)
                                                {
                                                ?>
                                            <span class="badge badge-danger"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->dc_adc_orddate)); ?></span><br>
                                            <?php
                                                }
                                                ?>
                                            <?php echo $case->dc_adc_note; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-info"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->co_ordpass_date)); ?></span><br>
                                            <?php echo $case->co_ordpass_note; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $("a").tooltip();
    });
</script>
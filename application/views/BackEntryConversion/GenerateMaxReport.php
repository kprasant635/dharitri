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
                        Report on the changes made through backlog office / field mutation in Chitha & Jamabandi
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Report - Circle Wise</h3>
                    </div>
                    <div class="panel-body">
                            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label">District</label></th>
                                <th class="center"><label class="control-label">Sub Division</label></th>
                                <th class="center"><label class="control-label">Circle</label></th>
                                <th class="center"><label class="control-label">Field Mutation</label></th>
                                <th class="center"><label class="control-label">Office Mutation</label></th>
                                <th class="center"><label class="control-label">Field Partition</label></th>
                                <th class="center"><label class="control-label">Office Partition</label></th>
                                </thead>
                                <?php 
                                //var_dump($result);
                                foreach ($result as $case): ?>
                                    <tr>
                                        <td class='center'><?php echo $case['dist_name']; ?></td>
                                        <td class='center'><?php echo $case['subdiv_name']; ?></td>
                                        <td class='center'><?php echo $case['cir_name']; ?></td>
                                        <td class='center'>
                                            <?php 
                                            $order_type = 'FM';
                                            if($case['total_count_Fmutation'] > 0){
                                                $url = base_url() . "index.php/BackLogMutation/MaxReportVill?dist_code=" . $case['dist_code'] . "&subdiv_code=" . $case['subdiv_code'] . "&cir_code=" . $case['cir_code'] . "&order_type=".$order_type;
                                                echo '<span class="badge badge-info">'.$case['total_count_Fmutation'].'</span>&nbsp;<a href="'.$url.'">View</a>';
                                            }
                                            ?>
                                        </td>
                                        <td class='center'>
                                            <?php 
                                            $order_type = 'OM';
                                            if($case['total_count_Omutation'] > 0){
                                                $url = base_url() . "index.php/BackLogMutation/MaxReportVill?dist_code=" . $case['dist_code'] . "&subdiv_code=" . $case['subdiv_code'] . "&cir_code=" . $case['cir_code'] . "&order_type=".$order_type;
                                                echo '<span class="badge badge-info">'.$case['total_count_Omutation'].'</span>&nbsp;<a href="'.$url.'">View</a>';
                                            }
                                            ?>
                                        </td>
                                        <td class='center'><span class="badge badge-info"><?php echo $case['total_count_Fpartition']; ?></span></td>
                                        <td class='center'><span class="badge badge-info"><?php echo $case['total_count_Opartition']; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
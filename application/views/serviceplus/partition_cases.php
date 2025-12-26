<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">Pending Partition Cases From Service Plus</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                                <thead>
                                <th><label class="control-label">Application No</label></th>
                                <th><label class="control-label">Patta No</label></th>
                                <th><label class="control-label">Dag No</label></th>
                                <th><label class="control-label">Land Schedule</label></th>
                                <th><label class="control-label">Submission Date</label></th>
                                <th><label class="control-label">Action</label></th>
                                </thead>
                                <?php
                                $i = 1;
                                foreach ($result as $s) {
                                    $dist_code = $s['dist_code'];
                                    $subdiv_code = $s['subdiv_code'];
                                    $cir_code = $s['cir_code'];
                                    $mouza_pargona_code = $s['mouza_pargona_code'];
                                    $lot_no = $s['lot_no'];
                                    $vill_townprt_code = $s['vill_townprt_code'];
                                    $patta_no = $s['patta_no'];
                                    $dag_no = $s['dag_no'];
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $s['application_ref_no']; ?></td>
                                        <td class='center'><?php echo $patta_no ?></td>
                                        <td class='center'><?php echo $dag_no/100 ?></td>
                                        <td class='center'>
                                            <span class='badge badge-info'><?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?></span>
                                            <span class='badge'><?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); ?></span>
                                            <span class='badge badge-danger'><?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code); ?></span>
                                        </td>
                                        <td class="center"><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($s['apply_date'])); ?></td>
                                        <td class="center">
                                            <a href='<?php echo base_url() ?>index.php/Serviceplus/partition_register?application_ref_no=<?php echo $s['application_ref_no'] ?>&applid=<?php echo $s['applid'] ?>' class='btn btn-primary btn-sm btn-block'><i class="fa fa-file-image-o" aria-hidden="true"></i> Register Application </a>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </table>
                            
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bInfo": false,
            "pageLength": 10
        });
    });
</script> 
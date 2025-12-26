<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">Pending Order Sheet Application From Service Plus</h2>
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
                                <th><label class="control-label">Case No</label></th>
                                <th><label class="control-label">Patta No</label></th>
                                <th><label class="control-label">Land Schedule</label></th>
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
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $s['application_ref_no']; ?></td>
                                        <td><span class="ellipsis"><?php echo $string = $s['appln_name']; ?></span></td>
                                        <td class='center'><?php echo $patta_no ?></td>
                                        <td class='center'>
                                            <span class='badge badge-info'><?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?></span>
                                            <span class='badge'><?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); ?></span>
                                            <span class='badge badge-danger'><?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code); ?></span>
                                        </td>
                                        <td class="center">
                                            <a href='<?php echo base_url() ?>index.php/serviceplus/register_mutorder_applicant?application_ref_no=<?php echo $s['application_ref_no'] ?>&applid=<?php echo $s['applid'] ?>' class='btn btn-primary btn-sm btn-block'><i class="fa fa-file-image-o" aria-hidden="true"></i> Register Application </a>
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
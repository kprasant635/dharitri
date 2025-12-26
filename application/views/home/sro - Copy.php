<style>
    #srodata{
        margin-top:40px;
        background:#ccc;
    }
</style>
<div class="col-lg-12 "  id="sro" >
    <div class="panel ">
        <div class="panel-heading">
            <div class="panel-title">
                <p class="regular">New Sub Registrar Office Registrations</p>
                <form class="pull-right">
                    <input type="text" required="" id="s" class="dating" placeholder="start date"/>
                    <input type="text" required="" id="e" class="dating" placeholder="end date"/>
                    <input type="submit" id="filter" class="btn btn-active" value="Filter"/>
                </form>
            </div>

        </div>
        <div class="panel-body" id="srodataa">
            <?php //var_dump($sronote); ?>
            <table class='centertable table table-stripped table-compressed'>
                <thead class='info center'>
                    <tr class='center'>
                        <th class='center'>SL No</th><th class='center'>Applicant Name</th><th class='center'>Deed No</th><th class='center'>Land Schedule</th><th class='center'>Dag/Patta</th><th class='center'>Action</th><th class='center'>Action</th></tr></thead>
                <tbody>
                    <?php
                    $i = 1;
                    //var_dump($sronote);
                    foreach ($sronote as $s) {
                        $dist_code = $s->dist_code;
                        $subdiv_code = $s->subdiv_code;
                        $cir_code = $s->cir_code;
                        $mouza_pargona_code = $s->mouza_pargona_code;
                        $lot_no = $s->lot_no;
                        $vill_townprt_code = $s->vill_townprt_code;
                        $dag_no = $s->dag_no;
                        $patta_no = $s->patta_no;
                        ?>

                        <tr class='center'>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $s->reg_to_name; ?> </td>
                            <td><?php echo $s->deed_no; ?></td>
                            <td>M:<span class='badge badge-info'> <?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?></span>
                                L: <span class='badge'><?php echo $lot_no ?></span>
                                V:	<span class='badge badge-danger'><?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code); ?></span>
                            </td>
                            <td><?php echo $dag_no . "/" . $patta_no; ?></td>
                            <td><a target='_blank' href='http://10.177.15.118:8084/webservices/deedview?slno=<?php echo $s->deed_no ?>&dist=<?php echo $s->dist_code ?>&sro=<?php echo $s->sro_code ?>&key=deedview&hashkey=3178a787e21cecf8e9dd744a9c07d82ea1bc0e61' class='btn btn-primary btn-sm'><i class="fa fa-file-image-o" aria-hidden="true"></i> View Deed</a>
                            </td> 
                            <td>
                                <?php
                                $user_desig = $this->session->userdata('user_desig_code');
                                if ($user_desig == 'CO') {
                                    ?>
                                    <a href='<?php echo base_url() . 'index.php/DisplayDeed/Updatestatus?d=' . $dist_code . '&s=' . $subdiv_code . '&c=' . $cir_code . '&deed=' . $s->deed_no ?>' class='btn btn-warning btn-sm'><i class="fa fa-check-square-o" aria-hidden="true"></i> Process</a>
                                <?php } ?>

                                <?php
                                if (($user_desig == 'DC') || ($user_desig == 'ADC') || ($user_desig == 'LAO')) {
                                    ?>
                                    <a target='_blank' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=4&dag=' . $dag_no . '&dist=' . $dist_code . '&sub_div=' . $subdiv_code . '&cir=' . $cir_code . '&m=' . $mouza_pargona_code . '&l=' . $lot_no . '&v=' . $vill_townprt_code . '&p=' . $s->patta_type_code ?>" class='btn btn-info btn-sm'><i class="fa fa-file-word-o" aria-hidden="true"></i> Show Chitha</a>
                                    <?php
                                } else {
                                    ?>
                                    <a target='_blank' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=3&dag=' . $dag_no . '&m=' . $mouza_pargona_code . '&l=' . $lot_no . '&v=' . $vill_townprt_code . '&p=' . $s->patta_type_code ?>" class='btn btn-info btn-sm'><i class="fa fa-file-word-o" aria-hidden="true"></i> Show Chitha</a>
                                    <?php
                                }
                                ?>


                            </td>


                        </tr>
    <?php $i++;
} ?>
                </tbody>

            </table>


        </div>
    </div>

</div>
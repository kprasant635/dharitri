<style>
    #srodata{
        margin-top:40px;
        background:#ccc;
    }
    .ellipsis {
        float: left;
        font-family: Arial;
        /* background: #FAFA41; */
        /* margin: 5px 0; */
        /* padding: 1%; */
        width: 150px;
        overflow: hidden;
        white-space: nowrap;
        height: 17px;
        text-overflow: ellipsis;
        color: #505050;
    }
</style>
<div class="col-lg-12 " id="sro" >
    <div class="panel ">
        <div class="panel-heading">
            <div class="panel-title">
                <p class="regular">New Sub Registrar Office Registrations</p>
                <form class="pull-right hide">
                    <input type="text" required="" id="s" class="dating" placeholder="start date"/>
                    <input type="text" required="" id="e" class="dating" placeholder="end date"/>
                    <input type="submit" id="filter" class="btn btn-active" value="Filter"/>
                </form>
                <?php
                $user_desig = $this->session->userdata('user_desig_code');
                if ($user_desig == 'CO') {
                    ?>
                    <a href="<?php echo base_url() . 'index.php/DisplayDeed' ?>" style='color:#fff' class='btn btn-danger btn-sm pull-right'><i class="fa fa-cogs blink_me" aria-hidden="true"></i> Please Click here to Update Deed List</a>
                <?php } ?>
            </div>

        </div>
        <div class="panel-body" id="srodataa">
            <?php //var_dump($sronote); ?>
            <table id="example" class='centertable table table-stripped table-compressed'>
                <thead class='info center'>
                    <tr class='center'>
                        <th class='center'>SL.No</th>
                        <th>Applicant Name</th>
                        <th class='center' width="10%">Deed SL.No</th>
                        <th class='center' width="20%">Land Schedule</th>
                        <th class='center'>Dag/Patta</th>
                        <th class='center'>Action</th>
                        <th class='center'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
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
                    <tr>
                        <td class='center'><?php echo $i; ?></td>
                        <td><span class="ellipsis"><?php echo $s->reg_to_name; ?></span></td>
                        <td class='center'><?php echo $s->deed_no; ?></td>
                        <td class='center'>
                            <span class='badge badge-info'><?php echo $this->utilityclass->getMouzaName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code); ?></span>
                            <span class='badge'><?php echo $this->utilityclass->getLotName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no); ?></span>
                            <span class='badge badge-danger'><?php echo $this->utilityclass->getVillageName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code); ?></span>
                        </td>
                        <td class='center'><?php echo $dag_no . "/" . $patta_no; ?></td>
                        <td class='center'>
                            <a target='_blank' href='<?php echo base_url() ?>index.php/DisplayDeed/sro?slno=<?php echo $s->deed_no ?>&dist=<?php echo $s->dist_code ?>&sro=<?php echo $s->sro_code ?>' class='btn btn-primary btn-sm btn-block'><i class="fa fa-file-image-o" aria-hidden="true"></i> View Deed </a>
                            <a target='_blank' href='<?php echo base_url() ?>index.php/DisplayDeed/noc?appno=<?php echo $s->nocno ?>' class='btn btn-info btn-sm btn-block'><i class="fa fa-file-image-o" aria-hidden="true"></i> View Noc </a>
                        </td> 
                        <td class='center'>
                            <?php
                            if (($user_desig == 'CO') and ($s->status =='0')) {
                                ?>
                                <a href='<?php echo base_url() . 'index.php/DisplayDeed/Updatestatus?deed=' . $s->deed_no ?>' class='btn btn-warning btn-sm btn-block'><i class="fa fa-check-square-o" aria-hidden="true"></i> Process</a>
                            <?php } ?>
                            <?php
                            if (($user_desig == 'DC') || ($user_desig == 'ADC') || ($user_desig == 'LAO')) {
                                ?>
                                <a target='_blank' href="<?php echo base_url() . 'index.php/chithareport/generateChithaforSro?case_no=4&dag=' . $dag_no . '&dist=' . $dist_code . '&sub_div=' . $subdiv_code . '&cir=' . $cir_code . '&m=' . $mouza_pargona_code . '&l=' . $lot_no . '&v=' . $vill_townprt_code . '&p=' . $s->patta_type_code ?>" class='btn btn-info btn-sm btn-block'><i class="fa fa-file-word-o" aria-hidden="true"></i> Show Chitha</a>
                                <?php
                            } else {
                                $dag_no = trim($dag_no);
                                $trim = explode(" ", $dag_no);
                                $trimmed_dag_no = $trim[0];
                                ?>
                                <a target='_blank' href="<?php echo base_url() . 'index.php/chithareport/generateChithaforSro?case_no=3&dag=' . $trimmed_dag_no . '&m=' . $mouza_pargona_code . '&l=' . $lot_no . '&v=' . $vill_townprt_code . '&p=' . $s->patta_type_code ?>" class='btn btn-info btn-sm btn-block'><i class="fa fa-file-word-o" aria-hidden="true"></i> Show Chitha</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </tbody>

            </table>


        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            
        });

    });
</script> 
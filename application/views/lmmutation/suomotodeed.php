<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Pending Field Mutation Deeds
                    </h2>
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
                            <th class="center"><label class="control-label">Deed No.</label></th>
                            <th><label class="control-label">CO's Instruction</label></th>
                            <th class="center"><label class="control-label">Action</label></th>
                            <th class="center"><label class="control-label">Deed</label></th>
                            <th class="center"><label class="control-label">Chitha</label></th>
                            </thead>
                            <?php
                            foreach ($sronote as $note) {

                                $mouza_pargona_code = $note->mouza_pargona_code;
                                $lot_no = $note->lot_no;
                                $vill_townprt_code = $note->vill_townprt_code;
                                $dag_no = $note->dag_no;
                                $patta_type_code = $note->patta_type_code;
                                ?>
                                <tr>
                                    <td class="center"><?php echo $note->deed_no; ?></td>
                                    <td><?php echo $note->co_order; ?></td>
                                    <td><a href='<?php echo base_url() . 'index.php/lmmutation/RegisterSuomoto?deed=' . $note->deed_no ?>' class='btn btn-sm btn-danger '>Register Case</a></td>
									<td><a target='_blank' href='<?php echo base_url() ?>index.php/DisplayDeed/sro?slno=<?php echo $note->deed_no ?>&dist=<?php echo $note->dist_code ?>&sro=<?php echo $note->sro_code ?>' class='btn btn-primary btn-sm btn-block'><i class="fa fa-file-image-o" aria-hidden="true"></i> View Deed </a></td>
                                    <td><a target='_blank' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=3&dag=' . $dag_no . '&m=' . $mouza_pargona_code . '&l=' . $lot_no . '&v=' . $vill_townprt_code . '&p=' . $patta_type_code ?>" class='btn btn-info btn-sm'><i class="fa fa-file-word-o" aria-hidden="true"></i> Show Chitha</a></td>
                                </tr>
                            <?php } ?>
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
            "pageLength": 20
        });

    });
</script>  
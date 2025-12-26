<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Suo-Moto Registration of Mutation Case(s)
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
                                <th><label class="control-label">Deed No.</label></th>
                                <th class="center"><label class="control-label">CO's Instruction</label></th>
                                <th class="center"><label class="control-label">Action</label></th>
                                <th class="center"><label class="control-label">Action</label></th>
                                </thead>
                            <tbody>
                                <?php foreach($sronote as $note):?>
                                <?php
                                $mouza_pargona_code = $note->mouza_pargona_code;
                                $lot_no = $note->lot_no;
                                $vill_townprt_code = $note->vill_townprt_code;
                                $dag_no = $note->dag_no;
                                $patta_type_code = $note->patta_type_code;
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $note->deed_no;?>
                                    </td>
                                    <td class="center">
                                        <?php echo $note->co_order; ?>
                                    </td>
                                    <td class="center">
                                        <a href='<?php echo base_url() . 'index.php/officemutation/RegisterSuomoto?deed=' . $note->deed_no ?>' class='btn btn-sm btn-primary btn-block'><i class="fa fa-pencil"></i>&nbsp;Register Case</a>
                                    </td>
                                    <td class="center">
                                        <a target='_blank' href="<?php echo base_url() . 'index.php/chithareport/generateChitha?case_no=3&dag=' . $dag_no . '&m=' . $mouza_pargona_code . '&l=' . $lot_no . '&v=' . $vill_townprt_code . '&p=' . $patta_type_code ?>" class='btn btn-info btn-sm btn-block'><i class="fa fa-file-word-o" aria-hidden="true"></i> Show Chitha</a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
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
$(document).ready(function() {
    $('#example').DataTable({
	"bLengthChange": false,
	"showNEntries" : false,
	"bSort" :	false,
	"bnew" :	false,
	"pageLength": 20
  });
  
});
</script> 
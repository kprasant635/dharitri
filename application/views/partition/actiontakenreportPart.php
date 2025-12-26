<style>
p{ font-size:.7em }
</style>
<div class="container-fluid form-top login">
    <div class='row'>
        <div class='col-lg-10 panel panel-default' style="margin: 0 auto;float: none;">          
            <table id="example" class="table table-hover  panel-body" width="100%">
                <thead class="center">
                    <tr >
                        <th class="alert-new"><?php echo $this->lang->line('case_no'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('petition_no'); ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('dag_no') ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('submission_date') ?></th>
                        <th class="alert-new"><?php echo $this->lang->line('status') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($partpetition as $p) { ?>
                    <tr>
                        <td ><?php echo $p->case_no; ?></td>
                        <td ><?php echo $p->petition_no; ?></td>
                        <td ><?php 
                        $dag=$this->utilityclass->dagnumbr($p->dist_code,$p->subdiv_code,$p->cir_code,$p->mouza_pargona_code,$p->lot_no,$p->vill_townprt_code,$p->petition_no);
                        echo $dag->dag_no;
                        ?></td>
                        <td ><?php echo date('d-m-Y',  strtotime($p->submission_date)); ?></td>
                            <?php
                            if (($p->next_date_of_hearing == null)) {
												if($p->status == 'D'){
                                                        echo "<td><p class=\"green small regular \"><i class=\"fa fa-thumbs-up \" aria-hidden=\"true\"></i>"." Order has been Deleted/Disposed"."</p></td>";
                                                }else{
                                ?>
                                <td ><a class="text-danger">Next Hearing Date Not Given</a></td>
                                <?php
												}
								} else {
                                ?>
                                <td ><a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/partition/ViewActionTakenReport?case_no=<?php echo $p->case_no; ?>">View Report</a>
                               <?php
                                                $datetime1 = new DateTime();
                                                $datetime2 = new DateTime(date('d-m-Y',  strtotime($p->next_date_of_hearing)));
                                                $interval = $datetime1->diff($datetime2);
                                                $days  = $interval->format('%R%a');
                                               // echo $p->status;
                                                if(($p->status == 'P') ){
													if($days <= -1){
														echo "<p class=\"red small  blink_me\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i>"." Lapsed by " . abs($days)." days ago"."</p>";
													}   
												}if($p->status == 'F'){
                                                        echo "<p class=\"green small  \"><i class=\"fa fa-thumbs-up \" aria-hidden=\"true\"></i>"." Final Order has been Passed"."</p>";
                                                }
												if($p->status == 'D'){
                                                        echo "<p class=\"green small  \"><i class=\"fa fa-thumbs-up \" aria-hidden=\"true\"></i>"." Order has been Deleted/Disposed"."</p>";
                                                }
                                            ?>
                                </td>
                            <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bnew": false,
            "pageLength": 20
        });

    });
</script> 

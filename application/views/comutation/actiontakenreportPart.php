<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Office Mutation Cases Proceeding Report
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Case Status Report
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?> / Location</label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('dag_no') ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('status') ?></label></th>
                            </thead>
                            <?php foreach ($partpetition as $case): 
                                $dag=$this->utilityclass->dagnumbr($case->dist_code,$case->subdiv_code,$case->cir_code,$case->mouza_pargona_code,$case->lot_no,$case->vill_townprt_code,$case->petition_no);
                                if(!empty($dag->dag_no)){
                                ?>
                                <tr>
                                    <td><?php echo $case->case_no; ?></td>
                                    <td class="center"><?php
                                        echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                        echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                        echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $dag->dag_no; ?>
                                    </td>
                                    <td class="center">
                                        <p class='text-success'> <i class='fa fa-calendar'></i> Submited On : <?php echo date('M jS, Y', strtotime($case->date_entry)); ?></p>
                                        <?php
                                        $datetime1 = new DateTime();
                                        $datetime2 = new DateTime(date('d-m-Y',  strtotime($case->next_date_of_hearing)));
                                        $interval = $datetime1->diff($datetime2);
                                        $days  = $interval->format('%R%a');
                                        if(($case->status == 'P') ){
                                            if($days <= -1){
                                                echo "<p class='text-danger blink_me'><i class='fa fa-exclamation-circle' aria-hidden='true'></i>"." Lapsed by " . abs($days)." days ago"."</p>";
                                            }   
                                        }
                                        if($case->status == 'F'){
                                            echo "<p class='text-primary'> <i class='fa fa-thumbs'></i> Final Order has been Passed </p>";
                                        }
                                        if($case->status == 'D'){
                                            echo "<p class='text-primary'> <i class='fa fa-thumbs red'></i> Order has been Rejected </p>";
                                        }
                                        if ($case->next_date_of_hearing == null) {
                                            echo "<p class='text-primary'> <i class='fa fa-thumbs red'></i> Next Hearing Date Not Given </p>";
                                        } else {
                                            ?>
                                            <?php $link = base_url() . "index.php/coofficemutation/ViewActionTakenReport?case_no=" . $case->case_no . "&dist_code=" . $case->dist_code . "&subdiv_code=" . $case->subdiv_code . "&cir_code=" . $case->cir_code . "&mouza_pargona_code=" . $case->mouza_pargona_code . "&lot_no=" . $case->lot_no . "&vill_townprt_code=" . $case->vill_townprt_code; ?>
                                            <a class="btn btn-success" href="<?php echo $link; ?>">View Report</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php endforeach; ?>
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


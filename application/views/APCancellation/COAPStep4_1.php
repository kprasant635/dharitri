<?php //var_dump($getOrderAPCancellation);
?>

<div class="container-fluid form-top login">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php echo $this->lang->line('give_co_order_for_ap_cancellation'); ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="active text-center">
                                <th><?php echo $this->lang->line('sl_no'); ?></th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('case_no'); ?>
                                </th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('submission_date'); ?>
                                </th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('date_of_hearing'); ?>
                                </th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('give_order'); ?>
                                </th>
                            </tr>
                            <?php
                            $row = count($getOrderAPCancellation);
                            if ($row > 0) {
                                $c = 1;
                                foreach ($getOrderAPCancellation as $cases) {
                            ?>
                                    <tr class="text-center">
                                        <td><?php echo $c; ?></td>
                                        <td><?php echo $cases->case_no; ?></td>
                                        <td><?php
                                            $d = $cases->submission_date;
                                            echo date("d-m-Y", strtotime($d));
                                            ?></td>

                                        <td>
                                            <?php

                                            $today = date("Y-m-d");
                                            $d1 = $cases->date_hearing;
                                            $date_of_hearing = date("Y-m-d", strtotime($d1));
                                            echo date("d-m-Y", strtotime($d1));
                                            ?>
                                        </td>

                                        <td>
                                            <?php if ($date_of_hearing <= $today) { ?>
                                                <a href="<?php echo base_url() . "index.php/APCancellation/COAPStep4_2"; ?>?submission_date=<?php echo $cases->submission_date; ?>&dist_code=<?php echo $cases->dist_code; ?>&subdiv_code=<?php echo $cases->subdiv_code; ?>&cir_code=<?php echo $cases->cir_code; ?>&mouza_pargona_code=<?php echo $cases->mouza_pargona_code; ?>&lot_no=<?php echo $cases->lot_no; ?>&vill_townprt_code=<?php echo $cases->vill_townprt_code; ?>&year_no=<?php echo $cases->year_no; ?>&petition_no=<?php echo $cases->petition_no; ?>&case_no=<?php echo $cases->case_no; ?>"
                                                    class="btn btn-primary"><?php echo $this->lang->line('give_order'); ?></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                    $c++;
                                }
                            } else {
                                ?>
                                <tr class="text-center">
                                    <td colspan="4" style="color: red;">
                                        <?php echo $this->lang->line('no_fresh_nr_cases_found'); ?>
                                        <br />
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>

                        <?php echo $this->pagination->create_links(); ?>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                <i
                                    class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
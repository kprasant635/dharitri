<div class="container-fluid form-top">
    <div class="row login">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <!--                        View Petition By Lot Mondal (LM)-->
                       <?php echo $this->lang->line('view_petition');?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <strong><?php echo $_GET['case_no']; ?></strong>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="success">
                                <td class="text-center"><h6><?php echo $this->lang->line('district');?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('circle');?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                            </tr>
                            <tr >
                                <td class="text-center"><h6><?php echo $this->lang->line('mouza');?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?> : <strong><?php
                                            $d = $_GET['submission_date'];
                                           echo date("d-m-Y", strtotime($d));
                                            ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $landtype->patta_type; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $landtype->add_off_desig; ?></strong></h6></td>
                            </tr>
                        </table>
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="danger">
                                <td colspan="6"><?php echo $this->lang->line('petitioner_info');?></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><?php echo $this->lang->line('sl_no');?></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('name');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('guardian');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('relation');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address1');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address2');?></h6></td>
                            </tr>
                            <?php
                            $c = 1;
                            foreach ($petitioninfo AS $petitioner) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $c; ?></td>
                                    <td class="text-center"><?php echo $petitioner->pet_name; ?></td>
                                    <td class="text-center"><?php echo $petitioner->guard_name; ?></td>
                                    <td class="text-center"><?php echo $petitioner->guard_rel; ?></td>
                                    <td class="text-center"><?php echo $petitioner->add1; ?></td>
                                    <td class="text-center"><?php echo $petitioner->add2; ?></td>
                                </tr>
                                <?php
                                $c++;
                            }
                            ?>
                        </table>
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="danger">
                                <td colspan="5"><?php echo $this->lang->line('pattadar_info');?></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><?php echo $this->lang->line('name');?></td>
                                <td class="text-center"><?php echo $this->lang->line('guardian');?></td>
                                <td class="text-center"><?php echo $this->lang->line('relation');?></td>
                                <td class="text-center"><?php echo $this->lang->line('address1');?></td>
                                <td class="text-center"><?php echo $this->lang->line('address2');?></td>
                            </tr>
                            <?php
                            //var_dump($pattadars);
                            foreach ($pattadars AS $pdar) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $pdar->pdar_name; ?></td>
                                    <td class="text-center"><?php echo $pdar->pdar_guardian; ?></td>
                                    <td class="text-center"><?php echo $pdar->pdar_rel_guar; ?></td>
                                    <td class="text-center"><?php echo $pdar->pdar_add1; ?></td>
                                    <td class="text-center"><?php echo $pdar->pdar_add2; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="danger">
                                <td colspan="4"><?php echo $this->lang->line('pattadar_dag_information');?></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><?php echo $this->lang->line('dag_no');?></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_no');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('show_chitha');?></h6></td>
                            </tr>
                            <?php foreach ($daginfo AS $dag) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $dag->dag_no; ?></td>
                                    <td class="text-center"><?php echo $dag->patta_no; ?></td>
                                    <td class="text-center"><?php echo $landtype->patta_type; ?></td>
                                    <td class="text-center">
                                        <a href="##" class="btn btn-sm btn-danger">
                                            <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('show_chitha');?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <a href="javascript:history.back()" class="btn btn-sm btn-danger">
                            <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid form-top login">
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center; "><?php echo $this->lang->line('co_note_of_hearing'); ?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no'); ?> : <?php echo $_GET['case_no']; ?>
                        </h3>
                    </div>
                    <div class="panel-body">                   
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="success">
                                <td class="text-center"><h6><?php echo $this->lang->line('district'); ?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('subdivision'); ?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('circle'); ?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                            </tr>
                            <tr>
                                <td class="text-center"><h6><?php echo $this->lang->line('mouza'); ?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('lot_no'); ?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('vill_town'); ?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><h6><?php echo $this->lang->line('submission_date'); ?> : <strong><?php
                                            $d = $_GET['submission_date'];
                                            echo date("d-m-Y", strtotime($d));
                                            ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_type'); ?> : <strong><?php echo $landtype->patta_type; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address_to_the_officer'); ?> : <strong>
                                            <?php
                                            $co_name = $this->utilityclass->getSelectedCOName($locations['dist_code'], $locations['subdiv_code'], $locations['cir_code'], $landtype->add_off_name);
                                            echo $co_name->username;
                                            ?>
                                        </strong></h6></td>
                            </tr>                      
                        </table>
                        <table class="table table-striped table-bordered" width="100%">
                            <tr>
                                <td><?php echo $this->lang->line('co_note_of_hearing'); ?></td>
                                <td style="font-weight: bold;">
                                    <p>
                                        <?php echo $note_on_order; ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <center>
                            <a href="javascript:history.back()" class="btn btn-md btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


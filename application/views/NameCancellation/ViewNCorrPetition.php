<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center">Application Details for Name Cancellation</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <?php echo $misc_case_no = $_GET['misc_case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;
							echo date("d-m-Y", strtotime($d));
							?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/NameCorrection/COStep2_save"; ?>">                       

                            <h3><?php echo $this->lang->line('basic_information');?> </h3>
                            <hr/>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered" width="100%">
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('district');?>  : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?>  : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('circle');?>  : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('mouza');?>  : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?>  : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                                        </tr>
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?>  : <strong><?php
                                                        $d = $miscCaseInfo->submission_date;
                                                        echo date("d-m-Y", strtotime($d));
                                                        ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $pattaType->patta_type; ?></strong></h6></td>
                                            <td class="text-center "><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $user_name->username; ?></strong></h6></td>
                                        </tr> 
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_no');?>  : <strong><?php echo $miscCaseInfo->patta_no; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('dag_no');?>  : <strong><?php echo $miscCaseInfo->dag_no; ?></strong></h6></td>
                                            <td class="text-center"></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                            
                            <h3><?php echo $this->lang->line('related_document_information');?></h3>
                            <hr/>
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered" width="100%">
                                    <?php
                                    $c = 1;
                                    foreach ($SupportDoc AS $sup) {
                                        ?>
                                        <tr class="success">
                                            <td>
                                        <?php echo $c . ". " . $sup->supp_doc_name; ?>
                                            </td>
                                        </tr>
                                    <?php $c++; } ?>
                                </table>
                            </div>
                            <h3><?php echo $this->lang->line('petitioner_information');?> </h3>
                            <hr/>
                            <div class="col-lg-12">
                               
                                <table class="table table-striped table-bordered" width="100%">
                                    <?php
                                    $c = 1;
                                   // foreach ($Petitioner AS $pet) {
                                        ?>
                                        <tr class="success">
                                            <td>
                                              <?php echo $c;?>. <?php echo $this->lang->line('petitioner_name');?>  : <strong><?php echo $pet->petition_pdar_name_old;?></strong>
                                            </td>
                                            <td>
                                                <?php //echo $this->lang->line('guardian_name');?>    <strong><?php //echo $pet->pdar_father;?></strong>
                                            </td>
                                            <td>
                                               <?php //echo $this->lang->line('address1');?>   <strong><?php //echo $pet->pdar_add1;?></strong>
                                            </td>
                                            <td>
                                              <?php //echo $this->lang->line('address2');?>   <strong><?php //echo $pet->pdar_add2;?></strong>
                                            </td>
                                        </tr>
                                        <?php //$c++; } ?>
                                </table>
                            </div>
                            
                            <h3><?php echo $this->lang->line('second_party_information');?> </h3>
                            <hr/>
                            <div class="col-lg-12">
                                
                                
                                 <table class="table table-striped table-bordered" width="100%">
                                    <?php
                                    $c = 1;
                                    foreach ($secondparty AS $pet) {
                                        ?>
                                        <tr class="success">
                                            <td>
                                              <?php echo $c;?>. <?php echo $this->lang->line('name');?>  : <strong><?php echo $pet->pdar_name;?></strong>
                                            </td>
                                            <td>
                                                <?php echo $this->lang->line('guardian_name');?>  : <strong><?php echo $pet->pdar_father;?></strong>
                                            </td>
                                            <td>
                                                <?php echo $this->lang->line('address1');?> : <strong><?php echo $pet->pdar_add1;?></strong>
                                            </td>
                                            <td>
                                                <?php echo $this->lang->line('address2');?> : <strong><?php echo $pet->pdar_add2;?></strong>
                                            </td>
                                        </tr>
                                        
                                        
                                        <?php $c++; } ?>
                                </table>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <br/>
                                    <a href="javascript:history.back();" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back');?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


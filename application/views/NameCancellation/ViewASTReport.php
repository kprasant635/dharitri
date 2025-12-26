<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('ast_report');?></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <?php echo $misc_case_no = $_GET['misc_case_no']; ?>  <span class="pull-right"><?php echo $this->lang->line('date');?> : <?php $d = $miscCaseInfo->submission_date;  echo date("d-m-Y", strtotime($d));?></span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/NameCorrection/SKStep2_save"; ?>">                       

                            <input type="hidden" name="misc_case_no" value="<?php echo $misc_case_no; ?>"/>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered" width="100%">
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('district');?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('circle');?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('mouza');?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                                        </tr>
                                        <tr class="success">
                                            <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?> : <strong><?php $d = $miscCaseInfo->submission_date;
                                                        echo date("d-m-Y", strtotime($d)); ?></strong></h6></td>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $pattaType->patta_type; ?></strong></h6></td>
                                            <td class="text-center "><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $user_name->username; ?></strong></h6></td>
                                        </tr> 
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_no');?> : <strong><?php echo $miscCaseInfo->patta_no; ?></strong></h6></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <h3><?php echo $this->lang->line('ast_report');?></h3>
                            <hr/>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <p class='uni_text'><?php echo $ast_report;?></p>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <a href="javascript:history.back()" class="btn btn-sm btn-danger">
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


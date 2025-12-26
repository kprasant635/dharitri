<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('ast_order_sheet_on_misc_cases');?></h2>
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
					<form class="form-horizontal" method='post' action="<?php echo base_url() . "index.php/NameCancellation/ASTOrderSheet1_save"; ?>">                       

                            <input type="hidden" name="misc_case_no" value="<?php echo $misc_case_no; ?>"/>
                            <input type="hidden" name="misc_petition_no" value="<?=$miscCaseInfo->misc_case_petition_no; ?>"/>
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
                                            <td class="text-center"><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $miscCaseInfo->add_to_officer; ?></strong></h6></td>
                                        </tr> 
                                        <tr>
                                            <td class="text-center"><h6><?php echo $this->lang->line('patta_no');?>  : <strong><?php echo $miscCaseInfo->patta_no; ?></strong></h6></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                            <h4>Order and Signature of the Circle Officer</h4>
                            <hr/>
                            
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                   <p class='uni_text'> <?php echo $co_order->process_note;?></p>
                                    <br/><br/><br/>
                                    <p style="text-align: right;">চক্ৰ বিষয়া<br/>
                                    <?php echo $co_order->username;?></p>
                                </div>
                            </div>
                            <h4>Note of Action taken on Order by AST</h4>
                            <hr/>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <textarea name="ast_report" class="form-control" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <button type="submit" name="FormSubmit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button');?></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/NameCancellation/ViewNCorrPetition"; ?>?misc_case_no=<?php echo $_GET['misc_case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_petition');?>
                                    </a>
                                    <br/><br/>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
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


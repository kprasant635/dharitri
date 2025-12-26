<div class="row" style="min-height: 500px;">
        <div class="col-lg-12 center-col">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('thank_you');?>...!!!!</u></span></p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="rasid table">
                                <tr>
                                    <td style="text-align: center;"> <?php echo $datas['table_name']; ?> <?php echo $this->lang->line('data_updated_properly_in');?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 rasid" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                            <a href="<?php echo base_url();?>index.php/initialization/EditCodePlug?LRCTables=<?php echo $datas['table_name']; ?>" class="btn btn-danger">
                                <span class="ass-btn"><?php echo $this->lang->line('back_to_main_menu');?></span></a>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
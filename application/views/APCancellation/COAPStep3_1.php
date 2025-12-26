<div class="container-fluid form-top">
    <div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="well well-sm mis_report">
                <h2 style="text-align: center; "><?php echo $this->lang->line('give_recommendation_for_ap_cancellation');?></h2>
            </div>
        </div>
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">                        
                    </h3>
                </div>
                <div class="panel-body">                   
                    <table class="table table-striped table-bordered" width="100%">                        
                        <tr class="active text-center">
                            <th><?php echo $this->lang->line('sl_no');?></th>
                            <th class="text-center">
                                <?php echo $this->lang->line('case_no');?>
                            </th>
                            <th class="text-center">
                                <?php echo $this->lang->line('submission_date');?>
                            </th>
                            <th class="text-center">
                                <?php echo $this->lang->line('write_report');?>
                            </th>
                        </tr>
                        <?php $row=count($getGiveRecommendationforCO);
                        if($row>0){
                        $c=1;
                        foreach($getGiveRecommendationforCO AS $cases){
                        ?>
                        <tr class="text-center">
                            <td><?php echo $c;?></td>
                            <td><?php echo $cases->case_no;?></td>
                            <td>
                                <?php echo date("d-m-Y", strtotime($cases->submission_date));?>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . "index.php/APCancellation/COAPStep3_2"; ?>?submission_date=<?php echo $cases->submission_date;?>&dist_code=<?php echo $cases->dist_code;?>&subdiv_code=<?php echo $cases->subdiv_code;?>&cir_code=<?php echo $cases->cir_code;?>&mouza_pargona_code=<?php echo $cases->mouza_pargona_code;?>&lot_no=<?php echo $cases->lot_no;?>&vill_townprt_code=<?php echo $cases->vill_townprt_code;?>&year_no=<?php echo $cases->year_no;?>&petition_no=<?php echo $cases->petition_no;?>&case_no=<?php echo $cases->case_no; ?>" class="btn btn-primary"><?php echo $this->lang->line('write_report');?></a>
                            </td>
                        </tr>
                        <?php $c++;}
                        }else{?>
                        <tr class="text-center">
                            <td colspan="4" style="color: red;"><?php echo $this->lang->line('no_fresh_nr_cases_found');?>
                            <br/>
                            </td>
                        </tr>
                        <?php }?>
                    </table>                    
                    <a href="<?php echo base_url();?>index.php/home/index" class="btn btn-sm btn-danger">
                                    <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


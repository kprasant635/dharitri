<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php echo $this->lang->line('co_order_confirm');?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter' id='cases'>
                            <thead>
                                 <tr>
                                    <th class="center"><?php echo $this->lang->line('dag_no');?></th>
                                    <th class="center"><?php echo $this->lang->line('land_area');?></th>
                                    <th class="center"><?php echo $this->lang->line('patta_no');?></th>
                                    <th class="center"><?php echo $this->lang->line('patta_type');?></th>
                                </tr>
                            </thead>
                            <?php foreach ($dag_details as $d):?>
                                <tr>
                                <td class="center"><?php echo $d->dag_no; ?></td>
                                <td class="center"><?php echo $d->dag_area_b . "-" . $d->dag_area_k . "-" . $d->dag_area_lc; ?></td>
                                <td class="center"><?php echo $d->patta_no; ?></td>
                                <td class="center"><?php echo $d->patta_type; ?></td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                       <hr>
                        <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }
                            ?>
                        <hr> 
                        <center>
                            <a href='<?php echo base_url() . "index.php/COFieldMutation/coorder?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code; ?>' class="btn btn-success">
                                <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('pass_order');?>
                            </a>
                            <a href="#" class="hide btn btn-danger"><?php echo $this->lang->line('postpone_order');?></a>
                            <a href="<?php echo base_url(); ?>index.php/home/index/" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
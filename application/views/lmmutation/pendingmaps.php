<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Pending Field Partition Cases For Map Correction
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($this->session->userdata('message')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong><?php
                                    echo $this->session->userdata('message');
                                    $this->session->unset_userdata('message');
                                    ?>
                            </div>
                        <?php endif; ?>
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('case_type'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('order_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                            <th class="center"><label class="control-label">View Map</label></th>
                            </thead>
                            <?php
                            foreach ($cases as $case): ?>
                                <tr>
                                    <td><?php echo $case->case_no; ?></td>
                                    <th class="center"><label class="control-label"><?php echo $this->lang->line('partition'); ?></label></th>
                                    <td class="center"><i class='fa fa-calendar'></i> Order Passed On <?php echo date('d-m-Y',strtotime($case->co_ord_date)); ?></td>
                                    <td class="center">
                                        <?php $str= $case->dist_code."/".$case->subdiv_code."/".
                                                $case->cir_code."/".$case->mouza_pargona_code."/"
                                                . $case->lot_no."/"
                                                . $case->vill_townprt_code."/".$case->case_no."/".$case->dag_no;?>
                                        <!--<a href="<?php echo base_url().'index.php/COFieldMutation/autoupdate/'.$str?>">Update Chitha</a>-->
                                        <a href="<?php echo base_url().'index.php/lmmutation/mapupdate?case_no='.$case->case_no?>" class="btn btn-success">Update Map</a>
                                    </td>
                                    <td class="center">
                                        <?php
                                        //$maplink=MapLink;
                                        $d=$case->dist_code;	
                                        $s=$case->subdiv_code;	
                                        $c=$case->cir_code;	
                                        $m=$case->mouza_pargona_code;	
                                        $l=$case->lot_no;	
                                        $v=$case->vill_townprt_code;	
                                        $dag=$case->dag_no;	
                                        $giscode=$d."_".$s."_".$c."_".$m."_".$l."_".$v."&plotno=".$dag;
                                        if($d=='16' or $d=='06'){
                                        ?>
                                        <div class="btn btn-info uni_text" >
                                            <a target='_blank' href="http://10.177.2.27:8080/bhunaksha/PlotImage?state=18&giscode=<?=$giscode;?>" style="color: #fff" ><i class="fa fa-book"></i>&nbsp;Show Trace Map</a>
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                </tr>
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
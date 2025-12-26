<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            Patta Pending List For CO
        </h4>
    </div>
</div>
<?php if ($this->session->flashdata('message')): ?>
    <div class="col-lg-12 ">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
        </div>
        <?php if($this->session->flashdata('message2')):?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message2');?></strong>
            </div>
        <?php endif;?>
    </div>

<?php endif; ?>
<div class="col-lg-12 ">
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <h3 class="panel-title">
                Pending List
            </h3>
        </div>
        <div class="panel-body">
            <table class='table table-striped' id='cases' width="100%">
                <thead>
                <th><label class="control-label">Case No.</label></th>
                <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                </thead>
                <?php if($patta_basic): ?>
                    <?php foreach ($patta_basic as $case): ?>
                        <tr>
                            <td><b><?php echo $case->case_no; ?></b></td>
                            <td class="center">
                                <?php
                                echo "Mouza : ".$mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                echo "<br>Lot : ".$lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                echo "<br>Village : ".$vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                ?>
                            </td>
                            <td class="center">
                                <i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->created_date)); ?>
                            </td>
                            <td>
                                <a type="button"  href="<?php echo base_url() . "index.php/Patta/pattaCoFinalView?case_no=" . $case->case_no ?>" class='btn-sm btn btn-primary'><i class="fa fa-envelope-open" aria-hidden="true"></i> Pass Order</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <center>
                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                </a>
            </center>
        </div>
    </div>
</div>
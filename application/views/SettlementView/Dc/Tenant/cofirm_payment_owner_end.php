<div class="col-lg-12 ">
    <div class="well well-sm mis_report">
        <h4 style="text-align: center;">
            <?php echo $this->lang->line('1st_proceeding'); ?>
        </h4>
    </div>
    <!-- New Select Field -->
    <!-- //Select Field End -->

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
</div>
<div class="col-lg-10 col-lg-offset-1">
    <div class="panel panel-info panel-form">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $this->lang->line('1st_proceeding'); ?></h3>
        </div>
        <div class="panel-body">
            <?php if ($this->session->userdata('message')) : ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php
                            echo $this->session->userdata('message');
                            $this->session->unset_userdata('message');
                            ?>
                </div>
            <?php endif; ?>
            <?php echo form_open(base_url("index.php/ZoneInformationController/approveZonalInformationCO"), array('method' => 'post')); ?>
            <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable' width="100%">
                <thead>
                    <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                    <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                </thead>
                <tbody>
                    <?php foreach ($getPaymentConfirmationCo as $case) :
                        
                        ?>
                        <tr>
                            <td><a href="#"><?php echo $case['case_no']; ?></a><br>
                            <span class='small font-italic red'><?php if ($case['applid']) {
                                                                            echo "Basundhara:" . $case['applid'];
                                                                        } ?> </span>
                            </td>
                            <td>
                                <?php
                                echo "Mouza : " . $mouza_pargona_code = $this->utilityclass->getMouzaName($case['dist_code'], $case['subdiv_code'], $case['cir_code'], $case['mouza_pargona_code']);
                                echo "<br>Lot : " . $lot_no = $this->utilityclass->getLotName($case['dist_code'], $case['subdiv_code'], $case['cir_code'], $case['mouza_pargona_code'], $case['lot_no']);
                                echo "<br>Village : " . $vill_townprt_code = $this->utilityclass->getVillageName($case['dist_code'], $case['subdiv_code'], $case['cir_code'], $case['mouza_pargona_code'], $case['lot_no'], $case['vill_townprt_code']);
                                ?>
                            </td>
                            <td><?php echo $case['date_entry']; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . 'index.php/SettlementTenantDc/confirmPaymentOwnerDc?case='.$case['case_no']; ?>" class='lmreportmut btn-sm btn btn-success '>
                                    <?php echo $this->lang->line('confirm_payment'); ?>
                                </a>
                     
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-3">
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Data Table Configuration -->
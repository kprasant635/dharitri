<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }
    .buttInfo {
        color: #FFF;
        background-color: #4CAF50;
    }
    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">


        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                <hr>
                <span>Payment Pending Cases</span>
            </div>

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


            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('location'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $i = 0; foreach ($cases as $case) : $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td>
                                    <a href="<?=base_url()?>index.php/SettlementCommonDc/viewApplicationDetailsOnly?case=<?=$case->case_no?>"><?php echo $case->case_no ?></a><br>
                                    <span class='small font-italic red'><?php if ($case->applid) {
                                            echo "Basundhara:" . $case->applid;
                                        } ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    echo "Mouza : " . $mouza_pargona_code = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code);
                                    echo "<br>Lot : " . $lot_no = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no);
                                    echo "<br>Village : " . $vill_townprt_code = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code);
                                    ?>
                                </td>
                                <td>
                                    <?php echo $case->date_entry; ?>
                                </td>
                                <td>
                                    <?php
                                    if($case->pay_notice_gen_yn == 'Y'){ ?>
                                        <a href="<?php echo base_url()?>index.php/SettlementTenantCo/printNotice?case_no=<?=$case->case_no?>" target="GenerateNotice">
                                            <button type="button" name="print_notice" class="btn btn-warning btn-sm">Print Notice</button>
                                        </a>
                                    <?php } ?>

                                    <a href="<?php echo base_url() . 'index.php/SettlementTenantDc/confirmPaymentApplicantDc?case='.$case->case_no; ?>" class='btn btn-primary btn-sm'>
                                        <?php echo $this->lang->line('confirm_payment'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>

            <?php echo form_close(); ?>

        </div>
    </div>
</div>





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
    .buttSuccess {
        color: #FFF;
        background-color: #4CAF50;
    }
    .buttInfo {
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

<div class="row"  style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">


        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                <hr>
                <span>Re-generate Excel</span>
            </div>
            <?php if ($this->session->flashdata('message')) : ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('message'); ?></div>
            <?php endif; ?>

            <div class="reza-body">
                <?php if ($this->session->userdata('message')) : ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><?php
                            // echo $this->session->userdata('message');
                            // $this->session->unset_userdata('message');
                            ?>
                    </div>
                <?php endif; ?>
                <?php echo form_open(base_url("index.php/ZoneInformationController/approveZonalInformationCO"), array('method' => 'post')); ?>

                <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='datatable' width="100%">
                    <thead>
                    <tr>
                        <th>Excel Report No</th>
                        <th class="center">Excel Created at</th>
                        <th class="center"><?php echo $this->lang->line('action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($exl_list)): foreach ($exl_list as $case) : ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url() . 'index.php/SettlementTenantDc/individualCaseConfirmFinalPayment/'.$case->exl_id; ?>"><?php echo $case->exl_id; ?></a>
                            </td>

                            <td class="text-center">
                                <?php echo $case->date_created; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo base_url() . 'index.php/SettlementTenantDc/generateExcel/'.$case->exl_id; ?>" class='lmreportmut rezaButt buttInfo'>
                                    Export Sheet
                                </a>

                                <!-- <a href="<?php echo base_url() . 'index.php/SettlementTenantDc/confirmFinalPayment/'.$case->exl_id; ?>" class='lmreportmut rezaButt buttPrimary '>
                                        Confirm payment
                                    </a> -->

                                <a href="<?php echo base_url() . 'index.php/SettlementTenantDc/individualCaseConfirmFinalPayment/'.$case->exl_id; ?>" class='lmreportmut  rezaButt buttSuccess'>
                                    Proceed
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; endif;?>
                    </tbody>
                </table>

                <?php echo form_close(); ?>

            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
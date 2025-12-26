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
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
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

        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right">
                        <a class="rezaButt buttSuccess" href="<?php echo base_url(); ?>index.php/SettlementTenantDc/downloadAllBeneficiaryWiseDist">
                            <i class="fa fa-download"></i> Download In Excel
                        </a>
                    </div>
                </div>
                <hr>
                <span><?php echo $this->lang->line('beneficiaryList') ?></span>
            </div>

            <div class="reza-body">

                <?php if ($beneficiaryCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th><label class="control-label">Payment Status</label></th>
                            <th class="center"><label class="control-label">Action</label></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($beneficiary as $singleB):  $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td>
                                    <?php echo $singleB->case_no; ?>
                                </td>
                                <td>
                                    <?php if($singleB->payment_status == 1): ?>
                                        <i class="fa fa-check" style="color: #2E7D32"></i> <b style="color: #2E7D32">Paid</b>
                                    <?php else: ?>
                                        <i class="fa fa-spinner fa-spin"></i> <b style="color: #F44336">Pending</b>
                                    <?php endif; ?>

                                </td>

                                <td class="center">
                                    <a class="rezaButt buttInfo" href="<?php echo base_url(); ?>index.php/SettlementTenantDc/getAllBeneficiaryListByCaseNo/?case=<?php echo $singleB->case_no; ?>">
                                        <i class="fa fa-eye"></i> <?php echo $this->lang->line('viewApp'); ?>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>





    </div>
</div>
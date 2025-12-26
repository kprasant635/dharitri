<nav aria-label="breadcrumb">
    <ol class="breadcrumb p-3 text-white">
        <li class="breadcrumb-item font-weight-bold active" aria-current="page">PROPERTY CHAIN</li>
    </ol>
</nav>
<div class="row" style='margin-top:20px'>
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel casedisplay">
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <!-- <tr class="bg-info" style="background: #17a2b8 !important;">
                        <td colspan="3">PROPERTY CHAIN</td>
                    </tr> -->
                    <?php
                    $user_desig = $this->session->userdata('user_desig_code');
                    if ($user_desig == 'CO' || $user_desig == 'ADC' || $user_desig == 'DC') { ?>
                        <tr>
                            <td>Digital Sign Propety Assets</td>
                            <td><a href="<?php echo base_url() . 'index.php/PropChainReport/bulkAddAsset' ?>" class="green" style="float:right">Go</a></td>
                        </tr>
                        <tr>
                            <td>Transactions List</td>
                            <td><a href="<?php echo base_url() . 'index.php/PropChainReport/userChainTransactions' ?>" class="green" style="float:right">view</a></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>Check Asset</td>
                        <td><a href="<?php echo base_url() . 'index.php/PropChainReport/districtDetails' ?>" class="green" style="float:right">Go</a></td>
                    </tr>
                    <?php if ($this->session->userdata('user_desig_code') == 'CO') { ?>
                    <tr>
                        <td>Pending Dag Mapping with bhunaksha</td>
                        <td><a href="<?php echo base_url() . 'index.php/PropChainReport/pendingAssets' ?>" class="green" style="float:right">Go</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
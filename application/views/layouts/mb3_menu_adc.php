

<?php if($this->session->userdata('user_desig_code') == 'ADC' && MB3_LIVE != 0) { ?>

    <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB3</a>

    <div class="dropdown-container">
        <a href="<?php echo base_url(); ?>index.php/SettlementInsADC/SettlementInsLandDc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Juridical Entities</a>
        <a href="<?php echo base_url(); ?>index.php/BhoodanControllerAdc/bhoodanLandAdc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Bhoodan Land</a>
        <a href="<?php echo base_url(); ?>index.php/TeaGrantControllerAdc/teaGrantAdc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tea Grant</a>
        <a href="<?php echo base_url(); ?>index.php/home/ConversionAdcMb"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP to PP Conversion</a>

        <?php if(TENANT_URBAN_ADC == OPEN){ ?>
            <a href="<?php echo base_url(); ?>index.php/SettlementTenantUrbanAdc/SettlementApFirstLandDc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tenant(Urban)</a>
        <?php }  ?>

        <a href="<?php echo base_url(); ?>index.php/ReclassSuiteControllerADC/ReclassSuiteLandDc?service=<?=RECLASS_ID?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Reclassification Suite</a>
        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerReclass/commonProposalListView"><i class="fa fa-fw fa-angle-right"></i>&nbsp;DLC Minute</a>


        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerIns/commonProposalListView"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Minute</a>
        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerIns/pendingProposalList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;<?php echo $this->lang->line('PendingOnlineMeeting') ?></a>
        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerIns/revertMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reverted Meeting</a>
        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerIns/forwardedMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Forwarded Meeting</a>



        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerReclass/revertMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>
            &nbsp;Reverted Meeting <br> <div style="margin-top: -25px!important; margin-left: 40px"> (Reclassification)</div>
        </a>
        <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerReclass/forwardedMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>
            &nbsp;Forwarded Meeting <br> <div style="margin-top: -25px!important; margin-left: 40px"> (Reclassification)</div>
        </a>



        <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getSdlacApprovedMeetingReportPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Report</a>
    </div>


<?php }?>










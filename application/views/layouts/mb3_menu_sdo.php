<?php if($this->session->userdata('user_desig_code') == 'SDO'): ?>
    <?php if(MB3_SDO_LIVE == 1): ?>

        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB3</a>

        <div class="dropdown-container">
            <a href="<?php echo base_url(); ?>index.php/SettlementInsSDO/SettlementInsLandDc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Juridical Entities</a>
            <a href="<?php echo base_url(); ?>index.php/BhoodanControllerSDO/bhoodanLandAdc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Bhoodan Land</a>

            <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerInsSdo/commonProposalListView"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Minute</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerInsSdo/pendingProposalList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;<?php echo $this->lang->line('PendingOnlineMeeting') ?></a>
            <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerInsSdo/revertMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reverted Meeting</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementProposalControllerInsSdo/forwardedMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Forwarded Meeting</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getSdlacApprovedMeetingReportPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Report</a>
        </div>

    <?php endif; ?>
<?php endif; ?>
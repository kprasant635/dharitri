

<?php if($this->session->userdata('user_desig_code') == 'DC' && MB3_LIVE != 0) { ?>

    <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB3</a>

    <div class="dropdown-container">
        <a href="<?php echo base_url(); ?>index.php/TeaGrantControllerDc/teaGrantDc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tea Grant</a>
        <?php
        if(TENANT_URBAN_DC == OPEN){
            ?>
            <a href="<?php echo base_url(); ?>index.php/SettlementTenantUrbanDc/SettlementApFirstLandDc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tenant(Urban)</a>
            <?php
        }
        ?>
        <a href="<?php echo base_url(); ?>index.php/home/ConversionDcMb"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP to PP Conversion (MB3.0)</a>
        <a href="<?php echo base_url(); ?>index.php/ReclassSuiteControllerADC/ReclassSuiteFinalLandDc"><i class="fa fa-fw fa-tasks"></i>&nbsp;Reclassification Suite</a>
        <?php if(MB3_DC_FINAL_PROCESS_LIVE == 1): ?>
            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/meetingLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Pending Meeting</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/meetingApprovedLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Approved Meeting</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/DepartmentApproved"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dept. Approved Cases</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/revertedMeetingByDepartmentForDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dept. Reverted Cases</a>
            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/getAllPendingMeetingForDigitalResigning"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Digital Resigning</a>
            <?php if(PULL_BACK_CASES_FORM_DC_END_PENDING_WITH_DEPT_LIVE_INS == 1):  ?>
                <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/pullBackCasesFromDepartmentForDCIns"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
                    Cases For Pull Back <br> <div style="margin-top: -25px!important; margin-left: 30px"> (Juridical Entities)</div>
                </a>
            <?php endif; ?>
            <?php if(PULL_BACK_CASES_FORM_DC_END_PENDING_WITH_DEPT_LIVE_BHOODAN == 1):  ?>
                <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDcIns/pullBackCasesFromDepartmentForDCBhoodan"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
                    Cases For Pull Back <br> <div style="margin-top: -25px!important; margin-left: 30px"> (Bhoodan Land)</div>
                </a>
            <?php endif; ?>

            <?php if(MINUTES_VIEW_BY_DC_STATUS_INS == 1): ?>
                <a href="<?php echo base_url(); ?>index.php/SettlementMinuteViewDc/meetingApprovedLandPageViewOnly"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Download Minute</a>
            <?php endif; ?>
        <?php endif; ?>




        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/meetingLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
            Pending Meeting<br> <div style="margin-top: -25px!important; margin-left: 30px"> (Reclassification)</div>
        </a>
        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/meetingApprovedLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
            Approved Meeting<br> <div style="margin-top: -25px!important; margin-left: 30px"> (Reclassification)</div>
        </a>
        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/revertedMeetingByDepartmentForDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
            Dept. Reverted Cases<br> <div style="margin-top: -25px!important; margin-left: 30px"> (Reclassification)</div>
        </a>
        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/getAllPendingMeetingForDigitalResigning"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
            Digital Resigning<br> <div style="margin-top: -25px!important; margin-left: 30px"> (Reclassification)</div>
        </a>
        <?php if(PULL_BACK_CASES_FORM_DC_END_PENDING_WITH_DEPT_LIVE == 1):  ?>
            <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/pullBackCasesFromDepartmentForDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
                Cases For Pull Back <br> <div style="margin-top: -25px!important; margin-left: 30px"> (Reclassification)</div>
            </a>
        <?php endif; ?>

        <a href="<?php echo base_url(); ?>index.php/RelassSuiteMeetingControllerDc/meetingApprovedDptLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
            Dept. Aprroved List
        </a>


    </div>


<?php }?>










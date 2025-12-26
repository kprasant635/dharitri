<?php if (CIRCLE_WISE_LAND_CLASS_AND_RATE_CHECK == '1' && $co_block_flag == 'not_updated' && $this->session->userdata('user_desig_code') == 'CO'): ?>
<div class="d-flex " id="wrapper">
    <div class="border-end dontshow" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom" style="color: white; padding: 20px">Dharitree Menu</div>
        <div class="list-group list-group-flush">
            <div class="list-group list-group-flush">
                <div class="sidenav">
                    <a href="<?php echo base_url(); ?>index.php/home/index" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a>
                    <a href="<?php echo base_url('index.php/lcu'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; LandClass/Rate Update</a>
                </div>
            </div>
        </div>
    </div>
<?php elseif (EKHAJANA_CO_PENDING_CONTROL == '1' && $ekhajana_pending_co_cases > 0 && $this->session->userdata('user_desig_code') == 'CO' &&
(! in_array($this->session->userdata('dist_code'), EKHAJANA_EXCLUDE_DISTRICT_FROM_EKHAJANA_PROCESS))): ?>
<div class="d-flex " id="wrapper">
    <div class="border-end dontshow" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom" style="color: white; padding: 20px">Dharitree Menu</div>
        <div class="list-group list-group-flush">
            <div class="list-group list-group-flush">
                <div class="sidenav">
                    <a href="<?php echo base_url(); ?>index.php/home/index" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a>

                    <?php if (EKHAJANA_CO_MENU_ACTIVE == 1): ?>
                        <?php if ($this->session->userdata('user_desig_code') == 'CO'): ?>
                            <button class="dropdown-btn"><i class="fa fa-money"></i>&nbsp;  E-Khajana
                                <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
                            padding-right: 40px;"></i>&nbsp;
                            </button>
                            <div class="dropdown-container">
                                <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/viewCircleWiseCount"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Dashboard</a>
                                <a href="<?php echo base_url(); ?>index.php/EkhajanaDoulController/viewDoulForAllMouza"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Doul</a>
                                <!-- <a href="<?php echo base_url(); ?>index.php/EkhajanaCoArrearUpdateController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Arrear Update</a> -->
                                <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Khajana Approve</a>
                                <?php if (EKHAJANA_AMDANI_REPORT_MENU_ACTIVE == 1): ?>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/amdaniReportForm"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Amdani Report</a>
                                <?php endif?>
                                <?php if (EKHAJANA_CO_ARREAR_RE_UPDATE == 1): ?>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/arrearReUpdateList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Arrear ReUpdate</a>
                                <?php endif?>
                                <?php if (EKHAJANA_CO_REPORT_MENU_ACTIVE == 1): ?>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Reports</a>

                                <?php endif?>

                                <?php if (EKHAJANA_CO_UPDATE_MENU == 1): ?>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/updateEkhajanaCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Cases</a>
                                <?php endif?>
                                <a href="<?php echo base_url(); ?>index.php/EkhajanaChangeRequestController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Change Request</a>
                            </div>
                        <?php endif?>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
    <?php elseif (EKHAJANA_LM_PENDING_CONTROL == '1' && $ekhajana_pending_lm_cases > 0 && $this->session->userdata('user_desig_code') == 'LM'): ?>
    <div class="d-flex " id="wrapper">
        <div class="border-end dontshow" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom" style="color: white; padding: 20px">Dharitree Menu</div>
            <div class="list-group list-group-flush">
                <div class="list-group list-group-flush">
                    <div class="sidenav">
                        <a href="<?php echo base_url(); ?>index.php/home/index" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a>
                        <?php if ($this->session->userdata('user_desig_code') == 'LM'): ?>
                            <a href="<?php echo base_url(); ?>index.php/EkhajanaLmController/index" class="active"><i class="fa fa-money"></i>&nbsp; E-Khajana</a>
                        <?php endif?>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
            <div class="d-flex " id="wrapper">
                <div class="border-end dontshow" id="sidebar-wrapper">
                    <div class="sidebar-heading border-bottom" style="color: white; padding: 20px">Dharitree Menu</div>
                    <div class="list-group list-group-flush">
                        <?php if ($this->session->userdata('user_desig_code') == 'DCN') {?>
                        <div class="list-group list-group-flush">
                            <div class="sidenav">
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a>
                                <a href="<?php echo base_url(); ?>index.php/CPMSController/getPMSForm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;PMS-FORM</a>
                                <button class="dropdown-btn"><i class="fa fa-money"></i>&nbsp;  E-Khajana
                                    <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;padding-right: 40px;"></i>&nbsp;
                                </button>
                                <div class="dropdown-container">
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseReconciliationDashborad"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reconciliation Dashboard</a>
                                    <a href="<?php echo base_url(); ?>index.php/FindCases/findUnavailableCases"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Find Cases</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseCFRBooksData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;CFR Books Details</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/indexDCN"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reports</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="list-group list-group-flush">
                        <div class="sidenav">
                            <a href="<?php echo base_url(); ?>index.php/home/index" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Dashboard</a>
                            <?php
                            if ($this->session->userdata('user_desig_code') == 'LM' or $this->session->userdata('user_desig_code') == 'AST') {
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/basundhara/byserviceList" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara</a>
                                <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCases" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara 2.0</a>
                                <a href="<?php echo base_url(); ?>index.php/rtps/byserviceList" class="active"><i class="fa fa-table"></i>&nbsp; RTPS</a>
                                <?php if (MB3_LIVE == 1) {

                                    if ($this->session->userdata('user_desig_code') == 'LM') {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/basundhara3/settlementCases" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara 3.0</a>
                                        <?php
                                    }
                                }?>
                                <a href="<?php echo base_url(); ?>index.php/LmstateCadreTransfer/applyTransfer" class="active"><i class="fa fa-pen"></i>&nbsp; Appy For Transfer <sup class="red">New</sup></a>
                                <?php
                            }

                            if (NC_LIVE != 0) {
                                if ($this->session->userdata('user_desig_code') == 'LM') {
                                    ?>
                                    <a href="<?php echo base_url(); ?>index.php/NcVillageHomeController/ncCases" class="active"><i class="fa fa-table"></i>&nbsp; NC Village Service</a>
                                    <?php
                                }
                            }

                            if ($this->session->userdata('user_desig_code') == 'SK') {
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/LmstateCadreTransfer/applyTransfer" class="active"><i class="fa fa-edit"></i>&nbsp; Appy For Transfer <sup class="red">New</sup></a>
                                <?php
                            }
                            if ($this->session->userdata('user_desig_code') == 'CO') {
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/basundhara/circlewiseReport" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara</a>
                                <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementOffered" class="active"><i class="fa fa-table"></i>&nbsp; Settlement Offer Given</a>

                                <?php if (ENABLED_BULK_JAMA_UPDATE == 1) {?>
                                    <a href="<?php echo base_url(); ?>index.php/BulkPattaTypeUpdateController/landingPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Bulk Jamabandi Update</a>
                                <?php }?>
                                <button class="dropdown-btn active"><i class="fa fa-fw fa-tasks"></i>&nbsp; Basundhara 3.0 <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
          padding-right: 40px;"></i>&nbsp;
                                </button>

                                <div class="dropdown-container">

                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboardMb3/geotagDashboard"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag Cases</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara3/settlementCasesforCO"><i class="fa fa-fw fa-angle-right"></i>&nbsp;MB3 Cases(Report)</a>
                                </div>
                                <!-- <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountCO" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara 2.0</a> -->
                                <button class="dropdown-btn active"><i class="fa fa-fw fa-tasks"></i>&nbsp; Basundhara 2.0 <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
          padding-right: 40px;"></i>&nbsp;
                                </button>

                                <div class="dropdown-container">
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountCO"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashboard</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountCOPerpetual"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashboard (Perpetual)</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountCOReview"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashboard (MB2.0 Review)</a>
                                    <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getCaseSearchCommon"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Search</a>
                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboard/geotagDashboard"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag Perpetual</a>
                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboard/geotagDashboardReview"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag MB2.0 Review</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/paymentCaseReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Payment Notice Report</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/paymentCaseReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement Offer Given</a>

                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/pppFullWithoutChithaUpdatedAppList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;
                                        &nbsp;<span> PPP Full without </span>
                                        <div style="margin-top: -25px!important;">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; Chitha Update</div>
                                    </a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/pppPartialPaymentAppList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;PPP Partial</a>
                                    <a href="<?php echo base_url(); ?>index.php/DigitalPatta/digitalPattaViewForCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Digital Patta</a>

                                    <?php if (MANUAL_CHALLAN_MENU_ACTIVE == '1'): ?>
                                        <a href="<?php echo base_url(); ?>index.php/ManualChallanController/settlementManualChallanReVerify"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reverify Manual Challan</a>
                                    <?php endif?>
                                </div>

                                <a href="<?php echo base_url(); ?>index.php/rtps/circlewiseReport" class="active"><i class="fa fa-table"></i>&nbsp; RTPS</a>
                                <a href="<?php echo base_url(); ?>index.php/basundhara/pendingApplicationsCircleWise" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara Pending <sup class="red">New</sup></a>
                                <a href="<?php echo base_url(); ?>index.php/basundhara/pendingforApprove" class="active"><i class="fa fa-table"></i>&nbsp; Allow Re-Approve</a>
                                <a href="<?php echo base_url(); ?>index.php/DashboardController/dashAll" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Detail in the Circle</a>

                                <a href="<?php echo base_url(); ?>index.php/DashboardController/applicationTime" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Process time</a>

                                <!-- Added by Abhijit -2024-07-11 -->
                                <?php if (LAND_CLASS_MAP_ENABLE == OPEN): ?>
                                    <a href="<?php echo base_url('index.php/land-class-groups'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Land Class Mapping</a>

                                    <a href="<?php echo base_url('index.php/lcu'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; LandClass/Rate Update</a>

                                <?php endif; ?>

                                <?php if (PATTA_TYPE_MAP_ENABLE == OPEN): ?>
                                    <a href="<?php echo base_url('index.php/patta-type-groups'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Patta Type Mapping</a>
                                <?php endif; ?>

                                <?php if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))) {?>
                                    <a href="<?php echo base_url(); ?>index.php/PropChainReport/propChainMenu" class="active"><i class="fa fa-fw fa-industry"   ></i>&nbsp; Property Chain</a>
                                <?php }?>
                            <?php }?>

                            <!-- E-Khajana Menu Section -->
                            <?php if (EKHAJANA_AST_MENU_ACTIVE == 1 && $this->session->userdata('user_desig_code') == 'AST'): ?>
                                <button class="dropdown-btn"><i class="fa fa-money"></i>&nbsp;  E-Khajana
                                    <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;padding-right: 40px;"></i>&nbsp;
                                </button>
                                <div class="dropdown-container">
                                    <?php if ($this->session->userdata('user_desig_code') == 'AST'): ?>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaAstController/index"><i class="fa fa-dollar"></i>&nbsp; Arrear Update</a>
                                        <?php if (EKHAJANA_AST_PRE_ARREAR_UPDATE == 1): ?>
                                            <a href="<?php echo base_url(); ?>index.php/EkhajanaAstController/pre_arrear_index"><i class="fa fa-rupee"></i>&nbsp; Arrear Pre Update</a>
                                        <?php endif?>
                                    <?php endif?>
                                </div>
                            <?php endif?>

                            <?php if (EKHAJANA_LM_MENU_ACTIVE == 1): ?>
                                <?php if ($this->session->userdata('user_desig_code') == 'LM'): ?>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaLmController/index" class="active"><i class="fa fa-money"></i>&nbsp; E-Khajana</a>
                                <?php endif?>
                            <?php endif?>

                            <?php if (EKHAJANA_CO_MENU_ACTIVE == 1): ?>
                                <?php if ($this->session->userdata('user_desig_code') == 'CO'): ?>
                                    <button class="dropdown-btn"><i class="fa fa-money"></i>&nbsp;  E-Khajana
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
                  padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/viewCircleWiseCount"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Dashboard</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaDoulController/viewDoulForAllMouza"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Doul</a>
                                        <!-- <a href="<?php echo base_url(); ?>index.php/EkhajanaCoArrearUpdateController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Arrear Update</a> -->
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Khajana Approve</a>
                                        <?php if (EKHAJANA_AMDANI_REPORT_MENU_ACTIVE == 1): ?>
                                            <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/amdaniReportForm"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Amdani Report</a>
                                        <?php endif?>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/EcfrMouzadarDashboard"><i class="fa fa-fw fa-angle-right"></i>&nbsp; e-CFR(Mouzadari)</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/arrearReUpdateList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Arrear ReUpdate</a>
                                        <?php if (EKHAJANA_CO_REPORT_MENU_ACTIVE == 1): ?>
                                            <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Reports</a>
                                        <?php endif?>
                                        <?php if (EKHAJANA_CO_UPDATE_MENU == 1): ?>
                                            <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/updateEkhajanaCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Cases</a>
                                        <?php endif?>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaChangeRequestController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Change Request</a>
                                        <?php if (EKHAJANA_CO_UPDATE_DOUL == 1 && ! in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))): ?>
                                            <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/updateDoul"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Doul</a>
                                        <?php endif?>

                                        <?php if (EKHAJANA_CO_VIEW_KHAJANA_RECEIPT == 1): ?>
                                            <a href="<?php echo base_url(); ?>index.php/EkhajanaCoController/getKhajanaReceiptDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Khajana Receipts</a>
                                        <?php endif?>
                                        <?php if (EKHAJANA_MOUZADAR_DOUL_CHECKING == 1): ?>
                                            <a href="<?php echo base_url() . 'index.php/EkhajanaDoulVerify/landing_page' ?>"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Mouzadar Doul Report</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif?>
                            <?php endif?>

                            <?php if (defined('DHARITREE_RCCMS_CO_ACTIVE') && DHARITREE_RCCMS_CO_ACTIVE == 1): ?>
                                <?php if ($this->session->userdata('user_desig_code') == 'CO'): ?>
                                    <button class="dropdown-btn">
                                        <i class="fa fa-money"></i>&nbsp; RCCMS
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url('index.php/Rccms/landing_page'); ?>">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Details
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- **************************************************************** -->
                            <!-- //ekhajana tn branch menu starts -->
                            <?php if (EKHAJANA_TN_MENU_ACTIVE == 1): ?>
                                <?php if ($this->session->userdata('user_desig_code') == 'TN'): ?>
                                    <button class="dropdown-btn"><i class="fa fa-money"></i>&nbsp;  E-Khajana
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="#"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Dashboard</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaTn/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; e-Khajana Applications</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaTn/preArrearIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Pre Arrear Update</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaCFR/tnIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; CFR Update</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseReconciliationDashborad"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reconciliation Dashboard</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseCFRBooksData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;CFR Books Details</a>
                                    </div>
                                <?php endif?>
                            <?php endif?>
                            <!-- //ekhajana tn branch menu ends -->
                            <!-- Ekhajana Adc menu starts -->
                            <?php if ($this->session->userdata('user_desig_code') == 'ADC'): ?>
                                <button class="dropdown-btn"><i class="fa fa-fw fa-rupee"></i>&nbsp; E-Khajana <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;padding-right: 40px;"></i>&nbsp;</button>
                                <div class="dropdown-container">
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaAdc/index"><i class="fa fa-fw fa-check"></i>&nbsp;Approve E-khajana</a>
                                    <?php if (EKHAJANA_ADC_MOUZADAR_VERIFY == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaAdc/verifyMouzadarAccount"><i class="fa fa-fw fa-check"></i>&nbsp;Mouzadar Account Verify</a>
                                    <?php endif?>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaAdc/EcfrMouzadarDashboard"><i class="fa fa-fw fa-check"></i>&nbsp;e-CFR Report</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaAdc/MouzadarDashboard"><i class="fa fa-fw fa-check"></i>&nbsp;Mouzadari Area Report</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaCFR/pendingCfrRecordsForAdc"><i class="fa fa-fw fa-check"></i>&nbsp;CFR Records(Pending)</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaCFR/rejectedCfrRecordsForAdc"><i class="fa fa-fw fa-check"></i>&nbsp;CFR Records(Rejected)</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaCFR/approvedCfrRecordsForAdc"><i class="fa fa-fw fa-check"></i>&nbsp;CFR Records(Approved)</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseReconciliationDashborad"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Re-Conciliation dashboard</a>
                                    <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseCFRBooksData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;CFR Books Details</a>


                                </div>
                            <?php endif?>
                            <!-- Ekhajana Adc menu ends -->
                            <!-- **************************************************************** -->
                            <?php

                            if ($this->session->userdata('user_desig_code') == 'DC' || $this->session->userdata('user_desig_code') == 'ADC') {
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/DashboardController/dashAllDistrict"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Detail in the Circle</a>
                                <a href="<?php echo base_url(); ?>index.php/basundhara/districtWiseReport" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara</a>
                                <button class="dropdown-btn"><i class="fa fa-fw fa-tasks"></i>&nbsp; Basundhara 3.0 <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
          padding-right: 40px;"></i>&nbsp;
                                </button>

                                <div class="dropdown-container">
                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboardMb3/geotagDashboardDistrict"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag Cases</a>

                                </div>
                                <!-- <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountDC" class="active"><i class="fa fa-table"></i>&nbsp; Basundhara 2.0</a> -->
                                <button class="dropdown-btn"><i class="fa fa-fw fa-tasks"></i>&nbsp; Basundhara 2.0 <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
          padding-right: 40px;"></i>&nbsp;
                                </button>

                                <div class="dropdown-container">

                                    <?php
                                    if ($this->session->userdata('user_desig_code') == 'ADC') {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/BasundharaApi/getRtpsData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;New Dashbaord</a>
                                        <a href="<?php echo base_url(); ?>index.php/BasundharaApi/getRtpsDataReview"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashbaord (Review MB2.0)</a>
                                        <a href="<?php echo base_url(); ?>index.php/SettlementCommon/adcDash"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashbaord</a>

                                        <?php

                                    } else if ($this->session->userdata('user_desig_code') == 'DC') {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/BasundharaApi/getRtpsData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;New Dashbaord</a>
                                        <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashbaord</a>

                                        <?php

                                    }

                                    ?>

                                    <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getCaseSearchCommon"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Search</a>
                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboard/geotagDashboardDistrict"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag Perpetual</a>
                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboard/geotagDashboardDistrictReview"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag Review MB 2.0</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/paymentCaseReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Payment Notice Report</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementOffered"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement Offer Given</a>

                                </div>
                            <?php }

                            if ($this->session->userdata('user_desig_code') == 'DCN') {
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/CPMSController/getPMSForm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;PMS-FORM</a>
                            <?php }

                            if ($this->session->userdata('user_desig_code') == 'SDO') {
                                ?>

                                <button class="dropdown-btn"><i class="fa fa-fw fa-tasks"></i>&nbsp; Basundhara 2.0 <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
          padding-right: 40px;"></i>&nbsp;
                                </button>

                                <div class="dropdown-container">
                                    <!-- <a href="<?php echo base_url(); ?>index.php/basundhara2/settlementCasesCountDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Dashbaord</a>
                        <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getCaseSearchCommon"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Search</a> -->
                                    <a href="<?php echo base_url(); ?>index.php/GeotagDashboard/geotagDashboardSubDiv"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Geotag Cases</a>
                                    <a href="<?php echo base_url(); ?>index.php/BasundharaApi/getRtpsData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;New Dashbaord</a>
                                    <a href="<?php echo base_url(); ?>index.php/SettlementCommon/sdoDash"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Dashboard</a>
                                    <a href="<?php echo base_url(); ?>index.php/basundhara2/paymentCaseReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Payment Notice Report</a>

                                </div>
                            <?php }?>

                            <?php if (VACANCY_OF_LR_STAFF_STATUS == 1): ?>
                                <?php if ($this->session->userdata('user_desig_code') == 'ADC'): ?>
                                    <button class="dropdown-btn"><i class="fa fa-fw fa-edit"></i>&nbsp; LR Staff<i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
                            padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url(); ?>index.php/VacancyStaffController/getVacancyOfLrStaffPageLrs"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Supervisor (LRS)</a>
                                        <a href="<?php echo base_url(); ?>index.php/VacancyStaffController/getVacancyOfLrStaffPageLra"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Assistants (LRA)</a>
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>


                            <?php if (in_array($this->session->userdata('user_desig_code'), ['ADC', 'DC'])): ?>
                                <?php if (LAND_CLASS_DELETE_ENABLE == OPEN): ?>
                                    <a href="<?php echo base_url('index.php/land-classes'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Manage Land Classes</a>
                                <?php endif; ?>
                                <?php if (LAND_CLASS_MAP_ENABLE == OPEN): ?>
                                    <a href="<?php echo base_url('index.php/land-class-groups'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Land Class Mapping</a>
                                <?php endif; ?>

                            <?php endif; ?>

                            <?php if (in_array($this->session->userdata('user_desig_code'), ['ADC', 'DC'])): ?>
                                <!-- Added By Abhijit - 2024-07-12 -->
                                <?php if (PATTA_TYPE_MAP_ENABLE == OPEN): ?>
                                    <a href="<?php echo base_url('index.php/patta-type-groups'); ?>" class="active"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Patta Type Mapping</a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- demand satisfy for mouzadar e-khajana -->
                            <?php if (EKHAJANA_DC_DEMAND_SATISFY_MENU_ACTIVE == 1): ?>
                                <?php if ($this->session->userdata('user_desig_code') == 'DC'): ?>
                                    <button class="dropdown-btn"><i class="fa fa-money"></i>&nbsp;  E-Khajana
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
                  padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaDcController/mouzaWiseDemandSatisfiedIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Demand-Satisfy(Info)</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaDcController/EcfrMouzadarDashboard"><i class="fa fa-fw fa-angle-right"></i>&nbsp; e-CFR Report</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaDcController/MouzadarDashboard"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Mouzadari Area Report</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseReconciliationDashborad"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Re-Conciliation dashboard</a>
                                        <a href="<?php echo base_url(); ?>index.php/EkhajanaReportController/MouzaWiseCFRBooksData"><i class="fa fa-fw fa-angle-right"></i>&nbsp;CFR Books Details</a>
                                    </div>
                                <?php endif?>
                            <?php endif?>
                            <!-- demand satisfy for mouzadar e-khajana -->
                            <?php if ($this->session->userdata('user_desig_code') == 'ADC') {?>
                                <a href="<?php echo base_url(); ?>index.php/Basundhara/adcRejectList"><i class="fa fa-fw fa-dashboard"></i>&nbsp; Basundhara Reject List</a>
                            <?php }?>
                            <button class="dropdown-btn"><i class="fa fa-fw fa-tasks"></i>&nbsp; Process <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
                padding-right: 40px;"></i>&nbsp;
                            </button>

                            <div class="dropdown-container">

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'CO') {
                                    if (MB2_LIVE != 0) {

                                        ?>

                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB2</a>
                                        <!-- Newly Added For MB2.0  Services for CO-->
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementTenantCo?service=<?php echo SETTLEMENT_TENANT_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tenant</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementApCo?service=<?php echo SETTLEMENT_AP_TRANSFER_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP Transfer</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementTribalCo?service=<?php echo SETTLEMENT_TRIBAL_COMMUNITY_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tribal Com.</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementKhasLandCo?service=<?php echo SETTLEMENT_KHAS_LAND_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Khas Land</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementVgrCo?service=<?php echo SETTLEMENT_PGR_VGR_LAND_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;VGR PGR</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementSpecialCulCo?service=<?php echo SETTLEMENT_SPECIAL_CULTIVATORS_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Special Cultivators</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementApplicantCo/applicantEditCaseList?service=16"><i class="fa fa-fw fa-file"></i>&nbsp;Applicant Modify Cases</a>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommon/RejectedCasesByHeadView"><i class="fa fa-fw fa-file"></i>&nbsp;Rejected Cases By Remark Head</a>
                                        </div>

                                    <?php }?>


                                    <?php include APPPATH . "views/layouts/mb3_menu_co.php"; ?>


                                    <a href="<?php echo base_url(); ?>index.php/home/CompServiceCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Composite Service</a>


                                    <a href="<?php echo base_url(); ?>index.php/home/MutationCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Field Mutation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/PartitionCoFP"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Field Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/MutationCoOM"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Mutation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/PartitionCoOP"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/LandReCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reclassification</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ApcCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Cancellation</a>



                                    <a href="<?php echo base_url(); ?>index.php/home/MiscCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Miscellaneous Case</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/CitizenCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Certificate Services</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/AcPPCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>

                                    <a href="<?php echo base_url(); ?>index.php/settlement/cofinalpendingcase"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement</a>

                                    <a href=""><i class="fa fa-fw fa-angle-right"></i>&nbsp;Grant to PP</a>

                                    <a href="<?php echo base_url(); ?>index.php/chitha_basic_deo/listAll"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Data Entry View</a>
                                    <a href="<?php echo base_url(); ?>index.php/LandBankCO/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Village Land Bank</a>

                                    <a href="<?php echo base_url(); ?>index.php/Tracemap/TraceMapCoFirst"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Trace Map</a>
                                    <a href="<?php echo base_url(); ?>index.php/Home/khatianCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Khatian</a>
                                    <a href="<?php echo base_url(); ?>index.php/Home/pattaCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Patta</a>
                                    <a href="<?php echo base_url(); ?>index.php/HydrocarbonReclass/landHydrocarbon"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Hydrocarbon Reclassification</a>
                                    <?php if (WRONG_POSSESSION_FROM_DATE_MENU == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/SettlementPossesionFrom/coLanding"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement Poseesion From <sup class="red">New</sup></a>
                                    <?php endif; ?>
                                    <?php
                                    if (BHRMS == OPEN) {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/Bhrms/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;BHRMS</a>
                                        <?php
                                    }?>
                                <?php }?>


                                <?php
                                if ($this->session->userdata('user_desig_code') == 'LM') {
                                    if (MB2_LIVE != 0) {
                                        ?>
                                        <!-- Newly Added For MB2.0  Services for LM-->
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB2</a>
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementTenantLm?service=<?php echo SETTLEMENT_TENANT_ID ?>"><i class="fa fa-fw fa-file"></i>&nbsp;Tenant</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementApLm?service=<?php echo SETTLEMENT_AP_TRANSFER_ID ?>"><i class="fa fa-fw fa-file"></i>&nbsp;AP Transfer</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementTribalLm?service=<?php echo SETTLEMENT_TRIBAL_COMMUNITY_ID ?>"><i class="fa fa-fw fa-file"></i>&nbsp;Tribal Com.</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementKhasLandLm?service=<?php echo SETTLEMENT_KHAS_LAND_ID ?>"><i class="fa fa-fw fa-file"></i>&nbsp;Khas Land</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementVgrPgrLm?service=<?php echo SETTLEMENT_PGR_VGR_LAND_ID ?>"><i class="fa fa-fw fa-file"></i>&nbsp;VGR PGR</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementSpecialCulLm?service=<?php echo SETTLEMENT_SPECIAL_CULTIVATORS_ID ?>"><i class="fa fa-fw fa-file"></i>&nbsp;Special Cultivators</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommon/getVillageListForVillageMeetingApi">
                                                <i class="fa fa-fw fa-file"></i>&nbsp;<?php echo $this->lang->line('villageMeetingSidebar') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementApplicantLm/applicantEditCases?service=16"><i class="fa fa-fw fa-file"></i>&nbsp;Applicant Modify Cases</a>
                                        </div>
                                    <?php }?>
                                    <!-- Newly Added For MB2.0  Services for LM End-->

                                    <?php include APPPATH . "views/layouts/mb3_menu_lm.php"; ?>


                                    <a href="<?php echo base_url(); ?>index.php/home/MutationLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Field Mutation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/MutationLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Field Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/MutationLmOM"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Mutation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/PartitionLmOP"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/LandReLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reclassification</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ApcLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Cancellation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/MiscLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Miscellaneous Case</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/CitizenLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Certificate Services</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/AcPPLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>

                                    <a href="<?php echo base_url(); ?>index.php/Settlement/lmpending"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement</a>

                                    <a href=""><i class="fa fa-fw fa-angle-right"></i>&nbsp;Grant to PP</a>

                                    <a href="<?php echo base_url(); ?>index.php/LandBankLM/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Village Land Bank</a>
                                    <a href="<?php echo base_url(); ?>index.php/Tracemap/TraceMapLmFirst"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Trace Map</a>
                                    <a href="<?php echo base_url(); ?>index.php/Home/khatianLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Khatian</a>
                                    <a href="<?php echo base_url(); ?>index.php/Home/pattaLm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Patta</a>
                                    <?php if (WRONG_POSSESSION_FROM_DATE_MENU == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/SettlementPossesionFrom/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement Poseesion From <sup class="red">New</sup></a>
                                    <?php endif; ?>

                                    <?php
                                    if (TENANT_URBAN != CLOSE) {
                                        ?>

                                    <?php }
                                }?>

                                <?php
                                if (in_array($this->session->userdata('user_desig_code'), ['SK', 'CO'])) {
                                    if (NC_LIVE != 0) {
                                        ?>
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;NC Village Service</a>
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/NcVillageHomeController/NcKhasLandCo?service=<?php echo NC_KHAS_LAND_ID ?>">
                                                <i class="fa fa-fw fa-tasks"></i>
                                                &nbsp;NC Khasland
                                            </a>

                                            <!-- <a href="<?php echo base_url(); ?>index.php/NcVillageHomeController/NcCultivationCo?service=<?php echo NC_CULTIVATOR_ID ?>">
                                                <i class="fa fa-fw fa-tasks"></i>
                                                &nbsp;NC Cultivation
                                            </a> -->
                                        </div>
                                        <?php
                                    }

                                    if (TENANT_URBAN != CLOSE) {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/home/TenantUrbanCoLanding?service=<?php echo SETTLEMENT_TENANT_URBAN_ID ?>"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement Tenant(Urban)</a>
                                        <?php
                                    }
                                }
                                ?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'SK') {

                                    if (MB2_LIVE != 0) {

                                        ?>

                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB2</a>
                                        <!-- Newly Added For MB2.0  Services for CO-->
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementTenantCo?service=<?php echo SETTLEMENT_TENANT_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tenant</a>
                                            <!--<a href="<?php echo base_url(); ?>index.php/home/SettlementApCo?service=<?php echo SETTLEMENT_AP_TRANSFER_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP Transfer</a>-->
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementTribalCo?service=<?php echo SETTLEMENT_TRIBAL_COMMUNITY_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tribal Com.</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementKhasLandCo?service=<?php echo SETTLEMENT_KHAS_LAND_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Khas Land</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementVgrCo?service=<?php echo SETTLEMENT_PGR_VGR_LAND_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;VGR PGR</a>
                                            <a href="<?php echo base_url(); ?>index.php/home/SettlementSpecialCulCo?service=<?php echo SETTLEMENT_SPECIAL_CULTIVATORS_ID ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Special Cultivators</a>
                                        </div>

                                    <?php }?>

                                    <?php if (ENABLED_MB3 == 1): ?>
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;MB3</a>
                                        <!-- Newly Added For MB2.0  Services for CO-->
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url("index.php/mb3_conversion_sk"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Conversion</a>
                                        </div>
                                    <?php endif?>

                                    <a href="<?php echo base_url(); ?>index.php/home/MutationSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Field Mutation</a>
                                    <a href="<?php echo base_url(); ?>index.php/home/MutationSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Field Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/PartitionSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Mutation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/PartitionSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ApcSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Cancellation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/Miscsk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Miscellaneous Case</a>

                                    <!-- <a href="<?php echo base_url(); ?>index.php/home/CitizenSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Certificate Services</a>
 -->
                                    <a href="<?php echo base_url(); ?>index.php/home/AcPPSk"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>
                                    <a href="<?php echo base_url(); ?>index.php/Settlement/skfirst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SP to PP</a>
                                    <a href=""><i class="fa fa-fw fa-angle-right"></i>&nbsp;Grant to PP</a>
                                    <a href="<?php echo base_url(); ?>index.php/Tracemap/TraceMapSkFirst"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Trace Map</a>


                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'AST') {
                                    ?>
                                    <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB2</a>
                                    <!-- Newly Added For MB2.0  Services for AST-->
                                    <div class="dropdown-container">

                                        <a href="<?php echo base_url(); ?>index.php/home/SettlementApAst?service=13&s=V"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tenant</a>
                                        <a href="<?php echo base_url(); ?>index.php/home/SettlementApAst?service=14&s=V"><i class="fa fa-fw fa-tasks"></i>&nbsp;AP Transfer</a>
                                        <a href="<?php echo base_url(); ?>index.php/home/SettlementApAst?service=15&s=V"><i class="fa fa-fw fa-tasks"></i>&nbsp;Tribal Community</a>
                                        <a href="<?php echo base_url(); ?>index.php/home/SettlementApAst?service=16&s=V"><i class="fa fa-fw fa-tasks"></i>&nbsp;Khas Land</a>
                                        <a href="<?php echo base_url(); ?>index.php/home/SettlementApAst?service=17&s=V"><i class="fa fa-fw fa-tasks"></i>&nbsp;PGR VGR</a>
                                        <a href="<?php echo base_url(); ?>index.php/home/SettlementApAst?service=18&s=V"><i class="fa fa-fw fa-tasks"></i>&nbsp;Cultivation</a>
                                        <a href="<?php echo base_url(); ?>index.php/DigitalPatta/digitalPattaViewForCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Digital Patta</a>

                                    </div>

                                    <?php if (ENABLED_MB3 == 1): ?>
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;MB3</a>
                                        <!-- Newly Added For MB2.0  Services for CO-->
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url("index.php/mb3_conversion_ast"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Conversion</a>
                                            <a href="<?php echo base_url("index.php/Home/Mb3JuridicalAst"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Juridical Entities</a>
                                        </div>
                                    <?php endif?>

                                    <a href="<?php echo base_url(); ?>index.php/home/CompServiceAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Composite Service</a>
                                    <a href="<?php echo base_url(); ?>index.php/home/MutationAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Mutation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/PartitionAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Office Partition</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ApcAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Cancellation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/MiscAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Miscellaneous Case</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/CitizenAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Certificate Services</a>
                                    <?php
                                    if ((RTPS_CERT_ON_OFF != '1') || (($this->session->userdata('dist_code') == '15') && ($this->session->userdata('subdiv_code') == '01') && ($this->session->userdata('cir_code') == '03'))) {?>
                                        <a href="<?php echo base_url(); ?>index.php/Allotment/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>
                                    <?php }?>
                                    <a href="<?php echo base_url(); ?>index.php/Settlement/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement</a>
                                    <a href=""><i class="fa fa-fw fa-angle-right"></i>&nbsp;Grant to PP</a>
                                    <a href="<?php echo base_url(); ?>index.php/Tracemap/traceAst"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Trace Map</a>

                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'DC') {?>

                                    <?php if (NC_DC_LIVE == 1): ?>
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>
                                            &nbsp;<?php echo $this->lang->line('ncSidebar') ?>
                                        </a>
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/NcMeetingDc/pendingMeetingList"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('ncPendingMeeting') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcMeetingDc/approvedMeetingList"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('ncApproveMeeting') ?>
                                            </a>
                                            <?php if (NC_MODIFICATION_REQUEST_SERVICE_LIVE == 1): ?>
                                                <a href="<?php echo base_url(); ?>index.php/NcModification/getAllModificationRequestApplicationByCoForDc">
                                                    <i class="fa fa-file-text-o"></i>&nbsp;NC Modification Request
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?php echo base_url(); ?>index.php/NcMeetingDc/revertedMeetingByDepartmentForDC">
                                                <i class="fa fa-file-text-o"></i>&nbsp;Dept. Reverted Cases
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcMeetingDc/getAllPendingMeetingForDigitalResigning">
                                                <i class="fa fa-file-text-o"></i>&nbsp;NC Digital Resigning
                                            </a>
                                            <?php if (NC_DIGITAL_PATTA_MENU_LIVE == 1): ?>
                                                <a href="<?php echo base_url(); ?>index.php/DigitalPattaNC/digitalPattaLandingPage">
                                                    <i class="fa fa-file-text-o"></i>&nbsp; Issue Property Card
                                                </a>
                                                <a href="<?php echo base_url(); ?>index.php/DigitalPattaNC/digitalPattaView">
                                                    <i class="fa fa-file-text-o"></i>&nbsp; View Property Card
                                                </a>
                                            <?php endif; ?>

                                        </div>
                                    <?php endif; ?>

                                    <?php if (MB2_LIVE != 0) {
                                        ?>
                                        <!-- Newly Added For MB2.0  Services for DC-->

                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB</a>
                                        <div class="dropdown-container">

                                            <?php
                                            if (EVICTION_NOTICE_OPEN == OPEN) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/SettlementEvictionController/evictionNoticeMenu"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Eviction Notice</a>
                                                <?php
                                            }
                                            ?>


                                            <a href="<?php echo base_url(); ?>index.php/SettlementApDc/SettlementApFirstLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Transfer</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementTenantDc/SettlementApFirstLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tenant</a>
                                            <?php if (VGR_VILLAGE_WISE_NOTICE == OPEN) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>index.php/SettlementVgrPgrDc/villageWiseList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;VGR/PGR notice of grazing ground</a>
                                            <?php }?>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/rejectedListDcLandingPage">
                                                <i class="fa fa-fw fa-angle-right"></i>&nbsp;Rejected By DC
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/revivalListDcLandingPage">
                                                <i class="fa fa-fw fa-angle-right"></i>&nbsp; Revival Flagged Cases
                                            </a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementModification/getAllModificationRequestApplicationByCoForDc">
                                                <i class="fa fa-fw fa-angle-right"></i>&nbsp;Modification Request
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDc/revertedMeetingByDepartmentForDC">
                                                <i class="fa fa-fw fa-angle-right"></i>&nbsp;Dept. Reverted Cases
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDc/getAllVgrPgrRevertedCaseByDept">
                                                <i class="fa fa-fw fa-angle-right"></i>
                                                &nbsp;<span>Dept. Reverted </span>
                                                <div style="margin-top: -25px!important;">&nbsp; &nbsp; &nbsp;&nbsp; VGR-PGR Cases</div>
                                            </a>

                                            <?php if (MB2_DC_FINAL_PROCESS_LIVE == 1): ?>
                                                <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDc/meetingLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Pending Meeting</a>

                                                <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDc/meetingApprovedLandPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Approved Meeting</a>
                                                <?php if (MINUTES_VIEW_BY_DC_STATUS == 1): ?>
                                                    <a href="<?php echo base_url(); ?>index.php/SettlementMinuteViewDc/meetingApprovedLandPageViewOnly"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Download Minute</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementMeetingControllerDc/getAllPendingMeetingForDigitalResigning">
                                                <i class="fa fa-fw fa-angle-right"></i>&nbsp;Digital Resigning
                                            </a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getSdlacApprovedMeetingReportPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Report</a>
                                            <!--
                                <a href="<?php //echo base_url(); ?>index.php/SettlementTribalDc/SettlementTribalLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tribal Com.</a>
                                <a href="<?php //echo base_url(); ?>index.php/SettlementMbDc/SettlementKhasLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Khas Land</a>
                                <a href="<?php //echo base_url(); ?>index.php/SettlementVgrPgrDc/SettlementVgrPgrLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;VGR PGR</a>
                                <a href="<?php //echo base_url(); ?>index.php/SettlementTeaDc/SettlementTeaLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Cultivation</a> -->
                                            <?php if (DIGITAL_PATTA_MENU == 1): ?>
                                                <a href="<?php echo base_url(); ?>index.php/DigitalPatta/digitalPattaLandingPage">
                                                    <i class="fa fa-fw fa-angle-right"></i>&nbsp; Digital Patta
                                                </a>
                                                <a href="<?php echo base_url(); ?>index.php/DigitalPatta/digitalPattaView">
                                                    <i class="fa fa-fw fa-angle-right"></i>&nbsp; View Digital Patta
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php }?>
                                    <!-- Newly Added For MB2.0  Services for DC End-->

                                    <?php include APPPATH . "views/layouts/mb3_menu_dc.php"; ?>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ApcDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Cancellation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reclassification</a>
                                    <a href="<?php echo base_url(); ?>index.php/home/AcPPDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>
                                    <!-- //new added task for DC end for approval 09122022--------- -->
                                    <a href="<?php echo base_url(); ?>index.php/LandBankDC/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Village Land Bank</a>

                                    <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;DOUL</a>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url(); ?>index.php/GenerateDoul/viewDoulInDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Indirect Paying Doul</a>
                                        <a href="<?php echo base_url(); ?>index.php/GenerateDoul/viewDpDoulInDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Direct Paying Doul</a>
                                    </div>
                                    <!-- end--------- -->
                                    <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;LAC Mapping</a>
                                    <!-- Newly Added For MB2.0  Services for CO-->
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url("index.php/LACApprovalController"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Approve</a>
                                    </div>


                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'ADC') {
                                    if (MB2_LIVE != 0) {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/cabinetController/cabinetForm"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Minister Visit Details</a>

                                        <!-- Newly Added For MB2.0  Services for DC-->
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB</a>
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/SettlementTenantAdc/SettlementApFirstLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tenant</a>
                                            <a href="<?php echo base_url(); ?>index.php/SettlementApADC/SettlementApLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Transfer</a>
                                            <!--  <a href="--><?php //echo base_url(); ?><!--index.php/SettlementTribalDc/SettlementTribalLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tribal Com.</a>-->
                                            <a href="<?php echo base_url(); ?>index.php/SettlementMbADC/SettlementKhasLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Khas Land</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementVgrPgrADC/SettlementVgrPgrLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;VGR PGR</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementTeaAdc/SettlementTeaLandAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Cultivation</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementTribalAdc/SettlementTribalLandAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tribal Community</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalController/commonProposalListView"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Minute</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalController/pendingProposalList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;<?php echo $this->lang->line('PendingOnlineMeeting') ?></a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalController/revertMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reverted Meeting</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalController/forwardedMeetingListForAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Forwarded Meeting</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getSdlacApprovedMeetingReportPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Report</a>


                                        </div>
                                    <?php }?>

                                    <?php include APPPATH . "views/layouts/mb3_menu_adc.php"; ?>


                                    <?php if (NC_SDO_ADC_LIVE == 1): ?>
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>
                                            &nbsp;<?php echo $this->lang->line('ncSidebar') ?>
                                        </a>
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/NcKhasLandAdc/NcKhasLandLandingPageAdc"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('ncKhasLink') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcCommonProposalAdc/commonProposalListViewAdc"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('ncSdlacMinutes') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcCommonProposalAdc/forwardedMeetingListForAdc"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('forwardedMeeting') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcCommonProposalAdc/revertMeetingListForAdc"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('revertedMeeting') ?>
                                            </a>


                                        </div>
                                    <?php endif; ?>


                                    <!-- Newly Added For MB2.0  Services for DC End-->

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ApcAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Cancellation</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reclassification</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/AlotAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>
                                    <?php if (ESCALATION_ENABLE == 1) {?>
                                        <a href="<?php echo base_url(); ?>index.php/home/NameCorrectionAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Name Correction</a>
                                    <?php }?>
                                    <?php if (CPMS_ADC_ACTIVE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/CPMSAdcController/getCPMSDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp;CPMS</a>
                                    <?php endif?>
                                    <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;LAC Mapping</a>
                                    <!-- Newly Added For MB2.0  Services for CO-->
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url("index.php/LACControler"); ?>"><i class="fa fa-fw fa-tasks"></i>&nbsp;Map</a>
                                    </div>



                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'SDO') {
                                    if (MB2_LIVE != 0) {
                                        ?>
                                        <!-- Newly Added For MB2.0  Services for DC-->
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Settlement MB</a>
                                        <div class="dropdown-container">
                                            <!--   <a href="--><?php //echo base_url(); ?><!--index.php/SettlementTenantDc/SettlementApFirstLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tenant</a>-->
                                            <a href="<?php echo base_url(); ?>index.php/SettlementApSdo/SettlementApLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AP Transfer</a>
                                            <!--  <a href="--><?php //echo base_url(); ?><!--index.php/SettlementTribalDc/SettlementTribalLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tribal Com.</a>-->
                                            <a href="<?php echo base_url(); ?>index.php/SettlementMbSdo/SettlementKhasLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Khas Land</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementTribalSdo/SettlementTribalLandSdo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Tribal Community</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementTeaSdo/SettlementTeaLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Cultivation</a>

                                            <a href="<?php echo base_url() ?>index.php/SettlementVgrPgrSdo/SettlementVgrPgrLandSdo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;PGR VGR</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalSdoController/commonProposalListView"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Minute</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalSdoController/pendingProposalList"><i class="fa fa-fw fa-angle-right"></i>&nbsp;<?php echo $this->lang->line('PendingOnlineMeeting') ?></a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalSdoController/revertMeetingListForSdo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Reverted Meeting</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementProposalSdoController/forwardedMeetingListForSdo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Forwarded Meeting</a>

                                            <a href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getSdlacApprovedMeetingReportPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;SDLAC/CDLAC Report</a>


                                            <!--  <a href="--><?php //echo base_url(); ?><!--index.php/SettlementTeaDc/SettlementTeaLandDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Cultivation</a>-->

                                        </div>
                                    <?php }?>
                                    <?php include APPPATH . "views/layouts/mb3_menu_sdo.php"; ?>


                                    <?php if (NC_SDO_ADC_LIVE == 1): ?>
                                        <a class="dropdown-btn"><i class="fa fa-fw fa-angle-right"></i>
                                            &nbsp;<?php echo $this->lang->line('ncSidebar') ?>
                                        </a>
                                        <div class="dropdown-container">
                                            <a href="<?php echo base_url(); ?>index.php/NcKhasLandSdo/NcKhasLandLandingPageSdo"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('ncKhasLink') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcCommonProposalSdo/commonProposalListViewSdo"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('ncSdlacMinutes') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcCommonProposalSdo/forwardedMeetingListForSdo"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('forwardedMeeting') ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>index.php/NcCommonProposalSdo/revertMeetingListForSdo"><i class="fa fa-file-text-o"></i>
                                                &nbsp;<?php echo $this->lang->line('revertedMeeting') ?>
                                            </a>


                                        </div>
                                    <?php endif; ?>


                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'BO') {
                                    ?>

                                    <a href="<?php echo base_url(); ?>index.php/home/ConversionBo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Conversion</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/AcPPBo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;AC to PP</a>

                                    <a href="<?php echo base_url(); ?>index.php/home/AppealBo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Appeal Case U/S 147</a>


                                <?php }?>




                            </div>

                            <?php if (OFFLINE_SETTLEMENT_LIVE == 1): ?>
                                <?php if (in_array($this->session->userdata('user_desig_code'), OFFLINE_SETTLEMENT_ACCESS)): ?>
                                    <button class="dropdown-btn"><i class="fa fa-fw fa-book"></i>&nbsp;
                                        <?php echo $this->lang->line('offlineSettlementSidebar') ?>
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url(); ?>index.php/OfflineSettlementCommonController/firstLandingPageCommonKhas">
                                            <i class="fa fa-file-o"></i>
                                            &nbsp;  Khas Land
                                        </a>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (RELINQUISHMENT_LIVE == 1): ?>
                                <?php if (in_array($this->session->userdata('user_desig_code'), RELINQUISHMENT_ACCESS)): ?>
                                    <button class="dropdown-btn"><i class="fa fa-fw fa-book"></i>&nbsp;
                                        <?php echo $this->lang->line('relinquishmentSidebar') ?>
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;padding-right: 40px;"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a href="<?php echo base_url(); ?>index.php/RelinquishmentCommonController/firstLandingPageCommonRelinquishment">
                                            <i class="fa fa-file-o"></i>
                                            &nbsp; Process
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <button class="dropdown-btn"><i class="fa fa-fw fa-wrench"></i>&nbsp; Utility <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
    padding-right: 40px;"></i>&nbsp;
                            </button>

                            <div class="dropdown-container">
                                <?php
                                if ($this->session->userdata('user_desig_code') == 'CO') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>
                                    <a href="<?php echo base_url() ?>index.php/ZoneInformationController/zonalInformationDetails_dc_co"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Zonal(Dag)</a>
                                    <a href="<?php echo base_url() ?>index.php/ZoneInformationController/zonalinformationDetails_villagewise_dc_co"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Zonal(Village)</a>
                                    <a href="<?php echo base_url() ?>index.php/LandShareUpdation/landShareDetails_dc_co"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Land Share</a>
                                    <a href="<?php echo base_url(); ?>index.php/Maintenance/JamabandiStatus"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Status</a>

                                    <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Legacy Data Updation</a>
                                    <a href="<?php echo base_url() ?>index.php/AddLocationController/viewVillageForm"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Add Location <sup class="red">New</sup></a>

                                    <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities"><i class="fa fa-fw fa-angle-right"></i>&nbsp; BackLog Entry</a>

                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Search</a>
                                    <a href="<?php echo base_url(); ?>index.php/FindCases/findUnavailableCases"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Find Cases</a>

                                    <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Revenue</a>

                                    <a href="<?php echo base_url(); ?>index.php/casetransfer"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Transfer</a>
                                    <a href="<?php echo base_url(); ?>index.php/casetransfer/getCaseTransferPage"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Transfer (MB 2.0)   </a>

                                    <a href="<?php echo base_url() ?>index.php/UtilityController/urbanRuralLocation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Rural Urban Updation</a>
                                    <a href="<?php echo base_url() ?>index.php/LegacyDataUpdation/searchFile"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Report Against Case No</a>
                                    <a href="<?php echo base_url() ?>index.php/RequestForChange/requestForChangeUI"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Data Updation</a>

                                    <?php if (DAG_DELETE_ENABLE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/DagDeletionController/FlagIndexCommon">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Dag Deletion
                                        </a>
                                    <?php endif; ?>

                                    <?php if (MAPPING_INDUSTRIAL_CORRIDOR_ENABLE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/MapIndustrialCorridorController/firstLandingPageMappingInCorridor">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Map Industrial Corridor
                                        </a>
                                    <?php endif; ?>


                                    <!-- <a href="<?php echo base_url(); ?>index.php/Chitha_basic_deo/listAll"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Data Entry View</a> -->

                                    <!-- <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a> -->

                                    <!-- <a href="<?php echo base_url() ?>index.php/Dagflag/MappingIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Mapping Dag with area</a> -->

                                    <?php if (DAG_FLAG_ENABLED == 1): ?>
                                        <a href="<?php echo base_url() ?>index.php/Dagflag/MappingIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Dag Flagging</a>
                                    <?php endif?>


                                    <?php if (CHITHA_DAG_FLAG_ENABLED == 1): ?>
                                        <a href="<?php echo base_url() ?>index.php/ChithaFlag/FlagIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Dag Mapping <sup class="red">New</sup></a>
                                    <?php endif?>


                                    <?php if (LANDCLASS_ALLOWED_IN_DAG == 1): ?>
                                        <a href="<?php echo base_url() ?>index.php/LandClassPermissionController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp;<?php echo $this->lang->line('land-class-allowed-in-dag') ?> <sup class="red">New</sup></a>
                                    <?php endif?>


                                <?php }?>


                                <?php
                                if ($this->session->userdata('user_desig_code') == 'LM') {
                                    ?>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>
                                    <a href="<?php echo base_url() ?>index.php/ZoneInformationController/zonalInformationDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update ZonalInformation</a>
                                    <a href="<?php echo base_url() ?>index.php/ZoneInformationController/zonalinformationDetails_villagewise"><i class="fa fa-fw fa-angle-right"></i>&nbsp; VILLAGE ZONAL ENTRY</a>

                                    <a href="<?php echo base_url() ?>index.php/ZoneInformationController/zonalValueReportLM"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Zonal Value Report</a>

                                    <a href="<?php echo base_url() ?>index.php/LandShareUpdation/LandShareDagSelect"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Land Share Updation</a>
                                    <!-- <a href="<?php echo base_url(); ?>index.php/Maintenance/JamabandiStatus"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Status</a> -->

                                    <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Legacy Data Updation</a>

                                    <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities"><i class="fa fa-fw fa-angle-right"></i>&nbsp; BackLog Entry</a>
                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Search</a>
                                    <a href="<?php echo base_url() ?>index.php/Maintenance/modifyserial"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Pattadar Serial Updation</a>

                                    <?php if (DAG_DELETE_ENABLE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/DagDeletionController/FlagIndexLM">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Dag Deletion
                                        </a>
                                    <?php endif; ?>

                                    <?php if (ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'), json_decode(ENABLED_BLOCKCHAIN_FOR_DIST))): ?>
                                        <a href="<?php echo base_url(); ?>index.php/PropChainReport/pendingAssets"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Pending Map Generation</a>
                                    <?php endif?>


                                    <!-- <a href="<?php echo base_url(); ?>index.php/casetransfer"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Transfer</a>
                        <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Revenue</a>
                        <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>
                        <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a> -->

                                    <!-- <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Revenue</a>
                        <a href="<?php echo base_url() ?>index.php/UtilityController/urbanRuralLocation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Rural Urban Updation</a> -->
                                    <a href="<?php echo base_url() ?>index.php/LmEntryChitha/menulm"><i class="fa fa-fw fa-angle-right"></i>&nbsp; LM Entry(Chitha)</a>

                                    <!-- <a href="<?php echo base_url() ?>index.php/Dagflag/MappingIndexLM"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Mapping Dag with area</a> -->

                                    <?php if (DAG_FLAG_ENABLED == 1): ?>
                                        <a href="<?php echo base_url() ?>index.php/Dagflag/MappingIndexLM"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Dag Flagging</a>
                                    <?php endif?>



                                    <?php if (CHITHA_DAG_FLAG_ENABLED == 1): ?>
                                        <a href="<?php echo base_url() ?>index.php/ChithaFlag/FlagIndexLM"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Dag Mapping <sup class="red">New</sup></a>
                                    <?php endif?>


                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'SK') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>

                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Search</a>


                                    <!-- <a href="<?php echo base_url() ?>index.php/Maintenance/JamabandiStatus"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Status</a>
                        <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Legacy Updation</a>
                        <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities"><i class="fa fa-fw fa-angle-right"></i>&nbsp; BackLog Entry</a>
                        <a href="<?php echo base_url() ?>index.php/Maintenance/modifyserial"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Pattadar Serial Updation</a> -->
                                    <!-- <a href="<?php echo base_url(); ?>index.php/casetransfer"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Transfer</a>
                        <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Revenue</a>
                        <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>
                        <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a> -->



                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'AST') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>
                                    <a href="<?php echo base_url() ?>index.php/UtilityControlleri/urbanRuralLocation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Status</a>
                                    <!-- <a href="<?php echo base_url(); ?>index.php/utility/backentry_utilities"><i class="fa hide fa-fw fa-angle-right"></i>&nbsp; BackLog Entry</a> -->

                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Cas Search</a>
                                    <a href="<?php echo base_url(); ?>index.php/FindCases/findUnavailableCases"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Find Cases</a>
                                    <a href="<?php echo base_url() ?>index.php/UtilityController/urbanRuralLocation"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Rural Urban Updation</a>

                                    <!-- <a href="<?php echo base_url(); ?>index.php/casetransfer"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Transfer</a>
                        <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocations"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update Revenue</a> -->
                                    <!-- <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>
                        <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a> -->



                                <?php }?>


                                <?php
                                if ($this->session->userdata('user_desig_code') == 'DC') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>

                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Search</a>
                                    <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Legacy Data Updation</a>
                                    <!-- Newly Added -->
                                    <a href="<?php echo base_url() ?>index.php/ZonalByforcationController/zonalDagCircleWiseDc"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Zonal Value Status</a>

                                    <a href="<?php echo base_url() ?>index.php/ZonalByforcationController/dagwiseEntryMissingReportDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Pending Dagwise Entry Report</a>


                                    <a href="<?php echo base_url() ?>index.php/ZoneInformationController/zonalinformationDetailsDC"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Zonal Value Certification Report</a>

                                    <?php if (DAG_DELETE_ENABLE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/DagDeletionController/FlagIndexCommon">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Dag Deletion
                                        </a>
                                    <?php endif; ?>

                                    <?php if (MAPPING_INDUSTRIAL_CORRIDOR_ENABLE == OPEN): ?>
                                        <a href="<?php echo base_url(); ?>index.php/MapIndustrialCorridorController/firstLandingPageMappingInCorridor">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Map Industrial Corridor
                                        </a>
                                    <?php endif; ?>


                                <?php }?>



                                <?php
                                if ($this->session->userdata('user_desig_code') == 'ADC') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>

                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Search</a>
                                    <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Legacy Data Updation</a>

                                    <a href="<?php echo base_url(); ?>index.php/ZoneInformationController/zonalinformationDetailsADC"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Update Zonal Value</a>
                                    <!--<a href="<?php echo base_url(); ?>index.php/CaseTransferAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Transfer</a>-->

                                    <a href="<?php echo base_url(); ?>index.php/CaseTransferLduAdc"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Transfer LDU</a>
                                    <a href="<?php echo base_url(); ?>index.php/ADCCaseTransfer"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Transfer ADC</a>

                                    <?php if (DAG_DELETE_ENABLE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/DagDeletionController/FlagIndexCommon">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Dag Deletion
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                    if (CASE_TRANSFER_CO == OPEN && $this->session->userdata('dist_code') == '24') {
                                        ?>
                                        <a href="<?php echo base_url(); ?>index.php/CaseTransferCo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Transfer CO</a>
                                        <?php
                                    }
                                    ?>

                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'SDO') {
                                    ?>
                                    <?php if (DAG_DELETE_ENABLE == 1): ?>
                                        <a href="<?php echo base_url(); ?>index.php/DagDeletionController/FlagIndexCommon">
                                            <i class="fa fa-fw fa-angle-right"></i>&nbsp;Dag Deletion
                                        </a>
                                    <?php endif; ?>

                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'BO') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chithareport/jamadistrictDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Update jamabandi</a>

                                    <a href="<?php echo base_url(); ?>index.php/CaseSearch"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Case Search</a>



                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'DEO') {
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/chitha_basic_deo"><i class="fa fa-fw fa-angle-right"></i>&nbsp; New dag entry</a>



                                <?php }?>






                            </div>
                            <button class="dropdown-btn"><i class="fa fa-fw fa-bar-chart"></i>&nbsp; Reports <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;"></i>&nbsp;
                            </button>
                            <div class="dropdown-container">
                                <?php
                                if ($this->session->userdata('user_desig_code') == 'CO') {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <?php if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))): ?>
                                        <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetailsBarak"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports (BARAK)</a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>
                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/GenerateDoul/CircleWiseDoulGenerate"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Generate Doul</a>


                                    <a href="<?php echo base_url(); ?>index.php/Khatian"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>

                                    <a href="<?php echo base_url(); ?>index.php/LandBankReport/circleVillageReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; VLB Report</a>
                                    <a href="<?php echo base_url(); ?>index.php/misreport/lmStateCadre"><i class="fa fa-fw fa-angle-right"></i>&nbsp; LM State-Cadre</a>
                                    <a href="<?php echo base_url(); ?>index.php/disposed-cases/get"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Disposed Cases</a>
                                <?php }?>
                                <a href="<?php echo base_url(); ?>index.php/rejected-data"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Rejected Cases Data</a>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'LM') {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>
                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/Khatian"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>


                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'SK') {
                                    ?>

                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>
                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/Khatian"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>


                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'AST') {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>
                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/Khatian"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>


                                <?php }?>
                                <?php
                                if ($this->session->userdata('user_desig_code') == 'DC') {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>
                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/katian/adcreportView"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>
                                    <a href="<?php echo base_url(); ?>index.php/LandBankReport/vlbMenu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; VLB Report</a>
                                    <a href="<?php echo base_url(); ?>index.php/NocCompositeReportController/registered"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Noc Composite Report</a>

                                <?php }?>

                                <?php
                                if (($this->session->userdata('user_desig_code') == 'BO') or ($this->session->userdata('user_desig_code') == 'DIO') or ($this->session->userdata('user_desig_code') == 'ADM')) {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>

                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/Home/adcreportView"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>


                                <?php }?>


                                <?php
                                if ($this->session->userdata('user_desig_code') == 'ADC' || $this->session->userdata('user_desig_code') == 'SDO') {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_dc_lao_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>

                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/MisReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; MIS Reports</a>

                                    <a href="<?php echo base_url(); ?>index.php/CentralDiary"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Central Diary</a>

                                    <a href="<?php echo base_url(); ?>index.php/MisReportController/DeedViewList"><i class="fa fa-fw fa-angle-right"></i>&nbsp; All Deed view list</a>

                                    <a href="<?php echo base_url(); ?>index.php/coofficemutation/ActionTakenReport"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Proceeding Report</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/view_location_codes"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Location Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Master Code</a>

                                    <a href="<?php echo base_url(); ?>index.php/Khatian/adcreportView"><i class="fa fa-fw fa-angle-right"></i>&nbsp; View Khatian</a>
                                    <a href="<?php echo base_url(); ?>index.php/LandBankReport/vlbMenu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; VLB Report</a>

                                <?php }?>


                                <?php
                                if ($this->session->userdata('user_desig_code') == 'DEO') {
                                    ?>


                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports</a>
                                    <a href="<?php echo base_url(); ?>index.php/chithareport/districtDetails_flagged"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Chitha Reports(flagged village)</a>
                                    <a href="<?php echo base_url(); ?>index.php/JamabandiControllerBondita/menu"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Jamabandi Reports</a>


                                <?php }?>
                                <a href="<?php echo base_url(); ?>index.php/AgricultureCountController/index"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Agri-Stack Report</a>
                            </div>

                            <?php if (TECHNICAL_TICKET_LIVE == OPEN): ?>
                                <?php if (in_array($this->session->userdata('user_desig_code'), TECHNICAL_TICKET_ACCESS)): ?>
                                    <?php if (in_array($this->session->userdata('user_desig_code'), TICKET_DASHBOARD_ACCESS_YES)): ?>
                                        <button class="dropdown-btn">
                                            <i class="fa fa-fw fa-bug"></i>&nbsp; Ticket System
                                            <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;">
                                            </i>&nbsp;
                                        </button>
                                        <div class="dropdown-container">
                                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/TicketCommonController/getTicketSystemDashboard">
                                                <i class="fa fa-fw fa-bug"></i>&nbsp; Report A Ticket
                                            </a>
                                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/TicketCommonController/getTicketSystemDashboardOverAll">
                                                <i class="fa fa-fw fa-laptop"></i>&nbsp; Dashboard
                                            </a>
                                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/TicketCommonController/ticketSearchOverAll">
                                                <i class="fa fa-fw fa-search"></i>&nbsp; Search
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (in_array($this->session->userdata('user_desig_code'), TICKET_DASHBOARD_ACCESS_NO)): ?>
                                        <button class="dropdown-btn">
                                            <i class="fa fa-fw fa-bug"></i>&nbsp; Ticket System
                                            <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;">
                                            </i>&nbsp;
                                        </button>
                                        <div class="dropdown-container">
                                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/TicketCommonController/getTicketSystemDashboard">
                                                <i class="fa fa-fw fa-bug"></i>&nbsp; Report A Ticket
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>


                            <?php if (ALLOTMENT_AND_SETTLEMENT == OPEN): ?>
                                <?php if (in_array($this->session->userdata('user_desig_code'), ['DC'])): ?>
                                    <button class="dropdown-btn">
                                        <i class="fa fa-certificate"></i>&nbsp;Allotment Certificate (NIJE)
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;">
                                        </i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/AllotmentCertificate">
                                            <i class="fa fa-certificate"></i>&nbsp; Issue Certificate
                                        </a>
                                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/AllotmentCertificate/issued">
                                            <i class="fa fa-fw fa-laptop"></i>&nbsp; Issued Certificates
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if (in_array($this->session->userdata('user_desig_code'), ['CO'])): ?>
                                    <button class="dropdown-btn">
                                        <i class="fa fa-fw fa-bug"></i>&nbsp;Allotment Certificate (NIJE)
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;">
                                        </i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/AllotmentCertificate/issued">
                                            <i class="fa fa-fw fa-laptop"></i>&nbsp; Issued Certificates
                                        </a>
                                    </div>
                                <?php endif; ?>


                                <?php if (in_array($this->session->userdata('user_desig_code'), ['DC'])): ?>
                                    <button class="dropdown-btn">
                                        <i class="fa fa-certificate"></i>&nbsp;Settlement Certificate (NIJE)
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;">
                                        </i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/SettlementCertificate">
                                            <i class="fa fa-certificate"></i>&nbsp; Issue Certificate
                                        </a>
                                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/SettlementCertificate/issued">
                                            <i class="fa fa-fw fa-laptop"></i>&nbsp; Issued Certificates
                                        </a>
                                    </div>
                                <?php endif; ?>


                                <?php if (in_array($this->session->userdata('user_desig_code'), ['CO'])): ?>
                                    <button class="dropdown-btn">
                                        <i class="fa fa-fw fa-bug"></i>&nbsp;Settlement Certificate (NIJE)
                                        <i class="fa fa-fw fa-caret-down" style="padding-top: 15px; padding-right: 40px;">
                                        </i>&nbsp;
                                    </button>
                                    <div class="dropdown-container">
                                        <a class="nav-link" href="<?php echo base_url(); ?>index.php/SettlementCertificate/issued">
                                            <i class="fa fa-fw fa-laptop"></i>&nbsp; Issued Certificates
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>




                            <button class="dropdown-btn "><i class="fa fa-fw fa-user"></i>&nbsp; User Management <i class="fa fa-fw fa-caret-down" style="padding-top: 15px;
    padding-right: 40px;"></i>&nbsp;
                            </button>
                            <div class="dropdown-container">

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'CO') {
                                    ?>
                                    <!-- index.php/initialization/useraccount  NEW ACCOUNT LINK-->

                                    <?php
                                    if (EHRMS_USER_CREATION == OPEN) {
                                        ?>
                                        <a href="<?php echo base_url() ?>index.php/EhrmsController/CreateUserIndex"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Create EHRMS User </a>
                                        <?php
                                    }
                                    ?>

                                    <a href="<?php echo base_url() ?>index.php/initialization/useraccount"><i class="fa fa-fw fa-angle-right"></i>&nbsp; New Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users_co"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Enable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users_co"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Disable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/passwordreset"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Reset password</a>
                                    <a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>" class="nav-link">
                                        <i class="fa fa-fw fa-angle-right"></i>&nbsp; Change password</a>
                                    <a href="<?php echo base_url(); ?>index.php/user-list"><i class="fa fa-fw fa-angle-right"></i>&nbsp;User Permission</a>

                                <?php }?>


                                <?php
                                if ($this->session->userdata('user_desig_code') == 'DC') {
                                    ?>
                                    <a href="<?php echo base_url() ?>index.php/initialization/useraccount"><i class="fa fa-fw fa-angle-right"></i>&nbsp; New Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Enable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Disable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/passwordreset"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Reset password</a>
                                    <a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>" class="nav-link">
                                        <i class="fa fa-fw fa-angle-right"></i>&nbsp; Change password</a>
                                    <a href="<?php echo base_url(); ?>index.php/user-list"><i class="fa fa-fw fa-angle-right"></i>&nbsp;User Permission</a>

                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'ADC' || $this->session->userdata('user_desig_code') == 'SDO') {
                                    ?>
                                    <a href="<?php echo base_url() ?>index.php/initialization/useraccount"><i class="fa fa-fw fa-angle-right"></i>&nbsp; New Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Enable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Disable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/passwordreset"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Reset password</a>
                                    <a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>" class="nav-link">
                                        <i class="fa fa-fw fa-angle-right"></i>&nbsp; Change password</a>
                                    <a href="<?php echo base_url(); ?>index.php/user-list"><i class="fa fa-fw fa-angle-right"></i>&nbsp;User Permission</a>
                                <?php }?>

                                <?php
                                if ($this->session->userdata('user_desig_code') == 'ADM') {
                                    ?>
                                    <a href="<?php echo base_url() ?>index.php/initialization/useraccount"><i class="fa fa-fw fa-angle-right"></i>&nbsp; New Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_active_enabled_users_dio"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Enable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/all_inactive_disabled_users_dio"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Disable Account</a>
                                    <a href="<?php echo base_url(); ?>index.php/initialization/viewaccount_master"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Other Account</a>

                                    <a href="<?php echo base_url(); ?>index.php/initialization/passwordreset_dio"><i class="fa fa-fw fa-angle-right"></i>&nbsp; Reset password</a>
                                    <a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>" class="nav-link">
                                        <i class="fa fa-fw fa-angle-right"></i>&nbsp; Change password</a>


                                <?php }?>




                                <?php
                                if (($this->session->userdata('user_desig_code') == 'LM') or ($this->session->userdata('user_desig_code') == 'SK') or ($this->session->userdata('user_desig_code') == 'AST') or ($this->session->userdata('user_desig_code') == 'BO') or ($this->session->userdata('user_desig_code') == 'DEO') or ($this->session->userdata('user_desig_code') == 'DIO')) {
                                    ?>
                                    <a href="<?php echo base_url() . 'index.php/initialization/edit_accounts?user_code=' . $this->session->userdata('user_code') . '&dist_code=' . $this->session->userdata('dist_code') . '&subdiv_code=' . $this->session->userdata('subdiv_code') . '&cir_code=' . $this->session->userdata('cir_code') . '&mouza_pargona_code=' . $this->session->userdata('mouza_pargona_code') . '&lot_no=' . $this->session->userdata('lot_no'); ?>" class="nav-link">
                                        <i class="fa fa-fw fa-angle-right"></i>&nbsp; Change password</a>
                                    <a href="<?php echo base_url(); ?>index.php/CaseTransferBo"><i class="fa fa-fw fa-angle-right"></i>&nbsp;Case Transfer</a>
                                <?php }?>
                            </div>
                            <a href="https://basundhara.assam.gov.in/mobileapp" download><i class='fa fa-download' ></i>&nbsp;Mobile App </a>
                            <?php if (ESCALATION_ENABLE == 1 && $this->session->userdata('user_desig_code') == 'DC') {
                                ?>
                                <a href="<?php echo base_url() . 'index.php/DcEscalationController/landingEscalatedViewPage'; ?>"><i class='fa fa-clock'></i>&nbsp;&nbsp;Escalation</a>
                            <?php }?>
                            <?php if (REVIEW_ENABLE == 1 && $this->session->userdata('user_desig_code') == 'DC') {
                                ?>
                                <a href="<?php echo base_url() . 'index.php/BasundharaReview/index'; ?>"><i class='fa fa-clock'></i>&nbsp;&nbsp;MB2 Review Applications</a>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        <?php endif?>


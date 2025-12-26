<style>
    .casedisplay {
        min-height: 0px;
    }

    .casedisplay-small {
        min-height: 120px;
    }

    .casedisplay:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    td{
        font-size: .9em;
    }
</style>
<div class="container-fluid login home" style="min-height:500px;">
    <div class="row">
        <?php if ($this->session->flashdata('message')): ?>
            <?php include 'message.php'; ?>
        <?php endif; ?>
        
        <div class="col-lg-12">
            <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> REVENUE DEPARTMENT OFFICER'S DASHBOARD</label></td>
                    <td><?php //include 'login_alert.php'; ?></td>
                </tr>
            </table>
            
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $user_desig_code = $this->session->userdata('user_desig_code');
                    if (($user_desig_code == 'DC') || ($user_desig_code == 'LAO') || ($user_desig_code == 'ADC')) {
                        ?>
                        <div class="well well-sm ">
                            <h3 style="text-align: center; font-size: 28px"><?php echo "MIS REPORTS"; ?></h3>
                            <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
                        </div>
                        <div class='col-lg-4 '>
                            <div class="panel">
                                <div class='panel-body'>
                                    <ul class='list-group'>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeGalanceDCLAO">Dispose and Pending Cases - At a Glance</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForPPDCLAO">Dispose and  Pending Cases - For a Particular Period</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForMonthsDCLAO">Cases Pending more than 2-3 months</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class='col-lg-4 '>
                            <div class="panel">
                                <div class='panel-body fixed-height'>
                                    <ul class='list-group'>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/LandRevenueEstimateRevenue">Land Area and Estimated Revenue</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController1/irregated_nonirregated">Irrigated and Non-Irrigated Land Area</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/AreaAgriNonAgri">Area of Agricultural / Non-Agricultural Land</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeGalance">Dispose and Pending Cases - At a Glance</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForPP">Dispose and  Pending Cases - For a Particular Period</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForMonths">Cases Pending more than 2-3 months</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/MonthlyCitizenCentricService">Monthly Statement on Citizen Centric Services</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/VillageLandScenario">Village-wise Land Scenario</a></li>
                                        <li class="list-group-item " ><a href="<?php echo base_url(); ?>index.php/MisReport/VillageLandScenarioOnLandClass">Village-wise Land Scenario based on Land Class</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/CropWiseLandArea">Crop-wise Land Area</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/VillWiseGovtLand">Village-wise Government Land Area</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/MonthlyReportConversion">Monthly Report on Conversion ( A.P to P.P )</a></li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-4 '>
                            <div class="panel">
                                <div class='panel-body fixed-height'>
                                    <ul class='list-style'>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/LandAreaNLR">Land Area of New Lease Rule Grant ( NLR Grant )</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController1/No_Of_Tenants">Number of Tenants</a></li>
                                        <li class="hide list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController1/village_wise_tenants">Village-wise List of Tenants</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/MisTeaReport">Tea Estate Wise Land Area</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController1/mouzawise_villages">List of Villages ( Mouza-Wise )</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportControllerBondita/JamaWasil">List Of Jama Wasil</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/ConversionArrearPremium">List of Conversion Cases For Arrear Premium.</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReport/DoulReport">Doul Report</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController/DoulReportDPE">Doul Report for Direct Paying Estates</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/district_Statistics">District Statistics</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/LandRevenueTeaEstate">Land Revenue For Direct Paying Tea Estate</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/LandRevenueNisKheEstate">Land Area and Revenue of Nisfi Keraj Estate</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/LandRevenueLaKheEstate">Land Area and Revenue of La Kheraj Estate</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class="panel">
                                <div class='panel-body fixed-height'>
                                    <ul class='list-style'>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReportControllerPartha/apppsppsap_select_land_area_wise">Land Area of Annual Patta ( A.P ),<br> Periodic Patta ( P.P ),<br> Special Periodic Patta ( S.P.P ),<br> Special Annual Patta ( S.A.P ).</a></li>
                                        <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReportController1/MonthlyAccMutPartConv">Monthly Account of -<br> Mutation / Partition / Conversion Cases </a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController1/AP_PP_SPP_SAP">Mouza-Wise Land Area of Annual Patta ( A.P ),<br> Periodic Patta ( P.P ),<br> Special Periodic Patta ( S.P.P ),<br> Special Annual Patta ( S.A.P )</a></li>
                                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportController1/AP_PP_SPP_SAP_Vill">Village-Wise Land Area of Annual Patta ( A.P ),<br> Periodic Patta ( P.P ),<br> Special Periodic Patta ( S.P.P ),<br> Special Annual Patta ( S.A.P )</a></li>
                                        <li class="list-group-item"> <a href="<?php echo base_url(); ?>index.php/MisReport/ReportMISC">Yearly / Monthly -<br>Report on application Received on MISC Cases</a></li>
                                        <li class="list-group-item not-active"><a href="<?php echo base_url(); ?>index.php/MisReport/UnderConstruction">Audit Report on Login</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
        $change_password = $my_info->first_login;
        if($change_password == 'Y'): ?> 
            <?php include 'first_login.php'; ?>
        <?php endif; ?>
    </div>
</div>

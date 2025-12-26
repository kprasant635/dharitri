<div class="container-fluid login">
    <div class="row">
         <?php
                        $user_desig_code = $this->session->userdata('user_desig_code');
                        if (($user_desig_code == 'DC') || ($user_desig_code == 'LAO') || ($user_desig_code == 'ADC') || ($user_desig_code == 'ADM')) {
                        ?>
        <div class='col-lg-6 '>
                <div class="panel">
                    <div class='panel-body fixed-height'>
                        <ul class='list-group'>
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeGalanceDCLAO">Dispose and Pending Cases - At a Glance</a></li>
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForPPDCLAO">Dispose and  Pending Cases - For a Particular Period</a></li>
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/DisposeForMonthsDCLAO">Cases Pending more than 2-3 months</a></li>
                            <li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReportController1/MonthlyAccMutPartConv_REV">Monthly Account of - Mutation / Partition / Conversion Cases </a></li>
							<li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReportController/dcFieldMutationCheck">Field Mutation Cases (with specific Date Range) </a></li>
							<li class="list-group-item" ><a href="<?php echo base_url(); ?>index.php/MisReportController/dcDeleteMutationCheck">Dispose Field Mutation Cases (with specific Date Range) </a></li>
                        </ul>
                    </div>
                </div>
            </div>
                        <?php }else{ ?>
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
                        <li class="list-group-item hide"><a href="<?php echo base_url(); ?>index.php/MisReportControllerBondita/JamaWasil">List Of Jama Wasil</a></li>
						<li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportControllerForJamawasil/districtDetailsForEnteringPattano">Jamawasil for Single Patta</a></li>
						<li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReportControllerForJamawasil/districtDetailsForEnteringMultiplePattaNo">Jama Wasil for Multiple Pattas</a></li>
                        <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/ConversionArrearPremium">List of Conversion Cases For Arrear Premium.</a></li>
                        <li class="list-group-item hide" ><a href="<?php echo base_url(); ?>index.php/MisReport/DoulReport">Doul Report</a></li>
	  <li class="list-group-item hide"><a href="<?php echo base_url(); ?>index.php/MisReportController/DoulReportDPE">Doul Report for Direct Paying Estates</a></li>
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
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/saledeed">Sale Deed for which Mutation Done</a></li>
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/districtwiselist">Dispose case District</a></li>
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/croplanddist">Crop Land Area</a></li>
                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/fruitdist">Fruit Trees</a></li>
<!--                            <li class="list-group-item"><a href="<?php echo base_url(); ?>index.php/MisReport/Backentry">Back Entry</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
         <?php } ?>
    </div>
</div>
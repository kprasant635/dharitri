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

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span>Revival Flagged Cases Service Wise</span>
                <hr>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Process Name</th>
                        <th>Total No. Case</th>
                        <th style="width: 200px; text-align:center!important;" >Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td class="rezaText"> <?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            Revival Flagged Cases For Khas Land And Ceiling Surplus Land
                        </td>
                        <td>
                            <?php
                            if ($revivalListCountKhas != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$revivalListCountKhas</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$revivalListCountKhas</span>";
                            }
                            ?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/revivalListDcServiceWise?service='.SETTLEMENT_KHAS_LAND_ID; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"> <?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            Revival Flagged Cases For Hereditary Land of Tribal Communities
                        </td>
                        <td>
                            <?php
                            if ($revivalListCountTribal != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$revivalListCountTribal</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$revivalListCountTribal</span>";
                            }
                            ?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/revivalListDcServiceWise?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"> <?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            Revival Flagged Cases For Land for Indigenous Special Cultivators (Tea/Coffee/Rubber)
                        </td>
                        <td>
                            <?php
                            if ($revivalListCountTea != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$revivalListCountTea</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$revivalListCountTea</span>";
                            }
                            ?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/revivalListDcServiceWise?service='.SETTLEMENT_SPECIAL_CULTIVATORS_ID; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"> <?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText">
                            Revival Flagged Cases For PGR VGR Land
                        </td>
                        <td>
                            <?php
                            if ($revivalListCountVGR != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$revivalListCountVGR</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$revivalListCountVGR</span>";
                            }
                            ?>
                        </td>
                        <td style="width: 200px" >
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/revivalListDcServiceWise?service='.SETTLEMENT_PGR_VGR_LAND_ID; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>



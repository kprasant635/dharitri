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
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
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

    .table>thead>tr>th {
        line-height: 2;

    }
    .table>tbody>tr>td {
        line-height: 2;

    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process / Settlement MB / <a href="<?= base_url()?>index.php/SettlementTribalADC/SettlementTribalLandAdc">Tribal Land</a>


            <a href="<?= base_url()?>index.php/SettlementTribalADC/SettlementTribalLandAdc">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>
        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementTribalCommunityTitle') ?></span>

                <?php if(CHITHA_DAG_FAG_TRIBAL_CASE_ADC_SDO == 1 && CHITHA_DAG_FLAG_DIST_CODE == trim($this->session->userdata("dist_code"))): ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 0px; margin-bottom: 10px">
                        <button class="rezaButt buttPrimary" id="chithaDagFlagUpdate">
                            <i class="fa fa-cog"></i> Update chitha dag flag
                        </button>
                    </div>
                <?php endif; ?>
                <hr>
            </div>
            <div class="reza-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Steps</th>
                        <th>Process Name</th>
                        <th>Total No. Case</th>
                        <th style="width: 200px; text-align:center!important;" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(DC_ADC_SDO_PRO_BUTTON == 0 OR DC_ADC_SDO_PRO_BUTTON == 1) { ?>
                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> Step 1</td>
                            <td class="rezaText"><?php echo $this->lang->line('1st_proceeding') ?></td>
                            <td>
                                <?php
                                if ($firstProceedingCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$firstProceedingCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$firstProceedingCount</span>";
                                }
                                ?>
                            </td>
                            <td style="width: 200px" >
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTribalAdc/viewAllTribalFirstProceedingADCCaseList'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step 2</td>
                            <td class="rezaText"><?php echo $this->lang->line('SDLACCommittee') ?></td>
                            <td>
                                <?php
                                if ($SDLACCommitteeCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACCommitteeCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACCommitteeCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/getSdlacCommitteeCommon'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> Step 3</td>
                            <td class="rezaText"><?php echo $this->lang->line('SDLACNotice') ?></td>
                            <td>
                                <?php
                                if ($SDLACNoticeCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACNoticeCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACNoticeCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTribalAdc/viewAllMarkAsSDLACListForADCTribal'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                    <?php } ?>
                    <?php if(DC_ADC_SDO_PRO_BUTTON == 1) { ?>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText">Step 4</td>
                            <td class="rezaText"><?php echo $this->lang->line('SDLACMemberReport') ?></td>
                            <td>
                                <?php
                                if ($SDLACReportCount != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$SDLACReportCount</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$SDLACReportCount</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTribalAdc/getAllProposalListSdlacTribal'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <!--                        <tr>-->
                        <!--                            <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
                        <!--                            <td class="rezaText">Step 4</td>-->
                        <!--                            <td class="rezaText">--><?php //echo $this->lang->line('SDLACMemberReport') ?><!--</td>-->
                        <!--                            <td>-->
                        <!--                                --><?php
//                                if ($sdlacMemberApprovalCount != '0')
//                                {
//                                    echo  "<span class=\"badge badge-danger\">$sdlacMemberApprovalCount</span>";
//                                }
//                                else
//                                {
//                                    echo  "<span class=\"badge badge-success\">$sdlacMemberApprovalCount</span>";
//                                }
//                                ?>
                        <!--                            </td>-->
                        <!--                            <td>-->
                        <!--                                <a class="rezaButt" href="--><?php //echo base_url() . 'index.php/SettlementTribalAdc/getAllSdlacMemberApprovalProposalListTribal'; ?><!--" style="float:right">-->
                        <!--                                    <i class="fa fa-eye"></i>&nbsp;view-->
                        <!--                                </a>-->
                        <!--                            </td>-->
                        <!--                        </tr>-->

                    <?php } ?>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText"><?php echo $this->lang->line('SDLACConsideration') ?></td>
                        <td>
                            <?php
                            if ($SDLACConsideration != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$SDLACConsideration</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$SDLACConsideration</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementTribalAdc/getAllUnderConSdlacTribal'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText">Rejected Application By CO</td>
                        <td>
                            <?php
                            if ($coRejectedCaseCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$coRejectedCaseCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$coRejectedCaseCount</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/getAllRejectedApplicationByCoForAdc?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID .'&s='.MB_DISMISS; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText">Modification Requested By CO</td>
                        <td>
                            <?php
                            if ($coModificationListCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$coModificationListCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$coModificationListCount</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementModification/getAllModificationRequestApplicationByCoForAdc?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText">Rejected By ADC</td>
                        <td>
                            <?php
                            if ($rejctedListCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$rejctedListCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$rejctedListCount</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDC/rejectedList?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID.'&s=D&office='.MB_ADD_DEPUTY_COMM; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText">Case Revival List</td>
                        <td>
                            <?php
                            if ($revivalListCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$revivalListCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$revivalListCount</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementMbCo/coRevivalCases?service='.SETTLEMENT_TRIBAL_COMMUNITY_ID.'&s=D'; ?>" style="float:right">
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



<!-- dag flag update  -->
<div class="modal" role="dialog" id="chithaDagFlagUpdateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to update chitha dag flag</h5>

                <input type="hidden" id="serviceType" value="><?php echo SETTLEMENT_TRIBAL_COMMUNITY_ID ?>">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="chithaDagFlagUpdateModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="chithaDagFlagUpdateModalYes">Yes, Update</button>
            </div>
        </div>
    </div>
</div>


<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.msg').click(function(e) {
            e.preventDefault();
            $('#myModal').modal();
        });

        $('.msg_reclass').click(function(e) {
            e.preventDefault();
            $('#myModal_reclass').modal();
        });
    });


    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }


    $(document).on('click','#chithaDagFlagUpdate',function ()
    {
        $('#chithaDagFlagUpdateModal').modal('show');
    });

    $(document).on('click','#chithaDagFlagUpdateModalNo',function ()
    {
        $('#chithaDagFlagUpdateModal').modal('hide');
    });

    $(document).on('click','#chithaDagFlagUpdateModalYes',function ()
    {
        var serviceCode   = $("#serviceType").val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        if(serviceCode != '')
        {
            const applicant = {
                serviceCode: serviceCode
            };

            $.ajax({
                url: BASE_URL + "/SettlementCommonDc/updateBulkChithaDagFlagCaseWise",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    $('#chithaDagFlagUpdateModal').modal('hide');
                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if (data.responseType == 2)
                    {
                        $('.buttPrimary').hide();
                        showSuccessMessage(data.message);
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                data: JSON.stringify(applicant)

            });
        }
        else
        {
            $.unblockUI();
            showErrorMessage("SOMETHING WENT WRONG");
        }
    });

</script>



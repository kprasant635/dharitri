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
            Process / Settlement MB / <a href="<?= base_url()?>index.php/SettlementVgrPgrSdo/SettlementVgrPgrLandSdo">Pgr Vgr</a>

            <a href="<?= base_url()?>index.php/SettlementVgrPgrSdo/SettlementVgrPgrLandSdo">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>


        <?php $slNo = 0; ?>
        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('pgrVgrTitle') ?></span>
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
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementVgrPgrSdo/viewAllVgrPgrFirstProceedingSdoCaseList'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> Step 2</td>
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
                            <td class="rezaText">Circle Clusters</td>
                            <td>
                                <?php
                                if ($circleCluster != '0')
                                {
                                    echo  "<span class=\"badge badge-danger\">$circleCluster</span>";
                                }
                                else
                                {
                                    echo  "<span class=\"badge badge-success\">$circleCluster</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/clusterList'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> Step 4</td>
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
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementVgrPgrSdo/viewAllMarkAsSdlacListForSdoVgrPgr'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                    <?php } ?>
                    <?php if(DC_ADC_SDO_PRO_BUTTON == 1) { ?>

                        <tr>
                            <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                            <td class="rezaText"> Step 5</td>
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
                                <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementVgrPgrSdo/getAllProposalListSdlacVgrPgr'; ?>" style="float:right">
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <!--<tr>-->
                        <!--    <td class="rezaText">--><?php //echo $slNo += 1; ?><!--.</td>-->
                        <!--    <td class="rezaText">Step 6</td>-->
                        <!--    <td class="rezaText">--><?php //echo $this->lang->line('SDLACMemberReport') ?><!--</td>-->
                        <!--    <td>-->
                        <!--        --><?php
                        //        if ($sdlacMemberApprovalCount != '0')
                        //        {
                        //            echo  "<span class=\"badge badge-danger\">$sdlacMemberApprovalCount</span>";
                        //        }
                        //        else
                        //        {
                        //            echo  "<span class=\"badge badge-success\">$sdlacMemberApprovalCount</span>";
                        //        }
                        //        ?>
                        <!--    </td>-->
                        <!--    <td>-->
                        <!--        <a class="rezaButt" href="--><?php //echo base_url() . 'index.php/SettlementVgrPgrSdo/getAllSdlacMemberApprovalProposalListVgrPgr'; ?><!--" style="float:right">-->
                        <!--            <i class="fa fa-eye"></i>&nbsp;view-->
                        <!--        </a>-->
                        <!--    </td>-->
                        <!--</tr>-->

                    <?php } ?>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> - - -</td>
                        <td class="rezaText">Cluster case re-report by CO</td>
                        <td>
                            <?php
                            if ($clusterCaseReReport != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$clusterCaseReReport</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$clusterCaseReReport</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/clusterReReport'; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText">VGR-PGR Reverted Cases</td>
                        <td>
                            <?php
                            if ($vgrPgrRevertCount != '0')
                            {
                                echo  "<span class=\"badge badge-danger\">$vgrPgrRevertCount</span>";
                            }
                            else
                            {
                                echo  "<span class=\"badge badge-success\">$vgrPgrRevertCount</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementProposalSdoController/getVgrPgrRevertedCaseListSdo'; ?>" style="float:right">
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
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDc/getAllRejectedApplicationByCoForSdo?service='.SETTLEMENT_PGR_VGR_LAND_ID .'&s='.MB_DISMISS; ?>" style="float:right">
                                <i class="fa fa-eye"></i>&nbsp;view
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="rezaText"><?php echo $slNo += 1; ?>.</td>
                        <td class="rezaText"> -- </td>
                        <td class="rezaText">Rejected By SDO</td>
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
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementCommonDC/rejectedList?service='.SETTLEMENT_PGR_VGR_LAND_ID.'&s=D&office='.MB_SUB_DIV_COMM; ?>" style="float:right">
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
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementMbCo/coRevivalCases?service='.SETTLEMENT_PGR_VGR_LAND_ID.'&s=D'; ?>" style="float:right">
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
                            <a class="rezaButt" href="<?php echo base_url() . 'index.php/SettlementModification/getAllModificationRequestApplicationByCoForSdo?service='.SETTLEMENT_PGR_VGR_LAND_ID; ?>" style="float:right">
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
</script>


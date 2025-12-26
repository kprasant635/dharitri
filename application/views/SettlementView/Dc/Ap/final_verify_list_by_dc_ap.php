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


    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .buttInfo2 {
        color: #FFF;
        background-color: #9C27B0;
    }
    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttDanger {
        color: #FFF;
        background-color: #EF5350;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }

    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        line-height: 35px;
        padding: 0 .8rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        /*text-transform: uppercase;*/
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
        margin-bottom: 10px;
    }
    .rezaText {
        font-size: 16px;
    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementAP') ?></span>
                <hr>
                <span><?php echo $this->lang->line('finalCaseList') ?></span>
            </div>

            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="18%"><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th width="18%"><label class="control-label">Hearing Date</label></th>
                            <th width="62%"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td>
                                    Proposal No <?php echo $case->id; ?>
                                </td>

                                <td class="center">
                                    <i class='fa fa-calendar'></i>
                                    On <?php echo date('d-m-Y', strtotime($case->h_date)); ?>
                                </td>
                                <!--                                <td class="center">-->
                                <!--                                    <i class='fa fa-user'></i>-->
                                <!--                                    --><?php //echo $case->created_by; ?>
                                <!--                                </td>-->
                                <td class="center">
                                    <a class="rezaButt btn-primary" target= "SDLACProposalNotice" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getProposalNotice/?case=<?php echo $case->id; ?>">
                                        Notice
                                    </a>
                                    <a target="_blank" class="rezaButt buttPrimary" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/generateSdlacMinutesForProposal/?case=<?php echo $case->id; ?>">
                                        Digital Minutes
                                    </a>
                                    <a class="rezaButt buttInfo2" target= "SDLACProposalNotice" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewSdlacAttendance/?case=<?php echo $case->id; ?>">
                                        Attendance
                                    </a>
                                    <a class="rezaButt buttCust" target= "SDLACProposalNotice" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewSdlacUploadedMinute/?case=<?php echo $case->id; ?>">
                                        Uploaded Minutes
                                    </a>
                                    <a class="rezaButt btn-success" href="<?php echo base_url(); ?>index.php/SettlementApDc/getAllApplicationInSdlacReportForVerifyAp/?case=<?php echo $case->id; ?>">
                                        <?php echo $this->lang->line('finalVerifyButt'); ?>
                                    </a>


                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>





    </div>
</div>
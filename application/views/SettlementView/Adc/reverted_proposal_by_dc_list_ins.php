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

    .buttPrimary {
        color: #FFF;
        background-color: #673AB7;
    }
    .buttSuccess {
        color: #FFF;
        background-color: #4CAF50;
    }
    .buttCust {
        color: #FFF;
        background-color: #795548;
    }

    .rezaInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaClose {
        color: #FFF;
        background-color: #EF5350;
    }

    .buttInfo {
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
        height: 33px;
        /*min-width: 150px;*/
        line-height: 34px;
        padding: 0 1rem;
        font-size: 14px;
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
    .swal-wide{
        width:850px !important;
    }
    #progress {
        width: 500px;
        border: 1px solid #aaa;
        height: 20px;
    }
    #progress .bar {
        background-color: cyan;
        height: 20px;
    }

</style>

<div class="row" style='padding: 40px 50px 40px 20px'>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="padding-left: 25px">
        Process /
        Settlement MB 3.0 /
        <a href="<?= base_url()?>index.php/SettlementProposalControllerIns/revertMeetingListForAdc">Reverted Meeting </a> /
        Proposals

        <a class="btn btn-sm btn-danger pull-right" href="<?=base_url().'index.php/SettlementProposalControllerIns/revertMeetingListForAdc'?>"><i class="fa fa-backward"></i>&nbsp; Go Back</a>

    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <span>Proposals Under Reverted Meeting (<?php echo $meetingName ?>) By DC</span>
                        <hr>
                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
                        <span><?php echo $this->lang->line('proposalList') ?></span>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12" align="right">
                        <button class="rezaButt buttInfo" id="searchProId">
                            <i class="fa fa-search"></i> Search Proposal ID
                        </button>
                        <button class="rezaButt buttPrimary" id="uploadAdditionalFile" >
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            Upload Additional Document
                        </button>
                    </div>
                </div>
            </div>

            <div class="reza-body">

                <?php if ($pendingProCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class="table" width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Proposal No</th>
                            <th>Hearing Date</th>
                            <th>Created By</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($proposals as $proposal): ?>
                            <tr>
                                <td  style="font-size: 16px"><?php echo $i;  $i++;?></td>
                                <td  style="font-size: 16px; font-weight: bolder"><?php echo $proposal->proposal_name ?></td>
                                <td  style="font-size: 16px"><?php echo date('d-m-Y', strtotime($proposal->h_date))  ?></td>
                                <td  style="font-size: 16px"><?php echo $proposal->created_by ?></td>
                                <td>
                                    <a class="rezaButt buttPrimary" target= "SDLACProposalNotice" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/getProposalNotice/?case=<?php echo $proposal->id ?>">
                                        <i class="fa fa-print"></i> Print Notice
                                    </a>
                                    <a class="rezaButt buttCust"    target= "Download" href="<?php echo base_url(); ?>index.php/SettlementCommonIns/downloadCasesWithProposalId/?case=<?php echo $proposal->id ?>">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                    <a class="rezaButt buttSuccess"  target= "SDLACProposalNotice" href="<?php echo base_url(); ?>index.php/SettlementProposalControllerIns/caseListUnderRevertedMeetingForAdc/?proposal=<?php echo $proposal->id ?>">
                                        <i class="fa fa-edit"></i> Edit Proposal
                                    </a>
                                </td>
                            </tr>
                        <?php  endforeach; ?>
                        </tbody>
                    </table>

                    <br>
                    <br>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="left">
                            <button type="submit" id="verifyCases" class="btn " style="background-color: rgb(244, 67, 54); color: white; display: inline-block;">
                                <b><i class="fa fa-spinner fa-spin"></i>  VERIFY CASES </b>
                            </button>
                            <button type="submit" id="openModalForFinalSubmit" class="btn btn-primary" style="display: none">
                                <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp; <b>VIEW MEETING MINUTES & SEND TO DC </b>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" id="meetingId" value="<?= $meetingDetails->id ?>" >

                <?php endif; ?>

            </div>

        </div>

    </div>
</div>


<!-- Proposal id search -->
<div class="modal" role="dialog" id="searchProIdModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Search Proposal Id With Case No.</h5>
            </div>
            <div class="modal-body" align="center">
                <form action="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="w3review" style="font-weight: bold">Search By Case ID</label>
                            <input class="form-control" name="" value="" id="caseId" placeholder=" KAM/PAL/2022-00/000/SAPNR"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center" style="margin-top: 15px">OR</div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="left">
                            <label for="w3review" style="font-weight: bold">Search By Application ID</label>
                            <input class="form-control" name="" value="" id="applicationId" placeholder=" RTPS/SAPH/2022/0000"/>
                        </div>
                    </div>
                    <div class="row" id="searchData">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group" align="center">
                            <hr>

                            <table class="" style="font-weight:bold; font-size: 18px">
                                <tbody id="caseTable">

                                </tbody>

                            </table>

                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="searchProIdModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="searchProIdModalYes">Search</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for final submission -->
<div class="modal" role="dialog" id="finalSubmissionModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    SDLAC/CDLAC Member who attended meeting
                </h5>
                <i class="fa fa-close fa-2x text-red closeFinalModal" style="cursor:pointer;"></i>
            </div>

            <div class="modal-body">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Meeting Date <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>

                                <input type="datetime-local" class="form-control"
                                       name="meeting_date" id="meeting_date" value="<?= $meetingDetails->meeting_date ?>">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Venue of Meeting  <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="text" class="form-control"
                                       name="meeting_venue" id="meeting_venue" value="<?= $meetingDetails->meeting_venue ?>">
                            </div>

                        </div>
                        <div class="form-group">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Remarks  <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="text" class="form-control"
                                       name="meeting_remarks" id="meeting_remarks" value="<?= $meetingDetails->meeting_remarks ?>">
                            </div>
                        </div>

                    </div>&nbsp;

                    <div class="row">

                        <table class="datatable table table-stripped" id='datatable1' width="100%">
                            <thead>
                            <tr>
                                <th width="10%">Sl No</th>
                                <th width="10%">Select Member</th>
                                <th width="20%">SDLAC/CDLAC Member</th>
                                <th width="20%">Select Nominee (if any)</th>
                                <th width="20%" style="text-align:center">Meeting Attended</th>
                            </tr>
                            </thead>
                            <tbody id="list_of_sdlac_commitee_members">

                            <?php $i=1; foreach($committeeList as $row) { ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td>
                                        <?php if(in_array($row->user_code, $allPreMem)): ?>
                                            <input type="checkbox" checked disabled class="checkBoxD selectMember" value="<?=$row->user_code?>" id="<?=$row->user_code?>" name="check_<?=$row->user_code?>">

                                        <?php else : ?>
                                            <input type="checkbox"  class="checkBoxD selectMember" value="<?=$row->user_code?>" id="<?=$row->user_code?>" name="check_<?=$row->user_code?>">

                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <?=$row->name?>
                                        <input type="hidden" id="sdlac_user_<?=$row->user_code?>" value="<?=$row->user_code?>">
                                    </td>

                                    <td>
                                        <select class="form-control" id="select_nominee_<?=$row->user_code?>">
                                            <option value="0">Not Available</option>
                                            <?php if($row->user_type == 'MLA' && in_array($this->session->userdata("dist_code").'_'.$row->user_code, SDLAC_MEM_MLA_NOMINEE_ALLOW)) :?>
                                                <?php
                                                //list of members
                                                $nominee = $this->utilityclass->getNomineeOfSdlacMember($row->user_code, $this->session->userdata('dist_code'));
                                                foreach($nominee as $nom)
                                                {
                                                    //for selected nominee
                                                    $checkedStatus = $this->utilityclass->getSelectedNomineeOfSdlac($proposal_no, $nom->id, SETTLEMENT_KHAS_LAND_ID); ?>
                                                    <option <?=$checkedStatus?> value="<?=$nom->id?>"><?=$nom->nominee_name?></option>
                                                <?php } ?>

                                            <?php elseif(in_array($row->user_type,SDLAC_MEM_NOMINEE_ALLOW)) : ?>

                                                <?php
                                                //list of members
                                                $nominee = $this->utilityclass->getNomineeOfSdlacMember($row->user_code, $this->session->userdata('dist_code'));
                                                foreach($nominee as $nom)
                                                {
                                                    //for selected nominee
                                                    $checkedStatus = $this->utilityclass->getSelectedNomineeOfSdlac($proposal_no, $nom->id, SETTLEMENT_KHAS_LAND_ID); ?>
                                                    <option <?=$checkedStatus?> value="<?=$nom->id?>"><?=$nom->nominee_name?></option>
                                                <?php } ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>

                                    <td style="text-align: center;">
                                        <input  disabled type="radio" name="attend_status_<?=$row->user_code?>"
                                                id="report_online<?=$i?>" value="<?=SDLAC_ATTEND_ONLINE?>" >&nbsp;<span style="color:green">
                                        Online</span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input  disabled type="radio" name="attend_status_<?=$row->user_code?>" checked
                                                id="report_offline<?=$i?>" value="<?=SDLAC_ATTEND_OFFLINE?>" >&nbsp;<span style="color:red">Offline</span>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: 25px">
                        <button type="submit" id="forwardToDcForFinalApproval" class="btn btn-primary">
                            <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp; VIEW MINUTES & SEND PROPOSAL TO DC
                        </button>
                        <button type="button" id="printMinutes" class="btn btn-primary" style="background-color: #FF9800">
                            <i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp; PRINT MINUTES
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal for minute generate  -->
<div class="modal" role="dialog" id="minutesGenerateModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-body" id="print_direct">

                <div class="container bg-white divCard pb-3 " style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            Minutes of the meeting of SDLAC/CDLAC held on
                            <span style="font-weight:bold;" class="meetingDate"></span>
                            at
                            <span style="font-weight:bold;" class="timing"></span>
                            in the
                            <span style="font-weight:bold;" class="meetingVenue"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-bottom: 10px; margin-top: 15px">
                                Members Present as per list at Annexure - A:
                                <br>
                                List of Proposals Considered at Annexure - B:
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px">
                                The meeting was presided over by  District Commissioner <span style="font-weight:bold;" class="districtName"></span>
                                & Chairman, SDLAC/CDLAC.
                                She/He welcomed all the members present in the meeting and apprised the house about the objectives of the meeting.
                                Initiating the discussion, the Chairman placed the settlement/allotment proposals of the individuals/Institutions for each Revenue Circle
                                under  <span style="font-weight:bold;" class="subDivName"></span> Sub-Division in front of
                                the SDLAC/CDLAC for discussion and consideration.

                                <br>
                                &nbsp; &nbsp; &nbsp; &nbsp;

                                After threadbare discussion, following settlement/allotment proposals submitted by the
                                Revenue Circle Officers under  <span style="font-weight:bold;" class="subDivName"></span>
                                Sub-Division are recommended
                                unanimously by the SDLAC/CDLAC subject to fulfillment of
                                extant rules & guidelines laid down in Mission Basundhara 3.0, Land Policy, 2019 etc
                                and verification of
                                all related records/documents.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                <b><u>Following Proposals where considered by SDLAC/CDLAC & Recommended</u></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px; margin-top: 15px" id="caseDiv">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                <b><u>Following Proposals where considered by SDLAC/CDLAC & Not Recommended</u></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px; margin-top: 15px" id="caseDivNot">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" align="center">
                            <div class="rezaText">
                                The meeting (<span style="font-weight:bold;" class="meetingName"></span>) ended with vote of thanks from the chair.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC
                                <br>
                                Date <b><?=date('d-m-Y')?></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-12">
                                Memo No <span style="font-weight:bold;" class="memoName"></span>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <br>
                                Copy to:-
                            </div>
                        </div>

                        <div style="margin-bottom: 20px; padding-left: 85px">
                            1.	<span id="mpName" style="font-weight: bold"></span> Hon’ble MP ,
                            <span id="mpHPC" style="font-weight: bold"></span> H.P.C.
                            <br>
                            2.	<span id="mlaName" style="font-weight: bold"></span>, Hon’ble MLA,
                            <span id="mlaLAC" style="font-weight: bold"></span> LAC.
                            <br>
                            3.	The Principal Secretary to the Govt. of Assam, Revenue & DM Department, Dispur, Guwahati-06, Assam for kind information
                            <br>
                            4.	The Commissioner,
                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(UPPER_ASSAM_DIST_CODE)))): ?>
                                Upper
                            <?php else : ?>
                                Lower
                            <?php endif;?>
                            Assam Division, Guwahati-1 for kind information.
                            <br>
                            5.	The Chairman, <span id="zpcName" style="font-weight: bold"></span>, Zilla Parishad.
                            <br>
                            6.	The Chairman / Mayor, <span id="municipalName" style="font-weight: bold"></span>, Municipal Board / Corporation.
                            <br>
                            7.	All Circle Officers of <span id="circleOfficer" style="font-weight: bold"></span>
                            <span class="districtName" style="font-weight: bold"></span>, District.
                            <br>
                            8.	<span id="socialWorker" style="font-weight: bold"></span> Social Worker
                            <br>
                            9.	Office file.

                            <br>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container bg-white divCard pb-3 " style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            Members Present as per list at Annexure - A
                        </div>
                    </div>

                    <!--                    <div class="row mt-5 px-5">-->
                    <!--                        <div class="col-md-12">-->
                    <!--                            <div class="row justify-content-end">-->
                    <!--                                <div class="col-4 text-right">-->
                    <!--                                    Date <b>--><?//=date('d-m-Y')?><!--</b>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!---->
                    <!--                    </div>-->

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title">
                                Members Present
                            </div>
                        </div>

                        <div style="padding-left: 85px">
                            <table>
                                <tbody id="membersTable">

                                </tbody>

                            </table>
                        </div>

                    </div>





                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container bg-white divCard pb-3 " style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center" style="text-align: center;">

                        <div class="col-12" style="text-align: center; font-size: 18px; font-weight:bold;">
                                <span style="font-weight: bold">
                                    GOVERNMENT OF ASSAM
                                    <br>
                                    OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                    <br>
                                    Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                                </span>
                        </div>


                        <div class="reza-title" style="text-align: center;">
                            List of Proposals Considered at Annexure - B
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title">
                                Proposal List
                            </div>
                        </div>

                        <div style="padding-left: 85px">
                            <table>
                                <tbody id="proposalListTable">

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row" id="reservationTable" style="display: none">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                VGR/PGR Reservation/De-Reservation details (Application wise)
                            </div>
                            <div id="individualCasesTable" class="rezaText" style="padding: 10px">

                            </div>

                            <div class="reza-title" style="margin-top: 25px">
                                VGR/PGR Reservation details(Circle wise)
                            </div>
                            <div id="totalReservationTable" class="rezaText" style="padding: 10px">

                            </div>
                        </div>
                    </div>



                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: 25px">
                        <button type="button" id="minutesGenerateModalNo" class="rezaButt rezaClose">
                            Close
                        </button>
                        <button type="submit" id="minutesGenerateModalYes" class="rezaButt rezaInfo" style="">
                            <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp; SEND PROPOSAL TO DC
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="meeting_id" name="meeting_id"/>


<!-- Modal for print  minute   -->
<div class="modal" role="dialog" id="printMinutesModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-body" id="print_direct_new">

                <div class="container bg-white divCard pb-3 " style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            Minutes of the meeting of SDLAC/CDLAC held on
                            <span style="font-weight:bold;" class="meetingDate"></span>
                            at
                            <span style="font-weight:bold;" class="timing"></span>
                            in the
                            <span style="font-weight:bold;" class="meetingVenue"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-bottom: 10px; margin-top: 15px">
                                Members Present as per list at Annexure - A:
                                <br>
                                List of Proposals Considered at Annexure - B:
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px">
                                The meeting was presided over by  District Commissioner <span style="font-weight:bold;" class="districtName"></span>
                                & Chairman, SDLAC/CDLAC.
                                She/He welcomed all the members present in the meeting and apprised the house about the objectives of the meeting.
                                Initiating the discussion, the Chairman placed the settlement/allotment proposals of the individuals/Institutions for each Revenue Circle
                                under  <span style="font-weight:bold;" class="subDivName"></span> Sub-Division in front of
                                the SDLAC/CDLAC for discussion and consideration.

                                <br>
                                &nbsp; &nbsp; &nbsp; &nbsp;

                                After threadbare discussion, following settlement proposals submitted by the
                                Revenue Circle Officers under  <span style="font-weight:bold;" class="subDivName"></span>
                                Sub-Division are recommended
                                unanimously by the SDLAC/CDLAC subject to fulfillment of
                                extant rules & guidelines laid down in Mission Basundhara 3.0, Land Policy, 2019 etc
                                and verification of
                                all related records/documents.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                <b><u>Following Proposals where considered by SDLAC/CDLAC & Recommended</u></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px; margin-top: 15px" id="caseDiv1">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title" style="margin-top: 25px">
                                <b><u>Following Proposals where considered by SDLAC/CDLAC & Not Recommended</u></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="rezaText" style="padding-left: 10px; padding-right: 10px; margin-top: 15px" id="caseDivNot1">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" align="center">
                            <div class="rezaText">
                                The meeting (<span style="font-weight:bold;" class="meetingName"></span>) ended with vote of thanks from the chair.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC
                                <br>
                                Date <b><?=date('d-m-Y')?></b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-12">
                                Memo No <span style="font-weight:bold;" class="memoName"></span>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <br>
                                Copy to:-
                            </div>
                        </div>

                        <div style="margin-bottom: 20px; padding-left: 85px">
                            1.	<span id="mpName1" style="font-weight: bold"></span> Hon’ble MP ,
                            <span id="mpHPC1" style="font-weight: bold"></span> H.P.C.
                            <br>
                            2.	<span id="mlaName1" style="font-weight: bold"></span>, Hon’ble MLA,
                            <span id="mlaLAC1" style="font-weight: bold"></span> LAC.
                            <br>
                            3.	The Principal Secretary to the Govt. of Assam, Revenue & DM Department, Dispur, Guwahati-06, Assam for kind information
                            <br>
                            4.	The Commissioner,
                            <?php if((in_array($this->session->userdata("dist_code"), json_decode(UPPER_ASSAM_DIST_CODE)))): ?>
                                Upper
                            <?php else : ?>
                                Lower
                            <?php endif;?>
                            Assam Division, Guwahati-1 for kind information.
                            <br>
                            5.	The Chairman, <span id="zpcName1" style="font-weight: bold"></span>, Zilla Parishad.
                            <br>
                            6.	The Chairman / Mayor, <span id="municipalName1" style="font-weight: bold"></span>, Municipal Board  / Corporation.
                            <br>
                            7.	All Circle Officers of <span id="circleOfficer1" style="font-weight: bold"></span>
                            <span class="districtName" style="font-weight: bold"></span>, District.
                            <br>
                            8.	<span id="socialWorker1" style="font-weight: bold"></span> Social Worker
                            <br>
                            9.	Office file.

                            <br>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container bg-white divCard pb-3 " style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center mrigankaCenter" style="font-size: 18px; font-weight:bold;">
                            <span style="font-weight: bold">
                                GOVERNMENT OF ASSAM
                                <br>
                                OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                <br>
                                Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                            </span>
                        </div>

                        <div class="reza-title" style="text-align: center;">
                            Members Present as per list at Annexure - A
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title">
                                Members Present
                            </div>
                        </div>

                        <div style="padding-left: 85px">
                            <table>
                                <tbody id="membersTable1">

                                </tbody>

                            </table>
                        </div>

                    </div>





                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container bg-white divCard pb-3 " style="page-break-before:always;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" align="center" style="margin-top: 25px;">
                            <img src="<?php echo base_url();?>application/views/images/emblem.png">
                        </div>
                    </div>
                    <div class="row mt-5 text-center" style="text-align: center;">

                        <div class="col-12" style="text-align: center; font-size: 18px; font-weight:bold;">
                                <span style="font-weight: bold">
                                    GOVERNMENT OF ASSAM
                                    <br>
                                    OFFICE OF THE DISTRICT COMMISSIONER: <span style="font-weight:bold;" class="districtName"></span>
                                    <br>
                                    Sub-Division: <span style="font-weight:bold;" class="subDivName"></span>
                                </span>
                        </div>


                        <div class="reza-title" style="text-align: center;">
                            List of Proposals Considered at Annexure - B
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="reza-title">
                                Proposal List
                            </div>
                        </div>

                        <div style="padding-left: 85px">
                            <table>
                                <tbody id="proposalListTable1">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="row justify-content-end mt-5">
                            <div class="col-3 text-center">
                                District Commissioner
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-3 text-center">
                                Chairman, SDLAC/CDLAC, <span style="font-weight:bold;" class="districtName"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: 25px">
                        <span style="font-weight: bold; margin-right: 15px; color: #FF5252">Note: Once you print the minutes, kindly reload the page ! </span>
                        <button type="button" id="printMinutesModalNo" class="rezaButt rezaClose">
                            Close
                        </button>
                        <button type="button" onclick="printDiv('print_direct_new');" id="print" class="rezaButt rezaPrint" style="background-color: #673AB7; color: white">
                            <i class="fa fa-print"></i>
                            Print Minute
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- upload file  -->
<div class="modal" role="dialog" id="uploadAdditionalFileModal">
    <div class="modal-dialog modal-lg" role="document" style="width: 50%!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Additional Document </h5>
            </div>
            <div class="modal-body" align="left">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Document Type  <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <select class="form-control" name="gurdDocType" id="gurdDocType">
                            <option selected disabled>Select</option>
                            <option value="1">Guardian Minister Signed Minutes</option>
                            <option value="2">Others Document</option>
                        </select>
                        <br>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Document Title  <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <input type="text" placeholder="Please enter the name of the document" class="form-control"  id="fileText"  name="fileText" required minlength="3" maxlength="99">
                        <br>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="inputEmail4">Select File <span style="font-weight: bold; color: red; font-size: 15px">*</span></label>
                        <input type="file" class="form-control" id="fileUpload" name="fileUpload" required >
                    </div>
                </div>
                <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="uploadAdditionalFileModalNo">Close</button>
                <button type="button" class="btn btn-primary"   id="uploadAdditionalFileModalYes" style="margin-top: 0px;">Submit</button>
            </div>
        </div>
    </div>
</div>




<!--// NEW JS BY MASUD REZA-->
<input type="hidden" name="meetingId" id="meetingId" value="<?=$meeting->id?>">
<input type="hidden" name="meetingName" id="meetingName" value="<?=$meeting->meeting_name?>">
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>

    var BASE_URL = $("#getBaseURL").val();
    var progress_count = 0;
    var timer = 0;
    var PROG_MEET_AREA     = "<?php echo PROG_MEET_AREA?>";

    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            showCancelButton: true
        });
    }

    function showErrorMessageHtml(text) {
        swal.fire({
            title: "Error!",
            html: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            showCancelButton: true
        });
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents

    }


    // ****************************************************************



    // new for verify the reverted case
    $("#verifyCases").click(function()
    {

        var meetingId = $('#meetingId').val();

        if(meetingId == '') {
            showErrorMessage('Meeting is mandatory');
            return false;
        }
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        const applicant = {
            meetingId: meetingId
        };
        $.ajax({
            url: BASE_URL + "/SettlementProposalControllerIns/verifyCasesUnderRevertedMeetingByDc",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data)
            {
                $.unblockUI();
                completeProgress();
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 101)
                {
                    Swal.fire({
                        backdrop:true,
                        title: "#MR0003166<br>Unable to process for final approval",
                        type: "warning",
                        position: 'top',
                        customClass: 'swal-wide',
                        allowOutsideClick: false,
                        html: (data.message)+'<br><br>  ' +
                        '<h4 style="color: red">Do you want to revert the cases to respective COs ? </h4>',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Revert',
                    }).then((result) => {
                        if(result.isConfirmed)
                    {
                        revertBulkToCO(data.revertBulkPull,data.revertBulkChitha);
                        return;
                    }
                });
                }
                else if (data.responseType == 2)
                {
                    showSuccessMessage(data.message);
                    $('#openModalForFinalSubmit').show();
                }
                else if (data.responseType == 3)
                {
                    showErrorMessage("Data not found !");
                }
                else
                {
                    showErrorMessage("There is some problem, Please try again");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.unblockUI();
                completeProgress();
                console.log(errorThrown);
            },
            data: JSON.stringify(applicant)
        });
        if (PROG_MEET_AREA == 1)
        {
            progress_count = 0;
            timer = window.setInterval(checkProgress, 6000);
        }

    });

    // bulk reverted case
    function revertBulkToCO(revertBulkPull,revertBulkChitha)
    {
        if(!confirm("Are you sure !, You want to revert the cases ?"))
        {
            return true;
        }
        else
        {
            if(revertBulkPull == '' && revertBulkChitha == '')
            {
                showErrorMessage("There is no cases for Revert");
            }
            const cases = {
                revertBulkPull  : revertBulkPull,
                revertBulkChitha: revertBulkChitha
            };

            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
            $.ajax({
                url: BASE_URL + "/SettlementCommonIns/bulkRevertCasesInRevertedMeeting",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();

                    if (data.responseType == 1)
                    {
                        showErrorMessage(data.message);
                    }
                    else if(data.responseType == 2)
                    {
                        Swal.fire({
                            backdrop:true,
                            allowOutsideClick: false,
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                        }).then(function(result) {
                            if(result.isConfirmed){
                                location.reload(true);
                            }
                        });
                    }
                    else
                    {
                        showErrorMessage("SOMETHING WENT WRONG");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.unblockUI();
                    console.log(errorThrown);
                    alert("Status: " + textStatus);
                },
                data: JSON.stringify(cases)
            });
        }

    }



    // proposal id search by case no
    $(document).on('click','#searchProId',function ()
    {
        $('#searchProIdModal').modal({backdrop: 'static', keyboard: false});
        $('#searchProIdModal').modal('show');
    });

    $(document).on('click','#searchProIdModalNo',function ()
    {
        $('#searchProIdModal').modal('hide');
    });

    $(document).on('click','#searchProIdModalYes',function ()
    {
        const applicant = {
            caseNo: $("#caseId").val(),
            applicationNo: $("#applicationId").val(),
        };


        $.ajax({
            url: BASE_URL + "/SettlementCommonDc/searchProposalIdByAppCaseNo",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                if (data.responseType == 1)
                {
                    showErrorMessage("There is some problem, Please try again");
                }
                else if (data.responseType == 2)
                {

                    $('#searchProIdModal').modal({backdrop: 'static', keyboard: false});

                    var table = '';
                    var sl    = 1;
                    $.each(data.proposalIds, function (i, val) {

                        table +=
                            '<tr>'+
                            '<td style="font-size: 18px; font-weight: bold">' + sl +'. &nbsp;' + '</td>' +
                            '<td style="font-size: 18px; font-weight: bold">' + 'PROPOSAL ID - ' + val.proposal_id + '</td>' +
                            '</tr>';

                        sl = sl + 1;
                    });
                    $('#caseTable').html(table);
                }
                else if (data.responseType == 3)
                {
                    $('#searchProIdModal').modal('hide');
                    showErrorMessage("Data not found !");
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });


    });




    // upload additional file
    $(document).on('click','#uploadAdditionalFile',function ()
    {
        $('#uploadAdditionalFileModal').modal('show');
    });

    $(document).on('click','#uploadAdditionalFileModalNo',function ()
    {
        $('#uploadAdditionalFileModal').modal('hide');
    });

    $(document).on('click','#uploadAdditionalFileModalYes',function ()
    {

        if($('#meetingId').val() == '')
        {
            showErrorMessage("There is some problem !");
            return false;
        }
        else if($('#meetingName').val() == '')
        {
            showErrorMessage("There is some problem !");
            return false;
        }
        else if($('#gurdDocType').val() == '')
        {
            showErrorMessage("There is some problem !");
            return false;
        }
        else if($('#fileName').val() == '')
        {
            showErrorMessage("Please enter the name of the document !");
            $('#fileText').focus();
            return false;
        }
        else if($('#fileUpload').val() == '')
        {
            showErrorMessage("Please enter the name of the document !");
            $('#fileUpload').focus();
            return false;
        }
        else
        {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            var uploadedFile = new FormData();
            uploadedFile.append("fileUpload", $('#fileUpload')[0].files[0]);
            uploadedFile.append("meetingId", $('#meetingId').val());
            uploadedFile.append("meetingName", $('#meetingName').val());
            uploadedFile.append("fileName", $('#fileText').val());
            uploadedFile.append("gurdDocType", $('#gurdDocType').val());

            $.ajax({
                url: BASE_URL + "/SettlementProposalControllerIns/postAdditionalFileUnderMeetingAdc",
                type: "post",
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data)
                {
                    $.unblockUI();
                    var data = JSON.parse(data);

                    $('#uploadAdditionalFileModal').modal('hide');

                    if (data.response == 1) { //for error message
                        showErrorMessage(data.message);
                    }
                    if (data.response == 2) { //if success
                        Swal.fire({
                            backdrop:true,
                            allowOutsideClick: false,
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                        }).then(function(result) {
                            if(result.isConfirmed){
                                location.reload(true);
                            }
                        });
                        //location.reload(true);
                    }

                },
                data: uploadedFile
            });
        }


    });



    //close modal
    $('.closeFinalModal').click(function(){
        $('#finalSubmissionModal').modal('hide');
    });

    $("#openModalForFinalSubmit").click(function()
    {
        $('#finalSubmissionModal').modal('show');
    });




    // Generate minutes
    $('#forwardToDcForFinalApproval').click(function()
    {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var nominee = [];
        var selectMem = [];

        if($('#meeting_date').val() == '') {
            showErrorMessage('Meeting Date is mandatory');
            $('#meeting_date').focus();
            return false;
        }

        if($('#meeting_venue').val() == '') {
            showErrorMessage('Meeting venue is mandatory');
            $('#meeting_venue').focus();
            return false;
        }

        if($('#meeting_remarks').val() == '') {
            showErrorMessage('Meeting remarks is mandatory');
            $('#meeting_remarks').focus();
            return false;
        }

        if($('#meetingId').val() == '') {
            showErrorMessage('Meeting is mandatory');
            return false;
        }


        var uploadedFile = new FormData();
        uploadedFile.append("meeting_date", $('#meeting_date').val());
        uploadedFile.append("meeting_venue", $('#meeting_venue').val());
        uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());
        uploadedFile.append("meeting_id", $('#meetingId').val());

        //list of proposals selected

        //sdlac_user select_nominee attend_status
        <?php foreach ($committeeList as $com) { ?>

        var sdlac_user = $('#sdlac_user_<?=$com->user_code?>').val();
        var select_nominee = $('#select_nominee_<?=$com->user_code?>').val();
        var attend_status = $('input:radio[name=attend_status_<?php echo $com->user_code?>]:checked').val();
        var check_status = $('input:checkbox[name=check_<?php echo $com->user_code?>]:checked').val();
        if(attend_status == '') {
            showErrorMessage('All checks are mandatory');
            return false;
        }

        nomineeData = {sdlac_user,select_nominee,attend_status};
        nominee.push(nomineeData);

        if(check_status)
        {
            memberData = {check_status};
            selectMem.push(memberData);
        }


        <?php } ?>

        uploadedFile.append("nominee", JSON.stringify(nominee));
        uploadedFile.append("selectMem", JSON.stringify(selectMem));

        $.ajax({
            url: BASE_URL + "/SettlementProposalControllerIns/sendRevertedProposalsToDcMinuteAdc",
            type: "post",
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData:false,
            success: function (data)
            {
                $.unblockUI();
                var data = JSON.parse(data);
                if (data.response == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2)
                {
                    $('#finalSubmissionModal').modal('hide');
                    $('#minutesGenerateModal').modal({backdrop: 'static', keyboard: false});
                    $('#minutesGenerateModal').modal('show');
                    $(".districtName").html(data.districtName);
                    $(".subDivName").html(data.subDivName);
                    $(".meetingDate").html(data.meetingDate);
                    $(".meetingName").html(data.meetingName);
                    $(".memoName").html(data.memoName);
                    $(".timing").html(data.timing);
                    $(".meetingVenue").html(data.meetingVenue);
                    $("#meeting_id").val(data.meetingId);

                    $("#mpName").html(data.mpName);
                    $("#mpHPC").html(data.mpHPC);
                    $("#mlaName").html(data.mlaName);
                    $("#mlaLAC").html(data.mlaLAC);
                    $("#zpcName").html(data.zpcName);
                    $("#municipalName").html(data.municipalName);
                    $("#socialWorker").html(data.socialWorker);

                    //mriganka + Masud ---------------
                    if ((data.reservationDetails.length) != 0)
                    {

                        $('#reservationTable').show();
                        //*****case wise details */
                        var tbody = '';
                        var sl = 1;
                        var thead_r = '<tr>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Sl No</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Case No</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">De-reservation Location</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Reservation Location</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Area</th>' +
                            '</tr>';

                        var tbody_c = '';
                        var sl_c = 1;
                        var thead_c = '<tr>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Sl No</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Circle Name</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Reservation Location</th>'+
                            '<th style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Area</th>'+
                            '</tr>';

                        for (var i = data.reservationDetails.length - 1; i >= 0; i--) {
                            var dd = data.reservationDetails[i];

                            $.each(dd.reservationDetails, function (i, val) {

                                var bklg_r = '';

                                if (val.isBarakValley == 1) {
                                    bklg_r = 'B:' + val.reservation_bigha + ', K:' + val.reservation_katha + ', C:' + val.reservation_lessa + ', G:' + val.reservation_ganda;
                                }
                                else {
                                    bklg_r = 'B:' + val.reservation_bigha + ', K:' + val.reservation_katha + ', L:' + val.reservation_lessa;
                                }

                                tbody +=
                                    '<tr>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + sl + '. &nbsp;' + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.case_no + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.village_name + ', ' + val.lot_name + ', ' + val.mouza_name + ', ' + val.cir_name + ', ' + val.subdiv_name + ', ' + val.dist_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.reservation_village_name + ', ' + val.reservation_lot_name + ', ' + val.reservation_mouza_name + ', ' + val.reservation_cir_name + ', ' + val.reservation_subdiv_name + ', ' + val.reservation_dist_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + bklg_r + '</td>' +
                                    '</tr>';

                                sl = sl + 1;
                            });

                            //****circle wise reservation details */

                            $.each(dd.reservationByCircleDetails, function (i, val) {
                                var bklg = '';
                                if (val.isBV == 1) {
                                    bklg = 'B:' + val.bigha + ', K:' + val.katha + ', C:' + val.lessa + ', G:' + val.ganda;
                                }
                                else {
                                    bklg = 'B:' + val.bigha + ', K:' + val.katha + ', L:' + val.lessa;
                                }
                                tbody_c +=
                                    '<tr>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + sl_c + '. &nbsp;' + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.cir_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + val.cir_name + ', ' + val.subdiv_name + ', ' + val.dist_name + '</td>' +
                                    '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">' + bklg + '</td>' +
                                    '</tr>';

                                sl_c = sl_c + 1;
                            });
                        }

                        $('#individualCasesTable').html("<table class='table table-bordered'>" + thead_r + tbody + "</table>");

                        $('#totalReservationTable').html("<table class='table table-bordered'>" + thead_c + tbody_c + "</table>");

                    }
                    else
                    {
                        $('#reservationTable').hide();
                    }


                    // all member list
                    var tableMembers = '';
                    var slMembers    = 1;
                    $.each(data.nominee, function (i, val) {
                        tableMembers +=
                            '<tr>'+
                            '<td>' + slMembers +'. &nbsp;' + '</td>' +
                            '<td>' + val +'</td>' +
                            '</tr>';

                        slMembers = slMembers + 1;
                    });
                    $('#membersTable').html(tableMembers);


                    var proposalTable = '';
                    var sln    = 1;
                    $.each(data.proposalDetails, function (i, val) {

                        proposalTable +=
                            '<tr>'+
                            '<td>' + sln +'. &nbsp;' + '</td>' +
                            '<td>' + val.proposal_name + '</td>' +
                            '</tr>';

                        sln = sln + 1;
                    });
                    $('#proposalListTable').html(proposalTable);



                    if (data.caseList != null && data.caseList !='')
                        displayRecommendCases(data.caseList);
                    else
                        $('#caseDiv').html('--NILL--');
                    if (data.caseDivNot != null && data.caseDivNot !='')
                        displayNotRecommendCases(data.caseDivNot);
                    else
                        $('#caseDivNot').html('--NILL--');
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: uploadedFile
        });

    });




    // Print minutes
    $('#printMinutes').click(function()
    {
        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var nominee = [];
        var selectMem = [];

        if($('#meeting_date').val() == '') {
            showErrorMessage('Meeting Date is mandatory');
            $('#meeting_date').focus();
            return false;
        }

        if($('#meeting_venue').val() == '') {
            showErrorMessage('Meeting venue is mandatory');
            $('#meeting_venue').focus();
            return false;
        }

        if($('#meeting_remarks').val() == '') {
            showErrorMessage('Meeting remarks is mandatory');
            $('#meeting_remarks').focus();
            return false;
        }

        if($('#meetingId').val() == '') {
            showErrorMessage('Meeting is mandatory');
            return false;
        }


        var uploadedFile = new FormData();
        uploadedFile.append("meeting_date", $('#meeting_date').val());
        uploadedFile.append("meeting_venue", $('#meeting_venue').val());
        uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());
        uploadedFile.append("meeting_id", $('#meetingId').val());

        //list of proposals selected

        //sdlac_user select_nominee attend_status
        <?php foreach ($committeeList as $com) { ?>

        var sdlac_user = $('#sdlac_user_<?=$com->user_code?>').val();
        var select_nominee = $('#select_nominee_<?=$com->user_code?>').val();
        var attend_status = $('input:radio[name=attend_status_<?php echo $com->user_code?>]:checked').val();
        var check_status = $('input:checkbox[name=check_<?php echo $com->user_code?>]:checked').val();
        if(attend_status == '') {
            showErrorMessage('All checks are mandatory');
            return false;
        }

        nomineeData = {sdlac_user,select_nominee,attend_status};
        nominee.push(nomineeData);

        if(check_status)
        {
            memberData = {check_status};
            selectMem.push(memberData);
        }


        <?php } ?>

        uploadedFile.append("nominee", JSON.stringify(nominee));
        uploadedFile.append("selectMem", JSON.stringify(selectMem));

        $.ajax({
            url: BASE_URL + "/SettlementProposalControllerIns/sendRevertedProposalsToDcMinuteAdc",
            type: "post",
            enctype: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData:false,
            success: function (data)
            {
                $.unblockUI();
                var data = JSON.parse(data);
                if (data.response == 1)
                {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2)
                {
                    $('#finalSubmissionModal').modal('hide');
                    $('#printMinutesModal').modal({backdrop: 'static', keyboard: false});
                    $('#printMinutesModal').modal('show');
                    $(".districtName").html(data.districtName);
                    $(".subDivName").html(data.subDivName);
                    $(".meetingDate").html(data.meetingDate);
                    $(".meetingName").html(data.meetingName);
                    $(".memoName").html(data.memoName);
                    $(".timing").html(data.timing);
                    $(".meetingVenue").html(data.meetingVenue);

                    $("#mpName1").html(data.mpName);
                    $("#mpHPC1").html(data.mpHPC);
                    $("#mlaName1").html(data.mlaName);
                    $("#mlaLAC1").html(data.mlaLAC);
                    $("#zpcName1").html(data.zpcName);
                    $("#municipalName1").html(data.municipalName);
                    $("#socialWorker1").html(data.socialWorker);

                    // all member list
                    var tableMembers = '';
                    var slMembers    = 1;
                    $.each(data.nominee, function (i, val) {
                        tableMembers +=
                            '<tr>'+
                            '<td>' + slMembers +'. &nbsp;' + '</td>' +
                            '<td>' + val +'</td>' +
                            '</tr>';

                        slMembers = slMembers + 1;
                    });
                    $('#membersTable1').html(tableMembers);


                    var proposalTable = '';
                    var sln    = 1;
                    $.each(data.proposalDetails, function (i, val) {

                        proposalTable +=
                            '<tr>'+
                            '<td>' + sln +'. &nbsp;' + '</td>' +
                            '<td>' + val.proposal_name + '</td>' +
                            '</tr>';

                        sln = sln + 1;
                    });
                    $('#proposalListTable1').html(proposalTable);



                    if (data.caseList != null && data.caseList !='')
                        displayRecommendCasesPrint(data.caseList);
                    else
                        $('#caseDiv1').html('--NILL--');
                    if (data.caseDivNot != null && data.caseDivNot !='')
                        displayNotRecommendCasesPrint(data.caseDivNot);
                    else
                        $('#caseDivNot1').html('--NILL--');
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: uploadedFile
        });

    });



    // close send proposal to dc
    $('#minutesGenerateModalNo').click(function(){
        $('#finalSubmissionModal').modal('hide');
        $('#minutesGenerateModal').modal('hide');
    });

    // close print Minutes
    $('#printMinutesModalNo').click(function(){
        $('#finalSubmissionModal').modal('hide');
        $('#printMinutesModal').modal('hide');
    });



    // final submit & send proposal to dc
    $('#minutesGenerateModalYes').click(function(){

        if(!confirm("Are you sure to process for forward to DC ?")){
            return true;
        }
        else
        {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });

            var nominee = [];
            var selectMembers = [];

            if($('#meeting_date').val() == '') {
                showErrorMessage('Meeting Date is mandatory');
                $('#meeting_date').focus();
                return false;
            }

            if($('#meeting_venue').val() == '') {
                showErrorMessage('Meeting venue is mandatory');
                $('#meeting_venue').focus();
                return false;
            }

            if($('#meeting_remarks').val() == '') {
                showErrorMessage('Meeting remarks is mandatory');
                $('#meeting_remarks').focus();
                return false;
            }

            if($('#meetingId').val() == '') {
                showErrorMessage('Meeting is mandatory');
                return false;
            }


            var uploadedFile = new FormData();
            uploadedFile.append("meeting_date", $('#meeting_date').val());
            uploadedFile.append("meeting_venue", $('#meeting_venue').val());
            uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());
            uploadedFile.append("meeting_id", $('#meetingId').val());

            //sdlac_user select_nominee attend_status
            <?php foreach ($committeeList as $com) { ?>

            var sdlac_user = $('#sdlac_user_<?=$com->user_code?>').val();
            var select_nominee = $('#select_nominee_<?=$com->user_code?>').val();
            var attend_status = $('input:radio[name=attend_status_<?php echo $com->user_code?>]:checked').val();
            var check_status = $('input:checkbox[name=check_<?php echo $com->user_code?>]:checked').val();
            if(attend_status == '') {
                showErrorMessage('All checks are mandatory');
                return false;
            }
            nomineeData = {sdlac_user,select_nominee,attend_status};
            nominee.push(nomineeData);

            if(check_status)
            {
                memberData = {check_status};
                selectMembers.push(memberData);
            }

            <?php } ?>


            uploadedFile.append("nominee", JSON.stringify(nominee));
            uploadedFile.append("selectMem", JSON.stringify(selectMembers));


            $.ajax({
                url: BASE_URL + "/SettlementProposalControllerIns/sendRevertedProposalsToDcAdc",
                type: "post",
                enctype: 'multipart/form-data',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data)
                {
                    $.unblockUI();
                    var data = JSON.parse(data);

                    $('#finalSubmissionModal').modal('hide');

                    if (data.response == 1) { //for error message
                        showErrorMessage(data.message);
                    }
                    if (data.response == 2) { //if success
                        Swal.fire({
                            backdrop:true,
                            allowOutsideClick: false,
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                        }).then(function(result) {
                            if(result.isConfirmed){
                                location.reload(true);
                            }
                        });
                        //location.reload(true);
                    }

                },
                data: uploadedFile
            });

        }

    });



    // generate Minutes
    function displayRecommendCases(data)
    {

        var tableMembers = '';
        var slMembers    = 1;
        var prev_circle = '';
        var html_table = '';
        var fixed_header_text = 'Circle Name : ';
        var fixed_header = '<tr>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px; ">Sl No.</td>' +
            '<td style="width: 240px!important; background-color: white!important;  border: 1px solid black">Application No. <br> Circle Case No.</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Proposed Settlement holder</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Father/Husband</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Mouza & Village</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Dag No</td>' +
            '<td style="width: 90px!important; background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Area</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Service Name</td>' +
            '</tr>';
        var tableMember = '';
        var slNo = 1;
        $.each(data, function (i, val)
        {
            if (val.cirname != prev_circle)
            {
                if (html_table != '')
                {
                    slNo = 1;
                    html_table = html_table + "</table>";
                }
                html_table = html_table  + '<div style="font-size: 16px; font-weight: bold; margin-top:25px!important;">'
                    + fixed_header_text + val.cirname  + '</div>'
                    +"<table class='table table-bordered table-condensed' style=\"width: 100%!important;\" >"
                    + fixed_header;
            }

            tableMembers =
                '<tr>'+
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + slNo + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.applid + '<br>' +  val.case_no + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.name + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.guard + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.mouza +','+ val.village + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.dag + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.area + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.service_name +'</td>' +
                '</tr>';

            slNo = slNo + 1;

            html_table = html_table + tableMembers;
            prev_circle = val.cirname;
        });
        html_table = html_table + "</table>";
        $('#caseDiv').html(html_table);
    }

    // generate Minutes
    function displayNotRecommendCases(data)
    {

        var tableMembers = '';
        var slMembers    = 1;
        var prev_circle = '';
        var html_table = '';
        var fixed_header_text = 'Circle Name : ';
        var fixed_header = '<tr>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Sl No.</td>' +
            '<td style="width: 240px!important; background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Application No. <br> Circle Case No.</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Name of Proposed Settlement holder</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Name of Father/Husband</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Mouza & Village</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Dag No</td>' +
            '<td style="width: 90px!important; background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Area</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Service Name</td>' +
            '</tr>';
        var tableMember = '';
        var slNo = 1;
        $.each(data, function (i, val)
        {
            if (val.cirname != prev_circle)
            {
                if (html_table != '')
                {
                    slNo = 1;
                    html_table = html_table + "</table>";
                }
                html_table = html_table  + '<div style="font-size: 16px; font-weight: bold; margin-top:25px!important;">'
                    + fixed_header_text + val.cirname  + '</div>'
                    +"<table class='table table-bordered table-condensed' style=\"width: 100%!important;\" >"
                    + fixed_header;
            }

            tableMembers =
                '<tr>'+
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + slNo + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.applid + '<br>' +  val.case_no + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.name + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.guard + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.mouza +','+ val.village + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.dag + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.area + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.service_name +'</td>' +
                '</tr>';

            slNo = slNo + 1;

            html_table = html_table + tableMembers;
            prev_circle = val.cirname;
        });
        html_table = html_table + "</table>";
        $('#caseDivNot').html(html_table);
    }




    // print minutes
    function displayRecommendCasesPrint(data)
    {

        var tableMembers = '';
        var slMembers    = 1;
        var prev_circle = '';
        var html_table = '';
        var fixed_header_text = 'Circle Name : ';
        var fixed_header = '<tr>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px; ">Sl No.</td>' +
            '<td style="width: 240px!important; background-color: white!important;  border: 1px solid black">Application No. <br> Circle Case No.</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Proposed Settlement holder</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Name of Father/Husband</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Mouza & Village</td>' +
            '<td style="background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Dag No</td>' +
            '<td style="width: 90px!important; background-color: white!important;  border: 1px solid black;  color: black!important; font-size: 12px;">Area</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Service Name</td>' +
            '</tr>';
        var tableMember = '';
        var slNo = 1;
        $.each(data, function (i, val)
        {
            if (val.cirname != prev_circle)
            {
                if (html_table != '')
                {
                    slNo = 1;
                    html_table = html_table + "</table>";
                }
                html_table = html_table  + '<div style="font-size: 16px; font-weight: bold; margin-top:25px!important;">'
                    + fixed_header_text + val.cirname  + '</div>'
                    +"<table class='table table-bordered table-condensed' style=\"width: 100%!important;\" >"
                    + fixed_header;
            }

            tableMembers =
                '<tr>'+
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + slNo + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.applid + '<br>' +  val.case_no + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.name + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.guard + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.mouza +','+ val.village + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.dag + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.area + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.service_name +'</td>' +
                '</tr>';

            slNo = slNo + 1;

            html_table = html_table + tableMembers;
            prev_circle = val.cirname;
        });
        html_table = html_table + "</table>";
        $('#caseDiv1').html(html_table);
    }

    // print minutes
    function displayNotRecommendCasesPrint(data)
    {

        var tableMembers = '';
        var slMembers    = 1;
        var prev_circle = '';
        var html_table = '';
        var fixed_header_text = 'Circle Name : ';
        var fixed_header = '<tr>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Sl No.</td>' +
            '<td style="width: 240px!important; background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Application No. <br> Circle Case No.</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Name of Proposed Settlement holder</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Name of Father/Husband</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Mouza & Village</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Dag No</td>' +
            '<td style="width: 90px!important; background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Area</td>' +
            '<td style="background-color: white!important;  border: 1px solid black; color: black!important; font-size: 12px;">Service Name</td>' +
            '</tr>';
        var tableMember = '';
        var slNo = 1;
        $.each(data, function (i, val)
        {
            if (val.cirname != prev_circle)
            {
                if (html_table != '')
                {
                    slNo = 1;
                    html_table = html_table + "</table>";
                }
                html_table = html_table  + '<div style="font-size: 16px; font-weight: bold; margin-top:25px!important;">'
                    + fixed_header_text + val.cirname  + '</div>'
                    +"<table class='table table-bordered table-condensed' style=\"width: 100%!important;\" >"
                    + fixed_header;
            }

            tableMembers =
                '<tr>'+
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + slNo + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.applid + '<br>' +  val.case_no + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.name + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.guard + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.mouza +','+ val.village + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.dag + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.area + '</td>' +
                '<td style="background-color: white!important; border: 1px solid black; color: black!important; font-size: 12px;">' + val.service_name +'</td>' +
                '</tr>';

            slNo = slNo + 1;

            html_table = html_table + tableMembers;
            prev_circle = val.cirname;
        });
        html_table = html_table + "</table>";
        $('#caseDivNot1').html(html_table);
    }


    // for progrss bar
    function checkProgress() {
        progress_count++;
        if (progress_count == 100)
        {
            completeProgress();
            return;
        }

        var dist_code = "<?php echo $this->session->userdata("dist_code") ?>";
        $.ajax({
            url: BASE_URL + "/ProgressCheck/checkProgressBulkCaseByMeeting?file="+dist_code+'_'+$('#meetingId').val(),
            async : true,
            type: "post",
            success:function(data){
                $("#progress").show();
                $("#progress").html('<div class="bar" style="width:' + data.percent + '%"></div>');
                $("#message").html(data.message);
                if (data.percent == 100) {
                    window.clearInterval(timer);
                    timer = window.setInterval(completeProgress, 2000);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                completeProgress();
                console.log(errorThrown);
            },
        });
    }
    function completeProgress() {
        $("#progress").hide();
        $("#message").html("");
        progress_count = 0;
        window.clearInterval(timer);
        timer=0;
    }

</script>






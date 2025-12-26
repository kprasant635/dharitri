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
    .rezaInfo {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaClose {
        color: #FFF;
        background-color: #EF5350;
    }
    .rezaPrint {
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

    .checkBoxD{

        width: 20px;
        height: 20px;
    }


    .divCard {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        margin-bottom: 20px;
    }


    @media print
    {

        .divCard {
            background: #fff!important;
            width: 100%!important;
            margin-bottom: 20px!important;
            box-shadow: none!important;
        }
        .no-print, .no-print *
        {
            display: none !important;
        }
        div.page-break-after {
            display: block !important;
            page-break-after: always;
            padding: 15px;
            border: 1px solid #ccc;
        }
    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if($this->session->flashdata('success')) { ?>

            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>


        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left" >
                <div class="reza-title">List of proposals to be approved</div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-right" >
                <a class="rezaButt rezaPrint pull-right" href="<?=base_url().'index.php/SettlementCommonDc/addEditCopyTo'?>">
                    <i class="fa fa-edit"></i> &nbsp; Add Members For Minutes Copy to
                </a>
            </div>
        </div>

        <div class="reza-card">
            <div class="reza-body">
                <br>
                <table class="datatable table table-stripped" id='datatable' width="100%">
                    <thead>
                    <tr>
                        <th style="width: 15px!important;">All <input type="checkbox" class="checkBoxD" value="all" id="checkedAll"></th>
                        <th style="width: 65px!important;">SL No.
                            <select class="form-control input_search" name="cir_id" id="cir_id" data-column-index="0">
                                <option value="">Circle</option>
                                <?php if(isset($location)){ foreach($location as $cir){ ?>
                                    <option value="<?=$cir['cir_code'].",".$cir['subdiv_code']?>"><?=$cir['cir_name']?></option>
                                <?php }}?>
                            </select>
                        </th>
                        <th>Proposal No
                            <input type="text" id="by_pro_no" name="by_pro_no"
                                   class="form-control" placeholder="Search by Proposal No"  style="width: 210px!important;">
                        </th>
                        <th>Service Name
                            <select class="form-control" name="by_service" id="by_service" data-column-index="0">
                                <option value="0">Search by Service</option>
                                <option value="13">Occupancy Tenant</option>
                                <option value="14">AP</option>
                                <option value="15">Tribal</option>
                                <option value="16">Khas Land</option>
                                <option value="17">Pgr Vgr</option>
                                <option value="18">Special Cultivators</option>
                            </select>
                        </th>
                        <th class="center" style="width: 100px!important;">Hearing Date
                            <input type="text" id="by_case_no" name="by_case_no"
                                   class="form-control" placeholder="Case No">
                        </th>
                        <th class="center" style="width: 285px!important;">Action
                            <button type="button" class="search_button btn btn-sm btn-success form-control"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <?php if($countPendingCase != 0){ ?>
                    <div class="row">
                        <?php if(SEND_PROPOSAL_TO_SDLAC_MEM_BUTTON == 1) { ?>
                            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                                <button class="btn btn-md btn-warning" id="addNomineeOfSdlacMembers">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    Add Nominee of SDLAC/CDLAC Member
                                </button>
                                <button  class="btn btn-md btn-primary" id="openModalForFinalSubmit" >
                                    <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp;Process
                                </button>
                            </div>
                        <?php } else { ?>
                            <button  class="btn btn-md btn-primary" id="noProcess" >
                                <i class="fa fa-forward" aria-hidden="true"></i>&nbsp;&nbsp;Process
                            </button>
                        <?php } ?>
                    </div>
                <?php } ?>
                <br>

            </div>
        </div>
    </div>
</div>


<!-- Add Nominee of SDLAC/CDLAC Member -->
<div class="modal" role="dialog" id="nomineeAddModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="max-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Add Nominee of SDLAC/CDLAC Member
                </h5>
                <i class="fa fa-close fa-2x text-red closeNomineeModal" style="cursor:pointer;"></i>
            </div>

            <div class="modal-body">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>SDLAC/CDLAC Member</label>&nbsp;<span class="text-danger">*</span>
                                <select class="form-control" id="added_sdlac_member">
                                    <option value="NA">Select SDLAC/CDLAC Member</option>
                                    <?php $i=1; foreach($committeeList as $mem) { ?>
                                        <?php if($mem->user_type == 'MLA' && in_array($this->session->userdata("dist_code").'_'.$mem->user_code, SDLAC_MEM_MLA_NOMINEE_ALLOW)) :?>
                                            <option value="<?= $mem->user_code ?>"><?= $mem->name ?></option>

                                        <?php elseif(in_array($mem->user_type,SDLAC_MEM_NOMINEE_ALLOW)) : ?>
                                            <option value="<?= $mem->user_code ?>"><?= $mem->name ?></option>

                                        <?php else : ?>
                                        <?php endif; ?>

                                        <?php $i++; } ?>
                                </select>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Nominee Name</label>&nbsp;<span class="text-danger">*</span>
                                <input type="text" class="form-control" id="added_nominee_name"
                                       placeholder="Enter Nominee Name">
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Nominee Contact No</label>&nbsp;<span class="text-danger">*</span>
                                <input type="text" class="form-control" id="added_nominee_contact"
                                       placeholder="Enter Nominee Contact No" maxlength="10">
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Nominee Email ID</label>
                                <input type="text" class="form-control" id="added_nominee_email"
                                       placeholder="eg. xyz@gmail.com">
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" id="insertNominee" class="btn btn-primary btn-sm">Add Nominee</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer"></div>
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

                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Meeting Date <span style="font-weight: bold; font-size: 18px; color: red">*</span>
                                    <?php if(MEETING_PROPOSAL_SDLAC_NOTICE_HOLD == 1): ?>
                                        <span style="color: #EF5350; font-weight: bold">
                                            ( Maximum Date of processing <?php echo MEETING_PROPOSAL_SDLAC_NOTICE_DATE_SHOW ?> )
                                        </span>
                                    <?php endif; ?>
                                </label>

                                <input type="datetime-local" class="form-control"
                                       name="meeting_date" id="meeting_date" required max="<?php echo MEETING_PROPOSAL_SDLAC_NOTICE_DATE_INPUT ?>">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Upload Minutes (If Any)</label>
                                <input type="file" class="form-control" id="upload_minute_online" name="upload_minute_online">
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Attendance Sheet  <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="file" class="form-control" id="upload_attendance" name="upload_attendance">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Venue of Meeting  <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="text" class="form-control"
                                       name="meeting_venue" id="meeting_venue" placeholder="Enter Venue of meeting held">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Remarks  <span style="font-weight: bold; font-size: 18px; color: red">*</span></label>
                                <input type="text" class="form-control"
                                       name="meeting_remarks" id="meeting_remarks" placeholder="Enter Remarks">
                            </div>
                        </div>
                    </div>

                    <br>
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
                                        <input type="checkbox" class="checkBoxD selectMember" value="<?=$row->user_code?>" id="<?=$row->user_code?>" name="check_<?=$row->user_code?>">
                                    </td>
                                    <td><?=$row->name?>
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
                                        <input type="radio" name="attend_status_<?=$row->user_code?>"
                                               id="report_online<?=$i?>" value="<?=SDLAC_ATTEND_ONLINE?>" >&nbsp;<span style="color:green">
                                        Online</span>

                                        &nbsp;&nbsp;&nbsp;&nbsp;

                                        <input type="radio" name="attend_status_<?=$row->user_code?>" checked
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
                                Initiating the discussion, the Chairman placed the settlement proposals of the individuals for each Revenue Circle
                                under  <span style="font-weight:bold;" class="subDivName"></span> Sub-Division in front of
                                the SDLAC/CDLAC for discussion and consideration.

                                <br>
                                &nbsp; &nbsp; &nbsp; &nbsp;

                                After threadbare discussion, following settlement proposals submitted by the
                                Revenue Circle Officers under  <span style="font-weight:bold;" class="subDivName"></span>
                                Sub-Division are recommended
                                unanimously by the SDLAC/CDLAC subject to fulfillment of
                                extant guidelines laid down in Mission Basundhara, Land Policy, 2019 and verification of
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
                        <button type="submit" id="minutesGenerateModalYes" class="rezaButt rezaInfo">
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
                                Initiating the discussion, the Chairman placed the settlement proposals of the individuals for each Revenue Circle
                                under  <span style="font-weight:bold;" class="subDivName"></span> Sub-Division in front of
                                the SDLAC/CDLAC for discussion and consideration.

                                <br>
                                &nbsp; &nbsp; &nbsp; &nbsp;

                                After threadbare discussion, following settlement proposals submitted by the
                                Revenue Circle Officers under  <span style="font-weight:bold;" class="subDivName"></span>
                                Sub-Division are recommended
                                unanimously by the SDLAC/CDLAC subject to fulfillment of
                                extant guidelines laid down in Mission Basundhara, Land Policy, 2019 and verification of
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
                            6.	The Chairman / Mayor, <span id="municipalName" style="font-weight: bold"></span>, Municipal Board / Corporation.
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







<!--// NEW JS BY MASUD REZA-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

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

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    var selectedCheckBoxArray = [];
    $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
        var checkBoxId = $(this).val();
        var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
        if(this.checked && rowIndex === -1) {
            selectedCheckBoxArray.push(checkBoxId);
        }
        else if (!this.checked && rowIndex !== -1) {
            selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
        }
    });

    $("#checkedAll").click(function(){
        if(this.checked){
            $('.selectMark').each(function(){
                this.checked = true;
                var id = $(this).val();
                if($.inArray(id, selectedCheckBoxArray) !== -1){
                    // $('.selectMark').prop('checked', false);
                }else{
                    selectedCheckBoxArray.push(id);
                    $('.selectMark').prop('checked', true);
                }
            })
        }else{
            $('.selectMark').each(function(){
                this.checked = false;
                var id = $(this).val();
                var rowIndex = $.inArray(id, selectedCheckBoxArray);
                if(rowIndex == -1){

                }else{
                    selectedCheckBoxArray.splice(rowIndex, 1);
                    $('.selectMark').prop('checked', false);
                }
            })
        }
    });


    $("#datatable").on('draw.dt', function() {
        for (var i = 0; i < selectedCheckBoxArray.length; i++) {
            checkboxId = selectedCheckBoxArray[i];
            const myArray = checkboxId.split("/");
            var arr = myArray[3];
            $('#' + arr).attr('checked', true);
        }
    });


    //Add Nominee of SDLAC/CDLAC Member
    $('#addNomineeOfSdlacMembers').click(function(){
        $('#nomineeAddModal').modal('show');
    });

    //close nominee of SDLAC/CDLAC Member
    $('.closeNomineeModal').click(function(){
        $('#nomineeAddModal').modal('hide');
    });

    //insert nominee
    $('#insertNominee').click(function()
    {
        sdlac_mem     = $('#added_sdlac_member').val();
        nominee_name  = $('#added_nominee_name').val();
        nominee_cont  = $('#added_nominee_contact').val();
        nominee_email = $('#added_nominee_email').val();

        if(sdlac_mem == 'NA'){
            showWarningMessage("Select SDLAC/CDLAC Member");
            $('#added_sdlac_member').focus();
            return false;
        }

        if(nominee_name == ''){
            showWarningMessage("Enter Nominee Name");
            $('#added_nominee_name').focus();
            return false;
        }

        if(nominee_cont == ''){
            showWarningMessage("Enter Nominee Contact No");
            $('#added_nominee_contact').focus();
            return false;
        }

        const nominee_detail = {
            sdlac_mem     : sdlac_mem,
            nominee_name  : nominee_name,
            nominee_cont  : nominee_cont,
            nominee_email : nominee_email,
        };
        $.ajax({
            url: BASE_URL + "/SettlementProposalSdoController/insertNomineeDetailOfSdlacMember",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                if (data.responseType == 1) {
                    showErrorMessage(data.message);
                }
                else if (data.responseType == 2) {
                    $('#nomineeAddModal').modal('hide');
                    Swal.fire({
                        backdrop:true,
                        allowOutsideClick: false,
                        text: data.message,
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                        location.reload(true);
                    }
                });
                }
            },
            data: JSON.stringify(nominee_detail)
        });
    });

    $('#datatable').DataTable();

    load_data();

    // proposal list by ajax call
    function load_data()
    {
        var base_url      = "<?php echo base_url();?>";
        var proposal_no   = $('#by_pro_no').val();
        var service_name  = $('#by_service').val();
        var case_no       = $('#by_case_no').val();
        var cir_code      = $('#cir_id').val();

        if(cir_code != 0){
            var newcircle     = cir_code.split(",");
            cir_id            = $('#vill_id').val();
            var villcode      = cir_id.split(",");
            var circle        = newcircle[0];
            var subdiv        = newcircle[1];
            var mouza         = villcode[2];
            var lot           = villcode[3];
            var vill_id       = villcode[4];
        }

        $('#datatable').DataTable().destroy();

        var table = $('#datatable').DataTable({

            'pageLength' : 10,
            "processing" : true,
            "serverSide" : true,
            "searching"  : false,
            "ordering"   : false,
            "lengthMenu" : [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language'   : {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax'   : {
                url  : base_url+'index.php/SettlementProposalSdoController/listOfProposalsAllServices',
                type : 'POST',
                data : {
                    circle       : circle,
                    subdiv       : subdiv,
                    mouza        : mouza,
                    lot          : lot,
                    vill_id      : vill_id,
                    case_no      : case_no,
                    service_code : service_name,
                    proposal_no  : proposal_no,
                },
                deferLoading     : 57,
            },
            order: [[2, 'asc']],
            columnDefs: [{
                targets: 0,
                checkboxes: {
                    'selectRow': true
                },
                data: "is_visible",
                'render': function (data, type, row) {
                    let text = row[0];
                    return '<input type="checkbox" class="checkBoxD selectMark" value='+text+' id='+text+' name="selectMark[]">';
                }
            }],
        });
    }

    $('.search_button').click(function(){
        load_data();
    });


    var selectedCheckBoxArray = [];
    $('#datatable tbody').on('click', 'input[type="checkbox"]', function(e) {
        var checkBoxId = $(this).val();
        var rowIndex = $.inArray(checkBoxId, selectedCheckBoxArray);
        if(this.checked && rowIndex === -1) {
            selectedCheckBoxArray.push(checkBoxId);
        }
        else if (!this.checked && rowIndex !== -1) {
            selectedCheckBoxArray.splice(rowIndex, 1); // Remove it from the array.
        }
    });

    function openTab(id)
    {
        $.ajax({
            url: BASE_URL + "/SettlementProposalSdoController/getCasesAgainstProposalNo",
            dataType: "JSON",
            data: {id : id},
            type: "POST",
            success: function(data) {
                console.log(data.response[0]['case_no']);
                var cases=[];
                $.each(data.response, function (i, val) {
                    cases += '<br>' + val['case_no']
                });
                $('#list_of_cases_'+id).html(cases);
            }
        });
    }

</script>

<script type="text/javascript">

    var BASE_URL = $("#getBaseURL").val();

    //close modal
    $('.closeFinalModal').click(function(){
        $('#finalSubmissionModal').modal('hide');
    });

    $("#openModalForFinalSubmit").click(function()
    {

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        var selectedList = [];
        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        if (selectedList.length > 0)
        {
            const applicant = {
                selectedList: selectedCheckBoxArray
            };

            $.ajax({
                url: BASE_URL + "/SettlementProposalSdoController/checkAllSdlacPresentMember",
                type: "post",
                dataType: "json",
                contentType: "application/json",
                success: function (data) {
                    $.unblockUI();
                    // console.log(data);
                    if (data.responseType == 1)
                    {
                        showErrorMessage("There is some problem, Please try again");
                    }
                    else if (data.responseType == 2)
                    {
                        for(var i =0;i<(data.memberPresents.length) ; i++)
                        {
                            $("#" + data.memberPresents[i].user_code).prop("checked", true);
                            $("#select_nominee_" + data.memberPresents[i].user_code).val(data.memberPresents[i].nominee).attr("selected", "selected");

                        }
                        $('#finalSubmissionModal').modal('show');
                    }
                    else if (data.responseType == 3)
                    {
                        showErrorMessage(data.message);
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
            showErrorMessage("Please Select Proposal  !")
        }


    });


    // print notice
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();
        document.body.innerHTML = originalContents;


    }




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

        if($('#upload_attendance').val() == '') {
            showErrorMessage('Attendance Sheet is mandatory');
            $('#upload_attendance').focus();
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

        var selectedList = [];
        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        var uploadedFile = new FormData();

        uploadedFile.append("upload_minute_online", $('#upload_minute_online')[0].files[0]);
        uploadedFile.append("upload_attendance", $('#upload_attendance')[0].files[0]);
        uploadedFile.append("meeting_date", $('#meeting_date').val());
        uploadedFile.append("meeting_venue", $('#meeting_venue').val());
        uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());

        //list of proposals selected
        uploadedFile.append("proposals", JSON.stringify(selectedCheckBoxArray));

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

        if (selectedList.length > 0)
        {
            $.ajax({
                url: BASE_URL + "/SettlementProposalSdoController/sendProposalsToDcMinute",
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
                                // console.log(dd);

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
        }
        else
        {
            $.unblockUI();
            showErrorMessage("Please Select Proposal !");
        }
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

        if($('#upload_attendance').val() == '') {
            showErrorMessage('Attendance Sheet is mandatory');
            $('#upload_attendance').focus();
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

        var selectedList = [];
        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        var uploadedFile = new FormData();

        uploadedFile.append("upload_minute_online", $('#upload_minute_online')[0].files[0]);
        uploadedFile.append("upload_attendance", $('#upload_attendance')[0].files[0]);
        uploadedFile.append("meeting_date", $('#meeting_date').val());
        uploadedFile.append("meeting_venue", $('#meeting_venue').val());
        uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());

        //list of proposals selected
        uploadedFile.append("proposals", JSON.stringify(selectedCheckBoxArray));

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

        if (selectedList.length > 0)
        {
            $.ajax({
                url: BASE_URL + "/SettlementProposalSdoController/sendProposalsToDcMinute",
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
        }
        else
        {
            $.unblockUI();
            showErrorMessage("Please Select Proposal !");
        }
    });






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

            if($('#upload_attendance').val() == '') {
                showErrorMessage('Attendance Sheet is mandatory');
                $('#upload_attendance').focus();
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

            var selectedList = [];

            $('.selectMark:checked').each(function(i){
                selectedList[i] = $(this).val();
            });

            var uploadedFile = new FormData();

            uploadedFile.append("upload_minute_online", $('#upload_minute_online')[0].files[0]);
            uploadedFile.append("upload_attendance", $('#upload_attendance')[0].files[0]);
            uploadedFile.append("meeting_date", $('#meeting_date').val());
            uploadedFile.append("meeting_venue", $('#meeting_venue').val());
            uploadedFile.append("meeting_remarks", $('#meeting_remarks').val());
            uploadedFile.append("meeting_id", $('#meeting_id').val());

            //list of proposals selected
            uploadedFile.append("proposals", JSON.stringify(selectedCheckBoxArray));

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

            if (selectedList.length > 0)
            {
                $.ajax({
                    url: BASE_URL + "/SettlementProposalSdoController/sendProposalsToDc",
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
            else
            {
                $.unblockUI();
                showErrorMessage("Please Select Case !");
            }
        }

    });


    $('#minutesGenerateModalNo').click(function(){
        $('#finalSubmissionModal').modal('hide');
        $('#minutesGenerateModal').modal('hide');
    });


    // close print Minutes
    $('#printMinutesModalNo').click(function(){
        $('#finalSubmissionModal').modal('hide');
        $('#printMinutesModal').modal('hide');
    });
</script>

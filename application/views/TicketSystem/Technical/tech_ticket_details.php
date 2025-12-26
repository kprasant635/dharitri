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
    .buttInfo {
        color: #FFF;
        background-color: #03a9f4;
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

    #files-area {
        width: 100%;
        margin: 0 auto;
    }
    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;
    }
    .file-block > span.name {
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        width: max-content;
        display: inline-flex;
    }

    .file-delete {
        display: flex;
        width: 24px;
        padding-top: 3px;
        color: red;
        background-color: #6eb4ff00;
        font-size: large;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;
    }
    .card-subtitle{
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 15px;
    }
</style>

<style>
    .timeline {
        max-width: 830px;
        margin: 0px auto;
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 15px 0px;
    }
    .timeline::after {
        content: "";
        position: absolute;
        width: 3px;
        background-color: #848892;
        height: 100%;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
    }
    .timeline__content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 18px 30px;
        background-color: white;
        border-radius: 5px;
        position: relative;
        width: 386px;
        box-shadow: 0 2px 8px 0 #242e4c59;
    }
    .timeline__content::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: white;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
    }
    .timeline__content::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #848892;
        border-radius: 50%;
        transform: translateY(-50%);
    }
    .timeline__content:nth-child(odd) {
        margin-left: auto;
    }
    .timeline__content:nth-child(odd) .content_tag {
        right: 5px;
    }
    .timeline__content:nth-child(odd)::after {
        left: -10px;
    }
    .timeline__content:nth-child(odd)::before {
        top: 50%;
        left: -39px;
    }
    .timeline__content:nth-child(even) {
        align-items: flex-end;
    }
    .timeline__content:nth-child(even) .content_p {
        text-align: right;
    }
    .timeline__content:nth-child(even)::after {
        right: -10px;
    }
    .timeline__content:nth-child(even)::before {
        top: 50%;
        right: -39px;
    }
    .timeline__content:nth-child(even) .content_tag {
        left: 5px;
    }

    .content_tag {
        position: absolute;
        top: 5px;
        padding: 6px 10px;
        background-color: #66BB6A;
        border-radius: 3px;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
    }

    .content_date {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;
        color: #848892;
    }
    .content_p {
        color: #242e4c;
        max-width: 230px;
        margin-bottom: 20px;
    }
    .content_link {
        display: inline-flex;
        text-decoration: none;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
        color: #1f1f1f;
    }
    .content_link svg {
        margin-left: 5px;
    }
    .content_link:hover {
        color: royalblue;
        transition-duration: 300ms;
    }
    .content_link:hover svg path {
        fill: royalblue;
    }

    @media screen and (max-width: 600px) {
        .timeline {
            gap: 15px;
            padding: 10px;
        }
        .timeline::after {
            display: none;
        }
        .timeline__content {
            width: 100%;
        }
        .timeline__content::after {
            display: none;
        }
        .timeline__content::before {
            display: none;
        }
    }

    #files-area {
        width: 100%;
        margin: 0 auto;
    }
    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;
    }
    .file-block > span.name {
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        width: max-content;
        display: inline-flex;
    }

    .file-delete {
        display: flex;
        width: 24px;
        padding-top: 3px;
        color: red;
        background-color: #6eb4ff00;
        font-size: large;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;
    }

</style>

<style>
    .card-header{
        background-color: #1f91f3;
        display: block;
        padding-left: 8px;
        padding-bottom: 5px!important;
        padding-top: 0px!important;
        font-size: 17px!important;
    }
    .panel-group .panel-title a{
        display: block;
        padding: 8px 0;
        font-size: 17px!important;
    }

    .testDc{
        text-decoration:none!important;
        color: white!important;
        font-weight: bolder;
    }
    .cardBorder{
        border: 1px solid #1f91f3;
        margin-bottom: 10px;
        border-radius: 4px!important;
    }

    #files-area {
        width: 100%;
        margin: 0 auto;
    }
    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;
    }
    .file-block > span.name {
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        width: max-content;
        display: inline-flex;
    }

    .file-delete {
        display: flex;
        width: 24px;
        padding-top: 3px;
        color: red;
        background-color: #6eb4ff00;
        font-size: large;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;
    }

    .modal .modal-header {
        border: none;
        padding: 10px 10px 10px 10px;
        font-size: 15px;
    }

    .modal-header {
        background-color: #9C27B0;
        color: white;
    }
    .collapsible-link {
        width: 100%;
        position: relative;
        text-align: left;
    }

    .collapsible-link::before {
        content: "\f107";
        position: absolute;
        top: 50%;
        right: 0.8rem;
        transform: translateY(-50%);
        display: block;
    }

    .collapsible-link[aria-expanded="true"]::before {
        content: "\f106";
    }
</style>

<div class="row" style='padding: 10px 20px 20px 0px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>
            <br>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
            <br>
        <?php } ?>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            <?php echo $this->lang->line('TicketSidebar') ?> /
            <a href="<?= base_url()?>index.php/TicketCommonController/getTicketSystemDashboard">
                Dashboard
            </a>
            /
            <?php if($ticket->ticket_status == TICKET_STATUS_PENDING) : ?>
                <a href="<?= base_url()?>index.php/TicketTechnicalController/getAllPendingTicketListForCo">
                    <?php echo $this->lang->line('TicketTechPendingMy') ?>
                </a>
            <?php elseif($ticket->ticket_status == TICKET_STATUS_CLOSED) : ?>
                <a href="<?= base_url()?>index.php/TicketTechnicalController/getAllClosedTicketListForCo">
                    <?php echo $this->lang->line('TicketTechClosedMy') ?>
                </a>
            <?php elseif($ticket->ticket_status == TICKET_STATUS_REJECTED) : ?>
                <a href="<?= base_url()?>index.php/TicketTechnicalController/getAllRejectedTicketListForCo">
                    <?php echo $this->lang->line('TicketTechRejectedMy') ?>
                </a>
            <?php else: ?>
                <?php echo $this->lang->line('TicketTechPending') ?>
            <?php endif; ?>
            / Ticket Details

            <a href="<?= base_url()?>index.php/Home/index">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>


        <div class="reza-card">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="reza-title">
                        <span><?php echo $this->lang->line('TicketTechDetails') ?></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" align="right" style="padding-top: 15px; padding-right: 25px">
                    <?php if($ticket->ticket_status == TICKET_STATUS_PENDING): ?>
                        <?php if($ticket->user_code == $this->session->userdata('user_code')): ?>
                            <button class="rezaButt buttPrimary" id="closeTicket">
                                <i class="fa fa-refresh" aria-hidden="true"></i> Close Ticket
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>

                    <input type="hidden" id="ticketId" name="ticketId" value="<?php echo base64_encode($ticket->ticket_id); ?>">
                </div>
            </div>
            <hr style="margin-top: 0px; margin-bottom: 15px">
            <br>
            <div class="reza-body">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12" style="margin-top: -15px">
                            <div id="accordionExample" class="accordion">
                                <div class="cardBorder">
                                    <div id="headingOne" class="card-header">
                                        <h2 class="mb-0">
                                            <a type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"  aria-controls="collapseOne"
                                               class="testDc btn btn-link text-uppercase collapsible-link">
                                                <i class="fa fa-bug"></i>&nbsp;
                                                <span> Ticket Details </span>
                                            </a>
                                        </h2>
                                    </div>
                                    <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse show">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>
                                                        <td>Application Type</td>
                                                        <td><?php echo $ticket->application_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 30%">Ticket Type</td>
                                                        <td>Technical Ticket</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Service Type</td>
                                                        <td><?php echo $ticket->service_name ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ticket Code</td>
                                                        <td style="font-weight: bold"><?php echo $ticket->t_unicode ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Reference Case No.</td>
                                                        <td><?php echo $ticket->ref_case_no ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Subject</td>
                                                        <td style="font-weight: bolder;" >
                                                            <?php echo $ticket->subject ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ticket Status</td>
                                                        <td>
                                                            <?php if($ticket->draft_status == TICKET_DRAFT_STATUS_YES) : ?>

                                                                <?php echo 'Draft'?>

                                                            <?php else : ?>

                                                                <?php echo 'Submitted'?>

                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ticket Submit On</td>
                                                        <td><?php echo date("d-m-Y", strtotime($ticket->created_at ))?></td>
                                                    </tr>
                                                    <?php if($ticket->ticket_status== TICKET_STATUS_PENDING) : ?>
                                                        <tr>
                                                            <td>Process Status</td>
                                                            <?php if($ticket->a_status == 1) : ?>
                                                                <!--<td style="font-weight: bolder; color: #673AB7">-->
                                                                <!--    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> On Queue-->
                                                                <!--</td>-->
                                                                <td style="font-weight: bolder; color: #009688">
                                                                    <i class="fa fa-cog fa-spin fa-fw"></i> Under Process
                                                                </td>
                                                            <?php elseif($ticket->a_status == 2) : ?>
                                                                <td style="font-weight: bolder; color: #009688">
                                                                    <i class="fa fa-cog fa-spin fa-fw"></i> Under Process
                                                                </td>
                                                            <?php else : ?>
                                                                <td style="font-weight: bolder; color: #37474F">
                                                                    <i class="fa fa-spinner fa-pulse fa-fw"></i> Pending
                                                                </td>
                                                            <?php endif ;?>
                                                        </tr>

                                                    <?php elseif($ticket->ticket_status== TICKET_STATUS_REJECTED) : ?>
                                                        <tr>
                                                            <td>Process Status</td>
                                                            <td style="font-weight: bolder; color: #EF5350 ">
                                                                Rejected
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td>Rejected Remarks </td>
                                                            <td style="color: #EF5350 ">
                                                                <?php echo $ticket->pro_note; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ticket Rejected On</td>
                                                            <td><?php echo date("d-m-Y", strtotime($ticket->closed_on ))?></td>
                                                        </tr>
                                                        <!--<tr>-->
                                                        <!--    <td>Total Process Days</td>-->
                                                        <!--    <td>--><?php //echo $ticket->pro_time ?><!-- Days</td>-->
                                                        <!--</tr>-->

                                                    <?php elseif($ticket->ticket_status== TICKET_STATUS_CLOSED) : ?>
                                                        <tr>
                                                            <td>Process Status</td>
                                                            <td style="font-weight: bolder; color: #388E3C ">
                                                                Closed
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ticket Closed On</td>
                                                            <td><?php echo date("d-m-Y", strtotime($ticket->closed_on ))?></td>
                                                        </tr>
                                                        <!--<tr>-->
                                                        <!--    <td>Total Process Days</td>-->
                                                        <!--    <td>--><?php //echo $ticket->pro_time ?><!--</td>-->
                                                        <!--</tr>-->
                                                    <?php else :?>
                                                        <tr>
                                                            <td>Process Status</td>
                                                            <td style="font-weight: bolder; color: #7E57C2 ">
                                                                Under Process
                                                            </td>
                                                        </tr>

                                                    <?php endif; ?>

                                                    <tr>
                                                        <td> Attachment </td>
                                                        <td>
                                                            <?php if(count($attachments) == 0) : ?>
                                                                No Attachment Found !
                                                            <?php else :?>
                                                                <table class="table " style="width: 100%">
                                                                    <tbody>
                                                                    <?php $i = 1;?>
                                                                    <?php foreach ($attachments as $attachment): ?>
                                                                        <tr>
                                                                            <td><?php echo $i. '.  ' ?></td>
                                                                            <td>
                                                                                <?php echo $attachment->file_name ?>
                                                                            </td>
                                                                            <td>
                                                                                <a type="button" href="<?php echo base_url(); ?>index.php/TicketCommonController/getViewTicketUploadedDoc/?fileId=<?php echo $attachment->id; ?>&type=1"
                                                                                   class="rezaButt buttCust btn-sm" target="ViewDocument" style="color: white!important; font-size: 17px!important; line-height: inherit">
                                                                                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $i++ ?>
                                                                    <?php endforeach ?>
                                                                    </tbody>

                                                                </table>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Ticket Details</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <textarea id="ckeditor" readonly>
                                                                <?php echo $ticket->details ?>
                                                            </textarea>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="cardBorder">
                                    <div id="headingTwo" class="card-header ">
                                        <h2 class="mb-0">
                                            <a type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                               aria-controls="collapseTwo"  class="testDc btn btn-link text-uppercase collapsible-link">
                                                <i class="fa fa-history"></i>&nbsp;
                                                <span> Ticket History </span>
                                            </a>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample" class="collapse">
                                        <div class="card-body p-5">
                                            <div class="panel-body" id="co-2">
                                                <div class="timeline">
                                                    <?php foreach ($histories as $history): ?>
                                                        <?php if($history->action_status =='Rejected'): ?>
                                                            <div class="timeline__content" style="background-color: #EF5350">
                                                            <span class="content_tag" style="margin-top: 15px; background-color: white; color: #EF5350">
                                                                Ticket <?php echo $history->action_status ?>
                                                            </span>
                                                                <span class="content_date" style="color: white; margin-top: 7px">
                                                            <?php echo date("F j, Y", strtotime($history->action_date ))?>
                                                            </span>
                                                            </div>
                                                        <?php elseif($history->action_status =='Closed'): ?>
                                                            <div class="timeline__content" style="background-color: #4CAF50">
                                                            <span class="content_tag" style="margin-top: 15px; background-color: white; color: #4CAF50">
                                                                Ticket <?php echo $history->action_status ?>
                                                            </span>
                                                                <span class="content_date" style="color: white; margin-top: 7px">
                                                            <?php echo date("F j, Y", strtotime($history->action_date ))?>
                                                            </span>
                                                            </div>
                                                        <?php elseif($history->action_status =='Pending'): ?>
                                                            <div class="timeline__content">
                                                                <?php if($history->assign_status == 'Forwarded'): ?>
                                                                    <span class="content_tag" style="color: black">
                                                                        Ticket <?php echo $history->assign_status ?>
                                                                    </span>

                                                                <?php else: ?>
                                                                    <span class="content_tag" style="color: white; background-color: #4CAF50">
                                                                        Ticket <?php echo $history->assign_status ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                                <span class="content_date">
                                                            <?php echo date("F j, Y", strtotime($history->assign_date ))?>
                                                            </span>
                                                                <p class="content_p">
                                                                    Forwarded To
                                                                    <br>
                                                                    <b><?php echo $history->assign_to ?></b>
                                                                </p>

                                                                <?php
                                                                $crtDateH = date("Y-m-d", strtotime($history->assign_date ));
                                                                if($history->action_date ==NULL)
                                                                {
                                                                    $intervalH = 0;
                                                                }
                                                                else
                                                                {
                                                                    $sumDateH  = date("Y-m-d", strtotime($history->action_date ));
                                                                    $dateH1 = new DateTime($crtDateH);
                                                                    $dateH2 = new DateTime($sumDateH);
                                                                    $intervalH = $dateH1->diff($dateH2);
                                                                }

                                                                ?>
                                                                <p class="content_p">
                                                                    Processed Time
                                                                    <br>
                                                                    <b style="text-transform: capitalize">
                                                                        <?php
                                                                        if($history->action_date ==NULL)
                                                                        {
                                                                            Echo 'Under Process';
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $intervalH->days. ' Days';
                                                                        }
                                                                        ?>
                                                                    </b>
                                                                </p>
                                                                <p class="content_p">
                                                                    Priority -

                                                                    <b style="text-transform: capitalize">
                                                                        <?php if($history->priority == 'low') : ?>
                                                                            <span style="color: #EF9A9A">Low</span>
                                                                        <?php elseif($history->priority == 'medium') : ?>
                                                                            <span style="color: #EF5350">Medium</span>
                                                                        <?php elseif($history->priority == 'high') : ?>
                                                                            <span style="color: #E53935">High</span>
                                                                        <?php elseif($history->priority == 'immediate') : ?>
                                                                            <span style="color: #D50000">Immediate</span>
                                                                        <?php else: ?>
                                                                            <span >Not Set</span>
                                                                        <?php endif ?>
                                                                    </b>
                                                                </p>

                                                            </div>

                                                            <?php $priorityVal = ''  ?>
                                                            <?php if($priorityVal == NULL): ?>
                                                                <?php $priorityVal = $history->priority; ?>
                                                            <?php endif; ?>
                                                        <?php elseif($history->action_status == 'Added'): ?>
                                                            <div class="timeline__content">
                                                                <span class="content_tag" style="background-color: #AB47BC; color: white"> Ticket Added</span>
                                                                <span class="content_date" >
                                                            <?php echo date("F j, Y, g:i a", strtotime($ticket->created_at ))?>
                                                        </span>
                                                                <p class="content_p">
                                                                    Added By
                                                                    <br>
                                                                    <b><?php echo $history->assign_from ?></b>
                                                                </p>

                                                            </div>
                                                        <?php else : ?>
                                                        <?php endif; ?>

                                                    <?php endforeach; ?>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="cardBorder">
                                    <div id="headingThree" class="card-header border-0">
                                        <h2 class="mb-0">
                                            <a type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                               aria-controls="collapseThree" class="testDc btn btn-link collapsed text-uppercase collapsible-link">
                                                <i class="fa fa-commenting-o"></i>&nbsp;
                                                <span> Comments </span>
                                            </a>
                                        </h2>
                                    </div>
                                    <div id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionExample" class="collapse">
                                        <div class="panel-body" id="co-3">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    Total Comment -
                                                    <b><?php echo count($comments) ?> </b>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" align="right">
                                                    <?php if($ticket->ticket_status == TICKET_STATUS_PENDING) :?>
                                                        <button type="button" data-color="purple" class="btn bg-purple waves-effect" data-toggle="modal" data-target="#defaultModal">
                                                            <i class="fa fa-plus-circle"></i>
                                                            <span class="icon-name"> Add Comment </span>
                                                        </button>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <?php $kaif = 1?>
                                            <?php foreach ($comments as $comment): ?>

                                                <div class="row" style="padding: 15px; margin-bottom: 30px" >
                                                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3" align="center" style="padding: 10px">
                                                        <div class="image" style="margin-bottom: 5px">
                                                            <img src="<?php echo base_url();?>assets/user.png" width="100%" height="100%" alt="User" style="border-radius: 50%;" />
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-11 col-md-11 col-sm-9 col-xs-9">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " align="left">
                                                                <span  style="font-weight: bold; color: #1976D2; font-size: 18px">
                                                                    <?php echo $comment->comment_by ?>
                                                                </span>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " align="right">
                                                                <?php echo date("F j, Y, g:i a", strtotime($comment->created_at ))?>
                                                            </div>
                                                        </div>
                                                        <div style="border-bottom: 1px solid #BBDEFB">
                                                            <p style="text-align: justify; margin-bottom: 25px">
                                                                <?php echo $comment->comment_details ?>
                                                            </p>

                                                            <?php if($comment->file_name != NULL): ?>
                                                                <br>
                                                                <a href="<?php echo base_url(); ?>index.php/TicketCommonController/getViewTicketCommentDoc/?fileId=<?php echo $comment->id; ?>&type=1"
                                                                   class="rezaButt buttCust btn-sm " target="ViewDocument">
                                                                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download Attachment
                                                                </a>
                                                                <br><br>
                                                            <?php endif?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add comment-->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document" style=" width: 750px!important; margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel" style="font-size: 19px">Add Comment </h4>
            </div>
            <h6 class="card-subtitle" style="margin-top: 15px"><code> All fields marked with asterisks(*) are required  </code></h6>
            <form id="form_validation" action="<?php echo base_url() ?>index.php/TicketTechnicalController/addCommentOnTechnicalTicket" enctype="multipart/form-data" method="POST">

                <input type="hidden" name="tId" value="<?php echo base64_encode($ticket->ticket_id)?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Your Comment  <span style="color:red;">*</span></label>
                                    <textarea  rows="5" type="text" class="form-control" name="comment" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top: 20px">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <div class="form-line">
                                        <label class="form-label">Attachment (If any, Accepted file type <?php echo UPLOAD_TYPE_VALIDATION_SHOW ?> only) </label>
                                        <div class="" id="frmFileUpload">
                                            <p class="mt-1">
                                                <label for="attachment">
                                                    <a class="btn bg-purple waves-effect text-light" role="button" aria-disabled="false">
                                                        <i class="fa fa-paperclip"></i>
                                                        <span class="icon-name"> Add Attachment </span>
                                                    </a>
                                                </label>
                                                <input type="file" name="attachment" accept="image/x-png,image/gif,image/jpeg,application/pdf" id="attachment" style="visibility: hidden; position: absolute;" />
                                            </p>
                                            <p id="files-area">
                                                <span id="filesList">
                                                    <span id="files-names"></span>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect">SUBMIT</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal for confirmation -->
<div class="modal" role="dialog" id="submitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Close Technical Ticket</h5>
            </div>
            <div class="modal-body" align="center">
                <h3>Are You Sure !</h3>
                <br>
                <h5>You want to close this Ticket ?. You wont be able to undo this once done</h5>
                <br>
                <hr>
                <br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="left">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">Remarks <span style="color:red;">*</span></label>
                                <textarea  rows="5" type="text" class="form-control" id="remarks" name="remarks" required></textarea>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="submitModalNo">NO</button>
                <button type="button" class="btn btn-primary" id="submitModalYes">YES, CLOSE</button>
            </div>
        </div>
    </div>
</div>


<!--Masud Script-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>


<!-- Ckeditor -->
<script src="<?php echo base_url();?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url();?>assets/js/pages/forms/editors.js"></script>
<script>
    CKEDITOR.replace('ckeditor', {
        height: 300,
        // Custom toolbar
        toolbar: [
            { name: 'clipboard', items: ['Undo', 'Redo', 'Paste', 'PasteText'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'HorizontalRule'] },
            { name: 'links', items: ['Unlink'] },
            { name: 'insert', items: ['Table'] },
            { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize'] }
        ],
        // Remove unwanted plugins
        removePlugins: 'image,flash,smiley,specialchar,sourcearea,maximize',
        resize_enabled: true
    });
</script>
<script>
    function showSuccessMessage(text) {
        swal.fire({
            backdrop:true,
            allowOutsideClick: false,
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
            backdrop:true,
            allowOutsideClick: false,
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }

    var BASE_URL = $("#getBaseURL").val();

    const dt = new DataTransfer();

    $("#attachment").on("change", function (e) {

        var mm = 0;
        for (var i = 0; i < this.files.length; i++ ) {
            mm++;
            var fileBloc = $("<span/>", { class: "file-block" }),
                fileName = $("<span/>", { class: "name", text: this.files.item(i).name });
            fileBloc
                .append('<span class="file-delete"><span>' + mm+'.'+'</span></span>')
                .append(fileName);
            $("#filesList > #files-names").append(fileBloc);
        }

    });


    $(document).on('click','#closeTicket',function ()
    {
        $('#submitModal').modal('show');
    });

    $(document).on('click','#submitModalNo',function ()
    {
        $('#submitModal').modal('hide');
    });

    // closed ticket by reporter
    $(document).on('click','#submitModalYes',function ()
    {
        $('#submitModal').modal('hide');
        var ticketId = $("#ticketId").val();
        var remarks  = $("#remarks").val();

        if(ticketId == '')
        {
            showErrorMessage("There is some problem ! Please contact with Administration. !");
            return false;
        }
        if(remarks == '')
        {
            showErrorMessage("Please Enter Some Remarks !");
            return false;
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border: 'none',
                backgroundColor: 'transparent'
            }
        });

        const applicant = {
            ticketId: ticketId,
            remarks: remarks

        };

        $.ajax({
            url: BASE_URL + "/TicketTechnicalController/closeTicketByTicketReporter",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data) {
                $.unblockUI();
                if (data.responseType == 1)
                {
                    $('#submitModal').modal('hide');

                    showErrorMessage(data.message);
                    data.validation.forEach(function(validation)
                    {
                        var errMsg = "#" + validation.field + "Err";
                        $(errMsg).text("⚠️ " + validation.message);

                    });
                }
                else if (data.responseType == 2)
                {
                    Swal.fire({
                        icon              : 'success',
                        backdrop          : true,
                        allowOutsideClick : false,
                        text              : data.message,
                        showCancelButton  : true,
                        confirmButtonText : 'CONFIRM',
                    }).then((result) => {
                        location.reload();
                })
                }
            },
            data: JSON.stringify(applicant),
            error:function(data){
                $.unblockUI();
                showErrorMessage("Something went wrong");
            }
        });
    });


</script>






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
        padding-bottom: 20px;
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
    label{
        padding-bottom: 5px;
        font-weight: bold;
    }

    #searchBox{
        padding: 15px;
        border: 1px solid #00BCD4;
        margin: 0px;
    }
    #cases_wrapper {
         margin-top: 0px !important;
    }

    /*.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {*/
        /*display: none;*/
    /*}*/


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                <hr style="margin-bottom: -5px">
            </div>

            <div class="reza-body">

                <form action="<?php echo base_url(); ?>index.php/SettlementCommonDc/searchCasesWithData" method="post">

                    <div class="row" id="searchBox">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="caseNo"><?= $this->lang->line('case_no') ?></label>
                                <input type="text" class="form-control" name="caseNo" id="caseNo">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="serviceType"><?= $this->lang->line('serviceType') ?></label>
                                <select class="form-select" aria-label="Default select example" name="serviceType" id="serviceType">
                                    <option selected disabled>Select</option>
                                    <option value="<?= SETTLEMENT_AP_TRANSFER_ID ?>">
                                        <?= $this->lang->line('settlementAPSelect') ?>
                                    </option>
                                    <option value="<?= SETTLEMENT_TRIBAL_COMMUNITY_ID ?>">
                                        <?= $this->lang->line('settlementTribalCommunityTitle') ?>
                                    </option>
                                    <option value="<?= SETTLEMENT_KHAS_LAND_ID ?>">
                                        <?= $this->lang->line('khasLand') ?>
                                    </option>
                                    <option value="<?= SETTLEMENT_PGR_VGR_LAND_ID ?>">
                                        <?= $this->lang->line('pgrVgrTitle') ?>
                                    </option>
                                    <option value="<?= SETTLEMENT_SPECIAL_CULTIVATORS_ID ?>">
                                        <?= $this->lang->line('specialCultivatorsSelect') ?>
                                    </option>
                                    <option value="<?= SETTLEMENT_TENANT_ID ?>">
                                        <?= $this->lang->line('settlementOccupancyTenant') ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="appStatus"><?= $this->lang->line('appStatus') ?></label>
                                <select class="form-select" aria-label="Default select example" name="appStatus" id="appStatus">
                                    <option selected disabled>Select</option>
                                    <option value="<?= MB_PENDING ?>">Pending </option>
                                    <option value="<?= MB_DISMISS ?>">Rejected</option>
                                    <option value="<?= MB_FINAL ?>">Approved</option>
                                    <option value="<?= MB_PAYMENT_REQUEST ?>">Payment Request</option>
                                    <option value="<?= MB_PAYMENT_RECEIVED ?>">Payment Received</option>
                                    <option value="<?= MB_UNDER_PROCESS_AFTER_PAYMENT ?>">Under Process After Payment</option>
                                    <option value="<?= MB_PAYMENT_NOTICE ?>">Payment Notice</option>
                                    <option value="<?= MB_REVERT ?>">Reverted</option>
                                    <option value="<?= MB_APPLICANT_NOTICE ?>">Applicant Notice</option>
                                    <option value="<?= MB_NOTICE_SERVED ?>">Notice Served</option>
                                    <option value="<?= MB_RE_REPORT ?>">Re Report </option>
                                    <option value="<?= MB_MARK_AS_SDLAC ?>">Mark As SDLAC </option>
                                    <option value="<?= MB_SEND_TO_SDLAC ?>">Send to SDLAC </option>
                                    <option value="<?= MB_ORDER_FOR_CHITHA_UPDATE ?>">Chitha Update</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="pendingOffice"><?= $this->lang->line('pendingOffice') ?></label>
                                <select class="form-select" aria-label="Default select example" name="pendingOffice" id="pendingOffice">
                                    <option selected disabled>Select</option>
                                    <option value="<?= MB_DEPUTY_COMM ?>">DC </option>
                                    <option value="<?= MB_CIRCLE_OFFICER ?>">CO </option>
                                    <option value="<?= MB_LOT_MONDOL ?>">LM </option>
                                    <option value="<?= MB_DEPARTMENT ?>">Department </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="fromDate"><?= $this->lang->line('fromDate') ?></label>
                                <input type="date" class="form-control" name="fromDate" id="fromDate">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="toDate"><?= $this->lang->line('toDate') ?></label>
                                <input type="date" class="form-control" name="toDate" id="toDate">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="selectCircle"><?= $this->lang->line('circle') ?></label>
                                <select class="form-select" aria-label="Default select example" name="selectCircle" id="selectCircle">
                                    <option selected disabled>Select</option>
                                    <?php foreach ($circles as $circle): ?>
                                        <option value="<?= $circle->cir_code ?>"> <?= $circle->locname_eng ?> ( <?= $circle->loc_name ?> )</option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="row" style="margin-top: 15px" align="right">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="rezaButt buttInfo" id="" style="width: 200px">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <?php echo $this->lang->line('caseSearch') ?>
                            </button>
                        </div>
                    </div>
                </form>



            </div>

        </div>

    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                        <span><?php echo $this->lang->line('caseList') ?></span>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12" align="right">

                    </div>
                </div>

                <hr style="margin-bottom: -5px">
            </div>

            <div class="reza-body" id="showBody">

                <?php if($casesCount == 0): ?>
                    <div style="margin-top: 15px" id="searchText">No Data Found !</div>
                <?php else: ?>
                    <table class='table table-striped table-bordered' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                        </tr>
                        </thead>
                        <tbody id="caseTable">

                        <?php $i= 1; foreach ($cases as $case) : ?>

                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $case->case_no ?></td>
                            <td>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?= date ("j F, Y",strtotime($case->submission_date)) ?>
                            </td>
                            <td>
                                <a class="rezaButt" href="<?php echo base_url(); ?>index.php/SettlementCommonDc/viewApplicationDetailsOnly/?case=<?php echo $case->case_no; ?>" >
                                    <i class="fa fa-eye"></i>&nbsp;view
                                </a>
                            </td>
                        </tr>

                        <?php $i = $i + 1; ?>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>



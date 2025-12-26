<style>
    .reza-card 
    {
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



</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="reza-card">
            <div class="reza-title">
                <span>Application Search </span>
                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

                <hr style="margin-bottom: -5px">
            </div>

            <div class="reza-body">

                <form action="<?php echo base_url(); ?>index.php/SettlementCommonDc/searchCasesWithData" method="post">

                    <div class="row" id="searchBox">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="caseNo"><?= $this->lang->line('case_no') ?></label>
                                <input type="text" class="form-control" name="caseNo" id="caseNo" placeholder="Eg: - KAM/PAL/2022-23/0000/SKHAS">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="caseNo">Application No</label>
                                <input type="text" class="form-control" name="applicationNo" id="applicationNo" placeholder="Eg: - RTPS/SKCSL/2023/00000">
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
                                    <option value="<?= MB_ADD_DEPUTY_COMM ?>">ADC </option>
                                    <option value="<?= MB_SUB_DIV_COMM ?>">SDO </option>
                                    <option value="<?= MB_CIRCLE_OFFICER ?>">CO </option>
                                    <option value="<?= MB_SUPERVISOR_KANANGU ?>">SK </option>
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
                    <div class="col-lg-12">
                        <span>List of Attachment(s) for Application No : RTPS-OMUT/2022/12649</span>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12" align="right">

                    </div>
                </div>

                <hr style="margin-bottom: -5px">
            </div>

            <div class="reza-body" id="showBody">
                <table class='table table-striped table-bordered' id='cases' width="100%">
                    <thead>
                    <tr>
                        <th class="center">#</th>
                        <th><label class="control-label">File Name</label></th>
                        <th class="center">View</th>
                    </tr>
                    </thead>
                    <tbody id="caseTable">

                    <?php 

                        $i= 1; 
                        foreach ($files as $file) :   

                        $refNo = "RTPS-OMUT/2022/12649";
                        $type  = 4;
                        $data  = $file->path;
                    ?>

                    <tr>
                        <td class="center"><?= $i ?></td>
                        <td>
                            <?= $file->doc_name ?>
                        </td>
                        <td class="center">
                            <a class="rezaButt" href="<?php echo base_url(); ?>index.php/Serviceplus/print_pdf?refNo=<?=$refNo?>&type=<?=$type?>&data=<?=$data?>" target="_doc">View Document</a>
                        </td>
                    </tr>

                    <?php $i = $i + 1; ?>
                    <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

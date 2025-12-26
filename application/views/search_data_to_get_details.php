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
</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php if($this->session->flashdata('message')):?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                </div>
            <?php endif;?>
        </div>



        <div class="reza-card">
            <div class="reza-title">
                <span>Application Search </span>
                <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
                <hr style="margin-bottom: -5px">
            </div>

            <div class="reza-body">

                <!-- <form action="<?php //echo base_url(); ?>index.php/SearchingController/getSearchedDataDetail" method="post"> -->

                <div class="row" id="searchBox">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="serviceName">RTPS Service</label>
                            <select class="form-select" aria-label="Default select example" name="serviceName" id="serviceName" style="border-color: green;">
                                <option selected disabled>-- Select Service --</option>
                                <option value="">Unselect Service</option>

                                <option disabled style="color:#999">============== MB1 ==============</option>

                                <option value="1" selected>Office Mutation</option>
                                <option value="2">Field Mutation</option>
                                <option value="3">Office Partition</option>
                                <option value="4">Field Partition</option>
                                <option value="6">Name Correction</option>
                                <option value="7">Area Correction</option>
                                <option value="8">Striking out Name</option>
                                <option value="10">Reclassification</option>
                                <option value="5">Land Allotment</option>


                                <!-- <option value="5">Land Allotmant</option>



                                <option value="9">AP to PP Conversion</option>
                                 -->

                                <option disabled style="color:#999">============== MB2 ==============</option>

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

                                <option disabled style="color:#999">============== MB3 ==============</option>

                                <option value="25">Settlement of land in surveyed N.C. village under SVAMITVA (Khas and ceiling Surplus Land)</option>
                                <option value="39">Settlement of unsettled erstwhile Bhoodan/Gramdan Lands</option>
                                <option value="40">Offering reclassification suite</option>
                                <option value="42">Ownership rights to occupancy tenants in town lands which were erstwhile rural lands</option>
                                <option value="43">Limited conversion of tea grant land to periodic patta</option>
                                <option value="44">End to end digitalization of Annual Patta to PP conversion with rationalized rates in town and its peripheral areas</option>
                                <option value="45">Digitalized settlement of land to non-individual juridical entities</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="caseNo"><?= $this->lang->line('case_no') ?></label>
                            <input type="text" class="form-control" name="caseNoSearch" id="caseNoSearch" placeholder="Eg: - KAM/PAL/2022-23/0000/SKHAS">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="caseNo">Application No</label>
                            <input type="text" class="form-control" name="applicationNoSearch" id="applicationNoSearch" placeholder="Eg: - RTPS/SKCSL/2023/00000">
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="appStatus"><?= $this->lang->line('appStatus') ?></label>
                            <select class="form-select" aria-label="Default select example" name="appStatus" id="appStatus">
                                <option selected disabled>-- Select Application Status --</option>
                                <option value="">Unselect Status </option>

                                <option disabled style="color:#999">============== MB1 | MB2 ==============</option>

                                <option value="PENDING">Pending </option>
                                <option value="REJECT">Rejected</option>
                                <option value="APPROVE">Approved</option>

                                <option disabled style="color:#999">============== MB2 ==============</option>

                                <option value="PAY_REQ">Payment Request</option>
                                <option value="PAY_RECV">Payment Received</option>
                                <option value="UN_PR_PAY">Under Process After Payment</option>
                                <option value="PAY_NOTICE">Payment Notice</option>
                                <option value="REVERT">Reverted</option>
                                <option value="APPL_NOTICE">Applicant Notice</option>
                                <option value="NOTICE_SER">Notice Served</option>
                                <option value="RE_REPORT">Re Report </option>
                                <option value="MARK_SDLAC">Mark As SDLAC/CDLAC </option>
                                <option value="SEND_SDLAC">Send to SDLAC/CDLAC </option>
                                <option value="CHITHA_UPDATE">Chitha Update</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="pendingOffice"><?= $this->lang->line('pendingOffice') ?></label>
                            <select class="form-select" aria-label="Default select example" name="pendingOffice" id="pendingOffice">
                                <option selected disabled>-- Select Pending Officer --</option>
                                <option value="">Unselect Officer </option>

                                <option value="AST">AST</option>
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
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="selectCircle"><?= $this->lang->line('circle') ?></label>
                            <select class="form-select" aria-label="Default select example" name="selectCircle" id="selectCircle">
                                <option selected disabled>-- Select Circle --</option>
                                <option value="">Unselect Circle </option>
                                <?php foreach ($circles as $circle): ?>
                                    <option value="<?= $circle->cir_code ?>"> <?= $circle->locname_eng ?> ( <?= $circle->loc_name ?> )</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="fromDate"><?= $this->lang->line('fromDate') ?></label>
                            <input type="text" autocomplete="off" placeholder="yyyy-mm-dd"
                                   class="fromDate form-control date" id="popup1Datepicker" name="fromDate" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="toDate"><?= $this->lang->line('toDate') ?></label>
                            <input type="text" autocomplete="off" placeholder="yyyy-mm-dd"
                                   class="toDate form-control date" id="popup2Datepicker" name="toDate" />
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 15px" align="right">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="rezaButt buttInfo searchData" id="" style="width: 200px">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <?php echo $this->lang->line('caseSearch') ?>
                        </button>
                    </div>
                </div>
                <!-- </form> -->

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

                <table class='table table-striped table-bordered' id='cases' width="100%">

                    <thead>
                    <tr>
                        <th>SL No.</th>
                        <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                        <th class="center"><label class="control-label"><?php echo $this->lang->line('action'); ?></label></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">

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
            timer: 5000,
            showConfirmButton: true,
        });
    }

    $(document).ready( function () {

        $('.searchData').click(function(){
            $('#cases').DataTable().destroy();
            load_data();
        });

        function load_data()
        {
            serviceName   = $('#serviceName').val();
            caseNo        = $('#caseNoSearch').val();
            applicationNo = $('#applicationNoSearch').val();
            appStatus     = $('#appStatus').val();
            pendingOffice = $('#pendingOffice').val();
            selectCircle  = $('#selectCircle').val();
            fromDate      = $('.fromDate').val();
            toDate        = $('.toDate').val();

            myArray = caseNo.split("/");
            arrLength = myArray.length;

            if(arrLength != 5 && arrLength != 1) {
                showWarningMessage("Please enter valid case no / petition no. In case of searching by Petition No," +
                    " kindly enter petition no only, do not use any special characters.");
                return false;
            }

            else if((serviceName == null || serviceName == '') && (caseNo != null || caseNo != '')) {
                showWarningMessage("Please select a RTPS Service for accurate result");
                return false;
            }

            else if((pendingOffice != null || pendingOffice != '') && (serviceName == null || serviceName == '') && (caseNo == null || caseNo == '')){
                showWarningMessage("Please select a RTPS Service for accurate result");
                return false;
            }

            else if((selectCircle != null || selectCircle != '') && ((caseNo == null || caseNo == '') && (applicationNo == null || applicationNo == '') && (appStatus == null || appStatus == '') && (pendingOffice == null || pendingOffice == '')) && (serviceName == '' || serviceName == null))
            {
                showWarningMessage("Please select a RTPS Service for accurate result");
                return false;
            }

            else if((fromDate == null || fromDate == '') && (toDate == null || toDate == '') && (serviceName == null || serviceName == ''))
            {
                showWarningMessage("Please select a RTPS Service for accurate result");
                return false;
            }

            var base_url = "<?php echo base_url();?>";
            var table = $('#cases').DataTable({
                'pageLength': 10,
                "processing": true,
                "serverSide": true,
                "ordering"  : false,
                "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                'language'  : {
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                },
                'ajax':{
                    url: base_url+'index.php/SearchingController/getSearchedDataDetail',
                    type:'POST',
                    data: {
                        serviceName   : serviceName,
                        caseNo        : caseNo,
                        applicationNo : applicationNo,
                        appStatus     : appStatus,
                        pendingOffice : pendingOffice,
                        selectCircle  : selectCircle,
                        fromDate      : fromDate,
                        toDate        : toDate,
                    },
                    deferLoading: 57,
                },
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false,
                    "className": "dt-center", "targets":[ 0, 1, 2],
                }]
            });
            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });
        }
    });
</script>





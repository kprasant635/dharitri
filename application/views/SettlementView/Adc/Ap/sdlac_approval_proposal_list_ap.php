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
        margin-bottom: 10px!important;
    }
    .rezaText {
        font-size: 16px;
    }


</style>

<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
            Process /
            Settlement MB /
            <a href="<?= base_url()?>index.php/SettlementApADC/SettlementApLandDc">AP Transfer</a> /
            <a href="<?= base_url()?>index.php/SettlementApADC/getAllSdlacMemberApprovalProposalListAp">SDLAC/CDLAC Reports</a>

            <a href="<?= base_url()?>index.php/SettlementApADC/SettlementApLandDc">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>
        </div>


        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <span><?php echo $this->lang->line('settlementAP') ?> <?php echo $this->lang->line('proposalList') ?></span>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="reza-body">
                <input type="hidden" id="service_code" value="<?=SETTLEMENT_AP_TRANSFER_ID?>" >

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>

                    <table class="datatable table table-stripped" id='datatable' width="100%">
                        <thead>
                        <tr>
                            <th width='2%'>#</th>
                            <th width='24%'> Proposal No <input type="text" id="by_proposal_no" name="by_proposal_no" data-column-index="1" class="form-control" placeholder="Search by Proposal No"></th>
                            <th width='18%' class="center">Hearing Date <input type="text" id="by_hearing_date" name="by_hearing_date" class="form-control" placeholder="Search by Hearing Date" data-column-index="3"></th>
                            <th width='16%' class="center">Created By <input type="text" id="by_case_no" name="by_case_no" data-column-index="2" class="form-control" placeholder="Search by Case No"></th>
                            <th width="40%" align="left" class="left">Action<button type="button" class="search_button btn btn-sm btn-primary form-control"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;Search</button></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
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


<!--// NEW JS BY MASUD REZA-->
<input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>

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



    // ****************************************************************
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
</script>

<script type="text/javascript">

    $('#datatable').DataTable();

    load_data();

    function load_data(){
        var base_url     = "<?php echo base_url();?>";
        var service_code = <?= SETTLEMENT_AP_TRANSFER_ID ?>;

        var case_no       = $('#by_case_no').val();
        var hearing_date  = $('#by_hearing_date').val();
        var proposal_no   = $('#by_proposal_no').val();

        $('#datatable').DataTable().destroy();

        var table = $('#datatable').DataTable({

            'pageLength' : 10,
            "processing" : true,
            "serverSide" : true,
            "ordering"   : false,
            "lengthMenu" : [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language'   : {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax'   : {
                url  : base_url+'index.php/SettlementApADC/getAllSdlacMemberApprovalProposalListDataAp',
                type : 'POST',
                data : {
                    service      : service_code,
                    case_no      : case_no,
                    hearing_date : hearing_date,
                    proposal_no  : proposal_no,
                },
                deferLoading     : 57,
            },

            order           : [[2, 'asc']],
            columnDefs      : [{
                targets     : "_all",
                orderable   : false,
                "className" : "dt-center", "targets":[ 0, 1, 2, 3, 4],
            }]
        });
    }

    $('.search_button').click(function(){
        load_data();
    });

    function openTab(id){

        var base_url     = "<?php echo base_url();?>";
        var service_code = <?= SETTLEMENT_AP_TRANSFER_ID ?>;

        $.ajax({
            url  : base_url+'index.php/SettlementApADC/getCasesAgainstProposalNo',
            dataType: "JSON",
            data: {id : id, service_code : service_code},
            type: "POST",
            success: function(data) {
                console.log(data.response[0]['case_no']);
                var cases=[];
                $.each(data.response, function (i, val) {
                    cases += '<br>' + val['case_no']
                });
                $('#list_of_cases_'+id).html(cases);

                // setTimeout(function() {
                //   $('#list_of_cases_'+id).toggle();
                // }, 2500);
            }
        });



    }

</script>

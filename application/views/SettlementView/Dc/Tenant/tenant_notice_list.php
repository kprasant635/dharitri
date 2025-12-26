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
    .checkBoxD{

        width: 20px;
        height: 20px;
    }

    .noticePadding{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px
    }
    .reza-title-modal{
        /* font-weight: bold; */
        /* font-size: 18px; */
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 20px;
        padding-bottom: 20px;
        /* color: #37474F; */
    }

    .datepick-popup {
        z-index: 9000!important;
    }

</style>
<script>
    $(function () {
        $('.ymd').datepick({dateFormat: 'yyyy-mm-dd'});
    });
</script>
<div class="col-lg-12"  style='padding: 40px 50px 40px 20px'>
    <div class="reza-card ">
        <div class="reza-title">
            <span><?php echo $this->lang->line('settlementOccupancyTenant') ?></span>
            <hr>
            <span>FORM No. 7 [See Rule 13] (Tenant notice generation village wise)</span>
        </div>

        <div class="reza-body">
            <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
            <table class="datatable table table-stripped" id='datatable'>
                <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Circle Name</th>
                    <th>Village Name</th>
                    <th class="center">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>

    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<style>
    /* .dataTables_filter, .dataTables_info { display: none; } */

    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
        }
 </style>

<script>

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

    function showWarningMessage(text) {
        swal.fire({
            title: "Warning!",
            text: text,
            icon: 'warning',
            position: 'top',
            timer: 5000,
            showCancelButton: true
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



    $('#datatable').DataTable();
    load_data();

    function load_data(){
        var base_url     = "<?php echo base_url(); ?>";
        var service_code = <?=SETTLEMENT_TENANT_ID?>;

        $('#datatable').DataTable().destroy();
        var table = $('#datatable').DataTable({

            'pageLength':10,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
            'language': {
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
            },
            'ajax':{
                url: base_url+'index.php/SettlementTenantDc/getPaymentReceivedCasesNoticeByVillage',
                type:'POST',
                data: {
                    service    : service_code
                },
                deferLoading: 57,
            },

            // order: [[2, 'asc']],
            columnDefs: [{
                targets: "_all",
                orderable: false,
                "className": "dt-center", "targets":[ 0, 1, 2, 3],
            }]
        });
    }

    $('.search_button').click(function(){
        load_data();
    });



    $('#generateExcel').click(function ()
    {
        var selectedList = [];

        $('.selectMark:checked').each(function(i){
            selectedList[i] = $(this).val();
        });

        Swal.fire({
            text: 'Downloading excel file...',
            icon: 'warning',
            confirmButtonText: 'OK',
            customClass: {
                actions: 'my-actions',
                confirmButton: 'order-2',
            }
        })
        .then((result) => {
            if (result.isConfirmed) {
                $('<form action="'+baseurl+'SettlementTenantDc/excelDataInsertion" method="POST"/>')
                    .append($('<input type="hidden" name="selectedData">').val(JSON.stringify(selectedList)))
                    .appendTo($(document.body)) //it has to be added somewhere into the <body>
                    .submit();

                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        })
    });
</script>


<!-- Notice Modal -->
<div class="modal" role="dialog" id="viewNoticeModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body" id="printableArea">

                <div class="container bg-white shadow pb-3" id="print_direct">
                    <input type="hidden" id="case_json">

                    <input type="hidden" id="dist_code_main_notice">
                    <input type="hidden" id="subdiv_code_main_notice">
                    <input type="hidden" id="cir_code_main_notice">
                    <input type="hidden" id="mouza_pargona_code_main_notice">
                    <input type="hidden" id="lot_no_main_notice">
                    <input type="hidden" id="vill_townprt_code_main_notice">
                    <input type="hidden" id="service_main_notice">
                    <input type="hidden" id="date_e_not">
                    <div class="row mt-5 text-center">
                        <div class="col-12 text-center" style="font-size: 18px; font-weight:bold;">
                            <u>FORM No. 7 [See Rule 13]</u>
                        </div>
                    </div>
                    <br>
                    <div class="row mt-2">
                        <div class="col-12 text-justify px-5">

                            <div class="row">
                                <div class="col-6"><p>No <b><?=$next_id?></b></div>
                                <div class="col-6 text-right">Dated : <?=date('d/m/Y')?></div>
                            </div>

                            <p>
                            Whereas the tenant/tenants/tenant’s legal heir named below has been found entitled to acquire ownership rights/intermediary rights of his landlords under Section 21 of the Assam (Temporarily Settled Areas) Tenancy' Act, 1971 (Assam Act XXIII of 1971);
                            </p>

	                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;And whereas the said tenant/tenants/tenant’s legal heir has/have applied and deposited the compensation under sub-section (1) of Section 23/(2) of Section 23 of the aforesaid Act;</p>

	                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Now, therefore, in exercise of the powers conferred by sub-section (1)/sub-section (2) of Section 23 of the said Act, it is hereby declared that the tenant/tenants/tenant’s legal heir named in column (1) of the schedule below has/have acquired the ownership rights/intermediary rights as landholder of the landlord's mentioned in column (2) of the schedule free from all encumbrance with effect from <b><span id="date_e_notice"></span></b> (date).</p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center font-weight-bold">
                            SCHEDULE
                        </div>
                    </div>

                    <div class="row px-5">
                        <div class="col-1">District</div>
                        <div class="col-3">: &nbsp;&nbsp;<span id="dist_name_id"></span></div>
                    </div>
                    <div class="row px-5">
                        <div class="col-1">Villlage</div>
                        <div class="col-3">: &nbsp;&nbsp;<span id="village_name_id"></span></div>
                    </div>
                    <div class="row px-5">
                        <div class="col-1">Circle</div>
                        <div class="col-3">: &nbsp;&nbsp;<span id="circle_name_id"></span></div>
                    </div>
                    <div class="row px-5">
                        <div class="col-1">Mauza</div>
                        <div class="col-3">: &nbsp;&nbsp;<span id="mouza_name_id"></span></div>
                    </div>
                    <br>


                    <div class="row px-5">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 noticePadding" id="caseTable">
                        </div>
                    </div>
                    <div class="row mt-5 justify-content-end mb-5">
                        <div class="col-5 text-center">
                            <b><?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></b><br>
                            District Commissioner <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="noticeSaveModalNo">CLOSE</button>
                <button type="button" class="btn btn-primary"   id="noticeSaveModalYes">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    &nbsp;SAVE NOTICE
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" role="dialog" id="dateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="dist_code_date_frm">
                    <input type="hidden" id="subdiv_code_date_frm">
                    <input type="hidden" id="cir_code_date_frm">
                    <input type="hidden" id="mouza_pargona_code_date_frm">
                    <input type="hidden" id="lot_no_date_frm">
                    <input type="hidden" id="vill_townprt_code_date_frm">
                    <input type="hidden" id="service_date_frm">

                    <div class="col-md-6">
                        <label for="">Enter the schedule free from all encumbrance with effect from date</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control ymd" id="e_date" placeholder="dd-mm-yyyy" readonly>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="dateModalClose">CLOSE</button>
                <button type="button" class="btn btn-primary"  id="generateNotice">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    &nbsp;Generate Notice
                </button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).on('click','#noticeSaveModalNo',function (){
        $('#viewNoticeModal').hide();
    });

    $(document).on('click','#dateModalClose',function (){
        $('#dateModal').hide();
    });

    function generateVillageNotice(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, service){
        $('#dateModal').show();
        $('#dist_code_date_frm').val(dist_code);
        $('#subdiv_code_date_frm').val(subdiv_code);
        $('#cir_code_date_frm').val(cir_code);
        $('#mouza_pargona_code_date_frm').val(mouza_pargona_code);
        $('#lot_no_date_frm').val(lot_no);
        $('#vill_townprt_code_date_frm').val(vill_townprt_code);
        $('#service_date_frm').val(service);
    }


    $(document).on('click','#generateNotice', function(){
        $('#dateModal').hide();
        var dist_code = $('#dist_code_date_frm').val();
        var subdiv_code = $('#subdiv_code_date_frm').val();
        var cir_code = $('#cir_code_date_frm').val();
        var mouza_pargona_code = $('#mouza_pargona_code_date_frm').val();
        var lot_no = $('#lot_no_date_frm').val();
        var vill_townprt_code = $('#vill_townprt_code_date_frm').val();
        var service = $('#service_date_frm').val();

        var date_e = $('#e_date').val();

        if(date_e == ''){
            alert('Please enter date before generating notice...');
            return false;
        }


        var postData = {
            'dist_code': dist_code,
            'subdiv_code': subdiv_code,
            'cir_code': cir_code,
            'mouza_pargona_code': mouza_pargona_code,
            'lot_no': lot_no,
            'vill_townprt_code': vill_townprt_code,
            'service': service,
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            url: baseurl+'SettlementTenantDc/generateVillNotice',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);
                if(arr.responseType != 2){
                    showErrorMessage(arr.msg);
                }
                else{
                    $('#viewNoticeModal').show();

                    $('#dist_code_main_notice').val(dist_code);
                    $('#subdiv_code_main_notice').val(subdiv_code);
                    $('#cir_code_main_notice').val(cir_code);
                    $('#mouza_pargona_code_main_notice').val(mouza_pargona_code);
                    $('#lot_no_main_notice').val(lot_no);
                    $('#vill_townprt_code_main_notice').val(vill_townprt_code);
                    $('#service_main_notice').val(service);

                    $('#dist_name_id').html(arr.loc_data.dist_name);
                    $('#village_name_id').html(arr.loc_data.village_name);
                    $('#circle_name_id').html(arr.loc_data.cir_name);
                    $('#mouza_name_id').html(arr.loc_data.mouza_name);

                    $('#date_e_notice').html(new Date(date_e).toLocaleDateString('en-GB'));
                    $('#date_e_not').val(new Date(date_e).toLocaleDateString('en-GB'));

                    var tr =    '<tr>'+
                                    '<th rowspan="2">Name of the tenant tenant(Applicant)</th>'+
                                    '<th rowspan="2">Name of the Land-lord and his address</th>'+
                                    '<th colspan ="3">Description of land</th>'+
                                    '<th rowspan="2">Area under occupation of the tenant/tenants/tenant’s legal heir(Applicant)</th>'+
                                    '<th rowspan="2">Land Revenue Payable</th>'+
                                    '<th rowspan="2">Remaks</th>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th>Patta No.</th>'+
                                    '<th>Khatian No.</th>'+
                                    '<th>Dag No.</th>'+
                                '</tr>';

                    tr +=   '<tr>'+
                                '<th>1</th>'+
                                '<th>2</th>'+
                                '<th>3</th>'+
                                '<th>4</th>'+
                                '<th>5</th>'+
                                '<th>6</th>'+
                                '<th>7</th>'+
                                '<th>8</th>'+
                            '</tr>';

                    var case_array = [];

                    var missing_rel = '';

                    var tenant_rel = [];

                    var t_r = '';
                    if(arr.missing_rel.length > 0){
                        for(j=0; j<arr.missing_rel.length; j++){

                            if(arr.missing_rel[j].pdar_type == 'P'){
                                missing_rel += 'Parent - '+arr.missing_rel[j].pdar_name+' <br>';
                            }else if(arr.missing_rel[j].pdar_type == 'GP'){
                                missing_rel += 'Grand Parent - '+arr.missing_rel[j].pdar_name+' <br>';
                            }
                            else if(arr.missing_rel[j].pdar_type == 'GPP'){
                                missing_rel += 'Great Grand Parent - '+arr.missing_rel[j].pdar_name+' <br>';
                            }

                            tenant_rel.push(arr.missing_rel[j].pdar_type)
                        }
                        if(tenant_rel.includes('P')){
                            t_r = 'Grand Parent(Tenant) - ';
                        }
                        if(tenant_rel.includes('GP')){
                            t_r = 'Great Grand Parent(Tenant) - ';
                        }
                    }else{
                        t_r = 'Tenant - ';
                    }


                    var land_owners = ''
                    for(k=0; k<arr.owner_result.length; k++){
                        land_owners += arr.owner_result[k].pdar_name+'<br>';
                    }

                    for(i=0; i<arr.tenant_data.length; i++){

                        tr += '<tr>'+
                                    '<th class="text-left">'+
                                    'Applicant - '+arr.tenant_data[i].applicantRow.pdar_name+'<br>'+
                                    missing_rel+
                                    t_r +arr.tenant_data[i].rioteeRow.pdar_name+'<br>'+
                                    'Applicantion Number: '+arr.tenant_data[i].application_no+
                                    '</th>'+
                                    '<th class="text-left">'+land_owners+'</th>'+
                                    '<th>'+arr.tenant_data[i].rioteeRow.patta_no+'</th>'+
                                    '<th>'+arr.tenant_data[i].rioteeRow.khatian_no+'</th>'+
                                    '<th>'+arr.tenant_data[i].rioteeRow.dag_no+'</th>'+
                                    '<th>'+arr.tenant_data[i].premRow.bkl+'</th>'+
                                    '<th>'+arr.tenant_data[i].premRow.due_amount+'</th>'+
                                    '<th>---</th>'+
                                '</tr>';
                        case_array.push(arr.tenant_data[i].case_no);
                    }

                    $('#case_json').val(JSON.stringify(case_array));

                    $('#caseTable').html('<table class="table text-center table-bordered">'+tr+'</table>');

                }
            }
        });
    })



    $(document).on('click','#noticeSaveModalYes',function ()
    {
        var htmlString  = $( "#printableArea" ).html();
        var htmlString  = b64EncodeUnicode(htmlString);

        var dist_code = $('#dist_code_main_notice').val();
        var subdiv_code = $('#subdiv_code_main_notice').val();
        var cir_code = $('#cir_code_main_notice').val();
        var mouza_pargona_code = $('#mouza_pargona_code_main_notice').val();
        var lot_no = $('#lot_no_main_notice').val();
        var vill_townprt_code = $('#vill_townprt_code_main_notice').val();
        var service = $('#service_main_notice').val();
        var case_json = $('#case_json').val();
        var date_e_notice = $('#date_e_not').val();

        var postData = {
            'case_array': case_json,
            'htmlString': htmlString,
            'dist_code': dist_code,
            'subdiv_code': subdiv_code,
            'cir_code': cir_code,
            'mouza_pargona_code': mouza_pargona_code,
            'lot_no': lot_no,
            'vill_townprt_code': vill_townprt_code,
            'service': service,
            'hearing_date': date_e_notice
        }

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        $.ajax({
            url: baseurl+'SettlementTenantDc/genVIllNotice',
            type: "POST",
            data: postData,
            success: function(data) {
                $.unblockUI();

                arr = JSON.parse(data);
                if(arr.responseType != 2){
                    showErrorMessage(arr.msg);
                }
                else{
                    $('#viewNoticeModal').hide();
                    Swal.fire({
                            text: arr.msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                actions: 'my-actions',
                                confirmButton: 'order-2',
                            }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = baseurl+'SettlementTenantDc/AllApplicantPaymentConfirmedCasesForNotice';
                        }
                        else
                        {
                            window.location.href = baseurl+'SettlementTenantDc/AllApplicantPaymentConfirmedCasesForNotice';
                        }
                    })

                }
            }
        });

    });


    function b64EncodeUnicode(str) {
        return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1);
            }));
    }


    // function printNotice(dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code, service){
    //     var postData = {
    //         'dist_code': dist_code,
    //         'subdiv_code': subdiv_code,
    //         'cir_code': cir_code,
    //         'mouza_pargona_code': mouza_pargona_code,
    //         'lot_no': lot_no,
    //         'vill_townprt_code': vill_townprt_code,
    //         'service': service,
    //     }

    //     $.blockUI({
    //         message: $('#displayBox'),
    //         css: {
    //             border:'none',
    //             backgroundColor:'transparent'
    //         }
    //     });

    //     $.ajax({
    //         url: baseurl+'SettlementTenantDc/printNotice',
    //         type: "POST",
    //         data: postData,
    //         success: function(data) {
    //             $.unblockUI();

    //             arr = JSON.parse(data);
    //             if(arr.responseType != 2){
    //                 showErrorMessage(arr.msg);
    //             }
    //             else{
    //                 // window.location.href = baseurl+'SettlementTenantDc/AllApplicantPaymentConfirmedCasesForNotice';
    //             }
    //         }
    //     });
    // }

</script>


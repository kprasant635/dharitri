<link href="<?php echo base_url(); ?>application/views/css/dataTableButton.css" rel="stylesheet" />
<style>

    .tenant{
        background-color : #9b8f83 !important;
        border-bottom-width: 0px;
    }
    .AP{
        background-color : #fb010159 !important;
        border-bottom-width: 0px;
    }
    .tribal{
        background-color : #0b405452 !important;
        border-bottom-width: 0px;
    }
    .khasland{
        background-color : #3333337a !important;
        border-bottom-width: 0px;
    }
    .bgrpgr{
        background-color : #8cc152a3 !important;
        border-bottom-width: 0px;
    }
    .cultivator{
        background-color : #6640409c !important;
        border-bottom-width: 0px;
    }

</style>

<script type="text/javascript">
    var exportThis = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"  xmlns="http://www.w3.org/TR/REC-html40"><head> <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets> <x:ExcelWorksheet><x:Name>{worksheet}</x:Name> <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions> </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook> </xml><![endif]--></head><body> <table>{table}</table></body></html>',
            base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
            }
        return function () {
            var ctx = { worksheet: 'Multi Level Export Table Example' || 'Worksheet', table: document.getElementById("multiLevelTable").innerHTML }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
    var exportThisAll = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"  xmlns="http://www.w3.org/TR/REC-html40"><head> <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets> <x:ExcelWorksheet><x:Name>{worksheet}</x:Name> <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions> </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook> </xml><![endif]--></head><body> <table>{table}</table></body></html>',
            base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
            }
        return function () {
            var ctx = { worksheet: 'Multi Level Export Table Example' || 'Worksheet', table: document.getElementById("multiLevelTableAll").innerHTML }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>

<div class="container-fluid">
    <div class="col-lg-12">

        <div class="row">
            <p class="uni_text">Total No. of Basundhara 2.0 Case(s) in the District </p>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body text-white">
                        <h4></h4>
                        Application Received: <kbd id='circle'><?=$output->data->recieved;?></kbd>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body text-white">
                        <h4></h4>
                        Application Pending: <kbd id='circle'><?=$output->data->pending;?></kbd>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body text-white">
                        <h4></h4>
                        Application Delivered: <kbd id='circle'><?=$output->data->delivered;?></kbd>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body text-white">
                        <h4></h4>
                        Application Rejected: <kbd id='circle'><?=$output->data->rejected;?></kbd>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12 p-4">

        <div class="card">
            <div class="text-center card-body">
                <span style="color:white; font-weight:bold; font-size:20px;">Download Rejected Cases</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button onclick="downloadRejected();" class="btn btn-warning">Download</button>
            </div>
        </div>


    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12 p-4">
        <h4 class="text-center">Pending With Officer</h4>

        <table class="table table-bordered" id="pendingCasesTable">
            <thead>
            <tr>
                <th>
                    <select id="service_code" onchange="getPendingCases();" class="form-select">
                        <option value="all">All Service</option>
                        <option value="16">Settlement Khasland</option>
                        <option value="15">Settlement Tribal</option>
                        <option value="18">Settlement Cultivation</option>
                        <option value="14">Settlement Settlement AP</option>
                        <option value="17">Settlement PGR/VGR</option>
                        <option value="13">Settlement Tenant</option>
                    </select>
                </th>
                <th class="text-center">LM</th>
                <th class="text-center">CO</th>
                <th class="text-center">SDO</th>
                <th class="text-center">ADC</th>
                <th class="text-center">SDLAC</th>
                <th class="text-center">DC</th>
                <th class="text-center">DPT</th>
                <th class="text-center">Total</th>
            </tr>
            </thead>
            <tbody id="Pcases">

            </tbody>
        </table>

    </div>
</div>


<div class="modal" role="dialog" id="pendingCaseDetailsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> <span id="serviceName"></span></h5>
                <hr>
            </div>
            <div class="modal-body" align="center">
                <h5>
                    Pending With <span id="userType"></span>
                </h5>
                <br>
                <h5>
                    <span id="distName"></span> /
                    <span id="subDivName"></span> /
                    <span id="circleName"></span>
                </h5>
                <hr>
                <table class="table table-striped table-hover">
                    <thead>

                    </thead>
                    <tbody>

                    <tr>
                        <td>Process Name</td>
                        <td align="center">Total No. Case</td>
                    </tr>
                    <tr>
                        <td class="rezaText"><?php echo $this->lang->line('1st_proceeding') ?></td>
                        <td align="center">
                            <span id="pendingCaseCount" style="font-weight: bold; color: #FF5252"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="rezaText">Rejected Cases</td>
                        <td align="center">
                            <span id="rejectedCaseCount" style="font-weight: bold; color: #FF5252"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="rezaText">Marked for SDLAC</td>
                        <td align="center">
                            <span id="markedForSDLACCaseCount" style="font-weight: bold; color: #FF5252"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="rezaText">Placed as SDLAC Proposals</td>
                        <td align="center">
                            <span id="casesInProposalCount" style="font-weight: bold; color: #FF5252"></span>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="pendingCaseDetailsModalClose">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>

<script>

    $( document ).ready(function() {
        getPendingCases();
    });

    function getPendingCases()
    {
        var service_code = $('#service_code').val();

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
        $.ajax({
            type: 'GET',
            url: baseurl+'SettlementCommon/pendingCasesStatus/'+service_code,
            dataType: 'json',
            cache: false,
            success: function(data) {
                console.log(data.responseType);

                $.unblockUI();

                if(data.responseType == 0)
                {
                    $("#Pcases").html('No data found !');
                }
                else
                {
                    $("#Pcases").html('');
                    $("#Pcases").find("tr").remove();
                    for(var i = 0; i < data.data.length; i++) {
                        $('#Pcases').append('<tr><td class="pl-4">' + data.data[i]['cir_name'] + '</td><td class="text-center">' + data.data[i]['lm'] + '</td><td class="text-center"> ' + data.data[i]['co'] + '</td>' +
                            '<td class="text-center">'+
                            '<button type="button" class="btn btn-info btn-sm" onclick="getDetails('+"'"+service_code+"','"+'SDO'+"','"+data.data[i]['subdiv_code']+"','"+data.data[i]['cir_code']+"'"+')"><i class="fa fa-eye"></i> '+data.data[i]['sdo']+'</a>'+
                            '</td>' +
                            '<td class="text-center">'+
                            '<button type="button" class="btn btn-info btn-sm" onclick="getDetails('+"'"+service_code+"','"+'ADC'+"','"+data.data[i]['subdiv_code']+"','"+data.data[i]['cir_code']+"'"+')"><i class="fa fa-eye"></i> '+data.data[i]['adc']+'</a>'+
                            '</td>' +
                            '<td class="text-center">' + data.data[i]['sdlac'] +'</td><td class="text-center">' + data.data[i]['dc'] + '</td><td class="text-center">' + data.data[i]['dpt'] + '</td><td class="text-center">' + data.data[i]['total'] + '</td></tr>');
                    }

                }
            }
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

    $(document).on('click','#pendingCaseDetailsModalClose',function ()
    {
        $('#pendingCaseDetailsModal').modal('hide');
    });

    function getDetails(sCode,user,sub,cir)
    {

        $.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });

        const applicant = {
            serviceCode: sCode,
            userType: user,
            subDivCode: sub,
            cirCode: cir
        };
        $.ajax({
            url: baseurl + "SettlementCommon/pendingCaseDetailsDashboardADC",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            success: function (data)
            {
                $.unblockUI();
                $('#pendingCaseDetailsModal').modal('show');
                if (data.responseType == 1)
                {
                    showErrorMessage("There is some problem, Please try again");
                }
                else if (data.responseType == 2)
                {
                    $("#serviceName").html(data.serviceName);
                    $("#userType").html(data.userType);
                    $("#distName").html(data.distName);
                    $("#subDivName").html(data.subDivName);
                    $("#circleName").html(data.circleName);

                    $("#pendingCaseCount").html(data.pendingCaseCount);
                    $("#rejectedCaseCount").html(data.rejectedCaseCount);
                    $("#markedForSDLACCaseCount").html(data.markedForSDLACCaseCount);
                    $("#casesInProposalCount").html(data.casesInProposalCount);
                }
                else if (data.responseType == 2)
                {
                    showErrorMessage("You are not Authorized");
                }
                else
                {
                    showErrorMessage("SOMETHING WENT WRONG");
                }
            },
            data: JSON.stringify(applicant)

        });




    }
</script>


<!--third Row Start-->
<div class="mt-5 col-lg-12 " style="overflow-x:auto;">
    <div class="row">
        <hr>
        <!-- <p class="uni_text">Total Case Details of Basundhara 2.0 service wise </p> -->


        <section class="">
            <button onclick="exportThis()" class="btn btn-sm btn-success">Export to Excel</button>
            <h4 class="text-center">Detail of service </h4>

            <div class="d-flex justify-content-between align-items-center">

                <table class="table table-bordered table-sm" id="multiLevelTable">

                    <thead>
                    <tr>
                        <th rowspan="3" scope="col" class="align-middle" scope="col">#</th>
                        <th rowspan="3" scope="col" class="align-middle" scope="col">District</th>
                        <th  colspan="24" scope="col" class="text-center">SETTLEMENT</th>
                    </tr>
                    <tr class="text-center">

                        <th colspan="4" class="text-center tenant">TENANT</th>
                        <th colspan="4" class="text-center AP">AP TRANSFER</th>
                        <th colspan="4" class="text-center tribal">TRIBAL</th>
                        <th colspan="4" class="text-center khasland">KHAS LAND</th>
                        <th colspan="4" class="text-center bgrpgr">PGR VGR LAND</th>
                        <th colspan="4" class="text-center cultivator">SPECIAL CULTIVATORS</th>

                    </tr>
                    <tr class="text-center">
                        <th class="tenant"> Received</th>
                        <th class="tenant"> Pending</th>
                        <th class="tenant"> Delivered</th>
                        <th class="tenant"> Rejected</th>
                        <th class="AP"> Received</th>
                        <th class="AP"> Pending</th>
                        <th class="AP"> Delivered</th>
                        <th class="AP"> Rejected</th>
                        <th class="tribal"> Received</th>
                        <th class="tribal"> Pending</th>
                        <th class="tribal"> Delivered</th>
                        <th class="tribal"> Rejected</th>
                        <th class="khasland"> Received</th>
                        <th class="khasland"> Pending</th>
                        <th class="khasland"> Delivered</th>
                        <th class="khasland"> Rejected</th>
                        <th class="bgrpgr"> Received</th>
                        <th class="bgrpgr"> Pending</th>
                        <th class="bgrpgr"> Delivered</th>
                        <th class="bgrpgr"> Rejected</th>
                        <th class="cultivator"> Received</th>
                        <th class="cultivator">Pending</th>
                        <th class="cultivator">Delivered</th>
                        <th class="cultivator">Rejected</th>
                    </tr>


                    </thead>
                    <tbody>


                    <tr>
                        <td scope="row"></td>
                        <td><a href="" title=""></a><?=$this->utilityclass->getDistrictName($output->data1->dist_code)?></td>
                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->socc_recieved ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_TENANT_ID?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class=""><?=$output->data1->socc_pending ;?> </span>
                            </a>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""> <?=$output->data1->socc_delivered ;?> </span>
                        </td>
                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->socc_rejected ;?></span>
                        </td>
                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->sapp_recieved ;?></span>
                        </td>
                        <td class="text-sm text-right">
                            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_AP_TRANSFER_ID?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class=""><?=$output->data1->sapp_pending ;?></span>
                            </a>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->sapp_delivered ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->sapp_rejected ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->stri_recieved ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_TRIBAL_COMMUNITY_ID?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class=""><?=$output->data1->stri_pending ;?></span>
                            </a>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->stri_delivered ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->stri_rejected ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->skha_recieved ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_KHAS_LAND_ID?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class=""><?=$output->data1->skha_pending ;?></span>
                            </a>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->skha_delivered ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->skha_rejected ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->spgr_recieved ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_PGR_VGR_LAND_ID?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class=""><?=$output->data1->spgr_pending ;?></span>
                            </a>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->spgr_delivered ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->spgr_rejected ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->stea_recieved ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <a href="<?=base_url().'index.php/SettlementCommon/viewPendingCases/'.SETTLEMENT_SPECIAL_CULTIVATORS_ID?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class=""><?=$output->data1->stea_pending ;?></span>
                            </a>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->stea_delivered ;?></span>
                        </td>

                        <td class="text-sm text-right">
                            <span class=""><?=$output->data1->stea_rejected ;?></span>
                        </td>

                    </tr>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<div class="mt-5 col-lg-12" style="overflow-x:auto;">
    <div class="row">
        <hr>



        <section class="">
            <button onclick="exportThisAll()" class="btn btn-sm btn-success">Export to Excel</button>

            <h4 class="text-center">Detail of service Circle wise</h4>

            <div class="d-flex justify-content-between align-items-center">


                <table class="table table-bordered table-sm" id="multiLevelTableAll">

                    <thead>
                    <tr>
                        <th rowspan="3" scope="col" class="align-middle" scope="col">#</th>
                        <th rowspan="3" scope="col" class="align-middle" scope="col">Circle</th>
                        <th  colspan="24" scope="col" class="text-center">SETTLEMENT</th>
                    </tr>
                    <tr class="text-center">

                        <th colspan="4" class="text-center tenant">TENANT</th>
                        <th colspan="4" class="text-center AP">AP TRANSFER</th>
                        <th colspan="4" class="text-center tribal">TRIBAL</th>
                        <th colspan="4" class="text-center khasland">KHAS LAND</th>
                        <th colspan="4" class="text-center bgrpgr">PGR VGR LAND</th>
                        <th colspan="4" class="text-center cultivator">SPECIAL CULTIVATORS</th>

                    </tr>
                    <tr class="text-center">
                        <th class="tenant"> Received</th>
                        <th class="tenant"> Pending<br> (% wise)
                        </th>
                        <th class="tenant"> Delivered<br> (% wise)</th>
                        <th class="tenant"> Rejected<br> (% wise)</th>
                        <th class="AP"> Received</th>
                        <th class="AP"> Pending<br> (% wise)</th>
                        <th class="AP"> Delivered<br> (% wise)</th>
                        <th class="AP"> Rejected<br> (% wise)</th>
                        <th class="tribal"> Received</th>
                        <th class="tribal"> Pending<br> (% wise)</th>
                        <th class="tribal"> Delivered<br> (% wise)</th>
                        <th class="tribal"> Rejected<br> (% wise)</th>
                        <th class="khasland"> Received</th>
                        <th class="khasland"> Pending<br> (% wise)</th>
                        <th class="khasland"> Delivered<br> (% wise)</th>
                        <th class="khasland"> Rejected<br> (% wise)</th>
                        <th class="bgrpgr"> Received</th>
                        <th class="bgrpgr"> Pending<br> (% wise)</th>
                        <th class="bgrpgr"> Delivered<br> (% wise)</th>
                        <th class="bgrpgr"> Rejected<br> (% wise)</th>
                        <th class="cultivator"> Received</th>
                        <th class="cultivator">Pending<br> (% wise)</th>
                        <th class="cultivator">Delivered<br> (% wise)</th>
                        <th class="cultivator">Rejected<br> (% wise)</th>
                    </tr>


                    </thead>
                    <tbody>
                    <?php $i=1; foreach($output->data2 as $cirData): ?>


                        <tr>
                            <td scope="row"><?=$i++?></td>
                            <td><a href="" title=""></a><?=$this->utilityclass->getCircleName($cirData->dist_code,$cirData->subdiv_code,$cirData->cir_code)?></td>
                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->socc_recieved)==null?"0":($cirData->socc_recieved)?></span><br>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->socc_pending)==null?"0":(($cirData->socc_pending)) ;?> </span><br>
                                <span class="">
                              <?php if($cirData->socc_recieved!=0){
                                  echo '('. number_format(((($cirData->socc_pending)/($cirData->socc_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->socc_delivered)==null?"0":($cirData->socc_delivered) ;?> </span><br>
                                <span class="">
                              <?php if($cirData->socc_recieved!=0){
                                  echo '('. number_format(((($cirData->socc_delivered)/($cirData->socc_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>
                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->socc_rejected)==null?"0":($cirData->socc_rejected) ;?></span><br>
                                <span class="">
                              <?php if($cirData->socc_recieved!=0){
                                  echo '('. number_format(((($cirData->socc_rejected)/($cirData->socc_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>
                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->sapp_recieved)==null?"0":($cirData->sapp_recieved) ;?></span><br>
                            </td>
                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->sapp_pending)==null?"0":($cirData->sapp_pending) ;?></span><br>
                                <span class="">
                              <?php if($cirData->sapp_recieved!=0){
                                  echo '('. number_format(((($cirData->sapp_pending)/($cirData->sapp_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->sapp_delivered)==null?"0":($cirData->sapp_delivered) ;?></span><br>
                                <span class="">
                              <?php if($cirData->sapp_recieved!=0){
                                  echo '('. number_format(((($cirData->sapp_delivered)/($cirData->sapp_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->sapp_rejected)==null?"0":($cirData->sapp_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->sapp_recieved!=0){
                                  echo '('. number_format(((($cirData->sapp_rejected)/($cirData->sapp_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>

                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stri_recieved)==null?"0":($cirData->stri_recieved) ;?></span><br>                       </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stri_pending)==null?"0":($cirData->stri_pending) ;?></span><br>                       <span class="">
                              <?php if($cirData->stri_recieved!=0){
                                  echo '('. number_format(((($cirData->stri_pending)/($cirData->stri_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stri_delivered)==null?"0":($cirData->stri_delivered) ;?></span><br>
                                <span class="">
                              <?php if($cirData->stri_recieved!=0){
                                  echo '('. number_format(((($cirData->stri_delivered)/($cirData->stri_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stri_rejected)==null?"0":($cirData->stri_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->stri_recieved!=0){
                                  echo '('. number_format(((($cirData->stri_rejected)/($cirData->stri_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->skha_recieved)==null?"0":($cirData->skha_recieved) ;?></span><br>                       </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->skha_pending)==null?"0":($cirData->skha_pending) ;?></span><br>                       <span class="">
                              <?php if($cirData->skha_recieved!=0){
                                  echo '('. number_format(((($cirData->skha_pending)/($cirData->skha_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->skha_delivered)==null?"0":($cirData->skha_delivered) ;?></span><br>
                                <span class="">
                              <?php if($cirData->skha_recieved!=0){
                                  echo '('. number_format(((($cirData->skha_delivered)/($cirData->skha_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->skha_rejected)==null?"0":($cirData->skha_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->skha_recieved!=0){
                                  echo '('. number_format(((($cirData->skha_rejected)/($cirData->skha_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->spgr_recieved)==null?"0":($cirData->spgr_recieved) ;?></span><br>                       </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->spgr_pending)==null?"0":($cirData->spgr_pending) ;?></span><br>                         <span class="">
                              <?php if($cirData->spgr_recieved!=0){
                                  echo '('. number_format(((($cirData->spgr_pending)/($cirData->spgr_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->spgr_delivered)==null?"0":($cirData->spgr_delivered) ;?></span><br>
                                <span class="">
                              <?php if($cirData->spgr_recieved!=0){
                                  echo '('. number_format(((($cirData->spgr_delivered)/($cirData->spgr_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->spgr_rejected)==null?"0":($cirData->spgr_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->spgr_recieved!=0){
                                  echo '('. number_format(((($cirData->spgr_rejected)/($cirData->spgr_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stea_recieved)==null?"0":($cirData->stea_recieved) ;?></span><br>                       </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stea_pending)==null?"0":($cirData->stea_pending) ;?></span><br>                       <span class="">
                              <?php if($cirData->stea_recieved!=0){
                                  echo '('. number_format(((($cirData->stea_pending)/($cirData->stea_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stea_delivered)==null?"0":($cirData->stea_delivered) ;?></span><br>
                                <span class="">
                              <?php if($cirData->stea_recieved!=0){
                                  echo '('. number_format(((($cirData->stea_delivered)/($cirData->stea_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                            <td class="text-sm text-right">
                                <span class=""><?=($cirData->stea_rejected)==null?"0":($cirData->stea_rejected) ;?></span><br>                         <span class="">
                              <?php if($cirData->stea_recieved!=0){
                                  echo '('. number_format(((($cirData->stea_rejected)/($cirData->stea_recieved))*100),1).'%)';

                              }else{
                                  echo '(NA)';
                              }?>

                            </span>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
        </section>
    </div>
</div>
</div>
<style type="text/css">
    .card-body{  background: #7b4397; /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #7b4397, #dc2430); /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #7b4397, #dc2430); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */);}
    #circle {
        background: #0f546a;
        border-radius: 30%;
        padding: 7px !important;
        font-weight: bold;
        font-size: 2em;
    }
</style>

<script src="<?php echo base_url(); ?>application/views/js/dataTableButtonJsZIP.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtons.js"></script>
<script src="<?php echo base_url(); ?>application/views/js/datatableButtonHtml.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#mb2report').dataTable({
            "scrollX": true,
            "lengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
            "pageLength": 20,
            //"autoWidth":false,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-download"></i> Download As Excel',
                    titleAttr: 'Excel',
                    title: "Basundhara 2.0 Cases Circle Wise",
                },
            ],
            initComplete: function () {
                var btns = $('.dt-button');
                btns.addClass('btn btn-info btn-sm');
                btns.removeClass('dt-button');
            }
        });
    });
</script>


<script>
    function downloadRejected()
    {
        window.location.href = baseurl+'Basundhara2/downloadRejected';
    }
</script>
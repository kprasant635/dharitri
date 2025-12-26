<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">E-Khajana-(Find Cases)</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-12 ">
        <div class="panel casedisplay">                        
            <div class="panel-body" style="font-size:18px!important;">
            <u><h4 class="text-black text-center">LAND DETAILS OF APPLICATION NO : <?=$getApplicationDetails['result']->application_details->application_no?></h4></u>
            <?php foreach ($getApplicationDetails['result']->land_details as $row):?>
            <h6 class="text-black">LAND DETAILS OF APPLICATION NO : <?=$row->ld_application_no?></h6>
            <table class="table table-striped table-bordered">
                <tr>
                    
                    <td>District Name: <?=$this->utilityclass->getDistrictName($row->dist_code)?></td>
                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($row->dist_code,$row->subdiv_code)?></td>
                    <td>Circle Name: <?=$this->utilityclass->getCircleName($row->dist_code,$row->subdiv_code,$row->cir_code)?></td>
                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code)?></td>
                </tr>
                <tr>
                    <td>Lot Name: <?=$this->utilityclass->getLotName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no)?></td>
                    <td>Village Name: <?=$this->utilityclass->getVillageName($row->dist_code,$row->subdiv_code,$row->cir_code,$row->mouza_pargona_code,$row->lot_no,$row->vill_townprt_code)?></td>
                    <td>Patta Type: <?=$this->utilityclass->getPattaType($row->patta_type_code)?></td>
                    <td>Patta No: <?=$row->patta_no?></td>
                </tr>
            </table>
            <?php endforeach;?>
            <?php $app_details = $getApplicationDetails['result']->application_details?>
            <u><h4 class="text-black text-center">APPLICATION DETAILS OF APPLICATION NO : <?=$app_details->application_no?></h4></u>
            <?php if($app_details->initial_payment_status =='R')
            {
                 $payment_status ="NOT DONE";

            }elseif($app_details->initial_payment_status =='N' || $app_details->initial_payment_status =='C')
            {
                $payment_status ="COMPLETED";
            }
            ?>
            <table class="table table-striped table-bordered">
                <tr>
                    <td>SERVICE NAME: <?="E-KHAJANA"?></td>
                    <td >PAYMENT-STATUS: <span style="background-color:yellow"><?=$payment_status?></span></td>
                </tr>
            </table>
            <?php if($app_details->initial_payment_status =='R'):?>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4 text-center">
                        <button class="btn btn-success text-center "  onclick="fetchInitialPaymentStatus('<?=$app_details->rtps_ref_no?>')">REFRESH CASE  <i class="fa fa-refresh fa-spin" style="font-size:24px"></i></button>
                    </div>
                    <div class="col-4"></div>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>               
</div>

<script>
function fetchInitialPaymentStatus(rtps_ref_no){
    event.preventDefault();
    $.ajax({
        url: baseurl + "FindCases/updateInitialPaymentStatus",
        type: 'POST',
        data: {"rtps_ref_no" : rtps_ref_no},
        dataType: 'json',
        beforeSend: function () {
            $.blockUI({
                message: $('#displayBox'),
                css: {
                    border:'none',
                    backgroundColor:'transparent'
                }
            });
        },
        success: function (data) {
             if(data.result == 'SERVER-ERROR'){
                $.unblockUI();
                alert(data.msg);
                return;

            }else if(data.result == 'SUCCESS'){
                $.unblockUI();
                alert(data.msg);
                location.href =  baseurl + "FindCases/findUnavailableCases";
            }
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
}
</script>


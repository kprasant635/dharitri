<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Find Cases</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-12 ">
        <div class="panel casedisplay">                      
            <div class="panel-body" style="font-size:18px!important;">
            <u><h4 class="text-black text-center">LAND DETAILS OF APPLICATION NO : <?=$getApplicationDetails['result']->application_no?></h4></u>
            <table class="table table-striped table-bordered">
                
                <tr>
                    <td>District Name: <?=$this->utilityclass->getDistrictName($getApplicationDetails['result']->dist_code)?></td>
                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($getApplicationDetails['result']->dist_code,$getApplicationDetails['result']->subdiv_code)?></td>
                    <td>Circle Name: <?=$this->utilityclass->getCircleName($getApplicationDetails['result']->dist_code,$getApplicationDetails['result']->subdiv_code,$getApplicationDetails['result']->cir_code)?></td>
                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($getApplicationDetails['result']->dist_code,$getApplicationDetails['result']->subdiv_code,$getApplicationDetails['result']->cir_code,$getApplicationDetails['result']->mouza_code)?></td>
                </tr>
               
                <tr>
                    <td>Lot Name: <?=$this->utilityclass->getLotName($getApplicationDetails['result']->dist_code,$getApplicationDetails['result']->subdiv_code,$getApplicationDetails['result']->cir_code,$getApplicationDetails['result']->mouza_code,$getApplicationDetails['result']->lot_no)?></td>
                    <td>Village Name: <?=$this->utilityclass->getVillageName($getApplicationDetails['result']->dist_code,$getApplicationDetails['result']->subdiv_code,$getApplicationDetails['result']->cir_code,$getApplicationDetails['result']->mouza_code,$getApplicationDetails['result']->lot_no,$getApplicationDetails['result']->village_code)?></td>
                    <td>Dag No: <?=$getApplicationDetails['result']->dag_no?></td>
                    <td>Patta No: <?=$getApplicationDetails['result']->patta_no?></td>
                </tr>
            </table>
            
            
            <u><h4 class="text-black text-center">APPLICATION DETAILS OF APPLICATION NO : <?=$getApplicationDetails['result']->application_no?></h4></u>
            <?php if($getApplicationDetails['result']->initial_payment_status =='R')
            {
                 $payment_status ="NOT DONE";

            }elseif($getApplicationDetails['result']->initial_payment_status =='N' || $getApplicationDetails['result']->initial_payment_status =='C')
            {
                $payment_status ="COMPLETED";
            }else{
                $payment_status ="UNDEFINED";
            }
            ?>
            <table class="table table-striped table-bordered">
                <tr>
                    <td>SERVICE NAME: <?=$service_name = $this->FindCasesModel->getBasundharaOneServiceName($getApplicationDetails['result']->service_code)?></td>
                    <td >PAYMENT-STATUS: <span style="background-color:yellow"><?=$payment_status?></span></td>
                </tr>
            </table>
            <?php if($getApplicationDetails['result']->initial_payment_status =='R'):?>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4 text-center">
                        <button class="btn btn-success text-center "  onclick="fetchInitialPaymentStatus('<?=$getApplicationDetails['result']->application_no?>')">REFRESH CASE  <i class="fa fa-refresh fa-spin" style="font-size:24px"></i></button>
                    </div>
                    <div class="col-4"></div>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>               
</div>

<script>
function fetchInitialPaymentStatus(application_no){
    event.preventDefault();
    $.ajax({
        url: baseurl + "FindCases/updateInitialPaymentStatusBasundharaOne",
        type: 'POST',
        data: {"application_no" : application_no},
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


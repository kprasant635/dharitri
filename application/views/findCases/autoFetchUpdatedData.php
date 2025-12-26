<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">Find Cases</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-12 ">
        <div class="panel casedisplay">                      
            <div class="panel-body" style="font-size:18px!important;">
            <u><h4 class="text-black text-center">LAND DETAILS OF APPLICATION NO : <?=$autoUpdateData['msg']->application_no?></h4></u>
            <table class="table table-striped table-bordered">
                <tr>
                    <td>District Name: <?=$this->utilityclass->getDistrictName($autoUpdateData['msg']->dist_code)?></td>
                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($autoUpdateData['msg']->dist_code,$autoUpdateData['msg']->subdiv_code)?></td>
                    <td>Circle Name: <?=$this->utilityclass->getCircleName($autoUpdateData['msg']->dist_code,$autoUpdateData['msg']->subdiv_code,$autoUpdateData['msg']->cir_code)?></td>
                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($autoUpdateData['msg']->dist_code,$autoUpdateData['msg']->subdiv_code,$autoUpdateData['msg']->cir_code,$autoUpdateData['msg']->mouza_code)?></td>
                </tr>
                
                <tr>
                    <td>Lot Name: <?=$this->utilityclass->getLotName($autoUpdateData['msg']->dist_code,$autoUpdateData['msg']->subdiv_code,$autoUpdateData['msg']->cir_code,$autoUpdateData['msg']->mouza_code,$autoUpdateData['msg']->lot_no)?></td>
                    <td>Village Name: <?=$this->utilityclass->getVillageName($autoUpdateData['msg']->dist_code,$autoUpdateData['msg']->subdiv_code,$autoUpdateData['msg']->cir_code,$autoUpdateData['msg']->mouza_code,$autoUpdateData['msg']->lot_no,$autoUpdateData['msg']->village_code)?></td>
                    <td>Dag No: <?=$autoUpdateData['msg']->dag_no?></td>
                    <td>Patta No: <?=$autoUpdateData['msg']->patta_no?></td>
                </tr>
            </table>
            
            
            <u><h4 class="text-black text-center">APPLICATION DETAILS OF APPLICATION NO : <?=$autoUpdateData['msg']->application_no?></h4></u>
            <?php if($autoUpdateData['msg']->initial_payment_status =='R')
            {
                 $payment_status ="NOT DONE";

            }elseif($autoUpdateData['msg']->initial_payment_status =='N' || $autoUpdateData['msg']->initial_payment_status =='C')
            {
                $payment_status ="COMPLETED";
            }else{
                $payment_status ="UNDEFINED";
            }
            ?>
            <table class="table table-striped table-bordered">
                <tr>
                    <td>SERVICE NAME: <?=$service_name = $this->FindCasesModel->getBasundharaOneServiceName($autoUpdateData['msg']->service_code)?></td>
                    <td >PAYMENT-STATUS: <span style="background-color:yellow"><?=$payment_status?></span></td>
                </tr>
            </table>
           
            </div>
        </div>
    </div>               
</div>



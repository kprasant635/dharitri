<style>
    .casedisplay {
    min-height: 395px !important;
    background: linear-gradient(to bottom right, rgba(255, 0, 0, 0), #4a5588);
}
</style>

<div class="row" style='margin-top:20px'>	
    <div class="col-lg-12 ">
        <div class="panel casedisplay">  
            <div class="panel-body" style="font-size:18px!important;">
            <u><h4 class="text-black text-center">LAND DETAILS OF APPLICATION NO : <?=$getUpdatedData['msg']->app_data->application_no?></h4></u>
            <?php foreach($getUpdatedData['msg']->land_data as $land_details):?>
            <table class="table table-striped table-bordered">
                
                <tr>
                    <td>District Name: <?=$this->utilityclass->getDistrictName($land_details->dist_code)?></td>
                    <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($land_details->dist_code,$land_details->subdiv_code)?></td>
                    <td>Circle Name: <?=$this->utilityclass->getCircleName($land_details->dist_code,$land_details->subdiv_code,$land_details->cir_code)?></td>
                    <td>Mouza Name: <?=$this->utilityclass->getMouzaName($land_details->dist_code,$land_details->subdiv_code,$land_details->cir_code,$land_details->mouza_pargona_code)?></td>
                </tr>
               
                <tr>
                    <td>Lot Name: <?=$this->utilityclass->getLotName($land_details->dist_code,$land_details->subdiv_code,$land_details->cir_code,$land_details->mouza_pargona_code,$land_details->lot_no)?></td>
                    <td>Village Name: <?=$this->utilityclass->getVillageName($land_details->dist_code,$land_details->subdiv_code,$land_details->cir_code,$land_details->mouza_pargona_code,$land_details->lot_no,$land_details->vill_townprt_code)?></td>
                    <td>Patta No: <?=$land_details->patta_type?></td>
                    <td>Patta No: <?=$land_details->patta_no?></td>
                </tr>
            </table>
            
            <?php endforeach;?>
            <u><h4 class="text-black text-center">APPLICATION DETAILS OF APPLICATION NO : <?=$getUpdatedData['msg']->app_data->application_no?></h4></u>
            <?php if($getUpdatedData['msg']->app_data->initial_payment_status =='R')
            {
                 $payment_status ="NOT DONE";

            }elseif($getUpdatedData['msg']->app_data->initial_payment_status =='N' || $getUpdatedData['msg']->app_data->initial_payment_status =='C')
            {
                $payment_status ="COMPLETED";
            }else{
                $payment_status ="UNDEFINED";
            }
            ?>
            <table class="table table-striped table-bordered">
                <tr>
                    <td>SERVICE NAME: <?="E-KHAJANA"?></td>
                    <td>REGISTRATION FEE PAYMENT STATUS: <span style="background-color:yellow"><?=$payment_status?></span></td>
                </tr>
            </table>
            </div>
        </div>
        <center>
        <a href="<?php echo base_url() . 'index.php/EkhajanaLmController/LmPendingListformouzadarisystem'?>"
            class="btn btn-sm btn-danger"><i class="fa fa-hand-o-left"></i>Back
        </a>
        </center>
    </div>               
</div>




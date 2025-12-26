<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading text-center bg-danger shadow-lg">
                        <h6 class="panel-title text-white text-center">
                            Arrear is not updated for this patta..!
                        </h6>
                    </div>
                    <table class="table table-striped text-bold">
                    <thead>
                        <tr>                     
                            <th colspan="6" class="text-center bg-secondary">
                                Last Khajana Receipt :
                                <button class="btn btn-success btn-sm">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <a href="<?=base_url().'index.php/EkhajanaCoController/document?appl_no='.$ek_land_details->ld_application_no?>"
                                    target="_blank" style="text-decoration:none;color:white;">
                                        Download
                                    </a>
                                </button>
                            </th>
                        </tr>
                    </thead>
                </table> 
                    <div class="panel-heading text-center bg-secondary shadow-lg">
                        <h6 class="panel-title text-white text-center p-1">
                            Kindly Update The Arrear For 
                            Mouza: <span style="color:yellow"><?=$this->utilityclass->getMouzaName($ek_land_details->dist_code,$ek_land_details->subdiv_code,$ek_land_details->cir_code,$ek_land_details->mouza_pargona_code)?></span>,
                            Lot No: <span style="color:yellow"><?=$this->utilityclass->getLotName($ek_land_details->dist_code,$ek_land_details->subdiv_code,$ek_land_details->cir_code,$ek_land_details->mouza_pargona_code,$ek_land_details->lot_no)?></span>,
                            Village: <span style="color:yellow"><?=$this->utilityclass->getVillageName($ek_land_details->dist_code,$ek_land_details->subdiv_code,$ek_land_details->cir_code,$ek_land_details->mouza_pargona_code,$ek_land_details->lot_no,$ek_land_details->vill_townprt_code)?></span>,
                            Patta-Type: <span style="color:yellow"><?=$ek_land_details->patta_type?></span>,
                            Patta-No: <span style="color:yellow"><?=$ek_land_details->patta_no?></span> 
                        </h6>
                    </div>
                    <div class="text-center mt-1 shadow-lg">
                        <h6 class="panel-title text-white text-center p-1">
                            <form action="<?php echo base_url() . 'index.php/EkhajanaAstController/submitArrear?autoYear=' . EKHAJANA_TEHSILDARI_AUTO_YEAR_CONFIG; ?>" method="POST" target="_blank">
                                <input type="hidden" name="dist_code" value="<?=$ek_land_details->dist_code?>">
                                <input type="hidden" name="subdiv_code" value="<?=$ek_land_details->subdiv_code?>">
                                <input type="hidden" name="cir_code" value="<?=$ek_land_details->cir_code?>">
                                <input type="hidden" name="mouza_pargona_code" value="<?=$ek_land_details->mouza_pargona_code?>">
                                <input type="hidden" name="lots" value="<?=$ek_land_details->lot_no?>">
                                <input type="hidden" name="villages" value="<?=$ek_land_details->vill_townprt_code?>">
                                <input type="hidden" name="patta_type_code" value="<?=$ek_land_details->patta_type_code?>">
                                <input type="hidden" name="patta_no" value="<?=$ek_land_details->patta_no?>">
                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-book fa-fw"></i>&nbsp;CLICK HERE TO UPDATE THE ARREAR</button>
                            </form>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
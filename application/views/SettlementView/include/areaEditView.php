<table class="table">
    <tr class="alert-warning">
        <th>
                <span style="font-size:16px;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;
                Want to edit area?
                </span>
        </th>
        <td>
            <input type="radio" onclick="editAreaYes();" name="area_edit_yes_no" id="" value="yes">
            <label for=""><strong>Yes</strong></label> &nbsp;
            <input type="radio" onclick="editAreaNo();" name="area_edit_yes_no" id="" value="no">
            <label for=""><strong>No</strong></label>
        </td>
    </tr>

</table>

<div id="edit_area" class=" mt-2 row" style="display: none;">

    <form action="<?php echo base_url() ?>index.php/SettlementCommon/areaUpdate" method="post">

        <input type="hidden" name="case_no" value="<?=$_GET['case']?>">
        <h5 class="reza-title" style="margin-top: 10px">
            <i class="fa fa-map-o" aria-hidden="true"></i>  Applied Area
        </h5>
        <table class="table table-bordered">
            <?php $service_code = $this->utilityclass->getServiceCode($_GET['case']);

            if($service_code == SETTLEMENT_AP_TRANSFER_ID){
                $dag_count = 1;

                foreach($dags as $all_dags){
                    ?>
                    <tr>
                        <th rowspan="5"><?=$dag_count++?></th>
                        <th>Dag Number:</th>
                        <td colspan="3">
                            <strong class="alert-warning">
                                <?=$all_dags->dag_no?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Patta Number:</th>
                        <td colspan="3">
                            <strong class="alert-warning">
                                <?=$all_dags->patta_no?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Patta type:</th>
                        <td colspan="3">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Land Area in Selected Dag</th>
                        <td>
                            <span class="input-group-addon alert-success">Bigha</span>
                            <strong>
                                <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" readonly>
                            </strong>
                        </td>
                        <td>
                            <span class="input-group-addon alert-success">Katha</span>
                            <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" readonly>
                        </td>
                        <td>
                            <span class="input-group-addon alert-success">Lessa</span>
                            <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" readonly>
                        </td>
                        <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <span class="input-group-addon alert-success">Ganda</span>
                                <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon alert-success">Kranti</span>
                                <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" readonly>
                            </td>
                        <?php endif;?>
                    </tr>

                    <tr>
                        <th>Total applied area</th>
                        <td>
                            <span class="input-group-addon">Bigha</span>
                            <input type="text" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags_first->s_dag_area_b?>" >
                        </td>
                        <td>
                            <span class="input-group-addon">Katha</span>
                            <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?=$dags_first->s_dag_area_k?>" class="form-control input-sm s_dag_area_k" >
                        </td>
                        <td>
                            <span class="input-group-addon">Lessa</span>
                            <input type="text" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags_first->s_dag_area_lc?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <span class="input-group-addon">Ganda</span>
                                <input type="text" style="text-align: center;" value="<?=$dags_first->s_dag_area_g?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                            </td>
                            <td>
                                <span class="input-group-addon">Kranti</span>
                                <input type="text" style="text-align: center;" value="<?=$dags_first->s_dag_area_kr?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                            </td>
                        <?php endif ; ?>
                    </tr>

                    <?php
                }}elseif($service_code == SETTLEMENT_TENANT_ID){
                ?>
                <table class="table">
                    <tr>
                        <th rowspan="5">1</th>
                        <th>Dag Number:</th>
                        <td colspan="3">
                            <strong class="alert-warning">
                                <?=$dags["dag_no"]?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Patta Number:</th>
                        <td colspan="3">
                            <strong class="alert-warning">
                                <?=$dags["patta_no"]?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Patta type:</th>
                        <td colspan="3">
                            <strong class="alert-warning">
                                <?=$this->utilityclass->getPattaType($dags["patta_type_code"])?>
                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Total Land Area in Selected Dag</th>
                        <td>
                            <span class="input-group-addon alert-success">Bigha</span>
                            <strong>
                                <input type="text" style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$dags["dag_area_b"]?>" readonly>
                            </strong>
                        </td>
                        <td>
                            <span class="input-group-addon alert-success">Katha</span>
                            <input type="text" style="text-align: center;" name="dag_area_k" value="<?=$dags["dag_area_k"]?>" class="form-control input-sm" readonly>
                        </td>
                        <td>
                            <span class="input-group-addon alert-success">Bigha</span>
                            <input type="text" style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$dags["dag_area_lc"]?>" readonly>
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <span class="input-group-addon alert-success">Ganda</span>
                                <input type="text" style="text-align: center;" value="<?=$dags["dag_area_g"]?>" class="form-control input-sm" name="dag_area_g" readonly>
                            </td>
                            <td>
                                <span class="input-group-addon alert-success">Kranti</span>
                                <input type="text" style="text-align: center;" value="<?=$dags["dag_area_kr"]?>" class="form-control input-sm" name="dag_area_kr" readonly>
                            </td>
                        <?php endif ; ?>
                    </tr>

                    <tr>
                        <th>Total applied area</th>
                        <td>
                            <span class="input-group-addon alert-warning">Bigha</span>
                            <input type="text" style="text-align: center;" name="s_dag_area_b" class="form-control input-sm s_dag_area_b" value="<?=$dags["s_dag_area_b"]?>" >
                        </td>
                        <td>
                            <span class="input-group-addon alert-warning">Katha</span>
                            <input type="text" style="text-align: center;" name="s_dag_area_k" value="<?=$dags["s_dag_area_k"]?>" class="form-control input-sm s_dag_area_k" >
                        </td>
                        <td>
                            <span class="input-group-addon alert-warning">Lessa</span>
                            <input type="text" style="text-align: center;" name="s_dag_area_lc" class="form-control input-sm s_dag_area_lc" value="<?=$dags["s_dag_area_lc"]?>" >
                        </td>
                        <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                            <td>
                                <span class="input-group-addon alert-warning">Ganda</span>
                                <input type="text" style="text-align: center;" value="<?=$dags["s_dag_area_g"]?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g" >
                            </td>
                            <td>
                                <span class="input-group-addon alert-warning">Kranti</span>
                                <input type="text" style="text-align: center;" value="<?=$dags["s_dag_area_kr"]?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr" >
                            </td>
                        <?php endif ; ?>
                    </tr>

                </table>
                <?php
            }elseif($service_code != SETTLEMENT_AP_TRANSFER_ID && $service_code != SETTLEMENT_TENANT_ID){

            $dag_count = 1;

            $total_home_bigha = 0;
            $total_home_katha = 0;
            $total_home_lessa = 0;
            $total_home_ganda = 0;
            $total_home_kranti = 0;

            $total_agri_bigha = 0;
            $total_agri_katha = 0;
            $total_agri_lessa = 0;
            $total_agri_ganda = 0;
            $total_agri_kranti = 0;

            $total_fbigha=0;
            $total_fkatha=0;
            $total_flessa=0;
            $total_fganda=0;
            $total_fkranti=0;

            $total_area_bigha = 1;
            $total_area_katha = 1;
            $total_area_lessa = 1;
            $total_area_ganda = 1;
            $total_area_kranti = 1;

            $total_area_agri_bigha = 1;
            $total_area_agri_katha = 1;
            $total_area_agri_lessa = 1;
            $total_area_agri_ganda = 1;
            $total_area_agri_kranti = 1;

            $total_area_fbigha = 1;
            $total_area_fkatha = 1;
            $total_area_flessa = 1;
            $total_area_fganda = 1;
            $total_area_fkranti = 1;

            if(isset($dags)){
            if($dags){
            foreach ($dags as $all_dags) {
                $total_home_bigha = $total_home_bigha + $all_dags->home_b;
                $total_home_katha = $total_home_katha + $all_dags->home_k;
                $total_home_lessa = $total_home_lessa + $all_dags->home_lc;
                $total_home_ganda = $total_home_ganda + $all_dags->home_g;
                $total_home_kranti = $total_home_kranti + $all_dags->home_kr;

                $total_agri_bigha = $total_agri_bigha + $all_dags->agri_b;
                $total_agri_katha = $total_agri_katha + $all_dags->agri_k;
                $total_agri_lessa = $total_agri_lessa + $all_dags->agri_lc;
                $total_agri_ganda = $total_agri_ganda + $all_dags->agri_g;
                $total_agri_kranti = $total_agri_kranti + $all_dags->agri_kr;

                $total_fbigha=$total_fbigha+$all_dags->fbigha;
                $total_fkatha=$total_fkatha+$all_dags->fkatha;
                $total_flessa=$total_flessa+$all_dags->flessa;
                $total_fganda=$total_fganda+$all_dags->fganda;
                $total_fkranti=$total_fkranti+$all_dags->fkranti;

                ?>
                <tr>
                    <th rowspan="6"><?=$dag_count++?></th>
                    <th>Dag Number:</th>
                    <td colspan="3">
                        <strong class="alert-warning">
                            <?=$all_dags->dag_no?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <th>Patta Number:</th>
                    <td colspan="3">
                        <strong class="alert-warning">
                            <?=$all_dags->patta_no?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <th>Patta type:</th>
                    <td colspan="3">
                        <strong class="alert-warning">
                            <?=$this->utilityclass->getPattaType($all_dags->patta_type_code)?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <th>Total Land Area in Selected Dag</th>
                    <td>
                        <span class="input-group-addon alert-success">Bigha</span>
                        <strong>
                            <input type="text" style="text-align: center;" name="dag_area_b<?=$all_dags->id?>" class="form-control input-sm" value="<?=$all_dags->dag_area_b?>" readonly>
                        </strong>
                    </td>
                    <td>
                        <span class="input-group-addon alert-success">Katha</span>
                        <input type="text" style="text-align: center;" name="dag_area_k<?=$all_dags->id?>" value="<?=$all_dags->dag_area_k?>" class="form-control input-sm" readonly>
                    </td>
                    <td>
                        <span class="input-group-addon alert-success">Lessa</span>
                        <input type="text" style="text-align: center;" name="dag_area_lc<?=$all_dags->id?>" class="form-control input-sm" value="<?=$all_dags->dag_area_lc?>" readonly>
                    </td>
                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                            <span class="input-group-addon alert-success">Ganda</span>
                            <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$all_dags->id?>" readonly>
                        </td>
                        <td>
                            <span class="input-group-addon alert-success">Kranti</span>
                            <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr<?=$all_dags->id?>" readonly>
                        </td>
                    <?php endif;?>
                </tr>

                <?php if($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID): ?>
                    <tr class="hide">
                <?php else: ?>
                    <tr>
                <?php endif; ?>

                <th class="text-primary">Applied area (Homestead)</th>
                <td>
                    <span class="input-group-addon alert-warning">Bigha</span>
                    <input type="text" style="text-align: center;" name="home_b<?=$all_dags->id?>" class="form-control input-sm home_b" value="<?=$all_dags->home_b?>" onkeyup="totalAreaCal()" id="mbigha<?=$total_area_bigha++?>">
                </td>
                <td>
                    <span class="input-group-addon alert-warning">Katha</span>
                    <input type="text" style="text-align: center;" name="home_k<?=$all_dags->id?>" value="<?=$all_dags->home_k?>" class="form-control input-sm home_k" onkeyup="totalAreaCal()" id="mkatha<?=$total_area_katha++?>">
                </td>
                <td>
                    <span class="input-group-addon alert-warning">Lessa</span>
                    <input type="text" style="text-align: center;" name="home_lc<?=$all_dags->id?>" class="form-control input-sm s_dag_area_lc" value="<?=$all_dags->home_lc?>" onkeyup="totalAreaCal()" id="mlessa<?=$total_area_lessa++?>">
                </td>
                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>
                        <span class="input-group-addon alert-warning">Ganda</span>
                        <input type="text" style="text-align: center;" value="<?=$all_dags->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g<?=$all_dags->id?>" onkeyup="totalAreaCal()" id="mganda<?=$total_area_ganda++?>">
                    </td>
                    <td>
                        <span class="input-group-addon alert-warning">Kranti</span>
                        <input type="text" style="text-align: center;" value="<?=$all_dags->home_kr?>" class="form-control input-sm s_dag_area_kr" name="home_kr<?=$all_dags->id?>" onkeyup="totalAreaCal()" id="mkranti<?=$total_area_kranti++?>">
                    </td>
                <?php endif;?>
                </tr>

                <?php if($service_code == SETTLEMENT_PGR_VGR_LAND_ID): ?>
                    <tr class="hide">
                <?php else: ?>
                    <tr>
                <?php endif; ?>


                <th class="text-primary">Applied area (Agricultural)</th>
                <td>
                    <span class="input-group-addon alert-warning">Bigha</span>
                    <input type="text" style="text-align: center;" name="agri_b<?=$all_dags->id?>" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b?>" onkeyup="agriArea()" id="agri_bigha<?=$total_area_agri_bigha++?>">
                </td>
                <td>
                    <span class="input-group-addon alert-warning">Katha</span>
                    <input type="text" style="text-align: center;" name="agri_k<?=$all_dags->id?>" value="<?=$all_dags->agri_k?>" class="form-control input-sm agri_k" onkeyup="agriArea()" id="agri_katha<?=$total_area_agri_katha++?>">
                </td>
                <td>
                    <span class="input-group-addon alert-warning">Lessa</span>
                    <input type="text" style="text-align: center;" name="agri_lc<?=$all_dags->id?>" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc?>" onkeyup="agriArea()" id="agri_lessa<?=$total_area_agri_lessa++?>">
                </td>
                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>
                        <span class="input-group-addon alert-warning">Ganda</span>
                        <input type="text" style="text-align: center;" value="<?=$all_dags->agri_g?>" class="form-control input-sm agri_g" name="agri_g<?=$all_dags->id?>" onkeyup="agriArea()" id="agri_ganda<?=$total_area_agri_ganda++?>">
                    </td>
                    <td>
                        <span class="input-group-addon alert-warning">Kranti</span>
                        <input type="text" style="text-align: center;" value="<?=$all_dags->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr<?=$all_dags->id?>" onkeyup="agriArea()" id="agri_kranti<?=$total_area_agri_kranti++?>">
                    </td>
                <?php endif;?>
                </tr>

                <tr class="hide">
                    <th class="text-primary">Applied area (Fishery)</th>
                    <td>
                        <span class="input-group-addon alert-warning">Bigha</span>
                        <input type="text" style="text-align: center;" name="fbigha<?=$all_dags->id?>" class="form-control input-sm fbigha" value="<?=$all_dags->fbigha?>" onkeyup="fisheryArea()" id="fbigha<?=$total_area_fbigha++?>">
                    </td>
                    <td>
                        <span class="input-group-addon alert-warning">Katha</span>
                        <input type="text" style="text-align: center;" name="fkatha<?=$all_dags->id?>" value="<?=$all_dags->fkatha?>" class="form-control input-sm fkatha" onkeyup="fisheryArea()" id="fkatha<?=$total_area_fkatha++?>">
                    </td>
                    <td>
                        <span class="input-group-addon alert-warning">Lessa</span>
                        <input type="text" style="text-align: center;" name="flessa<?=$all_dags->id?>" class="form-control input-sm flessa" value="<?=$all_dags->flessa?>" onkeyup="fisheryArea()" id="flessa<?=$total_area_flessa++?>">
                    </td>
                    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                        <td>
                            <span class="input-group-addon alert-warning">Ganda</span>
                            <input type="text" style="text-align: center;" value="<?=$all_dags->fganda?>" class="form-control input-sm fganda" name="fganda<?=$all_dags->id?>" onkeyup="fisheryArea()" id="fganda<?=$total_area_fganda++?>">
                        </td>
                        <td>
                            <span class="input-group-addon alert-warning">Kranti</span>
                            <input type="text" style="text-align: center;" value="<?=$all_dags->fkranti?>" class="form-control input-sm fkranti" name="fkranti<?=$all_dags->id?>" onkeyup="fisheryArea()" id="fkranti<?=$total_area_fkranti++?>">
                        </td>
                    <?php endif;?>
                </tr>

            <?php }?>

        </table>
        <h5 class="reza-title text-center" style="margin-top: 50px !important;" >
            <i class="fa fa-map" aria-hidden="true"></i>  Total Applied Area
        </h5>
        <table class="table-bordered table">

            <?php if($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID): ?>
        <tr class="hide">
        <?php else: ?>
            <tr>
                <?php endif; ?>
                <th colspan="2">Total applied area (Homestead)</th>
                <td>
                    <span class="input-group-addon alert-success">Bigha</span>
                    <input readonly type="text" style="text-align: center;" name="s_dag_area_b<?=$all_dags->id?>" class="form-control input-sm s_dag_area_b" value="<?=$total_home_bigha?>" id="total_applied_home_bigha">
                </td>
                <td>
                    <span class="input-group-addon alert-success">Katha</span>
                    <input readonly type="text" style="text-align: center;" name="s_dag_area_k<?=$all_dags->id?>" value="<?=$total_home_katha?>" class="form-control input-sm s_dag_area_k" id="total_applied_home_katha">
                </td>
                <td>
                    <span class="input-group-addon alert-success">Lessa</span>
                    <input readonly type="text" style="text-align: center;" name="s_dag_area_lc<?=$all_dags->id?>" class="form-control input-sm s_dag_area_lc" value="<?=$total_home_lessa?>" id="total_applied_home_lessa">
                </td>
                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>
                        <span class="input-group-addon alert-success">Ganda</span>
                        <input readonly type="text" style="text-align: center;" value="<?=$total_home_ganda?>" class="form-control input-sm s_dag_area_g" name="s_dag_area_g<?=$all_dags->id?>" id="total_applied_home_ganda">
                    </td>
                    <td>
                        <span class="input-group-addon alert-success">Kranti</span>
                        <input readonly type="text" style="text-align: center;" value="<?=$total_home_kranti?>" class="form-control input-sm s_dag_area_kr" name="s_dag_area_kr<?=$all_dags->id?>" id="total_applied_home_kranti">
                    </td>
                <?php endif;?>
            </tr>

            <?php if($service_code == SETTLEMENT_PGR_VGR_LAND_ID): ?>
        <tr class="hide">
        <?php else: ?>
            <tr>
                <?php endif; ?>

                <th colspan="2">Total applied area (Agricultural)</th>
                <td>
                    <span class="input-group-addon alert-success">Bigha</span>
                    <input readonly type="text" style="text-align: center;" name="ag_dag_area_b<?=$all_dags->id?>" class="form-control input-sm ag_dag_area_b" value="<?=$total_agri_bigha?>" id="total_applied_agri_bigha">
                </td>
                <td>
                    <span class="input-group-addon alert-success">Katha</span>
                    <input readonly type="text" style="text-align: center;" name="ag_dag_area_k<?=$all_dags->id?>" value="<?=$total_agri_katha?>" class="form-control input-sm ag_dag_area_k" id="total_applied_agri_katha">
                </td>
                <td>
                    <span class="input-group-addon alert-success">Lessa</span>
                    <input readonly type="text" style="text-align: center;" name="ag_dag_area_lc<?=$all_dags->id?>" class="form-control input-sm ag_dag_area_lc" value="<?=$total_agri_lessa?>" id="total_applied_agri_lessa">
                </td>
                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>
                        <span class="input-group-addon alert-success">Ganda</span>
                        <input readonly type="text" style="text-align: center;" value="<?=$total_agri_ganda?>" class="form-control input-sm ag_dag_area_g" name="ag_dag_area_g<?=$all_dags->id?>" id="total_applied_agri_ganda">
                    </td>
                    <td>
                        <span class="input-group-addon alert-success">Kranti</span>
                        <input readonly type="text" style="text-align: center;" value="<?=$total_agri_kranti?>" class="form-control input-sm ag_dag_area_kr" name="ag_dag_area_kr<?=$all_dags->id?>" id="total_applied_agri_kranti">
                    </td>
                <?php endif;?>
            </tr>
            <tr class="hide">
                <th colspan="2">Total applied area (Fishery)</th>
                <td>
                    <span class="input-group-addon alert-success">Bigha</span>
                    <input readonly type="text" style="text-align: center;" name="fish_dag_area_b<?=$all_dags->id?>" class="form-control input-sm fish_dag_area_b" value="<?=$total_fbigha?>" id="total_applied_fbigha">
                </td>
                <td>
                    <span class="input-group-addon alert-success">Katha</span>
                    <input readonly type="text" style="text-align: center;" name="fish_dag_area_k<?=$all_dags->id?>" value="<?=$total_fkatha?>" class="form-control input-sm fish_dag_area_k" id="total_applied_fkatha">
                </td>
                <td>
                    <span class="input-group-addon alert-success">Lessa</span>
                    <input readonly type="text" style="text-align: center;" name="fish_dag_area_lc<?=$all_dags->id?>" class="form-control input-sm fish_dag_area_lc" value="<?=$total_flessa?>" id="total_applied_flessa">
                </td>
                <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                    <td>
                        <span class="input-group-addon alert-success">Ganda</span>
                        <input readonly type="text" style="text-align: center;" value="<?=$total_fganda?>" class="form-control input-sm fish_dag_area_g" name="fish_dag_area_g<?=$all_dags->id?>" id="total_applied_fganda">
                    </td>
                    <td>
                        <span class="input-group-addon alert-success">Kranti</span>
                        <input readonly type="text" style="text-align: center;" value="<?=$total_fkranti?>" class="form-control input-sm fish_dag_area_kr" name="fish_dag_area_kr<?=$all_dags->id?>" id="total_applied_fkranti">
                    </td>
                <?php endif;?>
            </tr>

            <?php }}}?>

        </table>






        <?php if (isset($reservation) && $reservation == true) {?>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-road" aria-hidden="true"></i>
                Roadside/riverside Reservation
            </h5>

            <table class="table table-bordered">
                <?php $r_count=1; foreach ($reservation as $reserv_road) {
                    if ($reserv_road->type == "R") {?>

                        <input type="hidden" name="dag_no<?=$reserv_road->dag_no?>" value="<?=$reserv_road->dag_no?>">
                        <tr>
                            <th>Roadside/riverside reservation for Dag no. <?=$reserv_road->dag_no?></th>
                            <td>
                                <span class="input-group-addon alert-warning">Bigha</span>
                                <input type="text" style="text-align: center;" value="<?=$reserv_road->bigha?>" class="form-control input-sm" name="reserved_bigha<?=$reserv_road->dag_no?>" id="reserved_bigha">
                            </td>
                            <td>
                                <span class="input-group-addon alert-warning">Katha</span>
                                <input type="text" style="text-align: center;" value="<?=$reserv_road->katha?>" class="form-control input-sm" name="reserved_katha<?=$reserv_road->dag_no?>" id="reserved_katha" >
                            </td>
                            <td>
                                <span class="input-group-addon alert-warning">Lessa</span>
                                <input type="text" style="text-align: center;" value="<?=$reserv_road->lessa?>" class="form-control input-sm" name="reserved_lessa<?=$reserv_road->dag_no?>" id="reserved_lessa" >
                            </td>

                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
                                <td>
                                    <span class="input-group-addon alert-warning">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$reserv_road->ganda?>" class="form-control input-sm" name="reserved_ganda<?=$reserv_road->dag_no?>" >
                                </td>
                                <td>
                                    <span class="input-group-addon alert-warning">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$reserv_road->kranti?>" class="form-control input-sm" name="reserved_kranti<?=$reserv_road->dag_no?>" >
                                </td>
                            <?php endif;?>
                        </tr>
                    <?php }} ?>
            </table>

        <?php }?>

        <?php if (isset($reservation) && $reservation == true) {?>

            <h5 class="reza-title" style="margin-top: 50px">
                <i class="fa fa-users" aria-hidden="true"></i> Family Reservation
            </h5>

            <table class="table table-bordered">
                <?php foreach ($reservation as $reserv) {
                    if ($reserv->type == "F") {?>
                        <tr>
                            <th>Family reservation for Dag no. <?=$reserv->dag_no?></th>
                            <td>
                                <input type="hidden" name="dag_no<?=$reserv->dag_no?>" value="<?=$reserv->dag_no?>">
                                <span class="input-group-addon alert-warning">Bigha</span>
                                <input type="text" style="text-align: center;" value="<?=$reserv->bigha?>" class="form-control input-sm" name="reserved_bigha_family<?=$reserv->dag_no?>" id="reserved_bigha_family">
                            </td>
                            <td>
                                <span class="input-group-addon alert-warning">Katha</span>
                                <input type="text" style="text-align: center;" value="<?=$reserv->katha?>" class="form-control input-sm" name="reserved_katha_family<?=$reserv->dag_no?>" id="reserved_katha_family" >
                            </td>
                            <td>
                                <span class="input-group-addon alert-warning">Lessa</span>
                                <input type="text" style="text-align: center;" value="<?=$reserv->lessa?>" class="form-control input-sm" name="reserved_lessa_family<?=$reserv->dag_no?>" id="reserved_lessa_family" >
                            </td>
                            <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>

                                <td>
                                    <span class="input-group-addon alert-warning">Ganda</span>
                                    <input type="text" style="text-align: center;" value="<?=$reserv->ganda?>" class="form-control input-sm" name="reserved_ganda_family<?=$reserv->dag_no?>" >
                                </td>
                                <td>
                                    <span class="input-group-addon alert-warning">Kranti</span>
                                    <input type="text" style="text-align: center;" value="<?=$reserv->kranti?>" class="form-control input-sm" name="reserved_kranti_family<?=$reserv->dag_no?>" >
                                </td>
                            <?php endif;?>

                        </tr>
                    <?php }}?>
            </table>

        <?php }?>
        <br>
        <div class="row justify-content-center mt-4 mb-5">
            <button type="submit" name="area_update" class="btn btn-success col-6">
                <i class="fa fa-refresh" aria-hidden="true"></i> Update Area Details
            </button>
        </div>
    </form>
</div>



<script>
    function editAreaYes() {
        var x = document.getElementById("edit_area");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
    }

    function editAreaNo() {
        var x = document.getElementById("edit_area");
        if (x.style.display === "block") {
            x.style.display = "none";
        }
    }

    <?php
    if($service_code != SETTLEMENT_AP_TRANSFER_ID && $service_code != SETTLEMENT_TENANT_ID){

    if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))){
    ?>
    function totalAreaCal(){
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseInt($("#mbigha"+i).val());
            var mkatha = parseInt($("#mkatha"+i).val());
            var mlessa = parseInt($("#mlessa"+i).val());
            var mganda = parseInt($("#mganda"+i).val());

            var total_area = total_area + ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);
        }

        var bigha_r = Math.floor(total_area / 6400);
        var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
        var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
        var ganda_r = total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);
        $("#total_applied_home_ganda").val(ganda_r);
    }

    function agriArea(){
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseInt($("#agri_bigha"+i).val());
            var mkatha_agri = parseInt($("#agri_katha"+i).val());
            var mlessa_agri = parseInt($("#agri_lessa"+i).val());
            var mganda_agri = parseInt($("#agri_ganda"+i).val());

            var total_agri_area = total_agri_area + ((mbigha_agri * 6400) + (mkatha_agri * 320) + (mlessa_agri * 20) + mganda_agri);
        }

        var bigha_agri = Math.floor(total_agri_area / 6400);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 6400) / 320);
        var lessa_agri = Math.floor((total_agri_area - (bigha_agri * 6400) - (katha_agri * 320)) / 20);
        var ganda_agri = total_agri_area - bigha_agri * 6400 - katha_agri * 320 - lessa_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
        $("#total_applied_agri_ganda").val(ganda_agri);
    }

    function fisheryArea(){
        // for agri
        var bigha_fish = 0;
        var katha_fish = 0;
        var lessa_fish = 0;
        var length_fish = <?=$total_area_fbigha?>;
        var total_fish_area = 0;
        for(i=1; i<length_fish; i++){
            var mbigha_fish = parseInt($("#fbigha"+i).val());
            var mkatha_fish = parseInt($("#fkatha"+i).val());
            var mlessa_fish = parseInt($("#flessa"+i).val());
            var mganda_fish = parseInt($("#fganda"+i).val());

            var total_fish_area = total_fish_area + ((mbigha_fish * 6400) + (mkatha_fish * 320) + (mlessa_fish * 20) + mganda_fish);
        }

        var bigha_fish = Math.floor(total_fish_area / 6400);
        var katha_fish = Math.floor((total_fish_area - bigha_fish * 6400) / 320);
        var lessa_fish = Math.floor((total_fish_area - (bigha_fish * 6400) - (katha_fish * 320)) / 20);
        var ganda_fish = total_fish_area - bigha_fish * 6400 - katha_fish * 320 - lessa_fish * 20;

        $("#total_applied_fbigha").val(bigha_fish);
        $("#total_applied_fkatha").val(katha_fish);
        $("#total_applied_flessa").val(lessa_fish);
        $("#total_applied_fganda").val(ganda_fish);
    }

    <?php
    }else{?>
    function totalAreaCal(){
        // for homestead
        var length = <?=$total_area_bigha?>;
        var total_area = 0;
        for(i=1; i<length; i++){
            var mbigha = parseInt($("#mbigha"+i).val());
            var mkatha = parseInt($("#mkatha"+i).val());
            var mlessa = parseInt($("#mlessa"+i).val());
            var total_area = total_area + ((mbigha * 100) + (mkatha * 20) + mlessa);
        }

        var bigha_r = Math.floor(total_area / 100);
        var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
        var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

        $("#total_applied_home_bigha").val(bigha_r);
        $("#total_applied_home_katha").val(katha_r);
        $("#total_applied_home_lessa").val(lessa_r);

    }

    function agriArea(){
        // for agri
        var bigha_agri = 0;
        var katha_agri = 0;
        var lessa_agri = 0;
        var length_agri = <?=$total_area_agri_bigha?>;
        var total_agri_area = 0;
        for(i=1; i<length_agri; i++){
            var mbigha_agri = parseInt($("#agri_bigha"+i).val());
            var mkatha_agri = parseInt($("#agri_katha"+i).val());
            var mlessa_agri = parseInt($("#agri_lessa"+i).val());
            var total_agri_area = total_agri_area + ((mbigha_agri * 100) + (mkatha_agri * 20) + mlessa_agri);
        }
        // alert(total_agri_area);
        var bigha_agri = Math.floor(total_agri_area / 100);
        var katha_agri = Math.floor((total_agri_area - bigha_agri * 100) / 20);
        var lessa_agri = total_agri_area - bigha_agri * 100 - katha_agri * 20;

        $("#total_applied_agri_bigha").val(bigha_agri);
        $("#total_applied_agri_katha").val(katha_agri);
        $("#total_applied_agri_lessa").val(lessa_agri);
    }

    function fisheryArea(){
        // for agri
        var bigha_fish = 0;
        var katha_fish = 0;
        var lessa_fish = 0;
        var length_fish = <?=$total_area_fbigha?>;
        var total_fish_area = 0;
        for(i=1; i<length_fish; i++){
            var mbigha_fish = parseInt($("#fbigha"+i).val());
            var mkatha_fish = parseInt($("#fkatha"+i).val());
            var mlessa_fish = parseInt($("#flessa"+i).val());
            var total_fish_area = total_fish_area + ((mbigha_fish * 100) + (mkatha_fish * 20) + mlessa_fish);
        }
        // alert(total_fish_area);
        var bigha_fish = Math.floor(total_fish_area / 100);
        var katha_fish = Math.floor((total_fish_area - bigha_fish * 100) / 20);
        var lessa_fish = total_fish_area - bigha_fish * 100 - katha_fish * 20;

        $("#total_applied_fbigha").val(bigha_fish);
        $("#total_applied_fkatha").val(katha_fish);
        $("#total_applied_flessa").val(lessa_fish);
    }

    <?php }}?>


</script>
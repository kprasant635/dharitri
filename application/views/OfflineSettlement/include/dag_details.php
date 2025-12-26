<div class="tableCard">
    <table class="table table-bordered">

        <?php foreach($dags as $dagspremlm): ?>
            <div class="row p-2" >
                <div class="col-md-6">
                    <span><strong style="color:red"> Area Type for Dag No : <?=$dagspremlm->dag_no?></strong></span>
                    <?=form_error('area'.$dagspremlm->dag_no)?>
                </div>

                <div class="col-md-6">

                    <input type="hidden" name='area_new<?=$dagspremlm->dag_no?>' id='area_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaCategory($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                    <?=form_error('area_new'.$dagspremlm->dag_no)?>
                    <input class="form-control" type="text" name='area_cat_new<?=$dagspremlm->dag_no?>' id='area_cat_new<?=$dagspremlm->dag_no?>' value='<?=$this->utilityclass->getAreaName($dagspremlm->dist_code,$dagspremlm->subdiv_code,$dagspremlm->cir_code,$dagspremlm->mouza_pargona_code,$dagspremlm->lot_no,$dagspremlm->vill_townprt_code,$dagspremlm->dag_no)?>'>
                </div>
            </div>


        <?php endforeach;?>

    </table>

    <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;" class="<?php if(form_error('totalAppliedAdditionalArea')){echo 'is-invalid';} ?>">
        <?=form_error('totalAppliedAdditionalArea');?>
    </div>
    <div style="font-weight: bold!important; font-size: 18px!important; margin-bottom: 5px!important;"
         class="<?php if(form_error('totalAppliedAreaInUrban')){echo 'is-invalid';} ?>">
        <?=form_error('totalAppliedAreaInUrban');?>
    </div>
    <table class="table mb-0">
        <thead class="thead-warning">
        <tr>
            <th>#</th>
            <th>Description</th>
            <th class="text-center">Bigha</th>
            <th class="text-center">Katha</th>
            <th class="text-center"><?=$lessa_chatak?></th>
            <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                <th class="text-center">Ganda</th>
                <th class="text-center hide">Kranti</th>
            <?php endif; ?>
        </tr>
        </thead>
        <?php
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
                <th rowspan="6" style="vertical-align : middle!important;   ">
                    <div class="vertical">
                        DAG : <span class="text-danger"><?=$all_dags->dag_no?></span>
                        PATTA : <span class="text-danger"><?=$all_dags->patta_no?></span>
                        <input type="hidden" id="dag_no<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_no?>">
                        <input type="hidden" id="patta_no<?=$all_dags->dag_no?>" value="<?=$all_dags->patta_no?>">
                        <input type="hidden" name="is_urban" id="urbanCheck<?=$all_dags->dag_no?>" value="<?=$all_dags->is_urban?>">
                    </div>
                </th>
                <th class="bg-white">Total Land Area in Selected Dag</th>
                <td class="bg-white">
                    <strong>
                        <input type="text" style="text-align: center;" name="dag_area_b<?=$all_dags->dag_no?>" id="dag_area_b<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?=$all_dags->dag_area_b;?>" readonly>
                    </strong>
                </td>
                <td class="bg-white">
                    <input type="text" style="text-align: center;" name="dag_area_k<?=$all_dags->dag_no?>" id="dag_area_k<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_area_k;?>" class="form-control input-sm" readonly>
                </td>
                <td class="bg-white">
                    <input type="text" style="text-align: center;" name="dag_area_lc<?=$all_dags->dag_no?>" id="dag_area_lc<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?= $all_dags->dag_area_lc;?>" readonly>
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="bg-white">
                        <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_g?>" class="form-control input-sm" name="dag_area_g<?=$all_dags->dag_no?>" id="dag_area_g<?=$all_dags->dag_no?>" readonly>
                    </td>
                    <td class="bg-white hide">
                        <input type="text" style="text-align: center;" value="<?=$all_dags->dag_area_kr;?>" class="form-control input-sm" name="dag_area_kr<?=$all_dags->dag_no?>" id="dag_area_kr<?=$all_dags->dag_no?>" readonly>
                    </td>
                <?php endif;?>
            </tr>
            <?php $hide = 'area_show';
            if ($all_dags->land_type == 3 || $all_dags->land_type == 1) {
                $hide = 'area_show';
            } else {
                $hide = 'area_hide';
            }
            ?>
            <?php
            $encroachment_area = json_decode($all_dags->encroachement_area);
            ?>
            <tr>
                <th class="text-success enc-area-color">Encroachment Area (Homestead)</th>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$all_dags->dag_no?>" id="enc_home_b<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$encroachment_area->homestead->bigha;?>">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$all_dags->dag_no?>" id="enc_home_k<?=$all_dags->dag_no?>" value="<?=$encroachment_area->homestead->katha;?>" class="form-control input-sm enc_home_k">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$all_dags->dag_no?>" id="enc_home_lc<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_lc" value="<?=$encroachment_area->homestead->lessa;?>">
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="enc-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->homestead->ganda;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_dags->dag_no?>" id="enc_home_g<?=$all_dags->dag_no?>">
                    </td>
                    <td class="enc-area-color hide">
                        <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->homestead->kranti;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_dags->dag_no?>" id="enc_home_kr<?=$all_dags->dag_no?>">
                    </td>
                <?php endif;?>
            </tr>
            <tr>
                <th class="text-success enc-area-color">Encroachment Area (Agricultural)</th>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_agri_b<?=$all_dags->dag_no?>" id="enc_agri_b<?=$all_dags->dag_no?>" class="form-control input-sm agri_b" value="<?=$encroachment_area->agriculture->bigha;?>">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_agri_k<?=$all_dags->dag_no?>" id="enc_agri_k<?=$all_dags->dag_no?>" value="<?=$encroachment_area->agriculture->katha;?>" class="form-control input-sm agri_k">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_agri_lc<?=$all_dags->dag_no?>" id="enc_agri_lc<?=$all_dags->dag_no?>" class="form-control input-sm agri_lc" value="<?=$encroachment_area->agriculture->lessa;?>">
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="enc-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->agriculture->ganda;?>" class="form-control input-sm agri_g" name="enc_agri_g<?=$all_dags->dag_no?>" id="enc_agri_g<?=$all_dags->dag_no?>" onkeyup="agriArea()">
                    </td>
                    <td class="enc-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$encroachment_area->agriculture->kranti;?>" class="form-control input-sm agri_kr hide" name="enc_agri_kr<?=$all_dags->dag_no?>" id="enc_agri_kr<?=$all_dags->dag_no?>">
                    </td>
                <?php endif;?>
            </tr>
            <tr class='<?=$hide?>'>
                <th class="text-primary settlement-area-color">Area for Settlement (Homestead)</th>
                <td class="settlement-area-color">
                    <input readonly type="text" style="text-align: center;" name="home_b<?=$all_dags->dag_no?>" class="form-control input-sm home_b" value="<?=$all_dags->home_b;?>" onkeyup="totalAreaCal()" id="home_b<?=$all_dags->dag_no?>">
                </td>
                <td class="settlement-area-color">
                    <input readonly type="text" style="text-align: center;" name="home_k<?=$all_dags->dag_no?>" value="<?=$all_dags->home_k;?>" class="form-control input-sm home_k" onkeyup="totalAreaCal()" id="home_k<?=$all_dags->dag_no?>">
                </td>
                <td class="settlement-area-color">
                    <input readonly type="text" style="text-align: center;" name="home_lc<?=$all_dags->dag_no?>" class="form-control input-sm s_dag_area_lc" value="<?=$all_dags->home_lc;?>" onkeyup="totalAreaCal()" id="home_lc<?=$all_dags->dag_no?>">
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="settlement-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->home_g;?>" class="form-control input-sm s_dag_area_g" name="home_g<?=$all_dags->dag_no?>" onkeyup="totalAreaCal()" id="home_g<?=$all_dags->dag_no?>">
                    </td>
                    <td class="settlement-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->home_kr;?>" class="form-control input-sm s_dag_area_kr hide" name="home_kr<?=$all_dags->dag_no?>" onkeyup="totalAreaCal()" id="home_kr<?=$all_dags->dag_no?>">
                    </td>
                <?php endif;?>
            </tr>
            <?php $hide = 'area_show';
            if ($all_dags->land_type == 2)
            {
                $hide = 'area_show';
            }
            else
            {
                $hide = 'area_hide';
            }

            ?>
            <tr class='<?=$hide?>'>
                <th class="text-primary settlement-area-color">Area for Settlement (Agricultural)</th>
                <td class="settlement-area-color">
                    <input readonly type="text" style="text-align: center;" name="agri_b<?=$all_dags->dag_no?>" class="form-control input-sm agri_b" value="<?=$all_dags->agri_b;?>" onkeyup="agriArea()" id="agri_b<?=$all_dags->dag_no?>">
                </td>
                <td class="settlement-area-color">
                    <input readonly type="text" style="text-align: center;" name="agri_k<?=$all_dags->dag_no?>" value="<?=$all_dags->agri_k;?>" class="form-control input-sm agri_k" onkeyup="agriArea()" id="agri_k<?=$all_dags->dag_no?>">
                </td>
                <td class="settlement-area-color">
                    <input readonly type="text" style="text-align: center;" name="agri_lc<?=$all_dags->dag_no?>" class="form-control input-sm agri_lc" value="<?=$all_dags->agri_lc;?>" onkeyup="agriArea()" id="agri_lc<?=$all_dags->dag_no?>">
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="settlement-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->agri_g;?>" class="form-control input-sm agri_g" name="agri_g<?=$all_dags->dag_no?>" onkeyup="agriArea()" id="agri_g<?=$all_dags->dag_no?>">
                    </td>
                    <td class="settlement-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->agri_kr;?>" class="form-control input-sm agri_kr hide" name="agri_kr<?=$all_dags->dag_no?>" onkeyup="agriArea()" id="agri_kr<?=$all_dags->dag_no?>">
                    </td>
                <?php endif;?>
            </tr>
            <tr style="display:none">
                <th class="text-primary settlement-area-color">Applied area (Fishery)</th>
                <td class="settlement-area-color">
                    <span class="input-group-addon">Bigha</span>
                    <input type="text" style="text-align: center;" required name="fbigha<?=$all_dags->dag_no?>" class="form-control input-sm fbigha" value="<?=$all_dags->fbigha?>" onkeyup="fisheryArea()" id="fbigha<?=$total_area_fbigha++?>">
                </td>
                <td class="settlement-area-color">
                    <span class="input-group-addon">Katha</span>
                    <input type="text" style="text-align: center;" required name="fkatha<?=$all_dags->dag_no?>" value="<?=$all_dags->fkatha?>" class="form-control input-sm fkatha" onkeyup="fisheryArea()" id="fkatha<?=$total_area_fkatha++?>">
                </td>
                <td class="settlement-area-color">
                    <span class="input-group-addon">Lessa</span>
                    <input type="text" style="text-align: center;" required name="flessa<?=$all_dags->dag_no?>" class="form-control input-sm flessa" value="<?=$all_dags->flessa?>" onkeyup="fisheryArea()" id="flessa<?=$total_area_flessa++?>">
                </td>
                <?php if((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="settlement-area-color">
                        <span class="input-group-addon">Ganda</span>
                        <input type="text" style="text-align: center;"  value="<?=$all_dags->fganda?>" class="form-control input-sm fganda" name="fganda<?=$all_dags->dag_no?>" onkeyup="fisheryArea()" id="fganda<?=$total_area_fganda++?>">
                    </td>
                    <td class="settlement-area-color">
                        <span class="input-group-addon">Kranti</span>
                        <input type="text" style="text-align: center;"  value="<?=$all_dags->fkranti?>" class="form-control input-sm fkranti" name="fkranti<?=$all_dags->dag_no?>" onkeyup="fisheryArea()" id="fkranti<?=$total_area_fkranti++?>">
                    </td>
                <?php endif ; ?>
            </tr>
            <tr style="border-bottom:1px solid #227576">
                <td colspan="2">
                    <?php if (in_array($this->session->userdata('user_desig_code'), OFFLINE_SETTLEMENT_EDIT_OPTION_ACCESS)): ?>
                        <?php if(OFFLINE_SETTLEMENT_ENABLE_AREA_BUTTON == 1){ ?>
                            <button type="button" id="editarea<?=$all_dags->id?>" onclick="editArea(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-warning">Edit Area</button>
                        <?php } ?>

                        <?php if(OFFLINE_SETTLEMENT_ENABLE_DAG_ELIGIBLE_BUTTON == 1){ ?>
                            <?php if($dag_count>1){?>
                                <button type="button" id="deldag<?=$all_dags->id?>" onclick="deleteDag(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-danger"><i class="fa fa-remove" style="color:white"></i> Dag Not Eligible</button>
                                <button type="button" id="insdag<?=$all_dags->id?>" onclick="insertDag(<?=$all_dags->id?>,<?=$all_dags->dag_no?>);" class="btn btn-sm btn-success" style="display:none">Eligible</button>
                            <?php } ?>
                        <?php } ?>
                    <?php endif; ?>

                    <div id="dageligiblemsg<?=$all_dags->id?>" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; display:none">

                    </div>
                </td>

                <!--                <td colspan="2" class="text-right">-->
                <!--                    <a type="button" target="_blank" class="btn-sm  buttInfo" href="--><?php // echo base_url(); ?><!--index.php/SettlementCommon/apiDagWiseApplication?app=--><?php //echo $basic->applid;?><!--&dag=--><?php //echo $all_dags->dag_no;?><!--" style="text-decoration: none">-->
                <!--                        <small style="font-size:14px; color:white; font-weight:bold">-->
                <!--                            <i class="fa fa-eye"></i> View Total Applications in this Dag-->
                <!--                        </small>-->
                <!--                    </a>-->
                <!--                </td>-->

            </tr>

        <?php }?>

        <?php if (in_array($this->session->userdata('user_desig_code'), OFFLINE_SETTLEMENT_EDIT_OPTION_ACCESS)): ?>

            <?php
            // for dag not eligible
            include(APPPATH."views/OfflineSettlement/include/dag_not_eligible_view.php");
            ?>

        <?php endif; ?>

        <tr class="bg-white" style="border-top: 3px solid #227576;">
            <th rowspan="2"></th>
            <th class="text-danger">
                Total Settlement Area (Homestead)
                <span class="<?php if(form_error('khasMaxHomestead') ){echo 'is-invalid';}?>"></span>
                <?=form_error('khasMaxHomestead');?>
            </th>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_bigha" required class="form-control input-sm s_dag_area_b" id="total_applied_home_bigha" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_bigha');}else{ echo $total_home_bigha;}?>" >
            </td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_katha" required value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_katha');}else{ echo $total_home_katha;}?>" id="total_applied_home_katha" class="form-control input-sm s_dag_area_k" >
            </td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_area_homestead_lessa" required class="form-control input-sm s_dag_area_lc" id="total_applied_home_lessa" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_lessa');}else{ echo $total_home_lessa;}?>" >
            </td>
            <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                <td>
                    <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_ganda');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_g" id="total_applied_home_ganda" name="total_applied_area_homestead_ganda" >
                </td>
                <td class="hide">
                    <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_homestead_kranti');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_kr hide" id="total_applied_home_kranti" name="total_applied_area_homestead_kranti" >
                </td>
            <?php endif;?>
        </tr>
        <tr>
            <th class="text-danger">
                Total applied area (Agricultural)
                <span class="<?php if(form_error('khasMaxAgriculture') ){echo 'is-invalid';}?>"></span>
                <?=form_error('khasMaxAgriculture');?>
            </th>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_bigha" class="form-control input-sm ag_dag_area_b"  id="total_applied_agri_bigha"
                       value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_bigha');}else{ echo $total_agri_bigha;}?>">
            </td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_katha" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_katha');}else{ echo $total_agri_katha;}?>" id="total_applied_agri_katha"  class="form-control input-sm ag_dag_area_k" >
            </td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_area_agricultural_lessa" class="form-control input-sm ag_dag_area_lc" id="total_applied_agri_lessa"  value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_lessa');}else{ echo $total_agri_lessa;}?>" >
            </td>
            <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                <td>
                    <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_ganda');}else{ echo $total_agri_ganda;}?>" class="form-control input-sm ag_dag_area_g" id="total_applied_agri_ganda"  name="total_applied_area_agricultural_ganda" >
                </td>
                <td class="hide">
                    <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_area_agricultural_kranti');}else{ echo $total_agri_kranti;}?>" class="form-control input-sm ag_dag_area_kr hide" id="total_applied_agri_kranti"  name="total_applied_area_agricultural_kranti" >
                </td>
            <?php endif;?>
        </tr>

    </table>

    <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
    <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
    <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
    <strong><?=form_error('appAreaMoreThanDagA');?></strong>
    <br>

    <!--    --><?php //if(OFFLINE_SETTLEMENT_ENABLE_DAG_CHANGE_BUTTON == 1) { ?>
    <!--        <a href="--><?php //echo base_url();?><!--index.php/NcLmKhaslandController/firstProceeding?an=--><?php //echo $_GET['app'];?><!--"-->
    <!--           type="button" class="btn btn-sm btn-success pull-right" id="add_new_dag" >-->
    <!--            <i class="fa fa-plus"></i>&nbsp;&nbsp;ADD NEW DAG-->
    <!--        </a>-->
    <!--        <br><br>-->


    <!--    --><?php //} ?>


</div>


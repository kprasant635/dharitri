<div class="tableCard">
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

        $total_area_bigha = 1;
        $total_area_katha = 1;
        $total_area_lessa = 1;
        $total_area_ganda = 1;
        $total_area_kranti = 1;

        foreach ($dags as $all_dags)
        {
            $total_home_bigha = $total_home_bigha + $all_dags->s_dag_area_b;
            $total_home_katha = $total_home_katha + $all_dags->s_dag_area_k;
            $total_home_lessa = $total_home_lessa + $all_dags->s_dag_area_lc;
            $total_home_ganda = $total_home_ganda + $all_dags->s_dag_area_g;
            $total_home_kranti = $total_home_kranti + $all_dags->s_dag_area_kr;


            ?>
            <tr>
                <th rowspan="2" style="vertical-align : middle!important;   ">
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
            <tr>
                <th class="text-success enc-area-color">Applied Area</th>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$all_dags->dag_no?>" id="enc_home_b<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$all_dags->s_dag_area_b;?>">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$all_dags->dag_no?>" id="enc_home_k<?=$all_dags->dag_no?>" value="<?=$all_dags->s_dag_area_k;?>" class="form-control input-sm enc_home_k">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$all_dags->dag_no?>" id="enc_home_lc<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_lc" value="<?=$all_dags->s_dag_area_lc;?>">
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="enc-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->s_dag_area_g;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_dags->dag_no?>" id="enc_home_g<?=$all_dags->dag_no?>">
                    </td>
                    <td class="enc-area-color hide">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->s_dag_area_kr;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_dags->dag_no?>" id="enc_home_kr<?=$all_dags->dag_no?>">
                    </td>
                <?php endif;?>
            </tr>

        <?php }?>


        <tr class="bg-white" style="border-top: 3px solid #227576;">
            <th class="text-danger">
                Total Applied Area
                <span class="<?php if(form_error('khasMaxHomestead') ){echo 'is-invalid';}?>"></span>
                <?=form_error('khasMaxHomestead');?>
            </th>
            <td></td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_bigha" required class="form-control input-sm s_dag_area_b" id="total_applied_bigha" value="<?php if(isset($err_return)){ echo set_value('total_applied_bigha');}else{ echo $total_home_bigha;}?>" >
            </td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_katha" required value="<?php if(isset($err_return)){ echo set_value('total_applied_katha');}else{ echo $total_home_katha;}?>" id="total_applied_katha" class="form-control input-sm s_dag_area_k" >
            </td>
            <td>
                <input readonly type="text" style="text-align: center;" name="total_applied_lessa" required class="form-control input-sm s_dag_area_lc" id="total_applied_lessa" value="<?php if(isset($err_return)){ echo set_value('total_applied_lessa');}else{ echo $total_home_lessa;}?>" >
            </td>
            <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                <td>
                    <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_ganda');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_g" id="total_applied_ganda" name="total_applied_ganda" >
                </td>
                <td class="hide">
                    <input readonly type="text" style="text-align: center;" value="<?php if(isset($err_return)){ echo set_value('total_applied_kranti');}else{ echo $total_home_ganda;}?>" required class="form-control input-sm s_dag_area_kr hide" id="total_applied_kranti" name="total_applied_kranti" >
                </td>
            <?php endif;?>
        </tr>


    </table>




</div>


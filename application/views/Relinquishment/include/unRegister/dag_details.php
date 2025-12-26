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

        foreach ($rel_dag as $all_dags)
        {

            $total_home_bigha = $total_home_bigha + $all_dags->applied_bigha;
            $total_home_katha = $total_home_katha + $all_dags->applied_katha;
            $total_home_lessa = $total_home_lessa + $all_dags->applied_lessa;
            $total_home_ganda = $total_home_ganda + $all_dags->applied_ganda;
            $total_home_kranti = $total_home_kranti + $all_dags->applied_kranti;

            ?>
            <tr>
                <th rowspan="2" style="vertical-align : middle!important;   ">
                    <div class="vertical">
                        DAG : <span class="text-danger"><?=$all_dags->dag_no?></span>
                        PATTA : <span class="text-danger"><?=$all_dags->patta_no?></span>
                        <input type="hidden" id="dag_no<?=$all_dags->dag_no?>" value="<?=$all_dags->dag_no?>">
                        <input type="hidden" id="patta_no<?=$all_dags->dag_no?>" value="<?=$all_dags->patta_no?>">

                    </div>
                </th>
                <th class="bg-white">Total Land Area in Selected Dag</th>
                <td class="bg-white">
                    <strong>
                        <input type="text" style="text-align: center;" name="dag_area_b<?=$all_dags->dag_no?>" id="dag_area_b<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?=$all_dags->available_bigha;?>" readonly>
                    </strong>
                </td>
                <td class="bg-white">
                    <input type="text" style="text-align: center;" name="dag_area_k<?=$all_dags->dag_no?>" id="dag_area_k<?=$all_dags->dag_no?>" value="<?=$all_dags->available_katha;?>" class="form-control input-sm" readonly>
                </td>
                <td class="bg-white">
                    <input type="text" style="text-align: center;" name="dag_area_lc<?=$all_dags->dag_no?>" id="dag_area_lc<?=$all_dags->dag_no?>" class="form-control input-sm" value="<?= $all_dags->available_lessa;?>" readonly>
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="bg-white">
                        <input type="text" style="text-align: center;" value="<?=$all_dags->available_ganda?>" class="form-control input-sm" name="dag_area_g<?=$all_dags->dag_no?>" id="dag_area_g<?=$all_dags->dag_no?>" readonly>
                    </td>
                    <td class="bg-white hide">
                        <input type="text" style="text-align: center;" value="<?=$all_dags->available_kranti;?>" class="form-control input-sm" name="dag_area_kr<?=$all_dags->dag_no?>" id="dag_area_kr<?=$all_dags->dag_no?>" readonly>
                    </td>
                <?php endif;?>
            </tr>

            <tr>
                <th class="text-success enc-area-color">Applied Area</th>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_b<?=$all_dags->dag_no?>" id="enc_home_b<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_b" value="<?=$all_dags->applied_bigha;?>">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_k<?=$all_dags->dag_no?>" id="enc_home_k<?=$all_dags->dag_no?>" value="<?=$all_dags->applied_katha;?>" class="form-control input-sm enc_home_k">
                </td>
                <td class="enc-area-color">
                    <input readonly type="text" style="text-align: center;" name="enc_home_lc<?=$all_dags->dag_no?>" id="enc_home_lc<?=$all_dags->dag_no?>" class="form-control input-sm enc_home_lc" value="<?=$all_dags->applied_lessa;?>">
                </td>
                <?php if ((in_array($basic->dist_code, json_decode(BARAK_VALLEY)))): ?>
                    <td class="enc-area-color">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->applied_ganda;?>" class="form-control input-sm enc_home_g" name="enc_home_g<?=$all_dags->dag_no?>" id="enc_home_g<?=$all_dags->dag_no?>">
                    </td>
                    <td class="enc-area-color hide">
                        <input readonly type="text" style="text-align: center;" value="<?=$all_dags->applied_kranti;?>" class="form-control input-sm enc_home_kr" name="enc_home_kr<?=$all_dags->dag_no?>" id="enc_home_kr<?=$all_dags->dag_no?>">
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

    <span class="<?php if(form_error('totalAppliedAreaZeroCheck')){echo 'is-invalid';}?>"></span>
    <strong><?=form_error('totalAppliedAreaZeroCheck');?></strong>
    <span class="<?php if(form_error('appAreaMoreThanDagA')){echo 'is-invalid';}?>"></span>
    <strong><?=form_error('appAreaMoreThanDagA');?></strong>
    <br>



</div>

<?php
$posdate = null;
$barak_ad_prop_total  = "";
$aditional_prop_total = "";

// Check for Additional Property
if (!empty($additional_property))
{
    // For Barak area
    if (!empty($total_aditional_area_g))
    {
        $barak_ad_prop_total = "{$total_aditional_area_g->bigha} বিঘা, {$total_aditional_area_g->katha} কঠা, {$total_aditional_area_g->lecha} লেচা, {$total_aditional_area_g->gunta} গণ্ডা";
    }

    // For other areas
    if (!empty($total_aditional_area))
    {
        $aditional_prop_total = "{$total_aditional_area->bigha} বিঘা, {$total_aditional_area->katha} কঠা, {$total_aditional_area->lecha} লেচা, {$total_aditional_area->gunta} গণ্ডা";
    }

    // Merge both if both exist
    if (!empty($barak_ad_prop_total) && !empty($aditional_prop_total))
    {
        $aditional_prop_total = $barak_ad_prop_total . " আৰু " . $aditional_prop_total;
    }
    elseif (!empty($barak_ad_prop_total))
    {
        $aditional_prop_total = $barak_ad_prop_total;
    }

}
else
{
    // Default if applicant is landless
    $aditional_prop_total = "ভূমিহীন, অসমৰ ক'তও গৃহ ভূমি নথকা";
}


if($basic->is_urban=="Y")
{
    $lmtown      = "টাউনৰ অন্তৰ্গত ";
    $lmposession = "ঘৰবস্তী ( টিনচালিৰঘৰ / অসমআৰ্হিৰঘৰ / আৰ চি চিঘৰ ) ";
    $lmposdate   = "২৮ জুন, ২০০১ চনৰ ";
}
else
{
    $lmtown      = "";
    $lmposession = "ঘৰবস্তী / খেতি-বাতি ";
    $lmposdate   = $posdate;
}


if((in_array($basic->dist_code, json_decode(BARAK_VALLEY))))
{
    if(isset($property) && !empty($property))
    {
        $resultprop = array();
        foreach($property as $isproperty):
            $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে " .$isproperty->ganda. " গ";
        endforeach;
        $aditional_prop_temp=implode(",",$resultprop);
        $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
    }
    else
    {
        $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
    }
}
else
{
    if(isset($property) && !empty($property))
    {
        $resultprop = array();
        foreach($property as $isproperty):
            $resultprop[]=$isproperty->bigha." বি " .$isproperty->katha. " ক " .$isproperty->lessa. " লে";
        endforeach;
        $aditional_prop_temp=implode(",",$resultprop);
        $aditional_prop = $aditional_prop_temp. " ভূমি থকা কৃষক";
    }
    else
    {
        $aditional_prop="ভূমিহীন অসমৰ কতো গৃহ ভূমি নথকা";
    }
}

?>

<?php
if((in_array($basic->dist_code, json_decode(BARAK_VALLEY))))
{
    foreach ($settlements as $ss)
    {
        if($ss->is_applicant == 1)
        {
            $app_name= $ss->name_ass;
        }
    }
    foreach($rel_dag as $dags_lmtemplate)
    {
//        if ($dags_lmtemplate->is_applicant == 1)
//        {
//            $app_name   = $dags_lmtemplate->pdar_name;
        $resultdags = $dags_lmtemplate->dag_no;
//        }
//        ?>
        <input type="hidden" id="sbigha" name='sbigha'>
        <input type="hidden" id="skatha" name='skatha'>
        <input type="hidden" id="slessa" name='slessa'>
        <input type="hidden" id="sganda" name='sganda'>

        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
        <input type="hidden" id="alloted_katha" name='alloted_katha'>
        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>
        <input type="hidden" id="alloted_ganda" name='alloted_ganda'>

        <script>
            function totalAppliedArea(){
                var total_area = 0;
                var mbigha = parseFloat($("#s_dag_area_b").val());
                var mkatha = parseFloat($("#s_dag_area_k").val());
                var mlessa = parseFloat($("#s_dag_area_lc").val());
                var mganda = parseFloat($("#s_dag_area_g").val());
                var total_area = ((mbigha * 6400) + (mkatha * 320) + (mlessa * 20) + mganda);


                var bigha_r = Math.floor(total_area / 100);
                var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                var bigha_r = Math.floor(total_area / 6400);
                var katha_r = Math.floor((total_area - bigha_r * 6400) / 320);
                var lessa_r = Math.floor((total_area - (bigha_r * 6400) - (katha_r * 320)) / 20);
                var ganda_r = (total_area - bigha_r * 6400 - katha_r * 320 - lessa_r * 20).toFixed(2);

                $("#sbigha").val(bigha_r);
                $("#skatha").val(katha_r);
                $("#slessa").val(lessa_r);
                $("#sganda").val(ganda_r);

                var total_road_reserved = 0;
                var total_lm_reserved = 0;
                var total_family_reserved = 0;
                var total_lm_family_reserved = 0;
                <?php //foreach($dags as $dags_lmtemplate3){ ?>

                var road_bigha=$("#reserved_bigha").val() ? parseFloat($("#reserved_bigha").val()) : 0;
                var road_katha=$("#reserved_katha").val() ? parseFloat($("#reserved_katha").val()) : 0;
                var road_lessa=$("#reserved_lessa").val() ? parseFloat($("#reserved_lessa").val()) : 0;
                var road_ganda=$("#reserved_ganda").val() ? parseFloat($("#reserved_ganda").val()) : 0;
                total_road_reserved = parseFloat((road_bigha * 6400) + (road_katha * 320) + (road_lessa * 20) + road_ganda);
                total_lm_reserved = total_lm_reserved + total_road_reserved;

                var family_bigha=$("#reserved_bigha_family").val() ? parseFloat($("#reserved_bigha_family").val()) : 0;
                var family_katha=$("#reserved_katha_family").val() ? parseFloat($("#reserved_katha_family").val()) : 0;
                var family_lessa=$("#reserved_lessa_family").val() ? parseFloat($("#reserved_lessa_family").val()) : 0;
                var family_ganda=$("#reserved_ganda_family").val() ? parseFloat($("#reserved_ganda_family").val()) : 0;
                total_family_reserved = parseFloat((family_bigha * 6400) + (family_katha * 320) + (family_lessa * 20) + family_ganda);
                total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                <?php //} ?>

                var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                var alloted_bigha = Math.floor(total_alloted_area / 6400);
                var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 6400) / 320);
                var alloted_lessa = Math.floor((total_alloted_area - (alloted_bigha * 6400) - (alloted_katha * 320)) / 20);
                var alloted_ganda = (total_alloted_area - alloted_bigha * 6400 - alloted_katha * 320 - alloted_lessa * 20).toFixed(2);
                // alert(total_alloted_area);
                $("#alloted_bigha").val(alloted_bigha);
                $("#alloted_katha").val(alloted_katha);
                $("#alloted_lessa").val(alloted_lessa);
                $("#alloted_ganda").val(alloted_ganda);

            }
        </script>

    <?php }
    $all_dags = $resultdags;
    ?>

<?php }
else
{

    foreach ($settlements as $ss)
    {
        if($ss->is_applicant == 1)
        {
            $app_name= $ss->name_ass;
        }
    }
    foreach($rel_dag as $dags_lmtemplate)
    {

        $resultdags = $dags_lmtemplate->dag_no;

        ?>

        <input type="hidden" id="sbigha" name='sbigha'>
        <input type="hidden" id="skatha" name='skatha'>
        <input type="hidden" id="slessa" name='slessa'>

        <input type="hidden" id="alloted_bigha" name='alloted_bigha'>
        <input type="hidden" id="alloted_katha" name='alloted_katha'>
        <input type="hidden" id="alloted_lessa" name='alloted_lessa'>

        <script>
            function totalAppliedArea(){
                var total_area = 0;
                var mbigha = parseFloat($("#s_dag_area_b").val());
                var mkatha = parseFloat($("#s_dag_area_k").val());
                var mlessa = parseFloat($("#s_dag_area_lc").val());
                var total_area = ((mbigha * 100) + (mkatha * 20) + mlessa);


                var bigha_r = Math.floor(total_area / 100);
                var katha_r = Math.floor((total_area - bigha_r * 100) / 20);
                var lessa_r = total_area - bigha_r * 100 - katha_r * 20;

                $("#sbigha").val(bigha_r);
                $("#skatha").val(katha_r);
                $("#slessa").val(lessa_r);

                var total_road_reserved = 0;
                var total_lm_reserved = 0;
                var total_family_reserved = 0;
                var total_lm_family_reserved = 0;
                <?php //foreach($dags as $dags_lmtemplate3){ ?>
                var road_bigha=$("#reserved_bigha").val() ? parseFloat($("#reserved_bigha").val()) : 0;
                var road_katha=$("#reserved_katha").val() ? parseFloat($("#reserved_katha").val()) : 0;
                var road_lessa=$("#reserved_lessa").val() ? parseFloat($("#reserved_lessa").val()) : 0;
                total_road_reserved = (road_bigha * 100) + (road_katha * 20) + road_lessa;
                total_lm_reserved = total_lm_reserved + total_road_reserved;

                var family_bigha=$("#reserved_bigha_family").val() ? parseFloat($("#reserved_bigha_family").val()) : 0;
                var family_katha=$("#reserved_katha_family").val() ? parseFloat($("#reserved_katha_family").val()) : 0;
                var family_lessa=$("#reserved_lessa_family").val() ? parseFloat($("#reserved_lessa_family").val()) : 0;
                total_family_reserved = parseFloat((family_bigha * 100) + (family_katha * 20) + family_lessa);
                total_lm_family_reserved = total_lm_family_reserved + total_family_reserved;
                <?php //} ?>

                var total_alloted_area = total_area - total_lm_reserved - total_lm_family_reserved;

                var alloted_bigha = Math.floor(total_alloted_area / 100);
                var alloted_katha = Math.floor((total_alloted_area - alloted_bigha * 100) / 20);
                var alloted_lessa = total_alloted_area - alloted_bigha * 100 - alloted_katha * 20;
                // alert(total_alloted_area);
                $("#alloted_bigha").val(alloted_bigha);
                $("#alloted_katha").val(alloted_katha);
                $("#alloted_lessa").val(alloted_lessa);

            }
        </script>

    <?php }
    $all_dags = $resultdags;

}
?>

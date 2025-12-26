<?php foreach ($deleted_dags as $all_delete_dag) {?>

<tr class="bg-white">
    <th rowspan="6" style="vertical-align : middle;">
        <div class="vertical">
            DAG : <span class="text-danger"><?=$all_delete_dag->dag_no?></span> | 
            PATTA : <span class="text-danger"><?=$all_delete_dag->patta_no?> | <?=$this->utilityclass->getPattaType($all_delete_dag->patta_type_code)?></span>
        </div>
    </th>
    <td><strong>Total Land Area in Selected Dag</strong></td>
    <td style="text-align: center;">
        <strong><?=$all_delete_dag->dag_area_b?></strong>
        <input type="hidden" readonly style="text-align: center;" name="dag_area_b" class="form-control input-sm" value="<?=$all_delete_dag->dag_area_b?>" >
    </td>
    <td style="text-align: center;">
        <strong><?=$all_delete_dag->dag_area_k?></strong>
        <input type="hidden" readonly style="text-align: center;" name="dag_area_k" value="<?=$all_delete_dag->dag_area_k?>" class="form-control input-sm" >
    </td>
    <td style="text-align: center;">
        <strong><?=$all_delete_dag->dag_area_lc?></strong>
        <input type="hidden" readonly style="text-align: center;" name="dag_area_lc" class="form-control input-sm" value="<?=$all_delete_dag->dag_area_lc?>" >
    </td>
    <?php if((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
        <td style="text-align: center;">
            <strong><?=$all_delete_dag->dag_area_g?></strong>
            <input type="hidden" readonly style="text-align: center;" value="<?=$all_delete_dag->dag_area_g?>" class="form-control input-sm" name="dag_area_g" >
        </td>
        <td class="hide" style="text-align: center;">
            <strong><?=$all_delete_dag->dag_area_kr?></strong>
            <input type="hidden" readonly style="text-align: center;" value="<?=$all_delete_dag->dag_area_kr?>" class="form-control input-sm" name="dag_area_kr" >
        </td>
    <?php endif ; ?>
</tr>

<?php                            
    $enc_area = json_decode($all_delete_dag->encroachement_area);
    if($enc_area != null) {
?>
<!-- encroacher homestead -->
<tr class="bg-white">
    <td class="enc-area-color"><strong>Encroachment Area (Homestead)</strong></td>
    <td class="enc-area-color" style="text-align: center;">
        <strong><?=$enc_area->homestead->bigha?></strong>
        <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->homestead->bigha?>" readonly>
    </td>
    <td class="enc-area-color" style="text-align: center;">
        <strong><?=$enc_area->homestead->katha?></strong>
        <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->homestead->katha?>" readonly>
    </td>
    <td class="enc-area-color" style="text-align: center;">
        <strong><?=$enc_area->homestead->lessa?></strong>
        <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->homestead->lessa?>" readonly>
    </td>
    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
        <td class="enc-area-color" style="text-align: center;">
            <strong><?=$enc_area->homestead->ganda?></strong>
            <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->homestead->ganda?>" readonly>
        </td>
        <td class="enc-area-color" style="text-align: center;">
            <strong><?=$enc_area->homestead->kranti?></strong>
            <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->homestead->kranti?>" readonly>
        </td>
    <?php endif;?>
</tr>
<!-- encroacher agriculture -->
<tr class="bg-white">
    <td class="enc-area-color"><strong>Encroachment Area (Agriculture)</strong></td>
    <td class="enc-area-color" style="text-align: center;">
        <strong><?=$enc_area->agriculture->bigha?></strong>
        <input type="hidden" style="text-align: center;" name="fbigha" class="form-control input-sm fbigha" value="<?=$enc_area->agriculture->bigha?>" readonly>
    </td>
    <td class="enc-area-color" style="text-align: center;">
        <strong><?=$enc_area->agriculture->katha?></strong>
        <input type="hidden" style="text-align: center;" name="fkatha" class="form-control input-sm fkatha" value="<?=$enc_area->agriculture->katha?>" readonly>
    </td>
    <td class="enc-area-color" style="text-align: center;">
        <strong><?=$enc_area->agriculture->lessa?></strong>
        <input type="hidden" style="text-align: center;" name="flessa" class="form-control input-sm flessa" value="<?=$enc_area->agriculture->lessa?>" readonly>
    </td>
    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
        <td class="enc-area-color" style="text-align: center;">
            <strong><?=$enc_area->agriculture->ganda?></strong>
            <input type="hidden" style="text-align: center;" name="fganda" class="form-control input-sm fganda" value="<?=$enc_area->agriculture->ganda?>" readonly>
        </td>
        <td class="enc-area-color" style="text-align: center;">
            <strong><?=$enc_area->agriculture->kranti?></strong>
            <input type="hidden" style="text-align: center;" name="fkranti" class="form-control input-sm fkranti" value="<?=$enc_area->agriculture->kranti?>" readonly>
        </td>
    <?php endif;?>
</tr>  
<?php } ?>

<!-- area settlement homestead -->
<?php $hide = 'area_show';
    if ($all_delete_dag->land_type == 3 || $all_delete_dag->land_type == 1) {
        $hide = 'area_show';
    } else {
        $hide = 'area_hide';
    }
?>
<tr class='<?=$hide?>' class="bg-white">
    <td class="settlement-area-color"><strong>Area for Settlement (Homestead)</strong></td>
    <td class="settlement-area-color" style="text-align:center">
        <strong><?=$all_delete_dag->home_b?></strong>
        <input type="hidden" style="text-align: center;" name="home_b" class="form-control input-sm home_b" value="<?=$all_delete_dag->home_b?>" readonly>
    </td>
    <td class="settlement-area-color" style="text-align:center">
        <strong><?=$all_delete_dag->home_k?></strong>
        <input type="hidden" style="text-align: center;" name="home_k" value="<?=$all_delete_dag->home_k?>" class="form-control input-sm home_k" readonly>
    </td>
    <td class="settlement-area-color" style="text-align:center">
        <strong><?=$all_delete_dag->home_lc?></strong>
        <input type="hidden" style="text-align: center;" name="home_lc" value="<?=$all_delete_dag->home_lc?>" class="form-control input-sm home_lc" readonly>
    </td>
    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
        <td class="settlement-area-color" style="text-align:center">
            <strong><?=$all_delete_dag->home_g?></strong>
            <input type="hidden" style="text-align: center;" value="<?=$all_delete_dag->home_g?>" class="form-control input-sm s_dag_area_g" name="home_g" readonly>
        </td>
        <td class="settlement-area-color" style="text-align:center">
            <strong><?=$all_delete_dag->home_kr?></strong>
            <input type="hidden" style="text-align: center;" value="<?=$all_delete_dag->home_kr?>" class="form-control input-sm s_dag_area_g" name="home_kr" readonly>
        </td>
    <?php endif; ?>
</tr>

<!-- area settlement agriculture -->
<?php 
    $hide = 'area_show';
    if ($all_delete_dag->land_type == 2) {
        $hide = 'area_show';
    } else {
        $hide = 'area_hide';
    }
?>
<tr class='<?=$hide?>' class="bg-white">
    <td class="settlement-area-color"><strong>Area for Settlement (Agriculture)</strong></td>
    <td class="settlement-area-color" style="text-align:center">
        <strong><?=$all_delete_dag->agri_b?></strong>
        <input type="hidden" style="text-align: center;" name="agri_b" class="form-control input-sm agri_b" value="<?=$all_delete_dag->agri_b?>" readonly>
    </td>
    <td class="settlement-area-color" style="text-align:center">
        <strong><?=$all_delete_dag->agri_k?></strong>
        <input type="hidden" style="text-align: center;" name="agri_k" value="<?=$all_delete_dag->agri_k?>" class="form-control input-sm agri_k" readonly>
    </td>
    <td class="settlement-area-color" style="text-align:center">
        <strong><?=$all_delete_dag->agri_lc?></strong>
        <input type="hidden" style="text-align: center;" name="agri_lc" class="form-control input-sm agri_lc" value="<?=$all_delete_dag->agri_lc?>" readonly>
    </td>
    <?php if ((in_array($this->session->userdata("dist_code"), json_decode(BARAK_VALLEY)))): ?>
        <td class="settlement-area-color" style="text-align:center">
            <strong><?=$all_delete_dag->agri_g?></strong>
            <input type="hidden" style="text-align: center;" value="<?=$all_delete_dag->agri_g?>" class="form-control input-sm agri_g" name="agri_g" readonly>
        </td>
        <td class="settlement-area-color" style="text-align:center">
            <strong><?=$all_delete_dag->agri_kr?></strong>
            <input type="hidden" style="text-align: center;" value="<?=$all_delete_dag->agri_kr?>" class="form-control input-sm agri_kr" name="agri_kr" readonly>
        </td>
    <?php endif;?>
</tr>

<tr class="bg-white">
    <td colspan="6" style="margin-top:2px; border-bottom:1px solid #227576;" class="text-center">
    <div style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; font-size:20px"> 
      This dag was Removed by LM!!!
    </div>
    </td>
</tr>

<?php } ?>
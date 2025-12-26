<?php

  $ast_res  = json_decode($ast_data);
  $sk_res   = json_decode($sk_data);
  $lm_res   = json_decode($lm_data);
  $co_res   = json_decode($co_data);
  $adc_res  = json_decode($adc_data);
  $dc_res   = json_decode($dc_data);
  $bo_res   = json_decode($bo_data);
  $dept_res = json_decode($dept_data);

  // var_dump($dc_res); die;

?>

<?php if($user_desig_code == 'AST'){ ?> <!-- FOR AST -->
  <tr>

    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'LM', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->from_lm_to_ast."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'SK', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->from_sk_to_ast."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'CO', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->from_co_to_ast."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'ADC', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->from_adc_to_ast."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DC', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->from_dc_to_ast."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'BO', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->from_bo_to_ast."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DEPT', 'AST', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->from_dept_to_ast."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'LM'){ ?> <!-- FOR LM -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'CO', 'LM', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->from_co_to_lm."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'ADC', 'LM', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->from_adc_to_lm."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DC', 'LM', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->from_dc_to_lm."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'BO', 'LM', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->from_bo_to_lm."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DEPT', 'LM', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->from_dept_to_lm."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'SK'){ ?> <!-- FOR SK -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'CO', 'SK', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->from_co_to_sk."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'ADC', 'SK', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->from_adc_to_sk."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DC', 'SK', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->from_dc_to_sk."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'BO', 'SK', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->from_bo_to_sk."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DEPT', 'SK', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->from_dept_to_sk."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'CO'){ ?> <!-- FOR CO -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'ADC', 'CO', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->from_adc_to_co."</b>"?></td>

    <td onclick="getRevertedFromPendingDetail('from', 'DC', 'CO', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->from_dc_to_co."</b>"?></td>

    <td class="css">NA</td>

    <td class="css">NA</td>

  </tr>

<?php } if($user_desig_code == 'ADC'){ ?> <!-- FOR ADC -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'DC', 'ADC', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->from_dc_to_adc."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'DEPT', 'ADC', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->from_dept_to_adc."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'DC'){ ?> <!-- FOR DC -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'DEPT', 'DC', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->from_dept_to_dc."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'BO'){ ?> <!-- FOR BO -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'DC', 'BO', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->from_dc_to_bo."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getRevertedFromPendingDetail('from', 'DEPT', 'BO', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->from_dept_to_bo."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'DEPT'){ ?> <!-- FOR DEPT -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>

    <td class="css">NA</td>
  </tr>

<?php } ?>
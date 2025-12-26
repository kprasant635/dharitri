<?php

  $ast_res  = json_decode($ast_data);
  $sk_res   = json_decode($sk_data);
  $lm_res   = json_decode($lm_data);
  $co_res   = json_decode($co_data);
  $adc_res  = json_decode($adc_data);
  $dc_res   = json_decode($dc_data);
  $bo_res   = json_decode($bo_data);
  $dept_res = json_decode($dept_data);

?>

<?php if($user_desig_code == 'AST'){ ?> <!-- FOR AST -->
  <tr>

    <td>Click on numbers to view cases</td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('AST', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('AST', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('AST', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_co."</b>"?></td>

    <td onclick="getPendingDetail('AST', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('AST', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('AST', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('AST', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'LM'){ ?> <!-- FOR LM -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('LM', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_ast."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('LM', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_co."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'SK'){ ?> <!-- FOR SK -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('SK', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('SK', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_lm."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('SK', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_co."</b>"?></td>

    <td onclick="getPendingDetail('SK', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('SK', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('SK', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('SK', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'CO'){ ?> <!-- FOR CO -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('CO', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_lm."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('CO', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'ADC'){ ?> <!-- FOR ADC -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('ADC', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_co."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('ADC', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'DC'){ ?> <!-- FOR DC -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('DC', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_co."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_adc."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('DC', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'BO'){ ?> <!-- FOR BO -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('BO', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_co."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_dc."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('BO', 'DEPT', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_dept."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'DEPT'){ ?> <!-- FOR DEPT -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('DEPT', 'AST', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'SK', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'LM', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'CO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_co."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'ADC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'DC', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'BO', 'to', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_bo."</b>"?></td>

    <td class="css">NA</td>
  </tr>

<?php } ?>
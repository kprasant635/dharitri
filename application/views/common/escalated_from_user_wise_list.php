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

    <td onclick="getPendingDetail('LM', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_ast."</b>"?></td>    

    <td onclick="getPendingDetail('SK', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_ast."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'AST', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_ast."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'LM'){ ?> <!-- FOR LM -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_lm."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('SK', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_lm."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'LM', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_lm."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'SK'){ ?> <!-- FOR SK -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_sk."</b>"?></td> 

    <td class="css">NA</td>

    <td onclick="getPendingDetail('CO', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_sk."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'SK', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_sk."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'CO'){ ?> <!-- FOR CO -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_co."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_co."</b>"?></td> 

    <td onclick="getPendingDetail('SK', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_co."</b>"?></td>

    <td class="css">NA</td>    

    <td onclick="getPendingDetail('ADC', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_co."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_co."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_co."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'CO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_co."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'ADC'){ ?> <!-- FOR ADC -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_adc."</b>"?></td> 

    <td onclick="getPendingDetail('SK', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_adc."</b>"?></td>

    <td class="css">NA</td>        

    <td onclick="getPendingDetail('DC', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_adc."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'ADC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_adc."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'DC'){ ?> <!-- FOR DC -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_dc."</b>"?></td> 

    <td onclick="getPendingDetail('SK', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_dc."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('BO', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_dc."</b>"?></td>

    <td onclick="getPendingDetail('DEPT', 'DC', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_dc."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'BO'){ ?> <!-- FOR BO -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_bo."</b>"?></td> 

    <td onclick="getPendingDetail('SK', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_bo."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_bo."</b>"?></td>

    <td class="css">NA</td>

    <td onclick="getPendingDetail('DEPT', 'BO', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dept_res->dept_to_bo."</b>"?></td>
  </tr>

<?php } if($user_desig_code == 'DEPT'){ ?> <!-- FOR DEPT -->

  <tr>
    <td>Click on numbers to view cases</td>

    <td onclick="getPendingDetail('AST', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$ast_res->ast_to_dept."</b>"?></td>

    <td onclick="getPendingDetail('LM', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$lm_res->lm_to_dept."</b>"?></td> 

    <td onclick="getPendingDetail('SK', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$sk_res->sk_to_dept."</b>"?></td>

    <td onclick="getPendingDetail('CO', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$co_res->co_to_dept."</b>"?></td>

    <td onclick="getPendingDetail('ADC', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$adc_res->adc_to_dept."</b>"?></td>

    <td onclick="getPendingDetail('DC', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$dc_res->dc_to_dept."</b>"?></td>

    <td onclick="getPendingDetail('BO', 'DEPT', 'from', '<?=$service_type?>')" class="css"><?="<b style='color:red'>".$bo_res->bo_to_dept."</b>"?></td>

    <td class="css">NA</td>

  </tr>

<?php } ?>
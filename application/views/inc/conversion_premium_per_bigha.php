<?php 
    if($lm_details['premium_new_yn'] == 0 || $lm_details['premium_new_yn'] == null) {
        if ((($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'o')) || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm')) || (($lm_details['dist_frm_town'] == '0') && ($lm_details['inside_outside_town'] == 'r')) || ($lm_details['dist_frm_town'] == '3') || (($lm_details['dist_frm_town'] == '5') && ($lm_details['inside_outside_town'] == 'm'))) {
            if (trim($lm_details['premium_assesment']) == '40' || trim($lm_details['premium_assesment']) == '20') {
                $bigha_prem=$lm_details['premium_assesment'];
            }else {
            $bigha_prem = $lm_details['prim_per_bigha'];
            }
        }else{
            $bigha_prem = $lm_details['prim_per_bigha'];
        }
    }
    else if ($lm_details['premium_new_yn'] == 1) {
        $bigha_prem = $lm_details['prim_per_bigha'];
    }
    
?>
  
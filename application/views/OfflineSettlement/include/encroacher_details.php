
<div class="tableCard">
    <table class="table table-bordered">
        <?php
        $enc_count = 1;
        $llc = 0;
        foreach($applicants_encroacher as $riotee){
            ?>
            <tr>
                <th rowspan="2" style="vertical-align : middle;text-align:center;"><?=$enc_count++;?></th>
                <th>Dag No</th>
                <td colspan="2">
                    <input readonly type="text" name="enc_dag<?=$riotee->id?>" value="<?=$riotee->dag_no;?>" class="form-control input-sm encroacher_dag" >

                </td>

                <th>Name</th>
                <td colspan="2">
                    <input type="hidden" id="enc_id<?=$riotee->id?>" name="enc_id<?=$riotee->id?>" value="<?php
                    if($settlement_land_bank_details[$llc] != false)
                    {
                        echo $riotee->enc_id;
                    }
                    else
                    {
                        echo $riotee->enc_id=='-1' ? '' : $riotee->enc_id;
                    }
                    ?>">

                    <input type="text" readonly id="enc_name<?=$riotee->id?>" name="riotee_name<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_name'.$riotee->id);}else{
                        if($settlement_land_bank_details[$llc] != false)
                        {
                            echo $riotee->pdar_name;
                        }
                        else
                        {
                            echo $riotee->enc_id=='-1' || $riotee->enc_id=='' ? '' :$riotee->pdar_name;
                        }}?>"
                           class="form-control input-sm <?php if(form_error('riotee_name'.$riotee->id)){echo 'is-invalid';}?>">

                    <?=form_error('riotee_name'.$riotee->id)?>
                </td>

                <?php if (in_array($this->session->userdata('user_desig_code'), OFFLINE_SETTLEMENT_EDIT_OPTION_ACCESS)): ?>
                    <?php if(NC_ENABLE_BUTTON_CHANGE_ENCROACHER == 1){?>

                        <td rowspan="2" style="vertical-align : middle;">
                            <?php

                            // if($riotee->enc_id=='-1'):
                            if(isset($settlement_vlb_encroacher_check)):
                                if (in_array($riotee->dag_no, $settlement_vlb_encroacher_check))
                                {
                                    foreach($land_bank_status as $land_bank_stats):
                                        if($land_bank_stats != false):

                                            if($land_bank_stats->dag_no == $riotee->dag_no)
                                            {
                                                if(trim($land_bank_stats->status) == 'A'){
                                                    ?>
                                                    <span class="alert-success enc-already-added-span">Encroacher already added for this dag no...</span>
                                                    <br>
                                                    <span class="alert-success"><strong>Status : Approved</strong></span>
                                                    <br>
                                                    <br>

                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <span class="alert-danger">Encroacher added.</span>
                                                    <br>
                                                    <span class="alert-danger"><strong>Status : Pending</strong></span>
                                                    <br>
                                                    <?php

                                                    if(isset($settlement_land_bank_details))
                                                    {
                                                        foreach($settlement_land_bank_details as $bank)
                                                        {
                                                            if($bank != false)
                                                            {
                                                                if($bank->dag_no == $riotee->dag_no)
                                                                {
                                                                    ?>
                                                                    <button id="edit_encroacher_button" type="button" onclick="editEncroacher(<?=$riotee->dag_no?>,<?=$riotee->id?>, <?=$bank->encroacher_id?>,<?=$bank->land_bank_details_id?>);" class="btn btn-warning btn-sm">Edit Occupier</button>
                                                                    <br>
                                                                    <?php
                                                                }
                                                            }
                                                        }

                                                    }
                                                }
                                            }
                                        endif;
                                    endforeach;
                                }
                                else
                                {
                                    ?>
                                    <br>
                                    <button type="button" onclick="addEncroacher('<?=$riotee->dag_no;?>',<?=$riotee->id?>);" class="btn btn-sm btn-danger add_encroacher_button">Add Occupier</button>
                                    <br>
                                    <?php
                                }
                            endif;
                            // endif;


                            ?>

                            <button type="button" class="mt-1 btn btn-sm btn-primary"
                                    onclick="encroacherModal('<?=$riotee->dag_no;?>',<?=$riotee->id?>);" id="<?=$riotee->dag_no;?>">
                                VLB List
                            </button>

                        </td>
                    <?php } ?>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Father's Name</th>
                <td colspan="2">
                    <input readonly type="text" id="enc_gur_name<?=$riotee->id?>" name="riotee_guardian<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('riotee_guardian'.$riotee->id);}else{
                        if($settlement_land_bank_details[$llc] != false)
                        {
                            echo $riotee->pdar_guardian;
                        }
                        else
                        {
                            echo $riotee->enc_id=='-1' || $riotee->enc_id=='' ? '' : $riotee->pdar_guardian;
                        }}?>"
                           class="form-control input-sm" >

                </td>

                <th>Possession From</th>
                <td colspan="2">
                    <input readonly type="text" id="enc_period_possession<?=$riotee->id?>" name="period_possession<?=$riotee->id?>" value="<?php if(isset($err_return)){ echo set_value('period_possession'.$riotee->id);}else{
                        if($settlement_land_bank_details[$llc] != false)
                        {
                            echo $riotee->period_possession;
                        }
                        else
                        {
                            echo $riotee->enc_id=='-1' || $riotee->enc_id=='' ? '' : $riotee->period_possession;
                        }
                    }?>"  class="possesiondate form-control">

                </td>

            </tr>

            <?php $llc++; ?>
        <?php } ?>

        <?php if (in_array($this->session->userdata('user_desig_code'), OFFLINE_SETTLEMENT_EDIT_OPTION_ACCESS)): ?>

            <?php include(APPPATH."views/SettlementView/include/encroacherNotEligibleView.php"); ?>

        <?php endif; ?>
    </table>
</div>

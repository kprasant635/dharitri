<?php
                                 
                                
    foreach ($deleted_encroacher as $all_deleted_encroacher) {
        ?>
        <tr>
            <th rowspan="3" style="vertical-align : middle;text-align:center; background-color: #f44336;"><?=$enc_count++;?></th>
            <th>Dag No</th>
            <td >
                <?=$all_deleted_encroacher->dag_no;?>
            </td>

            <th>Name</th>
            <td >
                <?=$all_deleted_encroacher->pdar_name;?>"
            </td>
        </tr>
        <tr>
            <th>Father's Name</th>
            <td>
                <?=$all_deleted_encroacher->pdar_guardian;?>

            </td>

            <th>Possession From</th>
            <td>
                <?=$all_deleted_encroacher->period_possession;?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="text-center" style="padding: 10px; margin-top:5px; background-color: #f44336; color: white; font-weight:bold; font-size:20px">
                This Occupier was deleted by LM !!!
            </td>
        </tr>
    <?php }?>
<?php
                                 
                                
    foreach ($deleted_encroacher as $all_deleted_encroacher) {
        ?>
        <tr class="bg-warning">
            <th rowspan="2" style="vertical-align : middle;text-align:center;"><?=$enc_count++;?></th>
            <th>Dag No</th>
            <td colspan="2">
                <input readonly type="text" value="<?=$all_deleted_encroacher->dag_no;?>" class="form-control input-sm encroacher_dag" >

            </td>

            <th>Name</th>
            <td colspan="2">
                <input type="text" readonly value="<?=$all_deleted_encroacher->pdar_name;?>" class="form-control input-sm">
            </td>

            <td rowspan="2" style="vertical-align : middle;">
                <strong class="alert-danger">Deleted Occupier</strong>
            </td>
        </tr>
        <tr class="bg-warning">
            <th>Father's Name</th>
            <td colspan="2">
                <input readonly type="text" value="<?=$all_deleted_encroacher->pdar_guardian;?>" class="form-control input-sm encroacher_dag" >

            </td>

            <th>Possession From</th>
            <td colspan="2">
                <input type="text" readonly value="<?=$all_deleted_encroacher->period_possession;?>" class="form-control input-sm">
            </td>
        </tr>
    <?php }?>